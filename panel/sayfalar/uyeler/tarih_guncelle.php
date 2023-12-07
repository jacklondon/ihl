<?php 
	include('../../../ayar.php');
	$gelen_id = re('id');
	$sorgu = mysql_query("SELECT * FROM ilanlar WHERE id ='".$gelen_id."'");
	$cek=mysql_fetch_object($sorgu);
	$parcala=explode(":",$cek->ihale_saati);
	$ihale_saati=$parcala[0].":".$parcala[1];
	if($gelen_id)
	{
		$output .= '';
		$output .='
			<form method="POST">
				<div class="modal-body">
					<div class="row-fluid">
						<div class="span6">
							<label for="IDofInput">İhale Tarihi</label>
							<input type="date" value="'.$cek->ihale_tarihi.'" name="tarih_guncelle" id="tarih_guncelle'.$gelen_id.'" required class="span12" max="9999-12-31">
							<input type="hidden" name="ilanin_id" id="ilanin_id" value="'.$gelen_id.'">
						</div>      
						<div class="span6">
							<label for="IDofInput">İhale Saati</label>    
							<input type="time" value="'.$ihale_saati.'" name="saat_guncelle" id="saat_guncelle'.$gelen_id.'" required class="span12">  
						</div>      
					</div>
					<div class="row-fluid" style="margin-top:3%;">
						<div class="span6">
						</div>
						<div class="span6" style="display:none" id="uyari_span'.$gelen_id.'">
							<input type="checkbox" value="1" id="uyari_durum'.$gelen_id.'" name="uyari_durum'.$gelen_id.'" ><text style="margin-left:1%;"> Uyarıya rağmen işlemi yap</text>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
					<input type="button" onclick="panel_tarih_guncelle('.$gelen_id.');" name="ihale_tarih_degisir" value="Kaydet" class="btn blue">
				</div>
			</form> 
		';
		echo $output;
	}

?>
<script>
	function panel_tarih_guncelle(id){
		if(document.getElementById("uyari_durum"+id).checked==true){
			var uyari_durum=document.getElementById("uyari_durum"+id).value;
		}else{
			var uyari_durum="";
		}
		jQuery.ajax({
			url: "https://ihale.pertdunyasi.com/check.php",
			type: "POST",
			dataType: "JSON",
			data: {
				action: "panel_tarih_guncelle",
				ilan_id:id,
				saat:document.getElementById('saat_guncelle'+id).value,
				tarih: document.getElementById("tarih_guncelle"+id).value,
				uyari_durum: uyari_durum
			},
			success: function(response) {
				if(response.status != 200){
					if(response.ihale_durum==1){
						document.getElementById("uyari_span"+id).style.display = "block";
						alert(response.message);
					}else{
						alert(response.message);
					}
				}else{
					alert(response.message);
					location.reload();
				}
			}
		});
	}
</script>
