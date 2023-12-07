<?

$q=re("q");

$id=re("id");


if($q=="sifre")
{
$numara_cek=mysql_query("Select* from user where id='".$id."'");
$numara=mysql_fetch_assoc($numara_cek);
$gsm=$numara["telefon"];
    
$yeni_sifre = substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789"),0,6);
$sifre_guncelle = mysql_query("update user set sifre = '".md5($yeni_sifre)."' where id='".$id."'");

$sifre="Pertdunyasi.com kullanıcı girişi bilgileriniz:Onaylı cep No".$gsm." Şifre:". $yeni_sifre;

coklu_sms_gonder($id,$sifre,4);

header("Location:?modul=bana_ozel&sayfa=uyelerim");
}
if($q=="tanitim")
{    
$select=mysql_query("Select * from tanitim_sms_ayarlari where durum='1'");
$mesaj_cek=mysql_fetch_assoc($select);

coklu_sms_gonder($id,strip_tags($mesaj_cek["gonderilen_sms"]),7);

header("Location:?modul=bana_ozel&sayfa=uyelerim");
}



?>