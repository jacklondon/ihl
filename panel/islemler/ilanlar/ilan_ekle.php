<?php
session_start();
$admin_id=$_SESSION['kid'];
$admin_cek=mysql_query("select * from kullanicilar where id='".$admin_id."'");
$admin_oku=mysql_fetch_object($admin_cek);
$admin_token=$admin_oku->token;

if (re('ilani') == "Kaydet")
{
	$hizli_kategori_id=re("hizli_kategori_id");
	// İhale acilis sütunu ihalenin başlayacağı tarihtir. ihale tarihi ve saati ihale bitiştir.
    $gelen_plaka = re('plaka');
    $plaka = strtoupper($gelen_plaka);
    $arac_kodu = re('arac_kodu');
    $hesaplama = re('hesaplama');
    $sigorta = re('sigorta');
    $marka = re('marka');
    $model = re('model');
    $tip = re('tip');
    $model_yili = re('model_yili');
	// $piyasa_degeri = re('piyasa_degeri');
    $tsrsb_degeri = re('tsrsb_degeri');
    $acilis_fiyati = re('acilis_fiyati');
    $profil = re('profil');
    $sehir = re('sehir');
    $ilce = re('ilce');
    $ihale_acilis = re('ihale_baslama');
    $ihale_tarihi = re('ihale_tarihi');
    $ihale_saati = re('ihale_saati');
    $pd_hizmet = re('pd_hizmet');
    $otopark_giris = re('otopark_giris');
    $otopark_ucreti = re('otopark_ucreti');
    $cekici_ucreti = re('cekici_ucreti');
    $dosya_masrafi = re('dosya_masrafi');
	$link = re('link');
    $kilometre = re('kilometre');
    $uyari_notu = re('uyari_notu');
    $hasar_bilgileri = re('hasar_bilgileri'); 
    $notlar = re('notlar');
    $yakit_tipi = re('yakit_tipi');
    $vites_tipi = re('vites_tipi');
	
    $donanimlar = re('donanimlar');
    $vitrin = re('vitrin');
    $arac_durumu = re('arac_turu');
    //$ihale_turu = re('ihale_turu');
    $bugun = date("Y.m.d");
	$add_time = date('Y-m-d H:i:s');
	$uyari="";

	if($sigorta=="" || $marka=="" || $model=="" || $ihale_tarihi=="" || $ihale_saati=="" ){
		$uyari=" * ile belirtilen alanlar boş bırakılamaz.";
	}else{
		if (empty($arac_kodu)){
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
		$sehir_cek = mysql_query("SELECT * FROM sehir WHERE sehirID = $sehir");
		while($sehir_oku = mysql_fetch_array($sehir_cek)){
			$son_sehir = $sehir_oku['sehiradi'];
		}
		
		/*
			if(re('il')!="" ){
				$adres = re('adres')." / ".$son_sehir;
			}else{
				$adres = re('adres');
			}
		*/
   
		$adres = re('adres');
		$sorgula=mysql_query("select * from sigorta_ozellikleri where id='".$sigorta."'");
		$sigr_cek=mysql_fetch_object($sorgula);
		$ihale_turu=$sigr_cek->ihale_tipi;
		if($pd_hizmet<=0){
			$pd_hizmet=0;
		}
		$ihale_zaman=$ihale_tarihi." ".$ihale_saati;
		if(date("Y-m-d H:i:s")<$ihale_zaman){
			$durum=1;
		}else{
			$durum=-1;
		}
		
		$y_trh=$ihale_tarihi." ".$ihale_saati.":00";
		$gosterilme_tarih=strtotime($y_trh)+300; //Gösterilme süresi 5 dk fazla olması istendi
		$gosterilme_tarih=date("Y-m-d H:i:s",$gosterilme_tarih);
		
		mysql_query("INSERT INTO `ilanlar` (`id`,`plaka`,`arac_kodu`,`hesaplama`,`sigorta`,`marka`,`model`,`tip`,`model_yili`,`piyasa_degeri`,`tsrsb_degeri`,`acilis_fiyati`,`son_teklif`,`profil`,`sehir`,`ilce`,
		`ihale_tarihi`,`ihale_saati`,`pd_hizmet`,`otopark_giris`,`otopark_ucreti`,`cekici_ucreti`,`dosya_masrafi`,`link`,`kilometre`,`uyari_notu`,`hasar_bilgileri`,`notlar`,`adres`,`donanimlar`,`vitrin`,
		`eklenme_zamani`,`ilan_url`,`ihale_sahibi`,`ihale_acilis`,`durum`,`ihale_turu`,`vites_tipi`,`yakit_tipi`,`arac_durumu`,`ihale_son_gosterilme`) VALUES (NULL,'$plaka','$arac_kodu','$hesaplama',
		'$sigorta','$marka','$model','$tip','$model_yili','','$tsrsb_degeri','$acilis_fiyati','$acilis_fiyati','$profil','$son_sehir','$ilce','$ihale_tarihi','$ihale_saati','$pd_hizmet','$otopark_giris',
		'$otopark_ucreti','$cekici_ucreti','$dosya_masrafi','$link','$kilometre','$uyari_notu','$hasar_bilgileri','$notlar','$adres', '$donanimlar','$vitrin','$add_time','$ad','$admin_token',
		'$ihale_acilis','$durum','$ihale_turu','$vites_tipi','$yakit_tipi','$arac_durumu','$gosterilme_tarih');");

		$son_id=mysql_query("Select * from ilanlar order by id desc limit 1");
		$son_id_cek=mysql_fetch_assoc($son_id);

		$veri_cek=$son_id_cek["id"];

		//$update=mysql_query("Update ilanlar set link='https://ihale.pertdunyasi.com/panel/sistem.php?modul=ilanlar&sayfa=ilan_ekle&id=$veri_cek' where id='".$veri_cek."'");

		/*
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
					$image = new SimpleImage();
					$image->load($yeni_ad);
					$image->resizeToWidth(1000);
					$image->save($yeni_ad);

					$sonu_cek = mysql_query("SELECT * FROM ilanlar WHERE plaka = '".$plaka."' AND arac_kodu = '".$arac_kodu."'
					AND profil = '".$profil."' AND model_yili = '".$model_yili."' AND sigorta = '".$sigorta."' 
					AND ihale_turu = '".$ihale_turu."' AND ihale_acilis = '".$ihale_acilis."' AND vitrin = '".$vitrin."'
					AND ilce = '".$ilce."' AND model = '".$model."' AND acilis_fiyati = '".$acilis_fiyati."'");
					while ($sonu_oku = mysql_fetch_array($sonu_cek))
					{
						$ihaleID = $sonu_oku['id'];
						mysql_query("INSERT INTO ilan_resimler (`id`,`ilan_id`,`resim`,`durum`) VALUES
						 (NULL, '" . $ihaleID . "', '" . $ad . "','0')");
					}
				}
			}
		}
		*/
		$cek = mysql_query("SELECT * FROM ilanlar WHERE plaka = '".$plaka."' AND arac_kodu = '".$arac_kodu."' AND profil = '".$profil."' AND model_yili = '".$model_yili."' AND sigorta = '".$sigorta."' 
		AND ihale_turu = '".$ihale_turu."' AND ihale_acilis = '".$ihale_acilis."' AND vitrin = '".$vitrin."' AND ilce = '".$ilce."' AND model = '".$model."' AND acilis_fiyati = '".$acilis_fiyati."'");
		while($oku = mysql_fetch_array($cek)){
			$ilan_id = $oku['id'];
			$hesap = $oku['hesaplama'];
			$sigorta = $oku['sigorta'];
			$sigorta_cek = mysql_query("SELECT * FROM sigorta_ozellikleri WHERE id = '".$sigorta."'"); 
			$sigorta_oku = mysql_fetch_assoc($sigorta_cek);
			$sigorta_id = $sigorta_oku['id'];
			$komisyon_cek = mysql_query("SELECT * FROM komisyon_oranlari WHERE sigorta_id = '".$sigorta_id."' LIMIT 1");
			while($komisyon_oku = mysql_fetch_array($komisyon_cek)){
				if($hesap == "Standart"){
					$ilk = $komisyon_oku['onbinde'];
					$komisyon = $ilk + $komisyon_oku['net'];
				}elseif($hesap == "Luks"){
					$ilk = $komisyon_oku['lux_onbinde']  ;
					$komisyon = $ilk + $komisyon_oku['lux_net'];
				}
				if($pd_hizmet == ""){
					mysql_query("INSERT INTO `ilan_komisyon` (`id`, `ilan_id`, `sigorta_id`, `toplam`, `ek1`, `ek2`, `ek3`, `ek4`) VALUES (NULL, '".$ilan_id."', '".$sigorta_id."', '".$komisyon."', '', '', '', '')");
				 }else{
					mysql_query("INSERT INTO `ilan_komisyon` (`id`, `ilan_id`, `sigorta_id`, `toplam`, `ek1`, `ek2`, `ek3`, `ek4`) VALUES (NULL, '".$ilan_id."', '".$sigorta_id."', '".$pd_hizmet."', '', '', '', '')");
				}
			}
			$markasini_getir = mysql_query("select * from marka where markaID = '".$oku['marka']."'");
			$markasini_yaz = mysql_fetch_assoc($markasini_getir);
			$markasi = $markasini_yaz['marka_adi'];
			$zaman = date("Y-m-d H:i:s");
			$ilan_aciklama = $model_yili." / ".$markasi." / ".$model." / ".$son_sehir." / ".$sigorta_oku['sigorta_adi'];
			mysql_query("INSERT INTO `yapilan_is` (`id`, `admin_id`, `yaptigi`, `aciklama`, `ekleme_zamani`,ilan_id,dogrudan_id,uye_id)
			VALUES 
			(NULL, '".$admin_id."', '1',  '$ilan_aciklama', '".$zaman."', '".$ilan_id."', '', '');");

			echo "<script>alert('İlan Eklendi')</script>";
			if($hizli_kategori_id>0){
				$hizli_kategori_resim=mysql_query("select * from hizli_ekle_resim where kat_id='".$hizli_kategori_id."' and durum=1 ");
				while($kategori_resim=mysql_fetch_object($hizli_kategori_resim)){
					$kaydet=mysql_query("insert into ilan_resimler (ilan_id,resim,durum) values ('".$ilan_id."','".$kategori_resim->resim."','1') ");
				}
				echo "<script>window.location.href = '?modul=ilanlar&sayfa=ilan_resim_ekle&id=$ilan_id'; </script>";
			}else{
				echo "<script>window.location.href = '?modul=ilanlar&sayfa=ilan_resim_ekle&id=$ilan_id'; </script>";
			}
			
		}
    }
}

?>
