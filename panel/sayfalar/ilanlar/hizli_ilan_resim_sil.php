<?php 
$gelen_id = re('id');
$islem = re('q');
$resim_cek = mysql_query("select * from hizli_ekle_resim where id = '".$gelen_id."'");
$resim_oku = mysql_fetch_assoc($resim_cek);
$resim_kat_id = $resim_oku['kat_id'];
mysql_query("DELETE FROM hizli_ekle_resim WHERE id = '".$gelen_id."'");
header('Location: ?modul=ilanlar&sayfa=hizli_ilan_duzenle&id='.$resim_kat_id.'');

?>