<?php

namespace App\Adminigniter\Database\Migrations;

use CodeIgniter\Database\Migration;

class Banner extends Migration
{
	public function up()
	{
		// t_banner
		$this->forge->dropTable('t_banner', true);
		$this->forge->addField([
			'id' 			=> ['type' => 'MEDIUMINT','constraint' => '11','unsigned' => true,'auto_increment' => true,],
			'name' 			=> ['type' => 'VARCHAR','constraint' => '150','null' => true,],
			'slug' 			=> ['type' => 'VARCHAR','constraint' => '150','null' => true,],
			
			'file_image' 	=> ['type' => 'VARCHAR','constraint' => '255','null' => true,],
			'url' 			=> ['type' => 'VARCHAR','constraint' => '255','null' => true,],
			'url_title' 	=> ['type' => 'VARCHAR','constraint' => '255','null' => true,],
			'url_target' 	=> ['type' => 'VARCHAR','constraint' => '255','null' => true,'default' => '_blank',],
			'category_id' 	=> ['type' => 'INT','constraint' => '11','null' => true,],
			
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
		$this->forge->createTable('t_banner');
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropTable('t_banner', true);
	}
}
