<?php
$this->breadcrumbs=array(
	'Stores'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Store','url'=>array('index')),
	array('label'=>'Create Store','url'=>array('create')),
	array('label'=>'Update Store','url'=>array('update','id'=>$model->id)),
	array('label'=>'Delete Store','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Store','url'=>array('admin')),
);
?>

<h1>View Store #<?php echo $model->id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'unique_identifier',
		'image',
		'create_user_id',
		'update_user_id',
		'create_time',
		'update_time',
		'approved'
	),
)); ?>
