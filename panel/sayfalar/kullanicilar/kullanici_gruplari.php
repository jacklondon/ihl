<form method="POST" enctype="multipart/form-data" id="form" name="form" >
	<?php include('islemler/kullanicilar/kullanici_gruplari.php'); ?>
	<div class="tab-pane" style="margin-top:20px;">
		<div class="portlet box blue">
			<div class="portlet-title">
				<h4><i class="icon-cogs"></i>Kullanıcı Grupları</h4>
			</div>
			<div class="portlet-body">
				<table class="table table-hover">
					<thead>
						<tr>
							<th>#</th>
							<th>Grup Adı</th>
							<th>Aktiflik Durumu</th>
							<th>Sil</th>
						</tr>
					</thead>
					<tbody>
						<?php echo $gruplar; ?>
						<tr>
							<td>
								Yeni
							</td>
							<td>
								<input type="text" placeholder="Grup Adı" class="yeni_inputlar" name="y_adi" id="y_adi" />
							</td>
							<td>
							
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