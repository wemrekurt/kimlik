<?php 
$sinifadi=$_GET["sinifadi"]; 


$link = mysql_connect("localhost", "root", "") or die(mysql_error());
$db = mysql_select_db("program", $link) or die (mysql_error());
mysql_query("SET NAMES 'latin5'");
mysql_query("SET CHARACTER SET latin5");
mysql_query("SET COLLATION_CONNECTION = 'latin5_turkish_ci'");  
?>


<!DOCTYPE html>
<html>
  
  <head data-gwd-animation-mode="quickMode">
    <title>Yemek Kartlarý</title>
    <style type="text/css">
      html, body {
        width: 100%;
        height: 100%;
        margin: 0px;
      }
      body {
        background-color: transparent;
        -webkit-transform: perspective(1400px) matrix3d(1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1);
        -webkit-transform-style: preserve-3d;
      }
    
	#genelle{margin-left:40px;margin-top:20px; width:740px; height:auto;}
	.kimlikdis{width:370px; height:215px; float:left;}
	 
	 .genel{
	  width:300px; 
	  height:180px;
	  background: url(yemek.jpg) no-repeat center;
	  border:1px solid #000000;
	  float:left;
	  border-radius:5px;
	  	  
	  }
	  .temizlikci{width:120px; clear:both; float:left;}
	  .header{
	  }
	  .tablo{  font-size:13px; height:75px; }
		.kucuklogo{width:40px; height:40px; float:left; margin-left:-5px; margin-top:2px;
		
		}
		.kimlikbaslik{margin-left:4px; margin-right:4px; width:200px; height:40px; color:#ffffff; font-size:12px; font-family:Verdana; font-weight:bold; text-align:center; float:left;}
		
		.bilgiler{width:300px; height:130px; }
		.resim{width:87px; height:130px; float:left;}
		.info{width:200px; height:120px; float:left; padding-left:5px; padding-top:10px; font-family:sans-serif;}
		.qr{width:100px; height:10px; float:left; 	}
	.muduradi{font-size:22px; color:#f70000; width:100px; height:19px; float:left; margin-top:6px;  font-weight:bold; text-align:center; }
	.logosag{height:70px; width:15px; float:right; margin-top:-90px; margin-right:-10px;}
    </style>

  </head>
  
  <body>
   
	<div id="genelle">
	
<?php 
$dir = opendir($sinif); 
$sqlsorgu=mysql_query("SELECT * FROM yemek");
while ($obje=mysql_fetch_array($sqlsorgu)) 
{
$no=$obje[3];
$isim=$obje[1];
$soyisim=$obje[2];
$sinif = $obje[4];

?>

	<div class="kimlikdis">
		<div class="genel">
			<div class="header" style="height:50px; background:#f48e21; width:290px; padding-left:5px; padding-right:5px;
	  -webkit-border-top-left-radius: 5px;
-webkit-border-top-right-radius: 5px;
-moz-border-radius-topleft: 5px;
-moz-border-radius-topright: 5px;
border-top-left-radius: 5px;
border-top-right-radius: 5px;">
				<div class="kucuklogo" style="margin-left:1px;"> <img src="meblogo.png" width="45px" height="45px" /></div>			
				<div class="kimlikbaslik">BAFRA KIZILIRMAK <br />ANADOLU ÖÐRETMEN LÝSESÝ<div style="clear:both; height:5px; margin-top:-5px;"></div>
				<font size="1">2013-2014 Öðrenci Yemek Kartý</font></div>
				<div class="kucuklogo"> <img src="okullogo.png" width="50px" height="50px" /></div>
			</div> 
			<div class="bilgiler">
				<div class="resim">
					<img src="siniflar/<?php echo $sinif.'/'.$no ?>.JPG" height="130px; width:87px;" />
				</div>
				<div class="info">
					<div class="tablo">
					<table  >
					
						<tr ><td><b>Adý</b></td><td><b>:</b></td><td ><div style="width:150px;"><b><?php echo $isim; ?></b></div></td></tr>
						<tr><td><b>Soyadý</b></td><td><b>:</b></td><td><b><?php echo $soyisim; ?></b></td></tr>
						<tr><td><b>Sýnýf/No</b></td><td><b>:</b></td><td><b><?php echo $sinif; ?>, <?php echo $no; ?></b></td></tr>
					</table>
					</div>
					
					
					<div style="height:15px; margin-left:15px; margin-top:-5px; width:100%; font-size:10px; font-family:Tahoma; font-weight:bold;">
					<img width="50" src="http://qrfree.kaywa.com/?l=1&s=8&d=<?php echo $sinif.'+'.$no; ?>" /></div>
				<div class="qr"> <div style="float:left;">
				
				
				</div></div>
				<div class="muduradi">MART</div>
				<div class="logosag"><img src="ediplogobuyuk.png" height="70px" /></div>
				</div>	
				
			</div>
			
		</div>
	</div>		

		<?php } ?>
	
	</div>
	
	
	
	
	
	
	
	
	
	
	
  </body>

  
   
  
  
  
  
  
  
  
  
  
  
</html>
