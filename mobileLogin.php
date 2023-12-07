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
            <div class="customMobileLoginPageInner">
                <img class="customMobileLoginPageLogo" src="images/logo2.png" />
                <div class="customMobileLoginPageInputOuter">
                    <p>GSM No*</p>
                    <input type="tel" name="gsm" placeholder="(---) --- -- --" maxlength="14" />
                </div>
                <div class="customMobileLoginPageInputOuter">
                    <p>Şifre*</p>
                    <input type="password" name="sifre" placeholder="Şifrenizi Giriniz" />
                </div>
                <div class="customMobileLoginPageMiniLink">
                    <a href="mobileForgotPassword.php">Şifremi Unuttum</a>
                </div>
                <button onclick="mobileLogin()" class="customMobileLoginBtn">
                    Giriş Yap
                </button>
                <a href="mobileRegister.php" class="customMobileLoginBtn" style="background-color:#f4f5fb; margin-top:20px; color:#f79518;">
                    Kayıt Ol
                </a>
            </div>
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
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.10/jquery.mask.js"></script>
        <script>
        $('input[type="tel"]').mask('0(000)000-0000');
        </script>
	    <script>
	        setInterval(function(){
                cikis_yap("<?=$uye_token?>");
            }, 300001);
	        son_islem_guncelle("<?=$uye_token?>");
			setInterval(function(){ bildirim_sms(); }, 1000);
	    </script>
        <script>
            function mobileLogin(){
                var $telefon = $('input[name="gsm"]').val();
                var $sifre = $('input[name="sifre"]').val();
                if($telefon != "" && $telefon != ""){
                    jQuery.ajax({
                    url: "https://ihale.pertdunyasi.com/action.php",
                    type: "POST",
                    dataType: "JSON",
                    data: {
                        action: "mobile_login",
                        telefon: $telefon,
                        sifre: $sifre
                    },
                    success: function(response) {      
                        localStorage.setItem('gsm',$telefon); 
                        if(response.status == 200){
                            if(response.uye_turu == 1){
                                window.location.href = 'uye_panel/success.php';
                            }else{
                                window.location.href = 'kurumsal_panel/success.php';
                            }
                        }else{
                            alert(response.message);
                            if (response.status == 301) {
                                localStorage.setItem('Onay',0);
                                localStorage.setItem('gsm',$telefon);
                                window.location.href = 'mobileRegisterCode.php';
                            }else{
                                localStorage.setItem('Onay',1);
                            }
                        }   
                    }
                });
                }else{
                    alert("Lütfen boş alan bırakmayın");
                }
                
            }
        </script>
    </body>
</html>