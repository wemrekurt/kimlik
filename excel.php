
<?php

/**
 * Created by PhpStorm.
 * User: Emre
 * Date: 21.9.2015
 * Time: 17:49
 */

include('db.php');
include('olmasi.php');
$db->exec("SET NAMES latin5");
$db->exec("SET CHARACTER SET latin5");
$db->exec("SET COLLATION_CONNECTION = 'latin5_turkish_ci'");


if (!empty($_FILES['csv']['tmp_name']) and $_FILES['csv']['size'] > 0) {

    //get the csv file
    $file = $_FILES['csv']['tmp_name'];
    $handle = fopen($file,"r");

$say=0;
$sayma=0;
$eklenemeyen='';
    //loop through the csv file and insert into database
    do {
        if (!empty($data[0])) {

            $Sorgula=$db->query("SELECT * FROM ogrenci WHERE numara='{$data[0]}' AND okulid='{$_POST['ogretim']}'")->fetchAll(PDO::FETCH_ASSOC);

            if(empty($Sorgula)) {

                           $SqlHazir=$db->prepare("INSERT INTO ogrenci SET
                            okulid=:g_okulid,
                            sinif=:g_sinif,
                            numara=:g_numara,
                            isim=:g_isim,
                            soyisim=:g_soyisim,
                            tcno=:g_tcno,
                            bolum=:g_bolum
                          ");

                            if(empty($data[4])){
                                $tc=0;
                            }else{
                                $tc=$data[4];
                            }
                            if(empty($data[5])){$bolum=' ';}else{$bolum=$data[5];}
                            $SqlGiris=$SqlHazir->execute(array(
                                'g_okulid'  => addslashes($_POST['ogretim']),
                                'g_sinif'   => addslashes($data[3]),
                                'g_numara'   => addslashes($data[0]),
                                'g_isim'   => addslashes($data[1]),
                                'g_soyisim'   => addslashes($data[2]),
                                'g_tcno'   => addslashes($tc),
                                'g_bolum'   => addslashes($bolum),

                            ));
                if($SqlGiris){
                    $say++;
                }else{
                    $sayma++;
                    $eklenemeyen.=$data[0].',';
                }

            }else{
                $sayma++;
                $eklenemeyen.=$data[0].',';
            }

        }
    } while ($data = fgetcsv($handle,1000,";","'"));
    //

    $Sonuclar='';
    if($say>0){
        $Sonuclar.= '<b>'.$say. '</b> öğrenci eklendi. ';
    }
    if($sayma>0){
        $Sonuclar.= '<b>'.$sayma. '</b> öğrenci eklenemedi. Eklenemeyen Öğrenciler: '.$eklenemeyen;
    }

    session_start();
    $_SESSION['formsonuc']=$Sonuclar;
    header('Location:'.$link.'/ogrenci/New/3?Okul='.$_POST['ogretim']);
    //redirect


}else{
    echo 'dosya seçilmedi';
}

?>