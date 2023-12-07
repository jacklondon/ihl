<div style="float:left; width:100%; margin-top:20px;">
	<div class="span12">
		<div class="portlet box grey">
			<div class="portlet-title">
				<h4><i class="icon-reorder"></i>Sipariş</h4>
				<div class="actions">
				</div>
			</div>
			<div class="portlet-body">
				<div class="progress progress-striped active">
					<div style="width:<?php echo $toplam_siparis / 10; ?>%;" class="bar"></div>
				</div>
				<div style="font-size:14px;">
					Toplam Sipariş Sayısı : 
					<b><?php echo $toplam_siparis; ?></b>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="portlet box blue" style="margin-top:20px;">
	<div class="portlet-title">
		<h4><i class="icon-picture"></i>Üye Siparişleri</h4>
		<div class="tools">
		</div>
	</div>
	<div class="portlet-body">
		<table class="table table-condensed table-hover">
			<thead>
				<tr>
					<th>#</th>
					<th>Üye</th>
					<th>Sipariş Sayısı</th>
				</tr>
			</thead>
			<tbody>
				<?php echo $uye_siparisler_listesi; ?>
			</tbody>
		</table>
	</div>
</div>