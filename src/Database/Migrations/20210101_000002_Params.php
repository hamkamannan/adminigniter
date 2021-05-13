<?php

namespace hamkamannan\adminigniter\Database\Migrations;

use CodeIgniter\Database\Migration;

class Params extends Migration
{
	protected $config;
	private $tables = [];

	public function up()
	{
		//
		$this->config = config('Core');
		$this->DBGroup = $this->config->databaseGroupName ?? '';
		$this->tables = $this->config->tables;

		// Drop table 'params' if it exists
		$this->forge->dropTable($this->tables['params'], true);

		// Table structure for table 'params'
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
		$this->forge->createTable($this->tables['params']);
	}

	//--------------------------------------------------------------------

	public function down()
	{
		//
		$this->config = config('Core');
		$this->DBGroup = $this->config->databaseGroupName ?? '';
		$this->tables = $this->config->tables;

		$this->forge->dropTable($this->tables['params'], true);
	}
}
