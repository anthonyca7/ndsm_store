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

<h1><?php echo $this->capitalize($model->name); ?></h1>
<?php 
	$link = Yii::app()->createAbsoluteUrl("item/reserve", array('id'=>$model->id));
 	
 	if(!$this->check_for_existing_reservation($model->id, Yii::app()->user->id)){  ?>
	
	<form method="get" action="<?php echo $link ?>">
		Quantity: <input type="text" name="quantity" id="quantity" class="span1" />
				  <input type="submit" value="Reserve">
	</form>

<?php }else{ ?>
	You have already reserved this item

<?php } ?>
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
