<?php
$this->Widget('ext.yii-toast.ToastrWidget');
$base = Yii::app()->request->baseUrl;
$session = Yii::app()->session;
?>
<html>
<head>
  <meta charset="UTF-8"/>
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <meta http-equiv="content-language" content="es" />
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
  <title>COJUNAL</title>
  <meta name="keywords" content="" />
  <meta name="description" content="" />
  <meta name="copyright" content="imaginamos.com" />
  <meta name="date" content="2016" />
  <meta name="author" content="diseño web: imaginamos.com" />
  <meta name="robots" content="All" />
  <link rel="shortcut icon" type="image/x-icon" href="../assets/img/favicon.ico" />
  <link rel="author" type="text/plain" href="humans.txt" />
  <!--Style's-->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
 
</head>

<body>
<?php echo $content; ?>
</body>  
