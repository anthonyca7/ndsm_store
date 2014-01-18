<?php

class UserController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
	const VALIDATED = 1;

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  
				'actions'=>array('view', 'register', 'validate', 'profile' ),
				'users'=>array('*'),
			),
			array('allow', 
				'actions'=>array('update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete','index'),
				'users'=>array('anthonyka7@gmail.com', 'anthonyca7@gmail.com', 'anthonyca7@hotmail.com'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionProfile($id)
	{
		if (Yii::app()->user->id===$id) {
			$this->render('profile',array(
				'model'=>$this->loadModel($id),
			));
		}
		else{
			$this->render('view',array(
				'model'=>$this->loadModel($id),
			));
		}
	}

	public function actionValidate($id, $code)
	{
		Yii::app()->user->logout();
		$user = User::model()->findByPk($id);

		if ( ($user->validation_code === $code) ) {
			$user->status = 1;
			if($user->update(array('status'))){
				$useri = new UserIdentity($user->email, $user->password);
				Yii::app()->user->login($useri,2592000);
				Yii::app()->user->setFlash('info', "<strong>{$user->email}, you have validated your account</strong>");

			}
			else{
				throw new CHttpException(403,'There was an error while your account was being validated');
			}
		}
		else{
			if($user->status !== self::VALIDATED)
				throw new CHttpException(403,'There was an error while your account was being validated');
		}
		$this->redirect(array('site/login'));
	}

	/**
	 * register a new model.
	 * If creation is successful, thfe browser will be redirected to the 'view' page.
	 */
	public function actionRegister()
	{
		if (!Yii::app()->user->isGuest) {
			$this->redirect(array('site/index'));
		}

		$model=new User;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['User']))
		{
			$model->attributes = $_POST['User'];
			$password = $model->password;

			$model->status = 0;
			$model->validation_code = md5('anthony' . $model->password . $model->email);

			if($model->save()){
				$model->password = crypt($model->password, '$2a$10$anthony.cabshahdasswor$');
				//$model->password_repeat = crypt($model->password_repeat, '$2a$10$anthony.cabshahdasswor$');
				if($model->update('password')){
					
					$useri = new UserIdentity($model->email, $password);
					if ($useri->authenticate()) {
						Yii::app()->user->login($useri,2592000);

						$header  = "MIME-Version: 1.0\r\n";
	 					$header .= "Content-type: text/html; charset: utf8\r\n";

	 					$link = CHtml::link("Click here to activate this account", 
						 	array('user/validate', 'id'=>$model->id, 'code'=>$model->validation_code));

						mail($model->email, "Finish your registration", $link, $header);
						Yii::app()->user->setFlash('warning', 
							"<strong>{$model->email}, Go to your email to validate this account, 
							don't forget to check the spam folder</strong>");
						$this->redirect(array('site/index'));
					}
				}
				else{
					$model->delete();
					Yii::app()->user->setFlash('error', 'Something went wrong with the registration');

				}
				$this->redirect(array('site/index'));
			}
			else{
				$model->password = '';
				$model->password_repeat = '';
			}

		}

		$this->render('register',array(
			'model'=>$model,
		));
	}



	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['User']))
		{
			$model->attributes=$_POST['User'];
			if($model->save()){
				$this->redirect(array('view','id'=>$model->id));
			}
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

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{	
		$dataProvider=new CActiveDataProvider('User');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new User('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['User']))
			$model->attributes=$_GET['User'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=User::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='user-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
