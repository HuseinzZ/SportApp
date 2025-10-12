<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSchedulesAndGalleryTables extends Migration
{
    public function up()
    {
        // Tabel SCHEDULES
        $this->forge->addField([
            'schedule_id' => ['type' => 'INT', 'constraint' => 3, 'unsigned' => true, 'auto_increment' => true],
            'gor_id' => ['type' => 'INT', 'constraint' => 3, 'unsigned' => true],
            'court_id' => ['type' => 'INT', 'constraint' => 3, 'unsigned' => true],
            'date' => ['type' => 'DATE'],
            'start_time' => ['type' => 'TIME'],
            'end_time' => ['type' => 'TIME'],
            'status' => ['type' => 'VARCHAR', 'constraint' => 50, 'default' => 'Available'],
            'max_players' => ['type' => 'INT', 'default' => 4],
            'description' => ['type' => 'TEXT', 'null' => true],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addPrimaryKey('schedule_id');
        $this->forge->addForeignKey('gor_id', 'gors', 'gor_id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('court_id', 'courts', 'court_id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('schedules');

        // Tabel GALLERY
        $this->forge->addField([
            'gallery_id' => ['type' => 'INT', 'constraint' => 3, 'unsigned' => true, 'auto_increment' => true],
            'image' => ['type' => 'TEXT'],
            'description' => ['type' => 'VARCHAR', 'constraint' => 255],
            'upload_date' => ['type' => 'DATETIME'],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addPrimaryKey('gallery_id');
        $this->forge->createTable('gallery');
    }

    public function down()
    {
        $this->forge->dropTable('schedules');
        $this->forge->dropTable('gallery');
    }
}
