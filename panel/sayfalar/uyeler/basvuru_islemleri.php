<?php 
$gelen_id=re("id");
$islem = re("q");
$uye_id = re('uye');
$uye_limit_cek = mysql_query("SELECT * FROM teklif_limiti WHERE uye_id = '".$uye_id."'");
$uye_limit_say = mysql_num_rows($uye_limit_cek);
$basvuru_cek = mysql_query("SELECT * FROM gold_uyelik_talepleri WHERE uye_id = '".$uye_id."'");
while($oku = mysql_fetch_array($basvuru_cek)){
    $tur = $oku['tur'];
    $grup_bul = mysql_query("SELECT * FROM uye_grubu WHERE id = '".$tur."'");
    $grup_yaz = mysql_fetch_assoc($grup_bul);
    $grup_limit = $grup_yaz['teklif_ust_limit'];
    $grup_standart = $grup_yaz['standart_ust_limit'];
    $grup_luks = $grup_yaz['luks_ust_limit'];
    $cayma_bedeli = $grup_yaz['cayma_bedeli'];
    $uye_cayma_cek = mysql_query("SELECT * FROM cayma_bedelleri WHERE uye_id = '".$uye_id."'");
    $cayma_sayi = mysql_num_rows($uye_cayma_cek);    
if($uye_limit_say == 1){
if($islem ==  "onayla"){
    mysql_query("UPDATE `gold_uyelik_talepleri` SET `durum` = '1' WHERE `gold_uyelik_talepleri`.`id` = '".$gelen_id."'");

    $uye_cek = mysql_query("select * from user where id = '".$uye_id."'");
    $uye_oku = mysql_fetch_object($uye_cek);
    if($uye_oku->temsilci_id != 0){
      $temsilci_id = $uye_oku->temsilci_id;
    }else{
      $temsilci_id = 0;
      $prm_cek = mysql_query("select * from prm_notlari where uye_id = '".$uye_id."' and durum = 1 and ekleyen <> 0");
      if(mysql_num_rows($prm_cek) != 0){
        // $prm_oku = mysql_fetch_object($cek);
        while($prm_oku = mysql_fetch_object($prm_cek)){
          $admin_cek = mysql_query("select * from kullanicilar where id = '".$prm_oku->ekleyen."'");
          $admin_oku = mysql_fetch_object($admin_cek);
          if($admin_oku->departman == "Müşteri Temsilcisi"){
            $temsilci_id = $admin_oku->id;
          }
        }
        // $temsilci_id = $prm_oku->ekleyen;
      }else{
        $yeni_temsilci_id = -5;
          $temslici_cek = mysql_query("select * from kullanicilar where departman = 'Müşteri Temsilcisi'");
          while($temsilci_oku = mysql_fetch_object($temsilci_cek)){
            $toplam_musterisi = mysql_num_rows(mysql_query("select * from user where temsilci_id = '".$temsilci_oku->id."'"));
            if($toplam_musterisi == 0){
              $yeni_temsilci_id = $temsilci_oku->id;
            }
          }
          if($yeni_temsilci_id == -5){
            $temsilci_cek = mysql_query("SELECT b.temsilci_id,COUNT(*) as toplam FROM kullanicilar a, user b WHERE a.id = b.temsilci_id GROUP BY b.temsilci_id ORDER BY toplam asc");
            while($temsilci_oku = mysql_fetch_object($temsilci_cek)){
              $admin_cek = mysql_query("select * from kullanicilar where id = '".$temsilci_oku->temsilci_id."'");
              $admin_oku = mysql_fetch_object($admin_cek);
              if($admin_oku->departman == "Müşteri Temsilcisi"){
                $yeni_temsilci_id = $admin_oku->id;
              }
            }
          }
          $temsilci_id = $yeni_temsilci_id;
        /*
          $temsilci_cek = mysql_query("SELECT b.temsilci_id,COUNT(*) as toplam FROM kullanicilar a, user b WHERE a.id = b.temsilci_id GROUP BY b.temsilci_id ORDER BY toplam asc");
          while($temsilci_oku = mysql_fetch_object($temsilci_cek)){
            $admin_cek = mysql_query("select * from kullanicilar where id = '".$temsilci_oku->temsilci_id."'");
            $admin_oku = mysql_fetch_object($admin_cek);
            if($admin_oku->departman == "Müşteri Temsilcisi"){
              $temsilci_id = $admin_oku->id;
            }
          }
        */
        // $temsilci_oku = mysql_fetch_object($temsilci_cek);
        // $temsilci_id = $temsilci_oku->temsilci_id;
      }
    }

    mysql_query("UPDATE `user` SET `paket` = '".$tur."',`temsilci_id` = '".$temsilci_id."' WHERE `user`.`id` = '".$uye_id."'");
    mysql_query("UPDATE `teklif_limiti` SET `teklif_limiti` = '".$grup_limit."', standart_limit = '".$grup_standart."',luks_limit = '".$grup_luks."' WHERE uye_id='".$uye_id."'");
    
    /*
    if($cayma_sayi >0){
      mysql_query("UPDATE cayma_bedelleri SET tutar = '".$cayma_bedeli."', durum = '1', net = '".$cayma_bedeli."' WHERE uye_id = '".$uye_id."'");
    }else{
      mysql_query("INSERT INTO `cayma_bedelleri` (`id`, `uye_id`, `tutar`, `hesap_sahibi`, `iban`, `uye_grubu`, `tarih`, `iade_tarihi`, `iade_tutari`, `aciklama`, `net`, `durum`, `sonuc`) 
      VALUES (NULL, '".$uye_id."', '".$cayma_bedeli."', '', '', '', '', '', '', '', '".$cayma_bedeli."', '1', '');");
    }
    */
  header("Location:?modul=uyeler&sayfa=uye_duzenle&id=$uye_id");
}
if($islem ==  "reddet"){
    mysql_query("UPDATE `gold_uyelik_talepleri` SET `durum` = '2' WHERE `gold_uyelik_talepleri`.`id` = '".$gelen_id."'");
    header("Location:?modul=uyeler&sayfa=gold_uyelik_talepleri");
  }
if($islem ==  "sil"){
    mysql_query("DELETE FROM `gold_uyelik_talepleri` WHERE `gold_uyelik_talepleri`.`id` = '".$gelen_id."'");
    header("Location:?modul=uyeler&sayfa=gold_uyelik_talepleri");
  }
}else{
    if($islem ==  "onayla"){
      mysql_query("UPDATE `gold_uyelik_talepleri` SET `durum` = '1' WHERE `gold_uyelik_talepleri`.`id` = '".$gelen_id."'");
      mysql_query("UPDATE `user` SET `paket` = '".$tur."' WHERE `user`.`id` = '".$uye_id."'");
      mysql_query("INSERT INTO `teklif_limiti` (`id`, `uye_id`, `teklif_limiti`, `standart_limit`, `luks_limit`) VALUES
      (NULL, '".$uye_id."', '".$grup_limit."', '".$grup_standart."', '".$grup_luks."');");
      /*
      if($cayma_sayi >0){
        mysql_query("UPDATE cayma_bedelleri SET tutar = '".$cayma_bedeli."',durum = '1', net = '".$cayma_bedeli."' WHERE uye_id = '".$uye_id."'");
      }else{
        mysql_query("INSERT INTO `cayma_bedelleri` (`id`, `uye_id`, `tutar`, `hesap_sahibi`, `iban`, `uye_grubu`, `tarih`, `iade_tarihi`, `iade_tutari`, `aciklama`, `net`, `durum`, `sonuc`) 
        VALUES 
        (NULL, '".$uye_id."', '".$cayma_bedeli."', '', '', '', '', '', '', '', '".$cayma_bedeli."', '1', '');");
      }
      */
      header("Location:?modul=uyeler&sayfa=uye_duzenle&id=$uye_id");
    }
    if($islem ==  "reddet"){
      mysql_query("UPDATE `gold_uyelik_talepleri` SET `durum` = '2' WHERE `gold_uyelik_talepleri`.`id` = '".$gelen_id."'");
      header("Location:?modul=uyeler&sayfa=gold_uyelik_talepleri");
    }
    if($islem ==  "sil"){
      mysql_query("DELETE FROM `gold_uyelik_talepleri` WHERE `gold_uyelik_talepleri`.`id` = '".$gelen_id."'");
      header("Location:?modul=uyeler&sayfa=gold_uyelik_talepleri");
    }
  }
}

?>
