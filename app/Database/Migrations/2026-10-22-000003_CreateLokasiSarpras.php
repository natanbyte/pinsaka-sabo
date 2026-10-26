<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateLokasiSarpras extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'          => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'nama_lokasi' => ['type' => 'VARCHAR', 'constraint' => 150],
            'kategori'    => ['type' => 'ENUM', 'constraint' => ['ruang', 'kendaraan', 'fasilitas'], 'default' => 'fasilitas'],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('lokasi_sarpras', true, ['ENGINE' => 'InnoDB']);
    }

    public function down()
    {
        $this->forge->dropTable('lokasi_sarpras', true);
    }
}
