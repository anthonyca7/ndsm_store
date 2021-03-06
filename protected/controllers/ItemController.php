<?php

class ItemController extends Controller
{
	public $layout='//layouts/column2';
	private $store = null;
	private $model = null;
	private $user = null;

	public function filters()
	{
		return array(
			array( 'CSDataLoaderFilter', 'loadByName', 'on'=>array( 'view' ) ),
			'accessControl', // perform access control for CRUD operations
			'storeContext',
			'admin + admin create delete update'
		);
	}

	public function accessRules()
	{
		return array(
			array('allow',  
				'actions'=>array('view', 'index'),
				'users'=>array('*'),
			),
			array('allow', 
				'actions'=>array('reserve', 'updatereservation', 'create','delete','admin','update'),
				'users'=>array('@'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}




	private function reserve($id, $quantity)
	{
		$user = User::model()->findByPk(Yii::app()->user->id);

		if (isset($_GET['quantity'])) {
			$quantity = $_GET['quantity'];
		}
		else{
			throw new CHttpException(400, "pass a valid quantity");
		}

		if( isset($model) and ($model->available > 0) and ($model->available >= $quantity) ){
			if($user->status == 1){
				$r_model = new Reservation;
				$r_model->user_id = $user->id;
				$r_model->item_id = $id;
				$r_model->brought = 0;
				$r_model->quantity = $_GET['quantity'];
				$r_model->school_id = $this->store->id;

				if ($r_model->save()) {
					$model->available = $model->available - $quantity;
					$model->update(array('available'));
					Yii::app()->user->setflash('info', "You have reserved {$quantity} items");
				}
				else{
					Yii::app()->user->setflash('error', 'There was an error while attempting to make your reservation');
				}

			}
			else{
				Yii::app()->user->setflash('warning', "You need to validate your email to reserve any item");
				$this->redirect($this->createUrl('item/view', array('name'=>$model->name, 'tag'=>$this->store->unique_identifier)));
			}


		}
		else{
			Yii::app()->user->setflash('error', "Sorry, we don't have {$quantity} {$model->name}s available");
		}

		$this->redirect($this->createUrl('item/view', array('name'=>$model->name, 'tag'=>$this->store->unique_identifier)));

	}

	

	public function actionReserve($id, $quantity, $tag)
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
		$item = $this->loadModel($id);
		if ($reservation === null or !isset($_GET['nq']) or !$this->validposint($_GET['nq'])) {
			if (intval($_GET['nq']) <= 0) {
				Yii::app()->user->setflash('error', 'You need to choose an amount bigger than 0');
			}
			else{
				Yii::app()->user->setflash('error', 'You need to select a valid item');
			}
			$this->redirect($this->createUrl('item/view', array('name'=>$item->name, 'tag'=>$this->store->unique_identifier)));
		}
		else{
			$new_quantity = $_GET['nq'];
			$old_quantity = $reservation->quantity;

			$diff = $new_quantity - $old_quantity;

			$item = $this->loadModel($id);
			$updated_quantity = $item->available - $diff;

			if ($updated_quantity < 0) {
				Yii::app()->user->setflash('warning', 'You tried amount to more than what we have available');
				$this->redirect($this->createUrl('item/view', array('name'=>$item->name, 'tag'=>$this->store->unique_identifier)));
			}

			$reservation->quantity = $new_quantity;
			$item->available -= $diff;

			if ($reservation->update(array('quantity')) and $item->update(array('available'))) {
				Yii::app()->user->setflash('info', "You have now reserved $new_quantity of this item");
				$this->redirect(array('item/view', 'name'=>$item->name, 'tag'=>$this->store->unique_identifier));
			}
			else{
				Yii::app()->user->setflash('error', 'Something went wrong, please try again');
			}
			$this->redirect($this->createUrl('item/view', array('name'=>$item->name, 'tag'=>$this->store->unique_identifier)));
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

	public function actionView($name)
	{
		$this->layout = 'clearcolumn';
		$reservation = Reservation::model()->findByAttributes(array(
			'user_id'=>Yii::app()->user->id,
			'item_id'=>$this->model->id,
			'brought'=>0,
			));
		$this->render('view',array(
			'model'=>$this->model,
			'reservation'=>$reservation,
		));
	}


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
			$model->school_id = $this->store->id;
			
			if($model->save()){
				$filename = "/{$model->image->name}";

				if (!file_exists(Yii::app()->basePath . "/../images/" .$model->id)) {
    				mkdir(Yii::app()->basePath . "/../images/". $model->id, 0777, true);
				}

				$model->image->saveAs(Yii::app()->basePath . "/../images/" . $model->id . $filename);
				$this->redirect(array('item/view','name'=>$model->name));
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
		$this->layout = "clearcolumn";
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Item']))
		{
			$model->attributes=$_POST['Item'];
			$model->image=CUploadedFile::getInstance($model,'image');

			if($model->save()){
				$filename = "/{$model->image->name}";
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
	    $criteria->compare('school_id', $this->store->id, true, 'AND');

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
	       	'criteria'=>$criteria,
	       	'pagination'=>array(
				'pageSize'=>9,
			)

	       	));
	    }

		$this->render('index',array(
		  'dataProvider'=>$dataProvider,
		));
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

	public function filterAdmin($filterChain)
	{
		if (!Yii::app()->user->isGuest) {
			$this->loadstore($_GET['tag']);
			$user = User::model()->with('store')->findByPk(Yii::app()->user->id);
			if ( $user->is_admin and $user->store->id === $this->store->id) {
				$filterChain->run();
				Yii::app()->end();
			}
		}
		throw new CHttpException(403,'Invalid Request');
	}

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

	public function loadModel($id)
	{
		$model=Item::model()->findByPk($id);
		$this->model=$model;
		if($model===null or $model->school_id!==$this->store->id )
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
	public function loadByName(/*$name, $withstore=false*/)
	{
		/*if (!$withstore) {
			$model=Item::model()->findByAttributes(array('name'=>$name));
		}
		else{*/

			$this->model=Item::model()->with("store")->findByAttributes(array('name'=>Yii::app()->request->getParam( 'name' )));			
		//}
		$this->loadstore($_GET['tag']);

		if($this->model===null or $this->model->school_id!==$this->store->id )
			throw new CHttpException(404,'The requested page does not exist....');
		return $this->model;
	}

	private function check_for_existing_reservation($item_id, $user_id)
	{

		$sql = "SELECT * FROM reservation WHERE user_id=:user_id AND item_id=:item_id AND brought=:brought";
		$command = Yii::app()->db->createCommand($sql);
		$command->bindValue(":item_id", $item_id, PDO::PARAM_INT);
		$command->bindValue(":user_id", Yii::app()->user->getId(), PDO::PARAM_INT);
		$command->bindValue(":brought", 0, PDO::PARAM_INT);
		return $command->execute()>=1;

	}

	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='item-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
