<?php 

/* İlan süre uzaması kontrolleri  */

$ilan_cek = mysql_query("select * from ilanlar where id = '".$ilanID."'");
$ilan_oku = mysql_fetch_object($ilan_cek);
$ilan_sigorta = $ilan_oku->sigorta;
$sigorta_cek = mysql_query("select * from sigorta_ozellikleri where id = '".$ilan_sigorta."'");
$sigorta_oku = mysql_fetch_object($sigorta_cek);
if($sigorta_oku->sure_uzatma == 1){
  $kac_dakikanin_altinda = $sigorta_oku->dakikanin_altinda;
  $kac_saniyenin_altinda = $kac_dakikanin_altinda * 60;
  $uzayacak_dikaka = $sigorta_oku->dakika_uzar;
  $ilan_bitis = strtotime($ilan_oku->ihale_tarihi." ".$ilan_oku->ihale_saati);
  $suan = strtotime(date('Y-m-d H:i:s'));
  $fark = $ilan_bitis - $suan;
  $ilk_saniye = $sigorta_oku->saniyenin_altinda;
  $saniye_uzar = $sigorta_oku->saniye_uzar;
  if($fark < $ilk_saniye){
    $yeni_trh = date('Y-m-d H:i:s', strtotime('+'.$saniye_uzar.' seconds', strtotime($ilan_oku->ihale_tarihi." ".$ilan_oku->ihale_saati)));
    $explode=explode(" ",$yeni_trh);
    $yeni_t=$explode[0];
    $yeni_s=$explode[1];
    $gosterilme_tarih=strtotime($yeni_trh)+300; //Gösterilme süresi 5 dk fazla olması istendi
    $gosterilme_tarih = date('Y-m-d H:i:s',$gosterilme_tarih);
    mysql_query("UPDATE ilanlar SET ihale_tarihi='".$yeni_t."', ihale_saati='".$yeni_s."', ihale_son_gosterilme='".$gosterilme_tarih."' WHERE id='".$ilanID."'");
  }else{
    if($fark < $kac_saniyenin_altinda){				
      $yeni_trh = date('Y-m-d H:i:s', strtotime('+'.$uzayacak_dikaka.' minutes', strtotime($ilan_oku->ihale_tarihi." ".$ilan_oku->ihale_saati)));
      $explode=explode(" ",$yeni_trh);
      $yeni_t=$explode[0];
      $yeni_s=$explode[1];
      $gosterilme_tarih=strtotime($yeni_trh)+300; //Gösterilme süresi 5 dk fazla olması istendi
      $gosterilme_tarih = date('Y-m-d H:i:s',$gosterilme_tarih);
      mysql_query("UPDATE ilanlar SET ihale_tarihi='".$yeni_t."', ihale_saati='".$yeni_s."', ihale_son_gosterilme='".$gosterilme_tarih."' WHERE id='".$ilanID."'");
    }
  }  
}

/* İlan süre uzaması kontrolleri  */
