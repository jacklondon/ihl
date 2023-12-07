<?php
session_start();
$admin_id = $_SESSION['kid'];
$admin_yetki_cek = mysql_query("Select * from kullanicilar where id='" . $admin_id . "' ");
$admin_yetki_oku = mysql_fetch_assoc($admin_yetki_cek);

$yetkiler = $admin_yetki_oku["yetki"];

$yetki_parcala = explode("|", $yetkiler);

if (!in_array(4, $yetki_parcala)) {
	echo '<script>alert("Bu Sayfaya Giriş Yetkiniz Yoktur")</script>';
	echo "<script>window.location.href = 'index.php'</script>";
}


$gelen_id = re("id");
$hepsini_cek = mysql_query("SELECT * FROM user WHERE id = $gelen_id LIMIT 1");
$sehir_cek = mysql_query("SELECT * FROM sehir ORDER BY plaka ASC");
$dogum_tarihi_cek = mysql_query("SELECT * FROM dogum_tarihi WHERE uye_id = '" . $gelen_id . "'");
$dogum_oku = mysql_fetch_assoc($dogum_tarihi_cek);
$dogum_tarihi = $dogum_oku['dogum_tarihi'];

if (!in_array(4, $yetki_parcala)) {
	$duzenle = "disabled";
}
if (!in_array(5, $yetki_parcala)) {
	$yetki_sekmesi = "disabled";
}
if (!in_array(6, $yetki_parcala)) {
	$cayma_sekmesi = "disabled";
}
?>

<style>
	a.disabled {
		pointer-events: none;
		cursor: default;
	}

	.yedek_input {
		margin-bottom: 5%;
		width: 90%;
	}

	.yedek_sil_input {
		margin-bottom: 6px;
		/* margin-top:20%;	 */
	}
</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" />
<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="js/il_ilce.js?v=17"></script>
<script src="js/uyeler_modal.js?v=<? echo time(); ?>"></script>
<script>
	window.onload = TriggerVarMi;
	function TriggerVarMi() {
		
		var trigger_sor = localStorage.getItem('trigger');
		if (trigger_sor != "" && trigger_sor != undefined) {
			console.log("tıklandı");
			document.getElementById(trigger_sor).click();
			localStorage.removeItem("trigger");
		}
	}

	function updateTrigger(id) {
		localStorage.setItem("trigger", id);
	}
</script>
<style>
	i {
		color: black;
		padding: 8px;
	}

	a {
		color: black;
		cursor: pointer;
	}
</style>
<div class="row-fluid">
	<?php
	$uye_cekmece = mysql_query("SELECT * FROM user WHERE id = $gelen_id LIMIT 1");
	$uye_okumaca = mysql_fetch_assoc($uye_cekmece);
	if ($uye_okumaca["user_token"] != "") {
		$uye_bilgi = $uye_okumaca["id"] . " - " . $uye_okumaca["ad"];
	} else if ($uye_okumaca["kurumsal_user_token"] != "") {
		$uye_bilgi = $uye_okumaca["id"] . " - " . $uye_okumaca["unvan"] . " / " . $uye_okumaca["ad"];
	}
	?>
	<div class="span12">
		<b style="float:right;font-size:20px;margin:10px;"> <?= $uye_bilgi ?> </b>
	</div>
</div>
<div class="tabbable">
	<!-- Only required for left/right tabs -->
	<ul class="nav nav-tabs">
		<li onclick="updateTrigger('kisiel_bilgiler_tab')"><a id="kisiel_bilgiler_tab" href="#kisisel_bilgiler" data-toggle="tab">Kişisel Bilgiler</a></li>
		<li onclick="updateTrigger('yetkiler_tab')"><a id="yetkiler_tab" href="#yetkiler" class="<?= $yetki_sekmesi ?>" data-toggle="tab">Yetkiler</a></li>
		<li onclick="updateTrigger('cayma_bedeli_tab')" class="active "><a id="cayma_bedeli_tab" href="#cayma_bedeli" class="<?= $cayma_sekmesi ?>" data-toggle="tab">Cayma Bedeli</a></li>
		<li onclick="updateTrigger('yuklenen_dosyalar_tab')"><a id="yuklenen_dosyalar_tab" href="#yuklenen_dosyalar" data-toggle="tab">Yüklenen Dosyalar</a></li>
	</ul>
	<!-- Tab İçerikleri Başlangıç -->
	<div class="tab-content">
		<!-- Kişisel Bilgiler Başlangıç -->
		<div class="tab-pane" id="kisisel_bilgiler">
			<strong class="mesaj"></strong>
			<form method="POST" enctype="multipart/form-data" id="data" name="data">
				<input type="hidden" name="action" value="panel_guncelle" />
				<?php
				$yedek_ad_input = "";
				$yedek_tel_input = "";
				$sil_buton = "";
				while ($hepsini_oku = mysql_fetch_array($hepsini_cek)) {
					if ($hepsini_oku["yedek_kisi"] != "") {
						$yedek_durum = true;
						$parcala = explode(",", $hepsini_oku["yedek_kisi"]);
						$parcala_2 = explode(",", $hepsini_oku["yedek_kisi_tel"]);
						for ($m = 0; $m < count($parcala); $m++) {
							$yedek_ad_input .= '  <input type="text" name="yedek_kisi[]" value="' . $parcala[$m] . '" placeholder="Adı" class="form-control yedek_input" >';
							$yedek_tel_input .= '  <input type="tel"  data-mask="0(000)000-0000" name="yedek_kisi_tel[]" value="' . $parcala_2[$m] . '" placeholder="Telefonu" class="form-control yedek_input" >';
							$sil_buton .= '<input style="" onclick="yedek_sil(' . $m . ')"  type="button" class=" btn btn-danger yedek_sil_input"  name="" value="Sil" /><br>';
						}
					} else {
						$yedek_durum = false;
					}
				?>
					<input type="hidden" name="user_id" value="<?= $hepsini_oku['id'] ?>" />
					<div class="row-fluid">
						<div class="span6">
							<label for="IDofInput">ID No</label>
							<input id="user_id" type="text" name="id_numara" value="<?= $hepsini_oku['id'] ?>" class="span12" disabled>
							<label <?php if ($hepsini_oku['unvan'] == "") {
										echo ('style="display:none;"');
									} ?> for="FirmaUnvanı">Firma Unvanı</label>
							<input <?php if ($hepsini_oku['unvan'] == "") {
										echo ('style="display:none;"');
									} ?> type="text" id="firma_unvani" readonly name="firma_unvani" value="<?= $hepsini_oku['unvan'] ?>" class="span12">
							<label for="AdveSoyad">Ad ve Soyad</label>
							<input id="ad_soyad" type="text" style="text-transform: capitalize;" name="ad_soyad" value="<?= $hepsini_oku['ad'] ?>" pattern="\b\w+\b(?:.*?\b\w+\b){1}" oninvalid="this.setCustomValidity('Lütfen ad ve soyad en az 2 kelime olacak şekilde giriniz.')" oninput="this.setCustomValidity('')" class="span12">
							<label for="dogumTarihi">Doğum Tarihi</label>
							<input id="dogum_tarihi" type="date" class="span12" value="<?= $dogum_tarihi ?>" name="dogum_tarihi">
							<div class="row-fluid">
								<div class="span6">
									<label for="TcKimlik">TC Kimlik Numarası</label>
									<input id="tc_kimlik" type="text" class="span12" onkeypress="return isNumberKey(event)" maxlength="11" value="<?= $hepsini_oku['tc_kimlik'] ?>" name="tc_kimlik">
									<label id="tc_kontrol"></label>
								</div>
								<div class="span6">
									<label for="Email">Email Adresi</label>
									<input id="email" type="text" value="<?= $hepsini_oku['mail'] ?>" class="span12" name="email">
									<label id="email_kontrol"></label>
								</div>
							</div>
							<div class="row-fluid">
								<div class="span4">
									<label for="Tel">Tel</label>
									<input id="sabit_tel" type="tel" value="<?= $hepsini_oku['sabit_tel'] ?>" class="span12" name="sabit_tel">
									<label id="sabit_tel_kontrol"></label>
								</div>
								<div class="span8">
									<label for="CepTel">Cep Tel</label>
									<input id="tel" type="tel" value="<?= $hepsini_oku['telefon'] ?>" class="span12" name="tel">
									<label id="tel_kontrol"></label>
								</div>
							</div>
							<div class="row-fluid">
								<div class="span6">
									<?php
									$dizi = explode("/", $hepsini_oku['sehir']);
									$sehir_adi = mysql_query("SELECT * FROM sehir WHERE sehiradi = '" . $hepsini_oku['sehir'] . "' ");
									while ($sehir_gel = mysql_fetch_array($sehir_adi)) {
										$sehir_id = $sehir_gel["sehirID"];
									}
									?>
									<label for="Il">İl</label>
									<select name="sehir" id="sehir" class="span12">
										<?php while ($sehir_oku = mysql_fetch_array($sehir_cek)) { ?>
											<option value="<?= $sehir_oku["sehirID"] ?>" <?= $sehir_oku["sehirID"] == $sehir_id ? "selected" : "" ?>><?= $sehir_oku["sehiradi"]; ?></option>
										<?php } ?>
									</select>
								</div>
								<div class="span6">
									<label for="Ilce">İlçe</label>
									<select name="ilce" id="ilce" class="span12" disabled>
										<option value="<?= $hepsini_oku['ilce'] ?>" selected><?= $hepsini_oku['ilce']  ?></option>
										<option value="">İlçe seçin</option>
									</select>
								</div>
							</div>
							<div class="row-fluid">
								<div class="span6">
									<label for="Meslek">Meslek</label>
									<input id="meslek" type="text" value="<?= $hepsini_oku['meslek'] ?>" class="span12" name="meslek">
								</div>
								<div class="span6">
									<label for="Cinsiyet">Cinsiyet</label>
									<select name="cinsiyet" id="cinsiyet" class="span12">
										<option value="<?= $hepsini_oku['cinsiyet'] ?>" selected><?= $hepsini_oku['cinsiyet'] ?></option>
										<option value="Erkek">Erkek</option>
										<option value="Kadın">Kadın</option>
									</select>
								</div>
							</div>
							<div class="row-fluid">
								<div class="span6">
									<label for="Sifre">Şifre</label>
									<input id="sifre" type="password" value="" autocomplete="off" class="span12" name="yeni_sifre">
									<input id="mevcut_sifre" type="hidden" value="<?= $hepsini_oku['sifre'] ?>" class="span12" name="sifre">
								</div>
								<div class="span6">
									<label for="Sifre">Şifre Tekrar</label>
									<input id="sifre_tekrar" type="password" class="span12" name="sifre_tekrar">
								</div>
							</div>
						</div>
						<!-- Kişisel Bilgiler Sağ taraf Başlangıç -->
						<div class="span6">
							<div class="row-fluid">
								<div class="span12">
									<label id="IDofInput" class="form-text text-muted">Size ulaşamadığımızda ulaşabileceğimiz kişiler</label>
									<input style="float:right;margin-bottom:5%;" type="button" onclick="yedek_ekle();" class=" btn btn-success" value="Ekle" />
								</div>
							</div>
							<div class="row-fluid">
								<div class="span5" id="yedek_ad_div">
									<?php if ($yedek_durum == false) { ?>
										<input name="yedek_kisi[]" type="text" class="form-control yedek_input" placeholder="Adı" value="">
									<?php } ?>
									<?= $yedek_ad_input ?>
								</div>

								<div class="span5" id="yedek_tel_div">
									<?php if ($yedek_durum == false) { ?>
										<input name="yedek_kisi_tel[]" data-mask="0(000)000-0000" type="tel" class="form-control yedek_input" placeholder="Telefonu" value="">
									<?php } ?>
									<?= $yedek_tel_input ?>
								</div>
								<div class="span2">
									<?= $sil_buton ?>
								</div>
							</div>
							<div class="row-fluid">
								<label for="UyeOlmaSebebi">Üye Olma Sebebi</label>
								<select name="sebep" id="sebep" class="span12">
									<option value="<?= $hepsini_oku['uye_olma_sebebi'] ?>" selected><?= $hepsini_oku['uye_olma_sebebi'] ?></option>
									<option value="Onarıp Kullanmak Amacıyla">Onarıp Kullanmak Amacıyla</option>
									<option value="Araç Alıp Satıyorum">Araç Alıp Satıyorum</option>
									<option value="Aracımı Satmak İstiyorum">Aracımı Satmak İstiyorum</option>
									<option value="Sadece Merak Ettim">Sadece Merak Ettim</option>
								</select>
							</div>
							<div class="row-fluid">
								<?php
								$ilgilendigi_tur = $hepsini_oku['ilgilendigi_turler'];
								$drm1 = false;
								$drm2 = false;
								$drm3 = false;
								$ilgilendigi_tur = explode(",", $ilgilendigi_tur);
								$dizi_ilg = array("Plakalı Ruhsatlı", "Çekme Belgeli", "Hurda Belgeli", "Otomobil", "Çekici ve Kamyon", "Dorse", "Motosiklet", "Traktör", "Sadece lüks segment");
								for ($v = 0; $v < count($dizi_ilg); $v++) {
									for ($g = 0; $g < count($ilgilendigi_tur); $g++) {
										if ($dizi_ilg[$v] == $ilgilendigi_tur[$g]) {
											if ($v == 0) {
												$drm1 = true;
											} else if ($v == 1) {
												$drm2 = true;
											} else if ($v == 2) {
												$drm3 = true;
											} else if ($v == 3) {
												$drm4 = true;
											} else if ($v == 4) {
												$drm5 = true;
											} else if ($v == 5) {
												$drm6 = true;
											} else if ($v == 6) {
												$drm7 = true;
											} else if ($v == 7) {
												$drm8 = true;
											} else {
												$drm9 = true;
											}
										}
									}
								}
								?>
								<label for="İlgilendigiTurler">İlgilendiği Araç Türleri</label>
								<!--<textarea name="ilgilendigi_turler" id="ilgilendigi_turler" class="span12" rows="3"><?= $hepsini_oku['ilgilendigi_turler'] ?></textarea>-->
								<text onclick="check('ilg1');" style="margin-right:2%;">Plakalı Ruhsatlı</text><input type="checkbox" id="ilg1" name="ilgilendigi[]" value="Plakalı Ruhsatlı" <?php if ($drm1 == true) echo 'checked'; ?> /><br>
								<text onclick="check('ilg2');" style="margin-right:2%;">Çekme Belgeli</text><input type="checkbox" id="ilg2" name="ilgilendigi[]" value="Çekme Belgeli" <?php if ($drm2 == true) echo 'checked'; ?> /><br>
								<text onclick="check('ilg3');" style="margin-right:2%;">Hurda Belgeli</text><input type="checkbox" id="ilg3" name="ilgilendigi[]" value="Hurda Belgeli" <?php if ($drm3 == true) echo 'checked'; ?> /><br>
								<text onclick="check('ilg3');" style="margin-right:2%;">Otomobil</text><input type="checkbox" id="ilg4" name="ilgilendigi[]" value="Otomobil" <?php if ($drm4 == true) echo 'checked'; ?> /><br>
								<text onclick="check('ilg3');" style="margin-right:2%;">Çekici ve Kamyon</text><input type="checkbox" id="ilg5" name="ilgilendigi[]" value="Çekici ve Kamyon" <?php if ($drm5 == true) echo 'checked'; ?> /><br>
								<text onclick="check('ilg3');" style="margin-right:2%;">Dorse</text><input type="checkbox" id="ilg6" name="ilgilendigi[]" value="Dorse" <?php if ($drm6 == true) echo 'checked'; ?> /><br>
								<text onclick="check('ilg3');" style="margin-right:2%;">Motosiklet</text><input type="checkbox" id="ilg7" name="ilgilendigi[]" value="Motosiklet" <?php if ($drm7 == true) echo 'checked'; ?> /><br>
								<text onclick="check('ilg3');" style="margin-right:2%;">Traktör</text><input type="checkbox" id="ilg8" name="ilgilendigi[]" value="Traktör" <?php if ($drm8 == true) echo 'checked'; ?> /><br>
								<text onclick="check('ilg3');" style="margin-right:2%;">Sadece lüks segment</text><input type="checkbox" id="ilg9" name="ilgilendigi[]" value="Sadece lüks segment" <?php if ($drm9 == true) echo 'checked'; ?> /><br>
							</div>
							<div class="row-fluid">
								<label for="KargoAdresi">Kargo Adresi</label>
								<textarea name="kargo_adresi" id="kargo_adresi" class="span12" rows="3"><?= $hepsini_oku['kargo_adresi'] ?></textarea>
							</div>
							<div <?php if ($hepsini_oku['kurumsal_user_token'] == "") {
										echo ('style="display:none;"');
									} ?> class="row-fluid">
								<div class="span6">
									<label for="VergiDairesi">Vergi Dairesi</label>
									<input type="text" id="vergi_dairesi" class="span12" value="<?= $hepsini_oku['vergi_dairesi'] ?>" name="vergi_dairesi">
								</div>
								<div class="span6">
									<label for="VergiNumarasi">Vergi Numarası</label>
									<input id="vergi_no" type="text" class="span12" value="<?= $hepsini_oku['vergi_dairesi_no'] ?>" name="vergi_no">
									<label id="vergi_no_kontrol"></label>
								</div>
							</div>
							<div class="row-fluid">
								<label for="FaturaAdresi">Fatura Adresi</label>
								<input type="text" id="fatura_adresi" class="span12" value="<?= $hepsini_oku['fatura_adresi'] ?>" name="fatura_adresi">
							</div>
							<div class="row-fluid">
								<div class="span6">
									<label for="KayitTarihi">Kayıt Tarihi</label>
									<input type="text" class="span12" value="<?= $hepsini_oku['kayit_tarihi'] ?>" name="kayit_tarihi" disabled>
								</div>
								<div class="span6">
									<label for="SonGiris">Son Giriş</label>
									<input type="text" class="span12" value="<?= $hepsini_oku['kayit_tarihi'] ?>" name="son_giris" disabled>
								</div>
							</div>
						</div>
					</div>
					<div class="row-fluid" style="margin-top: 3%;">
						<button type="button" style="background-color: rgb(88,103,221); color:white;" onclick="guncelle();" <?= $duzenle ?> class="btn ">Kaydet</button>
					</div>
			</form>
		</div>
		<!-- Kişisel Bilgiler Bitiş -->
		<!-- Yetkiler Başlangıç -->
		<div class="tab-pane" id="yetkiler">
			<?php if (in_array(5, $yetki_parcala)) { ?>
				<form id="	" method="POST">
					<input type="hidden" id="yetki_duzenle_uye_id" value="<?= $hepsini_oku['id'] ?>">
					<?php include 'islemler/uyeler/yetki_duzenle.php' ?>
					<div class="row-fluid">
						<?php
						$durum_cek = mysql_query("SELECT * FROM uye_durumlari WHERE uye_id = '" . $hepsini_oku['id'] . "'");
						$durum_sayisi = mysql_num_rows($durum_cek);
						$uye_yetki_cek = mysql_query("SELECT * FROM teklif_limiti WHERE uye_id = '" . $hepsini_oku['id'] . "'");
						$uye_yetki_oku = mysql_fetch_assoc($uye_yetki_cek);
						$uye_limiti = $uye_yetki_oku['teklif_limiti'];
						?>
						<?php
						while ($durum_oku = mysql_fetch_array($durum_cek)) {
							$uyenin_grubu_cek = mysql_query("SELECT * FROM uye_grubu");
							$uye_paket_cek = mysql_query("SELECT * FROM uye_grubu WHERE id = '" . $hepsini_oku['paket'] . "'");
							$uye_paket_oku = mysql_fetch_assoc($uye_paket_cek);
							$paket_limit = $uye_paket_oku['teklif_ust_limit']; ?>
							<div class="span6">
								<label for="Grup">GRUP</label>
								<select name="grup" id="grup" onchange="musteri_temsilcisi_kontrolu();" class="span12">
									<?php while ($uyenin_grubu_oku = mysql_fetch_array($uyenin_grubu_cek)) {
										if ($uyenin_grubu_oku["id"] != 2) { ?>
											<option value="<?= $uyenin_grubu_oku['id'] ?>" <?php if ($hepsini_oku['paket'] == $uyenin_grubu_oku['id']) { echo "selected"; } ?>><?= $uyenin_grubu_oku['grup_adi'] ?></option>
									<?php }
									} ?>
								</select>
								<div class="row-fluid">
									<div class="span6">
										<h6>Şu Tarihten Sonra Demo Üye Yap</h6>
									</div>
									<div class="span6">
										<input type="date" value="<?= $durum_oku['demo_olacagi_tarih'] ?>" class="span12" id="demo_olacagi_tarih" name="demo_olacagi_tarih">
									</div>
								</div>
								<b>Üye Teklif Limiti Belirleyin</b>
								<div class="row-fluid">
									<div class="span6">
										<label for="UyeTeklifLimiri">Standart Limit</label>
										<input type="text" class="span12" value="<?php if ($uye_yetki_oku['standart_limit'] > 0) { echo $uye_yetki_oku["standart_limit"]; } ?>" id="uye_standart_teklif_limiti" name="uye_standart_teklif_limiti">
									</div>
									<div class="span6">
										<label for="UyeTeklifLimiri">Ticari Limit</label>
										<input type="text" class="span12" value="<?php if ($uye_yetki_oku['luks_limit'] > 0) { echo $uye_yetki_oku["luks_limit"]; } ?>" id="uye_luks_teklif_limiti" name="uye_luks_teklif_limiti">
									</div>
									<input type="checkbox" <?php if ($durum_oku['hurda_teklif'] == "on") { echo "checked"; } ?> name="hurda_teklif_yetkisi" id="hurda_teklif_yetkisi">Hurda Belgelilere Teklif Verebilsin
								</div>
								<br>
								<div class="row-fluid">
									<?php $yetkili_cek = mysql_query("select * from kullanicilar where departman = 'Müşteri Temsilcisi' and durum <> 0"); ?>
									<label for="MusteriTemsilcisi">Müşteri Temsilcisi</label>
									<?php
									$yetkiler = $admin_yetki_oku["yetki"];
									$yetki_parcala = explode("|", $yetkiler);
									if (in_array(13, $yetki_parcala)) {
										$temsilci_degistirme_yetki = 1;
										$degistirme = "";
									}else{
										$temsilci_degistirme_yetki = 0;
										$degistirme = "disabled";
									}
										$uyenin_id = $hepsini_oku['id'];
										$mevcut_temsilci_cek = mysql_query("select * from user where id = '".$uyenin_id."'");
										$mevcut_temsilci_oku = mysql_fetch_object($mevcut_temsilci_cek);
										$mevcut_temsilci = $mevcut_temsilci_oku->temsilci_id;
										while($yetkili_oku = mysql_fetch_object($yetkili_cek)){
											$selected = "";
											if($yetkili_oku->id == $mevcut_temsilci){
												$selected = "selected";
											}
											$toplam_musterisi = mysql_num_rows(mysql_query("select * from user where temsilci_id = '".$yetkili_oku->id."'"));
											$option .= '<option '.$selected.' value="'.$yetkili_oku->id.'">'.$yetkili_oku->adi.' '.$yetkili_oku->soyadi.' ('.$toplam_musterisi.')</option>';
										}
									?>
										<input type="hidden" id="temsilci_degistirme_yetki" value="<?= $temsilci_degistirme_yetki ?>">
										<select id="musteri_temsilcisi" name="musteri_temsilcisi" class="span12" <?= $degistirme ?>>
											<?= $option ?>
											<option <?php if($hepsini_oku['temsilci_id'] == 0){echo "selected";} ?> value="0">Yetkilisi Yok (Sabit Numaradan Hizmet Alabilir)</option>
											<option value="-1">Otomatik Olarak Atansın</option>
										</select>

									<?php $yasak_sigorta_cek = mysql_query("SELECT * FROM sigorta_ozellikleri"); ?>
									<label for="YasakSigortaSirketi">Üye Sigorta Şirketi Yasak</label>

									<?php while ($yasak_sigorta_oku = mysql_fetch_array($yasak_sigorta_cek)) {
										$yasak_parcala = explode(",", $durum_oku['yasak_sigorta']);
										$yasak_durum = "";
										foreach ($yasak_parcala as $yasaklar) {
											if ($yasak_sigorta_oku["id"] == $yasaklar) {
												$yasak_durum = "checked";
											}
										}
									?>
										<input type="checkbox" <?= $yasak_durum ?> name="yasak_sigorta[]" id="yasak_sigorta<?= $yasak_sigorta_oku['id'] ?>" value="<?= $yasak_sigorta_oku['id'] ?>"><?= $yasak_sigorta_oku['sigorta_adi'] ?> <br />
									<?php } ?>
								</div>
							</div>
							<!-- Yetkiler Sağ taraf Başlangıç -->
							<div class="span6">
								<div class="row-fluid">
									<input type="checkbox" name="kalici_mesaj" id="kalici_mesaj" <?php if ($durum_oku['kalici_mesaj'] == "on") { echo "checked"; } ?>> Kalıcı sistem mesajı
								</div>
								<br>
								<div class="row-fluid">
									<label for="KaliciSistemMesaji">Kalıcı Sistem Mesajı</label>
									<textarea name="kalici_sistem_mesaji" id="kalici_sistem_mesaji" class="span12" rows="3"><?= $durum_oku['kalici_sistem_mesaji'] ?></textarea>
								</div>
								<div class="row-fluid">
									<input type="checkbox" name="otomatik_risk_engelle" id="otomatik_risk_engelle" value="on" <?php if ($durum_oku['otomatik_teklif_engelle'] == "on") { echo "checked"; } ?>> Risk nedeniyle engel durumu
								</div>
								<div class="row-fluid">
									<input type="checkbox" name="teklif_vermesini_engelle" id="teklif_vermesini_engelle" value="on" <?php if ($durum_oku['teklif_engelle'] == "on") { echo "checked"; } ?>> Teklif vermesini engellemek için tıklayınız
								</div>
								<br>
								<div class="row-fluid">
									<label for="UyeyiEngellemeNedeni">Üyeyi Engelleme Nedeni</label>
									<textarea name="uyeyi_engelleme_nedeni" id="uyeyi_engelleme_nedeni" class="span12" rows="3"><?= $durum_oku['engelleme_nedeni'] ?></textarea>
								</div>
								<div class="row-fluid">
									<input type="checkbox" name="uyelik_iptali" id="uyelik_iptali" <?php if ($durum_oku['uyelik_iptal'] == "on") { echo "checked"; } ?>> Üyelik iptali için işaretleyin
								</div>
								<br>
								<div class="row-fluid">
									<label for="UyeyiEngellemeNedeni">Üyelik İptal Nedeni</label>
									<textarea name="uyelik_iptal_nedeni" id="uyelik_iptal_nedeni" class="span12" rows="3"><?= $durum_oku['uyelik_iptal_nedeni'] ?></textarea>
								</div>
							</div>
						<?php } ?>
					</div>
					<div class="row-fluid">
						<input type="button" onclick="yetkiyiKaydet();" class="btn-primary" name="yetkiyi" value="Kaydet">
					</div>
				</form>
		</div>
	<?php } ?>
	<!-- Yetkiler Bitiş -->
	<!-- Cayma Bedeli Başlangıç -->
	<?php
					/*$uyenin_aktif_caymasi = mysql_query("SELECT SUM(net) FROM cayma_bedelleri WHERE uye_id = '".$hepsini_oku['id']."' AND durum=1");
			$uye_aktif_bedel = mysql_fetch_assoc($uyenin_aktif_caymasi);
			$aktif_bedel = $uye_aktif_bedel['SUM(net)'];
			$uye_borc_cayma = mysql_query("SELECT SUM(net) FROM cayma_bedelleri WHERE uye_id = '".$hepsini_oku['id']."' AND durum=2"); 
			$uye_borc_bedel = mysql_fetch_assoc($uye_borc_cayma);
			$borc_bedel = $uye_borc_bedel['SUM(net)'];
			$toplam_cayma = $aktif_bedel + $borc_bedel;*/
					$aktif_cayma_toplam = mysql_query("
				SELECT 
					SUM(tutar) as toplam_aktif_cayma
				FROM
					cayma_bedelleri
				WHERE
					uye_id='" . $gelen_id . "' AND
					durum=1
			");
					$toplam_aktif_cayma = mysql_fetch_assoc($aktif_cayma_toplam);
					$iade_talepleri_toplam = mysql_query("
				SELECT 
					SUM(tutar) as toplam_iade_talepleri
				FROM
					cayma_bedelleri
				WHERE
					uye_id='" . $gelen_id . "' AND
					durum=2
			");
					$toplam_iade_talepleri = mysql_fetch_assoc($iade_talepleri_toplam);
					$borclar_toplam = mysql_query("
				SELECT 
					SUM(tutar) as toplam_borclar
				FROM
					cayma_bedelleri
				WHERE
					uye_id='" . $gelen_id . "' AND
					durum=6
			");
					$toplam_borclar = mysql_fetch_assoc($borclar_toplam);
					// $toplam_cayma=$toplam_aktif_cayma["toplam_aktif_cayma"]-$toplam_iade_talepleri["toplam_iade_talepleri"]-$toplam_borclar["toplam_borclar"];
					$toplam_cayma = $toplam_aktif_cayma["toplam_aktif_cayma"] - $toplam_borclar["toplam_borclar"];
	?>
	<div class="active tab-pane" id="cayma_bedeli">
		<?php if (in_array(6, $yetki_parcala)){ ?>
			<div class="row-fluid">
				<div class="span8">
					<div class="row-fluid">
						<h4 style="color:grey">TOPLAM CAYMA BEDELİ: <text style="color:#000;font-size:20px;font-weight:bold"> <?= money($toplam_cayma) ?> ₺<text></h4>
					</div>
				</div>
				<div class="span2">
					<button class="btn" name="cayma_bedeli" style="background-color: #8c2e2e; color:white;">
						<a id="<?= $hepsini_oku['id'] ?>" class="view_yeni_borc" role="button" data-toggle="modal" style="color: white;">BORÇ EKLE</a>
					</button>
				</div>
				<div class="span2">
					<button class="btn" name="cayma_bedeli" style="background-color: #8c2e2e; color:white;">
						<a id="<?= $hepsini_oku['id'] ?>" class="view_yeni_cayma" role="button" data-toggle="modal" style="color: white;">CAYMA BEDELİ EKLE</a>
					</button>
				</div>
			</div>
			<?php

						$aktif_cayma = mysql_query("SELECT * FROM cayma_bedelleri WHERE uye_id='" . $gelen_id . "' AND durum=1 ");
						if (mysql_num_rows($aktif_cayma) > 0) { ?>
				<div class="row-fluid">
					<h4 style="font-weight:bold">AKTİF CAYMA BEDELLERİ</h4>
				</div>
				<style>
					.no_border td {
						border-style: none;
					}
				</style>
				<div class="row-fluid">
					<div style="overflow-x:auto; overflow-y:auto;">
						<table class="table table-bordered">
							<thead>
								<tr style="background-color:green;color:white;">
									<th>ID</th>
									<th>Paranın geldiği tarih</th>
									<th>Parayı gönderen</th>
									<th>IBAN</th>
									<th>Tutar</th>
									<th>Açıklamalar</th>
									<th>İşlem</th>
								</tr>
							</thead>
							<tbody>
								<?php
								 while ($aktif_cayma_oku = mysql_fetch_array($aktif_cayma)) { 
									if(count($yetki_parcala) == 13){
										$cayma_sil_btn = '<text style="cursor: pointer;" onclick="cayma_sil(\''.$aktif_cayma_oku["id"].'\');">Sil -</text>';
									}else{
										$cayma_sil_btn = "";
									}
								?>
									<tr class="no_border" id="cayma_<?= $aktif_cayma_oku["id"] ?>">
										<td><?= $aktif_cayma_oku["id"] ?></td>
										<td><?= date("d-m-Y", strtotime($aktif_cayma_oku["paranin_geldigi_tarih"])) ?></td>
										<td><?= $aktif_cayma_oku["hesap_sahibi"] ?></td>
										<td>TR<?= $aktif_cayma_oku["iban"] ?></td>
										<td><?= money($aktif_cayma_oku["tutar"]) ?>₺</td>
										<td><?= $aktif_cayma_oku["aciklama"] ?></td>
										<!-- <td><text style="cursor: pointer;" onclick="cayma_sil('<?= $aktif_cayma_oku['id'] ?>');">Sil</text> - <a id="<?= $aktif_cayma_oku["id"] ?>" class="view_duzenle_cayma">Düzenle</a></td> -->
										<td><?= $cayma_sil_btn ?> <a id="<?= $aktif_cayma_oku["id"] ?>" class="view_duzenle_cayma">Düzenle</a></td>
									</tr>
								<?php } ?>
							</tbody>
						</table>
					</div>
				</div>
			<?php }
						$iade_talepleri = mysql_query("SELECT * FROM cayma_bedelleri WHERE uye_id='" . $gelen_id . "' AND durum=2");
						if (mysql_num_rows($iade_talepleri) > 0) { ?>
				<div class="row-fluid">
					<div class="row-fluid">
						<h4 style="font-weight:bold">İADE TALEPLERİ</h4>
					</div>
					<div class="row-fluid">
						<div style="overflow-x:auto; overflow-y:auto;">
							<table class="table table-bordered">
								<thead>
									<tr style="background-color:blue;color:white;">
										<th>ID</th>
										<th>Paranın geldiği tarih</th>
										<th>Parayı gönderen</th>
										<th>IBAN</th>
										<th>Tutar</th>
										<th>Açıklamalar</th>
										<th>İşlem</th>
									</tr>
								</thead>
								<tbody>
									<?php while ($iade_talepleri_oku = mysql_fetch_array($iade_talepleri)) { ?>
										<tr class="no_border">
											<td><?= $iade_talepleri_oku["id"] ?></td>
											<td><?= date("d-m-Y", strtotime($iade_talepleri_oku["paranin_geldigi_tarih"])) ?></td>
											<td><?= $iade_talepleri_oku["hesap_sahibi"] ?></td>
											<td>TR<?= $iade_talepleri_oku["iban"] ?></td>
											<td><?= money($iade_talepleri_oku["tutar"]) ?>₺</td>
											<td><?= $iade_talepleri_oku["aciklama"] ?></td>
											<!-- <td><a id="<?= $iade_talepleri_oku["id"] ?>" class="view_talepleri">Düzenle</a></td> -->
											<td><a id="<?= $iade_talepleri_oku["id"] ?>" class="view_duzenle_cayma">Düzenle</a></td>
										</tr>
									<?php } ?>
								</tbody>
							</table>
							<input type="hidden" id="gelen_id" value="<?= $gelen_id ?>">
						</div>
					</div>
				</div>
			<?php }
						$iade_edilenler = mysql_query("SELECT * FROM cayma_bedelleri WHERE uye_id='" . $gelen_id . "' AND durum=3");
						if (mysql_num_rows($iade_edilenler) > 0) { ?>
				<div class="row-fluid">
					<div class="row-fluid">
						<h4 style="font-weight:bold">İADE EDİLENLER</h4>
					</div>
					<div class="row-fluid">
						<div style="overflow-x:auto; overflow-y:auto;">
							<table class="table table-bordered">
								<thead>
									<tr style="background-color:grey;color:white;">
										<th>ID</th>
										<th>Paranın geldiği tarih</th>
										<th>İade Tarihi</th>
										<th>Hesap Sahibi</th>
										<th>IBAN</th>
										<th>Tutar</th>
										<th>Açıklamalar</th>
										<th>İşlem</th>
									</tr>
								</thead>
								<tbody>
									<?php 
									while ($iade_edilenler_oku = mysql_fetch_array($iade_edilenler)) { 
										if(count($yetki_parcala) == 13){
											$cayma_sil_btn = '<text style="cursor: pointer;" onclick="cayma_sil(\''.$iade_edilenler_oku["id"].'\');">Sil -</text>';
										}else{
											$cayma_sil_btn = "";
										}
									?>
										<tr class="no_border" id="cayma_<?= $aktif_cayma_oku["id"] ?>">
											<td><?= $iade_edilenler_oku["id"] ?></td>
											<td><?= date("d-m-Y", strtotime($iade_edilenler_oku["paranin_geldigi_tarih"])) ?></td>
											<td><?= date("d-m-Y", strtotime($iade_edilenler_oku["iade_tarihi"])) ?></td>
											<td><?= $iade_edilenler_oku["hesap_sahibi"] ?></td>
											<td>TR<?= $iade_edilenler_oku["iban"] ?></td>
											<td><?= money($iade_edilenler_oku["tutar"]) ?>₺</td>
											<td><?= $iade_edilenler_oku["aciklama"] ?></td>
											<td><?= $cayma_sil_btn ?> <a id="<?= $iade_edilenler_oku["id"] ?>" class="view_duzenle_cayma">Düzenle</a></td>
										</tr>
									<?php } ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			<?php } ?>
			<script>
				function islemYapamazsin() {
					swal("Dikkat", "İade edilmiş ya da iade isteği satırları iptal etmeden aktif satırı iptal edemezsiniz.", "error");
				}
			</script>
			<?php $mahsup_edilenler = mysql_query("SELECT * FROM cayma_bedelleri WHERE uye_id='" . $gelen_id . "' AND durum=4");
						if (mysql_num_rows($mahsup_edilenler) > 0) { ?>
				<div class="row-fluid">
					<div class="row-fluid">
						<h4 style="font-weight:bold">ARAÇ BEDELİNE MAHSUP EDİLENLER</h4>
					</div>
					<div class="row-fluid">
						<div style="overflow-x:auto; overflow-y:auto;">
							<table class="table table-bordered">
								<thead>
									<tr style="background-color:grey;color:white;">
										<th>ID</th>
										<th>Paranın geldiği tarih</th>
										<th>Mahsup Tarihi</th>
										<th>Konu Araç</th>
										<th>Tutar</th>
										<th>Açıklamalar</th>
										<th>İşlem</th>
									</tr>
								</thead>
								<tbody>
									<?php 
									while ($mahsup_edilenler_oku = mysql_fetch_array($mahsup_edilenler)) {

										$ilan_sorgu = mysql_query("SELECT * FROM ilanlar WHERE plaka='" . $mahsup_edilenler_oku["arac_kod_plaka"] . "' or arac_kodu='" . $mahsup_edilenler_oku["arac_kod_plaka"] . "'");
										$ilani_cek = mysql_fetch_assoc($ilan_sorgu);
										if (mysql_num_rows($ilan_sorgu) > 0) {
											$href = "../arac_detay.php?id=" . $ilani_cek["id"] . "&q=ihale";
										} else {
											$href = "#";
										}
										if(count($yetki_parcala) == 13){
											$cayma_sil_btn = '<text style="cursor: pointer;" onclick="cayma_sil(\''.$mahsup_edilenler_oku["id"].'\');">Sil -</text>';
										}else{
											$cayma_sil_btn = "";
										}
									?>
										<tr class="no_border" id="cayma_<?= $aktif_cayma_oku["id"] ?>">
											<td><?= $mahsup_edilenler_oku["id"] ?></td>
											<td><?= date("d-m-Y", strtotime($mahsup_edilenler_oku["paranin_geldigi_tarih"])) ?></td>
											<td><?= date("d-m-Y", strtotime($mahsup_edilenler_oku["mahsup_tarihi"])) ?></td>
											<td><a href="<?= $href ?>"><?= $mahsup_edilenler_oku["arac_detay"] ?></a></td>
											<td><?= money($mahsup_edilenler_oku["tutar"]) ?>₺</td>
											<td><?= $mahsup_edilenler_oku["aciklama"] ?></td>
											<td><?= $cayma_sil_btn ?> <a id="<?= $mahsup_edilenler_oku["id"] ?>" class="view_duzenle_cayma">Düzenle</a></td>
										</tr>
									<?php } ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			<?php }
						$cayilan_araclar = mysql_query("SELECT * FROM cayma_bedelleri WHERE uye_id='" . $gelen_id . "' AND durum=5");
						if (mysql_num_rows($cayilan_araclar) > 0) { ?>
				<div class="row-fluid">
					<div class="row-fluid">
						<h4 style="font-weight:bold">CAYILAN ARAÇLAR</h4>
					</div>
					<div class="row-fluid">
						<div style="overflow-x:auto; overflow-y:auto;">
							<table class="table table-bordered">
								<thead>
									<tr style="background-color:grey;color:white;">
										<th>ID</th>
										<th>Paranın geldiği tarih</th>
										<th>Bloke Tarihi</th>
										<th>Konu Araç</th>
										<th>Tutar</th>
										<th>Açıklamalar</th>
										<th>İşlem</th>
									</tr>
								</thead>
								<tbody>
									<?php while ($cayilan_araclar_oku = mysql_fetch_array($cayilan_araclar)) {
										$ilan_sorgu = mysql_query("SELECT * FROM ilanlar WHERE plaka='" . $cayilan_araclar_oku["arac_kod_plaka"] . "' or arac_kodu='" . $cayilan_araclar_oku["arac_kod_plaka"] . "'");
										$ilani_cek = mysql_fetch_assoc($ilan_sorgu);
										if (mysql_num_rows($ilan_sorgu) > 0) {
											$href = "../arac_detay.php?id=" . $ilani_cek["id"] . "&q=ihale";
										} else {
											$href = "#";
										}
										if(count($yetki_parcala) == 13){
											$cayma_sil_btn = '<text style="cursor: pointer;" onclick="cayma_sil(\''.$cayilan_araclar_oku["id"].'\');">Sil -</text>';
										}else{
											$cayma_sil_btn = "";
										}
									?>
										<tr class="no_border" id="cayma_<?= $aktif_cayma_oku["id"] ?>">
											<td><?= $cayilan_araclar_oku["id"] ?></td>
											<td><?= date("d-m-Y", strtotime($cayilan_araclar_oku["paranin_geldigi_tarih"])) ?></td>
											<td><?= date("d-m-Y", strtotime($cayilan_araclar_oku["bloke_tarihi"])) ?></td>
											<td><a href="<?= $href ?>"><?= $cayilan_araclar_oku["arac_detay"] ?></a></td>
											<td><?= money($cayilan_araclar_oku["tutar"]) ?>₺</td>
											<td><?= $cayilan_araclar_oku["aciklama"] ?></td>
											<td><?= $cayma_sil_btn ?> <a id="<?= $cayilan_araclar_oku["id"] ?>" class="view_duzenle_cayma">Düzenle</a></td>
										</tr>
									<?php } ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			<?php }
						$bekleyen_borclar = mysql_query("SELECT * FROM cayma_bedelleri WHERE uye_id='" . $gelen_id . "' AND durum=6");
						if (mysql_num_rows($bekleyen_borclar) > 0) { ?>
				<div class="row-fluid">
					<div class="row-fluid">
						<h4 style="font-weight:bold">BLOKE İÇİN BEKLEYEN BORÇLAR</h4>
					</div>
					<div class="row-fluid">
						<div style="overflow-x:auto; overflow-y:auto;">
							<table class="table table-bordered">
								<thead>
									<tr style="background-color:grey;color:white;">
										<th>ID</th>
										<th>Borç Tarihi</th>
										<th>Tutar</th>
										<th>Konu Araç</th>
										<th>Açıklamalar</th>
										<th>İşlem</th>
									</tr>
								</thead>
								<tbody>
									<?php while ($bekleyen_borclar_oku = mysql_fetch_array($bekleyen_borclar)) {
										$ilan_sorgu = mysql_query("SELECT * FROM ilanlar WHERE plaka='" . $bekleyen_borclar_oku["arac_kod_plaka"] . "' or arac_kodu='" . $bekleyen_borclar_oku["arac_kod_plaka"] . "'");
										$ilani_cek = mysql_fetch_assoc($ilan_sorgu);
										if (mysql_num_rows($ilan_sorgu) > 0) {
											$href = "../arac_detay.php?id=" . $ilani_cek["id"] . "&q=ihale";
										} else {
											$href = "#";
										}
										if(count($yetki_parcala) == 13){
											$cayma_sil_btn = '<text style="cursor: pointer;" onclick="cayma_sil(\''.$bekleyen_borclar_oku["id"].'\');">Sil -</text>';
										}else{
											$cayma_sil_btn = "";
										}
									?>
										<tr class="no_border" id="cayma_<?= $aktif_cayma_oku["id"] ?>">
											<td><?= $bekleyen_borclar_oku["id"] ?></td>
											<td><?= date("d-m-Y", strtotime($bekleyen_borclar_oku["bloke_tarihi"])) ?></td>
											<td><?= money($bekleyen_borclar_oku["tutar"]) ?>₺</td>
											<td><a href="<?= $href ?>"><?= $bekleyen_borclar_oku["arac_detay"] ?></a></td>
											<td><?= $bekleyen_borclar_oku["aciklama"] ?></td>
											<td><?= $cayma_sil_btn ?> <a id="<?= $bekleyen_borclar_oku["id"] ?>" class="view_duzenle_cayma">Düzenle</a></td>
										</tr>
									<?php } ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			<?php }
						$tahsil_edilmis_borclar = mysql_query("SELECT * FROM cayma_bedelleri WHERE uye_id='" . $gelen_id . "' AND durum=7 ");
						if (mysql_num_rows($tahsil_edilmis_borclar) > 0) { ?>
				<div class="row-fluid">
					<div class="row-fluid">
						<h4 style="font-weight:bold">TAHSİL EDİLMİŞ BLOKELİ BORÇLAR</h4>
					</div>
					<div class="row-fluid">
						<div style="overflow-x:auto; overflow-y:auto;">
							<table class="table table-bordered">
								<thead>
									<tr style="background-color:grey;color:white;">
										<th>ID</th>
										<th>Bloke Tarihi</th>
										<th>Tahsil Tarihi</th>
										<th>Konu Araç</th>
										<th>Tutar</th>
										<th>Açıklamalar</th>
										<th>İşlem</th>
									</tr>
								</thead>
								<tbody>
									<?php while ($tahsil_edilmis_borclar_oku = mysql_fetch_array($tahsil_edilmis_borclar)) {
										$ilan_sorgu = mysql_query("SELECT * FROM ilanlar WHERE plaka='" . $tahsil_edilmis_borclar_oku["arac_kod_plaka"] . "' or arac_kodu='" . $tahsil_edilmis_borclar_oku["arac_kod_plaka"] . "'");
										$ilani_cek = mysql_fetch_assoc($ilan_sorgu);
										if (mysql_num_rows($ilan_sorgu) > 0) {
											$href = "../arac_detay.php?id=" . $ilani_cek["id"] . "&q=ihale";
										} else {
											$href = "#";
										}
										if(count($yetki_parcala) == 13){
											$cayma_sil_btn = '<text style="cursor: pointer;" onclick="cayma_sil(\''.$tahsil_edilmis_borclar_oku["id"].'\');">Sil -</text>';
										}else{
											$cayma_sil_btn = "";
										}
									?>
										<tr class="no_border" id="cayma_<?= $aktif_cayma_oku["id"] ?>">
											<td><?= $tahsil_edilmis_borclar_oku["id"] ?></td>
											<td><?= date("d-m-Y", strtotime($tahsil_edilmis_borclar_oku["bloke_tarihi"])) ?></td>
											<td><?= date("d-m-Y", strtotime($tahsil_edilmis_borclar_oku["tahsil_tarihi"])) ?></td>
											<td><a href="<?= $href ?>"><?= $tahsil_edilmis_borclar_oku["arac_detay"] ?></td>
											<td><?= money($tahsil_edilmis_borclar_oku["tutar"]) ?>₺</td>
											<td><?= $tahsil_edilmis_borclar_oku["aciklama"] ?></td>
											<td><?= $cayma_sil_btn ?> <a id="<?= $tahsil_edilmis_borclar_oku["id"] ?>" class="view_duzenle_cayma">Düzenle</a></td>
										</tr>
									<?php } ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			<?php }  ?>
	</div>
<? } ?>
<!-- Cayma Bedeli Bitiş -->
<!-- Yüklenen Dosyalar Başlangıç -->
<div class="tab-pane" id="yuklenen_dosyalar">
	<?php
					/* $evrak_cek = mysql_query("SELECT * FROM yuklenen_evraklar WHERE user_id='".$gelen_id."'");
					$notunu_cek = mysql_query("SELECT * FROM uye_notlari WHERE uye_id = '".$gelen_id."'");*/
					/*$evrak_cek=mysql_query("
					SELECT 
						yuklenen_evraklar.*,-1 as ekleyen 
					FROM
						yuklenen_evraklar 
					WHERE 
						yuklenen_evraklar.user_id='".$gelen_id."'
					UNION 
						SELECT
							uye_notlari.id,
							uye_notlari.uye_id,
							uye_notlari.dosya,
							uye_notlari.tarih,
							uye_notlari.uye_notu,
							uye_notlari.gizlilik,
							uye_notlari.ekleyen 
						FROM
							uye_notlari 
						WHERE
							uye_notlari.uye_id='".$gelen_id."'
						ORDER BY
							gonderme_zamani
						desc
				");*/
					$evrak_cek = mysql_query("
					SELECT 
						yuklenen_evraklar.*,-1 as ekleyen , 'yuklenen_evraklar' as tablo
					FROM
						yuklenen_evraklar 
					WHERE 
						yuklenen_evraklar.user_id='" . $gelen_id . "'
                    GROUP BY 
                    	gonderme_zamani
					UNION 
						SELECT
							uye_notlari.id,
							uye_notlari.uye_id,
							uye_notlari.dosya,
							uye_notlari.tarih,
							uye_notlari.uye_notu,
							uye_notlari.gizlilik,
							uye_notlari.ekleyen,
                            'uye_notlari'
						FROM
							uye_notlari 
						WHERE
							uye_notlari.uye_id='" . $gelen_id . "'
                        GROUP BY 
                        	uye_notlari.tarih
						ORDER BY
							gonderme_zamani
						desc
				");
			// 	var_dump("
			// 	SELECT 
			// 		yuklenen_evraklar.*,-1 as ekleyen , 'yuklenen_evraklar' as tablo
			// 	FROM
			// 		yuklenen_evraklar 
			// 	WHERE 
			// 		yuklenen_evraklar.user_id='" . $gelen_id . "'
			// 	GROUP BY 
			// 		gonderme_zamani
			// 	UNION 
			// 		SELECT
			// 			uye_notlari.id,
			// 			uye_notlari.uye_id,
			// 			uye_notlari.dosya,
			// 			uye_notlari.tarih,
			// 			uye_notlari.uye_notu,
			// 			uye_notlari.gizlilik,
			// 			uye_notlari.ekleyen,
			// 			'uye_notlari'
			// 		FROM
			// 			uye_notlari 
			// 		WHERE
			// 			uye_notlari.uye_id='" . $gelen_id . "'
			// 		GROUP BY 
			// 			uye_notlari.tarih
			// 		ORDER BY
			// 			gonderme_zamani
			// 		desc
			// ");
					$sira = 1;
	?>
	<table class="table table-bordered table-striped">
		<thead>
			<tr>
				<th>Sıra</th>
				<th>Ekleme Tarihi</th>
				<th>Ekleyen</th>
				<th>Not</th>
				<th>Dosya</th>
			</tr>
		</thead>
		<tbody>
			<?php while ($evrak_oku = mysql_fetch_array($evrak_cek)) {
						$tablo_adi = $evrak_oku["tablo"];
						if ($tablo_adi == "uye_notlari") {
							$dosya = "dosya";
							$kosul = "WHERE tarih='" . $evrak_oku['gonderme_zamani'] . "' and uye_id='" . $gelen_id . "'";

							$sql2 = mysql_query("SELECT * FROM ".$tablo_adi."  ".$kosul."");
							$evrak = '';
							$evrak2 = '';
							$c = 0;
							$ids = "";
							if ($evrak_oku["icerik"] != "1") {
								while ($evrak_oku2 = mysql_fetch_array($sql2)) {
									if ($c != mysql_num_rows($sql2) - 1) {
										$ids .= $evrak_oku2["id"] . ",";
									} else {
										$ids .= $evrak_oku2["id"];
									}
									$evrak .= '<a href="../assets/' . $evrak_oku2[$dosya] . '" target="_blank">' . $evrak_oku2[$dosya] . '</a><br/>
									<a hidden id="dosya_' . $evrak_oku2["id"] . '" href="../assets/' . $evrak_oku2[$dosya] . '" download="../assets/' . $evrak_oku2[$dosya] . '" >' . $evrak_oku2[$dosya] . ' </a>';
									$evrak2 .= '<a hidden id="dosya_' . $evrak_oku2["id"] . '" href="../assets/' . $evrak_oku2[$dosya] . '" download="../assets/' . $evrak_oku2[$dosya] . '" >' . $evrak_oku2[$dosya] . ' </a><br/>';
									$c++;
								}
								$evrak .= '<button type="button" onclick="uye_not_indir(\'' . $ids . '\');" class="button btn-primary" >Tümünü İndir</button>';
							} else {
								$evrak = '';
								$evrak2 = '';
							}
							$evrak2 = '';
							if ($evrak_oku['ekleyen'] == "-1") {
								$user_cek = mysql_query("select * from user where id='" . $gelen_id . "'");
								$user_oku = mysql_fetch_object($user_cek);
								if ($user_oku->user_token != "") {
									$ekleyen = $user_oku->ad;
								} else {
									$ekleyen = $user_oku->unvan . " / " . $user_oku->ad;
								}
							} else {
								$kullanici_cek = mysql_query("select * from kullanicilar where id='" . $evrak_oku["ekleyen"] . "'");
								$kullanici_oku = mysql_fetch_object($kullanici_cek);
								$ekleyen = 'Admin->' . $kullanici_oku->adi . " " . $kullanici_oku->soyadi;
							}
						} else {
							// $kosul = "WHERE gonderme_zamani='" . $evrak_oku['gonderme_zamani'] . "' and user_id='" . $gelen_id . "'";
							// $dosya = "icerik";
							$cek = mysql_query("select * from yuklenen_evrak_dosya where evrak_id = '".$evrak_oku["id"]."'");
							$evrak = "";
							$evrak2 = "";
							$ids = "";
							$c = 0;
							while($oku = mysql_fetch_object($cek)){
								if ($c != mysql_num_rows($cek) - 1) {
									$ids .= $evrak_oku["id"]."_".$oku->id . ",";
								} else {
									$ids .= $evrak_oku["id"]."_".$oku->id;
								}
								$evrak .= '<a href="../assets/' . $oku->icerik . '" target="_blank">' . $oku->icerik . '</a><br/>
								<a hidden id="dosya_' . $evrak_oku["id"]."_".$oku->id . '" href="../assets/' . $oku->icerik . '" download="../assets/' . $oku->icerik . '" >' . $oku->icerik . ' </a>';
								$evrak2 .= '<a hidden id="dosya_' . $evrak_oku["id"]."_".$oku->id . '" href="../assets/' . $oku->icerik . '" download="../assets/' . $oku->icerik . '" >' . $oku->icerik . ' </a><br/>';
								$c++;
							}
							if(mysql_num_rows($cek) != 0){
								$evrak .= '<button type="button" onclick="uye_not_indir(\'' . $ids . '\');" class="button btn-primary" >Tümünü İndir</button>';
							}
						}
						//var_dump("SELECT * FROM ".$tablo_adi." ".$kosul." ");
						

			?>
				<tr>
					<td><?= $sira++ ?></td>
					<td><?= date("d-m-Y H:i:s", strtotime($evrak_oku['gonderme_zamani'])) ?></td>
					<td><?= $ekleyen ?></td>
					<td><?= $evrak_oku['not']  ?></td>

					<td><?= $evrak . $evrak2 ?></td>

				</tr>
			<?php } ?>
			<?php /*while($notu_oku = mysql_fetch_array($notunu_cek)){?>
					 <tr>
						<td><?= $sira++ ?></td>
						<td><a href="../assets/<?=$evrak_oku['dosya'] ?>" target="_blank"><?= $evrak_oku['dosya'] ?></a></td>
						<td><?= $evrak_oku['gonderme_zamani'] ?></td>
					 </tr>
					 <?php } */ ?>
		</tbody>
	</table>
</div>
<!-- Yüklenen Dosyalar Bitiş -->
<?php } ?>
	</div>
	<!-- Tab İçerikleri Bitiş -->
</div>

<div class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" id="aktifleri">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-body" id="caymanin_aktifleri">
			</div>
		</div>
	</div>
</div>
<div class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" id="iadeleri">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-body" id="caymanin_iadeleri">
			</div>
		</div>
	</div>
</div>
<div class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" id="talepleri">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-body" id="caymanin_talepleri">
			</div>
		</div>
	</div>
</div>
<div class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" id="yeni_cayma">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div style="background:#cececebd;" class="modal-content">
			<div class="modal-body" id="cayma_yeni">
			</div>
		</div>
	</div>
</div>
<div class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" id="ekle_borc">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div style="background:#cececebd;" class="modal-content">
			<div class="modal-body" id="borc_ekle">
			</div>
		</div>
	</div>
</div>
<div class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" id="duzenle_cayma">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div style="background:#cececebd;" class="modal-content">
			<div class="modal-body" id="cayma_duzenle">
			</div>
		</div>
	</div>
</div>
<script>
	async function uye_not_indir(ids) {
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
<script>
	function check(id) {
		if (document.getElementById(id).checked == false) {
			document.getElementById(id).checked = true;
		} else {
			document.getElementById(id).checked = false;
		}

	}

	function guncelle() {
		let myForm = document.getElementById('data');
		var form_data = new FormData(myForm);

		jQuery.ajax({
			url: "https://ihale.pertdunyasi.com/check.php",
			type: 'POST',
			data: form_data,
			dataType: "JSON",
			success: function(response) {

				if (response.status != 200) {
					$(".mesaj").html(response.message);
					$(".mesaj").css("color", "red");
				} else {
					alert("Başarıyla guncellendi");
					localStorage.setItem("trigger", "kisisel_bilgiler_tab");
					//location.reload();
				}
			},
			cache: false,
			contentType: false,
			processData: false
		});
	}
	/*$('#kisisel_bilgileri').on('click', function () {
		jQuery.ajax({
			url: "https://ihale.pertdunyasi.com/check.php",
			type: "POST",
			dataType: "JSON",
			data: {
				action: "panel_guncelle",
				id: document.getElementById('user_id').value,
				ad_soyad:document.getElementById('ad_soyad').value,
				firma_unvani:document.getElementById('firma_unvani').value,
				tc_kimlik:document.getElementById('tc_kimlik').value,
				dogum_tarihi:document.getElementById('dogum_tarihi').value,
				sebep:document.getElementById('sebep').value,
				cinsiyet:document.getElementById('cinsiyet').value,
				email:document.getElementById('email').value,
				tel:document.getElementById('tel').value,
				sabit_tel:document.getElementById('sabit_tel').value,
				sehir:document.getElementById('sehir').value,
				mevcut_sifre:document.getElementById('mevcut_sifre').value,
				sifre:document.getElementById('sifre').value,
				sifre_tekrar:document.getElementById('sifre_tekrar').value,
				ilce:document.getElementById('ilce').value,
				meslek:document.getElementById('meslek').value,
				ilgilendigi_turler:document.getElementById('ilgilendigi_turler').value,
				kargo_adresi:document.getElementById('ilgilendigi_turler').value,
				vergi_dairesi:document.getElementById('vergi_dairesi').value,
				vergi_no:document.getElementById('vergi_no').value,
				fatura_adresi:document.getElementById('fatura_adresi').value,
				yedek_kisi:document.getElementById('yedek_kisi').value,
				yedek_kisi_tel:document.getElementById('yedek_kisi_tel').value,
			},
			success: function(response) {
				console.log(response);
				if (response.status != 200) {
					$("#mesaj").html("");
					$("#mesaj").html(response.message);
					$("#mesaj").css("color", "red");
				}else{
					$("#mesaj").html("");
					alert("Güncelleme işlemi başarılı");
					 window.location="?modul=uyeler&sayfa=uye_duzenle&id=<?= $gelen_id ?>";
				}
			}
		});
	  
	});*/
	$('#email').on('change', function() {
		jQuery.ajax({
			url: "https://ihale.pertdunyasi.com/check.php",
			type: "POST",
			dataType: "JSON",
			data: {
				action: "email_kontrol",
				id: document.getElementById('user_id').value,
				email: document.getElementById('email').value,
			},
			success: function(response) {
				console.log(response);
				if (response.status == 200) {
					$("#email_kontrol").html(response.message);
					$("#email_kontrol").css("color", "green");
				} else {
					$("#email_kontrol").html(response.message);
					$("#email_kontrol").css("color", "red");
				}
			}
		});
	});
	$('#tel').on('change', function() {
		jQuery.ajax({
			url: "https://ihale.pertdunyasi.com/check.php",
			type: "POST",
			dataType: "JSON",
			data: {
				action: "tel_kontrol",
				id: document.getElementById('user_id').value,
				tel: document.getElementById('tel').value,
			},
			success: function(response) {
				console.log(response);
				if (response.status == 200) {
					$("#tel_kontrol").html(response.message);
					$("#tel_kontrol").css("color", "green");

				} else {
					$("#tel_kontrol").html(response.message);
					$("#tel_kontrol").css("color", "red");

				}
			}
		});
	});
	$('#sabit_tel').on('change', function() {
		jQuery.ajax({
			url: "https://ihale.pertdunyasi.com/check.php",
			type: "POST",
			dataType: "JSON",
			data: {
				action: "sabit_tel_kontrol",
				id: document.getElementById('user_id').value,
				sabit_tel: document.getElementById('sabit_tel').value,
			},
			success: function(response) {
				console.log(response);
				if (response.status == 200) {
					$("#sabit_tel_kontrol").html(response.message);
					$("#sabit_tel_kontrol").css("color", "green");

				} else {
					$("#sabit_tel_kontrol").html(response.message);
					$("#sabit_tel_kontrol").css("color", "red");

				}
			}
		});
	});
	$('#vergi_no').on('change', function() {
		jQuery.ajax({
			url: "https://ihale.pertdunyasi.com/check.php",
			type: "POST",
			dataType: "JSON",
			data: {
				action: "vergi_no_kontrol",
				id: document.getElementById('user_id').value,
				vergi_no: document.getElementById('vergi_no').value,
			},
			success: function(response) {
				console.log(response);
				if (response.status == 200) {
					$("#vergi_no_kontrol").html(response.message);
					$("#vergi_no_kontrol").css("color", "green");

				} else {
					$("#vergi_no_kontrol").html(response.message);
					$("#vergi_no_kontrol").css("color", "red");

				}
			}
		});
	});
	$('#tc_kimlik').on('change', function() {
		jQuery.ajax({
			url: "https://ihale.pertdunyasi.com/check.php",
			type: "POST",
			dataType: "JSON",
			data: {
				action: "tc_kontrol",
				id: document.getElementById('user_id').value,
				tc_kimlik: document.getElementById('tc_kimlik').value,
			},
			success: function(response) {
				console.log(response);
				if (response.status == 200) {
					$("#tc_kontrol").html(response.message);
					$("#tc_kontrol").css("color", "green");
				} else if (response.status == 500) {
					$("#tc_kontrol").html(response.message);
					$("#tc_kontrol").css("color", "red");
				} else {
					$("#tc_kontrol").html("");

				}
			}
		});
	});

	function yedek_ekle() {
		var nesne = document.createElement("input");
		nesne.setAttribute("type", "text");
		nesne.setAttribute("name", "yedek_kisi[]");
		nesne.setAttribute("placeholder", "Adı");
		nesne.setAttribute("class", " form-control yedek_input ");
		var yedek_ad_div = document.getElementById("yedek_ad_div");
		yedek_ad_div.appendChild(nesne);

		var nesne_2 = document.createElement("input");
		nesne_2.setAttribute("name", "yedek_kisi_tel[]");
		nesne_2.setAttribute("data-mask", "0(000)000-0000");
		nesne_2.setAttribute("type", "tel");
		nesne_2.setAttribute("class", "form-control yedek_input");
		nesne_2.setAttribute("placeholder", "Telefonu");
		nesne_2.setAttribute("value", "");
		nesne_2.setAttribute("autocomplete", "off");
		nesne_2.setAttribute("maxlength", "14");


		var yedek_tel_div = document.getElementById("yedek_tel_div");
		yedek_tel_div.appendChild(nesne_2);

		var nesne_3 = document.createElement("script");
		nesne_3.setAttribute("src", "js/jquery.mask.js");
		var yedek_tl_div = document.getElementById("yedek_tel_div");
		yedek_tl_div.appendChild(nesne_3);



	}

	function yedek_sil(id) {
		jQuery.ajax({
			url: "https://ihale.pertdunyasi.com/check.php",
			type: "POST",
			dataType: "JSON",
			data: {
				action: "yedek_sil",
				user_id: document.getElementById('user_id').value,
				yedek_id: id
			},
			success: function(response) {
				if (response.status == 200) {
					localStorage.setItem("trigger", "kisiel_bilgiler_tab");
					setTimeout(() => {
						location.reload();
					}, 150);
				}
			}
		});
	}
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.10/jquery.mask.js"></script>

<script>
	$('input[type="tel"]').mask('0(000)000-0000');
</script>
<!-- <script>
function phoneMask() { 
    var num = $(this).val().replace(/\D/g,''); 
    $(this).val(num.substring(0,1) + '(' + num.substring(1,4) + ')' + num.substring(4,7) + '-' + num.substring(7,11)); 
}
$('[type="tel"]').keyup(phoneMask);
</script> -->



<script>
	function isNumberKey(evt) {
		var charCode = (evt.which) ? evt.which : event.keyCode;
		if (charCode > 31 && (charCode < 48 || charCode > 57))
			return false;
		return true;
	}
</script>

<script>
	function musteri_temsilcisi_kontrolu() {
		jQuery.ajax({
			url: "https://ihale.pertdunyasi.com/check.php",
			type: "POST",
			dataType: "JSON",
			data: {
				action: "musteri_temsilcisi_kontrolu",
				user_id: document.getElementById('user_id').value,
				grup: document.getElementById('grup').value,
			},
			success: function(response) {
				console.log(response);
				console.log(response.admin_id);
				if (response.admin_id != "") {
					// document.getElementById('musteri_temsilci_' + response.admin_id).selected = true
					$('#musteri_temsilcisi').val(response.admin_id);
				}
			}
		});
	}

	function yetkiyiKaydet() {
		var array = [];
		$("input[name='yasak_sigorta[]']:checked").each(function() {
			array.push($(this).val());
		});
		jQuery.ajax({
			url: "https://ihale.pertdunyasi.com/action.php",
			type: "POST",
			dataType: "JSON",
			data: {
				action: "yetkiyi_kaydet",
				uye_id: document.getElementById('yetki_duzenle_uye_id').value,
				grup: document.getElementById('grup').value,
				demo_olacagi_tarih: document.getElementById('demo_olacagi_tarih').value,
				uye_standart_teklif_limiti: document.getElementById('uye_standart_teklif_limiti').value,
				uye_luks_teklif_limiti: document.getElementById('uye_luks_teklif_limiti').value,
				hurda_teklif_yetkisi: $("#hurda_teklif_yetkisi:checked").val(),
				musteri_temsilcisi: $("#musteri_temsilcisi").val(),
				yasak_sigorta: array,
				kalici_mesaj: $("#kalici_mesaj:checked").val(),
				kalici_sistem_mesaji: $("#kalici_sistem_mesaji").val(),
				otomatik_risk_engelle: $("#otomatik_risk_engelle:checked").val(),
				uyeyi_engelleme_nedeni: $("#uyeyi_engelleme_nedeni").val(),
				teklif_vermesini_engelle: $("#teklif_vermesini_engelle:checked").val(),
				uyelik_iptali: $("#uyelik_iptali:checked").val(),
				uyelik_iptal_nedeni: $("#uyelik_iptal_nedeni:checked").val(),
				temsilci_degistirme_yetki: $("#temsilci_degistirme_yetki").val(),
			},
			success: function(response) {
				console.log(response);
				localStorage.setItem("trigger", "yetkiler_tab")
				alert(response.message);
				location.reload();
			}
		});
	}
</script>