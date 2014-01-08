<?php
$this->breadcrumbs=array(
	'Items'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List Item','url'=>array('index')),
	array('label'=>'Create Item','url'=>array('create')),
	array('label'=>'Reserve', 'url'=>array('item/reserve', 'id'=>$model->id, 'quantity'=>1)),
	array('label'=>'Update Item','url'=>array('update','id'=>$model->id)),
	array('label'=>'Delete Item','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Item','url'=>array('admin')),
);
?>

<h1><?php echo $model->name; ?></h1>

<?php echo CHtml::link('Reserve', array('item/reserve', 'id'=>$model->id, 'quantity'=>1)); ?>
<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'name',
		'price',
		'quantity',
		'description',
		'available',
	),
)); ?>
