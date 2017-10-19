<?php
define("SECRET_KEY_GOOGLE", "6Ld8JhQUAAAAAPRFhVLPX4ZHUEkvl5qHnftBYgfg");
define("PUBLIC_KEY_GOOGLE", "6Ld8JhQUAAAAAODcw9eZK7mrH1r_RFZ6vN9vJ2hO");
return CMap::mergeArray(
            require(dirname(__FILE__) . '/main.php'), array(
            'theme' => 'default',
            'name' => 'Cojunal',
            'components' => array(
                'user' => array(
                    // enable cookie-based authentication
                    'allowAutoLogin' => true,
                    'loginUrl' => array('site/index'),
                ),
                'errorHandler' => array(
                    // use 'site/error' action to display errors
                    // 'errorAction' => 'site/error',
                    'errorAction' => YII_DEBUG ? null : 'site/error',
                ),
                'urlManager' => array(
                    'urlFormat' => 'path',
                    'showScriptName' => false,
                    'rules' => array(
                        'listado-deudores' => 'dashboard/listDebtor/0',
                        'contact' => 'site/sendContact',
                        'aboutus' => 'site/nosotros',
                        'services' => 'site/servicios',
                        'contactus' => 'site/contacto',
                        'listado-deudores/<q>' => 'dashboard/listDebtor',
                        'list-campaign/<q>' => 'dashboard/listCampaign',
                        'list-campaign' => 'dashboard/listCampaign/0',
                        'database' => 'dashboard/database',
                        'database/<lote>' => 'campaign/lote',
                        'deleteLote/<lote>' => 'campaign/deleteLote',
                        'uploadLote/<lote>' => 'campaign/uploadLote',
                        'secure/iniciar-sesion' => 'secure',
                        'secure/updatePassword' => 'secure/updatePassword',
                        'iniciar-sesion' => 'secure',
                        'iniciar-sesion/errorLogin' => 'secure/errorLogin',
                        'logout' => 'dashboard/logout',
                        'changeIdioma' => 'site/changeIdioma',
                        'wallet/search/<idWallet>' => 'wallet/search',
                        'dashboard/updateType/<idWallet>/<type>' => 'dashboard/updateType',
                        'wallet/getEffects/<idAction>'=>'wallet/getEffects',
                        'wallet/getCities/<idDepartment>'=>'wallet/getCities',
                        'wallet/getManagementPdf/<idWallet>'=>'wallet/getManagementPdf',
                        'formatos/getFormatPdf/<idWallet>'=>'formatos/getFormatPdf',
                        'formatos/getFormatCPdf/<idWallet>'=>'formatos/getFormatCPdf',
                        'formatos/getFormatSPdf/<idWallet>'=>'formatos/getFormatSPdf',
                        'wallet/deleteDemographic/<idDemographic>'=>'wallet/deleteDemographic',
                        'campaign/getManagementPdf/<idWallet>'=>'campaign/getManagementPdf',
                        array('wallet/save', 'pattern'=>'wallet:\w+', 'verb'=>'POST'),
                        array('site/sendContact', 'pattern'=>'contact:\w+', 'verb'=>'POST'),
                        array('wallet/saveInfo', 'pattern'=>'wallet:\w+', 'verb'=>'POST'),
                        array('wallet/saveAsset', 'pattern'=>'wallet:\w+', 'verb'=>'POST'),
                        array('wallet/saveDemographicPhone', 'pattern'=>'wallet:\w+', 'verb'=>'POST'),
                        array('wallet/saveSupport', 'pattern'=>'wallet:\w+', 'verb'=>'POST'),
                        array('wallet/saveFinantial', 'pattern'=>'wallet:\w+', 'verb'=>'POST'),
                        'support/filter' => 'supports/filter',
                        'dashboard/listDebtorByAttribute/<attribute>/<id>/<q>'=>'dashboard/listDebtorByAttribute',
                        'dashboard/listDebtorByAttributeCampaign/<attribute>/<id>/<q>'=>'dashboard/listDebtorByAttributeCampaign',
                        'campaign/search/<idWallet>' => 'campaign/search',
                        'campaign' =>'campaign/report',
                        array('campaign/saveComment', 'pattern'=>'wallet:\w+', 'verb'=>'POST'),
                        array('campaign/updateComment', 'pattern'=>'wallet:\w+', 'verb'=>'POST'),
                        array('campaign/masiveData', 'pattern'=>'campaign/masiveData:\w+', 'verb'=>'POST'),
                        '<controller:\w+>/<id:\d+>' => '<controller>/view',
                        '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                        '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
                    ),
                ),
                'log' => array(
                    'class' => 'CLogRouter',
                    'routes' => array(
                        array(
                            'class' => 'CFileLogRoute',
                            'levels' => 'error, warning',
                        ),
                    // uncomment the following to show log messages on web pages


                    // array(
                    //   'class'=>'CWebLogRoute',
                    //   ), 
                    ),
                ),
            )
    )
);
?>