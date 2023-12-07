  <?php 
	
	$sorgu=mysql_query("select * from pdf ");
	$row=mysql_fetch_object($sorgu);
	$mevcut_pdf=$row->vekaletname;
	$mevcut_word=$row->vekaletname_word;
	$id=$row->id;
	if(re('pdf_guncelle') =='Güncelle'){   
		$kayit = true;
		$hata_mesaj = '';
		if($_FILES['files']['name'][0]==""  ){
			if($kayit == true){
					$a=mysql_query("update vekaletname_pdf set 	
					vekaletname='".$mevcut_pdf."'
		            where id ='".$id."'
					")or die(mysql_error());       
					
					alert("Başarıyla Güncellendi..");
				}else{
					alert($hata_mesaj);
				}       	
		}
		else
		{
			$errors= array(); 
			foreach($_FILES['files']['tmp_name'] as $key => $tmp_name ){ 
				$dosya_adi =$_FILES['files']['name'][$key]; 		// uzantiya beraber dosya adi 
				$dosya_boyutu =$_FILES['files']['size'][$key];    		// byte cinsinden dosya boyutu 
				$dosya_gecici =$_FILES['files']['tmp_name'][$key];		//gecici dosya adresi 
				$yenisim=md5(microtime()).'.'.'pdf'; 					//karmasik yeni isim.pdf 
				if($dosya_boyutu > 20971520){ 
					$errors[]='Maksimum 20 Mb lık dosya yuklenebilir.'; 
				}		                     
				$klasor="../images/pdf"; // yuklenecek dosyalar icin yeni klasor 
				if(empty($errors)==true){  //eger hata yoksa 
					if(is_dir("$klasor/".$yenisim)==false){  //olusturdugumuz isimde dosya var mı?  
						$test=move_uploaded_file($dosya_gecici,"$klasor/".$yenisim);//yoksa yeni ismiyle kaydet 
						if($test==false){
							$kayit = false; $hata_mesaj .= 'PDF Alanı boş olamaz,';
						}
					}else{									//eger varsa 
						$new_dir="$klasor/".$yenisim.time(); //yeni ismin sonuna eklenme zamanını ekle 
						rename($dosya_gecici,$new_dir) ;				 
					}            			 
				}else{ 
					 print_r($errors); //varsa hataları yazdır 
				} 
			} 
			$yol='images/pdf/'.$yenisim;
		
			if(empty($errors)){ 
				if($kayit == true){
					$a=mysql_query("update vekaletname_pdf set 	
					vekaletname='".$yol."'
					where id ='".$id."'
					")or die(mysql_error());       
					
					alert("Başarıyla Güncellendi..");
				}else{
					alert($hata_mesaj);
				}       	
			} 
		}

    }
	if(re('word_guncelle') =='Güncelle'){   
		$kayit = true;
		$hata_mesaj = '';
		if($_FILES['files']['name'][0]==""  ){
			if($kayit == true){
					$a=mysql_query("update vekaletname_pdf set 	
					vekaletname_word='".$mevcut_word."'
		            where id ='".$id."'
					")or die(mysql_error());       
					
					alert("Başarıyla Güncellendi..");
				}else{
					alert($hata_mesaj);
				}       	
		}
		else
		{
			$errors= array(); 
			$allowed = array("application/msword","application/vnd.openxmlformats-officedocument.wordprocessingml.document");
			foreach($_FILES['files']['tmp_name'] as $key => $tmp_name ){ 
				$dosya_adi =$_FILES['files']['name'][$key]; 		// uzantiya beraber dosya adi 
				$dosya_boyutu =$_FILES['files']['size'][$key];    		// byte cinsinden dosya boyutu 
				$dosya_gecici =$_FILES['files']['tmp_name'][$key];		//gecici dosya adresi 
				$file_type =$_FILES['files']['type'][$key];
				$yenisim=md5(microtime()).$dosya_adi;			//karmasik yeni isim.pdf 
				if($dosya_boyutu > 20971520){ 
					$errors[]='Maksimum 20 Mb lık dosya yuklenebilir.'; 
				}	
				if(!in_array($file_type, $allowed)) {
					$errors[]=' .doc ve .docx uzantılı dosyalar yüklenebilir.'; 
				}				
				$klasor="../images/pdf"; // yuklenecek dosyalar icin yeni klasor 
				if(empty($errors)==true){  //eger hata yoksa 
					if(is_dir("$klasor/".$yenisim)==false){  //olusturdugumuz isimde dosya var mı?  
						$test=move_uploaded_file($dosya_gecici,"$klasor/".$yenisim);//yoksa yeni ismiyle kaydet 
						if($test==false){
							$kayit = false; $hata_mesaj .= 'Dosya Alanı boş olamaz,';
						}
					}else{									//eger varsa 
						$new_dir="$klasor/".$yenisim.time(); //yeni ismin sonuna eklenme zamanını ekle 
						rename($dosya_gecici,$new_dir) ;				 
					}            			 
				}else{ 
					 print_r($errors); //varsa hataları yazdır 
				} 
			} 
			$yol='images/pdf/'.$yenisim;
		
			if(empty($errors)){ 
				if($kayit == true){
					$a=mysql_query("update vekaletname_pdf set 	
					vekaletname_word='".$yol."'
					where id ='".$id."'
					")or die(mysql_error());       
					
					alert("Başarıyla Güncellendi..");
				}else{
					alert($hata_mesaj);
				}       	
			} 
		}
	}

	
 ?>