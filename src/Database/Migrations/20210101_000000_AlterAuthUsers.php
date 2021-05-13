<?php

namespace hamkamannan\adminigniter\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterTableUsers extends Migration
{
	public function up()
	{
		$fields = [
			'first_name' => [
				'type' => 'VARCHAR',
				'constraint' => '50',
				'null' => true,
			],
			'last_name' => [
				'type' => 'VARCHAR',
				'constraint' => '50',
				'null' => true,
			],
			'phone' => [
				'type' => 'VARCHAR',
				'constraint' => '50',
				'null' => true,
			],
			'section' => [
				'type' => 'VARCHAR',
				'constraint' => '50',
				'null' => true,
			],
			'department' => [
				'type' => 'VARCHAR',
				'constraint' => '50',
				'null' => true,
			],
			'division' => [
				'type' => 'VARCHAR',
				'constraint' => '50',
				'null' => true,
			],
			'unit' => [
				'type' => 'VARCHAR',
				'constraint' => '50',
				'null' => true,
			],
			'company' => [
				'type' => 'VARCHAR',
				'constraint' => '50',
				'null' => true,
			],
			'address' => [
				'type' => 'VARCHAR',
				'constraint' => '255',
				'null' => true,
			],
		];
		$this->forge->addColumn('users', $fields);
	}

	public function down()
	{
		$this->forge->dropColumn('users', ['first_name','last_name','phone','section','department','division','unit','company','address']);
	}
}
