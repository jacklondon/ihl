<?php 
$gelen_id=re("id"); 
if(re('modeli')=="Kaydet"){
    $model = re('model_adi');
    $marka = re('marka');
    $get_marka = mysql_query("select * from marka where markaID = '".$marka."'");
    $set_marka = mysql_fetch_assoc($get_marka);

    mysql_query("UPDATE `model` SET `marka_id` = '".$marka."', `model_adi` = '".$model."', `marka_adi` = '".$set_marka['marka_adi']."' WHERE `model`.`modelID` = '$gelen_id'");

    header("Location:?modul=ayarlar&sayfa=model_duzenle&id=$gelen_id");
}
?>