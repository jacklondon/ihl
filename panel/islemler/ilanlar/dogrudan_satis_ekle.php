<?php 
session_start();
$admin_id=$_SESSION['kid'];
$admin_cek=mysql_query("select * from kullanicilar where id='".$admin_id."'");
$admin_oku=mysql_fetch_assoc($admin_cek);
$admin_token=$admin_oku['token'];
if(re('dogrudan_satisli_ilani')=="Kaydet"){
    $plaka          =       re('plaka');
    $arac_kodu      =       re('arac_kodu');
    $bitis_tarihi   =       re('yayin_bitis');
    $fiyat          =       re('fiyat');
    $aracin_durumu  =       re('aracin_durumu');
    $sehir          =       re('sehir');
    $ilce           =       re('ilce');
    $yakit_tipi     =       re('yakit_tipi');
    $vites_tipi     =       re('vites_tipi');
    $evrak_tipi     =       re('evrak_tipi');
    $aracin_adresi  =       re('aracin_adresi');
    $aciklamalar    =       re('aciklamalar'); 
    $marka          =       re('marka');
    $model          =       re('model');
    $model_yili     =       re('model_yili');
    $uzanti         =       re('uzanti');
    $kilometre      =       re('kilometre');
    $vitrin         =       re('vitrin');
	
	if($plaka =="" || $bitis_tarihi =="" || $model_yili =="" || $marka =="" || $model ==""  ){
		echo "<script>alert('(*) ile belirtilen alanlar boş bırakılamaz');</script>";
		echo "<script>window.location.href='?modul=ilanlar&sayfa=dogrudan_satis_ekle'</script>";
	}else{
		$sehir_cek = mysql_query("SELECT * FROM sehir WHERE sehirID = $sehir");
        while($sehir_oku = mysql_fetch_array($sehir_cek)){
            $son_sehir = $sehir_oku['sehiradi'];
        }
		
		$marka_cek = mysql_query("SELECT * FROM marka WHERE markaID = $marka");
        while($marka_oku = mysql_fetch_array($marka_cek)){
            $son_marka = $marka_oku['marka_adi'];
        }   
		
        if (empty($fiyat)){
            $fiyat = 1000;
        }
        if (empty($bitis_tarihi)){
            $bitis_tarihi = date("Y.m.d", strtotime('+30 days'));
        }

		if(empty($arac_kodu)){
			$arac_kodu = str_pad(mt_rand(1,99999999),8,'0',STR_PAD_LEFT);
		}
		
		$time = date('H:i:s');
		$day = date('Y-m-d');
		$hasar=$_POST["hasar"];
		$yetki_say=count($hasar);
		$hasar_array=array();            

		for($i=0;$i<$yetki_say;$i++){
			array_push($hasar_array,$hasar[$i]);
		}
    
		$columns = implode(",",array_keys($hasar_array));
		$escaped_values = array_map('mysql_real_escape_string', array_values($hasar_array));
		$values  = implode("|", $hasar_array);
	
		mysql_query("
			INSERT
				INTO
			`dogrudan_satisli_ilanlar` 
				(`id`,
				`plaka`,
				`arac_kodu`,
				`bitis_tarihi`,
				`fiyat`,
				`aracin_durumu`,
				`sehir`,
				`ilce`,
				`marka`,
				`model`,
				`model_yili`,
				`uzanti`,
				`kilometre`,
				`yakit_tipi`,
				`vites_tipi`,
				`evrak_tipi`,
				`hasar_durumu`,
				`aracin_adresi`,
				`aciklamalar`,
				`ilan_url`,
				`ilan_sahibi`,
				`eklenme_tarihi`,
				`eklenme_saati`,
				`vitrin`,
				`durum`,
				`panelden_eklenme`)
			VALUES 
				(NULL,
				'$plaka',
				'$arac_kodu',
				'$bitis_tarihi',
				'$fiyat',
				'$aracin_durumu',
				'$son_sehir',
				'$ilce',
				'$son_marka',
				'$model',
				'$model_yili',
				'$uzanti',
				'$kilometre',
				'$yakit_tipi',
				'$vites_tipi',
				'$evrak_tipi',
				'$values',
				'$aracin_adresi',
				'$aciklamalar',
				'',
				'".$admin_token."',
				'$day',
				'$time',
				'$vitrin',
				1,
				1);
		");

		/*if ($_FILES['resim']['name'] != ""){
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
					$sonu_cek = mysql_query("SELECT * FROM dogrudan_satisli_ilanlar WHERE plaka = '".$plaka."' AND
					arac_kodu = '".$arac_kodu."' AND fiyat = '".$fiyat."' AND sehir = '".$son_sehir."' AND ilce = '".$ilce."'");
					while ($sonu_oku = mysql_fetch_array($sonu_cek))
					{
						$ihaleID = $sonu_oku['id'];
						mysql_query("INSERT INTO dogrudan_satisli_resimler (`id`,`ilan_id`,`resim`) VALUES 
						(NULL, '" . $ihaleID . "', '" . $ad . "')");
					}
				}
			}
		}*/
		$cek = mysql_query("SELECT * FROM dogrudan_satisli_ilanlar WHERE plaka = '".$plaka."' AND
			arac_kodu = '".$arac_kodu."' AND fiyat = '".$fiyat."' AND sehir = '".$son_sehir."' AND ilce = '".$ilce."'");
		$oku = mysql_fetch_assoc($cek);
			$zaman = date("Y-m-d H:i:s");
			$ilan_aciklama = $model_yili." ".$marka." ".$model." ".$son_sehir." ".$sigorta;
			mysql_query("INSERT INTO `yapilan_is` (`id`, `admin_id`, `yaptigi`, `aciklama`, `ekleme_zamani`,ilan_id,dogrudan_id,uye_id) 
			VALUES 
			(NULL, '".$admin_id."', '1',  '$ilan_aciklama', '".$zaman."', '".$oku['id']."', '', '');");			
		
		echo "<script>alert('İlan başarıyla eklendi');</script>";
		echo "<script>window.location.href = '?modul=ilanlar&sayfa=dogrudan_resim_ekle&id=".$oku['id']."'; </script>";
	}

}
?>