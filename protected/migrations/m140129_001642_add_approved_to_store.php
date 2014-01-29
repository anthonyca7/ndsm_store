<?php

class m140129_001642_add_approved_to_store extends CDbMigration
{
	public function up()
	{
		$this->addColumn('store', 'approved', 'tinyint(1) not null');
	}

	public function down()
	{
		$this->dropColumn('store', 'approved');
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