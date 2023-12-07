<?php
   session_start();
   include 'ayar.php';
   include 'modal.php';

   $token = $_SESSION['u_token'];
   $k_token = $_SESSION['k_token'];
   if($token != "" && $k_token == ""){
     $uye_token = $token;
   }elseif($token == "" && $k_token != ""){
      $uye_token = $k_token;
   }
   $marka_cek = mysql_query("SELECT * FROM marka");
   $sehir_cek = mysql_query("SELECT * FROM sehir");
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
      <link rel="stylesheet" href="css/style.css">
      <link rel="stylesheet" href="css/custom.css">
      <link rel="stylesheet" href="css/ihaledekiler.css">
      <style>
         .ihale ul{height:200px; width:80%; list-style-type:none;
         }
         .ihale ul{overflow:hidden; overflow-y:scroll;
         }
         .list-group-item{background: rgb(28, 1, 102); color: rgb(255, 255, 255);
         }
         .list-group-item:hover{ background: rgb(5, 22, 39); color: rgb(255, 255, 255);
         }
         /* .ihale{
         margin-top: -60px;
         } */
         /* .list-group{
         margin-top: 10px;
         } */
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
         <?php include 'header.php' ?>
         <div class="container">
            <div class="row" style="margin-top: 120px;">
               <div class="col-lg-3">
                  <a href="#"><b><strong>HIZLI ERİŞİM</strong></b></a>
               </div>
               <div class="col-lg-3">
               </div>
               <div class="col-lg-3">
                  <a href="ihaledeki_araclar.php"><b style="color: rgb(235, 115, 3);"><strong>İHALEDEKİ ARAÇLAR</strong></b></a>
               </div>
               <div class="col-lg-3">
                  <a href="dogrudan_satisli_araclar.php"><b><strong>DOĞRUDAN SATIŞ</strong></b></a>
               </div>
            </div>
         </div>
         <div class="site-section" style="margin-top: -8% !important;">
            <div class="container">
            <form action="" method="POST" name="filtre" id="filtre">
            <div class="row">
               <div class="col-sm-3">
               <label for="inputGroupSelect01">Markaya Göre</label>
                  <div class="input-group mb-3">                    
                     <select name="marka" class="custom-select">                     
                        <option>Seçiniz...</option>
                        <?php while($marka_oku = mysql_fetch_array($marka_cek)){ ?>
                        <option value="<?=$marka_oku['marka_adi']?>"><?= $marka_oku['marka_adi'] ?></option>
                        <?php } ?>
                     </select>
                  </div>
               </div>
               <div class="col-sm-3">
               <label for="inputGroupSelect01">Şehire Göre</label>
                  <div class="input-group mb-3">
                     <select name="sehir" class="custom-select" id="inputGroupSelect01">
                        <option >Seçiniz...</option>
                        <?php while($sehir_oku = mysql_fetch_array($sehir_cek)){ ?>
                        <option value="<?=$sehir_oku['sehiradi']?>"><?= $sehir_oku['sehiradi'] ?></option>
                        <?php } ?>

                     </select>
                  </div>
               </div>
               <div class="col-sm-3">
               <label for="inputGroupSelect01">İhale Zamanına Göre</label>
                  <div class="input-group mb-3">
                     <select name="zaman" class="custom-select" id="inputGroupSelect01">
                        <option >Seçiniz...</option>
                        <option value="1">Bugün Bitenler</option>
                        <option value="2">Yarın Bitenler</option>
                        <option value="3">Bugün Eklenenler</option>
                     </select>
                  </div>
               </div>
               <div class="col-sm-3">
               <label for="inputGroupSelect01">Profile Göre</label>
                  <div class="input-group mb-3">
                     <select name="profil" class="custom-select" id="inputGroupSelect01">
                        <option >Seçiniz...</option>
                        <option value="Çekme Belgeli/Pert Kayıtlı">Çekme Belgeli/Pert Kayıtlı</option>
                        <option value="Çekme Belgeli">Çekme Belgeli</option>
                        <option value="Hurda Belgeli">Hurda Belgeli</option>
                        <option value="Plakalı">Plakalı</option>
                     </select>
                  </div>
               </div>
               <div class="col-sm-6">
                <input type="submit" class="btn btn-primary btn-block" name="ihaleyi" value="Filtrele">
               </div>
               <div class="col-sm-3"></div>
               <div class="col-sm-3"></div>
            </div>
            </form>
            <!-- <div class="row">
              <?php if(re('ihaleyi')=="Filtrele"){
                // $marka = re('marka');
                // $sehir = re('sehir');
                // $zaman = re('zaman');
                // $bugun = date("Y-m-d");
                // $yarin = date("Y-m-d", strtotime("+1 day"));
                // if($zaman == "1"){
                //   $filtre_cek = mysql_query("SELECT * FROM ilanlar WHERE marka = '".$marka."' AND sehir = '".$sehir."'
                //   AND ihale_tarihi = '".$bugun."' AND profil = '".$profil."' ");
                // }elseif($zaman == "2"){
                //   $filtre_cek = mysql_query("SELECT * FROM ilanlar WHERE marka = '".$marka."' AND sehir = '".$sehir."'
                //   AND ihale_tarihi = '".$yarin."' AND profil = '".$profil."' ");
                // }elseif($zaman == "3"){
                //   $filtre_cek = mysql_query("SELECT * FROM ilanlar WHERE marka = '".$marka."' AND sehir = '".$sehir."'
                //   AND eklenme_zamani = '".$bugun."' AND profil = '".$profil."' ");
                // }else{
                //   echo '<script>alert("Başarısız")</script>';
                // }
              } 
              ?>
            </div> -->

               <!-- <div class="row">
                  <div class="col-lg-2">
                     <nav class="ihale">
                        <b ><strong> Markaya Göre</strong></b>
                        <ul class="list-group">
                           <option selected>Seçiniz...</option>
                        <option value="1">One</option>
                        <option value="2">Two</option>
                        <option value="3">Three</option>
                        <option value="1">One</option>
                        <option value="2">Two</option>
                        <option value="3">Three</option>
                        <option value="1">One</option>
                        <option value="2">Two</option>
                        <option value="3">Three</option>
                        </ul>
                     </nav>
                  </div>
                  <div class="col-lg-2">
                     <nav class="ihale">
                        <b><strong> Şehire Göre</strong></b>
                        <ul class="list-group">
                           <li class="list-group-item list-group-item-action"></li>
                           <li class="list-group-item list-group-item-action"></li>
                           <li class="list-group-item list-group-item-action"></li>
                           <li class="list-group-item list-group-item-action"></li>
                           <li class="list-group-item list-group-item-action"></li>
                           <li class="list-group-item list-group-item-action"></li>
                           <li class="list-group-item list-group-item-action"></li>
                           <li class="list-group-item list-group-item-action"></li>
                           <li class="list-group-item list-group-item-action"></li>
                           <li class="list-group-item list-group-item-action"></li>
                           <li class="list-group-item list-group-item-action"></li>
                           <li class="list-group-item list-group-item-action"></li>
                           <li class="list-group-item list-group-item-action"></li>
                           <li class="list-group-item list-group-item-action"></li>
                           <li class="list-group-item list-group-item-action"></li>
                           <li class="list-group-item list-group-item-action"></li>
                        </ul>
                     </nav>
                  </div>
                  <div class="col-lg-2">
                     <nav class="ihale">
                        <b><strong>Zamana Göre</strong></b>
                        <ul class="list-group">
                           <li class="list-group-item list-group-item-action"></li>
                           <li class="list-group-item list-group-item-action"></li>
                           <li class="list-group-item list-group-item-action"></li>
                           <li class="list-group-item list-group-item-action"></li>
                           <li class="list-group-item list-group-item-action"></li>
                           <li class="list-group-item list-group-item-action"></li>
                           <li class="list-group-item list-group-item-action"></li>
                           <li class="list-group-item list-group-item-action"></li>
                           <li class="list-group-item list-group-item-action"></li>
                           <li class="list-group-item list-group-item-action"></li>
                           <li class="list-group-item list-group-item-action"></li>
                           <li class="list-group-item list-group-item-action"></li>
                           <li class="list-group-item list-group-item-action"></li>
                           <li class="list-group-item list-group-item-action"></li>
                           <li class="list-group-item list-group-item-action"></li>
                           <li class="list-group-item list-group-item-action"></li>
                        </ul>
                     </nav>
                  </div>
                  <div class="col-lg-2">
                     <nav class="ihale">
                        <b><strong> Profile Göre</strong></b>
                        <ul class="list-group">
                           <li class="list-group-item list-group-item-action"></li>
                           <li class="list-group-item list-group-item-action"></li>
                           <li class="list-group-item list-group-item-action"></li>
                           <li class="list-group-item list-group-item-action"></li>
                           <li class="list-group-item list-group-item-action"></li>
                           <li class="list-group-item list-group-item-action"></li>
                           <li class="list-group-item list-group-item-action"></li>
                           <li class="list-group-item list-group-item-action"></li>
                           <li class="list-group-item list-group-item-action"></li>
                           <li class="list-group-item list-group-item-action"></li>
                           <li class="list-group-item list-group-item-action"></li>
                           <li class="list-group-item list-group-item-action"></li>
                           <li class="list-group-item list-group-item-action"></li>
                           <li class="list-group-item list-group-item-action"></li>
                           <li class="list-group-item list-group-item-action"></li>
                           <li class="list-group-item list-group-item-action"></li>
                        </ul>
                     </nav>
                  </div>
               </div> -->
            </div>
         </div>






































         <!-- Footer Başlangıç -->
 <?php include "footer.php" ?>
         <!-- Footer Bitiş -->
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
   </body>
</html>