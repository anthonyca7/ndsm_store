<?php

class m140204_040238_add_data_to_rbac extends CDbMigration
{
	/*public function up()
	{
	}

	public function down()
	{
		echo "m140204_040238_add_data_to_rbac does not support migration down.\n";
		return false;
	}*/

	
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
		$authManager = Yii::app()->authManager;

		//create user operations
		$authManager->createOperation(
			"userIndex",
			"View all users of a store"); 
		$authManager->createOperation(
			"userDelete",
			"Ability to delete a user"); 
		$authManager->createOperation(
			"userUpdate",
			"Ability to delete a user"); 
		$authManager->createOperation(
			"userAdmin",
			"user administrator"); 
		$authManager->createOperation(
			"userRoot",
			"user root");

		//create item operations
		$authManager->createOperation(
			"itemCreate",
			"create item");
		$authManager->createOperation(
			"itemDelete",
			"delete item");
		$authManager->createOperation(
			"itemUpdate",
			"update item");
		$authManager->createOperation(
			"itemAdmin",
			"administrator item");
		$authManager->createOperation(
			"itemReserve",
			"reserve item");
		$authManager->createOperation(
			"itemUpdateReservation",
			"update reservation");
		$authManager->createOperation(
			"itemRoot",
			"item root");

		//reservation operations
		$authManager->createOperation(
			"reservationDelete",
			"Delete Reservation");
		$authManager->createOperation(
			"reservationAdmin",
			"Reservation Administrator");
		$authManager->createOperation(
			"reservationRoot",
			"reservation root");

		//store operation
		$authManager->createOperation(
			"storeDelete",
			"delete a store");
		$authManager->createOperation(
			"storeUpdate",
			"Change store");
		$authManager->createOperation(
			"sistratortoreAdmin",
			"store administrator");
		$authManager->createOperation(
			"storeMakeAdmin",
			"Add admin");
		$authManager->createOperation(
			"storeCancel",
			"cancel store");
		$authManager->createOperation(
			"storeApprove",
			"Approve Store");



		//StoreMember
		$bizRule='return Yii::app()->user->id===$params["id_user"]->id and $params["user"]->store->id===$params["store"]->id;';
        $ownAccountOperations=$authManager->createTask('ownAccountOperations','user account operations',$bizRule);
        $ownAccountOperations->addChild("userDelete");
		$ownAccountOperations->addChild("userUpdate");
		$ownAccountOperations->addChild("reservationDelete");
		$ownAccountOperations->addChild("itemUpdateReservation");

		$storeMember=$authManager->createRole("storeMember");
		$storeMember->addChild("ownAccountOperations");
		$storeMember->addChild("itemReserve");

		//storeAdministrator
		$bizRule='return $params["user"]->is_admin==1 and $params["store"]->id==$params["user"]->store->id;';
        $manageOwnStore=$authManager->createTask('manageOwnStore','manage store operations',$bizRule);
        $manageOwnStore->addChild("itemCreate");
        $manageOwnStore->addChild("itemUpdate");
		$manageOwnStore->addChild("itemDelete");
		$manageOwnStore->addChild("itemAdmin");
		$manageOwnStore->addChild("reservationAdmin");
		$manageOwnStore->addChild("storeCancel");
		$manageOwnStore->addChild("storeUpdate");
		$manageOwnStore->addChild("storeMakeAdmin");
		$manageOwnStore->addChild("userIndex");
		$manageOwnStore->addChild("userAdmin");

		$bizRule='return $params["user"]->is_admin==1 and $params["store"]->id==$params["id_user"]->store->id and $params["store"]->id==$params["user"]->store->id;';
		$manageStoreUsers=$authManager->createTask('manageStoreUsers','manage store users',$bizRule);
        $manageStoreUsers->addChild("userUpdate");
        $manageStoreUsers->addChild("userDelete");
        $manageStoreUsers->addChild("reservationDelete");
		$manageStoreUsers->addChild("itemUpdateReservation");

		$storeAdmin=$authManager->createRole("storeAdmin");
		$storeAdmin->addChild("manageOwnStore");
		$storeAdmin->addChild("manageStoreUsers");
		$storeAdmin->addChild("storeMember");

	}

	public function safeDown()
	{
		$authManager = Yii::app()->authManager;
		$authManager->clearAll();
	}
	
}

/*

<?php
class RbacCommand extends CConsoleCommand
{
   
    private $_authManager;
 
    
	public function getHelp()
	{
		
		$description = "DESCRIPTION\n";
		$description .= '    '."This command generates an initial RBAC authorization hierarchy.\n";
		return parent::getHelp() . $description;
	}

	
	
	public function actionIndex()
	{
		 
		$this->ensureAuthManagerDefined();
		
		//provide the oportunity for the use to abort the request
		$message = "This command will create three roles: Owner, Member, and Reader\n";
		$message .= " and the following permissions:\n";
		$message .= "create, read, update and delete user\n";
		$message .= "create, read, update and delete project\n";
		$message .= "create, read, update and delete issue\n";
		$message .= "Would you like to continue?";
	    
	    //check the input from the user and continue if 
		//they indicated yes to the above question
	    if($this->confirm($message)) 
		{
		     //first we need to remove all operations, 
			 //roles, child relationship and assignments
			 $this->_authManager->clearAll();

			 //create the lowest level operations for users
			 $this->_authManager->createOperation(
				"createUser",
				"create a new user"); 
			 $this->_authManager->createOperation(
				"readUser",
				"read user profile information"); 
			 $this->_authManager->createOperation(
				"updateUser",
				"update a users in-formation"); 
			 $this->_authManager->createOperation(
				"deleteUser",
				"remove a user from a project"); 

			 //create the lowest level operations for projects
			 $this->_authManager->createOperation(
				"createProject",
				"create a new project"); 
			 $this->_authManager->createOperation(
				"readProject",
				"read project information"); 
	 		 $this->_authManager->createOperation(
				"updateProject",
				"update project information"); 
			 $this->_authManager->createOperation(
				"deleteProject",
				"delete a project"); 

			 //create the lowest level operations for issues
			 $this->_authManager->createOperation(
				"createIssue",
				"create a new issue"); 
			 $this->_authManager->createOperation(
				"readIssue",
				"read issue information"); 
			 $this->_authManager->createOperation(
				"updateIssue",
				"update issue information"); 
			 $this->_authManager->createOperation(
				"deleteIssue",
				"delete an issue from a project");     

			 //create the reader role and add the appropriate 
			 //permissions as children to this role
			 $role=$this->_authManager->createRole("reader"); 
			 $role->addChild("readUser");
			 $role->addChild("readProject"); 
			 $role->addChild("readIssue"); 

			 //create the member role, and add the appropriate 
			 //permissions, as well as the reader role itself, as children
			 $role=$this->_authManager->createRole("member"); 
			 $role->addChild("reader"); 
			 $role->addChild("createIssue"); 
			 $role->addChild("updateIssue"); 
			 $role->addChild("deleteIssue"); 

			 //create the owner role, and add the appropriate permissions, 
			 //as well as both the reader and member roles as children
			 $role=$this->_authManager->createRole("owner"); 
			 $role->addChild("reader"); 
			 $role->addChild("member");    
			 $role->addChild("createUser"); 
			 $role->addChild("updateUser"); 
			 $role->addChild("deleteUser");  
			 $role->addChild("createProject"); 
			 $role->addChild("updateProject"); 
			 $role->addChild("deleteProject");	
		
		     //provide a message indicating success
		     echo "Authorization hierarchy successfully generated.\n";
        }
 		else
			echo "Operation cancelled.\n";
    }

	public function actionDelete()
	{
		$this->ensureAuthManagerDefined();
		$message = "This command will clear all RBAC definitions.\n";
		$message .= "Would you like to continue?";
	    //check the input from the user and continue if they indicated 
	    //yes to the above question
	    if($this->confirm($message)) 
	    {
			$this->_authManager->clearAll();
			echo "Authorization hierarchy removed.\n";
		}
		else
			echo "Delete operation cancelled.\n";
			
	}
	
	protected function ensureAuthManagerDefined()
	{
		if(($this->_authManager=Yii::app()->authManager)===null)
		{
		    $message = "Error: an authorization manager, named 'authManager' must be con-figured to use this command.";
			$this->usageError($message);
		}
	}
}


*/