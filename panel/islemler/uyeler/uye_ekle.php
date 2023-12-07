<?php 
if(re('yeni_uyeyi')== "Kaydet"){
    $token = md5(uniqid(mt_rand(), true));
    $firma      = re('firma_adi');
    $yetkili    = re('yetkili_adi_soyadi');
    $tc         = re('tc_kimlik');
    $gelensifre = re('sifre'); 
    $sifre      = md5($gelensifre);
    $email      = re('email');
    $cep_no     = re('onayli_cep_no');
    $il         = re('sehir');
    $ilce       = re('ilce');
    $cinsiyet   = re('cinsiyet');
    $sebep      = re('sebep');
    $uye_turu   = re('uye_turu');
    $konum      = $il .$ilce;
    $kayit_tarihi = date('Y.m.d H:i:s');

    $sehir_adi = mysql_query("SELECT * FROM sehir WHERE sehirID = $il");
    while($sehir_gel = mysql_fetch_array($sehir_adi)){
        $il = $sehir_gel["sehiradi"];
    if($uye_turu=="1"){
        mysql_query("INSERT INTO `user` (`id`, `ad`, `soyad`, `tc_kimlik`, `uye_olma_sebebi`, `cinsiyet`, `mail`, 
        `telefon`, `sabit_tel`, `sehir`, `ilce`, `meslek`, `ilgilendigi_turler`, `sifre`, `adres`, 
        `kargo_adresi`, `fatura_adresi`, `user_token`, `paket`, `unvan`, `vergi_dairesi`, `vergi_dairesi_no`, 
        `kurumsal_user_token`, `temsilci_id`, `kayit_tarihi`, `yedek_kisi`, `yedek_kisi_tel`, `risk`) VALUES 
        (NULL, '".$yetkili."', '', '".$tc."', '".$sebep."', '".$cinsiyet."', '".$email."', '".$cep_no."', '', 
        '".$il."', '".$ilce."', '', '', '".$sifre."', '".$konum."', '".$konum."', '".$konum."', '".$token."', 
        '', '', '', '', '', '', '".$kayit_tarihi."', '', '', '');");
        mysql_query("INSERT INTO `teklif_limitleri` (`id`, `teklif_limiti`) VALUES (NULL, 0)"); 
    }elseif($uye_turu=="2"){
        mysql_query("INSERT INTO `user` (`id`, `ad`, `soyad`, `tc_kimlik`, `uye_olma_sebebi`, `cinsiyet`, `mail`, 
        `telefon`, `sabit_tel`, `sehir`, `ilce`, `meslek`, `ilgilendigi_turler`, `sifre`, `adres`, 
        `kargo_adresi`, `fatura_adresi`, `user_token`, `paket`, `unvan`, `vergi_dairesi`, `vergi_dairesi_no`, 
        `kurumsal_user_token`, `temsilci_id`, `kayit_tarihi`, `yedek_kisi`, `yedek_kisi_tel`, `risk`) VALUES 
        (NULL, '".$yetkili."', '', '".$tc."', '".$sebep."', '".$cinsiyet."', '".$email."', '".$cep_no."', '', 
        '".$il."', '".$ilce."', '', '', '".$sifre."', '".$konum."', '".$konum."', '".$konum."', '', 
        '', '', '', '', '".$token."', '', '".$kayit_tarihi."', '', '', '');");
        mysql_query("INSERT INTO `teklif_limitleri` (`id`, `teklif_limiti`) VALUES (NULL, 0)"); 
    }else{
        echo '<script>alert("HATAAAA !!!")</script>'; 
        die();
    }
}
}
?>