<?php 
		if(re('slider_kaydet') =='Slider Kaydet'){   
		$kayit = true;
		$hata_mesaj = '';
		$baslik=re("baslik");
		$aciklama=re("aciklama");
		$durum=re("durum");//aktif->1,pasif->0
		
		if(re('durum') == "") { $kayit = false; $hata_mesaj .= 'Durum alanı boş olamaz,'; }
		if(re('aciklama') == "") { $kayit = false; $hata_mesaj .= 'Açıklama alanı boş olamaz,'; }
		if(re('baslik') == "") { $kayit = false; $hata_mesaj .= 'Başlık alanı boş olamaz,'; }
	
		
	
		if(isset($_FILES['files'])){     // dosya tanımlanmıs mı? 
			$errors= array(); 
			foreach($_FILES['files']['tmp_name'] as $key => $tmp_name ){ 
				$dosya_adi =$_FILES['files']['name'][$key]; 		// uzantiya beraber dosya adi 
				$dosya_boyutu =$_FILES['files']['size'][$key];    		// byte cinsinden dosya boyutu 
				$dosya_gecici =$_FILES['files']['tmp_name'][$key];		//gecici dosya adresi 
				$yenisim=md5(microtime()).'.'.'png'; 					//karmasik yeni isim.pdf 
				if($dosya_boyutu > 20971520){ 
					$errors[]='Maksimum 20 Mb lık dosya yuklenebilir.'; 
				}		                     
				$klasor="../images/sliders"; // yuklenecek dosyalar icin yeni klasor 
				if(empty($errors)==true){  //eger hata yoksa 
					if(is_dir("$klasor/".$yenisim)==false){  //olusturdugumuz isimde dosya var mı?  
						$test=move_uploaded_file($dosya_gecici,"$klasor/".$yenisim);//yoksa yeni ismiyle kaydet 
						if($test==false){
							$kayit = false; $hata_mesaj .= 'Resim Alanı boş olamaz,';
						}
					}else{									//eger varsa 
						$new_dir="$klasor/".$yenisim.time(); //yeni ismin sonuna eklenme zamanını ekle 
						rename($dosya_gecici,$new_dir) ;				 
					}            			 
				}else{ 
					 print_r($errors); //varsa hataları yazdır 
				} 
			} 
			$yol='images/sliders/'.$yenisim;
			
			if(empty($error)){ 
				if($kayit == true){
					$a=mysql_query("insert into slider (id,baslik,aciklama,resim,durum,olusturulma_zamani)
					values
					(null,'".$baslik."','".$aciklama."','".$yol."','".$durum."','".date('Y-m-d H:i:s')."')
					
					
					")or die(mysql_error());       
					
					alert("Başarıyla Eklendi..");
					header("Location:?modul=slider&sayfa=slider_islemleri");
				}else{
					alert($hata_mesaj);
				}       	
			} 
		}
     }

	
 ?>