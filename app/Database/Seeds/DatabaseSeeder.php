<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Urutan penting: bagian dulu, baru users (foreign key).
        $this->call('BagianSeeder');
        $this->call('LokasiSarprasSeeder');
        $this->call('UserSeeder');
    }
}
