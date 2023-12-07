<?php 
	session_start();
	include 'ayar.php';
	function str_split_unicode($str, $length = 1) {
		$tmp = preg_split('~~u', $str, -1, PREG_SPLIT_NO_EMPTY);
		if ($length > 1) {
			$chunks = array_chunk($tmp, $length);
			foreach ($chunks as $i => $chunk) {
				$chunks[$i] = join('', (array) $chunk);
			}
			$tmp = $chunks;
		}
		return $tmp;
	}

	if(re("action")=="email_kontrol"){
		//header("Content-Type: application/xml; charset=utf-8");
		$response=[];
		$email=re("email");
		$str="ÜĞŞÇÖğıüşöçİ";
		$sorgu=mysql_query("select * from user where mail='".$email."' ");
		
	
		$a=str_split_unicode($email,1);
		$b=str_split_unicode($str,1);
		if(count($a)>count($b)){
			$v=count($a);
		}else{
			$v=count($b);
		}
		$sayi=0;
		for($i=0;$i<$v;$i++){
			for($j=0;$j<$v;$j++){
				if($a[$j]==$b[$i]){
					$sayi++;
				}
			}
		}
		if($sayi != 0){
			$response=["message"=>"Email alanında türkçe karakter olmamalıdır.","status"=>500];
		}
		else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$response=["message"=>"Email formatına uygun değil.","m1"=>$v,"status"=>500];
		}
		else
		{
			$response=["message"=>"Email formatına uygun.","status"=>200];
			if(mysql_num_rows($sorgu)>=1){
				$response=["message"=>"Email kullanıldığı için uygun değil.","status"=>500];
			}
			else{
				$response=["message"=>"Email kullanılmak için uygun.","status"=>200];
			}
		}
		echo json_encode($response);
	}
	if(re("action")=="tel_kontrol"){
		
		$response=[];
		$tel=re("tel");
		$sorgu=mysql_query("select * from user where telefon='".$tel."' ");
		if(strlen($tel)!=14){
			$response=["message"=>"Telefon numaranız 11 rakamdan oluşmalıdır.","status"=>500];
		}
		else
		{
			if(mysql_num_rows($sorgu)>=1){
				$response=["message"=>"Telefon numaranız kullanıldığı için uygun değil.","status"=>500];
			}
			else{
				$response=["message"=>"Telefon numaranız kullanılmak için uygun.","status"=>200];
			}
		}
		
		echo json_encode($response);
	}
	/*if(re("action")=="sabit_tel_kontrol"){
		
		$response=[];
		$sabit_tel=re("sabit_tel");
		$sorgu=mysql_query("select * from user where sabit_tel='".$sabit_tel."' ");
		if((strlen($sabit_tel)>4 || $sabit_tel =="") && strlen($sabit_tel)!=14){
			$response=["message"=>"Sabit telefon 11 rakamdan oluşmalıdır.","status"=>500];
		}
		else
		{
			if(mysql_num_rows($sorgu)>=1){
				$response=["message"=>"Sabit telefon kullanıldığı için uygun değil.","status"=>500];
			}
			else{
				$response=["message"=>"Sabit telefon kullanılmak için uygun.","status"=>200];
			}
		}
			
		
		echo json_encode($response);
	}*/
	if(re("action")=="tc_kontrol"){
		$response=[];
		$tc_kimlik=re("tc_kimlik");
		$sorgu=mysql_query("select * from user where tc_kimlik='".$tc_kimlik."' ");
		if(strlen($tc_kimlik)!=11){
			$response=["message"=>"TC kimlik numaranız 11 rakamdan oluşmalıdır",""=>$tc_kimlik,"status"=>500];
		}
		else
		{
			if(mysql_num_rows($sorgu)==1){
				$response=["message"=>"TC Kimlik numara kullanıldığı için uygun değil.","status"=>500];
			}
			else{
				$response=["message"=>"TC Kimlik numara kullanılmak için uygun.","status"=>200];
			}	
		}
		
		echo json_encode($response);
	}

	if(re('action') == "Kaydol"){
		$response=[];
		//$ad = mb_convert_case(re('u_ad'),MB_CASE_UPPER,"UTF-8");
		$ad = buyukHarf(re('u_ad'));
		$sebep = re('u_sebep');
		$cinsiyet = re('u_cinsiyet');
		$mail = re('u_email');
		$telefon = re('u_tel');
		// $sabit_tel = re('u_sabit_tel');
		$u_dogum_tarihi = re('u_dogum_tarihi');
		$sehir = re('sehir');
		$ilce = re('ilce');
		$gelen_sifre = re('u_sifre');
		$sifre_tekrar = re('u_sifre_tekrar');
		$sifre = md5(re('u_sifre'));
		$kayit_tarihi = date('Y-m-d H:i:s');
		$token = md5(uniqid(mt_rand(), true));

		$sorgu=mysql_query("select * from user where telefon='".$telefon."' ");
		$sorgu2=mysql_query("select * from user where sabit_tel='".$sabit_tel."' ");
		$sorgu3=mysql_query("select * from user where mail='".$mail."' ");
		$sorgu4 = mysql_query("select * from sehir where sehirID = '".$sehir."'");
		$sonuc4 = mysql_fetch_assoc($sorgu4);
		$son_sehir = $sonuc4['sehiradi'];
		$str="ÜĞŞÇÖğıüşöçİ";
		$a=str_split_unicode($mail,1);
		$b=str_split_unicode($str,1);
		if(count($a)>count($b)){
			$v=count($a);
		}else{
			$v=count($b);
		}
		$sayi=0;
		for($i=0;$i<$v;$i++){
			for($j=0;$j<$v;$j++){
				if($a[$j]==$b[$i]){
					$sayi++;
				}
			}
		}
		$a=ltrim(rtrim(re("u_ad")));
		if($sayi != 0){
			$response=["message"=>"Email alanında türkçe karakter olmamalıdır.","status"=>500];
		}

		else if(!strstr($a," ")){
			$response=["message"=>"Ad soyad en az 2 kelime olmalı","status"=>500];
		}
		else if($gelen_sifre != $sifre_tekrar){
			$response=["message"=>"Şifreler uyuşmuyor lütfen tekrar deneyiniz","status"=>500];
		}else if( $ad == "" || $sebep == "" || $mail == "" || $telefon == "" || $sehir == "" || $gelen_sifre == "" || $sifre_tekrar == "" || $cinsiyet == "" ){
			$response=["message"=>"Tüm alanları doldurmalısınız","status"=>500];
			
		} else if(strlen($telefon)!=14){
			$response=["message"=>" Telefon numaranız 11 rakamdan oluşmalıdır","status"=>500];
			
		} /* else if((strlen($sabit_tel)>4 || $sabit_tel =="") && strlen($sabit_tel)!=14){
			$response=["message"=>"Sabit telefon numaranız 11 rakamdan oluşmalıdır","status"=>500];
		} */
		else if (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
			$response=["message"=>"Email formatına uygun değil.","status"=>500];
		}	
		else if(strlen($gelen_sifre)<6){
			$response=["message"=>"Şifreniz en az 6 haneli olmalıdır.","status"=>500];
		}
		else if(mysql_num_rows($sorgu)==1){
			$response=["message"=>"Telefon numarası kullanılmakta","status"=>500];
		}
	/*	else if(mysql_num_rows($sorgu2)==1){
			$response=["message"=>"Sabit telefon numarası kullanılmakta","status"=>500];
		}*/
		else if(mysql_num_rows($sorgu3)==1){
			$response=["message"=>"Email kullanılmakta","status"=>500];
		}
		else{
			/*
			$prm_cek = mysql_query("select ekleyen,durum,count(ekleyen) as toplam from prm_notlari where durum = 1 order by toplam desc");
			$prm_oku = mysql_fetch_object($prm_cek);
			if(mysql_num_rows($prm_cek) == 0){
				$admin_cek = mysql_query("SELECT kullanicilar.id, user.temsilci_id, COUNT(kullanicilar.id)AS toplam,(user.temsilci_id IS NOT NULL) AS temsilci_sayisi FROM kullanicilar LEFT JOIN user ON kullanicilar.id = user.temsilci_id 
				GROUP BY kullanicilar.id ORDER BY toplam ASC,temsilci_sayisi ASC");
				$admin_oku = mysql_fetch_object($admin_cek);
				$temsilci_id = $admin_oku->id;
			}else{
				$temsilci_id = $prm_oku->ekleyen;
			}
			*/
			$temsilci_id = 0;
		   mysql_query("INSERT INTO `user` (`id`, `ad`, `soyad`, `tc_kimlik`, `uye_olma_sebebi`, `cinsiyet`, `mail`, `telefon`, `sabit_tel`, `sehir`, `ilce`, `meslek`, `ilgilendigi_turler`, `sifre`, `adres`, `kargo_adresi`, 
			`fatura_adresi`, `user_token`, `paket`, `unvan`, `vergi_dairesi`, `vergi_dairesi_no`, `kurumsal_user_token`, `temsilci_id`, `kayit_tarihi`, `yedek_kisi`, `yedek_kisi_tel`, `risk`) 
			VALUES (NULL, '".$ad."', '', '', '".$sebep."', '".$cinsiyet."', '".$mail."', '".$telefon."', '".$sabit_tel."', '".$son_sehir."', '".$ilce."', '', '', '".$sifre."', '', '', '', '".$token."', 
			'1', '', '', '', '', '".$temsilci_id."', '".$kayit_tarihi."', '', '', '');");
			$uye_bul = mysql_query("SELECT * FROM user WHERE ad='".$ad."' AND telefon='".$telefon."' AND mail='".$mail."'");
			$uye_cek = mysql_fetch_assoc($uye_bul);
			$uye_id = $uye_cek['id'];
			mysql_query("INSERT INTO `teklif_limiti` (`id`,`uye_id`,`teklif_limiti`,`standart_limit`, `luks_limit`) VALUES (NULL, '".$uye_id."',0,0,0)");    
			/*mysql_query("INSERT INTO `cayma_bedelleri` (`id`,`uye_id`,`tutar`,`uye_grubu`, `tarih`) 
			VALUES 
			(NULL, '".$uye_id."',0,1,'".date("Y-m-d H:i:s")."')");  */	
			mysql_query("INSERT INTO `dogum_tarihi` (`id`,`uye_id`,`dogum_tarihi`) VALUES (NULL, '".$uye_id."','".$u_dogum_tarihi."')");  	
			mysql_query("INSERT INTO `uye_durumlari` (`id`, `uye_id`, `demo_olacagi_tarih`, `grup`, `teklif_limiti`, `hurda_teklif`, `yasak_sigorta`, `kalici_mesaj`, `kalici_sistem_mesaji`, `teklif_engelle`, `engelleme_nedeni`,
			`uyelik_iptal`, `uyelik_iptal_nedeni`, `mesaj_gorme_durumu`) VALUES (NULL, '".$uye_id."', '', '1', '0', '', '', '', '', '', '', '', '', '');"); 				
			$response=["message"=>"Kayıt Başarılı","status"=>200];
		}
		echo json_encode($response);
		
	}
	
	if(re('action')== "panel_kayit"){
		$response=[];		
		$token = md5(uniqid(mt_rand(), true));
		$firma      = buyukHarf(re('firma_adi'));
		$yetkili    = buyukHarf(re('yetkili_adi_soyadi'));
		$tc         = re('tc_kimlik');
		$dogum_tarihi  = re('dogum_tarihi');
		$gelensifre = re('sifre'); 
		$sifre      = md5($gelensifre);
		$email      = re('email');
		$cep_no     = re('onayli_cep_no');
		$il         = re('sehir');
		$ilce       = re('ilce');
		$cinsiyet   = re('cinsiyet');
		$sebep      = re('sebep');
		
		$yedek_kisi      = $_POST['yedek_kisi'];//Array
		$yedek_kisi_tel      = $_POST['yedek_kisi_tel'];//Array
		
		$uye_turu   = re('uye_turu');
		$kayit_tarihi = date('Y.m.d H:i:s');
		$sorgu=mysql_query("select * from user where telefon='".$cep_no."' ");
		$sorgu3=mysql_query("select * from user where mail='".$email."' ");
		$sorgu4=mysql_query("select * from user where vergi_dairesi_no='".re('vergi_dairesi_no')."' ");
		$str="ÜĞŞÇÖğıüşöçİ";
		$a=str_split_unicode($email,1);
		$b=str_split_unicode($str,1);
		if(count($a)>count($b)){
			$v=count($a);
		}else{
			$v=count($b);
		}
		$sayi=0;
		for($i=0;$i<$v;$i++){
			for($j=0;$j<$v;$j++){
				if($a[$j]==$b[$i]){
					$sayi++;
				}
			}
		}

		$a=ltrim(rtrim(re("firma_adi")));
		$b=ltrim(rtrim(re("yetkili_adi_soyadi")));
		
		$yedek_tel_durum=true;
		$yedek_ad="";
		$yedek_tel="";
		$yedekler=count($yedek_kisi);
		for($h=0;$h<$yedekler;$h++)
		{
			if($yedek_kisi_tel[$h] !="" && $yedek_kisi[$h] !=""){
				ltrim(rtrim($yedek_kisi[$h]));
				ltrim(rtrim($yedek_kisi_tel[$h]));
			}else{
				array_splice($yedek_kisi_tel, $h, 1);
				array_splice($yedek_kisi, $h, 1);
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
		
		
		if($sayi != 0){
			$response=["message"=>"Email alanında türkçe karakter olmamalıdır.","status"=>500];
		}

		
		else if(!strstr($a," ") && $uye_turu==2 ){
			$response=["message"=>"Firma Unvanı en az 2 kelime olmalıdır","status"=>500];
		}
		else if(!strstr($b," ")){
			$response=["message"=>"Ad soyad en az 2 kelime olmalıdır","status"=>500];
		}
		else if( $uye_turu == "" || $yetkili == "" || $tc == "" || $email == "" || $cep_no == "" || $il == "" || $ilce == "" || $gelensifre == "" || $sebep == "" || $cinsiyet == "" ){
			$response=["message"=>"Tüm alanları doldurmalısınız.","status"=>500];
		}	
		else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$response=["message"=>"Email formatına uygun değil.","status"=>500];
		}else if(strlen($cep_no)!=14){
			$response=["message"=>" Telefon numaranız 11 rakamdan oluşmalıdır","status"=>500];
		}
		else if(strlen($gelensifre)<6){
			$response=["message"=>"Şifreniz en az 6 haneli olmalıdır.","status"=>500];
		}
		else if(strlen($tc)!=11){
			$response=["message"=>"TC kimlik numarası 11 haneli olmalıdır.","status"=>500];
		}
		else if(mysql_num_rows($sorgu)==1){
			$response=["message"=>"Telefon numarası kullanılmakta","status"=>500];
		}
		else if(mysql_num_rows($sorgu2)==1){
			$response=["message"=>"Sabit telefon numarası kullanılmakta","status"=>500];
		}
		else if(mysql_num_rows($sorgu3)==1){
			$response=["message"=>"Email kullanılmakta","status"=>500];
		}
		else if(mysql_num_rows($sorgu4)!= 0 && $uye_turu=="2"){
			$response=["message"=>"Vergi numarası kullanılmakta","status"=>500];
		}
		else{
			$sehir_adi = mysql_query("SELECT * FROM sehir WHERE sehirID = $il");
			$sehir_gel = mysql_fetch_assoc($sehir_adi);
			$onay_kodu = substr(str_shuffle("0123456789"), 0, 6);
			$il = $sehir_gel["sehiradi"];
			$konum= $il." ".$ilce;
			if($uye_turu=="1"){
				mysql_query("INSERT INTO `user` (`id`, `ad`, `soyad`, `tc_kimlik`, `uye_olma_sebebi`, `cinsiyet`, `mail`, 
				`telefon`, `sabit_tel`, `sehir`, `ilce`, `meslek`, `ilgilendigi_turler`, `sifre`, `adres`, 
				`kargo_adresi`, `fatura_adresi`, `user_token`, `paket`, `unvan`, `vergi_dairesi`, `vergi_dairesi_no`, 
				`kurumsal_user_token`, `temsilci_id`, `kayit_tarihi`, `yedek_kisi`, `yedek_kisi_tel`, `risk`) VALUES 
				(NULL, '".$yetkili."', '', '".$tc."', '".$sebep."', '".$cinsiyet."', '".$email."', '".$cep_no."', '', 
				'".$il."', '".$ilce."', '', '', '".$sifre."', '".$konum."', '".$konum."', '".$konum."', '".$token."', 
				'1', '', '', '', '', '', '".$kayit_tarihi."', '".$yedek_ad."', '".$yedek_tel."', '');");
				$uye_bul = mysql_query("SELECT * FROM user WHERE ad='".$yetkili."' AND telefon='".$cep_no."' 
				AND mail='".$email."'");
				$uye_cek = mysql_fetch_assoc($uye_bul);
				$uye_id = $uye_cek['id'];
				mysql_query("INSERT INTO `dogum_tarihi` (`id`, `uye_id`, `dogum_tarihi`) VALUES (NULL, '".$uye_id."', '".$dogum_tarihi."');");
				mysql_query("INSERT INTO `teklif_limiti` (`id`,`uye_id`,`teklif_limiti`,`standart_limit`, `luks_limit`) 
				VALUES 
				(NULL, '".$uye_id."',0,0,0)");    
				/*mysql_query("INSERT INTO `cayma_bedelleri` (`id`,`uye_id`,`tutar`,`uye_grubu`, `tarih`) 
				VALUES 
				(NULL, '".$uye_id."',0,1,'".date("Y-m-d H:i:s")."')");  	*/
				mysql_query("INSERT INTO `uye_durumlari` (`id`, `uye_id`, `demo_olacagi_tarih`, `grup`, `teklif_limiti`, `hurda_teklif`, `yasak_sigorta`, `kalici_mesaj`, `kalici_sistem_mesaji`, `teklif_engelle`, `engelleme_nedeni`, `uyelik_iptal`, `uyelik_iptal_nedeni`, `mesaj_gorme_durumu`)
				VALUES (NULL, '".$uye_id."', '', '1', '0', '', '', '', '', '', '', '', '', '');"); 		
				mysql_query("insert into onayli_kullanicilar(user_id,kod,e_tarihi,durum) values ('".$uye_id."','".$onay_kodu."','".date('Y-m-d H:i:s')."',1)");
				$response=["message"=>"Kayıt Başarılı","status"=>200];
			}elseif($uye_turu=="2"){
				if( $firma=="" ){
					$response=["message"=>"Tüm alanları doldurmalısınız.","status"=>500];
				}	
				else{
				mysql_query("INSERT INTO `user` (`id`, `ad`, `soyad`, `tc_kimlik`, `uye_olma_sebebi`, `cinsiyet`, `mail`, 
				`telefon`, `sabit_tel`, `sehir`, `ilce`, `meslek`, `ilgilendigi_turler`, `sifre`, `adres`, 
				`kargo_adresi`, `fatura_adresi`, `user_token`, `paket`, `unvan`, `vergi_dairesi`, `vergi_dairesi_no`, 
				`kurumsal_user_token`, `temsilci_id`, `kayit_tarihi`, `yedek_kisi`, `yedek_kisi_tel`, `risk`) VALUES 
				(NULL, '".$yetkili."', '', '".$tc."', '".$sebep."', '".$cinsiyet."', '".$email."', '".$cep_no."', '', 
				'".$il."', '".$ilce."', '', '', '".$sifre."', '".$konum."', '".$konum."', '".$konum."', '', 
				'1', '".$firma."', '".re('vergi_dairesi')."', '".re('vergi_dairesi_no')."', '".$token."', '', '".$kayit_tarihi."', '".$yedek_ad."', '".$yedek_tel."', '');");
				$uye_bul = mysql_query("SELECT * FROM user WHERE ad='".$yetkili."' AND telefon='".$cep_no."' 
				AND mail='".$email."'");
				$uye_cek = mysql_fetch_assoc($uye_bul);
				$uye_id = $uye_cek['id'];
				mysql_query("INSERT INTO `dogum_tarihi` (`id`, `uye_id`, `dogum_tarihi`) VALUES (NULL, '".$uye_id."', '".$dogum_tarihi."');");
				mysql_query("INSERT INTO `teklif_limiti` (`id`,`uye_id`,`teklif_limiti`,`standart_limit`, `luks_limit`) 
				VALUES 
				(NULL, '".$uye_id."',0,0,0)");    
				/*mysql_query("INSERT INTO `cayma_bedelleri` (`id`,`uye_id`,`tutar`,`uye_grubu`, `tarih`) 
				VALUES 
				(NULL, '".$uye_id."',0,1,'".date("Y-m-d H:i:s")."')");  	*/
				mysql_query("INSERT INTO `uye_durumlari` (`id`, `uye_id`, `demo_olacagi_tarih`, `grup`, `teklif_limiti`, `hurda_teklif`, `yasak_sigorta`, `kalici_mesaj`, `kalici_sistem_mesaji`, `teklif_engelle`, `engelleme_nedeni`, `uyelik_iptal`, `uyelik_iptal_nedeni`, `mesaj_gorme_durumu`)
				VALUES (NULL, '".$uye_id."', '', '1', '0', '', '', '', '', '', '', '', '', '');"); 		
				mysql_query("insert into onayli_kullanicilar(user_id,kod,e_tarihi,durum) values ('".$uye_id."','".$onay_kodu."','".date('Y-m-d H:i:s')."',1)");
				$response=["message"=>"Kayıt Başarılı","status"=>200];
				}
			}else{
				$response=["message"=>"Hata","status"=>500];
			}
		}
		echo json_encode($response);
	   
	}



?>