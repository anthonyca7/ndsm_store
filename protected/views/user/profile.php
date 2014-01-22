<h1>My Profile</h1>


<h3>My Items</h3><br>

<?php $this->renderPartial('_items',array(
'items'=>$model->items,
)); ?>


<h1>View User #<?php echo $model->id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
        'data'=>$model,
        'attributes'=>array(
                'id',
                'email',
                'password',
                'status',
                'validation_code',
                'create_time',
                'update_time',
                'last_login',
        ),
)); ?>