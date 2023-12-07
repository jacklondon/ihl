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
    <div class="site-wrap" id="home-section">
        <div class="site-mobile-menu site-navbar-target">
            <div class="site-mobile-menu-header">
                <div class="site-mobile-menu-close mt-3">
                    <span class="icon-close2 js-menu-toggle"></span>
                </div>
            </div>
            <div class="site-mobile-menu-body"></div>
        </div>
                <?php include 'header.php'; ?>
              <div class="container">
            <div class="row text-center mt-5">
                <h2 class="heading-title">Üyelik Paketleri</h2>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <div class="card text-center">
                        <div class="card-body">
                        <h5 class="card-title">5000₺ <sup>Teminat</sup></h5>
                        <p class="card-text">Üyelik Ücreti <b class="extra">Yok</b></p>
                        <p class="card-text">Teminatın İadesi <b class="extra">Var</b></p>
                        <p class="card-text">Teklif Limiti <b class="extra">100.000 ₺</b></p>                          
                        </div>                        
                    </div>
                    <p class="text-center fs-1">GOLD STANDART</p>
                </div>                
                               
                <div class="col-sm-4">
                    <div class="card text-center">
                        <div class="card-body">
                        <h5 class="card-title">10000₺ <sup>Teminat</sup></h5>
                        <p class="card-text plus">Üyelik Ücreti <b class="extra">Yok</b></p>
                        <p class="card-text">Teminatın İadesi <b class="extra">Var</b></p>
                        <p class="card-text">Teklif Limiti <b class="extra">250.000 ₺</b></p>                          
                        </div>                        
                    </div>
                    <p class="text-center fs-1">GOLD PLUS</p>
                </div>                
                                
                <div class="col-sm-4">
                    <div class="card text-center">
                        <div class="card-body">
                        <h5 class="card-title">30000₺ <sup>Teminat</sup></h5>
                        <p class="card-text">Üyelik Ücreti <b class="extra">Yok</b></p>
                        <p class="card-text">Teminatın İadesi <b class="extra">Var</b></p>
                        <p class="card-text">Teklif Limiti <b class="extra">Yok</b></p>                          
                        </div>                        
                    </div>
                    <p class="text-center fs-1">GOLD EXTRA</p>
                </div>                
            </div>
        </div>

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
    <script src="js/main.js"></script>
    <script src="https://kit.fontawesome.com/2fdd899201.js" crossorigin="anonymous" ></script>
	    <script src="js/cikis_yap.js?v=<?php echo time(); ?>"></script>
	<script >
	cikis_baslat("<?=$uye_token?>");
	
	</script>
</body>
</html>