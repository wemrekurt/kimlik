function ajaxnesneyarat()
{
	var httpNesne = null;
	var Tarayici = navigator.appName;
	
	if(Tarayici == "Microsoft Internet Explorer"){
	
	httpNesne = new ActiveXObject("Microsoft.XMLHTTP");	
	}else{
	httpNesne= new XMLHttpRequest();
	}
	return httpNesne;
}


function ajaxistek(nesne,metot,dosya,degisken,fonksiyon)
{
	ajaxNesne = ajaxnesneyarat();
	
	if(metot=='POST')
		{
		// eğer method post ise
			if(ajaxNesne!=null)
			   {
				ajaxNesne.onreadystatechange=fonksiyon;
				ajaxNesne.open('POST',dosya,true);
				header ="application/x-www-form-urlencoded";
				ajaxNesne.setRequestHeader("Content-Type",header);
				ajaxNesne.send(degisken);
			   }else{
				alert('Ajax nesnesi oluşturulamıyor!');
			   }
		
		
		}else{
			// eğer method get ise
			if(ajaxNesne!=null)
			   {
				ajaxNesne.onreadystatechange=fonksiyon;
				ajaxNesne.open('GET',dosya+'?'+degisken,true);
				date ="7: May 1993";
				ajaxNesne.setRequestHeader("If-Modified-Since",date);
				ajaxNesne.send(null);
			   }else{
				alert('Ajax nesnesi oluşturulamıyor!');
			   }
			}
}






/*

function ajaxgerigetir()
{
	if(ajaxNesne.readyState==4)
	{
		if(ajaxNesne.status==200)
		{
			var mesaj = ajaxNesne.responseText;
			document.getElementById('msg').innerHTML=mesaj;
		}
		else
			document.getElementById('msg').innerHTML="Hata Oluştu!";
		
	
	}else{
	
	document.getElementById('msg').innerHTML = "İşleme Devam";

}
}*/