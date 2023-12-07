<?php 
$silinecek = $_POST['secim'];
if($_POST['secili_sil']){
foreach ($silinecek as $sil) {
   mysql_query("DELETE FROM ilanlar WHERE id = '".$sil."'");
 }
 header('Location: ?modul=ihaleler&sayfa=tum_ihaleler');
}
?>