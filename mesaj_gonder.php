<?php 
include 'ayar.php';
	if(re("action")=="mesaj_gonder"){		
		$response=[];
		$gonderilecek_mesaj = $_POST['gonderilecek_mesaj'];
		$kullaniciToken = $_POST['kullaniciToken'];
		$ilanID = $_POST['ilanID'];
		$uye_tkn = re('uye_token');
		$user_sql=mysql_query("select * from user where user_token='".$uye_tkn."' or kurumsal_user_token='".$uye_tkn."' ");
		$user_row=mysql_fetch_object($user_sql);
		$uyeID=$user_row->id;
		$ihaleSahibi = $_POST['ihaleSahibi'];
		$date = date('Y-m-d H:i:s');
		$sql = mysql_query("SELECT * FROM user WHERE user_token = '".$ihaleSahibi."' or kurumsal_user_token = '".$ihaleSahibi."' ");
		$oku = mysql_fetch_array($sql);
		$sql_say=mysql_num_rows($sql);
		
		if($ihaleSahibi==$uye_tkn){
			$response=["message"=>"Kendi ihalenize mesaj atamazsınız.","status"=>500];
		} else if($sql_say!=0){
			$alan = $oku['id'];
			/*
			$kaydet=mysql_query("INSERT INTO `mesajlar` (`id`, `ilan_id`, `gonderen_id`, `alan_id`, `dogrudan_satis_id`, `mesaj`,`gonderme_zamani`, `gonderen_token`, `alan_token`, `durum`, `is_admin_see`) VALUES (NULL, '".$ilanID."', '".$uyeID."', 
			'".$alan."', '0', '".$gonderilecek_mesaj."','".$date."', '".$kullaniciToken."', '".$ihaleSahibi."',1,0);");
			$response=["message"=>"Başarılı.","status"=>200];
			*/
		}else{
			$sql2 = mysql_query("SELECT * FROM kullanici WHERE token = '".$ihaleSahibi."'  ");
			$alan = 0;
			/*
			$kaydet=mysql_query("INSERT INTO `mesajlar` (`id`, `ilan_id`, `gonderen_id`, `alan_id`, `dogrudan_satis_id`, `mesaj`,`gonderme_zamani`, `gonderen_token`, `alan_token`, `durum`, `is_admin_see`) VALUES (NULL, '".$ilanID."', '".$uyeID."', 
			'".$alan."', '0', '".$gonderilecek_mesaj."','".$date."', '".$kullaniciToken."', '".$ihaleSahibi."',1,0)");
			$response=["message"=>"Başarılı.","status"=>200];
			*/
		}	
		

		if($ihaleSahibi==$uye_tkn){
			$response=["message"=>"Kendi ihalenize mesaj atamazsınız.","status"=>500];
		}else{
			$add_time = date('Y-m-d H:i:s');
			$cek = mysql_query("select * from chat_room where ilan_id = '".$ilanID."' and gonderen_id = '".$uyeID."' and status = 1");
			if(mysql_num_rows($cek) != 0){
				$oku = mysql_fetch_object($cek);
				$room_id = $oku->id;
			}else{
				mysql_query("insert into chat_room(ilan_id,gonderen_id,alan_id,add_time,status) values ('".$ilanID."','".$uyeID."','".$alan."','".$add_time."',1)");
				$room_cek = mysql_query("select * from chat_room where ilan_id = '".$ilanID."' and gonderen_id = '".$uyeID."' and status = 1");
				$room_oku = mysql_fetch_object($room_cek);
				$room_id = $room_oku->id;
			}
			$add = mysql_query("insert into chat_messages(room_id,gonderen_id,gonderen_type,mesaj,add_time,status) values ('".$room_id."','".$uyeID."',1,'".$gonderilecek_mesaj."','".$add_time."',1)");
			if($add){
				mysql_query("update chat_room set last_message = '".$gonderilecek_mesaj."', last_message_time = '".$add_time."' where id = '".$room_id."'");
				$response=["message"=>"Başarılı.","status"=>200];
			}else{
				$response=["message"=>"İşlem sırasında bir hata oluştu. Lütfen daha sonra tekrar deneyiniz.","status"=>300];
			}
		}
		
		echo json_encode($response);
	}
	if(re("action")=="dogrudan_mesaj_gonder"){		
		$response=[];
		$gonderilecek_mesaj = $_POST['gonderilecek_mesaj'];
		$kullaniciToken = $_POST['kullaniciToken'];
		$ilanID = $_POST['ilanID'];
		$uye_tkn = re('uye_token');
		$user_sql=mysql_query("select * from user where user_token='".$uye_tkn."' or kurumsal_user_token='".$uye_tkn."' ");
		$user_row=mysql_fetch_object($user_sql);
		$uyeID=$user_row->id;
		$ihaleSahibi = $_POST['ihaleSahibi'];
		$date = date('Y-m-d H:i:s');
		$sql = mysql_query("SELECT * FROM user WHERE user_token = '".$ihaleSahibi."' or kurumsal_user_token = '".$ihaleSahibi."' ");
		$oku = mysql_fetch_array($sql);
		$sql_say=mysql_num_rows($sql);
		if($ihaleSahibi==$uye_tkn){
			$response=["message"=>"Kendi ihalenize mesaj atamazsınız.","status"=>500];
		}else if($sql_say!=0){
			$alan = $oku['id'];
			/*
			$kaydet=mysql_query("INSERT INTO `mesajlar` (`id`, `ilan_id`, `gonderen_id`, `alan_id`, `dogrudan_satis_id`, `mesaj`,`gonderme_zamani`, `gonderen_token`, `alan_token`) VALUES (NULL, '', '".$uyeID."', '".$alan."', '".$ilanID."', 
			'".$gonderilecek_mesaj."','".$date."', '".$kullaniciToken."', '".$ihaleSahibi."');");
			$response=["message"=>"Başarılı.","status"=>200];
			*/
		}else{
			$sql2 = mysql_query("SELECT * FROM kullanici WHERE token = '".$ihaleSahibi."'  ");
			$alan = 0;
			/*
			$alan = "";
			$kaydet=mysql_query("INSERT INTO `mesajlar` (`id`, `ilan_id`, `gonderen_id`, `alan_id`, `dogrudan_satis_id`, `mesaj`,
					`gonderme_zamani`, `gonderen_token`, `alan_token`) 
						VALUES 
					(NULL, '', '".$uyeID."', '".$alan."', '".$ilanID."', '".$gonderilecek_mesaj."','".$date."', '".$kullaniciToken."', '".$ihaleSahibi."');");
			$response=["message"=>"Başarılı.","status"=>200];
			*/
		}

		if($ihaleSahibi==$uye_tkn){
			$response=["message"=>"Kendi ihalenize mesaj atamazsınız.","status"=>500];
		}else{
			$add_time = date('Y-m-d H:i:s');
			$cek = mysql_query("select * from chat_room where dogrudan_satis_id = '".$ilanID."' and gonderen_id = '".$uyeID."' and status = 1");
			if(mysql_num_rows($cek) != 0){
				$oku = mysql_fetch_object($cek);
				$room_id = $oku->id;
			}else{
				mysql_query("insert into chat_room(dogrudan_satis_id,gonderen_id,alan_id,add_time,status) values ('".$ilanID."','".$uyeID."','".$alan."','".$add_time."',1)");
				$room_cek = mysql_query("select * from chat_room where dogrudan_satis_id = '".$ilanID."' and gonderen_id = '".$uyeID."' and status = 1");
				$room_oku = mysql_fetch_object($room_cek);
				$room_id = $room_oku->id;
			}
			$add = mysql_query("insert into chat_messages(room_id,gonderen_id,gonderen_type,mesaj,add_time,status) values ('".$room_id."','".$uyeID."',1,'".$gonderilecek_mesaj."','".$add_time."',1)");
			// var_dump("insert into chat_messages(room_id,gonderen_id,gonderen_type,mesaj,add_time,status) values ('".$room_id."','".$uyeID."',1,'".$gonderilecek_mesaj."','".$add_time."',1)");
			if($add){
				mysql_query("update chat_room set last_message = '".$gonderilecek_mesaj."', last_message_time = '".$add_time."' where id = '".$room_id."'");
				$response=["message"=>"Başarılı.","status"=>200];
			}else{
				$response=["message"=>"İşlem sırasında bir hata oluştu. Lütfen daha sonra tekrar deneyiniz.","status"=>300];
			}
		}


		
		echo json_encode($response);
	}
		
?>