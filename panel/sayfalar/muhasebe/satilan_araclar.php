<?php

$cek = mysql_query("select * from satilan_araclar");
while($oku = mysql_fetch_object($cek)){
	$ciro = $oku->pd_hizmet + $oku->ektra_kazanc + $oku->satilan_fiyat - $oku->maliyet;
	mysql_query("update satilan_araclar set ciro = '".$ciro."' where id = '".$oku->id."'");
}

session_start();
$admin_id = $_SESSION['kid'];
$admin_yetki_cek = mysql_query("Select * from kullanicilar where id='" . $admin_id . "' ");
$admin_yetki_oku = mysql_fetch_assoc($admin_yetki_cek);
$yetkiler = $admin_yetki_oku["yetki"];
$yetki_parcala = explode("|", $yetkiler);
$secilenleri_sil = "";
if(count($yetki_parcala) == 13){
	$secilenleri_sil = '<input type="button" onclick="secilenleri_sil()" name="secilenleri_sil" style="margin-bottom:10px;height:30px;background-color:orange;" class="input-mini btn" value="Seçilenleri Sil">';
}

$en_cok_cek = mysql_query("SELECT temsilci_id,COUNT(*) as toplam FROM satilan_araclar GROUP BY temsilci_id ORDER BY toplam DESC");
$en_cok_oku = mysql_fetch_object($en_cok_cek);
$en_cok_satis_yapan = $en_cok_oku->temsilci_id;

// $performans_orani_cek = mysql_query("select performans_kazanci_orani from kullanicilar where id='" . $en_cok_satis_yapan . "'");
$performans_orani_cek = mysql_query("select performans_kazanci_orani from kullanicilar where id='1'");
$performans_orani_oku = mysql_fetch_array($performans_orani_cek);
$performans_orani = $performans_orani_oku["performans_kazanci_orani"] / 100;
/*
	if (!in_array(10, $yetki_parcala)){ 
		echo '<script>alert("Bu Sayfaya Giriş Yetkiniz Yoktur")</script>';
		echo "<script>window.location.href = 'index.php'</script>";
	}    
	if (!in_array(10, $yetki_parcala)  ) { 
	}
*/
?>
<style>
	.sari td {
		border: 1px solid #000 !important;
	}
	
	.modal-body {
		max-height: unset;
	}

	.checker span input {
		opacity: 1 !important;
		margin-top: -3px !important;
	}

	.general_search_check {
		position: relative;
		z-index: 99;
	}

	.chec {
		opacity: 1 !important;
		z-index: 999 !important;
	}

	.chec2 {
		opacity: 1 !important;
		z-index: 999 !important;
	}
</style>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="js/uyeler_modal.js?v=<? echo time(); ?>"></script>
<?php
if (re("listeleme") == "") {
	if (re('ay') != "" && re("yil") != "") {
		$where = "WHERE  MONTH(tarih) = '" . re('ay') . "' AND YEAR(tarih)= '" . re("yil") . "' ";
		$odeme_href = "?modul=muhasebe&sayfa=satilan_araclar&listeleme=odeme_tarihi_asc&ay=" . re("ay") . "&yil=" . re("yil") . "";
		$satis_href = "?modul=muhasebe&sayfa=satilan_araclar&listeleme=tarih_desc&ay=" . re("ay") . "&yil=" . re("yil") . "";
		$excel_listeleme = "https://ihale.pertdunyasi.com/excel.php?tarih1=" . re('ay') . "&tarih2=" . re('yil') . "&q=secili_tarihi&listeleme=odeme_tarihi_desc";
	} elseif (re('tarih1') != "" && re("tarih2") != "") {
		$where = "WHERE tarih BETWEEN '" . re('tarih1') . "' AND '" . re('tarih2') . "' ";
		$odeme_href = "?modul=muhasebe&sayfa=satilan_araclar&listeleme=odeme_tarihi_asc&tarih1=" . re("tarih1") . "&tarih2=" . re("tarih2") . "";
		$satis_href = "?modul=muhasebe&sayfa=satilan_araclar&listeleme=tarih_desc&tarih1=" . re("tarih1") . "&tarih2=" . re("tarih2") . "";
		$excel_listeleme = "https://ihale.pertdunyasi.com/excel.php?tarih1=" . re('tarih1') . "&tarih2=" . re('tarih2') . "&q=tarihleri&listeleme=odeme_tarihi_desc";
	} else if (re('aranan') != "") {
		$where = "WHERE concat(plaka,' ',kod,' ',marka_model,' ',sigorta,' ',satis_adi,' ',maliyet,' ',pd_hizmet,' ',ektra_kazanc,' ',notlar,' ',parayi_gonderen,' ',araci_alan,' ',satilan_fiyat,' ',aciklayici_not,' ',ciro)  like '%" . re('aranan') . "%' ";
		$odeme_href = "?modul=muhasebe&sayfa=satilan_araclar&listeleme=odeme_tarihi_asc&aranan=" . re("aranan") . "";
		$satis_href = "?modul=muhasebe&sayfa=satilan_araclar&listeleme=tarih_desc&aranan=" . re("aranan") . "";
		$excel_listeleme = "https://ihale.pertdunyasi.com/excel.php?&aranan=" . re('aranan') . "&q=arama&listeleme=odeme_tarihi_desc";
	} else {
		$where = "";
		$odeme_href = "?modul=muhasebe&sayfa=satilan_araclar&listeleme=odeme_tarihi_asc";
		$satis_href = "?modul=muhasebe&sayfa=satilan_araclar&listeleme=tarih_desc";
		$excel_listeleme = "https://ihale.pertdunyasi.com/excel.php?q=tarihsiz&listeleme=odeme_tarihi_desc";
	}
	$order_by = $where . "order by odeme_tarihi desc";
} else if (re("listeleme") == "odeme_tarihi_desc") {
	if (re('ay') != "" && re("yil") != "") {
		$where = "WHERE  MONTH(tarih) = '" . re('ay') . "' AND YEAR(tarih)= '" . re("yil") . "' ";
		$odeme_href = "?modul=muhasebe&sayfa=satilan_araclar&listeleme=odeme_tarihi_asc&ay=" . re("ay") . "&yil=" . re("yil") . "";
		$satis_href = "?modul=muhasebe&sayfa=satilan_araclar&listeleme=tarih_desc&ay=" . re("ay") . "&yil=" . re("yil") . "";
		$excel_listeleme = "https://ihale.pertdunyasi.com/excel.php?tarih1=" . re('ay') . "&tarih2=" . re('yil') . "&q=secili_tarihi&listeleme=odeme_tarihi_desc";
	} elseif (re('tarih1') != "" && re("tarih2") != "") {
		$where = "WHERE tarih BETWEEN '" . re('tarih1') . "' AND '" . re('tarih2') . "' ";
		$odeme_href = "?modul=muhasebe&sayfa=satilan_araclar&listeleme=odeme_tarihi_asc&tarih1=" . re("tarih1") . "&tarih2=" . re("tarih2") . "";
		$satis_href = "?modul=muhasebe&sayfa=satilan_araclar&listeleme=tarih_desc&tarih1=" . re("tarih1") . "&tarih2=" . re("tarih2") . "";
		$excel_listeleme = "https://ihale.pertdunyasi.com/excel.php?tarih1=" . re('tarih1') . "&tarih2=" . re('tarih2') . "&q=tarihleri&listeleme=odeme_tarihi_desc";
	} else if (re('aranan') != "") {
		$where = "WHERE concat(plaka,' ',kod,' ',marka_model,' ',sigorta,' ',satis_adi,' ',maliyet,' ',pd_hizmet,' ',ektra_kazanc,' ',notlar,' ',parayi_gonderen,' ',araci_alan,' ',satilan_fiyat,' ',aciklayici_not,' ',ciro)  like '%" . re('aranan') . "%' ";
		$odeme_href = "?modul=muhasebe&sayfa=satilan_araclar&listeleme=odeme_tarihi_asc&aranan=" . re("aranan") . "";
		$satis_href = "?modul=muhasebe&sayfa=satilan_araclar&listeleme=tarih_desc&aranan=" . re("aranan") . "";
		$excel_listeleme = "https://ihale.pertdunyasi.com/excel.php?aranan=" . re('aranan') . "&q=arama&listeleme=odeme_tarihi_desc";
	} else {
		$odeme_href = "?modul=muhasebe&sayfa=satilan_araclar&listeleme=odeme_tarihi_asc";
		$satis_href = "?modul=muhasebe&sayfa=satilan_araclar&listeleme=tarih_desc";
		$where = "";
		$excel_listeleme = "https://ihale.pertdunyasi.com/excel.php?q=tarihsiz&listeleme=odeme_tarihi_desc";
	}
	$order_by = $where . "order by odeme_tarihi desc";
} else if (re("listeleme") == "odeme_tarihi_asc") {
	if (re('ay') != "" && re("yil") != "") {
		$where = "WHERE  MONTH(tarih) = '" . re('ay') . "' AND YEAR(tarih)= '" . re("yil") . "' ";
		$odeme_href = "?modul=muhasebe&sayfa=satilan_araclar&listeleme=odeme_tarihi_desc&ay=" . re("ay") . "&yil=" . re("yil") . "";
		$satis_href = "?modul=muhasebe&sayfa=satilan_araclar&listeleme=tarih_desc&ay=" . re("ay") . "&yil=" . re("yil") . "";
		$excel_listeleme = "https://ihale.pertdunyasi.com/excel.php?tarih1=" . re('ay') . "&tarih2=" . re('yil') . "&q=secili_tarihi&listeleme=odeme_tarihi_asc";
	} elseif (re('tarih1') != "" && re("tarih2") != "") {
		$where = "WHERE tarih BETWEEN '" . re('tarih1') . "' AND '" . re('tarih2') . "' ";
		$odeme_href = "?modul=muhasebe&sayfa=satilan_araclar&listeleme=odeme_tarihi_desc&tarih1=" . re("tarih1") . "&tarih2=" . re("tarih2") . "";
		$satis_href = "?modul=muhasebe&sayfa=satilan_araclar&listeleme=tarih_desc&tarih1=" . re("tarih1") . "&tarih2=" . re("tarih2") . "";
		$excel_listeleme = "https://ihale.pertdunyasi.com/excel.php?tarih1=" . re('tarih1') . "&tarih2=" . re('tarih2') . "&q=tarihleri&listeleme=odeme_tarihi_asc";
	} else if (re('aranan') != "") {
		$where = "WHERE concat(plaka,' ',kod,' ',marka_model,' ',sigorta,' ',satis_adi,' ',maliyet,' ',pd_hizmet,' ',ektra_kazanc,' ',notlar,' ',parayi_gonderen,' ',araci_alan,' ',satilan_fiyat,' ',aciklayici_not,' ',ciro)  like '%" . re('aranan') . "%' ";
		$odeme_href = "?modul=muhasebe&sayfa=satilan_araclar&listeleme=odeme_tarihi_desc&aranan=" . re("aranan") . "";
		$satis_href = "?modul=muhasebe&sayfa=satilan_araclar&listeleme=tarih_desc&aranan=" . re('aranan') . "";
		$excel_listeleme = "https://ihale.pertdunyasi.com/excel.php?aranan=" . re('aranan') . "&q=arama&listeleme=odeme_tarihi_asc";
	} else {
		$where = "";
		$odeme_href = "?modul=muhasebe&sayfa=satilan_araclar&listeleme=odeme_tarihi_desc";
		$satis_href = "?modul=muhasebe&sayfa=satilan_araclar&listeleme=tarih_desc";
		$excel_listeleme = "https://ihale.pertdunyasi.com/excel.php?q=tarihsiz&listeleme=odeme_tarihi_asc";
	}
	$order_by = $where . "order by odeme_tarihi asc";
} else if (re("listeleme") == "tarih_desc") {
	if (re('ay') != "" && re("yil") != "") {
		$where = "WHERE  MONTH(tarih) = '" . re('ay') . "' AND YEAR(tarih)= '" . re("yil") . "' ";
		$odeme_href = "?modul=muhasebe&sayfa=satilan_araclar&listeleme=odeme_tarihi_desc&ay=" . re("ay") . "&yil=" . re("yil") . "";
		$satis_href = "?modul=muhasebe&sayfa=satilan_araclar&listeleme=tarih_asc&ay=" . re("ay") . "&yil=" . re("yil") . "";
		$excel_listeleme = "https://ihale.pertdunyasi.com/excel.php?tarih1=" . re('ay') . "&tarih2=" . re('yil') . "&q=secili_tarihi&listeleme=tarih_desc";
	} elseif (re('tarih1') != "" && re("tarih2") != "") {
		$where = "WHERE tarih BETWEEN '" . re('tarih1') . "' AND '" . re('tarih2') . "' ";
		$odeme_href = "?modul=muhasebe&sayfa=satilan_araclar&listeleme=odeme_tarihi_desc&tarih1=" . re("tarih1") . "&tarih2=" . re("tarih2") . "";
		$satis_href = "?modul=muhasebe&sayfa=satilan_araclar&listeleme=tarih_asc&tarih1=" . re("tarih1") . "&tarih2=" . re("tarih2") . "";
		$excel_listeleme = "https://ihale.pertdunyasi.com/excel.php?tarih1=" . re('tarih1') . "&tarih2=" . re('tarih2') . "&q=tarihleri&listeleme=tarih_desc";
	} else if (re('aranan') != "") {
		$where = "WHERE concat(plaka,' ',kod,' ',marka_model,' ',sigorta,' ',satis_adi,' ',maliyet,' ',pd_hizmet,' ',ektra_kazanc,' ',notlar,' ',parayi_gonderen,' ',araci_alan,' ',satilan_fiyat,' ',aciklayici_not,' ',ciro)  like '%" . re('aranan') . "%' ";
		$odeme_href = "?modul=muhasebe&sayfa=satilan_araclar&listeleme=odeme_tarihi_desc&aranan=" . re('aranan') . "";
		$satis_href = "?modul=muhasebe&sayfa=satilan_araclar&listeleme=tarih_asc&aranan=" . re('aranan') . "";
		$excel_listeleme = "https://ihale.pertdunyasi.com/excel.php?aranan=" . re('aranan') . "&q=arama&listeleme=tarih_desc";
	} else {
		$where = "";
		$odeme_href = "?modul=muhasebe&sayfa=satilan_araclar&listeleme=odeme_tarihi_desc";
		$satis_href = "?modul=muhasebe&sayfa=satilan_araclar&listeleme=tarih_asc";
		$excel_listeleme = "https://ihale.pertdunyasi.com/excel.php?q=tarihsiz&listeleme=tarih_desc";
	}
	$order_by = $where . "order by tarih desc";
} else if (re("listeleme") == "tarih_asc") {
	if (re('ay') != "" && re("yil") != "") {
		$where = "WHERE  MONTH(tarih) = '" . re('ay') . "' AND YEAR(tarih)= '" . re("yil") . "' ";
		$odeme_href = "?modul=muhasebe&sayfa=satilan_araclar&listeleme=odeme_tarihi_desc&ay=" . re("ay") . "&yil=" . re("yil") . "";
		$satis_href = "?modul=muhasebe&sayfa=satilan_araclar&listeleme=tarih_desc&ay=" . re("ay") . "&yil=" . re("yil") . "";
		$excel_listeleme = "https://ihale.pertdunyasi.com/excel.php?tarih1=" . re('ay') . "&tarih2=" . re('yil') . "&q=secili_tarihi&listeleme=tarih_asc";
	} elseif (re('tarih1') != "" && re("tarih2") != "") {
		$where = "WHERE tarih BETWEEN '" . re('tarih1') . "' AND '" . re('tarih2') . "' ";
		$odeme_href = "?modul=muhasebe&sayfa=satilan_araclar&listeleme=odeme_tarihi_desc&tarih1=" . re("tarih1") . "&tarih2=" . re("tarih2") . "";
		$satis_href = "?modul=muhasebe&sayfa=satilan_araclar&listeleme=tarih_desc&tarih1=" . re("tarih1") . "&tarih2=" . re("tarih2") . "";
		$excel_listeleme = "https://ihale.pertdunyasi.com/excel.php?tarih1=" . re('tarih1') . "&tarih2=" . re('tarih2') . "&q=tarihleri&listeleme=tarih_asc";
	} else if (re('aranan') != "") {
		$where = "WHERE concat(plaka,' ',kod,' ',marka_model,' ',sigorta,' ',satis_adi,' ',maliyet,' ',pd_hizmet,' ',ektra_kazanc,' ',notlar,' ',parayi_gonderen,' ',araci_alan,' ',satilan_fiyat,' ',aciklayici_not,' ',ciro)  like '%" . re('aranan') . "%' ";
		$odeme_href = "?modul=muhasebe&sayfa=satilan_araclar&listeleme=odeme_tarihi_desc&aranan=" . re("aranan") . "";
		$satis_href = "?modul=muhasebe&sayfa=satilan_araclar&listeleme=tarih_desc&aranan=" . re("aranan") . "";
		$excel_listeleme = "https://ihale.pertdunyasi.com/excel.php?aranan=" . re('aranan') . "&q=arama&listeleme=tarih_asc";
	} else {
		$where = "";
		$odeme_href = "?modul=muhasebe&sayfa=satilan_araclar&listeleme=odeme_tarihi_desc";
		$satis_href = "?modul=muhasebe&sayfa=satilan_araclar&listeleme=tarih_desc";
		$excel_listeleme = "https://ihale.pertdunyasi.com/excel.php?q=tarihsiz&listeleme=tarih_asc";
	}
	$order_by = $where . "order by tarih asc";
} else {
	if (re('ay') != "" && re("yil") != "") {
		$where = "WHERE  MONTH(tarih) = '" . re('ay') . "' AND YEAR(tarih)= '" . re("yil") . "' ";
		$odeme_href = "?modul=muhasebe&sayfa=satilan_araclar&listeleme=odeme_tarihi_desc&ay=" . re("ay") . "&yil=" . re("yil") . "";
		$satis_href = "?modul=muhasebe&sayfa=satilan_araclar&listeleme=tarih_desc&ay=" . re("ay") . "&yil=" . re("yil") . "";
		$excel_listeleme = "https://ihale.pertdunyasi.com/excel.php?tarih1=" . re('ay') . "&tarih2=" . re('yil') . "&q=secili_tarihi&listeleme=odeme_tarihi_desc";
	} elseif (re('tarih1') != "" && re("tarih2") != "") {
		$where = "WHERE tarih BETWEEN '" . re('tarih1') . "' AND '" . re('tarih2') . "' ";
		$odeme_href = "?modul=muhasebe&sayfa=satilan_araclar&listeleme=odeme_tarihi_desc&tarih1=" . re("tarih1") . "&tarih2=" . re("tarih2") . "";
		$satis_href = "?modul=muhasebe&sayfa=satilan_araclar&listeleme=tarih_desc&tarih1=" . re("tarih1") . "&tarih2=" . re("tarih2") . "";
		$excel_listeleme = "https://ihale.pertdunyasi.com/excel.php?tarih1=" . re('tarih1') . "&tarih2=" . re('tarih2') . "&q=tarihleri&listeleme=odeme_tarihi_desc";
	} else if (re('aranan') != "") {
		$where = "WHERE concat(plaka,' ',kod,' ',marka_model,' ',sigorta,' ',satis_adi,' ',maliyet,' ',pd_hizmet,' ',ektra_kazanc,' ',notlar,' ',parayi_gonderen,' ',araci_alan,' ',satilan_fiyat,' ',aciklayici_not,' ',ciro)  like '%" . re('aranan') . "%' ";
		$odeme_href = "?modul=muhasebe&sayfa=satilan_araclar&listeleme=odeme_tarihi_desc&aranan=" . re("aranan") . "";
		$satis_href = "?modul=muhasebe&sayfa=satilan_araclar&listeleme=tarih_desc&aranan=" . re("aranan") . "";
		$excel_listeleme = "https://ihale.pertdunyasi.com/excel.php?aranan=" . re('aranan') . "&q=arama&listeleme=odeme_tarihi_desc";
	} else {
		$where = "";
		$odeme_href = "?modul=muhasebe&sayfa=satilan_araclar&listeleme=odeme_tarihi_desc";
		$satis_href = "?modul=muhasebe&sayfa=satilan_araclar&listeleme=tarih_desc";
		$excel_listeleme = "https://ihale.pertdunyasi.com/excel.php?q=tarihsiz&listeleme=odeme_tarihi_desc";
	}
	$order_by = $where . "order by odeme_tarihi desc";
}


$satilan_cek = mysql_query("SELECT * FROM satilan_araclar WHERE MONTH(odeme_tarihi) = MONTH(CURRENT_DATE()) $order_by ");
$satilan_sayi = mysql_num_rows($satilan_cek);
$sira = 1;
$result = mysql_query('SELECT SUM(ciro) AS ciro,SUM(prim) as prim FROM satilan_araclar where durum=0');
$row = mysql_fetch_assoc($result);
$sum = $row['ciro'];
$sum_prim = $row['prim'];
$sum_performans = $row['ciro'] * $performans_orani;


$month = date('m');
$buay = mysql_query("SELECT IFNULL(SUM(ciro), 0) AS ciro,IFNULL(SUM(prim), 0) as prim FROM satilan_araclar WHERE MONTH(odeme_tarihi) = '" . $month . "' and durum=0 ");
$buay_getir = mysql_fetch_assoc($buay);
$buay_ciro = $buay_getir['ciro'];
$buay_prim = $buay_getir['prim'];

$performans_orani_cek = mysql_query("select performans_kazanci_orani from kullanicilar where id='1'");
$performans_orani_oku = mysql_fetch_array($performans_orani_cek);
$performans_orani = $performans_orani_oku["performans_kazanci_orani"] / 100;
$buay_performans = $buay_ciro * $performans_orani;

$current_month = date('m');
$current_year = date('Y');
$lastmonth = $current_month - 1;

$gecenay = mysql_query('SELECT SUM(ciro) AS ciro FROM satilan_araclar WHERE MONTH(odeme_tarihi) = "' . $lastmonth . '" and durum=0  ');
$gecenay_getir = mysql_fetch_assoc($gecenay);
$gecenay_ciro = $gecenay_getir['ciro'];

$year = date('Y');
$buyil = mysql_query('SELECT SUM(ciro) AS ciro FROM satilan_araclar WHERE YEAR(odeme_tarihi) = "' . $year . '" and durum=0 ');
$buyil_getir = mysql_fetch_assoc($buyil);
$buyil_ciro = $buyil_getir['ciro'];

$lastyear = $year - 1;
$gecenyil = mysql_query('SELECT SUM(ciro) AS ciro FROM satilan_araclar WHERE YEAR(odeme_tarihi) = "' . $lastyear . '" and durum=0 ');
$gecenyil_getir = mysql_fetch_assoc($gecenyil);
$gecenyil_ciro = $gecenyil_getir['ciro'];
?>
<style>
	.dikey {
		writing-mode: tb-rl;
		transform: rotate(-180deg);
	}

	.sari {
		/* background-color: rgb(255,255,0); */
		background-color: #d9d9d9;
	}

	.laci {
		background-color: rgb(51, 51, 153);
		color: #ffffff;
	}

	.acik_mavi {
		/* background-color: rgb(219,229,241); */
		background-color: #d9d9d9;
	}
</style>
<h3>Satılan Araçlar</h3>
<div style="overflow-x:auto; overflow-y:auto;">
	<?php /*
		<table>
			<tr>
				<td></td>
				<td class="acik_mavi">Plaka</td>
				<td class="acik_mavi">Kod</td>
				<td class="acik_mavi">Marka Model</td>
				<td class="acik_mavi">Sigorta</td>
				<td class="acik_mavi">Satış Kimin adına?</td>
				<td class="acik_mavi">Tarih</td>
				<td class="acik_mavi">Aracın Bize Maliyeti</td>
				<td class="acik_mavi">PD Hizmet</td>
				<td class="acik_mavi">Extra Kazanç</td>
				<td class="acik_mavi">Notlar</td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			<form method="POST">
				<tr>
					<td></td>
					<!-- <td><input name="plaka" style="text-transform: uppercase;" onkeypress="return boslukEngelle()" id="plaka" type="text" value="" class="input-mini"/></td> -->
					<td>
					   <!-- <input name="plaka" onkeypress="return boslukEngelle()" id="plaka" type="text" value="" class="input-mini"/> -->
					   <input type="text" style="text-transform: uppercase;" required class="input-mini" name="plaka" id="plaka" placeholder="01AA0000" onkeypress="return boslukEngelle()" pattern="[0-9]{2}[A-Za-z]{1,3}[0-9]{2,4}" oninvalid="this.setCustomValidity('LÜTFEN PLAKAYI DÜZGÜN GİRİN')" oninput="this.setCustomValidity('')" maxlength="8"  /> 
					</td>
					<td><input name="kod" id="kod" type="text" required class="input-mini"/></td>
					<td><input id="marka_model" name="marka_model" required value="" type="text" class="input-mini"/></td>
					<td><input name="sigorta" id="sigorta" value="" required type="text" class="input-mini"/></td>
					<td><input name="satis_kimin_adina" value="" required id="satis_kimin_adina" type="text" class="input-mini"></td>
					<td><input name="satis_tarihi" id="satis_tarihi" value="" required type="date" class="input-mini"/></td>
					<td><input name="maliyet" id="maliyet" type="text" value="" required class="input-mini"/></td>
					<td><input name="pd_hizmet" id="pd_hizmet" type="text" value=""   class="input-mini"></td>
					<td><input name="ektra_kazanc" id="ektra_kazanc" value="" required type="text" class="input-mini"/></td>
					<td><input name="notlar" id="notlar" type="text" value="" required class="input-mini"/></td>
					<td><input type="submit" name="satisi" class="btn" style="background-color: rgb(227,108,9); color:#ffffff;" value="Ekle"></td>
				</tr>
			</form>
		</table>
	*/ ?>
	<script>
		function boslukEngelle() {
			if (event.keyCode == 32) {
				return false;
			}
		}
		$("#plaka").keypress(function(event) {
			var character = String.fromCharCode(event.keyCode);
			return isValid(character);
		});

		function isValid(str) {
			return !/[~`!@#$%\^&*()+=\-\[\]\\';.,/{}|\\":<>\?]/g.test(str);
		}
	</script>
	<form method="POST">
		<div class="row-fluid">
			<div class="span5">
				<h3>İstatistikler</h3>
				<table class="table table-bordered">
					<tr>
						<td class="acik_mavi">BU AY</td>
						<td class="acik_mavi">GEÇEN AY</td>
						<td class="acik_mavi">BU YIL</td>
						<td class="acik_mavi">GEÇEN YIL</td>
					</tr>
					<tr>
						<?php if (in_array(10, $yetki_parcala)) { ?>
							<td style="background-color: #f2f2f2;"><?= money($buay_ciro) ?> ₺</td>
							<td style="background-color: #f2f2f2;"><?= money($gecenay_ciro) ?> ₺</td>
							<td style="background-color: #f2f2f2;"><?= money($buyil_ciro) ?> ₺</td>
							<td style="background-color: #f2f2f2;"><?= money($gecenyil_ciro) ?> ₺</td>
						<?php } else { ?>
							<td style="background-color: #f2f2f2;">? ₺</td>
							<td style="background-color: #f2f2f2;">? ₺</td>
							<td style="background-color: #f2f2f2;">? ₺</td>
							<td style="background-color: #f2f2f2;">? ₺</td>
						<?php } ?>
					</tr>
				</table>
			</div>
			<div style="margin-top:60px;" class="span5">
				<input type="text" value="<?= re("aranan") ?>" style="width:50%;background-color: #f2f2f2;" name="aranan" value="" placeholder="aramak istediğinzi kelimeyi yazın">
				<input type="submit" name="aranan_kelime" style="height:30px;margin-bottom:10px;background:#ffc000" class="input-mini btn" value="Ara">
			</div>
			<div style="margin-top:60px;" class="span2">
				<input type="button" name="yeni_veri_ekle" style="height:30px;margin-bottom:10px;background:orange;font-weight:bold;" class="input-mini btn view_yeni_satilan_ekle" value="YENİ VERİ EKLE">
			</div>
		</div>
		<div class="row-fluid">
			<div class="span1">
			</div>
			<div class="span6">
				<div class="row-fluid">
					<div class="span9">
						<div class="row-fluid">
							<div class="span4">
								<center style="font-size:12px;margin-top:5px;">ŞU TARİHLER ARASI</center>
							</div>
							<div class="span4">
								<input type="date" style="width:100%;background-color: #f2f2f2;" value="<?= re("tarih1") ?>" name="tarih1" id="tarih1" class="input-mini">
							</div>
							<div class="span4">
								<input type="date" style="width:100%;background-color: #f2f2f2;" value="<?= re("tarih2") ?>" name="tarih2" id="tarih2" class="input-mini" />
							</div>
						</div>
						<div class="row-fluid">
							<div class="span4">
								<center style="font-size:12px;margin-top:5px;">Müşteri Temsilcisine Göre</center>
							</div>
							<div class="span8">
								<select id="admin" name="admin" onchange="div_show('admin','tarih_div')" class="span12" style="background-color: #f2f2f2;">
									<option style="background-color: #f2f2f2;" value="">Seçiniz</option>
									<?php
									$admin_cek = mysql_query("select * from kullanicilar where durum <> 0");
									$seciliAdminSayisi = count($_POST['admin']);
									if ($seciliAdminSayisi != 0) {
										$admin_check = array();

										while ($admin_oku = mysql_fetch_array($admin_cek)) {
											$admin_check = "";
											if ($admin_oku["id"] == $_POST["admin"]) {
												$admin_check = "selected";
											}
									?>
											<option style="background-color: #f2f2f2;" <?= $admin_check ?> id="admin_<?= $admin_oku['id'] ?>" value="<?= $admin_oku['id'] ?>" /><?= $admin_oku['adi'] . " " . $admin_oku['soyadi'] ?></option>
										<?php  }
										?>
										<?php } else {
										while ($admin_oku = mysql_fetch_array($admin_cek)) { ?>
											<option style="background-color: #f2f2f2;" id="admin_<?= $admin_oku['id'] ?>" value="<?= $admin_oku['id'] ?>" /><?= $admin_oku['adi'] . " " . $admin_oku['soyadi'] ?></option>
									<?php }
									}
									?>
								</select>
							</div>
						</div>
						<?php if (in_array(10, $yetki_parcala)) { ?>
							<?php if ($_POST['admin'] != "") { ?>
								<div style="display:block" id="tarih_div" class="row-fluid">
								<?php } else { ?>
									<div style="display:none" id="tarih_div" class="row-fluid">
									<?php } ?>

									<div class="span4">
										<?php
										if ($_POST['secilen_tarih_radio'] == 1) { ?>
											<input type="hidden" name="secilen_tarih_radio" id="secilen_tarih_radio" value="1">
										<?php } else if ($_POST['secilen_tarih_radio'] == 2) { ?>
											<input type="hidden" name="secilen_tarih_radio" id="secilen_tarih_radio" value="2">
										<?php } else { ?>
											<input type="hidden" name="secilen_tarih_radio" id="secilen_tarih_radio" value="1">
										<?php } ?>
									</div>
									<div class="span4">
										<?php
										if ($_POST['secilen_tarih_radio'] == 1) { ?>
											<input type="button" onclick="secilen_tarih_guncelle(1,1);" id="secilen_tarih_tumu" style="margin-bottom:10px;height:30px;width:100%;background:orange" class="input-mini btn " value="TÜMÜ">
										<?php } else if ($_POST['secilen_tarih_radio'] == 2) { ?>
											<input type="button" onclick="secilen_tarih_guncelle(1,1);" id="secilen_tarih_tumu" style="margin-bottom:10px;height:30px;width:100%;" class="input-mini btn " value="TÜMÜ">
										<?php } else { ?>
											<input type="button" onclick="secilen_tarih_guncelle(1,1);" id="secilen_tarih_tumu" style="margin-bottom:10px;height:30px;width:100%;background:orange" class="input-mini btn " value="TÜMÜ">
										<?php } ?>
									</div>
									<div class="span4">
										<?php
										if ($_POST['secilen_tarih_radio'] == 2) { ?>
											<input type="button" onclick="secilen_tarih_guncelle(1,2);" id="secilen_tarih_prim" style="margin-bottom:10px;height:30px;width:100%;background:orange;" class="input-mini btn " value="SADECE PRİM">
										<?php } else if ($_POST['secilen_tarih_radio'] == 1) { ?>
											<input type="button" onclick="secilen_tarih_guncelle(1,2);" id="secilen_tarih_prim" style="margin-bottom:10px;height:30px;width:100%;" class="input-mini btn " value="SADECE PRİM">
										<?php } else { ?>
											<input type="button" onclick="secilen_tarih_guncelle(1,2);" id="secilen_tarih_prim" style="margin-bottom:10px;height:30px;width:100%;" class="input-mini btn " value="SADECE PRİM">
										<?php } ?>
									</div>
									</div>
								<?php } ?>
								</div>
								<div class="span3">
									<input type="submit" name="tarihleri" style="margin-bottom:10px;height:70px;" class="input-mini btn blue" value="Filtrele">
								</div>
					</div>
				</div>
				<div class="span5">
					<div class="row-fluid">
						<div class="span9">
							<div class="row-fluid">
								<div class="span4">
									<center style="font-size:12px;margin-top:5px;">AY/YIL SEÇ</center>
								</div>
								<div class="span4">
									<select style="width:100%;background-color: #f2f2f2;" name="ay" id="ay" class="input-mini">
										<option style="background-color: #f2f2f2;" <?php if (re("ay") == "") {
																						echo "selected";
																					} ?> value="">Seçiniz</option>
										<option style="background-color: #f2f2f2;" <?php if (re("ay") == "01") {
																						echo "selected";
																					} ?> value="01">Ocak</option>
										<option style="background-color: #f2f2f2;" <?php if (re("ay") == "02") {
																						echo "selected";
																					} ?> value="02">Şubat</option>
										<option style="background-color: #f2f2f2;" <?php if (re("ay") == "03") {
																						echo "selected";
																					} ?> value="03">Mart</option>
										<option style="background-color: #f2f2f2;" <?php if (re("ay") == "04") {
																						echo "selected";
																					} ?> value="04">Nisan</option>
										<option style="background-color: #f2f2f2;" <?php if (re("ay") == "05") {
																						echo "selected";
																					} ?> value="05">Mayıs</option>
										<option style="background-color: #f2f2f2;" <?php if (re("ay") == "06") {
																						echo "selected";
																					} ?> value="06">Haziran</option>
										<option style="background-color: #f2f2f2;" <?php if (re("ay") == "07") {
																						echo "selected";
																					} ?> value="07">Temmuz</option>
										<option style="background-color: #f2f2f2;" <?php if (re("ay") == "08") {
																						echo "selected";
																					} ?> value="08">Ağustos</option>
										<option style="background-color: #f2f2f2;" <?php if (re("ay") == "09") {
																						echo "selected";
																					} ?> value="09">Eylül</option>
										<option style="background-color: #f2f2f2;" <?php if (re("ay") == "10") {
																						echo "selected";
																					} ?> value="10">Ekim</option>
										<option style="background-color: #f2f2f2;" <?php if (re("ay") == "11") {
																						echo "selected";
																					} ?> value="11">Kasım</option>
										<option style="background-color: #f2f2f2;" <?php if (re("ay") == "12") {
																						echo "selected";
																					} ?> value="12">Aralık</option>
									</select>
								</div>
								<div class="span4">
									<select style="width:100%;background-color: #f2f2f2;" name="yil" id="yil" class="input-mini">
										<option style="background-color: #f2f2f2;" <?php if (re("ay") == "") {
																						echo "selected";
																					} ?> value="">Seçiniz</option>
										<?php for ($i = $year; $i >= 2010; $i--) { ?>
											<option style="background-color: #f2f2f2;" <?php if (re("yil") == $i) {
																							echo "selected";
																						} ?> value="<?= $i ?>"><?= $i ?></option>
										<?php } ?>
									</select>
								</div>
							</div>
							<div class="row-fluid">
								<?php
								if (in_array(10, $yetki_parcala)) { ?>
									<div class="span4">
										<center style="font-size:12px;margin-top:5px;">Müşteri Temsilcisine Göre</center>
									</div>
									<div class="span8">
										<select style="height:1.8em; background-color: #f2f2f2;" name="admin2" onchange="div_show('admin2','tarih2_div')" class="span12">
											<option style="background-color: #f2f2f2;" value="">Seçiniz</option>
											<?php
											$admin_cek2 = mysql_query("select * from kullanicilar where durum <> 0");
											$seciliAdminSayisi2 = count($_POST['admin2']);
											if ($seciliAdminSayisi2 != 0) {
												$admin_check2 = array();

												while ($admin_oku2 = mysql_fetch_array($admin_cek2)) {
													$admin_check2 = "";

													if ($admin_oku2["id"] == $_POST["admin2"]) {
														$admin_check2 = "selected";
													}
											?>
													<option style="background-color: #f2f2f2;" <?= $admin_check2 ?> id="admin_<?= $admin_oku2['id'] ?>" value="<?= $admin_oku2['id'] ?>" /><?= $admin_oku2['adi'] . " " . $admin_oku2['soyadi'] ?></option>
												<?php  }
												?>
												<?php } else {
												while ($admin_oku2 = mysql_fetch_array($admin_cek2)) { ?>
													<option style="background-color: #f2f2f2;" id="admin_<?= $admin_oku2['id'] ?>" value="<?= $admin_oku2['id'] ?>" /><?= $admin_oku2['adi'] . " " . $admin_oku2['soyadi'] ?></option>
											<?php }
											}
											?>
										</select>
									</div>
								<?php } ?>
							</div>
							<?php if (in_array(10, $yetki_parcala)) { ?>
								<?php
								if ($_POST['admin2'] != "") { ?>
									<div style="display:block" id="tarih2_div" class="row-fluid">
									<?php } else { ?>
										<div style="display:none" id="tarih2_div" class="row-fluid">
										<?php } ?>
										<div class="span4">
											<?php
											if ($_POST['secilen_tarih_radio2'] == 1) { ?>
												<input type="hidden" name="secilen_tarih_radio2" id="secilen_tarih_radio2" value="1">
											<?php } else if ($_POST['secilen_tarih_radio2'] == 2) { ?>
												<input type="hidden" name="secilen_tarih_radio2" id="secilen_tarih_radio2" value="2">
											<?php } else { ?>
												<input type="hidden" name="secilen_tarih_radio2" id="secilen_tarih_radio2" value="1">
											<?php } ?>
										</div>
										<div class="span4">
											<?php
											if ($_POST['secilen_tarih_radio2'] == 1) { ?>
												<input type="button" onclick="secilen_tarih_guncelle(2,1);" id="secilen_tarih_tumu2" style="margin-bottom:10px;height:30px;width:100%;background:orange" class="input-mini btn " value="TÜMÜ">
											<?php } else if ($_POST['secilen_tarih_radio2'] == 2) { ?>
												<input type="button" onclick="secilen_tarih_guncelle(2,1);" id="secilen_tarih_tumu2" style="margin-bottom:10px;height:30px;width:100%;" class="input-mini btn " value="TÜMÜ">
											<?php } else { ?>
												<input type="button" onclick="secilen_tarih_guncelle(2,1);" id="secilen_tarih_tumu2" style="margin-bottom:10px;height:30px;width:100%;background:orange" class="input-mini btn " value="TÜMÜ">
											<?php } ?>
										</div>
										<div class="span4">
											<?php
											if ($_POST['secilen_tarih_radio2'] == 2) { ?>
												<input type="button" onclick="secilen_tarih_guncelle(2,2);" id="secilen_tarih_prim2" style="margin-bottom:10px;height:30px;width:100%;background:orange;" class="input-mini btn " value="SADECE PRİM">
											<?php } else if ($_POST['secilen_tarih_radio2'] == 1) { ?>
												<input type="button" onclick="secilen_tarih_guncelle(2,2);" id="secilen_tarih_prim2" style="margin-bottom:10px;height:30px;width:100%;" class="input-mini btn " value="SADECE PRİM">
											<?php } else { ?>
												<input type="button" onclick="secilen_tarih_guncelle(2,2);" id="secilen_tarih_prim2" style="margin-bottom:10px;height:30px;width:100%;" class="input-mini btn " value="SADECE PRİM">
											<?php } ?>
										</div>
										</div>
									<?php } ?>
									</div>
									<div class="span3">
										<input type="submit" style="margin-bottom:10px;height:70px;" name="secili_tarihi" class="input-mini btn blue" value="Filtrele">
									</div>
						</div>
					</div>
				</div>
	</form>
	<table class="table table-bordered">
		<tr>
			<td colspan="17"></td>
		</tr>
		<tr class="sari" style="overflow:hidden;overflow-y: scroll;">
			<td>SEÇ<input type="checkbox" id="checkle" class="checkall btn btn-blue chec2" style="padding:20px;opacity:1!important; z-index:999;"></td>
			<td>
				<p class="dikey">SIRA</p>
			</td>
			<td><a href="<?= $odeme_href ?>">ÖDEME TARİHİ</a></td>
			<td>ÖDEYEN</td>
			<td>KOD</td>
			<td>PLAKA</td>
			<td>MARKA MODEL</td>
			<td>SİGORTA</td>
			<td>ÜYE ADI</td>
			<td>SATIŞ KİMİN ADINA YAPILDI</td>
			<td><a href="<?= $satis_href ?>"> SATIŞ TARİHİ </a></td>
			<td>MALİYETİ</td>
			<td>SATILAN FİYAT</td>
			<td>PD HİZMET BEDELİ</td>
			<td>EXTRA KAZANÇ</td>
			<td>AÇIKLAYICI NOTLAR</td>
			<td>TOPLAM KAR / ZARAR</td>
			<!--<td>MENÜ</td>-->
		</tr>
		<?php
		if (re("ay") != "" || re("yil") != "") {
			$_POST["tarih1"] = "";
			$_POST["tarih2"] = "";

			if (re("listeleme") == "") {
				$order_by = "order by odeme_tarihi desc";
			} else if (re("listeleme") == "odeme_tarihi_desc") {
				$order_by = "order by odeme_tarihi desc";
			} else if (re("listeleme") == "odeme_tarihi_asc") {
				$order_by = "order by odeme_tarihi asc";
			} else if (re("listeleme") == "tarih_desc") {
				$order_by = "order by tarih desc";
			} else if (re("listeleme") == "tarih_asc") {
				$order_by = "order by tarih asc";
			} else {
				$order_by = "order by odeme_tarihi desc";
			}
			$gelen_ay = re('ay');
			$gelen_yil = re('yil');

			if ($_POST['admin2'] != "") {
				if ($_POST['secilen_tarih_radio2'] == 2) {
					/*
					$filtre_sql = "SELECT satilan_araclar.* ,  user.temsilci_id FROM satilan_araclar INNER JOIN user ON satilan_araclar.uye_id=user.id INNER JOIN prm_notlari ON satilan_araclar.uye_id=prm_notlari.uye_id 
					WHERE satilan_araclar.temsilci_id='" . $_POST['admin2'] . "' AND prm_notlari.durum=1 ";
					if ($gelen_ay != "") {
						$filtre_sql .= "AND MONTH(satilan_araclar.odeme_tarihi) = '$gelen_ay' ";
					}
					if ($gelen_yil != "") {
						$filtre_sql .= "AND YEAR(satilan_araclar.odeme_tarihi) = '$gelen_yil' ";
					}
					$filtre = mysql_query($filtre_sql);

					$ay_yil_sql = "SELECT SUM(ciro) AS ciro ,SUM(prim) as prim ,user.temsilci_id FROM satilan_araclar INNER JOIN user ON satilan_araclar.uye_id=user.id INNER JOIN prm_notlari ON satilan_araclar.uye_id=prm_notlari.uye_id 
					WHERE prm_notlari.durum=1 AND satilan_araclar.temsilci_id='" . $_POST['admin2'] . "' ";
					if ($gelen_ay != "") {
						$ay_yil_sql .= "AND MONTH(satilan_araclar.odeme_tarihi) = '$gelen_ay' ";
					}
					if ($gelen_yil != "") {
						$ay_yil_sql .= "AND YEAR(satilan_araclar.odeme_tarihi) = '$gelen_yil' ";
					}
					$ayYil = mysql_query($ay_yil_sql);
					*/

					$filtre_sql = "select * from satilan_araclar inner join user on satilan_araclar.uye_id=user.id where satilan_araclar.temsilci_id='" . $_POST['admin2'] . "' and satilan_araclar.prim > 0 ";
					if ($gelen_ay != "") {
						$filtre_sql .= "AND MONTH(satilan_araclar.odeme_tarihi) = '$gelen_ay' ";
					}
					if ($gelen_yil != "") {
						$filtre_sql .= "AND YEAR(satilan_araclar.odeme_tarihi) = '$gelen_yil' ";
					}
					$filtre_sql .= $order_by;
					// echo $filtre_sql;
					$filtre = mysql_query($filtre_sql);
					$ay_yil_sql = "select sum(ciro) as ciro, sum(prim) as prim, user.temsilci_id from satilan_araclar inner join user on satilan_araclar.uye_id=user.id 
					where satilan_araclar.durum=0 AND satilan_araclar.temsilci_id='" . $_POST['admin2'] . "' and satilan_araclar.prim > 0 ";
					// var_dump("select sum(ciro) as ciro, sum(prim) as prim, user.temsilci_id from satilan_araclar inner join user on satilan_araclar.uye_id=user.id 
					// where atilan_araclar.durum=0 AND satilan_araclar.temsilci_id='" . $_POST['admin2'] . "' and satilan_araclar.prim > 0 ");
					if ($gelen_ay != "") {
						$ay_yil_sql .= "AND MONTH(satilan_araclar.odeme_tarihi) = '$gelen_ay' ";
					}
					if ($gelen_yil != "") {
						$ay_yil_sql .= "AND YEAR(satilan_araclar.odeme_tarihi) = '$gelen_yil' ";
					}
					$ayYil = mysql_query($ay_yil_sql);
				} else {
					/*
					$filtre_sql = "SELECT satilan_araclar.* ,  user.temsilci_id FROM satilan_araclar INNER JOIN user ON satilan_araclar.uye_id=user.id WHERE satilan_araclar.temsilci_id='" . $_POST['admin'] . "'  ";
					if ($gelen_ay != "") {
						$filtre_sql .= "AND MONTH(satilan_araclar.odeme_tarihi) = '$gelen_ay' ";
					}
					if ($gelen_yil != "") {
						$filtre_sql .= "AND YEAR(satilan_araclar.odeme_tarihi) = '$gelen_yil' ";
					}
					$filtre = mysql_query($filtre_sql);
					$ayYil_sql = mysql_query("SELECT SUM(ciro) AS ciro ,SUM(prim) as prim ,user.temsilci_id FROM satilan_araclar INNER JOIN user ON satilan_araclar.uye_id=user.id WHERE  satilan_araclar.durum=0 AND 
					satilan_araclar.temsilci_id='" . $_POST['admin'] . "' ");
					if ($gelen_ay != "") {
						$ayYil_sql .= "AND MONTH(satilan_araclar.odeme_tarihi) = '$gelen_ay' ";
					}
					if ($gelen_yil != "") {
						$ayYil_sql .= "AND YEAR(satilan_araclar.odeme_tarihi) = '$gelen_yil' ";
					}
					$ayYil = mysql_query($ayYil_sql);
					*/
					$filtre_sql = "select * from satilan_araclar inner join user on satilan_araclar.uye_id=user.id where satilan_araclar.temsilci_id='" . $_POST['admin2'] . "' ";
					if ($gelen_ay != "") {
						$filtre_sql .= "AND MONTH(satilan_araclar.odeme_tarihi) = '$gelen_ay' ";
					}
					if ($gelen_yil != "") {
						$filtre_sql .= "AND YEAR(satilan_araclar.odeme_tarihi) = '$gelen_yil' ";
					}
					$filtre_sql .= $order_by;
					// echo $filtre_sql;
					$filtre = mysql_query($filtre_sql);
					$ay_yil_sql = "select sum(ciro) as ciro, sum(prim) as prim, user.temsilci_id from satilan_araclar inner join user on satilan_araclar.uye_id=user.id 
					where satilan_araclar.durum=0 AND satilan_araclar.temsilci_id='" . $_POST['admin2'] . "' 	 ";
					if ($gelen_ay != "") {
						$ay_yil_sql .= "AND MONTH(satilan_araclar.odeme_tarihi) = '$gelen_ay' ";
					}
					if ($gelen_yil != "") {
						$ay_yil_sql .= "AND YEAR(satilan_araclar.odeme_tarihi) = '$gelen_yil' ";
					}
					$ayYil = mysql_query($ay_yil_sql);
				}
			} else {
				$filtre_sql = "SELECT * FROM satilan_araclar WHERE id <> 0 ";
				if ($gelen_ay != "") {
					$filtre_sql .= "AND MONTH(odeme_tarihi) = '$gelen_ay' ";
				}
				if ($gelen_ay != "") {
					$filtre_sql .= "AND YEAR(odeme_tarihi) = '$gelen_yil' ";
				}
				$filtre = mysql_query($filtre_sql);
				$ayYil_sql = "SELECT SUM(ciro) AS ciro, SUM(prim) as prim FROM satilan_araclar WHERE durum = 0 ";
				if ($gelen_ay != "") {
					$ayYil_sql .= "AND MONTH(odeme_tarihi) = '$gelen_ay' ";
				}
				if ($gelen_ay != "") {
					$ayYil_sql .= "AND YEAR(odeme_tarihi) = '$gelen_yil' ";
				}
				$ayYil = mysql_query($ayYil_sql);
			}

			$en_cok_cek = mysql_query("SELECT temsilci_id,COUNT(*) as toplam FROM satilan_araclar WHERE MONTH(odeme_tarihi) = '" . $gelen_ay . "' AND YEAR(odeme_tarihi) = '" . $gelen_yil . "' GROUP BY temsilci_id ORDER BY toplam DESC");
			$en_cok_oku = mysql_fetch_object($en_cok_cek);
			$en_cok_satis_yapan = $en_cok_oku->temsilci_id;

			// $performans_orani_cek = mysql_query("select performans_kazanci_orani from kullanicilar where id='" . $en_cok_satis_yapan . "'");
			$performans_orani_cek = mysql_query("select performans_kazanci_orani from kullanicilar where id='1'");
			$performans_orani_oku = mysql_fetch_array($performans_orani_cek);
			$performans_orani = $performans_orani_oku["performans_kazanci_orani"] / 100;

			$filterCount = mysql_num_rows($filtre);

			$AyYilToplam = mysql_fetch_assoc($ayYil);
			$AyYilCiro = $AyYilToplam['ciro'];
			$toplam_prim = $AyYilToplam['prim'];
			$toplam_performans_ikramiyesi = $AyYilToplam['ciro'] * $performans_orani;
		?>
			<div class="row-fluid">
				<?php if (in_array(10, $yetki_parcala)) { ?>
					<div class="span3">
						<h4>Toplam <?= $filterCount ?> adet sonuç içinde Toplam Ciro <?= money($AyYilCiro) ?> ₺</h4>
					</div>
					<div class="span2">
						<?= $secilenleri_sil ?>
					</div>
					<div class="span2">
						<h4>Toplam Prim <?= money($toplam_prim) ?> ₺</h4>
					</div>
					<div class="span3">
						<h4> Performans İkramiyesi <?= money($toplam_performans_ikramiyesi) ?> ₺</h4>
					</div>
				<?php } else { ?>
					<div class="row-fluid">
						<div class="span3">
							<h4>Toplam <?= $filterCount ?> adet sonuç içinde Toplam Ciro ? ₺</h4>
						</div>
						<div class="span2">
							<?= $secilenleri_sil ?>
						</div>
						<div class="span2">
							<h4>Toplam Prim ? ₺</h4>
						</div>
						<div class="span3">
							<h4> Performans İkramiyesi ? ₺</h4>
						</div>

					<?php } ?>
					<div class="span2">
						<a style="background:#fcd5b4;" class="input-mini btn " href="<?= $excel_listeleme ?>">Excel</a>
					</div>
					</div>
			</div>
			<tr style="display: none;">
				<td colspan="17">
					<?php if (in_array(10, $yetki_parcala)) { ?>
						<h4>Toplam <?= $filterCount ?> adet sonuç içinde Toplam Ciro <?= money($AyYilCiro) ?> ₺</h4>
						<?= $secilenleri_sil ?>
						<h4>Toplam Prim <?= money($toplam_prim) ?> ₺</h4>
						<h4> Performans İkramiyesi <?= money($toplam_performans_ikramiyesi) ?> ₺</h4>
					<?php } else { ?>
						<h4>Toplam <?= $filterCount ?> adet sonuç içinde Toplam Ciro ? ₺</h4>
						<?= $secilenleri_sil ?>
						<h4>Toplam Prim ? ₺</h4>
						<h4> Performans İkramiyesi ? ₺</h4>
					<?php } ?>
					<a style="background:#fcd5b4;" class="input-mini btn " href="<?= $excel_listeleme ?>">Excel</a>
				</td>
			</tr>
			<?php while ($filtre_yaz = mysql_fetch_array($filtre)) {
				if ($_POST['admin2'] != "") {
					$id_cek = mysql_query("select * from satilan_araclar where plaka = '".$filtre_yaz["plaka"]."' and kod = '".$filtre_yaz["kod"]."' and ilan_id = '".$filtre_yaz["ilan_id"]."'");
					$id_oku = mysql_fetch_object($id_cek);
					$satilan_id = $id_oku->id;
				}else{
					$satilan_id = $filtre_yaz["id"];
				}
				$satilanID = $filtre['id'];
				$ciro = $filtre_yaz['ciro'];
				if ($filtre_yaz["durum"] == 1) {
					$style = "background:red;color:white;";
					$arka_plan = "backgroud:red;";
					$renk = "color:white !important;";
				} else {
					$style = "";
					$arka_plan = "";
					$renk = "";
				}
				if($filtre_yaz['tarih'] == "0000-00-00"){
					$tarih = "";
				}else{
					$tarih = date("d-m-Y", strtotime($filtre_yaz['tarih']));
				}
			?>
				<tr style="<?= $style ?>" id="satilan_tr_<?= $filtre_yaz['id'] ?>">
					<td><input type="checkbox" name="secim[]" class="chec" id="asd<?= $filtre_yaz['id'] ?>" value="<?= $filtre_yaz['id'] ?>" style="opacity:1!important; z-index:999;"></td>
					<td style="<?= $style ?>" class="laci"><a style="color:#fff" href="#myModal<?= $filtre_yaz['id'] ?>" data-toggle="modal"><?= $sira++ ?></a></td>
					<?php
					if ($filtre_yaz['odeme_tarihi'] != "0000-00-00") { ?>
						<td><?= date("d-m-Y", strtotime($filtre_yaz['odeme_tarihi'])) ?></td>
					<?php } else { ?>
						<td> </td>
					<?php }
					?>
					<td><?= $filtre_yaz['parayi_gonderen'] ?></td>
					<td><a style="<?= $renk ?>" id="<?= $filtre_yaz['ilan_id'] ?>" class="view_ilan_notlari"><?= $filtre_yaz['kod'] ?></a></td>
					<td><a style="<?= $renk ?>" href="?modul=ilanlar&sayfa=ilan_ekle&id=<?= $filtre_yaz['ilan_id'] ?>" target="_blank"><?= $filtre_yaz['plaka'] ?></a></td>
					<td><a style="<?= $renk ?>" href="../arac_detay.php?id=<?= $filtre_yaz['ilan_id'] ?>&q=ihale" target="_blank"><?= $filtre_yaz['marka_model'] ?></a></td>
					<td><?= $filtre_yaz['sigorta'] ?></td>
					<td><a id="<?= $filtre_yaz['uye_id'] ?>" class="view_notlari"><?= $filtre_yaz['araci_alan'] ?></a></td>
					<td><?= $filtre_yaz['satis_adi'] ?></td>
					<td><?= $tarih ?></td>

					<?php if (in_array(10, $yetki_parcala)) { ?>
						<td><?= money($filtre_yaz['maliyet']) ?> ₺</td>
					<?php } else { ?>
						<td>? ₺</td>
					<?php } ?>
					<td><?= $filtre_yaz['satilan_fiyat'] ?></td>
					<td><?= $filtre_yaz['pd_hizmet'] ?></td>
					<?php if (in_array(10, $yetki_parcala)) { ?>
						<td><?= money($filtre_yaz['ektra_kazanc']) ?> ₺</td>
					<?php } else { ?>
						<td>? ₺</td>
					<?php } ?>
					<td><?= $filtre_yaz['aciklayici_not'] ?></td>
					<?php if (in_array(10, $yetki_parcala)) { ?>
						<td><a href="#" id="<?= $satilan_id ?>" style="color: <?php if ($filtre_yaz['durum'] == 1) { echo "white"; } else { if ($ciro > 0) {echo "green";} else { echo "red";}} ?>" class="view_satilan_duzenle"><?= money($ciro) ?> ₺</a></td>
					<?php } else { ?>
						<td>? ₺</td>
					<?php } ?>
					<!--<td><a style="<?= $renk ?>" href="?modul=muhasebe&sayfa=satilan_duzenle&id=<?= $satilanID ?>" target="_blank">Düzenle</a><br>
				<a style="<?= $renk ?>" href="?modul=ayarlar&sayfa=data_sil&id=<?= $satilanID ?>&q=satilan_sil"  onclick="return confirm('Silmek istediğinize emin misiniz ?')">Sil</a><br>
				<?php
				if ($filtre_yaz['durum'] == 0) { ?>
							<a href="#myModal<?= $filtre_yaz['id'] ?>" data-toggle="modal">İade Et</a>
					<?php } else { ?>
							<span style="<?= $renk ?>" >İade Edildi</span>
					<?php }
					?>
			</td>-->
					<!-- Modal -->
					<div id="myModal<?= $filtre_yaz['id'] ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
						<form method="POST">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
								<h3 id="myModalLabel">İade Etme</h3>
							</div>
							<div class="modal-body">
								<div class="row-fluid">
									<textarea id="iade_aciklama" rows="3" name="iade_aciklama" class="span12"></textarea>
								</div>
							</div>
							<div class="modal-footer">
								<button class="btn" data-dismiss="modal" aria-hidden="true">Kapat</button>
								<button type="button" class="btn blue" onclick="guncelle(<?= $filtre_yaz['id'] ?>)" name="iadeyi">Kaydet</button>
							</div>
						</form>
					</div>
				</tr>

			<?php }  ?>

		<?php } elseif (re("tarih1") != "" || re("tarih2") != "") {
			$_POST["ay"] = "";
			$_POST["yil"] = "";
			if (re("listeleme") == "") {
				$order_by = "order by odeme_tarihi desc";
			} else if (re("listeleme") == "odeme_tarihi_desc") {
				$order_by = "order by odeme_tarihi desc";
			} else if (re("listeleme") == "odeme_tarihi_asc") {
				$order_by = "order by odeme_tarihi asc";
			} else if (re("listeleme") == "tarih_desc") {
				$order_by = "order by tarih desc";
			} else if (re("listeleme") == "tarih_asc") {
				$order_by = "order by tarih asc";
			} else {
				$order_by = "order by odeme_tarihi desc";
			}
			if ($_POST['admin'] != "") {
				if ($_POST['secilen_tarih_radio'] == 2) {
					/*
					$filtre_sql = "select satilan_araclas.*, user.temsilci_id from satilan_araclas inner join user on satilan_araclar.uye_id = user.id 
						inner join prm_notlari on satilan_araclar.uye_id = prm_notlari.uye_id where prm_notlari.durum = 1 
						and satilan_araclar.temsilci_id='" . $_POST['admin'] . "' ";
					if (re("tarih1") != "") {
						$filtre_sql .= "and odeme_tarihi >= '" . re("tarih1") . "' ";
					}
					if (re("tarih2") != "") {
						$filtre_sql .= "and odeme_tarihi <= '" . re("tarih2") . "' ";
					}
					$filtre_sql .= $order_by;
					$filtre_cek = mysql_query($filtre_sql);
					$tarih_filtre_sql = "select sum(ciro) as ciro, sum(prim) as prim, user.temsilci_id from satilan_araclar inner join user 
						on satilan_araclar.uye_id = user.id inner join prm_notlari on satilan_araclar.uye_id = prm_notlari.uye_id where prm_notlari.durum = 1 
						and satilan_araclar.temsilci_id='" . $_POST['admin'] . "' ";
					if (re("tarih1") != "") {
						$tarih_filtre_sql .= "and odeme_tarihi >= '" . re("tarih1") . "' ";
					}
					if (re("tarih2") != "") {
						$tarih_filtre_sql .= "and odeme_tarihi <= '" . re("tarih2") . "' ";
					}
					$tarihFiltre = mysql_query($tarih_filtre_sql);
					*/
					$filtre_sql = "select * from satilan_araclar inner join user on satilan_araclar.uye_id=user.id where satilan_araclar.temsilci_id='" . $_POST['admin'] . "' and satilan_araclar.prim > 0 ";
					if (re("tarih1") != "") {
						$filtre_sql .= "and odeme_tarihi >= '" . re("tarih1") . "' ";
					}
					if (re("tarih2") != "") {
						$filtre_sql .= "and odeme_tarihi <= '" . re("tarih2") . "' ";
					}
					$filtre_sql .= $order_by;
					$filtre_cek = mysql_query($filtre_sql);
					$tarih_filtre_sql = "select sum(ciro) as ciro, sum(prim) as prim, user.temsilci_id from satilan_araclar inner join user on satilan_araclar.uye_id=user.id 
						where atilan_araclar.durum=0 AND satilan_araclar.temsilci_id='" . $_POST['admin'] . "' and satilan_araclar.prim > 0 ";
					if (re("tarih1") != "") {
						$tarih_filtre_sql .= "and odeme_tarihi >= '" . re("tarih1") . "' ";
					}
					if (re("tarih2") != "") {
						$tarih_filtre_sql .= "and odeme_tarihi <= '" . re("tarih2") . "' ";
					}
					$tarihFiltre = mysql_query($tarih_filtre_sql);


				} else {
					/*
						$filtre_cek = mysql_query("SELECT * FROM satilan_araclar INNER JOIN user ON satilan_araclar.uye_id=user.id WHERE 
						odeme_tarihi BETWEEN '".re('tarih1')."' AND '".re('tarih2')."' AND satilan_araclar.temsilci_id='".$_POST['admin']."' $order_by ");
						*/
					$filtre_sql = "select * from satilan_araclar inner join user on satilan_araclar.uye_id=user.id where satilan_araclar.temsilci_id='" . $_POST['admin'] . "' ";
					if (re("tarih1") != "") {
						$filtre_sql .= "and odeme_tarihi >= '" . re("tarih1") . "' ";
					}
					if (re("tarih2") != "") {
						$filtre_sql .= "and odeme_tarihi <= '" . re("tarih2") . "' ";
					}
					$filtre_sql .= $order_by;
					$filtre_cek = mysql_query($filtre_sql);

					/*
						$tarihFiltre = mysql_query('SELECT SUM(ciro) AS ciro,SUM(prim) as prim ,user.temsilci_id FROM satilan_araclar INNER JOIN user ON 
						satilan_araclar.uye_id=user.id WHERE odeme_tarihi BETWEEN "'.re('tarih1').'" AND "'.re('tarih2').'" AND satilan_araclar.durum=0 AND
						satilan_araclar.temsilci_id="'.$_POST['admin'].'"');	
						*/
					$tarih_filtre_sql = "select sum(ciro) as ciro, sum(prim) as prim, user.temsilci_id from satilan_araclar inner join user on satilan_araclar.uye_id=user.id 
						where atilan_araclar.durum=0 AND satilan_araclar.temsilci_id='" . $_POST['admin'] . "' ";
					if (re("tarih1") != "") {
						$tarih_filtre_sql .= "and odeme_tarihi >= '" . re("tarih1") . "' ";
					}
					if (re("tarih2") != "") {
						$tarih_filtre_sql .= "and odeme_tarihi <= '" . re("tarih2") . "' ";
					}
					$tarihFiltre = mysql_query($tarih_filtre_sql);
				}
			} else {
				//$filtre_cek = mysql_query("SELECT * FROM satilan_araclar WHERE odeme_tarihi BETWEEN '".re('tarih1')."' AND '".re('tarih2')."' $order_by ");
				$filtre_sql = "select * from satilan_araclar where id <> 0 ";
				if (re("tarih1") != "") {
					$filtre_sql .= "and odeme_tarihi >= '" . re("tarih1") . "' ";
				}
				if (re("tarih2") != "") {
					$filtre_sql .= "and odeme_tarihi <= '" . re("tarih2") . "' ";
				}
				$filtre_sql .= $order_by;
				$filtre_cek = mysql_query($filtre_sql);
				$filtre_cek2 = mysql_query($filtre_sql);
				
				/*
					$tarihFiltre = mysql_query('SELECT SUM(ciro) AS ciro,SUM(prim) as prim FROM satilan_araclar WHERE odeme_tarihi BETWEEN 
					"'.re('tarih1').'" AND "'.re('tarih2').'" AND durum=0');
					*/
				$tarih_filtre_sql = "select sum(ciro) as ciro, sum(prim) as prim from satilan_araclar where id <> 0 and durum = 0 ";
				if (re("tarih1") != "") {
					$tarih_filtre_sql .= "and odeme_tarihi >= '" . re("tarih1") . "' ";
				}
				if (re("tarih2") != "") {
					$tarih_filtre_sql .= "and odeme_tarihi <= '" . re("tarih2") . "' ";
				}
				$tarihFiltre = mysql_query($tarih_filtre_sql);
			}
			// echo $filtre_sql;
			$en_cok_cek = mysql_query("SELECT temsilci_id,COUNT(*) as toplam FROM satilan_araclar WHERE odeme_tarihi BETWEEN '" . re('tarih1') . "' AND '" . re('tarih2') . "' GROUP BY temsilci_id ORDER BY toplam DESC");
			$en_cok_oku = mysql_fetch_object($en_cok_cek);
			$en_cok_satis_yapan = $en_cok_oku->temsilci_id;

			// $performans_orani_cek = mysql_query("select performans_kazanci_orani from kullanicilar where id='" . $en_cok_satis_yapan . "'");
			$performans_orani_cek = mysql_query("select performans_kazanci_orani from kullanicilar where id='1'");
			$performans_orani_oku = mysql_fetch_array($performans_orani_cek);
			$performans_orani = $performans_orani_oku["performans_kazanci_orani"] / 100;

			$filtre_sayi = mysql_num_rows($filtre_cek);
			$filtreToplam = mysql_fetch_assoc($tarihFiltre);
			$ToplamFiltre = money($filtreToplam['ciro']);
			$toplam_prim = money($filtreToplam['prim']);
		
			$ToplamFiltre = 0;
			while($filtre_oku2 = mysql_fetch_object($filtre_cek2)){
				if($filtre_oku2->ciro > 0 && $filtre_oku2->durum == 0){
					$ToplamFiltre += $filtre_oku2->ciro;	
				}
			}
			$toplam_performans_ikramiyesi = money($ToplamFiltre * $performans_orani);
		?>
			<div class="row-fluid">
				<div class="span3">
					<h4>Toplam <?= $filtre_sayi ?> adet sonuç içinde Toplam Ciro <?= money($ToplamFiltre) ?> ₺</h4>
				</div>
				<div class="span2">
				<?= $secilenleri_sil ?>
				</div>
				<div class="span2">
					<h4>Toplam Prim <?= money($toplam_prim) ?> ₺</h4>
				</div>
				<div class="span3">
					<h4> Performans İkramiyesi <?= money($toplam_performans_ikramiyesi) ?> ₺</h4>
				</div>
				<div class="span2">
					<a style="background:#fcd5b4;" class="input-mini btn " href="<?= $excel_listeleme ?>">Excel</a>
				</div>
			</div>
			<tr style="display: none;">
				<td colspan="17">
					<h4>Toplam <?= $filtre_sayi ?> adet sonuç içinde Toplam Ciro <?= $ToplamFiltre ?>₺</h4>
					<?= $secilenleri_sil ?>
					<h4> Toplam Prim <?= $toplam_prim ?> ₺ </h4>
					<h4> Performans İkramiyesi <?= $toplam_performans_ikramiyesi ?> ₺ </h4>
					<a style="background:#fcd5b4;" class="input-mini btn " href="<?= $excel_listeleme ?>">Excel</a>
				</td>
			</tr>
			<?php

			while ($filtre_oku = mysql_fetch_array($filtre_cek)) {
				$id_cek = mysql_query("select * from satilan_araclar where plaka = '".$filtre_oku["plaka"]."' and kod = '".$filtre_oku["kod"]."' and ilan_id = '".$filtre_oku["ilan_id"]."'");
				$id_oku = mysql_fetch_object($id_cek);
				$satilan_id = $id_oku->id;
				$satilanID = $filtre_oku['id'];
				$ciro = $filtre_oku['ciro'];
				if ($filtre_oku["durum"] == 1) {
					$style = "background:red;color:white;";
					$arka_plan = "backgroud:red;";
					$renk = "color:white !important;";
				} else {
					$style = "";
					$arka_plan = "";
					$renk = "";
				}

				if($filtre_oku['tarih'] == "0000-00-00"){
					$tarih = "";
				}else{
					$tarih = date("d-m-Y", strtotime($filtre_oku['tarih']));
				}
			?>

				<tr style="<?= $style ?>" id="satilan_tr_<?= $filtre_oku["id"] ?>">
					<td><input type="checkbox" name="secim[]" class="chec" id="asd<?= $filtre_oku['id'] ?>" value="<?= $filtre_oku['id'] ?>" style="opacity:1!important; z-index:999;"></td>
					<td style="<?= $style ?>" class="laci"><a style="color:#fff" href="#myModal<?= $filtre_oku['id'] ?>" data-toggle="modal"><?= $sira++ ?></a></td>

					<?php
					if ($filtre_oku['odeme_tarihi'] != "0000-00-00") { ?>
						<td><?= date("d-m-Y", strtotime($filtre_oku['odeme_tarihi'])) ?></td>
					<?php } else { ?>
						<td> </td>
					<?php }
					?>
					<td><?= $filtre_oku['parayi_gonderen'] ?></td>
					<td><a style="<?= $renk ?>" id="<?= $filtre_oku['ilan_id'] ?>" class="view_ilan_notlari"><?= $filtre_oku['kod'] ?></a></td>
					<td><a style="<?= $renk ?>" href="?modul=ilanlar&sayfa=ilan_ekle&id=<?= $filtre_oku['ilan_id'] ?>" target="_blank"><?= $filtre_oku['plaka'] ?></a></td>
					<td><a style="<?= $renk ?>" href="../arac_detay.php?id=<?= $filtre_oku['ilan_id'] ?>&q=ihale" target="_blank"><?= $filtre_oku['marka_model'] ?></a></td>
					<td><?= $filtre_oku['sigorta'] ?></td>
					<td><a id="<?= $filtre_oku['uye_id'] ?>" class="view_notlari"> <?= $filtre_oku['araci_alan'] ?></a></td>
					<td><?= $filtre_oku['satis_adi'] ?></td>
					<td><?= $tarih ?></td>

					<?php if (in_array(10, $yetki_parcala)) { ?>
						<td><?= money($filtre_oku['maliyet']) ?> ₺</td>
					<?php } else { ?>
						<td>? ₺</td>
					<?php } ?>
					<td><?= money($filtre_oku['satilan_fiyat']) ?> ₺</td>
					<td><?= money($filtre_oku['pd_hizmet']) ?> ₺</td>
					<?php if (in_array(10, $yetki_parcala)) { ?>
						<td><?= money($filtre_oku['ektra_kazanc']) ?> ₺</td>
					<?php } else { ?>
						<td>? ₺</td>
					<?php } ?>

					<td><?= $filtre_oku['aciklayici_not'] ?></td>
					<?php if (in_array(10, $yetki_parcala)) { ?>
						<td><a id="<?= $satilan_id ?>" href="#" class="view_satilan_duzenle"  style="color: <?php if ($filtre_oku['durum'] == 1) { echo "white"; } else { if ($ciro > 0) { echo "green"; } else { echo "red"; } } ?>"><?= money($ciro) ?> ₺</a></td>
					<?php } else { ?>
						<td>? ₺</td>
					<?php } ?>

					<!--<td><a style="<?= $renk ?>"  href="?modul=muhasebe&sayfa=satilan_duzenle&id=<?= $satilanID ?>" target="_blank">Düzenle</a><br>
				<a style="<?= $renk ?>"  href="?modul=ayarlar&sayfa=data_sil&id=<?= $satilanID ?>&q=satilan_sil"  onclick="return confirm('Silmek istediğinize emin misiniz ?')">Sil</a><br>
				<?php
				if ($filtre_oku['durum'] == 0) { ?>
							<a href="#myModal<?= $filtre_oku['id'] ?>" data-toggle="modal">İade Et</a>
					<?php } else { ?>
							<span style="<?= $renk ?>"  >İade Edildi</span>
					<?php }
					?>
			</td>-->
					<!-- Modal -->
					<div id="myModal<?= $filtre_oku['id'] ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
						<form method="POST">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
								<h3 id="myModalLabel">İade Etme</h3>
							</div>
							<div class="modal-body">
								<div class="row-fluid">
									<textarea id="iade_aciklama" rows="3" name="iade_aciklama" class="span12"></textarea>
								</div>
							</div>
							<div class="modal-footer">
								<button class="btn" data-dismiss="modal" aria-hidden="true">Kapat</button>
								<button type="button" class="btn blue" onclick="guncelle(<?= $filtre_oku['id'] ?>)" name="iadeyi">Kaydet</button>
							</div>
						</form>
					</div>
				</tr>
			<?php }  ?>

		<?php } else if (re("aranan") != "") {
			$_POST["tarih1"] = "";
			$_POST["tarih2"] = "";
			$_POST["ay"] = "";
			$_POST["yil"] = "";
			if (re("listeleme") == "") {
				$order_by = "order by odeme_tarihi desc";
			} else if (re("listeleme") == "odeme_tarihi_desc") {
				$order_by = "order by odeme_tarihi desc";
			} else if (re("listeleme") == "odeme_tarihi_asc") {
				$order_by = "order by odeme_tarihi asc";
			} else if (re("listeleme") == "tarih_desc") {
				$order_by = "order by tarih desc";
			} else if (re("listeleme") == "tarih_asc") {
				$order_by = "order by tarih asc";
			} else {
				$order_by = "order by odeme_tarihi desc";
			}
			$aranan = re('aranan');
			if ($_POST['admin2'] != "") {
				if ($_POST['secilen_tarih_radio2'] == 2) {
					$filtre = mysql_query("
						SELECT
							satilan_araclar.* ,  user.temsilci_id
						FROM 
							satilan_araclar
						INNER JOIN 
							user
						ON
							satilan_araclar.uye_id=user.id
						INNER JOIN 
							prm_notlari
						ON
							satilan_araclar.uye_id=prm_notlari.uye_id 
						WHERE  
							satilan_araclar.temsilci_id='" . $_POST['admin'] . "' AND
							prm_notlari.durum=1 AND
							concat(plaka,' ',kod,' ',marka_model,' ',sigorta,' ',satis_adi,' ',maliyet,' ',pd_hizmet,' ',ektra_kazanc,' ',notlar,' ',parayi_gonderen,' ',araci_alan,' ',satilan_fiyat,' ',aciklayici_not,' ',ciro)  like '%" . $aranan . "%'
						$order_by 
					");
					$ayYil = mysql_query("
						SELECT 
							SUM(ciro) AS ciro ,
							SUM(prim) as prim ,
							user.temsilci_id
						FROM 
							satilan_araclar 
						INNER JOIN 
							user
						ON
							satilan_araclar.uye_id=user.id
						INNER JOIN 
							prm_notlari
						ON
							satilan_araclar.uye_id=prm_notlari.uye_id 
						WHERE  
							satilan_araclar.durum=0 AND
							satilan_araclar.temsilci_id='" . $_POST['admin'] . "' AND
							prm_notlari.durum=1 AND
							concat(plaka,' ',kod,' ',marka_model,' ',sigorta,' ',satis_adi,' ',maliyet,' ',pd_hizmet,' ',ektra_kazanc,' ',notlar,' ',parayi_gonderen,' ',araci_alan,' ',satilan_fiyat,' ',aciklayici_not,' ',ciro)  like '%" . $aranan . "%'
					");
				} else {
					$filtre = mysql_query("
						SELECT
							satilan_araclar.* ,  user.temsilci_id
						FROM 
							satilan_araclar
						INNER JOIN 
							user
						ON
							satilan_araclar.uye_id=user.id
						WHERE  
							satilan_araclar.temsilci_id='" . $_POST['admin'] . "' AND
							concat(plaka,' ',kod,' ',marka_model,' ',sigorta,' ',satis_adi,' ',maliyet,' ',pd_hizmet,' ',ektra_kazanc,' ',notlar,' ',parayi_gonderen,' ',araci_alan,' ',satilan_fiyat,' ',aciklayici_not,' ',ciro)  like '%" . $aranan . "%'
						$order_by 
					");
					$ayYil = mysql_query("
						SELECT 
							SUM(ciro) AS ciro ,
							SUM(prim) as prim ,
							user.temsilci_id
						FROM 
							satilan_araclar 
						INNER JOIN 
							user
						ON
							satilan_araclar.uye_id=user.id
						WHERE  
							satilan_araclar.durum=0 AND
							satilan_araclar.temsilci_id='" . $_POST['admin'] . "' AND
							concat(plaka,' ',kod,' ',marka_model,' ',sigorta,' ',satis_adi,' ',maliyet,' ',pd_hizmet,' ',ektra_kazanc,' ',notlar,' ',parayi_gonderen,' ',araci_alan,' ',satilan_fiyat,' ',aciklayici_not,' ',ciro)  like '%" . $aranan . "%'
					");
				}
			} else {
				$filtre = mysql_query("
					SELECT
						* 
					FROM 
						satilan_araclar 
					WHERE  
						concat(plaka,' ',kod,' ',marka_model,' ',sigorta,' ',satis_adi,' ',maliyet,' ',pd_hizmet,' ',ektra_kazanc,' ',notlar,' ',parayi_gonderen,' ',araci_alan,' ',satilan_fiyat,' ',aciklayici_not,' ',ciro)  like '%" . $aranan . "%'
					$order_by 
				");
				$ayYil = mysql_query("
					SELECT 
						SUM(ciro) AS ciro,
						SUM(prim) as prim 
					FROM 
						satilan_araclar 
					WHERE  
						durum=0 AND 
						concat(plaka,' ',kod,' ',marka_model,' ',sigorta,' ',satis_adi,' ',maliyet,' ',pd_hizmet,' ',ektra_kazanc,' ',notlar,' ',parayi_gonderen,' ',araci_alan,' ',satilan_fiyat,' ',aciklayici_not,' ',ciro)  like '%" . $aranan . "%'
				");
			}

			$en_cok_cek = mysql_query("SELECT temsilci_id,COUNT(*) as toplam FROM satilan_araclar WHERE concat(plaka,' ',kod,' ',marka_model,' ',sigorta,' ',satis_adi,' ',maliyet,' ',pd_hizmet,' ',ektra_kazanc,' ',notlar,' ',parayi_gonderen,' ',araci_alan,' ',satilan_fiyat,' ',aciklayici_not,' ',ciro)  like '%" . $aranan . "%' GROUP BY temsilci_id ORDER BY toplam DESC");
			$en_cok_oku = mysql_fetch_object($en_cok_cek);
			$en_cok_satis_yapan = $en_cok_oku->temsilci_id;

			// $performans_orani_cek = mysql_query("select performans_kazanci_orani from kullanicilar where id='" . $en_cok_satis_yapan . "'");
			$performans_orani_cek = mysql_query("select performans_kazanci_orani from kullanicilar where id='1'");
			$performans_orani_oku = mysql_fetch_array($performans_orani_cek);
			$performans_orani = $performans_orani_oku["performans_kazanci_orani"] / 100;


			$filterCount = mysql_num_rows($filtre);

			$AyYilToplam = mysql_fetch_assoc($ayYil);
			$AyYilCiro = $AyYilToplam['ciro'];
			$toplam_prim = $AyYilToplam['prim'];
			// $toplam_performans_ikramiyesi = $AyYilToplam['ciro'] * $performans_orani;
			$toplam_performans_ikramiyesi = $AyYilCiro * $performans_orani;




		?>
			<div class="row-fluid">
				<?php if (in_array(10, $yetki_parcala)) { ?>
					<div class="span3">
						<h4>Toplam <?= $filterCount ?> adet sonuç içinde Toplam Ciro <?= money($AyYilCiro) ?> ₺</h4>
					</div>
					<div class="span2">
					<?= $secilenleri_sil ?>
					</div>
					<div class="span2">
						<h4>Toplam Prim <?= money($toplam_prim) ?> ₺</h4>
					</div>
					<div class="span3">
						<h4> Performans İkramiyesi <?= money($toplam_performans_ikramiyesi) ?> ₺</h4>
					</div>
				<?php } else { ?>
					<div class="row-fluid">
						<div class="span3">
							<h4>Toplam <?= $filterCount ?> adet sonuç içinde Toplam Ciro ? ₺</h4>
						</div>
						<div class="span2">
						<?= $secilenleri_sil ?>
						</div>
						<div class="span2">
							<h4>Toplam Prim ? ₺</h4>
						</div>
						<div class="span3">
							<h4> Performans İkramiyesi ? ₺</h4>
						</div>

					<?php } ?>
					<div class="span2">
						<a style="background:#fcd5b4;" class="input-mini btn " href="<?= $excel_listeleme ?>">Excel</a>
					</div>
					</div>
			</div>
			<tr style="display: none;">
				<td colspan="17">
					<?php if (in_array(10, $yetki_parcala)) { ?>
						<h4>Toplam <?= $filterCount ?> adet sonuç içinde Toplam Ciro <?= money($AyYilCiro) ?> ₺</h4>
						<?= $secilenleri_sil ?>
						<h4>Toplam Prim <?= money($toplam_prim) ?> ₺</h4>
						<h4> Performans İkramiyesi <?= money($toplam_performans_ikramiyesi) ?> ₺</h4>
					<?php } else { ?>
						<h4>Toplam <?= $filterCount ?> adet sonuç içinde Toplam Ciro ? ₺</h4>
						<?= $secilenleri_sil ?>
						<h4>Toplam Prim ? ₺</h4>
						<h4> Performans İkramiyesi ? ₺</h4>
					<?php } ?>
					<a style="background:#fcd5b4;" class="input-mini btn " href="<?= $excel_listeleme ?>">Excel</a>
				</td>
			</tr>
			<?php while ($filtre_yaz = mysql_fetch_array($filtre)) {
				$satilanID = $filtre['id'];
				$ciro = $filtre_yaz['ciro'];
				if ($filtre_yaz["durum"] == 1) {
					$style = "background:red;color:white;";
					$arka_plan = "backgroud:red;";
					$renk = "color:white !important;";
				} else {
					$style = "";
					$arka_plan = "";
					$renk = "";
				}

				if($filtre_yaz['tarih'] == "0000-00-00"){
					$tarih = "";
				}else{
					$tarih = date("d-m-Y", strtotime($filtre_yaz['tarih']));
				}
			?>
				<tr style="<?= $style ?>" id="satilan_tr_<?= $filtre_yaz["id"] ?>">
					<td><input type="checkbox" name="secim[]" class="chec" id="asd<?= $filtre_yaz['id'] ?>" value="<?= $filtre_yaz['id'] ?>" style="opacity:1!important; z-index:999;"></td>
					<td style="<?= $style ?>" class="laci"><a style="color:#fff" href="#myModal<?= $filtre_yaz['id'] ?>" data-toggle="modal"><?= $sira++ ?></a></td>

					<?php
					if ($filtre_yaz['odeme_tarihi'] != "0000-00-00") { ?>
						<td><?= date("d-m-Y", strtotime($filtre_yaz['odeme_tarihi'])) ?></td>
					<?php } else { ?>
						<td> </td>
					<?php }
					?>
					<td><?= $filtre_yaz['parayi_gonderen'] ?></td>
					<td><a style="<?= $renk ?>" id="<?= $filtre_yaz['ilan_id'] ?>" class="view_ilan_notlari"><?= $filtre_yaz['kod'] ?></a></td>
					<td><a style="<?= $renk ?>" href="?modul=ilanlar&sayfa=ilan_ekle&id=<?= $filtre_yaz['ilan_id'] ?>" target="_blank"><?= $filtre_yaz['plaka'] ?></a></td>
					<td><a style="<?= $renk ?>" href="../arac_detay.php?id=<?= $filtre_yaz['ilan_id'] ?>&q=ihale" target="_blank"><?= $filtre_yaz['marka_model'] ?></a></td>
					<td><?= $filtre_yaz['sigorta'] ?></td>
					<td><a id="<?= $filtre_yaz['uye_id'] ?>" class="view_notlari"><?= $filtre_yaz['araci_alan'] ?></a></td>
					<td><?= $filtre_yaz['satis_adi'] ?></td>
					<td><?= $tarih ?></td>

					<?php if (in_array(10, $yetki_parcala)) { ?>
						<td><?= money($filtre_yaz['maliyet']) ?> ₺</td>
					<?php } else { ?>
						<td>? ₺</td>
					<?php } ?>
					<td><?= $filtre_yaz['satilan_fiyat'] ?></td>
					<td><?= $filtre_yaz['pd_hizmet'] ?></td>
					<?php if (in_array(10, $yetki_parcala)) { ?>
						<td><?= money($filtre_yaz['ektra_kazanc']) ?> ₺</td>
					<?php } else { ?>
						<td>? ₺</td>
					<?php } ?>
					<td><?= $filtre_yaz['aciklayici_not'] ?></td>
					<?php if (in_array(10, $yetki_parcala)) { ?>
						<td><a href="#" id="<?= $filtre_yaz['id'] ?>" style="color: <?php if ($filtre_yaz['durum'] == 1) {
																						echo "white";
																					} else {
																						if ($ciro > 0) {
																							echo "green";
																						} else {
																							echo "red";
																						}
																					} ?>" class="view_satilan_duzenle"><?= money($ciro) ?> ₺ </a></td>
					<?php } else { ?>
						<td>? ₺</td>
					<?php } ?>
					<!--<td><a style="<?= $renk ?>" href="?modul=muhasebe&sayfa=satilan_duzenle&id=<?= $satilanID ?>" target="_blank">Düzenle</a><br>
					<a style="<?= $renk ?>" href="?modul=ayarlar&sayfa=data_sil&id=<?= $satilanID ?>&q=satilan_sil"  onclick="return confirm('Silmek istediğinize emin misiniz ?')">Sil</a><br>
					<?php
					if ($filtre_yaz['durum'] == 0) { ?>
								<a href="#myModal<?= $filtre_yaz['id'] ?>" data-toggle="modal">İade Et</a>
						<?php } else { ?>
								<span style="<?= $renk ?>" >İade Edildi</span>
						<?php }
						?>
				</td>-->
					<!-- Modal -->
					<div id="myModal<?= $filtre_yaz['id'] ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
						<form method="POST">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
								<h3 id="myModalLabel">İade Etme</h3>
							</div>
							<div class="modal-body">
								<div class="row-fluid">
									<textarea id="iade_aciklama" rows="3" name="iade_aciklama" class="span12"></textarea>
								</div>
							</div>
							<div class="modal-footer">
								<button class="btn" data-dismiss="modal" aria-hidden="true">Kapat</button>
								<button type="button" class="btn blue" onclick="guncelle(<?= $filtre_yaz['id'] ?>)" name="iadeyi">Kaydet</button>
							</div>
						</form>
					</div>
				</tr>
			<?php }
		} else { ?>
			<div class="row-fluid">
				<?php if (in_array(10, $yetki_parcala)) {
					?>
					<div class="span3">
						<h4>Toplam <?= $filterCount ?> adet sonuç içinde Toplam Ciro <?= money($buay_ciro) ?> ₺</h4>
					</div>
					<div class="span2">
					<?= $secilenleri_sil ?>
					</div>
					<div class="span2">
						<h4>Toplam Prim <?= money($buay_prim) ?> ₺</h4>
					</div>
					<div class="span3">
						<h4> Performans İkramiyesi <?= money($buay_performans) ?> ₺</h4>
					</div>
				<?php } else { ?>
					<div class="row-fluid">
						<div class="span3">
							<h4>Toplam <?= $filterCount ?> adet sonuç içinde Toplam Ciro ? ₺</h4>
						</div>
						<div class="span2">
						<?= $secilenleri_sil ?>
						</div>
						<div class="span2">
							<h4>Toplam Prim ? ₺</h4>
						</div>
						<div class="span3">
							<h4> Performans İkramiyesi ? ₺</h4>
						</div>

					<?php } ?>
					<div class="span2">
						<a style="background:#fcd5b4;" class="input-mini btn " href="<?= $excel_listeleme ?>">Excel</a>
					</div>
					</div>
			</div>



			<td></td>
			<?php
			while ($satilan_oku = mysql_fetch_array($satilan_cek)) {
				$satilanID = $satilan_oku['id'];
				$ciro = $satilan_oku['ciro'];
				if ($satilan_oku["durum"] == 1) {
					$style = "background:red;color:white;";
					$arka_plan = "backgroud:red;";
					$renk = "color:white !important;";
				} else {
					$style = "";
					$arka_plan = "";
					$renk = "";
				}

				if($satilan_oku['tarih'] == "0000-00-00"){
					$tarih = "";
				}else{
					$tarih = date("d-m-Y", strtotime($satilan_oku['tarih']));
				}
			?>
				<tr style="<?= $style ?>" id="satilan_tr_<?= $satilan_oku["id"] ?>">
					<td><input type="checkbox" name="secim[]" class="chec" id="asd<?= $satilan_oku['id'] ?>" value="<?= $satilan_oku['id'] ?>" style="opacity:1!important; z-index:999;"></td>
					<td style="<?= $style ?>" class="laci"><a style="color:#fff" style="color:#fff" href="#myModal<?= $satilan_oku['id'] ?>" data-toggle="modal"><?= $sira++ ?></a></td>
					<?php
					if ($satilan_oku['odeme_tarihi'] != "0000-00-00") { ?>
						<td><?= date("d-m-Y", strtotime($satilan_oku['odeme_tarihi'])) ?></td>
					<?php } else { ?>
						<td> </td>
					<?php }
					?>
					<td><?= $satilan_oku['parayi_gonderen'] ?></td>
					<td><a style="<?= $renk ?>" id="<?= $satilan_oku['ilan_id'] ?>" class="view_ilan_notlari"><?= $satilan_oku['kod'] ?></a></td>
					<td><a style="<?= $renk ?>" href="?modul=ilanlar&sayfa=ilan_ekle&id=<?= $satilan_oku['ilan_id'] ?>" target="_blank"><?= $satilan_oku['plaka'] ?></a></td>
					<td><a style="<?= $renk ?>" href="../arac_detay.php?id=<?= $satilan_oku['ilan_id'] ?>&q=ihale" target="_blank"><?= $satilan_oku['marka_model'] ?></a></td>
					<td><?= $satilan_oku['sigorta'] ?></td>
					<td><a id="<?= $satilan_oku['uye_id'] ?>" class="view_notlari"><?= $satilan_oku['araci_alan'] ?></a></td>
					<td><?= $satilan_oku['satis_adi'] ?></td>
					<td><?= $tarih ?></td>
					<?php if (in_array(10, $yetki_parcala)) { ?>
						<td><?= money($satilan_oku['maliyet']) ?> ₺</td>
					<?php } else { ?>
						<td>? ₺</td>
					<?php } ?>
					<td><?= money($satilan_oku['satilan_fiyat']) ?> ₺</td>
					<td><?= money($satilan_oku['pd_hizmet']) ?> ₺ </td>
					<?php if (in_array(10, $yetki_parcala)) { ?>
						<td><?= money($satilan_oku['ektra_kazanc']) ?> ₺</td>
					<?php } else { ?>
						<td>? ₺</td>
					<?php } ?>
					<td><?= $satilan_oku['aciklayici_not'] ?></td>
					<?php if (in_array(10, $yetki_parcala)) { ?>
						<td><a href="#" id="<?= $satilan_oku['id'] ?>" style="color: <?php if ($satilan_oku['durum'] == 1) {
																							echo "white";
																						} else {
																							if ($ciro > 0) {
																								echo "green";
																							} else {
																								echo "red";
																							}
																						} ?>" class="view_satilan_duzenle"><?= money($ciro) ?> ₺ </a></td>
					<?php } else { ?>
						<td>? ₺</td>
					<?php } ?>
					<!--<td>
				<a style="<?= $renk ?>" href="?modul=muhasebe&sayfa=satilan_duzenle&id=<?= $satilanID ?>" target="_blank">Düzenle</a><br>
				<a style="<?= $renk ?>" href="?modul=ayarlar&sayfa=data_sil&id=<?= $satilanID ?>&q=satilan_sil"  onclick="return confirm('Silmek istediğinize emin misiniz ?')">Sil</a><br>
				<?php
				if ($satilan_oku['durum'] == 0) { ?>
							<a href="#myModal<?= $satilan_oku['id'] ?>" data-toggle="modal">İade Et</a>
					<?php } else { ?>
							<span style="<?= $renk ?>" >İade Edildi</span>
					<?php }
					?>
			</td> -->
					<!-- Modal -->
					<div id="myModal<?= $satilan_oku['id'] ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
						<form method="POST">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
								<h3 id="myModalLabel">İade Etme</h3>
							</div>
							<div class="modal-body">
								<div class="row-fluid">
									<textarea id="iade_aciklama" rows="3" name="iade_aciklama" class="span12"></textarea>
								</div>
							</div>
							<div class="modal-footer">
								<button class="btn" data-dismiss="modal" aria-hidden="true">Kapat</button>
								<button type="button" class="btn blue" onclick="guncelle(<?= $satilan_oku['id'] ?>)" name="iadeyi">Kaydet</button>
							</div>
						</form>
					</div>
				</tr>
		<?php }
		}  ?>
	</table>
</div>
<div class="custom-large-modal modal fade" id="ilan_notlari">
	<button type="button" class="close" style="margin-right: 2%; margin-top:2%;" data-dismiss="modal" aria-hidden="true"></button>
	<div class="modal-dialog">
		<div class="modal-body" id="ilanin_notlarini">
		</div>
	</div>
</div>
<div class="custom-large-modal modal fade" id="notlari">
	<button type="button" class="close" style="margin-right: 2%; margin-top:2%;" data-dismiss="modal" aria-hidden="true"></button>
	<div class="modal-dialog">
		<div class="modal-body" id="uyenin_notlari">
		</div>
	</div>
</div>
<div class="custom-large-modal modal fade" style="width: 75%;left: 25%;" id="yeni_veri_ekle">
	<button type="button" class="close" style="margin-right: 2%; margin-top:2%;" data-dismiss="modal" aria-hidden="true"></button>
	<div class="modal-dialog">
		<div class="modal-body" id="satilan_yeni_veri_ekle">
		</div>
	</div>
</div>
<div class="custom-large-modal modal fade" style="width: 75%;left: 25%;" id="yeni_veri_duzenle">
	<button type="button" class="close" style="margin-right: 2%; margin-top:2%;" data-dismiss="modal" aria-hidden="true"></button>
	<div class="modal-dialog">
		<div class="modal-body" id="satilan_yeni_veri_duzenle">
		</div>
	</div>
</div>
<script>
	function guncelle(sayi) {
		jQuery.ajax({
			url: "https://ihale.pertdunyasi.com/check.php",
			type: "POST",
			dataType: "JSON",
			data: {
				action: "satilan_guncelle",
				satilan_id: sayi,
				iade_aciklama: $('#iade_aciklama').val(),
			},
			success: function(data) {
				console.log(data);
				alert("İşlem başarılı");
				location.reload();
			}
		});
	}
</script>
<!-- <script>
   //Notları
   $(document).ready(function(){
        $(document).on('click', '.view_notlari', function(){
             var employee_id = $(this).attr("id");
             if(employee_id != '')
             {  
                  $.post('sayfalar/uyeler/notlari.php', {'id':employee_id}, function(response){
                     $('#uyenin_notlari').html(response);
                     $('#notlari').modal('show')
                  })
             }
        });
   });
   </script> -->
<script>
	/*var now = new Date();
	var day = ("0" + now.getDate()).slice(-2);
	var month = ("0" + (now.getMonth() + 1)).slice(-2);
	var today = now.getFullYear()+"-"+(month)+"-"+(day) ;
	$(function(){
		$('#plaka').on('keyup', function(){
			var plaka = $(this).val();
			if(plaka){
				$.post('sayfalar/muhasebe/bilgileri_cek.php', {'plaka': plaka}, function(response){
					var data = jQuery.parseJSON(response);
					console.log(data);
					if(data.status==200){
						$('#kod').val(data.kod);
						$('#marka_model').val(data.marka_model);
						$('#sigorta').val(data.sigorta);
						$('#satis_kimin_adina').val(data.satis_kimin_adina);
						$('#maliyet').val(data.maliyet);
						$('#pd_hizmet').val(data.pd_hizmet);
						$('#satis_tarihi').val(today);
					}else{
						alert(data.message);
					}
				});
		   }else{
			   alert("Böyle bir araç bulunamadı");
		   }
	   });
	   });*/
	function secilen_tarih_guncelle(value, value2) {
		if (value == 1) {
			if (value2 == 1) {
				$("#secilen_tarih_tumu").css("background", "orange");
				$("#secilen_tarih_prim").css("background", "#e5e5e5");
			} else {
				$("#secilen_tarih_tumu").css("background", "#e5e5e5");
				$("#secilen_tarih_prim").css("background", "orange");
			}

			$("#secilen_tarih_radio").val(value2);
		}
		if (value == 2) {
			if (value2 == 1) {
				$("#secilen_tarih_tumu2").css("background", "orange");
				$("#secilen_tarih_prim2").css("background", "#e5e5e5");
			} else {
				$("#secilen_tarih_tumu2").css("background", "#e5e5e5");
				$("#secilen_tarih_prim2").css("background", "orange");
			}

			$("#secilen_tarih_radio2").val(value2);
		}
	}

	function div_show(id, div) {
		if ($("#" + id).val() != "") {
			$("#" + div).css("display", "block");
		} else {
			$("#" + div).css("display", "none");
		}
	}
</script>

<script>
	function secilenleri_sil() {

		if ($(".chec").is(':checked')) {
			if (confirm("Seçilenler silmek istediğinize emin misiniz?")) {

				var array = [];
				var sayi = $(".chec").length;
				for (var i = 0; i < sayi; i++) {
					if (document.getElementsByClassName('chec')[i].checked == true) {
						array.push(document.getElementsByClassName('chec')[i].value);
					}
				}
				//alert(JSON.stringify(array));
				jQuery.ajax({
					url: "https://ihale.pertdunyasi.com/check.php",
					type: "POST",
					dataType: "JSON",
					data: {
						action: "panel_satilan_sil",
						secilenler: array,
					},
					success: function(data) {
						if(data.status == 200){
							location.reload();
							// alert("burda");
							/*
							var sayi2 = $(".chec").length;
							for (var j = 0; j < sayi2; j++) {
								if (document.getElementsByClassName('chec')[j].checked == true) {
									var $id = document.getElementsByClassName('chec')[j].value;
									$('#satilan_tr_'+$id).remove();
								}								
							}
							*/
						}
						console.log(data);
						/*alert("İşlem başarılı");  
						location.reload();*/
					}
				});
			} else {
				alert("İşlem iptal edildi");
			}
		} else {
			alert("Seçim yapmalısınız");
			return false;
		}
	}
</script>

<script>
	function bind_select_search(srch, select, arr_name) {
		window[arr_name] = []
		$(select + " option").each(function() {
			window[arr_name][this.value] = this.text
		})
		$(srch).keyup(function(e) {
			text = $(srch).val()
			if (text != '' || e.keyCode == 8) {
				arr = window[arr_name]
				$(select + " option").remove()
				tmp = ''
				for (key in arr) {
					option_text = arr[key].toLowerCase()
					if (option_text.search(text.toLowerCase()) > -1) {
						tmp += '<option value="' + key + '">' + arr[key] + '</option>'
					}
				}
				$(select).append(tmp)
			}
		})
		$(srch).keydown(function(e) {
			if (e.keyCode == 8) // Backspace
				$(srch).trigger('keyup')
		})
	}
</script>
<script>
	var clicked = false;
	$(".checkall").on("click", function() {
		$(".chec").prop("checked", !clicked);
		clicked = !clicked;
		this.innerHTML = clicked ? 'Seçimleri Kaldır' : 'Seç';
	});
</script>
<?php
if (re('satisi') == "Ekle") {

	$plaka = re('plaka');
	$kod = re('kod');
	$son_odeme = re('odeme_tarihi');
	$parayi_gonderen = re('parayi_gonderen');
	$marka_model = re('marka_model');
	$sigorta = re('sigorta');

	$satis_tarihi = re('satis_tarihi');
	$maliyet = re('maliyet');
	$pd_hizmet = re('pd_hizmet');
	$ekstra_kazanc = re('ektra_kazanc');
	$notlar = re('notlar');
	$satis_kimin_adina = re('serbest_secim');
	$satis_adi = re('satis_adi');

	$ilan_bul = mysql_query("SELECT * FROM ilanlar WHERE plaka = '" . $plaka . "'");
	$ilan_getir = mysql_fetch_assoc($ilan_bul);
	$ilan_id = $ilan_getir['id'];
	$uye_bul = mysql_query("SELECT * FROM user WHERE ad = '" . $satis_kimin_adina . "'");
	$uye_yaz = mysql_fetch_assoc($uye_bul);
	if (mysql_num_rows($uye_bul) == 1) {
		$uye_ad = $uye_yaz['ad'];
		$uye_id = $uye_yaz['id'];
		$temsilci_id = $uye_yaz['temsilci_id'];
		$temsilci_cek = mysql_query("select * from kullanicilar where id='" . $temsilci_id . "'");
		$temsilci_oku = mysql_fetch_assoc($temsilci_cek);
		$temsilci_prim_orani = $temsilci_oku["prim_orani"];
		$kazanilan_bul = mysql_query("SELECT * FROM kazanilan_ilanlar WHERE ilan_id = '" . $ilan_id . "'");
		$kazanilan_yaz = mysql_fetch_assoc($kazanilan_bul);
		$son_odeme = $kazanilan_yaz['son_odeme_tarihi'];
		$satilan_fiyat = $kazanilan_yaz['kazanilan_teklif'];
		$ciro =  ($satilan_fiyat  + $ekstra_kazanc + $pd_hizmet) - $maliyet;
		$prim = $ciro * $temsilci_prim_orani;
		$plaka_cek = mysql_query("select * from satilan_araclar where plaka='" . $plaka . "'");
		if (mysql_num_rows($plaka_cek) == 0) {
			/*
			$satis_ekle = mysql_query("INSERT INTO `satilan_araclar` (`id`,`ilan_id`,`uye_id`,`temsilci_id`,`plaka`,`kod`,`marka_model`,`sigorta`,`satis_adi`,`tarih`,`maliyet`,`pd_hizmet`,`ektra_kazanc`, `notlar`,`odeme_tarihi`,`parayi_gonderen`, 
			`araci_alan`,`satilan_fiyat`,`aciklayici_not`,`ciro`,`prim`) VALUES (NULL,'".$ilan_id."','".$uye_id."','".$temsilci_id."','".$plaka."','".$kod."','".$marka_model."','".$sigorta."','".$satis_adi."','".$satis_tarihi."','".$maliyet."', 
			'".$pd_hizmet."','".$ekstra_kazanc."','".$notlar."','".$son_odeme."','".$parayi_gonderen."','".$$uye_ad."','".$satilan_fiyat."','','".$ciro."','".$prim."')");
				
			var_dump("INSERT INTO `satilan_araclar` (`id`,`ilan_id`,`uye_id`,`temsilci_id`,`plaka`,`kod`,`marka_model`,`sigorta`,`satis_adi`,`tarih`,`maliyet`,`pd_hizmet`,`ektra_kazanc`,`notlar`,`odeme_tarihi`,`parayi_gonderen`,`araci_alan`, 
			`satilan_fiyat`,`aciklayici_not`,`ciro`,`prim`) VALUES (NULL,'".$ilan_id."','".$uye_id."','".$temsilci_id."','".$plaka."','".$kod."','".$marka_model."','".$sigorta."','".$satis_adi."','".$satis_tarihi."','".$maliyet."','".$pd_hizmet."', 
			'".$ekstra_kazanc."','".$notlar."','".$son_odeme."','".$parayi_gonderen."','".$uye_ad."','".$satilan_fiyat."','','".$ciro."','".$prim."')");
			*/
			/* if($satis_ekle){
					header("Location: ?modul=muhasebe&sayfa=satilan_araclar");
				}else{
					echo "<script>alert('Hata oluştu')</script>";
					echo "<script>window.location.href='?modul=muhasebe&sayfa=satilan_araclar'</script>";
				} */
		} else {
			echo "<script>alert('Bu plakaya ait araç daha önce eklenmiş')</script>";
			echo "<script>window.location.href='?modul=muhasebe&sayfa=satilan_araclar'</script>";
		}
	} else {
		echo "<script>alert('Uygun kullanıcı bulunamadı')</script>";
		echo "<script>window.location.href='?modul=muhasebe&sayfa=satilan_araclar'</script>";
	}
}
?>