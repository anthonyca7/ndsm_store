<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('first')); ?>:</b>
	<?php echo CHtml::encode($data->first); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('last')); ?>:</b>
	<?php echo CHtml::encode($data->last); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id),array('view','id'=>$data->id)); ?>
	<br />

	<?php if (isset($data->school_id)): ?>
		<b><?php echo CHtml::encode($data->getAttributeLabel('school_id')); ?>:</b>
		<?php echo CHtml::link(CHtml::encode($data->id),array('view','id'=>$data->store->name)); ?>
		<br />	
	<?php endif ?>

	<b><?php echo CHtml::encode($data->getAttributeLabel('email')); ?>:</b>
	<?php echo CHtml::encode($data->email); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('password')); ?>:</b>
	<?php echo CHtml::encode($data->password); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('status')); ?>:</b>
	<?php echo CHtml::encode($data->status); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('create_time')); ?>:</b>
	<?php echo CHtml::encode($data->create_time); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('update_time')); ?>:</b>
	<?php echo CHtml::encode($data->update_time); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('last_login')); ?>:</b>
	<?php echo CHtml::encode($data->last_login); ?>
	<br />

	<?php echo CHtml::encode($data->validation_code); ?>
	<br /><br />




</div>