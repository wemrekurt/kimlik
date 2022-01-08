<?php
/**
 * Created by PhpStorm.
 * User: Emre
 * Date: 29.9.2015
 * Time: 19:57
 */
require_once('db.php');
if($_POST){
    include('olmasi.php');
    function tantuni($bizimki){

        $bul = array(1, 2, 3, 4, 5);
        $degistir = array('Kimik Kartı', 'Yemekhane Kartı', 'Çıkış Kartı', 'İzin Kartı', 'Yatakhane Kartı');
        return str_replace($bul,$degistir,$bizimki);
    }

    $id=@intval($_POST['id']);
    $kimlikid=@intval($_POST['kimlik']);
    if(!empty($_POST['marka'])){ $marka=$_POST['marka']; }else{ $marka=0; }


    $Sayfa  = 1; if(!$Sayfa) $Sayfa = 1;
    $Limit	= 30;

    $sayy=$db->query("SELECT COUNT(*) AS sayisi FROM ogrenci WHERE okulid='{$id}'")->fetch(PDO::FETCH_ASSOC);
    $ToplamVeri=$sayy['sayisi'];
    $Sayfa_Sayisi	= ceil($ToplamVeri/$Limit); if($Sayfa > $Sayfa_Sayisi){$Sayfa = 1;}


    $OkulBilgi=$db->query("SELECT * FROM okul WHERE id='{$id}'")->fetch(PDO::FETCH_ASSOC);
    $KimlikSor=$db->query("SELECT * FROM ogrenci WHERE okulid='{$id}' ORDER BY id DESC limit 0,30",PDO::FETCH_ASSOC);
    $TumKimlikler = $db->query("SELECT id AS kim,tur FROM kimlik WHERE okulid='{$id}'", PDO::FETCH_ASSOC);
    $KimlikBilgi=$db->query("SELECT * FROM kimlik WHERE id='{$kimlikid}' AND okulid='{$id}'")->fetch(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<head>
    <!-- BASICS -->
    <title>Kimlik</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="shortcut icon" href="<?php echo $link; ?>/img/favicon.ico">
    <script src="<?php echo $link; ?>/js/jquery-latest.min.js" type="text/javascript"></script>

    <!-- CSS's -->
    <link type="text/css" rel="stylesheet" href="<?php echo $link; ?>/editor/css/style.css">
    <link type="text/css" rel="stylesheet" href="<?php echo $link; ?>/editor/css/jquery.miniColors.css">
    <link href='http://fonts.googleapis.com/css?family=Questrial|Emblema+One|Cagliostro|Marko+One' rel='stylesheet' type='text/css'>
    <style>
        .genel{
            background:url(<?php echo $link; ?>/okul/<?php echo $OkulBilgi['sef']; ?>/arkaplan.png) no-repeat center;
        }
    </style>
    <script type="text/javascript">
        $(document).ready(function() {
            $(".flip").click(function() {
                $(".panel").slideToggle("slow");
            });
        });


    </script>

    <style type="text/css">
        p.flip {
            position:absolute;
            left:0;
            top:0;
            text-align: center;
            color:white;
            cursor:pointer

        }
        p.flip:hover{
            color:black;
        }

        div.panel {
            padding-left:100px;
            width: 80%;
            height: 20px;
            display: none;
        }
    </style>

    <script src="js/iletisim.js"></script>

    <script type="text/javascript">

        var ajaxNesne;

        function kontrol()
        {

            $('.panel').slideToggle("slow");

            nesne	= ajaxNesne;
            metot	= 'POST';
            dosya	= 'test.php';
            fonksiyon=ajaxgerigetir;

            id=document.getElementById('id').value;
            kimlik=document.getElementById('kimlik').value;
            sayfa=document.getElementById('sayfa').value;
            marka=document.getElementById('marka').value;


            degisken='id='+id+'&kimlik='+kimlik+'&sayfa='+sayfa+'&marka='+marka;


            ajaxistek(nesne,metot,dosya,degisken,fonksiyon);
        }

        function ajaxgerigetir()
        {
            if(ajaxNesne.readyState==4)
            {
                if(ajaxNesne.status==200)
                {
                    mesaj = ajaxNesne.responseText;
                    document.getElementById('sonuc').innerHTML=mesaj;
                }
                else{
                    document.getElementById('sonuc').innerHTML="Hata Oluştu!";
                    alert("Hata" +ajaxNesne.status);
                }

            }else
            {
                document.getElementById('sonuc').innerHTML = "İşlem Yapılıyor";
            }

        }

    </script>
</head>
<body>
<div class="panel">
    <form action="kimlikm.php" method="post">
        <input type="hidden" value="<?php echo $id; ?>" id="id" />
        Marka:
       <select onchange="kontrol()" id="marka">
           <option <?php if($marka==1){echo 'selected';} ?> value="1">Var</option>
           <option value="0">Yok</option>
       </select>
        Kart:
        <select onchange="kontrol()" id="kimlik">
            <?php foreach($TumKimlikler as $kbilgi){ ?>
                <option <?php if($kbilgi['kim']==$kimlikid){echo 'selected';} ?> value="<?php echo $kbilgi['kim']; ?>"><?php echo $kbilgi['kim'].'-'.tantuni($kbilgi['tur']); ?></option>
            <?php } ?>
        </select>
        Sayfa:
        <select  onchange="kontrol()" id="sayfa">
            <?php for($i=1;$i<=$Sayfa_Sayisi;$i++){ ?>
                <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
            <?php } ?>
        </select>
        <a href="<?php echo $link; ?>/okul/View/<?php echo $id; ?>">Okula Dön</a>
        <?php echo $uyarimizK; ?>
    </form>

</div>

<p class="flip">x</p>




<div id="sonuc">
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
</pre>
</div>

</body>
</html>
<?php } else{
    echo 'Yanlış Geldin!';
}?>