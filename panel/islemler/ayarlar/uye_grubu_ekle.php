<?php 

if(re('uye_grubunu')=="Kaydet"){
    mysql_query("INSERT INTO uye_grubu (id,grup_adi)
					VALUES (NULL,'".re('uye_grubu')."')
				");
    $ekleneni_bul = mysql_query("SELECT * FROM uye_grubu WHERE grup_adi = '".re('uye_grubu')."'");
    $ekleneni_oku = mysql_fetch_assoc($ekleneni_bul);
    $eklenen_id = $ekleneni_oku['id'];   
    $sigortayi_bul = mysql_query("SELECT * FROM sigorta_ozellikleri");
    while($sigortayi_oku = mysql_fetch_array($sigortayi_bul)){
        mysql_query("INSERT INTO `sigortalar` (`id`, `sigorta_id`, `paket_id`, `secilen_yetki_id`, `detay_gorur`, `tarih`) 
        VALUES 
        (NULL, '".$sigortayi_oku['id']."', '".$eklenen_id."', '1', '0', '".date('Y-m-d H:i:s')."');");
  
	}
	$pop_cek=mysql_query("select * from uye_giris_popup order by id asc");
	$pop_oku=mysql_fetch_object($pop_cek);
	$icerik=$pop_oku->icerik;
	$durum=$pop_oku->durum;
	$pop_ekle=mysql_query("insert into uye_giris_popup (icerik,paket_id,secilme_durumu,durum) values ('".$icerik."','".$eklenen_id."','1','".$durum."') ");
}


?>