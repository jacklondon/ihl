<!-- 
ADMİNİN YAPTIĞI İŞLER (VERİTABANINDA)
1 ==> İLAN EKLEME
2 ==> İLANA NOT EKLEME
3 ==> ÜYEYE NOT EKLEME
4 ==> PRM NOT EKLEME
-->
<style>
	.kirk{
		width:40%;
	}
	.baskili{
		font-weight: bold;
		background-color: #cecece;
	}
</style>
<style>
	.yapilan_isler
	{
		border-color: transparent;
		border-top:1px solid #000;
		border-bottom:1px solid #000;
		border-right:1px solid #000;
	}

	.yapilan_isler thead tr td{
		border-color: #000000;
	}
	
	.yapilan_isler thead tr th{
		border-color: #000000;
	}
	
	.yapilan_isler tbody tr td{
		border-color: #000000;
	}
	
	.yapilan_isler tbody tr th{
		border-color: #000000;
	}
</style>

<?php
	$yönetici_id=$_SESSION['kid'];
	$admin_yetki_cek=mysql_query("Select * from kullanicilar where id='".$yönetici_id."' ");
	$admin_yetki_oku=mysql_fetch_assoc($admin_yetki_cek);
	$yetkiler=$admin_yetki_oku["yetki"];
	$yetki_parcala=explode("|",$yetkiler);

	$veri_girisler = array();
	$veri_giris_cek = mysql_query("select * from kullanicilar where departman = 'Veri Giriş Sorumlusu'");
	while($veri_giris_oku = mysql_fetch_object($veri_giris_cek)){
		array_push($veri_girisler, $veri_giris_oku->id);
	}
	$string = implode(",", $veri_girisler);
	$array=array_map('intval', explode(',', $string));
	$array = implode("','",$array);

	$year = date('Y');
	$bugun = date('Y-m-d 23:59:59');
	$bugun_bas = date('Y-m-d 00:00:00');
	$gunluk_cek = mysql_query("SELECT COUNT(*) as total,admin_id FROM yapilan_is WHERE ekleme_zamani BETWEEN '".$bugun_bas."' AND '".$bugun."' and admin_id NOT IN ('".$array."') GROUP BY admin_id ORDER BY total DESC LIMIT 1");
	$gunluk_oku = mysql_fetch_assoc($gunluk_cek);
	$admin_bul = mysql_query("SELECT * FROM kullanicilar WHERE id = '".$gunluk_oku['admin_id']."'");
	$admin_yaz = mysql_fetch_assoc($admin_bul);
	$admin_adi = $admin_yaz['adi']." ".$admin_yaz['soyadi'];
	$month = date('m');

	

	$buay = mysql_query("SELECT COUNT(*) as aylik,admin_id FROM yapilan_is WHERE MONTH(ekleme_zamani) = '".$month."' and admin_id NOT IN ('".$array."') GROUP BY admin_id ORDER BY aylik DESC LIMIT 1"); 
	$buay_oku = mysql_fetch_assoc($buay);
	$aylik_admin_cek = mysql_query("SELECT * FROM kullanicilar WHERE id = '".$buay_oku['admin_id']."'");
	$aylik_admin = mysql_fetch_assoc($aylik_admin_cek);
	$aylik_admin_bilgi = $aylik_admin['adi']." ".$aylik_admin['soyadi'];
	
	$performans_orani_cek=mysql_query("select performans_kazanci_orani from kullanicilar where id=1");
	$performans_orani_oku=mysql_fetch_array($performans_orani_cek);
	$performans_orani=$performans_orani_oku["performans_kazanci_orani"] / 100;
	$performans_hesap=intval($buay_oku['aylik']) * $performans_orani;

	$aylik_ciro_cek = mysql_query("SELECT SUM(ciro) AS ciro,SUM(prim) as prim FROM satilan_araclar where month(odeme_tarihi) = '".$month."' and durum=0"); 
	$aylik_ciro_oku = mysql_fetch_assoc($aylik_ciro_cek); 
	$aylik_ciro = $aylik_ciro_oku['ciro'];
	$performans_hesap_ilk=$aylik_ciro * $performans_orani_oku["performans_kazanci_orani"];
	$performans_hesap = $performans_hesap_ilk / 100;
	
?>
<div class="row-fluid" style="margin-top: 2%;">
	<div class="span3" >
		<text style="font-size:15px;">GÜNLÜK EN İYİ PERFORMANS:</text>
	</div>
	<div style="font-size:16px;" class="span9" >
		<text><?=$admin_adi ?></text>
		<text style="margin-left:5%"><?=$gunluk_oku['total'] ?></text>
	</div>
</div>
<div class="row-fluid">
	<div class="span3" >
		<text style="font-size:15px;">AYLIK EN İYİ PERFORMANS:</text>
	</div>
	<div style="font-size:16px;" class="span9" >
		<text><?=$aylik_admin_bilgi ?></text>
		<text style="margin-left:5%"><?=$buay_oku['aylik'] ?></text>
	</div>
</div>
<div class="row-fluid">
	<div class="span3" >
		<text style="font-size:15px;">AYLIK EN İYİ PERFORMANS İKRAMİYESİ:</text>
	</div>
	<div style="font-size:16px;" class="span9" >
		<b><?=$performans_hesap." ₺" ?></b>
	</div>
</div>
<?php 
	if (in_array(11, $yetki_parcala)  ) { 
?>
<form method="POST">
	<div class="row-fluid" style="margin-top: 2%;">
		<div class="span1"></div>
		<div style="font-size:16px;" class="span7" >
			<div class="row-fluid">
				<div class="span3">
					<center style="font-size:12px;margin-top:5px;">ŞU TARİHLER ARASI</center>
				</div>
				<div class="span3">
					<input type="date" style="width:100%;" value="<?=re("ilk_tarih") ?>" name="ilk_tarih" id="ilk_tarih" class="input-mini">
				</div>
				<div class="span3">
					<input type="date" style="width:100%;" value="<?=re("ikinci_tarih") ?>" name="ikinci_tarih" id="ikinci_tarih" class="input-mini" />
				</div>
				<div class="span3">
					<input type="submit" name="tarihler_arasini" style="margin-bottom:10px;height:30px;" class="input-mini btn blue" value="Filtrele">
				</div>
			</div>
		</div>
		<div class="span3"></div>
	</div>
	<div class="row-fluid">
		<div class="span1"></div>
		<div style="font-size:16px;" class="span7">
			<div class="row-fluid">
				<div class="span3">
					<center style="font-size:12px;margin-top:5px;">AY YIL SEÇ</center>
				</div>
				<div class="span3">
					<select name="ay" id="ay" class="input-mini" style="width: 100%;"> 
						<option <?php if(re('ay')==""){ echo "selected"; } ?> value="">SEÇİNİZ</option>
						<option <?php if(re('ay')=="01"){ echo "selected"; } ?> value="01">Ocak</option>
						<option <?php if(re('ay')=="02"){ echo "selected"; } ?> value="02">Şubat</option>
						<option <?php if(re('ay')=="03"){ echo "selected"; } ?> value="03">Mart</option>
						<option <?php if(re('ay')=="04"){ echo "selected"; } ?> value="04">Nisan</option>
						<option <?php if(re('ay')=="05"){ echo "selected"; } ?> value="05" >Mayıs</option>
						<option <?php if(re('ay')=="06"){ echo "selected"; } ?> value="06">Haziran</option>
						<option <?php if(re('ay')=="07"){ echo "selected"; } ?> value="07">Temmuz</option>
						<option <?php if(re('ay')=="08"){ echo "selected"; } ?> value="08">Ağustos</option>
						<option <?php if(re('ay')=="09"){ echo "selected"; } ?> value="09">Eylül</option>
						<option <?php if(re('ay')=="10"){ echo "selected"; } ?> value="10">Ekim</option>
						<option <?php if(re('ay')=="11"){ echo "selected"; } ?> value="11">Kasım</option>
						<option <?php if(re('ay')=="12"){ echo "selected"; } ?> value="12">Aralık</option>
					</select>
				</div>
				<div class="span3">
					<select name="yil" id="yil" style="width: 100%;"> 
						<option value="">SEÇİNİZ</option>
						<?php for($i=$year;$i>=2010;$i--){ ?>	
						<option <?php if( re('yil')==$i ){ echo "selected"; } ?> value="<?= $i ?>"><?= $i ?></option>
						<?php } ?>
					</select>
				</div>
				<div class="span3">
					<input type="submit" name="secili_tarihi" style="margin-bottom:10px;height:30px;" class="input-mini btn blue" value="Filtrele">
				</div>
			</div>
		</div>
		<div class="span3"></div>
	</div>
</form>
	<?php } ?>
<?php 
if(re('tarihler_arasini')=="Filtrele"){ ?>
<?php 
	$_POST["ay"]="";
	$_POST["yil"]="";
	$sira = 1;
	$is_cek = mysql_query("SELECT * FROM yapilan_is WHERE ekleme_zamani BETWEEN '".re('ilk_tarih')." 00:00:00"."' AND '".re('ikinci_tarih')." 23:59:59"."' order by ekleme_zamani desc ");
	// var_dump("SELECT * FROM yapilan_is WHERE ekleme_zamani BETWEEN '".re('ilk_tarih')." 00:00:00"."' AND '".re('ikinci_tarih')." 23:59:59"."' order by ekleme_zamani desc ");
	$filtresiz_cek = mysql_query("SELECT * FROM yapilan_is WHERE ekleme_zamani >= '".re('ilk_tarih')." 00:00:00"."' AND ekleme_zamani <= '".re('ikinci_tarih')." 23:59:59"."' GROUP BY admin_id  order by ekleme_zamani desc");
	$filter_text=date("d-m-Y",strtotime(re('ilk_tarih')))."/".date("d-m-Y",strtotime(re('ikinci_tarih')))." tarihlerinin kayitlari listeleniyor";
	$is_sayi = mysql_num_rows($is_cek);
	$ilan_ekle_say = 0;
	$ilan_not_say = 0;
	$uye_not_say = 0;
	$prm_not_say = 0;
?>
<div class="row-fluid">
	<div class="span1"></div>
	<div class="span8">
		<table class="yapilan_isler table table-bordered">
			<thead>
				<tr style="background-color : #cecece">
					<td>YAPILAN İŞ</td>
					<td>İLAN EKLEDİ</td>
					<td>İLANA NOT EKLEDİ</td>
					<td>ÜYEYE NOT EKLEDİ</td>
					<td>PRM NOT EKLEDİ</td>
					<td>TOPLAMLAR</td>
				</tr>
			</thead>
			<tbody>
			<?php 
			if (in_array(11, $yetki_parcala)) {  
				while($filtresiz_oku = mysql_fetch_array($filtresiz_cek)){ 
					$admin_adi_cek = mysql_query("SELECT * FROM kullanicilar WHERE id = '".$filtresiz_oku['admin_id']."'");
					$admin_adi_oku = mysql_fetch_assoc($admin_adi_cek);
					$admin_adi_yaz = $admin_adi_oku['adi']." ".$admin_adi_oku['soyadi'];
					$admin_ilan_ekle = mysql_query("SELECT * FROM yapilan_is WHERE admin_id = '".$filtresiz_oku['admin_id']."' AND yaptigi = 1 AND ekleme_zamani BETWEEN '".re('ilk_tarih')." 00:00:00"."' AND '".re('ikinci_tarih')." 23:59:59"."' order by ekleme_zamani desc ");
					$admin_ilan_say = mysql_num_rows($admin_ilan_ekle);
					$ilan_ekle_say += $admin_ilan_say;

					$admin_ilan_not= mysql_query("SELECT * FROM yapilan_is WHERE admin_id = '".$filtresiz_oku['admin_id']."' AND yaptigi = 2 AND ekleme_zamani BETWEEN '".re('ilk_tarih')." 00:00:00"."' AND '".re('ikinci_tarih')." 23:59:59"."' order by ekleme_zamani desc "); 
					$admin_ilan_not_say = mysql_num_rows($admin_ilan_not);
					$ilan_not_say += $admin_ilan_not_say;

					$admin_uye_not= mysql_query("SELECT * FROM yapilan_is WHERE admin_id = '".$filtresiz_oku['admin_id']."' AND yaptigi = 3 AND  ekleme_zamani BETWEEN '".re('ilk_tarih')." 00:00:00"."' AND '".re('ikinci_tarih')." 23:59:59"."' order by ekleme_zamani desc "); 
					$admin_uye_not_say = mysql_num_rows($admin_uye_not);
					$uye_not_say += $admin_uye_not_say;

					$admin_prm_not= mysql_query("SELECT * FROM yapilan_is WHERE admin_id = '".$filtresiz_oku['admin_id']."' AND yaptigi = 4 AND  ekleme_zamani BETWEEN '".re('ilk_tarih')." 00:00:00"."' AND '".re('ikinci_tarih')." 23:59:59"."' order by ekleme_zamani desc "); 
					$admin_prm_not_say = mysql_num_rows($admin_prm_not);
					$prm_not_say += $admin_prm_not_say;

					$admin_not= mysql_query("SELECT * FROM yapilan_is WHERE admin_id = '".$filtresiz_oku['admin_id']."' AND  ekleme_zamani BETWEEN '".re('ilk_tarih')." 00:00:00"."' AND '".re('ikinci_tarih')." 23:59:59"."' order by ekleme_zamani desc "); 
					$admin_not_say = mysql_num_rows($admin_not);
				?>
					<tr>
						<td><?= $admin_adi_yaz ?></td>
						<td><?= $admin_ilan_say ?></td>
						<td><?= $admin_ilan_not_say ?></td>
						<td><?= $admin_uye_not_say ?></td>
						<td><?= $admin_prm_not_say ?></td>
						<th style="font-size:20px;background-color : #cecece;"><?=$admin_not_say ?></th>
					</tr>
			<?php } } ?>
				<?php 
					$toplam_ilan = mysql_query("SELECT * FROM yapilan_is WHERE yaptigi = 1 AND ekleme_zamani BETWEEN '".re('ilk_tarih')." 00:00:00"."' AND '".re('ikinci_tarih')." 23:59:59"."' order by ekleme_zamani desc ");
					$toplam_ilan_say = mysql_num_rows($toplam_ilan);
					$toplam_ilan_not = mysql_query("SELECT * FROM yapilan_is WHERE yaptigi = 2 AND ekleme_zamani BETWEEN '".re('ilk_tarih')." 00:00:00"."' AND '".re('ikinci_tarih')." 23:59:59"."' order by ekleme_zamani desc ");
					$toplam_ilan_not_say = mysql_num_rows($toplam_ilan_not);
					$toplam_uye_not = mysql_query("SELECT * FROM yapilan_is WHERE yaptigi = 3 AND ekleme_zamani BETWEEN '".re('ilk_tarih')." 00:00:00"."' AND '".re('ikinci_tarih')." 23:59:59"."' order by ekleme_zamani desc ");
					$toplam_uye_not_say = mysql_num_rows($toplam_uye_not);
					$toplam_prm_not = mysql_query("SELECT * FROM yapilan_is WHERE yaptigi = 4 AND ekleme_zamani BETWEEN '".re('ilk_tarih')." 00:00:00"."' AND '".re('ikinci_tarih')." 23:59:59"."' order by ekleme_zamani desc ");
					$toplam_prm_not_say = mysql_num_rows($toplam_prm_not);
					$toplam_not = mysql_query("SELECT * FROM yapilan_is WHERE ekleme_zamani BETWEEN '".re('ilk_tarih')." 00:00:00"."' AND '".re('ikinci_tarih')." 23:59:59"."' order by ekleme_zamani desc ");
					$toplam_not_say = mysql_num_rows($toplam_not);
				?>
				<tr style="background-color : #cecece">
					<td>TOPLAMLAR</td>
					<th style="font-size:20px;"><?= $ilan_ekle_say ?></th>
					<th style="font-size:20px;"><?= $ilan_not_say ?></th>
					<th style="font-size:20px;"><?= $uye_not_say ?></th>
					<th style="font-size:20px;"><?= $prm_not_say ?></th>
					<th style="font-size:20px;color:red"><?=$toplam_not_say ?></th>
				</tr>			  
			</tbody>
		</table>
	</div>
	
</div>

<div class="row-fluid">
	<div class="span1">
	</div>
	<div class="span3">
		<h4>GÖSTERİLEN KAYIT  : <?= $is_sayi ?></h4>
	</div>
	<div class="span5">
		<h5><?=$filter_text ?></h5>
	</div>
	<?php	if (in_array(11, $yetki_parcala)){  ?>
		<div class="span3">
			<a href="https://ihale.pertdunyasi.com/excel.php?q=performans_tarihler_arasini&ilk_tarih=<?=re('ilk_tarih') ?>&ikinci_tarih=<?=re('ikinci_tarih') ?>"><h5 style="font-weight:bold">EXCEL</h5></a>
		</div>
	<?php } ?>
</div>

<table class="table no-table-bordered">
    <thead>
        <tr  class="baskili">
            <td>Sıra</td>
            <td>Yapılan İş</td>
            <td class="kirk">Açıklamalar</td>
            <td>Ekleyen</td>
            <td>Ekleme Zamanı</td>
        </tr>
    </thead>
    <tbody>
        <?php while($is_oku = mysql_fetch_array($is_cek)){ 
            $yapilan_is = $is_oku['yaptigi'];
            $admin_id = $is_oku['admin_id'];
            $aracin_id = $is_oku['ilan_id'];
            $admin_cek = mysql_query("SELECT * FROM kullanicilar WHERE id = '".$admin_id."'");
            $admin_oku = mysql_fetch_assoc($admin_cek);
            $admin_ad = $admin_oku['adi']." ".$admin_oku['soyadi'];
            if($yapilan_is == 1){
                $ilan_cek = mysql_query("SELECT * FROM ilanlar WHERE id='".$is_oku['ilan_id']."'");
                $ilan_oku = mysql_fetch_assoc($ilan_cek);
                $ilan_no = $ilan_oku['arac_kodu'];
                $yapilan_is = "İlan Ekle"." / ".$ilan_oku['arac_kodu'];
				$aciklama=$is_oku['aciklama'];
            }elseif($yapilan_is == 2){     
                $ilan_cek = mysql_query("SELECT * FROM ilanlar WHERE id='".$is_oku['ilan_id']."'");
                $ilan_oku = mysql_fetch_assoc($ilan_cek);           
                $yapilan_is = "İlan Notu"." / ".$ilan_oku['arac_kodu'];
				if($is_oku['gizlilik']==0){
					if($yönetici_id==$is_oku["admin_id"]){
						$aciklama=$is_oku['aciklama'];
					}else{
						$aciklama="Sadece ekleyen admin görebilir";
					}
				}elseif($is_oku['gizlilik']==1){
					if (count($yetki_parcala)==13) { 
						$aciklama=$is_oku['aciklama'];
					}else{
						$aciklama="Sadece tam yetkili adminler görebilir";
					}
				}elseif($is_oku['gizlilik']==2){
					$aciklama=$is_oku['aciklama'];
				}else{
					$aciklama="Sadece ekleyen admin görebilir";
				}
            }elseif($yapilan_is == 3){     
                $uye_bul = mysql_query("SELECT * FROM user WHERE id = '".$is_oku['uye_id']."'");
                $uye_yaz = mysql_fetch_assoc($uye_bul);
                $uye_ad = $uye_yaz['ad'];
                $yapilan_is = "Üye Notu"." / ".$uye_ad;
				/*$aciklama=$is_oku['aciklama'];*/
				if($is_oku['gizlilik']==0){
					if($yönetici_id==$is_oku["admin_id"]){
						$aciklama=$is_oku['aciklama'];
					}else{
						$aciklama="Sadece ekleyen admin görebilir";
					}
				}elseif($is_oku['gizlilik']==1){
					if (count($yetki_parcala)==13) { 
						$aciklama=$is_oku['aciklama'];
					}else{
						$aciklama="Sadece tam yetkili adminler görebilir";
					}
				}elseif($is_oku['gizlilik']==2){
					$aciklama=$is_oku['aciklama'];
				}else{
					$aciklama="Sadece ekleyen admin görebilir";
				}
            }elseif($yapilan_is == 4){     
                $uye_bul = mysql_query("SELECT * FROM user WHERE id = '".$is_oku['uye_id']."'");
                $uye_yaz = mysql_fetch_assoc($uye_bul);
				if($uye_yaz["user_token"] != ""){
					$uye_ad = $uye_yaz['ad'];
				}else{
					$uye_ad = $uye_yaz['unvan'];
				}
                // $uye_ad = $uye_yaz['ad'];
                $yapilan_is = "PRM Notu"." / ".$uye_ad;
				/*$aciklama=$is_oku['aciklama'];*/
				if($is_oku['gizlilik']==0){
					if($yönetici_id==$is_oku["admin_id"]){
						$aciklama=$is_oku['aciklama'];
					}else{
						$aciklama="Sadece ekleyen admin görebilir";
					}
				}elseif($is_oku['gizlilik']==1){
					if (count($yetki_parcala)==13) { 
						$aciklama=$is_oku['aciklama'];
					}else{
						$aciklama="Sadece tam yetkili adminler görebilir";
					}
				}elseif($is_oku['gizlilik']==2){
					$aciklama=$is_oku['aciklama'];
				}else{
					$aciklama="Sadece ekleyen admin görebilir";
				}
            }
        ?>
        <tr>
            <td><?= $sira++ ?></td>
            <td><?= $yapilan_is ?></td>
            <td class="kirk"><?= $aciklama ?></td>
            <td><?= $admin_ad ?></td>
            
            <td><?= date("d-m-Y H:i:s", strtotime($is_oku['ekleme_zamani']))  ?></td>
        </tr>
        <?php } ?>
    </tbody>
</table>
<?php } elseif(re('secili_tarihi')=="Filtrele"){ ?>
<?php 
	$_POST["ilk_tarih"]="";
	$_POST["ikinci_tarih"]="";
	$gelen_ay = re('ay');
	$gelen_yil = re('yil');	
	$sira = 1;
	$is_cek = mysql_query("SELECT * FROM yapilan_is WHERE MONTH(ekleme_zamani) = '$gelen_ay' AND YEAR(ekleme_zamani)= '$gelen_yil' order by ekleme_zamani desc ");
	$filtresiz_cek = mysql_query("SELECT * FROM yapilan_is WHERE MONTH(ekleme_zamani) = '$gelen_ay' AND YEAR(ekleme_zamani)= '$gelen_yil' GROUP BY admin_id order by ekleme_zamani desc");
	$filter_text=$gelen_ay."/".$gelen_yil." tarihlerinin kayitlari listeleniyor";
	$is_sayi = mysql_num_rows($is_cek);
	$ilan_ekle_say = 0;
	$ilan_not_say = 0;
	$uye_not_say = 0;
	$prm_not_say = 0;
?>
<div class="row-fluid">
	<div class="span1">
	</div>
	<div class="span8">
		<table class="yapilan_isler table table-bordered">
			<thead>
				<tr style="background-color : #cecece">
					<td>YAPILAN İŞ</td>
					<td>İLAN EKLEDİ</td>
					<td>İLANA NOT EKLEDİ</td>
					<td>ÜYEYE NOT EKLEDİ</td>
					<td>PRM NOT EKLEDİ</td>
					<td>TOPLAMLAR</td>
				</tr>
			</thead>
			<tbody>
			<?php 
			if (in_array(11, $yetki_parcala)  ) {  
				while($filtresiz_oku = mysql_fetch_array($filtresiz_cek)){ 
					$admin_adi_cek = mysql_query("SELECT * FROM kullanicilar WHERE id = '".$filtresiz_oku['admin_id']."'");
					$admin_adi_oku = mysql_fetch_assoc($admin_adi_cek);
					$admin_adi_yaz = $admin_adi_oku['adi']." ".$admin_adi_oku['soyadi'];
					$admin_ilan_ekle = mysql_query("SELECT * FROM yapilan_is WHERE admin_id = '".$filtresiz_oku['admin_id']."' AND yaptigi = 1 AND MONTH(ekleme_zamani) = '$gelen_ay' AND YEAR(ekleme_zamani)= '$gelen_yil' order by ekleme_zamani desc ");
					$admin_ilan_say = mysql_num_rows($admin_ilan_ekle);
					$ilan_ekle_say += $admin_ilan_say;

					$admin_ilan_not= mysql_query("SELECT * FROM yapilan_is WHERE admin_id = '".$filtresiz_oku['admin_id']."' AND yaptigi = 2 AND MONTH(ekleme_zamani) = '$gelen_ay' AND YEAR(ekleme_zamani)= '$gelen_yil' order by ekleme_zamani desc "); 
					$admin_ilan_not_say = mysql_num_rows($admin_ilan_not);
					$ilan_not_say += $admin_ilan_not_say;

					$admin_uye_not= mysql_query("SELECT * FROM yapilan_is WHERE admin_id = '".$filtresiz_oku['admin_id']."' AND yaptigi = 3 AND MONTH(ekleme_zamani) = '$gelen_ay' AND YEAR(ekleme_zamani)= '$gelen_yil' order by ekleme_zamani desc "); 
					$admin_uye_not_say = mysql_num_rows($admin_uye_not);
					$uye_not_say += $admin_uye_not_say;

					$admin_prm_not= mysql_query("SELECT * FROM yapilan_is WHERE admin_id = '".$filtresiz_oku['admin_id']."' AND yaptigi = 4 AND MONTH(ekleme_zamani) = '$gelen_ay' AND YEAR(ekleme_zamani)= '$gelen_yil' order by ekleme_zamani desc "); 
					$admin_prm_not_say = mysql_num_rows($admin_prm_not);
					$prm_not_say += $admin_prm_not_say;

					$admin_not= mysql_query("SELECT * FROM yapilan_is WHERE admin_id = '".$filtresiz_oku['admin_id']."' AND MONTH(ekleme_zamani) = '$gelen_ay' AND YEAR(ekleme_zamani)= '$gelen_yil' order by ekleme_zamani desc "); 
					$admin_not_say = mysql_num_rows($admin_not);
				?>
					<tr>
						<td><?= $admin_adi_yaz ?></td>
						<td><?= $admin_ilan_say ?></td>
						<td><?= $admin_ilan_not_say ?></td>
						<td><?= $admin_uye_not_say ?></td>
						<td><?= $admin_prm_not_say ?></td>
						<th style="font-size:20px;background-color : #cecece;"><?=$admin_not_say ?></th>
					</tr>
			<?php } }?>
				<?php 
					$toplam_ilan = mysql_query("SELECT * FROM yapilan_is WHERE yaptigi = 1 AND  MONTH(ekleme_zamani) = '$gelen_ay' AND YEAR(ekleme_zamani)= '$gelen_yil' order by ekleme_zamani desc ");
					$toplam_ilan_say = mysql_num_rows($toplam_ilan);
					$toplam_ilan_not = mysql_query("SELECT * FROM yapilan_is WHERE yaptigi = 2 AND  MONTH(ekleme_zamani) = '$gelen_ay' AND YEAR(ekleme_zamani)= '$gelen_yil' order by ekleme_zamani desc ");
					$toplam_ilan_not_say = mysql_num_rows($toplam_ilan_not);
					$toplam_uye_not = mysql_query("SELECT * FROM yapilan_is WHERE yaptigi = 3 AND  MONTH(ekleme_zamani) = '$gelen_ay' AND YEAR(ekleme_zamani)= '$gelen_yil' order by ekleme_zamani desc ");
					$toplam_uye_not_say = mysql_num_rows($toplam_uye_not);
					$toplam_prm_not = mysql_query("SELECT * FROM yapilan_is WHERE yaptigi = 4 AND  MONTH(ekleme_zamani) = '$gelen_ay' AND YEAR(ekleme_zamani)= '$gelen_yil' order by ekleme_zamani desc ");
					$toplam_prm_not_say = mysql_num_rows($toplam_prm_not);
					$toplam_not = mysql_query("SELECT * FROM yapilan_is WHERE MONTH(ekleme_zamani) = '$gelen_ay' AND YEAR(ekleme_zamani)= '$gelen_yil' order by ekleme_zamani desc ");
					$toplam_not_say = mysql_num_rows($toplam_not);
				?>
				<tr style="background-color : #cecece">
					<td>TOPLAMLAR</td>
					<th style="font-size:20px;"><?= $ilan_ekle_say ?></th>
					<th style="font-size:20px;"><?= $ilan_not_say ?></th>
					<th style="font-size:20px;"><?= $uye_not_say ?></th>
					<th style="font-size:20px;"><?= $prm_not_say ?></th>
					<th style="font-size:20px;color:red"><?=$toplam_not_say ?></th>
				</tr>
			</tbody>
		</table>
	</div>
</div>

<div class="row-fluid">
	<div class="span1">
	</div>
	<div class="span3">
		<h4>GÖSTERİLEN KAYIT  : <?= $is_sayi ?></h4>
	</div>
	<div class="span5">
		<h5><?=$filter_text ?></h5>
	</div>
	<?php 	if (in_array(11, $yetki_parcala)  ) {  ?>
		<div class="span3">
			<a href="https://ihale.pertdunyasi.com/excel.php?q=performans_secili_tarihi&ay=<?=re('ay') ?>&yil=<?=re('yil') ?>"><h5 style="font-weight:bold">EXCEL</h5></a>
		</div>
	<?php } ?>
</div>

<table class="table no-table-bordered">
    <thead>
        <tr  class="baskili">
            <td>Sıra</td>
            <td>Yapılan İş</td>
            <td class="kirk">Açıklamalar</td>
            <td>Ekleyen</td>
            <td>Ekleme Zamanı</td>
        </tr>
    </thead>
    <tbody>
        <?php while($is_oku = mysql_fetch_array($is_cek)){ 
            $yapilan_is = $is_oku['yaptigi'];
            $admin_id = $is_oku['admin_id'];
            $aracin_id = $is_oku['ilan_id'];
            $admin_cek = mysql_query("SELECT * FROM kullanicilar WHERE id = '".$admin_id."'");
            $admin_oku = mysql_fetch_assoc($admin_cek);
            $admin_ad = $admin_oku['adi']." ".$admin_oku['soyadi'];
            if($yapilan_is == 1){
                $ilan_cek = mysql_query("SELECT * FROM ilanlar WHERE id='".$is_oku['ilan_id']."'");
                $ilan_oku = mysql_fetch_assoc($ilan_cek);
                $ilan_no = $ilan_oku['arac_kodu'];
                $yapilan_is = "İlan Ekle"." / ".$ilan_oku['arac_kodu'];
				$aciklama=$is_oku['aciklama'];
            }elseif($yapilan_is == 2){     
                $ilan_cek = mysql_query("SELECT * FROM ilanlar WHERE id='".$is_oku['ilan_id']."'");
                $ilan_oku = mysql_fetch_assoc($ilan_cek);           
                $yapilan_is = "İlan Notu"." / ".$ilan_oku['arac_kodu'];
				if($is_oku['gizlilik']==0){
					if($yönetici_id==$is_oku["admin_id"]){
						$aciklama=$is_oku['aciklama'];
					}else{
						$aciklama="Sadece ekleyen admin görebilir";
					}
				}elseif($is_oku['gizlilik']==1){
					if (count($yetki_parcala)==13) { 
						$aciklama=$is_oku['aciklama'];
					}else{
						$aciklama="Sadece tam yetkili adminler görebilir";
					}
				}elseif($is_oku['gizlilik']==2){
					$aciklama=$is_oku['aciklama'];
				}else{
					$aciklama="Sadece ekleyen admin görebilir";
				}
            }elseif($yapilan_is == 3){     
                $uye_bul = mysql_query("SELECT * FROM user WHERE id = '".$is_oku['uye_id']."'");
                $uye_yaz = mysql_fetch_assoc($uye_bul);
				if($uye_yaz["user_token"] != ""){
					$uye_ad = $uye_yaz['ad'];
				}else{
					$uye_ad = $uye_yaz['unvan'];
				}
                // $uye_ad = $uye_yaz['ad'];
                $yapilan_is = "Üye Notu"." / ".$uye_ad;
				/*$aciklama=$is_oku['aciklama'];*/
				if($is_oku['gizlilik']==0){
					if($yönetici_id==$is_oku["admin_id"]){
						$aciklama=$is_oku['aciklama'];
					}else{
						$aciklama="Sadece ekleyen admin görebilir";
					}
				}elseif($is_oku['gizlilik']==1){
					if (count($yetki_parcala)==13) { 
						$aciklama=$is_oku['aciklama'];
					}else{
						$aciklama="Sadece tam yetkili adminler görebilir";
					}
				}elseif($is_oku['gizlilik']==2){
					$aciklama=$is_oku['aciklama'];
				}else{
					$aciklama="Sadece ekleyen admin görebilir";
				}
            }elseif($yapilan_is == 4){     
                $uye_bul = mysql_query("SELECT * FROM user WHERE id = '".$is_oku['uye_id']."'");
                $uye_yaz = mysql_fetch_assoc($uye_bul);
				if($uye_yaz["user_token"] != ""){
					$uye_ad = $uye_yaz['ad'];
				}else{
					$uye_ad = $uye_yaz['unvan'];
				}
                // $uye_ad = $uye_yaz['ad'];
                $yapilan_is = "PRM Notu"." / ".$uye_ad;
				/*$aciklama=$is_oku['aciklama'];*/
				if($is_oku['gizlilik']==0){
					if($yönetici_id==$is_oku["admin_id"]){
						$aciklama=$is_oku['aciklama'];
					}else{
						$aciklama="Sadece ekleyen admin görebilir";
					}
				}elseif($is_oku['gizlilik']==1){
					if (count($yetki_parcala)==13) { 
						$aciklama=$is_oku['aciklama'];
					}else{
						$aciklama="Sadece tam yetkili adminler görebilir";
					}
				}elseif($is_oku['gizlilik']==2){
					$aciklama=$is_oku['aciklama'];
				}else{
					$aciklama="Sadece ekleyen admin görebilir";
				}
            }
        ?>
        <tr>
            <td><?= $sira++ ?></td>
            <td><?= $yapilan_is ?></td>
            <td class="kirk"><?= $aciklama ?></td>
            <td><?= $admin_ad ?></td>
            
            <td><?= date("d-m-Y H:i:s", strtotime($is_oku['ekleme_zamani']))  ?></td>
        </tr>
        <?php } ?>
    </tbody>
</table>

<?php }else{ ?>

<?php
$bugun = date('Y-m-d 23:59:59');
$bugun_bas = date('Y-m-d 00:00:00');
$is_cek = mysql_query("SELECT * FROM yapilan_is WHERE ekleme_zamani BETWEEN '".$bugun_bas."' AND '".$bugun."' order by ekleme_zamani desc ");

$sira = 1;
$filtresiz_cek = mysql_query("SELECT * FROM yapilan_is WHERE ekleme_zamani > '".$bugun_bas."' AND ekleme_zamani < '".$bugun."'  GROUP BY admin_id order by ekleme_zamani desc");
$filter_text=date('d-m-Y H:i:s',strtotime($bugun))."/".date('d-m-Y H:i:s',strtotime($bugun_bas))." tarihleri arası kayitları listeleniyor";
$is_sayi = mysql_num_rows($is_cek);
$ilan_ekle_say = 0;
$ilan_not_say = 0;
$uye_not_say = 0;
$prm_not_say = 0;
?>

<div class="row-fluid">
	<div class="span1">
	</div>
	<div class="span8">
		<table class="yapilan_isler table table-bordered">
			<thead>
				<tr style="background-color : #cecece">
					<td>YAPILAN İŞ</td>
					<td>İLAN EKLEDİ</td>
					<td>İLANA NOT EKLEDİ</td>
					<td>ÜYEYE NOT EKLEDİ</td>
					<td>PRM NOT EKLEDİ</td>
					<td>TOPLAMLAR</td>
				</tr>
			</thead>
			<tbody>
			<?php 
			if (in_array(11, $yetki_parcala)  ) {  
				while($filtresiz_oku = mysql_fetch_array($filtresiz_cek)){ 
					$admin_adi_cek = mysql_query("SELECT * FROM kullanicilar WHERE id = '".$filtresiz_oku['admin_id']."'");
					$admin_adi_oku = mysql_fetch_assoc($admin_adi_cek);
					$admin_adi_yaz = $admin_adi_oku['adi']." ".$admin_adi_oku['soyadi'];
					$admin_ilan_ekle = mysql_query("SELECT * FROM yapilan_is WHERE admin_id = '".$filtresiz_oku['admin_id']."' AND yaptigi = 1 AND ekleme_zamani BETWEEN '".$bugun_bas."' AND '".$bugun."' order by ekleme_zamani desc ");
					$admin_ilan_say = mysql_num_rows($admin_ilan_ekle);
					$ilan_ekle_say += $admin_ilan_say;

					$admin_ilan_not= mysql_query("SELECT * FROM yapilan_is WHERE admin_id = '".$filtresiz_oku['admin_id']."' AND yaptigi = 2 AND ekleme_zamani BETWEEN '".$bugun_bas."' AND '".$bugun."' order by ekleme_zamani desc "); 
					$admin_ilan_not_say = mysql_num_rows($admin_ilan_not);
					$ilan_not_say += $admin_ilan_not_say;

					$admin_uye_not= mysql_query("SELECT * FROM yapilan_is WHERE admin_id = '".$filtresiz_oku['admin_id']."' AND yaptigi = 3 AND ekleme_zamani BETWEEN '".$bugun_bas."' AND '".$bugun."' order by ekleme_zamani desc "); 
					$admin_uye_not_say = mysql_num_rows($admin_uye_not);
					$uye_not_say += $admin_uye_not_say;

					$admin_prm_not= mysql_query("SELECT * FROM yapilan_is WHERE admin_id = '".$filtresiz_oku['admin_id']."' AND yaptigi = 4 AND ekleme_zamani BETWEEN '".$bugun_bas."' AND '".$bugun."' order by ekleme_zamani desc "); 
					$admin_prm_not_say = mysql_num_rows($admin_prm_not);
					$prm_not_say += $admin_prm_not_say;

					$admin_not= mysql_query("SELECT * FROM yapilan_is WHERE admin_id = '".$filtresiz_oku['admin_id']."' AND ekleme_zamani BETWEEN '".$bugun_bas."' AND '".$bugun."' order by ekleme_zamani desc "); 
					$admin_not_say = mysql_num_rows($admin_not);
				?>
					<tr>
						<td><?= $admin_adi_yaz ?></td>
						<td><?= $admin_ilan_say ?></td>
						<td><?= $admin_ilan_not_say ?></td>
						<td><?= $admin_uye_not_say ?></td>
						<td><?= $admin_prm_not_say ?></td>
						<th style="font-size:20px;background-color : #cecece;"><?=$admin_not_say ?></th>
					</tr>
			<?php } }?>
				<?php 
					$toplam_ilan = mysql_query("SELECT * FROM yapilan_is WHERE yaptigi = 1 AND ekleme_zamani BETWEEN '".$bugun_bas."' AND '".$bugun."' order by ekleme_zamani desc ");
					$toplam_ilan_say = mysql_num_rows($toplam_ilan);
					$toplam_ilan_not = mysql_query("SELECT * FROM yapilan_is WHERE yaptigi = 2 AND ekleme_zamani BETWEEN '".$bugun_bas."' AND '".$bugun."' order by ekleme_zamani desc ");
					$toplam_ilan_not_say = mysql_num_rows($toplam_ilan_not);
					$toplam_uye_not = mysql_query("SELECT * FROM yapilan_is WHERE yaptigi = 3 AND ekleme_zamani BETWEEN '".$bugun_bas."' AND '".$bugun."' order by ekleme_zamani desc ");
					$toplam_uye_not_say = mysql_num_rows($toplam_uye_not);
					$toplam_prm_not = mysql_query("SELECT * FROM yapilan_is WHERE yaptigi = 4 AND ekleme_zamani BETWEEN '".$bugun_bas."' AND '".$bugun."' order by ekleme_zamani desc ");
					$toplam_prm_not_say = mysql_num_rows($toplam_prm_not);
					$toplam_not = mysql_query("SELECT * FROM yapilan_is WHERE ekleme_zamani BETWEEN '".$bugun_bas."' AND '".$bugun."' order by ekleme_zamani desc ");
					$toplam_not_say = mysql_num_rows($toplam_not);
				?>
				<tr style="background-color : #cecece">
					<td>TOPLAMLAR</td>
					<th style="font-size:20px;"><?= $ilan_ekle_say ?></th>
					<th style="font-size:20px;"><?= $ilan_not_say ?></th>
					<th style="font-size:20px;"><?= $uye_not_say ?></th>
					<th style="font-size:20px;"><?= $prm_not_say ?></th>
					<th style="font-size:20px;color:red"><?=$toplam_not_say ?></th>
				</tr>
			</tbody>
		</table>
	</div>
</div>

<div class="row-fluid">
	<div class="span1">
	</div>
	<div class="span3">
		<h4>GÖSTERİLEN KAYIT  : <?= $is_sayi ?></h4>
	</div>
	<div class="span5">
		<h5><?=$filter_text ?></h5>
	</div>
	<?php 	if (in_array(11, $yetki_parcala)  ) {  ?>
		<div class="span3">
			<a href="https://ihale.pertdunyasi.com/excel.php?q=performans_tarihler_arasini&ilk_tarih=<?=$bugun_bas ?>&ikinci_tarih=<?=$bugun ?>"><h5 style="font-weight:bold">EXCEL</h5></a>
		</div>
	<?php } ?>
</div>
<table class="table no-table-bordered">
    <thead>
        <tr  class="baskili">
            <td>Sıra</td>
            <td>Yapılan İş</td>
            <td class="kirk">Açıklamalar</td>
            <td>Ekleyen</td>
            <td>Ekleme Zamanı</td>
        </tr>
    </thead>
    <tbody>
        <?php while($is_oku = mysql_fetch_array($is_cek)){ 
            $yapilan_is = $is_oku['yaptigi'];
            $admin_id = $is_oku['admin_id'];
            $aracin_id = $is_oku['ilan_id'];
            $admin_cek = mysql_query("SELECT * FROM kullanicilar WHERE id = '".$admin_id."'");
            $admin_oku = mysql_fetch_assoc($admin_cek);
            $admin_ad = $admin_oku['adi']." ".$admin_oku['soyadi'];
            if($yapilan_is == 1){
                $ilan_cek = mysql_query("SELECT * FROM ilanlar WHERE id='".$is_oku['ilan_id']."'");
                $ilan_oku = mysql_fetch_assoc($ilan_cek);
                $ilan_no = $ilan_oku['arac_kodu'];
                $yapilan_is = "İlan Ekle"." / ".$ilan_oku['arac_kodu'];
				$aciklama=$is_oku['aciklama'];
            }elseif($yapilan_is == 2){     
                $ilan_cek = mysql_query("SELECT * FROM ilanlar WHERE id='".$is_oku['ilan_id']."'");
                $ilan_oku = mysql_fetch_assoc($ilan_cek);           
                $yapilan_is = "İlan Notu"." / ".$ilan_oku['arac_kodu'];
				if($is_oku['gizlilik']==0){
					if($yönetici_id==$is_oku["admin_id"]){
						$aciklama=$is_oku['aciklama'];
					}else{
						$aciklama="Sadece ekleyen admin görebilir";
					}
				}elseif($is_oku['gizlilik']==1){
					if (count($yetki_parcala)==13) { 
						$aciklama=$is_oku['aciklama'];
					}else{
						$aciklama="Sadece tam yetkili adminler görebilir";
					}
				}elseif($is_oku['gizlilik']==2){
					$aciklama=$is_oku['aciklama'];
				}else{
					$aciklama="Sadece ekleyen admin görebilir";
				}
            }elseif($yapilan_is == 3){     
                $uye_bul = mysql_query("SELECT * FROM user WHERE id = '".$is_oku['uye_id']."'");
                $uye_yaz = mysql_fetch_assoc($uye_bul);
                $uye_ad = $uye_yaz['ad'];
                $yapilan_is = "Üye Notu"." / ".$uye_ad;
				/*$aciklama=$is_oku['aciklama'];*/
				if($is_oku['gizlilik']==0){
					if($yönetici_id==$is_oku["admin_id"]){
						$aciklama=$is_oku['aciklama'];
					}else{
						$aciklama="Sadece ekleyen admin görebilir";
					}
				}elseif($is_oku['gizlilik']==1){
					if (count($yetki_parcala)==13) { 
						$aciklama=$is_oku['aciklama'];
					}else{
						$aciklama="Sadece tam yetkili adminler görebilir";
					}
				}elseif($is_oku['gizlilik']==2){
					$aciklama=$is_oku['aciklama'];
				}else{
					$aciklama="Sadece ekleyen admin görebilir";
				}
            }elseif($yapilan_is == 4){     
                $uye_bul = mysql_query("SELECT * FROM user WHERE id = '".$is_oku['uye_id']."'");
                $uye_yaz = mysql_fetch_assoc($uye_bul);
				if($uye_yaz["user_token"] != ""){
					$uye_ad = $uye_yaz['ad'];
				}else{
					$uye_ad = $uye_yaz['unvan'];
				}
               
                $yapilan_is = "PRM Notu"." / ".$uye_ad;
				/*$aciklama=$is_oku['aciklama'];*/
				if($is_oku['gizlilik']==0){
					if($yönetici_id==$is_oku["admin_id"]){
						$aciklama=$is_oku['aciklama'];
					}else{
						$aciklama="Sadece ekleyen admin görebilir";
					}
				}elseif($is_oku['gizlilik']==1){
					if (count($yetki_parcala)==13) { 
						$aciklama=$is_oku['aciklama'];
					}else{
						$aciklama="Sadece tam yetkili adminler görebilir";
					}
				}elseif($is_oku['gizlilik']==2){
						$aciklama=$is_oku['aciklama'];
				}else{
					$aciklama="Sadece ekleyen admin görebilir";
				}
            }
        ?>
        <tr>
            <td><?= $sira++ ?></td>
            <td><?= $yapilan_is ?></td>
            <td class="kirk"><?= $aciklama ?></td>
            <td><?= $admin_ad ?></td>
            
            <td><?= date("d-m-Y H:i:s", strtotime($is_oku['ekleme_zamani']))  ?></td>
        </tr>
        <?php } ?>
    </tbody>
</table>
<?php } ?>

