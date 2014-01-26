<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
        'id'=>'user-form',
        'enableAjaxValidation'=>false,
        'htmlOptions' => array(
        	'class' => 'form-horizontal well'
        ),
)); ?>

        <?php $model->password = '' ?>
        <?php $model->password_repeat = '' ?>
        <?php echo $form->errorSummary($model); ?>

        <div class="control-group">
            <label class="control-label">First Name</label>
            <div class="controls">
                <div class="input-prepend">
                    <span class="add-on"><i class="icon-user"></i></span>
                    <?php echo $form->textField($model,'first', array('class' => 'span4 required')); ?>
                </div>
                <?php /*echo $form->error($model,'first');*/ ?>
            </div>
        </div>

        <div class="control-group">
            <label class="control-label">Last Name</label>
            <div class="controls">
                <div class="input-prepend">
                    <span class="add-on"><i class="icon-user"></i></span>    
                    <?php echo $form->textField($model,'last', array('class' => 'span4 required')); ?>
                </div>
                <?php /*echo $form->error($model,'last');*/ ?>
            </div>
        </div>

        <div class="control-group">
            <label class="control-label">Email</label>
            <div class="controls">
                <div class="input-prepend">
                    <span class="add-on"><i class="icon-envelope"></i></span>
                    <?php echo $form->textField($model,'email', array('class' => 'span4 required', 'id'=>'email')); ?>
                </div>
                <?php /*echo $form->error($model,'email');*/ ?>
            </div>
        </div>

        <div class="control-group">
            <label class="control-label">Username</label>
            <div class="controls">
                <div class="input-prepend">
                    <span class="add-on"><i class="icon-user"></i></span>    
                    <?php echo $form->textField($model,'username', array('class' => 'span4 required', 'id'=>'username' )); ?>
                </div>
                <?php /*echo $form->error($model,'last');*/ ?>
            </div>
        </div>


        <div class="control-group">
            <label class="control-label">Password</label>
            <div class="controls">
                <div class="input-prepend">
                    <span class="add-on"><i class="icon-lock"></i></span>
                	<?php echo $form->passwordField($model,'password', array('class' => 'span4 required')); ?>
                </div>
                <?php /* echo $form->error($model,'password');*/ ?>
            </div>
        </div>


        <div class="control-group">
            <label class="control-label">Confirm Password</label>
            <div class="controls">
                <div class="input-prepend">
                    <span class="add-on"><i class="icon-lock"></i></span>
                    <?php echo $form->passwordField($model,'password_repeat', array('class' => 'span4 required')); ?>
                </div>
                <?php /*echo $form->error($model,'password_repeat');*/ ?>
            </div>
        </div>

        <div class="control-group">
            <div class="controls">
                <?php $label = $model->isNewRecord ? 'Create Account' : 'Update Account'; ?>
                    <button class="btn btn-info btn-large pull-left" type="submit" name="yt0"><?php echo $label; ?></button>
            </div>
        </div>




<?php $this->endWidget(); ?>
