<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'store-form',
	'enableAjaxValidation'=>false,
	'type' => 'horizontal',
	'htmlOptions' => array(
		'class' => 'well'
	), 
)); ?>

	<?php echo $form->errorSummary($model); ?>

    <p class="lead">Update Store Information</p>

    <?php echo $form->textFieldRow($model,'name',array('class'=>'span4','maxlength'=>255)); ?>

    <?php echo $form->textFieldRow($model,'unique_identifier',array('class'=>'span2','maxlength'=>15)); ?>

	
	<div class="control-group">
        <div class="controls">
            <div class="modal-footer">
                <button class="btn btn-info btn-large pull-left" type="submit" name="yt0">Update</button>
            </div>
        </div>
    </div>

<?php $this->endWidget(); ?>
