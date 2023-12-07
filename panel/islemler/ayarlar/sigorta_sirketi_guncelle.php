<?php 
    $gelen_id=re("id");    
    if(re('sigorta_guncellemeyi')=="Kaydet"){ 
		$gold_ses="";
		$sigorta_adi = re('sirket_adi');
		$hizli_teklif_1 = re('hizli_teklif1');
		$hizli_teklif_2 = re('hizli_teklif2');
		$hizli_teklif_3 = re('hizli_teklif3');
		$hizli_teklif_4 = re('hizli_teklif4');
		$sure_uzatma = re('sure_uzatma');
		$dakikanin_altinda = re('dakikanin_altinda');
		$dakika_uzar = re('dakika_uzar');
		$saniyenin_altinda = re('saniyenin_altinda');
		$saniye_uzar = re('saniye_uzar');
		$uyari_notu = re('uyari_notu');
		$sigorta_aciklamasi = re('sigorta_aciklamasi');
		$park_ucreti = re('park_ucreti');
		$cekici_ucreti = re('cekici_ucreti');
		$sigorta_dosya_masrafi = re('sigorta_dosya_masrafi');
		$minumum_artis = re('minumum_artis');
		$teklif_onay_mekanizmasi = re('teklif_onay');
		$teklif_iletme_mesaji = re('onaylama_mesaji');
		$sigorta_bitis_saati = re('sigorta_dakika');
		$bu_sure_altinda_teklif = re('sure_altinda_teklif_verilirse');
		$alacagi_mesaj = re('bu_mesaji_alsin');
		$pd_hizmeti = re('pd_hizmeti');
		$gold_uyari_dakika = re('altin_dakika');
		$ihale_tipi = re('ihale_tipi');
		$vitrin = re('vitrin');
		$vitrin_adet=re("vitrin_sayi");
		$tarih = date('H:i:s');
		if($_FILES["file"]["name"]!="" && $_FILES["teklif_uyari_sesi"]["name"]!=""  ){
			$errors= array(); 
			$allowed = array("audio/mpeg",'audio/mpg', 'audio/mpeg3', 'audio/mp3','audio/wav');

			$dosya_adi =$_FILES['file']['name']; 		// uzantiya beraber dosya adi 
			$dosya_boyutu =$_FILES['file']['size'];    		// byte cinsinden dosya boyutu 
			$dosya_gecici =$_FILES['file']['tmp_name'];		//gecici dosya adresi 
			$file_type =$_FILES['file']['type'];	
			$yenisim=md5(microtime()).$dosya_adi; 					//karmasik yeni isim.pdf 
			if($dosya_boyutu > 20971520){ 
				$errors[]='Maksimum 20 Mb lık dosya yuklenebilir.'; 
			}
			if(!in_array($file_type, $allowed)) {
				$errors[]='mp3 ve wav uzantılı dosyalar yüklenebilir.'; 
				
			}
			
			$dosya_adi2 =$_FILES['teklif_uyari_sesi']['name']; 		// uzantiya beraber dosya adi 
			$dosya_boyutu2 =$_FILES['teklif_uyari_sesi']['size'];    		// byte cinsinden dosya boyutu 
			$dosya_gecici2 =$_FILES['teklif_uyari_sesi']['tmp_name'];		//gecici dosya adresi 
			$file_type2 =$_FILES['teklif_uyari_sesi']['type'];	
			$yenisim2=md5(microtime()).$dosya_adi2; 					
			if($dosya_boyutu2 > 20971520){ 
				$errors[]='Maksimum 20 Mb lık dosya yuklenebilir.'; 
			}
			
			if(!in_array($file_type2, $allowed)) {
				$errors[]='mp3 ve wav uzantılı dosyalar yüklenebilir.'; 
			}
			
			$klasor="https://ihale.pertdunyasi.com/panel/images/sounds/"; // yuklenecek dosyalar icin yeni klasor 
			$klasor2="images/sounds/"; // yuklenecek dosyalar icin yeni klasor 
			if(empty($errors)==false){  //eger hata yoksa 
				$mesaj='';
				for($b=0;$b<count($errors);$b++){
					$mesaj.=$errors[$b].",";
				}
				echo "<script>alert('".$mesaj."')</script>"; 
				
			}else{
				$test=move_uploaded_file($dosya_gecici,"$klasor2/".$yenisim);//yoksa yeni ismiyle kaydet 
				$test2=move_uploaded_file($dosya_gecici2,"$klasor2/".$yenisim2);//yoksa yeni ismiyle kaydet 
				$gold_ses=$klasor.$yenisim;
				$teklif_uyari_sesi=$klasor.$yenisim2;
				mysql_query("
					UPDATE `sigorta_ozellikleri` 
					SET `sigorta_adi` = '".$sigorta_adi."',
						`hizli_teklif_1` = '".$hizli_teklif_1."', `hizli_teklif_2` = '".$hizli_teklif_2."', 
						`hizli_teklif_3` = '".$hizli_teklif_3."', `hizli_teklif_4` = '".$hizli_teklif_4."', 
						`sure_uzatma` = '".$sure_uzatma."', `dakikanin_altinda` = '".$dakikanin_altinda."', 
						`dakika_uzar` = '".$dakika_uzar."',saniyenin_altinda` = '".$saniyenin_altinda."', 
						`saniye_uzar` = '".$saniye_uzar."', `uyari_notu` = '".$uyari_notu."', `ihale_tipi` = '".$ihale_tipi."',  
						`sigorta_aciklamasi` = '".$sigorta_aciklamasi."', `park_ucreti` = '".$park_ucreti."', `sigorta_cekici_ucreti` = '".$cekici_ucreti."', 
						`sigorta_dosya_masrafi` = '".$sigorta_dosya_masrafi."', `minumum_artis` = '".$minumum_artis."', 
						`sigorta_bitis_saati` = '".$sigorta_bitis_saati."', `bu_sure_altinda_teklif` = '".$bu_sure_altinda_teklif."', 
						`alacagi_mesaj` = '".$alacagi_mesaj."', `teklif_onay_mekanizmasi` = '".$teklif_onay_mekanizmasi."', 
						`teklif_iletme_mesaji` = '".$teklif_iletme_mesaji."', `pd_hizmeti` = '".$pd_hizmeti."', `vitrin` = '".$vitrin."',`vitrin_adet` = '".$vitrin_adet."', 
						`gold_uyari_sesi`='".$gold_ses."', `gold_uyari_dakika` = '".$gold_uyari_dakika."',`teklif_uyari_sesi` = '".$teklif_uyari_sesi."'
					WHERE 
						`sigorta_ozellikleri`.`id` = '".$gelen_id."';");
					if($vitrin=="on" && $vitrin_adet>0){
						$ilan_get=mysql_query("select * from ilanlar where durum=1 and vitrin!='on' and sigorta='".$sigorta_id."'");//Vitrinde olabilecek potansiyel ilanlar
						$ilan_ssay=mysql_num_rows($ilan_get);
						if($vitrin_adet>$ilan_ssay){
							$vitrin_adet=$ilan_ssay;
						}
						while($durum=true){
							$guncelle=mysql_query("
								update 
									ilanlar as i
								inner join
									(Select
										* 
									from 
										ilanlar
									where
										durum = 1 and 
										vitrin !='on' and
										sigorta ='".$gelen_id."'
									order by
										rand() 
									limit 1
									) as i2
								on 
									i.id = i2.id
								set
									i.vitrin = 'on';"
							);
							
							$ilan_sorg=mysql_query("select * from ilanlar where durum=1 and vitrin='on' and sigorta='".$sigorta_id."' ");
							$ilan_say=mysql_num_rows($ilan_sorg);
							if($ilan_say==$vitrin_adet){
								break;
							}
						}	
					}


					$grup_bul = mysql_query("SELECT * FROM uye_grubu");
					$grup_sayi = mysql_num_rows($grup_bul);

					$arttir=0;
					while($grup_oku=mysql_fetch_array($grup_bul)){
						if($_POST["detay_".$arttir] == null){
							$_POST["detay_".$arttir]=0;
						}
						$grup_id = $grup_oku['id'];
						mysql_query("UPDATE sigortalar SET secilen_yetki_id = '".$_POST["yetki_durum".$arttir]."',
						detay_gorur = '".$_POST["detay_".$arttir]."' WHERE sigorta_id = '".$gelen_id."' AND paket_id = '".$grup_oku['id']."'");
						$arttir++;
					}
				header("Location:?modul=ayarlar&sayfa=sigorta_sirketi_ayarlari&id=$gelen_id");
		   
			}
			
		}else if($_FILES["file"]["name"]=="" && $_FILES["teklif_uyari_sesi"]["name"]!=""  ){
			$errors= array(); 
			$allowed = array("audio/mpeg",'audio/mpg', 'audio/mpeg3', 'audio/mp3','audio/wav');
			
			$dosya_adi2 =$_FILES['teklif_uyari_sesi']['name']; 		// uzantiya beraber dosya adi 
			$dosya_boyutu2 =$_FILES['teklif_uyari_sesi']['size'];    		// byte cinsinden dosya boyutu 
			$dosya_gecici2 =$_FILES['teklif_uyari_sesi']['tmp_name'];		//gecici dosya adresi 
			$file_type2 =$_FILES['teklif_uyari_sesi']['type'];	
			$yenisim2=md5(microtime()).$dosya_adi2; 					
			if($dosya_boyutu2 > 20971520){ 
				$errors[]='Maksimum 20 Mb lık dosya yuklenebilir.'; 
			}
			
			if(!in_array($file_type2, $allowed)) {
				$errors[]='mp3 ve wav uzantılı dosyalar yüklenebilir.'; 
			}
			
			$klasor="https://ihale.pertdunyasi.com/panel/images/sounds/"; // yuklenecek dosyalar icin yeni klasor 
			$klasor2="images/sounds/"; // yuklenecek dosyalar icin yeni klasor 
			if(empty($errors)==false){  //eger hata yoksa 
				$mesaj='';
				for($b=0;$b<count($errors);$b++){
					$mesaj.=$errors[$b].",";
				}
				echo "<script>alert('".$mesaj."')</script>"; 
				
			}else{
				$test2=move_uploaded_file($dosya_gecici2,"$klasor2/".$yenisim2);//yoksa yeni ismiyle kaydet 
				$teklif_uyari_sesi=$klasor.$yenisim2;
				mysql_query("
					UPDATE `sigorta_ozellikleri` 
					SET `sigorta_adi` = '".$sigorta_adi."',
						`hizli_teklif_1` = '".$hizli_teklif_1."', `hizli_teklif_2` = '".$hizli_teklif_2."', 
						`hizli_teklif_3` = '".$hizli_teklif_3."', `hizli_teklif_4` = '".$hizli_teklif_4."', 
						`sure_uzatma` = '".$sure_uzatma."', `dakikanin_altinda` = '".$dakikanin_altinda."', 
						`dakika_uzar` = '".$dakika_uzar."',`saniyenin_altinda` = '".$saniyenin_altinda."', 
						`saniye_uzar` = '".$saniye_uzar."', `uyari_notu` = '".$uyari_notu."', `ihale_tipi` = '".$ihale_tipi."',  
						`sigorta_aciklamasi` = '".$sigorta_aciklamasi."', `park_ucreti` = '".$park_ucreti."', `sigorta_cekici_ucreti` = '".$cekici_ucreti."', 
						`sigorta_dosya_masrafi` = '".$sigorta_dosya_masrafi."', `minumum_artis` = '".$minumum_artis."', 
						`sigorta_bitis_saati` = '".$sigorta_bitis_saati."', `bu_sure_altinda_teklif` = '".$bu_sure_altinda_teklif."', 
						`alacagi_mesaj` = '".$alacagi_mesaj."', `teklif_onay_mekanizmasi` = '".$teklif_onay_mekanizmasi."', 
						`teklif_iletme_mesaji` = '".$teklif_iletme_mesaji."', `pd_hizmeti` = '".$pd_hizmeti."', `vitrin` = '".$vitrin."',`vitrin_adet` = '".$vitrin_adet."', 
						 `gold_uyari_dakika` = '".$gold_uyari_dakika."',`teklif_uyari_sesi` = '".$teklif_uyari_sesi."'
					WHERE 
						`sigorta_ozellikleri`.`id` = '".$gelen_id."';");
					if($vitrin=="on" && $vitrin_adet>0){
						$ilan_get=mysql_query("select * from ilanlar where durum=1 and vitrin!='on' and sigorta='".$sigorta_id."'");//Vitrinde olabilecek potansiyel ilanlar
						$ilan_ssay=mysql_num_rows($ilan_get);
						if($vitrin_adet>$ilan_ssay){
							$vitrin_adet=$ilan_ssay;
						}
						while($durum=true){
							$guncelle=mysql_query("
								update 
									ilanlar as i
								inner join
									(Select
										* 
									from 
										ilanlar
									where
										durum = 1 and 
										vitrin !='on' and
										sigorta ='".$gelen_id."'
									order by
										rand() 
									limit 1
									) as i2
								on 
									i.id = i2.id
								set
									i.vitrin = 'on';"
							);
							
							$ilan_sorg=mysql_query("select * from ilanlar where durum=1 and vitrin='on' and sigorta='".$sigorta_id."' ");
							$ilan_say=mysql_num_rows($ilan_sorg);
							if($ilan_say==$vitrin_adet){
								break;
							}
						}	
					}


					$grup_bul = mysql_query("SELECT * FROM uye_grubu");
					$grup_sayi = mysql_num_rows($grup_bul);

					$arttir=0;
					while($grup_oku=mysql_fetch_array($grup_bul)){
						if($_POST["detay_".$arttir] == null){
							$_POST["detay_".$arttir]=0;
						}
						$grup_id = $grup_oku['id'];
						mysql_query("UPDATE sigortalar SET secilen_yetki_id = '".$_POST["yetki_durum".$arttir]."',
						detay_gorur = '".$_POST["detay_".$arttir]."' WHERE sigorta_id = '".$gelen_id."' AND paket_id = '".$grup_oku['id']."'");
						$arttir++;
					}
				header("Location:?modul=ayarlar&sayfa=sigorta_sirketi_ayarlari&id=$gelen_id");
		   
			}
			
		}	else if($_FILES["file"]["name"]!="" && $_FILES["teklif_uyari_sesi"]["name"]==""  ){
			$errors= array(); 
			$allowed = array("audio/mpeg",'audio/mpg', 'audio/mpeg3', 'audio/mp3','audio/wav');

			$dosya_adi =$_FILES['file']['name']; 		// uzantiya beraber dosya adi 
			$dosya_boyutu =$_FILES['file']['size'];    		// byte cinsinden dosya boyutu 
			$dosya_gecici =$_FILES['file']['tmp_name'];		//gecici dosya adresi 
			$file_type =$_FILES['file']['type'];	
			$yenisim=md5(microtime()).$dosya_adi; 					//karmasik yeni isim.pdf 
			if($dosya_boyutu > 20971520){ 
				$errors[]='Maksimum 20 Mb lık dosya yuklenebilir.'; 
			}
			if(!in_array($file_type, $allowed)) {
				$errors[]='mp3 ve wav uzantılı dosyalar yüklenebilir.'; 
				
			}
			
			
			$klasor="https://ihale.pertdunyasi.com/panel/images/sounds/"; // yuklenecek dosyalar icin yeni klasor 
			$klasor2="images/sounds/"; // yuklenecek dosyalar icin yeni klasor 
			if(empty($errors)==false){  //eger hata yoksa 
				$mesaj='';
				for($b=0;$b<count($errors);$b++){
					$mesaj.=$errors[$b].",";
				}
				echo "<script>alert('".$mesaj."')</script>"; 
				
			}else{
				$test=move_uploaded_file($dosya_gecici,"$klasor2/".$yenisim);//yoksa yeni ismiyle kaydet 
				$gold_ses=$klasor.$yenisim;
				mysql_query("
					UPDATE `sigorta_ozellikleri` 
					SET `sigorta_adi` = '".$sigorta_adi."',
						`hizli_teklif_1` = '".$hizli_teklif_1."', `hizli_teklif_2` = '".$hizli_teklif_2."', 
						`hizli_teklif_3` = '".$hizli_teklif_3."', `hizli_teklif_4` = '".$hizli_teklif_4."', 
						`sure_uzatma` = '".$sure_uzatma."', `dakikanin_altinda` = '".$dakikanin_altinda."', 
						`dakika_uzar` = '".$dakika_uzar."',`saniyenin_altinda` = '".$saniyenin_altinda."', 
						`saniye_uzar` = '".$saniye_uzar."', `uyari_notu` = '".$uyari_notu."', `ihale_tipi` = '".$ihale_tipi."',  
						`sigorta_aciklamasi` = '".$sigorta_aciklamasi."', `park_ucreti` = '".$park_ucreti."', `sigorta_cekici_ucreti` = '".$cekici_ucreti."', 
						`sigorta_dosya_masrafi` = '".$sigorta_dosya_masrafi."', `minumum_artis` = '".$minumum_artis."', 
						`sigorta_bitis_saati` = '".$sigorta_bitis_saati."', `bu_sure_altinda_teklif` = '".$bu_sure_altinda_teklif."', 
						`alacagi_mesaj` = '".$alacagi_mesaj."', `teklif_onay_mekanizmasi` = '".$teklif_onay_mekanizmasi."', 
						`teklif_iletme_mesaji` = '".$teklif_iletme_mesaji."', `pd_hizmeti` = '".$pd_hizmeti."', `vitrin` = '".$vitrin."',`vitrin_adet` = '".$vitrin_adet."', 
						`gold_uyari_sesi`='".$gold_ses."', `gold_uyari_dakika` = '".$gold_uyari_dakika."'
					WHERE 
						`sigorta_ozellikleri`.`id` = '".$gelen_id."';");
					if($vitrin=="on" && $vitrin_adet>0){
						$ilan_get=mysql_query("select * from ilanlar where durum=1 and vitrin!='on' and sigorta='".$sigorta_id."'");//Vitrinde olabilecek potansiyel ilanlar
						$ilan_ssay=mysql_num_rows($ilan_get);
						if($vitrin_adet>$ilan_ssay){
							$vitrin_adet=$ilan_ssay;
						}
						while($durum=true){
							$guncelle=mysql_query("
								update 
									ilanlar as i
								inner join
									(Select
										* 
									from 
										ilanlar
									where
										durum = 1 and 
										vitrin !='on' and
										sigorta ='".$gelen_id."'
									order by
										rand() 
									limit 1
									) as i2
								on 
									i.id = i2.id
								set
									i.vitrin = 'on';"
							);
							
							$ilan_sorg=mysql_query("select * from ilanlar where durum=1 and vitrin='on' and sigorta='".$sigorta_id."' ");
							$ilan_say=mysql_num_rows($ilan_sorg);
							if($ilan_say==$vitrin_adet){
								break;
							}
						}	
					}


					$grup_bul = mysql_query("SELECT * FROM uye_grubu");
					$grup_sayi = mysql_num_rows($grup_bul);

					$arttir=0;
					while($grup_oku=mysql_fetch_array($grup_bul)){
						if($_POST["detay_".$arttir] == null){
							$_POST["detay_".$arttir]=0;
						}
						$grup_id = $grup_oku['id'];
						mysql_query("UPDATE sigortalar SET secilen_yetki_id = '".$_POST["yetki_durum".$arttir]."',
						detay_gorur = '".$_POST["detay_".$arttir]."' WHERE sigorta_id = '".$gelen_id."' AND paket_id = '".$grup_oku['id']."'");
						$arttir++;
					}
				header("Location:?modul=ayarlar&sayfa=sigorta_sirketi_ayarlari&id=$gelen_id");
		   
			}
			
		}else{
			$sigort_cek=mysql_query("select * from sigorta_ozellikleri where id='".re("id")."'");
			$sigort_oku=mysql_fetch_array($sigort_cek);
			mysql_query("
			UPDATE `sigorta_ozellikleri` 
			SET `sigorta_adi` = '".$sigorta_adi."',
				`hizli_teklif_1` = '".$hizli_teklif_1."', `hizli_teklif_2` = '".$hizli_teklif_2."', 
				`hizli_teklif_3` = '".$hizli_teklif_3."', `hizli_teklif_4` = '".$hizli_teklif_4."', 
				`sure_uzatma` = '".$sure_uzatma."', `dakikanin_altinda` = '".$dakikanin_altinda."', 
				`dakika_uzar` = '".$dakika_uzar."',`saniyenin_altinda` = '".$saniyenin_altinda."', 
				`saniye_uzar` = '".$saniye_uzar."', `uyari_notu` = '".$uyari_notu."', `ihale_tipi` = '".$ihale_tipi."',  
				`sigorta_aciklamasi` = '".$sigorta_aciklamasi."', `park_ucreti` = '".$park_ucreti."', `sigorta_cekici_ucreti` = '".$cekici_ucreti."', 
				`sigorta_dosya_masrafi` = '".$sigorta_dosya_masrafi."', `minumum_artis` = '".$minumum_artis."', 
				`sigorta_bitis_saati` = '".$sigorta_bitis_saati."', `bu_sure_altinda_teklif` = '".$bu_sure_altinda_teklif."', 
				`alacagi_mesaj` = '".$alacagi_mesaj."', `teklif_onay_mekanizmasi` = '".$teklif_onay_mekanizmasi."', 
				`teklif_iletme_mesaji` = '".$teklif_iletme_mesaji."', `pd_hizmeti` = '".$pd_hizmeti."', `vitrin` = '".$vitrin."',`vitrin_adet` = '".$vitrin_adet."', 
				`gold_uyari_dakika` = '".$gold_uyari_dakika."'
			WHERE 
				`sigorta_ozellikleri`.`id` = '".$gelen_id."';");
			if($vitrin=="on" && $vitrin_adet>0){
				$ilan_get=mysql_query("select * from ilanlar where durum=1 and vitrin!='on' and sigorta='".$sigorta_id."'");//Vitrinde olabilecek potansiyel ilanlar
				$ilan_ssay=mysql_num_rows($ilan_get);
				if($vitrin_adet>$ilan_ssay){
					$vitrin_adet=$ilan_ssay;
				}
				while($durum=true){
					$guncelle=mysql_query("
						update 
							ilanlar as i
						inner join
							(Select
								* 
							from 
								ilanlar
							where
								durum = 1 and 
								vitrin !='on' and
								sigorta ='".$gelen_id."'
							order by
								rand() 
							limit 1
							) as i2
						on 
							i.id = i2.id
						set
							i.vitrin = 'on';"
					);
					
					$ilan_sorg=mysql_query("select * from ilanlar where durum=1 and vitrin='on' and sigorta='".$sigorta_id."' ");
					$ilan_say=mysql_num_rows($ilan_sorg);
					if($ilan_say==$vitrin_adet){
						break;
					}
				}	
			}


			$grup_bul = mysql_query("SELECT * FROM uye_grubu");
			$grup_sayi = mysql_num_rows($grup_bul);

			$arttir=0;
			while($grup_oku=mysql_fetch_array($grup_bul)){
				if($_POST["detay_".$arttir] == null){
					$_POST["detay_".$arttir]=0;
				}
				$grup_id = $grup_oku['id'];
				mysql_query("UPDATE sigortalar SET secilen_yetki_id = '".$_POST["yetki_durum".$arttir]."',
				detay_gorur = '".$_POST["detay_".$arttir]."' WHERE sigorta_id = '".$gelen_id."' AND paket_id = '".$grup_oku['id']."'");
				$arttir++;
			}
			header("Location:?modul=ayarlar&sayfa=sigorta_sirketi_ayarlari&id=$gelen_id");
		  
		}
		
	}

?>




