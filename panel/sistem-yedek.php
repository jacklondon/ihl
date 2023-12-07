<?php 
	session_start();
	
	include("ayar.php");
	$admin_id=$_SESSION['kid'];
	//include('assets/ckeditor5');
	$modul_is = false;
	
	if(re('sayfa') == "") { $modul_is = true; }
	if(re('sayfa') == "index") { $modul_is = true; }
	if(re('modul') == "istatistikler") { $modul_is = true; }
	
	if($modul_is == true)
	{
		include("genel_moduller.php");
	}
	
	if ( $_SESSION['kid'] == "" )
	{
		header("Location: index.php");
	}
	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<!--[if IE 8]> <html lang="tr" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="tr" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="tr"> <!--<![endif]-->
<head>
	<?php include("head.php"); ?>
</head>
<body class="fixed-top" >
<style>
	.custom-large-modal
	{
		width:80%!important;
		left:10%!important;
		margin-left:0px!important;
	}
	
	.custom-large-modal .modal-body
	{
		width: 100%!important;
		float: left!important;
		box-sizing: border-box!important;
		margin-top: 30px!important;
		max-height:calc(100vh - 170px);
	}
	input:focus
	{
		-webkit-box-shadow: 0px 0px 8px 0px #FF0000!important; 
		box-shadow: 0px 0px 8px 0px #FF0000!important;
		border-color:#ff0000!important;
	}
	
	input[type=checkbox]:focus
	{
		-webkit-box-shadow:none!important; 
		box-shadow: none!important;
		border-color:none!important;
	}
	input[type=radio]:focus
	{
		-webkit-box-shadow:none!important; 
		box-shadow: none!important;
		border-color:none!important;
	}
	
	select:focus
	{
		-webkit-box-shadow: 0px 0px 8px 0px #FF0000!important; 
		box-shadow: 0px 0px 8px 0px #FF0000!important;
		border-color:#ff0000!important;
	}
	
	textarea:focus
	{
		-webkit-box-shadow: 0px 0px 8px 0px #FF0000!important; 
		box-shadow: 0px 0px 8px 0px #FF0000!important;
		border-color:#ff0000!important;
	}
</style>
<script>
function playSound() {
	//swal("Hello world!");
}
setInterval(function(){ 
jQuery.ajax({
	url: "bildirim.php",
	type: "POST",
	dataType: "JSON",
	data: {
		action: "teklif_say", 
	},
	success: function(response) { 
		jQuery.each(response.data, function(index, value) {  
			var teklifler = localStorage.getItem("aktif_teklif_sayisi");
			if(value.ilan_sayisi > teklifler){
				var audio = document.getElementById("audio");
        				audio.play();
		}
		});
	},
}); 
}, 100000);
 setInterval(function(){ 

    jQuery.ajax({
        url: "bildirim.php",
        type: "POST",
        dataType: "JSON",
        data: {
            action: "teklif_say", 
        },
        success: function(response) { 
			jQuery.each(response.data, function(index, value) {  
					
					localStorage.setItem("aktif_teklif_sayisi",value.ilan_sayisi);
			});
        },
    });  

 }, 1500000);

	

</script> 


	<div id="submit_st"></div>
		<!-- BEGIN HEADER -->
	<div class="header navbar navbar-inverse navbar-fixed-top">
		<!-- BEGIN TOP NAVIGATION BAR -->
		<form method="POST" name="form" id="form" enctype="multipart/form-data">		
		<div class="navbar-inner">
			<div class="container-fluid">
				<!-- BEGIN LOGO -->
				<a class="brand" href="index.php">
					<img src="images/pert_logo.png" alt="logo" style="height:26px;" />
				</a>
				<!-- END LOGO -->
				<!-- BEGIN RESPONSIVE MENU TOGGLER -->
				<a href="javascript:;" class="btn-navbar collapsed" data-toggle="collapse" data-target=".nav-collapse">
					<img src="assets/img/menu-toggler.png" alt="" />
				</a>
				<input style="margin-top:5px" type="text" id="navbar_aranan" name="navbar_aranan" placeholder="Araç kodu veya plaka giriniz." >		
				<button class="button btn-primary"  style="width:45px;height:30px;margin-bottom:5px;border:none" type="button" onclick="navbar_searchle();" >Ara</button>	
				<!-- END RESPONSIVE MENU TOGGLER -->				
				<!-- BEGIN TOP NAVIGATION MENU -->	
				
				<ul class="nav pull-right">
					<!-- BEGIN NOTIFICATION DROPDOWN -->	
					<?php /* echo $bildirim_durum; */ ?>
					<!-- END NOTIFICATION DROPDOWN -->
					<!-- BEGIN INBOX DROPDOWN -->
					<?php /* echo $mesaj_durum; */ ?>
					<!-- END INBOX DROPDOWN -->
					<!-- BEGIN TODO DROPDOWN -->
					<?php /* echo $server_durum; */ ?>
					
					<?php /* echo $resim_deposu; */ ?>
					
					<!-- END TODO DROPDOWN -->
					<!-- BEGIN USER LOGIN DROPDOWN -->
					
					<img onclick="playAudio('bildirim.mp3')">
					<li style="margin-top:5px;" >
						<text style="color:#fff;" >GÜRCAN CANKIZ / 0.(532)718-3376</text>
					</li>
					<li class="dropdown user">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						<?php if ($kullanici_oku['resim']!="") {?>
						<img alt="" src="images/kullanicilar/<?php echo $kullanici_oku['resim']; ?>" style="width:29px; height:29px; "/>
						<?php } else { ?>
						<i class="icon-user icon-white"></i>
						<?php } ?>
						<span class="username"><?php echo $kullanici_oku['adi_soyadi']; ?></span>
						<i class="icon-angle-down"></i>
						</a>
						<ul class="dropdown-menu">
							<li><a href="extra_profile.html"><i class="icon-user"></i> Profiliniz</a></li>
							<!-- <li><a href="calendar.html"><i class="icon-calendar"></i> Ajandanız</a></li> -->
							<li><a href="#"><i class="icon-tasks"></i> Görev Listeniz</a></li>
							<li class="divider"></li>
							<li><a href="?sayfa=cikis"><i class="icon-key"></i> Çıkış</a></li>
						</ul>
					</li>
					<!-- END USER LOGIN DROPDOWN -->
				</ul>
				<!-- END TOP NAVIGATION MENU -->	
			</div>
		</div>
		</form>
		<!-- END TOP NAVIGATION BAR -->
	</div>
	<!-- END HEADER -->
	
	<?php 
	
		
		$ust_menu = "";
		$sayi = 0;
		$sayi_alt = 0;
		$menu_cek = mysql_query("select * from p_menu where durum!='0' and kategori='0' ORDER BY sira ASC");
		while($menu_oku = mysql_fetch_array($menu_cek))
		{
			$secilmis1='';
			$secilmis2='';
			$secilmis3='';
			$alink='?modul='.$menu_oku['modul'].'&sayfa='.$menu_oku['sayfa'].'';
			
			$bas = true;
			$alt_menuler='';
			if($bas == true)
			{
				
				
				$alt_kat_cek = mysql_query("select * from p_menu where durum!='0' and kategori='".$menu_oku['id']."' ORDER BY sira ASC");
				$alt_kat_sayi = mysql_num_rows($alt_kat_cek);
				if($alt_kat_sayi != 0)
				{
					
			
					$alink='javascript:;';
					$secilmis1='has-sub ';
					
					$secilmis2='<span class="selected"></span>';
					$secilmis3='<span class="arrow"></span>';
					
					if ($menu_oku['modul'] == re('modul') ) { $secilmis1.=' active '; $secilmis3='<span class="arrow open"></span>';}
						
					$uyeler = mysql_query("select * from user");					
					$uye_Sayisi = mysql_num_rows($uyeler);
					$online = mysql_query("select * from user where online_durum = 1");
					$onlineler = mysql_num_rows($online);
					$gold_talepleri = mysql_query("select * from gold_uyelik_talepleri where durum=0");
					$gold_talep = mysql_num_rows($gold_talepleri);
					$evrak_yukleyenler = mysql_query("select * from yuklenen_evraklar");
					$evraklar = mysql_num_rows($evrak_yukleyenler);
					//$cayma_talepleri = mysql_query("SELECT * FROM cayma_bedelleri WHERE durum=3");
					$cayma_talepleri = mysql_query("SELECT * FROM cayma_bedelleri");
					$cayma_talep = mysql_num_rows($cayma_talepleri);
					$bugun_bitenleri_cek = mysql_query("select * from ilanlar where ihale_tarihi = '".date('Y-m-d')."'");
					$bugun_bitenler = mysql_num_rows($bugun_bitenleri_cek);
					$yarin = date("Y.m.d",strtotime('+1 days'));
					$yarin_bitenleri_cek = mysql_query("SELECT * FROM ilanlar WHERE ihale_tarihi = '$yarin'");
					$yarin_bitenler = mysql_num_rows($yarin_bitenleri_cek);
					$tum_ihaleler_cek = mysql_query("select * from ilanlar");
					$tum_ihaleler = mysql_num_rows($tum_ihaleler_cek);
					$ihalesi_bitenleri_cek = mysql_query("SELECT * FROM ilanlar WHERE CONCAT_WS('', ihale_tarihi, ihale_saati) <= '".date('Y-m-d H:i:s')."' ORDER BY ihale_saati DESC");
					$ihalesi_bitenler = mysql_num_rows($ihalesi_bitenleri_cek);
					$bugun_eklenenleri = mysql_query("SELECT * FROM ilanlar WHERE eklenme_zamani = '".date("Y.m.d")."'  ORDER BY id DESC");
					$bugun_eklenenler = mysql_num_rows($bugun_eklenenleri);
					$son_teklifleri_cek = mysql_query("select * from teklifler as t1 WHERE durum=1 and teklif_zamani=(select max(teklif_zamani) from teklifler as t2 where t1.ilan_id=t2.ilan_id)group by ilan_id order by teklif_zamani desc");
					$son_teklifler = mysql_num_rows($son_teklifleri_cek);
					$statu_bekleyenleri = mysql_query("select distinct ilan_id from kazanilan_ilanlar where durum=0");
					$statuler = mysql_num_rows($statu_bekleyenleri);
					$dogrudan_satislilar = mysql_query("select * from dogrudan_satisli_ilanlar");
					$dogrudanlar = mysql_num_rows($dogrudan_satislilar);
					$uyelerin_ihaleleri = mysql_query("select * from ilanlar where ihale_sahibi != ''");
					$uye_ihale = mysql_num_rows($uyelerin_ihaleleri);
					$uyelerin_dogrulari = mysql_query("select * from dogrudan_satisli_ilanlar where ilan_sahibi !='' ");
					$uye_dogrular = mysql_num_rows($uyelerin_dogrulari);
					$uyelerden_gelenler = $uye_ihale + $uye_dogrular;
					$son_islemdekiler = mysql_query("select * from kazanilan_ilanlar where durum = 2");
					$son_islemler = mysql_num_rows($son_islemdekiler);
					$odeme_bekleyenlerrr = mysql_query("select * from kazanilan_ilanlar where durum = 1");
					$odeme_bekleyenler = mysql_num_rows($odeme_bekleyenlerrr);
					$onay_bekleyenlerrr = mysql_query("select * from kazanilan_ilanlar where durum = 0");
					$onay_bekleyenler = mysql_num_rows($onay_bekleyenlerrr);
					$iptal_edilenler = mysql_query("select * from kazanilan_ilanlar where durum = 4");
					$iptaller = mysql_num_rows($iptal_edilenler);
					$satilanlarr = mysql_query("select * from kazanilan_ilanlar where durum = 3");
					$satilanlar = mysql_num_rows($satilanlarr);
					$satilan_araclar = mysql_query("select * from satilan_araclar");
					$satilan_araclarr = mysql_num_rows($satilan_araclar);
					$sigorta_sirketleri = mysql_query("select * from sigorta_ozellikleri");
					$sig_sir_say = mysql_num_rows($sigorta_sirketleri);
					$uye_gruplari_cek = mysql_query("select * from uye_grubu");
					$uye_gruplari = mysql_num_rows($uye_gruplari_cek);
					$sss_cek = mysql_query("select * from sss");
					$sss = mysql_num_rows($sss_cek);
					$duyuru_cek = mysql_query("select * from duyurular");
					$duyurular = mysql_num_rows($duyuru_cek);
					$adminler_cek = mysql_query("select * from kullanicilar");
					$adminler = mysql_num_rows($adminler_cek);
					$yorumlar_cek = mysql_query("select * from yorumlar");
					$yorumlar = mysql_num_rows($yorumlar_cek);
					//$iade_cek = mysql_query("select * from cayma_bedelleri where durum = 4");
					$iade_cek = mysql_query("select * from cayma_bedelleri where durum = 4");
					$iadeler = mysql_num_rows($iade_cek);
					$uyelerim_cek = mysql_query("select * from user where temsilci_id = '".$admin_id."'");
					$uyelerim = mysql_num_rows($uyelerim_cek);
					$odeme_beklediklerim=0;
					while($uyelerim_oku = mysql_fetch_array($uyelerim_cek)){
						$uyelerim_id = $uyelerim_oku['id'];
						$odeme_beklediklerim_cek = mysql_query("select * from kazanilan_ilanlar where uye_id = '".$uyelerim_id."' and durum=1");
						if(mysql_num_rows($odeme_beklediklerim_cek)!=0){
							$odeme_beklediklerim++;
						}
						
					}
					
					$gun_sonu = date('Y-m-d 23:59:59');
					$gun_basi = date('Y-m-d 00:00:00');
					$performans_cek = mysql_query("SELECT * FROM yapilan_is WHERE ekleme_zamani BETWEEN '".$gun_basi."' AND '".$gun_sonu."'");
					$performans_say = mysql_num_rows($performans_cek);
					$admin_mesajlar=mysql_query("select * from mesajlar where alan_id=0 and durum=0");
					$amin_mesaj_sayisi=mysql_num_rows($admin_mesajlar);


					$sayi++;
					$sayi_alt++;
					$alt_menuler .= '<ul class="sub">';
					$degisken = '';
					
					//Alt menülerin getirildiği alan
					while($alt_kat_oku = mysql_fetch_array($alt_kat_cek))
					{

						
						$class='';
						$say++;
					
					
						if($say==1){$degisken=$uyelerim;}
						elseif($say==2){$degisken=$odeme_beklediklerim;}					
						elseif($say==6){$degisken=$bugun_bitenler;}
						elseif($say==7){$degisken=$yarin_bitenler;}
						elseif($say==8){$degisken=$tum_ihaleler;}
						elseif($say==9){$degisken=$ihalesi_bitenler;}
						elseif($say==10){$degisken=$bugun_eklenenler;}
						elseif($say==11){$degisken=$son_teklifler;}
						elseif($say==13){$degisken = $performans_say;}
						
						elseif($say==14){$degisken=$dogrudanlar;}
						elseif($say==15){$degisken=$uyelerden_gelenler;}
					
						elseif($say==16){$degisken=$amin_mesaj_sayisi;}//Okunmayan Mesaj Sayısı	
						elseif($say==20){$degisken=$statuler;}
						elseif($say==21){$degisken=$son_islemler;}
						elseif($say==22){$degisken=$odeme_bekleyenler;}
						elseif($say==23){$degisken=$onay_bekleyenler;}
						elseif($say==24){$degisken=$iptaller;}
						elseif($say==25){$degisken=$satilanlar;}	
						elseif($say==26){$degisken = $uye_Sayisi;}				
						elseif($say==27){ $degisken = $onlineler;}
						elseif($say==28){$degisken = $gold_talep;}
						elseif($say==30){$degisken=$evraklar;}
						elseif($say==31){$degisken = $cayma_talep;}
						elseif($say==35){$degisken = $satilan_araclarr;}
						elseif($say==37){$degisken = $iadeler;}
						elseif($say==38){$degisken = $sig_sir_say;}
						elseif($say==40){$degisken = $uye_gruplari;}
						elseif($say==45){$degisken = $sss;}
						elseif($say==56){$degisken = $duyurular;}
						elseif($say==65){$degisken = $adminler;}
						elseif($say==66){$degisken = $yorumlar;}

						/*elseif($say==34){$degisken=$sig_sir_say;}
						elseif($say==36){$degisken=$uye_gruplari;}
						elseif($say==41){$degisken=$sss;}


						elseif($say==52){$degisken=$duyurular;}
						
						elseif($say==60){$degisken=$adminler;}
						elseif($say==61){$degisken=$yorumlar;}
						elseif($say==63){$degisken=$satilanlar;}
						elseif($say==65){$degisken=$iadeler;}*/
						
						else{$degisken='';}
						if ($alt_kat_oku['sayfa'] == re('sayfa') ) { $class='class="active"'; }
						$alt_menuler.='
							<li '.$class.' id="'.$say.'"><a href="?modul='.$alt_kat_oku['modul'].'&sayfa='.$alt_kat_oku['sayfa'].'">'.$alt_kat_oku['adi'].' '.$degisken.'</a></li>';
					
					}
					$alt_menuler .= '</ul>';
					
					
				}
				else
				{
					if ($menu_oku['sayfa'] == re('sayfa') ) 
					{ 
						$secilmis1='start active ';
						$secilmis2='<span class="selected"></span>';
						
					}
				}
			}
					$sayi++;
					$ust_menu .= '
					<li class="'.$secilmis1.'">
						<a href="'.$alink.'">
						<i class="'.$menu_oku['icon'].'" style="color:white"></i> 
						<span class="title">'.$menu_oku['adi'].'</span>
						'.$secilmis2.'
						'.$secilmis3.'
						</a>
						'.$alt_menuler.'
					</li>
					
					';
		}
		
	?>
	
	
	<!-- BEGIN CONTAINER -->
	<div class="page-container row-fluid">
		<!-- BEGIN SIDEBAR -->
		<div class="page-sidebar nav-collapse ">
			<!-- BEGIN SIDEBAR MENU -->        	
			<ul>
				<li>
					<!-- BEGIN SIDEBAR TOGGLER BUTTON -->
					<div class="sidebar-toggler hidden-phone"></div>
					<!-- BEGIN SIDEBAR TOGGLER BUTTON -->
				</li>
				<li>
					<!-- BEGIN RESPONSIVE QUICK SEARCH FORM -->
					<!-- <form class="sidebar-search">
						<div class="input-box">
							<a href="javascript:;" class="remove"></a>
							<input type="text" placeholder="Ara..." />				
							<input type="button" class="submit" value=" " />
						</div>
					</form> -->
					<!-- END RESPONSIVE QUICK SEARCH FORM -->
				</li>
				<?php 
					
				
					echo $ust_menu;
					
					if($_SESSION['yetki'] == 9)
					{
						echo '<li class="start active ">
									<a href="?modul=form&sayfa=form">
									<i class="icon-home"></i> 
									<span class="title">Form Ayarları</span>
									<span class="selected"></span>
									</a>
								</li>';
					}
				?>
			</ul>
			<!-- END SIDEBAR MENU -->
		</div>
	
		<!-- END SIDEBAR -->
		<!-- BEGIN PAGE -->
		<div class="page-content">
			<!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->
			<div id="portlet-config" class="modal hide">
				<div class="modal-header">
					<button data-dismiss="modal" class="close" type="button"></button>
					<h3>Bilgi Penceresi</h3>
				</div>
				<div class="modal-body">
					<p>Dikkat sistem ürün yükleme modundadır.</p>
				</div>
			</div>
			<!-- END SAMPLE PORTLET CONFIGURATION MODAL FORM-->
			<!-- BEGIN PAGE CONTAINER-->
			<div class="container-fluid">
				
				
				<?php 
					
						if(re('modul') == "" or re('sayfa') == "")
						{
							include('sayfalar/anasayfa/anasayfa.php');
						}
						else
						{
							include('sayfalar/'.re('modul').'/'.re('sayfa').'.php');
						}
						
					?>
			</div>
			<!-- END PAGE CONTAINER-->		
		</div>
		<!-- END PAGE -->
	</div>
	<!-- END CONTAINER -->
	<!-- BEGIN FOOTER -->
	<!-- <div class="footer">
		2021 &copy; Sistemal Pert Dünyası.
		<div class="span pull-right">
			<span class="go-top"><i class="icon-angle-up"></i></span>
		</div>
	</div> -->
	<!-- END FOOTER -->
	<!-- BEGIN JAVASCRIPTS -->
	<!-- Load javascripts at bottom, this will reduce page load time -->
	<script src="assets/js/jquery-1.8.3.min.js"></script>	
	<!--[if lt IE 9]>
	<script src="assets/js/excanvas.js"></script>
	<script src="assets/js/respond.js"></script>	
	<![endif]-->	
	<script src="js/ea.js?v=<?=time() ?>"></script>	
	<script src="assets/breakpoints/breakpoints.js"></script>		
	<script src="assets/jquery-ui/jquery-ui-1.10.1.custom.min.js"></script>	
	<script src="assets/jquery-slimscroll/jquery.slimscroll.min.js"></script>
	<script src="assets/fullcalendar/fullcalendar/fullcalendar.min.js"></script>
	<script src="assets/bootstrap/js/bootstrap.min.js"></script>
	<script src="assets/js/jquery.blockui.js"></script>	
	<script src="assets/js/jquery.cookie.js"></script>
	<script src="assets/jqvmap/jqvmap/jquery.vmap.js?v=<?=time() ?>" type="text/javascript"></script>	
	<script src="assets/jqvmap/jqvmap/maps/jquery.vmap.russia.js" type="text/javascript"></script>
	<script src="assets/jqvmap/jqvmap/maps/jquery.vmap.world.js" type="text/javascript"></script>
	<script src="assets/jqvmap/jqvmap/maps/jquery.vmap.europe.js" type="text/javascript"></script>
	<script src="assets/jqvmap/jqvmap/maps/jquery.vmap.germany.js" type="text/javascript"></script>
	<script src="assets/jqvmap/jqvmap/maps/jquery.vmap.usa.js" type="text/javascript"></script>
	<script src="assets/jqvmap/jqvmap/data/jquery.vmap.sampledata.js" type="text/javascript"></script>	
	<script src="assets/flot/jquery.flot.js"></script>
	<script src="assets/flot/jquery.flot.resize.js"></script>
	<script type="text/javascript" src="assets/gritter/js/jquery.gritter.js"></script>
	<script type="text/javascript" src="assets/uniform/jquery.uniform.min.js"></script>	
	<script type="text/javascript" src="assets/js/jquery.pulsate.min.js"></script>
	<script type="text/javascript" src="assets/bootstrap-daterangepicker/date.js"></script>
	<script type="text/javascript" src="assets/bootstrap-daterangepicker/daterangepicker.js"></script>	
	<script src="../js/toastr/toastr.js"></script>
	<script src="assets/js/app.js?v=<?=time() ?>"></script>				
	<script>
		jQuery(document).ready(function() {		
			App.setPage("index");  // set current page
			App.init(); // init the rest of plugins and elements
		});
	</script>	
		
		
		<!--
		<div class="genel_dis">
		
		
		
		
		
		<!--
			<div class="ust_alan" onmouseover="hepsini_gotur();" style="top:50px;">
				<div class="ust_alan_ic">
					<div style="float:left;">
						EA Bilişim Yönetim Paneli
					</div>
					
					<div style="float:right; margin-top:-8px; padding-top:8px; cursor:pointer; padding-left:7px; padding-right:7px;" id="kullanici_p_dis" onmouseover="profil_ac();" >
						<div style="float:right; width:30px; height:35px; margin-top:-8px; overflow:hidden;">
							<img src="images/genel/r_cerceve.png" style="position:absolute; width:30px; height:30px; margin-top:3px;" id="kullanici_r_c_dis" />
							<img src="images/kullanicilar/<?php echo $kullanici_oku['resim']; ?>" width="100%" />
						</div>
						
						<div style="float:right; margin-right:10px;">Hoşgeldin <?php echo $kullanici_oku['adi'].' '.$kullanici_oku['soyadi']; ?></div>
					</div>
					<div style="float:right; background:black; margin-right:10px;">
						aa	
					
					</div>
				</div>
			</div>
			
	
			<div style="width:100%; float:left; position:fixed;  z-index:400; top:80px;" id="kapatmalik_alan_ust" >
				<div style="width:1000px; margin-left:auto; margin-right:auto;">
					<div style="float:left; width:100%; height:100%;" id="kapatmalik_alan" onmouseover="profil_kapat();"></div>
					<div class="profil_acilan_alan" id="acilacak_alan" >
						<a href="#" class="profil_acilan_eleman">
							<img src="images/genel/kullanici.png" style="position:absolute; margin-top:3px; width:16px;" />
							<div style="float:left; margin-left:20px;">Profili Düzenle</div>
						</a>
						<a href="?islem=cikis_yap" class="profil_acilan_eleman">
							<img src="images/genel/cikis_yap.png" style="position:absolute; margin-top:3px; width:15px;" />
							<div style="float:left; margin-left:20px;">Çıkış Yap</div>
						</a>
					</div>
				</div>
			</div>
			
			
			<div style="position:fixed; float:left; width:100%; height:100%; z-index:-10;" onmouseover="hepsini_gotur(), profil_kapat();"></div>
			-->
			<!--
			<div class="genel_ic" >
				<div class="ana_menu_dis" >
					<a href="index.php" class="ust_menu_ic tooltips" title="Anasayfa" data-placement="bottom" data-original-title="Anasayfa" onmouseover="hepsini_gotur(), profil_kapat();" ><img src="images/genel/home.png" style="width:30px;" /></a>
					<?php 
						$ust_menu = "";
						$sayi = 0;
						$sayi_alt = 0;
						$menu_cek = mysql_query("select * from p_menu where durum!='0' and kategori='0' ORDER BY sira ASC");
						while($menu_oku = mysql_fetch_array($menu_cek))
						{
							$bas = true;
							
							if($bas == true)
							{
								$alt_kat_cek = mysql_query("select * from p_menu where durum!='0' and kategori='".$menu_oku['id']."' ORDER BY sira ASC");
								$alt_kat_sayi = mysql_num_rows($alt_kat_cek);
								if($alt_kat_sayi = 0)
								{
									$sayi++;
									$ust_menu .= '<a href="?modul='.$menu_oku['modul'].'&sayfa='.$menu_oku['sayfa'].'" class="ust_menu_ic2" onmouseover="hepsini_gotur(), profil_kapat();" >Ürünler</a>';
								}
								else
								{
									$sayi++;
									$sayi_alt++;
									$ust_menu .= '<div class="etkisiz_menu_eleman" onmouseout="menu_gotur('.$sayi.');">
											<a href="?modul='.$menu_oku['modul'].'&sayfa='.$menu_oku['sayfa'].'" class="ust_menu_ic2" onmouseover="menu_getir('.$sayi.');" >'.$menu_oku['adi'].'</a>
											<div class="ana_alt_menu_dis" id="alt_m_'.$sayi.'" onmouseout="menu_gotur('.$sayi.'), profil_kapat();" >';
									while($alt_kat_oku = mysql_fetch_array($alt_kat_cek))
									{
										$ust_menu .= '<a href="?modul='.$alt_kat_oku['modul'].'&sayfa='.$alt_kat_oku['sayfa'].'" class="ana_alt_menu_eleman" >'.$alt_kat_oku['adi'].'</a>';
									}
									$ust_menu .= '</div></div>';
								}
							}
						}
						
						#echo $ust_menu;
					?>
					<input type="hidden" name="alt_menu_toplam" id="alt_menu_toplam" value="<?php echo $sayi_alt; ?>" />
				</div>
				
				<div class="alt_genel" onmouseover="hepsini_gotur(), profil_kapat();">
					
					<?php 
					/*
						if(re('modul') == "" or re('sayfa') == "")
						{
							include('sayfalar/anasayfa/anasayfa.php');
						}
						else
						{
							include('sayfalar/'.re('modul').'/'.re('sayfa').'.php');
						}
						*/
					?>
					
				</div>
			</div>
		</div>
		-->
		
		<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
		<!--<script src="assets/ckeditor/ckeditor.js"></script>-->
		<!--<script src="https://cdn.ckeditor.com/ckeditor5/27.0.0/classic/ckeditor.js"></script>-->
		<script src="https://kit.fontawesome.com/2fdd899201.js" crossorigin="anonymous" ></script>    <!-- Option 2: Separate Popper and Bootstrap JS -->
</body>
</html>

<script>
	function navbar_searchle(){
		var aranan=$("#navbar_aranan").val();
		jQuery.ajax({
			url: "https://ihale.pertdunyasi.com/check.php",
			type: "POST",
			dataType: "JSON",
			data: {
				action: "panel_arac_kodu",
				aranan:aranan,
			},
			success: function(response) {
					console.log(response);
					if(response.tur=="dogrudan"){
						window.location.href = "?modul=ihaleler&sayfa=navbar_search_dogrudan&navbar_aranan="+aranan;
					}else if(response.tur=="ilan"){
						window.location.href = "?modul=ihaleler&sayfa=navbar_search&navbar_aranan="+aranan;
					}else{
						alert("İstediğiniz kriterlere uygun araç bulunamadı.");
					}

			}
		});
		
		
	}
</script>