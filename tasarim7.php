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
		        if($sitenin_acilis_popupunu_oku['durum']==1)
                {
			        if($site_acilis_popup_icin_say == 0)
                    {
				        $siteye_giren_ekle = mysql_query("INSERT INTO `siteye_girenler` (`id`, `ip_adresi`, `tarih`, `durum`) VALUES (NULL, '".getIP()."', '".$siteye_giris_tarih."', '1');");
				        if($sitenin_acilis_popupunu_oku['buton']==0)
                        {  
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
                                </script>';			  
				        }
                        else
                        {
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
                                </script>';			  
                                    
					            $siteye_giren_guncelle = mysql_query("update siteye_girenler set tarih = '".date('Y-m-d H:i:s')."' where ip_adresi = '".getIP()."'");
				        }
			        }
                    else
                    {
				        if($site_acilis_popup_icin_oku['tarih'] < $siteye_giris_tarih_before)
                        {
					        if($sitenin_acilis_popupunu_oku['buton']==0)
                            {  
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
                                    </script>';			  
						
					        }
                            else
                            {
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
                                    </script>';			  
					        }               
				        }
			  
			        }
		        } 
            ?>
            <style>
                .custom_content_outer
                {
                    min-height:350px;
                    background-color:orange;
                    float:left;
                    margin-top:114px;
                }

                @media only screen and (max-width: 600px) 
                {                
                    .custom_content_outer
                    {
                        margin-top:51px;
                    }
                }
            </style>
            <div class="clearfix"></div>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 custom_content_outer">
                
            </div>
            <div class="clearfix"></div>

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