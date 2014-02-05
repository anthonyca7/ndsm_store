<?php

class StoreController extends Controller
{

	public $layout='//layouts/column1';

	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}

	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view', 'homepage', "create"),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}


	public function actionHomepage()
	{
		$this->layout = "clearcolumn";
		$this->render('homepage');
	}

	public function actionView($tag)
	{
		$this->render('view',array(
			'model'=>$this->loadByTag($tag),
		));
	}

	public function actionCreate()
	{
		$this->layout = "clearcolumn";

		$model=new Store;
		$admin=new User;

		if(isset($_POST['Store']) and isset($_POST['User']))
		{
			$model->attributes=$_POST['Store'];
			$admin->attributes=$_POST['User'];

			$admin->status = 0;
			$admin->is_admin = 1;
			$admin->is_active = 0;

			$model->approved = 0;
			$password = $admin->password;

			if ($model->save()) {
				$admin->password = crypt($admin->password, '$2a$10$anthony.cabshahdasswor$');
				$admin->password_repeat = crypt($admin->password_repeat, '$2a$10$anthony.cabshahdasswor$');
				$admin->school_id = $model->id;
				if ($admin->save()) {
					$useri = new UserIdentity($admin->email, $password);
					if ($useri->authenticate())
						Yii::app()->user->login($useri,2592000);
					$auth = Yii::app()->authManager;
					$auth->assign('storeAdmin',$admin->id);

					$this->redirect(array('view','tag'=>$model->unique_identifier));

				}
			}

			$command = Yii::app()->db->createCommand();
			$command->delete('store', 'id=:sid', array(':sid'=>$model->id));
			$command2 = Yii::app()->db->createCommand();
			$command2->delete('user', 'id=:sid', array(':sid'=>$admin->id));
			$admin->password='';
			$admin->password_repeat='';
		}

		$this->render('create',array(
			'model'=>$model,
			'admin'=>$admin,
		));
	}

	public function actionUpdate($tag)
	{
		$model=$this->loadByTag($tag);

		if(isset($_POST['Store']))
		{
			$model->attributes=$_POST['Store'];
			if($model->save())
				$this->redirect(array('view','tag'=>$model->unique_identifier));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	public function actionDelete($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$this->loadModel($id)->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Store');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Store('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Store']))
			$model->attributes=$_GET['Store'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}


	public function loadModel($id)
	{
		/*$comments = Comment::model()->with(array('issue'=>array('condition'=>'
		project_id=1')))->recent(10)->findAll();*/

		//$model = Store::model()->with(array('users'=>array('condition'=>'school_id='.$id)))->findByPk($id);
		$model = Store::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	public function loadByTag($tag)
	{
		/*$comments = Comment::model()->with(array('issue'=>array('condition'=>'
		project_id=1')))->recent(10)->findAll();*/

		//$model = Store::model()->with(array('users'=>array('condition'=>'school_id='.$id)))->findByPk($id);
		$model = Store::model()->findByAttributes(array('unique_identifier'=>$tag));
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	public function filterAdmin($fc)
	{
		$user = User::model()->findByPk(Yii::app()->user->id);
		if ($user->status == 2) {
			$fc->run();
			Yii::app()->end();
		}

		throw new CHttpException(403,'Invalid Request');
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='store-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
