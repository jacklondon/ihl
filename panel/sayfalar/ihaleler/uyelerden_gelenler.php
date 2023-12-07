<?php 
   $hepsini_cek = mysql_query("select * from ilanlar where ihale_sahibi != '' order by id desc");
   $dogrudan_cek = mysql_query("select * from dogrudan_satisli_ilanlar where ilan_sahibi !='' order by id desc");
?>
<style>
	table {
		border-collapse: collapse;
		border-spacing: 0;
		width: 100%;
		border: 1px solid #ddd;	
	}
	.chec
	{
		opacity:1!important;
		z-index:999!important;
	}
			.chec2
	{
		opacity:1!important;
		z-index:999!important;
	}
	th, td {
		text-align: left;
		padding: 8px;
	}
	i{
		padding: 8px;	
	}
	tr:nth-child(even) {
		background-color: #f2f2f2;	
	}
	.checker span input {
		opacity:1!important;
		margin-top: -3px !important;
	}
</style>





<div class="tabbable">
	<!-- Only required for left/right tabs -->
	<!-- ilanTrigger
dogrudanTrigger -->
	<ul class="nav nav-tabs">
		<li class="active" onclick="ilanTrigger()"><a id="ihale_islem" href="#tab1" data-toggle="tab">İhaleler</a></li>
		<li onclick="dogrudanTrigger()"><a id="dogrudan_islem" href="#tab2" data-toggle="tab">Doğrudan Satışlı İlanlar</a></li>
	</ul>
	<div class="tab-content">
		<div class="tab-pane active" id="tab1">
			<div style="overflow-x:auto; margin-top:2%;">
				<?php
					$admin_yetki_cek=mysql_query("Select * from kullanicilar where id='".$admin_id."' ");
					$admin_yetki_oku=mysql_fetch_assoc($admin_yetki_cek);
					$yetkiler=$admin_yetki_oku["yetki"];
					$yetki_parcala=explode("|",$yetkiler);
					$btn='';
					if ( in_array(1, $yetki_parcala) ) { 
						$btn='<input onclick="ilanTrigger();return confirm(\'Silmek İstediğinize emin misiniz?\');" type="submit" name="uye_secili_sil" class="btn-danger" value="Seçili Olanları Sil">';
					}   
					else{
						$btn='';
					}
					
				?> 
				<form method="POST" action="?modul=ihaleler&sayfa=toplu_sil">
					<a><? echo $btn ?></a>
				
				<table class="table table-bordered" cellspacing="1" cellpadding="1">
					<tr style="background-color: rgb(191,191,191);">
						<td><input type="checkbox" class="checkall btn btn-blue" style="padding:20px;opacity:1 !important; z-index:999;">Tümünü Seç</td>
						<td>Plaka</td>
						<td>Kod</td>
						<td>Model Yılı/Marka/Model/Tip/Şehir</td>
						<td>İlanı Ekleyen</td>
						<td>Ekleme Tarihi</td>
						<td>İhale Tarihi</td>
						<td>Durum</td>
						<td>Menu</td>
					</tr>
					<?php 
						while($hepsini_oku = mysql_fetch_array($hepsini_cek)){
							$marka_cek = mysql_query("select * from marka where markaID = '".$hepsini_oku['marka']."'");
							$marka_oku = mysql_fetch_assoc($marka_cek);
							$markasi = $marka_oku['marka_adi'];
							$token_user = $hepsini_oku['ihale_sahibi'];
							$kullanici_cek = mysql_query("SELECT * FROM `user` WHERE user_token = '".$token_user."' ");

							if(mysql_num_rows($kullanici_cek)==0){
								$kullanici_tipi = "kurumsal";
								$kullanici_cek = mysql_query("SELECT * FROM `user` WHERE kurumsal_user_token = '".$token_user."'");								
							}else{
								$kullanici_tipi = "bireysel";
							}
							
							$menu='';
							$ihale_id = $hepsini_oku['id'];
							$durum = "";
								if($hepsini_oku['durum']==0){
									$durum = "Onay Bekliyor";
									$arkaplan = "yellow";
									$color = "#000000";
										$menu='
											<li><a tabindex="-1" onclick="ihaleTrigger()" href="../arac_detay.php?id='.$ihale_id.'&q=ihale" target="_blank">Önizleme </a></li>		
											<li><a tabindex="-1" onclick="ihaleTrigger()" href="?modul=ihaleler&sayfa=ihale_islemleri&id='.$ihale_id.'&q=yayinla">Yayınla</a></li>
											<li><a tabindex="-1" onclick="ihaleTrigger()" href="?modul=ilanlar&sayfa=ihale_islemleri&id='.$ihale_id.'&q=reddet">Reddet</a></li>
											<li><a tabindex="-1" onclick="ihaleTrigger()" href="?modul=ilanlar&sayfa=ilan_ekle&id='.$ihale_id.'" target="_blank">Düzenle</a></li>
											<li><a tabindex="-1" onclick="ihaleTrigger()" href="?modul=ihaleler&sayfa=ihale_islemleri&id='.$ihale_id.'&q=sil" onclick="return confirm(\'Silmek İstediğinize Eminmisiniz ?\')">Sil</a></li>
										';
								}elseif($hepsini_oku['durum']==1){
									$durum = "Yayında";
									$arkaplan = "green";
									$color = "#ffffff";
									$menu='
											<li><a tabindex="-1" onclick="ihaleTrigger()" href="../arac_detay.php?id='.$ihale_id.'&q=ihale" target="_blank">Önizleme </a></li>
											<li><a tabindex="-1" onclick="ihaleTrigger()" href="?modul=ihaleler&sayfa=ihale_islemleri&id='.$ihale_id.'&q=yayindan_kaldir">Yayından Kaldır</a></li>
											<li><a tabindex="-1" onclick="ihaleTrigger()" href="?modul=ilanlar&sayfa=ilan_ekle&id='.$ihale_id.'" target="_blank">Düzenle</a></li>
											<li><a tabindex="-1" onclick="ihaleTrigger()" href="?modul=ihaleler&sayfa=ihale_islemleri&id='.$ihale_id.'&q=sil" onclick="return confirm(\'Silmek İstediğinize Eminmisiniz ?\')">Sil</a></li>
										';
								}elseif($hepsini_oku['durum']==2){
									$durum = "Admin İlanı Sildi";
									$arkaplan = "red";
									$color = "#ffffff";
									$menu='
											<li><a tabindex="-1" onclick="ihaleTrigger()" href="?modul=ihaleler&sayfa=ihale_islemleri&id='.$ihale_id.'&q=tekrar_yayinla">Tekrar Yayına Al</a></li>
											<li><a tabindex="-1" onclick="ihaleTrigger()" href="?modul=ilanlar&sayfa=ilan_ekle&id='.$ihale_id.'" target="_blank">Düzenle</a></li>
										';
								}elseif($hepsini_oku['durum']==-1){
									$durum = "Süresi Bitti";
									$arkaplan = "red";
									$color = "#ffffff";
									$menu='
											<li><a tabindex="-1" onclick="ihaleTrigger()" href="../arac_detay.php?id='.$ihale_id.'&q=ihale" target="_blank">Önizleme </a></li>
											<li><a tabindex="-1" onclick="ihaleTrigger()" href="?modul=ihaleler&sayfa=ihale_islemleri&id='.$ihale_id.'&q=tekrar_yayinla">Tekrar Yayına Al</a></li>
											<li><a tabindex="-1" onclick="ihaleTrigger()" href="?modul=ilanlar&sayfa=ilan_ekle&id='.$ihale_id.'" target="_blank">Düzenle</a></li>
											<li><a tabindex="-1" onclick="ihaleTrigger()" href="?modul=ihaleler&sayfa=ihale_islemleri&id='.$ihale_id.'&q=sil" onclick="return confirm(\'Silmek İstediğinize Eminmisiniz ?\')">Sil</a></li>
										';
								}elseif($hepsini_oku['durum']==-2){
									$durum = "Admin İlanı Onaylamadı";
									$arkaplan = "red";
									$color = "#ffffff";
									$menu='
										<li><a tabindex="-1" onclick="ihaleTrigger()" href="../arac_detay.php?id='.$ihale_id.'&q=ihale" target="_blank">Önizleme </a></li>
										<li><a tabindex="-1" onclick="ihaleTrigger()" href="?modul=ihaleler&sayfa=ihale_islemleri&id='.$ihale_id.'&q=yayinla">Yayınla</a></li>
										<li><a tabindex="-1" onclick="ihaleTrigger()" href="?modul=ilanlar&sayfa=ilan_ekle&id='.$ihale_id.'" target="_blank">Düzenle</a></li>
										<li><a tabindex="-1" onclick="ihaleTrigger()" href="?modul=ihaleler&sayfa=ihale_islemleri&id='.$ihale_id.'&q=sil" onclick="return confirm(\'Silmek İstediğinize Eminmisiniz ?\')">Sil</a></li>
									';
								}elseif($hepsini_oku['durum']==-3){
									$durum = "Admin İlanı Yayından Kaldırdı";
									$arkaplan = "red";
									$color = "#ffffff";
									$menu='
											<li><a tabindex="-1" onclick="ihaleTrigger()" href="?modul=ihaleler&sayfa=ihale_islemleri&id='.$ihale_id.'&q=tekrar_yayinla">Tekrar Yayına Al</a></li>
											<li><a tabindex="-1" onclick="ihaleTrigger()" href="?modul=ilanlar&sayfa=ilan_ekle&id='.$ihale_id.'" target="_blank">Düzenle</a></li>
											<li><a tabindex="-1" onclick="ihaleTrigger()" href="?modul=ihaleler&sayfa=ihale_islemleri&id='.$ihale_id.'&q=sil" onclick="return confirm(\'Silmek İstediğinize Eminmisiniz ?\')">Sil</a></li>
										';
								}elseif($hepsini_oku['durum']==-4){
									$durum = "Üye İlanı Yayından Kaldırdı";
									$arkaplan = "red";
									$color = "#ffffff";
									$menu='
											<li><a tabindex="-1" onclick="ihaleTrigger()" href="../arac_detay.php?id='.$ihale_id.'&q=ihale" target="_blank">Önizleme </a></li>
											<li><a tabindex="-1" onclick="ihaleTrigger()" href="?modul=ihaleler&sayfa=ihale_islemleri&id='.$ihale_id.'&q=tekrar_yayinla">Tekrar Yayına Al</a></li>
											<li><a tabindex="-1" onclick="ihaleTrigger()" href="?modul=ilanlar&sayfa=ilan_ekle&id='.$ihale_id.'" target="_blank">Düzenle</a></li>
											<li><a tabindex="-1" onclick="ihaleTrigger()" href="?modul=ihaleler&sayfa=ihale_islemleri&id='.$ihale_id.'&q=sil" onclick="return confirm(\'Silmek İstediğinize Eminmisiniz ?\')">Sil</a></li>
										';
								}
						?>
					<tr>
						<td><input type="checkbox" class="chec" style="opacity:1!important; z-index:999;" name="secim[]" id="asd<?=$ihale_id ?>" value="<?=$ihale_id ?>"></td>
						<td><?=$hepsini_oku["plaka"]?></td>
						<td><?=$hepsini_oku["arac_kodu"]?></td>
						<td><?=$hepsini_oku["model_yili"]." ".$markasi." ".$hepsini_oku["model"]." ".$hepsini_oku["tip"]." ".$hepsini_oku["sehir"]?></td>
						<?php 
						$kullanici_oku = mysql_fetch_assoc($kullanici_cek); 
						if($kullanici_tipi == "bireysel"){
							$ekleyen_adi = $kullanici_oku["ad"];
						}else{
							$ekleyen_adi = $kullanici_oku["unvan"];
						}
						?>						
						<td style="display: none;"><?= $kullanici_oku['ad']?></td>
						<td><?= $ekleyen_adi?></td>
						<td><?=date("d-m-Y", strtotime($hepsini_oku["eklenme_zamani"]))?></td>            
						<td><?=date("d-m-Y H:i:s", strtotime($hepsini_oku["ihale_tarihi"]. " ". $hepsini_oku["ihale_saati"]))?></td>
						<td style="background-color: <?= $arkaplan ?>; color:<?= $color ?>;"><?=$durum ?></td>
						<td>
							<div class="btn-group">
								<a class="btn dropdown-toggle btn-mini" data-toggle="dropdown" href="#">
									Menu<span class="caret"></span>
								</a>
								<ul class="dropdown-menu" style="position: absolute; transform: translate3d(90px, 10px, 0px); top: -55px; left: -200px; will-change: transform;" >
									<?=$menu ?>
								</ul>
							</div>
						</td>
					</tr>
					<?php } ?>
				</table>
				</form>
			</div>
		</div>
		<div class="tab-pane" id="tab2">
			<!-- <div style="overflow-y:visible; height:400px; margin-top:2%;"> -->
			<div style="overflow-x:auto; margin-top:2%;">
				<?php
					$admin_yetki_cek=mysql_query("Select * from kullanicilar where id='".$admin_id."' ");
					$admin_yetki_oku=mysql_fetch_assoc($admin_yetki_cek);
					$yetkiler=$admin_yetki_oku["yetki"];
					$yetki_parcala=explode("|",$yetkiler);
					$btn='';
					if ( in_array(1, $yetki_parcala) ) { 
						$btn='<input onclick="dogrudanTrigger();return confirm(\'Silmek İstediğinize emin misiniz?\');" type="submit" name="uye_dogrudan_secili_sil" class="btn-danger" value="Seçili Olanları Sil">';
					}   
					else{
						$btn='';
					}
				?> 
				<form method="POST" action="?modul=ihaleler&sayfa=toplu_sil">
					<a><? echo $btn ?></a>
					<table class="table table-bordered" cellspacing="1" cellpadding="1">
						<tr style="background-color: rgb(191,191,191);">
							<td><input type="checkbox" class="checkall2 btn btn-blue" style="padding:20px;opacity:1!important; z-index:999;">Tümünü Seç</td>
							<td>Plaka</td>
							<td>Kod</td>
							<td>Model Yılı/Marka/Model/Tip/Şehir</td>
							<td>İlanı Ekleyen</td>
							<td>Ekleme Tarihi</td>
							<td>Yayın Bitiş Tarihi</td>
							<td>Durum</td>
							<td>Menu</td>
						</tr>
						<?php 
							while($dogrudan_oku = mysql_fetch_array($dogrudan_cek)){ 
								$token_user2 = $dogrudan_oku['ilan_sahibi'];
								$kullanici_cek2 = mysql_query("SELECT * FROM `user` WHERE user_token = '$token_user2' ");
								if(mysql_num_rows($kullanici_cek2)==0){
									$kullanici_tipi = "kurumsal";
									$kullanici_cek2 = mysql_query("SELECT * FROM `user` WHERE kurumsal_user_token = '$token_user2' ");
								}else{
									$kullanici_tipi = "bireysel";
								}
								$kullanici_oku = mysql_fetch_assoc($kullanici_cek2);
								if($kullanici_tipi == "bireysel"){
									$ekleyen_adi = $kullanici_oku["ad"];
								}else{
									$ekleyen_adi = $kullanici_oku["unvan"];
								}


								/*$dogrudan_id = $dogrudan_oku['id'];                        
								$durum = "";
									if($dogrudan_oku['durum']==0){
										$durum = "Onay Bekliyor";
										$arkaplan = "yellow";
										$color = "#000000";
									}elseif($dogrudan_oku['durum']==1){
										$durum = "Yayında";
										$arkaplan = "green";
										$color = "#ffffff";
									}elseif($dogrudan_oku['durum']==-1){
										$durum = "Süresi Bitti";
										$arkaplan = "red";
										$color = "#ffffff";
									}elseif($dogrudan_oku['durum']==-2){
										$durum = "Admin İlanı Onaylamadı";
										$arkaplan = "red";
										$color = "#ffffff";
									}elseif($dogrudan_oku['durum']==-3){
										$durum = "Admin İlanı Yayından Kaldırdı";
										$arkaplan = "red";
										$color = "#ffffff";
									}    */	
								$dogrudan_id = $dogrudan_oku['id'];
								$durum = "";
								$menu2='';
							
								if($dogrudan_oku['durum']==0){
										$durum = "Onay Bekliyor";
										$arkaplan = "yellow";
										$color = "#000000";
										$menu2='
											<li><a tabindex="-1" onclick="dogrudanTrigger()" href="../arac_detay.php?id='.$dogrudan_id.'&q=dogrudan" target="_blank">Önizleme </a></li>	
											<li><a tabindex="-1" onclick="dogrudanTrigger()" href="?modul=ihaleler&sayfa=ihale_islemleri&id='.$dogrudan_id.'&q=dogrudan_yayinla">Yayınla</a></li>
											<li><a tabindex="-1" onclick="dogrudanTrigger()" href="?modul=ihaleler&sayfa=ihale_islemleri&id='.$dogrudan_id.'&q=dogrudan_reddet">Reddet</a></li>
											<li><a tabindex="-1" onclick="dogrudanTrigger()" href="?modul=ihaleler&sayfa=dogrudan_satis_duzenle&id='.$dogrudan_id.'" target="_blank">Düzenle</a></li>
											<li><a tabindex="-1" onclick="dogrudanTrigger()" href="?modul=ihaleler&sayfa=ihale_islemleri&id='.$dogrudan_id.'&q=dogrudan_sil" onclick="return confirm(\'Silmek istediğinize emin misiniz ?\')">Sil</a></li>
										';
									}elseif($dogrudan_oku['durum']==1){
										$durum = "Yayında";
										$arkaplan = "green";
										$color = "#ffffff";
										$menu2='
												<li><a tabindex="-1" onclick="dogrudanTrigger()" href="../arac_detay.php?id='.$dogrudan_id.'&q=dogrudan" target="_blank">Önizleme </a></li>
												<li><a tabindex="-1" onclick="dogrudanTrigger()" href="?modul=ihaleler&sayfa=ihale_islemleri&id='.$dogrudan_id.'&q=dogrudan_yayindan_kaldir">Yayından Kaldır</a></li>
												<li><a tabindex="-1" onclick="dogrudanTrigger()" href="?modul=ihaleler&sayfa=dogrudan_satis_duzenle&id='.$dogrudan_id.'" target="_blank">Düzenle</a></li>
												<li><a tabindex="-1" onclick="dogrudanTrigger()" href="?modul=ihaleler&sayfa=ihale_islemleri&id='.$dogrudan_id.'&q=dogrudan_sil" onclick="return confirm(\'Silmek istediğinize emin misiniz ?\')">Sil</a></li>
											';
									}elseif($dogrudan_oku['durum']==-1){
										$durum = "Süresi Bitti";
										$arkaplan = "red";
										$color = "#ffffff";
										$menu2='
												<li><a tabindex="-1" onclick="dogrudanTrigger()" href="../arac_detay.php?id='.$dogrudan_id.'&q=dogrudan" target="_blank">Önizleme </a></li>
												<li><a tabindex="-1" onclick="dogrudanTrigger()" href="?modul=ihaleler&sayfa=ihale_islemleri&id='.$dogrudan_id.'&q=dogrudan_tekrar_yayinla">Tekrar Yayına Al</a></li>
												<li><a tabindex="-1" onclick="dogrudanTrigger()" href="?modul=ihaleler&sayfa=dogrudan_satis_duzenle&id='.$dogrudan_id.'" target="_blank">Düzenle</a></li>
												<li><a tabindex="-1" onclick="dogrudanTrigger()" href="?modul=ihaleler&sayfa=ihale_islemleri&id='.$dogrudan_id.'&q=dogrudan_sil" onclick="return confirm(\'Silmek istediğinize emin misiniz ?\')">Sil</a></li>
											';
									}elseif($dogrudan_oku['durum']==-2){
										$durum = "Admin İlanı Onaylamadı";
										$arkaplan = "red";
										$color = "#ffffff";
										$menu2='
												<li><a tabindex="-1" onclick="dogrudanTrigger()" href="../arac_detay.php?id='.$dogrudan_id.'&q=dogrudan" target="_blank">Önizleme </a></li>
												<li><a tabindex="-1" onclick="dogrudanTrigger()" href="?modul=ihaleler&sayfa=ihale_islemleri&id='.$dogrudan_id.'&q=dogrudan_yayinla">Yayınla</a></li>
												<li><a tabindex="-1" onclick="dogrudanTrigger()" href="?modul=ihaleler&sayfa=dogrudan_satis_duzenle&id='.$dogrudan_id.'" target="_blank">Düzenle</a></li>
												<li><a tabindex="-1" onclick="dogrudanTrigger()" href="?modul=ihaleler&sayfa=ihale_islemleri&id='.$dogrudan_id.'&q=dogrudan_sil" onclick="return confirm(\'Silmek istediğinize emin misiniz ?\')">Sil</a></li>
											';
									}elseif($dogrudan_oku['durum']==-3){
										$durum = "Admin İlanı Yayından Kaldırdı";
										$arkaplan = "red";
										$color = "#ffffff";
										$menu2='
												<li><a tabindex="-1" onclick="dogrudanTrigger()" href="?modul=ihaleler&sayfa=ihale_islemleri&id='.$dogrudan_id.'&q=dogrudan_tekrar_yayinla">Tekrar Yayına Al</a></li>
												<li><a tabindex="-1" onclick="dogrudanTrigger()" href="?modul=ihaleler&sayfa=dogrudan_satis_duzenle&id='.$dogrudan_id.'" target="_blank">Düzenle</a></li>
												<li><a tabindex="-1" onclick="dogrudanTrigger()" href="?modul=ihaleler&sayfa=ihale_islemleri&id='.$dogrudan_id.'&q=dogrudan_sil" onclick="return confirm(\'Silmek istediğinize emin misiniz ?\')">Sil</a></li>
											';
									}elseif($dogrudan_oku['durum']==-4){
										$durum = "Üye İlanı Yayından Kaldırdı";
										$arkaplan = "red";
										$color = "#ffffff";
										$menu2='
												<li><a tabindex="-1" onclick="dogrudanTrigger()" href="../arac_detay.php?id='.$dogrudan_id.'&q=dogrudan" target="_blank">Önizleme </a></li>
												<li><a tabindex="-1" onclick="dogrudanTrigger()" href="?modul=ihaleler&sayfa=ihale_islemleri&id='.$dogrudan_id.'&q=dogrudan_sil" onclick="return confirm(\'Silmek istediğinize emin misiniz ?\')">Sil</a></li>
											';
									} 
								?>
								<tr>
									<td><input type="checkbox" class="chec2" name="secim[]" class="chec" id="asd<?=$dogrudan_oku["id"] ?>" value="<?=$dogrudan_oku["id"] ?>"  style="opacity:1!important; z-index:999;" ></td>
									<td><?=$dogrudan_oku["plaka"]?></td>
									<td><?=$dogrudan_oku["arac_kodu"]?></td>
									<td><?=$dogrudan_oku["model_yili"]." ".$dogrudan_oku["marka"]." ".$dogrudan_oku["model"]." ".$dogrudan_oku["sehir"]?></td>
									
									<td style="display:none"><?=$kullanici_oku2['ad']?></td>
									<td><?=$ekleyen_adi?></td>
									<td><?= date("d-m-Y H:i:s", strtotime($dogrudan_oku["eklenme_tarihi"]. " ".$dogrudan_oku["eklenme_saati"])) ?></td>
									<td><?= date("d-m-Y H:i:s", strtotime($dogrudan_oku["bitis_tarihi"])) ?></td>
									<td style="background-color: <?= $arkaplan ?>; color:<?= $color ?>;"><?=$durum ?></td>
									<td>
										<div class="btn-group">
											<a class="btn dropdown-toggle btn-mini" data-toggle="dropdown" href="#">
												Menu<span class="caret"></span>
											</a>
											<ul class="dropdown-menu" style="position: absolute; transform: translate3d(90px, 10px, 0px); top: -80px; left: -200px; will-change: transform;" >
												<?=$menu2 ?>
											</ul>
										</div>
									</td>
								</tr>
						<?php } ?>
					</table>
				</form>
			</div>
		</div>
	</div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
	function ilanTrigger(){
		localStorage.removeItem("islem");
		localStorage.setItem("islem","0");
	}
	function dogrudanTrigger(){
		localStorage.removeItem("islem");
		localStorage.setItem("islem","1");
	}
	
	window.onload = islem_cek;
	function islem_cek() {
		var islem_getir = localStorage.getItem('islem');
		if(islem_getir == 0){
			document.getElementById("ihale_islem").click();		
			localStorage.removeItem("islem");
		}else if(islem_getir == 1 ){
			document.getElementById("dogrudan_islem").click();		
			localStorage.removeItem("islem");
		}
	}
		var clicked = false;
	$(".checkall").on("click", function() {
	  $(".chec").prop("checked", !clicked);
	  clicked = !clicked;
	  this.innerHTML = clicked ? 'Seçimleri Kaldır' : 'Tümünü Seç';
	});
	var clicked2 = false;
		$(".checkall2").on("click", function() {
	  $(".chec2").prop("checked", !clicked2);
	  clicked2 = !clicked2;
	  this.innerHTML = clicked2 ? 'Seçimleri Kaldır' : 'Tümünü Seç';
	});
</script>