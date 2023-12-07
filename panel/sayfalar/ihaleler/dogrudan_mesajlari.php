<?php 
session_start();
$admin_id=$_SESSION['kid'];

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
		<th>Görüntüle</th>
		<th>Sil</th>
	</tr>
	</thead>';
$cek = mysql_query("select * from chat_room where dogrudan_satis_id = '".$gelen_id."' order by last_message_time desc");
while($oku = mysql_fetch_object($cek)){
	mysql_query("update chat_messages set is_admin_see = 1 where room_id = '".$oku->id."'");
	$user_id = $oku->gonderen_id;
	$user_cek = mysql_query("select * from user where id = '".$user_id."'");
	$user_oku = mysql_fetch_object($user_cek);
	$output .= '<tbody>
	<tr>
		<td>'.$user_oku->ad.'</td>
		<td>'.$user_oku->telefon.'</td>
		<td>'.$user_oku->mail.'</td>
		<td>'.$oku->last_message.'</td>
		<td>'.mesaj_tarih_duzenle($oku->last_message_time).'</td>
		<td><a onclick="mesajlari_goster_gizle(\''.$oku->id.'\')" class="btn green" style="width:100%; box-sizing:border-box; color:#fff!important;">Görüntüle</a></td>
		<td><a onclick="dogrudan_chat_room_sil(\''.$oku->id.'\')" class="btn red" style="width:100%; box-sizing:border-box; color:#fff!important;">Sil</a></td>
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
					<td colspan="5">
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
								$.post("sayfalar/ihaleler/dogrudan_mesajlari.php", {"id":ilan_id}, function(response){
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
$gelen_id = re('id');
if($gelen_id)
{
    $output .= '';   
    $ilan_favoriler = mysql_query("SELECT * FROM mesajlar WHERE dogrudan_satis_id ='".$gelen_id."' ");
    $output .= '
        <table class="table table-bordered">
        <thead>
            <tr>
            <th>Mesaj Zamanı</th>
            <th>Mesaj </th>
            <th>Gönderen Üye</th>
            <th>Cevap</th>
            <th>Gönder</th>
            
         </tr>
        </thead>'; 
		 $sira=0;
         while($favoriler = mysql_fetch_array($ilan_favoriler)){
             $arac_cek = mysql_query("SELECT * FROM dogrudan_satisli_ilanlar WHERE id = '".$gelen_id."' LIMIT 1");
             $uye_cek = mysql_query("SELECT * FROM user WHERE id = '".$favoriler['gonderen_id']."' LIMIT 1");
            
         $output .= '
         <tbody> ';
         while($uye_oku = mysql_fetch_array($uye_cek)){
             $uye_ad = $uye_oku['ad'];
             $uye_telefon = $uye_oku['telefon'];

         $output .= '
            <tr style = "'.$style.'">    
                <td id="eski_mesaj_tarih'.$sira.'">'.date("d-m-Y H:i:s", strtotime($favoriler['gonderme_zamani'])).'</td>         
                <td id="eski_mesaj'.$sira.'">'.$favoriler['mesaj'].'</td>         
				<td>'.$uye_ad.'</td>
				<td><input type="text" name="admin_cevap'.$sira.'" id="admin_cevap'.$sira.'" ></td>
				<td><button type="button" class="btn blue" onclick="cevapla('.$gelen_id.','.$favoriler['gonderen_id'].','.$sira.');" name="cevap_gonder'.$sira.'" id="cevap_gonder'.$sira.'" > Gönder </button></td>
            </tr>';  } $sira++; } 
         $output .='
         </tbody>
      </table>
         '; 
	
	$output .='
			<script>
					function cevapla(ilan_id,gonderen_id,sira){
						jQuery.ajax({
							url: "https://ihale.pertdunyasi.com/check.php",
							type: "POST",
							dataType: "JSON",
							data: {
								action: "panel_dogrudan_mesaj_cevapla",
								ilan_id: ilan_id,
								gonderen_id: gonderen_id,
								admin_mesaj: $("#admin_cevap"+parseInt(sira)).val(),
								admin_id :'.$admin_id.',
								eski_mesaj :$("#eski_mesaj"+parseInt(sira)).html(),
								eski_mesaj_tarih :$("#eski_mesaj_tarih"+parseInt(sira)).html(),
							},
							success: function(response) {
								console.log(response);
								alert("Mesaj başarıyla gönderildi");
								$("#admin_cevap"+parseInt(sira)).val("");

							}
						});
					}
				</script>
	';
    echo $output;
}
*/
?>
<script>
	function dogrudan_chat_room_sil($room_id){
		jQuery.ajax({
			url: "../check.php",
			type: "POST",
			dataType: "JSON",
			data: {
				action: "dogrudan_room_sil",
				room_id: $room_id
			},
			success: function(response) {
				location.reload();

			}
		});
	}
</script>
