<?php

class m140129_000651_add_admin_and_active_to_user extends CDbMigration
{
	public function up()
	{
		$this->addColumn('user', 'is_admin', 'tinyint(1) not null');
		$this->addColumn('user', 'is_active', 'tinyint(1) not null');
	}

	public function down()
	{
		$this->dropColumn('user', 'is_admin');
		$this->dropColumn('user', 'is_active');
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