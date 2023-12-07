<?

$id=re("id");

$select=mysql_query("Select * from tanitim_sms_ayarlari where durum='1'");
$mesaj_cek=mysql_fetch_assoc($select);


coklu_sms_gonder($id,strip_tags($mesaj_cek["gonderilen_sms"]),7);

header("Location:?modul=uyeler&sayfa=uyeler");

?>