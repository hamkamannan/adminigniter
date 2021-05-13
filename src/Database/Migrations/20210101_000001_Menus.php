<?php

namespace hamkamannan\adminigniter\Database\Migrations;

use CodeIgniter\Database\Migration;

class Menus extends Migration
{
	protected $config;
	private $tables = [];

	public function up()
	{
		$this->config = config('Core');
		$this->DBGroup = $this->config->databaseGroupName ?? '';
		$this->tables = $this->config->tables;

		// c_menus_categories
		$this->forge->dropTable($this->tables['menus_categories'], true);
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
			'slug' => [
				'type' => 'VARCHAR',
				'constraint' => '150',
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
		$this->forge->createTable($this->tables['menus_categories']);

		// Drop table 'menus' if it exists
		$this->forge->dropTable($this->tables['menus'], true);

		// Table structure for table 'moduels'
		$this->forge->addField([
			'id' => [
				'type' => 'MEDIUMINT',
				'constraint' => '11',
				'unsigned' => true,
				'auto_increment' => true,
			],
			'name' => [
				'type' => 'VARCHAR',
				'constraint' => '50',
				'null' => true,
			],
			'parent' => [
				'type' => 'MEDIUMINT',
				'constraint' => '8',
				'default' => 0,
			],
			'controller' => [
				'type' => 'VARCHAR',
				'constraint' => '50',
				'null' => true,
			],
			'icon' => [
				'type' => 'VARCHAR',
				'constraint' => '100',
				'null' => true,
			],
			'permission' => [
				'type' => 'VARCHAR',
				'constraint' => '255',
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
			'type' => [
				'type' => 'ENUM("menu", "label", "reference")',
				'default' => 'menu',
				'null' => false
			],
			'menu_category_id' => [
				'type' => 'INT',
				'constraint' => 11,
				'null' => false
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
		$this->forge->createTable($this->tables['menus']);
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->config = config('Core');
		$this->DBGroup = $this->config->databaseGroupName ?? '';
		$this->tables = $this->config->tables;

		$this->forge->dropTable($this->tables['menus'], true);
		$this->forge->dropTable($this->tables['menus_categories'], true);
	}
}
