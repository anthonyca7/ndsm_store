<?php

class m140118_232727_add_username_to_user extends CDbMigration
{
	public function up()
	{
		$this->addColumn('user', 'username', 'string NOT NULL UNIQUE'); 

	}

	public function down()
	{
		$this->dropColumn('user', 'username');
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