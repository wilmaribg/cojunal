<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');
// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
#Configuración de la aplicación
return array(
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    // preloading 'log' component
    'preload' => array('log'),
    'language' => 'es',
    'charset' => 'utf-8',
    'sourceLanguage' => 'es_co',
    // autoloading model and component classes
    'import' => array(
        'application.models.*',
        'application.components.*',
        'ext.giix-components.*',
    ),
    'aliases' => array(
        'xupload' => 'ext.xupload',
    ),
    'behaviors' => array(
        'runEnd' => array(
            'class' => 'application.components.WebApplicationEndBehavior',
        ),
    ),
    'modules' => array(
        // uncomment the following to enable the Gii tool
        'gii' => array(
            'class' => 'system.gii.GiiModule',
            'generatorPaths' => array(
                //'bootstrap.gii'
                'ext.giix-core',
            ),
            'password' => 'imaginamos',
            // If removed, Gii defaults to localhost only. Edit carefully to taste.
            'ipFilters' => array('127.0.0.1', '::1'),
        ),
    ),
    // application components
    'components' => array(
        'localtime' => array(
            'class' => 'LocalTime',
        ),
        'session' => array(
            'timeout' => 3600 * 5,
        ),
        'mobileDetect' => array(
            'class' => 'ext.MobileDetect.MobileDetect'
        ),
        'sendgrid' => array(  
            'class' => 'ext.yii-sendgrid.YiiSendGrid', //path to YiiSendGrid class  
            'username'=>'viviana0317', //replace with your actual username  
            'password'=>'imaginamos0317', //replace with your actual password  
            //alias to the layouts path. Optional  
            //'viewPath' => 'application.views.mail',  
            //wheter to log the emails sent. Optional  
            //'enableLog' => YII_DEBUG, 
            //if enabled, it won't actually send the emails, only log. Optional  
            //'dryRun' => false, 
            //ignore verification of SSL certificate  
            //'disableSslVerification'=>true,
        ),  
        'db' => (YII_DEBUG ? require(dirname(__FILE__) . '/database-developer.php') : require(dirname(__FILE__) . '/database-production.php')),
        'log' => array(
            'class' => 'CLogRouter',
            'routes' => array(
                array(
                    'class' => 'CFileLogRoute',
                    'levels' => 'error, warning',
                ),
            // uncomment the following to show log messages on web pages

            /* array(
              'class'=>'CWebLogRoute',
              ), */
            ),
        ),
    ),
    // application-level parameters that can be accessed
    // using Yii::app()->params['paramName']
    'params' => array(
        // this is used in contact page
        'adminEmail' => 'freddy.alarcon@imaginamos.com.co',
    ),
);
