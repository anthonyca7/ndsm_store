<?php 
	$image_link = Item::getImage($model->id, $model->image);
?>

<div class="row">
	<div class="span3">
		<a href='<?php echo $image_link; ?>'>
			<img class="img-polaroid block" src='<?php echo $image_link; ?>' >
		</a>
	</div>

	<div class="span9">
		<h2> <?php echo $this->capitalize($model->name); ?> </h2>
		<hr class="no-vmargin">
		<p class="lead"> <?php echo $model->description; ?></p>
		<hr>

		<?php if($model->available != "0"): ?>
			<p class="text-info"><?php echo $model->available . ' ' . $model->name; ?> left<br>
		<?php else: ?>
			<p class="text-info">There are no more <?php echo $model->name ?> left<br>
		<?php endif; ?>
		Price: $<?php echo $model->price; ?></p>
		
		<?php if($reservation === null){ 
	 		$link = Yii::app()->createAbsoluteUrl("item/reserve", array('id'=>$model->id)); 
	 	?>

	 	<form method="get" action="<?php echo $link ?>" id="resform" class="form-horizontal">
			Quantity: 
				<input type="text" name="quantity" id="quantity" class="span1 inline" value="1" />
				<input type="submit" value="Reserve" class="btn btn-primary">
		</form>

		</div>

		<?php }else{ $link = Yii::app()->createAbsoluteUrl("item/updatereservation", array('id'=>$model->id)); ?>
	               
	        You have <?php echo $reservation->quantity ?> reserved<br>

	        
	        Update quantity:
	        <form method="get" action="<?php echo $link ?>" id="resform" class="form-horizontal">
	            <input type="text" name="nq" id="nq" class="span1 inline" />
	            <input type="submit" value="Update Reservation" class="btn btn-primary">
	        </form>
	    </div>
		

		<?php } ?>

</div>

