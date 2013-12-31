<?php
abstract class CustomActiveRecord extends CActiveRecord
{

protected function beforeSave(){
	return parent::beforeSave();
}


public function behaviors()
{
	return array(
		'CTimestampBehavior' => array(
		'class' => 'zii.behaviors.CTimestampBehavior',
		'createAttribute' => 'create_time',
		'updateAttribute' => 'update_time',
		'setUpdateOnCreate' => true,
		),
	);
}
}
