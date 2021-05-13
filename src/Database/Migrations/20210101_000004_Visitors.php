<?php

namespace hamkamannan\adminigniter\Database\Migrations;

use CodeIgniter\Database\Migration;

class Visitors extends Migration
{
	protected $config;
	private $tables = [];

	public function up()
	{
		//
		$this->config = config('Core');
		$this->DBGroup = $this->config->databaseGroupName ?? '';
		$this->tables = $this->config->tables;

		// Drop table 'users' if it exists
		$this->forge->dropTable($this->tables['visitors'], true);

		// Table structure for table 'users'
		$this->forge->addField([
			'id' => [
				'type' => 'MEDIUMINT',
				'constraint' => '11',
				'unsigned' => true,
				'auto_increment' => true,
			],
			'ip_address' => [
				'type' => 'VARCHAR',
				'constraint' => '255',
				'null' => true,
			],
			'ip_country' => [
				'type' => 'VARCHAR',
				'constraint' => '255',
				'null' => true,
			],
			'ip_regionName' => [
				'type' => 'VARCHAR',
				'constraint' => '255',
				'null' => true,
			],
			'ip_city' => [
				'type' => 'VARCHAR',
				'constraint' => '255',
				'null' => true,
			],
			'ip_lat' => [
				'type' => 'VARCHAR',
				'constraint' => '255',
				'null' => true,
			],
			'ip_lon' => [
				'type' => 'VARCHAR',
				'constraint' => '255',
				'unique' => true,
				'null' => true,
			],
			'ip_isp' => [
				'type' => 'VARCHAR',
				'constraint' => '255',
				'null' => true,
			],
			'timestamp' => [
				'type' => 'DATE',
				'null' => true,
			],
			'hits' => [
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
		$this->forge->createTable($this->tables['visitors'], false);
	}

	//--------------------------------------------------------------------

	public function down()
	{
		//
		$this->config = config('Core');
		$this->DBGroup = $this->config->databaseGroupName ?? '';
		$this->tables = $this->config->tables;

		$this->forge->dropTable($this->tables['visitors'], true);
	}
}
