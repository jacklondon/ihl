<?php 
include('../../../ayar.php');
$gelen_id = re('id');
if($gelen_id)
{
	$today = date("Y-m-d");
    $output .= '';
    $query = mysql_query("SELECT * FROM `cayma_bedelleri` WHERE id='".$gelen_id."' LIMIT 1");
	$de = mysql_fetch_array($query);
	$q2=mysql_query("select * from cayma_bedelleri where id='".$de["cayma_id"]."'");
	$de2=mysql_fetch_array($q2);
	$output .= '
		<form method="POST">
			<h3>İşlem Formu</h3>
			<div class="row-fluid">
				<div class="span6">
					<label for="IDofInput">Hesap Sahibi</label> 
					<input type="text" id="hesap_sahibi" name="hesap_sahibi"  value="'.$de["hesap_sahibi"].'" class="span12"  style="text-transform: capitalize;" oninvalid="this.setCustomValidity("Lütfen ad ve soyad en az 2 kelime olacak şekilde giriniz.")" pattern="\b\w+\b(?:.*?\b\w+\b){1}" oninput="this.setCustomValidity("")">
					<input type="hidden" id="aktif_id" value="'.$gelen_id.'">
					<label for="IDofInput">Depozito Durumu</label>
					<select name="depozito_durumu" id="depozito_durumu" class="span12">
						<option value="">Depozito Durumu</option>
						<option value="İade Edildi">İade Edildi</option>
						<option value="İptal Edildi">İptal Edildi</option>
					</select>
					<label for="IDofInput">IBAN</label>
					<input type="number" minLength="24" maxLength="24" name="aktif_iban" id="aktif_iban" value="'.$de["iban"].'" class="span12">
				</div>
				<div class="span6">
					<label for="IDofInput">Tutar</label>
					<input type="text" name="aktif_tutar" id="aktif_tutar" value="'.$de2["tutar"].'" class="span12">
					<label for="IDofInput">İade Edilen Tutar</label>
					<input type="text" name="aktif_iade_tutar" id="aktif_iade_tutar" value="'.$de['tutar'].'" class="span12">
					<label for="IDofInput">İade Edilecek Tarih</label>
					<input type="date" name="iade_edilecek_tarih" id="iade_edilecek_tarih" value="'.$today.'" class="span12">
				</div>
			</div>
			<div class="row-fluid">
				<textarea name="aktif_aciklama" id="aktif_aciklama" class="span12" rows="3">'.$de["aciklama"].'</textarea>
			</div>
			<div class="row-fluid">
				<input type="button" id="aktif_duzenle" onclick="iadeGuncelle()" class="btn-primary" value="DÜZENLE">
			</div>
		</form>
	'; 
	
	echo $output;
}

?>
