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
					if ($sitenin_acilis_popupunu_oku['buton'] == 0) {
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
						//  $siteye_giren_guncelle = mysql_query("update siteye_girenler set tarih = '".date('Y-m-d H:i:s')."' where ip_adresi = '".getIP()."'");
					}
				}
			}
		}
		?>
		<style>
			@media screen and (max-width: 600px) {
				.navbar-collapse {
					margin-top: 83px !important;
					display: block !important;
					padding-bottom: 20px;
				}

				.site-navbar {
					position: absolute;
					margin: 0px !important;
					top: 0px;
					left: 0px;
				}

				.navbar-expand-md .navbar-nav .dropdown-menu {
					position: relative !important;
				}
			}

			.navbar-expand-md .navbar-nav .dropdown-menu {
				position: absolute;
				right: 0px;
				width: auto;
				left: auto;
				z-index: 9999;
			}
		</style>
		<?php
		if ($uye_token != "") {
			if ($_SESSION["u_token"] != "") {
				$yol = "uye_panel";
				$kullanici_cek = mysql_query("SELECT * FROM `user` WHERE user_token = '$uye_token' ");
				$kullanici_oku = mysql_fetch_array($kullanici_cek);
			} else if ($_SESSION["k_token"] != "") {
				$yol = "kurumsal_panel";
				$kullanici_cek = mysql_query("SELECT * FROM `user` WHERE kurumsal_user_token = '$uye_token' ");
				$kullanici_oku = mysql_fetch_array($kullanici_cek);
			} else {
				$yol = "";
			}
			$nav_display = "block";
		}else{
			$nav_display = "none";
		}
		?>	
		<style>
			@media screen and (min-width: 1365px) {
				.site-navbar .site-navigation .site-menu>li>a {
					margin-left: 10px;
					margin-right: 5px;
					padding: 15px 0px;
					color: #fff !important;
					display: inline-block;
					text-decoration: none !important;
					font-size: 15px;
				}

				.yeni {
					font-size: 20px !important;
				}
			}

			@media screen and (min-width: 1600px) {
				.site-navbar .site-navigation .site-menu>li>a {
					margin-left: 15px;
					margin-right: 10px;
					padding: 15px 0px;
					color: #fff !important;
					display: inline-block;
					text-decoration: none !important;
					font-size: 18px;
				}

				.yeni {
					font-size: 20px !important;
					margin-left: 20px;
					margin-right: 15px;
				}
			}

			@media screen and (max-width: 1365px) {
				.site-navbar .site-navigation .site-menu>li>a {
					margin-left: 0px;
					margin-right: 4px;
					padding: 15px 0px;
					color: #fff !important;
					display: inline-block;
					text-decoration: none !important;
					font-size: 12px;
				}

				.yeni {
					font-size: 13px !important;
				}
			}



			.header_div {
				display: none;
			}

			/* 06.05.2021 Düzenleme */
			body {
				overflow-x: hidden !important;
				padding-left: 0px !important;
				padding-right: 0px !important;
				margin: 0px !important;
				width: 100% !important;
				font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", "Liberation Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji" !important;
			}



			.form-check {
				padding-left: 0px !important;
			}

			@media screen and (min-width: 768px) {
				.site-footer {
					padding: 3em 0 !important;
				}
			}

			@media screen and (max-width: 600px) {
				.site-navbar {
					padding: 10px !important;
				}

				.site_logo_dis {
					width: 70% !important;
				}

				.site-logo a img {
					height: 40px;
				}

				.mobile_menu_dis {
					width: 30% !important;
				}

				.site-mobile-menu {
					top: 0px !important;
				}

				.site-menu-toggle {
					padding-bottom: 0px !important;
				}

				.modal {
					z-index: 999999;
					background-color: #0000004a;
					margin-top: 0px !important;
					padding-top: 10%;
				}

				.site-mobile-menu {
					height: calc(100vh + 100px);
					position: fixed;
					top: 0px !important;
					right: 0px !important;
				}

				.slide {
					margin-top: -16px !important;
				}

				.header_div {
					width: 100%;
					height: 15px;
					/* margin-bottom: 15px;*/
					display: block;
				}

				.row {
					margin-left: 0px !important;
					margin-right: 0px !important;
				}

				.media_margin {
					margin-top: -20px;
				}
			}

			.deneme p {
				margin-bottom: 0px !important;
				margin-top: 0px !important;
				margin-left: 15px;
				font-size: large;
			}

			.kutlama_gorseli img{
				background-color: transparent !important;
			}

		</style>
		<?php

		$today = date("Y-m-d");
		$hour = date("H:i:s");
		$ihale_cek2 = mysql_query("SELECT * FROM ilanlar WHERE ihale_acilis <= '" . $today . "' AND ihale_tarihi >= '" . $today . "' AND durum = 1");
		$dogrudan_cek2 = mysql_query("SELECT * FROM dogrudan_satisli_ilanlar WHERE durum = 1");
		$dogrudan_satis_sayisi2 = mysql_num_rows($dogrudan_cek2);
		$ihale_sayisi2 = mysql_num_rows($ihale_cek2);

		$bugun = date("Y-m-d");
		$sorgu = mysql_query("SELECT * FROM kutlama_gorseli WHERE '$bugun' < reklam_bitis AND '$bugun' >= reklam_baslangic ORDER BY id ASC LIMIT 1 ");
		while ($yaz = mysql_fetch_array($sorgu)) {
		?>
			<nav class="deneme" style="padding-bottom: 0%;width:100%;text-align:center; padding-top: 0%;color:<?= $yaz['yazi_renk'] ?>; background-color:<?= $yaz['arkaplan_renk'] ?>;padding: 0!important;">
				<div class="row">
					<div class="col-sm-12 kutlama_gorseli" style="padding:15px">
						<?= $yaz['icerik'] ?>
					</div>
				</div>

			</nav>
		<?php } ?>

		<nav class="navbar navbar-expand-md navbar-dark bg-dark " style="padding-bottom: 0%; padding-top: 0%; display: <?= $nav_display ?>">
			<div class="collapse navbar-collapse" id="navbarCollapse">
				<ul class="navbar-nav mr-auto">
					<li class="nav-item active" style="font-size: small;">
						<?php
						$uye_durum_cek = mysql_query("SELECT * FROM uye_durumlari WHERE uye_id = '" . $kullanici_oku['id'] . "'");
						$uye_durum_oku = mysql_fetch_assoc($uye_durum_cek);
						$uye_demo_tarihi = $uye_durum_oku['demo_olacagi_tarih'];
						if ($uye_demo_tarihi == $bugun) {
							$demo_yetki_cek = mysql_query("SELECT * FROM uye_grubu WHERE id = 1");
							$demo_yetki_oku = mysql_fetch_assoc($demo_yetki_cek);
							$ust_limiti = $demo_yetki_oku['teklif_ust_limit'];
							$ust_standart = $demo_yetki_oku['standart_ust_limit'];
							$ust_luks = $demo_yetki_oku['luks_ust_limit'];
							mysql_query("UPDATE user SET paket = 1 WHERE id = '" . $kullanici_oku['id'] . "'");
							mysql_query("UPDATE teklif_limiti SET teklif_limiti = '" . $ust_limiti . "', standart_limit = '0',
								luks_limit = '0' WHERE uye_id = '" . $kullanici_oku['id'] . "'");
						}
						/*
						$toplam_aktif = mysql_query('SELECT SUM(net) AS net FROM cayma_bedelleri WHERE uye_id = "'.$kullanici_oku['id'].'" and durum=1'); 
						$toplam_getir = mysql_fetch_assoc($toplam_aktif); 
						$toplam_cayma = $toplam_getir['net'];
						$toplam_borc = mysql_query('SELECT SUM(net) AS net FROM cayma_bedelleri WHERE uye_id = "'.$kullanici_oku['id'].'" and durum=2'); 
						$toplam_borc_getir = mysql_fetch_assoc($toplam_borc); 
						$toplam_borc_cayma = $toplam_getir['net'];
						$cayma=$toplam_cayma+toplam_borc_cayma;*/
						$aktif_cayma_toplam = mysql_query("SELECT SUM(tutar) as toplam_aktif_cayma FROM cayma_bedelleri WHERE uye_id='" . $kullanici_oku['id'] . "' AND durum=1");
						$toplam_aktif_cayma = mysql_fetch_assoc($aktif_cayma_toplam);
						$iade_talepleri_toplam = mysql_query("SELECT SUM(tutar) as toplam_iade_talepleri FROM cayma_bedelleri WHERE uye_id='" . $kullanici_oku['id'] . "' AND durum=2");
						$toplam_iade_talepleri = mysql_fetch_assoc($iade_talepleri_toplam);
						$borclar_toplam = mysql_query("SELECT SUM(tutar) as toplam_borclar FROM cayma_bedelleri WHERE uye_id='" . $kullanici_oku['id'] . "' AND durum=6");
						$toplam_borclar = mysql_fetch_assoc($borclar_toplam);
						// $cayma=$toplam_aktif_cayma["toplam_aktif_cayma"]-$toplam_iade_talepleri["toplam_iade_talepleri"]-$toplam_borclar["toplam_borclar"];
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
						<a class="nav-link uyelik" style="font-weight: bold;color:<?= $color ?> !important;"><b><?= mb_strtoupper($paket_adi, "utf-8") ?> ÜYE</b></a>
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
							<?php
							if ($kullanici_oku["user_token"] != "") {
								echo $kullanici_oku['ad'];
							} else {
								echo $kullanici_oku["unvan"];
							}
							?>
						</a>
						<div class="dropdown-menu" aria-labelledby="navbarDropdown">
							<a class="dropdown-item" href="<?= $yol ?>/index.php">Üye Panelim</a>
							<?php if ($paket != "21") { ?>
								<a class="dropdown-item" href="<?= $yol ?>/islemler/gold_uyelik_basvuru.php?id=21">Gold Üyelik Başvurusu</a>
							<?php } ?>
							<?php
							$sozlesmeyi_cek = mysql_query("select * from uyelik_pdf where id = 1");
							$sozlesmeyi_bas = mysql_fetch_object($sozlesmeyi_cek);
							if ($kullanici_oku["user_token"] != "") {
								$uyelik_sozlesme = $sozlesmeyi_bas->bireysel_pdf;
							} else {
								$uyelik_sozlesme = $sozlesmeyi_bas->kurumsal_pdf;
							}
							?>
							<a class="dropdown-item" href="images/pdf/<?= $uyelik_sozlesme ?>" target="_blank">Üyelik Sözleşmesi Görüntüle</a>
							<?php
							$kazanma_sorgula = mysql_query("select * from kazanilan_ilanlar where uye_id='" . $kullanici_oku['id'] . "' ");
							if (mysql_num_rows($kazanma_sorgula) > 0 && $paket == "21") {
								/*
								<a class="dropdown-item" href="https://ihale.pertdunyasi.com/pdf.php?id=1&uye_id=<?=$kullanici_oku['id']?>&q=vekaletname_pdf" target="_blank">Vekaletname Örneği Görüntüle(PDF)</a>
								<a class="dropdown-item" href="https://ihale.pertdunyasi.com/word.php?id=1&uye_id=<?=$kullanici_oku['id']?>&q=vekaletname_word" >Vekaletname Örneği Görüntüle(WORD)</a>
								*/
								$vekaletname_cek = mysql_fetch_object(mysql_query("select * from vekaletname_pdf")); ?>
								<a class="dropdown-item" href="https://ihale.pertdunyasi.com/<?= $vekaletname_cek->vekaletname ?>" target="_blank">Vekaletname Örneği Görüntüle(PDF)</a>
								<a class="dropdown-item" href="https://ihale.pertdunyasi.com/<?= $vekaletname_cek->vekaletname_word ?>" target="_blank">Vekaletname Örneği Görüntüle(WORD)</a>
							<?php } ?>
							<a class="dropdown-item" href="<?= $yol ?>/evrak_yukle.php">Evrak Yükle</a>
						</div>
					</li>
					<li class="nav-item active mr-0">
						<a class="nav-link" href="<?= $yol ?>/islemler/logout.php">Çıkış Yap</a>
					</li>
				</ul>
			</div>
		</nav>
		<div class="site-wrap" id="home-section">
			<div class="site-mobile-menu site-navbar-target">
				<div class="site-mobile-menu-header">
					<div class="site-mobile-menu-close mt-3">
						<span class="icon-close2 js-menu-toggle"></span>
					</div>
				</div>
				<div class="site-mobile-menu-body"></div>
			</div>
			<div class="header_div"></div>

			<header class="site-navbar site-navbar-target media_margin">

				<div class="row align-items-center position-relative">
					<div class="col-2 ">
					</div>
					<div class="col-10 text-right" style="margin-top:1%;">

						<nav class="site-navigation text-right ml-auto d-none d-lg-block" style="margin-bottom:-4% !important; margin-top:-3% !important;" role="navigation">
							<ul class="site-menu main-menu js-clone-nav ml-auto ">
								<li style="font-size:14px;">
									<?php if (!isset($_SESSION['u_token']) || !isset($_SESSION['k_token'])) { ?>
										<a href="#exampleModal2" id="giris_yap_btn" data-toggle="modal" class="nav-link"><i style="color: gold;" class="fas fa-user"> Giris Yap</i> </a>

									<?php }/*elseif($_SESSION['u_token'] != ""){ ?>
								<a href="uye_panel" class="nav-link">&nbsp;Profil</a>
							<?php }elseif($_SESSION['k_token'] != ""){ ?>
								<a href="kurumsal_panel" class="nav-link" >&nbsp;Profil</a>
							<?php }*/ ?>
								</li>
								<li style="font-size:14px;">
									<?php if (!isset($_SESSION['u_token']) || !isset($_SESSION['k_token'])) { ?>
										<a href="#exampleModal" data-toggle="modal" class="nav-link"><i style="color: gold;" class="fas fa-sign-in-alt"> </i> Uye Ol </a>
									<?php } /* else{ ?>
								<?php if($_SESSION['u_token'] != ""){ ?>
									<a href="uye_panel/islemler/logout.php" class="nav-link">&nbsp;Çıkış Yap</a>
								<?php }else if($_SESSION['k_token'] != ""){ ?>
									<a href="kurumsal_panel/islemler/logout.php" class="nav-link">&nbsp;Çıkış Yap</a>
								<?php } ?>
							<?php }*/ ?>
								</li>
							</ul>
						</nav>
					</div>
				</div>
				<div class="row align-items-center position-relative">
					<div class="col-xs-8 col-sm-3 site_logo_dis">
						<div class="site-logo">
							<a href="index.php"><img src="images/logo2.png"></a>
						</div>
					</div>
					<div class="col-xs-4 col-sm-9 text-right mobile_menu_dis">
						<span class="d-inline-block d-lg-none">
							<a href="#" class="text-white site-menu-toggle js-menu-toggle py-5 text-white">
								<span class="icon-menu h3 text-white"></span>
							</a>
						</span>
						<nav class="site-navigation text-right ml-auto d-none d-lg-block" style="font-size: 14px;" role="navigation">
							<ul class="site-menu main-menu js-clone-nav ml-auto ">
								<li style="font-size: 12px; padding:0px;" class="px-1"><a href="index.php" class="nav-link"><b>Ana Sayfa</b></a></li>
								<li style="font-size: 12px; padding:0px;"><a href="bulletin.php"><b>Blog</b></a></li>
								<li style="font-size: 12px; padding:0px;" class="nav-link px-1"><a href="sistem_nasil_isler.php"><b>Sistem Nasıl İşler?</b></a></li>
								<li style="font-size: 12px; padding:0px;" class="nav-link px-1"><a href="yorumlar.php"><b>Yorumlar</b></a></li>
								<li style="font-size: 12px; padding:0px;" class="nav-link px-1"><a href="contact.php"><b>İletişim</b></a></li>
								<li style="font-size: 13px;" class="nav-link yeni px-1"><a href="ihaledeki_araclar.php"><b><i class="fas fa-gavel"></i> İHALEDEKİ ARAÇLAR<sup><?= $ihale_sayisi2 ?></sup></b></a></li>
								<li style="font-size: 13px;" class="nav-link yeni px-1"><a href="dogrudan_satisli_araclar.php"><b><i class="fas fa-handshake"></i> DOĞRUDAN SATIŞ<sup><?= $dogrudan_satis_sayisi2 ?></sup></b></a></li>
							</ul>
						</nav>
					</div>
				</div>
			</header>
		</div>