<?php 
/*
	if(re('evragi') =='Yukle'){   
		session_start();
		$token = $_SESSION['u_token'];
		if($token){
			$uye_token = $token;
		}
		include '../../ayar.php';
		$not = re('not');
		//$gizlilik = re('gizlilik');
		$statusMsg = '';
		if(isset($_FILES['files'])){     // dosya tanımlanmıs mı? 
			$errors= array(); 
			$allowed = array("application/pdf","application/vnd.ms-excel","application/msword","image/jpeg","image/png","application/vnd.openxmlformats-officedocument.wordprocessingml.document");
			foreach($_FILES['files']['tmp_name'] as $key => $tmp_name ){ 
				$dosya_adi =$_FILES['files']['name'][$key]; 		// uzantiya beraber dosya adi 
				$dosya_boyutu =$_FILES['files']['size'][$key];    		// byte cinsinden dosya boyutu 
				$dosya_gecici =$_FILES['files']['tmp_name'][$key];		//gecici dosya adresi 
				$file_type =$_FILES['files']['type'][$key];	
				$yenisim=md5(microtime()).$dosya_adi; 					//karmasik yeni isim.pdf 
				if($dosya_boyutu > 20971520){ 
					$errors[]='Maksimum 20 Mb lık dosya yuklenebilir.'; 
				}
				if(!in_array($file_type, $allowed)) {
					$errors[]='jpg,jpeg,png,doc,xls uzantılı dosyalar yüklenebilir.'; 
				}
				$klasor="../assets/"; // yuklenecek dosyalar icin yeni klasor 
				if(empty($errors)==true){  //eger hata yoksa 
					if(is_dir("$klasor/".$yenisim)==false){  //olusturdugumuz isimde dosya var mı?  
						$test=move_uploaded_file($dosya_gecici,"$klasor/".$yenisim);//yoksa yeni ismiyle kaydet 
						if($test==false){
							$kayit = false; $hata_mesaj .= 'Resim Alanı boş olamaz,';
						}else{
							$uye_cek = mysql_query("SELECT * FROM user WHERE user_token = '".$uye_token."' LIMIT 1");
							$uye_oku = mysql_fetch_array($uye_cek);
							$now = date('Y-m-d H:i:s');
							$uyeID = $uye_oku['id'];
							$yukle ="INSERT INTO `yuklenen_evraklar` (`id`, `user_id`, `icerik`, `gonderme_zamani`, `not`, `gizlilik`) 
							VALUES (NULL, '".$uyeID."', '".$yenisim."', '".$now."', '".$not."', '2')";
							$insert = mysql_query($yukle);
							if($insert){
								$statusMsg = " <text style='color:green;font-weight:bold;' >Dosyalar başarıyla yüklendi.</text>";
							}else{
								$statusMsg = "Dosya yükleme başarısız, lütfen tekrar deneyin.";
							} 
						}
					}else{									//eger varsa 
						$new_dir="$klasor/".$yenisim.time(); //yeni ismin sonuna eklenme zamanını ekle 
						rename($dosya_gecici,$new_dir) ;				 
					}            			 
				}else{ 
					 print_r($errors); //varsa hataları yazdır 
				} 
			} 
		}
		echo $statusMsg;
	}
*/
?>


<?php 

	if(re('evragi') =='Yukle'){   
		session_start();
		$token = $_SESSION['u_token'];
		if($token){
			$uye_token = $token;
		}
		include '../../ayar.php';
		$not = re('not');
		//$gizlilik = re('gizlilik');
		$uye_cek = mysql_query("SELECT * FROM user WHERE user_token = '".$uye_token."' LIMIT 1");
		$uye_oku = mysql_fetch_array($uye_cek);
		$now = date('Y-m-d H:i:s');
		$uyeID = $uye_oku['id'];	
		$yukle = mysql_query("INSERT INTO `yuklenen_evraklar` (`id`,`user_id`,`gonderme_zamani`,`not`,`gizlilik`) VALUES (NULL,'".$uyeID."','".$now."','".$not."','2')");
		if($yukle){
			$statusMsg = '';
			if(isset($_FILES['files'])){ // dosya tanımlanmıs mı? 
				$errors= array(); 
				$allowed = array("application/pdf","application/vnd.ms-excel","application/msword","image/jpeg","image/png","application/vnd.openxmlformats-officedocument.wordprocessingml.document");
				$basarili_sayi = 0;
				foreach($_FILES['files']['tmp_name'] as $key => $tmp_name ){ 
					$dosya_adi =$_FILES['files']['name'][$key]; 		// uzantiya beraber dosya adi 
					$dosya_boyutu =$_FILES['files']['size'][$key];    		// byte cinsinden dosya boyutu 
					$dosya_gecici =$_FILES['files']['tmp_name'][$key];		//gecici dosya adresi 
					$file_type =$_FILES['files']['type'][$key];	
					$yenisim=md5(microtime()).$dosya_adi; 					//karmasik yeni isim.pdf 
					// if($dosya_boyutu > 20971520){ 
					// 	$errors[]='Maksimum 20 Mb lık dosya yuklenebilir.'; 
					// }
					// if(!in_array($file_type, $allowed)) {
					// 	$errors[]='jpg,jpeg,png,doc,xls uzantılı dosyalar yüklenebilir.'; 
					// }
					$klasor="../assets/"; // yuklenecek dosyalar icin yeni klasor 
					if(empty($errors)==true){  //eger hata yoksa 
						if(is_dir("$klasor/".$yenisim)==false){  //olusturdugumuz isimde dosya var mı?  
							$test=move_uploaded_file($dosya_gecici,"$klasor/".$yenisim);//yoksa yeni ismiyle kaydet 
							if($test==false){
								$kayit = false; $hata_mesaj .= 'Resim Alanı boş olamaz,';
							}else{
								$cek = mysql_query("select * from yuklenen_evraklar where user_id = '".$uyeID."' and gonderme_zamani = '".$now."'");
								$oku = mysql_fetch_object($cek);
								$evrak_id = $oku->id;
								$insert = mysql_query("insert into yuklenen_evrak_dosya(evrak_id,icerik,add_time,status) values ('".$evrak_id."','".$yenisim."','".$now."',1)");
								if($insert){
									$basarili_sayi += 1;
									$statusMsg = " <text style='color:green;font-weight:bold;' >Dosyalar başarıyla yüklendi.</text>";
								}else{
									$statusMsg = "Dosya yükleme başarısız, lütfen tekrar deneyin.";
								} 
							}
						}else{									//eger varsa 
							$new_dir="$klasor/".$yenisim.time(); //yeni ismin sonuna eklenme zamanını ekle 
							rename($dosya_gecici,$new_dir) ;				 
						}            			 
					}else{ 
						if($basarili_sayi == 0){
							mysql_query("delete from yuklenen_evraklar where user_id = '".$uyeID."' and gonderme_zamani = '".$now."'");
						}
						foreach($errors as $error){
							echo $error."\n";
						}
					} 
				} 
			}else{
				mysql_query("delete from yuklenen_evraklar where user_id = '".$uyeID."' and gonderme_zamani = '".$now."'");
			}
		}
		echo $statusMsg;
	}

?>







