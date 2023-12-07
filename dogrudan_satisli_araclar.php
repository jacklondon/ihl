<?php 
	session_start();
	include 'ayar.php';
	$update=mysql_query("update dogrudan_satisli_ilanlar set durum=-1 where bitis_tarihi < '".date("Y-m-d H:i:s")."'");
	$token = $_SESSION['u_token'];
	$k_token = $_SESSION['k_token'];
	if(!empty($token)){
		$uye_token = $token;
	}elseif(!empty($k_token)){
		$uye_token = $k_token;
	}
	$ihale_cek = mysql_query("SELECT * FROM dogrudan_satisli_ilanlar WHERE durum = '1' AND bitis_tarihi > '".$bugun."' order by id desc");
?>
<?php 
   // Sayfalama
		if (isset($_GET['sayfa'])) {
			$sayfa = $_GET['sayfa'];
		} else {
			$sayfa = 1;
          }
		$sayfada = 100;
		$offset = ($sayfa-1) * $sayfada;
		$bugun = date("Y-m-d");
		$toplam_sayfa_sql = mysql_query("SELECT COUNT(*) FROM dogrudan_satisli_ilanlar WHERE durum = 1");
		$toplam_ihale = mysql_fetch_array($toplam_sayfa_sql)[0];
		$toplam_sayfa = ceil($toplam_ihale / $sayfada);
   
		$sql = mysql_query("SELECT * FROM dogrudan_satisli_ilanlar WHERE durum = 1 AND bitis_tarihi > '".$bugun."'  ORDER BY eklenme_tarihi desc, eklenme_saati desc LIMIT $offset, $sayfada");
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
				<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">

		<link rel="stylesheet" href="css/bootstrap-datepicker.css">
		<link rel="stylesheet" href="css/jquery.fancybox.min.css">
		<link rel="stylesheet" href="css/owl.carousel.min.css">
		<link rel="stylesheet" href="css/owl.theme.default.min.css">
		<link rel="stylesheet" href="fonts/flaticon/font/flaticon.css">
		<link rel="stylesheet" href="css/aos.css">
		<!-- MAIN CSS -->
		<link rel="stylesheet" href="css/style.css?v=<?=time() ?>">
		<link rel="stylesheet" href="css/custom.css">
		<link rel="stylesheet" href="css/ihaledekiler.css">
		<link rel="stylesheet" href="css/dogrudan_satisli.css">
		   <link rel="stylesheet" type="text/css" href="js/toastr/toastr.css" rel="stylesheet">
	  	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.js"></script>
		<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
		<style>
			.ilanlar_ust_alan
			{
				width:100%;
				min-height:10px;
				float:left;
			}
			.ust_filtre_baslik
			{
				min-width:10px;
				height:25px;
				float:left;
				line-height:25px;
				font-size:14px;
				font-weight:600;
				padding:0px 10px;
			}
			.ust_filte_kutu
			{
				min-width:10px;
				height:25px;
				float:left;
				line-height:25px;
				font-size:12px;
				padding:0px 0px 5px 5px;
				margin:0px 3px;
				background-color:#eeeeee;
				border-radius:2px;
			}

			.ust_filte_kutu i
			{
				color:orange;
				cursor:pointer;
			}

			.ilanlar_ust_alan p
			{
				width:100%;
				float:left;
				font-size:12px;
				margin-top:5px;
				margin-bottom:5px;
				color:blue;
			}
		</style>
		<style>
			.ihale ul{
				height:400px;
				width:100%;
				list-style-type:none; 
			}
			.ihale ul{
				overflow:hidden; 
				overflow-y:scroll;
			}
			.list-group-item{
				background: rgb(28, 1, 102);
				color: rgb(255, 255, 255);
			}
			.list-group-item:hover{ 
				background: rgb(5, 22, 39);
				color: rgb(255, 255, 255);
			}
		</style>
		<style>
			.filter_outer
			{
				width:100%;
				min-height:10px;
				float:left;
				margin-bottom:20px;
			}
			.filter_title_outer
			{
				width: 100%;
				min-height: 10px;
				float: left;
				font-weight: 700;
				padding:5px;
			}

			.filter_check_outer
			{
				width:100%;
				min-height:10px;
				float:left;
			}

			.filter_check_box
			{
				min-height:10px;
				float:left;
				padding:5px;
				font-weight: 600 !important;
			}

			.filter_check_box input[type=checkbox]
			{
				float: left;
				margin: 5px;
				margin-left: 0px;
			}

			.filter_check_box input[type=text]
			{
				width:100%;
				height:35px;
				background-color:#ffffff!important;
			}

			.filter_check_box input[type=search]
			{
				width:100%;
				height:35px;
				background-color:#ffffff!important;
			}

			@media only screen and (max-width: 600px) 
			{
				.filter_check_box
				{
					width:100%!important;
				}
			}
			.filtre_cikart_buton{
				height: 25px;
				color: red;
				border-color: red;
				float: right;
				margin-left: 5px;
				padding: 0 5px 5px 5px;
				text-align: center
			}
		</style>
	</head>
	<body data-spy="scroll" data-target=".site-navbar-target" data-offset="300">
		<?php
			include 'modal.php';
			include 'alert.php';
			$sehir_cek = mysql_query("SELECT * FROM sehir"); 
			$marka_cek = mysql_query("SELECT * FROM marka"); 
			if(!empty($uye_token)){
				$tk = $uye_token;
			}elseif(!empty($kurumsal_token)){
				$tk = $kurumsal_token;
			}
		?>
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

	<script>
		var expanded = false;
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
		function showModeller() {
			var checkboxes = document.getElementById("modeller");
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
		function showVites() {
			var checkboxes = document.getElementById("vites");
			if (!expanded) {
				checkboxes.style.display = "block";
				expanded = true;
			} else {
				checkboxes.style.display = "none";
				expanded = false;
			}
		}
		function showYakit() {
			var checkboxes = document.getElementById("yakit");
			if (!expanded) {
				checkboxes.style.display = "block";
				expanded = true;
			} else {
				checkboxes.style.display = "none";
				expanded = false;
			}
		}
		function showHasar() {
			var checkboxes = document.getElementById("hasar");
			if (!expanded) {
				checkboxes.style.display = "block";
				expanded = true;
			} else {
				checkboxes.style.display = "none";
				expanded = false;
			}
		}
	</script>           
	<div class="site-section" >
		<div style="width: calc(94%); margin-left: calc(3%);" class="">
			<div style="margin-top: 2%;" class="row">
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
						<!--  <div class="form-group">
                           <h5>Kelime ile ara</h5>
                           <input type="search" name="aranan" class="form-control" placeholder="Plaka, araç kodu vb..">
                        </div>-->
                        <div class="filter_outer">
							<div class="filter_title_outer">
								Markaya Göre
							</div>
							<?php 
								$seciliMarkaSayisi = count($_POST['marka']);
								if($seciliMarkaSayisi!=0){
									$marka_array=array();
									$tu = 0;
									while($marka_oku = mysql_fetch_array($marka_cek)){
										$marka_say = mysql_query("SELECT * FROM dogrudan_satisli_ilanlar WHERE durum = 1 AND marka = '".$marka_oku['marka_adi']."'");
										$marka_sayi = mysql_num_rows($marka_say);
										$marka_array[$tu]="";
										for($i=0;$i<count($_POST["marka"]);$i++){
											if($marka_oku["marka_adi"]==$_POST["marka"][$i]){
												$marka_array[$tu]="checked";
											}
										} ?>
										<div class="filter_check_box" style="width:calc(100% / 2);<?php if($marka_sayi == 0){ echo "display: none;"; } ?>">
											<!-- <input <?=$marka_array[$tu] ?> type="checkbox" id="marka_<?= $marka_oku['markaID'] ?>" name="marka[]" onclick="modelGetir('<?= $marka_oku['markaID'] ?>')" value="<?= $marka_oku['marka_adi'] ?>" /><?= $marka_oku['marka_adi']." ".$marka_sayi ?> -->
											<input <?=$marka_array[$tu] ?> type="checkbox" id="marka_<?= $marka_oku['marka_adi'] ?>" name="marka[]" onclick="modelGetir('<?= $marka_oku['markaID'] ?>')" value="<?= $marka_oku['marka_adi'] ?>" /><?= $marka_oku['marka_adi']." ".$marka_sayi ?>
										</div>     
								<?php  $tu++; }
								}else{ ?>
									<div class="filter_check_outer">
										<?php while($marka_oku = mysql_fetch_array($marka_cek)){
											$marka_say = mysql_query("SELECT * FROM dogrudan_satisli_ilanlar WHERE durum = 1 AND marka = '".$marka_oku['marka_adi']."'");
											$marka_sayi = mysql_num_rows($marka_say);
										?>       
											<div class="filter_check_box" style="width:calc(100% / 2);<?php if($marka_sayi == 0){ echo "display: none;"; } ?>">
												<input type="checkbox" id="marka_<?= $marka_oku['markaID'] ?>" name="marka[]" onclick="modelGetir('<?= $marka_oku['markaID'] ?>')" value="<?= $marka_oku['marka_adi'] ?>" /><?= $marka_oku['marka_adi']." ".$marka_sayi ?>
											</div>        
										<?php } ?>
									</div>
								<?php } ?>

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
						
											$model_cek=mysql_query("select * from model where marka_adi='".$_POST["marka"][$tu2]."'");
											while($model_oku=mysql_fetch_array($model_cek)){
												$model_say=mysql_query("select * from dogrudan_satisli_ilanlar where marka='".$_POST["marka"][$tu2]."' and model='".$model_oku["model_adi"]."' and durum=1");
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
											$sehir_say = mysql_query("SELECT * FROM dogrudan_satisli_ilanlar WHERE sehir = '".$sehir_oku['sehiradi']."' and durum=1");
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
										$sehir_say = mysql_query("SELECT * FROM dogrudan_satisli_ilanlar WHERE sehir = '".$sehir_oku['sehiradi']."' and durum=1");
										$sehir_sayi = mysql_num_rows($sehir_say);
									?>
										 <div class="filter_check_box" style="width:calc(100% / 2); <?php if($sehir_sayi == 0){ echo "display: none;"; } ?>">
											 <input type="checkbox" name="sehir[]" id="sehir_<?=$sehir_oku['sehiradi'] ?>" value="<?= $sehir_oku['sehiradi'] ?>" /><?= $sehir_oku['sehiradi']." ".$sehir_sayi ?>
										</div>        
									<?php } } ?>
									
								<?php /* while($sehir_oku = mysql_fetch_array($sehir_cek)){
									$sehir_say = mysql_query("SELECT * FROM dogrudan_satisli_ilanlar WHERE durum = 1 AND sehir = '".$sehir_oku['sehiradi']."'");
									$sehir_sayi = mysql_num_rows($sehir_say);
								?>       
									<div class="filter_check_box" style="width:calc(100% / 2);<?php if($sehir_sayi == 0){ echo "display: none;"; } ?>">
										<input type="checkbox" name="sehir[]"  value="<?= $sehir_oku['sehiradi'] ?>" /><?= $sehir_oku['sehiradi']." ".$sehir_sayi  ?>
									</div>        
								<?php } */ ?>
							</div>
                        </div>
                        <div class="filter_outer">
							<div class="filter_title_outer">
								Tarihe Göre
							</div>
							<div class="filter_check_outer">
								<?php 
									$bugun = date("Y-m-d");
									$yarin = date("Y.m.d",strtotime('+1 days'));
									$bugun_biten = mysql_query("SELECT * FROM dogrudan_satisli_ilanlar WHERE durum = 1 AND DATE(bitis_tarihi) = '".$bugun."' ");
									$bugun_bitenler = mysql_num_rows($bugun_biten);                              
									$yarin_biten = mysql_query("SELECT * FROM dogrudan_satisli_ilanlar WHERE durum = 1 AND DATE(bitis_tarihi) = '".$yarin."'");
									$yarin_bitenler = mysql_num_rows($yarin_biten);
									
									
									$seciliKapanisSayisi = count($_POST['tarih']);
									if($seciliKapanisSayisi!=0){ 
										$kapanis_check=array();
										$tu = 0;
										$ilan_tarihleri=mysql_query("select *,count(id) as ihale_sayisi from dogrudan_satisli_ilanlar where durum=1 group by bitis_tarihi");
										while($ilan_tarihleri_oku=mysql_fetch_array($ilan_tarihleri)){
											$bitis_tarih_dzn=date("Y-m-d",strtotime($ilan_tarihleri_oku["bitis_tarihi"]));
											$tarih="";
											$kapanis_check[$tu]="";
											for($i=0;$i<count($_POST['tarih']);$i++){ 
												if($bitis_tarih_dzn==$_POST["tarih"][$i]){
													$kapanis_check[$tu]="checked";
												}
											} 
											if($bitis_tarih_dzn==date("Y-m-d")){
												$tarih="Bugün";
											}else if($bitis_tarih_dzn==date("Y-m-d", strtotime("+1 day"))){
												$tarih="Yarın";
											}else{
												$tarih=date("d-m-Y",strtotime($bitis_tarih_dzn));
											}
											?>
											<div class="filter_check_box" style="width:calc(100% / 3); <?php if($ilan_tarihleri_oku["ihale_sayisi"] == 0){ echo "display: none;"; } ?>">
												<input <?=$kapanis_check[$tu]?> type="checkbox" name="tarih[]" id="tarih_<?=$bitis_tarih_dzn ?>" value="<?=$bitis_tarih_dzn ?>" /><?=$tarih ?> (<?= $ilan_tarihleri_oku["ihale_sayisi"] ?>)
											</div>
										<?php 
										$tu++; }
									}else{ 
											$ilan_tarihleri=mysql_query("select *,count(id) as ihale_sayisi from dogrudan_satisli_ilanlar where durum=1 group by bitis_tarihi");
											while($ilan_tarihleri_oku=mysql_fetch_array($ilan_tarihleri)){
												$bitis_tarih_dzn=date("Y-m-d",strtotime($ilan_tarihleri_oku["bitis_tarihi"]));
												$tarih="";
												if($bitis_tarih_dzn==date("Y-m-d")){
													$tarih="Bugün";
												}else if($bitis_tarih_dzn==date("Y-m-d", strtotime("+1 day"))){
													$tarih="Yarın";
												}else{
													$tarih=date("d-m-Y",strtotime($bitis_tarih_dzn));
												}
												?>
												<div class="filter_check_box" style="width:calc(100% / 3); <?php if($ilan_tarihleri_oku["ihale_sayisi"] == 0){ echo "display: none;"; } ?>">
													<input type="checkbox" name="tarih[]" id="tarih_<?=$bitis_tarih_dzn ?>" value="<?=$bitis_tarih_dzn ?>" /><?=$tarih ?> (<?= $ilan_tarihleri_oku["ihale_sayisi"] ?>)
												</div>
											<?php 
											}
										?>

									<?php }  ?>
								<!--<div class="filter_check_box" style="width:calc(100% / 2);<?php if($bugun_bitenler == 0){ echo "display: none;"; } ?>">
									<input type="checkbox" name="tarih[]" value=" <?= date('Y-m-d') ?>" />Bugün Bitenler <?= $bugun_bitenler ?>
								</div>
								<div class="filter_check_box" style="width:calc(100% / 2);">
									<input type="checkbox" name="tarih[]" value="<?= date("Y-m-d", strtotime("+1 day")) ?>" />Yarın Bitenler <?= $yarin_bitenler ?>
								</div> -->
							</div>
                        </div>
                        <div class="filter_outer">
							<div class="filter_title_outer">
								Profile Göre
							</div>
							<div class="filter_check_outer">
								<?php 
									$cekme_pert_say = mysql_query("SELECT * FROM dogrudan_satisli_ilanlar WHERE durum = 1 AND evrak_tipi = 'Çekme Belgeli/Pert Kayıtlı'");
									$cekme_say = mysql_query("SELECT * FROM dogrudan_satisli_ilanlar WHERE durum = 1 AND evrak_tipi = 'Çekme Belgeli'");
									$hurda_say = mysql_query("SELECT * FROM dogrudan_satisli_ilanlar WHERE durum = 1 AND evrak_tipi = 'Hurda Belgeli'");
									$plakali_say = mysql_query("SELECT * FROM dogrudan_satisli_ilanlar WHERE durum = 1 AND evrak_tipi = 'Plakalı'");
									$plakali_ruhsatli_say = mysql_query("SELECT * FROM dogrudan_satisli_ilanlar WHERE durum = 1 AND evrak_tipi = 'Plakalı Ruhsatlı'");
									$cekme_pertler = mysql_num_rows($cekme_pert_say);
									$cekmeliler = mysql_num_rows($cekme_say);
									$hurdalar = mysql_num_rows($hurda_say);
									$plakalilar = mysql_num_rows($plakali_say);
									$plakali_ruhsatlilar = mysql_num_rows($plakali_say);
								$seciliProfilSayisi = count($_POST['profil']);
									
									if($seciliProfilSayisi!=0){ 
										$pert_checked="";
										$cekme_checked="";
										$hurda_checked="";
										$plakalilar_checked="";
										$plakali_ruhsatlilar_checked="";

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
											if($_POST["profil"][$i]=="Plakalı Ruhsatlı"){
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
										<?php if($plakali_ruhsatlilar_checked=="checked"){ ?>
											<div class="filter_check_box" style="width:calc(100% / 1); <?php if($plakali_ruhsatlilar == 0){ echo "display: none;"; } ?>">
												<input checked type="checkbox" name="profil[]" id="profil_plakaliruhsatli" value="Plakalı Ruhsatlı" />Plakalı Ruhsatlı <?= $plakali_ruhsatlilar ?>
											</div>
										<?php }else{ ?>
											<div class="filter_check_box" style="width:calc(100% / 1); <?php if($plakali_ruhsatlilar == 0){ echo "display: none;"; } ?>">
												<input type="checkbox" name="profil[]" id="profil_plakaliruhsatli" value="Plakalı Ruhsatlı" />Plakalı Ruhsatlı <?= $plakali_ruhsatlilar ?>
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
										 <div class="filter_check_box" style="width:calc(100% / 1);<?php if($plakali_ruhsatlilar == 0){ echo "display: none;"; } ?>">
											<input type="checkbox" name="profil[]" id="profil_plakali"  value="Plakalı Ruhsatlı" />Plakalı Ruhsatlı <?= $plakali_ruhsatlilar ?>
										</div>
								<?php }  ?>                              
								<!--<div class="filter_check_box" style="width:calc(100% / 1);<?php if($cekme_pertler == 0){ echo "display: none;"; } ?>">
									<input type="checkbox" name="profil[]" value="Çekme Belgeli/Pert Kayıtlı" />Çekme Belgeli/Pert Kayıtlı <?= $cekme_pertler ?>
								</div>
								<div class="filter_check_box" style="width:calc(100% / 1);<?php if($cekmeliler == 0){ echo "display: none;"; } ?>">
									<input type="checkbox" name="profil[]" value="Çekme Belgeli" />Çekme Belgeli <?= $cekmeliler ?>
								</div>
								<div class="filter_check_box" style="width:calc(100% / 1);<?php if($hurdalar == 0){ echo "display: none;"; } ?>">
									<input type="checkbox" name="profil[]" value="Hurda Belgeli"  />Hurda Belgeli <?= $hurdalar ?>
								</div>
								<div class="filter_check_box" style="width:calc(100% / 1);<?php if($plakalilar == 0){ echo "display: none;"; } ?>">
                                    <input type="checkbox" name="profil[]"  value="Plakalı" />Plakalı <?= $plakalilar ?>
								</div>
								<div class="filter_check_box" style="width:calc(100% / 1);<?php if($plakali_ruhsatli == 0){ echo "display: none;"; } ?>">
                                    <input type="checkbox" name="profil[]" value="Plakalı Ruhsatlı" />Plakalı Ruhsatlı <?= $plakali_ruhsatlilar ?>
								</div>-->
							</div>
                        </div>         
                        <div class="filter_outer">
							<div class="filter_title_outer">
								Vites Tipine Göre
							</div>
							<div class="filter_check_outer">
								<?php 
									$duz_say = mysql_query("SELECT * FROM dogrudan_satisli_ilanlar WHERE durum = 1 AND vites_tipi = 'Düz Vites'");
                                    $otomatik_say = mysql_query("SELECT * FROM dogrudan_satisli_ilanlar WHERE durum = 1 AND vites_tipi = 'Otomatik Vites'");
                                    $duzler = mysql_num_rows($duz_say);
                                    $otomatikler = mysql_num_rows($otomatik_say);		
									$seciliVitesSayisi = count($_POST['vites']);
									if($seciliVitesSayisi!=0){ 
										$duz_checked="";
										$oto_checked="";

										for($i=0;$i<count($_POST["vites"]);$i++){
											if($_POST["vites"][$i]=="Düz Vites"){
												$duz_checked="checked";
											}
											if($_POST["vites"][$i]=="Otomatik Vites"){
												$oto_checked="checked";
											}	
										}?>
										
										<?php if($duz_checked=="checked"){ ?>
											<div class="filter_check_box" style="width:calc(100% / 1); <?php if($duzler == 0){ echo "display: none;"; } ?>">
												<input checked type="checkbox" name="vites[]"  id="vites_duz" value="Düz Vites" />Düz Vites <?= $duzler ?>
											</div>
										<?php }else{ ?>
											<div class="filter_check_box" style="width:calc(100% / 1); <?php if($duzler == 0){ echo "display: none;"; } ?>">
												<input  type="checkbox" name="vites[]"  id="vites_duz" value="Düz Vites" />Düz Vites <?= $duzler ?>
											</div>
										<?php }?>
										
										<?php if($oto_checked=="checked"){ ?>
											<div class="filter_check_box" style="width:calc(100% / 1); <?php if($otomatikler == 0){ echo "display: none;"; } ?>">
												<input checked type="checkbox" name="vites[]" id="vites_oto" value="Otomatik Vites" />Otomatik Vites <?= $otomatikler ?>
											</div>
										<?php }else{ ?>
											<div class="filter_check_box" style="width:calc(100% / 1); <?php if($otomatikler == 0){ echo "display: none;"; } ?>">
												<input type="checkbox" name="vites[]" id="vites_oto" value="Otomatik Vites" />Otomatik Vites <?= $otomatikler ?>
											</div>
										<?php }?>
									
										
									<?php }else{ ?>
										 <div class="filter_check_box" style="width:calc(100% / 1); <?php if($duzler == 0){ echo "display: none;"; } ?>">
											<input type="checkbox" name="vites[]" id="vites_duz" value="Düz Vites" />Düz Vites <?= $duzler ?>
										 </div>
										 <div class="filter_check_box" style="width:calc(100% / 1); <?php if($otomatikler == 0){ echo "display: none;"; } ?>">
											<input type="checkbox" name="vites[]" id="vites_oto" value="Otomatik Vites" />Otomatik Vites <?= $otomatikler ?>
										 </div>
								<?php }  ?>                              
								<!-- <div class="filter_check_box" style="width:calc(100% / 1);<?php if($duzler == 0){ echo "display: none;"; } ?>">
									<input type="checkbox" name="vites[]" value="Düz Vites" />Düz Vites <?= $duzler ?>
								</div>
								<div class="filter_check_box" style="width:calc(100% / 1);<?php if($otomatikler == 0){ echo "display: none;"; } ?>">
									<input type="checkbox" name="vites[]" value="Otomatik Vites" />Otomatik Vites <?= $otomatikler ?>
								</div> -->
							</div>
                        </div>                 
                        <div class="filter_outer">
							<div class="filter_title_outer">
								Yakıt Tipine Göre
							</div>
							<div class="filter_check_outer">
								<?php 
									$benzinli = mysql_query("SELECT * FROM dogrudan_satisli_ilanlar WHERE durum = 1 AND yakit_tipi = 'Benzinli'");
                                    $dizel = mysql_query("SELECT * FROM dogrudan_satisli_ilanlar WHERE durum = 1 AND yakit_tipi = 'Dizel'");
                                    $lpg = mysql_query("SELECT * FROM dogrudan_satisli_ilanlar WHERE durum = 1 AND yakit_tipi = 'Benzin+Lpg'");
                                    $hibrit = mysql_query("SELECT * FROM dogrudan_satisli_ilanlar WHERE durum = 1 AND yakit_tipi = 'Hybrit'");
                                    $eklektrikli = mysql_query("SELECT * FROM dogrudan_satisli_ilanlar WHERE durum = 1 AND yakit_tipi = 'Elektrikli'");
									
                                    $benzinliler = mysql_num_rows($benzinli);
                                    $dizeller = mysql_num_rows($dizel);
                                    $lpgliler = mysql_num_rows($lpg);
                                    $hibritler = mysql_num_rows($hibrit);
                                    $elektrikliler = mysql_num_rows($eklektrikli);
									$seciliYakitSayisi = count($_POST['yakit']);
									if($seciliYakitSayisi!=0){ 
										$benzin_checked="";
										$dizel_checked="";
										$lpg_checked="";
										$hybrit_checked="";
										$elektrikli_checked="";
										for($i=0;$i<count($_POST["yakit"]);$i++){
											
											if($_POST["yakit"][$i]=="Benzinli"){
												$benzin_checked="checked";
											}
											if($_POST["yakit"][$i]=="Dizel"){
												$dizel_checked="checked";
											}	
											if($_POST["yakit"][$i]=="Benzin+Lpg"){
												$lpg_checked="checked";
											}										
											if($_POST["yakit"][$i]=="Hybrit"){
												$hybrit_checked="checked";
											}									
											if($_POST["yakit"][$i]=="Elektrikli"){
												$elektrikli_checked="checked";
											}
										}?>
										
										<?php if($benzin_checked=="checked"){ ?>
											<div class="filter_check_box" style="width:calc(100% / 1); <?php if($benzinliler == 0){ echo "display: none;"; } ?>">
												<input checked type="checkbox" name="yakit[]"  id="yakit_benzinli" value="Benzinli" />Benzinli <?= $benzinliler ?>
											</div>
										<?php }else{ ?>
											<div class="filter_check_box" style="width:calc(100% / 1); <?php if($benzinliler == 0){ echo "display: none;"; } ?>">
												<input  type="checkbox" name="yakit[]"  id="yakit_benzinli" value="Benzinli" />Benzinli <?= $benzinliler ?>
											</div>
										<?php }?>

										<?php if($dizel_checked=="checked"){ ?>
											<div class="filter_check_box" style="width:calc(100% / 1); <?php if($dizeller == 0){ echo "display: none;"; } ?>">
												<input checked type="checkbox" name="yakit[]"  id="yakit_dizel" value="Dizel" />Dizel <?= $dizeller ?>
											</div>
										<?php }else{ ?>
											<div class="filter_check_box" style="width:calc(100% / 1); <?php if($dizeller == 0){ echo "display: none;"; } ?>">
												<input  type="checkbox" name="yakit[]"  id="yakit_dizel" value="Dizel" />Dizel <?= $dizeller ?>
											</div>
										<?php }?>
										
										<?php if($lpg_checked=="checked"){ ?>
											<div class="filter_check_box" style="width:calc(100% / 1); <?php if($lpgliler == 0){ echo "display: none;"; } ?>">
												<input checked type="checkbox" name="yakit[]"  id="yakit_lpg" value="Benzin+Lpg" />Benzin+Lpg <?= $lpgliler ?>
											</div>
										<?php }else{ ?>
											<div class="filter_check_box" style="width:calc(100% / 1); <?php if($lpgliler == 0){ echo "display: none;"; } ?>">
												<input  type="checkbox" name="yakit[]"  id="yakit_lpg" value="Benzin+Lpg" />Benzin+Lpg <?= $lpgliler ?>
											</div>
										<?php }?>
										
										<?php if($hybrit_checked=="checked"){ ?>
											<div class="filter_check_box" style="width:calc(100% / 1); <?php if($hibritler == 0){ echo "display: none;"; } ?>">
												<input checked type="checkbox" name="yakit[]"  id="yakit_hybrit" value="Hybrit" />Hybrit <?= $hibritler ?>
											</div>
										<?php }else{ ?>
											<div class="filter_check_box" style="width:calc(100% / 1); <?php if($hibritler == 0){ echo "display: none;"; } ?>">
												<input  type="checkbox" name="yakit[]"  id="yakit_hybrit" value="Hybrit" />Hybrit <?= $hibritler ?>
											</div>
										<?php }?>
										
										<?php if($elektrikli_checked=="checked"){ ?>
											<div class="filter_check_box" style="width:calc(100% / 1); <?php if($elektrikliler == 0){ echo "display: none;"; } ?>">
												<input checked type="checkbox" name="yakit[]"  id="yakit_elektrik" value="Elektrikli" />Elektrikli <?= $elektrikliler ?>
											</div>
										<?php }else{ ?>
											<div class="filter_check_box" style="width:calc(100% / 1); <?php if($elektrikliler == 0){ echo "display: none;"; } ?>">
												<input  type="checkbox" name="yakit[]"  id="yakit_elektrik" value="Elektrikli" />Elektrikli <?= $elektrikliler ?>
											</div>
										<?php }?>
									
									
									<?php }else{ ?>
										<div class="filter_check_box" style="width:calc(100% / 1); <?php if($benzinliler == 0){ echo "display: none;"; } ?>">
											<input  type="checkbox" name="yakit[]"  id="yakit_benzinli" value="Benzinli" />Benzinli <?= $benzinliler ?>
										</div>
										 <div class="filter_check_box" style="width:calc(100% / 1); <?php if($dizeller == 0){ echo "display: none;"; } ?>">
											<input  type="checkbox" name="yakit[]"  id="yakit_dizel" value="Dizel" />Dizel <?= $dizeller ?>
										</div>
										<div class="filter_check_box" style="width:calc(100% / 1); <?php if($lpgliler == 0){ echo "display: none;"; } ?>">
											<input  type="checkbox" name="yakit[]"  id="yakit_lpg" value="Benzin+Lpg" />Benzin+Lpg <?= $lpgliler ?>
										</div>
										<div class="filter_check_box" style="width:calc(100% / 1); <?php if($hibritler == 0){ echo "display: none;"; } ?>">
											<input  type="checkbox" name="yakit[]"  id="yakit_hybrit" value="Hybrit" />Hybrit <?= $hibritler ?>
										</div>
										<div class="filter_check_box" style="width:calc(100% / 1); <?php if($elektrikliler == 0){ echo "display: none;"; } ?>">
											<input  type="checkbox" name="yakit[]"  id="yakit_elektrik" value="Elektrikli" />Elektrikli <?= $elektrikliler ?>
										</div>
										
								<?php }  ?>  
								<!--<div class="filter_check_box" style="width:calc(100% / 1);<?php if($benzinliler == 0){ echo "display: none;"; } ?>">
									<input type="checkbox" name="yakit[]" value="Benzinli" />Benzinli <?= $benzinliler ?>
								</div>
								<div class="filter_check_box" style="width:calc(100% / 1);<?php if($dizeller == 0){ echo "display: none;"; } ?>">
									<input type="checkbox" name="yakit[]" value="Dizel" />Dizel <?= $dizeller ?>
								</div>
								<div class="filter_check_box" style="width:calc(100% / 1);<?php if($lpgliler == 0){ echo "display: none;"; } ?>">
                                    <input type="checkbox" name="yakit[]" value="Benzin+Lpg" />Benzin+Lpg <?= $lpgliler ?>
								</div>
								<div class="filter_check_box" style="width:calc(100% / 1);<?php if($hibritler == 0){ echo "display: none;"; } ?>">
                                    <input type="checkbox" name="yakit[]" value="Hybrit" />Hybrit <?= $hibritler ?>
								</div>
								<div class="filter_check_box" style="width:calc(100% / 1);<?php if($elektrikliler == 0){ echo "display: none;"; } ?> ">
                                    <input type="checkbox" name="yakit[]" value="Elektrikli" />Elektrikli <?= $elektrikliler ?>
                                </div>-->
                            </div>
                        </div>                 
						<div class="filter_outer">
							<div class="filter_title_outer">
								Hasar Tipine Göre
							</div>
							<div class="filter_check_outer">
								<?php
									$hasar_bir_cek = mysql_query("SELECT * FROM `dogrudan_satisli_ilanlar` where durum=1 and (hasar_durumu like '%|1|%' or hasar_durumu like '1|%' or hasar_durumu like '%|1' or hasar_durumu='1')");
                                    $hasar_iki_cek = mysql_query("SELECT * FROM `dogrudan_satisli_ilanlar` where durum=1 and (hasar_durumu like '%|2|%' or hasar_durumu like '2|%' or hasar_durumu like '%|2' or hasar_durumu='2')");
                                    $hasar_uc_cek = mysql_query("SELECT * FROM `dogrudan_satisli_ilanlar` where durum=1 and (hasar_durumu like '%|3|%' or hasar_durumu like '3|%' or hasar_durumu like '%|3' or hasar_durumu='3')");
                                    $hasar_dort_cek = mysql_query("SELECT * FROM `dogrudan_satisli_ilanlar` where durum=1 and (hasar_durumu like '%|4|%' or hasar_durumu like '4|%' or hasar_durumu like '%|4' or hasar_durumu='4')");
                                    $hasar_bes_cek = mysql_query("SELECT * FROM `dogrudan_satisli_ilanlar` where durum=1 and (hasar_durumu like '%|5|%' or hasar_durumu like '5|%' or hasar_durumu like '%|5' or hasar_durumu='5')");
                                    $hasar_alti_cek = mysql_query("SELECT * FROM `dogrudan_satisli_ilanlar` where durum=1 and (hasar_durumu like '%|6|%' or hasar_durumu like '6|%' or hasar_durumu like '%|6' or hasar_durumu='6')");
                                    $hasar_yedi_cek = mysql_query("SELECT * FROM `dogrudan_satisli_ilanlar` where durum=1 and (hasar_durumu like '%|7|%' or hasar_durumu like '7|%' or hasar_durumu like '%|7' or hasar_durumu='7')");
                                    $hasar_birler = mysql_num_rows($hasar_bir_cek);
                                    $hasar_ikiler = mysql_num_rows($hasar_iki_cek);
                                    $hasar_ucler = mysql_num_rows($hasar_uc_cek);
                                    $hasar_dortler = mysql_num_rows($hasar_dort_cek);
                                    $hasar_besler = mysql_num_rows($hasar_bes_cek);
                                    $hasar_altilar = mysql_num_rows($hasar_alti_cek);
                                    $hasar_yediler = mysql_num_rows($hasar_yedi_cek);						
									$seciliHasarSayisi = count($_POST['hasar']);
									if($seciliHasarSayisi!=0){ 
										$hasar_bir_checked="";
										$hasar_iki_checked="";
										$hasar_uc_checked="";
										$hasar_dort_checked="";
										$hasar_bes_checked="";
										$hasar_alti_checked="";
										$hasar_yedi_checked="";
										
										
										for($i=0;$i<count($_POST["hasar"]);$i++){
											if($_POST["hasar"][$i]=="1"){
												$hasar_bir_checked="checked";
											}
											if($_POST["hasar"][$i]=="2"){
												$hasar_iki_checked="checked";
											}	
											if($_POST["hasar"][$i]=="3"){
												$hasar_uc_checked="checked";
											}										
											if($_POST["hasar"][$i]=="4"){
												$hasar_dort_checked="checked";
											}									
											if($_POST["hasar"][$i]=="5"){
												$hasar_bes_checked="checked";
											}
											if($_POST["hasar"][$i]=="6"){
												$hasar_alti_checked="checked";
											}			
											if($_POST["hasar"][$i]=="7"){
												$hasar_yedi_checked="checked";
											}
										}?>
										
										
										<div class="filter_check_box" style="width:calc(100% / 1); <?php if($hasar_birler == 0){ echo "display: none;"; } ?>">
											<input <?=$hasar_bir_checked ?> type="checkbox" name="hasar[]"  id="hasar_1" value="Benzinli" />Çarpma, Çarpışma <?= $hasar_birler ?>
										</div>
										<div class="filter_check_box" style="width:calc(100% / 1); <?php if($hasar_ikiler == 0){ echo "display: none;"; } ?>">
											<input <?=$hasar_iki_checked ?> type="checkbox" name="hasar[]"  id="hasar_2" value="Benzinli" />Teknik Arıza <?= $hasar_ikiler ?>
										</div>
										<div class="filter_check_box" style="width:calc(100% / 1); <?php if($hasar_ucler == 0){ echo "display: none;"; } ?>">
											<input <?=$hasar_uc_checked ?> type="checkbox" name="hasar[]"  id="hasar_3" value="Benzinli" />Sel/Su Hasarı <?= $hasar_ucler ?>
										</div>
										<div class="filter_check_box" style="width:calc(100% / 1); <?php if($hasar_dortler == 0){ echo "display: none;"; } ?>">
											<input <?=$hasar_dort_checked ?> type="checkbox" name="hasar[]"  id="hasar_4" value="Benzinli" />Yanma Hasarları <?= $hasar_dortler ?>
										</div>
										<div class="filter_check_box" style="width:calc(100% / 1); <?php if($hasar_besler == 0){ echo "display: none;"; } ?>">
											<input <?=$hasar_bes_checked ?> type="checkbox" name="hasar[]"  id="hasar_5" value="Benzinli" />Çalınma <?= $hasar_besler ?>
										</div>
										<div class="filter_check_box" style="width:calc(100% / 1); <?php if($hasar_altilar == 0){ echo "display: none;"; } ?>">
											<input <?=$hasar_alti_checked ?> type="checkbox" name="hasar[]"  id="hasar_6" value="Benzinli" />Diğer <?= $hasar_altilar ?>
										</div>
										<div class="filter_check_box" style="width:calc(100% / 1); <?php if($hasar_yediler == 0){ echo "display: none;"; } ?>">
											<input <?=$hasar_yedi_checked ?> type="checkbox" name="hasar[]"  id="hasar_7" value="Benzinli" />Hasarısz <?= $hasar_yediler ?>
										</div>
									
									<?php }else{ ?>
										<div class="filter_check_box" style="width:calc(100% / 1);<?php if($hasar_birler == 0){ echo "display: none;"; } ?>">
											<input type="checkbox" name="hasar[]" value="1" />Çarpma, Çarpışma <?= $hasar_birler ?>
										</div>
										<div class="filter_check_box" style="width:calc(100% / 1);<?php if($hasar_ikiler == 0){ echo "display: none;"; } ?>">
											<input type="checkbox" name="hasar[]" value="2" />Teknik Arıza <?= $hasar_ikiler ?>
										</div>
										<div class="filter_check_box" style="width:calc(100% / 1);<?php if($hasar_ucler == 0){ echo "display: none;"; } ?>">
											<input type="checkbox" name="hasar[]" value="3" />Sel/Su Hasarı <?= $hasar_ucler ?>
										</div>
										<div class="filter_check_box" style="width:calc(100% / 1);<?php if($hasar_dortler == 0){ echo "display: none;"; } ?>">
											<input type="checkbox" name="hasar[]" value="4" />Yanma Hasarı <?= $hasar_dortler ?>
										</div>
										<div class="filter_check_box" style="width:calc(100% / 1);<?php if($hasar_besler == 0){ echo "display: none;"; } ?>">
											<input type="checkbox" name="hasar[]" value="5" />Çalınma <?= $hasar_besler ?>
										</div>
										<div class="filter_check_box" style="width:calc(100% / 1);<?php if($hasar_altilar == 0){ echo "display: none;"; } ?>">
											<input type="checkbox" name="hasar[]" value="6" />Diğer <?= $hasar_altilar ?>
										</div>
										<div class="filter_check_box" style="width:calc(100% / 1);<?php if($hasar_yediler == 0){ echo "display: none;"; } ?>">
											<input type="checkbox" name="hasar[]" value="7" />Hasarsız <?= $hasar_yediler ?>
										</div>
								<?php }  ?> 
								<!--<div class="filter_check_box" style="width:calc(100% / 1);<?php if($hasar_birler == 0){ echo "display: none;"; } ?>">
									<input type="checkbox" name="hasar[]" value="1" />Çarpma, Çarpışma <?= $hasar_birler ?>
								</div>
								<div class="filter_check_box" style="width:calc(100% / 1);<?php if($hasar_ikiler == 0){ echo "display: none;"; } ?>">
									<input type="checkbox" name="hasar[]" value="2" />Teknik Arıza <?= $hasar_ikiler ?>
								</div>
								<div class="filter_check_box" style="width:calc(100% / 1);<?php if($hasar_ucler == 0){ echo "display: none;"; } ?>">
									<input type="checkbox" name="hasar[]" value="3" />Sel/Su Hasarı <?= $hasar_ucler ?>
								</div>
								<div class="filter_check_box" style="width:calc(100% / 1);<?php if($hasar_dortler == 0){ echo "display: none;"; } ?>">
									<input type="checkbox" name="hasar[]" value="4" />Yanma Hasarı <?= $hasar_dortler ?>
								</div>
								<div class="filter_check_box" style="width:calc(100% / 1);<?php if($hasar_besler == 0){ echo "display: none;"; } ?>">
									<input type="checkbox" name="hasar[]" value="5" />Çalınma <?= $hasar_besler ?>
								</div>
								<div class="filter_check_box" style="width:calc(100% / 1);<?php if($hasar_altilar == 0){ echo "display: none;"; } ?>">
									<input type="checkbox" name="hasar[]" value="6" />Diğer <?= $hasar_altilar ?>
								</div>
								<div class="filter_check_box" style="width:calc(100% / 1);<?php if($hasar_yediler == 0){ echo "display: none;"; } ?>">
									<input type="checkbox" name="hasar[]" value="7" />Hasarsız <?= $hasar_yediler ?>
								</div>-->
							</div>
                        </div>      
                        <div class="filter_outer">
							<div class="filter_title_outer">
								Model Yılına Göre
							</div>
                              <div class="filter_check_outer">
								 <?php
									if($_POST["kucuk_yil"]!="" && $_POST["buyuk_yil"]!="" ){ ?>
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
											<input type="number"  id="kucuk_yil" name="buyuk_yil" class="form-control" placeholder="En Yüksek" min="1950" max="<?php echo date("Y"); ?>" />
										 </div>
									<?php } ?>
                              </div>
                        </div>                              
                        <div class="filter_outer">
							<div class="filter_title_outer">
								Kilometreye Göre
							</div>
							<div class="filter_check_outer">
								 <?php
									if($_POST["kucuk_km"]!="" || $_POST["buyuk_km"]!="" ){ ?>
										<div class="filter_check_box" style="width:calc(100% / 2);">
											<input type="number"  id="kucuk_km" name="kucuk_km" class="form-control" placeholder="En Düşük" value="<?=$_POST["kucuk_km"] ?>" />
										 </div>
										 <div class="filter_check_box" style="width:calc(100% / 2);">
											<input type="number"  id="buyuk_km" name="buyuk_km" class="form-control" placeholder="En Yüksek"  value="<?=$_POST["buyuk_km"] ?>" />
										 </div>
									<?php }else { ?>
										<div class="filter_check_box" style="width:calc(100% / 2);">
											<input type="number"  id="kucuk_km" name="kucuk_km" class="form-control" placeholder="En Düşük"  />
										 </div>
										 <div class="filter_check_box" style="width:calc(100% / 2);">
											<input type="number"  id="buyuk_km" name="buyuk_km" class="form-control" placeholder="En Yüksek" />
										 </div>
									<?php } ?>
                              </div>
							<!--<div class="filter_check_outer">
								<div class="filter_check_box" style="width:calc(100% / 2);">
									<input type="number" name="kucuk_km" class="form-control" placeholder="En Düşük" />
								</div>
								<div class="filter_check_box" style="width:calc(100% / 2);">
									<input type="number" name="buyuk_km" class="form-control" placeholder="En Yüksek"  />
								</div>
							</div>-->
                        </div>                              
                        <div class="filter_outer">
							<div class="filter_title_outer">
								Fiyata Göre
							</div>
							<div class="filter_check_outer">
							 <?php
								if($_POST["kucuk_fiyat"]!="" || $_POST["buyuk_fiyat"]!="" ){ ?>
									<div class="filter_check_box" style="width:calc(100% / 2);">
										<input type="number"  id="kucuk_fiyat" name="kucuk_fiyat" class="form-control" placeholder="En Düşük"  value="<?=$_POST["kucuk_fiyat"] ?>"  />
									 </div>
									 <div class="filter_check_box" style="width:calc(100% / 2);">
										<input type="number"  id="buyuk_fiyat" name="buyuk_fiyat" class="form-control" placeholder="En Yüksek" value="<?=$_POST["buyuk_fiyat"] ?>"   />
									 </div>
								<?php }else { ?>
									<div class="filter_check_box" style="width:calc(100% / 2);">
										<input type="number"  id="kucuk_fiyat" name="kucuk_fiyat" class="form-control" placeholder="En Düşük"  />
									 </div>
									 <div class="filter_check_box" style="width:calc(100% / 2);">
										<input type="number"  id="buyuk_fiyat" name="buyuk_fiyat" class="form-control" placeholder="En Yüksek"  />
									 </div>
								<?php } ?>
						  </div>
							<!--<div class="filter_check_outer">
								<div class="filter_check_box" style="width:calc(100% / 2);">
									<input type="number" name="kucuk_fiyat" class="form-control" placeholder="En Düşük" />
								</div>
								<div class="filter_check_box" style="width:calc(100% / 2);">
									<input type="number" name="buyuk_fiyat" class="form-control" placeholder="En Yüksek"  />
								</div>
							</div>-->
                        </div>                             
                        <button type="submit" id="filtrele" name="filtrele" class="btn btn-primary">Ara</button>
					</form>
				</div>
				<div class="col-sm-8">
					<div class="alert alert-success" role="alert">
						Bu sayfada listelenen YEŞİL renkli ilanlar üyelerimiz tarafından eklenen Sabit fiyatlı ilanlardır. İlanlarda araç sahiplerinin iletişim bilgileri mevcuttur. Satışa hiçbir şekilde firmamız aracılık etmemektedir. Noter Devri sonrası doğacak problemlerden firmamız sorumlu değildir
					</div>
					<div class="alert" role="alert" style="background-color: #e8d7ee;color: black;">
					Bu sayfada listelenen MOR renkli ilanlar şirketimiz tarafından eklenen ancak şirketimize ait olmayan sadece aracılık hizmeti verdiğimiz sabit fiyatlı ilanlardır. Araçları yerinde gördükten sonra satın almanız aksi halde tüm sorumlulukların sizlere ait olduğunu bildiririz
					</div>
					<?php 
						if(isset($_POST['filtrele'])){                    
							$f_kelime = $_POST['aranan'];     
							$f_marka = $_POST['marka'];
							$f_model = $_POST['model'];
							$f_sehir = $_POST['sehir'];
							$f_tarih = $_POST['tarih'];
							$f_profil = $_POST['profil'];
							$f_vites = $_POST['vites'];
							$f_yakit = $_POST['yakit'];
							$f_hasar = $_POST['hasar'];
							$f_kucuk_yil = $_POST['kucuk_yil'];
							$f_buyuk_yil = $_POST['buyuk_yil'];
							$f_kucuk_km = $_POST['kucuk_km'];
							$f_buyuk_km = $_POST['buyuk_km'];
							$f_kucuk_fiyat = $_POST['kucuk_fiyat'];
							$f_buyuk_fiyat = $_POST['buyuk_fiyat'];
					?>
					<div class="ilanlar_ust_alan">
						<?php 
							$filtre_var="false";
							if($f_kelime !="")
							{       
								$filtre_var="true";
								echo '<div class="ust_filtre_baslik">
										Aranan
									</div>';            
								$onclick='onclick="filtre_cikar(\'aranan_\',\'filtre\')"';
								echo '<div class="ust_filte_kutu">
										'.$f_kelime.' <button '.$onclick.' class="filtre_cikart_buton"  >X</button>
									</div>';
							}
							if($f_marka !="")
							{
								$filtre_var="true";
								echo '<div class="ust_filtre_baslik">
									   Marka
									</div>'; 
								$k = 0;
								$seciliMarkaSayisi = count($_POST['marka']);
								$seciliMarka = "";
								$onclick='';
								while ($k < $seciliMarkaSayisi) 
								{
									$onclick='';
									$onclick='onclick="filtre_cikar(\'marka_\',\''.$_POST["marka"][$k].'\')"';
									echo '<div class="ust_filte_kutu">
											 '.$_POST['marka'][$k].'<button '.$onclick.' class="filtre_cikart_buton"  >X</button>
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
								while ($ml < $seciliModelSayisi) 
								{
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
							if($f_sehir !="")
							{
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
									echo 
										'<div class="ust_filte_kutu">
											'.date("d-m-Y",strtotime($_POST['tarih'][$t])).' <button '.$onclick.' class="filtre_cikart_buton"  >X</button>
										</div>';
									$t++;
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
								while ($p < $seciliProfilSayisi) {
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
									if($_POST["profil"][$p]=="Plakalı Ruhsatlı"){
										$post_profil="plakaliruhsatli";
									}
									$onclick='onclick="filtre_cikar(\'profil_\',\''.$post_profil.'\')"';
									echo '<div class="ust_filte_kutu">
										'.$_POST['profil'][$p].' <button '.$onclick.' class="filtre_cikart_buton"  >X</button>
									</div>';
									$p ++;
								}
							}
							if($f_vites !=""){
								$filtre_var="true";
								echo '<div class="ust_filtre_baslik">
                                       Vites
                                    </div>'; 
								$t = 0;
								
								$seciliVitesSayisi = count($_POST['vites']);
								$seciliVites = "";
								while ($t < $seciliVitesSayisi) {
									
									$onclick='';
									$post_vites="";
									if($_POST["vites"][$p]=="Düz Vites"){
										$post_vites="duz";
									}
									if($_POST["vites"][$p]=="Otomatik Vites"){
										$post_vites="oto";
									}
									$onclick='onclick="filtre_cikar(\'vites_\',\''.$post_vites.'\')"';
									echo 
										'<div class="ust_filte_kutu">
											'.$_POST['vites'][$t].' <button '.$onclick.' class="filtre_cikart_buton"  >X</button>
										</div>';
									$t++;
								}
							}
							if($f_yakit !=""){
								$filtre_var="true";
								echo '<div class="ust_filtre_baslik">
                                       Yakıt
                                    </div>'; 
								$t = 0;
								$seciliYakitSayisi = count($_POST['yakit']);
								$seciliYakit = "";
								while ($t < $seciliYakitSayisi) {
									$onclick='';
									$post_yakit="";
									if($_POST["yakit"][$t]=="Benzinli"){
										$post_yakit="benzinli";
									}
									if($_POST["yakit"][$t]=="Dizel"){
										$post_yakit="dizel";
									}
									if($_POST["yakit"][$t]=="Benzin+Lpg"){
										$post_yakit="lpg";
									}
									if($_POST["yakit"][$t]=="Hybrit"){
										$post_yakit="Hybrit";
									}
									if($_POST["yakit"][$t]=="Elektrikli"){
										$post_yakit="elektrik";
									}
									$onclick='onclick="filtre_cikar(\'yakit_\',\''.$post_yakit.'\')"';
									echo 
										'<div class="ust_filte_kutu">
											'.$_POST['yakit'][$t].' <button '.$onclick.' class="filtre_cikart_buton"  >X</button>
										</div>';
									$t++;
								}
							}
							if($f_hasar !=""){
								$filtre_var="true";
								echo '<div class="ust_filtre_baslik">
										Hasar
                                    </div>'; 
								$t = 0;
								$seciliHasarSayisi = count($_POST['hasar']);
								$seciliHasar = "";
								while ($t < $seciliHasarSayisi) {
									$onclick='';
	
									if($_POST['hasar'][$t]==1){
										$hasar_adi="Çarpma, Çarpışma";
									}else if($_POST['hasar'][$t]==2){
										$hasar_adi="Teknik Arıza";
									}else if($_POST['hasar'][$t]==3){
										$hasar_adi="Sel/Su Hasarı";
									}else if($_POST['hasar'][$t]==4){
										$hasar_adi="Yanma Hasarı";
									}else if($_POST['hasar'][$t]==5){
										$hasar_adi="Çalınma";
									}else if($_POST['hasar'][$t]==6){
										$hasar_adi="Diğer";
									}else if($_POST['hasar'][$t]==7){
										$hasar_adi="Hasarsız";
									}
									$onclick='onclick="filtre_cikar(\'hasar_\',\''.$_POST['hasar'][$t].'\')"';
									echo 
										'<div class="ust_filte_kutu">
											'.$hasar_adi.' <button '.$onclick.' class="filtre_cikart_buton"  >X</button>
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
							if($f_kucuk_km !="" || $f_buyuk_km !=""){
								$filtre_var="true";
								echo '<div class="ust_filtre_baslik">
										Kilometre
                                    </div>'; 
									$onclick='onclick="filtre_cikar(\'km_\',\'filtre\')"';
								echo '<div class="ust_filte_kutu">
                                          '.money($f_kucuk_km).' km - '.money($f_buyuk_km).' km <button '.$onclick.' class="filtre_cikart_buton"  >X</button>
									</div>';
							}
							if($f_kucuk_fiyat !="" || $f_buyuk_fiyat !=""){
								$filtre_var="true";
								echo '<div class="ust_filtre_baslik">
										Yıl
                                    </div>'; 
									$onclick='onclick="filtre_cikar(\'fiyat_\',\'filtre\')"';
								echo '<div class="ust_filte_kutu">
										'.money($f_kucuk_fiyat).' ₺ - '.money($f_buyuk_fiyat).' ₺ <button '.$onclick.' class="filtre_cikart_buton"  >X</button>
								   </div>';
							}
					   
					if($filtre_var=="true"){?>
						<p><a href="dogrudan_satisli_araclar.php">Tümünü Temizle</a></p>
					<?php } ?>
				</div>
				<?php
                   /* if($f_tarih=="1"){
                       $f_tarih =date("Y-m-d");
                    }elseif($f_tarih=="2"){
                       $f_tarih = date("Y-m-d", strtotime("+1 day"));
                    }*/
					$where = "WHERE durum = '1'";
					if($f_kelime !=""){
						$where .= "AND concat(plaka,model,arac_kodu,model_yili,sehir,ilce) LIKE '%".$f_kelime."%'";
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
                            $p ++;
                        }
                        $where = $where . " AND evrak_tipi in (" . $seciliProfil . ")";
					}
					if($f_vites !=""){
                        $v = 0;
                        $seciliVitesSayisi = count($_POST['vites']);
                        $seciliVites = "";
                        while ($v < $seciliVitesSayisi) {
                            $seciliVites = $seciliVites . "'" . $_POST['vites'][$v] . "'";
                            if ($v < $seciliVitesSayisi - 1) {
                                $seciliVites = $seciliVites . ", ";
                            }
                            $v ++;
                        }
                        $where = $where . " AND vites_tipi in (" . $seciliVites . ")";
					}
					if($f_yakit !=""){
                        $y = 0;
                        $seciliYakitSayisi = count($_POST['yakit']);
                        $seciliYakit = "";
                        while ($y < $seciliYakitSayisi) {
                            $seciliYakit = $seciliYakit . "'" . $_POST['yakit'][$y] . "'";
                            if ($y < $seciliYakitSayisi - 1) {
                                $seciliYakit = $seciliYakit . ", ";
                            }
                            $y ++;
                        }
                        $where = $where . " AND yakit_tipi in (" . $seciliYakit . ")";
					}
					if($f_hasar !=""){
                        $h = 0 ;
                        $seciliHasarSayisi = count($_POST['hasar']);                
                        $seciliHasar = "";
                        while ($h < $seciliHasarSayisi) {
                            $seciliHasar .=   $_POST['hasar'][$h] ;
                            if ($h < $seciliHasarSayisi - 1) {
                                $seciliHasar = $seciliHasar . ",";
                            }
							$dene = $seciliHasar;
                            $h ++;
                        }
                        $where = $where . " AND hasar_durumu in (" . $seciliHasar . ")";
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
                        $where = $where . " AND bitis_tarihi in (" . $seciliTarih . ")";
					}
					if($f_kucuk_yil !="" ){
						$where .= " AND  model_yili >= $f_kucuk_yil ";
					}
					if($f_buyuk_yil !=""){
						$where .= " AND  model_yili <= $f_buyuk_yil";
					}
					if($f_kucuk_km !="" ){
						$where .= " AND  kilometre >= $f_kucuk_km";
					}
					if($f_buyuk_km !=""){
						$where .= " AND  kilometre <= $f_buyuk_km";
					}
					if($f_kucuk_fiyat !=""){
						$where .= " AND  fiyat >= $f_kucuk_fiyat";
					}
					if($f_buyuk_fiyat !=""){
						$where .= " AND  fiyat <= $f_buyuk_fiyat";
					}
					$filtre_cek = "SELECT * FROM dogrudan_satisli_ilanlar $where";
					$result = mysql_query($filtre_cek) or die(mysql_error());
					// var_dump($filtre_cek);
					$sayi = mysql_numrows($result);
					if($sayi==0){
						echo '<script type="text/javascript">'; 
						echo 'alert("İstediğiniz kriterlere uygun araç bulunamadı.");'; 
                        echo 'window.location.href = "dogrudan_satisli_araclar.php";';
                        echo '</script>';                 
					}else{ ?>
					<?php 
						// İlan sayısı / reklam sayısı ==> Bu kadar ilandan sonra reklam çıkıyor
						$reklam_icin_cek = mysql_query("SELECT * FROM dogrudan_satisli_ilanlar WHERE durum = 1");
						$reklam_icin_say = mysql_num_rows($reklam_icin_cek);
						$dateTime = date('Y-m-d H:i:s');
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
						while($filtre_oku = mysql_fetch_array($result)){  
							if($_SESSION['u_token'] != "" && $_SESSION['k_token']=="" ){
								$renkli_uye_bul = mysql_query("SELECT * FROM user WHERE user_token = '".$_SESSION['u_token']."'");
								$renkli_uye_oku = mysql_fetch_assoc($renkli_uye_bul);
								$renkli_uye_id = $renkli_uye_oku['id'];  
								$favli_mi = mysql_query("SELECT * FROM favoriler WHERE uye_id = '".$renkli_uye_id."' AND dogrudan_satisli_id = '".$filtre_oku['id']."'");
								$favli_say = mysql_num_rows($favli_mi);
								if($favli_say == 0){
									$fav_color = "gray";
									$fav_title = "Araç favorilerinize eklenecektir.";
								}else{
									$fav_color = "orange";
									$fav_title = "Araç favorilerinizden kaldırılacaktır.";
								}
							}else if($_SESSION['u_token'] != "" && $_SESSION['k_token']=="" ){
								$renkli_uye_bul = mysql_query("SELECT * FROM user WHERE kurumsal_user_token = '".$_SESSION['k_token']."'");
								$renkli_uye_oku = mysql_fetch_assoc($renkli_uye_bul);
								$renkli_uye_id = $renkli_uye_oku['id'];   
								$favli_mi = mysql_query("SELECT * FROM favoriler WHERE uye_id = '".$renkli_uye_id."' AND dogrudan_satisli_id = '".$filtre_oku['id']."'");
								$favli_say = mysql_num_rows($favli_mi);
								if($favli_say == 0){
									$fav_color = "gray";
									$fav_title = "Araç favorilerinize eklenecektir.";
								}else{
									$fav_color = "orange";
									$fav_title = "Araç favorilerinizden kaldırılacaktır.";
								}
							}else{
								$fav_color = "gray";
								$fav_title = "Araç favorilerinize eklenecektir.";
							}
							$row_number++;
							$resim_cek = mysql_query("select * from dogrudan_satisli_resimler where ilan_id = '".$filtre_oku['id']."'");
							$resim_oku = mysql_fetch_assoc($resim_cek);
							$resim = $resim_oku['resim'];
							if($resim == ""){
								$resim = "default.png";
							}
							$marka_cek2 = mysql_query("select * from marka where markaID = '".$filtre_oku['marka']."'");
							$marka_oku2 = mysql_fetch_assoc($marka_cek2);
							$marka_adi2 = $marka_oku2['marka_adi'];
							if($reklam_icin_say>50){
									$advertisment_block = '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ilan_karti_dis">
									<a target="_blank" href="'.$reklam_url_array[$sayac].'">
										<img src="reklamlar/'.$reklam_array[$sayac].' " alt="" style="width:100%; height:auto;">
									</a>
								</div>' ;
							}
							if($filtre_oku['panelden_eklenme']==1){
								// $card_color="background:#00baff";
								$card_color="background:#a249a4";
								$card_title = "DOĞRUDAN SATIŞ";
							}else{
								$card_color="background:#22b14d";
								$card_title = "SAHİBİNDEN SATIŞ";
							}
					?>
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ilan_karti_dis">
						<div style="font-weight:bold;color:#fff;<?=$card_color ?>" class="col-xs-9 col-sm-9 col-md-9 col-lg-9 ilan_karti_baslik">
							<i class="fas fa-car" aria-hidden="true"></i> <?= $filtre_oku['model_yili']." ".$filtre_oku['marka']." ".$filtre_oku['model'] . " " . $filtre_oku['uzanti'] ?> 
						</div>
						<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 ilan_karti_baslik" style="background-color: #364d59; color: #ffffff; text-align: center;">
							<?= $card_title ?>
						</div>
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ilan_karti_icerik_dis">
							<div class="ilan_karti_gorsel_dis" style="background-image:url('images/<?= $resim ?>');">
								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ilan_karti_kod" style="background-color: #364d59c4">
									Kod : <?= $filtre_oku['arac_kodu'] ?>
								</div>
							</div>
							<div class="ilan_karti_gorsel_icerik">
								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ilan_karti_taglar_dis">
									<?php if($filtre_oku['sehir']!=""){ ?>
									<div class="ilan_karti_tag">
										<img src="images/car_list_icons/3.png" />
										<?= $filtre_oku['sehir'] ?>
									</div>
									<?php }  if($filtre_oku['vites_tipi']!=""){ ?>
									<div class="ilan_karti_tag">
										<img src="images/car_list_icons/2.png" />
										<?= $filtre_oku['vites_tipi'] ?>
									</div>
									<?php }  if($filtre_oku['yakit_tipi']!=""){ ?>
									<div class="ilan_karti_tag">
										<img src="images/car_list_icons/1.png" />
										<?= $filtre_oku['yakit_tipi'] ?>
									</div>
									<?php }  if($filtre_oku['kilometre']!=""){ ?>
									<div class="ilan_karti_tag">
										<img src="images/car_list_icons/7.png" />
										<?= money($filtre_oku['kilometre']) ?> km
									</div>
									<?php }  if($filtre_oku['evrak_tipi']!=""){ ?>
									<div class="ilan_karti_tag">
										<img src="images/car_list_icons/5.png" />
										<?= $filtre_oku['evrak_tipi'] ?>
									</div>
									<?php }  ?>
								</div>
								<?php 
									$hasarlar=$filtre_oku["hasar_durumu"];
									$hasar_parcala=explode("|",$hasarlar);
								?>
								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ilan_karti_alt_alan">
									
	
									<div class="col-xs-12 col-sm-12 col-md-7 col-lg-7 ilan_karti_notlar_dis mt-2">
										<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ilan_karti_not_alan">
											<?php 
												$t=0;
												$hasarlar="";
												while($t<count($hasar_parcala)){
													if($hasar_parcala[$t]=="1"){
														$hasarlar.="Çarpma, Çarpışma";
													}
													if($hasar_parcala[$t]=="2"){
														$hasarlar.="	Teknik Arıza";
													}
													if($hasar_parcala[$t]=="3"){
														$hasarlar.="Sel/Su Hasarı";
													}
													if($hasar_parcala[$t]=="4"){
														$hasarlar.="Yanma Hasarı";
													}
													if($hasar_parcala[$t]=="5"){
														$hasarlar.="Çalınma";
													}
													if($hasar_parcala[$t]=="6"){
														$hasarlar.="Diğer";
													}
													if($hasar_parcala[$t]=="7"){
														$hasarlar.="Hasarsız";
													}
													
													
													if($t!=count($hasar_parcala)-1){
														$hasarlar=$hasarlar.", ";
													}
													$t++;
													
												} 
												echo $hasarlar;
											?>
										</div>
										<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ilan_karti_begeni_dis">
											<form method="POST" action="" name="form" >
												<div onclick="dogrudan_favla(<?= $filtre_oku['id'] ?>)">
													<button data-toggle="tooltip" data-placement="top" title="<?=$fav_title ?>" id="favla_<?=$filtre_oku["id"] ?>" type="button" name="favla" class="btn btn-light btn-sm">
														<i style="color: <?= $fav_color ?>;" class="fas fa-star"></i>
														<input type="hidden" name="favlanacak" value="<?= $filtre_oku['id'] ?>">
													</button>
												</div>
											</form>
										</div>
									</div>
									<div class="col-xs-12 col-sm-12 col-md-5 col-lg-5 ilan_karti_teklif_dis">
										<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ilan_karti_teklif_baslik">
											Satış Fiyatı
										</div>
										<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ilan_karti_teklif_fiyat">
											<?= money($filtre_oku['fiyat']) ?> ₺
										</div>
										<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ilan_karti_teklif_btnlar">
											<div class="ilan_karti_teklif_btn" style="width:calc(100% - 10px); <?=$card_color ?>">
												<a onclick="dogrudan_arttir(<?=$filtre_oku['id']?>)" style="text-decoration: none; color:#ffffff;" href="arac_detay.php?id=<?= $filtre_oku['id'] ?>&q=dogrudan" target="_blank">İNCELE</a>
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
							}; 
                        ?>   
                        <div class="clearfix"></div>       
					<?php  } ?>
					<?php	} ?>
					<?php }else{ 
					
					// İlan sayısı / reklam sayısı ==> Bu kadar ilandan sonra reklam çıkıyor
					$reklam_icin_cek = mysql_query("SELECT * FROM dogrudan_satisli_ilanlar WHERE durum = 1");
					$reklam_icin_say = mysql_num_rows($reklam_icin_cek);
					$dateTime = date('Y-m-d H:i:s');
					$reklam_cek = mysql_query("SELECT * FROM reklamlar WHERE baslangic_tarihi <= '".$dateTime."' AND bitis_tarihi >= '".$dateTime."' ORDER BY RAND()");     
					$reklam_say = mysql_num_rows($reklam_cek);
					$gosterim_sayi = floor($reklam_icin_say / $reklam_say);                     
					$reklam_url_array = array();
					$reklam_array = array();
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
					while($ihale_oku = mysql_fetch_array($sql)){ 
                        if($_SESSION['u_token'] != "" && $_SESSION['k_token']=="" ){
							$renkli_uye_bul = mysql_query("SELECT * FROM user WHERE user_token = '".$_SESSION['u_token']."'");
							$renkli_uye_oku = mysql_fetch_assoc($renkli_uye_bul);
							$renkli_uye_id = $renkli_uye_oku['id'];  
							$favli_mi = mysql_query("SELECT * FROM favoriler WHERE uye_id = '".$renkli_uye_id."' AND dogrudan_satisli_id = '".$ihale_oku['id']."'");
							$favli_say = mysql_num_rows($favli_mi);
							if($favli_say == 0){
								$fav_color = "gray";
								$fav_title = "Araç favorilerin eklenecektir";
							}else{
								$fav_color = "orange";
								$fav_title = "Araç favorilerinizden kaldırılacaktır";
							}
						}else if($_SESSION['u_token'] == "" && $_SESSION['k_token'] !="" ){
							$renkli_uye_bul = mysql_query("SELECT * FROM user WHERE kurumsal_user_token = '".$_SESSION['k_token']."'");
							$renkli_uye_oku = mysql_fetch_assoc($renkli_uye_bul);
							$renkli_uye_id = $renkli_uye_oku['id'];   
                           
							$favli_mi = mysql_query("SELECT * FROM favoriler WHERE uye_id = '".$renkli_uye_id."' AND dogrudan_satisli_id = '".$ihale_oku['id']."'");
							$favli_say = mysql_num_rows($favli_mi);
							if($favli_say == 0){
								$fav_color = "gray";
								$fav_title = "Araç favorilerinize eklenecektir";
							}else{
								$fav_color = "orange";
								$fav_title = "Araç favorilerinizden kaldırılacaktır";
							}
						}else{
							$fav_color = "gray";
							$fav_title = "Araç favorilerinize eklenecektir";
						}
						
						$row_number++; 
						$resim_cek = mysql_query("select * from dogrudan_satisli_resimler where ilan_id = '".$ihale_oku['id']."'");
						$resim_oku = mysql_fetch_assoc($resim_cek);
						$resim = $resim_oku['resim'];
						if($resim == ""){
							$resim = "default.png";
						}
						if($reklam_icin_say>50){
							$advertisment_block = '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ilan_karti_dis">
								<a target="_blank" href="'.$reklam_url_array[$sayac].'">
									<img src="reklamlar/'.$reklam_array[$sayac].' " alt="" style="width:100%; height:auto;">
								</a>
							</div>' ; 
						}
						if($ihale_oku['panelden_eklenme']==1){
							// $card_color="background:#00baff";
							$card_color="background:#a249a4";
							$card_title = "DOĞRUDAN SATIŞ";
						}else{
							$card_color="background:#22b14d";
							$card_title = "SAHİBİNDEN SATIŞ";
						}
					?>
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ilan_karti_dis">
						<div style="font-weight:bold;color:#fff;<?=$card_color ?>" class="col-xs-9 col-sm-9 col-md-9 col-lg-9 ilan_karti_baslik">
							<i class="fas fa-car" aria-hidden="true"></i> <?= $ihale_oku['model_yili']." ".$ihale_oku['marka']." ".$ihale_oku['model'] . " " . $ihale_oku['uzanti'] ?> 
						</div>
						<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 ilan_karti_baslik" style="background-color: #364d59; color: #ffffff; text-align: center;">
							<?= $card_title ?>
						</div>
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ilan_karti_icerik_dis">
							<div class="ilan_karti_gorsel_dis" style="background-image:url('images/<?= $resim ?>');">
								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ilan_karti_kod" style="background-color: #364d59c4;">
									Kod : <?= $ihale_oku['arac_kodu'] ?>
								</div>
							</div>
							<div class="ilan_karti_gorsel_icerik">
								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ilan_karti_taglar_dis">
								<?php if($ihale_oku['sehir']!=""){ ?>
									<div class="ilan_karti_tag">
										<img src="images/car_list_icons/3.png" />
										<?= $ihale_oku['sehir'] ?>
									</div>
								<?php }  if($ihale_oku['vites_tipi']!=""){ ?>
									<div class="ilan_karti_tag">
										<img src="images/car_list_icons/2.png" />
										<?= $ihale_oku['vites_tipi'] ?>
									</div>
								<?php }  if($ihale_oku['yakit_tipi']!=""){ ?>
									<div class="ilan_karti_tag">
										<img src="images/car_list_icons/1.png" />
										<?= $ihale_oku['yakit_tipi'] ?>
									</div>
								<?php }  if($ihale_oku['kilometre']!=""){ ?>
									<div class="ilan_karti_tag">
										<img src="images/car_list_icons/7.png" />
										<?= money($ihale_oku['kilometre']) ?> km
									</div>
								<?php }  if($ihale_oku['evrak_tipi']!=""){ ?>
									<div class="ilan_karti_tag">
										<img src="images/car_list_icons/5.png" />
										<?= $ihale_oku['evrak_tipi'] ?>
									</div>
								<?php }  ?>
								</div>
								<?php 
									$hasarlar=$ihale_oku["hasar_durumu"];
									$hasar_parcala=explode("|",$hasarlar);
								?>
								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ilan_karti_alt_alan">
									<div class="col-xs-12 col-sm-12 col-md-7 col-lg-7 ilan_karti_notlar_dis mt-2">
										<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ilan_karti_not_alan">
											<?php 
												$t=0;
												$hasarlar="";
												while($t<count($hasar_parcala)){
													if($hasar_parcala[$t]=="1"){
														$hasarlar.="Çarpma, Çarpışma";
													}
													if($hasar_parcala[$t]=="2"){
														$hasarlar.="	Teknik Arıza";
													}
													if($hasar_parcala[$t]=="3"){
														$hasarlar.="Sel/Su Hasarı";
													}
													if($hasar_parcala[$t]=="4"){
														$hasarlar.="Yanma Hasarı";
													}
													if($hasar_parcala[$t]=="5"){
														$hasarlar.="Çalınma";
													}
													if($hasar_parcala[$t]=="6"){
														$hasarlar.="Diğer";
													}
													if($hasar_parcala[$t]=="7"){
														$hasarlar.="Hasarsız";
													}
													
													
													if($t!=count($hasar_parcala)-1){
														$hasarlar=$hasarlar.", ";
													}
													$t++;
													
												}
												echo $hasarlar;
											/*if (in_array(1, $hasar_parcala)){ echo " Çarpma, Çarpışma  ";} ?>
											<?php if (in_array(2, $hasar_parcala)){ echo " Teknik Arıza  ";} ?>
											<?php if (in_array(3, $hasar_parcala)){ echo " Sel/Su Hasarı  ";} ?>
											<?php if (in_array(4, $hasar_parcala)){ echo " Yanma Hasarı  ";} ?>
											<?php if (in_array(5, $hasar_parcala)){ echo " Çalınma  ";} ?>
											<?php if (in_array(6, $hasar_parcala)){ echo " Diğer  ";} ?>
											<?php if (in_array(7, $hasar_parcala)){ echo " Hasarsız";} */
											
											?>
										</div>
										<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ilan_karti_begeni_dis">
											<form method="POST" action="" name="form" >
												<div onclick="dogrudan_favla(<?= $ihale_oku['id'] ?>)">
													<button data-toggle="tooltip" data-placement="top" title="<?=$fav_title ?>"  type="button" name="favla" id="favla_<?=$ihale_oku["id"] ?>" class="btn btn-light btn-sm">
														<i style="color: <?= $fav_color ?>;"  class="fas fa-star"></i>
														<input type="hidden" name="favlanacak" value="<?= $ihale_oku['id'] ?>">
													</button>
												</div>
											</form>
										</div>
									</div>
									<div class="col-xs-12 col-sm-12 col-md-5 col-lg-5 ilan_karti_teklif_dis">
										<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ilan_karti_teklif_baslik">
											Satış Fiyatı
										</div>
										<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ilan_karti_teklif_fiyat">
											<?= money($ihale_oku['fiyat']) ?> ₺
										</div>
										<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ilan_karti_teklif_btnlar">
											<div class="ilan_karti_teklif_btn" style="width:calc(100% - 10px); <?=$card_color ?>">
												<a onclick="dogrudan_arttir(<?=$ihale_oku['id']?>)" style="text-decoration: none; color:#ffffff;" href="arac_detay.php?id=<?= $ihale_oku['id'] ?>&q=dogrudan" target="_blank">İNCELE</a>
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
                        }; 
						?>    
						<div class="clearfix"></div>      
					<?php  } ?>
					<nav aria-label="Page navigation example">
						<ul class="pagination justify-content-end">
							<li class="page-item">
								<a class="page-link" href="dogrudan_satisli_araclar.php" tabindex="-1" aria-disabled="true">İlk</a>
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
							<?php if($toplam_sayfa == 0){ ?>
                           Toplam 0 SAYFA ilan içerisinden 0. SAYFADASINIZ
						   <?php }else{ ?>
                           Toplam <?=$toplam_sayfa ?> SAYFA ilan içerisinden <?=$sayfa ?>. SAYFADASINIZ
						   <?php } ?>
                        </li>
                     </ul>
					</nav>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>
	<?php 
		if(isset($_POST['favla'])){
			$date = date('Y-m-d H:i:s');
			$id = $_POST['favlanacak'];
			if($_SESSION['u_token'] != "" && $_SESSION['k_token'] == ""){
				$favi_cek = mysql_query("SELECT * FROM user WHERE user_token = '".$uye_token."'");
				while($favi_oku = mysql_fetch_array($favi_cek)){
					$uyeninID = $favi_oku['id'];
					$favliyi_cek = mysql_query("SELECT * FROM favoriler WHERE dogrudan_satisli_id = '".$id."' AND uye_id = '".$uyeninID."'");
					$favliyi_say = mysql_num_rows($favliyi_cek);
					if($favliyi_say == 0){
						mysql_query("INSERT INTO `favoriler` (`id`, `ilan_id`, `dogrudan_satisli_id`, `uye_id`, `favlama_zamani`, `user_token`, `kurumsal_token`) VALUES 
						(NULL, '', '".$id."', '".$uyeninID."', '".$date."', '".$uye_token."', '');");
						echo'<script> alert("İlan Favorilerinize Eklendi")</script>';
							echo'<script> window.location.href = "dogrudan_satisli_araclar.php";</script>';
					}else{
						mysql_query("DELETE FROM favoriler WHERE dogrudan_satisli_id = '".$id."' AND uye_id = '".$uyeninID."'");
						echo'<script> alert("İlan Favorilerinizden Kaldırıldı")</script>';
							echo'<script> window.location.href = "dogrudan_satisli_araclar.php";</script>';
					}
				}
			}elseif($_SESSION['u_token'] == "" && $_SESSION['k_token'] != ""){
				$favi_cek = mysql_query("SELECT * FROM user WHERE kurumsal_user_token = '".$uye_token."'");
				while($favi_oku = mysql_fetch_array($favi_cek)){
					$uyeninID = $favi_oku['id'];
					$favliyi_cek = mysql_query("SELECT * FROM favoriler WHERE ilan_id = '".$id."' AND uye_id = '".$uyeninID."'");
					$favliyi_say = mysql_num_rows($favliyi_cek);
					if($favliyi_say == 0){
						mysql_query("INSERT INTO `favoriler` (`id`, `ilan_id`, `dogrudan_satisli_id`, `uye_id`, `favlama_zamani`, `user_token`, `kurumsal_token`) VALUES 
						(NULL, '', '".$id."', '".$uyeninID."', '".$date."', '', '".$uye_token."');");
						echo'<script> alert("İlan Favorilerinize Eklendi")</script>';
							echo'<script> window.location.href = "dogrudan_satisli_araclar.php";</script>';
					}else{
						mysql_query("DELETE FROM favoriler WHERE ilan_id = '".$id."' AND uye_id = '".$uyeninID."'");
						echo'<script> alert("İlan Favorilerinizden Kaldırıldı")</script>';
							echo'<script> window.location.href = "dogrudan_satisli_araclar.php";</script>';
					}
				}
			}
			else if($_SESSION['u_token'] == "" && $_SESSION['k_token'] == ""){
				echo'<script> alert("Giriş yapmalısınız")</script>';
				echo'<script> window.location.href = "dogrudan_satisli_araclar.php";</script>';
			}
		}

		if(isset($_POST['bildirim_ac'])){
			$date = date('Y-m-d H:i:s');
			$id = $_POST['bildirimlenecek'];
			if($uye_token==$token){
				$bildirim_cek = mysql_query("SELECT * FROM user WHERE user_token = '".$uye_token."'");
				while($bildirim_oku = mysql_fetch_array($bildirim_cek)){
					$uyeninID = $bildirim_oku['id'];
					$bildirim_varmi = mysql_query("SELECT * FROM bildirimler WHERE ilan_id = '".$id."' AND uye_id = '".$uyeninID."'");
					$bildirimini_say = mysql_num_rows($bildirim_varmi);
					if($bildirimini_say == 0){
						mysql_query("INSERT INTO `bildirimler` (`id`, `ilan_id`, `dogrudan_satisli_id`, `uye_id`, `bildirim_zamani`, `user_token`, `kurumsal_token`) VALUES 
						(NULL, '', '".$id."', '".$uyeninID."', '".$date."', '".$uye_token."', '');");
						echo'<script> alert("Bildirimler açıldı")</script>';
							echo'<script> window.location.href = "dogrudan_satisli_araclar.php";</script>';
					}else{
						mysql_query("DELETE FROM bildirimler WHERE dogrudan_satisli_id = '".$id."' AND uye_id = '".$uyeninID."'");
						echo'<script> alert("Bildirimler kapatıldı")</script>';
							echo'<script> window.location.href = "dogrudan_satisli_araclar.php";</script>';
					}

				}	
			}elseif($uye_token==$k_token){
				$bildirim_cek = mysql_query("SELECT * FROM user WHERE user_token = '".$uye_token."'");
				while($bildirim_oku = mysql_fetch_array($bildirim_cek)){
					$uyeninID = $bildirim_oku['id'];
					$bildirim_varmi = mysql_query("SELECT * FROM bildirimler WHERE ilan_id = '".$id."' AND uye_id = '".$uyeninID."'");
					$bildirimini_say = mysql_num_rows($bildirim_varmi);
					if($bildirimini_say == 0){
						mysql_query("INSERT INTO `bildirimler` (`id`, `ilan_id`, `dogrudan_satisli_id`, `uye_id`, `bildirim_zamani`, `user_token`, `kurumsal_token`) VALUES 
						(NULL, '', '".$id."', '".$uyeninID."', '".$date."', '', '".$uye_token."');");
						echo'<script> alert("Bildirimler açıldı")</script>';
							echo'<script> window.location.href = "dogrudan_satisli_araclar.php";</script>';
					}else{
						mysql_query("DELETE FROM bildirimler WHERE dogrudan_satisli_id = '".$id."' AND uye_id = '".$uyeninID."'");
						echo'<script> alert("Bildirimler kapatıldı")</script>';
							echo'<script> window.location.href = "dogrudan_satisli_araclar.php";</script>';
					}
				}
			} 
			else if($_SESSION['u_token'] == "" && $_SESSION['k_token'] == ""){
				echo'<script> alert("Giriş yapmalısınız")</script>';
				//echo'<script> window.location.href = "ihaledeki_araclar.php";</script>';
			}				
		}   
		?>
		<input type="hidden" id="ip" value="<?=GetIP() ?>">
		<!-- Footer Başlangıç -->
			<?php include "footer.php" ?>
		<!-- Footer Bitiş -->
	</div>
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
	<script src="js/main.js?v=<?=time() ?>"></script>
	  <script src="js/toastr/toastr.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
	<script src="https://kit.fontawesome.com/2fdd899201.js" crossorigin="anonymous" ></script>
	<script>
		function dogrudan_arttir(id){
			jQuery.ajax({
				url: "https://ihale.pertdunyasi.com/check.php",
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
	<script>
		function modelGetir(modelin_marka) {
			var modelin_marka = modelin_marka;   
			$.post('model_cek.php', {
				modelin_marka: modelin_marka
			}, function(output) {      
				var checkBox = document.getElementById("marka_"+modelin_marka);
				if (checkBox.checked == true){
					$('#modeller').append(output);
				} else {
					
					$(".modelmarka_"+modelin_marka).remove();
					/*var elms = document.querySelectorAll('#model_'+modelin_marka);
					for(var i = 0; i < elms.length; i++) {
						elms[i].remove();
					}*/
				}                          
			});
		}
		function filtre_cikar(key,value){
			if(key=="yil_" && value=="filtre"){
				$("#kucuk_yil").val("");
				$("#buyuk_yil").val("");
			}else if(key=="km_" && value=="filtre"){
				$("#kucuk_km").val("");
				$("#buyuk_km").val("");
			}else if(key=="fiyat_" && value=="filtre"){
				$("#kucuk_fiyat").val("");
				$("#buyuk_fiyat").val("");
			}else if(key=="aranan_" && value=="filtre"){
				$("#aranan").val("");
			}else{
				document.getElementById(""+key+value).checked=false
				console.log(""+key+value);
				if(key=="marka_"){
					$(".modelmarka_"+value).remove();
				}
			}	
			document.getElementById("filtrele").click();	
		}
		function dogrudan_favla(id){
			jQuery.ajax({
				url: 'action.php',
				method: 'POST',
				dataType: "JSON",
				data: {
					action:"dogrudan_favorilere_ekle",
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
	</script>  
	<script src="js/cikis_yap.js?v=<?php echo time(); ?>"></script>
	<script>
		setInterval(function() {
			cikis_yap("<?=$uye_token?>");
		}, 300001);
		son_islem_guncelle("<?=$uye_token?>");
		setInterval(function(){ bildirim_sms(); }, 1000);
		$(function () {
			$('[data-toggle="tooltip"]').tooltip()
		})
	</script>
	</body>
</html>