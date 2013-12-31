<?php

class m131231_194536_change_user_table extends CDbMigration
{
	public function up()
	{
		$this->addColumn('user', 'first', 'string NOT NULL');
		$this->addColumn('user', 'last', 'string NOT NULL');
		$this->addColumn('user', 'validation_code', 'varchar(255) NOT NULL');
	}

	public function down()
	{
		$this->dropColumn('user', 'first');
		$this->dropColumn('user', 'last');
		$this->dropColumn('user', 'validation_code');
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