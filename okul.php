<?php
/**
 * Created by PhpStorm.
 * User: Emre
 * Date: 12.9.2015
 * Time: 19:47
 */
include('header.php');
session_start();
function deleteDirectory($dir) {
    if (!file_exists($dir)) {
        return true;
    }

    if (!is_dir($dir)) {
        return unlink($dir);
    }

    foreach (scandir($dir) as $item) {
        if ($item == '.' || $item == '..') {
            continue;
        }

        if (!deleteDirectory($dir . DIRECTORY_SEPARATOR . $item)) {
            return false;
        }

    }

    return rmdir($dir);
}

$bul = array(1, 2, 3, 4, 5);
$degistir = array('Kimik Kartı', 'Yemekhane Kartı', 'Çıkış Kartı', 'İzin Kartı', 'Yatakhane Kartı');
    if($_POST){
        // Post İşlemi
        if($_POST['_token']=='1323021d8305728f5d471fa727faff01') {
            // Yeni Okul Ekle step 1
            if (!empty($_POST['okuladi']) and is_uploaded_file($_FILES['logo']['tmp_name'])) {
                $OkulSef=sef_link($_POST['okuladi']);

                $OkulSorgu=$db->query("SELECT id FROM okul WHERE sef='{$OkulSef}'")->fetch(PDO::FETCH_ASSOC);


                if(!$OkulSorgu){


                    $OkulYolu='okul/'.$OkulSef;
                    mkdir('okul/'.$OkulSef);
                    $OkulAdi = $_POST['okuladi'];
                    $OgretimYil = $_POST['ogretim'];
                    $MudurAdi=$_POST['muduradi'];



                    require 'include/class.upload.php';

                    $arkaplani = new Upload($_FILES['arkaplan']);
                    $arkaplani->file_new_name_body = 'arkaplan';
                    $arkaplani->allowed = array('image/png');
                    $arkaplani->file_max_size = '1024000';
                    $arkaplani->image_convert='png';



                    $image = new Upload($_FILES['logo']);
                    $image->file_new_name_body = 'logo';
                    $image->allowed = array('image/png');
                    $image->file_max_size = '1024000';

                    $arkaplani->Process($OkulYolu);
                    $image->Process($OkulYolu);



                    if($image->processed and $arkaplani->processed){

                        $OkulKayit=$db->prepare("INSERT INTO okul SET
                          yil=:glbl_Yil,
                          okuladi=:glbl_OkulAdi,
                          sef=:glbl_Sef,
                          muduradi=:glbl_Mudur
                        ");

                        $OkulQuery=$OkulKayit->execute(array(
                            'glbl_Yil'  => $OgretimYil,
                            'glbl_OkulAdi'=>$OkulAdi,
                            'glbl_Sef'  => $OkulSef,
                            'glbl_Mudur'=> $MudurAdi
                        ));

                        echo '<script type="text/javascript">window.location="'.$link.'/editor/New/'.$db->lastInsertId().'";</script>';

                    }else{
                        deleteDirectory($OkulYolu);
                        echo 'Şu hata söz konusu: <br />';
                        if(!empty($image->error) OR !empty($arkaplani->error)) {
                            echo 'Logo:'. $image->error.'<br />';
                            echo 'Arkaplan:' .$arkaplani->error;
                        }else{
                            echo 'Veritabanı girişi sıkıntılı.';

                        }
                    }


                }else{
                    // Bu Okul Zaten Var
                    echo 'Bu okul var zaten';
                }

            } else {
                echo 'Alanlar Boş Bırakılamaz!';
            }
        }
        elseif($_POST['_token']=='0699cd76f97ead0837a6fd0718bbb283'){
            // Yeni Kimlik Ekle

            $Postlar=array('Bilgi'=>$_POST);


            $KimlikHazirla=$db->prepare("INSERT INTO kimlik SET
                okulid=:global_OkulId,
                Gbgcolor=:g_bgcolor,
                Gtxtcolor=:g_txtcolor,
                Gbordercolor=:g_border,
                Gtcgoster=:g_tc,
                Gbolumgoster=:g_bolum,
                Gokulogrenci=:g_ogrencisidir,
                Gfont=:g_font,
                Gline=:g_aralik,
                Gtxsize=:g_yaziboyut,
                Gmdsize=:g_mudurboyut,
                Gmduzk=:g_muduruzaklik,
                Bbgcolor=:b_bgcolor,
                Btxcolor=:b_yazirenk,
                Bfont=:b_yazifont,
                Btxsize=:b_yaziboyut,
                Bline=:b_aralik,
                Baltgoster=:b_altbaslik,
                Baltsize=:b_altboyut,
                Baltuzk=:b_altuzaklik,
                Baltczg=:b_altcizgi,
                tur=:karttur
            ");

            $KimlikIsle=$KimlikHazirla->execute(array(
                'global_OkulId'     => $Postlar['Bilgi']['okulid'],
                'g_bgcolor'         => $Postlar['Bilgi']['pozadina'],
                'g_txtcolor'         => $Postlar['Bilgi']['naslovi'],
                'g_border'          => $Postlar['Bilgi']['discerceve'],
                'g_tc'              => $Postlar['Bilgi']['tc'],
                'g_bolum'           => $Postlar['Bilgi']['bolumgos'],
                'g_ogrencisidir'    => $Postlar['Bilgi']['ogrencigos'],
                'g_font'            => $Postlar['Bilgi']['font'],
                'g_aralik'          => $Postlar['Bilgi']['yazia'],
                'g_yaziboyut'       => $Postlar['Bilgi']['yaziboyut'],
                'g_mudurboyut'      => $Postlar['Bilgi']['muduryazi'],
                'g_muduruzaklik'    => $Postlar['Bilgi']['muduruzak'],
                'b_bgcolor'         => $Postlar['Bilgi']['emre'],
                'b_yazirenk'        => $Postlar['Bilgi']['bantfontrenk'],
                'b_yazifont'        => $Postlar['Bilgi']['bantyazi'],
                'b_yaziboyut'       => $Postlar['Bilgi']['ustbasboy'],
                'b_aralik'          => $Postlar['Bilgi']['ustbassatir'],
                'b_altbaslik'       => $Postlar['Bilgi']['altgos'],
                'b_altboyut'        => $Postlar['Bilgi']['altbasboy'],
                'b_altuzaklik'      => $Postlar['Bilgi']['bantaltbaslik'],
                'b_altcizgi'        => $Postlar['Bilgi']['cizgigos'],
                'karttur'           => $Postlar['Bilgi']['karttur']

            ));

            if($KimlikIsle){

                echo '<script type="text/javascript">window.location="'.$link.'/okul/View/'.$Postlar['Bilgi']['okulid'].'";</script>';

            }else{
                echo 'Veritabanı Bağlantı Hatası.';
            }
        }
        elseif($_POST['_token']=='d18bbb28376f970699cead0837a6fd07'){
            // Kimlik Sil


                $KimlikSil = $db->prepare("DELETE FROM kimlik WHERE id=:kimlik_id");
                $SilQuery=$KimlikSil->execute(array(
                    'kimlik_id'   => $_POST['kimlikid']
                ));

                if($SilQuery){
                    $_SESSION['kimliksil']='Kimlik Silindi!';
                    echo '<script type="text/javascript">window.location="'.$link.'";</script>';

                }else{
                    $_SESSION['kimliksil']='Kimlik Silinemedi!';
                    echo '<script type="text/javascript">window.location="'.$link.'";</script>';

                }


        }
        elseif($_POST['_token']=='81fa727f305728f5d47aff01323021d1'){
            //düzenle

            if (!empty($_POST['okuladi']) and !empty($_POST['id'])) {

                $OkulSef=sef_link($_POST['okuladi']);
                $GelenSef=$db->query("SELECT * FROM okul WHERE sef='{$OkulSef}'")->fetch(PDO::FETCH_ASSOC);
                $OkulSorgu=$db->query("SELECT * FROM okul WHERE id='{$_POST['id']}'")->fetch(PDO::FETCH_ASSOC);



                if($OkulSef==$OkulSorgu['sef']){
                    $islemiyap=true;
                    $OkulYolu='okul/'.$OkulSorgu['sef'];
                    // isim değişmemiş

                }else{
                    if(empty($GelenSef)){
                        // yeni okul adı
                        $islemiyap=true;
                        rename('okul/'.$OkulSorgu['sef'],'okul/'.$OkulSef);
                        $OkulYolu='okul/'.$OkulSef;

                    }else{
                        $islemiyap=false;
                    }
                }



                if($islemiyap==true){

                    $OkulAdi = $_POST['okuladi'];
                    $OgretimYil = $_POST['ogretim'];
                    $MudurAdi=$_POST['muduradi'];

                    require 'include/class.upload.php';

                    if(is_uploaded_file($_FILES['logo']['tmp_name'])) {


                        $image = new Upload($_FILES['logo']);
                        $image->file_new_name_body = 'logo';
                        $image->allowed = array('image/png');


                        $image->file_max_size = '1024000';
                        $image->file_overwrite = true;
                        $image->Process($OkulYolu);

                        if ($image->processed) {
                            $Loggoo='Logo Güncellendi.';

                        } else {

                            $Loggoo='Logo Güncellenemedi! '.$image->error;
                        }
                        $_SESSION['okulguncel']['logo']=$Loggoo;
                    }

                    if(is_uploaded_file($_FILES['arkaplan']['tmp_name'])) {


                        $arkasi = new Upload($_FILES['arkaplan']);
                        $arkasi->file_new_name_body = 'arkaplan';
                        $arkasi->allowed = array('image/png');


                        $arkasi->file_max_size = '1024000';
                        $arkasi->file_overwrite = true;
                        $arkasi->Process($OkulYolu);

                        if ($arkasi->processed) {
                            $Arkaplanim='Arkaplan Güncellendi.';

                        } else {

                            $Arkaplanim='Arkaplan Güncellenemedi: '.$arkasi->error;
                        }
                        $_SESSION['okulguncel']['arkaplan']=$Arkaplanim;
                    }

                    $OkulKayit = $db->prepare("UPDATE okul SET
                          yil=:glbl_Yil,
                          okuladi=:glbl_OkulAdi,
                          sef=:glbl_Sef,
                          muduradi=:glbl_Mudur
                          WHERE id=:glbl_id
                        ");

                    $OkulQuery = $OkulKayit->execute(array(
                        'glbl_Yil' => $OgretimYil,
                        'glbl_OkulAdi' => $OkulAdi,
                        'glbl_Sef' => $OkulSef,
                        'glbl_Mudur' => $MudurAdi,
                        'glbl_id'   => $_POST['id']
                    ));

                    if($OkulQuery) {
                        $_SESSION['okulguncel']['okul']='Okul Bilgileri Güncellendi';

                    }else{
                        $_SESSION['okulguncel']['okul']='Okul Bilgileri Güncellenemedi!';
                    }





                }else{
                    // Bu Okul Zaten Var
                    $_SESSION['okulguncel']['okul']='Bu Okul Zaten Kayıtlarda Mevcuttur!';
                }

            } else {
                $_SESSION['okulguncel']['okul']='Alanlar Boş Bırakılamaz!';
            }

            echo '<script type="text/javascript">window.location="'.$link.'/okul/View/'.$_POST['id'].'";</script>';

        }

    } // Post İşlem SOnu

    elseif($_GET){
        // Get İşlemi

            if($_GET['islem']=='View' and !empty($_GET['id'])) {
                //Okul göster sayfası
                $OkulBilgi = $db->query("SELECT * FROM okul WHERE id='{$_GET['id']}'")->fetch(PDO::FETCH_ASSOC);
                $Sayisal = $db->query("SELECT COUNT(*) as Ogrenci, COUNT(DISTINCT sinif) as Sinif FROM ogrenci WHERE okulid='{$_GET['id']}'")->fetch(PDO::FETCH_ASSOC);

                function kagitharca(){
                    global $db;
                    global $_GET;
                    $Sinifizy=$db->query("SELECT sinif,COUNT(*) AS say FROM ogrenci WHERE okulid='{$_GET['id']}' GROUP BY sinif ")->fetchAll(PDO::FETCH_ASSOC);
                    $toplam= count($Sinifizy);

                    $Genel=0;
                    for($i=0;$i<$toplam;$i++){
                        $Bol=ceil($Sinifizy[$i]['say']/10);
                        $Genel=$Genel+$Bol;
                    }

                    return $Genel;
                }

                $Siniflar = $db->query("SELECT DISTINCT sinif AS Sinif FROM ogrenci WHERE okulid='{$_GET['id']}' ORDER BY sinif ASC", PDO::FETCH_ASSOC);
                $Albumler = $db->query("SELECT DISTINCT sinif AS Sinif FROM ogrenci WHERE okulid='{$_GET['id']}' ORDER BY sinif DESC", PDO::FETCH_ASSOC);
                $Kimlikler = $db->query("SELECT * FROM kimlik WHERE okulid='{$_GET['id']}'", PDO::FETCH_ASSOC);



                if ($OkulBilgi){
                    ?>


                    <?php
                        if(!empty($_SESSION['okulguncel'])){ ?>

                            <script type="text/javascript" >
                                function temizle(){
                                    $( "#sonuclar" ).remove();
                                }

                            </script>
                            <div id="sonuclar" class="row" style=" color:#8a6d3b; padding:5px; background:#fcf8e3; border:1px solid #faebcc; border-radius: 10px; margin:5px;">
                                <div class="col-xs-11">
                                    <?php

                                    if(!empty($_SESSION['okulguncel']['okul'])) {
                                        echo ' '.$_SESSION['okulguncel']['okul'].'<br />';
                                    }

                                    if(!empty($_SESSION['okulguncel']['logo'])){
                                        echo ' '.$_SESSION['okulguncel']['logo'].'<br />';
                                    }
                                    if(!empty($_SESSION['okulguncel']['arkaplan'])){
                                        echo ' '.$_SESSION['okulguncel']['arkaplan'];
                                    }
                                    unset($_SESSION['okulguncel']);
                                    ?>


                                </div>
                                <div class="col-xs-1"><a style="cursor:pointer;" onclick="temizle()"><span class="fui-cross"></span></a></div>
                             </div>

               <?php } ?>
            <div class="row">
                    <div class="col-xs-3">
                    <div class="tile">
                    <img src="<?php echo $link; ?>/okul/<?php echo $OkulBilgi['sef']; ?>/logo.png" class="tile-image img-circle">
                <h3 class="tile-title"><?php echo $OkulBilgi['okuladi']; ?></h3>
                <p><?php echo $OkulBilgi['yil']; ?> Eğitim Öğretim Yılı</p>

                <a class="btn btn-danger btn-large btn-block" onclick="return confirm('emin misin?');" href="<?php echo $link; ?>/okul/Delete/<?php echo $OkulBilgi['id']; ?>">Okulu Sil</a>
                <a class="btn btn-primary btn-large btn-block" href="<?php echo $link; ?>/okul/Edit/<?php echo $OkulBilgi['id']; ?>">Düzenle</a>
                <a class="btn btn-inverse btn-large btn-block" href="<?php echo $link; ?>/editor/New/<?php echo $OkulBilgi['id']; ?>">Yeni Kimlik</a>
                <a class="btn btn-info btn-large btn-block" href="<?php echo $link; ?>/ogrenci/View/<?php echo $OkulBilgi['id']; ?>">Öğrenciler <?php if($Sayisal['Ogrenci']>0){ echo '('.$Sayisal['Ogrenci'].')'; }?></a>
                <!-- /btn-group -->
               </div>
                </div>

                <div class="col-xs-9">
                <div class="tile">
                    <h3 style="text-decoration: underline;" class="tile-title">İstatistikler</h3>
                    <table style="width:100%;">
                        <thead>
                        <tr>
                            <th>Öğrenci Say.</th>
                            <th>Sınıf Say.</th>
                            <th>Ort. A4</th>
                        </tr>

                        </thead>

                        <tbody style="text-align:left;">
                        <tr>
                            <td><?php echo $Sayisal['Ogrenci']; ?></td>
                            <td><?php echo $Sayisal['Sinif']?></td>
                            <td><?php echo kagitharca();?></td>
                        </tr>
                        </tbody>
                    </table>

                </div>

                <div class="tile">
                    <h3 style="text-decoration: underline;" class="tile-title">Kimlik Tasarımları</h3>
                <?php if($Kimlikler->rowCount()){
                    $sayisi=$Kimlikler->rowCount();

                    ?>
                    <ul class="slides">
                        <?php foreach($Kimlikler as $key=>$Kimlikcevir){ ?>
                        <input type="radio" name="radio-btn" id="img-<?php echo $key; ?>" checked />
                        <li class="slide-container">
                            <div class="slide">

                                <form action="<?php echo $link; ?>/okul.php" method="post">
                                    <input type="hidden" value="d18bbb28376f970699cead0837a6fd07" name="_token" />
                                    <input type="hidden" name="kimlikid" value="<?php echo $Kimlikcevir['id']; ?>" />
                                    <i><?php echo $Kimlikcevir['id'].'-'.str_replace($bul, $degistir, $Kimlikcevir['tur']); ?></i>
                                    <button onclick="return confirm('Silmek İstediğinize Emin Misiniz?');" type="submit" style="width:10%; height:15%; padding:0; position:absolute; top:0; right:0; margin-right:150px;" class="btn btn-block btn-lg btn-danger">Sil</button></form>
                              <iframe marginwidth="50" src="<?php echo $link; ?>/onizle.php?okulid=<?php echo $Kimlikcevir['okulid']; ?>&kimlikid=<?php echo $Kimlikcevir['id']; ?>" width="609" height="200" frameborder="0" scrolling="no"></iframe>
                            </div>
                            <div class="nav">
                                <label for="img-<?php if($key==0){echo $sayisi-1;}else{echo $key-1;} ?>" class="prev">&#x2039;</label>
                                <label for="img-<?php if($key==$sayisi-1){echo 0;}else{ echo $key+1; } ?>" class="next">&#x203a;</label>
                            </div>

                        </li>

                        <?php } ?>



                        <li class="nav-dots">
                            <?php for($i=0;$i<$sayisi;$i++){ ?>
                            <label for="img-<?php echo $i; ?>" class="nav-dot" id="img-dot-<?php echo $i; ?>"></label>
                            <?php } ?>

                        </li>
                    </ul>
                <?php }else{ echo 'Henüz Kimlik Oluşturulmamış.'; } ?>

                </div>

                    <div class="tile">
                        <h3 style="text-decoration: underline;" class="tile-title">Tasarruf Modu</h3>
                        <div style="clear:both; height:10px;"></div>
                        <form action="<?php echo $link; ?>/tasarruf.php" method="post">

                            <input type="hidden" name="id" value="<?php echo $OkulBilgi['id']; ?>"/>
                        <div class="btn-group">
                            <input type="checkbox" data-toggle="checkbox" value="1" id="checkbox1" name="marka" class="custom-checkbox"> Marka Logo
                        </div>

                        <div class="btn-group">

                            <?php
                            $Kimlikler3 = $db->query("SELECT * FROM kimlik WHERE okulid='{$_GET['id']}'", PDO::FETCH_ASSOC);
                            if ($Kimlikler3->rowCount()) { ?>
                                <select name="kimlik" class="form-control select select-primary select2-offscreen"
                                        data-toggle="select" tabindex="-1" title="">
                                    <?php foreach ($Kimlikler3 as $KimlikBilgi) { ?>
                                        <option value="<?php echo $KimlikBilgi['id']; ?>"><?php echo $KimlikBilgi['id'].'-'.str_replace($bul, $degistir, $KimlikBilgi['tur']); ?></option>
                                    <?php } ?>
                                </select>
                            <?php } else { ?>
                                <select disabled="disabled" class="form-control select select-primary select2-offscreen"
                                        data-toggle="select" tabindex="-1" title="">
                                    <option value="">Kimlik Yok</option>
                                </select>

                            <?php } ?>
                        </div>

                            <div class="btn-group">
                                <?php if ($Kimlikler3->rowCount() and $Siniflar->rowCount()) { ?>
                                    <input class="btn btn-block btn-lg btn-success" type="submit" value="Oluştur"/>
                                <?php } ?>

                            </div>
                        </form>



                    </div>

                <form action="<?php echo $link; ?>/kimlikm.php" method="post">
                    <input type="hidden" name="okulid" value="<?php echo $OkulBilgi['id']; ?>"/>

                    <div class="tile">
                        <h3 style="text-decoration: underline;" class="tile-title">Sınıf Kimlik Oluştur</h3>

                        <div style="clear:both; height:10px;"></div>
                        <div class="btn-group">
                            <input type="checkbox" data-toggle="checkbox" value="1" id="checkbox1" name="marka" class="custom-checkbox"> Marka Logo
                        </div>



                        <div class="btn-group">
                            <?php if ($Siniflar->rowCount()) { ?>
                                <select name="sinif" class="form-control select select-primary select2-offscreen"
                                        data-toggle="select" tabindex="-1" title="">
                                    <?php foreach ($Siniflar as $SinifBilgi) { ?>
                                        <option value="<?php echo $SinifBilgi['Sinif']; ?>"><?php echo $SinifBilgi['Sinif']; ?></option>
                                    <?php } ?>
                                </select>
                            <?php } else { ?>
                                <select disabled="disabled" class="form-control select select-primary select2-offscreen"
                                        data-toggle="select" tabindex="-1" title="">
                                    <option>Öğrenci Yok</option>
                                </select>
                            <?php } ?>
                        </div>
                        <div class="btn-group">

                            <?php $Kimlikler2 = $db->query("SELECT * FROM kimlik WHERE okulid='{$_GET['id']}'", PDO::FETCH_ASSOC);
                            if ($Kimlikler2->rowCount()) { ?>
                                <select name="kimlik" class="form-control select select-primary select2-offscreen"
                                        data-toggle="select" tabindex="-1" title="">
                                    <?php foreach ($Kimlikler2 as $KimlikBilgi) { ?>
                                        <option value="<?php echo $KimlikBilgi['id']; ?>"><?php echo $KimlikBilgi['id'].'-'.str_replace($bul, $degistir, $KimlikBilgi['tur']); ?></option>
                                    <?php } ?>
                                </select>
                            <?php } else { ?>
                                <select disabled="disabled" class="form-control select select-primary select2-offscreen"
                                        data-toggle="select" tabindex="-1" title="">
                                    <option value="">Kimlik Yok</option>
                                </select>

                            <?php } ?>
                        </div>
                        <div class="btn-group">
                            <?php if ($Kimlikler2->rowCount() and $Siniflar->rowCount()) { ?>
                                <input class="btn btn-block btn-lg btn-success" type="submit" value="Oluştur"/>
                            <?php } ?>

                        </div>


                    </div>
                </form>
                    <?php if($Albumler->rowCount()>0){ ?>
                    <div class="tile">
                        <h3 style="text-decoration: underline;" class="tile-title">Fotoğraf Albümü Oluştur</h3>
                        <div style="clear:both; height:10px;"></div>

                        <form action="<?php echo $link; ?>/album.php" method="post">
                            <input type="hidden" name="okulid" value="<?php echo $_GET['id']; ?>" />
                            <div class="btn-group">
                                <select name="sinif" class="form-control select select-info select2-offscreen" data-toggle="select" tabindex="-1" title="">
                                <?php foreach ($Albumler as $SinifBilgi) { ?>
                                        <option value="<?php echo $SinifBilgi['Sinif']; ?>"><?php echo $SinifBilgi['Sinif']; ?></option>
                                <?php } ?>
                                </select>
                            </div>
                            <div class="btn-group">
                                <input class="btn btn-block btn-lg btn-danger" type="submit" value="Oluştur"/>
                            </div>
                        </form>
                    </div>
                    <?php  $Kimlikler3 = $db->query("SELECT * FROM kimlik WHERE okulid='{$_GET['id']}'", PDO::FETCH_ASSOC); ?>
                    <div class="tile">
                        <h3 style="text-decoration: underline;" class="tile-title">Eksik Öğrenci Kimliği Oluştur</h3>
                        <div style="clear:both; height:10px;"></div>
                        <script src="<?php echo $link; ?>/dist/js/vendor/html5shiv.js"></script>
                        <script src="<?php echo $link; ?>/dist/js/vendor/respond.min.js"></script>
                        <form action="<?php echo $link; ?>/eksik.php" method="post">
                            <input type="hidden" name="okulid" value="<?php echo $_GET['id']; ?>" />
                            <div class="btn-group">
                                <input type="checkbox" data-toggle="checkbox" value="1" id="checkbox1" name="marka" class="custom-checkbox"> Marka Logo
                            </div>
                            <div class="btn-group has-success">

                                    <input type="text" name="eksikler" placeholder="(Ör. 416,578,1024)" class="form-control">

                            </div>


                            <div class="btn-group">
                                <select name="kimlik" class="form-control select select-primary select2-offscreen"
                                        data-toggle="select" tabindex="-1" title="">
                                    <?php foreach ($Kimlikler3 as $KimlikBilgi) { ?>
                                        <option value="<?php echo $KimlikBilgi['id']; ?>"><?php echo $KimlikBilgi['id'].'-'.str_replace($bul, $degistir, $KimlikBilgi['tur']); ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="btn-group">
                                <input class="btn btn-block btn-lg btn-danger" type="submit" value="Oluştur"/>
                            </div>
                        </form>
                    </div>



                    <?php } ?>
                </div>
            </div>


            <?php
                }else {
                    echo 'Okul bulunamadı';
                }
            }

            elseif($_GET['islem']=='New' and empty($_GET['id'])){
                //Yeni Okul Ekle Sayfası
                ?>
                <form action="<?php echo $link; ?>/okul.php" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="1323021d8305728f5d471fa727faff01" />
                    <div class="row">
                    <div class="col-xs-3">
                        <p>Okul Adı <sub>Eksiksiz Giriniz</sub></p>
                        <div class="form-group has-success">
                            <input type="text" name="okuladi" placeholder="Okul Adı" class="form-control" required />
                            <span class="input-icon fui-check-inverted"></span>
                        </div>
                    </div>

                    <div class="col-xs-3">
                        <p>Öğretim Yılı</p>
                        <select name="ogretim" class="form-control select select-primary select2-offscreen" data-toggle="select" tabindex="-1" title="">
                            <?php for($i=date('Y')-1;$i<date('Y')+3;$i++){ ?>
                            <option <?php if(date('Y')==$i){ echo 'selected';} ?> value="<?php $i1=$i+1; echo $i.' - '.$i1; ?>"><?php echo $i.' - '.$i1; ?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="col-xs-3">
                        <p>Logo <sub>(Kare ve .png Olmalıdır)</sub></p>
                        <input type="file" class="btn btn-block btn-lg btn-danger" style="width:auto;" name="logo" value="Logo" required />
                    </div>
                    </div>
                    <div class="row">
                    <div class="col-xs-3">
                        <p>Müdür Adı</p>
                        <div class="form-group">
                            <input type="text" name="muduradi" placeholder="Müdür İsim" class="form-control" required />
                        </div>
                    </div>


                    <div class="col-xs-5">
                        <p>İmzalı Arkaplan. <sub>Ölçü: 300px x 180px ve Saydam .png</sub></p>
                        <input type="file" class="btn btn-block btn-lg btn-warning" style="width:auto;" name="arkaplan" required />

                    </div>

                    <div class="col-xs-2">
                        <p style="color:white;">-</p>
                        <input type="submit" value="Sonraki &raquo;" class="btn btn-block btn-lg btn-info" />
                    </div>

                    </div>


                </form>
                <?php
            }

            elseif($_GET['islem']=='Edit' and !empty($_GET['id'])){

                $OkulVerileri=$db->query("SELECT * FROM okul WHERE id='{$_GET['id']}'")->fetch(PDO::FETCH_ASSOC);


                ?>
                <div class="row">
                    <div class="col-xs-1"><img width="80px" src="<?php echo $link; ?>/okul/<?php echo $OkulVerileri['sef']; ?>/logo.png" /></div>
                    <div class="col-xs-11"><h4><i class="fui-arrow-right"></i> <?php echo $OkulVerileri['okuladi']; ?> <i class="fui-arrow-left"></i></h4></div>
                </div>
                <br />


                <form action="<?php echo $link; ?>/okul.php" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="81fa727f305728f5d47aff01323021d1" />
                    <input type="hidden" name="id" value="<?php echo $OkulVerileri['id']; ?>" />
                    <div class="row">
                    <div class="col-xs-3">
                        <p>Okul Adı <sub>Eksiksiz Giriniz</sub></p>
                        <div class="form-group has-success">
                            <input type="text" name="okuladi" placeholder="Okul Adı" value="<?php echo $OkulVerileri['okuladi']; ?>" class="form-control">
                            <span class="input-icon fui-check-inverted"></span>
                        </div>
                    </div>

                    <div class="col-xs-3">
                        <p>Öğretim Yılı</p>
                        <select name="ogretim" class="form-control select select-primary select2-offscreen" data-toggle="select" tabindex="-1" title="">
                            <?php for($i=date('Y')-1;$i<date('Y')+3;$i++){
                    $i1=$i+1;
                    ?>
                    <option <?php if($OkulVerileri['yil']==$i.' - '.$i1){ echo 'selected';} ?> value="<?php  echo $i.' - '.$i1; ?>"><?php echo $i.' - '.$i1; ?></option>
                <?php } ?>
                        </select>
                    </div>

                    <div class="col-xs-3">
                        <p>Logo <sub>(Kare Olmalıdır)</sub></p>
                        <input type="file" class="btn btn-block btn-lg btn-danger" style="width:auto;" name="logo" value="Logo" />
                    </div>
                    </div>

                    <div class="row">
                    <div class="col-xs-3">
                        <p>Müdür Adı</p>
                        <div class="form-group">
                            <input type="text" name="muduradi" placeholder="Müdür İsim" value="<?php echo $OkulVerileri['muduradi']; ?>" class="form-control" required />
                        </div>
                    </div>


                    <div class="col-xs-5">
                        <p>İmzalı Arkaplan. <sub>Ölçü: 300px x 130px ve Saydam .png</sub></p>
                        <input type="file" class="btn btn-block btn-lg btn-warning" style="width:auto;" name="arkaplan" />

                    </div>

                    <div class="col-xs-2">
                        <p style="color:white;">-</p>
                        <input type="submit" value="Güncelle &raquo;" class="btn btn-block btn-lg btn-info" />
                    </div>

                    </div>


                </form>




            <?php


            }

            elseif($_GET['islem']=='Delete' and !empty($_GET['id'])){
                // Okul Sil
                $OkulCek=$db->query("SELECT * FROM okul WHERE id='{$_GET['id']}'")->fetch(PDO::FETCH_ASSOC);



                $Sonuc='';
                if($OkulCek){
                    $okuldizin = realpath('').'/okul/'.$OkulCek['sef'];

                    $KimlikVarmi=$db->query("SELECT * FROM kimlik WHERE okulid='{$_GET['id']}'",PDO::FETCH_ASSOC);
                    $OgrenciVarmi=$db->query("SELECT * FROM ogrenci WHERE okulid='{$_GET['id']}'",PDO::FETCH_ASSOC);

                    if($KimlikVarmi->rowCount()) {
                        $KimlikleriSil = $db->prepare("DELETE FROM kimlik WHERE okulid=:okul_id");
                        $Siliste=$KimlikleriSil->execute(array(
                            'okul_id'   => $_GET['id']
                        ));
                        if($Siliste){
                           $Sonuc.='<span class="fui-check"></span> Okula Ait Kimlikler Silindi!<br />';
                        }else{
                            $Sonuc.='<span style="color:red;" class="fui-cross"></span> Kimlikler Silinemedi!<br />';
                        }
                    }else{
                        $Sonuc.='<span style="color:red;" class="fui-cross"></span> Bu Okula Ait Kimlik Bulunamadı.<br />';
                    }

                    if($OgrenciVarmi->rowCount()) {
                        $OgrenciSil = $db->prepare("DELETE FROM ogrenci WHERE okulid=:okulcuk_id");
                        $OgrenciBitir = $OgrenciSil->execute(array(
                            'okulcuk_id' => $_GET['id']
                        ));
                        if($OgrenciBitir){
                            $Sonuc.='<span class="fui-check"></span> Okula Ait Öğrenciler Silindi!<br />';
                        }else{
                            $Sonuc.='<span style="color:red;" class="fui-cross"></span> Öğrenciler Silinemedi!<br />';
                        }
                    }else{
                        $Sonuc.='<span style="color:red;" class="fui-cross"></span> Okula Ait Öğrenci Zaten Yoktu!<br />';
                    }


                    $OkulSil=$db->prepare("DELETE FROM okul WHERE id=:okulun_id");
                    $OkuluBitir=$OkulSil->execute(array(

                        'okulun_id' => $_GET['id']
                    ));

                    if($OkuluBitir){
                        $Sonuc.='<span class="fui-check"></span> Okul Kayıtlardan Silindi.<br />';
                    }else{
                        $Sonuc.='<span style="color:red;" class="fui-cross"></span> Okul Kayıtlardan <u>Silinemedi!</u><br />';
                    }

                    if(file_exists($okuldizin)){
                        deleteDirectory($okuldizin);
                        $Sonuc.='<span class="fui-check"></span> Okul Klasörü Silindi!<br />';
                    }else{
                        $Sonuc.='<span style="color:red;" class="fui-cross"></span> Bu okula ait bir klasör bulunamadı!<br />';
                    }

                }else{
                    $Sonuc.='<span style="color:red;" class="fui-cross"></span> Böyle Bir Okul Mevcut Değil!';
                }

                if(!empty($Sonuc)) {

                    $_SESSION['okulusil'] = $Sonuc;
                    echo '<script type="text/javascript">window.location="'.$link.'";</script>';
                }

            }

            else{

                echo 'hop';
            }

    } else{
    echo 'Yanlış Yerdesin Adamım!';}

include('footer.php');

?>