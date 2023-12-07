<?php 
	session_start();
	include 'ayar.php';
	$token = $_SESSION['u_token'];
	$k_token = $_SESSION['k_token'];
	if(!empty($token)){
	$uye_token = $token; 
	}elseif(!empty($k_token)){
		$uye_token = $k_token;
	}
	include 'modal.php';
	include 'alert.php';
?>
<!doctype html>
<html lang="en">

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
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.js"></script>
		<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
		<!-- MAIN CSS -->
		<link rel="stylesheet" href="css/style.css?v=<?=time() ?>">
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
								$siteye_giren_guncelle = mysql_query("update siteye_girenler set tarih = '".date('Y-m-d H:i:s')."' where ip_adresi = '".getIP()."'");
							}               
						}
						  
					}
				}
			?>
			<div  class="site-section bg-light">
				<div class="container">
					<div class="row">
						<div style="margin-top:5%;"	class="col-sm-12">
							<?php
								$cek = mysql_query("SELECT * FROM hesap_bilgileri");
								while($oku = mysql_fetch_array($cek)){
									$gelen_id = $oku['id'];
									$resim_cek = mysql_query("SELECT * FROM hesap_resimler WHERE hesap_id = '".$gelen_id."'");
									echo $oku["icerik"];
								}
							?>
						</div>	
					</div>	
				</div>	
			</div>
		</div>
		<?php include "footer.php" ?>

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
		<script src="js/main.js"></script>
		<script src="https://kit.fontawesome.com/2fdd899201.js" crossorigin="anonymous" ></script>
		<script src="js/cikis_yap.js?v=<?php echo time(); ?>"></script>
		<script>
			setInterval(function() {
				cikis_yap("<?=$uye_token?>");
			}, 300001);
			son_islem_guncelle("<?=$uye_token?>");
			setInterval(function(){ bildirim_sms(); }, 1000);
		</script>
	</body>
</html>