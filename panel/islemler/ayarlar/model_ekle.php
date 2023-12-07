<?php
    if(re('modeli')=="Ekle"){
        $marka = re('marka');
        $model = re('model_adi');
        $get_marka = mysql_query("select * from marka where markaID = '".$marka."'");
        $set_marka = mysql_fetch_assoc($get_marka);
        mysql_query("INSERT INTO `model` (`modelID`, `marka_id`, `model_adi`, `marka_adi`) VALUES (NULL, '".$marka."', '".$model."', '".$set_marka['marka_adi']."');");
    }
?>