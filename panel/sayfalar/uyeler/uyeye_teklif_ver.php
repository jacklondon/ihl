<?php
include('../../../ayar.php');

$gelen_id = re('id');
$admin_id = $_SESSION['kid'];

if ($gelen_id) {
	$a1 = $_SERVER['HTTP_USER_AGENT'];
	$os        = getOS();
	$browser   = getBrowser();
	$output = '';

	$sor = mysql_query("SELECT * FROM ilanlar WHERE id = '" . $gelen_id . "'");
	/* $sorgula=mysql_query("select MAX(teklif) as tklf from teklifler where ilan_id='".$gelen_id."'");
	$rowla=mysql_fetch_array($sorgula);
	$max_teklif=$rowla["tklf"];*/

	$sy1 = 0;
	$sy2 = 1;

	while ($yaz = mysql_fetch_array($sor)) {
		$sorg = mysql_query("SELECT * FROM komisyon_oranlari WHERE sigorta_id = '" . $yaz['sigorta'] . "'");
		$sorg_say = mysql_num_rows($sorg);
		$arttir = 1;
		$oran = array();
		$standart_net = array();
		$luks_net = array();
		$standart_onbinde = array();
		$luks_onbinde = array();

		while ($sonu = mysql_fetch_array($sorg)) {
			array_push($oran, $sonu['komisyon_orani']);
			array_push($standart_net, $sonu['net']);
			array_push($luks_net, $sonu['lux_net']);
			array_push($standart_onbinde, $sonu['onbinde']);
			array_push($luks_onbinde, $sonu['lux_onbinde']);
			$output .= '
			<input type="hidden" id="standart_net" value="' . $standart_net . '">
			<input type="hidden" id="luks_net" value="' . $luks_net . '">
			<input type="hidden" id="standart_onbinde" value="' . $standart_onbinde . '">
			<input type="hidden" id="luks_onbinde" value=' . $luks_onbinde . '">
			<input type="hidden" id="oran" value="' . $oran . '">
			<input type="hidden" id="admin_id" value="' . $admin_id . '">
			';
		}

		$output .= '
				<input type="hidden" id="hesaplama' . $yaz["id"] . '" value="' . $yaz['hesaplama'] . '">
				<input type="hidden" id="sorgu_sayi" value="' . $sorg_say . '">
			';
		$ihale_id = $yaz['id'];
		$tarih = $yaz['ihale_tarihi'];
		$saat = $yaz['ihale_saati'];
		$max_teklif = $yaz["son_teklif"];
		$marka_cek = mysql_query("SELECT * FROM marka WHERE markaID = '" . $yaz['marka'] . "'");
		$marka_yaz = mysql_fetch_assoc($marka_cek);
		$marka_adi = $marka_yaz['marka_adi'];
		$uye_cek = mysql_query("SELECT * FROM user");

		$teklif_cek = mysql_query("SELECT * FROM teklifler WHERE ilan_id = '" . $yaz['id'] . "'  GROUP BY uye_id ORDER BY teklif_zamani DESC");
		$tklf_cek = mysql_query("SELECT *,MAX(teklif) as max_teklif FROM teklifler WHERE ilan_id = '" . $yaz['id'] . "' GROUP BY uye_id ORDER BY teklif_zamani DESC");
		$sigorta = mysql_query("select * from sigorta_ozellikleri where id='" . $yaz['sigorta'] . "' ");
		$sigorta_row = mysql_fetch_array($sigorta);
		$h1 = $sigorta_row["hizli_teklif_1"];
		$h2 = $sigorta_row["hizli_teklif_2"];
		$h3 = $sigorta_row["hizli_teklif_3"];
		$h4 = $sigorta_row["hizli_teklif_4"];
		$min_artis = $sigorta_row["minumum_artis"];
		$kaynak_uye_cek = mysql_query("SELECT * FROM user");
		while ($kaynak_uye_oku = mysql_fetch_array($kaynak_uye_cek)) {
			$kaynak_uye_limit_cek = mysql_query("SELECT * FROM teklif_limiti WHERE uye_id ='" . $kaynak_uye_oku['id'] . "'");
			$kaynak_uye_limit_oku = mysql_fetch_assoc($kaynak_uye_limit_cek);
			$kaynak_uye_limit = $kaynak_uye_limit_oku['teklif_limiti'];
			if ($kaynak_uye_oku["id"] == '283') { //Kaynak Firma Uye ID 
				$kaynak_firma_id = $kaynak_uye_oku["id"];
				$kaynak_firma = '<option value=' . $kaynak_uye_oku["id"] . '>' . $kaynak_uye_oku["ad"] . '</option>';
			}
		}
		$output .= '
        <form method="POST">
            <h3 style="text-align:center;">' . $yaz["model_yili"] . " " . $marka_adi . " " . $yaz["model"] . " " . $yaz["tip"] . '</h3>
            <div class="row-fluid">
			    <div class="span6">
                    <select onchange="pasifle()" name="teklif_uye" id="teklif_uye">
						<option value="">--Teklif Verenler--</option> ';
		$sayi = 0;
		$max_teklif_firma = false;
		while ($tklf_oku = mysql_fetch_array($tklf_cek)) {
			if ($tklf_oku['uye_id'] == $kaynak_firma_id) {
				$sayi = $sayi + 1;
				if ($max_teklif == $tklf_oku['teklif']) {
					$max_teklif_firma = true;
				}
			}
		}
		while ($teklif_oku = mysql_fetch_array($teklif_cek)) {
			$uye_getir = mysql_query("SELECT * FROM user WHERE id = '" . $teklif_oku['uye_id'] . "' ");
			$uye_yaz = mysql_fetch_array($uye_getir);
			$t_getir = mysql_query("SELECT * FROM teklifler WHERE  durum=1 and ilan_id = '" . $yaz['id'] . "' and uye_id='" . $teklif_oku["uye_id"] . "' order by teklif_zamani desc limit 1");
			$t_oku = mysql_fetch_array($t_getir);
			if ($uye_yaz["user_token"] == "") {
				$uye_adi = $uye_yaz['unvan'];
			} else {
				$uye_adi = $uye_yaz['ad'];
			}


			/*
			if($max_teklif_firma==true){
				if($t_oku['uye_id']==$kaynak_firma_id){
					$output .='
						<option selected value='.$t_oku["uye_id"].' >'.$uye_adi. " - " .money($t_oku['teklif']). " ₺ ".'</option> 
					';
				}else{
					$output .='
						<option style="background:red" value='.$t_oku["uye_id"].' >'.$uye_adi. " - " .money($t_oku['teklif']). " ₺ ".'</option> 
					';
				}
			}else{
				
				if($kaynak_firma_id==$t_oku["uye_id"]){
					$output .='
						<option selected value='.$t_oku["uye_id"].' >'.$uye_adi. " - " .money($t_oku['teklif']). " ₺ ".'</option> 
					';
				}else{
					$output .='
						<option value='.$t_oku["uye_id"].' >'.$uye_adi. " - " .money($t_oku['teklif']). " ₺ ".'</option> 
					';
				}
			}
			*/
			if ($max_teklif_firma == true) {
				if ($t_oku['uye_id'] == $kaynak_firma_id) {
					$output .= '<option value=' . $t_oku["uye_id"] . ' >' . $uye_adi . " - " . money($t_oku['teklif']) . " ₺ " . '</option>';
				} else {
					$output .= '<option style="background:red" value=' . $t_oku["uye_id"] . ' >' . $uye_adi . " - " . money($t_oku['teklif']) . " ₺ " . '</option>';
				}
			} else {
				$output .= '<option  value=' . $t_oku["uye_id"] . ' >' . $uye_adi . " - " . money($t_oku['teklif']) . " ₺ " . '</option>';
			}
		}
		if ($sayi == 0) {
			$output .= $kaynak_firma;
		}
		$parcala = explode(":", $yaz['ihale_saati']);
		$ihala_saat_duzenle = $parcala[0] . ":" . $parcala[1];
		$output .= '</select>
                </div>
                <div class="span6">				
                <input id="srch" type="text" name="search" placeholder="Üye ara..." class="span12">
                <select onchange="pasifle2()" class="span12" id="slct" name="kaynak_uye">
					<option value="">--Üyeler--</option>
                ';
		while ($uye_oku = mysql_fetch_array($uye_cek)) {
			$uye_limit_cek = mysql_query("SELECT * FROM teklif_limiti WHERE uye_id ='" . $uye_oku['id'] . "'");
			$uye_limit_oku = mysql_fetch_assoc($uye_limit_cek);

			$aktif_cayma_toplam = mysql_query("SELECT SUM(tutar) as toplam_aktif_cayma FROM cayma_bedelleri WHERE uye_id='" . $uye_oku['id'] . "' AND durum=1");
			$toplam_aktif_cayma = mysql_fetch_assoc($aktif_cayma_toplam);
			$iade_talepleri_toplam = mysql_query("SELECT SUM(tutar) as toplam_iade_talepleri FROM cayma_bedelleri WHERE uye_id='" . $uye_oku['id'] . "' AND durum=2");
			$toplam_iade_talepleri = mysql_fetch_assoc($iade_talepleri_toplam);
			$borclar_toplam = mysql_query("SELECT SUM(tutar) as toplam_borclar FROM cayma_bedelleri WHERE uye_id='" . $uye_oku['id'] . "' AND durum=6");
			$toplam_borclar = mysql_fetch_assoc($borclar_toplam);
			$cayma = $toplam_aktif_cayma["toplam_aktif_cayma"] - $toplam_iade_talepleri["toplam_iade_talepleri"] - $toplam_borclar["toplam_borclar"];
			if ($yaz['hesaplama'] == "Standart") {
				if ($uye_limit_oku["teklif_limiti"] == 0) {
					if ($uye_limit_oku["standart_limit"] != 0) {
						$uye_limit = $uye_limit_oku["standart_limit"];
					} else {
						$grup_cek = mysql_query("select * from uye_grubu_detaylari where grup_id='" . $uye_oku["paket"] . "' and cayma_bedeli <= '" . $cayma . "' order by cayma_bedeli desc limit 1");
						$grup_oku = mysql_fetch_object($grup_cek);
						$uye_limit = $grup_oku->standart_ust_limit;
					}
				} else {
					$uye_limit = $uye_limit_oku["teklif_limiti"];
				}
				// $uye_limit = $uye_limit_oku['standart_limit'];
			} else {
				if ($uye_limit_oku["teklif_limiti"] == 0) {
					if ($uye_limit_oku["luks_limit"] != 0) {
						$uye_limit = $uye_limit_oku["luks_limit"];
					} else {
						$grup_cek = mysql_query("select * from uye_grubu_detaylari where grup_id='" . $uye_oku["paket"] . "' and cayma_bedeli <= '" . $cayma . "' order by cayma_bedeli desc limit 1");
						$grup_oku = mysql_fetch_object($grup_cek);
						$uye_limit = $grup_oku->luks_ust_limit;
					}
				} else {
					$uye_limit = $uye_limit_oku["teklif_limiti"];
				}
				// $uye_limit = $uye_limit_oku['luks_limit'];
			}
			if ($uye_oku['id'] == '283') { //Kaynak Firma Uye ID
				$selected = "selected";
				$limit = "Sınırsız";
			} else {
				$selected = "";
				$limit = money($uye_limit) . " ₺";
			}
			$limit_base = $uye_limit;
			if ($uye_oku["user_token"] == "") {
				$uye_ad = $uye_oku["unvan"];
			} else {
				$uye_ad = $uye_oku["ad"];
			}
			if($limit_base > 0){
				$output .= '<option value=' . $uye_oku["id"] . ' ' . $selected . '>' . $uye_ad . " - " . $limit . '</option>';
			}
		
		}

		$output .= '</select>
                </div>
            </div>
            <div class="row-fluid">
                <div class="span6">
                    <div class="row-fluid">
                        <div class="span6">
							<label for="IDofInput">Kalan Süre</label>
							<span id="sayc' . $ihale_id . '"> </span><br/>
							<span>Kapanış: ' . $ihala_saat_duzenle . '</span>
							<input type="hidden" id="ihale_sayc' . $ihale_id . '" value="' . $yaz['ihale_tarihi'] . ' ' . $yaz['ihale_saati'] . '">
							<input type="hidden" id="idd_' . $ihale_id . '" value="' . $yaz['id'] . '">
                        </div>
                        <div class="span6">
                            <label for="IDofInput">Şuanki Fiyat</label>
                            <label for="IDofInput">' . $max_teklif . '</label>
                        </div>
                    </div>
                    <div class="row-fluid">
                        <div class="span6">
							Teklif Sonrası Süre<br>							
							<span style="font-weight:bold;font-size:15px;color:red" id="sayc' . $ihale_id . '_' . $sy2 . '"> </span><br/>
							<span style="font-weight:bold;font-size:15px;color:red" id="yeni_saat_span' . $ihale_id . '"></span>
							<input type="hidden" id="ihale_sayc' . $ihale_id . '_' . $sy2 . '" value="' . $yaz['ihale_tarihi'] . ' ' . $yaz['ihale_saati'] . '">
							<input type="hidden" id="idd_' . $ihale_id . '_' . $sy2 . '" value="' . $yaz['id'] . '">
                        </div>
                        <div class="span6">
                            <label for="IDofInput">Teklif Sonrası Fiyat</label>
                            <label id="yeni_teklif" for="IDofInput"> </label>
                        </div>
                    </div>
					<div class="row-fluid" style="margin-top:3%;">
						<div class="span12">
							Hizmet Bedeli: <span id="hizmet_bedel' . $ihale_id . '"></span>
						</div>
					</div>
                </div>
                <div  class="span6">
                    <div class="row-fluid">
                        <label for="IDofInput">Bitiş Saati Gir</label>
                        <input id="yeni_saat' . $ihale_id . '" onchange="sayac2(' . $ihale_id . ',' . $sy2 . ');" value="" type="time">
                    </div>
                    <div class="row-fluid">
                        <label for="IDofInput">Teklif Gir</label>
                        <input step="' . $min_artis . '" id="teklif" onchange="guncelle();komisyon_kontrol(' . $ihale_id . ');sayac2(' . $ihale_id . ',' . $sy2 . ');"  onkeypress="return event.keyCode === 8 || event.charCode >= 48 && event.charCode <= 57;guncelle();" type="number"/>
						<input type="hidden" value="' . ($max_teklif) . '" id="sonTeklif" />
						<input type="hidden" value="' . $ihale_id . '" id="yeni_sayac1">
						<input type="hidden" value="' . $sy2 . '" id="yeni_sayac2">
                    </div>
                    <div class="row-fluid">
                        <div class="span3">
                            <button type="button" onclick="h1(); guncelle();komisyon_kontrol(' . $ihale_id . ');" id="arti1" value="' . $h1 . '" class="btn blue btn-sm">+' . $h1 . '₺</button>
                        </div>
                        <div class="span3">
                            <button type="button" onclick="h3(); guncelle();komisyon_kontrol(' . $ihale_id . ');" id="arti3" value="' . $h3 . '" class="btn blue btn-sm">+' . $h3 . '₺</button>
                        </div>
                        <div class="span3">
                            <button type="button" onclick="h2(); guncelle();komisyon_kontrol(' . $ihale_id . ');" id="arti2" value="' . $h2 . '" class="btn blue btn-sm">+' . $h2 . '₺</button>
                        </div>
                        <div class="span3">
                            <button type="button" onclick="h4(); guncelle();komisyon_kontrol(' . $ihale_id . ');" id="arti4" value="' . $h4 . '" class="btn blue btn-sm">+' . $h4 . '₺</button>
                        </div>
                    </div>
                </div>
            </div>
			<div class="row-fluid" style="margin-top:3%;">
				<div class="span6">
				</div>
				<div class="span6" style="display:none" id="uyari_span' . $ihale_id . '">
					<input type="checkbox" value="1" id="uyari_durum' . $ihale_id . '" name="uyari_durum' . $ihale_id . '" ><text style="margin-left:1%;"> Uyarıya rağmen işlemi yap</text>
				</div>
			</div>
            <div class="row-fluid" style="margin-top:3%;">
                <div class="span6">
					<button type="button" id="teklif_gonder" onclick="komisyon_kontrol(' . $ihale_id . '); panel_teklif(' . $yaz["id"] . ');" class="btn-primary btn-block">Teklifi Gönder</button>
                </div>
                <div class="span6">
                    <button class="btn-danger btn-block" data-dismiss="modal" aria-hidden="true">Kapat</button>
                </div>
            </div>
        </form>
		 <input type="hidden" id="ip" value="' . GetIP() . '">
         <input type="hidden" id="tarayici" value="' . $browser . '">
         <input type="hidden" id="isletim_sistemi" value="' . $os . '">
		
	';
	}
	echo $output;
}
?>
<script>
	function pasifle() {
		if ($("#teklif_uye").val() != "") {
			document.getElementById("slct").disabled = true;
			document.getElementById("slct").value = "";
		} else {
			document.getElementById("slct").disabled = false;
		}
	}

	function pasifle2() {
		if ($("#slct").val() != "") {
			document.getElementById("teklif_uye").disabled = true;
			document.getElementById("teklif_uye").value = "";
		} else {
			document.getElementById("teklif_uye").disabled = false;
		}
	}

	function formatMoney(n) {
		var n = (Math.round(n * 100) / 100).toLocaleString();
		n = n.replaceAll(',', '.')
		return n;
	}

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
					option_text = arr[key].toLowerCase();
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
	$(document).ready(function() {
		bind_select_search('#srch', '#slct', 'options')
	})
</script>
<script>
	var i = document.getElementById('sonTeklif').value;
	var plus = parseInt(i);

	function h1() {
		var hizli1 = document.getElementById('arti1').value;
		plus += parseInt(hizli1);
		document.getElementById('teklif').value = plus;
	}

	function h2() {
		var hizli2 = document.getElementById('arti2').value;
		plus += parseInt(hizli2);
		document.getElementById('teklif').value = plus;
	}

	function h3() {
		var hizli3 = document.getElementById('arti3').value;
		plus += parseInt(hizli3);
		document.getElementById('teklif').value = plus;
	}

	function h4() {
		var hizli4 = document.getElementById('arti4').value;
		plus += parseInt(hizli4);
		document.getElementById('teklif').value = plus;
	}
</script>
<script>
	document.getElementById("yeni_teklif").value = $('#teklif').val();
	document.getElementById("yeni_teklif").innerHTML = $('#teklif').val();

	function guncelle() {
		document.getElementById("yeni_teklif").value = $('#teklif').val();
		document.getElementById("yeni_teklif").innerHTML = $('#teklif').val();
	}
</script>
<script>
	function sayac(sira) {
		var zaman = document.getElementById("ihale_sayc" + sira).value;
		var countDownDate = new Date(zaman).getTime();
		var x = setInterval(function() {
			var now = new Date().getTime();
			var distance = (countDownDate) - (now);
			var days = Math.floor(distance / (1000 * 60 * 60 * 24));
			var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
			if (hours < 10) {
				hours = "0" + hours;
			}
			var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
			if (minutes < 10) {
				minutes = "0" + minutes;
			}
			var seconds = Math.floor((distance % (1000 * 60)) / 1000);
			if (seconds < 10) {
				seconds = "0" + seconds;
			}
			document.getElementById("sayc" + sira).innerHTML = days + " Gün 	" + hours + ":" + minutes + ":" + seconds;
			if (distance < 0) {
				clearInterval(x);
				document.getElementById("sayc" + sira).innerHTML = "Süre Doldu";
			}
		}, 1000);
	}
	sayac(<?= $ihale_id ?>);
	var control = false;
	$("#teklif").on("change", function() {
		control = true;
		jQuery.ajax({
			url: "https://ihale.pertdunyasi.com/check.php",
			type: "POST",
			dataType: "JSON",
			data: {
				action: "teklif_sonrasi_tarih",
				ilan_id: <?= $ihale_id ?>,
				teklif: document.getElementById('teklif').value,
				yeni_saat: document.getElementById("yeni_saat" + <?= $ihale_id ?>).value,
			},
			success: function(response) {
				console.log(response);

				if (response.status == 200) {
					document.getElementById("ihale_sayc" + <?= $ihale_id ?> + "_" + <?= $sy2 ?>).value = response.tarih;
				}
			}
		});


	});

	// setInterval(function() {
	// 	if (document.getElementById("yeni_saat" + <?= $ihale_id ?>).value == "") {
	// 		sayac2_ugur($('#yeni_sayac1').val(), $('yeni_sayac2').val());
	// 	}
	// }, 1000);

	if (document.getElementById("yeni_saat" + <?= $ihale_id ?>).value == "") {
		sayac2_ugur($('#yeni_sayac1').val(), $('yeni_sayac2').val());
	}

	function sayac2_ugur(sira, sy) {

		var x = setInterval(function() {

			if (document.getElementById("yeni_saat" + <?= $ihale_id ?>).value == "") {
				jQuery.ajax({
					url: "https://ihale.pertdunyasi.com/check.php",
					type: "POST",
					dataType: "JSON",
					data: {
						action: "teklif_sonrasi_tarih",
						ilan_id: <?= $ihale_id ?>,
						teklif: document.getElementById('teklif').value,
						yeni_saat: document.getElementById("yeni_saat" + <?= $ihale_id ?>).value,
					},
					success: function(response) {
						console.log(response);
						if (response.status == 200) {

							document.getElementById("ihale_sayc" + <?= $ihale_id ?> + "_" + <?= $sy2 ?>).value = response.tarih;

							// $("#yeni_saat"+<?= $ihale_id ?>).val(response.kapanis_saat); 
							$("#yeni_saat_span" + sira).html("Kapanış: " + response.kapanis_saat);
						}
					}
				});
			}


			var zaman = document.getElementById("ihale_sayc" + <?= $ihale_id ?> + "_" + <?= $sy2 ?>).value;
			var countDownDate = new Date(zaman).getTime();
			var now = new Date().getTime();
			var distance = (countDownDate) - (now);
			var days = Math.floor(distance / (1000 * 60 * 60 * 24));
			var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
			if (hours < 10) {
				hours = "0" + hours;
			}
			var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
			if (minutes < 10) {
				minutes = "0" + minutes;
			}
			var seconds = Math.floor((distance % (1000 * 60)) / 1000);
			if (seconds < 10) {
				seconds = "0" + seconds;
			}
			document.getElementById("sayc" + <?= $ihale_id ?> + "_" + <?= $sy2 ?>).innerHTML = days + " Gün 	" + hours + ":" + minutes + ":" + seconds;
			if (distance < 0) {
				clearInterval(x);
				document.getElementById("sayc" + <?= $ihale_id ?> + "_" + <?= $sy2 ?>).innerHTML = "Süre Doldu";
			}

		}, 1000);
	}



	function sayac2(sira, sy) {
		var x = setInterval(function() {

			jQuery.ajax({
				url: "https://ihale.pertdunyasi.com/check.php",
				type: "POST",
				dataType: "JSON",
				data: {
					action: "teklif_sonrasi_tarih",
					ilan_id: <?= $ihale_id ?>,
					teklif: document.getElementById('teklif').value,
					yeni_saat: document.getElementById("yeni_saat" + <?= $ihale_id ?>).value,
				},
				success: function(response) {
					console.log(response);
					if (response.status == 200) {

						document.getElementById("ihale_sayc" + <?= $ihale_id ?> + "_" + <?= $sy2 ?>).value = response.tarih;
						$("#yeni_saat_span" + sira).html("Kapanış: " + response.kapanis_saat);
					}
				}
			});
			var zaman = document.getElementById("ihale_sayc" + sira + "_" + sy).value;
			var countDownDate = new Date(zaman).getTime();
			var now = new Date().getTime();
			var distance = (countDownDate) - (now);
			var days = Math.floor(distance / (1000 * 60 * 60 * 24));
			var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
			if (hours < 10) {
				hours = "0" + hours;
			}
			var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
			if (minutes < 10) {
				minutes = "0" + minutes;
			}
			var seconds = Math.floor((distance % (1000 * 60)) / 1000);
			if (seconds < 10) {
				seconds = "0" + seconds;
			}
			document.getElementById("sayc" + sira + "_" + sy).innerHTML = days + " Gün 	" + hours + ":" + minutes + ":" + seconds;
			if (distance < 0) {
				clearInterval(x);
				document.getElementById("sayc" + sira + "_" + sy).innerHTML = "Süre Doldu";
			}
		}, 1000);
	}

	/*setInterval(function() 
	{
		sayac2(<?= $ihale_id ?>,<?= $sy2 ?>);	
	}, 1000);*/


	/*function sayac2(sira,sy) 
	{	
		var x = setInterval(function() 
		{
			if($("#teklif").val() != ""){
				var zaman =document.getElementById("ihale_sayc"+sira+"_"+sy).value;
				var parcala=zaman.split(" ");
				var parcala2=parcala[1].split(":");
				var kapanis_zaman=parcala2[0]+":"+parcala2[1];
				
				
			}else{
				var zaman ="";
				var kapanis_zaman="";
			}
			var countDownDate = new Date(zaman).getTime();
			var now = new Date().getTime();
			if(isNaN(countDownDate)){
				distance=-1;
			}else{
				var distance = (countDownDate) - (now);
			}
			var days = Math.floor(distance / (1000 * 60 * 60 * 24));
			var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
			if(hours<10){
				hours="0"+hours;
			}
			var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
			if(minutes<10){
				minutes="0"+minutes;
			}
			var seconds = Math.floor((distance % (1000 * 60)) / 1000);
			if(seconds<10){
				seconds="0"+seconds;
			}
			if($("#teklif").val() > 0){
				document.getElementById("sayc"+sira+"_"+sy).innerHTML = days + " Gün " + hours + ": "+ minutes + ": " + seconds;
				//$("#yeni_saat_span"+sira).html("Kapanış: "+$("#yeni_saat"+sira).val()); 
				$("#yeni_saat_span"+sira).html("Kapanış: "+kapanis_zaman); 
			}else{
				document.getElementById("sayc"+sira+"_"+sy).innerHTML = "";
				$("#yeni_saat_span"+sira).html("") ; 
			}
			
			if (distance < 0) 
			{
				clearInterval(x);
				if($("#teklif").val() != ""){
					document.getElementById("sayc"+sira+"_"+sy).innerHTML = "Süre Doldu"; 
				}else{
					document.getElementById("sayc"+sira+"_"+sy).innerHTML = ""
				}
			}
		}, 1000);
		
	}
	setInterval(function() 
	{
		sayac2(<?= $ihale_id ?>,<?= $sy2 ?>);			
	}, 1000);
	*/
</script>
<script>
	function panel_teklif(id) {
		/*if($("#yeni_saat"+<?= $ihale_id ?>).val() == ""){
			alert("Bitiş Saati Boş Olamaz");
		}else{*/
		if (document.getElementById("uyari_durum" + id).checked == true) {
			var uyari_durum = document.getElementById("uyari_durum" + id).value;
		} else {
			var uyari_durum = "";
		}
		jQuery.ajax({
			url: "https://ihale.pertdunyasi.com/check.php",
			type: "POST",
			dataType: "JSON",
			data: {
				action: "panel_teklif",
				ilan_id: id,
				kaynak_id: document.getElementById('slct').value,
				uye_id: document.getElementById('teklif_uye').value,
				teklif: document.getElementById('teklif').value,
				ip: document.getElementById('ip').value,
				admin_id: document.getElementById('admin_id').value,
				tarayici: document.getElementById('tarayici').value,
				isletim_sistemi: document.getElementById('isletim_sistemi').value,
				yeni_saat: document.getElementById("yeni_saat" + id).value,
				hizmet_bedel: parseInt(document.getElementById("hizmet_bedel" + id).value),
				uyari_durum: uyari_durum,
			},
			success: function(response) {
				console.log(response);

				if (response.status != 200) {
					if (response.ihale_durum == 1) {

						console.log(document.getElementById("uyari_span" + id).style.display);
						document.getElementById("uyari_span" + id).style.display = "block";

						openToastrDanger(response.message);
					} else {
						openToastrDanger(response.message);
						//alert(response.message);
					}
				} else {
					//alert("Başarıyla teklif verildi");
					$('#uyeye_teklif').modal('hide');
					openToastrSuccess("Başarıyla teklif verildi")
					// setTimeout(function(){ location.reload(); }, 3000);

				}
			}
		});
		//}

	}
</script>
<script>
	function komisyon_kontrol(id) {
		var hesaplama = document.getElementById('hesaplama' + id).value;
		var girilen_teklif = document.getElementById('teklif').value;
		jQuery.ajax({
			url: "https://ihale.pertdunyasi.com/teklif_ver.php",
			type: "POST",
			dataType: "JSON",
			data: {
				action: "komisyon_cek",
				ilan_id: id,
				girilen_teklif: girilen_teklif

			},
			success: function(data) {

				var son_komisyon = data.son_komisyon;
				if (son_komisyon == 0 || son_komisyon == undefined || son_komisyon == null || son_komisyon == "") {
					document.getElementById("hizmet_bedel" + id).innerHTML = "" + "₺";
					document.getElementById("hizmet_bedel" + id).value = "" + "₺";
				} else {
					document.getElementById("hizmet_bedel" + id).innerHTML = formatMoney(son_komisyon) + "₺";
					document.getElementById("hizmet_bedel" + id).value = son_komisyon + "₺";
				}
			},
		});
		/*var oran = <?php echo json_encode($oran); ?>;
		var standart_net = <?php echo json_encode($standart_net); ?>;
		var luks_net = <?php echo json_encode($luks_net); ?>;
		var standart_onbinde = <?php echo json_encode($standart_onbinde); ?>;
		var luks_onbinde = <?php echo json_encode($luks_onbinde); ?>;
		
		//Dizi max,min bulur
		Array.prototype.max = function() {
		  return Math.max.apply(null, this);
		};

		Array.prototype.min = function() {
		  return Math.min.apply(null, this);
		};

		var dizi_length = oran.length;
		if(hesaplama == "Standart"){      
			for (var sayac = 0; sayac < dizi_length; sayac++) {
				if(girilen_teklif <= oran[sayac]){
					var oran1 = parseInt(oran[sayac]);
					var standart_net1 = parseInt(standart_net[sayac]);
					var standart_onbinde1 = parseInt(standart_onbinde[sayac]);
					var ek_gider = girilen_teklif * standart_onbinde1 / 10000;
					var son_komisyon = Math.ceil(ek_gider + standart_net1);   	
					break;
				}
			}
			var max_index;
			for (var j = 0; j < dizi_length; j++) {
				if(oran[j] == oran.max() ){
					max_index=j;
				}
			}
			if(girilen_teklif > oran.max()){
				var oran1 = parseInt(oran.max());
				var standart_net1 = parseInt(standart_net[max_index]);
				var standart_onbinde1 = parseInt(standart_onbinde[max_index]);
				var ek_gider = girilen_teklif * standart_onbinde1 / 10000;
				var son_komisyon = Math.ceil(ek_gider + standart_net1);   	
			}
		}else{
			for (var sayac = 0; sayac < dizi_length; sayac++) {
				if(girilen_teklif <= oran[sayac]){
					var oran1 = parseInt(oran[sayac]);
					var luks_net1 = parseInt(luks_net[sayac]);
					var luks_onbinde1 = parseInt(luks_onbinde[sayac]);
					var ek_gider = girilen_teklif * luks_onbinde1 / 10000;
					var son_komisyon = Math.ceil(ek_gider + luks_net1);   				 
					break;
				}
			}
			var max_index;
			for (var j = 0; j < dizi_length; j++) {
				if(oran[j] == oran.max() ){
					max_index=j;
				}
			}
			if(girilen_teklif > oran.max()){
				var oran1 = parseInt(oran.max());
				var luks_net1 = parseInt(luks_net[max_index]);
				var luks_onbinde1 = parseInt(luks_net[max_index]);
				var ek_gider = girilen_teklif * luks_onbinde1 / 10000;
				var son_komisyon = Math.ceil(ek_gider + luks_net1);   	
			}
		}

		if(son_komisyon == 0 || son_komisyon == undefined || son_komisyon == null || son_komisyon == "" ){
			document.getElementById('hizmet_bedel'+id).innerHTML = "" +" ₺";
			document.getElementById('hizmet_bedel'+id).value = "" +" ₺";
		}else {
			document.getElementById('hizmet_bedel'+id).innerHTML = formatMoney(son_komisyon) +" ₺";
			document.getElementById('hizmet_bedel'+id).value = son_komisyon +" ₺";
		}	*/
	}
	komisyon_kontrol(<?= $ihale_id ?>);
</script>