<?php
ini_set("display_errors","on");
ini_set("error_reporting","E_ALL");
	session_start();

	include 'ayar.php';
die("here");
	$token = $_SESSION['u_token'];
	$k_token = $_SESSION['k_token'];
	if(!empty($token)){
		$uye_token = $token;
	}elseif(!empty($k_token)){
		$uye_token = $k_token;
	}
?>

<?php 
	$sehir_cek = mysql_query("SELECT * FROM sehir"); 
	$sehir_cek2 = mysql_query("SELECT * FROM sehir");                 
	$sehir_cek3 = mysql_query("SELECT distinct sehiradi FROM sehir WHERE sehirID = plaka");  
	$vitrin_cek = mysql_query("SELECT *,concat(ihale_tarihi,' ',ihale_saati) as tarih FROM ilanlar WHERE vitrin = 'on' and durum=1");
	$dogrudan_vitrin_cek = mysql_query("SELECT * FROM dogrudan_satisli_ilanlar WHERE vitrin = 'on' and durum=1");
	// $sql = mysql_query("SELECT *,concat(ihale_tarihi,' ',ihale_saati) as tarih FROM ilanlar WHERE vitrin = 'on' and durum=1  ORDER BY id ASC LIMIT 2");
	$sql = mysql_query("SELECT *,concat(ihale_tarihi,' ',ihale_saati) as tarih FROM ilanlar WHERE vitrin = 'on' and durum=1  ORDER BY RAND() LIMIT 2");
	$sql2 = mysql_query("SELECT * FROM dogrudan_satisli_ilanlar WHERE vitrin = 'on' and durum=1 and  bitis_tarihi > '".date("Y-m-d H:i:s")."' ORDER BY rand() LIMIT 1"); //ORDER BY RAND()
?>
<!doctype html>
<html lang="tr">
	<head>
		<?php
			include 'seo_kelimeler.php';
		?>
		<meta charset="utf-8">
		<meta http-equiv="content-language" content="tr">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta name="author" content="EA Bilişim">
		<meta name="Abstract" content="Pert Dünyası sigortadan veya sahibinden kazalı,hasarlı pert araçların online ihale ile veya doğrudan satış yapılabileceği online ihale platformudur.">
		<meta name="description" content="Pert Dünyası Pert Kazalı Araç İhale Sistemi">
		<meta name="keywords" content="hasarlı oto, hasarlı arabalar, hasarlı araçlar, pert araçlar, pert oto, pert arabalar, kazalı araçlar, kazalı oto, kazalı arabalar, hurda araçlar, hurda arabalar, 
			hurda oto, hasarlı ve pert kamyon, hasarlı ve kazalı traktör, kazalı çekici, ihale ile satılan hasarlı araçlar, sigortadan satılık pert arabalar, ihaleli araçlar, kapalı ihaleli araçlar, açık ihalelli araçlar, 2.el araç,
			hurda kamyon, hurda traktör, ihaleyle kamyon">
		<meta name="Copyright" content="Ea Bilişim Tüm Hakları Saklıdır.">
		<link href="https://fonts.googleapis.com/css?family=DM+Sans:300,400,700&display=swap" rel="stylesheet">
		<link rel="stylesheet" href="fonts/icomoon/style.css">
		<link rel="stylesheet" href="css/bootstrap.min.css">
		<link rel="stylesheet" href="css/bootstrap-datepicker.css">
		<link rel="stylesheet" href="css/jquery.fancybox.min.css">
		<link rel="stylesheet" href="css/owl.carousel.min.css?v=2">
		<link rel="stylesheet" href="css/owl.theme.default.min.css">
		<link rel="stylesheet" href="fonts/flaticon/font/flaticon.css">
		<link rel="stylesheet" href="css/aos.css">
		<link rel="stylesheet" href="css/custom_slider.css?v=<?php echo time(); ?>">
		<link rel="stylesheet" href="css/carousel.css?v=11">

		<!-- Slick Slider -->
		<link rel="stylesheet" type="text/css" href="slick_slider/slick/slick.css"/>
		<link rel="stylesheet" type="text/css" href="slick_slider/slick/slick-theme.css"/>

		<!-- MAIN CSS -->
		<link rel="stylesheet" href="css/style.css?v=<?php echo time(); ?>">
		<link rel="stylesheet" href="css/custom.css">
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.js"></script>
		<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
		<style>
			.owl-nav {
				display: none;
			}
			.references {
				width: 256px;
				height: 256px;
				margin-left: 20px;
			}
			.slider_button_asagi_sol{
				bottom:0;
				float:left;
			}
			.slider_button_asagi_sag{
				bottom:0;
				float:right;
			}
			.slider_button_yukari_sol{
				
			}
			.slider_button_yukari_sag{
				
			}
		</style>
	</head>
	<body style="padding-top:0px;" data-spy="scroll" data-target=".site-navbar-target" data-offset="300">
		<input type="hidden" id="ip" value="<?=GetIP() ?>"/>
  

		
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
							swal( {
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
								swal( {
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
		?>
                  
		<div id="myCarousel" class="carousel slide" data-ride="carousel" style="margin-top:5%;">
			<ol class="carousel-indicators">
			<?php 
				$kontrol=1;
				$sorgu=mysql_query("select * from slider where durum='1' order by id asc");
				while($row=mysql_fetch_object($sorgu)){ ?>
					<li data-target="#myCarousel" data-slide-to="<?=$row->id ?>" class="<?php echo($kontrol==1) ? "active" : "" ?>"></li>
				<?php  $kontrol=$kontrol+1; }?>
			</ol>
			<div class="carousel-inner">
			<?php 
				$kontrol=1;
				$sorgu=mysql_query("select * from slider where durum='1' order by id asc ");
				while($row=mysql_fetch_object($sorgu)){	?>
					<div class="carousel-item <?php echo($kontrol==1) ? "active" : "" ?> ">
						<img class="first-slide" src="<?=$row->resim?>" style="object-fit: cover;" alt="First slide">
						<div class="container">
							<?php 
								$ust_btn='';
								$alt_btn='';
								if($row->button==1)
								{ 
									if($row->button_yer_secimi==0)
									{
										$button_class="slider_button_asagi_sol";
										$alt_btn='<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 slider_button_div slider_button_left">
											<a class="btn btn-lg btn-primary" href="slider_editor.php?slider_id='.$row->id.'"  role="button">Detay</a>
										</div>';
									}
									else if($row->button_yer_secimi==1)
									{
										$button_class="slider_button_asagi_sag";
										$alt_btn='<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 slider_button_div slider_button_right">
											<a class="btn btn-lg btn-primary" href="slider_editor.php?slider_id='.$row->id.'"  role="button">Detay</a>
										</div>';
									}
									else if($row->button_yer_secimi==2)
									{
										$button_class="slider_button_yukari_sol";
										$ust_btn='<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 slider_button_div slider_button_left">
											<a class="btn btn-lg btn-primary" href="slider_editor.php?slider_id='.$row->id.'"  role="button">Detay</a>
										</div>';
									}
									else if($row->button_yer_secimi==3)
									{
										$button_class="slider_button_yukari_sag";
										$ust_btn='<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 slider_button_div slider_button_right">
											<a class="btn btn-lg btn-primary" href="slider_editor.php?slider_id='.$row->id.'" role="button">Detay</a>
										</div>';
									}
									else
									{
										$button_class="";
									}
								}
							?>
							<style>
								.slider_button_div
								{
									height:auto;
									padding:0px;
									display:flex;
									align-items:center;
									margin:15px 0px;
								}
								
								.slider_button_left
								{
									justify-content:flex-start;
								}
								
								.slider_button_center
								{
									justify-content:center;
								}
								
								.slider_button_right
								{
									justify-content:flex-end;
								}
							</style>
							<div class="carousel-caption text-left">
								<?= $ust_btn ?>
								<h1 style="font-weight: 500;" class="c-white"><?=$row->baslik ?></h1>
								<p style="font-weight: 500;"><?=$row->aciklama ?></p>
								<?= $alt_btn ?>
							</div>
						</div>
					</div>
				<?php $kontrol=$kontrol+1; }?>
			</div>
			<?php if(mysql_num_rows($sorgu)>1){ ?>
			<a class="carousel-control-prev" href="#myCarousel" role="button" data-slide="prev">
				<span class="carousel-control-prev-icon" aria-hidden="true"></span>
				<span class="sr-only">Previous</span>
			</a>
			<a class="carousel-control-next" href="#myCarousel" role="button" data-slide="next">
				<span class="carousel-control-next-icon" aria-hidden="true"></span>
				<span class="sr-only">Next</span>
			</a>
			<?php } ?>
			</div>
			<style>
					.buyuk_vitrin_dis
					{
						min-height:10px;
						float:left;
						padding:10px;
					}
					.buyuk_vitrin_kutu
					{
						min-height:10px;
						float:left;
						background-color:#ffffff;
						border:1px solid #dadada;
						padding:0px;
					}
					.buyuk_vitrin_gorsel
					{
						width:45%;
						float:left;
						position:relative;
						background-size:cover;
						background-position:center;
					}
					.buyuk_vitrin_gorsel:after
					{
						content:"";
						display:block;
						padding-bottom:100%;
					}
					.buyuk_vitrin_kod
					{
						height: 40px;
						float: left;
						position: absolute;
						left: 0px;
						bottom: 0px;
						display: flex;
						align-items: center;
						padding: 10px;
						color: #fff;
					}
					.buyuk_vitrin_icerik_kutu
					{
						width:55%;
						min-height:20px;
						float:left;
						padding:10px;
					}
					.buyuk_vitrin_icerik_baslik
					{
						min-height: 10px;
						float: left;
						font-weight: 600;
						padding: 0px;
						font-size: 20px;
					}
					.buyuk_vitrin_icerik
					{
						min-height: 10px;
						float: left;
						font-weight: 700;
						padding: 0px;
						font-size: 24px;
					}
					.buyuk_vitrin_baslik_dis
					{
						height: 40px;
						float: left;
						line-height: 40px;
						padding: 0px 5px;
						font-weight: 600; 
						border-top:1px solid #dadada;
						white-space: nowrap;
						overflow: hidden;
						text-overflow: ellipsis;
					} 
					@media only screen and (max-width: 600px) {
						.buyuk_vitrin_gorsel
						{
							width:100%;
						}
						.buyuk_vitrin_icerik_kutu
						{
							width:100%;
						}
						.buyuk_vitrin_icerik_baslik
						{
							text-align:center;
						}
						.buyuk_vitrin_icerik
						{
							text-align:center;
						}
						.buyuk_vitrin_btn
						{
							width:50%;
							margin-left:25%;
						}
						.buyuk_vitrin_baslik_dis
						{
							text-align:center;
							font-size:13px;
						}
					}
				</style>

<?php 
		    $son_eklenen = vitrin_ilanlari_new();
			$sira_array2=array();
			$sira2 = 0;
			$sira3 = 0;
			$ihale_say2 = count($son_eklenen);
			for($i=0;$i<count($son_eklenen);$i++){
			   $sgrta_cek=mysql_query("select * from sigorta_ozellikleri where id='".$son_eklenen[$i]["sigorta"]."'");
			   $sgrta_oku=mysql_fetch_array($sgrta_cek);


			   	$bitis_tarihi=$son_eklenen[$i]["ihale_tarihi"]." ".$son_eklenen[$i]["ihale_saati"];
				$ihale_son_str = strtotime($bitis_tarihi);
				$suan_str = strtotime(date("Y-m-d H:i:s"));
				$sonuc=($ihale_son_str-$suan_str)/60;
				
				$u_token = $_SESSION["u_token"];
				$k_token = $_SESSION["k_token"];
				if($u_token != ""){
					$uye_token = $u_token;
				}else{
					$uye_token = $k_token;
				}
				if($sonuc<30){ 
					$kullanici_grubu = kullanici_grubu_cek($uye_token);
					if($kullanici_grubu==1){
						$user_package_status=true;
					}else{
						$user_package_status=false;
					}
					$kazanilan_sorgu=mysql_query("select * from kazanilan_ilanlar where ilan_id='".$ilan_id."' ");
					if(mysql_num_rows($kazanilan_sorgu)==0){
						$ilan_status=1;
					}else{
						$ilan_status=0;
					}					
				}else{
					$ilan_status=1;
					$user_package_status=true;					
				}	



			   if($son_eklenen[$i]["ihale_turu"] == 1){
					$color = "#00a2e8";
					$text_string = "En Yüksek";				
				}else{
					$color = "orange";
					$text_string = "Kapalı İhale";
					$son_teklif = "XXX";
				}

				if($son_eklenen[$i]["liste_durum"][0]["secilen_yetki_id"] == 2){
					$a_tag = '<a onclick="swal(\'Dikkat\',\'Bu ilanın detayını görme yetkiniz yoktur\',\'info\')">';
					$a_tag_buyuk = '<a onclick="swal(\'Dikkat\',\'Bu ilanın detayını görme yetkiniz yoktur\',\'info\')">';
				}else{
					$a_tag = '<a href="arac_detay.php?id='.$son_eklenen[$i]["id"].'&q=ihale" target="_blank">';
					$a_tag_buyuk = '<a onclick="ihale_arttir('.$son_eklenen[$i]["id"].')" style="text-decoration: none; color:#ffffff;" href="arac_detay.php?id='.$son_eklenen[$i]["id"].'&q=ihale" target="_blank">';
				}

				if($son_eklenen[$i]["liste_durum"][0]["detay_gorur"] != 1){					
					$son_teklif = '<i class="fas fa-lock"></i>';
					$resim = 'images/black_lock.jpg?v=2';
				}else{
					if($user_package_status == true && $ilan_status == 1){
						$son_teklif = money($son_eklenen[$i]["son_teklif"])." ₺";
					}else{
						$son_teklif = '<i class="fas fa-lock"></i>';
					}
					// $son_teklif = money($son_eklenen[$i]["son_teklif"])." ₺";
					$resim = $son_eklenen[$i]["resim"];
				}







			   if($i == 0 || $i == 1){				
			//    if($son_eklenen[$i]["id"] == 61 || $son_eklenen[$i]["id"] == 65){				
				$buyuk_vitrin .= '<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 buyuk_vitrin_dis">
					<div style="border-top: 5px solid '.$color.'" class="col-xs-12 col-sm-12 col-md-12 col-lg-12 buyuk_vitrin_kutu">
						<div class="buyuk_vitrin_gorsel" style="background-image:url(\''.$resim.'\');">
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 buyuk_vitrin_kod">
								#'.$son_eklenen[$i]["arac_kodu"].'
							</div>
						</div>
						<div class="buyuk_vitrin_icerik_kutu">
							<div id="sayac'.$sira3.'" class="col-xs-12 col-sm-12 col-md-12 col-lg-12 buyuk_vitrin_icerik" style="color:red;"></div>
							<input type="hidden" id="ihale_sayac'.$sira3.'" value="'.$son_eklenen[$i]["ihale_tarihi"].' '.$son_eklenen[$i]["ihale_saati"].'">
							<input type="hidden" id="id_'.$sira3.'" value="'.$son_eklenen[$i]["id"].'">
							<input type="hidden" id="sure_uzatilma_durumu_'.$sira3.'" value="'.$son_eklenen[$i]["sistem_sure_uzatma_durumu"].'">
							<input type="hidden" id="belirlenen_'.$sira3.'" value="'.$sgrt_oku['bu_sure_altinda_teklif'] .'">
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 buyuk_vitrin_icerik_baslik" style="margin-top:10px;">
								<text style="color:#3a3a3c94" >'.$text_string.'</text>
							</div>
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 buyuk_vitrin_icerik en_yuksek_'.$son_eklenen[$i]["id"].'">
								'.$son_teklif.' 
							</div>
							'.$a_tag_buyuk.'
								<button type="button" class="btn btn-warning mr-2 buyuk_vitrin_btn" style="background:'.$color.';padding: 6px 20px; color:#ffffff; margin-top: 10px;">
									İncele
								</button>
							</a>
						</div>
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 buyuk_vitrin_baslik_dis">
							'.$son_eklenen[$i]["model_yili"].' '.$son_eklenen[$i]["marka"].' '.$son_eklenen[$i]["model"].' '.$son_eklenen[$i]["tip"].'
						</div>
					</div>					
				</div>';
				$sira3++;
			   }else{
				array_push($sira_array2,$sira2); 
				$class = "";
				if($son_eklenen[$i]["ihale_turu"] == 2){
					$class = "website_fullwidth_slider_box_orange";
				}
				$son_eklenenler .= '<div>
						'.$a_tag.'
							<div class="website_fullwidth_slider_box '.$class.'">
								<div class="website_fullwidth_slider_box_title" id="sayac2_'.$sira2.'">
									<i class="fas fa-stopwatch"></i> '. $son_eklenen[$i]['ihale_tarihi'].' '. $son_eklenen[$i]['ihale_saati'].'
								</div>
								<input type="hidden" id="ihale_sayac2_'.$sira2.'" value="'. $son_eklenen[$i]['ihale_tarihi'].' '. $son_eklenen[$i]['ihale_saati'].'" >
								<input type="hidden" id="id2_'.$sira2.'" value="'.$son_eklenen[$i]['id'].'">
								<input type="hidden" id="sure_uzatilma_durum2_'.$sira2.'" value="'. $son_eklenen[$i]['sistem_sure_uzatma_durumu'].'">
								<input type="hidden" id="belirlenen2_'.$sira2.'" value="'. $sgrta_oku['bu_sure_altinda_teklif'] .'">
								<input type="hidden" id="gosterilme2_'.$sira2.'" value="'.gosterilme_durumu($son_eklenen[$i]['id']).'">
								<div class="website_fullwidth_slider_box_image" style="background-image:url(\''.$resim.'\');"></div>
								<div class="website_fullwidth_slider_box_contents">
									<h3>'.$son_eklenen[$i]["model_yili"].' '.$son_eklenen[$i]["marka"].' '.$son_eklenen[$i]["model"].' '.$son_eklenen[$i]["tip"].'</h3>
									<h4>'.$text_string.'</h4>
									<h5 class="en_yuksek_'.$son_eklenen[$i]["id"].'">'.$son_teklif.'</h5>
								</div>
							</div>
						</a>
					</div>';
				$sira2++;
			   }			   
			}

			while($dogrudan_buyuk_oku = mysql_fetch_object($sql2)){
				if($dogrudan_buyuk_oku->panelden_eklenme == 1){
					$card_title = "DOĞRUDAN SATIŞ";
					$border_color = '#a249a4';
				}else{
					$card_title = "SAHİBİNDEN SATIŞ";
					$border_color = '#22b14d';
				}
				$dogrudan_arac_kodu = substr($dogrudan_buyuk_oku->arac_kodu, 0, 25); 
				$dogrudan_resim = 'images/default.png';
				$getImage = mysql_query("SELECT * FROM dogrudan_satisli_resimler WHERE ilan_id = '".$dogrudan_buyuk_oku->id."' ORDER BY RAND() LIMIT 1");
				if(mysql_num_rows($getImage) != 0){
					$setImage = mysql_fetch_object($getImage);
					$dogrudan_resim = "images/".$setImage->resim;
				}
				/*
				$dogrudan_vitrin .= '<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 buyuk_vitrin_dis">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 buyuk_vitrin_kutu" style="border-top: 5px solid '.$border_color.'">
					<div class="buyuk_vitrin_gorsel" style="background-image:url(\''.$dogrudan_resim.'\');">
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 buyuk_vitrin_kod">
							#'.$dogrudan_arac_kodu.'
						</div>
					</div>
					<div class="buyuk_vitrin_icerik_kutu">
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 buyuk_vitrin_icerik" style="color:red;">'.$card_title.'</div>
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 buyuk_vitrin_icerik_baslik" style="margin-top:10px;">
							<text style="color:#3a3a3c94">Satış Fiyatı</text>
						</div>
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 buyuk_vitrin_icerik">
							'.money($dogrudan_buyuk_oku->fiyat).' ₺	
						</div>
						</div>
						<a style="text-decoration: none; color:#ffffff;" href="arac_detay.php?id='.$dogrudan_buyuk_oku->id.'&q=dogrudan" target="_blank">
							<button type="button" class="btn btn-warning mr-2 buyuk_vitrin_btn" style="background:'.$border_color.';padding: 6px 20px; color:#ffffff; margin-top: 10px;">
								İncele
							</button>
						</a>
					</div>
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 buyuk_vitrin_baslik_dis" style="background: white;">
						'.$dogrudan_buyuk_oku->model_yili.' '.$dogrudan_buyuk_oku->marka.' '.$dogrudan_buyuk_oku->model.' '.$dogrudan_buyuk_oku->uzanti.' 
						</div>
					</div>
				</div>';
				*/
				
				$dogrudan_vitrin .= '<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 buyuk_vitrin_dis">
				<div style="border-top: 5px solid '.$border_color.'" class="col-xs-12 col-sm-12 col-md-12 col-lg-12 buyuk_vitrin_kutu">
					<div class="buyuk_vitrin_gorsel" style="background-image:url(\''.$dogrudan_resim.'\');">
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 buyuk_vitrin_kod">
							#'.$dogrudan_arac_kodu.'
						</div>
					</div>
					<div class="buyuk_vitrin_icerik_kutu">
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 buyuk_vitrin_icerik" style="color:red;">'.$card_title.'</div>
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 buyuk_vitrin_icerik_baslik" style="margin-top:10px;">
							<text style="color:#3a3a3c94" >Satış Fiyatı</text>
						</div>
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 buyuk_vitrin_icerik">
							'.money($dogrudan_buyuk_oku->fiyat).' ₺	
						</div>
						<a style="text-decoration: none; color:#ffffff;" href="arac_detay.php?id='.$dogrudan_buyuk_oku->id.'&q=dogrudan" target="_blank">
							<button type="button" class="btn btn-warning mr-2 buyuk_vitrin_btn" style="background:'.$border_color.';padding: 6px 20px; color:#ffffff; margin-top: 10px;">
								İncele
							</button>
						</a>
					</div>
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 buyuk_vitrin_baslik_dis">
					'.$dogrudan_buyuk_oku->model_yili.' '.$dogrudan_buyuk_oku->marka.' '.$dogrudan_buyuk_oku->model.' '.$dogrudan_buyuk_oku->uzanti.' 
					</div>
				</div>					
			</div>';
			}
			

		?>
		<input type="hidden" id="ihale_say" value="2">	
		<div class="col-md-12" style="padding:0px; background-color:#cecece; margin-top:0px; padding-top:20px;">
			<!-- <div class="container"> -->
				<div class="row mt-4">
					<div class="col-12" style="text-align: center;"><h4 style="font-weight:800 !important;"><b>VİTRİN</b></h4></div>
				</div>
				<div class="row" style="padding: 15px;">
					<?= $buyuk_vitrin ?>			
					<?= $dogrudan_vitrin ?>			
				</div>
			<!-- </div> -->
			<style>
				/* 06.05.2021 Değişiklikler */
				.vitrin_ilanlari_ust
				{
					width:100%!important;
					height:40px!important;
					text-align:center!important;
					display:flex;
					align-items:center;
					justify-content:center;
					float:left;
				}
				.vitrin_ilan_gorsel
				{
					width:100%!important;
					height:120px;
					float:left;
					background-color:#dadada;
					background-size:cover;
					background-position:center;
					background-repeat:no-repeat;
					/* background-image:url('images/vitrin_default.png'); */
					background-image:url('images/default.png');
					display:flex;
					align-items:center;
					justify-content:center;
					overflow:hidden;
				}
				@media only screen and (max-width: 600px) {
					.vitrin_ilan_gorsel
					{
						height:200px;
					}
				}
				.vitrin_ilan_gorsel img
				{
					width: 100%!important;
					height: 100%;
					object-fit: cover;
				}
				.vitrin_marka
				{
					width:100%;
					min-height:10px;
					padding:20px 0px;
					float:left;
					display:flex;
					align-items:center;
					justify-content:center;
					font-weight:600;
				}
				.owl-stage-outer
				{
					padding-bottom:22px;
				}
				/*.vitrin_ilanlari .owl-item
				{
					border-bottom:5px solid orange;
				}*/
				.rotated {
					writing-mode: tb-rl;
					transform: rotate(360deg);
				}
			</style>
			<a href="#onay_modal" data-toggle="modal" id="onay_modal_ac"></a>
			<?php $sira2=0; $ihale_say2=mysql_num_rows($vitrin_cek);?>
			<input type="hidden" id="ihale_say2" value="<?=$ihale_say2 ?>" />	
			
		</div>
		<style>
			.homepage_custom_slider_outer
			{
				min-height:20px;
				padding:0px;
				float:left;
				background-color: #cecece;
			}
		</style>
	
		<div class="clearfix"></div>
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 homepage_custom_slider_outer">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 website_fullwidth_slider_outer" style="margin-top:0px;">
				<!-- <div class="website_fullwidth_slider_title">
					<a href="">Son Eklenen 200 Araç İçin Tıklayınız.</a>
				</div> -->
				<div class="website_fullwidth_slider_contnets_outer">
					<!-- <div class="website_fullwidth_slider_contents_left">
						<div class="website_fullwidth_slider_contents_left_title">
							SON EKLENENLER
						</div>
					</div> -->
					<div class="website_fullwidth_slider_contents_btn_outer">
						<div class="website_fullwidth_slider_contents_btn_left" id="fullwidth_slider_btn_left" style="background-color: #fff;"></div>
					</div>
					<div class="owl-carousel owl-theme website_fullwidth_slider_boxes_outer">
						<?= $son_eklenenler ?>
						<!-- <div>
							<div class="website_fullwidth_slider_box website_fullwidth_slider_box_orange">
								<div class="website_fullwidth_slider_box_title">
									<i class="fas fa-stopwatch"></i> 36 Gün 01:01:08
								</div>
								<div class="website_fullwidth_slider_box_image" style="background-image:url('https://ihale.pertdunyasi.com/images/et295824.png');"></div>
								<div class="website_fullwidth_slider_box_contents">
									<h3>2018 DACIA SANDERO</h3>
									<h4>En Yüksek</h4>
									<h5>42.400₺</h5>
								</div>
							</div>
						</div> -->
					</div>
					<div class="website_fullwidth_slider_contents_btn_outer">
						<div class="website_fullwidth_slider_contents_btn_right" id="fullwidth_slider_btn_right" style="background-color: #fff;"></div>
					</div>
				</div>
			</div>
		</div>
		<div class="clearfix"></div>
		<?php $ns_row=mysql_fetch_object(mysql_query("select * from nasil_calisir")); ?>
		<div class="site-section section-3" style="background-image: url('<?=$ns_row->resim ?>');">
			<div class="container">
				<div class="row">
					<div class="col-12 text-center mb-5">
						<h2 class="text-white"><?=$ns_row->baslik ?></h2>
					</div>
				</div>
				<div class="row">
					<?php $ns_sorgu=mysql_query("select * from nasil_calisir_menu order by id asc "); while($ns_row2=mysql_fetch_object($ns_sorgu)){ ?>
					<div class="col-lg-4">
						<div class="service-1">
							<span class="service-1-icon">
								<span class="flaticon-car-1"></span>
							</span>
							<div class="service-1-contents">
								<h3> <?=$ns_row2->baslik ?></h3>
								<p><?=$ns_row2->aciklama ?></p>
							</div>
						</div>
					</div>
					<?php } ?>
				</div>
			</div>
		</div>
		<style>
			.memnuniyet .owl-stage-outer .owl-stage .owl-item > div {
				cursor: pointer;
				margin: 0;
				transition: margin 0.4s ease;
			}
			.memnuniyet .owl-stage-outer .owl-stage .owl-item.center > div {
				cursor: auto;
				margin-top: 15%;
			}
			.memnuniyet .owl-stage-outer .owl-stage .owl-item:not(.center) > div:hover {
				opacity: .75;
			}

			.memnuniyet_ust
			{
				width: calc(100% + 60px);
				height: 45px;
				background-color: orange;
				float: left;
				margin-left: -30px;
				margin-top: -30px;
				margin-bottom: 30px;
				line-height:45px;
				color:#ffffff;
				padding:0px 10px;
			}

			.memnuniyet_ust span
			{
				float:right;
			}
		</style>

		<div class="site-section bg-light">
			<div class="container">
				<div class="row justify-content-center text-center mb-5">
					<div class="col-7 text-center mb-5">
						<h2>Memnuniyet</h2>
						<!--  <p>1960'larda Lorem Ipsum pasajları da içeren Letraset yapraklarının yayınlanması ile ve yakın zamanda Aldus
							PageMaker gibi Lorem Ipsum sürümleri içeren masaüstü yayıncılık yazılımları ile popüler olmuştur.</p>-->
					</div>
				</div>
				<div class="row">
					<div class="owl-carousel owl-theme memnuniyet">
					<?php $a_yorum=mysql_query("select * from yorumlar where durum=3 ");
						while($a_row=mysql_fetch_object($a_yorum)){
							$yorum_detay=mysql_query("select * from user where id='".$a_row->uye_id."'");
							$y_row=mysql_fetch_object($yorum_detay);

							$uye_adi = $y_row->ad;
							$uye_adi = trim($uye_adi);
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
								
							$ad=$y_row->ad;
							$parcala=explode(" ",$ad);
						
							$sayi=count($parcala)-1;
							$deneme=$parcala[0];
							$deneme2=$parcala[$sayi];
					
							$ad=substr($deneme,0,1)."***";
							$soyad=substr($deneme2,0,1)."***";
						?>
      
						<div class="testimonial-2 shadow">
							<div class="memnuniyet_ust">
								<i class="fas fa-car" aria-hidden="true"></i> <?= $a_row->arac_bilgileri ?>
								<span>
									<?= date('d.m.Y H:i:s', strtotime($a_row->yorum_zamani)) ?>
								</span>
							</div>
							<blockquote class="mb-4">
								<p><?=$a_row->yorum ?></p>
							</blockquote>
							<div class="d-flex v-card align-items-center">
								<span><?=$name_son ?></span>
							</div>
						</div>
			   
						<?php } ?>
					</div>
				</div>
			</div>
		</div>
		<style>
			.references
			{
				width:100%;
				height:120px;
				float:left;
				display:flex;
				align-items:center;
				justify-content:center;
				/* background-color: #fff; */
			}

			.references img
			{
				width:100%;
				height:100%;
				object-fit:contain;
			}
		</style>                 
		<div class="site-section bg-light" style="padding:20px 0px!important;">
			<div class="row">
				<div class="owl-carousel owl-theme alti_slider">
					<?php 
						$referans_cek=mysql_query("select * from referans where durum='1' order by id asc ");
						while($referans_row=mysql_fetch_object($referans_cek)){ ?>
							<div class="item">
								<div class="references">
									<img src="<?=$referans_row->resim?>">
								</div>
							</div>
					<?php } ?>
				</div>
			</div>
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
		<script src="js/main.js?v=<?php echo time(); ?>"></script>
		<script src="https://kit.fontawesome.com/2fdd899201.js" crossorigin="anonymous" ></script>
		<!-- Slick Slider -->
		<script type="text/javascript" src="slick_slider/slick/slick.min.js"></script>
		<script type="text/javascript" src="js/slick_slider.js?v=<?php echo time(); ?>"></script>
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

            $('.custom_mini_slider_boxes_contents').owlCarousel({
                margin:10,
                loop:true,
                items:1,
				autoplay:true,
				autoplayTimeout:2000,
				autoplayHoverPause:true
            })

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

			//set button id on click to hide first modal
			$("#fpass").on("click", function () {
				$('#exampleModal2').modal('hide');
			});
			//trigger next modal
			$("#fpass").on("click", function () {
				$('#exampleModal3').modal('show');
			});
		</script>

		<script>
			$( document ).ready(function() {
				var maxHeight = 0;
				$(".vitrin_marka").each(function(){
					if ($(this).height() > maxHeight) { maxHeight = $(this).height(); }
				});
				$(".vitrin_marka").height(maxHeight);
			});


			$('.alti_slider').owlCarousel({
				rewind:true,
				items : 6,
				loop: false,
				autoplay: true,
				autoplayTimeout: 2000,
				autoplayHoverPause: true,
				margin: 10,
				responsiveClass: true,
				responsive: {
					0: {
						items: 1,
					},
					600: {
						items: 2,
					},
					1000: {
						items: 3,
					}
				}
			})
		</script>

		<script>
			function isNumberKey(evt) {
				var charCode = (evt.which) ? evt.which : event.keyCode;
				if (charCode > 31 && (charCode < 48 || charCode > 57))
					return false;
				return true;
			}
		</script>

		<script>
			function phoneMask() { 
				var num = $(this).val().replace(/\D/g,''); 
				$(this).val(num.substring(0,1) + '(' + num.substring(1,4) + ')' + num.substring(4,7) + '-' + num.substring(7,11)); 
			}
			$('[type="tel"]').keyup(phoneMask);
		</script>

		<script language="javascript">
			function kontrol(){
				var reg=new RegExp("\[ÜĞŞÇÖğıüşöç]");
				if(reg.test(document.getElementById('email').value,reg)){
					alert('Email alanında türkçe karakter bulunmamalıdır.');
					document.getElementById('email').value="";
				}
			}
		</script>
		<script language="javascript">
			function KurumsalKontrol(){
				var reg=new RegExp("\[ÜĞŞÇÖğıüşöç]");
				if(reg.test(document.getElementById('kurumsal_mail').value,reg)){
					alert('Email alanında türkçe karakter bulunmamalıdır.');
					document.getElementById('kurumsal_mail').value="";
				}
			}
		</script>
		<script>     
			var ihale_say =document.getElementById('ihale_say');
			var ihale_say2 =document.getElementById('ihale_say2');
			function sure_doldu(id){
				jQuery.ajax({
					url: "https://ihale.pertdunyasi.com//check.php",
					type: "POST",
					dataType: "JSON",
					data: {
						action: "sure_doldu",
						id:id
					},
					success: function(response) {
						console.log(response);
						if (response.status == 200) {
							 //window.location="index.php";
							//$("#k_kayitol").attr("disabled", false);
							//$("#k_kayitol").css("display", "block");
						}else{

							//$("#k_kayitol").attr("disabled", true);
							//$("#k_kayitol").css("display", "none");
						}
					}
				});
			}
			function createCountDown(elementId,sira) {
				var zaman =document.getElementById("ihale_sayac"+sira).value;
				var id =document.getElementById("id_"+sira).value;
				var uzatilma_durumu =document.getElementById("sure_uzatilma_durumu_"+sira).value;
				var countDownDate = new Date(zaman).getTime();
				var belirlenen=document.getElementById("belirlenen_"+sira).value;
				var x = setInterval(function() {
					jQuery.ajax({
						url: "https://ihale.pertdunyasi.com//check.php",
						type: "POST",
						dataType: "JSON",
						data: {
							action: "panel_ilan_guncelle",
							kapanis_zamani: document.getElementById("ihale_sayac"+sira).value,
							ilan_id:id,
						},
						success: function(response) {
							if(response.ilan_status == 1 && response.user_package_status==true ){
								$(".en_yuksek_"+ilan_id).html(formatMoney(response.son_teklif)+" ₺");
							}else{
								$(".en_yuksek_"+ilan_id).html('<i style="color:#000" class="fas fa-lock"></i>');
							}
							console.log(document.getElementById("ihale_sayac"+sira).value);
							$("#ihale_sayac"+sira).val(response.ihale_tarihi);
							countDownDate=countDownDate+response.milisaniye; 	
							belirlenen=response.belirlenen;
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
							if (distance < 0) {
								sure_doldu(id);
								clearInterval(x);
								//document.getElementById(elementId).innerHTML = "Süre Doldu";   
							}
							if(hours<10){
								hours="0"+hours;
							}
							if(minutes<10){
								minutes="0"+minutes;
							}
							if(seconds<10){
								seconds="0"+seconds;
							}
							document.getElementById(elementId).innerHTML = " <i class='fas fa-stopwatch'></i>  " + "XX:XX:XX ";
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
							document.getElementById(elementId).innerHTML = " <i class='fas fa-stopwatch'></i>  " + days + " Gün " + hours + ":"+ minutes + ":" + seconds + " ";
						}
					}else{
						if (distance < 0) 
						{
							sure_doldu(id);
							clearInterval(x);
							//document.getElementById(elementId).innerHTML = "Süre Doldu";   
							
						}
						if(belirlenen>0){
							document.getElementById(elementId).innerHTML = " <i class='fas fa-stopwatch'></i>  " + "XX:XX:XX ";
						}else{
							document.getElementById(elementId).innerHTML = " <i class='fas fa-stopwatch'></i>  " + "Süre Doldu";   
						}
					}
					/*var now = new Date().getTime();
					var distance = (countDownDate) - (now);
					var days = Math.floor(distance / (1000 * 60 * 60 * 24));
					var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
					if(hours<10){
						hours="0"+hours;
					}
					var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
					if(minutes<10){
						minutes="0"+minutes;
					}
					var seconds = Math.floor((distance % (1000 * 60)) / 1000);
					if(seconds<10){
						seconds="0"+seconds;
					}
					if(days>=0 && hours>=0 && minutes>=0 && seconds >= 0){
						if(days<=0 && hours<=0 && minutes<3){
							jQuery.ajax({
								url: "https://ihale.pertdunyasi.com//check.php",
								type: "POST",
								dataType: "JSON",
								data: {
									action: "otomatik_sure_uzat",
									id:id
								},
								success: function(response) {
									console.log(response);
									if(response.status==200){
										countDownDate=countDownDate+120000; 
									}
								}
							});
							
							
							if(days<=0 && hours<=0 && minutes<2 ){
								document.getElementById(elementId).innerHTML = "XX:XX:XX ";
							}else{
								document.getElementById(elementId).innerHTML =  " <i class='fas fa-stopwatch'></i>  "+ days + " Gün " + hours + ":"+ minutes + ":" + seconds + " ";
							}
						}else{
							document.getElementById(elementId).innerHTML = " <i class='fas fa-stopwatch'></i>  " + days + " Gün " + hours + ":"+ minutes + ":" + seconds + " ";
						}
					}*/
					if (distance < 0) 
					{
						sure_doldu(id);
						clearInterval(x);
						//document.getElementById(elementId).innerHTML = "Süre Doldu";   
					}
				}, 1000);
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
   				url: "https://ihale.pertdunyasi.com//check.php",
   				type: "POST",
   				dataType: "JSON",
   				data: {
   					action: "panel_ilan_guncelle",
   					kapanis_zamani: document.getElementById("ihale_sayac2_"+sira).value,
   					ilan_id:id2,
   				},
   				success: function(response) {
					if(response.ilan_status == 1 && response.user_package_status == true ){
						$(".en_yuksek_"+id2).html(formatMoney(response.son_teklif)+" ₺");
					}else{
						$(".en_yuksek_"+id2).html('<i style="color:#000" class="fas fa-lock"></i>');
					}
   					
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
			
			for (var i = 0; i < ihale_say.value; i++) {
				createCountDown("sayac"+i,i);
			}
			for (var m = 0; m < ihale_say2.value; m++) {
				createCountDown2("sayac2_"+m,m);
			} 
			
		</script>
		<!-- <script> localStorage.setItem('Onay',1);</script> -->
		<script>
			 function formatMoney(n) {
				var n= (Math.round(n * 100) / 100).toLocaleString();
				n=n.replaceAll(',', '.')
				return n;
			}
			function otomatik_sure_uzat(id,sira){
				var durum=false;
				jQuery.ajax({
					url: "https://ihale.pertdunyasi.com//check.php",
					type: "POST",
					dataType: "JSON",
					data: {
						action: "otomatik_sure_uzat",
						id:id
					},
					success: function(response) {
						if(status==200){
							durum= true;
						}
						//createCountDown("sayac"+sira,sira)=;
					}
				});
				return durum;
			}
			function ihale_arttir(id){
				jQuery.ajax({
					url: "https://ihale.pertdunyasi.com//check.php",
					type: "POST",
					dataType: "JSON",
					data: {
						action: "ihale_arttir",
						ilan_id:id,
						ip:document.getElementById("ip").value,
					},
					success: function(response) {
						console.log(response);
					}
				});
			}
			function dogrudan_arttir(id){
				jQuery.ajax({
					url: "https://ihale.pertdunyasi.com//check.php",
					type: "POST",
					dataType: "JSON",
					data: {
						action: "dogrudan_arttir",
						ilan_id:id,
						ip:document.getElementById("ip").value,
					},
					success: function(response) {
						console.log(response);
					}
				});
			}
		</script>
		<script src="js/cikis_yap.js?v=<?php echo time(); ?>"></script>
		<script>
			setInterval(function() {
				cikis_yap("<?=$uye_token?>");
			}, 300001);
			son_islem_guncelle("<?=$uye_token?>");
			setInterval(function(){ bildirim_sms(); }, 1000);
		</script>
		<script>
			function sifreSifirla(){
				var hatirlatilacak_mail = document.getElementById('sifremi_unuttum_mail').value;
				if (hatirlatilacak_mail !=="") {
					$.ajax({
						url:"sifre_sifirla.php",
						type:"POST",
						cache:false,
						data:{hatirlatilacak_mail:hatirlatilacak_mail},
						success:function(data){
							alert("Yeni şifreniz mail adresinize iletildi.");
							window.location.href = 'index.php';
						}  
					});
				}else{
					alert("Hata! Lütfen Tekrar Deneyin.");
				}
			}
		</script>

		<script>
			/*
			  function bilgi_yenile(){
				$.ajax({
					url: 'check.php',
					method: 'post',
					dataType: "json",
					data: {
						action:"bilgi_yenile",
					},
					success: function(data) {            
						$.each(data.ilan_bilgileri, function( key, value ) {
							$("#uye_bilgi_"+value.ilan_id).html(value.uye_ilan_bilgileri);
							$("#modal_uye_bilgi_"+value.ilan_id).html(value.uye_ilan_bilgileri);
							if(value.ilan_status == 1 && value.user_package_status==true ){
								$(".en_yuksek_"+value.ilan_id).html(formatMoney(value.son_teklif)+" ₺");
							}else{
								$(".en_yuksek_"+value.ilan_id).html('<i style="color:#000" class="fas fa-lock"></i>');
							}
						});
					}
				});
			}
			setInterval(function(){ bilgi_yenile(); }, 1000);
			*/
		</script>
		
		<?php include "footer.php" ?>
	</body>
</html>
<?php include "modal.php"; ?>