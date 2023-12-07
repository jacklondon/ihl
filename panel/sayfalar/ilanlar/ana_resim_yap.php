<?php 
$gelen_id=re("id");
$gidilecek = re("g");

mysql_query("UPDATE `ilan_resimler` SET `durum` = '1' WHERE `ilan_resimler`.`id` = '".$gelen_id."'");
header("Location:?modul=ilanlar&sayfa=ilan_ekle&id=".$gidilecek."");
?>