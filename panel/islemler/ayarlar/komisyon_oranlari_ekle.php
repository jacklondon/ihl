<?php 
$gelen_id = re('id');
    if(re('komisyon_oranini')=="Kaydet"){
        mysql_query("INSERT INTO 
        `komisyon_oranlari` 
        (`id`, 
        `sigorta_id`, 
        `komisyon_orani`, 
        `net`, 
        `onbinde`, 
        `lux_net`, 
        `lux_onbinde`) 
        VALUES
         (NULL, 
         '".$gelen_id."', 
         '".re('miktar')."',          
         '".re('net')."', 
         '".re('onbinde')."', 
         '".re('lux_net')."', 
         '".re('lux_onbinde')."');
         ");
         header('Location: ?modul=ayarlar&sayfa=komisyon_oranlari&id='.$gelen_id.'');
    }
    
    
?>




