<?php 
include('../../../ayar.php');
$gelen_id = re('id');
if($gelen_id){
	$today = date("Y-m-d");
    $output .= '';
    $query = mysql_query("SELECT * FROM `cayma_bedelleri` WHERE uye_id=$gelen_id LIMIT 1");

		$output .= '
			<script src="assets/ckeditor4/ckeditor.js"></script>
			<form id="denmeFORM" method="POST">
				<h3>BORÇ BAKİYE EKLE</h3>
				<div class="row-fluid">
					<div class="span6">
						<label for="IDofInput">Borcun Oluştuğu Tarih</label> 
						<input type="date" name="bloke_tarihi" id="bloke_tarihi" value="'.$today.'" class="span12">
						
						<label for="IDofInput">Konu araç kodu veya plakası</label> 
						<input type="text" name="arac_kod_plaka" onchange="aracGetir();" id="arac_kod_plaka" class="span12">
						
						<input type="hidden" id="uye_id" value="'.$gelen_id.'">
						
					</div>
					<div class="span6">
						<label for="IDofInput">Tutar</label>
						<input type="number" name="tutar" id="tutar" class="span12">
					</div>
				</div>
				<div style="margin:15px" class="row-fluid">
					<label for="IDofInput">Bulunan Araç</label>
					<text id="arac_bilgisi"> </text>
				</div>
				<div class="row-fluid">
					<label for="IDofInput">Açıklama</label>
					<textarea name="aciklama" id="aciklama" rows="2" class="span12"></textarea>
				</div>
				<div class="row-fluid">
					<input style="float: right; background: orange;color: black;border: 2px solid #000; width: 175px;" type="button" id="yeni_borc" onclick="yeniBorcEkle()" class="btn-primary" value="Ekle">
				</div>
			</form>
		';
	  
	echo $output;
}


?>
