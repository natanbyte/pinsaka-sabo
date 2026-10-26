<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class MakeLokasiIdNullableInLaporanKerusakan extends Migration
{
    public function up()
    {
        $this->forge->modifyColumn('laporan_kerusakan', [
            'lokasi_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
                'default'    => null,
            ],
        ]);
    }

    public function down()
    {
        $this->forge->modifyColumn('laporan_kerusakan', [
            'lokasi_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => false,
            ],
        ]);
    }
}
