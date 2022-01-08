<?php
include('dbkontrol.php');
mysql_query("SET NAMES 'latin5'");
mysql_query("SET CHARACTER SET latin5");
mysql_query("SET COLLATION_CONNECTION = 'latin5_turkish_ci'");  

$islemno=$_POST['islem'];

if($islemno==1){
$okuladim=$_POST['okuladi'];
$muduradi=$_POST['muduradi'];
$ogretimyili=$_POST['ogryili'];

function temizle($tr1) {
$turkce=array("ş","Ş","ı","ü","Ü","ö","Ö","ç","Ç","ş","Ş","ı","ğ","Ğ","İ","ö","Ö","Ç","ç","ü","Ü");
$duzgun=array("s","S","i","u","U","o","O","c","C","s","S","i","g","G","I","o","O","C","c","u","U");
$tr1=str_replace($turkce,$duzgun,$tr1);
$tr1 = preg_replace("@[^a-z0-9\-_şıüğçİŞĞÜÇ]+@i","-",$tr1);
return $tr1;
}

$okuladi=temizle($okuladim);

mkdir($okuladi, 0777);


/* dosya yükleme iþlemi */

$allowedExts = array("gif", "jpeg", "jpg", "png");
$temp = explode(".", $_FILES["file"]["name"]);
$extension = end($temp);
if ((($_FILES["file"]["type"] == "image/gif")
|| ($_FILES["file"]["type"] == "image/jpeg")
|| ($_FILES["file"]["type"] == "image/jpg")
|| ($_FILES["file"]["type"] == "image/pjpeg")
|| ($_FILES["file"]["type"] == "image/x-png")
|| ($_FILES["file"]["type"] == "image/png"))
&& ($_FILES["file"]["size"] < 200000)
&& in_array($extension, $allowedExts))
  {
  if ($_FILES["file"]["error"] > 0)
    {
    echo "Return Code: " . $_FILES["file"]["error"] . "<br>";
    }
  else
    {
   

    if (file_exists($okuladi."/" . $_FILES["file"]["name"]))
      {
      echo $_FILES["file"]["name"] . " already exists. ";
      }
    else
      {
      move_uploaded_file($_FILES["file"]["tmp_name"],
      $okuladi."/" . $_FILES["file"]["name"]);
      $logolink= $okuladi."/" . $_FILES["file"]["name"];
      echo "Suraya yüklendi: ". $logolink;
      }
    }
  }
else
  {
  echo "Invalid file";
  }


/* dosya yükleme iþlemi son */
if(!empty($okuladim) or !empty($logolink) or !empty($muduradi)){
mysql_query("INSERT INTO okul (id,okuladi,ogretimyili,logo,muduradi) values ('','$okuladim','$ogretimyili','$logolink','$muduradi') ");
echo '
<script language="javascript" type="text/javascript">
alert(\'Okul Başarıyla Eklendi!\')
window.location.assign("okulolustur.php?step=2")
</script>

';
}else{echo 'hata, hicbiri bos olamaz!';}

}









else{echo'Hata, baþa dönmelisin.!';}


?>