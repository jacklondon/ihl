<!-- BEGIN PAGE HEADER-->
				<div class="row-fluid">
					<div class="span12">
						<!-- BEGIN STYLE CUSTOMIZER -->
						<?php 
						/*
						<div class="color-panel hidden-phone">
							<div class="color-mode-icons icon-color"></div>
							<div class="color-mode-icons icon-color-close"></div>
							<div class="color-mode">
								<p>THEME RENKLERİ</p>
								<ul class="inline">
									<li class="color-black current color-default" data-style="default"></li>
									<li class="color-blue" data-style="blue"></li>
									<li class="color-brown" data-style="brown"></li>
									<li class="color-purple" data-style="purple"></li>
									<li class="color-white color-light" data-style="light"></li>
								</ul>
								<label class="hidden-phone">
								<input type="checkbox" class="header" checked value="" />
								<span class="color-mode-label">Sayfaya yayma</span>
								</label>							
							</div>
						</div>
						*/
						?>
						<!-- END BEGIN STYLE CUSTOMIZER -->   	
						<!-- BEGIN PAGE TITLE & BREADCRUMB-->			
						<h3 class="page-title">
							Giriş				
							<small>Özet İstatistikler</small>
						</h3>
						<ul class="breadcrumb">
							<li>
								<i class="icon-home"></i>
								<a href="index.php">Giriş</a> 
								<i class="icon-angle-right"></i>
							</li>
							<li><a href="#">İstatistikler</a></li>
							<li class="pull-right no-text-shadow" style="display:none;">
								<div id="dashboard-report-range" class="dashboard-date-range tooltips no-tooltip-on-touch-device responsive" data-tablet="" data-desktop="tooltips" data-placement="top" data-original-title="Change dashboard date range">
									<i class="icon-calendar"></i>
									<span></span>
									<i class="icon-angle-down"></i>
								</div>
							</li>
						</ul>
						<!-- END PAGE TITLE & BREADCRUMB-->
					</div>
				</div>
				<!-- END PAGE HEADER-->

<style>
    thead{
        font-weight: 800;
    }
	.btn{
		background-color: orange !important;
		color: blue !important;
	}
</style>
<?php 
$bugun = date('Y-m-d');
$uye_cek = mysql_query("SELECT * FROM `user` ORDER BY kayit_tarihi DESC LIMIT 10");
$teklif_cek = mysql_query("SELECT * FROM teklifler where durum=1 ORDER BY teklif_zamani DESC LIMIT 10");
$mesaj_cek = mysql_query("SELECT * FROM mesajlar ORDER BY gonderme_zamani DESC LIMIT 10");
$talep_cek = mysql_query("SELECT * FROM gold_uyelik_talepleri ORDER BY basvuru_tarihi DESC LIMIT 10");
$dosya_cek = mysql_query("SELECT * FROM yuklenen_evraklar ORDER BY id DESC LIMIT 10");
$son_odeme_cek = mysql_query("SELECT * FROM kazanilan_ilanlar WHERE durum = 1 AND son_odeme_tarihi <= '".$bugun."' ORDER BY id DESC");
// $son_odeme_cek = mysql_query("SELECT * FROM kazanilan_ilanlar ORDER BY id DESC LIMIT 10");
//$cayma_talep_cek = mysql_query("SELECT * FROM cayma_bedelleri WHERE durum=3 ORDER BY id DESC LIMIT 10");
$cayma_talep_cek = mysql_query("SELECT * FROM cayma_bedelleri WHERE durum=2 ORDER BY id DESC ");

?>

<div class="row-fluid">
	<div class="btn-group">
		<a href="?modul=ilanlar&sayfa=ilan_ekle">
		<button class="btn" style="margin-left: 5px;"><i class="fas fa-plus"> İlan Ekle</i></button>
		</a>
		<a href="?modul=ihaleler&sayfa=bugun_bitenler">
		<button class="btn" style="margin-left: 5px;"><i class="fas fa-hourglass-start"> Bugün Bitenler</i></button>
		</a>
		<a href="?modul=ihaleler&sayfa=tum_ihaleler">
		<button class="btn" style="margin-left: 5px;"><i class="fas fa-car"> Tüm İhaleler</i></button>
		</a>
		<a href="?modul=muhasebe&sayfa=satilan_araclar">
		<button class="btn" style="margin-left: 5px;"><i class="fas fa-lira-sign"> Satılan Araçlar</i></button>
		</a>
		</a>
		<a href="?modul=bana_ozel&sayfa=uyelerim">
		<button class="btn" style="margin-left: 5px;"><i class="fas fa-user"> Üyelerim</i></button>
		</a>
		</a>
		<a href="?modul=uyeler&sayfa=toplu_mail_gonder">
		<button class="btn" style="margin-left: 5px;"><i class="fas fa-mail-bulk"> Mail Gönder</i></button>
		</a>
	</div>
</div>


	<table class="table table-bordered table-striped">
    <caption><h3 style="color: deepskyblue;">Üye Olan Son 10 Kullanıcı</h3></caption>
    <thead>
        <tr style="background-color: deepskyblue; color:white;">
            <th>Üye ID</th>
            <th>Ad</th>
            <th>Cinsiyet</th>
            <th>Telefon</th>
            <th>Mail</th>
            <th>Şehir</th>
            <th>Üyelik Tarihi</th>
        </tr>
    </thead>
    <tbody>
        <?php while($uye_oku = mysql_fetch_array($uye_cek)){
			if($uye_oku["user_token"] == ""){
				$uye_ad = $uye_oku["unvan"];
			}else{
				$uye_ad = $uye_oku["ad"];
			}
		?>
        <tr class="success">
            <td><?= $uye_oku["id"] ?></td>
            <td><a href="?modul=uyeler&sayfa=uye_duzenle&id=<?= $uye_oku["id"] ?>" target="_blank" style="text-decoration: none;"><?= $uye_ad ?></a></td>
            <td><?= $uye_oku["cinsiyet"] ?></td>
            <td><a href="tel:<?= $uye_oku['telefon'] ?>" style="color: #000000;"><?= $uye_oku["telefon"] ?></a></td>
            <td><?= $uye_oku["mail"] ?></td>
            <td><?= $uye_oku["sehir"] ?></td>
			<td><?= date("d-m-Y H:i:s",strtotime($uye_oku["kayit_tarihi"])) ?></td>
        </tr>
        <?php } ?>
    </tbody>
</table>
<p>
  <a href="?modul=uyeler&sayfa=uyeler"><button class=" btn-large btn-primary" type="button">Tüm Kullanıcıları Görüntüle</button></a>
</p>


<table class="table table-bordered table-striped" style="margin-top: 25px;">
	<caption><h3 style="color: #c92108;">Son 10 Teklif</h3></caption>
	<thead>
		<tr style="background-color: #c92108; color:white;">
			<th>Kod</th>
			<th>Plaka</th>
			<th>Arac Detay</th>
			<th>Teklifi Veren</th>
			<th>Teklif</th>
			<th>Teklif Zamanı</th>
		</tr>
	</thead>
	<tbody>
		<?php while($teklif_oku = mysql_fetch_array($teklif_cek)){
			$teklif_veren_cek = mysql_query("SELECT * FROM user WHERE id = '".$teklif_oku['uye_id']."'");
			$teklif_veren_oku = mysql_fetch_assoc($teklif_veren_cek);
			if($teklif_veren_oku["user_token"] == ""){
				$adi = $teklif_veren_oku["unvan"];
			}else{
				$adi = $teklif_veren_oku['ad'];
			}
			$telefonu = $teklif_veren_oku['telefon'];
			$ilani_cek = mysql_query("SELECT * FROM ilanlar WHERE id = '".$teklif_oku['ilan_id']."'");
			$ilani_oku = mysql_fetch_assoc($ilani_cek);
			$plaka = $ilani_oku['plaka'];
			$model_yili = $ilani_oku['model_yili'];
			$marka_bul = mysql_query("SELECT * FROM marka WHERE markaID = '".$ilani_oku['marka']."'");
			$marka_yaz = mysql_fetch_assoc($marka_bul);
			$marka = $marka_yaz['marka_adi'];
			$model = $ilani_oku['model'];
		?>
		<tr class="warning">
			<td><?= $ilani_oku["arac_kodu"] ?></td>
			<td><?= $ilani_oku["plaka"] ?></td>
			<td><a href="../arac_detay.php?id=<?= $teklif_oku["ilan_id"] ?>&q=ihale" target="_blank" style="text-decoration: none;"><?= $model_yili." ".$marka." ".$model." ".$plaka ?></a></td>			
			<td><a href="tel:<?= $telefonu ?>" style="color: #000000;"><?= $adi." ".$telefonu ?></a></td>
			<td><?= money($teklif_oku['teklif']) ?> ₺</td>		
			<td><?=  date("d-m-Y H:i:s",strtotime($teklif_oku["teklif_zamani"])) ?></td>
		</tr>
		<?php } ?>
	</tbody>
</table>

<?php 
	$mesaj_cek = mysql_query("select * from chat_messages where status = 1 order by id desc limit 10");
?>

<table class="table table-bordered table-striped" style="margin-top: 25px;">
	<caption><h3 style="color: #f26e09;">Son 10 Mesaj</h3></caption>
	<thead>
		<tr style="background-color: #f26e09;">
			<th>Plaka</th>
			<th>Kod</th>
			<th>Araç Detay</th>
			<th>Gönderen</th>
			<th>Alan</th>
			<th>Mesaj</th>
			<th>Gönderme Zamanı</th>			
		</tr>
	</thead>
	<tbody>
		<?php while($mesaj_oku = mysql_fetch_array($mesaj_cek)){ 
			$gonderen_bul = mysql_query("SELECT * FROM user WHERE id = '".$mesaj_oku['gonderen_id']."'");
			$gonderen_oku = mysql_fetch_assoc($gonderen_bul);

			$room_cek = mysql_query("select * from chat_room where id = '".$mesaj_oku["room_id"]."'");
			$room_oku = mysql_fetch_object($room_cek);
			
			if($mesaj_oku['gonderen_id']==0){
				$gonderen = "Admin";
			}else{
				if($gonderen_oku["user_token"] == ""){
					$gonderen = $gonderen_oku['unvan'];
				}else{
					$gonderen = $gonderen_oku['ad'];
				}
			}
			if($room_oku->alan_id == $mesaj_oku["gonderen_id"]){
				$alan_id = $room_oku->gonderen_id;
			}else{
				$alan_id = $room_oku->alan_id;
			}
			$alan_bul = mysql_query("SELECT * FROM user WHERE id = '".$alan_id."'");
			$alan_oku = mysql_fetch_assoc($alan_bul);
			if($alan_id==0){
				$alan = "Admin";
			}else{
				if($alan_oku["user_token"] == ""){
					$alan = $alan_oku['unvan'];
				}else{
					$alan = $alan_oku['ad'];
				}
			}
			
			if($room_oku->ilan_id == 0){
				$ilan_cek = mysql_query("select * from dogrudan_satisli_ilanlar where id = '".$room_oku->dogrudan_satis_id."'");
				$ilan_oku = mysql_fetch_object($ilan_cek);
				$arac_detay = '<a href="../arac_detay.php?id='.$ilan_oku->id.'&q=dogrudan" target="_blank" style="text-decoration: none;">
				'.$ilan_oku->model_yili.' '.$ilan_oku->marka.' '.$ilan_oku->model.' '.$ilan_oku->uzanti.'
				</a>';
			}else{
				$ilan_cek = mysql_query("select * from ilanlar where id = '".$room_oku->ilan_id."'");
				$ilan_oku = mysql_fetch_object($ilan_cek);
				$marka_cek = mysql_query("select * from marka where markaID = '".$ilan_oku->marka."'");
				$marka_oku = mysql_fetch_object($marka_cek);
				$arac_detay = '<a href="../arac_detay.php?id='.$room_oku->ilan_id.'&q=ihale" target="_blank" style="text-decoration: none;">
					'.$ilan_oku->model_yili.' '.$marka_oku->marka_adi.' '.$ilan_oku->model.' '.$ilan_oku->tip.'
				</a>';
			}

		?>
		<tr class="info">
			<td><?= $ilan_oku->plaka ?></td>
			<td><?= $ilan_oku->arac_kodu ?></td>
			<td><?= $arac_detay ?></td>
			<td><?= $gonderen ?></td>
			<td><?= $alan ?></td>
			<td><?= $mesaj_oku['mesaj'] ?></td>
			<td><?= date("d-m-Y H:i:s",strtotime($mesaj_oku["add_time"])) ?></td>
		</tr>
		<?php } ?>
	</tbody>
</table>

<table class="table table-bordered table-striped" style="margin-top: 25px;">
    <caption><h3 style="color: #0837e0;">Altın Üye Başvurusu Yapan Son 10 Üye</h3></caption>
    <thead>
        <tr style="background-color: #0837e0; color:white;">
            <th>Ad </th>
            <th>Şehir</th>
            <th>Başvuru Tarihi</th>
            <th>Durum</th>
        </tr>
    </thead>
    <tbody>
        <?php while($talep_oku = mysql_fetch_array($talep_cek)){ 
			$basvuru_uye_cek = mysql_query("SELECT * FROM user WHERE id = '".$talep_oku['uye_id']."'");
			$basvuru_uye_oku = mysql_fetch_assoc($basvuru_uye_cek);
			if($basvuru_uye_oku["user_token"] == ""){
				$basvuru_uye_adi = $basvuru_uye_oku["unvan"];
			}else{
				$basvuru_uye_adi = $basvuru_uye_oku['ad'];
			} 
			
			$paket_cek = mysql_query("SELECT * FROM uye_grubu WHERE id = '".$talep_oku['tur']."'");
			$paket_oku = mysql_fetch_assoc($paket_cek);
			$paket_adi = $paket_oku['grup_adi'];
			$durum = $talep_oku['durum'];
			if($durum==0){
				$durum = "Onay Bekliyor";
			}elseif($durum==1){
				$durum = "Onaylandı";
			}elseif($durum == 2){
				$durum = "Reddedildi";
			}
		?>
        <tr style="color: #0837e0; background-color:white;">
            <td><a href="?modul=uyeler&sayfa=uye_duzenle&id=<?= $basvuru_uye_oku["id"] ?>" target="_blank" style="text-decoration: none;"><?= $basvuru_uye_adi ?></a></td>
            <td><?= $basvuru_uye_oku["sehir"] ?></td>
			<td><?= date("d-m-Y H:i:s",strtotime($talep_oku["basvuru_tarihi"])) ?></td>
			<td><?= $durum ?></td>
        </tr>
        <?php } ?>
    </tbody>
</table>


<table class="table table-bordered table-striped" style="margin-top: 25px;">
    <caption><h3 style="color: #024905;">Dosya Yükleyen Son 10 Kullanıcı</h3></caption>
    <thead>
        <tr style="background-color: #024905; color:white;" >
            <th>Ad </th>
            <th>Dosya</th>
            <th>Tarih</th>
        </tr>
    </thead>
    <tbody>
        <?php 
		$dosya_cek = mysql_query("select * from yuklenen_evraklar group by user_id order by gonderme_zamani desc limit 10");
		while($dosya_oku = mysql_fetch_array($dosya_cek)){ 
			$cek = mysql_query("select * from yuklenen_evrak_dosya where evrak_id = '".$dosya_oku["id"]."' and status = 1");
			// var_dump("select * from yuklenen_evrak_dosya where evrak_id = '".$dosya_oku["id"]."' and status = 1");
			$evrak = "";
			$evrak2 = "";
			$ids = "";
			$c = 0;
			while($oku = mysql_fetch_object($cek)){
				if ($c != mysql_num_rows($cek) - 1) {
					$ids .= $evrak_oku["id"]."_".$oku->id . ",";
				} else {
					$ids .= $evrak_oku["id"]."_".$oku->id;
				}
				$evrak .= '<a href="../assets/' . $oku->icerik . '" target="_blank">' . $oku->icerik . '</a><br/>
				<a hidden id="dosya_' . $evrak_oku["id"]."_".$oku->id . '" href="../assets/' . $oku->icerik . '" download="../assets/' . $oku->icerik . '" >' . $oku->icerik . ' </a>';
				$evrak2 .= '<a hidden id="dosya_' . $evrak_oku["id"]."_".$oku->id . '" href="../assets/' . $oku->icerik . '" download="../assets/' . $oku->icerik . '" >' . $oku->icerik . ' </a><br/>';
				$c++;
			}
			if(mysql_num_rows($cek) != 0){
				$evrak .= '<button type="button" onclick="uye_not_indir(\'' . $ids . '\');" class="button btn-primary" >Tümünü İndir</button>';
			}
			
			$dosya_uye_bul = mysql_query("SELECT * FROM user WHERE id = '".$dosya_oku['user_id']."'");
			$dosya_uye_yaz = mysql_fetch_assoc($dosya_uye_bul);
			if($dosya_uye_yaz["user_token"] == ""){
				$dosya_uye_adi = $dosya_uye_yaz["unvan"];
			}else{
				$dosya_uye_adi = $dosya_uye_yaz['ad'];
			}
		
		?>
        <tr class="success">
            <td><a href="?modul=uyeler&sayfa=uye_duzenle&id=<?= $dosya_oku["user_id"] ?>" onclick="set_trigger_anasayfa('yuklenen_dosyalar_tab')" target="_blank"><?= $dosya_uye_adi ?></a></td>
            <td><?= $evrak ?></td>
			<td><?= date("d-m-Y H:i:s",strtotime($dosya_oku["gonderme_zamani"])) ?></td>
        </tr>
        <?php } ?>
    </tbody>
</table>
<script>
	function set_trigger_anasayfa($item){
		localStorage.setItem("trigger", $item);
	}
</script>

<script>
	async function uye_not_indir(ids) {
		var split = ids.split(",");
		var count = 0;
		for (var i = 0; i < split.length; i++) {
			document.getElementById("dosya_" + split[i]).click();
			if(++count >= 10){
				await pause(1000);
				count = 0;
			}
		}
	}
	function pause(msec) {
		return new Promise(
			(resolve, reject) => {
				setTimeout(resolve, msec || 1000);
			}
		);
	}
</script>

<table class="table table-bordered table-striped" style="margin-top: 25px;">
    <caption><h3 style="color: #000000;">Son Ödemesi Bugün Veya Geçmiş İlanlar</h3></caption>
    <thead>
        <tr style="background-color: #bc9b07;">
            <th>Plaka </th>
            <th>Araç Detay </th>
            <th>Toplam Tutar</th>
            <th>Üye Adı</th>
            <th>Telefonu</th>
        </tr>
    </thead>
    <tbody>
        <?php 
		$son_odeme_sayi = 0;
		while($son_odeme_oku = mysql_fetch_array($son_odeme_cek)){ 
			$ilan_bul = mysql_query("SELECT * FROM ilanlar WHERE id = '".$son_odeme_oku['ilan_id']."'");
			if(mysql_num_rows($ilan_bul) != 0 && $son_odeme_sayi <= 10){

			
			$ilan_oku = mysql_fetch_assoc($ilan_bul);
			$ilan_plaka = $ilan_oku['plaka'];

			$marka_cek = mysql_query("select * from marka where markaID = '".$ilan_oku["marka"]."'");
			$marka_oku = mysql_fetch_object($marka_cek);
			$marka = $marka_oku->marka_adi;

			$kazanan_uye_bul = mysql_query("SELECT * FROM user WHERE id = '".$son_odeme_oku['uye_id']."'");
			$kazanan_uye_oku = mysql_fetch_assoc($kazanan_uye_bul);
			$kazanan_telefon = $kazanan_uye_oku['telefon'];
			if($kazanan_uye_oku["user_token"] == ""){
				$kazanan_ad = $kazanan_uye_oku['unvan'];
			}else{
				$kazanan_ad = $kazanan_uye_oku['ad'];
			}
		
			$tutar = $son_odeme_oku['kazanilan_teklif'];
			$tutar += $son_odeme_oku['dosya_masrafi'];
			$tutar += $son_odeme_oku['pd_hizmet'];
			$tutar += $son_odeme_oku['noter_takipci_gideri'];
			if($ilan_plaka == ""){
				$ilan_plaka = "Plaka Yok";
			}
		?>
        <tr class="warning">
            <td><a href="?modul=ilanlar&sayfa=ilan_ekle&id=<?= $son_odeme_oku["ilan_id"] ?>" target="_blank"><?= $ilan_plaka ?></a></td>
            <td><a href="../arac_detay.php?id=<?=$son_odeme_oku["ilan_id"]?>&q=ihale" target="_blank"><?= $ilan_oku["model_yili"]." ".$marka." ".$ilan_oku["model"]." ".$ilan_oku["tip"] ?></a></td>
            <td><?= money($tutar)." ₺" ?></td>
            <td><a href="?modul=uyeler&sayfa=uye_duzenle&id=<?= $son_odeme_oku["uye_id"] ?>" target="_blank"><?= $kazanan_ad ?></a></td>         
			<td><a href="tel:<?= $kazanan_telefon ?>" style="color: #000000;"><?= $kazanan_telefon ?></a></td>
        </tr>
        <?php $son_odeme_sayi += 1; } } ?>
    </tbody>
</table>
<table class="table table-bordered table-striped" style="margin-top: 25px;">
    <caption><h3 style="color: #9e3737;">Cayma Bedeli İade İsteyen Son 10 Kullanıcı</h3></caption>
    <thead>
        <tr style="background-color: #9e3737; color:white;">
            <th>Ad </th>
            <th>Telefon</th>
            <th>Tutar</th>
            <th>Talep Tarihi</th>
        </tr>
    </thead>
    <tbody>
        <?php 
		$cayma_talep_sayi = 0;
		while($cayma_talep_oku = mysql_fetch_array($cayma_talep_cek)){ 
			$cayma_uye_bul = mysql_query("SELECT * FROM user WHERE id = '".$cayma_talep_oku['uye_id']."'");
			$cayma_uye_oku = mysql_fetch_assoc($cayma_uye_bul);
			if(mysql_num_rows($cayma_uye_bul) != 0 && $cayma_talep_sayi < 10){

			
			if($cayma_uye_oku["user_token"] == ""){
				$cayma_user = $cayma_uye_oku["unvan"];
			}else{
				$cayma_user = $cayma_uye_oku["ad"];
			}
			$cayma_telefon = $cayma_uye_oku['telefon'];
		?>
        <tr class="error">
			<td><a href="?modul=uyeler&sayfa=uye_duzenle&id=<?= $dosya_oku["user_id"] ?>" onclick="set_trigger_anasayfa('cayma_bedeli_tab')" target="_blank"><?= $cayma_user ?></a></td>
			<td><a href="tel:<?= $cayma_telefon ?>" style="color: #000000;"><?= $cayma_telefon ?></a></td>
            <td><?= money($cayma_talep_oku["tutar"]) ?> ₺</td>
			<td><?=  date("d-m-Y H:i:s",strtotime($cayma_talep_oku["iade_talep_tarihi"])) ?></td>
        </tr>
        <?php $cayma_talep_sayi += 1; } } ?>
    </tbody>
</table>


