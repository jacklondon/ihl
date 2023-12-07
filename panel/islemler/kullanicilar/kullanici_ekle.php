<?php
    if(re('yoneticiyi')=="Kaydet"){
		$gelen_id = re('id');
		$sifre = re('sifre');
		$email = re('email');
		$prim_orani = re('prim_orani');
		$uppercase = preg_match('@[A-Z]@', $sifre);	
		$lowercase = preg_match('@[a-z]@', $sifre);
		$number    = preg_match('@[0-9]@', $sifre);	
		$token = md5(uniqid(mt_rand(), true));

		if($prim_orani == ""){
			$prim_orani = 0;
		}
	
        if(re('id') != ""){
			$kullanici_kontrol = mysql_query("select * from kullanicilar where email='" . re("email") . "' and id <> '".$gelen_id."' and durum <> 0");
			$gsm_kontrol = mysql_query("select * from kullanicilar where tel='" . re("gsm") . "' and id <> '".$gelen_id."' and durum <> 0");
			$nickname_kontrol = mysql_query("select * from kullanicilar where kullanici_adi='" . re("kullanici_adi") . "' and id <> '".$gelen_id."' and durum <> 0");
			if( $sifre!="" && ( re('sifre')!=re('sifre_tekrar'))){
				$bilgi = "Şifreler Eşleşmiyor Lütfen Tekrar Deneyiniz";
				alert($bilgi);
			}else if($sifre!="" && (!$uppercase || !$lowercase || !$number )){
				$bilgi = "Şifrenizde sayi,küçük harf ve büyük harf olmalıdır";
				alert($bilgi);
			}else if(mysql_num_rows($kullanici_kontrol)>0){
				$bilgi = "Email adresi başka birisi tarafından kullanılmaktadır.";
				alert($bilgi);
			}else if(mysql_num_rows($gsm_kontrol)>0){
				$bilgi = "Telefon numarası başka birisi tarafından kullanılmaktadır.";
				alert($bilgi);
			}else if(mysql_num_rows($nickname_kontrol)>0){
				$bilgi = "Kullanıcı adı başka birisi tarafından kullanılmaktadır.";
				alert($bilgi);
			}else if(!filter_var(re("email"), FILTER_VALIDATE_EMAIL)){
				$bilgi = "Lütfen geçerli bir email adresi giriniz.";
				alert($bilgi);	
			}else{
				
				$admin_kontrol = mysql_query("SELECT * FROM kullanicilar WHERE id = '".re('id')."'");
				$admin_kontrol_yaz = mysql_fetch_assoc($admin_kontrol);
				
				if($sifre!=""){
					$son_sifre = md5($sifre);
				}else{
					$son_sifre = $admin_kontrol_yaz["sifre"];
				}
				
				/*$admin_sifre = $admin_kontrol_yaz['sifre'];
				if($admin_sifre == $sifre){
					$son_sifre = $sifre;
				}else{
					$son_sifre = md5($sifre);
				}*/
				
				$yetkiler=$_POST["yetki"];
				$yetki_say=count($yetkiler);
				$yetkiler_array=array();            

				for($i=0;$i<$yetki_say;$i++)
				{
					array_push($yetkiler_array,$yetkiler[$i]);
				}
				
				$columns = implode(",",array_keys($yetkiler_array));
				$escaped_values = array_map('mysql_real_escape_string', array_values($yetkiler_array));
				$values  = implode("|", $yetkiler_array);
				if(re('id')==1){
					$performans_kazanci_orani=re("performans_kazanci_orani");
				
				}else{
					$performans_kazanci_orani=0;
				}
				$performans_kazanci_orani=re("performans_kazanci_orani");
				
				if(re("departman")=="Diğer"){
					$departman=re("diger_departman");
				}else{
					$departman=re("departman");
				}
				
				$listelenme_sirasi=re("listelenme_sirasi");
				$sql = mysql_query("update kullanicilar set kullanici_adi = '".re('kullanici_adi')."', sifre = '".$son_sifre."', adi = '".re('adi')."', soyadi = '".re('soyadi')."', tel = '".re('gsm')."', yetki = '".$values."',
				prm_limiti = '".re('prm_limiti')."', listelenme_durumu = '".re('listelenme_durumu')."',prim_orani = '".$prim_orani."',performans_kazanci_orani='".$performans_kazanci_orani."',listelenme_sirasi='".$listelenme_sirasi."',
				departman='".$departman."', email = '$email' where id = '".re('id')."'");
				echo '
					<script>
						alert( "Kullanıcı Güncellendi ");
						window.location.href="sistem.php?modul=admin&sayfa=admin_ekle&id='.re("id").'";
					</script>
				';
			
				
			}

        }else{
			$kullanici_kontrol = mysql_query("select * from kullanicilar where email='" . re("email") . "' and durum <> 0");
			$gsm_kontrol = mysql_query("select * from kullanicilar where tel='" . re("gsm") . "' and durum <> 0");
			$nickname_kontrol = mysql_query("select * from kullanicilar where kullanici_adi='" . re("kullanici_adi") . "' and durum <> 0");
           
			if(re('sifre')!=re('sifre_tekrar')){
				$bilgi = "Şifreler Eşleşmiyor Lütfen Tekrar Deneyiniz";
				alert($bilgi);
				
			}else if(!$uppercase || !$lowercase || !$number ){
				$bilgi = "Şifrenizde sayi,küçük harf ve büyük harf olmalıdır";
				alert($bilgi);
			}else if(mysql_num_rows($kullanici_kontrol)>0){
				$bilgi = "E-mail başka birisi tarafından kullanılmaktadır.";
				alert($bilgi);
			}else if(mysql_num_rows($gsm_kontrol)>0){
				$bilgi = "Telefon numarası başka birisi tarafından kullanılmaktadır.";
				alert($bilgi);
			}else if(mysql_num_rows($nickname_kontrol) > 0){
				$bilgi = "Kullanıcı adı başka birisi tarafından kullanılmaktadır.";
				alert($bilgi);
			}else if(!filter_var(re("email"), FILTER_VALIDATE_EMAIL)){
				$bilgi = "Lütfen geçerli bir email adresi giriniz.";
				alert($bilgi);	
			}else if(re('uye_grubu')==0){    
				$yetkiler=$_POST["yetki"];
				$yetki_say=count($yetkiler);
				$yetkiler_array=array();            
			
				for($i=0;$i<$yetki_say;$i++)
				{
						array_push($yetkiler_array,$yetkiler[$i]);
				}
				
				$columns = implode(",",array_keys($yetkiler_array));
				$escaped_values = array_map('mysql_real_escape_string', array_values($yetkiler_array));
				$values  = implode("|", $yetkiler_array); 
				
				if(re("departman")=="Diğer"){
					$departman=re("diger_departman");
				}else{
					$departman=re("departman");
				}
				
				$listelenme_sirasi=re("listelenme_sirasi");
				
				mysql_query("INSERT INTO kullanicilar
				(
					kullanici_adi,
					sifre,
					adi,
					soyadi,
					email,
					tel,
					yetki,
					prm_limiti,
					durum,
					token,
					listelenme_durumu,
					prim_orani,
					performans_kazanci_orani,
					departman,
					listelenme_sirasi	
				)
				VALUES
				(
					'".re('kullanici_adi')."',
					'".md5(re('sifre'))."',
					'".re('adi')."',
					'".re('soyadi')."',
					'".$email."',
					'".re('gsm')."',
					'$values',
					'".re('prm_limiti')."',
					1,
					'".$token."',
					'".re('listelenme_durumu')."',
					'".$prim_orani."',
					'0',
					'".$departman."',
					'".$listelenme_sirasi."'
				)");
				
				
				
				alert("Kullanıcı Eklendi..");
			}else if(re('uye_grubu')==1){  
				
				$yetkiler=$_POST["yetki"];
				$yetki_say=count($yetkiler);
				$yetkiler_array=array();            

				for($i=0;$i<$yetki_say;$i++)
				{
						array_push($yetkiler_array,$yetkiler[$i]);
				}
				
				$columns = implode(",",array_keys($yetkiler_array));
				$escaped_values = array_map('mysql_real_escape_string', array_values($yetkiler_array));
				$values  = implode("|", $yetkiler_array);
				
				if(re("departman")=="Diğer"){
					$departman=re("diger_departman");
				}else{
					$departman=re("departman");
				}
				
				mysql_query("INSERT INTO kullanicilar
				(
					kullanici_adi,
					sifre,
					adi,
					soyadi,
					email,
					tel,
					yetki,
					prm_limiti,
					durum,
					token,
					listelenme_durumu,
					prim_orani,
					performans_kazanci_orani,
					departman,
					listelenme_sirasi	
				)
				VALUES
				(
					'".re('kullanici_adi')."',
					'".md5(re('sifre'))."',
					'".re('email')."',
					'".re('adi')."',
					'".re('soyadi')."',
					'".re('gsm')."',
					'$values',
					'".re('prm_limiti')."',
					1,
					'".$token."',
					'".re('listelenme_durumu')."',
					'".$prim_orani."',
					'0',
					'".$departman."',
					'".$listelenme_sirasi."'
				)");
				
				alert("Kullanıcı Eklendi..");
			}
			else {
            
			}
        }
    }
?>