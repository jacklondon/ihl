<?php 
session_start();
$admin_id=$_SESSION['kid'];
$admin_yetki_cek=mysql_query("Select * from kullanicilar where id='".$admin_id."' ");
$admin_yetki_oku=mysql_fetch_assoc($admin_yetki_cek);

$yetkiler=$admin_yetki_oku["yetki"];

$yetki_parcala=explode("|",$yetkiler);
if (!in_array(12, $yetki_parcala)  ) { 
  echo '<script>alert("Üye Bakiyelerini Görme Yetkiniz Yoktur")</script>';
  echo "<script>window.location.href = 'index.php'</script>";
}      						
	$toplam = 0;
	$cek = mysql_query("SELECT SUM(tutar) as toplam,uye_id,durum FROM cayma_bedelleri WHERE durum = 1 GROUP BY uye_id");
	while($oku = mysql_fetch_object($cek)){
		$uye_cek = mysql_query("select * from user where id = '".$oku->uye_id."'");
		if(mysql_num_rows($uye_cek) != 0){
			$uye_oku = mysql_fetch_object($uye_cek);

			$borclar_toplam = mysql_query("SELECT SUM(tutar) as toplam_borclar FROM cayma_bedelleri WHERE uye_id='" . $oku->uye_id . "' AND durum=6 ");
			$toplam_borclar = mysql_fetch_object($borclar_toplam);
			$toplam_cayma = $oku->toplam - $toplam_borclar->toplam_borclar;

			$toplam += $toplam_cayma;
			if($uye_oku->user_token != ""){
				$uye_adi = $uye_oku->ad;
				$uyelik_tipi = "Bireysel";
			}else{
				$uye_adi = $uye_oku->unvan;
				$uyelik_tipi = "Kurumsal";
			}
			$paket_bul = mysql_query("SELECT * FROM uye_grubu WHERE id = '".$uye_oku->paket."'");
			$paket_oku = mysql_fetch_object($paket_bul);
			$table .= '<tr>
				<td>'.$oku->uye_id.'</td>
				<td>'.$uyelik_tipi.'</td>
				<td><a href="?modul=uyeler&sayfa=uye_duzenle&id='.$oku->uye_id.'" target="_blank">'.$uye_adi.'</a></td>
				<td>'.$paket_oku->grup_adi.'</td>
				<td>'.money($toplam_cayma).' ₺</td>
			</tr>';
		}
	}
?>
<table style="font-size:15px;"  class="table table-bordered">
    
        <thead>
            <tr>
                <td>Toplam Cayma Bedeli</td>
                <td style="color: green;font-weight:bold;font-size:22px;"><?= money($toplam) ?>₺</td>
                <td></td>
            </tr>
            <tr>
                <td><a href="https://ihale.pertdunyasi.com/excel.php?q=muhasebe_uye_bakiyeleri">Excel</a></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        </thead>
        <tbody>
            <tr style="background-color: rgb(219,229,241);">
                <td>Üye ID</td>
                <td>Üyelik Tipi</td>
                <td>Üye adı soyadı</td>
                <td>Üye grubu</td>
                <td style="width: 250px;">Tutar</td>
            </tr>
			<?= $table ?>
        </tbody>
</table>