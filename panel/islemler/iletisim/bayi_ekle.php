 <?php 
		if(re('bayi_kaydet') =='Bayi Kaydet'){   
		$kayit = true;
		$hata_mesaj = '';
		$bayi_adi=re("bayi_adi");

		if(re('bayi_adi') == "") { $kayit = false; $hata_mesaj .= 'Bayi adı alanı boş olamaz,'; }

		if($kayit == true){
			$a=mysql_query("insert into bayiler (id,bayi_adi,olusturulma_zamani)
			values
			(null,'".$bayi_adi."','".date('Y-m-d H:i:s')."')
			
			")or die(mysql_error());       
			
			alert("Başarıyla Eklendi..");
			header("Location:?modul=iletisim&sayfa=iletisim_islemleri");
		}else{
			alert($hata_mesaj);
		}       	
			 
		
     }

	
 ?>