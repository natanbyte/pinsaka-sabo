<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddKendaraanToLaporanKerusakan extends Migration
{
    public function up()
    {
        $fields = [
            'kategori_laporan' => [
                'type'       => 'ENUM',
                'constraint' => ['sarpras', 'kendaraan'],
                'default'    => 'sarpras',
                'after'      => 'user_id',
            ],
            'kendaraan_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
                'after'      => 'lokasi_id',
            ],
            'nama_kendaraan' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
                'null'       => true,
                'after'      => 'kendaraan_id',
            ],
            'nomor_polisi' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'null'       => true,
                'after'      => 'nama_kendaraan',
            ],
            'odometer' => [
                'type'       => 'VARCHAR',
                'constraint' => 30,
                'null'       => true,
                'after'      => 'nomor_polisi',
            ],
            'bagian_kendaraan' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
                'after'      => 'odometer',
            ],
            'lokasi_kejadian' => [
                'type'       => 'VARCHAR',
                'constraint' => 200,
                'null'       => true,
                'after'      => 'bagian_kendaraan',
            ],
        ];

        $this->forge->addColumn('laporan_kerusakan', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('laporan_kerusakan', [
            'kategori_laporan',
            'kendaraan_id',
            'nama_kendaraan',
            'nomor_polisi',
            'odometer',
            'bagian_kendaraan',
            'lokasi_kejadian',
        ]);
    }
}
