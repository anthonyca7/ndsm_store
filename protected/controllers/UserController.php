<?php

class UserController extends Controller
{

	private $_store = null;
	public $layout='//layouts/column2';
	const VALIDATED = 1;

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'storeContext + register update profile',
			'admin + admin delete index',
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
				'actions'=>array('update', 'admin','delete','index'),
				'users'=>array('@'),
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

	public function actionRegister($tag)
	{
		
		$this->layout = "clearcolumn";
		if (!Yii::app()->user->isGuest) {
			$this->redirect(array('store/view', 'tag'=>$tag));
		}

		$model=new User;
		$model->school_id = $this->_store->id;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['User']))
		{
			$model->attributes = $_POST['User'];
			$password = $model->password;

			$model->status = 0;
			$model->is_admin = 0;
			$model->is_active = 1;
			$model->validation_code = md5('anthony' . $model->password . $model->email);
			$model->school_id = $this->_store->id;

			if($model->save()){
				$model->password = crypt($model->password, '$2a$10$anthony.cabshahdasswor$');
				if($model->update('password')){
					
					$useri = new UserIdentity($model->email, $password);
					if ($useri->authenticate()) {
						Yii::app()->user->login($useri,2592000);

						$header  = "MIME-Version: 1.0\r\n";
	 					$header .= "Content-type: text/html; charset: utf8\r\n";

	 					$link = "<a href='" . $this->createAbsoluteUrl('user/validate', array('id'=>$model->id, 
	 						'code'=>$model->validation_code))  .  "'> click here to validate! </a> ";

						mail($model->email, "Finish your registration", $link, $header);
						Yii::app()->user->setFlash('warning', 
							"<strong>{$model->email}, Go to your email to validate this account, 
							don't forget to check the spam folder</strong>");
						$this->redirect(array('store/view', 'tag'=>$tag));
					}
				}
				else{
					$model->delete();
					Yii::app()->user->setFlash('error', 'Something went wrong with the registration');
				}
				$this->redirect(array('store/view', 'tag'=>$tag));
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


	public function actionUpdate($id, $tag)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['User']))
		{
			$model->attributes=$_POST['User'];
			if($model->save()){
				$this->redirect(array('profile','id'=>$model->id, 'tag'=>$tag));
			}
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	
	public function actionDelete($tag)
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
	public function actionIndex($tag)
	{	
		$dataProvider=new CActiveDataProvider('User', array(
			'criteria'=>array('condition' => 'school_id='. $this->_store->id),
		));
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin($tag)
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
		if($model===null or $model->school_id!==$this->_store->id )
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

	protected function loadstore($tag)
	{
		if($this->_store===null)
		{
			$this->_store = Store::model()->findByAttributes(array('unique_identifier'=>$tag));
		}

		if($this->_store===null)
		{
			throw new CHttpException(404,'The requested STORE does not exist.');
		}
		return $this->_store;

	}

	public function filterStoreContext($filterChain)
	{
		if(isset($_GET['tag']))
			$this->loadstore($_GET['tag']);
		else
			throw new CHttpException(403,'Must specify a store before performing this action.');

		$filterChain->run();
	}
	public function filterAdmin($filterChain)
	{
		if (!Yii::app()->user->isGuest) {
			$this->loadstore($_GET['tag']);
			$user = User::model()->with('store')->findByPk(Yii::app()->user->id);
			if ( $user->is_admin and $user->store->id === $this->_store->id) {
				$filterChain->run();
				Yii::app()->end();
			}
		}
		throw new CHttpException(403,'Invalid Request');
	}
	public function filterMember($filterChain)
	{
		if (!Yii::app()->user->isGuest) {
			$this->loadstore($_GET['tag']);
			$user = User::model()->with('store')->findByPk(Yii::app()->user->id);
			if ( $user->store->id === $this->_store->id) {
				$filterChain->run();
				Yii::app()->end();
			}
		}
		throw new CHttpException(403,'Invalid Request');
	}
}
