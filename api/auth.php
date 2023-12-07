<?php
include_once '../ayar.php';

header("Content-Type: application/json");
header('Access-Control-Allow-Origin: *');
$response = [];
$statusCode = 404;

if (re("action") == "login") {
    $phone = re("phone");
    $password = re("password");
    $hashedPass = md5($password);
    $after_phone = str_replace(' ', '', $phone);
    $user = mysql_fetch_object(mysql_query("SELECT * FROM user WHERE telefon='" . $after_phone . "' AND sifre='" . $hashedPass . "'"));

    if ($user) {
        $uye_id = $user->id;
        $yasak_sigorta_sorgula = mysql_query("Select * from uye_durumlari where uye_id='" . $uye_id . "'");
        $yasak_sigorta_cek = mysql_fetch_assoc($yasak_sigorta_sorgula);
        $yasak_sigorta = $yasak_sigorta_cek["yasak_sigorta"];
        $token = $user->kurumsal_user_token;

        if ($token == "") {
            echo json_encode(["message" => "Giriş İşlemi Başarılı", "token" => $user->user_token, "name" => $user->ad, "surname" => $user->soyad, "tip" => "bireysel", "yasak_sigorta" => $yasak_sigorta, "status" => 200,]);
        } else {
            echo json_encode(["message" => "Giriş İşlemi Başarılı", "token" => $user->kurumsal_user_token, "name" => $user->ad, "surname" => $user->soyad, "tip" => "kurumsal", "yasak_sigorta" => $yasak_sigorta, "status" => 200,]);
        }
    } else {
        echo json_encode(["message" => "Giriş İşlemi Başarısız!", "status" => 404]);
    }
}


if (re("action") == "bireysel_kayit") {
    $user_token = md5(uniqid(mt_rand(), true));
    $bireysel_ad = re("bireysel_ad");
    $bireysel_gsm = re("bireysel_gsm");
    $bireysel_email = re("bireysel_email");
    $bireysel_sabit = re("bireysel_sabit");
    $bireysel_cinsiyet = re("bireysel_cinsiyet");
    $bireysel_il = re("bireysel_il");
    $bireysel_password = md5(re("bireysel_password"));
    $bireysel_uye_olma_sebep = re("bireysel_uye_olma_sebep");
    $kayit_tarihi = date('Y-m-d H:i:s');

    $after_phone = str_replace(' ', '', $bireysel_gsm);


    $kullanici_kontrol = mysql_query("Select * from user where mail='" . $bireysel_email . "' and telefon='".$after_phone."'");
    $kullanici_say = mysql_num_rows($kullanici_kontrol);

    if ($kullanici_say < 0 || $kullanici_say == 0) {
        $insert = mysql_query("INSERT INTO `user` 
        (`id`, `ad`, `soyad`, `tc_kimlik`, `uye_olma_sebebi`, `cinsiyet`, `mail`, 
        `telefon`, `sabit_tel`, `sehir`, `ilce`, `meslek`, `ilgilendigi_turler`, `sifre`, `adres`, `kargo_adresi`, 
        `fatura_adresi`, `user_token`, `paket`, `unvan`, `vergi_dairesi`, `vergi_dairesi_no`, `kurumsal_user_token`, 
        `temsilci_id`, `kayit_tarihi`, `yedek_kisi`, `yedek_kisi_tel`) 
        VALUES 
        (NULL, '" . $bireysel_ad . "', '', '', '" . $bireysel_uye_olma_sebep . "', '" . $bireysel_cinsiyet . "', '" . $bireysel_email . "', '" . $after_phone . "', 
        '" . $bireysel_sabit . "', '" . $bireysel_il . "', '', '', '', '" . $bireysel_password . "', '', '', '', '" . $user_token . "', 
        '1', '', '', '', '', '', '" . $kayit_tarihi . "', '', '');");
        $uye_bul = mysql_query("SELECT * FROM user WHERE ad='" . $bireysel_ad . "' AND telefon='" . $after_phone . "' 
					AND mail='" . $bireysel_email . "'");
        $uye_cek = mysql_fetch_assoc($uye_bul);
        $uye_id = $uye_cek['id'];

        mysql_query("INSERT INTO `teklif_limiti` (`id`,`uye_id`,`teklif_limiti`,`standart_limit`, `luks_limit`) 
					VALUES 
					(NULL, '" . $uye_id . "',0,0,0)");
        /*mysql_query("INSERT INTO `cayma_bedelleri` (`uye_id`,`uye_grubu`) 
					VALUES 
					('".$uye_id."',1)");*/

        if ($insert) {
            $statusCode = 200;
            $response = ["message" => "Kayıt Başarılı", "Mesaj" => $sorulari_cek, "status" => $statusCode];

            echo json_encode(response($listingMap, $statusCode));
        } else {
            $statusCode = 400;
            $response = ["message" => "Kayıt Başarısız", "Mesaj" => $sorulari_cek, "status" => $statusCode];
            echo json_encode(response($listingMap, $statusCode));
        }
    }
}


if (re("action") == "kurumsal_kayit") {
    $user_token = md5(uniqid(mt_rand(), true));
    $kurumsal_ad = re("kurumsal_ad");
    $kurumsal_gsm = re("kurumsal_gsm");
    $kurumsal_email = re("kurumsal_email");
    $kurumsal_sabit = re("kurumsal_sabit");
    $kurumsal_cinsiyet = re("kurumsal_cinsiyet");
    $kurumsal_il = re("kurumsal_il");
    $kurumsal_password = md5(re("kurumsal_password"));
    $kurumsal_uye_olma_sebep = re("kurumsal_uye_olma_sebep");
    $kayit_tarihi = date('Y-m-d H:i:s');
    $after_phone = str_replace(' ', '', $kurumsal_gsm);


    $kullanici_kontrol = mysql_query("Select * from user where mail='" . $kurumsal_email . "' and telefon='".$after_phone."'");
    $kullanici_say = mysql_num_rows($kullanici_kontrol);

    if ($kullanici_say < 0 || $kullanici_say == 0) {
        $insert = mysql_query("INSERT INTO `user` 
        (`id`, `ad`, `soyad`, `tc_kimlik`, `uye_olma_sebebi`, `cinsiyet`, `mail`, 
        `telefon`, `sabit_tel`, `sehir`, `ilce`, `meslek`, `ilgilendigi_turler`, `sifre`, `adres`, `kargo_adresi`, 
        `fatura_adresi`, `user_token`, `paket`, `unvan`, `vergi_dairesi`, `vergi_dairesi_no`, `kurumsal_user_token`, 
        `temsilci_id`, `kayit_tarihi`, `yedek_kisi`, `yedek_kisi_tel`) 
        VALUES 
        (NULL, '" . $kurumsal_ad . "', '', '', '" . $kurumsal_uye_olma_sebep . "', '" . $kurumsal_cinsiyet . "', '" . $kurumsal_email . "', '" . $after_phone . "', 
        '" . $kurumsal_sabit . "', '" . $kurumsal_il . "', '', '', '', '" . $kurumsal_password . "', '', '', '', '', 
        '1', '', '', '', '" . $user_token . "', '', '" . $kayit_tarihi . "', '', '');");
        $uye_bul = mysql_query("SELECT * FROM user WHERE ad='" . $kurumsal_ad . "' AND telefon='" . $after_phone . "' 
                AND mail='" . $kurumsal_email . "'");

        $uye_cek = mysql_fetch_assoc($uye_bul);
        $uye_id = $uye_cek['id'];

        mysql_query("INSERT INTO `teklif_limiti` (`id`,`uye_id`,`teklif_limiti`,`standart_limit`, `luks_limit`) 
                    VALUES 
                    (NULL, '" . $uye_id . "',0,0,0)");
        mysql_query("INSERT INTO `cayma_bedelleri` (`uye_id`,`uye_grubu`) 
                    VALUES 
                    ('" . $uye_id . "',1)");


        if ($insert) {
            $statusCode = 200;
            $response = ["message" => "Kayıt Başarılı", "Mesaj" => $sorulari_cek, "status" => $statusCode];

            echo json_encode(response($listingMap, $statusCode));
        } else {
            $statusCode = 400;
            $response = ["message" => "Kayıt Başarısız", "Mesaj" => $sorulari_cek, "status" => $statusCode];
            echo json_encode(response($listingMap, $statusCode));
        }
    }
}


if (re("action") == "change_password") {
    $token = re("token");
    $uye_tip = re("uye_tip");
    $mevcut_sifre = md5(re("mevcut_sifre"));
    $yeni_sifre = md5(re("yeni_sifre"));

    if ($uye_tip == "bireysel") {
        $kullanici_sorgula = mysql_query("Select * from user where user_token='" . $token . "'");
        $kullanici_bilgi = mysql_fetch_assoc($kullanici_sorgula);
        $kullanici_pass = $kullanici_bilgi["sifre"];

        if ($kullanici_pass != $mevcut_sifre) {

            echo json_encode(($statusCode = 1000));
        } else {
            $update_pass = mysql_query("update user set sifre='" . $yeni_sifre . "' where user_token='" . $token . "'");

            if ($update_pass) {
                $statusCode = 200;
                $response = ["message" => "Kayıt Başarılı", "Mesaj" => $sorulari_cek, "status" => $statusCode];
                echo json_encode(response($statusCode));
            } else {
                echo json_encode($statusCode = 400);
            }
        }
    }
    if ($uye_tip == "kurumsal") {
        $kullanici_sorgula = mysql_query("Select * from user where kurumsal_user_token='" . $token . "'");
        $kullanici_bilgi = mysql_fetch_assoc($kullanici_sorgula);
        $kullanici_pass = $kullanici_bilgi["sifre"];



        if ($kullanici_pass != $mevcut_sifre) {
            $statusCode = 1000;
            $response = ["message" => "Mevcut Şifreniz Eşleşmiyor", "Şifre Eşleşmiyor" => $sorulari_cek, "status" => $statusCode];
            echo json_encode(response($statusCode));
        } else {
            $update_pass = mysql_query("update user set sifre='" . $yeni_sifre . "' where kurumsal_user_token='" . $token . "'");

            if ($update_pass) {
                $statusCode = 200;
                $response = ["message" => "Kayıt Başarılı", "Mesaj" => $sorulari_cek, "status" => $statusCode];

                echo json_encode(response($statusCode));
            } else {
                $statusCode = 400;
                $response = ["message" => "Kayıt Başarısız", "Mesaj" => $sorulari_cek, "status" => $statusCode];
                echo json_encode(response($statusCode));
            }
        }
    }
}


if (re("action") == "email_kontrol") {
    $email = re("email");

    $email_kontrol_cek = mysql_query("Select * from user where mail='" . $email . "'");

    $email_kontrol = mysql_num_rows($email_kontrol_cek);

    if ($email_kontrol == 1) {
        echo json_encode(response($statusCode = 500));
    } else {
        echo json_encode(response($statusCode = 200));
    }
}

if (re("action") == "telefon_kontrol") {
    $telefon = re("telefon_no");
    $after_phone = str_replace(' ', '', $telefon);
    $telefon_kontrol = mysql_query("Select * from user where telefon='" . $after_phone . "'");
    $telefon_sayisi = mysql_num_rows($telefon_kontrol);

    if ($telefon_sayisi != 0) {
        echo json_encode(response($statusCode = 500));
    } else {
        echo json_encode(response($statusCode = 200));
    }
}

if (re("action") == "sifre_sifirlama") {
    $telefon_no = re("phone");

    $after_phone = str_replace(' ', '', $telefon_no);

    $kullanici_sorgula = mysql_query("Select * from user where telefon='" . $after_phone . "'");
    $kullanici_veri_cek = mysql_fetch_assoc($kullanici_sorgula);
    $kullanici_email = $kullanici_veri_cek["mail"];
    $kullanici_say = mysql_num_rows($kullanici_sorgula);
    $yeni_sifre = md5(uniqid(mt_rand(), true));
    $yeni_sifre = substr($yeni_sifre, 0, 9);
    $yeni_sifre_md5 = md5($yeni_sifre);
    if ($kullanici_say > 0) {
        $guncelle = mysql_query("update user set sifre='" . $yeni_sifre_md5 . "' where telefon='" . $after_phone . "'");
        if ($guncelle) {
            $messageBody = '';
            $messageBody .= '<h3 style="margin-top:5px;">Şifre Sıfırlama Talebiniz Alındı.</h3>';
            $messageBody .= '<h3 style="margin-top:5px;">Yeni Şifreniz İle Giriş Yapabilirsiniz</h3>';
            $messageBody .= '<strong class="margin-top:5px;">Yeni Şifreniz: </strong>   ' . $yeni_sifre . '<br>';
            $messageBody .= '<h5 style="margin-top:10px;">Şifre Sıfırlama Talebi Size Ait Değilse Lütfen Bizi Bilgilendiriniz.</h5>';
            $messageBody .= '<img src="https://ihale.pertdunyasi.com/images/logo2.png" style="margin-top:30px"> ';
            sendEmail($kullanici_email, "Pert Dünyası Ekibi", "Pert Dünyası Şifre Sıfırlama", $messageBody);
            $response = ["message" => "Mail başarıyla gönderildi.", "status" => 200];
        }
    } else {

        $statusCode = 0;
        echo ($statusCode);
    }
}
