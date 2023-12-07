<?php 
	session_start();
	$admin_id=$_SESSION['kid'];
	//$uyeleri_cek = mysql_query("SELECT * FROM user WHERE temsilci_id = '".$admin_id."'");
	$footer_cek = mysql_query("SELECT * FROM iletisim");
	$bayi_cek = mysql_query("SELECT * FROM bayiler");
	$sira=1;
?>
<style>
	table {
		border-collapse: collapse;
		border-spacing: 0;
		width: 100%;
		border: 1px solid #ddd;
	}

	th, td {
		text-align: left;
		padding: 8px;
	}
	i{
		color:black;
		padding: 8px;	
	}
	tr:nth-child(even) {
		background-color: #f2f2f2;
	}
</style>
<div class="form-control" style="margin-top: 2%;">
	<!-- <a href="?modul=slider&sayfa=slider_ekle">
		<input type="submit" class="btn blue" name="yeni_slider_ekle" value="Footer Oluştur">
	</a> -->
</div>
<div style="overflow-x:auto; overflow-y:auto; margin-top:2%;">
	<table width="100%" border="0" cellspacing="4" cellpadding="2" style="margin-top:3%;">
		<tbody>
			<tr>
				<td>#</td>
				<td>Adres</td>
				<td>Sabit Hat</td>
				<td>Fax ve SMS</td>
				<td>Telefon</td>
				<td>Email</td>
				<td>Skype</td>
				<td>Facebook</td>
				<td>Twitter</td>
				<td>İnstagram</td>
				<td>Youtube</td>
				<td>Düzenle</td>     
			</tr>
			<?php  while($row = mysql_fetch_array($footer_cek)){ ?>
			<tr>
				<td>#</td>
				<td><?= $row['adres'] ?></td>
				<td><?= $row['sabit_hat'] ?></td>
				<td><?= $row['fax_sms'] ?></td>
				<td><?= $row['telefon'] ?></td>
				<td><?= $row['email'] ?></td>
				<td><?= $row['skype'] ?></td>
				<td><?= $row['facebook'] ?></td>
				<td><?= $row['twitter'] ?></td>
				<td><?= $row['instagram'] ?></td>
				<td><?= $row['youtube'] ?></td>
				<td><a href="?modul=iletisim&sayfa=iletisim_guncelle&id=<?=$row["id"]?>" ><i class="fas fa-edit"></i></a></td>
			</tr>
			<?php } ?>
		</tbody>
	</table>
</div>
<div class="form-control" style="margin-top: 2%;">
	<a href="?modul=iletisim&sayfa=bayi_ekle">
		<input type="submit" class="btn blue" name="yeni_bayi_ekle" value="Bayi Oluştur">
	</a> 
</div>
<div style="overflow-x:auto; overflow-y:auto; margin-top:2%;">
	<table width="100%" border="0" cellspacing="4" cellpadding="2" style="margin-top:3%;">
		<tbody>
			<tr>
				<td>#</td>
				<td>Bayi Adı</td>
				<td>Düzenle</td>     
				<td>Sil</td>     
			</tr>
			<?php 
				while($row2 = mysql_fetch_array($bayi_cek)){ ?>
			<tr>
				<td><?=$sira ?></td>
				<td><?= $row2['bayi_adi'] ?></td>
				<td><a href="?modul=iletisim&sayfa=bayi_guncelle&id=<?=$row2["id"]?>" ><i class="fas fa-edit"></i></a></td>
				<td><a href="?modul=ayarlar&sayfa=data_sil&id=<?=$row2["id"]?>&q=bayi_sil"><i class="fas fa-trash"></i></a></td>
			</tr>
			<?php
				$sira++; } 
			?>
		</tbody>
	</table>
</div>



