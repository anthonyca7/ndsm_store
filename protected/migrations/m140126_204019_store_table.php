<?php

class m140126_204019_store_table extends CDbMigration
{
	public function up()
	{
		$this->createTable('store', array(
			'id' => 'pk',
			'name' => 'string NOT NULL UNIQUE',
			'unique_identifier' => 'string NOT NULL UNIQUE',
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

		$this->addForeignKey("fk_school_item_assignment", "item", "school_id", "store", "id", "CASCADE", "RESTRICT");
		$this->addForeignKey("fk_school_user_assignment", "user", "school_id", "store", "id", "CASCADE", "RESTRICT");
		$this->addForeignKey("fk_school_reservation_assignment", "reservation", "school_id", "store", "id", "CASCADE", "RESTRICT");
		$this->addForeignKey("fk_school_comment_assignment", "comment", "school_id", "store", "id", "CASCADE", "RESTRICT");

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