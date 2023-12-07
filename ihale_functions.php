<?php 
include 'ayar.php';
function sigorta_adi_getir($id){
    $cek = mysql_query("select * from sigorta_ozellikleri where id = '".$id."'");
    $oku = mysql_fetch_object($cek);
    return $oku->sigorta_adi;
}

function ilan_marka_adi($id){
    $cek = mysql_query("select * from marka where markaID = '".$id."'");
    $oku = mysql_fetch_object($cek);
    return $oku->marka_adi;
}

function arac_durumu_getir($id){
    if($id == 1){
        return "Kazalı (En Ufak Bir Onarım Görmemiş)";
    }elseif($id == 2){
        return "Kazalı (Hafif onarımlar yapılmış halk ağzıyla makyajlı)";
    }elseif($id == 3){
        return "İkinci El (Pert Kayıtlı)";
    }elseif($id == 4){
        return "İkinci El (Pert Kayıtsız)";
    }
}

function uye_teklif_durum_getir($uye_id,$ilan_id){
    $cek = mysql_query("select * from teklifler where ilan_id = '".$ilan_id."' and uye_id = '".$uye_id."' and durum = 1 order by teklif_zamani desc");
    $teklif_sayi = mysql_num_rows($cek);
    $oku = mysql_fetch_object($cek);
    $listingMap[] = [
        "teklif_sayi" => $teklif_sayi,
        "teklif" => $oku->teklif
    ];
    return $listingMap;
}

function ilan_bildirim_kontrol($uye_id,$ilan_id){
    $cek = mysql_query("select * from bildirimler where ilan_id = '".$ilan_id."' and uye_id = '".$uye_id."'");
    return mysql_num_rows($cek);
}

function ilan_favori_kontrol($uye_id,$ilan_id){
    $cek = mysql_query("select * from favoriler where ilan_id = '".$ilan_id."' and uye_id = '".$uye_id."'");
    return mysql_num_rows($cek);
}

function ilan_resimleri_getir($ilan_id){
    $cek = mysql_query("select * from ilan_resimler where ilan_id = '".$ilan_id."'");
    while($oku = mysql_fetch_object($cek)){
        $listingMap[] = [
            "id" => $oku->id,
            "ilan_id" => $oku->ilan_id,
            "base_resim" => $oku->resim,
            "resim" => "images/".$oku->resim,
            "durum" => $oku->durum
        ];
    }
    return $listingMap;
}


function ihaledeki_araclar_ugur($uye_id,$offset,$sayfada){
    $cek = mysql_query("SELECT *,concat(ihale_tarihi,' ',ihale_saati) as ihale_son FROM ilanlar WHERE ihale_son_gosterilme >= '".date("Y-m-d H:i:s")."'ORDER BY ihale_son ASC LIMIT $offset, $sayfada");
    while($oku = mysql_fetch_object($cek)){        
        $listingMap[] = [
            "id" => $oku->id,
            "plaka" => $oku->plaka,
            "arac_kodu" => $oku->arac_kodu,
            "hesaplama" => $oku->hesaplama,
            "sigorta" => $oku->sigorta,
            "sigorta_adi" => sigorta_adi_getir($oku->sigorta),
            "marka" => $oku->marka,
            "marka_adi" => ilan_marka_adi($oku->marka),
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
            "ihale_kapanis" => $oku->ihale_tarihi." ".$oku->ihale_saati,
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
            "ihale_turu" => $oku->ihale_turu,
            "vites_tipi" => $oku->vites_tipi,
            "yakit_tipi" => $oku->yakit_tipi,
            "sistem_sure_uzatma_durumu" => $oku->sistem_sure_uzatma_durumu,
            "arac_durumu_id" => $oku->arac_durumu,
            "arac_durumu" => arac_durumu_getir($oku->arac_durumu),
            "ihale_son_gosterilme" => $oku->ihale_son_gosterilme,
            "uye_teklif_durum" => uye_teklif_durum_getir($uye_id,$oku->id),
            "bildirim" => ilan_bildirim_kontrol($uye_id,$oku->id),
            "favori" => ilan_favori_kontrol($uye_id,$oku->id),
            "resim" => ilan_resimleri_getir($oku->id),
            "sigorta_ozellik" => ilan_sigorta_ozellikleri($oku->sigorta,$uye_id)
        ];
    }
    return $listingMap;
}

function ilan_sigorta_ozellikleri($sigorta_id,$uye_id){
    $uye_cek = mysql_query("select * from user where id = '".$uye_id."'");
    $uye_oku = mysql_fetch_object($uye_cek);
    $paket = $uye_oku->paket;
    $cek = mysql_query("select * from sigortalar where sigorta_id = '".$sigorta_id."' and paket_id = '".$paket."'");
    $oku = mysql_fetch_object($cek);
    $ozellik_cek = mysql_query("select * from sigorta_ozellikleri where id = '".$sigorta_id."'");
    $ozellik_oku = mysql_fetch_object($ozellik_cek);
    $listingMap[] = [
        "paket_id" => $paket,
        "sigorta_id" => $sigorta_id,
        "uye_id" => $uye_id,
        "secilen_yetki_id" => $oku->secilen_yetki_id,
        "detay_gorur" => $oku->detay_gorur,
        "minumum_artis" => $ozellik_oku->minumum_artis,        
        "bu_sure_altinda_teklif" => $ozellik_oku->bu_sure_altinda_teklif,        
    ];
    return $listingMap;
}




$ilan = ihaledeki_araclar_ugur(284,0,100);
// prear($ilan);

/*
$sayac = 0;
for($i=0;$i<count($ilan);$i++){
    if($ilan[$i]["favori"] == 1){
        $fav_color = "orange";
        $fav_title = "Araç favorilerinizden kaldırılacaktır";
    }else{
        $fav_color = "gray";
        $fav_title = "Araç favorilerinize eklenecektir";
    }
    if($ilan[$i]["bildirim"] == 1){
        $bidlirim_color = "orange";
        $bildirim_title = "Araç bildirimi kapatılacaktır";
    }else{
        $bidlirim_color = "gray";
        $bildirim_title = "Araç favorilerinize açılacaktır";
    }

    $ilanlar .= '';
}
*/






?>