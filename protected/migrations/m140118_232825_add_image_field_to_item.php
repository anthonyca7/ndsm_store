<?php

class m140118_232825_add_image_field_to_item extends CDbMigration
{
	public function up()
	{
		$this->addColumn('item', 'image', 'string NOT NULL'); 
		$this->addColumn('item', 'create_time', 'datetime DEFAULT NULL'); 
		$this->addColumn('item', 'update_time', 'datetime DEFAULT NULL'); 

	}

	public function down()
	{
		$this->dropColumn('item', 'image');
		$this->dropColumn('item', 'create_time');
		$this->dropColumn('item', 'update_time');
	}

	/*
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
	}

	public function safeDown()
	{
	}
	*/
}