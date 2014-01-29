<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController
{

	public $layout='//layouts/column1';

	public $menu=array();
	
	public $breadcrumbs=array();

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

}