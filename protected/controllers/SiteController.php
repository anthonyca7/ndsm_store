<?php

class SiteController extends Controller
{
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		$this->render('index');
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{
		$model=new ContactForm;
		if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];
			if($model->validate())
			{
				$name='=?UTF-8?B?'.base64_encode($model->name).'?=';
				$subject='=?UTF-8?B?'.base64_encode($model->subject).'?=';
				$headers="From: $name <{$model->email}>\r\n".
					"Reply-To: {$model->email}\r\n".
					"MIME-Version: 1.0\r\n".
					"Content-Type: text/plain; charset=UTF-8";

				mail(Yii::app()->params['adminEmail'],$subject,$model->body,$headers);
				Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
				$this->refresh();
			}
		}
		$this->render('contact',array('model'=>$model));
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		$layout = "column1";
		if (Yii::app()->user->isGuest){

		$model=new LoginForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login()){

				$user = User::model()->findByAttributes(array('email' => Yii::app()->user->name));
				if (isset($user) and $user->status==1) 
					Yii::app()->user->setFlash('success', "<strong>{$user->email}, you have successfully logged in</strong>");
				else
					Yii::app()->user->setFlash('warning', 
						"<strong>{$user->email}, Go to your email to validate this account, 
						don't forget to check the spam folder</strong>");
				if (Yii::app()->user->returnUrl != Yii::app()->baseUrl . '/') {
					$this->redirect(Yii::app()->user->returnUrl);
				}
				else{
					$user = User::model()->with('store')->findByPk(Yii::app()->user->id);
					$this->redirect(array('store/view', 'tag'=>$user->store->unique_identifier));
				}
			}
		}
		// display the login form
		$this->render('login',array('model'=>$model));
		}
		else{
			$user = User::model()->with('store')->findByPk(Yii::app()->user->id);
			$this->redirect(array('store/view', 'tag'=>$user->store->unique_identifier));
		}
	}

	public function actionLogout()
	{
		if (!Yii::app()->user->isGuest) {
			$user = User::model()->with('store')->findByPk(Yii::app()->user->id);
			$school_tag = $user->store->unique_identifier;
			Yii::app()->user->logout();
			$this->redirect(Yii::app()->createAbsoluteUrl('store/view', array('tag'=>$school_tag)));
		}
	}
}