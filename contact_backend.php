 <?php 
		if(re('contact_send') =='Gönder'){   
		$kayit = true;
		$hata_mesaj = '';
		$ad=re("ad");
		$soyad=re("soyad");
		$email=re("email");
		$mesaj=re("mesaj");

		if(re('ad') == "") { $kayit = false; $hata_mesaj .= 'Ad alanı boş olamaz,'; }
		if(re('soyad') == "") { $kayit = false; $hata_mesaj .= 'Soyadı alanı boş olamaz,'; }
		if(re('email') == "") { $kayit = false; $hata_mesaj .= 'Email alanı boş olamaz,'; }
		if(re('mesaj') == "") { $kayit = false; $hata_mesaj .= 'Mesaj alanı boş olamaz,'; }
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {  $kayit = false; $hata_mesaj .= "Email geçerli değil";}
		if($kayit == true){
			$a=mysql_query("insert into iletisim_formu (id,ad,soyad,email,mesaj,olusturulma_zamani)
			values
			(null,'".$ad."','".$soyad."','".$email."','".$mesaj."','".date('Y-m-d H:i:s')."')
			
			")or die(mysql_error());       
			
			alert("Mesaj Başarıyla Gönderildi");
		}else{
			alert($hata_mesaj);
		}       	
			 
		
     }

	
 ?>