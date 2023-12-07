  <?php 
	
	$sorgu=mysql_query("select * from pdf ");
	$row=mysql_fetch_object($sorgu);
	$mevcut_pdf=$row->kullanim_sartlari;
	$mevcut_pdf2=$row->vekaletname;
	$id=$row->id;
	if(re('pdf_guncelle') =='Güncelle'){   
		$kayit = true;
		$hata_mesaj = '';

		if($_FILES['files']['name'][0]=="" && $_FILES['files2']['name'][0]=="" ){
			if($kayit == true){
					$a=mysql_query("update pdf set 	
					kullanim_sartlari='".$mevcut_pdf."',vekaletname='".$mevcut_pdf2."'
		            where id ='".$id."'
					")or die(mysql_error());       
					
					alert("Başarıyla Güncellendi..");
				}else{
					alert($hata_mesaj);
				}       	
		}
		else if($_FILES['files']['name'][0]!="" && $_FILES['files2']['name'][0]=="" ){
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
				
				if(empty($error)){ 
					if($kayit == true){
						$a=mysql_query("update pdf set 	
						kullanim_sartlari='".$yol."',vekaletname='".$mevcut_pdf2."'
						where id ='".$id."'
						")or die(mysql_error());       
						
						alert("Başarıyla Güncellendi.");
					}else{
						alert($hata_mesaj);
					}       	
				}        	
		}
		else if($_FILES['files']['name'][0]=="" && $_FILES['files2']['name'][0]!="" ){
				$errors= array(); 
				foreach($_FILES['files2']['tmp_name'] as $key => $tmp_name ){ 
					$dosya_adi =$_FILES['files2']['name'][$key]; 		// uzantiya beraber dosya adi 
					$dosya_boyutu =$_FILES['files2']['size'][$key];    		// byte cinsinden dosya boyutu 
					$dosya_gecici =$_FILES['files2']['tmp_name'][$key];		//gecici dosya adresi 
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
				
				if(empty($error)){ 
					if($kayit == true){
						$a=mysql_query("update pdf set 	
						kullanim_sartlari='".$mevcut_pdf."',vekaletname='".$yol."'
						where id ='".$id."'
						")or die(mysql_error());       
						
						alert("Başarıyla Güncellendi.");
					}else{
						alert($hata_mesaj);
					}       	
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
				
				$errors2= array(); 
				foreach($_FILES['files2']['tmp_name'] as $key => $tmp_name ){ 
					$dosya_adi2 =$_FILES['files2']['name'][$key]; 		// uzantiya beraber dosya adi 
					$dosya_boyutu2 =$_FILES['files2']['size'][$key];    		// byte cinsinden dosya boyutu 
					$dosya_gecici2 =$_FILES['files2']['tmp_name'][$key];		//gecici dosya adresi 
					$yenisim2=md5(microtime()).'.'.'pdf'; 					//karmasik yeni isim.pdf 
					if($dosya_boyutu2 > 20971520){ 
						$errors2[]='Maksimum 20 Mb lık dosya yuklenebilir.'; 
					}		                     
					$klasor2="../images/pdf"; // yuklenecek dosyalar icin yeni klasor 
					if(empty($errors2)==true){  //eger hata yoksa 
						if(is_dir("$klasor/".$yenisim2)==false){  //olusturdugumuz isimde dosya var mı?  
							$test2=move_uploaded_file($dosya_gecici2,"$klasor/".$yenisim2);//yoksa yeni ismiyle kaydet 
							if($test2==false){
								$kayit = false; $hata_mesaj .= 'PDF Alanı boş olamaz,';
							}
						}else{									//eger varsa 
							$new_dir2="$klasor/".$yenisim2.time(); //yeni ismin sonuna eklenme zamanını ekle 
							rename($dosya_gecici2,$new_dir2) ;				 
						}            			 
					}else{ 
						 print_r($errors2); //varsa hataları yazdır 
					} 
				} 
				$yol2='images/pdf/'.$yenisim2;
				if(empty($error)){ 
					if($kayit == true){
						$a=mysql_query("update pdf set 	
						kullanim_sartlari='".$yol."',vekaletname='".$yol2."'
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