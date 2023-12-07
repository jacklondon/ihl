<!-- <footer class="site-footer" style="margin-top:1%;">
    <div class="container">
      <div class="row">
        <div class="col-lg-3">
          <h2 class="footer-heading mb-4">İletişim</h2>
          <p>Adres - Çınar Mahallesi 5003/1 Sokak No:9 Ege Plaza Daire:30 Bornova / İzmir</p>
          <p>Sabit Hat - 0 (232) 503 80 13</p>
          <p>Fax ve Sms - 0 (850) 303 98 69</p>
          <p>E-mail - info@pertdunyasi.com</p>
        </div>
        <div class="col-lg-9 ml-auto">
          <div class="row">
            <div class="col-lg-3">
              <h2 class="footer-heading mb-4">Şirketimiz</h2>
              <ul class="list-unstyled">
                <li><a href="#">Hakkımızda</a></li>
                <li><a href="#">Iletisim</a></li>
                <li><a href="#">S.S.S</a></li>
              </ul>
            </div>
            <div class="col-lg-3">
              <h2 class="footer-heading mb-4">Hizmetlerimiz</h2>
              <ul class="list-unstyled">
                <li><a href="#">Doğrudan Satış</a></li>
                <li><a href="#">Aracını Sat</a></li>
                <li><a href="#">Araç Değer Tespiti</a></li>
              </ul>
            </div>
            <div class="col-lg-3">
              <h2 class="footer-heading mb-4">Bayiliklerimiz</h2>
              <ul class="list-unstyled">
                <li><a href="#">İzmir</a></li>
                <li><a href="#">İstanbul</a></li>
                <li><a href="#">Ankara</a></li>
              </ul>
            </div>
            <div class="col-lg-3">
              <h2 class="footer-heading mb-4">Yararli Linkler</h2>
              <ul class="list-unstyled">
                <li><a href="#">Kullanim Kosul ve Sartlari</a></li>
                <li><a href="#">Gizlilik</a></li>
                <li><a href="#">Site Haritası</a></li>
              </ul>
            </div>
          </div>
        </div>
      </div>
      <div class="row mt-5 text-center">
        <div class="col-md-12">
          <div class="border-top pt-5">
            <p>
              Telif hakkı &copy;
              <script>
                document.write(new Date().getFullYear());
              </script> Tüm Hakları Saklıdır <br>
              Yazılım & Tasarim <a href="https://eabilisim.net.tr/" target="_blank">EA Bilişim Teknolojileri</a>
            </p>
            <img src="../images/logo2.png">
          </div>
        </div>
      </div>
    </div>
  </footer>-->
<?php
      session_start();

     $token = $_SESSION['u_token'];
     $k_token = $_SESSION['k_token'];
     if($token != "" && $k_token == ""){
       $uye_token = $token;
     }elseif($token == "" && $k_token != ""){
        $uye_token = $k_token;
     }
	 $iletisim_sorgu=mysql_query("select * from iletisim");
	 $iletisim_row=mysql_fetch_object($iletisim_sorgu);
	 $iframe=$row->iframe;
	 $footer_bayiler=mysql_query("select * from bayiler");
?>
<footer class="site-footer"  style="margin-top:1%;">
    <div class="container" style="max-width: max-content !important;">
      <div class="row">
        <div class="col-lg-3">
          <h2 class="footer-heading mb-4">İletişim</h2>
          <p>Adres : <?=$iletisim_row->adres ?></p>
          <p>Sabit Hat : <?=$iletisim_row->sabit_hat ?></p>
          <p>Telefon : <?=$iletisim_row->telefon ?></p>
          <p>Fax ve Sms : <?=$iletisim_row->fax_sms ?></p>
          <p>E-mail : <?=$iletisim_row->email ?></p>
          <style>
            .footer_social_outer
            {
              min-height:10px;
              float:left;
              padding:0px;
              margin-bottom:30px;
            }

            .social_box
            {
              width:40px;
              height:40px;
              float:left;
              background-color:#ffffff38;
              margin-right:10px;
              border-radius:50%;
              display:flex;
              align-items:center;
              justify-content:center;
              border:1px solid #ffffff7a;
              color:#ffffff;
              cursor:pointer;
            }
          </style>
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 footer_social_outer">
            <div class="social_box">
              <i class="fab fa-facebook-f"></i>
            </div>
            <div class="social_box">
              <i class="fab fa-twitter"></i>
            </div>
            <div class="social_box">
              <i class="fab fa-instagram"></i>
            </div>
            <div class="social_box">
              <i class="fab fa-linkedin-in"></i>
            </div>
          </div>
        </div>
        <div class="col-lg-9 ml-auto">
          <div class="row">
            <div class="col-lg-3">
              <h2 class="footer-heading mb-4">Şirketimiz</h2>
              <ul class="list-unstyled">
                <li><a href="../about.php">Hakkımızda</a></li>
                <li><a href="../contact.php">Iletisim</a></li>
                <li><a href="../hesaplarimiz.php">Banka Hesaplarımız</a></li>
                <li><a href="../sss.php">S.S.S</a></li>
              </ul>
            </div>
            <div class="col-lg-3">
              <h2 class="footer-heading mb-4">Hizmetlerimiz</h2>
              <ul class="list-unstyled">
                <li><a href="../dogrudan_satisli_araclar.php">Doğrudan Satış</a></li>
				<?php if($k_token == "") {?>
					<li><a href="uye_panel/yeni_ilan_ekle.php">Aracını Sat</a></li>
				<?php } else {?>
					<li><a href="kurumsal_panel/yeni_ilan_ekle.php">Aracını Sat</a></li>
				<?php } ?>
          <li><a href="../ihaledeki_araclar.php">İhale ile Satış</a></li>
              </ul>
            </div>
            <div class="col-lg-3">
              <h2 class="footer-heading mb-4">Bayiliklerimiz</h2>
              <ul class="list-unstyled">
				<?php while($bayiler_row=mysql_fetch_object($footer_bayiler)){?>
                <li><a href=""><?=$bayiler_row->bayi_adi ?></a></li>
				<?php } ?>

              </ul>
            </div>
            <?php 
        $yararli_link_cek = mysql_query("select * from yararli_linkler where status = 1");
        while($yararli_link_oku = mysql_fetch_object($yararli_link_cek)){
          $yararli_linkler .= '<li><a href="'.$yararli_link_oku->link.'">'.$yararli_link_oku->name.'</a></li>';
        }
        ?>
            <div class="col-lg-3">
              <h2 class="footer-heading mb-4">Yararli Linkler</h2>
              <ul class="list-unstyled">
				<?php $pdf_kks_cek=mysql_fetch_object(mysql_query("select * from pdf")) ?>
                <li><a href="../<?=$pdf_kks_cek->kullanim_sartlari ?>">Kullanim Kosul ve Sartlari</a></li>
                <?= $yararli_linkler ?>
              </ul>
            </div>
          </div>
        </div>
      </div>
      <div class="row mt-5 text-center">
        <div class="col-md-12">
          <div class="border-top pt-5">
            <p>
              &copy;
              <script>
                document.write(new Date().getFullYear());
              </script> Tüm Hakları Saklıdır <br>
              <!-- Yazılım & Tasarim <a href="https://eabilisim.net.tr/" target="_blank">EA Bilişim Teknolojileri</a> -->
            </p>
            <!-- <img src="../images/logo2.png">  -->
          </div>
        </div>
      </div>
    </div>
  </footer>
  <script src="https://kit.fontawesome.com/2fdd899201.js" crossorigin="anonymous" ></script>
  <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


   <!-- Yeniler -->
   <script src="../js/popper.min.js"></script>
    <script src="../js/owl.carousel.min.js"></script>
    <script src="../js/jquery.sticky.js"></script>
    <script src="../js/jquery.waypoints.min.js"></script>
    <script src="../js/jquery.animateNumber.min.js"></script>
    <script src="../js/jquery.fancybox.min.js"></script>
    <script src="../js/jquery.easing.1.3.js"></script>
    <script src="../js/bootstrap-datepicker.min.js"></script>
    <script src="../js/aos.js"></script>
    <script src="../js/main.js?v=9"></script>
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
	
	<!--Start of Tawk.to Script-->
<script type="text/javascript">
var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
(function(){
var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
s1.async=true;
s1.src='https://embed.tawk.to/616575c7157d100a41ac02fd/1fhq58579';
s1.charset='UTF-8';
s1.setAttribute('crossorigin','*');
s0.parentNode.insertBefore(s1,s0);
})();
</script>
<!--End of Tawk.to Script-->

<script>
$(document).ready(function() {
  $('input[type="date"]').attr({
    "max" : "9999-12-31"
  });
});
</script>
