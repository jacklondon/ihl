<?
 include('ayar.php');

 if(re("action")=="canli_chat")
{
  $soru=re("soru");

  $select=mysql_query("Select * from chat_bot where chat_bot_durum='1'");
  $veri_cek=mysql_fetch_assoc($select);

  if($veri_cek["chat_bot_durum"]==0)
  {
    $date_time=Date("Y-m-d H:i:s");

    mysql_query("INSERT INTO `canli_destek_mesaj`(`gelen_mesaj`,`giden_mesaj`,`sender_id`,`e_tarihi`,`ip`,`durum`) 
    VALUES ('".$soru."','','0','".$date_time."','".GetIP()."','1')");

$ilan_mesajlari_cek=mysql_query("Select * from canli_destek_mesaj where ip='".GetIp()."' order by id desc limit 1");
  
while($mesajlari_bas=mysql_fetch_array($ilan_mesajlari_cek))
        {

            $listingMap[] = 
            [
            "gelen_mesaj"=>$mesajlari_bas["gelen_mesaj"],
            "cevap" => $mesajlari_bas["giden_mesaj"],
            "sender_id"=>$mesajlari_bas["sender_id"]                
            ]; 
         
        }
    if (mysql_num_rows($ilan_mesajlari_cek) >= 0) $statusCode = 200;
    $response = ["message" => "Mesajlar Getirildi", "Mesaj Detaylari" => $ilan_mesajlari_cek, "status" => $statusCode];
    echo json_encode(response($listingMap, $statusCode));
 
  }
  else {
    
   $ilan_mesajlari_cek=mysql_query("Select * from canli_destek where soru like '%".$soru."%' limit 1 ");
  
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


}
?>