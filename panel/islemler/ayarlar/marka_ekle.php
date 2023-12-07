<?php 
$gelen_id=re("id");
if(re('markayi')=="Kaydet"){ 
    $marka = re('marka_adi');
    if(empty($gelen_id)){ 
    mysql_query("INSERT INTO `marka` (`markaID`, `marka_adi`) VALUES (NULL, '$marka')");
    echo '<script>alert("Marka Eklendi")</script>';
    } else{
        mysql_query("UPDATE `marka` SET `marka_adi` = '$marka' WHERE `marka`.`markaID` = $gelen_id;");
        header("Location:?modul=ayarlar&sayfa=marka_model&id=$gelen_id");
    }
}
?>