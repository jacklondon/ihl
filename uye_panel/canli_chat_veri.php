<?
 include('ayar.php');

 if(re("action")=="canli_chat")
{
  $soru=re("soru");

   $ilan_mesajlari_cek=mysql_query("Select * from canli_destek where soru like '%".$soru."%' ");
   echo("Select * from canli_destek where soru like '%".$soru."%' ");
    while($mesajlari_bas=mysql_fetch_array($ilan_mesajlari_cek))
            {
                $listingMap[] = 
                            [
                            "cevap" => $mesajlari_bas["cevap"]                        
                            ];    
            }
        if (mysql_num_rows($ilan_mesajlari_cek) >= 0) $statusCode = 200;
        $response = ["message" => "Mesajlar Getirildi", "Mesaj Detaylari" => $ilan_mesajlari_cek, "status" => $statusCode];
        echo json_encode(response($listingMap, $statusCode));
}


?>