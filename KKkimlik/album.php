
<?php 
$sinif2=$_GET["sinifadi"]; 
$sinif='siniflar/'.$sinif2;

$link = mysql_connect("localhost", "root", "") or die(mysql_error());
$db = mysql_select_db("emre", $link) or die (mysql_error());
mysql_query("SET NAMES 'latin5'");
mysql_query("SET CHARACTER SET latin5");
mysql_query("SET COLLATION_CONNECTION = 'latin5_turkish_ci'");  

$vericek=mysql_query("SELECT * FROM bkaol WHERE sinif='$sinif2' ORDER BY ABS(no) ASC");

?>
<HEAD>
<TITLE><?php echo $sinif2; ?></TITLE>
</HEAD>
<div style="width:1000px; height:auto; margin:0 auto; float:center;  ">
	<div style="font-family:Verdana; font-size:25px; font-weight:bold; text-align:center;">2013-2014 ÖÐRETÝM YILI <br /> BAFRA KIZILIRMAK ANADOLU ÖÐRETMEN LÝSESÝ <?php echo strtoupper($sinifadi); ?> SINIFI ALBÜMÜ</div>
	<div style="clear:both; height:20px;"></div>
<?php 
while($verial=mysql_fetch_array($vericek)){
$sinif=$verial[4];
$numara=$verial[1];
$isimtam=$verial[2];
$soyisim=$verial[3];


?>
<div style="width:120px; height:250px; float:left;">
<?php  echo '<img width="100px" src="siniflar/'.$sinif.'/'.$numara.'.JPG"><br />'; 
?>
 <div style="font-family:Arial; width:100px; float:left; text-align:center; font-size:15px; font-weight:bold;">
 <?php echo $numara.'<br />';
echo $isimtam.' '.$soyisim;
?>
 </div>
 
</div>


<?php }

?>
<div style="float:right; width:1000px; height:8px; margin-top:-15px; margin-right:40px; text-align:right;"><img src="ediplogobuyuk2.png" width="150px" /></div>
</div>

