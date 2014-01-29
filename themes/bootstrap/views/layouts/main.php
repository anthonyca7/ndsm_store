<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />
    <link rel="shortcut icon" href='<?php echo Yii::app()->baseUrl . "/images/favicon.ico"; ?>' type="image/x-icon" />

    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/styles.css" />
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>

	<?php Yii::app()->bootstrap->register(); 

      $baseUrl = Yii::app()->baseUrl;
      $cs = Yii::app()->getClientScript();
      $cs->registerCssFile(Yii::app()->theme->baseUrl . '/css/changes.css');
      $cs->registerScriptFile(Yii::app()->theme->baseUrl . '/js/custom.js');
    ?>

</head>

<body>

<?php     

    $login_form = (Yii::app()->user->isGuest ) ?
     '<form class="navbar-form pull-right form-inline" id="inlineForm" action="' . Yii::app()->createAbsoluteUrl('site/login') . '" method="post">


        <input class="input-medium" name="LoginForm[username]" id="LoginForm_username" maxlength="100" type="text" placeholder="Username" >
        <input class="input-medium" name="LoginForm[password]" id="LoginForm_password" maxlength="100" type="password" placeholder="Password" >   
   
        <button class="btn btn-primary" type="submit" name="yt0">Login</button>     

        </form>' : '';
    $page_errors = !isset(Yii::app()->errorHandler->error);

    $this->widget('bootstrap.widgets.TbNavbar', array(
    'type'=>'inverse', // null or 'inverse'
    'brand'=>CHtml::encode(Yii::app()->name),
    'brandUrl'=>Yii::app()->createAbsoluteUrl(''),
    'collapse'=>true, // requires bootstrap-responsive.css
    'items'=>array(
        array(
            'class'=>'bootstrap.widgets.TbMenu',
            'htmlOptions' => array('class' => 'pull-right'),
            'items'=>array(
                array('label'=>'Logout ('.Yii::app()->user->name.')', 'url'=>array('/site/logout'), 
                    'visible'=>!Yii::app()->user->isGuest),
                    
            ),
        ),

        $login_form,
    	
    ),
)); ?>




<div class="container" id="page"> 
     <?php if(isset($this->breadcrumbs)):?>
        <?php /*$this->widget('bootstrap.widgets.TbBreadcrumbs', array(
            'links'=>$this->breadcrumbs,
        ));*/ ?><!-- breadcrumbs -->
    <?php endif?> 

    <?php 


    $this->widget('bootstrap.widgets.TbAlert', array(
        'block'=>true, // display a larger alert block?
        'fade'=>true, // use transitions?
        'closeText'=>'&times;', // close link text - if set to false, no close link is displayed
        'alerts'=>array( // configurations per alert type
            // success, info, warning, error or danger
            'success'=>array(
                'block'=>true,
                'fade'=>true,
            ), 
            'warning'=>array(
                'block'=>true,
                'fade'=>true,
            ), 
            'info'=>array(
                'block'=>true,
                'fade'=>true,
            ), 
            'error'=>array(
                'block'=>true,
                'fade'=>true,
            ), 
            'danger'=>array(
                'block'=>true,
                'fade'=>true,
            ), 
        ),
    )); ?>

    <?php if ($page_errors):  ?>

    <form class="well pull-right offset5 span7 form-search input-prepend" id="searchForm" action="<?php echo Yii::app()->createUrl('item/index') ?>" method="get"  >    
        <div class="row-fluid">
            <div class="span12">
                <span class="add-on"><i class="icon-search"></i></span>
                <input class="input-search" placeholder="Search" name="q" id="Item_name" maxlength="255" type="text">
                <button class="btn btn-primary" type="submit">Search</button>                   
            </div>
        </div>
    </form>

    <?php endif; ?>


	<?php echo $content; ?>

	<div class="clear"></div>


</div>

</body>
</html>
