<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddJenisToFotoLaporan extends Migration
{
    public function up()
    {
        $fields = [
            'jenis' => [
                'type'       => 'ENUM',
                'constraint' => ['awal', 'perbaikan'],
                'default'    => 'awal',
                'after'      => 'nama_file',
            ],
        ];

        $this->forge->addColumn('foto_laporan', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('foto_laporan', 'jenis');
    }
}
