<?php 
session_start();
include 'ayar.php';
$token = $_SESSION['u_token'];
$k_token = $_SESSION['k_token'];
if(!empty($token)){
  $uye_token = $token;
}elseif(!empty($k_token)){
  $kurumsal_token = $k_token;
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
        <?php include 'ayar.php'; ?>      
        <div class="ftco-blocks-cover-1">
            <div class="ftco-cover-1 overlay innerpage" style="background-image: url('images/hero_2.jpg')">
                <div class="container">
                    <div class="row align-items-center justify-content-center">
                        <div class="col-lg-6 text-center">
                            <h1>Slogan</h1>
                            <p>Lorem Ipsum, dizgi ve baskı endüstrisinde kullanılan mıgır metinlerdir.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="site-section pt-0 pb-0 bg-light">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="page-shape"></div>
                        <div class="page-shape-two"></div>
                        <form class="trip-form">
                            <div class="row align-items-center mb-4">
                                <div class="col-md-12">
                                    <h3 class="m-0">1999 BMW Sedan</h3>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-1">
                                    <span class="label label-default c-red">#3</span>
                                </div>
                                <div class="form-group col-md-1">
                                    <span class="label label-default">35 ABS 35</span>
                                </div>
                                <div class="form-group col-md-2">
                                    <span class="label label-default">26.12.2020 12:00</span>
                                </div>
                                <div class="form-group col-md-3">
                                    <span class="label label-default">Çekme Belgeli/Pert Kayıtlı</span>
                                </div>
                                <div class="form-group col-md-1">
                                    <span class="label label-default">Ağrı</span>
                                </div>
                                <div class="form-group col-md-1">
                                    <span class="label label-default">Açık İhale</span>
                                </div>
                                <div class="form-group col-md-3">
                                    <span class="label label-default">TSRSB Bedeli : TL25.000</span>
                                </div>
                                <div class="form-group col-md-12 detail-info">
                                    <div class="text-center mt-3 mb-3"><i class="icon-info"></i></div>
                                    <span class="label label-default">
                                        <p>Ödemeden sonra 35 gün teslim ve satış onay beklenmesi gerekmektedir.</p>
                                    </span>
                                    <span class="label label-default">
                                        <p>Ödemeden sonra 35 gün teslim ve satış onay beklenmesi gerekmektedir.</p>
                                    </span>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="site-section bg-light">
            <div class="container">
                <div class="row">
                    <!-- Car #1 -->
                    <div class="col-lg-8 col-md-6 mb-4">
                        BURASI GALERI
                    </div>
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="container">
                            <div class="text-center border-bottom mt-3">
                                <h6>1 Gun 11:12:56</h6>
                            </div>
                            <div class="text-center border-bottom mt-3">
                                <label for="">En Yüksek Teklif</label>
                                <h3>TL 72.000</h3>
                                <div class="align-items-md-stretch mb-3">
                                    <div class="btn btn-primary mb-1">+ TL250</div>
                                    <div class="btn btn-primary mb-1">+ TL500</div>
                                    <div class="btn btn-primary mb-1">+ TL750</div>
                                    <div class="btn btn-primary mb-1">+ TL1000</div>
                                </div>
                            </div>
                            <div class="text-center border-bottom mt-3">
                                <h6>Açık Arttırma</h6>
                            </div>
                            <!-- Kullanici onceden bu arabaya teklif yapmis ise -->
                            <div class="text-center border-bottom mt-3">
                                <h6 class="c-green">En yüksek teklif sizindir.</h6>
                            </div>
                            <div class="text-center border-bottom mt-3">
                                <input class="mb-1" type="text" id="" name="" placeholder="yeni teklifiniz giriniz"
                                    required>
                            </div>
                            <a href="#exampleModal6" data-toggle="modal"
                                class="btn btn-secondary mt-3 mr-1 mb-3 float-left"><i class="icon-mail_outline"> Mesaj
                                    Yaz</i></a>
                            <a href="#" class="btn btn-primary mt-3 mr-1 mb-3 float-right"><i class="icon-send-o"> Teklifi
                                    Gonder</i></a>
                        </div>
                        <div class="container">
                            <h3>Teklifinize eksta ödeyecekleriniz</h3>
                            <div class="text-center border-bottom mt-3"></div>
                            <div class="text-center mt-3">
                                <label class="c-bold">PD Hizmet Bedeli</label>
                                <h6 class="text-muted">Hizmet Bedeli 1182 ₺</h6>
                                <label class="c-bold">Park Ücreti</label>
                                <h6 class="text-muted">Servisten Sorgulayınız.</h6>
                                <label class="c-bold">Dosya Masrafı</label>
                                <h6 class="text-muted">750 ₺</h6>
                                <label class="c-bold">Noter ve Takipçi Ücreti</label>
                                <h6 class="text-muted">750 ₺</h6>
                            </div>
                        </div>
                    </div>
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
	   son_islem_guncelle("<?=$uye_token?>");
	
	</script>
</body>

</html>