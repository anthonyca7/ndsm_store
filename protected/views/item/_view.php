<div class="span3 well item-view item-well">
	<p class="lead no-vmargin"><?php echo Item::capitalize($data->name) ?></p>
	<a href='<?php echo $this->createUrl("item/view", array("id" => $data->id)) ?>'>
		<img class="img-polaroid item-image pagination-centered" src='<?php echo Item::model()->getImage($data->id, $data->image) ?>' >
	</a>	
</div>

<?php //$string = (strlen($string) > 50) ? substr($string,0,47).'...' : $string; ?>
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