<?php 
	include('../../../ayar.php');
	$gelen_id = re('id');
	if($gelen_id)
	{
		$today = date("Y-m-d");
		$output = '';
		$uyeler='';
		$uye_bul = mysql_query("select * from user");
		while($uye_yaz = mysql_fetch_array($uye_bul)){
			
			$uyeler.='<option value="'.$uye_yaz['id'].'">'.$uye_yaz['id'].'ID - '.$uye_yaz['ad'].' </option>';
			
		}
		$output .= '
			<script src="assets/ckeditor4/ckeditor.js"></script>
			<style>
				.label_input{
					width: 200px;
					float: left;
					margin: 5px 0px;
				}
				
				.input_div {
					width: calc(100% - 150px);
					float: left;
				}
			</style>
			<form method="POST">
				
				<div class="row-fluid">
					<div class="span6">
						<label class="label_input" for="IDofInput">PLAKA</label>
						<input type="text" class="span12 " name="plaka" id="plaka" style="width: calc(100% - 150px);float: left;"  value="">
						<label class="label_input" for="IDofInput">KOD</label>
						<input type="text" class="span12 " name="kod" id="kod" style="width: calc(100% - 150px);float: left;"  value="">
						<label class="label_input" for="IDofInput">ÖDEME TARİHİ</label>
						<input type="date" class="span12 " name="odeme_tarihi" id="odeme_tarihi" style="width: calc(100% - 150px);float: left;"  value="'.date('Y-m-d').'">
						<label class="label_input" for="IDofInput">ÖDEMEYİ GÖNDEREN</label>
						<input type="text" class="span12 " id="parayi_gonderen" name="parayi_gonderen" style="width: calc(100% - 150px);float: left;"  value="">
						<label class="label_input" for="IDofInput">MARKA MODEL</label>
						<input type="text" class="span12 " name="marka_model" id="marka_model" style="width: calc(100% - 150px);float: left;"  value="">
						<label class="label_input" for="">SİGORTA</label>
						<input type="text" class="span12 " name="sigorta" id="sigorta" style="width: calc(100% - 150px);float: left;"  value="">
						<label class="label_input" for="IDofInput">ÜYE ADI</label>
						<input  style="width: calc(100% - 150px);float: left;" id="srch" type="text" name="search" placeholder="Üye ara..." class="span12">        
						<label class="label_input" for="IDofInput"></label>						
						<select style="width: calc(100% - 150px);float: left;"  onchange="musteri_temsilcisi_cek();kar_zarar_guncelle();" name="serbest_secim" id="slct" class="span12">
							<option value="">Seçiniz</option>
							'.$uyeler.'
						</select>
					</div>
					<div class="span6">
						<label class="label_input" for="IDofInput">SATIŞ KİMİN ADINA YAPILDI</label>
						<input type="text" class="span12 " name="satis_adi" id="satis_adi" style="width: calc(100% - 150px);float: left;"  value="">
						<label class="label_input" for="IDofInput">SATIŞ TARİHİ</label>
						<input type="date" class="span12 " name="satis_tarihi" id="satis_tarihi" style="width: calc(100% - 150px);float: left;"  value="">
						<label class="label_input" for="IDofInput">MALİYET</label>
						<input type="number" class="span12 " name="maliyet" id="maliyet" style="width: calc(100% - 150px);float: left;" onchange="kar_zarar_guncelle();" value="">
						<label class="label_input" for="IDofInput">SATILAN FİYAT</label>
						<input type="number" class="span12 " name="satilan_fiyat" id="satilan_fiyat" style="width: calc(100% - 150px);float: left;" onchange="kar_zarar_guncelle();" value="">
						<label class="label_input" for="IDofInput">PD HİZMET BEDELİ</label>
						<input type="number" class="span12 " name="pd_hizmet" id="pd_hizmet" style="width: calc(100% - 150px);float: left;" onchange="kar_zarar_guncelle();musteri_temsilcisi_cek();" value="">
						<label class="label_input" for="IDofInput">EKSTRA KAZANÇ</label>
						<input type="number" class="span12 " name="ekstra_kazanc" id="ekstra_kazanc" style="width: calc(100% - 150px);float: left;" onchange="kar_zarar_guncelle();"  value="">
						<label class="label_input" for="IDofInput">AÇIKLAYICI NOTLAR</label>
						<textarea class="span12 " name="aciklayici_not" id="aciklayici_not" style="width: calc(100% - 150px);float: left;" ></textarea>
					</div>
				</div>
				<div class="row-fluid">
					<div class="span6">
						<label class="label_input" for="IDofInput">TOPLAM KAR/ZARAR</label>
						<b style="font-size:25px;width: calc(100% - 150px);float: left;" id="ciro" > </b>
					</div>
					<div class="span6">
						<label class="label_input" for="IDofInput">MÜŞTERİ TEMSİLCİSİ</label>
						<span style="font-size:18px;width: calc(100% - 150px);float: left;" id="musteri_temsilcisi" > </span>
					</div>
				</div>
				<div class="row-fluid">
					<div class="span6">
						
					</div>
					<div class="span6">
						<label class="label_input" for="IDofInput">PRİM</label>
						<span style="font-size:18px;width: calc(100% - 150px);float: left;" id="prim" > </span>
						<input type="hidden" id="prim_db" value="">
					</div>
				</div>
				<div class="row-fluid">
					<input type="button" onclick="satisi_kaydet();" name="satisi" id="satisi" class="btn blue" style="width: calc(100% - 150px);float: left;"  value="Kaydet">
				</div>
			</form>
			<script>
				var now = new Date();
				var day = ("0" + now.getDate()).slice(-2);
				var month = ("0" + (now.getMonth() + 1)).slice(-2);
				var today = now.getFullYear()+"-"+(month)+"-"+(day) ;
				$(function(){
					$("#plaka").on("keyup", function(){
						var plaka = $(this).val();
						var plaka_sayi = plaka.length;
						if(plaka_sayi > 6){
							if(plaka){
								$.post("sayfalar/muhasebe/bilgileri_cek.php", {"plaka": plaka,"action":"plakaya_gore"}, function(response){
									var data = jQuery.parseJSON(response);
									console.log(data);
									if(data.status==200){
										$("#kod").val(data.kod);
										//$("#odeme_tarihi").val(data.odeme_tarihi);
										$("#marka_model").val(data.marka_model);
										$("#sigorta").val(data.sigorta);
										$("#satis_adi").val(data.satis_kimin_adina);
										$("#maliyet").val(data.maliyet);
										$("#pd_hizmet").val(data.pd_hizmet);
										$("#tarih").val(data.tarih);
										$("#satilan_fiyat").val(data.kazanilan_teklif);
										$("#slct").val(data.kazanan_uye_id);
										musteri_temsilcisi_cek();
									}else{
										alert(data.message);
									}
								});
							}else{
								alert("Böyle bir araç bulunamadı");
							}
						}
					});
					/*
					$("#plaka").on("keyup", function(){
						var plaka = $(this).val();
						var plaka_sayi = plaka.length;
						if(plaka_sayi > 6){
							if(plaka){
								$.post("sayfalar/muhasebe/bilgileri_cek.php", {"plaka": plaka,"action":"plakaya_gore"}, function(response){
									var data = jQuery.parseJSON(response);
									console.log(data);
									if(data.status==200){
										$("#kod").val(data.kod);
										//$("#odeme_tarihi").val(data.odeme_tarihi);
										$("#marka_model").val(data.marka_model);
										$("#sigorta").val(data.sigorta);
										$("#satis_adi").val(data.satis_kimin_adina);
										$("#maliyet").val(data.maliyet);
										$("#pd_hizmet").val(data.pd_hizmet);
										$("#tarih").val(data.tarih);
										$("#satilan_fiyat").val(data.kazanilan_teklif);
										$("#slct").val(data.kazanan_uye_id);
										musteri_temsilcisi_cek();
									}else{
										alert(data.message);
									}
								});
							}else{
								alert("Böyle bir araç bulunamadı");
							}
						}
					});
					*/
					$("#kod").on("change", function(){
						var kod = $(this).val();
						if(kod){
							$.post("sayfalar/muhasebe/bilgileri_cek.php", {"kod": kod,"action":"arac_koda_gore"}, function(response){
								var data = jQuery.parseJSON(response);
								console.log(data);
								if(data.status==200){
									$("#plaka").val(data.plaka);
									//$("#odeme_tarihi").val(data.odeme_tarihi);
									$("#marka_model").val(data.marka_model);
									$("#sigorta").val(data.sigorta);
									$("#satis_adi").val(data.satis_kimin_adina);
									$("#maliyet").val(data.maliyet);
									$("#pd_hizmet").val(data.pd_hizmet);
									$("#tarih").val(data.tarih);
									$("#satilan_fiyat").val(data.kazanilan_teklif);
									$("#slct").val(data.kazanan_uye_id);
									musteri_temsilcisi_cek();
								}else{
									alert(data.message);
								}
							});
						}else{
							alert("Böyle bir araç bulunamadı");
						}
					});
					$("#araci_alan").on("keyup", function(){
						var uye_adi = $(this).val();
						if(kod){
							$.post("sayfalar/muhasebe/bilgileri_cek.php", {"kod": kod,"action":"arac_koda_gore"}, function(response){
								var data = jQuery.parseJSON(response);
								console.log(data);
								if(data.status==200){
									$("#plaka").val(data.plaka);
									//$("#odeme_tarihi").val(data.odeme_tarihi);
									$("#marka_model").val(data.marka_model);
									$("#sigorta").val(data.sigorta);
									$("#satis_adi").val(data.satis_kimin_adina);
									$("#maliyet").val(data.maliyet);
									$("#pd_hizmet").val(data.pd_hizmet);
									$("#tarih").val(data.tarih);
									$("#satilan_fiyat").val(data.kazanilan_teklif);
									$("#slct").val(data.kazanan_uye_id);
									musteri_temsilcisi_cek();
								}else{
									alert(data.message);
								}
							});
						}else{
							alert("Böyle bir araç bulunamadı");
						}
					});
				});
				$(document).ready(function() {
					bind_select_search("#srch", "#slct", "options")
				})
				function musteri_temsilcisi_cek(){
					var uye_id=$("#slct").val();
					var plaka=$("#plaka").val();
					var pd_hizmet=$("#pd_hizmet").val();
					if(plaka!=""){
						$.post("sayfalar/muhasebe/bilgileri_cek.php", {"uye_id": uye_id,"plaka":plaka,"pd_hizmet":pd_hizmet,"action":"musteri_temsilcisi_cek"}, function(response){
							var data = jQuery.parseJSON(response);
							console.log(data);
							if(data.status==200){
								if(data.prim_notu != ""){
									$("#musteri_temsilcisi").html(data.musteri_temsilcisi+"("+data.prim_notu+")");
								}else{
									$("#musteri_temsilcisi").html(data.musteri_temsilcisi);
								}
								$("#musteri_temsilcisi").html(data.musteri_temsilcisi);
								$("#prim").html(data.prim);
								$("#prim_db").val(data.prim_db);
								
							}else{
								alert(data.message);
							}
						});
					}else{
						alert("Plaka alanı boş olamaz");
					}
				}
				function satisi_kaydet(){
					var uye_id=$("#slct").val();
					var plaka=$("#plaka").val();
					if(plaka!=""){
						$.post("sayfalar/muhasebe/bilgileri_cek.php", {
								"plaka": $("#plaka").val(),
								"kod": $("#kod").val(),
								"odeme_tarihi": $("#odeme_tarihi").val(),
								"parayi_gonderen": $("#parayi_gonderen").val(),
								"marka_model": $("#marka_model").val(),
								"sigorta": $("#sigorta").val(),
								"serbest_secim": $("#slct").val(),
								"satis_tarihi": $("#satis_tarihi").val(),
								"maliyet": $("#maliyet").val(),
								"satilan_fiyat": $("#satilan_fiyat").val(),
								"pd_hizmet": $("#pd_hizmet").val(),
								"ekstra_kazanc": $("#ekstra_kazanc").val(),
								"notlar": $("#notlar").val(),
								"satis_adi": $("#satis_adi").val(),
								"aciklayici_not": $("#aciklayici_not").val(),
								"prim_db": $("#prim_db").val(),
								"action":"satis_kaydet"
							}, function(response){
							var data = jQuery.parseJSON(response);
							console.log(data);
							if(data.status==200){
								alert("İşlem başarılı");
								window.location.href="?modul=muhasebe&sayfa=satilan_araclar";
							}else{
								alert(data.message);
							}
						});
					}else{
						alert("Plaka alanı boş olamaz");
					}
				}
				function kar_zarar_guncelle(){
					var maliyet=0;
					var satilan_fiyat=0;
					var pd_hizmet=0;
					var ekstra_kazanc=0;
					var ciro=0;
					if(isNaN(parseFloat($("#maliyet").val()))==true){
						maliyet=0;
					}else{
						maliyet=parseFloat($("#maliyet").val());	
					}
					if(isNaN(parseFloat($("#satilan_fiyat").val()))==true){
						satilan_fiyat=0;
					}else{
						satilan_fiyat=parseFloat($("#satilan_fiyat").val());
					}
					if(isNaN(parseFloat($("#pd_hizmet").val()))==true){
						pd_hizmet=0;
					}else{
						pd_hizmet=parseFloat($("#pd_hizmet").val());
					}
					if(isNaN(parseFloat($("#ekstra_kazanc").val()))==true){
						ekstra_kazanc=0;
					}else{
						ekstra_kazanc=parseFloat($("#ekstra_kazanc").val());
					}
					ciro += (satilan_fiyat  + ekstra_kazanc + pd_hizmet) - maliyet;
					$("#ciro").html(ciro +"₺");
				}
			</script>'; 
		echo $output;
	}
?>

