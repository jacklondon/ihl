<?php 
	session_start();
	$admin_id=$_SESSION['kid'];
	$uyeleri_cek = mysql_query("SELECT user.*,onayli_kullanicilar.id as o_id FROM `user` inner join onayli_kullanicilar on user.id=onayli_kullanicilar.user_id where onayli_kullanicilar.durum=1 ORDER BY id DESc");
	$sehir_cek = mysql_query("SELECT * FROM sehir");
	$admin_cek = mysql_query("SELECT * FROM kullanicilar");
	$array=array();
?>
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.10/jquery.mask.js"></script>
	<script src="js/uyeler_modal.js?v=<? echo time();?>"></script>
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
	.offscreen {
		opacity: 0;
		position: absolute;
		z-index: -9999;
		pointer-events: none;
	}
</style>
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
	function showAdminler() {
		var checkboxes = document.getElementById("adminler");
		if (!expanded) {
			checkboxes.style.display = "block";
			expanded = true;
		} else {
			checkboxes.style.display = "none";
			expanded = false;
		}
	}
	function showGrup() {
		var checkboxes = document.getElementById("uye_grubu");
		if (!expanded) {
			checkboxes.style.display = "block";
			expanded = true;
		} else {
			checkboxes.style.display = "none";
			expanded = false;
		}
	}
	function showDurum() {
		var checkboxes = document.getElementById("uye_durumu");
		if (!expanded) {
			checkboxes.style.display = "block";
			expanded = true;
		} else {
			checkboxes.style.display = "none";
			expanded = false;
		}
	} 
</script>   
<form method="POST" name="filter" id="filter">
	<div class="row-fluid" style="margin-top: 2%;">
		<div class="span6">
			<label for="IDofInput">Kelime İle Ara</label>
			<input type="search" name="aranan" class="span12" placeholder="Mail, telefon, cinsiyet, ad, şehir vb..">
			<div class="multiselect">
				<div class="selectBox" onclick="showSehirler()">
					<select style="height:1.8em;" class="span12">
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
			</div>
			<label for="IDofInput">Telefon Numarasına Göre</label>
			<input type="tel" name="aranan_tel" class="span12">
			<label for="IDofInput">Mail Adresine Göre</label>
			<input type="email" name="aranan_mail" class="span12">
			<div class="multiselect">
				<div class="selectBox" onclick="showDurum()">
					<select style="height:1.8em;" class="span12">
						<option>Üye Durumuna Göre</option>
					</select>
					<div class="overSelect"></div>
				</div>
				<div id="uye_durumu">
					<input type="checkbox" name="uye_durum[]" value="1" />Aktif</label><br>
					<input type="checkbox" name="uye_durum[]" value="2" />Teklif Kısıtlaması (Admin)</label><br>
					<input type="checkbox" name="uye_durum[]" value="3" />Teklif Kısıtlaması (Risk)</label><br>
					<input type="checkbox" name="uye_durum[]" value="4" />Sisteme Giriş Kısıtlaması</label><br>
					<input type="checkbox" name="uye_durum[]" value="5" />Üyelik İptali</label><br>
				</div>
			</div>
		</div>
		<div class="span6">
			<label for="IDofInput">Kayıt Tarihine Göre</label>
			<input type="date" name="kayit1" class="span12">     
			<input type="date" name="kayit2" class="span12">
			<label for="IDofInput">Son Giriş Aralığına Göre</label>
			<input type="date" name="giris1" class="span12">     
			<input type="date" name="giris2" class="span12">
			<div class="multiselect">
				<div class="selectBox" onclick="showAdminler()">
					<select style="height:1.8em;" class="span12">
						<option>Müşteri Temsilcisine Göre</option>
					</select>
					<div class="overSelect"></div>
				</div>
				<div id="adminler">
					<?php while($admin_oku = mysql_fetch_array($admin_cek)){?>                        
						<label for="<?= $admin_oku['id'] ?>">
						<input type="checkbox" name="admin[]" value="<?= $admin_oku['id'] ?>" /><?= $admin_oku['adi'] ?></label>
					<?php } ?> 
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
				<div id="uye_grubu">
					<?php while($uye_grup_oku = mysql_fetch_array($uye_grup_cek)){ ?>
						<input type="checkbox" name="grup[]" value="<?= $uye_grup_oku['id'] ?>" /><?= $uye_grup_oku['grup_adi'] ?></label><br>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>
	<button type="submit" name="filtrele" class="btn blue">Ara</button>
</form>
<?php
	function tarih_saat_formatla($tarih)
	{
		$date = str_replace('/', '-', $tarih);
		$yeni_tarih=date('d-m-Y H:i:s', strtotime($date));
		return $yeni_tarih;
	}
	function tarih_saat_formatla_yeni($tarih_yeni)
	{
		$date = str_replace('/', '-', $tarih_yeni);
		$yeni_tarih=date('d-m-Y H:i:s', strtotime($date));
		return $yeni_tarih;
	}

	if(isset($_POST['filtrele']))
	{                    
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
		$where = "WHERE u.id > '0'";
		if($f_kelime !=""){
			$where .= "AND concat(ad,cinsiyet,mail,uye_olma_sebebi,sehir,meslek,ilgilendigi_turler,adres,kargo_adresi,fatura_adresi,paket,unvan,vergi_dairesi,yedek_kisi,tc_kimlik,sehir,ilce) LIKE '%".$f_kelime."%'";
		}
		if($f_telefon !=""){
			$where .= "AND concat(telefon,sabit_tel) LIKE '%".$f_telefon."%' or yedek_kisi_tel LIKE '%".$f_telefon."%' ";
		}
		if($f_mail !=""){
			$where .= "AND concat(mail,ad) LIKE '%".$f_mail."%'";
		}

		if($f_ilk_tarih !="" && ($f_ikinci_tarih !="" && $f_ikinci_tarih !="01-01-1970 03:00:00" )){
				$f_ilk_tarih_yeni = date("Y-m-d H:i:s",strtotime($f_ilk_tarih));
				$f_ikinci_tarih_yeni = date("Y-m-d",strtotime($f_ikinci_tarih));
				$f_ikinci_tarih_yeni = $f_ikinci_tarih_yeni." 23:59:59";
				if( $f_ikinci_tarih_yeni != '1970-01-01 23:59:59' || $f_ilk_tarih_yeni != '1970-01-01 03:00:00' ){
					$where .= " AND  kayit_tarihi BETWEEN '".$f_ilk_tarih_yeni."' AND '".$f_ikinci_tarih_yeni."' ";
				}
		
		}else if($f_ilk_tarih !="" && ($f_ikinci_tarih == "" || $f_ikinci_tarih == "01-01-1970 03:00:00" ) ){
			$f_ilk_tarih_yeni = date("Y-m-d",strtotime($f_ilk_tarih));
			if($f_ilk_tarih_yeni != '1970-01-01' ){
				$where .= "AND  kayit_tarihi ='".$f_ilk_tarih_yeni."'";
			}
			  
		
		}
		
		if($f_giris1 !="" && ($f_giris2 !="" && $f_giris2=='01-01-1970 03:00:00' ) ){
			$f_giris1_yeni = date("Y-m-d H:i:s",strtotime($f_giris1));
			$f_giris2_yeni = date("Y-m-d",strtotime($f_giris2));
			$f_giris2_yeni = $f_giris2_yeni." 23:59:59";
			if( $f_giris1_yeni != '1970-01-01 23:59:59' ||  $f_giris2_yeni != '1970-01-01 03:00:00' ){
			    $where .= " AND  son_islem_zamani BETWEEN '".$f_giris1_yeni."' AND '".$f_giris2_yeni."'";
			}
        
		}else if($f_giris1 !="" && ($f_giris2 =="" || $f_girs2=="01-01-1970 03:00:00" )){
			$f_giris1_yeni = date("Y-m-d",strtotime($f_giris1));
			if( $f_giris1_yeni != '1970-01-01 23:59:59' ||  $f_giris2_yeni != '1970-01-01 03:00:00' ){
				$where .= "AND  son_islem_zamani ='".$f_giris1_yeni."'";
			}
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
				$i++;
			}
			$where = $where . " AND sehir in (" . $seciliSehir . ")";
		}
		if($f_admin !=""){
			$i = 0;
			$seciliAdminSayisi = count($_POST['admin']);
			$seciliAdmin = "";
			while ($i < $seciliAdminSayisi) {
				$seciliAdmin = $seciliAdmin . "'" . $_POST['admin'][$i] . "'";
				if ($i < $seciliAdminSayisi - 1) {
					$seciliAdmin = $seciliAdmin . ", ";
				}
				$i++;
			}
			$where = $where . " AND temsilci_id in (" . $seciliAdmin . ")";
		}
		if($f_grup !=""){
			$i = 0;
			$seciliGrupSayisi = count($_POST['grup']);
			$seciliGrup = "";
			while ($i < $seciliGrupSayisi) {
				$seciliGrup = $seciliGrup . "'" . $_POST['grup'][$i] . "'";
				if ($i < $seciliGrupSayisi - 1) {
					$seciliGrup = $seciliGrup . ", ";
				}
				$i++;
			}
			$where = $where . " AND paket in (" . $seciliGrup . ")";
		}
		if($f_uye_durum !=""){
			$d = 0;
			$seciliDurumSayisi = count($_POST['uye_durum']);
			$seciliDurum = "";
			while ($d < $seciliDurumSayisi) {
				if($_POST['uye_durum'][$d]=="1"){
					$seciliDurum.=" and online_durum=1 ";
				}else if($_POST['uye_durum'][$d]=="2"){
					$seciliDurum.=" and u_d.teklif_engelle='on' ";
				}else if($_POST['uye_durum'][$d]=="3"){
					$seciliDurum.=" and u_d.otomatik_teklif_engelle='on' ";
				}else if($_POST['uye_durum'][$d]=="4"){
					$seciliDurum.=" and u_d.kalici_mesaj='on' ";
				}else if($_POST['uye_durum'][$d]=="5"){
					$seciliDurum.=" and u_d.uyelik_iptal='on' ";
				}else{
					$seciliDurum.="";
				}
				$d++;
			}
				$where=$where.$seciliDurum;
		}
		// $filtre_cek = "SELECT * FROM user $where";
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
		$result = mysql_query($filtre_cek) or die(mysql_error());
		$sayi = mysql_num_rows($result);
		if($sayi==0){
			echo '<script type="text/javascript">'; 
			echo 'alert("İstediğiniz kriterlere uygun kullanıcı bulunamadı.");'; 
			echo '</script>';                       
		}else{ 
			
			echo $sayi . "Adet sonuç listelendi."
		?>
			<div class="row-fluid" style="margin-top:3%;">
				<form name="form" id="form" method="POST" enctype="multipart/form-data">
					<label for="IDofInput">Mail Konusu</label>
					<input type="text" id="mail_konusu" name="mail_konusu" class="span12">
					<label for="IDofInput">Mail İçeriği</label>
					<textarea name="icerik" id="icerik" class="span12" rows="6" required></textarea>
					<label for="IDofInput">Gönderilecek Kişiler</label>

					<?php 
					/* 
						<select multiple="multiple" name="gonderilecek_kisiler[]" class="span12" required style="height:250px;">
							<?php 
								while($uye_oku = mysql_fetch_array($result)){
							?>
								<option value="<?= $uye_oku['mail'] ?>"><?= $uye_oku['ad'] ?></option>
							<?php } ?>
						</select>
					*/
					?>
			
					<?php 
						while($uye_oku = mysql_fetch_array($result)){
							array_push($array,$uye_oku['mail']);
					?>
							<span ><?= $uye_oku['ad'] ?></span><br/>
							
					<?php }   $array = implode(",", $array); ?>
					
					<div class="form-actions">
						<div class="span4"></div>
						<div class="span4"><input type="button" onclick="mail_gonder('<?=$array ?>')" id="email_gonder" name="emaili" class="btn-primary btn-block" value="Kaydet"></div>
						<div class="span4"></div>
					</div>
				</form>
			</div>
		<?php 
	
		if(re('emaili')=='Kaydet'){
			var_dump($_POST['gonderilecek_kisiler']);
			$konu = re('mail_konusu');   
			$icerik = nl2br(htmlspecialchars($_POST['icerik']));
			$alicilar = $_POST['gonderilecek_kisiler'];
			$alici_sayi = count($alicilar);
			foreach($alicilar as $alici){
	
				$a=sendEmail($alici,$alici,$konu,$icerik,'');
				
			}
		}
	?> 
	<?php  
		}
	} else { ?>
		<?php 
		   $uye_cek = mysql_query("SELECT u.* FROM user as u inner join onayli_kullanicilar as o_k on u.id=o_k.user_id");
		?>
		<div class="row-fluid" style="margin-top:3%;">
			<form name="form" id="form" method="POST" enctype="multipart/form-data">
				<label for="IDofInput">Mail Konusu</label>
				<input type="text" name="mail_konusu" id="mail_konusu" class="span12">
				<label for="IDofInput">Mail İçeriği</label>
				<textarea name="icerik" id="icerik" class="span12" rows="6" required></textarea>
				<label for="IDofInput">Gönderilecek Kişiler</label>
				<?php 
				 /*
				<select multiple="multiple" name="gonderilecek_kisiler[]" class="span12" required style="height:250px;">
					<?php 
						while($uye_oku = mysql_fetch_array($uye_cek)){
					?>
						<option value="<?= $uye_oku['mail'] ?>"><?= $uye_oku['ad'] ?></option>
					<?php } ?>
				</select>
				*/
				?>
				<?php 
					while($uye_oku = mysql_fetch_array($uye_cek)){
						array_push($array,$uye_oku['mail']);
				?>
					<span ><?= $uye_oku['ad'] ?></span><br/>
				<?php }  $array = implode(",", $array);  ?>
				<div class="form-actions">
					<div class="span4"></div>
					<div class="span4"><input type="button" onclick="mail_gonder('<?=$array ?>')" id="email_gonder" name="emaili"  class="btn-primary btn-block" value="Kaydet"></div>
					<div class="span4"></div>
				</div>
			</form>
		</div>
	<?php 
		if(re('emaili')=='Kaydet'){
			var_dump("");
			$konu = re('mail_konusu');   
			$icerik = nl2br(htmlspecialchars($_POST['icerik']));
			//$alicilar = $_POST['gonderilecek_kisiler'];
			$alici_sayi = count($alicilar);
			foreach($array as $alici){
				$a=sendEmail($alici,$alici,$konu,$icerik,'');
			}
		}
	?> 
		
	<?php } ?>
  
	<script>
		/*function phoneMask() { 
			var num = $(this).val().replace(/\D/g,''); 
			$(this).val(num.substring(0,1) + '(' + num.substring(1,4) + ')' + num.substring(4,7) + '-' + num.substring(7,11)); 
		}
		$('[type="tel"]').keyup(phoneMask);*/
		$('input[type="tel"]').mask('0(000)000-0000'); 
	</script>
	<script>
		function mail_gonder(array){
			var mail_konusu=$('#mail_konusu').val();
			var mail_icerik=$('#icerik').val();
			var arr = array.split(",");
			console.log(arr)
			console.log(JSON.stringify(arr))
			jQuery.ajax({
				url: "https://ihale.pertdunyasi.com/check.php",
				method: 'POST',
				dataType: "json",
				data: {
					action:"panel_mail_gonder",
					mailler:JSON.stringify(arr),
					mail_konusu:mail_konusu,
					mail_icerik:mail_icerik,
				},
				success: function(data) {
					console.log(data);
				}
			});
		}
	</script>