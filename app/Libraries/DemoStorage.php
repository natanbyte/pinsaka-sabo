<?php

namespace App\Libraries;

class DemoStorage
{
    private const SESSION_KEY = 'demo_pinsaka_reports';
    private const SESSION_ID_COUNTER = 'demo_pinsaka_counter';

    private static function getStorageFile(): string
    {
        return WRITEPATH . 'demo_pinsaka_storage.json';
    }

    public static function loadReports(): array
    {
        $filePath = self::getStorageFile();
        if (file_exists($filePath)) {
            $raw = @file_get_contents($filePath);
            if ($raw !== false && $raw !== '') {
                $data = json_decode($raw, true);
                if (is_array($data) && isset($data['reports']) && is_array($data['reports'])) {
                    return $data;
                }
            }
        }

        $session = session();
        if ($session->has(self::SESSION_KEY)) {
            return [
                'counter' => (int) ($session->get(self::SESSION_ID_COUNTER) ?? 5),
                'reports' => $session->get(self::SESSION_KEY) ?? [],
            ];
        }

        return ['counter' => 0, 'reports' => []];
    }

    public static function saveReports(array $reports, int $counter): void
    {
        $filePath = self::getStorageFile();
        $payload = [
            'counter' => $counter,
            'reports' => $reports,
        ];
        @file_put_contents($filePath, json_encode($payload, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

        $session = session();
        $session->set(self::SESSION_KEY, $reports);
        $session->set(self::SESSION_ID_COUNTER, $counter);
    }

    /**
     * Inisialisasi data awal contoh jika belum ada.
     */
    public static function init(): void
    {
        $storage = self::loadReports();
        if (! empty($storage['reports'])) {
            $reports = $storage['reports'];
            $adaKendaraan = false;
            foreach ($reports as &$r) {
                if (! isset($r['kategori_laporan'])) {
                    $r['kategori_laporan'] = 'sarpras';
                }
                if (($r['kategori_laporan'] ?? '') === 'kendaraan') {
                    $adaKendaraan = true;
                }
                if (! isset($r['foto_perbaikan'])) {
                    $r['foto_perbaikan'] = [];
                }
            }
            unset($r);

            if (! $adaKendaraan) {
                $reports[] = [
                    'id'               => 4,
                    'kode_laporan'     => 'LK-261024-004V',
                    'user_id'          => 2,
                    'nama_lengkap'     => 'Budi Santoso, S.T. (Pegawai)',
                    'nip'              => '199001012020011001',
                    'no_hp'            => '081200000002',
                    'email'            => 'pegawai@pinsaka.test',
                    'bagian_id'        => 2,
                    'nama_bagian'      => 'Program dan Evaluasi',
                    'kategori_laporan' => 'kendaraan',
                    'kendaraan_id'     => 1,
                    'nama_kendaraan'   => 'Toyota Hilux Double Cabin 4x4 Lapangan',
                    'nomor_polisi'     => 'AB 1042 BS',
                    'odometer'         => '68.450 km',
                    'bagian_kendaraan' => 'Sistem Rem, Suspensi & Kaki-kaki',
                    'lokasi_kejadian'  => 'Jalur Survei Sabo Dam Kali Krasak',
                    'lokasi_id'        => 5,
                    'nama_lokasi'      => 'Toyota Hilux Double Cabin 4x4 (AB 1042 BS)',
                    'jenis_kerusakan'  => 'sedang',
                    'deskripsi'        => 'Pedal rem bergetar dan timbul bunyi gesekan besi saat pengereman di turunan curam menuju dasar sabo dam. Suspensi belakang kiri terasa sangat keras saat melintasi jalan inspeksi berbatu.',
                    'status'           => 'diproses',
                    'catatan_admin'    => 'Surat pengantar dinas telah diterbitkan. Kendaraan dijadwalkan masuk bengkel resmi rekanan pada Senin pagi jam 08.30 WIB untuk penggantian kampas rem dan peredam kejut.',
                    'created_at'       => date('Y-m-d H:i:s', strtotime('-1 days')),
                    'foto'             => [
                        [
                            'id'         => 4,
                            'laporan_id' => 4,
                            'nama_file'  => 'demo_rem_hilux.jpg',
                        ],
                    ],
                ];

                $reports[] = [
                    'id'               => 5,
                    'kode_laporan'     => 'LK-261025-005V',
                    'user_id'          => 2,
                    'nama_lengkap'     => 'Budi Santoso, S.T. (Pegawai)',
                    'nip'              => '199001012020011001',
                    'no_hp'            => '081200000002',
                    'email'            => 'pegawai@pinsaka.test',
                    'bagian_id'        => 2,
                    'nama_bagian'      => 'Program dan Evaluasi',
                    'kategori_laporan' => 'kendaraan',
                    'kendaraan_id'     => 2,
                    'nama_kendaraan'   => 'Toyota Fortuner 2.8 4x4 Inspeksi',
                    'nomor_polisi'     => 'AB 8201 XS',
                    'odometer'         => '42.120 km',
                    'bagian_kendaraan' => 'AC, Pendingin Kabin & Radiator',
                    'lokasi_kejadian'  => 'Garasi Kendaraan Dinas Balai Sabo',
                    'lokasi_id'        => 5,
                    'nama_lokasi'      => 'Toyota Fortuner 2.8 4x4 Inspeksi (AB 8201 XS)',
                    'jenis_kerusakan'  => 'ringan',
                    'deskripsi'        => 'Hembusan AC kabin depan tidak dingin ketika mobil diparkir atau beroperasi pada siang hari yang terik. Udara hanya berhembus seperti kipas angin biasa.',
                    'status'           => 'baru',
                    'catatan_admin'    => null,
                    'created_at'       => date('Y-m-d H:i:s'),
                    'foto'             => [],
                ];

                self::saveReports($reports, max((int) ($storage['counter'] ?? 3), 5));
            } else {
                session()->set(self::SESSION_KEY, $reports);
                session()->set(self::SESSION_ID_COUNTER, (int) ($storage['counter'] ?? 5));
            }
            return;
        }

        $initialReports = [
            [
                'id'               => 1,
                'kode_laporan'     => 'LK-261020-001A',
                'user_id'          => 2,
                'nama_lengkap'     => 'Budi Santoso, S.T. (Pegawai)',
                'nip'              => '199001012020011001',
                'no_hp'            => '081200000002',
                'email'            => 'pegawai@pinsaka.test',
                'bagian_id'        => 2,
                'nama_bagian'      => 'Program dan Evaluasi',
                'kategori_laporan' => 'sarpras',
                'kendaraan_id'     => null,
                'nama_kendaraan'   => null,
                'nomor_polisi'     => null,
                'odometer'         => null,
                'bagian_kendaraan' => null,
                'lokasi_kejadian'  => null,
                'lokasi_id'        => 1,
                'nama_lokasi'      => 'Ruang Rapat Sabo 1 (Gedung Utama Lt. 2)',
                'jenis_kerusakan'  => 'sedang',
                'deskripsi'        => 'Pendingin ruangan (AC Split) mengeluarkan air dan menimbulkan suara berisik saat dihidupkan, mengganggu konsentrasi rapat koordinasi.',
                'status'           => 'diproses',
                'catatan_admin'    => 'Teknisi fasilitas Sabo telah dijadwalkan untuk inspeksi dan penggantian kompresor pada hari Senin jam 09.00 WIB.',
                'created_at'       => date('Y-m-d H:i:s', strtotime('-3 days')),
                'foto'             => [
                    [
                        'id'         => 1,
                        'laporan_id' => 1,
                        'nama_file'  => 'demo_ac_bocor.jpg',
                    ],
                ],
            ],
            [
                'id'               => 2,
                'kode_laporan'     => 'LK-261022-002B',
                'user_id'          => 2,
                'nama_lengkap'     => 'Budi Santoso, S.T. (Pegawai)',
                'nip'              => '199001012020011001',
                'no_hp'            => '081200000002',
                'email'            => 'pegawai@pinsaka.test',
                'bagian_id'        => 2,
                'nama_bagian'      => 'Program dan Evaluasi',
                'kategori_laporan' => 'sarpras',
                'kendaraan_id'     => null,
                'nama_kendaraan'   => null,
                'nomor_polisi'     => null,
                'odometer'         => null,
                'bagian_kendaraan' => null,
                'lokasi_kejadian'  => null,
                'lokasi_id'        => 4,
                'nama_lokasi'      => 'Laboratorium Hidraulika Sabo (Flume Uji)',
                'jenis_kerusakan'  => 'berat',
                'deskripsi'        => 'Pipa katup sirkulasi air flume hidraulika retak di sambungan siku. Rembesan air cukup deras saat pompa uji sedimen dinyalakan.',
                'status'           => 'baru',
                'catatan_admin'    => null,
                'created_at'       => date('Y-m-d H:i:s', strtotime('-1 days')),
                'foto'             => [
                    [
                        'id'         => 2,
                        'laporan_id' => 2,
                        'nama_file'  => 'demo_pipa_retak.jpg',
                    ],
                ],
            ],
            [
                'id'               => 3,
                'kode_laporan'     => 'LK-261019-003C',
                'user_id'          => 1,
                'nama_lengkap'     => 'Administrator Sabo',
                'nip'              => '000000000000000001',
                'no_hp'            => '081200000001',
                'email'            => 'admin@pinsaka.test',
                'bagian_id'        => 1,
                'nama_bagian'      => 'Tata Usaha',
                'kategori_laporan' => 'sarpras',
                'kendaraan_id'     => null,
                'nama_kendaraan'   => null,
                'nomor_polisi'     => null,
                'odometer'         => null,
                'bagian_kendaraan' => null,
                'lokasi_kejadian'  => null,
                'lokasi_id'        => 7,
                'nama_lokasi'      => 'Area Parkir & Pos Gerbang Utama',
                'jenis_kerusakan'  => 'ringan',
                'deskripsi'        => 'Lampu penerangan gerbang utama padam saat malam hari.',
                'status'           => 'selesai',
                'catatan_admin'    => 'Bohlam LED 50W sudah diganti baru oleh petugas jaga.',
                'created_at'       => date('Y-m-d H:i:s', strtotime('-5 days')),
                'foto'             => [],
            ],
            [
                'id'               => 4,
                'kode_laporan'     => 'LK-261024-004V',
                'user_id'          => 2,
                'nama_lengkap'     => 'Budi Santoso, S.T. (Pegawai)',
                'nip'              => '199001012020011001',
                'no_hp'            => '081200000002',
                'email'            => 'pegawai@pinsaka.test',
                'bagian_id'        => 2,
                'nama_bagian'      => 'Program dan Evaluasi',
                'kategori_laporan' => 'kendaraan',
                'kendaraan_id'     => 1,
                'nama_kendaraan'   => 'Toyota Hilux Double Cabin 4x4 Lapangan',
                'nomor_polisi'     => 'AB 1042 BS',
                'odometer'         => '68.450 km',
                'bagian_kendaraan' => 'Sistem Rem, Suspensi & Kaki-kaki',
                'lokasi_kejadian'  => 'Jalur Survei Sabo Dam Kali Krasak',
                'lokasi_id'        => 5,
                'nama_lokasi'      => 'Toyota Hilux Double Cabin 4x4 (AB 1042 BS)',
                'jenis_kerusakan'  => 'sedang',
                'deskripsi'        => 'Pedal rem bergetar dan timbul bunyi gesekan besi saat pengereman di turunan curam menuju dasar sabo dam. Suspensi belakang kiri terasa sangat keras saat melintasi jalan inspeksi berbatu.',
                'status'           => 'diproses',
                'catatan_admin'    => 'Surat pengantar dinas telah diterbitkan. Kendaraan dijadwalkan masuk bengkel resmi rekanan pada Senin pagi jam 08.30 WIB untuk penggantian kampas rem dan peredam kejut.',
                'created_at'       => date('Y-m-d H:i:s', strtotime('-1 days')),
                'foto'             => [
                    [
                        'id'         => 4,
                        'laporan_id' => 4,
                        'nama_file'  => 'demo_rem_hilux.jpg',
                    ],
                ],
            ],
            [
                'id'               => 5,
                'kode_laporan'     => 'LK-261025-005V',
                'user_id'          => 2,
                'nama_lengkap'     => 'Budi Santoso, S.T. (Pegawai)',
                'nip'              => '199001012020011001',
                'no_hp'            => '081200000002',
                'email'            => 'pegawai@pinsaka.test',
                'bagian_id'        => 2,
                'nama_bagian'      => 'Program dan Evaluasi',
                'kategori_laporan' => 'kendaraan',
                'kendaraan_id'     => 2,
                'nama_kendaraan'   => 'Toyota Fortuner 2.8 4x4 Inspeksi',
                'nomor_polisi'     => 'AB 8201 XS',
                'odometer'         => '42.120 km',
                'bagian_kendaraan' => 'AC, Pendingin Kabin & Radiator',
                'lokasi_kejadian'  => 'Garasi Kendaraan Dinas Balai Sabo',
                'lokasi_id'        => 5,
                'nama_lokasi'      => 'Toyota Fortuner 2.8 4x4 Inspeksi (AB 8201 XS)',
                'jenis_kerusakan'  => 'ringan',
                'deskripsi'        => 'Hembusan AC kabin depan tidak dingin ketika mobil diparkir atau beroperasi pada siang hari yang terik. Udara hanya berhembus seperti kipas angin biasa.',
                'status'           => 'baru',
                'catatan_admin'    => null,
                'created_at'       => date('Y-m-d H:i:s'),
                'foto'             => [],
            ],
        ];

        self::saveReports($initialReports, 5);
    }

    /**
     * Daftar pilihan lokasi fasilitas sarpras.
     */
    public static function getLokasi(): array
    {
        return [
            ['id' => 1, 'nama_lokasi' => 'Ruang Rapat Sabo 1 (Gedung Utama Lt. 2)', 'kategori' => 'Gedung Utama'],
            ['id' => 2, 'nama_lokasi' => 'Ruang Tata Usaha (Gedung Utama Lt. 1)', 'kategori' => 'Gedung Utama'],
            ['id' => 3, 'nama_lokasi' => 'Ruang Seksi Program dan Evaluasi', 'kategori' => 'Gedung Utama'],
            ['id' => 4, 'nama_lokasi' => 'Laboratorium Hidraulika Sabo (Flume Uji)', 'kategori' => 'Laboratorium'],
            ['id' => 5, 'nama_lokasi' => 'Laboratorium Mekanika Tanah dan Batuan', 'kategori' => 'Laboratorium'],
            ['id' => 6, 'nama_lokasi' => 'Wisma Tamu Sabo - Kamar 01', 'kategori' => 'Wisma / Asrama'],
            ['id' => 7, 'nama_lokasi' => 'Area Parkir & Pos Gerbang Utama', 'kategori' => 'Sarana Luar'],
            ['id' => 8, 'nama_lokasi' => 'Toilet Lantai 1 Gedung Laboratorium', 'kategori' => 'Laboratorium'],
        ];
    }

    /**
     * Daftar armada kendaraan dinas resmi Balai Teknik Sabo.
     */
    public static function getKendaraan(): array
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

    /**
     * Daftar komponen umum kerusakan pada kendaraan dinas.
     */
    public static function getKomponenKendaraan(): array
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

    /**
     * Mengambil daftar laporan (bisa difilter user_id, status, atau kategori).
     */
    public static function getLaporan(?int $userId = null, ?string $status = null, ?string $kategori = null): array
    {
        self::init();
        $storage = self::loadReports();
        $reports = $storage['reports'] ?? [];

        $filtered = [];
        foreach ($reports as $r) {
            if ($userId !== null && (int)$r['user_id'] !== $userId) {
                continue;
            }
            if ($status !== null && $r['status'] !== $status) {
                continue;
            }
            if ($kategori !== null && ($r['kategori_laporan'] ?? 'sarpras') !== $kategori) {
                continue;
            }
            $filtered[] = $r;
        }

        // Urutkan ID terbesar (terbaru) di atas
        usort($filtered, static fn ($a, $b) => $b['id'] <=> $a['id']);

        return $filtered;
    }

    /**
     * Hitung jumlah laporan per status.
     */
    public static function hitungPerStatus(?int $userId = null, ?string $kategori = null): array
    {
        self::init();
        $storage = self::loadReports();
        $reports = $storage['reports'] ?? [];
        $hasil = ['baru' => 0, 'diproses' => 0, 'selesai' => 0];

        foreach ($reports as $r) {
            if ($userId !== null && (int)$r['user_id'] !== $userId) {
                continue;
            }
            if ($kategori !== null && ($r['kategori_laporan'] ?? 'sarpras') !== $kategori) {
                continue;
            }
            $st = $r['status'] ?? 'baru';
            if (isset($hasil[$st])) {
                $hasil[$st]++;
            }
        }

        return $hasil;
    }

    /**
     * Hitung jumlah laporan per kategori objek (sarpras vs kendaraan).
     */
    public static function hitungPerKategori(?int $userId = null): array
    {
        self::init();
        $storage = self::loadReports();
        $reports = $storage['reports'] ?? [];
        $hasil = ['semua' => 0, 'sarpras' => 0, 'kendaraan' => 0];

        foreach ($reports as $r) {
            if ($userId !== null && (int)$r['user_id'] !== $userId) {
                continue;
            }
            $hasil['semua']++;
            $kat = $r['kategori_laporan'] ?? 'sarpras';
            if (isset($hasil[$kat])) {
                $hasil[$kat]++;
            }
        }

        return $hasil;
    }

    /**
     * Detail satu laporan berdasarkan ID.
     */
    public static function detail(int $id): ?array
    {
        self::init();
        $storage = self::loadReports();
        $reports = $storage['reports'] ?? [];

        foreach ($reports as $r) {
            if ((int)$r['id'] === $id) {
                return $r;
            }
        }

        return null;
    }

    /**
     * Tambah laporan baru ke dalam penyimpanan demo persisten.
     */
    public static function tambah(array $data, array $fotoList = []): int
    {
        self::init();
        $storage = self::loadReports();
        $session = session();
        $counter = (int) ($storage['counter'] ?? 5) + 1;

        $kategoriLaporan = $data['kategori_laporan'] ?? 'sarpras';

        $lokasiId   = (int) ($data['lokasi_id'] ?? 0);
        $namaLokasi = 'Lokasi Fasilitas Sabo';

        if ($kategoriLaporan === 'kendaraan') {
            $namaKendaraan = trim((string) ($data['nama_kendaraan'] ?? 'Kendaraan Dinas'));
            $nopol         = strtoupper(trim((string) ($data['nomor_polisi'] ?? '')));
            $namaLokasi    = $namaKendaraan . ($nopol !== '' ? " ({$nopol})" : '');
            $lokasiId      = 5; // ID lokasi sarpras untuk 'Kendaraan Dinas'
        } else {
            $lokasiList = self::getLokasi();
            foreach ($lokasiList as $lok) {
                if ($lok['id'] === $lokasiId) {
                    $namaLokasi = $lok['nama_lokasi'];
                    break;
                }
            }
        }

        $userNama  = $session->get('nama') ?? 'Pegawai Contoh';
        $userEmail = $session->get('email') ?? 'pegawai@pinsaka.test';
        $userRole  = $session->get('role') ?? 'pegawai';

        $fotoFormatted = [];
        $fotoCounter = 100 + ($counter * 10);
        foreach ($fotoList as $file) {
            $fotoFormatted[] = [
                'id'         => ++$fotoCounter,
                'laporan_id' => $counter,
                'nama_file'  => $file,
            ];
        }

        $newLaporan = [
            'id'               => $counter,
            'kode_laporan'     => $data['kode_laporan'],
            'user_id'          => (int) ($session->get('user_id') ?? 2),
            'nama_lengkap'     => $userNama,
            'nip'              => $userRole === 'admin' ? '000000000000000001' : '199001012020011001',
            'no_hp'            => '081200000002',
            'email'            => $userEmail,
            'bagian_id'        => 2,
            'nama_bagian'      => 'Program dan Evaluasi',
            'kategori_laporan' => $kategoriLaporan,
            'kendaraan_id'     => isset($data['kendaraan_id']) ? (int) $data['kendaraan_id'] : null,
            'nama_kendaraan'   => $data['nama_kendaraan'] ?? null,
            'nomor_polisi'     => isset($data['nomor_polisi']) ? strtoupper(trim((string) $data['nomor_polisi'])) : null,
            'odometer'         => $data['odometer'] ?? null,
            'bagian_kendaraan' => $data['bagian_kendaraan'] ?? null,
            'lokasi_kejadian'  => $data['lokasi_kejadian'] ?? null,
            'lokasi_id'        => $lokasiId,
            'nama_lokasi'      => $namaLokasi,
            'jenis_kerusakan'  => $data['jenis_kerusakan'],
            'deskripsi'        => $data['deskripsi'],
            'status'           => 'baru',
            'catatan_admin'    => null,
            'created_at'       => date('Y-m-d H:i:s'),
            'foto'             => $fotoFormatted,
            'foto_perbaikan'   => [],
        ];

        $reports = $storage['reports'] ?? [];
        $reports[] = $newLaporan;
        self::saveReports($reports, $counter);

        return $counter;
    }

    /**
     * Perbarui status, catatan admin, dan unggah bukti foto perbaikan di penyimpanan persisten.
     */
    public static function updateStatus(int $id, string $status, ?string $catatan, array $fotoPerbaikanList = []): bool
    {
        self::init();
        $storage = self::loadReports();
        $reports = $storage['reports'] ?? [];
        $counter = (int) ($storage['counter'] ?? 5);

        foreach ($reports as &$r) {
            if ((int)$r['id'] === $id) {
                $r['status']        = $status;
                $r['catatan_admin'] = $catatan;
                $r['updated_at']    = date('Y-m-d H:i:s');

                if (! isset($r['foto_perbaikan']) || ! is_array($r['foto_perbaikan'])) {
                    $r['foto_perbaikan'] = [];
                }

                if (! empty($fotoPerbaikanList)) {
                    $fotoCounter = 800 + ($id * 20) + count($r['foto_perbaikan']);
                    foreach ($fotoPerbaikanList as $file) {
                        $r['foto_perbaikan'][] = [
                            'id'         => ++$fotoCounter,
                            'laporan_id' => $id,
                            'nama_file'  => $file,
                            'created_at' => date('Y-m-d H:i:s'),
                        ];
                    }
                }

                self::saveReports($reports, $counter);
                return true;
            }
        }

        return false;
    }
}
