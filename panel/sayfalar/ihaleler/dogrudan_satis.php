<?php 
if (!isset($_GET['startrow']) or !is_numeric( $_GET['startrow'] ) ) {
	$startrow = 0;
} else {
	$startrow = (int) $_GET['startrow'];
}
	//$hepsini_cek = mysql_query("SELECT * FROM dogrudan_satisli_ilanlar ORDER BY bitis_tarihi DESC");

	$limit = 100;
	$page = (re("page") != "" && is_numeric(re("page"))) ? re("page") : 1;	
	$total_rows = mysql_num_rows(mysql_query("SELECT * FROM dogrudan_satisli_ilanlar WHERE durum = 1 AND bitis_tarihi > '".date("Y-m-d H:i:s")."'"));
	$total_page = ceil($total_rows / $limit);
	$page = ($page < 1) ? 1 : $page;
	$page = ($page > $total_page) ? $total_page : $page;
	$limit_start = ($page-1)*$limit;
	$limit_sql = "LIMIT ".$limit_start.",".$limit;


	// $hepsini_cek = mysql_query("SELECT * FROM dogrudan_satisli_ilanlar WHERE durum = 1 AND bitis_tarihi > '".date("Y-m-d H:i:s")."' order by bitis_tarihi asc ".$limit_sql);
	$hepsini_cek = mysql_query("SELECT * FROM dogrudan_satisli_ilanlar WHERE durum = 1 AND bitis_tarihi > '".date("Y-m-d H:i:s")."' order by bitis_tarihi asc ");
?>
<style>

	.blink {
		animation: blinker 0.9s linear infinite;
		/* animation: blink 1s linear infinite; */
		color: red;
		font-size: 15px;
		font-weight: bold;
		font-family: sans-serif;
	}
	@keyframes blinker {  
		50% { opacity: 0; }
	}


	table {
		border-collapse: collapse;
		border-spacing: 0;
		width: 100%;
		border: 1px solid #ddd;
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
	
	#hasardurumu {
		display: none;
		border: 1px #dadada solid;
	}

	#hasardurumu label {
		display: block;
	}

	#hasardurumu label:hover {
		background-color: #1e90ff;
	}
	
	.checker span input {
		opacity:1!important;
		margin-top: -3px !important;
	}
	.chec
	{
		opacity:1!important;
		z-index:999!important;
	}
	.general_search_check
	{
		position:relative;
		z-index:99;
	}
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
<script>
	var expanded = false;
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
	function showMarkalar() {
		var checkboxes = document.getElementById("markalar");
		if (!expanded) {
			checkboxes.style.display = "block";
			document.getElementById('markalar_backdrop').style.display = "block";
			expanded = true;
		} else {
			checkboxes.style.display = "none";
			document.getElementById('markalar_backdrop').style.display = "none";
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
	function showHasarDurumu() {
		var checkboxes = document.getElementById("hasardurumu");
		if (!expanded) {
			checkboxes.style.display = "block";
			document.getElementById('hasardurumu_backdrop').style.display = "block";
			expanded = true;
		} else {
			checkboxes.style.display = "none";
			document.getElementById('hasardurumu_backdrop').style.display = "none";
			expanded = false;
		}
	}
	
</script> 
<?php 
	$sehir_cek = mysql_query("SELECT * FROM sehir order by sehiradi asc"); 
	$marka_cek = mysql_query("SELECT * FROM marka order by marka_adi asc"); 
?>


<div class="select_backdrop" id="sehirler_backdrop" onclick="showSehirler()">
</div>

<div class="select_backdrop" id="markalar_backdrop" onclick="showMarkalar()">
</div>

<div class="select_backdrop" id="bitis_backdrop" onclick="showBitis()">
</div>

<div class="select_backdrop" id="profil_backdrop" onclick="showProfil()">
</div>

<div class="select_backdrop" id="aracdurumu_backdrop" onclick="showAracDurumu()">
</div>

<div class="select_backdrop" id="hasardurumu_backdrop" onclick="showHasarDurumu()">
</div>

<form method="POST" name="filter" id="filter">
	<div class="row-fluid">
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
				<div class="selectBox" onclick="showSehirler()">
					<select style="height:1.8em;">
						<option>Şehire Göre</option>
					</select>
					<div class="overSelect"></div>
				</div>
				<div class="general_search_check" id="sehirler">
					<label style="display: flex;">
						<input type="text" placeholder="Şehir Ara" id="sehir_filtre_input" onkeyup="sehir_display()"/>
					</label>
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
								<label class="filtre_sehir" for="<?= $sehir_oku['sehirID'] ?>">
								<input type="checkbox" <?=$sehir_check[$tu] ?> class="sehir_check" id="sehir_<?= $sehir_oku['sehiradi'] ?>" id="sehir_<?=$sehir_oku['sehiradi'] ?>" name="sehir[]" value="<?= $sehir_oku['sehiradi'] ?>" /><?= $sehir_oku['sehiradi'] ?>
							<?php $tu++; }
						?>
						<?php }else{
							while($sehir_oku = mysql_fetch_array($sehir_cek)){?>                        
								<label class="filtre_sehir" for="<?= $sehir_oku['sehirID'] ?>">
								<input type="checkbox" name="sehir[]" id="sehir_<?= $sehir_oku['sehiradi'] ?>" value="<?= $sehir_oku['sehiradi'] ?>" /><?= $sehir_oku['sehiradi'] ?></label>
							<?php } 
						}
					?>
				</div>
			</div>
			
			<div class="multiselect">
				<div class="selectBox" onclick="showMarkalar()">
					<select style="height:1.8em;">
						<option>Markaya Göre</option>
					</select>
					<div class="overSelect"></div>
				</div>
				<div class="general_search_check" id="markalar" >
					<label style="display: flex;">
						<input type="text" placeholder="Marka Ara" id="marka_filtre_input" onkeyup="marka_display()"/>
					</label>
					<?php
						$seciliMarkaSayisi = count($_POST['marka']);
						if($seciliMarkaSayisi!=0){
							$marka_check=array();
							$mu = 0;
							while($marka_oku = mysql_fetch_array($marka_cek)){
								$marka_say = mysql_query("SELECT * FROM dogrudan_satisli_ilanlar WHERE durum=1 and marka = '".$marka_oku['marka_adi']."'");
								$marka_sayi = mysql_num_rows($marka_say);
								$marka_check[$mu]="";
								for($i=0;$i<count($_POST['marka']);$i++){ 
									if($marka_oku["marka_adi"]==$_POST["marka"][$i]){
										$marka_check[$mu]="checked";
									}
								} ?>
								<label class="filtre_marka" style=" <?php /*if($marka_sayi == 0){ echo "display: none;"; }*/ ?>" for="<?= $marka_oku['markaID'] ?>">
								<input type="checkbox" <?=$marka_check[$mu] ?> id="marka_<?= $marka_oku['marka_adi'] ?>" name="marka[]" value="<?= $marka_oku['marka_adi'] ?>" /><?= $marka_oku['marka_adi'] ?></label>
							<?php $mu++; }
						?>
						<?php }else{
							while($marka_oku = mysql_fetch_array($marka_cek)){
								$marka_say = mysql_query("SELECT * FROM dogrudan_satisli_ilanlar WHERE durum=1 and marka = '".$marka_oku['marka_adi']."'");
								$marka_sayi = mysql_num_rows($marka_say);
							?>                        
								<label class="filtre_marka" style=" <?php /*if($marka_sayi == 0){ echo "display: none;"; }*/ ?>" for="<?= $marka_oku['markaID'] ?>">
								<input type="checkbox" name="marka[]" id="marka_<?= $marka_oku['marka_adi'] ?>" value="<?= $marka_oku['marka_adi'] ?>" /><?= $marka_oku['marka_adi'] ?></label>
							<?php } 
						}
					?>
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
						$ilan_tarihleri=mysql_query("select *,count(id) as ihale_sayisi from dogrudan_satisli_ilanlar where durum=1 group by bitis_tarihi");
						while($ilan_tarihleri_oku=mysql_fetch_array($ilan_tarihleri)){
							$tarih="";
							$kapanis_check[$tu]="";
							for($i=0;$i<count($_POST['tarih']);$i++){ 
								if($ilan_tarihleri_oku["bitis_tarihi"]==$_POST["tarih"][$i]){
									$kapanis_check[$tu]="checked";
								}
							} 
							if($ilan_tarihleri_oku["bitis_tarihi"]==date("Y-m-d")){
								$tarih="Bugün";
							}else if($ilan_tarihleri_oku["bitis_tarihi"]==date("Y-m-d", strtotime("+1 day"))){
								$tarih="Yarın";
							}else{
								$tarih=date("d-m-Y",strtotime($ilan_tarihleri_oku["bitis_tarihi"]));
							}
							?>
							<div style="<?php if($ilan_tarihleri_oku["ihale_sayisi"] == 0){ echo "display: none;"; } ?>">
								<input <?=$kapanis_check[$tu]?> type="checkbox" name="tarih[]" id="tarih_<?=$ilan_tarihleri_oku["bitis_tarihi"] ?>" value="<?=$ilan_tarihleri_oku["bitis_tarihi"] ?>" /><?=$tarih ?> 
							</div>
						<?php $tu++; } 
					} else { 
							$ilan_tarihleri=mysql_query("select *,count(id) as ihale_sayisi from dogrudan_satisli_ilanlar where durum=1 group by bitis_tarihi");
							while($ilan_tarihleri_oku=mysql_fetch_array($ilan_tarihleri)){
								$tarih="";
								if($ilan_tarihleri_oku["bitis_tarihi"]==date("Y-m-d")){
									$tarih="Bugün";
								}else if($ilan_tarihleri_oku["bitis_tarihi"]==date("Y-m-d", strtotime("+1 day"))){
									$tarih="Yarın";
								}else{
									$tarih=date("d-m-Y",strtotime($ilan_tarihleri_oku["bitis_tarihi"]));
								}
								?>
								<div style="<?php if($ilan_tarihleri_oku["ihale_sayisi"] == 0){ echo "display: none;"; } ?>">
									<input type="checkbox" name="tarih[]" id="tarih_<?=$ilan_tarihleri_oku["bitis_tarihi"] ?>" value="<?=$ilan_tarihleri_oku["bitis_tarihi"] ?>" /><?=$tarih ?> 
								</div>
							<?php 
							}
						?>
					<?php }  ?>
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
								<input id="aracdurumu_1" type="checkbox" name="arac_durumu[]" value="1" />Kazalı (En Ufak Bir Onarım Görmemiş)
							</label>
							<label for="aracdurumu_2"> 
								<input id="aracdurumu_2" type="checkbox" name="arac_durumu[]" value="2" />Kazalı (Hafif onarımlar yapılmış halk ağzıyla makyajlı)
							</label>
							<label for="aracdurumu_3"> 
								<input id="aracdurumu_3" type="checkbox" name="arac_durumu[]" value="3" />İkinci El (Pert Kayıtlı)
							</label>
							<label for="aracdurumu_4"> 
								<input id="aracdurumu_4" type="checkbox" name="arac_durumu[]" value="4" />İkinci El (Pert Kayıtsız)
							</label>
					<?php } ?>
				</div>
			</div>

			<div class="multiselect">
				<div class="selectBox" onclick="showHasarDurumu()">
					<select style="height:1.8em;">
						<option>Hasar Durumuna Göre</option>
					</select>
					<div class="overSelect"></div>
				</div>
				<div class="general_search_check" id="hasardurumu"> 
					<?php
						$seciliHasarDurumuSayisi = count($_POST['hasardurumu']);
						if($seciliHasarDurumuSayisi!=0){
							$carpma_check = "";
							$teknik_check = "";
							$selsu_check = "";
							$yanma_check = "";
							$calinma_check = "";
							$diger_check = "";
							$hasarsiz_check = "";
							for($i=0;$i<count($_POST["hasardurumu"]);$i++){
								if($_POST["hasardurumu"][$i]=="1"){
									$carpma_check="checked";
								}
								if($_POST["hasardurumu"][$i]=="2"){
									$teknik_check="checked";
								}
								if($_POST["hasardurumu"][$i]=="3"){
									$selsu_check="checked";
								}
								if($_POST["hasardurumu"][$i]=="4"){
									$yanma_check="checked";
								}
								if($_POST["hasardurumu"][$i]=="5"){
									$calinma_check="checked";
								}
								if($_POST["hasardurumu"][$i]=="6"){
									$diger_check="checked";
								}
								if($_POST["hasardurumu"][$i]=="7"){
									$hasarsiz_check="checked";
								}
							} ?>
							<label for="Çekme Belgeli/Pert Kayıtlı">                          
								<input <?= $carpma_check ?> type="checkbox" id="hasardurumu_1" name="hasardurumu[]" value="1"/>Çarpma, Çarpışma
							</label>
							<label for="Çekme Belgeli/Pert Kayıtlı">                          
								<input <?= $teknik_check ?> type="checkbox" id="hasardurumu_2" name="hasardurumu[]" value="2"/>Teknik Arıza
							</label>
							<label for="Çekme Belgeli/Pert Kayıtlı">                          
								<input <?= $selsu_check ?> type="checkbox" id="hasardurumu_3" name="hasardurumu[]" value="3"/>Sel/Su Hasarı
							</label>
							<label for="Çekme Belgeli/Pert Kayıtlı">                          
								<input <?= $yanma_check ?> type="checkbox" id="hasardurumu_4" name="hasardurumu[]" value="4"/>Yanma Hasarı
							</label>
							<label for="Çekme Belgeli/Pert Kayıtlı">                          
								<input <?= $calinma_check ?> type="checkbox" id="hasardurumu_5" name="hasardurumu[]" value="5"/>Çalınma
							</label>
							<label for="Çekme Belgeli/Pert Kayıtlı">                          
								<input <?= $diger_check ?> type="checkbox" id="hasardurumu_6" name="hasardurumu[]" value="6"/>Diğer
							</label>
							<label for="Çekme Belgeli/Pert Kayıtlı">                          
								<input <?= $hasarsiz_check ?> type="checkbox" id="hasardurumu_7" name="hasardurumu[]" value="7"/>Hasarsız
							</label>
				<?php }else{ ?>
					<label for="Çekme Belgeli/Pert Kayıtlı">                          
						<input type="checkbox" id="hasardurumu_1" name="hasardurumu[]" value="1"/>Çarpma, Çarpışma
					</label>
					<label for="Çekme Belgeli/Pert Kayıtlı">                          
						<input type="checkbox" id="hasardurumu_2" name="hasardurumu[]" value="2"/>Teknik Arıza
					</label>
					<label for="Çekme Belgeli/Pert Kayıtlı">                          
						<input type="checkbox" id="hasardurumu_3" name="hasardurumu[]" value="3"/>Sel/Su Hasarı
					</label>
					<label for="Çekme Belgeli/Pert Kayıtlı">                          
						<input type="checkbox" id="hasardurumu_4" name="hasardurumu[]" value="4"/>Yanma Hasarı
					</label>
					<label for="Çekme Belgeli/Pert Kayıtlı">                          
						<input type="checkbox" id="hasardurumu_5" name="hasardurumu[]" value="5"/>Çalınma
					</label>
					<label for="Çekme Belgeli/Pert Kayıtlı">                          
						<input type="checkbox" id="hasardurumu_6" name="hasardurumu[]" value="6"/>Diğer
					</label>
					<label for="Çekme Belgeli/Pert Kayıtlı">                          
						<input type="checkbox" id="hasardurumu_7" name="hasardurumu[]" value="7"/>Hasarsız
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
		</div>
	</div>
    <button type="submit" id="filtrele" name="filtrele" class="btn blue">Ara</button>
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
		$f_kelime = $_POST['aranan'];     
		$f_marka = $_POST['marka'];
		$f_sehir = $_POST['sehir'];
		$f_tarih = $_POST['tarih'];
		$f_profil = $_POST['profil'];
		$f_aracdurumu = $_POST['arac_durumu'];
		$f_hasardurumu = $_POST['hasardurumu'];
		$f_kucuk_yil = $_POST['kucuk_yil'];
		$f_buyuk_yil = $_POST['buyuk_yil'];
	
		$filtre_var="false";
		$filtreler="";
		$where = "WHERE durum = '1'";
		if($f_kelime !=""){
			$where .= "AND concat(plaka,model,arac_kodu,model_yili,sehir,ilce) LIKE '%".$f_kelime."%'";
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
		if($f_marka !=""){      
			$filtre_var="true";		
			$k = 0;
			$seciliMarkaSayisi = count($_POST['marka']);
			$seciliMarka = "";
			while ($k < $seciliMarkaSayisi) {
				
				$onclick=''; 
				$onclick='onclick="filtre_cikar(\'marka_\',\''.$_POST["marka"][$k].'\')"';
				$filtreler.='
					<div class="filter_box">
						'.$_POST["marka"][$k].'
						<div '.$onclick.' class="filter_box_close">
							x
						</div>
					</div>	
				';
				
				
				$seciliMarka = $seciliMarka . "'" . $_POST['marka'][$k] . "'";
				if ($k < $seciliMarkaSayisi - 1) {
					$seciliMarka = $seciliMarka . ", ";
				}
				$k++;
			}
			$where = $where . " AND marka in (" . $seciliMarka . ")";
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
				$i++;
			}
			$where = $where . " AND sehir in (" . $seciliSehir . ")";
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
				$p++;
			}
			$where = $where . " AND evrak_tipi in (" . $seciliProfil . ")";
		}
		
		if($f_aracdurumu !=""){
			$filtre_var="true";
			$p = 0;
			$seciliAracDurumuSayisi = count($_POST['arac_durumu']);
			$seciliAracDurumu = "";
			if(count($_POST['arac_durumu']) != 0){
				$where .= " AND( aracin_durumu <> 0 ";
			}
			while ($p < $seciliAracDurumuSayisi) {
				$onclick='';
				$post_aracdurumu="";
				if($_POST["arac_durumu"][$p]=="1"){
					$post_aracdurumu="Kazalı (En Ufak Bir Onarım Görmemiş)";
				}
				if($_POST["arac_durumu"][$p]=="2"){
					$post_aracdurumu="Kazalı (Hafif onarımlar yapılmış halk ağzıyla makyajlanmış)";
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
				$seciliAracDurumu = $seciliAracDurumu . "'" . $post_aracdurumu . "'";
				if ($p < $seciliAracDurumuSayisi - 1) {
					$seciliAracDurumu = $seciliAracDurumu . ", ";
				}
				$p ++;
				$where = $where . " or aracin_durumu = '".$post_aracdurumu."'";
			}
		
			$where .= " )";
		}
	
		if($f_hasardurumu !=""){
			$filtre_var="true";
			$h = 0;
			$seciliHasarDurumuSayisi = count($_POST['hasardurumu']);
			$seciliHasarDurumu = "";
			while ($h < $seciliHasarDurumuSayisi) {
				$onclick='';
				$post_hasardurumu="";
				if($_POST["hasardurumu"][$h]=="1"){
					$post_hasardurumu="Çarpma, Çarpışma";
				}
				if($_POST["hasardurumu"][$h]=="2"){
					$post_hasardurumu="Teknik Arıza";
				}
				if($_POST["hasardurumu"][$h]=="3"){
					$post_hasardurumu="Sel/Su Hasarı";
				}
				if($_POST["hasardurumu"][$h]=="4"){
					$post_hasardurumu="Yanma Hasarı";
				}
				if($_POST["hasardurumu"][$h]=="5"){
					$post_hasardurumu="Çalınma";
				}
				if($_POST["hasardurumu"][$h]=="6"){
					$post_hasardurumu="Diğer";
				}
				if($_POST["hasardurumu"][$h]=="7"){
					$post_hasardurumu="Hasarsız";
				}
				$onclick='onclick="filtre_cikar(\'hasardurumu_\',\''. $_POST['hasardurumu'][$h].'\')"';
				$filtreler.='
					<div class="filter_box">
						'.$post_hasardurumu.'
						<div '.$onclick.' class="filter_box_close">
							x
						</div>
					</div>	
				';  
				$seciliHasarDurumu = $seciliHasarDurumu . "'" . $_POST["hasardurumu"][$h] . "'";
				if ($h < $seciliHasarDurumuSayisi - 1) {
					$seciliHasarDurumu = $seciliHasarDurumu . ", ";
				}
				$h ++;
			}
			
			$where = $where . " AND hasar_durumu in (" . $seciliHasarDurumu . ")";
			
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
				$t++;
			}
			$where = $where . " AND bitis_tarihi in (" . $seciliTarih . ")";
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
			$where .= "AND  model_yili BETWEEN $f_kucuk_yil AND $f_buyuk_yil";
		}
		$filtre_cek = "SELECT * FROM dogrudan_satisli_ilanlar $where order by bitis_tarihi desc";
		// var_dump("SELECT * FROM dogrudan_satisli_ilanlar $where order by bitis_tarihi desc");
		$result = mysql_query($filtre_cek) or die(mysql_error());
		$sayi = mysql_numrows($result);
		if($sayi==0){
			echo '<script type="text/javascript">'; 
			echo 'alert("İstediğiniz kriterlere uygun araç bulunamadı.");'; 
			echo 'window.location.href = "?modul=ihaleler&sayfa=dogrudan_satis";';
			echo '</script>';    
		}else {  ?>
			<?php if($filtre_var=="true"){ ?>
			<p><a href="?modul=ihaleler&sayfa=dogrudan_satis">Tümünü Temizle</a></p>
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
			
		
			<form method="POST" action="?modul=ihaleler&sayfa=dogrudan_toplu_sil" >
			<?php
				$admin_yetki_cek=mysql_query("Select * from kullanicilar where id='".$admin_id."' ");
				$admin_yetki_oku=mysql_fetch_assoc($admin_yetki_cek);
				$yetkiler=$admin_yetki_oku["yetki"];
				$yetki_parcala=explode("|",$yetkiler);
				$btn='';
				if (in_array(2, $yetki_parcala) && in_array(1, $yetki_parcala) ) { 
				  $btn='<input type="submit" name="secili_sil" onclick="ConfirmDelete()" class="btn-danger" value="Seçili Olanları Sil">';
				}      
			?>    
				<a><? echo $btn ?></a>

				<div style="overflow-x:auto; margin-top:2%;">
					<table id="dogrudan_satis_table" class="table table-bordered" cellspacing="1" cellpadding="1">
						<thead>
						<tr>
							<td><input type="checkbox" id="checkle" class="checkall btn btn-blue chec2" style="padding:20px;opacity:1!important; z-index:999;"> Seç</td>
							<td>Düzenle</td>
							<td>Görseller</td>
							<td>Kod</td>
							<td>Plaka</td>
							<td>İl Adı</td>
							<td>Detaylar</td>
							<td>Yayın Bitiş Zamanı</td>
							<td>Fiyat</td>
							<td>Mesaj</td>
							<td>Favori</td>
							<td>Notlar</td>
							<td>Ekleyen</td>
						</tr>
						</thead>
						<tbody>
						<?php 
							while($filtre_oku = mysql_fetch_array($result)){
								$resim_cek = mysql_query("select * from dogrudan_satisli_resimler where ilan_id = '".$filtre_oku['id']."'");
								$resim_oku = mysql_fetch_assoc($resim_cek);
								// $mesaj_cek=mysql_query("SELECT * FROM mesajlar WHERE dogrudan_satis_id ='".$filtre_oku['id']."' ");
								// $mesaj_say=mysql_num_rows($mesaj_cek);
								$mesaj_cek = mysql_query("select * from chat_room where dogrudan_satis_id = '".$filtre_oku['id']."'");						
								$mesaj_say=mysql_num_rows($mesaj_cek);
								$resim = $resim_oku['resim'];
								$ilan_sahibi = $filtre_oku['ilan_sahibi'];
								$uye_cek = mysql_query("SELECT * FROM user WHERE user_token = '".$ilan_sahibi."' OR kurumsal_user_token = '".$ilan_sahibi."'");
								$uye_oku =  mysql_fetch_assoc($uye_cek);
								if(mysql_num_rows($uye_cek) != 0){
									$sahip = $uye_oku['ad'];
								}else{
									$sahip_admin_cek = mysql_query("select * from kullanicilar where token = '".$ilan_sahibi."'");
									$sahip_admin_oku = mysql_fetch_object($sahip_admin_cek);
									$sahip = $sahip_admin_oku->adi." ".$sahip_admin_oku->soyadi;
								}
				
								$marka_cek2 = mysql_query("select * from marka where markaID = '".$filtre_oku['marka']."'");
								$marka_oku2 = mysql_fetch_assoc($marka_cek2);
								$marka_adi2 = $marka_oku2['marka_adi'];
								$gelen_id = $filtre_oku['id'];
								$not_cek = mysql_query("SELECT * FROM dogrudan_satis_notlari WHERE dogrudan_id = '".$filtre_oku['id']."' group by tarih order by id desc");
								$not_sayi = mysql_num_rows($not_cek);
							?>
							<tr>
								<td><input type="checkbox" name="secim[]" class="chec" id="asd<?= $filtre_oku['id'] ?>" value="<?= $filtre_oku['id'] ?>" style="opacity:1!important; z-index:999;"></td>
								<td><a href="?modul=ihaleler&sayfa=dogrudan_satis_duzenle&id=<?=$filtre_oku['id']?>" style="text-decoration:none; color:black;" name="duzenle"><i class="fas fa-edit"></i></a></td>
								<td><a onclick="tabTrigger();" target="_blank" href="?modul=ihaleler&sayfa=dogrudan_satis_duzenle&id=<?= $filtre_oku['id'] ?>"><img style="width: 50px; height:50px;" src="../images/<?= $resim ?>" alt=""></a></td>
								<td><?=$filtre_oku["arac_kodu"]?></td>
								<td><?=$filtre_oku["plaka"]?></td>    
								<td><?= $filtre_oku["sehir"] ?></td>      
								<td>
									<a href="../arac_detay.php?id=<?= $filtre_oku['id'] ?>&q=dogrudan" target="_blank" style="text-decoration: none; color:#000000; cursor:pointer;"> 
										<?=$filtre_oku["model_yili"]." ".$filtre_oku["marka"]." ".$filtre_oku["model"]." ".$filtre_oku["uzanti"]?>
									</a>
								</td>    
								<td> <a class="view_dogrudan_guncelle" id="<?= $filtre_oku['id'] ?>"><?= date("d-m-Y",strtotime($filtre_oku['bitis_tarihi'])) ?></a></td>  
								<td style="font-weight:bold;"><?=money($filtre_oku["fiyat"]) ?> ₺</td>
								<td><a class="view_dogru_mesajlari dogrudan_ilan_<?= $filtre_oku['id'] ?>" id="<?= $filtre_oku['id'] ?>"><i class="fas fa-envelope"></i><?= $mesaj_say ?></a></td>    
								<td><a class="view_dogru_favorileri" id="<?= $filtre_oku['id'] ?>"><i class="fas fa-heart"></i><?= $favori_say ?></a></td>    
								<td id="td_view_dogru_notlari_<?=$hepsini_oku["id"] ?>"><a class="view_dogru_notlari" id="<?= $filtre_oku['id'] ?>"><i class="fas fa-align-justify"><?= $not_sayi ?></i></a></td>    
								<td><?=$sahip?></td>    
							</tr>
						<?php } }?>      
						</tbody>               
					</table>
				</div>
			</form>
<?php }else{ ?>
	<form method="POST" action="?modul=ihaleler&sayfa=dogrudan_toplu_sil" >
	<?php
		$admin_yetki_cek=mysql_query("Select * from kullanicilar where id='".$admin_id."' ");
		$admin_yetki_oku=mysql_fetch_assoc($admin_yetki_cek);
		$yetkiler=$admin_yetki_oku["yetki"];
		$yetki_parcala=explode("|",$yetkiler);
		$btn='';
		if (in_array(2, $yetki_parcala) && in_array(1, $yetki_parcala) ) { 
			$btn='<input type="submit" name="secili_sil"  onclick="ConfirmDelete()" class="btn-danger" value="Seçili Olanları Sil">';
		}      
	?>    
		<a><? echo $btn ?></a>
		<div style="overflow-x:auto; margin-top:2%;">
			<table id="dogrudan_satis_table" class="table table-bordered" cellspacing="1" cellpadding="1">
				<thead>
				<tr>
					<td><input type="checkbox" id="checkle" class="checkall btn btn-blue chec2" style="padding:20px;opacity:1!important; z-index:999;"> Seç</td>
					<td>Düzenle</td>
					<td>Görseller</td>
					<td>Kod</td>
					<td>Plaka</td>
					<td>İl Adı</td>
					<td>Detaylar</td>
					<td>Yayın Bitiş Zamanı</td>
					<td>Fiyat</td>
					<td>Mesaj</td>
					<td>Favori</td>
					<td>Notlar</td>
					<td>Ekleyen</td>
				</tr>
				</thead>
				<tbody>
				<?php 
					while($hepsini_oku = mysql_fetch_array($hepsini_cek)){
						$resim_cek = mysql_query("select * from dogrudan_satisli_resimler where ilan_id = '".$hepsini_oku['id']."'");
						$resim_oku = mysql_fetch_assoc($resim_cek);
						$resim = $resim_oku['resim'];
						$ilan_sahibi = $hepsini_oku['ilan_sahibi'];
						$uye_cek = mysql_query("SELECT * FROM user WHERE user_token = '".$ilan_sahibi."' OR kurumsal_user_token = '".$ilan_sahibi."'");
						$uye_oku =  mysql_fetch_assoc($uye_cek);
						// $sahip = $uye_oku['ad'];

						if(mysql_num_rows($uye_cek) != 0){
							$sahip = $uye_oku['ad'];
						}else{
							$sahip_admin_cek = mysql_query("select * from kullanicilar where token = '".$ilan_sahibi."'");
							$sahip_admin_oku = mysql_fetch_object($sahip_admin_cek);
							$sahip = $sahip_admin_oku->adi." ".$sahip_admin_oku->soyadi;
						}
		


						$dogrudan_satis_id = $hepsini_oku["id"];
						/*
						$mesaj_cek=mysql_query("SELECT * FROM mesajlar WHERE dogrudan_satis_id ='".$dogrudan_satis_id."' ");
						$mesaj_say=mysql_num_rows($mesaj_cek);	
						*/
						$mesaj_cek = mysql_query("select * from chat_room where dogrudan_satis_id = '".$dogrudan_satis_id."'");
						$mesaj_say=mysql_num_rows($mesaj_cek);

						$favori_cek = mysql_query("SELECT * FROM favoriler WHERE dogrudan_satisli_id ='".$dogrudan_satis_id."'");
						$favori_say=mysql_num_rows($favori_cek);	
						$not_cek = mysql_query("SELECT * FROM dogrudan_satis_notlari WHERE dogrudan_id = '".$dogrudan_satis_id."' group by tarih order by id desc");
						$not_sayi = mysql_num_rows($not_cek);
						$ili_cek = mysql_query("SELECT * FROM sehir WHERE plaka ='".$hepsini_oku['sehir']."'");
						$gelen_id = $hepsini_oku["id"]; ?>
					<tr>
						<td><input type="checkbox" name="secim[]" class="chec" id="asd<?= $hepsini_oku['id'] ?>" value="<?= $hepsini_oku['id'] ?>" style="opacity:1!important; z-index:999;"></td>
						<td><a href="?modul=ihaleler&sayfa=dogrudan_satis_duzenle&id=<?=$dogrudan_satis_id?>" target="_blank" style="text-decoration:none; color:black;" name="duzenle"><i class="fas fa-edit"></i></a></td>
						<td><a onclick="tabTrigger();" target="_blank" href="?modul=ihaleler&sayfa=dogrudan_satis_duzenle&id=<?= $hepsini_oku['id'] ?>"><img style="width: 50px; height:50px;" src="../images/<?= $resim ?>" alt=""></a></td>
						<td><?=$hepsini_oku["arac_kodu"]?></td>
						<td><?=$hepsini_oku["plaka"]?></td>    
						<td><?= $hepsini_oku["sehir"] ?></td>      
						<td><a href="../arac_detay.php?id=<?= $hepsini_oku['id'] ?>&q=dogrudan" target="_blank" style="text-decoration: none; color:#000000; cursor:pointer;"> 
						<?=$hepsini_oku["model_yili"]." ".$hepsini_oku["marka"]." ".$hepsini_oku["model"]." ".$hepsini_oku["uzanti"]?>
						</a></td>    
						<td><a class="view_dogrudan_guncelle" id="<?= $dogrudan_satis_id ?>"><?= date("d-m-Y",strtotime($hepsini_oku['bitis_tarihi'])) ?></a></td>  
						<td style="font-weight:bold;"><?=money($hepsini_oku["fiyat"])?> ₺</td>
						<td><a class="view_dogru_mesajlari  dogrudan_ilan_<?= $hepsini_oku['id'] ?>" id="<?= $hepsini_oku['id'] ?>"><i class="fas fa-envelope"><?=$mesaj_say ?></i></a></td>    
						<td><a class="view_dogru_favorileri" id="<?= $hepsini_oku['id'] ?>"><i class="fas fa-heart"><?=$favori_say ?></i></a></td>    
						<td id="td_view_dogru_notlari_<?=$hepsini_oku["id"] ?>"><a class="view_dogru_notlari" id="<?= $hepsini_oku['id'] ?>"><i class="fas fa-align-justify"><?= $not_sayi ?></i></a></td>    
						<td><?= $sahip ?></td>    
					</tr>
					<?php } ?>
					</tbody>
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

<!-- Guncelleme-->
<div class="modal fade" id="tarih_guncelle">
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

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
	//Tarih Guncelle
	$(document).ready(function(){
		$(document).on('click', '.view_dogrudan_guncelle', function(){
			var employee_id = $(this).attr("id");
			if(employee_id != ''){  
				$.post('sayfalar/ihaleler/tarih_guncelle.php', {'id':employee_id}, function(response){
					$('#ihale_guncelle').html(response);
					$('#tarih_guncelle').modal('show')
				})
			}
		});
	});
</script>
<script type="text/javascript">
	function ConfirmDelete(){
		if(confirm("Silmek İsteğinize Emin Misiniz?")){
			location.href='linktoaccountdeletion';
		}
	}
</script>

<?php 
	if((re('ihale_tarih_degisir')=="Kaydet")){
		$guncel_tarih = re('tarih_guncelle');
		$ilanin_id = re('ilanin_id');
		mysql_query("UPDATE dogrudan_satisli_ilanlar SET bitis_tarihi = '".$guncel_tarih."', durum = 1 WHERE id='".$ilanin_id."'");
		header("Refresh:0");
	}	
?>


<!-- İlan Notları-->

<div class="custom-large-modal modal fade" id="dogrudan_notlari">
	<button type="button" id="dogrudan_notlari_close" class="close" style="margin-right: 2%; margin-top:2%;" data-dismiss="modal" aria-hidden="true"></button>
	<div class="modal-dialog">
		<div class="modal-body" id="dogrudanin_notlarini">
		</div>
	</div>
</div>

<!-- İlan Fav-->
<div class="modal fade" id="ilan_fav">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
	</div>
	<div class="modal-dialog">
		<div class="modal-body" id="fav_ilan"></div>
	</div>
</div>

<!-- İlan Mesaj-->
<div style="width:60%;" class="modal fade" id="ilan_mesaj">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
	</div>
	<div class="modal-dialog">
		<div class="modal-body" id="mesaj_ilan">
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
					$a=mysql_query("INSERT INTO `dogrudan_satis_notlari` (`id`, `dogrudan_id`, `ekleyen`, `ilan_notu`, `gizlilik`, `tarih`, `dosya`) 
					VALUES (NULL, '".$gelen_id."', '".$admin_id."', '".$eklenecek_not."', '".$gizlilik."', '".$tarih."', '".$yenisim."')")or die(mysql_error()); 
				
					mysql_query("INSERT INTO `yapilan_is` (`id`, `admin_id`, `yaptigi`,`aciklama`, `ekleme_zamani`, `ilan_id`, `dogrudan_id`, `uye_id`) VALUES 
					(NULL, '".$admin_id."', '2','".$eklenecek_not."', '".$tarih."','0','".$gelen_id."','0');"); 
					if($a){
					echo '<script>alert("Başarıyla Eklendi..");</script>';
					header("Location:?modul=ihaleler&sayfa=dogrudan_satis");
				   }
				}
				else {
					$a=mysql_query("INSERT INTO `dogrudan_satis_notlari` (`id`, `dogrudan_id`, `ekleyen`, `ilan_notu`, `gizlilik`, `tarih`, `dosya`) 
					VALUES (NULL, '".$gelen_id."', '".$admin_id."', '".$eklenecek_not."', '".$gizlilik."', '".$tarih."', '1')")or die(mysql_error()); 
				
					mysql_query("INSERT INTO `yapilan_is` (`id`, `admin_id`, `yaptigi`,`aciklama`, `ekleme_zamani`, `ilan_id`, `dogrudan_id`, `uye_id`) VALUES 
						(NULL, '".$admin_id."', '2','".$eklenecek_not."', '".$tarih."','0','".$gelen_id."','0');"); 
					header("Location:?modul=ihaleler&sayfa=dogrudan_satis");
				}
			} 
		}
	}
?>

<script>
	function tabTrigger(){
		localStorage.setItem("gorsel_trigger","1");
	}
	//İlan Mesajları
	$(document).ready(function(){
		$(document).on('click', '.view_dogru_mesajlari', function(){
			var employee_id = $(this).attr("id");
			if(employee_id != ''){  
				$.post('sayfalar/ihaleler/dogrudan_mesajlari.php', {'id':employee_id}, function(response){
					$('#mesaj_ilan').html(response);
					$('#ilan_mesaj').modal('show')
				})
			}
		});
	});
	//İlan Favorileri
	$(document).ready(function(){
		$(document).on('click', '.view_dogru_favorileri', function(){
			var employee_id = $(this).attr("id");
			if(employee_id != ''){  
				$.post('sayfalar/ihaleler/dogrudan_favorileri.php', {'id':employee_id}, function(response){
					$('#fav_ilan').html(response);
					$('#ilan_fav').modal('show')
				})
			}
	  });
	});

	//İlan Notları
	$(document).ready(function(){
		$(document).on('click', '.view_dogru_notlari', function(){
			var employee_id = $(this).attr("id");
			if(employee_id != ''){  
				$.post('sayfalar/ihaleler/dogrudan_notlari.php', {'id':employee_id}, function(response){
					$('#dogrudanin_notlarini').html(response);
					$('#dogrudan_notlari').modal('show')
				})
			}
		});
	});
	var clicked = false;
	$(".checkall").on("click", function() {
		$(".chec").prop("checked", !clicked);
		clicked = !clicked;
		this.innerHTML = clicked ? 'Seçimleri Kaldır' : 'Tümünü Seç';
	});
	
	function filtre_cikar(key,value){
		
		if(key=="yil_" && value=="filtre"){
			$("#kucuk_yil").val("");
			$("#buyuk_yil").val("");
		}else if(key=="aranan" && value=="filtre"){
			$("#aranan").val("");
		}else{
			document.getElementById(""+key+value).checked=false
			if(key=="marka_"){
				$(".modelmarka_"+value).remove();
			}
		}
		
		document.getElementById("filtrele").click();
	}
	
	
	setInterval(function() {
		dogrudan_satis_okunmayan_mesajlar();
	}, 3000);
	
	function dogrudan_satis_okunmayan_mesajlar(){
		jQuery.ajax({
			url: "../check.php",
			type: "POST",
			dataType: "JSON",
			data: {
				action: "panel_dogrudan_mesaj_sayi"
			},
			success: function(response) {
				jQuery.each(response.data, function(index, value){
					if(value.unread != 0){
						$('.dogrudan_ilan_'+value.ilan_id).html(`<i class="fas fa-envelope"></i>${value.room_count}<p style="background-color:red; color: white;padding:5px;" class="blink"> Yeni</p>`);
					}else{
						$('.dogrudan_ilan_'+value.ilan_id).html(`<i class="fas fa-envelope"></i>${value.room_count}`);
					}
				})
				
			}
		});
	}
	

</script>

