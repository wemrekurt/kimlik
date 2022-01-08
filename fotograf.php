<?php
/**
 * Created by PhpStorm.
 * User: Emre
 * Date: 22.9.2015
 * Time: 00:19
 */
session_start();
include('db.php');
if($_POST) {
    $Okul = $db->query("SELECT * FROM okul WHERE id='{$_POST['ogretim']}'")->fetch(PDO::FETCH_ASSOC);

    if (!empty($_POST['ogretim']) and $_POST['tur'] == 'arsiv') {


        $home_folder = 'okul/' . $Okul['sef'];
        $Dosyaadi = basename($_FILES['zip']['name']);
        $yuklenecek_dosya = $home_folder . '/' . basename($_FILES['zip']['name']);


        if (move_uploaded_file($_FILES['zip']['tmp_name'], $yuklenecek_dosya)) {

            $ZipFileName = $home_folder . '/' . $Dosyaadi;

            $zip = new ZipArchive;
            $_SESSION['yuklenmeyensayi']=$zip->numFiles;
            if ($zip->open($ZipFileName) === TRUE) {

                $zip->extractTo($home_folder);
                $_SESSION['yuklenensayi']=$zip->numFiles;
                $zip->close();

                unlink($ZipFileName);
                $_SESSION['fotosonuc']=1;
                header('Location:ogrenci/View/' . $_POST['ogretim']);

            } else {
                $_SESSION['yuklenmeyenler']= 'Arşivden Çıkarırken Hata Oluştu.';
                $_SESSION['fotosonuc']=1;
                header('Location:ogrenci/View/' . $_POST['ogretim']);

            }

        } else {

            $_SESSION['yuklenmeyenler']='Yüklerken Hata Oluştu!';
            $_SESSION['fotosonuc']=1;
            header('Location:ogrenci/View/' . $_POST['ogretim']);


        }


    } elseif (!empty($_POST['ogretim']) and $_POST['tur'] == 'resim') {


        $yol='okul/'.$Okul['sef'];

        $resimler = array();
        foreach ($_FILES['foto'] as $k => $l) {
            foreach ($l as $i => $v) {
                if (!array_key_exists($i, $resimler))
                    $resimler[$i] = array();
                $resimler[$i][$k] = $v;
            }
        }

        require_once('include/class.upload.php');
        $yuklenmeyen='';
        $yuklenmesay=0;
        $yuklensay=0;
        $sayigi=0;
        $topres= count($resimler);
        $cevirsekil=$_POST['cevir'];
        foreach ($resimler as $resim){

            $handle = new Upload($resim);

            if ($handle->uploaded) {

                /* Resim Yükleme İzni */
                $handle->allowed = array('image/*');
                $handle->image_convert='jpg';
                $handle->file_overwrite=true;
                $handle->image_rotate=$cevirsekil;

                /* Resmi İşle */
                $handle->Process($yol);
                if ($handle->processed) {
                    $yuklensay++;
                } else {
                    $yuklenmeyen[]=$resim['name'] . ' -> ' . $handle->error;
                    $yuklenmesay++;

                }

                $handle-> Clean();

            } else {

                $hatalar.= $resim['name'].' -> '.$handle->error.'<br />';
            }


$sayigi++;

        }

        if(!empty($hatalar)){ $_SESSION['yuklehata']=$hatalar; }
        if($yuklensay>0){ $_SESSION['yuklenensayi']=$yuklensay;}
        if($yuklenmesay>0){$_SESSION['yuklenmeyensayi']=$yuklenmesay; $_SESSION['yuklenmeyenler']=$yuklenmeyen;}

        if($sayigi==$topres){
            $_SESSION['fotosonuc']=1;
                header('Location:ogrenci/View/'.$Okul['id']);
            }



    } else {
        echo 'hata';
    }

}
?>