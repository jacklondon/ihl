 <style>
a{
    color: #000000;
    cursor: pointer;
}
a:hover{
    text-decoration: none;
}
</style>
<?php 
$yorum_cek = mysql_query("SELECT * FROM yorumlar where arac_bilgileri <> '' ORDER BY yorum_zamani DESC");
?>
<table class="table table-bordered" style="margin-top:2%;">
	<thead style="background-color: rgb(253,230,212);">
		<tr>
			<td>Görsel</td>
			<td>Plaka</td>
			<td>Araç Detayları</td>
			<td>Üye Adı</td>
			<td>Yorumu</td>
			<td>Yorum Tarihi</td>
			<td>Cevap</td>
			<td>Durum</td>
			<td>Menü</td>
		</tr>
	</thead>
	<tbody>
		<?php 
			while($yorum_oku = mysql_fetch_array($yorum_cek)){
				$durum = $yorum_oku['durum'];
				if($durum == 0){
					$durum = "Onay Bekliyor";
				}elseif($durum == 1){
					$durum = "Yayında";
				}elseif($durum == 2){
					$durum = "Reddedildi";
				}elseif($durum == 3){
					$durum = "Anasayfada";
				}
				$resim_cek = mysql_query("select * from ilan_resimler where ilan_id = '".$yorum_oku['ilan_id']."'");
				$resim_oku = mysql_fetch_assoc($resim_cek);
				$resim = $resim_oku['resim'];
				if($resim != ""){
					$resim = $resim;
				}else{
					$resim = "default.png";
				}
				$yorum_yapan=mysql_query("select * from user where id = '".$yorum_oku['uye_id']."'");
				$yorum_yapan_oku = mysql_fetch_assoc($yorum_yapan);
				$yorumcu = $yorum_yapan_oku['ad'];
				$ilan_cek = mysql_query("select * from ilanlar where id = '".$yorum_oku['ilan_id']."' limit 1");
				$ilan_oku = mysql_fetch_assoc($ilan_cek);
				$marka_cek = mysql_query("select * from marka where markaID = '".$ilan_oku['marka']."'");
				$marka_oku = mysql_fetch_assoc($marka_cek);
				$marka = $marka_oku['marka_adi'];
		?>
		<tr>
			<td><img style="height: 30px;" src="../images/<?=$resim?>"></td>
			<td><?= $ilan_oku['plaka'] ?></td>
			<td><?= $yorum_oku['arac_bilgileri'] ?></td>
			<td><?= $yorumcu ?></td>
			<td><?= $yorum_oku['yorum'] ?></td>
			<td><?=date('d-m-Y H:i:s', strtotime($yorum_oku['yorum_zamani'])) ?></td>
			<td><?=$yorum_oku['cevap'] ?></td>
			<td><?= $durum ?></td>
			<form method="post" action="?modul=admin&sayfa=yorum_islemleri">
					  
			<td><a href="?modul=admin&sayfa=yorum_islemleri&id=<?= $yorum_oku['id']?>&q=onayla">Onay Ver</a>
			-<a href="?modul=admin&sayfa=yorum_islemleri&id=<?= $yorum_oku['id'] ?>&q=reddet">Reddet</a>-
			<a href="?modul=admin&sayfa=yorum_islemleri&id=<?= $yorum_oku['id'] ?>&q=sil">Sil</a>-
			- <a href="?modul=admin&sayfa=yorum_islemleri&id=<?= $yorum_oku['id'] ?>&q=anasayfa">Anasayfada Gözüksün</a>
			- <a href="?modul=admin&sayfa=cevapla&id=<?= $yorum_oku['id']; ?>" target="_blank">Cevapla</a></td>
			</form>
		</tr>
		<?php  } ?>
	</tbody>
</table> 



