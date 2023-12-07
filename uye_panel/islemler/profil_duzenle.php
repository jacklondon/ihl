<?php 
   session_start();
   include '../../ayar.php';

    $token = $_SESSION['u_token'];
    if($token){
      $uye_token = $token;
    }
	$kullaniciyi_getir = mysql_query("SELECT * FROM user WHERE user_token = '".$uye_token."'");
	$kullaniciyi_getir_gel = mysql_fetch_assoc($kullaniciyi_getir);
	if(re("action")=="tc_kontrol"){
	
		$response=[];
		$tc_kimlik=re("tc_kimlik");
		$sorgu=mysql_query("select * from user where tc_kimlik='".$tc_kimlik."' ");
		if(strlen($tc_kimlik)!=11){
			$response=["message"=>"TC kimlik numaranız 11 rakamdan oluşmalıdır","status"=>500];
		}
		else
		{
			if($kullaniciyi_getir_gel["tc_kimlik"] != $tc_kimlik ){
				if(mysql_num_rows($sorgu)==1){
					$response=["message"=>"TC Kimlik numara kullanıldığı için uygun değil.","status"=>500];
				}
				else{
					$response=["message"=>"TC Kimlik numara kullanılmak için uygun.","status"=>200];
				}
			}else{
				if(mysql_num_rows($sorgu)==2){
					$response=["message"=>"TC Kimlik numara kullanıldığı için uygun değil.","status"=>500];
				}
				else{
					$response=["message"=>"TC Kimlik numara kullanılmak için uygun.","status"=>200];
				}
			}
		}
		
		echo json_encode($response);
	}
	if(re("action")=="email_kontrol"){
	
		$response=[];
		$email=re("email");
		$sorgu=mysql_query("select * from user where mail='".$email."' ");
	
			if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
				$response=["message"=>"Email formatına uygun değil.","status"=>500];
			}
			else
			{
				$response=["message"=>"Email formatına uygun.","status"=>200];
				if($kullaniciyi_getir_gel["mail"] != $email ){
					if(mysql_num_rows($sorgu)==1){
						$response=["message"=>"Email kullanıldığı için uygun değil.","status"=>500];
					}
					else{
						$response=["message"=>"Email kullanılmak için uygun.","status"=>200];
					}
				}else{
					if(mysql_num_rows($sorgu)==2){
						$response=["message"=>"Email kullanıldığı için uygun değil.","status"=>500];
					}
					else{
						$response=["message"=>"Email kullanılmak için uygun.","status"=>200];
					}
				}
			}
			echo json_encode($response);
		}

		if(re("action")=="tel_kontrol"){
	
		$response=[];
		$onayli_cep=re("onayli_cep");
		$sorgu=mysql_query("select * from user where telefon='".$onayli_cep."' ");
		if(strlen($onayli_cep)!=14) {
			$response=["message"=>"Telefon numaranız 11 rakamdan oluşmalıdır","status"=>500];
		}
		else
		{
			if($kullaniciyi_getir_gel["telefon"] != $onayli_cep ){
				if(mysql_num_rows($sorgu)==1){
					$response=["message"=>"Telefon numarası kullanıldığı için uygun değil.","status"=>500];
				}
				else{
					$response=["message"=>"Telefon numarası kullanılmak için uygun.","status"=>200];
				}
			}
			else{
				if(mysql_num_rows($sorgu)==2){
					$response=["message"=>"Telefon numarası kullanıldığı için uygun değil.","status"=>500];
				}
				else{
					$response=["message"=>"Telefon numarası kullanılmak için uygun.","status"=>200];
				}
			}
		}
		echo json_encode($response);
	}
	/*if(re("action")=="sabit_tel_kontrol"){
		
		$response=[];
		$sabit_tel=re("sabit_tel");
		$sorgu=mysql_query("select * from user where sabit_tel='".$sabit_tel."' ");
		if(strlen($sabit_tel)!=14) {
			$response=["message"=>"Sabit telefon numaranız 11 rakamdan oluşmalıdır","status"=>500];
		}
		else
		{
			if($kullaniciyi_getir_gel["sabit_tel"] != $sabit_tel ){
				if(mysql_num_rows($sorgu)==1){
					$response=["message"=>"Sabit telefon numarası kullanıldığı için uygun değil.","status"=>500];
				}
				else{
					$response=["message"=>"Sabit telefon numarası kullanılmak için uygun.","status"=>200];
				}
			}else{
				if(mysql_num_rows($sorgu)==2){
					$response=["message"=>"Sabit telefon numarası kullanıldığı için uygun değil.","status"=>500];
				}
				else{
					$response=["message"=>"Sabit telefon numarası kullanılmak için uygun.","status"=>200];
				}
			}
		}
		
		echo json_encode($response);
	}*/
/*	if(re("action")=="vergi_no_kontrol"){
	
		$response=[];
		$vergi_no=re("vergi_no");
		$sorgu=mysql_query("select * from user where vergi_dairesi_no='".$vergi_no."' ");
		if(strlen($vergi_no)!=10) {
			$response=["message"=>"Vergi numaranız 10 rakamdan oluşmalıdır","status"=>500];
		}
		else
		{
			if($kullaniciyi_getir_gel["vergi_dairesi_no"] != $vergi_no ){
				if(mysql_num_rows($sorgu)==1){
					$response=["message"=>"Vergi numarası kullanıldığı için uygun değil.","status"=>500];
				}
				else{
					$response=["message"=>"Vergi numarası kullanılmak için uygun.","status"=>200];
				}
			}else{
				if(mysql_num_rows($sorgu)==2){
					$response=["message"=>"Vergi numarası kullanıldığı için uygun değil.","status"=>500];
				}
				else{
					$response=["message"=>"Vergi numarası kullanılmak için uygun.","status"=>200];
				}
			}
		}
		
		echo json_encode($response);
	}*/
	if(re("action")=="yedek_sil"){
		$response=[];
		$gelen=re("yedek_id");
		$yedek_ad=$kullaniciyi_getir_gel["yedek_kisi"];
		$yedek_tel=$kullaniciyi_getir_gel["yedek_kisi_tel"];
		$yedek_ad=explode(",",$yedek_ad);
		$yedek_tel=explode(",",$yedek_tel);
		unset($yedek_ad[$gelen]);
		unset($yedek_tel[$gelen]);
		$yeni_yedek_ad = implode(",", $yedek_ad);
		$yeni_yedek_tel = implode(",", $yedek_tel);
		$guncelle=mysql_query(" update user set yedek_kisi='".$yeni_yedek_ad."',yedek_kisi_tel='".$yeni_yedek_tel."' where user_token = '".$uye_token."'" );
		if($guncelle){
			$response=["message"=>"Başarılı","status"=>200];
		}else{
			$response=["message"=>"Hata","status"=>500];
		}
	
		echo json_encode($response);
	}
	
	if(re('action')=="guncelle"){
	$response=[];
	$ad_soyad = re('ad_soyad');
	$tc_kimlik = re('tc_kimlik');
	$dogum_tarihi = re('dogum_tarihi');
	$email = re('email');
	$onayli_cep = re('onayli_cep');
	$sebep = re('why');	
	$cinsiyet = re('gender');
	$sabit_tel = re('sabit_tel');
	$sehir = re('sehir');
	$ilce = re('ilce');
	$meslek = re('meslek');
	$hurda_teklif = re('hurda_teklif');
	
	$yedek_kisi = $_POST["yedek_kisi"];//Array;
	$yedek_kisi_tel = $_POST["yedek_kisi_tel"];//Array;
	
	$ilgilendigi = $_POST["ilgilendigi"];//Array;
	//$adres = re('adres');
	//$vergi_dairesi = re('vergi_dairesi');
	//$vergi_no = re('vergi_no');
	$kargo_adresi = re('kargo_adresi');
	$fatura_adresi = re('fatura_adresi');

	$sehir_bul = mysql_query("SELECT * FROM sehir WHERE sehirID = '".$sehir."'");
	$sehir_yaz = mysql_fetch_assoc($sehir_bul);
	$sehiradi = $sehir_yaz['sehiradi'];

	$getirdigim_id = $kullaniciyi_getir_gel['id'];
	$dogum_tarihi_bul = mysql_query("SELECT * FROM dogum_tarihi WHERE uye_id = '".$getirdigim_id."' LIMIT 1");
	$dogum_tarihi_oku = mysql_fetch_assoc($dogum_tarihi_bul);
	$okunan_dogum_tarihi = $dogum_tarihi_oku['dogum_tarihi'];
	
	$sorgu=mysql_query("select * from user where telefon='".$onayli_cep."' ");
	$sorgu2=mysql_query("select * from user where sabit_tel='".$sabit_tel."' ");
	$sorgu3=mysql_query("select * from user where mail='".$email."' ");
	$sorgu4=mysql_query("select * from user where vergi_dairesi_no='".$vergi_no."' ");
	$sorgu5=mysql_query("select * from user where tc_kimlik='".$tc_kimlik."' ");
	
	$yedek_tel_durum=true;
	$yedek_ad="";
	$yedek_tel="";
	$yedekler=count($yedek_kisi);
	for($b=0;$b<$yedekler;$b++)
	{
		if($yedek_kisi_tel[$b] !="" && $yedek_kisi[$b] !=""){
			ltrim(rtrim($yedek_kisi[$b]));
			ltrim(rtrim($yedek_kisi_tel[$b]));
		}else{
			array_splice($yedek_kisi_tel, $b, 1);
			array_splice($yedek_kisi, $b, 1);
		}
	}
	$yedek_sayi=count($yedek_kisi);
	for($i=0;$i<count($yedek_kisi);$i++)
	{
		
		if($yedek_kisi_tel[$i]!="" && $yedek_kisi[$i]!=""){
			
			if(strlen($yedek_kisi_tel[$i])!=14){
				$yedek_tel_durum=false;
			}
			
			if($i!=$yedek_sayi-1){
				$yedek_ad.=$yedek_kisi[$i].",";
				$yedek_tel.=$yedek_kisi_tel[$i].",";
			}else{
				$yedek_ad.=$yedek_kisi[$i];
				$yedek_tel.=$yedek_kisi_tel[$i];
			}	
		}
	}
	$ilg_turler="";
	$ilg_sayi=count($ilgilendigi);
	for($j=0;$j<count($ilgilendigi);$j++){
		if($ilgilendigi[$j]!=""){
			if($j!=$ilg_sayi-1){
				$ilg_turler.=$ilgilendigi[$j].",";
			}else{
				$ilg_turler.=$ilgilendigi[$j];
			}	
		}
	}
	

	
	if($dogum_tarihi == "" || strlen($dogum_tarihi) != 10 ){
		$response=["message"=>"Lütfen doğum tarihinizi seçiniz","status"=>500];
	}else if($meslek == "" || $ilgilendigi == "" || $kargo_adresi == "" || $ilce == "" || $ad_soyad == "" || $tc_kimlik == "" || $dogum_tarihi == "" || $email == "" || $onayli_cep == "" || $sebep == "" || $cinsiyet == "" || $sehir == "" ){
		$response=["message"=>" Sabit telefon ve yedek kişi bilgileri dışındaki tüm alanları doldurmalısınız","status"=>500];	
	}else if(strlen($onayli_cep)!=14){
		$response=["message"=>" Telefon numaranız 11 rakamdan oluşmalıdır","status"=>500];
		
	}/*else if((strlen($sabit_tel)>4 || $sabit_tel =="") && strlen($sabit_tel) != 14){
		$response=["message"=>"Sabit telefon numaranız 11 rakamdan oluşmalıdır ",""=>strlen($sabit_tel),"status"=>500];
	}*/
	else if(strlen($tc_kimlik)!=11){
		$response=["message"=>"TC kimlik numaranız 11 rakamdan oluşmalıdır","status"=>500];
	}
	else if($yedek_tel_durum==false){
		$response=["message"=>"Yedek kişi telefon numarası 11 rakamdan oluşmalıdır ","status"=>500];
	}
	/* else if(strlen($vergi_no)!=10){
		$response=["message"=>"Vergi numarası 10 rakamdan oluşmalıdır","status"=>500];
	}*/
	else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		$response=["message"=>"Email formatına uygun değil.","status"=>500];
	}	
	else if(mysql_num_rows($sorgu)==1 && $kullaniciyi_getir_gel["telefon"] != $onayli_cep){	
		$response=["message"=>"Telefon numarası kullanılmakta","status"=>500];
	}
	else if(mysql_num_rows($sorgu)==2 && $kullaniciyi_getir_gel["telefon"] == $onayli_cep){
		$response=["message"=>"Telefon numarası kullanılmakta","status"=>500];
	}
	/*else if((strlen($sabit_tel)>4 || $sabit_tel =="") && mysql_num_rows($sorgu2)==1 && $kullaniciyi_getir_gel["sabit_tel"] != $sabit_tel){
		$response=["message"=>"Sabit telefon numarası kullanılmakta","status"=>500];
	}
	else if((strlen($sabit_tel)>4 || $sabit_tel =="") && mysql_num_rows($sorgu2)==2 && $kullaniciyi_getir_gel["sabit_tel"] == $sabit_tel){
		$response=["message"=>"Sabit telefon numarası kullanılmakta","status"=>500];
	}*/
	else if(mysql_num_rows($sorgu3)==1 && $kullaniciyi_getir_gel["mail"] != $email){
		$response=["message"=>"Email kullanılmakta","status"=>500];
	}
	else if(mysql_num_rows($sorgu3)==2 && $kullaniciyi_getir_gel["mail"] == $email){
		$response=["message"=>"Email kullanılmakta","status"=>500];
	}
	/* else if(mysql_num_rows($sorgu4)==1 && $kullaniciyi_getir_gel["vergi_dairesi_no"] != $vergi_no){
		$response=["message"=>"Vergi no kullanılmakta","status"=>500];
	}
	else if(mysql_num_rows($sorgu4)==2  && $kullaniciyi_getir_gel["vergi_dairesi_no"] == $vergi_no){
		$response=["message"=>"Vergi no kullanılmakta","status"=>500];
	}*/
	else if(mysql_num_rows($sorgu5)==1 && $kullaniciyi_getir_gel["tc_kimlik"] != $tc_kimlik){
		$response=["message"=>"TC kimlik numarası kullanılmakta","status"=>500];
	}
	else if(mysql_num_rows($sorgu5)==2 && $kullaniciyi_getir_gel["tc_kimlik"] == $tc_kimlik){
		$response=["message"=>"TC kimlik numarası kullanılmakta","status"=>500];
	}
	else{
		$ilce_cek=mysql_query("select * from ilce where ilceID='".$ilce."'");
		$ilce_oku=mysql_fetch_object($ilce_cek);
		$ilce_adi=$ilce_oku->ilce_adi;
		$user_guncelle=mysql_query("UPDATE user SET ad='".$ad_soyad."',tc_kimlik='".$tc_kimlik."',uye_olma_sebebi='".$sebep."',cinsiyet='".$cinsiyet."',
			mail='".$email."',telefon='".$onayli_cep."',sabit_tel='".$sabit_tel."',sehir='".$sehiradi."',meslek='".$meslek."',
			ilgilendigi_turler='".$ilg_turler."',kargo_adresi='".$kargo_adresi."',fatura_adresi='".$fatura_adresi."',
			yedek_kisi='".$yedek_ad."',yedek_kisi_tel='".$yedek_tel."',ilce='".$ilce_adi."'
			WHERE user_token = '".$uye_token."'");
		if($user_guncelle){
			$u=mysql_query("update uye_durumlari set hurda_teklif='".$hurda_teklif."' where uye_id='".$getirdigim_id."'");
			if($okunan_dogum_tarihi){
				$a=mysql_query("UPDATE `dogum_tarihi` SET `dogum_tarihi` = '".$dogum_tarihi."' WHERE uye_id = '".$getirdigim_id."'");
			}else{   
				mysql_query("INSERT INTO `dogum_tarihi` (`id`, `uye_id`, `dogum_tarihi`) VALUES (NULL, '".$getirdigim_id."' , '".$dogum_tarihi."')");
			}
			$response=["message"=>"Başarılı ","status"=>200];
		}
	}
	
	echo json_encode($response);
}

?>