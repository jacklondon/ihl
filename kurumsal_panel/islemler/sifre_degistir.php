<?php 
   session_start();
   include '../../ayar.php';

    $token = $_SESSION['k_token'];
    if($token){
      $uye_token = $token;
    }

    if(re('sifre_degisikligini')=="Kaydet"){
        $sifre = re('sifre');
        $yeni_sifre = re('yeni_sifre');
        $yeni_sifre_tekrar = re('yeni_sifre_tekrar');
        $sifre_cek = mysql_query("SELECT * FROM user WHERE kurumsal_user_token = '".$uye_token."'");
        while($sifre_oku = mysql_fetch_array($sifre_cek)){
            $db_sifre = $sifre_oku['sifre'];
            if($db_sifre == md5($sifre)){
                if($yeni_sifre == $yeni_sifre_tekrar){
                    if($db_sifre != md5($yeni_sifre)){
                        mysql_query("UPDATE user SET sifre = '".md5($yeni_sifre)."' WHERE kurumsal_user_token = '".$uye_token."'");
                        echo '<script>alert("Şifre değiştirme işleminiz başarılı bir şekilde gerçekleştirildi.")</script>';
                    }else{
                        echo '<script>alert("HATA != Yeni şifreniz mevcut şifrenizden farklı olmalıdır.")</script>';
                    }
                   
                }else{
                    echo '<script>alert("Yeni şifreler uyuşmuyor lütfen tekrar deneyiniz !")</script>';
                }
            }else{
                echo '<script>alert("Mevcut şifreniz yanlış lütfen tekrar deneyiniz !")</script>';
            }
        }
    }



?>