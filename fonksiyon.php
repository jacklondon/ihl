<?php
//include 'ayar.php';
function select_sql($table_name, $query = null)
{
    $deneme = array();
    $select = mysql_query("SELECT `COLUMN_NAME` 
          FROM `INFORMATION_SCHEMA`.`COLUMNS` 
          WHERE `TABLE_SCHEMA`='pert_dunyasi' 
               AND `TABLE_NAME`='" . $table_name . "' ");

    while ($veri_cek = mysql_fetch_array($select)) {
        array_push($deneme, $veri_cek["COLUMN_NAME"]);
    }

    if ($query != null) {
        $status_query = " WHERE " . $query;
    }

    $counter = 0;
    $listingMap = array();
    $select2 = mysql_query("SELECT * FROM " . $table_name . $status_query);
    while ($veri_cek2 = mysql_fetch_array($select2)) {
        for ($i = 0; $i < count($deneme); $i++) {
            $listingMap[$counter][$deneme[$i]] = $veri_cek2[$deneme[$i]];
        }

        $counter++;
    }

    return $listingMap;
}

function ilan_favori_kontrol($uye_id,$ilan_id){
    $cek = mysql_query("SELECT * FROM favoriler WHERE uye_id = '".$uye_id."' AND ilan_id = '".$ilan_id."'");
    if(mysql_num_rows($cek) == 0){
        $listingMap[] = [
            "fav_durum" => 0,
            "color" => "gray",
            "title" => "Araç favorilerinize eklenecektir"
        ];
    }else{
        $listingMap[] = [
            "fav_durum" => 1,
            "color" => "orange",
            "title" => "Araç favorilerinizden kaldırılacaktır"
        ];
    }
    return $listingMap;
}

function ilan_bildirim_kontrol($uye_id,$ilan_id){
    $cek = mysql_query("select * from bildirimler where uye_id = '".$uye_id."' and ilan_id = '".$ilan_id."'");
    if(mysql_num_rows($cek) == 0){
        $listingMap[] = [
            "fav_durum" => 0,
            "color" => "gray",
            "title" => "Araç bildirimi açılacaktır."
        ];
    }else{
        $listingMap[] = [
            "fav_durum" => 1,
            "color" => "orange",
            "title" => "Araç bildirimi kapatılacaktır."
        ];
    }
    return $listingMap;
}

function ilan_blink_class($ilan_id)
{
    $ilan = select_sql("ilanlar","id = '".$ilan_id."'");
    if($ilan[0]["profil"] == "Hurda Belgeli"){
        return "blink";
    }else{
        return "";
    }
}

function ihaledeki_araclar($offset, $sayfada)
{
    $cek = mysql_query("SELECT *,concat(ihale_tarihi,' ',ihale_saati) as ihale_son FROM ilanlar WHERE ihale_son_gosterilme>'" . date("Y-m-d H:i:s") . "' ORDER BY ihale_son ASC LIMIT $offset, $sayfada");
    $uye_cek = mysql_query("SELECT * FROM user WHERE user_token = '".$_SESSION['u_token']."' or kurumsal_token = '".$_SESSION["k_token"]."'");
    $uye_oku = mysql_fetch_object($uye_cek);
    $uye_id = $uye_oku->id;
    while ($oku = mysql_fetch_object($cek)) {        
        $listingMap[] = [
            "id" => $oku->id,
            "plaka" => $oku->plaka,
            "arac_kodu" => $oku->arac_kodu,
            "hesaplama" => $oku->hesaplama,
            "sigorta" => $oku->sigorta,
            "marka_id" => $oku->marka,
            "marka" => select_sql("marka","markaID = '".$oku->marka."'")[0]["marka_adi"],
            "model" => $oku->model,
            "tip" => $oku->tip,
            "model_yili" => $oku->model_yili,
            "piyasa_degeri" => $oku->piyasa_degeri,
            "tsrsb_degeri" => $oku->tsrsb_degeri,
            "acilis_fiyati" => $oku->acilis_fiyati,
            "son_teklif" => $oku->son_teklif,
            "profil" => $oku->profil,
            "sehir" => $oku->sehir,
            "ilce" => $oku->ilce,
            "ihale_tarihi" => $oku->ihale_tarihi,
            "ihale_saati" => $oku->ihale_saati,
            "pd_hizmet" => $oku->pd_hizmet,
            "otopark_giris" => $oku->otopark_giris,
            "otopark_ucreti" => $oku->otopark_ucreti,
            "cekici_ucreti" => $oku->cekici_ucreti,
            "dosya_masrafi" => $oku->dosya_masrafi,
            "link" => $oku->link,
            "kilometre" => $oku->kilometre,
            "uyari_notu" => $oku->uyari_notu,
            "hasar_bilgileri" => $oku->hasar_bilgileri,
            "notlar" => $oku->notlar,
            "adres" => $oku->adres,
            "donanimlar" => $oku->donanimlar,
            "vitrin" => $oku->vitrin,
            "eklenme_zamani" => $oku->eklenme_zamani,
            "ilan_url" => $oku->ilan_url,
            "ihale_sahibi" => $oku->ihale_sahibi,
            "ihale_acilis" => $oku->ihale_acilis,
            "durum" => $oku->durum,
            "ihale_turu" => $oku->ihale_turu,
            "vites_tipi" => $oku->vites_tipi,
            "yakit_tipi" => $oku->yakit_tipi,
            "sistem_sure_uzatma_durumu" => $oku->sistem_sure_uzatma_durumu,
            "arac_durumu" => $oku->arac_durumu,
            "ihale_son_gosterilme" => $oku->ihale_son_gosterilme,
            "uye_id" => $uye_id,
            "ilan_favori_kontrol" => ilan_favori_kontrol($uye_id,$oku->id),
            "ilan_bildirim_kontrol" => ilan_bildirim_kontrol($uye_id,$oku->id),
            "blink" => ilan_blink_class($oku->id),
        ];
    }
}
