<?php 
$gelen_id=re("id");
$islem = re("q");

if($islem ==  "sifre_sms"){
	$yeni_onay = substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789"),0,6);
	$onay_mesaj="Yeni Şifreniz:". $yeni_onay;
	$update = mysql_query("update kullanicilar set sifre = '".md5($yeni_sifre)."' where id = '".$gelen_id."'");
	coklu_sms_gonder_admin($gelen_id,$onay_mesaj,4);    
	header("Location:?modul=admin&sayfa=adminler");
}




?>