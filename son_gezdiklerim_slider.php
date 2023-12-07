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
        <link rel="stylesheet" href="css/style.css?v=<?=time() ?>">
		<link rel="stylesheet" href="css/custom_slider.css?v=<?php echo time(); ?>">
        <link rel="stylesheet" href="css/custom.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.js"></script>
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    </head>
    <body>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 custom_mini_slider_outer" style="margin-top:0px;">
            <div class="custom_mini_slider_title_outer">
                SON GEZDİKLERİM
            </div>
            <div class="custom_mini_slider_boxes_outer">
                <div class="website_fullwidth_slider_contents_btn_outer">
                    <div class="website_fullwidth_slider_contents_btn_left" id="mini_slider_btn_left"></div>
                </div>
                <div class="owl-carousel owl-theme custom_mini_slider_boxes_contents">
                    <div>
                        <div class="website_fullwidth_slider_box website_fullwidth_slider_box_orange">
                            <div class="website_fullwidth_slider_box_title">
                                <i class="fas fa-stopwatch"></i> 36 Gün 01:01:08
                            </div>
                            <div class="website_fullwidth_slider_box_image" style="background-image:url('images/du829969.png');"></div>
                            <div class="website_fullwidth_slider_box_contents">
                                <h3>2018 DACIA SANDERO</h3>
                                <h4>En Yüksek</h4>
                                <h5>42.400₺</h5>
                            </div>
                        </div>
                    </div>
                    <?php 
                        for($i=0;$i<=20;$i++)
                        {
                    ?>
                            <div>
                                <div class="website_fullwidth_slider_box">
                                    <div class="website_fullwidth_slider_box_title">
                                        <i class="fas fa-stopwatch"></i> 36 Gün 01:01:08
                                    </div>
                                    <div class="website_fullwidth_slider_box_image" style="background-image:url('images/du829969.png');"></div>
                                    <div class="website_fullwidth_slider_box_contents">
                                        <h3>2018 DACIA SANDERO</h3>
                                        <h4>En Yüksek</h4>
                                        <h5>42.400₺</h5>
                                    </div>
                                </div>
                            </div>
                    <?php 
                        }
                    ?>
                </div>
                <div class="website_fullwidth_slider_contents_btn_outer">
                    <div class="website_fullwidth_slider_contents_btn_right" id="mini_slider_btn_right"></div>
                </div>
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
        <script>
            $('.website_fullwidth_slider_boxes_outer').owlCarousel({
                margin:10,
                loop:true,
                responsive:{
                    0:{
                        items:1,
                        nav:true
                    },
                    600:{
                        items:1,
                        nav:false
                    },
                    1000:{
                        items:5,
                        nav:true,
                        loop:false,
                        autoWidth:true,
                    }
                }
            })

            $('.custom_mini_slider_boxes_contents').owlCarousel({
                margin:10,
                loop:true,
                items:1
            })

            var fullwidth_slider = $('.website_fullwidth_slider_boxes_outer');

            $('#fullwidth_slider_btn_right').click(function() {
                fullwidth_slider.trigger('next.owl.carousel');
            })

            $('#fullwidth_slider_btn_left').click(function() {
                fullwidth_slider.trigger('prev.owl.carousel', [300]);
            })

            var custom_mini_slider = $('.custom_mini_slider_boxes_contents');

            $('#mini_slider_btn_right').click(function() {
                custom_mini_slider.trigger('next.owl.carousel');
            })

            $('#mini_slider_btn_left').click(function() {
                custom_mini_slider.trigger('prev.owl.carousel', [300]);
            })
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