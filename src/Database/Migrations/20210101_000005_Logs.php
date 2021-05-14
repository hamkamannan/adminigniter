<?php

namespace hamkamannan\adminigniter\Database\Migrations;

use CodeIgniter\Database\Migration;

class Logs extends Migration
{
	public function up()
	{
		// Drop table 'c_logs' if it exists
		$this->forge->dropTable('c_logs', true);

		// Table structure for table 'login_attempts'
		$this->forge->addField([
			'id' => [
				'type' => 'MEDIUMINT',
				'constraint' => '11',
				'unsigned' => true,
				'auto_increment' => true,
			],
			'message' => [
				'type' => 'VARCHAR',
				'constraint' => '255',
				'null' => true,
			],
			'controller' => [
				'type' => 'VARCHAR',
				'constraint' => '50',
				'null' => true,
			],
			'operation' => [
				'type' => 'VARCHAR',
				'constraint' => '50',
				'null' => true,
			],
			'ref_table' => [
				'type' => 'VARCHAR',
				'constraint' => '50',
				'null' => true,
			],
			'ref_id' => [
				'type' => 'MEDIUMINT',
				'constraint' => '11',
				'unsigned' => true,
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
		$this->forge->createTable('c_logs');
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropTable('c_logs', true);
	}
}
