'".re('sirket_adi')."'<div style="float:left; width:100%; margin-top:20px;">
	<div class="span12">
		<div class="portlet box blue">
			<div class="portlet-title">
				<h4><i class="icon-reorder"></i>Ürün Ziyaretleri</h4>
				<div class="actions">
				</div>
			</div>
			<div class="portlet-body">
				<div class="progress progress-striped active">
					<div style="width:<?php echo $toplam_urun_ziyaretci / 10; ?>%;" class="bar"></div>
				</div>
				<div style="font-size:14px;">
					Toplam Ürünleri Ziyaret Eden Kişi Sayısı : 
					<b><?php echo $toplam_urun_ziyaretci; ?></b>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="portlet box green">
	<div class="portlet-title">
		<h4><i class="icon-picture"></i>Tüm Ziyaretçiler</h4>
		<div class="tools">
		</div>
	</div>
	<div class="portlet-body">
		<table class="table table-condensed table-hover">
			<thead>
				<tr>
					<th>#</th>
					<th>Ürün</th>
					<th>Son IP</th>
					<th>Giriş Sayısı</th>
					<th>İlk Giriş Tarihi</th>
					<th>Son Giriş Tarihi</th>
				</tr>
			</thead>
			<tbody>
				<?php echo $tum_urun_ziyaretciler_liste; ?>
			</tbody>
		</table>
	</div>
</div>