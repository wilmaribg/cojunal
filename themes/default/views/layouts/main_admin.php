<?php
$this->Widget('ext.yii-toast.ToastrWidget');
Yii::app()->clientScript->registerCoreScript('jquery');
Yii::app()->clientScript->registerCoreScript('jquery.ui');
Yii::app()->bootstrap->registerAssetJs("bootstrap-button.js", CClientScript::POS_HEAD);
Yii::app()->bootstrap->registerAssetJs("bootstrap-modal.js", CClientScript::POS_HEAD);
$base = Yii::app()->request->baseUrl;
/* @var $this Controller */ 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <meta name="language" content="es" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <title><?php echo CHtml::encode($this->pageTitle); ?></title>
        <script src="<?php echo $base; ?>/js/oLoader/js/jquery.oLoader.min.js"></script>
        <link rel="shortcut icon" type="image/x-icon" href="<?php echo $base; ?>/imaginamos.ico"/>
        <link href="<?php echo $base; ?>/imaginamos.ico" rel="icon" type="image/x-icon" />
        <link href="<?php echo $base; ?>/css/chosen.min.css" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" type="text/css" href="<?php echo $base; ?>/css/form.css" />
        <link href="<?php echo $base; ?>/css/cms.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript">
            var pathurl = '<?php echo $base; ?>/';
            var csrfToken = '<?php echo Yii::app()->request->csrfToken ?>';
            $(function(){
                $.oPageLoader();
                $('.bootstrap-widget-content img').oLoader({
                    waitLoad: true,
                    fadeLevel: 0.9,
                    backgroundColor: '#fff',
                    style:0,
                    image: pathurl + '/js/oLoader/images/ownageLoader/loader5.gif'
                });
            });
        </script>
        <script type="text/javascript" src="<?php echo $base; ?>/js/chosen.jquery.min.js"></script>
        <script type="text/javascript" src="<?php echo $base; ?>/js/admin.js"></script>
        <?php require 'javascriptPrototipesUtilities.php' ?>
    </head>
    <body data-spy="scroll" data-target=".bs-docs-sidebar">
        <?php
            if ($this->validateAccess()):
                $modelmenu = CmsMenu::model()->findAll(array('condition'=>'visible=1'.$this->getFilterMenu(), 'order'=>'titulo'));
        ?>
        <div class="navbar navbar-inverse navbar-fixed-top">
            <div class="navbar-inner">
                <div class="container">
                    <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </a>
                    <a class="brand" target="_blank" href="http://www.imaginamos.com"><img style="height: 24px; margin-left: 5px;" alt="Ver sitio" src="<?php echo $base; ?>/img/logo_admin.png" /></a>
                    <div class="nav-collapse collapse">
                        <ul class="nav pull-left">
                            <li><a style="cursor: pointer;" class="btn-login"><strong title="Perfil">Hola, <?php echo Yii::app()->user->getState('title'); ?></strong></a></li>
                            <?php
                                if($this->menu != null):
                            ?>
                            <li class="divider-vertical"></li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                   <b class="label label-important">Operaciones</b> <b class="caret"></b>
                                </a>
                                <?php
                                    $this->widget('zii.widgets.CMenu', array(
                                            'items'=>$this->menu,
                                            'encodeLabel'=>false,
                                            'htmlOptions'=>array('class'=>'dropdown-menu'),
                                    ));
                                ?>
                            </li>
                            <?php 
                                endif;
                            ?>
                            <li class="divider-vertical"></li>
                        </ul>
                        <ul class="nav pull-right">
                            <?php if ($this->validateAccess(array('admin'), 'admin')) { ?>
                            <li class="divider-vertical"></li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                   <b>Administración</b> <b class="caret"></b>
                                </a>
                                <ul class="dropdown-menu menu-barra">
                                    <li><a menu="cmsMenu" href="<?php echo $this->createUrl('cmsMenu/admin'); ?>"><i class="icon-tasks"></i> <b title="(Desarrolladores)">Menús</b></a></li>
                                    <li class="divider"></li>
                                    <li><a menu="cmsConfiguracion" href="<?php echo $this->createUrl('cmsConfiguracion/update', array('id'=>1)); ?>"><i class="icon-wrench"></i> <b title="(Desarrolladores)">Configurar Sitio</b></a></li>
                                    <li class="divider"></li>
                                    <li><a menu="cmsUsuario" href="<?php echo $this->createUrl('cmsUsuario/admin'); ?>"><i class="icon-user"></i> <b>Usuarios</b></a></li>
                                    <li class="divider"></li>
                                    <li><a menu="cmsRol" href="<?php echo $this->createUrl('cmsRol/admin'); ?>"><i class="icon-cog"></i> <b title="(Desarrolladores)">Roles</b></a></li>
                                    <li class="divider"></li>
                                    <li><a menu="cmsPermissionRol" href="<?php echo $this->createUrl('cmsPermissionRol/admin'); ?>"><i class="icon-warning-sign"></i> <b title="(Desarrolladores)">Permisos para Roles</b></a></li>
                                    <li class="divider"></li>
                                    <li><a menu="cmsHelp" href="<?php echo $this->createUrl('cmsHelp/admin'); ?>"><i class="icon-question-sign"></i> <b>Ayuda</b></a></li>
                                </ul>
                            </li>
                            <?php } ?>
                            <li class="divider-vertical"></li>
                            <li><a href="<?php echo $this->createUrl('site/index'); ?>" target="_blank"><b>Ver Sitio</b> <i class="icon-globe"></i></a></li>
                            <li class="divider-vertical"></li>
                            <li><a href="<?php echo $this->createUrl('cms/logout'); ?>"><div class="logout" title="Clic"><b>Salir</b> <i class="icon-off"></i></div></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row-fluid">
                <div class="span2">
                    <div>
                        <?php echo CHtml::dropDownList('busquedad_menu','', CHtml::listData($modelmenu , 'url', 'titulo'), array('empty'=>'Buscar Menú...', 'style'=>'width:100%')) ?>
                    </div>
                    <div class="well">
                        <ul class="nav nav-list menu-left">
                            <?php
                                unset($modelmenu);
                                $modelmenu = CmsMenu::model()->findAll(array('order'=>'orden','condition'=> 'visible=1 AND cms_menu_id is null'.$this->getFilterMenu()));
                                foreach ($modelmenu as $value):
                                    $submenu = CmsMenu::model()->findAll(array('order'=>'orden','condition'=> 'visible=1 AND cms_menu_id='.$value->idcmsmenu.$this->getFilterMenu()));
                                    if($submenu == null):
                            ?>
                                <li><a menu="<?php echo substr($value->url, 0,strlen($value->url) - strlen(strstr($value->url,"/"))) ; ?>" href="<?php echo $this->createUrl($value->url); ?>"> <i class="<?php echo $value->icono; ?>"></i> <?php echo $value->titulo; ?></a></li>
                                <li class="divider"></li>
                            <?php
                                    else:
                            ?>
                                <li class="dropdown">
                                    <a menu="<?php echo substr($value->url, 0,strlen($value->url) - strlen(strstr($value->url,"/"))) ; ?>" href="#" data-toggle="dropdown" class="dropdown-toggle"><i class="<?php echo $value->icono; ?>"></i> <?php echo $value->titulo; ?><b class="caret"></b></a>
                                    <ul class="dropdown-menu">
                                        <?php if($value->visible_header == 1): ?>
                                        <li class="well well-small"><a menu="<?php echo substr($value->url, 0,strlen($value->url) - strlen(strstr($value->url,"/"))) ; ?>" href="<?php echo $this->createUrl($value->url); ?>"> <i class="<?php echo $value->icono; ?>"></i> <?php echo $value->titulo; ?></a></li>
                                        <?php endif; ?>
                                        <li class="divider"></li>
                                        <?php
                                            foreach ($submenu as $value2):
                                                $submenu2 = CmsMenu::model()->find('visible=1 AND cms_menu_id='.$value2->idcmsmenu.$this->getFilterMenu());
                                                if($submenu2 == null):
                                        ?>
                                                <li><a menu="<?php echo substr($value2->url, 0,strlen($value2->url) - strlen(strstr($value2->url,"/"))) ; ?>" href="<?php echo $this->createUrl($value2->url); ?>"> <i class="<?php echo $value2->icono; ?>"></i> <?php echo $value2->titulo; ?></a></li>
                                                <li class="divider"></li>
                                        <?php
                                                else:
                                        ?>
                                        <li class="dropdown-submenu">
                                            <a menu="<?php echo substr($value2->url, 0,strlen($value2->url) - strlen(strstr($value2->url,"/"))) ; ?>" href="<?php echo $this->createUrl($value2->url); ?>"> <i class="<?php echo $value2->icono; ?>"></i> <?php echo $value2->titulo; ?></a>
                                            <ul class="dropdown-menu">
                                        <?php
                                                echo $this->submenus($value2->idcmsmenu);
                                        ?>
                                             </ul>  
                                         </li>
                                         <li class="divider"></li>
                                        <?php
                                                endif;
                                            endforeach;
                                        ?>  
                                    </ul>
                                </li>
                                <li class="divider"></li>
                            <?php             
                                    endif;
                                endforeach;
                            ?>
                        </ul>
                    </div>
                </div>
                <div class="span10">
                    <?php
                        $this->widget('bootstrap.widgets.TbBox', array(
                        'title' => $this->pageTitle,
                        'headerIcon' => 'icon-home',
                        'content' => $content // $this->renderPartial('_view')
                        ));
                    ?>
                    <div class="clear"></div>
                    <div id="footer"> &copy; Copyright <?php echo date('Y'); ?> <span class="tip"><a href="http://www.imaginamos.com/" target="_blank" title="Todos los derechos reservados" >www.imaginamos.com</a> </span> </div>
                </div>
            </div>
        </div>
        <div id="login-form" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 id="myModalLabel">Cambiar Contraseña</h3>
            </div>
            <div class="modal-body">
                <div class="row-fluid">
                    <div class="span4">
                        <?php echo CHtml::label('Anterior contraseña','anteriorcontrasena' , array('class'=>'label label-info')); ?>
                        <?php echo CHtml::passwordField('anteriorcontrasena', '', array('maxlength' => 50, 'class'=>'input-block-level')); ?>
                    </div>
                    <div class="span4">
                        <?php echo CHtml::label('Nueva contraseña','nuevacontrasena', array('class'=>'label label-success')); ?>
                        <?php echo CHtml::passwordField('nuevacontrasena', '', array('maxlength' => 50, 'class'=>'input-block-level')); ?>
                    </div>
                    <div class="span4">
                        <?php echo CHtml::label('Repita contraseña','repitacontrasena', array('class'=>'label label-success')); ?>
                        <?php echo CHtml::passwordField('repitacontrasena', '', array('maxlength' => 50, 'class'=>'input-block-level')); ?>
                    </div>
                </div>
                <div class="row-fluid">
                    <div class="span12 resp-change-pass">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn" data-dismiss="modal" aria-hidden="true">Cerrar</button>
                <button class="btn btn-primary btn-change-pass">Cambiar</button>
            </div>
        </div>
        <?php
            else:
               echo $content;
            endif;
        ?>
    </body>
</html>