 <?php 
	$id=re("id");
	$sorgu=mysql_query("select * from slider where id='".$id."' ");
	$row=mysql_fetch_object($sorgu);
	$mevcut_baslik=$row->baslik;
	$mevcut_aciklama=$row->aciklama;
	$mevcut_durum=$row->durum;
	
	$mevcut_button=$row->button;
	$mevcut_button_yer=$row->button_yer_secimi;
	$mevcut_button_editor=$row->editor;



	$mevcut_resim=$row->resim;
	if(re('slider_guncelle') =='Slider Güncelle'){   
		$kayit = true;
		$hata_mesaj = '';
		$baslik=re("baslik");
		$aciklama=re("aciklama");
		$durum=re("durum");//aktif->1,pasif->0
	
		if(re('durum') == "") { $kayit = false; $hata_mesaj .= 'Durum alanı boş olamaz,'; }
		if(re('button') == "") { $kayit = false; $hata_mesaj .= 'Buton durum alanı boş olamaz,'; }
		if(re('button_yer_secimi') == "") { $kayit = false; $hata_mesaj .= 'Buton yer seçimi alanı boş olamaz,'; }
		if(re('aciklama') == "") { $kayit = false; $hata_mesaj .= 'Açıklama alanı boş olamaz,'; }
		if(re('baslik') == "") { $kayit = false; $hata_mesaj .= 'Başlık alanı boş olamaz,'; }
		if($_FILES['files']['name'][0]==""){
			if($kayit == true){
					$a=mysql_query("update slider set 	
					baslik='".$baslik."',
					aciklama='".$aciklama."',
					resim='".$mevcut_resim."',
					durum='".$durum."',
					button='".re('button')."',
					button_yer_secimi='".re('button_yer_secimi')."',
					editor='".re('editor')."'
		            where id ='".$id."'
					")or die(mysql_error());       
					
					alert("Başarıyla Güncellendi..");
					header("location: ?modul=slider&sayfa=slider_islemleri");
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
						$a=mysql_query("update slider set 	
						baslik='".$baslik."',aciklama='".$aciklama."',resim='".$yol."',durum='".$durum."'
						where id ='".$id."'
						")or die(mysql_error());       
						
						alert("Başarıyla Güncellendi..");
						header("location: ?modul=slider&sayfa=slider_islemleri");
					}else{
						alert($hata_mesaj);
					}       	
				} 
		}
		
		
	
		
     }

	
 ?>
