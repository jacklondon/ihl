<?php 
$gelen_id = re('id');
if(re('temsilciyi')=="Kaydet"){
    $guncelle = mysql_query("UPDATE user SET temsilci_id = '".re('temsilci')."' WHERE id='".$gelen_id."'");
    if($guncelle){
        echo '<script>alert("Başarılı")</script>';
    }
}

?>