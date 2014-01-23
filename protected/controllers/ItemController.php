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
				'actions'=>array('reserve', 'updatereservation'),
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




	private function reserve($id)
	{
		$user = User::model()->findByPk(Yii::app()->user->id);
		$item = $this->loadModel($id);

		if (isset($_GET['quantity'])) {
			$quantity = $_GET['quantity'];
		}
		else{
			throw new CHttpException(400, "pass a valid quantity");
		}

		if( isset($item) and ($item->available > 0) and ($item->available >= $quantity) ){
			if($user->status == 1){
				$r_model = new Reservation;
				$r_model->user_id = $user->id;
				$r_model->item_id = $id;
				$r_model->brought = 0;
				$r_model->quantity = $_GET['quantity'];

				if ($r_model->save()) {
					$item->available = $item->available - $quantity;
					$item->update(array('available'));
					Yii::app()->user->setflash('info', "You have reserved {$quantity} items");
				}
				else{
					Yii::app()->user->setflash('error', 'There was an error while attempting to make your reservation');
				}

			}
			else{
				Yii::app()->user->setflash('warning', "You need to validate your email to reserve any item");
				$this->redirect($this->createUrl('item/view', array('id'=>$id)));
			}


		}
		else{
			Yii::app()->user->setflash('error', "Sorry, we don't have {$quantity} {$item->name}s available");
		}

		$this->redirect($this->createUrl('item/view', array('id'=>$id)));

	}

	

	public function actionReserve($id, $quantity)
	{
		if (!$this->check_for_existing_reservation($id, Yii::app()->user->id)) {
			$this->reserve($id, $quantity);
		}
		else{
			Yii::app()->user->setflash('info', 'You have already reserved this item');
			$this->redirect(array('item/view', 'id'=>$id));
		}
	}

	public function actionUpdatereservation($id)
	{
		$reservation = Reservation::model()->findByAttributes(array('user_id'=>Yii::app()->user->id,
																	'item_id'=>$id));
		if ($reservation === null or !isset($_GET['nq']) or !$this->validposint($_GET['nq'])) {
			if (intval($_GET['nq']) <= 0) {
				Yii::app()->user->setflash('error', 'You need to choose an amount bigger than 0');
			}
			else{
				Yii::app()->user->setflash('error', 'You need to select a valid item');
			}
			$this->redirect($this->createUrl('item/view', array('id'=>$id)));
		}
		else{
			$item = $this->loadModel($id);
			$new_quantity = $_GET['nq'];
			$old_quantity = $reservation->quantity;

			$diff = $new_quantity - $old_quantity;

			$item = $this->loadModel($id);
			$updated_quantity = $item->available - $diff;

			if ($updated_quantity < 0) {
				Yii::app()->user->setflash('warning', 'You tried amount to more than what we have available');
				$this->redirect($this->createUrl('item/view', array('id'=>$id)));
			}

			$reservation->quantity = $new_quantity;
			$item->available -= $diff;

			if ($reservation->update(array('quantity')) and $item->update(array('available'))) {
				Yii::app()->user->setflash('info', "You have now reserved $new_quantity of this item");
				$this->redirect(array('item/view', 'id'=>$id));
			}
			else{
				Yii::app()->user->setflash('error', 'Something went wrong, please try again');
			}
			$this->redirect($this->createUrl('item/view', array('id'=>$id)));

		}
	}

	public function capitalize_and_pluralize($str, $amount)
	{
		$str = capitalize($str);
		if ($amount < 2) {
			return $amount;
		}
		else{
			return $amount . 's';
		}
	}
	public function capitalize($str)
	{
		$str[0] = strtoupper($str[0]);
		return $str;
	}

	public function validposint($var) {
	    return ((string)(int)$var === $var) and ((int) $var > 0);
	}



	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->layout = 'clearcolumn';
		$reservation = Reservation::model()->findByAttributes(array(
			'user_id'=>Yii::app()->user->id,
			'item_id'=>$id,
			'brought'=>0,
			));
		$this->render('view',array(
			'model'=>$this->loadModel($id),
			'reservation'=>$reservation,
		));
	}




	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$this->layout = "clearcolumn";

		$model=new Item;
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Item']))
		{
			$model->attributes=$_POST['Item'];
			$model->image=CUploadedFile::getInstance($model,'image');
			$filename = "/{$model->image->name}";

			if($model->save()){
				if (!file_exists(Yii::app()->basePath . "/../images/" .$model->id)) {
    				mkdir(Yii::app()->basePath . "/../images/". $model->id, 0777, true);
				}

				$model->image->saveAs(Yii::app()->basePath . "/../images/" . $model->id . $filename);
				$this->redirect(array('view','id'=>$model->id));
			}
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
			$model->image=CUploadedFile::getInstance($model,'image');
			$filename = "/{$model->image->name}";

			if($model->save()){
				if (!file_exists(Yii::app()->basePath . "/../images/" .$model->id)) {
    				mkdir(Yii::app()->basePath . "/../images/". $model->id, 0777, true);
				}
				$model->image->saveAs(Yii::app()->basePath . "/../images/" . $model->id . $filename);
				$this->redirect(array('view','id'=>$model->id)); 
			}
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

	public function actionIndex()
	{
		$this->layout = "column1";
	    $criteria = new CDbCriteria();

	    if(isset($_GET['q']) and $_GET['q']!='')
	    {
	      $q = $_GET['q'];
	      $criteria->compare('name', $q, true, 'OR');
	      $criteria->compare('description', $q, true, 'OR');

	      $dataProvider=new CActiveDataProvider("Item", array('criteria'=>$criteria,
	      	'pagination'=>array(
				'pageSize'=>9,
				)
	      	));
	      Yii::app()->clientScript->registerScript('search', "
			$('#Item_name').val('" . $q . "');

			
			");
	    }
	    else{
	       $dataProvider=new CActiveDataProvider('Item', array(
	       	'pagination'=>array(
				'pageSize'=>9,
			)

	       	));
	    }

		$this->render('index',array(
		  'dataProvider'=>$dataProvider,
		));


	    
	    
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

	public function check_for_existing_reservation($item_id, $user_id)
	{

		$sql = "SELECT * FROM reservation WHERE user_id=:user_id AND item_id=:item_id AND brought=:brought";
		$command = Yii::app()->db->createCommand($sql);
		$command->bindValue(":item_id", $item_id, PDO::PARAM_INT);
		$command->bindValue(":user_id", Yii::app()->user->getId(), PDO::PARAM_INT);
		$command->bindValue(":brought", 0, PDO::PARAM_INT);
		return $command->execute()>=1;

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
