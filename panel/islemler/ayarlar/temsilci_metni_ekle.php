<?php 




if(re('musteri_temsilcisi_metnini')=="Kaydet"){
    $metni_cek = mysql_query("SELECT * FROM arac_detay_musteri_temsilcisi_metni ORDER BY id DESC LIMIT 1");
    $metni_say = mysql_num_rows($metni_cek);
    $metni_oku = mysql_fetch_assoc($metni_cek);
    $metin_id = $metni_oku['id'];
    if($metni_say == 0){
        mysql_query("INSERT INTO `arac_detay_musteri_temsilcisi_metni` (`id`, `icerik`) VALUES
        (NULL, '".re('musteri_temsilcisi_metni')."')");
     }else{         
        mysql_query("UPDATE `arac_detay_musteri_temsilcisi_metni` SET icerik = '".re('musteri_temsilcisi_metni')."' WHERE id ='".$metin_id."'");
     }
}


?>