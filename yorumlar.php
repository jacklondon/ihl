<?php 

   session_start();
   $token = $_SESSION['u_token'];
	$k_token = $_SESSION['k_token'];
if(!empty($token)){
  $uye_token = $token;
}elseif(!empty($k_token)){
  $uye_token = $k_token;
}
   include 'ayar.php';
   include 'modal.php';
  //  $yorumlari_cek = mysql_query("select yorumlar.* from yorumlar inner join ilanlar as i on i.id=yorumlar.ilan_id where yorumlar.durum = 1 or yorumlar.durum=3 order by yorumlar.yorum_zamani desc");
   $yorumlari_cek = mysql_query("select * from yorumlar where arac_bilgileri <> '' and ( durum = 1 or durum=3) order by yorum_zamani desc");
   //include 'alert.php';

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
  <style>
      @media only screen and (max-width: 600px) {
        .yorumlar {
          margin-top:45% !important;
        }
      }
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
                   // $siteye_giren_guncelle = mysql_query("update siteye_girenler set tarih = '".date('Y-m-d H:i:s')."' where ip_adresi = '".getIP()."'");
               }               
          }
          
     }
     }
      

?>
<div class="row" style="height: 120px !important;"></div>

<div class="container yorumlar">
<div class="row d-flex justify-content-center">

<?php 

while($yorumlari_oku = mysql_fetch_array($yorumlari_cek)){ 
  $uye_bilgisi_cek = mysql_query("select * from user where id ='".$yorumlari_oku['uye_id']."'");
  $uye_bilgisi_oku = mysql_fetch_assoc($uye_bilgisi_cek);
  $uye_adi = $uye_bilgisi_oku['ad'];
  // echo $uye_adi;
  $uye_adi = trim($uye_adi);
  $uye_adi = mb_convert_encoding($uye_adi, "UTF-8", "auto");
  $parcala=explode(" ",$uye_adi);
  $name = "";
  for($i=0;$i<count($parcala);$i++){
   if($parcala[$i] != "" && $parcala[$i] != " "){
    $harf_sayi = mb_strlen($parcala[$i], 'UTF-8');
    $ilk_harf = substr($parcala[$i],0,1);
    for($j=0;$j<$harf_sayi;$j++){
      if($j == 0){
        $name .= $ilk_harf;
      }else{
        $name .= "*";
      }
    }
    $name .= " ";
   }  
  }

  $name_array = explode(" ", $name);
  $name_son = "";
  for($i=0;$i<count($name_array);$i++){
    if($i==0){
      // $name = substr($name_array[$i],0,-1);
      $name = $name_array[$i];
    }else{
      $name = $name_array[$i];
    }
    $name_son .= $name." ";
  }
  /*
  $str = 'mała';
  $len = mb_strlen($str, 'UTF-8');
  $result = [];
  for ($i = 0; $i < $len; $i++) {
      $result[] = mb_substr($str, $i, 1, 'UTF-8');
  }
  var_dump($result);
  */
  




               ?>
            
               <div class="card mt-5" style="border: 1px solid #000000; width:80%;">
                  <h5 class="card-header" style="background-color: rgb(255, 192, 0); color:#000000; font-weight:750;"> <?= $yorumlari_oku["arac_bilgileri"] ?></h5>
                  <div class="card-body" style="border-bottom: 1px solid #000000;">
                     <p class="card-text" style="font-weight: bolder !important;"><b style="font-weight: bolder !important;">Yorum Sahibi : <?=$name_son ?></b>  <b style="margin-left:50px;">Tarih : <?=date("d.m.Y H:i:s",strtotime($yorumlari_oku['yorum_zamani'])) ?></b></p> 
                  </div>
                  <div class="card-body" style="border-bottom: 1px solid #000000; background-color:#e8e8e8;">
                     <p class="card-text"><i class="fas fa-comment" aria-hidden="true"></i> <?= $yorumlari_oku['yorum'] ?></p>
                  </div>
				  <?php if($yorumlari_oku['cevap'] !="") {
				$cevap_zaman = $yorumlari_oku['cevap_zamani'];
              $newDate = date("d.m.Y H:i:s", strtotime($cevap_zaman));
            ?>
                  <div class="card-body" style="border-bottom: 1px solid #000000;">
                     <p class="card-text" style="font-weight: bolder !important;" ><b style="font-weight: bolder !important;">Cevap :Pert Dünyası Ekibi</b>   <b style="margin-left:50px;">Tarih :<?= $newDate ?></b></p> 
                  </div>
                  <div class="card-body" style="background-color: #e8e8e8;">
                     <p class="card-text"><i class="fas fa-comment" aria-hidden="true"></i> <?= $yorumlari_oku['cevap'] ?></p>
                  </div>
				  <?php } ?>
               </div>
				  
            <?php } ?>
     
        </div>
</div>

   <!-- <div class="site-section bg-light">
      <div class="container">
        <div class="row justify-content-center text-center mb-5 section-2-title">
          <div class="col-md-6">
            <h2 class="mb-4">Yetkililerimiz</h2>
            <p>Lorem Ipsum, dizgi ve baskı endüstrisinde kullanılan mıgır metinlerdir. Lorem Ipsum, adı bilinmeyen bir
              matbaacının bir hurufat numune kitabı oluşturmak üzere bir yazı galerisini alarak karıştırdığı 1500'lerden
              beri endüstri standardı sahte metinler olarak kullanılmıştır.</p>
          </div>
        </div>
        <div class="row align-items-stretch">
          <div class="col-lg-4 col-md-6 mb-5">
            <div class="post-entry-1 h-100 person-1">
              <img src="images/person_3.jpg" alt="Image" class="img-fluid">
              <div class="post-entry-1-contents">
                <span class="meta">MT Takım Lideri </span>
                <h2>Ayşe Akkaş</h2>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ipsa, sapiente.</p>
              </div>
            </div>
          </div>
          <div class="col-lg-4 col-md-6 mb-5">
            <div class="post-entry-1 h-100 person-1">
              <img src="images/person_3.jpg" alt="Image" class="img-fluid">
              <div class="post-entry-1-contents">
                <span class="meta">Müşteri Temsilcisi </span>
                <h2>Nahide Akoğlu</h2>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ipsa, sapiente.</p>
              </div>
            </div>
          </div>
          <div class="col-lg-4 col-md-6 mb-5">
            <div class="post-entry-1 h-100 person-1">
              <img src="images/person_3.jpg" alt="Image" class="img-fluid">
              <div class="post-entry-1-contents">
                <span class="meta">Müşteri Temsilcisi</span>
                <h2>Sedef Genç</h2>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ipsa, sapiente.</p>
              </div>
            </div>
          </div>
          <div class="col-lg-4 col-md-6 mb-5">
            <div class="post-entry-1 h-100 person-1">
              <img src="images/person_1.jpg" alt="Image" class="img-fluid">
              <div class="post-entry-1-contents">
                <span class="meta">Kurucu</span>
                <h2>Ali Çakı </h2>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ipsa, sapiente.</p>
              </div>
            </div>
          </div>
          <div class="col-lg-4 col-md-6 mb-5">
            <div class="post-entry-1 h-100 person-1">
              <img src="images/person_1.jpg" alt="Image" class="img-fluid">
              <div class="post-entry-1-contents">
                <span class="meta">Kurucu</span>
                <h2>Gürcan Cankız</h2>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ipsa, sapiente.</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>-->
    <div class="col-sm-12 mt-5"></div>
    <?php include 'footer.php'; ?>

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
	 setInterval(function() {
   cikis_yap("<?=$uye_token?>");
 }, 300001);
	   son_islem_guncelle("<?=$uye_token?>");
			setInterval(function(){ bildirim_sms(); }, 1000);
	</script>
</body>

</html>