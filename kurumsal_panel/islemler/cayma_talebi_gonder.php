<?php 
	session_start();
	include '../../ayar.php';
	$token = $_SESSION['k_token'];
	if($token){
		$uye_token = $token;
	}
	if(re("action")=="cayma_talep"){

		$sql=mysql_query("SELECT * FROM user WHERE kurumsal_user_token='".$uye_token."'");
		$fetch=mysql_fetch_assoc($sql);
		$uye_id=$fetch["id"];
		
		$teklif_sql=mysql_query("SELECT teklifler.* FROM teklifler INNER JOIN ilanlar ON ilanlar.id=teklifler.ilan_id WHERE teklifler.uye_id='".$uye_id."' AND ilanlar.durum=1");
		$teklif_say=mysql_num_rows($teklif_sql);
		
		$onay_sql=mysql_query("SELECT kazanilan_ilar.* FROM kazanilan_ilanlar WHERE uye_id='".$uye_id."' and durum=0 ");
		$onay_say=mysql_num_rows($onay_sql);
		$odeme_sql=mysql_query("SELECT kazanilan_ilar.* FROM kazanilan_ilanlar WHERE uye_id='".$uye_id."' and durum=1 ");
		$odeme_say=mysql_num_rows($odeme_sql);

		$bloke_say = mysql_num_rows(mysql_query("select * from cayma_bedelleri where uye_id = '".$uye_id."' and durum = 6"));
		// var_dump("select * from cayma_bedelleri where uye_id = '".$uye_id."' and durum = 6");


		if($odeme_say>0 || $onay_say>0 || $teklif_say>0){
			$response=[	
				"message"=>"İade talebinde bulunabilmek için Devam eden ihalelerde teklifiniz ve Onay bekleyen, Ödeme bekleyen statülerinde  araçlarınız bulunmaması gerekmektedir.",
				"status"=>500
			];
		}else{
			if($bloke_say == 0){
				$caymalar = $_POST['caymalar'];
				$date = date('Y-m-d H:i:s');
				foreach($caymalar as $value){
					mysql_query("UPDATE cayma_bedelleri SET durum = 2,iade_talep_tarihi = '".$date."' WHERE id = '".$value."'");
				}
				$response=["message"=>"İşlem başarılı","status"=>200];
			}else{
				$response=[	
					"message"=>"İade talebi oluşturmak için önce bloke için bekleyen borcunuzu ödemeniz gerekmektedir.",
					"status"=>500
				];
			}
			
		}
		
		echo json_encode($response);
		
	}	
	
?>



