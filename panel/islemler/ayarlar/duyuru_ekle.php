<?php 
	$admin_id=$_SESSION["kid"];
	$statusMsg = '';
	if(re("duyuru")=="Ekle"){
		if(re("baslik")!="" && re("icerik")!="" && $_FILES["file"]["name"]!=""){
			$targetDir = "../duyurular/";
			$fileName = basename($_FILES["file"]["name"]);
			$targetFilePath = $targetDir . $fileName;
			$fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);
			$allowTypes = array('jpg','png','jpeg','gif','pdf');
			
			if(in_array($fileType, $allowTypes)){
				if(move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)){
					$now = date('Y-m-d H:i:s');
					$yukle ="INSERT INTO `duyurular` (`id`, `baslik`, `kisa_icerik`, `icerik`, `resim`, `eklenme_zamani`, `durum`, `ekleyen`) VALUES 
					(NULL, '".re('baslik')."', '".re('kisa_icerik')."', '".re('icerik')."', '".$fileName."', '".$now."', '1', '".$admin_id."');";
					$insert = mysql_query($yukle);
					if($insert){
						echo '<script>alert("Dosya başarıyla yüklendi.")</script>';
						echo '<script>window.location.href="?modul=ayarlar&sayfa=duyurular" </script>';
						//$statusMsg = " ".$fileName. "  başarıyla yüklendi.";
					}else{
						//$statusMsg = "Dosya yükleme başarısız, lütfen tekrar deneyin.";
						echo '<script>alert("Dosya yükleme başarısız, lütfen tekrar deneyin.")</script>';
						echo '<script>window.location.href="?modul=ayarlar&sayfa=duyurular" </script>';
					} 
				}else{
					//$statusMsg = "Dosya yüklenirken bir hatayla karşılaşıldı";
					echo '<script>alert("Dosya yüklenirken bir hatayla karşılaşıldı".")</script>';
					echo '<script>window.location.href="?modul=ayarlar&sayfa=duyurular" </script>';
					
				}
			}else{
				//$statusMsg = 'Sadece JPG, JPEG, PNG, GIF, & PDF dosyaları geçerlidir.';
				echo '<script>alert("Sadece JPG, JPEG, PNG, GIF, & PDF dosyaları geçerlidir.")</script>';
				echo '<script>window.location.href="?modul=ayarlar&sayfa=duyurular" </script>';
			}
			
		}else{
			echo '<script>alert("Lütfen başlık,resim ve içerik kısımlarını eksiksiz doldurun.")</script>';
			echo '<script>window.location.href="?modul=ayarlar&sayfa=duyurular" </script>';
		}
	}


	if(re("a")=="b"){
		if(re("baslik")!="" && re("icerik")!="" && $_FILES["file"]["name"]!=""){
			$targetDir = "../duyurular/";
			$fileName = basename($_FILES["file"]["name"]);
			$targetFilePath = $targetDir . $fileName;
			$fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);
			$allowTypes = array('jpg','png','jpeg','gif','pdf');
			echo $_FILES["file"]["tmp_name"]."<br>";
			echo $targetFilePath."<br>";
			// die();
			if(in_array($fileType, $allowTypes)){
				if(move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)){
					$now = date('Y-m-d H:i:s');
					// $yukle ="INSERT INTO `duyurular` (`id`, `baslik`, `kisa_icerik`, `icerik`, `resim`, `eklenme_zamani`, `durum`, `ekleyen`) VALUES 
					// (NULL, '".re('baslik')."', '".re('kisa_icerik')."', '".re('icerik')."', '".$fileName."', '".$now."', '1', '".$admin_id."');";
					$yukle = "update duyurular set baslik = '".re('baslik')."', kisa_icerik = '".re('kisa_icerik')."', icerik = '".re('icerik')."',
					resim = '".$fileName."', guncelleme_zamani = '".$now."' where id = '".re('duyuru_id')."'";
					$insert = mysql_query($yukle);
					if($insert){
						echo '<script>alert("Dosya başarıyla yüklendi.")</script>';
						echo '<script>window.location.href="?modul=ayarlar&sayfa=duyurular" </script>';
						//$statusMsg = " ".$fileName. "  başarıyla yüklendi.";
					}else{
						//$statusMsg = "Dosya yükleme başarısız, lütfen tekrar deneyin.";
						echo '<script>alert("Dosya yükleme başarısız, lütfen tekrar deneyin.")</script>';
						echo '<script>window.location.href="?modul=ayarlar&sayfa=duyurular" </script>';
					} 
				}else{
					echo "burdaaa";
					die();
					//$statusMsg = "Dosya yüklenirken bir hatayla karşılaşıldı";
					echo '<script>alert("Dosya yüklenirken bir hatayla karşılaşıldı".")</script>';
					echo '<script>window.location.href="?modul=ayarlar&sayfa=duyurular" </script>';
					
				}
			}else{
				//$statusMsg = 'Sadece JPG, JPEG, PNG, GIF, & PDF dosyaları geçerlidir.';
				echo '<script>alert("Sadece JPG, JPEG, PNG, GIF, & PDF dosyaları geçerlidir.")</script>';
				echo '<script>window.location.href="?modul=ayarlar&sayfa=duyurular" </script>';
			}
			
		}else{
			echo '<script>alert("Lütfen başlık,resim ve içerik kısımlarını eksiksiz doldurun.")</script>';
			echo '<script>window.location.href="?modul=ayarlar&sayfa=duyurular" </script>';
		}
		/*
		if(re("baslik")!="" && re("icerik")!="" && $_FILES["file"]["name"]!=""){
			$targetDir = "../duyurular/";
			$fileName = basename($_FILES["file"]["name"]);
			$targetFilePath = $targetDir . $fileName;
			$fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);
			$allowTypes = array('jpg','png','jpeg','gif','pdf');
			if(in_array($fileType, $allowTypes)){
				// move_uploaded_file($dosya_gecici, "$klasor/" . $yenisim);
				if(move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)){
					$now = date('Y-m-d H:i:s');
					// $yukle ="INSERT INTO `duyurular` (`id`, `baslik`, `kisa_icerik`, `icerik`, `resim`, `eklenme_zamani`, `durum`, `ekleyen`) VALUES 
					// (NULL, '".re('baslik')."', '".re('kisa_icerik')."', '".re('icerik')."', '".$fileName."', '".$now."', '1', '".$admin_id."');";
					$yukle = "update duyurular set baslik = '".re('baslik')."', kisa_icerik = '".re('kisa_icerik')."', icerik = '".re('icerik')."',
					resim = '".$fileName."', guncelleme_zamani = '".$now."' where id = '".re('duyuru_id')."'";
					$insert = mysql_query($yukle);
					if($insert){
						echo '<script>alert("Dosya başarıyla yüklendi.")</script>';
						echo '<script>window.location.href="?modul=ayarlar&sayfa=duyurular" </script>';
						//$statusMsg = " ".$fileName. "  başarıyla yüklendi.";
					}else{
						//$statusMsg = "Dosya yükleme başarısız, lütfen tekrar deneyin.";
						echo '<script>alert("Dosya yükleme başarısız, lütfen tekrar deneyin.")</script>';
						echo '<script>window.location.href="?modul=ayarlar&sayfa=duyurular" </script>';
					} 
				}else{
					//$statusMsg = "Dosya yüklenirken bir hatayla karşılaşıldı";
					echo '<script>alert("Dosya yüklenirken bir hatayla karşılaşıldı".")</script>';
					echo '<script>window.location.href="?modul=ayarlar&sayfa=duyurular" </script>';
					
				}
			}else{
				//$statusMsg = 'Sadece JPG, JPEG, PNG, GIF, & PDF dosyaları geçerlidir.';
				echo '<script>alert("Sadece JPG, JPEG, PNG, GIF, & PDF dosyaları geçerlidir.")</script>';
				echo '<script>window.location.href="?modul=ayarlar&sayfa=duyurular" </script>';
			}
		}else{
			echo '<script>alert("Lütfen başlık,resim ve içerik kısımlarını eksiksiz doldurun.")</script>';
			echo '<script>window.location.href="?modul=ayarlar&sayfa=duyurular" </script>';
		}
		*/
	}



	
	
	
	// File upload path
	/*$targetDir = "../duyurular/";
	$fileName = basename($_FILES["file"]["name"]);
	$targetFilePath = $targetDir . $fileName;
	$fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);

	if(isset($_POST["duyuru"]) && !empty($_FILES["file"]["name"])){
		// Allow certain file formats
		$allowTypes = array('jpg','png','jpeg','gif','pdf');
		if(in_array($fileType, $allowTypes)){
			// Upload file to server
			if(move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)){
				$now = date('Y-m-d H:i:s');
				$yukle ="INSERT INTO `duyurular` (`id`, `baslik`, `icerik`, `resim`, `eklenme_zamani`, `durum`, `ekleyen`) VALUES 
				(NULL, '".re('baslik')."', '".re('icerik')."', '".$fileName."', '".$now."', '1', '');";
				$insert = mysql_query($yukle);
			
				
				if($insert){
					$statusMsg = " ".$fileName. "  başarıyla yüklendi.";
				}else{
					$statusMsg = "Dosya yükleme başarısız, lütfen tekrar deneyin.";
				} 
			}else{
				$statusMsg = "Dosya yüklenirken bir hatayla karşılaşıldı";
			}
		}else{
			$statusMsg = 'Sadece JPG, JPEG, PNG, GIF, & PDF dosyaları geçerlidir.';
		}
	}
	else {
		$yukle ="INSERT INTO `duyurular` (`baslik`, `icerik`, `resim`, `eklenme_zamani`, `durum`, `ekleyen`) VALUES 
		('".re('baslik')."', '".re('icerik')."', '', '".$now."', '1', '');";
		  $insert = mysql_query($yukle);
	}*/

	//echo $statusMsg;

?>