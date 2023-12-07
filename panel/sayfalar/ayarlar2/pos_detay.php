<?php 
	$detay_cek=mysql_query("select * from pos_ayari_detay where p_id='".re('p_id')."'");
	$detay_oku=mysql_fetch_assoc($detay_cek);
	
	if(re('islemleri')=='Tümünü Kaydet')
	{
		$kontrol=mysql_num_rows($detay_cek);
		if($kontrol>0)
		{
			mysql_query("UPDATE pos_ayari_detay SET 
			uc_taksit='".re('uc_taksit')."',
			alti_taksit='".re('alti_taksit')."',
			dokuz_taksit='".re('dokuz_taksit')."',
			oniki_taksit='".re('oniki_taksit')."',
			yirmidort_taksit='".re('yirmidort_taksit')."',
			e_tarihi='".mktime()."'
			WHERE p_id='".re('p_id')."'")or die(mysql_error());
			header('Location: ?modul=ayarlar&sayfa=pos_detay&p_id='.re('p_id'));
		}
		else
		{
			mysql_query("INSERT INTO pos_ayari_detay (
			p_id,
			uc_taksit,
			alti_taksit,
			dokuz_taksit,
			oniki_taksit,
			yirmidort_taksit,
			e_tarihi
			) VALUES (
			'".re('p_id')."',
			'".re('uc_taksit')."',
			'".re('alti_taksit')."',
			'".re('dokuz_taksit')."',
			'".re('oniki_taksit')."',
			'".re('yirmidort_taksit')."',
			'".mktime()."')");
			header('Location: ?modul=ayarlar&sayfa=pos_detay&p_id='.re('p_id'));
		}
	}
?>

 <!--<form method="POST" enctype="multipart/form-data" id="form" name="form" >
	
	<div class="tab-pane" style="margin-top:20px; ">
		<div class="portlet box blue">
			<div class="portlet-title">
				<h4><i class="icon-cogs" ></i>Pos Ayarları</h4>	
			</div>
			<div class="portlet-body">
				<table class="table table-hover" style="min-height:100px;">
				<div style="float:left; margin-right:15px; font-size:14px;font-weight:600;"> Post Modülünü Seçiniz 
				<select>
			
					<option value="Vakıfbank">Vakıfbank</option>
					<option value="Vakıfbank">Halkbank</option>
					<option value="Vakıfbank">İş Bankası</option>
					<option value="Vakıfbank">Ziraat</option>
					<option value="Vakıfbank">Ziraat</option>
					<option value="Vakıfbank">Ziraat</option>
					
				</select>
				</div>
			</div>
				
			<div style="float:left; font-size:14px; font-weight:600; margin-right:5px; "> Banka Adını Giriniz
				<input type="text" name="site_banka" id="site_banka" value="<?php echo $site_oku['site_banka']; ?>" />
				
			</div>
				<input type="submit" class="btn blue kat_kayit" name="islemleri" value="Tümünü Kaydet" style="margin-left:auto;" />

			</table>
		</div>
			
	</div>
		-->
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	<?php 
		$bankalari_cek=mysql_query("select * from pos_modulleri where durum='1'");
		while( $bankalari_sor=mysql_fetch_array($bankalari_cek))
		{
			$banka_dizisi.='|'.$bankalari_sor['tanim'].':'.$bankalari_sor['modul'];
		}
		
		$banka_dizisi_d=explode("|",$banka_dizisi);
		
		$bankalari_bas='';
		$deger_cek=mysql_query("select * from pos_detay where banka='".re('p_id')."'");
		while($deger_oku=mysql_fetch_assoc($deger_cek))
		{			
			$bankalari_bas.='
			<tr>
				<td>
					'.$deger_oku['id'].'
				</td>
				<td>
					<input type="text" name="site_banka_'.$deger_oku['id'].'" id="site_banka" value="'.$deger_oku['tanim'].'" />
				</td>
				<td>
					<input type="file" name="logo_'.$deger_oku['id'].'" id="logo_'.$deger_oku['id'].'" />
				</td>
				<td>
					<a href="?modul=ayarlar&sayfa=pos_detay&p_id='.re('p_id').'&sil='.$deger_oku['id'].'" class="btn red kat_kayit">Sil</a>
					<a href="?modul=ayarlar&sayfa=pos_ayari_taksit&p_id='.re('p_id').'&tip_id='.$deger_oku['id'].'"><span class="btn btn-info">Ayar</span></a>
				</td>
			</tr>
			';
		}
	
		if(re('islem')=="Tümünü Kaydet")
		{
			$deger_cek=mysql_query("select * from pos_detay where banka='".re('p_id')."'");
			while($deger_oku=mysql_fetch_assoc($deger_cek))
			{
				$resim_guncelle="";
				if ( $_FILES['logo_'.$deger_oku['id']]['name'] != "" )
				{
					
					$yeni_ad='../images/banka/'.$_FILES['logo_'.$deger_oku['id']]['name'];
					$imageFileType = $_FILES['logo_'.$deger_oku['id']]['type'];
					$resim=$_FILES['logo_'.$deger_oku['id']]['name'];
					$uz_bol=explode('/',$imageFileType);
					
					if ( move_uploaded_file($_FILES['logo_'.$deger_oku['id']]['tmp_name'],$yeni_ad) )
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
				
				mysql_query("UPDATE `pos_detay` SET 
				`banka`='".re('p_id')."',
				".$resim_guncelle."
				`tanim`='".re('site_banka_'.$deger_oku['id'])."'
				WHERE id='".$deger_oku['id']."'")or die(mysql_error());
			}
			
			if(re('site_banka')!='')
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
				
				mysql_query("INSERT INTO `pos_detay`(`banka`, logo, `tanim`, `durum`) VALUES ('".re('p_id')."', '".$resim."', '".re('site_banka')."','1')");
			}
			
			header('Location: ?modul=ayarlar&sayfa=pos_detay&p_id='.re('p_id'));
		}
		
		if(re('sil')!='')
		{
			mysql_query("DELETE FROM `pos_detay` WHERE id='".re('sil')."'");
			
			header('Location: ?modul=ayarlar&sayfa=pos_detay&p_id='.re('p_id'));
		}
	?>
	
	
	
	
	
<form method="POST" enctype="multipart/form-data" id="form" name="form" > 
	<div class="tab-pane" style="margin-top:20px;">
		<div class="portlet box blue">
			<div class="portlet-title">
				<h4><i class="icon-cogs" ></i>Pos Ayarları</h4>	
			</div>
			<div class="portlet-body">
				<table class="table table-hover">
					<thead>
						<tr>
							<th>#</th>
							<th>Tanım</th>
							<th>Resim</th>
							<th>Durum</th>
						</tr>
					</thead>
					<tbody>
						<?php echo $bankalari_bas; ?>
						<tr>
							<td>
								#
							</td>
							<td>
								<input type="text" name="site_banka" id="site_banka" value="" />
							</td>
							<td>
								<input type="file" name="logo" id="logo" />
							</td>
							<td>
								<input type="submit" class="btn blue kat_kayit" name="islem" value="Tümünü Kaydet" style="margin-left:auto;" />
							</td>
						</tr>
					</tbody>
				</table>
		</div>
	</div>
</form>

<div style="width:100%; height:50px; float:left; font-size:19px;" >
	<input type="checkbox" name="pos_kosul" id="pos_kosul" /> Bu Pos'u Tanımlamadığım Tüm Kartlar İçin Kullan
</div>
	
	
<form method="POST" enctype="multipart/form-data" id="form" name="form" style="display:none;" >
	<div class="tab-pane" style="margin-top:20px;">
		<div class="portlet box blue">
			<div class="portlet-title">
				<h4><i class="icon-cogs"></i>Pos Detay</h4>
			</div>
			<div class="portlet-body">
				<table class="table table-hover">
					<thead>
						<tr>
							<th>#</th>
							<th>3 Taksit</th>
							<th>6 Taksit</th>
							<th>9 Taksit</th>
							<th>12 Taksit</th>
							<th>24 Taksit</th>
							<th>İşlem</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>
								#
							</td>
							<td>
								<input type="text" placeholder="3 Taksit Oranı" name="uc_taksit" id="uc_taksit" style="width:95%;" value="<?php echo $detay_oku['uc_taksit']; ?>"/>
							</td>
							<td>
								<input type="text" placeholder="6 Taksit Oranı" name="alti_taksit" id="alti_taksit" style="width:95%;" value="<?php echo $detay_oku['alti_taksit']; ?>"/>
							</td>
							<td>
								<input type="text" placeholder="9 Taksit Oranı" name="dokuz_taksit" id="dokuz_taksit" style="width:95%;" value="<?php echo $detay_oku['dokuz_taksit']; ?>"/>
							</td>
							<td>
								<input type="text" placeholder="12 Taksit Oranı" name="oniki_taksit" id="oniki_taksit" style="width:95%;" value="<?php echo $detay_oku['oniki_taksit']; ?>"/>
							</td>
							<td>
								<input type="text" placeholder="24 Taksit Oranı" name="yirmidort_taksit" id="yirmidort_taksit" style="width:95%;" value="<?php echo $detay_oku['yirmidort_taksit']; ?>"/>
							</td>
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