<?php
require_once('db.php');
include('olmasi.php');

$id=intval($_GET['okulid']);


$goster=true;

$OkulBilgi=$db->query("SELECT * FROM okul WHERE id='{$id}'")->fetch(PDO::FETCH_ASSOC);


if($OkulBilgi){

    if(!empty($_GET['kimlikid'])){

        $kimlikid=$_GET['kimlikid'];
        $KimlikBilgi=$db->query("SELECT * FROM kimlik WHERE id='{$kimlikid}' AND okulid='{$id}'")->fetch(PDO::FETCH_ASSOC);

        if($KimlikBilgi){
            //kimlik değişkenleri

        }else{
            $goster=false;
        }

    }


}else{
    $goster=false;
}

if($goster==true){
    $bul = array(1, 2, 3, 4, 5);
    $degistir = array('Öğrenci Kimik Kartı', 'Yemekhane Kartı', 'Öğrenci Çıkış Kartı', 'Öğrenci İzin Kartı', 'Yatakhane Kartı');
?>
<!DOCTYPE html>
<head>
    <!-- BASICS -->
    <title>Kimlik Ayarları</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="shortcut icon" href="<?php echo $link; ?>/img/favicon.ico">

    <!-- CSS's -->
    <link type="text/css" rel="stylesheet" href="<?php echo $link; ?>/editor/css/style.css">
    <link type="text/css" rel="stylesheet" href="<?php echo $link; ?>/editor/css/jquery.miniColors.css">
    <link href='http://fonts.googleapis.com/css?family=Questrial|Emblema+One|Cagliostro|Marko+One' rel='stylesheet' type='text/css'>
        <style>
    .genel{
    background:url(<?php echo $link; ?>/okul/<?php echo $OkulBilgi['sef']; ?>/arkaplan.png) no-repeat center;
    }
    </style>
</head>

<body style="margin-left:150px; margin-top:10px;">
<div class="kimlikdis">
    <div class="genel" style="background-color:<?php echo $KimlikBilgi['Gbgcolor']; ?>; color:<?php echo $KimlikBilgi['Gtxtcolor']; ?>; border-color:<?php echo $KimlikBilgi['Gbordercolor']; ?>;" id="genel">
        <div class="header" style="border-bottom:<?php echo $KimlikBilgi['Baltczg']; ?>; background-color:<?php echo $KimlikBilgi['Bbgcolor']; ?>;" id="header">
            <div class="kucuklogo" style="margin-left:1px;"> <img src="<?php echo $link; ?>/editor/meblogo.png" width="48px" height="48px" /></div>
            <div class="kimlikbaslik" style="font-family:<?php echo $KimlikBilgi['Bfont']; ?>;  color:<?php echo $KimlikBilgi['Btxcolor']; ?>;">
                <strong style="font-size:<?php echo $KimlikBilgi['Btxsize']; ?>; line-height:<?php echo $KimlikBilgi['Bline']; ?>;"><?php echo $OkulBilgi['okuladi']; ?></strong><br />
                <div id="karti" style="padding-top:<?php echo $KimlikBilgi['Baltuzk']; ?>; font-size:<?php echo $KimlikBilgi['Baltsize']; ?>; display:<?php echo $KimlikBilgi['Baltgoster']; ?>;"><?php echo $OkulBilgi['yil']; ?>
                <span><?php echo str_replace($bul, $degistir, $KimlikBilgi['tur']); ?></span></div>
            </div>
            <div class="kucuklogo"> <img src="<?php echo $link; ?>/okul/<?php echo $OkulBilgi['sef']; ?>/logo.png" width="48px" height="48px" /></div>
        </div>
        <div class="bilgiler">
            <div class="resim">
                <img src="<?php echo $link; ?>/editor/materyal/ogrenci.png" height="130px; width:87px;" />
            </div>
            <div class="info">
                <div class="tablo">
                    <table style="font-family:<?php echo $KimlikBilgi['Gfont']; ?>; font-size:<?php echo $KimlikBilgi['Gtxsize']; ?>;" >

                        <tr ><td><b><p>Adı</p></b></td><td><b>:</b></td><td ><div style="width:150px;"><b><p style="padding-bottom: <?php echo $KimlikBilgi['Gline']; ?>;">EMRE</p></b></div></td></tr>
                        <tr><td><b><p>Soyadı</p></b></td><td><b>:</b></td><td><b><p style="padding-bottom: <?php echo $KimlikBilgi['Gline']; ?>;">KURT</p></b></td></tr>
                        <tr><td><b><p>Sınıf/No</p></b></td><td><b>:</b></td><td><b><p style="padding-bottom: <?php echo $KimlikBilgi['Gline']; ?>;">9-A, 123</p></b></td></tr>
                        <tr id="tckn" style="display:<?php echo $KimlikBilgi['Gtcgoster']; ?>;"><td><b><p style="padding-bottom: <?php echo $KimlikBilgi['Gline']; ?>;">TC No</p></b></td><td><b>:</b></td><td><b><p>67993044350</p></b></td></tr>
                        <tr id="bolum" style="display:<?php echo $KimlikBilgi['Gbolumgoster']; ?>;"><td><b><p style="padding-bottom: <?php echo $KimlikBilgi['Gline']; ?>;">Bölüm</p></b></td><td><b>:</b></td><td><b><p>Elektrik - Elektronik</p></b></td></tr>
                    </table>
                </div>


                <div id="ogrencisidir" style="display:<?php echo $KimlikBilgi['Gokulogrenci']; ?>;height:15px; padding-top:10px; width:100%; font-size:10px; font-family:Tahoma; font-weight:bold;">
                    Okulumuz Öğrencisidir.</div>
                <div class="qr"> <div style="float:left;">


                    </div></div>
                <div class="muduradi" style="font-size:<?php echo $KimlikBilgi['Gmdsize']; ?>; padding-top:<?php echo $KimlikBilgi['Gmduzk']; ?>;"><?php echo $OkulBilgi['muduradi']; ?><br />OKUL MÜDÜRÜ</div>

            </div>

        </div>

    </div>


</div>

</body>
</html><br />
<?php

}else{ echo 'kimlik yok';} ?>