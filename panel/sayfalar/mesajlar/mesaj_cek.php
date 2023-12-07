<?php 

/*if(re("action")=="mesajlasma")
{
   $ilan_id_gelen=re("value");  
   $dizi=explode("*",$ilan_id_gelen);
   $ilan_id=$dizi[0];
   $tkn=$dizi[1];
   $sorgu=mysql_query("select * from ilanlar where id='".$ilan_id."'");
   $row=mysql_fetch_assoc($sorgu);
   $ilan_sahibi=$row["ihale_sahibi"];
   $ilan_mesajlari_cek=mysql_query("Select * from mesajlar where ilan_id='".$ilan_id."' order by gonderme_zamani asc ");
    
	
	while($mesajlari_bas=mysql_fetch_array($ilan_mesajlari_cek))
            {
                $konum_belirle="";
                $mesajlar=$mesajlari_bas["mesaj"];
                $gonderme_zamani=$mesajlari_bas["gonderme_zamani"];
                $alan_token=$mesajlari_bas["gonderen_token"];

                if($alan_token==$ilan_sahibi || $alan_token=="" )
                {
                    $konum_belirle="sag";
                }
                else
                {
                    $konum_belirle="sol";
                }
                $listingMap[] = 
                [
                "mesajlar" => $mesajlar, 
                "gonderme_zamani"=>$gonderme_zamani,
                "konum"=>$konum_belirle
                ];    
            }

        if (mysql_num_rows($ilan_mesajlari_cek) >= 0) $statusCode = 200;
        
        $response = ["message" => "Mesajlar Getirildi", "Mesaj Detaylari" => $ilan_mesajlari_cek, "status" => $statusCode];
    
        echo json_encode(response($listingMap, $statusCode));
}


if(re("action")=="mesaj_gonder")
{
 
    $mesaj_icerik=re("icerik");

    $ilan_id_gelen=re("value");  
    $dizi=explode("*",$ilan_id_gelen);
    $ilan_id=$dizi[0];
    $tkn=$dizi[1];

    $kullanici_listele=mysql_query("Select * from user where user_token='".$tkn."'");
    $kullanici_oku=mysql_fetch_assoc($kullanici_listele);
    $kullanici_id=$kullanici_oku["id"];

    if($kullanici_id=="")
    {        
        $kullanici_listele=mysql_query("Select * from user where kurumsal_user_token='".$tkn."'");
        $kullanici_oku=mysql_fetch_assoc($kullanici_listele);
        $kullanici_id=$kullanici_oku["id"];
    }



    $idim="";

    $date_time = date('Y-m-d H:i:s');



    $insert = mysql_query("INSERT INTO mesajlar (ilan_id, gonderen_id,alan_id,dogrudan_satis_id,mesaj,gonderme_zamani,gonderen_token,alan_token)VALUES
    ('$ilan_id','$idim','$kullanici_id',0,'$mesaj_icerik','$date_time','','$tkn')");



        if ($insert) $statusCode = 200;

        $response = ["message" => "Mesaj Gönderildi", "Mesaj Detaylari Detaylari" => $dersleri_cek, "status" => $statusCode];

        echo json_encode(response($listingMap, $statusCode));     

}
*/
?>