<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class BagianSeeder extends Seeder
{
    public function run()
    {
        // DATA CONTOH - ganti dengan daftar bagian asli dari client.
        $this->db->table('bagian')->insertBatch([
            ['nama_bagian' => 'Tata Usaha'],
            ['nama_bagian' => 'Umum dan Kepegawaian'],
            ['nama_bagian' => 'Keuangan'],
            ['nama_bagian' => 'Perencanaan'],
            ['nama_bagian' => 'Teknis'],
        ]);
    }
}
