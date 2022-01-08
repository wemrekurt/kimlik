<?php require_once('db.php');
include('olmasi.php');



    if($_POST){
        // Veriler $_POST ile çekilip değişkenlere atansın


        if($_POST['_token']=='new'){
            // Yeni Kimlik Ekle

        }elseif($_POST['_token']=='edit'){
            // Kimlik Düzenle



        }
    }
$goster=false;
if(!empty($_GET)){

    $id=intval($_GET['id']);
    $islem=$_GET['islem'];
    $goster=true;

    $OkulBilgi=$db->query("SELECT * FROM okul WHERE id='{$id}'")->fetch(PDO::FETCH_ASSOC);



    if($OkulBilgi){

        if(!empty($_GET['kimlikid'])){

            $kimlikid=$_GET['kimlikid'];
            $KimlikBilgi=$db->query("SELECT * FROM kimlik WHERE okulid='{$id}' AND id='{$kimlikid}'")->fetch(PDO::FETCH_ASSOC);

            if($KimlikBilgi){
                //kimlik değişkenleri

            }else{
                $goster=false;
            }

        }


    }else{
        $goster=false;
    }
}

if($goster==true){

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

<body>

<?php if($islem=='New' and !empty($id)){ ?>
<div style="margin-left:450px; margin-top:50px; width:300px; height:300px;">
    <h1>Kimlik Editörü</h1>
    <div class="kimlikdis">
        <div class="genel" id="genel">
            <div class="header" id="header">
                <div class="kucuklogo" style="margin-left:1px;"> <img src="<?php echo $link; ?>/editor/meblogo.png" width="48px" height="48px" /></div>
                <div class="kimlikbaslik"><strong><?php echo $OkulBilgi['okuladi']; ?></strong><br />
                    <div id="karti" style="font-size:10px;"><?php echo $OkulBilgi['yil']; ?> <span>Öğrenci Kimlik Kartı</span></div>
                </div>
                <div class="kucuklogo"> <img src="<?php echo $link; ?>/okul/<?php echo $OkulBilgi['sef']; ?>/logo.png" width="48px" height="48px" /></div>
            </div>
            <div class="bilgiler">
                <div class="resim">
                    <img src="<?php echo $link; ?>/editor/materyal/ogrenci.png" height="130px; width:87px;" />
                </div>
                <div class="info">
                    <div class="tablo">
                        <table  >

                            <tr ><td><b><p>Adı</p></b></td><td><b>:</b></td><td ><div style="width:150px;"><b><p>EMRE</p></b></div></td></tr>
                            <tr><td><b><p>Soyadı</p></b></td><td><b>:</b></td><td><b><p>KURT</p></b></td></tr>
                            <tr><td><b><p>Sınıf/No</p></b></td><td><b>:</b></td><td><b><p>9-A, 123</p></b></td></tr>
                            <tr id="tckn" style="display:none;"><td><b><p>TC No</p></b></td><td><b>:</b></td><td><b><p>67993044350</p></b></td></tr>
                            <tr id="bolum" style="display:none;"><td><b><p>Bölüm</p></b></td><td><b>:</b></td><td><b><p>Elektrik - Elektronik</p></b></td></tr>
                        </table>
                    </div>


                    <div id="ogrencisidir" style="height:15px; padding-top:10px; width:100%; font-size:10px; font-family:Tahoma; font-weight:bold;">
                        Okulumuz Öğrencisidir.</div>
                    <div class="qr"> <div style="float:left;">


                        </div></div>
                    <div class="muduradi"><?php echo $OkulBilgi['muduradi']; ?><br />OKUL MÜDÜRÜ</div>

                </div>

            </div>

        </div>
    </div>
    <h1>Yerleşim</h1>
    <div class="kimlikdis">
        <div class="genel" style="background: url(<?php echo $link; ?>/editor/materyal/arkaplan.png);" id="genel">
            <div class="header" style="background: url(<?php echo $link; ?>/editor/materyal/BantArka.png);" id="header">
                <div class="kucuklogo" style="margin-left:1px;"> <img src="<?php echo $link; ?>/editor/materyal/meblogo.png" width="48px" height="48px" /></div>
                <div class="kimlikbaslik" ><br />
                </div>
                <div class="kucuklogo"> <img src="<?php echo $link; ?>/editor/materyal/okullogo.png" width="48px" height="48px" /></div>
            </div>
            <div class="bilgiler">
                <div class="resim">
                    <img src="<?php echo $link; ?>/editor/materyal/ogrenci.png" height="130px; width:87px;" />
                </div>
                <div class="info">
                    <div class="tablo">
                        <table  >

                        </table>
                    </div>


                    <div id="ogrencisidir" style="height:15px; padding-top:10px; width:100%; font-size:10px; font-family:Tahoma; font-weight:bold;">
                    </div>
                    <div class="qr"> <div style="float:left;">


                        </div></div>
                    <div class="muduradi"</div>

            </div>

        </div>

    </div>

</div>

<form action="<?php echo $link; ?>/okul.php" method="post">
<input type="hidden" value="<?php echo $OkulBilgi['id']; ?>" name="okulid" />
<input type="hidden" value="0699cd76f97ead0837a6fd0718bbb283" name="_token" />
    <div id="panel">
        <div class="subpanel">
            <div class="left-">
                <h2>Gövde Ayarları</h2> <hr />

                <label for="karttur">Kart Türü</label>
                <select id="karttur" name="karttur">
                    <?php
                    $kartturler=array(
                        1   => 'Kimlik Kartı',
                        2   => 'Yemekhane Kartı',
                        3   => 'Çıkış Kartı',
                        4   => 'İzin Kartı',
                        5   => 'Yatakhane Kartı'

                    );
                    foreach($kartturler as $key=>$bilgisi){?>

                    <option value="<?php echo $key; ?>"><?php echo $bilgisi; ?></option>
                    <?php } ?>
                </select>


                <label for="pozadina">Arkaplan Rengi</label>
                <input id="pozadina" class="pozadina" value="#ffffff" name="pozadina" type="text" />

                <label for="naslovi">Yazı Rengi</label>
                <input id="naslovi" class="naslovi" value="#000" name="naslovi" type="text" />

                <label for="discerceve">Dış Çerçeve</label>
                <input id="discerceve" value="#000000" name="discerceve" type="text" />

                <label for="tc">TC Göster</label>
                <select id="tc" name="tc">
                    <option value="">Var</option>
                    <option selected value="none">Yok</option>
                </select>

                <label for="bolumgos">Bölüm Göster</label>
                <select id="bolumgos" name="bolumgos">
                    <option value="">Var</option>
                    <option selected value="none">Yok</option>
                </select>

                <label for="ogrencigos">Okulumuz Öğrencisi Göster</label>
                <select id="ogrencigos" name="ogrencigos">
                    <option selected value="">Var</option>
                    <option value="none">Yok</option>
                </select>

                <label for="fonts">Yazı Fontu</label>
                <select id="fonts" name="font">
                    <option value="Questrial">Questrial</option>
                    <option value="Roboto-Medium">Roboto</option>
                    <option value="Raleway-Medium">Raleway</option>
                    <option value="Inder-Regular">Inder</option>
                    <option value="Kaushan-Regular">Kaushan</option>
                    <option value="Exo-Regular">Exo</option>
                    <option value="DuruSans-Regular">Duru</option>
                    <option value="Cagliostro">Cagliostro</option>
                    <option value="Marko One">Marko One</option>
                    <option value="Calibri">Calibri</option>
                    <option value="Verdana">Verdana</option>
                    <option selected value="Arial">Arial</option>
                    <option value="Times New Roman">Times N.Roman</option>
                    <option value="Myriad Pro">Myriad Pro</option>
                </select>

                <label for="yazia">Yazı Aralığı</label>
                <select id="yazia" name="yazia">
                    <option value="1px">1</option>
                    <option value="3px">3</option>
                    <option value="5px">5</option>
                    <option value="7px">7</option>
                </select>

                <label for="yaziboyut">Yazı Boyutu</label>
                <select id="yaziboyut" name="yaziboyut">
                    <option value="10px">10</option>
                    <option value="12px">12</option>
                    <option selected value="13px">13</option>
                    <option value="14px">14</option>
                    <option value="16px">16</option>
                </select>
                <br />

                <label for="muduryazi">Müdür Yazi Boyutu</label>
                <select id="muduryazi" name="muduryazi">
                    <option value="8px">8</option>
                    <option value="9px">9</option>
                    <option selected value="10px">10</option>
                    <option value="11px">11</option>
                    <option value="12px">12</option>
                    <option value="13px">13</option>
                </select>

                <label for="muduruzak">Müdür Uzaklık</label>
                <select id="muduruzak" name="muduruzak">
                    <option value="1px">1</option>
                    <option value="2px">2</option>
                    <option value="3px">3</option>
                    <option value="5px">5</option>
                    <option value="7px">7</option>
                    <option value="9px">9</option>
                    <option value="10px">10</option>
                    <option value="12px">12</option>
                    <option value="14px">14</option>
                    <option value="16px">16</option>
                </select>

            </div>


            <div class="right-">
                <h2>Üst Şerit Ayarları</h2><hr />
                <label for="emre">Bant Arkaplan Renk</label>
                <input id="emre" value="#ff0000" name="emre" type="text" />

                <label for="bantfontrenk">Bant Yazı Renk</label>
                <input id="bantfontrenk" value="#ffffff" name="bantfontrenk" type="text" />

                <label for="bantyazi">Bant Yazı Font</label>
                <select id="bantyazi" name="bantyazi">
                    <option value="Questrial">Questrial</option>
                    <option value="Roboto-Medium">Roboto</option>
                    <option value="Raleway-Medium">Raleway</option>
                    <option value="Inder-Regular">Inder</option>
                    <option value="Kaushan-Regular">Kaushan</option>
                    <option value="Exo-Regular">Exo</option>
                    <option value="DuruSans-Regular">Duru</option>
                    <option value="Cagliostro">Cagliostro</option>
                    <option value="Marko One">Marko One</option>
                    <option value="Calibri">Calibri</option>
                    <option value="Verdana">Verdana</option>
                    <option selected value="Arial">Arial</option>
                    <option value="Times New Roman">Times N.Roman</option>
                    <option value="Myriad Pro">Myriad Pro</option>
                </select>


                <label for="ustbasboy">Üst Başlık Yazı Boyutu</label>
                <select id="ustbasboy" name="ustbasboy">
                    <option value="10px">10</option>
                    <option value="11px">11</option>
                    <option selected value="12px">12</option>
                    <option value="13px">13</option>
                    <option value="14px">14</option>
                    <option value="15px">15</option>
                </select>

                <label for="ustbassatir">Üst Başlık Satır Aralığı</label>
                <select id="ustbassatir" name="ustbassatir">
                    <option value="0.8em">0.8</option>
                    <option value="0.9em">0.9</option>
                    <option selected value="1em">1</option>
                    <option value="1.1em">1.1</option>
                    <option value="1.2em">1.2</option>
                    <option value="1.3em">1.3</option>
                    <option value="1.4em">1.4</option>
                    <option value="1.5em">1.5</option>
                    <option value="1.6em">1.6</option>
                    <option value="1.7em">1.7</option>
                    <option value="1.8em">1.8</option>
                    <option value="1.9em">1.9</option>
                    <option value="2em">2</option>
                </select>

                <label for="altgos">Alt Başlık Göster</label>
                <select id="altgos" name="altgos">
                    <option value="">Var</option>
                    <option value="none">Yok</option>
                </select>

                <label for="altbasboy">Alt Başlık Yazı Boyutu</label>
                <select id="altbasboy" name="altbasboy">
                    <option value="8px">8</option>
                    <option value="9px">9</option>
                    <option selected value="10px">10</option>
                    <option value="11px">11</option>
                </select>

                <label for="bantaltbaslik">Alt Başlık Uzaklığı</label>
                <select id="bantaltbaslik" name="bantaltbaslik">
                    <option value="1px">1</option>
                    <option value="3px">3</option>
                    <option value="5px">5</option>
                    <option value="7px">7</option>
                </select>


                <label for="cizgigos">Şerit Alt Çizgi</label>
                <select id="cizgigos" name="cizgigos">
                    <option value="1px solid">Var</option>
                    <option value="">Yok</option>
                </select>
                <br />
                <hr />
                <input type="submit" value="Gönder" />



            </div>


        </div>

        <div class="trigger"></div>

    </div> <!-- End of Panel -->

</form>


<?php }elseif($islem=='Edit' and !empty($id)){ ?>



<?php } ?>


<!-- JS's -->
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<script>window.Jquery || document.write('<script src="<?php echo $link; ?>/editor/js/jquery1.7.2"><\/script>')</script>
<script type="text/javascript" src="<?php echo $link; ?>/editor/js/jquery.miniColors.min.js"></script>
<script type="text/javascript" src="<?php echo $link; ?>/editor/js/easing.js"></script>

<script type="text/javascript">
    $(document).ready(function() {

         $('#karttur').on('change', function() {
         var icerigi= this.value; // or $(this).val()
         if(icerigi==1){
            icerigi = 'Öğrenci Kimlik Kartı';
         }else if(icerigi==2){
            icerigi = 'Öğrenci Yemek Kartı';
         }else if(icerigi==3){
            icerigi= 'Öğrenci Çıkış Kartı';
         }else if(icerigi==4){
            icerigi= 'Öğrenci İzin Kartı';
         }else if (icerigi==5){
            icerigi= 'Yatakhane Kartı';
         }
         $('#karti span').text(icerigi);
          console.log(icerigi);
        });
    });


</script>


<script type="text/javascript">

    $(document).ready(function() {

        $('.trigger').click(function() {
            if($(this).parent().css('left') == '-390px') {
                $(this).parent().animate({'left': '0'}, 1500, 'easeInQuart');
            }
            else {
                $(this).parent().animate({'left': '-390px'}, 1000, 'easeInBounce');
            }
        });
        $('.pozadina').miniColors({
            letterCase: 'uppercase',
            change: function(hex, rgb) {
                smenipozadina(hex);
            }
        });
        function smenipozadina(hex) {
            $('#genel').css('background-color', hex);
        }

        $('#emre').miniColors({
            letterCase: 'uppercase',
            change: function(hex, rgb) {
                emrek(hex);
            }
        });
        function emrek(hex) {
            $('#header').css('background-color', hex);
        }

        $('#discerceve').miniColors({
            letterCase: 'uppercase',
            change: function(hex, rgb) {
                cerceve(hex);
            }
        });
        function cerceve(hex) {
            $('.genel').css('border-color', hex);
        }


        $('#bantfontrenk').miniColors({
            letterCase: 'uppercase',
            change: function(hex, rgb) {
                bantfont(hex);
            }
        });
        function bantfont(hex) {
            $('.kimlikbaslik').css('color', hex);
        }


        $('.naslovi').miniColors({
            letterCase: 'uppercase',
            change: function(hex, rgb) {
                smeninaslovi(hex);
            }
        });
        function smeninaslovi(hex) {
            $('#genel').css('color', hex);
        }

        $('#fonts').bind('change', function() {
            var font = $(this).val();
            $('.tablo').css('fontFamily', font);
        });

        $('#yazia').bind('change', function() {
            var font = $(this).val();
            $('.tablo p').css('padding-bottom', font);
        });

        $('#yaziboyut').bind('change', function() {
            var font = $(this).val();
            $('.tablo p').css('font-size', font);
        });

        $('#muduryazi').bind('change', function() {
            var font = $(this).val();
            $('.muduradi').css('font-size', font);
        });

        $('#bantyazi').bind('change', function() {
            var font = $(this).val();
            $('.kimlikbaslik').css('fontFamily', font);
        });

        $('#bantaltbaslik').bind('change', function() {
            var bantyaziara = $(this).val();
            $('#karti').css('padding-top', bantyaziara);
        });

        $('#ustbasboy').bind('change', function() {
            var font = $(this).val();
            $('.kimlikbaslik strong').css('font-size', font);
        });

        $('#ustbassatir').bind('change', function() {
            var font = $(this).val();
            $('.kimlikbaslik strong').css('line-height', font);
        });

        $('#altbasboy').bind('change', function() {
            var font = $(this).val();
            $('#karti').css('font-size', font);
        });

        $('#altgos').bind('change', function() {
            var font = $(this).val();
            $('#karti').css('display', font);
        });

        $('#tc').bind('change', function() {
            var font = $(this).val();
            $('#tckn').css('display', font);
        });

        $('#bolumgos').bind('change', function() {
            var font = $(this).val();
            $('#bolum').css('display', font);
        });

        $('#ogrencigos').bind('change', function() {
            var font = $(this).val();
            $('#ogrencisidir').css('display', font);
        });


        $('#cizgigos').bind('change', function() {
            var font = $(this).val();
            $('#header').css('border-bottom', font);
        });

        $('#muduruzak').bind('change', function() {
            var font = $(this).val();
            $('.muduradi').css('padding-top', font);
        });



    });
</script>

</body>
</html>
<?php }else{
    echo 'Yanlış Parametreler!';
}
?>
<!-- EOF -->












