<?php 
$gelen_id=re("id"); 
if(re('resimleri')=="Ekle"){ 
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
                    $yeni_ad = "../images/" . $ad;
                    move_uploaded_file($_FILES["resim"]['tmp_name'][$i], $yeni_ad);
                    copy($yeni_ad, $k_ad);
                    $image = new SimpleImage();
                    $image->load($yeni_ad);
                    $image->resizeToWidth(1000);
                    $image->save($yeni_ad);
                    $sonu_cek = mysql_query("SELECT * FROM dogrudan_satisli_ilanlar WHERE id= '".$gelen_id."'");
                    while ($sonu_oku = mysql_fetch_array($sonu_cek))
                    {
                        $ihaleID = $sonu_oku['id'];
                        mysql_query("INSERT INTO dogrudan_satisli_resimler (`id`,`ilan_id`,`resim`) VALUES 
                        (NULL, '" . $gelen_id . "', '" . $ad . "')");
                    }
                }
            }
        }
    header("Location:?modul=ihaleler&sayfa=dogrudan_satis_duzenle&id=$gelen_id");
}
?>