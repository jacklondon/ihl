 <?php 
	$id=re("id");
	$sorgu=mysql_query("select * from nasil_calisir_menu where id='".$id."' ");
	$row=mysql_fetch_object($sorgu);
	$mevcut_baslik=$row->baslik;
	$mevcut_aciklama=$row->aciklama;

	if(re('menu_guncelle') =='Menü Güncelle'){   
		$kayit = true;
		$hata_mesaj = '';
		$baslik=re("baslik");
		$aciklama=re("aciklama");
	
		if(re('aciklama') == "") { $kayit = false; $hata_mesaj .= 'Açıklama alanı boş olamaz,'; }
		if(re('baslik') == "") { $kayit = false; $hata_mesaj .= 'Başlık alanı boş olamaz,'; }
			if($kayit == true){
					$a=mysql_query("update nasil_calisir_menu set 	
					baslik='".$baslik."',aciklama='".$aciklama."'
		            where id ='".$id."'
					")or die(mysql_error());       
					
					alert("Başarıyla Güncellendi..");
					header("location: ?modul=nasil_calisir&sayfa=nasil_calisir_islemleri");
				}else{
					alert($hata_mesaj);
				}       	
		}
		
     

	
 ?>