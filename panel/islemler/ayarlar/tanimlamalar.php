<?php 
	if(re('tanimlari') == "Kaydet")
	{
		if($_FILES['site_logo']["name"] != "")
		{
			$dosya_adi=$_FILES['site_logo']["name"];
			$dizim=array("iz","et","se","du","yr","nk");
			$uzanti=substr($dosya_adi,-4,4);
		
			$rasgele=rand(1,1000000);
			$ad=$dizim[rand(0,5)].$rasgele.$uzanti;
			$yeni_ad="../images/".$ad;
			move_uploaded_file($_FILES['site_logo']['tmp_name'],$yeni_ad);
			
			mysql_query("update site_ozellikleri set site_logo='".$ad."' where durum='1'");
			alert("Logo Başarıyla Güncellendi..");
		}
		
		if($_FILES['site_favicon']["name"] != "")
		{
			$dosya_adi=$_FILES['site_favicon']["name"];
			$dizim=array("iz","et","se","du","yr","nk");
			$uzanti=substr($dosya_adi,-4,4);
		
			$rasgele=rand(1,1000000);
			$ad=$dizim[rand(0,5)].$rasgele.$uzanti;
			$yeni_ad="../images/".$ad;
			move_uploaded_file($_FILES['site_favicon']['tmp_name'],$yeni_ad);
			
			mysql_query("update site_ozellikleri set site_favicon='".$ad."' where durum='1'");
			alert("Fav İcon Başarıyla Güncellendi..");
		}
		
		if($_FILES['kat_alt_reklam']["name"] != "")
		{
			$dosya_adi=$_FILES['kat_alt_reklam']["name"];
			$dizim=array("iz","et","se","du","yr","nk");
			$uzanti=substr($dosya_adi,-4,4);
		
			$rasgele=rand(1,1000000);
			$ad=$dizim[rand(0,5)].$rasgele.$uzanti;
			$yeni_ad="../images/".$ad;
			move_uploaded_file($_FILES['kat_alt_reklam']['tmp_name'],$yeni_ad);
			
			mysql_query("update site_ozellikleri set kat_alt_reklam='".$ad."' where durum='1'");
			alert("Kategori Alt Banner İcon Başarıyla Güncellendi..");
		}
		
		mysql_query("update site_ozellikleri set site_adi='".re('site_adi')."' ,site_haber='".re('site_haber')."', site_ana_renk='".re('site_ana_renk')."', site_gecis_renk='".re('site_gecis_renk')."', instagram='".re('instagram')."', youtube='".re('youtube')."', site_kisa_adi='".re('site_kisa_adi')."' ,title='".re('title')."' ,author='".re('author')."' ,description='".re('description')."' ,keywords='".re('keywords')."' ,facebook='".re('facebook')."' ,twitter='".re('twitter')."' ,google='".re('google')."' ,adres='".re('adres')."' ,tel='".re('tel')."' ,email='".re('email')."' ,maps='".re('maps')."' where durum='1' ");
	}
	
	$site_cek = mysql_query("select * from site_ozellikleri where durum='1' ");
	$site_oku = mysql_fetch_assoc($site_cek);
?>
