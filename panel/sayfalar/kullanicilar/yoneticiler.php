<?php 
	include('islemler/kullanicilar/yoneticiler.php');
?>
<form method="POST" enctype="multipart/form-data">
	<div class="portlet box blue" style="margin-top:20px;">
		<div class="portlet-title">
			<h4><i class="icon-picture"></i>Yöneticiler</h4>
			<div class="tools">
			</div>
		</div>
		<div class="portlet-body">
			<table class="table table-condensed table-hover">
				<thead>
					<tr>
						<th>#</th>
						<th>Kullanıcı Adı</th>
						<th>Adı</th>
						<th>Soyadı</th>
						<th>Kullanıcı Grubu</th>
						<th>Email</th>
						<th>Telefon</th>
						<th>Son Giriş</th>
						<th>İşlemler</th>
					</tr>
				</thead>
				<tbody>
					<?php echo $kullanicilar; ?>
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