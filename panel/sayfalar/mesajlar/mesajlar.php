<?php 
	$admin_id = $_SESSION['kid'];

	$limit = 100;
	$page = (re("page") != "" && is_numeric(re("page"))) ? re("page") : 1;	
	$total_rows = mysql_num_rows(mysql_query("select ilanlar.* from ilanlar inner join mesajlar on mesajlar.ilan_id=ilanlar.id and mesajlar.alan_id='0' and mesajlar.durum=0 group by ilanlar.id"));
	$total_page = ceil($total_rows / $limit);
	$page = ($page < 1) ? 1 : $page;
	$page = ($page > $total_page) ? $total_page : $page;
	$limit_start = ($page-1)*$limit;
	$limit_sql = "LIMIT ".$limit_start.",".$limit;


	// $hepsini_cek = mysql_query("select ilanlar.* from ilanlar inner join mesajlar on mesajlar.ilan_id=ilanlar.id and mesajlar.alan_id='0' and mesajlar.durum=0 group by ilanlar.id ".$limit_sql);
	// $hepsini_cek = mysql_query("select ilanlar.* from ilanlar inner join mesajlar on mesajlar.ilan_id=ilanlar.id and mesajlar.alan_id='0' and mesajlar.durum=0 group by ilanlar.id ");
	// $hepsini_cek = mysql_query("select ilanlar.* from ilanlar inner join mesajlar on mesajlar.ilan_id=ilanlar.id group by ilanlar.id order by mesajlar.gonderme_zamani desc");
	$hepsini_cek = mysql_query("select ilanlar.* from ilanlar inner join chat_room on chat_room.ilan_id=ilanlar.id group by ilanlar.id order by mesajlar.gonderme_zamani desc");
?>

<style>
	table {
		border-collapse: collapse;
		border-spacing: 0;
		width: 100%;
		border: 1px solid #ddd;
	}
	.table tr td{
		font-size: 15px;
	}

	th, td {
		text-align: left;
		padding: 8px;
	}
	i{
		padding: 8px;
	}

</style>
<style>
	.blink {
		animation: blinker 0.9s linear infinite;
		color: red;
		font-size: 15px;
		font-weight: bold;
		font-family: sans-serif;
	}
	@keyframes blinker {  
		50% { opacity: 0; }
	}
</style>
<style>
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
</style>
<style>
    .modal {
		position: fixed;
		left: 0;
		top: 0;   
		margin: auto;   
		right: 0;
	}
</style>
<script>
	var expanded = false;
	
	function showAramaKriteri() {
		var checkboxes = document.getElementById("arama_kriteri");
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

	function showihale_turu() {
		var checkboxes = document.getElementById("ihale_turu");
		if (!expanded) {
			checkboxes.style.display = "block";
			expanded = true;
		} else {
			checkboxes.style.display = "none";
			expanded = false;
		}
	}


	
	function showsigortasirketleri() {
		var checkboxes = document.getElementById("sigorta_sirketleri");
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
	function showTeklif() {
		var checkboxes = document.getElementById("teklif_durum");
		if (!expanded) {
			checkboxes.style.display = "block";
			expanded = true;
		} else {
			checkboxes.style.display = "none";
			expanded = false;
		}
	}  

	function showEkleyenAdmin() {
		var checkboxes = document.getElementById("adminler");
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
	function showModeller() {
		var checkboxes = document.getElementById("model");
		if (!expanded) {
			checkboxes.style.display = "block";
			expanded = true;
		} else {
			checkboxes.style.display = "none";
			expanded = false;
		}
	}
</script>   

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
	#arama_kriteri {
		display: none;
		border: 1px #dadada solid;
	}

	#arama_kriteri label {
		display: block;
	}

	#arama_kriteri label:hover {
		background-color: #1e90ff;
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
	#ihale_turu {
		display: none;
		border: 1px #dadada solid;
	}

	#ihale_turu label {
		display: block;
	}

	#ihale_turu label:hover {
		background-color: #1e90ff;
	}



	
	#sigorta_sirketleri {
		display: none;
		border: 1px #dadada solid;
	}

	#sigorta_sirketleri label {
		display: block;
	}

	#sigorta_sirketleri label:hover {
		background-color: #1e90ff;
	}
	#markalar {
		display: none;
		border: 1px #dadada solid;
	}

	#markalar label {
		display: block;
	}

	#markalar label:hover {
		background-color: #1e90ff;
	}
	#tarih {
		display: none;
		border: 1px #dadada solid;
	}

	#tarih label {
		display: block;
	}

	#tarih label:hover {
		background-color: #1e90ff;
	}
	#teklif_durum {
		display: none;
		border: 1px #dadada solid;
	}

	#teklif_durum label {
		display: block;
	}

	#teklif_durum label:hover {
		background-color: #1e90ff;
	}
	#profil {
		display: none;
		border: 1px #dadada solid;
	}

	#profil label {
		display: block;
	}

	#profil label:hover {
		background-color: #1e90ff;
	}

	#model {
		display: none;
		border: 1px #dadada solid;
	}

	#model label {
		display: block;
	}

	#model label:hover {
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
	.checker span input {
		opacity:1!important;
		margin-top: -3px !important;
	}
</style>
   
<?php 
	$sehir_cek = mysql_query("SELECT * FROM sehir"); 
	$marka_cek = mysql_query("SELECT * FROM marka"); 
	$sigorta_cek=mysql_query("Select * from sigorta_ozellikleri");
?>

<form method="POST" name="filter" id="filter">
	<div class="row-fluid">
		<div class="span6">
			<div class="form-group">
				<h5>Kelime ile ara</h5>
				<input type="search" name="aranan" class="form-control" placeholder="Plaka, araç kodu vb..">
			</div>
			<div class="multiselect">
				<div class="selectBox" onclick="showAramaKriteri()">
					<select style="height:1.8em;">
						<option>Arama Kriteri</option>
					</select>
					<div class="overSelect"></div>
				</div>
				<div id="arama_kriteri">
						<label><input type="checkbox" name="arama_kriteri[]" value="1" />Yalnızca ihalesi devam eden </label>
						<label><input type="checkbox" name="arama_kriteri[]" value="2" />Bugün Bitecekler </label>
						<label><input type="checkbox" name="arama_kriteri[]" value="3" />Yarın Bitecekler </label>
						<label><input type="checkbox" name="arama_kriteri[]" value="4" />İhalesi Bitenler </label>
						<label><input type="checkbox" name="arama_kriteri[]" value="5" />Bugün Eklenenler </label>
						<label><input type="checkbox" name="arama_kriteri[]" value="6" />Statü Belirlenenler </label>
						<label><input type="checkbox" name="arama_kriteri[]" value="7" />Tümü</label>
				</div>
			</div>	
			<div class="multiselect">
				<div class="selectBox" onclick="showSehirler()">
					<select style="height:1.8em;">
						<option>Şehire Göre</option>
					</select>
				<div class="overSelect"></div>
				</div>
				<div id="sehirler">
					<?php while($sehir_oku = mysql_fetch_array($sehir_cek)){?>                        
						<label for="<?= $sehir_oku['sehirID'] ?>">
						<input type="checkbox" name="sehir[]" value="<?= $sehir_oku['sehiradi'] ?>" /><?= $sehir_oku['sehiradi'] ?></label>
				<?php } ?> 
				</div>
				<!-- style="width: 15px; height: 15px; position: relative; top: -5px;opacity: 1 !important;" -->
			</div>
			<div class="multiselect">
				<div class="selectBox" onclick="showsigortasirketleri()">
					<select style="height:1.8em;">
						<option>Sigorta Şirketine Göre</option>
					</select>
					<div class="overSelect"></div>
				</div>
				<div id="sigorta_sirketleri">
					<?php while($sigorta_oku = mysql_fetch_array($sigorta_cek)){?>                        
						<label for="<?= $sigorta_oku['sehirID'] ?>">
						<input type="checkbox" name="sigorta[]" value="<?= $sigorta_oku['id'] ?>" /><?= $sigorta_oku['sigorta_adi'] ?></label>
				<?php } ?> 
				</div>
				<!-- style="width: 15px; height: 15px; position: relative; top: -5px;opacity: 1 !important;" -->
			</div>
			<div class="multiselect">
				<div class="selectBox" onclick="showihale_turu()">
					<select style="height:1.8em;">
						<option>İhale Türüne Göre</option>
					</select>
				<div class="overSelect"></div>
				</div>
				<div id="ihale_turu">
					<input type="checkbox" name="ihale_turu[]" value="1" />Açık İhale
					<input type="checkbox" name="ihale_turu[]" value="2" />Kapalı İhale
			
				</div>
				<!-- style="width: 15px; height: 15px; position: relative; top: -5px;opacity: 1 !important;" -->
			</div>
			<div class="multiselect">
				<div class="selectBox" onclick="showMarkalar();">
					<select style="height:1.8em;">
						<option>Markaya Göre</option>
					</select>
					<div class="overSelect"></div>
				</div>
				<div id="markalar" onchange="markaGetir();">
					<?php while($marka_oku = mysql_fetch_array($marka_cek)){?>                        
						<label for="<?= $marka_oku['markaID'] ?>">
						<input  type="checkbox" name="marka[]" value="<?= $marka_oku['markaID'] ?>" /><?= $marka_oku['marka_adi'] ?></label>
					<?php } ?> 
				</div>
			</div>
			<div class="multiselect">
				<div class="selectBox" onclick="showModeller();markaGetir();">
					<select style="height:1.8em;" >
						<option>Modele Göre</option>
					</select>
					<div class="overSelect"></div>
					</div>
				<div id="model">
				<?php /*                        
					<label for="<?= $marka_oku['markaID'] ?>">
					<input type="checkbox" name="model[]" value="<?= $marka_oku['markaID'] ?>" /><?= $marka_oku['marka_adi'] ?></label>
				 */ ?> 
				</div>
			</div>
			<div class="multiselect">
				<div class="selectBox" onclick="showBitis()">
					<select style="height:1.8em;">
						<option>Tarihe Göre</option>
					</select>
					<div class="overSelect"></div>
				</div>
				<div id="tarih">    
					<?php
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
							
								<input type="checkbox" name="tarih[]" value="<?=$ilan_tarihleri_oku["ihale_tarihi"] ?>" /><?=$tarih ?> </br>

						<?php } ?>
				</div>
			</div>
			<div class="multiselect">
				<div class="selectBox" onclick="showTeklif()">
					<select style="height:1.8em;">
						<option>Teklif Durumuna Göre</option>
					</select>
					<div class="overSelect"></div>
				</div>
				<div id="teklif_durum">                           
					<input type="checkbox" name="teklif_durum_var" value="1" />Teklif Verilenler</label><br>
					<input type="checkbox" name="teklif_durum_yok" value="0" />Teklif Verilmeyenler</label>
				</div>
			</div>
			<div class="multiselect">
				<div class="selectBox" onclick="showProfil()">
					<select style="height:1.8em;">
						<option>Profile Göre</option>
					</select>
					<div class="overSelect"></div>
				</div>
				<div id="profil"> 
					<label for="Çekme Belgeli/Pert Kayıtlı">                          
						<input type="checkbox" name="profil[]" value="Çekme Belgeli/Pert Kayıtlı" />Çekme Belgeli/Pert Kayıtlı
					</label><br>
					<label for="Çekme Belgeli"> 
						<input type="checkbox" name="profil[]" value="Çekme Belgeli" />Çekme Belgeli
					</label><br>
					<label for="Hurda Belgeli"> 
						<input type="checkbox" name="profil[]" value="Hurda Belgeli" />Hurda Belgeli
					</label><br>
					<label for="Plakalı"> 
						<input type="checkbox" name="profil[]" value="Plakalı" />Plakalı
					</label>
				</div>
			</div>
			<div class="multiselect">
				<div class="selectBox" onclick="showEkleyenAdmin()">
					<select style="height:1.8em;">
						<option>Ekleyen Kişiye Göre</option>
					</select>
				<div class="overSelect"></div>
				</div>
				<div id="adminler">
					<?php 
					$admin_cek = mysql_query("select * from kullanicilar");
					while($admin_oku = mysql_fetch_array($admin_cek)){?>                        
						<label for="<?= $admin_oku['adi'] ?>">
						<input type="checkbox" name="adminler[]" value="<?= $admin_oku['token'] ?>" /><?= $admin_oku['adi']." ".$admin_oku['soyadi'] ?></label>
				<?php } ?> 
				</div>
				
			</div>
		</div>
		<div class="span6">
			<div class="form-check">
				<h5>Yıla Göre</h5>
			</div>
			<div class="form-group">
				<label for="exampleInputEmail1">En düşük</label>
				<input type="text" name="kucuk_yil" class="form-control">
			</div>
			<div class="form-group">
				<label for="exampleInputPassword1">En yüksek</label>
				<input type="text" name="buyuk_yil" class="form-control" >
			</div>
			<div class="form-check">
				<h5>Kapanış Tarihine Göre</h5>
			</div>
			<div class="form-group">
				<label for="exampleInputEmail1">Küçük Tarih</label>
				<input type="date" name="kucuk_kapanis" class="form-control">
			</div>
			<div class="form-group">
				<label for="exampleInputPassword1">Büyük Tarih</label>
				<input type="date" name="buyuk_kapanis" class="form-control" >
			</div>
			<div class="form-check">
				<h5>Ekleme Tarihine Göre</h5>
			</div>
			<div class="form-group">
				<label for="exampleInputEmail1">Küçük Tarih</label>
				<input type="date" name="kucuk_ekleme" class="form-control">
			</div>
			<div class="form-group">
				<label for="exampleInputPassword1">Büyük Tarih</label>
				<input type="date" name="buyuk_ekleme" class="form-control" >
			</div>
		</div>
	</div>
	<button type="submit" name="filtrele" class="btn blue">Ara</button>
</form>

<?php 
if(isset($_POST['filtrele'])){                    
	$f_arama_kriteri = $_POST['arama_kriteri'];     
	$f_kelime = $_POST['aranan'];     
	$f_marka = $_POST['marka'];
	$f_sehir = $_POST['sehir'];
	$f_tarih = $_POST['tarih'];
	$f_profil = $_POST['profil'];
	$f_kucuk_yil = $_POST['kucuk_yil'];
	$f_buyuk_yil = $_POST['buyuk_yil'];                   
	$f_sigorta_sirketi = $_POST['sigorta'];   
	$f_adminler = $_POST['adminler'];   
	$f_ihale_turu=$_POST["ihale_turu"];     
	$f_kucuk_kapanis = $_POST['kucuk_kapanis'];
	$f_buyuk_kapanis = $_POST['buyuk_kapanis'];   
	$f_kucuk_ekleme = $_POST['kucuk_ekleme'];
	$f_buyuk_ekleme = $_POST['buyuk_ekleme'];   
	$f_teklif_var = $_POST['teklif_durum_var'];                
	$f_teklif_yok = $_POST['teklif_durum_yok'];                
 
	//$where = "WHERE durum = '1'";
	$where = "WHERE id > '0' ";
	if($f_kelime !=""){
		$where .= "AND concat(plaka,model,arac_kodu,model_yili,sehir,ilce,hesaplama) LIKE '%".$f_kelime."%'";
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
		$where = $where . " AND sehir in (". $seciliSehir . ")";
	}

	if($f_ihale_turu !=""){
		$ihale = 0;
		$seciliİhaleSayisi = count($_POST['ihale_turu']);
		$seciliİhale = "";
		while ($ihale < $seciliİhaleSayisi) {
			$seciliİhale = $seciliİhale . "'" . $_POST['ihale_turu'][$ihale] . "'";
			if ($ihale < $seciliİhaleSayisi - 1) {
				$seciliİhale = $seciliİhale . ", ";
			}
			$ihale ++;
		}
		$where = $where . " AND ihale_turu in (" . $seciliİhale . ")";
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
		$where = $where . " AND profil in (" . $seciliProfil . ")";
	}

	if($f_sigorta_sirketi !=""){
		$si = 0;
		$secili_sigorta = count($_POST['sigorta']);
		$seciliSigorta = "";
		while ($si < $secili_sigorta) {
			$seciliSigorta = $seciliSigorta . "'" . $_POST['sigorta'][$si] . "'";
			if ($si < $secili_sigorta - 1) {
				$seciliSigorta = $seciliSigorta . ", ";
			}
			$si ++;
		}
		$where = $where . " AND sigorta in (" . $seciliSigorta . ")";
	}

	if($f_adminler !=""){
		$tm = 0;
		$secili_adminler = count($_POST['adminler']);
		$seciliAdminler = "";
		while ($tm < $secili_adminler) {
			$seciliAdminler = $seciliAdminler . "'" . $_POST['adminler'][$tm] . "'";
			if ($tm < $secili_adminler - 1) {
				$seciliAdminler = $seciliAdminler . ", ";
			}
			$tm ++;
		}
		$where = $where . " AND ihale_sahibi in (" . $seciliAdminler . ")";
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
	if($f_kucuk_yil !="" && $f_buyuk_yil !=""){
		$where .= "AND  model_yili BETWEEN $f_kucuk_yil AND $f_buyuk_yil ";
	}
	
	if($f_kucuk_kapanis !="" && $f_buyuk_kapanis !=""){
		$where .= "AND  ihale_tarihi BETWEEN '".date($f_kucuk_kapanis)."' AND '".date($f_buyuk_kapanis)."'";
	}else if($f_kucuk_kapanis !="" && $f_buyuk_kapanis ==""){
		$where .= "AND  ihale_tarihi ='".date($f_kucuk_kapanis)."'";
	}
	
	
	if($f_kucuk_ekleme !="" && $f_buyuk_ekleme !=""){
		$where .= "AND  eklenme_zamani BETWEEN '".date($f_kucuk_ekleme)."' AND '".date($f_buyuk_ekleme)."'";
	}else if($f_kucuk_ekleme !="" && $f_buyuk_ekleme ==""){
		$where .= "AND  eklenme_zamani ='".date($f_kucuk_ekleme)."'";
	}
	if($f_teklif_var != ""){
		$where .= "AND son_teklif > 0 ";
	}
	if($f_teklif_yok != ""){
		$where .= "AND son_teklif = '0' ";
	}
	
	if($f_arama_kriteri!="" && $f_kucuk_kapanis =="" && $f_buyuk_kapanis =="" && $f_kucuk_ekleme =="" && $f_buyuk_ekleme ==""   ){
		$t = 0;
		$arama_where="";
		$seciliAramaKriteriSayisi = count($_POST['arama_kriteri']);
		
		while ($t < $seciliAramaKriteriSayisi) {
			if($_POST["arama_kriteri"][$t]=="1"){
				$arama_where.=" durum=1 ";//İhalesi devam edenler
			}else if($_POST["arama_kriteri"][$t]=="2"){
				$arama_where.=" ihale_tarihi = '".date("Y-m-d")."' ";//Bügun bitecekler
			}else if($_POST["arama_kriteri"][$t]=="3"){
				$arama_where.=" ihale_tarihi = '".date("Y-m-d",strtotime('+1 days'))."' ";//Yarın bitecekler
			}else if($_POST["arama_kriteri"][$t]=="4"){
				$arama_where.=" durum=-1 ";//İhalesi bitenler
			}else if($_POST["arama_kriteri"][$t]=="5"){
				$arama_where.=" ekleme_tarihi = '".date("Y-m-d")."' "; //Bugün Eklenenler
			}else if($_POST["arama_kriteri"][$t]=="6"){
				$arama_where.=" id=(select ilan_id from kazanilan_ilanlar where kazanilan_ilanlar.ilan_id=ilanlar.id) ";//Statü atanmışsa
			}else if($_POST["arama_kriteri"][$t]=="7"){
				$arama_where=" true "; //Tümü
			}
			if ($t < $seciliAramaKriteriSayisi - 1) {
				if($_POST["arama_kriteri"][$t]=="1"){
					$arama_where = $arama_where . " and (";
				}else{
					$arama_where = $arama_where . " or ";
				}
			}else {
				
				if(in_array("1",$_POST["arama_kriteri"]) && $seciliAramaKriteriSayisi>1){
					$arama_where = $arama_where . " ) ";
				}
			}
			$t++;
		}
		$where.="AND ( ".$arama_where." )";	
		
	}
	$filtre_cek = "SELECT * FROM ilanlar $where  ORDER BY concat(ihale_tarihi,' ',ihale_saati) asc";
	
	$result = mysql_query($filtre_cek) or die(mysql_error());
	
	$sayi = mysql_num_rows($result);
	
	
	if($sayi==0){
		echo '<script type="text/javascript">'; 
		echo 'alert("İstediğiniz kriterlere uygun araç bulunamadı.");'; 
		echo 'window.location.href = "?modul=mesajlar&sayfa=mesajlar";';
		echo '</script>';                       
	}else{ ?>

	<form method="POST" action="?modul=ihaleler&sayfa=toplu_sil" onsubmit="return confirm('SEÇİLİ İLANLARI SİLMEK İSTEDİĞİNİZE EMİN MİSİNİ?');" >
		<?php
			$admin_yetki_cek=mysql_query("Select * from kullanicilar where id='".$admin_id."' ");
			$admin_yetki_oku=mysql_fetch_assoc($admin_yetki_cek);
			$yetkiler=$admin_yetki_oku["yetki"];
			$yetki_parcala=explode("|",$yetkiler);

			$btn='';
			$btn2='';
			if (in_array(2, $yetki_parcala) && in_array(1, $yetki_parcala) ) { 
			  $btn='<input type="submit" name="secili_sil" class="btn-danger" value="Seçili Olanları Sil">';
			  $btn2='<input type="submit" name="secili_uzat" class="btn-primary" value="Seçili Olanların Süresini Uzat">';
			}  else if(in_array(2, $yetki_parcala) && !in_array(1, $yetki_parcala)){
				$btn='<input type="submit" name="secili_sil" class="btn-danger" value="Seçili Olanları Sil">';
			    $btn2='';
			} else if(!in_array(2, $yetki_parcala) && in_array(1, $yetki_parcala)){
				$btn='';
			    $btn2='<input type="submit" name="secili_uzat" class="btn-primary" value="Seçili Olanların Süresini Uzat">';
			}   else{
				$btn='';
			    $btn2='';
			}
		?>    

		<style>
			a.disabled {
				pointer-events: none;
				cursor: default;
			}
		</style> 
		
		<style>
		
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
			
			/* .checker span
			{
				background:transparent!important;
			} */
			
		</style>
		
		<a><? echo $btn ?></a>
		<a><? echo $btn2 ?></a>
		<!--<button type="button" class="checkall btn blue">Tümünü Seç</button>-->


		<div style="overflow-x:auto;">
			<input type="hidden" id="ihale_say" value="<?=$sayi ?>">	     
			<table id="mesajlar_ilan_table" class="table table-bordered table-striper">
				<thead>
					<tr>
						<!--<td>Seç</td>-->
						<td><input type="checkbox" id="checkle" class="checkall btn btn-blue chec2" style="padding:20px;opacity:1!important; z-index:999;">Tümünü Seç</td>
						<td>Düzenle</td>
						<td>Görseller</td>
						<td>Kod</td>
						<td>Plaka</td>
						<td>İl Adı</td>
						<td>Detaylar</td>
						<td>Sayaç</td>
						<td>Kapanış Zamanı</td>
						<td>En Yüksek</td>
						<td>Teklifleri İncele</td>
						<td>Mesaj</td>
						<td>Favori</td>
						<td>Notlar</td>
						<td>Sigorta</td>
					</tr>
				</thead>
				<?php  
					$sira=0; 
					$tablo_rengi="";
					$ihale_say=mysql_num_rows($result); $td=''; 
							
					$acik_mavi_array=array();
					$koyu_yesil_array=array();
					$acik_yesil_array=array();
					$toz_pembe_array=array();
					$krem_array=array(); 
					$filtre_array=array();
						
				while($filtre_oku = mysql_fetch_array($result)){  

					$teklif_cek = mysql_query("SELECT * FROM teklifler WHERE durum=1 and ilan_id = '".$filtre_oku['id']."' order by teklif_zamani desc limit 1");
					$teklifini_oku = mysql_fetch_assoc($teklif_cek);
					$teklif_sayi = mysql_num_rows($teklif_cek);
					
					$teklifler=mysql_query("select * from teklifler where ilan_id='".$filtre_oku['id']."' and durum=1 order by teklif_zamani desc ");
					$toplam_teklif = mysql_num_rows($teklifler);
					
					
					$mesaj_cek = mysql_query("SELECT * FROM mesajlar WHERE ilan_id = '".$filtre_oku['id']."' ");
					$mesaj_sayi = mysql_num_rows($mesaj_cek);
					$favori_cek = mysql_query("SELECT * FROM favoriler WHERE ilan_id = '".$filtre_oku['id']."'");
					$favori_sayi = mysql_num_rows($favori_cek);
					$not_cek = mysql_query("SELECT * FROM ilan_notlari WHERE ilan_id = '".$filtre_oku['id']."' group by tarih order by id desc");
					$not_sayi = mysql_num_rows($not_cek);


					$sigorta_cek = mysql_query("SELECT * FROM sigorta_ozellikleri WHERE id = '".$filtre_oku['sigorta']."'");
					$sigorta_oku = mysql_fetch_assoc($sigorta_cek);
					$sigorta_adi = $sigorta_oku['sigorta_adi'];
					$gelen_id = $filtre_oku['id'];

					$style = '';
					$class  = '';
					if($oku->profil=="Hurda Belgeli"){
						$class = "blink" ;
						$color2 = "color:red;";
					}elseif($oku->profil=="Plakalı"){         
						$color2 = "color:green;font-weight:bold";            
					}elseif($oku->profil == "Çekme Belgeli/Pert Kayıtlı"){
						$color2 = "color:#000000";
					}else{
						$color2 = "color:#000000";
					}
					$resim_cek = mysql_query("select * from ilan_resimler where ilan_id = '".$filtre_oku['id']."'");
					$resim_oku = mysql_fetch_assoc($resim_cek);
					$resim = $resim_oku['resim'];
					if($resim==""){
						$resim="default.png";
					}
					$marka_cek2 = mysql_query("select * from marka where markaID = '".$filtre_oku['marka']."'");
					$marka_oku2 = mysql_fetch_assoc($marka_cek2);
					$marka_adi2 = $marka_oku2['marka_adi']; 
				
					
					$statu_cek = mysql_query("SELECT * FROM kazanilan_ilanlar WHERE ilan_id = '".$filtre_oku['id']."'");
					$statu_oku = mysql_fetch_assoc($statu_cek);

					if($toplam_teklif>0){
						if($statu_oku['durum'] == "0" || $statu_oku['durum'] == "1" || $statu_oku['durum'] == "2" || $statu_oku['durum'] == "3" || $statu_oku['durum'] == "4"){
					
							$tablo_rengi = "#1b8d3d"; //Koyu yeşil
							$ihale_trh=$filtre_oku["ihale_tarihi"];
							$ihale_st=$filtre_oku["ihale_saati"];
							$srgl=mysql_query("select ilanlar.* from ilanlar inner join teklifler on teklifler.ilan_id=ilanlar.id  where ilanlar.id = '".$filtre_oku["id"]."' and ilanlar.durum=1 and ilanlar.ihale_tarihi='".$ihale_trh."' and ilanlar.ihale_saati='".$ihale_st."' and teklifler.durum=1 group by ilanlar.id");							//
							if(mysql_num_rows($srgl)>0){
								while($oku=mysql_fetch_object($srgl)){
									if(!in_array($oku->id,$filtre_array)){
										array_push($filtre_array,$oku->id);
										
										$tarih_ihale=$oku->ihale_tarihi.' '. $oku->ihale_saati;
										$kapanis_zamani=date("d-m-Y H:i:s", strtotime($oku->ihale_tarihi. " ". $oku->ihale_saati));
										
										
										$teklifler=mysql_query("select * from teklifler where ilan_id='".$oku->id."' and durum=1 order by teklif_zamani desc ");
										$toplam_teklif = mysql_num_rows($teklifler);
										
										
										$mesaj_cek = mysql_query("SELECT * FROM mesajlar WHERE ilan_id = '".$oku->id."' ");
										$mesaj_sayi = mysql_num_rows($mesaj_cek);
										$favori_cek = mysql_query("SELECT * FROM favoriler WHERE ilan_id = '".$oku->id."'");
										$favori_sayi = mysql_num_rows($favori_cek);
										$not_cek = mysql_query("SELECT * FROM ilan_notlari WHERE ilan_id = '".$oku->id."' group by tarih order by id desc");
										$not_sayi = mysql_num_rows($not_cek);


										$sigorta_cek = mysql_query("SELECT * FROM sigorta_ozellikleri WHERE id = '".$oku->sigorta."'");
										$sigorta_oku = mysql_fetch_assoc($sigorta_cek);
										$sigorta_adi = $sigorta_oku['sigorta_adi'];

										$style = '';
										$class  = '';
										if($oku->profil=="Hurda Belgeli"){
											$class = "blink" ;
											$color2 = "color:red;";
										}elseif($oku->profil=="Plakalı"){         
											$color2 = "color:green;font-weight:bold";            
										}elseif($oku->profil == "Çekme Belgeli/Pert Kayıtlı"){
											$color2 = "color:#000000";
										}else{
											$color2 = "color:#000000";
										}
										
										$resim_cek = mysql_query("select * from ilan_resimler where ilan_id = '".$oku->id."'");
										$resim_oku = mysql_fetch_assoc($resim_cek);
										$resim = $resim_oku['resim'];
										if($resim==""){
											$resim="default.png";
										}
										$stat_cek = mysql_query("SELECT * FROM kazanilan_ilanlar WHERE ilan_id = '".$oku->id."'");
										$stat_oku = mysql_fetch_assoc($stat_cek);
										$tklif_cek = mysql_query("SELECT * FROM teklifler WHERE durum=1 and ilan_id = '".$oku->id."' order by teklif_zamani desc limit 1");
										$tklifini_oku = mysql_fetch_assoc($tklif_cek);
										$tklif_sayi = mysql_num_rows($tklif_cek);
										if($stat_oku['durum'] == "0" || $stat_oku['durum'] == "1" || $stat_oku['durum'] == "2" || $stat_oku['durum'] == "3" || $stat_oku['durum'] == "4"){
											$tablo_rengi = "#1b8d3d"; //Koyu yeşil
											
										}else if($oku->ihale_turu == "1" && $tklifini_oku['uye_id']!='283'){
											if($oku->durum == "-1"){
													$tablo_rengi = "#00a2ff"; //Açık mavi       
											}else{
												$tablo_rengi = "#b4e61d"; //Açık yeşil      
											}
										}else if($oku->ihale_turu== "1" && $tklifini_oku['uye_id']=='283'){
											$tablo_rengi = "#feadc8";  //Toz pembe
										}else {
											if($oku->ihale_turu== "2" && $tklifini_oku['uye_id']=='283'){
												$tablo_rengi = "#ffd0b0";//Krem rengi
											}else{
												$tablo_rengi = "#ffd0b0";//Krem rengi
											}
										}
										
										if($tablo_rengi=="#1b8d3d"){
											$t_color="color:#fff;";
											$color="#fff";
										}else{
											$t_color="";
										}
										if($oku->link!=""){
											$sgrt_adi='<a style="'.$t_color.'" href="'.$oku->link.'" target="_blank">'.$sigorta_adi.'</a>';
										}else{
											$sgrt_adi='<span style="'.$t_color.'">'.$sigorta_adi.'</span>';
										}
										$arac_detaylari=$oku->model_yili." ".$marka_adi2." ".$oku->model." ".$oku->tip." <span style='".$color2."' class='".$class."'>".$oku->profil."</span>";
										$td.='
											<tr id="tr_'.$oku->id.'" style="background-color: '.$tablo_rengi.'; '.$t_color.' ">
												<td><input type="checkbox" name="secim[]" class="chec" id="asd'.$oku->id.'" value="'.$oku->id.'" style="opacity:1!important; z-index:999;"></td>
												<td><a target="_blank" href="?modul=ilanlar&sayfa=ilan_ekle&id='.$oku->id.'"><i class="fas fa-edit"></i></a></td>
												<td><a onclick="tabTrigger()" href="?modul=ilanlar&sayfa=ilan_ekle&id='.$oku->id.'" target="_blank"><img style="width: 50px; height:50px;" src="../images/'.$resim.'" alt=""></a></td>
												<td>'.$oku->arac_kodu.'</td>
												<td>'.$oku->plaka.'</td>    
												<td>'.$oku->sehir.'</td>  
												<td style="color:'.$color.';"><a href="../arac_detay.php?id='.$oku->id.'&q=ihale" style="color:'.$color.';"  target="_blank">'.$arac_detaylari.'</a></td>    
												<td id="sayac'.$sira.'">
													<input type="hidden" id="ihale_sayac'.$sira.'" value="'.$tarih_ihale.'" >
													<input type="hidden" id="id_'.$sira.'" value="'.$oku->id.'">
												</td> 
												<td>
													<a style="cursor: pointer;'.$t_color.'" class="view_guncelle kapanis_zamani'.$sira.'" id="'.$oku->id.'">'.$kapanis_zamani.'</a>
												</td>
												<td class="'.$yan.'"><a class="view_uyeye_teklif_ver" style="'.$t_color.'" id="sonteklif_'.$oku->id.'">'.money($oku->son_teklif).'₺</a></td>   
												<!-- <td class="'.$yan.'">'.$oku->son_teklif.'</td>     -->
												<input type="hidden" id="teklif_sayisi'.$sira.'" value="'.$toplam_teklif.'" >
												<td><a style="'.$t_color.'" class="view_ilan_teklifleri" id="teklifler_'.$oku->id.'"><i class="fas fa-gavel">'.$toplam_teklif.'</i></a></td>    
												<td><a style="'.$t_color.'" class="view_ilan_mesajlari" id="mesajlar_'.$oku->id.'"><i class="fas fa-envelope">'.$mesaj_sayi.'</i></a></td>    
												<td><a style="'.$t_color.'" class="view_ilan_favorileri" id="'.$oku->id.'"><i class="fas fa-heart">'.$favori_sayi.'</i></a></td>    
												<td><a style="'.$t_color.'" class="view_ilan_notlari" id="'.$oku->id.'"><i class="fas fa-align-justify">'.$not_sayi.'</i></a></td>    
												<td>'.$sgrt_adi.'</td>
											</tr>
										';
										$sira++;
									}
								}
							}else{
								
								if(!in_array($filtre_oku['id'],$filtre_array)){
									
									
									$tarih_ihale=$filtre_oku['ihale_tarihi'].' '. filtre_oku;
									$kapanis_zamani=date("d-m-Y H:i:s", strtotime($filtre_oku["ihale_tarihi"]. " ". $filtre_oku["ihale_saati"]));
									if($tablo_rengi=="#1b8d3d"){
										$t_color="color:#fff;";
										$color="#fff";
									}else{
										$t_color="";
									}

									if($filtre_oku["link"]!=""){
										$sgrt_adi='<a style="'.$t_color.'" href="'.$filtre_oku["link"].'" target="_blank">'.$sigorta_adi.'</a>';
									}else{
										$sgrt_adi='<span style="'.$t_color.'">'.$sigorta_adi.'</span>';
									}	
									$arac_detaylari=$filtre_oku["model_yili"]." ".$marka_adi2." ".$filtre_oku['model']." ".$filtre_oku['tip']." <span style='".$color2."' class='".$class."'>".$filtre_oku['profil']."</span>";
									$td.='
										<tr id="tr_'.$filtre_oku["id"].'" style="background-color: '.$tablo_rengi.';'.$t_color.'  ">
											<td><input type="checkbox" name="secim[]" class="chec" id="asd'.$gelen_id.'" value="'.$gelen_id.'" style="opacity:1!important; z-index:999;"></td>
											<td><a target="_blank" href="?modul=ilanlar&sayfa=ilan_ekle&id='.$gelen_id.'"><i class="fas fa-edit"></i></a></td>
											<td><a onclick="tabTrigger()" href="?modul=ilanlar&sayfa=ilan_ekle&id='.$gelen_id.'" target="_blank"><img style="width: 50px; height:50px;" src="../images/'.$resim.'" alt=""></a></td>
											<td>'.$filtre_oku["arac_kodu"].'</td>
											<td>'.$filtre_oku["plaka"].'</td>    
											<td>'.$filtre_oku['sehir'].'</td>  
											<td style="color:'.$color.';" ><a href="../arac_detay.php?id='.$gelen_id.'&q=ihale" style="color:'.$color.';"  target="_blank">'.$arac_detaylari.'</a></td>    
											<td id="sayac'.$sira.'">
												<input type="hidden" id="ihale_sayac'.$sira.'" value="'.$tarih_ihale.'" >
												<input type="hidden" id="id_'.$sira.'" value="'.$filtre_oku['id'].'">
											</td> 
											<td>
												<a style="cursor: pointer;'.$t_color.'" class="view_guncelle kapanis_zamani'.$sira.'" id="'.$filtre_oku['id'].'">'.$kapanis_zamani.'</a>
											</td>
											<td class="'.$yan.'"><a style="'.$t_color.'" class="view_uyeye_teklif_ver" id="sonteklif_'.$filtre_oku['id'].'">'.money($filtre_oku["son_teklif"]).'₺</a></td>   
											<!-- <td class="'.$yan.'">'.$filtre_oku["son_teklif"].'</td>     -->
											<input type="hidden" id="teklif_sayisi'.$sira.'" value="'.$toplam_teklif.'" >
											<td><a style="'.$t_color.'" class="view_ilan_teklifleri" id="teklifler_'.$filtre_oku['id'].'"><i class="fas fa-gavel">'.$toplam_teklif.'</i></a></td>    
											<td><a style="'.$t_color.'" class="view_ilan_mesajlari" id="mesajlar_'.$filtre_oku['id'].'"><i class="fas fa-envelope">'.$mesaj_sayi.'</i></a></td>    
											<td><a style="'.$t_color.'" class="view_ilan_favorileri" id="'.$filtre_oku['id'].'"><i class="fas fa-heart">'.$favori_sayi.'</i></a></td>    
											<td><a style="'.$t_color.'" class="view_ilan_notlari" id="'.$filtre_oku['id'].'"><i class="fas fa-align-justify">'.$not_sayi.'</i></a></td>    
											<td>'.$sgrt_adi.'</td>
										</tr>
									';
									$sira++;
								}
								
							}
						}else if($filtre_oku['ihale_turu']== "1" && $teklifini_oku['uye_id']!='283'){
							if($filtre_oku['durum']== "-1"){
								$tablo_rengi = "#00a2ff"; //Açık mavi  
								$ihale_trh=$filtre_oku["ihale_tarihi"];
								$ihale_st=$filtre_oku["ihale_saati"];
								$srgl=mysql_query("select ilanlar.* from ilanlar inner join teklifler on teklifler.ilan_id=ilanlar.id  where ilanlar.id = '".$filtre_oku["id"]."' and ilanlar.durum=1 and ilanlar.ihale_tarihi='".$ihale_trh."' and ilanlar.ihale_saati='".$ihale_st."' and teklifler.durum=1 group by ilanlar.id");							//
								if(mysql_num_rows($srgl)>0){
									while($oku=mysql_fetch_object($srgl)){
										if(!in_array($oku->id,$filtre_array)){
											array_push($filtre_array,$oku->id);
										
											$tarih_ihale=$oku->ihale_tarihi.' '. $oku->ihale_saati;
											$kapanis_zamani=date("d-m-Y H:i:s", strtotime($oku->ihale_tarihi. " ". $oku->ihale_saati));

											
											$teklifler=mysql_query("select * from teklifler where ilan_id='".$oku->id."' and durum=1 order by teklif_zamani desc ");
											$toplam_teklif = mysql_num_rows($teklifler);
											
											
											$mesaj_cek = mysql_query("SELECT * FROM mesajlar WHERE ilan_id = '".$oku->id."' ");
											$mesaj_sayi = mysql_num_rows($mesaj_cek);
											$favori_cek = mysql_query("SELECT * FROM favoriler WHERE ilan_id = '".$oku->id."'");
											$favori_sayi = mysql_num_rows($favori_cek);
											$not_cek = mysql_query("SELECT * FROM ilan_notlari WHERE ilan_id = '".$oku->id."' group by tarih order by id desc");
											$not_sayi = mysql_num_rows($not_cek);


											$sigorta_cek = mysql_query("SELECT * FROM sigorta_ozellikleri WHERE id = '".$oku->sigorta."'");
											$sigorta_oku = mysql_fetch_assoc($sigorta_cek);
											$sigorta_adi = $sigorta_oku['sigorta_adi'];

											$style = '';
											$class  = '';
											if($oku->profil=="Hurda Belgeli"){
												$class = "blink" ;
												$color2 = "color:red;";
											}elseif($oku->profil=="Plakalı"){         
												$color2 = "color:green;font-weight:bold";            
											}elseif($oku->profil == "Çekme Belgeli/Pert Kayıtlı"){
												$color2 = "color:#000000";
											}else {
												$color2 = "color:#000000";
											}
											
											$resim_cek = mysql_query("select * from ilan_resimler where ilan_id = '".$oku->id."'");
											$resim_oku = mysql_fetch_assoc($resim_cek);
											$resim = $resim_oku['resim'];
											if($resim==""){
												$resim="default.png";
											}
											$stat_cek = mysql_query("SELECT * FROM kazanilan_ilanlar WHERE ilan_id = '".$oku->id."'");
											$stat_oku = mysql_fetch_assoc($stat_cek);
											$tklif_cek = mysql_query("SELECT * FROM teklifler WHERE durum=1 and ilan_id = '".$oku->id."' order by teklif_zamani desc limit 1");
											$tklifini_oku = mysql_fetch_assoc($tklif_cek);
											$tklif_sayi = mysql_num_rows($tklif_cek);
											if($stat_oku['durum'] == "0" || $stat_oku['durum'] == "1" || $stat_oku['durum'] == "2" || $stat_oku['durum'] == "3" || $stat_oku['durum'] == "4"){
												$tablo_rengi = "#1b8d3d"; //Koyu yeşil
											}else if($oku->ihale_turu == "1" && $tklifini_oku['uye_id']!='283'){
												if($oku->durum == "-1"){
														$tablo_rengi = "#00a2ff"; //Açık mavi       
												}else{
													$tablo_rengi = "#b4e61d"; //Açık yeşil      
												}
											}else if($oku->ihale_turu== "1" && $tklifini_oku['uye_id']=='283'){
												$tablo_rengi = "#feadc8";  //Toz pembe
											}else {
												if($oku->ihale_turu== "2" && $tklifini_oku['uye_id']=='283'){
													$tablo_rengi = "#ffd0b0";//Krem rengi
												}else{
													$tablo_rengi = "#ffd0b0";//Krem rengi
												}
											}
											
											
											if($tablo_rengi=="#1b8d3d"){
												$t_color="color:#fff;";
												$color="#fff";
											}else{
												$t_color="";
											}
											$arac_detaylari=$oku->model_yili." ".$marka_adi2." ".$oku->model." ".$oku->tip." <span style='".$color2."' class='".$class."'>".$oku->profil."</span>";
											if($oku->link!=""){
												$sgrt_adi='<a style="'.$t_color.'" href="'.$oku->link.'" target="_blank">'.$sigorta_adi.'</a>';
											}else{
												$sgrt_adi='<span style="'.$t_color.'">'.$sigorta_adi.'</span>';
											}
											$td.='
												<tr id="tr_'.$oku->id.'" style="background-color: '.$tablo_rengi.'; '.$t_color.' ">
													<td><input type="checkbox" name="secim[]" class="chec" id="asd'.$oku->id.'" value="'.$oku->id.'" style="opacity:1!important; z-index:999;"></td>
													<td><a target="_blank" href="?modul=ilanlar&sayfa=ilan_ekle&id='.$oku->id.'"><i class="fas fa-edit"></i></a></td>
													<td><a onclick="tabTrigger()" href="?modul=ilanlar&sayfa=ilan_ekle&id='.$oku->id.'" target="_blank"><img style="width: 50px; height:50px;" src="../images/'.$resim.'" alt=""></a></td>
													<td>'.$oku->arac_kodu.'</td>
													<td>'.$oku->plaka.'</td>    
													<td>'.$oku->sehir.'</td>  
													<td style="color:'.$color.';" ><a href="../arac_detay.php?id='.$oku->id.'&q=ihale" style="color:'.$color.';" target="_blank">'.$arac_detaylari.'</a></td>    
													<td id="sayac'.$sira.'">
														<input type="hidden" id="ihale_sayac'.$sira.'" value="'.$tarih_ihale.'" >
														<input type="hidden" id="id_'.$sira.'" value="'.$oku->id.'">
													</td> 
													<td>
														<a style="cursor: pointer;'.$t_color.'" class="view_guncelle kapanis_zamani'.$sira.'" id="'.$oku->id.'">'.$kapanis_zamani.'</a>
													</td>
													<td class="'.$yan.'"><a class="view_uyeye_teklif_ver" style="'.$t_color.'" id="sonteklif_'.$oku->id.'">'.money($oku->son_teklif).'₺</a></td>   
													<!-- <td class="'.$yan.'">'.$oku->son_teklif.'</td>     -->
													<input type="hidden" id="teklif_sayisi'.$sira.'" value="'.$toplam_teklif.'" >
													<td><a style="'.$t_color.'" class="view_ilan_teklifleri" id="teklifler_'.$oku->id.'"><i class="fas fa-gavel">'.$toplam_teklif.'</i></a></td>    
													<td><a style="'.$t_color.'" class="view_ilan_mesajlari" id="mesajlar_'.$oku->id.'"><i class="fas fa-envelope">'.$mesaj_sayi.'</i></a></td>    
													<td><a style="'.$t_color.'" class="view_ilan_favorileri" id="'.$oku->id.'"><i class="fas fa-heart">'.$favori_sayi.'</i></a></td>    
													<td><a style="'.$t_color.'" class="view_ilan_notlari" id="'.$oku->id.'"><i class="fas fa-align-justify">'.$not_sayi.'</i></a></td>    
													<td>'.$sgrt_adi.'</td>  
												</tr>
											';
											$sira++;
										}
									}
								}else{
									if(!in_array($filtre_oku['id'],$filtre_array)){
										$tarih_ihale=$filtre_oku['ihale_tarihi'].' '. $filtre_oku['ihale_saati'];
										$kapanis_zamani=date("d-m-Y H:i:s", strtotime($filtre_oku["ihale_tarihi"]. " ". $filtre_oku["ihale_saati"]));
										if($tablo_rengi=="#1b8d3d"){
											$t_color="color:#fff;";
											$color="#fff";
										}else{
											$t_color="";
										}
										$arac_detaylari=$filtre_oku["model_yili"]." ".$marka_adi2." ".$filtre_oku['model']." ".$filtre_oku['tip']." <span style='".$color2."' class='".$class."'>".$filtre_oku['profil']."</span>";
										if($filtre_oku["link"]!=""){
											$sgrt_adi='<a style="'.$t_color.'" href="'.$filtre_oku["link"].'" target="_blank">'.$sigorta_adi.'</a>';
										}else{
											$sgrt_adi='<span style="'.$t_color.'">'.$sigorta_adi.'</span>';
										}
										$td.='
											<tr id="tr_'.$filtre_oku["id"].'" style="background-color: '.$tablo_rengi.';'.$t_color.'  ">
												<td><input type="checkbox" name="secim[]" class="chec" id="asd'.$gelen_id.'" value="'.$gelen_id.'" style="opacity:1!important; z-index:999;"></td>
												<td><a target="_blank" href="?modul=ilanlar&sayfa=ilan_ekle&id='.$gelen_id.'"><i class="fas fa-edit"></i></a></td>
												<td><a onclick="tabTrigger()" href="?modul=ilanlar&sayfa=ilan_ekle&id='.$gelen_id.'" target="_blank"><img style="width: 50px; height:50px;" src="../images/'.$resim.'" alt=""></a></td>
												<td>'.$filtre_oku["arac_kodu"].'</td>
												<td>'.$filtre_oku["plaka"].'</td>    
												<td>'.$filtre_oku['sehir'].'</td>  
												<td style="color:'.$color.';" ><a href="../arac_detay.php?id='.$gelen_id.'&q=ihale" style="color:'.$color.';"  target="_blank">'.$arac_detaylari.'</a></td>    
												<td id="sayac'.$sira.'">
													<input type="hidden" id="ihale_sayac'.$sira.'" value="'.$tarih_ihale.'" >
													<input type="hidden" id="id_'.$sira.'" value="'.$filtre_oku['id'].'">
												</td> 
												<td>
													<a style="cursor: pointer;'.$t_color.'" class="view_guncelle kapanis_zamani'.$sira.'" id="'.$filtre_oku['id'].'">'.$kapanis_zamani.'</a>
												</td>
												<td class="'.$yan.'"><a style="'.$t_color.'" class="view_uyeye_teklif_ver" id="sonteklif_'.$filtre_oku['id'].'">'.money($filtre_oku["son_teklif"]).'₺</a></td>   
												<!-- <td class="'.$yan.'">'.$filtre_oku["son_teklif"].'</td>     -->
												<input type="hidden" id="teklif_sayisi'.$sira.'" value="'.$toplam_teklif.'" >
												<td><a style="'.$t_color.'" class="view_ilan_teklifleri" id="teklifler_'.$filtre_oku['id'].'"><i class="fas fa-gavel">'.$toplam_teklif.'</i></a></td>    
												<td><a style="'.$t_color.'" class="view_ilan_mesajlari" id="mesajlar_'.$filtre_oku['id'].'"><i class="fas fa-envelope">'.$mesaj_sayi.'</i></a></td>    
												<td><a style="'.$t_color.'" class="view_ilan_favorileri" id="'.$filtre_oku['id'].'"><i class="fas fa-heart">'.$favori_sayi.'</i></a></td>    
												<td><a style="'.$t_color.'" class="view_ilan_notlari" id="'.$filtre_oku['id'].'"><i class="fas fa-align-justify">'.$not_sayi.'</i></a></td>    
												<td>'.$sgrt_adi.'</td>  
											</tr>
										';
										$sira++;
									}
									
								}
							}else{
								$tablo_rengi = "#b4e61d"; //Açık yeşil    
								$ihale_trh=$filtre_oku["ihale_tarihi"];
								$ihale_st=$filtre_oku["ihale_saati"];
								$srgl=mysql_query("select ilanlar.* from ilanlar inner join teklifler on teklifler.ilan_id=ilanlar.id  where ilanlar.id = '".$filtre_oku["id"]."' and ilanlar.durum=1 and ilanlar.ihale_tarihi='".$ihale_trh."' and ilanlar.ihale_saati='".$ihale_st."' and teklifler.durum=1 group by ilanlar.id");							//
								if(mysql_num_rows($srgl)>0){
									while($oku=mysql_fetch_object($srgl)){
										if(!in_array($oku->id,$filtre_array)){
											array_push($filtre_array,$oku->id);
											$tarih_ihale=$oku->ihale_tarihi.' '. $oku->ihale_saati;
											$kapanis_zamani=date("d-m-Y H:i:s", strtotime($oku->ihale_tarihi. " ". $oku->ihale_saati));
																					
											$teklifler=mysql_query("select * from teklifler where ilan_id='".$oku->id."' and durum=1 order by teklif_zamani desc ");
											$toplam_teklif = mysql_num_rows($teklifler);

											$mesaj_cek = mysql_query("SELECT * FROM mesajlar WHERE ilan_id = '".$oku->id."' ");
											$mesaj_sayi = mysql_num_rows($mesaj_cek);
											$favori_cek = mysql_query("SELECT * FROM favoriler WHERE ilan_id = '".$oku->id."'");
											$favori_sayi = mysql_num_rows($favori_cek);
											$not_cek = mysql_query("SELECT * FROM ilan_notlari WHERE ilan_id = '".$oku->id."' group by tarih order by id desc");
											$not_sayi = mysql_num_rows($not_cek);

											$sigorta_cek = mysql_query("SELECT * FROM sigorta_ozellikleri WHERE id = '".$oku->sigorta."'");
											$sigorta_oku = mysql_fetch_assoc($sigorta_cek);
											$sigorta_adi = $sigorta_oku['sigorta_adi'];

											$style = '';
											$class  = '';
											if($oku->profil=="Hurda Belgeli"){
												$class = "blink" ;
												$color2 = "color:red;";
											}elseif($oku->profil=="Plakalı"){         
												$color2 = "color:green;font-weight:bold";            
											}elseif($oku->profil == "Çekme Belgeli/Pert Kayıtlı"){
												$color2 = "color:#000000";
											}else{
												$color2 = "color:#000000";
											}
											
											$resim_cek = mysql_query("select * from ilan_resimler where ilan_id = '".$oku->id."'");
											$resim_oku = mysql_fetch_assoc($resim_cek);
											$resim = $resim_oku['resim'];
											if($resim==""){
												$resim="default.png";
											}
											
											$stat_cek = mysql_query("SELECT * FROM kazanilan_ilanlar WHERE ilan_id = '".$oku->id."'");
											$stat_oku = mysql_fetch_assoc($stat_cek);
											$tklif_cek = mysql_query("SELECT * FROM teklifler WHERE durum=1 and ilan_id = '".$oku->id."' order by teklif_zamani desc limit 1");
											$tklifini_oku = mysql_fetch_assoc($tklif_cek);
											$tklif_sayi = mysql_num_rows($tklif_cek);
											if($stat_oku['durum'] == "0" || $stat_oku['durum'] == "1" || $stat_oku['durum'] == "2" || $stat_oku['durum'] == "3" || $stat_oku['durum'] == "4"){
												$tablo_rengi = "#1b8d3d"; //Koyu yeşil
											}else if($oku->ihale_turu == "1" && $tklifini_oku['uye_id']!='283'){
												if($oku->durum == "-1"){
														$tablo_rengi = "#00a2ff"; //Açık mavi       
												}else{
													$tablo_rengi = "#b4e61d"; //Açık yeşil      
												}
											}else if($oku->ihale_turu== "1" && $tklifini_oku['uye_id']=='283'){
												$tablo_rengi = "#feadc8";  //Toz pembe
											}else {
												if($oku->ihale_turu== "2" && $tklifini_oku['uye_id']=='283'){
													$tablo_rengi = "#ffd0b0";//Krem rengi
												}else{
													$tablo_rengi = "#ffd0b0";//Krem rengi
												}
											}
											
											
											if($tablo_rengi=="#1b8d3d"){
												$t_color="color:#fff;";
												$color="#fff";
											}else{
												$t_color="";
											}
											if($oku->link!=""){
												$sgrt_adi='<a style="'.$t_color.'" href="'.$oku->link.'" target="_blank">'.$sigorta_adi.'</a>';
											}else{
												$sgrt_adi='<span style="'.$t_color.'">'.$sigorta_adi.'</span>';
											}
											$arac_detaylari=$oku->model_yili." ".$marka_adi2." ".$oku->model." ".$oku->tip." <span style='".$color2."' class='".$class."'>".$oku->profil."</span>";
											$td.='
												<tr id="tr_'.$oku->id.'" style="background-color: '.$tablo_rengi.'; '.$t_color.' ">
													<td><input type="checkbox" name="secim[]" class="chec" id="asd'.$oku->id.'" value="'.$oku->id.'" style="opacity:1!important; z-index:999;"></td>
													<td><a target="_blank" href="?modul=ilanlar&sayfa=ilan_ekle&id='.$oku->id.'"><i class="fas fa-edit"></i></a></td>
													<td><a onclick="tabTrigger()" href="?modul=ilanlar&sayfa=ilan_ekle&id='.$oku->id.'" target="_blank"><img style="width: 50px; height:50px;" src="../images/'.$resim.'" alt=""></a></td>
													<td>'.$oku->arac_kodu.'</td>
													<td>'.$oku->plaka.'</td>    
													<td>'.$oku->sehir.'</td>  
													<td style="color:'.$color.';" ><a href="../arac_detay.php?id='.$oku->id.'&q=ihale" style="color:'.$color.';" target="_blank">'.$arac_detaylari.'</a></td>    
													<td id="sayac'.$sira.'">
														<input type="hidden" id="ihale_sayac'.$sira.'" value="'.$tarih_ihale.'" >
														<input type="hidden" id="id_'.$sira.'" value="'.$oku->id.'">
													</td> 
													<td>
														<a style="cursor: pointer;'.$t_color.'" class="view_guncelle kapanis_zamani'.$sira.'" id="'.$oku->id.'">'.$kapanis_zamani.'</a>
													</td>
													<td class="'.$yan.'"><a class="view_uyeye_teklif_ver" style="'.$t_color.'" id="sonteklif_'.$oku->id.'">'.money($oku->son_teklif).'₺</a></td>   
													<!-- <td class="'.$yan.'">'.$oku->son_teklif.'</td>     -->
													<input type="hidden" id="teklif_sayisi'.$sira.'" value="'.$toplam_teklif.'" >
													<td><a style="'.$t_color.'" class="view_ilan_teklifleri" id="teklifler_'.$oku->id.'"><i class="fas fa-gavel">'.$toplam_teklif.'</i></a></td>    
													<td><a style="'.$t_color.'" class="view_ilan_mesajlari" id="mesajlar_'.$oku->id.'"><i class="fas fa-envelope">'.$mesaj_sayi.'</i></a></td>    
													<td><a style="'.$t_color.'" class="view_ilan_favorileri" id="'.$oku->id.'"><i class="fas fa-heart">'.$favori_sayi.'</i></a></td>    
													<td><a style="'.$t_color.'" class="view_ilan_notlari" id="'.$oku->id.'"><i class="fas fa-align-justify">'.$not_sayi.'</i></a></td>    
													<td>'.$sgrt_adi.'</td>
												</tr>
											';
											$sira++;
										}
									}
								}else{
									if(!in_array($filtre_oku['id'],$filtre_array)){
										$arac_detaylari=$filtre_oku["model_yili"]." ".$marka_adi2." ".$filtre_oku['model']." ".$filtre_oku['tip']." <span style='".$color2."' class='".$class."'>".$filtre_oku['profil']."</span>";
										$tarih_ihale=$filtre_oku['ihale_tarihi'].' '. $filtre_oku['ihale_saati'];
										$kapanis_zamani=date("d-m-Y H:i:s", strtotime($filtre_oku["ihale_tarihi"]. " ". $filtre_oku["ihale_saati"]));
										if($tablo_rengi=="#1b8d3d"){
											$t_color="color:#fff;";
											$color="#fff";
										}else{
											$t_color="";
										}
										if($filtre_oku["link"]!=""){
											$sgrt_adi='<a style="'.$t_color.'" href="'.$filtre_oku["link"].'" target="_blank">'.$sigorta_adi.'</a>';
										}else{
											$sgrt_adi='<span style="'.$t_color.'">'.$sigorta_adi.'</span>';
										}	
										$td.='
											<tr id="tr_'.$filtre_oku["id"].'" style="background-color: '.$tablo_rengi.';'.$t_color.'  ">
												<td><input type="checkbox" name="secim[]" class="chec" id="asd'.$gelen_id.'" value="'.$gelen_id.'" style="opacity:1!important; z-index:999;"></td>
												<td><a target="_blank" href="?modul=ilanlar&sayfa=ilan_ekle&id='.$gelen_id.'"><i class="fas fa-edit"></i></a></td>
												<td><a onclick="tabTrigger()" href="?modul=ilanlar&sayfa=ilan_ekle&id='.$gelen_id.'" target="_blank"><img style="width: 50px; height:50px;" src="../images/'.$resim.'" alt=""></a></td>
												<td>'.$filtre_oku["arac_kodu"].'</td>
												<td>'.$filtre_oku["plaka"].'</td>    
												<td>'.$filtre_oku['sehir'].'</td>  
												<td style="color:'.$color.';" ><a href="../arac_detay.php?id='.$gelen_id.'&q=ihale" style="color:'.$color.';"  target="_blank">'.$arac_detaylari.'</a></td>    
												<td id="sayac'.$sira.'">
													<input type="hidden" id="ihale_sayac'.$sira.'" value="'.$tarih_ihale.'" >
													<input type="hidden" id="id_'.$sira.'" value="'.$filtre_oku['id'].'">
												</td> 
												<td>
													<a style="cursor: pointer;'.$t_color.'" class="view_guncelle kapanis_zamani'.$sira.'" id="'.$filtre_oku['id'].'">'.$kapanis_zamani.'</a>
												</td>
												<td class="'.$yan.'"><a style="'.$t_color.'" class="view_uyeye_teklif_ver" id="sonteklif_'.$filtre_oku['id'].'">'.money($filtre_oku["son_teklif"]).'₺</a></td>   
												<!-- <td class="'.$yan.'">'.$filtre_oku["son_teklif"].'</td>     -->
												<input type="hidden" id="teklif_sayisi'.$sira.'" value="'.$toplam_teklif.'" >
												<td><a style="'.$t_color.'" class="view_ilan_teklifleri" id="teklifler_'.$filtre_oku['id'].'"><i class="fas fa-gavel">'.$toplam_teklif.'</i></a></td>    
												<td><a style="'.$t_color.'" class="view_ilan_mesajlari" id="mesajlar_'.$filtre_oku['id'].'"><i class="fas fa-envelope">'.$mesaj_sayi.'</i></a></td>    
												<td><a style="'.$t_color.'" class="view_ilan_favorileri" id="'.$filtre_oku['id'].'"><i class="fas fa-heart">'.$favori_sayi.'</i></a></td>    
												<td><a style="'.$t_color.'" class="view_ilan_notlari" id="'.$filtre_oku['id'].'"><i class="fas fa-align-justify">'.$not_sayi.'</i></a></td>    
												<td>'.$sgrt_adi.'</td>
											</tr>
										';
										$sira++;
									}
									
								}								
							}
						}else if($filtre_oku['ihale_turu']== "1" && $teklifini_oku['uye_id']=='283'){
							$tablo_rengi = "#feadc8";  //Toz pembe
							$ihale_trh=$filtre_oku["ihale_tarihi"];
							$ihale_st=$filtre_oku["ihale_saati"];
							$srgl=mysql_query("select ilanlar.* from ilanlar inner join teklifler on teklifler.ilan_id=ilanlar.id  where ilanlar.id = '".$filtre_oku["id"]."' and ilanlar.durum=1 and ilanlar.ihale_tarihi='".$ihale_trh."' and ilanlar.ihale_saati='".$ihale_st."' and teklifler.durum=1 group by ilanlar.id");							//
							if(mysql_num_rows($srgl)>0){
								while($oku=mysql_fetch_object($srgl)){
									if(!in_array($oku->id,$filtre_array)){
										array_push($filtre_array,$oku->id);

										$tarih_ihale=$oku->ihale_tarihi.' '. $oku->ihale_saati;
										$kapanis_zamani=date("d-m-Y H:i:s", strtotime($oku->ihale_tarihi. " ". $oku->ihale_saati));
										
										
										$teklifler=mysql_query("select * from teklifler where ilan_id='".$oku->id."' and durum=1 order by teklif_zamani desc ");
										$toplam_teklif = mysql_num_rows($teklifler);
										
										
										$mesaj_cek = mysql_query("SELECT * FROM mesajlar WHERE ilan_id = '".$oku->id."' ");
										$mesaj_sayi = mysql_num_rows($mesaj_cek);
										$favori_cek = mysql_query("SELECT * FROM favoriler WHERE ilan_id = '".$oku->id."'");
										$favori_sayi = mysql_num_rows($favori_cek);
										$not_cek = mysql_query("SELECT * FROM ilan_notlari WHERE ilan_id = '".$oku->id."' group by tarih order by id desc");
										$not_sayi = mysql_num_rows($not_cek);


										$sigorta_cek = mysql_query("SELECT * FROM sigorta_ozellikleri WHERE id = '".$oku->sigorta."'");
										$sigorta_oku = mysql_fetch_assoc($sigorta_cek);
										$sigorta_adi = $sigorta_oku['sigorta_adi'];

										$style = '';
										$class  = '';
										if($oku->profil=="Hurda Belgeli"){
											$class = "blink" ;
											$color2 = "color:red;";
										}elseif($oku->profil=="Plakalı"){         
											$color2 = "color:green;font-weight:bold";            
										}elseif($oku->profil == "Çekme Belgeli/Pert Kayıtlı"){
											$color2 = "color:#000000";
										}else{
											$color2 = "color:#000000";
										}
										
										$resim_cek = mysql_query("select * from ilan_resimler where ilan_id = '".$oku->id."'");
										$resim_oku = mysql_fetch_assoc($resim_cek);
										$resim = $resim_oku['resim'];
										if($resim==""){
											$resim="default.png";
										}
										
										$stat_cek = mysql_query("SELECT * FROM kazanilan_ilanlar WHERE ilan_id = '".$oku->id."'");
										$stat_oku = mysql_fetch_assoc($stat_cek);
										$tklif_cek = mysql_query("SELECT * FROM teklifler WHERE durum=1 and ilan_id = '".$oku->id."' order by teklif_zamani desc limit 1");
										$tklifini_oku = mysql_fetch_assoc($tklif_cek);
										$tklif_sayi = mysql_num_rows($tklif_cek);
										if($stat_oku['durum'] == "0" || $stat_oku['durum'] == "1" || $stat_oku['durum'] == "2" || $stat_oku['durum'] == "3" || $stat_oku['durum'] == "4"){
											$tablo_rengi = "#1b8d3d"; //Koyu yeşil
										}else if($oku->ihale_turu == "1" && $tklifini_oku['uye_id']!='283'){
											if($oku->durum == "-1"){
													$tablo_rengi = "#00a2ff"; //Açık mavi       
											}else{
												$tablo_rengi = "#b4e61d"; //Açık yeşil      
											}
										}else if($oku->ihale_turu== "1" && $tklifini_oku['uye_id']=='283'){
											$tablo_rengi = "#feadc8";  //Toz pembe
										}else {
											if($oku->ihale_turu== "2" && $tklifini_oku['uye_id']=='283'){
												$tablo_rengi = "#ffd0b0";//Krem rengi
											}else{
												$tablo_rengi = "#ffd0b0";//Krem rengi
											}
										}
										
										if($tablo_rengi=="#1b8d3d"){
											$t_color="color:#fff;";
											$color="#fff";
										}else{
											$t_color="";
										}
										$arac_detaylari=$oku->model_yili." ".$marka_adi2." ".$oku->model." ".$oku->tip." <span style='".$color2."' class='".$class."'>".$oku->profil."</span>";
										
										if($oku->link!=""){
											$sgrt_adi='<a style="'.$t_color.'" href="'.$oku->link.'" target="_blank">'.$sigorta_adi.'</a>';
										}else{
											$sgrt_adi='<span style="'.$t_color.'">'.$sigorta_adi.'</span>';
										}
										$td.='
											<tr id="tr_'.$oku->id.'" style="background-color: '.$tablo_rengi.'; '.$t_color.' ">
												<td><input type="checkbox" name="secim[]" class="chec" id="asd'.$oku->id.'" value="'.$oku->id.'" style="opacity:1!important; z-index:999;"></td>
												<td><a target="_blank" href="?modul=ilanlar&sayfa=ilan_ekle&id='.$oku->id.'"><i class="fas fa-edit"></i></a></td>
												<td><a onclick="tabTrigger()" href="?modul=ilanlar&sayfa=ilan_ekle&id='.$oku->id.'" target="_blank"><img style="width: 50px; height:50px;" src="../images/'.$resim.'" alt=""></a></td>
												<td>'.$oku->arac_kodu.'</td>
												<td>'.$oku->plaka.'</td>    
												<td>'.$oku->sehir.'</td>  
												<td style="color:'.$color.';" ><a href="../arac_detay.php?id='.$oku->id.'&q=ihale" style="color:'.$color.';" target="_blank">'.$arac_detaylari.'</a></td>    
												<td id="sayac'.$sira.'">
													<input type="hidden" id="ihale_sayac'.$sira.'" value="'.$tarih_ihale.'" >
													<input type="hidden" id="id_'.$sira.'" value="'.$oku->id.'">
												</td> 
												<td>
													<a style="cursor: pointer;'.$t_color.'" class="view_guncelle kapanis_zamani'.$sira.'" id="'.$oku->id.'">'.$kapanis_zamani.'</a>
												</td>
												<td class="'.$yan.'"><a class="view_uyeye_teklif_ver" style="'.$t_color.'" id="sonteklif_'.$oku->id.'">'.money($oku->son_teklif).'₺</a></td>   
												<!-- <td class="'.$yan.'">'.$oku->son_teklif.'</td>     -->
												<input type="hidden" id="teklif_sayisi'.$sira.'" value="'.$toplam_teklif.'" >
												<td><a style="'.$t_color.'" class="view_ilan_teklifleri" id="teklifler_'.$oku->id.'"><i class="fas fa-gavel">'.$toplam_teklif.'</i></a></td>    
												<td><a style="'.$t_color.'" class="view_ilan_mesajlari" id="mesajlar_'.$oku->id.'"><i class="fas fa-envelope">'.$mesaj_sayi.'</i></a></td>    
												<td><a style="'.$t_color.'" class="view_ilan_favorileri" id="'.$oku->id.'"><i class="fas fa-heart">'.$favori_sayi.'</i></a></td>    
												<td><a style="'.$t_color.'" class="view_ilan_notlari" id="'.$oku->id.'"><i class="fas fa-align-justify">'.$not_sayi.'</i></a></td>    
												<td>'.$sgrt_adi.'</td>
											</tr>
										';
										$sira++;
									}
								}
							}else{
								if(!in_array($filtre_oku['id'],$filtre_array)){
									$tarih_ihale=$filtre_oku['ihale_tarihi'].' '. $filtre_oku['ihale_saati'];
									$kapanis_zamani=date("d-m-Y H:i:s", strtotime($filtre_oku["ihale_tarihi"]. " ". $filtre_oku["ihale_saati"]));
									if($tablo_rengi=="#1b8d3d"){
										$t_color="color:#fff;";
										$color="#fff";
									}else{
										$t_color="";
									}
									$arac_detaylari=$filtre_oku["model_yili"]." ".$marka_adi2." ".$filtre_oku['model']." ".$filtre_oku['tip']." <span style='".$color2."' class='".$class."'>".$filtre_oku['profil']."</span>";
									if($filtre_oku["link"]!=""){
										$sgrt_adi='<a style="'.$t_color.'" href="'.$filtre_oku["link"].'" target="_blank">'.$sigorta_adi.'</a>';
									}else{
										$sgrt_adi='<span style="'.$t_color.'">'.$sigorta_adi.'</span>';
									}	
									$td.='
										<tr id="tr_'.$filtre_oku["id"].'" style="background-color: '.$tablo_rengi.';'.$t_color.'  ">
											<td><input type="checkbox" name="secim[]" class="chec" id="asd'.$gelen_id.'" value="'.$gelen_id.'" style="opacity:1!important; z-index:999;"></td>
											<td><a target="_blank" href="?modul=ilanlar&sayfa=ilan_ekle&id='.$gelen_id.'"><i class="fas fa-edit"></i></a></td>
											<td><a onclick="tabTrigger()" href="?modul=ilanlar&sayfa=ilan_ekle&id='.$gelen_id.'" target="_blank"><img style="width: 50px; height:50px;" src="../images/'.$resim.'" alt=""></a></td>
											<td>'.$filtre_oku["arac_kodu"].'</td>
											<td>'.$filtre_oku["plaka"].'</td>    
											<td>'.$filtre_oku['sehir'].'</td>  
											<td style="color:'.$color.';"><a href="../arac_detay.php?id='.$gelen_id.'&q=ihale" style="color:'.$color.';"  target="_blank">'.$arac_detaylari.'</a></td>    
											<td id="sayac'.$sira.'">
												<input type="hidden" id="ihale_sayac'.$sira.'" value="'.$tarih_ihale.'" >
												<input type="hidden" id="id_'.$sira.'" value="'.$filtre_oku['id'].'">
											</td> 
											<td>
												<a style="cursor: pointer;'.$t_color.'" class="view_guncelle kapanis_zamani'.$sira.'" id="'.$filtre_oku['id'].'">'.$kapanis_zamani.'</a>
											</td>
											<td class="'.$yan.'"><a style="'.$t_color.'" class="view_uyeye_teklif_ver" id="sonteklif_'.$filtre_oku['id'].'">'.money($filtre_oku["son_teklif"]).'₺</a></td>   
											<!-- <td class="'.$yan.'">'.$filtre_oku["son_teklif"].'</td>     -->
											<input type="hidden" id="teklif_sayisi'.$sira.'" value="'.$toplam_teklif.'" >
											<td><a style="'.$t_color.'" class="view_ilan_teklifleri" id="teklifler_'.$filtre_oku['id'].'"><i class="fas fa-gavel">'.$toplam_teklif.'</i></a></td>    
											<td><a style="'.$t_color.'" class="view_ilan_mesajlari" id="mesajlar_'.$filtre_oku['id'].'"><i class="fas fa-envelope">'.$mesaj_sayi.'</i></a></td>    
											<td><a style="'.$t_color.'" class="view_ilan_favorileri" id="'.$filtre_oku['id'].'"><i class="fas fa-heart">'.$favori_sayi.'</i></a></td>    
											<td><a style="'.$t_color.'" class="view_ilan_notlari" id="'.$filtre_oku['id'].'"><i class="fas fa-align-justify">'.$not_sayi.'</i></a></td>    
											<td>'.$sgrt_adi.'</td>
										</tr>
									';
									$sira++;
								}
								
							}
						}else {
							if($filtre_oku['ihale_turu']== "2" && $teklifini_oku['uye_id']=='283'){
								
								$krem_array=array();
								$tablo_rengi = "#ffd0b0";//Krem rengi
								$ihale_trh=$filtre_oku["ihale_tarihi"];
								$ihale_st=$filtre_oku["ihale_saati"];
								$srgl=mysql_query("select ilanlar.* from ilanlar inner join teklifler on teklifler.ilan_id=ilanlar.id  where ilanlar.id = '".$filtre_oku["id"]."' and ilanlar.durum=1 and ilanlar.ihale_tarihi='".$ihale_trh."' and ilanlar.ihale_saati='".$ihale_st."' and teklifler.durum=1 group by ilanlar.id");							//
								if(mysql_num_rows($srgl)>0){
									while($oku=mysql_fetch_object($srgl)){
										if(!in_array($oku->id,$krem_array)){
											array_push($krem_array,$oku->id);

											$tarih_ihale=$oku->ihale_tarihi.' '. $oku->ihale_saati;
											$kapanis_zamani=date("d-m-Y H:i:s", strtotime($oku->ihale_tarihi. " ". $oku->ihale_saati));
											$teklifler=mysql_query("select * from teklifler where ilan_id='".$oku->id."' and durum=1 order by teklif_zamani desc ");
											$toplam_teklif = mysql_num_rows($teklifler);
											
											
											$mesaj_cek = mysql_query("SELECT * FROM mesajlar WHERE ilan_id = '".$oku->id."' ");
											$mesaj_sayi = mysql_num_rows($mesaj_cek);
											$favori_cek = mysql_query("SELECT * FROM favoriler WHERE ilan_id = '".$oku->id."'");
											$favori_sayi = mysql_num_rows($favori_cek);
											$not_cek = mysql_query("SELECT * FROM ilan_notlari WHERE ilan_id = '".$oku->id."' group by tarih order by id desc");
											$not_sayi = mysql_num_rows($not_cek);

											$sigorta_cek = mysql_query("SELECT * FROM sigorta_ozellikleri WHERE id = '".$oku->sigorta."'");
											$sigorta_oku = mysql_fetch_assoc($sigorta_cek);
											$sigorta_adi = $sigorta_oku['sigorta_adi'];

											$style = '';
											$class  = '';
											if($oku->profil=="Hurda Belgeli"){
												$class = "blink" ;
												$color2 = "color:red;";
											}elseif($oku->profil=="Plakalı"){         
												$color2 = "color:green;font-weight:bold";            
											}elseif($oku->profil == "Çekme Belgeli/Pert Kayıtlı"){
												$color2 = "color:#000000";
											}else {
												$color2 = "color:#000000";
											}
											
											$resim_cek = mysql_query("select * from ilan_resimler where ilan_id = '".$oku->id."'");
											$resim_oku = mysql_fetch_assoc($resim_cek);
											$resim = $resim_oku['resim'];
											if($resim==""){
												$resim="default.png";
											}
											$stat_cek = mysql_query("SELECT * FROM kazanilan_ilanlar WHERE ilan_id = '".$oku->id."'");
											$stat_oku = mysql_fetch_assoc($stat_cek);
											$tklif_cek = mysql_query("SELECT * FROM teklifler WHERE durum=1 and ilan_id = '".$oku->id."' order by teklif_zamani desc limit 1");
											$tklifini_oku = mysql_fetch_assoc($tklif_cek);
											$tklif_sayi = mysql_num_rows($tklif_cek);
											if($stat_oku['durum'] == "0" || $stat_oku['durum'] == "1" || $stat_oku['durum'] == "2" || $stat_oku['durum'] == "3" || $stat_oku['durum'] == "4"){
												$tablo_rengi = "#1b8d3d"; //Koyu yeşil
											}else if($oku->ihale_turu == "1" && $tklifini_oku['uye_id']!='283'){
												if($oku->durum == "-1"){
														$tablo_rengi = "#00a2ff"; //Açık mavi       
												}else{
													$tablo_rengi = "#b4e61d"; //Açık yeşil      
												}
											}else if($oku->ihale_turu== "1" && $tklifini_oku['uye_id']=='283'){
												$tablo_rengi = "#feadc8";  //Toz pembe
											}else {
												if($oku->ihale_turu== "2" && $tklifini_oku['uye_id']=='283'){
													$tablo_rengi = "#ffd0b0";//Krem rengi
												}else{
													$tablo_rengi = "#ffd0b0";//Krem rengi
												}
											}
											
											if($tablo_rengi=="#1b8d3d"){
												$t_color="color:#fff;";
												$color="#fff";
											}else{
												$t_color="";
											}
											$arac_detaylari=$oku->model_yili." ".$marka_adi2." ".$oku->model." ".$oku->tip." <span style='".$color2."' class='".$class."'>".$oku->profil."</span>";
											if($oku->link!=""){
												$sgrt_adi='<a style="'.$t_color.'" href="'.$oku->link.'" target="_blank">'.$sigorta_adi.'</a>';
											}else{
												$sgrt_adi='<span style="'.$t_color.'">'.$sigorta_adi.'</span>';
											}
											$td.='
												<tr id="tr_'.$oku->id.'" style="background-color: '.$tablo_rengi.'; '.$t_color.' ">
													<td><input type="checkbox" name="secim[]" class="chec" id="asd'.$oku->id.'" value="'.$oku->id.'" style="opacity:1!important; z-index:999;"></td>
													<td><a target="_blank" href="?modul=ilanlar&sayfa=ilan_ekle&id='.$oku->id.'"><i class="fas fa-edit"></i></a></td>
													<td><a onclick="tabTrigger()" href="?modul=ilanlar&sayfa=ilan_ekle&id='.$oku->id.'" target="_blank"><img style="width: 50px; height:50px;" src="../images/'.$resim.'" alt=""></a></td>
													<td>'.$oku->arac_kodu.'</td>
													<td>'.$oku->plaka.'</td>    
													<td>'.$oku->sehir.'</td>   
													<td style="color:'.$color.';" ><a href="../arac_detay.php?id='.$oku->id.'&q=ihale" style="color:'.$color.';" target="_blank">'.$arac_detaylari.'</a></td>    
													<td id="sayac'.$sira.'">
														<input type="hidden" id="ihale_sayac'.$sira.'" value="'.$tarih_ihale.'" >
														<input type="hidden" id="id_'.$sira.'" value="'.$oku->id.'">
													</td> 
													<td>
														<a style="cursor: pointer;'.$t_color.'" class="view_guncelle kapanis_zamani'.$sira.'" id="'.$oku->id.'">'.$kapanis_zamani.'</a>
													</td>
													<td class="'.$yan.'"><a class="view_uyeye_teklif_ver" style="'.$t_color.'" id="sonteklif_'.$oku->id.'">'.money($oku->son_teklif).'₺</a></td>   
													<!-- <td class="'.$yan.'">'.$oku->son_teklif.'</td>     -->
													<input type="hidden" id="teklif_sayisi'.$sira.'" value="'.$toplam_teklif.'" >
													<td><a style="'.$t_color.'" class="view_ilan_teklifleri" id="teklifler_'.$oku->id.'"><i class="fas fa-gavel">'.$toplam_teklif.'</i></a></td>    
													<td><a style="'.$t_color.'" class="view_ilan_mesajlari" id="mesajlar_'.$oku->id.'"><i class="fas fa-envelope">'.$mesaj_sayi.'</i></a></td>    
													<td><a style="'.$t_color.'" class="view_ilan_favorileri" id="'.$oku->id.'"><i class="fas fa-heart">'.$favori_sayi.'</i></a></td>    
													<td><a style="'.$t_color.'" class="view_ilan_notlari" id="'.$oku->id.'"><i class="fas fa-align-justify">'.$not_sayi.'</i></a></td>    
													<td>'.$sgrt_adi.'</td>
												</tr>
											';
											$sira++;
										}
									}
								}else{
									if(!in_array($filtre_oku['id'],$krem_array)){
										$tarih_ihale=$filtre_oku['ihale_tarihi'].' '. $filtre_oku['ihale_saati'];
										$kapanis_zamani=date("d-m-Y H:i:s", strtotime($filtre_oku["ihale_tarihi"]. " ". $filtre_oku["ihale_saati"]));
										if($tablo_rengi=="#1b8d3d"){
											$t_color="color:#fff;";
											$color="#fff";
										}else{
											$t_color="";
										}
										$arac_detaylari=$filtre_oku["model_yili"]." ".$marka_adi2." ".$filtre_oku['model']." ".$filtre_oku['tip']." <span style='".$color2."' class='".$class."'>".$filtre_oku['profil']."</span>";
										if($filtre_oku["link"]!=""){
											$sgrt_adi='<a style="'.$t_color.'" href="'.$filtre_oku["link"].'" target="_blank">'.$sigorta_adi.'</a>';
										}else{
											$sgrt_adi='<span style="'.$t_color.'">'.$sigorta_adi.'</span>';
										}
										$td.='
											<tr id="tr_'.$filtre_oku["id"].'" style="background-color: '.$tablo_rengi.';'.$t_color.'  ">
												<td><input type="checkbox" name="secim[]" class="chec" id="asd'.$gelen_id.'" value="'.$gelen_id.'" style="opacity:1!important; z-index:999;"></td>
												<td><a target="_blank" href="?modul=ilanlar&sayfa=ilan_ekle&id='.$gelen_id.'"><i class="fas fa-edit"></i></a></td>
												<td><a onclick="tabTrigger()" href="?modul=ilanlar&sayfa=ilan_ekle&id='.$gelen_id.'" target="_blank"><img style="width: 50px; height:50px;" src="../images/'.$resim.'" alt=""></a></td>
												<td>'.$filtre_oku["arac_kodu"].'</td>
												<td>'.$filtre_oku["plaka"].'</td>    
												<td>'.$filtre_oku['sehir'].'</td>  
												<td style="color:'.$color.';"><a href="../arac_detay.php?id='.$gelen_id.'&q=ihale" style="color:'.$color.';"  target="_blank">'.$arac_detaylari.'</a></td>    
												<td id="sayac'.$sira.'">
													<input type="hidden" id="ihale_sayac'.$sira.'" value="'.$tarih_ihale.'" >
													<input type="hidden" id="id_'.$sira.'" value="'.$filtre_oku['id'].'">
												</td> 
												<td>
													<a style="cursor: pointer;'.$t_color.'" class="view_guncelle kapanis_zamani'.$sira.'" id="'.$filtre_oku['id'].'">'.$kapanis_zamani.'</a>
												</td>
												<td class="'.$yan.'"><a style="'.$t_color.'" class="view_uyeye_teklif_ver" id="sonteklif_'.$filtre_oku['id'].'">'.money($filtre_oku["son_teklif"]).'₺</a></td>   
												<!-- <td class="'.$yan.'">'.$filtre_oku["son_teklif"].'</td>     -->
												<input type="hidden" id="teklif_sayisi'.$sira.'" value="'.$toplam_teklif.'" >
												<td><a style="'.$t_color.'" class="view_ilan_teklifleri" id="teklifler_'.$filtre_oku['id'].'"><i class="fas fa-gavel">'.$toplam_teklif.'</i></a></td>    
												<td><a style="'.$t_color.'" class="view_ilan_mesajlari" id="mesajlar_'.$filtre_oku['id'].'"><i class="fas fa-envelope">'.$mesaj_sayi.'</i></a></td>    
												<td><a style="'.$t_color.'" class="view_ilan_favorileri" id="'.$filtre_oku['id'].'"><i class="fas fa-heart">'.$favori_sayi.'</i></a></td>    
												<td><a style="'.$t_color.'" class="view_ilan_notlari" id="'.$filtre_oku['id'].'"><i class="fas fa-align-justify">'.$not_sayi.'</i></a></td>    
												<td>'.$sgrt_adi.'</td>
											</tr>
										';
										$sira++;
									}
									
								}
								
							}else{
								$tablo_rengi = "#ffd0b0";//Krem rengi
								$ihale_trh=$filtre_oku["ihale_tarihi"];
								$ihale_st=$filtre_oku["ihale_saati"];
								$srgl=mysql_query("select ilanlar.* from ilanlar inner join teklifler on teklifler.ilan_id=ilanlar.id  where ilanlar.id = '".$filtre_oku["id"]."' and ilanlar.durum=1 and ilanlar.ihale_tarihi='".$ihale_trh."' and ilanlar.ihale_saati='".$ihale_st."' and teklifler.durum=1 group by ilanlar.id");							//
								if(mysql_num_rows($srgl)>0){
									while($oku=mysql_fetch_object($srgl)){
										if(!in_array($oku->id,$filtre_array)){
											array_push($filtre_array,$oku->id);

											$tarih_ihale=$oku->ihale_tarihi.' '. $oku->ihale_saati;
											$kapanis_zamani=date("d-m-Y H:i:s", strtotime($oku->ihale_tarihi. " ". $oku->ihale_saati));
											

											
											$teklifler=mysql_query("select * from teklifler where ilan_id='".$oku->id."' and durum=1 order by teklif_zamani desc ");
											$toplam_teklif = mysql_num_rows($teklifler);
											
											
											$mesaj_cek = mysql_query("SELECT * FROM mesajlar WHERE ilan_id = '".$oku->id."' ");
											$mesaj_sayi = mysql_num_rows($mesaj_cek);
											$favori_cek = mysql_query("SELECT * FROM favoriler WHERE ilan_id = '".$oku->id."'");
											$favori_sayi = mysql_num_rows($favori_cek);
											$not_cek = mysql_query("SELECT * FROM ilan_notlari WHERE ilan_id = '".$oku->id."' group by tarih order by id desc");
											$not_sayi = mysql_num_rows($not_cek);


											$sigorta_cek = mysql_query("SELECT * FROM sigorta_ozellikleri WHERE id = '".$oku->sigorta."'");
											$sigorta_oku = mysql_fetch_assoc($sigorta_cek);
											$sigorta_adi = $sigorta_oku['sigorta_adi'];

											$style = '';
											$class  = '';
											if($oku->profil=="Hurda Belgeli"){
												$class = "blink" ;
												$color2 = "color:red;";
											}elseif($oku->profil=="Plakalı"){         
												$color2 = "color:green;font-weight:bold";            
											}elseif($oku->profil == "Çekme Belgeli/Pert Kayıtlı"){
												$color2 = "color:#000000";
											}else{
												$color2 = "color:#000000";
											}
											
											$resim_cek = mysql_query("select * from ilan_resimler where ilan_id = '".$oku->id."'");
											$resim_oku = mysql_fetch_assoc($resim_cek);
											$resim = $resim_oku['resim'];
											if($resim==""){
												$resim="default.png";
											}
											$stat_cek = mysql_query("SELECT * FROM kazanilan_ilanlar WHERE ilan_id = '".$oku->id."'");
											$stat_oku = mysql_fetch_assoc($stat_cek);
											$tklif_cek = mysql_query("SELECT * FROM teklifler WHERE durum=1 and ilan_id = '".$oku->id."' order by teklif_zamani desc limit 1");
											$tklifini_oku = mysql_fetch_assoc($tklif_cek);
											$tklif_sayi = mysql_num_rows($tklif_cek);
											if($stat_oku['durum'] == "0" || $stat_oku['durum'] == "1" || $stat_oku['durum'] == "2" || $stat_oku['durum'] == "3" || $stat_oku['durum'] == "4"){
												$tablo_rengi = "#1b8d3d"; //Koyu yeşil
											}else if($oku->ihale_turu == "1" && $tklifini_oku['uye_id']!='283'){
												if($oku->durum == "-1"){
														$tablo_rengi = "#00a2ff"; //Açık mavi       
												}else{
													$tablo_rengi = "#b4e61d"; //Açık yeşil      
												}
											}else if($oku->ihale_turu== "1" && $tklifini_oku['uye_id']=='283'){
												$tablo_rengi = "#feadc8";  //Toz pembe
											}else {
												if($oku->ihale_turu== "2" && $tklifini_oku['uye_id']=='283'){
													$tablo_rengi = "#ffd0b0";//Krem rengi
												}else{
													$tablo_rengi = "#ffd0b0";//Krem rengi
												}
											}
											
											
											if($tablo_rengi=="#1b8d3d"){
												$t_color="color:#fff;";
												$color="#fff";
											}else{
												$t_color="";
											}
											$arac_detaylari=$oku->model_yili." ".$marka_adi2." ".$oku->model." ".$oku->tip." <span style='".$color2."' class='".$class."'>".$oku->profil."</span>";
											if($oku->link!=""){
												$sgrt_adi='<a style="'.$t_color.'" href="'.$oku->link.'" target="_blank">'.$sigorta_adi.'</a>';
											}else{
												$sgrt_adi='<span style="'.$t_color.'">'.$sigorta_adi.'</span>';
											}
											$td.='
												<tr id="tr_'.$oku->id.'" style="background-color: '.$tablo_rengi.'; '.$t_color.' ">
													<td><input type="checkbox" name="secim[]" class="chec" id="asd'.$oku->id.'" value="'.$oku->id.'" style="opacity:1!important; z-index:999;"></td>
													<td><a target="_blank" href="?modul=ilanlar&sayfa=ilan_ekle&id='.$oku->id.'"><i class="fas fa-edit"></i></a></td>
													<td><a onclick="tabTrigger()" href="?modul=ilanlar&sayfa=ilan_ekle&id='.$oku->id.'" target="_blank"><img style="width: 50px; height:50px;" src="../images/'.$resim.'" alt=""></a></td>
													<td>'.$oku->arac_kodu.'</td>
													<td>'.$oku->plaka.'</td>    
													<td>'.$oku->sehir.'</td>  
													<td style="color:'.$color.';" ><a href="../arac_detay.php?id='.$oku->id.'&q=ihale" style="color:'.$color.';" target="_blank">'.$arac_detaylari.'</a></td>    
													<td id="sayac'.$sira.'">
														<input type="hidden" id="ihale_sayac'.$sira.'" value="'.$tarih_ihale.'" >
														<input type="hidden" id="id_'.$sira.'" value="'.$oku->id.'">
													</td> 
													<td>
														<a style="cursor: pointer;'.$t_color.'" class="view_guncelle kapanis_zamani'.$sira.'" id="'.$oku->id.'">'.$kapanis_zamani.'</a>
													</td>
													<td class="'.$yan.'"><a class="view_uyeye_teklif_ver" style="'.$t_color.'" id="sonteklif_'.$oku->id.'">'.money($oku->son_teklif).'₺</a></td>   
													<!-- <td class="'.$yan.'">'.$oku->son_teklif.'</td>     -->
													<input type="hidden" id="teklif_sayisi'.$sira.'" value="'.$toplam_teklif.'" >
													<td><a style="'.$t_color.'" class="view_ilan_teklifleri" id="teklifler_'.$oku->id.'"><i class="fas fa-gavel">'.$toplam_teklif.'</i></a></td>    
													<td><a style="'.$t_color.'" class="view_ilan_mesajlari" id="mesajlar_'.$oku->id.'"><i class="fas fa-envelope">'.$mesaj_sayi.'</i></a></td>    
													<td><a style="'.$t_color.'" class="view_ilan_favorileri" id="'.$oku->id.'"><i class="fas fa-heart">'.$favori_sayi.'</i></a></td>    
													<td><a style="'.$t_color.'" class="view_ilan_notlari" id="'.$oku->id.'"><i class="fas fa-align-justify">'.$not_sayi.'</i></a></td>    
													<td>'.$sgrt_adi.'</td>
												</tr>
											';
											$sira++;
										}
									}
								}else{
									if(!in_array($filtre_oku['id'],$filtre_array)){
										$tarih_ihale=$filtre_oku['ihale_tarihi'].' '. $filtre_oku['ihale_saati'];
										$kapanis_zamani=date("d-m-Y H:i:s", strtotime($filtre_oku["ihale_tarihi"]. " ". $filtre_oku["ihale_saati"]));
										if($tablo_rengi=="#1b8d3d"){
											$t_color="color:#fff;";
											$color="#fff";
										}else{
											$t_color="";
										}
										if($filtre_oku["link"]!=""){
											$sgrt_adi='<a style="'.$t_color.'" href="'.$filtre_oku["link"].'" target="_blank">'.$sigorta_adi.'</a>';
										}else{
											$sgrt_adi='<span style="'.$t_color.'">'.$sigorta_adi.'</span>';
										}
										$arac_detaylari=$filtre_oku["model_yili"]." ".$marka_adi2." ".$filtre_oku['model']." ".$filtre_oku['tip']." <span style='".$color2."' class='".$class."'>".$filtre_oku['profil']."</span>";
										$td.='
											<tr id="tr_'.$filtre_oku["id"].'" style="background-color: '.$tablo_rengi.';'.$t_color.'  ">
												<td><input type="checkbox" name="secim[]" class="chec" id="asd'.$gelen_id.'" value="'.$gelen_id.'" style="opacity:1!important; z-index:999;"></td>
												<td><a target="_blank" href="?modul=ilanlar&sayfa=ilan_ekle&id='.$gelen_id.'"><i class="fas fa-edit"></i></a></td>
												<td><a onclick="tabTrigger()" href="?modul=ilanlar&sayfa=ilan_ekle&id='.$gelen_id.'" target="_blank"><img style="width: 50px; height:50px;" src="../images/'.$resim.'" alt=""></a></td>
												<td>'.$filtre_oku["arac_kodu"].'</td>
												<td>'.$filtre_oku["plaka"].'</td>    
												<td>'.$filtre_oku['sehir'].'</td>  
												<td style="color:'.$color.';" ><a href="../arac_detay.php?id='.$gelen_id.'&q=ihale" style="color:'.$color.';"  target="_blank">'.$arac_detaylari.'</a></td>    
												<td id="sayac'.$sira.'">
													<input type="hidden" id="ihale_sayac'.$sira.'" value="'.$tarih_ihale.'" >
													<input type="hidden" id="id_'.$sira.'" value="'.$filtre_oku['id'].'">
												</td> 
												<td>
													<a style="cursor: pointer;'.$t_color.'" class="view_guncelle kapanis_zamani'.$sira.'" id="'.$filtre_oku['id'].'">'.$kapanis_zamani.'</a>
												</td>
												<td class="'.$yan.'"><a style="'.$t_color.'" class="view_uyeye_teklif_ver" id="sonteklif_'.$filtre_oku['id'].'">'.money($filtre_oku["son_teklif"]).'₺</a></td>   
												<!-- <td class="'.$yan.'">'.$filtre_oku["son_teklif"].'</td>     -->
												<input type="hidden" id="teklif_sayisi'.$sira.'" value="'.$toplam_teklif.'" >
												<td><a style="'.$t_color.'" class="view_ilan_teklifleri" id="teklifler_'.$filtre_oku['id'].'"><i class="fas fa-gavel">'.$toplam_teklif.'</i></a></td>    
												<td><a style="'.$t_color.'" class="view_ilan_mesajlari" id="mesajlar_'.$filtre_oku['id'].'"><i class="fas fa-envelope">'.$mesaj_sayi.'</i></a></td>    
												<td><a style="'.$t_color.'" class="view_ilan_favorileri" id="'.$filtre_oku['id'].'"><i class="fas fa-heart">'.$favori_sayi.'</i></a></td>    
												<td><a style="'.$t_color.'" class="view_ilan_notlari" id="'.$filtre_oku['id'].'"><i class="fas fa-align-justify">'.$not_sayi.'</i></a></td>    
												<td>'.$sgrt_adi.'</td>
											</tr>
										';
										$sira++;
									}	
								}
							}
						}
					}else{
						$tablo_rengi = "#fff";
						$arac_detaylari=$filtre_oku["model_yili"]." ".$marka_adi2." ".$filtre_oku['model']." ".$filtre_oku['tip']." <span style='".$color2."' class='".$class."'>".$filtre_oku['profil']."</span>";
						$tarih_ihale=$filtre_oku['ihale_tarihi'].' '. $filtre_oku['ihale_saati'];
						$kapanis_zamani=date("d-m-Y H:i:s", strtotime($filtre_oku["ihale_tarihi"]. " ". $filtre_oku["ihale_saati"]));
						if($filtre_oku["link"]!=""){
							$sgrt_adi='<a style="'.$t_color.'" href="'.$filtre_oku["link"].'" target="_blank">'.$sigorta_adi.'</a>';
						}else{
							$sgrt_adi='<span style="'.$t_color.'">'.$sigorta_adi.'</span>';
						}
						$td.='
							<tr id="tr_'.$filtre_oku["id"].'" style="background-color: '.$tablo_rengi.'; ">
								<td><input type="checkbox" name="secim[]" class="chec" id="asd'.$gelen_id.'" value="'.$gelen_id.'" style="opacity:1!important; z-index:999;"></td>
								<td><a target="_blank" href="?modul=ilanlar&sayfa=ilan_ekle&id='.$gelen_id.'"><i class="fas fa-edit"></i></a></td>
								<td><a onclick="tabTrigger()" href="?modul=ilanlar&sayfa=ilan_ekle&id='.$gelen_id.'" target="_blank"><img style="width: 50px; height:50px;" src="../images/'.$resim.'" alt=""></a></td>
								<td>'.$filtre_oku["arac_kodu"].'</td>
								<td>'.$filtre_oku["plaka"].'</td>    
								<td>'.$filtre_oku['sehir'].'</td>  
								<td style="color:'.$color.';" ><a href="../arac_detay.php?id='.$gelen_id.'&q=ihale" style="color:'.$color.';"  target="_blank">'.$arac_detaylari.'</a></td>    
								<td id="sayac'.$sira.'">
									<input type="hidden" id="ihale_sayac'.$sira.'" value="'.$tarih_ihale.'" >
									<input type="hidden" id="id_'.$sira.'" value="'.$filtre_oku['id'].'">
								</td> 
								<td>
									<a style="cursor: pointer;" class="view_guncelle kapanis_zamani'.$sira.'" id="'.$filtre_oku['id'].'">'.$kapanis_zamani.'</a>
								</td>
								<td class="'.$yan.'"><a class="view_uyeye_teklif_ver" id="sonteklif_'.$filtre_oku['id'].'">'.money($filtre_oku["son_teklif"]).'₺</a></td>   
								<!-- <td class="'.$yan.'">'.$filtre_oku["son_teklif"].'</td>     -->
								<input type="hidden" id="teklif_sayisi'.$sira.'" value="'.$toplam_teklif.'" >
								<td><a class="view_ilan_teklifleri" id="teklifler_'.$filtre_oku['id'].'"><i class="fas fa-gavel">'.$toplam_teklif.'</i></a></td>    
								<td><a class="view_ilan_mesajlari" id="mesajlar_'.$filtre_oku['id'].'"><i class="fas fa-envelope">'.$mesaj_sayi.'</i></a></td>    
								<td><a class="view_ilan_favorileri" id="'.$filtre_oku['id'].'"><i class="fas fa-heart">'.$favori_sayi.'</i></a></td>    
								<td><a class="view_ilan_notlari" id="'.$filtre_oku['id'].'"><i class="fas fa-align-justify">'.$not_sayi.'</i></a></td>    
								<td>'.$sgrt_adi.'</td>
							</tr>
						';
						$sira++;
					}
					
				?>
				<?php   }	
					} 
				?>
				<tbody><?= $td ?></tbody>
			</table>
		</div>
	</form>
     

	<?php  }else{ ?>
  
	<form method="POST" action="?modul=ihaleler&sayfa=toplu_sil" onsubmit="return confirm('SEÇİLİ İLANLARI SİLMEK İSTEDİĞİNİZE EMİN MİSİNİ?');" >
		<?php
			$admin_yetki_cek=mysql_query("Select * from kullanicilar where id='".$admin_id."' ");
			$admin_yetki_oku=mysql_fetch_assoc($admin_yetki_cek);
			$yetkiler=$admin_yetki_oku["yetki"];
			$yetki_parcala=explode("|",$yetkiler);

			$btn='';
			$btn2='';
			if (in_array(2, $yetki_parcala) && in_array(1, $yetki_parcala) ) { 
			  $btn='<input type="submit" name="secili_sil" class="btn-danger" value="Seçili Olanları Sil">';
			  $btn2='<input type="submit" name="secili_uzat" class="btn-primary" value="Seçili Olanların Süresini Uzat">';
			}  else if(in_array(2, $yetki_parcala) && !in_array(1, $yetki_parcala)){
				$btn='<input type="submit" name="secili_sil" class="btn-danger" value="Seçili Olanları Sil">';
			    $btn2='';
			} else if(!in_array(2, $yetki_parcala) && in_array(1, $yetki_parcala)){
				$btn='';
			    $btn2='<input type="submit" name="secili_uzat" class="btn-primary" value="Seçili Olanların Süresini Uzat">';
			}   else{
				$btn='';
			    $btn2='';
			}
		?>    

		<style>
			a.disabled {
				pointer-events: none;
				cursor: default;
			}
		</style>  
		
		<a><? echo $btn ?></a>
		<a><? echo $btn2 ?></a>
		<!--<button type="button" id="checkle" class="checkall btn btn-blue">Tümünü Seç</button>-->
    
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

		<div style="overflow-x:auto; margin-top:4%;">
			<table id="mesajlar_ilan_table" class="table table-bordered" cellspacing="1" cellpadding="1">
				<thead>
				<tr>
					<td><input type="checkbox" id="checkle" class="checkall btn btn-blue chec2" style="padding:20px;opacity:1!important; z-index:999;">Tümünü Seç</td>
					<td>Düzenle</td>
					<td>Görseller</td>
					<td>Kod</td>
					<td>Plaka</td>
					<td>İl Adı</td>
					<td>Detaylar</td>
					<td>Sayaç</td>
					<td>Kapanış Zamanı</td>
					<td>En Yüksek</td>
					<td>Teklifleri İncele</td>
					<td>Mesaj</td>
					<td>Favori</td>
					<td>Notlar</td>
					<td>Sigorta</td>
				</tr>
				</thead>
				<?php $sira=0; $ihale_say=mysql_num_rows($hepsini_cek);?>
					<input type="hidden" id="ihale_say" value="<?=$ihale_say ?>" />	
					<?php 
					
					$acik_mavi_array=array();
					$koyu_yesil_array=array();
					$acik_yesil_array=array();
					$toz_pembe_array=array();
					$krem_array=array(); 
					$hepsi_array=array();
					while($hepsini_oku = mysql_fetch_array($hepsini_cek)){
						$tablo_rengi="";
						$teklif_cek = mysql_query("SELECT * FROM teklifler WHERE ilan_id = '".$hepsini_oku['id']."' and durum=1 order by teklif_zamani desc limit 1");
						$teklifini_oku = mysql_fetch_assoc($teklif_cek);
						$teklifler=mysql_query("select * from teklifler where ilan_id='".$hepsini_oku['id']."' and durum=1 order by teklif_zamani desc ");
						$toplam_teklif = mysql_num_rows($teklifler);
						
						$mesaj_cek = mysql_query("SELECT * FROM mesajlar WHERE ilan_id = '".$hepsini_oku['id']."' ");
						$mesaj_sayi = mysql_num_rows($mesaj_cek);
						$favori_cek = mysql_query("SELECT * FROM favoriler WHERE ilan_id = '".$hepsini_oku['id']."'");
						$favori_sayi = mysql_num_rows($favori_cek);
						$not_cek = mysql_query("SELECT * FROM ilan_notlari WHERE ilan_id = '".$hepsini_oku['id']."' group by tarih order by id desc");
						$not_sayi = mysql_num_rows($not_cek);
						$resim_cek = mysql_query("select * from ilan_resimler where ilan_id = '".$hepsini_oku['id']."'");
						$resim_oku = mysql_fetch_assoc($resim_cek);
						$resim = $resim_oku['resim'];
						if($resim==""){
							$resim="default.png";
						}
						$sigorta_cek = mysql_query("SELECT * FROM sigorta_ozellikleri WHERE id = '".$hepsini_oku['sigorta']."'");
						$sigorta_oku = mysql_fetch_assoc($sigorta_cek);
						$sigorta_adi = $sigorta_oku['sigorta_adi'];
				
						$suan = date('Y-m-d H:i:s');
						$newTime = date("Y-m-d H:i:s",strtotime(date("Y-m-d H:i:s")." -2 minutes"));
						$zaman_ilan = $hepsini_oku['ihale_tarihi']." ".$hepsini_oku['ihale_saati'];
						$yan = "";
						if($suan > $zaman_ilan){
							$yan = "yan";
						}
						$gelen_id = $hepsini_oku["id"];
						$marka_getir = mysql_query("select * from marka where markaID = '".$hepsini_oku['marka']."'");
						$marka_gel = mysql_fetch_assoc($marka_getir);
						$marka_adi = $marka_gel['marka_adi'];
						$style = '';
						$class  = '';
						if($hepsini_oku['profil']=="Hurda Belgeli"){
							$class = "blink" ;
							$color2 = "red !important";
						}elseif($hepsini_oku['profil']=="Plakalı"){         
							$color2 = "color:green;font-weight:bold";            
						}elseif($hepsini_oku['profil'] == "Çekme Belgeli/Pert Kayıtlı"){
							$color2 = "color:#000000";
						}else{
							$color2 = "color:#000000";
						}
						$statu_cek = mysql_query("SELECT * FROM kazanilan_ilanlar WHERE ilan_id = '".$gelen_id."'");
						$statu_oku = mysql_fetch_assoc($statu_cek);
						$teklifi_cek = mysql_query("SELECT * FROM teklifler WHERE durum=1 and ilan_id = '".$gelen_id."'");
						
						$teklifi_oku = mysql_fetch_assoc($teklifi_cek);
						$teklif_durum = $teklifi_oku['admin_teklif'];
						$teklif_fiyat = $teklifi_oku['teklif'];

						if($toplam_teklif>0){
							if($statu_oku['durum'] == "0" || $statu_oku['durum'] == "1" || $statu_oku['durum'] == "2" || $statu_oku['durum'] == "3" || $statu_oku['durum'] == "4"){
								
								$tablo_rengi = "#1b8d3d"; //Koyu yeşil
								$ihale_trh=$hepsini_oku["ihale_tarihi"];
								$ihale_st=$hepsini_oku["ihale_saati"];
								$srgl=mysql_query("select ilanlar.* from ilanlar inner join teklifler on teklifler.ilan_id=ilanlar.id where ilanlar.id = '".$hepsini_oku["id"]."' and ilanlar.durum=1 and ilanlar.ihale_tarihi='".$ihale_trh."' and ilanlar.ihale_saati='".$ihale_st."' and teklifler.durum=1 group by ilanlar.id");							//
								if(mysql_num_rows($srgl)>0){
									while($oku=mysql_fetch_object($srgl)){
										if(!in_array($oku->id,$hepsi_array)){
											array_push($hepsi_array,$oku->id);
										
											$tarih_ihale=$oku->ihale_tarihi.' '. $oku->ihale_saati;
											$kapanis_zamani=date("d-m-Y H:i:s", strtotime($oku->ihale_tarihi. " ". $oku->ihale_saati));
											
											
											$teklifler=mysql_query("select * from teklifler where ilan_id='".$oku->id."' and durum=1 order by teklif_zamani desc ");
											$toplam_teklif = mysql_num_rows($teklifler);
											
											
											$mesaj_cek = mysql_query("SELECT * FROM mesajlar WHERE ilan_id = '".$oku->id."' ");
											$mesaj_sayi = mysql_num_rows($mesaj_cek);
											
											$favori_cek = mysql_query("SELECT * FROM favoriler WHERE ilan_id = '".$oku->id."'");
											$favori_sayi = mysql_num_rows($favori_cek);
											$not_cek = mysql_query("SELECT * FROM ilan_notlari WHERE ilan_id = '".$oku->id."' group by tarih order by id desc");
											$not_sayi = mysql_num_rows($not_cek);


											$sigorta_cek = mysql_query("SELECT * FROM sigorta_ozellikleri WHERE id = '".$oku->sigorta."'");
											$sigorta_oku = mysql_fetch_assoc($sigorta_cek);
											$sigorta_adi = $sigorta_oku['sigorta_adi'];

											$style = '';
											$class  = '';
											if($oku->profil=="Hurda Belgeli"){
												$class = "blink" ;
												//$color = "red";
											}elseif($oku->profil=="Plakalı"){         
												$color = "green";            
											}elseif($oku->profil == "Çekme Belgeli/Pert Kayıtlı"){
												$color = "#000000";
											}else{
												$color="#000000";
											}
											
											$resim_cek = mysql_query("select * from ilan_resimler where ilan_id = '".$oku->id."'");
											$resim_oku = mysql_fetch_assoc($resim_cek);
											$resim = $resim_oku['resim'];
											if($resim==""){
												$resim="default.png";
											}
											$stat_cek = mysql_query("SELECT * FROM kazanilan_ilanlar WHERE ilan_id = '".$oku->id."'");
											$stat_oku = mysql_fetch_assoc($stat_cek);
											$tklif_cek = mysql_query("SELECT * FROM teklifler WHERE durum=1 and ilan_id = '".$oku->id."' order by teklif_zamani desc limit 1");
											$tklifini_oku = mysql_fetch_assoc($tklif_cek);
											$tklif_sayi = mysql_num_rows($tklif_cek);
											if($stat_oku['durum'] == "0" || $stat_oku['durum'] == "1" || $stat_oku['durum'] == "2" || $stat_oku['durum'] == "3" || $stat_oku['durum'] == "4"){
												$tablo_rengi = "#1b8d3d"; //Koyu yeşil
											}else if($oku->ihale_turu == "1" && $tklifini_oku['uye_id']!='283'){
												if($oku->durum == "-1"){
														$tablo_rengi = "#00a2ff"; //Açık mavi       
												}else{
													$tablo_rengi = "#b4e61d"; //Açık yeşil      
												}
											}else if($oku->ihale_turu== "1" && $tklifini_oku['uye_id']=='283'){
												$tablo_rengi = "#feadc8";  //Toz pembe
											}else {
												if($oku->ihale_turu== "2" && $tklifini_oku['uye_id']=='283'){
													$tablo_rengi = "#ffd0b0";//Krem rengi
												}else{
													$tablo_rengi = "#ffd0b0";//Krem rengi
												}
											}
											
											if($tablo_rengi=="#1b8d3d"){
												$t_color="color:#fff;";
												$color="#fff";
											}else{
												$t_color="";
											}
											$arac_detaylari=$oku->model_yili." ".$marka_adi." ".$oku->model." ".$oku->tip." <span style='".$color2."' class='".$class."'>".$oku->profil."</span>";
											if($oku->link!=""){
												$sgrt_adi='<a style="'.$t_color.'" href="'.$oku->link.'" target="_blank">'.$sigorta_adi.'</a>';
											}else{
												$sgrt_adi='<span style="'.$t_color.'">'.$sigorta_adi.'</span>';
											}
											
											$td.='
												<tr id="tr_'.$oku->id.'" style="background-color: '.$tablo_rengi.'; '.$t_color.' ">
													<td><input type="checkbox" name="secim[]" class="chec" id="asd'.$oku->id.'" value="'.$oku->id.'" style="opacity:1!important; z-index:999;"></td>
													<td><a target="_blank" href="?modul=ilanlar&sayfa=ilan_ekle&id='.$oku->id.'"><i class="fas fa-edit"></i></a></td>
													<td><a onclick="tabTrigger()" href="?modul=ilanlar&sayfa=ilan_ekle&id='.$oku->id.'" target="_blank"><img style="width: 50px; height:50px;" src="../images/'.$resim.'" alt=""></a></td>
													<td>'.$oku->arac_kodu.'</td>
													<td>'.$oku->plaka.'</td>    
													<td>'.$oku->sehir.'</td>  
													<td style="color:'.$color.';" ><a href="../arac_detay.php?id='.$oku->id.'&q=ihale" style="color:'.$color.';" target="_blank">'.$arac_detaylari.'</a></td>    
													<td id="sayac'.$sira.'">
														<input type="hidden" id="ihale_sayac'.$sira.'" value="'.$tarih_ihale.'" >
														<input type="hidden" id="id_'.$sira.'" value="'.$oku->id.'">
													</td> 
													<td>
														<a style="cursor: pointer;'.$t_color.'" class="view_guncelle kapanis_zamani'.$sira.'" id="'.$oku->id.'">'.$kapanis_zamani.'</a>
													</td>
													<td class="'.$yan.'"><a class="view_uyeye_teklif_ver" style="'.$t_color.'" id="sonteklif_'.$oku->id.'">'.money($oku->son_teklif).'₺</a></td>   
													<!-- <td class="'.$yan.'">'.$oku->son_teklif.'</td>     -->
													<input type="hidden" id="teklif_sayisi'.$sira.'" value="'.$toplam_teklif.'" >
													<td><a style="'.$t_color.'" class="view_ilan_teklifleri" id="teklifler_'.$oku->id.'"><i class="fas fa-gavel">'.$toplam_teklif.'</i></a></td>    
													<td><a style="'.$t_color.'" class="view_ilan_mesajlari" id="mesajlar_'.$oku->id.'"><i class="fas fa-envelope">'.$mesaj_sayi.'</i></a></td>    
													<td><a style="'.$t_color.'" class="view_ilan_favorileri" id="'.$oku->id.'"><i class="fas fa-heart">'.$favori_sayi.'</i></a></td>    
													<td><a style="'.$t_color.'" class="view_ilan_notlari" id="'.$oku->id.'"><i class="fas fa-align-justify">'.$not_sayi.'</i></a></td>    
													<td>'.$sgrt_adi.'</td>
												</tr>
											';
											$sira++;
										}
									}
								}else{
									if(!in_array($hepsini_oku['id'],$hepsi_array)){
										
										$tarih_ihale=$hepsini_oku['ihale_tarihi'].' '. $hepsini_oku['ihale_saati'];
										$kapanis_zamani=date("d-m-Y H:i:s", strtotime($hepsini_oku["ihale_tarihi"]. " ". $hepsini_oku["ihale_saati"]));
										if($tablo_rengi=="#1b8d3d"){
											$t_color="color:#fff;";
											$color="#fff";
										}else{
											$t_color="";
										}
										if($hepsini_oku["link"]!=""){
											$sgrt_adi='<a style="'.$t_color.'" href="'.$hepsini_oku["link"].'" target="_blank">'.$sigorta_adi.'</a>';
										}else{
											$sgrt_adi='<span style="'.$t_color.'">'.$sigorta_adi.'</span>';
										}
										$arac_detaylari=$hepsini_oku["model_yili"]." ".$marka_adi." ".$hepsini_oku['model']." ".$hepsini_oku['tip']." <span style='".$color2."' class='".$class."'>".$hepsini_oku['profil']."</span>";
										$td.='
											<tr id="tr_'.$hepsini_oku["id"].'" style="background-color: '.$tablo_rengi.';'.$t_color.'  ">
												<td><input type="checkbox" name="secim[]" class="chec" id="asd'.$gelen_id.'" value="'.$gelen_id.'" style="opacity:1!important; z-index:999;"></td>
												<td><a target="_blank" href="?modul=ilanlar&sayfa=ilan_ekle&id='.$gelen_id.'"><i class="fas fa-edit"></i></a></td>
												<td><a onclick="tabTrigger()" href="?modul=ilanlar&sayfa=ilan_ekle&id='.$gelen_id.'" target="_blank"><img style="width: 50px; height:50px;" src="../images/'.$resim.'" alt=""></a></td>
												<td>'.$hepsini_oku["arac_kodu"].'</td>
												<td>'.$hepsini_oku["plaka"].'</td>    
												<td>'.$hepsini_oku['sehir'].'</td>  
												<td style="color:'.$color.';" ><a href="../arac_detay.php?id='.$gelen_id.'&q=ihale" style="color:'.$color.';"  target="_blank">'.$arac_detaylari.'</a></td>    
												<td id="sayac'.$sira.'">
													<input type="hidden" id="ihale_sayac'.$sira.'" value="'.$tarih_ihale.'" >
													<input type="hidden" id="id_'.$sira.'" value="'.$hepsini_oku['id'].'">
												</td> 
												<td>
													<a style="cursor: pointer;'.$t_color.'" class="view_guncelle kapanis_zamani'.$sira.'" id="'.$hepsini_oku['id'].'">'.$kapanis_zamani.'</a>
												</td>
												<td class="'.$yan.'"><a style="'.$t_color.'" class="view_uyeye_teklif_ver" id="sonteklif_'.$hepsini_oku['id'].'">'.money($hepsini_oku["son_teklif"]).'₺</a></td>   
												<!-- <td class="'.$yan.'">'.$hepsini_oku["son_teklif"].'</td>     -->
												<input type="hidden" id="teklif_sayisi'.$sira.'" value="'.$toplam_teklif.'" >
												<td><a style="'.$t_color.'" class="view_ilan_teklifleri" id="teklifler_'.$hepsini_oku['id'].'"><i class="fas fa-gavel">'.$toplam_teklif.'</i></a></td>    
												<td><a style="'.$t_color.'" class="view_ilan_mesajlari" id="mesajlar_'.$hepsini_oku['id'].'"><i class="fas fa-envelope">'.$mesaj_sayi.'</i></a></td>    
												<td><a style="'.$t_color.'" class="view_ilan_favorileri" id="'.$hepsini_oku['id'].'"><i class="fas fa-heart">'.$favori_sayi.'</i></a></td>    
												<td><a style="'.$t_color.'" class="view_ilan_notlari" id="'.$hepsini_oku['id'].'"><i class="fas fa-align-justify">'.$not_sayi.'</i></a></td>    
												<td>'.$sgrt_adi.'</td>  
											</tr>
										';
										$sira++;
									}
									
								}
							}else if($hepsini_oku['ihale_turu']== "1" && $teklifini_oku['uye_id']!='283'){
								if($hepsini_oku['durum']== "-1"){
									
									$tablo_rengi = "#00a2ff"; //Açık mavi  
									$ihale_trh=$hepsini_oku["ihale_tarihi"];
									$ihale_st=$hepsini_oku["ihale_saati"];
									$srgl=mysql_query("select ilanlar.* from ilanlar inner join teklifler on teklifler.ilan_id=ilanlar.id  where ilanlar.id = '".$hepsini_oku["id"]."' and ilanlar.durum=1 and ilanlar.ihale_tarihi='".$ihale_trh."' and ilanlar.ihale_saati='".$ihale_st."' and teklifler.durum=1 group by ilanlar.id");							//
									if(mysql_num_rows($srgl)>0){
										while($oku=mysql_fetch_object($srgl)){
											if(!in_array($oku->id,$hepsi_array)){
												array_push($hepsi_array,$oku->id);
						
												$tarih_ihale=$oku->ihale_tarihi.' '. $oku->ihale_saati;
												$kapanis_zamani=date("d-m-Y H:i:s", strtotime($oku->ihale_tarihi. " ". $oku->ihale_saati));
												
												$teklifler=mysql_query("select * from teklifler where ilan_id='".$oku->id."' and durum=1 order by teklif_zamani desc ");
												$toplam_teklif = mysql_num_rows($teklifler);
												
												
												$mesaj_cek = mysql_query("SELECT * FROM mesajlar WHERE ilan_id = '".$oku->id."'");
												$mesaj_sayi = mysql_num_rows($mesaj_cek);
											
												$favori_cek = mysql_query("SELECT * FROM favoriler WHERE ilan_id = '".$oku->id."'");
												$favori_sayi = mysql_num_rows($favori_cek);
												$not_cek = mysql_query("SELECT * FROM ilan_notlari WHERE ilan_id = '".$oku->id."' group by tarih order by id desc");
												$not_sayi = mysql_num_rows($not_cek);


												$sigorta_cek = mysql_query("SELECT * FROM sigorta_ozellikleri WHERE id = '".$oku->sigorta."'");
												$sigorta_oku = mysql_fetch_assoc($sigorta_cek);
												$sigorta_adi = $sigorta_oku['sigorta_adi'];

												$style = '';
												$class  = '';
												if($oku->profil=="Hurda Belgeli"){
													$class = "blink" ;
													$color2 = "color:red;";
												}elseif($oku->profil=="Plakalı"){         
													$color2 = "color:green;font-weight:bold";            
												}elseif($oku->profil == "Çekme Belgeli/Pert Kayıtlı"){
													$color2 = "color:#000000";
												}else{
													$color2 = "color:#000000";
												}
												
												$resim_cek = mysql_query("select * from ilan_resimler where ilan_id = '".$oku->id."'");
												$resim_oku = mysql_fetch_assoc($resim_cek);
												$resim = $resim_oku['resim'];
												if($resim==""){
													$resim="default.png";
												}
												$stat_cek = mysql_query("SELECT * FROM kazanilan_ilanlar WHERE ilan_id = '".$oku->id."'");
												$stat_oku = mysql_fetch_assoc($stat_cek);
												$tklif_cek = mysql_query("SELECT * FROM teklifler WHERE durum=1 and ilan_id = '".$oku->id."' order by teklif_zamani desc limit 1");
												$tklifini_oku = mysql_fetch_assoc($tklif_cek);
												$tklif_sayi = mysql_num_rows($tklif_cek);
												if($stat_oku['durum'] == "0" || $stat_oku['durum'] == "1" || $stat_oku['durum'] == "2" || $stat_oku['durum'] == "3" || $stat_oku['durum'] == "4"){
													$tablo_rengi = "#1b8d3d"; //Koyu yeşil
												}else if($oku->ihale_turu == "1" && $tklifini_oku['uye_id']!='283'){
													if($oku->durum == "-1"){
															$tablo_rengi = "#00a2ff"; //Açık mavi       
													}else{
														$tablo_rengi = "#b4e61d"; //Açık yeşil      
													}
												}else if($oku->ihale_turu== "1" && $tklifini_oku['uye_id']=='283'){
													$tablo_rengi = "#feadc8";  //Toz pembe
												}else {
													if($oku->ihale_turu== "2" && $tklifini_oku['uye_id']=='283'){
														$tablo_rengi = "#ffd0b0";//Krem rengi
													}else{
														$tablo_rengi = "#ffd0b0";//Krem rengi
													}
												}
												
												if($tablo_rengi=="#1b8d3d"){
													$t_color="color:#fff;";
													$color="#fff";
												}else{
													$t_color="";
												}
												$arac_detaylari=$oku->model_yili." ".$marka_adi." ".$oku->model." ".$oku->tip." <span style='".$color2."' class='".$class."'>".$oku->profil."</span>";
												if($oku->link!=""){
													$sgrt_adi='<a style="'.$t_color.'" href="'.$oku->link.'" target="_blank">'.$sigorta_adi.'</a>';
												}else{
													$sgrt_adi='<span style="'.$t_color.'">'.$sigorta_adi.'</span>';
												}
												$td.='
													<tr id="tr_'.$oku->id.'" style="background-color: '.$tablo_rengi.'; '.$t_color.' ">
														<td><input type="checkbox" name="secim[]" class="chec" id="asd'.$oku->id.'" value="'.$oku->id.'" style="opacity:1!important; z-index:999;"></td>
														<td><a target="_blank" href="?modul=ilanlar&sayfa=ilan_ekle&id='.$oku->id.'"><i class="fas fa-edit"></i></a></td>
														<td><a onclick="tabTrigger()" href="?modul=ilanlar&sayfa=ilan_ekle&id='.$oku->id.'" target="_blank"><img style="width: 50px; height:50px;" src="../images/'.$resim.'" alt=""></a></td>
														<td>'.$oku->arac_kodu.'</td>
														<td>'.$oku->plaka.'</td>    
														<td>'.$oku->sehir.'</td>  
														<td style="color:'.$color.';" ><a href="../arac_detay.php?id='.$oku->id.'&q=ihale" style="color:'.$color.';" target="_blank">'.$arac_detaylari.'</a></td>    
														<td id="sayac'.$sira.'">
															<input type="hidden" id="ihale_sayac'.$sira.'" value="'.$tarih_ihale.'" >
															<input type="hidden" id="id_'.$sira.'" value="'.$oku->id.'">
														</td> 
														<td>
															<a style="cursor: pointer;'.$t_color.'" class="view_guncelle kapanis_zamani'.$sira.'" id="'.$oku->id.'">'.$kapanis_zamani.'</a>
														</td>
														<td class="'.$yan.'"><a class="view_uyeye_teklif_ver" style="'.$t_color.'" id="sonteklif_'.$oku->id.'">'.money($oku->son_teklif).'₺</a></td>   
														<!-- <td class="'.$yan.'">'.$oku->son_teklif.'</td>     -->
														<input type="hidden" id="teklif_sayisi'.$sira.'" value="'.$toplam_teklif.'" >
														<td><a style="'.$t_color.'" class="view_ilan_teklifleri" id="teklifler_'.$oku->id.'"><i class="fas fa-gavel">'.$toplam_teklif.'</i></a></td>    
														<td><a style="'.$t_color.'" class="view_ilan_mesajlari" id="mesajlar_'.$oku->id.'"><i class="fas fa-envelope">'.$mesaj_sayi.'</i></a></td>    
														<td><a style="'.$t_color.'" class="view_ilan_favorileri" id="'.$oku->id.'"><i class="fas fa-heart">'.$favori_sayi.'</i></a></td>    
														<td><a style="'.$t_color.'" class="view_ilan_notlari" id="'.$oku->id.'"><i class="fas fa-align-justify">'.$not_sayi.'</i></a></td>    
														<td>'.$sgrt_adi.'</td>    
													</tr>
												';
												$sira++;
											}
										}
									}else{
										if(!in_array($hepsini_oku['id'],$hepsi_array)){
											$tarih_ihale=$hepsini_oku['ihale_tarihi'].' '. $hepsini_oku['ihale_saati'];
											$kapanis_zamani=date("d-m-Y H:i:s", strtotime($hepsini_oku["ihale_tarihi"]. " ". $hepsini_oku["ihale_saati"]));
											if($tablo_rengi=="#1b8d3d"){
												$t_color="color:#fff;";
												$color="#fff";
											}else{
												$t_color="";
											}
											if($hepsini_oku["link"]!=""){
												$sgrt_adi='<a style="'.$t_color.'" href="'.$hepsini_oku["link"].'" target="_blank">'.$sigorta_adi.'</a>';
											}else{
												$sgrt_adi='<span style="'.$t_color.'">'.$sigorta_adi.'</span>';
											}
											$arac_detaylari=$hepsini_oku["model_yili"]." ".$marka_adi." ".$hepsini_oku['model']." ".$hepsini_oku['tip']." <span style='".$color2."' class='".$class."'>".$hepsini_oku['profil']."</span>";
											$td.='
												<tr id="tr_'.$hepsini_oku["id"].'" style="background-color: '.$tablo_rengi.';'.$t_color.'  ">
													<td><input type="checkbox" name="secim[]" class="chec" id="asd'.$gelen_id.'" value="'.$gelen_id.'" style="opacity:1!important; z-index:999;"></td>
													<td><a target="_blank" href="?modul=ilanlar&sayfa=ilan_ekle&id='.$gelen_id.'"><i class="fas fa-edit"></i></a></td>
													<td><a onclick="tabTrigger()" href="?modul=ilanlar&sayfa=ilan_ekle&id='.$gelen_id.'" target="_blank"><img style="width: 50px; height:50px;" src="../images/'.$resim.'" alt=""></a></td>
													<td>'.$hepsini_oku["arac_kodu"].'</td>
													<td>'.$hepsini_oku["plaka"].'</td>    
													<td>'.$hepsini_oku['sehir'].'</td>  
													<td style="color:'.$color.';" ><a href="../arac_detay.php?id='.$gelen_id.'&q=ihale" style="color:'.$color.';"  target="_blank">'.$arac_detaylari.'</a></td>    
													<td id="sayac'.$sira.'">
														<input type="hidden" id="ihale_sayac'.$sira.'" value="'.$tarih_ihale.'" >
														<input type="hidden" id="id_'.$sira.'" value="'.$hepsini_oku['id'].'">
													</td> 
													<td>
														<a style="cursor: pointer;'.$t_color.'" class="view_guncelle kapanis_zamani'.$sira.'" id="'.$hepsini_oku['id'].'">'.$kapanis_zamani.'</a>
													</td>
													<td class="'.$yan.'"><a style="'.$t_color.'" class="view_uyeye_teklif_ver" id="sonteklif_'.$hepsini_oku['id'].'">'.money($hepsini_oku["son_teklif"]).'₺</a></td>   
													<!-- <td class="'.$yan.'">'.$hepsini_oku["son_teklif"].'</td>     -->
													<input type="hidden" id="teklif_sayisi'.$sira.'" value="'.$toplam_teklif.'" >
													<td><a style="'.$t_color.'" class="view_ilan_teklifleri" id="teklifler_'.$hepsini_oku['id'].'"><i class="fas fa-gavel">'.$toplam_teklif.'</i></a></td>    
													<td><a style="'.$t_color.'" class="view_ilan_mesajlari" id="mesajlar_'.$hepsini_oku['id'].'"><i class="fas fa-envelope">'.$mesaj_sayi.'</i></a></td>    
													<td><a style="'.$t_color.'" class="view_ilan_favorileri" id="'.$hepsini_oku['id'].'"><i class="fas fa-heart">'.$favori_sayi.'</i></a></td>    
													<td><a style="'.$t_color.'" class="view_ilan_notlari" id="'.$hepsini_oku['id'].'"><i class="fas fa-align-justify">'.$not_sayi.'</i></a></td>    
													<td>'.$sgrt_adi.'</td>    
												</tr>
											';
											$sira++;
										}
										
									}
								}else{
									$tablo_rengi = "#b4e61d"; //Açık yeşil    
								
									$ihale_trh=$hepsini_oku["ihale_tarihi"];
									$ihale_st=$hepsini_oku["ihale_saati"];
									$srgl=mysql_query("select ilanlar.* from ilanlar inner join teklifler on teklifler.ilan_id=ilanlar.id  where ilanlar.id = '".$hepsini_oku["id"]."' and ilanlar.durum=1 and ilanlar.ihale_tarihi='".$ihale_trh."' and ilanlar.ihale_saati='".$ihale_st."' and teklifler.durum=1 group by ilanlar.id");							//
									if(mysql_num_rows($srgl)>0){
										while($oku=mysql_fetch_object($srgl)){
											if(!in_array($oku->id,$hepsi_array)){
												array_push($hepsi_array,$oku->id);

												$tarih_ihale=$oku->ihale_tarihi.' '. $oku->ihale_saati;
												$kapanis_zamani=date("d-m-Y H:i:s", strtotime($oku->ihale_tarihi. " ". $oku->ihale_saati));
																						
												$teklifler=mysql_query("select * from teklifler where ilan_id='".$oku->id."' and durum=1 order by teklif_zamani desc ");
												$toplam_teklif = mysql_num_rows($teklifler);											
												
												$mesaj_cek = mysql_query("SELECT * FROM mesajlar WHERE ilan_id = '".$oku->id."' ");
												$mesaj_sayi = mysql_num_rows($mesaj_cek);
												
												$favori_cek = mysql_query("SELECT * FROM favoriler WHERE ilan_id = '".$oku->id."'");
												$favori_sayi = mysql_num_rows($favori_cek);
												$not_cek = mysql_query("SELECT * FROM ilan_notlari WHERE ilan_id = '".$oku->id."' group by tarih order by id desc");
												$not_sayi = mysql_num_rows($not_cek);

												$sigorta_cek = mysql_query("SELECT * FROM sigorta_ozellikleri WHERE id = '".$oku->sigorta."'");
												$sigorta_oku = mysql_fetch_assoc($sigorta_cek);
												$sigorta_adi = $sigorta_oku['sigorta_adi'];
								
												$style = '';
												$class  = '';
												if($oku->profil=="Hurda Belgeli"){
													$class = "blink" ;
													$color2 = "color:red;";
												}elseif($oku->profil=="Plakalı"){         
													$color2 = "color:green;font-weight:bold";            
												}elseif($oku->profil == "Çekme Belgeli/Pert Kayıtlı"){
													$color2 = "color:#000000";
												}else{
													$color2 ="#000000";
												}
												
												$resim_cek = mysql_query("select * from ilan_resimler where ilan_id = '".$oku->id."'");
												$resim_oku = mysql_fetch_assoc($resim_cek);
												$resim = $resim_oku['resim'];
												if($resim==""){
													$resim="default.png";
												}
												$stat_cek = mysql_query("SELECT * FROM kazanilan_ilanlar WHERE ilan_id = '".$oku->id."'");
												$stat_oku = mysql_fetch_assoc($stat_cek);
												$tklif_cek = mysql_query("SELECT * FROM teklifler WHERE durum=1 and ilan_id = '".$oku->id."' order by teklif_zamani desc limit 1");
												$tklifini_oku = mysql_fetch_assoc($tklif_cek);
												$tklif_sayi = mysql_num_rows($tklif_cek);
												if($stat_oku['durum'] == "0" || $stat_oku['durum'] == "1" || $stat_oku['durum'] == "2" || $stat_oku['durum'] == "3" || $stat_oku['durum'] == "4"){
													$tablo_rengi = "#1b8d3d"; //Koyu yeşil
												}else if($oku->ihale_turu == "1" && $tklifini_oku['uye_id']!='283'){
													if($oku->durum == "-1"){
															$tablo_rengi = "#00a2ff"; //Açık mavi       
													}else{
														$tablo_rengi = "#b4e61d"; //Açık yeşil      
													}
												}else if($oku->ihale_turu== "1" && $tklifini_oku['uye_id']=='283'){
													$tablo_rengi = "#feadc8";  //Toz pembe
												}else {
													if($oku->ihale_turu== "2" && $tklifini_oku['uye_id']=='283'){
														$tablo_rengi = "#ffd0b0";//Krem rengi
													}else{
														$tablo_rengi = "#ffd0b0";//Krem rengi
													}
												}
												
												if($tablo_rengi=="#1b8d3d"){
													$t_color="color:#fff;";
													$color="#fff";
												}else{
													$t_color="";
												}
												
												$arac_detaylari=$oku->model_yili." ".$marka_adi." ".$oku->model." ".$oku->tip." <span style='".$color2."' class='".$class."'>".$oku->profil."</span>";
												if($oku->link!=""){
													$sgrt_adi='<a style="'.$t_color.'" href="'.$oku->link.'" target="_blank">'.$sigorta_adi.'</a>';
												}else{
													$sgrt_adi='<span style="'.$t_color.'">'.$sigorta_adi.'</span>';
												}
											
												$td.='
													<tr  id="tr_'.$oku->id.'" style="background-color: '.$tablo_rengi.'; '.$t_color.' ">
														<td><input type="checkbox" name="secim[]" class="chec" id="asd'.$oku->id.'" value="'.$oku->id.'" style="opacity:1!important; z-index:999;"></td>
														<td><a target="_blank" href="?modul=ilanlar&sayfa=ilan_ekle&id='.$oku->id.'"><i class="fas fa-edit"></i></a></td>
														<td><a onclick="tabTrigger()" href="?modul=ilanlar&sayfa=ilan_ekle&id='.$oku->id.'" target="_blank"><img style="width: 50px; height:50px;" src="../images/'.$resim.'" alt=""></a></td>
														<td>'.$oku->arac_kodu.'</td>
														<td>'.$oku->plaka.'</td>    
														<td>'.$oku->sehir.'</td>  
														<td style="color:'.$color.';"><a href="../arac_detay.php?id='.$oku->id.'&q=ihale" style="color:'.$color.';" target="_blank">'.$arac_detaylari.'</a></td>    
														<td id="sayac'.$sira.'">
															<input type="hidden" id="ihale_sayac'.$sira.'" value="'.$tarih_ihale.'" >
															<input type="hidden" id="id_'.$sira.'" value="'.$oku->id.'">
														</td> 
														<td>
															<a style="cursor: pointer;'.$t_color.'" class="view_guncelle kapanis_zamani'.$sira.'" id="'.$oku->id.'">'.$kapanis_zamani.'</a>
														</td>
														<td class="'.$yan.'"><a class="view_uyeye_teklif_ver" style="'.$t_color.'" id="sonteklif_'.$oku->id.'">'.money($oku->son_teklif).'₺</a></td>   
														<!-- <td class="'.$yan.'">'.$oku->son_teklif.'</td>     -->
														<input type="hidden" id="teklif_sayisi'.$sira.'" value="'.$toplam_teklif.'" >
														<td><a style="'.$t_color.'" class="view_ilan_teklifleri" id="teklifler_'.$oku->id.'"><i class="fas fa-gavel">'.$toplam_teklif.'</i></a></td>    
														<td><a style="'.$t_color.'" class="view_ilan_mesajlari" id="mesajlar_'.$oku->id.'"><i class="fas fa-envelope">'.$mesaj_sayi.'</i></a></td>    
														<td><a style="'.$t_color.'" class="view_ilan_favorileri" id="'.$oku->id.'"><i class="fas fa-heart">'.$favori_sayi.'</i></a></td>    
														<td><a style="'.$t_color.'" class="view_ilan_notlari" id="'.$oku->id.'"><i class="fas fa-align-justify">'.$not_sayi.'</i></a></td>    
														<td>'.$sgrt_adi.'</td>    
													</tr>
												';
												$sira++;
											}
										}
									}else{
										if(!in_array($hepsini_oku['id'],$hepsi_array)){

											$tarih_ihale=$hepsini_oku['ihale_tarihi'].' '. $hepsini_oku['ihale_saati'];
											$kapanis_zamani=date("d-m-Y H:i:s", strtotime($hepsini_oku["ihale_tarihi"]. " ". $hepsini_oku["ihale_saati"]));
											if($tablo_rengi=="#1b8d3d"){
												$t_color="color:#fff;";
												$color="#fff";
											}else{
												$t_color="";
											}
											$arac_detaylari=$hepsini_oku["model_yili"]." ".$marka_adi." ".$hepsini_oku['model']." ".$hepsini_oku['tip']." <span style='".$color2."' class='".$class."'>".$hepsini_oku['profil']."</span>";

											if($hepsini_oku["link"]!=""){
												$sgrt_adi='<a style="'.$t_color.'" href="'.$hepsini_oku["link"].'" target="_blank">'.$sigorta_adi.'</a>';
											}else{
												$sgrt_adi='<span style="'.$t_color.'">'.$sigorta_adi.'</span>';
											}
											$td.='
												<tr id="tr_'.$hepsini_oku["id"].'" style="background-color: '.$tablo_rengi.';'.$t_color.'  ">
													<td><input type="checkbox" name="secim[]" class="chec" id="asd'.$gelen_id.'" value="'.$gelen_id.'" style="opacity:1!important; z-index:999;"></td>
													<td><a target="_blank" href="?modul=ilanlar&sayfa=ilan_ekle&id='.$gelen_id.'"><i class="fas fa-edit"></i></a></td>
													<td><a onclick="tabTrigger()" href="?modul=ilanlar&sayfa=ilan_ekle&id='.$gelen_id.'" target="_blank"><img style="width: 50px; height:50px;" src="../images/'.$resim.'" alt=""></a></td>
													<td>'.$hepsini_oku["arac_kodu"].'</td>
													<td>'.$hepsini_oku["plaka"].'</td>    
													<td>'.$hepsini_oku['sehir'].'</td>  
													<td style="color:'.$color.';" ><a href="../arac_detay.php?id='.$gelen_id.'&q=ihale" style="color:'.$color.';"  target="_blank">'.$arac_detaylari.'</a></td>    
													<td id="sayac'.$sira.'">
														<input type="hidden" id="ihale_sayac'.$sira.'" value="'.$tarih_ihale.'" >
														<input type="hidden" id="id_'.$sira.'" value="'.$hepsini_oku['id'].'">
													</td> 
													<td>
														<a style="cursor: pointer;'.$t_color.'" class="view_guncelle kapanis_zamani'.$sira.'" id="'.$hepsini_oku['id'].'">'.$kapanis_zamani.'</a>
													</td>
													<td class="'.$yan.'"><a style="'.$t_color.'" class="view_uyeye_teklif_ver" id="sonteklif_'.$hepsini_oku['id'].'">'.money($hepsini_oku["son_teklif"]).'₺</a></td>   
													<!-- <td class="'.$yan.'">'.$hepsini_oku["son_teklif"].'</td>     -->
													<input type="hidden" id="teklif_sayisi'.$sira.'" value="'.$toplam_teklif.'" >
													<td><a style="'.$t_color.'" class="view_ilan_teklifleri" id="teklifler_'.$hepsini_oku['id'].'"><i class="fas fa-gavel">'.$toplam_teklif.'</i></a></td>    
													<td><a style="'.$t_color.'" class="view_ilan_mesajlari" id="mesajlar_'.$hepsini_oku['id'].'"><i class="fas fa-envelope">'.$mesaj_sayi.'</i></a></td>    
													<td><a style="'.$t_color.'" class="view_ilan_favorileri" id="'.$hepsini_oku['id'].'"><i class="fas fa-heart">'.$favori_sayi.'</i></a></td>    
													<td><a style="'.$t_color.'" class="view_ilan_notlari" id="'.$hepsini_oku['id'].'"><i class="fas fa-align-justify">'.$not_sayi.'</i></a></td>    
													<td>'.$sgrt_adi.'</td>    
												</tr>
											';
											$sira++;
										}
										
									}								
								}
							}else if($hepsini_oku['ihale_turu']== "1" && $teklifini_oku['uye_id']=='283'){
								
								$tablo_rengi = "#feadc8";  //Toz pembe
								$ihale_trh=$hepsini_oku["ihale_tarihi"];
								$ihale_st=$hepsini_oku["ihale_saati"];
								$srgl=mysql_query("select ilanlar.* from ilanlar inner join teklifler on teklifler.ilan_id=ilanlar.id  where ilanlar.id = '".$hepsini_oku["id"]."' and ilanlar.durum=1 and ilanlar.ihale_tarihi='".$ihale_trh."' and ilanlar.ihale_saati='".$ihale_st."' and teklifler.durum=1 group by ilanlar.id");							//
								if(mysql_num_rows($srgl)>0){
									while($oku=mysql_fetch_object($srgl)){
										if(!in_array($oku->id,$hepsi_array)){
											array_push($hepsi_array,$oku->id);

											$tarih_ihale=$oku->ihale_tarihi.' '. $oku->ihale_saati;
											$kapanis_zamani=date("d-m-Y H:i:s", strtotime($oku->ihale_tarihi. " ". $oku->ihale_saati));
											
											
											$teklifler=mysql_query("select * from teklifler where ilan_id='".$oku->id."' and durum=1 order by teklif_zamani desc ");
											$toplam_teklif = mysql_num_rows($teklifler);
											
											
											$mesaj_cek = mysql_query("SELECT * FROM mesajlar WHERE ilan_id = '".$oku->id."' ");
											$mesaj_sayi = mysql_num_rows($mesaj_cek);
											$favori_cek = mysql_query("SELECT * FROM favoriler WHERE ilan_id = '".$oku->id."'");
											$favori_sayi = mysql_num_rows($favori_cek);
											$not_cek = mysql_query("SELECT * FROM ilan_notlari WHERE ilan_id = '".$oku->id."' group by tarih order by id desc");
											$not_sayi = mysql_num_rows($not_cek);


											$sigorta_cek = mysql_query("SELECT * FROM sigorta_ozellikleri WHERE id = '".$oku->sigorta."'");
											$sigorta_oku = mysql_fetch_assoc($sigorta_cek);
											$sigorta_adi = $sigorta_oku['sigorta_adi'];

											$style = '';
											$class  = '';
											if($oku->profil=="Hurda Belgeli"){
												$class = "blink" ;
												$color2 = "color:red;";
											}elseif($oku->profil=="Plakalı"){         
												$color2 = "color:green;font-weight:bold";            
											}elseif($oku->profil == "Çekme Belgeli/Pert Kayıtlı"){
												$color2 = "color:#000000";
											}else{
												$color2 = "color:#000000";
											}
											
											$resim_cek = mysql_query("select * from ilan_resimler where ilan_id = '".$oku->id."'");
											$resim_oku = mysql_fetch_assoc($resim_cek);
											$resim = $resim_oku['resim'];
											if($resim==""){
												$resim="default.png";
											}
											$stat_cek = mysql_query("SELECT * FROM kazanilan_ilanlar WHERE ilan_id = '".$oku->id."'");
											$stat_oku = mysql_fetch_assoc($stat_cek);
											$tklif_cek = mysql_query("SELECT * FROM teklifler WHERE durum=1 and ilan_id = '".$oku->id."' order by teklif_zamani desc limit 1");
											$tklifini_oku = mysql_fetch_assoc($tklif_cek);
											$tklif_sayi = mysql_num_rows($tklif_cek);
											if($stat_oku['durum'] == "0" || $stat_oku['durum'] == "1" || $stat_oku['durum'] == "2" || $stat_oku['durum'] == "3" || $stat_oku['durum'] == "4"){
												$tablo_rengi = "#1b8d3d"; //Koyu yeşil
											}else if($oku->ihale_turu == "1" && $tklifini_oku['uye_id']!='283'){
												if($oku->durum == "-1"){
														$tablo_rengi = "#00a2ff"; //Açık mavi       
												}else{
													$tablo_rengi = "#b4e61d"; //Açık yeşil      
												}
											}else if($oku->ihale_turu== "1" && $tklifini_oku['uye_id']=='283'){
												$tablo_rengi = "#feadc8";  //Toz pembe
											}else {
												if($oku->ihale_turu== "2" && $tklifini_oku['uye_id']=='283'){
													$tablo_rengi = "#ffd0b0";//Krem rengi
												}else{
													$tablo_rengi = "#ffd0b0";//Krem rengi
												}
											}
											
											if($tablo_rengi=="#1b8d3d"){
												$t_color="color:#fff;";
												$color="#fff";
											}else{
												$t_color="";
											}
											$arac_detaylari=$oku->model_yili." ".$marka_adi." ".$oku->model." ".$oku->tip." <span style='".$color2."' class='".$class."'>".$oku->profil."</span>";
											if($oku->link!=""){
												$sgrt_adi='<a style="'.$t_color.'" href="'.$oku->link.'" target="_blank">'.$sigorta_adi.'</a>';
											}else{
												$sgrt_adi='<span style="'.$t_color.'">'.$sigorta_adi.'</span>';
											}
											$td.='
												<tr id="tr_'.$oku->id.'" style="background-color: '.$tablo_rengi.'; '.$t_color.' ">
													<td><input type="checkbox" name="secim[]" class="chec" id="asd'.$oku->id.'" value="'.$oku->id.'" style="opacity:1!important; z-index:999;"></td>
													<td><a target="_blank" href="?modul=ilanlar&sayfa=ilan_ekle&id='.$oku->id.'"><i class="fas fa-edit"></i></a></td>
													<td><a onclick="tabTrigger()" href="?modul=ilanlar&sayfa=ilan_ekle&id='.$oku->id.'" target="_blank"><img style="width: 50px; height:50px;" src="../images/'.$resim.'" alt=""></a></td>
													<td>'.$oku->arac_kodu.'</td>
													<td>'.$oku->plaka.'</td>    
													<td>'.$oku->sehir.'</td>  
													<td style="color:'.$color.';" ><a href="../arac_detay.php?id='.$oku->id.'&q=ihale" style="color:'.$color.';" target="_blank">'.$arac_detaylari.'</a></td>    
													<td id="sayac'.$sira.'">
														<input type="hidden" id="ihale_sayac'.$sira.'" value="'.$tarih_ihale.'" >
														<input type="hidden" id="id_'.$sira.'" value="'.$oku->id.'">
													</td> 
													<td>
														<a style="cursor: pointer;'.$t_color.'" class="view_guncelle kapanis_zamani'.$sira.'" id="'.$oku->id.'">'.$kapanis_zamani.'</a>
													</td>
													<td class="'.$yan.'"><a class="view_uyeye_teklif_ver" style="'.$t_color.'" id="sonteklif_'.$oku->id.'">'.money($oku->son_teklif).'₺</a></td>   
													<!-- <td class="'.$yan.'">'.$oku->son_teklif.'</td>     -->
													<input type="hidden" id="teklif_sayisi'.$sira.'" value="'.$toplam_teklif.'" >
													<td><a style="'.$t_color.'" class="view_ilan_teklifleri" id="teklifler_'.$oku->id.'"><i class="fas fa-gavel">'.$toplam_teklif.'</i></a></td>    
													<td><a style="'.$t_color.'" class="view_ilan_mesajlari" id="mesajlar_'.$oku->id.'"><i class="fas fa-envelope">'.$mesaj_sayi.'</i></a></td>    
													<td><a style="'.$t_color.'" class="view_ilan_favorileri" id="'.$oku->id.'"><i class="fas fa-heart">'.$favori_sayi.'</i></a></td>    
													<td><a style="'.$t_color.'" class="view_ilan_notlari" id="'.$oku->id.'"><i class="fas fa-align-justify">'.$not_sayi.'</i></a></td>    
													<td>'.$sgrt_adi.'</td>    
												</tr>
											';
											$sira++;
										}
									}
								}else{
									if(!in_array($hepsini_oku['id'],$hepsi_array)){
										$arac_detaylari=$hepsini_oku["model_yili"]." ".$marka_adi." ".$hepsini_oku['model']." ".$hepsini_oku['tip']." <span style='".$color2."' class='".$class."'>".$hepsini_oku['profil']."</span>";

										$tarih_ihale=$hepsini_oku['ihale_tarihi'].' '. $hepsini_oku['ihale_saati'];
										$kapanis_zamani=date("d-m-Y H:i:s", strtotime($hepsini_oku["ihale_tarihi"]. " ". $hepsini_oku["ihale_saati"]));
										if($tablo_rengi=="#1b8d3d"){
											$t_color="color:#fff;";
											$color="#fff";
										}else{
											$t_color="";
										}
										
										if($hepsini_oku["link"]!=""){
											$sgrt_adi='<a style="'.$t_color.'" href="'.$hepsini_oku["link"].'" target="_blank">'.$sigorta_adi.'</a>';
										}else{
											$sgrt_adi='<span style="'.$t_color.'">'.$sigorta_adi.'</span>';
										}
										
										$td.='
											<tr id="tr_'.$hepsini_oku["id"].'" style="background-color: '.$tablo_rengi.';'.$t_color.'  ">
												<td><input type="checkbox" name="secim[]" class="chec" id="asd'.$gelen_id.'" value="'.$gelen_id.'" style="opacity:1!important; z-index:999;"></td>
												<td><a target="_blank" href="?modul=ilanlar&sayfa=ilan_ekle&id='.$gelen_id.'"><i class="fas fa-edit"></i></a></td>
												<td><a onclick="tabTrigger()" href="?modul=ilanlar&sayfa=ilan_ekle&id='.$gelen_id.'" target="_blank"><img style="width: 50px; height:50px;" src="../images/'.$resim.'" alt=""></a></td>
												<td>'.$hepsini_oku["arac_kodu"].'</td>
												<td>'.$hepsini_oku["plaka"].'</td>    
												<td>'.$hepsini_oku['sehir'].'</td>  
												<td style="color:'.$color.';" ><a href="../arac_detay.php?id='.$gelen_id.'&q=ihale" style="color:'.$color.';"  target="_blank">'.$arac_detaylari.'</a></td>    
												<td id="sayac'.$sira.'">
													<input type="hidden" id="ihale_sayac'.$sira.'" value="'.$tarih_ihale.'" >
													<input type="hidden" id="id_'.$sira.'" value="'.$hepsini_oku['id'].'">
												</td> 
												<td>
													<a style="cursor: pointer;'.$t_color.'" class="view_guncelle kapanis_zamani'.$sira.'" id="'.$hepsini_oku['id'].'">'.$kapanis_zamani.'</a>
												</td>
												<td class="'.$yan.'"><a style="'.$t_color.'" class="view_uyeye_teklif_ver" id="sonteklif_'.$hepsini_oku['id'].'">'.money($hepsini_oku["son_teklif"]).'₺</a></td>   
												<!-- <td class="'.$yan.'">'.$hepsini_oku["son_teklif"].'</td>     -->
												<input type="hidden" id="teklif_sayisi'.$sira.'" value="'.$toplam_teklif.'" >
												<td><a style="'.$t_color.'" class="view_ilan_teklifleri" id="teklifler_'.$hepsini_oku['id'].'"><i class="fas fa-gavel">'.$toplam_teklif.'</i></a></td>    
												<td><a style="'.$t_color.'" class="view_ilan_mesajlari" id="mesajlar_'.$hepsini_oku['id'].'"><i class="fas fa-envelope">'.$mesaj_sayi.'</i></a></td>    
												<td><a style="'.$t_color.'" class="view_ilan_favorileri" id="'.$hepsini_oku['id'].'"><i class="fas fa-heart">'.$favori_sayi.'</i></a></td>    
												<td><a style="'.$t_color.'" class="view_ilan_notlari" id="'.$hepsini_oku['id'].'"><i class="fas fa-align-justify">'.$not_sayi.'</i></a></td>    
												<td>'.$sgrt_adi.'</td>    
											</tr>
										';
										$sira++;
									}
									
								}
							}else {
								if($hepsini_oku['ihale_turu']== "2" && $teklifini_oku['uye_id']=='283'){
									$tablo_rengi = "#ffd0b0";//Krem rengi
									$ihale_trh=$hepsini_oku["ihale_tarihi"];
									$ihale_st=$hepsini_oku["ihale_saati"];
									$srgl=mysql_query("select ilanlar.* from ilanlar inner join teklifler on teklifler.ilan_id=ilanlar.id  where ilanlar.id = '".$hepsini_oku["id"]."' and ilanlar.durum=1 and ilanlar.ihale_tarihi='".$ihale_trh."' and ilanlar.ihale_saati='".$ihale_st."' and teklifler.durum=1 group by ilanlar.id");							//
									if(mysql_num_rows($srgl)>0){
										while($oku=mysql_fetch_object($srgl)){
											if(!in_array($oku->id,$hepsi_array)){
												array_push($hepsi_array,$oku->id);
												$tarih_ihale=$oku->ihale_tarihi.' '. $oku->ihale_saati;
												$kapanis_zamani=date("d-m-Y H:i:s", strtotime($oku->ihale_tarihi. " ". $oku->ihale_saati));
											
												
												$teklifler=mysql_query("select * from teklifler where ilan_id='".$oku->id."' and durum=1 order by teklif_zamani desc ");
												$toplam_teklif = mysql_num_rows($teklifler);
												
												
												$mesaj_cek = mysql_query("SELECT * FROM mesajlar WHERE ilan_id = '".$oku->id."' ");
												$mesaj_sayi = mysql_num_rows($mesaj_cek);
												$favori_cek = mysql_query("SELECT * FROM favoriler WHERE ilan_id = '".$oku->id."'");
												$favori_sayi = mysql_num_rows($favori_cek);
												$not_cek = mysql_query("SELECT * FROM ilan_notlari WHERE ilan_id = '".$oku->id."' group by tarih order by id desc");
												$not_sayi = mysql_num_rows($not_cek);


												$sigorta_cek = mysql_query("SELECT * FROM sigorta_ozellikleri WHERE id = '".$oku->sigorta."'");
												$sigorta_oku = mysql_fetch_assoc($sigorta_cek);
												$sigorta_adi = $sigorta_oku['sigorta_adi'];

												$style = '';
												$class  = '';
												if($oku->profil=="Hurda Belgeli"){
													$class = "blink" ;
													$color2 = "color:red;";
												}elseif($oku->profil=="Plakalı"){         
													$color2 = "color:green;font-weight:bold";            
												}elseif($oku->profil == "Çekme Belgeli/Pert Kayıtlı"){
													$color2 = "color:#000000";
												}else{
													$color2 = "color:#000000";
												}
												
												$resim_cek = mysql_query("select * from ilan_resimler where ilan_id = '".$oku->id."'");
												$resim_oku = mysql_fetch_assoc($resim_cek);
												$resim = $resim_oku['resim'];
												if($resim==""){
													$resim="default.png";
												}
												$stat_cek = mysql_query("SELECT * FROM kazanilan_ilanlar WHERE ilan_id = '".$oku->id."'");
												$stat_oku = mysql_fetch_assoc($stat_cek);
												$tklif_cek = mysql_query("SELECT * FROM teklifler WHERE durum=1 and ilan_id = '".$oku->id."' order by teklif_zamani desc limit 1");
												$tklifini_oku = mysql_fetch_assoc($tklif_cek);
												$tklif_sayi = mysql_num_rows($tklif_cek);
												if($stat_oku['durum'] == "0" || $stat_oku['durum'] == "1" || $stat_oku['durum'] == "2" || $stat_oku['durum'] == "3" || $stat_oku['durum'] == "4"){
													$tablo_rengi = "#1b8d3d"; //Koyu yeşil
												}else if($oku->ihale_turu == "1" && $tklifini_oku['uye_id']!='283'){
													if($oku->durum == "-1"){
															$tablo_rengi = "#00a2ff"; //Açık mavi       
													}else{
														$tablo_rengi = "#b4e61d"; //Açık yeşil      
													}
												}else if($oku->ihale_turu== "1" && $tklifini_oku['uye_id']=='283'){
													$tablo_rengi = "#feadc8";  //Toz pembe
												}else {
													if($oku->ihale_turu== "2" && $tklifini_oku['uye_id']=='283'){
														$tablo_rengi = "#ffd0b0";//Krem rengi
													}else{
														$tablo_rengi = "#ffd0b0";//Krem rengi
													}
												}
												
												if($tablo_rengi=="#1b8d3d"){
													$t_color="color:#fff;";
													$color="#fff";
												}else{
													$t_color="";
												}
												$arac_detaylari=$oku->model_yili." ".$marka_adi." ".$oku->model." ".$oku->tip." <span style='".$color2."' class='".$class."'>".$oku->profil."</span>";
												
												if($oku->link!=""){
													$sgrt_adi='<a style="'.$t_color.'" href="'.$oku->link.'" target="_blank">'.$sigorta_adi.'</a>';
												}else{
													$sgrt_adi='<span style="'.$t_color.'">'.$sigorta_adi.'</span>';
												}
												$td.='
													<tr id="tr_'.$oku->id.'" style="background-color: '.$tablo_rengi.'; '.$t_color.' ">
														<td><input type="checkbox" name="secim[]" class="chec" id="asd'.$oku->id.'" value="'.$oku->id.'" style="opacity:1!important; z-index:999;"></td>
														<td><a target="_blank" href="?modul=ilanlar&sayfa=ilan_ekle&id='.$oku->id.'"><i class="fas fa-edit"></i></a></td>
														<td><a onclick="tabTrigger()" href="?modul=ilanlar&sayfa=ilan_ekle&id='.$oku->id.'" target="_blank"><img style="width: 50px; height:50px;" src="../images/'.$resim.'" alt=""></a></td>
														<td>'.$oku->arac_kodu.'</td>
														<td>'.$oku->plaka.'</td>    
														<td>'.$oku->sehir.'</td>  
														<td style="color:'.$color.';" ><a href="../arac_detay.php?id='.$oku->id.'&q=ihale" style="color:'.$color.';" target="_blank">'.$arac_detaylari.'</a></td>    
														<td id="sayac'.$sira.'">
															<input type="hidden" id="ihale_sayac'.$sira.'" value="'.$tarih_ihale.'" >
															<input type="hidden" id="id_'.$sira.'" value="'.$oku->id.'">
														</td> 
														<td>
															<a style="cursor: pointer;'.$t_color.'" class="view_guncelle kapanis_zamani'.$sira.'" id="'.$oku->id.'">'.$kapanis_zamani.'</a>
														</td>
														<td class="'.$yan.'"><a class="view_uyeye_teklif_ver" style="'.$t_color.'" id="sonteklif_'.$oku->id.'">'.money($oku->son_teklif).'₺</a></td>   
														<!-- <td class="'.$yan.'">'.$oku->son_teklif.'</td>     -->
														<input type="hidden" id="teklif_sayisi'.$sira.'" value="'.$toplam_teklif.'" >
														<td><a style="'.$t_color.'" class="view_ilan_teklifleri" id="teklifler_'.$oku->id.'"><i class="fas fa-gavel">'.$toplam_teklif.'</i></a></td>    
														<td><a style="'.$t_color.'" class="view_ilan_mesajlari" id="mesajlar_'.$oku->id.'"><i class="fas fa-envelope">'.$mesaj_sayi.'</i></a></td>    
														<td><a style="'.$t_color.'" class="view_ilan_favorileri" id="'.$oku->id.'"><i class="fas fa-heart">'.$favori_sayi.'</i></a></td>    
														<td><a style="'.$t_color.'" class="view_ilan_notlari" id="'.$oku->id.'"><i class="fas fa-align-justify">'.$not_sayi.'</i></a></td>    
														<td>'.$sgrt_adi.'</td>   
													</tr>
												';
												$sira++;
											}
										}
									}else{
										if(!in_array($hepsini_oku['id'],$hepsi_array)){
											$arac_detaylari=$hepsini_oku["model_yili"]." ".$marka_adi." ".$hepsini_oku['model']." ".$hepsini_oku['tip']." <span style='".$color2."' class='".$class."'>".$hepsini_oku['profil']."</span>";
											$tarih_ihale=$hepsini_oku['ihale_tarihi'].' '. $hepsini_oku['ihale_saati'];
											$kapanis_zamani=date("d-m-Y H:i:s", strtotime($hepsini_oku["ihale_tarihi"]. " ". $hepsini_oku["ihale_saati"]));
											if($tablo_rengi=="#1b8d3d"){
												$t_color="color:#fff;";
												$color="#fff";
											}else{
												$t_color="";
											}
														
											if($hepsini_oku["link"]!=""){
												$sgrt_adi='<a style="'.$t_color.'" href="'.$hepsini_oku["link"].'" target="_blank">'.$sigorta_adi.'</a>';
											}else{
												$sgrt_adi='<span style="'.$t_color.'">'.$sigorta_adi.'</span>';
											}
											$td.='
												<tr id="tr_'.$hepsini_oku["id"].'" style="background-color: '.$tablo_rengi.';'.$t_color.'  ">
													<td><input type="checkbox" name="secim[]" class="chec" id="asd'.$gelen_id.'" value="'.$gelen_id.'" style="opacity:1!important; z-index:999;"></td>
													<td><a target="_blank" href="?modul=ilanlar&sayfa=ilan_ekle&id='.$gelen_id.'"><i class="fas fa-edit"></i></a></td>
													<td><a onclick="tabTrigger()" href="?modul=ilanlar&sayfa=ilan_ekle&id='.$gelen_id.'" target="_blank"><img style="width: 50px; height:50px;" src="../images/'.$resim.'" alt=""></a></td>
													<td>'.$hepsini_oku["arac_kodu"].'</td>
													<td>'.$hepsini_oku["plaka"].'</td>    
													<td>'.$hepsini_oku['sehir'].'</td>  
													<td style="color:'.$color.';" ><a href="../arac_detay.php?id='.$gelen_id.'&q=ihale" style="color:'.$color.';"  target="_blank">'.$arac_detaylari.'</a></td>    
													<td id="sayac'.$sira.'">
														<input type="hidden" id="ihale_sayac'.$sira.'" value="'.$tarih_ihale.'" >
														<input type="hidden" id="id_'.$sira.'" value="'.$hepsini_oku['id'].'">
													</td> 
													<td>
														<a style="cursor: pointer;'.$t_color.'" class="view_guncelle kapanis_zamani'.$sira.'" id="'.$hepsini_oku['id'].'">'.$kapanis_zamani.'</a>
													</td>
													<td class="'.$yan.'"><a style="'.$t_color.'" class="view_uyeye_teklif_ver" id="sonteklif_'.$hepsini_oku['id'].'">'.money($hepsini_oku["son_teklif"]).'₺</a></td>   
													<!-- <td class="'.$yan.'">'.$hepsini_oku["son_teklif"].'</td>     -->
													<input type="hidden" id="teklif_sayisi'.$sira.'" value="'.$toplam_teklif.'" >
													<td><a style="'.$t_color.'" class="view_ilan_teklifleri" id="teklifler_'.$hepsini_oku['id'].'"><i class="fas fa-gavel">'.$toplam_teklif.'</i></a></td>    
													<td><a style="'.$t_color.'" class="view_ilan_mesajlari" id="mesajlar_'.$hepsini_oku['id'].'"><i class="fas fa-envelope">'.$mesaj_sayi.'</i></a></td>    
													<td><a style="'.$t_color.'" class="view_ilan_favorileri" id="'.$hepsini_oku['id'].'"><i class="fas fa-heart">'.$favori_sayi.'</i></a></td>    
													<td><a style="'.$t_color.'" class="view_ilan_notlari" id="'.$hepsini_oku['id'].'"><i class="fas fa-align-justify">'.$not_sayi.'</i></a></td>    
													<td>'.$sgrt_adi.'</td>   
												</tr>
											';
											$sira++;
										}
									}
									
								}else{
							
									$tablo_rengi = "#ffd0b0";//Krem rengi
									$ihale_trh=$hepsini_oku["ihale_tarihi"];
									$ihale_st=$hepsini_oku["ihale_saati"];
									$srgl=mysql_query("select ilanlar.* from ilanlar inner join teklifler on teklifler.ilan_id=ilanlar.id  where ilanlar.id = '".$hepsini_oku["id"]."' and ilanlar.durum=1 and ilanlar.ihale_tarihi='".$ihale_trh."' and ilanlar.ihale_saati='".$ihale_st."' and teklifler.durum=1 group by ilanlar.id");							//
									if(mysql_num_rows($srgl)>0){
										while($oku=mysql_fetch_object($srgl)){
											if(!in_array($oku->id,$hepsi_array)){
												array_push($hepsi_array,$oku->id);
												$tarih_ihale=$oku->ihale_tarihi.' '. $oku->ihale_saati;
												$kapanis_zamani=date("d-m-Y H:i:s", strtotime($oku->ihale_tarihi. " ". $oku->ihale_saati));

												
												$teklifler=mysql_query("select * from teklifler where ilan_id='".$oku->id."' and durum=1 order by teklif_zamani desc ");
												$toplam_teklif = mysql_num_rows($teklifler);
												
												
												$mesaj_cek = mysql_query("SELECT * FROM mesajlar WHERE ilan_id = '".$oku->id."'");
												$mesaj_sayi = mysql_num_rows($mesaj_cek);
												$favori_cek = mysql_query("SELECT * FROM favoriler WHERE ilan_id = '".$oku->id."'");
												$favori_sayi = mysql_num_rows($favori_cek);
												$not_cek = mysql_query("SELECT * FROM ilan_notlari WHERE ilan_id = '".$oku->id."' group by tarih order by id desc");
												$not_sayi = mysql_num_rows($not_cek);


												$sigorta_cek = mysql_query("SELECT * FROM sigorta_ozellikleri WHERE id = '".$oku->sigorta."'");
												$sigorta_oku = mysql_fetch_assoc($sigorta_cek);
												$sigorta_adi = $sigorta_oku['sigorta_adi'];

												$style = '';
												$class  = '';
												if($oku->profil=="Hurda Belgeli"){
													$class = "blink" ;
													$color2 = "color:red;";
												}elseif($oku->profil=="Plakalı"){         
													$color2 = "color:green;font-weight:bold";            
												}elseif($oku->profil == "Çekme Belgeli/Pert Kayıtlı"){
													$color2 = "color:#000000";
												}else{
													$color2 = "color:#000000";
												}
												
												$resim_cek = mysql_query("select * from ilan_resimler where ilan_id = '".$oku->id."'");
												$resim_oku = mysql_fetch_assoc($resim_cek);
												$resim = $resim_oku['resim'];
												if($resim==""){
													$resim="default.png";
												}
												$stat_cek = mysql_query("SELECT * FROM kazanilan_ilanlar WHERE ilan_id = '".$oku->id."'");
												$stat_oku = mysql_fetch_assoc($stat_cek);
												$tklif_cek = mysql_query("SELECT * FROM teklifler WHERE durum=1 and ilan_id = '".$oku->id."' order by teklif_zamani desc limit 1");
												$tklifini_oku = mysql_fetch_assoc($tklif_cek);
												$tklif_sayi = mysql_num_rows($tklif_cek);
												if($stat_oku['durum'] == "0" || $stat_oku['durum'] == "1" || $stat_oku['durum'] == "2" || $stat_oku['durum'] == "3" || $stat_oku['durum'] == "4"){
													$tablo_rengi = "#1b8d3d"; //Koyu yeşil
												}else if($oku->ihale_turu == "1" && $tklifini_oku['uye_id']!='283'){
													if($oku->durum == "-1"){
															$tablo_rengi = "#00a2ff"; //Açık mavi       
													}else{
														$tablo_rengi = "#b4e61d"; //Açık yeşil      
													}
												}else if($oku->ihale_turu== "1" && $tklifini_oku['uye_id']=='283'){
													$tablo_rengi = "#feadc8";  //Toz pembe
												}else {
													if($oku->ihale_turu== "2" && $tklifini_oku['uye_id']=='283'){
														$tablo_rengi = "#ffd0b0";//Krem rengi
													}else{
														$tablo_rengi = "#ffd0b0";//Krem rengi
													}
												}
												
												if($tablo_rengi=="#1b8d3d"){
													$t_color="color:#fff;";
													$color="#fff";
												}else{
													$t_color="";
												}
												$arac_detaylari=$oku->model_yili." ".$marka_adi." ".$oku->model." ".$oku->tip." <span style='".$color2."' class='".$class."'>".$oku->profil."</span>";
												if($oku->link!=""){
													$sgrt_adi='<a style="'.$t_color.'" href="'.$oku->link.'" target="_blank">'.$sigorta_adi.'</a>';
												}else{
													$sgrt_adi='<span style="'.$t_color.'">'.$sigorta_adi.'</span>';
												}
												$td.='
													<tr id="tr_'.$oku->id.'" style="background-color: '.$tablo_rengi.'; '.$t_color.' ">
														<td><input type="checkbox" name="secim[]" class="chec" id="asd'.$oku->id.'" value="'.$oku->id.'" style="opacity:1!important; z-index:999;"></td>
														<td><a target="_blank" href="?modul=ilanlar&sayfa=ilan_ekle&id='.$oku->id.'"><i class="fas fa-edit"></i></a></td>
														<td><a onclick="tabTrigger()" href="?modul=ilanlar&sayfa=ilan_ekle&id='.$oku->id.'" target="_blank"><img style="width: 50px; height:50px;" src="../images/'.$resim.'" alt=""></a></td>
														<td>'.$oku->arac_kodu.'</td>
														<td>'.$oku->plaka.'</td>    
														<td>'.$oku->sehir.'</td>  
														<td style="color:'.$color.';" ><a href="../arac_detay.php?id='.$oku->id.'&q=ihale" style="color:'.$color.';" target="_blank">'.$arac_detaylari.'</a></td>    
														<td id="sayac'.$sira.'">
															<input type="hidden" id="ihale_sayac'.$sira.'" value="'.$tarih_ihale.'" >
															<input type="hidden" id="id_'.$sira.'" value="'.$oku->id.'">
														</td> 
														<td>
															<a style="cursor: pointer;'.$t_color.'" class="view_guncelle kapanis_zamani'.$sira.'" id="'.$oku->id.'">'.$kapanis_zamani.'</a>
														</td>
														<td class="'.$yan.'"><a class="view_uyeye_teklif_ver" style="'.$t_color.'" id="sonteklif_'.$oku->id.'">'.money($oku->son_teklif).'₺</a></td>   
														<!-- <td class="'.$yan.'">'.$oku->son_teklif.'</td>     -->
														<input type="hidden" id="teklif_sayisi'.$sira.'" value="'.$toplam_teklif.'" >
														<td><a style="'.$t_color.'" class="view_ilan_teklifleri" id="teklifler_'.$oku->id.'"><i class="fas fa-gavel">'.$toplam_teklif.'</i></a></td>    
														<td><a style="'.$t_color.'" class="view_ilan_mesajlari" id="mesajlar_'.$oku->id.'"><i class="fas fa-envelope">'.$mesaj_sayi.'</i></a></td>    
														<td><a style="'.$t_color.'" class="view_ilan_favorileri" id="'.$oku->id.'"><i class="fas fa-heart">'.$favori_sayi.'</i></a></td>    
														<td><a style="'.$t_color.'" class="view_ilan_notlari" id="'.$oku->id.'"><i class="fas fa-align-justify">'.$not_sayi.'</i></a></td>    
														<td>'.$sgrt_adi.'</td>  
													</tr>
												';
												$sira++;
											}
										}
									}else{
										if(!in_array($hepsini_oku['id'],$hepsi_array)){
											$arac_detaylari=$hepsini_oku["model_yili"]." ".$marka_adi." ".$hepsini_oku['model']." ".$hepsini_oku['tip']." <span class='".$class."'>".$hepsini_oku['profil']."</span>";
											$tarih_ihale=$hepsini_oku['ihale_tarihi'].' '. $hepsini_oku['ihale_saati'];
											$kapanis_zamani=date("d-m-Y H:i:s", strtotime($hepsini_oku["ihale_tarihi"]. " ". $hepsini_oku["ihale_saati"]));
											if($tablo_rengi=="#1b8d3d"){
												$t_color="color:#fff;";
												$color="#fff";
											}else{
												$t_color="";
											}
											if($hepsini_oku["link"]!=""){
												$sgrt_adi='<a style="'.$t_color.'" href="'.$hepsini_oku["link"].'" target="_blank">'.$sigorta_adi.'</a>';
											}else{
												$sgrt_adi='<span style="'.$t_color.'">'.$sigorta_adi.'</span>';
											}
											$td.='
												<tr id="tr_'.$hepsini_oku["id"].'" style="background-color: '.$tablo_rengi.';'.$t_color.'  ">
													<td><input type="checkbox" name="secim[]" class="chec" id="asd'.$gelen_id.'" value="'.$gelen_id.'" style="opacity:1!important; z-index:999;"></td>
													<td><a target="_blank" href="?modul=ilanlar&sayfa=ilan_ekle&id='.$gelen_id.'"><i class="fas fa-edit"></i></a></td>
													<td><a onclick="tabTrigger()" href="?modul=ilanlar&sayfa=ilan_ekle&id='.$gelen_id.'" target="_blank"><img style="width: 50px; height:50px;" src="../images/'.$resim.'" alt=""></a></td>
													<td>'.$hepsini_oku["arac_kodu"].'</td>
													<td>'.$hepsini_oku["plaka"].'</td>    
													<td>'.$hepsini_oku['sehir'].'</td>  
													<td style="color:'.$color.';" ><a href="../arac_detay.php?id='.$gelen_id.'&q=ihale" style="color:'.$color.';"  target="_blank">'.$arac_detaylari.'</a></td>    
													<td id="sayac'.$sira.'">
														<input type="hidden" id="ihale_sayac'.$sira.'" value="'.$tarih_ihale.'" >
														<input type="hidden" id="id_'.$sira.'" value="'.$hepsini_oku['id'].'">
													</td> 
													<td>
														<a style="cursor: pointer;'.$t_color.'" class="view_guncelle kapanis_zamani'.$sira.'" id="'.$hepsini_oku['id'].'">'.$kapanis_zamani.'</a>
													</td>
													<td class="'.$yan.'"><a style="'.$t_color.'" class="view_uyeye_teklif_ver" id="sonteklif_'.$hepsini_oku['id'].'">'.money($hepsini_oku["son_teklif"]).'₺</a></td>   
													<!-- <td class="'.$yan.'">'.$hepsini_oku["son_teklif"].'</td>     -->
													<input type="hidden" id="teklif_sayisi'.$sira.'" value="'.$toplam_teklif.'" >
													<td><a style="'.$t_color.'" class="view_ilan_teklifleri" id="teklifler_'.$hepsini_oku['id'].'"><i class="fas fa-gavel">'.$toplam_teklif.'</i></a></td>    
													<td><a style="'.$t_color.'" class="view_ilan_mesajlari" id="mesajlar_'.$hepsini_oku['id'].'"><i class="fas fa-envelope">'.$mesaj_sayi.'</i></a></td>    
													<td><a style="'.$t_color.'" class="view_ilan_favorileri" id="'.$hepsini_oku['id'].'"><i class="fas fa-heart">'.$favori_sayi.'</i></a></td>    
													<td><a style="'.$t_color.'" class="view_ilan_notlari" id="'.$hepsini_oku['id'].'"><i class="fas fa-align-justify">'.$not_sayi.'</i></a></td>    
													<td>'.$sgrt_adi.'</td>  
												</tr>
											';
											$sira++;
										}	
									}
								}
							}
						}else{
							$tablo_rengi = "#fff";
							$arac_detaylari=$hepsini_oku["model_yili"]." ".$marka_adi." ".$hepsini_oku['model']." ".$hepsini_oku['tip']." <span style='".$color2."' class='".$class."'>".$hepsini_oku['profil']."</span>";
							$tarih_ihale=$hepsini_oku['ihale_tarihi'].' '. $hepsini_oku['ihale_saati'];
							$kapanis_zamani=date("d-m-Y H:i:s", strtotime($hepsini_oku["ihale_tarihi"]. " ". $hepsini_oku["ihale_saati"]));
							if($hepsini_oku["link"]!=""){
								$sgrt_adi='<a style="'.$t_color.'" href="'.$hepsini_oku["link"].'" target="_blank">'.$sigorta_adi.'</a>';
							}else{
								$sgrt_adi='<span style="'.$t_color.'">'.$sigorta_adi.'</span>';
							}
							$td.='
								<tr id="tr_'.$hepsini_oku["id"].'"  style="background-color: '.$tablo_rengi.'; ">
									<td><input type="checkbox" name="secim[]" class="chec" id="asd'.$gelen_id.'" value="'.$gelen_id.'" style="opacity:1!important; z-index:999;"></td>
									<td><a target="_blank" href="?modul=ilanlar&sayfa=ilan_ekle&id='.$gelen_id.'"><i class="fas fa-edit"></i></a></td>
									<td><a onclick="tabTrigger()" href="?modul=ilanlar&sayfa=ilan_ekle&id='.$gelen_id.'" target="_blank"><img style="width: 50px; height:50px;" src="../images/'.$resim.'" alt=""></a></td>
									<td>'.$hepsini_oku["arac_kodu"].'</td>
									<td>'.$hepsini_oku["plaka"].'</td>    
									<td>'.$hepsini_oku['sehir'].'</td>  
									<td style="color:'.$color.';" ><a href="../arac_detay.php?id='.$gelen_id.'&q=ihale" style="color:'.$color.';"  target="_blank">'.$arac_detaylari.'</a></td>    
									<td id="sayac'.$sira.'">
										<input type="hidden" id="ihale_sayac'.$sira.'" value="'.$tarih_ihale.'" >
										<input type="hidden" id="id_'.$sira.'" value="'.$hepsini_oku['id'].'">
									</td> 
									<td>
										<a style="cursor: pointer;" class="view_guncelle kapanis_zamani'.$sira.'" id="'.$hepsini_oku['id'].'">'.$kapanis_zamani.'</a>
									</td>
									<td class="'.$yan.'"><a class="view_uyeye_teklif_ver" id="sonteklif_'.$hepsini_oku['id'].'">'.money($hepsini_oku["son_teklif"]).'₺</a></td>   
									<!-- <td class="'.$yan.'">'.$hepsini_oku["son_teklif"].'</td>     -->
									<input type="hidden" id="teklif_sayisi'.$sira.'" value="'.$toplam_teklif.'" >
									<td><a class="view_ilan_teklifleri" id="teklifler_'.$hepsini_oku['id'].'"><i class="fas fa-gavel">'.$toplam_teklif.'</i></a></td>    
									<td><a class="view_ilan_mesajlari" id="mesajlar_'.$hepsini_oku['id'].'"><i class="fas fa-envelope">'.$mesaj_sayi.'</i></a></td>    
									<td><a class="view_ilan_favorileri" id="'.$hepsini_oku['id'].'"><i class="fas fa-heart">'.$favori_sayi.'</i></a></td>    
									<td><a class="view_ilan_notlari" id="'.$hepsini_oku['id'].'"><i class="fas fa-align-justify">'.$not_sayi.'</i></a></td>    
									<td>'.$sgrt_adi.'</td>
								</tr>
							';
							$sira++;
						}
					?>
				<?php  } ?>
				<tbody><?= $td ?></tbody>
			</table>
		</div>
	</form>
<?php } ?>
<style>
  .pagination.special-form {display: flex;align-items: center;justify-content: flex-end;}
  .pagination.special-form > a {
    padding: 5px;
    background: #4b8df8;
    color: #fff;
    margin: 0 3px;
    text-decoration: none;
    transition: 0.3s ease all;
    font-size: 20px;
    font-weight: bold;
  }
  .pagination.special-form > a:hover , .pagination.special-form > .page-active {
   background:#365fa1;
 }
 .pagination.special-form > .page-disable {
  background: #aaa !important;
  color: #fff!important;
  cursor: not-allowed;
}
</style>
<script>
	function tabTrigger(){
		localStorage.setItem("gorsel_trigger","1");
	}
</script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="js/uyeler_modal.js?v=<? echo time();?>"></script>

<!-- Guncelleme-->
<div style="width:75%;" class="modal fade" id="tarih_guncelle">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
		<h3 id="myModalLabel">Tarihi Değiştir</h3>
	</div>
	<div class="modal-dialog">
		<div class="modal-body" id="ihale_guncelle">
		</div>
	</div>
</div>
<!-- Guncelleme Modal Bitiş-->
<!-- İlan Fav-->
<div style="width:75%;" class="modal fade" id="ilan_fav">
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
<div style="width:75%;" class="modal fade" id="ilan_mesaj">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
	</div>
	<div class="modal-dialog">
		<div class="modal-body" id="mesaj_ilan">
		</div>
	</div>
</div>
<!-- İlan Mesaj Bitiş-->
<!-- İlan Teklif-->
<div style="width:75%;" class="modal fade" id="ilan_teklif">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
	</div>
	<div class="modal-dialog">
		<div class="modal-body" id="teklif_ilan">
		</div>
	</div>
</div>
<!-- İlan Teklif-->

<?php 
	if((re('ihale_tarih_degisir')=="Kaydet")){
		$guncel_tarih = re('tarih_guncelle');
		$guncel_saat = re('saat_guncelle');
		$ilanin_id = re('ilanin_id');
		mysql_query("UPDATE ilanlar SET ihale_tarihi = '".$guncel_tarih."', ihale_saati = '".$guncel_saat."', durum = 1 WHERE id='".$ilanin_id."'");
	}
?>

<!-- Üye Adına Teklif -->
<div style="" class="modal fade" id="uyeye_teklif">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
	</div>
   <div class="modal-dialog">
		<div class="modal-body" id="uyenin_teklifi">
		</div>
   </div>
</div>
<!-- Üye Adına Teklif Bitiş-->




<script>
	function sureleri_uzat(){
		
		if($(".chec").is(':checked')){
			return confirm ("Seçili süreleri uzatmak istediğinize emin misiniz?");
		}else{
			alert("Seçim yapmalısınız");
			return false;
		}
	}
    function createCountDown(elementId,sira) 
    {
		var zaman =document.getElementById("ihale_sayac"+sira).value;
		var id =document.getElementById("id_"+sira).value;
		var countDownDate = new Date(zaman).getTime();
		var x = setInterval(function() 
		{
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
					var son_teklif=$("#sonteklif_"+id).html();
					son_teklif=String(son_teklif);
					son_teklif=son_teklif.replace('.','');
					son_teklif=son_teklif.replace("₺","");	
					var yeni_sonteklif=formatMoney(response.son_teklif)+'₺';
					$("#sonteklif_"+id).html(yeni_sonteklif);
					$(".kapanis_zamani"+sira).html(response.ihale_tarihi);
					$("#tr_"+id).css("background-color",response.renk);
					var $teklif_sayi = `<i class="fas fa-gavel" aria-hidden="true">${response.toplam_teklif}</i>`;
					var $mesaj_sayi = `<i class="fas fa-envelope" aria-hidden="true">${response.mesaj_sayi}</i>`;
					if(response.onaydaki_sayi == 1){
						$('#teklifler_'+id).html($teklif_sayi+'<span style="color:#0966f2;" class="blink"> Yeni</span>');
					}else{
						if(response.onay_bekleyen_teklif_var_mi == "1"){
							$('#teklifler_'+id).html($teklif_sayi+'<span style="color:red;" class="blink"> Yeni</span>');
						}else{
							$('#teklifler_'+id).html($teklif_sayi);
						}
					}
					if(response.okunmamis_mesaj_var_mi == "1"){
						$('#mesajlar_'+id).html($mesaj_sayi + '<span style="color:red;" class="blink"> Yeni</span>');
					}else{
						$('#mesajlar_'+id).html($mesaj_sayi);
					}
		
					
					countDownDate=countDownDate+response.milisaniye; 	
				}
			});

			
			
			var now = new Date().getTime();
			var distance = (countDownDate) - (now);
			var days = Math.floor(distance / (1000 * 60 * 60 * 24));
			var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));			
			var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
			
			if(minutes<10){
				if(minutes<2 && (hours==0 || hours=="00" ) && (days==0 || days=="00" )){
					var teklif_sayisi=$("#teklif_sayisi"+sira).val();
					if(teklif_sayisi>0){
						$(".kapanis_zamani"+sira).addClass("yan");	
					}else{
						$(".kapanis_zamani"+sira).removeClass("yan");
					}
					
				}else{
					$(".kapanis_zamani"+sira).removeClass("yan");
				}
				minutes="0"+minutes;
			}
			
			if(hours<10){
				hours="0"+hours;
			}
			
			var seconds = Math.floor((distance % (1000 * 60)) / 1000);
			if(seconds<10){
				seconds="0"+seconds;
			}
			
			document.getElementById(elementId).innerHTML = days + " gün " + hours + ":"+ minutes + ":" + seconds + "";
			if (distance < 0) 
			{
				sure_doldu(id);
				clearInterval(x);
				document.getElementById(elementId).innerHTML = "Süre Doldu";

			}
		}, 1000);
	}
	/*function createCountDown(elementId,sira) 
    {
		var zaman =document.getElementById("ihale_sayac"+sira).value;
		var id =document.getElementById("id_"+sira).value;
		var countDownDate = new Date(zaman).getTime();
		var x = setInterval(function() 
		{
			var now = new Date().getTime();
			var distance = (countDownDate) - (now);
			var days = Math.floor(distance / (1000 * 60 * 60 * 24));
			var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));			
			var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));

			if(minutes<10){
				if(minutes<2 && (hours==0 || hours=="00" ) && (days==0 || days=="00" )){
					var teklif_sayisi=$("#teklif_sayisi"+sira).val();
					if(teklif_sayisi>0){
						$(".kapanis_zamani"+sira).addClass("yan");	
					}else{
						$(".kapanis_zamani"+sira).removeClass("yan");
					}
					
				}else{
					$(".kapanis_zamani"+sira).removeClass("yan");
				}
				minutes="0"+minutes;
			}
			
			if(hours<10){
				hours="0"+hours;
			}
			
			var seconds = Math.floor((distance % (1000 * 60)) / 1000);
			if(seconds<10){
				seconds="0"+seconds;
			}
			
			if(days>=0 && hours>=0 && minutes>=0 && seconds >= 0){
				
				if(days<=0 && hours<=0 && minutes<3){
			
					jQuery.ajax({
						url: "https://ihale.pertdunyasi.com/check.php",
						type: "POST",
						dataType: "JSON",
						data: {
							action: "otomatik_sure_uzat",
							id:id
						},
						success: function(response) {
							console.log(response);
							if(response.status==200){
								$(".kapanis_zamani"+sira).html(response.tarih);
								countDownDate=countDownDate+120000; 
							}
						}
					});

					document.getElementById(elementId).innerHTML = days + " Gün " + hours + ":"+ minutes + ":" + seconds + " ";
					
				}else{
					document.getElementById(elementId).innerHTML = days + " Gün " + hours + ":"+ minutes + ":" + seconds + " ";
				}
			
			}
			if (distance < 0) 
			{
				sure_doldu(id);
				clearInterval(x);
				document.getElementById(elementId).innerHTML = "Süre Doldu";

			}
		}, 1000);
	}*/
	for (var i = 0; i < ihale_say.value; i++) {
		createCountDown("sayac"+i,i);
	}
	
</script>

<!-- İlan Notları Başlangıç-->
<div class="modal fade custom-large-modal" id="ilan_notlari">
	<button type="button" class="close" style="margin-right: 2%; margin-top:2%;" data-dismiss="modal" aria-hidden="true"></button>
	<div class="modal-dialog">
		<div class="modal-body" id="ilanin_notlarini">
		</div>
	</div>
</div>

<?php 
	if(re('notu') =='Kaydet'){
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
				$yenisim=md5(microtime()).$dosya_adi; 				//karmasik yeni isim.pdf 
				                     
				$klasor="../assets"; // yuklenecek dosyalar icin yeni klasor 
				$test=move_uploaded_file($dosya_gecici,"$klasor/".$yenisim);//yoksa yeni ismiyle kaydet 
				if($test==true){
					$yol='assets/'.$yenisim;
					$a=mysql_query("INSERT INTO `ilan_notlari` (`id`, `ilan_id`, `ekleyen`, `ilan_notu`, `gizlilik`, `tarih`, `dosya`) 
					VALUES (NULL, '".$gelen_id."', '".$admin_id."', '".$eklenecek_not."', '".$gizlilik."', '".$tarih."', '".$yenisim."')")or die(mysql_error()); 
				
					mysql_query("INSERT INTO `yapilan_is` (`id`, `admin_id`, `yaptigi`,`aciklama`, `ekleme_zamani`, `ilan_id`, `dogrudan_id`, `uye_id`) VALUES 
					(NULL, '".$admin_id."', '2','".$eklenecek_not."', '".$tarih."','".$gelen_id."','0','0');"); 
					if($a){
					echo '<script>alert("Başarıyla Eklendi..");</script>';
					header("Location:?modul=ihaleler&sayfa=tum_ihaleler");
				   }
				}
				else {
					$a=mysql_query("INSERT INTO `ilan_notlari` (`id`, `ilan_id`, `ekleyen`, `ilan_notu`, `gizlilik`, `tarih`, `dosya`) 
					VALUES (NULL, '".$gelen_id."', '".$admin_id."', '".$eklenecek_not."', '".$gizlilik."', '".$tarih."', '1')")or die(mysql_error()); 
				
					mysql_query("INSERT INTO `yapilan_is` (`id`, `admin_id`, `yaptigi`,`aciklama`, `ekleme_zamani`, `ilan_id`, `dogrudan_id`, `uye_id`) VALUES 
						(NULL, '".$admin_id."', '2','".$eklenecek_not."', '".$tarih."','".$gelen_id."','0','0');"); 
					header("Location:?modul=ihaleler&sayfa=tum_ihaleler");
				}
			} 
		}
	}

?>
<script>
	var clicked = false;
	$(".checkall").on("click", function() {
		$(".chec").prop("checked", !clicked);
		clicked = !clicked;
		this.innerHTML = clicked ? 'Seçimleri Kaldır' : 'Tümünü Seç';
	});
	function markaGetir(){
		var sayi=document.getElementsByClassName("checked").length;
        var i;
		var array=[];
		for(i=0;i<sayi;i++){
			var a=document.getElementsByClassName('checked')[i].innerHTML;
			a=a.split(" ");
			a[3]=a[3].split("=");
			a[3][1]=a[3][1].replace('""','"');
			a[2]=a[2].split("=");
			a[2][1]=a[2][1].replace('""','"');
			if(a[2][1]=='"marka[]"'){
				array.push({marka_id:a[3][1]});
			}
		}
		jQuery.ajax({
			url: "https://ihale.pertdunyasi.com/check.php",
			type: "POST",
			dataType: "JSON",
			data: {
				action: "panel_model",
				json_array:JSON.stringify(array),
			},
			success: function(response) {
				console.log(response);
				if(response.status == 200){
					$('#model').html(response.str);
				} else {
					
				}
			}
		});
    }
	function formatMoney(n) {
		var n= (Math.round(n * 100) / 100).toLocaleString();
		n=n.replaceAll(',', '.')
		return n;
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
	function data_update(){
		jQuery.ajax({
			url: "https://ihale.pertdunyasi.com/check.php",
			type: "POST",
			dataType: "JSON",
			data: {
				action: "panel_ilanlar_guncelle",
			},
			success: function(response) {
				jQuery.each(response, function (index, value) {
					var son_teklif=$("#sonteklif_"+value.id).html();
					if(son_teklif!=undefined){
						son_teklif=String(son_teklif);
						son_teklif=son_teklif.replace('.','');
						son_teklif=son_teklif.replace("₺","");	
						if(son_teklif!=value.son_teklif){
							var yeni_sonteklif=formatMoney(value.son_teklif)+'₺';
							$("#sonteklif_"+value.id).html(yeni_sonteklif);
						}
					}
				});
			}
		});
	}
	var baslat=setInterval(function(){
		//data_update();
	},3000)
	
	

</script>