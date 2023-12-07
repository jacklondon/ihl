<?php 

if(re('sik_sorulan_soruyu')=="Ekle"){
    if(empty(re("soru"))||empty(re("cevap"))){
        echo '<script>alert("Lütfen bilgileri eksiksiz doldurun.")</script>';
    }else{
    mysql_query("INSERT INTO `sss` (`id`, `soru`, `cevap`) VALUES (NULL, '".re('soru')."', '".re('cevap')."');");
}
}

?>