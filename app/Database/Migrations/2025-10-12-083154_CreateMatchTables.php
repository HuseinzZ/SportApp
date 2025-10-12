<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateMatchTables extends Migration
{
    public function up()
    {
        // Tabel MATCHES
        $this->forge->addField([
            'match_id' => ['type' => 'INT', 'constraint' => 3, 'unsigned' => true, 'auto_increment' => true],
            'match_date' => ['type' => 'DATE'],
            'match_type' => ['type' => 'VARCHAR', 'constraint' => 50, 'default' => 'Doubles'],

            // FK GOR & COURT
            'gor_id' => ['type' => 'INT', 'constraint' => 3, 'unsigned' => true],
            'court_id' => ['type' => 'INT', 'constraint' => 3, 'unsigned' => true],

            // FK ADMIN
            'recorded_by_admin' => ['type' => 'INT', 'constraint' => 3, 'unsigned' => true],

            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addPrimaryKey('match_id');
        $this->forge->addForeignKey('gor_id', 'gors', 'gor_id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('court_id', 'courts', 'court_id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('recorded_by_admin', 'admin', 'admin_id', 'CASCADE', 'CASCADE'); // Menggunakan 'admin' (bukan 'admins')
        $this->forge->createTable('matches');

        // Tabel MATCH_PARTICIPANTS
        $this->forge->addField([
            'participant_id' => ['type' => 'INT', 'constraint' => 3, 'unsigned' => true, 'auto_increment' => true],
            'match_id' => ['type' => 'INT', 'constraint' => 3, 'unsigned' => true],

            // TELAH DIPERBAIKI: Disamakan dengan 'user_id' di CreateUsersTable.php
            'user_id' => ['type' => 'INT', 'constraint' => 3, 'unsigned' => true],

            'is_winner' => ['type' => 'TINYINT', 'constraint' => 1],
            'points_before' => ['type' => 'INT'],
            'points_after' => ['type' => 'INT'],
            'points_change' => ['type' => 'INT'],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addPrimaryKey('participant_id');
        $this->forge->addForeignKey('match_id', 'matches', 'match_id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('user_id', 'users', 'user_id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('match_participants');
    }

    public function down()
    {
        $this->forge->dropTable('match_participants');
        $this->forge->dropTable('matches');
    }
}
