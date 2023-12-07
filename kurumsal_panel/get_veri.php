<?php 
   session_start();
   include('../ayar.php');
    $token = $_SESSION['k_token'];
    if(!empty($token)){
      $uye_token = $token;
    }
    if(!isset($uye_token)){
      echo '<script>alert("Devam Etmek İçin Lütfen Giriş Yapın !")</script>';
      echo '<script>window.location.href = "../index.php"</script>';
      }
if(re("action")=="mesajlasma")
{
	$ilan_id_gelen=re("value");  
	$dizi=explode("*",$ilan_id_gelen);
	$ilan_id=$dizi[0];
	$tkn=$dizi[1];
	$tur=$dizi[2];
	if($tur=="ilan"){
		$ilan_mesajlari_cek=mysql_query("Select * from mesajlar where ilan_id='".$ilan_id."' and ((alan_token='".$token."' and gonderen_token='".$tkn."') or  (alan_token='".$tkn."' and gonderen_token='".$token."')) order by gonderme_zamani asc ");

		while($mesajlari_bas=mysql_fetch_array($ilan_mesajlari_cek))
		{
			$gonderen_bul = mysql_query("select * from user where user_token = '".$tkn." or kurumsal_user_token = '".$tkn."'");
			$gonderen_say = mysql_num_rows($gonderen_bul);
			if($gonderen_say == 0){
				$adminden_bul = mysql_query("select * from kullanicilar where token = '".$tkn."'");
				$adminden_oku = mysql_fetch_assoc($adminden_bul);
				$gonderen = $adminden_oku['adi']." ".$adminden_oku['soyadi'];
			}else{
				$gonderen_oku = mysql_fetch_assoc($gonderen_bul);
				$gonderen = $gonderen_oku['ad'];
			}
			$konum_belirle="";
			$mesajlar=$mesajlari_bas["mesaj"];
			$gonderme_zamani=$mesajlari_bas["gonderme_zamani"];
			$alan_token=$mesajlari_bas["gonderen_token"];

			if($alan_token==$token)
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
			"gonderme_zamani"=>date("d-m-Y H:i:s",strtotime($gonderme_zamani)),
			"konum"=>$konum_belirle,
			"gonderen"=>$gonderen
			];    
		}
	
        if (mysql_num_rows($ilan_mesajlari_cek) >= 0) $statusCode = 200;
        $response = ["message" => "Mesajlar Getirildi", "Mesaj Detaylari" => $ilan_mesajlari_cek, "status" => $statusCode];
        echo json_encode(response($listingMap, $statusCode));
	}else{
			$ilan_mesajlari_cek=mysql_query("Select * from mesajlar where dogrudan_satis_id='".$ilan_id."' and ((alan_token='".$token."' and gonderen_token='".$tkn."') or  (alan_token='".$tkn."' and gonderen_token='".$token."')) order by gonderme_zamani asc ");
			while($mesajlari_bas=mysql_fetch_array($ilan_mesajlari_cek))
            {
                $gonderen_bul = mysql_query("select * from user where user_token = '".$tkn." or kurumsal_user_token = '".$tkn."'");
                $gonderen_say = mysql_num_rows($gonderen_bul);
                if($gonderen_say == 0){
                    $adminden_bul = mysql_query("select * from kullanicilar where token = '".$tkn."'");
                    $adminden_oku = mysql_fetch_assoc($adminden_bul);
                    $gonderen = $adminden_oku['adi']." ".$adminden_oku['soyadi'];
                }else{
                    $gonderen_oku = mysql_fetch_assoc($gonderen_bul);
                    $gonderen = $gonderen_oku['ad'];
                }
                $konum_belirle="";
                $mesajlar=$mesajlari_bas["mesaj"];
                $gonderme_zamani=$mesajlari_bas["gonderme_zamani"];
                $alan_token=$mesajlari_bas["gonderen_token"];

                if($alan_token==$token)
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
                "gonderme_zamani"=>date("d-m-Y H:i:s",strtotime($gonderme_zamani)),
                "konum"=>$konum_belirle,
                "gonderen"=>$gonderen
                ];    
            }
        if (mysql_num_rows($ilan_mesajlari_cek) >= 0) $statusCode = 200;
        $response = ["message" => "Mesajlar Getirildi", "Mesaj Detaylari" => $ilan_mesajlari_cek, "status" => $statusCode];
        echo json_encode(response($listingMap, $statusCode));
	}

}
if(re("action")=="mesaj_gonder")
{
    $mesaj_icerik=re("icerik");
    $ilan_id_gelen=re("value");  
    $dizi=explode("*",$ilan_id_gelen);
    $ilan_id=$dizi[0];
    $tkn=$dizi[1];
	$tur=$dizi[2];
	if($tur=="ilan"){
		$kullanici_listele=mysql_query("Select * from user where user_token='".$tkn."'");
		$kullanici_oku=mysql_fetch_assoc($kullanici_listele);
		$kullanici_id=$kullanici_oku["id"];
		if($kullanici_id=="")
		{        
			$kullanici_listele=mysql_query("Select * from user where kurumsal_user_token='".$tkn."'");
			$kullanici_oku=mysql_fetch_assoc($kullanici_listele);
			$kullanici_id=$kullanici_oku["id"];
			 if($kullanici_id=="")
			{       
				$kullanici_id=0;
			}
		}
		$idmi_cek=mysql_query("Select * from user where user_token='".$token."'");
		$idmi_oku=mysql_fetch_assoc($idmi_cek);
		$idim=$idmi_oku["id"];
		$date_time = date('Y-m-d H:i:s');
		$insert = mysql_query("INSERT INTO mesajlar (ilan_id, gonderen_id,alan_id,dogrudan_satis_id,mesaj,gonderme_zamani,gonderen_token,alan_token,durum,is_admin_see)VALUES
		('$ilan_id','$idim','$kullanici_id',0,'$mesaj_icerik','$date_time','$token','$tkn',1,0)");
			if ($insert) $statusCode = 200;
			$response = ["message" => "Mesaj Gönderildi", "Mesaj Detaylari Detaylari" => $dersleri_cek,"tkn"=>$tkn, "status" => $statusCode];
		echo json_encode(response($listingMap, $statusCode));     
	}else{
		$kullanici_listele=mysql_query("Select * from user where user_token='".$tkn."'");
		$kullanici_oku=mysql_fetch_assoc($kullanici_listele);
		$kullanici_id=$kullanici_oku["id"];
		if($kullanici_id=="")
		{        
			$kullanici_listele=mysql_query("Select * from user where kurumsal_user_token='".$tkn."'");
			$kullanici_oku=mysql_fetch_assoc($kullanici_listele);
			$kullanici_id=$kullanici_oku["id"];
			 if($kullanici_id=="")
			{       
				$kullanici_id=0;
			}
		}
		$idmi_cek=mysql_query("Select * from user where user_token='".$token."'");
		$idmi_oku=mysql_fetch_assoc($idmi_cek);
		$idim=$idmi_oku["id"];
		$date_time = date('Y-m-d H:i:s');
		$insert = mysql_query("INSERT INTO mesajlar (ilan_id, gonderen_id,alan_id,dogrudan_satis_id,mesaj,gonderme_zamani,gonderen_token,alan_token,durum,is_admin_see)VALUES
		(0,'$idim','$kullanici_id','$ilan_id','$mesaj_icerik','$date_time','$token','$tkn',1,0)");
			if ($insert) $statusCode = 200;
			$response = ["message" => "Mesaj Gönderildi", "Mesaj Detaylari Detaylari" => $dersleri_cek,"tkn"=>$tkn, "status" => $statusCode];
		echo json_encode(response($listingMap, $statusCode));     
	}
}
?>