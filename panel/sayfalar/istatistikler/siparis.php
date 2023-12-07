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


<?php 
	include('islemler/istatistikler/siparis.php');
?>
<form method="POST" enctype="multipart/form-data">
	<div class="portlet box blue" style="margin-top:20px;">
		<div class="portlet-title">
			<h4><i class="icon-picture"></i>Siparişler</h4>
			<div class="tools">
			</div>
		</div>
		<div class="portlet-body">
			<table class="table table-condensed table-hover">
				<thead>
					<tr>
						<th>#</th>
						<th>Adı Soyadı</th>
						<th>Ödeme Türü</th>
						<th>Sipariş No</th>
						<th>Sipariş Durumu</th>
						<th>Hediye Paketi</th>
						<th>Tarih</th>
						<th>Tutar</th>
						<th>İşlemler</th>
					</tr>
				</thead>
				<tbody>
					<?php echo $siparisler; ?>
				</tbody>
			</table>
		</div>
	</div>
	
	<div class="row-fluid">
		<div class="span6">
			<div class="dataTables_paginate paging_bootstrap pagination" style="margin-top:-10px;">
				<?php echo $sayilar; ?>
			</div>
		</div>
		<div class="span6"><div class="dataTables_info" id="sample_1_info">
			<?php echo $say; ?> kayıttan <?php echo $nereden; ?> - <?php echo $son_limit; ?> arası (<?php echo $sayfa; ?>. sayfa) gösteriliyor
		</div></div>
	</div>
</form>