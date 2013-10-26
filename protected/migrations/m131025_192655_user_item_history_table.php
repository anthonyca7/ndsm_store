<?php

class m131025_192655_user_item_history_table extends CDbMigration
{
	/*
	public function up()
	{
	}

	public function down()
	{
		echo "m131025_192655_user_item_history_table does not support migration down.\n";
		return false;
	}
	*/

	
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
		$this->createTable('user', array(
			'id' => 'pk',
			'email' => 'string NOT NULL UNIQUE',
			'password' => 'varchar(255) NOT NULL',
			'status' => 'tinyint(1) NOT NULL',
			'create_time' => 'datetime DEFAULT NULL', 
			'update_time' => 'datetime DEFAULT NULL',
			'last_login' => 'DATETIME NULL',
		),  'ENGINE=InnoDB');


		$this->createTable('item', array(
			'id' => 'pk',
			'name' => 'string NOT NULL UNIQUE',
			'price' => 'DECIMAL(9,2) DEFAULT NULL',
			'quantity' => 'int(11) DEFAULT 0',
			'description' => 'text not null',
		),  'ENGINE=InnoDB');

		$this->createTable('shopping_history', array(
			'user_id' => 'int(11) DEFAULT NULL',
			'item_id' => 'int(11) DEFAULT NULL',
			'date' => 'DATETIME NULL',
			'PRIMARY KEY (`user_id`, `item_id`)',
		), 'ENGINE=InnoDB');

		

		$this->addForeignKey("fk_shopping_item_assignment", "shopping_history", "item_id", "item", "id", "CASCADE", "RESTRICT");
		$this->addForeignKey("fk_shopping_user_assignment", "shopping_history", "user_id", "user", "id", "CASCADE", "RESTRICT");
	}

	public function safeDown()
	{
		$this->truncateTable('shopping_history');
		$this->truncateTable('item');
		$this->truncateTable('user');
		$this->dropTable('shopping_history');
		$this->dropTable('item');
		$this->dropTable('user');
	}
	
}