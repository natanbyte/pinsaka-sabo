<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $now = date('Y-m-d H:i:s');

        // AKUN CONTOH untuk pengembangan. Hapus/ganti sebelum dipakai sungguhan.
        $this->db->table('users')->insertBatch([
            [
                'nama_lengkap' => 'Administrator',
                'nip'          => '000000000000000001',
                'bagian_id'    => 1,
                'no_hp'        => '081200000001',
                'email'        => 'admin@pinsaka.test',
                'password'     => password_hash('admin123', PASSWORD_DEFAULT),
                'role'         => 'admin',
                'created_at'   => $now,
                'updated_at'   => $now,
            ],
            [
                'nama_lengkap' => 'Pegawai Contoh',
                'nip'          => '199001012020011001',
                'bagian_id'    => 2,
                'no_hp'        => '081200000002',
                'email'        => 'pegawai@pinsaka.test',
                'password'     => password_hash('pegawai123', PASSWORD_DEFAULT),
                'role'         => 'pegawai',
                'created_at'   => $now,
                'updated_at'   => $now,
            ],
        ]);
    }
}
