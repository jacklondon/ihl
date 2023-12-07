<?php 
	//MESAJ DURUM 0 OLANLAARA YANIP SÖNME EKLENİCEK GELİNCE
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

	$beni_cek = mysql_query("select * from user where user_token = '".$uye_token."'");
	$beni_oku = mysql_fetch_object($beni_cek);
	$benim_id = $beni_oku->id;

    include 'template/sayi_getir.php';
    include 'alert.php';
    
	$chat_rooms = user_chat_rooms($benim_id);
	// echo '<pre>';
	// print_r($chat_rooms);
	// echo '</pre>';
	for($i=0;$i<count($chat_rooms);$i++){
		$class = "";
		if($chat_rooms[$i]["unread_count"] != 0){
			$class = "alerts-border";
		}
		$opacity = "1";
		$arac_detay = '<a href="'.$chat_rooms[$i]["arac_detay"][0]["link"].'" target="_blank" style="float:right">'.$chat_rooms[$i]["arac_detay"][0]["detay"].'</a>';
		if($chat_rooms[$i]["arac_detay"][0]["devam_ediyor"] == 0){
			$opacity = "0.5";
			$arac_detay = '<a href="#" onclick="alert(\'İlan yayından kaldırılmış\')" style="float:right">'.$chat_rooms[$i]["arac_detay"][0]["detay"].'</a>';
		}
		// if($chat_rooms[$i]["dogrudan_satis_id"] != 0){
		// 	if($chat_rooms[$i]["arac_detay"][0]["kapanis"] < date('d-m-Y')){
		// 		$opacity = "0.5";
		// 	}
		// }
		$verileri_bas .= '<div class="card-header '.$class.'" id="message_room_'.$chat_rooms[$i]["id"].'" style="opacity: '.$opacity.';">
			<div style="text-align:right" class="row"  data-toggle="modal" data-target="#mesaj_sayfa_modal"  onclick="getChatRoomMessages(\''.$chat_rooms[$i]["id"].'\',\''.$benim_id.'\')">
				<div class="col-sm">
					<text style="color:black" >Kapanış :</text> <b style="color:black;font-weight:750">'.$chat_rooms[$i]["arac_detay"][0]["kapanis"].'</b>
					&nbsp &nbsp
					<text style="color:black" >Kod :</text> <b style="color:black;font-weight:750">'.$chat_rooms[$i]["arac_detay"][0]["kod"].'</b>
					&nbsp &nbsp
					<text style="color:black" >Plaka :</text> <b style="color:black;font-weight:750">'.$chat_rooms[$i]["arac_detay"][0]["plaka"].'</b>
				</div>
			</div>
			<div class="row">
				<div class="col-sm"  data-toggle="modal" data-target="#mesaj_sayfa_modal"  onclick="getChatRoomMessages(\''.$chat_rooms[$i]["id"].'\',\''.$benim_id.'\')">
					<h2 class="mb-0">
						<div class="message_image" style="background-image:url('.$chat_rooms[$i]["arac_detay"][0]["resim"].');">
						</div>
					<button class="btn btn-link" type="button" id="mesaj_accordion" style="width:calc(100% - 70px); float:left;">
							<p style="float:left"> '.strtoupper($chat_rooms[$i]["user"][0]["ad"]).' '.$chat_rooms[$i]["user"][0]["type"].'</p>
					</button>								  
					</h2>
				</div>
				<div class="col-sm">
					'.$arac_detay.'
				</div>
				<div class="col-sm">
					<button class="btn btn-danger" onclick="deleteChatRoom(\''.$chat_rooms[$i]["id"].'\')" style="float:right">Mesajları Sil</button>
				</div>
			</div>
		</div>';
	}		
    ?>
	
	<!doctype html>
	<html lang="tr">
		<head>
			<link rel="stylesheet" href="../css/uye_panel.css?v=15">
			<link rel="stylesheet" href="css/menu.css">
			<link rel="stylesheet" href="css/mesajlar.css">
			<?php
			include '../seo_kelimeler.php';
		?>
			<meta charset="utf-8">
			<meta http-equiv="content-language" content="tr">
			<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
			<meta name="author" content="EA Bilişim">
			<meta name="Abstract" content="Pert Dünyası sigortadan veya sahibinden kazalı,hasarlı pert araçların online ihale ile veya doğrudan satış yapılabileceği online ihale platformudur.">
			<meta name="description" content="Pert Dünyası Pert Kazalı Araç İhale Sistemi">
			<meta name="keywords" content="hasarlı oto, hasarlı arabalar, hasarlı araçlar, pert araçlar, pert oto, pert arabalar, kazalı araçlar, kazalı oto, kazalı arabalar, hurda araçlar, hurda arabalar, hurda oto, hasarlı ve pert kamyon, 
			hasarlı ve kazalı traktör, kazalı çekici, ihale ile satılan hasarlı araçlar,sigortadan satılık pert arabalar, ihaleli araçlar, kapalı ihaleli araçlar, açık ihalelli araçlar, 2.el araç,hurda kamyon, hurda traktör, ihaleyle kamyon">
			<meta name="Copyright" content="Ea Bilişim Tüm Hakları Saklıdır.">
			<script>
			</script>
			<!-- Bootstrap CSS -->
			<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
			<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.js"></script>
			<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
			<title>Pert Dünyası</title>
			<style>
			 .deneme p{
				margin-bottom:0px!important;
				margin-top:0px!important;
				margin-left:15px;
				}
				.alerts-border {
					border: 2px #ff0000 solid;
					
					animation-name: blink ;
					animation-duration: .5s ;
					animation-timing-function: step-end ;
					animation-iteration-count: infinite ;
					animation-direction: alternate ;
				}

				.container
  {
    max-width:100%!important;
  }

  .message_image
  {
	width: 70px;
    height: 70px;
    background-color: #dadada;
    float: left;
    margin-top: -19px;
	background-size:cover;
	background-position:center;
  }

				@keyframes blink { 50% { border-color:#fff ; }  }
			</style>
		</head>
		<body>
		<?php 
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
               }               
          }
          
     }
     }
      
			$bugun = date("Y-m-d");
			$sorgu = mysql_query("SELECT * FROM kutlama_gorseli WHERE '$bugun' < reklam_bitis AND '$bugun' >= reklam_baslangic ORDER BY id ASC LIMIT 1 ");
			while($yaz = mysql_fetch_array($sorgu)){ ?>
				<nav class="deneme" style="padding-bottom: 0%;width:100%; padding-top: 0%;color:<?= $yaz['yazi_renk']?>; background-color:<?= $yaz['arkaplan_renk'] ?>;padding: 0!important;">
				<div class="col-sm-12" style="text-align:center; font-size: large; padding: 15px;">
						<div style="text-align:center" class="col-sm-12">
							<?= $yaz['icerik'] ?>
						</div>
					</div>
				</nav>
			<?php } ?>
			<nav class="navbar navbar-expand-md navbar-dark bg-dark " style="padding-bottom: 0%; padding-top: 0%;">
				<div class="collapse navbar-collapse" id="navbarCollapse" >
					<ul class="navbar-nav mr-auto" >
						<li class="nav-item active" style="font-size: small;">
							<?php while($kullanici_oku = mysql_fetch_array($kullanici_cek)){ 
							$aktif_cayma_toplam=mysql_query("
								SELECT 
									SUM(tutar) as toplam_aktif_cayma
								FROM
									cayma_bedelleri
								WHERE
									uye_id='".$kullanici_oku['id']."' AND
									durum=1
							");
							$toplam_aktif_cayma=mysql_fetch_assoc($aktif_cayma_toplam);
							$iade_talepleri_toplam=mysql_query("
								SELECT 
									SUM(tutar) as toplam_iade_talepleri
								FROM
									cayma_bedelleri
								WHERE
									uye_id='".$kullanici_oku['id']."' AND
									durum=2
							");
							$toplam_iade_talepleri=mysql_fetch_assoc($iade_talepleri_toplam);
							$borclar_toplam=mysql_query("
								SELECT 
									SUM(tutar) as toplam_borclar
								FROM
									cayma_bedelleri
								WHERE
									uye_id='".$kullanici_oku['id']."' AND
									durum=6
							");
							$toplam_borclar=mysql_fetch_assoc($borclar_toplam);
							$cayma=$toplam_aktif_cayma["toplam_aktif_cayma"]-$toplam_borclar["toplam_borclar"];
						
							
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
								$grup_cek=mysql_query("select * from uye_grubu_detaylari where grup_id='".$paket."' order by cayma_bedeli asc");
								while($grup_oku=mysql_fetch_array($grup_cek)){
									if($cayma>=$grup_oku["cayma_bedeli"]){
										$limit = money($grup_oku["standart_ust_limit"])."₺ ";
										
									}
								}
								if($limit==0){
									$limit=$limit." ₺";
								}
								$limit_turu=" (Standart)";
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
								$grup_cek=mysql_query("select * from uye_grubu_detaylari where grup_id='".$paket."' order by cayma_bedeli asc");
								while($grup_oku=mysql_fetch_array($grup_cek)){
									if($cayma>=$grup_oku["cayma_bedeli"]){
										$limit2 = money($grup_oku["luks_ust_limit"])."₺ ";
									}
								}
								if($limit2==0){
									$limit2=$limit2." ₺";
								}
								$limit_turu2=" (Ticari)";
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
							<a class="nav-link uyelik" style="font-weight: bold; color:<?= $color ?> !important;" ><b><?= mb_strtoupper($paket_adi,"utf-8") ?> ÜYE</b></a> 
						</li>
						<li class="nav-item active" style="font-size: small;">
						   <a class="nav-link"><span style="color: #a4a4a4;" >Cayma Bakiyesi : </span>  <?= money($cayma) ?> ₺</a>
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
													<?php if( $paket != "21"){ ?>
						<a class="dropdown-item" href="islemler/gold_uyelik_basvuru.php?id=21" >Gold Üyelik Başvurusu</a>
					<?php } ?>
					<?php 
								$sozlesmeyi_cek = mysql_query("select * from uyelik_pdf where id = 1");
								$sozlesmeyi_bas = mysql_fetch_object($sozlesmeyi_cek);
								if($_SESSION["u_token"] != ""){
									$uyelik_sozlesme = $sozlesmeyi_bas->bireysel_pdf;
								}else{
									$uyelik_sozlesme = $sozlesmeyi_bas->kurumsal_pdf;
								}
							?>
							<a class="dropdown-item" href="../images/pdf/<?= $uyelik_sozlesme ?>" target="_blank">Üyelik Sözleşmesi Görüntüle</a>
								<?php 
									$kazanma_sorgula=mysql_query("select * from kazanilan_ilanlar where uye_id='".$kullanici_oku['id']."' ");
									if(mysql_num_rows($kazanma_sorgula)>0 && $paket == "21"){
									?> 
										<?php $vekaletname_cek=mysql_fetch_object(mysql_query("select * from vekaletname_pdf")); ?>
										<a class="dropdown-item" href="https://ihale.pertdunyasi.com/<?=$vekaletname_cek->vekaletname ?>" target="_blank">Vekaletname Örneği Görüntüle(PDF)</a>
										<a class="dropdown-item" href="https://ihale.pertdunyasi.com/<?=$vekaletname_cek->vekaletname_word ?>"  target="_blank" >Vekaletname Örneği Görüntüle(WORD)</a>
									
								<?php } ?>
								<a class="dropdown-item" href="evrak_yukle.php">Evrak Yükle</a>
							</div>
						</li>
						<li class="nav-item active mr-0">
							<a class="nav-link" href="islemler/logout.php"> Çıkış Yap</a>
						</li>
					</ul>
				</div>
			</nav>
			<style>
				li.list-group-item.d-flex.justify-content-between.align-items-center {
					padding-bottom: 0px;
				}
				li.list-group-item {
					padding-bottom: 0px;
				}
			</style>
			<?php  include 'template/header.php'; ?>
			<div class="container" style="margin-top:10%;">
				<div class="row">
					<div class="col-sm-4">
						<?php include 'template/sidebar.php'; ?>
					</div>
					<div class="col-sm-8">              
						<div class="accordion" id="accordionExample">
							<div class="row">
								<div class="col-sm-12">
									<nav>
										<div class="nav nav-tabs" id="nav-tab" role="tablist">
											<a class="nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home"  aria-controls="nav-home" aria-selected="true">Mesajlarım</a>
										</div>
									</nav>
									<div class="tab-content" id="nav-tabContent">
										<div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
										<div id="chat_rooms_html"><? echo $verileri_bas?></div>
										

										<div class="modal fade" id="mesaj_sayfa_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
											<div class="modal-dialog modal-xl">
												<div class="modal-content" style="margin-top: 25%;">
												<div class="modal-header">
													<h5 class="modal-title" id="exampleModalLabel">Direkt Mesaj</h5>
													<button type="button" class="close" data-dismiss="modal" aria-label="Close">
													<span aria-hidden="true">&times;</span>
													</button>
												</div>
												<div class="modal-body">
															<div class="row bootstrap snippets">
																<!-- DIRECT CHAT PRIMARY -->
																<div class="box box-primary direct-chat direct-chat-primary">
																	<div class="box-body">
																		<div class="direct-chat-messages" id="mesaj">
																		</div>
																	</div>
																	<div class="box-footer" id="messages_footer">                                
																	</div>
																</div>
															</div>      
													</div>
												</div>
											</div>
										</div>



											<div class="accordion" id="accordionExample">
												<div class="card ">
												
													
													<div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
														
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>              
					</div>
				</div>
			</div>
			<?php } ?>
			<?php include 'template/footer.php'; ?>
			<script src="https://kit.fontawesome.com/2fdd899201.js" crossorigin="anonymous" ></script>
			<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
			<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
			<script src="js/mesajlasma.js?<? echo time(); ?>"></script>
			<script src="../js/cikis_yap.js?v=<?php echo time(); ?>"></script>
			<script>
				function mesaj_guncelle(kullanici_token,gonderen_token,ilan_id){
					jQuery.ajax({
						url: "https://ihale.pertdunyasi.com/check.php",
						type: "POST",
						dataType: "JSON",
						data: {
							action: "mesaj_durum_guncelle",
							kullanici_token:kullanici_token,
							gonderen_token:gonderen_token,
							ilan_id:ilan_id,
						},
						success: function(response) {
							console.log(response);
							if (response.status == 200) {
								$("#ilan_baslik"+ilan_id+"_"+gonderen_token).removeClass("alerts-border");
							}
						}
					});
				}
				function mesaj_guncelle2(kullanici_token,gonderen_token,ilan_id){
					jQuery.ajax({
						url: "https://ihale.pertdunyasi.com/check.php",
						type: "POST",
						dataType: "JSON",
						data: {
							action: "dogrudan_mesaj_durum_guncelle",
							kullanici_token:kullanici_token,
							gonderen_token:gonderen_token,
							ilan_id:ilan_id,
						},
						success: function(response) {
							console.log(response);
							if (response.status == 200) {
								$("#ilan_baslik"+ilan_id+"_"+gonderen_token).removeClass("alerts-border");

							}else{
								
							}
						}
					});
				}


				function getChatRoomMessages($room_id,$user_id){
					$('#message_room_'+$room_id).removeClass("alerts-border");
					var $messages = "";
					jQuery.ajax({
						url: "../check.php",
						type: "POST",
						dataType: "JSON",
						data: {
							action: "getChatRoomMessages",
							room_id:$room_id,
							user_id:$user_id,
						},
						success: function(response) {
							jQuery.each(response.data, function(index,value){
								if(value.gonderen_id == $user_id && value.gonderen_type == 1){
									$messages += `<div class="direct-chat-msg" id="chat_message_${value.id}">
										<div class="direct-chat-info clearfix"> 
											<span class="direct-chat-name pull-right">Siz</span>  
											<span class="direct-chat-timestamp pull-left">${value.add_time}</span>
										</div> 
										<div class="direct-chat-text">
										${value.mesaj}
										<i class="fas fa-trash" style="display: none;float: right;font-size: 18px;color: red;" onclick="deleteChatMessage('${value.id}')"></i>
										</div>  
									</div>`;
								}else{
									$messages += `<div class="direct-chat-msg right">
										<div class="direct-chat-info clearfix">  
											<span class="direct-chat-name pull-left">${value.gonderen[0].ad}</span>  
											<span class="direct-chat-timestamp pull-right">${value.add_time}</span>   
										</div>
										<div class="direct-chat-text">${value.mesaj}</div>   
									</div>`;
								}
							});
							$('#mesaj').html($messages);
							$('#messages_footer').html(`<div class="input-group">
								<input type="text" name="message" placeholder="Mesaj Yaz" class="form-control" id="msj_icerik">
								<span class="input-group-btn">
									<button type="button" class="btn btn-primary btn-flat" onclick="sendChatMessage('${$room_id}','${$user_id}')">Gönder</button>
								</span>
							</div>`);
						}
					});
				}		
				
				function deleteChatMessage($message_id){
					jQuery.ajax({
						url: "../check.php",
						type: "POST",
						dataType: "JSON",
						data: {
							action: "deleteChatMessage",
							message_id:$message_id
						},
						success: function(response) {
							jQuery.each(response.data, function(index, value){
								if(value.result == "success"){
									$('#chat_message_'+$message_id).remove();
								} 
							})
							
						}
					});
				}

				

				function sendChatMessage($room_id,$user_id){
					var $message = $('#msj_icerik').val();
					if($message != ""){
						jQuery.ajax({
							url: "../check.php",
							type: "POST",
							dataType: "JSON",
							data: {
								action: "sendChatRoomMessage",
								room_id:$room_id,
								user_id:$user_id,
								message:$message,
							},
							success: function(response) {
								jQuery.each(response.data, function(index, value){
									alert(value.message);
									if(value.result == "success"){
										getChatRoomMessages($room_id,$user_id);
									} 
								})
								
							}
						});
					}
				}
				function chat_odalari_getir($user_id){
					var $rooms = "";
					var $sayi = 0;
					jQuery.ajax({
						url: "../check.php",
						type: "POST",
						dataType: "JSON",
						data: {
							action: "getChatRooms",
							user_id:$user_id,
						},
						success: function(response) {
							jQuery.each(response.data, function(index, value){
								var $class = "";
								if(value.unread_count != 0){
									var $class = "alerts-border";
								}

								var $opacity = "1";
								var $arac_detay = `<a href="${value.arac_detay[0].link}" target="_blank" style="float:right">${value.arac_detay[0].detay}</a>`;
								if(value.arac_detay[0].devam_ediyor == 0){
									var $opacity = "0.5";
									var $arac_detay = `<a href="#" onclick="alert('İlan yayından kaldırılmış')" style="float:right">${value.arac_detay[0].detay}</a>`;
								}


								$sayi += value.unread_count;
								$rooms += `<div class="card-header ${$class}" id="message_room_${value.id}" style="opacity: ${$opacity}">
									<div style="text-align:right" class="row"  data-toggle="modal" data-target="#mesaj_sayfa_modal"  onclick="getChatRoomMessages('${value.id}','${$user_id}')">
										<div   class="col-sm">
											<text style="color:black" >Kapanış :</text> <b style="color:black;font-weight:750">${value.arac_detay[0].kapanis}</b>
											&nbsp &nbsp
											<text style="color:black" >Kod :</text> <b style="color:black;font-weight:750">${value.arac_detay[0].kod}</b>
											&nbsp &nbsp
											<text style="color:black" >Plaka :</text> <b style="color:black;font-weight:750">${value.arac_detay[0].plaka}</b>
										</div>
									</div>
									<div class="row">
										<div class="col-sm"  data-toggle="modal" data-target="#mesaj_sayfa_modal"  onclick="getChatRoomMessages('${value.id}','${$user_id}')">
											<h2 class="mb-0">
												<div class="message_image" style="background-image:url('${value.arac_detay[0].resim}');">
												</div>
											<button class="btn btn-link" type="button" id="mesaj_accordion" style="width:calc(100% - 70px); float:left;">
												<p style="float:left"> ${(value.user[0].ad).toUpperCase()} ${value.user[0].type}</p>
											</button>								  
											</h2>
										</div>
										<div class="col-sm">
											${$arac_detay}
										</div>
										<div class="col-sm">
											<button class="btn btn-danger" onclick="deleteChatRoom('${value.id}')" style="float:right">Mesajları Sil</button>
										</div>
									</div>
								</div>`;
							});
							$('#chat_rooms_html').html($rooms);
							$('#uye_pane_mesaj_sayisi').html($sayi);
						}
					});
				}

				function deleteChatRoom($room_id){
					jQuery.ajax({
						url: "../check.php",
						type: "POST",
						dataType: "JSON",
						data: {
							action: "deleteChatRoom",
							room_id:$room_id
						},
						success: function(response) {
							jQuery.each(response.data, function(index, value){
								if(value.result == "success"){
									$('#message_room_'+$room_id).remove();
								} 
							})
							
						}
					});
				}


				setInterval(function() {
				   cikis_yap("<?=$uye_token?>");
				}, 300001);
				setInterval(function() {
				//    chat_odalari_getir("<?= $benim_id ?>");
				}, 5000);
				son_islem_guncelle("<?=$uye_token?>");
				 setInterval(function(){ bildirim_sms(); }, 1000);

			</script>
		</body>
	</html>