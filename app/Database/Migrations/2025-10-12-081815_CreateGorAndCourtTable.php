<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateGorAndCourtTables extends Migration
{
    public function up()
    {
        // Tabel GORS
        $this->forge->addField([
            'gor_id' => ['type' => 'INT', 'constraint' => 3, 'unsigned' => true, 'auto_increment' => true], // PK GOR
            'name' => ['type' => 'VARCHAR', 'constraint' => 100],
            'address' => ['type' => 'TEXT'],
            'facilities' => ['type' => 'TEXT', 'null' => true],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addPrimaryKey('gor_id');
        $this->forge->createTable('gors');

        // Tabel COURTS
        $this->forge->addField([
            'court_id' => ['type' => 'INT', 'constraint' => 3, 'unsigned' => true, 'auto_increment' => true],
            'gor_id' => ['type' => 'INT', 'constraint' => 3, 'unsigned' => true],
            'court_name' => ['type' => 'VARCHAR', 'constraint' => 100],
            'price_per_hour' => ['type' => 'DECIMAL', 'constraint' => '10,2'],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addPrimaryKey('court_id');
        $this->forge->addForeignKey('gor_id', 'gors', 'gor_id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('courts');
    }

    public function down()
    {
        $this->forge->dropTable('courts');
        $this->forge->dropTable('gors');
    }
}
