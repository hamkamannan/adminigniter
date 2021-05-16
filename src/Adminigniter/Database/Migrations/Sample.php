<?php

namespace App\Adminigniter\Database\Migrations;

use CodeIgniter\Database\Migration;

class Sample extends Migration
{
	public function up()
	{
		// t_sample
		$this->forge->dropTable('t_sample', true);
		$this->forge->addField([
			'id' 			=> ['type' => 'MEDIUMINT','constraint' => '11','unsigned' => true,'auto_increment' => true,],
			'name' 			=> ['type' => 'VARCHAR','constraint' => '150','null' => true,],
			'slug' 			=> ['type' => 'VARCHAR','constraint' => '150','null' => true,],
			'sort' 			=> ['type' => 'MEDIUMINT','constraint' => '8','null' => true,],
			'description' 	=> ['type' => 'VARCHAR','constraint' => '255','null' => true,],
			'active' 		=> ['type' => 'TINYINT','constraint' => '1','unsigned' => true,'default' => 1,],
			'created_by' 	=> ['type' => 'INT','constraint' => 11,'null' => true,],
			'updated_by' 	=> ['type' => 'INT','constraint' => 11,'null' => true,],
			'created_at' 	=> ['type' => 'DATETIME','null' => true,],
			'updated_at' 	=> ['type' => 'DATETIME','null' => true,],
			'deleted_at' 	=> ['type' => 'DATETIME','null' => true,],
		]);
		$this->forge->addKey('id', true);
		$this->forge->createTable('t_sample');
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropTable('t_sample', true);
	}
}
