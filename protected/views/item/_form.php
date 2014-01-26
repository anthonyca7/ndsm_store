<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'item-form',
	'enableAjaxValidation'=>false,
	'type' => 'horizontal',
	'htmlOptions' => array(
		'enctype' => 'multipart/form-data',
		'class' => 'well'
	), 
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldRow($model,'name',array('class'=>'span4 inline','maxlength'=>255)); ?>

	<?php echo $form->textFieldRow($model,'price',array('class'=>'span4 inline','maxlength'=>9)); ?>

	<?php echo $form->textFieldRow($model,'quantity',array('class'=>'span1 inline', 'value'=>1)); ?>

	<?php echo $form->textFieldRow($model,'available', array('class'=>'span1 inline', 'value'=>1)); ?>

	<?php echo $form->textAreaRow($model,'description',array('rows'=>4, 'cols'=>50, 'class'=>'span8')); ?>

	<?php if ($model->image == null): ?>
		<div class="control-group ">
			<label class="control-label" for="Item_image">Image</label>
			<div class="controls">
				<input id="ytItem_image" value="" name="Item[image]" type="hidden">
				<input class="span4" name="Item[image]" id="Item_image" type="file">
			</div>
		</div>

	<?php else: ?>
		<div class="control-group ">
			<label class="control-label" for="Item_image">
				<div>Current Image</div>
				<img class="span1 pull-right img-polaroid" id="current_image" src="<?php echo Item::getImage($model->id, $model->image); ?>"></img>
			</label>
			<div class="controls">
				<br>
				<br>
				<a rel="drevil" id="change_image">Change Image</a>
			</div>
		</div>
				
	<?php endif ?>


	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
	</div>

<?php $this->endWidget(); ?>

<script type="text/javascript">		
	$(document).ready(function() {
	  	$("[rel=drevil]").popover({
	      placement : 'right', //placement of the popover. also can use top, bottom, left or right
	      html: 'true', //needed to show html of course
	      content : '<div id="popOverBox"><input id="ytItem_image" value="" name="Item[image]" type="hidden"><input class="span4" name="Item[image]" id="Item_image" type="file"></div>' 
		});

		var image_width = $('#current_image').width();
		var image_height = image_width * 0.75;
		var tmargin = image_height * 0.5;

		$('#current_image').css({'height':image_height+'px'});
		$('#change_image').css({'margin-top':tmargin+'px', 'margin-bottom':tmargin+'px' });
	});

	$(window).on("resize", function () {
	    var image_width = $('#current_image').width();
		var image_height = image_width * 0.75;
		var tmargin = image_height * 0.5;

		$('#current_image').css({'height':image_height+'px'});
	}).resize();

	$('#Item_quantity').keyup(function (event) {
		$('#Item_available').val($("#Item_quantity").val());
	});
</script>
