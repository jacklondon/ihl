   <?php 
	$id=re("id");
	$sorgu=mysql_query("select * from bayiler where id='".$id."' ");
	$row=mysql_fetch_object($sorgu);
	$mevcut_bayi_adi=$row->bayi_adi;

	if(re('bayi_guncelle') =='Bayi Güncelle'){   
		$kayit = true;
		$hata_mesaj = '';
		$bayi_adi=re("bayi_adi");

	
		if(re('bayi_adi') == "") { $kayit = false; $hata_mesaj .= 'Bayi adı alanı boş olamaz,'; }


		if($kayit == true){
				$a=mysql_query("update bayiler set 	
				bayi_adi='".$bayi_adi."' 
				where id ='".$id."'
				")or die(mysql_error());       
				
				alert("Başarıyla Güncellendi..");
				header("location: ?modul=iletisim&sayfa=iletisim_islemleri");
			}else{
				alert($hata_mesaj);
			}       	
		
		
     }

	
 ?>