<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUsers extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'           => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'nama_lengkap' => ['type' => 'VARCHAR', 'constraint' => 150],
            'nip'          => ['type' => 'VARCHAR', 'constraint' => 30],
            'bagian_id'    => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => true],
            'no_hp'        => ['type' => 'VARCHAR', 'constraint' => 20, 'null' => true],
            'email'        => ['type' => 'VARCHAR', 'constraint' => 150],
            'password'     => ['type' => 'VARCHAR', 'constraint' => 255],
            'role'         => ['type' => 'ENUM', 'constraint' => ['pegawai', 'admin'], 'default' => 'pegawai'],
            'created_at'   => ['type' => 'DATETIME', 'null' => true],
            'updated_at'   => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('nip');
        $this->forge->addUniqueKey('email');
        $this->forge->addForeignKey('bagian_id', 'bagian', 'id', 'CASCADE', 'SET NULL');
        $this->forge->createTable('users', true, ['ENGINE' => 'InnoDB']);
    }

    public function down()
    {
        $this->forge->dropTable('users', true);
    }
}
