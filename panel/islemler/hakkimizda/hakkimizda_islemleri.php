  <?php 
	
	$sorgu=mysql_query("select * from hakkimizda ");
	$row=mysql_fetch_object($sorgu);
	
	$mevcut_baslik=$row->baslik;
	$mevcut_aciklama=$row->aciklama;
	$mevcut_resim=$row->resim;
	$id=$row->id;
	if(re('hakkimizda_guncelle') =='Güncelle'){   
		$kayit = true;
		$hata_mesaj = '';
		$baslik=re("baslik");
		$aciklama=re("aciklama");

		if(re('aciklama') == "") { $kayit = false; $hata_mesaj .= 'Açıklama alanı boş olamaz,'; }
		if(re('baslik') == "") { $kayit = false; $hata_mesaj .= 'Başlık alanı boş olamaz,'; }
		if($_FILES['files']['name'][0]==""){
			if($kayit == true){
					$a=mysql_query("update hakkimizda set 	
					baslik='".$baslik."',aciklama='".$aciklama."',resim='".$mevcut_resim."'
		            where id ='".$id."'
					")or die(mysql_error());       
					
					alert("Başarıyla Güncellendi..");
					header("location: ?modul=hakkimizda&sayfa=hakkimizda_islemleri");
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
					$yenisim=md5(microtime()).'.'.'png'; 					//karmasik yeni isim.pdf 
					if($dosya_boyutu > 20971520){ 
						$errors[]='Maksimum 20 Mb lık dosya yuklenebilir.'; 
					}		                     
					$klasor="../images/hakkimizda"; // yuklenecek dosyalar icin yeni klasor 
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
				$yol='images/hakkimizda/'.$yenisim;
				
				if(empty($error)){ 
					if($kayit == true){
						$a=mysql_query("update hakkimizda set 	
						baslik='".$baslik."',aciklama='".$aciklama."',resim='".$yol."'
						where id ='".$id."'
						")or die(mysql_error());       
						
						alert("Başarıyla Güncellendi..");
						header("location: ?modul=hakkimizda&sayfa=hakkimizda_islemleri");
					}else{
						alert($hata_mesaj);
					}       	
				} 
		}
		
		
	
		
     }

	
 ?>