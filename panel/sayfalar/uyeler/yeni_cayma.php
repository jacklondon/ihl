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
				<h3>CAYMA BEDELİ EKLE</h3>
				<div class="row-fluid">
					<div class="span6">
						<label for="IDofInput">Paranın Geldiği Tarih</label> 
						<input type="date" name="paranin_geldigi_tarih" id="paranin_geldigi_tarih" value="'.$today.'" class="span12">

						<label for="IDofInput">IBAN</label>
						<input type="text" onkeypress="return isNumberKey(event); return boslukEngelle();" maxLength="24" minlength="24" name="iban" id="iban" value="'.$de["iban"].'" class="span12">
					</div>
					<div class="span6">
						<label for="IDofInput">Tutar</label>
						<input type="number" name="tutar" id="tutar" class="span12">					
						<label for="IDofInput">Hesap Sahibi</label>
						<input type="text" id="hesap_sahibi" value="" class="span12" style="text-transform: capitalize;" oninvalid="this.setCustomValidity(\'Lütfen ad ve soyad en az 2 kelime olacak şekilde giriniz.\')" pattern="\b\w+\b(?:.*?\b\w+\b){1}" name="hesap_sahibi" oninput="this.setCustomValidity(\'\')" >
						<input type="hidden" id="uye_id" value="'.$gelen_id.'">
						
					</div>
				</div>
				<div class="row-fluid">
					<label for="IDofInput">Açıklama</label>
					<textarea name="aciklama" id="aciklama" rows="4" class="span12"></textarea>
				</div>
				<div class="row-fluid">
					<input style="float: right; background: orange;color: black;border: 2px solid #000; width: 175px;" type="button" id="yeni_ekle" onclick="yeniEkle()" class="btn-primary" value="Ekle">
				</div>
			</form>
		';

	echo $output;
}


?>
