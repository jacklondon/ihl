<?php
	
	$kategori_select="";
	$kategori_sor=mysql_query("select * from m_referans_kategoriler where durum='1'");
	while($kategori_cek=mysql_fetch_array($kategori_sor))
	{
		$referans_kategori_bas.='<tr>
									<td>'.$kategori_cek['id'].'</td>
									<td>'.$kategori_cek['baslik'].'</td>
									<td>'.$kategori_cek['link'].'</td>
									<td>
										<a href="?modul=icerik&sayfa=referanslar&kat_sil='.$kategori_cek['id'].'">
											sil
										</a>
									</td>
								</tr>';
								
		$kategori_select.='<option value="'.$kategori_cek['id'].'">'.$kategori_cek['baslik'].'</option>';
	}

	$referans_oku=mysql_query("select * from m_referans_icerik where durum='1'");
	while($referans_cek=mysql_fetch_array($referans_oku))
	{
		$kategori_sorgu=mysql_query("select * from m_referans_kategoriler where id='".$referans_cek['kategori']."'");
		$kategori_okuma=mysql_fetch_assoc($kategori_sorgu);
		
		$referans_bas.='<tr>
						<td>'.$referans_cek['id'].'</td>
						<td>'.$referans_cek['baslik'].'</td>
						<td>'.$referans_cek['icerik'].'</td>
						<td>'.$referans_cek['detay'].'</td>
						<td>Resim</td>
						<td>'.$kategori_okuma['baslik'].'</td>
						<td>'.$referans_cek['link'].'</td>
						<td><a href="?modul=icerik&sayfa=referanslar&sil='.$referans_cek['id'].'">
								sil
							</a>
						</td>
					</tr>';
		
	}
	$referans_bas.='
				<tr>
					<td>#</td>
					<td style="widtd:100px;">Referans Arkaplan</td>
					<td></td>
					<td></td>
					<td><input type="file" name="referans_arkaplan" id="referans_arkaplan" /></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>';
					
	$referans_bas.='
					<tr>
						<td>#</td>
						<td style="widtd:100px;"><input type="text" class="form-control" name="baslik" value="" style="width: 70px;"/></td>
						<td><textarea name="icerik" class="form-control" style="width: 100px;"></textarea></td>
						<td><textarea name="detay" class="form-control" style="width: 100px;"></textarea></td>
						<td><input type="file" name="referans_resim" id="referans_resim" /></td>
						<td>
							<select name="kategori" style="width: 70px;">
								'.$kategori_select.'
							</select>
						</td>
						<td><input type="text" name="link" class="form-control" value="" style="width: 120px;" /></td>
						<td>
							<input type="submit" name="ref_kaydet" id="ref_kaydet" value="kaydet" />
						</td>
					</tr>';
					
	if(re('sil')!="")
	{
		mysql_query("UPDATE m_referans_icerik SET durum='0' WHERE id='".re('sil')."' ");
		alert('Görsel Silindi');
		header('Location: ?modul=icerik&sayfa=referanslar');
	}
	
	if(re('ref_kaydet')=="kaydet")
	{
		if ( $_FILES['referans_resim']['name'] != "" )
		{
			$yeni_ad='../images/'.$_FILES['referans_resim']['name'];
			$imageFileType = $_FILES['referans_resim']['type'];
			$resim=$_FILES['referans_resim']['name'];
			$uz_bol=explode('/',$imageFileType);
			
			if ( move_uploaded_file($_FILES['referans_resim']['tmp_name'],$yeni_ad) )
			{
				$klasor='';
				$adi=$yeni_ad;
				$tipi=$imageFileType;
				$genislik='340';
				$yukseklik='300';
				$yeniisim=$yeni_ad;
				
				if($imageFileType=='image/jpg')
				{
					$kayitli_isim=resimYukle($klasor,$adi,$tipi,$genislik,$yukseklik,$yeniisim);
				}

				mysql_query("INSERT INTO  m_referans_icerik ( 
				kategori ,  
				resim ,  
				link ,  
				baslik ,  
				icerik ,  
				detay ,  
				durum 
				) VALUES (
				'".re('kategori')."',
				'".$resim."',
				'".re('link')."',
				'".re('baslik')."',
				'".re('icerik')."',
				'".re('detay')."',
				'1')");
				header('Location: ?modul=icerik&sayfa=referanslar');
				
			}
			
		}
		
		if ( $_FILES['referans_arkaplan']['name'] != "" )
		{
			$yeni_ad='../images/'.$_FILES['referans_arkaplan']['name'];
			$imageFileType = $_FILES['referans_arkaplan']['type'];
			$resim_arka=$_FILES['referans_arkaplan']['name'];
			$uz_bol=explode('/',$imageFileType);
			
			if ( move_uploaded_file($_FILES['referans_arkaplan']['tmp_name'],$yeni_ad) )
			{
				$klasor='';
				$adi=$yeni_ad;
				$tipi=$imageFileType;
				$genislik='340';
				$yukseklik='300';
				$yeniisim=$yeni_ad;
				
				if($imageFileType=='image/jpg')
				{
					$kayitli_isim=resimYukle($klasor,$adi,$tipi,$genislik,$yukseklik,$yeniisim);
				}

				mysql_query("UPDATE site_tasarim SET referans_arkaplan='".$resim_arka."' WHERE id=1");
				header('Location: ?modul=icerik&sayfa=referanslar');
				
			}
			
		}
	}
	
?>