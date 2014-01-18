<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'user-form',
	'enableAjaxValidation'=>false,
)); ?>

 	<?php $model->password = '' ?>
 	<?php $model->password_repeat = '' ?>
	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldRow($model,'first',array('class'=>'span4','maxlength'=>255)); ?>
	<?php echo $form->textFieldRow($model,'last',array('class'=>'span4','maxlength'=>255)); ?>
	<?php echo $form->textFieldRow($model,'email',array('class'=>'span4','maxlength'=>255)); ?>

	<?php echo $form->passwordFieldRow($model,'password',array('class'=>'span4','maxlength'=>255)); ?>
	<?php echo $form->passwordFieldRow($model,'password_repeat',array('class'=>'span4','maxlength'=>255)); ?>


	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
