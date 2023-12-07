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
    $bugun = date("Y.m.d");

    if (empty($arac_kodu))
    {
        $arac_kodu = md5(uniqid(mt_rand() , true));
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

    $dosya_adi = "";
    if (isset($_FILES['files']))
    { // dosya tanımlanmıs mı?
        $errors = array();
        foreach ($_FILES['files']['tmp_name'] as $key => $tmp_name)
        {
            $dosya_adi = $_FILES['files']['name'][$key]; // uzantiya beraber dosya adi
            $dosya_boyutu = $_FILES['files']['size'][$key]; // byte cinsinden dosya boyutu
            $dosya_gecici = $_FILES['files']['tmp_name'][$key]; //gecici dosya adresi
            $yenisim = md5(microtime()) . '.' . 'png'; //karmasik yeni isim.png
            if ($dosya_boyutu > 20971520)
            {
                $errors[] = 'Maksimum 20 Mb lık dosya yuklenebilir.';
            }
            $klasor = "img"; // yuklenecek dosyalar icin yeni klasor
            if (empty($errors) == true)
            { //eger hata yoksa
                if (is_dir("$klasor/" . $yenisim) == false)
                { //olusturdugumuz isimde dosya var mı?
                    move_uploaded_file($dosya_gecici, "$klasor/" . $yenisim); //yoksa yeni ismiyle kaydet
                    
                }
                else
                { //eger varsa
                    $new_dir = "$klasor/" . $yenisim . time(); //yeni ismin sonuna eklenme zamanını ekle
                    rename($dosya_gecici, $new_dir);
                }
            }
            else
            {
                print_r($errors); //varsa hataları yazdır
                
            }
        }

        $yol = $_SERVER['SERVER_NAME'] . '/tasarim/pert_dunyasi/uye_panel/img/' . $yenisim;

        if (empty($error))
        {
            if (re('id') != "")
            {
                mysql_query("UPDATE ilanlar SET plaka='$plaka', arac_kodu='$arac_kodu', hesaplama='$hesaplama',     
        sigorta='$sigorta', marka='$marka', model='$model', tip='$tip', model_yili='$model_yili',
        piyasa_degeri='$piyasa_degeri', tsrsb_degeri='$tsrsb_degeri', acilis_fiyati='$acilis_fiyati',
        profil='$profil', sehir='$sehir', ilce='$ilce', ihale_tarihi='$ihale_tarihi',
        ihale_saati='$ihale_saati', pd_hizmet='$pd_hizmet', otopark_giris='$otopark_giris',
        otopark_ucreti='$otopark_ucreti', cekici_ucreti='$cekici_ucreti',
        dosya_masrafi='$dosya_masrafi', link='$link', kilometre='$kilometre', 
        uyari_notu='$uyari_notu', hasar_bilgileri='$hasar_bilgileri', notlar='$notlar',
        adres='$adres', donanimlar='$donanimlar', ilan_url = '" . $yol . "'
        WHERE id='" . re('id') . "'");
                echo '<script>
         alert( "İlan Güncellendi");
         window.location.href="sistem.php?modul=dosya_yonetimi&sayfa=dosya_duzenle&id=' . re("id") . '";
         </script>';
            }
            else
            {

                mysql_query("INSERT INTO `ilanlar` (`id`,`plaka`,`arac_kodu`,`hesaplama`,`sigorta`,`marka`,`model`,
            `tip`,`model_yili`,`piyasa_degeri`,`tsrsb_degeri`,`acilis_fiyati`,`profil`,`sehir`,`ilce`,`ihale_tarihi`,
            `ihale_saati`,`pd_hizmet`,`otopark_giris`,`otopark_ucreti`,`cekici_ucreti`,`dosya_masrafi`,`link`,
            `kilometre`,`uyari_notu`,`hasar_bilgileri`,`notlar`,`adres`,`donanimlar`,`vitrin`,`eklenme_zamani`,
            `ilan_url`,`ihale_sahibi`,`ihale_kapanis`,`durum`) VALUES (NULL,'$plaka','$arac_kodu','$hesaplama',
            '$sigorta','$marka','$model','$tip','$model_yili','$piyasa_degeri','$tsrsb_degeri','$acilis_fiyati',
            '$profil','$sehir','$ilce','$ihale_tarihi','$ihale_saati','$pd_hizmet','$otopark_giris','$otopark_ucreti',
            '$cekici_ucreti','$dosya_masrafi','$link','$kilometre','$uyari_notu','$hasar_bilgileri','$notlar','$adres', 
            '$donanimlar','$vitrin','$bugun','$yol','','','1');");

            }
        }
    }

}

?>
