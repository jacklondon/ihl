<?php 
$gelen_id = re('id');
if(re('dogrudan_resimleri') == "Kaydet"){

    
if ($_FILES['resim']['name'] != "")
{
    include ('../simpleimage.php');
    $dosya_sayi = count($_FILES['resim']['name']);
    for ($i = 0;$i < $dosya_sayi;$i++)
    {
        if (!empty($_FILES['resim']['name'][$i]))
        {
            $dosya_adi = $_FILES["resim"]["name"][$i];
            $dizim = array("iz","et","se","du","yr","nk");
            $uzanti = substr($dosya_adi, -4, 4);

            $rasgele = rand(1, 1000000);
            $ad = $dizim[rand(0, 5) ].time() . $rasgele . ".png";
            $yeni_ad = "../images/" . $ad;
            move_uploaded_file($_FILES["resim"]['tmp_name'][$i], $yeni_ad);

            copy($yeni_ad, $k_ad);

            $image = new SimpleImage();
            $image->load($yeni_ad);
            $image->resizeToWidth(1000);
            $image->save($yeni_ad);

            mysql_query("INSERT INTO dogrudan_satisli_resimler (`id`,`ilan_id`,`resim`) VALUES (NULL, '" . $gelen_id . "', '" . $ad . "')");
        }
    }
}
header('Location: dogrudan_duzenle.php?id='.$gelen_id.'');

/*
if (isset($_FILES['resim']))
{ // dosya tanımlanmıs mı?
    $errors = array();
    foreach ($_FILES['resim']['tmp_name'] as $key => $tmp_name)
    {
        if ($_FILES['resim']['name'][$key] != "")
        {
            $dosyaUzantisi = pathinfo($_FILES["resim"]["name"][$key], PATHINFO_EXTENSION);
            $dosya_adi = $_FILES['resim']['name'][$key]; // uzantiya beraber dosya adi
            $dosya_boyutu = $_FILES['resim']['size'][$key]; // byte cinsinden dosya boyutu
            $dosya_gecici = $_FILES['resim']['tmp_name'][$key]; //gecici dosya adresi
            $yenisim = md5(microtime()) . '.' . $dosyaUzantisi; //karmasik yeni isim.png
            if ($dosya_boyutu > 20971520)
            {
                $errors[] = 'Maksimum 20 Mb lık dosya yuklenebilir.';
            }
            $klasor = "../images/"; // yuklenecek dosyalar icin yeni klasor
            if (empty($errors) == true)
            { //eger hata yoksa
                if (is_dir("$klasor/" . $yenisim) == false)
                { //olusturdugumuz isimde dosya var mı?
                    move_uploaded_file($dosya_gecici, "$klasor/" . $yenisim); //yoksa yeni ismiyle kaydet
                }
                else
                { //eger varsa
                    $new_dir = "$klasor/" . $yenisim . time(); //yeni ismin sonuna eklenme zamanını ekle
                    rename($dosya_gecici, $new_dir);
                }
            }
            else
            {
                print_r($errors); //varsa hataları yazdır
                
            }
            $yol = $yenisim;
        }
        if (empty($error))
        {
            mysql_query("INSERT INTO dogrudan_satisli_resimler (`id`,`ilan_id`,`resim`) VALUES (NULL, '" . $gelen_id . "', '" . $yol . "')");
        }
    }
}
 header('Location: dogrudan_duzenle.php?id='.$gelen_id.'');
*/



   

}
?>