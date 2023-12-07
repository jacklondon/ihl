<?php 
include('../../../ayar.php');
$gelen_id = re('id');
if($gelen_id){
	$today = date("Y-m-d");
    $output .= '';
    $query = mysql_query("SELECT * FROM `cayma_bedelleri` WHERE id=$gelen_id LIMIT 1");
	$fetch = mysql_fetch_assoc($query);
	if($fetch["durum"]==1){
		$output='
			<form method="POST">
				<h3>İŞLEM FORMU</h3>
				<div class="row-fluid">
					<div class="span12">
						<label for="IDofInput">Taşınacak Kategori Seç</label> 
						<select onchange="inputGoster();" id="durum" name="durum">		
							<option selected value="">Seçiniz</option>
							<option value="3">İade Edilenler</option>
							<option value="4">Araç Bedeline Mahsup Edilenler</option>
							<option value="5">Cayılan Araçlar</option>
						</select>	
						<input type="hidden" id="cayma_id" value="'.$gelen_id.'">
						<input type="hidden" id="uye_id" value="'.$fetch["uye_id"].'">
					</div>
				</div>
				<div id="cayma_form">
					<div class="row-fluid">
						<div class="span6">
							<label for="IDofInput">Paranın Geldiği Tarih</label> 
							<input type="date" disabled name="paranin_geldigi_tarih" id="paranin_geldigi_tarih" value="'.$fetch["paranin_geldigi_tarih"].'" class="span12">
							<label for="IDofInput">IBAN</label>
							<input type="text" onkeypress="return isNumberKey(event)" onchange="return isNumberKey(event); return boslukEngelle();" maxLength="24" minlength="24" name="iban" id="iban" value="'.$fetch["iban"].'" class="span12">
						</div>
						<div class="span6">
							<label for="IDofInput">Tutar</label>
							<input type="number" name="tutar" disabled value="'.$fetch["tutar"].'" id="tutar" class="span12">
							<label for="IDofInput">Hesap Sahibi</label>
							<input type="text" id="hesap_sahibi" value="'.$fetch["hesap_sahibi"].'" class="span12" style="text-transform: capitalize;" oninvalid="this.setCustomValidity(\'Lütfen ad ve soyad en az 2 kelime olacak şekilde giriniz.\')" pattern="\b\w+\b(?:.*?\b\w+\b){1}" name="hesap_sahibi" oninput="this.setCustomValidity(\'\')" >
						</div>
					</div>
				</div>
				<div class="row-fluid">
					<label for="IDofInput">Açıklama</label>
					<textarea name="aciklama" id="aciklama" rows="2" class="span12">'.$fetch["aciklama"].'</textarea>
				</div>
				<div class="row-fluid">
					<input style="float: right; background: orange;color: black;border: 2px solid #000; width: 175px;" type="button" id="cayma_duzenle" onclick="caymaDuzenle()" class="btn-primary" value="Düzenle">
				</div>
			</form>
		';
	}else if($fetch["durum"]==2){
		$output='
			<form method="POST">
				<h3>İŞLEM FORMU</h3>
				<div class="row-fluid">
					<div class="span12">
						<label for="IDofInput">Taşınacak Kategori Seç</label> 
						<select onchange="inputGoster();" id="durum" name="durum">		
							<option selected value="">Seçiniz</option>
							<option value="1">Aktif Cayma Bedelleri</option>
							<option value="3">İade Edilenler</option>
							<option value="4">Araç Bedeline Mahsup Edilenler</option>
						</select>	
						<input type="hidden" id="cayma_id" value="'.$gelen_id.'">
						<input type="hidden" id="uye_id" value="'.$fetch["uye_id"].'">
					</div>
				</div>
				<div id="cayma_form">
					<div class="row-fluid">
						<div class="span6">
							<label for="IDofInput">Paranın Geldiği Tarih</label> 
							<input type="date" disabled name="paranin_geldigi_tarih" id="paranin_geldigi_tarih" value="'.$fetch["paranin_geldigi_tarih"].'" class="span12">
							<label for="IDofInput">IBAN</label>
							<input type="text" onkeypress="return isNumberKey(event)" onchange="return isNumberKey(event); return boslukEngelle();" maxLength="24" minlength="24" name="iban" id="iban" value="'.$fetch["iban"].'" class="span12">
						</div>
						<div class="span6">
							<label for="IDofInput">Tutar</label>
							<input type="number" name="tutar" disabled value="'.$fetch["tutar"].'" id="tutar" class="span12">
							<label for="IDofInput">Hesap Sahibi</label>
							<input type="text" id="hesap_sahibi" value="'.$fetch["hesap_sahibi"].'" class="span12" style="text-transform: capitalize;" oninvalid="this.setCustomValidity(\'Lütfen ad ve soyad en az 2 kelime olacak şekilde giriniz.\')" pattern="\b\w+\b(?:.*?\b\w+\b){1}" name="hesap_sahibi" oninput="this.setCustomValidity(\'\')" >
							<label for="IDofInput">İade Tarihi</label> 
							<input type="date" name="iade_tarihi" id="iade_tarihi" value="'.$today.'" class="span12">
						</div>
					</div>
				</div>
				<div class="row-fluid">
					<label for="IDofInput">Açıklama</label>
					<textarea name="aciklama" id="aciklama" rows="2" class="span12">'.$fetch["aciklama"].'</textarea>
				</div>
				<div class="row-fluid">
					<input style="float: right; background: orange;color: black;border: 2px solid #000; width: 175px;" type="button" id="cayma_duzenle" onclick="caymaDuzenle()" class="btn-primary" value="Düzenle">
				</div>
			</form>
		';
	}else if($fetch["durum"]==3){
		$output='		
			<form method="POST">
				<h3>İŞLEM FORMU</h3>
				<div class="row-fluid">
					<div class="span12">
						<label for="IDofInput">Taşınacak Kategori Seç</label> 
						<select onchange="inputGoster();" id="durum" name="durum">		
							<option selected value="">Seçiniz</option>
							<option value="1">Aktif Cayma Bedelleri</option>
							<option value="4">Araç Bedeline Mahsup Edilenler</option>
							<option value="5">Cayılan Araçlar</option>
						</select>	
						<input type="hidden" id="cayma_id" value="'.$gelen_id.'">
						<input type="hidden" id="uye_id" value="'.$fetch["uye_id"].'">
					</div>
				</div>
				<div id="cayma_form">
					<div class="row-fluid">
						<div class="span6">
							<label for="IDofInput">Paranın Geldiği Tarih</label> 
							<input type="date" disabled name="paranin_geldigi_tarih" id="paranin_geldigi_tarih" value="'.$fetch["paranin_geldigi_tarih"].'" class="span12">
							<label for="IDofInput">IBAN</label>
							<input type="text" onkeypress="return isNumberKey(event)" onchange="return isNumberKey(event); return boslukEngelle();" maxLength="24" minlength="24" name="iban" id="iban" value="'.$fetch["iban"].'" class="span12">
						</div>
						<div class="span6">
							<label for="IDofInput">Tutar</label>
							<input type="number" name="tutar" disabled value="'.$fetch["tutar"].'" id="tutar" class="span12">
							<label for="IDofInput">Hesap Sahibi</label>
							<input type="text" id="hesap_sahibi" value="'.$fetch["hesap_sahibi"].'" class="span12" style="text-transform: capitalize;" oninvalid="this.setCustomValidity(\'Lütfen ad ve soyad en az 2 kelime olacak şekilde giriniz.\')" pattern="\b\w+\b(?:.*?\b\w+\b){1}" name="hesap_sahibi" oninput="this.setCustomValidity(\'\')" >
							<label for="IDofInput">İade Tarihi</label> 
							<input type="date" disabled name="iade_tarihi" id="iade_tarihi" value="'.$today.'" class="span12">
						</div>
					</div>
				</div>
				<div class="row-fluid">
					<label for="IDofInput">Açıklama</label>
					<textarea name="aciklama" id="aciklama" rows="2" class="span12">'.$fetch["aciklama"].'</textarea>
				</div>
				<div class="row-fluid">
					<input style="float: right; background: orange;color: black;border: 2px solid #000; width: 175px;" type="button" id="cayma_duzenle" onclick="caymaDuzenle()" class="btn-primary" value="Düzenle">
				</div>
			</form>
			
		';
	}else if($fetch["durum"]==4){
		$output='
			<form method="POST">
				<h3>İŞLEM FORMU</h3>
				<div class="row-fluid">
					<div class="span12">
						<label for="IDofInput">Taşınacak Kategori Seç</label> 
						<select onchange="inputGoster();" id="durum" name="durum">		
							<option selected value="">Seçiniz</option>
							<option value="1">Aktif Cayma Bedelleri</option>
							<option value="3">İade Edilenler</option>
							<option value="5">Cayılan Araçlar</option>
						</select>	
						<input type="hidden" id="cayma_id" value="'.$gelen_id.'">
						<input type="hidden" id="uye_id" value="'.$fetch["uye_id"].'">
					</div>
				</div>
				<div id="cayma_form">
					<div class="row-fluid">
						<div class="span6">
							<label for="IDofInput">Paranın Geldiği Tarih</label> 
							<input type="date" disabled name="paranin_geldigi_tarih" id="paranin_geldigi_tarih" value="'.$fetch["paranin_geldigi_tarih"].'" class="span12">
							<label for="IDofInput">Mahsup Tarihi</label> 
							<input type="date" name="mahsup_tarihi" id="mahsup_tarihi" value="'.$fetch["mahsup_tarihi"].'" class="span12">
						</div>
						<div class="span6">
							<label for="IDofInput">Tutar</label>
							<input type="number" name="tutar" disabled value="'.$fetch["tutar"].'" id="tutar" class="span12">
							<label for="IDofInput">Konu Araç Kodu veya Plakası</label>
							<input type="text" id="arac_kod_plaka" onchange="aracGetir();" value="" class="span12"  >
							
						</div>
					</div>
				</div>
				<div style="margin:15px" class="row-fluid">
					<label for="IDofInput">Bulunan Araç</label>
					<text id="arac_bilgisi">'.$fetch["arac_detay"].'</text>
				</div>
				<div class="row-fluid">
					<label for="IDofInput">Açıklama</label>
					<textarea name="aciklama" id="aciklama" rows="2" class="span12">'.$fetch["aciklama"].'</textarea>
				</div>
				<div class="row-fluid">
					<input style="float: right; background: orange;color: black;border: 2px solid #000; width: 175px;" type="button" id="cayma_duzenle" onclick="caymaDuzenle()" class="btn-primary" value="Düzenle">
				</div>
			</form>
		';
	}else if($fetch["durum"]==5){
		$output='
			<form method="POST">
				<h3>İŞLEM FORMU</h3>
				<div class="row-fluid">
					<div class="span12">
						<label for="IDofInput">Taşınacak Kategori Seç</label> 
						<select onchange="inputGoster();" id="durum" name="durum">		
							<option selected value="">Seçiniz</option>
							<option value="1">Aktif Cayma Bedelleri</option>
							<option value="3">İade Edilenler</option>
							<option value="4">Araç Bedeline Mahsup Edilenler</option>
						</select>
						<input type="hidden" id="cayma_id" value="'.$gelen_id.'">
						<input type="hidden" id="uye_id" value="'.$fetch["uye_id"].'">
					</div>
				</div>
				<div class="row-fluid">
					<div class="span6">
						<label for="IDofInput">Paranın Geldiği Tarih</label> 
						<input type="date" disabled name="paranin_geldigi_tarih" id="paranin_geldigi_tarih" value="'.$fetch["paranin_geldigi_tarih"].'" class="span12">
						<label for="IDofInput">Bloke Tarihi</label> 
						<input type="date" name="bloke_tarihi" id="bloke_tarihi" value="'.$fetch["bloke_tarihi"].'" class="span12">
					</div>
					<div class="span6">
						<label for="IDofInput">Tutar</label>
						<input type="number" name="tutar" disabled value="'.$fetch["tutar"].'" id="tutar" class="span12">
						<label for="IDofInput">Konu Araç Kodu veya Plakası</label>
						<input type="text" id="arac_kod_plaka" onchange="aracGetir();" value="" class="span12"  >
						
					</div>
				</div>
				<div style="margin:15px" class="row-fluid">
					<label for="IDofInput">Bulunan Araç</label>
					<text id="arac_bilgisi">'.$fetch["arac_detay"].'</text>
				</div>
				<div class="row-fluid">
					<label for="IDofInput">Açıklama</label>
					<textarea name="aciklama" id="aciklama" rows="2" class="span12">'.$fetch["aciklama"].'</textarea>
				</div>
				<div class="row-fluid">
					<input style="float: right; background: orange;color: black;border: 2px solid #000; width: 175px;" type="button" id="cayma_duzenle" onclick="caymaDuzenle()" class="btn-primary" value="Düzenle">
				</div>
			</form>
			</div>
		';
	}else if($fetch["durum"]==6){
		$output='
			
			<form method="POST">
				<h3>İŞLEM FORMU</h3>
				<div class="row-fluid">
					<div class="span12">
						<label for="IDofInput">Taşınacak Kategori Seç</label> 
						<select disabled id="durum" name="durum">		
							<option selected value="7">Tahsil Edilmiş Blokeli Borçlar</option>
						</select>
						<input type="hidden" id="cayma_id" value="'.$gelen_id.'">
						<input type="hidden" id="uye_id" value="'.$fetch["uye_id"].'">
					</div>
				</div>
				<div id="cayma_form">
					<div class="row-fluid">
						<div class="span6">
							<label for="IDofInput">Bloke Tarihi</label> 
							<input type="date" disabled name="bloke_tarihi" id="bloke_tarihi" value="'.$fetch["bloke_tarihi"].'" class="span12">
							<label for="IDofInput">Tahsil Tarihi</label> 
							<input type="date" name="tahsil_tarihi" id="tahsil_tarihi" value="'.$today.'" class="span12">
						</div>
						<div class="span6">
							<label for="IDofInput">Tutar</label>
							<input type="number" name="tutar" disabled value="'.$fetch["tutar"].'" id="tutar" class="span12">
							<label for="IDofInput">Konu Araç Kodu veya Plakası</label>
							<input type="text" disabled id="arac_kod_plaka" value="'.$fetch["arac_kod_plaka"].'" class="span12"  >
						</div>
					</div>
					<div style="margin:15px" class="row-fluid">
						<label for="IDofInput">Bulunan Araç</label>
						<text id="arac_bilgisi">'.$fetch["arac_detay"].'</text>
					</div>
					<div class="row-fluid">
						<label for="IDofInput">Açıklama</label>
						<textarea name="aciklama" id="aciklama" rows="2" class="span12">'.$fetch["aciklama"].'</textarea>
					</div>
				</div>
				<div class="row-fluid">
					<input style="float: right; background: orange;color: black;border: 2px solid #000; width: 175px;" type="button" id="cayma_duzenle" onclick="caymaDuzenle()" class="btn-primary" value="Düzenle">
				</div>
			</form>
			
		';
	}else if($fetch["durum"]==7){
		$output= '
		
			<form method="POST">
				<h3>İŞLEM FORMU</h3>
				<div class="row-fluid">
					<div class="span12">
						<label for="IDofInput">Taşınacak Kategori Seç</label> 
						<select disabled id="durum" name="durum">		
							<option selected value="6">Bloke içi Bekleyen Borçlar</option>
						</select>
						<input type="hidden" id="cayma_id" value="'.$gelen_id.'">
						<input type="hidden" id="uye_id" value="'.$fetch["uye_id"].'">
					</div>
				</div>
				<div id="cayma_form">
					<div class="row-fluid">
						<div class="span6">
							<label for="IDofInput">Bloke Tarihi</label> 
							<input type="date" disabled name="bloke_tarihi" id="bloke_tarihi" value="'.$fetch["bloke_tarihi"].'" class="span12">
							<label for="IDofInput">Konu Araç Kodu veya Plakası</label>
							<input type="text" disabled id="arac_kod_plaka" value="'.$fetch["arac_kod_plaka"].'" class="span12"  >
							
						</div>
						<div class="span6">
							
							<label for="IDofInput">Tutar</label>
							<input type="number" name="tutar" disabled value="'.$fetch["tutar"].'" id="aktif_tutar" class="span12">
						</div>
					</div>
					<div style="margin:15px" class="row-fluid">
						<label for="IDofInput">Bulunan Araç</label>
						<text id="arac_bilgisi">'.$fetch["arac_detay"].'</text>
					</div>
					<div class="row-fluid">
						<label for="IDofInput">Açıklama</label>
						<textarea name="aciklama" id="aciklama" rows="2" class="span12">'.$fetch["aciklama"].'</textarea>
					</div>
				</div>
				<div class="row-fluid">
					<input style="float: right; background: orange;color: black;border: 2px solid #000; width: 175px;" type="button" id="cayma_duzenle" onclick="caymaDuzenle()" class="btn-primary" value="Düzenle">
				</div>
			</form>
			
			
		';
	}else{
		$output .= '
			<form  method="POST">
				<h3>İŞLEM FORMU</h3>
				<div id="cayma_form">
				</div>
			</form>
		';
	}
	$output.='
		<script>

		
			
		</script>
	';
	  
	echo $output;
}


?>
