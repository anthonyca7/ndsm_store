<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'item-form',
	'enableAjaxValidation'=>false,
	'htmlOptions' => array('enctype' => 'multipart/form-data', ),
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldRow($model,'name',array('class'=>'span4','maxlength'=>255)); ?>

	<?php echo $form->textFieldRow($model,'price',array('class'=>'span4','maxlength'=>9)); ?>

	<?php echo $form->textFieldRow($model,'quantity',array('class'=>'span1')); ?>

	<?php echo $form->textFieldRow($model,'available', array('class'=>'span1')); ?>

	<?php echo $form->textAreaRow($model,'description',array('rows'=>4, 'cols'=>50, 'class'=>'span8')); ?>

	<?php echo $form->labelEx($model, 'image');
	echo $form->fileField($model, 'image');
	echo $form->error($model, 'image'); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
