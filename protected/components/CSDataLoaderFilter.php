<?php
/**
 * CSDataLoaderFilter class file.
 *
 * @author Maciej Lizewski (redguy)
 */

/**
 * CSDataLoaderFilter provides data loading features in filters of Controller. Sample use case:
 *
 * class MyController extends Controller {
 *   public $model;
 *
 *	public function filters() {
 *		return array(
 *			array( 'CSDataLoaderFilter', 'loadModel', 'on'=>array( 'action' ) ),
 *			'accessControl',
 *		);
 *	}
 * 
 *	public function accessRules() {
 *		return array(
 *			array( 'allow',
 *				'roles'=>array( 'allowEdit' => array( 'model'=>$this->model ) ),
 *				'actions'=>array( 'action' ),
 *			),
 *			array( 'deny' ),
 *		);
 *	}
 *	
 *	public function loadModel() {
 *		$this->model = Model::model()->findByPk( Yii::app()->request->getParam( 'id' ) );
 *		if( $this->model === null ) {
 *			throw new CHttpException( 404, 'Model not found' );
 *		}
 *	}
 **/
class CSDataLoaderFilter extends CFilter {
	public $method;
	public $on;
	public $except;
	public $data = array();
	
	public function set1( $val ) {
		$this->method = $val;
	}
	
	protected function preFilter( $filterChain ) {
		$action = $filterChain->action->getId();

		//if action is not on list - skip
		if( !empty( $this->on ) && is_array( $this->on ) && !in_array( $action, $this->on ) ) {
			return true;
		}
		
		//if action is on 'except' list - skip
		if( !empty( $this->except ) && is_array( $this->except ) && in_array( $action, $this->except ) ) {
			return true;
		}

		//call loader function
		call_user_func( array( $filterChain->controller, $this->method ), $this->data );

		return true;
	}
}