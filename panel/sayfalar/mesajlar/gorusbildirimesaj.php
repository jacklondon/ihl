<?php
	include('islemler/mesajlar/gorusbildirimesaj.php');
?>
<form method="POST" enctype="multipart/form-data">
	<div class="portlet box blue" style="margin-top:20px;">
		<div class="portlet-title">
			<h4><i class="icon-picture"></i>Görüş & Bildiri Mesajları</h4>
			<div class="tools">
			</div>
		</div>
		<div class="portlet-body">
			<table class="table table-condensed table-hover">
				<thead>
					<tr>
						<th>#</th>
						<th>Ad Soyad</th>
						<th>Telefon</th>
						<th>Mail</th>
						<th>Mesaj</th>
						<th>Tarih</th>
					</tr>
				</thead>
				<tbody>
					<?php
					foreach ($mesajlar as $msg) {
					?>
					<tr>
						<td><?=$msg['id']?></td>
						<td><?=$msg['adsoyad']?></td>
						<td><?=$msg['telefon']?></td>
						<td><?=$msg['mail']?></td>
						<td><?=$msg['mesaj']?></td>
						<td><?=date('d.m.Y H:i',$msg['tarih'])?></td>
					</tr>
					<?php
					}
					?>
				</tbody>
			</table>
		</div>
	</div>
</form>