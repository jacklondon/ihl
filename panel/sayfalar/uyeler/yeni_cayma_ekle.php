<?php 
	include('../../../ayar.php');
		if(re("action")=="borc_ekle"){
		$uye_id = re('uye_id');
		$arac_kod_plaka = re('arac_kod_plaka');
		$tutar = re('tutar');
		$arac_bilgisi = re('arac_bilgisi');
		$aciklama = re('aciklama');
		$bloke_tarihi = re('bloke_tarihi');


		$insert=mysql_query("
			INSERT 
				INTO
			cayma_bedelleri
				(uye_id,bloke_tarihi,tutar,arac_kod_plaka,arac_detay,aciklama,durum)
			VALUES
				('".$uye_id."',
				'".$bloke_tarihi."',
				'".$tutar."',
				'".$arac_kod_plaka."',				
				'".$arac_bilgisi."',
				'".$aciklama."',
				'6'
				)
		");
		if($insert){
			$response=["message"=>"İşlem başarılı","status"=>200];
		}else{
			$response=["message"=>"Hata oluştu","status"=>500];
		}
		echo json_encode($response);
	}
	if(re("action")=="yeni_ekle"){
		$uye_id = re('uye_id');
		$hesap_sahibi = re('hesap_sahibi');
		$tutar = re('tutar');
		$iban = re('iban');
		$aciklama = re('aciklama');
		$paranin_geldigi_tarih = re('paranin_geldigi_tarih');
		$date = date('Y-m-d H:i:s');
		/*	mysql_query("
						INSERT 
							INTO
						`cayma_bedelleri`	
							(`id`, `uye_id`, `tutar`, `hesap_sahibi`, `iban`, `uye_grubu`, `tarih`, `iade_tarihi`, `iade_tutari`, `aciklama`, `net`, `durum`, `sonuc`) 
						VALUES 
							(NULL, '".$uye_id."', '".$aktif_tutar."', '".$hesap_sahibi."', '".$aktif_iban."', '', '".$iade_edilecek_tarih."', '', '', '".$aktif_aciklama."', '".$aktif_tutar."', '1', '');
					");*/
		$insert=mysql_query("
			INSERT 
				INTO
			cayma_bedelleri
				(uye_id,paranin_geldigi_tarih,tutar,iban,hesap_sahibi,aciklama,durum)
			VALUES
				('".$uye_id."',
				'".$paranin_geldigi_tarih."',
				'".$tutar."',
				'".$iban."',				
				'".$hesap_sahibi."',
				'".$aciklama."',
				'1'
				)
		");
		if($insert){
			$response=["message"=>"İşlem başarılı","status"=>200];
		}else{
			$response=["message"=>"Hata oluştu","status"=>500];
		}
		echo json_encode($response);
	}
	if(re("action")=="form_guncelle"){
		$cayma_id=re("cayma_id");
		$durum=re("durum");
		$today = date('Y-m-d');
		$response=[];
		$sql=mysql_query("SELECT * FROM cayma_bedelleri WHERE id='".$cayma_id."'");
		if(mysql_num_rows($sql)!=0){
			if($durum!=""){
				$fetch = mysql_fetch_assoc($sql);
				if($durum==1){
					$output='
						<div class="row-fluid">
							<div class="span6">
								
								<label for="IDofInput">Paranın Geldiği Tarih</label> 
								<input type="date" disabled name="iade_edilecek_tarih" id="paranin_geldigi_tarih" value="'.$fetch["paranin_geldigi_tarih"].'" class="span12">
								<label for="IDofInput">IBAN</label>
								<input type="text" onchange="return isNumberKey(event); return boslukEngelle();" maxLength="24" minlength="24" name="iban" id="iban" value="'.$fetch["iban"].'" class="span12">

							</div>
							<div class="span6">
								<label for="IDofInput">Tutar</label>
								<input type="number" name="tutar" disabled value="'.$fetch["tutar"].'" id="tutar" class="span12">
								<label for="IDofInput">Hesap Sahibi</label>
								<input type="text" id="hesap_sahibi" value="'.$fetch["hesap_sahibi"].'" class="span12" style="text-transform: capitalize;" oninvalid="this.setCustomValidity(\'Lütfen ad ve soyad en az 2 kelime olacak şekilde giriniz.\')" pattern="\b\w+\b(?:.*?\b\w+\b){1}" name="hesap_sahibi" oninput="this.setCustomValidity(\'\')" >

							</div>
						</div>
						
					';
					// <div class="row-fluid">
					// 		<label for="IDofInput">Açıklama</label>
					// 		<textarea name="aciklama" id="aciklama" rows="2" class="span12">'.$fetch["aciklama"].'</textarea>
					// 	</div>
				}else if($durum==2){
					$output='
						<div class="row-fluid">
							<div class="span6">
								
								<label for="IDofInput">Paranın Geldiği Tarih</label> 
								<input type="date" disabled name="iade_edilecek_tarih" id="paranin_geldigi_tarih" value="'.$fetch["paranin_geldigi_tarih"].'" class="span12">
								<label for="IDofInput">IBAN</label>
								<input type="text" onchange="return isNumberKey(event); return boslukEngelle();" maxLength="24" minlength="24" name="iban" id="iban" value="'.$fetch["iban"].'" class="span12">

							</div>
							<div class="span6">
								<label for="IDofInput">Tutar</label>
								<input type="number" name="aktif_tutar" disabled value="'.$fetch["tutar"].'" id="aktif_tutar" class="span12">
								<label for="IDofInput">Hesap Sahibi</label>
								<input type="text" id="hesap_sahibi" value="'.$fetch["hesap_sahibi"].'" class="span12" style="text-transform: capitalize;" oninvalid="this.setCustomValidity(\'Lütfen ad ve soyad en az 2 kelime olacak şekilde giriniz.\')" pattern="\b\w+\b(?:.*?\b\w+\b){1}" name="hesap_sahibi" oninput="this.setCustomValidity(\'\')" >
								<label for="IDofInput">İade Tarihi</label> 
								<input type="date" name="iade_tarihi" id="iade_tarihi" value="'.$today.'" class="span12">
							</div>
						</div>
						
					';
					// <div class="row-fluid">
					// 		<label for="IDofInput">Açıklama</label>
					// 		<textarea name="aciklama" id="aciklama" rows="2" class="span12">'.$fetch["aciklama"].'</textarea>
					// 	</div>
				}else if($durum==3){
					$output='		
						<div class="row-fluid">
							<div class="span6">
								<label for="IDofInput">Paranın Geldiği Tarih</label> 
								<input type="date" disabled name="paranin_geldigi_tarih" id="paranin_geldigi_tarih" value="'.$fetch["paranin_geldigi_tarih"].'" class="span12">
								<label for="IDofInput">IBAN</label>
								<input type="text" onchange="return isNumberKey(event); return boslukEngelle();" maxLength="24" minlength="24" name="iban" id="iban" value="'.$fetch["iban"].'" class="span12">
							</div>
							<div class="span6">
								<label for="IDofInput">Tutar</label>
								<input type="number" name="tutar" disabled value="'.$fetch["tutar"].'" id="tutar" class="span12">
								<label for="IDofInput">Hesap Sahibi</label>
								<input type="text" id="hesap_sahibi" value="'.$fetch["hesap_sahibi"].'" class="span12" style="text-transform: capitalize;" oninvalid="this.setCustomValidity(\'Lütfen ad ve soyad en az 2 kelime olacak şekilde giriniz.\')" pattern="\b\w+\b(?:.*?\b\w+\b){1}" name="hesap_sahibi" oninput="this.setCustomValidity(\'\')" >
								<label for="IDofInput">İade Tarihi</label> 
								<input type="date" disabled name="iade_tarihi" id="iade_tarihi" value="'.$today.'" class="span12">
							</div>
						</div>						
					';
					// <div class="row-fluid" style="display:none;">
					// 		<label for="IDofInput">Açıklama</label>
					// 		<textarea name="aciklama" id="aciklama" rows="2" class="span12">'.$fetch["aciklama"].'</textarea>
					// 	</div>
				}else if($durum==4){
					$output='
						<div class="row-fluid">
							<div class="span6">
								<label for="IDofInput">Paranın Geldiği Tarih</label> 
								<input type="date" disabled name="paranin_geldigi_tarih" id="paranin_geldigi_tarih" value="'.$fetch["paranin_geldigi_tarih"].'" class="span12">
								<label for="IDofInput">Mahsup Tarihi</label> 
								<input type="date" name="mahsup_tarihi_eski" id="mahsup_tarihi_eski" value="'.$fetch["mahsup_tarihi"].'" class="span12" style="display: none;">
								<input type="date" name="mahsup_tarihi" id="mahsup_tarihi" value="'.$today.'" class="span12">
							</div>
							<div class="span6">
								<label for="IDofInput">Tutar</label>
								<input type="number" name="aktif_tutar" disabled value="'.$fetch["tutar"].'" id="aktif_tutar" class="span12">
								<label for="IDofInput">Konu Araç Kodu veya Plakası</label>
								<input type="text" id="arac_kod_plaka" onchange="aracGetir();" value="" class="span12">
							</div>
						</div>
						<div style="margin:15px" class="row-fluid">
							<label for="IDofInput">Bulunan Araç</label>
							<text id="arac_bilgisi"> </text>
						</div>
						
					';
					// <div class="row-fluid" style="display:none;">
					// 		<label for="IDofInput">Açıklama</label>
					// 		<textarea name="aciklama" id="aciklama" rows="2" class="span12">'.$fetch["aciklama"].'</textarea>
					// 	</div>
				}else if($durum==5){
					$output='

						<div class="row-fluid">
							<div class="span6">
								<label for="IDofInput">Paranın Geldiği Tarih</label> 
								<input type="date" disabled name="paranin_geldigi_tarih" id="paranin_geldigi_tarih" value="'.$fetch["paranin_geldigi_tarih"].'" class="span12">
								<label for="IDofInput">Bloke Tarihi</label> 
								<input type="date" name="bloke_tarihi_eski" id="bloke_tarihi_eski" value="'.$fetch["bloke_tarihi"].'" class="span12" style="display: none;">
								<input type="date" name="bloke_tarihi" id="bloke_tarihi" value="'.$today.'" class="span12">
							</div>
							<div class="span6">
								<label for="IDofInput">Tutar</label>
								<input type="number" name="aktif_tutar" disabled value="'.$fetch["tutar"].'" id="aktif_tutar" class="span12">
								<label for="IDofInput">Konu Araç Kodu veya Plakası</label>
								<input type="text" id="arac_kod_plaka" onchange="aracGetir();" value="" class="span12"  >
								
							</div>
						</div>
						<div style="margin:15px" class="row-fluid">
							<label for="IDofInput">Bulunan Araç</label>
							<text id="arac_bilgisi"> </text>
						</div>
						
					';
					// <div class="row-fluid" style="display:none;">
					// 		<label for="IDofInput">Açıklama</label>
					// 		<textarea name="aciklama" id="aciklama" rows="2" class="span12">'.$fetch["aciklama"].'</textarea>
					// 	</div>
				}else if($durum==6){
					$output='
						<div class="row-fluid">
							<div class="span6">
								<label for="IDofInput">Bloke Tarihi</label> 
								<input type="date" disabled name="bloke_tarihi" id="bloke_tarihi" value="'.$fetch["bloke_tarihi"].'" class="span12">
								<label for="IDofInput">Konu Araç Kodu veya Plakası</label>
								<input type="text" disabled id="arac_kod_plaka" value="'.$fetch["arac_kod_plaka"].'" class="span12"  >
							</div>
							<div class="span6">
								<label for="IDofInput">Tutar</label>
								<input type="number" name="aktif_tutar" disabled value="'.$fetch["tutar"].'" id="aktif_tutar" class="span12">
							</div>
						</div>
						<div style="margin:15px" class="row-fluid">
							<label for="IDofInput">Bulunan Araç</label>
							<text id="arac_bilgisi">'.$fetch["arac_detay"].'</text>
						</div>
						
					';
					// <div class="row-fluid">
					// 		<label for="IDofInput">Açıklama</label>
					// 		<textarea name="aciklama" id="aciklama" rows="2" class="span12">'.$fetch["aciklama"].'</textarea>
					// 	</div>
				}else if($durum==7){
					$output= '
						<div class="row-fluid">
							<div class="span6">
								<label for="IDofInput">Bloke Tarihi</label> 
								<input type="date" disabled name="bloke_tarihi" id="bloke_tarihi" value="'.$fetch["bloke_tarihi"].'" class="span12">
								<label for="IDofInput">Tahsil Tarihi</label> 
								<input type="date" name="tahsil_tarihi" id="tahsil_tarihi" value="'.$today.'" class="span12">
							</div>
							<div class="span6">
								<label for="IDofInput">Konu Araç Kodu veya Plakası</label>
								<input type="text" disabled id="arac_kod_plaka" value="'.$fetch["arac_kod_plaka"].'" class="span12"  >
								<label for="IDofInput">Tutar</label>
								<input type="number" name="aktif_tutar" disabled value="'.$fetch["tutar"].'" id="aktif_tutar" class="span12">
							</div>
						</div>
						<div style="margin:15px" class="row-fluid">
							<label for="IDofInput">Bulunan Araç</label>
							<text id="arac_bilgisi">'.$fetch["arac_detay"].'</text>
						</div>
						
					';
					// <div class="row-fluid">
					// 		<label for="IDofInput">Açıklama</label>
					// 		<textarea name="aciklama" id="aciklama" rows="2" class="span12">'.$fetch["aciklama"].'</textarea>
					// 	</div>
				}else{
					$output ='
						
					';
				}
				$response=["message"=>"Durum değişti","form"=>$output,"status"=>200];
			}else{
				$response=["message"=>"Durum seçimi yapılmalı","status"=>500];
				$output="";
			}
		}else{
			$response=["message"=>"Cayma bulunamadı","status"=>500];
		}
		echo json_encode($response);
		
	}
	if(re("action")=="arac_getir"){
		$arac_kod_plaka=re("arac_kod_plaka");
		$sql=mysql_query("SELECT * FROM ilanlar WHERE plaka='".$arac_kod_plaka."' or arac_kodu='".$arac_kod_plaka."'");
	
		if(mysql_num_rows($sql)!=0){
			$arac_detay="";
			$fetch=mysql_fetch_assoc($sql);
			$model_yili=$fetch["model_yili"];
			$marka_sql=mysql_query("SELECT * FROM markalar WHERE markaID='".$fetch["marka"]."'");
			$marka_fetch=mysql_fetch_assoc($marka_sql);
			$marka_adi=$marka_fetch["marka_adi"];
			$model=$fetch["model"];
			$tip=$fetch["tip"];
			$sehir=$fetch["sehir"];
			$arac_profili=$fetch["profil"];
			$arac_detay= $fetch["plaka"]." / ".$fetch["arac_kodu"]." / ".$model_yili." ".$marka_adi." ".$model." ".$tip." / ".$sehir." / ".$arac_profili;
			
			$response=["message"=>"Araç bulundu","arac_detay"=>$arac_detay,"status"=>200];
		}else{
			$response=["message"=>"Araç bulunamadı","status"=>500];
		}
		echo json_encode($response);
	}
		if(re("action")=="cayma_duzenle"){
		$cayma_id=re("cayma_id");
		$durum=re("durum");
		$uye_id=re("uye_id");
		$hesap_sahibi=re("hesap_sahibi");
		$tutar=re("tutar");
		$durum=re("durum");
		$iban=re("iban");
		$aciklama=re("aciklama");
		$paranin_geldigi_tarih=re("paranin_geldigi_tarih");
		$bloke_tarihi=re("bloke_tarihi");
		$mahsup_tarihi=re("mahsup_tarihi");
		$tahsil_tarihi=re("tahsil_tarihi");
		$iade_tarihi=re("iade_tarihi");
		$arac_kod_plaka=re("arac_kod_plaka");
		$arac_detay=re("arac_detay");
		// $aciklama=re("aciklama");
		$response=[];
		$sql=mysql_query("SELECT * FROM cayma_bedelleri WHERE id='".$cayma_id."' ");
		if(mysql_num_rows($sql)!=0){
			$oku = mysql_fetch_object($sql);
			if($durum!=""){
				if($durum==1){
					$update=mysql_query("UPDATE cayma_bedelleri SET iban='".$iban."', hesap_sahibi='".$hesap_sahibi."', aciklama='".$aciklama."', durum='".$durum."' WHERE id='".$cayma_id."'");
					$response=["message"=>"İşlem başarılı bir şekilde tamamlandı.","form"=>$output,"status"=>200];
				}else if($durum==2){
					//İade talebini kullanıcı kendi panelinden oluşturabiliyor
					$response=["message"=>"İade talebini sadece kullanıcılar oluşturabilir","form"=>$output,"status"=>700];
				}else if($durum==3){
					$update=mysql_query("UPDATE cayma_bedelleri SET iban='".$iban."',hesap_sahibi='".$hesap_sahibi."',iade_tarihi='".$iade_tarihi."',aciklama='".$aciklama."',durum='".$durum."' WHERE id='".$cayma_id."'");
					$response=["message"=>"İşlem başarılı bir şekilde tamamlandı.","form"=>$output,"status"=>200];
				}else if($durum==4){
					$update=mysql_query("UPDATE cayma_bedelleri SET mahsup_tarihi='".$mahsup_tarihi."',arac_kod_plaka='".$arac_kod_plaka."',arac_detay='".$arac_detay."',aciklama='".$aciklama."',durum='".$durum."' WHERE id='".$cayma_id."'");
					$response=["message"=>"İşlem başarılı bir şekilde tamamlandı.","form"=>$output,"status"=>200];
				}else if($durum==5){
					$update=mysql_query("UPDATE cayma_bedelleri SET bloke_tarihi='".$bloke_tarihi."',arac_kod_plaka='".$arac_kod_plaka."',arac_detay='".$arac_detay."',aciklama='".$aciklama."',durum='".$durum."' WHERE id='".$cayma_id."'");
					$response=["message"=>"İşlem başarılı bir şekilde tamamlandı.","form"=>$output,"status"=>200];
				}else if($durum==6){
					$update=mysql_query("UPDATE cayma_bedelleri SET aciklama='".$aciklama."',durum='".$durum."' WHERE id='".$cayma_id."'");
					$response=["message"=>"İşlem başarılı bir şekilde tamamlandı.","form"=>$output,"status"=>200];
				}else if($durum==7){
					$update=mysql_query("UPDATE cayma_bedelleri SET tahsil_tarihi='".$tahsil_tarihi."',aciklama='".$aciklama."',durum='".$durum."' WHERE id='".$cayma_id."'");
					$response=["message"=>"İşlem başarılı bir şekilde tamamlandı.","form"=>$output,"status"=>200];
				}else{
					$response=["message"=>"Geçersiz işlem.","form"=>$output,"status"=>600];
				}
				
			}else{
				if($oku->durum == 1){
					$update=mysql_query("UPDATE cayma_bedelleri SET iban='".$iban."', hesap_sahibi='".$hesap_sahibi."', aciklama='".$aciklama."' WHERE id='".$cayma_id."'");
					$response=["message"=>"İşlem başarılı bir şekilde tamamlandı.","form"=>$output,"status"=>200];
				}elseif($oku->durum == 2){
					$response=["message"=>"İade talebini sadece kullanıcılar oluşturabilir","form"=>$output,"status"=>701];
				}elseif($oku->durum == 3){
					$update=mysql_query("UPDATE cayma_bedelleri SET iban='".$iban."',hesap_sahibi='".$hesap_sahibi."',iade_tarihi='".$iade_tarihi."',aciklama='".$aciklama."' WHERE id='".$cayma_id."'");
					$response=["message"=>"İşlem başarılı bir şekilde tamamlandı.","form"=>$output,"status"=>200];
				}elseif($oku->durum == 4){
					$update=mysql_query("UPDATE cayma_bedelleri SET mahsup_tarihi='".$mahsup_tarihi."',arac_kod_plaka='".$arac_kod_plaka."',arac_detay='".$arac_detay."',aciklama='".$aciklama."' WHERE id='".$cayma_id."'");
					$response=["message"=>"İşlem başarılı bir şekilde tamamlandı.","form"=>$output,"status"=>200];
				}elseif($oku->durum == 5){
					$update=mysql_query("UPDATE cayma_bedelleri SET bloke_tarihi='".$bloke_tarihi."',arac_kod_plaka='".$arac_kod_plaka."',arac_detay='".$arac_detay."',aciklama='".$aciklama."' WHERE id='".$cayma_id."'");
					$response=["message"=>"İşlem başarılı bir şekilde tamamlandı.","form"=>$output,"status"=>200];
				}elseif($oku->durum == 6){
					$update=mysql_query("UPDATE cayma_bedelleri SET aciklama='".$aciklama."' WHERE id='".$cayma_id."'");
					$response=["message"=>"İşlem başarılı bir şekilde tamamlandı.","form"=>$output,"status"=>200];
				}elseif($oku->durum == 7){
					$update=mysql_query("UPDATE cayma_bedelleri SET tahsil_tarihi='".$tahsil_tarihi."',aciklama='".$aciklama."' WHERE id='".$cayma_id."'");
					$response=["message"=>"İşlem başarılı bir şekilde tamamlandı.","form"=>$output,"status"=>200];
				}else{
					$response=["message"=>"Geçersiz işlem.","form"=>$output,"status"=>600];
				}
				/*
				$response=["message"=>"Durum seçimi yapılmalı","status"=>500];
				$output="";
				*/
			}
		}else{
			$response=["message"=>"Cayma bulunamadı","status"=>500];
		}
		echo json_encode($response);
		
	}
	if(re("action")=="cayma_sil"){
		$cayma_id=re("cayma_id");
		$admin_id = $_SESSION['kid'];
		$admin_yetki_cek=mysql_query("Select * from kullanicilar where id='".$admin_id."' ");
		$admin_yetki_oku=mysql_fetch_assoc($admin_yetki_cek);
		$yetkiler=$admin_yetki_oku["yetki"];
		$yetki_parcala=explode("|",$yetkiler);
		if (count($yetki_parcala) !=13 ) {
			$response=["message"=>"Silme yetkiniz bulunmamaktadır.","status"=>500];
		}else{
			$delete=mysql_query("
				DELETE FROM
					cayma_bedelleri
				WHERE
					id='".$cayma_id."'
			");
			if($delete){
				$response=["message"=>"İşlem başarılı","status"=>200];
				
			}else{
				$repsonse=["message"=>"Hata oluştu","status"=>500];
			}
		}
		echo json_encode($response);
	}
	if(re("action")=="cayma_filtre"){
		$response=[];
		$durum=re("durum");
		$ay=re("ay");
		$yil=re("yil");;
		$listeleme=re("listeleme");
		$excel_action=re("excel_action");
		if($ay!=""){
			$excel_href="https://ihale.pertdunyasi.com/excel.php?q=".$excel_action."&ay=".$ay."&yil=".$yil;
			$tarih_text=$ay."/".$yil." tarihi listeleniyor";
			$where="MONTH(".$listeleme.") = '$ay' AND YEAR(".$listeleme.") = '$yil'";
		}else{
			$excel_href="https://ihale.pertdunyasi.com/excel.php?q=".$excel_action."&yil=".$yil;
			$tarih_text=$yil." yılı listeleniyor";
			$where="YEAR(".$listeleme.") = '$yil'";
		}
		$cayma=mysql_query("
			SELECT
				cayma_bedelleri.*,
				user.id as user_id,
				user.ad as user_ad,
				user.unvan as user_unvan,
				user.user_token as user_token,
				user.kurumsal_user_token as kurumsal_user_token,
				uye_grubu.grup_adi as user_paket
			FROM
				cayma_bedelleri
			INNER JOIN
				user
			ON
				user.id=cayma_bedelleri.uye_id
			INNER JOIN
				uye_grubu
			ON
				user.paket=uye_grubu.id
			WHERE
				durum=".$durum." AND
				".$where."
			ORDER BY
				".$listeleme." desc
		");
		
		$toplam_cayma=mysql_query("
			SELECT
				SUM(cayma_bedelleri.tutar) as toplam
			FROM
				cayma_bedelleri
			INNER JOIN
				user
			ON
				user.id=cayma_bedelleri.uye_id
			INNER JOIN
				uye_grubu
			ON
				user.paket=uye_grubu.id
			WHERE
				durum=".$durum." AND
				".$where."
		");
		$toplam_fetch=mysql_fetch_assoc($toplam_cayma);
		$toplam_aktif=$toplam_fetch["toplam"]; 
		
		while($cayma_fetch=mysql_fetch_array($cayma)){ 
			if($cayma_fetch["kurumsal_user_token"]!=""){
				$user_ad=$cayma_fetch["user_unvan"];
			}else{
				$user_ad=$cayma_fetch["user_ad"];
			}
			$ilan_sql=mysql_query("
				SELECT 
					*
				FROM
					ilanlar 
				WHERE	
					plaka='".$cayma_fetch["arac_kod_plaka"]."' or arac_kodu='".$cayma_fetch["arac_kod_plaka"]."'
			");
			if(mysql_num_rows($ilan_sql)!=0){
				$ilan_fetch=mysql_fetch_assoc($ilan_sql);
				$href="?modul=ilanlar&sayfa=ilan_ekle&id=".$ilan_fetch["id"];
			}else{
				$href="";
			}
			if($durum==3){
				$data.='		
					<tr>
						<td><a target="_blank" href="?modul=uyeler&sayfa=uye_duzenle&id='.$cayma_fetch["user_id"].'">'.$cayma_fetch["user_id"].' - '.$user_ad.'</a></td>
						<td>'.$cayma_fetch["user_paket"].'</td>
						<td>'.date("d-m-Y",strtotime($cayma_fetch["paranin_geldigi_tarih"])).'</td>
						<td>'.date("d-m-Y",strtotime($cayma_fetch["iade_tarihi"])).'</td>
						<td>'.date("d-m-Y",strtotime($cayma_fetch["hesap_sahibi"])).'</td>
						<td>'.date("d-m-Y",strtotime($cayma_fetch["iban"])).'</td>
						<td>'.$cayma_fetch["aciklama"].'</td>
						<td style="font-weight:bold">₺'.$cayma_fetch["tutar"].'</td> 
					</tr>
				';
			}else if($durum==4){
				$data.='		
					<tr>
						<td><a target="_blank" href="?modul=uyeler&sayfa=uye_duzenle&id='.$cayma_fetch["user_id"].'">'.$cayma_fetch["user_id"].' - '.$user_ad.'</a></td>
						<td>'.$cayma_fetch["user_paket"].'</td>
						<td>'.date("d-m-Y",strtotime($cayma_fetch["paranin_geldigi_tarih"])).'</td>
						<td>'.date("d-m-Y",strtotime($cayma_fetch["mahsup_tarihi"])).'</td>
						<td><a href="'.$href.'">#'.$cayma_fetch["arac_kod_plaka"].' / '.$cayma_fetch["arac_detay"].'</td>
						<td>'.$cayma_fetch["aciklama"].'</td>
						<td style="font-weight:bold">₺'.$cayma_fetch["tutar"].'</td> 
					</tr>
				';
			}else{
				$data.='		
					<tr>
						<td><a target="_blank" href="?modul=uyeler&sayfa=uye_duzenle&id='.$cayma_fetch["user_id"].'">'.$cayma_fetch["user_id"].' - '.$user_ad.'</a></td>
						<td>'.$cayma_fetch["user_paket"].'</td>
						<td>'.date("d-m-Y",strtotime($cayma_fetch["paranin_geldigi_tarih"])).'</td>
						<td>'.date("d-m-Y",strtotime($cayma_fetch["bloke_tarihi"])).'</td>
						<td><a href="'.$href.'">#'.$cayma_fetch["arac_kod_plaka"].' / '.$cayma_fetch["arac_detay"].'</td>
						<td>'.$cayma_fetch["aciklama"].'</td>
						<td style="font-weight:bold">₺'.$cayma_fetch["tutar"].'</td> 
					</tr>
				';
			}
			
		}
		$response=["message"=>"Datalar geldi","data"=>$data,"toplam"=>money($toplam_aktif)."₺","tarih_text"=>$tarih_text,"status"=>200];
		echo json_encode($response);
	}



?>
