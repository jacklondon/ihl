<?php
include "ayar.php";
if (re("action") == "bildirim_ac") {
	$response = [];
	$date = date('Y-m-d H:i:s');
	$id = re("id");
	if ($_SESSION['u_token'] != "" && $_SESSION['k_token'] == "") {
		$uye_token = $_SESSION['u_token'];
		$bildirim_cek = mysql_query("SELECT * FROM user WHERE user_token = '" . $uye_token . "'");
		while ($bildirim_oku = mysql_fetch_array($bildirim_cek)) {
			$uyeninID = $bildirim_oku['id'];
			$bildirim_varmi = mysql_query("SELECT * FROM bildirimler WHERE ilan_id = '" . $id . "' AND uye_id = '" . $uyeninID . "'");
			$bildirimini_say = mysql_num_rows($bildirim_varmi);
			if ($bildirimini_say == 0) {
				$insert = mysql_query("INSERT INTO `bildirimler` (`id`, `ilan_id`, `dogrudan_satisli_id`, `uye_id`, `bildirim_zamani`, `user_token`, `kurumsal_token`) VALUES (NULL, '" . $id . "', '', '" . $uyeninID . "', '" . $date . "', '" . $uye_token . "', '');");
				if ($insert) {
					$response = ["message" => "Bildirimler açıldı", "color" => "orange", "title" => "Araç bildirimleri kapatılacaktır.", "status" => 200];
				} else {
					$response = ["message" => "Hata oluştu", "status" => 500];
				}
			} else {
				$delete = mysql_query("DELETE FROM bildirimler WHERE ilan_id = '" . $id . "' AND uye_id = '" . $uyeninID . "'");
				if ($delete) {
					$response = ["message" => "Bildirimler kapatıldı", "color" => "gray", "title" => "Araç bildirimleri açılacaktır.", "status" => 200];
				} else {
					$response = ["message" => "Hata oluştu", "status" => 500];
				}
			}
		}
	} else if ($_SESSION['u_token'] == "" && $_SESSION['k_token'] != "") {
		$uye_token = $_SESSION['k_token'];
		$bildirim_cek = mysql_query("SELECT * FROM user WHERE kurumsal_user_token = '" . $uye_token . "'");
		while ($bildirim_oku = mysql_fetch_array($bildirim_cek)) {
			$uyeninID = $bildirim_oku['id'];
			$bildirim_varmi = mysql_query("SELECT * FROM bildirimler WHERE ilan_id = '" . $id . "' AND uye_id = '" . $uyeninID . "'");
			$bildirimini_say = mysql_num_rows($bildirim_varmi);
			if ($bildirimini_say == 0) {
				$insert = mysql_query("INSERT INTO `bildirimler` (`id`, `ilan_id`, `dogrudan_satisli_id`, `uye_id`, `bildirim_zamani`, `user_token`, `kurumsal_token`) VALUES 
					(NULL, '" . $id . "', '', '" . $uyeninID . "', '" . $date . "', '" . $uye_token . "', '');");
				if ($insert) {
					$response = ["message" => "Bildirimler açıldı", "color" => "orange", "title" => "Araç bildirimleri kapatılacaktır.", "status" => 200];
				} else {
					$response = ["message" => "Hata oluştu", "status" => 500];
				}
			} else {
				$delete = mysql_query("DELETE FROM bildirimler WHERE ilan_id = '" . $id . "' AND uye_id = '" . $uyeninID . "'");
				if ($delete) {
					$response = ["message" => "Bildirimler kapatıldı", "color" => "gray", "title" => "Araç bildirimleri açılacaktır.", "status" => 200];
				} else {
					$response = ["message" => "Hata oluştu", "status" => 500];
				}
			}
		}
	} else if ($_SESSION['u_token'] == "" && $_SESSION['k_token'] == "") {
		$response = ["message" => "Giriş yapmalısınız", "status" => 500];
	}
	echo json_encode($response);
}
if (re("action") == "favorilere_ekle") {
	$date = date('Y-m-d H:i:s');
	$id = re("id");
	if ($_SESSION['u_token'] != "" && $_SESSION['k_token'] == "") {
		$uye_token = $_SESSION['u_token'];
		$favi_cek = mysql_query("SELECT * FROM user WHERE user_token = '" . $uye_token . "'");
		while ($favi_oku = mysql_fetch_array($favi_cek)) {
			$uyeninID = $favi_oku['id'];
			$favlamismi_cek = mysql_query("SELECT * FROM favoriler WHERE ilan_id = '" . $id . "' AND uye_id = '" . $uyeninID . "'");
			$favlamismi_sayi = mysql_num_rows($favlamismi_cek);
			if ($favlamismi_sayi == 0) {
				$insert = mysql_query("INSERT INTO `favoriler` (`id`, `ilan_id`, `dogrudan_satisli_id`, `uye_id`, `favlama_zamani`, `user_token`, `kurumsal_token`) VALUES 
				(NULL, '" . $id . "', '', '" . $uyeninID . "', '" . $date . "', '" . $uye_token . "', '');");
				if ($insert) {
					$response = ["message" => "Favorilerinize eklendi", "color" => "orange", "title" => "Araç favorilerinizden kaldırılacaktır.", "status" => 200];
				} else {
					$response = ["message" => "Hata oluştu", "status" => 500];
				}
			} else {
				$delete = mysql_query("DELETE FROM favoriler WHERE ilan_id = '" . $id . "' AND uye_id = '" . $uyeninID . "'");
				if ($delete) {
					$response = ["message" => "Favorilerinizden kaldırıldı", "color" => "gray", "title" => "Araç favorilerinize eklenecektir.", "status" => 200];
				} else {
					$response = ["message" => "Hata oluştu", "status" => 500];
				}
			}
		}
	} elseif ($_SESSION['u_token'] == "" && $_SESSION['k_token'] != "") {
		$uye_token = $_SESSION['k_token'];
		$favi_cek = mysql_query("SELECT * FROM user WHERE kurumsal_user_token = '" . $uye_token . "'");
		while ($favi_oku = mysql_fetch_array($favi_cek)) {
			$uyeninID = $favi_oku['id'];
			$favlamismi_cek = mysql_query("SELECT * FROM favoriler WHERE ilan_id = '" . $id . "' AND uye_id = '" . $uyeninID . "'");
			$favlamismi_sayi = mysql_num_rows($favlamismi_cek);
			if ($favlamismi_sayi == 0) {
				$insert = mysql_query("
						INSERT 
							INTO 
						`favoriler` 
							(`id`, `ilan_id`, `dogrudan_satisli_id`, `uye_id`, `favlama_zamani`, `user_token`, `kurumsal_token`) 
						VALUES 
							(NULL, '" . $id . "', '', '" . $uyeninID . "', '" . $date . "', '', '" . $uye_token . "');
					");
				if ($insert) {
					$response = ["message" => "Favorilerinize eklendi", "color" => "orange", "title" => "Araç favorilerinizden kaldırılacaktır.", "status" => 200];
				} else {
					$response = ["message" => "Hata oluştu", "status" => 500];
				}
			} else {
				$delete = mysql_query("DELETE FROM favoriler WHERE ilan_id = '" . $id . "' AND uye_id = '" . $uyeninID . "'");
				if ($delete) {
					$response = ["message" => "Favorilerinizden kaldırıldı", "color" => "gray", "title" => "Araç favorilerinize eklenecektir.", "status" => 200];
				} else {
					$response = ["message" => "Hata oluştu", "status" => 500];
				}
			}
		}
	} else if ($_SESSION['u_token'] == "" && $_SESSION['k_token'] == "") {
		$response = ["message" => "Giriş yapmalısınız", "status" => 500];
	}
	echo json_encode($response);
}
if (re("action") == "dogrudan_favorilere_ekle") {
	$date = date('Y-m-d H:i:s');
	$id = re("id");
	if ($_SESSION['u_token'] != "" && $_SESSION['k_token'] == "") {
		$uye_token = $_SESSION["u_token"];
		$favi_cek = mysql_query("SELECT * FROM user WHERE user_token = '" . $uye_token . "'");
		while ($favi_oku = mysql_fetch_array($favi_cek)) {
			$uyeninID = $favi_oku['id'];
			$favlamismi_cek = mysql_query("SELECT * FROM favoriler WHERE dogrudan_satisli_id = '" . $id . "' AND uye_id = '" . $uyeninID . "'");
			$favlamismi_sayi = mysql_num_rows($favlamismi_cek);
			if ($favlamismi_sayi == 0) {
				$insert = mysql_query("
						INSERT INTO 
							`favoriler`
						(`id`, `ilan_id`, `dogrudan_satisli_id`, `uye_id`, `favlama_zamani`, `user_token`, `kurumsal_token`) 
							VALUES 
						(NULL, '', '" . $id . "', '" . $uyeninID . "', '" . $date . "', '" . $uye_token . "', '');
					");
				if ($insert) {
					$response = ["message" => "Favorilerinize eklendi", "color" => "orange", "title" => "Araç favorilerinizden kaldırılacaktır.", "status" => 200];
				} else {
					$response = ["message" => "Hata oluştu", "status" => 500];
				}
			} else {
				$delete = mysql_query("DELETE FROM favoriler WHERE dogrudan_satisli_id = '" . $id . "' AND uye_id = '" . $uyeninID . "'");
				if ($delete) {
					$response = ["message" => "Favorilerinizden kaldırıldı", "color" => "gray", "title" => "Araç favorilerinize eklenecektir.", "status" => 200];
				} else {
					$response = ["message" => "Hata oluştu", "status" => 500];
				}
			}
		}
	} elseif ($_SESSION['u_token'] == "" && $_SESSION['k_token'] != "") {
		$uye_token = $_SESSION["k_token"];
		$favi_cek = mysql_query("SELECT * FROM user WHERE kurumsal_user_token = '" . $uye_token . "'");
		while ($favi_oku = mysql_fetch_array($favi_cek)) {
			$uyeninID = $favi_oku['id'];
			$favlamismi_cek = mysql_query("SELECT * FROM favoriler WHERE dogrudan_satisli_id = '" . $id . "' AND uye_id = '" . $uyeninID . "'");
			$favlamismi_sayi = mysql_num_rows($favlamismi_cek);
			if ($favlamismi_sayi == 0) {
				$insert = mysql_query("
						INSERT INTO 
							`favoriler`
						(`id`, `ilan_id`, `dogrudan_satisli_id`, `uye_id`, `favlama_zamani`, `user_token`, `kurumsal_token`) 
							VALUES 
						(NULL, '', '" . $id . "', '" . $uyeninID . "', '" . $date . "', '', '" . $uye_token . "');
					");
				if ($insert) {
					$response = ["message" => "Favorilerinize eklendi", "color" => "orange", "title" => "Araç favorilerinizden kaldırılacaktır.", "status" => 200];
				} else {
					$response = ["message" => "Hata oluştu", "status" => 500];
				}
			} else {
				$delete = mysql_query("DELETE FROM favoriler WHERE dogrudan_satisli_id = '" . $id . "' AND uye_id = '" . $uyeninID . "'");
				if ($delete) {
					$response = ["message" => "Favorilerinizden kaldırıldı", "color" => "gray", "title" => "Araç favorilerinize eklenecektir.", "status" => 200];
				} else {
					$response = ["message" => "Hata oluştu", "status" => 500];
				}
			}
		}
		/*
			$favi_cek = mysql_query("SELECT * FROM user WHERE kurumsal_user_token = '".$uye_token."'");
			while($favi_oku = mysql_fetch_array($favi_cek)){
				$uyeninID = $favi_oku['id'];
				$favlamismi_cek = mysql_query("SELECT * FROM favoriler WHERE dogrudan_satisli_id = '".$id."' AND uye_id = '".$uyeninID."'");
				$favlamismi_sayi = mysql_num_rows($favlamismi_cek);
				if($favlamismi_sayi==0){
					$insert=mysql_query("
						INSERT 
							INTO
						`favoriler`
							(`id`, `ilan_id`, `dogrudan_satisli_id`, `uye_id`, `favlama_zamani`, `user_token`, `kurumsal_token`) 
						VALUES 
							(NULL, '', '".$id."', '".$uyeninID."', '".$date."', '', '".$uye_token."');
					");
				}else{
					$delete=mysql_query("DELETE FROM favoriler WHERE dogrudan_satisli_id = '".$id."' AND uye_id = '".$uyeninID."'");
					if($delete){
						$response=["message"=>"Favorilerinizden kaldırıldı","color"=>"gray","title"=>"Araç favorilerinize eklenecektir.","status"=>200];
					}else{
						$response=["message"=>"Hata oluştu","status"=>500];
					}
				}
			}
			*/
	} else if ($_SESSION['u_token'] == "" && $_SESSION['k_token'] == "") {
		$response = ["message" => "Giriş yapmalısınız", "status" => 500];
	}
	echo json_encode($response);
}
if (re("action") == "yetkiyi_kaydet") {
	$response = [];
	$gelen_id = re("uye_id");
	$grup = re('grup');
	$demo_olacagi_tarih = re('demo_olacagi_tarih');
	$uye_standart_teklif_limiti = re('uye_standart_teklif_limiti');
	$uye_luks_teklif_limiti = re('uye_luks_teklif_limiti');

	$hurda_teklif_yetkisi = re('hurda_teklif_yetkisi');
	$musteri_temsilcisi = re('musteri_temsilcisi');
	$yasak_sigorta_array = $_POST['yasak_sigorta'];

	$temsilci_degistirme_yetki = re('temsilci_degistirme_yetki');
	for ($i = 0; $i < count($yasak_sigorta_array); $i++) {
		if ($i != count($yasak_sigorta_array) - 1) {
			$yasak_sigorta .= $yasak_sigorta_array[$i] . ",";
		} else {
			$yasak_sigorta .= $yasak_sigorta_array[$i];
		}
	}
	$kalici_mesaj = re('kalici_mesaj');
	$kalici_sistem_mesaji = re('kalici_sistem_mesaji');
	$teklif_vermesini_engelle = re('teklif_vermesini_engelle');
	$otomatik_risk_engelle = re('otomatik_risk_engelle');
	$uyeyi_engelleme_nedeni = re('uyeyi_engelleme_nedeni');
	$uyelik_iptali = re('uyelik_iptali');
	$uyelik_iptal_nedeni = re('uyelik_iptal_nedeni');


	$aktif_cayma_toplam = mysql_query("SELECT SUM(tutar) as toplam_aktif_cayma FROM cayma_bedelleri WHERE uye_id='" . $gelen_id . "' AND durum=1");
	$toplam_aktif_cayma = mysql_fetch_assoc($aktif_cayma_toplam);

	$borclar_toplam = mysql_query("SELECT SUM(tutar) as toplam_borclar FROM cayma_bedelleri WHERE uye_id='" . $gelen_id . "' AND durum=6");
	$toplam_borclar = mysql_fetch_assoc($borclar_toplam);
	$toplam_cayma = $toplam_aktif_cayma["toplam_aktif_cayma"] - $toplam_borclar["toplam_borclar"];

	// $grubu_sor = mysql_query("SELECT * FROM uye_grubu WHERE id = '".$grup."'");
	$grubu_sor = mysql_query("SELECT * FROM uye_grubu_detaylari WHERE grup_id = '" . $grup . "' and cayma_bedeli <= '" . $toplam_cayma . "' order by cayma_bedeli desc");
	$grubu_yaz = mysql_fetch_object($grubu_sor);


	if ($uye_standart_teklif_limiti == "") {
		//    $son_limit2 = "";
		//    $son_limit2 = $grubu_yaz->standart_ust_limit;
		$son_limit2 = 0;
	} else {
		$son_limit2 = $uye_standart_teklif_limiti;
	}
	if ($uye_luks_teklif_limiti == "") {
		//    $son_limit3 = "";
		//    $son_limit3 = $grubu_yaz->luks_ust_limit;
		$son_limit3 = 0;
	} else {
		$son_limit3 = $uye_luks_teklif_limiti;
	}
	$uye_durumu_cek = mysql_query("SELECT * FROM uye_durumlari WHERE uye_id = '" . $gelen_id . "'");
	$durum_say = mysql_num_rows($uye_durumu_cek);
	if ($durum_say == 0) {
		mysql_query("
				INSERT
					INTO 
				`uye_durumlari`
					(`uye_id`, `demo_olacagi_tarih`, `grup`, `teklif_limiti`, `hurda_teklif`, `yasak_sigorta`, `kalici_mesaj`, `kalici_sistem_mesaji`, `teklif_engelle`, `engelleme_nedeni`, `uyelik_iptal`, `uyelik_iptal_nedeni`) 
				VALUES 
					('" . $gelen_id . "', '" . $demo_olacagi_tarih . "', '" . $grup . "', '" . $son_limit . "', '" . $hurda_teklif_yetkisi . "', '" . $yasak_sigorta . "', '" . $kalici_mesaj . "', '" . $kalici_sistem_mesaji . "', '" . $teklif_vermesini_engelle . "', '" . $uyeyi_engelleme_nedeni . "', '" . $uyelik_iptali . "', '" . $uyelik_iptal_nedeni . "');
			");
		mysql_query("UPDATE user SET paket = '" . $grup . "' WHERE id = '" . $gelen_id . "'");
		mysql_query("UPDATE teklif_limiti SET standart_limit = '" . $son_limit2 . "',luks_limit = '" . $son_limit3 . "' WHERE uye_id = '" . $gelen_id . "'");
	} else {
		mysql_query("UPDATE `uye_durumlari` SET `demo_olacagi_tarih` = '" . $demo_olacagi_tarih . "', `grup` = '" . $grup . "', 
				`teklif_limiti` = '" . $son_limit . "', `hurda_teklif` = '" . $hurda_teklif_yetkisi . "', 
				`yasak_sigorta` = '" . $yasak_sigorta . "', `kalici_mesaj` = '" . $kalici_mesaj . "', 
				`kalici_sistem_mesaji` = '" . $kalici_sistem_mesaji . "', `teklif_engelle` = '" . $teklif_vermesini_engelle . "', 
				`engelleme_nedeni` = '" . $uyeyi_engelleme_nedeni . "',`otomatik_teklif_engelle`='" . $otomatik_risk_engelle . "', `uyelik_iptal` = '" . $uyelik_iptali . "',
				`uyelik_iptal_nedeni` = '" . $uyelik_iptal_nedeni . "' WHERE `uye_durumlari`.`uye_id` = '" . $gelen_id . "';
			");
		mysql_query("UPDATE user SET paket = '" . $grup . "' WHERE id = '" . $gelen_id . "'");
		mysql_query("UPDATE teklif_limiti SET standart_limit = '" . $son_limit2 . "',luks_limit = '" . $son_limit3 . "' WHERE uye_id = '" . $gelen_id . "'");
		$risk_cek = mysql_query("SELECT * FROM uye_durumlari WHERE uye_id = '" . $gelen_id . "'");
		while ($risk_oku = mysql_fetch_array($risk_cek)) {
			if ($risk_oku['teklif_engelle'] == "on") {
				mysql_query("UPDATE user SET risk = '2' WHERE id = '" . $gelen_id . "'");
			} elseif ($risk_oku['uyelik_iptal'] == "on") {
				mysql_query("UPDATE user SET risk = '3' WHERE id = '" . $gelen_id . "'");
			} else {
				mysql_query("UPDATE user SET risk = '1' WHERE id = '" . $gelen_id . "'");
			}
		}
	}



	$uye_durumu_cek = mysql_query("SELECT * FROM uye_durumlari WHERE uye_id = '" . $gelen_id . "'");
	$uye_cek = mysql_query("select * from user where id = '" . $gelen_id . "'");
	$uye_oku = mysql_fetch_object($uye_cek);
	$temsilci_degistirme_yetki = re('temsilci_degistirme_yetki');

	if ($grup == 1) {
		if ($musteri_temsilcisi != -1) {
			$yeni_temsilci_id = $musteri_temsilcisi;
		} else {
			$yeni_temsilci_id = $uye_oku->temsilci_id;
		}
	} else {

		if ($musteri_temsilcisi == -1) {
			$yeni_temsilci_id = 0;
			$prm_cek = mysql_query("select * from prm_notlari where uye_id = '" . $gelen_id . "' and durum = 1 and ekleyen <> 0");
			if (mysql_num_rows($prm_cek) != 0) {
				while ($prm_oku = mysql_fetch_object($prm_cek)) {
					$admin_cek = mysql_query("select * from kullanicilar where id = '" . $prm_oku->ekleyen . "'");
					$admin_oku = mysql_fetch_object($admin_cek);
					if ($admin_oku->departman == "Müşteri Temsilcisi") {
						$yeni_temsilci_id = $admin_oku->id;
					}
				}
			} else {
				$yeni_temsilci_id = -5;
				$temslici_cek_yeni = mysql_query("select * from kullanicilar where departman = 'Müşteri Temsilcisi'");
				while ($temsilci_oku_yeni = mysql_fetch_object($temslici_cek_yeni)) {
					$toplam_musterisi = mysql_num_rows(mysql_query("select * from user where temsilci_id = '" . $temsilci_oku_yeni->id . "'"));
					if ($toplam_musterisi == 0) {
						$yeni_temsilci_id = $temsilci_oku_yeni->id;
					}
				}
				if ($yeni_temsilci_id == -5) {
					$temsilci_cekk = mysql_query("SELECT b.temsilci_id,COUNT(*) as toplam FROM kullanicilar a, user b WHERE a.id = b.temsilci_id GROUP BY b.temsilci_id ORDER BY toplam asc");
					while ($temsilci_okuu = mysql_fetch_object($temsilci_cekk)) {
						$admin_cek = mysql_query("select * from kullanicilar where id = '" . $temsilci_okuu->temsilci_id . "'");
						$admin_oku = mysql_fetch_object($admin_cek);
						if ($admin_oku->departman == "Müşteri Temsilcisi") {
							$yeni_temsilci_id = $admin_oku->id;
						}
					}
				}
			}
		} else {
			$yeni_temsilci_id = $musteri_temsilcisi;
		}
	}
	if ($temsilci_degistirme_yetki == 1) {
		mysql_query("UPDATE user SET temsilci_id = '" . $yeni_temsilci_id . "' WHERE id = '" . $gelen_id . "'");
	}

	$response = ["message" => "İşlem başarılı", "status" => 200];
	echo json_encode($response);
}
if (re("action") == "uye_notu_kaydet") {
	$admin_id = $_SESSION['kid'];
	$eklenecek_not = re('eklenecek_not');
	$gelen_id = re('gelen_id');
	$gizlilik = re('gizlilik');
	$tarih = date('Y-m-d H:i:s');
	$sayi = 0;
	if (count($_FILES['file']['tmp_name']) > 0) {
		foreach ($_FILES['file']['tmp_name'] as $key => $tmp_name) {
			$dosya_adi = $_FILES['file']['name'][$key]; 		// uzantiya beraber dosya adi 
			$dosya_boyutu = $_FILES['file']['size'][$key];    		// byte cinsinden dosya boyutu 
			$dosya_gecici = $_FILES['file']['tmp_name'][$key];		//gecici dosya adresi 
			$yenisim = md5(microtime()) . $dosya_adi; 					//karmasik yeni isim.pdf                  
			$klasor = "assets"; // yuklenecek dosyalar icin yeni klasor 
			$test = move_uploaded_file($dosya_gecici, "$klasor/" . $yenisim); //yoksa yeni ismiyle kaydet 
			if ($test == false) {
				$a = mysql_query("INSERT INTO `uye_notlari` (`id`, `uye_id`, `ekleyen`, `uye_notu`, `gizlilik`, `tarih`, `dosya`) 
					VALUES (NULL, '" . $gelen_id . "', '" . $admin_id . "', '" . $eklenecek_not . "', '" . $gizlilik . "', '" . $tarih . "', '1')
					") or die(mysql_error());
				if ($sayi == 0) {
					mysql_query("INSERT INTO `yapilan_is` (`id`, `admin_id`, `yaptigi`,`aciklama`,`gizlilik`, `ekleme_zamani`, `ilan_id`, `dogrudan_id`, `uye_id`) VALUES 
						(NULL, '" . $admin_id . "', '3','" . $eklenecek_not . "', '" . $gizlilik . "','" . $tarih . "','','','" . $gelen_id . "');");
				}
			} else {
				$a = mysql_query("INSERT INTO `uye_notlari` (`id`, `uye_id`, `ekleyen`, `uye_notu`, `gizlilik`, `tarih`, `dosya`) 
					VALUES (NULL, '" . $gelen_id . "', '" . $admin_id . "', '" . $eklenecek_not . "', '" . $gizlilik . "', '" . $tarih . "', '" . $yenisim . "')
					") or die(mysql_error());
				if ($sayi == 0) {
					mysql_query("INSERT INTO `yapilan_is` (`id`, `admin_id`, `yaptigi`,`aciklama`,`gizlilik`, `ekleme_zamani`, `ilan_id`, `dogrudan_id`, `uye_id`) VALUES 
						(NULL, '" . $admin_id . "', '3','" . $eklenecek_not . "', '" . $gizlilik . "', '" . $tarih . "','','','" . $gelen_id . "');");
				}
			}
			$sayi++;
		}
	} else {
		$a = mysql_query("INSERT INTO `uye_notlari` (`id`, `uye_id`, `ekleyen`, `uye_notu`, `gizlilik`, `tarih`, `dosya`) 
			VALUES (NULL, '" . $gelen_id . "', '" . $admin_id . "', '" . $eklenecek_not . "', '" . $gizlilik . "', '" . $tarih . "', '1')") or die(mysql_error());
		mysql_query("INSERT INTO `yapilan_is` (`id`, `admin_id`, `yaptigi`,`aciklama`,`gizlilik`, `ekleme_zamani`, `ilan_id`, `dogrudan_id`, `uye_id`) VALUES 
			(NULL, '" . $admin_id . "', '3','" . $eklenecek_not . "', '" . $gizlilik . "', '" . $tarih . "','','','" . $gelen_id . "');");
	}

	$yuklenen_cek = mysql_query("SELECT * FROM yuklenen_evraklar WHERE user_id ='" . $gelen_id . "' group by gonderme_zamani order by id desc");
	$yuklenenler = mysql_num_rows($yuklenen_cek);
	$evraklar = mysql_query("SELECT * FROM uye_notlari WHERE uye_id ='" . $gelen_id . "' group by tarih order by id desc");
	$evrak_say = mysql_num_rows($evraklar);
	$prm_cek = mysql_query("SELECT * FROM prm_notlari WHERE uye_id ='" . $gelen_id . "'");
	$prm_say = mysql_num_rows($prm_cek);
	$toplam_not = $prm_say + $evrak_say + $yuklenenler;
	$response = ["message" => "Not eklendi", "toplam_not" => $toplam_not, "status" => 200];
	echo json_encode($response);
}
if (re("action") == "ilan_notu_kaydet") {
	$admin_id = $_SESSION['kid'];
	$eklenecek_not = re('eklenecek_not');
	$gelen_id = re('gelen_id');
	$gizlilik = re('gizlilik');
	$tarih = date('Y-m-d H:i:s');
	$sayi = 0;
	if (count($_FILES['file']['tmp_name']) > 0) {    // dosya tanımlanmıs mı? 
		foreach ($_FILES['file']['tmp_name'] as $key => $tmp_name) {
			$dosya_adi = $_FILES['file']['name'][$key]; 		// uzantiya beraber dosya adi 
			$dosya_boyutu = $_FILES['file']['size'][$key];    		// byte cinsinden dosya boyutu 
			$dosya_gecici = $_FILES['file']['tmp_name'][$key];		//gecici dosya adresi 
			$yenisim = md5(microtime()) . $dosya_adi; 				//karmasik yeni isim.pdf 
			$klasor = "assets"; // yuklenecek dosyalar icin yeni klasor 
			$test = move_uploaded_file($dosya_gecici, "$klasor/" . $yenisim); //yoksa yeni ismiyle kaydet 
			if ($test) {
				$yol = 'assets/' . $yenisim;
				$a = mysql_query("INSERT INTO `ilan_notlari` (`id`, `ilan_id`, `ekleyen`, `ilan_notu`, `gizlilik`, `tarih`, `dosya`) 
					VALUES (NULL, '" . $gelen_id . "', '" . $admin_id . "', '" . $eklenecek_not . "', '" . $gizlilik . "', '" . $tarih . "', '" . $yenisim . "')") or die(mysql_error());
				if ($sayi == 0) {
					mysql_query("INSERT INTO `yapilan_is` (`id`, `admin_id`, `yaptigi`,`aciklama`,`gizlilik`, `ekleme_zamani`, `ilan_id`, `dogrudan_id`, `uye_id`) VALUES 
						(NULL, '" . $admin_id . "', '2','" . $eklenecek_not . "','" . $gizlilik . "', '" . $tarih . "','" . $gelen_id . "','0','0');");
				}
			} else {
				$a = mysql_query("INSERT INTO `ilan_notlari` (`id`, `ilan_id`, `ekleyen`, `ilan_notu`, `gizlilik`, `tarih`, `dosya`) 
					VALUES (NULL, '" . $gelen_id . "', '" . $admin_id . "', '" . $eklenecek_not . "', '" . $gizlilik . "', '" . $tarih . "', '1')") or die(mysql_error());
				if ($sayi == 0) {
					mysql_query("INSERT INTO `yapilan_is` (`id`, `admin_id`, `yaptigi`,`aciklama`, `gizlilik`, `ekleme_zamani`, `ilan_id`, `dogrudan_id`, `uye_id`) VALUES 
						(NULL, '" . $admin_id . "', '2','" . $eklenecek_not . "','" . $gizlilik . "', '" . $tarih . "','" . $gelen_id . "','0','0');");
				}
			}
			$sayi++;
		}
	} else {
		$a = mysql_query("INSERT INTO `ilan_notlari` (`id`, `ilan_id`, `ekleyen`, `ilan_notu`, `gizlilik`, `tarih`, `dosya`) 
					VALUES (NULL, '" . $gelen_id . "', '" . $admin_id . "', '" . $eklenecek_not . "', '" . $gizlilik . "', '" . $tarih . "', '1')") or die(mysql_error());

		mysql_query("INSERT INTO `yapilan_is` (`id`, `admin_id`, `yaptigi`,`aciklama`, `gizlilik`, `ekleme_zamani`, `ilan_id`, `dogrudan_id`, `uye_id`) VALUES 
				(NULL, '" . $admin_id . "', '2','" . $eklenecek_not . "','" . $gizlilik . "', '" . $tarih . "','" . $gelen_id . "','0','0');");
	}

	$not_cek = mysql_query("SELECT * FROM ilan_notlari WHERE ilan_id = '" . $gelen_id . "' group by tarih order by id desc");
	$toplam_not = mysql_num_rows($not_cek);
	$response = ["message" => "Not eklendi", "toplam_not" => $toplam_not, "status" => 200];
	echo json_encode($response);
}
if (re("action") == "dogrudan_notu_kaydet") {
	$admin_id = $_SESSION['kid'];
	$eklenecek_not = re('eklenecek_not');
	$gelen_id = re('gelen_id');
	$gizlilik = re('gizlilik');
	$tarih = date('Y-m-d H:i:s');
	//var_dump($_FILES["file"]);

	if (count($_FILES['file']['tmp_name']) > 0) {     // dosya tanımlanmıs mı? 
		$errors = array();
		foreach ($_FILES['file']['tmp_name'] as $key => $tmp_name) {
			$dosya_adi = $_FILES['file']['name'][$key]; 		// uzantiya beraber dosya adi 
			$dosya_boyutu = $_FILES['file']['size'][$key];    		// byte cinsinden dosya boyutu 
			$dosya_gecici = $_FILES['file']['tmp_name'][$key];		//gecici dosya adresi 
			$yenisim = md5(microtime()) . $dosya_adi; 				//karmasik yeni isim.pdf 

			$klasor = "assets"; // yuklenecek dosyalar icin yeni klasor 
			$test = move_uploaded_file($dosya_gecici, "$klasor/" . $yenisim); //yoksa yeni ismiyle kaydet 
			if ($test == true) {
				$yol = 'assets/' . $yenisim;
				$a = mysql_query("INSERT INTO `dogrudan_satis_notlari` (`id`, `dogrudan_id`, `ekleyen`, `ilan_notu`, `gizlilik`, `tarih`, `dosya`) 
					VALUES (NULL, '" . $gelen_id . "', '" . $admin_id . "', '" . $eklenecek_not . "', '" . $gizlilik . "', '" . $tarih . "', '" . $yenisim . "')") or die(mysql_error());

				mysql_query("INSERT INTO `yapilan_is` (`id`, `admin_id`, `yaptigi`,`aciklama`, `ekleme_zamani`, `ilan_id`, `dogrudan_id`, `uye_id`) VALUES 
					(NULL, '" . $admin_id . "', '2','" . $eklenecek_not . "', '" . $tarih . "','0','" . $gelen_id . "','0');");
			} else {
				$a = mysql_query("INSERT INTO `dogrudan_satis_notlari` (`id`, `dogrudan_id`, `ekleyen`, `ilan_notu`, `gizlilik`, `tarih`, `dosya`) 
					VALUES (NULL, '" . $gelen_id . "', '" . $admin_id . "', '" . $eklenecek_not . "', '" . $gizlilik . "', '" . $tarih . "', '1')") or die(mysql_error());

				mysql_query("INSERT INTO `yapilan_is` (`id`, `admin_id`, `yaptigi`,`aciklama`, `ekleme_zamani`, `ilan_id`, `dogrudan_id`, `uye_id`) VALUES 
						(NULL, '" . $admin_id . "', '2','" . $eklenecek_not . "', '" . $tarih . "','0','" . $gelen_id . "','0');");
			}
		}
	} else {
		$a = mysql_query("INSERT INTO `dogrudan_satis_notlari` (`id`, `dogrudan_id`, `ekleyen`, `ilan_notu`, `gizlilik`, `tarih`, `dosya`) 
				VALUES (NULL, '" . $gelen_id . "', '" . $admin_id . "', '" . $eklenecek_not . "', '" . $gizlilik . "', '" . $tarih . "', '1')") or die(mysql_error());

		mysql_query("INSERT INTO `yapilan_is` (`id`, `admin_id`, `yaptigi`,`aciklama`, `ekleme_zamani`, `ilan_id`, `dogrudan_id`, `uye_id`) VALUES 
					(NULL, '" . $admin_id . "', '2','" . $eklenecek_not . "', '" . $tarih . "','0','" . $gelen_id . "','0');");
	}
	$not_cek = mysql_query("SELECT * FROM dogrudan_satis_notlari WHERE dogrudan_id = '" . $gelen_id . "' group by tarih order by id desc");
	$not_sayi = mysql_num_rows($not_cek);
	$response = ["message" => "Not eklendi", "toplam_not" => $not_sayi, "status" => 200];

	echo json_encode($response);
}
if (re("action") == "yeni_onay_kodu") {
	$response = [];
	$telefon = re("gsm");
	$select = mysql_query("Select * from user where telefon='" . $telefon . "'");
	$kullanici_cek = mysql_fetch_assoc($select);
	$yeni_onay = substr(str_shuffle("0123456789"), 0, 6);
	$onay_mesaj = "Pertdunyasi.com kullanıcı onay bilgileriniz:Onaylı cep No:" . $telefon . " Onay Kodunuz:" . $yeni_onay . ". Üyeliğinizin tamamlanabilmesi için lütfen cep telefonunuza gönderilen kodu giriniz.";
	$date_time = date("Y-m-d H:i:s");

	$uye_kontrol = mysql_query("Select * from onayli_kullanicilar where user_id='" . $kullanici_cek["id"] . "'");
	$kontrol = mysql_num_rows($uye_kontrol);

	if ($kontrol != 0) {
		$update = mysql_query("Update onayli_kullanicilar set kod='" . $yeni_onay . "',durum='1' where user_id='" . $kullanici_cek["id"] . "'");
	} else {
		$onayli_kullanicilar = mysql_query("INSERT INTO onayli_kullanicilar (user_id, kod,e_tarihi,durum) VALUES('" . $kullanici_cek["id"] . "','" . $yeni_onay . "','" . $date_time . "','1')");
		// var_dump("INSERT INTO onayli_kullanicilar (user_id, kod,e_tarihi,durum) VALUES('".$kullanici_cek["id"]."','".$yeni_onay."','".$date_time."','1')");

	}

	coklu_sms_gonder($kullanici_cek["id"], $onay_mesaj, 5);
	$response = ["message" => "Onay kodu telefon numaranıza başarıyla gönderildi", "status" => 200];
	echo json_encode($response);
}

if (re('action') == "mobile_login") {
	$telefon = re('telefon');
	$sifre = md5(re('sifre'));
	$kullanici_kontrol = mysql_query("SELECT * FROM user WHERE telefon='" . $telefon . "' and sifre='" . $sifre . "'");
	if (mysql_num_rows($kullanici_kontrol) == 1) {
		$kullanici_oku = mysql_fetch_array($kullanici_kontrol);
		$bugun = date("Y-m-d");
		$uye_durum_cek = mysql_query("SELECT * FROM uye_durumlari WHERE uye_id = '" . $kullanici_oku['id'] . "'");
		$uye_durum_oku = mysql_fetch_assoc($uye_durum_cek);
		$uye_demo_tarihi = $uye_durum_oku['demo_olacagi_tarih'];
		if ($uye_demo_tarihi == $bugun) {
			$demo_yetki_cek = mysql_query("SELECT * FROM uye_grubu WHERE id = 1");
			$demo_yetki_oku = mysql_fetch_assoc($demo_yetki_cek);
			$ust_limiti = $demo_yetki_oku['teklif_ust_limit'];
			$ust_standart = $demo_yetki_oku['standart_ust_limit'];
			$ust_luks = $demo_yetki_oku['luks_ust_limit'];
			mysql_query("UPDATE user SET paket = 1 WHERE id = '" . $kullanici_oku['id'] . "'");
			mysql_query("UPDATE teklif_limiti SET teklif_limiti = '" . $ust_limiti . "', standart_limit = '0', luks_limit = '0' WHERE uye_id = '" . $kullanici_oku['id'] . "'");
		}
		$kullanici_onay = mysql_query("Select * from onayli_kullanicilar where user_id='" . $kullanici_oku["id"] . "'");
		$onay_cek = mysql_fetch_assoc($kullanici_onay);
		if ($onay_cek["durum"] != 1) {
			$response = ["message" => "Lütfen hesabınızı doğrulayın!", "status" => 301];
			echo json_encode($response);
		} else {
			$_SESSION['u_token'] = $kullanici_oku["user_token"];
			$_SESSION['k_token'] = $kullanici_oku["kurumsal_user_token"];
			if (!empty($_SESSION['u_token'])) {
				$cek = mysql_query("SELECT * FROM user WHERE user_token = '" . $_SESSION['u_token'] . "' LIMIT 1");
				$oku = mysql_fetch_assoc($cek);
				$uye_turu = 1;
			} elseif (!empty($_SESSION['k_token'])) {
				$cek = mysql_query("SELECT * FROM user WHERE kurumsal_user_token = '" . $_SESSION['k_token'] . "' LIMIT 1");
				$oku = mysql_fetch_assoc($k_cek);
				$uye_turu = 2;
			}

			$yetki_cek = mysql_query("SELECT * FROM uye_durumlari WHERE uye_id = '" . $oku['id'] . "'");
			$yetki_oku = mysql_fetch_assoc($yetki_cek);
			if ($yetki_oku['uyelik_iptal'] == "on") {
				if ($yetki_oku['uyelik_iptal_nedeni'] == "") {
					session_destroy();
					$response = ["message" => "Üyeliğiniz fesih edilmiştir. Tekrar üyelik almanız mümkün değildir", "status" => 302];
					echo json_encode($response);
				} else {
					$uyelik_iptal_nedeni = $yetki_oku['uyelik_iptal_nedeni'];
					session_destroy();
					$response = ["message" => $uyelik_iptal_nedeni, "status" => 303];
					echo json_encode($response);
				}
			} else {
				if ($yetki_oku['kalici_mesaj'] == "on") {
					$kalici_sistem_mesaji = $yetki_oku['kalici_sistem_mesaji'];
					if ($kalici_sistem_mesaji != "") {
						session_destroy();
						$response = ["message" => $kalici_sistem_mesaji, "status" => 304];
						echo json_encode($response);
					} else {
						session_destroy();
						$response = ["message" => "Değerli üyemiz bazı bilgileriniz eksiktir. Bize ulaşmanız durumunda eksik bilgileri birlikte doldurur isek sisteme giriş yapabileceksiniz.", "status" => 305];
						echo json_encode($response);
					}
				} else {
					$son_islem_cek = mysql_query("SELECT * FROM user WHERE id = '" . $oku['id'] . "'");
					$son_islem_oku = mysql_fetch_assoc($son_islem_cek);
					$son_islem_zamani = $son_islem_oku['son_islem_zamani'];
					$u_paket = $son_islem_oku["paket"];
					$now = date("Y-m-d H:i:s");
					$yesterday = date("Y-m-d H:i:s", strtotime('-24 hours', strtotime($now)));
					$response = ["message" => "Giriş Başarılı", "uye_turu" => $uye_turu, "status" => 200];
					echo json_encode($response);
					// header('location:uye_panel/success.php');
				}
			}
		}
	} else {
		$response = ["message" => "Telefon numaranız veya şifreniz hatalı lütfen tekrar deneyin!", "status" => 300];
		echo json_encode($response);
	}
}


if(re("action") == "mobile_onay_kodu"){
	$onay_kodu = re('onay_kodu');
	$gsm=re("gsm");
	$kullanici_cek=mysql_query("select * from user where telefon='".$gsm."'");
	$kullanici_oku=mysql_fetch_assoc($kullanici_cek);
	$kullanici_id=$kullanici_oku["id"];
	
	$sql=mysql_query("select * from onayli_kullanicilar where user_id='".$kullanici_id."'");
	$fetch=mysql_fetch_assoc($sql);
	if($fetch["kod"]==$onay_kodu){
		$_SESSION['u_token'] = $kullanici_oku["user_token"];
		$_SESSION['k_token'] = $kullanici_oku["kurumsal_user_token"];
		if($_SESSION['u_token']!=""){
			$yonlendirme="uye_panel/success.php";
		}else{
			$yonlendirme="kurumsal_panel/success.php";
		}
		$update=mysql_query("Update onayli_kullanicilar set durum='1' where user_id='".$kullanici_id."' and kod='".$onay_kodu."'");
		if($update)
		{
			$response = ["message" => "GSM No Onaylandı.","yonlendirme" => $yonlendirme,"status" => 200];
			echo json_encode($response);
		} else {
			$response = ["message" => "İşlem sırasında bir hata oluştu. Lütfen tekrar deneyiniz.", "status" => 300];
			echo json_encode($response);
		}
	}else{
		$response = ["message" => "Onay Kodunuz Yanlış", "status" => 300];
		echo json_encode($response);
	}
}
