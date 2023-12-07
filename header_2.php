<div class="site-wrap" id="home-section">
    <div class="site-mobile-menu site-navbar-target">
      <div class="site-mobile-menu-header">
        <div class="site-mobile-menu-close mt-3">
          <span class="icon-close2 js-menu-toggle"></span>
        </div>
      </div>
      <div class="site-mobile-menu-body"></div>
    </div>
    <header class="site-navbar site-navbar-target" role="banner">
      <div class="container">
        <div class="row align-items-center position-relative">
          <div class="col-3 ">
            <div class="site-logo">
              <a href="index.html"><img src="images/logo2.png"></a>
            </div>
          </div>
          <div class="col-9 text-right" >
            <span class="d-inline-block d-lg-none">
              <a href="#" class="text-white site-menu-toggle js-menu-toggle py-5 text-white">
                <span class="icon-menu h3 text-white"></span></a></span>
            <nav class="site-navigation text-right ml-auto d-none d-lg-block" style="font-size: 14px;" role="navigation">
              <ul class="site-menu main-menu js-clone-nav ml-auto ">
                <li class="active"><a href="index.html" class="nav-link">Ana Sayfa</a></li>
                <li><a href="showcase.html" class="nav-link">Vitrin</a></li>
                <li><a href="bulletin.html" class="nav-link">Duyurular</a></li>
                <li><a href="about.html" class="nav-link">Hakkımızda</a></li>
                <li><a href="contact.html" class="nav-link">İletişim</a></li>
                <li><a href="#exampleModal2" data-toggle="modal" class="nav-link">&nbsp;Giris Yap</a></li>
                <li><a href="#exampleModal" data-toggle="modal" class="nav-link">&nbsp;Uye Ol</a></li>
                <li style="font-size:14px;"><?php if(!isset($_SESSION['u_token'])||!isset($_SESSION['k_token'])){ ?>
                  <a href="#exampleModal2" data-toggle="modal" class="nav-link"><i style="color: gold;" class="fas fa-user"> Giris Yap</i> </a>
                  <?php }elseif($_SESSION['u_token'] != ""){ ?>
                  <a href="uye_panel" class="nav-link">&nbsp;Profil</a>
                  <?php }elseif($_SESSION['k_token'] != ""){ ?>
                  <a href="kurumsal_panel" class="nav-link" >&nbsp;Profil</a>
                  <?php } ?>
                </li>
                <li style="font-size:14px;"><?php if(!isset($_SESSION['u_token'])||!isset($_SESSION['k_token'])){ ?>
                <a href="#exampleModal" data-toggle="modal" class="nav-link"><i style="color: gold;" class="fas fa-sign-in-alt"> </i> Uye Ol </a>
                <?php }else{ ?>
                <a href="uye_panel/islemler/logout.php" class="nav-link">&nbsp;Çıkış Yap</a>
                <?php } ?>
                </li>

              </ul>
            </nav>
          </div>
        </div>
      </div>
    </header>
  </div>

