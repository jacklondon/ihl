<?php 
include('../../../ayar.php');
// include "not_gonder.php";
$gelen_id = re('id');
if($gelen_id)
{
    $output = '';
	$aktif_admin=mysql_query("select * from kullanicilar where id='".$_SESSION["kid"]."'");
	$aktif_admin_oku=mysql_fetch_object($aktif_admin);
	$aktif_admin_id=$aktif_admin_oku->id;
	$aktif_admin_yetkiler=$aktif_admin_oku->yetki;
	$parcala=explode("|",$aktif_admin_yetkiler);
	if(count($parcala)==13){
		$sınırsız_yetki=true;
	}else{
		$sınırsız_yetki=false;
	}
	if (in_array(8, $parcala)) { 
	   $duzenleme_durumu=true;
	} else{
		$duzenlenme_durumu=false;
	}
    $query2 = mysql_query("SELECT * FROM `ilanlar` WHERE id=$gelen_id LIMIT 1");
    $qyaz = mysql_fetch_assoc($cek);
	$notlar = "";
	$say = mysql_query("SELECT * FROM ilan_notlari WHERE ilan_id ='".$gelen_id."' order by id desc");
    $output .= '<h3>'.$qyaz["ad"].'</h3>';
	$output .= '<h6>'.mysql_num_rows($say).' adet not bulundu</h6>';
	$output .= '<form method="POST" action="" enctype="multipart/form-data">
            <div class="row-fluid>
               <label for="IDofInput">Notunuz</label>
               <textarea class="span12" name="eklenecek_not" id="eklenecek_not" rows="4"></textarea>
               <input type="hidden" value="'.$gelen_id.'" name="gelen_id" id="gelen_id">
            </div>
            <div class="row-fluid">
				<input type="file" name="files[]" multiple id="ilan_not_files" >
            </div>
			<div class="row-fluid">
				<div class="span2">
					<input type="button" onclick="ilan_not_ekle('.$gelen_id.')" class="btn blue" name="notu" value="Kaydet" >
				</div>
				<div class="span2"><label>Gizlilik</label></div>
				<div class="span8">
					<select id="gizlilik" name="gizlilik">
						<option value="0">Sadece Ben </option>             
						<option value="1">Tam Yetkili Adminler Görebilir </option> 
						<option value="2" selected>Herkes Görebilir </option> 
					</select>
				</div>
            </div>
		</form>';
    $output .= '<table class="table table-bordered">
        <thead>
            <tr>
				<th>Ekleme Tarihi</th>
				<th>Ekleyen</th>
				<th>Gizlilik</th>
				<th>Not</th>
				<th>Düzenle</th>
				<th>Sil</th>
				<th>Ek</th>
			</tr>
        </thead>'; 
         $output .='<tbody>';
		 $cek = mysql_query("SELECT * FROM ilan_notlari WHERE ilan_id ='".$gelen_id."' group by ilan_id,tarih order by id desc");
		 while($oku = mysql_fetch_object($cek)){			
			if (in_array(9, $parcala)) {
				if ($sınırsız_yetki == true) {
					$silme_durumu = true;
				} else {
					if ($aktif_admin_id == $oku->ekleyen) {
						$silme_durumu = true;
					} else {
						$silme_durumu = false;
					}
				}
			} else {
				$silme_durumu = false;
			}

			if (in_array(8, $parcala)) { 
				if ($sınırsız_yetki == true) {
					$duzenleme_durumu = true;
				} else {
					if ($aktif_admin_id == $oku->ekleyen) {
						$duzenleme_durumu = true;
					} else {
						$duzenleme_durumu = false;
					}
				}
			 } else{
				$duzenlenme_durumu=false;
			 }
			
			
			/*
			if (in_array(9, $parcala)) { 
				$silme_durumu=true;
			} else{
				$silme_durumu=false;
			}
			*/
			
			$admin_cek = mysql_query("select * from kullanicilar where id = '".$oku->ekleyen."'");
			$admin_oku = mysql_fetch_assoc($admin_cek);
			$admin_adi = $admin_oku['adi']." ".$admin_oku['soyadi'];		
			if($oku->gizlilik == 0){
				$gizlilik = "Sadece ekleyen admin görebilir";				
				if($aktif_admin_id == $oku->ekleyen){
					$not = $oku->ilan_notu;
				}else{
					$not = "";
				}
			}elseif($oku->gizlilik == 1){
				$gizlilik = "Yetkili Adminler Görebilir";
				if($sinirsiz_yetki == true){
					$not = $oku->ilan_notu;
				}else{
					$not = "Yetkiniz Yetersiz";
				}
			}elseif($oku->gizlilik == 2){
				$gizlilik = "Herkes Görebilir";
				$not = $oku->ilan_notu;
			}
			$dosya_cek = mysql_query("select * from ilan_notlari where ilan_notu = '".$oku->ilan_notu."' and tarih = '".$oku->tarih."'");
			$dosya = "";
			$sayi = 0;
			$evrak_list = "";
			while($dosya_oku = mysql_fetch_object($dosya_cek)){
				if($dosya_oku->gizlilik == 0){
					if($aktif_admin_id == $dosya_oku->ekleyen){
						if($dosya_oku->dosya == 1 || $dosya_oku->dosya == 0){
							$dosya='<p style="color:black" >Dosya Yok</p>';
						}else{
							if($sayi == 0){
								$evrak_list = $dosya_oku->dosya;
							}else{
								$evrak_list .= ",".$dosya_oku->dosya;
							}
							$sayi++;
							$dosya .= '<p><a href="../assets/'.$dosya_oku->dosya.'" target="_blank"> Dosyayı Görüntüle</a>
							<a hidden id="ilan_dosya_'.$dosya_oku->dosya.'" href="../assets/'.$dosya_oku->dosya.'" download> Dosyayı Görüntüle</a></p>';
						}
					}else{
						$dosya='<p style="color:black">Sadece Ekleyen Admin Görebilir</p>';
					}
				}elseif($dosya_oku->gizlilik == 1){
					if($sinirsiz_yetki == true){
						if($dosya_oku->dosya == 1 || $dosya_oku->dosya == 0){
							$dosya='<p style="color:black">Dosya Yok</p>';
						}else{
							if($sayi == 0){
								$evrak_list = $dosya_oku->dosya;
							}else{
								$evrak_list .= ",".$dosya_oku->dosya;
							}
							$sayi++;
							$dosya .= '<p><a href="../assets/'.$dosya_oku->dosya.'" target="_blank"> Dosyayı Görüntüle</a>
							<a hidden id="ilan_dosya_'.$dosya_oku->dosya.'" href="../assets/'.$dosya_oku->dosya.'" download> Dosyayı Görüntüle</a></p>';
						}
					}else{
						$dosya='<p style="color:black">Yetkiniz Yetersiz</p>';				
					}
				}elseif($dosya_oku->gizlilik == 2){
					if($dosya_oku->dosya != 1 || $dosya_oku->dosya != 0){
						if($sayi == 0){
							$evrak_list = $dosya_oku->dosya;
						}else{
							$evrak_list .= ",".$dosya_oku->dosya;
						}
						$sayi++;
						$dosya .= '<p><a href="../assets/'.$dosya_oku->dosya.'" target="_blank"> Dosyayı Görüntüle</a>
						<a hidden id="ilan_dosya_'.$dosya_oku->dosya.'" href="../assets/'.$dosya_oku->dosya.'" download> Dosyayı Görüntüle</a></p>';
					}else{
						$dosya='<p style="color:black">Dosya Yok</p>';
					}
				}
			}
			if($duzenleme_durumu == true){
				$duzenle = '<a href="?modul=ihaleler&sayfa=ilan_not_duzenle&id='.$oku->id.'" target="_blank"> <i class="fas fa-edit"> </i> </a>';
			}else{
				$duzenle = "";
			}
			if($silme_durumu == true){
				$silme = '<a href="?modul=ayarlar&sayfa=data_sil&id='.$oku->id.'&q=ilan_not_sil" onclick="return confirm(\'Silmek istediğinize emin misiniz ?\')" ><i class="fas fa-trash"></i></a>';
			}else{
				$silme = "";
			}
			if($sayi > 0){
				$button = '<button type="button" onclick="ilan_not_indir(\'' . $evrak_list . '\');" class="button btn-primary" >Tümünü İndir</button>';
			}else{
				$button = "";
			}
			$output .= '<tr>
				<td>'.date("d-m-Y H:i:s", strtotime($oku->tarih)).'</td>
				<td>'.$admin_adi.'</td>
				<td>'.$gizlilik.'</td>
				<td>'.$not.'</td>
				<td>'.$duzenle.'</td>
				<td>'.$silme.'</td>
				<td>'.$dosya.' '.$button.'</td>
			</tr>';
		}
        $output .='</tbody>
      </table>'; 
    $output .= '</table>';
    $output.="<script>
		function ilan_not_ekle(id){
			var formData = new FormData(document.getElementById('form'));
			var gizlilik = $('#gizlilik').val();
			var eklenecek_not = $('#eklenecek_not').val();
			formData.append('action', 'ilan_notu_kaydet');
			formData.append('gelen_id', id);
			formData.append('gizlilik', gizlilik);
			formData.append('eklenecek_not', eklenecek_not);
			var filesLength=document.getElementById('ilan_not_files').files.length;
			for(var i=0;i<filesLength;i++){
				formData.append('file[]', document.getElementById('ilan_not_files').files[i]);
			}
			$.ajax({
				url: 'https://ihale.pertdunyasi.com/action.php',
				type: 'POST',
				data: formData,
				dataType: 'json',
				success: function(response) {
					if(response.status==200){
						console.log(response.toplam_not);
						openToastrSuccess(response.message);
						$('#ilanin_notlari_close').trigger('click');
						var text='<a id=\''+id+'\' class=\'view_ilan_notlari\'><i class=\'fas fa-align-justify\'>'+response.toplam_not+'</i></a>';
						$('#td_view_ilan_notlari_'+id).html(text);
					}else{
						openToastrDanger(response.message);
					}
				},
				cache: false,
				contentType: false,
				processData: false
			});
		 }
		</script>";
    echo $output;
}
?>

<script>
	async function ilan_not_indir(ids) {
		var split = ids.split(",");
		var count = 0;
		for (var i = 0; i < split.length; i++) {
			if(split[i] != ""){
				document.getElementById("ilan_dosya_" + split[i]).click();
				if(++count >= 10){
					await pause(1000);
					count = 0;
				}
			}
		}
	}
	function pause(msec) {
		return new Promise(
			(resolve, reject) => {
				setTimeout(resolve, msec || 1000);
			}
		);
	}
</script>

<script>
// Not Ekleme
	function notuKaydet(){     
		var eklenecek_not = $('#eklenecek_not').val();
		var file = $('#files').val();
		var gelen_id = $('#gelen_id').val();
		var gizlilik = $('#gizlilik').val();
		var $baseUrl = "https://ihale.pertdunyasi.com/panel/sayfalar/uyeler/";
		if(gelen_id)
		{  
			jQuery.ajax({
				url: $baseUrl+'not_gonder.php',
				type: "POST",
				dataType: "JSON",
				data: {
					eklenecek_not: eklenecek_not,
					file: file,
					gelen_id: gelen_id,
					gizlilik: gizlilik,
				},
				success: function(data) {
					console.log(data);
					$('.success').removeClass('d-none').html(data);                  
					//location.reload();
				},
				error: function(data) {
					$('.error').removeClass('d-none').html(data);
					alert('HATA! Lütfen tekrar deneyiniz.')
				}
			});
		}
	} 
</script>  

