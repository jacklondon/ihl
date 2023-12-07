 <?php 
	session_start();
	$admin_id=$_SESSION['kid'];
	//$uyeleri_cek = mysql_query("SELECT * FROM user WHERE temsilci_id = '".$admin_id."'");
	$slider_cek = mysql_query("SELECT * FROM slider order by id asc");
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
	<a href="?modul=slider&sayfa=slider_ekle">
		<input type="submit" class="btn blue" name="yeni_slider_ekle" value="Yeni Slider Ekle">
	</a>
</div>
<div style="overflow-x:auto; overflow-y:auto; margin-top:2%;">
	<table width="100%" border="0" cellspacing="4" cellpadding="2" style="margin-top:3%;">
		<tbody>
			<tr>
				<td>#</td>
				<td>Başlık</td>
				<td>Açıklama</td>
				<td>Buton</td>
				<td>Buton Yeri</td>
				<td>Resim</td>
				<td>Durum</td>
				<td>Düzenle</td>
				<td>Sil</td>      
			</tr>
			<?php $sira=1; while($row = mysql_fetch_array($slider_cek)){ 
				if($row['button_yer_secimi'] == 0){
					$button_yeri="Aşağı Sol";
				}else if($row['button_yer_secimi'] == 1){
					$button_yeri="Aşağı Sağ";
				}else if($row['button_yer_secimi'] == 2){
					$button_yeri="Yukarı Sol";
				}else{
					$button_yeri="Yukarı Sağ";
				}

				
			?>
			<tr>
				<td><?= $sira?></td>
				<td><?= $row['baslik'] ?></td>
				<td><?= $row['aciklama'] ?></td>
				<td><?= $row['button'] == 1 ? $row['button']="Aktif" : $row['button']="Pasif" ?></td>
				<td><?= $button_yeri ?></td>
				<td><img style="width:100px;height:100px;object-fit:cover;" src="https://ihale.pertdunyasi.com/<?=$row["resim"]?>"/></td>
				<td><?= $row['durum'] == 1 ? $row['durum']="Aktif" : $row['durum']="Pasif" ?></td>
				<td><a href="?modul=slider&sayfa=slider_guncelle&id=<?=$row["id"]?>" ><i class="fas fa-edit"></i></a></td>
				<td><a href="?modul=ayarlar&sayfa=data_sil&id=<?=$row["id"]?>&q=slider_sil"><i class="fas fa-trash"></i></a></td>
			</tr>
			<?php $sira=$sira+1; } ?>
		</tbody>
	</table>
</div>



