<?php 
	//$banner_path = Yii::app()->basePath.'/images/lndms.png';
	//$banner = Yii::app()->assetManager->publish($banner_path); 
	//echo '<img src=images/lndms.png height=50px>'
	
    $this->widget('bootstrap.widgets.TbCarousel', array(
	'slide'=>true,
    'items'=>array(
        array('image'=>'images/lndms.png', 'imageOptions'=>array('width'=>'600', 'height'=>'400' ) ),
        array('image'=>'images/picture1.jpeg',  'imageOptions'=>array('width'=>'600', 'height'=>'200' )  ),
        array('image'=>'images/picture2.jpg',  'imageOptions'=>array('width'=>'600', 'height'=>'200' )  ),
    ),
    'htmlOptions' => array('style'=>"width: 500px; height: 200px; display:inline", 'class'=>'span8'),
)); ?>

<?php
/*
    The most frequently brought items has to be shown
    Recommended items for the user


*/


?>
<div class="cor-text span6">

<div class="pt">
<h1>Find all school supplies you need</h1>
<h3>This page contains all the item supplies that the school has available</h3>
</div>

<div class="pt">
<h1>It is easy to get started</h1>
<h3>Just search for the item that you need, reserve it and then just pick up before two weeks.</h3>
</div>


</div>













































<?php
/* @var $this SiteController */

/*$this->pageTitle=Yii::app()->name;
?>

<?php $this->beginWidget('bootstrap.widgets.TbHeroUnit',array(
    'heading'=>'Welcome to '.CHtml::encode(Yii::app()->name),
)); ?>

<p>This the main Page for the NDMS Store.</p>

<?php $this->endWidget(); ?>



<?php $this->widget('bootstrap.widgets.TbButton', array(
    'label'=>'Primary',
    'type'=>'primary', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
    'size'=>'large', // null, 'large', 'small' or 'mini'
));*/ ?>


