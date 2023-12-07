<?php 
	session_start();
    $token = $_SESSION['k_token'];
    if($token){
		$uye_token = $token;
    }
	include '../../ayar.php';
?>
<?php 
	if(re('ihaleyi') == "Kaydet"){
		$sehir_getir = mysql_query("SELECT * FROM sehir");
		$gelen_plaka = ucwords(re('plaka'));
		$plaka = strtoupper($gelen_plaka);
		$arac_durumu = re('arac_durumu');
		$marka = re('marka');
		$model = re('model');
		$uzanti = re('uzanti');
		$model_yili = re('model_yili');
		$satis_fiyati = re('satis_fiyati');
		$sehir = re('sehir');
		//$ilce = re('ilce');
		$evrak_tipi = re('evrak_tipi');
		$yakit_tipi = re('yakit_tipi');
		$vites_tipi = re('vites_tipi');
		$kilometre = re('kilometre');
		$uyari_notu = re('uyari_notu');
		$aracin_adresi = re('aracin_adresi');
		$hasar_durumu = re('hasar_durumu');
		$notlar = re('notlar');
		$arac_kodu = str_pad(mt_rand(1,99999999),8,'0',STR_PAD_LEFT);
		$bugun     =   date("Y.m.d");
		$saat = date("h:i:s");
		$eklenme_tarihi = $bugun . " " . $saat;
		$add_time = date('Y-m-d H:i:s');
		$ilan_cek = mysql_query("SELECT * FROM ilanlar");
		while($ilan_oku = mysql_fetch_array($ilan_cek)){
			$db_plaka = $ilan_oku['plaka'];
		}
		if($db_plaka==$plaka){
			echo '<script>alert("Araç zaten kayıtlı. Lütfen plakayı düzgün giriniz !")</script>';
			echo'<script> location.reload();</script>';
		} else {
			if($arac_durumu == 1){
				//$arac_durumu = "Kazalı (En Ufak Bir Onarım Görmemiş)";
			}elseif($arac_durumu == 2){
				//$arac_durumu = "Kazalı (Hafif onarımlar yapılmış halk ağzıyla makyajlı)";
			}elseif($arac_durumu == 3){
				//$arac_durumu = "İkinci El (Pert Kayıtlı)";
			}elseif($arac_durumu == 4){
				//$arac_durumu = "İkinci El (Pert Kayıtsız)";
			}
		
			$sehir_cek = mysql_query("SELECT * FROM sehir WHERE sehirID = $sehir");
			while($sehir_oku = mysql_fetch_array($sehir_cek)){
				$son_sehir = $sehir_oku['sehiradi'];
			}
			$marka_cek = mysql_query("SELECT * FROM marka WHERE markaID = $marka");
			while($marka_oku = mysql_fetch_array($marka_cek)){
				$son_marka = $marka_oku['marka_adi'];
			}
			$sorgula=mysql_query("select * from sigorta_ozellikleri where id='1'");
			$sigr_cek=mysql_fetch_object($sorgula);
			$ihale_turu=$sigr_cek->ihale_tipi; 
			mysql_query("
				INSERT INTO `ilanlar`
					(`id`,
					`plaka`, 
					`arac_kodu`,
					`hesaplama`,
					`sigorta`,
					`marka`,
					`model`, 
					`tip`,
					`model_yili`, 
					`piyasa_degeri`, 
					`tsrsb_degeri`, 
					`acilis_fiyati`, 
					`son_teklif`, 
					`profil`, 
					`sehir`, 
					`ilce`, 
					`ihale_tarihi`, 
					`ihale_saati`, 
					`pd_hizmet`, 
					`otopark_giris`, 
					`otopark_ucreti`, 
					`cekici_ucreti`, 
					`dosya_masrafi`, 
					`link`, 
					`kilometre`, 
					`uyari_notu`, 
					`hasar_bilgileri`, 
					`notlar`, `adres`, 
					`donanimlar`, 
					`vitrin`, 
					`eklenme_zamani`, 
					`ilan_url`, 
					`ihale_sahibi`, 
					`ihale_acilis`, 
					`durum`, 
					`ihale_turu`, 
					`vites_tipi`, 
					`yakit_tipi`,
					`arac_durumu`
					) 
				VALUES 
					(NULL, 
					'".ucwords(re('plaka'))."', 
					'$arac_kodu',
					'Standart', 
					'1', 
					'".re('marka')."', 
					'".re('model')."', 
					'".re('uzanti')."', 
					'".re('model_yili')."', 
					'', 
					'', 
					'".re('satis_fiyati')."', 
					'".re('satis_fiyati')."', 
					'".re('evrak_tipi')."', 
					'".$son_sehir."',
					'', 
					'',
					'', 
					'',
					'',
					'', 
					'', 
					'', 
					'', 
					'".re('kilometre')."', 
					'".re('uyari_notu')."', 
					'".re('hasar_bilgileri')."',
					'".re('notlar')."', 
					'".re('aracin_adresi')."', 
					'', 
					'',
					'$add_time', 
					'',
					'$uye_token', 
					'', 
					'0', 
					'".$ihale_turu."', 
					'".$vites_tipi."', 
					'".$yakit_tipi."',
					'".$arac_durumu."'
					)"
			);

			
			  
    $cek = mysql_query("SELECT * FROM ilanlar WHERE plaka = '".$plaka."' AND arac_kodu = '".$arac_kodu."'");
    $oku = mysql_fetch_assoc($cek);
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
            mysql_query("INSERT INTO `ilan_komisyon` (`id`, `ilan_id`, `sigorta_id`, `toplam`, `ek1`, `ek2`, `ek3`, `ek4`) 
            VALUES (NULL, '".$ilan_id."', '".$sigorta_id."', '".$komisyon."', '', '', '', '')");
         }else{
            mysql_query("INSERT INTO `ilan_komisyon` (`id`, `ilan_id`, `sigorta_id`, `toplam`, `ek1`, `ek2`, `ek3`, `ek4`) 
            VALUES (NULL, '".$ilan_id."', '".$sigorta_id."', '".$pd_hizmet."', '', '', '', '')");
         }
    }    
    header('Location: ihale_resim_ekle.php?id='.$oku["id"].'');
    }
}

if(re('resimleri')=="Kaydet"){
    $gelen_id = re('id');
    if ($_FILES['resim']['name'] != "")
{
    include ('../simpleimage.php');
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

            $sonu_cek = mysql_query("SELECT * FROM ilanlar ORDER BY id DESC LIMIT 1");
            while ($sonu_oku = mysql_fetch_array($sonu_cek))
            {
                $ihaleID = $sonu_oku['id'];
                mysql_query("INSERT INTO ilan_resimler (`id`,`ilan_id`,`resim`) VALUES (NULL, '" . $gelen_id . "', '" . $ad . "')");
                echo '<script>alert("Tebrikler ilan girişiniz yapıldı. Yönetici onayından sonra yayına alınacaktır")</script>';
                echo '<script>window.location.href = "ihaledeki_ilanlarim.php";</script>';
            }
        }
    }
}
}

?>