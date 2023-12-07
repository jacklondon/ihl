<?php 
	
	if(re('islemleri') == "Tümünü Kaydet")
	{
		$banka_cek = mysql_query("select * from s_fiyat_tipler ORDER BY e_tarihi ASC ");
		while($banka_oku = mysql_fetch_array($banka_cek))
		{
			if ( re('sil_'.$banka_oku['id']) == 1 )
			{
				mysql_query("delete from s_fiyat_tipler where id='".$banka_oku['id']."'");
			}
			else
			{
				$resim_guncelle="";
				if ( $_FILES['logo_'.$banka_oku['id']]['name'] != "" )
				{
					
					$yeni_ad='../images/banka/'.$_FILES['logo_'.$banka_oku['id']]['name'];
					$imageFileType = $_FILES['logo_'.$banka_oku['id']]['type'];
					$resim=$_FILES['logo_'.$banka_oku['id']]['name'];
					$uz_bol=explode('/',$imageFileType);
					
					if ( move_uploaded_file($_FILES['logo_'.$banka_oku['id']]['tmp_name'],$yeni_ad) )
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
					$resim_guncelle="logo='".$resim."',";
				
				}
				$son_durum=2;
				if ( re('durum_'.$banka_oku['id']) == 1 )
				{
					$son_durum=1;
				}
				
				#mysql_query("update s_odeme_banka set adi='".re('y_adi_'.$banka_oku['id'])."',sube_adi='".re('y_adi_'.$banka_oku['id'])."',sube_kodu='".re('y_sube_kodu_'.$banka_oku['id'])."',hesap_no='".re('y_hesap_no_'.$banka_oku['id'])."',iban='".re('y_iban_'.$banka_oku['id'])."',c_1='".re('y_c1_'.$banka_oku['id'])."',c_3='".re('y_c3_'.$banka_oku['id'])."',c_6='".re('y_c6_'.$banka_oku['id'])."',c_9='".re('y_c9_'.$banka_oku['id'])."',resim='".re('y_resim_'.$banka_oku['id'])."' where id='".$banka_oku['id']."' ")or die(mysql_error());
				mysql_query("update s_fiyat_tipler set 
				p_kullanici_adi='".re('p_kullanici_adi_'.$banka_oku['id'])."',
				p_sifre='".re('p_sifre_'.$banka_oku['id'])."',
				p_banka_aktivasyon='".re('p_banka_aktivasyon_'.$banka_oku['id'])."',
				".$resim_guncelle."
				e_tarihi='".re('y_iban_'.$banka_oku['id'])."', 
				durum='".$son_durum."'
				where id='".$banka_oku['id']."' ")or die(mysql_error());
			}	
			
			
		}
		
		if(re('adi') != "0")
		{
			$banka_secili='|';
			$banka_cek = mysql_query("select * from s_fiyat_tipler ORDER BY id ASC ");
			while($banka_oku = mysql_fetch_array($banka_cek))
			{
				$banka_secili.=$banka_oku['adi'].'|';
			}
			
			if(strstr($banka_secili, '|'.re('adi').'|'))
			{
				
			}
			else
			{
				
				if ( $_FILES['logo']['name'] != "" )
				{
					
					$yeni_ad='../images/banka/'.$_FILES['logo']['name'];
					$imageFileType = $_FILES['logo']['type'];
					$resim=$_FILES['logo']['name'];
					$uz_bol=explode('/',$imageFileType);
					
					if ( move_uploaded_file($_FILES['logo']['tmp_name'],$yeni_ad) )
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
				}
					
					mysql_query("INSERT INTO s_fiyat_tipler
					(tur_id, 
					adi, 
					logo, 
					p_kullanici_adi, 
					p_sifre, 
					p_banka_aktivasyon, 
					e_tarihi, 
					durum) 
					VALUES 
					('4', 
					'".re('adi')."', 
					'".$resim."', 
					'".re('p_kullanici_adi')."', 
					'".re('p_sifre')."', 
					'".re('p_banka_aktivasyon')."', 
					'".mktime()."', 
					'1')")or die(mysql_error());
					
					header('Location: ?modul=ayarlar&sayfa=pos_ayarlari');
				
			}
		}
	}
	
	$banka_secili='|';
	$bankalar = '';
	$k_sayi = 0;
	$banka_cek = mysql_query("select * from s_fiyat_tipler ORDER BY id ASC ");
	while($banka_oku = mysql_fetch_array($banka_cek))
	{
		$bankalari_cek=mysql_query("select * from pos_ayarlari_bankalar where id='".$banka_oku['adi']."' and durum='1'");
		$bankalari_oku=mysql_fetch_assoc($bankalari_cek);
		
		$banka_secili.=$bankalari_oku['banka_adi'].'|';

		// Banka Basımları Select box dan alınıp direkt olarak basıldığı için kapatıldı. 14.11.2017
		/*$banka_bas='';
		
		$banka_bas.='<select name="adi_'.$banka_oku['id'].'" id="adi_'.$banka_oku['id'].'">';
		
		if($banka_oku['adi']=='Vakıfbank'){ $banka_bas.='<option value="Vakıfbank" selected>Vakıfbank</option>';}
		else{ $banka_bas.='<option value="Vakıfbank">Vakıfbank</option>';}
		
		if($banka_oku['adi']=='Halkbank'){ $banka_bas.='<option value="Halkbank" selected>Halkbank</option>';}
		else{ $banka_bas.='<option value="Halkbank">Halkbank</option>';}
		
		if($banka_oku['adi']=='İş Bankası'){ $banka_bas.='<option value="İş Bankası" selected>İş Bankası</option>';}
		else{ $banka_bas.='<option value="İş Bankası">İş Bankası</option>';}
		
		if($banka_oku['adi']=='Garanti'){ $banka_bas.='<option value="Garanti" selected>Garanti</option>';}
		else{ $banka_bas.='<option value="Garanti">Garanti</option>';}
		
		if($banka_oku['adi']=='Yapı Kredi'){ $banka_bas.='<option value="Yapı Kredi" selected>Yapı Kredi</option>';}
		else{ $banka_bas.='<option value="Yapı Kredi">Yapı Kredi</option>';}
		
		if($banka_oku['adi']=='TEB'){ $banka_bas.='<option value="TEB" selected>TEB</option>';}
		else{ $banka_bas.='<option value="TEB">TEB</option>';}
		
		$banka_bas.='</select>';*/
		
		$k_sayi++;
		$durum="";
		if($banka_oku['durum']==1){$durum="checked";}
		if($banka_oku['durum']==2){$durum="";}
		$bankalar .= '<tr>
							<td>
								'.$k_sayi.'
							</td>
							<td>
								<!--<input type="text" placeholder="Banka Adı" name="adi_'.$banka_oku['id'].'" id="adi_'.$banka_oku['id'].'" style="width:95%;" value="'.$banka_oku['adi'].'" />-->
								'.$bankalari_oku['banka_adi'].'
							</td>
							<td>
								<input type="file" name="logo_'.$banka_oku['id'].'" id="logo_'.$banka_oku['id'].'" />
							</td>
							<td>
								<input type="text" placeholder="P Kullanıcı" name="p_kullanici_adi_'.$banka_oku['id'].'" id="p_kullanici_adi_'.$banka_oku['id'].'" style="width:95%;"  value="'.$banka_oku['p_kullanici_adi'].'"/>
							</td>
							<td>
								<input type="text" placeholder="P Şifre" name="p_sifre_'.$banka_oku['id'].'" id="p_sifre_'.$banka_oku['id'].'" style="width:95%;" value="'.$banka_oku['p_sifre'].'" />
							</td>
							<td>
								<input type="text" placeholder="P Aktivasyon" name="p_banka_aktivasyon_'.$banka_oku['id'].'" id="p_banka_aktivasyon_'.$banka_oku['id'].'" style="width:95%;" value="'.$banka_oku['p_banka_aktivasyon'].'"/>
							</td>
							<td>
								<input type="checkbox" name="sil_'.$banka_oku['id'].'" id="sil_'.$banka_oku['id'].'" value="1"  />
							</td>
							<td>
								<input type="checkbox" name="durum_'.$banka_oku['id'].'" id="durum_'.$banka_oku['id'].'" value="1"  '.$durum.'/>
							</td>
							<td>
								<a href="?modul=ayarlar&sayfa=pos_detay&p_id='.$banka_oku['id'].'"><span class="btn btn-info">Ayar</span></a>
							</td>
						</tr>';
	}
	
	$banka_bas='<select name="adi" id="adi">
		<option value="0">Seçiniz</option>';
	$bankalari_cek=mysql_query("select * from pos_ayarlari_bankalar where durum='1'");
	while($bankalari_oku=mysql_fetch_array($bankalari_cek))
	{
		 if(strstr($banka_secili, "|".$bankalari_oku['banka_adi']."|"))
		 {
			 
		 }
		 else
		 {
			$banka_bas.='<option value="'.$bankalari_oku['id'].'">'.$bankalari_oku['banka_adi'].'</option>'; 
		 }
	}
	$banka_bas.='</select>';
	
?>

<form method="POST" enctype="multipart/form-data" id="form" name="form" >
	<div class="tab-pane" style="margin-top:20px;">
		<div class="portlet box blue">
			<div class="portlet-title">
				<h4><i class="icon-cogs"></i>Pos Ayarları</h4>
			</div>
			<div class="portlet-body">
				<table class="table table-hover">
					<thead>
						<tr>
							<th>#</th>
							<th>Adı</th>
							<th>Logo</th>
							<th>P Kullanici</th>
							<th>P Sifre</th>
							<th>P Banka Aktivasyon</th>
							<th>Sil</th>
							<th>Açık</th>
							<th>Ayar</th>
						</tr>
					</thead>
					<tbody>
						<?php echo $bankalar; ?>
						<tr>
							<td>
								Yeni
							</td>
							<td>
								<?php echo $banka_bas; ?>
								<!--<input type="text" placeholder="Banka Adı" name="adi" id="adi" style="width:95%;" />-->
							</td>
							<td>
								<input type="file" name="logo" id="logo" />
							</td>
							<td>
								<input type="text" placeholder="P Kullanıcı" name="p_kullanici_adi" id="p_kullanici_adi" style="width:95%;" />
							</td>
							<td>
								<input type="text" placeholder="P Şifre" name="p_sifre" id="p_sifre" style="width:95%;" />
							</td>
							<td>
								<input type="text" placeholder="P Aktivasyon" name="p_banka_aktivasyon" id="p_banka_aktivasyon" style="width:95%;" />
							</td>
							<td></td>
							<td></td>
							<td>
								<input type="submit" class="btn blue kat_kayit" name="islemleri" value="Tümünü Kaydet" style="margin-left:auto;" />
							</td>
						</tr>
					</tbody>
				</table>
				
			</div>
			</div>
		</div>
</form>