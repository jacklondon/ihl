<?php
session_start();
include('../ayar.php');
include 'ayar.php';
$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";



$token = $_SESSION['u_token'];
$k_token = $_SESSION['k_token'];
if ($token != "" && $k_token == "") {
	$uye_token = $token;
} elseif ($token == "" && $k_token != "") {
	$uye_token = $k_token;
}



$kullanici_grubu = kullanici_grubu_cek($uye_token); //Uye Paketi Sorgula Function 

$gelen_id = re("id");
$cekilecek = re('q');



if ($cekilecek == "ihale") {
	$seo_ilan_cek = mysql_query("select * from ilanlar where id = '" . $gelen_id . "'");
	$seo_ilan_oku = mysql_fetch_object($seo_ilan_cek);
	$seo_ilan_profil = $seo_ilan_oku->profil;

	$goruntulenme_cek_first = mysql_query("select * from ihale_goruntulenme where ilan_id = '" . $gelen_id . "' and ip = '" . getIP() . "'");
	if (mysql_num_rows($goruntulenme_cek_first) == 0) {
		mysql_query("insert into ihale_goruntulenme (ilan_id,ip,tarih) values ('" . $gelen_id . "','" . getIP() . "','" . date('Y-m-d H:i:s') . "')");
	}

	$seo_marka_oku = mysql_fetch_object(mysql_query("select * from marka where markaID = '" . $seo_ilan_oku->marka . "'"));
	$seo_marka = $seo_marka_oku->marka_adi;

	if ($seo_ilan_profil == "Hurda Belgeli") {
		$seo_baslik = "Hurda Oto " . $seo_ilan_oku->sehir . " " . $seo_marka . " " . $seo_ilan_oku->model;
	} elseif ($seo_ilan_profil == "Çekme Belgeli") {
		$seo_baslik = "Pert Araba " . $seo_ilan_oku->sehir . " " . $seo_marka . " " . $seo_ilan_oku->model;
	} elseif ($seo_ilan_profil == "Çekme Belgeli/Pert Kayıtlı") {
		$seo_baslik = "Hasarlı Araçlar " . $seo_ilan_oku->sehir . " " . $seo_marka . " " . $seo_ilan_oku->model;
	} elseif ($seo_ilan_profil == "Plakalı") {
		$seo_baslik = "Hasarlı Oto " . $seo_ilan_oku->sehir . " " . $seo_marka . " " . $seo_ilan_oku->model;
	} elseif ($seo_ilan_profil == "Diğer") {
		$seo_baslik = "Kazalı araba ihaleleri " . $seo_ilan_oku->sehir . " " . $seo_marka . " " . $seo_ilan_oku->model;
	} else {
		$seo_baslik = "Pert &mdash; Dünyası";
	}
} elseif ($cekilecek == "dogrudan") {
	$seo_ilan_cek = mysql_query("select * from dogrudan_satisli_ilanlar where id = '" . $gelen_id . "'");
	$seo_ilan_oku = mysql_fetch_object($seo_ilan_cek);
	$seo_ilan_profil = $seo_ilan_oku->evrak_tipi;
	$goruntulenme_cek_first = mysql_query("select * from dogrudan_goruntulenme where ilan_id = '" . $gelen_id . "' and ip = '" . getIP() . "'");
	if (mysql_num_rows($goruntulenme_cek_first) == 0) {
		mysql_query("insert into dogrudan_goruntulenme (ilan_id,ip,tarih) values ('" . $gelen_id . "','" . getIP() . "','" . date('Y-m-d H:i:s') . "')");
	}
	if ($seo_ilan_profil == "Hurda Belgeli") {
		$seo_baslik = "Hurda Oto " . $seo_ilan_oku->sehir . " " . $seo_ilan_oku->marka . " " . $seo_ilan_oku->model;
	} elseif ($seo_ilan_profil == "Çekme Belgeli") {
		$seo_baslik = "Pert Araba " . $seo_ilan_oku->sehir . " " . $seo_ilan_oku->marka . " " . $seo_ilan_oku->model;
	} elseif ($seo_ilan_profil == "Çekme Belgeli/Pert Kayıtlı") {
		$seo_baslik = "Hasarlı Araçlar " . $seo_ilan_oku->sehir . " " . $seo_ilan_oku->marka . " " . $seo_ilan_oku->model;
	} elseif ($seo_ilan_profil == "Plakalı") {
		$seo_baslik = "Hasarlı Oto " . $seo_ilan_oku->sehir . " " . $seo_ilan_oku->marka . " " . $seo_ilan_oku->model;
	} elseif ($seo_ilan_profil == "Diğer") {
		$seo_baslik = "Kazalı araba ihaleleri " . $seo_ilan_oku->sehir . " " . $seo_ilan_oku->marka . " " . $seo_ilan_oku->model;
	} else {
		$seo_baslik = "Pert &mdash; Dünyası";
	}
}

if ($cekilecek == "ihale") {
	if ($uye_token != "") {
		$giris_uye_bul = mysql_query("SELECT * FROM user WHERE user_token = '" . $uye_token . "' or kurumsal_user_token='" . $uye_token . "' ");
		$giris_uye_yaz = mysql_fetch_assoc($giris_uye_bul);
		$giris_uye_id = $giris_uye_yaz['id'];
		$giris_uye_durumlari_cek = mysql_query("select * from uye_durumlari where uye_id='" . $giris_uye_id . "'");
		$giris_uye_durumlari_oku = mysql_fetch_assoc($giris_uye_durumlari_cek);
		$giris_uye_paket = $giris_uye_yaz['paket'];
		$giris_ilan_cek = mysql_query("select * from ilanlar where id = '" . $gelen_id . "'");
		$giris_ilan_oku = mysql_fetch_assoc($giris_ilan_cek);
		$sigorta_cek = mysql_query("SELECT * FROM sigortalar WHERE sigorta_id = '" . $giris_ilan_oku['sigorta'] . "' and paket_id='" . $giris_uye_paket . "'");
		$sigorta_oku = mysql_fetch_array($sigorta_cek);
		$secilen_yetki_id = $sigorta_oku['secilen_yetki_id'];
		if ($giris_ilan_oku['durum'] != "1") {
			if ($_SESSION['kid'] == "") {
				if ($secilen_yetki_id != "3") {
					echo "<script>alert('Bu sayfaya erişim yetkiniz yoktur')</script>";
					echo "<script>window.location.href = 'index.php'</script>";
				} else if ($giris_ilan_oku['sigorta'] == $giris_uye_durumlari_oku["yasakli_sigorta"]) {
					echo "<script>alert('Bu sayfaya erişim yetkiniz yoktur')</script>";
					echo "<script>window.location.href = 'index.php'</script>";
				} else {
					$kazanilmis_mi_cek = mysql_query("select * from kazanilan_ilanlar where ilan_id = '" . $gelen_id . "'");
					//$kazanilmis_mi_say = mysql_num_rows($kazanilmis_mi_cek);
					$kazanilmis_mi_oku = mysql_fetch_assoc($kazanilmis_mi_cek);
					if ($kazanilmis_mi_oku['uye_id'] != $giris_uye_id) {
						echo "<script>alert('Bu sayfaya erişim yetkiniz yoktur')</script>";
						echo "<script>window.location.href = 'index.php'</script>";
					}
				}
			}
		}
	} else {
		//Ziyaretçiyse
		$giris_uye_paket = 2; //Ziyaretçi paket_id=2
		$giris_ilan_cek = mysql_query("select * from ilanlar where id = '" . $gelen_id . "'");
		$giris_ilan_oku = mysql_fetch_assoc($giris_ilan_cek);
		$sigorta_cek = mysql_query("SELECT * FROM sigortalar WHERE sigorta_id = '" . $giris_ilan_oku['sigorta'] . "' and paket_id='" . $giris_uye_paket . "'");
		$sigorta_oku = mysql_fetch_array($sigorta_cek);
		$secilen_yetki_id = $sigorta_oku['secilen_yetki_id'];
		if ($_SESSION["kid"] == "") {
			if ($giris_ilan_oku['durum'] != "1") {
			}
			if ($secilen_yetki_id != "3") {
				echo "<script>alert('Bu sayfaya erişim yetkiniz yoktur..')</script>";
				echo "<script>window.location.href = 'index.php'</script>";
			} else {
				$kazanilmis_mi_cek = mysql_query("select * from kazanilan_ilanlar where ilan_id = '" . $gelen_id . "'");
				$kazanilmis_mi_say = mysql_num_rows($kazanilmis_mi_cek);
				if ($kazanilmis_mi_say != 0) {
					echo "<script>alert('Bu sayfaya erişim yetkiniz yoktur')</script>";
					echo "<script>window.location.href = 'index.php'</script>";
				}
			}
		}
	}
}else{
	$dogruyu_cek = mysql_query("select * from dogrudan_satisli_ilanlar where id = '".$gelen_id."'");
	$dogruyu_oku = mysql_fetch_object($dogruyu_cek);
	if($dogruyu_oku->bitis_tarihi < date('Y-m-d H:i:s')){
		if ($_SESSION["kid"] == "") {
			echo "<script>alert('İlan yayından kaldırılmış')</script>";
			echo "<script>window.location.href = 'index.php'</script>";
		}
	}
	
}

if($uye_token != ""){
	$arac_detay_uye_cek = mysql_query("select * from user where user_token = '".$uye_token."' or kurumsal_user_token = '".$uye_token."'");
	$arac_detay_uye_oku = mysql_fetch_object($arac_detay_uye_cek);
	$uye_id = $arac_detay_uye_oku->id;
	if($cekilecek == "ihale"){
		mysql_query("insert into gezilen_ilanlar(uye_id,ilan_id,add_time,status) values ('".$uye_id."','".$gelen_id."','".date('Y-m-d H:i:s')."',1)");
	}
}else{
	if($cekilecek == "ihale"){
		$ip_adresi = getIP();
		mysql_query("insert into gezilen_ilanlar(ip_adresi,ilan_id,add_time,status) values ('".$ip_adresi."','".$gelen_id."','".date('Y-m-d H:i:s')."',1)");
	}
}


/*
$giris_uye_bul = mysql_query("SELECT * FROM user WHERE user_token = '".$uye_token."'");
$giris_uye_yaz = mysql_fetch_assoc($giris_uye_bul);
$giris_uye_id=$giris_uye_yaz['uye_id'];
$giris_uye_durumlari_cek=mysql_query("select * from uye_durumlari where uye_id='".$giris_uye_id."'");
$giris_uye_durumlari_oku=mysql_fetch_assoc($giris_uye_durumlari_cek);
$giris_uye_paket = $giris_uye_yaz['paket'];
$giris_ilan_cek = mysql_query("select * from ilanlar where id = '".$gelen_id."'");
$giris_ilan_oku = mysql_fetch_assoc($giris_ilan_cek);
$sigorta_cek = mysql_query("SELECT * FROM sigortalar WHERE sigorta_id = '".$giris_ilan_oku['sigorta']."' and paket_id='".$giris_uye_paket ."'");
$sigorta_oku = mysql_fetch_array($sigorta_cek);
$secilen_yetki_id = $sigorta_oku['secilen_yetki_id'];
if($secilen_yetki_id != 3){
	echo "<script>alert('Bu sayfaya erişim yetkiniz yoktur')</script>";
	echo "<script>window.location.href = 'index.php'</script>";
}
if($giris_ilan_oku['sigorta']==$giris_uye_durumlari_oku["yasakli_sigorta"]){
	echo "<script>alert('Bu sayfaya erişim yetkiniz yoktur')</script>";
	echo "<script>window.location.href = 'index.php'</script>";
}
if($giris_ilan_oku['durum'] != 1){
	if($_SESSION['kid'] == ""){
		if($uye_token == ""){
			echo "<script>alert('Bu sayfaya erişim yetkiniz yoktur')</script>";
			echo "<script>window.location.href = 'index.php'</script>";
		}
		$giren_uye_kontrol = mysql_query("select * from user where user_token = '".$uye_token."' or kurumsal_user_token = '".$uye_token."'");
		$giren_uye_kontrol_sonuc = mysql_fetch_assoc($giren_uye_kontrol);
		$kazanilmis_mi_cek = mysql_query("select * from kazanilan_ilanlar where ilan_id = '".$gelen_id."'");
		$kazanilmis_mi_say = mysql_num_rows($kazanilmis_mi_cek);
		$kazanilmis_mi_oku = mysql_fetch_assoc($kazanilmis_mi_cek);
		if($kazanilmis_mi_say == 0 || $kazanilmis_mi_oku['uye_id'] != $giren_uye_kontrol_sonuc['id']){
			echo "<script>alert('Bu sayfaya erişim yetkiniz yoktur')</script>";
			echo "<script>window.location.href = 'index.php'</script>";
		}
	}
	// $giris_deneme = mysql_query("select * from kazanilan_ilanlar where ilan_id = '".$gelen_id."'");
	// $giris_deneme_oku = mysql_fetch_asoc($giris_deneme);
	// $giris_uye_cek = mysql_query("select * from user where user_token = '".$uye_token."' or kurumsal_user_token = '".$uye_token."'");
	// $giris_uye_oku = mysql_fetch_assoc($giris_uye_cek);
	// if($giris_deneme_oku['uye_id'] != $giris_uye_oku['id'] || $_SESSION['kid'] == ""){
	//    echo "<script>alert('Bu sayfaya erişim yetkiniz yoktur')</script>";
	//    echo "<script>window.location.href = 'index.php'</script>";
	// }
}
*/


$ilani_cek = mysql_query("SELECT * FROM ilanlar WHERE id = $gelen_id ");
$dogrudan_cek = mysql_query("SELECT * FROM dogrudan_satisli_ilanlar WHERE id = $gelen_id");
$favori = re('favori');
if ($favori == "toggle") {
	$getUserInfo = mysql_query("SELECT * FROM user WHERE user_token = '$uye_token' AND user_token <> '' ");
	if (mysql_num_rows($getUserInfo) == 1) {
		$userInfo = mysql_fetch_object($getUserInfo);
		// check is favorite 
		$checkIsFavorite = mysql_query("SELECT * FROM favoriler WHERE uye_id = '$userInfo->id' AND ilan_id = '$gelen_id'");
		if (mysql_num_rows($checkIsFavorite) == 1) {
			$favInfo = mysql_fetch_object($checkIsFavorite);
			mysql_query("DELETE FROM favoriler WHERE uye_id = '$userInfo->id' AND ilan_id = '$gelen_id'");
			echo '<script>alert("Favorilerinizden Kaldırıldı");</script>';
		} else {
			// mysql_query("INSERT INTO favoriler SET ilan_id = '$gelen_id',dogrudan_satisli_id = '0',uye_id = '$userInfo->id',favlama_zamani = NOW(),user_token = '$uye_token',kurumsal_token = '0'");
			mysql_query("insert into favorile(ilan_id,uye_id,favlama_zamani,user_token) values ('".$gelen_id."','".$userInfo->id."','".date('Y-m-d H:i:s')."','".$uye_token."')");
			echo '<script>alert("Favorilerinize Eklendi");</script>';
		}
	}
}
$a1 = $_SERVER['HTTP_USER_AGENT'];
$os        = getOS();
$browser   = getBrowser();
?>
<!doctype html>
<html lang="en">
<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
	<!-- <title>Pert &mdash; Dünyası</title> -->
	<title><?= $seo_baslik ?></title>
	<?php
	include 'seo_kelimeler.php';
	?>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link href="https://fonts.googleapis.com/css?family=DM+Sans:300,400,700&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="fonts/icomoon/style.css">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/bootstrap-datepicker.css">
	<link rel="stylesheet" href="css/jquery.fancybox.min.css">
	<!-- <link rel="stylesheet" href="css/owl.carousel.min.css"> -->
	<!-- <link rel="stylesheet" href="css/owl.theme.default.min.css"> -->
	<link rel="stylesheet" href="fonts/flaticon/font/flaticon.css">
	<link rel="stylesheet" href="css/aos.css">
	<!-- MAIN CSS -->
	<link rel="stylesheet" href="css/style.css?v=<?= time() ?>">
	<link rel="stylesheet" href="css/custom.css">
	<link rel="stylesheet" href="css/ihaledekiler.css">
	<link rel="stylesheet" type="text/css" href="js/toastr/toastr.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Raleway:200,100,400" rel="stylesheet" type="text/css" />
	<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/lightgallery/1.6.14/css/lightgallery.css'>
	<link rel="stylesheet" href="light_gallery/style.css?v=1">
	<link rel="stylesheet" href="css/arac_detay.css?v=<?= time() ?>">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.js"></script>
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/sharer.js@latest/sharer.min.js"></script>
</head>

<body onload="modalGonder()">
	<?php
	include 'modal.php';
	include 'alert.php';
	?>
	<?php include 'header.php'; ?>
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
				echo '<script>
						var htmlContent2 = document.createElement("div");
						htmlContent2.innerHTML = `'.$sitenin_acilis_popupu.'`;
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
					</script>';
			} else {
				echo '
					<script>
						var htmlContent2 = document.createElement("div");
						htmlContent2.innerHTML = `'.$sitenin_acilis_popupu.'`;
						swal( {
							buttons: false,
							showCancelButton: false,
							content:htmlContent2,
						})			
						.then((value) => {
							window.location.href = "hazirlaniyor.php";
						});
					</script>';
				$siteye_giren_guncelle = mysql_query("update siteye_girenler set tarih = '" . date('Y-m-d H:i:s') . "' where ip_adresi = '" . getIP() . "'");
			}
		} else {
			if ($site_acilis_popup_icin_oku['tarih'] < $siteye_giris_tarih_before) {
				if ($sitenin_acilis_popupunu_oku['buton'] == 1) {
					echo '<script>
							var htmlContent2 = document.createElement("div");
							htmlContent2.innerHTML = `'.$sitenin_acilis_popupu.'`;
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
				} else {
					echo '<script>
							var htmlContent2 = document.createElement("div");
							htmlContent2.innerHTML = `'.$sitenin_acilis_popupu.'`;
							swal( {
								buttons: false,
								showCancelButton: false,
								content:htmlContent2,
							})			
							.then((value) => {
								window.location.href = "hazirlaniyor.php";
							});
						</script>';
				}
			}
		}
	}

	$user_getir = mysql_fetch_object(mysql_query("select * from user where user_token='" . $uye_token . "' or kurumsal_user_token='" . $uye_token . "'"));
	$id_u = $user_getir->id;
	if ($cekilecek == "ihale") {
		$ihale_obj = mysql_fetch_object(mysql_query("SELECT * FROM ilanlar WHERE id = $gelen_id "));
		if ($ihale_obj->ihale_tarihi == date('Y-m-d') && $ihale_obj->ihale_saati <= date('H:i:s')) {
			$tklnma =  "disabled";
		}
		$kazanilan_ihl_durum = true;
		if ($ihale_obj->ihale_tarihi == date('Y-m-d') && $ihale_obj->ihale_saati <= date('H:i:s')) {
			$kazanilan_ihl_durum = false;
		} else {
			$kazanilan_sorgu = mysql_query("select * from kazanilan_ilanlar where ilan_id='" . $gelen_id . "'");
			if (mysql_num_rows($kazanilan_sorgu) == 1) {
				$kazanilan_ihl_durum = false;
			}
		}
		$ihl_mdl_y = $ihale_obj->model_yili;
		$ihl_mdl = $ihale_obj->model;
		$ihl_mrk = $ihale_obj->marka;
		$mrk_sql = mysql_fetch_object(mysql_query("select * from marka where markaID='" . $ihl_mrk . "'"));
		$ihl_mrk_adi = $mrk_sql->marka_adi;
		$ihl_sonteklif = $ihale_obj->son_teklif;
		$sgrt = mysql_fetch_object(mysql_query("select * from sigorta_ozellikleri where id='" . $ihale_obj->sigorta . "' "));
		$min = $sgrt->minumum_artis;
		$h1 = $sgrt->hizli_teklif_1;
		$h2 = $sgrt->hizli_teklif_2;
		$h3 = $sgrt->hizli_teklif_3;
		$h4 = $sgrt->hizli_teklif_4;
		$s_mesaj = $sgrt->teklif_iletme_mesaji;
		$tur = $ihale_obj->ihale_turu;
		$tbn_fiyat = $ihale_obj->acilis_fiyati;
		$sql_teklif = mysql_query("select * from teklifler where ilan_id='" . $gelen_id . "' and uye_id='" . $id_u . "' and durum=1 order by teklif_zamani desc ");
		$teklif_say = 0;
		$en_yksk = "";
		while ($row_teklif = mysql_fetch_object($sql_teklif)) {
			if ($kazanilan_ihl_durum == true) {
				if ($uye_token != "") {
					if ($row_teklif->teklif == $ihale_obj->son_teklif) {
						$en_yksk = ' <i style="color: green; text-align:center;">En yüksek teklif sizindir.</i><br/>
						<i style="color: red; text-align:center;">' . money($row_teklif->teklif) . ' ₺ teklif verdiniz.</i>
					';
					} else if ($row_teklif->teklif == "") {
						$en_yksk = '<i style="color: red; text-align:center;">Henüz teklif vermediniz.</i>';
					} else if ($row_teklif->teklif != $ihale_obj->son_teklif && $row_teklif->teklif != "" && $teklif_say == 0) {
						$en_yksk = '<i style="color: red; text-align:center;">' . money($row_teklif->teklif) . ' ₺ teklif verdiniz.</i>';
					}
					$teklif_say++;
				} else {
					$en_yksk = '';
				}
			}
		}
		if ($tur == 1) {    ?>
			<!-- Teklif Ver Modal Başlangıç -->
			<input type="hidden" id="ihale_tur" value="<?= $tur ?>" />
			<div class="modal fade" id="teklifVer" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="container">
							<form method="post">
								<div class="modal-header">
									<button style="margin-top: 1%; font-size:17px; font-weight:600;" type="button" class="btn btn-dark  btn-block" id="arac_bilgisi"><?= $ihl_mdl_y . " " . $ihl_mrk_adi . " " . $ihl_mdl ?></button>
									<button type="button" id="acik_modal_kapat" class="close" data-dismiss="modal" aria-label="Close">
										<span aria-hidden="true">&times;</span>
									</button>
								</div>
								<div class="modal-body">
									<div class="row">
										<div class="col">
											<p style="text-align: left; font-weight:550;">PD HİZMET BEDELİ</p>
											<button type="button" id="hizmet_bedel" class="btn btn-dark btn-block" style="font-weight:600; font-size:17px;"></button>
										</div>
										<div class="col">
											<p style="text-align: center; font-weight:550;">VERİLECEK TEKLİF</p>
											<button type="button" class="btn btn-dark btn-block" id="GelenTeklif" style="font-weight:600; font-size:17px; background-color: rgb(247, 148, 29);"> </button>
										</div>
									</div>
									<div class="row mt-3" style="display:none;">
										<div class="col">
											<p style="background-color: rgb(245, 245, 208); text-align:center;"> <br> AÇIK ARTTIRMA <br> <br> </p>
										</div>
										<div class="col">
										</div>
									</div>
									<div class="row mt-3" style="display:none;">
										<div id="modal_en_yuksek" class="col">
											<i style="color: green; text-align:center;"><?= $en_yksk ?></i>
										</div>
										<div class="col">
											<input style="margin-top:-10px;height:40px;" type="number" value="" step="<?= $min ?>" class="form-control" id="verilen_teklif">
										</div>
									</div>
									<div class="row mt-2" style="display:none;">
										<div class="col">
											<b style="color:blue;" id="GelenTeklif"></b> <b style=""> ₺ Teklif vermek üzeresiniz.</b> <br>
											<b> Hizmet Bedeli:</b> <span style="color:red;" id="hizmet_bedel"></span>
										</div>
									</div>
									<div class="row mt-2">
										<div class="col">
											<div onclick="popup('<?= $s_mesaj  ?>')" class="col">
												<textarea style="width:calc(100% + 30px); margin:15px -15px; min-height:250px;" name="" id="" rows="3" disabled placeholder="<?= $s_mesaj ?>"></textarea>
											</div>
										</div>
									</div>
									<div class="row mt-2">
										<div class="col">
											<input type="checkbox" id="sozlesme_kontrol<?= $ilani_oku['id'] ?>" value="1" required> <span onclick="popup('<?= $s_mesaj  ?>')">Yukarıdaki Koşulları Okudum ve Kabul Ediyorum.</span>
										</div>
									</div>
								</div>
								<div class="row mt-2 mb-2">
									<div class="col"><button type="button" id="acik_modal_kapat2" class="btn btn-danger btn-block" data-dismiss="modal">Vazgeç</button></div>
									<div class="col"><button type="button" class="btn btn-success btn-block" onclick="denem();"><i class="fas fa-lira-sign"> Teklif Ver</i></button></div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
			<!-- Teklif Ver Modal Bitiş -->
			<!-- Mesaj Yaz Modal Başlangıç -->
			<div class="modal fade" id="mesajYaz" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="container">
							<form method="POST">
								<div class="modal-body">
									<div class="row mt-2">
										<div class="col">
											<h6 style="text-align: center; font-size:10px;">Mesaj Yaz</h6>
										</div>
									</div>
									<div class="row mt-2">
										<div class="col">
											<label for="IDofInput">Mesaj</label>
											<textarea style="width:100%;" name="gonderilecek_mesaj" id="gonderilecek_mesaj" rows="3"></textarea>
										</div>
									</div>
									<div class="row mt-2">
										<div class="col">
											<button type="button" onclick="mesajGonder()" class="btn btn-dark btn-block">Gönder</button>
										</div>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
			<!-- Mesaj Yaz Modal Bitiş -->
			<div class="container" style="margin-top:11%;">
				<?php while ($ilani_oku = mysql_fetch_array($ilani_cek)) {
					if ($ilani_oku['profil'] == "Hurda Belgeli") {
						$blink = "blink";
					}
					$ilan_yil = $ilani_oku['model_yili']; ?>
					<input type="hidden" value="<?= $ilan_yil ?>" id="ilan_bilgisi">
					<?php
					// if ($ilani_oku['ihale_tarihi'] == date('Y-m-d') && $ilani_oku['ihale_saati'] < date('H:i:s')) {
					if ($ilani_oku['ihale_son_gosterilme'] == date('Y-m-d H:i:s')) {
						if ($_SESSION['u_token'] != "" && $_SESSION['k_token'] == "") {
							$kazanan_uye_cek = mysql_query("select * from user where user_token = '" . $_SESSION['u_token'] . "'");
							$kazanan_uye_oku = mysql_fetch_object($kazanan_uye_cek);
							$kazandigini_cek = mysql_query("SELECT * FROM kazanilan_ilanlar WHERE ilan_id = '" . $gelen_id . "' AND uye_id = '" . $kazanan_uye_oku->id . "'");
							$kazandigini_say = mysql_num_rows($kazandigini_cek);
							if ($kazandigini_say == 0) {
								echo "<script>alert('Bu sayfaya URL1 üzerinden erişim yetkiniz yok');</script>";
								echo "<script>window.location.href = 'index.php';</script>";
							}
						} elseif ($_SESSION['u_token'] == "" && $_SESSION['k_token'] != "") {
							$kazanan_uye_cek = mysql_query("select * from user where kurumsal_user_token = '" . $_SESSION['k_token'] . "'");
							$kazanan_uye_oku = mysql_fetch_object($kazanan_uye_cek);
							$kazandigini_cek = mysql_query("SELECT * FROM kazanilan_ilanlar WHERE ilan_id = '" . $gelen_id . "' AND uye_id = '" . $kazanan_uye_oku->id . "'");
							$kazandigini_say = mysql_num_rows($kazandigini_cek);
							if ($kazandigini_say == 0) {
								echo "<script>alert('Bu sayfaya UR2L üzerinden erişim yetkiniz yok');</script>";
								echo "<script>window.location.href = 'index.php';</script>";
							}
						} elseif ($_SESSION['u_token'] == "" && $_SESSION['k_token'] == "" && $_SESSION['kid'] == "") {
							echo "<script>alert('Bu sayfaya URL üzerinden erişim yetkiniz yok');</script>";
							echo "<script>window.location.href = 'index.php';</script>";
						}
					}
					if ($_SESSION['u_token'] != "" && $_SESSION['k_token'] == "") {
						$renkli_uye_bul = mysql_query("SELECT * FROM user WHERE user_token = '" . $_SESSION['u_token'] . "'");
						$renkli_uye_oku = mysql_fetch_assoc($renkli_uye_bul);
						$renkli_uye_id = $renkli_uye_oku['id'];
						$favli_mi = mysql_query("SELECT * FROM favoriler WHERE uye_id = '" . $renkli_uye_id . "' AND ilan_id = '" . $ilani_oku['id'] . "'");
						$favorili_say = mysql_num_rows($favli_mi);
						if ($favorili_say == 0) {
							$fav_color = "gray";
							$fav_title = "Araç favorilerinize eklenecektir.";
						} else {
							$fav_color = "orange";
							$fav_title = "Araç favorilerinizden kaldırılacaktır.";
						}
					} else if ($_SESSION['u_token'] == "" && $_SESSION['k_token'] != "") {
						$renkli_uye_bul = mysql_query("SELECT * FROM user WHERE kurumsal_user_token = '" . $_SESSION['k_token'] . "'");
						$renkli_uye_oku = mysql_fetch_assoc($renkli_uye_bul);
						$renkli_uye_id = $renkli_uye_oku['id'];
						$favli_mi = mysql_query("SELECT * FROM favoriler WHERE uye_id = '" . $renkli_uye_id . "' AND ilan_id = '" . $ilani_oku['id'] . "'");
						$favorili_say = mysql_num_rows($favli_mi);
						if ($favorili_say == 0) {
							$fav_color = "gray";
							$fav_title = "Araç favorilerinize eklenecektir.";
						} else {
							$fav_color = "orange";
							$fav_title = "Araç favorilerinizden kaldırılacaktır.";
						}
					} else {
						$fav_color = "gray";
						$fav_title = "Araç favorilerinize eklenecektir.";
					}
					if ($_SESSION['u_token'] != "" && $_SESSION['k_token'] == "") {
						$renkli_uye_bul = mysql_query("SELECT * FROM user WHERE user_token = '" . $_SESSION['u_token'] . "'");
						$renkli_uye_oku = mysql_fetch_assoc($renkli_uye_bul);
						$renkli_uye_id = $renkli_uye_oku['id'];
						$bildirimli_mi = mysql_query("SELECT * FROM bildirimler WHERE uye_id = '" . $renkli_uye_id . "' AND ilan_id = '" . $ilani_oku['id'] . "'");
						$bildirimli_say = mysql_num_rows($bildirimli_mi);
						if ($bildirimli_say == 0) {
							$bidlirim_color = "gray";
							$bildirim_title = "Araç bildirimleri açılacaktır.";
						} else {
							$bidlirim_color = "orange";
							$bildirim_title = "Araç bildirimleri kapatılacaklar.";
						}
					} else if ($_SESSION['u_token'] == "" && $_SESSION['k_token'] != "") {
						$renkli_uye_bul = mysql_query("SELECT * FROM user WHERE kurumsal_user_token = '" . $_SESSION['k_token'] . "'");
						$renkli_uye_oku = mysql_fetch_assoc($renkli_uye_bul);
						$renkli_uye_id = $renkli_uye_oku['id'];
						$bildirimli_mi = mysql_query("SELECT * FROM bildirimler WHERE uye_id = '" . $renkli_uye_id . "' AND ilan_id = '" . $ilani_oku['id'] . "'");
						$bildirimli_say = mysql_num_rows($bildirimli_mi);
						if ($bildirimli_say == 0) {
							$bidlirim_color = "gray";
							$bildirim_title = "Araç bildirimleri açılacaktır.";
						} else {
							$bidlirim_color = "orange";
							$bildirim_title = "Araç bildirimleri kapatılacaklar.";
						}
					} else {
						$bidlirim_color = "gray";
						$bildirim_title = "Araç bildirimleri açılacaktır.";
					}
					$ihale_turu = $ilani_oku['ihale_turu'];
					if ($ihale_turu == 1) {
						$ihale_turu_yaz = "Açık İhale";
					} elseif ($ihale_turu == 2) {
						$ihale_turu_yaz = "Kapalı İhale";
					}
					$ihaleID = $ilani_oku['id'];
					$ihale_marka = $ilani_oku['marka'];
					$ihale_sehir = $ilani_oku['sehir'];
					$son_teklif_cek = mysql_query("SELECT * FROM ilanlar WHERE id='" . $ihaleID . "'");
					$ilan_resim_cek = mysql_query("SELECT * FROM ilan_resimler WHERE ilan_id = '" . $ihaleID . "' ");
					$ilan_resim_cek2 = mysql_query("SELECT * FROM ilan_resimler WHERE ilan_id = '" . $ihaleID . "' ");
					$ilan_resim_sayisi = mysql_num_rows($ilan_resim_cek);
					$marka_cek = mysql_query("SELECT * FROM marka WHERE markaID='" . $ihale_marka . "' LIMIT 1");
					$marka_cek2 = mysql_query("SELECT * FROM marka WHERE markaID='" . $ihale_marka . "' LIMIT 1");
					$marka_oku2 = mysql_Fetch_assoc($marka_cek2);
					$marka_adi2 = $marka_oku2['marka_adi'];
					$sehir_cek = mysql_query("SELECT * FROM sehir WHERE sehirID = '" . $ihale_sehir . "' LIMIT 1");
					$sehir = mysql_fetch_array($sehir_cek);
					$komisyon_cek = mysql_query("SELECT * FROM ilan_komisyon WHERE ilan_id = '" . $ihaleID . "'");
					$komisyon_oku = mysql_fetch_assoc($komisyon_cek);
					$komisyon = $komisyon_oku['toplam'];
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
					<?php
					// Sigorta Şirketine göre belirlenen dakikanın altında teklif gelirse süre
					// otomatik olarak şirketin belirlenen ayarlarındaki dakika kadar artar
					$sigorta_bul = mysql_query("SELECT * FROM sigorta_ozellikleri WHERE id = '" . $ilani_oku['sigorta'] . "'");
					$sigorta_oku = mysql_fetch_assoc($sigorta_bul);
					$hizli1 = $sigorta_oku['hizli_teklif_1'];
					$hizli2 = $sigorta_oku['hizli_teklif_2'];
					$hizli3 = $sigorta_oku['hizli_teklif_3'];
					$hizli4 = $sigorta_oku['hizli_teklif_4'];
					$min_arti = $sigorta_oku['minumum_artis'];
					$sigorta_notu = $sigorta_oku['uyari_notu'];
					$dakika_altinda = $sigorta_oku['dakikanin_altinda'];
					$dakika_uzar = $sigorta_oku['dakika_uzar'];
					$ihalenin_saati = $ilani_oku['ihale_saati'];
					$pd_hizmeti = $sigorta_oku['pd_hizmeti'];
					$bugun = date('Y-m-d');
					$ihale_zaman = $ilani_oku['ihale_tarihi'] . " " . $ilani_oku['ihale_saati'];
					$yeni_ihale_saati =  date('H:i:s', strtotime('+' . $dakika_uzar . ' minutes', strtotime($ihalenin_saati)));
					$teklif_zaman_kontrol =  date('H:i:s', strtotime('-' . $dakika_uzar . ' minutes', strtotime($ihalenin_saati)));
					$teklif_zaman_son_kontrol = $bugun . " " . $teklif_zaman_kontrol;
					$teklif_zaman_cek = mysql_query("SELECT * FROM teklifler WHERE ilan_id = '" . $ilani_oku['id'] . "' and durum=1 ORDER BY teklif_zamani DESC LIMIT 1");
					$teklif_zaman_oku = mysql_fetch_assoc($teklif_zaman_cek);
					$teklif_zamani = $teklif_zaman_oku['teklif_zamani'];
					/*if($ilani_oku['ihale_tarihi']==$bugun && $teklif_zamani > $teklif_zaman_son_kontrol && $teklif_zamani < $ihale_zaman){
						mysql_query("UPDATE ilanlar SET ihale_saati = '".$yeni_ihale_saati."' WHERE id = '".$ihaleID."'");
					}*/
					?>
					<?php
					if (isset($_POST['favla'])) {
						$date = date('Y-m-d H:i:s');
						$id = $_POST['favlanacak'];
						if ($_SESSION['u_token'] != "" && $_SESSION['k_token'] == "") {
							$favi_cek = mysql_query("SELECT * FROM user WHERE user_token = '" . $uye_token . "'");
							while ($favi_oku = mysql_fetch_array($favi_cek)) {
								$uyeninID = $favi_oku['id'];
								$favlamismi_cek = mysql_query("SELECT * FROM favoriler WHERE ilan_id = '" . $id . "' AND uye_id = '" . $uyeninID . "'");
								$favlamismi_sayi = mysql_num_rows($favlamismi_cek);
								if ($favlamismi_sayi == 0) {
									mysql_query("INSERT INTO `favoriler` (`id`, `ilan_id`, `dogrudan_satisli_id`, `uye_id`, `favlama_zamani`, `user_token`, `kurumsal_token`) VALUES 
									(NULL, '" . $id . "', '', '" . $uyeninID . "', '" . $date . "', '" . $uye_token . "', '');");
									echo '<script> alert("İlan Favorilerinize Eklendi")</script>';
									echo '<script> window.location.href = "arac_detay.php?id=' . $id . '&q=ihale&";</script>';
								} else {
									mysql_query("DELETE FROM favoriler WHERE ilan_id = '" . $id . "' AND uye_id = '" . $uyeninID . "'");
									echo '<script> alert("İlan Favorilerinizden Kaldırıldı")</script>';
									echo '<script> window.location.href = "arac_detay.php?id=' . $id . '&q=ihale&";</script>';
								}
							}
						} elseif ($_SESSION['u_token'] == "" && $_SESSION['k_token'] != "") {
							$favi_cek = mysql_query("SELECT * FROM user WHERE kurumsal_user_token = '" . $uye_token . "'");
							while ($favi_oku = mysql_fetch_array($favi_cek)) {
								$uyeninID = $favi_oku['id'];
								$favlamismi_cek = mysql_query("SELECT * FROM favoriler WHERE ilan_id = '" . $id . "' AND uye_id = '" . $uyeninID . "'");
								$favlamismi_sayi = mysql_num_rows($favlamismi_cek);
								if ($favlamismi_sayi == 0) {
									mysql_query("INSERT INTO `favoriler` (`id`, `ilan_id`, `dogrudan_satisli_id`, `uye_id`, `favlama_zamani`, `user_token`, `kurumsal_token`) VALUES 
									(NULL, '" . $id . "', '', '" . $uyeninID . "', '" . $date . "', '', '" . $uye_token . "');");
									echo '<script> alert("İlan Favorilerinize Eklendi")</script>';
									echo '<script> window.location.href = "arac_detay.php?id=' . $id . '&q=ihale&";</script>';
								} else {
									mysql_query("DELETE FROM favoriler WHERE ilan_id = '" . $id . "' AND uye_id = '" . $uyeninID . "'");
									echo '<script> alert("İlan Favorilerinizden Kaldırıldı")</script>';
									echo '<script> window.location.href = "arac_detay.php?id=' . $id . '&q=ihale&";</script>';
								}
							}
						}
					}
					if (isset($_POST['bildirim_ac'])) {
						$date = date('Y-m-d H:i:s');
						$id = $_POST['bildirimlenecek'];
						if ($_SESSION['u_token'] != "" && $_SESSION['k_token'] == "") {
							$bildirim_cek = mysql_query("SELECT * FROM user WHERE user_token = '" . $uye_token . "'");
							while ($bildirim_oku = mysql_fetch_array($bildirim_cek)) {
								$uyeninID = $bildirim_oku['id'];
								$bildirim_varmi = mysql_query("SELECT * FROM bildirimler WHERE ilan_id = '" . $id . "' AND uye_id = '" . $uyeninID . "'");
								$bildirimini_say = mysql_num_rows($bildirim_varmi);
								if ($bildirimini_say == 0) {
									mysql_query("INSERT INTO `bildirimler` (`id`, `ilan_id`, `dogrudan_satisli_id`, `uye_id`, `bildirim_zamani`, `user_token`, `kurumsal_token`) VALUES 
									(NULL, '" . $id . "', '', '" . $uyeninID . "', '" . $date . "', '" . $uye_token . "', '');");
									echo '<script> alert("Bildirimler açıldı");</script>';
									echo '<script> window.location.href = "arac_detay.php?id=' . $id . '&q=ihale&";</script>';
								} else {
									mysql_query("DELETE FROM bildirimler WHERE ilan_id = '" . $id . "' AND uye_id = '" . $uyeninID . "'");
									echo '<script> alert("Bildirimler kapatıldı");</script>';
									echo '<script> window.location.href = "arac_detay.php?id=' . $id . '&q=ihale&";</script>';
								}
							}
						} elseif ($_SESSION['u_token'] == "" && $_SESSION['k_token'] != "") {
							$bildirim_cek = mysql_query("SELECT * FROM user WHERE kurumsal_user_token = '" . $uye_token . "'");
							while ($bildirim_oku = mysql_fetch_array($bildirim_cek)) {
								$uyeninID = $bildirim_oku['id'];
								$bildirim_varmi = mysql_query("SELECT * FROM bildirimler WHERE ilan_id = '" . $id . "' AND uye_id = '" . $uyeninID . "'");
								$bildirimini_say = mysql_num_rows($bildirim_varmi);
								if ($bildirimini_say == 0) {
									mysql_query("INSERT INTO `bildirimler` (`id`, `ilan_id`, `dogrudan_satisli_id`, `uye_id`, `bildirim_zamani`, `user_token`, `kurumsal_token`) VALUES 
									(NULL, '" . $id . "', '', '" . $uyeninID . "', '" . $date . "', '" . $uye_token . "', '');");
									echo '<script> alert("Bildirimler açıldı")</script>';
									echo '<script> window.location.href = "arac_detay.php?id=' . $id . '&q=ihale&";</script>';
								} else {
									mysql_query("DELETE FROM bildirimler WHERE ilan_id = '" . $id . "' AND uye_id = '" . $uyeninID . "'");
									echo '<script> alert("Bildirimler kapatıldı")</script>';
									echo '<script> window.location.href = "arac_detay.php?id=' . $id . '&q=ihale&";</script>';
								}
							}
						}
					}
					?>
					<input type="hidden" id="ilanID" value="<?= $ilani_oku['id'] ?>">
					<input type="hidden" id="ihaleSahibi" value="<?= $ilani_oku['ihale_sahibi'] ?>">
					<input type="hidden" id="ilan_komisyon" value="<?= $komisyon ?>">
					<div class="btn-group mr-2" role="group" aria-label="Basic example" style="display:none;">
						<button type="button" class="btn kucuk kapanis_zamani"><?= date("d-m-Y", strtotime($ilani_oku["ihale_tarihi"])) . " " . $ilani_oku["ihale_saati"] ?></button>
					</div>
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 car_detail_top">
						<span style="display:<?php if ($ilani_oku["plaka"] == "") {echo ('none');} ?>">Plaka : <b><?= $ilani_oku["plaka"] ?></b></span>
						<span style="display:<?php if ($ilani_oku["arac_kodu"] == "") {echo ('none');} ?>">Araç Kodu : <b>#<?= $ilani_oku['arac_kodu'] ?></b></span>
						<span style="display:<?php if ($ilani_oku['tsrsb_degeri'] == "") {echo ('none');} ?>">TSRSB Değeri : <b style="color:#000;"> <?= money($ilani_oku["tsrsb_degeri"]) ?>₺</b></span>
						<a data-toggle="tooltip" data-placement="top" title="Benzer ilanlara buradan ulaşabilirsiniz." target="_blank" href="https://www.sahibinden.com/vasita?query_text_mf=<?= $ilani_oku['model_yili'] ?>+<?= $marka_adi2 ?>+<?= $ilani_oku['model'] ?>&query_text=<?= $ilani_oku['model_yili'] ?>+<?= $marka_adi2 ?>+<?= $ilani_oku['model'] ?>">
							<div class="car_detail_top_btn" style="background-image:url('assets/sahibinden_logo2.png'); margin-left:15px;"></div>
						</a>
						<div class="car_detail_top_btn" onclick="bildirim_ac(<?= $ilani_oku['id'] ?>)" data-toggle="tooltip" data-placement="top" title="<?= $bildirim_title ?>" id="bildirim_ac_<?= $ilani_oku['id'] ?>">
							<i style="color: <?= $bidlirim_color ?>;" class="fas fa-bell"></i>
							<input type="hidden" name="bildirimlenecek" value="<?= $ilani_oku['id'] ?>">
						</div>
						<div class="car_detail_top_btn" onclick="favla(<?= $ilani_oku['id'] ?>)" data-toggle="tooltip" data-placement="top" title="<?= $fav_title ?>" id="favla_<?= $ilani_oku['id'] ?>">
							<i style="color: <?= $fav_color ?>;" class="fas fa-star"></i>
							<input type="hidden" name="favlanacak" value="<?= $ilani_oku['id'] ?>">
						</div>
					</div>
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 car_detail_top_info" style="display:<?php if ($ilani_oku['uyari_notu'] != "" || $sigorta_notu != "") {echo 'block';} else {echo 'none';} ?>">
						<?= $ilani_oku['uyari_notu'] . " " . $sigorta_notu; ?>
					</div>
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 car_detail_title">
						<i class="fas fa-car"></i> <?= $ilani_oku["model_yili"] . " " . $marka_adi2 . " " . $ilani_oku["model"] . " " . $ilani_oku["tip"] ?>
					</div>
					<?php
					$image_list = array();
					while ($ilan_resim_oku = mysql_fetch_array($ilan_resim_cek)) {
						array_push($image_list, $ilan_resim_oku['resim']);
					}
					$mini_images = '';
					$say = 0;
					for ($i = 0; $i <= count($image_list); $i++) {
						if ($image_list[$i] != "") {
							$selected = '';
							if ($say == 0) {
								$selected = 'car_select_image';
							}
							$mini_images .= '<div class="car_detail_mini_images_box">
								<div class="car_detail_mini_images ' . $selected . '" style="background-image:url(\'images/' . $image_list[$i] . '\')" id="car_mini_image' . $i . '" onclick="carDetailImage(' . $i . ',\'' . $image_list[$i] . '\')"></div>
							</div>';
							$lightgallery_images .= '<a href="images/' . $image_list[$i] . '" data-lg-size="1600-2400" id="galleryImage' . $i . '">
								<img src="images/' . $image_list[$i] . '" />
							</a>';
							$say++;
						}
					}
					?>
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 car_detail_content_outer">
						<div class="col-xs-12 col-sm-12 col-md-7 col-lg-7 car_detail_images_outer">
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mh10p5">
								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 card_detail_big_image">
									<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 card_detail_big_image" id="car_detail_big_image" style="background-image:url('images/<?php echo $image_list[0]; ?>')" onclick="openGallery()">
									</div>
									<div class="car_detail_image_arrows" onclick="carSliderPrev()">
										<i class="fas fa-chevron-left"></i>
									</div>
									<div class="car_detail_image_arrows" onclick="carSliderNext()">
										<i class="fas fa-chevron-right"></i>
									</div>
								</div>
							</div>
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 car_detail_mini_images_outer">
								<input type="hidden" id="carDetailSelectImage" value="0" />
								<input type="hidden" id="carDetailImageCount" value="<?php echo $say; ?>" />
								<?php echo $mini_images; ?>
							</div>
							<?php
							$iln_sigorta = mysql_query("select * from sigorta_ozellikleri where id='" . $ilani_oku["sigorta"] . "'");
							$iln_sigorta_listele = mysql_fetch_object($iln_sigorta);
							$sigorta_uyari = $iln_sigorta_listele->uyari_notu;
							$onemli_metin_cek = mysql_query("select * from arac_detay_onemli_metni order by id desc limit 1");
							$onemli_metin_oku = mysql_fetch_object($onemli_metin_cek);
							$onemli_metin = $onemli_metin_oku->metin;
							?>
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mh10p5" style="margin-top:15px;">
								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 car_detail_content_box" style="border-top:1px solid #ededed;">
									<?= $onemli_metin ?>
								</div>
							</div>
						</div>
						<div class="col-xs-12 col-sm-12 col-md-5 col-lg-5 car_detail_text_outer">
							<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 mh10p5">
								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 car_detail_mini_text">
									Kalan Zaman
								</div>
								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 car_detail_button" id="sayac">
									<i class="fas fa-clock"></i>
								</div>
								<input type="hidden" id="ihale_sayac" value="<?= $ilani_oku['ihale_tarihi'] . ' ' . $ilani_oku['ihale_saati'] ?>">
								<input type="hidden" id="sure_uzatilma_durum" value="<?= $ilani_oku['sistem_sure_uzatma_durumu'] ?>">
								<input type="hidden" id="belirlenen" value="<?= $sigorta_oku['bu_sure_altinda_teklif'] ?>">
								<input type="hidden" id="ihale_id" value="<?= $ilani_oku['id'] ?>">
								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 car_detail_button">
									<i class="fas fa-gavel"></i>
									<?php if ($kazanilan_ihl_durum == true) { ?>
										<input type="hidden" id="acilis_fiyati" value="<?= $ilani_oku['acilis_fiyati'] ?>" />
									<?php } else { ?>
										<input type="hidden" id="acilis_fiyati" value="" />
									<?php } ?>
									<?= $ihale_turu_yaz ?>
								</div>
								<?php if ($ilani_oku['ihale_tarihi'] == date('Y-m-d') && $ilani_oku['ihale_saati'] <= date('H:i:s')) {
									$tiklanma =  "disabled";
								} ?>
								<?php if($uye_token != ""){ ?>
								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 car_detail_button" <?= $tiklanma ?> onclick="kontrol()" id="mesajGonder" data-toggle="modal" data-target="#mesajYaz" style="cursor: pointer;">
									<i class="fas fa-envelope"></i> Mesaj Yaz
								</div>
								<?php }else{ ?>
									<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 car_detail_button" <?= $tiklanma ?> onclick="alert('Devam Etmek İçin Lütfen Giriş Yapın !')" style="cursor: pointer;">
										<i class="fas fa-envelope"></i> Mesaj Yaz
									</div>
								<?php } ?>
							</div>
							<?php while ($son_teklif_oku = mysql_fetch_array($son_teklif_cek)) {
								$enyuksek = $son_teklif_oku["son_teklif"];
								if ($uye_token == $token) {
									$kim_cek = mysql_query("SELECT * FROM teklifler WHERE user_token = '" . $uye_token . "' AND ilan_id = '" . $gelen_id . "' and durum=1 ORDER BY teklif_zamani DESC LIMIT 1");
								} elseif ($uye_token == $k_token) {
									$kim_cek = mysql_query("SELECT * FROM teklifler WHERE kurumsal_token = '" . $uye_token . "' AND ilan_id = '" . $gelen_id . "' and durum=1 ORDER BY teklif_zamani DESC LIMIT 1");
								}
								if (mysql_num_rows($kim_cek) != 0) {
									if ($uye_token != "") {
										while ($kim_oku = mysql_fetch_array($kim_cek)) {
											if ($kim_oku['teklif'] == $enyuksek) {
												$display = "block";
												if ($ilani_oku["ihale_turu"] == 1) {
													$mesaj = "En yüksek teklif sizin";
												} else {
													$mesaj = "";
												}
												$renk = "green";
												$mesaj2 = money($kim_oku['teklif']) . " ₺ teklif verdiniz.";
												$renk2 = "red";
											} else if ($kim_oku['teklif'] > 0) {
												$display = "block";
												$mesaj2 = money($kim_oku['teklif']) . " ₺ teklif verdiniz.";
												$renk = "red";
												$renk2 = "red";
											} else {
												$display = "none";
											}
										}
									} else {
										$mesaj = "";
										$mesaj2 = "";
									}
								} else {
									$display = "none";
								}
							?>
								<?php if ($kazanilan_ihl_durum == true) { ?>
									<?php
									$bitis_tarihi = $ilani_oku["ihale_tarihi"] . " " . $ilani_oku["ihale_saati"];
									$ihale_son_str = strtotime($bitis_tarihi);
									$suan_str = strtotime(date("Y-m-d H:i:s"));
									$sonuc = ($ihale_son_str - $suan_str) / 60;
									if ($sonuc < 30) {
										if ($kullanici_grubu == 1) {
											if ($enyuksek == 0) {
												$en_yuksek_teklif_area = '<button class="col-xs-12 col-sm-12 col-md-12 col-lg-12 car_detail_button" id="sonTeklif" value="' . $enyuksek . '" style="margin:0px; background-color:#ff7f27;cursor: default;">
													' . money($ilani_oku['acilis_fiyati']) . ' ₺
												</button>';
									?>
											<?php } else {
												$en_yuksek_teklif_area = '<button class="col-xs-12 col-sm-12 col-md-12 col-lg-12 car_detail_button" id="sonTeklif" value="' . $enyuksek . '" style="margin:0px; background-color:#ff7f27;cursor: default;">
													' . money($enyuksek) . ' ₺
												</button>';
											?>
											<?php } ?>
										<?php } else {
											$en_yuksek_teklif_area = '<button class="col-xs-12 col-sm-12 col-md-12 col-lg-12 car_detail_button" id="sonTeklif" value="' . $enyuksek . '" style="margin:0px; background-color:#ff7f27;cursor: default;">
												<i style="color:#000" class="fas fa-lock"></i>
											</button>';
										?>
										<?php } ?>
										<?php } else {
										if ($kullanici_grubu == 1 || $kullanici_grubu == 4 || $kullanici_grubu == 0) {
											if ($enyuksek == 0) {
												$en_yuksek_teklif_area = '<button class="col-xs-12 col-sm-12 col-md-12 col-lg-12 car_detail_button" id="sonTeklif" value="' . $enyuksek . '" style="margin:0px; background-color:#ff7f27;cursor: default;">
													' . money($ilani_oku['acilis_fiyati']) . ' ₺
												</button>';
										?>
											<?php } else {
												$en_yuksek_teklif_area = '<button class="col-xs-12 col-sm-12 col-md-12 col-lg-12 car_detail_button" id="sonTeklif" value="' . $enyuksek . '" style="margin:0px; background-color:#ff7f27;cursor: default;">
													' . money($enyuksek) . ' ₺
												</button>';
											?>
											<?php } ?>
										<?php } else {
											$en_yuksek_teklif_area = '<button class="col-xs-12 col-sm-12 col-md-12 col-lg-12 car_detail_button" id="sonTeklif" value="' . $enyuksek . '" style="margin:0px; background-color:#ff7f27;cursor: default;">
												<i style="color:#000" class="fas fa-lock"></i>
											</button>';
										?>
										<?php } ?>
									<?php }
									?>
								<?php } else {
									if ($kullanici_grubu == 1) {
										if ($enyuksek == 0) {
											$en_yuksek_teklif_area = '<button class="col-xs-12 col-sm-12 col-md-12 col-lg-12 car_detail_button" id="sonTeklif" value="' . $enyuksek . '" style="margin:0px; background-color:#ff7f27;cursor: default;">
												' . money($ilani_oku['acilis_fiyati']) . ' ₺
											</button>';
										} else {
											$en_yuksek_teklif_area = '<button class="col-xs-12 col-sm-12 col-md-12 col-lg-12 car_detail_button" id="sonTeklif" value="' . $enyuksek . '" style="margin:0px; background-color:#ff7f27;cursor: default;">
												' . money($enyuksek) . ' ₺
											</button>';
										}
									} else {
										$en_yuksek_teklif_area = '<button class="col-xs-12 col-sm-12 col-md-12 col-lg-12 car_detail_button" id="sonTeklif" value="' . $enyuksek . '" style="margin:0px; background-color:#ff7f27;cursor: default;">
											<i style="color:#000" class="fas fa-lock"></i>
										</button>';
									}
									/* 15.04.2022 isimli word dosyasının 4.maddesi için aşağıdaki alan yukarıdaki if-else bloğu ile değiştirilmiştir */
									// 	$en_yuksek_teklif_area = '<button class="col-xs-12 col-sm-12 col-md-12 col-lg-12 car_detail_button" id="sonTeklif" value="" style="margin:0px; background-color:#ff7f27;">
									// 	XXX ₺
									// </button>';								
								?>
							<?php }
							} ?>
							<?php
							if ($ilani_oku['pd_hizmet'] == "" || $ilani_oku['pd_hizmet'] == 0) {
								if ($ilani_oku['ihale_turu'] == 1) {
									$uye_teklif_cek = mysql_query("select * from teklifler where ilan_id='" . $ilani_oku['id'] . "' and durum=1 order by teklif_zamani DESC limit 1  ");
									$uye_teklif_oku = mysql_fetch_object($uye_teklif_cek);
									if (mysql_num_rows($uye_teklif_cek) == 0) {
										$sigorta_pd_first = baslangic_komisyon($ilani_oku["id"], $ilani_oku["acilis_fiyati"]);
										$sigorta_pd = money($sigorta_pd_first) . " ₺ " . "(Teklifinize göre hesaplanacak)";
									} else {
										$sigorta_pd = money($uye_teklif_oku->hizmet_bedeli) . " ₺" . "(Teklifinize göre hesaplanacak)";
									}
								} else {
									$uye_teklif_cek = mysql_query("select * from teklifler where ilan_id='" . $ilani_oku['id'] . "' and uye_id='" . $id_u . "' and durum=1 order by teklif_zamani DESC limit 1 ");
									$uye_teklif_oku = mysql_fetch_object($uye_teklif_cek);
									if (mysql_num_rows($uye_teklif_cek) == 0) {
										$sigorta_pd_first = baslangic_komisyon($ilani_oku["id"], $ilani_oku["acilis_fiyati"]);
										// $sigorta_pd=money($sigorta_pd_first)." ₺ "."(Teklifinize göre hesaplanacak)";
										$sigorta_pd = "Teklifinize göre hesaplanacak";
									} else {
										$sigorta_pd = money($uye_teklif_oku->hizmet_bedeli) . " ₺" . "(Teklifinize göre hesaplanacak)";
									}
								}
							} else {
								$sigorta_pd = money($ilani_oku['pd_hizmet']) . " ₺" . "(Teklifinize göre hesaplanacak)";
							}
							//$sigorta_park_ucreti=$iln_sigorta_listele->park_ucreti;
							$sigorta_park_ucreti = $ilani_oku['otopark_ucreti'];
							$sigorta_park_giris = $ilani_oku['otopark_giris'];
							if ($sigorta_park_giris != "0000-00-00" && $sigorta_park_giris != "") {
								$park_giris = " [" . date("d-m-Y", strtotime($sigorta_park_giris)) . " ] ";
							} else {
								$park_giris = "";
							}
							//$sigorta_dosya_masrafi=$iln_sigorta_listele->sigorta_dosya_masrafi;
							$sigorta_dosya_masrafi = $ilani_oku['dosya_masrafi'];
							$noter_sorgu = mysql_query("select * from odeme_mesaji");
							$noter_listele = mysql_fetch_object($noter_sorgu);
							if ($ilani_oku['profil'] == "Hurda Belgeli") {
								$noter_ucreti = "Noter devri esnasında hesaplanacak";
							} else {
								$noter_ucreti = money($noter_listele->noter_takipci_gideri) . " ₺";
							}
							$sigorta_aciklama = $iln_sigorta_listele->sigorta_aciklamasi;
							$getNot = $ilani_oku['notlar'];
							$getHasar = $ilani_oku['hasar_bilgileri'];
							//$getAciklama = $ilani_oku['uyari_notu'];
							$setNot = htmlspecialchars($getNot);
							$setHasar = strip_tags($getHasar);
							$setAciklama = strip_tags($sigorta_aciklama);
							?>
							<?php
							$son_cek = mysql_query("select * from kazanilan_ilanlar where ilan_id = '".$gelen_id."'");
							$son_oku = mysql_fetch_object($son_cek);
							if ($son_oku->durum == 1 || $son_oku->durum == 2 || $son_oku->durum == 3) {
								$son_html = '<h3 id="en_yuksek_mesaj2" style="color: ' . $renk . ';">' . $mesaj . '</h3>';
								$en_yuksek_teklif_area = '<button class="col-xs-12 col-sm-12 col-md-12 col-lg-12 car_detail_button" id="sonTeklif" value="' . $enyuksek . '" style="margin:0px; background-color:#ff7f27;cursor: default;">
									<i style="color:#000" class="fas fa-lock"></i>
								</button>';
							} else {
								$son_html = '<h3 id="en_yuksek_mesaj" style="color: '.$renk.';">'.$mesaj.'</h3>
								<h3 id="en_yuksek_mesaj2" style="color: '.$renk2.';">'.$mesaj2.'</h3>';
							}
							?>
							<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 mh10p5" style="padding:0px;">
								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mh10p5">
									<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 car_detail_mini_text">
										En Yüksek Teklif
									</div>
									<?= $en_yuksek_teklif_area ?>
								</div>
								<?php if($uye_token != ""){ ?>
								<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 mh10p5" style="padding: 0px 5px 3px 5px !important;">
									<button type="button" data-toggle="modal" data-target="#teklifVer" data-keyboard="false" data-backdrop="static" onclick="buttonClick(); kontrol(); degerOku();" id="arti1" value="<?= $hizli1 ?>" <?= $tiklanma ?> class="col-xs-12 col-sm-12 col-md-12 col-lg-12 car_detail_button">+<?= money($hizli1) ?>₺</button>
								</div>
								<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 mh10p5" style="padding: 0px 5px 3px 5px !important;">
									<button type="button" data-toggle="modal" data-target="#teklifVer" data-keyboard="false" data-backdrop="static" onclick="clickButton(); kontrol(); degerOku();" id="arti3" value="<?= $hizli3 ?>" <?= $tiklanma ?> class="col-xs-12 col-sm-12 col-md-12 col-lg-12 car_detail_button">+<?= money($hizli3) ?>₺</button>
								</div>
								<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 mh10p5" style="padding: 0px 5px 3px 5px !important;">
									<button type="button" data-toggle="modal" data-target="#teklifVer" data-keyboard="false" data-backdrop="static" onclick="buttonClick2(); kontrol(); degerOku();" id="arti2" value="<?= $hizli2 ?>" <?= $tiklanma ?> class="col-xs-12 col-sm-12 col-md-12 col-lg-12 car_detail_button">+<?= money($hizli2) ?>₺</button>
								</div>
								<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 mh10p5" style="padding: 0px 5px 3px 5px !important;">
									<button type="button" data-toggle="modal" data-target="#teklifVer" data-keyboard="false" data-backdrop="static" onclick="clickButton2(); kontrol(); degerOku();" id="arti4" value="<?= $hizli4 ?>" <?= $tiklanma ?> class="col-xs-12 col-sm-12 col-md-12 col-lg-12 car_detail_button">+<?= money($hizli4) ?>₺</button>
								</div>
								<?php }else{ ?>
								<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 mh10p5" style="padding: 0px 5px 3px 5px !important;">
									<button type="button" onclick="alert('Devam Etmek İçin Lütfen Giriş Yapın !')" id="arti1" value="<?= $hizli1 ?>" <?= $tiklanma ?> class="col-xs-12 col-sm-12 col-md-12 col-lg-12 car_detail_button">+<?= money($hizli1) ?>₺</button>
								</div>
								<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 mh10p5" style="padding: 0px 5px 3px 5px !important;">
									<button type="button" onclick="alert('Devam Etmek İçin Lütfen Giriş Yapın !')" id="arti3" value="<?= $hizli3 ?>" <?= $tiklanma ?> class="col-xs-12 col-sm-12 col-md-12 col-lg-12 car_detail_button">+<?= money($hizli3) ?>₺</button>
								</div>
								<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 mh10p5" style="padding: 0px 5px 3px 5px !important;">
									<button type="button" onclick="alert('Devam Etmek İçin Lütfen Giriş Yapın !')" id="arti2" value="<?= $hizli2 ?>" <?= $tiklanma ?> class="col-xs-12 col-sm-12 col-md-12 col-lg-12 car_detail_button">+<?= money($hizli2) ?>₺</button>
								</div>
								<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 mh10p5" style="padding: 0px 5px 3px 5px !important;">
									<button type="button" onclick="alert('Devam Etmek İçin Lütfen Giriş Yapın !')" id="arti4" value="<?= $hizli4 ?>" <?= $tiklanma ?> class="col-xs-12 col-sm-12 col-md-12 col-lg-12 car_detail_button">+<?= money($hizli4) ?>₺</button>
								</div>
								<?php } ?>
								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 car_detail_price_box">
									<!-- <h3 id="en_yuksek_mesaj" style="color: <?= $renk ?>; "><?= $mesaj ?></h3>
                                    <h3 id="en_yuksek_mesaj2" style="color: <?= $renk2 ?>; "><?= $mesaj2 ?></h3> -->
									<?= $son_html ?>
									<input type="hidden" value="<?= $min_arti ?>" id="sigorta_min_artis">
									<?php if ($ilani_oku['son_teklif'] == 0) { ?>
										<input type="number" name="teklif" <?= $tiklanma ?> step="<?= $min_arti ?>" value="" id="girilen_teklif" onchange="degerOku(); komisyon_kontrol();" placeholder="Teklifinizi Giriniz">
										<input type="hidden" id="verilen_teklif_hidden" name="verilen_teklif_hidden" <?= $tiklanma ?> value="<?= $ilani_oku['acilis_fiyati'] ?>" id="girilen_teklif">
									<?php } else { ?>
										<input type="number" name="teklif" <?= $tiklanma ?> step="<?= $min_arti ?>" value="" id="girilen_teklif" onchange="degerOku(); komisyon_kontrol();" placeholder="Teklifinizi Giriniz">
										<input type="hidden" id="verilen_teklif_hidden" name="verilen_teklif_hidden" <?= $tiklanma ?> value="<?= $ilani_oku['son_teklif'] ?>" id="girilen_teklif">
									<?php } ?>

									<!-- <input type="text" placeholder="Teklifinizi Yazınız" /> -->
									<?php if($uye_token != ""){ ?>
									<button <?= $tiklanma ?> id="TeklifVer" onclick="kontrol(); komisyon_kontrol();" data-toggle="modal" data-target="#teklifVer">
										<i class="fas fa-arrow-right"></i>
									</button>
									<?php }else{ ?>
										<button <?= $tiklanma ?> id="TeklifVer" onclick="alert('Devam Etmek İçin Lütfen Giriş Yapın !')">
										<i class="fas fa-arrow-right"></i>
									</button>
									<?php } ?>
									<?php if ($ilani_oku['profil'] == "Hurda Belgeli") {
										echo '<p class="blink">Hurda Belgeli</p>';
									} ?>
									<label id="teklif_kontrol"> </label>
								</div>
							</div>
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mh10p5" style="margin-top:15px;">
								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 car_detail_content_title">
									DETAYLAR
								</div>
								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 car_detail_content_box">
									<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 car_detial_content_list">
										<b>İHALE KAPANIŞ :</b>
										<uk style="font-weight: 400;"><?= date("d-m-Y", strtotime($ilani_oku["ihale_tarihi"])) . " " . $ilani_oku["ihale_saati"] ?></uk>
									</div>
									<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 car_detial_content_list" style="display:<?php if ($ilani_oku["sehir"] == "") {echo "none";} else {echo "block";} ?>">
										<b>İL :</b>
										<uk style="font-weight: 400;"><?= $ilani_oku["sehir"] ?></uk>
									</div>
									<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 car_detial_content_list" style="display:<?php if ($ilani_oku["profil"] == "") {echo "none";} else {echo "block";} ?>">
										<b>PROFİL :</b>
										<uk style="font-weight: 400;"><?= $ilani_oku["profil"] ?></uk>
									</div>
									<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 car_detial_content_list" style="display:<?php if ($ilani_oku["yakit_tipi"] == "") {echo "none";} else {echo "block";} ?>">
										<b>YAKIT TÜRÜ :</b>
										<uk style="font-weight: 400;"><?= $ilani_oku["yakit_tipi"] ?></uk>
									</div>
									<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 car_detial_content_list" style="display:<?php if ($ilani_oku["vites_tipi"] == "") {echo "none";} else {echo "block";} ?>">
										<b>VİTES TÜRÜ :</b>
										<uk style="font-weight: 400;"><?= $ilani_oku["vites_tipi"] ?></uk>
									</div>
									<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 car_detial_content_list" style="display:<?php if ($ilani_oku["kilometre"] == "") {echo "none";} else {echo "block";} ?>">
										<b>KİLOMETRE :</b>
										<uk style="font-weight: 400;"><?= money($ilani_oku["kilometre"]) ?></uk>
									</div>
								</div>
							</div>
							<?php 
							$sigorta_park_ucreti = $ilani_oku['otopark_ucreti'];
							$sigorta_park_giris = $ilani_oku['otopark_giris'];
							if ($sigorta_park_giris != "0000-00-00" && $sigorta_park_giris != "") {
								$park_giris = " (Parka giriş: " . date("d-m-Y", strtotime($sigorta_park_giris)) . " ) ";
							} else {
								$park_giris = "";
							}
							$sigorta_park_ucreti .= $park_giris;
							?>
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mh10p5" style="margin-top:15px;">
								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 car_detail_content_title">
									TEKLİF HARİCİ ÖDEME
								</div>
								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 car_detail_content_box">
									<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 car_detial_content_list" style="display: <?php if ($sigorta_pd == "") {echo 'none';} ?>">
										<b>PD HİZMET BEDELİ :</b>
										<uk style="font-weight: 400;"><?= $sigorta_pd ?></uk>
									</div>
									<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 car_detial_content_list" style="display: <?php if ($sigorta_park_ucreti == "") {echo 'none';} else {echo "block";} ?>">
										<b>OTOPARK ÜCRETİ :</b>
										<uk style="font-weight: 400;"><?= $sigorta_park_ucreti ?> </uk>
									</div>
									<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 car_detial_content_list" style="display: <?php if ($ilani_oku['cekici_ucreti'] == "" || $ilani_oku['cekici_ucreti'] == 0) {echo 'none';} ?>">
										<b>ÇEKİCİ ÜCRETİ :</b>
										<uk style="font-weight: 400;"><?= money($ilani_oku['cekici_ucreti']) ?> ₺ </uk>
									</div>
									<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 car_detial_content_list" style="display: <?php if ($sigorta_dosya_masrafi == "" || $sigorta_dosya_masrafi == 0) {echo 'none';} ?>">
										<b>DOSYA MASRAFI :</b>
										<uk style="font-weight: 400;"><?= $sigorta_dosya_masrafi ?> </uk>
									</div>
									<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 car_detial_content_list" style="display: <?php if ($noter_ucreti == "" || $noter_ucreti == 0) {echo 'none';} ?>">
										<b>NOTER VE TAKİPÇİ ÜCRETİ :</b>
										<uk style="font-weight: 400;"><?= money($noter_ucreti) ?> ₺ </uk>
									</div>
								</div>
							</div>
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mh10p5" style="margin-top:15px;">
								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 car_detail_content_title">
									SERVİS VE OTOPARK BİLGİLERİ
								</div>
								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 car_detail_content_box">
									<?php
									if ($ilani_oku['adres'] != "") { ?>
										<p><?= $ilani_oku["adres"] . " / " . $ilani_oku["sehir"] ?></p>
									<?php } else { ?>
										<p><?= $ilani_oku["sehir"] ?></p>
									<?php }
									?>
								</div>
							</div>
							<?php
							if ($_SESSION['u_token'] != "") {
								$uyeyi_bul = mysql_query("SELECT * FROM user WHERE user_token = '" . $_SESSION['u_token'] . "'");
								$uyeyi_yaz = mysql_fetch_assoc($uyeyi_bul);
								$temsilciyi_bul = mysql_query("SELECT * FROM kullanicilar WHERE id = '" . $uyeyi_yaz['temsilci_id'] . "'");
								$temsilci_oku = mysql_fetch_assoc($temsilciyi_bul);
								$temsilci_adi = $temsilci_oku['adi'] . " " . $temsilci_oku['soyadi'];
							} elseif ($_SESSION['k_token'] != "") {
								$uyeyi_bul = mysql_query("SELECT * FROM user WHERE kurumsal_user_token = '" . $_SESSION['u_token'] . "'");
								$uyeyi_yaz = mysql_fetch_assoc($uyeyi_bul);
								$temsilciyi_bul = mysql_query("SELECT * FROM kullanicilar WHERE id = '" . $uyeyi_yaz['temsilci_id'] . "'");
								$temsilci_oku = mysql_fetch_assoc($temsilciyi_bul);
								$temsilci_adi = $temsilci_oku['adi'] . " " . $temsilci_oku['soyadi'];
							}
							?>
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mh10p5" style="margin-top:15px;">
								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 car_detail_content_title">
									MÜŞTERİ TEMSİLCİSİ
								</div>
								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 car_detail_content_box" style="display:flex; align-items:center; justify-content:center;">
									<?php

									if ($uyeyi_yaz['temsilci_id'] == 0) {
										$metni_cek = mysql_query("select * from arac_detay_musteri_temsilcisi_metni");
										$metni_oku = mysql_fetch_assoc($metni_cek); ?>
										<div class="car_detail_contact_content" style="width: 100%;min-height: unset;margin: 0px;">
											<?= $metni_oku['icerik'] ?>
										</div>
									<?php } else { ?>
										<div class="car_detail_contact_content">
											<h3><?= $temsilci_adi ?></h3>
											<h4 style="font-weight: 400;">Bilgi İçin İletişime Geçiniz</h4>
											<a href="tel:<?= $temsilci_oku['tel'] ?>">
												<h5 style="font-weight: 400;"><i class="fas fa-phone"></i> <?= $temsilci_oku['tel'] ?></h5>
											</a>
											<a href="mailto:<?= $temsilci_oku['email'] ?>">
												<h5 style="font-weight: 400;"><i class="fas fa-envelope"></i> <?= $temsilci_oku['email'] ?></h5>
											</a>
										</div>
										<?php $lnkle = "https://ihale.pertdunyasi.com/arac_detay.php?id=" . re("id") . "%26q=" . re("q");
										$sahip_tel = $temsilci_oku['tel'];
										$sahip_tel = str_replace('(', '', $sahip_tel);
										$sahip_tel = str_replace(')', '', $sahip_tel);
										$sahip_tel = str_replace('-', '', $sahip_tel);
										$sahip_tel = "9" . $sahip_tel;
										?>
										<a target="_blank" href="https://wa.me/?phone=<?= $sahip_tel ?>&text=<?= $lnkle ?>">
											<div class="car_detail_contact_icon">
												<img src="assets/whatsapp_logo.png" />
											</div>
										</a>
									<?php } ?>
								</div>
							</div>
						</div>
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mh10p5" style="margin-top:15px;display: <?php if ($ilani_oku["hasar_bilgileri"] == "") {echo 'none';} ?>">
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 car_detail_content_title">
								HASAR BİLGİLERİ
							</div>
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 car_detail_content_box">
								<?= $ilani_oku["hasar_bilgileri"] ?>
							</div>
						</div>
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mh10p5" style="margin-top:15px;display: <?php if ($ilani_oku["notlar"] == "") {echo 'none';} ?>">
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 car_detail_content_title">
								NOTLAR
							</div>
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 car_detail_content_box">
								<?= $getNot ?>
							</div>
						</div>
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mh10p5" style="margin-top:15px;display: <?php if ($ilani_oku["donanimlar"] == "") {echo 'none';} ?>">
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 car_detail_content_title">
								DONANIMLAR
							</div>
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 car_detail_content_box">
								<?= $ilani_oku["donanimlar"] ?>
							</div>
						</div>
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mh10p5" style="margin-top:15px;display: <?php if ($sigorta_aciklama == "") {echo 'none';} ?>">
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 car_detail_content_title">
								İHALE AÇIKLAMALARI
							</div>
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 car_detail_content_box">
								<?= $sigorta_aciklama ?>
							</div>
						</div>
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 car_detail_bottom_social">
							<a data-sharer="facebook" data-hashtag="Pert Dünyası" data-url="<?= $actual_link ?>">
								<span>
									<i class="fab fa-facebook-f"></i>
								</span>
							</a>
							<!-- <a href="https://www.facebook.com/sharer/sharer.php?u=https://ihale.pertdunyasi.com/arac_detay.php?id=184&q=ihale" target="_blank">
								<span>
									<i class="fab fa-facebook-f"></i>
								</span>
							</a> -->
							<a data-sharer="twitter" data-title="Pert Dünyası" data-hashtags="hasarlioto, pertdunyasi" data-url="<?= $actual_link ?>">
								<span>
									<i class="fab fa-twitter"></i>
								</span>
							</a>
							<!-- <a href="https://twitter.com/share?url=<?= $actual_link ?>&text=Pert Dünyası" target="_blank">
								<span>
									<i class="fab fa-twitter"></i>
								</span>
							</a> -->
							<a href="https://www.instagram.com/sharer/sharer.php?u=https://ihale.pertdunyasi.com/arac_detay.php?id=184&q=ihale" target="_blank">
								<span>
									<i class="fab fa-instagram"></i>
								</span>
							</a>
						</div>
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 car_detail_bottom_counter">
							<?php
							$sorgu_goruntulenme = mysql_query("SELECT * FROM ihale_goruntulenme where ilan_id='" . $ihaleID . "' ");
							$cek_goruntulenme = mysql_num_rows($sorgu_goruntulenme);
							?>
							<h3>Görüntülenme Sayısı</h3>
							<h4><?= $cek_goruntulenme ?></h4>
						</div>
					</div>
					<div id="lightgallery" style="display:none;">
						<?php echo $lightgallery_images; ?>
					</div>
			</div>
			</div>
			<div class="row mt-2" style="text-align:center;width:100%"></div>
		<?php } ?>
		</div>
	<?php } else {
			$en_yksk_kapali = "";
			$sql_teklif_kapali = mysql_query("select * from teklifler where ilan_id='" . $gelen_id . "' and uye_id='" . $id_u . "' and durum=1 order by teklif_zamani desc ");
			$ilan_kontrol_kapali = mysql_query("select * from ilanlar where id='" . $gelen_id . "' ");
			$ilan_kontrol_kapali_cek = mysql_fetch_object($ilan_kontrol_kapali);
			$kapali_durum = $ilan_kontrol_kapali_cek->ihale_turu;
			$teklif_say_kapali = 0;
			while ($row_teklif = mysql_fetch_object($sql_teklif_kapali)) {
				if ($kapali_durum == "2") {
					if ($kazanilan_ihl_durum == true) {
						if ($uye_token != "") {
							if ($row_teklif->teklif == "") {
								$en_yksk_kapali = '<i style="color: red; text-align:center;">Henüz teklif vermediniz.</i>';
							} else if ($row_teklif->teklif != "" && $teklif_say_kapali == 0) {
								$en_yksk_kapali = '<i style="color: red; text-align:center;">' . money($row_teklif->teklif) . ' ₺ teklif verdiniz.</i>';
							}
							$teklif_say_kapali++;
						} else {
							$en_yksk_kapali = "";
						}
					}
				}
			}
	?>
		<!-- Teklif Ver Modal Başlangıç -->
		<input type="hidden" id="ihale_tur" value="<?= $tur ?>" />
		<div class="modal fade" id="teklifVer" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="container">
						<form method="post">
							<div class="modal-header">
								<button style="margin-top:1%; font-size:17px; font-weight:600;" type="button" class="btn btn-dark btn-block"><?= $ihl_mdl_y . " " . $ihl_mrk_adi . " " . $ihl_mdl ?></button>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<div class="modal-body">
								<div class="row">
									<div class="col">
										<p style="text-align:left; font-size:15px; font-weight:600;">PD HİZMET BEDELİ</p>
										<b style="color:blue;display:none"></b>
										<button type="button" class="btn btn-dark btn-block" style="font-size:16px; font-weight:600;">
											<span id="hizmet_bedel"></span>
										</button>
									</div>
									<div class="col">
										<p style="text-align:center; font-size:15px; font-weight:600;">VERİLECEK TEKLİF</p>
										<button type="button" class="btn btn-dark btn-block" style="font-size:16px; font-weight:600; background-color:rgb(247, 148, 29);border-color:transparent !important;" id="GelenTeklif">
										</button>
									</div>
								</div>
								<div class="row mt-4">
									<div class="col" style="text-align:right; padding:10px 0px;">
										Teklifinizi Yazınız
									</div>
									<div class="col">
										<input style="height40px;" type="number" placeholder="Teklifinizi buraya yazınız." step="<?= $min ?>" class="form-control" id="verilen_teklif">
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
									<button type="button" class="btn btn-danger btn-block" data-dismiss="modal" id="acik_modal_kapat2">
										Vazgeç
									</button>
								</div>
								<div class="col">
									<button type="button" class="btn btn-success btn-block" id="TeklifVer<?= $ihale_oku['id'] ?>" onclick="denem();">
										<i class="fas fa-lira-sign"> Teklif Ver</i>
									</button>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
		<!-- Teklif Ver Modal Bitiş -->
		<!-- Mesaj Yaz Modal Başlangıç -->
		<div class="modal fade" id="mesajYaz" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="container">
						<form method="POST">
							<div class="modal-body">
								<div class="row mt-2">
									<div class="col">
										<h6 style="text-align: center; font-size:10px;">Mesaj Yaz</h6>
									</div>
								</div>
								<div class="row mt-2">
									<div class="col">
										<label for="IDofInput">Mesaj</label>
										<textarea style="width:100%;" name="gonderilecek_mesaj" id="gonderilecek_mesaj" rows="3"></textarea>
									</div>
								</div>
								<div class="row mt-2">
									<div class="col">
										<button type="button" onclick="mesajGonder()" class="btn btn-dark btn-block">Gönder</button>
									</div>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
		<!-- Mesaj Yaz Modal Bitiş -->
		<div class="container" style="margin-top:11%;">
			<?php while ($ilani_oku = mysql_fetch_array($ilani_cek)) {
				if ($_SESSION['u_token'] != "" && $_SESSION['k_token'] == "") {
					$renkli_uye_bul = mysql_query("SELECT * FROM user WHERE user_token = '" . $_SESSION['u_token'] . "'");
					$renkli_uye_oku = mysql_fetch_assoc($renkli_uye_bul);
					$renkli_uye_id = $renkli_uye_oku['id'];
					$favli_mi = mysql_query("SELECT * FROM favoriler WHERE uye_id = '" . $renkli_uye_id . "' AND ilan_id = '" . $ilani_oku['id'] . "'");
					$favorili_say = mysql_num_rows($favli_mi);
					if ($favorili_say == 0) {
						$fav_color = "gray";
						$fav_title = "Araç favorilerize eklenecektir.";
					} else {
						$fav_color = "orange";
						$fav_title = "Araç favorilerizden kaldırılacaktır.";
					}
				} else if ($_SESSION['u_token'] == "" && $_SESSION['k_token'] != "") {
					$renkli_uye_bul = mysql_query("SELECT * FROM user WHERE kurumsal_user_token = '" . $_SESSION['k_token'] . "'");
					$renkli_uye_oku = mysql_fetch_assoc($renkli_uye_bul);
					$renkli_uye_id = $renkli_uye_oku['id'];
					$favli_mi = mysql_query("SELECT * FROM favoriler WHERE uye_id = '" . $renkli_uye_id . "' AND ilan_id = '" . $ilani_oku['id'] . "'");
					$favorili_say = mysql_num_rows($favli_mi);
					if ($favorili_say == 0) {
						$fav_color = "gray";
						$fav_title = "Araç favorilerize eklenecektir.";
					} else {
						$fav_color = "orange";
						$fav_title = "Araç favorilerizden kaldırılacaktır.";
					}
				} else {
					$fav_color = "gray";
					$fav_title = "Araç favorilerize eklenecektir.";
				}
				if ($_SESSION['u_token'] != "" && $_SESSION['k_token'] == "") {
					$renkli_uye_bul = mysql_query("SELECT * FROM user WHERE user_token = '" . $_SESSION['u_token'] . "'");
					$renkli_uye_oku = mysql_fetch_assoc($renkli_uye_bul);
					$renkli_uye_id = $renkli_uye_oku['id'];
					$bildirimli_mi = mysql_query("SELECT * FROM bildirimler WHERE uye_id = '" . $renkli_uye_id . "' AND ilan_id = '" . $ilani_oku['id'] . "'");
					$bildirimli_say = mysql_num_rows($bildirimli_mi);
					if ($bildirimli_say == 0) {
						$bidlirim_color = "gray";
						$bildirim_title = "Araç bildirimleri açılacaktır.";
					} else {
						$bidlirim_color = "orange";
						$bildirim_title = "Araç bildirimleri kapatılacaktır.";
					}
				} else if ($_SESSION['u_token'] == "" && $_SESSION['k_token'] != "") {
					$renkli_uye_bul = mysql_query("SELECT * FROM user WHERE kurumsal_user_token = '" . $_SESSION['k_token'] . "'");
					$renkli_uye_oku = mysql_fetch_assoc($renkli_uye_bul);
					$renkli_uye_id = $renkli_uye_oku['id'];

					$bildirimli_mi = mysql_query("SELECT * FROM bildirimler WHERE uye_id = '" . $renkli_uye_id . "' AND ilan_id = '" . $ilani_oku['id'] . "'");
					$bildirimli_say = mysql_num_rows($bildirimli_mi);
					if ($bildirimli_say == 0) {
						$bidlirim_color = "gray";
						$bildirim_title = "Araç bildirimleri açılacaktır.";
					} else {
						$bidlirim_color = "orange";
						$bildirim_title = "Araç bildirimleri kapatılacaktır.";
					}
				} else {
					$bidlirim_color = "gray";
					$bildirim_title = "Araç bildirimleri açılacaktır.";
				}
				$ihale_turu = $ilani_oku['ihale_turu'];
				if ($ihale_turu == 1) {
					$ihale_turu_yaz = "Açık İhale";
				} elseif ($ihale_turu == 2) {
					$ihale_turu_yaz = "Kapalı İhale";
				}
				$ihaleID = $ilani_oku['id'];
				$ihale_marka = $ilani_oku['marka'];
				$ihale_sehir = $ilani_oku['sehir'];
				$son_teklif_cek = mysql_query("SELECT * FROM ilanlar WHERE id='" . $ihaleID . "'");
				$ilan_resim_cek = mysql_query("SELECT * FROM ilan_resimler WHERE ilan_id = '" . $ihaleID . "' ");
				$ilan_resim_cek2 = mysql_query("SELECT * FROM ilan_resimler WHERE ilan_id = '" . $ihaleID . "' ");
				$ilan_resim_sayisi = mysql_num_rows($ilan_resim_cek);
				$marka_cek = mysql_query("SELECT * FROM marka WHERE markaID='" . $ihale_marka . "' LIMIT 1");
				$marka_ck = mysql_query("SELECT * FROM marka WHERE markaID='" . $ihale_marka . "' LIMIT 1");
				$marka_kk = mysql_fetch_assoc($marka_ck);
				$marka_adi2 = $marka_kk["marka_adi"];
				$sehir_cek = mysql_query("SELECT * FROM sehir WHERE sehirID = '" . $ihale_sehir . "' LIMIT 1");
				$komisyon_cek = mysql_query("SELECT * FROM ilan_komisyon WHERE ilan_id = '" . $ihaleID . "'");
				$komisyon_oku = mysql_fetch_assoc($komisyon_cek);
				$komisyon = $komisyon_oku['toplam'];
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
				<?php
				// Sigorta Şirketine göre belirlenen dakikanın altında teklif gelirse süre
				// otomatik olarak şirketin belirlenen ayarlarındaki dakika kadar artar
				$sigorta_bul = mysql_query("SELECT * FROM sigorta_ozellikleri WHERE id = '" . $ilani_oku['sigorta'] . "'");
				$sigorta_oku = mysql_fetch_assoc($sigorta_bul);
				$hizli1 = $sigorta_oku['hizli_teklif_1'];
				$hizli2 = $sigorta_oku['hizli_teklif_2'];
				$hizli3 = $sigorta_oku['hizli_teklif_3'];
				$hizli4 = $sigorta_oku['hizli_teklif_4'];
				$min_arti = $sigorta_oku['minumum_artis'];
				$sigorta_notu = $sigorta_oku['uyari_notu'];
				$dakika_altinda = $sigorta_oku['dakikanin_altinda'];
				$dakika_uzar = $sigorta_oku['dakika_uzar'];
				$ihalenin_saati = $ilani_oku['ihale_saati'];
				$bugun = date('Y-m-d');
				$ihale_zaman = $ilani_oku['ihale_tarihi'] . " " . $ilani_oku['ihale_saati'];
				$yeni_ihale_saati =  date('H:i:s', strtotime('+' . $dakika_uzar . ' minutes', strtotime($ihalenin_saati)));
				$teklif_zaman_kontrol =  date('H:i:s', strtotime('-' . $dakika_uzar . ' minutes', strtotime($ihalenin_saati)));
				$teklif_zaman_son_kontrol = $bugun . " " . $teklif_zaman_kontrol;
				$teklif_zaman_cek = mysql_query("SELECT * FROM teklifler WHERE ilan_id = '" . $ilani_oku['id'] . "' and durum=1 ORDER BY teklif_zamani DESC LIMIT 1");
				$teklif_zaman_oku = mysql_fetch_assoc($teklif_zaman_cek);
				$teklif_zamani = $teklif_zaman_oku['teklif_zamani'];
				/* if($ilani_oku['ihale_tarihi']==$bugun && $teklif_zamani > $teklif_zaman_son_kontrol && $teklif_zamani < $ihale_zaman){
				mysql_query("UPDATE ilanlar SET ihale_saati = '".$yeni_ihale_saati."' WHERE id = '".$ihaleID."'");
				}*/
				?>
				<?php
				if (isset($_POST['favla'])) {
					$date = date('Y-m-d H:i:s');
					$id = $_POST['favlanacak'];
					if ($_SESSION['u_token'] != "" && $_SESSION['k_token'] == "") {
						$favi_cek = mysql_query("SELECT * FROM user WHERE user_token = '" . $uye_token . "'");
						while ($favi_oku = mysql_fetch_array($favi_cek)) {
							$uyeninID = $favi_oku['id'];
							$favlamismi_cek = mysql_query("SELECT * FROM favoriler WHERE ilan_id = '" . $id . "' AND uye_id = '" . $uyeninID . "'");
							$favlamismi_sayi = mysql_num_rows($favlamismi_cek);
							if ($favlamismi_sayi == 0) {
								mysql_query("INSERT INTO `favoriler` (`ilan_id`, `uye_id`, `favlama_zamani`, `user_token`) VALUES ('" . $id . "', '" . $uyeninID . "', '" . $date . "', '" . $uye_token . "');");
								echo '<script> alert("İlan Favorilerinize Eklendi")</script>';
								echo '<script> window.location.href = "arac_detay.php?id=' . $id . '&q=ihale";</script>';
							} else {
								mysql_query("DELETE FROM favoriler WHERE ilan_id = '" . $id . "' AND uye_id = '" . $uyeninID . "'");
								echo '<script> alert("İlan Favorilerinizden Kaldırıldı")</script>';
								echo '<script> window.location.href = "arac_detay.php?id=' . $id . '&q=ihale";</script>';
							}
						}
					} elseif ($_SESSION['u_token'] == "" && $_SESSION['k_token'] != "") {
						$favi_cek = mysql_query("SELECT * FROM user WHERE kurumsal_user_token = '" . $uye_token . "'");
						while ($favi_oku = mysql_fetch_array($favi_cek)) {
							$uyeninID = $favi_oku['id'];
							$favlamismi_cek = mysql_query("SELECT * FROM favoriler WHERE ilan_id = '" . $id . "' AND uye_id = '" . $uyeninID . "'");
							$favlamismi_sayi = mysql_num_rows($favlamismi_cek);
							if ($favlamismi_sayi == 0) {
								mysql_query("INSERT INTO `favoriler` `ilan_id`, `uye_id`, `favlama_zamani`, `kurumsal_token`) VALUES ('" . $id . "', '" . $uyeninID . "', '" . $date . "', '" . $uye_token . "');");
								echo '<script> alert("İlan Favorilerinize Eklendi")</script>';
								echo '<script> window.location.href = "arac_detay.php?id=' . $id . '&q=ihale";</script>';
							} else {
								mysql_query("DELETE FROM favoriler WHERE ilan_id = '" . $id . "' AND uye_id = '" . $uyeninID . "'");
								echo '<script> alert("İlan Favorilerinizden Kaldırıldı")</script>';
								echo '<script> window.location.href = "arac_detay.php?id=' . $id . '&q=ihale";</script>';
							}
						}
					}
				}
				if (isset($_POST['bildirim_ac'])) {
					$date = date('Y-m-d H:i:s');
					$id = $_POST['bildirimlenecek'];
					if ($_SESSION['u_token'] != "" && $_SESSION['k_token'] == "") {
						$bildirim_cek = mysql_query("SELECT * FROM user WHERE user_token = '" . $uye_token . "'");
						while ($bildirim_oku = mysql_fetch_array($bildirim_cek)) {
							$uyeninID = $bildirim_oku['id'];
							$bildirim_varmi = mysql_query("SELECT * FROM bildirimler WHERE ilan_id = '" . $id . "' AND uye_id = '" . $uyeninID . "'");
							$bildirimini_say = mysql_num_rows($bildirim_varmi);
							if ($bildirimini_say == 0) {
								mysql_query("INSERT INTO `bildirimler` (`ilan_id`, `uye_id`, `bildirim_zamani`, `user_token`) VALUES ('" . $id . "','" . $uyeninID . "', '" . $date . "', '" . $uye_token . "');");
								echo '<script> alert("Bildirimler açıldı");</script>';
								echo '<script> window.location.href = "arac_detay.php?id=' . $id . '&q=ihale";</script>';
							} else {
								mysql_query("DELETE FROM bildirimler WHERE ilan_id = '" . $id . "' AND uye_id = '" . $uyeninID . "'");
								echo '<script> alert("Bildirimler kapatıldı");</script>';
								echo '<script> window.location.href = "arac_detay.php?id=' . $id . '&q=ihale";</script>';
							}
						}
					} elseif ($_SESSION['u_token'] == "" && $_SESSION['k_token'] != "") {
						$bildirim_cek = mysql_query("SELECT * FROM user WHERE kurumsal_user_token = '" . $uye_token . "'");
						while ($bildirim_oku = mysql_fetch_array($bildirim_cek)) {
							$uyeninID = $bildirim_oku['id'];
							$bildirim_varmi = mysql_query("SELECT * FROM bildirimler WHERE ilan_id = '" . $id . "' AND uye_id = '" . $uyeninID . "'");
							$bildirimini_say = mysql_num_rows($bildirim_varmi);
							if ($bildirimini_say == 0) {
								mysql_query("INSERT INTO `bildirimler` (`ilan_id`, `uye_id`, `bildirim_zamani`,`kurumsal_token`) VALUES ('" . $id . "', '" . $uyeninID . "', '" . $date . "', '" . $uye_token . "');");
								echo '<script> alert("Bildirimler açıldı")</script>';
								echo '<script> window.location.href = "arac_detay.php?id=' . $id . '&q=ihale";</script>';
							} else {
								mysql_query("DELETE FROM bildirimler WHERE ilan_id = '" . $id . "' AND uye_id = '" . $uyeninID . "'");
								echo '<script> alert("Bildirimler kapatıldı")</script>';
								echo '<script> window.location.href = "arac_detay.php?id=' . $id . '&q=ihale";</script>';
							}
						}
					}
				}
				if ($ilani_oku['profil'] == "Hurda Belgeli") {
					$blink = "blink";
				}
				$sehir_ce = mysql_query("select * from sehir id='" . $ilani_oku["sehir"] . "'");
				$sehir_ok = mysql_fetch_array($sehir_ce);
				?>
				<input type="hidden" id="ilanID" value="<?= $ilani_oku['id'] ?>">
				<input type="hidden" id="ihaleSahibi" value="<?= $ilani_oku['ihale_sahibi'] ?>">
				<input type="hidden" id="ilan_komisyon" value="<?= $komisyon ?>">
				<div class="btn-group mr-2" role="group" aria-label="Basic example" style="display:none;">
					<button type="button" class="btn kucuk kapanis_zamani"><?= date("d-m-Y", strtotime($ilani_oku["ihale_tarihi"])) . " " . $ilani_oku["ihale_saati"] ?></button>
				</div>
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 car_detail_top">
					<span style="display:<?php if ($ilani_oku["plaka"] == "") { echo ('none');} ?>">Plaka : <b><?= $ilani_oku["plaka"] ?></b></span>
					<span style="display:<?php if ($ilani_oku["arac_kodu"] == "") { echo ('none');} ?>">Araç Kodu : <b>#<?= $ilani_oku['arac_kodu'] ?></b></span>
					<span style="display:<?php if ($ilani_oku['tsrsb_degeri'] == "") {echo ('none'); } ?>">TSRSB Değeri : <b style="color:#000;"> <?= money($ilani_oku["tsrsb_degeri"]) ?>₺</b></span>
					<a data-toggle="tooltip" data-placement="top" title="Benzer ilanlara buradan ulaşabilirsiniz." target="_blank" href="https://www.sahibinden.com/vasita?query_text_mf=<?= $ilani_oku['model_yili'] ?>+<?= $marka_adi2 ?>+<?= $ilani_oku['model'] ?>&query_text=<?= $ilani_oku['model_yili'] ?>+<?= $marka_adi2 ?>+<?= $ilani_oku['model'] ?>">
						<div class="car_detail_top_btn" style="background-image:url('assets/sahibinden_logo2.png'); margin-left:15px;"></div>
					</a>
					<div class="car_detail_top_btn" onclick="bildirim_ac(<?= $ilani_oku['id'] ?>)" data-toggle="tooltip" data-placement="top" title="<?= $bildirim_title ?>" id="bildirim_ac_<?= $ilani_oku['id'] ?>">
						<i style="color: <?= $bidlirim_color ?>;" class="fas fa-bell"></i>
						<input type="hidden" name="bildirimlenecek" value="<?= $ilani_oku['id'] ?>">
					</div>
					<div class="car_detail_top_btn" onclick="favla(<?= $ilani_oku['id'] ?>)" data-toggle="tooltip" data-placement="top" title="<?= $fav_title ?>" id="favla_<?= $ilani_oku['id'] ?>">
						<i style="color: <?= $fav_color ?>;" class="fas fa-star"></i>
						<input type="hidden" name="favlanacak" value="<?= $ilani_oku['id'] ?>">
					</div>
				</div>
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 car_detail_top_info" style="display:<?php if ($ilani_oku['uyari_notu'] != "" || $sigorta_notu != "") { echo 'block'; } else { echo 'none'; } ?>">
					<?= $ilani_oku['uyari_notu'] . " " . $sigorta_notu; ?>
				</div>
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 car_detail_title">
					<i class="fas fa-car"></i> 
					<?php while ($marka = mysql_fetch_array($marka_cek)) { ?>
						<?= $ilani_oku["model_yili"] . " " . $marka['marka_adi'] . " " . $ilani_oku["model"] . " " . $ilani_oku["tip"] ?>
					<?php } ?>
				</div>
				<?php
				$image_list = array();
				while ($ilan_resim_oku = mysql_fetch_array($ilan_resim_cek)) {
					array_push($image_list, $ilan_resim_oku['resim']);
				}
				$mini_images = '';
				$say = 0;
				for ($i = 0; $i <= count($image_list); $i++) {
					if ($image_list[$i] != "") {
						$selected = '';
						if ($say == 0) {
							$selected = 'car_select_image';
						}
						$mini_images .= '<div class="car_detail_mini_images_box">
							<div class="car_detail_mini_images ' . $selected . '" style="background-image:url(\'images/' . $image_list[$i] . '\')" id="car_mini_image' . $i . '" onclick="carDetailImage(' . $i . ',\'' . $image_list[$i] . '\')"></div>
						</div>';

						$lightgallery_images .= '<a href="images/' . $image_list[$i] . '" data-lg-size="1600-2400" id="galleryImage' . $i . '">
							<img src="images/' . $image_list[$i] . '" />
						</a>';
						$say++;
					}
				}
				?>
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 car_detail_content_outer">
					<div class="col-xs-12 col-sm-12 col-md-7 col-lg-7 car_detail_images_outer">
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mh10p5">
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 card_detail_big_image">
								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 card_detail_big_image" id="car_detail_big_image" style="background-image:url('images/<?php echo $image_list[0]; ?>')" onclick="openGallery()">
								</div>
								<div class="car_detail_image_arrows" onclick="carSliderPrev()">
									<i class="fas fa-chevron-left"></i>
								</div>
								<div class="car_detail_image_arrows" onclick="carSliderNext()">
									<i class="fas fa-chevron-right"></i>
								</div>
							</div>
						</div>
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 car_detail_mini_images_outer">
							<input type="hidden" id="carDetailSelectImage" value="0" />
							<input type="hidden" id="carDetailImageCount" value="<?php echo $say; ?>" />
							<?php echo $mini_images; ?>
						</div>
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mh10p5" style="margin-top:15px;">
							<?php
							$iln_sigorta = mysql_query("select * from sigorta_ozellikleri where id='" . $ilani_oku["sigorta"] . "'");
							$iln_sigorta_listele = mysql_fetch_object($iln_sigorta);
							$sigorta_uyari = $iln_sigorta_listele->uyari_notu;
							$onemli_metin_cek = mysql_query("select * from arac_detay_onemli_metni order by id desc limit 1");
							$onemli_metin_oku = mysql_fetch_object($onemli_metin_cek);
							$onemli_metin = $onemli_metin_oku->metin;
							?>
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 car_detail_content_box" style="border-top:1px solid #ededed;">
								<?= $onemli_metin ?>
							</div>
						</div>
					</div>
					<div class="col-xs-12 col-sm-12 col-md-5 col-lg-5 car_detail_text_outer">
						<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 mh10p5">
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 car_detail_mini_text">
								Kalan Zaman
							</div>
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 car_detail_button" id="sayac">
								<i class="fas fa-clock"></i>
							</div>
							<input type="hidden" id="ihale_sayac" value="<?= $ilani_oku['ihale_tarihi'] . ' ' . $ilani_oku['ihale_saati'] ?>">
							<input type="hidden" id="sure_uzatilma_durum" value="<?= $ilani_oku['sistem_sure_uzatma_durumu'] ?>">
							<input type="hidden" id="belirlenen" value="<?= $sigorta_oku['bu_sure_altinda_teklif'] ?>">
							<input type="hidden" id="ihale_id" value="<?= $ilani_oku['id'] ?>">
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 car_detail_button">
								KAPALI İHALE
							</div>
							<?php if ($ilani_oku['ihale_tarihi'] == date('Y-m-d') && $ilani_oku['ihale_saati'] <= date('H:i:s')) {
								$tiklanma =  "disabled";
							} ?>
							<?php if($uye_token != ""){ ?>
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 car_detail_button" <?= $tiklanma ?> onclick="kontrol()" id="mesajGonder" data-toggle="modal" data-target="#mesajYaz" style="cursor: pointer;">
								<i class="fas fa-envelope"></i> Mesaj Yaz
							</div>
							<?php }else{ ?>
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 car_detail_button" <?= $tiklanma ?> onclick="alert('Devam Etmek İçin Lütfen Giriş Yapın !')" style="cursor: pointer;">
								<i class="fas fa-envelope"></i> Mesaj Yaz
							</div>
							<?php } ?>
						</div>
						<?php while ($son_teklif_oku = mysql_fetch_array($son_teklif_cek)) {
							$enyuksek = $son_teklif_oku["son_teklif"];
							if ($uye_token == $token) {
								$kim_cek = mysql_query("SELECT * FROM teklifler WHERE user_token = '" . $uye_token . "' AND ilan_id = '" . $gelen_id . "' and durum=1 ORDER BY teklif_zamani DESC LIMIT 1");
							} elseif ($uye_token == $k_token) {
								$kim_cek = mysql_query("SELECT * FROM teklifler WHERE kurumsal_token = '" . $uye_token . "' AND ilan_id = '" . $gelen_id . "' and durum=1 ORDER BY teklif_zamani DESC LIMIT 1");
							}
							if (mysql_num_rows($kim_cek) != 0) {
								if ($uye_token != "") {
									while ($kim_oku = mysql_fetch_array($kim_cek)) {
										if ($kim_oku['teklif'] == $enyuksek) {
											$display = "block";
											// $mesaj="En yüksek teklif sizin3";
											if ($ilani_oku["ihale_turu"] == 1) {
												$mesaj = "En yüksek teklif sizin";
											} else {
												$mesaj = "";
											}
											$renk = "green";
											$mesaj2 = money($kim_oku['teklif']) . " ₺ teklif verdiniz";
											$renk2 = "red";
										} else if ($kim_oku['teklif'] > 0) {
											$display = "block";
											$mesaj2 = money($kim_oku['teklif']) . " ₺ teklif verdiniz";
											$renk = "red";
										} else {
											$display = "none";
										}
									}
								} else {
									$mesaj = "";
									$mesaj2 = "";
								}
							} else {
								$display = "none";
							}
						}
						?>
						<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 mh10p5" style="padding:0px;">
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mh10p5">
								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 car_detail_mini_text">
									Taban Fiyat
								</div>
								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 car_detail_button" style="margin:0px; background-color:#ff7f27;">
									<?= money($ilani_oku['acilis_fiyati']) ?> ₺
								</div>
							</div>
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 car_detail_price_box">
								<?php
								$son_cek = mysql_query("select * from kazanilan_ilanlar where ilan_id = '" . $gelen_id . "'");
								$son_oku = mysql_fetch_object($son_cek);
								if ($son_oku->durum == 1 || $son_oku->durum == 2 || $son_oku->durum == 3) {
									$son_html = '<h3 id="en_yuksek_mesaj2" style="color: ' . $renk . ';">' . $mesaj . '</h3>';
								} else {
									$son_html = '<h3 id="en_yuksek_mesaj" style="color: ' . $renk . ';">' . $mesaj . '</h3>
									<h3 id="en_yuksek_mesaj2" style="color: ' . $renk2 . ';">' . $mesaj2 . '</h3>';
								}
								?>
								<!-- <h3 id="en_yuksek_mesaj" style="color: <?= $renk ?>; "><?= $mesaj ?></h3>
								<h3 id="en_yuksek_mesaj2" style="color: <?= $renk2 ?>; "><?= $mesaj2 ?></h3> -->
								<?= $son_html ?>
								<input type="hidden" value="<?= $min_arti ?>" id="sigorta_min_artis">
								<input type="number" name="teklif" <?= $tiklanma ?> step="<?= $min_arti ?>" value="" id="girilen_teklif" onchange="degerOku(); komisyon_kontrol();" placeholder="Teklifinizi Giriniz">
								<?php if($uye_token != ""){ ?>
								<button <?= $tiklanma ?> id="TeklifVer" onclick="kontrol(); komisyon_kontrol();" data-toggle="modal" data-keyboard="false" data-backdrop="static" data-target="#teklifVer">
									<i class="fas fa-arrow-right"></i>
								</button>
								<?php }else{ ?>
									<button <?= $tiklanma ?> onclick="alert('Devam Etmek İçin Lütfen Giriş Yapın !')">
										<i class="fas fa-arrow-right"></i>
									</button>
								<?php } ?>
								<?php if ($ilani_oku['profil'] == "Hurda Belgeli") {
									echo '<p class="blink">Hurda Belgeli</p>';
								} ?>
								<label id="teklif_kontrol"> </label>
							</div>
						</div>
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mh10p5" style="margin-top:15px;">
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 car_detail_content_title">
								DETAYLAR
							</div>
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 car_detail_content_box">
								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 car_detial_content_list">
									<b>İHALE KAPANIŞ :</b>
									<uk style="font-weight: 400;"><?= date("d-m-Y", strtotime($ilani_oku["ihale_tarihi"])) . " " . $ilani_oku["ihale_saati"] ?></uk>
								</div>
								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 car_detial_content_list" style="display:<?php if ($ilani_oku["sehir"] == "") { echo "none"; } else { echo "block"; } ?>">
									<b>İL :</b>
									<uk style="font-weight: 400;"><?= $ilani_oku["sehir"] ?></uk>
								</div>
								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 car_detial_content_list" style="display:<?php if ($ilani_oku["profil"] == "") { echo "none"; } else { echo "block"; } ?>">
									<b>PROFİL :</b>
									<uk style="font-weight: 400;"><?= $ilani_oku["profil"] ?></uk>
								</div>
								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 car_detial_content_list" style="display:<?php if ($ilani_oku["yakit_tipi"] == "") { echo "none"; } else { echo "block"; } ?>">
									<b>YAKIT TÜRÜ :</b>
									<uk style="font-weight: 400;"><?= $ilani_oku["yakit_tipi"] ?></uk>
								</div>
								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 car_detial_content_list" style="display:<?php if ($ilani_oku["vites_tipi"] == "") { echo "none"; } else { echo "block"; } ?>">
									<b>VİTES TÜRÜ :</b>
									<uk style="font-weight: 400;"><?= $ilani_oku["vites_tipi"] ?></uk>
								</div>
								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 car_detial_content_list" style="display:<?php if ($ilani_oku["kilometre"] == "") { echo "none"; } else { echo "block"; } ?>">
									<b>KİLOMETRE :</b>
									<uk style="font-weight: 400;"><?= money($ilani_oku["kilometre"]) ?></uk>
								</div>
							</div>
						</div>
						<?php
						if ($ilani_oku['pd_hizmet'] == "" || $ilani_oku['pd_hizmet'] == 0) {
							if ($ilani_oku['ihale_turu'] == 1) {
								$uye_teklif_cek = mysql_query("select * from teklifler where ilan_id='" . $ilani_oku['id'] . "' and durum=1 order by teklif_zamani DESC limit 1  ");
								$uye_teklif_oku = mysql_fetch_object($uye_teklif_cek);
								if (mysql_num_rows($uye_teklif_cek) == 0) {
									$sigorta_pd_first = baslangic_komisyon($ilani_oku["id"], $ilani_oku["acilis_fiyati"]);
									$sigorta_pd = money($sigorta_pd_first) . " ₺ " . "(Teklifinize göre hesaplanacak)";
								} else {
									$sigorta_pd = money($uye_teklif_oku->hizmet_bedeli) . " ₺" . "(Teklifinize göre hesaplanacak)";
								}
							} else {
								$uye_teklif_cek = mysql_query("select * from teklifler where ilan_id='" . $ilani_oku['id'] . "' and uye_id='" . $id_u . "' and durum=1 order by teklif_zamani DESC limit 1 ");
								$uye_teklif_oku = mysql_fetch_object($uye_teklif_cek);
								if (mysql_num_rows($uye_teklif_cek) == 0) {
									$sigorta_pd_first = baslangic_komisyon($ilani_oku["id"], $ilani_oku["acilis_fiyati"]);
									// $sigorta_pd=money($sigorta_pd_first)." ₺ "."(Teklifinize göre hesaplanacak)";
									$sigorta_pd = "Teklifinize göre hesaplanacak";
								} else {
									$sigorta_pd = money($uye_teklif_oku->hizmet_bedeli) . " ₺" . "(Teklifinize göre hesaplanacak)";
								}
							}
						} else {
							$sigorta_pd = money($ilani_oku['pd_hizmet']) . " ₺" . "(Teklifinize göre hesaplanacak)";
						}
						//$sigorta_park_ucreti=$iln_sigorta_listele->park_ucreti;
						$sigorta_park_ucreti = $ilani_oku['otopark_ucreti'];
						$sigorta_park_giris = $ilani_oku['otopark_giris'];
						if ($sigorta_park_giris != "0000-00-00" && $sigorta_park_giris != "") {
							$park_giris = " (Parka giriş: " . date("d-m-Y", strtotime($sigorta_park_giris)) . " ) ";
						} else {
							$park_giris = "";
						}
						$sigorta_park_ucreti .= $park_giris;

						//$sigorta_dosya_masrafi=$iln_sigorta_listele->sigorta_dosya_masrafi;
						$sigorta_dosya_masrafi = $ilani_oku['dosya_masrafi'];
						$noter_sorgu = mysql_query("select * from odeme_mesaji");
						$noter_listele = mysql_fetch_object($noter_sorgu);
						if ($ilani_oku['profil'] == "Hurda Belgeli") {
							$noter_ucreti = "Noter devri esnasında hesaplanacak";
						} else {
							$noter_ucreti = money($noter_listele->noter_takipci_gideri) . " ₺";
						}
						?>
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mh10p5" style="margin-top:15px;">
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 car_detail_content_title">
								TEKLİF HARİCİ ÖDEME
							</div>
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 car_detail_content_box">
								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 car_detial_content_list" style="display: <?php if ($ilani_oku["ihale_turu"] == 1 && ($sigorta_pd == "" || $sigorta_pd == 0)) { echo 'none'; } ?>">
									<b>PD HİZMET BEDELİ : </b>
									<uk style="font-weight: 400;"><?= $sigorta_pd ?></uk>
								</div>
								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 car_detial_content_list" style="display: <?php if ($sigorta_park_ucreti == "") { echo 'none'; } else { echo "block"; } ?>">
									<b>OTOPARK ÜCRETİ :</b>
									<uk style="font-weight: 400;"><?= $sigorta_park_ucreti ?> </uk>
								</div>
								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 car_detial_content_list" style="display: <?php if ($ilani_oku['cekici_ucreti'] == "" || $ilani_oku['cekici_ucreti'] == 0) { echo 'none'; } ?>">
									<b>ÇEKİCİ ÜCRETİ :</b>
									<uk style="font-weight: 400;"><?= money($ilani_oku['cekici_ucreti']) ?> ₺ </uk>
								</div>
								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 car_detial_content_list" style="display: <?php if ($sigorta_dosya_masrafi == "" || $sigorta_dosya_masrafi == 0) { echo 'none'; } ?>">
									<b>DOSYA MASRAFI :</b>
									<uk style="font-weight: 400;"><?= $sigorta_dosya_masrafi ?> </uk>
								</div>
								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 car_detial_content_list" style="display: <?php if ($noter_ucreti == "" || $noter_ucreti == 0) { echo 'none'; } ?>">
									<b>NOTER VE TAKİPÇİ ÜCRETİ :</b>
									<uk style="font-weight: 400;"><?= money($noter_ucreti) ?> ₺</uk>
								</div>
							</div>
						</div>
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mh10p5" style="margin-top:15px;">
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 car_detail_content_title">
								SERVİS VE OTOPARK BİLGİLERİ
							</div>
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 car_detail_content_box">
								<?php
								if ($ilani_oku['adres'] != "") { ?>
									<p><?= $ilani_oku["adres"] . " / " . $ilani_oku["sehir"] ?></p>
								<?php } else { ?>
									<p><?= $ilani_oku["sehir"] ?></p>
								<?php }
								?>
							</div>
						</div>
						<?php
						if ($_SESSION['u_token'] != "") {
							$uyeyi_bul = mysql_query("SELECT * FROM user WHERE user_token = '" . $_SESSION['u_token'] . "'");
							$uyeyi_yaz = mysql_fetch_assoc($uyeyi_bul);
							$temsilciyi_bul = mysql_query("SELECT * FROM kullanicilar WHERE id = '" . $uyeyi_yaz['temsilci_id'] . "'");
							$temsilci_oku = mysql_fetch_assoc($temsilciyi_bul);
							$temsilci_adi = $temsilci_oku['adi'] . " " . $temsilci_oku['soyadi'];
						} elseif ($_SESSION['k_token'] != "") {
							$uyeyi_bul = mysql_query("SELECT * FROM user WHERE kurumsal_user_token = '" . $_SESSION['u_token'] . "'");
							$uyeyi_yaz = mysql_fetch_assoc($uyeyi_bul);
							$temsilciyi_bul = mysql_query("SELECT * FROM kullanicilar WHERE id = '" . $uyeyi_yaz['temsilci_id'] . "'");
							$temsilci_oku = mysql_fetch_assoc($temsilciyi_bul);
							$temsilci_adi = $temsilci_oku['adi'] . " " . $temsilci_oku['soyadi'];
						}
						?>
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mh10p5" style="margin-top:15px;">
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 car_detail_content_title">
								MÜŞTERİ TEMSİLCİSİ
							</div>
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 car_detail_content_box" style="display:flex; align-items:center; justify-content:center;">
								<?php
								if ($uyeyi_yaz['temsilci_id'] == 0) {
									$metni_cek = mysql_query("select * from arac_detay_musteri_temsilcisi_metni");
									$metni_oku = mysql_fetch_assoc($metni_cek); ?>
									<div class="car_detail_contact_content" style="width: 100%;min-height: unset;margin: 0px;">
										<?= $metni_oku['icerik'] ?>
									</div>
								<?php } else { ?>
									<div class="car_detail_contact_content">
										<h3><?= $temsilci_adi ?></h3>
										<h4 style="font-weight: 400;" style="font-weight: 400;">Bilgi İçin İletişime Geçiniz</h4>
										<a href="tel:<?= $temsilci_oku['tel'] ?>">
											<h5 style="font-weight: 400;"><i class="fas fa-phone"></i> <?= $temsilci_oku['tel'] ?></h5>
										</a>
										<a href="mailto:<?= $temsilci_oku['email'] ?>">
											<h5 style="font-weight: 400;"><i class="fas fa-envelope"></i> <?= $temsilci_oku['email'] ?></h5>
										</a>
									</div>
									<?php $lnkle = "https://ihale.pertdunyasi.com/arac_detay.php?id=" . re("id") . "%26q=" . re("q");
									$sahip_tel = $temsilci_oku['tel'];
									$sahip_tel = str_replace('(', '', $sahip_tel);
									$sahip_tel = str_replace(')', '', $sahip_tel);
									$sahip_tel = str_replace('-', '', $sahip_tel);
									$sahip_tel = "9" . $sahip_tel;
									?>
									<a target="_blank" href="https://wa.me/?phone=<?= $sahip_tel ?>&text=<?= $lnkle ?>">
										<div class="car_detail_contact_icon">
											<img src="assets/whatsapp_logo.png" />
										</div>
									</a>
								<?php } ?>
							</div>
						</div>
					</div>
					<!-- CAR DETAIL TEXT OUTER KAPANIŞ -->
					<?php
					$sigorta_aciklama = $iln_sigorta_listele->sigorta_aciklamasi;
					$getNot = $ilani_oku['notlar'];
					$getHasar = $ilani_oku['hasar_bilgileri'];
					$getAciklama = $ilani_oku['uyari_notu'];
					$setNot = strip_tags($getNot);
					$setHasar = strip_tags($getHasar);
					$setAciklama = strip_tags($getAciklama);
					?>
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mh10p5" style="margin-top:15px;display: <?php if ($ilani_oku["hasar_bilgileri"] == "") { echo 'none'; } ?>">
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 car_detail_content_title">
							HASAR BİLGİLERİ
						</div>
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 car_detail_content_box">
							<?= $ilani_oku["hasar_bilgileri"] ?>
						</div>
					</div>
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mh10p5" style="margin-top:15px;display: <?php if ($ilani_oku["notlar"] == "") { echo 'none'; } ?>">
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 car_detail_content_title">
							NOTLAR
						</div>
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 car_detail_content_box">
							<?= $getNot ?>
						</div>
					</div>
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mh10p5" style="margin-top:15px;display: <?php if ($ilani_oku["donanimlar"] == "") {echo 'none';} ?>">
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 car_detail_content_title">
							DONANIMLAR
						</div>
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 car_detail_content_box">
							<?= $ilani_oku["donanimlar"] ?>
						</div>
					</div>
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mh10p5" style="margin-top:15px;display: <?php if ($sigorta_aciklama == "") { echo 'none'; } ?>">
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 car_detail_content_title">
							İHALE AÇIKLAMALARI
						</div>
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 car_detail_content_box">
							<?= $sigorta_aciklama ?>
						</div>
					</div>
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 car_detail_bottom_social">
						<a data-sharer="facebook" data-hashtag="Pert Dünyası" data-url="<?= $actual_link ?>">
							<span>
								<i class="fab fa-facebook-f"></i>
							</span>
						</a>
						<!-- <a href="https://www.facebook.com/sharer/sharer.php?u=https://ihale.pertdunyasi.com/arac_detay.php?id=184&q=ihale" target="_blank">
								<span>
									<i class="fab fa-facebook-f"></i>
								</span>
							</a> -->
						<a data-sharer="twitter" data-title="Pert Dünyası" data-hashtags="hasarlioto, pertdunyasi" data-url="<?= $actual_link ?>">
							<span>
								<i class="fab fa-twitter"></i>
							</span>
						</a>
						<!-- <a href="https://twitter.com/share?url=<?= $actual_link ?>&text=Pert Dünyası" target="_blank">
								<span>
									<i class="fab fa-twitter"></i>
								</span>
							</a> -->
						<a href="https://www.instagram.com/sharer/sharer.php?u=https://ihale.pertdunyasi.com/arac_detay.php?id=184&q=ihale" target="_blank">
							<span>
								<i class="fab fa-instagram"></i>
							</span>
						</a>
					</div>
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 car_detail_bottom_counter">
						<?php
						$sorgu_goruntulenme = mysql_query("SELECT * FROM ihale_goruntulenme where ilan_id='" . $ihaleID . "' ");
						$cek_goruntulenme = mysql_num_rows($sorgu_goruntulenme);
						?>
						<h3>Görüntülenme Sayısı</h3>
						<h4><?= $cek_goruntulenme ?></h4>
					</div>
				</div>
				<div id="lightgallery" style="display:none;">
					<?php echo $lightgallery_images; ?>
				</div>
		</div>
		</div>
		<div class="row mt-2" style="text-align:center;width:100%">
		</div>
	<?php } ?>
	</div>
<?php }
	} elseif ($cekilecek == "dogrudan") { ?>
<?php while ($dogrudan_oku = mysql_fetch_array($dogrudan_cek)) {
			if ($_SESSION['u_token'] != "" && $_SESSION['k_token'] == "") {
				$favli_mi = mysql_query("SELECT * FROM favoriler WHERE user_token = '" . $_SESSION['u_token'] . "' AND dogrudan_satisli_id = '" . $dogrudan_oku['id'] . "'");
				$favli_say = mysql_num_rows($favli_mi);
				if ($favli_say == 0) {
					$fav_color = "gray";
					$fav_title = "Araç favorilerinize eklenecektir.";
				} else {
					$fav_color = "orange";
					$fav_title = "Araç favorilerinizden kaldırılacaktır.";
				}
			} else if ($_SESSION['u_token'] == "" && $_SESSION['k_token'] != "") {
				$favli_mi = mysql_query("SELECT * FROM favoriler WHERE kurumsal_token = '" . $_SESSION['k_token'] . "' AND dogrudan_satisli_id = '" . $dogrudan_oku['id'] . "'");
				$favli_say = mysql_num_rows($favli_mi);
				if ($favli_say == 0) {
					$fav_color = "gray";
					$fav_title = "Araç favorilerinize eklenecektir.";
				} else {
					$fav_color = "orange";
					$fav_title = "Araç favorilerinizden kaldırılacaktır.";
				}
			} else {
				$fav_color = "gray";
				$fav_title = "Araç favorilerinize eklenecektir.";
			}
			if ($_SESSION['u_token'] != "" && $_SESSION['k_token'] == "") {
				$renkli_uye_bul = mysql_query("SELECT * FROM user WHERE user_token = '" . $_SESSION['u_token'] . "'");
				$renkli_uye_oku = mysql_fetch_assoc($renkli_uye_bul);
				$renkli_uye_id = $renkli_uye_oku['id'];
				$bildirimli_mi = mysql_query("SELECT * FROM bildirimler WHERE uye_id = '" . $renkli_uye_id . "' AND dogrudan_satisli_id = '" . $dogrudan_oku['id'] . "'");
				$bildirimli_say = mysql_num_rows($bildirimli_mi);
				if ($bildirimli_say == 0) {
					$bidlirim_color = "gray";
					$bildirim_title = "Araç bildimleri açılacaktır";
				} else {
					$bidlirim_color = "orange";
					$bildirim_title = "Araç bildimleri kapatılacaktır";
				}
			} else if ($_SESSION['u_token'] == "" && $_SESSION['k_token'] != "") {
				$renkli_uye_bul = mysql_query("SELECT * FROM user WHERE kurumsal_user_token = '" . $_SESSION['k_token'] . "'");
				$renkli_uye_oku = mysql_fetch_assoc($renkli_uye_bul);
				$renkli_uye_id = $renkli_uye_oku['id'];
				$bildirimli_mi = mysql_query("SELECT * FROM bildirimler WHERE uye_id = '" . $renkli_uye_id . "' AND dogrudan_satisli_id = '" . $dogrudan_oku['id'] . "'");
				$bildirimli_say = mysql_num_rows($bildirimli_mi);
				if ($bildirimli_say == 0) {
					$bidlirim_color = "gray";
					$bildirim_title = "Araç bildimleri açılacaktır";
				} else {
					$bidlirim_color = "orange";
					$bildirim_title = "Araç bildimleri kapatılacaktır";
				}
			} else {
				$bidlirim_color = "gray";
				$bildirim_title = "Araç bildimleri açılacaktır";
			}
			if ($dogrudan_oku['profil'] == "Hurda Belgeli") {
				$blink = "blink";
			}
			$dogrudanID = $dogrudan_oku['id'];
			$dogrudan_resim_cek = mysql_query("SELECT * FROM dogrudan_satisli_resimler WHERE ilan_id = '" . $dogrudanID . "' ");
			$dogrudan_resim_cek2 = mysql_query("SELECT * FROM dogrudan_satisli_resimler WHERE ilan_id = '" . $dogrudanID . "' ");
			$dogrudan_resim_sayisi = mysql_num_rows($dogrudan_resim_cek);
?>
	<div class="modal fade" id="mesajYaz" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="container">
					<form method="POST">
						<div class="modal-body">
							<div class="row mt-2">
								<div class="col">
									<h6 style="text-align: center; font-size:10px;">Mesaj Yaz</h6>
								</div>
							</div>
							<div class="row mt-2">
								<div class="col">
									<label for="IDofInput">Mesaj</label>
									<textarea style="width:100%;" name="gonderilecek_mesaj" id="gonderilecek_mesaj" rows="3"></textarea>
								</div>
							</div>
							<div class="row mt-2">
								<div class="col">
									<button type="button" onclick="mesajGonder2()" class="btn btn-dark btn-block">Gönder</button>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	<?php
			if (isset($_POST['favla'])) {
				$date = date('Y-m-d H:i:s');
				$id = $_POST['favlanacak'];
				if ($_SESSION['u_token'] != "" && $_SESSION['k_token'] == "") {
					$favi_cek = mysql_query("SELECT * FROM user WHERE user_token = '" . $uye_token . "'");
					while ($favi_oku = mysql_fetch_array($favi_cek)) {
						$uyeninID = $favi_oku['id'];
						$favlamismi_cek = mysql_query("SELECT * FROM favoriler WHERE dogrudan_satisli_id = '" . $id . "' AND uye_id = '" . $uyeninID . "'");
						$favlamismi_sayi = mysql_num_rows($favlamismi_cek);
						if ($favlamismi_sayi == 0) {
							mysql_query("INSERT INTO `favoriler` (`ilan_id`, `dogrudan_satisli_id`, `uye_id`, `favlama_zamani`, `user_token`) VALUES ('', '" . $id . "', '" . $uyeninID . "', '" . $date . "', '" . $uye_token . "');");
							echo '<script> alert("İlan Favorilerinize Eklendi")</script>';
							echo '<script> window.location.href = "arac_detay.php?id=' . $id . '&q=dogrudan";</script>';
						} else {
							mysql_query("DELETE FROM favoriler WHERE dogrudan_satisli_id = '" . $id . "' AND uye_id = '" . $uyeninID . "'");
							echo '<script> alert("İlan Favorilerinizden Kaldırıldı")</script>';
							echo '<script> window.location.href = "arac_detay.php?id=' . $id . '&q=dogrudan";</script>';
						}
					}
				} elseif ($_SESSION['u_token'] == "" && $_SESSION['k_token'] != "") {
					$favi_cek = mysql_query("SELECT * FROM user WHERE kurumsal_user_token = '" . $uye_token . "'");
					while ($favi_oku = mysql_fetch_array($favi_cek)) {
						$uyeninID = $favi_oku['id'];
						$favlamismi_cek = mysql_query("SELECT * FROM favoriler WHERE dogrudan_satisli_id = '" . $id . "' AND uye_id = '" . $uyeninID . "'");
						$favlamismi_sayi = mysql_num_rows($favlamismi_cek);
						if ($favlamismi_sayi == 0) {
							mysql_query("INSERT INTO `favoriler` (`ilan_id`, `dogrudan_satisli_id`, `uye_id`, `favlama_zamani`,`kurumsal_token`) VALUES ('', '" . $id . "', '" . $uyeninID . "', '" . $date . "','" . $uye_token . "');");
							echo '<script> alert("İlan Favorilerinize Eklendi")</script>';
							echo '<script> window.location.href = "arac_detay.php?id=' . $id . '&q=dogrudan";</script>';
						} else {
							mysql_query("DELETE FROM favoriler WHERE dogrudan_satisli_id = '" . $id . "' AND uye_id = '" . $uyeninID . "'");
							echo '<script> alert("İlan Favorilerinizden Kaldırıldı")</script>';
							echo '<script> window.location.href = "arac_detay.php?id=' . $id . '&q=dogrudan";</script>';
						}
					}
				}
			}
			if (isset($_POST['d_bildirim_ac'])) {
				$date = date('Y-m-d H:i:s');
				$id = $_POST['d_bildirimlenecek'];
				if ($_SESSION['u_token'] != "" && $_SESSION['k_token'] == "") {
					$bildirim_cek = mysql_query("SELECT * FROM user WHERE user_token = '" . $uye_token . "'");
					while ($bildirim_oku = mysql_fetch_array($bildirim_cek)) {
						$uyeninID = $bildirim_oku['id'];
						$bildirim_varmi = mysql_query("SELECT * FROM bildirimler WHERE dogrudan_satisli_id = '" . $id . "' AND uye_id = '" . $uyeninID . "'");
						$bildirimini_say = mysql_num_rows($bildirim_varmi);
						if ($bildirimini_say == 0) {
							mysql_query("INSERT INTO `bildirimler` (`dogrudan_satisli_id`, `uye_id`, `bildirim_zamani`, `user_token`) VALUES ('" . $id . "', '" . $uyeninID . "', '" . $date . "', '" . $uye_token . "');");
							echo '<script> alert("Bildirimler açıldı");</script>';
							echo '<script> window.location.href = "arac_detay.php?id=' . $id . '&q=dogrudan";</script>';
						} else {
							mysql_query("DELETE FROM bildirimler WHERE dogrudan_satisli_id = '" . $id . "' AND uye_id = '" . $uyeninID . "'");
							echo '<script> alert("Bildirimler kapatıldı");</script>';
							echo '<script> window.location.href = "arac_detay.php?id=' . $id . '&q=dogrudan";</script>';
						}
					}
				} elseif ($_SESSION['u_token'] == "" && $_SESSION['k_token'] != "") {
					$bildirim_cek = mysql_query("SELECT * FROM user WHERE kurumsal_user_token = '" . $uye_token . "'");
					while ($bildirim_oku = mysql_fetch_array($bildirim_cek)) {
						$uyeninID = $bildirim_oku['id'];
						$bildirim_varmi = mysql_query("SELECT * FROM bildirimler WHERE dogrudan_satisli_id = '" . $id . "' AND uye_id = '" . $uyeninID . "'");
						$bildirimini_say = mysql_num_rows($bildirim_varmi);
						if ($bildirimini_say == 0) {
							mysql_query("INSERT INTO `bildirimler` (`dogrudan_satisli_id`, `uye_id`, `bildirim_zamani`, `user_token`) VALUES ('" . $id . "', '" . $uyeninID . "', '" . $date . "', '" . $uye_token . "');");
							echo '<script> alert("Bildirimler açıldı")</script>';
							echo '<script> window.location.href = "arac_detay.php?id=' . $id . '&q=dogrudan";</script>';
						} else {
							mysql_query("DELETE FROM bildirimler WHERE dogrudan_satisli_id = '" . $id . "' AND uye_id = '" . $uyeninID . "'");
							echo '<script> alert("Bildirimler kapatıldı")</script>';
							echo '<script> window.location.href = "arac_detay.php?id=' . $id . '&q=dogrudan";</script>';
						}
					}
				}
			}
	?>
	<?php
			$image_list = array();
			while ($dogrudan_resim_oku = mysql_fetch_array($dogrudan_resim_cek)) {
				array_push($image_list, $dogrudan_resim_oku['resim']);
			}
			$mini_images = '';
			$say = 0;
			for ($i = 0; $i <= count($image_list); $i++) {
				if ($image_list[$i] != "") {
					$selected = '';
					if ($say == 0) {
						$selected = 'car_select_image';
					}
					$mini_images .= '<div class="car_detail_mini_images_box">
						<div class="car_detail_mini_images ' . $selected . '" style="background-image:url(\'images/' . $image_list[$i] . '\')" id="car_mini_image' . $i . '" onclick="carDetailImage(' . $i . ',\'' . $image_list[$i] . '\')"></div>
					</div>';
					$lightgallery_images .= '<a href="images/' . $image_list[$i] . '" data-lg-size="1600-2400" id="galleryImage' . $i . '">
						<img src="images/' . $image_list[$i] . '" />
					</a>';
					$say++;
				}
			}
	?>
	<?php 
		$arac_sahibi = mysql_query("select * from user where user_token = '" . $dogrudan_oku['ilan_sahibi'] . "'");
		$kontrol = mysql_num_rows($arac_sahibi);
		if ($kontrol == 0) {
			$aracin_sahibi = mysql_query("select * from user where kurumsal_user_token = '" . $dogrudan_oku['ilan_sahibi'] . "'");
			if(mysql_num_rows($aracin_sahibi) != 0){
				$sahip_oku = mysql_fetch_array($aracin_sahibi);
				$ilan_sahibi = $sahip_oku["unvan"] . " / " . $sahip_oku["ad"];
				$ilan_email = $sahip_oku["mail"];
				$ilan_telofon = $sahip_oku["telefon"];
			}else{
				$aracin_sahibi = mysql_query("select * from kullanicilar where token = '" . $dogrudan_oku['ilan_sahibi'] . "'");			
				$sahip_oku = mysql_fetch_array($aracin_sahibi);
				$ilan_sahibi = "Pert Dünyası";
				$ilan_email = "info@pertdunyasi.com";
				$ilan_telofon = $sahip_oku["tel"];
			}
		}else {
			$aracin_sahibi = mysql_query("select * from user where user_token = '" . $dogrudan_oku['ilan_sahibi'] . "'");
			$sahip_oku = mysql_fetch_array($aracin_sahibi);
			$ilan_sahibi = $sahip_oku["ad"];
			$ilan_email = $sahip_oku["mail"];
			$ilan_telofon = $sahip_oku["telefon"];
		}


	?>
	<?php
		$lnkle = "https://ihale.pertdunyasi.com/arac_detay.php?id=" . re("id") . "%26q=" . re("q");
		$sahip_tel = $ilan_telofon;
		$sahip_tel = str_replace('(', '', $sahip_tel);
		$sahip_tel = str_replace(')', '', $sahip_tel);
		$sahip_tel = str_replace('-', '', $sahip_tel);
		$sahip_tel = "9" . $sahip_tel;
	?>
	<?php
		$dogrudan_hasar_cek = mysql_query("Select * from dogrudan_satisli_ilanlar where id='" . $gelen_id . "' ");
		$dogrudan_hasar_oku = mysql_fetch_assoc($dogrudan_hasar_cek);
		$hasarlar = $dogrudan_hasar_oku["hasar_durumu"];
		$hasar_parcala = explode("|", $hasarlar);
		$dizi = array();
		if (in_array(1, $hasar_parcala)) {
			$hasar = "Çarpma,Çarpışma";
			array_push($dizi, $hasar);
		}
		if (in_array(2, $hasar_parcala)) {
			$hasar = "Teknik Arıza";
			array_push($dizi, $hasar);
		}
		if (in_array(3, $hasar_parcala)) {
			$hasar = "Sel/Su Hasarı";
			array_push($dizi, $hasar);
		}
		if (in_array(4, $hasar_parcala)) {
			$hasar = "Yanma Hasarı";
			array_push($dizi, $hasar);
		}
		if (in_array(5, $hasar_parcala)) {
			$hasar = "Çalınma";
			array_push($dizi, $hasar);
		}
		if (in_array(6, $hasar_parcala)) {
			$hasar = "Diğer";
			array_push($dizi, $hasar);
		}
		if (in_array(7, $hasar_parcala)) {
			$hasar = "Hasarsız";
			array_push($dizi, $hasar);
		}
	?>
	<div class="row arac_detail_top" style="height: 120px !important;"></div>
	<div class="container arac_detail">
		<div class="row d-flex justify-content-center">
			<input type="hidden" id="ilanID" value="<?= $dogrudan_oku["id"] ?>" />
			<input type="hidden" id="ihaleSahibi" value="<?= $dogrudan_oku['ilan_sahibi'] ?>">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 car_detail_top">
				<span style="display:<?php if ($dogrudan_oku["plaka"] == "") { echo ('none'); } ?>">Plaka : <b><?= $dogrudan_oku["plaka"] ?></b></span>
				<span style="display:<?php if ($dogrudan_oku["arac_kodu"] == "") { echo ('none'); } ?>">Araç Kodu : <b>#<?= $dogrudan_oku["arac_kodu"] ?></b></span>
				<span style="display:<?php if ($dogrudan_oku["bitis_tarihi"] == "") { echo ('none'); } ?>">Yayınlanma Tarihi : <b style="color:#000;"><?= date("d-m-Y", strtotime($dogrudan_oku["eklenme_tarihi"])) ?></b></span>
				<a href="https://www.sahibinden.com/vasita?query_text_mf=<?= $dogrudan_oku['model_yili'] ?>+<?= $dogrudan_oku['marka'] ?>+<?= $dogrudan_oku['model'] ?>&query_text=<?= $ilani_oku['model_yili'] ?>+<?= $marka_adi2 ?>+<?= $dogrudan_oku['model'] ?>">
					<div class="car_detail_top_btn" style="background-image:url('assets/sahibinden_logo2.png'); margin-left:15px;" data-toggle="tooltip" data-placement="bottom" title="Benzer ilanlara buradan ulaşabilirsiniz."></div>
				</a>
				<div onclick="dogrudan_favla(<?= $dogrudan_oku['id'] ?>)" class="car_detail_top_btn" data-toggle="tooltip" data-placement="bottom" title="<?= $fav_title ?>" id="favla_<?= $dogrudan_oku['id'] ?>">
					<i style="color: <?= $fav_color ?>;" class="fas fa-star"></i>
					<input type="hidden" name="favlanacak" value="<?= $dogrudan_oku['id'] ?>">
				</div>
			</div>
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 car_detail_title">
				<i class="fas fa-car"></i> <?= $dogrudan_oku["model_yili"] . " " . $dogrudan_oku["marka"] . " " . $dogrudan_oku["model"] ?>
			</div>
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 car_detail_content_outer">
				<div class="col-xs-12 col-sm-12 col-md-7 col-lg-7 car_detail_images_outer">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mh10p5">
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 card_detail_big_image">
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 card_detail_big_image" id="car_detail_big_image" style="background-image:url('images/<?php echo $image_list[0]; ?>')" onclick="openGallery()">
							</div>
							<div class="car_detail_image_arrows" onclick="carSliderPrev()">
								<i class="fas fa-chevron-left"></i>
							</div>
							<div class="car_detail_image_arrows" onclick="carSliderNext()">
								<i class="fas fa-chevron-right"></i>
							</div>
						</div>
					</div>
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 car_detail_mini_images_outer">
						<input type="hidden" id="carDetailSelectImage" value="0" />
						<input type="hidden" id="carDetailImageCount" value="<?php echo $say; ?>" />
						<?php echo $mini_images; ?>
					</div>
				</div>
				<div class="col-xs-12 col-sm-12 col-md-5 col-lg-5 car_detail_text_outer">
					<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 mh10p5">
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 car_detail_mini_text">
							İl / İlçe
						</div>
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 car_detail_button">
							<?= $dogrudan_oku["sehir"] . " / " . $dogrudan_oku['ilce'] ?>
						</div>
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 car_detail_button" data-toggle="modal" data-target="#mesajYaz" style="cursor: pointer;">
							<i class="fas fa-envelope"></i> Mesaj Yaz
						</div>
					</div>
					<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 mh10p5">
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 car_detail_mini_text">
							Satış Fiyatı
						</div>
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 car_detail_button" style="background-color:#ff7f27;">
							<?= money($dogrudan_oku["fiyat"]) ?>₺
						</div>
						<a href="tel:<?= $sahip_oku['telefon'] ?> ">
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 car_detail_button" style="background-color:#22b14c;">
								İlan Sahibini Ara
							</div>
						</a>
					</div>
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mh10p5" style="margin-top:15px;">
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 car_detail_content_title">
							İLAN SAHİBİ
						</div>
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 car_detail_content_box" style="display:flex; align-items:center; justify-content:center;">
							<div class="car_detail_contact_content">
								<h3><?= $ilan_sahibi ?></h3>
								<h4 style="font-weight: 400;">Bilgi İçin İletişime Geçiniz</h4>
								<a href="tel:<?= $ilan_telofon ?>">
									<h5 style="font-weight: 400;"><i class="fas fa-phone"></i> <?= $ilan_telofon ?></h5>
								</a>
								<a href="mailto:<?= $ilan_email ?>">
									<h5 style="font-weight: 400;"><i class="fas fa-envelope"></i> <?= $ilan_email ?></h5>
								</a>
							</div>
							<div class="car_detail_contact_icon">
								<a target="_blank" href="https://wa.me/?phone=<?= $sahip_tel ?>&text=<?= $lnkle ?>"><img src="assets/whatsapp_logo.png" /></a>
							</div>
						</div>
					</div>
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mh10p5" style="margin-top:15px;">
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 car_detail_content_title">
							DETAYLAR
						</div>
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 car_detail_content_box">
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 car_detial_content_list">
								<b>YAYIN BİTİŞ :</b>
								<uk style="font-weight: 400;"><?= date("d-m-Y", strtotime($dogrudan_oku["bitis_tarihi"])) ?></uk>
							</div>
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 car_detial_content_list" style="display:<?php if ($dogrudan_oku["sehir"] == "") { echo "none"; } else { echo "block"; } ?>">
								<b>İL :</b>
								<uk style="font-weight: 400;"><?= $dogrudan_oku["sehir"] ?></uk>
							</div>
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 car_detial_content_list" style="display:<?php if ($dogrudan_oku["evrak_tipi"] == "") { echo "none"; } else { echo "block"; } ?>">
								<b>PROFİL :</b>
								<uk style="font-weight: 400;"><?= $dogrudan_oku["evrak_tipi"] ?></uk>
							</div>
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 car_detial_content_list" style="display:<?php if ($dogrudan_oku["yakit_tipi"] == "") { echo "none"; } else { echo "block"; } ?>">
								<b>YAKIT TÜRÜ :</b>
								<uk style="font-weight: 400;"><?= $dogrudan_oku["yakit_tipi"] ?></uk>
							</div>
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 car_detial_content_list" style="display:<?php if ($dogrudan_oku["vites_tipi"] == "") { echo "none"; } else { echo "block"; } ?>">
								<b>VİTES TÜRÜ :</b>
								<uk style="font-weight: 400;"><?= $dogrudan_oku["vites_tipi"] ?></uk>
							</div>
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 car_detial_content_list" style="display:<?php if ($dogrudan_oku["kilometre"] == "") { echo "none"; } else { echo "block"; } ?>">
								<b>KİLOMETRE :</b>
								<uk style="font-weight: 400;"><?= money($dogrudan_oku["kilometre"]) ?></uk>
							</div>
						</div>
					</div>

					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mh10p5" style="margin-top:15px;display:<?php if ($dogrudan_oku["aracin_adresi"] == "") { echo "none"; } else { echo "block"; } ?>">
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 car_detail_content_title">
							ARAÇ TESLİM ADRESİ
						</div>
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 car_detail_content_box">
							<p><?= $dogrudan_oku['aracin_adresi'] ?></p>
						</div>
					</div>
				</div>
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mh10p5" style="margin-top:15px;" display:<?php if ($dogrudan_oku["aciklamalar"] == "") { echo "none"; } else { echo "block"; } ?>>
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 car_detail_content_title">
						NOTLAR
					</div>
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 car_detail_content_box">
						<?= $dogrudan_oku["aciklamalar"] ?>
					</div>
				</div>
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mh10p5" style="margin-top:15px;display:<?php if ($dogrudan_oku["hasar_durumu"] == "") { echo "none"; } else { echo "block"; }  ?>">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 car_detail_content_title">
						HASAR BİLGİLERİ
					</div>
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 car_detail_content_box">
						<?php foreach ($dizi as $dizi_yaz) {
							echo '<p>' . $dizi_yaz . '</p>';
						}
						?>
					</div>
				</div>
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 car_detail_bottom_social">
					<a data-sharer="facebook" data-hashtag="Pert Dünyası" data-url="<?= $actual_link ?>">
						<span>
							<i class="fab fa-facebook-f"></i>
						</span>
					</a>
					<a data-sharer="twitter" data-title="Pert Dünyası" data-hashtags="hasarlioto, pertdunyasi" data-url="<?= $actual_link ?>">
						<span>
							<i class="fab fa-twitter"></i>
						</span>
					</a>
					<a href="https://www.instagram.com/sharer/sharer.php?u=https://ihale.pertdunyasi.com/arac_detay.php?id=<?= $dogrudanID ?>&q=dogrudan">
						<span>
							<i class="fab fa-instagram"></i>
						</span>
					</a>
				</div>
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 car_detail_bottom_counter">
					<?php
					$sorgu_goruntulenme2 = mysql_query("SELECT * FROM dogrudan_goruntulenme where ilan_id='" . $dogrudanID . "' ");
					$cek_goruntulenme2 = mysql_num_rows($sorgu_goruntulenme2); ?>
					<h3>Görüntülenme Sayısı</h3>
					<h4><?= $cek_goruntulenme2 ?></h4>
				</div>
			</div>
			<div id="lightgallery" style="display:none;">
				<?php echo $lightgallery_images; ?>
			</div>
		</div>
	</div>
<?php } ?>

<?php } ?>
<input type="hidden" id="kullaniciToken" value="<?= $uye_token ?>">
<input type="hidden" id="ip" value="<?= GetIP() ?>">
<input type="hidden" id="tarayici" value="<?= $browser ?>">
<input type="hidden" id="isletim_sistemi" value="<?= $os ?>">
<?php
if ($uye_token == $token) {
	$uye_bul = mysql_query("SELECT * FROM user WHERE user_token = '" . $uye_token . "' LIMIT 1");
} elseif ($uye_token == $k_token) {
	$uye_bul = mysql_query("SELECT * FROM user WHERE kurumsal_user_token = '" . $uye_token . "' LIMIT 1");
}
while ($buldugunu_yaz = mysql_fetch_array($uye_bul)) {
?>
	<input type="hidden" id="uyeID" value="<?= $buldugunu_yaz['id'] ?>">
<?php } ?>
<?php include 'footer.php'; ?>
<!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/toastr/toastr.js"></script>
<script src="js/aos.js"></script>
<script src="js/main.js?v=<?= time() ?>"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
<script src="https://kit.fontawesome.com/2fdd899201.js" crossorigin="anonymous"></script>
<script>
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
	function carSliderPrev() {
		var status = document.getElementById("carDetailSelectImage").value;
		var count = document.getElementById("carDetailImageCount").value;
		if (status == 0) {
			var lastImage = Number(count) - 1;
			document.getElementById("car_mini_image" + lastImage).click();
		} else {
			var prevImage = Number(status) - 1;
			document.getElementById("car_mini_image" + prevImage).click();
		}
	}
	function carSliderNext() {
		var status = document.getElementById("carDetailSelectImage").value;
		var count = document.getElementById("carDetailImageCount").value;
		var lastImage = Number(count) - 1;
		if (status == lastImage) {
			document.getElementById("car_mini_image0").click();
		} else {
			var nextImage = Number(status) + 1;
			document.getElementById("car_mini_image" + nextImage).click();
		}
	}
	function carDetailImage(item_id, image) {
		var status = document.getElementById("carDetailSelectImage").value;
		if (status != item_id) {
			document.getElementById("car_mini_image" + item_id).classList.add("car_select_image");
			document.getElementById("car_mini_image" + status).classList.remove("car_select_image");
			document.getElementById("car_detail_big_image").style.backgroundImage = 'url(\'images/' + image + '\')';
			document.getElementById("carDetailSelectImage").value = item_id;
		}
	}
	function openGallery() {
		var status = document.getElementById("carDetailSelectImage").value;
		document.getElementById("galleryImage" + status).click();
	}
	//TEKLİF VERME
	var ihale_tur = $('#ihale_tur').val();
	function modalGonder() {
		if (ihale_tur == 1) {
			if ($('#sonTeklif').val() == 0) {
				var modalTeklif = $('#acilis_fiyati').val();
				if (modalTeklif != "") {
					document.getElementById("modalTeklif").innerHTML = formatMoney(modalTeklif) + "₺";
				} else {
					document.getElementById("modalTeklif").innerHTML = "XXX ₺";
				}
			} else if ($('#sonTeklif').val() == "") {
				document.getElementById("modalTeklif").innerHTML = "XXX ₺";
			} else {
				var modalTeklif = $('#sonTeklif').val();
				var ilanID = $('#ilanID').val();
				$.ajax({
					url: 'check.php',
					method: 'post',
					dataType: "json",
					data: {
						action: "bilgi_yenile_arac_detay",
						ilan_id: ilanID,
					},
					success: function(data) {
						if (data.ilan_status == 1 && data.user_package_status == true) {
							//document.getElementById("modalTeklif").innerHTML = formatMoney(modalTeklif) + "₺";
						} else {
							document.getElementById("modalTeklif").innerHTML = '<i style="color:#000" class="fas fa-lock"></i>'
						}
					}
				});
			}
		} else {
			var modalTeklif = $('#acilis_fiyati').val();
			if ($('#acilis_fiyati').val() != "") {
				document.getElementById("modalTeklif").innerHTML = formatMoney(modalTeklif) + "₺";
			} else {
				document.getElementById("modalTeklif").innerHTML = "XXX ₺";
			}
		}
	}
	function denem() {
		var girilen_teklif = $("#girilen_teklif").val();
		var kullaniciToken = $('#kullaniciToken').val();
		var ilanID = $('#ilanID').val();
		var uyeID = $('#uyeID').val();
		var ip = $('#ip').val();
		var tarayici = $('#tarayici').val();
		var isletim_sistemi = $('#isletim_sistemi').val();
		var verilen_teklif = $('#verilen_teklif').val();
		var hizmet_bedel = parseInt($('#hizmet_bedel').val());
		if ($('#sozlesme_kontrol').is(':checked') == true) {
			var sozlesme_kontrol = 1;
		} else {
			var sozlesme_kontrol = 0;
		}
		if (verilen_teklif == '') {
			alert('Lütfen teklifinizi giriniz.');
		} else {
			$.ajax({
				url: 'teklif_ver.php',
				method: 'post',
				dataType: "json",
				data: {
					action: "teklif_ver",
					verilen_teklif: verilen_teklif,
					ilanID: ilanID,
					uye_token: "<?= $uye_token ?>",
					ip: ip,
					hizmet_bedel: hizmet_bedel,
					tarayici: tarayici,
					isletim_sistemi: isletim_sistemi,
					sozlesme_kontrol: sozlesme_kontrol,
				},
				success: function(data) {
					if (data.status == 200) {
						alert(data.message);
						location.reload();
					} else {
						alert(data.message);
					}
				}
			});
		}
	}
	var ilan_id = $('#ilanID').val();
	var uye_id = $('#uyeID').val();

	function teklif_kontrol() {
		$.ajax({
			url: 'teklif_ver.php',
			method: 'post',
			dataType: "json",
			data: {
				action: "teklif_kontrol",
				ilanID: ilan_id,
				teklif: $('#girilen_teklif').val(),
				uye_token: "<?= $uye_token ?>",
			},
			success: function(data) {
				if (data.status != 200) {
					$("#teklif_kontrol").html(data.message);
					$("#teklif_kontrol").css("color", "red");
					$("#TeklifVer").attr('disabled', true);
				} else {
					$("#teklif_kontrol").html("");
					$("#TeklifVer").attr('disabled', false);
				}
			},
		});
	}
	$('#girilen_teklif').on('keyup', function() {
		teklif_kontrol();
	});
	function komisyon_kontrol() {
		var hesaplama = document.getElementById('hesaplama').value;
		var girilen_teklif = parseInt(document.getElementById('girilen_teklif').value);
		$.ajax({
			url: 'teklif_ver.php',
			method: 'post',
			dataType: "json",
			data: {
				action: "komisyon_cek",
				ilan_id: ilan_id,
				girilen_teklif: girilen_teklif
			},
			success: function(data) {
				var son_komisyon = data.son_komisyon;
				if (son_komisyon == 0 || son_komisyon == undefined || son_komisyon == null || son_komisyon == "") {
					document.getElementById("hizmet_bedel").innerHTML = "" + "₺";
					document.getElementById("hizmet_bedel").value = "" + "₺";
				} else {
					document.getElementById("hizmet_bedel").innerHTML = formatMoney(son_komisyon) + "₺";
					document.getElementById("hizmet_bedel").value = son_komisyon + "₺";
				}
			},
		});

	}

	function kontrol() {
		var komisyon = document.getElementById('ilan_komisyon').value;
		var kullaniciToken = $('#kullaniciToken').val();
		document.getElementById("verilen_teklif").value = $("#girilen_teklif").val();
		document.getElementById("GelenTeklif").innerHTML = formatMoney($("#girilen_teklif").val()) + " ₺";
		if (kullaniciToken) {
			$.ajax({
				url: 'teklif_ver.php',
				method: 'post',
				dataType: "json",
				data: {
					action: "checked_kontrol",
					ilanID: ilan_id,
					uye_token: "<?= $uye_token ?>",
				},
				success: function(data) {
					console.log(data)
					if (data.status == 200) {
						$("#sozlesme_kontrol").prop('checked', true);
					} else {

						$("#sozlesme_kontrol").prop('checked', false);
					}
				},
			});
			return;
		} else {
			alert("Devam Etmek İçin Lütfen Giriş Yapın !");
			window.location.reload();
		}
	}
	//Mesaj Gönderme
	function mesajGonder() {
		var gonderilecek_mesaj = $("#gonderilecek_mesaj").val();
		var kullaniciToken = $('#kullaniciToken').val();
		var ilanID = $('#ilanID').val();
		var uyeID = $('#uyeID').val();
		var ihaleSahibi = $('#ihaleSahibi').val();
		if (gonderilecek_mesaj == '') {
			alert('Lütfen Mesajınızı Giriniz.');
		} else {
			$.ajax({
				url: 'mesaj_gonder.php',
				method: 'POST',
				dataType: 'JSON',
				data: {
					action: "mesaj_gonder",
					gonderilecek_mesaj: gonderilecek_mesaj,
					kullaniciToken: kullaniciToken,
					ilanID: ilanID,
					uye_token: "<?= $uye_token ?>",
					ihaleSahibi: ihaleSahibi
				},
				success: function(data) {
					if (data.status == 200) {
						$('.success').removeClass('d-none').html(data);
						alert("Mesajınız başarılı bir şekilde gönderildi");
						location.reload();
					} else {
						$('.success').removeClass('d-none').html(data);
						alert(data.message);
					}
				}
			});
		}
	}

	function mesajGonder2() {
		var gonderilecek_mesaj = $("#gonderilecek_mesaj").val();
		var kullaniciToken = $('#kullaniciToken').val();
		var ilanID = $('#ilanID').val();
		var uyeID = $('#uyeID').val();
		var ihaleSahibi = $('#ihaleSahibi').val();
		if (gonderilecek_mesaj == '') {
			alert('Lütfen Mesajınızı Giriniz.');
		} else {
			$.ajax({
				url: 'mesaj_gonder.php',
				method: 'POST',
				dataType: 'JSON',
				data: {
					action: "dogrudan_mesaj_gonder",
					gonderilecek_mesaj: gonderilecek_mesaj,
					kullaniciToken: kullaniciToken,
					ilanID: ilanID,
					uye_token: "<?= $uye_token ?>",
					ihaleSahibi: ihaleSahibi
				},
				success: function(data) {
					if (data.status == 200) {
						$('.success').removeClass('d-none').html(data);
						alert("Mesajınız başarılı bir şekilde gönderildi");
						location.reload();
					} else {
						$('.success').removeClass('d-none').html(data);
						alert(data.message);
					}
				}
			});
		}
	}

	function buttonClick() {
		var i = document.getElementById('verilen_teklif_hidden').value;
		var plus = parseInt(i);
		var hizli1 = document.getElementById('arti1').value;
		plus += parseInt(hizli1);
		document.getElementById('girilen_teklif').value = plus;
		document.getElementById('verilen_teklif').value = plus;
		$('#arti1').css("background-color", "#71bc42");
		$('#arti2').css("background-color", "#364d59");
		$('#arti3').css("background-color", "#364d59");
		$('#arti4').css("background-color", "#364d59");
		komisyon_kontrol();
	}

	function buttonClick2() {
		var i = document.getElementById('verilen_teklif_hidden').value;
		var plus = parseInt(i);
		var hizli2 = document.getElementById('arti2').value;
		plus += parseInt(hizli2);
		document.getElementById('girilen_teklif').value = plus;
		document.getElementById('verilen_teklif').value = plus;
		$('#arti1').css("background-color", "#364d59");
		$('#arti2').css("background-color", "#71bc42");
		$('#arti3').css("background-color", "#364d59");
		$('#arti4').css("background-color", "#364d59");
		komisyon_kontrol();
	}


	function ButtonClick() {
		var i = document.getElementById('verilen_teklif_hidden').value;
		var plus = parseInt(i);
		var hizli2 = document.getElementById('arti2').value;
		plus += parseInt(hizli2);
		document.getElementById('girilen_teklif').value = plus;
		document.getElementById('verilen_teklif').value = plus;
		komisyon_kontrol();
	}

	function clickButton() {
		var i = document.getElementById('verilen_teklif_hidden').value;
		var plus = parseInt(i);
		var hizli3 = document.getElementById('arti3').value;
		plus += parseInt(hizli3);
		document.getElementById('girilen_teklif').value = plus;
		document.getElementById('verilen_teklif').value = plus;
		$('#arti1').css("background-color", "#364d59");
		$('#arti2').css("background-color", "#364d59");
		$('#arti3').css("background-color", "#71bc42");
		$('#arti4').css("background-color", "#364d59");
		komisyon_kontrol();
	}

	function clickButton2() {
		var i = document.getElementById('verilen_teklif_hidden').value;
		var plus = parseInt(i);
		var hizli4 = document.getElementById('arti4').value;
		plus += parseInt(hizli4);
		document.getElementById('girilen_teklif').value = plus;
		document.getElementById('verilen_teklif').value = plus;
		$('#arti1').css("background-color", "#364d59");
		$('#arti2').css("background-color", "#364d59");
		$('#arti3').css("background-color", "#364d59");
		$('#arti4').css("background-color", "#71bc42");
		komisyon_kontrol();
	}

	function ClickButton() {
		var i = document.getElementById('verilen_teklif_hidden').value;
		var plus = parseInt(i);
		var hizli4 = document.getElementById('arti4').value;
		plus += parseInt(hizli4);
		document.getElementById('girilen_teklif').value = plus;
		document.getElementById('verilen_teklif').value = plus;
		komisyon_kontrol();
	}

	function degerOku() {
		var deger = document.getElementById('girilen_teklif').value;
		var input = document.getElementById('verilen_teklif').value = deger;
		document.getElementById("GelenTeklif").innerHTML = formatMoney(deger) + " ₺";


	}

	function isNumberKey(evt) {
		var charCode = (evt.which) ? evt.which : event.keyCode;
		if (charCode > 31 && (charCode < 48 || charCode > 57))
			return false;
		return true;
	}

	createCountDown('sayac');
	createCountDown('modalZaman');

	

	function otomatik_sure_uzat(id) {
		var durum = false;
		jQuery.ajax({
			url: "https://ihale.pertdunyasi.com/check.php",
			type: "POST",
			dataType: "JSON",
			data: {
				action: "otomatik_sure_uzat",
				id: id
			},
			success: function(response) {
				console.log(response);
				if (status == 200) {
					durum = true;
				}
			}
		});
		return durum;
	}

	/*
	function createCountDown(elementId) {
		var zaman = document.getElementById('ihale_sayac').value;
		var id = document.getElementById('ihale_id').value;
		var uzatilma_durumu = document.getElementById('sure_uzatilma_durum').value;
		var countDownDate = new Date(zaman).getTime();
		var belirlenen = document.getElementById('belirlenen').value;
		var x = setInterval(function() {
			jQuery.ajax({
				url: "https://ihale.pertdunyasi.com/check.php",
				type: "POST",
				dataType: "JSON",
				data: {
					action: "panel_ilan_guncelle",
					kapanis_zamani: $(".kapanis_zamani").html(),
					ilan_id: id,
				},
				success: function(response) {
					// $('#ihale_sayac').val(response.arac_detay_ihale_saati);
					$('#ihale_sayac').val(response.arac_detay_ihale_saati);
					countDownDate = new Date(response.arac_detay_ihale_saati).getTime();
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
					if (hours < 10) {
						hours = "0" + hours;
					}
					if (minutes < 10) {
						minutes = "0" + minutes;
					}
					if (seconds < 10) {
						seconds = "0" + seconds;
					}
					document.getElementById(elementId).innerHTML = '<i class="fas fa-clock"></i> ' + "XX:XX:XX ";
				} else {
					if (hours < 10) {
						hours = "0" + hours;
					}
					if (minutes < 10) {
						minutes = "0" + minutes;
					}

					if (seconds < 10) {
						seconds = "0" + seconds;
					}
					$('#'+elementId).html(`<i class="fas fa-clock"></i> ${days} Gün ${hours}:${minutes}:${seconds}`);
					// document.getElementById(elementId).innerHTML = '<i class="fas fa-clock"></i> ' + days + " Gün " + hours + ":" + minutes + ":" + seconds + " ";
				}
			} else {
				if (belirlenen > 0) {
					document.getElementById(elementId).innerHTML = '<i class="fas fa-clock"></i> ' + "XX:XX:XX ";
				} else {
					document.getElementById(elementId).innerHTML = '<i class="fas fa-clock"></i> ' + "Süre Doldu";
				}
			}
			if (distance < 0) {
				clearInterval(x);
				document.getElementById(elementId).innerHTML = "Süre Doldu";
				sure_doldu(id);
				document.getElementById("TeklifVer").disabled = true;
				document.getElementById("mesajGonder").disabled = true;
				document.getElementById("girilen_teklif").disabled = true;
				document.getElementById("arti1").disabled = true;
				document.getElementById("arti2").disabled = true;
				document.getElementById("arti3").disabled = true;
				document.getElementById("arti4").disabled = true;
			}
		}, 1000);
	}
	*/


	
	function createCountDown(elementId) {
		var zaman = document.getElementById('ihale_sayac').value;
		var id = document.getElementById('ihale_id').value;
		var uzatilma_durumu = document.getElementById('sure_uzatilma_durum').value;
		var countDownDate = new Date(zaman).getTime();
		var belirlenen = document.getElementById('belirlenen').value;
		var degistir = "";
		var x = setInterval(function() {
			jQuery.ajax({
				url: "https://ihale.pertdunyasi.com/check.php",
				type: "POST",
				dataType: "JSON",
				data: {
					action: "panel_ilan_guncelle",
					kapanis_zamani: $(".kapanis_zamani").html(),
					ilan_id: id,
				},
				success: function(response) {
					// $('#ihale_sayac').val(response.arac_detay_ihale_saati);
					$('#ihale_sayac').val(response.arac_detay_ihale_saati);
					countDownDate = new Date(response.arac_detay_ihale_saati).getTime();
					if(response.suan > response.arac_detay_ihale_saati && response.suan < response.son_gosterilme){
						degistir = 0;
						document.getElementById(elementId).innerHTML = '<i class="fas fa-clock"></i> ' + "XX:XX:XX";
					}else{
						// document.getElementById(elementId).innerHTML = '<i class="fas fa-clock"></i> ' + "Süre Doldu";
						degistir = 1;
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
					if (hours < 10) {
						hours = "0" + hours;
					}
					if (minutes < 10) {
						minutes = "0" + minutes;
					}
					if (seconds < 10) {
						seconds = "0" + seconds;
					}
					document.getElementById(elementId).innerHTML = '<i class="fas fa-clock"></i> ' + "XX:XX:XX ";
				} else {
					if (hours < 10) {
						hours = "0" + hours;
					}
					if (minutes < 10) {
						minutes = "0" + minutes;
					}

					if (seconds < 10) {
						seconds = "0" + seconds;
					}
					$('#'+elementId).html(`<i class="fas fa-clock"></i> ${days} Gün ${hours}:${minutes}:${seconds}`);
					// document.getElementById(elementId).innerHTML = '<i class="fas fa-clock"></i> ' + days + " Gün " + hours + ":" + minutes + ":" + seconds + " ";
				}
			} else {
				if(degistir == 1){
					if (belirlenen > 0) {
						document.getElementById(elementId).innerHTML = '<i class="fas fa-clock"></i> ' + "XX:XX:XX ";
					} else {
						document.getElementById(elementId).innerHTML = '<i class="fas fa-clock"></i> ' + "Süre Doldu";
					}
				}
				
			}
			if(degistir == 1){
				if (distance < 0) {
					clearInterval(x);
					document.getElementById(elementId).innerHTML = "Süre Doldu";
					sure_doldu(id);
					document.getElementById("TeklifVer").disabled = true;
					document.getElementById("mesajGonder").disabled = true;
					document.getElementById("girilen_teklif").disabled = true;
					document.getElementById("arti1").disabled = true;
					document.getElementById("arti2").disabled = true;
					document.getElementById("arti3").disabled = true;
					document.getElementById("arti4").disabled = true;
				}
			}
			console.log(degistir);
		}, 1000);
	}
	

	
	

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

	function enyuksek_getir() {
		jQuery.ajax({
			url: "https://ihale.pertdunyasi.com/check.php",
			type: "POST",
			dataType: "JSON",
			data: {
				action: "enyuksek_yenile_arac_detay",
				id: <?= $gelen_id ?>
			},
			success: function(response) {
				//alert(response.status);
				if (response.status == 200) {
					$('#verilen_teklif_hidden').val(response.teklif);
					if (response.en_yuksek_benim == 1) {
						$('#en_yuksek_mesaj').html("En yüksek teklif sizindir.");
					} else {
						$('#en_yuksek_mesaj').html("");
					}
					if (document.getElementById("sonTeklif").value != response.teklif) {
						openToastrDanger("En yüksek teklif fiyatı değişti.");
						$('#sonTeklif').val(response.teklif);
						document.getElementById("modalTeklif").value = parseInt(response.teklif);
						document.getElementById("modalTeklif").innerHTML = formatMoney(parseInt(response.teklif)) + "₺";
					}
					if (document.getElementById("sonTeklif").value != 0) {
						document.getElementById("sonTeklif").value = response.teklif;
						document.getElementById("sonTeklif").innerHTML = formatMoney(response.teklif) + " ₺";
					}
				}
			}
		});
	}

	$('#verilen_teklif').on('change', function() {
		document.getElementById("girilen_teklif").value = $('#verilen_teklif').val();
		document.getElementById("girilen_teklif").innerHTML = formatMoney($('#verilen_teklif').val());
		document.getElementById("GelenTeklif").value = $('#verilen_teklif').val();
		document.getElementById("GelenTeklif").innerHTML = formatMoney($('#verilen_teklif').val()) + " ₺";
		komisyon_kontrol();
	});

	$('#verilen_teklif').on('keyup', function() {
		document.getElementById("girilen_teklif").value = $('#verilen_teklif').val();
		document.getElementById("girilen_teklif").innerHTML = formatMoney($('#verilen_teklif').val());
		document.getElementById("GelenTeklif").value = $('#verilen_teklif').val();
		document.getElementById("GelenTeklif").innerHTML = formatMoney($('#verilen_teklif').val()) + " ₺";
		komisyon_kontrol();
	});

	$('#girilen_teklif').on('change', function() {
		teklif_kontrol();
	});

</script>
<script src="js/cikis_yap.js?v=<?php echo time(); ?>"></script>
<script>
	function bilgi_yenile() {
		var ilanID = $('#ilanID').val();
		$.ajax({
			url: 'check.php',
			method: 'post',
			dataType: "json",
			data: {
				action: "bilgi_yenile_arac_detay",
				ilan_id: ilanID,
			},
			success: function(data) {
				console.log(data);
				$("#modal_en_yuksek").html(data.en_yuksek_mesaj);
				$("#en_yuksek_mesaj").html(data.en_yuksek_mesaj);
				$("#en_yuksek_mesaj2").html(data.en_yuksek_mesaj2);
				if (data.ilan_status == 1 && data.user_package_status == true) {
					$("#sonTeklif").html(formatMoney(data.son_teklif) + " ₺");
					$("#modalTeklif").html(formatMoney(data.son_teklif) + " ₺");
				} else {
					$("#sonTeklif").html('<i style="color:#000" class="fas fa-lock"></i>');
					$("#modalTeklif").html('<i style="color:#000" class="fas fa-lock"></i>');
				}
			}
		});
	}
	setInterval(function() {
		cikis_yap("<?= $uye_token ?>");
	}, 300001);
	setInterval(function() {
		//bildirim_sms();bilgi_yenile(); 
	}, 1000);
	son_islem_guncelle("<?= $uye_token ?>");
</script>
<script>
	function locale_kaydet() {
		var baslat = setInterval(function() {
			teklif_kontrol();
			enyuksek_getir();
			komisyon_kontrol();
		}, 1000)
	}
	if ("<?= $cekilecek ?>" == "ihale") {
		locale_kaydet();
	} else {
		console.log("<?= $cekilecek ?> ");
	}
	$(function() {
		$('[data-toggle="tooltip"]').tooltip()
	})

	function bildirim_ac(id) {
		jQuery.ajax({
			url: 'action.php',
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
			url: 'action.php',
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

	function dogrudan_favla(id) {
		jQuery.ajax({
			url: 'action.php',
			method: 'POST',
			dataType: "JSON",
			data: {
				action: "dogrudan_favorilere_ekle",
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

	var slideIndex = 1;
	showSlides(slideIndex);

	function plusSlides(n) {
		showSlides(slideIndex += n);
	}

	function currentSlide(n) {
		showSlides(slideIndex = n);
	}

	function showSlides(n) {
		var i;
		var slides = document.getElementsByClassName("mySlides");
		var dots = document.getElementsByClassName("demo");
		var captionText = document.getElementById("caption");
		if (n > slides.length) {
			slideIndex = 1
		}
		if (n < 1) {
			slideIndex = slides.length
		}
		for (i = 0; i < slides.length; i++) {
			slides[i].style.display = "none";
		}
		for (i = 0; i < dots.length; i++) {
			dots[i].className = dots[i].className.replace(" active", "");
		}
		dots[slideIndex - 1].className += " active";
		if ($("#" + captionText).val() != undefined) {
			captionText.innerHTML = dots[slideIndex - 1].alt;
		}

	}
</script>


<script src='https://cdn.jsdelivr.net/picturefill/2.3.1/picturefill.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery-mousewheel/3.1.13/jquery.mousewheel.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/lightgallery/1.6.14/js/lightgallery-all.min.js'></script>
<script src="light_gallery/script.js?v=<?= time() ?>"></script>

</body>

</html>