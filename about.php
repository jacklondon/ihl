<?php 
	session_start();
	include 'ayar.php';

	//include 'alert.php';
	$token = $_SESSION['u_token'];
	$k_token = $_SESSION['k_token'];
	if(!empty($token)){
		$uye_token = $token;
	}elseif(!empty($k_token)){
		$uye_token = $k_token;
	}
	
	$calma="";
	$bekleyen_cek = mysql_query("SELECT * FROM kazanilanlar WHERE durum=0");
	$bekleyen_say = mysql_num_rows($bekleyen_cek);
	$zil_cek = mysql_query("SELECT * FROM zil_cal");
	$zil_oku = mysql_fetch_assoc($zil_cek);
	$zil_sayi = $zil_oku['sayi'];
	
	if($bekleyen_say < $zil_sayi){ 
		$calma="cal";
	} 
?>



<!doctype html>
<html lang="tr">

<head>
	<!-- <title>Pert &mdash; Dünyası</title> -->
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
	<link rel="stylesheet" href="css/owl.carousel.min.css">
	<link rel="stylesheet" href="css/owl.theme.default.min.css">
	<link rel="stylesheet" href="fonts/flaticon/font/flaticon.css">
	<link rel="stylesheet" href="css/aos.css">

	<!-- MAIN CSS -->
	<link rel="stylesheet" href="css/style.css?v=<?=time() ?>">
	<link rel="stylesheet" href="css/custom.css">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.js"></script>
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

</head>

<body data-spy="scroll" data-target=".site-navbar-target" data-offset="300">
	<div class="site-wrap" id="home-section">
		<div class="site-mobile-menu site-navbar-target">
			<div class="site-mobile-menu-header">
				<div class="site-mobile-menu-close mt-3">
					<span class="icon-close2 js-menu-toggle"></span>
				</div>
			</div>
			<div class="site-mobile-menu-body"></div>
		</div>
		
		
		<?php 
		include 'modal.php';
		include 'header.php'; 
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
				if($sitenin_acilis_popupunu_oku['buton']==0){  
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
					if($sitenin_acilis_popupunu_oku['buton']==0){  
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
						//  $siteye_giren_guncelle = mysql_query("update siteye_girenler set tarih = '".date('Y-m-d H:i:s')."' where ip_adresi = '".getIP()."'");
					}               
				}
			  
			}
		} ?>
		<!-- <header class="site-navbar site-navbar-target" role="banner">
			<div class="container">
				<div class="row align-items-center position-relative">
					<div class="col-3 ">
						<div class="site-logo">
							<a href="index.php"><img src="images/logo2.png"></a>
						</div>
					</div>
					<div class="col-9  text-right">
						<span class="d-inline-block d-lg-none">
						<a href="#" class="text-white site-menu-toggle js-menu-toggle py-5 text-white">
						<span class="icon-menu h3 text-white"></span></a></span>
						<nav class="site-navigation text-right ml-auto d-none d-lg-block" style="font-size: 16px;" role="navigation">
							<ul class="site-menu main-menu js-clone-nav ml-auto ">
								<li class="active"><a href="index.php" class="nav-link">Ana Sayfa</a></li>
								<li><a href="bulletin.php" class="nav-link">Duyurular</a></li>
								<li><a href="about.php" class="nav-link">Hakkımızda</a></li>
								<li><a href="contact.php" class="nav-link">İletişim</a></li>
								<li><?php if(!isset($_SESSION['u_token'])||!isset($_SESSION['k_token'])){ ?>
									<a href="#exampleModal2" data-toggle="modal" class="nav-link">&nbsp;Giris Yap</a>
									<?php }elseif(isset($_SESSION['u_token'])){ ?>
										<a href="uye_panel" class="nav-link">&nbsp;Profil</a>
									<?php }elseif(isset($_SESSION['k_token'])){ ?>
										<a href="kurumsal_panel" class="nav-link" >&nbsp;Profil</a>
									<?php } ?>
								</li>
								<li><?php if(!isset($_SESSION['u_token'])||!isset($_SESSION['k_token'])){ ?>
										<a href="#exampleModal" data-toggle="modal" class="nav-link">&nbsp;Uye Ol</a>
									<?php }else{ ?>
										<a href="uye_panel/islemler/logout.php" class="nav-link">&nbsp;Çıkış Yap</a>
									<?php } ?>
								</li>       
							</ul>
						</nav>
					</div>
				</div>
			</div>
		</header> -->
		<!-- <div class="ftco-blocks-cover-1">
			<div class="ftco-cover-1 overlay innerpage" style="background-image: url('images/hero_2.jpg')">
				<div class="container">
					<div class="row align-items-center justify-content-center">
						<div class="col-lg-6 text-center">
							<h1>Hakkımızda</h1>
							<p>Lorem Ipsum, dizgi ve baskı endüstrisinde kullanılan mıgır metinlerdir. Lorem Ipsum, adı bilinmeyen bir
							matbaacının bir hurufat numune kitabı oluşturmak üzere bir yazı galerisini alarak karıştırdığı
							1500'lerden
							beri endüstri standardı sahte metinler olarak kullanılmıştır.</p>
						</div>
					</div>
				</div>
			</div>
		</div>-->
		<input type="hidden" id="zil_cal" value="<? echo $calma ?>">  
		<button onclick="playSound();" id="soundBtn">Play</button>  
		<?php $hakkimizda=mysql_fetch_object(mysql_query("select * from hakkimizda")); ?>
		<div class="site-section">
			<div class="container">
				<br><h1 style="text-align:center" > </h1><br>
				<div class="row">
					<div class="col-lg-6 mb-5 mb-lg-0 order-lg-2">
						<img src="<?=$hakkimizda->resim ?>" alt="Image" class="img-fluid">
					</div>
					<input type="hidden" role="button" id="zil_btn" onclick="playSound();">  
					<div class="col-lg-4 mr-auto">
						<h2><?=$hakkimizda->baslik ?></h2>
						<p><?=$hakkimizda->aciklama ?></p>
					</div>
				</div>
			</div>
		</div>
		<!-- <div class="site-section">
			<div class="container">
				<br><h1 style="text-align:center" >Hakkımızda</h1><br>
				<div class="row">
					<div class="col-lg-6 mb-5 mb-lg-0 order-lg-2">
						<img src="images/hero_2.jpg" alt="Image" class="img-fluid">
					</div>
					<div class="col-lg-4 mr-auto">
						<h2>Pert Dünyası</h2>
						<p>Merkezi İzmir'de bulunan Pert Dünyası siz değerli müşterilerimize piyasadan çok daha ucuz fiyatlara araç
							sahibi olabilmeniz için Sigorta Şirketleri , hasarlı oto sektöründe faaliyet gösteren diğer Kurumların
							internet üzerinden e-ihale ortamında satışa sürdüğü araçlarını Türkiye genelinde hasarlı araç alım-satım
							işi yapan Tüzel ve Gerçek kişiler adına hareket eden, yapılan çalışmalarda siz değerli müşterilerimizin
							işini kolaylaştırmak için bilgi,birikim ve fizibilite çalışmalarımız ile alıcılarımız ve Sigorta
							Şirketleri arasında işleri hem hukuksal hemde finansal açıdan kolaylaştırmak üzere kurulmuş aracı bir
							kurumdur.
						</p>
					</div>
				</div>
			</div>
		</div>-->
		<!-- <div class="site-section bg-light">
			<div class="container">
				<div class="row justify-content-center text-center mb-5 section-2-title">
					<div class="col-md-6">
						<h2 class="mb-4">Yetkililerimiz</h2>
						<p>Lorem Ipsum, dizgi ve baskı endüstrisinde kullanılan mıgır metinlerdir. Lorem Ipsum, adı bilinmeyen bir
							matbaacının bir hurufat numune kitabı oluşturmak üzere bir yazı galerisini alarak karıştırdığı 1500'lerden
							beri endüstri standardı sahte metinler olarak kullanılmıştır.</p>
					</div>
				</div>
				<div class="row align-items-stretch">
					<div class="col-lg-4 col-md-6 mb-5">
						<div class="post-entry-1 h-100 person-1">
							<img src="images/person_3.jpg" alt="Image" class="img-fluid">
							<div class="post-entry-1-contents">
								<span class="meta">MT Takım Lideri </span>
								<h2>Ayşe Akkaş</h2>
								<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ipsa, sapiente.</p>
							</div>
						</div>
					</div>
					<div class="col-lg-4 col-md-6 mb-5">
						<div class="post-entry-1 h-100 person-1">
							<img src="images/person_3.jpg" alt="Image" class="img-fluid">
							<div class="post-entry-1-contents">
								<span class="meta">Müşteri Temsilcisi </span>
								<h2>Nahide Akoğlu</h2>
								<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ipsa, sapiente.</p>
							</div>
						</div>
					</div>
					<div class="col-lg-4 col-md-6 mb-5">
						<div class="post-entry-1 h-100 person-1">
							<img src="images/person_3.jpg" alt="Image" class="img-fluid">
							<div class="post-entry-1-contents">
								<span class="meta">Müşteri Temsilcisi</span>
								<h2>Sedef Genç</h2>
								<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ipsa, sapiente.</p>
							</div>
						</div>
					</div>
					<div class="col-lg-4 col-md-6 mb-5">
						<div class="post-entry-1 h-100 person-1">
							<img src="images/person_1.jpg" alt="Image" class="img-fluid">
							<div class="post-entry-1-contents">
								<span class="meta">Kurucu</span>
								<h2>Ali Çakı </h2>
								<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ipsa, sapiente.</p>
							</div>
						</div>
					</div>
					<div class="col-lg-4 col-md-6 mb-5">
						<div class="post-entry-1 h-100 person-1">
							<img src="images/person_1.jpg" alt="Image" class="img-fluid">
							<div class="post-entry-1-contents">
								<span class="meta">Kurucu</span>
								<h2>Gürcan Cankız</h2>
								<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ipsa, sapiente.</p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>-->
	    <?php include "footer.php" ?>
	</div>
	<script src="js/jquery-3.3.1.min.js"></script>
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
	<script>
		var degisken=$('#zil_cal').val();
		if(degisken=="cal")
		{
		  performSound();
		}
		document.getElementById('soundBtn').style.visibility='hidden';
		function performSound(){
			var soundButton = document.getElementById("soundBtn");
			soundButton.click();
		}
		function playSound() {
			const audio = new Audio("https://ihale.pertdunyasi.com/panel/araclar/bildirim.mp3");
			audio.play();
		}
	</script>
	<script src="js/main.js"></script>

	<script src="https://kit.fontawesome.com/2fdd899201.js" crossorigin="anonymous" ></script>
	<script src="js/cikis_yap.js?v=<?php echo time(); ?>"></script>
	<script>
		setInterval(function() {
			cikis_yap("<?=$uye_token?>");
		}, 300001);
		son_islem_guncelle("<?=$uye_token?>");
	</script>
</body>
</html>