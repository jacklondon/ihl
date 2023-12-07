<?php 
session_start();
$admin_id=$_SESSION['kid'];
$admin_yetki_cek=mysql_query("Select * from kullanicilar where id='".$admin_id."' ");
$admin_yetki_oku=mysql_fetch_assoc($admin_yetki_cek);

$yetkiler=$admin_yetki_oku["yetki"];

$yetki_parcala=explode("|",$yetkiler);
/*if (!in_array(6, $yetki_parcala)  ) { 
  echo '<script>alert("Bu Sayfaya Giriş Yetkiniz Yoktur")</script>';
  echo "<script>window.location.href = 'index.php'</script>";
} */   



/*$result = mysql_query('SELECT SUM(cayma_bedelleri.iade_tutari) AS tutar FROM cayma_bedelleri inner join user on user.id=cayma_bedelleri.uye_id WHERE cayma_bedelleri.durum=4 order by cayma_bedelleri.iade_tarihi DESC'); 
$row = mysql_fetch_assoc($result); 
$sum = $row['tutar'];

$iadeleri_cek = mysql_query("SELECT cayma_bedelleri.* FROM cayma_bedelleri inner join user on user.id=cayma_bedelleri.uye_id WHERE cayma_bedelleri.durum=4 order by cayma_bedelleri.iade_tarihi desc");*/
$sira = 1;

?>


<div class="row-fluid">

	<div style="margin-top:50px;" class="tabbable">  
		<style>
			.active .actived_href{
				background:green !important;
				color:#fff !important ;
			}
			.disactive a{
				background:#cecece; 
				color:#000;
			}
			.baskili{
				font-weight: bold;
				background-color: #cecece;
			}
		</style>
		<ul class="nav nav-tabs">
			<?php 
				if (in_array(12, $yetki_parcala)  ) { 
					$active_tutar="active";
					$active_iade_talepleri="";
				?>
				<li onclick="updateTrigger('aktif_tab')" class="disactive <?=$active_tutar ?>"><a class="actived_href" id="aktif_tab" href="#aktif" data-toggle="tab">AKTİF</a></li>
			<?php }else{
					$active_tutar="";
					$active_iade_talepleri="active";
				?>
			<?php } ?>
			<li onclick="updateTrigger('iade_talepleri_tab')"  class="disactive <?=$active_iade_talepleri?>" ><a class="actived_href" id="iade_talepleri_tab" href="#iade_talepleri" data-toggle="tab">İADE TALEPLERİ</a></li>
			<li onclick="updateTrigger('iade_edilenler_tab')" class="disactive"><a class="actived_href" id="iade_edilenler_tab"  href="#iade_edilenler" data-toggle="tab">İADE EDİLENLER</a></li>
			<li onclick="updateTrigger('mahsup_edilenler_tab')" class="disactive"><a class="actived_href" id="mahsup_edilenler_tab" href="#mahsup_edilenler" data-toggle="tab">ARAÇ BEDELİNE MAHSUP EDİLENLER</a></li>
			<li onclick="updateTrigger('cayilan_araclar_tab')" class="disactive"><a class="actived_href" id="cayilan_araclar_tab" href="#cayilan_araclar" data-toggle="tab">CAYILAN ARAÇLAR</a></li>
			<li onclick="updateTrigger('bloke_bekleyen_borclar_tab')" class="disactive"><a class="actived_href" id="bloke_bekleyen_borclar_tab" href="#bloke_bekleyen_borclar" data-toggle="tab">BLOKE İÇİN BEKLEYEN BORÇLAR</a></li>
			<li onclick="updateTrigger('tahsil_edilenler_tab')" class="disactive"><a class="actived_href" id="tahsil_edilenler_tab" href="#tahsil_edilenler" data-toggle="tab">TAHSİL EDİLMİŞ BORÇLAR</a></li>
		</ul>

		<div class="tab-content">
			<div class="tab-pane <?=$active_tutar ?>" id="aktif">
				<?php 
					if (in_array(12, $yetki_parcala)) { 
						$cayma=mysql_query("SELECT cayma_bedelleri.*,user.id as user_id,user.unvan as user_unvan,user.ad as user_ad,user.user_token as user_token,user.kurumsal_user_token as kurumsal_user_token,
						uye_grubu.grup_adi as user_paket FROM cayma_bedelleri INNER JOIN user ON user.id=cayma_bedelleri.uye_id INNER JOIN uye_grubu ON user.paket=uye_grubu.id 
						WHERE durum=1 ORDER BY paranin_geldigi_tarih DESC");
						// var_dump("SELECT cayma_bedelleri.*,user.id as user_id,user.unvan as user_unvan,user.ad as user_ad,user.user_token as user_token,user.kurumsal_user_token as kurumsal_user_token,
						// uye_grubu.grup_adi as user_paket FROM cayma_bedelleri INNER JOIN user ON user.id=cayma_bedelleri.uye_id INNER JOIN uye_grubu ON user.paket=uye_grubu.id 
						// WHERE durum=1 ORDER BY paranin_geldigi_tarih DESC");
						$toplam_cayma=mysql_query("SELECT SUM(cayma_bedelleri.tutar) as toplam FROM cayma_bedelleri INNER JOIN user ON user.id=cayma_bedelleri.uye_id INNER JOIN
						uye_grubu ON user.paket=uye_grubu.id WHERE durum=1");
						$toplam_fetch=mysql_fetch_assoc($toplam_cayma);
						$toplam_aktif=$toplam_fetch["toplam"];
				?>
				<div style="margin-top:25px;" class="row-fluid">
					<div class="span12">
						<text style="margin-left:50px;font-size:16px;">TOPLAM </text><b id="toplam_1" style="font-size:20px"> <?=money($toplam_aktif) ?>₺</b>
					</div>
				</div>
				<div style="margin-top:25px;" class="row-fluid">
					<div class="span12">
						<a target="_blank" href="https://ihale.pertdunyasi.com/excel.php?q=aktif_cayma_excel"><text style="font-size:16px;">Excel </text></a>
					</div>
				</div>
				<table class="table no-table-bordered">
					<thead>
						<tr class="baskili">
							<td>ÜYE ID VE ADI</td>
							<td>ÜYE GRUBU</td>
							<td>PARANIN GELDİĞİ TARİH</td>
							<td>PARAYI GÖNDEREN</td>
							<td>IBAN</td>
							<td>AÇIKLAMALAR</td>
							<td>TUTAR</td>
						</tr>
					</thead>
					<tbody>
						<?php
							while($cayma_fetch=mysql_fetch_array($cayma)){
								if($cayma_fetch["kurumsal_user_token"]!=""){
									$user_ad=$cayma_fetch["user_unvan"];
								}else{
									$user_ad=$cayma_fetch["user_ad"];
								}
						?>
						<tr>
							<td><a target="_blank" href="?modul=uyeler&sayfa=uye_duzenle&id=<?=$cayma_fetch["uye_id"] ?>"><?=$cayma_fetch["uye_id"] ?> - <?=$user_ad ?></a></td>
							<td><?=$cayma_fetch["user_paket"] ?></td>
							<td><?=date("d-m-Y",strtotime($cayma_fetch["paranin_geldigi_tarih"])) ?></td>
							<td><?=$cayma_fetch["hesap_sahibi"] ?></td>
							<td>TR<?=$cayma_fetch["iban"] ?> </td>
							<td><?=$cayma_fetch["aciklama"] ?> </td>
							<td style="font-weight:bold">₺<?=money($cayma_fetch["tutar"]) ?> </td> 
						</tr>
						<?php } ?>
					</tbody>
				</table>
				<?php } ?>
			</div>
			<div class="tab-pane <?=$active_iade_talepleri ?>" id="iade_talepleri">
				<?php 
					$cayma=mysql_query("
						SELECT
							cayma_bedelleri.*,
							user.id as user_id,
							user.ad as user_ad,
							user.unvan as user_unvan,
							user.user_token as user_token,
							user.kurumsal_user_token as kurumsal_user_token,
							uye_grubu.grup_adi as user_paket
						FROM
							cayma_bedelleri
						INNER JOIN
							user
						ON
							user.id=cayma_bedelleri.uye_id
						INNER JOIN
							uye_grubu
						ON
							user.paket=uye_grubu.id
						WHERE
							durum=2
						ORDER BY
							iade_talep_tarihi desc
					");
					$toplam_cayma=mysql_query("
						SELECT
							SUM(cayma_bedelleri.tutar) as toplam
						FROM
							cayma_bedelleri
						INNER JOIN
							user
						ON
							user.id=cayma_bedelleri.uye_id
						INNER JOIN
							uye_grubu
						ON
							user.paket=uye_grubu.id
						WHERE
							durum=2
						
					");
					$toplam_fetch=mysql_fetch_assoc($toplam_cayma);
					$toplam_aktif=$toplam_fetch["toplam"];
				?>
				<div style="margin-top:25px;" class="row-fluid">
					<div class="span12">
						<text style="margin-left:50px;font-size:16px;">TOPLAM </text><b id="toplam_2" style="font-size:20px"><?=money($toplam_aktif) ?>₺</b>
					</div>
				</div>
				<div style="margin-top:25px;" class="row-fluid">
					<div class="span12">
						<a target="_blank" href="https://ihale.pertdunyasi.com/excel.php?q=iade_talepleri_excel"><text style="font-size:16px;">Excel </text></a><br/>
					</div>
				</div>
				<table class="table no-table-bordered">
					<thead>
						<tr class="baskili">
							<td>ÜYE ID VE ADI</td>
							<td>ÜYE GRUBU</td>
							<td>PARANIN GELDİĞİ TARİH</td>
							<td>PARAYI GÖNDEREN</td>
							<td>IBAN</td>
							<td>AÇIKLAMALAR</td>
							<td>TUTAR</td>
							<td>İADE TALEP TARİHİ</td>
						</tr>
					</thead>
					<tbody>
						<?php
							while($cayma_fetch=mysql_fetch_array($cayma)){
								if($cayma_fetch["kurumsal_user_token"]!=""){
									$user_ad=$cayma_fetch["user_unvan"];
								}else{
									$user_ad=$cayma_fetch["user_ad"];
								}
						?>
						<tr>
							<td><a target="_blank" href="?modul=uyeler&sayfa=uye_duzenle&id=<?=$cayma_fetch["user_id"] ?>"><?=$cayma_fetch["user_id"] ?> - <?=$user_ad ?></a></td>
							<td><?=$cayma_fetch["user_paket"] ?></td>
							<td><?=date("d-m-Y",strtotime($cayma_fetch["paranin_geldigi_tarih"])) ?></td>
							<td><?=$cayma_fetch["hesap_sahibi"] ?></td>
							<td>TR<?=$cayma_fetch["iban"] ?> </td>
							<td><?=$cayma_fetch["aciklama"] ?> </td>
							<td style="font-weight:bold">₺<?=money($cayma_fetch["tutar"]) ?> </td> 
							<td><?=date("d-m-Y H:i:s",strtotime($cayma_fetch["iade_talep_tarihi"])) ?></td>
						</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
			<div class="tab-pane" id="iade_edilenler">
				
				<?php
					$year_start = strtotime('first day of January', time());
					$year_start_date=date('Y-m-d', $year_start);
					$year_end = strtotime('last day of December', time());
					$year_end_date=date('Y-m-d', $year_end);
					$cayma=mysql_query("
						SELECT
							cayma_bedelleri.*,
							user.id as user_id,
							user.ad as user_ad,
							user.unvan as user_unvan,
							user.user_token as user_token,
							user.kurumsal_user_token as kurumsal_user_token,
							uye_grubu.grup_adi as user_paket
						FROM
							cayma_bedelleri
						INNER JOIN
							user
						ON
							user.id=cayma_bedelleri.uye_id
						INNER JOIN
							uye_grubu
						ON
							user.paket=uye_grubu.id
						WHERE
							durum=3 AND
                            iade_tarihi BETWEEN '".$year_start_date."' AND '".$year_end_date."' 
						ORDER BY
							iade_tarihi desc
					");
					if(mysql_num_rows($cayma) == 0){
						$iade_edilenler_dipslay = "none";
					}else{
						$iade_edilenler_dipslay = "block";
					}
					$toplam_cayma=mysql_query("
						SELECT
							SUM(cayma_bedelleri.tutar) as toplam
						FROM
							cayma_bedelleri
						INNER JOIN
							user
						ON
							user.id=cayma_bedelleri.uye_id
						INNER JOIN
							uye_grubu
						ON
							user.paket=uye_grubu.id
						WHERE
							durum=3 AND
                            iade_tarihi BETWEEN '".$year_start_date."' AND '".$year_end_date."' 
					");
					$toplam_fetch=mysql_fetch_assoc($toplam_cayma);
					$toplam_aktif=$toplam_fetch["toplam"]; 
				?>
				<form method="POST">
					<div style="width:50%;"class="row-fluid">
						<div class="span2">
							<center style="font-size:12px;margin-top:5px;">AY SEÇ</center>
						</div>
						<div class="span4">
							<select style="width:60%;" name="ay_3" id="ay_3" class="input-mini">
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
						<div class="span2">
							<center style="font-size:12px;margin-top:5px;">YIL SEÇ</center>
						</div>
						<div class="span4">
							<select required style="width:60%;" name="yil_3" id="yil_3" class="input-mini">
								<option <?php if(re("ay")==""){ echo "selected"; } ?> value="">Seçiniz</option>
								<?php for($i=date("Y");$i>=2010;$i--){ ?>	
									<option <?php if(re("yil")==$i ){ echo "selected"; } ?> value="<?= $i ?>"><?= $i ?></option>
								<?php } ?>
							</select>
							<input type="button" onclick="caymaFiltre(3,'iade_tarihi','iade_edilenler_excel')" style="margin-bottom:10px;height:30px;background:yellow;color:black;" name="mahsup_edilenle_secili_tarihi" class="input-mini btn blue" value="Filtrele">
						</div>
					</div>
				</form>
				<div style="margin-top:25px;" class="row-fluid">
					<div class="span12">
						<text style="margin-left:50px;font-size:16px;">TOPLAM </text><b id="toplam_3" style="font-size:20px"><?=money($toplam_aktif) ?>₺</b>
					</div>
				</div>
				<div style="margin-top:25px;" class="row-fluid">
					<div class="span12">
						<a target="_blank" id="excel_3" href="https://ihale.pertdunyasi.com/excel.php?q=iade_edilenler_excel"><text style="font-size:16px;">Excel </text></a><br/>
						<text id="tarih_3" style="font-size:16px;"><?=date("Y") ?> yılı listeleniyor </text>
					</div>
				</div>
				<table class="table no-table-bordered">
					<thead>
						<tr class="baskili">
							<td>ÜYE ID VE ADI</td>
							<td>ÜYE GRUBU</td>
							<td>PARANIN GELDİĞİ TARİH</td>
							<td>İADE EDİLDİĞİ TARİH</td>
							<td>HESAP SAHİBİ</td>
							<td>IBAN</td>
							<td>AÇIKLAMALAR</td>
							<td>TUTAR</td>
						</tr>
					</thead>
					<tbody id="caymalar_3">
						<?php
							while($cayma_fetch=mysql_fetch_array($cayma)){ 
								if($cayma_fetch["kurumsal_user_token"]!=""){
									$user_ad=$cayma_fetch["user_unvan"];
								}else{
									$user_ad=$cayma_fetch["user_ad"];
								}
						?>
						<tr>
							<td><a target="_blank" href="?modul=uyeler&sayfa=uye_duzenle&id=<?=$cayma_fetch["user_id"] ?>"><?=$cayma_fetch["user_id"] ?> - <?=$user_ad ?></a></td>
							<td><?=$cayma_fetch["user_paket"] ?></td>
							<td><?=date("d-m-Y",strtotime($cayma_fetch["paranin_geldigi_tarih"])) ?></td>
							<td><?=date("d-m-Y",strtotime($cayma_fetch["iade_tarihi"])) ?></td>
							<td><?=$cayma_fetch["hesap_sahibi"] ?></td>
							<td>TR<?=$cayma_fetch["iban"] ?> </td>
							<td><?=$cayma_fetch["aciklama"] ?> </td>
							<td style="font-weight:bold">₺<?=money($cayma_fetch["tutar"]) ?> </td> 
						</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
			<div class="tab-pane" id="mahsup_edilenler">
				<?php
					$year_start = strtotime('first day of January', time());
					$year_start_date=date('Y-m-d', $year_start);
					$year_end = strtotime('last day of December', time());
					$year_end_date=date('Y-m-d', $year_end);
					$cayma=mysql_query("
						SELECT
							cayma_bedelleri.*,
							user.id as user_id,
							user.ad as user_ad,
							user.unvan as user_unvan,
							user.user_token as user_token,
							user.kurumsal_user_token as kurumsal_user_token,
							uye_grubu.grup_adi as user_paket
						FROM
							cayma_bedelleri
						INNER JOIN
							user
						ON
							user.id=cayma_bedelleri.uye_id
						INNER JOIN
							uye_grubu
						ON
							user.paket=uye_grubu.id
						WHERE
							durum=4 AND
                            mahsup_tarihi BETWEEN '".$year_start_date."' AND '".$year_end_date."' 
						ORDER BY
							mahsup_tarihi desc
					");
					$toplam_cayma=mysql_query("
						SELECT
							SUM(cayma_bedelleri.tutar) as toplam
						FROM
							cayma_bedelleri
						INNER JOIN
							user
						ON
							user.id=cayma_bedelleri.uye_id
						INNER JOIN
							uye_grubu
						ON
							user.paket=uye_grubu.id
						WHERE
							durum=4 AND
                            mahsup_tarihi BETWEEN '".$year_start_date."' AND '".$year_end_date."' 
					");
					$toplam_fetch=mysql_fetch_assoc($toplam_cayma);
					$toplam_aktif=$toplam_fetch["toplam"]; 
				?>
				<form method="POST">
					<div style="width:50%;"class="row-fluid">
						<div class="span2">
							<center style="font-size:12px;margin-top:5px;">AY SEÇ</center>
						</div>
						<div class="span4">
							<select style="width:60%;" name="ay_4" id="ay_4" class="input-mini">
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
						<div class="span2">
							<center style="font-size:12px;margin-top:5px;">YIL SEÇ</center>
						</div>
						<div class="span4">
							<select required style="width:60%;" name="yil_4" id="yil_4" class="input-mini">
								<option <?php if(re("ay")==""){ echo "selected"; } ?> value="">Seçiniz</option>
								<?php for($i=date("Y");$i>=2010;$i--){ ?>	
									<option <?php if(re("yil")==$i ){ echo "selected"; } ?> value="<?= $i ?>"><?= $i ?></option>
								<?php } ?>
							</select>
							<input type="button" onclick="caymaFiltre(4,'mahsup_tarihi','mahsup_edilenler_excel');" style="margin-bottom:10px;height:30px;background:yellow;color:black;" name="mahsup_edilenle_secili_tarihi" class="input-mini btn blue" value="Filtrele">
						</div>
					</div>
				</form>
				<div style="margin-top:25px;" class="row-fluid">
					<div class="span12">
						<text style="margin-left:50px;font-size:16px;">TOPLAM </text><b id="toplam_4" style="font-size:20px"><?=money($toplam_aktif) ?>₺</b>
					</div>
				</div>
				<div style="margin-top:25px;" class="row-fluid">
					<div class="span12">
						<a target="_blank" id="excel_4" href="https://ihale.pertdunyasi.com/excel.php?q=mahsup_edilenler_excel"><text style="font-size:16px;">Excel </text></a><br/>
						<text id="tarih_4" style="font-size:16px;"><?=date("Y") ?> yılı listeleniyor </text>
					</div>
				</div>
				<table class="table no-table-bordered">
					<thead>
						<tr class="baskili">
							<td>ÜYE ID VE ADI</td>
							<td>ÜYE GRUBU</td>
							<td>PARANIN GELDİĞİ TARİH</td>
							<td>MAHSUP TARİHİ</td>
							<td>KONU ARAÇ</td>
							<td>AÇIKLAMALAR</td>
							<td>TUTAR</td>
						</tr>
					</thead>
					<tbody id="caymalar_4">
						<?php
							while($cayma_fetch=mysql_fetch_array($cayma)){ 
								if($cayma_fetch["kurumsal_user_token"]!=""){
									$user_ad=$cayma_fetch["user_unvan"];
								}else{
									$user_ad=$cayma_fetch["user_ad"];
								}
								$ilan_sql=mysql_query("
									SELECT 
										*
									FROM
										ilanlar 
									WHERE	
										plaka='".$cayma_fetch["arac_kod_plaka"]."' or arac_kodu='".$cayma_fetch["arac_kod_plaka"]."'
								");
								if(mysql_num_rows($ilan_sql)!=0){
									$ilan_fetch=mysql_fetch_assoc($ilan_sql);
									//$href="?modul=ilanlar&sayfa=ilan_ekle&id=".$ilan_fetch["id"];
									if($ilan_fetch["ihale_turu"] == 1){
										$tur = "ihale";
									}elseif($ilan_fetch["ihale_turu"] == 2){
										$tur = "dogrudan";
									}
									$href='../arac_detay.php?id='.$ilan_fetch["id"].'&q='.$tur.'';
								}else{
									$href="";
								}
							?>
						<tr>
							<td><a target="_blank" href="?modul=uyeler&sayfa=uye_duzenle&id=<?=$cayma_fetch["user_id"] ?>"><?=$cayma_fetch["user_id"] ?> - <?=$user_ad ?></a></td>
							<td><?=$cayma_fetch["user_paket"] ?></td>
							<td><?=date("d-m-Y",strtotime($cayma_fetch["paranin_geldigi_tarih"])) ?></td>
							<td><?=date("d-m-Y",strtotime($cayma_fetch["mahsup_tarihi"])) ?></td>
							<td><a href="<?=$href ?>">#<?=$cayma_fetch["arac_kod_plaka"] ?> / <?=$cayma_fetch["arac_detay"] ?></a></td>
							<td><?=$cayma_fetch["aciklama"] ?></td>
							<td style="font-weight:bold">₺<?=money($cayma_fetch["tutar"]) ?></td> 
						</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
			<div class="tab-pane" id="cayilan_araclar">
				<?php
					$year_start = strtotime('first day of January', time());
					$year_start_date=date('Y-m-d', $year_start);
					$year_end = strtotime('last day of December', time());
					$year_end_date=date('Y-m-d', $year_end);
					$cayma=mysql_query("
						SELECT
							cayma_bedelleri.*,
							user.id as user_id,
							user.ad as user_ad,
							user.unvan as user_unvan,
							user.user_token as user_token,
							user.kurumsal_user_token as kurumsal_user_token,
							uye_grubu.grup_adi as user_paket
						FROM
							cayma_bedelleri
						INNER JOIN
							user
						ON
							user.id=cayma_bedelleri.uye_id
						INNER JOIN
							uye_grubu
						ON
							user.paket=uye_grubu.id
						WHERE
							durum=5 AND
                            bloke_tarihi BETWEEN '".$year_start_date."' AND '".$year_end_date."' 
						ORDER BY
							bloke_tarihi desc
					");
					$toplam_cayma=mysql_query("
						SELECT
							SUM(cayma_bedelleri.tutar) as toplam
						FROM
							cayma_bedelleri
						INNER JOIN
							user
						ON
							user.id=cayma_bedelleri.uye_id
						INNER JOIN
							uye_grubu
						ON
							user.paket=uye_grubu.id
						WHERE
							durum=5 AND
                            bloke_tarihi BETWEEN '".$year_start_date."' AND '".$year_end_date."' 
					");
					$toplam_fetch=mysql_fetch_assoc($toplam_cayma);
					$toplam_aktif=$toplam_fetch["toplam"]; 
				?>
				<form method="POST">
					<div style="width:50%;"class="row-fluid">
						<div class="span2">
							<center style="font-size:12px;margin-top:5px;">AY SEÇ</center>
						</div>
						<div class="span4">
							<select style="width:60%;" name="ay_5" id="ay_5" class="input-mini">
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
						<div class="span2">
							<center style="font-size:12px;margin-top:5px;">YIL SEÇ</center>
						</div>
						<div class="span4">
							<select required style="width:60%;" name="yil_5" id="yil_5" class="input-mini">
								<option <?php if(re("ay")==""){ echo "selected"; } ?> value="">Seçiniz</option>
								<?php for($i=date("Y");$i>=2010;$i--){ ?>	
									<option <?php if(re("yil")==$i ){ echo "selected"; } ?> value="<?= $i ?>"><?= $i ?></option>
								<?php } ?>
							</select>
							<input type="button" onclick="caymaFiltre(5,'bloke_tarihi','cayilanlar_excel')" style="margin-bottom:10px;height:30px;background:yellow;color:black;" name="cayilan_araclar_secili_tarihi" class="input-mini btn blue" value="Filtrele">
						</div>
					</div>
				</form>
				<div style="margin-top:25px;" class="row-fluid">
					<div class="span12">
						<text style="margin-left:50px;font-size:16px;">TOPLAM </text><b id="toplam_5" style="font-size:20px"><?=money($toplam_aktif) ?>₺</b>
					</div>
				</div>
				<div style="margin-top:25px;" class="row-fluid">
					<div class="span12">
						<a target="_blank" id="excel_5" href="https://ihale.pertdunyasi.com/excel.php?q=cayilanlar_excel"><text style="font-size:16px;">Excel </text></a><br/>
						<text id="tarih_5" style="font-size:16px;"><?=date("Y") ?> yılı listeleniyor </text>
					</div>
				</div>
				<table class="table no-table-bordered">
					<thead>
						<tr class="baskili">
							<td>ÜYE ID VE ADI</td>
							<td>ÜYE GRUBU</td>
							<td>PARANIN GELDİĞİ TARİH</td>
							<td>BLOKE TARİHİ</td>
							<td>KONU ARAÇ</td>
							<td>AÇIKLAMALAR</td>
							<td>TUTAR</td>
						</tr>
					</thead>
					<tbody id="cayma_durumlari_5">
						<?php
							while($cayma_fetch=mysql_fetch_array($cayma)){ 
								if($cayma_fetch["kurumsal_user_token"]!=""){
									$user_ad=$cayma_fetch["user_unvan"];
								}else{
									$user_ad=$cayma_fetch["user_ad"];
								}
								$ilan_sql=mysql_query("
									SELECT 
										*
									FROM
										ilanlar 
									WHERE	
										plaka='".$cayma_fetch["arac_kod_plaka"]."' or arac_kodu='".$cayma_fetch["arac_kod_plaka"]."'
								");
								if(mysql_num_rows($ilan_sql)!=0){
									$ilan_fetch=mysql_fetch_assoc($ilan_sql);
									// $href="?modul=ilanlar&sayfa=ilan_ekle&id=".$ilan_fetch["id"];
									if($ilan_fetch["ihale_turu"] == 1){
										$tur = "ihale";
									}elseif($ilan_fetch["ihale_turu"] == 2){
										$tur = "dogrudan";
									}
									$href='../arac_detay.php?id='.$ilan_fetch["id"].'&q='.$tur.'';
								}else{
									$href="";
								}
						?>
						<tr>
							<td><a target="_blank" href="?modul=uyeler&sayfa=uye_duzenle&id=<?=$cayma_fetch["user_id"] ?>"><?=$cayma_fetch["user_id"] ?> - <?=$user_ad ?></a></td>
							<td><?=$cayma_fetch["user_paket"] ?></td>
							<td><?=date("d-m-Y",strtotime($cayma_fetch["paranin_geldigi_tarih"])) ?></td>
							<td><?=date("d-m-Y",strtotime($cayma_fetch["bloke_tarihi"])) ?></td>
							<td><a href="<?=$href ?>">#<?=$cayma_fetch["arac_kod_plaka"] ?> / <?=$cayma_fetch["arac_detay"] ?></a></td>
							<td><?=$cayma_fetch["aciklama"] ?> </td>
							<td style="font-weight:bold">₺<?=money($cayma_fetch["tutar"]) ?> </td> 
						</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
			<div class="tab-pane" id="bloke_bekleyen_borclar">
				<?php 
					$cayma=mysql_query("
						SELECT
							cayma_bedelleri.*,
							user.id as user_id,
							user.unvan as user_unvan,
							user.ad as user_ad,
							user.user_token as user_token,
							user.kurumsal_user_token as kurumsal_user_token,
							uye_grubu.grup_adi as user_paket
						FROM
							cayma_bedelleri
						INNER JOIN
							user
						ON
							user.id=cayma_bedelleri.uye_id
						INNER JOIN
							uye_grubu
						ON
							user.paket=uye_grubu.id
						WHERE
							durum=6
						ORDER BY
							bloke_tarihi desc
					");
					$toplam_cayma=mysql_query("
						SELECT
							SUM(cayma_bedelleri.tutar) as toplam
						FROM
							cayma_bedelleri
						INNER JOIN
							user
						ON
							user.id=cayma_bedelleri.uye_id
						INNER JOIN
							uye_grubu
						ON
							user.paket=uye_grubu.id
						WHERE
							durum=6
						
					");
					$toplam_fetch=mysql_fetch_assoc($toplam_cayma);
					$toplam_aktif=$toplam_fetch["toplam"];
				?>
				<div style="margin-top:25px;" class="row-fluid">
					<div class="span12">
						<text style="margin-left:50px;font-size:16px;">TOPLAM </text><b id="toplam_6" style="font-size:20px"> <?=money($toplam_aktif) ?>₺</b>
					</div>
				</div>
				<div style="margin-top:25px;" class="row-fluid">
					<div class="span12">
						<a target="_blank" href="https://ihale.pertdunyasi.com/excel.php?q=bloke_bekleyen_excel"><text style="font-size:16px;">Excel </text></a><br/>
						<text style="font-size:16px;">Tüm yıllar listeleniyor </text>
					</div>
				</div>
				<table class="table no-table-bordered">
					<thead>
						<tr class="baskili">
							<td>ÜYE ID VE ADI</td>
							<td>ÜYE GRUBU</td>
							<td>BORÇ TARİHİ</td>
							<td>KONU ARAÇ</td>
							<td>AÇIKLAMALAR</td>
							<td>TUTAR</td>
						</tr>
					</thead>
					<tbody id="cayma_durumlari_6">
						<?php
							while($cayma_fetch=mysql_fetch_array($cayma)){ 
								if($cayma_fetch["kurumsal_user_token"]!=""){
									$user_ad=$cayma_fetch["user_unvan"];
								}else{
									$user_ad=$cayma_fetch["user_ad"];
								}
								$ilan_sql=mysql_query("
									SELECT 
										*
									FROM
										ilanlar 
									WHERE	
										plaka='".$cayma_fetch["arac_kod_plaka"]."' or arac_kodu='".$cayma_fetch["arac_kod_plaka"]."'
								");
								if(mysql_num_rows($ilan_sql)!=0){
									$ilan_fetch=mysql_fetch_assoc($ilan_sql);
									// $href="?modul=ilanlar&sayfa=ilan_ekle&id=".$ilan_fetch["id"];
									if($ilan_fetch["ihale_turu"] == 1){
										$tur = "ihale";
									}elseif($ilan_fetch["ihale_turu"] == 2){
										$tur = "dogrudan";
									}
									$href='../arac_detay.php?id='.$ilan_fetch["id"].'&q='.$tur.'';
								}else{
									$href="";
								}
							?>
						<tr>
							<td><a target="_blank" href="?modul=uyeler&sayfa=uye_duzenle&id=<?=$cayma_fetch["user_id"] ?>"><?=$cayma_fetch["user_id"] ?> - <?=$user_ad ?></a></td>
							<td><?=$cayma_fetch["user_paket"] ?></td>
							<td><?=date("d-m-Y",strtotime($cayma_fetch["bloke_tarihi"])) ?></td>
							<td><a href="<?=$href ?>">#<?=$cayma_fetch["arac_kod_plaka"] ?> / <?=$cayma_fetch["arac_detay"] ?></a></td>
							<td><?=$cayma_fetch["aciklama"] ?></td>
							<td style="font-weight:bold">₺<?=money($cayma_fetch["tutar"]) ?></td> 
						</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
			<div class="tab-pane" id="tahsil_edilenler">
				<?php 
					$cayma=mysql_query("
						SELECT
							cayma_bedelleri.*,
							user.id as user_id,
							user.ad as user_ad,
							user.unvan as user_unvan,
							user.user_token as user_token,
							user.kurumsal_user_token as kurumsal_user_token,
							uye_grubu.grup_adi as user_paket
						FROM
							cayma_bedelleri
						INNER JOIN
							user
						ON
							user.id=cayma_bedelleri.uye_id
						INNER JOIN
							uye_grubu
						ON
							user.paket=uye_grubu.id
						WHERE
							durum=7
						ORDER BY
							tahsil_tarihi desc
					");
					$toplam_cayma=mysql_query("
						SELECT
							SUM(cayma_bedelleri.tutar) as toplam
						FROM
							cayma_bedelleri
						INNER JOIN
							user
						ON
							user.id=cayma_bedelleri.uye_id
						INNER JOIN
							uye_grubu
						ON
							user.paket=uye_grubu.id
						WHERE
							durum=7
						
					");
					$toplam_fetch=mysql_fetch_assoc($toplam_cayma);
					$toplam_aktif=$toplam_fetch["toplam"];
				?>
				<div style="margin-top:25px;" class="row-fluid">
					<div class="span12">
						<text style="margin-left:50px;font-size:16px;">TOPLAM </text><b id="toplam_7" style="font-size:20px"><?=money($toplam_aktif) ?>₺</b>
					</div>
				</div>
				<div style="margin-top:25px;" class="row-fluid">
					<div class="span12">
						<a target="_blank" href="https://ihale.pertdunyasi.com/excel.php?q=tahsil_edilenler_excel"><text style="font-size:16px;">Excel </text></a><br/>
						<text style="font-size:16px;">Tüm yıllar listeleniyor </text>
					</div>
				</div>
				<table class="table no-table-bordered">
					<thead>
						<tr class="baskili">
							<td>ÜYE ID VE ADI</td>
							<td>ÜYE GRUBU</td>
							<td>BORÇ TARİHİ</td>
							<td>TAHSİL TARİHİ</td>
							<td>KONU ARAÇ</td>
							<td>AÇIKLAMALAR</td>
							<td>TUTAR</td>
						</tr>
					</thead>
					<tbody>
						<?php
							while($cayma_fetch=mysql_fetch_array($cayma)){ 
								if($cayma_fetch["kurumsal_user_token"]!=""){
									$user_ad=$cayma_fetch["user_unvan"];
								}else{
									$user_ad=$cayma_fetch["user_ad"];
								}
								$ilan_sql=mysql_query("
									SELECT 
										*
									FROM
										ilanlar 
									WHERE	
										plaka='".$cayma_fetch["arac_kod_plaka"]."' or arac_kodu='".$cayma_fetch["arac_kod_plaka"]."'
								");
								if(mysql_num_rows($ilan_sql)!=0){
									$ilan_fetch=mysql_fetch_assoc($ilan_sql);
									//$href="?modul=ilanlar&sayfa=ilan_ekle&id=".$ilan_fetch["id"];
									if($ilan_fetch["ihale_turu"] == 1){
										$tur = "ihale";
									}elseif($ilan_fetch["ihale_turu"] == 2){
										$tur = "dogrudan";
									}
									$href='../arac_detay.php?id='.$ilan_fetch["id"].'&q='.$tur.'';
								}else{
									$href="";
								}
							?>
						<tr>
							<td><a target="_blank" href="?modul=uyeler&sayfa=uye_duzenle&id=<?=$cayma_fetch["user_id"] ?>"><?=$cayma_fetch["user_id"] ?> - <?=$user_ad ?></a></td>
							<td><?=$cayma_fetch["user_paket"] ?></td>
							<td><?=date("d-m-Y",strtotime($cayma_fetch["bloke_tarihi"])) ?></td>
							<td><?=date("d-m-Y",strtotime($cayma_fetch["tahsil_tarihi"])) ?></td>
							<td><a href="<?=$href ?>">#<?=$cayma_fetch["arac_kod_plaka"] ?> / <?=$cayma_fetch["arac_detay"] ?></a></td>
							<td><?=$cayma_fetch["aciklama"] ?> </td>
							<td style="font-weight:bold">₺<?=money($cayma_fetch["tutar"]) ?> </td> 
						</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<?php  ?>
<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script src="js/uyeler_modal.js?v=<? echo time();?>"></script>
<script>

function TriggerVarMi() {
	var trigger_sor = localStorage.getItem('trigger');
	if(trigger_sor != "" && trigger_sor != undefined ){
		//console.log(document.getElementById(trigger_sor)+"!="+null);
		if(document.getElementById(trigger_sor)!=null){
			console.log(trigger_sor);
			document.getElementById(trigger_sor).click();
			//localStorage.removeItem("trigger");
		}else{
			localStorage.removeItem("trigger");
		}
	}
}
function updateTrigger(id){
	localStorage.setItem("trigger",id);
}

window.onload = TriggerVarMi;
</script>



