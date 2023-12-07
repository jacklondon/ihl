<?php 
   session_start();
   /* 	$token = $_SESSION['u_token'];
   	$k_token = $_SESSION['k_token'];
   	if($token != "" && $k_token == ""){
   		$uye_token = $token;
   	}elseif($token == "" && $k_token != ""){
   		$uye_token = $k_token;
   	}
   */
   if($_SESSION['u_token'] != "" && $_SESSION['k_token'] == ""){
   	$uye_token = $_SESSION['u_token'];
   }elseif($_SESSION['u_token'] == "" && $_SESSION['k_token'] != ""){
      $uye_token = $_SESSION['k_token'];
   }else{
   	$uye_token="";
   }
   include 'ayar.php';

   if($uye_token != ""){
      $arac_detay_uye_cek = mysql_query("select * from user where user_token = '".$uye_token."' or kurumsal_user_token = '".$uye_token."'");
      $arac_detay_uye_oku = mysql_fetch_object($arac_detay_uye_cek);
      $uye_id = $arac_detay_uye_oku->id;
   }

   $kullanici_grubu=kullanici_grubu_cek($uye_token); //Uye Paketi Sorgula Function 
   $today = date("Y-m-d");
   $hour = date("H:i:s");
   $a1 = $_SERVER['HTTP_USER_AGENT'];    
   //Fonksiyonlar ayar.php de tanımlı
   $os        = getOS();
   $browser   = getBrowser();
   include 'alert.php';
   ?>
<?php 
   // Sayfalama
   if (isset($_GET['sayfa'])) {
   	$sayfa = $_GET['sayfa'];
   } else {
   	$sayfa = 1;
   }
   // $sayfada = 10;
   $sayfada = 50;
   // $sayfada = 100000000;
   $offset = ($sayfa-1) * $sayfada;
   $toplam_sayfa_sql = mysql_query("SELECT COUNT(*) FROM ilanlar");
   $toplam_ihale = mysql_fetch_array($toplam_sayfa_sql)[0];
   $toplam_sayfa = ceil($toplam_ihale / $sayfada);
   $now = strtotime($today); 

   // $sql = mysql_query("SELECT *,concat(ihale_tarihi,' ',ihale_saati) as ihale_son FROM ilanlar WHERE ihale_tarihi >= '".$today."' AND durum = 1 ORDER BY ihale_son ASC LIMIT $offset, $sayfada");
   // $sql = mysql_query("SELECT *,concat(ihale_tarihi,' ',ihale_saati) as ihale_son FROM ilanlar WHERE ihale_son_gosterilme>'".date("Y-m-d H:i:s")."'ORDER BY ihale_son ASC LIMIT $offset, $sayfada");
   // $sql = mysql_query("SELECT *, concat(ihale_tarihi,' ',ihale_saati) as ihale_son FROM ilanlar WHERE durum = 1 ORDER BY ihale_son ASC LIMIT $offset, $sayfada");
   $sql = mysql_query("SELECT *,concat(ihale_tarihi,' ',ihale_saati) as ihale_son FROM ilanlar WHERE ihale_son_gosterilme >= '".date("Y-m-d H:i:s")."' ORDER BY eklenme_zamani DESC LIMIT $offset, $sayfada");
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
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
      <link rel="stylesheet" type="text/css" href="fonts/icomoon/style.css">
      <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
      <link rel="stylesheet" type="text/css" href="css/bootstrap-datepicker.css">
      <link rel="stylesheet" type="text/css" href="css/jquery.fancybox.min.css">
      <link rel="stylesheet" type="text/css" href="css/owl.carousel.min.css">
      <link rel="stylesheet" type="text/css" href="css/owl.theme.default.min.css">
      <link rel="stylesheet" type="text/css" href="fonts/flaticon/font/flaticon.css">
      <link rel="stylesheet" type="text/css" href="css/aos.css">
      <!-- MAIN CSS -->
      <link rel="stylesheet" type="text/css" href="css/style.css?v=<?= time() ?>">
      <link rel="stylesheet" type="text/css" href="css/custom.css">
      <link rel="stylesheet" type="text/css" href="css/ihaledekiler.css?v=<?= time() ?>">
		<link rel="stylesheet" href="css/custom_slider.css?v=<?php echo time(); ?>">
      <link rel="stylesheet" type="text/css" href="js/toastr/toastr.css" rel="stylesheet">
      <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.js"></script>
      <script>
         function locale_kaydet(ilan_id){
         		var baslat=setInterval(function(){
         			enyuksek_getir(ilan_id);
         			degistir(ilan_id);
         			komisyon_kontrol(ilan_id);
         			$("#acik_modal_kapat"+ilan_id).on("click",function(){
         				clearInterval(baslat);
         			});
         			$("#acik_modal_kapat2"+ilan_id).on("click",function(){
         				clearInterval(baslat);
         			});
         			$("#modal_kapat"+ilan_id).on("click",function(){
         				clearInterval(baslat);
         			});
         			$("#modal_kapat2"+ilan_id).on("click",function(){
         				clearInterval(baslat);
         			});
         		},1000)
         }
         function filtre_cikar(key,value){
         	if(key=="yil_" && value=="filtre"){
         		$("#kucuk_yil").val("");
         		$("#buyuk_yil").val("");
         	}else if(key=="aranan_" && value=="filtre"){
         		$("#aranan").val("");
         	}else{
         		document.getElementById(""+key+value).checked=false
         		if(key=="marka_"){
         			$(".modelmarka_"+value).remove();
         		}
         	}
         	document.getElementById("filtrele").click();
         }
      </script>
      <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
   </head>
   <body data-spy="scroll" data-target=".site-navbar-target" data-offset="300">
      <?php include 'modal.php'; ?>
      <input type="hidden" id="ip" value="<?=GetIP() ?>"/>
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
            include 'header.php'; 
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
            			echo '<script>
            					var htmlContent2 = document.createElement("div");
            					htmlContent2.innerHTML = `'.$sitenin_acilis_popupu.'`;
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
            				</script>';			  
            		}else{
            		   echo '<script>
            					var htmlContent2 = document.createElement("div");
            					htmlContent2.innerHTML = `'.$sitenin_acilis_popupu.'`;
            					swal({
            						buttons: false,
            						showCancelButton: false,
            						content:htmlContent2,
            					})			
            					.then((value) => {
            						window.location.href = "hazirlaniyor.php";
            					});
            				</script>';			  
            			$siteye_giren_guncelle = mysql_query("update siteye_girenler set tarih = '".date('Y-m-d H:i:s')."' where ip_adresi = '".getIP()."'");
            		}  
            	}else{
            		if($site_acilis_popup_icin_oku['tarih'] < $siteye_giris_tarih_before){
            			if($sitenin_acilis_popupunu_oku['buton']==1){  
            				echo '<script>
            						var htmlContent2 = document.createElement("div");
            						htmlContent2.innerHTML = `'.$sitenin_acilis_popupu.'`;
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
            					</script>';			  
            				$siteye_giren_guncelle = mysql_query("update siteye_girenler set tarih = '".date('Y-m-d H:i:s')."' where ip_adresi = '".getIP()."'");
            			}else{
            				echo '<script>
            						var htmlContent2 = document.createElement("div");
            						htmlContent2.innerHTML = `'.$sitenin_acilis_popupu.'`;
            						swal({
            							buttons: false,
            							showCancelButton: false,
            							content:htmlContent2,
            						})			
            						.then((value) => {
            							window.location.href = "hazirlaniyor.php";
            						});
            					</script>';
            			}               
            		}
            	}
            }
            $sehir_cek = mysql_query("SELECT * FROM sehir"); 
            $marka_cek = mysql_query("SELECT * FROM marka"); 
            ?>
         <div class="site-section" >
            <div class="row" style="width: calc(94%); margin-left: calc(3%);">
               <div style="margin-top: 2%;" class="row">
                  <script>
                     var expanded = false;
                     function showTur() {
                     	var checkboxes = document.getElementById("turler");
                     	if (!expanded) {
                     		checkboxes.style.display = "block";
                     		expanded = true;
                     	} else {
                     		checkboxes.style.display = "none";
                     		expanded = false;
                     	}
                     }
                     function showSehirler() {
                     	var checkboxes = document.getElementById("sehirler");
                     	if (!expanded) {
                     		checkboxes.style.display = "block";
                     		expanded = true;
                     	} else {
                     		checkboxes.style.display = "none";
                     		expanded = false;
                     	}
                     }
                     function showMarkalar() {
                     	var checkboxes = document.getElementById("markalar");
                     	if (!expanded) {
                     		checkboxes.style.display = "block";
                     		expanded = true;
                     	} else {
                     		checkboxes.style.display = "none";
                     		expanded = false;
                     	}
                     }
                     function showBitis() {
                     	var checkboxes = document.getElementById("tarih");
                     	if (!expanded) {
                     		checkboxes.style.display = "block";
                     		expanded = true;
                     	} else {
                     		checkboxes.style.display = "none";
                     		expanded = false;
                     	}
                     }  
                     function showProfil() {
                     	var checkboxes = document.getElementById("profil");
                     	if (!expanded) {
                     		checkboxes.style.display = "block";
                     		expanded = true;
                     	} else {
                     		checkboxes.style.display = "none";
                     		expanded = false;
                     	}
                     }
                  </script>   
                  <div class="col-sm-4">
                     <form method="POST" name="filter" >
                        <div class="filter_outer">
                           <div class="filter_title_outer">
                              Kelime ile ara
                           </div>
                           <div class="filter_check_outer">
                              <?php
                                 if($_POST["aranan"]!="" ){ ?>
                              <div class="filter_check_box" style="width:100%;">
                                 <input type="search" name="aranan" id="aranan" class="form-control" value="<?=$_POST["aranan"] ?>"  placeholder="Plaka, araç kodu vb..">
                              </div>
                              <?php }else { ?>
                              <div class="filter_check_box" style="width:100%;">
                                 <input type="search" name="aranan" id="aranan" class="form-control" placeholder="Plaka, araç kodu vb..">
                              </div>
                              <?php } ?>
                           </div>
                        </div>
                        <div class="filter_outer">
                           <?php 
                              $tur1_cek = mysql_query("SELECT * FROM ilanlar WHERE durum = 1 AND ihale_turu = 1"); 
                              $tur2_cek = mysql_query("SELECT * FROM ilanlar WHERE durum = 1 AND ihale_turu = 2 AND CONCAT_WS('', ihale_tarihi, ihale_saati) >= '".date('Y-m-d H:i:s')."'"); 
                              $tur1_say = mysql_num_rows($tur1_cek);
                              $tur2_say = mysql_num_rows($tur2_cek);
                              ?>
                           <div class="filter_title_outer">
                              İhale Türüne Göre
                           </div>
                           <div class="filter_check_box" style="width:calc(100% / 2); <?php if($tur1_say == 0){ echo "display: none;"; } ?>">
                              <?php 
                                 $tu = 0;
                                 $seciliTurSayisi = count($_POST['ihaleTur']);
                                 if($seciliTurSayisi!=0){
                                 	while ($tu < $seciliTurSayisi) {
                                 		if($_POST['ihaleTur'][$tu] == 1){ 
                                 			$ihale_tur1_check="checked";
                                 		}
                                 	$tu++; } ?>
                              <input type="checkbox" <?=$ihale_tur1_check ?> name="ihaleTur[]" id="ihale_tur1" value="1" />Açık Artırma <?= $tur1_say ?>
                              <?php }else{ ?>
                              <input type="checkbox" name="ihaleTur[]" id="ihale_tur1" value="1" />Açık Artırma <?= $tur1_say ?>
                              <?php } ?>
                           </div>
                           <div class="filter_check_box" style="width:calc(100% / 2); <?php if($tur2_say == 0){ echo "display: none;"; } ?>">
                              <?php 
                                 $tu = 0;
                                 $seciliTurSayisi = count($_POST['ihaleTur']);
                                 if($seciliTurSayisi!=0){
                                 	while ($tu < $seciliTurSayisi) {
                                 		if($_POST['ihaleTur'][$tu] == 2){ 
                                 			$ihale_tur2_check="checked";
                                 		} $tu++; } ?>
                              <input type="checkbox" <?=$ihale_tur2_check ?> name="ihaleTur[]" id="ihale_tur2" value="2" />Kapalı İhale  <?= $tur2_say ?>
                              <?php } else { ?>
                              <input type="checkbox" name="ihaleTur[]" id="ihale_tur2" value="2" />Kapalı İhale  <?= $tur2_say ?>
                              <?php } ?>
                           </div>
                        </div>
                        <div class="filter_outer">
                           <?php 
                              $vites1_cek = mysql_query("SELECT * FROM ilanlar WHERE durum = 1 AND vites_tipi = 'Düz Vites'"); 
                              $vites2_cek = mysql_query("SELECT * FROM ilanlar WHERE durum = 1 AND vites_tipi = 'Otomatik Vites'"); 
                              $vites1_say = mysql_num_rows($vites1_cek);
                              $vites2_say = mysql_num_rows($vites2_cek);
                           ?>
                           <div class="filter_title_outer">
                              Vites Türüne Göre
                           </div>
                           <div class="filter_check_box" style="width:calc(100% / 2); <?php if($vites1_say == 0){ echo "display: none;"; } ?>">
                              <?php 
                                 $vi = 0;
                                 $seciliVitesSayisi = count($_POST['vitesTur']);
                                 if($seciliVitesSayisi!=0){
                                 	while ($vi < $seciliVitesSayisi) {
                                 		if($_POST['vitesTur'][$vi] == 1){ 
                                 			$vites_tur1_check="checked";
                                 		}
                                 	$vi++; } ?>
                              <input type="checkbox" <?=$vites_tur1_check ?> name="vitesTur[]" id="vites_tur1" value="1" />Düz Vites <?= $vites1_say ?>
                              <?php }else{ ?>
                              <input type="checkbox" name="vitesTur[]" id="vites_tur1" value="1" />Düz Vites <?= $vites1_say ?>
                              <?php } ?>
                           </div>
                           <div class="filter_check_box" style="width:calc(100% / 2); <?php if($vites2_say == 0){ echo "display: none;"; } ?>">
                              <?php 
                                 $vi = 0;
                                 $seciliVitesSayisi = count($_POST['vitesTur']);
                                 if($seciliVitesSayisi!=0){
                                 	while ($vi < $seciliVitesSayisi) {
                                 		if($_POST['vitesTur'][$vi] == 2){ 
                                 			$vites_tur2_check="checked";
                                 		} $vi++; } ?>
                              <input type="checkbox" <?=$vites_tur2_check ?> name="vitesTur[]" id="vites_tur2" value="2" />Otomatik Vites  <?= $vites2_say ?>
                              <?php } else { ?>
                              <input type="checkbox" name="vitesTur[]" id="vites_tur2" value="2" />Otomatik Vites  <?= $vites2_say ?>
                              <?php } ?>
                           </div>
                        </div>
                        <div class="filter_outer">
                           <?php 
                              $yakit1_cek = mysql_query("SELECT * FROM ilanlar WHERE durum = 1 AND yakit_tipi = 'Benzinli'"); 
                              $yakit2_cek = mysql_query("SELECT * FROM ilanlar WHERE durum = 1 AND yakit_tipi = 'Benzin+Lpg'"); 
                              $yakit3_cek = mysql_query("SELECT * FROM ilanlar WHERE durum = 1 AND yakit_tipi = 'Dizel'"); 
                              $yakit4_cek = mysql_query("SELECT * FROM ilanlar WHERE durum = 1 AND yakit_tipi = 'Hybrit'"); 
                              $yakit5_cek = mysql_query("SELECT * FROM ilanlar WHERE durum = 1 AND yakit_tipi = 'Elektrikli'"); 
                              $yakit1_say = mysql_num_rows($yakit1_cek);
                              $yakit2_say = mysql_num_rows($yakit2_cek);
                              $yakit3_say = mysql_num_rows($yakit3_cek);
                              $yakit4_say = mysql_num_rows($yakit4_cek);
                              $yakit5_say = mysql_num_rows($yakit5_cek);
                           ?>
                           <div class="filter_title_outer">
                              Yakıt Türüne Göre
                           </div>
                           <div class="filter_check_box" style="width:calc(100% / 2); <?php if($yakit1_say == 0){ echo "display: none;"; } ?>">
                              <?php 
                                 $yi = 0;
                                 $seciliYakiitSayisi = count($_POST['yakitTur']);
                                 if($seciliYakiitSayisi!=0){
                                 	while ($yi < $seciliYakiitSayisi) {
                                 		if($_POST['yakitTur'][$yi] == 1){ 
                                 			$yakit_tur1_check="checked";
                                 		}
                                 	$yi++; } ?>
                              <input type="checkbox" <?=$yakit_tur1_check ?> name="yakitTur[]" id="yakit_tur1" value="1" />Benzinli <?= $yakit1_say ?>
                              <?php }else{ ?>
                              <input type="checkbox" name="yakitTur[]" id="yakit_tur1" value="1" />Benzinli <?= $yakit1_say ?>
                              <?php } ?>
                           </div>
                           
                           <div class="filter_check_box" style="width:calc(100% / 2); <?php if($yakit2_say == 0){ echo "display: none;"; } ?>">
                              <?php 
                                 $yi = 0;
                                 $seciliYakiitSayisi = count($_POST['yakitTur']);
                                 if($seciliYakiitSayisi!=0){
                                 	while ($yi < $seciliYakiitSayisi) {
                                 		if($_POST['yakitTur'][$yi] == 2){ 
                                 			$yakit_tur2_check="checked";
                                 		}
                                 	$yi++; } ?>
                              <input type="checkbox" <?=$yakit_tur2_check ?> name="yakitTur[]" id="yakit_tur2" value="2" />Benzin+Lpg <?= $yakit2_say ?>
                              <?php }else{ ?>
                              <input type="checkbox" name="yakitTur[]" id="yakit_tur2" value="2" />Benzin+Lpg <?= $yakit2_say ?>
                              <?php } ?>
                           </div>

                           <div class="filter_check_box" style="width:calc(100% / 2); <?php if($yakit3_say == 0){ echo "display: none;"; } ?>">
                              <?php 
                                 $yi = 0;
                                 $seciliYakiitSayisi = count($_POST['yakitTur']);
                                 if($seciliYakiitSayisi!=0){
                                 	while ($yi < $seciliYakiitSayisi) {
                                 		if($_POST['yakitTur'][$yi] == 3){ 
                                 			$yakit_tur3_check="checked";
                                 		}
                                 	$yi++; } ?>
                              <input type="checkbox" <?=$yakit_tur3_check ?> name="yakitTur[]" id="yakit_tur3" value="3" /><b>Dizel <?= $yakit3_say ?></b>
                              <?php }else{ ?>
                              <input type="checkbox" name="yakitTur[]" id="yakit_tur3" value="3" />Dizel <?= $yakit3_say ?>
                              <?php } ?>
                           </div>

                           <div class="filter_check_box" style="width:calc(100% / 2); <?php if($yakit4_say == 0){ echo "display: none;"; } ?>">
                              <?php 
                                 $yi = 0;
                                 $seciliYakiitSayisi = count($_POST['yakitTur']);
                                 if($seciliYakiitSayisi!=0){
                                 	while ($yi < $seciliYakiitSayisi) {
                                 		if($_POST['yakitTur'][$yi] == 4){ 
                                 			$yakit_tur4_check="checked";
                                 		}
                                 	$yi++; } ?>
                              <input type="checkbox" <?=$yakit_tur4_check ?> name="yakitTur[]" id="yakit_tur4" value="4" /><b>Hybrit <?= $yakit4_say ?></b>
                              <?php }else{ ?>
                              <input type="checkbox" name="yakitTur[]" id="yakit_tur4" value="4" />Hybrit <?= $yakit4_say ?>
                              <?php } ?>
                           </div>

                           <div class="filter_check_box" style="width:calc(100% / 2); <?php if($yakit5_say == 0){ echo "display: none;"; } ?>">
                              <?php 
                                 $yi = 0;
                                 $seciliYakiitSayisi = count($_POST['yakitTur']);
                                 if($seciliYakiitSayisi!=0){
                                 	while ($yi < $seciliYakiitSayisi) {
                                 		if($_POST['yakitTur'][$yi] == 5){ 
                                 			$yakit_tur5_check="checked";
                                 		}
                                 	$yi++; } ?>
                              <input type="checkbox" <?=$yakit_tur5_check ?> name="yakitTur[]" id="yakit_tur5" value="5" /><b>Elektrikli <?= $yakit5_say ?></b>
                              <?php }else{ ?>
                              <input type="checkbox" name="yakitTur[]" id="yakit_tur5" value="5" />Elektrikli <?= $yakit5_say ?>
                              <?php } ?>
                           </div>
                        </div>
                        <div class="filter_outer">
                           <div class="filter_title_outer">
                              Markaya Göre
                           </div>
                           <div class="filter_check_outer">
                              <?php
                                 $seciliMarkaSayisi = count($_POST['marka']);
                                 if($seciliMarkaSayisi!=0){
                                 	$marka_array=array();
                                 	$tu = 0;
                                 	while($marka_oku = mysql_fetch_array($marka_cek)){
                                 		$marka_say = mysql_query("SELECT * FROM ilanlar WHERE durum=1 and marka = '".$marka_oku['markaID']."'");
                                 		$marka_sayi = mysql_num_rows($marka_say);
                                 		$marka_array[$tu]="";
                                 		for($i=0;$i<count($_POST["marka"]);$i++){
                                 			if($marka_oku["markaID"]==$_POST["marka"][$i]){
                                 				$marka_array[$tu]="checked";
                                 			}
                                 		}
                                 	?>       
                              <div class="filter_check_box" style="width:calc(100% / 2); <?php if($marka_sayi == 0){ echo "display: none;"; } ?>">
                                 <?php 											
                                    if($marka_array[$tu] == "checked" ){ ?>
                                 <input type="checkbox" checked id="marka_<?= $marka_oku['markaID'] ?>" name="marka[]" onclick="modelGetir('<?= $marka_oku['markaID'] ?>')" value="<?= $marka_oku['markaID'] ?>" /><?= $marka_oku['marka_adi']." ".$marka_sayi ?>
                                 <?php  }else{ ?>
                                 <input type="checkbox" id="marka_<?= $marka_oku['markaID'] ?>" name="marka[]" onclick="modelGetir('<?= $marka_oku['markaID'] ?>')" value="<?= $marka_oku['markaID'] ?>" /><?= $marka_oku['marka_adi']." ".$marka_sayi ?>
                                 <?php } ?>
                              </div>
                              <?php $tu++; } ?>												
                              <?php }else{ 
                                 while($marka_oku = mysql_fetch_array($marka_cek)){
                                 	$marka_say = mysql_query("SELECT * FROM ilanlar WHERE durum=1 and marka = '".$marka_oku['markaID']."'");
                                 	$marka_sayi = mysql_num_rows($marka_say);
                                 ?>
                              <div class="filter_check_box" style="width:calc(100% / 2); <?php if($marka_sayi == 0){ echo "display: none;"; } ?>">
                                 <input type="checkbox" id="marka_<?= $marka_oku['markaID'] ?>" name="marka[]" onclick="modelGetir('<?= $marka_oku['markaID'] ?>')" value="<?= $marka_oku['markaID'] ?>" /><?= $marka_oku['marka_adi']." ".$marka_sayi ?>
                              </div>
                              <?php } } ?>
                           </div>
                        </div>
                        <div class="filter_outer">
                           <div class="filter_title_outer">
                              Modele Göre
                           </div>
                           <div class="filter_check_outer" id="modeller">
                              <?php 
                                 $tu = 0;
                                 $tu2 = 0;
                                 $seciliModelSayisi = count($_POST['model']);
                                 $model_array=array();
                                 if($seciliModelSayisi==0){ ?>
                              <?php }else{ 
                                 while($tu2<$seciliMarkaSayisi){
                                 	$model_cek=mysql_query("select * from model where marka_id='".$_POST["marka"][$tu2]."'");
                                 	while($model_oku=mysql_fetch_array($model_cek)){
                                 		$model_say=mysql_query("select * from ilanlar where marka='".$_POST["marka"][$tu2]."' and model='".$model_oku["model_adi"]."' and durum=1");
                                 		$model_sayisi=mysql_num_rows($model_say);
                                 		$model_array[$tu]="";
                                 		for($i=0;$i<count($_POST["model"]);$i++){
                                 			if($model_oku["model_adi"]==$_POST["model"][$i]){
                                 				$model_array[$tu]="checked";
                                 			}
                                 		}
                                 	?>
                              <div class="filter_check_box modelmarka_<?=$model_oku["marka_id"]?>" style="width:calc(100% / 2);<?php if($model_sayisi == 0){ echo "display: none;"; } ?>" >
                                 <input <?=$model_array[$tu] ?> type="checkbox" id="model_<?=$model_oku["model_adi"] ?>" name="model[]" value="<?=$model_oku["model_adi"] ?>" /><?= $model_oku["model_adi"]." ".$model_sayisi ?>	
                              </div>
                              <?php  $tu++;  }  ?>						
                              <?php $tu2++; }
                                 }
                                 ?>
                           </div>
                           <!--<div class="filter_check_outer" id="modeller">                                       
                              </div>-->
                        </div>
                        <div class="filter_outer">
                           <div class="filter_title_outer">
                              Şehire Göre
                           </div>
                           <div class="filter_check_outer">
                              <?php
                                 $seciliSehirSayisi = count($_POST['sehir']);
                                 if($seciliSehirSayisi!=0){
                                 	$sehir_check=array();
                                 	$tu = 0;
                                 	$sehir_cek=mysql_query("select * from sehir");
                                 	 while($sehir_oku = mysql_fetch_array($sehir_cek)){
                                 		$sehir_say = mysql_query("SELECT * FROM ilanlar WHERE sehir = '".$sehir_oku['sehiradi']."' and durum=1");
                                 		$sehir_sayi = mysql_num_rows($sehir_say);
                                 		$sehir_check[$tu]="";
                                 		for($i=0;$i<count($_POST['sehir']);$i++){ 
                                 			if($sehir_oku["sehiradi"]==$_POST["sehir"][$i]){
                                 				$sehir_check[$tu]="checked";
                                 			}
                                 		
                                 		} ?>
                              <div class="filter_check_box" style="width:calc(100% / 2); <?php if($sehir_sayi == 0){ echo "display: none;"; } ?>">
                                 <?php 											
                                    if($sehir_check[$tu] == "checked" ){ ?>
                                 <input type="checkbox" checked id="sehir_<?= $sehir_oku['sehiradi'] ?>" id="sehir_<?=$sehir_oku['sehiradi'] ?>" name="sehir[]" value="<?= $sehir_oku['sehiradi'] ?>" /><?= $sehir_oku['sehiradi']." ".$sehir_sayi ?>
                                 <?php  }else{ ?>
                                 <input type="checkbox" id="sehir_<?= $sehir_oku['sehiradi'] ?>" id="sehir_<?=$sehir_oku['sehiradi'] ?>" name="sehir[]"  value="<?= $sehir_oku['sehiradi'] ?>" /><?= $sehir_oku['sehiradi']." ".$sehir_sayi ?>
                                 <?php } ?>
                                 <?php  ?>												   
                              </div>
                              <?php $tu++; } ?> 
                              <?php }else{ 
                                 while($sehir_oku = mysql_fetch_array($sehir_cek)){
                                 	$sehir_say = mysql_query("SELECT * FROM ilanlar WHERE sehir = '".$sehir_oku['sehiradi']."' and durum=1");
                                 	$sehir_sayi = mysql_num_rows($sehir_say);	?>
                              <div class="filter_check_box" style="width:calc(100% / 2); <?php if($sehir_sayi == 0){ echo "display: none;"; } ?>">
                                 <input type="checkbox" name="sehir[]" id="sehir_<?=$sehir_oku['sehiradi'] ?>" value="<?= $sehir_oku['sehiradi'] ?>" /><?= $sehir_oku['sehiradi']." ".$sehir_sayi ?>
                              </div>
                              <?php } } ?>
                           </div>
                           <!-- <div class="filter_check_outer">
                              <?php while($sehir_oku = mysql_fetch_array($sehir_cek)){
                                 $sehir_say = mysql_query("SELECT * FROM ilanlar WHERE sehir = '".$sehir_oku['sehiradi']."'");
                                 $sehir_sayi = mysql_num_rows($sehir_say);
                                 ?>     
                              <div class="filter_check_box" style="width:calc(100% / 2); <?php if($sehir_sayi == 0){ echo "display: none;"; } ?>">
                              <input type="checkbox" name="sehir[]" value="<?= $sehir_oku['sehiradi'] ?>" /><?= $sehir_oku['sehiradi']." ".$sehir_sayi ?>
                              </div>                   
                              <?php } ?> 
                              </div> -->
                        </div>
                        <div class="filter_outer">
                           <div class="filter_title_outer">
                              İhale Kapanış Tarihine Göre
                           </div>
                           <div class="filter_check_outer">
                              <?php 
                                 $bugun = date("Y-m-d");
                                 $yarin = date("Y.m.d",strtotime('+1 days'));
                                 $bugun_biten = mysql_query("SELECT * FROM ilanlar WHERE ihale_tarihi = '".$bugun."' ");
                                 $bugun_bitenler = mysql_num_rows($bugun_biten);                              
                                 $yarin_biten = mysql_query("SELECT * FROM ilanlar WHERE ihale_tarihi = '".$yarin."'");
                                 $yarin_bitenler = mysql_num_rows($yarin_biten);
                                 $seciliKapanisSayisi = count($_POST['tarih']);
                                 if($seciliKapanisSayisi!=0){ 
                                 	$kapanis_check=array();
                                 	$tu = 0;
                                 	$ilan_tarihleri=mysql_query("select *,count(id) as ihale_sayisi from ilanlar where durum=1 group by ihale_tarihi");
                                 	while($ilan_tarihleri_oku=mysql_fetch_array($ilan_tarihleri)){
                                 		$tarih="";
                                 		$kapanis_check[$tu]="";
                                 		for($i=0;$i<count($_POST['tarih']);$i++){ 
                                 			if($ilan_tarihleri_oku["ihale_tarihi"]==$_POST["tarih"][$i]){
                                 				$kapanis_check[$tu]="checked";
                                 			}
                                 		} 
                                 		if($ilan_tarihleri_oku["ihale_tarihi"]==date("Y-m-d")){
                                 			$tarih="Bugün";
                                 		}else if($ilan_tarihleri_oku["ihale_tarihi"]==date("Y-m-d", strtotime("+1 day"))){
                                 			$tarih="Yarın";
                                 		}else{
                                 			$tarih=date("d-m-Y",strtotime($ilan_tarihleri_oku["ihale_tarihi"]));
                                 		}
                                 		?>
                              <div class="filter_check_box" style="width:calc(100% / 3); <?php if($ilan_tarihleri_oku["ihale_sayisi"] == 0){ echo "display: none;"; } ?>">
                                 <input <?=$kapanis_check[$tu]?> type="checkbox" name="tarih[]" id="tarih_<?=$ilan_tarihleri_oku["ihale_tarihi"] ?>" value="<?=$ilan_tarihleri_oku["ihale_tarihi"] ?>" /><?=$tarih ?> (<?= $ilan_tarihleri_oku["ihale_sayisi"] ?>)
                              </div>
                              <?php $tu++; }
                                 /*$bugun="";
                                 $yarin="";
                                 for($i=0;$i<count($_POST["tarih"]);$i++){
                                 	if($_POST["tarih"][$i]==date('Y-m-d')){
                                 		$bugun="checked";
                                 	}
                                 	if($_POST["tarih"][$i]==date("Y-m-d", strtotime("+1 day"))){
                                 		$yarin="checked";
                                 	}
                                 }?>
                              <?php if($bugun=="checked"){ ?>
                              <div class="filter_check_box" style="width:calc(100% / 3); <?php if($bugun_bitenler == 0){ echo "display: none;"; } ?>">
                                 <input checked type="checkbox" name="tarih[]" id="tarih_bugun" value=" <?= date('Y-m-d') ?>" />Bugün <?= $bugun_bitenler ?>
                              </div>
                              <?php }else{ ?>
                              <div class="filter_check_box" style="width:calc(100% / 3); <?php if($bugun_bitenler == 0){ echo "display: none;"; } ?>">
                                 <input type="checkbox" name="tarih[]" id="tarih_bugun" value=" <?= date('Y-m-d') ?>" />Bugün <?= $bugun_bitenler ?>
                              </div>
                              <?php }?>
                              <?php if($yarin=="checked"){ ?>
                              <div class="filter_check_box" style="width:calc(100% / 3); <?php if($yarin_bitenler == 0){ echo "display: none;"; } ?>">
                                 <input checked type="checkbox" name="tarih[]" id="tarih_yarin" value="<?= date("Y-m-d", strtotime("+1 day")) ?>" />Yarın <?= $yarin_bitenler ?>
                              </div>
                              <?php }else{ ?>
                              <div class="filter_check_box" style="width:calc(100% / 3); <?php if($yarin_bitenler == 0){ echo "display: none;"; } ?>">
                                 <input type="checkbox" name="tarih[]" id="tarih_yarin" value="<?= date("Y-m-d", strtotime("+1 day")) ?>" />Yarın <?= $yarin_bitenler ?>
                              </div>
                              <?php }*/?>
                              <?php } else { 
                                 $ilan_tarihleri=mysql_query("select *,count(id) as ihale_sayisi from ilanlar where durum=1 group by ihale_tarihi");
                                 while($ilan_tarihleri_oku=mysql_fetch_array($ilan_tarihleri)){
                                 	$tarih="";
                                 	if($ilan_tarihleri_oku["ihale_tarihi"]==date("Y-m-d")){
                                 		$tarih="Bugün";
                                 	}else if($ilan_tarihleri_oku["ihale_tarihi"]==date("Y-m-d", strtotime("+1 day"))){
                                 		$tarih="Yarın";
                                 	}else{
                                 		$tarih=date("d-m-Y",strtotime($ilan_tarihleri_oku["ihale_tarihi"]));
                                 	}
                                 	?>
                              <div class="filter_check_box" style="width:calc(100% / 3); <?php if($ilan_tarihleri_oku["ihale_sayisi"] == 0){ echo "display: none;"; } ?>">
                                 <input type="checkbox" name="tarih[]" id="tarih_<?=$ilan_tarihleri_oku["ihale_tarihi"] ?>" value="<?=$ilan_tarihleri_oku["ihale_tarihi"] ?>" /><?=$tarih ?> (<?= $ilan_tarihleri_oku["ihale_sayisi"] ?>)
                              </div>
                              <?php } ?>
                              <!--<div class="filter_check_box" style="width:calc(100% / 3); <?php if($bugun_bitenler == 0){ echo "display: none;"; } ?>">
                                 <input type="checkbox" name="tarih[]" id="tarih_bugun" value=" <?= date('Y-m-d') ?>" />Bugün <?= $bugun_bitenler ?>
                                 </div>
                                 <div class="filter_check_box" style="width:calc(100% / 3); <?php if($yarin_bitenler == 0){ echo "display: none;"; } ?>">
                                 <input type="checkbox" name="tarih[]" id="tarih_yarin" value="<?= date("Y-m-d", strtotime("+1 day")) ?>" />Yarın <?= $yarin_bitenler ?>
                                 </div>-->
                              <?php }  ?>
                           </div>
                        </div>
                        <div class="filter_outer">
                           <div class="filter_title_outer">
                              Profile Göre
                           </div>
                           <div class="filter_check_outer">
                              <?php 
                                 $cekme_pert_say = mysql_query("SELECT * FROM ilanlar WHERE profil = 'Çekme Belgeli/Pert Kayıtlı' and durum=1");
                                 $cekme_say = mysql_query("SELECT * FROM ilanlar WHERE profil = 'Çekme Belgeli' and durum=1");
                                 $hurda_say = mysql_query("SELECT * FROM ilanlar WHERE profil = 'Hurda Belgeli' and durum=1");
                                 $plakali_say = mysql_query("SELECT * FROM ilanlar WHERE profil = 'Plakalı' and durum=1");
                                 $cekme_pertler = mysql_num_rows($cekme_pert_say);
                                 $cekmeliler = mysql_num_rows($cekme_say);
                                 $hurdalar = mysql_num_rows($hurda_say);
                                 $plakalilar = mysql_num_rows($plakali_say);
                                 $seciliProfilSayisi = count($_POST['profil']);
                                 if($seciliProfilSayisi!=0){ 
                                 	$pert_checked="";
                                 	$cekme_checked="";
                                 	$hurda_checked="";
                                 	$plakalilar_checked="";
                                 	for($i=0;$i<count($_POST["profil"]);$i++){
                                 		if($_POST["profil"][$i]=="Çekme Belgeli/Pert Kayıtlı"){
                                 			$pert_checked="checked";
                                 		}
                                 		if($_POST["profil"][$i]=="Çekme Belgeli"){
                                 			$cekme_checked="checked";
                                 		}
                                 		if($_POST["profil"][$i]=="Hurda Belgeli"){
                                 			$hurda_checked="checked";
                                 		}
                                 		if($_POST["profil"][$i]=="Plakalı"){
                                 			$plakalilar_checked="checked";
                                 		}
                                 	}?>
                              <?php if($pert_checked=="checked"){ ?>
                              <div class="filter_check_box" style="width:calc(100% / 1); <?php if($cekme_pertler == 0){ echo "display: none;"; } ?>">
                                 <input checked type="checkbox" name="profil[]"  id="profil_pert" value="Çekme Belgeli/Pert Kayıtlı" />Çekme Belgeli/Pert Kayıtlı <?= $cekme_pertler ?>
                              </div>
                              <?php }else{ ?>
                              <div class="filter_check_box" style="width:calc(100% / 1); <?php if($cekme_pertler == 0){ echo "display: none;"; } ?>">
                                 <input  type="checkbox" name="profil[]"  id="profil_pert" value="Çekme Belgeli/Pert Kayıtlı" />Çekme Belgeli/Pert Kayıtlı <?= $cekme_pertler ?>
                              </div>
                              <?php }?>
                              <?php if($cekme_checked=="checked"){ ?>
                              <div class="filter_check_box" style="width:calc(100% / 1); <?php if($cekmeliler == 0){ echo "display: none;"; } ?>">
                                 <input checked type="checkbox" name="profil[]" id="profil_cekme" value="Çekme Belgeli" />Çekme Belgeli <?= $cekmeliler ?>
                              </div>
                              <?php }else{ ?>
                              <div class="filter_check_box" style="width:calc(100% / 1); <?php if($cekmeliler == 0){ echo "display: none;"; } ?>">
                                 <input type="checkbox" name="profil[]" id="profil_cekme" value="Çekme Belgeli" />Çekme Belgeli <?= $cekmeliler ?>
                              </div>
                              <?php }?>
                              <?php if($hurda_checked=="checked"){ ?>
                              <div class="filter_check_box" style="width:calc(100% / 1); <?php if($hurdalar == 0){ echo "display: none;"; } ?>">
                                 <input checked type="checkbox" name="profil[]" id="profil_hurda" value="Hurda Belgeli" />Hurda Belgeli <?= $hurdalar ?>
                              </div>
                              <?php }else{ ?>
                              <div class="filter_check_box" style="width:calc(100% / 1); <?php if($hurdalar == 0){ echo "display: none;"; } ?>">
                                 <input type="checkbox" name="profil[]" id="profil_hurda" value="Hurda Belgeli" />Hurda Belgeli <?= $hurdalar ?>
                              </div>
                              <?php }?>
                              <?php if($plakalilar_checked=="checked"){ ?>
                              <div class="filter_check_box" style="width:calc(100% / 1); <?php if($plakalilar == 0){ echo "display: none;"; } ?>">
                                 <input checked type="checkbox" name="profil[]" id="profil_plakali" value="Plakalı" />Plakalı <?= $plakalilar ?>
                              </div>
                              <?php }else{ ?>
                              <div class="filter_check_box" style="width:calc(100% / 1); <?php if($plakalilar == 0){ echo "display: none;"; } ?>">
                                 <input type="checkbox" name="profil[]" id="profil_plakali" value="Plakalı" />Plakalı <?= $plakalilar ?>
                              </div>
                              <?php }?>
                              <?php }else{ ?>
                              <div class="filter_check_box" style="width:calc(100% / 1); <?php if($cekme_pertler == 0){ echo "display: none;"; } ?>">
                                 <input type="checkbox" name="profil[]" id="profil_pert" value="Çekme Belgeli/Pert Kayıtlı" />Çekme Belgeli/Pert Kayıtlı <?= $cekme_pertler ?>
                              </div>
                              <div class="filter_check_box" style="width:calc(100% / 1); <?php if($cekmeliler == 0){ echo "display: none;"; } ?>">
                                 <input type="checkbox" name="profil[]" id="profil_cekme" value="Çekme Belgeli" />Çekme Belgeli <?= $cekmeliler ?>
                              </div>
                              <div class="filter_check_box" style="width:calc(100% / 1); <?php if($hurdalar == 0){ echo "display: none;"; } ?>">
                                 <input type="checkbox" name="profil[]" id="profil_hurda" value="Hurda Belgeli" />Hurda Belgeli <?= $hurdalar ?>
                              </div>
                              <div class="filter_check_box" style="width:calc(100% / 1); <?php if($plakalilar == 0){ echo "display: none;"; } ?>">
                                 <input type="checkbox" name="profil[]" id="profil_plakali" value="Plakalı" />Plakalı <?= $plakalilar ?>
                              </div>
                              <?php }  ?>
                           </div>
                        </div>
                        <div class="filter_outer">
                           <div class="filter_title_outer">
                              Model Yılına Göre
                           </div>
                           <div class="filter_check_outer">
                              <?php
                                 if($_POST["kucuk_yil"]!="" || $_POST["buyuk_yil"]!="" ){ ?>
                              <div class="filter_check_box" style="width:calc(100% / 2);">
                                 <input type="number"  id="kucuk_yil" name="kucuk_yil" class="form-control" placeholder="En Düşük" min="1950" value="<?=$_POST["kucuk_yil"] ?>" max="<?php echo date("Y"); ?>" />
                              </div>
                              <div class="filter_check_box" style="width:calc(100% / 2);">
                                 <input type="number"  id="buyuk_yil" name="buyuk_yil" class="form-control" placeholder="En Yüksek" min="1950" value="<?=$_POST["buyuk_yil"] ?>"  max="<?php echo date("Y"); ?>" />
                              </div>
                              <?php }else { ?>
                              <div class="filter_check_box" style="width:calc(100% / 2);">
                                 <input type="number"  id="kucuk_yil" name="kucuk_yil" class="form-control" placeholder="En Düşük" min="1950" max="<?php echo date("Y"); ?>" />
                              </div>
                              <div class="filter_check_box" style="width:calc(100% / 2);">
                                 <input type="number"  id="buyuk_yil" name="buyuk_yil" class="form-control" placeholder="En Yüksek" min="1950" max="<?php echo date("Y"); ?>" />
                              </div>
                              <?php } ?>
                           </div>
                        </div>
                        <button type="submit" name="filtrele" id="filtrele" class="btn btn-primary" style="width:100%; margin-bottom:10px;">Ara</button>
                        <!-- <iframe src="son_gezdiklerim_slider.php" height="450" width="100%" style="border:0px;"></iframe> -->
                        <!-- <input type="hidden" id="sira_array" value="<?=$sira_array; ?>">
                        <?php
                           $sira_array2=array();
                           $vitrin_cek=mysql_query("SELECT * FROM ilanlar WHERE durum=1 order by id desc limit 200");
                           // $vitrin_cek=mysql_query("SELECT * FROM ilanlar WHERE durum=1 order by eklenme_zamani desc limit 200");
                           // $vitrin_cek=mysql_query("SELECT * FROM ilanlar WHERE durum=1 or durum <> 1 order by eklenme_zamani desc limit 200");
                           $sira2=0; $ihale_say2=mysql_num_rows($vitrin_cek);
                           ?>
                        <input type="hidden" id="ihale_say2" value="<?=$ihale_say2 ?>" />	
                        <?php 
                        $vitrinler = "";
                        while($vitrin_oku = mysql_fetch_array($vitrin_cek)){ 
                           $vitrinler .= '<div>
                           <div class="website_fullwidth_slider_box">
                                 <div class="website_fullwidth_slider_box_title">
                                    <i class="fas fa-stopwatch"></i> 36 Gün 01:01:08
                                 </div>
                                 <div class="website_fullwidth_slider_box_image" style="background-image:url(\'images/du829969.png\');"></div>
                                 <div class="website_fullwidth_slider_box_contents">
                                    <h3>2018 DACIA SANDERO</h3>
                                    <h4>En Yüksek</h4>
                                    <h5>42.400₺</h5>
                                 </div>
                           </div>
                        </div>';
                  $vitrin_sigora_id = $vitrin_oku["sigorta"];
                  $yasak_cek = mysql_query("select * from uye_durumlari where uye_id = '".$uye_id."'");
                  $yasak_oku = mysql_fetch_object($yasak_cek);
                  $yasak_sigortalar = $yasak_oku->yasak_sigorta;
                  $yasak_sigorta_array = explode(",", $yasak_sigortalar);   
                  $sgrta_cek=mysql_query("select * from sigorta_ozellikleri where id='".$vitrin_oku["sigorta"]."'");
                  $sgrta_oku=mysql_fetch_array($sgrta_cek);
                  if($kullanici_grubu == 0){
                     $kullanici_grubu = 2;
                  }
                  $isgorta_cek = mysql_query("select * from sigortalar where sigorta_id = '".$vitrin_oku["sigorta"]."' and paket_id = '".$kullanici_grubu."'");
                  $isgorta_oku = mysql_fetch_object($isgorta_cek);
                  if($isgorta_oku->secilen_yetki_id == 3 ){
                  // if($vitrin_oku["tarih"]>date("Y-m-d H:i:s")){
                     if(!in_array($vitrin_sigora_id, $yasak_sigorta_array)){
                  $ilanID = $vitrin_oku['id'];
                  $getImage = mysql_query("SELECT * FROM ilan_resimler WHERE ilan_id = '".$vitrin_oku['id']."' ORDER BY RAND() LIMIT 1");
                  $getMarka = mysql_query("SELECT * FROM marka WHERE markaID = '".$vitrin_oku['marka']."' LIMIT 1")
                  ?>               
               <?php $sira2++; } } } ?> -->
                        <?php 
                           $son_gezdiklerim = son_gezdiklerim($uye_id);
                           $sira_array3=array();
                           $sira3 = 0;
                           $ihale_say3 = count($son_gezdiklerim);
                           for($i=0;$i<count($son_gezdiklerim);$i++){
                              $sgrta_cek=mysql_query("select * from sigorta_ozellikleri where id='".$son_gezdiklerim[$i]["sigorta"]."'");
                              $sgrta_oku=mysql_fetch_array($sgrta_cek);
                              $class = "";
                              if($son_gezdiklerim[$i]["ihale_turu"] == 1){
                                 $text_string = "En Yüksek";
                                 $son_teklif = $son_gezdiklerim[$i]["son_teklif"];
                              }else{
                                 $class = "website_fullwidth_slider_box_orange";
                                 $text_string = "Kapalı İhale";
                                 $son_teklif = "XXX";
                              }
                              if($son_gezdiklerim[$i]["liste_durum"][0]["secilen_yetki_id"] == 2){
                                 $a_tag = '<a onclick="swal(\'Dikkat\',\'Bu ilanın detayını görme yetkiniz yoktur\',\'info\')">';
                              }else{
                                 $a_tag = '<a href="arac_detay.php?id='.$son_gezdiklerim[$i]["id"].'&q=ihale" target="_blank">';
                              }
                              if($son_gezdiklerim[$i]["liste_durum"][0]["detay_gorur"] != 1){
                                 $son_teklif = '<i class="fas fa-lock"></i>';
                                 $resim = 'images/black_lock.jpg?v=2';
                              }else{
                                 $son_teklif = money($son_gezdiklerim[$i]["son_teklif"]);
                                 $resim = $son_gezdiklerim[$i]["resim"];
                              }
                              $gezdiklerim .= '<div class="owl_slider_images" id="'.$son_gezdiklerim[$i]["id"].'">
                              '.$a_tag.'
                              <div class="website_fullwidth_slider_box '.$class.'">
                                    <div class="website_fullwidth_slider_box_title" id="sayac3_'.$sira3.'">
                                       <i class="fas fa-stopwatch"></i> '. $son_gezdiklerim[$i]['ihale_tarihi'].' '. $son_gezdiklerim[$i]['ihale_saati'].'
                                    </div>
                                    <input type="hidden" id="ihale_sayac3_'.$sira3.'" value="'. $son_gezdiklerim[$i]['ihale_tarihi'].' '. $son_gezdiklerim[$i]['ihale_saati'].'" >
                                    <input type="hidden" id="id3_'.$sira3.'" value="'.$son_gezdiklerim[$i]['id'].'">
                                    <input type="hidden" id="sure_uzatilma_durum3_'.$sira3.'" value="'. $son_gezdiklerim[$i]['sistem_sure_uzatma_durumu'].'">
                                    <input type="hidden" id="belirlenen3_'.$sira3.'" value="'. $sgrta_oku['bu_sure_altinda_teklif'] .'">
                                    <input type="hidden" id="gosterilme3_'.$sira3.'" value="'.gosterilme_durumu($son_gezdiklerim[$i]['id']).'">
                                    <div class="website_fullwidth_slider_box_image" style="background-image:url(\''.$resim.'\');"></div>
                                    <div class="website_fullwidth_slider_box_contents">
                                       <h3>'.$son_gezdiklerim[$i]["model_yili"].' '.$son_gezdiklerim[$i]["marka"].' '.$son_gezdiklerim[$i]["model"].' '.$son_gezdiklerim[$i]["tip"].'</h3>
                                       <h4>'.$text_string.'</h4>
                                       <h5 id="son_gezdigim_fiyat_'.$son_gezdiklerim[$i]["id"].'">'.$son_teklif.'₺</h5>
                                    </div>
                              </div>
                              </a>
                           </div>';
                           $sira3++;
                           }
                           
                        ?>
                        <input type="hidden" id="ihale_say2" value="<?=$ihale_say2 ?>" />	
                        <input type="hidden" id="ihale_say3" value="<?=$ihale_say3 ?>" />	

                        <div class="clearfix"></div>
                        <div class="width:100%;" id="custom_slider_width"></div>
                        <div style="width:100%; height:auto;" id="customSliderOuter">
                           <div class="custom_mini_slider_title_outer">
                              SON GEZDİKLERİM
                           </div>
                           <div class="custom_mini_slider_boxes_outer">
                              <div class="website_fullwidth_slider_contents_btn_outer">
                                 <div class="website_fullwidth_slider_contents_btn_left" id="mini_slider_btn_left"></div>
                              </div>
                              <div class="owl-carousel owl-theme custom_mini_slider_boxes_contents">
                                 <?= $gezdiklerim ?>
                              </div>
                              <div class="website_fullwidth_slider_contents_btn_outer">
                                 <div class="website_fullwidth_slider_contents_btn_right" id="mini_slider_btn_right"></div>
                              </div>
                           </div>
                        </div>
                        <div class="clearfix"></div>                     
                     </form>
                  </div>
                  <div class="col-sm-8">
                     <?php
                        $yeni_grup = kullanici_grubu_yeni($uye_token);
                        if($yeni_grup == 0){
                           $grup_alert = '<div class="alert alert-danger" role="alert">
                           <p style="color:black;font-size:15px;"> Değerli site ziyaretçimiz listelenen hasarlı araçlar Online ihale ile satılmaktadır.<br>Araçların tümünü görebilmek ve teklif verebilmek için üye olmanız gerekmektedir.Üye olmak için <a href="#exampleModal" data-toggle="modal" >tıklayın </a> 
                           <p>
                        </div>';
                        }else if($yeni_grup == 2){
                           if($_SESSION["u_token"] != ""){
                              $grup_alert = '<div class="alert alert-danger" role="alert">
                              <p style="color:black;font-size:15px;">Değerli üyemiz listelenen hasarlı araçlar Online ihale ile satılmaktadır.<br>Araçların tümünü görebilmek ve teklif verebilmek için GOLD ÜYE olmanız gerekmektedir.Gold Üyelik için <a href="uye_panel/islemler/gold_uyelik_basvuru.php?id=21" >tıklayın </a> 
                              <p>
                           </div>';
                           }else{
                              $grup_alert = '<div class="alert alert-danger" role="alert">
                              <p style="color:black;font-size:15px;">Değerli üyemiz listelenen hasarlı araçlar Online ihale ile satılmaktadır.<br>Araçların tümünü görebilmek ve teklif verebilmek için GOLD ÜYE olmanız gerekmektedir.Gold Üyelik için <a href="kurumsal_panel/islemler/gold_uyelik_basvuru.php?id=21" >tıklayın </a> 
                              <p>
                           </div>';
                           }
                        }else{
                           $grup_alert = "";
                        }
                     ?>
                     <?php 
                        if( $_SESSION['u_token']=="" && $_SESSION['k_token']=="" )  { ?>
                     <div class="alert alert-danger" role="alert" style="display: none;">
                        <p style="color:black;font-size:15px;"> Değerli site ziyaretçimiz listelenen hasarlı araçlar Online ihale ile satılmaktadır.<br>Araçların tümünü görebilmek ve teklif verebilmek için üye olmanız gerekmektedir.Üye olmak için <a href="#exampleModal" data-toggle="modal" >tıklayın </a> 
                        <p>
                     </div>
                     <?php	} else if($kullanici_grubu==2 || $kullanici_grubu==3){
                     if($_SESSION['u_token'] != ""){   
                     ?>
                     <div class="alert alert-danger" role="alert" style="display: none;">
                        <p style="color:black;font-size:15px;">Değerli üyemiz listelenen hasarlı araçlar Online ihale ile satılmaktadır.<br>Araçların tümünü görebilmek ve teklif verebilmek için GOLD ÜYE olmanız gerekmektedir.Gold Üyelik için <a href="uye_panel/gold_uyelik_basvuru.php?id=21" >tıklayın </a> 
                        <p>
                     </div>
                     <?php }else{ ?>
                        <div class="alert alert-danger" role="alert" style="display: none;">
                        <p style="color:black;font-size:15px;">Değerli üyemiz listelenen hasarlı araçlar Online ihale ile satılmaktadır.<br>Araçların tümünü görebilmek ve teklif verebilmek için GOLD ÜYE olmanız gerekmektedir.Gold Üyelik için <a href="kurumsal_panel/gold_uyelik_basvuru.php?id=21" >tıklayın </a> 
                        <p>
                     </div>
                     <?php } } ?>
                     <?= $grup_alert ?>
                     <?php 
                        if(isset($_POST['filtrele'])){ 
                        	$f_kelime = $_POST['aranan'];     
                        	$f_marka = $_POST['marka'];
                        	$f_model = $_POST['model'];
                        	$f_sehir = $_POST['sehir'];
                        	$f_tarih = $_POST['tarih'];
                        	$f_profil = $_POST['profil'];
                        	$f_kucuk_yil = $_POST['kucuk_yil'];
                        	$f_buyuk_yil = $_POST['buyuk_yil'];                   
                        	$f_ihale_tur = $_POST['ihaleTur'];     
                        	$f_vites_tur = $_POST['vitesTur'];     
                        	$f_yakit_tur = $_POST['yakitTur']; 
                        ?>
                     <div class="ilanlar_ust_alan">
                        <?php 
                           $filtre_var="false";
                           if($f_kelime !=""){       
                           	$filtre_var="true";
                           	echo '<div class="ust_filtre_baslik">
                           		   Aranan
                           		</div>';            
                           	$onclick='onclick="filtre_cikar(\'aranan_\',\'filtre\')"';
                           	echo '<div class="ust_filte_kutu">
                           			'.$f_kelime.' <button '.$onclick.' class="filtre_cikart_buton"  >X</button>
                           		</div>';
                           }
                           if($f_ihale_tur !=""){       
                           	$filtre_var="true";
                           	echo '<div class="ust_filtre_baslik">
                           			İhale Türü
                           		</div>';            
                           	$tu = 0;
                           	$seciliTurSayisi = count($_POST['ihaleTur']);
                           	$seciliTur = "";
                           	$onclick='';
                           	while ($tu < $seciliTurSayisi) {
                           		$onclick='';
                           		if($_POST['ihaleTur'][$tu] == 1){
                           			$onclick='onclick="filtre_cikar(\'ihale_tur\',\''.$_POST["ihaleTur"][$tu].'\')"';
                           			echo '<div class="ust_filte_kutu">
                           					Açık Artırma <button '.$onclick.' class="filtre_cikart_buton"  >X</button>
                           				</div>';
                           		}
                           		if($_POST['ihaleTur'][$tu] == 2){
                           			$onclick='onclick="filtre_cikar(\'ihale_tur\',\''.$_POST["ihaleTur"][$tu].'\')"';
                           			echo '<div class="ust_filte_kutu">
                           					Kapalı İhale <button '.$onclick.' class="filtre_cikart_buton"  >X</button>
                           				</div>';
                           		}
                           		$tu ++;
                           	}
                           }
                           if($f_vites_tur !=""){       
                           	$filtre_var="true";
                           	echo '<div class="ust_filtre_baslik">
                           			Vites Türü
                           		</div>';            
                           	$vi = 0;
                           	$seciliTurSayisiVites = count($_POST['vitesTur']);
                           	$seciliTurVites = "";
                           	$onclick='';
                           	while ($vi < $seciliTurSayisiVites) {
                           		$onclick='';
                           		if($_POST['vitesTur'][$vi] == 1){
                           			$onclick='onclick="filtre_cikar(\'vites_tur\',\''.$_POST["vitesTur"][$vi].'\')"';
                           			echo '<div class="ust_filte_kutu">
                           					Düz Vites <button '.$onclick.' class="filtre_cikart_buton"  >X</button>
                           				</div>';
                           		}
                           		if($_POST['vitesTur'][$vi] == 2){
                           			$onclick='onclick="filtre_cikar(\'vites_tur\',\''.$_POST["vitesTur"][$vi].'\')"';
                           			echo '<div class="ust_filte_kutu">
                           					Otomatik Vites <button '.$onclick.' class="filtre_cikart_buton"  >X</button>
                           				</div>';
                           		}
                           		$vi ++;
                           	}
                           }

                           if($f_yakit_tur !=""){       
                           	$filtre_var="true";
                           	echo '<div class="ust_filtre_baslik">
                           			Yakıt Türü
                           		</div>';            
                           	$yi = 0;
                           	$seciliTurSayisiYakit = count($_POST['yakitTur']);
                           	$seciliTurYakit = "";
                           	$onclick='';
                           	while ($yi < $seciliTurSayisiYakit) {
                           		$onclick='';
                           		if($_POST['yakitTur'][$yi] == 1){
                           			$onclick='onclick="filtre_cikar(\'yakit_tur\',\''.$_POST["yakitTur"][$yi].'\')"';
                           			echo '<div class="ust_filte_kutu">
                                       Benzinli <button '.$onclick.' class="filtre_cikart_buton"  >X</button>
                                    </div>';
                           		}
                           		if($_POST['yakitTur'][$yi] == 2){
                           			$onclick='onclick="filtre_cikar(\'yakit_tur\',\''.$_POST["yakitTur"][$yi].'\')"';
                           			echo '<div class="ust_filte_kutu">
                                       Benzin+Lpg <button '.$onclick.' class="filtre_cikart_buton"  >X</button>
                                    </div>';
                           		}
                           		if($_POST['yakitTur'][$yi] == 3){
                           			$onclick='onclick="filtre_cikar(\'yakit_tur\',\''.$_POST["yakitTur"][$yi].'\')"';
                           			echo '<div class="ust_filte_kutu">
                                       Dizel <button '.$onclick.' class="filtre_cikart_buton"  >X</button>
                                    </div>';
                           		}
                           		if($_POST['yakitTur'][$yi] == 4){
                           			$onclick='onclick="filtre_cikar(\'yakit_tur\',\''.$_POST["yakitTur"][$yi].'\')"';
                           			echo '<div class="ust_filte_kutu">
                                       Hybrit <button '.$onclick.' class="filtre_cikart_buton"  >X</button>
                                    </div>';
                           		}
                           		if($_POST['yakitTur'][$yi] == 5){
                           			$onclick='onclick="filtre_cikar(\'yakit_tur\',\''.$_POST["yakitTur"][$yi].'\')"';
                           			echo '<div class="ust_filte_kutu">
                                       Elektrikli <button '.$onclick.' class="filtre_cikart_buton"  >X</button>
                                    </div>';
                           		}
                           		$yi ++;
                           	}
                           }
                           if($f_marka !=""){
                           	$filtre_var="true";
                           	echo '<div class="ust_filtre_baslik">
                           		Marka
                              </div>'; 
                           	$k = 0;
                           	$seciliMarkaSayisi = count($_POST['marka']);
                           	$seciliMarka = "";
                           	$onclick='';
                           	while($k < $seciliMarkaSayisi){
                           		$onclick='';
                           		$marka_cek = mysql_query("SELECT * FROM marka where markaID='".$_POST['marka'][$k]."'");
                           		$marka_oku = mysql_fetch_assoc($marka_cek);
                           		$onclick='onclick="filtre_cikar(\'marka_\',\''.$_POST["marka"][$k].'\')"';
                           		echo '<div class="ust_filte_kutu">
                                    '.$marka_oku['marka_adi'].'<button '.$onclick.' class="filtre_cikart_buton"  >X</button>
                                 </div>';
                           		$k++;
                           	}
                           }
                           if($f_model !=""){   
                           	$filtre_var="true";
                           	echo '<div class="ust_filtre_baslik">
                           		   Model
                           		</div>'; 
                           	$ml = 0;
                           	$seciliModelSayisi = count($_POST['model']);
                           	$seciliModel = "";
                           	$onclick='';
                           	while($ml < $seciliModelSayisi){
                           		$onclick='';
                           		 
                           		$onclick='onclick="filtre_cikar(\'model_\',\''.$_POST["model"][$ml].'\')"';
                           		echo '<div class="ust_filte_kutu">
                                    '.$_POST['model'][$ml].' <button '.$onclick.' class="filtre_cikart_buton"  >X</button>
                                 </div>';
                           		$modeller.='model_'.$_POST["model"][$ml].',';
                           		$ml++;
                           	}
                           	echo '<script>localStorage.setItem("filtre_modeller", "'.$modeller.'");</script>';
                           }
                           if($f_sehir !=""){
                           	$filtre_var="true";
                           	echo '<div class="ust_filtre_baslik">
                                 Adres
                              </div>'; 
                           	$i = 0;
                           	$seciliSehirSayisi = count($_POST['sehir']);
                           	$seciliSehir = "";
                           	while ($i < $seciliSehirSayisi) {
                           		$onclick='';
                           		$onclick='onclick="filtre_cikar(\'sehir_\',\''.$_POST["sehir"][$i].'\')"';
                           		echo '<div class="ust_filte_kutu">
                                    '.$_POST['sehir'][$i].'<button '.$onclick.' class="filtre_cikart_buton"  >X</button>
                                 </div>';
                           		$i++;
                           	}
                           }
                           if($f_profil !=""){
                           	$filtre_var="true";
                           	echo '<div class="ust_filtre_baslik">
                           		   Profil
                           		</div>'; 
                           	$p = 0;
                           	$seciliProfilSayisi = count($_POST['profil']);
                           	$seciliProfil = "";
                           	while($p < $seciliProfilSayisi) {
                           		$onclick='';
                           		$post_profil="";
                           		if($_POST["profil"][$p]=="Çekme Belgeli/Pert Kayıtlı"){
                           			$post_profil="pert";
                           		}
                           		if($_POST["profil"][$p]=="Çekme Belgeli"){
                           			$post_profil="cekme";
                           		}
                           		if($_POST["profil"][$p]=="Hurda Belgeli"){
                           			$post_profil="hurda";
                           		}
                           		if($_POST["profil"][$p]=="Plakalı"){
                           			$post_profil="plakali";
                           		}
                           		$onclick='onclick="filtre_cikar(\'profil_\',\''.$post_profil.'\')"';
                           		echo '<div class="ust_filte_kutu">
                                    '.$_POST['profil'][$p].' <button '.$onclick.' class="filtre_cikart_buton"  >X</button>
                                 </div>';
                           		$p ++;
                           	}
                           }
                           if($f_tarih !=""){
                           	$filtre_var="true";
                           	echo '<div class="ust_filtre_baslik">
                                 Tarih
                              </div>'; 
                           	$t = 0;
                           	$seciliTarihSayisi = count($_POST['tarih']);
                           	$seciliTarih = "";
                           	while ($t < $seciliTarihSayisi) {
                           		$onclick='';
                           		$seciliTarih = $seciliTarih . "'" . $_POST['tarih'][$t] . "'";
                           		$onclick='onclick="filtre_cikar(\'tarih_\',\''.$_POST['tarih'][$t].'\')"';
                           		echo '<div class="ust_filte_kutu">
                           				'.date("d-m-Y",strtotime($_POST['tarih'][$t])).' <button '.$onclick.' class="filtre_cikart_buton"  >X</button>
                           			</div>';
                           		$t++;
                           	}
                           }
                           
                           if($f_kucuk_yil !="" || $f_buyuk_yil !=""){
                           	$filtre_var="true";
                           	echo '<div class="ust_filtre_baslik">
                                 Yıl
                              </div>'; 
                           	$onclick='onclick="filtre_cikar(\'yil_\',\'filtre\')"';
                           	echo '<div class="ust_filte_kutu">
                                 '.$f_kucuk_yil.' - '.$f_buyuk_yil.' <button '.$onclick.' class="filtre_cikart_buton"  >X</button>
                              </div>';
                           }
                           if($filtre_var=="true"){ ?>
                        <p><a href="ihaledeki_araclar.php">Tümünü Temizle</a></p>
                        <?php } ?>
                     </div>
                     <?php 
                        $where = "WHERE durum = '1'";
                        if($f_kelime !=""){
                        	$where .= "AND concat(plaka,model,arac_kodu,model_yili,sehir,ilce,hesaplama) LIKE '%".$f_kelime."%'";
                        }
                        if($f_ihale_tur !=""){                    
                        	$tu = 0;
                        	$seciliTurSayisi = count($_POST['ihaleTur']);
                        	$seciliTur = "";
                        	while ($tu < $seciliTurSayisi) {
                        		$seciliTur = $seciliTur . "'" . $_POST['ihaleTur'][$tu] . "'";
                        		if ($tu < $seciliTurSayisi - 1) {
                        			$seciliTur = $seciliTur . ", ";
                        		}	
                        		$tu ++;
                        	}
                        	$where = $where . " AND ihale_turu in (" . $seciliTur . ")";
                        }
                        if($f_vites_tur !=""){                    
                        	$vi = 0;
                        	$seciliTurSayisi = count($_POST['vitesTur']);
                        	$seciliTur = "";
                        	while ($vi < $seciliTurSayisi) {
                              if($_POST['vitesTur'][$vi] == 1){
                                 $secili_vites = "Düz Vites";
                              }else{
                                 $secili_vites = "Otomatik Vites";
                              }
                        		$seciliTur = $seciliTur . "'" . $secili_vites . "'";
                        		if ($vi < $seciliTurSayisi - 1) {
                        			$seciliTur = $seciliTur . ", ";
                        		}	
                        		$vi ++;
                        	}
                        	$where = $where . " AND vites_tipi in (" . $seciliTur . ")";
                        }
                        if($f_yakit_tur !=""){                    
                        	$yi = 0;
                        	$seciliTurSayisiYakit = count($_POST['yakitTur']);
                        	$seciliTurYakit = "";
                        	while ($yi < $seciliTurSayisiYakit) {
                              if($_POST['yakitTur'][$yi] == 1){
                                 $secili_yakit = "Benzinli";
                              }elseif($_POST['yakitTur'][$yi] == 2){
                                 $secili_yakit = "Benzin+Lpg";
                              }elseif($_POST['yakitTur'][$yi] == 3){
                                 $secili_yakit = "Dizel";
                              }elseif($_POST['yakitTur'][$yi] == 4){
                                 $secili_yakit = "Hybrit";
                              }elseif($_POST['yakitTur'][$yi] == 5){
                                 $secili_yakit = "Elektrikli";
                              }
                        		$seciliTurYakit = $seciliTurYakit . "'" . $secili_yakit . "'";
                        		if ($yi < $seciliTurSayisiYakit - 1) {
                        			$seciliTurYakit = $seciliTurYakit . ", ";
                        		}	
                        		$yi ++;
                        	}
                        	$where = $where . " AND yakit_tipi in (" . $seciliTurYakit . ")";
                        }
                        if($f_marka !=""){                    
                        	$k = 0;
                        	$seciliMarkaSayisi = count($_POST['marka']);
                        	$seciliMarka = "";
                        	while ($k < $seciliMarkaSayisi) {
                        		$seciliMarka = $seciliMarka . "'" . $_POST['marka'][$k] . "'";
                        		if ($k < $seciliMarkaSayisi - 1) {
                        			$seciliMarka = $seciliMarka . ", ";
                        		}
                        		$k ++;
                        	}
                        	$where = $where . " AND marka in (" . $seciliMarka . ")";
                        }
                        if($f_model !=""){                    
                        	$ml = 0;
                        	$seciliModelSayisi = count($_POST['model']);
                        	$seciliModel = "";
                        	while ($ml < $seciliModelSayisi) {
                        		$seciliModel = $seciliModel . "'" . $_POST['model'][$ml] . "'";
                        		if ($ml < $seciliModelSayisi - 1) {
                        			$seciliModel = $seciliModel . ", ";
                        		}
                        		$ml ++;
                        	}
                        	$where = $where . " AND model in (" . $seciliModel . ")";
                        }
                        if($f_sehir !=""){
                        	$i = 0;
                        	$seciliSehirSayisi = count($_POST['sehir']);
                        	$seciliSehir = "";
                        	while ($i < $seciliSehirSayisi) {
                        		$seciliSehir = $seciliSehir . "'" . $_POST['sehir'][$i] . "'";
                        		if ($i < $seciliSehirSayisi - 1) {
                        			$seciliSehir = $seciliSehir . ", ";
                        		}
                        		$i ++;
                        	}
                        	$where = $where . " AND sehir in (" . $seciliSehir . ")";
                        }
                        if($f_profil !=""){
                        	$p = 0;
                        	$seciliProfilSayisi = count($_POST['profil']);
                        	$seciliProfil = "";
                        	while ($p < $seciliProfilSayisi) {
                        		$seciliProfil = $seciliProfil . "'" . $_POST['profil'][$p] . "'";
                        		if ($p < $seciliProfilSayisi - 1) {
                        			$seciliProfil = $seciliProfil . ", ";
                        		}
                        		$p++;
                        	}
                        	$where = $where . " AND profil in (" . $seciliProfil . ")";
                        }
                        if($f_tarih !=""){
                        	$t = 0;
                        	$seciliTarihSayisi = count($_POST['tarih']);
                        	$seciliTarih = "";
                        	while ($t < $seciliTarihSayisi) {
                        		$seciliTarih = $seciliTarih . "'" . $_POST['tarih'][$t] . "'";
                        		if ($t < $seciliTarihSayisi - 1) {
                        			$seciliTarih = $seciliTarih . ", ";
                        		}
                        		$t ++;
                        	}
                        	$where = $where . " AND ihale_tarihi in (" . $seciliTarih . ")";
                        }
                        if($f_kucuk_yil !="" ){
                        	$where .= "AND model_yili >= $f_kucuk_yil ";
                        }
                        if( $f_buyuk_yil !=""){
                        	$where .= "AND model_yili <= $f_buyuk_yil";
                        }
                                        
                        $filtre_cek = "SELECT *,concat(ihale_tarihi,' ',ihale_saati) as ihale_son FROM ilanlar $where order by ihale_son asc";  
                        // var_dump("SELECT *,concat(ihale_tarihi,' ',ihale_saati) as ihale_son FROM ilanlar $where order by ihale_son asc");                        
                        $result = mysql_query($filtre_cek) or die(mysql_error());
                        $sayi = mysql_numrows($result);
                        if($sayi==0){
                        	echo '<script type="text/javascript">'; 
                        	echo 'alert("İstediğiniz kriterlere uygun araç bulunamadı.");'; 
                        	echo 'window.location.href = "ihaledeki_araclar.php";';
                        	echo '</script>';                       
                        }else{ 
                        	$sira=0; 
                        	$sira_array=array();
                        	$modal_array=array();
                        	$ihale_say=mysql_num_rows($result); 
                        	// İlan sayısı / reklam sayısı ==> Bu kadar ilandan sonra reklam çıkıyor
                        	$dateTime = date('Y-m-d H:i:s');
                        	$reklam_icin_cek = mysql_query("SELECT * FROM ilanlar $where");
                        	$reklam_icin_say = mysql_num_rows($reklam_icin_cek);						  
                        	$reklam_cek = mysql_query("SELECT * FROM reklamlar WHERE baslangic_tarihi <= '".$dateTime."' AND bitis_tarihi >= '".$dateTime."' ORDER BY RAND()");     
                        	$reklam_say = mysql_num_rows($reklam_cek);
                        	$gosterim_sayi = floor($reklam_icin_say / $reklam_say);                     
                        	$reklam_array = array();
                        	$reklam_url_array = array();
                        	$row_number=0;
                        	while($reklam_oku = mysql_fetch_array($reklam_cek)){
                        		array_push($reklam_array,$reklam_oku['resim']);
                        		//array_push($reklam_url_array,$reklam_oku['url']);
                        		if($reklam_oku['url']==""){
                        			array_push($reklam_url_array,"https://ihale.pertdunyasi.com/reklam_url.php?id=".$reklam_oku["id"]."");
                        		}else{
                        			array_push($reklam_url_array,$reklam_oku["url"]);
                        		}
                        	}
                        	$sayac=0; 
                        	while($filtre_oku = mysql_fetch_array($result)){
                        		if($_SESSION['u_token'] != "" && $_SESSION['k_token']=="" ){  
                        			$favli_mi = mysql_query("SELECT * FROM favoriler WHERE user_token = '".$_SESSION['u_token']."' AND ilan_id = '".$filtre_oku['id']."'");
                        			$favli_say = mysql_num_rows($favli_mi);
                        			if($favli_say == 0){
                        				$fav_color = "gray";
                        				$fav_title="Araç favorilerinize eklenecektir";
                        			}else{
                        				$fav_color = "orange";
                        				$fav_title="Araç favorilerinizden kaldırılacaktır.";
                        			}
                        		}else if($_SESSION['u_token'] == "" && $_SESSION['k_token'] !="" ){  
                        			$favli_mi = mysql_query("SELECT * FROM favoriler WHERE kurumsal_user_token = '".$_SESSION['u_token']."' AND ilan_id = '".$filtre_oku['id']."'");
                        			$favli_say = mysql_num_rows($favli_mi);
                        			if($favli_say == 0){
                        				$fav_color = "gray";
                        				$fav_title="Araç favorilerinize eklenecektir";
                        			}else{
                        				$fav_color = "orange";
                        				$fav_title="Araç favorilerinizden kaldırılacaktır.";
                        			}
                        		}else{
                        			$fav_color = "gray";
                        			$fav_title="Araç favorilerinize eklenecektir";
                        		}
                        
                        		if($_SESSION['u_token'] != "" && $_SESSION['k_token']=="" ){
                        			$renkli_uye_bul = mysql_query("SELECT * FROM user WHERE user_token = '".$_SESSION['u_token']."'");
                        			$renkli_uye_oku = mysql_fetch_assoc($renkli_uye_bul);
                        			$renkli_uye_id = $renkli_uye_oku['id'];  
                        			
                        			$bildirimli_mi = mysql_query("SELECT * FROM bildirimler WHERE uye_id = '".$renkli_uye_id."' AND ilan_id = '".$filtre_oku['id']."'");
                        			$bildirimli_say = mysql_num_rows($bildirimli_mi);
                        			if($bildirimli_say == 0){
                        				$bidlirim_color = "gray";
                        				$bildirim_title="Araç bildirimleri açılacaktır.";
                        			}else{
                        				$bidlirim_color = "orange";
                        				$bildirim_title="Araç bildirimleri kapatılacaktır.";
                        			}
                        		}else if($_SESSION['u_token'] == "" && $_SESSION['k_token'] !="" ){  
                        			$renkli_uye_bul = mysql_query("SELECT * FROM user WHERE kurumsal_user_token = '".$_SESSION['k_token']."'");
                        			$renkli_uye_oku = mysql_fetch_assoc($renkli_uye_bul);
                        			$renkli_uye_id = $renkli_uye_oku['id'];   
                        		   
                        			$bildirimli_mi = mysql_query("SELECT * FROM bildirimler WHERE uye_id = '".$renkli_uye_id."' AND ilan_id = '".$filtre_oku['id']."'");
                        			$bildirimli_say = mysql_num_rows($bildirimli_mi);
                        			if($bildirimli_say == 0){
                        				$bidlirim_color = "gray";
                        				$bildirim_title="Araç bildirimleri açılacaktır.";
                        			}else{
                        				$bidlirim_color = "orange";
                        				$bildirim_title="Araç bildirimleri kapatılacaktır.";
                        			}
                        		}else{
                        			$bidlirim_color = "gray";
                        			$bildirim_title="Araç bildirimleri açılacaktır.";
                        		}
                        
                        		$row_number++; 
                        		if($reklam_icin_say>50){
                        				$advertisment_block = '
                        				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        					<a target="_blank" href="'.$reklam_url_array[$sayac].'">
                        						<img oncontextmenu="return false;" src="reklamlar/'.$reklam_array[$sayac].' " alt="" style="width:100%; height:auto;">
                        					</a>
                        				</div>' ; 
                        		}
                        		if($filtre_oku['profil'] == "Hurda Belgeli"){
                        		   $blink = "blink";
                        		}else{
                        			$blink="";
                        		}				
                        		if($_SESSION['u_token'] != ""){
                        			$uye_token=$_SESSION['u_token'];
                        			$uye_bul = mysql_query("SELECT * FROM user WHERE user_token = '".$uye_token."'");
                        			$uye_yaz = mysql_fetch_assoc($uye_bul);
                        			$uye_paket = $uye_yaz['paket'];
                        			$uye_id = $uye_yaz['id'];
                        			$sigorta_cek = mysql_query("SELECT * FROM sigortalar WHERE id = '".$filtre_oku['sigorta']."'");
                        			$sigorta_say = mysql_num_rows($sigorta_cek);
                        			$yasakli_sigorta=mysql_query("SELECT * FROM uye_durumlari WHERE uye_id = '". $uye_id."'");
                        			$yasakli_sigorta_cek=mysql_fetch_array($yasakli_sigorta);
                        			$yasaki_sigorta_id=$yasakli_sigorta_cek["yasak_sigorta"];
                        		}elseif($_SESSION['k_token'] != ""){
                        			$uye_token=$_SESSION['k_token'];
                        			$uye_bul = mysql_query("SELECT * FROM user WHERE kurumsal_user_token = '".$uye_token."'");
                        			$uye_yaz = mysql_fetch_assoc($uye_bul);
                        			$uye_paket = $uye_yaz['paket'];
                        			$uye_id = $uye_yaz['id'];
                        			$sigorta_cek = mysql_query("SELECT * FROM sigortalar WHERE id = '".$filtre_oku['sigorta']."'");
                        			$sigorta_say = mysql_num_rows($sigorta_cek);
                        			$yasakli_sigorta=mysql_query("SELECT * FROM uye_durumlari WHERE uye_id = '". $uye_id."'");
                        			$yasakli_sigorta_cek=mysql_fetch_array($yasakli_sigorta);
                        			$yasaki_sigorta_id=$yasakli_sigorta_cek["yasak_sigorta"];
                        		}else{ //Ziyaretçiyse
                        			$uye_token="";
                        			$uye_paket = 2;//Ziyaretçi Paketinin Id'si 2
                        			$yasaki_sigorta_id="";
                        		}
                        		$sigorta_cek = mysql_query("SELECT * FROM sigortalar WHERE sigorta_id = '".$filtre_oku['sigorta']."' and paket_id='".$uye_paket ."'");
                        		$sigorta_cek2 = mysql_query("SELECT * FROM sigorta_ozellikleri WHERE id = '".$filtre_oku['sigorta']."' ");
                        		$sigorta_oku2 = mysql_fetch_array($sigorta_cek2);
                        		$min_arti = $sigorta_oku2['minumum_artis'];
                        		//$sigorta_say = mysql_num_rows($sigorta_cek);
                        		$sigorta_oku = mysql_fetch_array($sigorta_cek);
                        		$secilen_yetki_id = $sigorta_oku['secilen_yetki_id'];
                        		$detay_gorur = $sigorta_oku['detay_gorur']; 
                              $yasak_sigorta_array = explode(",", $yasaki_sigorta_id);  
                              if(!in_array($filtre_oku['sigorta'], $yasak_sigorta_array)){
                        		// if($filtre_oku['sigorta'] != $yasaki_sigorta_id ){
                        			if($secilen_yetki_id==2 ){ 
                        				if($detay_gorur==1){ 
                        					$anlik = date("Y-m-d H:i:s");
                        					$getID = $filtre_oku['id'];
                        					$getImage = mysql_query("SELECT * FROM ilan_resimler WHERE ilan_id = '".$getID."' ORDER BY RAND() LIMIT 1");
                        					$setImage = mysql_fetch_assoc($getImage);
                        					$image = $setImage['resim'];
                        					$getMarka = mysql_query("SELECT * FROM marka WHERE markaID = '".$filtre_oku['marka']."' LIMIT 1");
                        					$getSehir = mysql_query("SELECT * FROM sehir WHERE sehirID = '".$filtre_oku['sehir']."' LIMIT 1");
                        					$setMarka = mysql_fetch_assoc($getMarka) ;   
                        					if($image == ""){
                        					   $image="default.png";
                        					} ?> 
                     <input type="hidden" id="ihale_say" value="<?=$ihale_say ?>">	     
                     <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ilan_karti_dis">                     
                        <?php  if($filtre_oku['ihale_turu']==1){$background_color = "#00a2e8";}else{$background_color="orange";}  ?>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ilan_karti_baslik "  style="background-color:<?= $background_color ?>">
                           <?php 
                              if(strlen($filtre_oku['model_yili']." ".$setMarka['marka_adi']." " . $filtre_oku['model']." " . $filtre_oku['tip']) > 135){
                                 $ilan_karti_baslik_bas = substr($filtre_oku['model_yili']." ".$setMarka['marka_adi']." " . $filtre_oku['model']." " . $filtre_oku['tip'],0,135)."...";
                              }else{
                                 $ilan_karti_baslik_bas = $filtre_oku['model_yili']." ".$setMarka['marka_adi']." " . $filtre_oku['model']." " . $filtre_oku['tip'];
                              } 
                           ?>
                           <text style="font-size: 15px;font-weight:bold;color: #fff;"><i class="fas fa-car" aria-hidden="true"></i> <?= $ilan_karti_baslik_bas  ?></text>
                           <span  id="sayac<?=$sira?>"> </span>
                           <?php array_push($sira_array,$sira); ?>
                           <input type="hidden" id="ihale_sayac<?=$sira?>" value="<?= $filtre_oku['ihale_tarihi'].' '. $filtre_oku['ihale_saati'] ?>">
                           <input type="hidden" id="id_<?=$sira?>" value="<?= $filtre_oku['id'] ?>">
                           <input type="hidden" id="sure_uzatilma_durum_<?=$sira?>" value="<?= $filtre_oku['sistem_sure_uzatma_durumu'] ?>">
                           <input type="hidden" id="belirlenen_<?=$sira ?>" value="<?= $sigorta_oku2['bu_sure_altinda_teklif'] ?>">
                           <input type="hidden" id="gosterilme_<?=$sira ?>" value="<?=gosterilme_durumu($filtre_oku['id']) ?>">
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ilan_karti_icerik_dis">
                           <div class="ilan_karti_gorsel_dis" style="background-image:url('images/<?= $image ?>');">
                              <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ilan_karti_kod">
                              <?php 
                              if(strlen($filtre_oku['arac_kodu']) > 15){
                                 $arac_kodu_yeni = substr($filtre_oku['arac_kodu'],0,15)."...";
                              }else{
                                 $arac_kodu_yeni = $filtre_oku['arac_kodu'];
                              }
                           ?>
                              #<?= $arac_kodu_yeni ?>
                              </div>
                           </div>
                           <div class="ilan_karti_gorsel_icerik">
                              <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ilan_karti_taglar_dis">
                                 <?php if($filtre_oku['yakit_tipi']!=""){ ?>
                                 <div class="ilan_karti_tag">
                                    <img src="images/car_list_icons/1.png" />
                                    <?= $filtre_oku['yakit_tipi'] ?>
                                 </div>
                                 <?php } if($filtre_oku['vites_tipi']!=""){ ?>
                                 <div class="ilan_karti_tag">
                                    <img src="images/car_list_icons/2.png" />
                                    <?= $filtre_oku['vites_tipi'] ?>
                                 </div>
                                 <?php }if($filtre_oku['kilometre']!=""){ ?>
                                 <div class="ilan_karti_tag">
                                 <img src="images/car_list_icons/7.png" />
                                    <?= money($filtre_oku['kilometre']) ?> km
                                 </div>
                                 <?php } if($filtre_oku['sehir']!=""){ ?>
                                 <div class="ilan_karti_tag">
                                    <img src="images/car_list_icons/3.png" />
                                    <?= $filtre_oku['sehir'] ?>
                                 </div>
                                 <?php }if($filtre_oku['ihale_turu']!=""){ ?>
                                 <div class="ilan_karti_tag">
                                    <img src="images/car_list_icons/4.png" />
                                    <?php if($filtre_oku['ihale_turu']==1){$ihale_turu = "Açık  İhale";}else{$ihale_turu="Kapalı İhale";} ?>
                                    <?= $ihale_turu ?>
                                 </div>
                                 <?php } if($filtre_oku['profil']!=""){ ?>
                                 <div class="ilan_karti_tag <?= $blink ?>">
                                    <img src="images/car_list_icons/5.png" />
                                    <?= $filtre_oku['profil'] ?>
                                 </div>
                                 <?php }if($filtre_oku['ihale_tarihi']!=""){  ?>
                                 <div class="ilan_karti_tag ">
                                    <img src="images/car_list_icons/6.png" /> 
                                     <span class="kapanis_zamani<?=$sira ?>" ><?= date("d-m-Y H:i:s",strtotime($filtre_oku['ihale_tarihi']." ".$filtre_oku['ihale_saati'])) ?></span>
                                 </div>
                                 <?php } ?>
                              </div>
                              <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ilan_karti_alt_alan">
                                 <div class="col-xs-12 col-sm-12 col-md-7 col-lg-7 ilan_karti_notlar_dis">
                                    <!-- <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ilan_karti_not_baslik">
                                       Sigorta Onay Notu
                                       </div> -->
                                    <div data-toggle="modal" data-target="#notmodal_<?=$filtre_oku['id'] ?>" class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ilan_karti_not_alan">
                                       <?php $onay_cek = mysql_query("select * from sigorta_ozellikleri where id = '".$filtre_oku['sigorta']."'"); 
                                          $onay_oku = mysql_fetch_assoc($onay_cek);
                                          // $onay = $onay_oku['sigorta_aciklamasi'];
                                          $onay = $onay_oku['uyari_notu'];
                                          ?>
                                       <b><?= $filtre_oku['uyari_notu']."<br>".$onay ?></b>
                                    </div>
                                    <div class="modal fade" id="notmodal_<?=$filtre_oku['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="notmodal_<?=$filtre_oku['id'] ?>" aria-hidden="true">
                                       <div class="modal-dialog" role="document">
                                          <div class="modal-content">
                                             <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                             </div>
                                             <div class="modal-body" style="font-weight: 600 !important;">
                                                <?= $filtre_oku['uyari_notu']."<br>".$onay ?>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                                 <?php
                                 if($filtre_oku['ihale_turu']==1){ ?>
                              <div class="col-xs-12 col-sm-12 col-md-5 col-lg-5 ilan_karti_teklif_dis">
                                 <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ilan_karti_teklif_baslik">
                                    En Yüksek
                                 </div>
                                 <div id="en_yuksek_<?=$filtre_oku["id"] ?>"  class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ilan_karti_teklif_fiyat">
                                    <?php
                                       $bitis_tarihi=$filtre_oku["ihale_tarihi"]." ".$filtre_oku["ihale_saati"];
                                       $ihale_son_str = strtotime($bitis_tarihi);
                                       $suan_str = strtotime(date("Y-m-d H:i:s"));
                                       $sonuc=($ihale_son_str-$suan_str)/60;
                                       if($sonuc<30){ 
                                       	if($kullanici_grubu==1){ ?>
                                    <?= money($filtre_oku['son_teklif']) ?> ₺
                                    <?php } else { ?>
                                    <i style="color:#000" class="fas fa-lock"></i>
                                    <?php } ?>
                                    <?php } else { 
                                       if($kullanici_grubu==1 || $kullanici_grubu==4 || $kullanici_grubu==0){ ?>
                                    <?= money($filtre_oku['son_teklif']) ?> ₺
                                    <?php } else { ?>
                                    <i style="color:#000" class="fas fa-lock"></i>
                                    <?php } ?>
                                    <?php }
                                       ?>
                                 </div>
                              </div>
                              <?php }else{ ?>
                              <div class="col-xs-12 col-sm-12 col-md-5 col-lg-5 ilan_karti_teklif_dis">
                                 <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ilan_karti_teklif_baslik">
                                    Taban Fiyat
                                 </div>
                                 <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ilan_karti_teklif_fiyat">
                                    <?= money($filtre_oku['acilis_fiyati']) ?> ₺
                                 </div>
                              </div>
                              <?php } ?>
                              <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ilan_karti_teklif_btnlar">
                              </div>
                                 <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ilan_karti_begeni_dis">
                                    <form method="POST" action="" >
                                       <div class="btn-group" role="group">
                                          <div onclick="bildirim_ac(<?= $filtre_oku['id'] ?>);">
                                             <button data-toggle="tooltip" data-placement="top" title="<?=$bildirim_title ?>"  type="button" name="bildirim_ac" id="bildirim_ac_<?= $filtre_oku['id'] ?>" class="btn btn-light mr-2 btn-sm">
                                             <i style="color: <?= $bidlirim_color ?>;font-size: 20px;" class="icon-notifications"></i>
                                             <input type="hidden" name="bildirimlenecek" value="<?= $filtre_oku['id'] ?>">
                                             </button>
                                          </div>
                                          <div onclick="favla(<?= $filtre_oku['id'] ?>);">
                                             <button data-toggle="tooltip" data-placement="top" title="<?=$fav_title ?>"  type="button" name="favla" id="favla_<?= $filtre_oku['id'] ?>" class="btn btn-light btn-sm">
                                             <i style="color: <?= $fav_color ?>;font-size: 20px;" class="fas fa-star"></i>
                                             <input type="hidden" name="favlanacak" value="<?= $filtre_oku['id'] ?>">
                                             </button>
                                          </div>
                                       </div>
                                    </form>
                                 </div>
                              </div>
                              
                           </div>
                        </div>
                     </div>
                  <!-- </div> -->
                  <div class="clearfix"></div>
                  <?php 
                     if(($row_number % $gosterim_sayi) == 0) {
                     	echo $advertisment_block;  
                     	$sayac++;
                     }
                     } else { 
                     $anlik = date("Y-m-d H:i:s");
                     $getID = $filtre_oku['id'];
                     $getImage = mysql_query("SELECT * FROM ilan_resimler WHERE ilan_id = '".$getID."' ORDER BY RAND() LIMIT 1");
                     $setImage = mysql_fetch_assoc($getImage);
                     $image = $setImage['resim'];
                     $getMarka = mysql_query("SELECT * FROM marka WHERE markaID = '".$filtre_oku['marka']."' LIMIT 1");
                     $getSehir = mysql_query("SELECT * FROM sehir WHERE sehirID = '".$filtre_oku['sehir']."' LIMIT 1");
                     $setMarka = mysql_fetch_assoc($getMarka) ; 	
                     if($image==""){
                       $image="default.png";
                     } ?> 
                  <input type="hidden" id="ihale_say" value="<?=$ihale_say ?>">	     
                  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ilan_karti_dis" style="background-color:gray !important; opacity: 0.5;">
                     <div style="color:#000;background-color:gray !important; opacity: 0.5;" class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ilan_karti_baslik">
                        <text style="font-size: 15px;font-weight:bold;color: #fff; width:100% !important"><i class="fas fa-car" aria-hidden="true"></i> <?= $filtre_oku['model_yili']." ".$setMarka['marka_adi']." " . $filtre_oku['model']  ?><i style="" class="fas fa-lock"></i></text>
                        <?php array_push($sira_array,$sira); ?>
                        <span  id="sayac<?=$sira?>"> </span>
                        <input type="hidden" id="ihale_sayac<?=$sira?>" value="<?= $filtre_oku['ihale_tarihi'].' '. $filtre_oku['ihale_saati'] ?>">
                        <input type="hidden" id="id_<?=$sira?>" value="<?= $filtre_oku['id'] ?>">
                        <input type="hidden" id="sure_uzatilma_durum_<?=$sira?>" value="<?= $filtre_oku['sistem_sure_uzatma_durumu'] ?>">
                        <input type="hidden" id="belirlenen_<?=$sira?>" value="<?= $sigorta_oku2['bu_sure_altinda_teklif'] ?>">
                        <input type="hidden" id="gosterilme_<?=$sira ?>" value="<?=gosterilme_durumu($filtre_oku['id']) ?>">
                     </div>
                     <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ilan_karti_icerik_dis">
                        <div class="ilan_karti_gorsel_dis" style="background:#fafafa!important;">
                           <div class="image_lock_box"></div>
                           <div style="color:#000" class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ilan_karti_kod">
                           <?php 
                              if(strlen($filtre_oku['arac_kodu']) > 15){
                                 $arac_kodu_yeni = substr($filtre_oku['arac_kodu'],0,15)."...";
                              }else{
                                 $arac_kodu_yeni = $filtre_oku['arac_kodu'];
                              }
                           ?>
                              #<?= $arac_kodu_yeni ?>
                           </div>
                        </div>
                        <div class="ilan_karti_gorsel_icerik">
                           <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ilan_karti_taglar_dis">
                              <?php if($filtre_oku['yakit_tipi']!=""){ ?>
                              <div class="ilan_karti_tag">
                              <img src="images/car_list_icons/1.png" />
                                 <?= $filtre_oku['yakit_tipi'] ?>
                              </div>
                              <?php } if($filtre_oku['vites_tipi']!=""){ ?>
                              <div class="ilan_karti_tag">
                              <img src="images/car_list_icons/2.png" />
                                 <?= $filtre_oku['vites_tipi'] ?>
                              </div>
                              <?php }if($filtre_oku['kilometre']!=""){ ?>
                              <div class="ilan_karti_tag">
                              <img src="images/car_list_icons/7.png" />
                                 <?= money($filtre_oku['kilometre']) ?> km
                              </div>
                              <?php } if($filtre_oku['sehir']!=""){ ?>
                              <div class="ilan_karti_tag">
                              <img src="images/car_list_icons/3.png" />
                                 <?= $filtre_oku['sehir'] ?>
                              </div>
                              <?php }if($filtre_oku['ihale_turu']!=""){ ?>
                              <div class="ilan_karti_tag">
                              <img src="images/car_list_icons/4.png" />
                                 <?php if($filtre_oku['ihale_turu']==1){$ihale_turu = "Açık  İhale";}else{$ihale_turu="Kapalı İhale";} ?>
                                 <?= $ihale_turu ?>
                              </div>
                              <?php } if($filtre_oku['profil']!=""){ ?>
                              <div class="ilan_karti_tag <?= $blink ?>">
                              <img src="images/car_list_icons/5.png" />
                                 <?= $filtre_oku['profil'] ?>
                              </div>
                              <?php }if($filtre_oku['ihale_tarihi']!=""){  ?>
                              <div class="ilan_karti_tag ">
                              <img src="images/car_list_icons/6.png" />
                                 <span class="kapanis_zamani<?=$sira ?>" ><?= date("d-m-Y H:i:s",strtotime($filtre_oku['ihale_tarihi']." ".$filtre_oku['ihale_saati'])) ?></span>
                              </div>
                              <?php } ?>
                           </div>
                           <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ilan_karti_alt_alan">
                              <div class="col-xs-12 col-sm-12 col-md-7 col-lg-7 ilan_karti_notlar_dis">
                                 <!-- <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ilan_karti_not_baslik">
                                    Sigorta Onay Notu
                                    </div> -->
                                 <div data-toggle="modal" data-target="#notmodal_<?=$filtre_oku['id'] ?>" class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ilan_karti_not_alan">
                                    <?php $onay_cek = mysql_query("select * from sigorta_ozellikleri where id = '".$filtre_oku['sigorta']."'"); 
                                       $onay_oku = mysql_fetch_assoc($onay_cek);
                                       // $onay = $onay_oku['sigorta_aciklamasi'];
                                       $onay = $onay_oku['uyari_notu'];
                                       ?>
                                    <b><?= $filtre_oku['uyari_notu']."<br>".$onay ?></b>
                                 </div>
                                 
                                 <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ilan_karti_begeni_dis">
                                    <form method="POST" action="" name="form" id="form">
                                       <div class="btn-group" role="group">
                                          <div onclick="bildirim_ac(<?= $filtre_oku['id'] ?>)">
                                             <button data-toggle="tooltip" data-placement="top" title="<?=$bildirim_title ?>" type="button"  name="bildirim_ac" id="bildirim_ac_<?= $filtre_oku['id'] ?>" class="btn btn-light mr-2 btn-sm">
                                             <i style="color: <?= $bidlirim_color ?>;font-size: 20px;" class="icon-notifications"></i>
                                             <input type="hidden" name="bildirimlenecek" value="<?= $filtre_oku['id'] ?>">
                                             </button>
                                          </div>
                                          <div onclick="favla(<?= $filtre_oku['id'] ?>);">
                                             <button data-toggle="tooltip" data-placement="top" title="<?=$fav_title ?>" type="button" name="favla" id="favla_<?= $filtre_oku['id'] ?>" class="btn btn-light btn-sm">
                                             <i style="color: <?= $fav_color ?>;font-size: 20px;" class="fas fa-star"></i>
                                             <input type="hidden" name="favlanacak" value="<?= $filtre_oku['id'] ?>">
                                             </button>
                                          </div>
                                       </div>
                                    </form>
                                 </div>
                              </div>
                              <div class="col-xs-12 col-sm-12 col-md-5 col-lg-5 ilan_karti_teklif_dis">
                                 <?php
                                    if($filtre_oku['ihale_turu']==1){ ?>
                                 <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ilan_karti_teklif_baslik">
                                    En Yüksek
                                 </div>
                                 <?php }else{ ?>
                                 <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ilan_karti_teklif_baslik">
                                    Taban Fiyat
                                 </div>
                                 <?php }
                                    ?>
                                 <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ilan_karti_teklif_fiyat">
                                    <i style="color:#000" class="fas fa-lock"></i>
                                 </div>
                                 <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ilan_karti_teklif_btnlar">
                                    <div class="ilan_karti_teklif_btn" style="background-color: #000; " >
                                       <a  style="text-decoration: none; color:#ffffff;" href=""><i style="color:#fff" class="fas fa-lock"></i></a> 
                                    </div>
                                    <div class="ilan_karti_teklif_btn" style="background-color: #424242; ">
                                       <a   style="text-decoration: none; color:#ffffff;" href=""><i style="color:#000" class="fas fa-lock"></i></a>                                
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="modal fade" id="notmodal_<?=$filtre_oku['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="notmodal_<?=$filtre_oku['id'] ?>" aria-hidden="true">
                     <div class="modal-dialog" role="document">
                        <div class="modal-content">
                           <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                              </button>
                           </div>
                           <div class="modal-body" style="font-weight: 600 !important;">
                              <?= $filtre_oku['uyari_notu']."<br>".$onay ?>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="clearfix"></div>
                  <?php 
                     if(($row_number % $gosterim_sayi) == 0) {
                     	echo $advertisment_block;  
                     	$sayac++;
                     } 
                     } 
                     }else if($secilen_yetki_id==3){
                     $resim_cek = mysql_query("select * from ilan_resimler where ilan_id = '".$filtre_oku['id']."'");
                     $resim_oku = mysql_fetch_assoc($resim_cek);
                     $resim = $resim_oku['resim'];
                     $marka_cek2 = mysql_query("select * from marka where markaID = '".$filtre_oku['marka']."'");
                     $marka_oku2 = mysql_fetch_assoc($marka_cek2);
                     $marka_adi2 = $marka_oku2['marka_adi'];
                     if($resim == ""){
                      $resim="default.png";
                     } ?>
                     
    
    
                  <input type="hidden" id="ihale_say" value="<?=$ihale_say ?>">
                  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ilan_karti_dis"  >
                     <?php  if($filtre_oku['ihale_turu']==1){$background_color = "#00a2e8";}else{$background_color="orange";}  ?>
                     <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ilan_karti_baslik "  style="background-color:<?= $background_color ?>">
                        <?php 
                              if(strlen($filtre_oku['model_yili']." ".$marka_adi2." " . $filtre_oku['model']." " . $filtre_oku['tip']) > 135){
                                 $ilan_karti_baslik_bas = substr($filtre_oku['model_yili']." ".$marka_adi2." " . $filtre_oku['model']." " . $filtre_oku['tip'],0,135)."...";
                              }else{
                                 $ilan_karti_baslik_bas = $filtre_oku['model_yili']." ".$marka_adi2." " . $filtre_oku['model']." " . $filtre_oku['tip'];
                              } 
                        ?>
                        <text style="font-size: 15px;font-weight:bold;color: #fff;"><i class="fas fa-car" aria-hidden="true"></i> <?= $ilan_karti_baslik_bas ?></text>
                        <?php array_push($sira_array,$sira); ?>
                        <span id="sayac<?=$sira?>" ></span>
                        <input type="hidden" id="ihale_sayac<?=$sira?>" value="<?= $filtre_oku['ihale_tarihi'].' '. $filtre_oku['ihale_saati'] ?>">
                        <input type="hidden" id="id_<?=$sira?>" value="<?= $filtre_oku['id'] ?>">
                        <input type="hidden" id="sure_uzatilma_durum_<?=$sira?>" value="<?= $filtre_oku['sistem_sure_uzatma_durumu'] ?>">
                        <input type="hidden" id="belirlenen_<?=$sira?>" value="<?= $sigorta_oku2['bu_sure_altinda_teklif'] ?>">
                        <input type="hidden" id="gosterilme_<?=$sira ?>" value="<?=gosterilme_durumu($filtre_oku['id']) ?>">
                     </div>
                     <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ilan_karti_icerik_dis">
                        <div class="ilan_karti_gorsel_dis" style="background-image:url('images/<?= $resim ?>');">
                           <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ilan_karti_kod">
                           <?php 
                              if(strlen($filtre_oku['arac_kodu']) > 15){
                                 $arac_kodu_yeni = substr($filtre_oku['arac_kodu'],0,15)."...";
                              }else{
                                 $arac_kodu_yeni = $filtre_oku['arac_kodu'];
                              }
                           ?>
                              #<?= $arac_kodu_yeni ?>
                           </div>
                        </div>
                        <div class="ilan_karti_gorsel_icerik">
                           <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ilan_karti_taglar_dis">
                              <?php if($filtre_oku['yakit_tipi']!=""){ ?>
                              <div class="ilan_karti_tag">
                              <img src="images/car_list_icons/1.png" />
                                 <?= $filtre_oku['yakit_tipi'] ?>
                              </div>
                              <?php } if($filtre_oku['vites_tipi']!=""){ ?>
                              <div class="ilan_karti_tag">
                              <img src="images/car_list_icons/2.png" />
                                 <?= $filtre_oku['vites_tipi'] ?>
                              </div>
                              <?php }if($filtre_oku['kilometre']!=""){ ?>
                              <div class="ilan_karti_tag">
                              <img src="images/car_list_icons/7.png" />
                                 <?= money($filtre_oku['kilometre']) ?> km
                              </div>
                              <?php } if($filtre_oku['sehir']!=""){ ?>
                              <div class="ilan_karti_tag">
                              <img src="images/car_list_icons/3.png" />
                                 <?= $filtre_oku['sehir'] ?>
                              </div>
                              <?php }if($filtre_oku['ihale_turu']!=""){ ?>
                              <div class="ilan_karti_tag">
                                 <img src="images/car_list_icons/4.png" />
                                 <?php if($filtre_oku['ihale_turu']==1){$ihale_turu = "Açık  İhale";}else{$ihale_turu="Kapalı İhale";} ?>
                                 <?= $ihale_turu ?>
                              </div>
                              <?php } if($filtre_oku['profil']!=""){ ?>
                              <div class="ilan_karti_tag <?= $blink ?>">
                                 <img src="images/car_list_icons/5.png" />
                                 <?= $filtre_oku['profil'] ?>
                              </div>
                              <?php }if($filtre_oku['ihale_tarihi']!=""){  ?>
                              <div class="ilan_karti_tag ">
                                 <img src="images/car_list_icons/6.png" />
                                 <span class="kapanis_zamani<?=$sira ?>" ><?= date("d-m-Y H:i:s",strtotime($filtre_oku['ihale_tarihi']." ".$filtre_oku['ihale_saati'])) ?></span>
                              </div>
                              <?php } ?>
                           </div>
                           <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ilan_karti_alt_alan">
                              <div class="col-xs-12 col-sm-12 col-md-7 col-lg-7 ilan_karti_notlar_dis">
                                 
                              <div data-toggle="modal" data-target="#notmodal_<?=$filtre_oku['id'] ?>" class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ilan_karti_not_alan">
                                    <?php $onay_cek = mysql_query("select * from sigorta_ozellikleri where id = '".$filtre_oku['sigorta']."'"); 
                                       $onay_oku = mysql_fetch_assoc($onay_cek);
                                       // $onay = $onay_oku['sigorta_aciklamasi'];
                                       $onay = $onay_oku['uyari_notu'];
                                       ?>
                                    <b><?= $filtre_oku['uyari_notu']."<br>".$onay ?></b>
                                 </div>
                                 <div class="modal fade" id="notmodal_<?=$filtre_oku['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="notmodal_<?=$filtre_oku['id'] ?>" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                       <div class="modal-content">
                                          <div class="modal-header">
                                             <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                             <span aria-hidden="true">&times;</span>
                                             </button>
                                          </div>
                                          <div class="modal-body" style="font-weight: 600 !important;">
                                             <?= $filtre_oku['uyari_notu']."<br>".$onay ?>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                                 <?php
                                    if($uye_token!=""){
                                    	$user_getir=mysql_fetch_object(mysql_query("select * from user where user_token='".$uye_token."' or kurumsal_user_token='".$uye_token."'"));
                                    	$id_u=$user_getir->id;
                                    	$en_yksk="";
                                    	$sql_teklif=mysql_query("select * from teklifler where ilan_id='".$filtre_oku['id']."' and uye_id='".$id_u."' and durum=1 order by teklif_zamani desc limit 1");
                                    	$teklif_say=0;
                                    	while($row_teklif=mysql_fetch_object($sql_teklif)){
                                    		if($row_teklif->teklif == $filtre_oku['son_teklif'] ){
                                    			$en_yksk =' 
                                    				<b style="color: green; text-align:center;float:right;display: none">En yüksek teklif sizindir.</b><br/>
                                    				<b style="color: red; text-align:center;float:right">'.money($row_teklif->teklif).' ₺ teklif verdiniz.</b>
                                    			';
                                    			//$carda_bas = ' <i style="color: green; text-align:center;">En yüksek teklif sizindir.</i>';
                                    		}else if($row_teklif->teklif == ""){
                                    			$en_yksk =' 
                                    				<b style="color: red; text-align:center;">Henüz teklif vermediniz.</b>
                                    			';
                                    		}else if($row_teklif->teklif != $filtre_oku['son_teklif'] && $row_teklif->teklif != "" && $teklif_say==0 ){
                                    			$en_yksk =' 
                                    						<b style="color: red; text-align:center;">'.money($row_teklif->teklif).' ₺ teklif verdiniz.</b>
                                    					  ';
                                    		}
                                    		$teklif_say++;
                                    	}
                                    	
                                    	$en_yksk_kapali="";
                                    	$sql_teklif=mysql_query("select * from teklifler where ilan_id='".$filtre_oku['id']."' and uye_id='".$id_u."' and durum=1 order by teklif_zamani desc limit 1");
                                    	$ilan_kontrol=mysql_query("select * from ilanlar where id='".$filtre_oku['id']."' ");
                                    	$ilan_kontrol_cek=mysql_fetch_object($ilan_kontrol);
                                    	$kapali_durum=$ilan_kontrol_cek->ihale_turu;
                                    	$teklif_say_kapali=0;
                                    	while($row_teklif=mysql_fetch_object($sql_teklif)){
                                    		if($kapali_durum=="2"){
                                    			if($row_teklif->teklif == ""){
                                    			$en_yksk_kapali ='<b style="color: red; text-align:center;">Henüz teklif vermediniz.</b>';
                                    			}else if( $row_teklif->teklif != "" && $teklif_say_kapali==0 ){
                                    				$en_yksk_kapali ='<b style="color: red; text-align:center; display:none;">'.money($row_teklif->teklif).' ₺ teklif verdiniz.</b>';
                                    			}
                                    			$teklif_say_kapali++;
                                    		}
                                    	}
                                    }else{
                                    	$en_yksk='';
                                    	$en_yksk_kapali='';
                                    }
                                    ?>
                                 <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 ilan_karti_begeni_dis">
                                    <form method="POST" action="" >
                                       <div class="btn-group" role="group">
                                          <div onclick="bildirim_ac(<?= $filtre_oku['id'] ?>)">
                                             <button data-toggle="tooltip" data-placement="top" title="<?=$bildirim_title ?>" type="button" name="bildirim_ac" id="bildirim_ac_<?= $filtre_oku['id'] ?>" class="btn btn-light mr-2 btn-sm">
                                             <i style="color: <?= $bidlirim_color ?>;font-size: 20px;" class="icon-notifications"></i>
                                             <input type="hidden" name="bildirimlenecek" value="<?= $filtre_oku['id'] ?>">
                                             </button>
                                          </div>
                                          <div onclick="favla(<?= $filtre_oku['id'] ?>);" >
                                             <button data-toggle="tooltip" data-placement="top" title="<?=$fav_title ?>" type="button" name="favla" id="favla_<?= $filtre_oku['id'] ?>" class="btn btn-light btn-sm">
                                             <i style="color: <?= $fav_color ?>;font-size: 20px;" class="fas fa-star"></i>
                                             <input type="hidden" name="favlanacak" value="<?= $filtre_oku['id'] ?>">
                                             </button>
                                          </div>
                                       </div>
                                    </form>
                                 </div>
                                 <div id="uye_bilgi_<?=$filtre_oku['id'] ?>" class="col-xs-8 col-sm-8 col-md-8 col-lg-8 ilan_karti_begeni_dis">
                                    <?php if($filtre_oku['ihale_turu']==1) {
                                       echo $en_yksk;
                                       }else{ 
                                       echo $en_yksk_kapali; 
                                       } ?>
                                 </div>
                              </div>
                              <div class="col-xs-12 col-sm-12 col-md-5 col-lg-5 ilan_karti_teklif_dis">
                                 <?php if($filtre_oku['ihale_turu']==1){ ?>
                                 <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ilan_karti_teklif_baslik">
                                    En Yüksek
                                 </div>
                                 <div id="en_yuksek_<?=$filtre_oku["id"] ?>" class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ilan_karti_teklif_fiyat">
                                    <?php
                                       $bitis_tarihi=$filtre_oku["ihale_tarihi"]." ".$filtre_oku["ihale_saati"];
                                       $ihale_son_str = strtotime($bitis_tarihi);
                                       $suan_str = strtotime(date("Y-m-d H:i:s"));
                                       $sonuc=($ihale_son_str-$suan_str)/60;
                                       if($sonuc<30){ 
                                       	if($kullanici_grubu==1){ ?>
                                    <?= money($filtre_oku['son_teklif']) ?> ₺
                                    <?php } else { ?>
                                    <i style="color:#000" class="fas fa-lock"></i>
                                    <?php } ?>
                                    <?php } else { 
                                       if($kullanici_grubu==1 || $kullanici_grubu==4 || $kullanici_grubu==0){ ?>
                                          <?= money($filtre_oku['son_teklif']) ?> ₺
                                 <?php } else { ?>
                                          <!-- <i style="color:#000" class="fas fa-lock"></i> -->
                                          <?= money($filtre_oku['son_teklif']) ?> ₺
                                 <?php } ?>
                                    <?php }
                                       ?>
                                 </div>
                                 <?php } else { ?>
                                 <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ilan_karti_teklif_baslik">
                                    Taban Fiyat
                                 </div>
                                 <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ilan_karti_teklif_fiyat">
                                    <?= money($filtre_oku['acilis_fiyati']) ?> ₺
                                 </div>
                                 <?php } ?>
                                 <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ilan_karti_teklif_btnlar">
                                    <div class="ilan_karti_teklif_btn" style="background-color:<?= $background_color ?>; cursor:pointer;">

                                    <?php
                                    if($uye_token == ""){ ?>
                                    <a onclick="alert('Teklif verebilmek için üye girişi yapmanız gerekmektedir')" data-keyboard="false" data-backdrop="static" style="text-decoration: none; color:#ffffff;" >TEKLİF VER</a>                                
                                    <?php }else{ ?>
                                       <a onclick="kontrol(<?=$filtre_oku['id']?>);locale_kaydet(<?=$filtre_oku['id']?>);" data-keyboard="false" data-backdrop="static" data-toggle="modal" data-target="#teklifVer<?=$filtre_oku['id']?>" style="text-decoration: none; color:#ffffff;">TEKLİF VER</a>                                                           
                                    <?php }
                                    ?>


                                       
                                    </div>
                                    <div class="ilan_karti_teklif_btn" style="background-color: #424242;">
                                       <a onclick="ihale_arttir(<?=$filtre_oku['id']?>)"  style="text-decoration: none; color:#ffffff;" href="arac_detay.php?id=<?= $filtre_oku['id'] ?>&q=ihale" target="_blank">İNCELE</a>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="clearfix"></div>
                  <?php	
                     $ihale_tur_sorgu=mysql_query("select * from ilanlar where id='".$filtre_oku['id']."'  ");
                     $tur_cek=mysql_fetch_object($ihale_tur_sorgu);
                     $komisyon_cek = mysql_query("SELECT * FROM ilan_komisyon WHERE ilan_id = '".$filtre_oku['id']."'");
                     $komisyon_oku = mysql_fetch_assoc($komisyon_cek);
                     $komisyon = $komisyon_oku['toplam'];
                     $sorgu = mysql_query("SELECT * FROM komisyon_oranlari WHERE sigorta_id = '".$filtre_oku['sigorta']."'");
                     $sorgu_say = mysql_num_rows($sorgu);
                     $arttir = 1;
                     $oran = array();
                     $standart_net = array();
                     $luks_net = array();
                     $standart_onbinde = array();
                     $luks_onbinde = array();
                     while($sonuc = mysql_fetch_array($sorgu)){
                     	array_push($oran, $sonuc['komisyon_orani']);
                     	array_push($standart_net, $sonuc['net']);
                     	array_push($luks_net, $sonuc['lux_net']);
                     	array_push($standart_onbinde, $sonuc['onbinde']);
                     	array_push($luks_onbinde, $sonuc['lux_onbinde']);
                     ?>
                  <input type="hidden" name="standart_net[]" id="standart_net<?= $filtre_oku['id'] ?>" value="<?= json_encode($standart_net) ?>">
                  <input type="hidden" name="luks_net[]" id="luks_net<?= $filtre_oku['id'] ?>" value="<?= json_encode($luks_net) ?>">
                  <input type="hidden" name="standart_onbinde[]" id="standart_onbinde<?= $filtre_oku['id'] ?>" value="<?= json_encode($standart_onbinde) ?>">
                  <input type="hidden" name="luks_onbinde[]" id="luks_onbinde<?= $filtre_oku['id'] ?>" value="<?= json_encode($luks_onbinde) ?>">
                  <input type="hidden" name="oran[]" id="oran<?= $filtre_oku['id'] ?>" value="<?= json_encode($oran) ?>">
                  <?php } ?>
                  <input type="hidden" id="hesaplama<?= $filtre_oku['id'] ?>" value="<?= $filtre_oku['hesaplama'] ?>">
                  <input type="hidden" id="sorgu_sayi<?= $filtre_oku['id'] ?>" value="<?= $sorgu_say ?>">
                  <?php 
                     $sgrt=mysql_fetch_object(mysql_query("select * from sigorta_ozellikleri where id='".$filtre_oku['sigorta']."' "));
                     $min=$sgrt->minumum_artis; 
                     $h1=$sgrt->hizli_teklif_1; 
                     $h2=$sgrt->hizli_teklif_2; 
                     $h3=$sgrt->hizli_teklif_3; 
                     $h4=$sgrt->hizli_teklif_4;   
                     $s_mesaj=$sgrt->teklif_iletme_mesaji;   
                     $tur=$tur_cek->ihale_turu;
                     $tbn_fiyat=$tur_cek->acilis_fiyati; ?>
                  <?php
                     if($tur=="1"){ ?>
                  <input type="hidden" id="ihale_tur" value="<?=$tur ?>">
                  <div class="modal fade" id="teklifVer<?=$filtre_oku['id']?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                     <div class="modal-dialog">
                        <div class="modal-content">
                           <div class="container">
                              <form method="post">
                                 <div class="modal-header">    
                                    <button style="margin-top:1%; font-size:17px; font-weight:600;" type="button" class="btn btn-dark  btn-block"><?=$filtre_oku['model_yili']." ".$setMarka['marka_adi']." ". $filtre_oku['model'] ?></button>    
                                    <button type="button" id="modal_kapat<?=$filtre_oku['id']?> " onclick="secimleri_sil(<?=$filtre_oku['id'] ?>)" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                 </div>
                                 <div class="modal-body">
                                    <div class="row">
                                       <div class="col">
                                          <p style="text-align:left; font-size:15px; font-weight:600;">PD HİZMET BEDELİ</p>
                                          <b style="color:blue;display:none"></b>  
                                          <button type="button" class="btn btn-dark btn-block" style="font-size:16px; font-weight:600;" >
                                          <span id="hizmet_bedel<?=$filtre_oku['id']?>"></span> 
                                          </button>																
                                       </div>
                                       <div class="col">
                                          <p style="text-align:center; font-size:15px; font-weight:600;">VERİLECEK TEKLİF</p>
                                          <button type="button" class="btn btn-dark btn-block" style="font-size:16px; font-weight:600; background-color:rgb(247, 148, 29);border-color:transparent !important;" id="GelenTeklif<?=$filtre_oku['id']?>"> 
                                          </button>
                                       </div>
                                    </div>
                                    <div class="row mt-4">
                                       <div class="col">
                                          <button style="background-color:#00a2e8; color:#fff; font-weight:600;" type="button" class="btn btn-block mavi"  onclick="buttonClick(<?=$filtre_oku['id'] ?>);" id="arti1<?=$filtre_oku['id'] ?>" value="<?=$h1 ?>">
                                          +<?= money($h1)?>₺
                                          </button>
                                       </div>
                                       <div class="col">
                                          <button style="background-color:#00a2e8; color:#fff; font-weight:600;" type="button" class="btn btn-block mavi"  onclick="buttonClick2(<?=$filtre_oku['id'] ?>);" id="arti2<?=$filtre_oku['id'] ?>" value="<?=$h2 ?>">
                                          +<?= money($h2)?>₺
                                          </button>
                                       </div>
                                       <div class="col">
                                          <button style="background-color:#00a2e8; color:#fff; font-weight:600;" type="button" class="btn btn-block mavi"  onclick="clickButton(<?=$filtre_oku['id'] ?>);" id="arti3<?=$filtre_oku['id'] ?>" value="<?=$h3 ?>">
                                          +<?= money($h3)?>₺
                                          </button>
                                       </div>
                                       <div class="col">
                                          <button style="background-color:#00a2e8; color:#fff; font-weight:600;" type="button" class="btn btn-block mavi"  onclick="clickButton2(<?=$filtre_oku['id'] ?>);" id="arti4<?=$filtre_oku['id'] ?>" value="<?=$h4 ?>">
                                          +<?= money($h4)?>₺
                                          </button>
                                       </div>
                                    </div>
                                    <div class="row mt-4">
                                       <div class="col" style="text-align:right; padding:10px 0px;">
                                          Teklifinizi Yazınız
                                       </div>
                                       <div class="col">
                                          <?php if($filtre_oku['son_teklif']==0){ ?>
                                          <input style="height:40px;" placeholder="Teklifinizi buraya yazınız." type="number"  value=""  step="<?=$min_arti ?>" class="form-control" id="verilen_teklif<?=$filtre_oku['id']?>" onchange="teklif_kontrol(<?=$filtre_oku['id']?>);" onkeyup="teklif_kontrol(<?=$filtre_oku['id']?>);">
                                          <input type="hidden" value="<?= $filtre_oku['acilis_fiyati'] ?>" id="verilen_teklif_hidden<?=$filtre_oku['id']?>" >
                                          <?php } else {  ?>
                                          <input style="height:40px;" placeholder="Teklifinizi buraya yazınız." type="number"  value=""  step="<?=$min_arti ?>" class="form-control" id="verilen_teklif<?=$filtre_oku['id']?>" onchange="teklif_kontrol(<?=$filtre_oku['id']?>);" onkeyup="teklif_kontrol(<?=$filtre_oku['id']?>);">
                                          <input type="hidden" value="<?= $filtre_oku['son_teklif'] ?>" id="verilen_teklif_hidden<?=$filtre_oku['id']?>" >
                                          <?php } ?>
                                          <label id="teklif_kontrol<?=$filtre_oku['id']?>"></label> 
                                       </div>
                                    </div>
                                    <div class="row mt-2">
                                       <div class="col">
                                          <div class="col">
                                             <textarea style="width:calc(100% + 30px); margin:15px -15px; min-height:250px;" id="deneme_alan<?=$filtre_oku['id']?>" rows="3" disabled placeholder="<?=$s_mesaj ?>"></textarea>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="row mt-2">
                                       <div class="col">
                                          <input type="checkbox" id="sozlesme_kontrol<?=$filtre_oku['id']?>" value="1" required>  
                                          <span onclick="popup('<?=$s_mesaj?>')">Yukarıdaki Koşulları Okudum ve Kabul Ediyorum.</span>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="row mt-2 mb-2">
                                    <div class="col">
                                       <button type="button" onclick="secimleri_sil(<?=$filtre_oku['id'] ?>)" class="btn btn-danger btn-block" id="acik_modal_kapat2<?=$filtre_oku["id"] ?>" data-dismiss="modal">Vazgeç</button>
                                    </div>
                                    <div class="col"><button type="button" class="btn btn-success btn-block" id="TeklifVer<?=$filtre_oku['id']?>"  onclick="denem(<?=$filtre_oku['id']?>);"><i class="fas fa-lira-sign"> Teklif Ver</i></button></div>
                                 </div>
                              </form>
                           </div>
                        </div>
                     </div>
                  </div>
                  <?php } else { ?>
                  <input type="hidden" id="ihale_tur" value="<?=$tur ?>"/>

				  <div class="modal fade" id="teklifVer<?=$filtre_oku['id']?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="container">
            <form method="post">
               <div class="modal-header">    
                  <button style="margin-top:1%; font-size:17px; font-weight:600;" type="button" class="btn btn-dark btn-block"><?=$filtre_oku['model_yili']." ".$setMarka['marka_adi']." ". $filtre_oku['model']?></button>    
                  <button type="button" class="close" data-dismiss="modal" id="modal_kapat<?=$filtre_oku['id']?>"  aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                  </button>
               </div>
               <div class="modal-body">
                  <div class="row">
                     <div class="col">
                        <p style="text-align:left; font-size:15px; font-weight:600;">PD HİZMET BEDELİ</p>
                        <b style="color:blue;display:none"></b>  
                        <button type="button" class="btn btn-dark btn-block"style="font-size:16px; font-weight:600;">
                        <span id="hizmet_bedel<?=$filtre_oku['id']?>"></span> 
                        </button>																
                     </div>
                     <div class="col">
                        <p style="text-align:center; font-size:15px; font-weight:600;">VERİLECEK TEKLİF</p>
                        <button type="button" class="btn btn-dark btn-block" style="font-size:16px; font-weight:600; background-color:rgb(247, 148, 29);border-color:transparent !important;" id="GelenTeklif<?=$filtre_oku['id']?>"> 
                        </button>
                     </div>
                  </div>
                  <div class="row mt-4">
                     <div class="col" style="text-align:right; padding:10px 0px;">
                        Teklifinizi Yazınız
                     </div>
                     <div class="col">
                        <input style="height40px;" type="number" placeholder="Teklifinizi buraya yazınız."  value=""  step="<?=$min_arti?>" class="form-control" id="verilen_teklif<?=$filtre_oku['id']?>" onchange="teklif_kontrol(<?=$filtre_oku['id']?>);" onkeyup="komisyon_kontrol(<?=$filtre_oku['id']?>);">					   
                        <label id="teklif_kontrol<?=$filtre_oku['id']?>"></label> 
                     </div>
                  </div>
                  <div class="row mt-2">
                     <div class="col">
                        <div class="col">
                           <textarea style="width:calc(100% + 30px); margin:15px -15px; min-height:250px;" rows="3" disabled id="deneme_alan<?=$filtre_oku['id']?>"placeholder="<?=$s_mesaj ?>"></textarea>
                        </div>
                     </div>
                  </div>
                  <div class="row mt-2">
                     <div class="col" onclick="popup('<?=$s_mesaj  ?>')">
                        <input type="checkbox" id="sozlesme_kontrol<?=$filtre_oku['id']?>" value="1" required>  
                        <span onclick="popup('<?=$s_mesaj  ?>')">Yukarıdaki Koşulları Okudum ve Kabul Ediyorum.</span>
                     </div>
                  </div>
               </div>
               <div class="row mt-2 mb-2">
                  <div class="col">
                     <button type="button" class="btn btn-danger btn-block" data-dismiss="modal" id="modal_kapat2<?=$filtre_oku["id"] ?>">
                     Vazgeç
                     </button>
                  </div>
                  <div class="col">
                     <button type="button" class="btn btn-success btn-block" id="TeklifVer<?=$filtre_oku['id']?>" onclick="denem(<?=$filtre_oku['id']?>);">
                     <i class="fas fa-lira-sign"> Teklif Ver</i>
                     </button>
                  </div>
               </div>
            </form>
         </div>
      </div>
   </div>
</div>

                  <?php } 
                     } 
                     } 
                     $sira++;
                     } 
                     } 
                     }else{
                     $sira=0;
                     $sira_array=array();
                     $modal_array=array();
                     $ihale_say=mysql_num_rows($sql);  
                     // İlan sayısı / reklam sayısı ==> Bu kadar ilandan sonra reklam çıkıyor
                     $dateTime = date('Y-m-d H:i:s');
                     $reklam_icin_cek = mysql_query("SELECT * FROM ilanlar WHERE ihale_acilis <= '".$today."' AND ihale_tarihi >= '".$today."' AND durum = 1 ");
                     $reklam_icin_say = mysql_num_rows($reklam_icin_cek);						  
                     $reklam_cek = mysql_query("SELECT * FROM reklamlar WHERE baslangic_tarihi <= '".$dateTime."' AND bitis_tarihi >= '".$dateTime."' ORDER BY RAND()");     
                     $reklam_say = mysql_num_rows($reklam_cek);
                     $gosterim_sayi = floor($reklam_icin_say / $reklam_say);                     
                     $reklam_array = array();
                     $reklam_url_array = array();
                     $row_number=0;
                     while($reklam_oku = mysql_fetch_array($reklam_cek)){
                           array_push($reklam_array,$reklam_oku['resim']);
                        if($reklam_oku['url']==""){
                           array_push($reklam_url_array,"https://ihale.pertdunyasi.com/reklam_url.php?id=".$reklam_oku["id"]."");
                        }else{
                           array_push($reklam_url_array,$reklam_oku["url"]);
                        }
                     }
                     $sayac=0; 
                     if($_SESSION['u_token'] != "" && $_SESSION['k_token']=="" ){
                        $renkli_uye_bul = mysql_query("SELECT * FROM user WHERE user_token = '".$_SESSION['u_token']."'");
                        $renkli_uye_oku = mysql_fetch_assoc($renkli_uye_bul);
                        $renkli_uye_id = $renkli_uye_oku['id'];  
                        $uye_paket = $renkli_uye_oku['paket'];   
                        $uye_token = $_SESSION['u_token'];
                     }else if($_SESSION['u_token'] == "" && $_SESSION['k_token'] !="" ){
                        $renkli_uye_bul = mysql_query("SELECT * FROM user WHERE kurumsal_user_token = '".$_SESSION['k_token']."'");
                        $renkli_uye_oku = mysql_fetch_assoc($renkli_uye_bul);
                        $renkli_uye_id = $renkli_uye_oku['id'];   
                        $uye_paket = $renkli_uye_oku['paket'];   
                        $uye_token = $_SESSION['k_token'];
                     }else{
                        $uye_token = "";
                        $uye_paket = 2;
                     }
                     while($ihale_oku = mysql_fetch_array($sql)){ 
                        $favli_mi = mysql_query("SELECT * FROM favoriler WHERE uye_id = '".$renkli_uye_id."' AND ilan_id = '".$ihale_oku['id']."'");
                        $favli_say = mysql_num_rows($favli_mi);
                        if($favli_say == 0){
                           $fav_color = "gray";
                           $fav_title = "Araç favorilerinize eklenecektir";
                        }else{
                           $fav_color = "orange";
                           $fav_title = "Araç favorilerinizden kaldırılacaktır";
                        }

                        $bildirimli_mi = mysql_query("SELECT * FROM bildirimler WHERE uye_id = '".$renkli_uye_id."' AND ilan_id = '".$ihale_oku['id']."'");
                        $bildirimli_say = mysql_num_rows($bildirimli_mi);
                        if($bildirimli_say == 0){
                           $bidlirim_color = "gray";
                           $bildirim_title = "Araç bildirimi açılacaktır.";
                        }else{
                           $bidlirim_color = "orange";
                           $bildirim_title = "Araç bildirimi kapatılacaktır.";
                        }
                     $row_number++; 
                     if($reklam_icin_say>50){
                     $advertisment_block = '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
                        <a target="_blank" href="'.$reklam_url_array[$sayac].'">
                           <img oncontextmenu="return false;" src="reklamlar/'.$reklam_array[$sayac].' " alt="" style="width:100%; height:auto;">
                        </a>
                     </div>' ; 
                     }
                     if($renkli_uye_id != ""){
                        $yasakli_sigorta=mysql_query("SELECT * FROM uye_durumlari WHERE uye_id = '". $renkli_uye_id."'");
                        $yasakli_sigorta_cek=mysql_fetch_array($yasakli_sigorta);
                        $yasaki_sigorta_id=$yasakli_sigorta_cek["yasak_sigorta"];                     
                        if($ihale_oku['profil']=="Hurda Belgeli"){
                           $blink = "blink";
                        }else{
                           $blink="";
                        }
                     }else{
                        $uye_token="";
                        $uye_paket = 2;//Ziyaretçi Paketinin Id'si 2
                        $yasaki_sigorta_id=""; 
                     }                     
                     $sigorta_cek = mysql_query("SELECT * FROM sigortalar WHERE sigorta_id = '".$ihale_oku['sigorta']."' and paket_id='".$uye_paket ."'");
                     $sigorta_say = mysql_num_rows($sigorta_cek);
                     $sigorta_cek2 = mysql_query("SELECT * FROM sigorta_ozellikleri WHERE id = '".$ihale_oku['sigorta']."' ");
                     $sigorta_oku2 = mysql_fetch_array($sigorta_cek2);
                     $min_arti = $sigorta_oku2['minumum_artis'];
                     //$sigorta_say = mysql_num_rows($sigorta_cek);
                     $sigorta_oku = mysql_fetch_array($sigorta_cek);
                     $secilen_yetki_id = $sigorta_oku['secilen_yetki_id'];
                     $detay_gorur = $sigorta_oku['detay_gorur'];
                     $yasak_sigorta_array = explode(",", $yasaki_sigorta_id);                    
                     // if($ihale_oku['sigorta'] != $yasaki_sigorta_id ){
                     if(!in_array($ihale_oku['sigorta'], $yasak_sigorta_array)){
                     if($secilen_yetki_id==2 ){ 
                     if($detay_gorur==1){ 
                     $anlik = date("Y-m-d H:i:s");
                     $getID = $ihale_oku['id'];
                     $getImage = mysql_query("SELECT * FROM ilan_resimler WHERE ilan_id = '".$getID."' ORDER BY RAND() LIMIT 1");
                     $setImage = mysql_fetch_assoc($getImage);
                     $image = $setImage['resim'];
                     $getMarka = mysql_query("SELECT * FROM marka WHERE markaID = '".$ihale_oku['marka']."' LIMIT 1");
                     $getSehir = mysql_query("SELECT * FROM sehir WHERE sehirID = '".$ihale_oku['sehir']."' LIMIT 1");
                     $setMarka = mysql_fetch_assoc($getMarka) ;      
                     if($image == ""){
                        $image="default.png";
                     } 
                     ?> 
                  <input type="hidden" id="ihale_say" value="<?=$ihale_say ?>">	     
                  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ilan_karti_dis">
                     <?php  if($ihale_oku['ihale_turu']==1){$background_color = "#00a2e8";}else{$background_color="orange";}  array_push($sira_array,$sira); ?>
                     <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ilan_karti_baslik "  style="background-color:<?= $background_color ?>">
                     <?php 
                        if(strlen($ihale_oku['model_yili']." ".$setMarka['marka_adi']." " . $ihale_oku['model']." ".$ihale_oku['tip']) > 135){
                           $ilan_karti_baslik_bas = substr($ihale_oku['model_yili']." ".$setMarka['marka_adi']." " . $ihale_oku['model']." ".$ihale_oku['tip'],0,135)."...";
                        }else{
                           $ilan_karti_baslik_bas = $ihale_oku['model_yili']." ".$setMarka['marka_adi']." " . $ihale_oku['model']." ".$ihale_oku['tip'];
                        } 
                     ?>
                        <text style="font-size: 15px;font-weight:bold;color: #fff;"><i class="fas fa-car" aria-hidden="true"></i> <?= $ilan_karti_baslik_bas ?></text>
                        <span  id="sayac<?=$sira?>"> </span>
                        <input type="hidden" id="ihale_sayac<?=$sira?>" value="<?= $ihale_oku['ihale_tarihi'].' '. $ihale_oku['ihale_saati'] ?>">
                        <input type="hidden" id="id_<?=$sira?>" value="<?= $ihale_oku['id'] ?>">
                        <input type="hidden" id="sure_uzatilma_durum_<?=$sira?>" value="<?= $ihale_oku['sistem_sure_uzatma_durumu'] ?>">
                        <input type="hidden" id="belirlenen_<?=$sira?>" value="<?= $sigorta_oku2['bu_sure_altinda_teklif'] ?>">
                        <input type="hidden" id="gosterilme_<?=$sira ?>" value="<?=gosterilme_durumu($ihale_oku['id']) ?>">
                     </div>
                     <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ilan_karti_icerik_dis">
                        <div class="ilan_karti_gorsel_dis" style="background-image:url('images/<?= $image ?>');">
                           <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ilan_karti_kod">
                           <?php 
                              if(strlen($ihale_oku['arac_kodu']) > 15){
                                 $arac_kodu_yeni = substr($ihale_oku['arac_kodu'],0,15)."...";
                              }else{
                                 $arac_kodu_yeni = $ihale_oku['arac_kodu'];
                              }
                           ?>
                              #<?= $arac_kodu_yeni ?>
                           </div>
                        </div>
                        <div class="ilan_karti_gorsel_icerik">
                           <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ilan_karti_taglar_dis">
                              <?php if($ihale_oku['yakit_tipi']!=""){ ?>
                              <div class="ilan_karti_tag">
                              <img src="images/car_list_icons/1.png" />
                                 <?= $ihale_oku['yakit_tipi'] ?>
                              </div>
                              <?php } if($ihale_oku['vites_tipi']!=""){ ?>
                              <div class="ilan_karti_tag">
                              <img src="images/car_list_icons/2.png" />
                                 <?= $ihale_oku['vites_tipi'] ?>
                              </div>
                              <?php }if($ihale_oku['kilometre']!=""){ ?>
                              <div class="ilan_karti_tag">
                              <img src="images/car_list_icons/7.png" />
                                 <?= money($ihale_oku['kilometre']) ?> km
                              </div>
                              <?php } if($ihale_oku['sehir']!=""){ ?>
                              <div class="ilan_karti_tag">
                              <img src="images/car_list_icons/3.png" />
                                 <?= $ihale_oku['sehir'] ?>
                              </div>
                              <?php }if($ihale_oku['ihale_turu']!=""){ ?>
                              <div class="ilan_karti_tag">
                              <img src="images/car_list_icons/4.png" />
                                 <?php if($ihale_oku['ihale_turu']==1){$ihale_turu = "Açık  İhale";}else{$ihale_turu="Kapalı İhale";} ?>
                                 <?= $ihale_turu ?>
                              </div>
                              <?php } if($ihale_oku['profil']!=""){ ?>
                              <div class="ilan_karti_tag <?= $blink ?>">
                                 <img src="images/car_list_icons/5.png" />
                                 <?= $ihale_oku['profil'] ?>
                              </div>
                              <?php }if($ihale_oku['ihale_tarihi']!=""){  ?>
                              <div class="ilan_karti_tag ">
                                <img src="images/car_list_icons/6.png" />
                               <span class="kapanis_zamani<?=$sira ?>" ><?= date("d-m-Y H:i:s",strtotime($ihale_oku['ihale_tarihi']." ".$ihale_oku['ihale_saati'])) ?></span>
                              </div>
                              <?php } ?>
                           </div>
                           <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ilan_karti_alt_alan">
                              <div class="col-xs-12 col-sm-12 col-md-7 col-lg-7 ilan_karti_notlar_dis">
                                 <!--<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ilan_karti_not_baslik">
                                       Sigorta Onay Notu
                                    </div>-->
                                 <div data-toggle="modal" data-target="#notmodal_<?=$ihale_oku['id'] ?>" class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ilan_karti_not_alan">
                                    <?php $onay_cek = mysql_query("select * from sigorta_ozellikleri where id = '".$ihale_oku['sigorta']."'"); 
                                       $onay_oku = mysql_fetch_assoc($onay_cek);
                                       // $onay = $onay_oku['sigorta_aciklamasi'];
                                       $onay = $onay_oku['uyari_notu'];
                                       ?>
                                    <b><?= $ihale_oku['uyari_notu']."<br>".$onay ?></b>
                                 </div>
                                 <div class="modal fade" id="notmodal_<?=$ihale_oku['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="notmodal_<?=$ihale_oku['id'] ?>" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                       <div class="modal-content">
                                          <div class="modal-header">
                                             <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                             <span aria-hidden="true">&times;</span>
                                             </button>
                                          </div>
                                          <div class="modal-body" style="font-weight: 600 !important;">
                                             <?= $ihale_oku['uyari_notu']."<br>".$onay ?>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ilan_karti_begeni_dis">
                                    <form method="POST" action="" name="form">
                                       <div class="btn-group" role="group">
                                          <div onclick="bildirim_ac(<?= $ihale_oku['id'] ?>);" >
                                             <button data-toggle="tooltip" data-placement="top" title="<?=$bildirim_title ?>" type="button" id="bildirim_ac_<?= $ihale_oku['id'] ?>" name="bildirim_ac" class="btn btn-light mr-2 btn-sm">
                                             <i style="color: <?= $bidlirim_color ?>;font-size: 20px;" class="icon-notifications"></i>
                                             <input type="hidden" name="bildirimlenecek" value="<?= $ihale_oku['id'] ?>">
                                             </button>
                                          </div>
                                          <div onclick="favla(<?= $ihale_oku['id'] ?>);" >
                                             <button data-toggle="tooltip" data-placement="top" title="<?=$fav_title ?>" type="button" id="favla_<?= $ihale_oku['id'] ?>" name="favla" class="btn btn-light btn-sm">
                                             <i style="color: <?= $fav_color ?>;font-size: 20px;" class="fas fa-star"></i>
                                             <input type="hidden" name="favlanacak" value="<?= $ihale_oku['id'] ?>">
                                             </button>
                                          </div>
                                       </div>
                                    </form>
                                 </div>
                              </div>
                              <div class="col-xs-12 col-sm-12 col-md-5 col-lg-5 ilan_karti_teklif_dis">
                                 <?php if($ihale_oku['ihale_turu']==1){ ?>
                                 <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ilan_karti_teklif_baslik">
                                    En Yüksek
                                 </div>
                                 <div id="en_yuksek_<?=$ihale_oku["id"] ?>" class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ilan_karti_teklif_fiyat">
                                    <?php
                                       $bitis_tarihi=$ihale_oku["ihale_tarihi"]." ".$ihale_oku["ihale_saati"];
                                       $ihale_son_str = strtotime($bitis_tarihi);
                                       $suan_str = strtotime(date("Y-m-d H:i:s"));
                                       $sonuc=($ihale_son_str-$suan_str)/60;
                                       if($sonuc<30){ 
                                       	if($kullanici_grubu==1){ ?>
                                    <?= money($ihale_oku['son_teklif']) ?> ₺ 
                                    <?php } else { ?>
                                    <i style="color:#000" class="fas fa-lock"></i>
                                    <?php } ?>
                                    <?php } else { 
                                       if($kullanici_grubu==1 || $kullanici_grubu==4 || $kullanici_grubu==0){ ?>
                                    <?= money($ihale_oku['son_teklif']) ?> ₺ 
                                    <?php } else { ?>
                                    <i style="color:#000" class="fas fa-lock"></i>
                                    <?php } ?>
                                    <?php }
                                       ?>
                                 </div>
                                 <?php }else{ ?>
                                 <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ilan_karti_teklif_baslik">
                                    Taban Fiyat
                                 </div>
                                 <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ilan_karti_teklif_fiyat">
                                    <?= money($ihale_oku['acilis_fiyati']) ?> ₺
                                 </div>
                                 <?php } ?>
                                 <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ilan_karti_teklif_btnlar">
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="clearfix"></div>
                  <?php 
                     if(($row_number % $gosterim_sayi) == 0) {
                     	echo $advertisment_block;  
                     	$sayac++;
                     }
                     }else{
                     $anlik = date("Y-m-d H:i:s");
                     $getID = $ihale_oku['id'];
                     $getImage = mysql_query("SELECT * FROM ilan_resimler WHERE ilan_id = '".$getID."' ORDER BY RAND() LIMIT 1");
                     $setImage = mysql_fetch_assoc($getImage);
                     $image = $setImage['resim'];
                     $getMarka = mysql_query("SELECT * FROM marka WHERE markaID = '".$ihale_oku['marka']."' LIMIT 1");
                     $getSehir = mysql_query("SELECT * FROM sehir WHERE sehirID = '".$ihale_oku['sehir']."' LIMIT 1");
                     $setMarka = mysql_fetch_assoc($getMarka) ;    
                     if($image==""){
                       $image="default.png";
                     } ?> 
                  <input type="hidden" id="ihale_say" value="<?= $ihale_say ?>">	     
                  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ilan_karti_dis" style="background-color:gray !important; opacity: 0.5;">
                     <div style="color:#000;background-color:gray !important; opacity: 0.5;" class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ilan_karti_baslik">
                        <text style="font-size: 15px;font-weight:bold;color: #fff;width:100% !important;"><i class="fas fa-car" aria-hidden="true"></i> <?= $ihale_oku['model_yili']." ".$setMarka['marka_adi']." " . $ihale_oku['model']  ?><i style="" class="fas fa-lock"></i></text>
                        <?php  array_push($sira_array,$sira); ?>
                        <span  id="sayac<?=$sira?>"> </span>
                        <input type="hidden" id="ihale_sayac<?=$sira?>" value="<?= $ihale_oku['ihale_tarihi'].' '. $ihale_oku['ihale_saati'] ?>">
                        <input type="hidden" id="id_<?=$sira?>" value="<?= $ihale_oku['id'] ?>">
                        <input type="hidden" id="sure_uzatilma_durum_<?=$sira?>" value="<?= $ihale_oku['sistem_sure_uzatma_durumu'] ?>">
                        <input type="hidden" id="belirlenen_<?=$sira?>" value="<?= $sigorta_oku2['bu_sure_altinda_teklif'] ?>">
                        <input type="hidden" id="gosterilme_<?=$sira ?>" value="<?=gosterilme_durumu($ihale_oku['id']) ?>">
                     </div>
                     <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ilan_karti_icerik_dis">
                        <div class="ilan_karti_gorsel_dis" style="background:#fafafa!important;">
                           <div class="image_lock_box">

                           </div>
                           <div style="color:#000" class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ilan_karti_kod">
                           <?php 
                              if(strlen($ihale_oku['arac_kodu']) > 15){
                                 $arac_kodu_yeni = substr($ihale_oku['arac_kodu'],0,15)."...";
                              }else{
                                 $arac_kodu_yeni = $ihale_oku['arac_kodu'];
                              }
                           ?>
                              #<?= $arac_kodu_yeni ?>
                           </div>
                        </div>
                        <div class="ilan_karti_gorsel_icerik">
                           <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ilan_karti_taglar_dis">
                              <?php if($ihale_oku['yakit_tipi']!=""){ ?>
                              <div class="ilan_karti_tag">
                                 <img src="images/car_list_icons/1.png" />
                                 <?= $ihale_oku['yakit_tipi'] ?>
                              </div>
                              <?php } if($ihale_oku['vites_tipi']!=""){ ?>
                              <div class="ilan_karti_tag">
                              <img src="images/car_list_icons/2.png" />
                                 <?= $ihale_oku['vites_tipi'] ?>
                              </div>
                              <?php }if($ihale_oku['kilometre']!=""){ ?>
                              <div class="ilan_karti_tag">
                                 <img src="images/car_list_icons/7.png" />
                                 <?= money($ihale_oku['kilometre']) ?> km
                              </div>
                              <?php } if($ihale_oku['sehir']!=""){ ?>
                              <div class="ilan_karti_tag">
                                 <img src="images/car_list_icons/3.png" />
                                 <?= $ihale_oku['sehir'] ?>
                              </div>
                              <?php }if($ihale_oku['ihale_turu']!=""){ ?>
                              <div class="ilan_karti_tag">
                                 <?php if($ihale_oku['ihale_turu']==1){$ihale_turu = "Açık  İhale";}else{$ihale_turu="Kapalı İhale";} ?>
                                 <img src="images/car_list_icons/4.png" />
                                 <?= $ihale_turu ?>
                              </div>
                              <?php } if($ihale_oku['profil']!=""){ ?>
                              <div class="ilan_karti_tag <?= $blink ?>">
                                 <img src="images/car_list_icons/5.png" />
                                 <?= $ihale_oku['profil'] ?>
                              </div>
                              <?php }if($ihale_oku['ihale_tarihi']!=""){  ?>
                              <div class="ilan_karti_tag ">
                              <img src="images/car_list_icons/6.png" />
                               <span class="kapanis_zamani<?=$sira ?>" ><?= date("d-m-Y H:i:s",strtotime($ihale_oku['ihale_tarihi']." ".$ihale_oku['ihale_saati'])) ?></span>
                              </div>
                              <?php } ?>
                           </div>
                           <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ilan_karti_alt_alan">
                              <div class="col-xs-12 col-sm-12 col-md-7 col-lg-7 ilan_karti_notlar_dis">
                                 <!-- <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ilan_karti_not_baslik">
                                    Sigorta Onay Notu
                                    </div> -->
                                 <div data-toggle="modal" data-target="#notmodal_<?=$ihale_oku['id'] ?>" class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ilan_karti_not_alan">
                                    <?php $onay_cek = mysql_query("select * from sigorta_ozellikleri where id = '".$ihale_oku['sigorta']."'"); 
                                       $onay_oku = mysql_fetch_assoc($onay_cek);
                                       // $onay = $onay_oku['sigorta_aciklamasi'];
                                       $onay = $onay_oku['uyari_notu'];
                                       ?>
                                    <b><?= $ihale_oku['uyari_notu']."<br>".$onay ?></b>
                                 </div>                                 
                                 <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ilan_karti_begeni_dis">
                                    <form method="POST" action="" name="form" >
                                       <div class="btn-group" role="group">
                                          <div onclick="bildirim_ac(<?= $ihale_oku['id'] ?>);">
                                             <button data-toggle="tooltip" data-placement="top" title="<?=$bildirim_title ?>" type="button"  id="bildirim_ac_<?= $ihale_oku['id'] ?>" name="bildirim_ac" class="btn btn-light mr-2 btn-sm">
                                             <i style="color: <?= $bidlirim_color ?>;font-size: 20px;" class="icon-notifications"></i>
                                             <input type="hidden" name="bildirimlenecek" value="<?= $ihale_oku['id'] ?>">
                                             </button>
                                          </div>
                                          <div onclick="favla(<?= $ihale_oku['id'] ?>);">
                                             <button data-toggle="tooltip" data-placement="top" title="<?=$fav_title ?>" type="button"  id="favla_<?= $ihale_oku['id'] ?>" name="favla" class="btn btn-light btn-sm">
                                             <i style="color:  <?= $fav_color ?>;font-size: 20px;" class="fas fa-star"></i>
                                             <input type="hidden" name="favlanacak" value="<?= $ihale_oku['id'] ?>">
                                             </button>
                                          </div>
                                       </div>
                                    </form>
                                 </div>
                              </div>
                              <div class="col-xs-12 col-sm-12 col-md-5 col-lg-5 ilan_karti_teklif_dis">
                                 <?php if($ihale_oku['ihale_turu']==1){ ?>
                                 <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ilan_karti_teklif_baslik">
                                    En Yüksek 
                                 </div>
                                 <?php }else{ ?>
                                 <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ilan_karti_teklif_baslik">
                                    Taban Fiyat
                                 </div>
                                 <?php } ?>
                                 <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ilan_karti_teklif_fiyat">
                                    <i style="color:#000" class="fas fa-lock"></i>
                                 </div>
                                 <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ilan_karti_teklif_btnlar">
                                    <div class="ilan_karti_teklif_btn" style="background-color: #000; " >
                                       <a style="text-decoration: none; color:#ffffff;" href=""><i style="color:#fff" class="fas fa-lock"></i></a> 
                                    </div>
                                    <div class="ilan_karti_teklif_btn" style="background-color: #424242; ">
                                       <a style="text-decoration: none; color:#ffffff;" href=""><i style="color:#000" class="fas fa-lock"></i></a>                                
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="modal fade" id="notmodal_<?=$ihale_oku['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="notmodal_<?=$ihale_oku['id'] ?>" aria-hidden="true">
                     <div class="modal-dialog" role="document">
                        <div class="modal-content">
                           <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                              </button>
                           </div>
                           <div class="modal-body" style="font-weight: 600 !important;">
                              <?= $ihale_oku['uyari_notu']."<br>".$onay ?>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="clearfix"></div>
                  <?php if(($row_number % $gosterim_sayi) == 0) {
                     echo $advertisment_block;  
                     $sayac++;
                     }; 
                     }
                     }else if($secilen_yetki_id==3) { 
                     $anlik = date("Y-m-d H:i:s");
                     $getID = $ihale_oku['id'];
                     $getImage = mysql_query("SELECT * FROM ilan_resimler WHERE ilan_id = '".$getID."' ORDER BY RAND() LIMIT 1");
                     $setImage = mysql_fetch_assoc($getImage);
                     $image = $setImage['resim'];
                     $getMarka = mysql_query("SELECT * FROM marka WHERE markaID = '".$ihale_oku['marka']."' LIMIT 1");
                     $getSehir = mysql_query("SELECT * FROM sehir WHERE sehirID = '".$ihale_oku['sehir']."' LIMIT 1");
                     $setMarka = mysql_fetch_assoc($getMarka) ;  
                     if($image==""){
                      $image="default.png";
                     } ?> 
                  <input type="hidden" id="ilanID" value="<?= $ilani_oku['id'] ?>">
                  <input type="hidden" id="ihale_say" value="<?=$ihale_say ?>">	     
                  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ilan_karti_dis">
                     <?php if($ihale_oku['ihale_turu']==1){$background_color = "#00a2e8";}else{$background_color="orange";} array_push($sira_array,$sira); ?>
                     <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ilan_karti_baslik" style="background-color:<?= $background_color ?>" >
                     <?php 
                        if(strlen($ihale_oku['model_yili']." ".$setMarka['marka_adi']." " . $ihale_oku['model']." " . $ihale_oku['tip']) > 135){
                           $ilan_karti_baslik_bas = substr($ihale_oku['model_yili']." ".$setMarka['marka_adi']." " . $ihale_oku['model']." " . $ihale_oku['tip'],0,135)."...";
                        }else{
                           $ilan_karti_baslik_bas = $ihale_oku['model_yili']." ".$setMarka['marka_adi']." " . $ihale_oku['model']." " . $ihale_oku['tip'];
                        } 
                     ?>
                        <text style="font-size: 15px;font-weight:bold;color: #fff;"><i class="fas fa-car" aria-hidden="true"></i> <?= $ilan_karti_baslik_bas  ?></text>
                        <span  id="sayac<?=$sira?>"> </span>
                        <input type="hidden" id="ihale_sayac<?=$sira?>" value="<?= $ihale_oku['ihale_tarihi'].' '. $ihale_oku['ihale_saati'] ?>">
                        <input type="hidden" id="id_<?=$sira?>" value="<?= $ihale_oku['id'] ?>">
                        <input type="hidden" id="sure_uzatilma_durum_<?=$sira?>" value="<?= $ihale_oku['sistem_sure_uzatma_durumu'] ?>">
                        <input type="hidden" id="belirlenen_<?=$sira?>" value="<?= $sigorta_oku2['bu_sure_altinda_teklif'] ?>">
                        <input type="hidden" id="gosterilme_<?=$sira ?>" value="<?=gosterilme_durumu($ihale_oku['id']) ?>">
                     </div>
                     <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ilan_karti_icerik_dis">
                        <div class="ilan_karti_gorsel_dis" style="background-image:url('images/<?= $image ?>');">
                           <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ilan_karti_kod" >
                           <?php 
                              if(strlen($ihale_oku['arac_kodu']) > 15){
                                 $arac_kodu_yeni = substr($ihale_oku['arac_kodu'],0,15)."...";
                              }else{
                                 $arac_kodu_yeni = $ihale_oku['arac_kodu'];
                              }
                           ?>
                              #<?= $arac_kodu_yeni ?>
                           </div>
                        </div>
                        <div class="ilan_karti_gorsel_icerik">
                           <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ilan_karti_taglar_dis">
                              <?php if($ihale_oku['yakit_tipi']!=""){ ?>
                              <div class="ilan_karti_tag">
                                 <img src="images/car_list_icons/1.png" />
                                 <?= $ihale_oku['yakit_tipi'] ?>
                              </div>
                              <?php } if($ihale_oku['vites_tipi']!=""){ ?>
                              <div class="ilan_karti_tag">
                                 <img src="images/car_list_icons/2.png" />
                                 <?= $ihale_oku['vites_tipi'] ?>
                              </div>
                              <?php }if($ihale_oku['kilometre']!=""){ ?>
                              <div class="ilan_karti_tag">
                                 <img src="images/car_list_icons/7.png" />
                                 <?= money($ihale_oku['kilometre']) ?> km
                              </div>
                              <?php } if($ihale_oku['sehir']!=""){ ?>
                              <div class="ilan_karti_tag">
                                 <img src="images/car_list_icons/3.png" />
                                 <?= $ihale_oku['sehir'] ?>
                              </div>
                              <?php }if($ihale_oku['ihale_turu']!=""){ ?>
                              <div class="ilan_karti_tag">
                                 <img src="images/car_list_icons/4.png" />
                                 <?php if($ihale_oku['ihale_turu']==1){$ihale_turu = "Açık  İhale";}else{$ihale_turu="Kapalı İhale";} ?>
                                 <?= $ihale_turu ?>
                              </div>
                              <?php } if($ihale_oku['profil']!=""){ ?>
                              <div class="ilan_karti_tag <?= $blink ?>">
                                 <img src="images/car_list_icons/5.png" />
                                 <?= $ihale_oku['profil'] ?>
                              </div>
                              <?php }if($ihale_oku['ihale_tarihi']!=""){  ?>
                              <div class="ilan_karti_tag ">
                                 <img src="images/car_list_icons/6.png" />
                                 <span class="kapanis_zamani<?=$sira ?>" ><?= date("d-m-Y H:i:s",strtotime($ihale_oku['ihale_tarihi']." ".$ihale_oku['ihale_saati'])) ?></span>
                              </div>
                              <?php } ?>
                           </div>
                           <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ilan_karti_alt_alan">
                              <div class="col-xs-12 col-sm-12 col-md-7 col-lg-7 ilan_karti_notlar_dis">
                                 <!-- <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ilan_karti_not_baslik">
                                    Sigorta Onay Notu
                                    </div> -->
                                 <div data-toggle="modal" data-target="#notmodal_<?=$ihale_oku['id'] ?>" class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ilan_karti_not_alan">
                                    <?php $onay_cek = mysql_query("select * from sigorta_ozellikleri where id = '".$ihale_oku['sigorta']."'"); 
                                       $onay_oku = mysql_fetch_assoc($onay_cek);
                                       // $onay = $onay_oku['sigorta_aciklamasi'];
                                       $onay = $onay_oku['uyari_notu'];
                                       ?>
                                    <b><?= $ihale_oku['uyari_notu']."<br>".$onay ?></b>
                                 </div>
                                 <div class="modal fade" id="notmodal_<?=$ihale_oku['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="notmodal_<?=$ihale_oku['id'] ?>" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                       <div class="modal-content">
                                          <div class="modal-header">
                                             <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                             <span aria-hidden="true">&times;</span>
                                             </button>
                                          </div>
                                          <div class="modal-body" style="font-weight: 600 !important;">
                                             <?= $ihale_oku['uyari_notu']."<br>".$onay ?>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                                 <?php
                                    if($uye_token!=""){
                                    	$user_getir=mysql_fetch_object(mysql_query("select * from user where user_token='".$uye_token."' or kurumsal_user_token='".$uye_token."'"));
                                    	$id_u=$user_getir->id;
                                    	$en_yksk="";
                                    	$sql_teklif=mysql_query("select * from teklifler where ilan_id='".$ihale_oku['id']."' and uye_id='".$id_u."' and durum=1 order by teklif_zamani desc limit 1");
                                    	$teklif_say=0;
                                    	while($row_teklif=mysql_fetch_object($sql_teklif)){
                                    		if($row_teklif->teklif == $ihale_oku['son_teklif'] ){
                                    			$en_yksk ='
                                    				<b style="color: green; text-align:center;float:right;display: none;">En yüksek teklif sizindir.</b><br/>
                                    				<b style="color: red; text-align:center;float:right">'.money($row_teklif->teklif).' ₺ teklif verdiniz.</b>
                                    			';
                                    			//$carda_bas = ' <i style="color: green; text-align:center;">En yüksek teklif sizindir.</i>';
                                    		}else if($row_teklif->teklif == ""){
                                    			$en_yksk =' 
                                    				<i style="color: red; text-align:center;">Henüz teklif vermediniz.</i>
                                    			';
                                    		}else if($row_teklif->teklif != $ihale_oku['son_teklif'] && $row_teklif->teklif != "" && $teklif_say==0 ){
                                    			$en_yksk =' 
                                    				<i style="color: red; text-align:center;">'.money($row_teklif->teklif).' ₺ teklif verdiniz.</i>
                                    			';
                                    		}
                                    		$teklif_say++;
                                    	}
                                    	$en_yksk_kapali="";
                                    	$sql_teklif=mysql_query("select * from teklifler where ilan_id='".$ihale_oku['id']."' and uye_id='".$id_u."' and durum=1 order by teklif_zamani desc limit 1");
                                    	$ilan_kontrol=mysql_query("select * from ilanlar where id='".$ihale_oku['id']."' ");
                                    	$ilan_kontrol_cek=mysql_fetch_object($ilan_kontrol);
                                    	$kapali_durum=$ilan_kontrol_cek->ihale_turu;
                                    	$teklif_say_kapali=0;
                                    	while($row_teklif=mysql_fetch_object($sql_teklif)){
                                    		if($kapali_durum=="2"){
                                    			if($row_teklif->teklif == ""){
                                    			$en_yksk_kapali =' 
                                    						<i style="color: red; text-align:center;">Henüz teklif vermediniz.</i>
                                    					  ';
                                    			}else if( $row_teklif->teklif != "" && $teklif_say_kapali==0 ){
                                    				$en_yksk_kapali =' 
                                    							<i style="color: red; text-align:center;display: none;">'.money($row_teklif->teklif).' ₺ teklif verdiniz.</i>
                                    						  ';
                                    			}
                                    			$teklif_say_kapali++;
                                    		}
                                    	}
                                    }else{
                                    	$en_yksk='';
                                    	$en_yksk_kapali='';
                                    }
                                    ?>
                                 <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 ilan_karti_begeni_dis">
                                    <form method="POST" action="" >
                                       <div class="btn-group" role="group">
                                          <div onclick="bildirim_ac(<?= $ihale_oku['id'] ?>);">
                                             <button data-toggle="tooltip" data-placement="top" title="<?=$bildirim_title ?>" type="button"  id="bildirim_ac_<?= $ihale_oku['id'] ?>" name="bildirim_ac" class="btn btn-light mr-2 btn-sm">
                                             <i style="color: <?= $bidlirim_color ?>;font-size: 20px;" class="icon-notifications"></i>
                                             <input type="hidden" name="bildirimlenecek" value="<?= $ihale_oku['id'] ?>">
                                             </button>
                                          </div>
                                          <div onclick="favla(<?= $ihale_oku['id'] ?>);">
                                             <button data-toggle="tooltip" data-placement="top" title="<?=$fav_title ?>" type="button"  id="favla_<?= $ihale_oku['id'] ?>" name="favla" class="btn btn-light btn-sm">
                                             <i style="color: <?= $fav_color ?>;font-size: 20px;" class="fas fa-star"></i>
                                             <input type="hidden" name="favlanacak" value="<?= $ihale_oku['id'] ?>">
                                             </button>
                                          </div>
                                       </div>
                                    </form>
                                 </div>
                                 <div id="uye_bilgi_<?=$ihale_oku['id'] ?>" class="col-xs-8 col-sm-8 col-md-8 col-lg-8 ilan_karti_begeni_dis">
                                    <?php if($ihale_oku['ihale_turu']==1) {
                                       echo $en_yksk;
                                       }else{ 
                                       echo $en_yksk_kapali; 
                                       } ?>
                                 </div>
                              </div>
                              <div class="col-xs-12 col-sm-12 col-md-5 col-lg-5 ilan_karti_teklif_dis">
                                 <?php
                                    if($ihale_oku['ihale_turu']==1){ ?>
                                 <div  class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ilan_karti_teklif_baslik">
                                    En Yüksek
                                 </div>
                                 <div id="en_yuksek_<?=$ihale_oku["id"] ?>" class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ilan_karti_teklif_fiyat">
                                    <?php
                                       $bitis_tarihi=$ihale_oku["ihale_tarihi"]." ".$ihale_oku["ihale_saati"];
                                       $ihale_son_str = strtotime($bitis_tarihi);
                                       $suan_str = strtotime(date("Y-m-d H:i:s"));
                                       $sonuc=($ihale_son_str-$suan_str)/60;
                                       if($sonuc<30){ 
                                       	if($kullanici_grubu==1){
                                          $teklif_ver_btn = '<a onclick="kontrol('.$ihale_oku['id'].');locale_kaydet('.$ihale_oku ['id'].'); " data-keyboard="false" data-backdrop="static" id="TeklifVer'.$ihale_oku['id'].'" data-toggle="modal" data-target="#teklifVer'.$ihale_oku['id'].'" style="text-decoration: none; color:#ffffff;" >TEKLİF VER</a>';
                                     ?>
                                    <?= money($ihale_oku['son_teklif']) ?> ₺
                                    <?php } else {
                                       $teklif_ver_btn = '<a onclick="alert(\'Teklif verme yetkiniz yok\')" data-keyboard="false" data-backdrop="static" style="text-decoration: none; color:#ffffff;" >TEKLİF VER</a>';
                                    ?>
                                    <i style="color:#000" class="fas fa-lock"></i>
                                    <?php } ?>
                                    <?php } else { 
                                       if($kullanici_grubu==1 || $kullanici_grubu==4 || $kullanici_grubu==0){ 
                                          $teklif_ver_btn = '<a onclick="kontrol('.$ihale_oku['id'].');locale_kaydet('.$ihale_oku ['id'].'); " data-keyboard="false" data-backdrop="static" id="TeklifVer'.$ihale_oku['id'].'" data-toggle="modal" data-target="#teklifVer'.$ihale_oku['id'].'" style="text-decoration: none; color:#ffffff;" >TEKLİF VER</a>';
                                    ?>
                                    <?= money($ihale_oku['son_teklif']) ?> ₺
                                    <?php } else { 
                                      $teklif_ver_btn = '<a onclick="alert(\'Teklif verme yetkiniz yok\')" data-keyboard="false" data-backdrop="static" style="text-decoration: none; color:#ffffff;" >TEKLİF VER</a>';   
                                    ?>
                                    <i style="color:#000" class="fas fa-lock"></i>
                                    <?php } ?>
                                    <?php }
                                       ?>
                                 </div>
                                 <?php }else{ ?>
                                    <?php
                                       $bitis_tarihi=$ihale_oku["ihale_tarihi"]." ".$ihale_oku["ihale_saati"];
                                       $ihale_son_str = strtotime($bitis_tarihi);
                                       $suan_str = strtotime(date("Y-m-d H:i:s"));
                                       $sonuc=($ihale_son_str-$suan_str)/60;
                                       if($sonuc<30){ 
                                       	if($kullanici_grubu==1){
                                          $teklif_ver_btn = '<a onclick="kontrol('.$ihale_oku['id'].');locale_kaydet('.$ihale_oku ['id'].'); " data-keyboard="false" data-backdrop="static" id="TeklifVer'.$ihale_oku['id'].'" data-toggle="modal" data-target="#teklifVer'.$ihale_oku['id'].'" style="text-decoration: none; color:#ffffff;" >TEKLİF VER</a>';
                                          } else {
                                             $teklif_ver_btn = '<a onclick="alert(\'Teklif verme yetkiniz yok\')" data-keyboard="false" data-backdrop="static" style="text-decoration: none; color:#ffffff;" >TEKLİF VER</a>';
                                          }
                                       }else{
                                          if($kullanici_grubu==1 || $kullanici_grubu==4 || $kullanici_grubu==0){ 
                                             $teklif_ver_btn = '<a onclick="kontrol('.$ihale_oku['id'].');locale_kaydet('.$ihale_oku ['id'].'); " data-keyboard="false" data-backdrop="static" id="TeklifVer'.$ihale_oku['id'].'" data-toggle="modal" data-target="#teklifVer'.$ihale_oku['id'].'" style="text-decoration: none; color:#ffffff;" >TEKLİF VER</a>';
                                          }else{
                                             $teklif_ver_btn = '<a onclick="alert(\'Teklif verme yetkiniz yok\')" data-keyboard="false" data-backdrop="static" style="text-decoration: none; color:#ffffff;" >TEKLİF VER</a>';   
                                          }
                                       }
                                    ?>
                                 <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ilan_karti_teklif_baslik">
                                    Taban Fiyat 
                                 </div>
                                 <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ilan_karti_teklif_fiyat">
                                    <?= money($ihale_oku['acilis_fiyati']) ?> ₺
                                 </div>
                                 <?php } ?>
                                 <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ilan_karti_teklif_btnlar">
                                    <div class="ilan_karti_teklif_btn" style="background-color: <?= $background_color ?>; cursor:pointer;">
                                    <?php
                                    if($uye_token == ""){ ?>
                                    <a onclick="alert('Teklif verebilmek için üye girişi yapmanız gerekmektedir')" data-keyboard="false" data-backdrop="static" style="text-decoration: none; color:#ffffff;" >TEKLİF VER</a>                                
                                    <?php }else{ ?>
                                       <?= $teklif_ver_btn ?>
                                    <?php }
                                    ?>                                      
                                    </div>
                                    <div class="ilan_karti_teklif_btn" style="background-color: #424242;" >
                                       <a onclick="ihale_arttir(<?=$ihale_oku['id']?>)"  style="text-decoration: none; color:#ffffff;" href="arac_detay.php?id=<?= $ihale_oku['id'] ?>&q=ihale" target="_blank">İNCELE</a> 
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="clearfix"></div>
                  <?php 
                     if(($row_number % $gosterim_sayi) == 0) {
                     	echo $advertisment_block;  
                     	$sayac++;
                     }
                     $ihale_tur_sorgu=mysql_query("select * from ilanlar where id='".$ihale_oku['id']."'  ");
                     $tur_cek=mysql_fetch_object($ihale_tur_sorgu);
                     $komisyon_cek = mysql_query("SELECT * FROM ilan_komisyon WHERE ilan_id = '".$ihale_oku['id']."'");
                     $komisyon_oku = mysql_fetch_assoc($komisyon_cek);
                     $komisyon = $komisyon_oku['toplam'];
                     $sorgu = mysql_query("SELECT * FROM komisyon_oranlari WHERE sigorta_id = '".$ihale_oku['sigorta']."'");
                     $sorgu_say = mysql_num_rows($sorgu);
                     $arttir = 1;
                     $oran = array();
                     $standart_net = array();
                     $luks_net = array();
                     $standart_onbinde = array();
                     $luks_onbinde = array();
                     while($sonuc = mysql_fetch_array($sorgu)){
                     	array_push($oran, $sonuc['komisyon_orani']);
                     	array_push($standart_net, $sonuc['net']);
                     	array_push($luks_net, $sonuc['lux_net']);
                     	array_push($standart_onbinde, $sonuc['onbinde']);
                     	array_push($luks_onbinde, $sonuc['lux_onbinde']);
                     ?>
                  <input type="hidden" id="standart_net<?= $ihale_oku['id'] ?>" value="<?= $standart_net ?>">
                  <input type="hidden" id="luks_net<?= $ihale_oku['id'] ?>" value="<?= $luks_net ?>">
                  <input type="hidden" id="standart_onbinde<?= $ihale_oku['id'] ?>" value="<?= $standart_onbinde ?>">
                  <input type="hidden" id="luks_onbinde<?= $ihale_oku['id'] ?>" value="<?= $luks_onbinde ?>">
                  <input type="hidden" id="oran<?= $ihale_oku['id'] ?>" value="<?= $oran ?>">
                  <?php } ?>
                  <input type="hidden" id="hesaplama<?= $ihale_oku['id'] ?>" value="<?= $ihale_oku['hesaplama'] ?>">
                  <input type="hidden" id="sorgu_sayi<?= $ihale_oku['id'] ?>" value="<?= $sorgu_say ?>">
                  <?php 
                     $sgrt=mysql_fetch_object(mysql_query("select * from sigorta_ozellikleri where id='".$ihale_oku['sigorta']."' "));
                     $min=$sgrt->minumum_artis; 
                     $h1=$sgrt->hizli_teklif_1; 
                     $h2=$sgrt->hizli_teklif_2; 
                     $h3=$sgrt->hizli_teklif_3; 
                     $h4=$sgrt->hizli_teklif_4;   
                     $s_mesaj=$sgrt->teklif_iletme_mesaji;   
                     $tur=$tur_cek->ihale_turu;
                     $tbn_fiyat=$tur_cek->acilis_fiyati; 
                     if($tur=="1"){ ?>
                  <input type="hidden" id="ihale_tur" value="<?=$tur ?>">
                  <div class="modal fade" id="teklifVer<?=$ihale_oku['id']?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                     <div class="modal-dialog">
                        <div class="modal-content">
                           <div class="container">
                              <form method="post">
                                 <div class="modal-header">    
                                    <button style="margin-top:1%; font-size:17px; font-weight:600;" type="button" class="btn btn-dark  btn-block"><?=$ihale_oku['model_yili']." ".$setMarka['marka_adi']." ". $ihale_oku['model'] ?></button>    
                                    <button type="button" onclick="secimleri_sil(<?=$ihale_oku['id']?>)" id="modal_kapat<?=$ihale_oku['id']?> " class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                 </div>
                                 <div class="modal-body">
                                    <div class="row">
                                       <div class="col">
                                          <p style="text-align:left; font-size:15px; font-weight:600;">PD HİZMET BEDELİ</p>
                                          <b style="color:blue;display:none"></b>  
                                          <button type="button" class="btn btn-dark btn-block" style="font-size:16px; font-weight:600;" >
                                          <span id="hizmet_bedel<?=$ihale_oku['id']?>"></span> 
                                          </button>																
                                       </div>
                                       <div class="col">
                                          <p style="text-align:center; font-size:15px; font-weight:600;">VERİLECEK TEKLİF</p>
                                          <button type="button" class="btn btn-dark btn-block" style="font-size:16px; font-weight:600; background-color:rgb(247, 148, 29);border-color:transparent !important;" id="GelenTeklif<?=$ihale_oku['id']?>"> 
                                          </button>
                                       </div>
                                    </div>
                                    <div class="row mt-4">
                                       <div class="col">
                                          <button style="background-color:#00a2e8; color:#fff; font-weight:600;" type="button" class="btn btn-block mavi"  onclick="buttonClick(<?=$ihale_oku['id'] ?>);" id="arti1<?=$ihale_oku['id'] ?>" value="<?=$h1 ?>">
                                          +<?= money($h1)?>₺
                                          </button>
                                       </div>
                                       <div class="col">
                                          <button style="background-color:#00a2e8; color:#fff; font-weight:600;" type="button" class="btn btn-block mavi"  onclick="buttonClick2(<?=$ihale_oku['id'] ?>);" id="arti2<?=$ihale_oku['id'] ?>" value="<?=$h2 ?>">
                                          +<?= money($h2)?>₺
                                          </button>
                                       </div>
                                       <div class="col">
                                          <button style="background-color:#00a2e8; color:#fff; font-weight:600;" type="button" class="btn btn-block mavi"  onclick="clickButton(<?=$ihale_oku['id'] ?>);" id="arti3<?=$ihale_oku['id'] ?>" value="<?=$h3 ?>">
                                          +<?= money($h3)?>₺
                                          </button>
                                       </div>
                                       <div class="col">
                                          <button style="background-color:#00a2e8; color:#fff; font-weight:600;" type="button" class="btn btn-block mavi"  onclick="clickButton2(<?=$ihale_oku['id'] ?>);" id="arti4<?=$ihale_oku['id'] ?>" value="<?=$h4 ?>">
                                          +<?= money($h4)?>₺
                                          </button>
                                       </div>
                                    </div>
                                    <div class="row mt-4">
                                       <div class="col" style="text-align:right; padding:10px 0px;">
                                          Teklifinizi Yazınız
                                       </div>
                                       <div class="col">
                                          <?php if($ihale_oku['son_teklif']==0){ ?>
                                          <input style="height:40px;" placeholder="Teklifinizi buraya yazınız." type="number"  value=""  step="<?=$min_arti ?>" class="form-control" id="verilen_teklif<?=$ihale_oku['id']?>" onchange="teklif_kontrol(<?=$ihale_oku['id']?>);" onkeyup="teklif_kontrol(<?=$ihale_oku['id']?>);">
                                          <input type="hidden" value="<?= $ihale_oku['acilis_fiyati'] ?>" id="verilen_teklif_hidden<?=$ihale_oku['id']?>" >
                                          <?php } else {  ?>
                                          <input style="height:40px;" placeholder="Teklifinizi buraya yazınız." type="number"  value=""  step="<?=$min_arti ?>" class="form-control" id="verilen_teklif<?=$ihale_oku['id']?>" onchange="teklif_kontrol(<?=$ihale_oku['id']?>);" onkeyup="teklif_kontrol(<?=$ihale_oku['id']?>);">
                                          <input type="hidden" value="<?= $ihale_oku['son_teklif'] ?>" id="verilen_teklif_hidden<?=$ihale_oku['id']?>" >
                                          <?php } ?>
                                          <label id="teklif_kontrol<?=$ihale_oku['id']?>"></label> 
                                       </div>
                                    </div>
                                    <div class="row mt-2">
                                       <div class="col">
                                          <div class="col">
                                             <textarea style="width:calc(100% + 30px); margin:15px -15px; min-height:250px;" id="deneme_alan<?=$ihale_oku['id']?>" rows="3" disabled placeholder="<?=$s_mesaj ?>"></textarea>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="row mt-2">
                                       <div class="col">
                                          <input type="checkbox" id="sozlesme_kontrol<?=$ihale_oku['id']?>" value="1" required>  
                                          <span onclick="popup('<?=$s_mesaj?>')">Yukarıdaki Koşulları Okudum ve Kabul Ediyorum.</span>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="row mt-2 mb-2">
                                    <div class="col">
                                       <button type="button" onclick="secimleri_sil(<?=$ihale_oku['id']?>)" class="btn btn-danger btn-block" id="acik_modal_kapat2<?=$ihale_oku["id"] ?>" data-dismiss="modal">Vazgeç</button>
                                    </div>
                                    <div class="col"><button type="button" class="btn btn-success btn-block" id="TeklifVer<?=$ihale_oku['id']?>"  onclick="denem(<?=$ihale_oku['id']?>);"><i class="fas fa-lira-sign"> Teklif Ver</i></button></div>
                                 </div>
                              </form>
                           </div>
                        </div>
                     </div>
                  </div>
                  <?php } else if($tur=="2") { ?>
                  <input type="hidden" id="ihale_tur" value="<?=$tur ?>"/>

				  <div class="modal fade" id="teklifVer<?=$ihale_oku['id']?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
									<div class="modal-dialog">
										<div class="modal-content">
											<div class="container">
												<form method="post">
													<div class="modal-header">    
														<button style="margin-top:1%; font-size:17px; font-weight:600;" type="button" class="btn btn-dark btn-block"><?=$ihale_oku['model_yili']." ".$setMarka['marka_adi']." ". $ihale_oku['model']?></button>    
														<button type="button" class="close" data-dismiss="modal" id="modal_kapat<?=$ihale_oku['id']?>"  aria-label="Close">
															<span aria-hidden="true">&times;</span>
														</button>
													</div>
													<div class="modal-body">
														<div class="row">
															<div class="col">
																<p style="text-align:left; font-size:15px; font-weight:600;">PD HİZMET BEDELİ</p>
																<b style="color:blue;display:none"></b>  
																<button type="button" class="btn btn-dark btn-block"style="font-size:16px; font-weight:600;">
																<span id="hizmet_bedel<?=$ihale_oku['id']?>"></span> 
																</button>																
															</div>
															<div class="col">
																<p style="text-align:center; font-size:15px; font-weight:600;">VERİLECEK TEKLİF</p>
																<button type="button" class="btn btn-dark btn-block" style="font-size:16px; font-weight:600; background-color:rgb(247, 148, 29);border-color:transparent !important;" id="GelenTeklif<?=$ihale_oku['id']?>"> 
																	
                                                </button>
                                             </div>            
                                          </div>
														<div class="row mt-4">
															<div class="col" style="text-align:right; padding:10px 0px;">
																Teklifinizi Yazınız
                                             </div>
															<div class="col">
																<input style="height40px;" type="number" placeholder="Teklifinizi buraya yazınız."  value=""  step="<?=$min_arti?>" class="form-control" id="verilen_teklif<?=$ihale_oku['id']?>" onchange="teklif_kontrol(<?=$ihale_oku['id']?>);" onkeyup="komisyon_kontrol(<?=$ihale_oku['id']?>);">					   
																<label id="teklif_kontrol<?=$ihale_oku['id']?>"></label> 
                                             </div>
                                          </div>
                                          <div class="row mt-2">
                                             <div class="col">
                                                <div class="col">
                                                <textarea style="width:calc(100% + 30px); margin:15px -15px; min-height:250px;" rows="3" disabled id="deneme_alan<?=$ihale_oku['id']?>"placeholder="<?=$s_mesaj ?>"></textarea>
                                                </div>
                                             </div>
                                          </div>
														<div class="row mt-2">
                                             <div class="col" onclick="popup('<?=$s_mesaj  ?>')">
                                                <input type="checkbox" id="sozlesme_kontrol<?=$ihale_oku['id']?>" value="1" required>  
                                                <span onclick="popup('<?=$s_mesaj  ?>')">Yukarıdaki Koşulları Okudum ve Kabul Ediyorum.</span>
                                             </div>
                                          </div>
                                       </div>
													<div class="row mt-2 mb-2">
                                          <div class="col">
                                             <button type="button" class="btn btn-danger btn-block" data-dismiss="modal" id="modal_kapat2<?=$ihale_oku["id"] ?>">
                                             Vazgeç
                                             </button>
                                          </div>
                                          <div class="col">
                                             <button type="button" class="btn btn-success btn-block" id="TeklifVer<?=$ihale_oku['id']?>" onclick="denem(<?=$ihale_oku['id']?>);">
                                             <i class="fas fa-lira-sign"> Teklif Ver</i>
                                             </button>
                                          </div>
                                       </div>
                                       </form>
							</div>
						</div>
					</div>
					</div>


                  
                  <?php 
                     } 	
                     } 
                     $sira++;  }
                     }  
                                    if(isset($_POST['favla'])){
                     $date = date('Y-m-d H:i:s');
                     $id = $_POST['favlanacak'];
                     if($_SESSION['u_token'] != "" && $_SESSION['k_token'] == ""){
                     $favi_cek = mysql_query("SELECT * FROM user WHERE user_token = '".$uye_token."'");
                     while($favi_oku = mysql_fetch_array($favi_cek)){
                     $uyeninID = $favi_oku['id'];
                     $favlamismi_cek = mysql_query("SELECT * FROM favoriler WHERE ilan_id = '".$id."' AND uye_id = '".$uyeninID."'");
                     $favlamismi_sayi = mysql_num_rows($favlamismi_cek);
                     if($favlamismi_sayi == 0){
                     	mysql_query("INSERT INTO `favoriler` (`id`, `ilan_id`, `dogrudan_satisli_id`, `uye_id`, `favlama_zamani`, `user_token`, `kurumsal_token`) VALUES 
                     		(NULL, '".$id."', '', '".$uyeninID."', '".$date."', '".$uye_token."', '');");
                     	echo'<script> alert("İlan Favorilerinize Eklendi")</script>';
                     	echo'<script> window.location.href = "ihaledeki_araclar.php";</script>';
                     }else{
                     	mysql_query("DELETE FROM favoriler WHERE ilan_id = '".$id."' AND uye_id = '".$uyeninID."'");
                     	echo'<script> alert("İlan Favorilerinizden Kaldırıldı")</script>';
                     	echo'<script> window.location.href = "ihaledeki_araclar.php";</script>';
                     }
                     }
                     }elseif($_SESSION['u_token'] == "" && $_SESSION['k_token'] != ""){
                     $favi_cek = mysql_query("SELECT * FROM user WHERE kurumsal_user_token = '".$uye_token."'");
                     while($favi_oku = mysql_fetch_array($favi_cek)){
                     $uyeninID = $favi_oku['id'];
                     $favlamismi_cek = mysql_query("SELECT * FROM favoriler WHERE ilan_id = '".$id."' AND uye_id = '".$uyeninID."'");
                     $favlamismi_sayi = mysql_num_rows($favlamismi_cek);
                     if($favlamismi_sayi==0){
                     	mysql_query("INSERT INTO `favoriler` (`id`, `ilan_id`, `dogrudan_satisli_id`, `uye_id`, `favlama_zamani`, `user_token`, `kurumsal_token`) VALUES 
                     		(NULL, '".$id."', '', '".$uyeninID."', '".$date."', '', '".$uye_token."');");
                     	echo'<script> alert("İlan Favorilerinize Eklendi")</script>';
                     	echo'<script> window.location.href = "ihaledeki_araclar.php";</script>';
                     }else{
                     	mysql_query("DELETE FROM favoriler WHERE ilan_id = '".$id."' AND uye_id = '".$uyeninID."'");
                     	echo'<script> alert("İlan Favorilerinizden Kaldırıldı")</script>';
                     	echo'<script> window.location.href = "ihaledeki_araclar.php";</script>';
                     }
                     }
                     }else if($_SESSION['u_token'] == "" && $_SESSION['k_token'] == ""){
                     echo'<script> alert("Giriş yapmalısınız")</script>';
                     //echo'<script> window.location.href = "ihaledeki_araclar.php";</script>';
                     }
                                    }
                                    if(isset($_POST['bildirim_ac'])){
                     $date = date('Y-m-d H:i:s');
                     $id = $_POST['bildirimlenecek'];
                     if($_SESSION['u_token'] != "" && $_SESSION['k_token'] == ""){
                     $bildirim_cek = mysql_query("SELECT * FROM user WHERE user_token = '".$uye_token."'");
                     while($bildirim_oku = mysql_fetch_array($bildirim_cek)){
                     $uyeninID = $bildirim_oku['id'];
                     $bildirim_varmi = mysql_query("SELECT * FROM bildirimler WHERE ilan_id = '".$id."' AND uye_id = '".$uyeninID."'");
                     $bildirimini_say = mysql_num_rows($bildirim_varmi);
                     if($bildirimini_say == 0){
                     	mysql_query("INSERT INTO `bildirimler` (`id`, `ilan_id`, `dogrudan_satisli_id`, `uye_id`, `bildirim_zamani`, `user_token`, `kurumsal_token`) VALUES 
                     	(NULL, '".$id."', '', '".$uyeninID."', '".$date."', '".$uye_token."', '');");
                     	echo'<script> alert("Bildirimler açıldı");</script>';
                     	echo'<script> window.location.href = "ihaledeki_araclar.php";</script>';
                     }else{
                     	mysql_query("DELETE FROM bildirimler WHERE ilan_id = '".$id."' AND uye_id = '".$uyeninID."'");
                     	echo'<script> alert("Bildirimler kapatıldı");</script>';
                     	echo'<script> window.location.href = "ihaledeki_araclar.php";</script>';
                     }
                     }
                     }elseif($_SESSION['u_token'] == "" && $_SESSION['k_token'] != ""){
                     $bildirim_cek = mysql_query("SELECT * FROM user WHERE kurumsal_user_token = '".$uye_token."'");
                     while($bildirim_oku = mysql_fetch_array($bildirim_cek)){
                     $uyeninID = $bildirim_oku['id'];
                     $bildirim_varmi = mysql_query("SELECT * FROM bildirimler WHERE ilan_id = '".$id."' AND uye_id = '".$uyeninID."'");
                     $bildirimini_say = mysql_num_rows($bildirim_varmi);
                     if($bildirimini_say == 0){
                     	mysql_query("INSERT INTO `bildirimler` (`id`, `ilan_id`, `dogrudan_satisli_id`, `uye_id`, `bildirim_zamani`, `user_token`, `kurumsal_token`) VALUES 
                     	(NULL, '".$id."', '', '".$uyeninID."', '".$date."', '".$uye_token."', '');");
                     	echo'<script> alert("Bildirimler açıldı")</script>';
                     	echo'<script> window.location.href = "ihaledeki_araclar.php";</script>';
                     }else{
                     	mysql_query("DELETE FROM bildirimler WHERE ilan_id = '".$id."' AND uye_id = '".$uyeninID."'");
                     	echo'<script> alert("Bildirimler kapatıldı")</script>';
                     	echo'<script> window.location.href = "ihaledeki_araclar.php";</script>';
                     }
                     
                     }
                     
                     }else if($_SESSION['u_token'] == "" && $_SESSION['k_token'] == ""){
                     echo'<script> alert("Giriş yapmalısınız")</script>';
                     //echo'<script> window.location.href = "ihaledeki_araclar.php";</script>';
                     }                        
                     }
                     ?>
                  <nav aria-label="Page navigation example">
                     <ul class="pagination justify-content-end">
                        <li class="page-item">
                           <a class="page-link" href="?sayfa=1" tabindex="-1" aria-disabled="true">İlk</a>
                        </li>
                        <li class="page-item <?php if($sayfa <= 1){ echo 'disabled'; } ?>">
                           <a class="page-link" href="<?php if($sayfa <= 1){ echo '#'; } else { echo "?sayfa=".($sayfa - 1); } ?>">Önceki</a>
                        </li>
                        <li class="page-item <?php if($sayfa >= $toplam_sayfa){ echo 'disabled'; } ?>">
                           <a class="page-link" href="<?php if($sayfa >= $toplam_sayfa){ echo '#'; } else { echo "?sayfa=".($sayfa + 1); } ?>">Sonraki</a>
                        </li>
                        <li class="page-item">
                           <a class="page-link" href="?sayfa=<?php echo $toplam_sayfa; ?>">Son</a>
                        </li>
                     </ul>
                     <ul class="pagination justify-content-end">
                        <li class="page-item">
                           Toplam <?=$toplam_sayfa ?> SAYFA ilan içerisinden <?=$sayfa ?>. SAYFADASINIZ
                        </li>
                     </ul>
                  </nav>
                  <script>localStorage.removeItem("filtre_modeller");</script>
                  <?php } ?>
               </div>
            </div>
         </div>
      </div>
      <input type="hidden" id="kullaniciToken" value="<?=$uye_token ?>">
      <input type="hidden" id="ip" value="<?=GetIP() ?>">
      <input type="hidden" id="tarayici" value="<?=$browser ?>">
      <input type="hidden" id="isletim_sistemi" value="<?=$os ?>">
  
      <style>
         .ihale_slider_outer
         {
            min-height:20px;
            float:left;
            padding:0px;
         }
      </style>
      
      <div class="clearfix"></div>
      <input type="hidden" id="sira_array2" value="<?=$sira_array2; ?>">
      <!-- Footer Başlangıç -->
      <?php include "footer.php" ?>
      <!-- Footer Bitiş -->
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
      <script src="js/toastr/toastr.js"></script>
      <script src="js/aos.js"></script>
      <script src="js/main.js?v=<?=time() ?>"></script>
      <script src="https://kit.fontawesome.com/2fdd899201.js" crossorigin="anonymous" ></script>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
      <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
   </body>
</html>
<script>
   $('.website_fullwidth_slider_boxes_outer').owlCarousel({
         margin:10,
         loop:true,
         autoplay:true,
         autoplayTimeout:2000,
         autoplayHoverPause:true,
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

   window.addEventListener('resize', function(event) {
      var customSliderWidth = document.getElementById("custom_slider_width").offsetWidth;
      document.getElementById("customSliderOuter").style.width = customSliderWidth+"px";
   }, true);

   $(document).ready(function(){
      var customSliderWidth = document.getElementById("custom_slider_width").offsetWidth;
      document.getElementById("customSliderOuter").style.width = customSliderWidth+"px";
      setTimeout(function(){ 
         $('.custom_mini_slider_boxes_contents').owlCarousel({
            margin:10,
            loop:true,
            items:2,
            autoplay:true,
            autoplayTimeout:2000,
            autoplayHoverPause:true
         })
      }, 500);

      function counter(event) {
         // console.log(event);
         var element = event.target;         // DOM element, in this example .owl-carousel
         var items = event.item.count;     // Number of items
         var item = event.item.index + 1;     // Position of the current item
         // it loop is true then reset counter from 1
         if(item > items) {
            item = item - items
         }
         // var $dene = element.children[0];
         // var $dene2 = $dene.children[0];
         // var $dene3 = $dene2.children[3];
         // var activeEls = $('.owl-item.active').eq(0);
         // console.log($dene2);
         // console.log(event.item);
         // console.log(event.relatedTarget.settings.items);
         // console.log(event.relatedTarget.current());
         console.log("item "+item+" of "+items)
         // console.log(element);
         // console.log(event.item);
         // var $active = $('.owl-item active');
         // console.log($active);
         // var $dene = element.find('.son_gezdigim_arac');
         // alert($dene);
      }

   });
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

   function bildirim_ac(id){
   	jQuery.ajax({
   		url: 'action.php',
   		method: 'POST',
   		dataType: "JSON",
   		data: {
   			action:"bildirim_ac",
   			id:id
   		},
   		success: function(data) {
   			$("#bildirim_ac_"+id).tooltip('hide');
   			if(data.status!=200){
   				openToastrDanger(data.message);
   			}else{
   				openToastrSuccess(data.message);
   				$("#bildirim_ac_"+id+" i").css("color",data.color);
   				$("#bildirim_ac_"+id).attr("data-original-title",data.title);
   			}
   		}
   	});	
   }
   
   function favla(id){
   	jQuery.ajax({
   		url: 'action.php',
   		method: 'POST',
   		dataType: "JSON",
   		data: {
   			action:"favorilere_ekle",
   			id:id
   		},
   		success: function(data) {
   			$("#favla_"+id).tooltip('hide');
   			if(data.status!=200){
   				openToastrDanger(data.message);
   			}else{
   				openToastrSuccess(data.message);
   				$("#favla_"+id+" i").css("color",data.color);
   				$("#favla_"+id).attr("data-original-title","");
   				$("#favla_"+id).attr("data-original-title",data.title);
   			}
   		}
   	});	
   }
   var sira_array=<?php echo json_encode($sira_array) ?>;
   var sira_array2=<?php echo json_encode($sira_array2) ?>;
   var modal_array=<?php echo json_encode($modal_array) ?>;
   
   function popup(text){
   	$(".modal").addClass("modal_zindex");
   	swal({
   		text: text,
   		closeOnClickOutside: false,
   		buttons: {
   			defeat: "KAPAT",
   		}
   	}).then((value) => {
   		switch (value) {   
   			case "defeat":
   				  $(".modal").removeClass("modal_zindex");
   			break;
   	  
   		 default:
   		 break;
   		 }
   	});
   }
   function formatMoney(n) {
      var n= (Math.round(n * 100) / 100).toLocaleString();
      n=n.replaceAll(',', '.')
      return n;
   }
</script>
<script>
   var ihale_say =document.getElementById('ihale_say');
   var ihale_say2 =document.getElementById('ihale_say2');
   var ihale_say3 =document.getElementById('ihale_say3');
   
   function createCountDown(elementId,sira) 
   {
   	var zaman =document.getElementById("ihale_sayac"+sira).value;
   	var id =document.getElementById("id_"+sira).value;
   	var uzatilma_durumu =document.getElementById("sure_uzatilma_durum_"+sira).value;
   	var countDownDate = new Date(zaman).getTime();
   	var belirlenen=document.getElementById("belirlenen_"+sira).value;
   	var gosterilme=document.getElementById("gosterilme_"+sira).value;
   	if(countDownDate>0){
         
   		var x = setInterval(function(){
   			jQuery.ajax({
   				url: "https://ihale.pertdunyasi.com/check.php",
   				type: "POST",
   				dataType: "JSON",
   				data: {
   					action: "panel_ilan_guncelle",
   					kapanis_zamani: $(".kapanis_zamani"+sira).html(),
   					ilan_id:id,
   				},
   				success: function(response) {
   					$(".kapanis_zamani"+sira).html(response.ihale_tarihi);
   					countDownDate=countDownDate+response.milisaniye; 	
   					belirlenen=response.belirlenen;
   					gosterilme=response.gosterilme;
                  //document.getElementById("verilen_teklif_hidden"+id).value = response.son_teklif;
   				}
   			});
   			var now = new Date().getTime();
   			var distance = (countDownDate) - (now);
   			var days = Math.floor(distance / (1000 * 60 * 60 * 24));
   			var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
   			var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));	
   			var seconds = Math.floor((distance % (1000 * 60)) / 1000);
   			if(days>=0 && hours>=0 && minutes>=0 && seconds >= 0){
   				if(days<=0 && hours<=0 && minutes<belirlenen ){
   					if(hours<10){
   						hours="0"+hours;
   					}
   					if(minutes<10){
   						minutes="0"+minutes;
   					}
   					if(seconds<10){
   						seconds="0"+seconds;
   					}
   					document.getElementById(elementId).innerHTML = " <i class='fas fa-stopwatch'></i>"+ "XX:XX:XX ";
   				}else{
   					if(hours<10){
   						hours="0"+hours;
   					}
   					if(minutes<10){
   						minutes="0"+minutes;
   					}	
   					if(seconds<10){
   						seconds="0"+seconds;
   					}
   					document.getElementById(elementId).innerHTML = "<i class='fas fa-stopwatch'></i> "+ days + " Gün " + hours + ":"+ minutes + ":" + seconds + " ";
   				}
   			}else{
   				if(belirlenen>0){
   					document.getElementById(elementId).innerHTML = " <i class='fas fa-stopwatch'></i>"+ "XX:XX:XX ";
   				}else{
   					if(gosterilme=="true"){
   						document.getElementById(elementId).innerHTML = " <i class='fas fa-stopwatch'></i>"+ "XX:XX:XX ";   
   					}else{
   						document.getElementById(elementId).innerHTML = " <i class='fas fa-stopwatch'></i>"+ "İHALE KAPANDI";   
   					}
   				}
   			}
   			if (distance < 0) {
   				clearInterval(x); 
   				sure_doldu(id);
   			}
   		}, 1000);
         
   	}
   }
   
   function createCountDown2(elementId2,sira){
   		var zaman2 =document.getElementById("ihale_sayac2_"+sira).value;
   		var id2 =document.getElementById("id2_"+sira).value;
   		var uzatilma_durumu2 =document.getElementById("sure_uzatilma_durum2_"+sira).value;
   		var countDownDate2 = new Date(zaman2).getTime();
   		var belirlenen2=document.getElementById("belirlenen2_"+sira).value;
   		var gosterilme2=document.getElementById("gosterilme2_"+sira).value;
   		if(countDownDate2>0){
            
   		var x2 = setInterval(function(){
   			jQuery.ajax({
   				url: "https://ihale.pertdunyasi.com/check.php",
   				type: "POST",
   				dataType: "JSON",
   				data: {
   					action: "panel_ilan_guncelle",
   					kapanis_zamani: document.getElementById("ihale_sayac2_"+sira).value,
   					ilan_id:id2,
   				},
   				success: function(response) {
   					
   					$("#ihale_sayac2_"+sira).val(response.ihale_tarihi);
   					countDownDate2=countDownDate2+response.milisaniye; 	
   					belirlenen2=response.belirlenen;
   					gosterilme2=response.gosterilme;
                  //document.getElementById("verilen_teklif_hidden"+id2).value = response.son_teklif;
   				}
   			});
   			var now2 = new Date().getTime();
   			var distance2 = (countDownDate2) - (now2);
   			var days2 = Math.floor(distance2 / (1000 * 60 * 60 * 24));
   			var hours2 = Math.floor((distance2 % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
   			var minutes2 = Math.floor((distance2 % (1000 * 60 * 60)) / (1000 * 60));	
   			var seconds2 = Math.floor((distance2 % (1000 * 60)) / 1000);
   			if(days2>=0 && hours2>=0 && minutes2>=0 && seconds2 >= 0){
   				if(days2<=0 && hours2<=0 && minutes2<belirlenen2 ){
   					
   					if(hours2<10){
   						hours2="0"+hours2;
   					}
   					if(minutes2<10){
   						minutes2="0"+minutes2;
   					}
   					if(seconds2<10){
   						seconds2="0"+seconds2;
   					}
   					document.getElementById(elementId2).innerHTML =  " <i class='fas fa-stopwatch'></i>  "+"XX:XX:XX ";
   				}else{
   					if(hours2<10){
   						hours2="0"+hours2;
   					}
   					if(minutes2<10){
   						minutes2="0"+minutes2;
   					}
   						
   					if(seconds2<10){
   						seconds2="0"+seconds2;
   					}
   					document.getElementById(elementId2).innerHTML =  " <i class='fas fa-stopwatch'></i>  "+days2 + " Gün " + hours2 + ":"+ minutes2 + ":" + seconds2 + " ";
   				}
   			}else{
   				
   				if(belirlenen2>0){
   					document.getElementById(elementId2).innerHTML =  " <i class='fas fa-stopwatch'></i>  "+"XX:XX:XX ";
   				}else{
   					if(gosterilme2=="true"){
   						document.getElementById(elementId2).innerHTML = " <i class='fas fa-stopwatch'></i>"+ "XX:XX:XX ";   
   					}else{
   						document.getElementById(elementId2).innerHTML = " <i class='fas fa-stopwatch'></i>"+ "İHALE KAPANDI";   
   					}
   				}
   				
   			}
   
   				if (distance2 < 0) 
   				{
   					clearInterval(x2);
   					//document.getElementById(elementId2).innerHTML =" <i class='fas fa-stopwatch'></i> " + " Süre Doldu";   
   					sure_doldu(id2);
   				}
   		
   			}, 1000);

            
   		}
   }


   function createCountDown3(elementId2,sira){
   		var zaman2 =document.getElementById("ihale_sayac3_"+sira).value;
   		var id2 =document.getElementById("id3_"+sira).value;
   		var uzatilma_durumu2 =document.getElementById("sure_uzatilma_durum3_"+sira).value;
   		var countDownDate2 = new Date(zaman2).getTime();
   		var belirlenen2=document.getElementById("belirlenen3_"+sira).value;
   		var gosterilme2=document.getElementById("gosterilme3_"+sira).value;
   		if(countDownDate2>0){
   		var x2 = setInterval(function(){
   			jQuery.ajax({
   				url: "https://ihale.pertdunyasi.com/check.php",
   				type: "POST",
   				dataType: "JSON",
   				data: {
   					action: "panel_ilan_guncelle",
   					kapanis_zamani: document.getElementById("ihale_sayac3_"+sira).value,
   					ilan_id:id2,
   				},
   				success: function(response) {
   					$("#ihale_sayac3_"+sira).val(response.ihale_tarihi);
   					countDownDate2=countDownDate2+response.milisaniye; 	
   					belirlenen2=response.belirlenen;
   					gosterilme2=response.gosterilme;
   				}
   			});
   			var now2 = new Date().getTime();
   			var distance2 = (countDownDate2) - (now2);
   			var days2 = Math.floor(distance2 / (1000 * 60 * 60 * 24));
   			var hours2 = Math.floor((distance2 % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
   			var minutes2 = Math.floor((distance2 % (1000 * 60 * 60)) / (1000 * 60));	
   			var seconds2 = Math.floor((distance2 % (1000 * 60)) / 1000);
   			if(days2>=0 && hours2>=0 && minutes2>=0 && seconds2 >= 0){
   				if(days2<=0 && hours2<=0 && minutes2<belirlenen2 ){
   					if(hours2<10){
   						hours2="0"+hours2;
   					}
   					if(minutes2<10){
   						minutes2="0"+minutes2;
   					}
   					if(seconds2<10){
   						seconds2="0"+seconds2;
   					}
   					document.getElementById(elementId2).innerHTML =  " <i class='fas fa-stopwatch'></i>  "+"XX:XX:XX ";
   				}else{
   					if(hours2<10){
   						hours2="0"+hours2;
   					}
   					if(minutes2<10){
   						minutes2="0"+minutes2;
   					}
   					if(seconds2<10){
   						seconds2="0"+seconds2;
   					}
   					document.getElementById(elementId2).innerHTML =  " <i class='fas fa-stopwatch'></i>  "+days2 + " Gün " + hours2 + ":"+ minutes2 + ":" + seconds2 + " ";
   				}
   			}else{
   				if(belirlenen2>0){
   					document.getElementById(elementId2).innerHTML =  " <i class='fas fa-stopwatch'></i>  "+"XX:XX:XX ";
   				}else{
   					if(gosterilme2=="true"){
   						document.getElementById(elementId2).innerHTML = " <i class='fas fa-stopwatch'></i>"+ "XX:XX:XX ";   
   					}else{
   						document.getElementById(elementId2).innerHTML = " <i class='fas fa-stopwatch'></i>"+ "İHALE KAPANDI";   
   					}
   				}
   			}
            if (distance2 < 0) 
            {
               clearInterval(x2);
               sure_doldu(id2);
            }
   		
   			}, 1000);
   		}
   }


   for (var i = 0; i <= sira_array.length; i++) {
      if(jQuery.inArray( i, sira_array )>-1){
         var sayac=createCountDown("sayac"+i,i);
      }
   }
   for (var h = 0; h <= modal_array.length; h++) {
      if(jQuery.inArray( h, modal_array )>-1){
         createCountDown("modalZaman"+h,h);
      }
   }
   for (var m = 0; m < ihale_say2.value; m++) {
   	createCountDown2("sayac2_"+m,m);
   }
   for (var p = 0; p < ihale_say3.value; p++) {
   	createCountDown3("sayac3_"+p,p);
   }
</script>
<script>
   $( document ).ready(function() {
         var maxHeight = 0;
   
      $(".vitrin_marka").each(function(){
      if ($(this).height() > maxHeight) { maxHeight = $(this).height(); }
      });
   
      $(".vitrin_marka").height(maxHeight);
   });
   
   
   
   function ihale_arttir(id){
      jQuery.ajax({
         url: "https://ihale.pertdunyasi.com/check.php",
         type: "POST",
         dataType: "JSON",
         data: {
            action: "ihale_arttir",
            ilan_id:id,
            ip:document.getElementById("ip").value,
         },
         success: function(response) {
            //console.log(response);
         }
      });
   }
</script>
<script>
   function otomatik_sure_uzat(id,sira){
   	var durum=false;
   	var stt=500;
   	var cv=jQuery.ajax({
   		url: "https://ihale.pertdunyasi.com/check.php",
   		type: "POST",
   		dataType: "JSON",
   		data: {
   			action: "otomatik_sure_uzat",
   			id:id
   		},
   		success: function(response) {
   			console.log(response.status);
   			return response;
   			/*if(response.status==200){
   				durum= true;
   			}else {
   				durum=false
   			}*/
   		}
   	});
   
   	return durum;
   
   	
   }
   function sure_doldu(id){
   	jQuery.ajax({
   		url: "https://ihale.pertdunyasi.com/check.php",
   		type: "POST",
   		dataType: "JSON",
   		data: {
   			action: "sure_doldu",
   			id:id
   		},
   		success: function(response) {
   
   			if (response.status == 200) {
   				//window.location="ihaledeki_araclar.php";
   			}
   		}
   	});
     }
</script>
<script>
   function degistir(ilan_id){
   if($("#verilen_teklif"+parseInt(ilan_id)).val()!=""){
   		
   $("#hizmet_bedel"+parseInt(ilan_id)).css("display","contents");
      document.getElementById("GelenTeklif"+parseInt(ilan_id)).value = $("#verilen_teklif"+parseInt(ilan_id)).val() ;
   // document.getElementById("GelenTeklif"+parseInt(ilan_id)).innerHTML =  formatMoney($("#verilen_teklif"+parseInt(ilan_id)).val()) + " ₺ teklif vermek üzeresiniz";
   document.getElementById("GelenTeklif"+parseInt(ilan_id)).innerHTML =  formatMoney($("#verilen_teklif"+parseInt(ilan_id)).val()) + " ₺";
   } else {
   
   $("#hizmet_bedel"+parseInt(ilan_id)).css("display","none");
   
   document.getElementById("GelenTeklif"+parseInt(ilan_id)).value = "";
   document.getElementById("GelenTeklif"+parseInt(ilan_id)).innerHTML =  "";
   }
   		
   }
</script>
<script>
   function kontrol(ilan_id){
      $.ajax({
         url: 'teklif_ver.php',
         method: 'post',
         dataType: "json",
         data: {
            action:"checked_kontrol",
            ilanID: ilan_id,
            uye_token: "<?=$uye_token ?>",
         },
         success: function(data) {
            if(data.status==200){
                  $("#sozlesme_kontrol"+parseInt(ilan_id)).prop('checked', true);
            }else{
               $("#sozlesme_kontrol"+parseInt(ilan_id)).prop('checked', false);
            }	
         },
         error: function(data) {
            alert('HATA! Lütfen tekrar deneyiniz.')
         }
      });
   }
</script>
<script>
   function komisyon_kontrol(id){
   	var hesaplama = document.getElementById("hesaplama"+id).value;
   	if(document.getElementById("verilen_teklif"+id).value != ""){
   		var girilen_teklif = parseInt(document.getElementById("verilen_teklif"+id).value);           
   	}else if($("#verilen_teklif_hidden"+id).val()!=""  ){
   		if( $("#verilen_teklif_hidden"+id).val()!=undefined){
   			var girilen_teklif = parseInt(document.getElementById("verilen_teklif_hidden"+id).value);           
   		}
   	}
   	$.ajax({
   		url: 'teklif_ver.php',
   		method: 'post',
   		dataType: "json",
   		data: {
   			action:"komisyon_cek",
   			ilan_id: id,
   			girilen_teklif:girilen_teklif
   		},
   		success: function(data) {
   			var son_komisyon=data.son_komisyon;
   			if(son_komisyon == 0 || son_komisyon == undefined || son_komisyon == null || son_komisyon == "" ){
   				document.getElementById("hizmet_bedel"+id).innerHTML = "" +"₺";
   				document.getElementById("hizmet_bedel"+id).value = "" +"₺";
   			}else {
   				document.getElementById("hizmet_bedel"+id).innerHTML = formatMoney(son_komisyon) +"₺";
   				document.getElementById("hizmet_bedel"+id).value = son_komisyon +"₺";
   			}	
   		},
   	});
    
    }
</script>
<script>
   function teklif_kontrol(ilan_id){
   	$.ajax({
   		url: 'teklif_ver.php',
   		method: 'post',
   		dataType: "json",
   		data: {
   			action:"teklif_kontrol",
   			ilanID: ilan_id,
   			teklif: $("#verilen_teklif"+parseInt(ilan_id)).val(),
   			uye_token: "<?=$uye_token ?>",
   		},
   		success: function(data) {
   			if(data.status!=200){
   				$("#teklif_kontrol"+parseInt(ilan_id)).html(data.message);
   				$("#teklif_kontrol"+parseInt(ilan_id)).css("color","red");
   			}else{
   				$("#teklif_kontrol"+parseInt(ilan_id)).html("");
   			}
   		},
   		error: function(data) {
   			alert('HATA! Lütfen tekrar deneyiniz.')
   		}
   	});
   }
     
</script>
<script>
   function enyuksek_getir(ilan_id){
         	jQuery.ajax({
         		url: "https://ihale.pertdunyasi.com/check.php",
         		type: "POST",
         		dataType: "JSON",
         		data: {
         			action: "enyuksek_yenile",
         			id:ilan_id,
         		},
         		success: function(response) {
                  
         			if (response.status == 200) {
                     var deneme=document.getElementById("modalTeklif"+(ilan_id)).innerHTML;
                     var a=response.teklif;
                     var b=document.getElementById("modalTeklif"+ilan_id).value;
         				if(a != b ){
                        openToastrDanger("En yüksek teklif fiyatı değişti.");
                        $("#GelenTeklif"+parseInt(ilan_id)).val(parseInt(response.teklif)+<?=$min_arti ?>);
                        document.getElementById("verilen_teklif_hidden"+ilan_id).value=parseInt(response.teklif)+<?=$min_arti ?>;
         					document.getElementById("GelenTeklif"+ilan_id).innerHTML= formatMoney(response.teklif+<?=$min_arti ?>);
         					document.getElementById("modalTeklif"+ilan_id).value = a;
         					document.getElementById("modalTeklif"+ilan_id).innerHTML = formatMoney(a) + " ₺";
                        //location.reload();
         				}
         			
         			}/*else{
         				
         				 window.location="index.php";
         			}*/
         		}
         	});
         }
   function denem(ilan_id){
   	var girilen_teklif = $("#girilen_teklif"+ilan_id).val();
   	var kullaniciToken = $('#kullaniciToken').val();
      
   	var uyeID = $('#uyeID').val();
   	var ip = $('#ip').val();
   	var tarayici = $('#tarayici').val();
   	var isletim_sistemi = $('#isletim_sistemi').val();
   	var sozlesme_kontrol = $('#sozlesme_kontrol').val();   
   	var hizmet_bedel = parseInt($('#hizmet_bedel'+ilan_id).val());   
   	var verilen_teklif = "";
   	if(document.getElementById("verilen_teklif"+ilan_id).value != ""){
   		verilen_teklif = parseInt(document.getElementById("verilen_teklif"+ilan_id).value);           
   	}else if($("#verilen_teklif_hidden"+ilan_id).val()!=""  ){
   		if( $("#verilen_teklif_hidden"+ilan_id).val()!=undefined){
   			verilen_teklif = parseInt(document.getElementById("verilen_teklif_hidden"+ilan_id).value);           
   		}else {				
   			alert('Lütfen teklifinizi giriniz.');
   		}
   	} else {				
   			alert('Lütfen teklifinizi giriniz.');
   		}
   	if(verilen_teklif ==""  ){
   		alert('Lütfen teklifinizi giriniz.');
   	}else{
   		$.ajax({
   			url: 'teklif_ver.php',
   			method: 'post',
   			dataType: "json",
   			data: {
   				action:"teklif_ver",
   				verilen_teklif:verilen_teklif,
   				hizmet_bedel:hizmet_bedel,
   				ilanID: ilan_id,
   				uye_token: "<?=$uye_token ?>",
   				ip: ip,
   				tarayici: tarayici,
   				isletim_sistemi: isletim_sistemi,
   				sozlesme_kontrol: $('input:checkbox:checked').val(),
   			},
   			success: function(data) {
               alert(data.message);
               $('#modal_kapat'+ilan_id).trigger("click");
   				if(data.status==200){   					
   					document.getElementById("verilen_teklif"+ilan_id).value="";
   					document.getElementById("verilen_teklif_hidden"+ilan_id).value=verilen_teklif;
                  secimleri_sil(ilan_id);                  
                  $('.close').trigger("click");
                  $('#modal_kapat'+ilan_id).trigger("click");
                  $('#acik_modal_kapat'+ilan_id).trigger("click");
   					//location.reload();
   				}
   			}
   		});
   	}
   }
</script>
<script>

function secimleri_sil(id){
   $('#verilen_teklif'+id).val("");
   $('#arti1'+id).css("background-color","#00a2e8");
   $('#arti2'+id).css("background-color","#00a2e8");
   $('#arti3'+id).css("background-color","#00a2e8");
   $('#arti4'+id).css("background-color","#00a2e8");
}

   function buttonClick(id) {
   	var i = document.getElementById("verilen_teklif_hidden"+id).value;      
   	var plus = parseInt(i);
   	var hizli1 = document.getElementById("arti1"+id).value;
   	plus += parseInt(hizli1);      
   	
   	//document.getElementById("verilen_teklif_hidden"+id).value=plus;
   	document.getElementById("verilen_teklif"+id).value = plus;
      $('#arti1'+id).css("background-color","#71bc42");
      $('#arti2'+id).css("background-color","#00a2e8");
      $('#arti3'+id).css("background-color","#00a2e8");
      $('#arti4'+id).css("background-color","#00a2e8");
   	
   	document.getElementById("GelenTeklif"+id).style.display = "block";
   
   	komisyon_kontrol(id);
   }
   
   function clickButton(id) {
   	var i = document.getElementById("verilen_teklif_hidden"+id).value;
   	var plus = parseInt(i);
   	var hizli3 = document.getElementById("arti3"+id).value;
   	plus +=  parseInt(hizli3);
   	
   	//document.getElementById("verilen_teklif_hidden"+id).value=plus;
   	document.getElementById("verilen_teklif"+id).value = plus;
      $('#arti1'+id).css("background-color","#00a2e8");
      $('#arti2'+id).css("background-color","#00a2e8");
      $('#arti3'+id).css("background-color","#71bc42");
      $('#arti4'+id).css("background-color","#00a2e8");
   	
   	document.getElementById("GelenTeklif"+id).style.display = "block";
   	komisyon_kontrol(id);
   }
   function buttonClick2 (id) {
   	var i = document.getElementById("verilen_teklif_hidden"+id).value;
   	var plus = parseInt(i);
   	var hizli2 = document.getElementById("arti2"+id).value;
   	plus +=  parseInt(hizli2);
   	//document.getElementById("verilen_teklif_hidden"+id).value=plus;
   	document.getElementById("verilen_teklif"+id).value = plus;
      $('#arti1'+id).css("background-color","#00a2e8");
      $('#arti2'+id).css("background-color","#71bc42");
      $('#arti3'+id).css("background-color","#00a2e8");
      $('#arti4'+id).css("background-color","#00a2e8");
   	document.getElementById("GelenTeklif"+id).style.display = "block";
   	komisyon_kontrol(id);
   }
   function clickButton2 (id) {
   	var i = document.getElementById("verilen_teklif_hidden"+id).value;
   	var plus = parseInt(i);
   	var hizli4 = document.getElementById("arti4"+id).value;
      $('#arti1'+id).css("background-color","#00a2e8");
      $('#arti2'+id).css("background-color","#00a2e8");
      $('#arti3'+id).css("background-color","#00a2e8");
      $('#arti4'+id).css("background-color","#71bc42");
   	plus +=  parseInt(hizli4);
   	//document.getElementById("verilen_teklif_hidden"+id).value=plus;
   	document.getElementById("verilen_teklif"+id).value = plus;
   	document.getElementById("GelenTeklif"+id).style.display = "block";
   	komisyon_kontrol(id);
   }
</script>    
<script>
   function modelGetir(modelin_marka) {
         var modelin_marka = modelin_marka;   
         $.post('ihale_model_cek.php', {
            modelin_marka: modelin_marka
         }, function(output) {
   
   			var marka_checkBox = document.getElementById("marka_"+modelin_marka);
   			 if (marka_checkBox.checked == true){
   				$('#modeller').append(output);
   			 } else {
   				$(".modelmarka_"+modelin_marka).remove();
   			 } 
            //   $('#modeller').append(output);
         });
      }
      function modelGetir2(modelin_marka) {
         var modelin_marka = modelin_marka;   
         $.post('ihale_model_cek.php', {
            modelin_marka: modelin_marka
         }, function(output) {
   		  var local_cek=localStorage.getItem("filtre_modeller");
   		 
   		if(local_cek=="" || local_cek==null || local_cek==undefined ){
   			var marka_checkBox = document.getElementById("marka_"+modelin_marka);    
   			 if (marka_checkBox.checked == true){
   				$('#modeller').append(output);
   			 } else {
   				var elms = document.querySelectorAll('#model_'+modelin_marka);
   				for(var i = 0; i < elms.length; i++) {
   				   elms[i].remove();
   				}
   			 } 
   		}else{
   			 var parcala=local_cek.split(",");
   			var boyut=parcala.length-1;
   			for(var i=0;i<boyut;i++){
   			  if(parcala[i]!="marka"+modelin_marka){
   				 var marka_checkBox = document.getElementById("marka_"+modelin_marka);    
   				 if (marka_checkBox.checked == true){
   					$('#modeller').append(output);
   				 } else {
   					var elms = document.querySelectorAll('#model_'+modelin_marka);
   					for(var i = 0; i < elms.length; i++) {
   					   elms[i].remove();
   					}
   				 } 
   			  }
   		  }
   		}
            //   $('#modeller').append(output);
         });
      }
      
</script>  

<script>
   $( document ).ready(function() {
      $(".son_gezdigim_arac").each(function(){
         var $ilan_id = $(this).val();   
         // alert($ilan_id);
          son_gezilenler_sayac($ilan_id);
      })   
   });

   function son_gezilenler_sayac($ilan_id){
      // console.log($ilan_id);
      setInterval(function() {
         var $sure = $('#son_gezilen_sure_'+$ilan_id).val();
         var $kapanis_tarihi = new Date($sure);
         $kapanis_tarihi = (Date.parse($kapanis_tarihi) / 1000);
         var now = new Date();
         now = (Date.parse(now) / 1000);
         var timeLeft = $kapanis_tarihi - now;
         var days = Math.floor(timeLeft / 86400); 
         var hours = Math.floor((timeLeft - (days * 86400)) / 3600);
         var minutes = Math.floor((timeLeft - (days * 86400) - (hours * 3600 )) / 60);
         var seconds = Math.floor((timeLeft - (days * 86400) - (hours * 3600) - (minutes * 60)));
         if (hours < "10") { hours = "0" + hours; }
         if (minutes < "10") { minutes = "0" + minutes; }
         if (seconds < "10") { seconds = "0" + seconds; }
         $('#son_gezdigim_sayac_'+$ilan_id).html(days+" Gün "+hours+":"+minutes+":"+seconds);
      }, 1000);
      // console.log(days+" Gün "+hours+":"+minutes+":"+seconds);
   }
</script>


<script src="js/cikis_yap.js?v=<?php echo time(); ?>"></script>
<script>
   function bilgi_yenile(){
   	$.ajax({
   		url: 'check.php',
   		method: 'post',
   		dataType: "json",
   		data: {
   			action:"bilgi_yenile",
   		},
   		success: function(data) {            
   			$.each( data.ilan_bilgileri, function( key, value ) {
   				$("#uye_bilgi_"+value.ilan_id).html(value.uye_ilan_bilgileri);
   				$("#modal_uye_bilgi_"+value.ilan_id).html(value.uye_ilan_bilgileri);
               
   				if(value.ilan_status==1 && value.user_package_status==true ){
   					$("#en_yuksek_"+value.ilan_id).html(formatMoney(value.son_teklif)+" ₺");
   				}else{
   					$("#en_yuksek_"+value.ilan_id).html('<i style="color:#000" class="fas fa-lock"></i>');
   				}
               // $("#en_yuksek_"+value.ilan_id).html(formatMoney(value.son_teklif)+" ₺");
               //document.getElementById("verilen_teklif_hidden"+ilan_id).value = value.son_teklif;
   				$("#owl_son_teklif_"+value.ilan_id).html(formatMoney(value.son_teklif)+" ₺");
   				//$("#uye_bilgi"+value.ilan_id).html(value.uye_ilan_bilgileri);
   			});
   		}
   	});
   }
   setInterval(function() {
      cikis_yap("<?=$uye_token?>");
   }, 300001);
      son_islem_guncelle("<?=$uye_token?>"); 
      setInterval(function(){ bildirim_sms();bilgi_yenile(); }, 1000);
</script>
<script>
   $(function () {
   	$('[data-toggle="tooltip"]').tooltip()
   })
</script>