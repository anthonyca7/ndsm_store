<?php

class m140106_205650_add_columns_to_reservation_table extends CDbMigration
{
	public function up()
	{
		$this->dropColumn('reservation', "date");
		$this->addColumn('reservation', 'create_time', 'datetime DEFAULT NULL'); 
		$this->addColumn('reservation', 'update_time', 'datetime DEFAULT NULL');
	}

	public function down()
	{
		echo "m140106_205650_add_columns_to_reservation_table does not support migration down.\n";
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