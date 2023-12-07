<style>
   .blink {
			animation: blinker 1.8s linear infinite;
			color: red;
			font-weight: bold;
		}
	@keyframes blinker {  
		50% { opacity: 0; }
   }
   .esit{
		color: red;
		font-weight: bold;
   }
	.yok{
		color: black;
   }
   	.yan {
		animation: blinker 0.9s linear infinite;
		color: red;
		font-size: 15px;
		font-weight: bold;
		font-family: sans-serif;
	}
	@keyframes blinker {  
		50% { opacity: 0; }
	}
	.kalin_kirmizi{
		color:red;
		font-weight:bold;
	}
</style>
<style>
	table {
		border-collapse: collapse;
		border-spacing: 0;
		width: 100%;
		border: 1px solid #ddd;
   }
	th, td {
		text-align: left;
		padding: 16px;
	}
	tr:nth-child(even) {
		background-color: #f2f2f2;
   }
	i{
		padding: 8px;
	}
	a{
		color: black;
	}
	a:hover{
		color: black;
	}
</style>
<style>
	.filter_box_outer
	{
		width:100%;
		min-height:10px;
		float:left;
		margin-bottom:20px;
	}

	.filter_box
	{
		min-width: 10px;
		height: 35px;
		background-color: #fff200;
		float: left;
		line-height: 35px;
		font-size: 16px;
		padding-right:45px;
		padding-left:15px;
		font-weight: 600;
		position:relative;
		font-family:"Helvetica Neue",Helvetica,Arial,sans-serif!important;
		margin-right:10px;
	}

	.filter_box_close
	{
		width:15px;
		height:35px;
		position:absolute;
		right:0px;
		top:0px;
		text-align: center;
    	line-height: 14px;
	}
</style>

<form method="POST" name="filter" id="filter">
	<div class="row-fluid searchs">
		<div class="span6">
			<div class="form-group">
				<h5>Plaka ile ara</h5>
				<?php
					if($_POST["aranan_plaka"]!=""){ ?>
						<input type="search" id="aranan_plaka" name="aranan_plaka" class="form-control" value="<?=$_POST["aranan_plaka"]?>" placeholder="Plaka">
					<?php } else { ?>
						<input type="search" id="aranan_plaka" name="aranan_plaka" class="form-control" placeholder="Plaka">
					<?php }
				?>
			</div>
			<div class="form-group">
				<h5>Araç kodu ile ara</h5>
				<?php
					if($_POST["aranan_arac_kodu"]!=""){ ?>
						<input type="search" id="aranan_arac_kodu" name="aranan_arac_kodu" class="form-control" value="<?=$_POST["aranan_arac_kodu"]?>" placeholder="Araç Kodu">
					<?php } else { ?>
						<input type="search" id="aranan_arac_kodu" name="aranan_arac_kodu" class="form-control" placeholder="Araç kodu">
					<?php }
				?>
			</div>
			<button type="submit" name="filtrele" id="filtrele" class="btn blue">Ara</button>
		</div>
	</div>
</form>

<?php 
if(isset($_POST['filtrele'])){
	$filtreler="";                
	$f_aranan_plaka = $_POST['aranan_plaka'];     
	$f_aranan_arac_kodu = $_POST['aranan_arac_kodu'];     

	//$where = "WHERE durum = '1'";
	$where = "WHERE id > '0' ";
	$filtre_var="false";
	
	if($f_aranan_plaka !=""){
		$where .= "AND plaka ='".$f_aranan_plaka."' ";
		
		$filtre_var="true";
		$filtreler.='
			<div class="filter_box">
				'.$f_aranan_plaka.'
				<div onclick="filtre_cikar(\'aranan_plaka\',\'filtre\');" class="filter_box_close">
					x
				</div>
			</div>	
		';
	}
	
	if($f_aranan_arac_kodu !=""){
		$where .= "AND arac_kodu ='".$f_aranan_arac_kodu."' ";
		
		$filtre_var="true";
		$filtreler.='
			<div class="filter_box">
				'.$f_aranan_arac_kodu.'
				<div onclick="filtre_cikar(\'aranan_arac_kodu\',\'filtre\');" class="filter_box_close">
					x
				</div>
			</div>	
		';
	}
	$filtre_cek = "SELECT * FROM ilanlar $where  ORDER BY concat(ihale_tarihi,' ',ihale_saati) asc";
	$result = mysql_query($filtre_cek) or die(mysql_error());
	
	$sayi = mysql_num_rows($result);
	

	if($sayi==0){
		echo '<script type="text/javascript">'; 
		echo 'alert("İstediğiniz kriterlere uygun araç bulunamadı.");'; 
		echo 'window.location.href = "?modul=dosya_yonetimi&sayfa=odeme_bekleyen";';
		echo '</script>';                       
	}else{ ?>
	
		<?php if($filtre_var=="true"){ ?>
			<p><a href="?modul=dosya_yonetimi&sayfa=odeme_bekleyen">Tümünü Temizle</a></p>
		<?php } ?>
		<div class="filter_box_outer">
			<?php 
				echo $filtreler;
			
			?>	
		</div>
	<div style=" height:400px; margin-top:2%;">
		<table class="table table-bordered"  cellspacing="1" cellpadding="1">
			<tr>
				<td>Düzenle</td>
				<td>Görseller</td>
				<td>Araç Kodu </td>
				<td>Plaka</td>
				<td>Detaylar</td>
				<td>Kazanan</td>
				<td>Kazandığı Teklif</td>
				<td>PD Hizmet Bedeli</td>
				<td>Dosya Masrafı</td>
				<td>Noter Ücreti</td>
				<td>Son Ödeme Tarihi</td>
				<td>Teklifler</td>
				<td>Favori</td>
				<td>Mesaj</td>
				<td>Notlar</td>
				<td>Açıklama</td>
				<td>Sigorta</td>
				<td>Ödeme Tutarı</td>
			</tr>
			<?php 

				while($iptalleri_oku = mysql_fetch_array($result)){
					$ilan_id = $iptalleri_oku['id'];
					
					
					$hepsini_cek = mysql_query("SELECT * FROM ilanlar WHERE id = '".$ilan_id."'");
					$hepsini_oku = mysql_fetch_array($hepsini_cek);
					
					$son_teklif=$hepsini_oku["son_teklif"];
					$ilan_teklif=mysql_query("select * from teklifler where ilan_id='".$ilan_id."' and teklif='".$son_teklif."' limit 1");
					$ilan_teklif_oku=mysql_fetch_assoc($ilan_teklif);
					
					$iptalleri_cek = mysql_query("SELECT * FROM kazanilan_ilanlar WHERE ilan_id='".$ilan_id."'");
					$iptalleri_oku = mysql_fetch_assoc($iptalleri_cek);
					
					$noter_takipci_gideri=mysql_query("select * from odeme_mesaji where id=1");
					$noter_oku=mysql_fetch_assoc($noter_takipci_gideri);
					
					if(mysql_num_rows($iptalleri_cek)>0){
						$kazanilan_teklif=$iptalleri_oku["kazanilan_teklif"];
						$pd_hizmet=$iptalleri_oku["pd_hizmet"];
						$dosya_masrafi=$iptalleri_oku["dosya_masrafi"];
						$noter_takipci=$iptalleri_oku["noter_takipci_gideri"];
						if($hepsini_oku["profil"]=="Hurda Belgeli"){
							$noter_ucreti="Noter devri esnasında hesaplanıcak";
							$toplam_ucret=$kazanilan_teklif+$dosya_masrafi+$pd_hizmet;
						}else{
							$noter_ucreti=money($noter_takipci)."₺";
							$toplam_ucret=$kazanilan_teklif+$dosya_masrafi+$pd_hizmet+$noter_takipci;
						}
						if(	date("d-m-Y",strtotime($iptalleri_oku["son_odeme_tarihi"]))=="30-11--0001" ){
							
							$son_odeme="";
						}else{
						
							$son_odeme=	date("d-m-Y",strtotime($iptalleri_oku["son_odeme_tarihi"]));
						}
						if($iptalleri_oku["son_odeme_tarihi"]==date("Y-m-d")){
							$son_odeme_class="kalin_kirmizi ";
						}
						else if($iptalleri_oku["son_odeme_tarihi"]<date("Y-m-d")){
							$son_odeme_class="yan ";
						}else{
							$son_odeme_class="";
						}
						$kazanan_kisi_cek = mysql_query("SELECT * FROM user WHERE id = '".$iptalleri_oku['uye_id']."' LIMIT 1"); 
						$kazanan_kisi_oku = mysql_fetch_assoc($kazanan_kisi_cek);
						$kazanan_adi = $kazanan_kisi_oku['ad'];
						
						$kazanan_teklif=money($kazanilan_teklif)."₺";
						$kazanan_pd=money($pd_hizmet)."₺";
						$kazanan_dosya=money($dosya_masrafi)."₺";
					}else if(mysql_num_rows($ilan_teklif)>0){
						$kazanilan_teklif=$ilan_teklif_oku["teklif"];
						$pd_hizmet=$ilan_teklif_oku["hizmet_bedeli"];
						$dosya_masrafi=$hepsini_oku["dosya_masrafi"];
						$noter_takipci=$noter_oku["noter_takipci_gideri"];
						if($hepsini_oku["profil"]=="Hurda Belgeli"){
							$noter_ucreti="Noter devri esnasında hesaplanıcak";
							$toplam_ucret=$kazanilan_teklif+$dosya_masrafi+$pd_hizmet;
						}else{
							$noter_ucreti=money($noter_takipci)."₺";
							$toplam_ucret=$kazanilan_teklif+$dosya_masrafi+$pd_hizmet+$noter_takipci;
						}
						$son_odeme="";
						$kazanan_adi="";
						$kazanan_teklif=money($kazanilan_teklif)."₺";
						$kazanan_pd=money($pd_hizmet)."₺";
						$kazanan_dosya=money($dosya_masrafi)."₺";
					}else{
						$kazanilan_teklif=$hepsini_oku["acilis_teklifi"];
						$pd_hizmet=$hepsini_oku["pd_hizmet"];
						$dosya_masrafi=$hepsini_oku["dosya_masrafi"];
						$noter_takipci=$noter_oku["noter_takipci_gideri"];
						if($hepsini_oku["profil"]=="Hurda Belgeli"){
							$noter_ucreti="Noter devri esnasında hesaplanıcak";
							$toplam_ucret=$kazanilan_teklif+$dosya_masrafi+$pd_hizmet;
						}else{
							$noter_ucreti=money($noter_takipci)."₺";
							$toplam_ucret=$kazanilan_teklif+$dosya_masrafi+$pd_hizmet+$noter_takipci;
						}
						$son_odeme="";
						$kazanan_adi="";
						$kazanan_teklif=money($kazanilan_teklif)."₺";
						$kazanan_pd=money($pd_hizmet)."₺";
						$kazanan_dosya=money($dosya_masrafi)."₺";
					}
					
					
					$sigorta_cek=mysql_query("select * from sigorta_ozellikleri where id='".$hepsini_oku['sigorta']."'");
					$sigorta_oku=mysql_fetch_array($sigorta_cek);
					
					$sigorta_adi=$sigorta_oku["sigorta_adi"];
					$sigorta_id=$sigorta_oku["sigorta_id"];
					
					
					$teklif_cek = mysql_query("SELECT * FROM teklifler WHERE ilan_id = '".$hepsini_oku['id']."' and durum=1");
					$teklif_sayi = mysql_num_rows($teklif_cek);
					$mesaj_cek = mysql_query("SELECT * FROM mesajlar WHERE ilan_id = '".$hepsini_oku['id']."' and alan_id !='0'");
					$mesaj_sayi = mysql_num_rows($mesaj_cek);
					$favori_cek = mysql_query("SELECT * FROM favoriler WHERE ilan_id = '".$hepsini_oku['id']."'");
					$favori_sayi = mysql_num_rows($favori_cek);
					$not_cek = mysql_query("SELECT * FROM ilan_notlari WHERE ilan_id = '".$hepsini_oku['id']."'");
					$not_sayi = mysql_num_rows($not_cek);
					
					$islem_id = $hepsini_oku["id"];

					if($hepsini_oku["ihale_tarihi"] < date("Y-m-d")){
						$class="blink";   
					}elseif($hepsini_oku["ihale_tarihi"] == date("Y-m-d")){ 
						$class="esit";
					}elseif($hepsini_oku["ihale_tarihi"] > date("Y-m-d")){
						$class="yok";
					}
					
					
				?>
			<tr>
				<?php 
					$marka_cek = mysql_query("SELECT * FROM marka WHERE markaID = '".$hepsini_oku['marka']."' LIMIT 1");
					$marka_oku = mysql_fetch_assoc($marka_cek);
					$marka_adi = $marka_oku['marka_adi'];
				?>
					<td><a target="_blank" href="?modul=ilanlar&sayfa=ilan_ekle&id=<?= $islem_id ?>"><i class="fas fa-edit"></i></a></td>
					<td><a target="_blank" href="?modul=ilanlar&sayfa=ilan_resim_ekle&id=<?= $islem_id ?>"><i class="far fa-image"></i></a></td>
					<td><?= $hepsini_oku["arac_kodu"] ?> </td>
					<td><?=$hepsini_oku["plaka"]?></td>
					<td><a target="_blank" href="../arac_detay.php?id=<?=$islem_id?>&q=ihale" style="text-decoration: none; color:#000000; cursor:pointer;"> 
						<?=$hepsini_oku["model_yili"]. " " .$marka_adi ." ". $hepsini_oku['model']." ". $hepsini_oku['tip'] ?></a>
					</td>
					<td><?=$kazanan_adi?></td>
					<td><?=$kazanan_teklif ?></td>
					<td><?=$kazanan_pd ?></td>
					<td><?=$kazanan_dosya ?></td>
					<td><?=$noter_ucreti ?></td>
					<td class="<?=$son_odeme_class  ?>" ><?=$son_odeme ?></td>
					<td><a class="view_ilan_teklifleri" id="ilanteklif_<?= $islem_id ?>"><i class="fas fa-gavel"><?=$teklif_sayi ?></i></a></td> 
					<td><a class="view_ilan_favorileri" id="<?= $islem_id ?>"><i class="fas fa-heart"><?=$favori_sayi ?></i></a></td>  
					<td><a class="view_ilan_mesajlari" id="ilanmesaj_<?= $islem_id ?>"><i class="fas fa-envelope"><?=$mesaj_sayi ?></i></a></td>   
					<td><a class="view_ilan_notlari" id="<?= $islem_id ?>"><i class="fas fa-align-justify"><?=$not_sayi ?></i></a></td> 
					<td> </td>
					<td>
						<a target="_blank" href="<?= $hepsini_oku["link"] ?>" style=""> 
							<?=$sigorta_adi ?>
						</a>
					</td>
					<td>
						<a data-toggle="modal" data-target="#odeme_tutari<?=$iptalleri_oku["ilan_id"] ?>?>" style="cursor: pointer; text-decoration:none; color:#000000;font-weight:bold;font-size:15px;">
							<?=money($toplam_ucret)."₺" ?>
						</a>
					</td>
					
				</tr>
				<div id="odeme_tutari<?=$iptalleri_oku["ilan_id"] ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
						<center>
							<h4 id="myModalLabel">PARÇALAR VE MTV</h4>
						</center>
					</div>
					<div class="modal-body">
						<div class="row-fluid">
							<div style="background-color: #cecece; padding: 1%;" class="span12">
								<div class="row-fluid">
									<div class="span3">
										<label for="IdofInput"></label>
									</div>
									<div class="span8">
										<div class="row-fluid">
											<div class="span6">
												<text style="color:#fff;font-size: 17px;">RAKAMLARI YAZINIZ</text>
											</div>
											<div class="span6">
												<text style="color:#fff;font-size: 17px;">NOTLAR</text>
											</div>
										</div>
									</div>
									<div class="span1">
									</div>
								</div>
								<div class="row-fluid">
									<div class="span3">
										<label style="color:#fff;;font-size: 18px;" for="IdofInput">PARÇA 1</label>
									</div>
									<div class="span8">
										<div class="row-fluid">
											<div class="span6">
												<input type="text" disabled value="<?=$statu_parca_2 ?>" name="parca_1" id="parca_1" class="span12" >
											</div>
											<div class="span6">
												<input type="text" value="<?=$statu_parca_1_not ?>" name="parca_1_not" id="parca_1_not" class="span12" >
											</div>
										</div>
									</div>
									<div class="span1">
										<i style="font-size:16px;" onclick="parca_kaydet(<?=$iptalleri_oku["ilan_id"] ?>,1)" class="fas fa-save"></i>
									</div>
								</div> 
								<div class="row-fluid">
									<div class="span3">
										<label style="color:#fff;font-size: 18px;" for="IdofInput">PARÇA 2</label>
									</div>
									<div class="span8">
										<div class="row-fluid">
											<div class="span6">
												<input type="text" disabled value="<?=$statu_parca_2 ?>" name="parca_2" id="parca_2" class="span12" >
											</div>
											<div class="span6">
												<input type="text" value="<?=$statu_parca_2_not ?>" name="parca_2_not" id="parca_2_not" class="span12" >
											</div>
										</div>
									</div>
									<div  class="span1">
										<i style="font-size:16px;" onclick="parca_kaydet(<?=$iptalleri_oku["ilan_id"] ?>,2)" class="fas fa-save"></i>
									</div>
								</div>
								<div class="row-fluid">
									<div class="span3">
										<label style="color:#fff;font-size: 18px;" for="IdofInput">PARÇA 3</label>
									</div>
									<div class="span8">
										<div class="row-fluid">
											<div class="span6">
												<input type="text" disabled value="<?=$statu_parca_3 ?>" name="parca_3" id="parca_3" class="span12" >
											</div>
											<div class="span6">
												<input type="text" value="<?=$statu_parca_3_not ?>" name="parca_3_not" id="parca_3_not" class="span12" >
											</div>
										</div>
									</div>
									<div  class="span1">
										<i style="font-size:16px;" onclick="parca_kaydet(<?=$iptalleri_oku["ilan_id"] ?>,3)" class="fas fa-save"></i>
									</div>
								</div>
								<div class="row-fluid">
									<div class="span3">
										<label style="color:#fff;font-size: 18px;" for="IdofInput">MTV</label>
									</div>
									<div class="span8">
										<div class="row-fluid">
											<div class="span6">
												<?php if($statu_mtv>0){ ?>
													<input type="text" disabled name="mtv" id="mtv" value="<?=$statu_mtv ?>" class="span12" >
												<?php } else { ?>
													<input type="text" disabled name="mtv" id="mtv" value="" class="span12" >
												<?php } ?>	
											</div>
											<div class="span6">
												<?php if($statu_mtv_not!=""){ ?>
													<input type="text" value="<?=$statu_mtv_not?>" name="mtv_not" id="mtv_not" class="span12" >
												<?php } else { ?>
													<input type="text" value="" name="mtv_not" id="mtv_not" class="span12" >
												<?php } ?>
											</div>
										</div>
									</div>
									<div  class="span1">
										<i onclick="mtv_kaydet(<?=$iptalleri_oku["ilan_id"] ?>);" style="font-size:16px;" class="fas fa-save"></i>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<div class="span3"></div>
						<div class="span6">
							<button class="btn btn-block" data-dismiss="modal" aria-hidden="true">KAPAT</button>
						</div>
						<div class="span3"></div>
					</div>
				</div>
		  <?php } ?>
	   </table>
	</div>
<?php } ?> 


<?php }else{ ?>
<div style="overflow-x:auto; overflow-y:auto; height:400px; margin-top:2%;">
	<table class="table table-bordered"  cellspacing="1" cellpadding="1">
		<tr>
			<td>Düzenle</td>
			<td>Görseller</td>
			<td>Araç Kodu </td>
			<td>Plaka</td>
			<td>Detaylar</td>
			<td>Kazanan</td>
			<td>Kazandığı Teklif</td>
			<td>PD Hizmet Bedeli</td>
			<td>Dosya Masrafı</td>
			<td>Noter Ücreti</td>
			<td>Son Ödeme Tarihi</td>
			<td>Teklifler</td>
			<td>Favori</td>
			<td>Mesaj</td>
			<td>Notlar</td>
			<td>Açıklama</td>
			<td>Sigorta</td>
			<td>Ödeme Tutarı</td>
		</tr>
		<?php 
			$iptalleri_cek = mysql_query("SELECT * FROM kazanilan_ilanlar WHERE durum = 4");
			while($iptalleri_oku = mysql_fetch_array($iptalleri_cek)){
				$iptal_id = $iptalleri_oku['ilan_id'];
				$hepsini_cek = mysql_query("SELECT * FROM ilanlar WHERE id = '".$iptal_id."'");
				$hepsini_oku = mysql_fetch_array($hepsini_cek);
				if(mysql_num_rows($hepsini_cek) != 0){


				$toplam_ucret=$iptalleri_oku["kazanilan_teklif"]+$iptalleri_oku["dosya_masrafi"]+$iptalleri_oku["pd_hizmet"]+$iptalleri_oku["noter_takipci_gideri"];
				$otomatik_mesaj=$iptalleri_oku["otomatik_mesaj"];
				$kazanilan_teklif=$iptalleri_oku["kazanilan_teklif"];
				$pd_hizmet=$iptalleri_oku["pd_hizmet"];
				$dosya_masrafi=$iptalleri_oku["dosya_masrafi"];
				$mtv=$iptalleri_oku["mtv"];
			
				
				
				
				
				$sigorta_cek=mysql_query("select * from sigorta_ozellikleri where id='".$hepsini_oku['sigorta']."'");
				$sigorta_oku=mysql_fetch_array($sigorta_cek);
				
				$sigorta_adi=$sigorta_oku["sigorta_adi"];
				$sigorta_id=$sigorta_oku["sigorta_id"];
				
				
				$teklif_cek = mysql_query("SELECT * FROM teklifler WHERE ilan_id = '".$hepsini_oku['id']."' and durum=1");
				$teklif_sayi = mysql_num_rows($teklif_cek);
				$mesaj_cek = mysql_query("SELECT * FROM mesajlar WHERE ilan_id = '".$hepsini_oku['id']."' and alan_id !='0'");
				$mesaj_sayi = mysql_num_rows($mesaj_cek);
				$favori_cek = mysql_query("SELECT * FROM favoriler WHERE ilan_id = '".$hepsini_oku['id']."'");
				$favori_sayi = mysql_num_rows($favori_cek);
				$not_cek = mysql_query("SELECT * FROM ilan_notlari WHERE ilan_id = '".$hepsini_oku['id']."'");
				$not_sayi = mysql_num_rows($not_cek);
				
				$islem_id = $hepsini_oku["id"];

				if($hepsini_oku["profil"]=="Hurda Belgeli"){
					$noter_ucreti="Noter devri esnasında hesaplanıcak";
				}else{
					$noter_ucreti=$iptalleri_oku["noter_takipci_gideri"];
				}

				if($iptalleri_oku["son_odeme_tarihi"]==date("Y-m-d")){
					$son_odeme_class="kalin_kirmizi ";
				}
				else if($iptalleri_oku["son_odeme_tarihi"]<date("Y-m-d")){
					$son_odeme_class="yan ";
				}else{
					$son_odeme_class="";
				}
				
				if($hepsini_oku["ihale_tarihi"] < date("Y-m-d")){
					$class="blink";   
				}elseif($hepsini_oku["ihale_tarihi"] == date("Y-m-d")){ 
					$class="esit";
				}elseif($hepsini_oku["ihale_tarihi"] > date("Y-m-d")){
					$class="yok";
				}
				
				if(	date("d-m-Y",strtotime($iptalleri_oku["son_odeme_tarihi"]))=="30-11--0001" ){
					$son_odeme="";
				}else{
					$son_odeme=	date("d-m-Y",strtotime($iptalleri_oku["son_odeme_tarihi"]));
				}
			?>
		<tr>
			<?php 
				$marka_cek = mysql_query("SELECT * FROM marka WHERE markaID = '".$hepsini_oku['marka']."' LIMIT 1");
				$marka_oku = mysql_fetch_assoc($marka_cek);
				$marka_adi = $marka_oku['marka_adi'];
				$kazanan_kisi_cek = mysql_query("SELECT * FROM user WHERE id = '".$iptalleri_oku['uye_id']."' LIMIT 1"); ?>
				<td><a target="_blank" href="?modul=ilanlar&sayfa=ilan_ekle&id=<?= $islem_id ?>"><i class="fas fa-edit"></i></a></td>
				<td><a target="_blank" href="?modul=ilanlar&sayfa=ilan_resim_ekle&id=<?= $islem_id ?>"><i class="far fa-image"></i></a></td>
				<td><?= $hepsini_oku["arac_kodu"] ?> </td>
				<td><?=$hepsini_oku["plaka"]?></td>
				<td><a target="_blank" href="../arac_detay.php?id=<?=$islem_id?>&q=ihale" style="text-decoration: none; color:#000000; cursor:pointer;"> 
					<?=$hepsini_oku["model_yili"]. " " .$marka_adi ." ". $hepsini_oku['model']." ". $hepsini_oku['tip'] ?></a>
				</td>
			 
				<?php 
				while($kazanan_kisi_oku = mysql_fetch_array($kazanan_kisi_cek)){ 
					$kazanan_adi = $kazanan_kisi_oku['ad'];?>
					<td><?=$kazanan_adi?></td>
					<td><?=money($kazanilan_teklif)."₺" ?></td>
					<td><?=money($pd_hizmet)."₺" ?></td>
					<td><?=money($dosya_masrafi)."₺" ?></td>
					<td><?=money($noter_ucreti)."₺" ?></td>
					<td class="" ><?=$son_odeme ?></td>
					<td><a class="view_ilan_teklifleri" id="<?= $islem_id ?>"><i class="fas fa-gavel"><?=$teklif_sayi ?></i></a></td> 
					<td><a class="view_ilan_favorileri" id="<?= $islem_id ?>"><i class="fas fa-heart"><?=$favori_sayi ?></i></a></td>  
					<td><a class="view_ilan_mesajlari" id="<?= $islem_id ?>"><i class="fas fa-envelope"><?=$mesaj_sayi ?></i></a></td>   
					<td><a class="view_ilan_notlari" id="<?= $islem_id ?>"><i class="fas fa-align-justify"><?=$not_sayi ?></i></a></td> 
					<td><?=$iptalleri_oku["aciklama"]?></td>
					<td>
						<a target="_blank" href="<?= $hepsini_oku["link"] ?>" style=""> 
							<?=$sigorta_adi ?>
						</a>
					</td>
					<td>
						<a data-toggle="modal" data-target="#odeme_tutari" style="cursor: pointer; text-decoration:none; color:#000000;font-weight:bold;font-size:15px;">
							<?=money($toplam_ucret)."₺" ?>
						</a>
					</td>
				<?php } ?>
			</tr>
      <?php } } ?>
   </table>
</div>
<?php } ?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="js/uyeler_modal.js?v=<? echo time();?>"></script>
<!-- Ödeme Tutarı Modal Başlangıç -->
<!-- Modal -->
<div id="odeme_tutari" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
   <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
      <center>
         <h4 id="myModalLabel">ÖDEME MESAJI</h4>
      </center>
   </div>
   <div class="modal-body">
	<?=$otomatik_mesaj ?>
   </div>
   <div class="modal-footer">
      <div class="span3"></div>
      <div class="span6">
         <button class="btn btn-block" data-dismiss="modal" aria-hidden="true">KAPAT</button>
      </div>
      <div class="span3"></div>
   </div>
</div>
<!-- Ödeme Tutarı Modal Bitiş -->

<!-- İlan Teklif-->
<div  class="custom-large-modal modal fade" id="ilan_teklif">
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
  </div>
   <div class="modal-dialog">
      <div class="modal-body" id="teklif_ilan">
      </div>
   </div>
</div>
<!-- İlan Teklif-->
<!-- İlan Fav-->
<div class="custom-large-modal modal fade" id="ilan_fav">
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
  </div>
   <div class="modal-dialog">
      <div class="modal-body" id="fav_ilan">
      </div>
   </div>
</div>
<!-- İlan Fav Bitiş-->
<!-- İlan Mesaj-->
<div style="width:75%;" class="custom-large-modal modal fade" id="ilan_mesaj">
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
  </div>
   <div class="modal-dialog">
      <div class="modal-body" id="mesaj_ilan">
      </div>
   </div>
</div>
<!-- İlan Mesaj Bitiş-->
<!-- İlan Notları Başlangıç-->
<div class="custom-large-modal modal fade" id="ilan_notlari">
	<button type="button" class="close" style="margin-right: 2%; margin-top:2%;" data-dismiss="modal" aria-hidden="true"></button>
	<div class="modal-dialog">
      <div class="modal-body" id="ilanin_notlarini">
      </div>
   </div>
</div>


<script>
	function filtre_cikar(key,value){
		window.location.href = "?modul=dosya_yonetimi&sayfa=iptal_edilen";
	}
	function parca_kaydet(ilan_id,parca_id){
		var secilen_parca="parca_"+parca_id;
		var secilen_parca_not="parca_"+parca_id+"_not";
		var parca=$("#parca_"+parca_id).val();
		var parca_not=$("#parca_"+parca_id+"_not").val();
		$.ajax({
			url: "https://ihale.pertdunyasi.com/check.php",
			method: 'POST',
			dataType: 'json',
			data: {
				action:"parca_guncelle",
				ilan_id:ilan_id,
				parca:parca,
				parca_not:parca_not,
				secilen_parca:secilen_parca,
				secilen_parca_not:secilen_parca_not
			},
			success: function(data) {
				console.log(data);
			},
			error: function(data) {
				
			}
		});		
	}
	function mtv_kaydet(ilan_id){
		var mtv=$("#mtv").val();
		var mtv_not=$("#mtv_not").val();
		$.ajax({
			url: "https://ihale.pertdunyasi.com/check.php",
			method: 'POST',
			dataType: 'json',
			data: {
				action:"mtv_guncelle",
				ilan_id:ilan_id,
				mtv:mtv,
				mtv_not:mtv_not
			},
			success: function(data) {
				console.log(data);

			},
			error: function(data) {
				
			}
		});		
	}
</script>


<?php 
	if(re('notu') =='Kaydet'){
		$admin_id = $_SESSION['kid'];
		$eklenecek_not = re('eklenecek_not');
		$gelen_id = re('gelen_id');
		$gizlilik = re('gizlilik');
		$tarih = date('Y-m-d H:i:s');
		if(isset($_FILES['files'])){     // dosya tanımlanmıs mı? 
			$errors= array(); 
			foreach($_FILES['files']['tmp_name'] as $key => $tmp_name ){ 
				$dosya_adi =$_FILES['files']['name'][$key]; 		// uzantiya beraber dosya adi 
				$dosya_boyutu =$_FILES['files']['size'][$key];    		// byte cinsinden dosya boyutu 
				$dosya_gecici =$_FILES['files']['tmp_name'][$key];		//gecici dosya adresi 
				$yenisim=md5(microtime()).$dosya_adi; 					//karmasik yeni isim.pdf 
				if($dosya_boyutu > 20971520){ 
					$errors[]='Maksimum 20 Mb lık dosya yuklenebilir.'; 
				}		                     
				$klasor="../assets"; // yuklenecek dosyalar icin yeni klasor 
				if(empty($errors)==true){  //eger hata yoksa 
					if(is_dir("$klasor/".$yenisim)==false){  //olusturdugumuz isimde dosya var mı?  
						$test=move_uploaded_file($dosya_gecici,"$klasor/".$yenisim);//yoksa yeni ismiyle kaydet 
						if($test==false){
							alert("asdjajsdasd");
						}
					}else{									//eger varsa 
						$new_dir="$klasor/".$yenisim.time(); //yeni ismin sonuna eklenme zamanını ekle 
						rename($dosya_gecici,$new_dir) ;				 
					}            			 
				}else{ 
					 print_r($errors); //varsa hataları yazdır 
				} 
			} 
			$yol='assets/'.$yenisim;
			
			if(empty($error)){ 
				
					$a=mysql_query("INSERT INTO `ilan_notlari` (`id`, `ilan_id`, `ekleyen`, `ilan_notu`, `gizlilik`, `tarih`, `dosya`) 
					VALUES (NULL, '".$gelen_id."', '".$admin_id."', '".$eklenecek_not."', '".$gizlilik."', '".$tarih."', '".$yol."')
					")or die(mysql_error()); 
                
          mysql_query("INSERT INTO `yapilan_is` (`id`, `admin_id`, `yaptigi`,`aciklama`, `ekleme_zamani`, `ilan_id`, `dogrudan_id`, `uye_id`) VALUES 
          (NULL, '".$admin_id."', '2','".$eklenecek_not."', '".$tarih."','','','".$gelen_id."');"); 
					if($a){
						alert("Başarıyla Eklendi..");
						header("Location:?modul=ihaleler&sayfa=tum_ihaleler");
            }
			} 
		}
	}

?>
