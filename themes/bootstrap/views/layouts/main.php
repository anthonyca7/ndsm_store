<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />

    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/styles.css" />

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>

	<?php Yii::app()->bootstrap->register(); ?>
</head>

<body>

<?php $this->widget('bootstrap.widgets.TbNavbar', array(
    'type'=>'inverse', // null or 'inverse'
    'brand'=>CHtml::encode(Yii::app()->name),
    'brandUrl'=>'/',
    'collapse'=>true, // requires bootstrap-responsive.css
    'items'=>array(
        array(
            'class'=>'bootstrap.widgets.TbMenu',
            'items'=>array(
                array('label'=>'Login', 'url'=>array('/site/login'), 'visible'=>Yii::app()->user->isGuest),
                array('label'=>'Logout ('.Yii::app()->user->name.')', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest),
                array('label'=>'Manage Users', 'url'=>array('/user/index')),
                
                /* 'visible'=>Yii::app()->user->status===0,*/
                /*array('label'=>'Dropdown', 'url'=>'#', 'items'=>array(
                    array('label'=>'About', 'url'=>array('/site/page', 'view'=>'about')),
                	array('label'=>'Contact', 'url'=>array('/site/contact')),
                    array('label'=>'Something else here', 'url'=>'#'),
                    '---',
                    array('label'=>'NAV HEADER'),
                    array('label'=>'Separated link', 'url'=>'#'),
                    array('label'=>'One more separated link', 'url'=>'#'),
                )),*/
            ),
        ),
        '<form class="navbar-search pull-right form-inline" id="inlineForm" action="/ndsm_store/" method="post">     
        <input class="input-xlarge" name="Item[name]" id="Item_name" maxlength="255" type="text">   
        <button class="btn" type="submit" name="yt0">Search</button>     
        </form>',


    	array(
            'class'=>'bootstrap.widgets.TbMenu',
            'htmlOptions'=>array('class'=>'pull-right'),
            'items'=>array(
                	array('label'=>'Options', 'url'=>'#', 'items'=>array(
                    array('label'=>'Action', 'url'=>'#'),
                    array('label'=>'Another action', 'url'=>'#'),
                    array('label'=>'Something else here', 'url'=>'#'),
                    '---',
                    array('label'=>'Separated link', 'url'=>'#'))),

             	),
            ),
    ),
)); ?>


        '<form class="navbar-search pull-left" action=""><input type="text" class="search-query span2" placeholder="Search"></form>',


<div class="container" id="page"> 
     <?php if(isset($this->breadcrumbs)):?>
        <?php $this->widget('bootstrap.widgets.TbBreadcrumbs', array(
            'links'=>$this->breadcrumbs,
        )); ?><!-- breadcrumbs -->
    <?php endif?> 
    <?php $item = Item::model()?>
    <?php /** @var BootActiveForm $form */
    /*$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
        'id'=>'inlineForm',
        'type'=>'inline',
        'htmlOptions'=>array('class' => 'navbar-search pull-right'),
    )); ?>
     
    <?php echo $form->textFieldRow($item, 'name', array('class'=>'input-xxlarge')); ?>
    <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'label'=>'Search')); ?>
     
    <?php $this->endWidget(); */ ?>

	  

	<?php echo $content; ?>

	<div class="clear"></div>
<!-- 
	<div id="footer">
		Copyright &copy; <?php echo date('Y'); ?> by My Company.<br/>
		All Rights Reserved.<br/>
		<?php echo Yii::powered(); ?>
	</div> --><!-- footer -->

</div><!-- page -->

</body>
</html>
