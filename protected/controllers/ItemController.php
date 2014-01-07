<?php

class ItemController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}

	public function accessRules()
	{
		return array(
			array('allow',  
				'actions'=>array('view','index' ),
				'users'=>array('*'),
			),
			array('allow', 
				'actions'=>array('reserve'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('create','delete','admin','update'),
				'users'=>array('anthonyka7@gmail.com', 'anthonyca7@gmail.com', 'anthonyca7@hotmail.com'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}




	public function actionReserve($id, $quantity)
	{
		$model=$this->loadModel($id);

		echo "This is the action reserve method " . $id . " " . $quantity;

		$this->redirect(array('?q=w'));
		

	}

	/*$this->createTable('reservation', array(
			'user_id' => 'int(11) DEFAULT NULL',
			'item_id' => 'int(11) DEFAULT NULL',
			'date' => 'DATETIME NULL',
			'PRIMARY KEY (`user_id`, `item_id`)',
		), 'ENGINE=InnoDB');
*/


	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Item;
		$model->quantity = 1;
		$model->available = 1;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Item']))
		{
			$model->attributes=$_POST['Item'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
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

		if(isset($_POST['Item']))
		{
			$model->attributes=$_POST['Item'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
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
	/*public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Item');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}*/
	public function actionIndex()
	{
	    $criteria = new CDbCriteria();

	    if(isset($_GET['q']) and $_GET['q']!='')
	    {
	      $q = $_GET['q'];
	      $criteria->compare('name', $q, true, 'OR');
	      $criteria->compare('description', $q, true, 'OR');

	      $dataProvider=new CActiveDataProvider("Item", array('criteria'=>$criteria));
	      //Item_name
	      Yii::app()->clientScript->registerScript('search', "
			$('#Item_name').val('" . $q . "');

			");

		  $this->render('index',array(
		    'dataProvider'=>$dataProvider,
		  ));


	    }
	    else{
	    	throw new CHttpException(403,'Enter what you are looking for on the search box');
	    }
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Item('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Item']))
			$model->attributes=$_GET['Item'];

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
		$model=Item::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='item-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
