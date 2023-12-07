<?php 
    $gelen_id=re("id");    
    if(re('dogrudan_satisli_ilani')=="Kaydet"){ 
        $hasarlar=$_POST["hasar_durumu"];
        $hasar_say=count($hasarlar);
        $hasarlar_array=array();            
        for($i=0;$i<$hasar_say;$i++){
            array_push($hasarlar_array,$hasarlar[$i]);
        }
        $columns = implode(",",array_keys($hasarlar_array));
        $escaped_values = array_map('mysql_real_escape_string', array_values($hasarlar_array));
        $values  = implode("|", $hasarlar_array);
		if(re('plaka') =="" || re('yayin_bitis') =="" || re('model_yili') =="" || re('dogrudan_marka') =="" || re('dogrudan_model') ==""  ){
			echo "<script>alert('(*) ile belirtilen alanlar boş bırakılamaz');</script>";
			//echo "<script>window.location.href='?modul=ihaleler&sayfa=dogrudan_satis_duzenle&id=$gelen_id'</script>";
		}else{
			mysql_query("
				UPDATE 
					dogrudan_satisli_ilanlar
				SET 
					plaka= '".re('plaka')."',
					arac_kodu='".re('arac_kodu')."',
					bitis_tarihi='".re('yayin_bitis')."',
					fiyat='".re('fiyat')."',
					aracin_durumu='".re('aracin_durumu')."',
					sehir='".re('sehir')."',
					yakit_tipi='".re('yakit_tipi')."',
					vites_tipi='".re('vites_tipi')."',
					sehir='".re('sehir')."',
					ilce='".re('ilce')."',
					model_yili='".re('model_yili')."',
					marka='".re('dogrudan_marka')."',
					model='".re('dogrudan_model')."',
					uzanti='".re('uzanti')."',
					evrak_tipi='".re('evrak_tipi')."',
					kilometre='".re('kilometre')."',
					hasar_durumu='".$values."',
					aracin_adresi='".re('aracin_adresi')."',
					vitrin='".re('vitrin')."',
					aciklamalar='".re('aciklamalar')."'
				WHERE
					id = $gelen_id
			");
			
		   
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
						$sonu_cek = mysql_query("SELECT * FROM dogrudan_satisli_ilanlar WHERE id= '".$gelen_id."'");
						while ($sonu_oku = mysql_fetch_array($sonu_cek)){
							$ihaleID = $sonu_oku['id'];
							mysql_query("INSERT INTO dogrudan_satisli_resimler (`id`,`ilan_id`,`resim`) VALUES (NULL, '" . $ihaleID . "', '" . $ad . "')");
						}
					}
				}
			}
			echo "<script>alert('Güncelleme başarılı');</script>";
			echo "<script>window.location.href='?modul=ihaleler&sayfa=dogrudan_satis_duzenle&id=$gelen_id'</script>";
			//header("Location:?modul=ihaleler&sayfa=dogrudan_satis_duzenle&id=$gelen_id");
		}   
	}   
           

?>




