<?php 
$gelen_id=re("id"); 
session_start();
$admin_id=$_SESSION['kid'];
$admin_yetki_cek=mysql_query("Select * from kullanicilar where id='".$admin_id."' ");
$admin_yetki_oku=mysql_fetch_assoc($admin_yetki_cek);

$yetkiler=$admin_yetki_oku["yetki"];

$yetki_parcala=explode("|",$yetkiler);
if(re('guncellemeyi')=="Kaydet"){ 
	if (!in_array(1, $yetki_parcala)) { 
		echo '<script>alert("İlan düzenleme Yetkiniz Yoktur")</script>';
		echo "<script>window.location.href = '?modul=ilanlar&sayfa=ilan_ekle&id=".$gelen_id."'</script>";
	}else{
    $gelen_plaka        =   re('plaka');
    $plaka              =   strtoupper($gelen_plaka);
    $arac_kodu          =   re('arac_kodu');
    $hesaplama          =   re('hesaplama');
    $sigorta            =   re('sigorta');
    $marka              =   re('marka');
    $model              =   re('model'); 
    $tip                =   re('tip');
    $model_yili         =   re('model_yili');
    //$piyasa_degeri      =   re('piyasa_degeri');
    $tsrsb_degeri       =   re('tsrsb_degeri');
    $acilis_fiyati      =   re('acilis_fiyati');
    $profil             =   re('profil');
    $sehir              =   re('sehir');
    $ilce               =   re('ilce');
    $vites_tipi         =   re('vites_tipi');
	$yakit_tipi         =   re('yakit_tipi');
    // $ihale_acilis       =   re('ihale_baslama');
    $ihale_tarihi       =   re('ihale_tarihi');
    $ihale_saati        =   re('ihale_saati');
    $pd_hizmet          =   re('pd_hizmet');
    $otopark_giris      =   re('otopark_giris');
    $otopark_ucreti     =   re('otopark_ucreti');
    $cekici_ucreti      =   re('cekici_ucreti');
    $dosya_masrafi      =   re('dosya_masrafi');
    $link               =   re('link');
    $kilometre          =   re('kilometre');
    $uyari_notu         =   re('uyari_notu');
    $hasar_bilgileri    =   re('hasar_bilgileri');
    $notlar             =   re('notlar');
    $adres              =   re('adres');
	$donanimlar         =   re('donanimlar');
    $vitrin             =   re('vitrin');
	$ilan_yayin         =   re('yayinda');
	$arac_durumu         =   re('arac_turu');
	if($arac_durumu == ""){
		$arac_durumu = 0;
	}

	

    //$ihale_turu         =   re('ihale_turu');
	if($pd_hizmet=="Otomatik Hesaplama"){
		$pd_hizmet="";
	}

    $bugun              =   date("Y.m.d");
	if($sigorta=="" || $marka=="" || $model=="" || $ihale_tarihi=="" || $ihale_saati=="" ){
		$uyari=" * ile belirtilen alanlar boş bırakılamaz.";
	}else{
		if (empty($arac_kodu))
		{
			$ilan_cek=mysql_query("select * from ilanlar");
			$a="true";
			$arac_kodu = str_pad(mt_rand(1,99999999),8,'0',STR_PAD_LEFT);
			while($a=="true"){
				$arac_kodu = str_pad(mt_rand(1,99999999),8,'0',STR_PAD_LEFT);
				while($ilan_oku=mysql_fetch_array($ilan_cek)){
					if($ilan_oku["arac_kodu"]==$arac_kodu){
						$arac_kodu = str_pad(mt_rand(1,99999999),8,'0',STR_PAD_LEFT);
					}else{
						$a="false";
					}
				}
			}
		}
		if (empty($acilis_fiyati))
		{
			$acilis_fiyati = 1000;
		}
		if (empty($ihale_tarihi))
		{
			$ihale_tarihi = date("Y.m.d", strtotime('+7 days'));
		}
		if (empty($ihale_saati))
		{
			$ihale_saati = date('H:i', strtotime("10:00"));
		}
		if($ilan_yayin=="")
		{
			$ilan_durum=-3;
		}else {
			$ilan_durum=1;
		}
		$sehir_cek = mysql_query("SELECT * FROM sehir WHERE sehirID = $sehir");
		$sehir_oku = mysql_fetch_assoc($sehir_cek);
		$son_sehir = $sehir_oku['sehiradi'];
		$sorgula=mysql_query("select * from sigorta_ozellikleri where id='".$sigorta."'");
		$sigr_cek=mysql_fetch_object($sorgula);
		$ihale_turu=$sigr_cek->ihale_tipi;  
		
		$y_trh=$ihale_tarihi." ".$ihale_saati.":00";
		$gosterilme_tarih=strtotime($y_trh)+300; //Gösterilme süresi 5 dk fazla olması istendi
		$gosterilme_tarih=date("Y-m-d H:i:s",$gosterilme_tarih);
		
		$sql_ilan=mysql_query("SELECT * FROM ilanlar WHERE id='".$gelen_id."'");
		$fetch_ilan=mysql_fetch_assoc($sql_ilan);
		
		$yeni_marka_sql=mysql_query("SELECT * FROM marka WHERE markaID='".$marka."'");
		$yeni_marka_fetch=mysql_fetch_assoc($yeni_marka_sql);
	
		
		$arac_text=$model_yili." ".$yeni_marka_fetch["marka_adi"]." ".$model." ".$tip." / ".$son_sehir." / ".$profil;
		$cayma_cek=mysql_query("SELECT * FROM cayma_bedelleri WHERE arac_kod_plaka='".$fetch_ilan["arac_kodu"]."' or arac_kod_plaka='".$fetch_ilan["plaka"]."'");
		while($cayma_oku=mysql_fetch_array($cayma_cek)){
			if($cayma_oku["arac_kod_plaka"]==$fetch_ilan["plaka"]){
				$arac_kod_plaka=$plaka;
			}else{
				$arac_kod_plaka=$arac_kodu;
			}
			$cayma_update=mysql_query("UPDATE cayma_bedelleri SET arac_detay='".$arac_text."', arac_kod_plaka='".$arac_kod_plaka."' WHERE id='".$cayma_oku["id"]."'");
		}
		
		$teklif_cek = mysql_query("select * from teklifler where ilan_id = '".$gelen_id."'");
		if(mysql_num_rows($teklif_cek) == 0){
			mysql_query("update ilanlar set son_teklif = '".$acilis_fiyati."' where id = '".$gelen_id."'");
		}
		
		// `durum` ='".$ilan_durum."',
		
		mysql_query("UPDATE `ilanlar` SET 
		`plaka` = '".$plaka."', 
		`arac_kodu` = '".$arac_kodu."', 
		`hesaplama` = '".$hesaplama."', 
		`sigorta` = '".$sigorta."', 
		`marka` = '".$marka."', 
		`model` = '".$model."', 
		`tip` = '".$tip."', 
		`model_yili` = '".$model_yili."', 
		`tsrsb_degeri` = '".$tsrsb_degeri."', 
		`acilis_fiyati` = '".$acilis_fiyati."', 
		`profil` = '".$profil."', 
		`sehir` = '".$son_sehir."', 
		`ilce` = '".$ilce."', 
		`ihale_tarihi` = '".$ihale_tarihi."', 
		`ihale_saati` = '".$ihale_saati."', 
		`pd_hizmet` = '".$pd_hizmet."', 
		`otopark_giris` = '".$otopark_giris."', 
		`otopark_ucreti` = '".$otopark_ucreti."', 
		`cekici_ucreti` = '".$cekici_ucreti."', 
		`dosya_masrafi` = '".$dosya_masrafi."', 
		`link` = '".$link."', 
		`kilometre` = '".$kilometre."', 
		`uyari_notu` = '".$uyari_notu."', 
		`hasar_bilgileri` = '".$hasar_bilgileri."', 
		`notlar` = '".$notlar."', 
		`adres` = '".$adres."', 
		`donanimlar` = '".$donanimlar."', 
		`vitrin` = '".$vitrin."',    
		`ihale_turu` = '".$ihale_turu."',
		`vites_tipi` ='".$vites_tipi."',
		`yakit_tipi` ='".$yakit_tipi."',
		`arac_durumu` ='".$arac_durumu."',
		`ihale_son_gosterilme`='".$gosterilme_tarih."'
		WHERE ilanlar.id = '".$gelen_id."'");
		// var_dump("UPDATE `ilanlar` SET 
		// `plaka` = '".$plaka."', 
		// `arac_kodu` = '".$arac_kodu."', 
		// `hesaplama` = '".$hesaplama."', 
		// `sigorta` = '".$sigorta."', 
		// `marka` = '".$marka."', 
		// `model` = '".$model."', 
		// `tip` = '".$tip."', 
		// `model_yili` = '".$model_yili."', 
		// `piyasa_degeri` = '".$piyasa_degeri."', 
		// `tsrsb_degeri` = '".$tsrsb_degeri."', 
		// `acilis_fiyati` = '".$acilis_fiyati."', 
		// `profil` = '".$profil."', 
		// `sehir` = '".$son_sehir."', 
		// `ilce` = '".$ilce."', 
		// `ihale_acilis` = '".$ihale_acilis."', 
		// `ihale_tarihi` = '".$ihale_tarihi."', 
		// `ihale_saati` = '".$ihale_saati."', 
		// `pd_hizmet` = '".$pd_hizmet."', 
		// `otopark_giris` = '".$otopark_giris."', 
		// `otopark_ucreti` = '".$otopark_ucreti."', 
		// `cekici_ucreti` = '".$cekici_ucreti."', 
		// `dosya_masrafi` = '".$dosya_masrafi."', 
		// `link` = '".$link."', 
		// `kilometre` = '".$kilometre."', 
		// `uyari_notu` = '".$uyari_notu."', 
		// `hasar_bilgileri` = '".$hasar_bilgileri."', 
		// `notlar` = '".$notlar."', 
		// `adres` = '".$adres."', 
		// `donanimlar` = '".$donanimlar."', 
		// `vitrin` = '".$vitrin."',    
		// `ihale_turu` = '".$ihale_turu."',
		// `durum` ='".$ilan_durum."',
		// `vites_tipi` ='".$vites_tipi."',
		// `yakit_tipi` ='".$yakit_tipi."',
		// `arac_durumu` ='".$arac_durumu."',
		// `ihale_son_gosterilme`='".$gosterilme_tarih."'
		// WHERE ilanlar.id = '".$gelen_id."'");
		
		if($dosya_masrafi == "" || $dosya_masrafi == 0){
			$dosya_masrafi_statu = 0;
		}else{
			$dosya_masrafi_statu = $dosya_masrafi;
		}

		mysql_query("update kazanilan_ilanlar set dosya_masrafi = '".$dosya_masrafi_statu."' where ilan_id = '".$gelen_id."'");
		
		if ($_FILES['resim']['name'] != "")
		{
			include ('simpleimage.php');
			$dosya_sayi = count($_FILES['resim']['name']);
			for ($i = 0;$i < $dosya_sayi;$i++)
			{
				if (!empty($_FILES['resim']['name'][$i]))
				{
					$dosya_adi = $_FILES["resim"]["name"][$i];
					$dizim = array("iz","et","se","du","yr","nk");
					$uzanti = substr($dosya_adi, -4, 4);
					$rasgele = rand(1, 1000000);
					$ad = $dizim[rand(0, 5) ] . $rasgele . ".png";
					$yeni_ad = "../images/" . $ad;
					move_uploaded_file($_FILES["resim"]['tmp_name'][$i], $yeni_ad);
					copy($yeni_ad, $k_ad);
					$image = new SimpleImage();
					$image->load($yeni_ad);
					$image->resizeToWidth(1000);
					$image->save($yeni_ad);
					$sonu_cek = mysql_query("SELECT * FROM ilanlar WHERE id= '".$gelen_id."'");
					while ($sonu_oku = mysql_fetch_array($sonu_cek))
					{
						$ihaleID = $sonu_oku['id'];
						mysql_query("INSERT INTO ilan_resimler (`id`,`ilan_id`,`resim`) VALUES (NULL, '" . $ihaleID . "', '" . $ad . "')");
					}
				}
			}
		}
		echo "<script>alert('İlan Güncellendi')</script>";
		echo "<script>window.location.href = '?modul=ilanlar&sayfa=ilan_ekle&id=$gelen_id'; </script>";
		//header("Location:?modul=ilanlar&sayfa=ilan_ekle&id=$gelen_id");
	}	
}
}
if(re('resimleri')=="Ekle"){
	if (!in_array(1, $yetki_parcala)) { 
		echo '<script>alert("İlan düzenleme Yetkiniz Yoktur")</script>';
		echo "<script>window.location.href = '?modul=ilanlar&sayfa=ilan_resim_ekle&id=".$gelen_id."'</script>";
	}else{
		if ($_FILES['resim']['name'] != ""){
			include ('simpleimage.php');
			$dosya_sayi = count($_FILES['resim']['name']);
			for ($i = 0;$i < $dosya_sayi;$i++)
			{
				if (!empty($_FILES['resim']['name'][$i]))
				{
					$dosya_adi = $_FILES["resim"]["name"][$i];
					$dizim = array("iz","et","se","du","yr","nk");
					$uzanti = substr($dosya_adi, -4, 4);
					$rasgele = rand(1, 1000000);
					$ad = $dizim[rand(0, 5) ] . $rasgele . ".png";
					$yeni_ad = "../images/" . $ad;
					move_uploaded_file($_FILES["resim"]['tmp_name'][$i], $yeni_ad);
					copy($yeni_ad, $k_ad);
					$image = new SimpleImage();
					$image->load($yeni_ad);
					$image->resizeToWidth(1000);
					$image->save($yeni_ad);
					$sonu_cek = mysql_query("SELECT * FROM ilanlar WHERE id= '".$gelen_id."'");
					while ($sonu_oku = mysql_fetch_array($sonu_cek)){
						$ihaleID = $sonu_oku['id'];
						mysql_query("INSERT INTO ilan_resimler (`id`,`ilan_id`,`resim`) VALUES (NULL, '" . $ihaleID . "', '" . $ad . "')");
					}
				}
			}
		}
		header("Location:?modul=ilanlar&sayfa=ilan_resim_ekle&id=$gelen_id"); 
	}
 }
if(re('smsi')=="Tekrar Sms Gönder"){
    mysql_query("UPDATE kazanilanlar SET mtv = '".re('mtv')."' WHERE ilan_id = '".$gelen_id."'");
    header("Location:?modul=ilanlar&sayfa=ilan_ekle&id=$gelen_id");
}
if(re('statu_bilgilerini')=="Kaydet"){  
	if (!in_array(3, $yetki_parcala)) { 
		echo '<script>alert("Statü tanımlanma Yetkiniz Yoktur")</script>';
		echo "<script>window.location.href = '?modul=ilanlar&sayfa=ilan_ekle&id=".$gelen_id."'</script>";
	}else{
		if(re("teklifler")!=""){
			$teklif_getir=mysql_query("select * from teklifler id='".re("teklifler")."'");
			$teklif_cek=mysql_fetch_object($teklif_getir);
			$uye_id=$teklif_cek->uye_id;
		}else{
			$uye_id=re("serbest_secim");
		}
		

		$user_cek = mysql_query("SELECT * FROM user WHERE id = '".re('teklifler')."'");
		$user_oku = mysql_fetch_assoc($user_cek);
		$user_token = $user_oku['user_token'];
		
		$ilan_cek=mysql_query("select * from ilanlar where id='".$gelen_id."'");
		$ilan_oku=mysql_fetch_object($ilan_cek);
		
		if($ilani_oku['pd_hizmeti']=="" || $ilani_oku['pd_hizmeti']==0 ){
		
			$teklifler_cek=mysql_query("select * from teklifler where uye_id='".$uye_id."' and ilan_id='".$gelen_id."' order by teklif desc limit 1 ");
			$teklifler_oku=mysql_fetch_object($teklifler_cek);
			if(mysql_num_rows($teklifler_cek)!=0){
				$pd_hizmeti=$teklifler_oku->hizmet_bedeli;
			}else{
				$pd_hizmeti=$ilani_oku['pd_hizmeti'];
			}

			
		}else{
			$pd_hizmeti=$ilani_oku['pd_hizmeti'];
		}
		
		
	   // $pd_hizmet = re('pd_hizmet');
		$arac_bedeli = re('arac_bedeli');
		$eft = re('eft_ile_odenecek');
		$nakit = re('nakit_odenecek');
		$mtvli_cek = mysql_query("SELECT * FROM kazanilanlar WHERE ilan_id = '".$gelen_id."' ");
		$mtvli_oku = mysql_fetch_assoc($mtvli_cek);
		$mtv = $mtvli_oku['statu'];
		$noter_cek = mysql_query("SELECT * FROM odeme_mesaji");
		$noter_oku = mysql_fetch_assoc($noter_cek);
		$noter_ucreti = $noter_oku['noter_takipci_gideri'];
		$toplam_tutar = re('kazandigi_tutar') + $pd_hizmeti + re('dosya_masrafi') + $noter_ucreti + $arac_bedeli ;
		if(re("statu_bilgileri")=="1"){
			$son_odeme_tarihi=re("son_odeme_tarihi");
		}else{
			$son_odeme_tarihi="";
		}
		if(re('teklifler')){
		mysql_query("UPDATE kazanilanlar SET uye_id = '".re('teklifler')."' , kazanilan_tutar = '".re('kazandigi_tutar')."',
		durum = '".re('statu_bilgileri')."', aciklama = '".re('aciklama')."', son_odeme_tarihi = '".$son_odeme_tarihi."',
		toplam = '".$toplam_tutar."', eft_ile_odenecek = '".re('eft_ile_odenecek')."',
		nakit_odenecek = '".re('nakit_odenecek')."', user_token = '".$user_token."',
		kazanilan_tutar = '".re('kazandigi_tutar')."', arac_bedeli_fatura = '".re('arac_bedeli')."' 
		WHERE ilan_id = '".$gelen_id."'");
		header("Location:?modul=ilanlar&sayfa=ilan_ekle&id=$gelen_id");
		}elseif(re('serbest_secim')){
		mysql_query("UPDATE kazanilanlar SET uye_id = '".re('serbest_secim')."' , kazanilan_tutar = '".re('kazandigi_tutar')."',
		durum = '".re('statu_bilgileri')."', aciklama = '".re('aciklama')."', son_odeme_tarihi = '".$son_odeme_tarihi."',
		toplam = '".$toplam_tutar."', eft_ile_odenecek = '".re('eft_ile_odenecek')."',
		nakit_odenecek = '".re('nakit_odenecek')."', user_token = '".$user_token."', 
		kazanilan_tutar = '".re('kazandigi_tutar')."', arac_bedeli_fatura = '".re('arac_bedeli')."' 
		 WHERE ilan_id = '".$gelen_id."'");
		}
		
	}
}
?>