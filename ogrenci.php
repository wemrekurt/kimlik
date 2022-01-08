<?php
/**
 * Created by PhpStorm.
 * User: Emre
 * Date: 19.9.2015
 * Time: 11:50
 */
session_start();


    if($_POST){
        require_once('db.php');
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



        if($_POST['_token']=='05fbcbe95f88500fef15ada4ae3dff91') {
            //yeni öğrenci ekle

            if(is_uploaded_file($_FILES['logo']['tmp_name'])){
                $Veriler=array('ogrenci'=>$_POST);

                $OkulBilgiCek=$db->query("SELECT * FROM okul WHERE id='{$Veriler['ogrenci']['ogretim']}'")->fetch(PDO::FETCH_ASSOC);
                $OgrAra=$db->query("SELECT * FROM ogrenci WHERE numara='{$Veriler['ogrenci']['numara']}' AND okulid='{$Veriler['ogrenci']['ogretim']}'")->fetchAll(PDO::FETCH_ASSOC);


                $OkulYolu='okul/'.$OkulBilgiCek['sef'];
                $SinifYolu=$OkulYolu.'/'.$Veriler['ogrenci']['sinif'];

                if(empty($OgrAra)) {


                    $cevirsekil=$_POST['cevir'];
                    require 'include/class.upload.php';
                    $image = new Upload($_FILES['logo']);
                    $image->file_new_name_body = $Veriler['ogrenci']['numara'];
                    $image->allowed = array('image/*');
                    $image->image_convert = 'jpg';
                    $image->file_overwrite = true;
                    $image->image_rotate=$cevirsekil;
                    $image->file_max_size = '1024000';
                    $image->Process($OkulYolu);

                    if ($image->processed) {

                        $OgrSql=$db->prepare("INSERT INTO ogrenci SET
                        okulid=:g_okul,
                        sinif=:g_sinif,
                        numara=:g_numara,
                        isim=:g_isim,
                        soyisim=:g_soy,
                        tcno=:g_tc,
                        bolum=:g_bolum
                        ");

                        $EkleIslemi=$OgrSql->execute(array(
                            'g_okul'    => $Veriler['ogrenci']['ogretim'],
                            'g_sinif'    => $Veriler['ogrenci']['sinif'],
                            'g_numara'    => $Veriler['ogrenci']['numara'],
                            'g_isim'    => $Veriler['ogrenci']['ogradi'],
                            'g_soy'    => $Veriler['ogrenci']['ogrsoy'],
                            'g_tc'    => $Veriler['ogrenci']['tc'],
                            'g_bolum'    => $Veriler['ogrenci']['bolum']
                        ));

                        if($EkleIslemi){

                            echo '<script>window.location="'.$link.'/ogrenci/View/'.$Veriler['ogrenci']['ogretim'].'";</script>';
                        }

                    } else {
                        echo $image->error;
                    }

                }else{
                    echo 'Bu okulda bu numarayla kayıtlarda öğrenci bulundu. Detaylar şu şekilde:<br />';
                    foreach($OgrAra as $OgrBilgim) {
                        echo $OgrBilgim['isim'] . ' ' . $OgrBilgim['soyisim'] . ' , ' . $OgrBilgim['sinif'] . ' , ' . $OgrBilgim['numara'].'<a href="'.$link.'/ogrenci/Edit/'.$OgrBilgim['id'].'">Gör</a><br />';
                    }
                }

            }else{
                echo 'Tüm Alanlar Doldurulmalıdır!';
            }


        } // Ekleme Sonu

        elseif($_POST['_token']=='0a4ae3e95cbfef5fbad15f88500dff91'){

            $OgrGelen['bilgi']=$_POST;
            $OgrGelen['foto']=$_FILES;
            $OkulBilgiOgr=$db->query("SELECT * FROM okul WHERE id='{$OgrGelen['bilgi']['okulid']}}'")->fetch(PDO::FETCH_ASSOC);
            $BilgiAl=$db->query("SELECT * FROM ogrenci WHERE id='{$OgrGelen['bilgi']['id']}'")->fetch(PDO::FETCH_ASSOC);
            $OnceBiSorVarMi=$db->query("SELECT count(*) AS say,id FROM ogrenci WHERE numara='{$OgrGelen['bilgi']['numara']}' AND okulid='{$OgrGelen['bilgi']['okulid']}'")->fetch(PDO::FETCH_ASSOC);


            if($OnceBiSorVarMi['say']==1){
                if($OnceBiSorVarMi['id']==$OgrGelen['bilgi']['id']){
                    $isiyap=1;
                }else{
                    $isiyap=0;
                }
            }elseif($OnceBiSorVarMi['say']==0){
                $isiyap=1;
            }else{
                $isiyap=1;
            }

            if($isiyap==1) {

                $OkulYoluDuz = realpath('') . '/okul/' . $OkulBilgiOgr['sef'];
                $FotoYoluYan = realpath('') . '/okul/' . $OkulBilgiOgr['sef'].'/'.$BilgiAl['numara'].'.jpg';
                $FotoYoluDuz = realpath('') . '/okul/' . $OkulBilgiOgr['sef'].'/'.$OgrGelen['bilgi']['numara'].'.jpg';

                if (!empty($OgrGelen['foto']['logo']['name'])) {

                    if(file_exists($FotoYoluYan)){
                        unlink($FotoYoluYan);
                    }

                    //logo yükleme işlemi

                    $cevirsekil = $OgrGelen['bilgi']['cevir'];
                    require 'include/class.upload.php';
                    $image = new Upload($OgrGelen['foto']['logo']);
                    $image->file_new_name_body = $OgrGelen['bilgi']['numara'];
                    $image->allowed = array('image/*');
                    $image->image_convert = 'jpg';
                    $image->file_overwrite = true;
                    $image->image_rotate = $cevirsekil;
                    $image->file_max_size = '1024000';
                    $image->Process($OkulYoluDuz);

                    if ($image->processed) {
                        $_SESSION['resyukle'] = 'Fotoğraf Başarıyla Güncellendi';

                    } else {
                        $_SESSION['resyukle'] = 'Fotoğraf Yüklenemedi. Hata: ' . $image->error;

                    }
                }else{
                    if(file_exists($FotoYoluYan)){
                        rename($FotoYoluYan,$FotoYoluDuz);
                    }
                }

                if (!empty($OgrGelen['bilgi']['ogradi']) AND !empty($OgrGelen['bilgi']['ogrsoy']) AND !empty($OgrGelen['bilgi']['sinif']) AND !empty($OgrGelen['bilgi']['numara'])) {
                    //veritabanı güncelleme işlemleri

                    $Guncelle = $db->prepare("UPDATE ogrenci SET
                isim=:glb_isim,
                soyisim=:glb_soy,
                sinif=:glb_sinif,
                numara=:glb_no,
                tcno=:glb_tc,
                bolum=:glb_bolum
                WHERE id=:glb_id
                ");

                    $Guncel = $Guncelle->execute(array(
                        'glb_isim' => $OgrGelen['bilgi']['ogradi'],
                        'glb_soy' => $OgrGelen['bilgi']['ogrsoy'],
                        'glb_sinif' => $OgrGelen['bilgi']['sinif'],
                        'glb_no' => $OgrGelen['bilgi']['numara'],
                        'glb_tc' => $OgrGelen['bilgi']['tc'],
                        'glb_bolum' => $OgrGelen['bilgi']['bolum'],
                        'glb_id' => $OgrGelen['bilgi']['id']

                    ));

                    if ($Guncel) {
                        $_SESSION['ogrguncel'] = 'Başarıyla Güncellendi!';


                    } else {
                        $_SESSION['ogrguncel'] = 'Veritabanı İşleminde Hata ile karşılaşıldı.';
                    }


                } else {
                    $_SESSION['ogrguncel'] = 'Alanlar Boş Bırakılamaz!';
                }
            }else{
                $_SESSION['ogrguncel'] = 'Bu numaraya ait bir öğrenci zaten var!';
            }
         echo '<script type="text/javascript">window.location="'.$link.'/ogrenci/Edit/'.$OgrGelen['bilgi']['id'].'"</script>';


        } // Düzenleme Sonu
        elseif($_POST['_token']=='0d1100dfcbf3e5fa4aea885ef5f995fb'){


            $Gelen['i']=$_POST;


            $FSilinenSay=0;
            $FSilinmeyenSay=0;
            $FotoOlmayan=0;
            $SilinenKayit=0;
            $SilinmeyenKayit=0;
            $Silinmeyenler='';
            $Cevap='';


            if(!empty($Gelen['i']['ilk']) AND !empty($Gelen['i']['iki'])) {
                if($Gelen['i']['islemtur']==0) {
                    $IsSonuc = $Gelen['i']['ilk'] + $Gelen['i']['iki'];
                }elseif($Gelen['i']['islemtur']==1){
                    $IsSonuc = $Gelen['i']['ilk'] - $Gelen['i']['iki'];
                }elseif($Gelen['i']['islemtur']==2){
                    $IsSonuc = $Gelen['i']['ilk'] * $Gelen['i']['iki'];
                }

                if($Gelen['i']['sonucu']==$IsSonuc) {

                    $OgrencileriCek = $db->query("SELECT * FROM ogrenci WHERE sinif='{$Gelen['i']['sinif']}' AND okulid='{$Gelen['i']['okulid']}'", PDO::FETCH_ASSOC);
                    $OkulYolum = $db->query("SELECT sef FROM okul WHERE id='{$Gelen['i']['okulid']}'")->fetch(PDO::FETCH_ASSOC);



                    foreach ($OgrencileriCek as $Tekle) {

                        $FotoYol = realpath('okul') . '/' . $OkulYolum['sef'] . '/' . $Tekle['numara'] . '.jpg';

                        $Delete=$db->prepare("DELETE FROM ogrenci WHERE id=:glb_id");
                        $Del=$Delete->execute(array('glb_id'=>$Tekle['id']));

                        if($Del){
                            $SilinenKayit++;
                            if (file_exists($FotoYol)) {
                               if(unlink($FotoYol)) {
                                   $FSilinenSay++;
                               }else{
                                   $FSilinmeyenSay++;
                               }
                            }else{
                                $FotoOlmayan++;
                            }
                        }else{
                            //Veritabanından Sİlinemedi
                            $SilinmeyenKayit++;
                            $Silinmeyenler.=$Tekle['numara'].',';
                        }

                    }
                }else{
                    $Cevap.='Güvenlik Sorusunu Yanlış Cevapladınız!';
                }
            }else{
                // Güvenlik Boş Bırakılamaz
                $Cevap.='Güvenlik Sorusunu Cevaplamalısınız!';
            }



            if($SilinenKayit>0){
                $_SESSION['sinifsil']['silinensayi']=$SilinenKayit;
                $_SESSION['sinifsil']['silinenfoto']=$FSilinenSay;
                $_SESSION['sinifsil']['silinmeyenfoto']=$FSilinmeyenSay;
                $_SESSION['sinifsil']['olmayanfoto']=$FotoOlmayan;
                $_SESSION['sinifsil']['silinmeyenno']=$Silinmeyenler;
                $_SESSION['sinifsil']['silinmeyensayi']=$SilinmeyenKayit;

            }else{
                $Cevap.='Hiçbir Öğrenci Silinmedi!';
            }
            if(!empty($Cevap)) {
                $_SESSION['sinifsil']['Cevap'] = $Cevap;
            }
                $_SESSION['sinifsil']['sinif']=$Gelen['i']['sinif'];
                header('Location:'.$link.'/ogrenci/View/'.$Gelen['i']['okulid']);



        } // Sınıf Sil İşlem Sonu
    }

    elseif($_GET){
        include('header.php');
        $id=intval($_GET['id']);

        if($_GET['islem']=='View' and !empty($_GET['id'])){


            $OkulBilgisi=$db->query("SELECT * FROM okul WHERE id='{$_GET['id']}'")->fetch(PDO::FETCH_ASSOC);
            if($OkulBilgisi) {
                // okulun öğrencileri
                function ogrliste($sinifi)
                {
                    global $id;
                    global $db;
                    $OgrenciListele = $db->query("SELECT * FROM ogrenci WHERE okulid='{$id}' AND sinif='{$sinifi}' ORDER BY numara", PDO::FETCH_ASSOC);
                    return $OgrenciListele;
                }


                $SinifListe = $db->query("SELECT DISTINCT(sinif) FROM ogrenci WHERE okulid='{$id}'", PDO::FETCH_ASSOC);


                    ?>

                    <div class="row">
                        <div class="col-xs-2"><a href="<?php echo $link; ?>/okul/View/<?php echo $OkulBilgisi['id']; ?>"><img class="img-thumbnail"
                                src="<?php echo $link; ?>/okul/<?php echo $OkulBilgisi['sef']; ?>/logo.png"
                                width="100px"/></a></div>
                        <div class="col-xs-8"><h4><?php echo $OkulBilgisi['okuladi']; ?></h4>
                            Sınıf ve Öğrenci Listesi
                        </div>
                        <div class="col-xs-2">
                            <div class="btn-group">
                                <a type="button" href="<?php echo $link; ?>/okul/View/<?php echo $OkulBilgisi['id']; ?>" class="btn btn-info">&laquo; Okula Dön</a>
                                <div style="height:5px;clear:both;"></div>
                                <button data-toggle="dropdown" class="btn btn-success dropdown-toggle" type="button">Yeni Ekle
                                    <span class="caret"></span></button>
                                <ul role="menu" class="dropdown-menu">
                                    <li><a href="<?php echo $link; ?>/ogrenci/New/1?Okul=<?php echo $_GET['id']; ?>">Excel'den Öğrenci Aktar</a></li>
                                    <li><a href="<?php echo $link; ?>/ogrenci/New/2?Okul=<?php echo $_GET['id']; ?>">Tek Öğrenci Ekle</a></li>
                                    <li><a href="<?php echo $link; ?>/ogrenci/New/3?Okul=<?php echo $_GET['id']; ?>">Toplu Fotoğraf Ekle</a></li>
                                </ul>
                            </div>


                        </div>
                    </div>


                <?php  if(!empty($_SESSION['ogrteksil'])){ ?>
                    <script type="text/javascript" >
                        function temizle(){
                            $( "#sonuclar" ).remove();
                        }

                    </script>
                    <div id="sonuclar" class="row" style=" color:#31708f; padding:5px; background:#d9edf7; border:1px solid #bce8f1; border-radius: 10px; margin:5px;">
                        <div class="col-xs-11"><span class="fui-info-circle"></span> &nbsp; &nbsp; <?php echo $_SESSION['ogrteksil']; ?></div>
                        <div class="col-xs-1"><a style="cursor:pointer;" onclick="temizle()"><span class="fui-cross"></span></a></div>
                    </div>

                    <?php unset($_SESSION['ogrteksil']);  }

                    if(!empty($_SESSION['formsonuc'])){ ?>
                        <script type="text/javascript" >
                            function temizle(){
                                $( "#sonuclar" ).remove();
                            }

                        </script>
                        <div id="sonuclar" class="row" style=" color:#31708f; padding:5px; background:#d9edf7; border:1px solid #bce8f1; border-radius: 10px; margin:5px;">
                            <div class="col-xs-11"><span class="fui-info-circle"></span> &nbsp; &nbsp; <?php echo $_SESSION['formsonuc']; ?></div>
                            <div class="col-xs-1"><a style="cursor:pointer;" onclick="temizle()"><span class="fui-cross"></span></a></div>
                        </div>

                    <?php unset($_SESSION['formsonuc']);  }


                    if(!empty($_SESSION['fotosonuc']) AND $_SESSION['fotosonuc']==1){ ?>

                        <script type="text/javascript" >
                            function temizle(){
                                $( "#sonuclar" ).remove();
                            }

                        </script>
                        <div id="sonuclar" class="row" style=" color:#31708f; padding:5px; background:#d9edf7; border:1px solid #bce8f1; border-radius: 10px; margin:5px;">
                            <div class="col-xs-11"><span class="fui-info-circle"></span> &nbsp; &nbsp;
                                <?php
                                if(!empty($_SESSION['yuklenensayi'])){

                                    echo 'Toplam <b>'.$_SESSION['yuklenensayi'].'</b> fotoğraf yüklendi. ';
                                    unset($_SESSION['yuklenensayi']);
                                }

                                if(!empty($_SESSION['yuklenmeyensayi'])){
                                    echo '<b>'.$_SESSION['yuklenmeyensayi']. '</b> fotoğraf yüklenemedi.Hatalar Şöyle:<br />';

                                    foreach($_SESSION['yuklenmeyenler'] as $yuklenmeyenler){
                                        echo $yuklenmeyenler.'<br />';
                                    }
                                    unset($_SESSION['yuklenmeyenler']);
                                    unset($_SESSION['yuklenmeyensayi']);
                                }


                                ?>


                            </div>
                            <div class="col-xs-1"><a style="cursor:pointer;" onclick="temizle()"><span class="fui-cross"></span></a></div>
                        </div>

                    <?php unset($_SESSION['fotosonuc']); }
                    if(!empty($_SESSION['sinifsil'])){

                       ?>

                        <script type="text/javascript" >
                            function temizle(){
                                $( "#sonuclar" ).remove();
                            }

                        </script>
                        <?php if(!empty($_SESSION['sinifsil']['Cevap'])){ ?>
                        <div id="sonuclar" class="row" style=" color:#a94442; padding:5px; background:#f2dede; border:1px solid #ebccd1; border-radius: 10px; margin:5px;">
                            <div class="col-xs-11"><span class="fui-info-circle"></span>
                                <?php echo $_SESSION['sinifsil']['sinif']. ' Sınıfında; '  . $_SESSION['sinifsil']['Cevap'];  ?></div>
                            <div class="col-xs-1"><a style="cursor:pointer;" onclick="temizle()"><span class="fui-cross"></span></a></div>
                        </div>
                        <?php }else{ ?>

                            <div id="sonuclar" class="row" style=" color:#31708f; padding:5px; background:#d9edf7; border:1px solid #bce8f1; border-radius: 10px; margin:5px;">
                                <div class="col-xs-11"><span class="fui-info-circle"></span>
                                    <?php
                                    echo $_SESSION['sinifsil']['sinif']. ' Sınıfında; ';
                                    if($_SESSION['sinifsil']['silinensayi']>0) {
                                        echo $_SESSION['sinifsil']['silinensayi']. ' öğrenci silindi!. ' ;
                                    }

                                    if($_SESSION['sinifsil']['silinenfoto']>0){
                                        echo $_SESSION['sinifsil']['silinenfoto']. ' fotoğraf silindi!. ' ;
                                    }

                                    if($_SESSION['sinifsil']['silinmeyenfoto']>0){
                                        echo $_SESSION['sinifsil']['silinmeyenfoto']. ' fotoğraf silinemedi!. ' ;
                                    }

                                    if($_SESSION['sinifsil']['olmayanfoto']>0){
                                        echo $_SESSION['sinifsil']['olmayanfoto']. ' öğrencinin fotoğrafı zaten yoktu!. ' ;
                                    }

                                    if($_SESSION['sinifsil']['silinmeyensayi']>0){
                                        echo $_SESSION['sinifsil']['silinmeyensayi']. ' silinemeyen öğrencilerin numaraları şöyle: '.$_SESSION['sinifsil']['silinmeyenno'];
                                    }

                                    ?></div>
                                <div class="col-xs-1"><a style="cursor:pointer;" onclick="temizle()"><span class="fui-cross"></span></a></div>
                            </div>


                <?php }  unset($_SESSION['sinifsil']); } ?>
                    <br/>


                    <?php

                    function guvenli(){
                        $ilk= rand(5,10);
                        $iki= rand(1,5);
                        $islemler= array('+','-','x');
                        $islemm=array_rand($islemler);
                        $_SESSION['guvenlik']=array(
                            'ilk'   => $ilk,
                            'iki'   => $iki,
                            'islem' => $islemm
                        );

                        $malum= $ilk.' '.$islemler[$islemm].' '.$iki;
                        return $malum;
                    }

                if ($SinifListe->rowCount()) {


                    foreach ($SinifListe as $SinifBilgi) {
                        $Bilgiler[$SinifBilgi['sinif']] = array();

                        foreach (ogrliste($SinifBilgi['sinif']) as $OgrBil) {

                            $Bilgiler[$SinifBilgi['sinif']][] = $OgrBil;

                        }
                    }
                    ?>
                    <div id="accordion">
                        <?php foreach ($Bilgiler as $key => $Bilgiveri) {
                            $Sayi = count($Bilgiveri);
                            ?>
                            <h3><?php echo $key; $SinifTam=$key; ?></h3>

                            <div >
                                <p>
                                <table class="emre" style="width:100%; padding:10px;" border="1">
                                    <thead>
                                    <tr>
                                        <th>Foto</th>
                                        <th>Numara</th>
                                        <th>İsim</th>

                                        <th>TC</th>
                                        <th>Bölüm</th>
                                        <th>İşlem</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    <?php for ($i = 0; $i < $Sayi; $i++) {

                                         $dosya =realpath('').'/okul/'.$OkulBilgisi['sef'].'/'.$Bilgiveri[$i]['numara'].'.jpg';
                                        ?>
                                        <tr style=" <?php if ($i % 2 == 1) { ?> background:#e0e0e0; <?php } ?>">
                                            <td><span

                                            <?php if(file_exists($dosya)){echo 'style="color:green;" class="fui-check"';}else{echo 'style="color:red;" class="fui-cross"';} ?>></span></td>
                                            <td><?php echo $Bilgiveri[$i]['numara']; ?></td>
                                            <td><?php echo $Bilgiveri[$i]['isim'] . ' ' . $Bilgiveri[$i]['soyisim']; ?></td>

                                            <td><?php echo $Bilgiveri[$i]['tcno']; ?></td>
                                            <td><?php echo $Bilgiveri[$i]['bolum']; ?></td>
                                            <td style="font-size:17px;">
                                                <a onclick="return confirm('Bu Öğrenciye Ait Tüm Bilgiler Kaybolacaktır! Silmek İstediğinize Emin Misiniz?');" href="<?php echo $link; ?>/ogrenci/Delete/<?php echo $Bilgiveri[$i]['id']; ?>"><span class="fui-trash"></span></a>
                                                <a href="<?php echo $link; ?>/ogrenci/Edit/<?php echo $Bilgiveri[$i]['id']; ?>"><span class="fui-resize"></span></a>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                    </tbody>

                                </table>

                                </p>
                                <p>
                                    <form action="" method="post">

                                    <div class="col-xs-3"><?php echo guvenli(); ?> = ?</div>
                                    <input type="hidden" value="0d1100dfcbf3e5fa4aea885ef5f995fb" name="_token" />
                                    <input type="hidden" value="<?php echo $_SESSION['guvenlik']['ilk']; ?>" name="ilk" />
                                    <input type="hidden" value="<?php echo $_SESSION['guvenlik']['iki']; ?>" name="iki" />
                                    <input type="hidden" value="<?php echo $_SESSION['guvenlik']['islem']; ?>" name="islemtur" />
                                    <input type="hidden" value="<?php echo $SinifTam; ?>" name="sinif" />
                                    <input type="hidden" value="<?php echo $OkulBilgisi['id']; ?>" name="okulid" />

                                    <div class="col-xs-3">
                                        <input class="form-control input-sm" name="sonucu" type="text" placeholder="İşlem Sonucu" required>
                                    </div>
                                    <div class="col-xs-3">
                                        <button type="submit" class="btn btn-primary btn-sm">Sınıfı Sil</button>
                                    </div>
                                    <div class="col-xs-3">


                                    </div>
                                </form>
                                </p>
                            </div>

                        <?php } ?>
                    </div>
                    <br />

                    <br />



                <?php
                } else {
                    ?>
                    Bu Okulda Henüz Öğrenci Bulunmamaktadır! Öğrenci ekleme işlemini üst menüden gerçekleştirebilirsiniz.
                <?php }
            }

            else{
                echo '<script>window.location="'.$link.'";</script>';
            }


        }

        elseif($_GET['islem']=='Edit' and !empty($_GET['id'])){
            // öğrenci düzenle
            $ogrid=intval($_GET['id']);
            $Ogrencim=$db->query("SELECT * FROM ogrenci WHERE id='{$_GET['id']}'")->fetch(PDO::FETCH_ASSOC);

            if($Ogrencim){
                $OkulDetayi=$db->query("SELECT * FROM okul WHERE id='{$Ogrencim['okulid']}'")->fetch(PDO::FETCH_ASSOC);

                if(!empty($_SESSION['ogrguncel']) or !empty($_SESSION['resyukle'])){

                ?>
                    <script type="text/javascript" >
                        function temizle(){
                            $( "#sonuclar" ).remove();
                        }

                    </script>
                    <div id="sonuclar" class="row" style=" color:#31708f; padding:5px; background:#d9edf7; border:1px solid #bce8f1; border-radius: 10px; margin:5px;">
                        <div class="col-xs-11"><span class="fui-info-circle"></span> &nbsp; &nbsp;
                            <?php if(!empty($_SESSION['ogrguncel'])){ echo $_SESSION['ogrguncel']; unset($_SESSION['ogrguncel']); } ?>
                            <?php if(!empty($_SESSION['resyukle'])){ echo $_SESSION['resyukle']; unset($_SESSION['resyukle']);} ?>

                        </div>
                        <div class="col-xs-1"><a style="cursor:pointer;" onclick="temizle()"><span class="fui-cross"></span></a></div>
                    </div>


                <?php } ?>
                <div class="row">
                    <div class="col-xs-10"> <h5>Düzenle: <?php echo $Ogrencim['isim'].' '.$Ogrencim['soyisim']; ?></h5></div>
                    <div class="col-xs-2"> <a href="<?php echo $link; ?>/ogrenci/View/<?php echo $OkulDetayi['id']; ?>" type="button" class="btn btn-danger">&laquo; İptal</a></div>

                </div>
                <hr />

            <form action="<?php echo $link; ?>/ogrenci.php" method="post" enctype="multipart/form-data">
                <input type="hidden" name="_token" value="0a4ae3e95cbfef5fbad15f88500dff91" />
                <input type="hidden" name="id" value="<?php echo $Ogrencim['id']; ?>" />
                <input type="hidden" name="okulid" value="<?php echo $OkulDetayi['id']; ?>" />
                <div class="row">
                    <div class="col-xs-3">
                        <div class="form-group has-success">
                            <input type="text" name="ogradi" placeholder="İsim" class="form-control" value="<?php echo $Ogrencim['isim']; ?>" required>
                            <span class="input-icon fui-check-inverted"></span>
                        </div>
                    </div>
                    <div class="col-xs-3">
                        <div class="form-group has-success">
                            <input type="text" name="ogrsoy" placeholder="Soyisim" class="form-control" value="<?php echo $Ogrencim['soyisim']; ?>" required>
                            <span class="input-icon fui-check-inverted"></span>
                        </div>
                    </div>
                    <div class="col-xs-3">
                        <div class="form-group has-success">
                            <input type="text" name="sinif" placeholder="Sınıf (ör. 12-A)" class="form-control" value="<?php echo $Ogrencim['sinif']; ?>" required>
                            <span class="input-icon fui-check-inverted"></span>
                        </div>
                    </div>
                    <div class="col-xs-3">
                        <div class="form-group has-success">
                            <input type="number" min="1" name="numara" placeholder="Numara (ör. 1453)" class="form-control" value="<?php echo $Ogrencim['numara']; ?>" required>
                            <span class="input-icon fui-check-inverted"></span>
                        </div>

                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-3">
                        <input type="file" class="btn btn-block btn-lg btn-success" style="width:100%;" name="logo" />
                    </div>
                    <div class="col-xs-4">
                        <select style="width:100%;" name="ogretim" class="form-control select select-default mrs mbm" data-toggle="select" tabindex="-1" disabled>
                            <option value="<?php echo $OkulDetayi['id']; ?>"><?php echo $OkulDetayi['okuladi']; ?></option>
                        </select>
                    </div>
                    <div class="col-xs-3">
                        <select name="cevir" class="form-control select select-success select2-offscreen" data-toggle="select" tabindex="-1" title="">
                            <optgroup label="Saat Yönünde">
                                <option value="0">Çevirme</option>
                                <option value="90">90 Derece</option>
                                <option value="180">180 Derece</option>
                                <option value="270">270 Derece</option>
                            </optgroup>

                        </select>
                    </div>

                    <div class="col-xs-2"><input type="submit" value="Düzenle &raquo;" class="btn btn-block btn-lg btn-info" /></div>
                </div>
                <hr />

                <div class="row">
                    <div class="col-xs-6"><h5>Öğrenci Bilgileri</h5></div>
                    <div class="col-xs-6"><p>Tc ve Bölüm alanlarını okul içeriğinde olması gerekiyor ise doldurun. Yoksa boş bırakın..</p></div>

                </div>
                <div class="row">
                    <div class="col-xs-2">

                        <img class="img-thumbnail" width="150px"
                             <?php
                            $Rezyol=realpath('').'/okul/'.$OkulDetayi['sef'].'/'.$Ogrencim['numara'].'.jpg';
                             if(file_exists($Rezyol)){
                             ?>
                             src="<?php echo $link; ?>/okul/<?php echo $OkulDetayi['sef']; ?>/<?php echo $Ogrencim['numara']; ?>.jpg"
                            <?php } else{ ?>
                            src="<?php echo $link; ?>/img/fotoyok.png"
                            <?php } ?>
                            >

                    </div>
                    <div class="col-xs-4" style="border-right:1px solid gray;">
                        <p><strong>Okul: </strong><?php echo $OkulDetayi['okuladi']; ?> </p>
                        <?php if(!$Ogrencim['tcno']==0 AND !empty($Ogrencim['tcno'])){ ?><p><strong>TC:</strong> <?php echo $Ogrencim['tcno']; ?></p><?php } ?>
                        <p><strong>İsim:</strong> <?php echo $Ogrencim['isim'].' '.$Ogrencim['soyisim']; ?></p>
                        <p><strong>No/Sınıf:</strong> <?php echo $Ogrencim['numara'].' / '.$Ogrencim['sinif']; ?></p>
                        <?php if(!empty($Ogrencim['bolum'])){ ?><p><strong>Bölüm:</strong> <?php echo $Ogrencim['bolum']; ?></p><?php } ?>
                    </div>
                    <div class="col-xs-3">
                        <div class="form-group has-inactive">
                            <input type="number" name="tc" placeholder="TC No" <?php if(!$Ogrencim['tcno']==0 AND !empty($Ogrencim['tcno'])){ ?>value="<?php echo $Ogrencim['tcno']; ?>"<?php } ?> class="form-control" >
                            <span class="input-icon fui-check-inverted"></span>
                        </div>
                    </div>
                    <div class="col-xs-3">
                        <div class="form-group has-inactive">
                            <input type="text" name="bolum" placeholder="Bölüm" <?php if(!empty($Ogrencim['bolum'])){ ?>value="<?php echo $Ogrencim['bolum']; ?>"<?php } ?> class="form-control" >
                            <span class="input-icon fui-check-inverted"></span>
                        </div>

                    </div>
                </div>

                <hr />
                <div class="row">
                    <div class="col-xs-4">




                        <sub>*Yeşil Alanların doldurulması zorunludur!</sub>
                    </div>

                    </div>


            </form>

        <?php }
        }
        elseif($_GET['islem']=='Delete' and !empty($_GET['id'])){
            $Son='';
            // öğrenci düzenle
            $ogrrid=intval($_GET['id']);
            $OgrSorgula=$db->query("SELECT numara,okulid,sinif,isim,soyisim FROM ogrenci WHERE id='{$ogrrid}'")->fetch(PDO::FETCH_ASSOC);
            $OklSorgula=$db->query("SELECT sef,id FROM okul WHERE id='{$OgrSorgula['okulid']}'")->fetch(PDO::FETCH_ASSOC);
            $Yolcu=realpath('okul').'/'.$OklSorgula['sef'].'/'.$OgrSorgula['numara'].'.jpg';

            if(!empty($OgrSorgula)) {
                $Silislemi = $db->prepare("DELETE FROM ogrenci WHERE id=:glb_id");
                $Silislemi = $Silislemi->execute(array('glb_id' => $ogrrid));
                if($Silislemi){
                    $Son.=$OgrSorgula['sinif'].' Sınıfından '.$OgrSorgula['isim'].' '.$OgrSorgula['soyisim'].' kayıtlardan silindi!';
                    if(file_exists($Yolcu)){
                        if(unlink($Yolcu)){
                            $Son.=' Ayrıca fotoğrafı da silindi';
                        }else{
                            $Son.=' Ancak fotoğraf silinemedi.';
                        }

                    }else{
                        $Son.= ' Ayrıca Bu Öğrenciye Ait silinecek fotoğraf yoktu.';
                    }

                }
            }else{
                $Son.='Böyle Bir Öğrenci Yok!';
            }
            $_SESSION['ogrteksil']=$Son;
            echo '<script type="text/javascript">window.location="'.$link.'/ogrenci/View/'.$OgrSorgula['okulid'].'";</script>';

        }
        elseif($_GET['islem']=='New' and !empty($_GET['id'])){
            echo '<h4>Yeni Öğrenci Ekle</h4>';
            $Turu=intval($_GET['id']);
            if($Turu==1){
                //excelden aktar
                $MevcutOkullar=$db->query("SELECT * FROM okul",PDO::FETCH_ASSOC);
                $ornek=1;

                ?>



                <form id="form1" method="post" action="<?php echo $link; ?>/excel.php" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-xs-5">
                            <input type="file" class="btn btn-block btn-lg btn-success" style="width:100%;" id="csv" name="csv" value="Excel" required />
                        </div>

                        <div class="col-xs-5">
                             <select name="ogretim" style="width:100%;" class="form-control select select-success select2-offscreen" data-toggle="select" tabindex="-1" title="">
                                    <?php foreach($MevcutOkullar as $OkulDetay){ ?>
                                <option <?php if(!empty($_GET['Okul']) and $_GET['Okul']==$OkulDetay['id']){ echo 'selected';} ?>
                                    value="<?php echo $OkulDetay['id']; ?>"><?php echo $OkulDetay['okuladi']; ?></option>
                                     <?php } ?>
                                </select>
                        </div>

                        <div class="col-xs-2">

                            <input type="submit" id="ekle" value="Ekle &raquo;" class="btn btn-block btn-lg btn-info" />
                        </div>

                    </div>

                </form>

                <?php
            }elseif($Turu==2){
                // tek ekleme formu,
                $MevcutOkullar=$db->query("SELECT * FROM okul",PDO::FETCH_ASSOC);
                ?>
                    <form action="<?php echo $link; ?>/ogrenci.php" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="_token" value="05fbcbe95f88500fef15ada4ae3dff91" />
                        <div class="row">
                            <div class="col-xs-3">
                                <div class="form-group has-success">
                                    <input type="text" name="ogradi" placeholder="İsim" class="form-control" required>
                                    <span class="input-icon fui-check-inverted"></span>
                                </div>
                            </div>
                            <div class="col-xs-3">
                                <div class="form-group has-success">
                                    <input type="text" name="ogrsoy" placeholder="Soyisim" class="form-control" required>
                                    <span class="input-icon fui-check-inverted"></span>
                                </div>
                            </div>
                            <div class="col-xs-3">
                                <div class="form-group has-success">
                                    <input type="text" name="sinif" placeholder="Sınıf (ör. 12-A)" class="form-control" required>
                                    <span class="input-icon fui-check-inverted"></span>
                                </div>
                            </div>
                            <div class="col-xs-3">
                                <div class="form-group has-success">
                                    <input type="number" min="1" name="numara" placeholder="Numara (ör. 1453)" class="form-control" required>
                                    <span class="input-icon fui-check-inverted"></span>
                                </div>

                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-3">
                                <input type="file" class="btn btn-block btn-lg btn-success" style="width:100%;" name="logo" value="Logo" required />
                            </div>
                            <div class="col-xs-4">


                                <select style="width:100%;" name="ogretim" class="form-control select select-success select2-offscreen" data-toggle="select" tabindex="-1" title="">
                                    <?php foreach($MevcutOkullar as $OkulDetay){ ?>
                                        <option <?php if(!empty($_GET['Okul']) and $_GET['Okul']==$OkulDetay['id']){ echo 'selected';} ?>
                                            value="<?php echo $OkulDetay['id']; ?>"><?php echo $OkulDetay['okuladi']; ?></option>
                                    <?php } ?>
                                </select>

                            </div>
                            <div class="col-xs-3">
                                <select name="cevir" class="form-control select select-success select2-offscreen" data-toggle="select" tabindex="-1" title="">
                                    <optgroup label="Saat Yönünde">
                                        <option value="0">Çevirme</option>
                                        <option value="90">90 Derece</option>
                                        <option value="180">180 Derece</option>
                                        <option value="270">270 Derece</option>
                                    </optgroup>

                                </select>
                            </div>

                            <div class="col-xs-2"><input type="submit" value="Ekle &raquo;" class="btn btn-block btn-lg btn-info" /></div>
                        </div>
                        <hr />

                        <div class="row">
                            <p>Tc ve Bölüm alanlarını okul içeriğinde olması gerekiyor ise doldurun. Yoksa boş bırakın..</p>
                            <div class="col-xs-3">
                                <div class="form-group has-inactive">
                                    <input type="number" name="tc" placeholder="TC No" class="form-control" >
                                    <span class="input-icon fui-check-inverted"></span>
                                </div>
                            </div>
                            <div class="col-xs-3">
                                <div class="form-group has-inactive">
                                    <input type="text" name="bolum" placeholder="Bölüm" class="form-control" >
                                    <span class="input-icon fui-check-inverted"></span>
                                </div>
                            </div>
                        </div>

                    </form>


                <?php
            }elseif($Turu==3){
                $MevcutOkullar=$db->query("SELECT * FROM okul",PDO::FETCH_ASSOC);
                $MevcutOkullar2=$db->query("SELECT * FROM okul",PDO::FETCH_ASSOC);
               ?>
                <h4>Arşivden Fotoğraf Yükle</h4>
                <p>.zip dosyası ile tüm fotoğrafları yükleyebilirsiniz (max 20 mb)</p>
                <form id="form1" method="post" action="<?php echo $link; ?>/fotograf.php" enctype="multipart/form-data">
                <input type="hidden" value="arsiv" name="tur" />
                <div class="row">


                    <div class="col-xs-5">
                        <select style="width:100%;" name="ogretim" class="form-control select select-success select2-offscreen" data-toggle="select" tabindex="-1" title="">
                            <?php foreach($MevcutOkullar2 as $OkulDetay){ ?>
                                <option <?php if(!empty($_GET['Okul']) and $_GET['Okul']==$OkulDetay['id']){ echo 'selected';} ?>
                                    value="<?php echo $OkulDetay['id']; ?>"><?php echo $OkulDetay['okuladi']; ?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="col-xs-4">
                        <input type="file" class="btn btn-block btn-lg btn-success" style="width:100%;" name="zip" required />
                    </div>

                    <div class="col-xs-3">
                        <input style="width:50%;" type="submit" id="ekle" value="Ekle &raquo;" class="btn btn-block btn-lg btn-info" />
                    </div>



                </div>


                </form>

                <hr />
                <h4>Toplu Fotoğraf Yükle</h4>
                <p>Tek Seferde Max. 500 Fotoğraf.</p>
                <form id="form1" method="post" action="<?php echo $link; ?>/fotograf.php" enctype="multipart/form-data">
                <input type="hidden" value="resim" name="tur" />
                <div class="row">


                    <div class="col-xs-5">
                        <select style="width:100%;" name="ogretim" class="form-control select select-success select2-offscreen" data-toggle="select" tabindex="-1" title="">
                            <?php foreach($MevcutOkullar as $OkulDetay){ ?>
                                <option <?php if(!empty($_GET['Okul']) and $_GET['Okul']==$OkulDetay['id']){ echo 'selected';} ?>
                                    value="<?php echo $OkulDetay['id']; ?>"><?php echo $OkulDetay['okuladi']; ?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="col-xs-4">
                        <input type="file" class="btn btn-block btn-lg btn-success" style="width:100%;" name="foto[]" multiple required />
                    </div>

                    <div class="col-xs-3">
                        <select name="cevir" data-toggle="select" class="form-control select select-default mrs mbm">
                            <optgroup label="Saat Yönünde">
                                <option value="0">Çevirme</option>
                                <option value="90">90 Derece</option>
                                <option value="180">180 Derece</option>
                                <option value="270">270 Derece</option>
                            </optgroup>

                        </select>
                     </div>



                </div>

                <div class="row">
                    <div class="col-xs-3"></div>
                    <div class="col-xs-3">

                    </div>
                    <div style="text-align:right;" class="col-xs-3">
                        <a <?php if(!empty($_GET['Okul'])){ ?>href="<?php echo $link; ?>/ogrenci/View/<?php echo  $_GET['Okul']; ?>" <?php }else{ ?> href="<?php echo $link; ?>" <?php } ?> id="ekle"  class="btn btn-danger">Vazgeçtim</a>
                    </div>


                    <div class="col-xs-3" style="text-align:right;">
                        <input style="width:50%;" type="submit" id="ekle" value="Ekle &raquo;" class="btn btn-block btn-lg btn-info" />
                    </div>

                </div>
                </form>




             <?php }else{

                // hatalı işlem

                echo 'hata';
            }
?>
        <hr />
            <div class="row">
                <div class="col-xs-4">


            <?php
            if(!empty($ornek)){
                ?>
                <sub style="color:#5cb355;"><b>*Dosya Türü <u>.csv</u> olmalıdır.</b></sub><br />
                <sub><b>*Örnek şablonu indirmek için <a href="<?php echo $link; ?>/ornek.csv">tıklayın</a>.</b></sub>

                <br />
            <?php } ?>

        <sub>*Yeşil Alanların doldurulması zorunludur!</sub>
                </div>
                <div class="col-xs-8">
                     <?php
            if(!empty($ornek)){ ?>
                    <img src="<?php echo $link; ?>/img/excel.jpg" />

                <?php } ?>
                </div>
            </div>
<?php
        }else{

         echo 'hata' ;
        }


    }else{

        echo 'nörüyon';

    }

include('footer.php');

?>