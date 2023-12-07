<?php
session_start();
include('../ayar.php');

$a1 = $_SERVER['HTTP_USER_AGENT'];
$os        = getOS();
$browser   = getBrowser();

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
include 'template/sayi_getir.php';
include 'alert.php';

$getUserInfo = mysql_query("
	SELECT 
		* 
	FROM 
		user 
	WHERE 
	kurumsal_user_token = '$uye_token' AND 
	kurumsal_user_token <> '0'
	");
$userInfo = mysql_fetch_object($getUserInfo);

$getAllFavoriteRecords = mysql_query("
	SELECT 
		f.*  
    FROM 
      favoriler AS f 
	INNER JOIN 
		ilanlar AS i 
	ON 
		f.ilan_id = i.id 
    WHERE 
		f.uye_id = '$userInfo->id' 
     
    ");

// Sayfalama
if (isset($_GET['sayfa'])) {
	$sayfa = $_GET['sayfa'];
} else {
	$sayfa = 1;
}
$sayfada = 10;
$offset = ($sayfa - 1) * $sayfada;


//  $toplam_sayfa_sql = mysql_query("SELECT COUNT(*) FROM ilanlar");
//  $toplam_ihale = mysql_fetch_array($toplam_sayfa_sql)[0];
$toplam_ihale = mysql_num_rows($getAllFavoriteRecords);

$toplam_sayfa = ceil($toplam_ihale / $sayfada);
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
	<script>
		/*setInterval(function(){
			window.location.reload(false);
		},60000);*/
	</script>
	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
	<link rel="stylesheet" href="css/menu.css">
	<link rel="stylesheet" type="text/css" href="../js/toastr/toastr.css" rel="stylesheet">
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

		a.disabled {
			pointer-events: none;
			cursor: default;
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
	<style>
		.swal-text {
			color: #000;
		}

		.swal-button {
			color: #000;
			background: #ffc107;
		}

		.modal_zindex {
			z-index: 1 !important;
		}

		.mavi {
			background-color: rgb(154, 173, 233);
		}

		.ihale ul {
			height: 400px;
			width: 100%;
			list-style-type: none;
		}

		.ihale ul {
			overflow: hidden;
			overflow-y: scroll;
		}

		/* .ihale{
				margin-top: -60px;
			} */
		/* .list-group{
				margin-top: 10px;
			} */
	</style>
	<style>
		.ilan_karti_dis {
			min-height: 10px;
			float: left;
			margin: 10px 0px;
			padding: 0px;
		}

		.ilan_karti_baslik {
			height: 35px;
			background-color: orange;
			float: left;
			padding: 0px;
			line-height: 35px;
			padding-left: 10px;
			font-weight: 600;
		}

		.ilan_karti_baslik span {
			float: right;
			background-color: #364d59;
			height: 35px;
			padding: 0px 20px;
			line-height: 35px;
			color: #ffffff;
			font-weight: 600;
		}

		.ilan_karti_icerik_dis {
			min-height: 20px;
			background-color: #ffffff;
			float: left;
			border: 1px solid #dadada;
			border-top: 0px;
			padding: 0px;
		}

		.ilan_karti_gorsel_dis {
			width: 200px;
			float: left;
			background-color: maroon;
			background-image: url('images/default.png');
			position: relative;
			background-position: center;
			background-size: cover;
		}

		.ilan_karti_gorsel_dis:after {
			content: "";
			display: block;
			padding-bottom: 100%;
		}

		.ilan_karti_kod {
			height: 40px;
			float: left;
			position: absolute;
			left: 0px;
			bottom: 0px;
			/* background-color: #364d59; */
			background-color: #364d59c4;
			display: flex;
			align-items: center;
			padding: 10px;
			color: #fff;
		}

		.ilan_karti_gorsel_icerik {
			width: calc(100% - 200px);
			min-height: 200px;
			float: left;
			padding: 10px;
		}

		.ilan_karti_taglar_dis {
			min-height: 20px;
			float: left;
			padding: 0px;
		}

		.ilan_karti_tag {
			min-width: 10px;
			height: 30px;
			float: left;
			background-color: #f1f1f1;
			margin-right: 10px;
			margin-bottom: 10px;
			padding: 0px 8px;
			line-height: 30px;
			font-weight: 600;
			font-size: 12px;
		}

		.ilan_karti_alt_alan {
			min-height: 10px;
			float: left;
			padding: 0px;
		}

		.ilan_karti_notlar_dis {
			min-height: 10px;
			float: left;
			padding: 0px;
		}

		.ilan_karti_not_baslik {
			min-height: 10px;
			float: left;
			padding: 0px;
		}

		.ilan_karti_not_alan {
			height: 75px;
			float: left;
			background-color: #f7f7f7;
			float: left;
			margin-top: 10px;
			padding: 8px;
			font-size: 13px;
			overflow-y: scroll;
			border: 1px solid #eaeaea;
		}

		.ilan_karti_begeni_dis {
			height: 26px;
			float: left;
			margin-top: 5px;
			padding: 0px;
		}

		.ilan_karti_begeni_dis span {
			width: 26px;
			height: 26px;
			background-color: #e6e6e6;
			margin-right: 10px;
			float: left;
			text-align: center;
			line-height: 27px;
			color: orange;
			border-radius: 3px;
		}

		.ilan_karti_teklif_dis {
			min-height: 10px;
			float: left;
		}

		.ilan_karti_teklif_baslik {
			height: 30px;
			float: left;
			text-align: center;
			line-height: 30px;
			font-weight: 600;
			font-size: 18px;
		}

		.ilan_karti_teklif_fiyat {
			min-height: 20px;
			float: left;
			text-align: center;
			font-size: 35px;
			font-weight: 700;
		}

		.ilan_karti_teklif_btnlar {
			min-height: 20px;
			float: left;
			padding: 0px;
		}

		.ilan_karti_teklif_btn {
			width: calc(50% - 10px);
			height: 47px;
			float: left;
			margin: 5px;
			text-align: center;
			line-height: 47px;
			color: #ffffff;
			border-radius: 4px;
			font-weight: 500;
		}

		@media only screen and (max-width: 600px) {
			.ilan_karti_baslik {
				font-size: 9px;
				padding-left: 5px;
			}

			.ilan_karti_gorsel_dis {
				width: 100%;
			}

			.ilan_karti_gorsel_icerik {
				width: 100%;
			}

			.ilan_karti_begeni_dis {
				display: flex;
				align-items: center;
				justify-content: center;
				margin-bottom: 15px;
				margin-top: 15px;
			}

			.ilan_karti_begeni_dis span {
				width: 35px;
				height: 35px;
				line-height: 35px;
			}
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

	$bugun = date("Y-m-d");
	$sorgu = mysql_query("SELECT * FROM kutlama_gorseli WHERE '$bugun' < reklam_bitis AND '$bugun' >= reklam_baslangic ORDER BY id ASC LIMIT 1 ");
	while ($yaz = mysql_fetch_array($sorgu)) {	?>
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
					<?php
					$kullanici_oku = mysql_fetch_assoc($kullanici_cek);
					$uye_id = $kullanici_oku['id'];

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
					}

					?>
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
						<?= $kullanici_oku['unvan'] ?>
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
				/*$favorileri_cek = mysql_query("SELECT 
						f.*  
						FROM 
						teklifler AS f INNER JOIN 
						ilanlar AS i ON 
						f.ilan_id = i.id 
						WHERE 
						f.durum = 1 and
						f.uye_id = '$userInfo->id' 
						group by i.id
						order by ihale_tarihi asc
					");*/
				/*$favorileri_cek=mysql_query("
									(SELECT 
										ilanlar.*,unix_timestamp(concat(ilanlar.ihale_tarihi,' ',ilanlar.ihale_saati)) as ihale_son
									from 
										ilanlar
									inner join 
										teklifler
										on
											teklifler.ilan_id=ilanlar.id and 
											teklifler.uye_id='381'
									inner join
										kazanilan_ilanlar 
										on
											kazanilan_ilanlar.ilan_id !=ilanlar.id and
											kazanilan_ilanlar.uye_id !='381'
									WHERE
										ilanlar.durum='1'

									)
										UNION
									(
									SELECT 
										ilanlar.*,concat(ilanlar.ihale_tarihi,' ',ilanlar.ihale_saati) as ihale_son2
									from 
										ilanlar
									inner join 
										teklifler
										on
											teklifler.ilan_id=ilanlar.id and 
											teklifler.uye_id='381'
									inner join
										kazanilan_ilanlar 
										on
											kazanilan_ilanlar.ilan_id !=ilanlar.id and
											kazanilan_ilanlar.uye_id !='381'
									WHERE
										ilanlar.durum!='1'

									)
									ORDER BY
										ihale_son asc
					");*/
				$favorileri_cek = mysql_query("
									(SELECT 
										ilanlar.*,unix_timestamp(concat(ilanlar.ihale_tarihi,' ',ilanlar.ihale_saati)) as ihale_son
									from 
										ilanlar
									inner join 
										teklifler
										on
											teklifler.ilan_id=ilanlar.id and 
											teklifler.uye_id='" . $uye_id . "' and
											teklifler.durum = 1
									WHERE
										ilanlar.durum='1'

									)
										UNION
									(
									SELECT 
										ilanlar.*,concat(ilanlar.ihale_tarihi,' ',ilanlar.ihale_saati) as ihale_son2
									from 
										ilanlar
									inner join 
										teklifler
										on
											teklifler.ilan_id=ilanlar.id and 
											teklifler.uye_id='" . $uye_id . "'
									WHERE
										ilanlar.durum!='1'

									)
									ORDER BY
										ihale_son asc
					");
				// $favorileri_cek = mysql_query("SELECT DISTINCT ilan_id FROM favoriler WHERE user_token = '".$uye_token."'");
				$favori_sayisi = mysql_num_rows($favorileri_cek);
				$ihale_say = mysql_num_rows($favorileri_cek);
				$sira = 0;
				$sira_array = array();
				$modal_array = array();
				while ($favori_oku = mysql_fetch_array($favorileri_cek)) {
					$kazanilan_cek = mysql_query("select * from kazanilan_ilanlar where ilan_id='" . $favori_oku['id'] . "' and uye_id='" . $uye_id . "'");
					$kazanilan_say = mysql_num_rows($kazanilan_cek);
					if ($kazanilan_say == 0) {
						//$ilan_favori_id = $favori_oku['ilan_id'];
						$ilan_favori_id = $favori_oku['id'];
						$dogrudan_favori_id = $favori_oku['dogrudan_satisli_id'];
						$sql = mysql_query("SELECT * FROM ilanlar WHERE id= '" . $ilan_favori_id . "'");
						$ihale_oku = mysql_fetch_assoc($sql);
						$yasakli_sigorta = mysql_query("SELECT * FROM uye_durumlari WHERE uye_id = '" . $uye_id . "'");
						$yasakli_sigorta_cek = mysql_fetch_assoc($yasakli_sigorta);
						$yasaki_sigorta_id = $yasakli_sigorta_cek["yasak_sigorta"];
						$sigorta_cek = mysql_query("SELECT * FROM sigortalar WHERE sigorta_id = '" . $ihale_oku['sigorta'] . "' and paket_id='" . $paket . "'");
						$sigorta_oku = mysql_fetch_assoc($sigorta_cek);

						$sgrt_cek = mysql_query("select * from sigorta_ozellikleri where id='" . $ihale_oku['sigorta'] . "'");
						$sgrt_oku = mysql_fetch_array($sgrt_cek);

						$secilen_yetki_id = $sigorta_oku['secilen_yetki_id'];
						$detay_gorur = $sigorta_oku['detay_gorur'];
						$ilan_resim_cek = mysql_query("SELECT * FROM ilan_resimler WHERE ilan_id = '" . $ihale_oku['id'] . "'");
						$ilan_resim_oku = mysql_fetch_assoc($ilan_resim_cek);
						$ilan_resmi = $ilan_resim_oku['resim'];
						if(mysql_num_rows($ilan_resim_cek) == 0){
							$ilan_resmi = "default.png";
						}
						$renkli_uye_bul = mysql_query("SELECT * FROM user WHERE kurumsal_user_token = '" . $_SESSION['u_token'] . "'");
						$renkli_uye_oku = mysql_fetch_assoc($renkli_uye_bul);
						$renkli_uye_id = $renkli_uye_oku['id'];

						$bildirimli_mi = mysql_query("SELECT * FROM bildirimler WHERE uye_id = '" . $renkli_uye_id . "' AND ilan_id = '" . $ihale_oku['id'] . "'");
						$bildirimli_say = mysql_num_rows($bildirimli_mi);
						if ($bildirimli_say == 0) {
							$bidlirim_color = "gray";
							$bildirim_title = "Araç bildirimi açılacaktır.";
						} else {
							$bidlirim_color = "orange";
							$bildirim_title = "Araç bildirimi kapatılacaktır.";
						}

						$favli_mi = mysql_query("SELECT * FROM favoriler WHERE uye_id = '" . $renkli_uye_id . "' AND ilan_id = '" . $ihale_oku['id'] . "'");
						$favli_say = mysql_num_rows($favli_mi);
						if ($favli_say == 0) {
							$fav_color = "gray";
							$fav_title = "Araç favorilerinize eklenecektir";
						} else {
							$fav_color = "orange";
							$fav_title = "Araç favorilerinizden kaldırılacaktır";
						}
						$en_yksk = "";
						$sql_teklif = mysql_query("select * from teklifler where ilan_id='" . $ihale_oku['id'] . "' and uye_id='" . $uye_id . "' and durum=1 order by teklif_zamani desc limit 1 ");
						$teklif_say = 0;
						while ($row_teklif = mysql_fetch_object($sql_teklif)) {
							if ($row_teklif->teklif != "") {
								$en_yksk = '<uk style="color: red; text-align:right;display: block;" id="benim_teklif_'.$ihale_oku['id'].'">' . money($row_teklif->teklif) . ' ₺ teklif verdiniz.</uk>';
							}
							if ($row_teklif->teklif == $ihale_oku['son_teklif']) {
								$en_yksk = '<uk style="color: green; text-align:right;display: block;" id="en_yuksek_benim_'.$ihale_oku['id'].'">En yüksek teklif sizindir.</uk>
											<uk style="color: red; text-align:right;display: block;" id="benim_teklif_'.$ihale_oku['id'].'">' . money($row_teklif->teklif) . ' ₺ teklif verdiniz.</uk>
										  ';
							} else if ($row_teklif->teklif != $ihale_oku['son_teklif'] && $row_teklif->teklif != "" && $teklif_say == 0) {
								$en_yksk = '<uk style="color: green; text-align:right;display: none;" id="en_yuksek_benim_'.$ihale_oku['id'].'">En yüksek teklif sizindir.</uk>
								<uk style="color: red; text-align:right;display: block;" id="benim_teklif_'.$ihale_oku['id'].'">' . money($row_teklif->teklif) . ' ₺ teklif verdiniz.</uk>';
							}else{
								$en_yksk = '<uk style="color: green; text-align:right;display: none;" id="en_yuksek_benim_'.$ihale_oku['id'].'">En yüksek teklif sizindir.</uk>';
							}
							$teklif_say++;
						}

						$en_yksk_kapali = "";
						$sql_teklif = mysql_query("select * from teklifler where ilan_id='" . $ihale_oku['id'] . "' and uye_id='" . $uye_id . "' and durum=1 order by teklif_zamani desc limit 1 ");
						$ilan_kontrol = mysql_query("select * from ilanlar where id='" . $ihale_oku['id'] . "' ");
						$ilan_kontrol_cek = mysql_fetch_object($ilan_kontrol);
						$kapali_durum = $ilan_kontrol_cek->ihale_turu;
						$teklif_say_kapali = 0;
						while ($row_teklif = mysql_fetch_object($sql_teklif)) {
							if ($kapali_durum == "2") {
								if ($row_teklif->teklif != "") {
									$en_yksk_kapali = '<uk style="color: red; text-align:right;display: block;" id="benim_teklif_'.$ihale_oku['id'].'">' . money($row_teklif->teklif) . ' ₺ teklif verdiniz.</uk>';
								}
								/*if($row_teklif->teklif == ""){
									$en_yksk_kapali =' 
											<i style="color: red; text-align:center;">Henüz teklif vermediniz.</i>
										  ';
								}else if( $row_teklif->teklif != "" && $teklif_say_kapali==0 ){
									$en_yksk_kapali ='<uk style="color: red; text-align:center;">'.money($row_teklif->teklif).' ₺ teklif verdiniz.</uk>';
								}
								$teklif_say_kapali++;*/
							}
						}
						if ($ihale_oku['sigorta'] != $yasaki_sigorta_id) {
							if ($secilen_yetki_id == 2) {
								if ($detay_gorur == 1) {
									$ihale_id = $ihale_oku['id'];
									$ihale_marka = $ihale_oku['marka'];
									$sehir_gel = mysql_query("SELECT * FROM sehir WHERE sehirID = '" . $ihale_id . "'");
									$marka_gel = mysql_query("SELECT * FROM marka WHERE markaID = '" . $ihale_marka . "'");
									$setMarka = mysql_fetch_assoc($marka_gel); ?>

									<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ilan_karti_dis" style="<?php if ($ihale_oku['ihale_tarihi'] . ' ' . $ihale_oku['ihale_saati'] < date("Y-m-d H:i:s")) {
																													echo ('background-color:gray; opacity: 0.5;');
																												} ?>">
										<?php if ($ihale_oku['ihale_turu'] == 1) {
											$background_color = "#00a2e8";
										} else {
											$background_color = "orange";
										}
										array_push($sira_array, $sira); ?>
										<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ilan_karti_baslik " style="background-color:<?= $background_color ?>">
											<?php
											if (strlen($ihale_oku['model_yili'] . " " . $setMarka['marka_adi'] . " " . $ihale_oku['model'] . " " . $ihale_oku['tip']) > 120) {
												$ilan_karti_baslik_bas = substr($ihale_oku['model_yili'] . " " . $setMarka['marka_adi'] . " " . $ihale_oku['model'] . " " . $ihale_oku['tip'], 0, 120) . "...";
											} else {
												$ilan_karti_baslik_bas = $ihale_oku['model_yili'] . " " . $setMarka['marka_adi'] . " " . $ihale_oku['model'] . " " . $ihale_oku['tip'];
											}
											?>
											<text style="font-size: 15px;font-weight:bold;color: #fff;"><i class="fas fa-car" aria-hidden="true"></i> <?= $ilan_karti_baslik_bas ?></text>
											<span id="sayac<?= $sira ?>"> </span>
											<input type="hidden" id="ihale_sayac<?= $sira ?>" value="<?= $ihale_oku['ihale_tarihi'] . ' ' . $ihale_oku['ihale_saati'] ?>">
											<input type="hidden" id="id_<?= $sira ?>" value="<?= $ihale_oku['id'] ?>">
											<input type="hidden" id="belirlenen_<?= $sira ?>" value="<?= $sgrt_oku['bu_sure_altinda_teklif'] ?>">
										</div>
										<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ilan_karti_icerik_dis">
											<div class="ilan_karti_gorsel_dis" style="background-image:url('images/<?= $ilan_resmi ?>');">
												<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ilan_karti_kod">
													#<?= $ihale_oku['arac_kodu'] ?>
												</div>
											</div>
											<div class="ilan_karti_gorsel_icerik">
												<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ilan_karti_taglar_dis">
												<?php if($ihale_oku['yakit_tipi']!=""){ ?>
													<div class="ilan_karti_tag">
													<img src="../images/car_list_icons/1.png" />
														<?= $ihale_oku['yakit_tipi'] ?>
													</div>
													<?php } if($ihale_oku['vites_tipi']!=""){ ?>
													<div class="ilan_karti_tag">
													<img src="../images/car_list_icons/2.png" />
														<?= $ihale_oku['vites_tipi'] ?>
													</div>
													<?php }if($ihale_oku['kilometre']!=""){ ?>
													<div class="ilan_karti_tag">
													<img src="../images/car_list_icons/7.png" />
														<?= money($ihale_oku['kilometre']) ?> km
													</div>
													<?php } if($ihale_oku['sehir']!=""){ ?>
													<div class="ilan_karti_tag">
													<img src="../images/car_list_icons/3.png" />
														<?= $ihale_oku['sehir'] ?>
													</div>
													<?php }if($ihale_oku['ihale_turu']!=""){ ?>
													<div class="ilan_karti_tag">
													<img src="../images/car_list_icons/4.png" />
														<?php if($ihale_oku['ihale_turu']==1){$ihale_turu = "Açık  İhale";}else{$ihale_turu="Kapalı İhale";} ?>
														<?= $ihale_turu ?>
													</div>
													<?php } if($ihale_oku['profil']!=""){ ?>
													<div class="ilan_karti_tag <?= $blink ?>">
														<img src="../images/car_list_icons/5.png" />
														<?= $ihale_oku['profil'] ?>
													</div>
													<?php }if($ihale_oku['ihale_tarihi']!=""){  ?>
													<div class="ilan_karti_tag ">
														<img src="../images/car_list_icons/6.png" />
													<span class="kapanis_zamani<?=$sira ?>" ><?= date("d-m-Y H:i:s",strtotime($ihale_oku['ihale_tarihi']." ".$ihale_oku['ihale_saati'])) ?></span>
													</div>
													<?php } ?>
												</div>
												<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ilan_karti_alt_alan">
													<div class="col-xs-12 col-sm-12 col-md-7 col-lg-7 ilan_karti_notlar_dis">
														<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ilan_karti_not_alan">
															<?php $onay_cek = mysql_query("select * from sigorta_ozellikleri where id = '" . $ihale_oku['sigorta'] . "'");
															$onay_oku = mysql_fetch_assoc($onay_cek);
															$onay = $onay_oku['uyari_notu'];
															?>
															<?= $onay ?>
														</div>
														<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ilan_karti_begeni_dis">
															<form method="POST" action="" name="form">
																<div class="btn-group" role="group">
																	<div style="display:contents" onclick="bildirim_ac(<?= $ihale_oku['id'] ?>);">
																		<button data-toggle="tooltip" data-placement="top" title="<?= $bildirim_title ?>" type="button" id="bildirim_ac_<?= $ihale_oku['id'] ?>" name="bildirim_ac" class="btn btn-light mr-2 btn-sm">
																			<i style="color: <?= $bidlirim_color ?>;" class="icon-notifications"></i>
																			<input type="hidden" name="bildirimlenecek" value="<?= $ihale_oku['id'] ?>">
																		</button>
																	</div>
																	<div style="display:contents" onclick="favla(<?= $ihale_oku['id'] ?>);">
																		<button data-toggle="tooltip" data-placement="top" title="<?= $fav_title ?>" type="button" id="favla_<?= $ihale_oku['id'] ?>" name="favla" class="btn btn-light btn-sm">
																			<i style="color: <?= $fav_color ?>;" class="fas fa-star"></i>
																			<input type="hidden" name="favlanacak" value="<?= $ihale_oku['id'] ?>">
																		</button>
																	</div>
																</div>
															</form>
														</div>
													</div>
													<div class="col-xs-12 col-sm-12 col-md-5 col-lg-5 ilan_karti_teklif_dis">
														<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ilan_karti_teklif_baslik">
															<?php if ($ihale_oku['ihale_turu'] == 1) { 
																	$name="";
																?>
																En Yüksek Teklif
															<?php } else { 
																	$name="kapalı_";
																?>
																Taban Fiyat
															<?php } ?>
														</div>
														<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ilan_karti_teklif_fiyat">
															<div id="<?= $name ?>ilan_fiyat_bilgisi_<?= $ihale_oku["id"] ?>">
																<?php
																if ($ihale_oku["ihale_tarihi"] . " " . $ihale_oku["ihale_saati"] > date('Y-m-d H:i:s')) { ?>
																	<?php if ($ihale_oku['ihale_turu'] == 1) { ?>
																		<?= money($ihale_oku['son_teklif']) ?> ₺
																	<?php } else { ?>
																		<?= money($ihale_oku['acilis_fiyati']) ?> ₺
																	<?php } ?>
																<?php } else { ?>
																	<i style="color:#000" class="fas fa-lock"></i>
																<?php }
																?>
															</div>


														</div>
														<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ilan_karti_teklif_btnlar">
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								<?php } else {
									$ihale_id = $ihale_oku['id'];
									$ihale_marka = $ihale_oku['marka'];
									$sehir_gel = mysql_query("SELECT * FROM sehir WHERE sehirID = '" . $ihale_id . "'");
									$marka_gel = mysql_query("SELECT * FROM marka WHERE markaID = '" . $ihale_marka . "'");
									$setMarka = mysql_fetch_assoc($marka_gel);
								?>
									<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ilan_karti_dis" style="background-color:gray !important; opacity: 0.5;">
										<div style="color:#000;background-color:gray !important; opacity: 0.5;" class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ilan_karti_baslik">
											<?php
											if (strlen($ihale_oku['model_yili'] . " " . $setMarka['marka_adi'] . " " . $ihale_oku['model'] . " " . $ihale_oku['tip']) > 120) {
												$ilan_karti_baslik_bas = substr($ihale_oku['model_yili'] . " " . $setMarka['marka_adi'] . " " . $ihale_oku['model'] . " " . $ihale_oku['tip'], 0, 120) . "...";
											} else {
												$ilan_karti_baslik_bas = $ihale_oku['model_yili'] . " " . $setMarka['marka_adi'] . " " . $ihale_oku['model'] . " " . $ihale_oku['tip'];
											}
											?>
											<text style="font-size: 15px;font-weight:bold;color: #fff;"><i class="fas fa-car" aria-hidden="true"></i> <?= $ilan_karti_baslik_bas  ?><i style="" class="fas fa-lock"></i></text>
											<?php array_push($sira_array, $sira); ?>
											<span id="sayac<?= $sira ?>"> </span>
											<input type="hidden" id="ihale_sayac<?= $sira ?>" value="<?= $ihale_oku['ihale_tarihi'] . ' ' . $ihale_oku['ihale_saati'] ?>">
											<input type="hidden" id="id_<?= $sira ?>" value="<?= $ihale_oku['id'] ?>">
											<input type="hidden" id="belirlenen_<?= $sira ?>" value="<?= $sgrt_oku['bu_sure_altinda_teklif'] ?>">
										</div>
										<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ilan_karti_icerik_dis">
											<div class="ilan_karti_gorsel_dis" style="background-color:#fff;background-image:url('images/black_lock.jpg');">
												<div style="color:#000" class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ilan_karti_kod">
													<!-- # <i style="color:#000" class="fas fa-lock"></i> -->
													#<?= $ihale_oku['arac_kodu'] ?>
												</div>
											</div>
											<div class="ilan_karti_gorsel_icerik">
												<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ilan_karti_taglar_dis">
												<?php if($ihale_oku['yakit_tipi']!=""){ ?>
													<div class="ilan_karti_tag">
													<img src="../images/car_list_icons/1.png" />
														<?= $ihale_oku['yakit_tipi'] ?>
													</div>
													<?php } if($ihale_oku['vites_tipi']!=""){ ?>
													<div class="ilan_karti_tag">
													<img src="../images/car_list_icons/2.png" />
														<?= $ihale_oku['vites_tipi'] ?>
													</div>
													<?php }if($ihale_oku['kilometre']!=""){ ?>
													<div class="ilan_karti_tag">
													<img src="../images/car_list_icons/7.png" />
														<?= money($ihale_oku['kilometre']) ?> km
													</div>
													<?php } if($ihale_oku['sehir']!=""){ ?>
													<div class="ilan_karti_tag">
													<img src="../images/car_list_icons/3.png" />
														<?= $ihale_oku['sehir'] ?>
													</div>
													<?php }if($ihale_oku['ihale_turu']!=""){ ?>
													<div class="ilan_karti_tag">
													<img src="../images/car_list_icons/4.png" />
														<?php if($ihale_oku['ihale_turu']==1){$ihale_turu = "Açık  İhale";}else{$ihale_turu="Kapalı İhale";} ?>
														<?= $ihale_turu ?>
													</div>
													<?php } if($ihale_oku['profil']!=""){ ?>
													<div class="ilan_karti_tag <?= $blink ?>">
														<img src="../images/car_list_icons/5.png" />
														<?= $ihale_oku['profil'] ?>
													</div>
													<?php }if($ihale_oku['ihale_tarihi']!=""){  ?>
													<div class="ilan_karti_tag ">
														<img src="../images/car_list_icons/6.png" />
													<span class="kapanis_zamani<?=$sira ?>" ><?= date("d-m-Y H:i:s",strtotime($ihale_oku['ihale_tarihi']." ".$ihale_oku['ihale_saati'])) ?></span>
													</div>
													<?php } ?>
												</div>
												<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ilan_karti_alt_alan">
													<div class="col-xs-12 col-sm-12 col-md-7 col-lg-7 ilan_karti_notlar_dis">
														<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ilan_karti_not_alan">
															<?php $onay_cek = mysql_query("select * from sigorta_ozellikleri where id = '" . $ihale_oku['sigorta'] . "'");
															$onay_oku = mysql_fetch_assoc($onay_cek);
															$onay = $onay_oku['uyari_notu'];
															?>
															<?= $onay ?>
														</div>
														<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ilan_karti_begeni_dis">
															<form method="POST" action="" name="form">
																<div style="display:contents" onclick="bildirim_ac(<?= $ihale_oku['id'] ?>);">
																	<button data-toggle="tooltip" data-placement="top" title="<?= $bildirim_title ?>" type="button" id="bildirim_ac_<?= $ihale_oku['id'] ?>" name="bildirim_ac" class="btn btn-light mr-2 btn-sm">
																		<i style="color:<?= $bidlirim_color ?>;" class="icon-notifications"></i>
																		<input type="hidden" name="bildirimlenecek" value="<?= $ihale_oku['id'] ?>">
																	</button>
																</div>
																<div style="display:contents" onclick="favla(<?= $ihale_oku['id'] ?>);">
																	<button data-toggle="tooltip" data-placement="top" title="<?= $fav_title ?>" type="button" id="favla_<?= $ihale_oku['id'] ?>" name="favla" class="btn btn-light btn-sm">
																		<i style="color:<?= $fav_color ?>;" class="fas fa-star"></i>
																		<input type="hidden" name="favlanacak" value="<?= $ihale_oku['id'] ?>">
																	</button>
																</div>
															</form>
														</div>
													</div>
													<div class="col-xs-12 col-sm-12 col-md-5 col-lg-5 ilan_karti_teklif_dis">
														<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ilan_karti_teklif_baslik">
															<?php if ($ihale_oku['ihale_turu'] == 1) { 
																	$name="";
																	?>
																En Yüksek Teklif
															<?php } else { 
																	$name="kapalı_";
																?>
																Taban Fiyat
															<?php } ?>
														</div>
														<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ilan_karti_teklif_fiyat">
															<div id="<?= $name ?>ilan_fiyat_bilgisi_<?= $ihale_oku["id"] ?>">
																<i style="color:#000" class="fas fa-lock"></i>
															</div>
														</div>
														<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ilan_karti_teklif_btnlar">
															<div class="ilan_karti_teklif_btn" style="background-color: #000; ">
																<a style="text-decoration: none; color:#ffffff;" href=""><i style="color:#fff" class="fas fa-lock"></i></a>
															</div>
															<div class="ilan_karti_teklif_btn" style="background-color: #424242; ">
																<a style="text-decoration: none; color:#ffffff;" href=""><i style="color:#000" class="fas fa-lock"></i></a>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								<?php }
							} elseif ($secilen_yetki_id == 3) {
								$ihale_id = $ihale_oku['id'];
								$ihale_marka = $ihale_oku['marka'];
								$sehir_gel = mysql_query("SELECT * FROM sehir WHERE sehirID = '" . $ihale_id . "'");
								$marka_gel = mysql_query("SELECT * FROM marka WHERE markaID = '" . $ihale_marka . "'");
								$marka_oku = mysql_fetch_assoc($marka_gel); ?>
								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ilan_karti_dis" style="<?php if ($ihale_oku['ihale_tarihi'] . ' ' . $ihale_oku['ihale_saati'] < date("Y-m-d H:i:s")) {
																												echo ('background-color:gray; opacity: 0.5;');
																											} ?>">
									<?php if ($ihale_oku['ihale_turu'] == 1) {
										$background_color = "#00a2e8";
									} else {
										$background_color = "orange";
									}  ?>
									<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ilan_karti_baslik" style="background-color:<?= $background_color ?>">
										<?php
										if (strlen($ihale_oku['model_yili'] . " " . $marka_oku['marka_adi'] . " " . $ihale_oku['model'] . " " . $ihale_oku['tip']) > 120) {
											$ilan_karti_baslik_bas = substr($ihale_oku['model_yili'] . " " . $marka_oku['marka_adi'] . " " . $ihale_oku['model'] . " " . $ihale_oku['tip'], 0, 120) . "...";
										} else {
											$ilan_karti_baslik_bas = $ihale_oku['model_yili'] . " " . $marka_oku['marka_adi'] . " " . $ihale_oku['model'] . " " . $ihale_oku['tip'];
										}
										?>
										<text style="font-size: 15px;font-weight:bold;color: #fff;"><i class="fas fa-car" aria-hidden="true"></i> <?= $ilan_karti_baslik_bas  ?></text>
										<?php array_push($sira_array, $sira); ?>
										<span id="sayac<?= $sira ?>"></span>
										<input type="hidden" id="ihale_sayac<?= $sira ?>" value="<?= $ihale_oku['ihale_tarihi'] . ' ' . $ihale_oku['ihale_saati'] ?>">
										<input type="hidden" id="id_<?= $sira ?>" value="<?= $ihale_oku['id'] ?>">
										<input type="hidden" id="belirlenen_<?= $sira ?>" value="<?= $sgrt_oku['bu_sure_altinda_teklif'] ?>">
									</div>
									<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ilan_karti_icerik_dis">
										<div class="ilan_karti_gorsel_dis" style="background-image:url('../images//<?= $ilan_resmi ?>');">
											<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ilan_karti_kod">
												#<?= $ihale_oku['arac_kodu'] ?>
											</div>
										</div>
										<div class="ilan_karti_gorsel_icerik">
											<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ilan_karti_taglar_dis">
											<?php if($ihale_oku['yakit_tipi']!=""){ ?>
													<div class="ilan_karti_tag">
													<img src="../images/car_list_icons/1.png" />
														<?= $ihale_oku['yakit_tipi'] ?>
													</div>
													<?php } if($ihale_oku['vites_tipi']!=""){ ?>
													<div class="ilan_karti_tag">
													<img src="../images/car_list_icons/2.png" />
														<?= $ihale_oku['vites_tipi'] ?>
													</div>
													<?php }if($ihale_oku['kilometre']!=""){ ?>
													<div class="ilan_karti_tag">
													<img src="../images/car_list_icons/7.png" />
														<?= money($ihale_oku['kilometre']) ?> km
													</div>
													<?php } if($ihale_oku['sehir']!=""){ ?>
													<div class="ilan_karti_tag">
													<img src="../images/car_list_icons/3.png" />
														<?= $ihale_oku['sehir'] ?>
													</div>
													<?php }if($ihale_oku['ihale_turu']!=""){ ?>
													<div class="ilan_karti_tag">
													<img src="../images/car_list_icons/4.png" />
														<?php if($ihale_oku['ihale_turu']==1){$ihale_turu = "Açık  İhale";}else{$ihale_turu="Kapalı İhale";} ?>
														<?= $ihale_turu ?>
													</div>
													<?php } if($ihale_oku['profil']!=""){ ?>
													<div class="ilan_karti_tag <?= $blink ?>">
														<img src="../images/car_list_icons/5.png" />
														<?= $ihale_oku['profil'] ?>
													</div>
													<?php }if($ihale_oku['ihale_tarihi']!=""){  ?>
													<div class="ilan_karti_tag ">
														<img src="../images/car_list_icons/6.png" />
													<span class="kapanis_zamani<?=$sira ?>" ><?= date("d-m-Y H:i:s",strtotime($ihale_oku['ihale_tarihi']." ".$ihale_oku['ihale_saati'])) ?></span>
													</div>
													<?php } ?>
											</div>
											<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ilan_karti_alt_alan">
												<div class="col-xs-12 col-sm-12 col-md-7 col-lg-7 ilan_karti_notlar_dis">
													<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ilan_karti_not_alan">
														<?php $onay_cek2 = mysql_query("select * from sigorta_ozellikleri where id = '" . $ihale_oku['sigorta'] . "'");
														$onay_oku2 = mysql_fetch_assoc($onay_cek2);
														$onay2 = $onay_oku2['uyari_notu'];
														?>
														<?= $onay2 ?>
													</div>
													<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 ilan_karti_begeni_dis">
														<form method="POST" action="" name="form">
															<div style="display:contents" onclick="bildirim_ac(<?= $ihale_oku['id'] ?>)">
																<button data-toggle="tooltip" data-placement="top" title="<?= $bildirim_title ?>" id="bildirim_ac_<?= $ihale_oku['id'] ?>" type="button" name="bildirim_ac" class="btn btn-light mr-2 btn-sm">
																	<i style="color: <?= $bidlirim_color ?>;" class="icon-notifications"></i>
																	<input type="hidden" name="bildirimlenecek" value="<?= $ihale_oku['id'] ?>">
																</button>
															</div>
															<div style="display:contents" onclick="favla(<?= $ihale_oku['id'] ?>)">
																<button data-toggle="tooltip" data-placement="top" title="<?= $fav_title ?>" type="button" id="favla_<?= $ihale_oku['id'] ?>" name="favla" class="btn btn-light btn-sm">
																	<i style="color:  <?= $fav_color ?>;" class="fas fa-star"></i>
																	<input type="hidden" name="favlanacak" value="<?= $ihale_oku['id'] ?>">
																</button>
															</div>
														</form>
													</div>
													<div class="col-xs-8 col-sm-8 col-md-8 col-lg-8 ilan_karti_begeni_dis">
														<?php if ($ihale_oku['ihale_turu'] == 1) {
															echo $en_yksk;
														} else {
															echo $en_yksk_kapali;
														}
														?>
													</div>
												</div>
												<div class="col-xs-12 col-sm-12 col-md-5 col-lg-5 ilan_karti_teklif_dis">
													<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ilan_karti_teklif_baslik">
														<?php if ($ihale_oku['ihale_turu'] == 1) { 
																$name="";
																?>
															En Yüksek Teklif
														<?php } else { 
																$name="kapalı_";
																?>
															Taban Fiyat
														<?php } ?>
													</div>
													<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ilan_karti_teklif_fiyat">
														<div id="<?= $name ?>ilan_fiyat_bilgisi_<?= $ihale_oku["id"] ?>">
															<?php
															if ($ihale_oku["ihale_tarihi"] . " " . $ihale_oku["ihale_saati"] > date('Y-m-d H:i:s')) { ?>
																<?php if ($ihale_oku['ihale_turu'] == 1) { ?>
																	<?= money($ihale_oku['son_teklif']) ?> ₺
																<?php } else { ?>
																	<?= money($ihale_oku['acilis_fiyati']) ?> ₺
																<?php } ?>
															<?php } else { ?>
																<i style="color:#000" class="fas fa-lock"></i>
															<?php }
															?>
														</div>
													</div>

													<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ilan_karti_teklif_btnlar">
														<div class="ilan_karti_teklif_btn" style="background-color:<?= $background_color ?>">
															<?php if ($ihale_oku['durum'] == "-1") { ?>
																<span style="text-decoration: none; color:#ffffff; cursor: pointer;">TEKLİF VER</span>
															<?php } else { ?>
																<a onclick="kontrol(<?= $ihale_oku['id'] ?>); " data-toggle="modal" data-target="#teklifVer<?= $ihale_oku['id'] ?>" style="text-decoration: none; color:#ffffff; cursor: pointer;">TEKLİF VER</a>
															<?php } ?>
														</div>
														<div class="ilan_karti_teklif_btn" style="background-color: #424242;">
															<?php if ($ihale_oku['durum'] == "-1") { ?>
																<span style="text-decoration: none; color:#ffffff;">İNCELE</a>
																<?php } else { ?>
																	<a onclick="ihale_arttir(<?= $ihale_oku['id'] ?>)" style="text-decoration: none; color:#ffffff;" href="../arac_detay.php?id=<?= $ihale_oku['id'] ?>&q=ihale">İNCELE</a>
																<?php } ?>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<?php
								$ihale_tur_sorgu = mysql_query("select * from ilanlar where id='" . $ihale_oku['id'] . "'  ");
								$tur_cek = mysql_fetch_object($ihale_tur_sorgu);
								$komisyon_cek = mysql_query("SELECT * FROM ilan_komisyon WHERE ilan_id = '" . $ihale_oku['id'] . "'");
								$komisyon_oku = mysql_fetch_assoc($komisyon_cek);
								$komisyon = $komisyon_oku['toplam'];
								$sorgu = mysql_query("SELECT * FROM komisyon_oranlari WHERE sigorta_id = '" . $ihale_oku['sigorta'] . "'");
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
									<input type="hidden" id="standart_net<?= $ihale_oku['id'] ?>" value="<?= $standart_net ?>">
									<input type="hidden" id="luks_net<?= $ihale_oku['id'] ?>" value="<?= $luks_net ?>">
									<input type="hidden" id="standart_onbinde<?= $ihale_oku['id'] ?>" value="<?= $standart_onbinde ?>">
									<input type="hidden" id="luks_onbinde<?= $ihale_oku['id'] ?>" value="<?= $luks_onbinde ?>">
									<input type="hidden" id="oran<?= $ihale_oku['id'] ?>" value="<?= $oran ?>">
								<?php } ?>


								<input type="hidden" id="hesaplama<?= $ihale_oku['id'] ?>" value="<?= $ihale_oku['hesaplama'] ?>">
								<input type="hidden" id="sorgu_sayi<?= $ihale_oku['id'] ?>" value="<?= $sorgu_say ?>">

								<?php

								$sgrt = mysql_fetch_object(mysql_query("select * from sigorta_ozellikleri where id='" . $ihale_oku['sigorta'] . "' "));
								$min_arti = $sgrt->minumum_artis;
								$h1 = $sgrt->hizli_teklif_1;
								$h2 = $sgrt->hizli_teklif_2;
								$h3 = $sgrt->hizli_teklif_3;
								$h4 = $sgrt->hizli_teklif_4;
								$s_mesaj = $sgrt->teklif_iletme_mesaji;
								$tur = $tur_cek->ihale_turu;
								$tbn_fiyat = $tur_cek->acilis_fiyati; ?>


								<?php if ($tur == "1") { ?>

									<input type="hidden" id="ihale_tur" value="<?= $tur ?>" />
									<div class="modal fade" id="teklifVer<?= $ihale_oku['id'] ?>" style="z-index: 999999;" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
										<div class="modal-dialog">
											<div class="modal-content">
												<div class="container">
													<form method="post">
														<div class="modal-header">
															<button style="margin-top:1%; font-size:17px; font-weight:600;" type="button" class="btn btn-dark  btn-block"><?= $ihale_oku['model_yili'] . " " . $marka_oku['marka_adi'] . " " . $ihale_oku['model'] ?></button>
															<button type="button" onclick="secimleri_sil(<?= $ihale_oku['id'] ?>)" id="modal_kapat<?= $ihale_oku['id'] ?> " class="close" data-dismiss="modal" aria-label="Close">
																<span aria-hidden="true">&times;</span>
															</button>
														</div>
														<div class="modal-body">
															<div class="row">
																<div class="col">
																	<p style="text-align:left; font-size:15px; font-weight:600;">PD HİZMET BEDELİ</p>
																	<b style="color:blue;display:none"></b>
																	<button type="button" class="btn btn-dark btn-block" style="font-size:16px; font-weight:600;">
																		<span id="hizmet_bedel<?= $ihale_oku['id'] ?>"></span>
																	</button>
																</div>
																<div class="col">
																	<p style="text-align:center; font-size:15px; font-weight:600;">VERİLECEK TEKLİF</p>
																	<button type="button" class="btn btn-dark btn-block" style="font-size:16px; font-weight:600; background-color:rgb(247, 148, 29);border-color:transparent !important;" id="GelenTeklif<?= $ihale_oku['id'] ?>">
																	</button>
																</div>
															</div>
															<div class="row mt-4">
																<div class="col">
																	<button style="background-color:#00a2e8; color:#fff; font-weight:600;" type="button" class="btn btn-block mavi" onclick="buttonClick(<?= $ihale_oku['id'] ?>); degistir(<?= $ihale_oku['id'] ?>);" id="arti1<?= $ihale_oku['id'] ?>" value="<?= $h1 ?>">
																		+<?= money($h1) ?>₺
																	</button>
																</div>
																<div class="col">
																	<button style="background-color:#00a2e8; color:#fff; font-weight:600;" type="button" class="btn btn-block mavi" onclick="buttonClick2(<?= $ihale_oku['id'] ?>); degistir(<?= $ihale_oku['id'] ?>);" id="arti2<?= $ihale_oku['id'] ?>" value="<?= $h2 ?>">
																		+<?= money($h2) ?>₺
																	</button>
																</div>
																<div class="col">
																	<button style="background-color:#00a2e8; color:#fff; font-weight:600;" type="button" class="btn btn-block mavi" onclick="clickButton(<?= $ihale_oku['id'] ?>); degistir(<?= $ihale_oku['id'] ?>);" id="arti3<?= $ihale_oku['id'] ?>" value="<?= $h3 ?>">
																		+<?= money($h3) ?>₺
																	</button>
																</div>
																<div class="col">
																	<button style="background-color:#00a2e8; color:#fff; font-weight:600;" type="button" class="btn btn-block mavi" onclick="clickButton2(<?= $ihale_oku['id'] ?>); degistir(<?= $ihale_oku['id'] ?>);" id="arti4<?= $ihale_oku['id'] ?>" value="<?= $h4 ?>">
																		+<?= money($h4) ?>₺
																	</button>
																</div>
															</div>
															<div class="row mt-4">
																<div class="col" style="text-align:right; padding:10px 0px;">
																	Teklifinizi Yazınız
																</div>
																<div class="col">
																	<?php if ($ihale_oku['son_teklif'] == 0) { ?>
																		<input style="height:40px;" placeholder="Teklifinizi buraya yazınız." type="number" value="" step="<?= $min_arti ?>" class="form-control" id="verilen_teklif<?= $ihale_oku['id'] ?>" onchange="teklif_kontrol(<?= $ihale_oku['id'] ?>);" onkeyup="teklif_kontrol(<?= $ihale_oku['id'] ?>);">
																		<input type="hidden" value="<?= $ihale_oku['acilis_fiyati'] ?>" id="verilen_teklif_hidden<?= $ihale_oku['id'] ?>">
																	<?php } else {  ?>
																		<input style="height:40px;" placeholder="Teklifinizi buraya yazınız." type="number" value="" step="<?= $min_arti ?>" class="form-control" id="verilen_teklif<?= $ihale_oku['id'] ?>" onchange="teklif_kontrol(<?= $ihale_oku['id'] ?>);" onkeyup="teklif_kontrol(<?= $ihale_oku['id'] ?>);">
																		<input type="hidden" value="<?= $ihale_oku['son_teklif'] ?>" id="verilen_teklif_hidden<?= $ihale_oku['id'] ?>">
																	<?php } ?>
																	<label id="teklif_kontrol<?= $ihale_oku['id'] ?>"></label>
																</div>
															</div>
															<div class="row mt-2">
																<div class="col">
																	<div class="col">
																		<textarea style="width:calc(100% + 30px); margin:15px -15px; min-height:250px;" id="deneme_alan<?= $ihale_oku['id'] ?>" rows="3" disabled placeholder="<?= $s_mesaj ?>"></textarea>
																	</div>
																</div>
															</div>
															<div class="row mt-2">
																<div class="col">
																	<input type="checkbox" id="sozlesme_kontrol<?= $ihale_oku['id'] ?>" value="1" required>
																	<span onclick="popup('<?= $s_mesaj ?>')">Yukarıdaki Koşulları Okudum ve Kabul Ediyorum.</span>
																</div>
															</div>
														</div>
														<div class="row mt-2 mb-2">
															<div class="col">
																<button type="button" onclick="secimleri_sil(<?= $ihale_oku['id'] ?>)" class="btn btn-danger btn-block" id="acik_modal_kapat2<?= $ihale_oku["id"] ?>" data-dismiss="modal">Vazgeç</button>
															</div>
															<div class="col"><button type="button" class="btn btn-success btn-block" id="TeklifVer<?= $ihale_oku['id'] ?>" onclick="denem(<?= $ihale_oku['id'] ?>);"><i class="fas fa-lira-sign"> Teklif Ver</i></button></div>
														</div>
													</form>
												</div>
											</div>
										</div>
									</div>
									<!-- <div class="modal fade" style="z-index: 9999;" id="teklifVer<?= $ihale_oku['id'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
										<div class="modal-dialog">
											<div class="modal-content">
												<div class="container">
													<form method="post">
														<div class="modal-header">    
															<button style="margin-top: 1%;" type="button" class="btn btn-dark  btn-block"><?= $ihale_oku['model_yili'] . " " . $marka_oku['marka_adi'] . " " . $ihale_oku['model'] . " " . $ihale_oku['tip'] ?></button>    
															<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																<span aria-hidden="true">&times;</span>
															</button>
														</div>
														<div class="modal-body">
															<div class="row">
																<div class="col">
																	<p style="text-align: center;">KALAN ZAMAN</p>
																	<?php array_push($modal_array, $sira); ?>
																	<button type="button" id = "modalZaman<?= $sira ?>" class="btn btn-dark btn-block"></button>
																</div>
																<div class="col">
																	<p style="text-align: center;">EN YÜKSEK TEKLİF</p>
																	<?php if ($ihale_oku['son_teklif'] != 0) { ?>
																		<button type="button" class="btn btn-dark btn-block"  value="<?= $ihale_oku['son_teklif'] ?>" id="modalTeklif<?= $ihale_oku['id'] ?>" style="background-color: rgb(247, 148, 29);"><?= money($ihale_oku['son_teklif']) ?> ₺</button>
																	<?php } else { ?>
																		<button type="button" class="btn btn-dark btn-block" value="<?= $ihale_oku['acilis_fiyati'] ?>" id="modalTeklif<?= $ihale_oku['id'] ?>" style="background-color: rgb(247, 148, 29);"><?= money($ihale_oku['acilis_fiyati']) ?> ₺</button>
																	<?php } ?>
																	
																</div>
															</div>
															<div class="row mt-3">
																<div class="col" >
																   <p style="background-color: rgb(245, 245, 208); text-align:center;"> <br> AÇIK ARTTIRMA <br> <br>	 </p>
																</div>
																<div class="col" >
																	<div class="row mt-2">
																		<div class="col"><button style="margin-bottom:10px;" type="button" onclick="buttonClick(<?= $ihale_oku['id'] ?>); degistir(<?= $ihale_oku['id'] ?>);" id="arti1<?= $ihale_oku['id'] ?>" value="<?= $h1 ?>" class="btn btn-block mavi">+<?= money($h1) ?>₺</button></div>
																		<div class="col"><button type="button" onclick="clickButton(<?= $ihale_oku['id'] ?>); degistir(<?= $ihale_oku['id'] ?>);" id="arti3<?= $ihale_oku['id'] ?>" value="<?= $h3 ?>" class="btn btn-block mavi">+<?= money($h3) ?>₺</button></div>
																	</div>
																	<div class="row mt-2">
																		<div class="col"><button style="margin-bottom:10px;" type="button" onclick="ButtonClick(<?= $ihale_oku['id'] ?>); degistir(<?= $ihale_oku['id'] ?>);" id="arti2<?= $ihale_oku['id'] ?>" value="<?= $h2 ?>"  class="btn btn-block mavi">+<?= money($h2) ?>₺</button></div>
																		<div class="col"><button type="button" onclick="ClickButton(<?= $ihale_oku['id'] ?>); degistir(<?= $ihale_oku['id'] ?>);" id="arti4<?= $ihale_oku['id'] ?>" value="<?= $h4 ?>" class="btn btn-block mavi">+<?= money($h4) ?>₺</button></div>
																	</div>
																</div>
															</div>
															<div class="row mt-2">
																<div class="col">
																   <?= $en_yksk ?>
																</div>
																<div class="col">
																	
																	<?php if ($ihale_oku['son_teklif'] == 0) { ?>
																		<input  style="margin-top:-10px;height:40px;" type="number"  value=""  step="<?= $min_arti ?>" class="form-control" id="verilen_teklif<?= $ihale_oku['id'] ?>" onchange="degistir(<?= $ihale_oku['id'] ?>); teklif_kontrol(<?= $ihale_oku['id'] ?>); komisyon_kontrol(<?= $ihale_oku['id'] ?>);" onkeyup=" degistir(<?= $ihale_oku['id'] ?>); teklif_kontrol(<?= $ihale_oku['id'] ?>); komisyon_kontrol(<?= $ihale_oku['id'] ?>);">
																		<input type="hidden" value="<?= $ihale_oku['acilis_fiyati'] ?>" id="verilen_teklif_hidden<?= $ihale_oku['id'] ?>" >
																	<?php } else {  ?>
																		<input style="margin-top:-10px;height:40px;" type="number"  value=""  step="<?= $min_arti ?>" class="form-control" id="verilen_teklif<?= $ihale_oku['id'] ?>" onchange=" degistir(<?= $ihale_oku['id'] ?>); teklif_kontrol(<?= $ihale_oku['id'] ?>); komisyon_kontrol(<?= $ihale_oku['id'] ?>);" onkeyup="degistir(<?= $ihale_oku['id'] ?>); teklif_kontrol(<?= $ihale_oku['id'] ?>); komisyon_kontrol(<?= $ihale_oku['id'] ?>);">
																		<input type="hidden" value="<?= $ihale_oku['son_teklif'] ?>" id="verilen_teklif_hidden<?= $ihale_oku['id'] ?>" >
																	<?php }  ?>
																	<label id="teklif_kontrol<?= $ihale_oku['id'] ?>"></label> 
																</div>
															</div>
															<div class="row mt-2">
																<div class="col">
																	<b style="color:blue;display:none" id="GelenTeklif<?= $ihale_oku['id'] ?>"></b>  
																	<b> Hizmet Bedeli:</b>  <span style="color:red;" id="hizmet_bedel<?= $ihale_oku['id'] ?>"></span> 	
																</div>
															</div>
															<div class="row mt-2">
																<div class="col">
																	<div onclick="popup('<?= $s_mesaj  ?>')" class="col">
																		<textarea style="width:100%;" id="deneme_alan<?= $ihale_oku['id'] ?>" rows="3" disabled placeholder="<?= $s_mesaj ?>"></textarea>
																	</div>
																</div>
															</div>
															<div class="row mt-2">
																<div class="col">
																	<input type="checkbox" id="sozlesme_kontrol<?= $ihale_oku['id'] ?>" value="1" required>  <span onclick="popup('<?= $s_mesaj  ?>')">Yukarıdaki Koşulları Okudum ve Kabul Ediyorum.</span>
																</div>
															</div>
														</div>
														<div class="row mt-2 mb-2">
															<div class="col"><button type="button" class="btn btn-danger btn-block" data-dismiss="modal">Vazgeç</button></div>
															<div class="col"><button type="button" class="btn btn-success btn-block" id="TeklifVer<?= $ihale_oku['id'] ?>" onclick="denem(<?= $ihale_oku['id'] ?>);"><i class="fas fa-lira-sign"> Teklif Ver</i></button></div>
														</div>
												   </form>
												</div>
											</div>
										</div>
									</div> -->
								<?php } else { ?>
									<input type="hidden" id="ihale_tur" value="<?= $tur ?>" />
									<div class="modal fade" style="z-index: 9999;" id="teklifVer<?= $ihale_oku['id'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
										<div class="modal-dialog">
											<div class="modal-content">
												<div class="container">
													<form method="post">
														<div class="modal-header">
															<button style="margin-top:1%; font-size:17px; font-weight:600;" type="button" class="btn btn-dark btn-block"><?= $ihale_oku['model_yili'] . " " . $marka_oku['marka_adi'] . " " . $ihale_oku['model'] ?></button>
															<button type="button" class="close" data-dismiss="modal" id="modal_kapat<?= $ihale_oku['id'] ?>" aria-label="Close">
																<span aria-hidden="true">&times;</span>
															</button>
														</div>
														<div class="modal-body">
															<div class="row">
																<div class="col">
																	<p style="text-align:left; font-size:15px; font-weight:600;">PD HİZMET BEDELİ</p>
																	<b style="color:blue;display:none"></b>
																	<button type="button" class="btn btn-dark btn-block" style="font-size:16px; font-weight:600;">
																		<span id="hizmet_bedel<?= $ihale_oku['id'] ?>"></span>
																	</button>
																</div>
																<div class="col">
																	<p style="text-align:center; font-size:15px; font-weight:600;">VERİLECEK TEKLİF</p>
																	<button type="button" class="btn btn-dark btn-block" style="font-size:16px; font-weight:600; background-color:rgb(247, 148, 29);border-color:transparent !important;" id="GelenTeklif<?= $ihale_oku['id'] ?>">
																	</button>
																</div>
															</div>
															<div class="row mt-4">
																<div class="col" style="text-align:right; padding:10px 0px;">
																	Teklifinizi Yazınız
																</div>
																<div class="col">
																	<input style="height40px;" type="number" placeholder="Teklifinizi buraya yazınız." value="" step="<?= $min_arti ?>" class="form-control" id="verilen_teklif<?= $ihale_oku['id'] ?>" onchange="teklif_kontrol(<?= $ihale_oku['id'] ?>);" onkeyup="teklif_kontrol(<?= $ihale_oku['id'] ?>),komisyon_kontrol(<?= $ihale_oku['id'] ?>);">
																	<label id="teklif_kontrol<?= $ihale_oku['id'] ?>"></label>
																</div>
															</div>
															<div class="row mt-2">
																<div class="col">
																	<div class="col">
																		<textarea style="width:calc(100% + 30px); margin:15px -15px; min-height:250px;" rows="3" disabled id="deneme_alan<?= $ihale_oku['id'] ?>" placeholder="<?= $s_mesaj ?>"></textarea>
																	</div>
																</div>
															</div>
															<div class="row mt-2">
																<div class="col" onclick="popup('<?= $s_mesaj  ?>')">
																	<input type="checkbox" id="sozlesme_kontrol<?= $ihale_oku['id'] ?>" value="1" required>
																	<span onclick="popup('<?= $s_mesaj  ?>')">Yukarıdaki Koşulları Okudum ve Kabul Ediyorum.</span>
																</div>
															</div>
														</div>
														<div class="row mt-2 mb-2">
															<div class="col">
																<button type="button" class="btn btn-danger btn-block" data-dismiss="modal" id="modal_kapat2<?= $ihale_oku["id"] ?>">
																	Vazgeç
																</button>
															</div>
															<div class="col">
																<button type="button" class="btn btn-success btn-block" id="TeklifVer<?= $ihale_oku['id'] ?>" onclick="denem(<?= $ihale_oku['id'] ?>);">
																	<i class="fas fa-lira-sign"> Teklif Ver</i>
																</button>
															</div>
														</div>
													</form>
												</div>
											</div>
										</div>
									</div>
									<!-- <div class="modal fade" style="z-index: 9999;" id="teklifVer<?= $ihale_oku['id'] ?>" onmousemove="degistir(<?= $ihale_oku['id'] ?>);komisyon_kontrol(<?= $ihale_oku['id'] ?>); " tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
											<div class="modal-dialog">
												<div class="modal-content">
													<div class="container">
														<form method="post">
															<div class="modal-header">    
																<button style="margin-top: 1%;" type="button" class="btn btn-dark  btn-block"><?= $ihale_oku['model_yili'] . " " . $marka_oku['marka_adi'] . " " . $ihale_oku['model'] . " " . $ihale_oku['tip'] ?></button>    
																<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																<span aria-hidden="true">&times;</span>
															</button>
														</div>
														<div class="modal-body">
															<div class="row">
																<div class="col">
																	<p style="text-align: center;">KALAN ZAMAN</p>
																	<?php array_push($modal_array, $sira); ?>
																	<button type="button" id = "modalZaman<?= $sira ?>" class="btn btn-dark btn-block"></button>
																</div>
																<div class="col">
																	<p style="text-align: center;">TABAN FİYAT</p>
																	<button type="button" class="btn btn-dark btn-block" value="<?= $ihale_oku['acilis_fiyati'] ?>" id="modalTeklif<?= $ihale_oku['id'] ?>" style="background-color: rgb(247, 148, 29);"><?= money($ihale_oku['acilis_fiyati']) ?> ₺</button>                      
																</div>
															</div>
															<div class="row mt-3">
																<div class="col" >
																	<p style="background-color: rgb(245, 245, 208); text-align:center; height:100px; padding:35px;">KAPALI İHALE</p>
																</div>
																<div class="col" >
																	<p style="font-size: 10px ;background-color: rgb(245, 245, 208); text-align:center; height:100px;"> <br> TEKLİFİNİZİ DÜŞÜREBİLİR VEYA YÜKSELTEBİLİRSİNİZ SON VERECEĞİNİZ TEKLİF GEÇERLİ OLACAKTIR <br> <br> </p>
																</div>
															</div>
															<div class="row mt-3">
																<div class="col" >
																	<b style="color:red;font-size:13px;" id="GelenTeklif<?= $ihale_oku['id'] ?>"></b>   
																</div>
																<div class="col" >
																	<input  style="margin-top:-15px;height:40px;" type="number"  value=""  step="<?= $min_arti ?>" class="form-control" id="verilen_teklif<?= $ihale_oku['id'] ?>" onchange="degistir(<?= $ihale_oku['id'] ?>); teklif_kontrol(<?= $ihale_oku['id'] ?>); komisyon_kontrol(<?= $ihale_oku['id'] ?>);" onkeyup="degistir(<?= $ihale_oku['id'] ?>); teklif_kontrol(<?= $ihale_oku['id'] ?>); komisyon_kontrol(<?= $ihale_oku['id'] ?>);">								   
																	<label id="teklif_kontrol<?= $ihale_oku['id'] ?>"></label> 
																</div>
															</div>
															<div class="row mt-2">
																<div class="col">
																   <?= $en_yksk_kapali ?>
																</div>
															</div>
															<div class="row mt-2">
																<div class="col">
																	<b> Hizmet Bedeli:</b>  <span style="color:red;" id="hizmet_bedel<?= $ihale_oku['id'] ?>"></span> 	
																</div>
															</div>
															<div class="row mt-2">
																<div class="col">
																	<div onclick="popup('<?= $s_mesaj  ?>')" class="col">
																		<textarea  style="width:100%;" id="deneme_alan<?= $ihale_oku['id'] ?>"  rows="3" disabled placeholder="<?= $s_mesaj ?>"></textarea>
																	</div>
																</div>
															</div>
															<div class="row mt-2">
																<div class="col">
																   <input type="checkbox" id="sozlesme_kontrol<?= $ihale_oku['id'] ?>" value="1" required> <span onclick="popup('<?= $s_mesaj  ?>')">Yukarıdaki Koşulları Okudum ve Kabul Ediyorum.</span>
																</div>
															</div>
														</div>
														<div class="row mt-2 mb-2">
															<div class="col"><button type="button" class="btn btn-danger btn-block" data-dismiss="modal">Vazgeç</button></div>
															<div class="col"><button type="button" class="btn btn-success btn-block" id="TeklifVer<?= $ihale_oku['id'] ?>" onclick="denem(<?= $ihale_oku['id'] ?>);"><i class="fas fa-lira-sign"> Teklif Ver</i></button></div>
														</div>
													</form>
												</div>
											</div>
										</div>
									</div> -->
								<?php } ?>
							<?php } ?>
					<?php }
						$sira++;
					}  ?>
				<?php  } ?>
				<?php
				if (isset($_POST['favla'])) {
					$date = date('Y-m-d H:i:s');
					$id = $_POST['favlanacak'];
					$favi_cek = mysql_query("SELECT * FROM user WHERE user_token = '" . $uye_token . "'");
					while ($favi_oku = mysql_fetch_array($favi_cek)) {
						$uyeninID = $favi_oku['id'];
						$favlamismi_cek = mysql_query("SELECT * FROM favoriler WHERE ilan_id = '" . $id . "' AND uye_id = '" . $uyeninID . "'");
						$favlamismi_sayi = mysql_num_rows($favlamismi_cek);
						if ($favlamismi_sayi == 0) {
							mysql_query("INSERT INTO `favoriler` (`id`, `ilan_id`, `dogrudan_satisli_id`, `uye_id`, `favlama_zamani`, `user_token`, `kurumsal_token`) VALUES 
									(NULL, '" . $id . "', '', '" . $uyeninID . "', '" . $date . "', '" . $uye_token . "', '');");
							echo '<script> alert("İlan Favorilerinize Eklendi")</script>';
							echo '<script> window.location.href = "tekliflerim.php";</script>';
						} else {
							mysql_query("DELETE FROM favoriler WHERE ilan_id = '" . $id . "' AND uye_id = '" . $uyeninID . "'");
							echo '<script> alert("İlan Favorilerinizden Kaldırıldı")</script>';
							echo '<script> window.location.href = "tekliflerim.php";</script>';
						}
					}
				}
				if (isset($_POST['bildirim_ac'])) {
					$date = date('Y-m-d H:i:s');
					$id = $_POST['bildirimlenecek'];
					$bildirim_cek = mysql_query("SELECT * FROM user WHERE kurumsal_user_token = '" . $uye_token . "'");
					while ($bildirim_oku = mysql_fetch_array($bildirim_cek)) {
						$uyeninID = $bildirim_oku['id'];
						$bildirim_varmi = mysql_query("SELECT * FROM bildirimler WHERE ilan_id = '" . $id . "' AND uye_id = '" . $uyeninID . "'");
						$bildirimini_say = mysql_num_rows($bildirim_varmi);
						if ($bildirimini_say == 0) {
							mysql_query("INSERT INTO `bildirimler` (`id`, `ilan_id`, `dogrudan_satisli_id`, `uye_id`, `bildirim_zamani`, `user_token`, `kurumsal_token`) VALUES 
								(NULL, '" . $id . "', '', '" . $uyeninID . "', '" . $date . "', '', '".$uye_token."');");
							echo '<script> alert("Bildirimler açıldı")</script>';
						} else {
							mysql_query("DELETE FROM bildirimler WHERE ilan_id = '" . $id . "' AND uye_id = '" . $uyeninID . "'");
							echo '<script> alert("Bildirimler kapatıldı")</script>';
						}
					}
				}
				?>

				<!--  <nav aria-label="Page navigation example">
                  <ul class="pagination justify-content-end">
                     <li class="page-item">
                        <a class="page-link" href="?sayfa=1" tabindex="-1" aria-disabled="true">İlk</a>
                     </li>
                     <li class="page-item <?php if ($sayfa <= 1) {
												echo 'disabled';
											} ?>">
                        <a class="page-link" href="<?php if ($sayfa <= 1) {
														echo '#';
													} else {
														echo "?sayfa=" . ($sayfa - 1);
													} ?>">Önceki</a>
                     </li>
                     <li class="page-item <?php if ($sayfa >= $toplam_sayfa) {
												echo 'disabled';
											} ?>">
                        <a class="page-link" href="<?php if ($sayfa >= $toplam_sayfa) {
														echo '#';
													} else {
														echo "?sayfa=" . ($sayfa + 1);
													} ?>">Sonraki</a>
                     </li>
                     <li class="page-item">
                        <a class="page-link" href="?sayfa=<?php echo $toplam_sayfa; ?>">Son</a>
                     </li>
                  </ul>
                  </nav>-->
			</div>
		</div>
	</div>
	<input type="hidden" id="kullaniciToken" value="<?= $uye_token ?>">
	<input type="hidden" id="ip" value="<?= GetIP() ?>">
	<input type="hidden" id="tarayici" value="<?= $browser ?>">
	<input type="hidden" id="isletim_sistemi" value="<?= $os ?>">
	<?php include 'template/footer.php'; ?>
	<script src="https://kit.fontawesome.com/2fdd899201.js" crossorigin="anonymous"></script>
	<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
	<script src="../js/toastr/toastr.js"></script>
	<script>
		var sira_array = <?php echo json_encode($sira_array) ?>;
		var modal_array = <?php echo json_encode($modal_array) ?>;

		function popup(text) {
			$(".modal").addClass("modal_zindex");
			swal({
				text: text,
				closeOnClickOutside: false,
				buttons: {
					defeat: "KAPAT",
				}
			}).then((value) => {
				switch (value) {
					case "defeat":
						$(".modal").removeClass("modal_zindex");
						break;
					default:
						break;
				}
			});
		}

		function formatMoney(n) {
			var n = (Math.round(n * 100) / 100).toLocaleString();
			n = n.replaceAll(',', '.')
			return n;
		}
	</script>
	<script>
		function secimleri_sil(id) {
			$('#verilen_teklif' + id).val("");
			$('#arti1' + id).css("background-color", "#00a2e8");
			$('#arti2' + id).css("background-color", "#00a2e8");
			$('#arti3' + id).css("background-color", "#00a2e8");
			$('#arti4' + id).css("background-color", "#00a2e8");
		}
		var ihale_say = document.getElementById('ihale_say');

		function createCountDown(elementId, sira) {
			var zaman = document.getElementById("ihale_sayac" + sira).value;
			var id = document.getElementById("id_" + sira).value;
			var countDownDate = new Date(zaman).getTime();
			var belirlenen = document.getElementById("belirlenen_" + sira).value;
			if (countDownDate > 0) {
				var x = setInterval(function() {
					jQuery.ajax({
						url: "https://ihale.pertdunyasi.com/check.php",
						type: "POST",
						dataType: "JSON",
						data: {
							action: "panel_ilan_guncelle",
							kapanis_zamani: $(".kapanis_zamani" + sira).html(),
							ilan_id: id,
						},
						success: function(response) {
							//$('#ilan_fiyat_bilgisi_' + id).html(formatMoney(response.son_teklif) + " ₺");
							$('#ilan_fiyat_bilgisi_' + id).html(response.son_teklif_yeni);
							$('#verilen_teklif_hidden'+id).val(response.son_teklif);
							$(".kapanis_zamani" + sira).html(response.ihale_tarihi);
							countDownDate = countDownDate + response.milisaniye;
							belirlenen = response.belirlenen;
							if(response.en_yuksek_benim == 1){
								$('#en_yuksek_benim_'+id).css("display","block");
								// $('#benim_teklif_'+id).html(response.son_teklif_yeni+" ₺ teklif verdiniz");
								$('#benim_teklif_'+id).html(formatMoney(response.son_teklif)+" ₺ teklif verdiniz");
							}else{
								$('#en_yuksek_benim_'+id).css("display","none");
							}

						}
					});
					var now = new Date().getTime();
					var distance = (countDownDate) - (now);
					var days = Math.floor(distance / (1000 * 60 * 60 * 24));
					var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
					var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
					var seconds = Math.floor((distance % (1000 * 60)) / 1000);
					if (days >= 0 && hours >= 0 && minutes >= 0 && seconds >= 0) {
						if (days <= 0 && hours <= 0 && minutes < belirlenen) {
							if (distance < 0) {
								sure_doldu(id);
								clearInterval(x);
								//document.getElementById(elementId).innerHTML = "Süre Doldu";   
							}
							if (hours < 10) {
								hours = "0" + hours;
							}
							if (minutes < 10) {
								minutes = "0" + minutes;
							}
							if (seconds < 10) {
								seconds = "0" + seconds;
							}
							document.getElementById(elementId).innerHTML = "XX:XX:XX ";
						} else {
							if (distance < 0) {
								sure_doldu(id);
								clearInterval(x);
								//document.getElementById(elementId).innerHTML = "Süre Doldu";   
							}
							if (hours < 10) {
								hours = "0" + hours;
							}
							if (minutes < 10) {
								minutes = "0" + minutes;
							}
							if (seconds < 10) {
								seconds = "0" + seconds;
							}
							document.getElementById(elementId).innerHTML = days + " Gün " + hours + ":" + minutes + ":" + seconds + " ";
						}
					} else {
						if (distance < 0) {
							sure_doldu(id);
							clearInterval(x);
							//document.getElementById(elementId).innerHTML = "Süre Doldu";   
						}
						if (belirlenen > 0) {
							document.getElementById(elementId).innerHTML = "XX:XX:XX ";
						} else {
							document.getElementById(elementId).innerHTML = "Süre Doldu";
						}
					}
					/*var now = new Date().getTime();
						var distance = (countDownDate) - (now);
						var days = Math.floor(distance / (1000 * 60 * 60 * 24));
						var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
						if(hours<10){
							hours="0"+hours;
						}
						var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
						if(minutes<10){
							minutes="0"+minutes;
						}
						var seconds = Math.floor((distance % (1000 * 60)) / 1000);
						if(seconds<10){
							seconds="0"+seconds;
						}
						if(days>=0 && hours>=0 && minutes>=0 && seconds >= 0){
							//console.log(elementId)
							document.getElementById(elementId).innerHTML = days + " Gün " + hours + ":"+ minutes + ":" + seconds + " ";
						}
					*/
					if (distance < 0) {
						sure_doldu(id);
						clearInterval(x);
						//document.getElementById(elementId).innerHTML = "Süre Doldu";   
					}
				}, 1000);
			}
		}
		for (var i = 0; i <= sira_array.length; i++) {
			if (jQuery.inArray(i, sira_array) > -1) {
				createCountDown("sayac" + i, i);
			}
		}
		for (var h = 0; h <= modal_array.length; h++) {
			if (jQuery.inArray(h, modal_array) > -1) {
				createCountDown("modalZaman" + h, h);
			}
		}
	</script>
	<script>
		var genislik = window.innerWidth;
		if (genislik > 600) {
			$('.alti_slider').owlCarousel({
				rewind: true,
				items: 6,
				loop: false,
				autoplay: true,
				autoplayTimeout: 5000,
				autoplayHoverPause: true,
				margin: 10,
			})
		} else {
			$('.alti_slider').owlCarousel({
				rewind: true,
				items: 1,
				loop: false,
				autoplay: true,
				autoplayTimeout: 5000,
				autoplayHoverPause: true,
				margin: 10,
			})
		}
		function ihale_arttir(id) {
			jQuery.ajax({
				url: "https://ihale.pertdunyasi.com/check.php",
				type: "POST",
				dataType: "JSON",
				data: {
					action: "ihale_arttir",
					ilan_id: id,
					ip: document.getElementById("ip").value,
				},
				success: function(response) {
					console.log(response);
				}
			});
		}
	</script>
	<script>
		function sure_doldu(id) {
			jQuery.ajax({
				url: "https://ihale.pertdunyasi.com/check.php",
				type: "POST",
				dataType: "JSON",
				data: {
					action: "sure_doldu",
					id: id
				},
				success: function(response) {
					if (response.status == 200) {
						//window.location="ihaledeki_araclar.php";
					}
				}
			});
		}
	</script>
	<script>
		function degistir(ilan_id) {
			document.getElementById("GelenTeklif" + ilan_id).style.display = "block";
			if ($("#verilen_teklif" + parseInt(ilan_id)).val() != "") {
				document.getElementById("GelenTeklif" + parseInt(ilan_id)).value = $("#verilen_teklif" + parseInt(ilan_id)).val();
				// document.getElementById("GelenTeklif"+parseInt(ilan_id)).innerHTML =  formatMoney($("#verilen_teklif"+parseInt(ilan_id)).val()) + "₺ teklif vermek üzeresiniz";
				document.getElementById("GelenTeklif" + parseInt(ilan_id)).innerHTML = formatMoney($("#verilen_teklif" + parseInt(ilan_id)).val()) + "₺";
			} else if ($("#verilen_teklif_hidden" + ilan_id).val() != "") {
				if ($("#verilen_teklif_hidden" + ilan_id).val() != undefined) {
					document.getElementById("GelenTeklif" + parseInt(ilan_id)).value = $("#verilen_teklif_hidden" + ilan_id).val();
					document.getElementById("GelenTeklif" + parseInt(ilan_id)).innerHTML = formatMoney($("#verilen_teklif_hidden" + ilan_id).val()) + " ₺ teklif vermek üzeresiniz";
				} else {
					document.getElementById("GelenTeklif" + parseInt(ilan_id)).value = "";
					document.getElementById("GelenTeklif" + parseInt(ilan_id)).innerHTML = "";
				}
			} else {
				document.getElementById("GelenTeklif" + parseInt(ilan_id)).value = "";
				document.getElementById("GelenTeklif" + parseInt(ilan_id)).innerHTML = "";
			}
			/*
			document.getElementById("GelenTeklif"+ilan_id).style.display = "block";
			if($("#verilen_teklif"+parseInt(ilan_id)).val()!=""){
				document.getElementById("GelenTeklif"+parseInt(ilan_id)).value = $("#verilen_teklif"+parseInt(ilan_id)).val() ;
				document.getElementById("GelenTeklif"+parseInt(ilan_id)).innerHTML =  formatMoney($("#verilen_teklif"+parseInt(ilan_id)).val()) + " ₺ teklif vermek üzeresiniz";
			}else if($("#verilen_teklif_hidden"+ilan_id).val()!=""  ){
				if( $("#verilen_teklif_hidden"+ilan_id).val()!=undefined){
					document.getElementById("GelenTeklif"+parseInt(ilan_id)).value = $("#verilen_teklif_hidden"+ilan_id).val() ;
					document.getElementById("GelenTeklif"+parseInt(ilan_id)).innerHTML =  formatMoney($("#verilen_teklif_hidden"+ilan_id).val()) + " ₺ teklif vermek üzeresiniz";
				}else{
					document.getElementById("GelenTeklif"+parseInt(ilan_id)).value = "";
					document.getElementById("GelenTeklif"+parseInt(ilan_id)).innerHTML =  "";
				}
			}else{
				document.getElementById("GelenTeklif"+parseInt(ilan_id)).value = "";
				document.getElementById("GelenTeklif"+parseInt(ilan_id)).innerHTML =  "";
			}
			*/
		}
	</script>
	<script>
		function kontrol(ilan_id) {
			$.ajax({
				url: '../teklif_ver.php',
				method: 'post',
				dataType: "json",
				data: {
					action: "checked_kontrol",
					ilanID: ilan_id,
					uye_token: "<?= $uye_token ?>",
				},
				success: function(data) {
					if (data.status == 200) {
						$("#sozlesme_kontrol" + parseInt(ilan_id)).prop('checked', true);
					} else {
						$("#sozlesme_kontrol" + parseInt(ilan_id)).prop('checked', false);
					}
				},
				error: function(data) {
					alert('HATA! Lütfen tekrar deneyiniz.')
				}
			});
		}
	</script>
	<script>
		function komisyon_kontrol(id) {
			var hesaplama = document.getElementById("hesaplama" + id).value;
			if (document.getElementById("verilen_teklif" + id).value != "") {
				var girilen_teklif = parseInt(document.getElementById("verilen_teklif" + id).value);
			} else if ($("#verilen_teklif_hidden" + id).val() != "") {
				if ($("#verilen_teklif_hidden" + id).val() != undefined) {
					var girilen_teklif = parseInt(document.getElementById("verilen_teklif_hidden" + id).value);
				}
			}
			$.ajax({
				url: '../teklif_ver.php',
				method: 'post',
				dataType: "json",
				data: {
					action: "komisyon_cek",
					ilan_id: id,
					girilen_teklif: girilen_teklif
				},
				success: function(data) {
					var son_komisyon = data.son_komisyon;
					if (son_komisyon == 0 || son_komisyon == undefined || son_komisyon == null || son_komisyon == "") {
						document.getElementById("hizmet_bedel" + id).innerHTML = "" + "₺";
						document.getElementById("hizmet_bedel" + id).value = "" + "₺";
					} else {
						document.getElementById("hizmet_bedel" + id).innerHTML = formatMoney(son_komisyon) + "₺";
						document.getElementById("hizmet_bedel" + id).value = son_komisyon + "₺";
					}
				},
			});


			/*var oran = <?php echo json_encode($oran); ?>;
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
					document.getElementById("hizmet_bedel"+id).innerHTML = "" +"₺";
					document.getElementById("hizmet_bedel"+id).value = "" +"₺";
				}else {
					document.getElementById("hizmet_bedel"+id).innerHTML = formatMoney(son_komisyon) +"₺";
					document.getElementById("hizmet_bedel"+id).value = son_komisyon +"₺";
				}	*/
		}
	</script>
	<script>
		function teklif_kontrol(ilan_id) {
			$("#GelenTeklif"+ilan_id).html(formatMoney($("#verilen_teklif"+ilan_id).val())+"₺");
			$.ajax({
				url: '../teklif_ver.php',
				method: 'post',
				dataType: "json",
				data: {
					action: "teklif_kontrol",
					ilanID: ilan_id,
					teklif: $("#verilen_teklif" + parseInt(ilan_id)).val(),
					uye_token: "<?= $uye_token ?>",
				},
				success: function(data) {
					if (data.status != 200) {
						$("#GelenTeklif" + ilan_id).html($("#verilen_teklif" + ilan_id).val());
						$("#teklif_kontrol" + parseInt(ilan_id)).html(data.message);
						$("#teklif_kontrol" + parseInt(ilan_id)).css("color", "red");
					} else {
						$("#teklif_kontrol" + parseInt(ilan_id)).html("");
					}
				},
				error: function(data) {
					alert('HATA! Lütfen tekrar deneyiniz.')
				}
			});
		}
	</script>
	<script>
		function enyuksek_getir(ilan_id) {
			/*	jQuery.ajax({
               		url: "https://ihale.pertdunyasi.com/check.php",
               		type: "POST",
               		dataType: "JSON",
               		data: {
               			action: "enyuksek_yenile",
               			id:ilan_id,
               		},
               		success: function(response) {
               			if (response.status == 200) {
         				var deneme=document.getElementById("modalTeklif"+(ilan_id)).innerHTML;
         				var a=response.teklif;
         				var b=document.getElementById("modalTeklif"+ilan_id).value;
               				if(a != b ){
         					alert("En yüksek teklif fiyatı değişti.");
         					$("#GelenTeklif"+parseInt(ilan_id)).val(parseInt(response.teklif)+<?= $min_arti ?>);
         					document.getElementById("verilen_teklif_hidden"+ilan_id).value=parseInt(response.teklif)+<?= $min_arti ?>;
               					document.getElementById("GelenTeklif"+ilan_id).innerHTML= formatMoney(response.teklif+<?= $min_arti ?>);
               					document.getElementById("modalTeklif"+ilan_id).value = a;
               					document.getElementById("modalTeklif"+ilan_id).innerHTML = formatMoney(a) + " ₺";
               				}
               			}else{
               				 //window.location="index.php";
               			}
               		}
               	});*/
		}

		function denem(ilan_id) {
			var girilen_teklif = $("#girilen_teklif" + ilan_id).val();
			var kullaniciToken = $('#kullaniciToken').val();

			var uyeID = $('#uyeID').val();
			var ip = $('#ip').val();
			var tarayici = $('#tarayici').val();
			var isletim_sistemi = $('#isletim_sistemi').val();
			var sozlesme_kontrol = $('#sozlesme_kontrol').val();
			var hizmet_bedel = parseInt($('#hizmet_bedel' + ilan_id).val());
			var verilen_teklif = "";
			if (document.getElementById("verilen_teklif" + ilan_id).value != "") {
				verilen_teklif = parseInt(document.getElementById("verilen_teklif" + ilan_id).value);
			} else if ($("#verilen_teklif_hidden" + ilan_id).val() != "") {
				if ($("#verilen_teklif_hidden" + ilan_id).val() != undefined) {
					verilen_teklif = parseInt(document.getElementById("verilen_teklif_hidden" + ilan_id).value);
				} else {
					alert('Lütfen teklifinizi giriniz.');
				}
			} else {
				alert('Lütfen teklifinizi giriniz.');
			}
			if (verilen_teklif == "") {
				alert('Lütfen teklifinizi giriniz.');
			} else {
				$.ajax({
					url: '../teklif_ver.php',
					method: 'post',
					dataType: "json",
					data: {
						action: "teklif_ver",
						verilen_teklif: verilen_teklif,
						hizmet_bedel: hizmet_bedel,
						ilanID: ilan_id,
						uye_token: "<?= $uye_token ?>",
						ip: ip,
						tarayici: tarayici,
						isletim_sistemi: isletim_sistemi,
						sozlesme_kontrol: $('input:checkbox:checked').val(),
					},
					success: function(data) {
						$('#modal_kapat' + ilan_id).trigger("click");
						alert(data.message);
						if (data.status == 200) {
							$('#benim_teklif_'+ilan_id).html(formatMoney(verilen_teklif)+" ₺ teklif verdiniz.");
							document.getElementById("verilen_teklif" + ilan_id).value = "";
							document.getElementById("verilen_teklif_hidden" + ilan_id).value = verilen_teklif;
							secimleri_sil(ilan_id);
							$('.close').trigger("click");
							$('#acik_modal_kapat' + ilan_id).trigger("click");
							//location.reload();
						}
					},
					error: function(data) {
						alert('HATA! Lütfen tekrar deneyiniz.')
					}
				});
			}
		}
	</script>
	<script>
		function buttonClick(id) {
			var i = document.getElementById("verilen_teklif_hidden" + id).value;
			var plus = parseInt(i);
			var hizli1 = document.getElementById("arti1" + id).value;
			plus += parseInt(hizli1);

			//document.getElementById("verilen_teklif_hidden"+id).value=plus;
			document.getElementById("verilen_teklif" + id).value = plus;
			$('#arti1' + id).css("background-color", "#71bc42");
			$('#arti2' + id).css("background-color", "#00a2e8");
			$('#arti3' + id).css("background-color", "#00a2e8");
			$('#arti4' + id).css("background-color", "#00a2e8");

			document.getElementById("GelenTeklif" + id).style.display = "block";

			komisyon_kontrol(id);
		}

		function clickButton(id) {
			var i = document.getElementById("verilen_teklif_hidden" + id).value;
			var plus = parseInt(i);
			var hizli3 = document.getElementById("arti3" + id).value;
			plus += parseInt(hizli3);

			//document.getElementById("verilen_teklif_hidden"+id).value=plus;
			document.getElementById("verilen_teklif" + id).value = plus;
			$('#arti1' + id).css("background-color", "#00a2e8");
			$('#arti2' + id).css("background-color", "#00a2e8");
			$('#arti3' + id).css("background-color", "#71bc42");
			$('#arti4' + id).css("background-color", "#00a2e8");

			document.getElementById("GelenTeklif" + id).style.display = "block";
			komisyon_kontrol(id);
		}

		function buttonClick2(id) {
			var i = document.getElementById("verilen_teklif_hidden" + id).value;
			var plus = parseInt(i);
			var hizli2 = document.getElementById("arti2" + id).value;
			plus += parseInt(hizli2);
			//document.getElementById("verilen_teklif_hidden"+id).value=plus;
			document.getElementById("verilen_teklif" + id).value = plus;
			$('#arti1' + id).css("background-color", "#00a2e8");
			$('#arti2' + id).css("background-color", "#71bc42");
			$('#arti3' + id).css("background-color", "#00a2e8");
			$('#arti4' + id).css("background-color", "#00a2e8");
			document.getElementById("GelenTeklif" + id).style.display = "block";
			komisyon_kontrol(id);
		}

		function clickButton2(id) {
			var i = document.getElementById("verilen_teklif_hidden" + id).value;
			var plus = parseInt(i);
			var hizli4 = document.getElementById("arti4" + id).value;
			$('#arti1' + id).css("background-color", "#00a2e8");
			$('#arti2' + id).css("background-color", "#00a2e8");
			$('#arti3' + id).css("background-color", "#00a2e8");
			$('#arti4' + id).css("background-color", "#71bc42");
			plus += parseInt(hizli4);
			//document.getElementById("verilen_teklif_hidden"+id).value=plus;
			document.getElementById("verilen_teklif" + id).value = plus;
			document.getElementById("GelenTeklif" + id).style.display = "block";
			komisyon_kontrol(id);
		}
		/*
			function buttonClick(id) {
				var i = document.getElementById("verilen_teklif_hidden"+id).value;
				var plus = parseInt(i);
				var hizli1 = document.getElementById("arti1"+id).value;
				plus += parseInt(hizli1);
				
				//document.getElementById("verilen_teklif_hidden"+id).value=plus;
				document.getElementById("verilen_teklif"+id).value = plus;

				document.getElementById("GelenTeklif"+id).style.display = "block";
         
				komisyon_kontrol(id);
			}
			function ButtonClick(id) {
				var i = document.getElementById("verilen_teklif_hidden"+id).value;
				var plus = parseInt(i);
				var hizli2 = document.getElementById("arti2"+id).value;
				plus +=  parseInt(hizli2);
         
				//document.getElementById("verilen_teklif_hidden"+id).value=plus;
				document.getElementById("verilen_teklif"+id).value = plus;
         
				document.getElementById("GelenTeklif"+id).style.display = "block";
         
				komisyon_kontrol(id);
			}
			function clickButton(id) {
				var i = document.getElementById("verilen_teklif_hidden"+id).value;
				var plus = parseInt(i);
				var hizli3 = document.getElementById("arti3"+id).value;
				plus +=  parseInt(hizli3);
				
				//document.getElementById("verilen_teklif_hidden"+id).value=plus;
				document.getElementById("verilen_teklif"+id).value = plus;
         
				document.getElementById("GelenTeklif"+id).style.display = "block";
				komisyon_kontrol(id);
			}
			function ClickButton(id) {
				var i = document.getElementById("verilen_teklif_hidden"+id).value;
				var plus = parseInt(i);
				var hizli4 = document.getElementById("arti4"+id).value;
				plus +=  parseInt(hizli4);
         
				//document.getElementById("verilen_teklif_hidden"+id).value=plus;
				document.getElementById("verilen_teklif"+id).value = plus;
         
				document.getElementById("GelenTeklif"+id).style.display = "block";
				komisyon_kontrol(id);
			}
			*/
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
		//Sayfa Yenileme 60sn
		/*setInterval(function(){
			window.location.reload(false);
		},60000);*/

		function bildirim_ac(id) {
			jQuery.ajax({
				url: '../action.php',
				method: 'POST',
				dataType: "JSON",
				data: {
					action: "bildirim_ac",
					id: id
				},
				success: function(data) {
					$("#bildirim_ac_" + id).tooltip('hide');
					if (data.status != 200) {
						openToastrDanger(data.message);
					} else {
						openToastrSuccess(data.message);
						$("#bildirim_ac_" + id + " i").css("color", data.color);
						$("#bildirim_ac_" + id).attr("data-original-title", data.title);
					}
				}
			});
		}

		function favla(id) {
			jQuery.ajax({
				url: '../action.php',
				method: 'POST',
				dataType: "JSON",
				data: {
					action: "favorilere_ekle",
					id: id
				},
				success: function(data) {
					$("#favla_" + id).tooltip('hide');
					if (data.status != 200) {
						openToastrDanger(data.message);
					} else {
						openToastrSuccess(data.message);
						$("#favla_" + id + " i").css("color", data.color);
						$("#favla_" + id).attr("data-original-title", "");
						$("#favla_" + id).attr("data-original-title", data.title);
					}
				}
			});
		}
		$(function() {
			$('[data-toggle="tooltip"]').tooltip()
		})
	</script>
</body>

</html>