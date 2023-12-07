<?php
if (re('ilani') == "Kaydet")
{

    $gelen_plaka = re('plaka');
    $plaka = strtoupper($gelen_plaka);
    $arac_kodu = re('arac_kodu');
    $hesaplama = re('hesaplama');
    $sigorta = re('sigorta');
    $marka = re('marka');
    $model = re('model');
    $tip = re('tip');
    $model_yili = re('model_yili');
    $piyasa_degeri = re('piyasa_degeri');
    $tsrsb_degeri = re('tsrsb_degeri');
    $acilis_fiyati = re('acilis_fiyati');
    $profil = re('profil');
    $sehir = re('sehir');
    $ilce = re('ilce');
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
    $adres = re('adres');
    $donanimlar = re('donanimlar');
    $vitrin = re('vitrin');
    $ihale_turu = re('ihale_turu');
    $bugun = date("Y.m.d");

    $kac_adet = re('adet');

    if (empty($arac_kodu))
    {
        $arac_kodu = str_pad(mt_rand(1,99999999),8,'0',STR_PAD_LEFT);
    }
    if (empty($acilis_fiyati))
    {
        $acilis_fiyati = 1000;
    }
    if (empty($ihale_tarihi))
    {
        $ihale_tarihi = date("Y.m.d", strtotime('+1 days'));
    }
    if (empty($ihale_saati))
    {
        $ihale_saati = date('H:i', strtotime("10:00"));
    }

    
    for($a=0; $a<$kac_adet; $a++){
    $sehir_cek = mysql_query("SELECT * FROM sehir WHERE sehirID = $sehir");
    $sehir_oku=mysql_fetch_assoc($sehir_cek);
    $son_sehir=$sehir_oku["sehir_adi"];


mysql_query("INSERT INTO `ilanlar` (`id`, `plaka`, `arac_kodu`, `hesaplama`, `sigorta`, `marka`, `model`, 
`tip`, `model_yili`, `piyasa_degeri`, `tsrsb_degeri`, `acilis_fiyati`, `son_teklif`, `profil`, `sehir`, 
 `ilce`, `ihale_tarihi`, `ihale_saati`, `pd_hizmet`, `otopark_giris`, `otopark_ucreti`, 
 `cekici_ucreti`, `dosya_masrafi`, `link`, `kilometre`, `uyari_notu`, `hasar_bilgileri`, 
 `notlar`, `adres`, `donanimlar`, `vitrin`, `eklenme_zamani`, `ilan_url`, `ihale_sahibi`, 
 `ihale_acilis`, `durum`, `ihale_turu`, `vites_tipi`, `yakit_tipi`) 
 VALUES (NULL, '".$plaka."', '".$arac_kodu."', '".$hesaplama."', '".$sigorta."', '".$marka."', '".$model."', 
 '".$tip."', '".$model_yili."', '".$piyasa_degeri."', '".$tsrsb_degeri."', '".$acilis_fiyati."', '".$acilis_fiyati."', 
 '".$profil."', '".$son_sehir."', '".$ilce."', 
 '".$ihale_tarihi."', '".$ihale_saati."', '".$pd_hizmet."', '".$otopark_giris."', '".$otopark_ucreti."', 
 '".$cekici_ucreti."', '".$dosya_masrafi."', '".$link."', '".$kilometre."', '".$uyari_notu."', 
 '".$hasar_bilgileri."', '".$notlar."', '".$adres."', '".$donanimlar."', '".$vitrin."', '".$bugun."', 
 '".$ad."', '', '', '1', '".$ihale_turu."', '', '');");
    }

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
                AND ihale_turu = '".$ihale_turu."' AND profil = '".$profil."' AND model_yili = '".$model_yili."' AND 
                tsrsb_degeri = '".$tsrsb_degeri."' AND  ihale_tarihi = '".$ihale_tarihi."' AND hesaplama = '".$hesaplama."' AND
                sigorta = '".$sigorta."' AND pd_hizmet = '".$pd_hizmet."'");
                while($sonu_oku = mysql_fetch_array($sonu_cek)){                
                $ihaleID = $sonu_oku['id'];            
                mysql_query("INSERT INTO ilan_resimler (`ilan_id`,`resim`) VALUES ('" . $ihaleID . "', '" . $ad . "')");
                }
              

            }  
        }
    }
}


?>
