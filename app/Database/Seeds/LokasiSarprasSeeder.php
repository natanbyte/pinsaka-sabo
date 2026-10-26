<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class LokasiSarprasSeeder extends Seeder
{
    public function run()
    {
        // Nama ruang rapat mengikuti formulir client. Sisanya DATA CONTOH.
        $this->db->table('lokasi_sarpras')->insertBatch([
            ['nama_lokasi' => 'Media Center Auditorium Merapi', 'kategori' => 'ruang'],
            ['nama_lokasi' => 'Ruang Rapat Semeru',             'kategori' => 'ruang'],
            ['nama_lokasi' => 'Ruang Rapat Kelud',              'kategori' => 'ruang'],
            ['nama_lokasi' => 'Ruang Rapat Sinabung',           'kategori' => 'ruang'],
            ['nama_lokasi' => 'Kendaraan Dinas',                'kategori' => 'kendaraan'],
            ['nama_lokasi' => 'Gedung Kantor Utama',            'kategori' => 'fasilitas'],
            ['nama_lokasi' => 'Area Parkir',                    'kategori' => 'fasilitas'],
            ['nama_lokasi' => 'Toilet',                         'kategori' => 'fasilitas'],
        ]);
    }
}
