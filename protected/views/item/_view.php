<?php 
$product_name = $data->name;
$product_name = (strlen($product_name) > 25) ? substr($product_name,0,22).'...' : $product_name;
$link = $this->createUrl("item/view", array("id" => $data->id));  ?>


<div class="span3 well item-view item-well">
	<p class="lead no-vmargin"><a href="<?php echo $link; ?>" rel="tooltip" data-original-title="<?php echo $data->name; ?>"><?php echo $product_name; ?></a></p>
	<a href='<?php echo $link; ?>'>
		<img class="img-polaroid item-image pagination-centered" src='<?php echo Item::model()->getImage($data->id, $data->image) ?>'
		alt="<?php echo $data->name; ?>" >
	</a>	
</div>


<script type="text/javascript">
	$(document).ready(function () {
		var content_width = $('.item-view').width();
		var content_height = content_width * 0.75;
		var image_height = content_height * 0.75;
		var image_width = content_width * 0.95;
		$('.item-view').css({'height':content_height+'px'});
		$('.item-image').css({'height':image_height+'px', 'width':image_width+'px' });
	});

</script>