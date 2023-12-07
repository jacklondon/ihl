<?php 
$gelen_id=re("id");
$islem = re("q");
$cevap = re("cevap");

if($islem == "sil"){
    mysql_query("delete from yorumlar where id = '".$gelen_id."'");
    header('Location: ?modul=admin&sayfa=yorumlar');
}
if($islem=="onayla"){
    mysql_query("UPDATE `yorumlar` SET `durum` = '1' WHERE `yorumlar`.`id` = '".$gelen_id."';");
    header('Location: ?modul=admin&sayfa=yorumlar');
}
if($islem=="reddet"){
    mysql_query("UPDATE `yorumlar` SET `durum` = '2' WHERE `yorumlar`.`id` = '".$gelen_id."';");
    header('Location: ?modul=admin&sayfa=yorumlar');
}
if($islem=="anasayfa"){
	$sorgu=mysql_query("select * from yorumlar where durum='3' ");

	mysql_query("UPDATE `yorumlar` SET `durum` = '3' WHERE `yorumlar`.`id` = '".$gelen_id."';");
	header('Location: ?modul=admin&sayfa=yorumlar');
	
	
   
}

?>