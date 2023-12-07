<?php 
    session_start();
    $token = $_SESSION['u_token'];
    $k_token = $_SESSION['k_token'];
    if($token != "" && $k_token == "")
    {
        $uye_token = $token;
    }
    elseif($token == "" && $k_token != "")
    {
        $uye_token = $k_token;
    }
    
    include 'ayar.php';
  
    $duyuru_cek = mysql_query("SELECT * FROM duyurular WHERE durum = 1");
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
        <!-- MAIN CSS -->
        <link rel="stylesheet" href="css/style.css?v=<?=time() ?>">
        <link rel="stylesheet" href="css/metin.css?v=<?=time() ?>">
        <link rel="stylesheet" href="css/custom.css">
	    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.js"></script>
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    </head>
    <body data-spy="scroll" data-target=".site-navbar-target" data-offset="300">
        <div class="customSplashScreenOuter" style="background-image:url('images/sliders/f7470798a2c7389d43b6c8c52cc2c055.png');">
            <form method="POST" action="mobileForgotPasswordChange.php">
                <div class="customMobileLoginPageInner">
                    <img class="customMobileLoginPageLogo" src="images/logo2.png" />
                    <div class="customMobileLoginPageInputOuter">
                        <p>Şifre Sıfırlama Kodu*</p>
                        <input type="text" placeholder="Şifre Sıfırlama Kodunuzu Giriniz." />
                    </div>
                    <div class="customMobileLoginPageMiniLink">
                        <a href="">Tekrar Gönder</a>
                    </div>
                    <button class="customMobileLoginBtn">
                        Devam Et
                    </button>
                </div>
            </form>
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
	    <script>
	        setInterval(function(){
                cikis_yap("<?=$uye_token?>");
            }, 300001);
	        son_islem_guncelle("<?=$uye_token?>");
			setInterval(function(){ bildirim_sms(); }, 1000);
	    </script>
    </body>
</html>