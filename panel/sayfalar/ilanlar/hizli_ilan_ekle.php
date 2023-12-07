<?php 
session_start();
$admin_id=$_SESSION['kid'];
$admin_cek=mysql_query("select * from kullanicilar where id='".$admin_id."'");
$admin_oku=mysql_fetch_assoc($admin_cek);
$admin_token=$admin_oku['token'];
$gelen_id = re('id');
$kat_cek = mysql_query("select * from hizli_ekle_detay where kategori_id = '".$gelen_id."'");
$oku = mysql_fetch_assoc($kat_cek);
$sayi_deneme = $oku['sayi'];




for ($i=0; $i < $sayi_deneme ; $i++) {    
  $arac_kodu = str_pad(mt_rand(1,99999999),8,'0',STR_PAD_LEFT); 
  $tarih = date('Y-m-d');
  $ekle = mysql_query("INSERT INTO `ilanlar` (`id`, `plaka`, `arac_kodu`, `hesaplama`, `sigorta`, `marka`, `model`, 
  `tip`, `model_yili`, `piyasa_degeri`, `tsrsb_degeri`, `acilis_fiyati`, `son_teklif`, `profil`, `sehir`, 
   `ilce`, `ihale_tarihi`, `ihale_saati`, `pd_hizmet`, `otopark_giris`, `otopark_ucreti`, 
   `cekici_ucreti`, `dosya_masrafi`, `link`, `kilometre`, `uyari_notu`, `hasar_bilgileri`, 
   `notlar`, `adres`, `donanimlar`, `vitrin`, `eklenme_zamani`, `ilan_url`, `ihale_sahibi`, 
   `ihale_acilis`, `durum`, `ihale_turu`, `vites_tipi`, `yakit_tipi`) 
   VALUES (NULL, '".$oku['plaka']."', '".$arac_kodu."', '".$oku['hesaplama']."', '".$oku['sigorta']."', 
   '".$oku['marka']."', '".$oku['model']."', 
   '".$oku['tip']."', '".$oku['model_yili']."', '".$oku['piyasa_degeri']."', '".$oku['tsrsb_degeri']."', 
   '".$oku['acilis_fiyati']."', '', 
   '".$oku['profil']."', '".$oku['sehir']."', '".$oku['ilcer']."', 
   '".$oku['ihale_tarihi']."', '".$oku['ihale_saati']."', '".$oku['pd_hizmet']."', '".$oku['otopark_giris']."', 
   '".$oku['otopark_ucreti']."', 
   '".$oku['cekici_ucreti']."', '".$oku['dosya_masrafi']."', '".$oku['link']."', '".$oku['kilometre']."', 
   '".$oku['uyari_notu']."', 
   '".$oku['hasar_bilgileri']."', '".$oku['notlar']."', '".$oku['adres']."', '".$oku['donanimlar']."', 
   '".$oku['vitrin']."', '".$tarih."', 
   '".$oku['ilan_url']."', '".$admin_token."', '".$oku['ihale_acilis']."', '1', '".$oku['ihale_turu']."', 
   '".$oku['vites_tipi']."','".$oku['yakit_tipi']."');");

   $eklenen_cek = mysql_query("select * from ilanlar order by id desc limit 1");
   $eklenen_oku = mysql_fetch_assoc($eklenen_cek);
   $eklenen_id = $eklenen_oku['id'];
   $resim_cek = mysql_query("select * from hizli_ekle_resim where kat_id = '".$gelen_id."'");
   while($resim_oku = mysql_fetch_array($resim_cek)){
     $ilana_resim_ekle = mysql_query("INSERT INTO `ilan_resimler` (`id`, `ilan_id`, `resim`, `durum`) VALUES 
     (NULL, '".$eklenen_id."', '".$resim_oku['resim']."', '1');");
   }      
}
echo "<script>alert('İlan Başarıyla Eklendi')</script>";
echo "<script>window.location.href = '?modul=ilanlar&sayfa=hizli_ekle';</script>";


?>