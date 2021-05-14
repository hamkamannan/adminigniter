<?php

namespace hamkamannan\adminigniter\Database\Migrations;

use CodeIgniter\Database\Migration;

class Params extends Migration
{
	public function up()
	{
		// Drop table 'c_params' if it exists
		$this->forge->dropTable('c_params', true);

		// Table structure for table 'c_params'
		$this->forge->addField([
			'id' => [
				'type' => 'MEDIUMINT',
				'constraint' => '11',
				'unsigned' => true,
				'auto_increment' => true,
			],
			'name' => [
				'type' => 'VARCHAR',
				'constraint' => '150',
				'null' => true,
			],
			'value' => [
				'type' => 'VARCHAR',
				'constraint' => '255',
				'null' => true,
			],
			'description' => [
				'type' => 'VARCHAR',
				'constraint' => '255',
				'null' => true,
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
		$this->forge->createTable('c_params');
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropTable('c_params', true);
	}
}
