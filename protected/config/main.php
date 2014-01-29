<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.

// $mysql_host = "mysql12.000webhost.com";
// $mysql_database = "a1160700_admin";
// $mysql_user = "a1160700_admin";
// $mysql_password = "admin1";

Yii::setPathOfAlias('bootstrap', dirname(__FILE__).'/../extensions/bootstrap');

return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'NDMS Store',
	'theme'=>'bootstrap',

	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
	),

	'modules'=>array(
		// uncomment the following to enable the Gii tool
		
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>false,
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
			'generatorPaths'=>array(
                'bootstrap.gii',
            ),
		),
		
	),

	// application components
	'components'=>array(
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
		),
		// uncomment the following to enable URLs in path-format
		
		'urlManager'=>array(
			'urlFormat'=>'path',
			'showScriptName'=>false,
			'rules'=>array(
				''=>'store/homepage',
				'<tag:\w+>/register' => 'user/register',
				'profile/<id:\d+>' => 'user/profile',
				'<tag:\w+>/reserve/<id:\d+>' => 'item/reserve',
				'<tag:\w+>/<controller:user>/<id:\d+>/<code:\w+>'=>'<controller>/validate',
				'<tag:\w+>/updatereservation/<id:\d+>' => 'item/updatereservation',
				'<tag:\w+>/<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<tag:\w+>/<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<tag:\w+>/<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),

		
		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=s3',
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => 'root',
			'charset' => 'utf8',
		),
		
		/*'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=schoolstores_zxq_admin',
			'emulatePrepare' => true,
			'username' => '897704_admin',
			'password' => 'admin',
			'charset' => 'utf8',
		),*/

		/*'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=s2',
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => 'root',
			'charset' => 'utf8',
		),*/

		//$mysql_host = "mysql12.000webhost.com";
		// $mysql_database = "a1160700_admin";
		// $mysql_user = "a1160700_admin";
		// $mysql_password = "admin1";

		/*'db'=>array(
        'tablePrefix'=>'',
        'connectionString' => 'pgsql:host=64.62.211.131;port=5432;dbname=acc7_admin',
        'username'=>'acc7_admin',
        'password'=>'admin',
        'charset'=>'UTF8',
		),*/

		/*'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=acc7_s2',
			'emulatePrepare' => true,
			'username' => 'acc7_admin',
			'password' => 'admin',
			'charset' => 'utf8',
		),*/
		
		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'site/error',
		),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
				// uncomment the following to show log messages on web pages
				/*
				array(
					'class'=>'CWebLogRoute',
				),
				*/
			),
		),
		
		

		'bootstrap'=>array(
            'class'=>'bootstrap.components.Bootstrap',
        ),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'anthonyca7@newdesignmiddle.org',
		'maindir'=> 'http://storendms.heliohost.org',
		//<link rel="stylesheet" type="text/css" href="http://storendms.heliohost.org//css/changes.css">
	),
);