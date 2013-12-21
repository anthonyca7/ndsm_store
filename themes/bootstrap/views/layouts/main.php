<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />

    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/styles.css" />
    <link rel="stylesheet" type="text/css" href="css/changes.css">

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>

	<?php Yii::app()->bootstrap->register(); ?>
</head>

<body>

<?php 
    $login_link = 'site/login';
    $this->widget('bootstrap.widgets.TbNavbar', array(
    'type'=>'inverse', // null or 'inverse'
    'brand'=>CHtml::encode(Yii::app()->name),
    'brandUrl'=>'/',
    'collapse'=>true, // requires bootstrap-responsive.css
    'items'=>array(
        array(
            'class'=>'bootstrap.widgets.TbMenu',
            'items'=>array(
                array('label'=>'Logout ('.Yii::app()->user->name.')', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest),
                
                array('label'=>'Settings', 'url'=>'#', 'items'=>array(
                    array('label'=>'Manage Users', 'url'=>array('/user/index')),
                    array('label'=>'About', 'url'=>array('/site/page', 'view'=>'about')),
                	array('label'=>'Contact', 'url'=>array('/site/contact')),
                    '---',
                    array('label'=>'NAV HEADER'),
                    array('label'=>'Separated link', 'url'=>'#'),
                    array('label'=>'One more separated link', 'url'=>'#'),
                ), 'visible'=>!Yii::app()->user->isGuest),
            ),
        ),



        '<form class="navbar-form pull-right form-inline" id="inlineForm" action="' . $login_link . '"method="post">


        <input class="input-medium" name="LoginForm[username]" id="LoginForm_username" maxlength="100" type="text" placeholder="Username" >
        <input class="input-medium" name="LoginForm[password]" id="LoginForm_password" maxlength="100" type="password" placeholder="Password" >   
   
        <button class="btn btn-primary" type="submit" name="yt0">Login</button>     

        </form>',




    	
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
            'success'=>array(
                'block'=>true,
                'fade'=>true,
            ), // success, info, warning, error or danger
        ),
    )); ?>

    <form class="navbar-search pull-right" action="#" >
        <input type="text" class="search-query span8" placeholder="Search" id="search-bar">
    </form>    






	<?php echo $content; ?>

	<div class="clear"></div>


</div><!-- page -->

</body>
</html>
