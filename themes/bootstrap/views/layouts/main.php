<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />


    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/styles.css" />
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>

	<?php Yii::app()->bootstrap->register(); 

      $baseUrl = Yii::app()->baseUrl;
      $cs = Yii::app()->getClientScript();
      //$cs->registerScriptFile($baseUrl . '/js/jsfile');
      $cs->registerCssFile($baseUrl.'/css/changes.css');
    ?>

</head>

<body>

<?php 
    $current_controller =  Yii::app()->controller->id;
    $current_action =  Yii::app()->controller->action->id;
    $actions_without_search = array("login", "register", "create");
    $login_form = (Yii::app()->user->isGuest and !in_array($current_action, $actions_without_search) ) ?
     '<form class="navbar-form pull-right form-inline" id="inlineForm" action="site/login" method="post">


        <input class="input-medium" name="LoginForm[username]" id="LoginForm_username" maxlength="100" type="text" placeholder="Username" >
        <input class="input-medium" name="LoginForm[password]" id="LoginForm_password" maxlength="100" type="password" placeholder="Password" >   
   
        <button class="btn btn-primary" type="submit" name="yt0">Login</button>     

        </form>' : '';
    $page_errors = !isset(Yii::app()->errorHandler->error);

    //Yii::app()->urlManager->parseUrl(Yii::app()->request) ;
    $this->widget('bootstrap.widgets.TbNavbar', array(
    'type'=>'inverse', // null or 'inverse'
    'brand'=>CHtml::encode(Yii::app()->name),
    'brandUrl'=>'/',
    'collapse'=>true, // requires bootstrap-responsive.css
    'items'=>array(
        array(
            'class'=>'bootstrap.widgets.TbMenu',
            'htmlOptions' => array('class' => 'pull-right'),
            'items'=>array(
                array('label'=>'Logout ('.Yii::app()->user->name.')', 'url'=>array('/site/logout'), 
                    'visible'=>!Yii::app()->user->isGuest),
                    array('label'=>'Register', 'url'=>array('/user/register'), 
                        'visible'=>Yii::app()->user->isGuest and !in_array($current_action, $actions_without_search)),
                    /*array('label'=>'Settings', 'url'=>'#', 'class'=>'pull-right', 'items'=>array(
                    array('label'=>'Manage Users', 'url'=>array('/user/index')),
                    array('label'=>'About', 'url'=>array('/site/page', 'view'=>'about')),
                	array('label'=>'Contact', 'url'=>array('/site/contact')),
                    '---',
                    array('label'=>'NAV HEADER'),
                    array('label'=>'Separated link', 'url'=>'#'),
                    array('label'=>'One more separated link', 'url'=>'#'),
                ), 'visible'=>!Yii::app()->user->isGuest),*/
                //array('label'=>'Profile'),
            ),
        ),

        $login_form,
    	
    ),
)); ?>




<div class="container" id="page"> 
     <?php if(isset($this->breadcrumbs)):?>
        <?php $this->widget('bootstrap.widgets.TbBreadcrumbs', array(
            'links'=>$this->breadcrumbs,
        )); ?><!-- breadcrumbs -->
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

    <?php
    /*$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
        'id'=>'searchForm',
        'type'=>'search',
        'htmlOptions'=>array('class'=>'well pull-right'),
    )); 
     
    echo $form->textFieldRow(Item::model(), 'name', array('class'=>'input-xxlarge', 'placeholder' => 'search', 'prepend'=>'<i class="icon-search"></i>')); 
    $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'label'=>'Search')); 
    $this->endWidget(); */
    
    if ( !in_array($current_action, $actions_without_search) and $page_errors ) {
        echo '<form class="well pull-right form-search" id="searchForm" action="/item" method="get"  >
            <div class="input-prepend">
                <span class="add-on"><i class="icon-search"></i></span>
                <input class="input-xxlarge" placeholder="Search" name="q" id="Item_name" maxlength="255" type="text">
            </div>
            <button class="btn btn-primary" type="submit">Search</button>
        </form>
        <br><br><br><br><br>';
    }

    ?>


	<?php echo $content; ?>

	<div class="clear"></div>


</div><!-- page -->

</body>
</html>
