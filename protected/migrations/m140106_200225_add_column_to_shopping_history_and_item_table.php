<?php
//add brought column to shopping history table
//drop primary key on shopping history table
//add quantity column on the shopping history table
//add available column to Item table
//make a reservation model

class m140106_200225_add_column_to_shopping_history_and_item_table extends CDbMigration
{
	public function up()
	{

	}

	public function down()
	{
		echo "m140106_200225_add_column_to_shopping_history_and_item_table does not support migration down.\n";
		return false;
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