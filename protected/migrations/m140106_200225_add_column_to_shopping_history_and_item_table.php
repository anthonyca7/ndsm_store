<?php
//add brought column to shopping history table c
//drop primary key on shopping history table check c
//add quantity column on the shopping history table c
//add available column to Item table
//make a reservation model c

class m140106_200225_add_column_to_shopping_history_and_item_table extends CDbMigration
{
	public function up()
	{
		$this->dropTable('shopping_history');

		$this->createTable('reservation', array(
			'id' => 'pk',
			'user_id' => 'int(11) DEFAULT NULL',
			'item_id' => 'int(11) DEFAULT NULL',
			'date' => 'DATETIME NULL',
			'brought' => 'tinyint',
			'quantity' => 'int',

		), 'ENGINE=InnoDB');

		$this->addForeignKey("fk_shopping_item_assignment", "reservation", "item_id", "item", "id", "CASCADE", "RESTRICT");
		$this->addForeignKey("fk_shopping_user_assignment", "reservation", "user_id", "user", "id", "CASCADE", "RESTRICT");

		$this->addColumn("item", "available", "int");
	}

	public function down()
	{
		$this->truncateTable('reservation');
		$this->dropColumn('item', "available");
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