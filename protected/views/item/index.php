<?php
$this->breadcrumbs=array(
	'Items',
);

?>

<h1>Items</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
