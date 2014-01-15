<?php

class m140109_191814_comment_rating_table extends CDbMigration
{
	public function up()
	{
		//create the issue table
		$this->createTable('comment', array(
			'id' => 'pk',
		    'content' => 'text NOT NULL',
		    'rating' => 'tinyint NOT NULL',
		    'item_id' => 'int(11) NOT NULL',
			'create_time' => 'datetime DEFAULT NULL',
			'create_user_id' => 'int(11) DEFAULT NULL',
			'update_time' => 'datetime DEFAULT NULL',
			'update_user_id' => 'int(11) DEFAULT NULL',
		 ), 'ENGINE=InnoDB');
		
		$this->addForeignKey("fk_comment_issue", "comment", "item_id", "item", "id", "CASCADE", "RESTRICT");
		
		$this->addForeignKey("fk_comment_owner", "comment", "create_user_id", "user", "id", "RESTRICT", "RESTRICT");
		
		$this->addForeignKey("fk_comment_update_user", "comment", "update_user_id", "user", "id", "RESTRICT", "RESTRICT");
	}

	public function down()
	{
		$this->dropForeignKey('fk_comment_issue', 'comment');
		$this->dropForeignKey('fk_comment_owner', 'comment');
		$this->dropForeignKey('fk_comment_update_user', 'comment');
		$this->dropTable('comment');
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