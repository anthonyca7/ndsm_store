<?php
$this->breadcrumbs=array(
	'Stores'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Store','url'=>array('index')),
	array('label'=>'Manage Store','url'=>array('admin')),
);
?>


<?php echo $this->renderPartial('_rform', array('model'=>$model, 'admin'=>$admin)); ?>

