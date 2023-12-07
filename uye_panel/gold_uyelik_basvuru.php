<?php 
   session_start();
   include('../ayar.php');
    $token = $_SESSION['u_token'];
    if(!empty($token)){
      $uye_token = $token;
    }
    if(!isset($uye_token)){
      echo '<script>alert("Devam Etmek İçin Lütfen Giriş Yapın !")</script>';
      echo '<script>window.location.href = "../index.php"</script>';
	}
	$user_select=mysql_query("select * from user where user_token='".$uye_token."'");
	$user_fetch=mysql_fetch_assoc($user_select);
	$kullanici_paket=$user_fetch["paket"];
	if($kullanici_paket==21){
		echo '<script>alert("Üyeliğiniz gold üyeliktir.")</script>';
		echo '<script>window.location.href = "../index.php"</script>';	  
	}
		  
	  
include 'modal.php';

?>
<!doctype html>
<html lang="tr">
<head>
    <!-- <title>Pert &mdash; Dünyası</title> -->
    <?php
			include '../seo_kelimeler.php';
		?>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://fonts.googleapis.com/css?family=DM+Sans:300,400,700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="fonts/icomoon/style.css">

    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/bootstrap-datepicker.css">
    <link rel="stylesheet" href="../css/jquery.fancybox.min.css">
    <link rel="stylesheet" href="../css/owl.carousel.min.css">
    <link rel="stylesheet" href="../css/owl.theme.default.min.css">
    <link rel="stylesheet" href="../fonts/flaticon/font/flaticon.css">
    <link rel="stylesheet" href="../css/aos.css">

    <!-- MAIN CSS -->
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/custom.css">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.js"></script>
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <!-- price table -->

    <style>
        body{
            background:#393E46;
        }
        .card-body{
            background: #00ADB5;
            color: white;
        }
        .card-footer{
            background: white;
        }
        .text-center{
            margin-bottom: 5px;
            margin-top: 15px;
        }
        .heading-title {
            margin: auto;
            width: 50%;
            margin-top: 10%;
            margin-bottom: 3%;
            display: block;
            color: rgb(255, 255, 255);
            font-weight: 900;
        }        
        .card-title{
            display: block;
            color: white;
            font-weight: 900;
            font-size: 21px;
        }        
        .extra{
            color: white;
            font-weight: 900;
        }
        .card-text{
            margin: auto;
            margin-top: 20px;
        }
        .fs-1{
            background:#393E46;
            display: block;
            color: rgb(255, 255, 255);
            font-weight: 900;
            font-size: 20px;
            margin-top: 5px;
        }
        .plus{
            margin-top: 60px;
        }
        .card{
            transition: all 0.6s ease-in-out 0s;
        }
        .card:hover{
            border: 2px solid #f7941e;
            margin-top: -25px;
        }       
    </style>
</head>

<body data-spy="scroll" data-target=".site-navbar-target" data-offset="300">

<style>
        @media screen and (min-width: 1365px) {
          .site-navbar .site-navigation .site-menu > li > a {
            margin-left: 10px;
            margin-right: 5px;
            padding: 15px 0px;
            color: #fff !important;
            display: inline-block;
            text-decoration: none !important; 
            font-size: 15px;
          }
            .yeni{
              font-size: 20px !important;
            }
        }
        @media screen and (min-width: 1600px) {
          .site-navbar .site-navigation .site-menu > li > a {
            margin-left: 15px;
            margin-right: 10px;
            padding: 15px 0px;
            color: #fff !important;
            display: inline-block;
            text-decoration: none !important; 
            font-size: 18px;
          }
            .yeni{
              font-size: 20px !important;
              margin-left: 20px;
              margin-right: 15px;

            }
        }
        @media screen and (max-width: 1365px) {
          .site-navbar .site-navigation .site-menu > li > a {
            margin-left: 0px;
            margin-right: 4px;
            padding: 15px 0px;
            color: #fff !important;
            display: inline-block;
            text-decoration: none !important; 
            font-size: 12px;
          }
            .yeni{
              font-size: 13px !important;
            }
        }


        .header_div
        {
          display:none;
        }

        /* 06.05.2021 Düzenleme */
        body
        {
          overflow-x: hidden!important;
          padding-left: 0px!important;
          padding-right: 0px!important;
          margin: 0px!important;
          width: 100%!important;
        }

        .form-check
        {
          padding-left:0px!important;
        }

        @media screen and  (min-width: 768px)
        {
          .site-footer {
              padding: 3em 0!important;
          }
        }
        @media screen and (max-width: 600px) 
        {
          .site-navbar
          {
            padding:10px!important;
          }

          .site_logo_dis
          {
            width:70%!important;
          }

          .site-logo a img
          {
            height:40px;
          }

          .mobile_menu_dis
          {
            width:30%!important;
          }

          .site-mobile-menu
          {
            top:0px!important;
          }

          .site-menu-toggle
          {
            padding-bottom:0px!important;
          }

          .modal 
          {
            z-index: 999999;
            background-color: #0000004a;
            margin-top: 0px!important;
            padding-top: 10%;
          }

          .site-mobile-menu
          {
            height: calc(100vh + 100px);
            position: fixed;
            top: 0px!important;
            right: 0px!important;
          }

          .slide 
          {
            margin-top: -16px!important;
          }

          .header_div
          {
            width: 100%;
            height: 20px;
            margin-bottom: 15px;
            display:block;
          }

          .row
          {
            margin-left:0px!important;
            margin-right:0px!important;
          }
        }
	   .deneme p{
			margin-bottom:0px!important;
			margin-top:0px!important;
			margin-left:15px;
	   
		}

</style>
   <?php 
   	$site_acilis_popup_icin_cek = mysql_query("select * from siteye_girenler WHERE ip_adresi = '".getIP()."'");
     $site_acilis_popup_icin_say = mysql_num_rows($site_acilis_popup_icin_cek);
     $site_acilis_popup_icin_oku = mysql_fetch_assoc($site_acilis_popup_icin_cek);
     $siteye_giris_tarih = date('Y-m-d H:i:s');
     $siteye_giris_tarih_before = date("Y-m-d H:i:s", strtotime('-24 hours',strtotime($siteye_giris_tarih)));
     $sitenin_acilis_popupunu_cek = mysql_query("select * from site_acilis_popup");
     $sitenin_acilis_popupunu_say = mysql_num_rows($sitenin_acilis_popupunu_cek);
     $sitenin_acilis_popupunu_oku = mysql_fetch_assoc($sitenin_acilis_popupunu_cek);
     $sitenin_acilis_popupu = $sitenin_acilis_popupunu_oku['icerik'];
	 		if($sitenin_acilis_popupunu_oku['durum']==1){
     if($site_acilis_popup_icin_say == 0){
          $siteye_giren_ekle = mysql_query("INSERT INTO `siteye_girenler` (`id`, `ip_adresi`, `tarih`, `durum`) VALUES (NULL, '".getIP()."', '".$siteye_giris_tarih."', '1');");
			if($sitenin_acilis_popupunu_oku['buton']==1){  
			   echo '
					<script>
						var htmlContent2 = document.createElement("div");
						htmlContent2.innerHTML = `
							'.$sitenin_acilis_popupu.'
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
		   }else{
			   echo '
					<script>
						var htmlContent2 = document.createElement("div");
						htmlContent2.innerHTML = `
							'.$sitenin_acilis_popupu.'
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
				$siteye_giren_guncelle = mysql_query("update siteye_girenler set tarih = '".date('Y-m-d H:i:s')."' where ip_adresi = '".getIP()."'");
		   }  
     }else{
          if($site_acilis_popup_icin_oku['tarih'] < $siteye_giris_tarih_before){
               if($sitenin_acilis_popupunu_oku['buton']==1){  
				   echo '
						<script>
							var htmlContent2 = document.createElement("div");
							htmlContent2.innerHTML = `
								'.$sitenin_acilis_popupu.'
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
				    $siteye_giren_guncelle = mysql_query("update siteye_girenler set tarih = '".date('Y-m-d H:i:s')."' where ip_adresi = '".getIP()."'");
                  //  echo '<script type="text/javascript">alert("'.$sitenin_acilis_popupu.'");</script>';
                  //  echo "<script>window.location.href = 'hazirlaniyor.php';</script>";
               }else{
				   echo '
						<script>
							var htmlContent2 = document.createElement("div");
							htmlContent2.innerHTML = `
								'.$sitenin_acilis_popupu.'
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
while($yaz = mysql_fetch_array($sorgu)){
?>
<nav class="deneme" style="padding-bottom: 0%;width:100%; padding-top: 0%;color:<?= $yaz['yazi_renk']?>; background-color:<?= $yaz['arkaplan_renk'] ?>;padding: 0!important;">
<div class="col-sm-12" style="text-align:center; font-size: large; padding: 15px;">
		<div style="text-align:center" class="col-sm-12">
			<?= $yaz['icerik'] ?>
		</div>
	</div>
</nav>
<?php } ?>
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
    
<header class="site-navbar site-navbar-target" style="top:<?= $top ?> ;">
<div class="row align-items-center position-relative">
          <div class="col-2 ">
          </div>
          <div class="col-10 text-right" style="margin-top:1%;">
          <nav class="site-navigation text-right ml-auto d-none d-lg-block" style="margin-bottom:-4% !important; margin-top:-3% !important;" role="navigation">
              <ul class="site-menu main-menu js-clone-nav ml-auto ">
                <li style="font-size:14px;"><?php if(!isset($_SESSION['u_token'])||!isset($_SESSION['k_token'])){ ?>
                  <a href="#exampleModal2" data-toggle="modal" class="nav-link"><i style="color: gold;" class="fas fa-user"> Giris Yap</i> </a>
                  <?php }elseif($_SESSION['u_token'] != ""){ ?>
                  <a href="index.php" class="nav-link">&nbsp;Profil</a>
                  <?php }elseif($_SESSION['k_token'] != ""){ ?>
                  <a href="index.php" class="nav-link" >&nbsp;Profil</a>
                  <?php } ?>
                </li>
                <li style="font-size:14px;"><?php if(!isset($_SESSION['u_token'])||!isset($_SESSION['k_token'])){ ?>
                <a href="#exampleModal" data-toggle="modal" class="nav-link"><i style="color: gold;" class="fas fa-sign-in-alt"> </i> Uye Ol </a>
                <?php }else{ ?>
                <a href="uye_panel/islemler/logout.php" class="nav-link">&nbsp;Çıkış Yap</a>
                <?php } ?>
                </li>
              </ul>
            </nav>
          </div>
        </div>
        <div class="row align-items-center position-relative">
          <div class="col-xs-8 col-sm-3 site_logo_dis">
            <div class="site-logo">
              <a href="index.php"><img src="../images/logo2.png"></a>
            </div>
          </div>
          <div class="col-xs-4 col-sm-9 text-right mobile_menu_dis" >
            <span class="d-inline-block d-lg-none">
              <a href="#" class="text-white site-menu-toggle js-menu-toggle py-5 text-white">
                <span class="icon-menu h3 text-white"></span></a></span>
            <nav class="site-navigation text-right ml-auto d-none d-lg-block" style="font-size: 14px;" role="navigation">
              <ul class="site-menu main-menu js-clone-nav ml-auto ">
                <li style="font-size: 12px; padding:0px;" class="px-1"><a href="../index.php" class="nav-link">Ana Sayfa</a></li>
                <li style="font-size: 12px; padding:0px;"><a href="../bulletin.php">Duyurular</a></li>
                <li style="font-size: 12px; padding:0px;" class="nav-link px-1"><a href="../sss.php">Sistem Nasıl İşler?</a></li>
                <li style="font-size: 12px; padding:0px;" class="nav-link px-1"><a href="../yorumlar.php">Yorumlar</a></li>
                <li style="font-size: 12px; padding:0px;" class="nav-link px-1"><a href="../contact.php">İletişim</a></li>
                <li style="font-size: 13px;" class="nav-link yeni px-1"><a href="../ihaledeki_araclar.php">İHALEDEKİ ARAÇLAR<sup><?= $ihale_sayisi2 ?></sup></a></li>
                <li style="font-size: 13px;" class="nav-link yeni px-1"><a href="../dogrudan_satisli_araclar.php">DOĞRUDAN SATIŞ<sup><?= $dogrudan_satis_sayisi2 ?></sup></a></li>
              </ul>
            </nav>
          </div>
        </div>
    </header>
</div>


              <div class="container">
            <div class="row text-center mt-5">
                <h2 class="heading-title">Üyelik Paketleri</h2>
            </div>
            <?php $grup_cek = mysql_query("SELECT * FROM uye_grubu") ?>
            <div class="row">
              <?php while($grup_oku = mysql_fetch_array($grup_cek)){ 
                $grup_id = $grup_oku['id'];
                $uyelik_ucreti = "";
                $teminat_iadesi = "";
                $standart_teklif_limit = $grup_oku['standart_ust_limit'];
                if($standart_teklif_limit > 10000000){
                  $tekstandart_teklif_limit = "Sınırsız";
                }else{
                  $tekstandart_teklif_limit = money($grup_oku['standart_ust_limit'])."₺";
                }
				
				$lux_teklif_limit = $grup_oku['luks_ust_limit'];
                if($lux_teklif_limit > 10000000){
                  $teklux_limit = "Sınırsız";
                }else{
                  $teklux_limit = money($grup_oku['luks_ust_limit'])."₺";
                }
				
				if($grup_oku["uyelik_ucreti"]=="1"){
					$uyelik_ucreti="Var";
				}else{
					$uyelik_ucreti="Yok";
				}
				if($grup_oku["teminat_iadesi"]=="1"){
					$teminat_iadesi="Var";
				}else{
					$teminat_iadesi="Yok";
				}
				
              ?>
                <div class="col-sm-4">
                <a href="islemler/gold_uyelik_basvuru.php?id=<?= $grup_id ?>" title="Başvuru Yap">
                    <div class="card text-center">
                        <div class="card-body">
                        <h5 class="card-title"><?= $grup_oku['cayma_bedeli'] ?>₺ <sup>Teminat</sup></h5>
                        <p class="card-text">Üyelik Ücreti <b class="extra"><?=$uyelik_ucreti ?></b></p>
                        <p class="card-text">Teminatın İadesi <b class="extra"><?=$teminat_iadesi ?></b></p>
                        <p class="card-text">Standart Teklif Limiti <b class="extra"><?= $tekstandart_teklif_limit ?></b></p>                          
                        <p class="card-text">Ticari Teklif Limiti <b class="extra"><?= $teklux_limit ?></b></p>                          
                        </div>                        
                    </div>
                    </a>
                    <p class="text-center fs-1"><?= $grup_oku['grup_adi'] ?></p>
                </div>  
                <?php } ?>              
                               
                
                  
                </div>                
            </div>
        </div>

        <footer class="site-footer">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3">
                        <h2 class="footer-heading mb-4">İletişim</h2>
                        <p>Adres - Çınar Mahallesi 5003/1 Sokak No:9 Ege Plaza Daire:30 Bornova / İzmir</p>
                        <p>Sabit Hat - 0 (232) 503 80 13</p>
                        <p>Fax ve Sms - 0 (850) 303 98 69</p>
                        <p>E-mail - info@pertdunyasi.com</p>
                    </div>
                    <div class="col-lg-9 ml-auto">
                        <div class="row">
                            <div class="col-lg-3">
                                <h2 class="footer-heading mb-4">Şirketimiz</h2>
                                <ul class="list-unstyled">
                                    <li><a href="#">Hakkımızda</a></li>
                                    <li><a href="#">Iletisim</a></li>
                                    <li><a href="#">S.S.S</a></li>
                                </ul>
                            </div>
                            <div class="col-lg-3">
                                <h2 class="footer-heading mb-4">Hizmetlerimiz</h2>
                                <ul class="list-unstyled">
                                    <li><a href="#">Doğrudan Satış</a></li>
                                    <li><a href="#">Aracını Sat</a></li>
                                    <li><a href="#">Araç Değer Tespiti</a></li>
                                </ul>
                            </div>
                            <div class="col-lg-3">
                                <h2 class="footer-heading mb-4">Bayiliklerimiz</h2>
                                <ul class="list-unstyled">
                                    <li><a href="#">İzmir</a></li>
                                    <li><a href="#">İstanbul</a></li>
                                    <li><a href="#">Ankara</a></li>
                                </ul>
                            </div>
                            <div class="col-lg-3">
                                <h2 class="footer-heading mb-4">Yararli Linkler</h2>
                                <ul class="list-unstyled">
                                    <li><a href="#">Kullanim Kosul ve Sartlari</a></li>
                                    <li><a href="#">Gizlilik</a></li>
                                    <li><a href="#">Site Haritası</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-5 text-center">
                    <div class="col-md-12">
                        <div class="border-top pt-5">
                            <p>
                                Telif hakkı &copy;<script>
                                    document.write(new Date().getFullYear());
                                </script> Tüm Hakları Saklıdır <br>
                                Yazılım & Tasarim <a href="https://eabilisim.net.tr/" target="_blank">EA Bilişim
                                    Teknolojileri</a>
                            </p>
                            <img src="images/logo2.png">
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </div>
    <?php  // include 'template/footer.php'; ?>


    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/jquery.sticky.js"></script>
    <script src="js/jquery.waypoints.min.js"></script>
    <script src="js/jquery.animateNumber.min.js"></script>
    <script src="js/jquery.fancybox.min.js"></script>
    <script src="js/jquery.easing.1.3.js"></script>
    <script src="js/bootstrap-datepicker.min.js"></script>
    <script src="js/aos.js"></script>
    <script src="js/main.js"></script>
	   <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	  	  <script src="../js/cikis_yap.js?v=<?php echo time(); ?>"></script>
		<script >
		 setInterval(function() {
   cikis_yap("<?=$uye_token?>");
 }, 300001);
		   son_islem_guncelle("<?=$uye_token?>");
 setInterval(function(){ bildirim_sms(); }, 1000);
		</script>

</body>
</html>