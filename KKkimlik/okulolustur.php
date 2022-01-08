<?php $step=$_GET['step']; ?>
<title>Okul Oluþtur</title>
<?php if($step==1){ ?>
<form action="islem.php" method="post" enctype="multipart/form-data">
<div style="display:none;"><input type="text" name="islem" value="1" /></div>
Okul Adý:<input type="text" name="okuladi" /><br />
Öðretim Yýlý: <select name="ogryili">
<option selected value="2013/2014">2013/2014</option>
<option value="2014/2015">2014/2015</option>
<option value="2015/2016">2015/2016</option>
<option value="2016/2017">2016/2017</option>
<option value="2017/2018">2017/2018</option>
<option value="2018/2019">2018/2019</option>
<option value="2019/2020">2019/2020</option>
</select><br />
Logo: <input type="file" name="file" id="file"><br />
Müdür Adý:<input type="text" name="muduradi" /><br />
<input type="submit" value="Adým 2" />



<?php }elseif($step==2){ ?>







<?php } else{ echo 'hata!, baþa dön'; } ?>