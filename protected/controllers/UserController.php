<?php

class UserController extends Controller
{

	private $store = null;
	private $model = null;
	private $id_user = null;
	public $layout='//layouts/column2';
	const VALIDATED = 1;

	public function filters()
	{
		return array(
			'storeContext + index register update delete admin',
			'loadUser + index update delete admin',
			'loadIdUser + update profile delete validate',
			'accessControl',  
		);
	}

	public function accessRules()
	{
		$params=array();
        $params['user']=$this->model;
        $params['store']=$this->store;
        $params['id_user']=$this->id_user;

		return array(
			array('allow',  
				'actions'=>array('validate', 'profile'),
				'users'=>array('*'),
			),
			array('allow',
				'actions'=>array('register'),
				'users'=>array('?'),
			),
			array('allow',
				'actions'=>array('index'),
				'roles'=>array('userIndex'=>$params),
			),
			array('allow',
				'actions'=>array('delete'),
				'roles'=>array('userDelete'=>$params),
			),
			array('allow',
				'actions'=>array('update'),
				'roles'=>array('userUpdate'=>$params),
			),
			array('allow',
				'actions'=>array('admin'),
				'roles'=>array('userAdmin'=>$params),
			),

			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	public function actionProfile($name)
	{
		if ($this->id_user->store->unique_identifier != $_GET['tag']) {
			throw new CHttpException(404, 'Invalid page');
		}
		if (Yii::app()->user->id===$this->id_user->id) {
			$this->render('profile',array(
				'model'=>$this->id_user,
			));
		}
		else{
			$this->render('view',array(
				'model'=>$this->id_user,
			));
		}
		Yii::model()->app->end();
	}

	public function actionValidate($id, $code)
	{
		Yii::app()->user->logout();
		$user = $this->id_user;

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

		$model=new User;

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
			$model->school_id = $this->store->id;

			if($model->save()){
				$model->password = crypt($model->password, '$2a$10$anthony.cabshahdasswor$');
				if($model->update('password')){
					
					$useri = new UserIdentity($model->email, $password);
					if ($useri->authenticate()) {
						Yii::app()->user->login($useri,2592000);
					}

					$header  = "MIME-Version: 1.0\r\n";
	 				$header .= "Content-type: text/html; charset: utf8\r\n";

	 				$link = "<a href='" . $this->createAbsoluteUrl('user/validate', array('id'=>$model->id, 
	 					'code'=>$model->validation_code))  .  "'> click here to validate! </a> ";

					mail($model->email, "Finish your registration", $link, $header);
					Yii::app()->user->setFlash('warning', 
						"<strong>{$model->email}, Go to your email to validate this account, 
						don't forget to check the spam folder</strong>");
					$auth = Yii::app()->authManager;
					$auth->assign('storeMember',$model->id);
					$this->redirect(array('store/view', 'tag'=>$tag));
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
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['User']))
		{
			$this->id_user->attributes=$_POST['User'];
			$password = $this->id_user->password;
			if($this->id_user->save()){
				$this->id_user->password = crypt($this->id_user->password, '$2a$10$anthony.cabshahdasswor$');
				if($this->id_user->update('password')){
					if ($this->id_user->id==Yii::app()->user->id){
						$useri = new UserIdentity($this->id_user->email, $password);
						if ($useri->authenticate()) {
							Yii::app()->user->login($useri,2592000);
						}
					}

					$this->redirect(array('profile','name'=>$this->id_user->username, 'tag'=>$tag));
				}
			}
		}

		$this->render('update',array(
			'model'=>$this->id_user,
		));
	}

	
	public function actionDelete($id, $tag)
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$this->id_user->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	public function actionIndex($tag)
	{	
		$dataProvider=new CActiveDataProvider('User', array(
			'criteria'=>array('condition' => 'school_id='. $this->store->id),
		));
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	public function actionAdmin($tag)
	{
		$model=new User('search');
		$model->unsetAttributes(); 
		if(isset($_GET['User']))
			$model->attributes=$_GET['User'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='user-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	public function loadModel($id, $withstore=false)
	{
		if ($withstore) {
			$model=User::model()->with("store")->findByPk($id);
		}
		else{
			$model=User::model()->findByPk($id);
		}
		
		if($model===null )
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}


	public function loadByName($name)
	{
		$model=User::model()->with("store")->findByAttributes(array('username'=>$name));

		if( $model===null )
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	protected function loadstore($tag)
	{
		if($this->store===null)
		{
			$this->store = Store::model()->findByAttributes(array('unique_identifier'=>$tag));
		}

		if($this->store===null)
		{
			throw new CHttpException(404,'The requested STORE does not exist.');
		}
		return $this->store;

	}

	public function filterStoreContext($filterChain)
	{
		if(isset($_GET['tag']))
			$this->loadstore($_GET['tag']);
		else
			throw new CHttpException(403,'Must specify a store before performing this action.');

		$filterChain->run();
	}
	public function filterLoadUser($filterChain)
	{
		if(!Yii::app()->user->isGuest)
			$this->model = $this->loadModel(Yii::app()->user->id, true);
		else
			$this->redirect($this->createUrl('site/login'));

		$filterChain->run();
	}
	
	public function filterLoadIdUser($filterChain)
	{
		if(!Yii::app()->user->isGuest){
			if (isset($_GET['id'])) 
				$this->id_user = $this->loadModel($_GET['id'], true);
			
			elseif (isset($_GET['name'])) 
				$this->id_user = $this->loadByName($_GET['name'], true);

			else
				throw new CHttpException(403,'Specify the user');
			
			$filterChain->run();
		}
		else
			$this->redirect($this->createUrl('site/login'));

		$filterChain->run();
	}

}
