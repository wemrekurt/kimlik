
<?php 
$sinif2=$_GET["sinifadi"]; 
$sinif='siniflar/'.$sinif2;

$link = mysql_connect("localhost", "root", "") or die(mysql_error());
$db = mysql_select_db("emre", $link) or die (mysql_error());
mysql_query("SET NAMES 'latin5'");
mysql_query("SET CHARACTER SET latin5");
mysql_query("SET COLLATION_CONNECTION = 'latin5_turkish_ci'");  

$vericek=mysql_query("SELECT * FROM bkaol WHERE sinif='$sinif2'");

?>
<HEAD>
<TITLE><?php echo $sinif2; ?></TITLE>
</HEAD>
<div style="width:1000px; height:auto; margin:0 auto; float:center;  ">
	
<?php 


while($verial=mysql_fetch_array($vericek)){
for($sayi = 0; $sayi < 4; $sayi++) {
$sinif=$verial[0];
$numara=$verial[1];
$isimtam=$verial[2];
$soyisim=$verial[3];

$isimikili=explode("_",$isimtam);

$tamisim=$isimikili[0].' '.$isimikili[1];

$dosya=$numara.' - '.$isimtam.' '.$soyisim.'.JPG';
?>
<div style="width:110px; height:200px; float:left;">
<?php  echo '<img width="100px" src="siniflar/'.$sinif2.'/'.$numara.'.JPG"><br />';
echo '<div style="font-size:10px">'.$numara.' - '.$isimtam.'&nbsp;'.$soyisim.'</div>'; 
$dizi=explode(".JPG",$dosya);
$ayir=explode(" - ",$dizi[0]);
?>
 
 
</div>


<?php }  }

?>

</div>

