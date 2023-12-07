  <?php 
	$id=re("id");
	$sorgu=mysql_query("select * from iletisim where id='".$id."' ");
	$row=mysql_fetch_object($sorgu);
	$mevcut_adres=$row->adres;
	$mevcut_email=$row->email;
	$mevcut_sabit_hat=$row->sabit_hat;
	$mevcut_fax_sms=$row->fax_sms;
	$mevcut_skype=$row->skype;
	$mevcut_telefon=$row->telefon;
	$mevcut_iframe=$row->iframe;
	$mevcut_facebook=$row->facebook;
	$mevcut_twitter=$row->twitter;
	$mevcut_instagram=$row->instagram;
	$mevcut_youtube=$row->youtube;

	if(re('iletisim_guncelle') =='İletişim Güncelle'){   
		$kayit = true;
		$hata_mesaj = '';
		$adres=re("adres");
		$email=re("email");
		$sabit_hat=re("sabit_hat");
		$fax_sms=re("fax_sms");
		$telefon=re("telefon");
		$iframe=re("iframe");
		$skype=re("skype");
		$facebook=re("facebook");
		$twitter=re("twitter");
		$instagram=re("instagram");
		$youtube=re("youtube");
	
		if(re('adres') == "") { $kayit = false; $hata_mesaj .= 'Adres alanı boş olamaz,'; }
		if(re('email') == "") { $kayit = false; $hata_mesaj .= 'Email alanı boş olamaz,'; }
		if(re('fax_sms') == "") { $kayit = false; $hata_mesaj .= 'Fax ve SMS alanı boş olamaz,'; }
		if(re('sabit_hat') == "") { $kayit = false; $hata_mesaj .= 'Sabit Hat alanı boş olamaz,'; }
		//if(re('skype') == "") { $kayit = false; $hata_mesaj .= 'Skype alanı boş olamaz,'; }
		if(re('telefon') == "") { $kayit = false; $hata_mesaj .= 'Telefon alanı boş olamaz,'; }
		if(re('iframe') == "") { $kayit = false; $hata_mesaj .= 'İframe alanı boş olamaz,'; }

		if($kayit == true){
			$a=mysql_query("
						update 
							iletisim
						set 	
							adres='".$adres."',
							sabit_hat='".$sabit_hat."',
							fax_sms='".$fax_sms."',
							telefon='".$telefon."',
							email='".$email."',
							skype='".$skype."',
							iframe='".$iframe."',
							facebook='".$facebook."',
							twitter='".$twitter."',
							instagram='".$instagram."',
							youtube='".$youtube."'
						where
							id ='".$id."'
			")or die(mysql_error());       
			/*$a=mysql_query("
						update 
							iletisim
						set 	
							adres='".$adres."',
							sabit_hat='".$sabit_hat."',
							fax_sms='".$fax_sms."',
							telefon='".$telefon."',
							email='".$email."',
							skype='".$skype."',
							iframe='".$iframe."',
							facebook='".$facebook."',
							twitter='".$twitter."',
							instagram='".$instagram."',
							youtube='".$youtube."'
						where
							id ='".$id."'
			")or die(mysql_error());       */
			
			alert("Başarıyla Güncellendi..");
			header("location: ?modul=iletisim&sayfa=iletisim_islemleri");
		}else{
			alert($hata_mesaj);
		}       	
		
		
     }

	
 ?>