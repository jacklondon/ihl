<?

$id=re("id");

$update=mysql_query("update tanitim_sms_ayarlari set durum='0'");

$update_2=mysql_query("Update tanitim_sms_ayarlari set durum='1' where id='".$id."'");

echo("Update tanitim_sms_ayarlari set durum='1' where id='".$id."'");

header("Location:?modul=ayarlar&sayfa=tanitim_sms_ayari");

?>