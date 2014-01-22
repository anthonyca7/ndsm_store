<div class="span3 well">
	<a href='<?php echo $this->createUrl("item/view", array("id" => $data->id)) ?>'>
		<img class="img-polaroid block" src='<?php echo Yii::app()->request->baseUrl . "/images/" . $data->id . '/' . $data->image; ?>' >	


</div>