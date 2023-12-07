<?php 
$gelen_id = re('id');
if(re('dogrudan_guncellemeyi') == "Kaydet"){
    $plaka = re('plaka');
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
    $satis_fiyati = re('satis_fiyati');
    $hasarlar=$_POST["hasar"];
    $hasar_say=count($hasarlar);
    $hasarlar_array=array();            
    for($i=0;$i<$hasar_say;$i++)
    {
        array_push($hasarlar_array,$hasarlar[$i]);
    }
    $columns = implode(",",array_keys($hasarlar_array));
    $escaped_values = array_map('mysql_real_escape_string', array_values($hasarlar_array));
    $values  = implode("|", $hasarlar_array);

    $sehri_cek = mysql_query("SELECT * FROM sehir WHERE sehirID = '".$sehir."'");
    $sehri_oku = mysql_fetch_assoc($sehri_cek);
    $sehrin_adi = $sehri_oku['sehiradi'];

    $markayi_cek = mysql_query("SELECT * FROM marka WHERE markaID = '".$marka."'");
    $markayi_oku = mysql_fetch_assoc($markayi_cek);
    $markanin_adi = $markayi_oku['marka_adi'];

    mysql_query("UPDATE `dogrudan_satisli_ilanlar` SET `plaka` = '".$plaka."', `fiyat` = '".$satis_fiyati."', 
    `aracin_durumu` = '".$arac_durumu."', `sehir` = '".$sehrin_adi."', `ilce` = '".$ilce."', `marka` = '".$markanin_adi."', 
    `model` = '".$model."', `model_yili` = '".$model_yili."', `uzanti` = '".$uzanti."', `kilometre` = '".$kilometre."', 
    `yakit_tipi` = '".$yakit_tipi."', `vites_tipi` = '".$vites_tipi."', `evrak_tipi` = '".$evrak_tipi."', 
    `hasar_durumu` = '".$values."', `aracin_adresi` = '".$aracin_adresi."', `aciklamalar` = '".$aciklamalar."' 
    WHERE `dogrudan_satisli_ilanlar`.`id` = '".$gelen_id."';");


     header('Location: dogrudan_duzenle.php?id='.$gelen_id.'');

}
?>