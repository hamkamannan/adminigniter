<?php

namespace hamkamannan\adminigniter\Database\Migrations;

use CodeIgniter\Database\Migration;

class References extends Migration
{
	public function up()
	{
		// Drop table 'references' if it exists
		$this->forge->dropTable('c_references', true);

		// Table structure for table 'references'
		$this->forge->addField([
			'id' => [
				'type' => 'MEDIUMINT',
				'constraint' => '11',
				'unsigned' => true,
				'auto_increment' => true,
			],
			'slug' => [
				'type' => 'VARCHAR',
				'constraint' => '255',
				'null' => true,
			],
			'name' => [
				'type' => 'VARCHAR',
				'constraint' => '50',
				'null' => true,
			],
			'sort' => [
				'type' => 'MEDIUMINT',
				'constraint' => '8',
				'null' => true,
			],
			'description' => [
				'type' => 'VARCHAR',
				'constraint' => '255',
				'null' => true,
			],
			'menu_id' => [
				'type' => 'INT',
				'constraint' => '11',
				'null' => true,
			],
			'active' => [
				'type' => 'TINYINT',
				'constraint' => '1',
				'unsigned' => true,
				'default' => 1,
			],
			'created_by' => [
				'type' => 'INT',
				'constraint' => 11,
				'null' => true,
			],
			'updated_by' => [
				'type' => 'INT',
				'constraint' => 11,
				'null' => true,
			],
			'created_at' => [
				'type' => 'DATETIME',
				'null' => true,
			],
			'updated_at' => [
				'type' => 'DATETIME',
				'null' => true,
			],
			'deleted_at' => [
				'type' => 'DATETIME',
				'null' => true,
			],
		]);
		$this->forge->addKey('id', true);
		$this->forge->createTable('c_references');
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropTable('c_references', true);
	}
}
