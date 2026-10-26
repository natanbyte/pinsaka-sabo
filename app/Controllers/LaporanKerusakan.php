<?php

namespace App\Controllers;

use App\Models\FotoLaporanModel;
use App\Models\LaporanKerusakanModel;
use App\Models\LokasiSarprasModel;
use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\Files\File;

class LaporanKerusakan extends BaseController
{
    private const MAX_FOTO   = 5;
    private const MAX_UKURAN = 5 * 1024 * 1024; // 5MB per foto
    private const MIME_BOLEH = ['image/jpeg', 'image/png', 'image/webp'];

    /** Riwayat laporan: pegawai melihat miliknya, admin melihat semua. */
    public function index(): string
    {
        $isAdmin = session()->get('role') === 'admin';

        $status = $this->request->getGet('status');
        if (! in_array($status, ['baru', 'diproses', 'selesai'], true)) {
            $status = null;
        }

        $kategori = $this->request->getGet('kategori');
        if (! in_array($kategori, ['sarpras', 'kendaraan'], true)) {
            $kategori = null;
        }

        $userId         = $isAdmin ? null : (int) session()->get('user_id');
        $laporanModel   = new LaporanKerusakanModel();
        $laporan        = $laporanModel->daftar($userId, $status, $kategori);
        $hitungKategori = $laporanModel->hitungPerKategori($userId);
        $hitungStatus   = $laporanModel->hitungPerStatus($userId, $kategori);

        return view('laporan/index', [
            'title'          => 'Register Laporan Kerusakan',
            'laporan'        => $laporan,
            'isAdmin'        => $isAdmin,
            'statusAktif'    => $status,
            'kategoriAktif'  => $kategori,
            'hitungKategori' => $hitungKategori,
            'hitungStatus'   => $hitungStatus,
        ]);
    }

    /** Form lapor kerusakan sarpras dan kendaraan dinas. */
    public function create(): string
    {
        $kategori = $this->request->getGet('kategori');
        if (! in_array($kategori, ['sarpras', 'kendaraan'], true)) {
            $kategori = 'sarpras';
        }

        $lokasiModel = new LokasiSarprasModel();
        $lokasi      = $lokasiModel->orderBy('nama_lokasi', 'ASC')->findAll();

        return view('laporan/create', [
            'title'             => 'Buat Laporan Kerusakan',
            'lokasi'            => $lokasi,
            'kendaraan'         => $this->daftarKendaraan(),
            'komponenKendaraan' => $this->daftarKomponenKendaraan(),
            'kategoriAktif'     => $kategori,
        ]);
    }

    /** Simpan laporan + foto ke database MySQL dan berkas ke WRITEPATH. */
    public function store()
    {
        $kategoriLaporan = $this->request->getPost('kategori_laporan') === 'kendaraan' ? 'kendaraan' : 'sarpras';

        $rules = [
            'kategori_laporan' => [
                'label'  => 'Kategori laporan',
                'rules'  => 'required|in_list[sarpras,kendaraan]',
                'errors' => [
                    'required' => 'Kategori laporan wajib dipilih.',
                    'in_list'  => 'Kategori laporan tidak valid.',
                ],
            ],
            'jenis_kerusakan' => [
                'label'  => 'Jenis kerusakan',
                'rules'  => 'required|in_list[ringan,sedang,berat]',
                'errors' => [
                    'required' => 'Jenis kerusakan wajib dipilih.',
                    'in_list'  => 'Jenis kerusakan tidak valid.',
                ],
            ],
            'deskripsi' => [
                'label'  => 'Deskripsi kerusakan',
                'rules'  => 'required|min_length[10]|max_length[2000]',
                'errors' => [
                    'required'   => 'Deskripsi kerusakan wajib diisi.',
                    'min_length' => 'Deskripsi kerusakan minimal 10 karakter.',
                    'max_length' => 'Deskripsi kerusakan maksimal 2000 karakter.',
                ],
            ],
        ];

        if ($kategoriLaporan === 'kendaraan') {
            $rules['nama_kendaraan'] = [
                'label'  => 'Nama kendaraan',
                'rules'  => 'required|min_length[3]|max_length[150]',
                'errors' => [
                    'required'   => 'Nama / jenis kendaraan dinas wajib dipilih atau diisi.',
                    'min_length' => 'Nama kendaraan minimal 3 karakter.',
                    'max_length' => 'Nama kendaraan maksimal 150 karakter.',
                ],
            ];
            $rules['nomor_polisi'] = [
                'label'  => 'Nomor polisi',
                'rules'  => 'required|min_length[3]|max_length[20]',
                'errors' => [
                    'required'   => 'Nomor polisi / plat kendaraan wajib diisi.',
                    'min_length' => 'Nomor polisi minimal 3 karakter.',
                    'max_length' => 'Nomor polisi maksimal 20 karakter.',
                ],
            ];
            $rules['bagian_kendaraan'] = [
                'label'  => 'Bagian kendaraan yang rusak',
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Bagian / komponen kendaraan yang rusak wajib dipilih.',
                ],
            ];
        } else {
            $rules['lokasi_id'] = [
                'label'  => 'Lokasi sarpras',
                'rules'  => 'required|is_natural_no_zero',
                'errors' => [
                    'required'           => 'Lokasi sarpras wajib dipilih.',
                    'is_natural_no_zero' => 'Lokasi sarpras tidak valid.',
                ],
            ];
        }

        $errors = [];
        if (! $this->validate($rules)) {
            $errors = array_values($this->validator->getErrors());
        }

        // Foto divalidasi manual supaya pesan errornya jelas per foto.
        $files = $this->request->getFileMultiple('foto') ?? [];
        $files = array_values(array_filter(
            $files,
            static fn ($f) => $f->getError() !== UPLOAD_ERR_NO_FILE
        ));
        $errors = array_merge($errors, $this->periksaFoto($files));

        if ($errors !== []) {
            return redirect()->to('/laporan/buat' . ($kategoriLaporan === 'kendaraan' ? '?kategori=kendaraan' : ''))
                ->withInput()
                ->with('errors', $errors);
        }

        $dir = WRITEPATH . 'uploads/laporan/';
        if (! is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        $kode      = 'LK-' . date('ymd') . '-' . strtoupper(bin2hex(random_bytes(3)));
        $tersimpan = [];

        foreach ($files as $file) {
            $nama = $file->getRandomName();
            $file->move($dir, $nama);
            $tersimpan[] = $nama;
        }

        $userId = session()->get('user_id') ? (int) session()->get('user_id') : 2;

        $payload = [
            'kode_laporan'     => $kode,
            'user_id'          => $userId,
            'kategori_laporan' => $kategoriLaporan,
            'jenis_kerusakan'  => (string) $this->request->getPost('jenis_kerusakan'),
            'deskripsi'        => trim((string) $this->request->getPost('deskripsi')),
            'status'           => 'baru',
        ];

        if ($kategoriLaporan === 'kendaraan') {
            $payload['kendaraan_id']     = $this->request->getPost('kendaraan_id') ? (int) $this->request->getPost('kendaraan_id') : null;
            $payload['nama_kendaraan']   = trim((string) $this->request->getPost('nama_kendaraan'));
            $payload['nomor_polisi']     = strtoupper(trim((string) $this->request->getPost('nomor_polisi')));
            $payload['odometer']         = trim((string) $this->request->getPost('odometer')) ?: null;
            $payload['bagian_kendaraan'] = trim((string) $this->request->getPost('bagian_kendaraan'));
            $payload['lokasi_kejadian']  = trim((string) $this->request->getPost('lokasi_kejadian')) ?: null;
            $payload['lokasi_id']        = null;
        } else {
            $payload['lokasi_id']        = (int) $this->request->getPost('lokasi_id');
        }

        $laporanModel = new LaporanKerusakanModel();
        $laporanId    = $laporanModel->insert($payload);

        if (! empty($tersimpan)) {
            $fotoModel = new FotoLaporanModel();
            foreach ($tersimpan as $namaFile) {
                $fotoModel->insert([
                    'laporan_id' => $laporanId,
                    'nama_file'  => $namaFile,
                    'jenis'      => 'awal',
                ]);
            }
        }

        $pesanTipe = $kategoriLaporan === 'kendaraan' ? 'Laporan kerusakan kendaraan dinas' : 'Laporan kerusakan sarana prasarana';
        return redirect()->to('/laporan/' . $laporanId)
            ->with('success', $pesanTipe . ' berhasil dikirim. Kode laporan: ' . $kode);
    }

    /** Detail satu laporan. */
    public function show($id)
    {
        $laporanModel = new LaporanKerusakanModel();
        $laporan      = $laporanModel->detail((int) $id);

        if (! $laporan || ! $this->bolehAkses($laporan)) {
            throw PageNotFoundException::forPageNotFound();
        }

        $fotoModel     = new FotoLaporanModel();
        $foto          = $fotoModel->where('laporan_id', (int) $id)->where('jenis', 'awal')->findAll();
        $fotoPerbaikan = $fotoModel->where('laporan_id', (int) $id)->where('jenis', 'perbaikan')->findAll();

        return view('laporan/show', [
            'title'         => 'Detail Laporan ' . $laporan['kode_laporan'],
            'laporan'       => $laporan,
            'foto'          => $foto,
            'fotoPerbaikan' => $fotoPerbaikan,
        ]);
    }

    /** Admin: ubah status laporan, beri catatan, dan lampirkan bukti foto perbaikan. */
    public function updateStatus($id)
    {
        if (session()->get('role') !== 'admin') {
            throw PageNotFoundException::forPageNotFound();
        }

        $laporanModel = new LaporanKerusakanModel();
        $laporan      = $laporanModel->find((int) $id);

        if (! $laporan) {
            throw PageNotFoundException::forPageNotFound();
        }

        $rules = [
            'status' => [
                'label'  => 'Status',
                'rules'  => 'required|in_list[baru,diproses,selesai]',
                'errors' => [
                    'required' => 'Status wajib dipilih.',
                    'in_list'  => 'Status tidak valid.',
                ],
            ],
            'catatan_admin' => [
                'label'  => 'Catatan',
                'rules'  => 'permit_empty|max_length[1000]',
                'errors' => ['max_length' => 'Catatan maksimal 1000 karakter.'],
            ],
        ];

        if (! $this->validate($rules)) {
            return redirect()->to('/laporan/' . (int) $id)
                ->with('error', implode(' ', array_values($this->validator->getErrors())));
        }

        $catatan = trim((string) $this->request->getPost('catatan_admin'));

        // Unggah bukti foto perbaikan dari admin
        $files = $this->request->getFileMultiple('foto_perbaikan') ?? [];
        $files = array_values(array_filter(
            $files,
            static fn ($f) => $f->getError() !== UPLOAD_ERR_NO_FILE
        ));

        $fotoErrors = $this->periksaFoto($files);
        if ($fotoErrors !== []) {
            return redirect()->to('/laporan/' . (int) $id)
                ->with('error', implode(' ', $fotoErrors));
        }

        $dir = WRITEPATH . 'uploads/laporan/';
        if (! is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        $tersimpanPerbaikan = [];
        foreach ($files as $file) {
            $nama = $file->getRandomName();
            $file->move($dir, $nama);
            $tersimpanPerbaikan[] = $nama;
        }

        $laporanModel->update((int) $id, [
            'status'        => (string) $this->request->getPost('status'),
            'catatan_admin' => $catatan === '' ? null : $catatan,
        ]);

        if (! empty($tersimpanPerbaikan)) {
            $fotoModel = new FotoLaporanModel();
            foreach ($tersimpanPerbaikan as $namaFile) {
                $fotoModel->insert([
                    'laporan_id' => (int) $id,
                    'nama_file'  => $namaFile,
                    'jenis'      => 'perbaikan',
                ]);
            }
        }

        $pesan = 'Status laporan berhasil diperbarui.';
        if (! empty($tersimpanPerbaikan)) {
            $pesan .= ' ' . count($tersimpanPerbaikan) . ' bukti foto perbaikan berhasil diunggah untuk pelapor.';
        }

        return redirect()->to('/laporan/' . (int) $id)->with('success', $pesan);
    }

    /** Menampilkan file foto (baik foto kerusakan awal maupun bukti perbaikan). */
    public function foto($id)
    {
        $fotoModel  = new FotoLaporanModel();
        $targetFoto = $fotoModel->find((int) $id);

        if (! $targetFoto) {
            throw PageNotFoundException::forPageNotFound();
        }

        $laporanModel  = new LaporanKerusakanModel();
        $targetLaporan = $laporanModel->find((int) $targetFoto['laporan_id']);

        if (! $targetLaporan || ! $this->bolehAkses($targetLaporan)) {
            throw PageNotFoundException::forPageNotFound();
        }

        $isPerbaikan = ($targetFoto['jenis'] ?? 'awal') === 'perbaikan';

        $path = WRITEPATH . 'uploads/laporan/' . basename($targetFoto['nama_file']);
        if (is_file($path)) {
            $file = new File($path);

            return $this->response
                ->setHeader('Cache-Control', 'private, max-age=86400')
                ->setContentType($file->getMimeType())
                ->setBody(file_get_contents($path));
        }

        // Placeholder SVG informatif untuk foto jika berkas fisik tidak ada di disk
        $namaFile    = htmlspecialchars($targetFoto['nama_file'], ENT_QUOTES, 'UTF-8');
        $judulSvg    = $isPerbaikan ? 'Bukti Foto Hasil Perbaikan (Admin)' : 'Dokumentasi Foto Fisik Kerusakan (Pelapor)';
        $temaWarna   = $isPerbaikan ? '#059669' : '#1e40af';
        $bgLingkaran = $isPerbaikan ? 'rgba(16, 185, 129, 0.15)' : 'rgba(59, 130, 246, 0.15)';

        $svg = '<svg xmlns="http://www.w3.org/2000/svg" width="600" height="400" viewBox="0 0 600 400">
            <rect width="100%" height="100%" fill="#f8fafc"/>
            <rect x="20" y="20" width="560" height="360" rx="8" fill="#f1f5f9" stroke="#cbd5e1" stroke-width="2" stroke-dasharray="6,6"/>
            <circle cx="300" cy="165" r="40" fill="' . $bgLingkaran . '"/>
            <path d="M280 155 L300 135 L320 155 L310 155 L310 190 L290 190 L290 155 Z" fill="' . $temaWarna . '"/>
            <text x="300" y="235" font-family="system-ui, -apple-system, sans-serif" font-size="16" font-weight="bold" fill="#1e293b" text-anchor="middle">' . $judulSvg . '</text>
            <text x="300" y="260" font-family="system-ui, -apple-system, sans-serif" font-size="12" fill="#64748b" text-anchor="middle">Lampiran: ' . $namaFile . '</text>
            <text x="300" y="285" font-family="system-ui, -apple-system, sans-serif" font-size="11" fill="#94a3b8" text-anchor="middle">Foto tersimpan di database dan dapat diakses oleh pelapor &amp; admin.</text>
        </svg>';

        return $this->response
            ->setHeader('Content-Type', 'image/svg+xml')
            ->setBody($svg);
    }

    private function bolehAkses(array $laporan): bool
    {
        return session()->get('role') === 'admin'
            || (int) $laporan['user_id'] === (int) session()->get('user_id');
    }

    /**
     * @param list<\CodeIgniter\HTTP\Files\UploadedFile> $files
     *
     * @return list<string>
     */
    private function periksaFoto(array $files): array
    {
        if (count($files) < 1) {
            return []; // Foto opsional
        }

        $errors = [];

        if (count($files) > self::MAX_FOTO) {
            $errors[] = 'Maksimal ' . self::MAX_FOTO . ' foto per laporan.';
        }

        foreach ($files as $i => $file) {
            $no = $i + 1;

            if (! $file->isValid()) {
                $errors[] = "Foto ke-{$no} gagal diunggah (kemungkinan ukurannya terlalu besar).";
                continue;
            }

            if ($file->getSize() > self::MAX_UKURAN) {
                $errors[] = "Foto ke-{$no} melebihi 5MB.";
                continue;
            }

            $mimeOk   = in_array($file->getMimeType(), self::MIME_BOLEH, true);
            $gambarOk = @getimagesize($file->getTempName()) !== false;

            if (! $mimeOk || ! $gambarOk) {
                $errors[] = "Foto ke-{$no} harus berupa gambar JPG, PNG, atau WEBP.";
            }
        }

        return $errors;
    }

    /** Daftar kendaraan dinas referensi Balai Sabo */
    private function daftarKendaraan(): array
    {
        return [
            [
                'id'    => 1,
                'nama'  => 'Toyota Hilux Double Cabin 4x4 Lapangan',
                'nopol' => 'AB 1042 BS',
                'tipe'  => 'Truk Lapangan & Survei Sabo',
                'unit'  => 'Seksi Pengendalian & Pengawasan Lapangan',
            ],
            [
                'id'    => 2,
                'nama'  => 'Toyota Fortuner 2.8 4x4 Inspeksi',
                'nopol' => 'AB 8201 XS',
                'tipe'  => 'SUV Kedinasan & Inspeksi Wilayah',
                'unit'  => 'Pimpinan / PPK Balai Sabo',
            ],
            [
                'id'    => 3,
                'nama'  => 'Isuzu D-Max Double Cabin Operasional',
                'nopol' => 'AB 1904 BT',
                'tipe'  => 'Mobil Operasional Angkut Sampel',
                'unit'  => 'Laboratorium Hidraulika & Mekanika Tanah',
            ],
            [
                'id'    => 4,
                'nama'  => 'Toyota Avanza 1.5 G Kedinasan',
                'nopol' => 'AB 1540 BS',
                'tipe'  => 'Mobil Dinas Operasional Kantor',
                'unit'  => 'Subbagian Tata Usaha & Protokoler',
            ],
            [
                'id'    => 5,
                'nama'  => 'Daihatsu Gran Max Blind Van Logistik',
                'nopol' => 'AB 9081 BS',
                'tipe'  => 'Mobil Angkutan Peralatan & Logistik',
                'unit'  => 'Pengelola BMN & Gudang Sarpras',
            ],
        ];
    }

    /** Komponen kerusakan umum kendaraan */
    private function daftarKomponenKendaraan(): array
    {
        return [
            'Sistem Rem, Suspensi & Kaki-kaki',
            'Mesin & Sistem Transmisi',
            'AC, Pendingin Kabin & Radiator',
            'Kelistrikan, Aki & Lampu Penerangan',
            'Ban, Roda, Pelek & Baut Roda',
            'Bodi, Kaca, Wiper & Spion',
            'Sistem Kemudi (Power Steering)',
            'Sistem Bahan Bakar & Tangki',
            'Lainnya',
        ];
    }
}
