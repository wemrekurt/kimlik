<?php include_once('header.php');
$OkulListe=$db->query("SELECT * FROM okul ORDER BY id DESC",PDO::FETCH_ASSOC);
$Uyari=0;
session_start();
if(!empty($_SESSION['okulusil']) or !empty($_SESSION['kimliksil'])){
    $Uyari=1;
}
?>

        <?php if($Uyari==1){?>

            <script type="text/javascript" >
                function temizle(){
                    $( "#sonuclar" ).remove();
                }

            </script>
            <div id="sonuclar" class="row" style=" color:#8a6d3b; padding:5px; background:#fcf8e3; border:1px solid #faebcc; border-radius: 10px; margin:5px;">
                <div class="col-xs-11">
                    <?php

                    if(!empty($_SESSION['okulusil'])) {
                        echo $_SESSION['okulusil'];
                        unset($_SESSION['okulusil']);
                    }elseif(!empty($_SESSION['kimliksil'])){

                        echo $_SESSION['kimliksil'];
                        unset($_SESSION['kimliksil']);

                    }

                    ?>


                </div>
                <div class="col-xs-1"><a style="cursor:pointer;" onclick="temizle()"><span class="fui-cross"></span></a></div>
            </div>


        <?php } ?>

        <h4 class="">Yapmak istediğiniz işlemi aşağıdan seçiniz.</h4>

      <div class="row demo-row">
        <div class="col-xs-3">
          <a href="<?php echo $link; ?>/okul/New" class="btn btn-block btn-lg btn-primary">Yeni Okul Ekle</a>
        </div>
        <div class="col-xs-3">
          <a href="<?php echo $link; ?>/ogrenci/New/2" class="btn btn-block btn-lg btn-warning">Yeni Öğrenci Ekle</a>
        </div>
        <div class="col-xs-3">
          <a href="<?php echo $link; ?>/ogrenci/New/1" class="btn btn-block btn-lg btn-default">Toplu Öğrenci Ekle</a>
        </div>
        <div class="col-xs-3">
            <div class="btn-group">
                <button data-toggle="dropdown" style="width:100%;" class="btn btn-danger dropdown-toggle" type="button">
                    Lütfen Okul Seçiniz
                    <span class="caret"></span></button>
                <ul role="menu" class="dropdown-menu">
                    <?php foreach($OkulListe as $OkulBilgi){?>
                        <li><a href="okul/View/<?php echo $OkulBilgi['id']; ?>"><?php echo $OkulBilgi['okuladi']; ?></a></li>
                    <?php } ?>

                </ul>
            </div><!-- /btn-group -->
        </div>
      </div> <!-- /row -->
<hr/>
        <h4>Mevcut Okullar</h4>
        <div class="row kurt">
            <div class="col-xs-6">Okul Adı</div>
            <div class="col-xs-2">Öğr. Say.</div>
            <div class="col-xs-1">Snf Sy</div>
            <div class="col-xs-1">Kmlk</div>
            <div class="col-xs-1">A4</div>
            <div class="col-xs-1">İşlem</div>
        </div>
            <?php
            $OkulListele=$db->query("SELECT * FROM okul ORDER BY id DESC", PDO::FETCH_ASSOC)->fetchAll();

            function kagitharca($okulid){
                global $db;
                $Sinifizy=$db->query("SELECT sinif,COUNT(*) AS say FROM ogrenci WHERE okulid='{$okulid}' GROUP BY sinif ")->fetchAll(PDO::FETCH_ASSOC);
                $toplam= count($Sinifizy);

                $Genel=0;
                for($i=0;$i<$toplam;$i++){
                    $Bol=ceil($Sinifizy[$i]['say']/10);
                    $Genel=$Genel+$Bol;
                }

                return $Genel;
            }
            $sayim=count($OkulListele);
            foreach($OkulListele as $key=>$OkulBilgi){
                $Sayisal = $db->query("SELECT COUNT(*) as Ogrenci, COUNT(DISTINCT sinif) as Sinif FROM ogrenci WHERE okulid='{$OkulBilgi['id']}'")->fetch(PDO::FETCH_ASSOC);
                $Kimlikler = $db->query("SELECT COUNT(id) AS KimSay FROM kimlik WHERE okulid='{$OkulBilgi['id']}'")->fetch(PDO::FETCH_ASSOC);

                ?>
                <div <?php if($key%2==1){echo 'style="background:rgba(224, 224, 224, 1);"';}else{ echo 'style="background:rgba(239, 239, 239, 0.9);"';} ?>
                    class="row <?php if($key==$sayim){ echo 'koseler';} ?>">
                <div class="col-xs-6"><?php echo $OkulBilgi['okuladi']; ?></div>
                <div class="col-xs-2"><a href="<?php echo $link; ?>/ogrenci/View/<?php echo $OkulBilgi['id']; ?>"><?php echo $Sayisal['Ogrenci']; ?></a></div>
                <div class="col-xs-1"><?php echo $Sayisal['Sinif']; ?></div>
                <div class="col-xs-1"><?php echo $Kimlikler['KimSay']; ?></div>
                <div class="col-xs-1"><?php echo kagitharca($OkulBilgi['id']); ?></div>
                <div class="col-xs-1">
                    <a href="okul/View/<?php echo $OkulBilgi['id']; ?>"><span class="fui-eye"></span></a>
                   <a onclick="return confirm('Bu Okulu Silerseniz Tüm Bilgiler Gidecektir. Emin Misiniz?');" href="<?php echo $link; ?>/okul/Delete/<?php echo $OkulBilgi['id']; ?>"><span class="fui-trash"></span></a>
                </div>
                </div>
            <?php } ?>






<?php include('footer.php'); ?>

