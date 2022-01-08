<?php
/**
 * Created by PhpStorm.
 * User: Emre
 * Date: 29.9.2015
 * Time: 21:23
 */
require_once('db.php');
include('olmasi.php');

function tantuni($bizimki){

    $bul = array(1, 2, 3, 4, 5);
    $degistir = array('Kimik Kartı', 'Yemekhane Kartı', 'Çıkış Kartı', 'İzin Kartı', 'Yatakhane Kartı');
    return str_replace($bul,$degistir,$bizimki);
}

$id=@intval($_POST['id']);
$kimlikid=@intval($_POST['kimlik']);
$marka=$_POST['marka'];

$Sayfa  = @intval($_POST['sayfa']); if(!$Sayfa) $Sayfa = 1;
$Limit	= 30;
$GorunenSayfa   = 3;
$sayy=$db->query("SELECT COUNT(*) AS sayisi FROM ogrenci WHERE okulid='{$id}'")->fetch(PDO::FETCH_ASSOC);
$ToplamVeri=$sayy['sayisi'];
$Sayfa_Sayisi	= ceil($ToplamVeri/$Limit); if($Sayfa > $Sayfa_Sayisi){$Sayfa = 1;}
$Goster   = $Sayfa * $Limit - $Limit;

$OkulBilgi=$db->query("SELECT * FROM okul WHERE id='{$id}'")->fetch(PDO::FETCH_ASSOC);
$KimlikSor=$db->query("SELECT * FROM ogrenci WHERE okulid='{$id}' ORDER BY id DESC limit $Goster,$Limit",PDO::FETCH_ASSOC);
$TumKimlikler = $db->query("SELECT id AS kim,tur FROM kimlik WHERE okulid='{$id}'", PDO::FETCH_ASSOC);
$KimlikBilgi=$db->query("SELECT * FROM kimlik WHERE id='{$kimlikid}' AND okulid='{$id}'")->fetch(PDO::FETCH_ASSOC);
?>


<div id="genelle">

        <?php foreach($KimlikSor as $bil) {
    $FotoYol= realpath('').'/okul/'.$OkulBilgi['sef'].'/'.$bil['numara'].'.jpg';

    if(file_exists($FotoYol)){
        $Fotograf=$link.'/okul/'.$OkulBilgi['sef'].'/'.$bil['numara'].'.jpg';
    }else{
        $Fotograf=$link.'/editor/materyal/ogrenci.png';
    }
    ?>

    <div class="kimlikdis">
        <div class="genel" style="background-color:<?php echo $KimlikBilgi['Gbgcolor']; ?>; color:<?php echo $KimlikBilgi['Gtxtcolor']; ?>; border-color:<?php echo $KimlikBilgi['Gbordercolor']; ?>;" id="genel">
            <div class="header" style="border-bottom:<?php echo $KimlikBilgi['Baltczg']; ?>; background-color:<?php echo $KimlikBilgi['Bbgcolor']; ?>;" id="header">
                <div class="kucuklogo" style="margin-left:1px;"> <img src="<?php echo $link; ?>/editor/meblogo.png" width="48px" height="48px" /></div>
                <div class="kimlikbaslik" style="font-family:<?php echo $KimlikBilgi['Bfont']; ?>;  color:<?php echo $KimlikBilgi['Btxcolor']; ?>;">
                    <strong style="font-size:<?php echo $KimlikBilgi['Btxsize']; ?>; line-height:<?php echo $KimlikBilgi['Bline']; ?>;"><?php echo $OkulBilgi['okuladi']; ?></strong><br />
                    <div id="karti" style="padding-top:<?php echo $KimlikBilgi['Baltuzk']; ?>; font-size:<?php echo $KimlikBilgi['Baltsize']; ?>; display:<?php echo $KimlikBilgi['Baltgoster']; ?>;"><?php echo $OkulBilgi['yil']; ?>
                        <span><?php echo tantuni($KimlikBilgi['tur']); ?></span></div>
                </div>
                <div class="kucuklogo"> <img src="<?php echo $link; ?>/okul/<?php echo $OkulBilgi['sef']; ?>/logo.png" width="48px" height="48px" /></div>
            </div>
            <div class="bilgiler">
                <div class="resim">
                    <img src="<?php echo $Fotograf; ?>" height="130px; width:87px;" />
                </div>
                <div class="info">
                    <div class="tablo">
                        <table style="font-family:<?php echo $KimlikBilgi['Gfont']; ?>; font-size:<?php echo $KimlikBilgi['Gtxsize']; ?>;" >

                            <tr ><td><b><p>Adı</p></b></td><td><b>:</b></td><td ><div style="width:150px;"><b><p style="padding-bottom: <?php echo $KimlikBilgi['Gline']; ?>;"><?php echo $bil['isim'];?></p></b></div></td></tr>
                            <tr><td><b><p>Soyadı</p></b></td><td><b>:</b></td><td><b><p style="padding-bottom: <?php echo $KimlikBilgi['Gline']; ?>;"><?php echo $bil['soyisim'];?></p></b></td></tr>
                            <tr><td><b><p>Sınıf/No</p></b></td><td><b>:</b></td><td><b><p style="padding-bottom: <?php echo $KimlikBilgi['Gline']; ?>;"><?php echo $bil['sinif'];?>, <?php echo $bil['numara'];?></p></b></td></tr>
                            <tr id="tckn" style="display:<?php echo $KimlikBilgi['Gtcgoster']; ?>;"><td><b><p style="padding-bottom: <?php echo $KimlikBilgi['Gline']; ?>;"><?php echo $bil['tcno'];?></p></b></td><td><b>:</b></td><td><b><p>67993044350</p></b></td></tr>
                            <tr id="bolum" style="display:<?php echo $KimlikBilgi['Gbolumgoster']; ?>;"><td><b><p style="padding-bottom: <?php echo $KimlikBilgi['Gline']; ?>;"><?php echo $bil['bolum'];?></p></b></td><td><b>:</b></td><td><b><p>Elektrik - Elektronik</p></b></td></tr>
                        </table>
                    </div>


                    <div id="ogrencisidir" style="display:<?php echo $KimlikBilgi['Gokulogrenci']; ?>;height:15px; padding-top:10px; width:100%; font-size:10px; font-family:Tahoma; font-weight:bold;">
                        Okulumuz Öğrencisidir.</div>
                    <div class="qr"> <div style="float:left;">


                        </div></div>
                    <div class="muduradi" style="font-size:<?php echo $KimlikBilgi['Gmdsize']; ?>; padding-top:<?php echo $KimlikBilgi['Gmduzk']; ?>;"><?php echo $OkulBilgi['muduradi']; ?><br />OKUL MÜDÜRÜ</div>
                    <?php if($marka==1){ ?>
                        <div class="logosag"><img src="<?php echo $link; ?>/logod.png" height="70px" /></div>
                    <?php } ?>

                </div>

            </div>

        </div>


    </div>

<?php } ?>
</div>
