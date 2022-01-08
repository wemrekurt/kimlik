<?php
require_once('db.php');
include('olmasi.php');

if($_POST){
    $OkulBil=$db->query("SELECT * FROM okul WHERE id='{$_POST['okulid']}'")->fetch(PDO::FETCH_ASSOC);
    $OgrBil=$db->query("SELECT * FROM ogrenci WHERE okulid='{$_POST['okulid']}' AND sinif='{$_POST['sinif']}'",PDO::FETCH_ASSOC);
    $Siniflar = $db->query("SELECT DISTINCT sinif AS Sinif FROM ogrenci WHERE okulid='{$_POST['okulid']}'", PDO::FETCH_ASSOC);
?>
<head>
    <meta charset="utf8" />
    <title><?php echo $_POST['sinif']; ?></title>
    <script src="<?php echo $link; ?>/js/jquery-latest.min.js" type="text/javascript"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $(".flip").click(function() {
                $(".panel").slideToggle("slow");
            });
        });
    </script>

    <style type="text/css">
        body {
            margin: 0;
            padding: 0;
            border: 0;
            font-size: 100%;
            vertical-align: baseline;
        }

        .logo {
            width:100px;
            height:auto;
            float:left;

        }

        .orta {
            width:750px;
            height:auto;
            float:left;
            font-family: Verdana;
            font-size:25px;
            font-weight:bold;
            text-align:center;
            padding-top:10px;
        }

        .main{

            width:980px;
            height:auto;
            margin:0 auto;
            float:center;

        }
        p.flip {
            position:absolute;
            left:0;
            top:0;
            text-align: center;
            color:white;
            cursor:pointer;


        }
        p.flip:hover{
            color:black;
        }

        div.panel {
            padding-left:100px;
            width: 50%;
            height: 20px;
            display: none;
        }
    </style>
</head>
<body>
    <div class="panel">
        <form action="album.php" method="post">
            <input type="hidden" value="<?php echo $_POST['okulid']; ?>" name="okulid" />
            <select name="sinif">
                <?php foreach($Siniflar as $sbilgi){ ?>
                    <option <?php if($sbilgi['Sinif']==$_POST['sinif']){echo 'selected';} ?> value="<?php echo $sbilgi['Sinif']; ?>"><?php echo $sbilgi['Sinif']; ?></option>
                <?php } ?>
            </select>

            <input type="submit" value="Oluştur" />
            <a href="<?php echo $link; ?>/okul/View/<?php echo $_POST['okulid']; ?>">Okula Dön</a>
            <?php echo $uyarimizA; ?>
        </form>

    </div>
    <p class="flip">x</p>

<div class="main" >
    <div class="logo">
        <img src="<?php echo $link.'/okul/'.$OkulBil['sef'].'/logo.png'; ?>" width="100px" />
    </div>
    <div class="orta">
        <?php echo $OkulBil['yil']; ?> ÖĞRETİM YILI <br /> <?php echo $OkulBil['okuladi'].' &nbsp; '.$_POST['sinif']; ?> ALBÜMÜ
    </div>
    <div class="logo">
        <img src="<?php echo $link.'/editor/meblogo.png'; ?>" width="100px" />
    </div>
    <div style="clear:both; height:20px;"></div>
    <?php foreach($OgrBil as $Ogr) {
        $dosya=realpath('okul').'/'.$OkulBil['sef'].'/'.$Ogr['numara'].'.jpg';
        if(file_exists($dosya)){
            $fotoyol=$link.'/okul/'.$OkulBil['sef'].'/'.$Ogr['numara'].'.jpg';
        }else{
            $fotoyol=$link.'/img/fotoyok.png';
        }
        ?>
        <div style="width:120px; height:250px; float:left;">
            <?php echo '<img width="100px" src="'.$fotoyol.'"><br />';
            ?>
            <div
                style="font-family:Arial; width:100px; float:left; text-align:center; font-size:15px; font-weight:bold;">
                <?php echo $Ogr['numara'] . '<br />';
                echo $Ogr['isim'] . ' ' . $Ogr['soyisim'];
                ?>
            </div>

        </div>


    <?php } ?>
    <div style="float:right; width:1000px; height:8px; margin-top:-15px; margin-right:40px; text-align:right;"><img src="<?php echo $link; ?>/logoy.png" width="150px" /></div>
</div>

</body>

<?php } ?>