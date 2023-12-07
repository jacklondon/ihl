<?php
include('../../../ayar.php');
// include "not_gonder.php";
$gelen_id = re('id');
if ($gelen_id) {
	$output = '';
	$aktif_admin = mysql_query("select * from kullanicilar where id='" . $_SESSION["kid"] . "'");
	$aktif_admin_oku = mysql_fetch_object($aktif_admin);
	$aktif_admin_id = $aktif_admin_oku->id;
	$aktif_admin_yetkiler = $aktif_admin_oku->yetki;
	$parcala = explode("|", $aktif_admin_yetkiler);
	if (count($parcala) == 13) {
		$sınırsız_yetki = true;
	} else {
		$sınırsız_yetki = false;
	}
	$birlesmis_sql = "SELECT yuklenen_evraklar.*, -1 as ekleyen, 'yuklenen_evraklar' as tablo_turu FROM yuklenen_evraklar WHERE yuklenen_evraklar.user_id='" . $gelen_id . "' UNION SELECT prm_notlari.id,prm_notlari.uye_id,prm_notlari.durum,prm_notlari.tarih,
	prm_notlari.not,prm_notlari.gizlilik,prm_notlari.ekleyen,'prm_notlari' as tablo_turu FROM prm_notlari WHERE prm_notlari.uye_id='" . $gelen_id . "' UNION SELECT uye_notlari.id,uye_notlari.uye_id,uye_notlari.dosya,uye_notlari.tarih,uye_notlari.uye_notu,
	uye_notlari.gizlilik,uye_notlari.ekleyen,'uye_notlari' as tablo_turu FROM uye_notlari WHERE uye_notlari.uye_id='" . $gelen_id . "' GROUP BY uye_notlari.tarih,uye_notlari.uye_notu ORDER BY gonderme_zamani desc";
	
	$prm_mesaj = "Kendisiyle görüştüm Gold üye olma olasılığı yüksektir";
	$birlesmis_sql_query = mysql_query($birlesmis_sql);
	$uye_evraklari = mysql_query("select * from yuklenen_evraklar where user_id='" . $gelen_id . "' group by gonderme_zamani order by id desc");
	$uye_evraklari_say = mysql_num_rows($uye_evraklari);
	$prm_cek = mysql_query("SELECT * FROM prm_notlari WHERE uye_id = '" . $gelen_id . "' ");
	$prm_oku = mysql_fetch_array($prm_cek);
	$prm_say = mysql_num_rows($prm_cek);
	$admin_cek2 = mysql_query("select * from kullanicilar where id = '" . $prm_oku['ekleyen'] . "'");
	$admin_oku2 = mysql_fetch_array($admin_cek2);
	$admin_adi2 = $admin_oku2['adi'];
	$query = mysql_query("SELECT * FROM `user` WHERE id=$gelen_id LIMIT 1");
	$query2 = mysql_query("SELECT * FROM `user` WHERE id=$gelen_id LIMIT 1");
	$evraklar = mysql_query("SELECT * FROM uye_notlari WHERE uye_id ='" . $gelen_id . "' group by tarih order by tarih desc");
	$evrak_say = mysql_num_rows($evraklar);
	$tpl = $evrak_say + $prm_say + $uye_evraklari_say;
	$qyaz = mysql_fetch_array($query2);
	$kullanici_adi = $qyaz["ad"];
	$output .= '<h3>' . $qyaz["ad"] . '</h3>';
	$output .= '<h6>' . $tpl . ' adet not bulundu</h6>';
	$output .= '<form method="POST" enctype="multipart/form-data">
            <div class="row-fluid>
               <label for="IDofInput">Notunuz</label>
               <textarea class="span12" name="eklenecek_not" id="eklenecek_not" rows="4"></textarea>
               <input type="hidden" value="' . $gelen_id . '" name="gelen_id" id="gelen_id">
            </div>
            <div class="row-fluid">
               <input type="file" name="files[]" multiple id="uye_not_files" >
            </div>
            <div class="row-fluid">
				<div class="span2">
					<input type="button" onclick="uye_not_ekle(' . $gelen_id . ')" class="btn blue" name="notu" value="Kaydet" >
				</div>
				<div class="span2"><label>Gizlilik</label></div>
				<div class="span8">
					<select id="gizlilik" name="gizlilik">
						<option value="0">Sadece Ben </option>             
						<option value="1">Tam Yetkili Adminler Görebilir </option> 
						<option value="2" selected>Herkes Görebilir </option> 
					</select>
				</div>
            </div>
		</form>';
	$output .= '<table class="table table-bordered">
			<thead>
				<tr>
					<th>Ekleme Tarihi</th>
					<th>Ekleyen</th>
					<th>Gizlilik</th>
					<th>Not</th>
					<th>Düzenle</th>
					<th>Sil</th>
					<th>Ek</th>
				</tr>
			</thead>  
			<tbody>';
	$evrak_sayi = 0;
	$evrak_list = "";
	while ($notlar_oku = mysql_fetch_array($birlesmis_sql_query)) {
		$admin_cek = mysql_query("select * from kullanicilar where id = '" . $prm_oku['ekleyen'] . "'");
		$admin_oku = mysql_fetch_assoc($admin_cek);
		$admin_adi = $admin_oku['adi'] . " " . $admin_oku["soyadi"];
		if (in_array(8, $parcala)) {
			if ($sınırsız_yetki == true) {
				$duzenleme_durumu = true;
			} else {
				if ($aktif_admin_id == $notlar_oku["ekleyen"]) {
					$duzenleme_durumu = true;
				} else {
					$duzenleme_durumu = false;
				}
			}
		} else {
			$duzenlenme_durumu = false;
		}
		if (in_array(9, $parcala)) {
			if ($sınırsız_yetki == true) {
				$silme_durumu = true;
			} else {
				if ($aktif_admin_id == $notlar_oku["ekleyen"]) {
					$silme_durumu = true;
				} else {
					$silme_durumu = false;
				}
			}
		} else {
			$silme_durumu = false;
		}
		if ($notlar_oku['tablo_turu'] == "prm_notlari") {
			if ($prm_oku["durum"] == 1) {
				if ($sınırsız_yetki) {
					$onayla = '<a style="color:green" href="#" >Onaylandı</a>';
					$reddet = '<a style="color:red" href="#" onclick="prm_islemi(2,' . $notlar_oku["id"] . ');" > Reddet</a>';
					$style = "style='color:green !important;' ";
				} else {
					$text = "alert('Yetkiniz yetersiz');";
					$onayla = '<a style="color:green" href="#" >Onaylandı</a>';
					$reddet = '<a style="color:red" href="#" onclick="' . $text . '"  > Reddet</a>';
					$style = "style='color:green !important;' ";
				}
			} else if ($prm_oku["durum"] == 2) {
				if ($sınırsız_yetki) {
					$onayla = '<a style="color:green" href="#"  onclick="prm_islemi(1,' . $notlar_oku["id"] . ');" >Onayla</a>';
					$reddet = '<a style="color:red" href="#" > Reddedildi</a>';
					$style = "style='color:grey !important;' ";
				} else {
					$text = "alert('Yetkiniz yetersiz');";
					$onayla = '<a style="color:green" href="#" onclick="' . $text . '" >Onayla</a>';
					$reddet = '<a style="color:red" href="#" > Reddedildi</a>';
					$style = "style='color:grey !important;' ";
				}
			} else {
				if ($sınırsız_yetki) {
					$onayla = '<a style="color:green" href="#"  onclick="prm_islemi(1,' . $notlar_oku["id"] . ');" >Onayla</a>';
					$reddet = '<a style="color:red" href="#" onclick="prm_islemi(2,' . $notlar_oku["id"] . ');" > Reddet</a>';
					$style = "style='color:red !important;' ";
				} else {
					$text = "alert('Yetkiniz yetersiz');";
					$onayla = '<a style="color:green"  href="#" onclick="' . $text . '" >Onayla</a>';
					$reddet = '<a style="color:red"  href="#" onclick="' . $text . '" > Reddet</a>';
					$style = "style='color:red !important;' ";
				}
			}
			$output .= '<tr '.$style.'>
					<td>'.date("d-m-Y H:i:s", strtotime($notlar_oku['gonderme_zamani'])).'</td>
					<td>'.$admin_adi.'</td>
					<td> </td>
					<td>'.$notlar_oku['not'].'</td>
					<td>'.$onayla." ".$reddet.'</td>
					<td></td>
					<td></td>
				</tr>
			';
		} else if ($notlar_oku['tablo_turu'] == "uye_notlari") {
			$td = "";
			$yukleme_tarihi = $notlar_oku["gonderme_zamani"];
			$admin_cek = mysql_query("select * from kullanicilar where id = '" . $notlar_oku['ekleyen'] . "'");
			$admin_oku = mysql_fetch_assoc($admin_cek);
			$admin_adi = $admin_oku['adi'] . " " . $admin_oku["soyadi"];
			$td .= "<td>";
			$gorme_durum = "";
			$evrak_yaz = "";
			if ($notlar_oku["icerik"] == 1) {
				if ($notlar_oku["gizlilik"] == 2) {
					$evrak_yaz .= $notlar_oku['not'];
					$td .= '<p style="color:black" >Dosya Yok</p>';
				} else if ($notlar_oku["gizlilik"] == 1 && $sınırsız_yetki == true) {
					$evrak_yaz .= $notlar_oku['not'];
					$td .= '<p style="color:black" >Dosya Yok</p>';
				} else if ($notlar_oku["gizlilik"] == 0) {
					if ($notlar_oku['ekleyen'] == $aktif_admin_id) {
						$evrak_yaz .= $notlar_oku['not'];
						$td .= '<p style="color:black" >Dosya Yok</p>';
					} else {
						$evrak_yaz .= "Sadece Ekleyen Admin Görebilir";
						$td .= "Sadece Ekleyen Admin Görebilir";
					}
				} else {
					$evrak_yaz .= "Yetkiniz Yetersiz";
					$td .= "Yetkiniz Yetersiz";
				}
			} else {
				if ($notlar_oku["gizlilik"] == 2) {
					$evrak_yaz .= $notlar_oku['not'];
					$evrak_grup = mysql_query("select * from uye_notlari where tarih='" . $yukleme_tarihi . "' and uye_id='" . $gelen_id . "'");
					while ($evrak_grup_oku = mysql_fetch_array($evrak_grup)) {
						if ($sayi == 0) {
							$evrak_list = $evrak_grup_oku['dosya'];
						} else {
							$evrak_list .= "," . $evrak_grup_oku['dosya'];
						}
						$td .= '<a href="../assets/' . $evrak_grup_oku['dosya'] . '" target="_blank">--' . $evrak_grup_oku['dosya'] . '</a>
						<a hidden href="../assets/' . $evrak_grup_oku['dosya'] . '" download id="user_dosya_' . $evrak_grup_oku['dosya'] . '">-' . $evrak_grup_oku['dosya'] . '</a><br/>';
						$sayi++;
					}
				} else if ($notlar_oku["gizlilik"] == 1 && $sınırsız_yetki == true) {
					$evrak_yaz .= $notlar_oku['not'];
					$evrak_grup = mysql_query("select * from uye_notlari where tarih='" . $yukleme_tarihi . "' and uye_id='" . $gelen_id . "'");
					while ($evrak_grup_oku = mysql_fetch_array($evrak_grup)) {
						if ($sayi == 0) {
							$evrak_list = $evrak_grup_oku['dosya'];
						} else {
							$evrak_list .= "," . $evrak_grup_oku['dosya'];
						}
						$td .= '<a href="../assets/' . $evrak_grup_oku['dosya'] . '" target="_blank">-*' . $evrak_grup_oku['dosya'] . '</a>
						<a hidden href="../assets/' . $evrak_grup_oku['dosya'] . '" id="user_dosya_' . $evrak_grup_oku['dosya'] . '" download>-' . $evrak_grup_oku['dosya'] . '</a><br/>';
						$sayi++;
					}
				} else if ($notlar_oku["gizlilik"] == 0) {
					if ($notlar_oku['ekleyen'] == $aktif_admin_id) {

						$evrak_yaz .= $notlar_oku['not'];
						$evrak_grup = mysql_query("select * from uye_notlari where tarih='" . $yukleme_tarihi . "' and uye_id='" . $gelen_id . "'");
						while ($evrak_grup_oku = mysql_fetch_array($evrak_grup)) {
							$td .= '<a href="../assets/' . $evrak_grup_oku['dosya'] . '" target="_blank">-**' . $evrak_grup_oku['dosya'] . '</a>
							<a hidden href="../assets/' . $evrak_grup_oku['dosya'] . '" target="_blank" id="user_dosya_' . $evrak_grup_oku['dosya'] . '" download>-' . $evrak_grup_oku['dosya'] . '</a><br/>';
							if ($sayi == 0) {
								$evrak_list = $evrak_grup_oku['dosya'];
							} else {
								$evrak_list .= "," . $evrak_grup_oku['dosya'];
							}
							$sayi++;
						}
					} else {
						$evrak_yaz .= "Sadece Ekleyen Admin Görebilir";
						$td .= "Sadece Ekleyen Admin Görebilir";
					}
				} else {
					$evrak_yaz .= "Yetkiniz Yetersiz";
					$td .= "Yetkiniz Yetersiz";
				}
			}
			if ($sayi > 0) {
				$td .= '<button type="button" onclick="user_not_indir(\'' . $evrak_list . '\');" class="button btn-primary" >Tümünü İndir</button>';
			}
			$td .= "</td>";
			if ($notlar_oku["gizlilik"] == 0) {
				$gorme_durum = "Sadece Ben";
			} else if ($notlar_oku["gizlilik"] == 1) {
				$gorme_durum = "Tam Yetkili Adminler";
			} else if ($notlar_oku["gizlilik"] == 2) {
				$gorme_durum = "Herkes Görebilir";
			}
			if ($duzenleme_durumu == true && $silme_durumu == true) {
				$output .= '
					<tr >
						<td>' . date("d-m-Y H:i:s", strtotime($notlar_oku['gonderme_zamani'])) . '</td>
						<td>' . $admin_adi . '</td>
						<td>' . $gorme_durum . '</td>
						<td>' . $evrak_yaz . '</td>
						<td><a href="?modul=uyeler&sayfa=uye_not_duzenle&id=' . $notlar_oku['id'] . '" target="_blank"> <i class="fas fa-edit"> </i> </a></td>
						<td><a href="?modul=ayarlar&sayfa=data_sil&id=' . $notlar_oku['id'] . '&q=uye_not_sil" onclick="return confirm(\'Silmek istediğinize emin misiniz ?\')" ><i class="fas fa-trash"></i></a></td>
					   ' . $td . '
					</tr>  
				';
			} else if ($duzenleme_durumu == false && $silme_durumu == true) {
				$output .= '
					<tr >
						<td>' . date("d-m-Y H:i:s", strtotime($notlar_oku['gonderme_zamani'])) . '</td>
						<td>' . $admin_adi . '</td>
						<td>' . $gorme_durum . '</td>
						<td>' . $evrak_yaz . '</td>
						<td></td>
						<td><a href="?modul=ayarlar&sayfa=data_sil&id=' . $notlar_oku['id'] . '&q=uye_not_sil" onclick="return confirm(\'Silmek istediğinize emin misiniz ?\')" ><i class="fas fa-trash"></i></a></td>
					   ' . $td . '
					</tr>  
				';
			} else if ($duzenleme_durumu == true && $silme_durumu == false) {
				$output .= '
					<tr >
						<td>'.date("d-m-Y H:i:s", strtotime($notlar_oku['gonderme_zamani'])) . '</td>
						<td>' . $admin_adi . '</td>
						<td>' . $gorme_durum . '</td>
						<td>' . $evrak_yaz . '</td>
						<td><a href="?modul=uyeler&sayfa=uye_not_duzenle&id=' . $notlar_oku['id'] . '" target="_blank"> <i class="fas fa-edit"> </i> </a></td>
						<td></td>
					   ' . $td . '
					</tr>';
			} else {
				$output .= '<tr>
					<td>'.date("d-m-Y H:i:s", strtotime($notlar_oku['gonderme_zamani'])).'</td>
					<td>' . $admin_adi . '</td>
					<td>' . $gorme_durum . '</td>
					<td>' . $evrak_yaz . '</td>
					<td></td>
					<td></td>
				   '.$td.'
				</tr>  ';
			}
		} else {
			
			$evrak_sayi_yeni = 0;
			$evrak_list = "";
			$td = "";
			$yukleme_tarihi = $notlar_oku["gonderme_zamani"];
			$evrak_yaz = "";
			$dosya = "";
			$evrak_yaz .= $notlar_oku['not'];
			$gorme_durum = "Herkes Görebilir";
			// $evrak_grup = mysql_query("select * from yuklenen_evraklar where gonderme_zamani='" . $yukleme_tarihi . "' and user_id='" . $gelen_id . "' group by gonderme_zamani");
			$evrak_grup = mysql_query("select * from yuklenen_evraklar where user_id='" . $gelen_id . "' ");
			while ($evrak_grup_oku = mysql_fetch_array($evrak_grup)) {
				$evrak_cek = mysql_query("select * from yuklenen_evrak_dosya where evrak_id = '".$evrak_grup_oku["id"]."'");
				$dosya = "";
				while($evrak_oku = mysql_fetch_array($evrak_cek)){
					$dosya .= '<a href="../assets/' . $evrak_oku['icerik'] . '" target="_blank">-' . $evrak_oku['icerik'] . '</a>
					<a hidden href="../assets/' . $evrak_oku['icerik'] . '" id="user_dosya_' . $evrak_oku['icerik'] . '" download>-' . $evrak_oku['icerik'] . '</a><br/>';
					if ($evrak_sayi_yeni == 0) {
						$evrak_list = $evrak_oku['icerik'];
					} else {
						$evrak_list .= "," . $evrak_oku['icerik'];
					}
					$evrak_sayi_yeni++;
				}
			// $evrak_grup_oku = mysql_fetch_assoc($evrak_grup);
				
				
			
			if ($evrak_sayi_yeni > 0) {
				$dosya .= '<button type="button" onclick="user_not_indir(\'' . $evrak_list . '\');" class="button btn-primary" >Tümünü İndir</button>';
			}
			if ($duzenleme_durumu == true && $silme_durumu == true) {
				$output .= '<tr>
					<td>' . date("d-m-Y H:i:s", strtotime($notlar_oku['gonderme_zamani'])) . '</td>
					<td>' . $kullanici_adi . '</td>
					<td>' . $gorme_durum . '</td>
					<td>' . $evrak_yaz . '</td>
					<td><a href="?modul=uyeler&sayfa=uye_evrak_duzenle&id=' . $notlar_oku['id'] . '"> <i class="fas fa-edit"> </i> </a></td>
					<td><a href="?modul=ayarlar&sayfa=data_sil&id=' . $notlar_oku['id'] . '&q=uye_evrak_sil" onclick="return confirm(\'Silmek istediğinize emin misiniz ?\')" ><i class="fas fa-trash"></i></a></td>
					<td>' . $dosya . '</td>
				</tr>';
			} else if ($duzenleme_durumu == false && $silme_durumu == true) {
				$output .= '<tr>
					<td>' . date("d-m-Y H:i:s", strtotime($notlar_oku['gonderme_zamani'])) . '</td>
					<td>' . $kullanici_adi . '</td>
					<td>' . $gorme_durum . '</td>
					<td>' . $evrak_yaz . '</td>
					<td></td>
					<td><a href="?modul=ayarlar&sayfa=data_sil&id=' . $notlar_oku['id'] . '&q=uye_evrak_sil" onclick="return confirm(\'Silmek istediğinize emin misiniz ?\')" ><i class="fas fa-trash"></i></a></td>
					<td>' . $dosya . '</td>
				</tr>';
			} else if ($duzenleme_durumu == true && $silme_durumu == false) {
				$output .= '<tr>
					<td>' . date("d-m-Y H:i:s", strtotime($notlar_oku['gonderme_zamani'])) . '</td>
					<td>' . $kullanici_adi . '</td>
					<td>' . $gorme_durum . '</td>
					<td>' . $evrak_yaz . '</td>
					<td><a href="?modul=uyeler&sayfa=uye_evrak_duzenle&id=' . $notlar_oku['id'] . '"> <i class="fas fa-edit"> </i> </a></td>
					<td></td>
					<td>' . $dosya . '</td>
				</tr>';
			} else {
				$output .= '<tr>
					<td>' . date("d-m-Y H:i:s", strtotime($notlar_oku['gonderme_zamani'])) . '</td>
					<td>' . $kullanici_adi . '</td>
					<td>' . $gorme_durum . '</td>
					<td>' . $evrak_yaz . '</td>
					<td></td>
					<td></td>
					<td>' . $dosya . '</td>
				</tr>';
			}
		}
		}
	}

	/*
		if($prm_say>0){
			if($prm_oku["durum"]==1){
				if($sınırsız_yetki){
					$onayla='<a style="color:green" href="#" >Onaylandı</a>';
					$reddet='<a style="color:red" href="#" onclick="prm_islemi(2,'.$prm_oku["id"].');" > Reddet</a>';
					$style="style='color:green !important;' ";
				}else{
					$text="alert('Yetkiniz yetersiz');";
					$onayla='<a style="color:green" href="#" >Onaylandı</a>';
					$reddet='<a style="color:red" href="#" onclick="'.$text.'"  > Reddet</a>';
					$style="style='color:green !important;' ";
				}
			}else if($prm_oku["durum"]==2){
				if($sınırsız_yetki){
					$onayla='<a style="color:green" href="#"  onclick="prm_islemi(1,'.$prm_oku["id"].');" >Onayla</a>';
					$reddet='<a style="color:red" href="#" > Reddedildi</a>';
					$style="style='color:grey !important;' ";
				}else{
					$text="alert('Yetkiniz yetersiz');";
					$onayla='<a style="color:green" href="#" onclick="'.$text.'" >Onayla</a>';
					$reddet='<a style="color:red" href="#" > Reddedildi</a>';
					$style="style='color:grey !important;' ";
				}
			}else{
				if($sınırsız_yetki){
					$onayla='<a style="color:green" href="#"  onclick="prm_islemi(1,'.$prm_oku["id"].');" >Onayla</a>';
					$reddet='<a style="color:red" href="#" onclick="prm_islemi(2,'.$prm_oku["id"].');" > Reddet</a>';
					$style="style='color:red !important;' ";
				}	
				else{
					$text="alert('Yetkiniz yetersiz');";
					$onayla='<a style="color:green"  href="#" onclick="'.$text.'" >Onayla</a>';
					$reddet='<a style="color:red"  href="#" onclick="'.$text.'" > Reddet</a>';
					$style="style='color:red !important;' ";
				}
			}
			 $output .= '
				<tr '.$style.'>
				   <td>'.date("d-m-Y H:i:s", strtotime($prm_oku['tarih'])).'</td>
				   <td>'.$qyaz["ad"].'</td>
				   <td> </td>
				   <td>'.$prm_oku['not'].'</td>
				   <td>'.$onayla." ".$reddet.'</td>
				   <td></td>
				   <td></td>
				</tr>  '; 
		 }
		while($uye_evraklari_oku=mysql_fetch_array($uye_evraklari)){
			$yukleme_tarihi=$uye_evraklari_oku["gonderme_zamani"];
			$td="";
			$evrak_yaz="";
			$td.="<td>";
			$evrak_yaz.=$uye_evraklari_oku['not'];
			$gorme_durum="Herkes Görebilir";
			$evrak_grup=mysql_query("select * from yuklenen_evraklar where gonderme_zamani='".$yukleme_tarihi."' and user_id='".$gelen_id."'");
			while($evrak_grup_oku=mysql_fetch_array($evrak_grup)){
				$td.='<a href="../assets/'.$uye_evraklari_oku['icerik'].'" target="_blank">-'.$uye_evraklari_oku['icerik'].'</a><br/>';
			}
			$td.="</td>";
			if($duzenleme_durumu==true && $silme_durumu==true){
				$output .= '
					<tr >
					   <td>'.date("d-m-Y H:i:s", strtotime($uye_evraklari_oku['gonderme_zamani'])).'</td>
					   <td>'.$kullanici_adi.'</td>
					   <td>'.$gorme_durum.'</td>
					   <td>'.$evrak_yaz.'</td>
					   <td><a href="?modul=uyeler&sayfa=uye_evrak_duzenle&id='.$uye_evraklari_oku['id'].'"> <i class="fas fa-edit"> </i> </a></td>
					   <td><a href="?modul=ayarlar&sayfa=data_sil&id='.$uye_evraklari_oku['id'].'&q=uye_evrak_sil" onclick="return confirm(\'Silmek istediğinize emin misiniz ?\')" ><i class="fas fa-trash"></i></a></td>
					   '.$td.'
					</tr>  
				'; 
			}else if($duzenleme_durumu==false && $silme_durumu==true){
				$output .= '
					<tr >
					   <td>'.date("d-m-Y H:i:s", strtotime($uye_evraklari_oku['gonderme_zamani'])).'</td>
					   <td>'.$kullanici_adi.'</td>
					   <td>'.$gorme_durum.'</td>
					   <td>'.$evrak_yaz.'</td>
					   <td></td>
					   <td><a href="?modul=ayarlar&sayfa=data_sil&id='.$uye_evraklari_oku['id'].'&q=uye_evrak_sil" onclick="return confirm(\'Silmek istediğinize emin misiniz ?\')" ><i class="fas fa-trash"></i></a></td>
					   '.$td.'
					</tr>  
				'; 
			}else if($duzenleme_durumu==true && $silme_durumu==false){
				$output .= '
					<tr >
					   <td>'.date("d-m-Y H:i:s", strtotime($uye_evraklari_oku['gonderme_zamani'])).'</td>
					   <td>'.$kullanici_adi.'</td>
					   <td>'.$gorme_durum.'</td>
					   <td>'.$evrak_yaz.'</td>
						<td><a href="?modul=uyeler&sayfa=uye_evrak_duzenle&id='.$uye_evraklari_oku['id'].'"> <i class="fas fa-edit"> </i> </a></td>
					   <td></td>
					   '.$td.'
					</tr>  
				'; 
			}else{
				$output .= '
					<tr >
					   <td>'.date("d-m-Y H:i:s", strtotime($uye_evraklari_oku['gonderme_zamani'])).'</td>
					   <td>'.$kullanici_adi.'</td>
					   <td>'.$gorme_durum.'</td>
					   <td>'.$evrak_yaz.'</td>
					   <td></td>
					   <td></td>
					   '.$td.'
					</tr>  
				'; 
			}
			
		 }
         while($evrak = mysql_fetch_array($evraklar)){
			$td="";
			$yukleme_tarihi=$evrak["tarih"];
            $admin_cek = mysql_query("select * from kullanicilar where id = '".$evrak['ekleyen']."'");
            $admin_oku = mysql_fetch_assoc($admin_cek);
            $admin_adi = $admin_oku['adi'];
            $td.="<td>";
            $gorme_durum="";
            $evrak_yaz="";
            if($evrak["dosya"]==1)
            {
				if($evrak["gizlilik"]==2){
				    $evrak_yaz.=$evrak['uye_notu'];
					 $td.='<p style="color:black" >Dosya Yok</p>';
				}else if($evrak["gizlilik"]==1 && $sınırsız_yetki==true ){
					$evrak_yaz.=$evrak['uye_notu'];
					 $td.='<p style="color:black" >Dosya Yok</p>';
				}else if($evrak["gizlilik"]==0 ){
					if($evrak['ekleyen']==$aktif_admin_id){
						$evrak_yaz.=$evrak['uye_notu'];
						 $td.='<p style="color:black" >Dosya Yok</p>';
					}else{
						$evrak_yaz.="Sadece Ekleyen Admin Görebilir";
						$td.="Sadece Ekleyen Admin Görebilir";
					}
				}else{
					$evrak_yaz.="Yetkiniz Yetersiz";
				    $td.="Yetkiniz Yetersiz";
				}
            }
            else {
			   if($evrak["gizlilik"]==2){
				    $evrak_yaz.=$evrak['uye_notu'];
					$evrak_grup=mysql_query("select * from uye_notlari where tarih='".$yukleme_tarihi."' and uye_id='".$gelen_id."'");
					while($evrak_grup_oku=mysql_fetch_array($evrak_grup)){
						$td.=' <a href="../assets/'.$evrak_grup_oku['dosya'].'" target="_blank">-'.$evrak_grup_oku['dosya'].'</a><br/>';
					}
				}else if($evrak["gizlilik"]==1 && $sınırsız_yetki==true ){
					$evrak_yaz.=$evrak['uye_notu'];
					$evrak_grup=mysql_query("select * from uye_notlari where tarih='".$yukleme_tarihi."' and uye_id='".$gelen_id."'");
					while($evrak_grup_oku=mysql_fetch_array($evrak_grup)){
						$td.=' <a href="../assets/'.$evrak_grup_oku['dosya'].'" target="_blank">-'.$evrak_grup_oku['dosya'].'</a><br/>';
					}
				}else if($evrak["gizlilik"]==0 ){
					if($evrak['ekleyen']==$aktif_admin_id){
						$evrak_yaz.=$evrak['uye_notu'];
						$evrak_grup=mysql_query("select * from uye_notlari where tarih='".$yukleme_tarihi."' and uye_id='".$gelen_id."'");
						while($evrak_grup_oku=mysql_fetch_array($evrak_grup)){
							$td.=' <a href="../assets/'.$evrak_grup_oku['dosya'].'" target="_blank">-'.$evrak_grup_oku['dosya'].'</a><br/>';
						}
					}else{
						$evrak_yaz.="Sadece Ekleyen Admin Görebilir";
						$td.="Sadece Ekleyen Admin Görebilir";
					}
				}else{
					$evrak_yaz.="Yetkiniz Yetersiz";
				    $td.="Yetkiniz Yetersiz";
				}
            }
			$td.="</td>";
			if($evrak["gizlilik"]==0)
            {
                $gorme_durum="Sadece Ben";
            }
            else if($evrak["gizlilik"]==1)
            {
               $gorme_durum="Tam Yetkili Adminler";
            }
            else if($evrak["gizlilik"]==2)
            {
               $gorme_durum="Herkes Görebilir";
            }
			if($duzenleme_durumu==true && $silme_durumu==true){
				$output .= '
					<tr >
						<td>'.date("d-m-Y H:i:s", strtotime($evrak['tarih'])).'</td>
						<td>'.$admin_adi.'</td>
						<td>'.$gorme_durum.'</td>
						<td>'.$evrak_yaz.'</td>
						<td><a href="?modul=uyeler&sayfa=uye_not_duzenle&id='.$evrak['id'].'"> <i class="fas fa-edit"> </i> </a></td>
						<td><a href="?modul=ayarlar&sayfa=data_sil&id='.$evrak['id'].'&q=uye_not_sil" onclick="return confirm(\'Silmek istediğinize emin misiniz ?\')" ><i class="fas fa-trash"></i></a></td>
					   '.$td.'
					</tr>  
				'; 
			} else if($duzenleme_durumu==false && $silme_durumu==true){
				$output .= '
					<tr >
						<td>'.date("d-m-Y H:i:s", strtotime($evrak['tarih'])).'</td>
						<td>'.$admin_adi.'</td>
						<td>'.$gorme_durum.'</td>
						<td>'.$evrak_yaz.'</td>
						<td></td>
						<td><a href="?modul=ayarlar&sayfa=data_sil&id='.$evrak['id'].'&q=uye_not_sil" onclick="return confirm(\'Silmek istediğinize emin misiniz ?\')" ><i class="fas fa-trash"></i></a></td>
					   '.$td.'
					</tr>  
				'; 
			}else if($duzenleme_durumu==true && $silme_durumu==false){
				$output .= '
					<tr >
						<td>'.date("d-m-Y H:i:s", strtotime($evrak['tarih'])).'</td>
						<td>'.$admin_adi.'</td>
						<td>'.$gorme_durum.'</td>
						<td>'.$evrak_yaz.'</td>
						<td><a href="?modul=uyeler&sayfa=uye_not_duzenle&id='.$evrak['id'].'"> <i class="fas fa-edit"> </i> </a></td>
						<td></td>
					   '.$td.'
					</tr>  
				'; 
			}else{
				$output .= '
				<tr>
					<td>'.date("d-m-Y H:i:s", strtotime($evrak['tarih'])).'</td>
					<td>'.$admin_adi.'</td>
					<td>'.$gorme_durum.'</td>
					<td>'.$evrak_yaz.'</td>
					<td></td>
					<td></td>
				   '.$td.'
				</tr>  '; 
			}
         } 
          */
	$output .= '</tbody></table>';
	$output .= '</table>';
	$output .= "<script>
		function uye_not_ekle(id){
			var formData = new FormData(document.getElementById('form'));
			var gizlilik = $('#gizlilik').val();
			var eklenecek_not = $('#eklenecek_not').val();
			formData.append('action', 'uye_notu_kaydet');
			formData.append('gelen_id', id);
			formData.append('gizlilik', gizlilik);
			formData.append('eklenecek_not', eklenecek_not);
			var filesLength=document.getElementById('uye_not_files').files.length;
			for(var i=0;i<filesLength;i++){
				formData.append('file[]', document.getElementById('uye_not_files').files[i]);
			}
			$.ajax({
				url: 'https://ihale.pertdunyasi.com/action.php',
				type: 'POST',
				data: formData,
				dataType: 'json',
				success: function(response) {
					if(response.status==200){
						openToastrSuccess(response.message);
						$('#uyenin_notlari_close').trigger('click');
						var text='<a id=\''+id+'\' class=\'view_notlari\'><i class=\'fas fa-align-left\'>'+response.toplam_not+'</i></a>';
						$('#td_view_notlari_'+id).html(text);
					}else{
						openToastrDanger(response.message);
					}
				},
				cache: false,
				contentType: false,
				processData: false
			});
		 }
		</script>";
	echo $output;
}
?>

<script>
	async function user_not_indir(ids) {
		var split = ids.split(",");
		var count = 0;
		for (var i = 0; i < split.length; i++) {
			document.getElementById("user_dosya_" + split[i]).click();
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

<script>
	// Not Ekleme
	function notuKaydet() {
		var eklenecek_not = $('#eklenecek_not').val();
		var file = $('#files').val();
		var gelen_id = $('#gelen_id').val();
		var gizlilik = $('#gizlilik').val();
		var $baseUrl = "https://ihale.pertdunyasi.com/panel/sayfalar/uyeler/";
		if (gelen_id) {
			jQuery.ajax({
				url: $baseUrl + 'not_gonder.php',
				type: "POST",
				dataType: "JSON",
				data: {
					eklenecek_not: eklenecek_not,
					file: file,
					gelen_id: gelen_id,
					gizlilik: gizlilik,
				},
				success: function(data) {
					console.log(data);
					$('.success').removeClass('d-none').html(data);
					//alert("İşlem başarılı");  
				},
				error: function(data) {
					$('.error').removeClass('d-none').html(data);
					alert('HATA! Lütfen tekrar deneyiniz.')
				}
			});
		}
	}

	function prm_islemi(durum, id) {
		var $baseUrl = "https://ihale.pertdunyasi.com/panel/sayfalar/uyeler/";
		jQuery.ajax({
			url: $baseUrl + 'not_gonder.php',
			type: "POST",
			dataType: "JSON",
			data: {
				action: "prm_islem",
				durum: durum,
				id: id
			},
			success: function(data) {
				console.log(data);
				if (data.status == 200) {
					alert("İşlem başarılı");
					location.reload();
				}
			},
			error: function(data) {}
		});
	}
</script>