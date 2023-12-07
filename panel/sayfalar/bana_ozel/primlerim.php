<?php
	session_start();
	$admin_id=$_SESSION['kid'];
	// $admin_id=139;
	$admin_yetki_cek=mysql_query("Select * from kullanicilar where id='".$admin_id."' ");
	$admin_yetki_oku=mysql_fetch_assoc($admin_yetki_cek);
	$yetkiler=$admin_yetki_oku["yetki"];
	$yetki_parcala=explode("|",$yetkiler);
	$admin_cek = mysql_query("select * from kullanicilar where id = '".$admin_id."'");
	$admin_oku = mysql_fetch_object($admin_cek);
	$admin_prim = $admin_oku->prim_orani;
?>
<style>
	.sari td{
		border: 1px solid #000 !important;
	}
</style>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="js/uyeler_modal.js?v=<? echo time();?>"></script>
<?php 
	if(re("listeleme")==""){
		if(re('tarih1')!="" || re("tarih2")!="" ){
			$where="WHERE tarih BETWEEN '".re('tarih1')."' AND '".re('tarih2')."' ";
			$odeme_href="?modul=bana_ozel&sayfa=primlerim&listeleme=odeme_tarihi_asc&tarih1=".re("tarih1")."&tarih2=".re("tarih2")."";
			$satis_href="?modul=bana_ozel&sayfa=primlerim&listeleme=tarih_desc&tarih1=".re("tarih1")."&tarih2=".re("tarih2")."";
			$excel_listeleme="https://ihale.pertdunyasi.com/excel.php?tarih1=".re('tarih1')."&tarih2=".re('tarih2')."&q=primlerim_tarihleri&listeleme=odeme_tarihi_desc";
		}else if(re('ay')!="" || re("yil")!=""){
			$where="WHERE  MONTH(tarih) = '".re('ay')."' AND YEAR(tarih)= '".re("yil")."' ";
			$odeme_href="?modul=bana_ozel&sayfa=primlerim&listeleme=odeme_tarihi_asc&ay=".re("ay")."&yil=".re("yil")."";
			$satis_href="?modul=bana_ozel&sayfa=primlerim&listeleme=tarih_desc&ay=".re("ay")."&yil=".re("yil")."";
			$excel_listeleme="https://ihale.pertdunyasi.com/excel.php?tarih1=".re('ay')."&tarih2=".re('yil')."&q=primlerim_secili_tarihi&listeleme=odeme_tarihi_desc";
		}else if(re('aranan')!="" ){
			$where="WHERE concat(plaka,' ',kod,' ',marka_model,' ',sigorta,' ',satis_adi,' ',maliyet,' ',pd_hizmet,' ',ektra_kazanc,' ',notlar,' ',parayi_gonderen,' ',araci_alan,' ',satilan_fiyat,' ',aciklayici_not,' ',ciro)  like '%".re('aranan')."%' ";
			$odeme_href="?modul=bana_ozel&sayfa=primlerim&listeleme=odeme_tarihi_asc&aranan=".re("aranan")."";
			$satis_href="?modul=bana_ozel&sayfa=primlerim&listeleme=tarih_desc&aranan=".re("aranan")."";
			$excel_listeleme="https://ihale.pertdunyasi.com/excel.php?&aranan=".re('aranan')."&q=primlerim_arama&listeleme=odeme_tarihi_desc";
		}else{
			$where="";
			$odeme_href="?modul=bana_ozel&sayfa=primlerim&listeleme=odeme_tarihi_asc";
			$satis_href="?modul=bana_ozel&sayfa=primlerim&listeleme=tarih_desc";
			$excel_listeleme="https://ihale.pertdunyasi.com/excel.php?q=primlerim_tarihsiz&listeleme=odeme_tarihi_desc";
		}
		$order_by=$where."order by odeme_tarihi desc";
	}else if(re("listeleme")=="odeme_tarihi_desc"){
		if(re('tarih1')!="" || re("tarih2")!="" ){
			$where="WHERE tarih BETWEEN '".re('tarih1')."' AND '".re('tarih2')."' ";
			$odeme_href="?modul=bana_ozel&sayfa=primlerim&listeleme=odeme_tarihi_asc&tarih1=".re("tarih1")."&tarih2=".re("tarih2")."";
			$satis_href="?modul=bana_ozel&sayfa=primlerim&listeleme=tarih_desc&tarih1=".re("tarih1")."&tarih2=".re("tarih2")."";
			$excel_listeleme="https://ihale.pertdunyasi.com/excel.php?tarih1=".re('tarih1')."&tarih2=".re('tarih2')."&q=primlerim_tarihleri&listeleme=odeme_tarihi_desc";
		}else if(re('ay')!="" || re("yil")!=""){
			$where="WHERE  MONTH(tarih) = '".re('ay')."' AND YEAR(tarih)= '".re("yil")."' ";
			$odeme_href="?modul=bana_ozel&sayfa=primlerim&listeleme=odeme_tarihi_asc&ay=".re("ay")."&yil=".re("yil")."";
			$satis_href="?modul=bana_ozel&sayfa=primlerim&listeleme=tarih_desc&ay=".re("ay")."&yil=".re("yil")."";
			$excel_listeleme="https://ihale.pertdunyasi.com/excel.php?tarih1=".re('ay')."&tarih2=".re('yil')."&q=primlerim_secili_tarihi&listeleme=odeme_tarihi_desc";
		}else if(re('aranan')!=""){
			$where="WHERE concat(plaka,' ',kod,' ',marka_model,' ',sigorta,' ',satis_adi,' ',maliyet,' ',pd_hizmet,' ',ektra_kazanc,' ',notlar,' ',parayi_gonderen,' ',araci_alan,' ',satilan_fiyat,' ',aciklayici_not,' ',ciro)  like '%".re('aranan')."%' ";
			$odeme_href="?modul=bana_ozel&sayfa=primlerim&listeleme=odeme_tarihi_asc&aranan=".re("aranan")."";
			$satis_href="?modul=bana_ozel&sayfa=primlerim&listeleme=tarih_desc&aranan=".re("aranan")."";
			$excel_listeleme="https://ihale.pertdunyasi.com/excel.php?aranan=".re('aranan')."&q=primlerim_arama&listeleme=odeme_tarihi_desc";
		}else{
			$odeme_href="?modul=bana_ozel&sayfa=primlerim&listeleme=odeme_tarihi_asc";
			$satis_href="?modul=bana_ozel&sayfa=primlerim&listeleme=tarih_desc";
			$where="";
			$excel_listeleme="https://ihale.pertdunyasi.com/excel.php?q=primlerim_tarihsiz&listeleme=odeme_tarihi_desc";
		}
		$order_by=$where."order by odeme_tarihi desc";
	}else if(re("listeleme")=="odeme_tarihi_asc"){
		if(re('tarih1')!="" || re("tarih2")!="" ){
			$where="WHERE tarih BETWEEN '".re('tarih1')."' AND '".re('tarih2')."' ";
			$odeme_href="?modul=bana_ozel&sayfa=primlerim&listeleme=odeme_tarihi_desc&tarih1=".re("tarih1")."&tarih2=".re("tarih2")."";
			$satis_href="?modul=bana_ozel&sayfa=primlerim&listeleme=tarih_desc&tarih1=".re("tarih1")."&tarih2=".re("tarih2")."";
			$excel_listeleme="https://ihale.pertdunyasi.com/excel.php?tarih1=".re('tarih1')."&tarih2=".re('tarih2')."&q=primlerim_tarihleri&listeleme=odeme_tarihi_asc";
		}else if(re('ay')!="" || re("yil")!=""){
			$where="WHERE  MONTH(tarih) = '".re('ay')."' AND YEAR(tarih)= '".re("yil")."' ";
			$odeme_href="?modul=bana_ozel&sayfa=primlerim&listeleme=odeme_tarihi_desc&ay=".re("ay")."&yil=".re("yil")."";
			$satis_href="?modul=bana_ozel&sayfa=primlerim&listeleme=tarih_desc&ay=".re("ay")."&yil=".re("yil")."";
			$excel_listeleme="https://ihale.pertdunyasi.com/excel.php?tarih1=".re('ay')."&tarih2=".re('yil')."&q=primlerim_secili_tarihi&listeleme=odeme_tarihi_asc";
		}else if(re('aranan')!=""){
			$where="WHERE concat(plaka,' ',kod,' ',marka_model,' ',sigorta,' ',satis_adi,' ',maliyet,' ',pd_hizmet,' ',ektra_kazanc,' ',notlar,' ',parayi_gonderen,' ',araci_alan,' ',satilan_fiyat,' ',aciklayici_not,' ',ciro)  like '%".re('aranan')."%' ";
			$odeme_href="?modul=bana_ozel&sayfa=primlerim&listeleme=odeme_tarihi_desc&aranan=".re("aranan")."";
			$satis_href="?modul=bana_ozel&sayfa=primlerim&listeleme=tarih_desc&aranan=".re('aranan')."";
			$excel_listeleme="https://ihale.pertdunyasi.com/excel.php?aranan=".re('aranan')."&q=primlerim_arama&listeleme=odeme_tarihi_asc";
		}else{
			$where="";
			$odeme_href="?modul=bana_ozel&sayfa=primlerim&listeleme=odeme_tarihi_desc";
			$satis_href="?modul=bana_ozel&sayfa=primlerim&listeleme=tarih_desc";
			$excel_listeleme="https://ihale.pertdunyasi.com/excel.php?q=primlerim_tarihsiz&listeleme=odeme_tarihi_asc";
		}
	    $order_by=$where."order by odeme_tarihi asc";
	}else if(re("listeleme")=="tarih_desc"){
		if(re('tarih1')!="" || re("tarih2")!="" ){
			$where="WHERE tarih BETWEEN '".re('tarih1')."' AND '".re('tarih2')."' ";
			$odeme_href="?modul=bana_ozel&sayfa=primlerim&listeleme=odeme_tarihi_desc&tarih1=".re("tarih1")."&tarih2=".re("tarih2")."";
			$satis_href="?modul=bana_ozel&sayfa=primlerim&listeleme=tarih_asc&tarih1=".re("tarih1")."&tarih2=".re("tarih2")."";
			$excel_listeleme="https://ihale.pertdunyasi.com/excel.php?tarih1=".re('tarih1')."&tarih2=".re('tarih2')."&q=primlerim_tarihleri&listeleme=tarih_desc";
		}else if(re('ay')!="" || re("yil")!=""){
			$where="WHERE  MONTH(tarih) = '".re('ay')."' AND YEAR(tarih)= '".re("yil")."' ";
			$odeme_href="?modul=bana_ozel&sayfa=primlerim&listeleme=odeme_tarihi_desc&ay=".re("ay")."&yil=".re("yil")."";
			$satis_href="?modul=bana_ozel&sayfa=primlerim&listeleme=tarih_asc&ay=".re("ay")."&yil=".re("yil")."";
			$excel_listeleme="https://ihale.pertdunyasi.com/excel.php?tarih1=".re('ay')."&tarih2=".re('yil')."&q=primlerim_secili_tarihi&listeleme=tarihi_desc";
		}else if(re('aranan')!=""){
			$where="WHERE concat(plaka,' ',kod,' ',marka_model,' ',sigorta,' ',satis_adi,' ',maliyet,' ',pd_hizmet,' ',ektra_kazanc,' ',notlar,' ',parayi_gonderen,' ',araci_alan,' ',satilan_fiyat,' ',aciklayici_not,' ',ciro)  like '%".re('aranan')."%' ";
			$odeme_href="?modul=bana_ozel&sayfa=primlerim&listeleme=odeme_tarihi_desc&aranan=".re('aranan')."";
			$satis_href="?modul=bana_ozel&sayfa=primlerim&listeleme=tarih_asc&aranan=".re('aranan')."";
			$excel_listeleme="https://ihale.pertdunyasi.com/excel.php?aranan=".re('aranan')."&q=primlerim_arama&listeleme=tarih_desc";
		}else{
			$where="";
			$odeme_href="?modul=bana_ozel&sayfa=primlerim&listeleme=odeme_tarihi_desc";
			$satis_href="?modul=bana_ozel&sayfa=primlerim&listeleme=tarih_asc";
			$excel_listeleme="https://ihale.pertdunyasi.com/excel.php?q=primlerim_tarihsiz&listeleme=tarih_desc";
		}
		$order_by=$where."order by tarih desc";
	}else if(re("listeleme")=="tarih_asc"){
		if(re('tarih1')!="" || re("tarih2")!="" ){
			$where="WHERE tarih BETWEEN '".re('tarih1')."' AND '".re('tarih2')."' ";
			$odeme_href="?modul=bana_ozel&sayfa=primlerim&listeleme=odeme_tarihi_desc&tarih1=".re("tarih1")."&tarih2=".re("tarih2")."";
			$satis_href="?modul=bana_ozel&sayfa=primlerim&listeleme=tarih_desc&tarih1=".re("tarih1")."&tarih2=".re("tarih2")."";
			$excel_listeleme="https://ihale.pertdunyasi.com/excel.php?tarih1=".re('tarih1')."&tarih2=".re('tarih2')."&q=primlerim_tarihleri&listeleme=tarih_asc";
		}else if(re('ay')!="" || re("yil")!=""){
			$where="WHERE  MONTH(tarih) = '".re('ay')."' AND YEAR(tarih)= '".re("yil")."' ";
			$odeme_href="?modul=bana_ozel&sayfa=primlerim&listeleme=odeme_tarihi_desc&ay=".re("ay")."&yil=".re("yil")."";
			$satis_href="?modul=bana_ozel&sayfa=primlerim&listeleme=tarih_desc&ay=".re("ay")."&yil=".re("yil")."";
			$excel_listeleme="https://ihale.pertdunyasi.com/excel.php?tarih1=".re('ay')."&tarih2=".re('yil')."&q=primlerim_secili_tarihi&listeleme=tarih_asc";
		}else if(re('aranan') != ""){
		 	$where="WHERE concat(plaka,' ',kod,' ',marka_model,' ',sigorta,' ',satis_adi,' ',maliyet,' ',pd_hizmet,' ',ektra_kazanc,' ',notlar,' ',parayi_gonderen,' ',araci_alan,' ',satilan_fiyat,' ',aciklayici_not,' ',ciro)  like '%".re('aranan')."%' ";
			$odeme_href="?modul=bana_ozel&sayfa=primlerim&listeleme=odeme_tarihi_desc&aranan=".re("aranan")."";
			$satis_href="?modul=bana_ozel&sayfa=primlerim&listeleme=tarih_desc&aranan=".re("aranan")."";
			$excel_listeleme="https://ihale.pertdunyasi.com/excel.php?aranan=".re('aranan')."&q=primlerim_arama&listeleme=tarih_asc"; 
		}else{
			$where="";
			$odeme_href="?modul=bana_ozel&sayfa=primlerim&listeleme=odeme_tarihi_desc";
			$satis_href="?modul=bana_ozel&sayfa=primlerim&listeleme=tarih_desc";
			$excel_listeleme="https://ihale.pertdunyasi.com/excel.php?q=primlerim_tarihsiz&listeleme=tarih_asc";
		}
		$order_by=$where."order by tarih asc";
	}else {
		if(re('tarih1')!="" || re("tarih2")!="" ){
			$where="WHERE tarih BETWEEN '".re('tarih1')."' AND '".re('tarih2')."' ";
			$odeme_href="?modul=bana_ozel&sayfa=primlerim&listeleme=odeme_tarihi_desc&tarih1=".re("tarih1")."&tarih2=".re("tarih2")."";
			$satis_href="?modul=bana_ozel&sayfa=primlerim&listeleme=tarih_desc&tarih1=".re("tarih1")."&tarih2=".re("tarih2")."";
			$excel_listeleme="https://ihale.pertdunyasi.com/excel.php?tarih1=".re('tarih1')."&tarih2=".re('tarih2')."&q=primlerim_tarihleri&listeleme=odeme_tarihi_desc";
		}else if(re('ay')!="" || re("yil")!=""){
			$where="WHERE  MONTH(tarih) = '".re('ay')."' AND YEAR(tarih)= '".re("yil")."' ";
			$odeme_href="?modul=bana_ozel&sayfa=primlerim&listeleme=odeme_tarihi_desc&ay=".re("ay")."&yil=".re("yil")."";
			$satis_href="?modul=bana_ozel&sayfa=primlerim&listeleme=tarih_desc&ay=".re("ay")."&yil=".re("yil")."";
			$excel_listeleme="https://ihale.pertdunyasi.com/excel.php?tarih1=".re('ay')."&tarih2=".re('yil')."&q=primlerim_secili_tarihi&listeleme=odeme_tarihi_desc";
		}else if(re('aranan')!=""){
			$where="WHERE concat(plaka,' ',kod,' ',marka_model,' ',sigorta,' ',satis_adi,' ',maliyet,' ',pd_hizmet,' ',ektra_kazanc,' ',notlar,' ',parayi_gonderen,' ',araci_alan,' ',satilan_fiyat,' ',aciklayici_not,' ',ciro)  like '%".re('aranan')."%' ";
			$odeme_href="?modul=bana_ozel&sayfa=primlerim&listeleme=odeme_tarihi_desc&aranan=".re("aranan")."";
			$satis_href="?modul=bana_ozel&sayfa=primlerim&listeleme=tarih_desc&aranan=".re("aranan")."";
			$excel_listeleme="https://ihale.pertdunyasi.com/excel.php?aranan=".re('aranan')."&q=primlerim_arama&listeleme=odeme_tarihi_desc"; 
		}else{
			$where="";
			$odeme_href="?modul=bana_ozel&sayfa=primlerim&listeleme=odeme_tarihi_desc";
			$satis_href="?modul=bana_ozel&sayfa=primlerim&listeleme=tarih_desc";
			$excel_listeleme="https://ihale.pertdunyasi.com/excel.php?q=primlerim_tarihsiz&listeleme=odeme_tarihi_desc";
		}
		$order_by=$where."order by odeme_tarihi desc";
   }
   $satilan_cek = mysql_query("SELECT satilan_araclar.* FROM satilan_araclar INNER JOIN user ON user.id=satilan_araclar.uye_id 
   INNER JOIN prm_notlari ON prm_notlari.uye_id = satilan_araclar.uye_id WHERE satilan_araclar.prim > 0 AND prm_notlari.durum = 1 AND
   user.temsilci_id='".$admin_id."' AND MONTH(satilan_araclar.odeme_tarihi) = '".date('m')."' $order_by ");
   $satilan_cek_prim = mysql_query("SELECT satilan_araclar.* FROM satilan_araclar INNER JOIN user ON user.id=satilan_araclar.uye_id 
   INNER JOIN prm_notlari ON prm_notlari.uye_id = satilan_araclar.uye_id WHERE satilan_araclar.prim > 0 AND prm_notlari.durum = 1 AND
   user.temsilci_id='".$admin_id."' AND MONTH(satilan_araclar.odeme_tarihi) = '".date('m')."' $order_by ");
   $satilan_sayi = mysql_num_rows($satilan_cek);
   $sira = 1;
   $result = mysql_query("SELECT SUM(satilan_araclar.prim) as prim FROM satilan_araclar INNER JOIN user ON user.id=satilan_araclar.uye_id WHERE 
   user.temsilci_id='".$admin_id."' AND satilan_araclar.prim > 0 AND satilan_araclar.durum=0"); 
   $row = mysql_fetch_assoc($result); 
   $sum = $row['prim'];
   $month = date('m');
   $buay = mysql_query("SELECT SUM(satilan_araclar.prim) as prim FROM satilan_araclar INNER JOIN user ON user.id=satilan_araclar.uye_id 
   INNER JOIN prm_notlari ON prm_notlari.uye_id = satilan_araclar.uye_id WHERE user.temsilci_id='".$admin_id."' AND prm_notlari.durum = 1
   AND satilan_araclar.durum=0 AND satilan_araclar.prim > 0 AND MONTH(satilan_araclar.odeme_tarihi) = '".$month."'"); 
   $buay_getir = mysql_fetch_assoc($buay); 
   $buay_ciro = $buay_getir['prim'];
   $current_month=date('m');
   $current_year=date('Y');
   $lastmonth=$current_month-1;
   $gecenay = mysql_query("SELECT SUM(satilan_araclar.prim) as prim FROM satilan_araclar INNER JOIN user ON user.id=satilan_araclar.uye_id
   INNER JOIN prm_notlari ON prm_notlari.uye_id = satilan_araclar.uye_id WHERE prm_notlari.durum = 1 AND
   user.temsilci_id='".$admin_id."' AND satilan_araclar.prim > 0 AND satilan_araclar.durum=0 AND MONTH(satilan_araclar.odeme_tarihi) = '".$lastmonth."'"); 
   $gecenay_getir = mysql_fetch_assoc($gecenay); 
   $gecenay_ciro = $gecenay_getir['prim'];
   $year = date('Y');
   $buyil = mysql_query("SELECT SUM(satilan_araclar.prim) as prim FROM satilan_araclar INNER JOIN user ON user.id=satilan_araclar.uye_id 
   INNER JOIN prm_notlari ON prm_notlari.uye_id = satilan_araclar.uye_id WHERE prm_notlari.durum = 1 AND
   user.temsilci_id='".$admin_id."' AND satilan_araclar.prim > 0 AND satilan_araclar.durum=0 AND YEAR(satilan_araclar.odeme_tarihi) = '".$year."'"); 
   $buyil_getir = mysql_fetch_assoc($buyil); 
   $buyil_ciro = $buyil_getir['prim'];
   $lastyear = $year-1;
   $gecenyil = mysql_query("SELECT SUM(satilan_araclar.prim) as prim FROM satilan_araclar INNER JOIN user ON user.id=satilan_araclar.uye_id
   INNER JOIN prm_notlari ON prm_notlari.uye_id = satilan_araclar.uye_id WHERE prm_notlari.durum = 1 AND
   user.temsilci_id='".$admin_id."' AND satilan_araclar.prim > 0 AND satilan_araclar.durum=0 AND YEAR(satilan_araclar.odeme_tarihi) = '".$lastyear."'"); 
   $gecenyil_getir = mysql_fetch_assoc($gecenyil); 
   $gecenyil_ciro = $gecenyil_getir['prim'];
?>
<style>
	.dikey{
		writing-mode: tb-rl;
		transform: rotate(-180deg);
	}
	.sari{
		/* background-color: rgb(255,255,0); */
		background-color: #d9d9d9;
	}
	.laci{
		background-color: rgb(51,51,153);
		color: #ffffff;
	}
	.acik_mavi{
		/* background-color: rgb(219,229,241); */
		background-color: #d9d9d9;
	}
</style>
<div style="overflow-x:auto; overflow-y:auto;">
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
<style>
	.ay_select option{
		background-color: #f2f2f2;
	}
</style>
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
						<td style="background-color: #f2f2f2;"><?= money($buay_ciro) ?> ₺</td>
						<td style="background-color: #f2f2f2;"><?= money($gecenay_ciro) ?> ₺</td>
						<td style="background-color: #f2f2f2;"><?= money($buyil_ciro) ?> ₺</td>
						<td style="background-color: #f2f2f2;"><?= money($gecenyil_ciro) ?> ₺</td>
					</tr>
				</table>
			</div>
			<div style="margin-top:60px;" class="span5">
				<input type="text" value="<?=re("aranan") ?>" style="width:50%;background-color: #f2f2f2;" name="aranan" value="" placeholder="aramak istediğinzi kelimeyi yazın">
				<input type="submit" name="aranan_kelime" style="height:30px;margin-bottom:10px;background:#ffc000"  class="input-mini btn" value="Ara">
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
								<input type="date" style="width:100%;background-color: #f2f2f2;" value="<?=re("tarih1") ?>" name="tarih1" id="tarih1" class="input-mini">
							</div>
							<div class="span4">
								<input type="date" style="width:100%;background-color: #f2f2f2;" value="<?=re("tarih2") ?>" name="tarih2" id="tarih2" class="input-mini" />
							</div>
						</div>
					</div>
					<div class="span3">
						<input type="submit" name="tarihleri" class="input-mini btn blue" value="Filtrele">
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
								<select style="width:100%;background-color: #f2f2f2;" name="ay" id="ay" class="input-mini ay_select">
									<option <?php if(re("ay")==""){ echo "selected"; } ?> value="">Seçiniz</option>
									<option <?php if(re("ay")=="01"){ echo "selected"; } ?> value="01">Ocak</option>
									<option <?php if(re("ay")=="02"){ echo "selected"; } ?> value="02">Şubat</option>
									<option <?php if(re("ay")=="03"){ echo "selected"; } ?> value="03">Mart</option>
									<option <?php if(re("ay")=="04"){ echo "selected"; } ?> value="04">Nisan</option>
									<option <?php if(re("ay")=="05"){ echo "selected"; } ?> value="05">Mayıs</option>
									<option <?php if(re("ay")=="06"){ echo "selected"; } ?> value="06">Haziran</option>
									<option <?php if(re("ay")=="07"){ echo "selected"; } ?> value="07">Temmuz</option>
									<option <?php if(re("ay")=="08"){ echo "selected"; } ?> value="08">Ağustos</option>
									<option <?php if(re("ay")=="09"){ echo "selected"; } ?> value="09">Eylül</option>
									<option <?php if(re("ay")=="10"){ echo "selected"; } ?> value="10">Ekim</option>
									<option <?php if(re("ay")=="11"){ echo "selected"; } ?> value="11">Kasım</option>
									<option <?php if(re("ay")=="12"){ echo "selected"; } ?> value="12">Aralık</option>
								</select>
							</div>
							<div class="span4">
								<select style="width:100%;background-color: #f2f2f2;" name="yil" id="yil" class="input-mini">
									<option <?php if(re("ay")==""){ echo "selected"; } ?> value="">Seçiniz</option>
									<?php for($i=$year;$i>=2010;$i--){ ?>								
										<option <?php if(re("yil")==$i ){ echo "selected"; } ?> value="<?= $i ?>"><?= $i ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
					</div>
					<div class="span3">
						<input type="submit" style="margin-bottom:10px;" name="secili_tarihi" class="input-mini btn blue" value="Filtrele">
					</div>
				</div>
			</div>
			</div>
		</div>
	</form>
	<table class="table table-bordered" style="display: none;">
		<tr class="sari" style="overflow:hidden;overflow-y: scroll;">
			<td><input type="checkbox" id="tumunu_sec" name="tumunu_sec">SEÇ</td>
			<td><p class="dikey">SIRA</p></td>
			<td><a href="<?=$odeme_href ?>" >ÖDEME TARİHİ</a></td>
			<td>ÖDEYEN</td>
			<td>KOD</td>			
			<td>PLAKA</td>
			<td>MARKA MODEL</td>
			<td>SİGORTA</td>
			<td>ÜYE ADI</td>
			<td>SATIŞ KİMİN ADINA YAPILDI</td>
			<td><a href="<?=$satis_href ?>"> SATIŞ TARİHİ </a></td>
			<td>SATILAN FİYAT</td>
			<td>PD HİZMET BEDELİ</td>
			<td>KAZANILAN PRİM</td>
			<td>MENÜ</td>
		</tr>
	</table>
		<?php 
			if(re("tarih1")!="" || re("tarih2")!="" ){
				$_POST["ay"]="";
				$_POST["yil"]="";
				if(re("listeleme")==""){
				   $order_by="order by odeme_tarihi desc";
				}else if(re("listeleme")=="odeme_tarihi_desc"){
				   $order_by="order by odeme_tarihi desc";
				}else if(re("listeleme")=="odeme_tarihi_asc"){
					$order_by="order by odeme_tarihi asc";
				}else if(re("listeleme")=="tarih_desc"){
				   $order_by="order by tarih desc";
				}else if(re("listeleme")=="tarih_asc"){
					$order_by="order by tarih asc";			  
				}else {
					$order_by="order by odeme_tarihi desc";
				}
				//$filtre_cek = mysql_query("SELECT * FROM satilan_araclar WHERE tarih BETWEEN '".re('tarih1')."' AND '".re('tarih2')."' $order_by ");
				$filtre_cek_sql = "SELECT satilan_araclar.* FROM satilan_araclar INNER JOIN user ON user.id=satilan_araclar.uye_id INNER JOIN prm_notlari ON prm_notlari.uye_id = satilan_araclar.uye_id 
				WHERE user.temsilci_id='".$admin_id."' AND prm_notlari.durum = 1 ";
				if(re('tarih1') != ""){
					$filtre_cek_sql .= " AND satilan_araclar.odeme_tarihi >= '".re('tarih1')."' ";
				}
				if(re('tarih2') != ""){
					$filtre_cek_sql .= " AND satilan_araclar.odeme_tarihi <= '".re('tarih2')."' ";
				}
				$filtre_cek_sql .= $order_by;
				// echo $filtre_cek_sql;
				/*
				$filtre_cek = mysql_query("SELECT satilan_araclar.* FROM satilan_araclar INNER JOIN user ON user.id=satilan_araclar.uye_id WHERE 
				user.temsilci_id='".$admin_id."' AND satilan_araclar.prim > 0 AND satilan_araclar.tarih BETWEEN '".re('tarih1')."' AND '".re('tarih2')."' $order_by ");
				*/
				$filtre_cek = mysql_query($filtre_cek_sql);
				$filtre_cek_prim = mysql_query($filtre_cek_sql);
				$filtre_sayi = mysql_num_rows($filtre_cek); 
				//$tarihFiltre = mysql_query('SELECT SUM(ciro) AS ciro FROM satilan_araclar WHERE tarih BETWEEN "'.re('tarih1').'" AND "'.re('tarih2').'" and durum=0  '); 
				$tarihFiltre_cek = "SELECT SUM(satilan_araclar.prim) as prim FROM satilan_araclar INNER JOIN user ON user.id=satilan_araclar.uye_id 
				INNER JOIN prm_notlari ON prm_notlari.uye_id = satilan_araclar.uye_id WHERE 
				user.temsilci_id='".$admin_id."' AND satilan_araclar.prim > 0 AND prm_notlari.durum = 1 AND satilan_araclar.durum=0";
				if(re('tarih1') != ""){
					$tarihFiltre_cek .= " AND satilan_araclar.odeme_tarihi >= '".re('tarih1')."' ";
				}
				if(re('tarih2') != ""){
					$tarihFiltre_cek .= " AND satilan_araclar.odeme_tarihi <= '".re('tarih2')."' ";
				}
				$tarihFiltre_cek .= $order_by;
				$tarihFiltre = mysql_query($tarihFiltre_cek);
				/*
				$tarihFiltre = mysql_query("SELECT SUM(satilan_araclar.prim) as prim FROM satilan_araclar INNER JOIN user ON user.id=satilan_araclar.uye_id WHERE 
				user.temsilci_id='".$admin_id."' AND satilan_araclar.prim > 0 AND satilan_araclar.tarih BETWEEN '".re('tarih1')."' AND '".re('tarih2')."' AND 
				satilan_araclar.durum=0 $order_by "); 
				*/
				$filtreToplam = mysql_fetch_assoc($tarihFiltre); 
				if (in_array(10, $yetki_parcala)  ) { 
					$ToplamFiltre = money($filtreToplam['prim']);
				}else{
					$ToplamFiltre = "?";
				}

				$toplam_prim = 0;
				while($filtre_oku_prim = mysql_fetch_array($filtre_cek_prim)){
					if($filtre_oku_prim["durum"]!=1){
						$prim_first = $filtre_oku_prim["pd_hizmet"] * $admin_prim;
						$toplam_prim += $prim_first / 100;
					}					
				}

            ?>
		<div class="row-fluid">
				<div class="span6"><h4>TOPLAM PRİM <?= money($toplam_prim) ?>₺</h4></div>
				<div class="span6"><a href="<?=$excel_listeleme ?>" style="background:#fcd5b4; float:right;" class="input-mini btn" >Excel</a></div>
			</div>			
			<table class="table table-bordered" id="primlerim_table">
				<thead>
				<tr class="sari" style="overflow:hidden;overflow-y: scroll;">
					<td><input type="checkbox" id="tumunu_sec" name="tumunu_sec">SEÇ</td>
					<td><p class="dikey">SIRA</p></td>
					<td><a href="<?=$odeme_href ?>" >ÖDEME TARİHİ</a></td>
					<td>ÖDEYEN</td>
					<td>KOD</td>			
					<td>PLAKA</td>
					<td>MARKA MODEL</td>
					<td>SİGORTA</td>
					<td>ÜYE ADI</td>
					<td>SATIŞ KİMİN ADINA YAPILDI</td>
					<td><a href="<?=$satis_href ?>"> SATIŞ TARİHİ </a></td>
					<td>SATILAN FİYAT</td>
					<td>PD HİZMET BEDELİ</td>
					<td>KAZANILAN PRİM</td>
					<!-- <td>MENÜ</td> -->
				</tr>
				</thead>
				<tbody>
		<?php 
			while($filtre_oku = mysql_fetch_array($filtre_cek)){ 
				$satilanID = $filtre_oku['id'];
				$ciro = $filtre_oku['prim'];
				if($filtre_oku["durum"]==1){
					$style="background:red;color:white;";
					$arka_plan="backgroud:red;";
					$renk="color:white !important;";
				}else{
					$style="";
					$arka_plan="";
					$renk="";
				}
		?>
		<tr style="<?=$style ?>">
			<td><input type="checkbox" id="primlerim_<?=$filtre_oku["id"] ?>" name="primlerim[]" value="<?=$filtre_oku["id"] ?>" ></td>
			<td style="<?=$style ?>" class="laci"><?= $sira++ ?></td>
			<?php
				if($filtre_oku['odeme_tarihi']!="0000-00-00"){?>
					<td><?= date("d-m-Y",strtotime($filtre_oku['odeme_tarihi'])) ?></td>
				<?php }else{ ?>
					<td> </td>
				<?php }
				$prim_first = $filtre_oku["pd_hizmet"] * $admin_prim;
				$prim = $prim_first / 100;
				if($filtre_oku['tarih'] == "0000-00-00"){
					$tarih = "";
				}else{
					$tarih = date("d-m-Y", strtotime($filtre_oku['tarih']));
				}
			?>
			<td><?= $filtre_oku['parayi_gonderen']?></td>
			<td id="td_view_ilan_notlari_<?=$filtre_oku["ilan_id"]?>"><a style="<?=$renk ?>" class="view_ilan_notlari" id="<?=$filtre_oku["ilan_id"]?>"><?= $filtre_oku['kod']?></a></td>
			<td><a style="<?=$renk ?>"  href="?modul=ilanlar&sayfa=ilan_ekle&id=<?= $filtre_oku['ilan_id'] ?>" target="_blank"><?= $filtre_oku['plaka']?></a></td>
			<td><a style="<?=$renk ?>"  href="../arac_detay.php?id=<?= $filtre_oku['ilan_id'] ?>&q=ihale" target="_blank"><?= $filtre_oku['marka_model']?></a></td>
			<td><?= $filtre_oku['sigorta'] ?></td>
			<td id="td_view_notlari_<?=$filtre_oku["uye_id"]?>"><a id="<?=$filtre_oku["uye_id"]?>" class="view_notlari"><?=$filtre_oku['araci_alan']?></a></td>
			<td><?= $filtre_oku['satis_adi']?></td>
			<td><?= $tarih ?></td>
			<td><?= money($filtre_oku['satilan_fiyat']) ?> ₺</td>
			<td><?= money($filtre_oku['pd_hizmet']) ?> ₺</td>
			<td><?= money($prim) ?> ₺</td>
			<!-- <td><a style="<?=$renk ?>"  href="?modul=muhasebe&sayfa=satilan_duzenle&id=<?= $satilanID ?>" target="_blank">Düzenle</a><br>
				<a style="<?=$renk ?>"  href="?modul=ayarlar&sayfa=data_sil&id=<?= $satilanID ?>&q=satilan_sil"  onclick="return confirm('Silmek istediğinize emin misiniz ?')">Sil</a><br>
				<?php
					if($filtre_oku['durum']==0){?>
							<a href="#myModal<?= $filtre_oku['id'] ?>" data-toggle="modal">İade Et</a>
					<?php }else{?>
							<span style="<?=$renk ?>"  >İade Edildi</span>
					<?php }
				?>
			</td> -->
			<!-- Modal -->
			<div id="myModal<?= $filtre_oku['id'] ?>" class="custom-large-modal modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
		</tbody>
		</table>
		<?php }else if(re("ay")!="" || re("yil")!="" ){ 
			$_POST["tarih1"]="";
			$_POST["tarih2"]="";
			if(re("listeleme")==""){
			   $order_by="order by odeme_tarihi desc";
			}else if(re("listeleme")=="odeme_tarihi_desc"){
			   $order_by="order by odeme_tarihi desc";
			}else if(re("listeleme")=="odeme_tarihi_asc"){
				$order_by="order by odeme_tarihi asc";
			}else if(re("listeleme")=="tarih_desc"){
			   $order_by="order by tarih desc";
			}else if(re("listeleme")=="tarih_asc"){
				$order_by="order by tarih asc";			  
			}else {
				$order_by="order by odeme_tarihi desc";
			}
			$gelen_ay = re('ay');
			$gelen_yil = re('yil');
			/*
			$filtre = mysql_query("SELECT satilan_araclar.* FROM satilan_araclar INNER JOIN user ON user.id=satilan_araclar.uye_id WHERE user.temsilci_id='".$admin_id."' AND
			satilan_araclar.prim > 0 AND MONTH(satilan_araclar.tarih) = '".$gelen_ay."' AND YEAR(satilan_araclar.tarih)= '".$gelen_yil."' $order_by ");
			*/
			$filtre_sql = "SELECT satilan_araclar.* FROM satilan_araclar INNER JOIN user ON user.id=satilan_araclar.uye_id INNER JOIN prm_notlari ON prm_notlari.uye_id = satilan_araclar.uye_id
			WHERE user.temsilci_id='".$admin_id."' AND satilan_araclar.prim > 0 AND prm_notlari.durum = 1 ";
			if($gelen_ay != 0 && $gelen_ay != ""){
				$filtre_sql .= " AND MONTH(satilan_araclar.odeme_tarihi) = '".$gelen_ay."'";
			}
			if($gelen_yil != ""){
				$filtre_sql .= " AND YEAR(satilan_araclar.odeme_tarihi) = '".$gelen_yil."' ";
			}
			$filtre_sql .= $order_by;
			// echo $filtre_sql;
			$filtre = mysql_query($filtre_sql);
			$filtre_prim_cek = mysql_query($filtre_sql);
			$filterCount = mysql_num_rows($filtre);
			/*
			$ayYil = mysql_query("SELECT SUM(satilan_araclar.prim) as prim FROM satilan_araclar INNER JOIN user ON user.id=satilan_araclar.uye_id WHERE 
			user.temsilci_id='".$admin_id."' AND satilan_araclar.prim > 0 AND MONTH(satilan_araclar.tarih) = '".$gelen_ay."' AND YEAR(satilan_araclar.tarih)= '".$gelen_yil."' 
			AND satilan_araclar.durum=0 $order_by ");
			*/
			$ayYil_sql = "SELECT SUM(satilan_araclar.prim) as prim FROM satilan_araclar INNER JOIN user ON user.id=satilan_araclar.uye_id INNER JOIN prm_notlari ON prm_notlari.uye_id = satilan_araclar.uye_id 
			WHERE user.temsilci_id='".$admin_id."' AND satilan_araclar.prim > 0 AND satilan_araclar.durum=0 AND prm_notlari.durum = 1 ";
			if($gelen_ay != 0 && $gelen_ay != ""){
				$ayYil_sql .= " AND MONTH(satilan_araclar.odeme_tarihi) = '".$gelen_ay."'";
			}
			if($gelen_yil != ""){
				$ayYil_sql .= " AND YEAR(satilan_araclar.odeme_tarihi) = '".$gelen_yil."'";
			}
			$ayYil_sql = $order_by;
			$ayYil = mysql_query($ayYil_sql);
								
			$AyYilToplam = mysql_fetch_assoc($ayYil); 
			$AyYilCiro = $AyYilToplam['prim']; 
			$toplam_prim = 0;
			while($filtre_oku_prim = mysql_fetch_array($filtre_prim_cek)){
				if($filtre_oku_prim["durum"]!=1){
					$prim_first = $filtre_oku_prim["pd_hizmet"] * $admin_prim;
					$toplam_prim += $prim_first / 100;
				}
			}
        ?>
			<div class="row-fluid">
				<div class="span6"><h4>TOPLAM PRİM <?= money($toplam_prim) ?>₺</h4></div>
				<div class="span6"><a href="<?=$excel_listeleme ?>" style="background:#fcd5b4; float:right;" class="input-mini btn" >Excel</a></div>
			</div>			
			<table class="table table-bordered" id="primlerim_table">
				<thead>
					<tr class="sari" style="overflow:hidden;overflow-y: scroll;">
						<td><input type="checkbox" id="tumunu_sec" name="tumunu_sec">SEÇ</td>
						<td><p class="dikey">SIRA</p></td>
						<td><a href="<?=$odeme_href ?>" >ÖDEME TARİHİ</a></td>
						<td>ÖDEYEN</td>
						<td>KOD</td>			
						<td>PLAKA</td>
						<td>MARKA MODEL</td>
						<td>SİGORTA</td>
						<td>ÜYE ADI</td>
						<td>SATIŞ KİMİN ADINA YAPILDI</td>
						<td><a href="<?=$satis_href ?>"> SATIŞ TARİHİ </a></td>
						<td>SATILAN FİYAT</td>
						<td>PD HİZMET BEDELİ</td>
						<td>KAZANILAN PRİM</td>
						<!-- <td>MENÜ</td> -->
					</tr>
				</thead>
				<tbody>
			<?php while($filtre_yaz = mysql_fetch_array($filtre)){ 
				$satilanID = $filtre['id'];
				$ciro = $filtre_yaz['prim'];
				if($filtre_yaz["durum"]==1){
					$style="background:red;color:white;";
					$arka_plan="backgroud:red;";
					$renk="color:white !important;";
				}else{
					$style="";
					$arka_plan="";
					$renk="";
				}
			?>
		<tr style="<?=$style ?>">
			<td><input type="checkbox" id="primlerim_<?=$filtre_yaz["id"] ?>" name="primlerim[]" value="<?=$filtre_yaz["id"] ?>" ></td>	
			<td  style="<?=$style ?>" class="laci"><?= $sira++ ?></td>
			<?php
				if($filtre_yaz['odeme_tarihi']!="0000-00-00"){?>
					<td><?=  date("d-m-Y",strtotime($filtre_yaz['odeme_tarihi'])) ?></td>
				<?php }else{ ?>
					<td> </td>
				<?php }
				$prim_first = $filtre_yaz["pd_hizmet"] * $admin_prim;
				$prim = $prim_first / 100;

				if($filtre_yaz['tarih'] == "0000-00-00"){
					$tarih = "";
				}else{
					$tarih = date("d-m-Y", strtotime($filtre_yaz['tarih']));
				}
			?>
			<td><?= $filtre_yaz['parayi_gonderen']?></td>
			<td id="td_view_ilan_notlari_<?=$filtre_yaz["ilan_id"]?>"><a style="<?=$renk ?>" class="view_ilan_notlari" id="<?=$filtre_yaz["ilan_id"]?>"><?= $filtre_yaz['kod']?></a></td>
			<td><a style="<?=$renk ?>" href="?modul=ilanlar&sayfa=ilan_ekle&id=<?= $filtre_yaz['ilan_id'] ?>" target="_blank"><?= $filtre_yaz['plaka']?></a></td>
			<td><a style="<?=$renk ?>" href="../arac_detay.php?id=<?= $filtre_yaz['ilan_id'] ?>&q=ihale" target="_blank"><?= $filtre_yaz['marka_model']?></a></td>
			<td><?= $filtre_yaz['sigorta'] ?></td>
			<td id="td_view_notlari_<?=$filtre_yaz["uye_id"]?>"><a id="<?=$filtre_yaz["uye_id"]?>" class="view_notlari"><?=$filtre_yaz['araci_alan']?></a></td>
			<td><?= $filtre_yaz['satis_adi']?></td>
			<td><?= $tarih ?></td>
			<td><?= money($filtre_yaz['satilan_fiyat']) ?> ₺</td>
			<td><?= money($filtre_yaz['pd_hizmet']) ?> ₺</td>
			<td><?= money($prim) ?> ₺</td>
			<!-- <td><a style="<?=$renk ?>" href="?modul=muhasebe&sayfa=satilan_duzenle&id=<?= $satilanID ?>" target="_blank">Düzenle</a><br>
				<a style="<?=$renk ?>" href="?modul=ayarlar&sayfa=data_sil&id=<?= $satilanID ?>&q=satilan_sil"  onclick="return confirm('Silmek istediğinize emin misiniz ?')">Sil</a><br>
				<?php
					if($filtre_yaz['durum']==0){?>
							<a href="#myModal<?= $filtre_yaz['id'] ?>" data-toggle="modal">İade Et</a>
					<?php }else{?>
							<span style="<?=$renk ?>" >İade Edildi</span>
					<?php }
				?>
			</td> -->
			<!-- Modal -->
			<div id="myModal<?= $filtre_yaz['id'] ?>" class="custom-large-modal modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
		</tbody>
			</table>
		<?php }else if(re("aranan")!=""){
			$_POST["tarih1"]="";
			$_POST["tarih2"]="";
			$_POST["ay"]="";
			$_POST["yil"]="";
			if(re("listeleme")==""){
			   $order_by="order by odeme_tarihi desc";
			}else if(re("listeleme")=="odeme_tarihi_desc"){
			   $order_by="order by odeme_tarihi desc";
			}else if(re("listeleme")=="odeme_tarihi_asc"){
				$order_by="order by odeme_tarihi asc";
			}else if(re("listeleme")=="tarih_desc"){
			   $order_by="order by tarih desc";
			}else if(re("listeleme")=="tarih_asc"){
				$order_by="order by tarih asc";			  
			}else {
				$order_by="order by odeme_tarihi desc";
			}
			$aranan = re('aranan');
			$filtre = mysql_query("SELECT satilan_araclar.* FROM satilan_araclar INNER JOIN user ON user.id=satilan_araclar.uye_id INNER JOIN prm_notlari ON prm_notlari.uye_id = satilan_araclar.uye_id
			WHERE user.temsilci_id='".$admin_id."' AND satilan_araclar.prim > 0 AND prm_notlari.durum = 1 AND
			concat(plaka,' ',kod,' ',marka_model,' ',sigorta,' ',satis_adi,' ',maliyet,' ',pd_hizmet,' ',ektra_kazanc,' ',notlar,' ',parayi_gonderen,' ',araci_alan,' ',satilan_fiyat,' ',aciklayici_not,' ',ciro)  like '%".$aranan."%'
			$order_by");
			$filtre_prim_cek = mysql_query("SELECT satilan_araclar.* FROM satilan_araclar INNER JOIN user ON user.id=satilan_araclar.uye_id INNER JOIN prm_notlari ON prm_notlari.uye_id = satilan_araclar.uye_id
			WHERE user.temsilci_id='".$admin_id."' AND satilan_araclar.prim > 0 AND prm_notlari.durum = 1 AND
			concat(plaka,' ',kod,' ',marka_model,' ',sigorta,' ',satis_adi,' ',maliyet,' ',pd_hizmet,' ',ektra_kazanc,' ',notlar,' ',parayi_gonderen,' ',araci_alan,' ',satilan_fiyat,' ',aciklayici_not,' ',ciro)  like '%".$aranan."%'
			$order_by");
			$filterCount = mysql_num_rows($filtre);
			$ayYil = mysql_query("SELECT SUM(satilan_araclar.prim) as prim FROM satilan_araclar INNER JOIN user ON user.id=satilan_araclar.uye_id  INNER JOIN prm_notlari ON prm_notlari.uye_id = satilan_araclar.uye_id
			WHERE user.temsilci_id='".$admin_id."' AND satilan_araclar.prim > 0 AND prm_notlari.durum = 1
			concat(plaka,' ',kod,' ',marka_model,' ',sigorta,' ',satis_adi,' ',maliyet,' ',pd_hizmet,' ',ektra_kazanc,' ',notlar,' ',parayi_gonderen,' ',araci_alan,' ',satilan_fiyat,' ',aciklayici_not,' ',ciro)  like '%".$aranan."%' AND
			satilan_araclar.durum=0 $order_by ");
			$AyYilToplam = mysql_fetch_assoc($ayYil); 
			$AyYilCiro = $AyYilToplam['prim']; 

			$toplam_prim = 0;
			while($filtre_oku_prim = mysql_fetch_array($filtre_prim_cek)){
				if($filtre_oku_prim["durum"]!=1){
					$prim_first = $filtre_oku_prim["pd_hizmet"] * $admin_prim;
					$toplam_prim += $prim_first / 100;
				}
			}
			?>
			<div class="row-fluid">
				<div class="span6"><h4>TOPLAM PRİM <?= money($toplam_prim) ?>₺</h4></div>
				<div class="span6"><a href="<?=$excel_listeleme ?>" style="background:#fcd5b4; float:right;" class="input-mini btn" >Excel</a></div>
			</div>			
			<table class="table table-bordered" id="primlerim_table">
				<thead>
				<tr class="sari" style="overflow:hidden;overflow-y: scroll;">
					<td><input type="checkbox" id="tumunu_sec" name="tumunu_sec">SEÇ</td>
					<td>
						<p class="dikey">SIRA</p>
					</td>
					<td><a href="<?=$odeme_href ?>" >ÖDEME TARİHİ</a></td>
					<td>ÖDEYEN</td>
					<td>KOD</td>			
					<td>PLAKA</td>
					<td>MARKA MODEL</td>
					<td>SİGORTA</td>
					<td>ÜYE ADI</td>
					<td>SATIŞ KİMİN ADINA YAPILDI</td>
					<td><a href="<?=$satis_href ?>"> SATIŞ TARİHİ </a></td>
					<td>SATILAN FİYAT</td>
					<td>PD HİZMET BEDELİ</td>
					<td>KAZANILAN PRİM</td>
					<!-- <td>MENÜ</td> -->
				</tr>
				</thead>
				<tbody>
				<?php
				
				while($filtre_yaz = mysql_fetch_array($filtre)){ 
					$satilanID = $filtre['id'];
					$ciro = $filtre_yaz['prim'];
					if($filtre_yaz["durum"]==1){
						$style="background:red;color:white;";
						$arka_plan="backgroud:red;";
						$renk="color:white !important;";
					}else{
						$style="";
						$arka_plan="";
						$renk="";
					}
				?>
			<tr style="<?=$style ?>">
				<td><input type="checkbox" id="primlerim_<?=$filtre_yaz["id"] ?>" name="primlerim[]" value="<?=$filtre_yaz["id"] ?>" ></td>	
				<td style="<?=$style ?>" class="laci"><?= $sira++ ?></td>
				<?php
					if($filtre_yaz['odeme_tarihi']!="0000-00-00"){?>
						<td><?=  date("d-m-Y",strtotime($filtre_yaz['odeme_tarihi'])) ?></td>
					<?php }else{ ?>
						<td> </td>
					<?php }
					$prim_first = $filtre_yaz["pd_hizmet"] * $admin_prim;
					$prim = $prim_first / 100;
					if($filtre_yaz['tarih'] == "0000-00-00"){
						$tarih = "";
					}else{
						$tarih = date("d-m-Y", strtotime($filtre_yaz['tarih']));
					}
				?>
				<td><?= $filtre_yaz['parayi_gonderen']?></td>
				<td id="td_view_ilan_notlari_<?=$filtre_yaz["ilan_id"]?>"><a style="<?=$renk ?>" class="view_ilan_notlari" id="<?=$filtre_yaz["ilan_id"]?>"><?= $filtre_yaz['kod']?></a></td>
				<td><a style="<?=$renk ?>" href="?modul=ilanlar&sayfa=ilan_ekle&id=<?= $filtre_yaz['ilan_id'] ?>" target="_blank"><?= $filtre_yaz['plaka']?></a></td>
				<td><a style="<?=$renk ?>" href="../arac_detay.php?id=<?= $filtre_yaz['ilan_id'] ?>&q=ihale" target="_blank"><?= $filtre_yaz['marka_model']?></a></td>
				<td><?= $filtre_yaz['sigorta'] ?></td>
				<td id="td_view_notlari_<?=$filtre_yaz["uye_id"]?>"><a id="<?=$filtre_yaz["uye_id"]?>" class="view_notlari"><?=$filtre_yaz['araci_alan']?></a></td>
				<td><?= $filtre_yaz['satis_adi']?></td>
				<td><?= $tarih ?></td>
				<td><?= money($filtre_yaz['satilan_fiyat']) ?> ₺</td>
				<td><?= money($filtre_yaz['pd_hizmet']) ?> ₺</td>
				<td><?= money($prim) ?> ₺</td>
				<!-- <td><a style="<?=$renk ?>" href="?modul=muhasebe&sayfa=satilan_duzenle&id=<?= $satilanID ?>" target="_blank">Düzenle</a><br>
					<a style="<?=$renk ?>" href="?modul=ayarlar&sayfa=data_sil&id=<?= $satilanID ?>&q=satilan_sil"  onclick="return confirm('Silmek istediğinize emin misiniz ?')">Sil</a><br>
					<?php
						if($filtre_yaz['durum']==0){?>
								<a href="#myModal<?= $filtre_yaz['id'] ?>" data-toggle="modal">İade Et</a>
						<?php }else{?>
								<span style="<?=$renk ?>" >İade Edildi</span>
						<?php }
					?>
				</td> -->
				<!-- Modal -->
				<div id="myModal<?= $filtre_yaz['id'] ?>" class="custom-large-modal modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
			</tbody>
		</table>
			<?php
		}else{ 
			$toplam_prim = 0;
			while($satilan_oku_prim = mysql_fetch_array($satilan_cek_prim)){
				if($satilan_oku_prim["durum"]!=1){
					$prim_first = $satilan_oku_prim["pd_hizmet"] * $admin_prim;
					$toplam_prim += $prim_first / 100;
				}
			}
		?>
		<div class="row-fluid">
			<div class="span6"><h4>TOPLAM PRİM <?= money($toplam_prim) ?>₺</h4></div>
			<div class="span6"><a href="<?=$excel_listeleme ?>" style="background:#fcd5b4; float:right;" class="input-mini btn" >Excel</a></div>
		</div>		
	<table class="table table-bordered" id="primlerim_table">
		<thead>
			<tr class="sari" style="overflow:hidden;overflow-y: scroll;">
				<td><input type="checkbox" id="tumunu_sec" name="tumunu_sec">SEÇ</td>
				<td><p class="dikey">SIRA</p></td>
				<td><a href="<?=$odeme_href ?>">ÖDEME TARİHİ</a></td>
				<td>ÖDEYEN</td>
				<td>KOD</td>			
				<td>PLAKA</td>
				<td>MARKA MODEL</td>
				<td>SİGORTA</td>
				<td>ÜYE ADI</td>
				<td>SATIŞ KİMİN ADINA YAPILDI</td>
				<td><a href="<?=$satis_href ?>"> SATIŞ TARİHİ </a></td>
				<td>SATILAN FİYAT</td>
				<td>PD HİZMET BEDELİ</td>
				<td>KAZANILAN PRİM</td>
				<!-- <td>MENÜ</td> -->
			</tr>
		</thead>
		<tbody>
		<?php 
		while($satilan_oku = mysql_fetch_array($satilan_cek)){ 
			$satilanID = $satilan_oku['id'];
			$ciro = $satilan_oku['prim'];
			if($satilan_oku["durum"]==1){
				$style="background:red;color:white;";
				$arka_plan="backgroud:red;";
				$renk="color:white !important;";
			}else{
				$style="";
				$arka_plan="";
				$renk="";
			}
        ?>
		<tr style="<?=$style ?>">
			<td><input type="checkbox" id="primlerim_<?=$satilan_oku["id"] ?>" name="primlerim[]" value="<?=$satilan_oku["id"] ?>" ></td>	
			<td style="<?=$style ?>" class="laci"><?= $sira++ ?></td>
			<?php
				if($satilan_oku['odeme_tarihi']!="0000-00-00"){?>
					<td><?=  date("d-m-Y",strtotime($satilan_oku['odeme_tarihi'])) ?></td>
				<?php }else{ ?>
					<td></td>
				<?php }
				$prim_first = $satilan_oku["pd_hizmet"] * $admin_prim;
				$prim = $prim_first / 100;
				if($satilan_oku['tarih'] == "0000-00-00"){
					$tarih = "";
				}else{
					$tarih = date("d-m-Y", strtotime($satilan_oku['tarih']));
				}
			?>
			<td><?= $satilan_oku['parayi_gonderen']?></td>
			<td id="td_view_ilan_notlari_<?=$satilan_oku["ilan_id"]?>"><a style="<?=$renk ?>" class="view_ilan_notlari" id="<?=$satilan_oku["ilan_id"]?>"><?= $satilan_oku['kod']?></a></td>
			<td><a style="<?=$renk ?>" href="?modul=ilanlar&sayfa=ilan_ekle&id=<?= $satilan_oku['ilan_id'] ?>" target="_blank"><?= $satilan_oku['plaka']?></a></td>
			<td><a style="<?=$renk ?>" href="../arac_detay.php?id=<?= $satilan_oku['ilan_id'] ?>&q=ihale" target="_blank"><?= $satilan_oku['marka_model']?></a></td>
			<td><?= $satilan_oku['sigorta'] ?></td>
			<td id="td_view_notlari_<?=$satilan_oku["uye_id"]?>"><a id="<?=$satilan_oku["uye_id"]?>" class="view_notlari"><?=$satilan_oku['araci_alan']?></a></td>
			<td><?= $satilan_oku['satis_adi']?></td>
			<td><?= $tarih ?></td>
			<td><?= money($satilan_oku['satilan_fiyat'])?> ₺</td>
			<td><?= money($satilan_oku['pd_hizmet']) ?> ₺ </td>
			<td><?= money($prim) ?> ₺</td>
			<!-- <td>
				<a style="<?=$renk ?>" href="?modul=muhasebe&sayfa=satilan_duzenle&id=<?= $satilanID ?>" target="_blank">Düzenle</a><br>
				<a style="<?=$renk ?>" href="?modul=ayarlar&sayfa=data_sil&id=<?= $satilanID ?>&q=satilan_sil"  onclick="return confirm('Silmek istediğinize emin misiniz ?')">Sil</a><br>
				<?php
					if($satilan_oku['durum']==0){?>
							<a href="#myModal<?= $satilan_oku['id'] ?>" data-toggle="modal">İade Et</a>
					<?php }else{?>
							<span style="<?=$renk ?>" >İade Edildi</span>
					<?php }
				?>
			</td> -->
			<!-- Modal -->
			<div id="myModal<?= $satilan_oku['id'] ?>" class="custom-large-modal modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				<form method="POST">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
						<h3 id="myModalLabel">İade Etme</h3>
					</div>
					<div class="modal-body">
						<div class="row-fluid">
							<textarea id="iade_aciklama"  rows="3" name="iade_aciklama" class="span12"></textarea>
						</div>
					</div>
					<div class="modal-footer">
						<button class="btn" data-dismiss="modal" aria-hidden="true">Kapat</button>
						<button type="button" class="btn blue" onclick="guncelle(<?= $satilan_oku['id'] ?>)" name="iadeyi">Kaydet</button>
					</div>
				</form>
			</div>
		</tr>
	<?php } }  ?>
		</tbody>
	</table>
</div>


<!-- İlan Notları Başlangıç-->
<div class="custom-large-modal modal fade" id="ilan_notlari">
	<div class="modal-dialog">
		<button type="button" id="ilanin_notlari_close" class="close" style="margin:2%" data-dismiss="modal" aria-hidden="true"></button>
		<div class="modal-body" id="ilanin_notlarini">
		</div>
	</div>
</div>
<!-- İlan Notları Bitiş-->

<!-- Üye Notları Modal Başlangıç-->
<div class="modal fade custom-large-modal" id="notlari" >
	<button type="button" class="close" id="uyenin_notlari_close" style="margin-right: 2%; margin-top:2%;" data-dismiss="modal" aria-hidden="true"></button>
	<div class="modal-dialog">
		<div class="modal-body" id="uyenin_notlari">
		</div>
	</div>
</div>
<!-- Üye Notları Modal Bitiş-->




<script>
   function guncelle(sayi){
		jQuery.ajax({
			url: "https://ihale.pertdunyasi.com/check.php",
			type: "POST",
			dataType: "JSON",
			data: {
				action: "satilan_guncelle",
				satilan_id:sayi,
				iade_aciklama:$('#iade_aciklama').val(),
			},
			success: function(data) {
			console.log(data);
				alert("İşlem başarılı");  
				location.reload();
			}
		});
	} 
</script>