<?php
function pre_up($str)
{
	$str = str_replace('i', 'İ', $str);
	$str = str_replace('ı', 'I', $str);
	return $str;
}
session_start();
$admin_id = $_SESSION['kid'];

$sehir_cek = mysql_query("SELECT * FROM sehir WHERE sehirID <> 0 ORDER BY sehiradi ASC");
$gelen_id = re("id");

$hizli_ekle_kategori = re("hizli_ekle_kategori_id");

$ilani_cek = mysql_query("SELECT * FROM ilanlar WHERE id = $gelen_id");

$admin_yetki_cek = mysql_query("Select * from kullanicilar where id='" . $admin_id . "' ");
$admin_yetki_oku = mysql_fetch_assoc($admin_yetki_cek);
$yetkiler = $admin_yetki_oku["yetki"];
$yetki_parcala = explode("|", $yetkiler);

if (!in_array(1, $yetki_parcala)) {
	$aktiflik = "disabled";
	$gorunme = "none";
} else {
	$aktiflik = "";
	$gorunme = "block";
}

?>

<!-- <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>-->
<style>
	.fix {
		border: 5px solid black;
	}

	.offscreen {
		opacity: 0;
		position: absolute;
		z-index: -9999;
		pointer-events: none;
	}

	.files input {
		outline: 2px dashed red;
		outline-offset: -10px;
		-webkit-transition: outline-offset .15s ease-in-out, background-color .15s linear;
		transition: outline-offset .15s ease-in-out, background-color .15s linear;
		padding: 120px 0px 85px 35%;
		text-align: center !important;
		margin: 0;
		width: 100% !important;
	}

	.files input:focus {
		outline: 2px dashed #92b0b3;
		outline-offset: -10px;
		-webkit-transition: outline-offset .15s ease-in-out, background-color .15s linear;
		transition: outline-offset .15s ease-in-out, background-color .15s linear;
		border: 1px solid #92b0b3;
	}

	.files {
		position: relative
	}

	.files:after {
		pointer-events: none;
		position: absolute;
		top: 60px;
		left: 0;
		width: 50px;
		right: 0;
		height: 56px;
		content: "";
		background-image: url(images/dosya_yukleme.png);
		display: block;
		margin: 0 auto;
		background-size: 100%;
		background-repeat: no-repeat;
	}

	.color input {
		background-color: #f1f1f1;
	}

	.files:before {
		position: absolute;
		bottom: 10px;
		left: 0;
		pointer-events: none;
		width: 100%;
		right: 0;
		height: 57px;
		content: "veya Dosyaları buraya sürükle bırak yapabilirsiniz ";
		display: block;
		margin: 0 auto;
		color: red;
		font-weight: 600;
		text-align: center;
	}

	.blue-text {
		color: blue;
	}

	.underline {
		text-decoration: underline;
	}

	.drop-field {
		position: relative;
		text-align: center;
		vertical-align: middle;
	}

	.drop-field,
	.drop-area {
		margin-top: 10px;
		height: 200px;
		width: 100%;
	}

	.drop-field .browse {
		z-index: 0;
		position: absolute;
		left: 0;
		bottom: 0;
		right: 0;
		margin: 0 auto;
	}

	.drop-field .drop-area {
		display: block;
		border: 3px dashed #ce680d;
		position: relative;
	}

	.drop-field,
	.drop-area,
	.drop-field .browse {
		transition: all 0.3s;
	}

	.drop-field.loaded .drop-area {
		border: 1px solid blue;
	}

	.drop-field .browse {
		opacity: 0;
		transform: translateY(100%);
	}

	.drop-field.loaded .browse {
		opacity: 1;
		transform: translateY(0);
	}

	.drop-field.hover .drop-area {
		border: 1px solid black;
	}

	.drop-field .drop-area input[type="file"] {
		height: 100%;
		width: 100%;
		position: absolute;
		display: block;
		z-index: 3;
		top: 0;
		left: 0;
		opacity: 0.000001;
	}

	.drop-field .file-list {
		position: absolute;
		z-index: 0;
		top: 0;
		left: 0;
		text-align: center;
	}

	.drop-field .remove {
		position: absolute;
		left: 20px;
		top: 20px;
		z-index: 4;
		transition: all 0.3s;
		opacity: 0;
		transform: translateY(-100%);
		cursor: pointer;
	}

	.drop-field .remove:hover {
		color: blue;
	}

	.drop-field.loaded .remove {
		opacity: 1;
		transform: translateY(0);
	}

	.drop-field ul li {
		margin-left: 50px;
		font-size: 15px;
		padding: 0;
		text-align: center;
		list-style: none;
	}
</style>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="js/il_ilce.js?v=14"></script>
<script src="js/marka_model.js?v=4"></script>
<!-- <script src="js/teklif.js?v=2"></script> -->
<!-- <script src="https://cdn.ckeditor.com/4.7.3/standard/ckeditor.js"></script> -->
<!--<script src="https://cdn.ckeditor.com/ckeditor5/27.0.0/classic/ckeditor.js"></script>-->
<script src="../js/ckeditor4/ckeditor.js"></script>
<style>
	.row {
		background: #f6f6f6;
		overflow: hidden;
		padding: 10px;
	}

	.col {
		float: left;
		width: 50%
	}

	#plaka {
		text-transform: uppercase;
	}

	.deneme {
		opacity: 1 !important;
		z-index: 999;
	}

	.isDisabled {
		color: currentColor;
		cursor: pointer;
		opacity: 0.5;
		text-decoration: none;
	}
	.chec {
		opacity: 1 !important;
		z-index: 999 !important;
	}

	.chec2 {
		opacity: 1 !important;
		z-index: 999 !important;
	}

	/* .checker span
		{
			background:transparent!important;
		} 
	*/
</style>
<script>

/*
	window.onload = TriggerVarMi;
	function TriggerVarMi() {
		var trigger_sor = localStorage.getItem('gorsel_trigger');
		if(trigger_sor == 1){
			document.getElementById("foto_trigger").click();		
			localStorage.removeItem("gorsel_trigger");
		}
	}
*/

	window.onload = ilan_trigger_var_mi;
	function ilan_trigger_var_mi() {
		var gorsel_trigger_sor = localStorage.getItem('gorsel_trigger');
		if (gorsel_trigger_sor == 1) {
			document.getElementById("arac_fotograflari_tab").click();
			localStorage.removeItem("gorsel_trigger");
		} else {
			var trigger_sor = localStorage.getItem('ilan_tab_name');
			if (trigger_sor != "" && trigger_sor != undefined) {
				console.log("tıklandı");
				document.getElementById(trigger_sor).click();
				localStorage.removeItem("ilan_tab_name");
			}
		}
	}
	function ihale_trigger(tab_name) {
		localStorage.setItem('ilan_tab_name', tab_name);
	}
</script>


<?php if (!empty($gelen_id)) { ?>
	<?php
	$geleni_cek = mysql_query("select * from ilanlar where id = '" . $gelen_id . "'");
	$geleni_oku = mysql_fetch_assoc($geleni_cek);
	$gelen_marka_cek = mysql_query("select * from marka where markaID='" . $geleni_oku["marka"] . "' ");
	$gelen_marka_oku = mysql_fetch_object($gelen_marka_cek);
	if ($geleni_oku['ihale_tarihi'] . " " . $geleni_oku['ihale_saati'] > date('Y-m-d H:i:s')) {
		$statu_bas = '<li><a>Statü Bilgileri</a></li>';
	} else {
		if (in_array(3, $yetki_parcala)) {
			$statu_bas = '<li onclick="ihale_trigger(\'statu_bilgileri_tab\')"><a id="statu_bilgileri_tab" href="#statu_bilgileri" data-toggle="tab">Statü Bilgileri</a></li>';
		} else {
			$statu_bas = '<li><a>Statü Bilgileri</a></li>';
		}
	}
	?>
	<?php include('islemler/ilanlar/ilan_duzenle.php'); ?>
	<div class="row-fluid">
		<b style="float:right;font-size:20px;margin:10px;"><?php echo "#" . $geleni_oku["arac_kodu"] . " / " . $geleni_oku["model_yili"] . " / " . $gelen_marka_oku->marka_adi . " / " . $geleni_oku["model"] . " / " . $geleni_oku["tip"] ?></b>
	</div>
	<div class="tabbable">
		<!-- Only  for left/right tabs -->
		<ul class="nav nav-tabs">
			<li onclick="ihale_trigger('arac_bilgileri_tab')" class="active"><a id="arac_bilgileri_tab" href="#arac_bilgileri" data-toggle="tab">Araç Bilgileri</a></li>
			<li onclick="ihale_trigger('arac_fotograflari_tab')"><a id="arac_fotograflari_tab" href="#arac_fotograflari" data-toggle="tab">Araç Fotoğrafları</a></li>
			<?= $statu_bas ?>
			<li onclick="ihale_trigger('yuklenen_dosyalar_tab')"><a id="yuklenen_dosyalar_tab" href="#yuklenen_dosyalar" data-toggle="tab">Yüklenen Dosyalar</a></li>
		</ul>
		<div class="tab-content">
			<div class="tab-pane active" id="arac_bilgileri">
				<form method="POST" id="form" name="form" enctype="multipart/form-data">
					<?php while ($ilani_oku = mysql_fetch_array($ilani_cek)) {
						$max_teklif = $ilani_oku["son_teklif"];
						$marka_cek = mysql_query("select * from marka where markaID='" . $ilani_oku["marka"] . "' ");
						$marka_oku = mysql_fetch_object($marka_cek);
						$get_sigorta = mysql_query("SELECT * FROM sigorta_ozellikleri WHERE id = '" . $ilani_oku['sigorta'] . "'");
						$set_sigorta = mysql_fetch_assoc($get_sigorta);
						$sigorta_name = $set_sigorta['sigorta_adi'];
						$get_model = mysql_query("SELECT * FROM model");
						$set_model = mysql_fetch_assoc($get_model);
						$model_adi = $set_model['model_adi'];
						$dosya_masrafi = $ilani_oku['dosya_masrafi'];
					?>
						<?php
						$sorgu = mysql_query("SELECT * FROM komisyon_oranlari WHERE sigorta_id = '" . $ilani_oku['sigorta'] . "'");
						$sorgu_say = mysql_num_rows($sorgu);
						$arttir = 1;
						$oran = array();
						$standart_net = array();
						$luks_net = array();
						$standart_onbinde = array();
						$luks_onbinde = array();
						while ($sonuc = mysql_fetch_array($sorgu)) {
							array_push($oran, $sonuc['komisyon_orani']);
							array_push($standart_net, $sonuc['net']);
							array_push($luks_net, $sonuc['lux_net']);
							array_push($standart_onbinde, $sonuc['onbinde']);
							array_push($luks_onbinde, $sonuc['lux_onbinde']);
						?>
							<input type="hidden" id="standart_net" value="<?= $standart_net ?>">
							<input type="hidden" id="luks_net" value="<?= $luks_net ?>">
							<input type="hidden" id="standart_onbinde" value="<?= $standart_onbinde ?>">
							<input type="hidden" id="luks_onbinde" value="<?= $luks_onbinde ?>">
							<input type="hidden" id="oran" value="<?= $oran ?>">
						<?php } ?>
						<input type="hidden" id="hesaplama" value="<?= $ilani_oku['hesaplama'] ?>">
						<input type="hidden" id="sorgu_sayi" value="<?= $sorgu_say ?>">
						<text style="color:red"><?= $uyari ?></text>
						<div class="row-fluid">
							<div class="span6">
								<label for="IDofInput">Plaka</label>
								<input type="text" class="span12" name="plaka" id="plaka" onchange="plaka_sorgu();" placeholder="01AA0000" value="<?= $ilani_oku['plaka'] ?>" onkeypress="return boslukEngelle()" pattern="[0-9]{2}[A-Za-z]{1,3}[0-9]{2,4}" oninvalid="this.setCustomValidity('LÜTFEN PLAKAYI DÜZGÜN GİRİN')" oninput="this.setCustomValidity('')" maxlength="8" />
								<label for="IDofInput">Araç Kodu</label>
								<input type="text" class="span12" name="arac_kodu" id="arac_kodu" onchange="arac_kodu_sorgu();" value="<?= $ilani_oku['arac_kodu'] ?>" onkeypress="return boslukEngelle()" />
								<label for="IDofInput">Hesaplama</label>
								<select class="span12" name="hesaplama" id="hesaplama" required>
									<option <?php if($ilani_oku["hesaplama"] == "Standart"){echo "selected";} ?> value="Standart">Standart</option>
									<option <?php if($ilani_oku["hesaplama"] == "Luks"){echo "selected";} ?> value="Luks">Ticari</option>
								</select>
								<?php $sigorta_cek = mysql_query("SELECT * FROM sigorta_ozellikleri"); ?>
								<label for="IDofInput">Sigorta Şirketi*</label>
								<select class="span12" name="sigorta" id="sigorta" required>
									<?php while ($sigorta_oku = mysql_fetch_array($sigorta_cek)) { ?>
										<option value="<?= $sigorta_oku['id'] ?>" <?php if ($ilani_oku['sigorta'] == $sigorta_oku['id']) {echo "selected";} ?>><?= $sigorta_oku['sigorta_adi'] ?></option>
									<?php } ?>
								</select>
								<label for="IDofInput">Marka*</label>
								<select class="span12" name="marka" id="marka" reuqired>
									<?php $marka_bul = mysql_query("select * from marka where markaID = '" . $ilani_oku['marka'] . "'");
									$markayaz = mysql_fetch_assoc($marka_bul);
									$markanin_idsi = $markayaz['markaID'];
									?>

									<?php $marka_cek = mysql_query("SELECT * FROM marka order by marka_adi asc");
									while ($marka_oku = mysql_fetch_array($marka_cek)) { ?>
										<option value="<?= $marka_oku['markaID'] ?>" <?php if ($marka_oku['markaID'] == $ilani_oku['marka']) {
											echo "selected";
										} ?>><?= mb_strtoupper(pre_up($marka_oku['marka_adi'])) ?></option>
									<?php } ?>
								</select>
								<label for="IDofInput">Model*</label>
								<select class="span12" name="model" id="model" required>
									<option value="<?= $ilani_oku['model'] ?>" selected><?= mb_strtoupper(pre_up($ilani_oku['model'])) ?></option>
								</select>
								<label for="IDofInput">Tip</label>
								<input class="span12" type="text" value="<?= $ilani_oku['tip'] ?>" style="text-transform:uppercase" name="tip" id="tip">
								<?php $anlik_yil = date("Y") ?>
								<label for="IDofInput">Model Yılı</label>
								<input class="span12" type="number" onkeypress="return isNumberKey(event)" value="<?= $ilani_oku['model_yili'] ?>" name="model_yili" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxLength="4" min="1950" max="<?= $anlik_yil; ?>" id="model_yili">
								<!--<label for="IDofInput">Piyasa Değeri</label>
								<input class="span12" type="text" value="<?= $ilani_oku['piyasa_degeri'] ?>" onkeypress="return isNumberKey(event)" name="piyasa_degeri" id="piyasa_degeri"  >-->
								<label for="IDofInput">TSRSB Değeri</label>
								<input class="span12" type="text" value="<?= $ilani_oku['tsrsb_degeri'] ?>" onkeypress="return isNumberKey(event)" name="tsrsb_degeri" id="tsrsb_degeri" placeholder="sadece rakam">
								<label for="IDofInput">Açılış Fiyatı</label>
								<input class="span12" type="text" value="<?= $ilani_oku['acilis_fiyati'] ?>" onkeypress="return isNumberKey(event)" name="acilis_fiyati" id="acilis_fiyati">
								<label for="IDofInput">Profil</label>
								<select class="span12" name="profil" id="profil">
									<option value="<?= $ilani_oku['profil'] ?>" selected><?= $ilani_oku['profil'] ?></option>
									<option value="Çekme Belgeli/Pert Kayıtlı">Çekme Belgeli/Pert Kayıtlı</option>
									<option value="Çekme Belgeli">Çekme Belgeli</option>
									<option value="Hurda Belgeli">Hurda Belgeli</option>
									<option value="Plakalı">Plakalı Ruhsatlı</option>
									<option value="Diğer">Diğer</option>
								</select>

								<label for="IDofInput">Vites Tipi</label>
								<select class="span12" name="vites_tipi" id="vites_tipi">
									<option <?php if ($ilani_oku['vites_tipi'] == "") {
												echo "selected";
											} ?> value="">Seçiniz</option>
									<option <?php if ($ilani_oku['vites_tipi'] == "Düz Vites") {
												echo "selected";
											} ?> value="Düz Vites">Düz Vites</option>
									<option <?php if ($ilani_oku['vites_tipi'] == "Otomatik Vites") {
												echo "selected";
											} ?> value="Otomatik Vites">Otomatik Vites</option>
								</select>

								<label for="IDofInput">Yakıt Tipi</label>
								<select class="span12" name="yakit_tipi" id="yakit_tipi">
									<option <?php if ($ilani_oku['yakit_tipi'] == "") {
												echo "selected";
											} ?> value="">Seçiniz</option>
									<option <?php if ($ilani_oku['yakit_tipi'] == "Benzinli") {
												echo "selected";
											} ?> value="Benzinli">Benzinli</option>
									<option <?php if ($ilani_oku['yakit_tipi'] == "Benzin+Lpg") {
												echo "selected";
											} ?> value="Benzin+Lpg">Benzin+Lpg</option>
									<option <?php if ($ilani_oku['yakit_tipi'] == "Dizel") {
												echo "selected";
											} ?> value="Dizel">Dizel</option>
									<option <?php if ($ilani_oku['yakit_tipi'] == "Hybrit") {
												echo "selected";
											} ?> value="Hybrit">Hybrit</option>
									<option <?php if ($ilani_oku['yakit_tipi'] == "Elektrikli") {
												echo "selected";
											} ?> value="Elektrikli">Elektrikli</option>
								</select>

								<!--<label for="IDofInput">İhale Türü</label>
								<select name="ihale_turu" id="ihale_turu" >
									<option value="<?= $ilani_oku['ihale_turu'] ?>" selected><?= $ilani_oku['ihale_turu'] ?></option>
									<option value="1">Açık İhale</option>
									<option value="2">Kapalı İhale</option>
								</select>-->
							</div>
							<div class="span6">
								<label for="IDofInput">Şehir</label>
								<select class="span12" name="sehir" id="sehir">
									<option value="0">Bilinmiyor</option>
									<?php
									while ($sehir_oku = mysql_fetch_array($sehir_cek)) {
									?>
										<option value="<?= $sehir_oku["sehirID"] ?>" <?php if ($sehir_oku['sehiradi'] == $ilani_oku['sehir']) {
																						echo "selected";
																					} ?>><?= $sehir_oku["sehiradi"]; ?></option>
									<?php } ?>
								</select>
								<?php
								$ilce_cek = mysql_query("SELECT * FROM ilce WHERE ilce_adi = '" . $ilani_oku['ilce'] . "'");
								$ilce_oku = mysql_fetch_assoc($ilce_cek);
								$ilce_adi = $ilce_oku['ilce_adi'];
								?>
								<!-- <label for="IDofInput">İlçe</label>
            <select class="span12" name="ilce" id="ilce" >
            <option value="<?= $ilce_adi ?>" <?php if ($ilce_adi == $ilani_oku['ilce']) {
													echo "selected";
												} ?> ><?= $ilani_oku['ilce'] ?></option>
            </select>-->

								<!-- <label for="IDofInput">İhale Başlama Tarihi</label>
            <input class="span12" type="date" value="<?= $ilani_oku['ihale_kapanis'] ?>" name="ihale_tarihi" id="ihale_tarihi"> -->

								<label for="IDofInput">İhale Bitiş Tarihi*</label>

								<input class="span12" onfocusout="tarih_sorgula();" type="date" value="<?= $ilani_oku['ihale_tarihi'] ?>" name="ihale_tarihi" id="ihale_tarihi" required>
								<!-- <input class="span12" type="date" onchange="tarih_sorgula()" value="<?= $ilani_oku['ihale_tarihi'] ?>" name="ihale_tarihi" id="ihale_tarihi" required>-->

								<label for="IDofInput">İhale Bitiş Saati*</label>
								<?php
								$parcala = explode(":", $ilani_oku["ihale_saati"]);
								$ihale_s = $parcala[0] . ":" . $parcala[1];
								?>
								<input class="span12" onchange="tarih_sorgula2();" type="time" value="<?= $ihale_s ?>" name="ihale_saati" id="ihale_saati" required>

								<label for="IDofInput">PD Hizmet Bedeli</label>
								<?php
								if ($ilani_oku['pd_hizmet'] == "" || $ilani_oku['pd_hizmet'] <= 0) {
									$pd_yaz = "Otomatik Hesaplama";
								} else {
									$pd_yaz = $ilani_oku["pd_hizmet"];
								}
								?>
								<input class="span12" type="text" value="<?= $pd_yaz ?>" name="pd_hizmet" id="pd_hizmet">

								<label for="IDofInput">Otopark Giriş Tarihi</label>
								<input class="span12" type="date" value="<?= $ilani_oku['otopark_giris'] ?>" name="otopark_giris" id="otopark_giris">

								<label for="IDofInput">Otopark Ücreti</label>
								<input class="span12" type="text" value="<?= $ilani_oku['otopark_ucreti'] ?>" name="otopark_ucreti" id="otopark_ucreti">

								<label for="IDofInput">Çekici Ücreti</label>
								<input class="span12" type="text" value="<?= $ilani_oku['cekici_ucreti'] ?>" name="cekici_ucreti" id="cekici_ucreti">

								<label for="IDofInput">Dosya Masrafı</label>
								<input class="span12" type="text" value="<?= $ilani_oku['dosya_masrafi'] ?>" name="dosya_masrafi" id="dosya_masrafi">

								<label for="IDofInput">Link</label>
								<input class="span12" type="text" value="<?= $ilani_oku['link'] ?>" name="link" id="link">

								<label for="IDofInput">Kilometre</label>
								<input class="span12" type="text" value="<?= $ilani_oku['kilometre'] ?>" onkeypress="return isNumberKey(event)" name="kilometre" id="kilometre">

								<label for="IDofInput">Adres</label>
								<textarea name="adres" class="span12" rows="5"><?= $ilani_oku['adres'] ?></textarea>

								

								<label for="IDofInput">Araç Türü</label>
								<select class="span12" name="arac_turu" id="arac_turu">
									<option <?php if ($ilani_oku['arac_durumu'] == "") {
												echo "selected";
											} ?> value="">Seçiniz</option>
									<option <?php if ($ilani_oku['arac_durumu'] == 1) {
												echo "selected";
											} ?> value="1">Kazalı (En Ufak Bir Onarım Görmemiş)</option>
									<option <?php if ($ilani_oku['arac_durumu'] == 2) {
												echo "selected";
											} ?> value="2">Kazalı (Hafif onarımlar yapılmış halk ağzıyla makyajlı)</option>
									<option <?php if ($ilani_oku['arac_durumu'] == 3) {
												echo "selected";
											} ?> value="3">İkinci El (Pert Kayıtlı)</option>
									<option <?php if ($ilani_oku['arac_durumu'] == 4) {
												echo "selected";
											} ?> value="4">İkinci El (Pert Kayıtsız)</option>

								</select>
								<!--<label for="IDofInput">Resim</label>
            <input class="span12" type="file" class="span12" name="resim[]" multiple>-->
							</div>
						</div>
						<?php
						$ekleyen_cek = mysql_query("SELECT * FROM yapilan_is WHERE yaptigi = 1 AND ilan_id = '" . $gelen_id . "'");
						$ekleyen_say = mysql_num_rows($ekleyen_cek);
						$ekleyen_oku = mysql_fetch_assoc($ekleyen_cek);
						$ekleyen_id = $ekleyen_oku['admin_id'];

						$ekleyen_bul = mysql_query("select * from kullanicilar where id = '" . $ekleyen_id . "'");
						$ekleyen_yaz = mysql_fetch_assoc($ekleyen_bul);
						if ($ekleyen_say != 0) {
							$ekleyen = $ekleyen_yaz['adi'] . " " . $ekleyen_yaz['soyadi'];
							$ekleme_tarihi = date("d-m-Y H:i:s", strtotime($ekleyen_oku['ekleme_zamani']));
						} else {
							$ekleyen_uye_cek = mysql_query("select * from user where user_token = '" . $ilani_oku['ihale_sahibi'] . "'");
							if (mysql_num_rows($ekleyen_uye_cek) != "") {
								$eklyen_uye_oku = mysql_fetch_object($ekleyen_uye_cek);
								$ekleyen = $eklyen_uye_oku->ad . " " . $eklyen_uye_oku->soyad;
							} else {
								$ekleyen_k_uye_cek = mysql_query("select * from user where kurumsal_user_token = '" . $ilani_oku["ihale_sahibi"] . "'");
								$ekleyen_k_uye_oku = mysql_fetch_object($ekleyen_k_uye_cek);
								$ekleyen = $eklyen_uye_oku->unvan;
							}
							//$ekleyen = "Kullanıcı tarafından eklenen ilan";
							$ekleme_tarihi = date("d-m-Y H:i:s", strtotime($ilani_oku['eklenme_zamani']));
						}
						?>
						<div class="row-fluid">
							<label for="IDofInput">Uyarı Notu</label>
							<textarea style="min-height:200px !important" class="span12" name="uyari_notu" id="uyari_notu"><?= $ilani_oku['uyari_notu'] ?></textarea>
							<label for="IDofInput">Hasar Bilgileri</label>
							<textarea class="span12" name="hasar_bilgileri" id="hasar_bilgileri"><?= $ilani_oku['hasar_bilgileri'] ?></textarea>
							<label for="IDofInput">Notlar</label>
							<textarea class="span12" name="notlar" id="notlar"><?= $ilani_oku['notlar'] ?></textarea>
							<label for="IDofInput">Donanımlar</label>
							<textarea class="span12" name="donanimlar" id="donanimlar"><?= $ilani_oku['donanimlar'] ?></textarea>
							<label class="b-label">
								<label for="IDofInput">Vitrin</label>
								<input class="span12" type="checkbox" <?php if ($ilani_oku['vitrin'] == 'on') echo "checked='checked'"; ?>name="vitrin">
							</label>
							<label for="IDofInput">Yayında</label>
							<input class="span12 chec" type="checkbox" <?php if ($ilani_oku['durum'] == 1) echo "checked='checked'"; ?> value="1" style="opacity:1!important; z-index:999;margin-top:-3px;" id="yayinda" name="yayinda">
							<label for="IDofInput">İlanı Ekleyen</label>
							<input type="text" name="ilani_ekleyen" readonly class="span12" value="<?= $ekleyen ?>">
							<label for="IDofInput">Ekleme Zamanı</label>
							<input type="datetime" name="ekleme_zamani" readonly class="span12" value="<?= $ekleme_tarihi ?>">
						</div>
						<div class="form-actions">
							<button type="submit" name="guncellemeyi" class="btn blue" <?= $aktiflik ?> value="Kaydet">Kaydet</button>
							<!-- <input type="submit" name="guncellemeyi" class="btn blue" <?= $aktiflik ?> value="Kaydet"> -->
						</div>
				</form>
			</div>
			<?php
				$ilan_resimleri_cek = mysql_query("SELECT * FROM ilan_resimler WHERE ilan_id = '" . $ilani_oku['id'] . "'");
			?>
			<div class="tab-pane" id="arac_fotograflari">
				<form method="POST" id="form" name="form" enctype="multipart/form-data">
					<input type="hidden" name="action" value="ilan_resim_ekle" />
					<div class="row-fluid" style="margin-right: 2% !important; margin-left: 2% !important; width:96% !important;">
						<input type="button" class="btn" <?= $aktiflik ?> onclick="butun_resim_sil(<?= $ilani_oku['id'] ?>)" value="Bütün Resimleri Sil" style="background-color: rgb(251,57,122); color:white;">
						<div class="form-group">
							<br/>
							<text>Dosyaları seçmek için aaşağıdaki alana tıklayabilir veya dosyaları alanın içine sürükleyebilirsiniz.</text>
							<input onchange="ilan_resim_yukle(<?= re('id') ?>)" id="file_input" name="resim[]" type="file" multiple>
						</div>
						<div class="row-fluid" style="margin-left:1px;">
							<ul id="kayitli_resimler" class="thumbnails">
								<?php while ($resim_oku = mysql_fetch_array($ilan_resimleri_cek)) {
									$resim = "../images/" . $resim_oku['resim']; ?>
									<li id="ilan_resmi_<?= $resim_oku['id'] ?>" style="margin-left:5px;margin-top:10px;" class="span4">
										<a href="#" class="thumbnail">
											<img src="<?= $resim ?>" style="height:100px;">
										</a><br />
										<a style="display: <?= $gorunme ?>;" href="#" onclick="resim_sil(<?= $resim_oku['id'] ?>)" class="btn red">Sil</a>
									</li>
								<?php } ?>
							</ul>
						</div>
					</div>
				</form>
			</div>
			<div class="tab-pane" id="statu_bilgileri">
				<?php if (!in_array(3, $yetki_parcala)) {
							echo "Statü tanımlama yetkiniz yoktur";
						} else { ?>
					<form method="POST" id="formstatu" name="formstatu" enctype="multipart/form-data">
						<?php
							$teklif_cek = mysql_query("SELECT * FROM teklifler WHERE ilan_id = '" . $gelen_id . "'  and  durum=1 GROUP BY uye_id ORDER BY teklif_zamani DESC");
							$teklif_cek2 = mysql_query("SELECT * FROM teklifler WHERE ilan_id = '" . $gelen_id . "' and durum=1  GROUP BY uye_id ORDER BY teklif_zamani DESC");
							$teklif_cek3 = mysql_query("SELECT * FROM teklifler WHERE ilan_id = '" . $gelen_id . "' and durum=1  GROUP BY uye_id ORDER BY teklif_zamani DESC");
						?>
						<input type="hidden" name="action" value="statu_guncelle" />
						<input type="hidden" name="ilan_id" id="ilan_id" value="<?= $gelen_id ?>" />
						<?php
							$ilan_statu_cek = mysql_query("select * from kazanilan_ilanlar where ilan_id='" . $gelen_id . "'");
							$ilan_statu_oku = mysql_fetch_object($ilan_statu_cek);
							$statu_uye_id = $ilan_statu_oku->uye_id;
							$ilan_secim_turu =  $ilan_statu_oku->secim_turu;
							$statu_kazandigi_tutar =  $ilan_statu_oku->kazanilan_teklif;

							$kazanan_uye_cek = mysql_query("select * from user where id='" . $statu_uye_id . "'");
							$kazanan_uye_oku = mysql_fetch_assoc($kazanan_uye_cek);
							$kazanan_uye_ad = $kazanan_uye_oku["ad"];

							$statu_mtv = $ilan_statu_oku->mtv;
							$statu_mtv_not = $ilan_statu_oku->mtv_not;

							$statu_aciklama = $ilan_statu_oku->aciklama;
							$statu_otomatik_mesaj = $ilan_statu_oku->otomatik_mesaj;
							$statu_son_odeme_tarihi = $ilan_statu_oku->son_odeme_tarihi;

							$statu_durum = $ilan_statu_oku->durum;

							if ($statu_durum != "") {
								$statu_parca_1 = $ilan_statu_oku->parca_1 . "₺";
								$statu_parca_1_not = $ilan_statu_oku->parca_1_not;
								$statu_parca_2 = $ilan_statu_oku->parca_2 . "₺";
								$statu_parca_2_not = $ilan_statu_oku->parca_2_not;
								$statu_parca_3 = $ilan_statu_oku->parca_3 . "₺";
								$statu_parca_3_not = $ilan_statu_oku->parca_3_not;
							} else {
								$statu_parca_1 = "";
								$statu_parca_1_not = "";
								$statu_parca_2 = "";
								$statu_parca_2_not = "";
								$statu_parca_3 = "";
								$statu_parca_3_not = "";
							}
							/*
							if (!empty($statu_uye_id)) {
								// $statu_noter_takipci_gideri = $ilan_statu_oku->noter_takipci_gideri;
								// $noter = $statu_noter_takipci_gideri;
								$noter_cek = mysql_query("select * from odeme_mesaji");
								$noter_oku = mysql_fetch_assoc($noter_cek);
								$statu_noter_takipci_gideri = $noter_oku["noter_takipci_gideri"];
								$noter = $noter_oku["noter_takipci_gideri"];
							} else {
								if ($ilani_oku['profil'] == "Hurda Belgeli") {
									$statu_noter_takipci_gideri = 0;
									$noter = "Araç hurda belgeli olduğu için noter devri esnasında hesaplanacak.(Toplam tutara dahil edilmedi)";
								} else {
									$noter_cek = mysql_query("select * from odeme_mesaji");
									$noter_oku = mysql_fetch_assoc($noter_cek);
									$statu_noter_takipci_gideri = $noter_oku["noter_takipci_gideri"];
									$noter = $noter_oku["noter_takipci_gideri"];
								}
							}
							*/

							if ($ilani_oku['profil'] == "Hurda Belgeli") {
								$statu_noter_takipci_gideri = 0;
								$noter = "Araç hurda belgeli olduğu için noter devri esnasında hesaplanacak.(Toplam tutara dahil edilmedi)";
							} else {
								$noter_cek = mysql_query("select * from odeme_mesaji");
								$noter_oku = mysql_fetch_assoc($noter_cek);
								$statu_noter_takipci_gideri = $noter_oku["noter_takipci_gideri"];
								$noter = $noter_oku["noter_takipci_gideri"];
							}

							if ($ilan_secim_turu == "0") {
								$teklif_secim = "selected";
								$uye_secim = "";
							} else {
								$teklif_secim = "";
								$uye_secim = "selected";
							}
							if (!empty($statu_uye_id) && $statu_uye_id != 0) {
								$kazanan_text = "<text style='color: #fff;background-color: #ff8100;padding: 15px 20px;width: calc(100% / 3);font-size: 17px;display: block;'>KAZANAN: <b>" . $kazanan_uye_ad . "</b> TEKLİFİ: <b>" . money($statu_kazandigi_tutar) . "₺</b></text>";
								$kazanan_teklif = $statu_kazandigi_tutar;
								$statu_pd_hizmet = $ilan_statu_oku->pd_hizmet;
								$statu_dosya_masrafi = $ilan_statu_oku->dosya_masrafi;
							} else {
								/*
								if ($dosya_masrafi > 0) {
									$statu_dosya_masrafi = $dosya_masrafi;
								} else {
									$statu_dosya_masrafi = 0;
								}
								*/
								$statu_dosya_masrafi=$dosya_masrafi;
								while ($teklif_oku3 = mysql_fetch_array($teklif_cek3)) {
									$teklif_veren = $teklif_oku3['uye_id'];
									$uye_bul = mysql_query("SELECT * FROM user WHERE id = '" . $teklif_veren . "' LIMIT 1");
									$uye_yaz = mysql_fetch_array($uye_bul);
									$uye_adi = $uye_yaz['ad'];
									$t_getir3 = mysql_query("SELECT * FROM teklifler WHERE durum=1 and ilan_id = '" . $gelen_id . "' and uye_id='" . $teklif_veren . "' order by teklif_zamani desc limit 1");
									$t_oku3 = mysql_fetch_array($t_getir3);
									$teklif_id = $t_oku3["id"];
									if ($t_oku3["teklif"] == $max_teklif) {
										$kazanan_text = "<text style='color: #fff;background-color: #ff8100;padding: 15px 20px;width: calc(100% / 3);font-size: 17px;display: block;'>KAZANAN: <b>" . $uye_adi . "</b> TEKLİFİ: <b>" . money($t_oku3["teklif"]) . "₺</b></text>";
										$kazanan_teklif = $t_oku3["teklif"];
										$statu_pd_hizmet = $t_oku3["hizmet_bedeli"];
									}
								}
							}
							if ($statu_durum == "") {
								$statu_toplam_tutar = (int) $kazanan_teklif + (int) $statu_dosya_masrafi + (int) $statu_pd_hizmet + (int) $statu_noter_takipci_gideri;;
								$parcalar_style = "display:none";
								$statu_odeme_bildirimi_pdf = "#";
								$statu_odeme_bildirimi_pdf_adi = "Henüz pdf eklenmedi";
							} else if ($statu_durum == "1") {
								//$statu_toplam_tutar=(int) $statu_kazandigi_tutar+(int) $statu_dosya_masrafi+(int) $statu_pd_hizmet+(int) $mtv+(int) $statu_noter_takipci_gideri;
								$statu_toplam_tutar = (int) $statu_kazandigi_tutar + (int) $statu_dosya_masrafi + (int) $statu_pd_hizmet + (int) $statu_noter_takipci_gideri;
								$parcalar_style = "display:block";
								$statu_odeme_bildirimi_pdf = $system_base_url . "/images/pdf/" . $ilan_statu_oku->odeme_bildirimi; //system_base_url ayar.phpde tanımlandı
								$statu_odeme_bildirimi_pdf_adi = $ilan_statu_oku->odeme_bildirimi; //system_base_url ayar.phpde tanımlandı
							} else {
								$parcalar_style = "display:none";
								$statu_toplam_tutar = (int) $statu_kazandigi_tutar + (int) $statu_dosya_masrafi + (int) $statu_pd_hizmet + (int) $statu_noter_takipci_gideri;
								$statu_odeme_bildirimi_pdf = "#";
								$statu_odeme_bildirimi_pdf_adi = "Henüz pdf eklenmedi";
							}
							if($ilan_statu_oku->uye_id == 0){
								$kazanan_text = "<text style='color: #fff;background-color: #ff8100;padding: 15px 20px;width: calc(100% / 3);font-size: 17px;display: block;'>KAZANAN: <b>Henüz Atanmamış</b></text>";
							}
							if($ilan_statu_oku->odeme_bildirimi == ""){
								$statu_odeme_bildirimi_pdf_adi = "Henüz pdf eklenmedi";
							}else{
								$statu_odeme_bildirimi_pdf_adi = $ilan_statu_oku->odeme_bildirimi; //system_base_url ayar.phpde tanımlandı
							}
						?>
						<?= $kazanan_text ?>
						<div style="margin-top:2%;" class="row-fluid">
							<div class="span6">
								<div class="row-fluid">
									<div class="span6">
										<label for="IDofInput">TEKLİFLER</label>
										<select onchange="komisyon_kontrol();statu_bilgileri_cek();" name="teklifler" id="teklifler" class="span12">
											<option value="">Seçiniz</option>
											<?php
											$teklif_array = array();
											while ($teklif_oku2 = mysql_fetch_array($teklif_cek2)) {
												if ($teklif_oku2["uye_id"] != '283') {
													$teklif_veren = $teklif_oku2['uye_id'];
													$uye_bul = mysql_query("SELECT * FROM user WHERE id = '" . $teklif_veren . "' LIMIT 1");
													$uye_yaz = mysql_fetch_array($uye_bul);
													if($uye_yaz["user_token"] != ""){
														$uye_adi = $uye_yaz['ad'];
													}else{
														$uye_adi = $uye_yaz['unvan'];
													}
													
													$t_getir2 = mysql_query("SELECT * FROM teklifler WHERE  durum=1 and ilan_id = '" . $gelen_id . "' and uye_id='" . $teklif_oku2["uye_id"] . "' order by teklif_zamani desc limit 1");
													$t_oku2 = mysql_fetch_array($t_getir2);
													$teklif_id = $t_oku2["id"];

													if (!empty($statu_uye_id)) {
														if ($t_oku2["teklif"] == $statu_kazandigi_tutar) {
															array_push($teklif_array, $teklif_id); ?>
															<option <?= $teklif_secim ?> value="<?= $teklif_id ?>"><?= $uye_adi ?> - <?= money($t_oku2["teklif"]) ?>₺</option>
														<?php }
													} else {
														if ($t_oku2["teklif"] == $max_teklif) {
															array_push($teklif_array, $teklif_id); ?>
															<option <?= $teklif_secim ?> value="<?= $teklif_id ?>"><?= $uye_adi ?> - <?= money($t_oku2["teklif"]) ?>₺</option>
														<?php }
													}
												}
											}
											while ($teklif_oku = mysql_fetch_array($teklif_cek)) {
												if ($teklif_oku["uye_id"] != '283') {
													$teklif_veren = $teklif_oku['uye_id'];
													$uye_bul = mysql_query("SELECT * FROM user WHERE id = '" . $teklif_veren . "' LIMIT 1");
													$uye_yaz = mysql_fetch_array($uye_bul);
													$uye_adi = $uye_yaz['ad'];
													$t_getir = mysql_query("SELECT * FROM teklifler WHERE  durum=1 and ilan_id = '" . $gelen_id . "' and uye_id='" . $teklif_oku["uye_id"] . "' order by teklif_zamani desc limit 1");
													$t_oku = mysql_fetch_array($t_getir);
													$teklif_id = $t_oku["id"];
													if ($t_oku["teklif"] != $max_teklif && !in_array($teklif_id, $teklif_array)) { ?>
														<option value="<?= $teklif_id ?>"><?= $uye_adi ?> - <?= money($t_oku["teklif"]) ?>₺</option>
											<?php }
												}
											}
											?>
										</select>
									</div>
								</div>
								<div class="row-fluid">
									<div class="span6">
										<label for="IDofInput">Serbest Seçim</label>
										<?php $gold_bul = mysql_query("select * from user"); ?>
										<input id="srch" type="text" name="search" placeholder="Üye ara..." class="span12">
										<select onchange="statu_bilgileri_cek();" name="serbest_secim" id="slct" class="span12">
											<option value="">Seçiniz</option>
											<?php while ($gold_yaz = mysql_fetch_array($gold_bul)) {
												$gold_unvan = "Bireysel / ";
												if ($gold_yaz["unvan"] != "") {
													$gold_unvan = $gold_yaz["unvan"] . " / ";
												}
												if ($statu_uye_id == $gold_yaz['id']) { ?>
													<option <?= $uye_secim ?> value="<?= $gold_yaz['id'] ?>"> <?= $gold_yaz['id'] ?> ID - <?= $gold_unvan . $gold_yaz['ad'] ?></option>
												<?php } else { ?>
													<option value="<?= $gold_yaz['id'] ?>"><?= $gold_yaz['id'] ?> ID -<?= $gold_unvan . $gold_yaz['ad'] ?></option>
											<?php }
											} ?>
										</select>
									</div>
									<!-- üyeler selectboxunda arama yapma scripti -->
									<script>
										function bind_select_search(srch, select, arr_name) {
											window[arr_name] = []
											$(select + " option").each(function() {
												window[arr_name][this.value] = this.text
											})
											$(srch).keyup(function(e) {
												text = $(srch).val()
												if (text != '' || e.keyCode == 8) {
													arr = window[arr_name]
													$(select + " option").remove()
													tmp = ''
													for (key in arr) {
														option_text = arr[key].toLowerCase()
														if (option_text.search(text.toLowerCase()) > -1) {
															tmp += '<option value="' + key + '">' + arr[key] + '</option>'
														}
													}
													$(select).append(tmp)
												}
											})
											$(srch).keydown(function(e) {
												if (e.keyCode == 8) // Backspace
													$(srch).trigger('keyup')
											})
										}
										$(document).ready(function() {
											bind_select_search('#srch', '#slct', 'options')
										})
									</script>
									<div class="span6">
										<label for="IDofInput">Kazandığı Fiyat</label>
										<input onchange="komisyon_kontrol();toplam_tutar_guncelle();" value="<?= $kazanan_teklif ?>" type="text" name="kazandigi_tutar" id="kazandigi_tutar" class="span12">
									</div>
								</div>
								<div class="row-fluid">
									<div class="span6">
										<label for="IDofInput">Statü Bilgileri</label>
										<select onchange="tarih_getir();statu_bilgileri_cek();toplam_tutar_guncelle();" name="statu_bilgileri" id="statu_bilgisi" class="span12">
											<option <?php if ($statu_durum == "") {
														echo "selected";
													} ?> value="">Seçiniz</option>
											<option <?php if ($statu_durum == 2) {
														echo "selected";
													} ?> value="2">Son İşlemde</option>
											<option <?php if ($statu_durum == 1) {
														echo "selected";
													} ?> value="1">Ödeme Bekliyor</option>
											<option <?php if ($statu_durum == 0) {
														echo "selected";
													} ?> value="0">Onay Bekliyor</option>
											<option <?php if ($statu_durum == 3) {
														echo "selected";
													} ?> value="3">Satın Alınan</option>
											<option <?php if ($statu_durum == 4) {
														echo "selected";
													} ?> value="4">İptal Edildi</option>
										</select>
									</div>
									<div class="span6">
										<label for="IDofInput">Açıklama</label>
										<input type="text" name="aciklama" id="aciklama" value="<?= $statu_aciklama ?>" class="span12">
									</div>
								</div>
								<div class="row-fluid">
									<div id="tarih_div" class="span6">
										<?php
										$gun = date('Y-m-d');
										$weekDay = date('w', strtotime($date));
										if ($weekDay == 0 || $weekDay == 6) {
											$hesaplanmis_tarih = date('Y-m-d', strtotime('3 weekdays'));
										} else {
											$hesaplanmis_tarih = date('Y-m-d', strtotime('2 weekdays'));
										}
										/*
											$gun=3;
											$gun_ekle='+'.$gun.' days';
											$hesaplanmis_tarih=date('Y-m-d', strtotime($gun_ekle));
											$str=(string) date('D',strtotime($gun_ekle));
											$array=array("Sat","Sun");
											$sayi=0;
											$durum=true;
											while($durum){
												if(in_array($str,$array)){
													$gun=$gun+1;
													$gun_ekle='+'.$gun.' days';
													$hesaplanmis_tarih=date('Y-m-d',strtotime($gun_ekle));
													$str=(string) date('D',strtotime($gun_ekle));
												}else{
													$durum=false;
												}
											}
										*/
										?>
									</div>
								</div>
							</div>
							<div class="span6">
								<div class="row-fluid">
									<label for="IDofInput">Risk Bilgileri</label>
									<div class="row-fluid">
										<div class="span6">
											Onay Bekleyenler <br />
											Ödeme Bekleyenler <br />
											Son İşlemdekiler <br />
											Satılanlar <br />
											İptal edilenler <br />
										</div>
										<?php
										$statu_kazanan_onay_bekleyen = mysql_query("select * from kazanilan_ilanlar where durum=0 and uye_id='" . $statu_uye_id . "' ");
										$statu_kazanan_onay_bekleyen_say = mysql_num_rows($statu_kazanan_onay_bekleyen);
										$statu_kazanan_odeme_bekleyen = mysql_query("select * from kazanilan_ilanlar where durum=1 and uye_id='" . $statu_uye_id . "' ");
										$statu_kazanan_odeme_bekleyen_say = mysql_num_rows($statu_kazanan_odeme_bekleyen);
										$statu_kazanan_son_islem = mysql_query("select * from kazanilan_ilanlar where durum=2 and uye_id='" . $statu_uye_id . "' ");
										$statu_kazanan_son_islem_say = mysql_num_rows($statu_kazanan_son_islem);
										$statu_kazanan_satilanlar = mysql_query("select * from kazanilan_ilanlar where durum=3 and uye_id='" . $statu_uye_id . "' ");
										$statu_kazanan_satilanlar_say = mysql_num_rows($statu_kazanan_satilanlar);
										$statu_kazanan_iptal_edilenler = mysql_query("select * from kazanilan_ilanlar where durum=4 and uye_id='" . $statu_uye_id . "' ");
										$statu_kazanan_iptal_edilenler_say = mysql_num_rows($statu_kazanan_iptal_edilenler);
										?>
										<div class="span6">
											<span id="onay_bekleyenler"><?= $statu_kazanan_onay_bekleyen_say ?></span> <br />
											<span id="odeme_bekleyenler"><?= $statu_kazanan_odeme_bekleyen_say ?></span> <br />
											<span id="son_islemdekiler"><?= $statu_kazanan_son_islem_say ?></span> <br />
											<span id="satilanlar"><?= $statu_kazanan_satilanlar_say ?></span><br />
											<span id="iptal_edilenler"><?= $statu_kazanan_iptal_edilenler_say ?></span> <br />
										</div>
									</div>
									<div class="row-fluid">
										<?php if ($statu_kazanan_onay_bekleyen_say >= 3 || $statu_kazanan_odeme_bekleyen_say >= 1) { ?>
											<input type="checkbox" id="riske_gore_teklif" checked name="riske_gore_teklif" class="deneme"> Risk ölçümüne göre teklif verme engeli
										<?php } else { ?>
											<input type="checkbox" id="riske_gore_teklif" name="riske_gore_teklif" class="deneme"> Risk ölçümüne göre teklif verme engeli
										<?php } ?>
									</div>
									<div class="row-fluid" style="margin-top: 1%;">
										<label for="IDofInput">Otomatik Mesaj</label>
										<?php
										if ($statu_otomatik_mesaj != "") {
											$sms_mesaj = $statu_otomatik_mesaj;
										} else {
											$sms_mesaj = "";
										}
										?>
										<textarea style="height:75px;" id="otomatik_mesaj" name="otomatik_mesaj" class="span12" placeholder="Otomatik mesaj"><?= $sms_mesaj ?></textarea>
									</div>
									<div class="row-fluid" style="margin-top:1%;">
										<input type="button" <?= $aktiflik ?> class="btn blue" name="smsi" onclick="tekrar_sms_gonder();" value="Tekrar Sms Gönder">
									</div>
								</div>
							</div>
						</div>
						<div style="margin-top:5%;" class="row-fluid">
							<div style="<?= $parcalar_style ?>" id="parcalar">
								<div style="background-color: #cecece; padding: 1%;" class="span5">
									<div class="row-fluid">
										<div class="span3">
											<label for="IdofInput"></label>
										</div>
										<div class="span8">
											<div class="row-fluid">
												<div class="span6">
													<text style="color:#fff;font-size: 17px;">RAKAMLARI YAZINIZ</text>
												</div>
												<div class="span6">
													<text style="color:#fff;font-size: 17px;">NOTLAR</text>
												</div>
											</div>
										</div>
										<div class="span1">
										</div>
									</div>
									<div class="row-fluid">
										<div class="span3">
											<label style="color:#fff;;font-size: 18px;" for="IdofInput">PARÇA 1</label>
										</div>
										<div class="span8">
											<div class="row-fluid">
												<div class="span6">
													<input type="text" onchange="birlestir();toplam_tutar_guncelle();" value="<?= $statu_parca_1 ?>" name="parca_1" id="parca_1" onkeypress="return isNumberKey(event)" class="span12">
												</div>
												<div class="span6">
													<input type="text" value="<?= $statu_parca_1_not ?>" name="parca_1_not" id="parca_1_not" class="span12">
												</div>
											</div>
										</div>
										<div style="margin-top:5px" class="span1">
											<i style="font-size:18px;" onclick="parca_kaydet(<?= $gelen_id ?>,1)" class="fas fa-save"></i>
										</div>
									</div>
									<div class="row-fluid">
										<div class="span3">
											<label style="color:#fff;font-size: 18px;" for="IdofInput">PARÇA 2</label>
										</div>
										<div class="span8">
											<div class="row-fluid">
												<div class="span6">
													<input type="text" onchange="birlestir2();toplam_tutar_guncelle();" value="<?= $statu_parca_2 ?>" name="parca_2" id="parca_2" onkeypress="return isNumberKey(event)" class="span12">
												</div>
												<div class="span6">
													<input type="text" value="<?= $statu_parca_2_not ?>" name="parca_2_not" id="parca_2_not" class="span12">
												</div>
											</div>
										</div>
										<div style="margin-top:5px" class="span1">
											<i style="font-size:18px;" onclick="parca_kaydet(<?= $gelen_id ?>,2)" class="fas fa-save"></i>
										</div>
									</div>
									<div class="row-fluid">
										<div class="span3">
											<label style="color:#fff;font-size: 18px;" for="IdofInput">PARÇA 3</label>
										</div>
										<div class="span8">
											<div class="row-fluid">
												<div class="span6">
													<input type="text" onchange="birlestir3();toplam_tutar_guncelle();" value="<?= $statu_parca_3 ?>" name="parca_3" id="parca_3" onkeypress="return isNumberKey(event)" class="span12">
												</div>
												<div class="span6">
													<input type="text" value="<?= $statu_parca_3_not ?>" name="parca_3_not" id="parca_3_not" class="span12">
												</div>
											</div>
										</div>
										<div style="margin-top:5px" class="span1">
											<i style="font-size:18px;" onclick="parca_kaydet(<?= $gelen_id ?>,3)" class="fas fa-save"></i>
										</div>
									</div>
									<div class="row-fluid">
										<div class="span3">
											<label style="color:#fff;font-size: 18px;" for="IdofInput">MTV</label>
										</div>
										<div class="span8">
											<div class="row-fluid">
												<div class="span6">
													<?php if ($statu_mtv > 0) { ?>
														<input type="text" onchange="birlestir4();toplam_tutar_guncelle();" name="mtv" id="mtv" value="<?= $statu_mtv ?>" onkeypress="return isNumberKey(event)" class="span12">
													<?php } else { ?>
														<input type="text" onchange="birlestir4();toplam_tutar_guncelle();" name="mtv" id="mtv" value="" onkeypress="return isNumberKey(event)" class="span12">
													<?php } ?>
												</div>
												<div class="span6">
													<?php if ($statu_mtv_not != "") { ?>
														<input type="text" value="<?= $statu_mtv_not ?>" name="mtv_not" id="mtv_not" class="span12">
													<?php } else { ?>
														<input type="text" value="" name="mtv_not" id="mtv_not" class="span12">
													<?php } ?>
												</div>
											</div>
										</div>
										<div style="margin-top:5px" class="span1">
											<i onclick="mtv_kaydet(<?= $gelen_id ?>);" style="font-size:18px;" class="fas fa-save"></i>
										</div>
									</div>
								</div>
							</div>
							<div style="border:1px solid #cecece;" class="span4">
								<div style="background-color:#cecece" class="row-fluid">
									<div class="span12">
										<b style="font-size: 18px;padding: 5px 5px;color:#fff;">ÖDEME TABLOSU</b>
									</div>
								</div>
								<div style="padding: 1px 5px;font-size: 18px;" class="row-fluid">
									<div class="span12">
										<text style="color:grey;">Kazanılan Teklif: <b id="kazanilan_teklif_text" style="color:#000;"><?= money($kazanan_teklif) . "₺" ?></b></text>
									</div>
								</div>
								<div style="padding: 1px 5px;font-size: 18px;" class="row-fluid">
									<div class="span12">
										<text style="color:grey;">Dosya Masrafı: <b id="dosya_masrafi_text" style="color:#000;"><?= money($statu_dosya_masrafi) . "₺" ?></b></text>
										<input type="hidden" id="dosya_masrafi" value="<?= $statu_dosya_masrafi ?>" readonly>
									</div>
								</div>
								<div style="padding: 1px 5px;font-size: 18px;" class="row-fluid">
									<div class="span12">
										<text style="color:grey;">PD Hizmet Bedeli: <b id="pd_hizmet_text" style="color:#000;"><?= money($statu_pd_hizmet) . "₺" ?></b></text>
										<input type="hidden" value="<?= $statu_pd_hizmet ?>" name="pd_hizmet" onchange="komisyon_kontrol();" id="pd_hizmet_hesaplı" readonly />
									</div>
								</div>
								<div style="padding: 1px 5px;font-size: 18px;" class="row-fluid">
									<div class="span12">
										<text style="color:grey;">Noter&Takipçi Gideri: <b id="noter_text" style="color:#000;"><?= money($statu_noter_takipci_gideri) . "₺" ?></b></text>
										<input type="hidden" name="noter_takipci" value="<?= $statu_noter_takipci_gideri ?>" id="noter" readonly />
									</div>
								</div>
								<div style="margin-top:3%;padding: 1px 5px;font-size: 18px;" class="row-fluid">
									<div class="span12">
										<text style="color:grey;">Toplam: <b id="toplam_odenecek_tutar_text" style="color:#000;"><?= money($statu_toplam_tutar) . "₺" ?></b></text>
										<input type="hidden" id="toplam_odenecek_tutar" value="<?= $statu_toplam_tutar ?>" readonly>
									</div>
								</div>
							</div>
							<div style="<?= $parcalar_style ?>" id="parcalar2">
								<div style="margin-top:110px;padding: 0px 15px;" class="span3">
									<div class="row-fluid">
										<div class="span12">
											<a href="<?= $system_base_url . "/odeme_bildirimi_pdf.php?ilan_id=" . $gelen_id ?>" target="_blank">
												<text id="odeme_bildirimi_pdf"><?= $statu_odeme_bildirimi_pdf_adi ?></text>
											</a>
										</div>
									</div>
									<div class="row-fluid">
										<div class="span12">
											<text id="link_kopyala_text" onclick="link_kopyala();" style="cursor:pointer">Linki panoya kopyala</text>
											<input aria-hidden="true" type="text" class="offscreen" id="pdf_link_kopyala" value="<?= $system_base_url . "/odeme_bildirimi_pdf.php?ilan_id=" . $gelen_id ?>" />
										</div>
									</div>
									<div class="row-fluid">
										<div class="span12">
											<input type="button" class="btn btn-primary" onclick="odeme_pdf_file_click();" name="odeme_bildirimi_yukle" value="ÖDEME BİLDİRİMİ YUKLE" />
											<input type="file" onchange="button_kontrol(<?= $gelen_id ?>)" hidden id="odeme_bildirimi_dosya" name="odeme_bildirimi_dosya" />
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="row-fluid">
							<button id="statu_kaydet" type="button" <?= $aktiflik ?> class="btn blue btn-block" name="statu_bilgilerini" onclick="statu_guncelle();" value="Kaydet">Kaydet</button>
							<!-- <input type="button" <?= $aktiflik ?>  class="btn blue btn-block" name="statu_bilgilerini" onclick="statu_guncelle();" value="Kaydet"> -->
						</div>
					</form>
				<?php } ?>
			</div>

			<div class="tab-pane" id="yuklenen_dosyalar">
				<?php
						$yuklenen_dosya_cek = mysql_query("SELECT * FROM ilan_notlari WHERE ilan_id = '" . $gelen_id . "' group by tarih");
						$sira = 1;
						$aktif_admin = mysql_query("select * from kullanicilar where id='" . $_SESSION["kid"] . "'");
						$aktif_admin_oku = mysql_fetch_object($aktif_admin);
						$aktif_admin_id = $aktif_admin_oku->id;
						$ilan_not_cek = mysql_query("select * from ilan_notlari where ilan_id = '" . $gelen_id . "' group by ilan_id,tarih order by tarih desc");
						while ($ilan_not_oku = mysql_fetch_object($ilan_not_cek)) {
							$not_gizlilik = $ilan_not_oku->gizlilik;
							if ($not_gizlilik == 0) {
								if ($admin_id == $ilan_not_oku->ekleyen) {
									$not = $ilan_not_oku->ilan_notu;
									$dosya = '<a style="width: 100%;text-align: center;" class="button btn-primary" id="dosya_' . $evrak_oku["id"] . '" href="../assets/' . $ilan_not_oku->dosya . '" download="../assets/' . $ilan_not_oku->dosya . '" >İndir</a>';
								} else {
									$not = "Sadece ekleyen admin görebilir";
									$dosya = "Sadece ekleyen admin görebilir";
								}
							} elseif ($not_gizlilik == 1) {

								$aktif_admin_yetkiler = $aktif_admin_oku->yetki;
								$parcala = explode("|", $aktif_admin_yetkiler);
								if (count($parcala) == 13) {
									$sinirsiz_yetki = true;
								} else {
									$sinirsiz_yetki = false;
								}
								if ($sinirsiz_yetki == true) {
									$not = $ilan_not_oku->ilan_notu;
									$dosya = '<a style="width: 100%;text-align: center;" class="button btn-primary" id="dosya_' . $evrak_oku["id"] . '" href="../assets/' . $ilan_not_oku->dosya . '" download="../assets/' . $ilan_not_oku->dosya . '" >İndir</a>';
								} else {
									$not = "Sadece yetkili adminler görebilir";
									$dosya = "Sadece yetkili adminler görebilir";
								}
							} elseif ($not_gizlilik == 2) {
								$not = $ilan_not_oku->ilan_notu;
								$dosya = '<a style="width: 100%;text-align: center;" class="button btn-primary" id="dosya_' . $evrak_oku["id"] . '" href="../assets/' . $ilan_not_oku->dosya . '" download="../assets/' . $ilan_not_oku->dosya . '" >İndir</a>';
							}


							$dosya_cek = mysql_query("select * from ilan_notlari where ilan_notu = '" . $ilan_not_oku->ilan_notu . "' and tarih = '" . $ilan_not_oku->tarih . "'");
							$dosya = "";
							$dosya_sayi = 0;
							$dosya_array = array();
							while ($dosya_oku = mysql_fetch_object($dosya_cek)) {
								if ($dosya_oku->gizlilik == 0) {
									if ($aktif_admin_id == $dosya_oku->ekleyen) {
										if ($dosya_oku->dosya == 1 || $dosya_oku->dosya == 0) {
											$dosya = '<p style="color:black" >Dosya Yok</p>';
										} else {
											$dosya_sayi += 1;
											$dosya .= '<p><a style="width: 100%;text-align: center;" class="button btn-primary" href="../assets/' . $dosya_oku->dosya . '" target="_blank"> Dosyayı Görüntüle</a>
											<a style="width: 100%;text-align: center;display: none;" class="button btn-primary" href="../assets/' . $dosya_oku->dosya . '" id="dosya_' . $dosya_oku->id . '" download> Dosyayı Görüntüle</a></p>';
											array_push($dosya_array, $dosya_oku->id);
										}
									} else {
										$dosya = '<p style="color:black">Sadece Ekleyen Admin Görebilir</p>';
									}
								} elseif ($dosya_oku->gizlilik == 1) {
									if ($sinirsiz_yetki == true) {
										if ($dosya_oku->dosya == 1 || $dosya_oku->dosya == 0) {
											$dosya = '<p style="color:black">Dosya Yok</p>';
										} else {
											$dosya_sayi += 1;
											$dosya .= '<p><a style="width: 100%;text-align: center;" class="button btn-primary" href="../assets/' . $dosya_oku->dosya . '" target="_blank"> Dosyayı Görüntüle</a>
											<a style="width: 100%;text-align: center;display: none;" class="button btn-primary" href="../assets/' . $dosya_oku->dosya . '" id="dosya_' . $dosya_oku->id . '" download> Dosyayı Görüntüle</a></p>';
											array_push($dosya_array, $dosya_oku->id);
										}
									} else {
										$dosya = '<p style="color:black">Yetkiniz Yetersiz</p>';
									}
								} elseif ($dosya_oku->gizlilik == 2) {
									if ($dosya_oku->dosya != 1 || $dosya_oku->dosya != 0) {
										$dosya_sayi += 1;
										$dosya .= '<p><a style="width: 100%;text-align: center;" class="button btn-primary" href="../assets/' . $dosya_oku->dosya . '" target="_blank"> Dosyayı Görüntüle</a>
										<a style="width: 100%;text-align: center;display: none;" class="button btn-primary" href="../assets/' . $dosya_oku->dosya . '" id="dosya_' . $dosya_oku->id . '" download> Dosyayı Görüntüle</a></p>';
										array_push($dosya_array, $dosya_oku->id);
									} else {
										$dosya = '<p style="color:black">Dosya Yok</p>';
									}
								}
							}
							// print_r($dosya_array);
							if ($dosya_sayi != 0) {
								$dosya_text = "";
								for ($i = 0; $i < count($dosya_array); $i++) {
									if ($i == 0) {
										$dosya_text .= $dosya_array[$i];
									} else {
										$dosya_text .= ',' . $dosya_array[$i];
									}
								}
								// foreach($dosya_array as $dosya){
								// 	$dosya_text .= $dosya."";
								// }
								$dosya .= '<p><button style="width:100%;text-align:center;"onclick="ilan_not_indir(\'' . $dosya_text . '\');" class="button btn-success">Tümünü İndir</button></p>';
							}


							$admin_cek = mysql_query("select * from kullanicilar where id = '" . $ilan_not_oku->ekleyen . "'");
							$admin_oku = mysql_fetch_assoc($admin_cek);
							$admin_adi = $admin_oku['adi'] . " " . $admin_oku['soyadi'];
							$ilan_notlari .= '<tr>
							<td>' . $sira++ . '</td>
							<td>' . date("d-m-Y H:i:s", strtotime($ilan_not_oku->tarih)) . '</td>
							<td>' . $admin_adi . '</td>
							<td>' . $not . '</td>
							<td>' . $dosya . '</td>
						</tr>';
						}
				?>
				<script>
					async function ilan_not_indir(ids) {
						var split = ids.split(",");
						var count = 0;
						for (var i = 0; i < split.length; i++) {
							document.getElementById("dosya_" + split[i]).click();
							if(++count >= 10){
								await pause(1000);
								count = 0;
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
				<table class="table table-bordered table-striped">
					<thead>
						<tr>
							<th> Sıra </th>
							<th> Ekleme Zamanı </th>
							<th> Ekleyen </th>
							<th> Not </th>
							<th> Dosya </th>
						</tr>
					</thead>
					<tbody>
						<?= $ilan_notlari ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>

	<?php


	?>
<?php } ?>

<?php  } else if (!empty($hizli_ekle_kategori)) { ?>


	<?php

	$kategori_cek = mysql_query("select * from hizli_ekle_detay where kategori_id='" . $hizli_ekle_kategori . "'");
	$kategori_oku = mysql_fetch_array($kategori_cek);
	if ($kategori_oku["hesaplama"] == "Standart") {
		$standart_select = "selected";
		$luks_select = "";
	}
	if ($kategori_oku["hesaplama"] == "Luks") {
		$standart_select = "";
		$luks_select = "selected";
	}
	$profil_select = "";
	$profil_select2 = "";
	$profil_select3 = "";
	$profil_select4 = "";
	$profil_select5 = "";
	if ($kategori_oku["profil"] == "Çekme Belgeli/Pert Kayıtlı") {
		$profil_select = "selected";
	} else if ($kategori_oku["profil"] == "Çekme Belgeli") {
		$profil_select2 = "selected";
	} else if ($kategori_oku["profil"] == "Hurda Belgeli") {
		$profil_select3 = "selected";
	} else if ($kategori_oku["profil"] == "Plakalı") {
		$profil_select4 = "selected";
	} else if ($kategori_oku["profil"] == "Diğer") {
		$profil_select5 = "selected";
	}


	?>
	<form method="post" id="form" name="form" enctype="multipart/form-data">
		<?php include('islemler/ilanlar/ilan_ekle.php'); ?>
		<input type="hidden" name="hizli_kategori_id" value="<?= $hizli_ekle_kategori ?>">
		<text style="color:red"><?= $uyari ?></text>
		<div class="row-fluid">
			<div class="span6">
				<label for="IDofInput">Plaka</label>
				<!-- <input type="text" class="span12" name="plaka" id="plaka" onchange="plaka_sorgu();" placeholder="01AA0000" onkeypress="return boslukEngelle()" pattern="[0-9]{2}[A-Za-z]{1,3}[0-9]{2,4}" oninvalid="this.setCustomValidity('LÜTFEN PLAKAYI DÜZGÜN GİRİN')" oninput="this.setCustomValidity('')" maxlength="8"  />  -->
				<input type="text" class="span12" name="plaka" id="plaka" onchange="plaka_sorgu();" placeholder="01AA0000" value="<?= $kategori_oku["plaka"] ?>" onkeypress="return boslukEngelle()" pattern="[0-9]{2}[A-Za-z]{1,3}[0-9]{2,4}" oninvalid="this.setCustomValidity('LÜTFEN PLAKAYI DÜZGÜN GİRİN')" oninput="this.setCustomValidity('')" maxlength="8" />

				<label for="IDofInput">Araç Kodu</label>
				<input type="text" class="span12" name="arac_kodu" value="<?= $kategori_oku["arac_kodu"] ?>" id="arac_kodu" onchange="arac_kodu_sorgu();" value="<?= $kategori_oku["arac_kodu"] ?>" onkeypress="return boslukEngelle()" />

				<label for="IDofInput">Hesaplama*</label>
				<select class="span12" name="hesaplama" id="hesaplama" required>
					<option <?= $stantdart_select ?> value="Standart">Standart</option>
					<option <?= $luks_select ?> value="Luks">Ticari</option>
				</select>
				<?php $sigorta_cek = mysql_query("SELECT * FROM sigorta_ozellikleri"); ?>
				<label for="IDofInput">Sigorta Şirketi*</label>
				<select class="span12" name="sigorta" id="sigorta" onchange="sigort()" required>
					<option value="">SEÇİNİZ</option>
					<?php while ($sigorta_oku = mysql_fetch_array($sigorta_cek)) { ?>

						<?php if ($kategori_oku["sigorta"] == $sigorta_oku["id"]) { ?>

							<option selected value="<?= $sigorta_oku['id'] ?>"><?= $sigorta_oku['sigorta_adi'] ?></option>
						<?php } else { ?>
							<option value="<?= $sigorta_oku['id'] ?>"><?= $sigorta_oku['sigorta_adi'] ?></option>
						<?php } ?>

					<?php } ?>
				</select>

				<label for="IDofInput">Marka*</label>
				<select class="span12" name="marka" id="marka" required>
					<option value="">SEÇİNİZ</option>
					<?php $marka_cek = mysql_query("SELECT * FROM marka order by marka_adi asc");
					while ($marka_oku = mysql_fetch_array($marka_cek)) { ?>

						<?php if ($kategori_oku["marka"] == $marka_oku["markaID"]) { ?>


							<option value="<?= $marka_oku['markaID'] ?>" selected style="text-transform: uppercase;"><?= mb_strtoupper(pre_up($marka_oku['marka_adi']), "utf-8") ?></option>
						<?php } else { ?>

							<option value="<?= $marka_oku['markaID'] ?>" style="text-transform: uppercase;"><?= mb_strtoupper(pre_up($marka_oku['marka_adi']), "utf-8") ?></option>
						<?php  } ?>


					<?php } ?>
				</select>

				<label for="IDofInput">Model*</label>
				<?php if ($kategori_oku["model"] != "") {			?>
					<select class="span12" name="model" id="model" required>
						<option value="">SEÇİNİZ</option>
						<?php
						$model_cek = mysql_query("select * from model where marka_id='" . $kategori_oku["marka"] . "'");
						while ($model_oku = mysql_fetch_array($model_cek)) {
							$select = "";

							if ($model_oku["model_adi"] == $kategori_oku["model"]) {
								$select = "selected";
							}
						?>
							<option <?= $select ?> value="<?= $model_oku["model_adi"] ?>"><?= mb_strtoupper(pre_up($model_oku['model_adi']), "utf-8") ?></option>
						<?php } ?>
					</select>
				<?php  } else if ($kategori_oku["marka"] != "") {  ?>
					<select class="span12" name="model" id="model" required>
						<option value="">SEÇİNİZ</option>
						<?php
						$model_cek = mysql_query("select * from model where marka_id='" . $kategori_oku["marka"] . "'");
						while ($model_oku = mysql_fetch_array($model_cek)) { ?>
							<option value="<?= $model_oku["model_adi"] ?>"><?= mb_strtoupper(pre_up($model_oku['model_adi']), "utf-8") ?></option>
						<?php } ?>
					</select>
				<?php  } else { ?>
					<select class="span12" name="model" id="model" disabled required>
					</select>
				<?php } ?>
				<label for="IDofInput">Tip</label>
				<input class="span12" type="text" value="<?= $kategori_oku["tip"] ?>" style="text-transform: uppercase;" name="tip" id="tip">

				<?php $anlik_yil = date("Y") ?>
				<label for="IDofInput">Model Yılı</label>
				<input class="span12" type="number" value="<?= $kategori_oku["model_yili"] ?>" onkeypress="return isNumberKey(event)" name="model_yili" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxLength="4" min="1950" max="<?= $anlik_yil; ?>" id="model_yili">

				<!-- <label for="IDofInput">Piyasa Değeri</label>
            <input class="span12" type="text" onkeypress="return isNumberKey(event)" name="piyasa_degeri" id="piyasa_degeri"  > -->

				<label for="IDofInput">TSRSB Değeri</label>
				<input class="span12" type="text" onkeypress="return isNumberKey(event)" value="<?= $kategori_oku["tsrsb_degeri"] ?>" name="tsrsb_degeri" id="tsrsb_degeri" placeholder="sadece rakam">

				<label for="IDofInput">Açılış Fiyatı</label>
				<input class="span12" type="text" onkeypress="return isNumberKey(event)" name="acilis_fiyati" value="<?= $kategori_oku["acilis_fiyati"] ?>" id="acilis_fiyati">

				<label for="IDofInput">Profil</label>

				<select class="span12" name="profil" id="profil">
					<option <?= $profil_select ?> value="Çekme Belgeli/Pert Kayıtlı">Çekme Belgeli/Pert Kayıtlı</option>
					<option <?= $profil_select2 ?> value="Çekme Belgeli">Çekme Belgeli</option>
					<option <?= $profil_select3 ?> value="Hurda Belgeli">Hurda Belgeli</option>
					<option <?= $profil_select4 ?> value="Plakalı">Plakalı</option>
					<option <?= $profil_select5 ?> value="Diğer">Diğer</option>
				</select>
			</div>
			<div class="span6">
				<label for="IDofInput">Şehir</label>
				<select class="span12" name="sehir" id="sehir">
					<option value="">Şehir seçin</option>
					<option value="0">Bilinmiyor</option>

					<?php while ($sehir_oku = mysql_fetch_array($sehir_cek)) { ?>

						<?php if ($kategori_oku["sehir"] == $sehir_oku["sehiradi"]) { ?>
							<option selected value="<?= $sehir_oku["sehirID"] ?>"><?= $sehir_oku["sehiradi"]; ?></option>
						<?php } else { ?>
							<option value="<?= $sehir_oku["sehirID"] ?>"><?= $sehir_oku["sehiradi"]; ?></option>
						<?php } ?>


					<?php } ?>

				</select>
				<label for="IDofInput">İhale Bitiş Tarihi*</label>
				<input class="span12" onfocusout="tarih_sorgula();" type="date" value="<?= $kategori_oku["ihale_tarihi"] ?>" name="ihale_tarihi" id="ihale_tarihi" required>
				<!--<input class="span12" type="date" onchange="tarih_sorgula()" value="<?= $kategori_oku["ihale_tarihi"] ?>" name="ihale_tarihi" id="ihale_tarihi" required> -->

				<label for="IDofInput">İhale Bitiş Saati*</label>
				<input class="span12" type="time" onchange="tarih_sorgula2()" name="ihale_saati" value="<?= $kategori_oku["ihale_saati"] ?>" id="ihale_saati" required>

				<label for="IDofInput">PD Hizmet Bedeli</label>
				<?php
				if ($kategori_oku['pd_hizmet'] == "" || $kategori_oku['pd_hizmet'] <= 0) {
					$pd_yaz = "Otomatik Hesaplama";
				} else {
					$pd_yaz = $kategori_oku["pd_hizmet"];
				}
				?>
				<input class="span12" type="text" value="<?= $pd_yaz ?>" name="pd_hizmet" value="" id="pd_hizmet">

				<label for="IDofInput">Otopark Giriş Tarihi</label>
				<input class="span12" type="date" name="otopark_giris" value="<?= $kategori_oku["otopark_giris"] ?>" id="otopark_giris">

				<label for="IDofInput">Otopark Ücreti</label>
				<input class="span12" type="text" name="otopark_ucreti" value="<?= $kategori_oku["otopark_ucreti"] ?>" id="otopark_ucreti">

				<label for="IDofInput">Çekici Ücreti</label>
				<input class="span12" type="text" name="cekici_ucreti" value="<?= $kategori_oku["cekici_ucreti"] ?>" id="cekici_ucreti">

				<label for="IDofInput">Dosya Masrafı</label>
				<input class="span12" type="text" name="dosya_masrafi" value="<?= $kategori_oku["dosya_masrafi"] ?>" id="dosya_masrafi">

				<label for="IDofInput">Link</label>
				<input class="span12" type="text" name="link" value="<?= $kategori_oku["link"] ?>" id="link">

				<label for="IDofInput">Kilometre</label>
				<input class="span12" type="text" onkeypress="return isNumberKey(event)" value="<?= $kategori_oku["kilometre"] ?>" name="kilometre" id="kilometre">

				<label for="IDofInput">Adres</label>
				<textarea name="adres" class="span12" rows="5"><?= $kategori_oku["adres"] ?></textarea>

				<label for="IDofInput">Araç Türü</label>
				<select class="span12" name="arac_turu" id="arac_turu">
					<option <?php if ($kategori_oku['arac_durumu'] == "") {
								echo "selected";
							} ?> value="">Seçiniz</option>
					<option <?php if ($kategori_oku['arac_durumu'] == 1) {
								echo "selected";
							} ?> value="1">Kazalı (En Ufak Bir Onarım Görmemiş)</option>
					<option <?php if ($kategori_oku['arac_durumu'] == 2) {
								echo "selected";
							} ?> value="2">Kazalı (Hafif onarımlar yapılmış halk ağzıyla makyajlı)</option>
					<option <?php if ($kategori_oku['arac_durumu'] == 3) {
								echo "selected";
							} ?> value="3">İkinci El (Pert Kayıtlı)</option>
					<option <?php if ($kategori_oku['arac_durumu'] == 4) {
								echo "selected";
							} ?> value="4">İkinci El (Pert Kayıtsız)</option>

				</select>



				<!--<label for="IDofInput">Resim</label>
            <input type="file" class="span12" name="resim[]" multiple>-->

			</div>
		</div>
		<div class="row-fluid">

			<label for="IDofInput">Uyarı Notu</label>
			<textarea style="min-height:200px !important" class="span12" name="uyari_notu" id="uyari_notu"><?= $kategori_oku["uyari_notu"] ?></textarea>

			<label for="IDofInput">Hasar Bilgileri</label>
			<textarea class="span12" name="hasar_bilgileri" id="hasar_bilgileri"><?= $kategori_oku["hasar_bilgileri"] ?></textarea>

			<label for="IDofInput">Notlar</label>
			<textarea class="span12" name="notlar" id="notlar"><?= $kategori_oku["notlar"] ?></textarea>


			<label for="IDofInput">Donanımlar</label>
			<textarea class="span12" name="donanimlar" id="donanimlar"><?= $kategori_oku["donanimlar"] ?></textarea>

			<label class="b-label">
				<label for="IDofInput">Vitrin</label>
				<?php if ($kategori_oku["vitrin"] == "on") { ?>
					<input class="span12 chec" type="checkbox" checked style="opacity:1!important; z-index:999;" id="sigorta_vitrin" name="vitrin">
				<?php } else { ?>
					<input class="span12 chec" type="checkbox" style="opacity:1!important; z-index:999;" id="sigorta_vitrin" name="vitrin">
				<?php } ?>
			</label>
		</div>
		<div class="form-actions">
			<button type="submit" name="ilani" class="btn blue" value="Kaydet">Kaydet</button>

		</div>
	</form>

<?php } else { ?>

	<form method="post" id="form" name="form" enctype="multipart/form-data">
		<?php include('islemler/ilanlar/ilan_ekle.php'); ?>
		<text style="color:red"><?= $uyari ?></text>
		<div class="row-fluid">
			<div class="span6">
				<label for="IDofInput">Plaka</label>
				<!-- <input type="text" class="span12" name="plaka" id="plaka" onchange="plaka_sorgu();" placeholder="01AA0000" onkeypress="return boslukEngelle()" pattern="[0-9]{2}[A-Za-z]{1,3}[0-9]{2,4}" oninvalid="this.setCustomValidity('LÜTFEN PLAKAYI DÜZGÜN GİRİN')" oninput="this.setCustomValidity('')" maxlength="8"  />  -->
				<input type="text" class="span12" name="plaka" id="plaka" onchange="plaka_sorgu();" placeholder="01AA0000" onkeypress="return boslukEngelle()" pattern="[0-9]{2}[A-Za-z]{1,3}[0-9]{2,4}" oninvalid="this.setCustomValidity('LÜTFEN PLAKAYI DÜZGÜN GİRİN')" oninput="this.setCustomValidity('')" maxlength="8" />

				<label for="IDofInput">Araç Kodu</label>
				<input type="text" class="span12" name="arac_kodu" id="arac_kodu" onchange="arac_kodu_sorgu();" onkeypress="return boslukEngelle()" />

				<label for="IDofInput">Hesaplama*</label>
				<select class="span12" name="hesaplama" id="hesaplama" required>
					<option value="Standart" selected>Standart</option>
					<option value="Luks">Ticari</option>
				</select>
				<?php $sigorta_cek = mysql_query("SELECT * FROM sigorta_ozellikleri"); ?>
				<label for="IDofInput">Sigorta Şirketi*</label>
				<select class="span12" name="sigorta" id="sigorta" onchange="sigort()" required>
					<option value="">SEÇİNİZ</option>
					<?php while ($sigorta_oku = mysql_fetch_array($sigorta_cek)) { ?>
						<option value="<?= $sigorta_oku['id'] ?>"><?= $sigorta_oku['sigorta_adi'] ?></option>
					<?php } ?>
				</select>

				<label for="IDofInput">Marka*</label>
				<select class="span12" name="marka" id="marka" required>
					<option value="">SEÇİNİZ</option>
					<?php $marka_cek = mysql_query("SELECT * FROM marka order by marka_adi asc");
					while ($marka_oku = mysql_fetch_array($marka_cek)) { ?>
						<option value="<?= $marka_oku['markaID'] ?>" style="text-transform: uppercase;"><?= mb_strtoupper(pre_up($marka_oku['marka_adi'])) ?></option>
					<?php } ?>
				</select>

				<label for="IDofInput">Model*</label>
				<select class="span12" name="model" id="model" disabled required>
				</select>

				<label for="IDofInput">Tip</label>
				<input class="span12" type="text" style="text-transform: uppercase;" name="tip" id="tip">

				<?php $anlik_yil = date("Y") ?>
				<label for="IDofInput">Model Yılı</label>
				<input class="span12" type="number" onkeypress="return isNumberKey(event)" name="model_yili" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxLength="4" min="1950" max="<?= $anlik_yil; ?>" id="model_yili">

				<!-- <label for="IDofInput">Piyasa Değeri</label>
            <input class="span12" type="text" onkeypress="return isNumberKey(event)" name="piyasa_degeri" id="piyasa_degeri"  > -->

				<label for="IDofInput">TSRSB Değeri</label>
				<input class="span12" type="text" onkeypress="return isNumberKey(event)" name="tsrsb_degeri" id="tsrsb_degeri" placeholder="sadece rakam">

				<label for="IDofInput">Açılış Fiyatı</label>
				<input class="span12" type="text" onkeypress="return isNumberKey(event)" name="acilis_fiyati" id="acilis_fiyati">

				<label for="IDofInput">Profil</label>
				<select class="span12" name="profil" id="profil">
					<option value="Çekme Belgeli/Pert Kayıtlı">Çekme Belgeli/Pert Kayıtlı</option>
					<option value="Çekme Belgeli">Çekme Belgeli</option>
					<option value="Hurda Belgeli">Hurda Belgeli</option>
					<option value="Plakalı">Plakalı</option>
					<option value="Diğer">Diğer</option>
				</select>
				<label for="IDofInput">Araç Türü</label>
				<select class="span12" name="arac_turu" id="arac_turu">
					<option value="">Seçiniz</option>
					<option value="1">Kazalı (En Ufak Bir Onarım Görmemiş)</option>
					<option value="2">Kazalı (Hafif onarımlar yapılmış halk ağzıyla makyajlı)</option>
					<option value="3">İkinci El (Pert Kayıtlı)</option>
					<option value="4">İkinci El (Pert Kayıtsız)</option>
				</select>
				<!--<label for="IDofInput">İhale Türü</label>
            <select class="span12" name="ihale_turu" id="ihale_turu" >
                
                <option value="1">Açık İhale</option>
                <option value="2">Kapalı İhale</option>
            </select>-->
			<label for="IDofInput">Yakıt Tipi</label>
			<select name="yakit_tipi" class="span12" id="yakit_tipi" >
				<option value="">Seçiniz</option>
				<option value="Benzinli">Benzinli</option>
				<option value="Benzin+Lpg">Benzin+Lpg</option>
				<option value="Dizel">Dizel</option>
				<option value="Hybrit">Hybrit</option>
				<option value="Elektrikli">Elektrikli</option>
			</select>
			</div>
			<div class="span6">
				<label for="IDofInput">Şehir</label>
				<select class="span12" name="sehir" id="sehir">
					<option value="">Şehir seçin</option>
					<option value="0">Bilinmiyor</option>
					<?php
					while ($sehir_oku = mysql_fetch_array($sehir_cek)) {
					?>
						<option value="<?= $sehir_oku["sehirID"] ?>"><?= $sehir_oku["sehiradi"]; ?></option>
					<?php } ?>
				</select>
				<!-- <label for="IDofInput">İlçe</label>
            <select class="span12" name="ilce" id="ilce" disabled>
                <option value="">İlçe seçin</option>
            </select>-->

				<!-- <label for="IDofInput">İhale Başlama Tarihi</label>
            <input class="span12" type="date"  name="ihale_acilis" id="ihale_acilis"> -->

				<label for="IDofInput">İhale Bitiş Tarihi*</label>
				<input class="span12" onfocusout="tarih_sorgula();" type="date" value="" name="ihale_tarihi" id="ihale_tarihi" required>
				<!-- <input class="span12" onfocusout="tarih_sorgula();" type="date" value="" name="ihale_tarihi" id="ihale_tarihi" required max="9999-12-31"> -->
				<!--<input class="span12" onchange="tarih_sorgula()" type="date" value="" name="ihale_tarihi" id="ihale_tarihi" required>-->

				<label for="IDofInput">İhale Bitiş Saati*</label>
				<input class="span12" type="time" onchange="tarih_sorgula2()" name="ihale_saati" id="ihale_saati" required>

				<label for="IDofInput">PD Hizmet Bedeli</label>
				<input class="span12" type="text" name="pd_hizmet" value="" id="pd_hizmet">

				<label for="IDofInput">Otopark Giriş Tarihi</label>
				<input class="span12" type="date" name="otopark_giris" id="otopark_giris">

				<label for="IDofInput">Otopark Ücreti</label>
				<input class="span12" type="text" name="otopark_ucreti" id="otopark_ucreti">

				<label for="IDofInput">Çekici Ücreti</label>
				<input class="span12" type="text" name="cekici_ucreti" id="cekici_ucreti">

				<label for="IDofInput">Dosya Masrafı</label>
				<input class="span12" type="text" name="dosya_masrafi" id="dosya_masrafi">

				<label for="IDofInput">Link</label>
				<input class="span12" type="text" name="link" id="link">

				<label for="IDofInput">Kilometre</label>
				<input class="span12" type="text" onkeypress="return isNumberKey(event)" name="kilometre" id="kilometre">

				<label for="IDofInput">Adres</label>
				<textarea name="adres" class="span12" rows="5"></textarea>
				
				<label for="IDofInput">Vites Tipi</label>
				<select  name="vites_tipi" id="vites_tipi" class="span12" >
					<option value="">Seçiniz</option>
					<option value="Düz Vites">Düz Vites</option>
					<option value="Otomatik Vites">Otomatik Vites</option>
				</select>

				
				<!--<label for="IDofInput">Resim</label>
            <input type="file" class="span12" name="resim[]" multiple>-->

			</div>
		</div>
		<div class="row-fluid">
			<label for="IDofInput">Uyarı Notu</label>
			<textarea style="min-height:200px !important" class="span12" name="uyari_notu" id="uyari_notu"></textarea>

			<label for="IDofInput">Hasar Bilgileri</label>
			<textarea class="span12" name="hasar_bilgileri" id="hasar_bilgileri"></textarea>

			<label for="IDofInput">Notlar</label>
			<textarea class="span12" name="notlar" id="notlar"></textarea>


			<label for="IDofInput">Donanımlar</label>
			<textarea class="span12" name="donanimlar" id="donanimlar"></textarea>




			<label class="b-label">
				<label for="IDofInput">Vitrin</label>
				<input class="span12 chec" type="checkbox" style="opacity:1!important; z-index:999;margin-top:-4px;" id="sigorta_vitrin" name="vitrin">
			</label>

		</div>
		<div class="form-actions">
			<button type="submit" name="ilani" class="btn blue" value="Kaydet">Kaydet</button>
		</div>
	</form>
<?php } ?>
<style>
	.chec {
		opacity: 1 !important;
		z-index: 999 !important;
	}

	/* .checker span
			{
				background:transparent!important;
			} */
	#sigorta_vitrin {
		opacity: 1 !important;
	}
</style>
<!--<script src="https://code.jquery.com/jquery-3.6.0.js" > </script>-->
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script>
	function sigort() {
		jQuery.ajax({
			url: "https://ihale.pertdunyasi.com/check.php",
			type: "POST",
			dataType: "JSON",
			data: {
				action: "panel_sigorta",
				sigorta: $("#sigorta").val(),

			},
			success: function(response) {
				console.log(response);
				if (response.status == 200) {
					if (response.vitrindemi == "on") {
						console.log("vitrinde");
						document.getElementById("sigorta_vitrin").checked = true;
					} else {
						console.log("vitrinde değil");
						document.getElementById("sigorta_vitrin").checked = false;
					}
					// $("#ihale_saati").val()=response.saat;
					// $("#pd_hizmet").val()=response.pd;
					document.getElementById("ihale_saati").value = response.saat;
					document.getElementById("pd_hizmet").value = response.pd;
					document.getElementById("dosya_masrafi").value = response.dosya_masrafi;
					document.getElementById("cekici_ucreti").value = response.cekici_ucreti;
					document.getElementById("otopark_ucreti").value = response.otopark_ucreti;
				}
			}
		});
	}
</script>


<script>
	function formatMoney(n) {
		var n = (Math.round(n * 100) / 100).toLocaleString();
		n = n.replaceAll(',', '.')
		return n;
	}

	function button_kontrol(ilan_id) {
		var statu_durumu = <?php echo json_encode($statu_durum) ?>;
		if (statu_durumu == "1") {
			if ($('#pdf_link_kopyala').val() != "") {
				document.getElementById("statu_kaydet").disabled = true;
			} else {
				document.getElementById("statu_kaydet").disabled = false;
			}
		} else if ($("#statu_bilgisi").val() == "1") {
			if ($('input[name="odeme_bildirimi_dosya"]')[0].files.length == 0) {
				document.getElementById("statu_kaydet").disabled = true;
			} else {
				document.getElementById("statu_kaydet").disabled = false;
			}
		} else {
			document.getElementById("statu_kaydet").disabled = false;
		}
		var formData = new FormData(document.getElementById('form'));
		formData.append('ilan_id', ilan_id);
		formData.append("action", "odeme_bildirimi_ekle");
		formData.append("odeme_bildirimi_dosya", document.getElementById('odeme_bildirimi_dosya').files[0]);
		$.ajax({
			url: "../check.php",
			type: 'POST',
			data: formData,
			dataType: 'json',
			success: function(response) {
				console.log(response);
				if (response.status == 200) {
					if (statu_durumu == "1") {
						if ($('#pdf_link_kopyala').val() != "") {
							document.getElementById("statu_kaydet").disabled = true;
						} else {
							document.getElementById("statu_kaydet").disabled = false;
						}
					} else if ($("#statu_bilgisi").val() == "1") {
						if ($('input[name="odeme_bildirimi_dosya"]')[0].files.length == 0) {
							document.getElementById("statu_kaydet").disabled = true;
						} else {
							document.getElementById("statu_kaydet").disabled = false;
						}
					} else {
						document.getElementById("statu_kaydet").disabled = false;
					}
					alert(response.message);
					statu_bilgileri_cek();
					document.getElementById('odeme_bildirimi_dosya').value = "";
					document.getElementById('odeme_bildirimi_pdf').innerHTML = response.odeme_bildirimi;
				} else {
					alert(response.message);
					document.getElementById('odeme_bildirimi_dosya').value = "";
				}
			},
			cache: false,
			contentType: false,
			processData: false
		});
	}

	function tarih_getir() {
		var statu_durumu = <?php echo json_encode($statu_durum) ?>;
		var statu = <?php echo json_encode($statu_son_odeme_tarihi) ?>;
		var hesaplanmis_tarih = <?php echo json_encode($hesaplanmis_tarih) ?>;
		var mtv = <?php echo json_encode($statu_mtv) ?>;

		if ($('input[name="odeme_bildirimi_dosya"]')[0].files.length == 0 && statu_durumu == 1) {
			document.getElementById("statu_kaydet").disabled = true;
		} else {
			document.getElementById("statu_kaydet").disabled = false;
		}
		if ($("#statu_bilgisi").val() == "1") {
			if ($('input[name="odeme_bildirimi_dosya"]')[0].files.length == 0) {
				// document.getElementById("statu_kaydet").disabled = true;
				document.getElementById("statu_kaydet").disabled = false;
				console.log("çalıştı");
			} else {
				document.getElementById("statu_kaydet").disabled = false;
				console.log("çaasasas");
			}
			if (statu != "0000-00-00" && (statu != null || statu != undefined)) {
				$("#tarih_div").html('<label for="IDofInput">Son Ödeme Tarihi</label><input type="date" name="son_odeme_tarihi" id="son_odeme_tarihi" class="span12" value="' + statu + '">');

			} else {
				$("#tarih_div").html('<label for="IDofInput">Son Ödeme Tarihi</label><input type="date" name="son_odeme_tarihi" id="son_odeme_tarihi" class="span12" value="' + hesaplanmis_tarih + '">');
			}

		} else {
			$("#tarih_div").html('');
			$("#mtv_ekle").html('');
			document.getElementById("statu_kaydet").disabled = false;
		}
	}
	// tarih_getir();

	$("#plaka").keypress(function(event) {
		var character = String.fromCharCode(event.keyCode);
		return isValid(character);
	});

	function isValid(str) {
		return !/[~`!@#$%\^&*()+=\-\[\]\\';.,/{}|\\":<>\?]/g.test(str);
	}
</script>

<!-- <script language="javascript">
function kontrol()
{
var reg=new RegExp("\[ÜĞŞÇÖğıüşöçİ.,´-_/*-+!'^$%&/()=]");
if(reg.test(document.getElementById('plaka').value,reg))
{
alert('Email alanında türkçe karakter bulunmamalıdır.');
document.getElementById('plaka').value="";
}
}
</script> -->



<!-- <script>
$('plaka').on('keypress', function (event) {
    var regex = new RegExp("^[a-zA-Z0-9]+$");
    var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
    if (!regex.test(key)) {
       event.preventDefault();
       return false;
    }
});
</script> -->
<script>
	function boslukEngelle() {
		if (event.keyCode == 32) {
			return false;
		}
	}
</script>

<script>
	function isNumberKey(evt) {
		var charCode = (evt.which) ? evt.which : event.keyCode;
		if (charCode > 31 && (charCode < 48 || charCode > 57))
			return false;
		return true;
	}
</script>
<style>
	.ck-editor__editable_inline {
		min-height: 200px !important;
	}
</style>

<script>
	/* ClassicEditor
        .create( document.querySelector( '#hasar_bilgileri' ) )
        .then( editor => {
            console.log( editor );
        } )
        .catch( error => {
            console.error( error );
        } );      */
	CKEDITOR.replace('hasar_bilgileri', {
		height: 250,
		extraPlugins: 'colorbutton,colordialog',
		removeButtons: 'PasteFromWord'
	});
</script>
<script>
	/* ClassicEditor
        .create( document.querySelector( '#notlar' ) )
        .then( editor => {
            console.log( editor );
        } )
        .catch( error => {
            console.error( error );
        } );*/

	CKEDITOR.replace('notlar', {
		height: 250,
		extraPlugins: 'colorbutton,colordialog',
		removeButtons: 'PasteFromWord'
	});
</script>
<script>
	/*ClassicEditor
        .create( document.querySelector( '#donanimlar' ) )
        .then( editor => {
            console.log( editor );
        } )
        .catch( error => {
            console.error( error );
        } );*/
	CKEDITOR.replace('donanimlar', {
		height: 250,
		extraPlugins: 'colorbutton,colordialog',
		removeButtons: 'PasteFromWord'
	});

	// Set focus and blur listeners for all editors to be created.
	CKEDITOR.on('instanceReady', function(evt) {
		var editor = evt.editor,
			body = CKEDITOR.document.getBody();
		editor.on('focus', function() {
			// Use jQuery if you want.
			var $sira = this.id;
			$('.' + $sira).addClass('ckeditor_focus');
			//body.addClass( 'fix' );
		});
		editor.on('blur', function() {
			// Use jQuery if you want.
			var $sira = this.id;
			$('.' + $sira).removeClass('ckeditor_focus');
			//body.removeClass( 'fix' );
		});
	});
</script>
<script>
	function plaka_sorgu() {
		jQuery.ajax({
			url: "https://ihale.pertdunyasi.com/check.php",
			type: "POST",
			dataType: "JSON",
			data: {
				action: "panel_plaka_sorgu",
				plaka: $("#plaka").val(),

			},
			success: function(response) {

				if (response.status == 200) {
					var span = document.createElement("span");
					span.innerHTML = response.data;

					swal({
						title: "Dikkat",
						text: "Bu plakaya ait bilgiler mevcut.",
						content: span,
					});
				}
			}
		});
	}

	function arac_kodu_sorgu() {
		jQuery.ajax({
			url: "https://ihale.pertdunyasi.com/check.php",
			type: "POST",
			dataType: "JSON",
			data: {
				action: "panel_arac_kodu_sorgu",
				arac_kodu: $("#arac_kodu").val(),

			},
			success: function(response) {

				if (response.status == 200) {
					var span = document.createElement("span");
					span.innerHTML = response.data;

					swal({
						title: "Dikkat",
						text: "Bu plakaya ait bilgiler mevcut.",
						content: span,
					});
				}
			}
		});
	}

	function tarih_sorgula2() {
		var todayDate = new Date().toISOString().slice(0, 10);
		if ($("#ihale_tarihi").val() == todayDate) {
			setTimeout(function() {
				if ($("#ihale_tarihi").val() != "" && $("#ihale_saati").val() != "") {
					jQuery.ajax({
						url: "https://ihale.pertdunyasi.com/check.php",
						type: "POST",
						dataType: "JSON",
						data: {
							action: "panel_tarih_sorgu",
							ihale_tarihi: $("#ihale_tarihi").val(),
							ihale_saati: $("#ihale_saati").val()
						},
						success: function(response) {

							if (response.status == 200) {
								swal({
									title: "Dikkat",
									text: response.message,
								});

							}
							if (response.yayin_durum == 1) {
								if (document.getElementById("yayinda") != undefined) {
									document.getElementById("yayinda").checked = true;
								}
							}
						}
					});
				}
			}, 3000);
		} else {
			if ($("#ihale_tarihi").val() != "" && $("#ihale_saati").val() != "") {
				jQuery.ajax({
					url: "https://ihale.pertdunyasi.com/check.php",
					type: "POST",
					dataType: "JSON",
					data: {
						action: "panel_tarih_sorgu",
						ihale_tarihi: $("#ihale_tarihi").val(),
						ihale_saati: $("#ihale_saati").val()
					},
					success: function(response) {

						if (response.status == 200) {
							swal({
								title: "Dikkat",
								text: response.message,
							});

						}
						if (response.yayin_durum == 1) {
							if (document.getElementById("yayinda") != undefined) {
								document.getElementById("yayinda").checked = true;
							}
						}
					}
				});
			}
		}

		//await sleep(3000);

	}

	function tarih_sorgula() {
		if ($("#ihale_tarihi").val() != "" && $("#ihale_saati").val() != "") {
			jQuery.ajax({
				url: "https://ihale.pertdunyasi.com/check.php",
				type: "POST",
				dataType: "JSON",
				data: {
					action: "panel_tarih_sorgu",
					ihale_tarihi: $("#ihale_tarihi").val(),
					ihale_saati: $("#ihale_saati").val()
				},
				success: function(response) {

					if (response.status == 200) {
						swal({
							title: "Dikkat",
							text: response.message,
						});


					}
					if (response.yayin_durum == 1) {
						if (document.getElementById("yayinda") != undefined) {
							document.getElementById("yayinda").checked = true;
						}
					}
				}
			});
		}
		//await sleep(3000);

	}

	/*	function sleep(ms) {
  return new Promise(resolve => setTimeout(resolve, ms));
}*/
</script>


<script>
	function komisyon_kontrol() {
		var hesaplama = document.getElementById('hesaplama').value;
		var girilen_teklif = parseInt(document.getElementById('kazandigi_tutar').value);
		$.ajax({
			url: '"https://ihale.pertdunyasi.com/teklif_ver.php"',
			method: 'post',
			dataType: "json",
			data: {
				action: "komisyon_cek",
				ilan_id: $("#ilan_id").val(),
				girilen_teklif: girilen_teklif

			},
			success: function(data) {
				var son_komisyon = data.son_komisyon;
				if (son_komisyon == 0 || son_komisyon == undefined || son_komisyon == null || son_komisyon == "") {
					document.getElementById("pd_hizmet_hesaplı").innerHTML = "" + "₺";
					document.getElementById("pd_hizmet_hesaplı").value = "" + "₺";
					document.getElementById('pd_hizmet_text').innerHTML = "";
				} else {

					document.getElementById('kazanilan_teklif_text').innerHTML = formatMoney(girilen_teklif) + "₺";
					document.getElementById('pd_hizmet_text').innerHTML = formatMoney(son_komisyon) + "₺";
					document.getElementById("pd_hizmet_hesaplı").innerHTML = formatMoney(son_komisyon) + "₺";
					document.getElementById("pd_hizmet_hesaplı").value = son_komisyon + "₺";
				}
			},
		});
		/* var oran = <?php echo json_encode($oran); ?>;
            var standart_net = <?php echo json_encode($standart_net); ?>;
            var luks_net = <?php echo json_encode($luks_net); ?>;
            var standart_onbinde = <?php echo json_encode($standart_onbinde); ?>;
            var luks_onbinde = <?php echo json_encode($luks_onbinde); ?>;

			//Dizi max,min bulur
			Array.prototype.max = function() {
			  return Math.max.apply(null, this);
			};

			Array.prototype.min = function() {
			  return Math.min.apply(null, this);
			};

            var dizi_length = oran.length;
            if(hesaplama == "Standart"){      
				for (var sayac = 0; sayac < dizi_length; sayac++) {
					if(girilen_teklif <= oran[sayac]){
						var oran1 = parseInt(oran[sayac]);
						var standart_net1 = parseInt(standart_net[sayac]);
						var standart_onbinde1 = parseInt(standart_onbinde[sayac]);
						var ek_gider = girilen_teklif * standart_onbinde1 / 10000;
						var son_komisyon = Math.ceil(ek_gider + standart_net1);   	
						break;
					}
				}
				var max_index;
				for (var j = 0; j < dizi_length; j++) {
					if(oran[j] == oran.max() ){
						max_index=j;
					}
				}
				if(girilen_teklif > oran.max()){
					var oran1 = parseInt(oran.max());
					var standart_net1 = parseInt(standart_net[max_index]);
					var standart_onbinde1 = parseInt(standart_onbinde[max_index]);
					var ek_gider = girilen_teklif * standart_onbinde1 / 10000;
					var son_komisyon = Math.ceil(ek_gider + standart_net1);   	
				}
            }else{
				for (var sayac = 0; sayac < dizi_length; sayac++) {
					if(girilen_teklif <= oran[sayac]){
						var oran1 = parseInt(oran[sayac]);
						var luks_net1 = parseInt(luks_net[sayac]);
						var luks_onbinde1 = parseInt(luks_onbinde[sayac]);
						var ek_gider = girilen_teklif * luks_onbinde1 / 10000;
						var son_komisyon = Math.ceil(ek_gider + luks_net1);   				 
						break;
					}
				}
			   	var max_index;
				for (var j = 0; j < dizi_length; j++) {
					if(oran[j] == oran.max() ){
						max_index=j;
					}
				}
				if(girilen_teklif > oran.max()){
					var oran1 = parseInt(oran.max());
					var luks_net1 = parseInt(luks_net[max_index]);
					var luks_onbinde1 = parseInt(luks_net[max_index]);
					var ek_gider = girilen_teklif * luks_onbinde1 / 10000;
					var son_komisyon = Math.ceil(ek_gider + luks_net1);   	
				}
            }
			
			if(son_komisyon == 0 || son_komisyon == undefined || son_komisyon == null || son_komisyon == "" ){
				document.getElementById('pd_hizmet_hesaplı').innerHTML = "" +"₺";
				document.getElementById('pd_hizmet_hesaplı').value = "" +"₺";
			}else {
				document.getElementById('pd_hizmet_hesaplı').innerHTML = formatMoney(son_komisyon) +"₺";
				document.getElementById('pd_hizmet_hesaplı').value = son_komisyon +"₺";
			}	*/
		//console.log(document.getElementById('pd_hizmet').innerHTML);
		//console.log(document.getElementById('pd_hizmet').value);
	}
	$(function() {
		$('#teklifler').on('change', function() {
			var teklif = $(this).val();

			if (teklif > 0) {
				$.post('sayfalar/ilanlar/teklif_bul.php', {
					'teklif': teklif
				}, function(response) {

					var tutar = response.teklif;
					console.log(tutar);
					if (tutar > 0) {
						$('#kazandigi_tutar').val(tutar);
						$('#kazandigi_tutar').html(tutar);
						$('#kazanilan_teklif_text').html(formatMoney(tutar) + "₺");
						$("#slct option[value='']").attr("selected", "selected");
						$("#slct").attr("disabled", "disabled");
					} else {
						$('#kazandigi_tutar').val("");
						$('#kazanilan_teklif_text').html("");
						$('#kazandigi_tutar').html("");
						$("#slct").removeAttr("disabled");
					}


					document.getElementById('pd_hizmet_text').innerHTML = formatMoney(response.hizmet_bedeli) + "₺";
					document.getElementById('pd_hizmet_hesaplı').innerHTML = formatMoney(response.hizmet_bedeli) + "₺";
					document.getElementById('pd_hizmet_hesaplı').value = response.hizmet_bedeli + "₺";
					toplam_tutar_guncelle();
				}, 'json');

			} else {
				$('#kazandigi_tutar').val("");
				$('#kazanilan_teklif_text').val("");
				$('#kazandigi_tutar').html("");
				$("#slct").removeAttr("disabled");
				toplam_tutar_guncelle();
			}
		});
	});
	$(function() {
		$('#slct').on('change', function() {
			var slct = $(this).val();
			var teklifler = $("#teklifler").val();

			if (slct > 0) {
				$('#kazandigi_tutar').val("");
				$('#kazanilan_teklif_text').html("");
				$('#kazandigi_tutar').html("");
				$("#teklifler option[value='']").attr("selected", "selected");
				$("#teklifler").attr("disabled", "disabled");
			} else {
				$('#kazanilan_teklif_text').html("");
				$('#kazandigi_tutar').val("");
				$('#kazandigi_tutar').html("");
				$("#teklifler").removeAttr("disabled");
			}
		});
	});
	var globalFunctions = {};

	globalFunctions.ddInput = function(elem) {
		if ($(elem).length == 0 || typeof FileReader === "undefined") return;
		var $fileupload = $('input[name="resim[]"]');
		var noitems = '<li class="no-items"></li>';
		var hasitems = '<div class="browse hasitems">Dosya Seçimi </div>';
		var file_list = '<ul class="file-list"></ul>';
		var rmv = '<div class="remove"><i style="font-size:30px" class="icon-close icons">x</i></div>'
		$fileupload.each(function() {
			var self = this;
			var $dropfield = $('<div class="drop-field"><div class="drop-area"></div></div>');
			$(self).after($dropfield).appendTo($dropfield.find('.drop-area'));
			var $file_list = $(file_list).appendTo($dropfield);
			$dropfield.append(hasitems);
			$dropfield.append(rmv);
			$(noitems).appendTo($file_list);
			var isDropped = false;
			$(self).on("change", function(evt) {
				if ($(self).val() == "") {
					$file_list.find('li').remove();
					$file_list.append(noitems);
				} else {
					if (!isDropped) {
						$dropfield.removeClass('hover');
						$dropfield.addClass('loaded');
						var files = $(self).prop("files");
						traverseFiles(files);
					}
				}
			});

			$dropfield.on("dragleave", function(evt) {
				$dropfield.removeClass('hover');
				evt.stopPropagation();
			});

			$dropfield.on('click', function(evt) {
				$(self).val('');
				$file_list.find('li').remove();
				$file_list.append(noitems);
				$dropfield.removeClass('hover').removeClass('loaded');
			});

			$dropfield.on("dragenter", function(evt) {
				$dropfield.addClass('hover');
				evt.stopPropagation();
			});

			$dropfield.on("drop", function(evt) {
				isDropped = true;
				$dropfield.removeClass('hover');
				$dropfield.addClass('loaded');
				var files = evt.originalEvent.dataTransfer.files;
				traverseFiles(files);
				isDropped = false;
			});


			function appendFile(file) {

				$file_list.append('<li>' + file.name + '</li>');
			}

			function traverseFiles(files) {
				if ($dropfield.hasClass('loaded')) {
					$file_list.find('li').remove();
				}
				if (typeof files !== "undefined") {
					for (var i = 0, l = files.length; i < l; i++) {
						appendFile(files[i]);
					}
				} else {
					alert("Tarayıcının dosya yükleme özelliği yok.");
				}
			}

		});
	};

	$(document).ready(function() {
		globalFunctions.ddInput('input[name="resim[]"]');
	});

	function ilan_resim_yukle(id) {

		var formData = new FormData(document.getElementById('form'));
		formData.append('id', id);
		formData.append("action", "ilan_resim_ekle");
		var filesLength = document.getElementById('file_input').files.length;
		for (var i = 0; i < filesLength; i++) {
			formData.append("resim[]", document.getElementById('file_input').files[i]);
		}
		$.ajax({
			url: "https://ihale.pertdunyasi.com/check.php",
			type: 'POST',
			data: formData,
			dataType: 'json',
			success: function(response) {
				var gorunme = <?php echo json_encode($gorunme); ?>;
				alert("Yükleme Başarılı");
				var dosya_sayisi = response.yukleme_sayisi;

				var li_html = $("#kayitli_resimler").html();
				li_html = $("#kayitli_resimler").html();
				var li_html2 = "";
				for (var j = 0; j < filesLength; j++) {
					li_html += "<li id='" + response.resim_id[j]["resim_id"] + "' style='margin-left:5px;margin-top:10px;' class='span4'><a href='#' class='thumbnail'><img src=../images/" + response.resim[j]["ad"] + " value='' style='height:100px;'></a><br/><a style='display: " + gorunme + "' href='?modul=ayarlar&sayfa=data_sil&id=" + response.resim_id[j]["resim_id"] + "&q=resim&g=" + id + "' class='btn red'>Sil</a></li>";
				}
				$("#kayitli_resimler").html(li_html + li_html2);
				var file_list = '<ul class="file-list"></ul>';
				var dropfield = $('<div class="drop-field"><div class="drop-area"></div></div>');
				var noitems = '<li class="no-items"></li>';
				$('input[type="file"]').val('');
				$(".file-list").remove();
				$(".drop-field").removeClass("loaded");


			},
			cache: false,
			contentType: false,
			processData: false
		});

	}

	function resim_sil(id) {

		$.ajax({
			url: "https://ihale.pertdunyasi.com/check.php",
			method: 'POST',
			data: {
				action: "ilan_resim_sil",
				id: id
			},
			success: function(data) {
				alert("İşlem Başarılı");
				$("#ilan_resmi_" + id).remove();
			},
			error: function(data) {

			}
		});

	}

	function butun_resim_sil(id) {
		var a = confirm("Tüm resimleri silmek istediğinize emin misiniz");
		if (a) {
			$.ajax({
				url: "https://ihale.pertdunyasi.com/check.php",
				method: 'POST',
				data: {
					action: "ilan_resimleri_sil",
					id: id
				},
				success: function(data) {
					alert("İşlem Başarılı");
					$("#kayitli_resimler").remove();
				},
				error: function(data) {

				}
			});
		}

	}

	function statu_bilgileri_cek() {
		var serbest_secim_k_id = $('#slct').val();
		var statu_secim = $('#statu_bilgisi').val();
		var teklif_id = $('#teklifler').val();
		var ilan_id = $('#ilan_id').val();
		if (statu_secim == "1") {
			$("#parcalar").css("display", "block");
			$("#parcalar2").css("display", "block");
		} else {
			$("#parcalar").css("display", "none");
			$("#parcalar2").css("display", "none");
		}

		$.ajax({
			url: "../check.php",
			method: 'POST',
			dataType: 'json',
			data: {
				action: "statuleri_getir",
				serbest_secim_k_id: serbest_secim_k_id,
				teklif_id: teklif_id,
				statu_secim: statu_secim,
				ilan_id: ilan_id,
			},
			success: function(data) {
				console.log(data.statu_sms);
				$("#otomatik_mesaj").val(data.statu_sms);

				if (data.otamatik_engelle != undefined) {
					document.getElementById("riske_gore_teklif").checked = data.otamatik_engelle;
				}
				if (data.onay_bekleyen != undefined) {
					document.getElementById("onay_bekleyenler").innerHTML = "";
					document.getElementById("onay_bekleyenler").innerHTML = data.onay_bekleyen;
				}
				if (data.odeme_bekleyen != undefined) {
					document.getElementById("odeme_bekleyenler").innerHTML = "";
					document.getElementById("odeme_bekleyenler").innerHTML = data.odeme_bekleyen;
				}
				if (data.son_islemde != undefined) {
					document.getElementById("son_islemdekiler").innerHTML = "";
					document.getElementById("son_islemdekiler").innerHTML = data.son_islemde;
				}
				if (data.satin_alinan != undefined) {
					document.getElementById("satilanlar").innerHTML = "";
					document.getElementById("satilanlar").innerHTML = data.satin_alinan;
				}
				if (data.iptal_edilenler != undefined) {
					document.getElementById("iptal_edilenler").innerHTML = "";
					document.getElementById("iptal_edilenler").innerHTML = data.iptal_edilenler;
				}
			},
			error: function(data) {

			}
		});

	}

	function statu_guncelle() {
		var form = document.getElementById("formstatu");
		var formData = new FormData(form);
		$.ajax({
			url: "https://ihale.pertdunyasi.com/check.php",
			type: 'POST',
			data: formData,
			dataType: 'json',
			success: function(response) {
				if (response.status == 200) {
					if (response.kaldırma_islemi != "true") {
						swal({
							text: "Statü bilgileri kaydedildi üyeye SMS iletilsin mi?",
							buttons: {
								defeat: "Evet",
								catch: {
									text: "Hayır",
									value: "catch",
								}
							}
						}).then((value) => {

							switch (value) {
								case "defeat":
									$.ajax({
										url: "https://ihale.pertdunyasi.com/check.php",
										method: 'POST',
										dataType: 'json',
										data: {
											action: "statu_sms_gonder",
											teklif_id: $("#teklifler").val(),
											secim_id: $("#slct").val(),
											otomatik_mesaj: $("#otomatik_mesaj").val(),
										},
										success: function(data) {
											console.log(data);
											if (data.statu == 200) {
												alert("İşlem Başarılı");
											} else {
												alert(data.message);
											}
										},
										error: function(data) {

										}
									});
									break;
								case "catch":
									alert("İşlem Başarılı");
									//window.location.assign("?modul=ihaleler&sayfa=tum_ihaleler");
									window.location.reload();
									break;

								default:
									break;
							}
						});
					} else {
						alert(response.message);
						location.reload();

					}

				} else {
					alert(response.message)
				}
			},
			cache: false,
			contentType: false,
			processData: false
		});
	}

	function tekrar_sms_gonder() {
		$.ajax({
			url: "https://ihale.pertdunyasi.com/check.php",
			method: 'POST',
			dataType: 'json',
			data: {
				action: "statu_sms_gonder",
				teklif_id: $("#teklifler").val(),
				secim_id: $("#slct").val(),
				otomatik_mesaj: $("#otomatik_mesaj").val(),
			},
			success: function(data) {
				console.log(data);
				if (data.statu == 200) {
					alert("İşlem Başarılı");
				} else {
					alert(data.message);
				}
			},
			error: function(data) {

			}
		});
	}

	function birlestir() {
		var parcala1 = document.getElementById("parca_1").value;

		if (document.getElementById("parca_1").value.indexOf("₺") == -1) {
			document.getElementById("parca_1").value = document.getElementById("parca_1").value + "₺"
		}
	}

	function birlestir2() {

		var parcala2 = document.getElementById("parca_2").value;
		if (document.getElementById("parca_2").value.indexOf("₺") == -1) {
			document.getElementById("parca_2").value = document.getElementById("parca_2").value + "₺"
		}

	}

	function birlestir3() {

		var parcala3 = document.getElementById("parca_3").value;
		if (document.getElementById("parca_3").value.indexOf("₺") == -1) {
			document.getElementById("parca_3").value = document.getElementById("parca_3").value + "₺"
		}
	}

	function birlestir4() {

		var parcala4 = document.getElementById("mtv").value;
		if (document.getElementById("mtv").value.indexOf("₺") == -1) {
			document.getElementById("mtv").value = document.getElementById("mtv").value + "₺"
		}
	}

	function toplam_tutar_guncelle() {
		var kazandigi_tutar = $("#kazandigi_tutar").val();
		var statu_bilgisi = $("#statu_bilgisi").val();
		var dosya_masrafi = $("#dosya_masrafi").val();
		var mtv = $("#mtv").val();
		var noter = $("#noter").val();
		var parca_1 = $("#parca_1").val();
		var parca_2 = $("#parca_2").val();
		var parca_3 = $("#parca_3").val();
		var pd_hizmet = $("#pd_hizmet_hesaplı").val();
		$.ajax({
			url: "https://ihale.pertdunyasi.com/check.php",
			method: 'POST',
			dataType: 'json',
			data: {
				action: "toplam_tutar_guncelle",
				kazandigi_tutar: kazandigi_tutar,
				statu_bilgisi: statu_bilgisi,
				mtv: mtv,
				parca_1: parca_1,
				parca_2: parca_2,
				parca_3: parca_3,
				noter: noter,
				pd_hizmet: pd_hizmet,
				dosya_masrafi: dosya_masrafi,
			},
			success: function(data) {
				console.log(data);
				$("#kazanilan_teklif_text").html(formatMoney(kazandigi_tutar) + "₺");
				$("#toplam_odenecek_tutar").val(data.toplam_odenecek_tutar);
				$("#toplam_odenecek_tutar_text").html(formatMoney(data.toplam_odenecek_tutar) + "₺");
				if (data.durum == 0) {
					if (parseInt(parca_1) > 0 && parseInt(parca_2) > 0 && parseInt(parca_3) > 0) {
						$("#statu_kaydet").attr('disabled', 'disabled');
					}
				} else {
					if (parseInt(parca_1) > 0 && parseInt(parca_2) > 0 && parseInt(parca_3) > 0) {
						$('#statu_kaydet').removeAttr('disabled');
					}
				}
			},
			error: function(data) {

			}
		});
	}
</script>
<script>
	function not_indir(ids) {
		var split = ids.split(",");

		for (var i = 0; i < split.length; i++) {
			document.getElementById("dosya_" + split[i]).click();
		}
	}
</script>
<script>
	function odeme_pdf_file_click() {
		$("#odeme_bildirimi_dosya").click();
	}

	function parca_kaydet(ilan_id, parca_id) {
		var secilen_parca = "parca_" + parca_id;
		var secilen_parca_not = "parca_" + parca_id + "_not";
		var parca = $("#parca_" + parca_id).val();
		var parca_not = $("#parca_" + parca_id + "_not").val();
		$.ajax({
			url: "https://ihale.pertdunyasi.com/check.php",
			method: 'POST',
			dataType: 'json',
			data: {
				action: "parca_guncelle",
				ilan_id: ilan_id,
				parca: parca,
				parca_not: parca_not,
				secilen_parca: secilen_parca,
				secilen_parca_not: secilen_parca_not
			},
			success: function(data) {
				console.log(data);
			},
			error: function(data) {

			}
		});
	}

	function mtv_kaydet(ilan_id) {
		var mtv = $("#mtv").val();
		var mtv_not = $("#mtv_not").val();
		$.ajax({
			url: "https://ihale.pertdunyasi.com/check.php",
			method: 'POST',
			dataType: 'json',
			data: {
				action: "mtv_guncelle",
				ilan_id: ilan_id,
				mtv: mtv,
				mtv_not: mtv_not
			},
			success: function(data) {
				console.log(data);

			},
			error: function(data) {

			}
		});
	}

	function link_kopyala() {
		var copyText2 = document.getElementById("pdf_link_kopyala");
		copyText2.type = 'text';
		copyText2.select();
		document.execCommand("copy");
	}
</script>