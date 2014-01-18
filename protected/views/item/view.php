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
 	
 	if($reservation === null){ 
 		$link = Yii::app()->createAbsoluteUrl("item/reserve", array('id'=>$model->id)); 
 	?>
	
	<form method="get" action="<?php echo $link ?>">
		Quantity: <input type="text" name="quantity" id="quantity" class="span1" />
				  <input type="submit" value="Reserve" class="btn btn-primary">
	</form>

<?php }else{ 
			$link = Yii::app()->createAbsoluteUrl("item/updatereservation", array('id'=>$model->id));
		?>
		You have <?php echo $reservation->quantity ?> reserved<br>
		Update quantity: 
		<form method="get" action="<?php echo $link ?>">
			<input type="text" name="nq" id="nq" class="span1" />
			<input type="submit" value="Update Reservation" class="btn btn-primary">
		</form>

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
