



<?php 
   session_start();
   include('../ayar.php');
    $token = $_SESSION['u_token'];
    if(!empty($token)){
      $uye_token = $token;
    }
    if(!isset($_SESSION['u_token'])){
      echo '<script>alert("Devam Etmek İçin Lütfen Giriş Yapın !")</script>';
      echo '<script>window.location.href = "../index.php"</script>';
      }
    $ihale_cek = mysql_query("SELECT * FROM ilanlar ORDER BY ihale_tarihi DESC");
    $dogrudan_cek = mysql_query("SELECT * FROM dogrudan_satisli_ilanlar");
    $dogrudan_satis_sayisi = mysql_num_rows($dogrudan_cek);
    $ihale_sayisi = mysql_num_rows($ihale_cek);
    $kullanici_cek = mysql_query("SELECT * FROM `user` WHERE user_token = '$uye_token'");
    include 'template/sayi_getir.php';
    include 'alert.php';
   
    $getUserInfo = mysql_query("SELECT 
      * 
    FROM 
      user 
    WHERE 
      user_token = '$uye_token' AND 
      user_token <> '0'
    ");
    $userInfo = mysql_fetch_object($getUserInfo);
   
    $getAllFavoriteRecords = mysql_query("SELECT 
      f.*  
    FROM 
      favoriler AS f INNER JOIN 
      ilanlar AS i ON 
        f.ilan_id = i.id 
    WHERE 
      f.uye_id = '$userInfo->id' 
     
    ");
    
    // Sayfalama
            if (isset($_GET['sayfa'])) {
               $sayfa = $_GET['sayfa'];
           } else {
               $sayfa = 1;
           }
           $sayfada = 10;
           $offset = ($sayfa-1) * $sayfada;
           
    
          //  $toplam_sayfa_sql = mysql_query("SELECT COUNT(*) FROM ilanlar");
          //  $toplam_ihale = mysql_fetch_array($toplam_sayfa_sql)[0];
          $toplam_ihale = mysql_num_rows($getAllFavoriteRecords);
          
          $toplam_sayfa = ceil($toplam_ihale / $sayfada);
    
           
           ?>
<!doctype html>
<html lang="tr">
   <head>
      <link rel="stylesheet" href="../css/uye_panel.css?v=15">
      <!-- Required meta tags -->
      <!-- <title>Pert &mdash; Dünyası</title> -->
      <?php
			include '../seo_kelimeler.php';
		?>
      <meta charset="utf-8">
      <meta http-equiv="content-language" content="tr">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <meta name="author" content="EA Bilişim">
      <meta name="Abstract" content="Pert Dünyası sigortadan veya sahibinden kazalı,hasarlı pert araçların 
         online ihale ile veya doğrudan satış yapılabileceği online ihale platformudur.">
      <meta name="description" content="Pert Dünyası Pert Kazalı Araç İhale Sistemi">
      <meta name="keywords" 
         content="hasarlı oto, hasarlı arabalar, hasarlı araçlar, pert araçlar, pert oto, 
         pert arabalar, kazalı araçlar, kazalı oto, kazalı arabalar, hurda araçlar, hurda arabalar, 
         hurda oto, hasarlı ve pert kamyon, hasarlı ve kazalı traktör, kazalı çekici, ihale ile satılan hasarlı araçlar,
         sigortadan satılık pert arabalar, ihaleli araçlar, kapalı ihaleli araçlar, açık ihalelli araçlar, 2.el araç,
         hurda kamyon, hurda traktör, ihaleyle kamyon" >
      <meta name="Copyright" content="Ea Bilişim Tüm Hakları Saklıdır.">
      <script>
         setInterval(function(){
         window.location.reload(false);
         },60000);
      </script>
      <!-- Bootstrap CSS -->
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
      <link rel="stylesheet" href="css/menu.css">
      <title>Pert Dünyası</title>
      <style>
         .uyelik{
         color: yellow !important;
         font-weight: bolder;
         }
         .alt_baslik{
         text-decoration: none !important;
         cursor: pointer;
         color: #000000;           
         }
         .alt_baslik:hover{
         color: red;
         }
         .list-group-item{
         padding-bottom: 0px;
         }         
         tr:nth-child(odd) {
         background-color: rgb(219,238,244);
         }
         table {
         border-collapse: collapse;
         width: 100%;
         margin-top:1%;
         }
         .kod{
         background-color: rgb(78,79,83);
         color: #ffffff;
         }
         a.disabled {
         pointer-events: none;
         cursor: default;
         }
		    .deneme p{
	   margin-bottom:0px!important;
	   margin-top:0px!important;
	   margin-left:15px;
	   
	}
      </style>

<style>
         .ilan_karti_dis
         {
         min-height:10px;
         float:left;
         margin:10px 0px;
         padding:0px;
         }
         .ilan_karti_baslik
         {
         height: 35px;
         background-color: orange;
         float: left;
         padding: 0px;
         line-height: 35px;
         padding-left: 10px;
         font-weight: 600;
         }
         .ilan_karti_baslik span
         {
         float: right;
         background-color: #364d59;
         height: 35px;
         padding: 0px 20px;
         line-height: 35px;
         color: #ffffff;
         font-weight: 600;
         }
         .ilan_karti_icerik_dis
         {
         min-height:20px;
         background-color:#ffffff;
         float:left;
         border:1px solid #dadada;
         border-top:0px;
         padding:0px;
         }
         .ilan_karti_gorsel_dis
         {
         width:200px;
         float:left;
         background-color:maroon;
         background-image:url('images/default.png');
         position:relative;
         background-position:center;
         background-size:cover;
         }
         .ilan_karti_gorsel_dis:after
         {
         content:"";
         display:block;
         padding-bottom:100%;
         }
         .ilan_karti_kod
         {
         height: 40px;
         float: left;
         position: absolute;
         left: 0px;
         bottom: 0px;
         background-color: gray;
         display: flex;
         align-items: center;
         padding: 10px;
         color: #fff;
         }
         .ilan_karti_gorsel_icerik
         {
         width:calc(100% - 200px);
         min-height:200px;
         float:left;
         padding:10px;
         }
         .ilan_karti_taglar_dis
         {
         min-height:20px;
         float:left;
         padding:0px;
         }
         .ilan_karti_tag
         {
         min-width: 10px;
         height: 30px;
         float: left;
         background-color: #f1f1f1;
         margin-right: 10px;
         margin-bottom: 10px;
         padding: 0px 8px;
         line-height: 30px;
         font-weight: 600;
         font-size: 12px;
         }
         .ilan_karti_alt_alan
         {
         min-height:10px;
         float:left;
         padding:0px;
         }
         .ilan_karti_notlar_dis
         {
         min-height:10px;
         float:left;
         padding:0px;
         }
         .ilan_karti_not_baslik
         {
         min-height:10px;
         float:left;
         padding:0px;
         }
         .ilan_karti_not_alan
         {
         height: 75px;
         float: left;
         background-color: #f7f7f7;
         float: left;
         margin-top: 10px;
         padding: 8px;
         font-size: 13px;
         overflow-y: scroll;
         border: 1px solid #eaeaea;
         }
         .ilan_karti_begeni_dis
         {
         height: 26px;
         float: left;
         margin-top: 5px;
         padding: 0px;
         }
         .ilan_karti_begeni_dis span
         {
         width: 26px;
         height: 26px;
         background-color: #e6e6e6;
         margin-right: 10px;
         float: left;
         text-align: center;
         line-height: 27px;
         color: orange;
         border-radius: 3px;
         }
         .ilan_karti_teklif_dis
         {
         min-height:10px;
         float:left;
         }
         .ilan_karti_teklif_baslik
         {
         height: 30px;
         float: left;
         text-align: center;
         line-height: 30px;
         font-weight: 600;
         font-size: 18px;
         }
         .ilan_karti_teklif_fiyat
         {
         min-height: 20px;
         float: left;
         text-align: center;
         font-size: 35px;
         font-weight: 700;
         }
         .ilan_karti_teklif_btnlar
         {
         min-height:20px;
         float:left;
         padding:0px;
         }
         .ilan_karti_teklif_btn
         {
         width: calc(50% - 10px);
         height: 47px;
         float: left;
         margin: 5px;
         text-align: center;
         line-height: 47px;
         color: #ffffff;
         border-radius: 4px;
         font-weight: 500;
         }
         @media only screen and (max-width: 600px) {
         .ilan_karti_baslik
         {
         font-size:9px;
         padding-left:5px;
         }
         .ilan_karti_gorsel_dis
         {
         width:100%;
         }
         .ilan_karti_gorsel_icerik
         {
         width:100%;
         }
         .ilan_karti_begeni_dis
         {
         display:flex;
         align-items:center;
         justify-content:center;
         margin-bottom:15px;
         margin-top:15px;
         }
         .ilan_karti_begeni_dis span
         {
         width:35px;
         height:35px;
         line-height:35px;
         }
         }
      </style>

   </head>
   <body>
   <?php 
$bugun = date("Y-m-d");
$sorgu = mysql_query("SELECT * FROM kutlama_gorseli WHERE '$bugun' < reklam_bitis AND '$bugun' >= reklam_baslangic ORDER BY id ASC LIMIT 1 ");
while($yaz = mysql_fetch_array($sorgu)){
?>
<nav class="deneme" style="padding-bottom: 0%;width:100%; padding-top: 0%;color:<?= $yaz['yazi_renk']?>; background-color:<?= $yaz['arkaplan_renk'] ?>;padding: 0!important;">
	<div style="text-align:center" class="row">
		<div style="text-align:center" class="col-sm-12">
			<?= $yaz['icerik'] ?>
		</div>
	</div>
</nav>
<?php } ?>
      <nav class="navbar navbar-expand-md navbar-dark bg-dark " style="padding-bottom: 0%; padding-top: 0%;">
         <div class="collapse navbar-collapse" id="navbarCollapse" >
  <ul class="navbar-nav mr-auto" >
      <li class="nav-item active">
      <?php $kullanici_oku = mysql_fetch_assoc($kullanici_cek);
	    $uye_id=$kullanici_oku['id'];
       $cayma_cek = mysql_query("SELECT * FROM cayma_bedelleri WHERE uye_id = '".$kullanici_oku['id']."'");
        $cayma_oku = mysql_fetch_assoc($cayma_cek);
        $cayma = money($cayma_oku['tutar'])."₺";
        $paket = $kullanici_oku['paket'];
        $paket_cek = mysql_query("SELECT * FROM uye_grubu WHERE id = '".$paket."'");
        $paket_oku = mysql_fetch_assoc($paket_cek);
        $paket_adi = $paket_oku['grup_adi'];
        if($paket == "1"){          
          $color = "#ffffff";          
        }elseif($paket == "22"){          
          $color = "green";
        }elseif($paket == "21"){
          $color = "yellow";
        }
		$limit_cek = mysql_query("SELECT * FROM teklif_limiti WHERE uye_id = '".$kullanici_oku['id']."'");
        $limit_oku = mysql_fetch_assoc($limit_cek);
		$limit = $limit_oku['standart_limit'];  
		if($limit==0){
			if( $paket_oku["standart_limit_ust"]>100000000000){
				$limit = "Sınırsız ";
				$limit_turu=" (Standart)";
			}else{
				$limit = money($paket_oku["standart_ust_limit"])."₺ ";
				$limit_turu=" (Standart)";
			}
		}else{		
			if($limit>1000000){
				$limit = "Sınırsız ";
				$limit_turu=" (Standart)";
			}else{
				$limit = money($limit_oku['standart_limit'])."₺ ";
				$limit_turu=" (Standart)";
			}
		}
		
		
		$limit2 = $limit_oku['luks_limit']; 
		if($limit2==0){
			if( $paket_oku["luks_limit_ust"]>100000000000){
				$limit2 = "Sınırsız ";
				$limit_turu2=" (Ticari)";
			}else{
				$limit2 = money($paket_oku["lukss_ust_limit"])."₺ ";
				$limit_turu2=" (Ticari)";
			}
		}else{
			if($limit2>1000000){
				$limit2 = "Sınırsız ";
				$limit_turu2=" (Ticari)";
			}else{
				$limit2 = money($limit_oku['luks_limit'])."₺ ";
				$limit_turu2=" (Ticari)";
			}
		}
      
      ?> 
        <a class="nav-link uyelik" style="font-size: large; color:<?= $color ?> !important;" ><?= $paket_adi ?></a> 
      </li>
      <li class="nav-item active" style="font-size: small;">
        <a class="nav-link"><span style="color: #a4a4a4;" >Cayma Bakiyesi : </span>  <?= $cayma ?> </a>
      </li>
      <li class="nav-item active" style="font-size: small;">
        <a class="nav-link" ><span style="color: #a4a4a4;" >Teklif Limiti : </span><?= $limit ?><span style="color: #a4a4a4;" ><?=$limit_turu ?> </span> <?=$limit2 ?> <span style="color: #a4a4a4;" ><?=$limit_turu2 ?> </span></a>
      </li>
    </ul>
            <ul class="navbar-nav" style="font-size: small;">
               <li class="nav-item active dropdown">
                  <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <?= $kullanici_oku['ad'] ?>
                  </a>
                  <div class="dropdown-menu" aria-labelledby="navbarDropdown" style="position: absolute; transform: translate3d(90px, 10px, 0px); top: 15px; left: -190px; will-change: transform;">
                     <a class="dropdown-item" href="index.php">Üye Panelim</a>
                     <a class="dropdown-item" href="gold_uyelik_basvuru.php">Gold Üyelik Başvurusu</a>
                     <?php $pdf_cek=mysql_fetch_object(mysql_query("select * from pdf")) ?>
                     <a class="dropdown-item" href="https://ihale.pertdunyasi.com/pdf.php?id=1&uye_id=<?=$kullanici_oku['id']?>&q=uyelik_pdf" target="_blank">Üyelik Sözleşmesi Görüntüle</a>
					      <a style="display:<?php if($paket == 21){ echo 'block'; }else{ echo 'none'; } ?>" class="dropdown-item" href="https://ihale.pertdunyasi.com/pdf.php?id=1&uye_id=<?=$kullanici_oku['id']?>&q=vekaletname_pdf" target="_blank">Vekaletname Örneği Görüntüle</a>
                     <a class="dropdown-item" href="evrak_yukle.php">Evrak Yükle</a>
                  </div>
               </li>
               <li class="nav-item active mr-0">
                  <a class="nav-link" href="islemler/logout.php"> Çıkış Yap</a>
               </li>
            </ul>
         </div>
      </nav>
      <?php  include 'template/header.php'; ?>
      <div class="container" style="margin-top:10%;">
            <div class="row">
               <div class="col-sm-4">
                  <?php include 'template/sidebar.php'; ?>
               </div>
               <div class="col-sm-8">
                  <?php 
                  $favori_cek = mysql_query("select * from favoriler where uye_id = '".$uye_id."'");
                  while($favori_oku = mysql_fetch_array($favori_cek)){
                     $ilan_cek = mysql_query("select * from ilanlar where id = '".$favori_oku['ilan_id']."'");
                     $ilan_oku = mysql_fetch_assoc($ilan_cek); 
                     $marka_cek = mysql_query("select * from marka where markaID = '".$ilan_oku['marka']."'");
                     $marka_oku = mysql_fetch_assoc($marka_cek);
                  ?>
                     <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ilan_karti_dis"  >
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ilan_karti_baslik" >
                        <?= $ilan_oku['model_yili']." ".$marka_oku['marka_adi']." " . $ilan_oku['model']." " . $ilan_oku['tip']  ?>
                           <span id="sayac<?=$sira?>" ></span>
                           <input type="hidden" id="ihale_sayac<?=$sira?>" value="<?= $ilan_oku['ihale_tarihi'].' '. $ilan_oku['ihale_saati'] ?>">
                           <input type="hidden" id="id_<?=$sira?>" value="<?= $ilan_oku['id'] ?>">
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ilan_karti_icerik_dis">
                           <div class="ilan_karti_gorsel_dis" style="background-image:url('images/<?= $resim ?>');">
                              <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ilan_karti_kod">
                                 #<?= $ilan_oku['arac_kodu'] ?>
                              </div>
                           </div>
                           <div class="ilan_karti_gorsel_icerik">
                              <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ilan_karti_taglar_dis">
                                 <div class="ilan_karti_tag">
                                    <?= $ilan_oku['sehir'] ?>
                                 </div>
                                 <div class="ilan_karti_tag">
                                    <?php if($ilan_oku['ihale_turu']==1){$filtre_turu = "Açık İhale";}else{$filtre_turu="Kapalı İhale";} ?>
                                    <?= $filtre_turu ?>
                                 </div>
                                 <div class="ilan_karti_tag <?= $blink ?>">
                                    <?= $ilan_oku['profil'] ?>
                                 </div>
                                 <div class="ilan_karti_tag">
                                    KAPANIŞ : <?= $ilan_oku['ihale_tarihi']." ".$ilan_oku['ihale_saati'] ?>
                                 </div>
                              </div>
                              <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ilan_karti_alt_alan">
                                 <div class="col-xs-12 col-sm-12 col-md-7 col-lg-7 ilan_karti_notlar_dis">
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ilan_karti_not_baslik">
                                       Sigorta Onay Notu
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ilan_karti_not_alan">
                                       <?php $onay_cek2 = mysql_query("select * from sigorta_ozellikleri where id = '".$ilan_oku['sigorta']."'"); 
                                          $onay_oku2 = mysql_fetch_assoc($onay_cek2);
                                          $onay2 = $onay_oku2['uyari_notu'];
                                          ?>
                                       <?= $onay2 ?>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ilan_karti_begeni_dis">
                                       <form method="POST" action="" name="form">
                                          <button type="submit" name="bildirim_ac" class="btn btn-light mr-2 btn-sm">
                                          <i style="color: <?= $bidlirim_color ?>;" class="icon-notifications"></i>
                                          <input type="hidden" name="bildirimlenecek" value="<?= $ilan_oku['id'] ?>">
                                          </button>                                   
                                          <button type="submit" name="favla" class="btn btn-light btn-sm">
                                          <i style="color: <?= $fav_color ?>;" class="icon-favorite"></i>
                                          <input type="hidden" name="favlanacak" value="<?= $ilan_oku['id'] ?>">
                                          </button>
                                       </form>
                                    </div>
                                 </div>
                                 <style>
                                 </style>
                                 <div class="col-xs-12 col-sm-12 col-md-5 col-lg-5 ilan_karti_teklif_dis">
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ilan_karti_teklif_baslik">
                                       Taban Fiyat
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ilan_karti_teklif_fiyat">
                                       <?= $ilan_oku['acilis_fiyati'] ?> ₺
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ilan_karti_teklif_btnlar">
                                       <div class="ilan_karti_teklif_btn" style="background-color: #424242;">
                                          <a onclick="ihale_arttir(<?=$ilan_oku['id']?>)"  style="text-decoration: none; color:#ffffff;" href="../arac_detay.php?id=<?= $ilan_oku['id'] ?>&q=ihale">İNCELE</a>
                                       </div>
                                       <div class="ilan_karti_teklif_btn" style="background-color: orange;">
                                          <a onclick="kontrol(<?=$ilan_oku['id']?>); " data-toggle="modal" data-target="#teklifVer<?=$ilan_oku['id']?>" style="text-decoration: none; color:#ffffff;" >TEKLİF VER</a>                                                           
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div> 
                  <?php } ?>
               </div>
            </div>


      </div>
      <?php include 'template/footer.php'; ?>
      <script src="https://kit.fontawesome.com/2fdd899201.js" crossorigin="anonymous" ></script>
      <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
      <script>
         // Set the date we're counting down to
         var ihale_sayac = document.getElementById('son_zaman').value;
         var countDownDate = new Date(ihale_sayac).getTime();
         
         // Update the count down every 1 second
         var countdownfunction = setInterval(function() {
         
           // Get todays date and time
           var now = new Date().getTime();
           
           // Find the distance between now an the count down date
           var distance = countDownDate - now;
           
           // Time calculations for days, hours, minutes and seconds
           var days = Math.floor(distance / (1000 * 60 * 60 * 24));
           var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
           var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
           var seconds = Math.floor((distance % (1000 * 60)) / 1000);
           
           // Output the result in an element with id="demo"
           document.getElementById("kalan_zaman").innerHTML = days + "g " + hours + "s "
           + minutes + "d " + seconds + "s ";
           
           // If the count down is over, write some text 
           if (distance < 0) {
             clearInterval(countdownfunction);
             document.getElementById("kalan_zaman").innerHTML = "İhale Kapandı";
           }
         }, 1000);
      </script>
      <script>
         //Sayfa Yenileme 60sn
           setInterval(function(){
           window.location.reload(false);
           },60000);
      </script>
      <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	  	  <script src="../js/cikis_yap.js?v=<?php echo time(); ?>"></script>
		<script >
		 setInterval(function() {
   cikis_yap("<?=$uye_token?>");
 }, 300001);
		   son_islem_guncelle("<?=$uye_token?>");
	 setInterval(function(){ bildirim_sms(); }, 1000);
		</script>
   </body>
</html>