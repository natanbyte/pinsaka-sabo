<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateLaporanKerusakan extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'              => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'kode_laporan'    => ['type' => 'VARCHAR', 'constraint' => 30],
            'user_id'         => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'lokasi_id'       => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'jenis_kerusakan' => ['type' => 'ENUM', 'constraint' => ['ringan', 'sedang', 'berat']],
            'deskripsi'       => ['type' => 'TEXT'],
            'status'          => ['type' => 'ENUM', 'constraint' => ['baru', 'diproses', 'selesai'], 'default' => 'baru'],
            'catatan_admin'   => ['type' => 'TEXT', 'null' => true],
            'created_at'      => ['type' => 'DATETIME', 'null' => true],
            'updated_at'      => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('kode_laporan');
        $this->forge->addKey('status');
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'RESTRICT');
        $this->forge->addForeignKey('lokasi_id', 'lokasi_sarpras', 'id', 'CASCADE', 'RESTRICT');
        $this->forge->createTable('laporan_kerusakan', true, ['ENGINE' => 'InnoDB']);
    }

    public function down()
    {
        $this->forge->dropTable('laporan_kerusakan', true);
    }
}
