<style>
	.radio_k_class{float:left; margin-right:10px;}
</style>
<form method="POST" enctype="multipart/form-data" id="form" name="form" >
	<?php include('islemler/kullanicilar/yeni_kullanici_ekle.php'); ?>
	<div class="row-fluid" style="margin-top:20px;">
	   <div class="span12">
		  <!-- BEGIN SAMPLE FORM PORTLET-->   
		  <div class="portlet box blue">
			 <div class="portlet-title">
				<h4><i class="icon-reorder"></i>Kullanıcı Ekle</h4>
				<div class="tools">
				</div>
			 </div>
			 <div class="portlet-body form">
				<!-- BEGIN FORM-->
				<div class="form-horizontal">
					<div class="control-group">
					  <label class="control-label">Kullanıcı Adı</label>
					  <div class="controls">
						 <input type="text" class="span6 m-wrap" name="kullanici_adi" id="kullanici_adi" value="<?php echo $kullanici_oku4['kullanici_adi']; ?>" />
						 <span class="help-inline"></span>
					  </div>
				   </div>
				   <div class="control-group">
					  <label class="control-label">Yeni Şifre</label>
					  <div class="controls">
						 <input type="password" class="span6 m-wrap" name="yeni_sifre" id="yeni_sifre" value="" />
						 <span class="help-inline"></span>
					  </div>
				   </div>
				    <div class="control-group">
					  <label class="control-label">Yeni Şifre Tekrar</label>
					  <div class="controls">
						 <input type="password" class="span6 m-wrap" name="yeni_sifre_tekrar" id="yeni_sifre_tekrar" value="" />
						 <span class="help-inline"></span>
					  </div>
				   </div>
				   <div class="control-group">
					  <label class="control-label">Adı</label>
					  <div class="controls">
						 <input type="text" class="span6 m-wrap" name="adi" id="adi" value="<?php echo $kullanici_oku4['adi']; ?>" />
						 <span class="help-inline"></span>
					  </div>
				   </div>
				    <div class="control-group">
					  <label class="control-label">Soyadı</label>
					  <div class="controls">
						 <input type="text" class="span6 m-wrap" name="soyadi" id="soyadi" value="<?php echo $kullanici_oku4['soyadi']; ?>" />
						 <span class="help-inline"></span>
					  </div>
				   </div>
				   <div class="control-group">
					  <label class="control-label">Email</label>
					  <div class="controls">
						 <input type="text" class="span6 m-wrap" name="email" id="email" value="<?php echo $kullanici_oku4['email']; ?>" />
						 <span class="help-inline"></span>
					  </div>
				   </div>
				   <div class="control-group">
					  <label class="control-label">Telefon</label>
					  <div class="controls">
						 <input type="text" class="span6 m-wrap" name="tel" id="tel" value="<?php echo $kullanici_oku4['tel']; ?>" />
						 <span class="help-inline"></span>
					  </div>
				   </div>
				   <div class="control-group">
					  <label class="control-label">Adres</label>
					  <div class="controls">
						 <input type="text" class="span6 m-wrap" name="adres" id="adres" value="<?php echo $kullanici_oku4['adres']; ?>" />
						 <span class="help-inline"></span>
					  </div>
				   </div>
					<div class="control-group">
						<label class="control-label lbl_bolum_1">Yetki</label>
						<div class="controls">
							<select class="span6 m-wrap" name="yetki" id="yetki" tabindex="1" >
								<option value="0">Seçiniz</option>
								<option value="1" <?php echo $yetki_bir; ?> >Standart Kullanıcı</option>
								<option value="9" <?php echo $yetki_dokuz; ?> >Yönetici</option>
							</select>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label lbl_bolum_1">Grup</label>
						<div class="controls">
							<select class="span6 m-wrap" name="grup" id="grup" tabindex="1" >
								<option value="0">Grup Seçilmemiş</option>
								<?php 
									$gruplari_cek = mysql_query("select * from kullanicilar_grup where durum!='0' ORDER BY id DESC ");
									while($gruplari_oku = mysql_fetch_array($gruplari_cek))
									{
										$secili = '';
										if($kullanici_oku4['grup'] != 0 and $kullanici_oku4['grup'] != "")
										{
											if($kullanici_oku4['grup'] == $gruplari_oku['id']) { $secili = 'selected'; }
										}
										echo '<option value="'.$gruplari_oku['id'].'" '.$secili.' >'.$gruplari_oku['adi'].'</option>';
									}
								?>
							</select>
						</div>
					</div>
					
					<div class="control-group">
						<label class="control-label lbl_bolum_1">Kullanıcı Durumu</label>
						<div class="controls">
							<select class="span6 m-wrap" name="durum" id="durum" tabindex="1" >
								<option value="0">Seçiniz</option>
								<option value="1" <?php echo $durum_aktif; ?> >Aktif</option>
								<option value="2" <?php echo $durum_pasif; ?> >Pasif</option>
							</select>
						</div>
					</div>
					
					<?php 
						if($kullanici_oku4['grup'] == 2)
						{
							$secilimi = '';
							if($kullanici_oku4['bayi'] == 1) { $secilimi = 'checked'; }
							echo '<div class="control-group">
									<label class="control-label lbl_bolum_1">Bayi Aktivasyonu</label>
									<div class="controls">
										<input type="checkbox" name="bayi" id="bayi" value="1" '.$secilimi.' />
									</div>
								</div>';
								
							$usd_secilimi = '';
							if($kullanici_oku4['bayi_usd'] == 1) { $usd_secilimi = 'checked'; }
							echo '<div class="control-group">
									<label class="control-label lbl_bolum_1">Bayi USD Fiyatı</label>
									<div class="controls">
										<input type="checkbox" name="bayi_usd" id="bayi_usd" value="1" '.$usd_secilimi.' />
									</div>
								</div>';
								
							
							
							echo '<div class="control-group">
									<label class="control-label lbl_bolum_1"> </label>
									<div class="controls">
										<h4><b>Firma Bilgileri</b></h4>
									</div>
								</div>';

							$f_katler = '';
							$f_kat_cek = mysql_query("select * from f_kategoriler where durum='1' ORDER BY id ASC ");
							while($f_kat_oku = mysql_fetch_array($f_kat_cek))
							{
								$secili = '';
								if($f_kat_oku['id'] == $kullanici_oku4['f_kategori']) { $secili = 'selected'; }
								$f_katler .= '<option value="'.$f_kat_oku['id'].'" '.$secili.' >'.$f_kat_oku['adi'].'</option>';
							}
								
							echo '<div class="control-group">
										<label class="control-label lbl_bolum_1">Firma Kategorisi</label>
										<div class="controls">
											<select class="span6 m-wrap" name="f_kategori" id="f_kategori" tabindex="1" >
												<option value="0">Seçiniz</option>
												'.$f_katler.'
											</select>
										</div>
									</div>';
								
							echo '<div class="control-group">
									<label class="control-label lbl_bolum_1">Operatör Kodu</label>
									<div class="controls">
										 <input type="text" class="span6 m-wrap" name="f_operator" id="f_operator" value="'.$kullanici_oku4['f_operator'].'" />
									<span class="help-inline"></span>
									</div>
								</div>';
								
							echo '<div class="control-group">
									<label class="control-label lbl_bolum_1">Firma Ticari Ünvanı</label>
									<div class="controls">
										 <input type="text" class="span6 m-wrap" name="f_ticari_unvan" id="f_ticari_unvan" value="'.$kullanici_oku4['f_ticari_unvan'].'" />
									<span class="help-inline"></span>
									</div>
								</div>';
							
							echo '<div class="control-group">
									<label class="control-label lbl_bolum_1">Vergi Dairesi</label>
									<div class="controls">
										 <input type="text" class="span6 m-wrap" name="f_vergi_dairesi" id="f_vergi_dairesi" value="'.$kullanici_oku4['f_vergi_dairesi'].'" />
									<span class="help-inline"></span>
									</div>
								</div>';
								
							echo '<div class="control-group">
									<label class="control-label lbl_bolum_1">Vergi No</label>
									<div class="controls">
										 <input type="text" class="span6 m-wrap" name="f_vergi_no" id="f_vergi_no" value="'.$kullanici_oku4['f_vergi_no'].'" />
									<span class="help-inline"></span>
									</div>
								</div>';
								
							echo '<div class="control-group">
									<label class="control-label lbl_bolum_1">TC Kimlik No</label>
									<div class="controls">
										 <input type="text" class="span6 m-wrap" name="f_tc" id="f_tc" value="'.$kullanici_oku4['f_tc'].'" />
									<span class="help-inline"></span>
									</div>
								</div>';
								
							echo '<div class="control-group">
									<label class="control-label lbl_bolum_1">Telefon</label>
									<div class="controls">
										 <input type="text" class="span6 m-wrap" name="f_telefon" id="f_telefon" value="'.$kullanici_oku4['f_telefon'].'" />
									<span class="help-inline"></span>
									</div>
								</div>';
								
							echo '<div class="control-group">
									<label class="control-label lbl_bolum_1">Adres</label>
									<div class="controls">
										 <input type="text" class="span6 m-wrap" name="f_adres" id="f_adres" value="'.$kullanici_oku4['f_adres'].'" />
									<span class="help-inline"></span>
									</div>
								</div>';
								
								
							if($kullanici_oku4['vergi_levhasi'] != "")
							{
								echo '<div class="control-group">
										<label class="control-label lbl_bolum_1">Vergi Levhası</label>
										<div class="controls">
											<a href="../dosyalar/'.$kullanici_oku4['vergi_levhasi'].'" target="_blank">İndir</a>
										</div>
									</div>';
							}
							if($kullanici_oku4['oda_sicil_kaydi'] != "")
							{
								echo '<div class="control-group">
										<label class="control-label lbl_bolum_1">Oda Sicil Kaydı</label>
										<div class="controls">
											<a href="../dosyalar/'.$kullanici_oku4['oda_sicil_kaydi'].'" target="_blank">İndir</a>
										</div>
									</div>';
							}
							if($kullanici_oku4['imza_sirkusu'] != "")
							{
								echo '<div class="control-group">
										<label class="control-label lbl_bolum_1">İmza Sirkusu</label>
										<div class="controls">
											<a href="../dosyalar/'.$kullanici_oku4['imza_sirkusu'].'" target="_blank">İndir</a>
										</div>
									</div>';
							}
							if($kullanici_oku4['faaliyet_belgesi'] != "")
							{
								echo '<div class="control-group">
										<label class="control-label lbl_bolum_1">Faaliyet Belgesi</label>
										<div class="controls">
											<a href="../dosyalar/'.$kullanici_oku4['faaliyet_belgesi'].'" target="_blank">İndir</a>
										</div>
									</div>';
							}
						}
					?>
				   
					<?php if($resimler != "") { ?>
					<div class="control-group">
					  <label class="control-label lbl_bolum_1"> </label>
					  <div class="controls">
							<?php echo $resimler; ?>
					  </div>
					</div>
					<?php } ?>
				   
				   <div class="form-actions">
						<input type="submit" name="kullaniciyi" class="btn blue" value="Kaydet" />
				   </div>
				</div>
				<!-- END FORM-->           
			 </div>
		  </div>
		  <!-- END SAMPLE FORM PORTLET-->
	   </div>
	</div>
</form>