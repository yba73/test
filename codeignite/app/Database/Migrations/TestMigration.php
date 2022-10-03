<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePostsTable extends Migration {
    public function up() {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'nom' => [
                'type' => 'VARCHAR',
                'constraint' => 10,
            ],
            'nom' => [
                'type' => 'VARCHAR',
                'constraint' => 10,
            ],
            'nom' => [
                'type' => 'INT',
             
            ],
            'body' => [
                'type' => 'TEXT',
            ],
            'image' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('posts');
    }

    public function down() {
        $this->forge->dropTable('posts');
    }
}