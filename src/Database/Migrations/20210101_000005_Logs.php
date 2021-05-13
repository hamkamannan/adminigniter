<?php

namespace hamkamannan\adminigniter\Database\Migrations;

use CodeIgniter\Database\Migration;

class Logs extends Migration
{
	protected $config;
	private $tables = [];

	public function up()
	{
		//
		$this->config = config('Core');
		$this->DBGroup = $this->config->databaseGroupName ?? '';
		$this->tables = $this->config->tables;

		// Drop table 'login_attempts' if it exists
		$this->forge->dropTable($this->tables['logs'], true);

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
		$this->forge->createTable($this->tables['logs']);
	}

	//--------------------------------------------------------------------

	public function down()
	{
		//
		$this->config = config('Core');
		$this->DBGroup = $this->config->databaseGroupName ?? '';
		$this->tables = $this->config->tables;

		$this->forge->dropTable($this->tables['logs'], true);
	}
}
