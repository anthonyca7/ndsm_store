<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'store-form',
	'enableAjaxValidation'=>false,
	'type' => 'horizontal',
	'htmlOptions' => array(
		'class' => 'well'
	), 
)); ?>

	<?php echo $form->errorSummary($model); ?>
	<?php echo $form->errorSummary($admin); ?>

    <p class="lead">Enter Store Information</p>

    <?php echo $form->textFieldRow($model,'name',array('class'=>'span4','maxlength'=>255)); ?>

    <?php echo $form->textFieldRow($model,'unique_identifier',array('class'=>'span2','maxlength'=>15)); ?>

    <?php //create user and user_id and image?>

	<p class="lead">Create Your Admin Account</p>
	<div class="control-group">
            <label class="control-label">First Name</label>
            <div class="controls">
                <div class="input-prepend">
                    <span class="add-on"><i class="icon-user"></i></span>
                    <?php echo $form->textField($admin,'first', array('class' => 'span4 required')); ?>
                </div>
                <?php /*echo $form->error($admin,'first');*/ ?>
            </div>
        </div>

        <div class="control-group">
            <label class="control-label">Last Name</label>
            <div class="controls">
                <div class="input-prepend">
                    <span class="add-on"><i class="icon-user"></i></span>    
                    <?php echo $form->textField($admin,'last', array('class' => 'span4 required')); ?>
                </div>
                <?php /*echo $form->error($admin,'last');*/ ?>
            </div>
        </div>

        <div class="control-group">
            <label class="control-label">Email</label>
            <div class="controls">
                <div class="input-prepend">
                    <span class="add-on"><i class="icon-envelope"></i></span>
                    <?php echo $form->textField($admin,'email', array('class' => 'span4 required', 'id'=>'email')); ?>
                </div>
                <?php /*echo $form->error($admin,'email');*/ ?>
            </div>
        </div>

        <div class="control-group">
            <label class="control-label">Username</label>
            <div class="controls">
                <div class="input-prepend">
                    <span class="add-on"><i class="icon-user"></i></span>    
                    <?php echo $form->textField($admin,'username', array('class' => 'span4 required', 'id'=>'username' )); ?>
                </div>
                <?php /*echo $form->error($admin,'last');*/ ?>
            </div>
        </div>


        <div class="control-group">
            <label class="control-label">Password</label>
            <div class="controls">
                <div class="input-prepend">
                    <span class="add-on"><i class="icon-lock"></i></span>
                    <?php echo $form->passwordField($admin,'password', array('class' => 'span4 required')); ?>
                </div>
                <?php /* echo $form->error($admin,'password');*/ ?>
            </div>
        </div>


        <div class="control-group">
            <label class="control-label">Confirm Password</label>
            <div class="controls">
                <div class="input-prepend">
                    <span class="add-on"><i class="icon-lock"></i></span>
                    <?php echo $form->passwordField($admin,'password_repeat', array('class' => 'span4 required')); ?>
                </div>
                <?php /*echo $form->error($admin,'password_repeat');*/ ?>
            </div>
        </div>

	<div class="control-group">
        <div class="controls">
            <div class="modal-footer">
                <button class="btn btn-info btn-large pull-left" type="submit" name="yt0">Register</button>
            </div>
        </div>
    </div>

<?php $this->endWidget(); ?>
