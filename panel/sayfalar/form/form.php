<form method="POST" enctype="multipart/form-data" id="form" name="form" >
<?php include('islemler/form/form.php'); ?>
<style>
	.kat_resim_input{position:absolute; float:left; max-width:85px; margin-top:0px;  cursor:pointer; z-index:20; opacity: 0; filter: alpha(opacity = 0); -ms-filter: "alpha(opacity=0)";}
	.kat_kayit{margin-top:-7px; width:130px; margin-left:60px;}
	.yeni_inputlar{height:16px; position:absolute; margin-top:-2px;}
	.yeni_inputlar_slc{height:24px; position:absolute; margin-top:-3px;}
	.yeni_inputlar_texta{height:20px; position:absolute; margin-top:-2px; font-size:13px;}
	.tam_satir{float:left; width:100%;}
</style>
	<div style="float:left; width:100%; margin-top:20px;">
		<div class="portlet box blue">
			<div class="portlet-title">
				<h4><i class="icon-cogs"></i>Özellikler</h4>
			</div>
			<div class="portlet-body">
				<table class="table table-hover">
					<thead>
						<tr>
							<th>#</th>
							<th>Soru</th>
							<th>Türü</th>
							<th>Kategori</th>
							<th>İnput</th>
							<th>Özellikler</th>
							<th>Zorunlu</th>
							<th>Sil</th>
						</tr>
					</thead>
					<tbody>
						<?php echo $basilacak; ?>
						<tr>
							<td>
								Yeni
							</td>
							<td>
								<input type="text" placeholder="Soru Adı" style="width:160px;" class="yeni_inputlar" name="y_soru_adi" id="y_soru_adi" />
								<div style="float:left; width:160px;"></div>
							</td>
							<td>
								<select style="width:160px;" class="yeni_inputlar_slc" name="y_soru_tur" id="y_soru_tur" >
									<option value="0">Tür Seçiniz</option>
									<?php 
										$soru_tur_cek = mysql_query("select * from s_sorular_turleri where durum='1' ORDER BY id ASC ");
										while($soru_tur_oku = mysql_fetch_array($soru_tur_cek))
										{
											echo '<option value="'.$soru_tur_oku['id'].'" >'.$soru_tur_oku['adi'].'</option>';
										}
									?>
								</select>
								<div style="float:left; width:160px;"></div>
							</td>
							<td>
								<select style="width:160px;" class="yeni_inputlar_slc" name="y_kategori" id="y_kategori" >
									<option value="0">Hepsi</option>
									<?php 
										$kati_cek = mysql_query("select * from urunler_kategoriler where durum!='0' and kategori='0' ORDER BY id ASC ");
										while($kati_oku = mysql_fetch_array($kati_cek))
										{
											echo '<option value="'.$kati_oku['id'].'" >'.$kati_oku['tanim'].'</option>';
										}
									?>
								</select>
								<div style="float:left; width:160px;"></div>
							</td>
							<td>
								<input type="text" placeholder="İnput Adı" style="width:160px;" class="yeni_inputlar" name="y_input_adi" id="y_input_adi" />
								<div style="float:left; width:160px;"></div>
							</td>
							<td>
								 <textarea style="width:180px;" class="yeni_inputlar_texta" rows="1" name="y_ozellik" id="y_ozellik" ></textarea>
								 <div style="float:left; width:180px;"></div>
							</td>
							<td>
								<label class="checkbox">
									<input type="checkbox" value="1" name="y_zorunlu" id="y_zorunlu" />
								</label>
							</td>
							<td>
								 
							</td>
						</tr>
					</tbody>
				</table>
				<input type="submit" class="btn blue kat_kayit" name="islemleri" value="Kaydet" />
			</div>
		</div>
	</div>
</form>