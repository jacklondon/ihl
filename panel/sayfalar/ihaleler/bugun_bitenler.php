<?php 
if (!isset($_GET['startrow']) or !is_numeric( $_GET['startrow'] ) ) {
	$startrow = 0;
} else {
	$startrow = (int) $_GET['startrow'];
}
	$admin_id = $_SESSION['kid'];
	$bugun = date("Y-m-d");

	$limit = 100;
	$page = (re("page") != "" && is_numeric(re("page"))) ? re("page") : 1;	
	$total_rows = mysql_num_rows(mysql_query("SELECT * FROM ilanlar WHERE ihale_tarihi = '$bugun' and ihale_saati > '".date('H:i:s')."' "));
	$total_page = ceil($total_rows / $limit);
	$page = ($page < 1) ? 1 : $page;
	$page = ($page > $total_page) ? $total_page : $page;
	$limit_start = ($page-1)*$limit;
	$limit_sql = "LIMIT ".$limit_start.",".$limit;

	// $hepsini_cek = mysql_query("SELECT * FROM ilanlar WHERE ihale_tarihi = '$bugun'  ORDER BY concat(ihale_tarihi,' ',ihale_saati) asc ".$limit_sql);
	//$hepsini_cek = mysql_query("SELECT * FROM ilanlar WHERE ihale_tarihi = '$bugun' and ihale_saati > '".date('H:i:s')."' ORDER BY concat(ihale_tarihi,' ',ihale_saati) asc ");
	$hepsini_cek = mysql_query("SELECT * FROM ilanlar WHERE ihale_tarihi = '$bugun' ORDER BY concat(ihale_tarihi,' ',ihale_saati) asc ");
	$filtreler="";
?>


<style>
	table{
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

	.table-bordered * td
	{
		color:#000!important;
	}
	
	.table-bordered * td a
	{
		color:#000!important;
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
		color: red !important;
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
			document.getElementById('arama_kriteri_backdrop').style.display = "block";
			expanded = true;
		} else {
			checkboxes.style.display = "none";
			document.getElementById('arama_kriteri_backdrop').style.display = "none";
			expanded = false;
		}
	}
	function showSehirler() {
		var checkboxes = document.getElementById("sehirler");
		if (!expanded) {
			checkboxes.style.display = "block";
			document.getElementById('sehirler_backdrop').style.display = "block";
			expanded = true;
		} else {
			checkboxes.style.display = "none";
			document.getElementById('sehirler_backdrop').style.display = "none";
			expanded = false;
		}
	}

	function showihale_turu() {
		var checkboxes = document.getElementById("ihale_turu");
		if (!expanded) {
			checkboxes.style.display = "block";
			document.getElementById('ihale_turu_backdrop').style.display = "block";
			expanded = true;
		} else {
			checkboxes.style.display = "none";
			document.getElementById('ihale_turu_backdrop').style.display = "none";
			expanded = false;
		}
	}
	function showsigortasirketleri() {
		var checkboxes = document.getElementById("sigorta_sirketleri");
		if (!expanded) {
			checkboxes.style.display = "block";
			document.getElementById('sigorta_backdrop').style.display = "block";
			expanded = true;
		} else {
			checkboxes.style.display = "none";
			document.getElementById('sigorta_backdrop').style.display = "none";
			expanded = false;
		}
	}
	function showMarkalar() {
		var checkboxes = document.getElementById("markalar");
		if (!expanded) {
			checkboxes.style.display = "block";
			document.getElementById('marka_backdrop').style.display = "block";
			expanded = true;
		} else {
			checkboxes.style.display = "none";
			document.getElementById('marka_backdrop').style.display = "none";
			expanded = false;
		}
	}
	function showBitis() {
		var checkboxes = document.getElementById("tarih");
		if (!expanded) {
			checkboxes.style.display = "block";
			document.getElementById('bitis_backdrop').style.display = "block";
			expanded = true;
		} else {
			checkboxes.style.display = "none";
			document.getElementById('bitis_backdrop').style.display = "none";
			expanded = false;
		}
	}  
	function showTeklif() {
		var checkboxes = document.getElementById("teklif_durum");
		if (!expanded) {
			checkboxes.style.display = "block";
			document.getElementById('teklif_backdrop').style.display = "block";
			expanded = true;
		} else {
			checkboxes.style.display = "none";
			document.getElementById('teklif_backdrop').style.display = "none";
			expanded = false;
		}
	}  

	function showEkleyenAdmin() {
		var checkboxes = document.getElementById("adminler");
		if (!expanded) {
			checkboxes.style.display = "block";
			document.getElementById('ekleyen_admin_backdrop').style.display = "block";
			expanded = true;
		} else {
			checkboxes.style.display = "none";
			document.getElementById('ekleyen_admin_backdrop').style.display = "none";
			expanded = false;
		}
	}  

	function showProfil() {
		var checkboxes = document.getElementById("profil");
		if (!expanded) {
			checkboxes.style.display = "block";
			document.getElementById('profil_backdrop').style.display = "block";
			expanded = true;
		} else {
			checkboxes.style.display = "none";
			document.getElementById('profil_backdrop').style.display = "none";
			expanded = false;
		}
	}
	function showModeller() {
		var checkboxes = document.getElementById("model");
		if (!expanded) {
			checkboxes.style.display = "block";
			document.getElementById('model_backdrop').style.display = "block";
			expanded = true;
		} else {
			checkboxes.style.display = "none";
			document.getElementById('model_backdrop').style.display = "none";
			expanded = false;
		}
	}
	function showAracDurumu() {
		var checkboxes = document.getElementById("aracdurumu");
		if (!expanded) {
			checkboxes.style.display = "block";
			document.getElementById('aracdurumu_backdrop').style.display = "block";
			expanded = true;
		} else {
			checkboxes.style.display = "none";
			document.getElementById('aracdurumu_backdrop').style.display = "none";
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
	
	#aracdurumu {
		display: none;
		border: 1px #dadada solid;
	}

	#aracdurumu label {
		display: block;
	}

	#aracdurumu label:hover {
		background-color: #1e90ff;
	}
	
	.checker span input {
		opacity:1!important;
		margin-top: -3px !important;
	}
	
	.general_search_check
	{
		position:relative;
		z-index:99;
	}
</style>
   
<?php 
	$sehir_cek = mysql_query("SELECT * FROM sehir"); 
	$marka_cek = mysql_query("SELECT * FROM marka"); 
	$sigorta_cek=mysql_query("Select * from sigorta_ozellikleri");
?>
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

<div class="select_backdrop" id="arama_kriteri_backdrop" onclick="showAramaKriteri()">
</div>

<div class="select_backdrop" id="sehirler_backdrop" onclick="showSehirler()">
</div>

<div class="select_backdrop" id="ihale_turu_backdrop" onclick="showihale_turu()">
</div>

<div class="select_backdrop" id="sigorta_backdrop" onclick="showsigortasirketleri()">
</div>

<div class="select_backdrop" id="marka_backdrop" onclick="showMarkalar()">
</div>

<div class="select_backdrop" id="bitis_backdrop" onclick="showBitis()">
</div>

<div class="select_backdrop" id="teklif_backdrop" onclick="showTeklif()">
</div>

<div class="select_backdrop" id="ekleyen_admin_backdrop" onclick="showEkleyenAdmin()">
</div>

<div class="select_backdrop" id="profil_backdrop" onclick="showProfil()">
</div>

<div class="select_backdrop" id="model_backdrop" onclick="showModeller()">
</div>

<div class="select_backdrop" id="aracdurumu_backdrop" onclick="showAracDurumu()">
</div>



<form method="POST" name="filter" id="filter">
	<div class="row-fluid searchs">
		<div class="span6">
			<div class="form-group">
				<h5>Kelime ile ara</h5>
				<?php
					if($_POST["aranan"]!=""){ ?>
						<input type="search" id="aranan" name="aranan" class="form-control" value="<?=$_POST["aranan"]?>" placeholder="Plaka, araç kodu vb..">
					<?php } else { ?>
						<input type="search" id="aranan" name="aranan" class="form-control" placeholder="Plaka, araç kodu vb..">
					<?php }
				?>
			</div>
			<div class="multiselect">
				<div class="selectBox" onclick="showAramaKriteri()">
					<select style="height:1.8em;">
						<option>Arama Kriteri</option>
					</select>
					<div class="overSelect"></div>
				</div>
				<div class="general_search_check" id="arama_kriteri">
				
					<?php
						$seciliAramaKriteriSayisi = count($_POST['arama_kriteri']);
									
						if($seciliAramaKriteriSayisi!=0){ 
							$yalnizca_devam_check="";
							$bugun_bitenler_check="";
							$yarin_bitenler_check="";
							$bitenler_check="";
							$bugun_eklenenler_check="";
							$statu_belirlenen_check="";
							$tumu_check="";
							for($i=0;$i<count($_POST["arama_kriteri"]);$i++){
								if($_POST["arama_kriteri"][$i]=="1"){
									$yalnizca_devam_check="checked";
								}
								if($_POST["arama_kriteri"][$i]=="2"){
									$bugun_bitenler_check="checked";
								}
								if($_POST["arama_kriteri"][$i]=="3"){
									$yarin_bitenler_check="checked";
								}
								if($_POST["arama_kriteri"][$i]=="4"){
									$bitenler_check="checked";
								}
								if($_POST["arama_kriteri"][$i]=="5"){
									$bugun_eklenenler_check="checked";
								}
								if($_POST["arama_kriteri"][$i]=="6"){
									$statu_belirlenen_check="checked";
								}
								if($_POST["arama_kriteri"][$i]=="7"){
									$tumu_check="checked";
								}
							}
						?>
							<label><input <?=$yalnizca_devam_check ?> type="radio" id="aramakriteri_1" name="arama_kriteri[]" value="1" />Yalnızca ihalesi devam eden </label>
							<label><input <?=$bugun_bitenler_check ?> type="radio" id="aramakriteri_2" name="arama_kriteri[]" value="2" />Bugün Bitecekler </label>
							<label><input <?=$yarin_bitenler_check ?> type="radio" id="aramakriteri_3" name="arama_kriteri[]" value="3" />Yarın Bitecekler </label>
							<label><input <?=$bitenler_check ?> type="radio" id="aramakriteri_4" name="arama_kriteri[]" value="4" />İhalesi Bitenler </label>
							<label><input <?=$bugun_eklenenler_check ?> type="radio" id="aramakriteri_5" name="arama_kriteri[]" value="5" />Bugün Eklenenler </label>
							<label><input <?=$statu_belirlenen_check ?> type="radio" id="aramakriteri_6" name="arama_kriteri[]" value="6" />Statü Belirlenenler </label>
							<label><input <?=$tumu_check ?> type="radio" id="aramakriteri_7" name="arama_kriteri[]" value="7" />Tümü</label>	
						<?php } else { ?>
							<?php
								if(isset($_POST['filtrele'])){
									$krt="";
									foreach($_POST["arama_kriteri"] as $arm_kriteri){
										
										if($arm_kriteri==1){
											$krt="checked"; ?>
										<?php }
									} ?>
									<label><input <?=$krt ?> type="radio" id="aramakriteri_1" name="arama_kriteri[]" value="1" />Yalnızca ihalesi devam eden </label>
								<?php }else{ ?>
									<label><input type="radio" id="aramakriteri_1" name="arama_kriteri[]" value="1" />Yalnızca ihalesi devam eden </label>
								<?php }
							?>
							<label><input type="radio" id="aramakriteri_2" name="arama_kriteri[]" value="2" />Bugün Bitecekler </label>
							<label><input type="radio" id="aramakriteri_3" name="arama_kriteri[]" value="3" />Yarın Bitecekler </label>
							<label><input type="radio" id="aramakriteri_4" name="arama_kriteri[]" value="4" />İhalesi Bitenler </label>
							<label><input type="radio" id="aramakriteri_5" name="arama_kriteri[]" value="5" />Bugün Eklenenler </label>
							<label><input type="radio" id="aramakriteri_6" name="arama_kriteri[]" value="6" />Statü Belirlenenler </label>
							<label><input type="radio" id="aramakriteri_7" name="arama_kriteri[]" value="7" />Tümü</label>	
						<?php }
					?>
				</div>
			</div>	
			<div class="multiselect">
				<div class="selectBox" onclick="showSehirler()">
					<select style="height:1.8em;">
						<option>Şehire Göre</option>
					</select>
				<div class="overSelect"></div>
				</div>
				<div class="general_search_check" id="sehirler">
					<input type="text" class="span4" id="city_filter_input" style="width: 100%;" placeholder="Şehir Arayın" onkeyup="search_in_div('filter_city','city_filter_input')">
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
								<label class="filter_city" for="<?= $sehir_oku['sehirID'] ?>">
								<input type="checkbox" <?=$sehir_check[$tu] ?> id="sehir_<?= $sehir_oku['sehiradi'] ?>" id="sehir_<?=$sehir_oku['sehiradi'] ?>" name="sehir[]" value="<?= $sehir_oku['sehiradi'] ?>" /><?= $sehir_oku['sehiradi'] ?>
							<?php $tu++; }
						?>
						<?php }else{
							while($sehir_oku = mysql_fetch_array($sehir_cek)){?>                        
								<label class="filter_city" for="<?= $sehir_oku['sehirID'] ?>">
								<input type="checkbox" name="sehir[]" id="sehir_<?= $sehir_oku['sehiradi'] ?>" value="<?= $sehir_oku['sehiradi'] ?>" /><?= $sehir_oku['sehiradi'] ?></label>
							<?php } 
						}
					?>
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
				<div class="general_search_check" id="sigorta_sirketleri">
					<?php
						$seciliSigortaSayisi = count($_POST['sigorta']);
						if($seciliSigortaSayisi!=0){
							$sigorta_check=array();
							$tu = 0;
							while($sigorta_oku = mysql_fetch_array($sigorta_cek)){
								$sigorta_check[$tu]="";
								for($i=0;$i<count($_POST['sigorta']);$i++){ 
									if($sigorta_oku["id"]==$_POST["sigorta"][$i]){
										$sigorta_check[$tu]="checked";
									}
								} ?>
								<label for="<?= $sigorta_oku['id'] ?>">
								<input type="checkbox" <?=$sigorta_check[$tu] ?> id="sigorta_<?= $sigorta_oku['id'] ?>" name="sigorta[]" value="<?= $sigorta_oku['id'] ?>" /><?= $sigorta_oku['sigorta_adi'] ?></label>
							<?php $tu++; }
						?>
						<?php }else{
							while($sigorta_oku = mysql_fetch_array($sigorta_cek)){?>                        
								<label for="<?= $sigorta_oku['id'] ?>">
								<input type="checkbox" name="sigorta[]" id="sigorta_<?= $sigorta_oku['id'] ?>" value="<?= $sigorta_oku['id'] ?>" /><?= $sigorta_oku['sigorta_adi'] ?></label>
							<?php } 
						}
					?>
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
				<div class="general_search_check" id="ihale_turu">
					<?php 						
						$seciliİhaleTuruSayisi = count($_POST['ihale_turu']);		
						if($seciliİhaleTuruSayisi!=0){ 
							$ihale_acik_check="";
							$ihale_kapali_check="";
							for($i=0;$i<count($_POST["ihale_turu"]);$i++){
								if($_POST["ihale_turu"][$i]=="1"){
									$ihale_acik_check="checked";
								}
								if($_POST["ihale_turu"][$i]=="2"){
									$ihale_kapali_check="checked";
								}
							}?>
							<input <?=$ihale_acik_check ?> type="checkbox" id="ihale_tur1" name="ihale_turu[]" value="1" />Açık İhale
							<input <?=$ihale_kapali_check ?> type="checkbox" id="ihale_tur2" name="ihale_turu[]" value="2" />Kapalı İhale
						<?php }else{ ?>
							<input type="checkbox" id="ihale_tur1" name="ihale_turu[]" value="1" />Açık İhale
							<input type="checkbox" id="ihale_tur2" name="ihale_turu[]" value="2" />Kapalı İhale
						<?php }
					?>
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
				<div class="general_search_check" id="markalar" onchange="markaGetir();">
				<input type="text" class="span4" id="marka_filter_input" style="width: 100%;" placeholder="Marka Arayın" onkeyup="search_in_div('filter_marka','marka_filter_input')">
					<?php
						$seciliMarkaSayisi = count($_POST['marka']);
						if($seciliMarkaSayisi!=0){
							$marka_check=array();
							$tu = 0;
							while($marka_oku = mysql_fetch_array($marka_cek)){
								$marka_say = mysql_query("SELECT * FROM ilanlar WHERE durum=1 and marka = '".$marka_oku['markaID']."'");
								$marka_sayi = mysql_num_rows($marka_say);
								$marka_check[$tu]="";
								for($i=0;$i<count($_POST['marka']);$i++){ 
									if($marka_oku["markaID"]==$_POST["marka"][$i]){
										$marka_check[$tu]="checked";
									}
								} ?>
								<label class="filter_marka" style=" <?php /*if($marka_sayi == 0){ echo "display: none;"; }*/ ?>" for="<?= $marka_oku['markaID'] ?>">
								<input type="checkbox" <?=$marka_check[$tu] ?> id="marka_<?= $marka_oku['markaID'] ?>" name="marka[]" value="<?= $marka_oku['markaID'] ?>" /><?= $marka_oku['marka_adi'] ?></label>
							<?php $tu++; }
						?>
						<?php }else{
							while($marka_oku = mysql_fetch_array($marka_cek)){
								$marka_say = mysql_query("SELECT * FROM ilanlar WHERE durum=1 and marka = '".$marka_oku['markaID']."'");
								$marka_sayi = mysql_num_rows($marka_say);
							?>                        
								<label class="filter_marka" style=" <?php /*if($marka_sayi == 0){ echo "display: none;"; }*/ ?>" for="<?= $marka_oku['markaID'] ?>">
								<input type="checkbox" name="marka[]" id="marka_<?= $marka_oku['markaID'] ?>" value="<?= $marka_oku['markaID'] ?>" /><?= $marka_oku['marka_adi'] ?></label>
							<?php } 
						}
					?>
				</div>
			</div>
			<div class="multiselect">
				<div class="selectBox" onclick="showModeller();markaGetir();">
					<select style="height:1.8em;" >
						<option>Modele Göre</option>
					</select>
					<div class="overSelect"></div>
					</div>
				<div class="general_search_check" id="model">				
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
							<div class="modelmarka_<?=$model_oku["marka_id"]?>" style="<?php if($model_sayisi == 0){ echo "display: none;"; } ?>" >
								<input <?=$model_array[$tu] ?> type="checkbox" id="model_<?=$model_oku["model_adi"] ?>" name="model[]" value="<?=$model_oku["model_adi"] ?>" /><?= $model_oku["model_adi"] ?>	
							</div>
						<?php  $tu++;  }  ?>						
					<?php $tu2++; }
					} 
				?>
				
				
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
				<div class="general_search_check" id="tarih">    
				<?php 
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
							<div style="<?php if($ilan_tarihleri_oku["ihale_sayisi"] == 0){ echo "display: none;"; } ?>">
								<input <?=$kapanis_check[$tu]?> type="checkbox" name="tarih[]" id="tarih_<?=$ilan_tarihleri_oku["ihale_tarihi"] ?>" value="<?=$ilan_tarihleri_oku["ihale_tarihi"] ?>" /><?=$tarih ?> 
							</div>
						<?php $tu++; } 
					} else { 
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
								<div style="<?php if($ilan_tarihleri_oku["ihale_sayisi"] == 0){ echo "display: none;"; } ?>">
									<input type="checkbox" name="tarih[]" id="tarih_<?=$ilan_tarihleri_oku["ihale_tarihi"] ?>" value="<?=$ilan_tarihleri_oku["ihale_tarihi"] ?>" /><?=$tarih ?> 
								</div>
							<?php 
							}
						?>
					<?php }  ?>
				</div>
			</div>
			<div class="multiselect">
				<div class="selectBox" onclick="showTeklif()">
					<select style="height:1.8em;">
						<option>Teklif Durumuna Göre</option>
					</select>
					<div class="overSelect"></div>
				</div>
				<div class="general_search_check" id="teklif_durum">           
					<?php 
						$teklif_durum_var_check="";
						$teklif_durum_yok_check="";
						if($_POST["teklif_durum_var"]==1){
							$teklif_durum_var_check="checked";
						}

						if($_POST["teklif_durum_yok"]==0 && $_POST["teklif_durum_yok"]!=NULL ){
							$teklif_durum_yok_check="checked";
						}

					?>
					<input <?=$teklif_durum_var_check ?> type="checkbox" id="teklifdurum_1" name="teklif_durum_var" value="1" />Teklif Verilenler</label><br>	
					<input <?=$teklif_durum_yok_check ?> type="checkbox" id="teklifdurum_0" name="teklif_durum_yok" value="0" />Teklif Verilmeyenler</label>
				</div>
			</div>
			<div class="multiselect">
				<div class="selectBox" onclick="showAracDurumu()">
					<select style="height:1.8em;">
						<option>Araç Durumuna Göre</option>
					</select>
					<div class="overSelect"></div>
				</div>
				<div class="general_search_check" id="aracdurumu"> 
					<?php 


						$seciliAracDurumuSayisi = count($_POST['arac_durumu']);
						
						if($seciliAracDurumuSayisi!=0){ 
							$kazali_checked="";
							$hafif_kazali_checked="";
							$ikinciel_pert_checked="";
							$ikinciel_checked="";

							for($i=0;$i<count($_POST["arac_durumu"]);$i++){
								if($_POST["arac_durumu"][$i]=="1"){
									$kazali_checked="checked";
								}
								if($_POST["arac_durumu"][$i]=="2"){
									$hafif_kazali_checked="checked";
								}
								if($_POST["arac_durumu"][$i]=="3"){
									$ikinciel_pert_checked="checked";
								}
								if($_POST["arac_durumu"][$i]=="4"){
									$ikinciel_checked="checked";
								}
								
							}?>
							<label for="aracdurumu_1">                          
								<input <?=$kazali_checked ?>  id="aracdurumu_1"  type="checkbox" name="arac_durumu[]" value="1" />Kazalı (En Ufak Bir Onarım Görmemiş)
							</label>
							<label for="aracdurumu_2"> 
								<input <?=$hafif_kazali_checked ?>  id="aracdurumu_2" type="checkbox" name="arac_durumu[]" value="2" />Kazalı (Hafif onarımlar yapılmış halk ağzıyla makyajlı)
							</label>
							<label for="aracdurumu_3"> 
								<input <?=$ikinciel_pert_checked ?>  id="aracdurumu_3"  type="checkbox" name="arac_durumu[]" value="3" />İkinci El (Pert Kayıtlı)
							</label>
							<label for="aracdurumu_4"> 
								<input <?=$ikinciel_checked ?>  id="aracdurumu_4"  type="checkbox" name="arac_durumu[]" value="4" />İkinci El (Pert Kayıtsız)
							</label>
					<?php } else { ?>
							<label for="aracdurumu_1">                          
								<input id="aracdurumu_1"  type="checkbox" name="arac_durumu[]" value="1" />Kazalı (En Ufak Bir Onarım Görmemiş)
							</label>
							<label for="aracdurumu_2"> 
								<input id="aracdurumu_2"  type="checkbox" name="arac_durumu[]" value="2" />Kazalı (Hafif onarımlar yapılmış halk ağzıyla makyajlı)
							</label>
							<label for="aracdurumu_3"> 
								<input id="aracdurumu_3"  type="checkbox" name="arac_durumu[]" value="3" />İkinci El (Pert Kayıtlı)
							</label>
							<label for="aracdurumu_4"> 
								<input id="aracdurumu_4"  type="checkbox" name="arac_durumu[]" value="4" />İkinci El (Pert Kayıtsız)
							</label>
					<?php } ?>
				</div>
			</div>
			<div class="multiselect">
				<div class="selectBox" onclick="showProfil()">
					<select style="height:1.8em;">
						<option>Profile Göre</option>
					</select>
					<div class="overSelect"></div>
				</div>
				<div class="general_search_check" id="profil"> 
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
							<label for="Çekme Belgeli/Pert Kayıtlı">                          
								<input <?=$pert_checked ?>  id="profil_pert"  type="checkbox" name="profil[]" value="Çekme Belgeli/Pert Kayıtlı" />Çekme Belgeli/Pert Kayıtlı
							</label><br>
							<label for="Çekme Belgeli"> 
								<input <?=$cekme_checked ?> id="profil_cekme" type="checkbox" name="profil[]" value="Çekme Belgeli" />Çekme Belgeli
							</label><br>
							<label for="Hurda Belgeli"> 
								<input <?=$hurda_checked ?> id="profil_hurda"  type="checkbox" name="profil[]" value="Hurda Belgeli" />Hurda Belgeli
							</label><br>
							<label for="Plakalı"> 
								<input <?=$plakalilar_checked ?> id="profil_plakali"  type="checkbox" name="profil[]" value="Plakalı" />Plakalı
							</label>
						<?php } else { ?>
							<label for="Çekme Belgeli/Pert Kayıtlı">                          
								<input type="checkbox" id="profil_pert" name="profil[]" value="Çekme Belgeli/Pert Kayıtlı" />Çekme Belgeli/Pert Kayıtlı
							</label>
							<label for="Çekme Belgeli"> 
								<input type="checkbox" id="profil_cekme" name="profil[]" value="Çekme Belgeli" />Çekme Belgeli
							</label>
							<label for="Hurda Belgeli"> 
								<input type="checkbox" id="profil_hurda" name="profil[]" value="Hurda Belgeli" />Hurda Belgeli
							</label>
							<label for="Plakalı"> 
								<input type="checkbox" id="profil_plakali" name="profil[]" value="Plakalı" />Plakalı
							</label>
					<?php } ?>
				</div>
			</div>
			<div class="multiselect">
				<div class="selectBox" onclick="showEkleyenAdmin()">
					<select style="height:1.8em;">
						<option>Ekleyen Kişiye Göre</option>
					</select>
				<div class="overSelect"></div>
				</div>
				<div class="general_search_check" id="adminler">
					<?php
						$admin_cek = mysql_query("select * from kullanicilar where durum <> 0");
						$seciliAdminSayisi = count($_POST['adminler']);
						if($seciliAdminSayisi!=0){
							$admin_check=array();
							$tu = 0;
							while($admin_oku = mysql_fetch_array($admin_cek)){
								$admin_check[$tu]="";
								for($i=0;$i<count($_POST['adminler']);$i++){ 
									if($admin_oku["token"]==$_POST["adminler"][$i]){
										$admin_check[$tu]="checked";
									}
								} ?>
								<label for="<?= $admin_oku['token'] ?>">
								<input type="checkbox" <?=$admin_check[$tu] ?> id="admin_<?= $admin_oku['token'] ?>" name="adminler[]" value="<?= $admin_oku['token'] ?>" /><?= $admin_oku['adi']." ".$admin_oku['soyadi'] ?></label>
							<?php $tu++; }
						?>
						<?php }else{
							while($admin_oku = mysql_fetch_array($admin_cek)){?>                        
								<label for="<?= $admin_oku['token'] ?>">
								<input type="checkbox" name="adminler[]" id="admin_<?= $admin_oku['token'] ?>" value="<?= $admin_oku['token'] ?>" /><?= $admin_oku['adi']." ".$admin_oku['soyadi'] ?></label>
							<?php } 
						}
					?>
				</div>
			</div>
		</div>
		<div class="span6">
			<div class="form-check">
				<h5>Yıla Göre</h5>
			</div>
			<div class="form-group">
				<label for="exampleInputEmail1">En düşük</label>
					<?php
						if($_POST["kucuk_yil"]!=""){ ?>
							<input type="text" id="kucuk_yil" name="kucuk_yil" value="<?=$_POST["kucuk_yil"] ?>" class="form-control">
						<?php }else{ ?>
							<input type="text" id="kucuk_yil" name="kucuk_yil" class="form-control">
						<?php } 
					?>
			</div>
			<div class="form-group">
				<label for="exampleInputPassword1">En yüksek</label>
				<?php
					if($_POST["buyuk_yil"]!=""){ ?>
						<input type="text" id="buyuk_yil" name="buyuk_yil" value="<?=$_POST["buyuk_yil"] ?>" class="form-control">
					<?php }else{ ?>
						<input type="text" id="buyuk_yil" name="buyuk_yil" class="form-control">
					<?php } 
				?>
			</div>
			<div class="form-check">
				<h5>Kapanış Tarihine Göre</h5>
			</div>
			<div class="form-group">
				<label for="exampleInputEmail1">Küçük Tarih</label>
				<?php
					if($_POST["kucuk_kapanis"]!=""){ ?>
						<input type="date" id="kucuk_kapanis" name="kucuk_kapanis" value="<?=$_POST["kucuk_kapanis"] ?>" class="form-control">
					<?php }else{ ?>
						<input type="date" id="kucuk_kapanis" name="kucuk_kapanis" class="form-control">
					<?php } 
				?>
			</div>
			<div class="form-group">
				<label for="exampleInputPassword1">Büyük Tarih</label>
				<?php
					if($_POST["buyuk_kapanis"]!=""){ ?>
						<input type="date" id="buyuk_kapanis" name="buyuk_kapanis" value="<?=$_POST["buyuk_kapanis"] ?>" class="form-control">
					<?php }else{ ?>
						<input type="date" id="buyuk_kapanis" name="buyuk_kapanis" class="form-control">
					<?php } 
				?>
			</div>
			<div class="form-check">
				<h5>Ekleme Tarihine Göre</h5>
			</div>
			<div class="form-group">
				<label for="exampleInputEmail1">Küçük Tarih</label>
				<?php
					if($_POST["kucuk_ekleme"]!=""){ ?>
						<input type="date" id="kucuk_ekleme" name="kucuk_ekleme" value="<?=$_POST["kucuk_ekleme"] ?>" class="form-control">
					<?php }else{ ?>
						<input type="date" id="kucuk_ekleme" name="kucuk_ekleme" class="form-control">
					<?php } 
				?>
			</div>
			<div class="form-group">
				<label for="exampleInputPassword1">Büyük Tarih</label>
				<?php
					if($_POST["buyuk_ekleme"]!=""){ ?>
						<input type="date" id="buyuk_ekleme" name="buyuk_ekleme" value="<?=$_POST["buyuk_ekleme"] ?>" class="form-control">
					<?php }else{ ?>
						<input type="date" id="buyuk_ekleme" name="buyuk_ekleme" class="form-control">
					<?php } 
				?>
			</div>
		</div>
	</div>
	<button type="submit" name="filtrele" id="filtrele" class="btn blue">Ara</button>
</form>

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
<?php 
if(isset($_POST['filtrele'])){    
	$filtreleme = 1;
}else{
	$filtreleme = 0;
}
?>
<input type="hidden" id="filtreleme_durum" value="<?= $filtreleme ?>">

<?php 

if(isset($_POST['filtrele'])){    
	$filtreler="";                
	$f_arama_kriteri = $_POST['arama_kriteri'];     
	$f_kelime = $_POST['aranan'];     
	$f_marka = $_POST['marka'];
	$f_model = $_POST['model'];
	$f_sehir = $_POST['sehir'];
	$f_tarih = $_POST['tarih'];
	$f_profil = $_POST['profil'];
	$f_aracdurumu = $_POST['arac_durumu'];
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
	$where = "WHERE id > '0'";
	$filtre_var="false";
	
	if($f_kelime !=""){
		$where .= "AND concat(plaka,model,arac_kodu,model_yili,sehir,ilce,hesaplama,hasar_bilgileri,notlar,uyari_notu,kilometre,adres,donanimlar,tip) LIKE '%".$f_kelime."%' ";
		
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
	
	if($f_arama_kriteri!="" && $f_kucuk_kapanis =="" && $f_buyuk_kapanis =="" && $f_kucuk_ekleme =="" && $f_buyuk_ekleme ==""){
		if(re('kucuk_ekleme') =="" && re('buyuk_ekleme') =="" && re('kucuk_kapanis') =="" && re('buyuk_kapanis') ==""){
			$filtre_var="true";
			$t = 0;
			$arama_where="";
			$seciliAramaKriteriSayisi = count($_POST['arama_kriteri']);
			while ($t < $seciliAramaKriteriSayisi) {
				if($_POST["arama_kriteri"][$t]=="1"){
					$arama_where.=" durum=1 ";//İhalesi devam edenler
					$arama_krt="İhalesi devam edenler";
				}else if($_POST["arama_kriteri"][$t]=="2"){
					$arama_where.=" ihale_tarihi = '".date("Y-m-d")."' ";//Bügun bitecekler
					$arama_krt="Bugün bitecekler";
				}else if($_POST["arama_kriteri"][$t]=="3"){
					$arama_where.=" ihale_tarihi = '".date("Y-m-d",strtotime('+1 days'))."' ";//Yarın bitecekler
					$arama_krt="Yarın bitecekler";
				}else if($_POST["arama_kriteri"][$t]=="4"){
					$arama_where.=" durum=-1 ";//İhalesi bitenler
					$arama_krt="İhalesi bitenler";
				}else if($_POST["arama_kriteri"][$t]=="5"){
					$arama_where.=" date(eklenme_zamani) = '".date("Y-m-d")."' "; //Bugün Eklenenler
					$arama_krt="Bugün eklenenler";
				}else if($_POST["arama_kriteri"][$t]=="6"){
					$arama_where.=" id=(select ilan_id from kazanilan_ilanlar where kazanilan_ilanlar.ilan_id=ilanlar.id) ";//Statü atanmışsa
					$arama_krt="Statüsü atanlar";
				}else if($_POST["arama_kriteri"][$t]=="7"){
					$arama_where="  "; //Tümü
					$arama_krt="Tümü";
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
				
				$onclick=''; 
				$onclick='onclick="filtre_cikar(\'aramakriteri_\',\''.$_POST["arama_kriteri"][$t].'\')"';
				
				$filtreler.='<div class="filter_box">
						Arama Kriteri: '.$arama_krt.'
						<div '.$onclick.' class="filter_box_close">
							x
						</div>
					</div>';
				$t++;
			}
			$where.="AND ( ".$arama_where." )";	
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
		$where = $where . " AND sehir in (". $seciliSehir . ")";
	}
	
	if($f_sigorta_sirketi !=""){
		$filtre_var="true";
		$si = 0;
		$secili_sigorta = count($_POST['sigorta']);
		$seciliSigorta = "";
		while ($si < $secili_sigorta) {
			$onclick='';
			$onclick='onclick="filtre_cikar(\'sigorta_\',\''.$_POST["sigorta"][$si].'\')"';
			$sigorta_ad_cek = mysql_query("select * from sigorta_ozellikleri where id = '".$_POST["sigorta"][$si]."'");
			$sigorta_ad_oku = mysql_fetch_object($sigorta_ad_cek);
			$sigorta_adi_filtre = $sigorta_ad_oku->sigorta_adi;
			$filtreler.='
				<div class="filter_box">
					'.$sigorta_adi_filtre.'
					<div '.$onclick.' class="filter_box_close">
						x
					</div>
				</div>	
			';
			$seciliSigorta = $seciliSigorta . "'" . $_POST['sigorta'][$si] . "'";
			if ($si < $secili_sigorta - 1) {
				$seciliSigorta = $seciliSigorta . ", ";
			}
			$si ++;
		}
		$where = $where . " AND sigorta in (" . $seciliSigorta . ")";
	}

	if($f_marka !=""){       
		$filtre_var="true";
		$k = 0;
		$seciliMarkaSayisi = count($_POST['marka']);
		$seciliMarka = "";
		while ($k < $seciliMarkaSayisi) {
			$markala=mysql_query("select * from marka where markaID='".$_POST["marka"][$k]."'");
			$markala_oku=mysql_fetch_assoc($markala);
			
			$onclick=''; 
			$onclick='onclick="filtre_cikar(\'marka_\',\''.$_POST["marka"][$k].'\')"';
			$filtreler.='
				<div class="filter_box">
					'.$markala_oku["marka_adi"].'
					<div '.$onclick.' class="filter_box_close">
						x
					</div>
				</div>	
			';
			$seciliMarka = $seciliMarka . "'" . $_POST['marka'][$k] . "'";
			if ($k < $seciliMarkaSayisi - 1) {
				$seciliMarka = $seciliMarka . ", ";
			}
			$k ++;
		}
		$where = $where . " AND marka in (" . $seciliMarka . ") ";
	}

	if($f_kucuk_kapanis == "" && $f_buyuk_kapanis == "" && $f_kucuk_ekleme == "" && $f_buyuk_ekleme == ""){
		$sadece_model = 1;
	}else{
		$sadece_model = 0;
	}
	
	if($sadece_model == 1){
		if($f_model !=""){       
			$filtre_var="true";
			$k = 0;
			$seciliModelSayisi = count($_POST['model']);
			$seciliModel = "";
			while ($k < $seciliModelSayisi) {
				
				$onclick=''; 
				$onclick='onclick="filtre_cikar(\'model_\',\''.$_POST["model"][$k].'\')"';
				$filtreler.='
					<div class="filter_box">
						'.$_POST["model"][$k].'
						<div '.$onclick.' class="filter_box_close">
							x
						</div>
					</div>	
				';
				$seciliModel = $seciliModel . "'" . $_POST['model'][$k] . "'";
				if ($k < $seciliModelSayisi - 1) {
					$seciliModel = $seciliModel . ", ";
				}
				$k ++;
			}
			$where = $where . " AND model in (" . $seciliModel . ") and ihale_son_gosterilme >= '".date('Y-m-d H:i:s')."'";
		}
	}else{
		if($f_model !=""){       
			$filtre_var="true";
			$k = 0;
			$seciliModelSayisi = count($_POST['model']);
			$seciliModel = "";
			while ($k < $seciliModelSayisi) {
				
				$onclick=''; 
				$onclick='onclick="filtre_cikar(\'model_\',\''.$_POST["model"][$k].'\')"';
				$filtreler.='
					<div class="filter_box">
						'.$_POST["model"][$k].'
						<div '.$onclick.' class="filter_box_close">
							x
						</div>
					</div>	
				';
				$seciliModel = $seciliModel . "'" . $_POST['model'][$k] . "'";
				if ($k < $seciliModelSayisi - 1) {
					$seciliModel = $seciliModel . ", ";
				}
				$k ++;
			}
			$where = $where . " AND model in (" . $seciliModel . ") ";
		}
	}
	

	
	
	if($f_tarih !=""){
		$filtre_var="true";
		$t = 0;
		$seciliTarihSayisi = count($_POST['tarih']);
		$seciliTarih = "";
		while ($t < $seciliTarihSayisi) {
			$onclick='';					
			$onclick='onclick="filtre_cikar(\'tarih_\',\''.$_POST['tarih'][$t].'\')"';
			$filtreler.='
				<div class="filter_box">
					'.date("d-m-Y",strtotime($_POST['tarih'][$t])).'
					<div '.$onclick.' class="filter_box_close">
						x
					</div>
				</div>	
			';
			$seciliTarih = $seciliTarih . "'" . $_POST['tarih'][$t] . "'";
			if ($t < $seciliTarihSayisi - 1) {
				$seciliTarih = $seciliTarih . ", ";
			}
			$t ++;
		}
		$where = $where . " AND ihale_tarihi in (" . $seciliTarih . ")";
	}
	
	if($f_teklif_var != "" && $f_teklif_yok == ""){
		$onclick='';
		$filtre_var="true";
		$onclick='onclick="filtre_cikar(\'teklifdurum_\',\''.$_POST['teklif_durum_var'].'\')"';
		$filtreler.='
			<div class="filter_box">
				Teklif Verilenler
				<div '.$onclick.' class="filter_box_close">
					x
				</div>
			</div>	
		';
		// $where .= "AND son_teklif > 0 ";
	}elseif($f_teklif_yok != "" && $f_teklif_var == ""){
		$onclick='';
		$filtre_var="true";
		$onclick='onclick="filtre_cikar(\'teklifdurum_\',\''.$_POST['teklif_durum_yok'].'\')"';
		$filtreler.='
			<div class="filter_box">
				Teklif Verilmeyenler
				<div '.$onclick.' class="filter_box_close">
					x
				</div>
			</div>	
		';
		// $where .= "AND son_teklif = '0' ";
	}elseif($f_teklif_yok != "" && $f_teklif_var != ""){
		$filtre_var="true";
		$onclick='onclick="filtre_cikar(\'teklifdurum_\',\''.$_POST['teklif_durum_var'].'\')"';
		$filtreler.='
			<div class="filter_box">
				Teklif Verilenler
				<div '.$onclick.' class="filter_box_close">
					x
				</div>
			</div>	
		';
		$onclick2='onclick="filtre_cikar(\'teklifdurum_\',\''.$_POST['teklif_durum_yok'].'\')"';
		$filtreler.='
			<div class="filter_box">
				Teklif Verilmeyenler
				<div '.$onclick2.' class="filter_box_close">
					x
				</div>
			</div>	
		';
	}
	

	if($f_ihale_turu !=""){
		$filtre_var="true";
		$ihale = 0;
		$seciliİhaleSayisi = count($_POST['ihale_turu']);
		$seciliİhale = "";
		while ($ihale < $seciliİhaleSayisi) {

			$onclick='';
			if($_POST['ihale_turu'][$ihale] == 1)
			{
				$onclick='onclick="filtre_cikar(\'ihale_tur\',\''.$_POST["ihale_turu"][$ihale].'\')"';
				$filtreler.='
					<div class="filter_box">
						 Açık Arttırma 
						<div '.$onclick.' class="filter_box_close">
							x
						</div>
					</div>	
				';  
			}
			if($_POST['ihale_turu'][$ihale] == 2)
			{
				$onclick='onclick="filtre_cikar(\'ihale_tur\',\''.$_POST["ihale_turu"][$ihale].'\')"';
				$filtreler.='
					<div class="filter_box">
						 Kapalı Arttırma 
						<div '.$onclick.' class="filter_box_close">
							x
						</div>
					</div>	
				';  

			}
			$seciliİhale = $seciliİhale . "'" . $_POST['ihale_turu'][$ihale] . "'";
			if ($ihale < $seciliİhaleSayisi - 1) {
				$seciliİhale = $seciliİhale . ", ";
			}
			$ihale ++;
		}
		$where = $where . " AND ihale_turu in (" . $seciliİhale . ")";
	}
	
	if($f_adminler !=""){
		$filtre_var="true";
		$tm = 0;
		$secili_adminler = count($_POST['adminler']);
		$seciliAdminler = "";
		while ($tm < $secili_adminler) {
			$admin_read=mysql_query("select * from kullanicilar where token='".$_POST["adminler"][$tm]."'");
			$admin_fetch=mysql_fetch_assoc($admin_read);

			$onclick='';
			$onclick='onclick="filtre_cikar(\'admin_\',\''.$_POST["adminler"][$tm].'\')"';
			$filtreler.='
				<div class="filter_box">
					'.$admin_fetch['adi']." ".$admin_fetch['soyadi'].'
					<div '.$onclick.' class="filter_box_close">
						x
					</div>
				</div>	
			';
			
			$seciliAdminler = $seciliAdminler . "'" . $_POST['adminler'][$tm] . "'";
			if ($tm < $secili_adminler - 1) {
				$seciliAdminler = $seciliAdminler . ", ";
			}
			$tm ++;
		}
		// $where = $where . " AND ihale_sahibi in (" . $seciliAdminler . ") and ihale_son_gosterilme >= '".date('Y-m-d H:i:s')."'";
		$where = $where . " AND ihale_sahibi in (" . $seciliAdminler . ")";
	}
	
	if($f_aracdurumu !=""){
		$filtre_var="true";
		$p = 0;
		$seciliAracDurumuSayisi = count($_POST['arac_durumu']);
		$seciliAracDurumu = "";
		while ($p < $seciliAracDurumuSayisi) {
			$onclick='';
			$post_aracdurumu="";
			if($_POST["arac_durumu"][$p]=="1"){
				$post_aracdurumu="Kazalı (En Ufak Bir Onarım Görmemiş)";
			}
			if($_POST["arac_durumu"][$p]=="2"){
				$post_aracdurumu="Kazalı (Hafif onarımlar yapılmış halk ağzıyla makyajlı)";
			}
			if($_POST["arac_durumu"][$p]=="3"){
				$post_aracdurumu="Kazalı (Hafif onarımlar yapılmış halk ağzıyla makyajlı)";
			}
			if($_POST["arac_durumu"][$p]=="4"){
				$post_aracdurumu="İkinci El (Pert Kayıtsız)";
			}
			$onclick='onclick="filtre_cikar(\'aracdurumu_\',\''. $_POST['arac_durumu'][$p].'\')"';
			$filtreler.='
				<div class="filter_box">
					'.$post_aracdurumu.'
					<div '.$onclick.' class="filter_box_close">
						x
					</div>
				</div>	
			';  
			$seciliAracDurumu = $seciliAracDurumu . "'" . $_POST['arac_durumu'][$p] . "'";
			if ($p < $seciliAracDurumuSayisi - 1) {
				$seciliAracDurumu = $seciliAracDurumu . ", ";
			}
			$p ++;
		}
		$where = $where . " AND arac_durumu in (" . $seciliAracDurumu . ")";
	}
	
	if($f_profil !=""){
		$filtre_var="true";
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
			$onclick='onclick="filtre_cikar(\'profil_\',\''.$post_profil.'\')"';
			$filtreler.='
				<div class="filter_box">
					'.$_POST["profil"][$p].'
					<div '.$onclick.' class="filter_box_close">
						x
					</div>
				</div>	
			';  
			$seciliProfil = $seciliProfil . "'" . $_POST['profil'][$p] . "'";
			if ($p < $seciliProfilSayisi - 1) {
				$seciliProfil = $seciliProfil . ", ";
			}
			$p ++;
		}
		$where = $where . " AND profil in (" . $seciliProfil . ")";
	}

	

	if($f_kucuk_yil !="" && $f_buyuk_yil !=""){
		$onclick="";
		$filtre_var="true";
		$onclick='onclick="filtre_cikar(\'yil_\',\'filtre\')";';
		$filtreler.='
			<div class="filter_box">
				Model Yılı: '.$f_kucuk_yil.' - '.$f_buyuk_yil.'
				<div '.$onclick.' class="filter_box_close">
					x
				</div>
			</div>	
		';
		
		$where .= "AND  model_yili BETWEEN $f_kucuk_yil AND $f_buyuk_yil ";
	}
	
	
	if($f_kucuk_kapanis !="" && $f_buyuk_kapanis !=""){
		$onclick="";
		$filtre_var="true";
		$onclick='onclick="filtre_cikar(\'kucukbuyuk_\',\'kapanis\')";';
		$filtreler.='
			<div class="filter_box">
				Kapanış Tarihi: '.date("d-m-Y",strtotime($f_kucuk_kapanis)).' - '.date("d-m-Y",strtotime($f_buyuk_kapanis)).'
				<div '.$onclick.' class="filter_box_close">
					x
				</div>
			</div>	
		';
		$where .= "AND  ihale_tarihi BETWEEN '".date($f_kucuk_kapanis)."' AND '".date($f_buyuk_kapanis)."'";
	}else if($f_kucuk_kapanis !="" && $f_buyuk_kapanis ==""){
		$onclick="";
		$filtre_var="true";
		$onclick='onclick="filtre_cikar(\'kucuk_\',\'kapanis\')";';
		$filtreler.='
			<div class="filter_box">
				Kapanış Tarihi: '.date("d-m-Y",strtotime($f_kucuk_kapanis)).' -
				<div '.$onclick.' class="filter_box_close">
					x
				</div>
			</div>	
		';
		$where .= "AND  ihale_tarihi >='".date($f_kucuk_kapanis)."'";
	}else if($f_kucuk_kapanis =="" && $f_buyuk_kapanis !=""){
		$onclick="";
		$filtre_var="true";
		$onclick='onclick="filtre_cikar(\'kucuk_\',\'kapanis\')";';
		$filtreler.='
			<div class="filter_box">
				Kapanış Tarihi: - '.date("d-m-Y",strtotime($f_buyuk_kapanis)).'
				<div '.$onclick.' class="filter_box_close">
					x
				</div>
			</div>	
		';
		$where .= "AND ihale_tarihi <='".date($f_buyuk_kapanis)."'";
	}
	
	
	if($f_kucuk_ekleme !="" && $f_buyuk_ekleme !=""){
		$filtre_var="true";
		$onclick='onclick="filtre_cikar(\'kucukbuyuk_\',\'ekleme\')";';
		$filtreler.='
			<div class="filter_box">
				Ekleme tarih: '.date("d-m-Y",strtotime($f_kucuk_ekleme)).' - '.date("d-m-Y",strtotime($f_buyuk_ekleme)).'
				<div '.$onclick.' class="filter_box_close">
					x
				</div>
			</div>	
		';		
		$where .= "AND date(eklenme_zamani) BETWEEN '".date($f_kucuk_ekleme)."' AND '".date($f_buyuk_ekleme)."'";
	}else if($f_kucuk_ekleme !="" && $f_buyuk_ekleme ==""){
		$filtre_var="true";
		$onclick='onclick="filtre_cikar(\'kucuk_\',\'ekleme\')"';
		$filtreler.='
			<div class="filter_box">
				Ekleme tarihi: '.date("d-m-Y",strtotime($f_kucuk_ekleme)).' -
				<div '.$onclick.' class="filter_box_close">
					x
				</div>
			</div>	
		';
		$where .= "AND  date(eklenme_zamani) >='".date($f_kucuk_ekleme)."'";
	}else if($f_kucuk_ekleme =="" && $f_buyuk_ekleme !=""){
		$filtre_var="true";
		$onclick='onclick="filtre_cikar(\'kucuk_\',\'ekleme\')"';
		$filtreler.='
			<div class="filter_box">
				Ekleme tarihi: - '.date("d-m-Y",strtotime($f_buyuk_ekleme)).'
				<div '.$onclick.' class="filter_box_close">
					x
				</div>
			</div>	
		';
		$where .= "AND  date(eklenme_zamani) <= '".date($f_buyuk_ekleme)."'";
	}
	
	$filtre_cek = "SELECT * FROM ilanlar $where  ORDER BY concat(ihale_tarihi,' ',ihale_saati) asc";
	// var_dump("SELECT * FROM ilanlar $where  ORDER BY concat(ihale_tarihi,' ',ihale_saati) asc");
	$result = mysql_query($filtre_cek) or die(mysql_error());
	
	$sayi = mysql_num_rows($result);
	
	
	if($sayi==0){
		echo '<script type="text/javascript">'; 
		echo 'alert("İstediğiniz kriterlere uygun araç bulunamadı.");'; 
		echo 'window.location.href = "?modul=ihaleler&sayfa=tum_ihaleler";';
		echo '</script>';                       
	}else{ ?>
	
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

	
	<form method="POST" action="?modul=ihaleler&sayfa=toplu_sil" onsubmit="return confirm('SEÇİLİ İLANLARI SİLMEK İSTEDİĞİNİZE EMİN MİSİNİ?');">
		<?php
			$admin_yetki_cek=mysql_query("Select * from kullanicilar where id='".$admin_id."' ");
			$admin_yetki_oku=mysql_fetch_assoc($admin_yetki_cek);
			$yetkiler=$admin_yetki_oku["yetki"];
			$yetki_parcala=explode("|",$yetkiler);

			$btn='';
			$btn2='';
			if (in_array(2, $yetki_parcala) && in_array(1, $yetki_parcala) ) { 
			  $btn='<input type="submit" name="secili_sil" class="btn-danger" value="Seçili Olanları Sil">';
			  $btn2='<input type="button" name="secili_uzat" class="view_secili_ilan_sure_uzat btn-primary" value="Seçili Olanların Süresini Uzat">';
			}  else if(in_array(2, $yetki_parcala) && !in_array(1, $yetki_parcala)){
				$btn='<input type="submit" name="secili_sil" class="btn-danger" value="Seçili Olanları Sil">';
			    $btn2='';
			} else if(!in_array(2, $yetki_parcala) && in_array(1, $yetki_parcala)){
				$btn='';
			    $btn2='<input type="button" name="secili_uzat" class="view_secili_ilan_sure_uzat btn-primary" value="Seçili Olanların Süresini Uzat">';
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
			<table id="tum_ihaleler_table" class="table table-bordered table-striper" style="width:100%!important;">
				<thead>
					<tr>
						<!--<td>Seç</td>-->
						<td><input type="checkbox" id="checkle" class="checkall btn btn-blue chec2" style="padding:20px;opacity:1!important; z-index:999;">Seç</td>
						<td>Düzenle</td>
						<td>Görseller</td>
						<td>Kod</td>
						<td>Plaka</td>
						<td>İl Adı</td>
						<td>Detaylar</td>
						<td>Sayaç</td>
						<td>Kapanış Zamanı</td>
						<td>En Yüksek</td>
						<td>Teklif</td>
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
					$ilan_yeni_durum = 1;
					/*
					$ilan_bitis=$filtre_oku["ihale_tarihi"]." ".$filtre_oku["ihale_saati"];
					if($ilan_bitis > date('Y-m-d H:i:s')){
						$ilan_yeni_durum = 1;
					}else{
						if($ilan_bitis<date("Y-m-d H:i:s") && $toplam_teklif == 0){
							$ilan_yeni_durum = 0;
						}else{			
							$new_time = date("Y-m-d H:i:s", strtotime('+5 minutes', strtotime($ilan_bitis)));		
							if($toplam_teklif == 0){
								$ilan_yeni_durum = 0;
							}else{
								if($new_time > date('Y-m-d H:i:s')){
									$ilan_yeni_durum = 1;					
								}else{
									$ilan_yeni_durum = 0;
								}
							}
						}
					}
					$ilan_yeni_durum = 1;
					*/
					
					/*
					if($_POST["arama_kriteri"] != ""){
						if(re('kucuk_ekleme') =="" && re('buyuk_ekleme') =="" && re('kucuk_kapanis') =="" && re('buyuk_kapanis') ==""){
							$arama_kriter_array = $_POST["arama_kriteri"];
							if (in_array("7", $arama_kriter_array)) {
								$ilan_yeni_durum = 1;
							}elseif(in_array("6", $arama_kriter_array)){
								$ilan_id = $filtre_oku["id"];
								$statu_say = mysql_num_rows(mysql_query("select * from kazanilan_ilanlar where ilan_id = '".$ilan_id."'"));
								if($statu_say != 0){
									$ilan_yeni_durum = 1;
								}else{
									$ilan_yeni_durum = 0;
								}
							}elseif(in_array("5", $arama_kriter_array)){
								$eklenme_zamani = $filtre_oku["eklenme_zamani"];
								$dt = new DateTime($eklenme_zamani);
								$date = $dt->format('Y-m-d');
								$today = date('Y-m-d');
								if($today == $date){
									$ilan_yeni_durum = 1;
								}else{
									$ilan_yeni_durum = 0;
								}
							}elseif(in_array("4", $arama_kriter_array)){
								$ilan_bitis=$filtre_oku["ihale_tarihi"]." ".$filtre_oku["ihale_saati"];
								if($ilan_bitis < date('Y-m-d H:i:s')){
									$ilan_yeni_durum = 1;
								}else{
									$ilan_yeni_durum = 0;
								}
							}elseif(in_array("3", $arama_kriter_array)){
								$datetime = new DateTime('tomorrow');
								$yarin = $datetime->format('Y-m-d');
								if($filtre_oku["ihale_tarihi"] == $yarin){
									$ilan_yeni_durum = 1;
								}else{
									$ilan_yeni_durum = 0;
								}
							}elseif(in_array("2", $arama_kriter_array)){
								if($filtre_oku["ihale_tarihi"] == date('Y-m-d')){
									$ilan_yeni_durum = 1;
								}else{
									$ilan_yeni_durum = 0;
								}
							}elseif(in_array("1", $arama_kriter_array)){
								$ilan_bitis=$filtre_oku["ihale_tarihi"]." ".$filtre_oku["ihale_saati"];
								if($ilan_bitis > date('Y-m-d H:i:s')){
									$ilan_yeni_durum = 1;
								}else{
									$ilan_yeni_durum = 0;
								}
							}
						}						
					}else{
						$ilan_yeni_durum = 1;
					}
					*/

					if(re('kucuk_ekleme') !="" || re('buyuk_ekleme') !="" || re('kucuk_kapanis') !="" || re('buyuk_kapanis') !=""){
						$ilan_yeni_durum = 1;
					}else{
						if($_POST["arama_kriteri"] == ""){
							$ilan_bitis=$filtre_oku["ihale_tarihi"]." ".$filtre_oku["ihale_saati"];
							if($ilan_bitis > date('Y-m-d H:i:s')){
								$ilan_yeni_durum = 1;
							}else{
								if($ilan_bitis<date("Y-m-d H:i:s") && $toplam_teklif == 0){
									$ilan_yeni_durum = 0;
								}else{			
									$new_time = date("Y-m-d H:i:s", strtotime('+5 minutes', strtotime($ilan_bitis)));		
									if($toplam_teklif == 0){									
										$ilan_yeni_durum = 0;
									}else{
										if($new_time > date('Y-m-d H:i:s')){
											$ilan_yeni_durum = 1;					
										}else{
											$ilan_yeni_durum = 0;
										}
									}							
								}
							}
						}						
					}
					
					if(re('teklif_durum_var') != "" && re('teklif_durum_yok') != ""){
						if(re('kucuk_ekleme') =="" && re('buyuk_ekleme') =="" && re('kucuk_kapanis') =="" && re('buyuk_kapanis') ==""){
							if($ilan_bitis > date('Y-m-d H:i:s')){
								$ilan_yeni_durum = 1;
							}else{
								$ilan_yeni_durum = 0;
							}
						}else{
							$ilan_yeni_durum = 1;
						}					
					}elseif(re('teklif_durum_var') != "" && re('teklif_durum_yok') == ""){						
						if($toplam_teklif>0){		
							if(re('kucuk_ekleme') =="" && re('buyuk_ekleme') =="" && re('kucuk_kapanis') =="" && re('buyuk_kapanis') ==""){
								if($ilan_bitis > date('Y-m-d H:i:s')){
									$ilan_yeni_durum = 1;
								}else{
									$ilan_yeni_durum = 0;
								}
							}else{
								$ilan_yeni_durum = 1;
							}					
						}else{
							$ilan_yeni_durum = 0;
						}
					}elseif(re('teklif_durum_var') == "" && re('teklif_durum_yok') != ""){
						if($toplam_teklif>0){
							$ilan_yeni_durum = 0;
						}else{
							if(re('kucuk_ekleme') =="" && re('buyuk_ekleme') =="" && re('kucuk_kapanis') =="" && re('buyuk_kapanis') ==""){
								if($ilan_bitis > date('Y-m-d H:i:s')){
									$ilan_yeni_durum = 1;
								}else{
									$ilan_yeni_durum = 0;
								}
							}else{
								$ilan_yeni_durum = 1;
							}
						}
					}

					// $ilan_yeni_durum = 1;
					if($ilan_yeni_durum == 1 && $filtre_oku["durum"] != 2){
						if($toplam_teklif>0){
							if($statu_oku['durum'] == "0" || $statu_oku['durum'] == "1" || $statu_oku['durum'] == "2" || $statu_oku['durum'] == "3" || $statu_oku['durum'] == "4"){
								$tablo_rengi = "#1b8d3d"; //Koyu yeşil
								$ihale_trh=$filtre_oku["ihale_tarihi"];
								$ihale_st=$filtre_oku["ihale_saati"];
								$srgl=mysql_query("select ilanlar.* from ilanlar inner join teklifler on teklifler.ilan_id=ilanlar.id where ilanlar.id = '".$filtre_oku["id"]."' and ilanlar.durum=1 and ilanlar.ihale_tarihi='".$ihale_trh."' and ilanlar.ihale_saati='".$ihale_st."' and teklifler.durum=1 group by ilanlar.id");							//
								if(mysql_num_rows($srgl)>0){
									while($oku=mysql_fetch_object($srgl)){
										if(!in_array($oku->id,$filtre_array)){
											array_push($filtre_array,$oku->id);
											
											$tarih_ihale=$oku->ihale_tarihi.' '. $oku->ihale_saati;
											$kapanis_zamani=date("d-m-Y H:i:s", strtotime($oku->ihale_tarihi. " ". $oku->ihale_saati));

											$teklifler=mysql_query("select * from teklifler where ilan_id='".$oku->id."' and durum=1 order by teklif_zamani desc ");
											$toplam_teklif = mysql_num_rows($teklifler);
												
											// $mesaj_cek = mysql_query("SELECT * FROM mesajlar WHERE ilan_id = '".$oku->id."' ");
											// $mesaj_sayi = mysql_num_rows($mesaj_cek);
											$mesaj_sayi = okunmamis_mesaj_sayi($filtre_oku["id"]);
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
												$t_color="color:#fff !important;";
												$color="#fff !important";
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
													<td style="font-weight:bold;" class="kapanis2_zamani'.$sira.'" id="sayac'.$sira.'">
														<input type="hidden" id="ihale_sayac'.$sira.'" value="'.$tarih_ihale.'" >
														<input type="hidden" id="id_'.$sira.'" value="'.$oku->id.'">
													</td> 
													<td>
														<a style="cursor: pointer;'.$t_color.'" class="view_guncelle kapanis_zamani'.$sira.'" id="'.$oku->id.'">'.$kapanis_zamani.'</a>
													</td>
													<td class="'.$yan.'">
														<a class="view_uyeye_teklif_ver" style="font-size:19px; font-weight:bold;'.$t_color.'" id="sonteklif_'.$oku->id.'">
															'.money($oku->son_teklif).'₺
															</a>
													</td>   
													<!-- <td class="'.$yan.'">'.$oku->son_teklif.'</td>     -->
													<input type="hidden" id="teklif_sayisi'.$sira.'" value="'.$toplam_teklif.'" >
													<td><a style="'.$t_color.'" class="view_ilan_teklifleri" id="teklifler_'.$oku->id.'"><i class="fas fa-gavel">'.$toplam_teklif.'</i></a></td>    
													<td><a style="'.$t_color.'" class="view_ilan_mesajlari" id="mesajlar_'.$oku->id.'"><i class="fas fa-envelope">'.$mesaj_sayi.'</i></a></td>    
													<td><a style="'.$t_color.'" class="view_ilan_favorileri" id="'.$oku->id.'"><i class="fas fa-heart">'.$favori_sayi.'</i></a></td>    
													<td id="td_view_ilan_notlari_'.$oku->id.'"><a style="'.$t_color.'" class="view_ilan_notlari" id="'.$oku->id.'"><i class="fas fa-align-justify">'.$not_sayi.'</i></a></td>    
													<td>'.$sgrt_adi.'</td>
												</tr>
											';
											$sira++;
										}
									}
								}else{
									
									if(!in_array($filtre_oku['id'],$filtre_array)){
										
										
										$tarih_ihale=$filtre_oku['ihale_tarihi'].' '. $filtre_oku["ihale_saati"];
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
												<td style="font-weight:bold;" class="kapanis2_zamani'.$sira.'" id="sayac'.$sira.'">
													<input type="hidden" id="ihale_sayac'.$sira.'" value="'.$tarih_ihale.'" >
													<input type="hidden" id="id_'.$sira.'" value="'.$filtre_oku['id'].'">
												</td> 
												<td>
													<a style="cursor: pointer;'.$t_color.'" class="view_guncelle kapanis_zamani'.$sira.'" id="'.$filtre_oku['id'].'">'.$kapanis_zamani.'</a>
												</td>
												<td class="'.$yan.'"><a style="font-size:19px; font-weight:bold;'.$t_color.'" class="view_uyeye_teklif_ver" id="sonteklif_'.$filtre_oku['id'].'">'.money($filtre_oku["son_teklif"]).'₺</a></td>   
												<!-- <td class="'.$yan.'">'.$filtre_oku["son_teklif"].'</td>     -->
												<input type="hidden" id="teklif_sayisi'.$sira.'" value="'.$toplam_teklif.'" >
												<td><a style="'.$t_color.'" class="view_ilan_teklifleri" id="teklifler_'.$filtre_oku['id'].'"><i class="fas fa-gavel">'.$toplam_teklif.'</i></a></td>    
												<td><a style="'.$t_color.'" class="view_ilan_mesajlari" id="mesajlar_'.$filtre_oku['id'].'"><i class="fas fa-envelope">'.$mesaj_sayi.'</i></a></td>    
												<td><a style="'.$t_color.'" class="view_ilan_favorileri" id="'.$filtre_oku['id'].'"><i class="fas fa-heart">'.$favori_sayi.'</i></a></td>    
												<td id="td_view_ilan_notlari_'.$filtre_oku['id'].'"><a style="'.$t_color.'" class="view_ilan_notlari" id="'.$filtre_oku['id'].'"><i class="fas fa-align-justify">'.$not_sayi.'</i></a></td>    
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
												
												
												// $mesaj_cek = mysql_query("SELECT * FROM mesajlar WHERE ilan_id = '".$oku->id."' ");
												// $mesaj_sayi = mysql_num_rows($mesaj_cek);
												$mesaj_sayi = okunmamis_mesaj_sayi($filtre_oku["id"]);
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
														<td style="font-weight:bold;" class="kapanis2_zamani'.$sira.'" id="sayac'.$sira.'">
															<input type="hidden" id="ihale_sayac'.$sira.'" value="'.$tarih_ihale.'" >
															<input type="hidden" id="id_'.$sira.'" value="'.$oku->id.'">
														</td> 
														<td>
															<a style="cursor: pointer;'.$t_color.'" class="view_guncelle kapanis_zamani'.$sira.'" id="'.$oku->id.'">'.$kapanis_zamani.'</a>
														</td>
														<td class="'.$yan.'"><a class="view_uyeye_teklif_ver" style="font-size:19px; font-weight:bold;'.$t_color.'" id="sonteklif_'.$oku->id.'">'.money($oku->son_teklif).'₺</a></td>   
														<!-- <td class="'.$yan.'">'.$oku->son_teklif.'</td>     -->
														<input type="hidden" id="teklif_sayisi'.$sira.'" value="'.$toplam_teklif.'" >
														<td><a style="'.$t_color.'" class="view_ilan_teklifleri" id="teklifler_'.$oku->id.'"><i class="fas fa-gavel">'.$toplam_teklif.'</i></a></td>    
														<td><a style="'.$t_color.'" class="view_ilan_mesajlari" id="mesajlar_'.$oku->id.'"><i class="fas fa-envelope">'.$mesaj_sayi.'</i></a></td>    
														<td><a style="'.$t_color.'" class="view_ilan_favorileri" id="'.$oku->id.'"><i class="fas fa-heart">'.$favori_sayi.'</i></a></td>    
														<td id="td_view_ilan_notlari_'.$oku->id.'" ><a style="'.$t_color.'" class="view_ilan_notlari" id="'.$oku->id.'"><i class="fas fa-align-justify">'.$not_sayi.'</i></a></td>    
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
													<td style="font-weight:bold;" class="kapanis2_zamani'.$sira.'" id="sayac'.$sira.'">
														<input type="hidden" id="ihale_sayac'.$sira.'" value="'.$tarih_ihale.'" >
														<input type="hidden" id="id_'.$sira.'" value="'.$filtre_oku['id'].'">
													</td> 
													<td>
														<a style="cursor: pointer;'.$t_color.'" class="view_guncelle kapanis_zamani'.$sira.'" id="'.$filtre_oku['id'].'">'.$kapanis_zamani.'</a>
													</td>
													<td class="'.$yan.'"><a style="font-size:19px; font-weight:bold;'.$t_color.'" class="view_uyeye_teklif_ver" id="sonteklif_'.$filtre_oku['id'].'">'.money($filtre_oku["son_teklif"]).'₺</a></td>   
													<!-- <td class="'.$yan.'">'.$filtre_oku["son_teklif"].'</td>     -->
													<input type="hidden" id="teklif_sayisi'.$sira.'" value="'.$toplam_teklif.'" >
													<td><a style="'.$t_color.'" class="view_ilan_teklifleri" id="teklifler_'.$filtre_oku['id'].'"><i class="fas fa-gavel">'.$toplam_teklif.'</i></a></td>    
													<td><a style="'.$t_color.'" class="view_ilan_mesajlari" id="mesajlar_'.$filtre_oku['id'].'"><i class="fas fa-envelope">'.$mesaj_sayi.'</i></a></td>    
													<td><a style="'.$t_color.'" class="view_ilan_favorileri" id="'.$filtre_oku['id'].'"><i class="fas fa-heart">'.$favori_sayi.'</i></a></td>    
													<td id="td_view_ilan_notlari_'.$filtre_oku['id'].'"><a style="'.$t_color.'" class="view_ilan_notlari" id="'.$filtre_oku['id'].'"><i class="fas fa-align-justify">'.$not_sayi.'</i></a></td>    
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

												// $mesaj_cek = mysql_query("SELECT * FROM mesajlar WHERE ilan_id = '".$oku->id."' ");
												// $mesaj_sayi = mysql_num_rows($mesaj_cek);
												$mesaj_sayi = okunmamis_mesaj_sayi($filtre_oku["id"]);
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
														<td style="font-weight:bold;" class="kapanis2_zamani'.$sira.'" id="sayac'.$sira.'">
															<input type="hidden" id="ihale_sayac'.$sira.'" value="'.$tarih_ihale.'" >
															<input type="hidden" id="id_'.$sira.'" value="'.$oku->id.'">
														</td> 
														<td>
															<a style="cursor: pointer;'.$t_color.'" class="view_guncelle kapanis_zamani'.$sira.'" id="'.$oku->id.'">'.$kapanis_zamani.'</a>
														</td>
														<td class="'.$yan.'"><a class="view_uyeye_teklif_ver" style="font-size:19px; font-weight:bold;'.$t_color.'" id="sonteklif_'.$oku->id.'">'.money($oku->son_teklif).'₺</a></td>   
														<!-- <td class="'.$yan.'">'.$oku->son_teklif.'</td>     -->
														<input type="hidden" id="teklif_sayisi'.$sira.'" value="'.$toplam_teklif.'" >
														<td><a style="'.$t_color.'" class="view_ilan_teklifleri" id="teklifler_'.$oku->id.'"><i class="fas fa-gavel">'.$toplam_teklif.'</i></a></td>    
														<td><a style="'.$t_color.'" class="view_ilan_mesajlari" id="mesajlar_'.$oku->id.'"><i class="fas fa-envelope">'.$mesaj_sayi.'</i></a></td>    
														<td><a style="'.$t_color.'" class="view_ilan_favorileri" id="'.$oku->id.'"><i class="fas fa-heart">'.$favori_sayi.'</i></a></td>    
														<td id="td_view_ilan_notlari_'.$oku->id.'"><a style="'.$t_color.'" class="view_ilan_notlari" id="'.$oku->id.'"><i class="fas fa-align-justify">'.$not_sayi.'</i></a></td>    
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
													<td style="font-weight:bold;" class="kapanis2_zamani'.$sira.'" id="sayac'.$sira.'">
														<input type="hidden" id="ihale_sayac'.$sira.'" value="'.$tarih_ihale.'" >
														<input type="hidden" id="id_'.$sira.'" value="'.$filtre_oku['id'].'">
													</td> 
													<td>
														<a style="cursor: pointer;'.$t_color.'" class="view_guncelle kapanis_zamani'.$sira.'" id="'.$filtre_oku['id'].'">'.$kapanis_zamani.'</a>
													</td>
													<td class="'.$yan.'"><a style="font-size:19px; font-weight:bold;'.$t_color.'" class="view_uyeye_teklif_ver" id="sonteklif_'.$filtre_oku['id'].'">'.money($filtre_oku["son_teklif"]).'₺</a></td>   
													<!-- <td class="'.$yan.'">'.$filtre_oku["son_teklif"].'</td>     -->
													<input type="hidden" id="teklif_sayisi'.$sira.'" value="'.$toplam_teklif.'" >
													<td><a style="'.$t_color.'" class="view_ilan_teklifleri" id="teklifler_'.$filtre_oku['id'].'"><i class="fas fa-gavel">'.$toplam_teklif.'</i></a></td>    
													<td><a style="'.$t_color.'" class="view_ilan_mesajlari" id="mesajlar_'.$filtre_oku['id'].'"><i class="fas fa-envelope">'.$mesaj_sayi.'</i></a></td>    
													<td><a style="'.$t_color.'" class="view_ilan_favorileri" id="'.$filtre_oku['id'].'"><i class="fas fa-heart">'.$favori_sayi.'</i></a></td>    
													<td id="td_view_ilan_notlari_'.$filtre_oku['id'].'"><a style="'.$t_color.'" class="view_ilan_notlari" id="'.$filtre_oku['id'].'"><i class="fas fa-align-justify">'.$not_sayi.'</i></a></td>    
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
											
											
											// $mesaj_cek = mysql_query("SELECT * FROM mesajlar WHERE ilan_id = '".$oku->id."' ");
											// $mesaj_sayi = mysql_num_rows($mesaj_cek);
											$mesaj_sayi = okunmamis_mesaj_sayi($filtre_oku["id"]);
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
													<td style="font-weight:bold;" class="kapanis2_zamani'.$sira.'" id="sayac'.$sira.'">
														<input type="hidden" id="ihale_sayac'.$sira.'" value="'.$tarih_ihale.'" >
														<input type="hidden" id="id_'.$sira.'" value="'.$oku->id.'">
													</td> 
													<td>
														<a style="cursor: pointer;'.$t_color.'" class="view_guncelle kapanis_zamani'.$sira.'" id="'.$oku->id.'">'.$kapanis_zamani.'</a>
													</td>
													<td class="'.$yan.'"><a class="view_uyeye_teklif_ver" style="font-size:19px; font-weight:bold;'.$t_color.'" id="sonteklif_'.$oku->id.'">'.money($oku->son_teklif).'₺</a></td>   
													<!-- <td class="'.$yan.'">'.$oku->son_teklif.'</td>     -->
													<input type="hidden" id="teklif_sayisi'.$sira.'" value="'.$toplam_teklif.'" >
													<td><a style="'.$t_color.'" class="view_ilan_teklifleri" id="teklifler_'.$oku->id.'"><i class="fas fa-gavel">'.$toplam_teklif.'</i></a></td>    
													<td><a style="'.$t_color.'" class="view_ilan_mesajlari" id="mesajlar_'.$oku->id.'"><i class="fas fa-envelope">'.$mesaj_sayi.'</i></a></td>    
													<td><a style="'.$t_color.'" class="view_ilan_favorileri" id="'.$oku->id.'"><i class="fas fa-heart">'.$favori_sayi.'</i></a></td>    
													<td id="td_view_ilan_notlari_'.$oku->id.'"><a style="'.$t_color.'" class="view_ilan_notlari" id="'.$oku->id.'"><i class="fas fa-align-justify">'.$not_sayi.'</i></a></td>    
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
												<td style="font-weight:bold;" class="kapanis2_zamani'.$sira.'" id="sayac'.$sira.'">
													<input type="hidden" id="ihale_sayac'.$sira.'" value="'.$tarih_ihale.'" >
													<input type="hidden" id="id_'.$sira.'" value="'.$filtre_oku['id'].'">
												</td> 
												<td>
													<a style="cursor: pointer;'.$t_color.'" class="view_guncelle kapanis_zamani'.$sira.' " id="'.$filtre_oku['id'].'">'.$kapanis_zamani.'</a>
												</td>
												<td class="'.$yan.'"><a style="font-size:19px; font-weight:bold;'.$t_color.'" class="view_uyeye_teklif_ver" id="sonteklif_'.$filtre_oku['id'].'">'.money($filtre_oku["son_teklif"]).'₺</a></td>   
												<!-- <td class="'.$yan.'">'.$filtre_oku["son_teklif"].'</td>     -->
												<input type="hidden" id="teklif_sayisi'.$sira.'" value="'.$toplam_teklif.'" >
												<td><a style="'.$t_color.'" class="view_ilan_teklifleri" id="teklifler_'.$filtre_oku['id'].'"><i class="fas fa-gavel">'.$toplam_teklif.'</i></a></td>    
												<td><a style="'.$t_color.'" class="view_ilan_mesajlari" id="mesajlar_'.$filtre_oku['id'].'"><i class="fas fa-envelope">'.$mesaj_sayi.'</i></a></td>    
												<td><a style="'.$t_color.'" class="view_ilan_favorileri" id="'.$filtre_oku['id'].'"><i class="fas fa-heart">'.$favori_sayi.'</i></a></td>    
												<td id="td_view_ilan_notlari_'.$filtre_oku['id'].'"><a style="'.$t_color.'" class="view_ilan_notlari" id="'.$filtre_oku['id'].'"><i class="fas fa-align-justify">'.$not_sayi.'</i></a></td>    
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
												
												
												// $mesaj_cek = mysql_query("SELECT * FROM mesajlar WHERE ilan_id = '".$oku->id."' ");
												// $mesaj_sayi = mysql_num_rows($mesaj_cek);
												$mesaj_sayi = okunmamis_mesaj_sayi($filtre_oku["id"]);
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
														<td style="font-weight:bold;" class="kapanis2_zamani'.$sira.'" id="sayac'.$sira.'">
															<input type="hidden" id="ihale_sayac'.$sira.'" value="'.$tarih_ihale.'" >
															<input type="hidden" id="id_'.$sira.'" value="'.$oku->id.'">
														</td> 
														<td>
															<a style="cursor: pointer;'.$t_color.'" class="view_guncelle kapanis_zamani'.$sira.'" id="'.$oku->id.'">'.$kapanis_zamani.'</a>
														</td>
														<td class="'.$yan.'"><a class="view_uyeye_teklif_ver" style="font-size:19px; font-weight:bold;'.$t_color.'" id="sonteklif_'.$oku->id.'">'.money($oku->son_teklif).'₺</a></td>   
														<!-- <td class="'.$yan.'">'.$oku->son_teklif.'</td>     -->
														<input type="hidden" id="teklif_sayisi'.$sira.'" value="'.$toplam_teklif.'" >
														<td><a style="'.$t_color.'" class="view_ilan_teklifleri" id="teklifler_'.$oku->id.'"><i class="fas fa-gavel">'.$toplam_teklif.'</i></a></td>    
														<td><a style="'.$t_color.'" class="view_ilan_mesajlari" id="mesajlar_'.$oku->id.'"><i class="fas fa-envelope">'.$mesaj_sayi.'</i></a></td>    
														<td><a style="'.$t_color.'" class="view_ilan_favorileri" id="'.$oku->id.'"><i class="fas fa-heart">'.$favori_sayi.'</i></a></td>    
														<td id="td_view_ilan_notlari_'.$oku->id.'"><a style="'.$t_color.'" class="view_ilan_notlari" id="'.$oku->id.'"><i class="fas fa-align-justify">'.$not_sayi.'</i></a></td>    
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
													<td style="font-weight:bold;" class="kapanis2_zamani'.$sira.'" id="sayac'.$sira.'">
														<input type="hidden" id="ihale_sayac'.$sira.'" value="'.$tarih_ihale.'" >
														<input type="hidden" id="id_'.$sira.'" value="'.$filtre_oku['id'].'">
													</td> 
													<td>
														<a style="cursor: pointer;'.$t_color.'" class="view_guncelle kapanis_zamani'.$sira.'" id="'.$filtre_oku['id'].'">'.$kapanis_zamani.'</a>
													</td>
													<td class="'.$yan.'"><a style="font-size:19px; font-weight:bold;'.$t_color.'" class="view_uyeye_teklif_ver" id="sonteklif_'.$filtre_oku['id'].'">'.money($filtre_oku["son_teklif"]).'₺</a></td>   
													<!-- <td class="'.$yan.'">'.$filtre_oku["son_teklif"].'</td>     -->
													<input type="hidden" id="teklif_sayisi'.$sira.'" value="'.$toplam_teklif.'" >
													<td><a style="'.$t_color.'" class="view_ilan_teklifleri" id="teklifler_'.$filtre_oku['id'].'"><i class="fas fa-gavel">'.$toplam_teklif.'</i></a></td>    
													<td><a style="'.$t_color.'" class="view_ilan_mesajlari" id="mesajlar_'.$filtre_oku['id'].'"><i class="fas fa-envelope">'.$mesaj_sayi.'</i></a></td>    
													<td><a style="'.$t_color.'" class="view_ilan_favorileri" id="'.$filtre_oku['id'].'"><i class="fas fa-heart">'.$favori_sayi.'</i></a></td>    
													<td id="td_view_ilan_notlari_'.$filtre_oku['id'].'"><a style="'.$t_color.'" class="view_ilan_notlari" id="'.$filtre_oku['id'].'"><i class="fas fa-align-justify">'.$not_sayi.'</i></a></td>    
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
												
												
												// $mesaj_cek = mysql_query("SELECT * FROM mesajlar WHERE ilan_id = '".$oku->id."' ");
												// $mesaj_sayi = mysql_num_rows($mesaj_cek);
												$mesaj_sayi = okunmamis_mesaj_sayi($filtre_oku["id"]);
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
														<td style="font-weight:bold;" class="kapanis2_zamani'.$sira.'" id="sayac'.$sira.'">
															<input type="hidden" id="ihale_sayac'.$sira.'" value="'.$tarih_ihale.'" >
															<input type="hidden" id="id_'.$sira.'" value="'.$oku->id.'">
														</td> 
														<td>
															<a style="cursor: pointer;'.$t_color.'" class="view_guncelle kapanis_zamani'.$sira.'" id="'.$oku->id.'">'.$kapanis_zamani.'</a>
														</td>
														<td class="'.$yan.'"><a class="view_uyeye_teklif_ver" style="font-size:19px; font-weight:bold;'.$t_color.'" id="sonteklif_'.$oku->id.'">'.money($oku->son_teklif).'₺</a></td>   
														<!-- <td class="'.$yan.'">'.$oku->son_teklif.'</td>     -->
														<input type="hidden" id="teklif_sayisi'.$sira.'" value="'.$toplam_teklif.'" >
														<td><a style="'.$t_color.'" class="view_ilan_teklifleri" id="teklifler_'.$oku->id.'"><i class="fas fa-gavel">'.$toplam_teklif.'</i></a></td>    
														<td><a style="'.$t_color.'" class="view_ilan_mesajlari" id="mesajlar_'.$oku->id.'"><i class="fas fa-envelope">'.$mesaj_sayi.'</i></a></td>    
														<td><a style="'.$t_color.'" class="view_ilan_favorileri" id="'.$oku->id.'"><i class="fas fa-heart">'.$favori_sayi.'</i></a></td>    
														<td id="td_view_ilan_notlari_'.$oku->id.'"><a style="'.$t_color.'" class="view_ilan_notlari" id="'.$oku->id.'"><i class="fas fa-align-justify">'.$not_sayi.'</i></a></td>    
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
													<td style="font-weight:bold;" class="kapanis2_zamani'.$sira.'" id="sayac'.$sira.'">
														<input type="hidden" id="ihale_sayac'.$sira.'" value="'.$tarih_ihale.'" >
														<input type="hidden" id="id_'.$sira.'" value="'.$filtre_oku['id'].'">
													</td> 
													<td>
														<a style="cursor: pointer;'.$t_color.'" class="view_guncelle kapanis_zamani'.$sira.'" id="'.$filtre_oku['id'].'">'.$kapanis_zamani.'</a>
													</td>
													<td class="'.$yan.'"><a style="font-size:19px; font-weight:bold;'.$t_color.'" class="view_uyeye_teklif_ver" id="sonteklif_'.$filtre_oku['id'].'">'.money($filtre_oku["son_teklif"]).'₺</a></td>   
													<!-- <td class="'.$yan.'">'.$filtre_oku["son_teklif"].'</td>     -->
													<input type="hidden" id="teklif_sayisi'.$sira.'" value="'.$toplam_teklif.'" >
													<td><a style="'.$t_color.'" class="view_ilan_teklifleri" id="teklifler_'.$filtre_oku['id'].'"><i class="fas fa-gavel">'.$toplam_teklif.'</i></a></td>    
													<td><a style="'.$t_color.'" class="view_ilan_mesajlari" id="mesajlar_'.$filtre_oku['id'].'"><i class="fas fa-envelope">'.$mesaj_sayi.'</i></a></td>    
													<td><a style="'.$t_color.'" class="view_ilan_favorileri" id="'.$filtre_oku['id'].'"><i class="fas fa-heart">'.$favori_sayi.'</i></a></td>    
													<td id="td_view_ilan_notlari_'.$filtre_oku['id'].'"><a style="'.$t_color.'" class="view_ilan_notlari" id="'.$filtre_oku['id'].'"><i class="fas fa-align-justify">'.$not_sayi.'</i></a></td>    
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
									<td style="'.$color2.'" ><a href="../arac_detay.php?id='.$gelen_id.'&q=ihale" style="'.$color2.'"  target="_blank">'.$arac_detaylari.'</a></td>    
									<td style="font-weight:bold;" class="kapanis2_zamani'.$sira.'" id="sayac'.$sira.'">
										<input type="hidden" id="ihale_sayac'.$sira.'" value="'.$tarih_ihale.'" >
										<input type="hidden" id="id_'.$sira.'" value="'.$filtre_oku['id'].'">
									</td> 
									<td>
										<a style="cursor: pointer;" class="view_guncelle kapanis_zamani'.$sira.'" id="'.$filtre_oku['id'].'">'.$kapanis_zamani.'</a>
									</td>
									<td class="'.$yan.'"><a class="view_uyeye_teklif_ver" style="font-size:19px; font-weight:bold;" id="sonteklif_'.$filtre_oku['id'].'">'.money($filtre_oku["son_teklif"]).'₺</a></td>   
									<!-- <td class="'.$yan.'">'.$filtre_oku["son_teklif"].'</td>     -->
									<input type="hidden" id="teklif_sayisi'.$sira.'" value="'.$toplam_teklif.'" >
									<td><a class="view_ilan_teklifleri" id="teklifler_'.$filtre_oku['id'].'"><i class="fas fa-gavel">'.$toplam_teklif.'</i></a></td>    
									<td><a class="view_ilan_mesajlari" id="mesajlar_'.$filtre_oku['id'].'"><i class="fas fa-envelope">'.$mesaj_sayi.'</i></a></td>    
									<td><a class="view_ilan_favorileri" id="'.$filtre_oku['id'].'"><i class="fas fa-heart">'.$favori_sayi.'</i></a></td>    
									<td id="td_view_ilan_notlari_'.$filtre_oku['id'].'"><a class="view_ilan_notlari" id="'.$filtre_oku['id'].'"><i class="fas fa-align-justify">'.$not_sayi.'</i></a></td>    
									<td>'.$sgrt_adi.'</td>
								</tr>
							';
							$sira++;
						}
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
  
	<form method="POST" action="?modul=ihaleler&sayfa=toplu_sil" onsubmit="return confirm('SEÇİLİ İLANLARI SİLMEK İSTEDİĞİNİZE EMİN MİSİNİ?');">
		<?php
			$admin_yetki_cek=mysql_query("Select * from kullanicilar where id='".$admin_id."' ");
			$admin_yetki_oku=mysql_fetch_assoc($admin_yetki_cek);
			$yetkiler=$admin_yetki_oku["yetki"];
			$yetki_parcala=explode("|",$yetkiler);

			$btn='';
			$btn2='';
			if (in_array(2, $yetki_parcala) && in_array(1, $yetki_parcala) ) { 
			  $btn='<input type="submit" name="secili_sil" class="btn-danger" value="Seçili Olanları Sil">';
			  $btn2='<input type="button" name="secili_uzat" class="view_secili_ilan_sure_uzat btn-primary" value="Seçili Olanların Süresini Uzat">';
			}  else if(in_array(2, $yetki_parcala) && !in_array(1, $yetki_parcala)){
				$btn='<input type="submit" name="secili_sil" class="btn-danger" value="Seçili Olanları Sil">';
			    $btn2='';
			} else if(!in_array(2, $yetki_parcala) && in_array(1, $yetki_parcala)){
				$btn='';
			    $btn2='<input type="button" name="secili_uzat" class="view_secili_ilan_sure_uzat btn-primary" value="Seçili Olanların Süresini Uzat">';
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
			#tum_ihaleler_table_filter{
				float: left!important;
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
			<table id="tum_ihaleler_table" class="table table-bordered" cellspacing="1" cellpadding="1">
				<thead>
					<tr>
						<td><input type="checkbox" id="checkle" class="checkall btn btn-blue chec2" style="padding:20px;opacity:1!important; z-index:999;">Seç</td>
						<td>Düzenle</td>
						<td>Görseller</td>
						<td>Kod</td>
						<td>Plaka</td>
						<td>İl Adı</td>
						<td>Detaylar</td>
						<td>Sayaç</td>
						<td>Kapanış Zamanı</td>
						<td>En Yüksek</td>
						<td>Teklif</td>
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

						$ilan_bitis=$hepsini_oku["ihale_tarihi"]." ".$hepsini_oku["ihale_saati"];
						$new_time = date("Y-m-d H:i:s", strtotime('+5 minutes', strtotime($ilan_bitis)));						
						

						$new_time = date("Y-m-d H:i:s", strtotime('+5 minutes', strtotime($ilan_bitis)));		
						if($toplam_teklif == 0){
							if($ilan_bitis > date('Y-m-d H:i:s')){
								$ilan_yeni_durum = 1;
							}else{
								$ilan_yeni_durum = 0;
							}
						}else{
							if($new_time > date('Y-m-d H:i:s')){
								$ilan_yeni_durum = 1;					
							}else{
								$ilan_yeni_durum = 0;
							}
						}	


						
						if($ilan_yeni_durum == 1){
						// $mesaj_cek = mysql_query("SELECT * FROM mesajlar WHERE ilan_id = '".$hepsini_oku['id']."' ");
						// $mesaj_sayi = mysql_num_rows($mesaj_cek);
						$mesaj_sayi = okunmamis_mesaj_sayi($hepsini_oku["id"]);
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
								$srgl=mysql_query("select ilanlar.* from ilanlar inner join teklifler on teklifler.ilan_id=ilanlar.id  where ilanlar.id = '".$hepsini_oku["id"]."' and ilanlar.durum=1 and ilanlar.ihale_tarihi='".$ihale_trh."' and ilanlar.ihale_saati='".$ihale_st."' and teklifler.durum=1 group by ilanlar.id");							//
								if(mysql_num_rows($srgl)>0){
									while($oku=mysql_fetch_object($srgl)){
										if(!in_array($oku->id,$hepsi_array)){
											array_push($hepsi_array,$oku->id);
										
											$tarih_ihale=$oku->ihale_tarihi.' '. $oku->ihale_saati;
											$kapanis_zamani=date("d-m-Y H:i:s", strtotime($oku->ihale_tarihi. " ". $oku->ihale_saati));
											
											
											$teklifler=mysql_query("select * from teklifler where ilan_id='".$oku->id."' and durum=1 order by teklif_zamani desc ");
											$toplam_teklif = mysql_num_rows($teklifler);
											
											
											// $mesaj_cek = mysql_query("SELECT * FROM mesajlar WHERE ilan_id = '".$oku->id."' ");
											// $mesaj_sayi = mysql_num_rows($mesaj_cek);
											$mesaj_sayi = okunmamis_mesaj_sayi($hepsini_oku["id"]);
											
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
													<td style="font-weight:bold;" class="kapanis2_zamani'.$sira.'" id="sayac'.$sira.'">
														<input type="hidden" id="ihale_sayac'.$sira.'" value="'.$tarih_ihale.'" >
														<input type="hidden" id="id_'.$sira.'" value="'.$oku->id.'">
													</td> 
													<td>
														<a style="cursor: pointer;'.$t_color.'" class="view_guncelle kapanis_zamani'.$sira.'" id="'.$oku->id.'">'.$kapanis_zamani.'</a>
													</td>
													<td class="'.$yan.'"><a class="view_uyeye_teklif_ver" style="font-size:19px; font-weight:bold;'.$t_color.'" id="sonteklif_'.$oku->id.'">'.money($oku->son_teklif).'₺</a></td>   
													<!-- <td class="'.$yan.'">'.$oku->son_teklif.'</td>     -->
													<input type="hidden" id="teklif_sayisi'.$sira.'" value="'.$toplam_teklif.'" >
													<td><a style="'.$t_color.'" class="view_ilan_teklifleri" id="teklifler_'.$oku->id.'"><i class="fas fa-gavel">'.$toplam_teklif.'</i></a></td>    
													<td><a style="'.$t_color.'" class="view_ilan_mesajlari" id="mesajlar_'.$oku->id.'"><i class="fas fa-envelope">'.$mesaj_sayi.'</i></a></td>    
													<td><a style="'.$t_color.'" class="view_ilan_favorileri" id="'.$oku->id.'"><i class="fas fa-heart">'.$favori_sayi.'</i></a></td>    
													<td id="td_view_ilan_notlari_'.$oku->id.'"><a style="'.$t_color.'" class="view_ilan_notlari" id="'.$oku->id.'"><i class="fas fa-align-justify">'.$not_sayi.'</i></a></td>    
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
												<td style="font-weight:bold;" class="kapanis2_zamani'.$sira.'" id="sayac'.$sira.'">
													<input type="hidden" id="ihale_sayac'.$sira.'" value="'.$tarih_ihale.'" >
													<input type="hidden" id="id_'.$sira.'" value="'.$hepsini_oku['id'].'">
												</td> 
												<td>
													<a style="cursor: pointer;'.$t_color.'" class="view_guncelle kapanis_zamani'.$sira.'" id="'.$hepsini_oku['id'].'">'.$kapanis_zamani.'</a>
												</td>
												<td class="'.$yan.'"><a style="font-size:19px; font-weight:bold;'.$t_color.'" class="view_uyeye_teklif_ver" id="sonteklif_'.$hepsini_oku['id'].'">'.money($hepsini_oku["son_teklif"]).'₺</a></td>   
												<!-- <td class="'.$yan.'">'.$hepsini_oku["son_teklif"].'</td>     -->
												<input type="hidden" id="teklif_sayisi'.$sira.'" value="'.$toplam_teklif.'" >
												<td><a style="'.$t_color.'" class="view_ilan_teklifleri" id="teklifler_'.$hepsini_oku['id'].'"><i class="fas fa-gavel">'.$toplam_teklif.'</i></a></td>    
												<td><a style="'.$t_color.'" class="view_ilan_mesajlari" id="mesajlar_'.$hepsini_oku['id'].'"><i class="fas fa-envelope">'.$mesaj_sayi.'</i></a></td>    
												<td><a style="'.$t_color.'" class="view_ilan_favorileri" id="'.$hepsini_oku['id'].'"><i class="fas fa-heart">'.$favori_sayi.'</i></a></td>    
												<td id="td_view_ilan_notlari_'.$hepsini_oku['id'].'"><a style="'.$t_color.'" class="view_ilan_notlari" id="'.$hepsini_oku['id'].'"><i class="fas fa-align-justify">'.$not_sayi.'</i></a></td>    
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
												
												
												// $mesaj_cek = mysql_query("SELECT * FROM mesajlar WHERE ilan_id = '".$oku->id."'");
												// $mesaj_sayi = mysql_num_rows($mesaj_cek);
												$mesaj_sayi = okunmamis_mesaj_sayi($hepsini_oku["id"]);
											
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
														<td style="font-weight:bold;" class="kapanis2_zamani'.$sira.'" id="sayac'.$sira.'">
															<input type="hidden" id="ihale_sayac'.$sira.'" value="'.$tarih_ihale.'" >
															<input type="hidden" id="id_'.$sira.'" value="'.$oku->id.'">
														</td> 
														<td>
															<a style="cursor: pointer;'.$t_color.'" class="view_guncelle kapanis_zamani'.$sira.'" id="'.$oku->id.'">'.$kapanis_zamani.'</a>
														</td>
														<td class="'.$yan.'"><a class="view_uyeye_teklif_ver" style="font-size:19px; font-weight:bold;'.$t_color.'" id="sonteklif_'.$oku->id.'">'.money($oku->son_teklif).'₺</a></td>   
														<!-- <td class="'.$yan.'">'.$oku->son_teklif.'</td>     -->
														<input type="hidden" id="teklif_sayisi'.$sira.'" value="'.$toplam_teklif.'" >
														<td><a style="'.$t_color.'" class="view_ilan_teklifleri" id="teklifler_'.$oku->id.'"><i class="fas fa-gavel">'.$toplam_teklif.'</i></a></td>    
														<td><a style="'.$t_color.'" class="view_ilan_mesajlari" id="mesajlar_'.$oku->id.'"><i class="fas fa-envelope">'.$mesaj_sayi.'</i></a></td>    
														<td><a style="'.$t_color.'" class="view_ilan_favorileri" id="'.$oku->id.'"><i class="fas fa-heart">'.$favori_sayi.'</i></a></td>    
														<td id="td_view_ilan_notlari_'.$oku->id.'" ><a style="'.$t_color.'" class="view_ilan_notlari" id="'.$oku->id.'"><i class="fas fa-align-justify">'.$not_sayi.'</i></a></td>    
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
													<td style="font-weight:bold;" class="kapanis2_zamani'.$sira.'" id="sayac'.$sira.'">
														<input type="hidden" id="ihale_sayac'.$sira.'" value="'.$tarih_ihale.'" >
														<input type="hidden" id="id_'.$sira.'" value="'.$hepsini_oku['id'].'">
													</td> 
													<td>
														<a style="cursor: pointer;'.$t_color.'" class="view_guncelle kapanis_zamani'.$sira.'" id="'.$hepsini_oku['id'].'">'.$kapanis_zamani.'</a>
													</td>
													<td class="'.$yan.'"><a style="font-size:19px; font-weight:bold;'.$t_color.'" class="view_uyeye_teklif_ver" id="sonteklif_'.$hepsini_oku['id'].'">'.money($hepsini_oku["son_teklif"]).'₺</a></td>   
													<!-- <td class="'.$yan.'">'.$hepsini_oku["son_teklif"].'</td>     -->
													<input type="hidden" id="teklif_sayisi'.$sira.'" value="'.$toplam_teklif.'" >
													<td><a style="'.$t_color.'" class="view_ilan_teklifleri" id="teklifler_'.$hepsini_oku['id'].'"><i class="fas fa-gavel">'.$toplam_teklif.'</i></a></td>    
													<td><a style="'.$t_color.'" class="view_ilan_mesajlari" id="mesajlar_'.$hepsini_oku['id'].'"><i class="fas fa-envelope">'.$mesaj_sayi.'</i></a></td>    
													<td><a style="'.$t_color.'" class="view_ilan_favorileri" id="'.$hepsini_oku['id'].'"><i class="fas fa-heart">'.$favori_sayi.'</i></a></td>    
													<td id="td_view_ilan_notlari_'.$hepsini_oku['id'].'"><a style="'.$t_color.'" class="view_ilan_notlari" id="'.$hepsini_oku['id'].'"><i class="fas fa-align-justify">'.$not_sayi.'</i></a></td>    
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
												
												// $mesaj_cek = mysql_query("SELECT * FROM mesajlar WHERE ilan_id = '".$oku->id."' ");
												// $mesaj_sayi = mysql_num_rows($mesaj_cek);
												$mesaj_sayi = okunmamis_mesaj_sayi($hepsini_oku["id"]);

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
														<td style="font-weight:bold;" class="kapanis2_zamani'.$sira.'" id="sayac'.$sira.'">
															<input type="hidden" id="ihale_sayac'.$sira.'" value="'.$tarih_ihale.'" >
															<input type="hidden" id="id_'.$sira.'" value="'.$oku->id.'">
														</td> 
														<td>
															<a style="cursor: pointer;'.$t_color.'" class="view_guncelle kapanis_zamani'.$sira.'" id="'.$oku->id.'">'.$kapanis_zamani.'</a>
														</td>
														<td class="'.$yan.'"><a class="view_uyeye_teklif_ver" style="font-size:19px; font-weight:bold;'.$t_color.'" id="sonteklif_'.$oku->id.'">'.money($oku->son_teklif).'₺</a></td>   
														<!-- <td class="'.$yan.'">'.$oku->son_teklif.'</td>     -->
														<input type="hidden" id="teklif_sayisi'.$sira.'" value="'.$toplam_teklif.'" >
														<td><a style="'.$t_color.'" class="view_ilan_teklifleri" id="teklifler_'.$oku->id.'"><i class="fas fa-gavel">'.$toplam_teklif.'</i></a></td>    
														<td><a style="'.$t_color.'" class="view_ilan_mesajlari" id="mesajlar_'.$oku->id.'"><i class="fas fa-envelope">'.$mesaj_sayi.'</i></a></td>    
														<td><a style="'.$t_color.'" class="view_ilan_favorileri" id="'.$oku->id.'"><i class="fas fa-heart">'.$favori_sayi.'</i></a></td>    
														<td id="td_view_ilan_notlari_'.$oku->id.'"><a style="'.$t_color.'" class="view_ilan_notlari" id="'.$oku->id.'"><i class="fas fa-align-justify">'.$not_sayi.'</i></a></td>    
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
													<td style="font-weight:bold;" class="kapanis_zamani'.$sira.'" id="sayac'.$sira.'">
														<input type="hidden" id="ihale_sayac'.$sira.'" value="'.$tarih_ihale.'" >
														<input type="hidden" id="id_'.$sira.'" value="'.$hepsini_oku['id'].'">
													</td> 
													<td>
														<a style="cursor: pointer;'.$t_color.'" class="view_guncelle" id="'.$hepsini_oku['id'].'">'.$kapanis_zamani.'</a>
													</td>
													<td class="'.$yan.'"><a style="font-size:19px; font-weight:bold;'.$t_color.'" class="view_uyeye_teklif_ver" id="sonteklif_'.$hepsini_oku['id'].'">'.money($hepsini_oku["son_teklif"]).'₺</a></td>   
													<!-- <td class="'.$yan.'">'.$hepsini_oku["son_teklif"].'</td>     -->
													<input type="hidden" id="teklif_sayisi'.$sira.'" value="'.$toplam_teklif.'" >
													<td><a style="'.$t_color.'" class="view_ilan_teklifleri" id="teklifler_'.$hepsini_oku['id'].'"><i class="fas fa-gavel">'.$toplam_teklif.'</i></a></td>    
													<td><a style="'.$t_color.'" class="view_ilan_mesajlari" id="mesajlar_'.$hepsini_oku['id'].'"><i class="fas fa-envelope">'.$mesaj_sayi.'</i></a></td>    
													<td><a style="'.$t_color.'" class="view_ilan_favorileri" id="'.$hepsini_oku['id'].'"><i class="fas fa-heart">'.$favori_sayi.'</i></a></td>    
													<td id="td_view_ilan_notlari_'.$hepsini_oku['id'].'"><a style="'.$t_color.'" class="view_ilan_notlari" id="'.$hepsini_oku['id'].'"><i class="fas fa-align-justify">'.$not_sayi.'</i></a></td>    
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
											
											
											// $mesaj_cek = mysql_query("SELECT * FROM mesajlar WHERE ilan_id = '".$oku->id."' ");
											// $mesaj_sayi = mysql_num_rows($mesaj_cek);
											$mesaj_sayi = okunmamis_mesaj_sayi($hepsini_oku["id"]);
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
													<td style="font-weight:bold;" class="kapanis2_zamani'.$sira.'" id="sayac'.$sira.'">
														<input type="hidden" id="ihale_sayac'.$sira.'" value="'.$tarih_ihale.'" >
														<input type="hidden" id="id_'.$sira.'" value="'.$oku->id.'">
													</td> 
													<td>
														<a style="cursor: pointer;'.$t_color.'" class="view_guncelle kapanis_zamani'.$sira.'" id="'.$oku->id.'">'.$kapanis_zamani.'</a>
													</td>
													<td class="'.$yan.'"><a class="view_uyeye_teklif_ver" style="font-size:19px; font-weight:bold;'.$t_color.'" id="sonteklif_'.$oku->id.'">'.money($oku->son_teklif).'₺</a></td>   
													<!-- <td class="'.$yan.'">'.$oku->son_teklif.'</td>     -->
													<input type="hidden" id="teklif_sayisi'.$sira.'" value="'.$toplam_teklif.'" >
													<td><a style="'.$t_color.'" class="view_ilan_teklifleri" id="teklifler_'.$oku->id.'"><i class="fas fa-gavel">'.$toplam_teklif.'</i></a></td>    
													<td><a style="'.$t_color.'" class="view_ilan_mesajlari" id="mesajlar_'.$oku->id.'"><i class="fas fa-envelope">'.$mesaj_sayi.'</i></a></td>    
													<td><a style="'.$t_color.'" class="view_ilan_favorileri" id="'.$oku->id.'"><i class="fas fa-heart">'.$favori_sayi.'</i></a></td>    
													<td id="td_view_ilan_notlari_'.$hepsini_oku['id'].'"><a style="'.$t_color.'" class="view_ilan_notlari" id="'.$oku->id.'"><i class="fas fa-align-justify">'.$not_sayi.'</i></a></td>    
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
										$td.='<tr id="tr_'.$hepsini_oku["id"].'" style="background-color: '.$tablo_rengi.';'.$t_color.'  ">
												<td><input type="checkbox" name="secim[]" class="chec" id="asd'.$gelen_id.'" value="'.$gelen_id.'" style="opacity:1!important; z-index:999;"></td>
												<td><a target="_blank" href="?modul=ilanlar&sayfa=ilan_ekle&id='.$gelen_id.'"><i class="fas fa-edit"></i></a></td>
												<td><a onclick="tabTrigger()" href="?modul=ilanlar&sayfa=ilan_ekle&id='.$gelen_id.'" target="_blank"><img style="width: 50px; height:50px;" src="../images/'.$resim.'" alt=""></a></td>
												<td>'.$hepsini_oku["arac_kodu"].'</td>
												<td>'.$hepsini_oku["plaka"].'</td>    
												<td>'.$hepsini_oku['sehir'].'</td>  
												<td style="color:'.$color.';" ><a href="../arac_detay.php?id='.$gelen_id.'&q=ihale" style="color:'.$color.';"  target="_blank">'.$arac_detaylari.'</a></td>    
												<td style="font-weight:bold;" class="kapanis2_zamani'.$sira.'" id="sayac'.$sira.'">
													<input type="hidden" id="ihale_sayac'.$sira.'" value="'.$tarih_ihale.'" >
													<input type="hidden" id="id_'.$sira.'" value="'.$hepsini_oku['id'].'">
												</td> 
												<td>
													<a style="cursor: pointer;'.$t_color.'" class="view_guncelle kapanis_zamani'.$sira.'" id="'.$hepsini_oku['id'].'">'.$kapanis_zamani.'</a>
												</td>
												<td class="'.$yan.'"><a style="font-size:19px; font-weight:bold;'.$t_color.'" class="view_uyeye_teklif_ver" id="sonteklif_'.$hepsini_oku['id'].'">'.money($hepsini_oku["son_teklif"]).'₺</a></td>   
												<!-- <td class="'.$yan.'">'.$hepsini_oku["son_teklif"].'</td>     -->
												<input type="hidden" id="teklif_sayisi'.$sira.'" value="'.$toplam_teklif.'" >
												<td><a style="'.$t_color.'" class="view_ilan_teklifleri" id="teklifler_'.$hepsini_oku['id'].'"><i class="fas fa-gavel">'.$toplam_teklif.'</i></a></td>    
												<td><a style="'.$t_color.'" class="view_ilan_mesajlari" id="mesajlar_'.$hepsini_oku['id'].'"><i class="fas fa-envelope">'.$mesaj_sayi.'</i></a></td>    
												<td><a style="'.$t_color.'" class="view_ilan_favorileri" id="'.$hepsini_oku['id'].'"><i class="fas fa-heart">'.$favori_sayi.'</i></a></td>    
												<td id="td_view_ilan_notlari_'.$hepsini_oku['id'].'"><a style="'.$t_color.'" class="view_ilan_notlari" id="'.$hepsini_oku['id'].'"><i class="fas fa-align-justify">'.$not_sayi.'</i></a></td>    
												<td>'.$sgrt_adi.'</td>    
											</tr>';
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
												
												// $mesaj_cek = mysql_query("SELECT * FROM mesajlar WHERE ilan_id = '".$oku->id."' ");
												// $mesaj_sayi = mysql_num_rows($mesaj_cek);
												$mesaj_sayi = okunmamis_mesaj_sayi($hepsini_oku["id"]);
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
														<td style="font-weight:bold;" class="kapanis2_zamani'.$sira.'" id="sayac'.$sira.'">
															<input type="hidden" id="ihale_sayac'.$sira.'" value="'.$tarih_ihale.'" >
															<input type="hidden" id="id_'.$sira.'" value="'.$oku->id.'">
														</td> 
														<td>
															<a style="cursor: pointer;'.$t_color.'" class="view_guncelle kapanis_zamani'.$sira.'" id="'.$oku->id.'">'.$kapanis_zamani.'</a>
														</td>
														<td class="'.$yan.'"><a class="view_uyeye_teklif_ver" style="font-size:19px; font-weight:bold;'.$t_color.'" id="sonteklif_'.$oku->id.'">'.money($oku->son_teklif).'₺</a></td>   
														<!-- <td class="'.$yan.'">'.$oku->son_teklif.'</td>     -->
														<input type="hidden" id="teklif_sayisi'.$sira.'" value="'.$toplam_teklif.'" >
														<td><a style="'.$t_color.'" class="view_ilan_teklifleri" id="teklifler_'.$oku->id.'"><i class="fas fa-gavel">'.$toplam_teklif.'</i></a></td>    
														<td><a style="'.$t_color.'" class="view_ilan_mesajlari" id="mesajlar_'.$oku->id.'"><i class="fas fa-envelope">'.$mesaj_sayi.'</i></a></td>    
														<td><a style="'.$t_color.'" class="view_ilan_favorileri" id="'.$oku->id.'"><i class="fas fa-heart">'.$favori_sayi.'</i></a></td>    
														<td id="td_view_ilan_notlari_'.$oku->id.'"><a style="'.$t_color.'" class="view_ilan_notlari" id="'.$oku->id.'"><i class="fas fa-align-justify">'.$not_sayi.'</i></a></td>    
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
													<td style="font-weight:bold;" class="kapanis2_zamani'.$sira.'" id="sayac'.$sira.'">
														<input type="hidden" id="ihale_sayac'.$sira.'" value="'.$tarih_ihale.'" >
														<input type="hidden" id="id_'.$sira.'" value="'.$hepsini_oku['id'].'">
													</td> 
													<td>
														<a style="cursor: pointer;'.$t_color.'" class="view_guncelle kapanis_zamani'.$sira.'" id="'.$hepsini_oku['id'].'">'.$kapanis_zamani.'</a>
													</td>
													<td class="'.$yan.'"><a style="font-size:19px; font-weight:bold;'.$t_color.'" class="view_uyeye_teklif_ver" id="sonteklif_'.$hepsini_oku['id'].'">'.money($hepsini_oku["son_teklif"]).'₺</a></td>   
													<!-- <td class="'.$yan.'">'.$hepsini_oku["son_teklif"].'</td>     -->
													<input type="hidden" id="teklif_sayisi'.$sira.'" value="'.$toplam_teklif.'" >
													<td><a style="'.$t_color.'" class="view_ilan_teklifleri" id="teklifler_'.$hepsini_oku['id'].'"><i class="fas fa-gavel">'.$toplam_teklif.'</i></a></td>    
													<td><a style="'.$t_color.'" class="view_ilan_mesajlari" id="mesajlar_'.$hepsini_oku['id'].'"><i class="fas fa-envelope">'.$mesaj_sayi.'</i></a></td>    
													<td><a style="'.$t_color.'" class="view_ilan_favorileri" id="'.$hepsini_oku['id'].'"><i class="fas fa-heart">'.$favori_sayi.'</i></a></td>    
													<td id="td_view_ilan_notlari_'.$hepsini_oku['id'].'"><a style="'.$t_color.'" class="view_ilan_notlari" id="'.$hepsini_oku['id'].'"><i class="fas fa-align-justify">'.$not_sayi.'</i></a></td>    
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
												
												// $mesaj_cek = mysql_query("SELECT * FROM mesajlar WHERE ilan_id = '".$oku->id."'");
												// $mesaj_sayi = mysql_num_rows($mesaj_cek);
												$mesaj_sayi = okunmamis_mesaj_sayi($hepsini_oku["id"]);
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
														<td style="font-weight:bold;" class="kapanis2_zamani'.$sira.'" id="sayac'.$sira.'">
															<input type="hidden" id="ihale_sayac'.$sira.'" value="'.$tarih_ihale.'" >
															<input type="hidden" id="id_'.$sira.'" value="'.$oku->id.'">
														</td> 
														<td>
															<a style="cursor: pointer;'.$t_color.'" class="view_guncelle kapanis_zamani'.$sira.'" id="'.$oku->id.'">'.$kapanis_zamani.'</a>
														</td>
														<td class="'.$yan.'"><a class="view_uyeye_teklif_ver" style="font-size:19px; font-weight:bold;'.$t_color.'" id="sonteklif_'.$oku->id.'">'.money($oku->son_teklif).'₺</a></td>   
														<!-- <td class="'.$yan.'">'.$oku->son_teklif.'</td>     -->
														<input type="hidden" id="teklif_sayisi'.$sira.'" value="'.$toplam_teklif.'" >
														<td><a style="'.$t_color.'" class="view_ilan_teklifleri" id="teklifler_'.$oku->id.'"><i class="fas fa-gavel">'.$toplam_teklif.'</i></a></td>    
														<td><a style="'.$t_color.'" class="view_ilan_mesajlari" id="mesajlar_'.$oku->id.'"><i class="fas fa-envelope">'.$mesaj_sayi.'</i></a></td>    
														<td><a style="'.$t_color.'" class="view_ilan_favorileri" id="'.$oku->id.'"><i class="fas fa-heart">'.$favori_sayi.'</i></a></td>    
														<td id="td_view_ilan_notlari_'.$oku->id.'"><a style="'.$t_color.'" class="view_ilan_notlari" id="'.$oku->id.'"><i class="fas fa-align-justify">'.$not_sayi.'</i></a></td>    
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
													<td style="font-weight:bold;" class="kapanis2_zamani'.$sira.'" id="sayac'.$sira.'">
														<input type="hidden" id="ihale_sayac'.$sira.'" value="'.$tarih_ihale.'" >
														<input type="hidden" id="id_'.$sira.'" value="'.$hepsini_oku['id'].'">
													</td> 
													<td>
														<a style="cursor: pointer;'.$t_color.'" class="view_guncelle kapanis_zamani'.$sira.'" id="'.$hepsini_oku['id'].'">'.$kapanis_zamani.'</a>
													</td>
													<td class="'.$yan.'"><a style="font-size:19px; font-weight:bold;'.$t_color.'" class="view_uyeye_teklif_ver" id="sonteklif_'.$hepsini_oku['id'].'">'.money($hepsini_oku["son_teklif"]).'₺</a></td>   
													<!-- <td class="'.$yan.'">'.$hepsini_oku["son_teklif"].'</td>     -->
													<input type="hidden" id="teklif_sayisi'.$sira.'" value="'.$toplam_teklif.'" >
													<td><a style="'.$t_color.'" class="view_ilan_teklifleri" id="teklifler_'.$hepsini_oku['id'].'"><i class="fas fa-gavel">'.$toplam_teklif.'</i></a></td>    
													<td><a style="'.$t_color.'" class="view_ilan_mesajlari" id="mesajlar_'.$hepsini_oku['id'].'"><i class="fas fa-envelope">'.$mesaj_sayi.'</i></a></td>    
													<td><a style="'.$t_color.'" class="view_ilan_favorileri" id="'.$hepsini_oku['id'].'"><i class="fas fa-heart">'.$favori_sayi.'</i></a></td>    
													<td id="td_view_ilan_notlari_'.$hepsini_oku['id'].'"><a style="'.$t_color.'" class="view_ilan_notlari" id="'.$hepsini_oku['id'].'"><i class="fas fa-align-justify">'.$not_sayi.'</i></a></td>    
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
								<tr id="tr_'.$hepsini_oku["id"].'"  style="background-color: '.$tablo_rengi.';">
									<td><input type="checkbox" name="secim[]" class="chec" id="asd'.$gelen_id.'" value="'.$gelen_id.'" style="opacity:1!important; z-index:999;"></td>
									<td><a target="_blank" href="?modul=ilanlar&sayfa=ilan_ekle&id='.$gelen_id.'"><i class="fas fa-edit"></i></a></td>
									<td><a onclick="tabTrigger()" href="?modul=ilanlar&sayfa=ilan_ekle&id='.$gelen_id.'" target="_blank"><img style="width: 50px; height:50px;" src="../images/'.$resim.'" alt=""></a></td>
									<td>'.$hepsini_oku["arac_kodu"].'</td>
									<td>'.$hepsini_oku["plaka"].'</td>    
									<td>'.$hepsini_oku['sehir'].'</td>  
									<td style="'.$color2.'" ><a href="../arac_detay.php?id='.$gelen_id.'&q=ihale" style="'.$color2.'"  target="_blank">'.$arac_detaylari.'</a></td>    
									<td style="font-weight:bold;" class="kapanis2_zamani'.$sira.'" id="sayac'.$sira.'">
										<input type="hidden" id="ihale_sayac'.$sira.'" value="'.$tarih_ihale.'" >
										<input type="hidden" id="id_'.$sira.'" value="'.$hepsini_oku['id'].'">
									</td> 
									<td>
										<a style="cursor: pointer;" class="view_guncelle kapanis_zamani'.$sira.'" id="'.$hepsini_oku['id'].'">'.$kapanis_zamani.'</a>
									</td>
									<td class="'.$yan.'"><a class="view_uyeye_teklif_ver" style="font-size:19px; font-weight:bold;" id="sonteklif_'.$hepsini_oku['id'].'">'.money($hepsini_oku["son_teklif"]).'₺</a></td>   
									<!-- <td class="'.$yan.'">'.$hepsini_oku["son_teklif"].'</td>     -->
									<input type="hidden" id="teklif_sayisi'.$sira.'" value="'.$toplam_teklif.'" >
									<td><a class="view_ilan_teklifleri" id="teklifler_'.$hepsini_oku['id'].'"><i class="fas fa-gavel">'.$toplam_teklif.'</i></a></td>    
									<td><a class="view_ilan_mesajlari" id="mesajlar_'.$hepsini_oku['id'].'"><i class="fas fa-envelope">'.$mesaj_sayi.'</i></a></td>    
									<td><a class="view_ilan_favorileri" id="'.$hepsini_oku['id'].'"><i class="fas fa-heart">'.$favori_sayi.'</i></a></td>    
									<td id="td_view_ilan_notlari_'.$hepsini_oku['id'].'"><a class="view_ilan_notlari" id="'.$hepsini_oku['id'].'"><i class="fas fa-align-justify">'.$not_sayi.'</i></a></td>    
									<td>'.$sgrt_adi.'</td>
								</tr>
							';
							$sira++;
						}
					?>
				<?php }  } ?>
				<tbody><?= $td ?></tbody>
			</table>
		</div>
	</form>
<?php } ?>

<style>
	.pagination.special-form {
		display: flex;
		align-items: center;
		justify-content: flex-end;
	}

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
<div class="custom-large-modal modal fade" id="tarih_guncelle">
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
<div class="custom-large-modal modal fade" id="ilan_mesaj">
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
<div class="custom-large-modal modal fade" id="ilan_teklif">
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
<div style="width:50%;" class=" modal fade" id="uyeye_teklif">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
	</div>
   <div class="modal-dialog">
		<div class="modal-body" id="uyenin_teklifi">
		</div>
   </div>
</div>
<!-- Üye Adına Teklif Bitiş-->
<!-- İlan Notları Başlangıç-->
<div class="custom-large-modal modal fade" id="ilan_notlari">
	
	<div class="modal-dialog">
		<button type="button" id="ilanin_notlari_close" class="close" style="margin:2%" data-dismiss="modal" aria-hidden="true"></button>
		<div class="modal-body" id="ilanin_notlarini">
		</div>
	</div>
</div>
<!-- İlan Notları Bitiş-->
<!-- İlan Süre Uzat Başlangıç-->
<div class="modal fade" id="sure_uzat_ilan">
	
	<div class="modal-dialog">
		<button type="button" id="ilan_sure_uzatma_close" class="close" style="margin:2%" data-dismiss="modal" aria-hidden="true"></button>
		<div class="modal-body" id="ilan_sure_uzat">
		
		</div>
	</div>
</div>
<!-- İlan Süre Uzat Bitiş-->




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
					filtreleme: $('#filtreleme_durum').val()
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
					// if(response.ilan_durumu!="true" && document.getElementById("tr_"+id)!=undefined){
					// 	document.getElementById("tr_"+id).remove();
					// }

					if($('#filtreleme_durum').val() == 0){
						if(response.ilan_yeni_durum == 0){
							document.getElementById("tr_"+id).remove();
							clearInterval(x);
						}
					}

					/* if(response.ilan_yeni_durum == 0){
						if($('#filtreleme_durum').val() == 0){
							document.getElementById("tr_"+id).remove();
							clearInterval(x);
						}						
					} */
					var $teklif_sayi = `<i class="fas fa-gavel" aria-hidden="true">${response.toplam_teklif}</i>`;
					var $mesaj_sayi = `<i class="fas fa-envelope" aria-hidden="true">${response.mesaj_sayi}</i>`;
					
					//$('#mesajlar_'+id).html($mesaj_sayi);

					if(response.onaydaki_sayi == 1){
						$('#teklifler_'+id).html($teklif_sayi+'<p style="background-color:#0966f2; color:white;padding:5px;" class="blink"> YENİ</p>');
					}else{
						if(response.onay_bekleyen_teklif_var_mi == "1"){
							$('#teklifler_'+id).html($teklif_sayi+'<p style="background-color:red;color:white;padding:5px;" class="blink"> YENİ</p>');
						}else{
							if(response.yeni_teklif != 0){
								$('#teklifler_'+id).html($teklif_sayi+'<p style="background-color:red;color:white;padding:5px;" class="blink"> YENİ</p>');
							}else{
								$('#teklifler_'+id).html($teklif_sayi);
							}							
						}
					}
					if(response.okunmamis_mesaj_var_mi == "1"){
						$('#mesajlar_'+id).html($mesaj_sayi + '<p style="background-color:red; color: white;padding:5px;" class="blink"> Yeni</p>');
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
						$(".kapanis2_zamani"+sira).addClass("yan");	
						
					}else{
						$(".kapanis2_zamani"+sira).removeClass("yan");
					}
					
				}else{
					$(".kapanis2_zamani"+sira).removeClass("yan");
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
			if(document.getElementById(elementId)!=undefined){

				if(days == 0 && hours == 0 && minutes < 5){
					document.getElementById(elementId).innerHTML = '<span class="blink" style="color: red;" id="kalan_sayac_goster_'+sira+'">'+days + " gün " + hours + ":"+ minutes + ":" + seconds + ""+'</span>';
				}else{
					document.getElementById(elementId).innerHTML = '<span id="kalan_sayac_goster_'+sira+'">'+days + " gün " + hours + ":"+ minutes + ":" + seconds + ""+'</span>';
				}
			}
			
			if (distance < 0) 
			{
				sure_doldu(id);
				//clearInterval(x);
				document.getElementById(elementId).innerHTML = "Süre Doldu";

			}
		}, 1000);
		
	}
	

	for (var i = 0; i < ihale_say.value; i++) {
		createCountDown("sayac"+i,i);
	}
	
	
	
</script>


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
				
					mysql_query("INSERT INTO `yapilan_is` (`id`, `admin_id`, `yaptigi`,`aciklama`,`gizlilik`, `ekleme_zamani`, `ilan_id`, `dogrudan_id`, `uye_id`) VALUES 
					(NULL, '".$admin_id."', '2','".$eklenecek_not."','".$gizlilik."', '".$tarih."','".$gelen_id."','0','0');"); 
					if($a){
					echo '<script>alert("Başarıyla Eklendi..");</script>';
					header("Location:?modul=ihaleler&sayfa=tum_ihaleler");
				   }
				}
				else {
					$a=mysql_query("INSERT INTO `ilan_notlari` (`id`, `ilan_id`, `ekleyen`, `ilan_notu`, `gizlilik`, `tarih`, `dosya`) 
					VALUES (NULL, '".$gelen_id."', '".$admin_id."', '".$eklenecek_not."', '".$gizlilik."', '".$tarih."', '1')")or die(mysql_error()); 
				
					mysql_query("INSERT INTO `yapilan_is` (`id`, `admin_id`, `yaptigi`,`aciklama`, `gizlilik`, `ekleme_zamani`, `ilan_id`, `dogrudan_id`, `uye_id`) VALUES 
						(NULL, '".$admin_id."', '2','".$eklenecek_not."','".$gizlilik."', '".$tarih."','".$gelen_id."','0','0');"); 
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
		this.innerHTML = clicked ? 'Seçimleri Kaldır' : 'Seç';
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
		console.log(array);
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
	},3000);
	
	function filtre_cikar(key,value){
		
		if(key=="yil_" && value=="filtre"){
			$("#kucuk_yil").val("");
			$("#buyuk_yil").val("");
		}else if(key=="aranan" && value=="filtre"){
			$("#aranan").val("");
		}else if(key=="kucukbuyuk_" && value=="kapanis"){
			$("#kucuk_kapanis").val("");
			$("#buyuk_kapanis").val("");
		}else if(key=="kucuk_" && value=="kapanis"){
			$("#kucuk_kapanis").val("");
		}else if(key=="kucukbuyuk_" && value=="ekleme"){
			$("#kucuk_ekleme").val("");
			$("#buyuk_ekleme").val("");
		}else if(key=="kucuk_" && value=="ekleme"){
			$("#kucuk_ekleme").val("");
		}else{
			document.getElementById(""+key+value).checked=false
			if(key=="marka_"){
				$(".modelmarka_"+value).remove();
			}
		}
		
		document.getElementById("filtrele").click();
	}
	
	// $(".searchs").click(){
		// $(".general_search_check").css("display","none");
	// });
	
	

</script>