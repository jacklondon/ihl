<?php
session_start();
include('../ayar.php');
$token = $_SESSION['k_token'];
if (!empty($token)) {
  $uye_token = $token;
}
if (!isset($uye_token)) {
  echo '<script>alert("Devam Etmek İçin Lütfen Giriş Yapın !")</script>';
  echo '<script>window.location.href = "../index.php"</script>';
}
$ihale_cek = mysql_query("SELECT * FROM ilanlar WHERE durum=1  ORDER BY ihale_tarihi DESC");
$dogrudan_cek = mysql_query("SELECT * FROM dogrudan_satisli_ilanlar");

$kullanici_cek = mysql_query("SELECT * FROM `user` WHERE kurumsal_user_token = '$uye_token' ");
$kullanici_oku = mysql_fetch_array($kullanici_cek);
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
  <link rel="stylesheet" href="css/menu.css?v=2">
  <link rel="stylesheet" href="css/dropdown.css?v=9">

  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  <title>Pert Dünyası</title>
  <style>
    .uyelik {

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

    .ilan_karti_gorsel_icerik {
      padding: 0px !important;
    }

    .ilan_karti_gorsel_icerik table {
      margin: 0px !important;
    }
  </style>
</head>

<!-- <body onload="yorum_kontrol_et()"> -->
<body>
  <?php

  $son_islem_cek = mysql_query("SELECT * FROM user WHERE kurumsal_user_token = '" . $_SESSION['k_token'] . "'");
  $son_islem_oku = mysql_fetch_assoc($son_islem_cek);
  $son_islem_zamani = $son_islem_oku['son_islem_zamani'];
  $u_paket = $son_islem_oku["paket"];

  $now = date("Y-m-d H:i:s");
  $yesterday = date("Y-m-d H:i:s", strtotime('-24 hours', strtotime($now)));

  if ($son_islem_zamani < $yesterday) {
    $popup_cek = mysql_query("SELECT * FROM uye_giris_popup where paket_id='" . $u_paket . "'");
    $popup_oku = mysql_fetch_assoc($popup_cek);
    if ($popup_oku["secilme_durumu"] == "1" && $popup_oku["durum"] == "1") {
      $giris_popup_gelen = $popup_oku['icerik'];
      echo '
				<script>
					var htmlContent2 = document.createElement("div");
					htmlContent2.innerHTML = `
						' . $giris_popup_gelen . '
					`;
					swal( {
						closeOnEsc: false,
						closeOnClickOutside: false,
						
						content:htmlContent2,
						buttons: {
							defeat: "Okudum, kabul ediyorum",
							catch: { 
								text: "İptal",
								value: "catch",
							},

						},
					})			
					.then((value) => {
							switch (value) {
								case "defeat": 
									jQuery.ajax({
										url: "https://ihale.pertdunyasi.com/check.php",
										type: "POST",
										data: {
											action: "son_islem",
											token: "' . $uye_token . '",
										},success: function(response) {
											
											location.reload();
										}
									});
								break;            
							case "catch":
								window.location.href = "../session_destroy.php";
								break;
					  
							default:
								break;
						}
					});
				</script>
			';
    }
  }


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

  $kazanilan_cek = mysql_query("select * from kazanilan_ilanlar where uye_id = '".$kullanici_oku['id']."' and durum = 3 order by e_tarih desc");
  // var_dump("select * from kazanilan_ilanlar where uye_id = '".$kullanici_oku['id']."' and durum = 3 order by e_tarih desc");
  if (mysql_num_rows($kazanilan_cek) != 0) {
    $kazanilan_oku = mysql_fetch_object($kazanilan_cek);
    $tarih = time();
    $your_date = strtotime($kazanilan_oku->e_tarih);
    $datediff = $tarih - $your_date;						
    $date_count = round($datediff / (60 * 60 * 24));

    $yorum_cek = mysql_query("select * from yorumlar where ilan_id = '".$kazanilan_id."' and uye_id = '".$uye_id."'");
    if($kazanilan_oku->modal_durum == 0 && mysql_num_rows($yorum_cek) == 0 && $date_count <= 7){

      $ilan_cek = mysql_query("select * from ilanlar where id = '".$kazanilan_oku->ilan_id."'");
      $ilan_oku = mysql_fetch_object($ilan_cek);
      $marka_cek = mysql_query("select * from marka where markaID = '".$ilan_oku->marka."'");
      $marka_oku = mysql_fetch_object($marka_cek);
      $modal_bas = '';
      $title = $ilan_oku->model_yili . '/' . $marka_oku->marka_adi . '/' . $ilan_oku->model . '/' . $ilan_oku->tip;
      $resim_cek = mysql_query("select * from ilan_resimler where ilan_id = '".$kazanilan_oku->ilan_id."' and durum = 1");
      if(mysql_num_rows($resim_cek) == 0){
        $resim_cek = mysql_query("select * from ilan_resimler where ilan_id = '".$kazanilan_oku->ilan_id."'");
      }
      $resim_oku = mysql_fetch_assoc($resim_cek);
      $resim = $resim_oku['resim'];    
      $modal_bas .= '<script>
          var htmlContent2 = document.createElement("div");
          htmlContent2.innerHTML = `
            <div style="">
              <div style="" class="row">
                <div class="col-12">
                  <center style="font-weight:bold">Yorumlarınız bizim için kıymetlidir.</center>
                  <center>Aşağıdaki alışveriş ile ilgili yorumlarınız nelerdir?<center>
                  <center>Unutmayın sizin yorumlarınız sitemizde alışveriş yapmak isteyen yeni üyelerimize yol gösterecektir.<center><br/>
                </div>
              </div>
              <div class="row">
                <div class="col-6">
                  <img style="width:100%;max-height:200px; float:left" src="../images/' . $resim . '">
                </div>
                <div style="margin-left: 0px !important;margin-right: 0px !important;" class="col-6">
                  <text>Yorumunuzu aşağıdaki alana yazabilirsiniz</text>
                  <div class="row">
                    <div class="col-12">
                      <form id="data" method="POST" >
                        <input type="hidden" name="uye_id" id="uye_id" value="' . $kullanici_oku["id"] . '" >
                        <input type="hidden" name="ilan_id" id="ilan_id" value="' . $kazanilan_oku->ilan_id . '" >
                        <textarea placeholder="İyi bir alışverişti güvenle siteden araç satın alabilirsiniz." style="width: 100%;height: 115px;font-size: 13px;" name="yorum" id="yorum"></textarea>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          `;
          swal( {
            closeOnEsc: false,
            closeOnClickOutside: false,
            title:"' . $title . '",
            content:htmlContent2,
            buttons: {
              defeat: "Daha Sonra Yaz",
              catch: {
                text: "Yorumu İlet",
                value: "catch",
              },
            },
          })
          .then((value) => {
            switch (value) {
              case "defeat": 
                $.ajax({
                  url: "https://ihale.pertdunyasi.com/check.php",
                  type: "POST",
                  dataType: "JSON",
                  data: {
                    action:"daha_sonra_yap",
                    uye_id:$("#uye_id").val(),
                    ilan_id:$("#ilan_id").val(),
                  },
                  success: function(response) {
                    alert(response.message);
                    location.reload();
                  }
                });
  
                break;            
              case "catch":
                  $.ajax({
                    url: "https://ihale.pertdunyasi.com/check.php",
                    type: "POST",
                    dataType: "JSON",
                    data: {
                      action:"modal_yorum_yap",
                      uye_id:$("#uye_id").val(),
                      ilan_id:$("#ilan_id").val(),
                      yorum:$("#yorum").val(),
                    },
                    success: function(response) {
                      alert(response.message);
                      location.reload();
                    }
                  });
                break;
              default:
                break;
            }
          });
        </script>
      ';
  
      echo $modal_bas;
    }
    
  }
  $bugun = date("Y-m-d");
  $sorgu = mysql_query("SELECT * FROM kutlama_gorseli WHERE '$bugun' < reklam_bitis AND '$bugun' >= reklam_baslangic ORDER BY id ASC LIMIT 1 ");
  while ($yaz = mysql_fetch_array($sorgu)) {
  ?>
    <nav class="deneme" style="padding-bottom: 0%;width:100%; padding-top: 0%;color:<?= $yaz['yazi_renk'] ?>; background-color:<?= $yaz['arkaplan_renk'] ?>;padding: 0!important;">
      <div class="row">
        <div class="col-sm-12" style="text-align:center; font-size: large; padding: 15px;">
          <?= $yaz['icerik'] ?>
        </div>
      </div>

    </nav>
  <?php } ?>

  <input type="hidden" id="yorum_icin_uye_id" value="<?= $kullanici_oku['id'] ?>">
  <nav class="navbar navbar-expand-md navbar-dark bg-dark " style="padding-bottom: 0%; padding-top: 0%; ">
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
          <a class="nav-link uyelik" style="font-weight:bold;color:<?= $color ?> !important;"><b><?= mb_strtoupper($paket_adi, "utf-8") ?> ÜYE</b></a>
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
          <div class="dropdown-menu" aria-labelledby="navbarDropdown">
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
  <?php
  include 'template/header.php';

  ?>

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
  <style>
    .statu_baslik {
      font-weight: bold;
      font-size: 13px;
    }

    .ilan_karti_gorsel_icerik * td {
      font-size: 13px !important;
    }

    .blink {
      animation: blinker 3s linear infinite !important;
      color: #fff !important;
      font-weight: bold !important;
      font-family: sans-serif !important;
    }

    @keyframes blinker {
      50% {
        opacity: 0;
      }
    }
  </style>

  <div class="container" style="margin-top:2%; margin-bottom:5%;">
    <div class="row">
      <div class="col-sm-4">
        <?php include 'template/sidebar.php'; ?>
      </div>
      <?php
      // $odeme_bekleyen_cek = mysql_query("SELECT * FROM kazanilan_ilanlar WHERE durum = 1 AND uye_id = '" . $kullanici_oku['id'] . "'");
      $odeme_bekleyen_cek = mysql_query("SELECT * FROM kazanilan_ilanlar LEFT JOIN ilanlar ON kazanilan_ilanlar.ilan_id = ilanlar.id 
      WHERE kazanilan_ilanlar.uye_id = '".$kullanici_oku['id']."' AND ilanlar.id = kazanilan_ilanlar.ilan_id AND kazanilan_ilanlar.durum = 1");
      $odeme_bekleyen_sayisi = mysql_num_rows($odeme_bekleyen_cek);

      ?>

      <div class="col-sm-8">
        <?php if ($odeme_bekleyen_sayisi < 1) { ?>
          <div class="alert alert-danger" role="alert">
          Bu statüye ait kazandığınız ihale bulunmamaktadır. Dilerseniz <a href="../ihaledeki_araclar.php" class="alert-link"> İhaledeki Araçlar</a> sayfasından
          beğendiğiniz araçlara yeni teklifler verebilirsiniz.
          </div>
          <?php } else {
          while ($odeme_bekleyen_oku = mysql_fetch_array($odeme_bekleyen_cek)) {
            $cek_bakam = mysql_query("select * from ilanlar where id = '" . $odeme_bekleyen_oku['ilan_id'] . "'");
            $oku_bakam = mysql_fetch_assoc($cek_bakam);
            $getMarka = mysql_query("select * from marka where markaID = '" . $oku_bakam['marka'] . "'");
            $setMarka = mysql_fetch_assoc($getMarka);
            $statu_teklif_cek = mysql_query("select * from teklifler where ilan_id = '" . $oku_bakam['id'] . "' and uye_id = '" . $kullanici_oku['id'] . "' and teklif = '" . $odeme_bekleyen_oku['kazanilan_teklif'] . "'");
            $statu_teklif_oku = mysql_fetch_assoc($statu_teklif_cek);
            $statu_resim_cek = mysql_query("select * from ilan_resimler where ilan_id = '" . $oku_bakam['id'] . "'");
            $statu_resim_say = mysql_num_rows($statu_resim_cek);
            $statu_resim_oku = mysql_fetch_assoc($statu_resim_cek);
            if ($statu_resim_say == 0) {
              $resim = "default.png";
            } else {
              $resim = $statu_resim_oku['resim'];
            }
            if(mysql_num_rows($cek_bakam) != 0){
          ?>

            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ilan_karti_dis">

              <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ilan_karti_baslik ">
                <text style="font-size:large; color: #FFFFFF; text-transform: uppercase;"><?= $oku_bakam['model_yili'] . " " . $setMarka['marka_adi'] . " " . $oku_bakam['model'] . " " . $oku_bakam['tip'] ?></text>
                <?php
                if ($odeme_bekleyen_oku['son_odeme_tarihi'] != "0000-00-00") { ?>
                  <span class="<?php if ($odeme_bekleyen_oku['son_odeme_tarihi'] < date('Y-m-d')) { echo "blink"; } ?>"> 
                    SON ÖDEME TARİHİ : <?= date("d-m-Y", strtotime($odeme_bekleyen_oku['son_odeme_tarihi'])) ?> 
                  </span>
                <?php } else { ?>
                  <span class=""> SON ÖDEME TARİHİ : </span>
                <?php }
                ?>

              </div>
              <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ilan_karti_icerik_dis">
                <div class="ilan_karti_gorsel_dis" style="background-image:url('../images/<?= $resim ?>');">
                  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ilan_karti_kod">
                    #<?= $oku_bakam['arac_kodu'] ?>
                  </div>
                </div>
                <div class="ilan_karti_gorsel_icerik">
                  <table class="table table-bordered">
                    <tbody>

                      <tr style="background-color: transparent;">
                        <td><span class="statu_baslik">İhale Kapanış Tarihi:</span> <?= date("d-m-Y H:i:s", strtotime($oku_bakam['ihale_tarihi'] . " " . $oku_bakam['ihale_saati'])) ?></td>
                        <td><span class="statu_baslik">Şehir ve Profil: </span><?= $oku_bakam['sehir'] . " / " . $oku_bakam['profil'] ?></td>
                        <td><span class="statu_baslik">Plaka:</span> <?= $oku_bakam['plaka'] ?> </td>
                      </tr>
                      <tr style="background-color: transparent;">
                        <td><span class="statu_baslik">Teklif Verdiğim Tarih:</span> <?= date("d-m-Y H:i:s", strtotime($statu_teklif_oku['teklif_zamani'])) ?> </td>
                        <td><span class="statu_baslik">Statü:</span> Ödeme Bekliyor</td>
                        <td><span class="statu_baslik">Açıklamalar:</span> <?= $odeme_bekleyen_oku['aciklama'] ?></td>
                      </tr>
                      <tr style="background-color: transparent; display:none;">
                        <td colspan=3><span class="statu_baslik">Ödeme Bildirimi:</span> <a href="<?= $system_base_url . "/odeme_bildirimi_pdf.php?ilan_id=" . $odeme_bekleyen_oku['ilan_id'] ?>" target="_blank"><text><?= $odeme_bekleyen_oku["odeme_bildirimi"] ?></text></a></td>
                      </tr>
                      <tr style="background-color: transparent;">
                        <td colspan="3">
                          <a href="<?= $system_base_url . "/odeme_bildirimi_pdf.php?ilan_id=" . $odeme_bekleyen_oku['ilan_id'] ?>" target="_blank"><button type="button" class="btn btn-primary btn-sm" style=" background-color: orange; float:right; margin-left:10px;">Ödeme Ayrıntıları</button></a>
                          <a href="../arac_detay.php?id=<?= $oku_bakam['id'] ?>&q=ihale"><button type="button" class="btn btn-sm" style="background-color: #424242; color:#ffffff; float:right;">İNCELE</button></a>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
        <?php } } } ?>
      </div>


    </div>
  </div>
  <button type="button" class="btn btn-primary" data-toggle="modal" id="yorum_modal_ac" data-target="#yorum_yap_modal" style="display: none;">
    Launch demo modal
  </button>

  <!-- Modal -->
  <div class="modal fade" id="yorum_yap_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="yorum_yapilacak_arac_bilgi"></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label for="exampleFormControlTextarea1">Yorumunuz</label>
            <textarea class="form-control" id="kazanilan_yorum" rows="3">İyi bir alışverişti. Güvenle alışveriş yapabilirsiniz.</textarea>
          </div>
        </div>
        <div class="modal-footer" id="yorum_modal_buton_area">

        </div>
      </div>
    </div>
  </div>

  <?php include 'template/footer.php'; ?>


  <script src="https://kit.fontawesome.com/2fdd899201.js" crossorigin="anonymous"></script>
  <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
    function yorum_kontrol_et() {
      var $arac = "";

      $.ajax({
        url: '../check.php',
        method: 'post',
        dataType: "json",
        data: {
          action: "ilan_yorum_icin_getir",
          uye_id: $('#yorum_icin_uye_id').val(),
        },
        success: function(response) {
          jQuery.each(response.data, function(index, value) {
            if (value.yorum_yapsin == 1) {
              $arac += value.model_yili + " " + value.marka + " " + value.model;
              $('#yorum_yapilacak_arac_bilgi').html($arac);
              $('#yorum_modal_buton_area').html(`<button type="button" class="btn btn-primary" onclick="uye_panel_yorum_yap(${value.id})">Yorum Yap</button>`);
              $('#yorum_yap_modal').css("z-index", "99999");
              $('#yorum_modal_ac').trigger("click");

            }

          });

        },
        error: function(response) {
          alert('HATA! Lütfen tekrar deneyiniz.')
        }
      });

    }

    function uye_panel_yorum_yap($ilan_id) {
      if ($('#kazanilan_yorum').val() != "") {
        $.ajax({
          url: '../check.php',
          method: 'post',
          dataType: "json",
          data: {
            action: "ilan_yorum_yap",
            uye_id: $('#yorum_icin_uye_id').val(),
            yorum: $('#kazanilan_yorum').val(),
            ilan_id: $ilan_id
          },
          success: function(response) {
            jQuery.each(response.data, function(index, value) {
              alert(value.message);
              window.location.href = 'yorumlarim.php';
            });
          },
          error: function(response) {
            alert('HATA! Lütfen tekrar deneyiniz.')
          }
        });
      } else {
        alert("Lütfen yorum yazınız");
      }
    }
  </script>

</body>

</html>