<?php 
$gelen_id=re("id");
$islem = re("q");

$d=strtotime("+7 Days");
$bugun   =  date("Y-m-d", $d);
$a=strtotime("+1 Months");
$biray = date("Y-m-d", $a);
$saat = date("h:i:s");
$suan = date('Y-m-d');

if($islem == "yayinla"){
    
		$sorgula=mysql_query("select * from ilanlar where id='".$gelen_id."'");
		$oku=mysql_fetch_assoc($sorgula);
		$ilan_id = $oku['id'];
        $hesap = $oku['hesaplama'];

        $sigorta = $oku['sigorta'];
        $sigorta_cek = mysql_query("SELECT * FROM sigorta_ozellikleri WHERE id = '".$sigorta."'"); 
        $sigorta_oku = mysql_fetch_assoc($sigorta_cek);
        $sigorta_id = $sigorta_oku['id'];
        $komisyon_cek = mysql_query("SELECT * FROM komisyon_oranlari WHERE sigorta_id = '".$sigorta_id."' LIMIT 1");
		$sigorta_tarih = $sigorta_oku['sigorta_bitis_saati'];
		mysql_query("UPDATE `ilanlar` SET `durum` = '1', `ihale_acilis` = '".$suan."',`ihale_tarihi` = '".$bugun."', `ihale_saati` = '".$sigorta_tarih."'  WHERE `ilanlar`.`id` = '".$gelen_id."'");
	
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
	
	header("Location:?modul=ihaleler&sayfa=uyelerden_gelenler");
}

if($islem == "reddet"){
    mysql_query("UPDATE `ilanlar` SET `durum` = '-2' WHERE `ilanlar`.`id` = '".$gelen_id."'");
	header("Location:?modul=ihaleler&sayfa=uyelerden_gelenler");
}

if($islem == "tekrar_yayinla"){
	$ilan_cek=mysql_query("select * from ilanlar where id='".$gelen_id."'");
	$ilan_oku=mysql_fetch_array($ilan_cek);
	$sigorta_cek=mysql_query("select * from sigorta_ozellikleri where sigorta_id='".$sigorta_id."'");
	$sigorta_oku=mysql_fetch_array($sigorta_cek);
	$sigorta_bitis_saati=$sigorta_oku["sigorta_bitis_saati"];
    mysql_query("UPDATE `ilanlar` SET `durum` = '1', `ihale_tarihi` = '".$bugun."', `ihale_saati` = '".$sigorta_bitis_saati."'  WHERE `ilanlar`.`id` = '".$gelen_id."'");
	header("Location:?modul=ihaleler&sayfa=uyelerden_gelenler");
}

if($islem == "yayindan_kaldir"){
    mysql_query("UPDATE `ilanlar` SET `durum` = '-3' WHERE `ilanlar`.`id` = '".$gelen_id."'");
	header("Location:?modul=ihaleler&sayfa=uyelerden_gelenler");
}

if($islem == "sil"){
    mysql_query("DELETE FROM `ilanlar` WHERE `ilanlar`.`id` = '".$gelen_id."'");
	header("Location:?modul=ihaleler&sayfa=uyelerden_gelenler");
}

if($islem == "dogrudan_yayinla"){
    mysql_query("UPDATE `dogrudan_satisli_ilanlar` SET `durum` = '1', `bitis_tarihi` = '".$biray."'  WHERE `dogrudan_satisli_ilanlar`.`id` = '".$gelen_id."'");
	header("Location:?modul=ihaleler&sayfa=uyelerden_gelenler");
}

if($islem == "dogrudan_yayindan_kaldir"){
    mysql_query("UPDATE `dogrudan_satisli_ilanlar` SET `durum` = '-3' WHERE `dogrudan_satisli_ilanlar`.`id` = '".$gelen_id."'");
	header("Location:?modul=ihaleler&sayfa=uyelerden_gelenler");
}

if($islem == "dogrudan_reddet"){
    mysql_query("UPDATE `dogrudan_satisli_ilanlar` SET `durum` = '-2' WHERE `dogrudan_satisli_ilanlar`.`id` = '".$gelen_id."'");
	header("Location:?modul=ihaleler&sayfa=uyelerden_gelenler");
}

if($islem == "dogrudan_tekrar_yayinla"){
    mysql_query("UPDATE `dogrudan_satisli_ilanlar` SET `durum` = '1', `bitis_tarihi` = '".$biray."' WHERE `dogrudan_satisli_ilanlar`.`id` = '".$gelen_id."'");
	header("Location:?modul=ihaleler&sayfa=uyelerden_gelenler");
}

if($islem == "dogrudan_sil"){
    mysql_query("DELETE FROM `dogrudan_satisli_ilanlar` WHERE `dogrudan_satisli_ilanlar`.`id` = '".$gelen_id."'");
    mysql_query("DELETE FROM `favoriler` WHERE `favoriler`.`id` = '".$gelen_id."'");
	header("Location:?modul=ihaleler&sayfa=uyelerden_gelenler");
}

if($islem == "duzenle"){
    $cek = mysql_query("SELECT * FROM ilanlar WHERE id = $gelen_id");
}






?>