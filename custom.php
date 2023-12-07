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
            ?>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 site-section">
                <style>
                    .website_fullwidth_slider_outer
                    {
                        min-height:50px;
                        padding:15px;
                        margin-top:15px;
                        float:left;
                    }

                    .website_fullwidth_slider_title
                    {
                        width:100%;
                        min-height:10px;
                        float:left;
                        font-size:17px;
                        font-weight:500;
                        color:#333;
                        margin-bottom:25px;
                    }

                    .website_fullwidth_slider_title a
                    {
                        color:#333!important;
                    }

                    .website_fullwidth_slider_contnets_outer
                    {
                        width:100%;
                        min-height:100px;
                        float:left;
                        display:flex;
                        align-items:center;
                        justify-content:center;
                        gap:15px;
                    }

                    .website_fullwidth_slider_contents_left
                    {
                        width:40px;
                        height:280px;
                        background-color:#c3c3c3;
                        float:left;
                        display:flex;
                        align-items:center;
                        justify-content:center;
                    }

                    .website_fullwidth_slider_contents_left_title
                    {
                        min-width:10px;
                        height:40px;
                        float:left;
                        display:flex;
                        align-items:center;
                        justify-content:center;
                        font-size:17px;
                        font-weight:500;
                        color:#fff;
                        white-space:nowrap;
                        letter-spacing:1.5px;
                        -ms-transform: rotate(-90deg);
                        transform: rotate(-90deg);
                    }

                    .website_fullwidth_slider_contents_btn_outer
                    {
                        width:30px;
                        height:280px;
                        display:flex;
                        align-items:center;
                        justify-content:center;
                    }
                    
                    .website_fullwidth_slider_contents_btn_left
                    {
                        width:30px;
                        height:100px;
                        background-color:#e2e2e2;
                        clip-path: polygon(100% 0, 0 50%, 100% 100%);
                        cursor:pointer;
                    }

                    .website_fullwidth_slider_contents_btn_right
                    {
                        width:30px;
                        height:100px;
                        background-color:#e2e2e2;
                        clip-path: polygon(0 0, 100% 50%, 0 100%);
                        cursor:pointer;
                    }

                    .website_fullwidth_slider_boxes_outer
                    {
                        flex:1;
                        height:280px;
                        overflow:hidden;
                    }

                    .website_fullwidth_slider_box
                    {
                        width:175px;
                        height:280px;
                        background-color:#fff;
                        float:left;
                        border-bottom:4px solid #00a2e8;
                    }

                    .website_fullwidth_slider_box_title
                    {
                        width:100%;
                        height:40px;
                        background-color:#00a2e8;
                        float:left;
                        display:flex;
                        align-items:center;
                        justify-content:center;
                        font-size:13px;
                        font-weight:500;
                        color:#fff;
                        letter-spacing:0.5px;
                    }

                    .website_fullwidth_slider_box_title i
                    {
                        margin-right:5px;
                        float:left;
                        margin-top:1px;
                    }

                    .website_fullwidth_slider_box_image
                    {
                        width:100%;
                        height:115px;
                        float:left;
                        background-size:cover;
                        background-position:center;
                    }

                    .website_fullwidth_slider_box_contents
                    {
                        width:100%;
                        height:121px;
                        float:left;
                        display:flex;
                        align-items:center;
                        justify-content:center;
                        flex-direction:column;
                    }

                    .website_fullwidth_slider_box_contents h3
                    {
                        width:100%;
                        font-size:13px;
                        font-weight:500;
                        color:#333;
                        text-align:center;
                        margin:0px;
                        margin-bottom:17px;
                    }

                    .website_fullwidth_slider_box_contents h4
                    {
                        width:100%;
                        font-size:15px;
                        font-weight:300;
                        color:#333;
                        text-align:center;
                        margin:0px;
                    }

                    .website_fullwidth_slider_box_contents h5
                    {
                        width:100%;
                        font-size:13px;
                        font-weight:500;
                        color:#333;
                        text-align:center;
                        margin:0px;
                        margin-top:8px;
                    }

                    .website_fullwidth_slider_box_orange .website_fullwidth_slider_box_title
                    {
                        background-color:#ffa500!important;
                    }
                    
                    .website_fullwidth_slider_box_orange
                    {
                        border-color:#ffa500!important;
                    }
                    
                    @media only screen and (max-width: 600px) 
                    {
                        .website_fullwidth_slider_box
                        {
                            width:100%;
                        }
                    }

                    .custom_mini_slider_outer
                    {
                        min-height:50px;
                        padding:25px;
                        float:left;
                    }

                    .custom_mini_slider_title_outer
                    {
                        width:100%;
                        height:40px;
                        background-color:#c3c3c3;
                        float:left;
                        display:flex;
                        align-items:center;
                        justify-content:center;
                        font-size:17px;
                        font-weight:500;
                        color:#fff;
                        margin-bottom:20px;
                    }

                    .custom_mini_slider_boxes_outer
                    {
                        width:100%;
                        min-height:100px;
                        float:left;
                        display:flex;
                        align-items:center;
                        justify-content:center;
                        gap:15px;
                    }

                    .custom_mini_slider_boxes_contents
                    {
                        flex:1;
                        height:280px;
                        overflow:hidden;
                    }

                    .custom_mini_slider_boxes_contents * .website_fullwidth_slider_box
                    {
                        width:100%!important;
                    }
                </style>
                <div class="col-xs-12 col-sm-12 col-md-3 col-lg-4 custom_mini_slider_outer">
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
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 website_fullwidth_slider_outer">
                    <div class="website_fullwidth_slider_title">
                        <a href="">Son Eklenen 200 Araç İçin Tıklayınız.</a>
                    </div>
                    <div class="website_fullwidth_slider_contnets_outer">
                        <div class="website_fullwidth_slider_contents_left">
                            <div class="website_fullwidth_slider_contents_left_title">
                                SON EKLENENLER
                            </div>
                        </div>
                        <div class="website_fullwidth_slider_contents_btn_outer">
                            <div class="website_fullwidth_slider_contents_btn_left" id="fullwidth_slider_btn_left"></div>
                        </div>
                        <div class="owl-carousel owl-theme website_fullwidth_slider_boxes_outer">
                            <div>
                                <div class="website_fullwidth_slider_box website_fullwidth_slider_box_orange">
                                    <div class="website_fullwidth_slider_box_title">
                                        <i class="fas fa-stopwatch"></i> 36 Gün 01:01:08
                                    </div>
                                    <div class="website_fullwidth_slider_box_image" style="background-image:url('https://ihale.pertdunyasi.com/images/et295824.png');"></div>
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
                                            <div class="website_fullwidth_slider_box_image" style="background-image:url('https://ihale.pertdunyasi.com/images/et295824.png');"></div>
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
                            <div class="website_fullwidth_slider_contents_btn_right" id="fullwidth_slider_btn_right"></div>
                        </div>
                    </div>
                </div>
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