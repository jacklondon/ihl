<?php 
session_start();
include 'ayar.php';
$token = $_SESSION['u_token'];
$k_token = $_SESSION['k_token'];
if(!empty($token)){
  $uye_token = $token; 
}elseif(!empty($k_token)){
  $uye_token = $k_token;
}
include 'modal.php';
include 'alert.php';
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
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.js"></script>
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  <!-- MAIN CSS -->
  <link rel="stylesheet" href="css/style.css?v=<?=time() ?>">

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
	
    <?php include 'header.php'; 
		$site_acilis_popup_icin_cek = mysql_query("select * from siteye_girenler WHERE ip_adresi = '".getIP()."'");
     $site_acilis_popup_icin_say = mysql_num_rows($site_acilis_popup_icin_cek);
     $site_acilis_popup_icin_oku = mysql_fetch_assoc($site_acilis_popup_icin_cek);
     $siteye_giris_tarih = date('Y-m-d H:i:s');
     $siteye_giris_tarih_before = date("Y-m-d H:i:s", strtotime('-24 hours',strtotime($siteye_giris_tarih)));
     $sitenin_acilis_popupunu_cek = mysql_query("select * from site_acilis_popup");
     $sitenin_acilis_popupunu_say = mysql_num_rows($sitenin_acilis_popupunu_cek);
     $sitenin_acilis_popupunu_oku = mysql_fetch_assoc($sitenin_acilis_popupunu_cek);
     $sitenin_acilis_popupu = $sitenin_acilis_popupunu_oku['icerik'];
	 			if($sitenin_acilis_popupunu_oku['durum']==1){
     if($site_acilis_popup_icin_say == 0){
          $siteye_giren_ekle = mysql_query("INSERT INTO `siteye_girenler` (`id`, `ip_adresi`, `tarih`, `durum`) VALUES (NULL, '".getIP()."', '".$siteye_giris_tarih."', '1');");
			if($sitenin_acilis_popupunu_oku['buton']==1){  
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
					</script>	
				';			  
			   
			  //  echo '<script type="text/javascript">alert("'.$sitenin_acilis_popupu.'");</script>';
			  //  echo "<script>window.location.href = 'hazirlaniyor.php';</script>";
		   }else{
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
					</script>
				';			  
			   // echo '<script type="text/javascript">alert("'.$sitenin_acilis_popupu.'");</script>';
				$siteye_giren_guncelle = mysql_query("update siteye_girenler set tarih = '".date('Y-m-d H:i:s')."' where ip_adresi = '".getIP()."'");
		   }  
     }else{
          if($site_acilis_popup_icin_oku['tarih'] < $siteye_giris_tarih_before){
               if($sitenin_acilis_popupunu_oku['buton']==1){  
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
						</script>	
					';			  
				    $siteye_giren_guncelle = mysql_query("update siteye_girenler set tarih = '".date('Y-m-d H:i:s')."' where ip_adresi = '".getIP()."'");
                  //  echo '<script type="text/javascript">alert("'.$sitenin_acilis_popupu.'");</script>';
                  //  echo "<script>window.location.href = 'hazirlaniyor.php';</script>";
               }else{
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
						</script>
					';			  
                   // echo '<script type="text/javascript">alert("'.$sitenin_acilis_popupu.'");</script>';
                    //$siteye_giren_guncelle = mysql_query("update siteye_girenler set tarih = '".date('Y-m-d H:i:s')."' where ip_adresi = '".getIP()."'");
               }               
          }
          
     }
     }
	
	
	
	?>
   <!-- <div class="ftco-blocks-cover-1">
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
    </div>-->
	<style>
		.contact_page_element
		{
			color: #000;
			width: 100%;
			height: auto;
			float: left;
			font-size: 20px;
			/* font-weight: 600; */
			font-weight: unset;
		}				
	</style>
    <div class="site-section bg-light">
      <div class="container">
		<div style="margin-top:5%;" class="row justify-content-center text-center">
          <div class="col-7 text-center mb-3">
            <h2 class="contact_page_element">EKİBİMİZ</h2>
          </div>
        </div>
		<div class="row">
				<?php 
					// $temsilciyi_bul = mysql_query("SELECT * FROM kullanicilar where listelenme_durumu=1 order by listelenme_sirasi");
					$temsilciyi_bul = mysql_query("SELECT * FROM kullanicilar where listelenme_durumu=1 and durum <> 0 order by listelenme_sirasi");
					while($temsilci_oku = mysql_fetch_array($temsilciyi_bul)){
						$temsilci_adi = $temsilci_oku['adi']." ".$temsilci_oku['soyadi'];
				?>
					<div class="col-sm-4">
						<div class="card mt-1">
						   <div class="card-body">
								<text style="font-size:13px;font-weight:600;" class="card-title"><?= $temsilci_oku["departman"] ?></text>
								<div class="row mt-2">
									<div class="col">
										<text class="contact_page_element" style="font-weight: 600;"><?= $temsilci_adi ?></text>
									</div>
								</div>
								<div class="row">
									<div class="col">
										<text class="contact_page_element">Destek için iletişime geçiniz</text>
									</div>
								</div> 
								<div class="row">
									<div class="col">
										<a href="tel:<?= $temsilci_oku['tel'] ?>" class="contact_page_element"><i style="font-size:15px;margin-right:2px;" class="fas fa-phone-square-alt"></i> <?= $temsilci_oku['tel'] ?></a>
									</div>
								</div>	
								<div class="row">
									<div class="col-10" style="padding-right:0;" >
										<a href="mailto:<?= $temsilci_oku["email"] ?>">
											<text class="contact_page_element"><i style="font-size:15px;margin-right:2px;" class="fas fa-envelope"></i> <?= $temsilci_oku['email'] ?></text>
										</a>
									</div>
									<div class="col-2" class="contact_page_element"  style="text-align:right;padding:0">
									<?php	
										$sahip_tel=$temsilci_oku['tel'];
										$sahip_tel=str_replace('(','',$sahip_tel);
										$sahip_tel=str_replace(')','',$sahip_tel);
										$sahip_tel=str_replace('-','',$sahip_tel);
										$sahip_tel="9".$sahip_tel; 
									?>
										<a target="_blank" href="https://wa.me/?phone=<?= $sahip_tel ?>&text=<?=$lnkle ?>"><i style="font-size:45px;color:green;" class="fab fa-whatsapp"></i></a>
									</div>	
								</div>	
							</div>
						</div>
					</div>
				<?php
					}
				?>
			
		</div>

        <div class="row mt-4">
          <div class="col-lg-8 mb-5">
		          <div style="margin-top:5%;" class="row justify-content-center text-center">
          <div class="col-7 text-center mb-5">
            <h2>İletişim Formu</h2>
          </div>
        </div>
		  <?php include "contact_backend.php"; ?>
            <form method="post" >
              <div class="form-group row">
                <div class="col-md-6 mb-4 mb-lg-0">
                  <input type="text" name="ad" class="form-control" placeholder="Adınız">
                </div>
                <div class="col-md-6">
                  <input type="text" name="soyad" class="form-control" placeholder="Soyadınız">
                </div>
              </div>

              <div class="form-group row">
                <div class="col-md-12">
                  <input type="email" name="email" class="form-control" placeholder="Email Adresiniz">
                </div>
              </div>

              <div class="form-group row">
                <div class="col-md-12">
                  <textarea name="mesaj" class="form-control" placeholder="Mesajınızı buraya yazınız." cols="30"
                    rows="10"></textarea>
                </div>
              </div>
              <div class="form-group row">
                <div class="col-md-6 mr-auto">
                  <input type="submit" name="contact_send" value="Gönder" class="btn btn-block btn-primary text-white py-3 px-5"/>
                </div>
              </div>
            </form>
          </div>
          <div class="col-lg-4 ml-auto">
            <div class="bg-white p-3 p-md-5">
              <h3 class="text-black mb-4">İletişim Bilgileri</h3>
              <ul class="list-unstyled footer-link">
			  <?php $cek=mysql_fetch_object(mysql_query("select * from iletisim")) ?>
                <li class="d-block mb-3">
                  <span class="d-block text-black"><i class="icon-map-marker"></i></span>
                  <span><?=$cek->adres ?></span></li>
                <li class="d-block mb-3"><span class="d-block text-black"><i class="icon-phone-square"></i>
                  </span><span><?=$cek->sabit_hat ?></span></li>
                <li class="d-block mb-3"><span class="d-block text-black"><i class="icon-print"></i> </span><span><?=$cek->fax_sms ?></span>
                </li>
                <li class="d-block mb-3"><span class="d-block text-black"><i class="icon-mobile-phone"></i>
                  </span><span><?=$cek->telefon ?></span></li>
                <li class="d-block mb-3">
				<a href="mailto:<?= $cek->email ?>" style="color: #000;">
				<span class="d-block text-black"><i class="icon-mail_outline"></i>
                  </span><span><?=$cek->email ?></span>
				</a>
                <li class="d-block mb-3"><span class="d-block text-black"><i class="icon-skype"></i>
                  </span><span><?=$cek->skype ?> </span>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
	 
      <iframe class="mt-5" style="border: 0; width: 100%; height: 300px;"
        src="https://maps.google.com/maps?q=pert%20d%C3%BCnyas%C4%B1&t=&z=15&ie=UTF8&iwloc=&output=embed"
        frameborder="0" allowfullscreen=""></iframe>
		
		
    </div>
	<?php include "footer.php" ?>

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
	 setInterval(function() {
   cikis_yap("<?=$uye_token?>");
 }, 300001);
	   son_islem_guncelle("<?=$uye_token?>");
			setInterval(function(){ bildirim_sms(); }, 1000);
	</script>
</body>

</html>