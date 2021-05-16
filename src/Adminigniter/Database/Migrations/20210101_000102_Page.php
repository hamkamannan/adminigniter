<?php

namespace App\Adminigniter\Database\Migrations;

use CodeIgniter\Database\Migration;

class Page extends Migration
{
	public function up()
	{
		// t_page
		$this->forge->dropTable('t_page', true);
		$this->forge->addField([
			'id' => [
				'type' => 'MEDIUMINT',
				'constraint' => '11',
				'unsigned' => true,
				'auto_increment' => true,
			],
			'title' => [
				'type' => 'VARCHAR',
				'constraint' => '255',
				'null' => true,
			],
			'slug' => [
				'type' => 'VARCHAR',
				'constraint' => '255',
				'null' => true,
			],
			'content' => [
				'type' => 'TEXT',
				'null' => true,
			],
			'tags' => [
				'type' => 'TEXT',
				'null' => true,
			],
			'file_image' => [
				'type' => 'VARCHAR',
				'constraint' => '255',
				'null' => true,
			],
			'blog_category_id' => [
				'type' => 'INT',
				'constraint' => 11,
				'null' => true,
			],
			'status' => [
				'type' => 'VARCHAR',
				'constraint' => '255',
				'null' => true,
			],
			'author' => [
				'type' => 'INT',
				'constraint' => '11',
				'null' => true,
			],
			'viewers' => [
				'type' => 'INT',
				'constraint' => '11',
				'null' => true,
			],
			'description' => [
				'type' => 'TEXT',
				'null' => true,
			],
			'active' => [
				'type' => 'TINYINT',
				'constraint' => '1',
				'unsigned' => true,
				'default' => 0,
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
		$this->forge->createTable('t_page');
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropTable('t_page');
	}
}
