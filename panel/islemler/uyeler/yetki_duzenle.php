<?php 
$gelen_id=re("id"); 

if(re('yetkiyi')=="Kaydet"){
	$uye_durumu_cek = mysql_query("SELECT * FROM uye_durumlari WHERE uye_id = '".$gelen_id."'");
	$uye_cek = mysql_query("select * from user where id = '".$gelen_id."'");
	$uye_oku = mysql_fetch_object($uye_cek);
    $grup = re('grup');
	$musteri_temsilcisi = re('musteri_temsilcisi');
	$temsilci_degistirme_yetki = re('temsilci_degistirme_yetki');
	
	if($grup == 1){
		$yeni_temsilci_id = $uye_oku->temsilci_id;
	}else{
		if($musteri_temsilcisi == -1){
			$yeni_temsilci_id = 0;
			$prm_cek = mysql_query("select * from prm_notlari where uye_id = '".$gelen_id."' and durum = 1 and ekleyen <> 0");
			if(mysql_num_rows($prm_cek) != 0){
			  while($prm_oku = mysql_fetch_object($prm_cek)){
				$admin_cek = mysql_query("select * from kullanicilar where id = '".$prm_oku->ekleyen."'");
				$admin_oku = mysql_fetch_object($admin_cek);
				if($admin_oku->departman == "Müşteri Temsilcisi"){
				  $yeni_temsilci_id = $admin_oku->id;
				}
			  }
			}else{
			  $temsilci_cek = mysql_query("SELECT b.temsilci_id,COUNT(*) as toplam FROM kullanicilar a, user b WHERE a.id = b.temsilci_id GROUP BY b.temsilci_id ORDER BY toplam asc");
			  while($temsilci_oku = mysql_fetch_object($temsilci_cek)){
				$admin_cek = mysql_query("select * from kullanicilar where id = '".$temsilci_oku->temsilci_id."'");
				$admin_oku = mysql_fetch_object($admin_cek);
				if($admin_oku->departman == "Müşteri Temsilcisi"){
				  $yeni_temsilci_id = $admin_oku->id;
				}
			  }
			}
		}
	}


    $demo_olacagi_tarih = re('demo_olacagi_tarih');
    $uye_teklif_limiti = re('uye_teklif_limiti');
    $uye_standart_teklif_limiti = re('uye_standart_teklif_limiti');
    $uye_luks_teklif_limiti = re('uye_luks_teklif_limiti');
	
    $hurda_teklif_yetkisi = re('hurda_teklif_yetkisi');
 
	
    $yasak_sigorta_array = $_POST['yasak_sigorta']; //array
	for($i=0;$i<count($yasak_sigorta_array);$i++){
		if($i!=count($yasak_sigorta_array)-1){
			$yasak_sigorta.=$yasak_sigorta_array[$i].",";
		}else{
			$yasak_sigorta.=$yasak_sigorta_array[$i];
		}
	}



	
    $kalici_mesaj = re('kalici_mesaj');
    $kalici_sistem_mesaji = re('kalici_sistem_mesaji');
    $teklif_vermesini_engelle = re('teklif_vermesini_engelle');
    $otomatik_risk_engelle = re('otomatik_risk_engelle');
    $uyeyi_engelleme_nedeni = re('uyeyi_engelleme_nedeni');
    $uyelik_iptali = re('uyelik_iptali');
    $uyelik_iptal_nedeni = re('uyelik_iptal_nedeni');
   
    $durum_say = mysql_num_rows($uye_durumu_cek);

    $grubu_sor = mysql_query("SELECT * FROM uye_grubu WHERE id = '".$grup."'");
    $grubu_yaz = mysql_fetch_assoc($grubu_sor);

	/*if($uye_teklif_limiti == ""){
       $son_limit = $grubu_yaz['teklif_ust_limit'];
    }else{
        $son_limit = $uye_teklif_limiti;
    }*/
	
	if($uye_standart_teklif_limiti == ""){
      // $son_limit2 = $grubu_yaz['standart_ust_limit'];
       $son_limit2 = "";
    }else{
        $son_limit2 = $uye_standart_teklif_limiti;
    }
	
	if($uye_luks_teklif_limiti == ""){
       //$son_limit3 = $grubu_yaz['luks_ust_limit'];
       $son_limit3 = "";
    }else{
        $son_limit3 = $uye_luks_teklif_limiti;
    }

    if($durum_say == 0){
		mysql_query("
			INSERT
				INTO 
			`uye_durumlari`
				(`id`, `uye_id`, `demo_olacagi_tarih`, `grup`, `teklif_limiti`, `hurda_teklif`, `yasak_sigorta`, `kalici_mesaj`, `kalici_sistem_mesaji`, `teklif_engelle`, `engelleme_nedeni`, `uyelik_iptal`, `uyelik_iptal_nedeni`) 
			VALUES 
				(NULL, '".$gelen_id."', '".$demo_olacagi_tarih."', '".$grup."', '".$son_limit."', '".$hurda_teklif_yetkisi."', '".$yasak_sigorta."', '".$kalici_mesaj."', '".$kalici_sistem_mesaji."', '".$teklif_vermesini_engelle."', '".$uyeyi_engelleme_nedeni."', '".$uyelik_iptali."', '".$uyelik_iptal_nedeni."');
		");
		mysql_query("UPDATE teklif_limiti SET standart_limit = '".$son_limit2."',luks_limit = '".$son_limit3."' WHERE uye_id = '".$gelen_id."'");
    }else{
		mysql_query("UPDATE `uye_durumlari` SET `demo_olacagi_tarih` = '".$demo_olacagi_tarih."', `grup` = '".$grup."', 
			`teklif_limiti` = '".$son_limit."', `hurda_teklif` = '".$hurda_teklif_yetkisi."', 
			`yasak_sigorta` = '".$yasak_sigorta."', `kalici_mesaj` = '".$kalici_mesaj."', 
			`kalici_sistem_mesaji` = '".$kalici_sistem_mesaji."', `teklif_engelle` = '".$teklif_vermesini_engelle."', 
			`engelleme_nedeni` = '".$uyeyi_engelleme_nedeni."',`otomatik_teklif_engelle`='".$otomatik_risk_engelle."', `uyelik_iptal` = '".$uyelik_iptali."',
			`uyelik_iptal_nedeni` = '".$uyelik_iptal_nedeni."' WHERE `uye_durumlari`.`uye_id` = '".$gelen_id."';
		");
		mysql_query("UPDATE teklif_limiti SET standart_limit = '".$son_limit2."',luks_limit = '".$son_limit3."' WHERE uye_id = '".$gelen_id."'");
		$risk_cek = mysql_query("SELECT * FROM uye_durumlari WHERE uye_id = '".$gelen_id."'");
		while($risk_oku = mysql_fetch_array($risk_cek)){
			if($risk_oku['teklif_engelle']=="on"){
				mysql_query("UPDATE user SET risk = '2' WHERE id = '".$gelen_id."'");
			}elseif($risk_oku['uyelik_iptal']=="on"){
				mysql_query("UPDATE user SET risk = '3' WHERE id = '".$gelen_id."'");
			}else{
				mysql_query("UPDATE user SET risk = '1' WHERE id = '".$gelen_id."'");
			}
        } 
	}
	if($temsilci_degistirme_yetki == 1){
		mysql_query("UPDATE user SET temsilci_id = '".$yeni_temsilci_id."', paket = '".$grup."' WHERE id = '".$gelen_id."'");
	}
	echo '<script>localStorage.setItem("trigger","yetkiler")</script>';
	// header('Location: ?modul=uyeler&sayfa=uye_duzenle&id='.$gelen_id.'');
}

?>



