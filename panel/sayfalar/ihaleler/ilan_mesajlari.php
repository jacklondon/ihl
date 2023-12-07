<?php
session_start();
$admin_id = $_SESSION['kid'];

include('../../../ayar.php');
$gelen_id = re('id');
$sira = 0;
$output = '<table class="table table-bordered">
<thead>
	<tr>
		<th>Adı Soyadı</th>
		<th>Cep</th>
		<th>Email</th>
		<th>Son Mesaj </th>
		<th>Mesaj Zamanı</th>
		<th>Araç Linki</th>
		<th>Görüntüle</th>
	</tr>
	</thead>';

$cek = mysql_query("select * from chat_room where ilan_id = '".$gelen_id."' and status = 1 order by last_message_time desc");

while($oku = mysql_fetch_object($cek)){
	mysql_query("update chat_messages set is_admin_see = 1 where room_id = '".$oku->id."'");
	$user_id = $oku->gonderen_id;
	$user_cek = mysql_query("select * from user where id = '".$user_id."'");
	$user_oku = mysql_fetch_object($user_cek);
	$arac_cek = mysql_query("SELECT * FROM ilanlar WHERE id = '".$gelen_id."' LIMIT 1");
	$arac_oku = mysql_fetch_object($arac_cek);
	$arac_marka = mysql_query("SELECT * FROM marka WHERE markaID = '".$arac_oku->marka."'");
	$marka_cek = mysql_fetch_object($arac_marka);
	$marka = $marka_cek->marka_adi;
	$model_yili = $arac_oku->model;
	$model_yili = $arac_oku->model_yili;
	$tip = $arac_oku->tip;
	$hepsi = $model_yili." ".$marka." ".$model." ".$tip;	
	$output .= '<tbody>
	<tr>
		<td>'.$user_oku->ad.'</td>
		<td>'.$user_oku->telefon.'</td>
		<td>'.$user_oku->mail.'</td>
		<td>'.$oku->last_message.'</td>
		<td>'.mesaj_tarih_duzenle($oku->last_message_time).'</td>
		<td><a href="../arac_detay.php?id='.$gelen_id.'&q=ihale" target="_blank">'.$hepsi.'</a></td>  
		<td><a onclick="mesajlari_goster_gizle(\''.$oku->id.'\')" class="btn green" style="width:100%; box-sizing:border-box; color:#fff!important;">Görüntüle</a></td>
	</tr>
	</tbody>
	<tbody id="mesaj_listesi_'.$oku->id.'" style="display:none;">';
	$mesaj_cek = mysql_query("select * from chat_messages where room_id = '".$oku->id."' and status = 1 order by id asc");
	while($mesaj_oku = mysql_fetch_object($mesaj_cek)){
		if($mesaj_oku->gonderen_type == 1){
			$gonderen_cek = mysql_query("select * from user where id = '".$mesaj_oku->gonderen_id."'");
			$gonderen_oku = mysql_fetch_object($gonderen_cek);
			$gonderen = $gonderen_oku->ad." ".$gonderen_oku->soyad;
		}else{
			$gonderen_cek = mysql_query("select * from kullanicilar where id = '".$mesaj_oku->gonderen_id."'");
			$gonderen_oku = mysql_fetch_object($gonderen_cek);
			$gonderen = "Admin Mesajı (".$gonderen_oku->kullanici_adi.")";
		}
		$output .= '<tr id="ilan_mesaji_'.$mesaj_oku->id.'">
					<td colspan="6">
						<p style="color:red; margin: unset;">'.$gonderen.' ('.mesaj_tarih_duzenle($mesaj_oku->add_time).')</p>
						<p style="margin:unset;">'.$mesaj_oku->mesaj.'</p>
					</td>
					<td>
						<a class="btn red" onclick="mesaj_sil_yeni(\''.$mesaj_oku->id.'\')" style="width:100%; color:#fff!important; box-sizing:border-box;">
							<i class="fas fa-trash"></i> Sil
						</a>
					</td>
			</tr>';
			$sira++;
	}
	$output .= '<tr>
					<td colspan="5">
						<input type="text" class="span8 m-wrap" id="admin_cevap_'.$user_id.'" placeholder="Mesajınızı Giriniz." style="width:100%; margin:0px!important; padding:0px 20px; box-sizing:border-box; height:45px!important;">
					</td>
					<td colspan="2">
						<button type="button" onclick="cevapla('.$oku->id.','.$admin_id.','.$user_id.','.$gelen_id.')" class="btn blue span4" style="float: right; width:100%; box-sizing:border-box; height:45px;"> Gönder </button>
					</td>	
				</tr>';
}
$output .= '</tbody>
</table>';

$output .= '<script>
	function mesajlari_goster_gizle($mesaj_id){
		var x = document.getElementById("mesaj_listesi_"+$mesaj_id);
		if (x.style.display === "none") {
			x.style.display = "table-row-group";
		} else {
			x.style.display = "none";
		}
	}
</script>';
$output .='<script>
				function mesaj_sil_yeni(mesaj_id){
					jQuery.ajax({
						url: "https://ihale.pertdunyasi.com/check.php",
						type: "POST",
						dataType: "JSON",
						data: {
							action: "panel_mesaji_sil_yeni",
							mesaj_id: mesaj_id
						},
						success: function(response) {
							if(response.status == 200){
								$("#ilan_mesaji_"+mesaj_id).remove();
							}
						}
					});
				}
				function cevapla(room_id,admin_id,alan_id,ilan_id){
					jQuery.ajax({
						url: "https://ihale.pertdunyasi.com/check.php",
						type: "POST",
						dataType: "JSON",
						data: {
							action: "panel_mesaj_cevapla_son",
							room_id: room_id,
							admin_id: admin_id,
							admin_mesaj: $("#admin_cevap_"+alan_id+"").val(),
						},
						success: function(response) {
							if(response.status == 200){
								alert("Mesaj başarıyla gönderildi");
								$("#admin_cevap").val("");
								$.post("sayfalar/ihaleler/ilan_mesajlari.php", {"id":ilan_id}, function(response){
									$("#mesaj_ilan").html(response);
									//$("#ilan_mesaj").modal("show")
								})
							}else{
								alert(response.message);
							}
							
						}
					});
				}
		</script>';
echo $output;

/*
$cek = mysql_query("SELECT mesajlar.* FROM mesajlar INNER JOIN ilanlar on ilanlar.id=mesajlar.ilan_id WHERE mesajlar.ilan_id = '".$gelen_id."' and mesajlar.gonderen_id <> 0 group by mesajlar.gonderen_id ORDER BY mesajlar.gonderme_zamani DESC");
mysql_query("update mesajlar set is_admin_see = 1 where ilan_id = '" . $gelen_id . "'");
while ($oku = mysql_fetch_object($cek)) {
	if($oku->gonderen_id == 0){
		$user_id = $oku->alan_id;
	}else{
		$user_id = $oku->gonderen_id;
	}
	$user_cek = mysql_query("select * from user where id = '".$user_id."'");
	$user_oku = mysql_fetch_object($user_cek);
	$arac_cek = mysql_query("SELECT * FROM ilanlar WHERE id = '".$gelen_id."' LIMIT 1");
	$arac_oku = mysql_fetch_object($arac_cek);
	$arac_marka = mysql_query("SELECT * FROM marka WHERE markaID = '".$arac_oku->marka."'");
	$marka_cek = mysql_fetch_object($arac_marka);
	$marka = $marka_cek->marka_adi;
	$model_yili = $arac_oku->model;
	$model_yili = $arac_oku->model_yili;
	$tip = $arac_oku->tip;
	$hepsi = $model_yili." ".$marka." ".$model." ".$tip;	
	$output .='<tbody>
	<tr>
		<td>'.$user_oku->ad.'</td>
		<td>'.$user_oku->telefon.'</td>
		<td>'.$user_oku->mail.'</td>
		<td>'.$oku->mesaj.'</td>
		<td>'.$oku->gonderme_zamani.'</td>
		<td><a href="../arac_detay.php?id='.$gelen_id.'&q=ihale" target="_blank">'.$hepsi.'</a></td>  
		<td><a onclick="mesajlari_goster_gizle(\''.$oku->id.'\')" class="btn green" style="width:100%; box-sizing:border-box; color:#fff!important;">Görüntüle</a></td>
	</tr>
	</tbody>
	<tbody id="mesaj_listesi_'.$oku->id.'" style="display:none;">';
	$mesaj_cek = mysql_query("select * from mesajlar where ilan_id = '".$gelen_id."' and (gonderen_id = '".$oku->gonderen_id."' or alan_id = '".$oku->gonderen_id."')  order by id asc");
	while($mesaj_oku = mysql_fetch_object($mesaj_cek)){
		if($mesaj_oku->gonderen_id == 0){
			$gonderen = 'Admin Mesajı';
		}else{
			$gonderen_cek = mysql_query("select * from user where id = '".$oku->gonderen_id."'");
			$gonderen_oku = mysql_fetch_object($gonderen_cek);
			$gonderen = $gonderen_oku->ad;
		}
	$output .= '<tr id="ilan_mesaji_'.$mesaj_oku->id.'">
					<td colspan="6">
						<p style="color:red; margin: unset;">'.$gonderen.' ('.$mesaj_oku->gonderme_zamani.')</p>
						<p style="margin:unset;">'.$mesaj_oku->mesaj.'</p>
					</td>
					<td>
						<a class="btn red" onclick="mesaj_sil(\''.$mesaj_oku->id.'\')" style="width:100%; color:#fff!important; box-sizing:border-box;">
							<i class="fas fa-trash"></i> Sil
						</a>
					</td>
			</tr>';
			$sira++;
	}
	$output .= '<tr>
					<td colspan="5">
						<input type="text" class="span8 m-wrap" id="admin_cevap_'.$user_id.'" placeholder="Mesajınızı Giriniz." style="width:100%; margin:0px!important; padding:0px 20px; box-sizing:border-box; height:45px!important;">
					</td>
					<td colspan="2">
						<button type="button" onclick="cevapla('.$gelen_id.',0,'.$user_id.')" class="btn blue span4" style="float: right; width:100%; box-sizing:border-box; height:45px;"> Gönder </button>
					</td>	
				</tr>';
}
$output .= '</tbody>
</table>';

$output .= '<script>
	function mesajlari_goster_gizle($mesaj_id){
		var x = document.getElementById("mesaj_listesi_"+$mesaj_id);
		if (x.style.display === "none") {
			x.style.display = "table-row-group";
		} else {
			x.style.display = "none";
		}
	}
</script>';
$output .='<script>
				function mesaj_sil(mesaj_id){
					jQuery.ajax({
						url: "https://ihale.pertdunyasi.com/check.php",
						type: "POST",
						dataType: "JSON",
						data: {
							action: "panel_mesaji_sil",
							mesaj_id: mesaj_id
						},
						success: function(response) {
							if(response.status == 200){
								$("#ilan_mesaji_"+mesaj_id).remove();
							}
						}
					});
				}
				function cevapla(ilan_id,gonderen_id,alan_id){
					jQuery.ajax({
						url: "https://ihale.pertdunyasi.com/check.php",
						type: "POST",
						dataType: "JSON",
						data: {
							action: "panel_mesaj_cevapla_yeni",
							ilan_id: ilan_id,
							gonderen_id: gonderen_id,
							admin_mesaj: $("#admin_cevap_"+alan_id+"").val(),
							admin_id :'.$admin_id.',
							alan_id: alan_id
						},
						success: function(response) {
							alert("Mesaj başarıyla gönderildi");
							$("#admin_cevap").val("");
							$.post("sayfalar/ihaleler/ilan_mesajlari.php", {"id":ilan_id}, function(response){
								$("#mesaj_ilan").html(response);
								//$("#ilan_mesaj").modal("show")
							})
						}
					});
				}
		</script>';
echo $output;
*/