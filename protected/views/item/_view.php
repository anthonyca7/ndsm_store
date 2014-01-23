<div class="span3 well item-view item-well">
	<p class="lead no-vmargin"><?php echo Item::capitalize($data->name) ?></p>
	<a href='<?php echo $this->createUrl("item/view", array("id" => $data->id)) ?>'>
		<img class="img-polaroid item-image pagination-centered" src='<?php echo Item::model()->getImage($data->id, $data->image) ?>' >
	</a>	
</div>
