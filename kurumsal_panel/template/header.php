<!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous"> -->

<!-- Yeniler -->

<link rel="stylesheet" href="../fonts/icomoon/style.css">
<link rel="stylesheet" href="../css/bootstrap-datepicker.css">
<link rel="stylesheet" href="../css/jquery.fancybox.min.css">
<link rel="stylesheet" href="../css/owl.carousel.min.css?v=2">
<link rel="stylesheet" href="../css/owl.theme.default.min.css">
<link rel="stylesheet" href="../fonts/flaticon/font/flaticon.css">
<link rel="stylesheet" href="../css/aos.css">
<!--<link rel="stylesheet" href="../css/carousel.css?v=11">-->

<!-- Slick Slider -->
<link rel="stylesheet" type="../text/css" href="slick_slider/slick/slick.css" />
<link rel="stylesheet" type="../text/css" href="slick_slider/slick/slick-theme.css" />

<!-- MAIN CSS -->
<link rel="stylesheet" href="../css/style.css?v=<?php echo time(); ?>">
<link rel="stylesheet" href="../css/custom.css">

<style>
  body {
    padding-top: 0px;
  }

  .navbar-expand-md {
    min-height: 45px;
  }

  .dropdown-menu {
    z-index: 99999;
  }

  .site-navbar {}

  .navbar {
    margin-bottom: 140px;
  }

  .profile_menu_btn {
    display: none;
  }

  @media only screen and (min-width: 600px) {
    .new_navbar_outer .collapse ul {
      position: absolute;
      right: 30px;
    }
  }



  @media only screen and (max-width: 600px) {
    .new_navbar_logo {
      height: 40px !important;
    }

    .site-navbar {
      top: 0px !important
    }

    .navbar {
      margin-bottom: 0px;
    }

    .profile_menu_btn {
      display: block;
    }
  }

  @media screen and (min-width: 1365px) {
    .new_navbar_outer .collapse ul>li>a {
      margin-left: 10px;
      margin-right: 5px;
      padding: 15px 0px;
      color: #fff !important;
      display: inline-block;
      text-decoration: none !important;
      font-size: 15px;
    }
  }

  @media screen and (min-width: 1600px) {
    .new_navbar_outer .collapse ul>li>a {
      margin-left: 15px;
      margin-right: 10px;
      padding: 15px 0px;
      color: #fff !important;
      display: inline-block;
      text-decoration: none !important;
      font-size: 18px;
    }

    .yeni {
      font-size: 20px !important;
      margin-left: 20px;
      margin-right: 15px;

    }
  }

  @media screen and (max-width: 1365px) {
    .new_navbar_outer .collapse ul>li>a {
      margin-left: 0px;
      margin-right: 4px;
      padding: 15px 0px;
      color: #fff !important;
      display: inline-block;
      text-decoration: none !important;
      font-size: 12px;
    }
  }
</style>

<!-- <nav class="navbar navbar-expand-lg navbar-dark bg-dark new_navbar_outer" style="background-color: #364d59 !important;padding-bottom:2.3%;padding-top:2.3%;">
    <a style="padding-right:4.8%;" href="../index.php">
      <img src="../images/logo2.png" class="new_navbar_logo" style="height:59px;">
    </a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div style="font-size:12px;" class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
    <li style=" font-size: 12px; padding:0px;" class="nav-item"><a href="../index.php" class="nav-link" style="color: #fff !important;">Ana Sayfa</a></li>
    <li style=" font-size: 12px; padding:0px;" class="nav-item"><a class="nav-link" href="../bulletin.php" class="nav-link" style="color: #fff !important;">Duyurular</a></li>
    <li style=" font-size: 12px; padding:0px;" class="nav-item"><a class="nav-link" href="../about.php" class="nav-link" style="color: #fff !important;">Sistem Nasıl İşler?</a></li>
    <li style=" font-size: 12px; padding:0px;" class="nav-item"><a class="nav-link" href="../yorumlar.php" class="nav-link" style="color: #fff !important;">Yorumlar</a></li>
    <li style=" font-size: 12px; padding:0px;" class="nav-item"><a class="nav-link" href="../contact.php" class="nav-link" style="color: #fff !important;">İletişim</a></li>
    <li style=" font-size: 12px; padding:0px;" class="nav-item"><a class="nav-link" href="../ihaledeki_araclar.php" class="nav-link" style="color: #fff !important;">İHALEDEKİ ARAÇLAR<sup><span class=""><?= $ihale_sayisi2 ?></span></sup></a></li><!-- class="badge badge-danger" -->
<!--<li style=" font-size: 12px; padding:0px;" class="nav-item"><a class="nav-link" href="../dogrudan_satisli_araclar.php" class="nav-link" style="color: #fff !important;">DOĞRUDAN SATIŞ<sup><span class=""><?= $dogrudan_satis_sayisi2 ?></span></sup></a></li>
    </ul>
  </div>
</nav> -->

<!-- 
<style>
        @media screen and (min-width: 1365px) {
          .site-navbar .site-navigation .site-menu > li > a {
            margin-left: 10px;
            margin-right: 5px;
            padding: 15px 0px;
            color: #fff !important;
            display: inline-block;
            text-decoration: none !important; 
            font-size: 15px;
          }
            .yeni{
              font-size: 20px !important;
            }
        }
        @media screen and (min-width: 1600px) {
          .site-navbar .site-navigation .site-menu > li > a {
            margin-left: 15px;
            margin-right: 10px;
            padding: 15px 0px;
            color: #fff !important;
            display: inline-block;
            text-decoration: none !important; 
            font-size: 18px;
          }
            .yeni{
              font-size: 20px !important;
              margin-left: 20px;
              margin-right: 15px;

            }
        }
        @media screen and (max-width: 1365px) {
          .site-navbar .site-navigation .site-menu > li > a {
            margin-left: 0px;
            margin-right: 4px;
            padding: 15px 0px;
            color: #fff !important;
            display: inline-block;
            text-decoration: none !important; 
            font-size: 12px;
          }
            .yeni{
              font-size: 13px !important;
            }
        }


        .header_div
        {
          display:none;
        }

        /* 06.05.2021 Düzenleme */
        body
        {
          overflow-x: hidden!important;
          padding-left: 0px!important;
          padding-right: 0px!important;
          margin: 0px!important;
          width: 100%!important;
        }

        .form-check
        {
          padding-left:0px!important;
        }

        @media screen and  (min-width: 768px)
        {
          .site-footer {
              padding: 3em 0!important;
          }
        }
        @media screen and (max-width: 600px) 
        {
          .site-navbar
          {
            padding:10px!important;
          }

          .site_logo_dis
          {
            width:70%!important;
          }

          .site-logo a img
          {
            height:40px;
          }

          .mobile_menu_dis
          {
            width:30%!important;
          }

          .site-mobile-menu
          {
            top:0px!important;
          }

          .site-menu-toggle
          {
            padding-bottom:0px!important;
          }

          .modal 
          {
            z-index: 999999;
            background-color: #0000004a;
            margin-top: 0px!important;
            padding-top: 10%;
          }

          .site-mobile-menu
          {
            height: calc(100vh + 100px);
            position: fixed;
            top: 0px!important;
            right: 0px!important;
          }

          .slide 
          {
            margin-top: -16px!important;
          }

          .header_div
          {
            width: 100%;
            height: 20px;
            margin-bottom: 15px;
            display:block;
          }

          .row
          {
            margin-left:0px!important;
            margin-right:0px!important;
          }
        }

</style>
<div class="site-wrap" id="home-section">
    <div class="site-mobile-menu site-navbar-target">
      <div class="site-mobile-menu-header">
        <div class="site-mobile-menu-close mt-3">
          <span class="icon-close2 js-menu-toggle"></span>
        </div>
      </div>
      <div class="site-mobile-menu-body"></div>
    </div>
    <div class="header_div"></div>
<header class="site-navbar site-navbar-target" style="top:<?= $top ?> ;">
        <div class="row align-items-center position-relative">
          <div class="col-xs-8 col-sm-3 site_logo_dis">
            <div class="site-logo">
              <a href="index.php"><img src="../images/logo2.png"></a>
            </div>
          </div>
          <div class="col-xs-4 col-sm-9 text-right mobile_menu_dis" >
            <span class="d-inline-block d-lg-none">
              <a href="#" class="text-white site-menu-toggle js-menu-toggle py-5 text-white">
                <span class="icon-menu h3 text-white"></span></a></span>
            <nav class="site-navigation text-right ml-auto d-none d-lg-block" style="font-size: 14px;" role="navigation">
              <ul class="site-menu main-menu js-clone-nav ml-auto ">
                <li style="font-size: 12px; padding:0px;" class="px-1"><a href="index.php" class="nav-link">Ana Sayfa</a></li>
                <li style="font-size: 12px; padding:0px;"><a href="bulletin.php">Duyurular</a></li>
                <li style="font-size: 12px; padding:0px;" class="nav-link px-1"><a href="sss.php">Sistem Nasıl İşler?</a></li>
                <li style="font-size: 12px; padding:0px;" class="nav-link px-1"><a href="yorumlar.php">Yorumlar</a></li>
                <li style="font-size: 12px; padding:0px;" class="nav-link px-1"><a href="contact.php">İletişim</a></li>
                <li style="font-size: 13px;" class="nav-link yeni px-1"><a href="ihaledeki_araclar.php">İHALEDEKİ ARAÇLAR<sup><?= $ihale_sayisi ?></sup></a></li>
                <li style="font-size: 13px;" class="nav-link yeni px-1"><a href="dogrudan_satisli_araclar.php">DOĞRUDAN SATIŞ<sup><?= $dogrudan_satis_sayisi ?></sup></a></li>
              </ul>
            </nav>
          </div>
        </div>
    </header>
</div>

 -->

<?php
/*
 $today = date("Y-m-d");
 $hour = date("H:i:s");
$ihale_cek2 = mysql_query("SELECT * FROM ilanlar WHERE ihale_acilis <= '".$today."' AND ihale_tarihi >= '".$today."' AND durum = 1");
$dogrudan_cek2 = mysql_query("SELECT * FROM dogrudan_satisli_ilanlar WHERE durum = 1");
$dogrudan_satis_sayisi2 = mysql_num_rows($dogrudan_cek2);
$ihale_sayisi2 = mysql_num_rows($ihale_cek2);
   $bugun = date("Y-m-d");
// $sorgu = mysql_query("SELECT * FROM kutlama_gorseli WHERE reklam_baslangic = '$bugun' ORDER BY id DESC LIMIT 1 ");
$sorgu = mysql_query("SELECT * FROM kutlama_gorseli WHERE '$bugun' < reklam_bitis AND '$bugun' >= reklam_baslangic ORDER BY id ASC LIMIT 1 ");
$satir = mysql_num_rows($sorgu);
if($satir == 0){
  $top = 0;
}else{
  $top = 1;
}
while($yaz = mysql_fetch_array($sorgu)){
?>
<nav class="navbar"
    style="top:0; position:absolute;padding-bottom: 0%;width:100%;padding-top: 0%;color:<?= $yaz['yazi_renk']?>; background-color:<?= $yaz['arkaplan_renk'] ?>;">
    <?= $yaz['icerik'] ?>
</nav>
<?php } */ ?>
<style>
  @media screen and (min-width: 1365px) {
    .site-navbar .site-navigation .site-menu>li>a {
      margin-left: 10px;
      margin-right: 5px;
      padding: 15px 0px;
      color: #fff !important;
      display: inline-block;
      text-decoration: none !important;
      font-size: 15px;
    }

    .yeni {
      font-size: 20px !important;
    }
  }

  @media screen and (min-width: 1600px) {
    .site-navbar .site-navigation .site-menu>li>a {
      margin-left: 15px;
      margin-right: 10px;
      padding: 15px 0px;
      color: #fff !important;
      display: inline-block;
      text-decoration: none !important;
      font-size: 18px;
    }

    .yeni {
      font-size: 20px !important;
      margin-left: 20px;
      margin-right: 15px;

    }
  }

  @media screen and (max-width: 1365px) {
    .site-navbar .site-navigation .site-menu>li>a {
      margin-left: 0px;
      margin-right: 4px;
      padding: 15px 0px;
      color: #fff !important;
      display: inline-block;
      text-decoration: none !important;
      font-size: 12px;
    }

    .yeni {
      font-size: 13px !important;
    }
  }


  .header_div {
    display: none;
  }

  /* 06.05.2021 Düzenleme */
  body {
    overflow-x: hidden !important;
    padding-left: 0px !important;
    padding-right: 0px !important;
    margin: 0px !important;
    width: 100% !important;
  }

  .form-check {
    padding-left: 0px !important;
  }

  @media screen and (min-width: 768px) {
    .site-footer {
      padding: 3em 0 !important;
    }
  }

  @media screen and (max-width: 600px) {
    .site-navbar {
      padding: 10px !important;
    }

    .site_logo_dis {
      width: 70% !important;
    }

    .site-logo a img {
      height: 40px;
    }

    .mobile_menu_dis {
      width: 30% !important;
    }

    .site-mobile-menu {
      top: 0px !important;
    }

    .site-menu-toggle {
      padding-bottom: 0px !important;
    }

    .modal {
      z-index: 999999;
      background-color: #0000004a;
      margin-top: 0px !important;
      padding-top: 10%;
    }

    .site-mobile-menu {
      height: calc(100vh + 100px);
      position: fixed;
      top: 0px !important;
      right: 0px !important;
    }

    .slide {
      margin-top: -16px !important;
    }

    .header_div {
      width: 100%;
      height: 20px;
      margin-bottom: 15px;
      display: block;
    }

    .row {
      margin-left: 0px !important;
      margin-right: 0px !important;
    }

    .test {
      top: 0px !important;
    }

    .deneme {
      margin-top: 68px;
    }


    .test-2 {
      top: 0px !important;
    }

  }

  @media screen and (min-width: 600px) {
    .test {
      top: 93px !important;
    }

    .test-2 {
      top: 43px !important;
    }
  }
</style>
<?php
$sorgu = mysql_query("SELECT * FROM kutlama_gorseli WHERE '$bugun' < reklam_bitis AND '$bugun' >= reklam_baslangic ORDER BY id ASC LIMIT 1 ");
$satir = mysql_num_rows($sorgu);
if ($satir == 0) {
  $style = "test-2";
  echo '<style>
  @media screen and (max-width: 600px) {
    .navbar-collapse
    {
      margin-top:83px!important;
    }
  }
  </style>';
} else {
  $style = "test";
}
?>
<div class="site-wrap" id="home-section">
  <div class="site-mobile-menu site-navbar-target">
    <div class="site-mobile-menu-header">
      <div class="site-mobile-menu-close mt-3">
        <span class="icon-close2 js-menu-toggle"></span>
      </div>
    </div>
    <div class="site-mobile-menu-body"></div>
  </div>
  <div class="header_div"></div>
  <header class="site-navbar site-navbar-target <?= $style ?>" style="">
    <div class="row align-items-center position-relative">
      <div class="col-2 ">
      </div>
      <div class="col-10 text-right" style="margin-top:1%;">
        <nav class="site-navigation text-right ml-auto d-none d-lg-block" style="margin-bottom:-4% !important; margin-top:-3% !important;" role="navigation">
          <ul class="site-menu main-menu js-clone-nav ml-auto profile_menu_btn">

            <li style="font-size:14px;">
              <?php if (!isset($_SESSION['u_token']) || !isset($_SESSION['k_token'])) { ?>
                <a href="#exampleModal2" data-toggle="modal" class="nav-link"><i style="color: gold;" class="fas fa-user"> Giris Yap</i> </a>
              <?php } elseif ($_SESSION['u_token'] != "") { ?>
                <a href="uye_panel" class="nav-link">&nbsp;Profil</a>
              <?php } elseif ($_SESSION['k_token'] != "") { ?>
                <a href="kurumsal_panel" class="nav-link">&nbsp;Profil</a>
              <?php } ?>
            </li>
            <li style="font-size:14px;">
              <?php if (!isset($_SESSION['u_token']) || !isset($_SESSION['k_token'])) { ?>
                <a href="#exampleModal" data-toggle="modal" class="nav-link"><i style="color: gold;" class="fas fa-sign-in-alt"> </i> Uye Ol </a>
              <?php } else { ?>
                <a href="uye_panel/islemler/logout.php" class="nav-link">&nbsp;Çıkış Yap</a>
              <?php } ?>
            </li>
          </ul>
        </nav>
      </div>
    </div>
    <div class="row align-items-center position-relative">
      <div class="col-xs-8 col-sm-3 site_logo_dis">
        <div class="site-logo">
          <a href="../index.php"><img src="../images/logo2.png"></a>
        </div>
      </div>
      <div class="col-xs-4 col-sm-9 text-right mobile_menu_dis">
        <span class="d-inline-block d-lg-none">
          <a href="#" class="text-white site-menu-toggle js-menu-toggle py-5 text-white">
            <span class="icon-menu h3 text-white"></span></a></span>
        <nav class="site-navigation text-right ml-auto d-none d-lg-block" style="font-size: 14px;" role="navigation">
          <ul class="site-menu main-menu js-clone-nav ml-auto ">
            <li style="font-size: 12px; padding:0px;" class="px-1"><a href="../index.php" class="nav-link">Ana
                Sayfa</a></li>
            <li style="font-size: 12px; padding:0px;"><a href="../bulletin.php">Blog</a></li>
            <li style="font-size: 12px; padding:0px;" class="nav-link px-1"><a href="../sistem_nasil_isler.php">Sistem Nasıl
                İşler?</a></li>
            <li style="font-size: 12px; padding:0px;" class="nav-link px-1"><a href="../yorumlar.php">Yorumlar</a></li>
            <li style="font-size: 12px; padding:0px;" class="nav-link px-1"><a href="../contact.php">İletişim</a></li>
            <li style="font-size: 13px;" class="nav-link yeni px-1"><a href="../ihaledeki_araclar.php"><i class="fas fa-gavel"></i> İHALEDEKİ ARAÇLAR<sup><?= $ihale_sayisi2 ?></sup></a></li>
            <li style="font-size: 13px;" class="nav-link yeni px-1"><a href="../dogrudan_satisli_araclar.php"><i class="fas fa-handshake"></i> DOĞRUDAN
                SATIŞ<sup><?= $dogrudan_satis_sayisi2 ?></sup></a></li>
          </ul>
        </nav>
      </div>
    </div>
  </header>
</div>