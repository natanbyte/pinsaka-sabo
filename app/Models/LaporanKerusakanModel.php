<?php

namespace App\Models;

use CodeIgniter\Model;

class LaporanKerusakanModel extends Model
{
    protected $DBGroup       = 'default';
    protected $table         = 'laporan_kerusakan';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $allowedFields = [
        'kode_laporan', 'user_id', 'kategori_laporan', 'lokasi_id',
        'kendaraan_id', 'nama_kendaraan', 'nomor_polisi', 'odometer',
        'bagian_kendaraan', 'lokasi_kejadian', 'jenis_kerusakan',
        'deskripsi', 'status', 'catatan_admin',
    ];
    protected $useTimestamps = true;

    /**
     * Daftar laporan. Isi $userId untuk membatasi ke laporan milik satu user,
     * atau biarkan null untuk semua laporan (dipakai admin).
     */
    public function daftar(?int $userId = null, ?string $status = null, ?string $kategori = null): array
    {
        $this->select('laporan_kerusakan.*, lokasi_sarpras.nama_lokasi, users.nama_lengkap')
            ->join('lokasi_sarpras', 'lokasi_sarpras.id = laporan_kerusakan.lokasi_id', 'left')
            ->join('users', 'users.id = laporan_kerusakan.user_id')
            ->orderBy('laporan_kerusakan.id', 'DESC');

        if ($userId !== null) {
            $this->where('laporan_kerusakan.user_id', $userId);
        }

        if ($status !== null) {
            $this->where('laporan_kerusakan.status', $status);
        }

        if ($kategori !== null) {
            $this->where('laporan_kerusakan.kategori_laporan', $kategori);
        }

        return $this->findAll();
    }

    /**
     * Jumlah laporan per status. Isi $userId untuk membatasi ke satu user.
     *
     * @return array{baru: int, diproses: int, selesai: int}
     */
    public function hitungPerStatus(?int $userId = null, ?string $kategori = null): array
    {
        $this->select('status, COUNT(*) AS jumlah')->groupBy('status');

        if ($userId !== null) {
            $this->where('user_id', $userId);
        }

        if ($kategori !== null) {
            $this->where('kategori_laporan', $kategori);
        }

        $hasil = ['baru' => 0, 'diproses' => 0, 'selesai' => 0];
        foreach ($this->findAll() as $baris) {
            $hasil[$baris['status']] = (int) $baris['jumlah'];
        }

        return $hasil;
    }

    /**
     * Jumlah laporan per kategori objek (sarpras vs kendaraan).
     *
     * @return array{semua: int, sarpras: int, kendaraan: int}
     */
    public function hitungPerKategori(?int $userId = null): array
    {
        $this->select('kategori_laporan, COUNT(*) AS jumlah')->groupBy('kategori_laporan');

        if ($userId !== null) {
            $this->where('user_id', $userId);
        }

        $hasil = ['semua' => 0, 'sarpras' => 0, 'kendaraan' => 0];
        foreach ($this->findAll() as $baris) {
            $kat = $baris['kategori_laporan'] ?: 'sarpras';
            if (isset($hasil[$kat])) {
                $hasil[$kat] = (int) $baris['jumlah'];
            }
            $hasil['semua'] += (int) $baris['jumlah'];
        }

        return $hasil;
    }

    /**
     * Satu laporan lengkap dengan lokasi dan data pelapor.
     */
    public function detail(int $id): ?array
    {
        return $this->select(
            'laporan_kerusakan.*, lokasi_sarpras.nama_lokasi, '
            . 'users.nama_lengkap, users.nip, users.no_hp, users.email, bagian.nama_bagian'
        )
            ->join('lokasi_sarpras', 'lokasi_sarpras.id = laporan_kerusakan.lokasi_id', 'left')
            ->join('users', 'users.id = laporan_kerusakan.user_id')
            ->join('bagian', 'bagian.id = users.bagian_id', 'left')
            ->where('laporan_kerusakan.id', $id)
            ->first();
    }
}
