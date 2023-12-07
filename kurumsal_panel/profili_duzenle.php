<?php
session_start();
include('../ayar.php');
$token = $_SESSION['k_token'];
if (!empty($token)) {
	$uye_token = $token;
}

if (!isset($_SESSION['k_token'])) {
	echo '<script>alert("Devam Etmek İçin Lütfen Giriş Yapın !")</script>';
	echo '<script>window.location.href = "../index.php"</script>';
}
$ihale_cek = mysql_query("SELECT * FROM ilanlar ORDER BY ihale_tarihi DESC");
$dogrudan_cek = mysql_query("SELECT * FROM dogrudan_satisli_ilanlar");
$dogrudan_satis_sayisi = mysql_num_rows($dogrudan_cek);
$ihale_sayisi = mysql_num_rows($ihale_cek);
$kullanici_cek = mysql_query("SELECT * FROM `user` WHERE kurumsal_user_token = '$uye_token'");
$sehir_cek = mysql_query("SELECT * FROM sehir");
include 'template/sayi_getir.php';

?>
<!doctype html>
<html lang="tr">

<head>
	<link rel="stylesheet" href="../css/uye_panel.css?v=15">
	<link rel="stylesheet" href="css/menu.css">
	<!-- Required meta tags -->
	<!-- <title>Pert &mdash; Dünyası</title> -->
	<?php
	include '../seo_kelimeler.php';
	?>
	<meta charset="utf-8">
	<meta http-equiv="content-language" content="tr">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="author" content="EA Bilişim">
	<meta name="Abstract" content="Pert Dünyası sigortadan veya sahibinden kazalı,hasarlı pert araçların 
			online ihale ile veya doğrudan satış yapılabileceği online ihale platformudur.">
	<meta name="description" content="Pert Dünyası Pert Kazalı Araç İhale Sistemi">
	<meta name="keywords" content="hasarlı oto, hasarlı arabalar, hasarlı araçlar, pert araçlar, pert oto, 
			pert arabalar, kazalı araçlar, kazalı oto, kazalı arabalar, hurda araçlar, hurda arabalar, 
			hurda oto, hasarlı ve pert kamyon, hasarlı ve kazalı traktör, kazalı çekici, ihale ile satılan hasarlı araçlar,
			sigortadan satılık pert arabalar, ihaleli araçlar, kapalı ihaleli araçlar, açık ihalelli araçlar, 2.el araç,
			hurda kamyon, hurda traktör, ihaleyle kamyon">
	<meta name="Copyright" content="Ea Bilişim Tüm Hakları Saklıdır.">
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.js"></script>
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
	<title>Pert Dünyası</title>
	<style>
		.uyelik {
			color: yellow !important;
			font-weight: bolder;
		}

		.alt_baslik {
			text-decoration: none !important;
			cursor: pointer;
			color: #000000;
		}

		.alt_baslik:hover {
			color: red;
		}

		.list-group-item {
			padding-bottom: 0px;
		}

		tr:nth-child(odd) {
			background-color: rgb(219, 238, 244);
		}

		table {
			border-collapse: collapse;
			width: 100%;
			margin-top: 1%;
		}

		.kod {
			background-color: rgb(78, 79, 83);
			color: #ffffff;
		}

		.swal-modal {
			background-color: #ffc90e;
		}

		.swal-button {
			background-color: #00a2e8;
		}

		.swal-text {
			color: #000;
		}

		.yedek_input {
			margin-bottom: 5%;
		}

		.yedek_sil_input {
			margin-top: 20%;
			margin-bottom: 45%;
		}

		.deneme p {
			margin-bottom: 0px !important;
			margin-top: 0px !important;
			margin-left: 15px;
		}
	</style>
</head>

<body>
	<?php

	$site_acilis_popup_icin_cek = mysql_query("select * from siteye_girenler WHERE ip_adresi = '" . getIP() . "'");
	$site_acilis_popup_icin_say = mysql_num_rows($site_acilis_popup_icin_cek);
	$site_acilis_popup_icin_oku = mysql_fetch_assoc($site_acilis_popup_icin_cek);
	$siteye_giris_tarih = date('Y-m-d H:i:s');
	$siteye_giris_tarih_before = date("Y-m-d H:i:s", strtotime('-24 hours', strtotime($siteye_giris_tarih)));
	$sitenin_acilis_popupunu_cek = mysql_query("select * from site_acilis_popup");
	$sitenin_acilis_popupunu_say = mysql_num_rows($sitenin_acilis_popupunu_cek);
	$sitenin_acilis_popupunu_oku = mysql_fetch_assoc($sitenin_acilis_popupunu_cek);
	$sitenin_acilis_popupu = $sitenin_acilis_popupunu_oku['icerik'];
	if ($sitenin_acilis_popupunu_oku['durum'] == 1) {
		if ($site_acilis_popup_icin_say == 0) {
			$siteye_giren_ekle = mysql_query("INSERT INTO `siteye_girenler` (`id`, `ip_adresi`, `tarih`, `durum`) VALUES (NULL, '" . getIP() . "', '" . $siteye_giris_tarih . "', '1');");
			if ($sitenin_acilis_popupunu_oku['buton'] == 1) {
				echo '
					<script>
						var htmlContent2 = document.createElement("div");
						htmlContent2.innerHTML = `
							' . $sitenin_acilis_popupu . '
						`;
						swal( {
							closeOnEsc: false,
							closeOnClickOutside: false,
							
							content:htmlContent2,
							buttons: {
								defeat: "Tamam",
							},
						})			
						.then((value) => {
							switch (value) {
								case "defeat": 
									
									break;            
								default:
									break;
							}
						});
					</script>	
				';

				//  echo '<script type="text/javascript">alert("'.$sitenin_acilis_popupu.'");</script>';
				//  echo "<script>window.location.href = 'hazirlaniyor.php';</script>";
			} else {
				echo '
					<script>
						var htmlContent2 = document.createElement("div");
						htmlContent2.innerHTML = `
							' . $sitenin_acilis_popupu . '
						`;
						swal( {
							buttons: false,
							showCancelButton: false,
							content:htmlContent2,
						})			
						.then((value) => {
							window.location.href = "hazirlaniyor.php";
						});
					</script>
				';
				// echo '<script type="text/javascript">alert("'.$sitenin_acilis_popupu.'");</script>';
				$siteye_giren_guncelle = mysql_query("update siteye_girenler set tarih = '" . date('Y-m-d H:i:s') . "' where ip_adresi = '" . getIP() . "'");
			}
		} else {
			if ($site_acilis_popup_icin_oku['tarih'] < $siteye_giris_tarih_before) {
				if ($sitenin_acilis_popupunu_oku['buton'] == 1) {
					echo '
						<script>
							var htmlContent2 = document.createElement("div");
							htmlContent2.innerHTML = `
								' . $sitenin_acilis_popupu . '
							`;
							swal( {
								closeOnEsc: false,
								closeOnClickOutside: false,
								
								content:htmlContent2,
								buttons: {
									defeat: "Tamam",
								},
							})			
							.then((value) => {
								switch (value) {
									case "defeat": 
										
										break;            
									default:
										break;
								}
							});
						</script>	
					';
					$siteye_giren_guncelle = mysql_query("update siteye_girenler set tarih = '" . date('Y-m-d H:i:s') . "' where ip_adresi = '" . getIP() . "'");
					//  echo '<script type="text/javascript">alert("'.$sitenin_acilis_popupu.'");</script>';
					//  echo "<script>window.location.href = 'hazirlaniyor.php';</script>";
				} else {
					echo '
						<script>
							var htmlContent2 = document.createElement("div");
							htmlContent2.innerHTML = `
								' . $sitenin_acilis_popupu . '
							`;
							swal( {
								buttons: false,
								showCancelButton: false,
								content:htmlContent2,
							})			
							.then((value) => {
								window.location.href = "hazirlaniyor.php";
							});
						</script>
					';
					// echo '<script type="text/javascript">alert("'.$sitenin_acilis_popupu.'");</script>';
					// $siteye_giren_guncelle = mysql_query("update siteye_girenler set tarih = '".date('Y-m-d H:i:s')."' where ip_adresi = '".getIP()."'");
				}
			}
		}
	}


	$sistem_devam_bilgileri_cek = mysql_query("SELECT * FROM `user` WHERE kurumsal_user_token = '$uye_token'");
	while ($devam_etsin = mysql_fetch_array($sistem_devam_bilgileri_cek)) {
		if ($devam_etsin['tc_kimlik'] == "" || $devam_etsin['mail'] == ""  || $devam_etsin['telefon'] == "" || $devam_etsin['sehir'] == "" || $devam_etsin['unvan'] == "" || $devam_etsin['cinsiyet'] == ""  || $devam_etsin['kargo_adresi'] == "") {
			$paketi_sorgula = mysql_query("select * from uye_grubu where id='" . $devam_etsin['paket'] . "'");
			$paketi_cek = mysql_fetch_object($paketi_sorgula);
			echo '<script>swal({text:"Tebrikler platformumuza ' . $paketi_cek->grup_adi . ' üyeliğiniz başarıyla gerçekleştirildi.Size daha iyi hizmet verebilmek adına üyelik profilinize ekstra bilgiler girmeniz gerekmektedir.Tüm bilgileri doğru ve eksiksiz şekilde doldurduğunuzda üyeliğiniz tamamlanmış olacaktır.",button:"Tamam"})</script>';
		}
	}
	$bugun = date("Y-m-d");
	$sorgu = mysql_query("SELECT * FROM kutlama_gorseli WHERE '$bugun' < reklam_bitis AND '$bugun' >= reklam_baslangic ORDER BY id ASC LIMIT 1 ");
	while ($yaz = mysql_fetch_array($sorgu)) {
	?>
		<nav class="deneme" style="padding-bottom: 0%;width:100%; padding-top: 0%;color:<?= $yaz['yazi_renk'] ?>; background-color:<?= $yaz['arkaplan_renk'] ?>;padding: 0!important;">
			<div class="col-sm-12" style="text-align:center; font-size: large; padding: 15px;">
				<div style="text-align:center" class="col-sm-12">
					<?= $yaz['icerik'] ?>
				</div>
			</div>
		</nav>
	<?php } ?>
	<nav class="navbar navbar-expand-md navbar-dark bg-dark " style="padding-bottom: 0%; padding-top: 0%;">
		<div class="collapse navbar-collapse" id="navbarCollapse">
			<ul class="navbar-nav mr-auto">
				<li class="nav-item active">
					<?php
					$yedek_ad_input = "";
					$yedek_tel_input = "";
					$sil_buton = "";
					while ($kullanici_oku = mysql_fetch_array($kullanici_cek)) {

						if ($kullanici_oku["yedek_kisi"] != "") {
							$yedek_durum = true;
							$parcala = explode(",", $kullanici_oku["yedek_kisi"]);
							$parcala_2 = explode(",", $kullanici_oku["yedek_kisi_tel"]);
							for ($m = 0; $m < count($parcala); $m++) {
								$yedek_ad_input .= '  <input type="text" name="yedek_kisi[]" value="' . $parcala[$m] . '" class="form-control yedek_input" >';
								$yedek_tel_input .= '  <input type="tel" name="yedek_kisi_tel[]" value="' . $parcala_2[$m] . '" class="form-control yedek_input" >';
								$sil_buton .= '<input style="" onclick="yedek_sil(' . $m . ')"  id="yedek_kisi_tela" type="button" class=" btn btn-danger yedek_sil_input"  name="" value="Sil" />';
							}
						} else {
							$yedek_durum = false;
						}


						$gelen_id = $kullanici_oku['id'];
						$token = $uye_token;
						$sebepi = $kullanici_oku['uye_olma_sebebi'];
						$cinsiyet = $kullanici_oku['cinsiyet'];
						$ilgilendigi_tur = $kullanici_oku['ilgilendigi_turler'];
						$dogum_tarihi_cek = mysql_query("SELECT * FROM dogum_tarihi WHERE uye_id = '" . $gelen_id . "'");
						$dogum_tarihi_oku = mysql_fetch_assoc($dogum_tarihi_cek);
						$dogum_tarihi = $dogum_tarihi_oku['dogum_tarihi'];

						/*$toplam_aktif = mysql_query('SELECT SUM(net) AS net FROM cayma_bedelleri WHERE uye_id = "'.$kullanici_oku['id'].'" and durum=1'); 
							$toplam_getir = mysql_fetch_assoc($toplam_aktif); 
							$toplam_cayma = $toplam_getir['net'];
						  
							$toplam_borc = mysql_query('SELECT SUM(net) AS net FROM cayma_bedelleri WHERE uye_id = "'.$kullanici_oku['id'].'" and durum=2'); 
							$toplam_borc_getir = mysql_fetch_assoc($toplam_borc); 
							$toplam_borc_cayma = $toplam_getir['net'];
							$cayma=$toplam_cayma+toplam_borc_cayma;*/

						$aktif_cayma_toplam = mysql_query("
								SELECT 
									SUM(tutar) as toplam_aktif_cayma
								FROM
									cayma_bedelleri
								WHERE
									uye_id='" . $kullanici_oku['id'] . "' AND
									durum=1
							");
						$toplam_aktif_cayma = mysql_fetch_assoc($aktif_cayma_toplam);
						$iade_talepleri_toplam = mysql_query("
								SELECT 
									SUM(tutar) as toplam_iade_talepleri
								FROM
									cayma_bedelleri
								WHERE
									uye_id='" . $kullanici_oku['id'] . "' AND
									durum=2
							");
						$toplam_iade_talepleri = mysql_fetch_assoc($iade_talepleri_toplam);
						$borclar_toplam = mysql_query("
								SELECT 
									SUM(tutar) as toplam_borclar
								FROM
									cayma_bedelleri
								WHERE
									uye_id='" . $kullanici_oku['id'] . "' AND
									durum=6
							");
						$toplam_borclar = mysql_fetch_assoc($borclar_toplam);
						$cayma = $toplam_aktif_cayma["toplam_aktif_cayma"] - $toplam_iade_talepleri["toplam_iade_talepleri"] - $toplam_borclar["toplam_borclar"];


						$paket = $kullanici_oku['paket'];
						$paket_cek = mysql_query("SELECT * FROM uye_grubu WHERE id = '" . $paket . "'");
						$paket_oku = mysql_fetch_assoc($paket_cek);
						$paket_adi = $paket_oku['grup_adi'];
						if ($paket == "1") {
							$color = "#ffffff";
						} elseif ($paket == "22") {
							$color = "green";
						} elseif ($paket == "21") {
							$color = "yellow";
						}
						$limit_cek = mysql_query("SELECT * FROM teklif_limiti WHERE uye_id = '" . $kullanici_oku['id'] . "'");
						$limit_oku = mysql_fetch_assoc($limit_cek);
						$limit = $limit_oku['standart_limit'];
						if ($limit == 0) {
							$grup_cek = mysql_query("select * from uye_grubu_detaylari where grup_id='" . $paket . "' order by cayma_bedeli asc");
							while ($grup_oku = mysql_fetch_array($grup_cek)) {
								if ($cayma >= $grup_oku["cayma_bedeli"]) {
									$limit = money($grup_oku["standart_ust_limit"]) . "₺ ";
								}
							}
							if ($limit == 0) {
								$limit = $limit . " ₺";
							}
							$limit_turu = " (Standart)";
						} else {
							if ($limit > 1000000) {
								$limit = "Sınırsız ";
								$limit_turu = " (Standart)";
							} else {
								$limit = money($limit_oku['standart_limit']) . "₺ ";
								$limit_turu = " (Standart)";
							}
						}


						$limit2 = $limit_oku['luks_limit'];
						if ($limit2 == 0) {
							$grup_cek = mysql_query("select * from uye_grubu_detaylari where grup_id='" . $paket . "' order by cayma_bedeli asc");
							while ($grup_oku = mysql_fetch_array($grup_cek)) {
								if ($cayma >= $grup_oku["cayma_bedeli"]) {
									$limit2 = money($grup_oku["luks_ust_limit"]) . "₺ ";
								}
							}
							if ($limit2 == 0) {
								$limit2 = $limit2 . " ₺";
							}
							$limit_turu2 = " (Ticari)";
						} else {
							if ($limit2 > 1000000) {
								$limit2 = "Sınırsız ";
								$limit_turu2 = " (Ticari)";
							} else {
								$limit2 = money($limit_oku['luks_limit']) . "₺ ";
								$limit_turu2 = " (Ticari)";
							}
						}

						$uye_durumu = mysql_query("select * from uye_durumlari where uye_id='" . $gelen_id . "'");
						$uye_durumlari_oku = mysql_fetch_object($uye_durumu);

						$hurda_teklif = $uye_durumlari_oku->hurda_teklif;

					?>
						<a class="nav-link uyelik" style="font-size: large; color:<?= $color ?> !important;"><b><?= mb_strtoupper($paket_adi, "utf-8") ?> ÜYE</b></a>
				</li>
				<li class="nav-item active" style="font-size: small;">
					<a class="nav-link"><span style="color: #a4a4a4;">Cayma Bakiyesi : </span> <?= money($cayma) ?> ₺</a>
				</li>
				<li class="nav-item active" style="font-size: small;">
					<a class="nav-link"><span style="color: #a4a4a4;">Teklif Limiti : </span><?= $limit ?><span style="color: #a4a4a4;"><?= $limit_turu ?> </span> <?= $limit2 ?> <span style="color: #a4a4a4;"><?= $limit_turu2 ?> </span></a>
				</li>
			</ul>
			<ul class="navbar-nav" style="font-size: small;">
				<li class="nav-item active dropdown">
					<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<?= $kullanici_oku['unvan'] ?>
					</a>
					<div class="dropdown-menu" aria-labelledby="navbarDropdown" style="position: absolute; transform: translate3d(90px, 10px, 0px); top: 15px; left: -190px; will-change: transform;">
						<a class="dropdown-item" href="index.php">Üye Panelim</a>
						<?php if ($paket == "21") { ?>
							<a class="dropdown-item" href="islemler/gold_uyelik_basvuru.php?id=21">Gold Üyelik Başvurusu</a>
						<?php } ?>
						<?php $pdf_cek = mysql_fetch_object(mysql_query("select * from pdf")) ?>
						<a class="dropdown-item" href="https://ihale.pertdunyasi.com/pdf.php?id=1&uye_id=<?= $kullanici_oku['id'] ?>&q=k_uyelik_pdf" target="_blank">Üyelik Sözleşmesi Görüntüle</a>
						<?php
						$kazanma_sorgula = mysql_query("select * from kazanilan_ilanlar where uye_id='" . $kullanici_oku['id'] . "' ");
						if (mysql_num_rows($kazanma_sorgula) > 0 && $paket == "21") {
							/*
									<a class="dropdown-item" href="https://ihale.pertdunyasi.com/pdf.php?id=1&uye_id=<?=$kullanici_oku['id']?>&q=vekaletname_pdf" target="_blank">Vekaletname Örneği Görüntüle(PDF)</a>
									<a class="dropdown-item" href="https://ihale.pertdunyasi.com/word.php?id=1&uye_id=<?=$kullanici_oku['id']?>&q=vekaletname_word" >Vekaletname Örneği Görüntüle(WORD)</a>
								*/
						?>
							<?php $vekaletname_cek = mysql_fetch_object(mysql_query("select * from vekaletname_pdf")); ?>
							<a class="dropdown-item" href="https://ihale.pertdunyasi.com/<?= $vekaletname_cek->vekaletname ?>" target="_blank">Vekaletname Örneği Görüntüle(PDF)</a>
							<a class="dropdown-item" href="https://ihale.pertdunyasi.com/<?= $vekaletname_cek->vekaletname_word ?>" target="_blank">Vekaletname Örneği Görüntüle(WORD)</a>

						<?php } ?>
						<a class="dropdown-item" href="evrak_yukle.php">Evrak Yükle</a>
					</div>
				</li>
				<li class="nav-item active mr-0">
					<a class="nav-link" href="islemler/logout.php"> Çıkış Yap</a>
				</li>
			</ul>
		</div>
	</nav>
	<?php include 'template/header.php'; ?>
	<div class="col-sm-12" style="margin-top:10%;">
		<div class="row">
			<div class="col-sm-4">
				<?php include 'template/sidebar.php'; ?>
			</div>
			<div class="col-sm-8">
				<strong class="mesaj"></strong>
				<form method="POST" name="data" id="data" enctype="multipart/form-data">
					<input type="hidden" name="action" value="guncelle" />
					<?php include 'islemler/profil_duzenle.php'; ?>
					<div class="row">
						<div class="col">
							<div class="form-group">
								<label for="IDofInput">Yetkili Adı</label>
								<input type="text" class="form-control" id="ad_soyad" name="ad_soyad" readonly value="<?= $kullanici_oku['ad'] ?>">
							</div>
							<div class="form-group">
								<label for="IDofInput">TC Kimlik No</label>
								<input type="text" onkeypress="return isNumberKey(event)" class="form-control" maxLength="11" id="tc_kimlik" name="tc_kimlik" value="<?= $kullanici_oku['tc_kimlik'] ?>" <?php if ($kullanici_oku['tc_kimlik'] != '') {
																																																				echo 'readonly';
																																																			}  ?>>
								<label class="tc_kontrol"> </label>
							</div>
							<div class="form-group">
								<label for="IDofInput">Doğum Tarihi</label>
								<input type="date" class="form-control" id="dogum_tarihi" required name="dogum_tarihi" value="<?= $dogum_tarihi ?>">
							</div>
							<div class="form-group">
								<label for="IDofInput">E-posta Adresi</label>
								<input type="email" class="form-control" id="email" name="email" readonly value="<?= $kullanici_oku['mail'] ?>">
								<label class="email_kontrol"> </label>
							</div>
							<div class="form-group">
								<label for="IDofInput">Onaylı Cep No</label>
								<input type="tel" class="form-control" readonly id="onayli_cep" name="onayli_cep" value="<?= $kullanici_oku['telefon'] ?>">
								<label class="tel_kontrol"> </label>
							</div>
							<div class="form-group">
								<label for="IDofInput">Üye Olma Sebebi</label>
								<select name="why" class="form-control" id="why" required>
									<option value="Onarıp kullanmak amacıyla" <?php if ($sebepi == "Onarıp kullanmak amacıyla") echo 'selected="selected"'; ?>>Onarıp kullanmak amacıyla</option>
									<option value="Araç alıp satıyorum" <?php if ($sebepi == "Araç alıp satıyorum") echo 'selected="selected"'; ?>>Araç alıp satıyorum</option>
									<option value="Aracımı satmak istiyorum" <?php if ($sebepi == "Aracımı satmak istiyorum") echo 'selected="selected"'; ?>>Aracımı satmak istiyorum</option>
									<option value="Sadece merak ettim" <?php if ($sebepi == "Sadece merak ettim") echo 'selected="selected"'; ?>>Sadece merak ettim</option>
								</select>
							</div>
							<div class="form-group">
								<label for="IDofInput">Cinsiyet*</label>
								<select name="gender" class="custom-select d-block w-100" id="gender" required>
									<option value="Kadin" <?php if ($cinsiyet == "Kadin") echo 'selected="selected"'; ?>>Kadın</option>
									<option value="Erkek" <?php if ($cinsiyet == "Erkek") echo 'selected="selected"'; ?>>Erkek</option>
									<option value="belirtmemis" <?php if ($cinsiyet == "belirtmemis") echo 'selected="selected"'; ?>>Belirtmek istemiyorum</option>
								</select>
							</div>
							<div class="form-group">
								<label for="IDofInput">Sabit Telefon</label>
								<input id="sabit_tel" type="tel" class="form-control" name="sabit_tel" value="<?= $kullanici_oku['sabit_tel'] ?>">
								<label class="sabit_tel_kontrol"> </label>
							</div>
							<div class="form-group">
								<label for="IDofInput">Sehir seciniz*</label>
								<select name="sehir" class="form-control" id="sehir" required>
									<?php
									$sehir_adi = mysql_query("SELECT * FROM sehir WHERE sehiradi = '" . $kullanici_oku['sehir'] . "' ");
									while ($sehir_gel = mysql_fetch_array($sehir_adi)) {
										$sehir_id = $sehir_gel["sehirID"];
									}
									while ($sehir_oku = mysql_fetch_array($sehir_cek)) { ?>
										<option value="<?= $sehir_oku['sehirID'] ?>" <?= $sehir_oku["sehirID"] == $sehir_id ? "selected" : "" ?>><?= $sehir_oku["sehiradi"]; ?></option>
									<?php } ?>
								</select>
							</div>
							<div class="form-group">
								<label for="IDofInput">İlçe</label>
								<?php 	 ?>
								<select name="ilce" id="ilce" title="" class="form-control">
									<?php
									$ilce_adi = mysql_query("SELECT * FROM ilce WHERE ilce_adi = '" . $kullanici_oku['ilce'] . "' ");
									while ($ilce_gel = mysql_fetch_array($ilce_adi)) {
										$ilce_id = $ilce_gel["ilceID"];
									}
									$ilce_cek = mysql_query("select * from ilce where il_plaka='" . $sehir_id . "'");

									while ($ilce_oku = mysql_fetch_array($ilce_cek)) { ?>
										<option value="<?= $ilce_oku['ilceID'] ?>" <?= $ilce_oku["ilceID"] == $ilce_id ? "selected" : "" ?>><?= $ilce_oku["ilce_adi"]; ?></option>
									<?php } ?>
									<option value="">--İlçe Seçin--</option>
								</select>
							</div>
							<div class="form-group">
								<label for="IDofInput">Meslek</label>
								<input id="meslek" type="text" class="form-control" required name="meslek" value="<?= $kullanici_oku['meslek'] ?>">
							</div>
						</div>
						<div class="col">
							<div class="row">
								<div class="col">
									<label id="IDofInput" class="form-text text-muted">Size ulaşamadığımızda ulaşabileceğimiz kişiler</label>
									<input style="float:right;margin-bottom:5%;" type="button" onclick="yedek_ekle()" class=" btn btn-success" value="Ekle" />
								</div>
							</div>
							<div class="row">

								<div class="col-5" id="yedek_ad_div">
									<div class="form-group">
										<?php if ($yedek_durum == false) { ?>
											<input style="" name="yedek_kisi[]" type="text" class="form-control yedek_input" placeholder="Adı" value="<?= $kullanici_oku['yedek_kisi'] ?>">
										<?php } ?>
										<?= $yedek_ad_input ?>
									</div>
								</div>
								<div class="col-5 " id="yedek_tel_div">
									<div class="form-group">
										<?php if ($yedek_durum == false) { ?>
											<input style="" name="yedek_kisi_tel[]" type="tel" class="form-control yedek_input" placeholder="Telefonu" value="<?= $kullanici_oku['yedek_kisi_tel'] ?>">
										<?php } ?>
										<?= $yedek_tel_input ?>
									</div>
								</div>
								<div class="col-2">
									<div class="form-group">
										<?= $sil_buton ?>
									</div>
								</div>
							</div>
							<?php
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
							<!--<div class="form-group">
											<label for="IDofInput">İlgilendiği Türler</label>
											<select class="form-control" name="ilgilendigi" id="ilgilendigi">
												<option value="Plakalı Ruhsatlı" <?php if ($ilgilendigi_tur == "Plakalı Ruhsatlı") echo 'selected="selected"'; ?> >Plakalı Ruhsatlı</option>
												<option value="Çekme Belgeli" <?php if ($ilgilendigi_tur == "Çekme Belgeli") echo 'selected="selected"'; ?> >Çekme Belgeli</option>
												<option value="Hurda Belgeli" <?php if ($ilgilendigi_tur == "Hurda Belgeli") echo 'selected="selected"'; ?> >Hurda Belgeli</option>
											</select>
										</div>-->
							<div class="form-group">
								<label for="IDofInput">İlgilendiğiniz Araç Türleri</label><br>
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
							<div class="form-group">
								<label for="IDofInput">Vergi Dairesi Adı</label>
								<?php
								if ($kullanici_oku["vergi_dairesi"] == "") { ?>
									<input type="text" class="form-control" required id="vergi_dairesi" name="vergi_dairesi" value="">
								<?php } else { ?>
									<span>Vergi Dairesi : <?= $kullanici_oku["vergi_dairesi"] ?> </span>
									<input type="hidden" id="vergi_dairesi" name="vergi_dairesi" value="<?= $kullanici_oku["vergi_dairesi"] ?>">
								<?php } ?>
							</div>
							<div class="form-group">
								<label for="IDofInput">Vergi Numarası</label>
								<?php if ($kullanici_oku['vergi_dairesi_no'] == "") { ?>
									<input onkeypress="return isNumeric(event)" oninput="maxLengthCheck(this)" type="number" class="form-control" required id="vergi_dairesi_no" name="vergi_dairesi_no" max="9999999999" min="1000000000" maxlength="10" value="">
								<?php } else { ?>
									<span>Vergi Numarası : <?= $kullanici_oku["vergi_dairesi_no"] ?> </span>
									<input type="hidden" id="vergi_dairesi_no" name="vergi_dairesi_no" value="<?= $kullanici_oku["vergi_dairesi_no"] ?>">
								<?php } ?>
								<label class="vergi_kontrol"> </label>
							</div>

							<!--<div class="form-group">
											<label for="IDofInput">Adres</label>
											<textarea class="form-control" id="adres" name="adres" required rows="3"><?= $kullanici_oku['adres'] ?></textarea>
										</div>-->
							<?php
							$kargo_adresim = false;
							if ($kullanici_oku['fatura_adresi'] == $kullanici_oku['kargo_adresi']) {
								$kargo_adresim = true;
							}
							?>
							<div class="form-group">
								<label for="IDofInput">Kargo Adresi</label>
								<textarea class="form-control" id="kargo_adresi" name="kargo_adresi" required rows="3"><?= $kullanici_oku['kargo_adresi'] ?></textarea>
							</div>

							<div class="form-group">
								<label for="IDofInput">Fatura Adresim Kargo Adresimle Aynı Olsun</label>
								<input type="checkbox" id="adres_kargo_ayni" onclick="kargo_adres_ayni();" name="adres_kargo_ayni" value="" />
							</div>
							<div class="form-group">
								<label for="IDofInput">Fatura Adresi</label>
								<textarea class="form-control" id="fatura_adresi" name="fatura_adresi" required rows="3"><?= $kullanici_oku['fatura_adresi'] ?></textarea>
							</div>
							<div class="form-group">
								<label for="IDofInput">Hurda Araçlara Teklif Verebilme</label>
								<input type="checkbox" id="hurda_teklif" name="hurda_teklif" value="on" <?php if ($hurda_teklif == "on") echo 'checked'; ?> />
							</div>
						</div>
					</div>
					<button type="button" onclick="guncelle();" class="btn btn-primary">Kaydet</button>
				</form>
			</div>
		</div>
	</div>
<?php  } ?>
<?php include 'template/footer.php'; ?>
<script src="https://kit.fontawesome.com/2fdd899201.js" crossorigin="anonymous"></script>
<!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="js/il_ilce.js?v=17"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.10/jquery.mask.js"></script>
<script>
	$('input[type="tel"]').mask('0(000)000-0000');
</script>
<script>
	function kargo_adres_ayni() {
		if (document.getElementById("adres_kargo_ayni").checked == true) {
			var adres = document.getElementById("kargo_adresi").value;
			document.getElementById("fatura_adresi").value = adres;
			document.getElementById("fatura_adresi").innerHTML = adres;
		} else {
			var adres = document.getElementById("kargo_adresi").value;
			document.getElementById("fatura_adresi").value = "";
			document.getElementById("fatura_adresi").innerHTML = "";
		}
	}

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
		var meslek = document.getElementById('meslek').value;
		var tc_kimlik = document.getElementById('tc_kimlik').value;
		//var adres = document.getElementById('adres').value;
		var kargo_adresi = document.getElementById('kargo_adresi').value;
		var fatura_adresi = document.getElementById('fatura_adresi').value;
		var vergi_dairesi = document.getElementById('vergi_dairesi').value;
		var vergi_dairesi_no = document.getElementById('vergi_dairesi_no').value;
		if (tc_kimlik == "") {
			alert("Tc Kimlik Numarası Boş Bırakılamaz");
		} else if (meslek == "") {
			alert("Meslek Boş Bırakılamaz");
		}
		/* else if(adres == ""){
							alert("Adres Boş Bırakılamaz");
						} */
		else if (kargo_adresi == "") {
			alert("Kargo Adresi Boş Bırakılamaz");
		} else if (fatura_adresi == "") {
			alert("Fatura Adresi Boş Bırakılamaz");
		} else if (vergi_dairesi == "") {
			alert("Vergi Dairesi Boş Bırakılamaz");
		} else if (vergi_dairesi_no == "") {
			alert("Vergi Numarası Boş Bırakılamaz");
		} else if (vergi_dairesi_no.toString().length != 10) {
			alert("Vergi Numarası 10 Haneli olmalı");
		} else {
			jQuery.ajax({
				url: "https://ihale.pertdunyasi.com/kurumsal_panel/islemler/profil_duzenle.php",
				type: 'POST',
				data: form_data,
				dataType: "JSON",
				success: function(response) {
					console.log(response);
					if (response.status != 200) {
						$(".mesaj").html(response.message);
						$(".mesaj").css("color", "red");
						alert(response.message);
					} else {
						alert("Başarıyla guncellendi");
						// window.location.href = 'https://ihale.pertdunyasi.com/ihaledeki_araclar.php';
						location.reload();
					}
				},
				cache: false,
				contentType: false,
				processData: false
			});
		}
	}
	$('#tc_kimlik').on('change', function() {
		jQuery.ajax({
			url: "https://ihale.pertdunyasi.com/kurumsal_panel/islemler/profil_duzenle.php",
			type: "POST",
			dataType: "JSON",
			data: {
				action: "tc_kontrol",
				tc_kimlik: document.getElementById('tc_kimlik').value,
			},
			success: function(response) {
				console.log(response);
				if (response.status == 200) {
					$(".tc_kontrol").html(response.message);
					$(".tc_kontrol").css("color", "green");
				} else {
					$(".tc_kontrol").html(response.message);
					$(".tc_kontrol").css("color", "red");
				}
			}
		});

	});
	$('#email').on('change', function() {
		jQuery.ajax({
			url: "https://ihale.pertdunyasi.com/kurumsal_panel/islemler/profil_duzenle.php",
			type: "POST",
			dataType: "JSON",
			data: {
				action: "email_kontrol",
				email: document.getElementById('email').value,
			},
			success: function(response) {
				console.log(response);
				if (response.status == 200) {
					$(".email_kontrol").html(response.message);
					$(".email_kontrol").css("color", "green");
				} else {
					$(".email_kontrol").html(response.message);
					$(".email_kontrol").css("color", "red");
				}
			}
		});

	});
	$('#onayli_cep').on('change', function() {
		jQuery.ajax({
			url: "https://ihale.pertdunyasi.com/kurumsal_panel/islemler/profil_duzenle.php",
			type: "POST",
			dataType: "JSON",
			data: {
				action: "tel_kontrol",
				onayli_cep: document.getElementById('onayli_cep').value,
			},
			success: function(response) {
				console.log(response);
				if (response.status == 200) {
					$(".tel_kontrol").html(response.message);
					$(".tel_kontrol").css("color", "green");

				} else {
					$(".tel_kontrol").html(response.message);
					$(".tel_kontrol").css("color", "red");
				}
			}
		});

	});
	$('#vergi_dairesi_no').on('change', function() {
		jQuery.ajax({
			url: "https://ihale.pertdunyasi.com/kurumsal_panel/islemler/profil_duzenle.php",
			type: "POST",
			dataType: "JSON",
			data: {
				action: "vergi_no_kontrol",
				vergi_no: document.getElementById('vergi_dairesi_no').value,
			},
			success: function(response) {
				console.log(response);
				if (response.status == 200) {
					$(".vergi_kontrol").html(response.message);
					$(".vergi_kontrol").css("color", "green");

				} else {
					$(".vergi_kontrol").html(response.message);
					$(".vergi_kontrol").css("color", "red");
				}
			}
		});

	});
	$('#sabit_tel').on('change', function() {
		jQuery.ajax({
			url: "https://ihale.pertdunyasi.com/kurumsal_panel/islemler/profil_duzenle.php",
			type: "POST",
			dataType: "JSON",
			data: {
				action: "sabit_tel_kontrol",
				sabit_tel: document.getElementById('sabit_tel').value,
			},
			success: function(response) {
				console.log(response);
				if (response.status == 200) {
					$(".sabit_tel_kontrol").html(response.message);
					$(".sabit_tel_kontrol").css("color", "green");

				} else {
					$(".sabit_tel_kontrol").html(response.message);
					$(".sabit_tel_kontrol").css("color", "red");
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
		nesne_2.setAttribute("placeholder", "Telefonu");
		nesne_2.setAttribute("type", "tel");
		nesne_2.setAttribute("class", "form-control yedek_input");
		nesne_2.setAttribute("name", "yedek_kisi_tel[]");
		nesne_2.setAttribute("mask", "0(000)000-0000");
		nesne_2.setAttribute("maxlength", "14");

		var yedek_tel_div = document.getElementById("yedek_tel_div");
		yedek_tel_div.appendChild(nesne_2);
		$('input[type="tel"]').mask('0(000)000-0000');
	}

	function yedek_sil(id) {
		jQuery.ajax({
			url: "https://ihale.pertdunyasi.com/kurumsal_panel/islemler/profil_duzenle.php",
			type: "POST",
			dataType: "JSON",
			data: {
				action: "yedek_sil",
				yedek_id: id
			},
			success: function(response) {
				if (response.status == 200) {
					setTimeout(() => {
						location.reload();
					}, 150);
				}
			}
		});
	}

	function maxLengthCheck(object) {
		if (object.value.length > object.maxLength) {
			object.value = object.value.slice(0, object.maxLength)
		}

	}

	function isNumeric(evt) {
		var theEvent = evt || window.event;
		var key = theEvent.keyCode || theEvent.which;
		key = String.fromCharCode(key);
		var regex = /[0-9]|\./;
		if (!regex.test(key)) {
			theEvent.returnValue = false;
			if (theEvent.preventDefault) theEvent.preventDefault();
		}
	}
</script>

<script src="../js/cikis_yap.js?v=<?php echo time(); ?>"></script>
<script>
	setInterval(function() {
		cikis_yap("<?= $uye_token ?>");
	}, 300001);
	son_islem_guncelle("<?= $uye_token ?>");
	setInterval(function() {
		bildirim_sms();
	}, 1000);
</script>
<script>
	function isNumberKey(evt) {
		var charCode = (evt.which) ? evt.which : event.keyCode;
		if (charCode > 31 && (charCode < 48 || charCode > 57))
			return false;
		return true;
	}
</script>
</body>

</html>