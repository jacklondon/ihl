<?php 
	session_start();
	include 'ayar.php';
	$token = $_SESSION['u_token'];
	$k_token = $_SESSION['k_token'];
	$admin_id=$_SESSION['kid'];
	if(!empty($token)){
		$uye_token = $token; 
	}elseif(!empty($k_token)){
		$uye_token = $k_token;
	}
	$ilan_id=re("ilan_id");
		$cek = mysql_query("select * from kazanilan_ilanlar where ilan_id = '".$ilan_id."'");
		$oku = mysql_fetch_object($cek);
		$durum = $oku->durum;
		
	if($admin_id == ""){
		if($durum != 1){
			die("Bir hata ile karşılaşıldı");
		}
	}
	
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
		<link rel="stylesheet" href="css/style.css">
	</head>
		
	<body data-spy="scroll" data-target=".site-navbar-target" data-offset="300">
		<?php
			$kazanilan_ilan_sql=mysql_query("SELECT * FROM kazanilan_ilanlar WHERE ilan_id='".$ilan_id."'");
			$kazanilan_ilan_fetch=mysql_fetch_array($kazanilan_ilan_sql);
			$kazanilan_ilan_durum=$kazanilan_ilan_fetch["durum"];
			$pdf_url=$system_base_url."/images/pdf/".$kazanilan_ilan_fetch["odeme_bildirimi"];
			if($kazanilan_ilan_durum==1 || $admin_id>0 ){
				$durum=true;
			}else{
				$durum=false;
			}
			if($durum==true){ ?>
				<iframe src="http://docs.google.com/gview?url=<?=$pdf_url ?>&embedded=true"style="width:100%; height:100vh;" frameborder="0"></iframe>
			<?php } else {
				echo "<script>alert('Bu sayfaya erişim yetkiniz yoktur');</script>";
				echo "<script>window.location.href = 'index.php'</script>";
			} ?>
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