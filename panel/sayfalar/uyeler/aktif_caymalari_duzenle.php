<?php 
	include('../../../ayar.php');
	if(re("action")=="aktif_guncelle"){
		$aktif_id = $_POST['aktif_id'];
		$gelen_id = $_POST['gelen_id'];
		$hesap_sahibi = $_POST['hesap_sahibi'];
		$depozito_durumu = $_POST['depozito_durumu'];
		$aktif_tutar = $_POST['aktif_tutar'];
		$aktif_iade_tutar = $_POST['aktif_iade_tutar'];
		$aktif_iban = $_POST['aktif_iban'];
		$aktif_aciklama = $_POST['aktif_aciklama'];
		$iade_edilecek_tarih = $_POST['iade_edilecek_tarih'];

		$uyenin_grubunu_sor = mysql_query("SELECT * FROM user WHERE id ='".$gelen_id."'");
		$uyenin_grubunu_oku = mysql_fetch_assoc($uyenin_grubunu_sor);
		$uyenin_grubu = $uyenin_grubunu_oku['paket'];

		$date = date('Y-m-d H:i:s');
		$tutar_cek=mysql_query("
								Select
									*
								from
									cayma_bedelleri 
								where 
									id='".$aktif_id."'
							");
		$aktif_tutari_cek=mysql_fetch_assoc($tutar_cek);

		$tutar=$aktif_tutari_cek["net"];

		$net=(intval($tutar)-intval($aktif_iade_tutar));
		$net2 = (intval($aktif_iade_tutar)-intval($tutar));
		if($depozito_durumu == "İptal Edildi"){
			mysql_query("
							UPDATE 
								cayma_bedelleri 
							SET
								iade_tutari = '".$aktif_iade_tutar."', 
								hesap_sahibi = '".$hesap_sahibi."', 
								sonuc = '".$depozito_durumu."', 
								durum = 5,
								aciklama = '".$aktif_aciklama."', 
								iade_tarihi = '".$date."',
								net='".$net."'
							WHERE 
								id = '".$aktif_id."'
						");
			$response=["message"=>"İşlem başarılı"];
		}else{
			if($net > 0){
				mysql_query("
							UPDATE 
								cayma_bedelleri
							SET
								iade_tutari = '".$aktif_iade_tutar."', 
								hesap_sahibi = '".$hesap_sahibi."', 
								sonuc = '".$depozito_durumu."', 
								aciklama = '".$aktif_aciklama."', 
								iade_tarihi = '".$date."',
								net='".$net."' 
							WHERE 
								id = '".$aktif_id."'
							");
				mysql_query("
								INSERT 
									INTO
								`cayma_bedelleri`
									(`id`, `uye_id`, `tutar`, `hesap_sahibi`, `iban`, `uye_grubu`, `tarih`, `iade_tarihi`, `iade_tutari`, `aciklama`, `net`, `durum`, `sonuc`,`cayma_id`) 
								VALUES 
									(NULL, '".$gelen_id."', '".$net."', '".$hesap_sahibi."', '".$aktif_iban."', '".$uyenin_grubu."', '".$date."', '".$date."', '".$aktif_iade_tutar."', '".$aktif_aciklama."', '".$net."', '4', '".$depozito_durumu."','".$aktif_id."')
							");
				
			}elseif($net == 0 ){
				mysql_query("
								UPDATE 
									cayma_bedelleri 
								SET 
									iade_tutari = '".$aktif_iade_tutar."', 
									hesap_sahibi = '".$hesap_sahibi."', 
									sonuc = '".$depozito_durumu."', 
									aciklama = '".$aktif_aciklama."', 
									iade_tarihi = '".$date."',
									net='".$net."',
									durum = 4 
								WHERE 
									id = '".$aktif_id."'
							");    
			}else{
				mysql_query("
								UPDATE 
									cayma_bedelleri 
								SET 
									iade_tutari = '".$aktif_iade_tutar."', 
									hesap_sahibi = '".$hesap_sahibi."', 
									sonuc = '".$depozito_durumu."', 
									aciklama = '".$aktif_aciklama."', 
									iade_tarihi = '".$date."',
									net='".$net."',
									durum = 2 
								WHERE 
									id = '".$aktif_id."'
							");  
			}
			$response=["message"=>"İşlem başarılı"];
		}
		echo json_encode($response);
	}

    
/*
 mysql_query("INSERT INTO `cayma_bedelleri` (`id`, `uye_id`, `tutar`, `hesap_sahibi`, `iban`, `uye_grubu`, `tarih`, `iade_tarihi`, `iade_tutari`, `aciklama`, `net`, `durum`, `sonuc`) 
 VALUES 
 (NULL, '".$gelen_id."', '".$net."', '".$hesap_sahibi."', '".$aktif_iban."', '', '".$date."', '".$date."', '".$aktif_iade_tutar."', '".$aktif_aciklama."', '".$net."', '4', '".$depozito_durumu."')");
 */


?>
