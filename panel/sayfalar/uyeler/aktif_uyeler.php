<?php 
	session_start();
	$admin_id=$_SESSION['kid'];
	online_sorgulama();
	$son_bes=date("Y-m-d H:i:s",strtotime("-5 minutes"));
	$now=date("Y-m-d H:i:s");
	$uyeleri_cek = mysql_query("SELECT user.*,onayli_kullanicilar.id as o_id FROM `user` inner join onayli_kullanicilar on user.id=onayli_kullanicilar.user_id where user.son_islem_zamani between '".$son_bes."' and '".$now."' and onayli_kullanicilar.durum=1 order by id desc");
	$sehir_cek = mysql_query("SELECT * FROM sehir");
	$admin_cek = mysql_query("SELECT * FROM kullanicilar");
?>
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.10/jquery.mask.js"></script>
	<script src="js/uyeler_modal.js?v=<? echo time(); ?>"></script>
	<style>
		table {
			border-collapse: collapse;
			border-spacing: 0;
			width: 100%;
			border: 1px solid #ddd;
		}
		/* th, td { padding: 8px 16px; text-align: left; font-size: 10px;} */
		i{
			color:black;
			padding: 8px;
		}
		/* .table thead tr th{
			font-size: 8px;
		} */
		tr:nth-child(even) {
			background-color: #f2f2f2;
		}
		th { 
			background:white; 
			font-size: 10px;
		}
		a{
		cursor: pointer;
		}
	</style>
	<style>
	
		.chec
		{
			opacity:1!important;
			z-index:999!important;
		}
		
		/* .checker span
		{
			background:transparent!important;
		} */
		
	</style>
	<style>
		.multiselect {
			width: 200px;
		}
		.selectBox {
			position: relative;
		}
		.selectBox select {
			width: 100%;
			font-weight: bold;
		}
		.overSelect {
			position: absolute;
			left: 0;
			right: 0;
			top: 0;
			bottom: 0;
		}
		#sehirler {
			display: none;
			border: 1px #dadada solid;
		}
		#sehirler label {
			display: block;
		}
		#sehirler label:hover {
			background-color: #1e90ff;
		}
		#adminler {
			display: none;
			border: 1px #dadada solid;
		}
		#adminler label {
			display: block;
		}
		#adminler label:hover {
			background-color: #1e90ff;
		}
		#uye_grubu {
			display: none;
			border: 1px #dadada solid;
		}
		#uye_grubu label {
			display: block;
		}
		#uye_grubu label:hover {
			background-color: #1e90ff;
		}
		#uye_durumu {
			display: none;
			border: 1px #dadada solid;
		}
		#uye_durumu label {
			display: block;
		}
		#uye_durumu label:hover {
			background-color: #1e90ff;
		}
		#uye_ilgi {
			display: none;
			border: 1px #dadada solid;
		}
		#uye_ilgi label {
			display: block;
		}
		#uye_ilgi label:hover {
			background-color: #1e90ff;
		}
		.offscreen {
			opacity: 0;
			position: absolute;
			z-index: -9999;
			pointer-events: none;
		}
		.general_search_check
		{
			position:relative;
			z-index:99;
		}
	</style>

	<style>
		.select_backdrop
		{
			width:100%;
			height:100vh;
			position:fixed;
			left:0px;
			top:0px;
			display:none;
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
	<div class="select_backdrop" id="sehirler_backdrop" onclick="showSehirler()">
	</div>

	<div class="select_backdrop" id="durum_backdrop" onclick="showDurum()">
	</div>

	<div class="select_backdrop" id="adminler_backdrop" onclick="showAdminler()">
	</div>

	<div class="select_backdrop" id="grup_backdrop" onclick="showGrup()">
	</div>
	
	<div class="select_backdrop" id="ilgi_backdrop" onclick="showIlgi()">
	</div>

	<form method="POST" name="filter" id="filter">
		<div class="row-fluid" style="margin-top: 2%;">
			<div class="span6">
				<label for="IDofInput">Kelime İle Ara</label>
				<?php
					if($_POST["aranan"]!=""){ ?>
						<input type="search" id="aranan" name="aranan" class="span12"  value="<?=$_POST["aranan"]?>" placeholder="Ad,Soyad,Cinsiyet ile arama yapınız ...">
					<?php } else { ?>
						<input type="search" id="aranan" name="aranan" class="span12" placeholder="Ad,Soyad,Cinsiyet ile arama yapınız ...">
					<?php }
				?>
				<div class="multiselect">
					<div class="selectBox" onclick="showSehirler()">
						<select style="height:1.8em;" class="span12">
							<option>Şehire Göre</option>
						</select>
						<div class="overSelect"></div>
					</div>
					<div class="general_search_check" id="sehirler">	
						<?php
							$seciliSehirSayisi = count($_POST['sehir']);
							if($seciliSehirSayisi!=0){
								$sehir_check=array();
								$tu = 0;
								while($sehir_oku = mysql_fetch_array($sehir_cek)){
									$sehir_check[$tu]="";
									for($i=0;$i<count($_POST['sehir']);$i++){ 
										if($sehir_oku["sehiradi"]==$_POST["sehir"][$i]){
											$sehir_check[$tu]="checked";
										}
									} ?>
									<label for="<?= $sehir_oku['sehirID'] ?>">
									<input type="checkbox" <?=$sehir_check[$tu] ?> id="sehir_<?= $sehir_oku['sehiradi'] ?>" id="sehir_<?=$sehir_oku['sehiradi'] ?>" name="sehir[]" value="<?= $sehir_oku['sehiradi'] ?>" /><?= $sehir_oku['sehiradi'] ?>
								<?php $tu++; }
							?>
							<?php }else{
								while($sehir_oku = mysql_fetch_array($sehir_cek)){?>                        
								   <label for="<?= $sehir_oku['sehirID'] ?>">
								   <input type="checkbox" name="sehir[]" id="sehir_<?= $sehir_oku['sehiradi'] ?>" value="<?= $sehir_oku['sehiradi'] ?>" /><?= $sehir_oku['sehiradi'] ?></label>
								<?php }
							}
						?>
					</div>
				</div>
				<label for="IDofInput">Telefon Numarasına Göre</label>
				<?php if($_POST["aranan_tel"]!="" ){?>
					<input type="tel" id="aranantel" name="aranan_tel" value="<?=$_POST["aranan_tel"] ?>" class="span12">
				<?php }else{ ?>
					<input type="tel" id="aranantel" name="aranan_tel" class="span12">
				<?php } ?>
	
				
				<label for="IDofInput">Mail Adresine Göre</label>
				<?php if($_POST["aranan_mail"]!=""){?>
					<input type="email" id="arananmail" name="aranan_mail" value="<?=$_POST["aranan_mail"] ?>" class="span12">
				<?php }else{ ?>
					<input type="email" id="arananmail" name="aranan_mail" class="span12">
				<?php } ?>

				
				<div class="multiselect">
					<div class="selectBox" onclick="showDurum()">
						<select style="height:1.8em;" class="span12">
							<option>Üye Durumuna Göre</option>
						</select>
						<div class="overSelect"></div>
					</div>
					<div  class="general_search_check" id="uye_durumu">
						<?php 
						$seciliDurumSayisi = count($_POST['uye_durum']);
						if($seciliDurumSayisi!=0){ 
							$aktif_checked="";
							$kisitlama_admin_checked="";
							$kisitlama_risk_checked="";
							$kisitlama_giris_checked="";
							$iptal_checked="";
							for($i=0;$i<count($_POST["uye_durum"]);$i++){
								if($_POST["uye_durum"][$i]=="1"){
									$aktif_checked="checked";
								}
								if($_POST["uye_durum"][$i]=="2"){
									$kisitlama_admin_checked="checked";
								}
								if($_POST["uye_durum"][$i]=="3"){
									$kisitlama_risk_checked="checked";
								}
								if($_POST["uye_durum"][$i]=="4"){
									$kisitlama_giris_checked="checked";
								}
								if($_POST["uye_durum"][$i]=="5"){
									$iptal_checked="checked";
								}
							}?>
							<input type="checkbox" <?=$aktif_checked ?> id="durum_1" name="uye_durum[]" value="1" />Aktif</label><br>
							<input type="checkbox" <?=$kisitlama_admin_checked ?> id="durum_2" name="uye_durum[]" value="2" />Teklif Kısıtlaması (Admin)</label><br>
							<input type="checkbox" <?=$kisitlama_risk_checked ?> id="durum_3" name="uye_durum[]" value="3" />Teklif Kısıtlaması (Risk)</label><br>
							<input type="checkbox" <?=$kisitlama_giris_checked ?> id="durum_4" name="uye_durum[]" value="4" />Sisteme Giriş Kısıtlaması</label><br>
							<input type="checkbox" <?=$iptal_checked ?> id="durum_5" name="uye_durum[]" value="5" />Üyelik İptali</label><br>
							
						<?php }else { ?>
							<input type="checkbox" id="durum_1" name="uye_durum[]" value="1" />Aktif</label><br>
							<input type="checkbox" id="durum_2" name="uye_durum[]" value="2" />Teklif Kısıtlaması (Admin)</label><br>
							<input type="checkbox" id="durum_3" name="uye_durum[]" value="3" />Teklif Kısıtlaması (Risk)</label><br>
							<input type="checkbox" id="durum_4" name="uye_durum[]" value="4" />Sisteme Giriş Kısıtlaması</label><br>
							<input type="checkbox" id="durum_5" name="uye_durum[]" value="5" />Üyelik İptali</label><br>
						<?php } ?>
					</div>
				</div>
				
				<div class="multiselect">
					<div class="selectBox" onclick="showIlgi()">
						<select style="height:1.8em;" class="span12">
							<option>İlgilendiği Araç Türü</option>
						</select>
						<div class="overSelect"></div>
					</div>
					<div  class="general_search_check" id="uye_ilgi">
						<?php 
						$seciliDurumSayisi = count($_POST['uye_ilgi']);
						if($seciliDurumSayisi!=0){ 
				
							$plakali_checked="";
							$cekme_admin_checked="";
							$hurda_checked="";
							$otomobil_checked="";
							$cekici_checked="";
							$dorse_checked="";
							$motosiklet_checked="";
							$traktor_checked="";
							$luks_checked="";
					
							for($i=0;$i<count($_POST["uye_ilgi"]);$i++){
								if($_POST["uye_ilgi"][$i]=="1"){
									$plakali_checked="checked";
								}
								if($_POST["uye_ilgi"][$i]=="2"){
									$cekme_admin_checked="checked";
								}
								if($_POST["uye_ilgi"][$i]=="3"){
									$hurda_checked="checked";
								}
								if($_POST["uye_ilgi"][$i]=="4"){
									$otomobil_checked="checked";
								}
								if($_POST["uye_ilgi"][$i]=="5"){
									$cekici_checked="checked";
								}
								if($_POST["uye_ilgi"][$i]=="6"){
									$dorse_checked="checked";
								}
								if($_POST["uye_ilgi"][$i]=="7"){
									$motosiklet_checked="checked";
								}
								if($_POST["uye_ilgi"][$i]=="8"){
									$traktor_checked="checked";
								}
								if($_POST["uye_ilgi"][$i]=="9"){
									$luks_checked="checked";
								}
							}?>
							<input type="checkbox" <?=$plakali_checked ?> id="ilgi_1" name="uye_ilgi[]" value="1" />Plakalı Ruhsatlı</label><br>
							<input type="checkbox" <?=$cekme_admin_checked ?> id="ilgi_2" name="uye_ilgi[]" value="2" />Çekme Belgeli</label><br>
							<input type="checkbox" <?=$hurda_checked ?> id="ilgi_3" name="uye_ilgi[]" value="3" />Hurda Belgeli</label><br>
							<input type="checkbox" <?=$otomobil_checked ?> id="ilgi_4" name="uye_ilgi[]" value="4" />Otomobil</label><br>
							<input type="checkbox" <?=$cekici_checked ?> id="ilgi_5" name="uye_ilgi[]" value="5" />Çekici ve Kamyon</label><br>
							<input type="checkbox" <?=$dorse_checked ?> id="ilgi_6" name="uye_ilgi[]" value="6" />Dorse</label><br>
							<input type="checkbox" <?=$motosiklet_checked ?> id="ilgi_7" name="uye_ilgi[]" value="7" />Motosiklet</label><br>
							<input type="checkbox" <?=$traktor_checked ?> id="ilgi_8" name="uye_ilgi[]" value="8" />Traktör</label><br>
							<input type="checkbox" <?=$luks_checked ?> id="ilgi_9" name="uye_ilgi[]" value="9" />Sadece lüks segment</label><br>
							
						<?php }else { ?>
							<input type="checkbox"  id="ilgi_1" name="uye_ilgi[]" value="1" />Plakalı Ruhsatlı</label><br>
							<input type="checkbox"  id="ilgi_2" name="uye_ilgi[]" value="2" />Çekme Belgeli</label><br>
							<input type="checkbox"  id="ilgi_3" name="uye_ilgi[]" value="3" />Hurda Belgeli</label><br>
							<input type="checkbox"  id="ilgi_4" name="uye_ilgi[]" value="4" />Otomobil</label><br>
							<input type="checkbox"  id="ilgi_5" name="uye_ilgi[]" value="5" />Çekici ve Kamyon</label><br>
							<input type="checkbox"  id="ilgi_6" name="uye_ilgi[]" value="6" />Dorse</label><br>
							<input type="checkbox"  id="ilgi_7" name="uye_ilgi[]" value="7" />Motosiklet</label><br>
							<input type="checkbox"  id="ilgi_8" name="uye_ilgi[]" value="8" />Traktör</label><br>
							<input type="checkbox"  id="ilgi_9" name="uye_ilgi[]" value="9" />Sadece lüks segment</label><br>
						<?php } ?>
					</div>
				</div>
			</div>
			<div class="span6">
				<label for="IDofInput">Kayıt Tarihine Göre</label>
					<?php if($_POST["kayit1"]!="" && $_POST["kayit1"]!="01-01-1970 03:00:00" ){?>
							<input type="date" id="kayit1" name="kayit1" value="<?=$_POST["kayit1"] ?>" class="span12">
						<?php }else{ ?>
							<input type="date" id="kayit1" name="kayit1" class="span12">
						<?php } ?>
					<?php if($_POST["kayit2"]!="" && $_POST["kayit2"]!="01-01-1970 03:00:00" ){?>
						<input type="date" id="kayit2" name="kayit2" value="<?=$_POST["kayit2"] ?>" class="span12">
					<?php }else{ ?>
						<input type="date" id="kayit2" name="kayit2" class="span12">
					<?php } ?>
				<label for="IDofInput">Son Giriş Aralığına Göre</label>
					<?php if($_POST["giris1"]!="" && $_POST["giris1"]!="01-01-1970 03:00:00" ){?>
							<input type="date" id="giris1" name="giris1" value="<?=$_POST["giris1"] ?>" class="span12">
						<?php }else{ ?>
							<input type="date" id="giris1" name="giris1" class="span12">
						<?php } ?>
					<?php if($_POST["giris2"]!="" && $_POST["giris2"]!="01-01-1970 03:00:00" ){?>
						<input type="date" id="giris2" name="giris2" value="<?=$_POST["giris2"] ?>" class="span12">
					<?php }else{ ?>
						<input type="date" id="giris2" name="giris2" class="span12">
					<?php } ?>
					
				<div class="multiselect">
					<div class="selectBox" onclick="showAdminler()">
						<select style="height:1.8em;" class="span12">
							<option>Müşteri Temsilcisine Göre</option>
						</select>
						<div class="overSelect"></div>
					</div>
					<div id="adminler">
						
						<?php
						$admin_cek = mysql_query("select * from kullanicilar");
						$seciliAdminSayisi = count($_POST['admin']);
						if($seciliAdminSayisi!=0){
							$admin_check=array();
							$tu = 0;
							while($admin_oku = mysql_fetch_array($admin_cek)){
								$admin_check[$tu]="";
								for($i=0;$i<count($_POST['admin']);$i++){ 
									if($admin_oku["id"]==$_POST["adminler"][$i]){
										$admin_check[$tu]="checked";
									}
								} ?>
								<label for="<?= $admin_oku['id'] ?>">
								<input type="checkbox" <?=$admin_check[$tu] ?> id="admin_<?= $admin_oku['id'] ?>" name="admin[]" value="<?= $admin_oku['id'] ?>" /><?= $admin_oku['adi']." ".$admin_oku['soyadi'] ?></label>
							<?php $tu++; }
						?>
						<?php }else{
							while($admin_oku = mysql_fetch_array($admin_cek)){?>                        
								<label for="<?= $admin_oku['id'] ?>">
								<input type="checkbox" name="admin[]" id="admin_<?= $admin_oku['id'] ?>" value="<?= $admin_oku['id'] ?>" /><?= $admin_oku['adi']." ".$admin_oku['soyadi'] ?></label>
							<?php } 
						}
					?>
						
					
					</div>
				</div>
				<div class="multiselect">
					<div class="selectBox" onclick="showGrup()">
						<select style="height:1.8em;" class="span12">
							<option>Üye Grubuna Göre</option>
						</select>
						<div class="overSelect"></div>
					</div>
					<?php 
						$uye_grup_cek = mysql_query("SELECT * FROM uye_grubu"); 
					?>
					<div class="general_search_check" id="uye_grubu">
						<?php

							$seciliUyeGrubuSayisi = count($_POST['grup']);
							if($seciliUyeGrubuSayisi!=0){
								$grup_check=array();
								$tu = 0;
								while($uye_grup_oku = mysql_fetch_array($uye_grup_cek)){
									$grup_check[$tu]="";
									for($i=0;$i<count($_POST['grup']);$i++){ 
										if($uye_grup_oku["id"]==$_POST["grup"][$i]){
											$grup_check[$tu]="checked";
										}
									} ?>
									<label for="<?= $uye_grup_oku['id'] ?>">
									<input type="checkbox" <?=$grup_check[$tu] ?> id="grup_<?= $uye_grup_oku['id'] ?>" name="grup[]" value="<?= $uye_grup_oku['id'] ?>" /><?= $uye_grup_oku['grup_adi']?></label>
								<?php $tu++; }
							?>
							<?php }else{
								while($uye_grup_oku = mysql_fetch_array($uye_grup_cek)){?>                        
									<label for="<?= $uye_grup_oku['id'] ?>">
									<input type="checkbox" name="grup[]" id="grup_<?= $uye_grup_oku['id'] ?>" value="<?= $uye_grup_oku['id'] ?>" /><?=  $uye_grup_oku['grup_adi'] ?></label>
								<?php } 
							}
						?>
						
					
					</div>
				</div>
			</div>
		</div>
		<button type="submit" id="filtrele" name="filtrele" class="btn blue">Ara</button>
	</form>
	<?php
		function tarih_saat_formatla($tarih){
			$date = str_replace('/', '-', $tarih);
			$yeni_tarih=date('d-m-Y H:i:s', strtotime($date));
			return $yeni_tarih;
		}
	?>
	<?php
		function tarih_saat_formatla_yeni($tarih_yeni){
			$date = str_replace('/', '-', $tarih_yeni);
			$yeni_tarih=date('d-m-Y H:i:s', strtotime($date));
			return $yeni_tarih;
		}
	?>
	<?php 
		if(isset($_POST['filtrele'])){       
		$filtreler=""; 
		$f_kelime = $_POST['aranan'];     
		$f_sehir = $_POST['sehir'];
		$f_telefon = $_POST['aranan_tel'];
		$f_mail = $_POST['aranan_mail'];
		$f_ilk_tarih =tarih_saat_formatla($_POST['kayit1']) ;
		$f_ikinci_tarih =tarih_saat_formatla($_POST['kayit2']) ;
		$f_giris1 =$_POST['giris1'] ;
		$f_giris2 =$_POST['giris2'] ;
		$f_admin = $_POST['admin'];
		$f_grup = $_POST['grup'];
		$f_uye_durum = $_POST['uye_durum'];
		$f_uye_ilgi = $_POST['uye_ilgi'];

		$where = "WHERE u.son_islem_zamani between '".$son_bes."' and '".$now."' and u.id > '0'";
	    $filtre_var="false";
		if($f_kelime !=""){
			/* $where .= " AND concat(ad,cinsiyet,mail,uye_olma_sebebi,sehir,meslek,ilgilendigi_turler,adres,kargo_adresi,fatura_adresi,paket,unvan,vergi_dairesi,yedek_kisi,yedek_kisi_tel) LIKE '%".$f_kelime."%'";*/
			$where .= " AND concat(ad,cinsiyet,mail,uye_olma_sebebi,sehir,meslek,ilgilendigi_turler,adres,kargo_adresi,fatura_adresi,paket,unvan,vergi_dairesi,yedek_kisi,tc_kimlik,sehir,ilce) LIKE '%".$f_kelime."%'";
			
			$filtre_var="true";
			$filtreler.='
				<div class="filter_box">
					'.$f_kelime.'
					<div onclick="filtre_cikar(\'aranan\',\'filtre\');" class="filter_box_close">
						x
					</div>
				</div>	
			';
			
		}
		if($f_telefon !=""){
			$filtre_var="true";
			$filtreler.='
				<div class="filter_box">
					'.$f_telefon.'
					<div onclick="filtre_cikar(\'aranantel\',\'filtre\');" class="filter_box_close">
						x
					</div>
				</div>	
			';
			$where .= " AND concat(telefon,sabit_tel) LIKE '%".$f_telefon."%' or yedek_kisi_tel LIKE '%".$f_telefon."%'";
		}
		if($f_mail !=""){
			$filtre_var="true";
			$filtreler.='
				<div class="filter_box">
					'.$f_mail.'
					<div onclick="filtre_cikar(\'arananmail\',\'filtre\');" class="filter_box_close">
						x
					</div>
				</div>	
			';
			$where .= " AND concat(mail,ad) LIKE '%".$f_mail."%'";
		}

		if($f_ilk_tarih !="" && ($f_ikinci_tarih !="" && $f_ikinci_tarih !="01-01-1970 03:00:00" )){
			
			$f_ilk_tarih_yeni = date("Y-m-d H:i:s",strtotime($f_ilk_tarih));
			$f_ikinci_tarih_yeni = date("Y-m-d",strtotime($f_ikinci_tarih));
			$f_ikinci_tarih_yeni = $f_ikinci_tarih_yeni." 23:59:59";
			if( $f_ikinci_tarih_yeni != '1970-01-01 23:59:59' || $f_ilk_tarih_yeni != '1970-01-01 03:00:00' ){
				$where .= " AND  kayit_tarihi BETWEEN '".$f_ilk_tarih_yeni."' AND '".$f_ikinci_tarih_yeni."' ";
				$onclick='';
				$filtre_var="true";
				$onclick='onclick="filtre_cikar(\'kucukbuyuk_\',\'kayit\')";';
				$filtreler.='
					<div class="filter_box">
						Kayıt tarih: '.date("d-m-Y",strtotime($f_ilk_tarih_yeni)).' - '.date("d-m-Y",strtotime($f_ikinci_tarih_yeni)).'
						<div '.$onclick.' class="filter_box_close">
							x
						</div>
					</div>	
				';
			}
			
			
			
        
		}else if($f_ilk_tarih !="" && ($f_ikinci_tarih == "" || $f_ikinci_tarih == "01-01-1970 03:00:00" ) ){
			$f_ilk_tarih_yeni = date("Y-m-d",strtotime($f_ilk_tarih));
			if($f_ilk_tarih_yeni != '1970-01-01' ){
				$where .= "AND  kayit_tarihi ='".$f_ilk_tarih_yeni."'";
				$onclick='';
				$filtre_var="true";
				$onclick='onclick="filtre_cikar(\'kayit\',\'1\')";';
				$filtreler.='
					<div class="filter_box">
						Kayıt tarih: '.date("d-m-Y",strtotime($f_ilk_tarih_yeni)).'
						<div '.$onclick.' class="filter_box_close">
							x
						</div>
					</div>	
				';
			}
		}
		
		if($f_giris1 !="" && ($f_giris2 !="" && $f_giris2 !='01-01-1970 03:00:00' ) ){
			$f_giris1_yeni = date("Y-m-d H:i:s",strtotime($f_giris1));
			$f_giris2_yeni = date("Y-m-d",strtotime($f_giris2));
			$f_giris2_yeni = $f_giris2_yeni." 23:59:59";
			if( $f_giris1_yeni != '1970-01-01 23:59:59' ||  $f_giris2_yeni != '1970-01-01 03:00:00' ){
				$where .= " AND  son_islem_zamani BETWEEN '".$f_giris1_yeni."' AND '".$f_giris2_yeni."'";
				$onclick='';
				$filtre_var="true";
				$onclick='onclick="filtre_cikar(\'kucukbuyuk_\',\'giris\')";';
				$filtreler.='
					<div class="filter_box">
						Son Giriş tarih: '.date("d-m-Y",strtotime($f_giris1_yeni)).' - '.date("d-m-Y",strtotime($f_giris2_yeni)).'
						<div '.$onclick.' class="filter_box_close">
							x
						</div>
					</div>	
				';
			}
		}else if($f_giris1 !="" && ($f_giris2 =="" || $f_girs2=="01-01-1970 03:00:00" )){
			$f_giris1_yeni = date("Y-m-d",strtotime($f_giris1));
			if( $f_giris1_yeni != '1970-01-01 23:59:59' ||  $f_giris2_yeni != '1970-01-01 03:00:00' ){
				$where .= "AND  son_islem_zamani ='".$f_giris1_yeni."'";
				$onclick='';
				$filtre_var="true";
				$onclick='onclick="filtre_cikar(\'giris\',\'1\')";';
				$filtreler.='
					<div class="filter_box">
						Son Giriş tarih: '.date("d-m-Y",strtotime($f_giris1_yeni)).'
						<div '.$onclick.' class="filter_box_close">
							x
						</div>
					</div>	
				';
			}
		}
		
		if($f_sehir !=""){
			$filtre_var="true";
			$i = 0;
			$seciliSehirSayisi = count($_POST['sehir']);
			$seciliSehir = "";
			while ($i < $seciliSehirSayisi) {
				
				$onclick='';
				$onclick='onclick="filtre_cikar(\'sehir_\',\''.$_POST["sehir"][$i].'\')"';
				$filtreler.='
					<div class="filter_box">
						'.$_POST['sehir'][$i].'
						<div '.$onclick.' class="filter_box_close">
							x
						</div>
					</div>	
				';
				
				$seciliSehir = $seciliSehir . "'" . $_POST['sehir'][$i] . "'";
				if ($i < $seciliSehirSayisi - 1) {
					$seciliSehir = $seciliSehir . ", ";
				}
				$i ++;
			}
			$where = $where . " AND sehir in (" . $seciliSehir . ")";
		}
		
		if($f_admin !=""){
			$filtre_var="true";
			$i = 0;
			$seciliAdminSayisi = count($_POST['admin']);
			$seciliAdmin = "";
			while ($i < $seciliAdminSayisi) {
				$admin_read=mysql_query("select * from kullanicilar where id='".$_POST["admin"][$i]."'");
				$admin_fetch=mysql_fetch_assoc($admin_read);
				$onclick='';
				$onclick='onclick="filtre_cikar(\'admin_\',\''.$_POST["admin"][$i].'\')"';
				$filtreler.='
					<div class="filter_box">
						'.$admin_fetch['adi']." ".$admin_fetch['soyadi'].'
						<div '.$onclick.' class="filter_box_close">
							x
						</div>
					</div>	
				';
				
				$seciliAdmin = $seciliAdmin . "'" . $_POST['admin'][$i] . "'";
				if ($i < $seciliAdminSayisi - 1) {
					$seciliAdmin = $seciliAdmin . ", ";
				}
				$i ++;
			}
			$where = $where . " AND temsilci_id in (" . $seciliAdmin . ")";
		}
		
		if($f_grup !=""){
			$filtre_var="true";
			$i = 0;
			$seciliGrupSayisi = count($_POST['grup']);
			$seciliGrup = "";
			while ($i < $seciliGrupSayisi) {
				$grup_read=mysql_query("select * from uye_grubu where id='".$_POST["grup"][$i]."'");
				$grup_fetch=mysql_fetch_assoc($grup_read);
				$onclick='';
				$onclick='onclick="filtre_cikar(\'grup_\',\''.$_POST["grup"][$i].'\')"';
				$filtreler.='
					<div class="filter_box">
						'.$grup_fetch['grup_adi'].'
						<div '.$onclick.' class="filter_box_close">
							x
						</div>
					</div>	
				';
				$seciliGrup = $seciliGrup . "'" . $_POST['grup'][$i] . "'";
				if ($i < $seciliGrupSayisi - 1) {
					$seciliGrup = $seciliGrup . ", ";
				}
				$i ++;
			}
			$where = $where . " AND paket in (" . $seciliGrup . ")";
		}
		if($f_uye_durum !=""){
			$filtre_var="true";
			$d = 0;
			$seciliDurumSayisi = count($_POST['uye_durum']);
			$seciliDurum = "";
			while ($d < $seciliDurumSayisi) {
				/* 	$seciliDurum = $seciliDurum . "'" . $_POST['uye_durum'][$d] . "'";
					if ($d < $seciliDurumSayisi - 1) {
						$seciliDurum = $seciliDurum . ", ";
					}
					$d ++;
				*/
				$onclick='';
				$secili_durum_text="";
				if($_POST['uye_durum'][$d]=="1"){
					$seciliDurum.=" and online_durum=1 ";
					$secili_durum_text="Aktif";
				}else if($_POST['uye_durum'][$d]=="2"){
					$seciliDurum.=" and u_d.teklif_engelle='on' ";
					$secili_durum_text="Teklif Kısıtlaması (Admin)";
				}else if($_POST['uye_durum'][$d]=="3"){
					$seciliDurum.=" and u_d.otomatik_teklif_engelle='on' ";
					$secili_durum_text="Teklif Kısıtlaması (Risk)";
				}else if($_POST['uye_durum'][$d]=="4"){
					$seciliDurum.=" and u_d.kalici_mesaj='on' ";
					$secili_durum_text="Sisteme Giriş Kısıtlaması";
				}else if($_POST['uye_durum'][$d]=="5"){
					$seciliDurum.=" and u_d.uyelik_iptal='on' ";
					$secili_durum_text="Üyelik İptali";
				}else{
					$seciliDurum.="";
					$secili_durum_text="";
				}
				$d++;
				
				$onclick='onclick="filtre_cikar(\'durum_\',\''.$_POST['uye_durum'][$d].'\')"';
				$filtreler.='
					<div class="filter_box">
						'.$secili_durum_text.'
						<div '.$onclick.' class="filter_box_close">
							x
						</div>
					</div>	
				';  
				
			}
			// $where = $where . " AND risk in (" . $seciliDurum . ")";
			$where=$where.$seciliDurum;
		}
		if($f_uye_ilgi !=""){
			$filtre_var="true";
			$d = 0;
			$seciliİlgiSayisi = count($_POST['uye_ilgi']);
			
			$seciliİlgi = "and (";
					
			while ($d < $seciliİlgiSayisi) {
				/* 	$seciliDurum = $seciliDurum . "'" . $_POST['uye_durum'][$d] . "'";
					if ($d < $seciliDurumSayisi - 1) {
						$seciliDurum = $seciliDurum . ", ";
					}
					$d ++;
				*/
				$onclick='';
				$secili_ilgi_text="";
				if($_POST['uye_ilgi'][$d]=="1"){
					if($d!=$seciliİlgiSayisi-1){
						$seciliİlgi.=" ilgilendigi_turler like '%,Plakalı Ruhsatlı%' or ilgilendigi_turler like '%Plakalı Ruhsatlı,%' or ilgilendigi_turler like '%,Plakalı Ruhsatlı,%' or ilgilendigi_turler like '%Plakalı Ruhsatlı%' or ";
					}else{
						$seciliİlgi.=" ilgilendigi_turler like '%,Plakalı Ruhsatlı%' or ilgilendigi_turler like '%Plakalı Ruhsatlı,%' or ilgilendigi_turler like '%,Plakalı Ruhsatlı,%' or ilgilendigi_turler like '%Plakalı Ruhsatlı%' ";
					}
					
					$secili_ilgi_text="Plakalı Ruhsatlı";
				}else if($_POST['uye_ilgi'][$d]=="2"){
					if($d!=$seciliİlgiSayisi-1){
						$seciliİlgi.=" ilgilendigi_turler like '%,Çekme Belgeli%' or ilgilendigi_turler like '%Çekme Belgeli,%' or ilgilendigi_turler like '%,Çekme Belgeli,%' or ilgilendigi_turler like '%Çekme Belgeli%' or ";
					}else{
						$seciliİlgi.=" ilgilendigi_turler like '%,Çekme Belgeli%' or ilgilendigi_turler like '%Çekme Belgeli,%' or ilgilendigi_turler like '%,Çekme Belgeli,%' or ilgilendigi_turler like '%Çekme Belgeli%' ";
					}
					
					$secili_ilgi_text="Çekme Belgeli";
				}else if($_POST['uye_ilgi'][$d]=="3"){
					if($d!=$seciliİlgiSayisi-1){
						$seciliİlgi.=" ilgilendigi_turler like '%,Hurda Belgeli%' or ilgilendigi_turler like '%Hurda Belgeli,%' or ilgilendigi_turler like '%,Hurda Belgeli,%' or ilgilendigi_turler like '%Hurda Belgeli%' or ";
					}else{
						$seciliİlgi.=" ilgilendigi_turler like '%,Hurda Belgeli%' or ilgilendigi_turler like '%Hurda Belgeli,%' or ilgilendigi_turler like '%,Hurda Belgeli,%' or ilgilendigi_turler like '%Hurda Belgeli%' ";
					}
					
					$secili_ilgi_text="Hurda Belgeli";
				}else if($_POST['uye_ilgi'][$d]=="4"){
					if($d!=$seciliİlgiSayisi-1){
						$seciliİlgi.=" ilgilendigi_turler like '%,Otomobil%' or ilgilendigi_turler like '%Otomobil,%' or ilgilendigi_turler like '%,Otomobil,%' or ilgilendigi_turler like '%Otomobil%' or ";
					}else{
						$seciliİlgi.=" ilgilendigi_turler like '%,Otomobil%' or ilgilendigi_turler like '%Otomobil,%' or ilgilendigi_turler like '%,Otomobil,%' or ilgilendigi_turler like '%Otomobil%' ";
					}
					$secili_ilgi_text="Otomobil";
				}else if($_POST['uye_ilgi'][$d]=="5"){
					if($d!=$seciliİlgiSayisi-1){
						$seciliİlgi.=" ilgilendigi_turler like '%,Çekici ve Kamyon%' or ilgilendigi_turler like '%Çekici ve Kamyon,%' or ilgilendigi_turler like '%,Çekici ve Kamyon,%' or ilgilendigi_turler like '%Çekici ve Kamyon%' or  ";
					}else{
						$seciliİlgi.=" ilgilendigi_turler like '%,Çekici ve Kamyon%' or ilgilendigi_turler like '%Çekici ve Kamyon,%' or ilgilendigi_turler like '%,Çekici ve Kamyon,%' or ilgilendigi_turler like '%Çekici ve Kamyon%'  ";
					}
					$secili_ilgi_text="Çekici ve Kamyon";
				}else if($_POST['uye_ilgi'][$d]=="6"){
					if($d!=$seciliİlgiSayisi-1){
						$seciliİlgi.=" ilgilendigi_turler like '%,Dorse%' or ilgilendigi_turler like '%Dorse,%' or ilgilendigi_turler like '%,Dorse,%' or ilgilendigi_turler like '%Dorse%' or ";
					}else{
						$seciliİlgi.=" ilgilendigi_turler like '%,Dorse%' or ilgilendigi_turler like '%Dorse,%' or ilgilendigi_turler like '%,Dorse,%' or ilgilendigi_turler like '%Dorse%' ";
					}
					
					$secili_ilgi_text="Dorse";
				}else if($_POST['uye_ilgi'][$d]=="7"){
					if($d!=$seciliİlgiSayisi-1){
						$seciliİlgi.=" ilgilendigi_turler like '%,Motosiklet%' or ilgilendigi_turler like '%Motosiklet,%' or ilgilendigi_turler like '%,Motosiklet,%' or ilgilendigi_turler like '%Motosiklet%' or ";
					}else{
						$seciliİlgi.=" ilgilendigi_turler like '%,Motosiklet%' or ilgilendigi_turler like '%Motosiklet,%' or ilgilendigi_turler like '%,Motosiklet,%' or ilgilendigi_turler like '%Motosiklet%' ";
					}
					
					$secili_ilgi_text="Motosiklet";
				}else if($_POST['uye_ilgi'][$d]=="8"){
					if($d!=$seciliİlgiSayisi-1){
						$seciliİlgi.=" ilgilendigi_turler like '%,Traktör%' or ilgilendigi_turler like '%Traktör,%' or ilgilendigi_turler like '%,Traktör,%' or ilgilendigi_turler like '%Traktör%' or ";
					}else{
						$seciliİlgi.=" ilgilendigi_turler like '%,Traktör%' or ilgilendigi_turler like '%Traktör,%' or ilgilendigi_turler like '%,Traktör,%' or ilgilendigi_turler like '%Traktör%' ";
					}
					
					$secili_ilgi_text="Traktör";
				}else if($_POST['uye_ilgi'][$d]=="9"){
					if($d!=$seciliİlgiSayisi){
						$seciliİlgi.=" ilgilendigi_turler like '%,Sadece lüks segment%' or ilgilendigi_turler like '%Sadece lüks segment,%' or ilgilendigi_turler like '%,Sadece lüks segment,%' or ilgilendigi_turler like '%Sadece lüks segment%' or ";
					}else{
						$seciliİlgi.=" ilgilendigi_turler like '%,Sadece lüks segment%' or ilgilendigi_turler like '%Sadece lüks segment,%' or ilgilendigi_turler like '%,Sadece lüks segment,%' or ilgilendigi_turler like '%Sadece lüks segment%' ";
					}
					
					$secili_ilgi_text="Sadece lüks segment";
				}else{
					$seciliİlgi.="";
					$secili_ilgi_text="";
				}
				$d++;
				
				$onclick='onclick="filtre_cikar(\'durum_\',\''.$_POST['uye_durum'][$d].'\')"';
				$filtreler.='
					<div class="filter_box">
						'.$secili_ilgi_text.'
						<div '.$onclick.' class="filter_box_close">
							x
						</div>
					</div>	
				';  
				
			}
			$seciliİlgi .= ") ";
			// $where = $where . " AND risk in (" . $seciliİlgi . ")";
	
			$where=$where.$seciliİlgi;
		}
		$filtre_cek = "
			SELECT 
				u.*
			FROM 
				user as u 
			inner join
				onayli_kullanicilar as o_k
					on u.id=o_k.user_id
			inner join 
				uye_durumlari as u_d 
					on u.id=u_d.uye_id 
			$where and o_k.durum=1
		";
		//$filtre_cek = "SELECT * FROM user  $where";
		$result = mysql_query($filtre_cek) or die(mysql_error());
		$sayi = mysql_num_rows($result);
		if($sayi==0){
			echo '<script type="text/javascript">'; 
			echo 'alert("İstediğiniz kriterlere uygun kullanıcı bulunamadı.");'; 
			echo 'window.location.href = "?modul=uyeler&sayfa=uyeler";';
			echo '</script>';  
			
		}else{ 
			echo $sayi . "Adet sonuç listelendi." ?>
			<?php if($filtre_var=="true"){ ?>
				<p><a href="?modul=ihaleler&sayfa=tum_ihaleler">Tümünü Temizle</a></p>
			<?php } ?>
			<div class="filter_box_outer">
				<?php 
					echo $filtreler;
				/*
					<div class="filter_box">
						Opel
						<div class="filter_box_close">
							x
						</div>
					</div>		
					<div class="filter_box">
						Opel
						<div class="filter_box_close">
							x
						</div>
					</div>		
					<div class="filter_box">
						Opel
						<div class="filter_box_close">
							x
						</div>
					</div>		
					<div class="filter_box">
						Opel
						<div class="filter_box_close">
							x
						</div>
					</div>		
					<div class="filter_box">
						Opel
						<div class="filter_box_close">
							x
						</div>
					</div>	
					*/
				?>	
			</div>
		<form method="POST" action="?modul=uyeler&sayfa=uyeler_islem">
			<?php
				$admin_yetki_cek=mysql_query("Select * from kullanicilar where id='".$admin_id."' ");
				$admin_yetki_oku=mysql_fetch_assoc($admin_yetki_cek);
				$yetkiler=$admin_yetki_oku["yetki"];
				$yetki_parcala=explode("|",$yetkiler);
				$btn='';

				if (in_array(7, $yetki_parcala) ) {
					$text="return confirm('Emin misiniz?')";
					$btn='<input onclick="'.$text.'" type="submit" name="secili_sil" class="btn-danger" value="Seçili Olanları Sil">';
				}      
				$uyenin_grup_cek = mysql_query("SELECT * FROM uye_grubu WHERE id = 1 OR id = 22");
			?>    
			<div class="row-fluid">
				<div class="span6"></div>
				<div class="span6">
					<div class="btn-group">
						<a class="btn blue dropdown-toggle" data-toggle="dropdown" href="#">
							Seçilileri
							<span class="caret"></span>
						</a>
						<ul class="dropdown-menu">
							<li> <a><? echo $btn ?></a></li>
							<?php while($uyenin_grup_oku = mysql_fetch_array($uyenin_grup_cek)){ ?>
							<li>
								<a>
									<button type="submit" class="btn-primary btn-block" name="grup_degistir" value="<?= $uyenin_grup_oku['id'] ?>">
										<?= $uyenin_grup_oku['grup_adi'] ?> Yap
									</button>
								</a>
							</li>
							<?php } ?>
						</ul>
					</div>
				</div>
			</div>
			<div style="overflow-x:auto; overflow-y:auto;  margin-top:2%;">
				<table width="100%" class="table table-bordered">
					<thead>
						<tr>
							<th>Seç</th>
							<th>Durumu</th>
							<th>Üye Grubu</th>
							<th>Firma Adı</th>
							<th>Üye Adı/Yetkili Adı</th>
							<th>Onaylı gsm no</th>
							<th>Cinsiyet</th>
							<th>İlçe / İl</th>
							<th>Kazandıkları</th>
							<th>Teklifleri</th>
							<th>Mesajları</th>
							<th>Favorileri</th>
							<th>Notlar</th>
							<th>Kayıt Tarihi</th>
							<th>Son Giriş Tarihi</th>
							<th>Düzenle</th>
							<th>İşlem</th>
						</tr>
					</thead>
					<tbody>
					
						<span value="<?=$sayi ?>" id="uye_sayisi">
						<?php $count=1; while($filtre_oku = mysql_fetch_array($result)){ 
							$uye_durum_cek = mysql_query("SELECT * FROM uye_durumlari WHERE uye_id = '".$filtre_oku['id']."'");
							$uye_durum_oku = mysql_fetch_assoc($uye_durum_cek);
							$admin_yetki_engel = $uye_durum_oku['teklif_engelle'];
							$uyelik_iptal = $uye_durum_oku['uyelik_iptal'];
							$kalici_mesaj = $uye_durum_oku['kalici_mesaj'];
						   
							if($admin_yetki_engel=="on"){
								$renk = "#000000";
							}elseif($uyelik_iptal=="on"){
								$renk = "red";
							}elseif($kalici_mesaj=="on"){
								$renk = "blue";
							}else{
								$renk = "green";
							}

							$grup_oku = mysql_query("SELECT * FROM uye_grubu WHERE id = '".$filtre_oku['paket']."'");
							$grup_yaz = mysql_fetch_assoc($grup_oku);
							$grubun_adi = $grup_yaz['grup_adi'];
							$gelen_id = $filtre_oku["id"];
							$gelen_ad = $filtre_oku['ad'];
							if($filtre_oku['user_token'] == ""){
								$user = $filtre_oku['kurumsal_user_token'];
							}else{
								$user = $filtre_oku['user_token'];
							}
							$ili_cek = mysql_query("SELECT * FROM sehir WHERE plaka ='".$filtre_oku['sehir']."'");
							$kazandigini_cek = mysql_query("SELECT * FROM kazanilan_ilanlar WHERE uye_id = '".$gelen_id."'");
							$kazandiklari = 0;
							while($kazandigini_oku = mysql_fetch_object($kazandigini_cek)){
								$ilan_durum_cek = mysql_query("select * from ilanlar where id = '".$kazandigini_oku->ilan_id."'");
								if(mysql_num_rows($ilan_durum_cek) != 0){
									$kazandiklari += 1;
								}								
							}
							$tekliflerini_cek = mysql_query("SELECT * FROM teklifler WHERE uye_id = '".$gelen_id."' and durum=1");
							$teklifleri = mysql_num_rows($tekliflerini_cek);
							$mesajlarini_cek = mysql_query("SELECT * FROM mesajlar WHERE gonderen_id = '".$gelen_id."'");
							$mesajlari = mysql_num_rows($mesajlarini_cek);
							$favorilerini_cek = mysql_query("SELECT * FROM favoriler WHERE uye_id = '".$gelen_id."'");
							$favorileri = mysql_num_rows($favorilerini_cek);
							if($filtre_oku["son_islem_isletim_sistemi"]=="İphone" || $filtre_oku["son_islem_isletim_sistemi"]=="iPod"  || $filtre_oku["son_islem_isletim_sistemi"]=="iPad" || $filtre_oku["son_islem_isletim_sistemi"]=="Mac OS X" || $filtre_oku["son_islem_isletim_sistemi"]=="Mac OS 9"){
								$icon='/ <i class="fab fa-apple"></i>';
							}else if($filtre_oku["son_islem_isletim_sistemi"]=="Android"){
								$icon='/ <i class="fab fa-android"></i>';
							}else {
								$icon='';
							}

							$yuklenen_cek = mysql_query("SELECT * FROM yuklenen_evraklar WHERE user_id ='".$gelen_id."' group by gonderme_zamani order by id desc");
							$yuklenenler = mysql_num_rows($yuklenen_cek); 
							$evraklar = mysql_query("SELECT * FROM uye_notlari WHERE uye_id ='".$gelen_id."' group by tarih order by id desc");
							$evrak_say = mysql_num_rows($evraklar);
							$prm_cek = mysql_query("SELECT * FROM prm_notlari WHERE uye_id ='".$gelen_id."'");
							$prm_say = mysql_num_rows($prm_cek); 
						?>
						<tr>
							<td><input type="checkbox" name="secim[]" value="<?= $gelen_id ?>" class="chec" style="opacity:1!important; z-index:999;margin-top:-3px;" ></td>
							<td><i class="fas fa-circle" style="color: <?= $renk ?>;"></i></td>
							<td><?= $grubun_adi ?></td>
							<td><?= $filtre_oku["unvan"] ?></td>
							<td><?= $filtre_oku["ad"] ?></td>
							<td><?= $filtre_oku["telefon"] ?></td>
							<td><?= $filtre_oku["cinsiyet"] ?></td>
							<td  onclick="kopyala_filtre(<?=$count ?>)"><a style="color:#000;"><?= $filtre_oku["ilce"]." / ".$filtre_oku["sehir"] ?></a></td>
							<td><a id="<?= $filtre_oku['id']?>" class="view_kazandiklari"><i class="fas fa-star"><?= $kazandiklari ?></i></a></td>
							<td><a id="<?= $filtre_oku['id']?>" class="view_teklifleri"><i class="fas fa-gavel"><?= $teklifleri ?></i></a></td>
							<td><a id="<?= $filtre_oku['id']?>" class="view_mesajlari"><i class="fas fa-envelope"><?= $mesajlari ?></i></a></td>
							<td><a  id="<?= $filtre_oku['id']?>" class="view_favorileri"><i class="fas fa-heart"><?= $favorileri ?></i></a></td>
							<td><a id="<?= $filtre_oku['id'] ?>" class="view_notlari"><i class="fas fa-align-left"><?= $prm_say+$evrak_say+$yuklenenler ?></i></a></td>
							<td><?= date("d-m-Y H:i:s",strtotime($filtre_oku["kayit_tarihi"])) ?></td>
							<?php if($filtre_oku["son_islem_zamani"] == "0000-00-00 00:00:00" ){ ?>
								<td><?= $filtre_oku["son_islem_zamani"] ?></td>
							<?php }else{ ?>
								<td><?= date("d-m-Y H:i:s",strtotime($filtre_oku["son_islem_zamani"])) ?>  <?= $icon ?> </td>
							<?php } ?>
							<td><a href="?modul=uyeler&sayfa=uye_duzenle&id=<?= $gelen_id ?>" target="_blank"><i class="fas fa-edit "></i></a></td>
							<td class="dropdown">
								<a class="dropwn-toggle" data-toggle="dropdown"><i class="fas fa-align-justify"></i></a>
								<ul class="dropdown-menu"style="position: absolute; transform: translate3d(90px, 10px, 0px); top: -30px; left: -240px; will-change: transform;">
									<li><a href="?modul=uyeler&sayfa=sifre_hatirlat&id=<?= $filtre_oku["id"] ?>">Şifre Hatırlat (Sms)</a></li>
									<li><a onclick="sifre_yenile(<?=$filtre_oku['id'] ?>); alert('Mail gönderildi'); ">Şifre Hatırlat (Eposta)</a></li>
									<li><a href="?modul=uyeler&sayfa=tanitim_mesaj_gonder&id=<?= $filtre_oku["id"] ?>">Tanıtım Mesajı Gönder</a></li>
									<li><a href="?modul=uyeler&sayfa=prm_ekle&id=<?= $filtre_oku['id'] ?>">prm notu ekle</a></li>
									<!-- <li><a href="?modul=ayarlar&sayfa=arac_detay_musteri_temsilcisi">Araç detay önemli metni</a></li> -->
									<!-- <li><a href="?modul=uyeler&sayfa=temsilci_ekle&id=<?= $gelen_id ?>">Temsilci Ata</a></li> -->
								</ul>
							</td>
						</tr>
						<?php
							if($filtre_oku['user_token']!=""){
								$uye_isim_bilgi=$filtre_oku['ad'];
							}else if($filtre_oku['kurumsal_user_token']!=""){
								$uye_isim_bilgi=$filtre_oku['unvan']." / ".$filtre_oku['ad'];
							}
				
						?>
						<input aria-hidden="true" type="text" class="offscreen" id="kopyalanan_filtre<?=$count ?>" value="
							Alıcı Adı : <?= $uye_isim_bilgi ?> 
							Kargo Adresi : <?= $filtre_oku['adres']." ".$filtre_oku['ilce']." ".$filtre_oku['sehir'] ?>
							İletişim : <?= $filtre_oku['telefon'] ?>" />
							<!-- <input type="hidden" id="kopyalanan" value=" Alıcı Adı : <?= $filtre_oku['ad'] ?> <br>
							   Kargo Adresi : <?= $filtre_oku['adres']." ".$filtre_oku['ilce']." ".$filtre_oku['sehir'] ?><br>
							   İletişim : <?= $filtre_oku['telefon'] ?>"> -->
							<?php $count++; } ?>
					</tbody>
				</table>
			 
				<?php  }
				}else{ ?>
		   </div>
		</form>
		<div class="form-control" style="margin-top: 2%; margin-left:2%;">
			<div class="row-fluid">
				<div class="span6">
					<a href="?modul=uyeler&sayfa=uye_ekle">
						<input type="submit" class="btn blue" name="yeni_kullanici" value="Yeni Kullanıcı Ekle">
					</a> 		
				</div>
			</div>
		</div>
		<form method="POST" action="?modul=uyeler&sayfa=uyeler_islem" name="form" id="form">
			<?php
				$admin_yetki_cek=mysql_query("Select * from kullanicilar where id='".$admin_id."' ");
				$admin_yetki_oku=mysql_fetch_assoc($admin_yetki_cek);
				$yetkiler=$admin_yetki_oku["yetki"];
				$yetki_parcala=explode("|",$yetkiler);
				$btn='';
				if (in_array(7, $yetki_parcala)  ) { 
					$text="return confirm('Emin misiniz?')";
					$btn='<input onclick="'.$text.'" type="submit" name="secili_sil" class="btn-danger" value="Seçili Olanları Sil">';
				}      
				$uyenin_grup_cek = mysql_query("SELECT * FROM uye_grubu WHERE id = 1 OR id = 22 ");
			?>    
			<div class="row-fluid">
				<div class="span6"></div>
				<div class="span6">
					<div class="btn-group">
						<a class="btn blue dropdown-toggle" data-toggle="dropdown" href="#">
							Seçilileri
							<span class="caret"></span>
						</a>
						<ul class="dropdown-menu">
							<li> <a><? echo $btn ?></a></li>
								<?php while($uyenin_grup_oku = mysql_fetch_array($uyenin_grup_cek)){ ?>
							<li>
								<a>
									<?php 
										$button = '<button type="submit" class="btn-primary btn-block" name="grup_degistir" value=" '.$uyenin_grup_oku['id'].' ">
										'.$uyenin_grup_oku['grup_adi'].'  Yap';
									?>
									<button type="submit" class="btn-primary btn-block" name="grup_degistir" value="<?= $uyenin_grup_oku['id'] ?>">
										<?= $uyenin_grup_oku['grup_adi'] ?> Yap
									</button>
								</a>
							</li>
							<?php } ?>
						</ul>
					</div>
				</div>
			</div>
			<div style="overflow-x:auto; overflow-y:auto;  margin-top:4%;">
				<table width="100%" class="table table-bordered" cellspacing="2">
					<thead>
						<tr>
							<th> <input type="checkbox" class="checkall btn blue" style="margin-left:10px;padding:20px">Tümünü Seç</th>
							<th>Durumu</th>
							<th>Üye Grubu</th>
							<th>Firma Adı</th>
							<th>Üye Adı/Yetkili Adı</th>
							<th>Onaylı gsm no</th>
							<th>Cinsiyet</th>
							<th>İlçe / İl</th>
							<th>Kazandıkları</th>
							<th>Teklifleri</th>
							<th>Mesajları</th>
							<th>Favorileri</th>
							<th>Notlar</th>
							<th>Kayıt Tarihi</th>
							<th>Son Giriş Tarihi</th>
							<th>Düzenle</th>
							<th>İşlem</th>
						</tr>
					</thead>
					<tbody>
						<input type="hidden" value="<?=mysql_num_rows($uyeleri_cek) ?>" id="uye_sayisi">
						<?php $sira=1; 
						while($uyeleri_oku = mysql_fetch_array($uyeleri_cek)){ 
							$uye_durum_cek = mysql_query("SELECT * FROM uye_durumlari WHERE uye_id = '".$uyeleri_oku['id']."'");
							$uye_durum_oku = mysql_fetch_assoc($uye_durum_cek);
							$admin_yetki_engel = $uye_durum_oku['teklif_engelle'];
							$uyelik_iptal = $uye_durum_oku['uyelik_iptal'];
							$kalici_mesaj = $uye_durum_oku['kalici_mesaj'];
					   
							if($admin_yetki_engel=="on"){
								$renk = "#000000";
							}elseif($uyelik_iptal=="on"){
								$renk = "red";
							}elseif($kalici_mesaj=="on"){
								$renk = "blue";
							}else{
								$renk = "green";
							}
							$grup_oku2 = mysql_query("SELECT * FROM uye_grubu WHERE id = '".$uyeleri_oku['paket']."'");
							$grup_yaz2 = mysql_fetch_assoc($grup_oku2);
							$grubun_adi2 = $grup_yaz2['grup_adi'];
							$gelen_id = $uyeleri_oku["id"];
							$gelen_ad = $uyeleri_oku['ad'];
							if($uyeleri_oku['user_token'] == ""){
								$user = $uyeleri_oku['kurumsal_user_token'];
							}else{
								$user = $uyeleri_oku['user_token'];
							}
							$ili_cek = mysql_query("SELECT * FROM sehir WHERE plaka ='".$uyeleri_oku['sehir']."'");
							$kazandigini_cek = mysql_query("SELECT * FROM kazanilan_ilanlar WHERE uye_id = '".$gelen_id."'");
							$kazandiklari = mysql_num_rows($kazandigini_cek);
							$tekliflerini_cek = mysql_query("SELECT * FROM teklifler WHERE uye_id = '".$gelen_id."' and durum=1");
							$teklifleri = mysql_num_rows($tekliflerini_cek);

							$aktif_teklif = mysql_query("select * from ilanlar as i, teklifler as t where i.id = t.ilan_id and i.durum = 1 and t.uye_id = '".$gelen_id."'");
							$aktif_teklif_say = mysql_num_rows($aktif_teklif);

							// echo $aktif_teklif_say;              
					   
							$mesajlarini_cek = mysql_query("SELECT * FROM mesajlar WHERE gonderen_id = '".$gelen_id."'");
							$mesajlari = mysql_num_rows($mesajlarini_cek);
							$favorilerini_cek = mysql_query("SELECT * FROM favoriler WHERE uye_id = '".$gelen_id."'");
							$favorileri = mysql_num_rows($favorilerini_cek);
							$yuklenen_cek = mysql_query("SELECT * FROM yuklenen_evraklar WHERE user_id ='".$gelen_id."' group by gonderme_zamani order by id desc");
							$yuklenenler = mysql_num_rows($yuklenen_cek); 
							$evraklar = mysql_query("SELECT * FROM uye_notlari WHERE uye_id ='".$gelen_id."' group by tarih order by id desc");
							$evrak_say = mysql_num_rows($evraklar);
							$prm_cek = mysql_query("SELECT * FROM prm_notlari WHERE uye_id ='".$gelen_id."'");
							$prm_say = mysql_num_rows($prm_cek); 
							if($uyeleri_oku["son_islem_isletim_sistemi"]=="iPhone" || $uyeleri_oku["son_islem_isletim_sistemi"]=="iPod"  || $uyeleri_oku["son_islem_isletim_sistemi"]=="iPad" || $uyeleri_oku["son_islem_isletim_sistemi"]=="Mac OS X" || $uyeleri_oku["son_islem_isletim_sistemi"]=="Mac OS 9"){
								$icon='/ <i class="fab fa-apple"></i>';
							}else if($uyeleri_oku["son_islem_isletim_sistemi"]=="Android"){
								$icon='/ <i class="fab fa-android"></i>';
							}else {
								$icon='';
							}
							?>
							
							<tr>
								<td><input type="checkbox" name="secim[]" value="<?= $gelen_id ?>" class="chec" style="opacity:1!important; z-index:999;margin-top:-3px" ></td>
								<td><i class="fas fa-circle" style="color: <?= $renk ?>;"></i></td>
								<td><?= $grubun_adi2 ?></td>
								<td><?= $uyeleri_oku["unvan"] ?></td>
								<td><?= $uyeleri_oku["ad"] ?></td>
								<td><a href="?modul=uyeler&sayfa=sms_gonder&id=<?=$uyeleri_oku["id"]?>" target="_blank"><?= $uyeleri_oku["telefon"] ?></a></td>
								<td><?= $uyeleri_oku["cinsiyet"] ?></td>
								<td onclick="kopyala(<?=$sira ?>)"><a style="color:#000;"><?= $uyeleri_oku["ilce"]." / ".$uyeleri_oku["sehir"] ?></a></td>
								<td><a id="<?= $uyeleri_oku['id']?>" class="view_kazandiklari"><i class="fas fa-star"><?= $kazandiklari ?></i></a></td>
								<td><a id="<?= $uyeleri_oku['id']?>" class="view_teklifleri"><i class="fas fa-gavel"><?= $aktif_teklif_say ?></i></a></td>
								<td><a id="<?= $uyeleri_oku['id']?>" class="view_mesajlari"><i class="fas fa-envelope"><?= $mesajlari ?></i></a></td>
								<td><a id="<?= $uyeleri_oku['id']?>" class="view_favorileri"><i class="fas fa-heart"><?= $favorileri ?></i></a></td>
								<td><a id="<?= $uyeleri_oku['id'] ?>" class="view_notlari"><i class="fas fa-align-left"><?= $prm_say+$evrak_say+$yuklenenler ?></i></a></td>
								<td><?= date("d-m-Y H:i:s",strtotime($uyeleri_oku["kayit_tarihi"])) ?></td>
								<?php if($uyeleri_oku["son_islem_zamani"] == "0000-00-00 00:00:00" ){ ?>
									<td><?= $uyeleri_oku["son_islem_zamani"] ?></td>
								<?php }else{ ?>
									<td><?= date("d-m-Y H:i:s",strtotime($uyeleri_oku["son_islem_zamani"])) ?> <?=$icon ?></td>
								<?php } ?>
								<td><a href="?modul=uyeler&sayfa=uye_duzenle&id=<?= $gelen_id ?>" target="_blank"><i class="fas fa-edit "></i></a></td>
								<td class="dropdown">
									<a class="dropwn-toggle" data-toggle="dropdown"><i class="fas fa-align-justify"></i></a>
									<ul class="dropdown-menu"style="position: absolute; transform: translate3d(90px, 10px, 0px); top: -30px; left: -240px; will-change: transform;">
										<li><a href="?modul=uyeler&sayfa=sifre_hatirlat&id=<?= $uyeleri_oku["id"] ?>">Şifre Hatırlat (Sms)</a></li>
										<li><a onclick="sifre_yenile(<?=$uyeleri_oku['id'] ?>);alert('Mail gönderildi');">Şifre Hatırlat (Eposta)</a></li>
										<li><a href="?modul=uyeler&sayfa=tanitim_mesaj_gonder&id=<?= $uyeleri_oku["id"] ?>">Tanıtım Mesajı Gönder</a></li>
										<li><a href="?modul=uyeler&sayfa=prm_ekle&id=<?= $gelen_id ?>">PRM notu ekle</a></li>
										<!-- <li><a href="?modul=ayarlar&sayfa=arac_detay_musteri_temsilcisi">Araç detay önemli metni</a></li> -->
										<!-- <li><a href="?modul=uyeler&sayfa=temsilci_ekle&id=<?= $gelen_id ?>">Temsilci Ata</a></li> -->
									</ul>
								</td>
							</tr>
							<?php
								if($uyeleri_oku['user_token']!=""){
									$uye_isim_bilgi=$uyeleri_oku['ad'];
								}else if($uyeleri_oku['kurumsal_user_token']!=""){
									$uye_isim_bilgi=$uyeleri_oku['unvan']." / ".$uyeleri_oku['ad'];
								}
					
							?>
							<input aria-hidden="true" type="text" class="offscreen" id="kopyalanan<?=$sira ?>" 
								value=" 				
									Alıcı Adı : <?= uye_isim_bilgi ?> 
									Kargo Adresi : <?= $uyeleri_oku['adres']." ".$uyeleri_oku['ilce']." ".$uyeleri_oku['sehir'] ?>  
									İletişim : <?= $uyeleri_oku['telefon'] ?>				
								"
							/>
							<?php $sira++;
						} ?>
					</tbody>
				</table>
			</div>
		</form>
	<?php } ?>
	<!-- Kazandıkları Modal Başlangıç-->
	<div class="modal hide fade"  id="kazandiklari" style="width:60%;">
		<button type="button" class="close" style="margin-right: 2%; margin-top:2%;" data-dismiss="modal" aria-hidden="true"></button>
		<div class="modal-dialog">
			<div class="modal-body" id="uyenin_kazandiklari"></div>
		</div>
	</div>
	<!-- Kazandıkları Modal Bitiş-->
		<!-- Teklifleri Modal Başlangıç-->
	<div class="modal hide fade" id="teklifleri" style="width:60%;">
		<button type="button" class="close" style="margin-right: 2%; margin-top:2%;" data-dismiss="modal" aria-hidden="true"></button>
		<div class="modal-dialog">
			<div class="modal-body" id="uyenin_teklifleri"></div>
		</div>
	</div>
	<!-- Teklifleri Modal Bitiş-->
	<!-- Mesajları Modal Başlangıç-->
	<div class="modal fade" id="mesajlari" >
		<button type="button" class="close" style="margin-right: 2%; margin-top:2%;" data-dismiss="modal" aria-hidden="true"></button>
		<div class="modal-dialog">
			<div class="modal-body" id="uyenin_mesajlari">
			</div>
		</div>
	</div>
	<!-- Mesajları Modal Bitiş-->
	<!-- Favorileri Modal Başlangıç-->
	<div class="modal fade" id="favorileri">
		<button type="button" class="close" style="margin-right: 2%; margin-top:2%;" data-dismiss="modal" aria-hidden="true"></button>
		<div class="modal-dialog">
			<div class="modal-body" id="uyenin_favorileri">
			</div>
		</div>
	</div>
	<!-- Favorileri Modal Bitiş-->
	<!-- Notları Modal Başlangıç-->
	<div class="modal fade custom-large-modal" id="notlari" >
		<button type="button" class="close" style="margin-right: 2%; margin-top:2%;" data-dismiss="modal" aria-hidden="true"></button>
		<div class="modal-dialog">
			<div class="modal-body" id="uyenin_notlari">
			</div>
		</div>
	</div>
	<?php 
		if(re('notu') =='Kaydet'){
		
			$admin_id = $_SESSION['kid'];
			$eklenecek_not = re('eklenecek_not');
			$gelen_id = re('gelen_id');
			$gizlilik = re('gizlilik');
			$tarih = date('Y-m-d H:i:s');
		//	if(isset($_FILES['files'])){     // dosya tanımlanmıs mı? 
			$errors= array(); 
			foreach($_FILES['files']['tmp_name'] as $key => $tmp_name ){ 
				$dosya_adi =$_FILES['files']['name'][$key]; 		// uzantiya beraber dosya adi 
				$dosya_boyutu =$_FILES['files']['size'][$key];    		// byte cinsinden dosya boyutu 
				$dosya_gecici =$_FILES['files']['tmp_name'][$key];		//gecici dosya adresi 
				$yenisim=md5(microtime()).$dosya_adi; 					//karmasik yeni isim.pdf                  
				$klasor="../assets"; // yuklenecek dosyalar icin yeni klasor 
				//olusturdugumuz isimde dosya var mı?  
				$test=move_uploaded_file($dosya_gecici,"$klasor/".$yenisim);//yoksa yeni ismiyle kaydet 
				if($test==false){
					$a=mysql_query("INSERT INTO `uye_notlari` (`id`, `uye_id`, `ekleyen`, `uye_notu`, `gizlilik`, `tarih`, `dosya`) 
					VALUES (NULL, '".$gelen_id."', '".$admin_id."', '".$eklenecek_not."', '".$gizlilik."', '".$tarih."', '1')
					")or die(mysql_error()); 
					  
					  mysql_query("INSERT INTO `yapilan_is` (`id`, `admin_id`, `yaptigi`,`aciklama`, `ekleme_zamani`, `ilan_id`, `dogrudan_id`, `uye_id`) VALUES 
					  (NULL, '".$admin_id."', '3','".$eklenecek_not."', '".$tarih."','','','".$gelen_id."');"); 
					if($a){
						alert("Başarıyla Eklendi..");
						header("Location:?modul=uyeler&sayfa=uyeler");
					}
				}else{
					$a=mysql_query("INSERT INTO `uye_notlari` (`id`, `uye_id`, `ekleyen`, `uye_notu`, `gizlilik`, `tarih`, `dosya`) 
					VALUES (NULL, '".$gelen_id."', '".$admin_id."', '".$eklenecek_not."', '".$gizlilik."', '".$tarih."', '".$yenisim."')
					")or die(mysql_error()); 
					  
					  mysql_query("INSERT INTO `yapilan_is` (`id`, `admin_id`, `yaptigi`,`aciklama`, `ekleme_zamani`, `ilan_id`, `dogrudan_id`, `uye_id`) VALUES 
					  (NULL, '".$admin_id."', '3','".$eklenecek_not."', '".$tarih."','','','".$gelen_id."');"); 
					if($a){
						alert("Başarıyla Eklendi..");
						header("Location:?modul=uyeler&sayfa=uyeler");
					}
				}
			} 
		//} 
			
		/* 	
		
			if ($_FILES['resim']['name'] != "")
			{
				include ('simpleimage.php');
				$dosya_sayi = count($_FILES['resim']['name']);
				for ($i = 0;$i < $dosya_sayi;$i++)
				{
					if (!empty($_FILES['resim']['name'][$i]))
					{
						$dosya_adi = $_FILES["resim"]["name"][$i];
						$dizim = array("iz","et","se","du","yr","nk");
						$uzanti = substr($dosya_adi, -4, 4);
						$rasgele = rand(1, 1000000);
						$ad = $dizim[rand(0, 5) ] . $rasgele . ".png";
						$yeni_ad = "../images/" . $ad;
						move_uploaded_file($_FILES["resim"]['tmp_name'][$i], $yeni_ad);
						$image = new SimpleImage();
						$image->load($yeni_ad);
						$image->resizeToWidth(1000);
						$image->save($yeni_ad);

						$a=mysql_query("INSERT INTO `uye_notlari` (`id`, `uye_id`, `ekleyen`, `uye_notu`, `gizlilik`, `tarih`, `dosya`) 
							VALUES (NULL, '".$gelen_id."', '".$admin_id."', '".$eklenecek_not."', '".$gizlilik."', '".$tarih."', '".$ad."')
						")or die(mysql_error()); 
			
						mysql_query("INSERT INTO `yapilan_is` (`id`, `admin_id`, `yaptigi`,`aciklama`, `ekleme_zamani`, `ilan_id`, `dogrudan_id`, `uye_id`) VALUES 
						(NULL, '".$admin_id."', '3','".$eklenecek_not."', '".$tarih."','','','".$gelen_id."');"); 
						if($a){
							alert("Başarıyla Eklendi..");
							//header("Location:?modul=uyeler&sayfa=uyeler");
						}
					}
				}
			}*/
		}
   ?>
	<!-- Notları Modal Bitiş-->
	<script>
		var clicked = false;
		$(".checkall").on("click", function() {
			$(".chec").prop("checked", !clicked);
			clicked = !clicked;
			this.innerHTML = clicked ? 'Seçimleri Kaldır' : 'Tümünü Seç';
		});
	
		var uye_sayisi=document.getElementById("uye_sayisi").value;
		//var uye_sayisi_filtre=document.getElementById("uye_sayisi_filtre").value;
		function kopyala_filtre(id){
			var copyText = document.getElementById("kopyalanan_filtre"+id);
			copyText.type = 'text';
			copyText.select();
			document.execCommand("copy");
		}
		function kopyala(id){
			var copyText2 = document.getElementById("kopyalanan"+id);
			copyText2.type = 'text';
			copyText2.select();
			document.execCommand("copy");
		}
		var p;
		for (p = 1; p < uye_sayisi.value; p++) {
		}
	</script>
	<script>
		var expanded = false;
		function showSehirler() {
			var checkboxes = document.getElementById("sehirler");
			if (!expanded) {
				checkboxes.style.display = "block";
				expanded = true;
				document.getElementById('sehirler_backdrop').style.display = "block";
			} else {
				checkboxes.style.display = "none";
				document.getElementById('sehirler_backdrop').style.display = "none";
				expanded = false;
			}
		}
		function showAdminler() {
			var checkboxes = document.getElementById("adminler");
			if (!expanded) {
				checkboxes.style.display = "block";
				expanded = true;
				document.getElementById('adminler_backdrop').style.display = "block";
			} else {
				checkboxes.style.display = "none";
				document.getElementById('adminler_backdrop').style.display = "none";
				expanded = false;
			}
		}		
		function showGrup() {
			var checkboxes = document.getElementById("uye_grubu");
			if (!expanded) {
				checkboxes.style.display = "block";
				expanded = true;
				document.getElementById('grup_backdrop').style.display = "block";
				
			} else {
				checkboxes.style.display = "none";
				document.getElementById('grup_backdrop').style.display = "none";
				expanded = false;
			}
		}
		function showDurum() {
			var checkboxes = document.getElementById("uye_durumu");
			if (!expanded) {
				checkboxes.style.display = "block";
				expanded = true;
				document.getElementById('durum_backdrop').style.display = "block";
			
			} else {
				checkboxes.style.display = "none";
				document.getElementById('durum_backdrop').style.display = "none";
				expanded = false;
			}
		}
		function showIlgi() {
			var checkboxes = document.getElementById("uye_ilgi");
			if (!expanded) {
				checkboxes.style.display = "block";
				expanded = true;
				document.getElementById('ilgi_backdrop').style.display = "block";
			
			} else {
				checkboxes.style.display = "none";
				document.getElementById('ilgi_backdrop').style.display = "none";
				expanded = false;
			}
		}
	</script>   
	<script>
		/*function phoneMask() { 
			var num = $(this).val().replace(/\D/g,''); 
			$(this).val(num.substring(0,1) + '(' + num.substring(1,4) + ')' + num.substring(4,7) + '-' + num.substring(7,11)); 
		}
		$('[type="tel"]').keyup(phoneMask);*/
		$('input[type="tel"]').mask('0(000)000-0000'); 
	</script>
	<script language="javascript">
		function kontrol(){
			var reg=new RegExp("\[ÜĞŞÇÖğıüşöç]");
			if(reg.test(document.getElementById('aranan_mail').value,reg)){
				alert('Email alanında türkçe karakter bulunmamalıdır.');
				document.getElementById('aranan_mail').value="";
			}
		}
	</script>
	<script>
		function sifre_yenile(uye_id){
			jQuery.ajax({
				url: "?modul=ayarlar&sayfa=sifre_mail",
				type: "POST",
				dataType: "JSON",
				data: {
					action: "sifre_yenile",
					id: uye_id,
				},
				success: function(response) {
   			
				}
			});
		}
		
		
		function filtre_cikar(key,value){
			if(key=="aranan" && value=="filtre"){
				$("#aranan").val("");
			}else if(key=="aranantel" && value=="filtre"){
				$("#aranantel").val("");
			}else if(key=="arananmail" && value=="filtre"){
				$("#arananmail").val("");
			}else if(key=="kucukbuyuk_" && value=="kayit"){
				$("#kayit1").val("");
				$("#kayit2").val("");
			}else if(key=="kucukbuyuk_" && value=="giris"){
				$("#giris1").val("");
				$("#giris2").val("");
			}else{
				document.getElementById(""+key+value).checked=false
				
			}
			
			document.getElementById("filtrele").click();
		}
	</script>