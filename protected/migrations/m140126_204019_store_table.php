<?php

class m140126_204019_store_table extends CDbMigration
{
	public function up()
	{
		$this->createTable('store', array(
			'id' => 'pk',
			'store_name' => 'string NOT NULL UNIQUE',
			'image' => 'string DEFAULT NULL',
			'create_user_id' => 'int(11) DEFAULT NULL',
			'update_user_id' => 'int(11) DEFAULT NULL',
			'create_time' => 'datetime DEFAULT NULL', 
			'update_time' => 'datetime DEFAULT NULL',
		),  'ENGINE=InnoDB');

		$this->addColumn('item', 'school_id', 'int(11) NOT NULL'); 
		$this->addColumn('user', 'school_id', 'int(11) DEFAULT NULL'); 
		$this->addColumn('reservation', 'school_id', 'int(11) NOT NULL'); 
		$this->addColumn('comment', 'school_id', 'int(11) NOT NULL'); 

		$this->addForeignKey("fk_school_item", "item", "school_id", "store", "id", "CASCADE", "RESTRICT");
		$this->addForeignKey("fk_school_user", "user", "school_id", "store", "id", "CASCADE", "RESTRICT");
		$this->addForeignKey("fk_school_item", "reservation", "school_id", "store", "id", "CASCADE", "RESTRICT");
		$this->addForeignKey("fk_school_item", "comment", "school_id", "store", "id", "CASCADE", "RESTRICT");

	}

	public function down()
	{
		$this->dropColumn('item', 'school_id'); 
		$this->dropColumn('user', 'school_id'); 
		$this->dropColumn('reservation', 'school_id'); 
		$this->dropColumn('comment', 'school_id'); 

		$this->truncateTable('store');
		$this->dropTable('store');
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