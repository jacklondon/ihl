<?
$id=re("id");

$numara_cek=mysql_query("Select* from user where id='".$id."'");
$numara=mysql_fetch_assoc($numara_cek);
$gsm=$numara["telefon"];

$yeni_sifre = substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789"),0,6);
$sifre_guncelle = mysql_query("update user set sifre = '".md5($yeni_sifre)."' where id='".$id."'");

$sifre="Pertdunyasi.com kullanıcı girişi bilgileriniz:Onaylı cep No:".$gsm." Şifre:". $yeni_sifre;

coklu_sms_gonder($id,$sifre,8);

header("Location:?modul=uyeler&sayfa=uyeler");

?>