<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\I18n\Time;

class CreateAdminTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'admin_id' => [
                'type' => 'INT',
                'constraint' => 3,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'username' => ['type' => 'VARCHAR', 'constraint' => 100],
            'password_hash' => ['type' => 'VARCHAR', 'constraint' => 255],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addPrimaryKey('admin_id');
        $this->forge->addUniqueKey('username');
        $this->forge->createTable('admin');

        $this->db->table('admin')->insert([
            'username' => 'admin',
            'password_hash' => password_hash('admin123', PASSWORD_BCRYPT),
            'created_at' => Time::now(),
            'updated_at' => Time::now(),
        ]);
    }

    public function down()
    {
        $this->forge->dropTable('admin');
    }
}
