<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUsersTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'user_id' => ['type' => 'INT', 'constraint' => 3, 'unsigned' => true, 'auto_increment' => true],
            'name' => ['type' => 'VARCHAR', 'constraint' => 255],
            'email' => ['type' => 'VARCHAR', 'constraint' => 255, 'unique' => true],
            'phone' => ['type' => 'VARCHAR', 'constraint' => 50],
            'points' => ['type' => 'INT', 'default' => 0],
            'total_matches' => ['type' => 'INT', 'default' => 0],
            'total_wins' => ['type' => 'INT', 'default' => 0],
            'win_rate' => ['type' => 'DECIMAL', 'constraint' => '5,2', 'default' => 0.00],
            'level' => ['type' => 'VARCHAR', 'constraint' => 20, 'default' => 'Beginner'],
            'rank_badge' => ['type' => 'VARCHAR', 'constraint' => 10, 'default' => '🏸'],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addPrimaryKey('user_id');
        $this->forge->createTable('users');
    }

    public function down()
    {
        $this->forge->dropTable('users');
    }
}
