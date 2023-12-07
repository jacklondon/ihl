<?php 

    if(re('kutlama_gorselini')=="Kaydet"){
        mysql_query("INSERT INTO `kutlama_gorseli` (`id`,`yazi_renk`,`arkaplan_renk`,`icerik`,`reklam_baslangic`,`reklam_bitis`,`durum`) VALUES (NULL,
        '".re('yazi_rengi')."','".re('arkaplan_rengi')."','".re('icerik')."','".re('reklam_baslangic')."','".re('reklam_bitis')."','1');");
        header('Location: ?modul=ayarlar&sayfa=kutlama_gorseli');
    }


?>