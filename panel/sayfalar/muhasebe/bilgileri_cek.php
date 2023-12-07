<?php 
include('../../../ayar.php');
if(re('action')=="plakaya_gore"){
	if(re('plaka')){
		$plaka = re('plaka');
		$response=[];
		$arac_cek = mysql_query("SELECT * FROM ilanlar WHERE plaka = '".$plaka."'");
		if(mysql_num_rows($arac_cek)!=0){
			while($arac_oku = mysql_fetch_array($arac_cek)){
				$max_teklif = $arac_oku['son_teklif'];
				if($arac_oku['pd_hizmet']==0 || $arac_oku['pd_hizmet']=""){
					/*$teklif_cek = mysql_query("select * from teklifler where ilan_id = '".$arac_oku['id']."' group by uye_id order by teklif_zamani desc ");
					while($teklif_oku = mysql_fetch_array($teklif_cek)){
						$pd_cek = mysql_query("select * from teklifler where ilan_id = '".$arac_oku['id']."' and uye_id = '".$teklif_oku['uye_id']."' order by teklif_zamani desc limit 1");
						$pd_oku = mysql_fetch_array($pd_cek);
						if($max_teklif == $pd_oku['teklif']){
							$pd_hizmet = $pd_oku['hizmet_bedeli'];						
						}
					}*/
					$kazanilan_cek=mysql_query("select * from kazanilan_ilanlar where ilan_id='".$arac_oku["id"]."'");
					$kazanilan_oku=mysql_fetch_array($kazanilan_cek);
					$pd_hizmet=$kazanilan_oku["pd_hizmet"];
				}else{
					$pd_hizmet = $arac_oku['pd_hizmet'];
				}
				
				$arac_marka = mysql_query("SELECT * FROM marka where markaID = '".$arac_oku['marka']."'");
				$arac_kodu = $arac_oku['arac_kodu'];
				$sehir = $arac_oku['sehir'];
				$sigorta = $arac_oku['sigorta']; 
				$marka_yaz = mysql_fetch_assoc($arac_marka);
				$marka_model = $marka_yaz['marka_adi']." ".$arac_oku['model'];	
				$model_yili = $arac_oku['model_yili'];
				$tip = $arac_oku['tip'];
				$sigorta_bul = mysql_query("SELECT * FROM sigorta_ozellikleri WHERE id = '".$sigorta."'");
				$sigortayi_oku = mysql_Fetch_assoc($sigorta_bul);
				$sigortanin_adi = $sigortayi_oku['sigorta_adi'];
				$kazanan_cek = mysql_query("SELECT * FROM kazanilan_ilanlar WHERE ilan_id = '".$arac_oku['id']."' AND durum = 3 ");
				while($kazanan_oku = mysql_fetch_array($kazanan_cek)){
					$kazanan_id = $kazanan_oku['uye_id'];
					$satis_tarihi = $kazanan_oku['zaman'];
					$odeme_tarihi = date("Y-m-d",strtotime($kazanan_oku['son_odeme_tarihi']));
					//$maliyet = $kazanan_oku['kazanilan_tutar'];
					$uyeyi_bul = mysql_query("SELECT * FROM user WHERE id = '".$kazanan_id."' LIMIT 1");
					$uyeyi_yaz = mysql_fetch_assoc($uyeyi_bul);
					$uye_adi = $uyeyi_yaz['ad'];
					
				}
				$kazanan_teklif_cek = mysql_query("select * from kazanilan_ilanlar where ilan_id = '".$arac_oku["id"]."'");
				$kazanan_teklif_oku = mysql_fetch_object($kazanan_teklif_cek);
				$kazanilan_teklif = $kazanan_teklif_oku->kazanilan_teklif;
				$kazanan_uye_id = $kazanan_teklif_oku->uye_id;
			}
			$response=["kod"=>$arac_kodu,
				"marka_model"=>$marka_model,
				"odeme_tarihi"=>$odeme_tarihi,
				"sigorta"=>$sigortanin_adi,
				"satis_kimin_adina"=>$uye_adi,
				"tarih"=>date("Y-m-d"),
				"maliyet"=>$maliyet,
				"pd_hizmet"=>$pd_hizmet,
				"status"=>200,
				"kazanilan_teklif" => $kazanilan_teklif,
				"kazanan_uye_id" => $kazanan_uye_id
			];
		}else{
			$response=["message"=>"Plakaya ait araç bulunamadı","status"=>500];
		}
		echo json_encode($response);
	}
}
if(re('action')=="arac_koda_gore"){
	if(re('kod')){
		$kod = re('kod');
		$response=[];
		$arac_cek = mysql_query("SELECT * FROM ilanlar WHERE arac_kodu = '".$kod."'");
		if(mysql_num_rows($arac_cek)!=0){
			while($arac_oku = mysql_fetch_array($arac_cek)){
				$max_teklif = $arac_oku['son_teklif'];
				if($arac_oku['pd_hizmet']==0 || $arac_oku['pd_hizmet']=""){
					/*$teklif_cek = mysql_query("select * from teklifler where ilan_id = '".$arac_oku['id']."' group by uye_id order by teklif_zamani desc ");
					while($teklif_oku = mysql_fetch_array($teklif_cek)){
						$pd_cek = mysql_query("select * from teklifler where ilan_id = '".$arac_oku['id']."' and uye_id = '".$teklif_oku['uye_id']."' order by teklif_zamani desc limit 1");
						$pd_oku = mysql_fetch_array($pd_cek);
						if($max_teklif == $pd_oku['teklif']){
							$pd_hizmet = $pd_oku['hizmet_bedeli'];						
						}
					}*/
					$kazanilan_cek=mysql_query("select * from kazanilan_ilanlar where ilan_id='".$arac_oku["id"]."'");
					$kazanilan_oku=mysql_fetch_array($kazanilan_cek);
					$pd_hizmet=$kazanilan_oku["pd_hizmet"];
				}else{
					$pd_hizmet = $arac_oku['pd_hizmet'];
				}
				
				$arac_marka = mysql_query("SELECT * FROM marka where markaID = '".$arac_oku['marka']."'");
				$plaka = $arac_oku['plaka'];
				$sehir = $arac_oku['sehir'];
				$sigorta = $arac_oku['sigorta']; 
				$marka_yaz = mysql_fetch_assoc($arac_marka);
				$marka_model = $marka_yaz['marka_adi']." ".$arac_oku['model'];	
				$model_yili = $arac_oku['model_yili'];
				$tip = $arac_oku['tip'];
				$sigorta_bul = mysql_query("SELECT * FROM sigorta_ozellikleri WHERE id = '".$sigorta."'");
				$sigortayi_oku = mysql_Fetch_assoc($sigorta_bul);
				$sigortanin_adi = $sigortayi_oku['sigorta_adi'];
				$kazanan_cek = mysql_query("SELECT * FROM kazanilan_ilanlar WHERE ilan_id = '".$arac_oku['id']."' AND durum = 3 ");
				while($kazanan_oku = mysql_fetch_array($kazanan_cek)){
					$kazanan_id = $kazanan_oku['uye_id'];
					$satis_tarihi = $kazanan_oku['zaman'];
					$odeme_tarihi = date("Y-m-d",strtotime($kazanan_oku['son_odeme_tarihi']));
					//$maliyet = $kazanan_oku['kazanilan_tutar'];
					$uyeyi_bul = mysql_query("SELECT * FROM user WHERE id = '".$kazanan_id."' LIMIT 1");
					$uyeyi_yaz = mysql_fetch_assoc($uyeyi_bul);
					$uye_adi = $uyeyi_yaz['ad'];
				}
				$kazanan_teklif_cek = mysql_query("select * from kazanilan_ilanlar where ilan_id = '".$arac_oku["id"]."'");
				$kazanan_teklif_oku = mysql_fetch_object($kazanan_teklif_cek);
				$kazanilan_teklif = $kazanan_teklif_oku->kazanilan_teklif;
				$kazanan_uye_id = $kazanan_teklif_oku->uye_id;
			}
			$response=[
				"plaka"=>$plaka,
				"marka_model"=>$marka_model,
				"odeme_tarihi"=>$odeme_tarihi,
				"sigorta"=>$sigortanin_adi,
				"satis_kimin_adina"=>$uye_adi,
				"tarih"=>date("Y-m-d"),
				"maliyet"=>$maliyet,
				"pd_hizmet"=>$pd_hizmet,
				"status"=>200,
				"kazanilan_teklif" => $kazanilan_teklif,
				"kazanan_uye_id" => $kazanan_uye_id
			];
		}else{
			$response=["message"=>"Araç koduna ait araç bulunamadı","status"=>500];
		}
		echo json_encode($response);
	}
}
if(re('action')=="musteri_temsilcisi_cek"){
	$response=[];
	$uye_id=re('uye_id');
	$plaka=re('plaka');
	$gelen_pd_hizmet=re('pd_hizmet');
	$arac_cek = mysql_query("SELECT * FROM ilanlar WHERE plaka = '".$plaka."' order by id desc");
	if(mysql_num_rows($arac_cek)!=0){
		$arac_oku = mysql_fetch_assoc($arac_cek);
		$max_teklif = $arac_oku['son_teklif'];
		if($arac_oku['pd_hizmet']==0 || $arac_oku['pd_hizmet']=""){
			$kazanilan_cek=mysql_query("select * from kazanilan_ilanlar where ilan_id='".$arac_oku["id"]."'");
			$kazanilan_oku=mysql_fetch_array($kazanilan_cek);
			$pd_hizmet= $kazanilan_oku["pd_hizmet"];
		}else{
			$pd_hizmet = $arac_oku['pd_hizmet'];
		}
		$uye_cek=mysql_query("SELECT * FROM user WHERE id='".$uye_id."'");
		// var_dump("SELECT * FROM user WHERE id='".$uye_id."'");
		$uye_oku=mysql_fetch_assoc($uye_cek);
		$musteri_temsilci_id=$uye_oku["temsilci_id"];
		$musteri_cek=mysql_query("SELECT * FROM kullanicilar WHERE id='".$musteri_temsilci_id."'");
		$musteri_oku=mysql_fetch_assoc($musteri_cek);
		$musteri_adi=$musteri_oku["adi"]." ".$musteri_oku["soyadi"];
		// $sorgu=mysql_query("SELECT prm_notlari.* FROM prm_notlari INNER JOIN user ON user.id=prm_notlari.uye_id WHERE user.id='".$uye_id."' AND prm_notlari.durum=1 AND user.temsilci_id='".$musteri_temsilci_id."' ORDER BY id DESC");
		$sorgu = mysql_query("select * from prm_notlari where uye_id = '".$uye_id."' and ekleyen = '".$musteri_temsilci_id."' and durum = 1");
		// var_dump("select * from prm_notlari where uye_id = '".$uye_id."' and ekleyen = '".$musteri_temsilci_id."' and durum = 1");

		$cek=mysql_fetch_assoc($sorgu);
		if($gelen_pd_hizmet!=""){
			$pd=$gelen_pd_hizmet;
		}else{
			$pd=$pd_hizmet;
		}
		// if(count($sorgu)!=0){
		if(mysql_num_rows($sorgu)!=0){
			$prim_hesap=para(($musteri_oku["prim_orani"]/100) * $pd);
			$prim_hesap.=" ₺";
			$prim_db = ($musteri_oku["prim_orani"]/100) * $pd;
			$prim_notu = $cek["not"];
		}else{
			$prim_hesap=0;
			$prim_hesap.=" ₺";
			$prim_db = 0;
			$prim_notu = "";
		}
		$response=["musteri_temsilcisi"=>$musteri_adi,"prim_notu"=>$prim_notu,"pd_hizmet"=>$pd_hizmet,"prim"=>$prim_hesap,"status"=>200,"prim_db" => $prim_db];
	}else{
		$response=["message"=>"Plakaya ait araç bulunamadı","status"=>500];
	}
	echo json_encode($response);

}

if(re('action')=="satis_kaydet"){
	$plaka = re('plaka');
	$kod = re('kod');
	$son_odeme = re('odeme_tarihi');
	$parayi_gonderen = re('parayi_gonderen');
	$marka_model = re('marka_model');
	$sigorta = re('sigorta');
	$prim_db = re('prim_db');

	$satis_tarihi = re('satis_tarihi');
	$maliyet = re('maliyet');
	$pd_hizmet = re('pd_hizmet');
	$ekstra_kazanc = re('ekstra_kazanc');
	$notlar = re('notlar');
	$satis_kimin_adina = re('serbest_secim');
	$satis_adi = re('satis_adi');
	$aciklayici_not = re('aciklayici_not');
	/*$satilan_fiyat = re('satilan_fiyat');*/
	
	$ilan_bul = mysql_query("SELECT * FROM ilanlar WHERE plaka = '".$plaka."'");
	$ilan_getir = mysql_fetch_assoc($ilan_bul);
	$ilan_id = $ilan_getir['id']; 
	$uye_bul = mysql_query("SELECT * FROM user WHERE id = '".$satis_kimin_adina."'");
	$uye_yaz = mysql_fetch_assoc($uye_bul);
	if(mysql_num_rows($uye_bul)==1){
		$uye_ad = $uye_yaz['ad'];
		$uye_id = $uye_yaz['id'];
		$temsilci_id = $uye_yaz['temsilci_id'];
		$temsilci_cek=mysql_query("select * from kullanicilar where id='".$temsilci_id."'");
		$temsilci_oku=mysql_fetch_assoc($temsilci_cek);
		$temsilci_prim_orani=$temsilci_oku["prim_orani"];
		$kazanilan_bul = mysql_query("SELECT * FROM kazanilan_ilanlar WHERE ilan_id = '".$ilan_id."'");
		$kazanilan_yaz = mysql_fetch_assoc($kazanilan_bul);
		/*$son_odeme = $kazanilan_yaz['son_odeme_tarihi'];*/
		$satilan_fiyat = $kazanilan_yaz['kazanilan_teklif'];
		$ciro =  ($satilan_fiyat  + $ekstra_kazanc + $pd_hizmet) - $maliyet;
		$prim=$ciro * ($temsilci_prim_orani / 100);

		$cek = mysql_query("select * from prm_notlari where uye_id = '".$uye_id."' and ekleyen = '".$temsilci_id."' and durum = 1");
		if(mysql_num_rows($cek) == 0){
			$son_prim = 0;
		}else{
			$son_prim = $prim;
		}

		$plaka_cek=mysql_query("select * from satilan_araclar where plaka='".$plaka."'");
		if(mysql_num_rows($plaka_cek)==0){
			/*
			$satis_ekle = mysql_query("INSERT INTO `satilan_araclar` (`id`, `ilan_id`,`uye_id`,`temsilci_id`,`plaka`,`kod`,`marka_model`,`sigorta`,`satis_adi`,`tarih`,`maliyet`,`pd_hizmet`,`ektra_kazanc`, `notlar`,`odeme_tarihi`,`parayi_gonderen`,
			`araci_alan`,`satilan_fiyat`,`aciklayici_not`,`ciro`,`prim`) VALUES (NULL,'".$ilan_id."','".$uye_id."','".$temsilci_id."','".$plaka."','".$kod."','".$marka_model."','".$sigorta."','".$satis_adi."','".$satis_tarihi."','".$maliyet."', 
			'".$pd_hizmet."','".$ekstra_kazanc."','".$notlar."','".$son_odeme."','".$parayi_gonderen."','".$uye_ad."','".$satilan_fiyat."','".$aciklayici_not."','".$ciro."','".$son_prim."');
			");
			*/
			$satis_ekle = mysql_query("INSERT INTO `satilan_araclar` (`id`, `ilan_id`,`uye_id`,`temsilci_id`,`plaka`,`kod`,`marka_model`,`sigorta`,`satis_adi`,`tarih`,`maliyet`,`pd_hizmet`,`ektra_kazanc`, `notlar`,`odeme_tarihi`,`parayi_gonderen`,
			`araci_alan`,`satilan_fiyat`,`aciklayici_not`,`ciro`,`prim`) VALUES (NULL,'".$ilan_id."','".$uye_id."','".$temsilci_id."','".$plaka."','".$kod."','".$marka_model."','".$sigorta."','".$satis_adi."','".$satis_tarihi."','".$maliyet."', 
			'".$pd_hizmet."','".$ekstra_kazanc."','".$notlar."','".$son_odeme."','".$parayi_gonderen."','".$uye_ad."','".$satilan_fiyat."','".$aciklayici_not."','".$ciro."','".$prim_db."');
			");
			if($satis_ekle){
				$response=["message"=>"İşlem başarılı","status"=>200];
			}else{
				$response=["message"=>"Hata oluştu","status"=>500];
			}
		}else{
			$response=["message"=>"Bu plakaya ait araç daha önce eklenmiş","status"=>500];
		}	
	}else{
		$response=["message"=>"Uygun kullanıcı bulunamadı","ddd"=>$satis_kimin_adina,"status"=>500];
	}
	echo json_encode($response);
}

if(re('action')=="satis_guncelle"){
	
	$response=[];
	$id=re("id");
	$uye_id=re("serbest_secim");
	$plaka=re("plaka");
	$kod=re("kod");
	$odeme_tarihi=re("odeme_tarihi");
	$parayi_gonderen=re("parayi_gonderen");
	$marka_model=re("marka_model");
	$sigorta=re("sigorta");
	$satis_tarihi=re("satis_tarihi");
	$maliyet=re("maliyet");
	$satilan_fiyat=re("satilan_fiyat");
	$pd_hizmet=re("pd_hizmet");
	$ekstra_kazanc=re("ekstra_kazanc");
	$satis_adi=re("satis_adi");
	$aciklayici_notlar=re("aciklayici_not");
	
	
	$ilan_bul = mysql_query("SELECT * FROM ilanlar WHERE plaka = '".$plaka."'");
	$ilan_getir = mysql_fetch_assoc($ilan_bul);
	$ilan_id = $ilan_getir['id']; 
	$uye_bul = mysql_query("SELECT * FROM user WHERE id = '".$uye_id."'");
	$uye_yaz = mysql_fetch_assoc($uye_bul);
	if(mysql_num_rows($uye_bul)==1){
		$uye_ad = $uye_yaz['ad'];
		$temsilci_id = $uye_yaz['temsilci_id'];
		$temsilci_cek=mysql_query("select * from kullanicilar where id='".$temsilci_id."'");
		$temsilci_oku=mysql_fetch_assoc($temsilci_cek);
		$temsilci_prim_orani=$temsilci_oku["prim_orani"];
		$kazanilan_bul = mysql_query("SELECT * FROM kazanilan_ilanlar WHERE ilan_id = '".$ilan_id."'");
		$kazanilan_yaz = mysql_fetch_assoc($kazanilan_bul);
		$satilan_fiyat = $kazanilan_yaz['kazanilan_teklif'];
		$ciro =  ($satilan_fiyat  + $ekstra_kazanc + $pd_hizmet) - $maliyet;
		$prim=$ciro * ($temsilci_prim_orani / 100);

		$cek = mysql_query("select * from prm_notlari where uye_id = '".$uye_id."' and ekleyen = '".$temsilci_id."' and durum = 1");
		if(mysql_num_rows($cek) == 0){
			$son_prim = 0;
		}else{
			$son_prim = $prim;
		}


		$plaka_cek=mysql_query("select * from satilan_araclar where plaka='".$plaka."'");
		if(mysql_num_rows($plaka_cek)==1){
			$update=mysql_query("
				UPDATE
					satilan_araclar
				SET
					uye_id='".$uye_id."',
					temsilci_id='".$temsilci_id."',
					plaka='".$plaka."',
					kod='".$kod."',
					marka_model='".$marka_model."',
					sigorta='".$sigorta."',
					satis_adi='".$satis_adi."',
					tarih='".$satis_tarihi."',
					maliyet='".$maliyet."',
					pd_hizmet='".$pd_hizmet."',
					ektra_kazanc='".$ekstra_kazanc."',
					odeme_tarihi='".$odeme_tarihi."',
					parayi_gonderen='".$parayi_gonderen."',
					araci_alan='".$uye_ad."',
					satilan_fiyat='".$satilan_fiyat."',
					aciklayici_not='".$aciklayici_notlar."',
					odeme_tarihi='".$odeme_tarihi."'
				WHERE
					id='".$id."'
			");
			if($update){
				$response=["message"=>"İşlem başarılı","sdsdsd"=>"","status"=>200];
			}else{
				$response=["message"=>"Hata oluştu","status"=>500];
			}
		}else{
			$response=["message"=>"Bu plakaya ait araç bulunamadı","status"=>500];
		}	
	}else{
		$response=["message"=>"Uygun kullanıcı bulunamadı","ddd"=>$satis_kimin_adina,"status"=>500];
	}
	echo json_encode($response);
	
	
}

?>



