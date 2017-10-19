-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versión del servidor:         10.1.9-MariaDB - mariadb.org binary distribution
-- SO del servidor:              Win32
-- HeidiSQL Versión:             9.3.0.4984
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Volcando estructura para tabla cms.cms_configuracion
CREATE TABLE IF NOT EXISTS `cms_configuracion` (
  `idcmsconfiguracion` int(11) NOT NULL AUTO_INCREMENT,
  `empresa` varchar(255) DEFAULT NULL COMMENT 'name:Empresa',
  `host` varchar(60) NOT NULL COMMENT 'name:host',
  `encryption` varchar(20) DEFAULT NULL COMMENT 'name:Encryption',
  `nombre_correo` varchar(255) NOT NULL COMMENT 'name:Nombre Correo',
  `username` varchar(70) NOT NULL COMMENT 'name:Username',
  `password` varchar(100) NOT NULL COMMENT 'name:password|type:password',
  `apiKey` text NOT NULL,
  `port` varchar(10) NOT NULL COMMENT 'name:Port',
  `plantilla` text NOT NULL COMMENT 'name:plantilla|type:wysiwyg',
  `fecha_actualizacion` datetime NOT NULL COMMENT 'name:Fecha de Actualización',
  `usuario_actualiza` int(11) NOT NULL DEFAULT '1' COMMENT 'Name:Usuario Actualiza',
  `user_restful` varchar(255) DEFAULT NULL,
  `password_restful` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`idcmsconfiguracion`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla cms.cms_configuracion: ~1 rows (aproximadamente)
DELETE FROM `cms_configuracion`;
/*!40000 ALTER TABLE `cms_configuracion` DISABLE KEYS */;
INSERT INTO `cms_configuracion` (`idcmsconfiguracion`, `empresa`, `host`, `encryption`, `nombre_correo`, `username`, `password`, `apiKey`, `port`, `plantilla`, `fecha_actualizacion`, `usuario_actualiza`, `user_restful`, `password_restful`) VALUES
	(1, 'Imaginamos', 'smtp.mandrillapp.com', NULL, 'Imaginamos - Info', 'freddyclone@gmail.com', '385uFPrkFLNYW2FdHivjjw', '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', '587', '<table style="width: 100%;" border="0" cellspacing="0" cellpadding="0">\r\n<tbody>\r\n<tr>\r\n<td style="padding: 0 0 30px 0;">\r\n<table style="border: 1px solid #cccccc; border-collapse: collapse; width: 600px;" border="0" cellspacing="0" cellpadding="0" align="center">\r\n<tbody>\r\n<tr>\r\n<td bgcolor="#E2E7EA">&nbsp;</td>\r\n</tr>\r\n<tr>\r\n<td style="padding: 5px 0px 0px; color: #153643; font-size: 28px; font-weight: bold; font-family: Arial,sans-serif;" align="center"><img style="display: block;" src="http://localhost:8080/cms-base/uploads/ahorranito.png" alt="Imaginamos" width="95" height="93" /></td>\r\n</tr>\r\n<tr>\r\n<td bgcolor="#E2E7EA">&nbsp;</td>\r\n</tr>\r\n<tr>\r\n<td style="padding: 20px 15px 20px 15px;" bgcolor="#ffffff">\r\n<table style="width: 100%;" border="0" cellspacing="0" cellpadding="0">\r\n<tbody>\r\n<tr>\r\n<td style="color: #153643; font-family: Arial, sans-serif; font-size: 24px;"><strong>Imaginamos</strong></td>\r\n</tr>\r\n<tr>\r\n<td style="padding: 20px 0 30px 0; color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px;">__content__</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td style="padding: 30px 30px 30px 30px;" bgcolor="#5AD4D7">\r\n<table style="width: 100%;" border="0" cellspacing="0" cellpadding="0">\r\n<tbody>\r\n<tr>\r\n<td style="color: #ffffff; font-family: Arial, sans-serif; font-size: 14px;" width="75%">&reg; Imaginamos 2013</td>\r\n<td align="right" width="25%">&nbsp;</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n<p>&nbsp;</p>', '2016-06-24 00:03:36', 1, 'admin', '123');
/*!40000 ALTER TABLE `cms_configuracion` ENABLE KEYS */;


-- Volcando estructura para tabla cms.cms_help
CREATE TABLE IF NOT EXISTS `cms_help` (
  `idcmshelp` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(255) NOT NULL COMMENT 'name:Título|type:text',
  `contenido` text COMMENT 'name:Contenido|type:wysiwyg',
  `link` text COMMENT 'name:Url|type:url',
  `fecha_creacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'name:Fecha de creación|type:text',
  PRIMARY KEY (`idcmshelp`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla cms.cms_help: ~7 rows (aproximadamente)
DELETE FROM `cms_help`;
/*!40000 ALTER TABLE `cms_help` DISABLE KEYS */;
INSERT INTO `cms_help` (`idcmshelp`, `titulo`, `contenido`, `link`, `fecha_creacion`) VALUES
	(2, 'Cambio de Contraseña ', '<h3>Para cambiar la contrase&ntilde;a, es necesario realizar los siguientes pasos:</h3>\r\n<p>&nbsp;1. Nos situamos en nuestro nombre de usuario en el men&uacute; del CMS &nbsp;y damos click sobre &eacute;l.</p>\r\n<p><img src="/cms-base/uploads/Ayuda/Cambio%20Contrase%C3%B1a/Selection_054.png" alt="" width="554" height="39" /></p>\r\n<p>2. Nos aparecer&aacute; una ventana emergente como esta:&nbsp;</p>\r\n<p><img src="/cms-base/uploads/Ayuda/Cambio%20Contrase%C3%B1a/imagenescritorio.png" alt="" width="600" height="283" /></p>\r\n<p>&nbsp;3. Diligenciamos los datos que se requieren y por &uacute;ltimo damos click en el bot&oacute;n Cambiar.</p>\r\n<p>&nbsp;4. Si los datos han sido diligenciados correctamente procederemos a verificar que nuestra contrase&ntilde;a ha sido cambiada, ingresando a nuestro sistema de nuevo.</p>\r\n<p>&nbsp;</p>\r\n<p style="text-align: justify;">&nbsp;</p>', NULL, '2015-04-21 22:05:20'),
	(3, 'Configurar Sitio', '<h3>Para configurar el sitio se deben realizar los siguientes pasos:</h3>\r\n<p>1. Ir al panel de Administraci&oacute;n y seleccionar "configurar sitio".</p>\r\n<p>&nbsp;<img src="http://localhost/cmsbase/uploads/Ayuda/Configurar%20sitio/Selection_055.png" alt="" width="231" height="323" /></p>\r\n<p>2. Luego se mostrar&aacute; una ventana para poder configurar los datos b&aacute;sicos del sitio, los cuales son:</p>\r\n<p><img src="http://localhost/cmsbase/uploads/Ayuda/Configurar%20sitio/Selection_056.png" alt="" width="1038" height="634" /></p>\r\n<p>3. Todos los campos deben ser diligenciados, est&aacute;n marcados por el signo de asterisco. Los diferentes campos que se describen de la siguiente forma:</p>\r\n<ul>\r\n<li><strong>Nombre de empresa: &nbsp;</strong>Describe el nombre de la organizaci&oacute;n.</li>\r\n<li><strong>Nombre de correo:&nbsp;</strong>Describe el nombre del servidor base para el env&iacute;o de correos por medio de SMTP.</li>\r\n<li><strong>Host:&nbsp;</strong>Describe el nombre del host smtp al que se va a conectar para el env&iacute;o de correos. Por ejemplo: Gmail: "smtp.gmail.com", Hotmail: "smtp.live.com".</li>\r\n<li><strong>Usuario:&nbsp;</strong>Describe el nombre de usuario para el uso de una cuenta de correo de una organizaci&oacute;n. En el caso de los servidores de gmail o hotmail. El usuario es representado por el correo.</li>\r\n<li><strong>Contrase&ntilde;a:&nbsp;</strong>Describe la contrase&ntilde;a correspondiente al nombre de usuario ingresado anteriormente.</li>\r\n<li><strong>Puerto:&nbsp;</strong>Describe la compuerta que se va a utilizar mediante la conexion de internet, que recibe el servidor para poder utilizar los servicios correo electr&oacute;nico.&nbsp;</li>\r\n<li><strong>Plantilla:&nbsp;</strong>La plantilla describe como se puede ver el contenido del sitio principal y se puede editar siempre y cuando se deje la palabra reservada <strong>_content_.</strong></li>\r\n</ul>\r\n<p>4. Por &uacute;ltimo luego de que los cambos esten diligenciados haremos click en guardar para conservar estos cambios.</p>\r\n<p><img src="http://localhost/cmsbase/uploads/Ayuda/Configurar%20sitio/Selection_057.png" alt="" width="978" height="125" /></p>', NULL, '2015-04-21 23:38:55'),
	(4, 'Cómo Administrar Usuarios', '<h3>Para administrar los usuarios debes realizar los siguientes pasos:</h3>\r\n<p>1. En el men&uacute; principal de nuuestro CMS, nos situamos al panel de administraci&oacute;n y seleccionamos la opci&oacute;n "Usuarios".</p>\r\n<p>&nbsp;<img src="http://localhost/cmsbase/uploads/Ayuda/Configurar%20sitio/Selection_055.png" alt="" width="231" height="323" /></p>\r\n<p>2. Selecciona las opciones a realizar, puedes crear un usuario, buscar un usuario entre otras opciones como se muestra a continuaci&oacute;n.</p>\r\n<p><img src="http://localhost/cmsbase/uploads/Ayuda/Administrar%20Usuarios/Selection_060.png" alt="" width="805" height="355" /></p>\r\n<p>3. Para buscar usuarios de una manera b&aacute;sica, si quieres borrarlo, verlo, o editarlo puedes buscarlos de la siguiente manera:&nbsp;</p>\r\n<ul>\r\n<li>Puedes ingresar el nombre del usuario o el email, nombre, apellido o puedes filtrar los resultados por rol o por el estado. En este caso se procedi&oacute; a buscar el usuario por medio de nombre de usuario o alias y se encontr&oacute; un resultado.</li>\r\n</ul>\r\n<p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <img src="http://localhost/cmsbase/uploads/Ayuda/Administrar%20Usuarios/Selection_061.png" alt="" width="767" height="116" /></p>\r\n<ul>\r\n<li>Se desplegan las diferentes opciones para los usuarios como ver, modificar y borrar. En este caso si hacemos click en ver representado por el s&iacute;mbolo <img src="http://localhost/cmsbase/uploads/Ayuda/Administrar%20Usuarios/Selection_068.png" alt="" width="20" height="30" />podemos ver los datos generales del usuario como se muestra a continuaci&oacute;n.</li>\r\n</ul>\r\n<p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;<img src="http://localhost/cmsbase/uploads/Ayuda/Administrar%20Usuarios/Selection_062.png" alt="" width="787" height="408" /></p>\r\n<ul>\r\n<li>Si hacemos click en modificar representado por es s&iacute;mbolo de <img src="http://localhost/cmsbase/uploads/Ayuda/Administrar%20Usuarios/Selection_067.png" alt="" width="15" height="25" />&nbsp;podemos visualizar la siguiente interfaz:</li>\r\n</ul>\r\n<p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<img src="http://localhost/cmsbase/uploads/Ayuda/Administrar%20Usuarios/Selection_063.png" alt="" width="772" height="476" />&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</p>\r\n<p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Los campos que se encuentran con asterisco son obligatorios, esta informaci&oacute;n refleja si un usuario est&aacute; activo o no dentro del sistema.</p>\r\n<ul>\r\n<li>Si hacemos click en eliminar usuario identificado por el simbolo de&nbsp;<img src="http://localhost/cmsbase/uploads/Ayuda/Administrar%20Usuarios/Selection_066.png" alt="" width="17" height="34" />&nbsp;, se mostrar&aacute; esta ventana emergente confirmando el borrado o no del usuario.</li>\r\n</ul>\r\n<p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<img src="http://localhost/cmsbase/uploads/Ayuda/Administrar%20Usuarios/Selection_065.png" alt="" width="380" height="167" /></p>\r\n<ul>\r\n<li>Para realizar una b&uacute;squeda avanzada es necesario que selecciones la opci&oacute;n de b&uacute;squeda avanzada. Luego de clickear este bot&oacute;n puedes ver la siguiente interfaz:</li>\r\n</ul>\r\n<p>&nbsp; &nbsp; &nbsp; &nbsp;<img src="http://localhost/cmsbase/uploads/Ayuda/Administrar%20Usuarios/Selection_071.png" alt="" width="814" height="489" /></p>\r\n<p>Los campos no son olbigatorios ya que puedes buscar por cualquier termino, c&oacute;mo lo muestra el formulario.&nbsp;</p>\r\n<p>4. Para crear un usuario es necesario seleccionar el bot&oacute;n de crear usuario como se muestra a acontinuaci&oacute;n.</p>\r\n<p><img src="http://localhost/cmsbase/uploads/Ayuda/Administrar%20Usuarios/Selection_069.png" alt="" width="138" height="44" /> &nbsp;</p>\r\n<p>5. Una vez se seleccion&oacute; ese boton aparecer&aacute; una interfaz como esta, debemos ingresar los datos requeridos.</p>\r\n<p><img src="http://localhost/cmsbase/uploads/Ayuda/Administrar%20Usuarios/Selection_070.png" alt="" width="820" height="503" />&nbsp;</p>\r\n<p>Es importante la definici&oacute;n de los roles ya que cada rol identifica las diferentes funciones de cada usuario. Aqui se describe cada rol:</p>\r\n<ul>\r\n<li><strong>Super Administrador:</strong> El super adminitrador puede realizar todas las acciones que se muestran en esta ayuda.</li>\r\n<li><strong>Administrador Cliente:.&nbsp;</strong>El administrador cliente puede ingresar al sistema pero no puede realizar las diferentes opciones del administrador, ya que el uso es restringido.</li>\r\n<li><strong>Usuario registrado Back:</strong>&nbsp;El usuario registrado back puede realizar las acciones que el super administrador le asige a este rol.&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;</li>\r\n</ul>\r\n<p>&nbsp;</p>\r\n<p>&nbsp;</p>', NULL, '2015-04-22 13:53:33'),
	(5, 'Menú Roles', '<h3>Para cambiar los roles es necesario realizar los siguientes pasos:</h3>\r\n<p>1. Debes ir al panel de adminsitraci&oacute;n y seleccionar el men&uacute; "Rol".</p>\r\n<p>&nbsp;<img src="http://localhost/cmsbase/uploads/Ayuda/Administrar%20Roles/Selection_055.png" alt="" width="231" height="323" /></p>\r\n<p>2. Luego de que has seleccionado la opci&oacute;n, se mostrar&aacute; la siguiente interfaz:</p>\r\n<p><img src="http://localhost/cmsbase/uploads/Ayuda/Administrar%20Roles/Selection_072.png" alt="" width="845" height="334" /></p>\r\n<p>3. Es posible realizar las diferentes acciones como en el item de usuarios, se puede buscar, crear, modificar los roles, no es posible eliminar estos roles.</p>\r\n<ul>\r\n<li>Para buscar los roles se realiza de la misma manera que los usuarios, por ejemplo si colocamos alguna letra o palabra dentro del campo de texto donde dice Rol autom&aacute;ticamente se actualizar&aacute; la tabla con los resultados de la b&uacute;squeda, como se muestra a continuaci&oacute;n:</li>\r\n</ul>\r\n<p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<img src="http://localhost/cmsbase/uploads/Ayuda/Administrar%20Roles/Selection_073.png" alt="" width="843" height="133" /></p>\r\n<ul>\r\n<li>&nbsp;Para una b&uacute;squeda avanzada es necesario seleccionar el bot&oacute;n de b&uacute;squeda avanzada. Luego te mostrar&aacute; una interfaz como esta:</li>\r\n</ul>\r\n<p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<img src="http://localhost/cmsbase/uploads/Ayuda/Administrar%20Roles/Selection_074.png" alt="" width="880" height="448" />&nbsp;</p>\r\n<ul>\r\n<li>Para editar el rol, debes seleccionar la opci&oacute;n de rol representada con el &iacute;cono de &nbsp;<img src="http://localhost/cmsbase/uploads/Ayuda/Administrar%20Roles/Selection_067.png" alt="" width="15" height="25" />&nbsp;y luego aparecer&aacute; una interfaz como esta:</li>\r\n</ul>\r\n<p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<img src="http://localhost/cmsbase/uploads/Ayuda/Administrar%20Roles/Selection_075.png" alt="" width="837" height="274" /></p>\r\n<p>Para editar esta informaci&oacute;n s&oacute;lo modifica lo que encuentras en la caja de texto y ese ser&aacute; el nuevo rol editado. Para guardar los cabios debes hacer click en guardar.</p>\r\n<ul>\r\n<li>Para ver la informaci&oacute;n relacionada con el rol solo debes hacer click en el siguiente s&iacute;mbolo &nbsp;<img src="http://localhost/cmsbase/uploads/Ayuda/Administrar%20Roles/Selection_068.png" alt="" width="20" height="30" />&nbsp;, luego de seleccionarlo se te mostrar&aacute; toda la informaci&oacute;n correspondiente al rol seleccionado.</li>\r\n</ul>\r\n<p>&nbsp; &nbsp; &nbsp; &nbsp; <img src="http://localhost/cmsbase/uploads/Ayuda/Administrar%20Roles/Selection_076.png" alt="" width="876" height="195" /></p>\r\n<p>&nbsp;La interfaz muestra todos los usuarios que pertenecen al rol seleccionado.</p>', NULL, '2015-04-22 17:05:41'),
	(6, 'Permisos para Roles', '<h3>Para crear o otorgar permisos para roles debes seguir los siguientes pasos:</h3>\r\n<p>1. Pimero debes seleccionar en el panel de administraci&oacute;n, la opci&oacute;n "Permisos para roles". Luego te aparecer&aacute; una interfaz como esta:</p>\r\n<p><img src="http://localhost/cmsbase/uploads/Ayuda/Permisos%20roles/Selection_077.png" alt="" width="829" height="247" /></p>\r\n<p>2 Para buscar o realizar roles solo es necesario escribir el nobe del rol, con la lista desplegable que se muestra, tambien se puede por el nombre del controlador y la acci&oacute;n del controlador, lo mismo ser&iacute;a para una busqueda avanzada.&nbsp;</p>\r\n<p>3. Para crear permisos de rol tienes que seleccionar el siguiente bot&oacute;n.</p>\r\n<p><img src="http://localhost/cmsbase/uploads/Ayuda/Permisos%20roles/Selection_078.png" alt="" width="197" height="42" /></p>\r\n<p>4. Aparecer&aacute; la siguiente interfaz y debes ingresar los datos requeridos para crear el permiso del rol.</p>\r\n<p>&nbsp;</p>\r\n<p><img src="http://localhost/cmsbase/uploads/Ayuda/Permisos%20roles/Selection_079.png" alt="" width="829" height="319" /></p>\r\n<p>Los campos se representan de la siguiente forma:</p>\r\n<ul>\r\n<li><strong>Rol:&nbsp;</strong>Describe el rol del usuario al que se van a generar los permisos.</li>\r\n<li><strong>Controlador:&nbsp;</strong>Describe el nombre del controlador en el cual se almacenan las acciones que se van a permitir. El controlador esta situado en la Url. como en este caso.</li>\r\n</ul>\r\n<p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<img src="http://localhost/cmsbase/uploads/Ayuda/Permisos%20roles/Selection_085.png" alt="" /></p>\r\n<ol>\r\n<li><strong>cmsbase:&nbsp;</strong>Representa el nombre del sitio web.</li>\r\n<li><strong>cmsUsuario:&nbsp;</strong>Representa el nombre del controlador.</li>\r\n<li><strong>create:&nbsp;</strong>Representa la acci&oacute;n.</li>\r\n</ol>\r\n<ul>\r\n<li><strong>Acci&oacute;n:&nbsp;</strong>Describe la acci&oacute;n que se va a permitir para el rol seleccionado.&nbsp;</li>\r\n</ul>', NULL, '2015-04-22 20:40:42'),
	(7, 'Botón Operaciones', '<h3><strong>Bot&oacute;n Operaciones</strong>&nbsp;</h3>\r\n<p style="text-align: justify;">El bot&oacute;n operaciones representa las acciones que se pueden realizar en cada pantalla, como acualizar, consultar, eliminar y todas las acciones b&aacute;sicas que se encuentran en cada item del sistema y aparecen dependiendo del &aacute;mbito en el que est&eacute; ya que cada &aacute;mbito representa lo que puedo hacer dentro del CMS.</p>\r\n<p style="text-align: justify;">El bot&oacute;n operaciones se encuentra en la parte superior al lado del nombre del usuario as&iacute;:</p>\r\n<p style="text-align: justify;"><img src="http://localhost/cmsbase/uploads/Ayuda/Operaciones/Selection_081.png" alt="" width="165" height="44" /></p>\r\n<p style="text-align: justify;">Si desplegamos el bot&oacute;n, nos mostrar&aacute; las diferentes opciones que tenemos pero como se d&iacute;jo antes dependen del &aacute;mbito en el que est&eacute;n. Un ejemplo claro ser&iacute;a el siguiente:</p>\r\n<p style="text-align: justify;">Estamos situados en el m&oacute;dulo de "Usuarios", que est&aacute; situado si seleccionamos la opci&oacute;n de "Usuarios" en el men&uacute; Administraci&oacute;n.</p>\r\n<p style="text-align: justify;"><img src="http://localhost/cmsbase/uploads/Ayuda/Operaciones/Selection_082.png" alt="" width="209" height="93" /></p>\r\n<p style="text-align: justify;">Vemos que aparece una opci&oacute;n en donde podemos crear el usuario, ya que estamos situados sobre la interfaz de inicio de los usuarios.</p>\r\n<p style="text-align: justify;">Si seleccionamos un usuario al cual acabamos de buscar en la interfaz principal de usuarios nos cambiar&aacute;n las opciones del men&uacute; de operaciones conforme a lo que se pueda realizar con el usuario &nbsp;o con lo que haya seleccionado, asi ocurre en los diferentes m&oacute;dulos del CMS.</p>\r\n<p style="text-align: justify;">Ejemplo: Se seleccion&oacute; un usuario para visualizar sus datos, o alguna otra acci&oacute;n. El men&uacute; me muestra lo siguiente:</p>\r\n<p style="text-align: justify;"><img src="http://localhost/cmsbase/uploads/Ayuda/Operaciones/Selection_083.png" alt="" width="202" height="170" /></p>\r\n<p style="text-align: justify;">En cada m&oacute;dulo es igual ya que dependiendo a el m&oacute;dulo seleccionado y a las diferentes acciones que realizas, el men&uacute; va a cambiar.</p>\r\n<p style="text-align: justify;">&nbsp;</p>\r\n<p style="text-align: justify;">&nbsp;</p>', NULL, '2015-04-22 22:08:56'),
	(8, 'Creación Menús', '<h3>Para crear men&uacute;s debes seguir los siguientes pasos:</h3>\r\n<p>1. Debes seleccionar en el menu de administraci&oacute;n la opci&oacute;n "Menus", como se muestra aqu&iacute; en la siguiente imagen:</p>\r\n<p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;<img src="http://localhost/cmsbase/uploads/Ayuda/Menus/Selection_055.png" alt="" width="231" height="323" /></p>\r\n<p>2. Luego de haber seleccionado la opci&oacute;n de "Men&uacute;s" aparecer&aacute; la siguiente interfaz:</p>\r\n<p><img src="http://localhost/cmsbase/uploads/Ayuda/Menus/Selection_086.png" alt="" width="799" height="218" /></p>\r\n<p>3. Para crear un Men&uacute;, debes hacer click en la opci&oacute;n Crear Men&uacute; como se muestra a continuaci&oacute;n:</p>\r\n<p><img src="http://localhost/cmsbase/uploads/Ayuda/Menus/Selection_087.png" alt="" width="804" height="377" /></p>\r\n<p>Cada campo se explica a continuaci&oacute;n:</p>\r\n<ul>\r\n<li><strong>T&iacute;tulo:&nbsp;</strong>El t&iacute;tulo representa el nombre con el que se va a representar el men&uacute;.</li>\r\n<li><strong>Controlador:&nbsp;</strong>Es el nombre del controlador junto con la acci&oacute;n a realizar del men&uacute;.&nbsp;</li>\r\n<li><strong>Men&uacute; Dependiente:&nbsp;</strong>Si existen men&uacute;s dependientes en la lista desplegable aparecer&aacute;n, el men&uacute; dependiente es aquel que es padre de un item que se desea agregar, en el caso de que existan otros men&uacute;s en la parte lateral de nuestro CMS.&nbsp;</li>\r\n<li><strong>Encabezado visible para men&uacute; padre:&nbsp;</strong>Representa si el men&uacute; que se crea es hijo, ser&aacute; visible o no en el t&iacute;tulo de men&uacute; padre.</li>\r\n<li><strong>Men&uacute; Visible:&nbsp;</strong>Describe si el men&uacute; ser&aacute; visible o no.</li>\r\n<li><strong>&Iacute;cono del Men&uacute;:&nbsp;</strong>Representa el &iacute;cono o la forma que va a representar el t&iacute;tulo del men&uacute; o el contenido de los mismos.&nbsp;</li>\r\n</ul>\r\n<p>Cuando el men&uacute; se crea correctamente, este queda situado en la parte lateral de la interfaz del CMS como se muestra a continuaci&oacute;n:</p>\r\n<p><img src="http://localhost/cmsbase/uploads/Ayuda/Menus/Selection_088.png" alt="" width="801" height="288" /></p>\r\n<p>Como vemos, una vez creado el men&uacute;, ser&aacute; mostrado un resumen sobre los datos que se guardaron del men&uacute; y se puede visualizar el men&uacute; creado en la parte lateral de nuestro CMS.</p>\r\n<p>Aqu&iacute; veremos que cuando regresarmos a la interfaz principal de los men&uacute;s, aparecer&aacute;n todos los men&uacute;s creados, en este caso aparece el men&uacute; que acabamos de crear. Como vemos tiene las diferentes opciones como editar, ver y eliminar, como est&aacute;n presentes en todos los items del men&uacute; administraci&oacute;n.</p>\r\n<p><img src="http://localhost/cmsbase/uploads/Ayuda/Menus/Selection_089.png" alt="" width="793" height="101" /></p>\r\n<p>Si nos situamos en el men&uacute; operaciones podemos ver las siguientes opciones siempre y cuando estemos en la interfaz de crear men&uacute;.</p>\r\n<p>&nbsp;<img src="http://localhost/cmsbase/uploads/Ayuda/Menus/Selection_090.png" alt="" width="200" height="161" /></p>\r\n<p>&nbsp;<strong>Nota:</strong> El men&uacute; se crea siempre y cuando exista un modelo, en la base de datos sobre ese men&uacute;.</p>', NULL, '2015-04-22 22:56:10');
/*!40000 ALTER TABLE `cms_help` ENABLE KEYS */;


-- Volcando estructura para tabla cms.cms_icono
CREATE TABLE IF NOT EXISTS `cms_icono` (
  `idcmsicono` int(11) NOT NULL AUTO_INCREMENT,
  `icono_class` varchar(40) NOT NULL,
  PRIMARY KEY (`idcmsicono`)
) ENGINE=InnoDB AUTO_INCREMENT=264 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla cms.cms_icono: ~263 rows (aproximadamente)
DELETE FROM `cms_icono`;
/*!40000 ALTER TABLE `cms_icono` DISABLE KEYS */;
INSERT INTO `cms_icono` (`idcmsicono`, `icono_class`) VALUES
	(1, 'glyphicon-asterisk'),
	(2, 'glyphicon-plus'),
	(3, 'glyphicon-euro'),
	(4, 'glyphicon-eur'),
	(5, 'glyphicon-minus'),
	(6, 'glyphicon-cloud'),
	(7, 'glyphicon-envelope'),
	(8, 'glyphicon-pencil'),
	(9, 'glyphicon-glass'),
	(10, 'glyphicon-music'),
	(11, 'glyphicon-search'),
	(12, 'glyphicon-heart'),
	(13, 'glyphicon-star'),
	(14, 'glyphicon-star-empty'),
	(15, 'glyphicon-user'),
	(16, 'glyphicon-film'),
	(17, 'glyphicon-th-large'),
	(18, 'glyphicon-th'),
	(19, 'glyphicon-th-list'),
	(20, 'glyphicon-ok'),
	(21, 'glyphicon-remove'),
	(22, 'glyphicon-zoom-in'),
	(23, 'glyphicon-zoom-out'),
	(24, 'glyphicon-off'),
	(25, 'glyphicon-signal'),
	(26, 'glyphicon-cog'),
	(27, 'glyphicon-trash'),
	(28, 'glyphicon-home'),
	(29, 'glyphicon-file'),
	(30, 'glyphicon-time'),
	(31, 'glyphicon-road'),
	(32, 'glyphicon-download-alt'),
	(33, 'glyphicon-download'),
	(34, 'glyphicon-upload'),
	(35, 'glyphicon-inbox'),
	(36, 'glyphicon-play-circle'),
	(37, 'glyphicon-repeat'),
	(38, 'glyphicon-refresh'),
	(39, 'glyphicon-list-alt'),
	(40, 'glyphicon-lock'),
	(41, 'glyphicon-flag'),
	(42, 'glyphicon-headphones'),
	(43, 'glyphicon-volume-off'),
	(44, 'glyphicon-volume-down'),
	(45, 'glyphicon-volume-up'),
	(46, 'glyphicon-qrcode'),
	(47, 'glyphicon-barcode'),
	(48, 'glyphicon-tag'),
	(49, 'glyphicon-tags'),
	(50, 'glyphicon-book'),
	(51, 'glyphicon-bookmark'),
	(52, 'glyphicon-print'),
	(53, 'glyphicon-camera'),
	(54, 'glyphicon-font'),
	(55, 'glyphicon-bold'),
	(56, 'glyphicon-italic'),
	(57, 'glyphicon-text-height'),
	(58, 'glyphicon-text-width'),
	(59, 'glyphicon-align-left'),
	(60, 'glyphicon-align-center'),
	(61, 'glyphicon-align-right'),
	(62, 'glyphicon-align-justify'),
	(63, 'glyphicon-list'),
	(64, 'glyphicon-indent-left'),
	(65, 'glyphicon-indent-right'),
	(66, 'glyphicon-facetime-video'),
	(67, 'glyphicon-picture'),
	(68, 'glyphicon-map-marker'),
	(69, 'glyphicon-adjust'),
	(70, 'glyphicon-tint'),
	(71, 'glyphicon-edit'),
	(72, 'glyphicon-share'),
	(73, 'glyphicon-check'),
	(74, 'glyphicon-move'),
	(75, 'glyphicon-step-backward'),
	(76, 'glyphicon-fast-backward'),
	(77, 'glyphicon-backward'),
	(78, 'glyphicon-play'),
	(79, 'glyphicon-pause'),
	(80, 'glyphicon-stop'),
	(81, 'glyphicon-forward'),
	(82, 'glyphicon-fast-forward'),
	(83, 'glyphicon-step-forward'),
	(84, 'glyphicon-eject'),
	(85, 'glyphicon-chevron-left'),
	(86, 'glyphicon-chevron-right'),
	(87, 'glyphicon-plus-sign'),
	(88, 'glyphicon-minus-sign'),
	(89, 'glyphicon-remove-sign'),
	(90, 'glyphicon-ok-sign'),
	(91, 'glyphicon-question-sign'),
	(92, 'glyphicon-info-sign'),
	(93, 'glyphicon-screenshot'),
	(94, 'glyphicon-remove-circle'),
	(95, 'glyphicon-ok-circle'),
	(96, 'glyphicon-ban-circle'),
	(97, 'glyphicon-arrow-left'),
	(98, 'glyphicon-arrow-right'),
	(99, 'glyphicon-arrow-up'),
	(100, 'glyphicon-arrow-down'),
	(101, 'glyphicon-share-alt'),
	(102, 'glyphicon-resize-full'),
	(103, 'glyphicon-resize-small'),
	(104, 'glyphicon-exclamation-sign'),
	(105, 'glyphicon-gift'),
	(106, 'glyphicon-leaf'),
	(107, 'glyphicon-fire'),
	(108, 'glyphicon-eye-open'),
	(109, 'glyphicon-eye-close'),
	(110, 'glyphicon-warning-sign'),
	(111, 'glyphicon-plane'),
	(112, 'glyphicon-calendar'),
	(113, 'glyphicon-random'),
	(114, 'glyphicon-comment'),
	(115, 'glyphicon-magnet'),
	(116, 'glyphicon-chevron-up'),
	(117, 'glyphicon-chevron-down'),
	(118, 'glyphicon-retweet'),
	(119, 'glyphicon-shopping-cart'),
	(120, 'glyphicon-folder-close'),
	(121, 'glyphicon-folder-open'),
	(122, 'glyphicon-resize-vertical'),
	(123, 'glyphicon-resize-horizontal'),
	(124, 'glyphicon-hdd'),
	(125, 'glyphicon-bullhorn'),
	(126, 'glyphicon-bell'),
	(127, 'glyphicon-certificate'),
	(128, 'glyphicon-thumbs-up'),
	(129, 'glyphicon-thumbs-down'),
	(130, 'glyphicon-hand-right'),
	(131, 'glyphicon-hand-left'),
	(132, 'glyphicon-hand-up'),
	(133, 'glyphicon-hand-down'),
	(134, 'glyphicon-circle-arrow-right'),
	(135, 'glyphicon-circle-arrow-left'),
	(136, 'glyphicon-circle-arrow-up'),
	(137, 'glyphicon-circle-arrow-down'),
	(138, 'glyphicon-globe'),
	(139, 'glyphicon-wrench'),
	(140, 'glyphicon-tasks'),
	(141, 'glyphicon-filter'),
	(142, 'glyphicon-briefcase'),
	(143, 'glyphicon-fullscreen'),
	(144, 'glyphicon-dashboard'),
	(145, 'glyphicon-paperclip'),
	(146, 'glyphicon-heart-empty'),
	(147, 'glyphicon-link'),
	(148, 'glyphicon-phone'),
	(149, 'glyphicon-pushpin'),
	(150, 'glyphicon-usd'),
	(151, 'glyphicon-gbp'),
	(152, 'glyphicon-sort'),
	(153, 'glyphicon-sort-by-alphabet'),
	(154, 'glyphicon-sort-by-alphabet-alt'),
	(155, 'glyphicon-sort-by-order'),
	(156, 'glyphicon-sort-by-order-alt'),
	(157, 'glyphicon-sort-by-attributes'),
	(158, 'glyphicon-sort-by-attributes-alt'),
	(159, 'glyphicon-unchecked'),
	(160, 'glyphicon-expand'),
	(161, 'glyphicon-collapse-down'),
	(162, 'glyphicon-collapse-up'),
	(163, 'glyphicon-log-in'),
	(164, 'glyphicon-flash'),
	(165, 'glyphicon-log-out'),
	(166, 'glyphicon-new-window'),
	(167, 'glyphicon-record'),
	(168, 'glyphicon-save'),
	(169, 'glyphicon-open'),
	(170, 'glyphicon-saved'),
	(171, 'glyphicon-import'),
	(172, 'glyphicon-export'),
	(173, 'glyphicon-send'),
	(174, 'glyphicon-floppy-disk'),
	(175, 'glyphicon-floppy-saved'),
	(176, 'glyphicon-floppy-remove'),
	(177, 'glyphicon-floppy-save'),
	(178, 'glyphicon-floppy-open'),
	(179, 'glyphicon-credit-card'),
	(180, 'glyphicon-transfer'),
	(181, 'glyphicon-cutlery'),
	(182, 'glyphicon-header'),
	(183, 'glyphicon-compressed'),
	(184, 'glyphicon-earphone'),
	(185, 'glyphicon-phone-alt'),
	(186, 'glyphicon-tower'),
	(187, 'glyphicon-stats'),
	(188, 'glyphicon-sd-video'),
	(189, 'glyphicon-hd-video'),
	(190, 'glyphicon-subtitles'),
	(191, 'glyphicon-sound-stereo'),
	(192, 'glyphicon-sound-dolby'),
	(193, 'glyphicon-sound-5-1'),
	(194, 'glyphicon-sound-6-1'),
	(195, 'glyphicon-sound-7-1'),
	(196, 'glyphicon-copyright-mark'),
	(197, 'glyphicon-registration-mark'),
	(198, 'glyphicon-cloud-download'),
	(199, 'glyphicon-cloud-upload'),
	(200, 'glyphicon-tree-conifer'),
	(201, 'glyphicon-tree-deciduous'),
	(202, 'glyphicon-cd'),
	(203, 'glyphicon-save-file'),
	(204, 'glyphicon-open-file'),
	(205, 'glyphicon-level-up'),
	(206, 'glyphicon-copy'),
	(207, 'glyphicon-paste'),
	(208, 'glyphicon-alert'),
	(209, 'glyphicon-equalizer'),
	(210, 'glyphicon-king'),
	(211, 'glyphicon-queen'),
	(212, 'glyphicon-pawn'),
	(213, 'glyphicon-bishop'),
	(214, 'glyphicon-knight'),
	(215, 'glyphicon-baby-formula'),
	(216, 'glyphicon-tent'),
	(217, 'glyphicon-blackboard'),
	(218, 'glyphicon-bed'),
	(219, 'glyphicon-apple'),
	(220, 'glyphicon-erase'),
	(221, 'glyphicon-hourglass'),
	(222, 'glyphicon-lamp'),
	(223, 'glyphicon-duplicate'),
	(224, 'glyphicon-piggy-bank'),
	(225, 'glyphicon-scissors'),
	(226, 'glyphicon-bitcoin'),
	(227, 'glyphicon-btc'),
	(228, 'glyphicon-xbt'),
	(229, 'glyphicon-yen'),
	(230, 'glyphicon-jpy'),
	(231, 'glyphicon-ruble'),
	(232, 'glyphicon-rub'),
	(233, 'glyphicon-scale'),
	(234, 'glyphicon-ice-lolly'),
	(235, 'glyphicon-ice-lolly-tasted'),
	(236, 'glyphicon-education'),
	(237, 'glyphicon-option-horizontal'),
	(238, 'glyphicon-option-vertical'),
	(239, 'glyphicon-menu-hamburger'),
	(240, 'glyphicon-modal-window'),
	(241, 'glyphicon-oil'),
	(242, 'glyphicon-grain'),
	(243, 'glyphicon-sunglasses'),
	(244, 'glyphicon-text-size'),
	(245, 'glyphicon-text-color'),
	(246, 'glyphicon-text-background'),
	(247, 'glyphicon-object-align-top'),
	(248, 'glyphicon-object-align-bottom'),
	(249, 'glyphicon-object-align-horizontal'),
	(250, 'glyphicon-object-align-left'),
	(251, 'glyphicon-object-align-vertical'),
	(252, 'glyphicon-object-align-right'),
	(253, 'glyphicon-triangle-right'),
	(254, 'glyphicon-triangle-left'),
	(255, 'glyphicon-triangle-bottom'),
	(256, 'glyphicon-triangle-top'),
	(257, 'glyphicon-console'),
	(258, 'glyphicon-superscript'),
	(259, 'glyphicon-subscript'),
	(260, 'glyphicon-menu-left'),
	(261, 'glyphicon-menu-right'),
	(262, 'glyphicon-menu-down'),
	(263, 'glyphicon-menu-up ');
/*!40000 ALTER TABLE `cms_icono` ENABLE KEYS */;


-- Volcando estructura para tabla cms.cms_menu
CREATE TABLE IF NOT EXISTS `cms_menu` (
  `idcmsmenu` int(11) NOT NULL AUTO_INCREMENT,
  `cms_menu_id` int(11) DEFAULT NULL COMMENT 'name:Menú Dependiente',
  `titulo` varchar(40) NOT NULL COMMENT 'name:Título del Menú',
  `url` varchar(80) NOT NULL COMMENT 'name:Controlador / Acción menú',
  `icono` varchar(20) NOT NULL COMMENT 'name:Icono del menú',
  `visible_header` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'name:Encabezado visible para menú padre|type:switch',
  `visible` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'name:Menú Visible|type:switch',
  `orden` smallint(3) NOT NULL DEFAULT '0' COMMENT 'name:Posición del Menú',
  PRIMARY KEY (`idcmsmenu`),
  KEY `recursive_menu` (`cms_menu_id`),
  CONSTRAINT `recursive_menu` FOREIGN KEY (`cms_menu_id`) REFERENCES `cms_menu` (`idcmsmenu`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla cms.cms_menu: ~4 rows (aproximadamente)
DELETE FROM `cms_menu`;
/*!40000 ALTER TABLE `cms_menu` DISABLE KEYS */;
INSERT INTO `cms_menu` (`idcmsmenu`, `cms_menu_id`, `titulo`, `url`, `icono`, `visible_header`, `visible`, `orden`) VALUES
	(1, NULL, 'test', 'cmsHelp/admin', 'glyphicon-minus', 1, 1, 0),
	(2, NULL, 'tes2', 'cmsHelp/admin', 'glyphicon-asterisk', 1, 1, 2),
	(3, 1, 'sub', 'cmsHelp/admin', 'glyphicon-asterisk', 1, 1, 1),
	(4, 3, 'sub sub', 'cmsHelp/admin', 'glyphicon-euro', 1, 1, 3);
/*!40000 ALTER TABLE `cms_menu` ENABLE KEYS */;


-- Volcando estructura para tabla cms.cms_permission_rol
CREATE TABLE IF NOT EXISTS `cms_permission_rol` (
  `idcmspermissionrol` int(11) NOT NULL AUTO_INCREMENT,
  `cms_rol_id` int(11) NOT NULL,
  `controller` varchar(255) NOT NULL,
  `action` varchar(255) NOT NULL,
  PRIMARY KEY (`idcmspermissionrol`),
  KEY `cms_permission_rol_cms_rol` (`cms_rol_id`),
  CONSTRAINT `cms_permission_rol_cms_rol` FOREIGN KEY (`cms_rol_id`) REFERENCES `cms_rol` (`idcmsrol`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla cms.cms_permission_rol: ~0 rows (aproximadamente)
DELETE FROM `cms_permission_rol`;
/*!40000 ALTER TABLE `cms_permission_rol` DISABLE KEYS */;
/*!40000 ALTER TABLE `cms_permission_rol` ENABLE KEYS */;


-- Volcando estructura para tabla cms.cms_rol
CREATE TABLE IF NOT EXISTS `cms_rol` (
  `idcmsrol` int(11) NOT NULL AUTO_INCREMENT,
  `rol` varchar(255) NOT NULL,
  PRIMARY KEY (`idcmsrol`),
  UNIQUE KEY `unico_rol` (`rol`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla cms.cms_rol: ~4 rows (aproximadamente)
DELETE FROM `cms_rol`;
/*!40000 ALTER TABLE `cms_rol` DISABLE KEYS */;
INSERT INTO `cms_rol` (`idcmsrol`, `rol`) VALUES
	(2, 'Administrador Cliente'),
	(1, 'Super Administrador'),
	(3, 'Usuario Registrado Back'),
	(4, 'Usuario Registrado Front');
/*!40000 ALTER TABLE `cms_rol` ENABLE KEYS */;


-- Volcando estructura para tabla cms.cms_usuario
CREATE TABLE IF NOT EXISTS `cms_usuario` (
  `idcmsusuario` int(11) NOT NULL AUTO_INCREMENT,
  `usuario` varchar(70) NOT NULL COMMENT 'name:Usuario',
  `contrasena` varchar(100) NOT NULL COMMENT 'name:Contraseña|type:password',
  `nombres` varchar(50) NOT NULL COMMENT 'name:Nombres|type:text',
  `apellidos` varchar(50) NOT NULL COMMENT 'name:Apellidos',
  `email` varchar(50) NOT NULL COMMENT 'name:Email|type:email',
  `empresa` varchar(80) NOT NULL COMMENT 'name:Empresa',
  `telefono` varchar(150) DEFAULT NULL COMMENT 'name:Teléfono|type:phone',
  `descripcion` text COMMENT 'name:Descripción|type:textlarge',
  `ciudad` varchar(30) DEFAULT NULL COMMENT 'name:Ciudad',
  `cms_rol_id` int(11) NOT NULL COMMENT 'name:Rol',
  `token_chage` varchar(255) DEFAULT NULL COMMENT 'name:Token de cambio',
  `activo` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'name:Activo|type:switch',
  PRIMARY KEY (`idcmsusuario`),
  KEY `cms_usuario_cms_rol` (`cms_rol_id`),
  CONSTRAINT `cms_usuario_cms_rol` FOREIGN KEY (`cms_rol_id`) REFERENCES `cms_rol` (`idcmsrol`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla cms.cms_usuario: ~2 rows (aproximadamente)
DELETE FROM `cms_usuario`;
/*!40000 ALTER TABLE `cms_usuario` DISABLE KEYS */;
INSERT INTO `cms_usuario` (`idcmsusuario`, `usuario`, `contrasena`, `nombres`, `apellidos`, `email`, `empresa`, `telefono`, `descripcion`, `ciudad`, `cms_rol_id`, `token_chage`, `activo`) VALUES
	(1, 'cms', '21232f297a57a5a743894a0e4a801fc3', 'Freddy Fernando', 'Alarcón Juez', 'freddy.alarcon@imaginamos.com.co', 'IMAGINAMOS', NULL, NULL, 'Bogotá', 1, NULL, 1),
	(2, 'user', '21232f297a57a5a743894a0e4a801fc3', 'User', 'Administrator', 'freddyclone@gmail.com', 'IMAGINAMOS', NULL, NULL, 'Bogotá', 2, NULL, 1);
/*!40000 ALTER TABLE `cms_usuario` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
