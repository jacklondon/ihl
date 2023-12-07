<?php 
session_start();
$admin_id = $_SESSION['kid'];
    if(re('reklam_ayarlarini')=="Kaydet"){
        $reklam_url = re('reklam_url');
        $reklam_baslangic = re('reklam_baslangic');
        $reklam_bitis = re('reklam_bitis');
        $icerik = re('reklam_ayarlari');
        $tarih = date('Y-m-d H:i:s');

        $statusMsg = '';

        $fileTmpPath = $_FILES['uploadedFile']['tmp_name'];
        $fileName = $_FILES['uploadedFile']['name'];
        $fileSize = $_FILES['uploadedFile']['size'];
        $fileType = $_FILES['uploadedFile']['type'];

        // File upload path
        $targetDir = "../reklamlar/";
        $fileName = basename($_FILES["file"]["name"]);
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));
        $newFileName =md5(time() . $fileName) . '.' . $fileExtension;
        $targetFilePath = $targetDir . $newFileName;
        $fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);
        
        if($reklam_baslangic==""){
			$statusMsg = 'Reklam başlangıcı belirlemelisiniz.';
		}else if($reklam_baslangic==""){
			$statusMsg = 'Reklam bitişi belirlemelisiniz.';
		}else if( $fileName==""){
			$guncelle=mysql_query("update reklamlar set baslangic_tarihi='".$reklam_baslangic."',bitis_tarihi='".$reklam_bitis."',icerik='".$icerik."',url='".$reklam_url."' where id='".re("id")."' ");
			header("Location:?modul=ayarlar&sayfa=reklam_guncelle&id=".re("id")."");
		}else{
			if(isset($_POST["reklam_ayarlarini"]) && !empty($_FILES["file"]["name"])){
				// Allow certain file formats
				$allowTypes = array('jpg','png','jpeg','gif');
				if(in_array($fileType, $allowTypes)){
					// Upload file to server $fileName adı
					if(move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)){
						// Insert image file name into database
						$guncelle=mysql_query("update reklamlar set resim='".$newFileName."',baslangic_tarihi='".$reklam_baslangic."',bitis_tarihi='".$reklam_bitis."',icerik='".$icerik."',url='".$reklam_url."' where id='".re("id")."' ");
						if($guncelle){
							$statusMsg = " ".$fileName. "  başarıyla yüklendi.";
								header("Location:?modul=ayarlar&sayfa=reklam_guncelle&id=".re("id")."");
						}else{
							$statusMsg = "Dosya yükleme başarısız, lütfen tekrar deneyin.";
						} 
					}else{
						$statusMsg = "Dosya yüklenirken bir hatayla karşılaşıldı";
					}
				}else{
					$statusMsg = 'Sadece JPG, JPEG, PNG, GIF, & PDF dosyaları geçerlidir.';
				}
			}else{
				$statusMsg = 'Lütfen dosya seçin.';
			}
			
			// Display status message
			echo $statusMsg;
		}
    }
?>