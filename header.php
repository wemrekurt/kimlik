<?php require_once('db.php');
include('olmasi.php');
$dosya='http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
function sef_link($s){
    $tr = array('ş','Ş','ı','İ','ğ','Ğ','ü','Ü','ö','Ö','ç','Ç');
    // Türkçe karakterlerin çevrilecegi karakterler
    $en = array('s','s','i','i','g','g','u','u','o','o','c','c');
    $s = str_replace($tr,$en,$s);
    $s = strtolower($s);
    $s = preg_replace('/&amp;amp;amp;amp;amp;amp;amp;amp;.+?;/', '-', $s);
    $s = preg_replace('/[^%a-z0-9 _-]/', '-', $s);
    $s = preg_replace('/\s+/', '-', $s);
    $s = preg_replace('|-+|', '-', $s);
    $s = str_replace("--","-",$s);
    $s = trim($s, '-');
    return $s;
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="utf-8">
    <title>KimlikA</title>

    <meta name="viewport" content="width=1000, initial-scale=1.0, maximum-scale=1.0">

    <!-- Loading Bootstrap -->
    <link href="<?php echo $link; ?>/dist/css/vendor/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo $link; ?>/dist/css/emre.css" rel="stylesheet">

    <!-- Loading Flat UI -->
    <link href="<?php echo $link; ?>/dist/css/flat-ui.css" rel="stylesheet">
    <link href="<?php echo $link; ?>/dist/css/slider.css" rel="stylesheet">
    <link href="<?php echo $link; ?>/docs/assets/css/demo.css" rel="stylesheet">
    <link rel="shortcut icon" href="<?php echo $link; ?>/img/favicon.ico">


    <link rel="stylesheet" href="<?php echo $link; ?>/dist/css/jquery-ui.css">
    <script src="<?php echo $link; ?>/js/jquery-1.10.2.js"></script>
    <script src="<?php echo $link; ?>/js/jquery-ui.js"></script>
    <script>
        $(function() {
            $( "#accordion" ).accordion();
        });
    </script>

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements. All other JS at the end of file. -->
    <!--[if lt IE 9]>
    <script src="<?php echo $link; ?>/dist/js/vendor/html5shiv.js"></script>
    <script src="<?php echo $link; ?>/dist/js/vendor/respond.min.js"></script>
    <![endif]-->
</head>
<body >
<div class="container">

    <div style="margin-top:10px;" class="row demo-row">
        <div class="col-xs-12">
            <nav class="navbar navbar-inverse navbar-embossed" role="navigation">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse-01">
                        <span class="sr-only">Toggle navigation</span>
                    </button>
                    <a class="navbar-brand" href="#">Kimlika &nbsp;&nbsp;</a>
                </div>
                <div class="collapse navbar-collapse" id="navbar-collapse-01">
                    <ul class="nav navbar-nav navbar-left">
                        <li><a href="<?php echo $link; ?>/index.php">Anasayfa</a></li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Yeni Öğrenci <b class="caret"></b></a>
                            <span class="dropdown-arrow"></span>
                            <ul class="dropdown-menu">
                                <li><a href="<?php echo $link; ?>/ogrenci/New/1">Excel'den Aktar</a></li>
                                <li><a href="<?php echo $link; ?>/ogrenci/New/2">Tek Ekle</a></li>

                                <li class="divider"></li>
                                <li><a href="<?php echo $link; ?>/okul/New">Yeni Okul</a></li>
                            </ul>
                        </li>
                        <li><a href="<?php echo $link; ?>/okul/New">Yeni Okul</a></li>
                        <li><a href="<?php echo $link; ?>/ogrenci/New/3">Yeni Fotoğraf</a></li>
                        <li><a><img src="<?php echo $link; ?>/logoy.png" height="20px"/></a></li>
                    </ul>

                </div><!-- /.navbar-collapse -->

            </nav><!-- /navbar -->
        </div>
    </div> <!-- /row -->