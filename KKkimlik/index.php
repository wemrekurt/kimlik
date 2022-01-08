<?php include('dbkontrol.php'); ?>
<html>
<head>
<title>Emre Okul Malzemeleri</title>
</head>
<body style="background:#c6c6c6; width:750px; margin:0 auto; text-align:center; font-family:Verdana; font-size:14px;">

<b><h2>Güç: <font color="green">AÇIK</font>
<br />
<h2>Güvenlik Kalkanları:<font color="green">DEVREDE</font><br />
Sistem Hazır!
</h2></b><br />
<div style="clear:both; height:10px;"></div>
<img src="ediplogobuyuk2.png" width="200">

<hr />
Mevcut Okullar:<br />
<?php 
$okulsorgu =mysql_query('SELECT * FROM okul');
while($okulbilgi=mysql_fetch_array($okulsorgu)){
echo $okulbilgi[1].'<br />';
}
?>
<hr />

<a href="okulolustur.php" />Yeni Okul Oluştur</a>
</body>


</html>