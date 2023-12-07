<?php
session_start();
include('../ayar.php');
$token = $_SESSION['u_token'];
if (!empty($token)) {
	$uye_token = $token;
}
if (!isset($_SESSION['u_token'])) {
	echo '<script>alert("Devam Etmek İçin Lütfen Giriş Yapın !")</script>';
	echo '<script>window.location.href = "../index.php"</script>';
}
$ihale_cek = mysql_query("SELECT * FROM ilanlar ORDER BY ihale_tarihi DESC");
$dogrudan_cek = mysql_query("SELECT * FROM dogrudan_satisli_ilanlar");
$dogrudan_satis_sayisi = mysql_num_rows($dogrudan_cek);
$ihale_sayisi = mysql_num_rows($ihale_cek);
$kullanici_cek = mysql_query("SELECT * FROM `user` WHERE user_token = '" . $token . "'");
include 'template/sayi_getir.php';
include 'alert.php';
?>
<!doctype html>
<html lang="tr">

<head>
	<link rel="stylesheet" href="../css/uye_panel.css?v=15">
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
	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
	<link rel="stylesheet" href="css/menu.css">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.js"></script>
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
	<link rel="stylesheet" type="text/css" href="../slick_slider/slick/slick.css" />
	<link rel="stylesheet" type="text/css" href="../slick_slider/slick/slick-theme.css" />
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

		.deneme p {
			margin-bottom: 0px !important;
			margin-top: 0px !important;
			margin-left: 15px;
		}

		.container {
			max-width: 100% !important;
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
					//$siteye_giren_guncelle = mysql_query("update siteye_girenler set tarih = '".date('Y-m-d H:i:s')."' where ip_adresi = '".getIP()."'");
				}
			}
		}
	}
	$bugun = date("Y-m-d");
	$sorgu = mysql_query("SELECT * FROM kutlama_gorseli WHERE '$bugun' < reklam_bitis AND '$bugun' >= reklam_baslangic ORDER BY id ASC LIMIT 1 ");
	while ($yaz = mysql_fetch_array($sorgu)) { ?>
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
				<li class="nav-item active" style="font-size: small;">
					<?php $kullanici_oku = mysql_fetch_assoc($kullanici_cek);
					/*$cayma_cek_2 = mysql_query("SELECT * FROM cayma_bedelleri WHERE uye_id = '".$kullanici_oku['id']."' and durum = 1");          
						$toplam_aktif = mysql_query('SELECT SUM(net) AS net FROM cayma_bedelleri WHERE uye_id = "'.$kullanici_oku['id'].'" and durum=1'); 
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
					$cayma = $toplam_aktif_cayma["toplam_aktif_cayma"] - $toplam_borclar["toplam_borclar"];


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
					} ?>
					<a class="nav-link uyelik" style="font-weight: bold; color:<?= $color ?> !important;"><b><?= mb_strtoupper($paket_adi, "utf-8") ?> ÜYE</b></a>
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
						<?= $kullanici_oku['ad'] ?>
					</a>
					<div class="dropdown-menu" aria-labelledby="navbarDropdown" style="position: absolute; transform: translate3d(90px, 10px, 0px); top: 15px; left: -190px; will-change: transform;">
						<a class="dropdown-item" href="index.php">Üye Panelim</a>
						<?php if ($paket != "21") { ?>
							<a class="dropdown-item" href="islemler/gold_uyelik_basvuru.php?id=21">Gold Üyelik Başvurusu</a>
						<?php } ?>

						<?php
						$sozlesmeyi_cek = mysql_query("select * from uyelik_pdf where id = 1");
						$sozlesmeyi_bas = mysql_fetch_object($sozlesmeyi_cek);
						if ($_SESSION["u_token"] != "") {
							$uyelik_sozlesme = $sozlesmeyi_bas->bireysel_pdf;
						} else {
							$uyelik_sozlesme = $sozlesmeyi_bas->kurumsal_pdf;
						}
						?>
						<a class="dropdown-item" href="../images/pdf/<?= $uyelik_sozlesme ?>" target="_blank">Üyelik Sözleşmesi Görüntüle</a>
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
	<div class="container" style="margin-top:10%;">
		<div class="row">
			<div class="col-sm-4">
				<?php include 'template/sidebar.php'; ?>
			</div>
			<div class="col-sm-8">
				<?php
				// if(re('cayma_bedelini')=="Kaydet"){
				//   $gelen_iban = $_POST['iban_numarasi'];
				//   $sql = mysql_query("UPDATE cayma_bedelleri SET iban = '".$gelen_iban."' WHERE id = '".re('aktifin_idsi')."'");
				// }

				/*$toplam_aktif = mysql_query('SELECT SUM(net) AS net FROM cayma_bedelleri WHERE uye_id = "'.$kullanici_oku['id'].'" and durum=1'); 
					$toplam_getir = mysql_fetch_assoc($toplam_aktif); 
					$toplam_cayma = $toplam_getir['net'];

					$toplam_borc = mysql_query('SELECT SUM(net) AS net FROM cayma_bedelleri WHERE uye_id = "'.$kullanici_oku['id'].'" and durum=2'); 
					$toplam_borc_getir = mysql_fetch_assoc($toplam_borc); 
					$toplam_borc_cayma = $toplam_getir['net'];
					$aa=$toplam_cayma-toplam_borc_cayma;*/
				echo "Toplam Cayma Bedeli : ".'<uk style="font-weight: bold;">'.money($cayma).' ₺</uk>';

				$aktifi = mysql_query("SELECT * FROM cayma_bedelleri WHERE uye_id = '" . $kullanici_oku['id'] . "' AND durum = 1"); //Aktifler
				$aktifi_say = mysql_num_rows($aktifi);
				$iade_talepleri = mysql_query("SELECT * FROM cayma_bedelleri WHERE uye_id = '" . $kullanici_oku['id'] . "' AND durum = 2"); //İade Talepleri
				$iade_talepleri_say = mysql_num_rows($iade_talepleri);
				$iade_edilenler = mysql_query("SELECT * FROM cayma_bedelleri WHERE uye_id = '" . $kullanici_oku['id'] . "' AND durum = 3"); //İade Edilenler
				$iade_edilenler_say = mysql_num_rows($iade_edilenler);
				$mahsup_edilenler = mysql_query("SELECT * FROM cayma_bedelleri WHERE uye_id = '" . $kullanici_oku['id'] . "' AND durum = 4"); //Araç Bedeline Mahsup Edilenler
				$mahsup_edilenler_say = mysql_num_rows($mahsup_edilenler);
				$cayilan_araclar = mysql_query("SELECT * FROM cayma_bedelleri WHERE uye_id = '" . $kullanici_oku['id'] . "' AND durum = 5"); //Cayılan Araçlar
				$cayilan_araclar_say = mysql_num_rows($cayilan_araclar);
				$blokeli_borclar = mysql_query("SELECT * FROM cayma_bedelleri WHERE uye_id = '" . $kullanici_oku['id'] . "' AND durum = 6"); //Bloke İçin Bekleyen Borçlar
				$blokeli_borclar_say = mysql_num_rows($blokeli_borclar);
				$tahsil_edilenler = mysql_query("SELECT * FROM cayma_bedelleri WHERE uye_id = '" . $kullanici_oku['id'] . "' AND durum = 7"); //Tahsil Edilmiş Blokeli Borçlar
				$tahsil_edilenler_say = mysql_num_rows($tahsil_edilenler);
				?>
				<!-- <div class="row mt-5">
						<div class="col-sm-4">
							<a href="iade_olustur.php" class="btn btn-info btn-block">İade Talebi Oluştur</a>
						</div>
						<div class="col-sm-4"></div>
						<div class="col-sm-4"></div>
					</div> -->

				<?php
				$aktif_active = "";
				$aktif_show_active = "";
				$iade_talepleri_active = "";
				$iade_talepleri_show_active = "";
				$iade_edilenler_active = "";
				$iade_edilenler_show_active = "";
				$mahsup_edilenler_active = "";
				$mahsup_edilenler_show_active = "";
				$cayilan_araclar_active = "";
				$cayilan_araclar_show_active = "";
				$blokeli_borclar_active = "";
				$blokeli_borclar_show_active = "";
				$tahsil_edilenler_active = "";
				$tahsil_edilenler_show_active = "";

				if ($aktifi_say > 0) {
					$aktif_active = "page_select_tab_box";
					$aktif_show_active = "show active";
					$active_status = 'aktif';
				} else if ($iade_talepleri_say > 0) {
					$iade_talepleri_active = "page_select_tab_box";
					$iade_talepleri_show_active = "show active";
					$active_status = 'iade_talepleri';
				} else if ($iade_edilenler_say > 0) {
					$iade_edilenler_active = "page_select_tab_box";
					$iade_edilenler_show_active = "show active";
					$active_status = 'iade_edilenler';
				} else if ($mahsup_edilenler_say > 0) {
					$mahsup_edilenler_active = "page_select_tab_box";
					$mahsup_edilenler_show_active = "show active";
					$active_status = 'mahsup_edilenler';
				} else if ($cayilan_araclar > 0) {
					$cayilan_araclar_active = "page_select_tab_box";
					$cayilan_araclar_show_active = "show active";
					$active_status = 'cayilan_araclar';
				} else if ($blokeli_borclar_say > 0) {
					$blokeli_borclar_active = "page_select_tab_box";
					$blokeli_borclar_show_active = "show active";
					$active_status = 'bloke_bekleyenler';
				} else {
					$tahsil_edilenler_active = "page_select_tab_box";
					$tahsil_edilenler_show_active = "show active";
					$active_status = 'tahsil_edilenler';
				}
				?>

				<style>
					.page_tabs_outer {
						width: 100%;
						min-height: 20px;
						float: left;
						margin-top: 15px;
					}

					.page_tab_box {
						min-width: 10px;
						height: 45px;
						float: left;
						padding: 0px 18px;
						line-height: 45px;
						font-size: 15px;
						border-bottom: 1px solid #dadada;
						border-top-left-radius: 3px;
						border-top-right-radius: 3px;
						color: #007bff;
						cursor: pointer;
						transition: all 0.1s ease;
					}

					.page_tab_box:hover {
						border: 1px solid #eaeaea;
						padding: 0px 17px;
						line-height: 44px;
					}

					.page_select_tab_box {
						border: 1px solid #dadada;
						border-bottom: 0px;
						color: #333;
						line-height: 44px;
						padding: 0px 18px !important;
					}

					.card-body label {
						width: 100%;
						float: left;
						font-size: 16px;
						font-weight: 600;
						padding: 0px 15px;
						box-sizing: border-box;
						margin-bottom: 00px;
					}

					.card-body p {
						width: 100%;
						float: left;
						margin-bottom: 20px;
						font-size: 16px;
					}

					.card-header {
						font-size: 13px !important;
						font-weight: 500 !important;
					}
				</style>
				<input type="hidden" id="page_tab_status" value="<?php echo $active_status; ?>" />
				<div class="page_tabs_outer">
					<?php if ($aktifi_say > 0) { ?>
						<div>
							<a onclick="customTabOpen('aktif')">
								<div class="page_tab_box <?php echo $aktif_active; ?>" id="aktif_tabbox" onclick="updateTrigger('aktif-tab')">
									Aktif Cayma Bedelleri(<?= $aktifi_say ?>)
								</div>
							</a>
						</div>
					<?php }
					if ($iade_talepleri_say > 0) { ?>
						<div>
							<a onclick="customTabOpen('iade_talepleri')">
								<div class="page_tab_box <?php echo $iade_talepleri_active; ?>" id="iade_talepleri_tabbox" onclick="updateTrigger('iade_talepleri-tab')">
									İade Talepleri(<?= $iade_talepleri_say ?>)
								</div>
							</a>
						</div>
					<?php }
					if ($iade_edilenler_say > 0) { ?>
						<div>
							<a onclick="customTabOpen('iade_edilenler')">
								<div class="page_tab_box <?php echo $iade_edilenler_active; ?>" id="iade_edilenler_tabbox" onclick="updateTrigger('iade_edilenler-tab')">
									İade Edilenler(<?= $iade_edilenler_say ?>)
								</div>
							</a>
						</div>
					<?php }
					if ($mahsup_edilenler_say > 0) { ?>
						<div>
							<a onclick="customTabOpen('mahsup_edilenler')">
								<div class="page_tab_box <?php echo $mahsup_edilenler_active; ?>" id="mahsup_edilenler_tabbox" onclick="updateTrigger('mahsup_edilenler-tab')">
									Araç Bedeline Mahsup Edilenler(<?= $mahsup_edilenler_say ?>)
								</div>
							</a>
						</div>
					<?php }
					if ($cayilan_araclar_say > 0) { ?>
						<div>
							<a onclick="customTabOpen('cayilan_araclar')">
								<div class="page_tab_box <?php echo $cayilan_araclar_active; ?>" id="cayilan_araclar_tabbox" onclick="updateTrigger('cayilan_araclar-tab')">
									Cayılan Araçlar(<?= $cayilan_araclar_say ?>)
								</div>
							</a>
						</div>
					<?php }
					if ($blokeli_borclar_say > 0) {	?>
						<div>
							<a onclick="customTabOpen('bloke_bekleyenler')">
								<div class="page_tab_box <?php echo $blokeli_borclar_active; ?>" id="bloke_bekleyenler_tabbox" onclick="updateTrigger('bloke_bekleyenler-tab')">
									Bloke için Bekleyen Borçlar(<?= $blokeli_borclar_say ?>)
								</div>
							</a>
						</div>
					<?php }
					if ($tahsil_edilenler_say > 0) { ?>
						<div>
							<a onclick="customTabOpen('tahsil_edilenler')">
								<div class="page_tab_box <?php echo $tahsil_edilenler_active; ?>" id="tahsil_edilenler_tabbox" onclick="updateTrigger('tahsil_edilenler-tab')">
									Tahsil Edilmiş Blokeli Borçlar(<?= $tahsil_edilenler_say ?>)
								</div>
							</a>
						</div>
					<?php } ?>
				</div>
				<div class="clearfix"></div>

				<!-- <ul class="nav nav-tabs mt-5" id="myTab" role="tablist">
					<?php if ($aktifi_say > 0) { ?>
						<li onclick="updateTrigger('aktif-tab')" class="nav-item" role="presentation" style="font-size: 15px;">
							<a class="nav-link <?= $aktif_active ?>" id="aktif-tab" data-toggle="tab" href="#aktif" role="tab" aria-controls="aktif" aria-selected="false">Aktif Cayma Bedelleri(<?= $aktifi_say ?>) </a>
						</li>
					<?php }
					if ($iade_talepleri_say > 0) { ?>
						<li onclick="updateTrigger('iade_talepleri-tab')" class="nav-item" role="presentation" style="font-size: 15px;">
							<a class="nav-link <?= $iade_talepleri_active ?> " id="iade_talepleri-tab" data-toggle="tab" href="#iade_talepleri" role="tab" aria-controls="iade_talepleri" aria-selected="false">İade Talepleri(<?= $iade_talepleri_say ?>) </a>
						</li>
					<?php }
					if ($iade_edilenler_say > 0) { ?>
						<li onclick="updateTrigger('iade_edilenler-tab')"  class="nav-item" role="presentation" style="font-size: 15px;">
							<a class="nav-link <?= $iade_edilenler_active ?> " id="iade_edilenler-tab" data-toggle="tab" role="tab" href="#iade_edilenler" aria-controls="iade_edilenler" aria-selected="false">İade Edilenler(<?= $iade_edilenler_say ?>) </a>
						</li>
					<?php }
					if ($mahsup_edilenler_say > 0) { ?>
						<li onclick="updateTrigger('mahsup_edilenler-tab')"  class="nav-item" role="presentation" style="font-size: 15px;">
							<a class="nav-link <?= $mahsup_edilenler_active ?>" id="mahsup_edilenler-tab" data-toggle="tab" href="#mahsup_edilenler" role="tab" aria-controls="mahsup_edilenler" aria-selected="false">Araç Bedeline Mahsup Edilenler(<?= $mahsup_edilenler_say ?>) </a>
						</li>
					<?php }
					if ($cayilan_araclar_say > 0) { ?>
						<li onclick="updateTrigger('cayilan_araclar-tab')"  class="nav-item" role="presentation" style="font-size: 15px;">
							<a class="nav-link <?= $cayilan_araclar_active ?>" id="cayilan_araclar-tab" data-toggle="tab" href="#cayilan_araclar" role="tab" aria-controls="cayilan_araclar" aria-selected="false">Cayılan Araçlar(<?= $cayilan_araclar_say ?>) </a>
						</li>
					<?php }
					if ($blokeli_borclar_say > 0) {	?>
						<li onclick="updateTrigger('bloke_bekleyenler-tab')"  class="nav-item" role="presentation" style="font-size: 15px;">
							<a class="nav-link <?= $blokeli_borclar_active ?>" id="bloke_bekleyenler-tab" data-toggle="tab" href="#bloke_bekleyenler" role="tab" aria-controls="bloke_bekleyenler" aria-selected="false">Bloke için Bekleyen Borçlar(<?= $blokeli_borclar_say ?>) </a>
						</li>
					<?php }
					if ($tahsil_edilenler_say > 0) { ?>
						<li onclick="updateTrigger('tahsil_edilenler-tab')"  class="nav-item" role="presentation" style="font-size: 15px;">
							<a class="nav-link <?= $tahsil_edilenler_active ?>" id="tahsil_edilenler-tab" data-toggle="tab" href="#tahsil_edilenler" role="tab" aria-controls="tahsil_edilenler" aria-selected="false">Tahsil Edilmiş Blokeli Borçlar(<?= $tahsil_edilenler_say ?>) </a>
						</li>
					<?php } ?>
				</ul> -->
				<?php
				$today = date('Y-m-d');
				$odeme_cek = mysql_query("SELECT * FROM kazanilanlar WHERE uye_id = '" . $uyeID . "' AND durum = 1 OR durum = 0");
				$odeme_say = mysql_num_rows($odeme_cek);
				$teklif_cek = mysql_query("SELECT * FROM teklifler WHERE uye_id = '" . $uyeID . "'");
				while ($teklif_oku = mysql_fetch_assoc($teklif_cek)) {
					$ilan_cek = mysql_query("SELECT * FROM ilanlar WHERE id = '" . $teklif_oku['ilan_id'] . "' AND ihale_tarihi >= '" . $today . "'");
					$ilan_say = mysql_num_rows($ilan_cek);
					if ($odeme_say > 0 || $ilan_say > 0) {
						$display = "none";
					}
				}
				?>
				<div class="tab-content" id="myTabContent">
					<div class="tab-pane fade <?= $aktif_show_active ?>" id="aktif" role="tabpanel" aria-labelledby="aktif-tab" style="margin-top: 3%;">
						<div class="row">
							<?php
							while ($cayma_oku2 = mysql_fetch_array($aktifi)) {
								$cayma_id = $cayma_oku2['id'];
							?>
								<div class="col-4">
									<div class="card text-white bg-success mb-3" style="max-width: 18rem;">
										<div class="card-header" style="text-align: right; font-size:small;">Gönderildiği Tarih : <?= date("d-m-Y", strtotime($cayma_oku2['paranin_geldigi_tarih'])) ?></div>
										<div class="card-body">
											<div class="row">
												<input type="hidden" name="aktifin_idsi" value="<?= $cayma_oku2['id'] ?>">
												<label for="IDofInput">Tutar</label>
												<p class="col-sm-12"><?= money($cayma_oku2['tutar']) ?>₺</p>

												<label for="IDofInput">İade Edilecek Hesap Sahibi</label>
												<p class="col-sm-12"><?= $cayma_oku2['hesap_sahibi'] ?></p>

												<label for="IDofInput">İade Edilecek IBAN Numarası</label>
												<div class="input-group flex-nowrap">
													<div class="input-group-prepend">
														<span class="input-group-text" id="addon-wrapping">TR</span>
													</div>
													<input type="text" name="iban_numarasi" class="form-control" id="iban_no<?= $cayma_id ?>" value="<?= $cayma_oku2['iban'] ?>" onkeypress="return isNumberKey(event);" maxLength="24" minlength="24" placeholder="Başında TR olmadan sadece rakam girebilirsiniz.">
												</div>
												<input type="button" onclick="SonibanGuncelle(<?= $cayma_id ?>)" class="btn btn-primary" name="cayma_bedelini" value="Kaydet">
											</div>
										</div>
										<div class="card-footer" style="text-align: right;">
											Seç
											<input type="checkbox" class="checkbox_check" name="caymaID" id="caymaID" value="<?= $cayma_id ?>">
											<input type="hidden" id="durum" value="<?= $cayma_oku2['durum'] ?>">
										</div>
									</div>
								</div>
							<?php } ?>
						</div>
						<div class="row">
							<div class="col-sm-8"></div>
							<div class="col-sm-4">
								<input type="button" name="talep" onclick="talepGonder()" class="btn btn-danger btn-block" value="İade Talebi Gönder">
							</div>
						</div>
					</div>
					<div class="tab-pane fade <?= $iade_talepleri_show_active ?>" id="iade_talepleri" role="tabpanel" aria-labelledby="borc-tab" style="margin-top: 3%;">
						<div class="row">
							<?php while ($cayma_borc_oku = mysql_fetch_array($iade_talepleri)) {
								$cayma_borc_id = $cayma_borc_oku['id'];
								// style="display: $display  259.satıra
							?>
								<div class="col-4">
									<div class="card text-white mb-3" style="max-width: 18rem;background-color: blue;">
										<div class="card-header" style="text-align: right; font-size:small;">İade Talep Tarihi : <?= date("d-m-Y", strtotime($cayma_borc_oku['iade_talep_tarihi'])) ?></div>
										<div class="card-body">
											<div class="row">
												<label for="IDofInput">Tutar</label>
												<p class="col-sm-12"><?= money($cayma_borc_oku['tutar']) ?>₺</p>

												<label for="IDofInput">İade Edilecek Hesap Sahibi</label>
												<p class="col-sm-12"><?= $cayma_borc_oku['hesap_sahibi'] ?></p>

												<label for="IDofInput">İade Edilecek IBAN Numarası</label>
												<p class="col-sm-12">TR <?= $cayma_borc_oku['iban'] ?></p>
											</div>
										</div>
									</div>
								</div>
							<?php } ?>
						</div>
					</div>
					<div class="tab-pane fade <?= $iade_edilenler_show_active ?>" id="iade_edilenler" role="tabpanel" aria-labelledby="talep-tab" style="margin-top: 3%;">
						<div class="row">
							<?php while ($cayma_talep_oku = mysql_fetch_array($iade_edilenler)) {
								$cayma_talep_id = $cayma_talep_oku['id'];
							?>
								<div class="col-4">
									<div class="card text-white mb-3" style="max-width: 18rem;background-color:gray !important">
										<div class="card-header" style="text-align: right; font-size:small;">İade Tarihi : <?= date("d-m-Y", strtotime($cayma_talep_oku['iade_tarihi'])) ?></div>
										<div class="card-body">
											<div class="row">
												<label for="IDofInput">Tutar</label>
												<p class="col-sm-12"><?= money($cayma_talep_oku['tutar']) ?>₺</p>

												<label for="IDofInput">İade Edilen Hesap Sahibi</label>
												<p class="col-sm-12"><?= $cayma_talep_oku['hesap_sahibi'] ?></p>

												<label for="IDofInput">İade Edilen IBAN Numarası</label>
												<p class="col-sm-12">TR <?= $cayma_talep_oku['iban'] ?></p>
											</div>
										</div>
									</div>
								</div>
							<?php } ?>
						</div>
					</div>
					<div class="tab-pane fade <?= $mahsup_edilenler_show_active ?>" id="mahsup_edilenler" role="tabpanel" aria-labelledby="iade-tab" style="margin-top: 3%;">
						<div class="row">
							<?php while ($cayma_aldigi_oku = mysql_fetch_array($mahsup_edilenler)) {
								$cayma_aldigi_id = $cayma_aldigi_oku['id'];
							?>
								<div class="col-4">
									<div class="card text-white bg-success mb-3" style="max-width: 18rem;background-color:gray !important">
										<div class="card-header" style="text-align: right; font-size:small;">Mahsup Tarihi : <?= date("d-m-Y", strtotime($cayma_aldigi_oku['mahsup_tarihi'])) ?></div>
										<div class="card-body">
											<div class="row">
												<label for="IDofInput">Konu Araç</label>
												<p class="col-sm-12">#<?= $cayma_aldigi_oku["arac_kod_plaka"] ?> / <?= $cayma_aldigi_oku["arac_detay"] ?></p>
												<label for="IDofInput">Tutar</label>
												<p class="col-sm-12"><?= money($cayma_aldigi_oku['tutar']) ?>₺</p>
											</div>
										</div>
									</div>
								</div>
							<?php } ?>
						</div>
					</div>
					<div class="tab-pane fade <?= $cayilan_araclar_show_active ?>" id="cayilan_araclar" role="tabpanel" aria-labelledby="iade-tab" style="margin-top: 3%;">
						<div class="row">
							<?php while ($cayma_aldigi_oku = mysql_fetch_array($cayilan_araclar)) {
								$cayma_aldigi_id = $cayma_aldigi_oku['id'];
							?>
								<div class="col-4">
									<div class="card text-white bg-success mb-3" style="max-width: 18rem;background-color:gray !important">
										<div class="card-header" style="text-align: right; font-size:small;">Araçtan Cayma Tarihi : <?= date("d-m-Y", strtotime($cayma_aldigi_oku['bloke_tarihi'])) ?></div>
										<div class="card-body">
											<div class="row">
												<label for="IDofInput">Konu Araç</label>
												<p class="col-sm-12">#<?= $cayma_aldigi_oku["arac_kod_plaka"] ?> / <?= $cayma_aldigi_oku["arac_detay"] ?></p>
												<label for="IDofInput">Tutar</label>
												<p class="col-sm-12"><?= money($cayma_aldigi_oku['tutar']) ?>₺</p>
											</div>
										</div>
									</div>
								</div>
							<?php } ?>
						</div>
					</div>
					<div class="tab-pane fade <?= $blokeli_borclar_show_active ?>" id="bloke_bekleyenler" role="tabpanel" aria-labelledby="iade-tab" style="margin-top: 3%;">
						<div class="row">
							<?php while ($cayma_aldigi_oku = mysql_fetch_array($blokeli_borclar)) {
								$cayma_aldigi_id = $cayma_aldigi_oku['id'];
							?>
								<div class="col-4">
									<div class="card text-white bg-success mb-3" style="max-width: 18rem;background-color:#dc3545 !important">
										<div class="card-header" style="text-align: right; font-size:small;">Borç Tarihi : <?= date("d-m-Y", strtotime($cayma_aldigi_oku['bloke_tarihi'])) ?></div>
										<div class="card-body">
											<div class="row">
												<?php
												if ($cayma_aldigi_oku["arac_kod_plaka"] != "") { ?>
													<label for="IDofInput">Konu Araç</label>
													<p class="col-sm-12">#<?= $cayma_aldigi_oku["arac_kod_plaka"] ?> / <?= $cayma_aldigi_oku["arac_detay"] ?></p>
												<?php } ?>
												<label for="IDofInput">Tutar</label>
												<p class="col-sm-12"><?= money($cayma_aldigi_oku['tutar']) ?>₺</p>
											</div>
										</div>
									</div>
								</div>
							<?php } ?>
						</div>
					</div>
					<div class="tab-pane fade <?= $tahsil_edilenler_show_active ?>" id="tahsil_edilenler" role="tabpanel" aria-labelledby="iade-tab" style="margin-top: 3%;">
						<div class="row">
							<?php while ($cayma_aldigi_oku = mysql_fetch_array($tahsil_edilenler)) {

								$cayma_aldigi_id = $cayma_aldigi_oku['id'];
							?>
								<div class="col-4">
									<div class="card text-white bg-success mb-3" style="max-width: 18rem;background-color:gray !important">
										<div class="card-header" style="text-align: right; font-size:small;">Tahsil Tarihi : <?= date("d-m-Y", strtotime($cayma_aldigi_oku['tahsil_tarihi'])) ?></div>
										<div class="card-body">
											<div class="row">
												<label for="IDofInput">Borç Tarihi</label>
												<p class="col-sm-12"><?= date("d-m-Y", strtotime($cayma_aldigi_oku['bloke_tarihi'])) ?></p>
												<label for="IDofInput">Konu Araç</label>
												<p class="col-sm-12">#<?= $cayma_aldigi_oku["arac_kod_plaka"] ?> / <?= $cayma_aldigi_oku["arac_detay"] ?></p>
												<label for="IDofInput">Tutar</label>
												<p class="col-sm-12"><?= money($cayma_aldigi_oku['tutar']) ?>₺</p>
											</div>
										</div>
									</div>
								</div>
							<?php } ?>
						</div>
					</div>

				</div>
			</div>
		</div>
	</div>
	<?php include 'template/footer.php'; ?>
	<style>
		.swal-modal .swal-text {
			text-align: center;
		}
	</style>

	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
	<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
	<script src="https://kit.fontawesome.com/2fdd899201.js" crossorigin="anonymous"></script>
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
	<script type="text/javascript" src="../slick_slider/slick/slick.min.js"></script>
	<script src="../js/cikis_yap.js?v=<?php echo time(); ?>"></script>
	<script>
		$('.page_tabs_outer').slick({
			dots: false,
			arrows: false,
			infinite: false,
			speed: 300,
			slidesToShow: 1,
			variableWidth: true
		});

		function customTabOpen(item) {
			var status = document.getElementById("page_tab_status").value;

			if (status != item) {
				document.getElementById(item).style.display = "block";
				document.getElementById(item).style.opacity = "1";
				document.getElementById(item + "_tabbox").classList.add("page_select_tab_box");

				document.getElementById(status).style.display = "none";
				document.getElementById(status).style.opacity = "0";
				document.getElementById(status + "_tabbox").classList.remove("page_select_tab_box");

				document.getElementById("page_tab_status").value = item;
			}
		}

		function talepGonder() {
			var caymaID = $('input:checked').val();
			var $value = $('#iban_no' + caymaID).val();
			if ($('input.checkbox_check').is(':checked')) {
				if ($value != null && $value != "" && $value != undefined) {
					var span = document.createElement("span");
					span.innerHTML = "<b style='color:#000;'>İadeler sadece parayı gönderen kişi/kurum ların hesaplarına yapılabilir. Lütfen sadece  Hesap sahibi kısmında belirtilen Şahıs ya da Kuruma Ait IBAN numarası giriniz. Hesap sahibi ile IBAN no eşleşmemesi halinde yaşanacak aksaklıklardan üyelik sahibi sorumludur. Gönder butonuna basmanız halinde IBAN üzerinde düzenleme yapamayacaksınız. Bu talep sonrası kalan bakiyeniz limitlerinde teklif verebileceksiniz</b>";
					swal({
							html: true,
							content: span,
							icon: "warning",
							buttons: true,
							dangerMode: true,
							buttons: ["İptal", "Tamam"],
						})
						.then((willDelete) => {
							if (willDelete) {
								var caymaID = $('input:checked').val();
								console.log(caymaID);
								var durum = $('#durum').val();
								var iban_no = $('#iban_no').val();
								if ($('input.checkbox_check').is(':checked')) {
									if (iban_no == '') {
										alert('Lütfen seçim yaptığınızdan ve iban girdiğinizden emin olun.');
									} else {
										var array = [];
										$("input.checkbox_check:checked").each(function() {
											array.push($(this).val());
										});
										console.log(array);
										$.ajax({
											url: 'islemler/cayma_talebi_gonder.php',
											method: 'post',
											dataType: "json",
											data: {
												action: "cayma_talep",
												caymalar: array,
											},
											success: function(data) {
												console.log(data);
												if (data.status == 200) {
													$('.success').removeClass('d-none').html(data);
													alert('İade talebiniz başarılı bir şekilde iletildi.');
													location.reload();
												} else {
													$('.error').removeClass('d-none').html(data);
													swal("Hata!", data.message, "error")
												}

											},
											error: function(data) {
												$('.error').removeClass('d-none').html(data);
												alert('HATA! Lütfen tekrar deneyiniz.')
											}
										});
									}
								} else {
									alert('Lütfen seçim yaptığınızdan ve iban girdiğinizden emin olun.');
								}
							} else {
								swal("İşlem iptal edildi!");
							}
						});
				} else {
					alert("LÜTFEN İADE EDİLECEK HESAP SAHİBİNE AİT BİR IBAN NUMARASI GİRİNİZ");
				}
			} else {
				alert("Lütfen iade talebi oluşturmak istediğiniz cayma bedelini seçiniz");
			}

			/*
			var span = document.createElement("span");
			span.innerHTML = "<b style='color:#000;'>İadeler sadece parayı gönderen kişi/kurum ların hesaplarına yapılabilir. Lütfen sadece  Hesap sahibi kısmında belirtilen Şahıs ya da Kuruma Ait IBAN numarası giriniz. Hesap sahibi ile IBAN no eşleşmemesi halinde yaşanacak aksaklıklardan üyelik sahibi sorumludur. Gönder butonuna basmanız halinde IBAN üzerinde düzenleme yapamayacaksınız. Bu talep sonrası kalan bakiyeniz limitlerinde teklif verebileceksiniz</b>";
			swal({
				html:true,
				content: span,
				icon: "warning",
				buttons: true,
				dangerMode: true,
				buttons: ["İptal", "Tamam"],
			})
			.then((willDelete) => {
				if (willDelete) {
					var caymaID = $('input:checked').val();
					console.log(caymaID);
					var durum = $('#durum').val();
					var iban_no = $('#iban_no').val();
					if ($('input.checkbox_check').is(':checked')) {
						if (iban_no == '' ) {
							alert('Lütfen seçim yaptığınızdan ve iban girdiğinizden emin olun.');
						}else {
							var array=[];
							$("input.checkbox_check:checked").each(function(){
								array.push($(this).val());
							});
							console.log(array);
							$.ajax({
								url: 'islemler/cayma_talebi_gonder.php',
								method: 'post',
								dataType: "json",
								data: {
									action:"cayma_talep",
									caymalar: array,
								},
								success: function(data) {
									console.log(data);
									if(data.status==200){
										$('.success').removeClass('d-none').html(data);
										alert('İade talebiniz başarılı bir şekilde iletildi.');
										location.reload();
									}else{
										$('.error').removeClass('d-none').html(data);
										swal("Hata!",data.message,"error")
									}
								
								},
								error: function(data) {
									$('.error').removeClass('d-none').html(data);
									alert('HATA! Lütfen tekrar deneyiniz.')
								}
							});
						}
					}else{
						 alert('Lütfen seçim yaptığınızdan ve iban girdiğinizden emin olun.');
					}
				} else {
					swal("İşlem iptal edildi!");
				}
			});
			*/
		}
	</script>
	<script>
		setInterval(function() {
			cikis_yap("<?= $uye_token ?>");
		}, 300001);

		son_islem_guncelle("<?= $uye_token ?>");
		setInterval(function() {
			bildirim_sms();
		}, 1000);

		function isNumberKey(evt) {
			var charCode = (evt.which) ? evt.which : event.keyCode;
			if (charCode > 31 && (charCode < 48 || charCode > 57))
				return false;
			return true;
		}
	</script>
	<script>
		function SonibanGuncelle(cayma_id) {
			var cayma_id = cayma_id;
			var iban_no = document.getElementById('iban_no' + cayma_id).value;
			var iban_length = iban_no.length;
			if (iban_length == 24) {
				if (cayma_id) {
					jQuery.ajax({
						url: "../cayma_duzenle.php",
						type: "POST",
						dataType: "JSON",
						data: {
							action: "cayma_duzenle",
							cayma_id: cayma_id,
							iban_no: iban_no,
						},
						success: function(response) {
							console.log(response);
							if (response.status == 200) {
								swal("BAŞARILI", response.message, "success");
							} else {
								swal("HATA", response.message, "error");
							}
						}
					});
				} else {
					console.log("hata");
				}
			} else {
				swal("HATA", "IBAN Numarası 24 karakter olmalıdır", "error");
			}
		}
	</script>
	<script>
		function TriggerVarMi() {
			var trigger_sor = localStorage.getItem('trigger');
			if (trigger_sor != "" && trigger_sor != undefined) {
				//console.log(document.getElementById(trigger_sor)+"!="+null);
				if (document.getElementById(trigger_sor) != null) {
					console.log(trigger_sor);
					document.getElementById(trigger_sor).click();
					localStorage.removeItem("trigger");
				} else {
					localStorage.removeItem("trigger");
				}
			}
		}

		function updateTrigger(id) {
			localStorage.setItem("trigger", id);
		}
		window.onload = TriggerVarMi;
	</script>
</body>

</html>