<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateFotoLaporan extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'         => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'laporan_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'nama_file'  => ['type' => 'VARCHAR', 'constraint' => 255],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('laporan_id', 'laporan_kerusakan', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('foto_laporan', true, ['ENGINE' => 'InnoDB']);
    }

    public function down()
    {
        $this->forge->dropTable('foto_laporan', true);
    }
}
