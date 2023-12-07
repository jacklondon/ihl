<?php 
   session_start();
    $token = $_SESSION['k_token'];
    if($token){
      $uye_token = $token;
    }
include '../../ayar.php';
?>

<?php 
if(re('dogrudan_satisi') == "Kaydet"){
    $sehir_getir = mysql_query("SELECT * FROM sehir");
    $gelen_plaka = re('plaka');
    $plaka = strtoupper($gelen_plaka);
    $arac_durumu = re('arac_durumu');
    $sehir = re('sehir');
    $ilce = re('ilce');
    $yakit_tipi = re('yakit_tipi');
    $vites_tipi = re('vites_tipi');
    $evrak_tipi = re('evrak_tipi');
    $marka = re('marka');
    $model = re('model');
    $model_yili = re('model_yili');
    $uzanti = re('uzanti');
    $kilometre = re('kilometre');
    $satis_fiyati = re('satis_fiyati');
    $aracin_adresi = re('aracin_adresi');
    $aciklamalar = re('aciklamalar');
    $arac_kodu = str_pad(mt_rand(1,99999999),8,'0',STR_PAD_LEFT);
    $bugun     =   date("Y.m.d");
    $saat = date("h:i:s");

    $hasar=$_POST["hasar"];
    $yetki_say=count($hasar);
    $hasar_array=array();            

    for($i=0;$i<$yetki_say;$i++)
    {
        array_push($hasar_array,$hasar[$i]);
    }
    
    $columns = implode(",",array_keys($hasar_array));
    $escaped_values = array_map('mysql_real_escape_string', array_values($hasar_array));
    $values  = implode("|", $hasar_array);

    $ilan_cek = mysql_query("SELECT * FROM dogrudan_satisli_ilanlar");
    while($ilan_oku = mysql_fetch_array($ilan_cek)){
        $db_plaka = $ilan_oku['plaka'];
    }
    if($db_plaka==$plaka){
        echo '<script>alert("Araç zaten kayıtlı. Lütfen plakayı düzgün giriniz !")</script>';
    }else{
        if($arac_durumu == 1){
            $arac_durumu = "Kazalı (En Ufak Bir Onarım Görmemiş)";
        }elseif($arac_durumu == 2){
            $arac_durumu = "Kazalı (Hafif onarımlar yapılmış halk ağzıyla makyajlı)";
        }elseif($arac_durumu == 3){
            $arac_durumu = "İkinci El (Pert Kayıtlı)";
        }elseif($arac_durumu == 4){
            $arac_durumu = "İkinci El (Pert Kayıtsız)";
        }
    
        $sehir_cek = mysql_query("SELECT * FROM sehir WHERE sehirID = $sehir");
        while($sehir_oku = mysql_fetch_array($sehir_cek)){
            $son_sehir = $sehir_oku['sehiradi'];
        }
        $marka_cek = mysql_query("SELECT * FROM marka WHERE markaID = $marka");
        while($marka_oku = mysql_fetch_array($marka_cek)){
            $son_marka = $marka_oku['marka_adi'];
        }
            mysql_query("INSERT INTO `dogrudan_satisli_ilanlar` 
            (`id`, `plaka`, `arac_kodu`, `bitis_tarihi`, `fiyat`, `aracin_durumu`, `sehir`, `ilce`, `marka`, `model`, 
            `model_yili`, `uzanti`, `kilometre`, `yakit_tipi`, `vites_tipi`, `evrak_tipi`, `hasar_durumu`, `aracin_adresi`,
             `aciklamalar`, `ilan_url`, `ilan_sahibi`, `eklenme_tarihi`, `eklenme_saati`, `durum`) VALUES 
             (NULL, '$plaka', '$arac_kodu', '', '$satis_fiyati', '$arac_durumu', '$son_sehir', '$ilce', '$son_marka', '$model', 
             '$model_yili', '$uzanti', '$kilometre', '$yakit_tipi', '$vites_tipi', '$evrak_tipi', '$values', 
             '$aracin_adresi', '$aciklamalar', '', '$uye_token', '$bugun', '$saat', 0);");

             $cek = mysql_query("select * from dogrudan_satisli_ilanlar where plaka = '".$plaka."' and arac_kodu = '".$arac_kodu."' and aracin_adresi = '".$aracin_adresi."' and aciklamalar = '".$aciklamalar."'");
             $oku = mysql_fetch_assoc($cek);

            header('Location: dogrudan_resim_ekle.php?id='.$oku["id"].'');
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
                mysql_query("INSERT INTO dogrudan_satisli_resimler (`id`,`ilan_id`,`resim`) VALUES (NULL, '" . $gelen_id . "', '" . $ad . "')");
            }
        }
    }
	   echo '<script>alert("Tebrikler ilan girişiniz yapıldı. Yönetici onayından sonra yayına alınacaktır")</script>';
	 echo '<script>window.location.href = "dogrudan_satisli_ilanlarim.php";</script>';
}





//     echo '<script>alert("Tebrikler ilan girişiniz yapıldı. Yönetici onayından sonra yayına alınacaktır")</script>';
//     echo '<script>window.location.href = "dogrudan_satisli_ilanlarim.php";</script>';


?>