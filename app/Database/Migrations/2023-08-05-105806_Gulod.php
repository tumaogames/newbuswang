<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Gulod extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'first_name' => [
                'type' => 'VARCHAR',
                'constraint' => 30,
            ],
            'last_name' => [
                'type' => 'VARCHAR',
                'constraint' => 30,
            ],
            'address' => [
                'type' => 'VARCHAR',
                'constraint' => 30,
            ],
            'precinct_no' => [
                'type' => 'VARCHAR',
                'constraint' => 30,
            ],
            'clustered_precinct' => [
                'type' => 'VARCHAR',
                'constraint' => 30,
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

        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('newbuswang');
    }

    public function down()
    {
        $this->forge->dropTable('newbuswang');
    }
}

