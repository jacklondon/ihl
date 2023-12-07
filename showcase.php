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

    <?php include 'header.php'; ?>

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
                <div class="col-md-6">
                  <h3 class="m-0">Aracını Bul</h3>
                </div>
                <div class="col-md-6 text-md-right">
                  <span class="text-primary">12</span> <span>araç uygun</span></span>
                </div>
              </div>
              <div class="row">
                <div class="form-group col-md-3">
                  <form action="#" class="pb-3">
                    <div class="form-group">
                      <select name="city" class="form-control" id="city" placeholder="Şehir seçiniz"
                        data-rule="minlen:4">
                        <option value="0">Şehir seçiniz</option>
                        <option value="1">Ankara</option>
                        <option value="2">İstanbul</option>
                        <option value="3">İzmir</option>
                        <option value="4">Adana</option>
                        <option value="5">Bursa</option>
                      </select>
                    </div>
                  </form>
                </div>
                <div class="form-group col-md-3">
                  <label for="cf-2">Evrak Durumu</label>
                  <form action="#">
                    <input type="checkbox" id="1" name="1" value="2">
                    <label for="1"> Çekme Belgeli / Pert Kayıtlı</label><br>
                    <input type="checkbox" id="2" name="2" value="2">
                    <label for="2"> Çekme Belgeli </label><br>
                    <input type="checkbox" id="3" name="3" value="3">
                    <label for="3"> Plakalı </label><br>
                    <input type="checkbox" id="4" name="4" value="4">
                    <label for="4"> Hurda Belgeli </label><br>
                  </form>
                </div>
                <div class="form-group col-md-3">
                  <label for="cf-3">Model Yılı Aralığı</label>
                  <form action="#">
                    <div class="row" style="justify-content: center; align-items: center;">
                      <div class="col-md-5">
                        <input type="text" class="form-control" id="start" placeholder="Başlangıç" value="" required="">
                      </div>
                      /
                      <div class="col-md-5">
                        <input type="text" class="form-control" id="end" placeholder="Bitiş" value="" required="">
                      </div>
                    </div>
                  </form>
                </div>
                <div class="form-group col-md-3">
                  <label for="cf-4">Marka</label>
                  <form action="#" class="pb-3">
                    <div class="form-group">
                      <select name="city" class="form-control" id="brand" placeholder="Marka seçiniz"
                        data-rule="minlen:4">
                        <option value="0">Marka seçiniz</option>
                        <option value="1">Dodge</option>
                        <option value="2">Mercedes</option>
                        <option value="3">BMW</option>
                        <option value="4">Renault</option>
                      </select>
                    </div>
                  </form>
                </div>
              </div>
              <div class="row mt-3">
                <div class="col-lg-6">
                  <input type="submit" value="Filtrele" class="btn btn-trans">
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

          <div class="col-lg-4 col-md-6 mb-4">
            <div class="item-1 shadow">
              <a href="#"><img src="images/img_1.jpg" alt="Image" class="img-fluid"></a>
              <div class="item-1-contents">
                <div class="text-center">
                  <h3><a href="#" class="c-second">2016 Nissan 1.DCI TEKNA SKY PACK X-TRONIC</a></h3>
                  <div class="text-center">
                    <h6>8 Gun 23:12:56</h6>
                  </div>
                </div>
                <ul class="specs">
                  <li>
                    <span>İlan No</span>
                    <span class="spec">#1</span>
                  </li>
                  <li>
                    <span>Şehir</span>
                    <span class="spec">İstanbul</span>
                  </li>
                  <li>
                    <span>Tür</span>
                    <span class="spec">Açık İhale</span>
                  </li>
                  <li>
                    <span>Durum</span>
                    <span class="spec">Çekme Belgeli / Pert Kayıtlı</span>
                  </li>
                  <li>
                    <span>Yayın Bitiş</span>
                    <span class="spec">03.11.2020 15:55</span>
                  </li>
                </ul>
                <div class="row no-gutters">
                  <div class="col-6">
                    <a href="#" class="btn btn-primary mt-3 ml-1"><i class="icon-money"></i></a>
                    <a href="#" class="btn btn-primary mt-3 ml-1"><i class="icon-info-circle"></i></a>
                  </div>
                  <div class="col-6">
                    <a href="#" class="btn btn-primary mt-3 mr-1 float-right"><i class="icon-favorite"></i></a>
                    <a href="#" class="btn btn-primary mt-3 mr-1 float-right"><i class="icon-notifications"></i></a>
                  </div>
                </div>
              </div>
            </div>
          </div>


          <div class="col-lg-4 col-md-6 mb-4">
            <div class="item-1 shadow">
              <a href="#"><img src="images/img_2.jpg" alt="Image" class="img-fluid"></a>
              <div class="item-1-contents">
                <div class="text-center">
                  <h3><a href="#" class="c-second">1999 Sedan</a></h3>
                  <div class="text-center">
                    <div class="rent-price"><span class="c-red">TL100.000</span> <br> teklifiniz</div>
                    <h6>2 Gun 13:12:56</h6>
                  </div>
                </div>
                <ul class="specs">
                  <li>
                    <span>İlan No</span>
                    <span class="spec">#2</span>
                  </li>
                  <li>
                    <span>Şehir</span>
                    <span class="spec">Ağrı</span>
                  </li>
                  <li>
                    <span>Tür</span>
                    <span class="spec">Açık İhale</span>
                  </li>
                  <li>
                    <span>Durum</span>
                    <span class="spec">Plakalı</span>
                  </li>
                  <li>
                    <span>Yayın Bitiş</span>
                    <span class="spec">06.11.2020 15:55</span>
                  </li>
                </ul>
                <div class="row no-gutters">
                  <div class="col-6">
                    <a href="#" class="btn btn-blue mt-3 ml-1"><i class="icon-money"></i></a>
                    <a href="#" class="btn btn-blue mt-3 ml-1"><i class="icon-info-circle"></i></a>
                  </div>
                  <div class="col-6">
                    <a href="#" class="btn btn-blue mt-3 mr-1 float-right"><i class="icon-favorite"></i></a>
                    <a href="#" class="btn btn-blue mt-3 mr-1 float-right"><i class="icon-notifications"></i></a>
                  </div>
                </div>
              </div>
            </div>
          </div>


          <div class="col-lg-4 col-md-6 mb-4">
            <div class="item-1 shadow">
              <a href="#"><img src="images/img_3.jpg" alt="Image" class="img-fluid"></a>
              <div class="item-1-contents">
                <div class="text-center">
                  <h3><a href="#" class="c-second">i8 Premium Techno</a></h3>
                  <div class="text-center">
                    <h6>23 Gun 23:12:56</h6>
                  </div>
                </div>
                <ul class="specs">
                  <li>
                    <span>İlan No</span>
                    <span class="spec">#3</span>
                  </li>
                  <li>
                    <span>Şehir</span>
                    <span class="spec">İzmir</span>
                  </li>
                  <li>
                    <span>Tür</span>
                    <span class="spec">Açık İhale</span>
                  </li>
                  <li>
                    <span>Durum</span>
                    <span class="spec">Çekme Belgeli / Pert Kayıtlı</span>
                  </li>
                  <li>
                    <span>Yayın Bitiş</span>
                    <span class="spec">13.11.2020 15:55</span>
                  </li>
                </ul>
                <div class="row no-gutters">
                  <div class="col-6">
                    <a href="#" class="btn btn-primary mt-3 ml-1"><i class="icon-money"></i></a>
                    <a href="#" class="btn btn-primary mt-3 ml-1"><i class="icon-info-circle"></i></a>
                  </div>
                  <div class="col-6">
                    <a href="#" class="btn btn-primary mt-3 mr-1 float-right"><i class="icon-favorite"></i></a>
                    <a href="#" class="btn btn-primary mt-3 mr-1 float-right"><i class="icon-notifications"></i></a>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="owl-carousel owl-theme">
              <div class="item">
                <div class="card mb-3">
                  <div class="card-header my-card-title-primary text-center">
                    8 Gun 23:12:56
                  </div>
                  <div class="row no-gutters align-items-center">
                    <img src="images/img_1.jpg" class="card-img" alt="Land Rover">
                    <div class="card-body">
                      <div class="text-center c-bold"> 2016 Nissan 1.DCI TEKNA SKY PACK X-TRONIC </div>
                      <div class="text-center mt-3">
                        <h3 class="c-yellow">22.500 ₺</h3>
                      </div>
                    </div>
                    <div class="ml-3 m-1">
                      <a class="btn btn-show" href="#" role="button"><i class="fa fa-search" aria-hidden="true"></i></a>
                    </div>
                  </div>
                </div>
              </div>
              <div class="item">
                <div class="card mb-3">
                  <div class="card-header my-card-title-blue text-center">
                    DOĞRUDAN SATIŞ
                  </div>
                  <div class="row no-gutters align-items-center">
                    <img src="images/img_1.jpg" class="card-img" alt="Land Rover">
                    <div class="card-body">
                      <div class="text-center c-bold"> 2016 Nissan 1.DCI TEKNA SKY PACK X-TRONIC </div>
                      <div class="text-center mt-3">
                        <h3 class="c-blue">22.500 ₺</h3>
                      </div>
                    </div>
                    <div class="ml-3 m-1">
                      <a class="btn btn-show" href="#" role="button"><i class="fa fa-search" aria-hidden="true"></i></a>
                    </div>
                  </div>
                </div>
              </div>
              <div class="item">
                <div class="card mb-3">
                  <div class="card-header my-card-title-primary text-center">
                    8 Gun 23:12:56
                  </div>
                  <div class="row no-gutters align-items-center">
                    <img src="images/img_1.jpg" class="card-img" alt="Land Rover">
                    <div class="card-body">
                      <div class="text-center c-bold"> 2016 Nissan 1.DCI TEKNA SKY PACK X-TRONIC </div>
                      <div class="text-center mt-3">
                        <h3 class="c-yellow">22.500 ₺</h3>
                      </div>
                    </div>
                    <div class="ml-3 m-1">
                      <a class="btn btn-show" href="#" role="button"><i class="fa fa-search" aria-hidden="true"></i></a>
                    </div>
                  </div>
                </div>
              </div>
              <div class="item">
                <div class="card mb-3">
                  <div class="card-header my-card-title-primary text-center">
                    8 Gun 23:12:56
                  </div>
                  <div class="row no-gutters align-items-center">
                    <img src="images/img_1.jpg" class="card-img" alt="Land Rover">
                    <div class="card-body">
                      <div class="text-center c-bold"> 2016 Nissan 1.DCI TEKNA SKY PACK X-TRONIC </div>
                      <div class="text-center mt-3">
                        <h3 class="c-yellow">22.500 ₺</h3>
                      </div>
                    </div>
                    <div class="ml-3 m-1">
                      <a class="btn btn-show" href="#" role="button"><i class="fa fa-search" aria-hidden="true"></i></a>
                    </div>
                  </div>
                </div>
              </div>
              <div class="item">
                <div class="card mb-3">
                  <div class="card-header my-card-title-primary text-center">
                    8 Gun 23:12:56
                  </div>
                  <div class="row no-gutters align-items-center">
                    <img src="images/img_1.jpg" class="card-img" alt="Land Rover">
                    <div class="card-body">
                      <div class="text-center c-bold"> 2016 Nissan 1.DCI TEKNA SKY PACK X-TRONIC </div>
                      <div class="text-center mt-3">
                        <h3 class="c-yellow">22.500 ₺</h3>
                      </div>
                    </div>
                    <div class="ml-3 m-1">
                      <a class="btn btn-show" href="#" role="button"><i class="fa fa-search" aria-hidden="true"></i></a>
                    </div>
                  </div>
                </div>
              </div>
              <div class="item">
                <div class="card mb-3">
                  <div class="card-header my-card-title-primary text-center">
                    8 Gun 23:12:56
                  </div>
                  <div class="row no-gutters align-items-center">
                    <img src="images/img_1.jpg" class="card-img" alt="Land Rover">
                    <div class="card-body">
                      <div class="text-center c-bold"> 2016 Nissan 1.DCI TEKNA SKY PACK X-TRONIC </div>
                      <div class="text-center mt-3">
                        <h3 class="c-yellow">22.500 ₺</h3>
                      </div>
                    </div>
                    <div class="ml-3 m-1">
                      <a class="btn btn-show" href="#" role="button"><i class="fa fa-search" aria-hidden="true"></i></a>
                    </div>
                  </div>
                </div>
              </div>
              <div class="item">
                <div class="card mb-3">
                  <div class="card-header my-card-title-blue text-center">
                    DOĞRUDAN SATIŞ
                  </div>
                  <div class="row no-gutters align-items-center">
                    <img src="images/img_1.jpg" class="card-img" alt="Land Rover">
                    <div class="card-body">
                      <div class="text-center c-bold"> 2016 Nissan 1.DCI TEKNA SKY PACK X-TRONIC </div>
                      <div class="text-center mt-3">
                        <h3 class="c-blue">22.500 ₺</h3>
                      </div>
                    </div>
                    <div class="ml-3 m-1">
                      <a class="btn btn-show" href="#" role="button"><i class="fa fa-search" aria-hidden="true"></i></a>
                    </div>
                  </div>
                </div>
              </div>
              <div class="item">
                <div class="card mb-3">
                  <div class="card-header my-card-title-primary text-center">
                    8 Gun 23:12:56
                  </div>
                  <div class="row no-gutters align-items-center">
                    <img src="images/img_1.jpg" class="card-img" alt="Land Rover">
                    <div class="card-body">
                      <div class="text-center c-bold"> 2016 Nissan 1.DCI TEKNA SKY PACK X-TRONIC </div>
                      <div class="text-center mt-3">
                        <h3 class="c-yellow">22.500 ₺</h3>
                      </div>
                    </div>
                    <div class="ml-3 m-1">
                      <a class="btn btn-show" href="#" role="button"><i class="fa fa-search" aria-hidden="true"></i></a>
                    </div>
                  </div>
                </div>
              </div>
              <div class="item">
                <div class="card mb-3">
                  <div class="card-header my-card-title-primary text-center">
                    8 Gun 23:12:56
                  </div>
                  <div class="row no-gutters align-items-center">
                    <img src="images/img_1.jpg" class="card-img" alt="Land Rover">
                    <div class="card-body">
                      <div class="text-center c-bold"> 2016 Nissan 1.DCI TEKNA SKY PACK X-TRONIC </div>
                      <div class="text-center mt-3">
                        <h3 class="c-yellow">22.500 ₺</h3>
                      </div>
                    </div>
                    <div class="ml-3 m-1">
                      <a class="btn btn-show" href="#" role="button"><i class="fa fa-search" aria-hidden="true"></i></a>
                    </div>
                  </div>
                </div>
              </div>
              <div class="item">
                <div class="card mb-3">
                  <div class="card-header my-card-title-primary text-center">
                    8 Gun 23:12:56
                  </div>
                  <div class="row no-gutters align-items-center">
                    <img src="images/img_1.jpg" class="card-img" alt="Land Rover">
                    <div class="card-body">
                      <div class="text-center c-bold"> 2016 Nissan 1.DCI TEKNA SKY PACK X-TRONIC </div>
                      <div class="text-center mt-3">
                        <h3 class="c-yellow">22.500 ₺</h3>
                      </div>
                    </div>
                    <div class="ml-3 m-1">
                      <a class="btn btn-show" href="#" role="button"><i class="fa fa-search" aria-hidden="true"></i></a>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- <div class="col-md-3">
              <div class="card mb-3">
                <div class="card-header my-card-title-blue text-center">
                  DOĞRUDAN SATIŞ
                </div>
                <div class="row no-gutters align-items-center">
                  <img src="images/img_1.jpg" class="card-img" alt="Land Rover">
                  <div class="card-body">
                    <div class="text-center c-bold"> 2016 Nissan 1.DCI TEKNA SKY PACK X-TRONIC </div>
                    <div class="text-center mt-3">
                      <h3 class="c-blue">22.500 ₺</h3>
                    </div>
                  </div>
                  <div class="ml-3 m-1">
                    <a class="btn btn-show" href="#" role="button"><i class="fa fa-search" aria-hidden="true"></i></a>
                  </div>

                </div>
              </div>
            </div> -->

            <!-- <div class="col-md-3">
              <div class="card mb-3">
                <div class="card-header my-card-title-primary text-center">
                  8 Gun 23:12:56
                </div>
                <div class="row no-gutters align-items-center">
                  <img src="images/img_1.jpg" class="card-img" alt="Land Rover">
                  <div class="card-body">
                    <div class="text-center c-bold"> 2016 Nissan 1.DCI TEKNA SKY PACK X-TRONIC </div>
                    <div class="text-center mt-3">
                      <h3 class="c-yellow">22.500 ₺</h3>
                    </div>
                  </div>
                  <div class="ml-3 m-1">
                    <a class="btn btn-show" href="#" role="button"><i class="fa fa-search" aria-hidden="true"></i></a>
                  </div>
                </div>
              </div>
            </div> -->

            <!-- <div class="col-md-3">
              <div class="card mb-3">
                <div class="card-header my-card-title-primary text-center">
                  8 Gun 23:12:56
                </div>
                <div class="row no-gutters align-items-center">
                  <img src="images/img_1.jpg" class="card-img" alt="Land Rover">
                  <div class="card-body">
                    <div class="text-center c-bold"> 2016 Nissan 1.DCI TEKNA SKY PACK X-TRONIC </div>
                    <div class="text-center mt-3">
                      <h3 class="c-yellow">22.500 ₺</h3>
                    </div>
                  </div>
                  <div class="ml-3 m-1">
                    <a class="btn btn-show" href="#" role="button"><i class="fa fa-search" aria-hidden="true"></i></a>
                  </div>

                </div>
              </div>
            </div> -->

          </div>
        </div>

        <div class="col-12">
          <span class="p-3">1</span>
          <a href="#" class="p-3">2</a>
          <a href="#" class="p-3">3</a>
          <a href="#" class="p-3">4</a>
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
	cikis_baslat("<?=$uye_token?>");
	
	</script>

  <script>
    $(document).ready(function () {
      $('.owl-carousel').owlCarousel({
        loop: true,
        autoplay: true,
        autoplayTimeout: 1000,
        autoplayHoverPause: true,
        margin: 10,
        responsiveClass: true,
        responsive: {
          0: {
            items: 1,
            nav: true
          },
          600: {
            items: 3,
            nav: false
          },
          1000: {
            items: 5,
            nav: true,
            loop: false,
            margin: 20
          }
        }
      })
    })
  </script>

</body>

</html>