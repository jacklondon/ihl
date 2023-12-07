<?php 

if(re('hesap_bilgilerini') == "Kaydet"){
    mysql_query("INSERT INTO `hesap_bilgileri` (`id`, `icerik`, `banka_resim`, `banka_bilgileri`, `referans_baslik`, `referans`) VALUES (NULL, '".re('aciklamalar')."', '', '', '', '');");


    if ($_FILES['resim']['name'] != "")
    {
        include ('simpleimage.php');
        $dosya_sayi = count($_FILES['resim']['name']);
        for ($i = 0;$i < $dosya_sayi;$i++)
        {
            if (!empty($_FILES['resim']['name'][$i]))
            {
                $dosya_adi = $_FILES["resim"]["name"][$i];
                $dizim = array("iz","et","se","du","yr","nk");
                $uzanti = substr($dosya_adi, -4, 4);
                $rasgele = rand(1, 1000000);
                $ad = $dizim[rand(0, 5) ] . $rasgele . ".png";
                $yeni_ad = "../hesap_bilgileri/" . $ad;
                move_uploaded_file($_FILES["resim"]['tmp_name'][$i], $yeni_ad);
                $image = new SimpleImage();
                $image->load($yeni_ad);
                $image->resizeToWidth(1000);
                $image->save($yeni_ad);
                $sonu_cek = mysql_query("SELECT * FROM hesap_bilgileri WHERE icerik = '".re('aciklamalar')."'");

                while ($sonu_oku = mysql_fetch_array($sonu_cek))
                {
                    $hesapID = $sonu_oku['id'];                   
                     mysql_query("INSERT INTO `hesap_resimler` (`id`, `hesap_id`, `resim`) VALUES (NULL, '".$hesapID."', '" . $ad . "');");
                }
            }
        }
    }

}

?>