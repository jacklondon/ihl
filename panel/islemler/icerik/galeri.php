<?php
	$resim_oku=mysql_query("select * from m_galeri where durum='1'");
	while($resim_cek=mysql_fetch_array($resim_oku))
	{
		$resim_bas.='<tr>
			<td>'.$resim_cek['id'].'</td>
			<td>'.$resim_cek['baslik'].'</td>
			<td><img src="../images/'.$resim_cek['resim'].'" width="150"/></td>
			<td>
				<a href="?modul=icerik&sayfa=galeri&sil='.$resim_cek['id'].'">
					sil
				</a>
			</td>
		</tr>';
		
	}
	$resim_bas.='
					<tr>
						<td>
						#
						</td>
						<td>
							Galeri Arka Fon
						</td>
						<td>
							<input type="color" name="galeri_arka" id="galeri_arka" value='.$ozellik_oku['galeri_arka_fon'].' />
						</td>
						<td>
						</td>
					</tr>
					
					<tr>
						<td>
							#
						</td>
						<td>
							<input type="text" name="galeri_baslik" id="galeri_baslik" />
						</td>
						<td>
							<input type="file" class="form-control" name="galeri_resim" id="galeri_resim" />
						</td>
						<td>
							<input type="submit" name="kaydet" id="kaydet" value="kaydet" />
						</td>
					</tr>';
	if(re('sil')!="")
	{
		mysql_query("UPDATE m_galeri SET durum='0' WHERE id='".re('sil')."' ");
		alert('Görsel Silindi');
		header('Location: ?modul=icerik&sayfa=galeri');
	}
	if(re('kaydet')=="kaydet")
	{
		if ( $_FILES['galeri_resim']['name'] != "" )
		{
			$yeni_ad='../images/'.$_FILES['galeri_resim']['name'];
			$imageFileType = $_FILES['galeri_resim']['type'];
			$resim=$_FILES['galeri_resim']['name'];
			$uz_bol=explode('/',$imageFileType);
			
			if ( move_uploaded_file($_FILES['galeri_resim']['tmp_name'],$yeni_ad) )
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
			}
			
			mysql_query("INSERT INTO  m_galeri (resim ,baslik ,durum) VALUES ('".$resim."', '".re('galeri_baslik')."', '1')")or die(mysql_error());
			header('Location: ?modul=icerik&sayfa=galeri');
		
		}
		if(re('galeri_arka')!=$ozellik_oku['galeri_arka_fon'])
		{
			mysql_query("update site_tasarim set galeri_arka_fon='".re('galeri_arka')."'");
			header('Location: ?modul=icerik&sayfa=galeri');
		}
	}
?>