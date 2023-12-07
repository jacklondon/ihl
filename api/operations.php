<?php

use function PHPSTORM_META\map;

include_once '../ayar.php';
header("Content-Type: application/json");
header('Access-Control-Allow-Origin: *');
$response = [];
$statusCode = 404;
//Faruk Aksungur

//Sigorta Şirketine Göre ilan Verileri Function Begın
function sigorta_sirketine_gore_ilan_ozellikleri($ilan_id, $paket_id)
{
    $ilan_verileri = mysql_query("Select * from ilanlar where id='" . $ilan_id . "'");
    $ilan_sigorta_sirketi = mysql_fetch_assoc($ilan_verileri);
    $ilan_sigortasi = $ilan_sigorta_sirketi["sigorta"];

    $sigorta_sirketi_ozellikleri = mysql_query("Select * from sigortalar where sigorta_id='" . $ilan_sigortasi . "' and paket_id='" . $paket_id . "'");
    // var_dump("Select * from sigortalar where sigorta_id='" . $ilan_sigortasi . "' and paket_id='" . $paket_id . "'");
    $ozellikleri_cek = mysql_fetch_assoc($sigorta_sirketi_ozellikleri);

    $detay_gorme = $ozellikleri_cek["detay_gorur"];
    $secilen_yetki = $ozellikleri_cek["secilen_yetki_id"];

    $uye_grubu_yetkileri = mysql_query("Select * from uye_grubu_yetkiler where id='" . $secilen_yetki . "'");
    $uye_grubu_verileri = mysql_fetch_assoc($uye_grubu_yetkileri);

    $yetki = $uye_grubu_verileri["id"];
    $arac_gorme_durumu = "";

    if ($yetki == 1) {
        $arac_gorme_durumu = "Göremez";
        $listingMap[] = [
            "arac_gorme_durumu" => $arac_gorme_durumu,
            "detay_gorme_durumu" => $detay_gorme,
        ];
    }
    if ($yetki == 2) {
        $arac_gorme_durumu = "Listede";
        $listingMap[] = [
            "arac_gorme_durumu" => $arac_gorme_durumu,
            "detay_gorme_durumu" => $detay_gorme,
        ];
    }
    if ($yetki == 3) {
        $arac_gorme_durumu = "Tamamen";
        $listingMap[] = [
            "arac_gorme_durumu" => $arac_gorme_durumu,
            "detay_gorme_durumu" => $detay_gorme,
        ];
    }

    return $listingMap;
}
//Sigorta Şirketine Göre ilan Verileri Function End

//Kullanici Cek Function Begın
function kullanici_veri_cek($token)
{
    $user = mysql_fetch_object(mysql_query("Select * from user where user_token='" . $token . "'"));
    if ($user) {
        $statusCode = 200;
        $veriler[] = [
            "message" => "Kullanici Getirildi.",
            "kullanici_id" => $user->id,
            "kullanici_adi" => $user->ad,
            "kullanici_soyadi" => $user->soyad,
            "kullanici_tc" => $user->tc_kimlik,
            "kullanici_uye_sebep" => $user->uye_olma_sebebi,
            "kullanici_cinsiyet" => null_sorgulama_string($user->cinsiyet),
            "kullanici_mail" => $user->mail,
            "kullanici_telefon" => $user->telefon,
            "kullanici_sabit_tel" => $user->sabit_tel,
            "kullanici_sehir" => $user->sehir,
            "kullanici_ilce" => null_sorgulama_string(ilce_duzenli_getir($user->ilce)),
            "kullanici_meslek" => null_sorgulama_string($user->meslek),
            "kullanici_adres" => $user->adres,
            "kullanici_kargo_adresi" => $user->kargo_adresi,
            "kullanici_fatura_adresi" => $user->fatura_adresi,
            "kullanici_paket" => $user->paket,
            "kullanici_unvan" => $user->unvan,
            "kullanici_vergi_dairesi" => $user->vergi_dairesi,
            "kullanici_vergi_dairesi_no" => $user->vergi_dairesi_no,
            "kullanici_temsilci_id" => $user->temsilci_id,
            "kullanici_kayit_tarihi" => $user->kayit_tarihi,
            "kullanici_yedek_kisi" => $user->yedek_kisi,
            "kullanici_yedek_kisi_tel" => $user->yedek_kisi_tel,
            "kullanici_ilgilendigi_turler" => $user->ilgilendigi_turler,
            "kullanici_tip" => "bireysel",
            "status" => $statusCode
        ];
        return $veriler;
    } else {
        $user = mysql_fetch_object(mysql_query("Select * from user where kurumsal_user_token='" . $token . "'"));
        $statusCode = 200;
        $veriler[] = [
            "message" => "Kullanici Getirildi.",
            "kullanici_id" => $user->id,
            "kullanici_adi" => $user->ad,
            "kullanici_soyadi" => $user->soyad,
            "kullanici_tc" => $user->tc_kimlik,
            "kullanici_uye_sebep" => $user->uye_olma_sebebi,
            "kullanici_cinsiyet" => $user->cinsiyet,
            "kullanici_mail" => $user->mail,
            "kullanici_telefon" => $user->telefon,
            "kullanici_sabit_tel" => $user->sabit_tel,
            "kullanici_sehir" => $user->sehir,
            "kullanici_ilce" => $user->ilce,
            "kullanici_meslek" => $user->meslek,
            "kullanici_adres" => $user->adres,
            "kullanici_kargo_adresi" => $user->kargo_adresi,
            "kullanici_fatura_adresi" => $user->fatura_adresi,
            "kullanici_paket" => $user->paket,
            "kullanici_unvan" => $user->unvan,
            "kullanici_vergi_dairesi" => $user->vergi_dairesi,
            "kullanici_vergi_dairesi_no" => $user->vergi_dairesi_no,
            "kullanici_temsilci_id" => $user->temsilci_id,
            "kullanici_kayit_tarihi" => $user->kayit_tarihi,
            "kullanici_yedek_kisi" => $user->yedek_kisi,
            "kullanici_yedek_kisi_tel" => $user->yedek_kisi_tel,
            "kullanici_ilgilendigi_turler" => $user->ilgilendigi_turler,
            "kullanici_tip" => "kurumsal",
            "status" => $statusCode
        ];

        return $veriler;
    }
}
//Kullanici Cek Function End

function null_sorgulama_int($veri)
{
    $sifir = "0";
    if ($veri === null || $veri === " ") {
        return $sifir;
    } else {
        return $veri;
    }
}

function null_sorgulama_string($veri)
{
    $bosluk = "";
    if ($veri == null || $veri == " ") {
        return $bosluk;
    } else {
        return $veri;
    }
}



//İlanlari Cek Function Begın
function ilanlari_cek($uye_paket_id, $durum, $limit = 20,$user_token)
{
    $kullanici_grubu=kullanici_grubu_cek($user_token);
    $cek = mysql_query("select * from user where user_token = '".$user_token."' or kurumsal_user_token = '".$user_token."'");
    $oku = mysql_fetch_object($cek);
    $uye_id = $oku->id;
    if($user_token != ""){
        $paket_id = $oku->paket;
    }else{
        $paket_id = 2;
    }

    $base_url_img = 'https://ihale.pertdunyasi.com/images/';
    // $ilanlari_cek = mysql_query("Select * from ilanlar limit  $limit");
    $ilanlari_cek = mysql_query("SELECT *,concat(ihale_tarihi,' ',ihale_saati) as ihale_son FROM ilanlar WHERE durum = '".$durum."' AND
    ihale_son_gosterilme >= '".date("Y-m-d H:i:s")."'ORDER BY ihale_son ASC limit  $limit");
    while ($ilanlari_bas = mysql_fetch_array($ilanlari_cek)) {
        $ilan_id = $ilanlari_bas["id"];

        $uye_teklif_cek = mysql_query("select * from teklifler where ilan_id = '".$ilan_id."' and uye_id = '".$uye_id."' and durum = 1 order by teklif_zamani desc limit 1");
        $uye_teklif_oku = mysql_fetch_object($uye_teklif_cek);
        if(mysql_num_rows($uye_teklif_cek) != 0){
            $son_teklifim = money($uye_teklif_oku->teklif)." ₺ teklif verdiniz";
        }else{
            $son_teklifim = "Henüz teklif vermediniz";
        }

        $veri = sigorta_sirketine_gore_ilan_ozellikleri($ilan_id, $paket_id);
        $detay = $veri[0];
        $arac_gorme_durumu = $detay["arac_gorme_durumu"];
        $listingMap[] = [
            "ilan_id" => $ilanlari_bas["id"],
            "ilan_plaka" => null_sorgulama_string($ilanlari_bas["plaka"]),
            "ilan_arac_kodu" => null_sorgulama_string($ilanlari_bas["arac_kodu"]),
            "ilan_hesaplama" => $ilanlari_bas["hesaplama"],
            "ilan_sigorta" => $ilanlari_bas["sigorta"],
            "ilan_marka" => arac_marka($ilanlari_bas["marka"]),
            "ilan_model" => null_sorgulama_string($ilanlari_bas["model"]),
            "ilan_tip" => null_sorgulama_string($ilanlari_bas["tip"]),
            "ilan_model_yili" => null_sorgulama_int($ilanlari_bas["model_yili"]),
            "ilan_piyasa_degeri" => null_sorgulama_int(fiyat_formatla($ilanlari_bas["piyasa_degeri"])),
            "ilan_tsrsb_degeri" => null_sorgulama_int(fiyat_formatla($ilanlari_bas["tsrsb_degeri"])),
            "ilan_plaka" => null_sorgulama_string($ilanlari_bas["plaka"]),
            "ilan_acilis_fiyati" => null_sorgulama_int(fiyat_formatla($ilanlari_bas["acilis_fiyati"])),
            "ilan_son_teklif" => fiyat_formatla($ilanlari_bas["son_teklif"]),
            "ilan_son_teklif_duzensiz" => $ilanlari_bas["son_teklif"],
            "ilan_profil" => $ilanlari_bas["profil"],
            "ilan_sehir" => $ilanlari_bas["sehir"],
            "ilan_ilce" => $ilanlari_bas["ilce"],
            "ilan_ihale_tarihi" => tarih_formatla($ilanlari_bas["ihale_tarihi"]),
            "ilan_ihale_saati" => $ilanlari_bas["ihale_saati"],
            "ilan_pd_hizmet" => $ilanlari_bas["pd_hizmet"],
            "ilan_otopark_ucreti" => fiyat_formatla($ilanlari_bas["otopark_ucreti"]),
            "ilan_otopark_giris" => tarih_formatla($ilanlari_bas["otopark_giris"]),
            "ilan_cekici_ucreti" => null_sorgulama_int(fiyat_formatla($ilanlari_bas["cekici_ucreti"])),
            "ilan_dosya_masrafi" => null_sorgulama_int(fiyat_formatla($ilanlari_bas["dosya_masrafi"])),
            "ilan_link" => $ilanlari_bas["link"],
            "ilan_kilometre" => $ilanlari_bas["kilometre"],
            "ilan_uyari_notu" => $ilanlari_bas["uyari_notu"],
            "ilan_hasar_bilgileri" => $ilanlari_bas["hasar_bilgileri"],
            "ilan_notlar" => null_sorgulama_string($ilanlari_bas["notlar"]),
            "ilan_adres" => null_sorgulama_string($ilanlari_bas["adres"]),
            "ilan_donanimlar" => $ilanlari_bas["donanimlar"],
            "ilan_vitrin" => $ilanlari_bas["vitrin"],
            "ilan_eklenme_zamani" => tarih_formatla($ilanlari_bas["eklenme_zamani"]),
            "ilan_url" => $ilanlari_bas["url"],
            "ilan_ihale_sahibi" => $ilanlari_bas["ihale_sahibi"],
            "ilan_ihale_acilis" => tarih_formatla($ilanlari_bas["ihale_acilis"]),
            "ilan_fotografi" => $base_url_img . ilan_foto_cek($ilanlari_bas["id"]),
            "ilan_ihale_turu" => $ilanlari_bas["ihale_turu"],
            "ihale_tipi" => $ilanlari_bas["ihale_turu"],
            "ilan_durum" => $ilanlari_bas["durum"],
            "ilan_gorme_durumu" => $arac_gorme_durumu,
            "ilan_detay_gorme_durumu" => $detay["detay_gorme_durumu"],
            "ilan_komisyonu" => ilan_komisyon($ilanlari_bas["id"]),
            "reklamlar" => response(reklamlar()),
            "sigorta_sirket_ozellikleri" => sigorta_sirketleri_verileri($ilanlari_bas["sigorta"]),
            "duzensiz_tarih" => sayac_tarih_formatla($ilanlari_bas["ihale_tarihi"]),
            "son_teklifim" => $son_teklifim
        ];
    }
    return ($listingMap);
} //İlanlari Cek Function End


//Tablo Dolu mu Function Begın

function tablocheck($tablo_adi, $user_token = "", $uye_tip)
{
    if ($uye_tip == "bireysel") {
        $sql =  mysql_query("SELECT * FROM $tablo_adi");
        $field_names = array();
        while ($field = mysql_fetch_field($sql)) {

            $field_names[] = $field;
            $say = count($field_names);
        }
        $bos = 0;
        for ($i = 0; $i < $say; $i++) {
            $sutun_adi = $field_names[$i]->name;
            $tablo_kontol_et = mysql_query("Select * from $tablo_adi where user_token='" . $user_token . "'");
            $tabloyu_cek = mysql_fetch_assoc($tablo_kontol_et);
            if (empty($tabloyu_cek[$sutun_adi])) {
                $bos++;
            }
        }
        return $bos;
    }
}
if ($uye_tip == "kurumsal") {
    $sql =  mysql_query("SELECT * FROM $tablo_adi");
    $field_names = array();
    while ($field = mysql_fetch_field($sql)) {

        $field_names[] = $field;
        $say = count($field_names);
    }
    $bos = 0;
    for ($i = 0; $i < $say; $i++) {
        $sutun_adi = $field_names[$i]->name;
        $tablo_kontol_et = mysql_query("Select * from $tablo_adi where kurumsal_user_token='" . $user_token . "'");
        $tabloyu_cek = mysql_fetch_assoc($tablo_kontol_et);
        if (empty($tabloyu_cek[$sutun_adi])) {
            $bos++;
        }
    }
    return $bos;
}
//Tablo Dolu mu Function End

//İlan Komisyon Function Begın
function ilan_komisyon($ilan_id)
{
    $komisyon_tutari = mysql_query("Select * from ilan_komisyon where ilan_id='" . $ilan_id . "'");
    $komisyon_verisi_cek = mysql_fetch_assoc($komisyon_tutari);

    return fiyat_formatla($komisyon_verisi_cek["toplam"]);
}
//İlan Komisyon Function End

//Sigorta Şirketleri Mesajları Function Begın

function sigorta_sirketleri_verileri($sigorta_id)
{
    $sigorta_sirketleri_verileri = mysql_query("Select * from sigorta_ozellikleri where id='" . $sigorta_id . "'");
    while ($sigorta_verileri = mysql_fetch_array($sigorta_sirketleri_verileri)) {
        $listingMap[] = [
            "hizli_teklif_1" => $sigorta_verileri["hizli_teklif_1"],
            "hizli_teklif_2" => $sigorta_verileri["hizli_teklif_2"],
            "hizli_teklif_3" => $sigorta_verileri["hizli_teklif_3"],
            "hizli_teklif_4" => $sigorta_verileri["hizli_teklif_4"],
            "minumum_artis" => $sigorta_verileri["minumum_artis"],
            "sigorta_uyari_notu" => $sigorta_verileri["uyari_notu"],
            "sigorta_aciklamasi" => $sigorta_verileri["sigorta_aciklamasi"],
            "sigorta_dosya_masrafi" => $sigorta_verileri["sigorta_dosya_masrafi"],
            "sigorta_teklif_iletme_mesajı" => $sigorta_verileri["teklif_iletme_mesaji"]
        ];
    }

    return $listingMap;
}



//Sigorta Şirketleri Mesajları Function End

//Özel İlan cek Function Begın
function ilan_cek($uye_paket_id, $ilan_id)
{
    $base_url_img = 'https://ihale.pertdunyasi.com/images/';
    $ilanlari_cek = mysql_query("Select * from ilanlar where id='" . $ilan_id . "'");
    while ($ilanlari_bas = mysql_fetch_array($ilanlari_cek)) {

        $veri = sigorta_sirketine_gore_ilan_ozellikleri($ilan_id, $uye_paket_id);
        $detay = $veri[0];
        $arac_gorme_durumu = $detay["arac_gorme_durumu"];

        $listingMap[] = [
            "ilan_id" => $ilanlari_bas["id"],
            "ilan_plaka" => $ilanlari_bas["plaka"],
            "ilan_arac_kodu" => $ilanlari_bas["arac_kodu"],
            "ilan_hesaplama" => $ilanlari_bas["hesaplama"],
            "ilan_sigorta" => $ilanlari_bas["sigorta"],
            "ilan_marka" => arac_marka($ilanlari_bas["marka"]),
            "ilan_model" => $ilanlari_bas["model"],
            "ilan_tip" => $ilanlari_bas["tip"],
            "ilan_model_yili" => $ilanlari_bas["model_yili"],
            "ilan_piyasa_degeri" => fiyat_formatla($ilanlari_bas["piyasa_degeri"]),
            "ilan_tsrsb_degeri" => fiyat_formatla($ilanlari_bas["tsrsb_degeri"]),
            "ilan_plaka" => $ilanlari_bas["plaka"],
            "ilan_acilis_fiyati" => fiyat_formatla($ilanlari_bas["acilis_fiyati"]),
            "ilan_son_teklif" => fiyat_formatla($ilanlari_bas["son_teklif"]),
            "ilan_profil" => $ilanlari_bas["profil"],
            "ilan_sehir" => $ilanlari_bas["sehir"],
            "ilan_ilce" => $ilanlari_bas["ilce"],
            "ilan_ihale_tarihi" => tarih_formatla($ilanlari_bas["ihale_tarihi"]),
            "ilan_ihale_saati" => $ilanlari_bas["ihale_saati"],
            "ilan_pd_hizmet" => $ilanlari_bas["pd_hizmet"],
            "ilan_otopark_ucreti" => fiyat_formatla($ilanlari_bas["otopark_ucreti"]),
            "ilan_otopark_giris" => tarih_formatla($ilanlari_bas["otopark_giris"]),
            "ilan_cekici_ucreti" => null_sorgulama_int(fiyat_formatla($ilanlari_bas["cekici_ucreti"])),
            "ilan_dosya_masrafi" => fiyat_formatla($ilanlari_bas["dosya_masrafi"]),
            "ilan_link" => $ilanlari_bas["link"],
            "ilan_kilometre" => $ilanlari_bas["kilometre"],
            "ilan_uyari_notu" => $ilanlari_bas["uyari_notu"],
            "ilan_hasar_bilgileri" => $ilanlari_bas["hasar_bilgileri"],
            "ilan_notlar" => $ilanlari_bas["notlar"],
            "ilan_adres" => $ilanlari_bas["adres"],
            "ilan_donanimlar" => $ilanlari_bas["donanimlar"],
            "ilan_vitrin" => $ilanlari_bas["vitrin"],
            "ilan_eklenme_zamani" => tarih_formatla($ilanlari_bas["eklenme_zamani"]),
            "ilan_url" => $ilanlari_bas["url"],
            "ilan_ihale_sahibi" => $ilanlari_bas["ihale_sahibi"],
            "ilan_ihale_acilis" => tarih_formatla($ilanlari_bas["ihale_acilis"]),
            "ilan_fotografi" => $base_url_img . ilan_foto_cek($ilan_id),
            "ilan_durum" => $ilanlari_bas["durum"],
            "ilan_ihale_turu" => $ilanlari_bas["ihale_turu"],
            "duzensiz_tarih" => sayac_tarih_formatla($ilanlari_bas["ihale_tarihi"]),
            "arac_gorme_durumu" => $arac_gorme_durumu,
            "detay_gorme_durumu" => $detay["detay_gorme_durumu"],
            "ilan_komisyonu" => ilan_komisyon($ilanlari_bas["id"]),
            "reklamlar" => response(reklamlar()),
            "sigorta_sirket_verisi" => response(sigorta_sirketleri_verileri($ilanlari_bas["sigorta"]))
        ];
        return $listingMap;
    }
}
//Özel İlan cek Function End

//İhaledeki Arac Goruntulenme Sayısı Function Begın

function arac_goruntulenme_ihalede($ilan_id)
{
    $arac_goruntulenme_sayisi_cek = mysql_query("Select * from ihale_goruntulenme where ilan_id='" . $ilan_id . "'");
    $arac_sayisi = mysql_num_rows($arac_goruntulenme_sayisi_cek);
    if ($arac_sayisi == 0) {
        $arac_sayisi = "0";
    }
    return $arac_sayisi;
}
//İhaledeki Arac Goruntulenme Sayısı Function End

//Dogrudan Arac Goruntulenme Sayısı Function Begın

function arac_goruntulenme_dogrudan($ilan_id)
{
    $arac_goruntulenme_sayisi_cek = mysql_query("Select * from dogrudan_goruntulenme where ilan_id='" . $ilan_id . "'");
    $arac_sayisi = mysql_num_rows($arac_goruntulenme_sayisi_cek);
    if ($arac_sayisi == 0) {
        $arac_sayisi = "0";
    }
    return $arac_sayisi;
}

//Dogrudan Arac Goruntulenme Sayısı Function End

//Düzenli İlçe Getir Function Begın
function ilce_duzenli_getir($ilce_id)
{

    $ilce_adi_bas = mysql_query("Select * from ilce where ilceID='" . $ilce_id . "'");
    $ilce_verileri = mysql_fetch_assoc($ilce_adi_bas);


    return $ilce_verileri["ilce_adi"];
}
//Düzenli İlçe Getir Function End

//Araç Sahibi Function Begın
function arac_sahibi($token)
{
    $arac_sahibi_bul = mysql_query("Select * from user where (user_token='" . $token . "') or (kurumsal_user_token='" . $token . "') ");
    while ($arac_sahip_verileri = mysql_fetch_array($arac_sahibi_bul)) {
        $listingMap[] = [
            "kullanici_adi" => $arac_sahip_verileri["ad"],
            "kullanici_tel" => $arac_sahip_verileri["telefon"],
        ];
    }

    return $listingMap;
}
//Araç Sahibi Function End

//Uye Durumlari Function Begın

function uye_durumlari($token, $uye_tip)
{
    if ($uye_tip == "bireysel") {
        $kullanici_oku = mysql_query("Select * from user where user_token='" . $token . "'");
        $bilgi_oku = mysql_fetch_assoc($kullanici_oku);
        $kullanici_id = $bilgi_oku["id"];

        $uye_durumu = mysql_query("Select * from uye_durumlari where uye_id='" . $kullanici_id . "'");
        while ($uye_detaylari = mysql_fetch_array($uye_durumu)) {
            $listingMap[] = [
                "teklif_limiti" => $uye_detaylari["teklif_limiti"],
                "hurda_teklif" => $uye_detaylari["on"],
                "yasak_sigorta" => $uye_detaylari["yasak_sigorta"],
                "kalici_mesaj_durumu" => $uye_detaylari["kalici_mesaj"],
                "kalici_sistem_mesaji" => $uye_detaylari["kalici_sistem_mesaji"],
                "teklif_engelle" => $uye_detaylari["teklif_engelle"],
                "engelleme_nedeni" => $uye_detaylari["engelleme_nedeni"],
                "uyelik_iptal" => $uye_detaylari["uyelik_iptal"],
                "uyelik_iptal_nedeni" => $uye_detaylari["uyelik_iptal_nedeni"],
                "mesaj_gorme_nedeni" => $uye_detaylari["mesajh_gorme_durumu"]
            ];
        }
        return $listingMap;
    }
    if ($uye_tip == "kurumsal") {
        $kullanici_oku = mysql_query("Select * from user where kurumsal_user_token='" . $token . "'");
        $bilgi_oku = mysql_fetch_assoc($kullanici_oku);
        $kullanici_id = $bilgi_oku["id"];

        $uye_durumu = mysql_query("Select * from uye_durumlari where uye_id='" . $kullanici_id . "'");
        while ($uye_detaylari = mysql_fetch_array($uye_durumu)) {
            $listingMap[] = [
                "teklif_limiti" => $uye_detaylari["teklif_limiti"],
                "hurda_teklif" => $uye_detaylari["on"],
                "yasak_sigorta" => $uye_detaylari["yasak_sigrota"],
                "kalici_mesaj_durumu" => $uye_detaylari["kalici_mesaj"],
                "kalici_sistem_mesaji" => $uye_detaylari["kalici_sistem_mesaji"],
                "teklif_engelle" => $uye_detaylari["teklif_engelle"],
                "engelleme_nedeni" => $uye_detaylari["engelleme_nedeni"],
                "uyelik_iptal" => $uye_detaylari["uyelik_iptal"],
                "uyelik_iptal_nedeni" => $uye_detaylari["uyelik_iptal_nedeni"],
                "mesaj_gorme_nedeni" => $uye_detaylari["mesajh_gorme_durumu"]
            ];
        }
        return $listingMap;
    }
}
//Uye Durumlari Function End

//Kalıcı Sistem Mesajı Function Begın

function kalici_sistem_mesaji($token, $uye_tip)
{
    if ($uye_tip == "bireysel") {
        $kullanici_oku = mysql_query("Select * from user where user_token='" . $token . "'");
        $bilgi_oku = mysql_fetch_assoc($kullanici_oku);
        $kullanici_id = $bilgi_oku["id"];

        $uye_durumu = mysql_query("Select * from uye_durumlari where uye_id='" . $kullanici_id . "'");
        while ($uye_detaylari = mysql_fetch_array($uye_durumu)) {
            $listingMap[] = [
                "kalici_mesaj_durumu" => $uye_detaylari["kalici_mesaj"],
                "kalici_sistem_mesaji" => $uye_detaylari["kalici_sistem_mesaji"],
            ];
        }
        return $listingMap;
    }
    if ($uye_tip == "kurumsal") {
        $kullanici_oku = mysql_query("Select * from user where kurumsal_user_token='" . $token . "'");
        $bilgi_oku = mysql_fetch_assoc($kullanici_oku);
        $kullanici_id = $bilgi_oku["id"];

        $uye_durumu = mysql_query("Select * from uye_durumlari where uye_id='" . $kullanici_id . "'");
        while ($uye_detaylari = mysql_fetch_array($uye_durumu)) {
            $listingMap[] = [
                "kalici_mesaj_durumu" => $uye_detaylari["kalici_mesaj"],
                "kalici_sistem_mesaji" => $uye_detaylari["kalici_sistem_mesaji"],
            ];
        }
        return $listingMap;
    }
}
//Kalıcı Sistem Mesajı Function End

//Doğrudan Satış Function Begın

function dogrudan_satis_ilan_cek($ilan_id)
{
    $base_url_img = 'https://ihale.pertdunyasi.com/images/';
    $ilanlari_cek = mysql_query("Select * from dogrudan_satisli_ilanlar where id='" . $ilan_id . "'");
    while ($ilanlari_bas = mysql_fetch_array($ilanlari_cek)) {
        $listingMap[] = [
            "ilan_id" => $ilanlari_bas["id"],
            "ilan_plaka" => $ilanlari_bas["plaka"],
            "ilan_arac_kodu" => $ilanlari_bas["arac_kodu"],
            "ilan_bitis_tarihi" => tarih_saat_formatla($ilanlari_bas["bitis_tarihi"]),
            "ilan_hesaplama" => $ilanlari_bas["hesaplama"],
            "ilan_evrak_tipi" => $ilanlari_bas["evrak_tipi"],
            "ilan_sigorta" => $ilanlari_bas["sigorta"],
            "arac_bilgileri" => $ilanlari_bas["aracin_durumu"],
            "aracin_adresi" => $ilanlari_bas["aracin_adresi"],
            "hasar_durumu" => $ilanlari_bas["hasar_durumu"],
            "ilan_marka" => $ilanlari_bas["marka"],
            "ilan_model" => $ilanlari_bas["model"],
            "arac_aciklamalar" => $ilanlari_bas["aciklamalar"],
            "ilan_tip" => $ilanlari_bas["tip"],
            "ilan_model_yili" => $ilanlari_bas["model_yili"],
            "arac_fiyat" => fiyat_formatla($ilanlari_bas["fiyat"]),
            "ilan_piyasa_degeri" => fiyat_formatla($ilanlari_bas["piyasa_degeri"]),
            "ilan_tsrsb_degeri" => fiyat_formatla($ilanlari_bas["tsrsb_degeri"]),
            "ilan_plaka" => $ilanlari_bas["plaka"],
            "ilan_acilis_fiyati" => fiyat_formatla($ilanlari_bas["acilis_fiyati"]),
            "ilan_son_teklif" => fiyat_formatla($ilanlari_bas["son_teklif"]),
            "ilan_profil" => $ilanlari_bas["profil"],
            "ilan_sehir" => $ilanlari_bas["sehir"],
            "ilan_ilce" => $ilanlari_bas["ilce"],
            "ilan_ihale_tarihi" => tarih_formatla($ilanlari_bas["ihale_tarihi"]),
            "ilan_ihale_saati" => $ilanlari_bas["ihale_saati"],
            "ilan_pd_hizmet" => $ilanlari_bas["pd_hizmet"],
            "ilan_otopark_ucreti" => fiyat_formatla($ilanlari_bas["otopark_ucreti"]),
            "ilan_otopark_giris" => tarih_formatla($ilanlari_bas["otopark_giris"]),
            "ilan_cekici_ucreti" => fiyat_formatla($ilanlari_bas["cekici_ucreti"]),
            "ilan_dosya_masrafi" => fiyat_formatla($ilanlari_bas["dosya_masrafi"]),
            "ilan_link" => $ilanlari_bas["link"],
            "ilan_kilometre" => $ilanlari_bas["kilometre"],
            "ilan_uyari_notu" => $ilanlari_bas["uyari_notu"],
            "ilan_hasar_bilgileri" => $ilanlari_bas["hasar_bilgileri"],
            "ilan_notlar" => $ilanlari_bas["notlar"],
            "ilan_adres" => $ilanlari_bas["adres"],
            "ilan_donanimlar" => $ilanlari_bas["donanimlar"],
            "ilan_vitrin" => $ilanlari_bas["vitrin"],
            "ilan_eklenme_zamani" => tarih_saat_formatla_2($ilanlari_bas["bitis_tarihi"]),
            "ilan_url" => $ilanlari_bas["url"],
            "ilan_ihale_sahibi" => $ilanlari_bas["ihale_sahibi"],
            "ilan_ihale_acilis" => tarih_formatla($ilanlari_bas["ihale_acilis"]),
            "ilan_fotografi" => $base_url_img . ilan_foto_cek($ilan_id),
            "ilan_durum" => $ilanlari_bas["durum"],
            "duzensiz_tarih" => sayac_tarih_formatla($ilanlari_bas["ihale_tarihi"]),
            "reklamlar" => response(reklamlar()),
            "arac_sahibi" => response(arac_sahibi($ilanlari_bas["ilan_sahibi"]))
        ];
    }
    return $listingMap;
}
//Doğrudan Satış Function End

//Araç Marka Function Begın
function arac_marka($marka_id)
{
    $marka_cek = mysql_query("Select * from marka where markaID='" . $marka_id . "'");
    $marka_oku = mysql_fetch_assoc($marka_cek);
    return $marka_oku["marka_adi"];
}
//Araç Marka Function End

//Gün araç cek Function Begın
function gun_arac_say_ihale($gun)
{

    $arac_sayisi = mysql_query("Select * from ilanlar where ihale_tarihi='" . $gun . "'");
    $arac_say = mysql_num_rows($arac_sayisi);
    return $arac_say;
}


//Gün araç cek Function End

//Cayma Bedelleri Function Begın

function cayma_bedel_cek($uye_id, $durum)
{
    $cayma_bedeli = mysql_query("Select * from cayma_bedelleri where uye_id='" . $uye_id . "' and durum='" . $durum . "' ");
    while ($cayma_detaylari_cek = mysql_fetch_array($cayma_bedeli)) {
        /*$listingMap[] = [
            "cayma_id" => $cayma_detaylari_cek["id"],
            "tarih" => tarih_saat_formatla($cayma_detaylari_cek["iade_tarihi"]),
            "tutar" => fiyat_formatla($cayma_detaylari_cek["tutar"]),
            "hesap_ismi" => $cayma_detaylari_cek["hesap_sahibi"],
            "ıban" => $cayma_detaylari_cek["iban"]
        ];*/
		$listingMap[] = [
            "cayma_id" => $cayma_detaylari_cek["id"],
            "paranin_geldigi_tarih" => tarih_saat_formatla($cayma_detaylari_cek["paranin_geldigi_tarih"]),
            "bloke_tarihi" => tarih_saat_formatla($cayma_detaylari_cek["paranin_geldigi_tarih"]),
            "mahsup_tarihi" => tarih_saat_formatla($cayma_detaylari_cek["mahsup_tarihi"]),
            "tahsil_tarihi" => tarih_saat_formatla($cayma_detaylari_cek["tahsil_tarihi"]),
            "iade_talep_tarihi" => tarih_saat_formatla($cayma_detaylari_cek["iade_talep_tarihi"]),
            "iade_tarihi" => tarih_saat_formatla($cayma_detaylari_cek["iade_tarihi"]),
            "tutar" => fiyat_formatla($cayma_detaylari_cek["tutar"]),
            "hesap_ismi" => $cayma_detaylari_cek["hesap_sahibi"],
            "arac_kod_plaka" => $cayma_detaylari_cek["arac_kod_plaka"],
            "arac_detay" => $cayma_detaylari_cek["arac_detay"],
            "ıban" => $cayma_detaylari_cek["iban"]
        ];
    }
    return $listingMap;
}
//Cayma Bedelleri Function End

//İlan Fotoğraf Cek Function Begın
function ilan_foto_cek($ilan_id)
{
    $ilan_foto_cek = mysql_query("Select * from ilan_resimler where ilan_id='" . $ilan_id . "'");
    $ilan_foto_bas = mysql_fetch_assoc($ilan_foto_cek);

    if ($ilan_foto_bas["resim"] == "") {
        $data = "img/duyurular/duyuru.png";
    } else {
        $data = $ilan_foto_bas["resim"];
    }
    return $data;
}
//İlan Fotoğraf Cek Function End

//İlan Detay Fotoğraf Function Begın

function ilan_detay_foto_cek($ilan_id)
{
    $base_url_img = 'https://ihale.pertdunyasi.com/images/';
    $ilan_foto_cek = mysql_query("Select * from ilan_resimler where ilan_id='" . $ilan_id . "'");
    while ($ilan_foto_bas = mysql_fetch_array($ilan_foto_cek)) {

        if ($ilan_foto_bas["resim"] == "") {
            $data = "img/duyurular/duyuru.png";
        } else {
            $data = $ilan_foto_bas["resim"];
        }
        $listingMap[] = [
            "ilan_fotograflari" => $base_url_img . $data,
        ];
    }

    return $listingMap;
}
//İlan Detay Fotoğraf Function End

//İlan Detay Fotoğraf Function Begın

function dogrudan_detay_foto_cek($ilan_id)
{
    $base_url_img = 'https://ihale.pertdunyasi.com/images/';
    $ilan_foto_cek = mysql_query("Select * from dogrudan_satisli_resimler where ilan_id='" . $ilan_id . "'");
    while ($ilan_foto_bas = mysql_fetch_array($ilan_foto_cek)) {
        if ($ilan_foto_bas["resim"] == "") {
            $data = "img/duyurular/duyuru.png";
        } else {
            $data = $ilan_foto_bas["resim"];
        }
        $listingMap[] = [
            "ilan_fotograflari" => $base_url_img . $data,
        ];
    }

    return $listingMap;
}
//İlan Detay Fotoğraf Function End

//İhaledeki İlanlarim Function Begın

function ihaledeki_ilanlarim($token)
{
    $base_url_img = 'https://ihale.pertdunyasi.com/images/';
    $ilanlari_cek = mysql_query("Select * from ilanlar where ihale_sahibi='" . $token . "'");
    while ($ilanlari_bas = mysql_fetch_array($ilanlari_cek)) {

        $listingMap[] = [
            "ilan_id" => $ilanlari_bas["id"],
            "ilan_plaka" => $ilanlari_bas["plaka"],
            "ilan_arac_kodu" => $ilanlari_bas["arac_kodu"],
            "ilan_hesaplama" => $ilanlari_bas["hesaplama"],
            "ilan_sigorta" => $ilanlari_bas["sigorta"],
            "ilan_marka" => arac_marka($ilanlari_bas["marka"]),
            "ilan_model" => $ilanlari_bas["model"],
            "ilan_tip" => $ilanlari_bas["tip"],
            "ilan_model_yili" => $ilanlari_bas["model_yili"],
            "ilan_piyasa_degeri" => fiyat_formatla($ilanlari_bas["piyasa_degeri"]),
            "ilan_tsrsb_degeri" => fiyat_formatla($ilanlari_bas["tsrsb_degeri"]),
            "ilan_plaka" => $ilanlari_bas["plaka"],
            "ilan_acilis_fiyati" => fiyat_formatla($ilanlari_bas["acilis_fiyati"]),
            "ilan_son_teklif" => fiyat_formatla($ilanlari_bas["son_teklif"]),
            "ilan_profil" => $ilanlari_bas["profil"],
            "ilan_sehir" => $ilanlari_bas["sehir"],
            "ilan_ilce" => $ilanlari_bas["ilce"],
            "ilan_ihale_tarihi" => tarih_formatla($ilanlari_bas["ihale_tarihi"]),
            "ilan_ihale_saati" => $ilanlari_bas["ihale_saati"],
            "ilan_pd_hizmet" => $ilanlari_bas["pd_hizmet"],
            "ilan_otopark_ucreti" => fiyat_formatla($ilanlari_bas["otopark_ucreti"]),
            "ilan_otopark_giris" => tarih_formatla($ilanlari_bas["otopark_giris"]),
            "ilan_cekici_ucreti" => fiyat_formatla($ilanlari_bas["cekici_ucreti"]),
            "ilan_dosya_masrafi" => fiyat_formatla($ilanlari_bas["dosya_masrafi"]),
            "ilan_link" => $ilanlari_bas["link"],
            "ilan_kilometre" => $ilanlari_bas["kilometre"],
            "ilan_uyari_notu" => $ilanlari_bas["uyari_notu"],
            "ilan_hasar_bilgileri" => $ilanlari_bas["hasar_bilgileri"],
            "ilan_notlar" => $ilanlari_bas["notlar"],
            "ilan_adres" => $ilanlari_bas["adres"],
            "ilan_donanimlar" => $ilanlari_bas["donanimlar"],
            "ilan_vitrin" => $ilanlari_bas["vitrin"],
            "ilan_eklenme_zamani" => tarih_formatla($ilanlari_bas["eklenme_zamani"]),
            "ilan_url" => $ilanlari_bas["url"],
            "ilan_ihale_sahibi" => $ilanlari_bas["ihale_sahibi"],
            "ilan_ihale_acilis" => tarih_formatla($ilanlari_bas["ihale_acilis"]),
            "ilan_fotografi" => $base_url_img . ilan_foto_cek($ilanlari_bas["id"]),
            "ilan_durum" => $ilanlari_bas["durum"],

        ];
    }
    return $listingMap;
}

//İhaledeki İlanlarim Function End

//Plaka Sorgula Function Begın7

function plaka_sorgula($database, $plaka)
{

    $plaka_sorgula = mysql_query("Select * from $database where plaka='" . $plaka . "'");
    $plaka_sayisi = mysql_num_rows($plaka_sorgula);

    return $plaka_sayisi;
}

//Plaka Sorgula Function End

//Tarih Formatla Function Begın

function tarih_formatla($tarih)
{
    $date = str_replace('/', '-', $tarih);
    $yeni_tarih = date('d/m/Y', strtotime($date));
    return $yeni_tarih;
}

//Tarih Formatla Function End

//Sayac Tarih Formatla Function Begın

function sayac_tarih_formatla($tarih)
{
    $date = str_replace('/', '-', $tarih);
    $yeni_tarih = date('Y/m/d', strtotime($date));
    return $yeni_tarih;
}
//Sayac Tarih Formatla Function End

//Harf Gizle Function Begın
function private_str($str, $start, $end)
{
    $after = mb_substr($str, 0, $start, 'utf8');
    $repeat = str_repeat('*', $end);
    $before = mb_substr($str, ($start + $end), strlen($str), 'utf8');
    return $after . $repeat . $before;
}
//Harf Gizle Function End

//Tarih Saat Formatla Begın

function tarih_saat_formatla($tarih)
{
    $date = str_replace('/', '-', $tarih);
    $yeni_tarih = date('d/m/Y H:i:s', strtotime($date));
    return $yeni_tarih;
}
//Tarih Saat Formatla End

//Tarih Saat Formatla Begın

function tarih_saat_formatla_2($tarih)
{
    $date = str_replace('/', '-', $tarih);
    $yeni_tarih = date('Y/m/d H:i:s', strtotime($date));
    return $yeni_tarih;
}
//Tarih Saat Formatla End

//Görüntülenme Sayısı İhale Function Begın

function ihale_goruntulenme_sayisi($ilan_id, $ıp)
{
    $date_time = date("Y-m-d H:i:s");
    $ihale_goruntulenme_sorgula = mysql_query("Select * from ihale_goruntulenme where ip='" . $ıp . "' and ilan_id='" . $ilan_id . "'");
    $ihale_goruntulenme_sayisi = mysql_num_rows($ihale_goruntulenme_sorgula);

    if ($ihale_goruntulenme_sayisi == 0) {
        $goruntulenme_kaydet = mysql_query("INSERT INTO `ihale_goruntulenme` (`ilan_id`, `ip`, `tarih`) 
        VALUES ('$ilan_id', '$ıp','$date_time');");
    }
}

//Görüntülenme Sayısı İhale Function 

//Doğrudan Görüntülenme Sayısı İhale Function Begın

function dogrudan_goruntulenme_sayisi_arttir($ilan_id, $ıp)
{
    $date_time = date("Y-m-d H:i:s");
    $ihale_goruntulenme_sorgula = mysql_query("Select * from dogrudan_goruntulenme where ip='" . $ıp . "' and ilan_id='" . $ilan_id . "'");
    $ihale_goruntulenme_sayisi = mysql_num_rows($ihale_goruntulenme_sorgula);

    if ($ihale_goruntulenme_sayisi == 0) {
        $goruntulenme_kaydet = mysql_query("INSERT INTO `dogrudan_goruntulenme` (`ilan_id`, `ip`, `tarih`) 
        VALUES ('$ilan_id', '$ıp','$date_time');");
    }
}

//Doğrudan Görüntülenme Sayısı İhale Function End

//Gelen Değer Boş Dolu Kontrol Function Begın

function bos_dolu_kontrol($deger)
{
    $sonuc = "bos";
    if ($deger == "") {
        return $sonuc;
    } else {
        return $deger;
    }
}

//Gelen Değer Boş Dolu Kontrol Function End

//Fiyat Formatla Function Begın
function fiyat_formatla($fiyat)
{
    $yeni_fiyat = number_format($fiyat, 2, ',', '.');
    return $yeni_fiyat;
}

//Fiyat Formatla Function End


//Km Formatla Function Begın
function km_formatla($km)
{
    $yeni_km = number_format($km, 1, '.', '.');
    return $yeni_km;
}

//Km Formatla Function End

//İl Cek Function Begın
function il_cek()
{
    $illeri_cek = mysql_query("Select * from sehir ");
    while ($il_bas = mysql_fetch_array($illeri_cek)) {
        $listingMap[] = [
            "il_id" => $il_bas["sehirID"],
            "il_adi" => $il_bas["sehiradi"],
        ];
    }

    return $listingMap;
}
//İl Cek Function End

//İlce Cek Function Begın
function ilce_cek($il_id)
{
    $ilce_cek = mysql_query("Select * from ilce where il_plaka='" . $il_id . "' ");
    while ($ilce_bas = mysql_fetch_array($ilce_cek)) {
        $listingMap[] = [
            "ilce_id" => $ilce_bas["ilceID"],
            "ilce_adi" => $ilce_bas["ilce_adi"],
        ];
    }

    return $listingMap;
}
//İlce Cek Function End

function ilce_cek_ada_gore($il_adi)
{

    $il_cek = mysql_query("Select * from sehir where sehiradi='" . $il_adi . "' ");

    $il_oku = mysql_fetch_assoc($il_cek);

    $il_id = $il_oku["plaka"];

    $ilce_cek = mysql_query("Select * from ilce where il_plaka='" . $il_id . "' ");
    while ($ilce_bas = mysql_fetch_array($ilce_cek)) {
        $listingMap[] = [
            "ilce_id" => $ilce_bas["ilceID"],
            "ilce_adi" => $ilce_bas["ilce_adi"],
        ];
    }

    return $listingMap;
}
//Filter Check Function Begın

function filtercheck($ihale, $filtre_marka, $filtre_profil, $filtre_il, $filtre_tarih)
{
    var_dump($ihale);
    var_dump($filtre_marka);
    var_dump($filtre_profil);
    var_dump($filtre_il);
    var_dump($filtre_tarih);

    die();


    $kontrol = mysql_query("Select * from ilanlar where ihale_turu='" . $ihale . "' and marka='" . $filtre_marka . "' and profil='" . $filtre_profil . "'
   and sehir='" . $filtre_il . "' and ihale_tarihi='" . $filtre_tarih . "'");
    $veri_say = mysql_num_rows($kontrol);

    $listingMap[] =
        [
            "ilan_sayi" => $veri_say
        ];


    if (mysql_num_rows($kontrol) >= 0) $statusCode = 200;

    $response = ["message" => "kontrol Getirildi", "kontrol Detay" => $kontrol, "status" => $statusCode];

    echo json_encode(response($listingMap, $statusCode));
}

//Filter Check Function End


//Kazanilan durum Function Begın

function kazanilan_durum_cek($token, $durum, $kullanici, $paket_id)
{
    if ($kullanici == "bireysel") {
        $kazanilan_durum = mysql_query("Select * from kazanilanlar where user_token='" . $token . "' and durum='" . $durum . "' ");
        $durum_say = mysql_num_rows($kazanilan_durum);
        $default_durum = 0;

        if ($durum_say == 0) {
            $listingMap[] =
                [
                    "durum_sayisi" => $default_durum,
                ];
        } else {
            while ($kazanilan_durum_bas = mysql_fetch_array($kazanilan_durum)) {
                $listingMap[] =
                    [
                        "ilan_id" => $kazanilan_durum_bas["ilan_id"],
                        "uye_id" => $kazanilan_durum_bas["uye_id"],
                        "zaman" => $kazanilan_durum_bas["zaman"],
                        "kazanilan_tutar" => $kazanilan_durum_bas["kazanilan_tutar"],
                        "statu" => $kazanilan_durum_bas["mtv"],
                        "odenen" => $kazanilan_durum_bas["odenen"],
                        "kalan" => $kazanilan_durum_bas["kalan"],
                        "durum_sayisi" => $durum_say,
                        "ilan_verileri" => ilan_cek($paket_id, $kazanilan_durum_bas["ilan_id"]),
                    ];
            }
        }

        if (mysql_num_rows($kazanilan_durum) >= 0) $statusCode = 200;

        $response = ["message" => "Durumlar Çekildi", "Durum Detay" => $kazanilan_durum, "status" => $statusCode];

        echo json_encode(response($listingMap, $statusCode));
    }
    if ($kullanici == "kurumsal") {
        $kazanilan_durum = mysql_query("Select * from kazanilanlar where kurumsal_token='" . $token . "' and durum='" . $durum . "'");
        $durum_say = mysql_num_rows($kazanilan_durum);
        while ($kazanilan_durum_bas = mysql_fetch_array($kazanilan_durum)) {
            $listingMap[] =
                [
                    "ilan_id" => $kazanilan_durum_bas["ilan_id"],
                    "uye_id" => $kazanilan_durum_bas["uye_id"],
                    "zaman" => $kazanilan_durum_bas["zaman"],
                    "kazanilan_tutar" => $kazanilan_durum_bas["kazanilan_tutar"],
                    "statu" => $kazanilan_durum_bas["statu"],
                    "odenen" => $kazanilan_durum_bas["odenen"],
                    "kalan" => $kazanilan_durum_bas["kalan"],
                    "durum_sayisi" => $durum_say,
                    "ilan_verileri" => ilan_cek($paket_id, $kazanilan_durum_bas["ilan_id"])
                ];
        }
        if (mysql_num_rows($kazanilan_durum) >= 0) $statusCode = 200;

        $response = ["message" => "Durumlar Çekildi", "Durum Detay" => $kazanilan_durum, "status" => $statusCode];

        echo json_encode(response($listingMap, $statusCode));
    }
}
//Kazanilan durum Function End

//Markaya Göre Araç Sayısı Function Begın
function araca_gore_filtre_say($marka)
{
    $araca_gore_cek = mysql_query("Select * from ilanlar where marka='" . $marka . "'");
    $arac_say = mysql_num_rows($araca_gore_cek);

    return $arac_say;
}
//Markaya Göre Araç Sayısı Function End

//Profile Göre Araç Sayısı Function Begın

function profile_gore($profil_tipi)
{
    $profile_gore_cek = mysql_query("Select * from ilanlar where profil='" . $profil_tipi . "'");
    $profil_say = mysql_num_rows($profile_gore_cek);

    return $profil_say;
}

//Profile Göre Araç Sayısı Function End

//Mesajlasma cek Function Begın

function mesajlasma_cek($token, $ilan_id)
{
    $sag = 0;


    $mesajlasma_cek = mysql_query("Select * from mesajlar where ilan_id='" . $ilan_id . "' and ((gonderen_token='" . $token . "') or (alan_token='" . $token . "')) ");
    while ($mesajlari_bas = mysql_fetch_array($mesajlasma_cek)) {
        $token_kontrol = $mesajlari_bas["alan_token"];
        if ($token != $token_kontrol) {
            $sag = 0;
        } else {
            $sag = 1;
        }
        $listingMap[] = [
            "mesajlar" => $mesajlari_bas["mesaj"],
            "mesaj_yeri" => $sag,
            "mesaj_saati" => tarih_saat_formatla($mesajlari_bas["gonderme_zamani"]),
        ];
    }
    if (mysql_num_rows($mesajlasma_cek) >= 0) $statusCode = 200;

    $response = ["message" => "Mesajlar Çekildi", "Mesajlar Detay" => $mesajlasma_cek, "status" => $statusCode];

    echo json_encode(response($listingMap, $statusCode));
}
//Mesajlasma cek Function End

//Teklif veya Kazanan Sayı Function Begın
function kazanan_teklif_cek($table, $token, $uye_tip, $group)
{
    if ($uye_tip == "bireysel") {
        $veri_cek = mysql_query("Select * from $table where user_token='" . $token . "'  $group");
        $veri_say = mysql_num_rows($veri_cek);

        $listingMap[] = [
            "veri_sayisi" => $veri_say,
        ];

        if (mysql_num_rows($veri_cek) >= 0) $statusCode = 200;

        $response = ["message" => "Veri Sayısı Çekildi", "Veri Detay" => $veri_cek, "status" => $statusCode];

        echo json_encode(response($listingMap, $statusCode));
    }
    if ($uye_tip == "kurumsal") {

        $veri_cek = mysql_query("Select * from $table where kurumsal_token='" . $token . "'  $group");
        $veri_say = mysql_num_rows($veri_cek);

        $listingMap[] = [
            "veri_sayisi" => $veri_say,
        ];

        if (mysql_num_rows($veri_cek) >= 0) $statusCode = 200;

        $response = ["message" => "Veri Sayısı Çekildi", "Veri Detay" => $veri_cek, "status" => $statusCode];

        echo json_encode(response($listingMap, $statusCode));
    }
}
//Teklif veya Kazanan Sayı Function End

//Doğrudan Satisli İlanlarim Function Begın

function dogrudan_satisli_ilanlarim($token)
{
    $ilanlari_cek = mysql_query("Select * from dogrudan_satisli_ilanlar where ilan_sahibi='" . $token . "'");
    while ($ilanlari_bas = mysql_fetch_array($ilanlari_cek)) {
        $listingMap[] = [
            "id" => $ilanlari_bas["id"],
            "ilan_plaka" => $ilanlari_bas["plaka"],
            "ilan_arac_kodu" => $ilanlari_bas["arac_kodu"],
            "ilan_bitis_tarihi" => $ilanlari_bas["bitis_tarihi"],
            "ilan_marka" => arac_marka($ilanlari_bas["marka"]),
            "ilan_model" => $ilanlari_bas["model"],
            "ilan_model_yili" => $ilanlari_bas["model_yili"],
            "ilan_sehir" => $ilanlari_bas["sehir"],
            "ilan_profil" => $ilanlari_bas["aracin_durumu"],
            "ilan_eklenme_tarihi" => tarih_formatla($ilanlari_bas["eklenme_tarihi"]),
            "ilan_durum" => $ilanlari_bas["durum"],

        ];
    }
    return $listingMap;
}

//Doğrudan Satisli İlanlarim Function End

//Doğrudan Satisli İlanlar Foto Function Begın
function dogrudan_satis_image($ilan_id)
{

    $ilan_foto_cek = mysql_query("Select * from dogrudan_satisli_resimler where ilan_id='" . $ilan_id . "'");
    $ilan_fotosu_oku = mysql_fetch_assoc($ilan_foto_cek);

    if ($ilan_fotosu_oku["resim"] == "") {
        $data = "img/duyurular/duyuru.png";
    } else {
        $data = $ilan_fotosu_oku["resim"];
    }
    return $data;
}


//Doğrudan Satisli İlanlar Foto Function End

//Doğrudan Satışlı İlanlar Function Begın

function dogrudan_satisli_ilanlar()
{
    $base_url_img = 'https://ihale.pertdunyasi.com/images/';

    $ilanlari_cek = mysql_query("Select * from dogrudan_satisli_ilanlar ");
    while ($ilanlari_bas = mysql_fetch_array($ilanlari_cek)) {
        $listingMap[] = [
            "id" => $ilanlari_bas["id"],
            "ilan_plaka" => $ilanlari_bas["plaka"],
            "ilan_arac_kodu" => $ilanlari_bas["arac_kodu"],
            "ilan_marka" => $ilanlari_bas["marka"],
            "ilan_model" => $ilanlari_bas["model"],
            "ilan_model_yili" => $ilanlari_bas["model_yili"],
            "ilan_sehir" => $ilanlari_bas["sehir"],
            "ilan_profil" => $ilanlari_bas["aracin_durumu"],
            "ilan_eklenme_tarihi" => tarih_formatla($ilanlari_bas["eklenme_tarihi"]),
            "bitis_tarihi" => tarih_saat_formatla($ilanlari_bas["bitis_tarihi"]),
            "ilan_durum" => $ilanlari_bas["durum"],
            "ilan_fiyat" => fiyat_formatla($ilanlari_bas["fiyat"]),
            "ilan_foto" => $base_url_img . dogrudan_satis_image($ilanlari_bas["id"]),
            "reklamlar" => response(reklamlar()),


        ];
    }
    return $listingMap;
}

//Doğrudan Satışlı İlanlar Function End

//User Profile Page Begın
if (re("action") == "profile") {
    $kullanici_verileri = kullanici_veri_cek(re("user_token"));

    echo json_encode(response($kullanici_verileri, $statusCode));
}
//User Profile Page End

//Edit Profile Page Begın
if (re("action") == "edit_profile") {
    $kullanici_verileri = kullanici_veri_cek(re("user_token"));
    echo json_encode(response($kullanici_verileri, $statusCode));
}
//Edit Profile Page End

//Sehirler Page Begın
if (re("action") == "sehir_getir") {
    echo json_encode(response(il_cek()));
}
//Sehirler Page End

//İlanlar Page Begın
if (re("action") == "ilanlari_getir") {
    $uye_paketim = re("paket_turu");
    $user_token = re("user_token");
    echo json_encode(response(ilanlari_cek($uye_paketim = 2, 1, 20, $user_token)));
}
//İlanlar Page End

//Araç Detay Page Begın
if (re("action") == "arac_detayi_getir") {
    $uye_paketim = re("paket_turu");
    $ilan_id_gelen = re("ilan_id");
    $dizi = explode(":", $ilan_id_gelen);
    $ilan_id = $dizi[1];
    echo json_encode(response(ilan_cek($uye_paketim = 2, $ilan_id)));
}
//Araç Detay Page End
function reklamlar()
{
    $base_url_img = 'https://ihale.pertdunyasi.com/reklamlar/';

    $date_time = date("Y-m-d H:i:s");

    $reklamlari_getir = mysql_query("Select * from reklamlar where bitis_tarihi>='" . $date_time . "' and baslangic_tarihi<='" . $date_time . "'  order by rand()");
    $reklam_sayisi = mysql_num_rows($reklamlari_getir);
    while ($reklamlari_cek = mysql_fetch_array($reklamlari_getir)) {
        $listingMap[] = [
            "reklam_yonlendirme_url" => $reklamlari_cek["url"],
            "baslangic_tarihi" => $reklamlari_cek["baslangic_tarihi"],
            "bitis_tarihi" => $reklamlari_cek["bitis_tarihi"],
            "resim_url" => $base_url_img . $reklamlari_cek["resim"],
            "reklam_icerik" => $reklamlari_cek["icerik"],
            "reklam_sayisi" => $reklam_sayisi
        ];
    }
    return $listingMap;
}
//Sehre Göre Araç Sayısı Function Begın
function sehre_gore_arac_say($sehir)
{
    $sehre_gore_cek = mysql_query("Select * from ilanlar where sehir='" . $sehir . "'");
    $sehir_arac_say = mysql_num_rows($sehre_gore_cek);

    return $sehir_arac_say;
}
//Sehre Göre Araç Sayısı Function End

//Arac Fotoğraf Page Begın
if (re("action") == "arac_fotograflari_cek") {
    $ilan_id_gelen = re("ilan_id");
    $dizi = explode(":", $ilan_id_gelen);
    $ilan_id = $dizi[1];

    echo json_encode(response(ilan_detay_foto_cek($ilan_id)));
}
//Arac Fotoğraf Page End


//Tekliflerim Page Begın
if (re("action") == "tekliflerimi_getir") {
    $token = re("token");
    $uye_tipi = re("uye_tipi");
    $uye_paketim = re("uye_paketim");

    if ($uye_tipi == "bireysel") {
        $teklifleri_listele = mysql_query("Select * from teklifler where user_token='" . $token . "'  group by ilan_id order by id desc ");
        while ($teklifleri_cek = mysql_fetch_array($teklifleri_listele)) {
            $listingMap[] = [
                "ilan_id" => $teklifleri_cek["ilan_id"],
                "uye_id" => $teklifleri_cek["uye_id"],
                "teklif" => $teklifleri_cek["teklif"],
                "teklif_zamani" => tarih_saat_formatla($teklifleri_cek["teklif_zamani"]),
                "ilan_detaylari" => ilan_cek($uye_paketim, $teklifleri_cek["ilan_id"]),
                "simdiki_zaman" => tarih_saat_formatla(date("Y-m-d H:i:s"))
            ];
        }
        if (mysql_num_rows($teklifleri_listele) >= 0) $statusCode = 200;

        $response = ["message" => "Teklifler Getirildi", "Teklifler Detay" => $teklifleri_listele, "status" => $statusCode];

        echo json_encode(response($listingMap, $statusCode));
    }
    if ($uye_tipi == "kurumsal") {
        $teklifleri_listele = mysql_query("Select * from teklifler where kurumsal_token='" . $token . "' group by ilan_id order by id desc ");
        while ($teklifleri_cek = mysql_fetch_array($teklifleri_listele)) {
            $listingMap[] = [
                "ilan_id" => $teklifleri_cek["ilan_id"],
                "uye_id" => $teklifleri_cek["uye_id"],
                "teklif" => $teklifleri_cek["teklif"],
                "teklif_zamani" => $teklifleri_cek["teklif_zamani"],
                "ilan_detaylari" => ilan_cek($uye_paketim, $teklifleri_cek["ilan_id"]),
                "simdiki_zaman" => tarih_saat_formatla(date("Y-m-d H:i:s"))

            ];
        }
        if (mysql_num_rows($teklifleri_listele) >= 0) $statusCode = 200;

        $response = ["message" => "Teklifler Getirildi", "Teklifler Detay" => $teklifleri_listele, "status" => $statusCode];

        echo json_encode(response($listingMap, $statusCode));
    }
}
//Tekliflerim Page End

//İhale Tipi Araç Function Begın

function ihale_tipi_arac_say($ihale_kodu)
{
    $ihale_tipi_cek = mysql_query("Select * from ilanlar where ihale_turu='" . $ihale_kodu . "'");
    $ihale_say = mysql_num_rows($ihale_tipi_cek);

    return $ihale_say;
}

//İhale Tipi Araç Function End

//Favorilerimi Cek Page Begın
if (re("action") == "favorilerimi_cek") {
    $token = re("token");
    $tip_cek = re("uye_tip");
    $uye_paket_id = re("uye_paketim");

    if ($tip_cek == "bireysel") {
        $favorileri_cek = mysql_query("Select *from  favoriler where user_token='" . $token . "'  ");
        while ($fav_oku = mysql_fetch_array($favorileri_cek)) {
            $ilan_say = mysql_num_rows(mysql_query("select * from ilanlar where id = '".$fav_oku["ilan_id"]."'"));
            if($ilan_say != 0){
                $listingMap[] = [
                    "ilan_id" => $fav_oku["ilan_id"],
                    "uye_id" => $fav_oku["uye_id"],
                    "fav_tarihi" => $fav_oku["favlama_zamani"],
                    "dogrudan_satisli" => $fav_oku["dogrudan_satisli_id"],
                    "ilan_verileri" => ilan_cek($uye_paket_id, $fav_oku["ilan_id"]),
                ];
            }           
        }
        if (mysql_num_rows($favorileri_cek) >= 0) $statusCode = 200;

        $response = ["message" => "Favoriler Getirildi", "Favoriler Detay" => $favorileri_cek, "status" => $statusCode];

        echo json_encode(response($listingMap, $statusCode));
    }
    if ($tip_cek == "kurumsal") {
        $favorileri_cek = mysql_query("Select *from  favoriler where kurumsal_user_token='" . $token . "'  ");
        while ($fav_oku = mysql_fetch_array($favorileri_cek)) {
            $listingMap[] = [
                "ilan_id" => $fav_oku["ilan_id"],
                "uye_id" => $fav_oku["uye_id"],
                "fav_tarihi" => $fav_oku["favlama_zamani"],
                "dogrudan_satisli" => $fav_oku["dogrudan_satisli_id"],
                "ilan_detaylari" => ilan_cek($uye_paket_id, $fav_oku["ilan_id"]),
            ];
        }
        if (mysql_num_rows($favorileri_cek) >= 0) $statusCode = 200;

        $response = ["message" => "Favoriler Getirildi", "Favoriler Detay" => $favorileri_cek, "status" => $statusCode];

        echo json_encode(response($listingMap, $statusCode));
    }
}

if(re('action') == "favorilerimi_cek_yeni"){
    $user_token = re('token');
    echo json_encode(response(getUserFavorites($user_token)));
}

function getUserFavorites($user_token){
    $user_cek = mysql_query("select * from user where user_token = '".$user_token."' or kurumsal_user_token = '".$user_token."'");
    $user_oku = mysql_fetch_object($user_cek);
    $user_id = $user_oku->id;
    $cek = mysql_query("(SELECT ilanlar.*,unix_timestamp(concat(ilanlar.ihale_tarihi,' ',ilanlar.ihale_saati)) as ihale_son from ilanlar inner join favoriler on favoriler.ilan_id=ilanlar.id and 
    favoriler.uye_id='".$user_id."' WHERE ilanlar.durum='1') UNION (SELECT ilanlar.*,concat(ilanlar.ihale_tarihi,' ',ilanlar.ihale_saati) as ihale_son2 from ilanlar inner join  favoriler on
    favoriler.ilan_id=ilanlar.id and favoriler.uye_id='".$user_id."' where ilanlar.durum!='1') ORDER BY ihale_son asc");
    while($favori_oku = mysql_fetch_object($cek)){
        $kazanilan_say = mysql_num_rows(mysql_query("select * from kazanilan_ilanlar where ilan_id = '".$favori_oku->id."' and uye_id = '".$user_id."'"));
        if($kazanilan_say == 0){
            $ilan_favori_id = $favori_oku->id;
            $dogrudan_favori_id = $favori_oku->dogrudan_satisli_id;
            $sql = mysql_query("select * from ilanlar where id = '".$ilan_favori_id."'");
            $ihale_oku = mysql_fetch_object($sql);
            $yasakli_sigorta = mysql_query("select * from uye_durumlari where uye_id = '".$user_id."'");
            $yasakli_sigorta_cek = mysql_fetch_object($yasakli_sigorta);
            $yasaki_sigorta_id = $yasakli_sigorta_cek->yasak_sigorta;
            $sigorta_cek = mysql_query("select * from sigortalar where sigorta_id = '".$ihale_oku->sigorta."'");
            $sigorta_oku = mysql_fetch_object($sigorta_cek);

            $ilan_bitis = $ihale_oku->ihale_tarihi." ".$ihale_oku->ihale_saati;
            $bitis_tarihi=$ilan_bitis;
            $ihale_son_str = strtotime($bitis_tarihi);
            $suan_str = strtotime(date("Y-m-d H:i:s"));
            $sonuc = ($ihale_son_str-$suan_str)/60;

            if($sonuc<30){ 
                $kullanici_grubu = kullanici_grubu_cek($user_token);
                if($kullanici_grubu==1){
                    $user_package_status=1;
                }else{
                    $user_package_status=0;
                }
                $kazanilan_sorgu=mysql_query("select * from kazanilan_ilanlar where ilan_id='".$ilan_favori_id."' ");
                if(mysql_num_rows($kazanilan_sorgu)==0){
                    $ilan_status=1;
                }else{
                    $ilan_status=0;
                }					
            }else{
                $ilan_status=1;
                $user_package_status=1;					
            }			
            if($ihale_oku["ihale_son_gosterilme"] >= date('Y-m-d H:i:s')){
                $ilan_status=1;
            }else{
                $ilan_status = 0;
            }
        }
    }
}


//Favorilerimi Cek Page End

//Vitrin ilan Cek Page Begın
if (re("action") == "vitrin_ilan_cek") {

    $uye_paketim = re("paket_turu");

    $vitrin_cek = mysql_query("Select * from  ilanlar where vitrin='on' ");
    while ($vitrinoku = mysql_fetch_array($vitrin_cek)) {
        $listingMap[] = [
            "ilan_detaylari" => ilan_cek($uye_paketim = 2, $vitrinoku["id"]),
        ];
    }

    if (mysql_num_rows($vitrin_cek) >= 0) $statusCode = 200;

    $response = ["message" => "Vitrin Getirildi", "Vitrin Detay" => $vitrin_cek, "status" => $statusCode];

    echo json_encode(response($listingMap, $statusCode));
}
//Vitrin ilan Cek Page End

//Profile Page Section Begın
if (re("action") == "onay_bekleyenler") {
    $token = re("user_token");
    $uye_tip = re("uye_tip");
    $onay_durum = 0;
    $uye_paketi = re("uye_paketi");


    kazanilan_durum_cek($token, $onay_durum, $uye_tip, $uye_paketi);
}

if (re("action") == "satin_alinan") {
    $token = re("user_token");
    $uye_tip = re("uye_tip");
    $onay_durum = 3;
    $uye_paketi = re("uye_paketi");

    kazanilan_durum_cek($token, $onay_durum, $uye_tip, $uye_paketi);
}

if (re("action") == "iptal_olan") {
    $token = re("user_token");
    $uye_tip = re("uye_tip");
    $onay_durum = 4;
    $uye_paketi = re("uye_paketi");

    kazanilan_durum_cek($token, $onay_durum, $uye_tip, $uye_paketi);
}
if (re("action") == "odeme_bekleyen") {
    $token = re("user_token");
    $uye_tip = re("uye_tip");
    $onay_durum = 1;
    $uye_paketi = re("uye_paketi");

    kazanilan_durum_cek($token, $onay_durum, $uye_tip, $uye_paketi);
}

if (re("action") == "son_islemdekiler") {
    $token = re("user_token");
    $uye_tip = re("uye_tip");
    $onay_durum = 2;
    $uye_paketi = re("uye_paketi");
    kazanilan_durum_cek($token, $onay_durum, $uye_tip, $uye_paketi);
}

if (re("action") == "profile_favoriler") {
    $token = re("user_token");
    $tip = re("uye_tip");
    $table = "favoriler";
    $group_by = "group by ilan_id";


    kazanan_teklif_cek($table, $token, $tip, $group_by);
}
if (re("action") == "profile_tekliflerim") {
    $token = re("user_token");
    $tip = re("uye_tip");
    $table = "teklifler";
    $group_by = "group by ilan_id";

    kazanan_teklif_cek($table, $token, $tip, $group_by);
}
//Profile Page Section End

//Ödeme Bekleyen Page Begın

if (re("action") == "odeme_bekleyen_page") {
    $token = re("token");
    $uye_tip = re("uye_tip");
    $durum = 1;
    $paket_id = re("uye_paketi");
    kazanilan_durum_cek($token, $durum, $uye_tip, $paket_id);
}
//Ödeme Bekleyen Page End

//Son İşlemdekiler Page Begın

if (re("action") == "son_islemdekiler_page") {
    $token = re("token");
    $uye_tip = re("uye_tip");
    $durum = 2;

    kazanilan_durum_cek($token, $durum, $uye_tip);
}
//Son İşlemdekiler Page End

//Onay Bekleyenler Page Begın

if (re("action") == "onay_bekleyenler_page") {
    $token = re("token");
    $uye_tip = re("uye_tip");
    $durum = 0;
    $paket_id = re("uye_paketi");
    kazanilan_durum_cek($token, $durum, $uye_tip, $paket_id);
}

//Onay Bekleyenler Page End

//Satin Alinanlar Page Begın

if (re("action") == "satin_alinanlar_page") {
    $token = re("token");
    $uye_tip = re("uye_tip");
    $durum = 3;
    kazanilan_durum_cek($token, $durum, $uye_tip);
}
//Satin Alinanlar Page End

//İptal Olanlar Page Begın

if (re("action") == "iptal_olanlar_page") {
    $token = re("token");
    $uye_tip = re("uye_tip");
    $durum = 4;
    kazanilan_durum_cek($token, $durum, $uye_tip);
}
//İptal Olanlar Page End

//İhaledeki İlanlarim Page Begın

if (re("action") == "ihaledeki_ilanlarim") {
    $token = re("token");
    echo json_encode(response(ihaledeki_ilanlarim($token)));
}
//İhaledeki İlanlarim Page End

//Doğrudan Satisli İlanlarim Page Begın
if (re("action") == "dogrudan_satisli_ilanlarim") {
    $token = re("token");
    echo json_encode(response(dogrudan_satisli_ilanlarim($token)));
}
//Doğrudan Satisli İlanlarim Page End

//Sıkca Sorulan Sorular Page Begın

if (re("action") == "sss") {
    $sorulari_cek = mysql_query("Select * from sss");
    while ($sorulari_oku = mysql_fetch_array($sorulari_cek)) {
        $listingMap[] = [
            "sorular" => $sorulari_oku["soru"],
            "cevaplar" => $sorulari_oku["cevap"]
        ];
    }

    if (mysql_num_rows($sorulari_cek) >= 0) $statusCode = 200;

    $response = ["message" => "Sorular Getirildi", "Sorular Detay" => $sorulari_cek, "status" => $statusCode];

    echo json_encode(response($listingMap, $statusCode));
}

//Sıkca Sorulan Sorular Page End

//İletişim Page Begın

if (re("action") == "iletisim_gonder") {
    $ad = re("ad");
    $soyad = re("soyad");
    $email = re("email");
    $mesaj = re("mesaj");
    $date_time = date("Y-m-d H:i:s");


    $insert = mysql_query("INSERT INTO iletisim_formu (ad,soyad,email,mesaj,olusturulma_zamani)VALUES ('$ad', '$soyad','$email','$mesaj','$date_time')");

    if ($insert) {
        $statusCode = 200;
        $response = ["message" => "Mesaj Gönderildi", "Mesaj" => $sorulari_cek, "status" => $statusCode];

        echo json_encode(response($listingMap, $statusCode));
    } else {
        $statusCode = 400;
        $response = ["message" => "Mesaj Gönderilemedi", "Mesaj" => $sorulari_cek, "status" => $statusCode];
        echo json_encode(response($listingMap, $statusCode));
    }
}
//İletişim Page End

//Duyurular Page Begın
if (re("action") == "duyurular_genel") {
    $base_url_img = 'https://ihale.pertdunyasi.com/duyurular/';
    $cek = mysql_query("Select * from duyurular where durum='1' order by id desc limit 4");
    while($oku = mysql_fetch_object($cek)) {
        
        $listingMap[] = [
            "duyuru_id" => $oku->id,
            "duyuru_baslik" => $oku->baslik,
            "duyuru_icerik" => $oku->icerik,
            "duyuru_resim" => $base_url_img . $oku->resim,
            "duyuru_eklenme_zamani" => tarih_formatla($oku->eklenme_zamani),
        ];
    }

    echo json_encode(response($listingMap));
}
//Duyurular Page End

//Duyuru Detay Page Begın

if (re("action") == "duyuru_detay_getir") {
    $base_url_img = 'https://ihale.pertdunyasi.com/duyurular/';

    $duyuru_id_gelen = re("duyuru_id");
    $dizi = explode(":", $duyuru_id_gelen);
    $duyuru_id = $dizi[1];

    $duyuru_detay_cek = mysql_query("Select * from duyurular where id='" . $duyuru_id . "'");
    $duyuru_detaylari = mysql_fetch_assoc($duyuru_detay_cek);

    $listingMap[] = [
        "duyuru_id" => $duyuru_detaylari["id"],
        "duyuru_baslik" => $duyuru_detaylari["baslik"],
        "duyuru_icerik" => $duyuru_detaylari["icerik"],
        "duyuru_resim" => $base_url_img . $duyuru_detaylari["resim"],
        "duyuru_eklenme_zamani" => tarih_formatla($duyuru_detaylari["eklenme_zamani"]),
    ];

    if (mysql_num_rows($duyuru_detay_cek) >= 0) $statusCode = 200;

    $response = ["message" => "Duyuru Detaylari Getirildi", "Duyurular Detay" => $duyuru_detay_cek, "status" => $statusCode];

    echo json_encode(response($listingMap, $statusCode));
}
//Duyuru Detay Page End


//Profil Bilgileri Güncelle Page Begın


if (re("action") == "change_profile") {
    $token = re("token");
    $uye_tip = re("uye_tip");
    $kullanici_adi = re("kullanici_adi");
    $gsm = re("gsm");
    $e_posta = re("e_posta");
    $sabit_tel = re("sabit_tel");
    $cinsiyet = re("cinsiyet");
    $sehir = re("sehir");
    $tc_no_user = re("tc_no_user");
    $dogum_tarihi_user = re("dogum_tarihi_user");
    $uye_olma_user = re("uye_olma_user");
    $ilce_user = re("ilce_user");
    $ilgilendigi_turler_user = re("ilgilendigi_turler_user");
    $meslek_user = re("meslek_user");
    $yeni_kisi_adi_user = re("yeni_kisi_adi_user");
    $yeni_kisi_telefon_user = re("yeni_kisi_telefon_user");
    $adres_user = re("adres_user");
    $fatura_user = re("fatura_user");
    $kargo_adresi = re("kargo_adresi");

    $after_phone = str_replace(' ', '', $gsm);

    if ($uye_tip == "bireysel") {
        $kullanici_guncelle = mysql_query("Update user set ad='" . $kullanici_adi . "',tc_kimlik='" . $tc_no_user . "',uye_olma_sebebi='" . $uye_olma_user . "',cinsiyet='" . $cinsiyet . "',
        mail='" . $e_posta . "',telefon='" . $after_phone . "',sabit_tel='" . $sabit_tel . "',ilce='" . $ilce_user . "',meslek='" . $meslek_user . "',
        ilgilendigi_turler='" . $ilgilendigi_turler_user . "', adres='" . $adres_user . "',kargo_adresi='" . $kargo_adresi . "',fatura_adresi='" . $fatura_user . "',yedek_kisi='" . $yeni_kisi_adi_user . "',yedek_kisi_tel='" . $yeni_kisi_telefon_user . "',cinsiyet='" . $cinsiyet . "',sehir='" . $sehir . "' where user_token='" . $token . "'");

        if ($kullanici_guncelle) {
            echo json_encode(response($statusCode = 200));
        } else {
            echo json_encode(response($statusCode = 400));
        }
    }
    if ($uye_tip == "kurumsal") {
        $kullanici_guncelle = mysql_query("Update user set ad='" . $kullanici_adi . "',tc_kimlik='" . $tc_no_user . "',uye_olma_sebebi='" . $uye_olma_user . "',cinsiyet='" . $cinsiyet . "',
        mail='" . $e_posta . "',telefon='" . $after_phone . "',sabit_tel='" . $sabit_tel . "',ilce='" . $ilce_user . "',meslek='" . $meslek_user . "',
        ilgilendigi_turler='" . $ilgilendigi_turler_user . "', adres='" . $adres_user . "',kargo_adresi='" . $kargo_adresi . "',fatura_adresi='" . $fatura_user . "',yedek_kisi='" . $yeni_kisi_adi_user . "',yedek_kisi_tel='" . $yeni_kisi_telefon_user . "',cinsiyet='" . $cinsiyet . "',sehir='" . $sehir . "' where kurumsal_user_token='" . $token . "'");

        if ($kullanici_guncelle) {
            echo json_encode(response($statusCode = 200));
        } else {
            echo json_encode(response($statusCode = 400));
        }
    }
}
//Profil Bilgileri Güncelle Page End

//Anasayfa Filter Section Begın
if (re("action") == "filtre_markalar") {
    $markalari_cek = mysql_query("Select * from marka order by marka_adi asc");
    while ($markalari_bas = mysql_fetch_array($markalari_cek)) {
        $listingMap[] = [
            "marka_id" => $markalari_bas["markaID"],
            "marka_adi" => $markalari_bas["marka_adi"]
        ];
    }

    if (mysql_num_rows($markalari_cek) >= 0) $statusCode = 200;

    $response = ["message" => "Markalar Getirildi", "Marka Detay" => $markalari_cek, "status" => $statusCode];

    echo json_encode(response($listingMap, $statusCode));
}

if (re("action") == "filtre_model") {
    $marka_id = re("marka");

    $modelleri_cek = mysql_query("Select * from model where marka_id='" . $marka_id . "'");
    while ($model_bas = mysql_fetch_array($modelleri_cek)) {
        $listingMap[] = [
            "model_id" => $model_bas["modelID"],
            "model_adi" => $model_bas["model_adi"],
        ];
    }
    if (mysql_num_rows($modelleri_cek) >= 0) $statusCode = 200;

    $response = ["message" => "Modeller Getirildi", "Model Detay" => $modelleri_cek, "status" => $statusCode];

    echo json_encode(response($listingMap, $statusCode));
}
if (re("action") == "filtre_il") {
    $illeri_cek = mysql_query("Select * from sehir");
    while ($il_bas = mysql_fetch_array($illeri_cek)) {
        $listingMap[] = [
            "il_id" => $il_bas["sehirID"],
            "il_adi" => $il_bas["sehiradi"]
        ];
    }
    if (mysql_num_rows($illeri_cek) >= 0) $statusCode = 200;

    $response = ["message" => "İller Getirildi", "İller Detay" => $illeri_cek, "status" => $statusCode];

    echo json_encode(response($listingMap, $statusCode));
}
//Anasayfa Filter Section End

//Filter Page Begın

if (re("action") == "filtre_secenekleri") {
    $ihale = re("ihale");
    $filtre_marka = re("filtre_marka");
    $filtre_model = re("filtre_model");
    $filtre_evrak_durum = re("filtre_evrak_durum");
    $filtre_il = re("filtre_il");

    $filtrele = mysql_query("Select * from ilanlar where ihale_turu='" . $ihale . "' and marka='" . $filtre_marka . "' and model='" . $filtre_model . "'  
    and profil='" . $filtre_evrak_durum . "' and sehir='" . $filtre_il . "'");
    while ($filtre_bas = mysql_fetch_array($filtrele)) {
        $listingMap[] =
            [
                "ilan_verileri" => ilan_cek($filtre_bas["id"])
            ];
    }

    if (mysql_num_rows($filtrele) >= 0) $statusCode = 200;

    $response = ["message" => "Filtre Getirildi", "Filtre Detay" => $filtrele, "status" => $statusCode];

    echo json_encode(response($listingMap, $statusCode));
}

//Filter Page End

//Filter Var check Page Begın

if (re("action") == "filtre_var_mi") {
    $f_ihale = $_POST["ihale"];
    $f_marka = $_POST["filtre_marka"];
    $f_profil = $_POST["filtre_profil"];
    $f_sehir = $_POST["filtre_il"];
    $f_tarih = $_POST["filtre_tarih"];
    $baslangic_tarihi = $_POST["filtre_baslangic_tarihi"];
    $bitis_tarihi = $_POST["filtre_bitis_tarihi"];
    $paket_turu = re("paket_turu");

    $where = "WHERE durum = '1' ";

    if ($baslangic_tarihi != "" && $bitis_tarihi != "") {

        $where = $where . " AND model_yili between  $baslangic_tarihi[0]  and $bitis_tarihi[0] ";
    }

    if ($f_ihale != "") {
        $veri = 0;
        $seciliihaleSayisi = count($_POST['ihale']);
        $seciliihale = "";
        while ($veri < $seciliihaleSayisi) {
            $seciliihale = $seciliihale . "'" . $_POST['ihale'][$veri] . "'";
            if ($veri < $seciliihaleSayisi - 1) {
                $seciliihale = $seciliihale . ", ";
            }
            $veri++;
        }
        $where = $where . " AND ihale_turu in (" . $seciliihale . ")";
    }
    if ($f_marka != "") {
        $k = 0;
        $seciliMarkaSayisi = count($_POST['filtre_marka']);
        $seciliMarka = "";
        while ($k < $seciliMarkaSayisi) {
            $seciliMarka = $seciliMarka . "'" . $_POST['filtre_marka'][$k] . "'";
            if ($k < $seciliMarkaSayisi - 1) {
                $seciliMarka = $seciliMarka . ", ";
            }
            $k++;
        }
        $where = $where . " AND marka in (" . $seciliMarka . ")";
    }
    if ($f_sehir != "") {
        $i = 0;
        $seciliSehirSayisi = count($_POST['filtre_il']);
        $seciliSehir = "";
        while ($i < $seciliSehirSayisi) {
            $seciliSehir = $seciliSehir . "'" . $_POST['filtre_il'][$i] . "'";
            if ($i < $seciliSehirSayisi - 1) {
                $seciliSehir = $seciliSehir . ", ";
            }
            $i++;
        }
        $where = $where . " AND sehir in (" . $seciliSehir . ")";
    }
    /*
    if ($f_profil != "") {
        $p = 0;
        $seciliProfilSayisi = count($_POST['filtre_profil']);
        $seciliProfil = "";
        while ($p < $seciliProfilSayisi) {
            $seciliProfil = $seciliProfil . "'" . $_POST['filtre_profil'][$p] . "'";
            if ($p < $seciliProfilSayisi - 1) {
                $seciliProfil = $seciliProfil . ", ";
            }
            $p++;
        }
        $where = $where . " AND profil in (" . $seciliProfil . ")";
    }*/
    if ($f_tarih != "") {
        $t = 0;
        $seciliTarihSayisi = count($_POST['filtre_tarih']);
        $seciliTarih = "";
        while ($t < $seciliTarihSayisi) {
            $seciliTarih = $seciliTarih . "'" . $_POST['filtre_tarih'][$t] . "'";
            if ($t < $seciliTarihSayisi - 1) {
                $seciliTarih = $seciliTarih . ", ";
            }
            $t++;
        }
        $where = $where . " AND ihale_tarihi in (" . $seciliTarih . ")";
    }
    $filtre_cek = "SELECT * FROM ilanlar $where";
    $result = mysql_query($filtre_cek) or die(mysql_error());
    $sayi = mysql_num_rows($result);

    if ($sayi != 0) {
        while ($filtre_oku = mysql_fetch_array($result)) {
            $resim_cek = mysql_query("select * from ilan_resimler where ilan_id = '" . $filtre_oku['id'] . "'");
            $resim_oku = mysql_fetch_assoc($resim_cek);
            $resim = $resim_oku['resim'];
            $listingMap[] = [
                "ilanlar" => ilan_cek($paket_turu = 1, $filtre_oku["id"]),
                "ilan_sayisi" => $sayi
            ];
        }

        if (mysql_num_rows($filtre_cek) >= 0) $statusCode = 200;

        $response = ["message" => "Filtre Getirildi", "Filtre Detay" => $filtre_cek, "status" => $statusCode];

        echo json_encode(response($listingMap, $statusCode));
    } else {
        $response = ["message" => "Filtre Getirildi", "Filtre Detay" => $filtre_cek, "status" => "500"];

        echo json_encode(response($response));
    }

    //filtercheck($ihale,$filtre_marka,$filtre_profil,$filtre_il,$filtre_tarih);
}
//Filter Var check Page End

//Filtre Dogrudan Satış Page Begın
if (re("action") == "filtre_var_mi_dogrudan") {
    $dogrudan_filtrele_vites_tipi = $_POST["dogrudan_filtrele_vites_tipi"];
    $dogrudan_filtre_markalar = $_POST["dogrudan_filtre_markalar"];
    $dogrudan_satisli_model_yillari = $_POST["dogrudan_satisli_model_yillari"];
    $dogrudan_filtrele_yakit_tipi = $_POST["dogrudan_filtrele_yakit_tipi"];
    $dogrudan_filtrele_profil = $_POST["dogrudan_filtrele_profil"];
    $dogrudan_filtrele_hasar_durumu = $_POST["dogrudan_filtrele_hasar_durumu"];
    $dogrudan_filtre_sehir = $_POST["dogrudan_filtre_sehir"];

    $yila_gore_en_dusuk = $_POST["yila_gore_en_dusuk"];
    $yila_gore_en_yuksek = $_POST["yila_gore_en_yuksek"];
    //$dogrudan_filtre_baslangic_tarihi=$_POST["dogrudan_filtre_baslangic_tarihi"];   
    //$dogrudan_filtre_bitis_tarihi=$_POST["dogrudan_filtre_bitis_tarihi"];   

    $kilometreye_gore_en_dusuk = $_POST["kilometreye_gore_en_dusuk"];
    $kilometreye_gore_en_yuksek = $_POST["kilometreye_gore_en_yuksek"];



    $where = "WHERE durum = '1' ";

    if ($yila_gore_en_dusuk != "" && $yila_gore_en_yuksek != "") {

        $where = $where . " AND model_yili between  $yila_gore_en_dusuk  and $yila_gore_en_yuksek ";
    }


    if ($dogrudan_filtrele_vites_tipi != "") {
        $veri = 0;
        $secili_vites_tipi = count($_POST['dogrudan_filtrele_vites_tipi']);
        $secili_vites = "";
        while ($veri < $secili_vites_tipi) {
            $secili_vites = $secili_vites . "'" . $_POST['dogrudan_filtrele_vites_tipi'][$veri] . "'";

            if ($veri < $secili_vites_tipi - 1) {
                $secili_vites = $secili_vites . ", ";
            }
            $veri++;
        }
        $where = $where . " AND vites_tipi in (" . $secili_vites . ")";
    }
    if ($dogrudan_filtre_markalar != "") {
        $k = 0;
        $seciliMarkaSayisi = count($_POST['dogrudan_filtre_markalar']);
        $seciliMarka = "";
        while ($k < $seciliMarkaSayisi) {
            $seciliMarka = $seciliMarka . "'" . $_POST['dogrudan_filtre_markalar'][$k] . "'";
            if ($k < $seciliMarkaSayisi - 1) {
                $seciliMarka = $seciliMarka . ", ";
            }
            $k++;
        }
        $where = $where . " AND marka in (" . $seciliMarka . ")";
    }
    if ($dogrudan_filtrele_yakit_tipi != "") {
        $veri_2 = 0;
        $seciliVitesTipi = count($_POST['dogrudan_filtrele_yakit_tipi']);
        $secili_vites = "";
        while ($veri_2 < $seciliVitesTipi) {
            $secili_vites = $secili_vites . "'" . $_POST['dogrudan_filtrele_yakit_tipi'][$veri_2] . "'";
            if ($veri_2 < $seciliVitesTipi - 1) {
                $secili_vites = $secili_vites . ", ";
            }
            $veri_2++;
        }
        $where = $where . " AND yakit_tipi in (" . $secili_vites . ")";
    }


    if ($dogrudan_filtrele_profil != "") {
        $veri_3 = 0;
        $seciliProfil = count($_POST['dogrudan_filtrele_profil']);
        $secili_profil = "";
        while ($veri_3 < $seciliProfil) {
            $secili_profil = $secili_profil . "'" . $_POST['dogrudan_filtrele_profil'][$veri_3] . "'";
            if ($veri_3 < $seciliProfil - 1) {
                $secili_profil = $secili_profil . ", ";
            }
            $veri_3++;
        }
        $where = $where . " AND evrak_tipi in (" . $secili_profil . ")";
    }

    if ($dogrudan_satisli_model_yillari != "") {
        $veri_5 = 0;
        $secili_modeli_yili = count($_POST['dogrudan_satisli_model_yillari']);
        $secili_model_yillari = "";
        while ($veri_5 < $secili_modeli_yili) {
            $secili_model_yillari = $secili_model_yillari . "'" . $_POST['dogrudan_satisli_model_yillari'][$veri_5] . "'";
            if ($veri_5 < $secili_modeli_yili - 1) {
                $secili_model_yillari = $secili_model_yillari . ", ";
            }
            $veri_5++;
        }
        $where = $where . " AND model_yili in (" . $secili_model_yillari . ")";
    }


    if ($dogrudan_filtrele_hasar_durumu != "") {
        $veri_4 = 0;
        $secili_hasar_durumu = count($_POST['dogrudan_filtrele_hasar_durumu']);
        $Secili_hasar = "";
        while ($veri_4 < $secili_hasar_durumu) {
            $push_dizim = array();
            $Secili_hasar = $Secili_hasar . "'" . $_POST['dogrudan_filtrele_hasar_durumu'][$veri_4] . "'";
            if ($veri_4 < $secili_hasar_durumu - 1) {
                $Secili_hasar = $Secili_hasar . ", ";
            }
            $veri_4++;
        }
        array_push($push_dizim, $Secili_hasar);

        $virgül_ayraçlı = implode(",", $push_dizim);
        $metin = str_replace("'", "", $virgül_ayraçlı);
        $gelen_datam = str_replace(",", "|", $metin);
        $son_data = str_replace(" ", "", $gelen_datam);

        $where = $where . " AND hasar_durumu in (" . $son_data . ")";
    }




    if ($dogrudan_filtre_sehir != "") {
        $i = 0;
        $seciliSehirSayisi = count($_POST['dogrudan_filtre_sehir']);
        $seciliSehir = "";
        while ($i < $seciliSehirSayisi) {
            $seciliSehir = $seciliSehir . "'" . $_POST['dogrudan_filtre_sehir'][$i] . "'";
            if ($i < $seciliSehirSayisi - 1) {
                $seciliSehir = $seciliSehir . ", ";
            }
            $i++;
        }
        $where = $where . " AND sehir in (" . $seciliSehir . ")";
    }

    if ($kilometreye_gore_en_dusuk != "" && $kilometreye_gore_en_yuksek != "") {

        $where = $where . " AND kilometre between (" . $kilometreye_gore_en_dusuk . ")  and (" . $kilometreye_gore_en_yuksek . ")  ";
    }

    /*
     if($f_profil !=""){
        $p = 0;
        $seciliProfilSayisi = count($_POST['filtre_profil']);
        $seciliProfil = "";
        while ($p < $seciliProfilSayisi) {
            $seciliProfil = $seciliProfil . "'" . $_POST['filtre_profil'][$p] . "'";
            if ($p < $seciliProfilSayisi - 1) {
                $seciliProfil = $seciliProfil . ", ";
            }
            $p ++;
        }
        $where = $where . " AND profil in (" . $seciliProfil . ")";
     }
     if($f_tarih !=""){        
        $t = 0;
        $seciliTarihSayisi = count($_POST['filtre_tarih']);
        $seciliTarih = "";
        while ($t < $seciliTarihSayisi) {
            $seciliTarih = $seciliTarih . "'" . $_POST['filtre_tarih'][$t] . "'";
            if ($t < $seciliTarihSayisi - 1) {
                $seciliTarih = $seciliTarih . ", ";
            }
            $t ++;
        }
        $where = $where . " AND ihale_tarihi in (" . $seciliTarih . ")";
     }   
     */
    $filtre_cek = "SELECT * FROM dogrudan_satisli_ilanlar $where";
    $result = mysql_query($filtre_cek) or die(mysql_error());
    $sayi = mysql_num_rows($result);



    if ($sayi != 0) {
        while ($filtre_oku = mysql_fetch_array($result)) {
            $resim_cek = mysql_query("select * from dogrudan_satisli_resimler where ilan_id = '" . $filtre_oku['id'] . "'");
            $resim_oku = mysql_fetch_assoc($resim_cek);
            $resim = $resim_oku['resim'];
            $listingMap[] = [
                "ilanlar" => dogrudan_satis_ilan_cek($filtre_oku["id"]),
                "ilan_sayisi" => $sayi
            ];
        }

        if (mysql_num_rows($filtre_cek) >= 0) $statusCode = 200;

        $response = ["message" => "Filtre Getirildi", "Filtre Detay" => $filtre_cek, "status" => $statusCode];

        echo json_encode(response($listingMap, $statusCode));
    } else {
        echo json_encode(response($statusCode = 500));
    }
}



//Filtre Dogrudan Satış Page End

//Mesajlasma Page Begın

if (re("action") == "Mesajlasma_cek") {
    $token = re("token");
    $ilan_id = re("ilan_id");

    mesajlasma_cek($token, $ilan_id);
}
//Mesajlasma Page End

//Mesaj Gönder Page Begın

if (re("action") == "mesaj_gonder") {
    $token = re("token");
    $ilan_id = re("ilan_id");
    $mesaj = re("mesaj");
    $uye_tip = re("uye_tip");

    $date_time = date("Y-m-d H:i:s");

    if ($uye_tip == "bireysel") {
        $kullanici_id_cek = mysql_query("Select * from user where user_token='" . $token . "'");
        $kullanici_veri_cek = mysql_fetch_assoc($kullanici_id_cek);
        $kullanici_id = $kullanici_veri_cek["id"];
    }
    if ($uye_tip == "kurumsal") {
        $kullanici_id_cek = mysql_query("Select * from user where kurumsal_user_token='" . $token . "'");
        $kullanici_veri_cek = mysql_fetch_assoc($kullanici_id_cek);
        $kullanici_id = $kullanici_veri_cek["id"];
    }

    $kullanici_cek = mysql_query("Select * from ilanlar where id='" . $ilan_id . "'");
    $kullanici_oku = mysql_fetch_assoc($kullanici_cek);
    $kullanici_token = $kullanici_oku["ihale_sahibi"];


    $alan_token_oku = mysql_query("Select * from user where user_token='" . $kullanici_token . "'");
    $alan_token_cek = mysql_fetch_assoc($alan_token_oku);
    $gelen_id = $alan_token_cek["id"];

    if ($gelen_id == "") {
        $alan_token_oku = mysql_query("Select * from user where kurumsal_user_token='" . $kullanici_token . "'");
        $alan_token_cek = mysql_fetch_assoc($alan_token_oku);
        $gelen_id = $alan_token_cek["id"];
    }


    $mesajı_kaydet = mysql_query("INSERT INTO `mesajlar` (`ilan_id`, `gonderen_id`, `alan_id`,`dogrudan_satis_id`,`mesaj`,`gonderme_zamani`,`gonderen_token`,`alan_token`) 
    VALUES ('$ilan_id', '$kullanici_id','$gelen_id','0','$mesaj','$date_time','$kullanici_token','$token');");


    if ($mesajı_kaydet) {
        echo json_encode(response($statusCode = 200));
    } else {
        echo json_encode(response($statusCode = 500));
    }
}
//Mesaj Gönder Page End

//Favorile Button Begın

if (re("action") == "favorile") {
    $token = re("token");
    $ilan_id = re("ilan_id");
    $uye_tip = re("uye_tip");
    $date_time = date("Y-m-d H:i:s");


    if ($uye_tip == "bireysel") {
        $kullanici_cek = mysql_query("Select * from user where user_token='" . $token . "'");
        $kullanici_oku = mysql_fetch_assoc($kullanici_cek);
        $uye_id = $kullanici_oku["id"];

        $favla = mysql_query("INSERT INTO `favoriler` (`ilan_id`, `dogrudan_satisli_id`, `uye_id`,`favlama_zamani`,`user_token`,`kurumsal_token`) 
        VALUES ('$ilan_id', '0','$uye_id','$date_time','$token','');");

        if ($favla) {
            echo json_encode(response($statusCode = 200));
        } else {
            echo json_encode(response($statusCode = 500));
        }
    }
    if ($uye_tip == "kurumsal") {
        $kullanici_cek = mysql_query("Select * from user where kurumsal_user_token='" . $token . "'");
        $kullanici_oku = mysql_fetch_assoc($kullanici_cek);
        $uye_id = $kullanici_oku["id"];

        $favla = mysql_query("INSERT INTO `favoriler` (`ilan_id`, `dogrudan_satisli_id`, `uye_id`,`favlama_zamani`,`user_token`,`kurumsal_token`) 
        VALUES ('$ilan_id', '0','$uye_id','$date_time','','$token');");
        if ($favla) {
            echo json_encode(response($statusCode = 200));
        } else {
            echo json_encode(response($statusCode = 500));
        }
    }
}
//Favorile Button End

//Doğrudan Favorile Page Begın

if (re("action") == "favorile_dogrudan") {
    $token = re("token");
    $ilan_id = re("ilan_id");
    $uye_tip = re("uye_tip");
    $date_time = date("Y-m-d H:i:s");


    if ($uye_tip == "bireysel") {
        $kullanici_cek = mysql_query("Select * from user where user_token='" . $token . "'");
        $kullanici_oku = mysql_fetch_assoc($kullanici_cek);
        $uye_id = $kullanici_oku["id"];

        $favla = mysql_query("INSERT INTO `favoriler` (`ilan_id`, `dogrudan_satisli_id`, `uye_id`,`favlama_zamani`,`user_token`,`kurumsal_token`) 
        VALUES ('0', '$ilan_id','$uye_id','$date_time','$token','');");

        if ($favla) {
            echo json_encode(response($statusCode = 200));
        } else {
            echo json_encode(response($statusCode = 500));
        }
    }
    if ($uye_tip == "kurumsal") {
        $kullanici_cek = mysql_query("Select * from user where kurumsal_user_token='" . $token . "'");
        $kullanici_oku = mysql_fetch_assoc($kullanici_cek);
        $uye_id = $kullanici_oku["id"];

        $favla = mysql_query("INSERT INTO `favoriler` (`ilan_id`, `dogrudan_satisli_id`, `uye_id`,`favlama_zamani`,`user_token`,`kurumsal_token`) 
        VALUES ('0', '$ilan_id','$uye_id','$date_time','','$token');");
        if ($favla) {
            echo json_encode(response($statusCode = 200));
        } else {
            echo json_encode(response($statusCode = 500));
        }
    }
}
//Doğrudan Favorile Page End
//İlan Ver Page Begın

if (re("action") == "arac_marka_cek") {
    $arac_markalari_cek = mysql_query("Select * from marka");
    while ($markalari_oku = mysql_fetch_array($arac_markalari_cek)) {
        $listingMap[] =
            [
                "arac_marka" => $markalari_oku["marka_adi"],
                "marka_id" => $markalari_oku["markaID"]
            ];
    }

    if (mysql_num_rows($arac_markalari_cek) >= 0) $statusCode = 200;

    $response = ["message" => "Markalar Getirildi", "Markalar Detay" => $arac_markalari_cek, "status" => $statusCode];

    echo json_encode(response($listingMap, $statusCode));
}

if (re("action") == "arac_model_cek") {
    $marka = re("arac_marka");

    $arac_modelleri_cek = mysql_query("Select * from model where marka_id='" . $marka . "'");

    while ($modelleri_oku = mysql_fetch_array($arac_modelleri_cek)) {
        $listingMap[] =
            [
                "arac_model" => $modelleri_oku["model_adi"],
                "model_id" => $modelleri_oku["modelID"]
            ];
    }

    if (mysql_num_rows($arac_modelleri_cek) >= 0) $statusCode = 200;

    $response = ["message" => "Modeller Getirildi", "Modeller Detay" => $arac_modelleri_cek, "status" => $statusCode];

    echo json_encode(response($listingMap, $statusCode));
}

if (re("action") == "arac_model_cek_ada") {
    $marka = re("arac_marka");

    $marka_id_cek = mysql_query("Select * from marka where marka_adi='" . $marka . "'");
    $marka_id_bas = mysql_fetch_assoc($marka_id_cek);
    $marka_id = $marka_id_bas["markaID"];

    $arac_modelleri_cek = mysql_query("Select * from model where marka_id='" . $marka_id . "'");

    while ($modelleri_oku = mysql_fetch_array($arac_modelleri_cek)) {
        $listingMap[] =
            [
                "arac_model" => $modelleri_oku["model_adi"],
                "model_id" => $modelleri_oku["modelID"]
            ];
    }

    if (mysql_num_rows($arac_modelleri_cek) >= 0) $statusCode = 200;

    $response = ["message" => "Modeller Getirildi", "Modeller Detay" => $arac_modelleri_cek, "status" => $statusCode];

    echo json_encode(response($listingMap, $statusCode));
}

if (re("action") == "ihaledeki_ilanlarim_count") {
    $token = re("user_token");


    $ihaledeki_ilanlarim_cek = mysql_query("Select * from ilanlar where ihale_sahibi='" . $token . "'");
    $ihale_say = mysql_num_rows($ihaledeki_ilanlarim_cek);

    $listingMap[] =
        [
            "ihaledeki_arac_say" => $ihale_say

        ];

    $response = ["message" => "İhale Sayısı", "İhale Detay" => $ihale_say, "status" => $statusCode];

    echo json_encode(response($listingMap, $statusCode));
}
if (re("action") == "dogrudan_satisli_ilanlarim_count") {
    $token = re("user_token");
    $ihaledeki_ilanlarim_cek = mysql_query("Select * from dogrudan_satisli_ilanlar where ilan_sahibi='" . $token . "'");
    $ihale_say = mysql_num_rows($ihaledeki_ilanlarim_cek);

    $listingMap[] =
        [
            "ihaledeki_arac_say" => $ihale_say

        ];

    $response = ["message" => "İhale Sayısı", "İhale Detay" => $ihaledeki_ilanlarim_cek, "status" => $statusCode];

    echo json_encode(response($listingMap, $statusCode));
}



if (re("action") == "arac_model_yili") {
    $date_year = date("Y");

    for ($i = 1950; $i < $date_year + 1; $i++) {
        $listingMap[] = [
            "model_yili" => $i
        ];
    }

    $response = ["message" => "Yıllar Getirildi", "status" => $statusCode];

    echo json_encode(response($listingMap, $statusCode));
}

if (re("action") == "ihale_sehirler") {
    echo json_encode(response(il_cek()));
}

if (re("action") == "ihale_ilceler") {
    $il_id = re("il_id");


    echo json_encode(response(ilce_cek_ada_gore($il_id)));
}


if (re("action") == "dogrudan_ilceler") {
    $il_id = re("il_id");

    echo json_encode(response(ilce_cek($il_id)));
}

if (re("action") == "ihale_ver") {
    $token = re("token");
    $arac_markalari = re("arac_markalari");
    $arac_modeli = re("arac_modeli");
    $ihale_model_yili = re("ihale_model_yili");
    $ihale_ver_km_bilgisi = re("ihale_ver_km_bilgisi");
    $ihale_ver_arac_tipi = re("ihale_ver_arac_tipi");
    $ihale_ver_hasar_bilgisi = re("ihale_ver_hasar_bilgisi");
    $ihale_ver_evrak_durumu = re("ihale_ver_evrak_durumu");
    $arac_en_dusuk_fiyati = re("arac_borcu");
    $arac_donanimlar = re("arac_donanimlar");
    $arac_adres = re("arac_adres");
    $arac_fiyat = re("arac_fiyat");
    $ihale_adınız_soyadınız = re("ihale_adınız_soyadınız");
    $ihale_irtibat_tel = re("ihale_irtibat_tel");
    $ilan_sehirler = re("ilan_sehirler");
    $ihale_ilce = re("ihale_ilce");
    $arac_not = re("arac_not");
    $bugun = date("Y.m.d");
    $arac_kodu = md5(uniqid(mt_rand(5, 15), true));
    $acilis_fiyati = 1000;
    $ihale_tarihi = date("Y.m.d", strtotime('+1 days'));
    $ihale_saati = date('H:i', strtotime("10:00"));
    $ihale_ver_plaka = re("ihale_ver_plaka");
    $ihale_vites_tipi = re("ihale_vites_tipi");
    $ihale_yakit_tipi = re("ihale_yakit_tipi");

    $en_dusuk = 0;

    if (empty($arac_en_dusuk_fiyati)) {
        $en_dusuk = $acilis_fiyati;
    } else {
        $en_dusuk = $arac_en_dusuk_fiyati;
    }
    $insert = mysql_query("INSERT INTO `ilanlar` (`id`,`plaka`,`arac_kodu`,`hesaplama`,`sigorta`,`marka`,`model`,
            `tip`,`model_yili`,`piyasa_degeri`,`tsrsb_degeri`,`acilis_fiyati`,`son_teklif`,`profil`,`sehir`,`ilce`,`ihale_tarihi`,
            `ihale_saati`,`pd_hizmet`,`otopark_giris`,`otopark_ucreti`,`cekici_ucreti`,`dosya_masrafi`,`link`,
            `kilometre`,`uyari_notu`,`hasar_bilgileri`,`notlar`,`adres`,`donanimlar`,`vitrin`,`eklenme_zamani`,
            `ilan_url`,`ihale_sahibi`,`ihale_acilis`,`durum`,`ihale_turu`,`vites_tipi`,`yakit_tipi`) VALUES (NULL,'$ihale_ver_plaka','$arac_kodu','',
            '1','$arac_markalari','$arac_modeli','$ihale_ver_arac_tipi','$ihale_model_yili','$arac_fiyat','$arac_fiyat','$en_dusuk',
            '','$ihale_ver_evrak_durumu','$ilan_sehirler','$ihale_ilce','$ihale_tarihi','$ihale_saati','','','',
            '','','','$ihale_ver_km_bilgisi','','$ihale_ver_hasar_bilgisi','$arac_not','$arac_adres', 
            '$arac_donanimlar','','$bugun','$ad','$token','','0','1','$ihale_vites_tipi','$ihale_yakit_tipi');");

    if ($insert) {
        echo json_encode(response($statusCode = 200));
    } else {
        echo json_encode(response($statusCode = 500));
    }
}

if (re("action") == "ihale_ver_dogrudan") {
    $token = re("token");
    $arac_markalari = re("arac_markalari");
    $arac_modeli = re("arac_modeli");
    $ihale_model_yili = re("ihale_model_yili");
    $ihale_ver_km_bilgisi = re("ihale_ver_km_bilgisi");
    $ihale_ver_arac_tipi = re("ihale_ver_arac_tipi");
    $ihale_ver_hasar_bilgisi = re("ihale_ver_hasar_bilgisi");
    $ihale_ver_evrak_durumu = re("ihale_ver_evrak_durumu");
    $arac_borcu = re("arac_borcu");
    $arac_donanimlar = re("arac_donanimlar");
    $arac_adres = re("arac_adres");
    $arac_fiyat = re("arac_fiyat");
    $ihale_adınız_soyadınız = re("ihale_adınız_soyadınız");
    $ihale_irtibat_tel = re("ihale_irtibat_tel");
    $ilan_sehirler = re("ilan_sehirler");
    $ihale_ilce = re("ihale_ilce");
    $arac_not = re("arac_not");
    $bugun = date("Y.m.d");
    $arac_kodu = md5(uniqid(mt_rand(5, 15), true));
    $acilis_fiyati = 1000;
    $ihale_tarihi = date("Y-m-d");
    $ihale_saati = date('H:i:s');
    $ihale_ver_plaka = re("ihale_ver_plaka");
    $ihale_vites_tipi = re("ihale_vites_tipi");
    $ihale_yakit_tipi = re("ihale_yakit_tipi");

    $insert = mysql_query("INSERT INTO `dogrudan_satisli_ilanlar` (`plaka`,`arac_kodu`,`bitis_tarihi`,`fiyat`,`aracin_durumu`,`sehir`,
            `ilce`,`marka`,`model`,`model_yili`,`uzanti`,`kilometre`,`yakit_tipi`,`vites_tipi`,`evrak_tipi`,
            `hasar_durumu`,`aracin_adresi`,`aciklamalar`,`ilan_url`,`ilan_sahibi`,`eklenme_tarihi`,`eklenme_saati`,           
            `durum`) VALUES ('$ihale_ver_plaka','$arac_kodu','','$arac_fiyat','$ihale_ver_hasar_bilgisi','$ilan_sehirler',
            '$ihale_ilce','$arac_markalari','$arac_modeli','$ihale_model_yili','$ihale_ver_arac_tipi',
            '$ihale_ver_km_bilgisi','$ihale_yakit_tipi','$ihale_vites_tipi','$ihale_ver_evrak_durumu',
            '$ihale_ver_hasar_bilgisi','$arac_adres','$arac_not','','$token','$ihale_tarihi','$ihale_saati', 
            '0');");

    if ($insert) {
        echo json_encode(response($statusCode = 200));
    } else {
        echo json_encode(response($statusCode = 500));
    }
}

if (re("action") == "foto_ekle") {
    $son_id_cek = mysql_query("Select * from ilanlar order by id desc");
    $son_id_oku = mysql_fetch_assoc($son_id_cek);
    $son_id = $son_id_oku["id"];

    $out = [];
    $access_token = re("_access_token");
    if (isset($_FILES["foto"])) {
        $file = $_FILES["foto"];
        if (strlen($file["name"]) >= 3) {
            if ($file["name"]) {
                $new_file_name = uniqid() . time() . "_" . $file["name"];
                $path = "../images/";
                $upload = move_uploaded_file($file["tmp_name"], $path . $new_file_name);
                if ($upload) {
                    $yol2 = $new_file_name;
                    $ekle = mysql_query("insert into ilan_resimler (id,ilan_id,resim,durum)
                    values (null,'" . $son_id . "','" . $yol2 . "','0')
                    ");
                    if ($ekle) {

                        $out["status"] = 200;
                        $out["new_photo"] = $new_file_name;
                    } else {
                        $out["message"] = "Hata";
                        $out["status"] = 500;
                    }
                } else {
                    $out["message"] = "Profil resmi yüklenemedi";
                    $out["status"] = 500;
                }
            } else {
                $out["message"] = "Lütfen geçerli formatta bir resim seçiniz.";
                $out["status"] = 500;
            }
        } else {
            $out["message"] = "Lütfen resim seçiniz.";
            $out["status"] = 500;
        }
    } else {
        $out["message"] = "Lütfen resim seçiniz.";
        $out["status"] = 500;
    }
    echo json_encode($out);
}

//İlan Ver Page End

//Doğrudan ilan Ver Page Begın


if (re("action") == "foto_dogrudan_ekle") {
    $son_id_cek = mysql_query("Select * from dogrudan_satisli_ilanlar order by id desc");
    $son_id_oku = mysql_fetch_assoc($son_id_cek);
    $son_id = $son_id_oku["id"];

    $out = [];
    $access_token = re("_access_token");
    if (isset($_FILES["foto"])) {
        $file = $_FILES["foto"];
        if (strlen($file["name"]) >= 3) {
            if ($file["name"]) {
                $new_file_name = uniqid() . time() . "_" . $file["name"];
                $path = "../images/";
                $upload = move_uploaded_file($file["tmp_name"], $path . $new_file_name);
                if ($upload) {
                    $yol2 = $new_file_name;
                    $ekle = mysql_query("insert into dogrudan_satisli_resimler (id,ilan_id,resim)
                    values (null,'" . $son_id . "','" . $yol2 . "')
                    ");
                    if ($ekle) {

                        $out["status"] = 200;
                        $out["new_photo"] = $new_file_name;
                    } else {
                        $out["message"] = "Hata";
                        $out["status"] = 500;
                    }
                } else {
                    $out["message"] = "Profil resmi yüklenemedi";
                    $out["status"] = 500;
                }
            } else {
                $out["message"] = "Lütfen geçerli formatta bir resim seçiniz.";
                $out["status"] = 500;
            }
        } else {
            $out["message"] = "Lütfen resim seçiniz.";
            $out["status"] = 500;
        }
    } else {
        $out["message"] = "Lütfen resim seçiniz.";
        $out["status"] = 500;
    }
    echo json_encode($out);
}

//Doğrudan ilan Ver Page End

//İlan Mesajlarım Page Begın
if (re("action") == "ilan_mesajlarim") {
    $token = re("token");
    $uye_paketim = re("uye_paketi");

    $mesajlarimi_cek = mysql_query("Select * from mesajlar where gonderen_token='" . $token . "' group by ilan_id");
    while ($mesajlar_oku = mysql_fetch_array($mesajlarimi_cek)) {
        $listingMap[] = [
            "ilan_id" => $mesajlar_oku["ilan_id"],
            "ilan_detaylari" => ilan_cek($uye_paketim, $mesajlar_oku["ilan_id"]),
        ];
    }

    if (mysql_num_rows($mesajlarimi_cek) >= 0) $statusCode = 200;

    $response = ["message" => "Mesajlar Getirildi", "Mesajlar Detay" => $mesajlarimi_cek, "status" => $statusCode];

    echo json_encode(response($listingMap, $statusCode));
}
//İlan Mesajlarım Page End

if (re("action") == "mesaj_sayisi") {
    $token = re("user_token");

    $mesajlarimi_cek = mysql_query("Select * from mesajlar where gonderen_token='" . $token . "' group by ilan_id");
    $mesaj_sayisi = mysql_num_rows($mesajlarimi_cek);

    $listingMap[] = [
        "mesaj_sayisi" => $mesaj_sayisi
    ];

    if (mysql_num_rows($mesajlarimi_cek) >= 0) $statusCode = 200;

    $response = ["message" => "Mesaj Sayısı Getirildi", "Mesaj Detay" => $mesajlarimi_cek, "status" => $statusCode];

    echo json_encode(response($listingMap, $statusCode));
}
//Yorumlarım Page Begın
if (re("action") == "yorumlarim") {
    $token = re("user_token");
    $uye_tip = re("uye_tipi");
    $uye_paketim = re("uye_paketim");


    if ($uye_tip == "bireysel") {
        $uye_id_cek = mysql_query("Select * from user where user_token='" . $token . "'");
        $uye_id_oku = mysql_fetch_assoc($uye_id_cek);
        $uye_id = $uye_id_oku["id"];
    }
    if ($uye_tip == "kurumsal") {
        $uye_id_cek = mysql_query("Select * from user where kurumsal_user_token='" . $token . "'");
        $uye_id_oku = mysql_fetch_assoc($uye_id_cek);
        $uye_id = $uye_id_oku["id"];
    }

    $yorumlarimi_cek = mysql_query("Select * from yorumlar  where  uye_id='" . $uye_id . "'");
    while ($yorumlarimi_bas = mysql_fetch_array($yorumlarimi_cek)) {
        $listingMap[] = [
            "yorum" => $yorumlarimi_bas["yorum"],
            "ilan_verileri" => ilan_cek($uye_paketim, $yorumlarimi_bas["ilan_id"]),
            "yorum_tarihi" => tarih_saat_formatla($yorumlarimi_bas["yorum_zamani"])
        ];
    }

    if (mysql_num_rows($yorumlarimi_cek) >= 0) $statusCode = 200;

    $response = ["message" => "Yorumlar Getirildi", "Yorumlar Detay" => $yorumlarimi_cek, "status" => $statusCode];

    echo json_encode(response($listingMap, $statusCode));
}
//Yorumlarım Page End

//Yorumlarim Count Page Begın
if (re("action") == "profile_yorumlarim") {
    $token = re("user_token");
    $uye_tip = re("uye_tip");

    if ($uye_tip == "bireysel") {
        $uye_id_cek = mysql_query("Select * from user where user_token='" . $token . "'");
        $uye_id_oku = mysql_fetch_assoc($uye_id_cek);
        $uye_id = $uye_id_oku["id"];
    }
    if ($uye_tip == "kurumsal") {
        $uye_id_cek = mysql_query("Select * from user where kurumsal_user_token='" . $token . "'");
        $uye_id_oku = mysql_fetch_assoc($uye_id_cek);
        $uye_id = $uye_id_oku["id"];
    }

    $yorum_say = mysql_query("Select * from yorumlar where uye_id='" . $uye_id . "' ");
    $yorum_sayisi = mysql_num_rows($yorum_say);

    $listingMap[] = [
        "yorum_sayisi" => $yorum_sayisi
    ];

    if (mysql_num_rows($yorum_say) >= 0) $statusCode = 200;

    $response = ["message" => "Yorum Sayısı", "Yorumlar Detay" => $yorum_say, "status" => $statusCode];

    echo json_encode(response($listingMap, $statusCode));
}
//Yorumlarim Count Page End

//Tüm Yorumlar Page Begın

function uye_adi_yildizli($uye_id){
    $turkish = array("ı", "ğ", "ü", "ş", "ö", "ç");
    $english   = array("i", "g", "u", "s", "o", "c");
    $cek = mysql_query("select * from user where id = '".$uye_id."'");
    $oku = mysql_fetch_object($cek);
    $gelen_user_name = $oku->ad;
    $user_name = str_replace($turkish, $english, $gelen_user_name);
    $pieces = explode(" ", $user_name);
    $sonuc = "";
    foreach ($pieces as $piece) {
        if ($piece != " ") {
            $text_array = str_split($piece);
            foreach ($text_array as $key => $value) {
                if ($key == 0) {
                    $sonuc .= $value;
                } else {
                    $sonuc .= "*";
                }
            }
            $sonuc .= " ";
        }
    }
    return $sonuc;
}

if (re("action") == "tum_yorumlar") {
    $uye_paketi = re("uye_paketi");
    $cek = mysql_query("select * from yorumlar where arac_bilgileri <> '' and ( durum = 1 or durum=3) order by yorum_zamani desc");
    while($oku = mysql_fetch_object($cek)){

        $admin_bilgileri = mysql_query("Select * from kullanicilar where id='".$oku->cevaplayan."'");
        $admin_bilgi_oku = mysql_fetch_assoc($admin_bilgileri);
        $admin_adi = $admin_bilgi_oku["ad"];

        $admin_say = strlen($admin_adi);

        $listingMap[] = [
            "id" => $oku->id,
            "ilan_id" => $oku->ilan_id,
            "uye_id" => $oku->uye_id,
            "yorum_yapan" => uye_adi_yildizli($oku->uye_id),
            "yorum" => $oku->yorum,
            "yorum_zamani" => tarih_saat_formatla($oku->yorum_zamani),
            "cevap" => $oku->cevap,
            "cevap_tarihi" => tarih_saat_formatla($oku->cevap_zamani),
            "cevaplayan" => private_str($admin_adi, 1, $admin_say),
            "arac_bilgileri" => $oku->arac_bilgileri 
        ];
    }
    echo json_encode(response($listingMap));
    /*
    $tum_yorumlari_cek = mysql_query("Select * from yorumlar ");
    while ($yorumlari_oku = mysql_fetch_array($tum_yorumlari_cek)) {
        $uye_bilgileri = mysql_query("Select * from user where id='" . $yorumlari_oku["uye_id"] . "'");
        $uye_bilgi_oku = mysql_fetch_assoc($uye_bilgileri);
        $uye_adi = $uye_bilgi_oku["ad"];
        $array = explode(" ", $uye_adi);
        $say_1 = strlen($array[0]);
        $say_2 = strlen($array[1]);

        $admin_bilgileri = mysql_query("Select * from kullanicilar where id='" . $yorumlari_oku["cevaplayan"] . "'");
        $admin_bilgi_oku = mysql_fetch_assoc($admin_bilgileri);
        $admin_adi = $admin_bilgi_oku["ad"];

        $admin_say = strlen($admin_adi);

        $listingMap[] = [
            "yorum" => $yorumlari_oku["yorum"],
            "yorum_zamani" => tarih_saat_formatla($yorumlari_oku["yorum_zamani"]),
            "ilan_verileri" => ilan_cek($uye_paketi, $yorumlari_oku["ilan_id"]),
            "uye_adi" => private_str($array[0], 1, $say_1),
            "uye_soyadi" => private_str($array[1], 1, $say_2),
            "cevap" => $yorumlari_oku["cevap"],
            "cevap_tarihi" => tarih_saat_formatla($yorumlari_oku["cevap_zamani"]),
            "cevaplayan" => private_str($admin_adi, 1, $admin_say)
        ];
    }
    if (mysql_num_rows($tum_yorumlari_cek) >= 0) $statusCode = 200;

    $response = ["message" => "Tüm Yorumlar ", "Tüm Yorumlar Detay" => $tum_yorumlari_cek, "status" => $statusCode];

    echo json_encode(response($listingMap, $statusCode));
    */
}
//Tüm Yorumlar Page End

if (re("action") == "kullanici_getir") {
    $token = re("token");

    echo json_encode(response(kullanici_veri_cek($token)));
}

//Tüm Yorumlar Count Begı
if (re("action") == "tum_yorumlar_profile") {
    $tum_yorumlar = mysql_query("Select * from yorumlar");
    $yorumlari_say = mysql_num_rows($tum_yorumlar);

    $listingMap[] = [
        "tum_yorum_sayisi" => $yorumlari_say,
    ];

    if (mysql_num_rows($tum_yorumlar) >= 0) $statusCode = 200;

    $response = ["message" => "Tüm Yorumlar ", "Tüm Yorumlar Detay" => $tum_yorumlar, "status" => $statusCode];

    echo json_encode(response($listingMap, $statusCode));
}
//Tüm Yorumlar Count End

//ihaleler Filtre Page Begın
if (re("action") == "sehirleri_getir_filtre") {
    echo json_encode(response(il_cek()));
}
//ihaleler Filtre Page End

//Filtre İhale Tarih Saat Begın

if (re("action") == "ihale_filtre_tarih") {
    $date = date("d-m-Y");

    $dun = date("d-m-Y", mktime(0, 0, 0, date("m"), date("d") - 1, date("Y")));
    $yarin = date("d-m-Y", mktime(0, 0, 0, date("m"), date("d") + 1, date("Y")));

    $listingMap[] = [
        "bugun" => $date,
        "yarin" => $yarin,
        "dun" => $dun
    ];

    $response = ["message" => "Tarihler ", "Tarihler Detay" => $tum_yorumlar, "status" => $statusCode];

    echo json_encode(response($listingMap, $statusCode));
}
//Filtre İhale Tarih Saat End

//Aranan İlanlar Page Begın

if (re("action") == "filtre_secenekleri_ihale") {
    $ihale_turu = re("ihale_turu");
    $iller = re("iller");
    $tarih = re("tarih");
    $ozellik = re("ozellik");

    $date = str_replace('/', '-', $tarih);
    $yeni_tarih = date('Y-m-d', strtotime($date));

    $il_cek = mysql_query("Select * from sehir where sehirID='" . $iller . "'");
    $il_oku = mysql_fetch_assoc($il_cek);
    $il_adi = $il_oku["sehiradi"];

    $ilan_sorgula = mysql_query("Select * from ilanlar where ihale_turu='" . $ihale_turu . "' and sehir='" . $il_adi . "' and 
    profil='" . $ozellik . "' and ihale_tarihi='" . $yeni_tarih . "'");

    while ($ilanlari_listele = mysql_fetch_array($ilan_sorgula)) {
        $listingMap[] = [
            "ilan_verileri" => ilan_cek($ilanlari_listele["id"]),
        ];
    }

    if (mysql_num_rows($ilan_sorgula) >= 0) $statusCode = 200;

    $response = ["message" => "İlanları Çek ", "İlanlar Detay" => $ilan_sorgula, "status" => $statusCode];

    echo json_encode(response($listingMap, $statusCode));
}
//Aranan İlanlar Page End

//Aktif Cayma Talepleri Begin
if (re("action") == "aktif_cayma_taleplerim") {
    $token = re("token");
    $uye_tip = re("uye_tip");
    $durum = 1;
    if ($uye_tip == "bireysel") {
        $kullanici_cek = mysql_query("Select * from user where user_token='" . $token . "'");
        $bilgi_oku = mysql_fetch_assoc($kullanici_cek);
        $uye_id = $bilgi_oku["id"];

        $cayma_bedeli = mysql_query("Select * from cayma_bedelleri where uye_id='" . $uye_id . "' and durum='1' ");

        while ($cayma_detaylari_cek = mysql_fetch_array($cayma_bedeli)) {


            /*$listingMap[] = [
                "cayma_id" => $cayma_detaylari_cek["id"],
                "tarih" => tarih_saat_formatla($cayma_detaylari_cek["iade_tarihi"]),
                "tutar" => fiyat_formatla($cayma_detaylari_cek["tutar"]),
                "hesap_ismi" => $cayma_detaylari_cek["hesap_sahibi"],
                "ıban" => $cayma_detaylari_cek["iban"]
            ];*/
			$listingMap[] = [
                "cayma_id" => $cayma_detaylari_cek["id"],
                "tarih" => tarih_saat_formatla($cayma_detaylari_cek["paranin_geldigi_tarih"]),
                "tutar" => fiyat_formatla($cayma_detaylari_cek["tutar"]),
                "hesap_ismi" => $cayma_detaylari_cek["hesap_sahibi"],
                "ıban" => $cayma_detaylari_cek["iban"]
            ];
        }

        if (mysql_num_rows($cayma_bedeli) >= 0) $statusCode = 200;

        $response = ["message" => "İlanları Çek ", "İlanlar Detay" => $cayma_bedeli, "status" => $statusCode];

        echo json_encode(response($listingMap, $statusCode));
    }
    if ($uye_tip == "kurumsal") {
        $kullanici_cek = mysql_query("Select * from user where kurumsal_user_token='" . $token . "'");
        $bilgi_oku = mysql_fetch_assoc($kullanici_cek);
        $uye_id = $bilgi_oku["id"];

        $cayma_bedeli = mysql_query("Select * from cayma_bedelleri where  uye_id='" . $uye_id . "' and durum='1' ");
        while ($cayma_detaylari_cek = mysql_fetch_array($cayma_bedeli)) {
            /*$listingMap[] = [
                "cayma_id" => $cayma_detaylari_cek["id"],
                "tarih" => tarih_saat_formatla($cayma_detaylari_cek["iade_tarihi"]),
                "tutar" => fiyat_formatla($cayma_detaylari_cek["tutar"]),
                "hesap_ismi" => $cayma_detaylari_cek["hesap_sahibi"],
                "ıban" => $cayma_detaylari_cek["iban"]
            ];*/
			$listingMap[] = [
                "cayma_id" => $cayma_detaylari_cek["id"],
                "tarih" => tarih_saat_formatla($cayma_detaylari_cek["paranin_geldigi_tarih"]),
                "tutar" => fiyat_formatla($cayma_detaylari_cek["tutar"]),
                "hesap_ismi" => $cayma_detaylari_cek["hesap_sahibi"],
                "ıban" => $cayma_detaylari_cek["iban"]
            ];
        }

        if (mysql_num_rows($cayma_bedeli) >= 0) $statusCode = 200;

        $response = ["message" => "İlanları Çek ", "İlanlar Detay" => $cayma_bedeli, "status" => $statusCode];

        echo json_encode(response($listingMap, $statusCode));
    }
}

//Aktif Cayma Talepleri End

if (re("action") == "iade_taleplerim") {
    $token = re("token");
    $uye_tip = re("uye_tip");
    $durum = 2;
    if ($uye_tip == "bireysel") {
       $user="user_token";
    }else {
       $user="kurumsal_user_token";
    }
	$kullanici_cek = mysql_query("Select * from user where ".$user."='" . $token . "'");
	$bilgi_oku = mysql_fetch_assoc($kullanici_cek);
	$uye_id = $bilgi_oku["id"];

	$cayma_bedeli = mysql_query("Select * from cayma_bedelleri where  uye_id='" . $uye_id . "' and durum='1' ");
	while ($cayma_detaylari_cek = mysql_fetch_array($cayma_bedeli)) {
		$listingMap[] = [
			"cayma_id" => $cayma_detaylari_cek["id"],
			"tarih" => tarih_saat_formatla($cayma_detaylari_cek["iade_talep_tarihi"]),
			"tutar" => fiyat_formatla($cayma_detaylari_cek["tutar"]),
			"hesap_ismi" => $cayma_detaylari_cek["hesap_sahibi"],
			"ıban" => $cayma_detaylari_cek["iban"]
		];
	}

	if (mysql_num_rows($cayma_bedeli) >= 0) $statusCode = 200;

	$response = ["message" => "İlanları Çek ", "İlanlar Detay" => $cayma_bedeli, "status" => $statusCode];

	echo json_encode(response($listingMap, $statusCode));
}
if (re("action") == "iade_edilenler") {
    $token = re("token");
    $uye_tip = re("uye_tip");
    $durum = 3;
    if ($uye_tip == "bireysel") {
       $user="user_token";
    }else {
       $user="kurumsal_user_token";
    }
	$kullanici_cek = mysql_query("Select * from user where ".$user."='" . $token . "'");
	$bilgi_oku = mysql_fetch_assoc($kullanici_cek);
	$uye_id = $bilgi_oku["id"];

	$cayma_bedeli = mysql_query("Select * from cayma_bedelleri where  uye_id='" . $uye_id . "' and durum='1' ");
	while ($cayma_detaylari_cek = mysql_fetch_array($cayma_bedeli)) {
		$listingMap[] = [
			"cayma_id" => $cayma_detaylari_cek["id"],
			"tarih" => tarih_saat_formatla($cayma_detaylari_cek["iade_tarihi"]),
			"tutar" => fiyat_formatla($cayma_detaylari_cek["tutar"]),
			"hesap_ismi" => $cayma_detaylari_cek["hesap_sahibi"],
			"ıban" => $cayma_detaylari_cek["iban"]
		];
	}

	if (mysql_num_rows($cayma_bedeli) >= 0) $statusCode = 200;

	$response = ["message" => "İlanları Çek ", "İlanlar Detay" => $cayma_bedeli, "status" => $statusCode];

	echo json_encode(response($listingMap, $statusCode));
}
if (re("action") == "mahsup_edilenler") {
    $token = re("token");
    $uye_tip = re("uye_tip");
    $durum = 4;
    if ($uye_tip == "bireysel") {
       $user="user_token";
    }else {
       $user="kurumsal_user_token";
    }
	$kullanici_cek = mysql_query("Select * from user where ".$user."='" . $token . "'");
	$bilgi_oku = mysql_fetch_assoc($kullanici_cek);
	$uye_id = $bilgi_oku["id"];

	$cayma_bedeli = mysql_query("Select * from cayma_bedelleri where  uye_id='" . $uye_id . "' and durum='1' ");
	while ($cayma_detaylari_cek = mysql_fetch_array($cayma_bedeli)) {
		$listingMap[] = [
			"cayma_id" => $cayma_detaylari_cek["id"],
			"tarih" => tarih_saat_formatla($cayma_detaylari_cek["mahsup_tarihi"]),
			"tutar" => fiyat_formatla($cayma_detaylari_cek["tutar"]),
			"arac_kod_plaka" => $cayma_detaylari_cek["arac_kod_plaka"],
			"arac_detay" => $cayma_detaylari_cek["arac_detay"]
		];
	}

	if (mysql_num_rows($cayma_bedeli) >= 0) $statusCode = 200;

	$response = ["message" => "İlanları Çek ", "İlanlar Detay" => $cayma_bedeli, "status" => $statusCode];

	echo json_encode(response($listingMap, $statusCode));
}
if (re("action") == "cayilan_caymalar") {
    $token = re("token");
    $uye_tip = re("uye_tip");
    $durum = 5;
    if ($uye_tip == "bireysel") {
       $user="user_token";
    }else {
       $user="kurumsal_user_token";
    }
	$kullanici_cek = mysql_query("Select * from user where ".$user."='" . $token . "'");
	$bilgi_oku = mysql_fetch_assoc($kullanici_cek);
	$uye_id = $bilgi_oku["id"];

	$cayma_bedeli = mysql_query("Select * from cayma_bedelleri where  uye_id='" . $uye_id . "' and durum='1' ");
	while ($cayma_detaylari_cek = mysql_fetch_array($cayma_bedeli)) {
		$listingMap[] = [
			"cayma_id" => $cayma_detaylari_cek["id"],
			"tarih" => tarih_saat_formatla($cayma_detaylari_cek["bloke_tarihi"]),
			"tutar" => fiyat_formatla($cayma_detaylari_cek["tutar"]),
			"arac_kod_plaka" => $cayma_detaylari_cek["arac_kod_plaka"],
			"arac_detay" => $cayma_detaylari_cek["arac_detay"]
		];
	}

	if (mysql_num_rows($cayma_bedeli) >= 0) $statusCode = 200;

	$response = ["message" => "İlanları Çek ", "İlanlar Detay" => $cayma_bedeli, "status" => $statusCode];

	echo json_encode(response($listingMap, $statusCode));
}
if(re("action") == "blokeli_borclar") {
    $token = re("token");
    $uye_tip = re("uye_tip");
    $durum = 6;
    if ($uye_tip == "bireysel") {
       $user="user_token";
    }else {
       $user="kurumsal_user_token";
    }
	$kullanici_cek = mysql_query("Select * from user where ".$user."='" . $token . "'");
	$bilgi_oku = mysql_fetch_assoc($kullanici_cek);
	$uye_id = $bilgi_oku["id"];

	$cayma_bedeli = mysql_query("Select * from cayma_bedelleri where  uye_id='" . $uye_id . "' and durum='1' ");
	while ($cayma_detaylari_cek = mysql_fetch_array($cayma_bedeli)) {
		$listingMap[] = [
			"cayma_id" => $cayma_detaylari_cek["id"],
			"tarih" => tarih_saat_formatla($cayma_detaylari_cek["bloke_tarihi"]),
			"tutar" => fiyat_formatla($cayma_detaylari_cek["tutar"]),
			"arac_kod_plaka" => $cayma_detaylari_cek["arac_kod_plaka"],
			"arac_detay" => $cayma_detaylari_cek["arac_detay"]
		];
	}

	if (mysql_num_rows($cayma_bedeli) >= 0) $statusCode = 200;

	$response = ["message" => "İlanları Çek ", "İlanlar Detay" => $cayma_bedeli, "status" => $statusCode];

	echo json_encode(response($listingMap, $statusCode));
}
if(re("action") == "tahsil_edilenler") {
    $token = re("token");
    $uye_tip = re("uye_tip");
    $durum = 7;
    if ($uye_tip == "bireysel") {
       $user="user_token";
    }else {
       $user="kurumsal_user_token";
    }
	$kullanici_cek = mysql_query("Select * from user where ".$user."='" . $token . "'");
	$bilgi_oku = mysql_fetch_assoc($kullanici_cek);
	$uye_id = $bilgi_oku["id"];

	$cayma_bedeli = mysql_query("Select * from cayma_bedelleri where  uye_id='" . $uye_id . "' and durum='1' ");
	while ($cayma_detaylari_cek = mysql_fetch_array($cayma_bedeli)) {
		$listingMap[] = [
			"cayma_id" => $cayma_detaylari_cek["id"],
			"tarih" => tarih_saat_formatla($cayma_detaylari_cek["tahsil_tarihi"]),
			"tutar" => fiyat_formatla($cayma_detaylari_cek["tutar"]),
			"arac_kod_plaka" => $cayma_detaylari_cek["arac_kod_plaka"],
			"arac_detay" => $cayma_detaylari_cek["arac_detay"]
		];
	}

	if (mysql_num_rows($cayma_bedeli) >= 0) $statusCode = 200;

	$response = ["message" => "İlanları Çek ", "İlanlar Detay" => $cayma_bedeli, "status" => $statusCode];

	echo json_encode(response($listingMap, $statusCode));
}







//Aktif Borç Bilgilerim Begın

if (re("action") == "aktif_borc_bilgilerim") {
    $token = re("token");
    $uye_tip = re("uye_tip");
    $durum = 1;
    if ($uye_tip == "bireysel") {
        $kullanici_cek = mysql_query("Select * from user where user_token='" . $token . "'");
        $bilgi_oku = mysql_fetch_assoc($kullanici_cek);
        $uye_id = $bilgi_oku["id"];

        $cayma_bedeli = mysql_query("Select * from cayma_bedelleri where uye_id='" . $uye_id . "' and durum='2' ");

        while ($cayma_detaylari_cek = mysql_fetch_array($cayma_bedeli)) {
            $listingMap[] = [
                "cayma_id" => $cayma_detaylari_cek["id"],
                "tarih" => tarih_saat_formatla($cayma_detaylari_cek["iade_tarihi"]),
                "tutar" => fiyat_formatla($cayma_detaylari_cek["tutar"]),
                "hesap_ismi" => $cayma_detaylari_cek["hesap_sahibi"],
                "ıban" => $cayma_detaylari_cek["iban"]
            ];
        }

        if (mysql_num_rows($cayma_bedeli) >= 0) $statusCode = 200;

        $response = ["message" => "İlanları Çek ", "İlanlar Detay" => $cayma_bedeli, "status" => $statusCode];

        echo json_encode(response($listingMap, $statusCode));
    }
    if ($uye_tip == "kurumsal") {
        $kullanici_cek = mysql_query("Select * from user where kurumsal_user_token='" . $token . "'");
        $bilgi_oku = mysql_fetch_assoc($kullanici_cek);
        $uye_id = $bilgi_oku["id"];

        $cayma_bedeli = mysql_query("Select * from cayma_bedelleri where  uye_id='" . $uye_id . "' and durum='2' ");
        while ($cayma_detaylari_cek = mysql_fetch_array($cayma_bedeli)) {
            $listingMap[] = [
                "cayma_id" => $cayma_detaylari_cek["id"],
                "tarih" => tarih_saat_formatla($cayma_detaylari_cek["iade_tarihi"]),
                "tutar" => fiyat_formatla($cayma_detaylari_cek["tutar"]),
                "hesap_ismi" => $cayma_detaylari_cek["hesap_sahibi"],
                "ıban" => $cayma_detaylari_cek["iban"]
            ];
        }

        if (mysql_num_rows($cayma_bedeli) >= 0) $statusCode = 200;

        $response = ["message" => "İlanları Çek ", "İlanlar Detay" => $cayma_bedeli, "status" => $statusCode];

        echo json_encode(response($listingMap, $statusCode));
    }
}
//Aktif Borç Bilgilerim End

//Neden Function Yazmadıysam Tek tek uğraşıyorum :(
//Aktif İade Taleplerim Begın

if (re("action") == "aktif_iade_taleplerim") {
    $token = re("token");
    $uye_tip = re("uye_tip");
    $durum = 1;
    if ($uye_tip == "bireysel") {
        $kullanici_cek = mysql_query("Select * from user where user_token='" . $token . "'");
        $bilgi_oku = mysql_fetch_assoc($kullanici_cek);
        $uye_id = $bilgi_oku["id"];

        $cayma_bedeli = mysql_query("Select * from cayma_bedelleri where uye_id='" . $uye_id . "' and durum='3' ");

        while ($cayma_detaylari_cek = mysql_fetch_array($cayma_bedeli)) {


            $listingMap[] = [
                "cayma_id" => $cayma_detaylari_cek["id"],
                "tarih" => tarih_saat_formatla($cayma_detaylari_cek["iade_tarihi"]),
                "tutar" => fiyat_formatla($cayma_detaylari_cek["tutar"]),
                "hesap_ismi" => $cayma_detaylari_cek["hesap_sahibi"],
                "ıban" => $cayma_detaylari_cek["iban"]
            ];
        }

        if (mysql_num_rows($cayma_bedeli) >= 0) $statusCode = 200;

        $response = ["message" => "İlanları Çek ", "İlanlar Detay" => $cayma_bedeli, "status" => $statusCode];

        echo json_encode(response($listingMap, $statusCode));
    }
    if ($uye_tip == "kurumsal") {
        $kullanici_cek = mysql_query("Select * from user where kurumsal_user_token='" . $token . "'");
        $bilgi_oku = mysql_fetch_assoc($kullanici_cek);
        $uye_id = $bilgi_oku["id"];

        $cayma_bedeli = mysql_query("Select * from cayma_bedelleri where  uye_id='" . $uye_id . "' and durum='3' ");
        while ($cayma_detaylari_cek = mysql_fetch_array($cayma_bedeli)) {
            $listingMap[] = [
                "cayma_id" => $cayma_detaylari_cek["id"],
                "tarih" => tarih_saat_formatla($cayma_detaylari_cek["iade_tarihi"]),
                "tutar" => fiyat_formatla($cayma_detaylari_cek["tutar"]),
                "hesap_ismi" => $cayma_detaylari_cek["hesap_sahibi"],
                "ıban" => $cayma_detaylari_cek["iban"]
            ];
        }

        if (mysql_num_rows($cayma_bedeli) >= 0) $statusCode = 200;

        $response = ["message" => "İlanları Çek ", "İlanlar Detay" => $cayma_bedeli, "status" => $statusCode];

        echo json_encode(response($listingMap, $statusCode));
    }
}


//Aktif İade Taleplerim End

//Aktif İade Aldıklarım Page Begın
if (re("action") == "iade_aldıklarım_html") {
    $token = re("token");
    $uye_tip = re("uye_tip");
    $durum = 1;
    if ($uye_tip == "bireysel") {
        $kullanici_cek = mysql_query("Select * from user where user_token='" . $token . "'");
        $bilgi_oku = mysql_fetch_assoc($kullanici_cek);
        $uye_id = $bilgi_oku["id"];

        $cayma_bedeli = mysql_query("Select * from cayma_bedelleri where uye_id='" . $uye_id . "' and durum='4' ");

        while ($cayma_detaylari_cek = mysql_fetch_array($cayma_bedeli)) {


            $listingMap[] = [
                "cayma_id" => $cayma_detaylari_cek["id"],
                "tarih" => tarih_saat_formatla($cayma_detaylari_cek["iade_tarihi"]),
                "tutar" => fiyat_formatla($cayma_detaylari_cek["tutar"]),
                "hesap_ismi" => $cayma_detaylari_cek["hesap_sahibi"],
                "iban" => $cayma_detaylari_cek["iban"]
            ];
        }

        if (mysql_num_rows($cayma_bedeli) >= 0) $statusCode = 200;

        $response = ["message" => "İlanları Çek ", "İlanlar Detay" => $cayma_bedeli, "status" => $statusCode];

        echo json_encode(response($listingMap, $statusCode));
    }
    if ($uye_tip == "kurumsal") {
        $kullanici_cek = mysql_query("Select * from user where kurumsal_user_token='" . $token . "'");
        $bilgi_oku = mysql_fetch_assoc($kullanici_cek);
        $uye_id = $bilgi_oku["id"];

        $cayma_bedeli = mysql_query("Select * from cayma_bedelleri where uye_id='" . $uye_id . "' and durum='4' ");
        while ($cayma_detaylari_cek = mysql_fetch_array($cayma_bedeli)) {
            $listingMap[] = [
                "cayma_id" => $cayma_detaylari_cek["id"],
                "tarih" => tarih_saat_formatla($cayma_detaylari_cek["iade_tarihi"]),
                "tutar" => fiyat_formatla($cayma_detaylari_cek["tutar"]),
                "hesap_ismi" => $cayma_detaylari_cek["hesap_sahibi"],
                "iban" => $cayma_detaylari_cek["iban"]
            ];
        }

        if (mysql_num_rows($cayma_bedeli) >= 0) $statusCode = 200;

        $response = ["message" => "İlanları Çek ", "İlanlar Detay" => $cayma_bedeli, "status" => $statusCode];

        echo json_encode(response($listingMap, $statusCode));
    }
}
//Aktif İade Aldıklarım Page End

//Iban Bilgisi Kaydet Begın

if (re("action") == "ıban_bilgisi_guncelle") {
    $cayma_id_cek = explode(":", re("cayma_id"));
    $cayma_id = $cayma_id_cek[1];

    $ıban_bilgisi = re("iban_bilgisi");


    $cayma_bedeli = mysql_query("update cayma_bedelleri set iban='" . $ıban_bilgisi . "' where id='" . $cayma_id . "' ");

    if ($cayma_bedeli) {
        echo json_encode(response($statusCode = 200));
    } else {
        echo json_encode(response($statusCode = 500));
    }
}
//Iban Bilgisi Kaydet End

//Iban Bilgisi Cek Begın
if (re("action") == "ıban_bilgisi") {
    $token = re("token");
    $cayma_id_cek = explode(":", re("cayma_id"));
    $cayma_id = $cayma_id_cek[1];

    $ıban_bilgisi = re("iban_bilgisi");


    $cayma_bedeli = mysql_query("select * from cayma_bedelleri where id='" . $cayma_id . "'");
    $ıban_oku = mysql_fetch_assoc($cayma_bedeli);
    $ıban = $ıban_oku["iban"];

    $listingMap[] = [
        "ıban_bilgisi" => $ıban,
    ];


    if (mysql_num_rows($cayma_bedeli) >= 0) $statusCode = 200;

    $response = ["message" => "İlanları Çek ", "İlanlar Detay" => $cayma_bedeli, "status" => $statusCode];

    echo json_encode(response($listingMap, $statusCode));
}
//Iban Bilgisi Cek End

//Paket Başvurusu Begın
if (re("action") == "paket_basvurusu") {
    $token = re("token");
    $basvuru_tip = re("basvuru_tip");
    $uye_tip = re("uye_tip");

    $date_time = date("Y-m-d H:i:s");
    if ($uye_tip == "bireysel") {
        $kullanici_bilgi_cek = mysql_query("Select * from user where user_token='" . $token . "'");
        $bilgi_cek = mysql_fetch_assoc($kullanici_bilgi_cek);
        $kullanici_adi = $bilgi_cek["ad"];
        $kullanici_tel = $bilgi_cek["telefon"];

        $insert = mysql_query("INSERT INTO `gold_uyelik_talepleri` (`uye_adi`, `tur`, `basvuru_tarihi`,`telefon`,`user_token`,`kurumsal_user_token`,`durum`) 
        VALUES ('$kullanici_adi', '$basvuru_tip','$date_time','$kullanici_tel','$token','','0');");

        if ($insert) {
            echo json_encode(response($statusCode = 200));
        } else {
            echo json_encode(response($statusCode = 500));
        }
    }
    if ($uye_tip == "kurumsal") {

        $kullanici_bilgi_cek = mysql_query("Select * from user where kurumsal_user_token='" . $token . "'");
        $bilgi_cek = mysql_fetch_assoc($kullanici_bilgi_cek);
        $kullanici_adi = $bilgi_cek["ad"];
        $kullanici_tel = $bilgi_cek["telefon"];

        $insert = mysql_query("INSERT INTO `gold_uyelik_talepleri` (`uye_adi`, `tur`, `basvuru_tarihi`,`telefon`,`user_token`,`kurumsal_user_token`,`durum`) 
        VALUES ('$kullanici_adi', '$basvuru_tip','$date_time','$kullanici_tel','','$token','0');");
        if ($insert) {
            echo json_encode(response($statusCode = 200));
        } else {
            echo json_encode(response($statusCode = 500));
        }
    }
}
//Paket Başvurusu End

//Home Paket Durumu Begın

if (re("action") == "paket_durumu") {
    $token = re("token");
    $uye_tip = re("uye_tip");

    if ($uye_tip == "bireysel") {
        $kullanici_bilgi = mysql_query("Select * from user where user_token='" . $token . "'");
        $bilgi_oku = mysql_fetch_assoc($kullanici_bilgi);
        $kullanici_paket = $bilgi_oku["paket"];

        $listingMap[] = [
            "tur" => $kullanici_paket,
        ];

        if (mysql_num_rows($uye_tipi_cek) >= 0) $statusCode = 200;

        $response = ["message" => "Tip Çek ", "İlanlar Detay" => $uye_tipi_cek, "status" => $statusCode];

        echo json_encode(response($listingMap, $statusCode));
    }
    if ($uye_tip == "kurumsal") {
        $kullanici_bilgi = mysql_query("Select * from user where kurumsal_user_token='" . $token . "'");
        $bilgi_oku = mysql_fetch_assoc($kullanici_bilgi);
        $kullanici_paket = $bilgi_oku["paket"];

        $listingMap[] = [
            "tur" => $kullanici_paket,
        ];

        if (mysql_num_rows($uye_tipi_cek) >= 0) $statusCode = 200;

        $response = ["message" => "Tip Çek ", "İlanlar Detay" => $uye_tipi_cek, "status" => $statusCode];

        echo json_encode(response($listingMap, $statusCode));
    }
}
//Home Paket Durumu End

//Profile Paket Durumu Begın 


if (re("action") == "paket_durumu_profile") {
    $token = re("token");
    $uye_tip = re("uye_tip");

    if ($uye_tip == "bireysel") {
        $kullanici_bilgi = mysql_query("Select * from user where user_token='" . $token . "'");
        $bilgi_oku = mysql_fetch_assoc($kullanici_bilgi);
        $paket_turu = $bilgi_oku["paket"];


        $uye_grubum = mysql_query("Select * from uye_grubu where id='" . $paket_turu . "'");
        $grup_id_cek = mysql_fetch_assoc($uye_grubum);
        $grup_id = $grup_id_cek["grup_adi"];

        $listingMap[] = [
            "tur" => $grup_id,
        ];

        if (mysql_num_rows($uye_tipi_cek) >= 0) $statusCode = 200;

        $response = ["message" => "Tip Çek ", "İlanlar Detay" => $uye_tipi_cek, "status" => $statusCode];

        echo json_encode(response($listingMap, $statusCode));
    }
    if ($uye_tip == "kurumsal") {
        $kullanici_bilgi = mysql_query("Select * from user where kurumsal_user_token='" . $token . "'");
        $bilgi_oku = mysql_fetch_assoc($kullanici_bilgi);
        $kullanici_id = $bilgi_oku["paket"];

        $uye_grubum = mysql_query("Select * from uye_grubu where id='" . $kullanici_id . "'");
        $grup_id_cek = mysql_fetch_assoc($uye_grubum);
        $grup_id = $grup_id_cek["grup_adi"];

        $listingMap[] = [
            "tur" => $grup_id,
        ];

        if (mysql_num_rows($uye_tipi_cek) >= 0) $statusCode = 200;

        $response = ["message" => "Tip Çek ", "İlanlar Detay" => $uye_tipi_cek, "status" => $statusCode];

        echo json_encode(response($listingMap, $statusCode));
    }
}
//Profile Paket Durumu End

//Home Slider Begın 
if (re("action") == "home_slider_cek") {
    $base_url = "https://ihale.pertdunyasi.com/";
    $slider_cek = mysql_query("Select * from slider where durum='1'");
    while ($slider_bas = mysql_fetch_array($slider_cek)) {
        $listingMap[] = [
            "slider" => $base_url . $slider_bas["resim"]
        ];
    }
    if (mysql_num_rows($slider_cek) >= 0) $statusCode = 200;

    $response = ["message" => "Slider Getirildi ", "Slider Detay" => $slider_cek, "status" => $statusCode];

    echo json_encode(response($listingMap, $statusCode));
} //Home Slider End

//Vekaletname Cek Begın
if (re("action") == "vekaletname_cek") {
    $vekaletname_cek = mysql_query("Select * from pdf");
    $vekaletname_oku = mysql_fetch_assoc($vekaletname_cek);
    $vekaletname_url = $vekaletname_oku["vekaletname"];
    $listingMap[] = [
        "vekaletname_url" => $vekaletname_url
    ];

    if (mysql_num_rows($vekaletname_cek) >= 0) $statusCode = 200;

    $response = ["message" => "Vekaletname Getirildi ", "Vekaletname Detay" => $vekaletname_cek, "status" => $statusCode];

    echo json_encode(response($listingMap, $statusCode));
} //Vekaletname Cek End

//Kullanım Kılavuzu Cek Begın
if (re("action") == "kullanim_klavuzu_cek") {
    $kullanim_kilavuzu_url_cek = mysql_query("Select * from pdf");
    $kullanim_kilavuzu_oku = mysql_fetch_assoc($kullanim_kilavuzu_url_cek);
    $kullanim_kilavuzu_url = $kullanim_kilavuzu_oku["kullanim_sartlari"];
    $listingMap[] = [
        "kullanim_kilavuzu_url" => $kullanim_kilavuzu_url
    ];

    if (mysql_num_rows($kullanim_kilavuzu_url_cek) >= 0) $statusCode = 200;

    $response = ["message" => "Kullanım Kılavuzu Getirildi ", "Kullanım Kılavuzu Detay" => $kullanim_kilavuzu_url_cek, "status" => $statusCode];

    echo json_encode(response($listingMap, $statusCode));
}
//Kullanım Kılavuzu Cek End

//Favoriden Çıkar Page Begın
if (re("action") == "favori_cikar") {
    $token = re("token");
    $ilan_id = re("ilan_id");
    $uye_tip = re("uye_tip");



    if ($uye_tip == "bireysel") {
        $kullanici_cek = mysql_query("Select * from user where user_token='" . $token . "'");
        $kullanici_oku = mysql_fetch_assoc($kullanici_cek);
        $uye_id = $kullanici_oku["id"];

        $veri_sil = mysql_query("DELETE from favoriler where ilan_id='" . $ilan_id . "' and uye_id='" . $uye_id . "'");

        if ($veri_sil) {
            echo json_encode(response($statusCode = 200));
        } else {
            echo json_encode(response($statusCode = 500));
        }
    }
    if ($uye_tip == "kurumsal") {
        $kullanici_cek = mysql_query("Select * from user where kurumsal_user_token='" . $token . "'");
        $kullanici_oku = mysql_fetch_assoc($kullanici_cek);
        $uye_id = $kullanici_oku["id"];

        $veri_sil = mysql_query("DELETE from favoriler where ilan_id='" . $ilan_id . "' and uye_id='" . $uye_id . "'");

        if ($veri_sil) {
            echo json_encode(response($statusCode = 200));
        } else {
            echo json_encode(response($statusCode = 500));
        }
    }
}
//Favoriden Çıkar Page End

//İletişim Page Begın

if (re("action") == "iletisim_bilgileri_cek") {
    $contact_cek = mysql_query("Select * from iletisim");
    $contact_oku = mysql_fetch_assoc($contact_cek);
    $listingMap[] = [
        "adres" => $contact_oku["adres"],
        "sabit_hat" => $contact_oku["sabit_hat"],
        "fax_sms" => $contact_oku["fax_sms"],
        "telefon" => $contact_oku["telefon"],
        "email" => $contact_oku["email"],
        "skype" => $contact_oku["skype"],
        "iframe" => $contact_oku["iframe"]

    ];

    if (mysql_num_rows($contact_cek) >= 0) $statusCode = 200;

    $response = ["message" => "İletişim Bilgileri Getirildi", "İletişim Bilgileri Detay" => $contact_cek, "status" => $statusCode];

    echo json_encode(response($listingMap, $statusCode));
}
//İletişim Page End

//Doğrudan Satışlı Page Begın

if (re("action") == "dogrudan_satisli_ilanlar") {
    echo json_encode(response(dogrudan_satisli_ilanlar()));
}
//Doğrudan Satışlı Page End

//Doğrudan Satışlı Detay Page Begın

if (re("action") == "arac_detayi_dogrudan_getir") {
    $ilan_id_gelen = re("ilan_id");
    $dizi = explode(":", $ilan_id_gelen);
    $ilan_id = $dizi[1];

    echo json_encode(response(dogrudan_satis_ilan_cek($ilan_id)));
}
//Doğrudan Satışlı Detay Page End


//Doğrudan Araç Fotoğrafı Çek Begın

if (re("action") == "dogrudan_arac_foto_cek") {
    $ilan_id_gelen = re("ilan_id");
    $dizi = explode(":", $ilan_id_gelen);
    $ilan_id = $dizi[1];
    echo json_encode(response(dogrudan_detay_foto_cek($ilan_id)));
}
//Doğrudan Araç Fotoğrafı Çek End

//Hakkımızda Page Begın
if (re("action") == "hakkimizda") {
    $hakkimizda_cek = mysql_query("Select * from hakkimizda");
    $hakkimizda_oku = mysql_fetch_assoc($hakkimizda_cek);

    $listingMap[] = [
        "id" => $hakkimizda_oku["id"],
        "baslik" => $hakkimizda_oku["baslik"],
        "hakkimizda" => $hakkimizda_oku["aciklama"],
        "resim" => $hakkimizda_oku["resim"],
        "olusturulma_zamani" => $hakkimizda_oku["olusturulma_zamani"]
    ];

    if (mysql_num_rows($hakkimizda_cek) >= 0) $statusCode = 200;

    $response = ["message" => "Hakkımızda Getirildi", "Hakkımızda Detay" => $hakkimizda_cek, "status" => $statusCode];

    echo json_encode(response($listingMap, $statusCode));
}
//Hakkımızda Page End

//Banka Bilgileri Page Begın

if (re("action") == "banka_bilgileri") {
    $banka_bilgileri = mysql_query("Select * from hesap_bilgileri");
    $banka_bilgi_oku = mysql_fetch_assoc($banka_bilgileri);

    $listingMap[] = [
        "banka_bilgisi" => $banka_bilgi_oku["icerik"]
    ];

    if (mysql_num_rows($banka_bilgileri) >= 0) $statusCode = 200;

    $response = ["message" => "Banka Bilgileri Getirildi", "Banka Bilgileri Detay" => $banka_bilgileri, "status" => $statusCode];

    echo json_encode(response($listingMap, $statusCode));
}
//Banka Bilgileri Page End

//Markalari Çek Begın

if (re("action") == "dogrudan_satis_markalar") {
    $marka_cek = mysql_query("Select * from marka  ");
    while ($markalari_oku = mysql_fetch_array($marka_cek)) {
        $listingMap[] = [
            "marka_id" => $markalari_oku["markaID"],
            "marka_adi" => $markalari_oku["marka_adi"]
        ];
    }

    if (mysql_num_rows($marka_cek) >= 0) $statusCode = 200;

    $response = ["message" => "Markalar Getirildi", "Markalar Detay" => $marka_cek, "status" => $statusCode];

    echo json_encode(response($listingMap, $statusCode));
}
//Markalari Çek End

//Doğrudan Satış Şehirler Page Begın

if (re("action") == "dogrudan_satis_sehirler") {
    echo json_encode(response(il_cek()));
}
//Doğrudan Satış Şehirler Page End

//Doğrudan Satış Filtre Tarihi Page Begın
if (re("action") == "dogrudan_tarihleri_cek") {
    $date = date("d-m-Y");

    $dun = date("d-m-Y", mktime(0, 0, 0, date("m"), date("d") - 1, date("Y")));
    $yarin = date("d-m-Y", mktime(0, 0, 0, date("m"), date("d") + 1, date("Y")));

    $bugun_id = 1;
    $yarin_id = 2;
    $listingMap[] = [
        "bugun" => tarih_formatla($date),
        "yarin" => tarih_formatla($yarin),
        "bugun_id" => $bugun_id,
        "yarin_id" => $yarin_id
    ];

    $response = ["message" => "Tarihler ", "Tarihler Detay" => $tum_yorumlar, "status" => $statusCode];

    echo json_encode(response($listingMap, $statusCode));
}
//Doğrudan Satış Filtre Tarihi Page End

//Doğrudan Satış Filtreler Page Begın
if (re("action") == "dogrudan_satis_filtreler") {
    $f_marka = $_POST['marka'];
    $f_sehir = $_POST['sehir'];
    $f_tarih = $_POST['tarih'];
    $f_profil = $_POST['ozellik'];


    if ($f_marka[0] != "" || $f_sehir[0] != "" || $f_tarih[0] != "" ||  $f_profil[0] != "") {

        $where = "WHERE durum = '1'";
    }

    if ($f_tarih[0] == "1") {
        $f_tarih = date("Y-m-d 00:00:00");
        $where = $where . " AND bitis_tarihi in (" . "'  $f_tarih  '" . ")";
    } elseif ($f_tarih[0] == "2") {
        $f_tarih = date("Y-m-d 00:00:00", strtotime("+1 day"));
        $where = $where . " AND bitis_tarihi in (" . "'  $f_tarih  '" . ")";
    }

    if ($f_marka[0] != "") {

        $k = 0;
        $seciliMarkaSayisi = count($_POST['marka']);
        $seciliMarka = "";
        while ($k < $seciliMarkaSayisi) {
            $seciliMarka = $seciliMarka . "'" . $_POST['marka'][$k] . "'";

            if ($k < $seciliMarkaSayisi - 1) {
                $seciliMarka = $seciliMarka . ", ";
            }
            $k++;
        }
        $where = $where . " AND marka in (" . $seciliMarka . ")";
    }
    if ($f_sehir[0] != "") {

        $i = 0;
        $seciliSehirSayisi = count($_POST['sehir']);
        $seciliSehir = "";
        while ($i < $seciliSehirSayisi) {
            $seciliSehir = $seciliSehir . "'" . $_POST['sehir'][$i] . "'";
            if ($i < $seciliSehirSayisi - 1) {
                $seciliSehir = $seciliSehir . ", ";
            }
            $i++;
        }
        $where = $where . " AND sehir in (" . $seciliSehir . ")";
    }
    if ($f_profil[0] != "") {

        $p = 0;
        $seciliProfilSayisi = count($_POST['ozellik']);
        $seciliProfil = "";
        while ($p < $seciliProfilSayisi) {
            $seciliProfil = $seciliProfil . "'" . $_POST['ozellik'][$p] . "'";
            if ($p < $seciliProfilSayisi - 1) {
                $seciliProfil = $seciliProfil . ", ";
            }
            $p++;
        }
        $where = $where . " AND evrak_tipi in (" . $seciliProfil . ")";
    }
    $filtre_cek = "SELECT * FROM dogrudan_satisli_ilanlar $where";
    $result = mysql_query($filtre_cek) or die(mysql_error());
    $sayi = mysql_num_rows($result);

    //var_dump($filtre_cek);
    if ($sayi != 0) {
        while ($filtre_oku = mysql_fetch_array($result)) {
            $resim_cek = mysql_query("select * from dogrudan_satisli_resimler where ilan_id = '" . $filtre_oku['id'] . "'");
            $resim_oku = mysql_fetch_assoc($resim_cek);
            $resim = $resim_oku['resim'];
            $listingMap[] = [
                "ilanlar" => dogrudan_satis_ilan_cek($filtre_oku["id"])
            ];
        }

        if (mysql_num_rows($filtre_cek) >= 0) $statusCode = 200;

        $response = ["message" => "Filtre Getirildi", "Filtre Detay" => $filtre_cek, "status" => $statusCode];

        echo json_encode(response($listingMap, $statusCode));
    } else {
        echo json_encode(response($statusCode = 500));
    }
}

//Doğrudan Satış Filtreler Page End

//Tarih Filtre Page Begın

if (re("action") == "filtre_tarih") {
    $date_time = date("Y-m-d");
    $yarin = date('Y-m-d ', strtotime('+1 day'));
    $ertesi_1 = date('Y-m-d ', strtotime('+2 day'));
    $ertesi_2 = date('Y-m-d ', strtotime('+3 day'));
    $ertesi_3 = date('Y-m-d ', strtotime('+4 day'));
    $ertesi_4 = date('Y-m-d ', strtotime('+5 day'));
    $ertesi_5 = date('Y-m-d ', strtotime('+6 day'));

    $listingMap[] = [
        "bugun" => tarih_formatla($date_time) . " [" . gun_arac_say_ihale($date_time) . "]",
        "yarin" => tarih_formatla($yarin) . " [" . gun_arac_say_ihale($yarin) . "]",
        "ertesi_1" => tarih_formatla($ertesi_1) . " [" . gun_arac_say_ihale($ertesi_1) . "]",
        "ertesi_2" => tarih_formatla($ertesi_2) . " [" . gun_arac_say_ihale($ertesi_2) . "]",
        "ertesi_3" => tarih_formatla($ertesi_3) . " [" . gun_arac_say_ihale($ertesi_3) . "]",
        "ertesi_4" => tarih_formatla($ertesi_4) . " [" . gun_arac_say_ihale($ertesi_4) . "]",
        "ertesi_5" => tarih_formatla($ertesi_5) . " [" . gun_arac_say_ihale($ertesi_5) . "]",
        "bugun_tarih" => date("Y-m-d"),
        "yarin_tarih" => date('Y-m-d ', strtotime('+1 day')),
        "ertesi_1_tarih" => date('Y-m-d ', strtotime('+2 day')),
        "ertesi_2_tarih" => date('Y-m-d ', strtotime('+3 day')),
        "ertesi_3_tarih" => date('Y-m-d ', strtotime('+4 day')),
        "ertesi_4_tarih" => date('Y-m-d ', strtotime('+5 day')),
        "ertesi_5_tarih" => date('Y-m-d ', strtotime('+6 day')),
    ];

    $statusCode = 200;

    $response = ["message" => "Tarihler Getirildi", "Tarih Detay" => $date_time, "status" => $statusCode];

    echo json_encode(response($listingMap, $statusCode));
}
//Tarih Fİltre Page End

//Şehir Filtre Page Begın

if (re("action") == "sehre_gore_arac_say") {
    $sehirleri_cek = mysql_query("Select * from sehir");
    while ($sehirler = mysql_fetch_array($sehirleri_cek)) {
        $listingMap[] = [
            "sehir_id" => $sehirler["sehirID"],
            "sehir_adi" => $sehirler["sehiradi"],
            "arac_sayisi" => sehre_gore_arac_say($sehirler["sehiradi"]),

        ];
    }
    $statusCode = 200;

    $response = ["message" => "Sehirler Getirildi", "Sehirler Detay" => $date_time, "status" => $statusCode];

    echo json_encode(response($listingMap, $statusCode));
}
//Şehir Filtre Page End

//Marka Filtre Page Begın
if (re("action") == "markaya_gore_arac_say") {

    $arac_marka_cek = mysql_query("Select * from marka");
    while ($arac_markalari = mysql_fetch_array($arac_marka_cek)) {
        $listingMap[] = [
            "marka_id" => $arac_markalari["markaID"],
            "marka_adi" => $arac_markalari["marka_adi"] . " [" . araca_gore_filtre_say($arac_markalari["markaID"]) . "]",
        ];
    }

    $statusCode = 200;

    $response = ["message" => "Markalar Getirildi", "Markalar Detay" => $date_time, "status" => $statusCode];

    echo json_encode(response($listingMap, $statusCode));
}
//Marka Filtre Page End

//İhale Tipi Araç Say Begın
if (re("action") == "ihale_tipi_arac_say") //Durum 1 AÇIK İLAN //Durum 2 Kapalı İlan
{
    $listingMap[] = [
        "acik_ihale" => ihale_tipi_arac_say(1),
        "kapali_ihale" => ihale_tipi_arac_say(2),
    ];

    $statusCode = 200;

    $response = ["message" => "İlanlar Getirildi", "İlanlar Detay" => $date_time, "status" => $statusCode];

    echo json_encode(response($listingMap, $statusCode));
}
//İhale Tipi Araç Say End

//Profile Göre Araç Say Begın
if (re("action") == "profile_gore_arac_say") {
    $listingMap[] = [
        "plakali_ruhsatli" => profile_gore("Plakalı Ruhsatlı"),
        "plakali" => profile_gore("Plakalı"),
        "hurda" => profile_gore("Hurda Belgeli"),
        "cekme_belgeli" => profile_gore("Çekme Belgeli"),
        "cekme_belge_pert" => profile_gore("Çekme Belgeli/Pert Kayıtlı"),
    ];

    $statusCode = 200;

    $response = ["message" => "Profile Göre araçlar Getirildi", "Profile Göre Detay" => $date_time, "status" => $statusCode];

    echo json_encode(response($listingMap, $statusCode));
}
//Profile Göre Araç Say End

//Tarihi Çek Filter Page Begın

if (re("action") == "tarihi_cek") {
    $date = date("Y");

    for ($dates = 1950; $dates < $date + 1; $dates++) {
        $listingMap[] = [
            "date" => $dates,
        ];
    }
    $statusCode = 200;

    $response = ["message" => "Profile Göre araçlar Getirildi", "Profile Göre Detay" => $date_time, "status" => $statusCode];

    echo json_encode(response($listingMap, $statusCode));
}
//Tarihi Çek Filter Page End

//Araç Plakasi Sorgula Page Begın
if (re("action") == "arac_plakasi_sorgula") {
    $plaka = re("plaka");

    $listingMap[] = [
        "dogrudan_plaka_sayisi" => plaka_sorgula("dogrudan_satisli_ilanlar", $plaka),
        "ilan_plaka_sayisi" => plaka_sorgula("ilanlar", $plaka),
    ];

    $statusCode = 200;

    $response = ["message" => "Plaka araç sayıları Getirildi", "Plaka Araç Detay" => $date_time, "status" => $statusCode];

    echo json_encode(response($listingMap, $statusCode));
} //Araç Plakasi Sorgula Page End

//Home Bildirim Aç Begın
if (re("action") == "home_bildirim") {
    $token = re("token");
    $ilan_id = re("ilan_id");
    $uye_tip = re("uye_tip");
    $date_time = date("Y-m-d H:i:s");


    if ($uye_tip == "bireysel") {
        $kullanici_cek = mysql_query("Select * from user where user_token='" . $token . "'");
        $kullanici_oku = mysql_fetch_assoc($kullanici_cek);
        $uye_id = $kullanici_oku["id"];

        $bildirim_kontrol = mysql_query("Select * from bildirimler where ilan_id='" . $ilan_id . "' and user_token='" . $token . "'");
        $bildirim_say = mysql_num_rows($bildirim_kontrol);

        if ($bildirim_say > 0) {
            echo json_encode(response($statusCode = 400));
        } else {
            $favla = mysql_query("INSERT INTO `bildirimler` (`ilan_id`, `dogrudan_satisli_id`, `uye_id`,`bildirim_zamani`,`user_token`,`kurumsal_token`) 
            VALUES ('$ilan_id', '0','$uye_id','$date_time','$token','');");

            if ($favla) {
                echo json_encode(response($statusCode = 200));
            } else {
                echo json_encode(response($statusCode = 500));
            }
        }
    }
    if ($uye_tip == "kurumsal") {
        $kullanici_cek = mysql_query("Select * from user where kurumsal_user_token='" . $token . "'");
        $kullanici_oku = mysql_fetch_assoc($kullanici_cek);
        $uye_id = $kullanici_oku["id"];

        $bildirim_kontrol = mysql_query("Select * from bildirimler where ilan_id='" . $ilan_id . "' and kurumsal_token='" . $token . "'");
        $bildirim_say = mysql_num_rows($bildirim_kontrol);
        if ($bildirim_say > 0) {
            echo json_encode(response($statusCode = 400));
        } else {
            $favla = mysql_query("INSERT INTO `bildirimler` (`ilan_id`, `dogrudan_satisli_id`, `uye_id`,`bildirim_zamani`,`user_token`,`kurumsal_token`) 
        VALUES ('$ilan_id', '0','$uye_id','$date_time','','$token');");
            if ($favla) {
                echo json_encode(response($statusCode = 200));
            } else {
                echo json_encode(response($statusCode = 500));
            }
        }
    }
}
//Home Bildirim Aç End

//Bildirim Dogrudan Page Begın
if (re("action") == "home_bildirim_dogrudan") {
    $token = re("token");
    $ilan_id = re("ilan_id");
    $uye_tip = re("uye_tip");
    $date_time = date("Y-m-d H:i:s");


    if ($uye_tip == "bireysel") {
        $kullanici_cek = mysql_query("Select * from user where user_token='" . $token . "'");
        $kullanici_oku = mysql_fetch_assoc($kullanici_cek);
        $uye_id = $kullanici_oku["id"];

        $bildirim_kontrol = mysql_query("Select * from bildirimler where ilan_id='" . $ilan_id . "' and user_token='" . $token . "'");
        $bildirim_say = mysql_num_rows($bildirim_kontrol);

        if ($bildirim_say > 0) {
            echo json_encode(response($statusCode = 400));
        } else {
            $favla = mysql_query("INSERT INTO `bildirimler` (`ilan_id`, `dogrudan_satisli_id`, `uye_id`,`bildirim_zamani`,`user_token`,`kurumsal_token`) 
            VALUES ('0', '$ilan_id','$uye_id','$date_time','$token','');");

            if ($favla) {
                echo json_encode(response($statusCode = 200));
            } else {
                echo json_encode(response($statusCode = 500));
            }
        }
    }
    if ($uye_tip == "kurumsal") {
        $kullanici_cek = mysql_query("Select * from user where kurumsal_user_token='" . $token . "'");
        $kullanici_oku = mysql_fetch_assoc($kullanici_cek);
        $uye_id = $kullanici_oku["id"];

        $bildirim_kontrol = mysql_query("Select * from bildirimler where ilan_id='" . $ilan_id . "' and kurumsal_token='" . $token . "'");
        $bildirim_say = mysql_num_rows($bildirim_kontrol);
        if ($bildirim_say > 0) {
            echo json_encode(response($statusCode = 400));
        } else {
            $favla = mysql_query("INSERT INTO `bildirimler` (`ilan_id`, `dogrudan_satisli_id`, `uye_id`,`bildirim_zamani`,`user_token`,`kurumsal_token`) 
        VALUES ('0', '$ilan_id','$uye_id','$date_time','','$token');");
            if ($favla) {
                echo json_encode(response($statusCode = 200));
            } else {
                echo json_encode(response($statusCode = 500));
            }
        }
    }
}

//Bildirim Dogrudan Page End


//Dogrudan Satış Markalari Filtre Begın
if (re("action") == "dogrudan_satis_markalari_cek") {
    $markalari_cek = mysql_query("Select * from marka");
    while ($markalari_bas = mysql_fetch_array($markalari_cek)) {
        $listingMap[] = [
            "marka_id" => $markalari_bas["markaID"],
            "marka_adi" => $markalari_bas["marka_adi"]
        ];
    }

    if (mysql_num_rows($markalari_cek) >= 0) $statusCode = 200;

    $response = ["message" => "Markalar Getirildi", "Markalar Detay" => $markalari_cek, "status" => $statusCode];

    echo json_encode(response($listingMap, $statusCode));
}
//Dogrudan Satış Markalari Filtre End

//Doğrudan Satış Sehirleri Cek Begın
if (re("action") == "dogrudan_satis_sehirleri_cek") {
    $sehirleri_cek = mysql_query("Select * from sehir");
    while ($sehirleri_oku = mysql_fetch_array($sehirleri_cek)) {
        $listingMap[] = [
            "sehir_adi" => $sehirleri_oku["sehiradi"],
            "sehir_id" => $sehirleri_oku["sehirID"]
        ];
    }
    if (mysql_num_rows($sehirleri_cek) >= 0) $statusCode = 200;

    $response = ["message" => "Şehirler Getirildi", "Şehirler Detay" => $sehirleri_cek, "status" => $statusCode];

    echo json_encode(response($listingMap, $statusCode));
}
//Doğrudan Satış Sehirleri Cek End,

//Doğrudan Satış Model Yillari Begın
if (re("action") == "dogrudan_model_yillari_cek") {
    $model_yillari = mysql_query("Select * from dogrudan_satisli_ilanlar  group by model_yili order by model_yili asc");
    while ($model_yillari_cek = mysql_fetch_array($model_yillari)) {
        $model_yili_say = mysql_query("Select * from dogrudan_satisli_ilanlar where model_yili='" . $model_yillari_cek["model_yili"] . "'");
        $model_yili_sayac = mysql_num_rows($model_yili_say);
        $listingMap[] = [
            "model_yili" => $model_yillari_cek["model_yili"],
            "model_yil_sayisi" => $model_yili_sayac
        ];
    }
    if (mysql_num_rows($model_yillari) >= 0) $statusCode = 200;

    $response = ["message" => "Modeller Yıllari Getirildi", "Model Yılları Detay" => $model_yillari, "status" => $statusCode];

    echo json_encode(response($listingMap, $statusCode));
}
//Doğrudan Satış Model Yillari End

//Üyelik Paketleri Page Begın

if (re("action") == "uyelik_paketleri") {
    $uyelik_paketleri = mysql_query("Select * from uye_grubu");
    while ($uyelikleri_cek = mysql_fetch_array($uyelik_paketleri)) {
        $paket_fiyati = $uyelikleri_cek["teklif_ust_limit"];
        if ($paket_fiyati > 10000000) {
            $paket_fiyati = "Sınırsız";
        } else {
            $paket_fiyati = fiyat_formatla($uyelikleri_cek["teklif_ust_limit"]) . " ₺ ";
        }
        $listingMap[] = [
            "paket_adi" => $uyelikleri_cek["grup_adi"],

            "cayma_bedeli" => fiyat_formatla($uyelikleri_cek["cayma_bedeli"]),
            "teklif_ust_limiti" => $paket_fiyati,
            "standart_ust_limit" => fiyat_formatla($uyelikleri_cek["standart_ust_limit"]),
            "luks_ust_limit" => fiyat_formatla($uyelikleri_cek["luks_ust_limit"]),
            "yetki" => $uyelikleri_cek["yetki"],
            "paket_id" => $uyelikleri_cek["id"]
        ];
    }
    if (mysql_num_rows($uyelik_paketleri) >= 0) $statusCode = 200;

    $response = ["message" => "Üyelik Paketleri Getirildi", "Üyelik Paketleri Detay" => $uyelik_paketleri, "status" => $statusCode];

    echo json_encode(response($listingMap, $statusCode));
}
//Üyelik Paketleri Page End

//Üye Paket Başvurusu Page Begın
if (re("action") == "paket_basvurusu_yap") {
    $date_time = date("Y-m-d H:i:s");

    $paket_id = re("paket_id");
    $token = re("token");
    $uye_tip = re("uye_tip");

    if ($uye_tip == "bireysel") {
        $kullanici_bilgi_cek = mysql_query("Select *from user where user_token='" . $token . "'");
        $bilgi_cek = mysql_fetch_assoc($kullanici_bilgi_cek);
        $kullanici_id = $bilgi_cek["id"];
        $kullanici_adi = $bilgi_cek["ad"];
        $kullanici_tel = $bilgi_cek["telefon"];
        $paket_basvuru_kontrol = mysql_query("Select * from gold_uyelik_talepleri where  uye_id='" . $kullanici_id . "' ");
        $paket_sayisi = mysql_num_rows($paket_basvuru_kontrol);

        if ($paket_sayisi == 0) {
            $basvuru_kaydet = mysql_query("INSERT INTO `gold_uyelik_talepleri` (`uye_adi`, `tur`,`basvuru_tarihi`,`telefon`,`durum`,`uye_id`) 
                VALUES ('$kullanici_adi', '$paket_id','$date_time','$kullanici_tel','0','$kullanici_id');");
        } else {
            $basvuru_update = mysql_query("Update gold_uyelik_talepleri set tur='" . $paket_id . "' where uye_id='" . $kullanici_id . "'");
        }
    }
    if ($uye_tip == "kurumsal") {
        echo ("burdasın kurumsal");
        $kullanici_bilgi_cek = mysql_query("Select *from user where kurumsal_user_token='" . $token . "'");
        $bilgi_cek = mysql_fetch_assoc($kullanici_bilgi_cek);
        $kullanici_id = $bilgi_cek["id"];
        $kullanici_adi = $bilgi_cek["ad"];
        $kullanici_tel = $bilgi_cek["telefon"];
        $paket_basvuru_kontrol = mysql_query("Select * from gold_uyelik_talepleri where uye_id='" . $kullanici_id . "' ");
        $paket_sayisi = mysql_num_rows($paket_basvuru_kontrol);

        if ($paket_sayisi == 0) {
            $basvuru_kaydet = mysql_query("INSERT INTO `gold_uyelik_talepleri` (`uye_adi`, `tur`,`basvuru_tarihi`,`telefon`,`durum`,`uye_id`) 
                VALUES ('$kullanici_adi', '$paket_id','$date_time','$kullanici_tel','0','$kullanici_id');");
        } else {
            $basvuru_update = mysql_query("Update gold_uyelik_talepleri set tur='" . $paket_id . "' where uye_id='" . $kullanici_id . "'");
        }
    }
}

//Üye Paket Başvurusu Page End

//İhale İlanları Görüntülenme Sayısı Page Begın

if (re("action") == "ihale_goruntulenme_sayisi_arttir") {
    $ilan_id_gelen = re("ilan_id");
    $dizi = explode(":", $ilan_id_gelen);
    $ilan_id = $dizi[1];
    $ip = GetIP();
    ihale_goruntulenme_sayisi($ilan_id, $ip);
}
//İhale İlanları Görüntülenme Sayısı Page End

//İhaledeki ilan görüntülenme sayıs arttır Begın

if (re("action") == "dogrudan_goruntulenme_sayisi_arttir") {
    $ilan_id_gelen = re("ilan_id");
    $dizi = explode(":", $ilan_id_gelen);
    $ilan_id = $dizi[1];
    $ip = GetIP();
    ihale_goruntulenme_sayisi($ilan_id, $ip);
}
//İhaledeki ilan görüntülenme sayıs arttır End

//Doğrudan ilan görüntülenme sayıs arttır Begın

if (re("action") == "dogrudan_goruntulenme_sayisi_arttir") {
    $ilan_id_gelen = re("ilan_id");
    $dizi = explode(":", $ilan_id_gelen);
    $ilan_id = $dizi[1];
    $ip = GetIP();
    dogrudan_goruntulenme_sayisi_arttir($ilan_id, $ip);
}
//Doğrudan ilan görüntülenme sayıs arttır End


//İhale Araç Goruntulenme sayısı Begın
if (re("action") == "ihale_arac_goruntulenme_sayisi") {
    $ilan_id_gelen = re("ilan_id");
    $dizi = explode(":", $ilan_id_gelen);
    $ilan_id = $dizi[1];

    echo (json_encode(response(arac_goruntulenme_ihalede($ilan_id))));
}
//İhale Araç Goruntulenme sayısı End

//Doğrudan Araç Goruntulenme sayısı Begın
if (re("action") == "dogrudan_arac_goruntulenme_sayisi") {
    $ilan_id_gelen = re("ilan_id");
    $dizi = explode(":", $ilan_id_gelen);
    $ilan_id = $dizi[1];

    echo (json_encode(response(arac_goruntulenme_dogrudan($ilan_id))));
}
//Doğrudan Araç Goruntulenme sayısı End

//İhale Teklif Limitim Page Begın 
if (re("action") == "ihale_teklif_limitim") {
    $token = re("token");
    $uye_tip = re("uye_tip");

    if ($uye_tip == "bireysel") {
        $kullanici_bilgisi = mysql_query("Select * from user where user_token='" . $token . "' ");
        $bilgi_oku = mysql_fetch_assoc($kullanici_bilgisi);
        $kullanici_id = $bilgi_oku["id"];

        $kullanici_ust_limit = mysql_query("Select * from teklif_limiti where uye_id='" . $kullanici_id . "'");
        while ($kullanici_paket_limitleri = mysql_fetch_array($kullanici_ust_limit)) {
            $listingMap[] = [
                "teklif_ust_limit" => $kullanici_paket_limitleri["teklif_limiti"],
                "standart_ust_limit" => $kullanici_paket_limitleri["standart_limit"],
                "luks_ust_limit" => $kullanici_paket_limitleri["luks_limit"],

            ];
        }
        if (mysql_num_rows($uyelik_paketleri) >= 0) $statusCode = 200;

        $response = ["message" => "Üyelik Paketleri Getirildi", "Üyelik Paketleri Detay" => $uyelik_paketleri, "status" => $statusCode];

        echo json_encode(response($listingMap, $statusCode));
    }
    if ($uye_tip == "kurumsal") {
        $kullanici_bilgisi = mysql_query("Select * from user where kurumsal_user_token='" . $token . "' ");
        $bilgi_oku = mysql_fetch_assoc($kullanici_bilgisi);
        $kullanici_id = $bilgi_oku["id"];

        $kullanici_ust_limit = mysql_query("Select * from teklif_limiti where uye_id='" . $kullanici_id . "'");
        while ($kullanici_paket_limitleri = mysql_fetch_array($kullanici_ust_limit)) {
            $listingMap[] = [
                "teklif_ust_limit" => $kullanici_paket_limitleri["teklif_limiti"],
                "standart_ust_limit" => $kullanici_paket_limitleri["standart_limit"],
                "luks_ust_limit" => $kullanici_paket_limitleri["luks_limit"],

            ];
        }
        if (mysql_num_rows($uyelik_paketleri) >= 0) $statusCode = 200;

        $response = ["message" => "Üyelik Paketleri Getirildi", "Üyelik Paketleri Detay" => $uyelik_paketleri, "status" => $statusCode];

        echo json_encode(response($listingMap, $statusCode));
    }
}
//İhale Teklif Limitim Page End

//Hizli Teklif Limit Butonlari Begın
if (re("action") == "hizli_teklif_butonlari") {
    $ilan_id_gelen = re("ilan_id");
    $dizi = explode(":", $ilan_id_gelen);
    $ilan_id = $dizi[1];

    $ilan_sigorta_sirketi = mysql_query("Select * from ilanlar where id='" . $ilan_id . "'");
    $ilan_bilgisi_oku = mysql_fetch_assoc($ilan_sigorta_sirketi);

    $sigorta_sirketi = $ilan_bilgisi_oku["sigorta"];

    $sigorta_verileri_cek = mysql_query("Select * from sigorta_ozellikleri where id='" . $sigorta_sirketi . "'");
    $sigorta_buton_verileri = mysql_fetch_assoc($sigorta_verileri_cek);

    $listingMap[] = [
        "hizli_teklif_1" => $sigorta_buton_verileri["hizli_teklif_1"],
        "hizli_teklif_2" => $sigorta_buton_verileri["hizli_teklif_2"],
        "hizli_teklif_3" => $sigorta_buton_verileri["hizli_teklif_3"],
        "hizli_teklif_4" => $sigorta_buton_verileri["hizli_teklif_4"],

    ];

    if (mysql_num_rows($ilan_sigorta_sirketi) >= 0) $statusCode = 200;

    $response = ["message" => "Buton Verileri Getirildi", "Buton Veri Detay" => $ilan_sigorta_sirketi, "status" => $statusCode];

    echo json_encode(response($listingMap, $statusCode));
} //Hizli Teklif Limit Butonlari End

//Edit Profile İlçe Getir Page Begın
if (re("action") == "ilce_getir_edit_prfile") {
    //Şu verilerin idsi gelse şaşıcam artık.......
    $sehir_adi = re("sehir_id");
    $sehir_id_ceeeek = mysql_query("Select * from sehir where sehiradi='" . $sehir_adi . "'");
    $sehir_verileri_oku = mysql_fetch_assoc($sehir_id_ceeeek);
    $sehir_id = $sehir_verileri_oku["sehirID"];

    $ilceleri_cek = mysql_query("Select * from ilce where il_plaka='" . $sehir_id . "'");
    while ($ilceleri_oku = mysql_fetch_array($ilceleri_cek)) {
        $listingMap[] = [
            "ilce_adi" => $ilceleri_oku["ilce_adi"],
            "ilce_id" => $ilceleri_oku["ilceID"]
        ];
    }
    if (mysql_num_rows($ilceleri_cek) >= 0) $statusCode = 200;

    $response = ["message" => "İlçeler Getirildi", "İlçe Detay" => $ilceleri_cek, "status" => $statusCode];

    echo json_encode(response($listingMap, $statusCode));
}
//Edit Profile İlçe Getir Page End

//Paket Başvurusu Profil Eksikleri Doldurma Begın
if (re("action") == "user_tablosu_dolu_mu") {
    $token = re("token");
    $uye_tip = re("uye_tip");
    $toplam_bos_sayisi = tablocheck("user", $token, $uye_tip = 1);

    if ($toplam_bos_sayisi >= 15) {
        $statusCode = 400;
        echo ($statusCode);
    } else {
        $statusCode = 200;
        echo ($statusCode);
    }
}
//Paket Başvurusu Profil Eksikleri Doldurma End


//Kalıcı Sistem Mesajı Page Begın

if (re("action") == "kalici_sistem_mesaji") {
    $token = re("token");
    $uye_tip = re("uye_tip");

    echo json_encode(response(kalici_sistem_mesaji($token, $uye_tip)));
}
//Kalıcı Sistem Mesajı Page End

//Online Durumu Update Page Begın
if (re("action") == "online_durumu_update") {
    $token = re("token");
    $uye_tip = re("uye_tip");
    $date_time = date("Y-m-d H:i:s");

    if ($uye_tip == "bireysel") {
        $update = mysql_query("Update user set  son_islem_zamani='" . $date_time . "',online_durum='1' where user_token='" . $token . "' ");
    }
    if ($uye_tip == "kurumsal") {
        $update = mysql_query("Update user set  son_islem_zamani='" . $date_time . "',online_durum='1' where kurumsal_user_token='" . $token . "' ");
    }
}
//Online Durumu Update Page End

//Temsilci Page Begın 
if (re("action") == "temsilcim") {
    $token = re("token");
    $uye_tip = re("uye_tip");

    if ($uye_tip == "bireysel") {
        $kullanici_cek = mysql_query("Select * from user where user_token='" . $token . "' ");
        $bilgi_oku = mysql_fetch_assoc($kullanici_cek);
        $temsilci_id = $bilgi_oku["temsilci_id"];

        $temsilci_cek = mysql_query("Select * from kullanicilar where id='" . $temsilci_id . "'");
        $temsilci_oku = mysql_fetch_assoc($temsilci_cek);
        $listingMap[] = [
            "temsilci_adi" => $temsilci_oku["adi"],
            "temsilci_soyadi" => $temsilci_oku["soyadi"],
            "temsilci_email" => $temsilci_oku["email"],
            "temsilci_tel" => $temsilci_oku["tel"],
        ];

        if (mysql_num_rows($temsilci_cek) >= 0) $statusCode = 200;

        $response = ["message" => "Temsilci Getirildi", "Temsilci Detay" => $temsilci_cek, "status" => $statusCode];

        echo json_encode(response($listingMap, $statusCode));
    }
    if ($uye_tip == "kurumsal") {
        $kullanici_cek = mysql_query("Select * from user where kurumsal_user_token='" . $token . "' ");
        $bilgi_oku = mysql_fetch_assoc($kullanici_cek);
        $temsilci_id = $bilgi_oku["temsilci_id"];

        $temsilci_cek = mysql_query("Select * from kullanicilar where id='" . $temsilci_id . "'");
        $temsilci_oku = mysql_fetch_assoc($temsilci_cek);
        $listingMap[] = [
            "temsilci_adi" => $temsilci_oku["adi"],
            "temsilci_soyadi" => $temsilci_oku["soyadi"],
            "temsilci_email" => $temsilci_oku["email"],
            "temsilci_tel" => $temsilci_oku["tel"],
        ];

        if (mysql_num_rows($temsilci_cek) >= 0) $statusCode = 200;

        $response = ["message" => "Temsilci Getirildi", "Temsilci Detay" => $temsilci_cek, "status" => $statusCode];

        echo json_encode(response($listingMap, $statusCode));
    }
}
//Temsilci Page End

//Demo Durumu Sorgulama Page Begın
if (re("action") == "demoluk_sorgula") {
    $token = re("token");
    $uye_tip = re("uye_tip");

    $date_time = date("Y-m-d");

    $kullanici_cek = mysql_query("Select * from user where (user_token='" . $token . "' or kurumsal_user_token='" . $token . "')");
    $bilgi_cek = mysql_fetch_assoc($kullanici_cek);
    $kullanici_id = $bilgi_cek["id"];

    $demoluk_sorgula = mysql_query("Select * from  uye_durumlari where uye_id='" . $kullanici_id . "' and demo_olacagi_tarih='" . $date_time . "'");
    $veri_say = mysql_num_rows($demoluk_sorgula);

    if ($veri_say > 1) {
        $update = mysql_query("update user set paket='1' where id='" . $kullanici_id . "'");
    }
}

//Demo Durumu Sorgulama Page End

//Üye Engelle Modul Page Begın

if(re("action")=="uye_engelle_modul")
{
    $token=re("token");
    $uye_tip=re("uye_tip");

    $kullanici_cek=mysql_query("Select * from user where (user_token='".$token."' or kurumsal_user_token='".$token."')");
    $bilgi_cek=mysql_fetch_assoc($kullanici_cek);
    $kullanici_id=$bilgi_cek["id"];

    $uye_durumu_cek=mysql_query("Select * from uye_durumlari where uye_id='".$kullanici_id."'");
    $uye_verisi=mysql_fetch_assoc($uye_durumu_cek);
    
    $listingMap[] = [
        "uyelik_iptal" => $uye_verisi["uyelik_iptal"],
        "uyelik_iptal_nedeni" => $uye_verisi["uyelik_iptal_nedeni"],
    ];

    if (mysql_num_rows($uye_durumu_cek) >= 0) $statusCode = 200;

    $response = ["message" => "Üyelik İptali Getirildi", "Üyelik İptal Detay" => $uye_durumu_cek, "status" => $statusCode];

    echo json_encode(response($listingMap, $statusCode)); 

}


//Üye Engelle Modul Page End


if(re("action")=="hizmet_bedeli_getir"){
    $ilan_id=re("ilan_id");
    $gelen_teklif = re('teklif_fiyati');
    $user_token = re('user_token');
    if($gelen_teklif == ""){
        $cek = mysql_query("select * from ilanlar where id = '".$ilan_id."'");
        $oku = mysql_fetch_object($cek);
        $verilen_teklif=$oku->son_teklif;
    }else{
        $verilen_teklif=re("girilen_teklif");
    }
    $response=[];
    $sorgu=mysql_query("select * from ilanlar where id='".$ilan_id."' ");
    $row=mysql_fetch_object($sorgu);
    if($row->pd_hizmet>0){
        $hizmet_bedel=$row->pd_hizmet;
    }else{
        $cek = mysql_query("select* from komisyon_oranlari where sigorta_id = '".$row->sigorta."' and komisyon_orani >= '".$verilen_teklif."' order by komisyon_orani asc");
        $oku = mysql_fetch_object($cek);
        $hesaplama=$row->hesaplama;
        if($hesaplama=="Standart"){
            $net = $oku->net;
            $oran = $oku->onbinde;
        }else{
            $net = $oku->lux_net;
            $oran = $oku->lux_onbinde;
        }
        $ek_gider = $verilen_teklif * $oran / 10000;
        $son_komisyon = ceil($ek_gider + $net);
        $hizmet_bedel=$son_komisyon;
    }
    $response=["son_komisyon"=>$hizmet_bedel, "status" => 200];
    echo json_encode($response);
}



//Araç Teklif Ver Page Begın
if (re("action") == "arac_teklif_ver") {
    $token = re("user_token");
    $teklif_fiyatim = re("teklif_fiyati");
    $ilan_id_gelen = re("ilan_id");
    $dizi = explode(":", $ilan_id_gelen);
    $ilan_id = $dizi[1];
    $uye_tip = re("uye_tip");
    $cihaz_turu = re("cihaz_turu");
    $date_time = date("Y-m-d H:i:s");
    $ip = GetIP();

    if ($uye_tip == "bireysel") {
        $ilan_teklif_cek = mysql_query("Select * from ilanlar where id='" . $ilan_id . "' ");
        $ilan_teklif_detaylari = mysql_fetch_assoc($ilan_teklif_cek);
        $son_teklif = $ilan_teklif_detaylari["son_teklif"];
        $id_cek = mysql_query("Select * from user where user_token='" . $token . "'");
        $id_oku = mysql_fetch_assoc($id_cek);
        $uye_id = $id_oku["id"];
        $teklif_verme_kontrol = mysql_query("Select * from uye_durumlari where uye_id='" . $uye_id . "'");
        $teklif_durumu_cek = mysql_fetch_assoc($teklif_verme_kontrol);
        $hurda_teklifim = $teklif_durumu_cek["hurda_teklif"];
        $teklif_engelle = $teklif_durumu_cek["teklif_engelle"];
        $ilan_id_sorgula = mysql_query("Select * from ilanlar where id='" . $ilan_id . "'");
        $ilan_id_hurda_sorgula = mysql_fetch_assoc($ilan_id_sorgula);
        $ilan_profil = $ilan_id_hurda_sorgula["profil"];
        if ($teklif_engelle == "on") {
            $response = ["message" => "Teklif Verme Engellenmiş", "Başarısız" => $kullanici_sorgula, "status" => 01];
            echo json_encode(response($response));
        } else {
            if ($ilan_profil == "Hurda Belgeli" && $hurda_teklifim != "on") {
                $response = ["message" => "Hurda Araç Teklif Veremezsiniz", "Başarısız" => $kullanici_sorgula, "status" => 02];
                echo json_encode(response($response));
            } else {
                if ($son_teklif < $teklif_fiyatim) {
                    $teklif_update = mysql_query("update ilanlar set son_teklif='".$teklif_fiyatim."' where id='".$ilan_id."'");
                    $teklif_kaydet = mysql_query("INSERT INTO `teklifler` (`ilan_id`, `uye_id`, `teklif`,`teklif_zamani`,`user_token`,`dogrudan_satisli_ilan_id`,`kurumsal_token`,`ip`,`tarayici`,`isletim_sistemi`) 
            VALUES ('$ilan_id','$uye_id','$teklif_fiyatim','$date_time','$token',0,'','$ip','Mobil Uygulama','$cihaz_turu');");

                    if ($teklif_kaydet) {
                        $response = ["message" => "Başarılı", "Başarılı" => $kullanici_sorgula, "status" => 200];

                        echo json_encode(response($response));
                    } else {
                        $response = ["message" => "Başarısız", "Başarısız" => $kullanici_sorgula, "status" => 400];

                        echo json_encode(response($response));
                    }
                } else {
                    $response = ["message" => "Başarısız", "Başarısız" => $kullanici_sorgula, "status" => 400];

                    echo json_encode(response($response));
                }
            }
        }
    }

    if ($uye_tip == "kurumsal") {
        $ilan_teklif_cek = mysql_query("Select * from ilanlar where id='" . $ilan_id . "' ");
        $ilan_teklif = mysql_fetch_assoc($ilan_teklif_cek);
        $son_teklif = $ilan_teklif["son_teklif"];

        $id_cek = mysql_query("Select * from user where kurumsal_user_token='" . $token . "' ");
        $id_oku = mysql_fetch_assoc($id_cek);
        $uye_id = $id_oku["id"];

        $teklif_verme_kontrol = mysql_query("Select * from uye_durumlari where uye_id='" . $uye_id . "'");
        $teklif_durumu_cek = mysql_fetch_assoc($teklif_verme_kontrol);

        $hurda_teklifim = $teklif_durumu_cek["hurda_teklif"];

        $teklif_engelle = $teklif_durumu_cek["teklif_engelle"];

        $ilan_id_sorgula = mysql_query("Select * from ilanlar where id='" . $ilan_id . "'");
        $ilan_id_hurda_sorgula = mysql_fetch_assoc($ilan_id_sorgula);
        $ilan_profil = $ilan_id_hurda_sorgula["profil"];


        if ($teklif_engelle == "on") {
            $response = ["message" => "Teklif Verme Engellenmiş", "Başarısız" => $kullanici_sorgula, "status" => 01];

            echo json_encode(response($response));
        } else {
            if ($ilan_profil == "Hurda Belgeli" && $hurda_teklifim != "on") {
                $response = ["message" => "Hurda Araç Teklif Veremezsiniz", "Başarısız" => $kullanici_sorgula, "status" => 02];

                echo json_encode(response($response));
            } else {
                if ($son_teklif < $teklif_fiyatim) {
                    $teklif_update = mysql_query("update ilanlar set son_teklif='" . $teklif_fiyatim . "' where id='" . $ilan_id . "'");

                    $teklif_kaydet = mysql_query("INSERT INTO `teklifler` (`ilan_id`, `uye_id`, `teklif`,`teklif_zamani`,`user_token`,`dogrudan_satisli_ilan_id`,`kurumsal_token`,`ip`,`tarayici`,`isletim_sistemi`) 
        VALUES ('$ilan_id','$uye_id','$teklif_fiyatim','$date_time','',0,'$token','$ip','Mobil Uygulama','$cihaz_turu');");

                    if ($teklif_kaydet) {
                        $response = ["message" => "Başarılı", "Başarılı" => $kullanici_sorgula, "status" => 200];

                        echo json_encode(response($response));
                    } else {
                        $response = ["message" => "Başarısız", "Başarısız" => $kullanici_sorgula, "status" => 400];

                        echo json_encode(response($response));
                    }
                } else {
                    $response = ["message" => "Başarısız", "Başarısız" => $kullanici_sorgula, "status" => 400];

                    echo json_encode(response($response));
                }
            }
        }
    }
}

if(re("action")=="teklif_ver"){
    $teklif_tarihi = date('Y-m-d H:i:s');
    $response=[];
    $verilen_teklif = $_POST['verilen_teklif'];
    $kullaniciToken = $_POST['kullaniciToken'];
    $ilanID = re('ilanID');
    $uye_tkn = re('uye_token');
    $uye_tip = re('uye_tip');
    //$hizmet_bedel = re('hizmet_bedel');
    $user_sql=mysql_query("select * from user where user_token='".$uye_tkn."' or kurumsal_user_token='".$uye_tkn."' ");
    // var_dump("select * from user where user_token='".$uye_tkn."' or kurumsal_user_token='".$uye_tkn."' ");
    $user_row=mysql_fetch_object($user_sql);
    $uyeID=$user_row->id;
    $uye_paket=$user_row->paket;
    $date = date('Y-m-d H:i:s');
    $ip = GetIP();
    $isletim_sistemi=re("isletim_sistemi");
    $tarayici=re("tarayici");
    $sozlesme_kontrol=re("sozlesme_kontrol");		
    $sorgu=mysql_query("select * from ilanlar where id='".$ilanID."' ");
    $row=mysql_fetch_object($sorgu);
    if($row->pd_hizmet>0){
        $hizmet_bedel=$row->pd_hizmet;
    }else{
        $hesaplama=$row->hesaplama;
        $sorgu = mysql_query("SELECT * FROM komisyon_oranlari WHERE sigorta_id = '".$row->sigorta."'");
        $oran = array();
        $standart_net = array();
        $luks_net = array();
        $standart_onbinde = array();
        $luks_onbinde = array();
        while($sonuc = mysql_fetch_array($sorgu)){
            array_push($oran, $sonuc['komisyon_orani']);
            array_push($standart_net, $sonuc['net']);
            array_push($luks_net, $sonuc['lux_net']);
            array_push($standart_onbinde, $sonuc['onbinde']);
            array_push($luks_onbinde, $sonuc['lux_onbinde']);
        }
        $oran_sayisi=count($oran);
        if($hesaplama=="Standart"){
            $durum=false;
            for ($i = 0; $i < $oran_sayisi; $i++) {
                if($verilen_teklif <= $oran[$i]){
                    $oran1 = $oran[$i];
                    $standart_net1 = $standart_net[$i];
                    $standart_onbinde1 = $standart_onbinde[$i];
                    $ek_gider = $verilen_teklif * $standart_onbinde1 / 10000;
                    $son_komisyon = ceil($ek_gider + $standart_net1);  
                    break;
                }else{
                    $durum=true;
                }
            } 
            $max_index=0;
            for ($j = 0; $j < $oran_sayisi; $j++) {
                if($oran[$j] == max($oran) ){
                    $max_index=$j;
                }
            }
            if($durum==true){
                if($verilen_teklif > max($oran) ){
                    $oran1 = max($oran);
                    $standart_net1 = $standart_net[$max_index];
                    $standart_onbinde1 = (int)$standart_onbinde[$max_index];					
                    $ek_gider = $verilen_teklif * $standart_onbinde1 / 10000;
                    $son_komisyon = ceil($ek_gider + $standart_net1);   	
                }
            }
        }else{
            $durum=false;
            for($i = 0; $i < $oran_sayisi; $i++) {
                if($verilen_teklif <= $oran[$i]){
                    $oran1 = $oran[$i];
                    $luks_net1 = $luks_net[$i];
                    $luks_onbinde1 = $luks_onbinde[$i];
                    $ek_gider = $verilen_teklif * $luks_onbinde1 / 10000;
                    $son_komisyon = ceil($ek_gider + $luks_net1); 
                    break;
                }else{
                    $durum=true;
                }
            } 
            $max_index=0;
            for ($j = 0; $j < $oran_sayisi; $j++) {
                if($oran[$j] == max($oran) ){
                    $max_index=$j;
                }
            }
            if($durum==true){
                if($verilen_teklif > max($oran) ){
                    $oran1 = max($oran);
                    $luks_net1 = $luks_net[$max_index];
                    $luks_onbinde1 = (int)$luks_onbinde[$max_index];					
                    $ek_gider = $verilen_teklif * $luks_onbinde1 / 10000;
                    $son_komisyon = ceil($ek_gider + $luks_net1);   	
                }
            }
        }
        $hizmet_bedel=$son_komisyon;
        // $hizmet_bedel = re('hizmet_bedel');
    }
    $sigorta_id=$row->sigorta;
    $sorgu2=mysql_query("select * from teklif_limiti where uye_id='".$uyeID."' ");
    $row2=mysql_fetch_object($sorgu2);
    $uyenin_durumu_cek = mysql_query("SELECT * FROM uye_durumlari WHERE uye_id = '".$uyeID."'");
    $uyenin_durumu = mysql_fetch_assoc($uyenin_durumu_cek);
    $uye_paket_cek=mysql_query("select * from uye_grubu where id='".$uye_paket."'");
    $uye_paket_oku=mysql_fetch_object($uye_paket_cek);
    $teklif_engelle = $uyenin_durumu['teklif_engelle'];
    $engelleme_nedeni = $uyenin_durumu['engelleme_nedeni'];
    $otomatik_teklif_engelle = $uyenin_durumu['otomatik_teklif_engelle'];
    $engelli_sigorta="false";
    $uye_engelli_sigortalar = explode(",",$uyenin_durumu['yasak_sigorta']);
    for($h=0;$h<count($uye_engelli_sigortalar);$h++){
        if($sigorta_id==$uye_engelli_sigortalar[$h]){
            $engelli_sigorta="true";
        }
    }
    $hurda_teklif = $uyenin_durumu['hurda_teklif'];
    $ilan_durumu_cek = mysql_query("SELECT * FROM ilanlar WHERE id = '".$ilanID."'");
    $ilan_durumu_oku = mysql_fetch_assoc($ilan_durumu_cek);
    $hurda_durumu = $ilan_durumu_oku['profil'];
    //Hurda Belgeli
    $aktif_cayma_toplam=mysql_query("SELECT SUM(tutar) as toplam_aktif_cayma FROM cayma_bedelleri WHERE uye_id='".$uyeID."' AND durum=1");
    $toplam_aktif_cayma=mysql_fetch_assoc($aktif_cayma_toplam);
    $iade_talepleri_toplam=mysql_query("SELECT SUM(tutar) as toplam_iade_talepleri FROM cayma_bedelleri WHERE uye_id='".$uyeID."' AND durum=2");
    $toplam_iade_talepleri=mysql_fetch_assoc($iade_talepleri_toplam);
    $borclar_toplam=mysql_query("SELECT SUM(tutar) as toplam_borclar FROM cayma_bedelleri WHERE uye_id='".$uyeID."' AND durum=6");
    $toplam_borclar=mysql_fetch_assoc($borclar_toplam);
    $cayma=$toplam_aktif_cayma["toplam_aktif_cayma"]-$toplam_borclar["toplam_borclar"];
    if($row->hesaplama=="Standart"){
        if($row2->standart_limit != 0){
            $teklif_limiti=$row2->standart_limit;
        }else{
            $teklif_limiti=0;
            $grup_cek=mysql_query("select * from uye_grubu_detaylari where grup_id='".$uye_paket."' and cayma_bedeli <= '".$cayma."' order by cayma_bedeli desc limit 1");
            $grup_oku = mysql_fetch_object($grup_cek);
            $teklif_limiti = $grup_oku->standart_ust_limit;	
        }
    }else{
        if($row2->luks_limit>0){
            $teklif_limiti=$row2->luks_limit;
        }else{
            $teklif_limiti=0;
            $grup_cek=mysql_query("select * from uye_grubu_detaylari where grup_id='".$uye_paket."' and cayma_bedeli <= '".$cayma."' order by cayma_bedeli desc limit 1");
            $grup_oku = mysql_fetch_object($grup_cek);
            $teklif_limiti = $grup_oku->luks_ust_limit;	
        }
    }
    $sorgu3=mysql_query("select * from sigorta_ozellikleri where id='".$sigorta_id."'");
    $row3=mysql_fetch_object($sorgu3);
    $belirlenen=(int)$row3->bu_sure_altinda_teklif;
    $alacagi_mesaj=$row3->alacagi_mesaj;
    $sigorta_min_artis=$row3->minumum_artis;
    $sure_uzatma = $row3->sure_uzatma;
    $dakikanin_altinda = $row3->dakikanin_altinda;
    $dakika_uzar = $row3->dakika_uzar;
    if($row->ihale_turu==1){
        if($hurda_durumu=="Hurda Belgeli"){			
            if($hurda_teklif == "on"){
                if($teklif_engelle=="on"){
                    if($engelleme_nedeni ==""){
                        $response = ["message"=>"Teklif verme yetkileriniz geçici olarak durdurulmuştur.","status"=>500];
                        $islem_durum = 0;
                    }else{
                        $response = ["message"=>"$engelleme_nedeni","status"=>500];
                        $islem_durum = 0;
                    }
                }else if($otomatik_teklif_engelle=="on" ){
                    $response = ["message"=>"Sistem tarafından teklif vermeniz kısıtlanmıştır.Müşteri temsilcileri ile iletişime geçebilirsiniz.","status"=>500];
                    $islem_durum = 0;
                }else if($engelli_sigorta=="true" ){
                    $response = ["message"=>"İlanın sigorta şirketine ait olan araçlara teklif vermeniz kısıtlanmıştır.","status"=>500];
                    $islem_durum = 0;
                }else{
                    if($uye_tkn == ""){
                        $response=["message"=>"Teklif verebilmek için giriş yapmalısınız","status"=>500];
                        $islem_durum = 0;
                    }else if($uye_tkn == $row->ihale_sahibi){
                        $response=["message"=>"Kendi ihalenize teklif veremezsiniz.","status"=>500];
                        $islem_durum = 0;
                    }else if($row->ihale_tarihi." ".$row->ihale_saati < $teklif_tarihi){
                        $response=["message"=>"İhalenin süresi dolmuştur.","status"=>500];
                        $islem_durum = 0;
                    }elseif($verilen_teklif == ""){
                        $response=["message"=>"Teklfiniz boş olamaz","status"=>500];
                        $islem_durum = 0;
                    }  
                    else if($verilen_teklif <= $row->acilis_fiyati  ){
                        $response=["message"=>"Teklifiniz taban fiyat koşulunu sağlamamaktadır. İhalenin taban fiyatı $row->acilis_fiyati ₺'dir. ","status"=>500];
                        $islem_durum = 0;
                    } 	
                    else if($verilen_teklif % $sigorta_min_artis != 0){
                        $response=["message"=>"Teklifiniz $sigorta_min_artis ₺ katları olmalı","status"=>500];
                        $islem_durum = 0;
                    } 						
                    else if($verilen_teklif > $teklif_limiti  ){
                        $response=["message"=>"Teklif limitini aştınız. Mevcut paketinizin teklif limiti '".money($teklif_limiti)."' ₺'dir. ","status"=>500];
                        $islem_durum = 0;
                    } 						
                    else if($verilen_teklif < $row->son_teklif+$sigorta_min_artis){
                        $response=["message"=>"Teklfiniz en yüksek teklifden en az $sigorta_min_artis ₺ fazla olmalı ","status"=>500];
                        $islem_durum = 0;
                    }  
                    else{
                        if($sozlesme_kontrol != 1){
                            $sigort_cek_onay = mysql_query("select * from sigorta_ozellikleri where id = '".$row->sigorta."'");
                            $sigorta_oku_onay = mysql_fetch_object($sigort_cek_onay);
                            if($sigorta_oku_onay->teklif_onay_mekanizmasi == 1){
                                $response=["message"=>"Teklif verebilmeniz için sözleşmeyi kabul etmelisiniz.","status"=>500];
                                $islem_durum = 0;
                            }else{
                                $ihale_son=$row->ihale_tarihi." ".$row->ihale_saati;
                                $ihale_son_str = strtotime($ihale_son);
                                $suan_str = strtotime(date("Y-m-d H:i:s"));
                                $sonuc=($ihale_son_str-$suan_str)/60;
                                if($sonuc>=$belirlenen ){
                                    $teklif_durum=1;
                                    $ilan_teklifi=mysql_query("select * from teklifler where ilan_id='".$ilanID."' and durum=1 order by teklif_zamani desc limit 1"); 
                                    $ilan_teklifi_oku=mysql_fetch_object($ilan_teklifi);
                                    $teklif_uye_id=$ilan_teklifi_oku->uye_id;
                                    $ilan_cek = mysql_query("SELECT * FROM ilanlar WHERE id = '".$ilanID."' ");
                                    $ilan_oku = mysql_fetch_array($ilan_cek);
                                    $teklif = $ilan_oku['son_teklif'];
                                    if($verilen_teklif > $teklif){
                                        if($sonuc>=3 && $teklif_uye_id!='283'){//283 Kaynak Firma Uye ID
                                            $ihale_bitis=$ilan_oku["ihale_tarihi"]." ".$ilan_oku["ihale_saati"];
                                            $sigorta_sure_uzatma_durumu=$row3->sure_uzatma;
                                            $sigorta_dakikanin_altinda=$row3->dakikanin_altinda;
                                            $sigorta_dakika_uzar=$row3->dakika_uzar;
                                            if($sigorta_sure_uzatma_durumu=="1"){
                                                $yeni_trh=strtotime("+".$sigorta_dakika_uzar." minutes",strtotime($ihale_bitis));
                                                $yeni_trh=date("Y-m-d H:i:s",$yeni_trh);
                                                $explode=explode(" ",$yeni_trh);
                                                $yeni_t=$explode[0];
                                                $yeni_s=$explode[1];
                                                $date=$teklif_tarihi;
                                                $tarih=strtotime("-".$sigorta_dakikanin_altinda." minutes",strtotime($ihale_bitis));
                                                $tarih=date("Y-m-d H:i:s",$tarih);
                                                if($date>$tarih){
                                                    $gosterilme_tarih=strtotime($yeni_trh)+300; //Gösterilme süresi 5 dk fazla olması istendi
                                                    $gosterilme_tarih=date("Y-m-d H:i:s",$gosterilme_tarih);
                                                    mysql_query("UPDATE ilanlar SET son_teklif = '".$verilen_teklif."',sistem_sure_uzatma_durumu='0' WHERE id='".$ilanID."'");
                                                }else{
                                                    mysql_query("UPDATE ilanlar SET son_teklif = '".$verilen_teklif."',sistem_sure_uzatma_durumu='0' WHERE id='".$ilanID."'");
                                                }
                                            }else{
                                                mysql_query("UPDATE ilanlar SET son_teklif = '".$verilen_teklif."',sistem_sure_uzatma_durumu='0' WHERE id='".$ilanID."'");
                                            }
                                        }else{
                                            mysql_query("UPDATE ilanlar SET son_teklif = '".$verilen_teklif."' WHERE id='".$ilanID."'");
                                        }
                                    }
                                    if($uye_tip == "bireysel"){
                                        mysql_query("INSERT INTO `teklifler`(`id`,`ilan_id`,`uye_id`,`teklif`,`hizmet_bedeli`,`teklif_zamani`,`user_token`,`dogrudan_satisli_ilan_id`,`kurumsal_token`,ip,tarayici,isletim_sistemi,admin_teklif,admin_id,durum) 
                                            VALUES (NULL,'".$ilanID."','".$uyeID."','".$verilen_teklif."','".$hizmet_bedel."','".$date."','".$uye_tkn."','0','','".$ip."','".$tarayici."','".$isletim_sistemi."','0','0','".$teklif_durum."')");
                                    }elseif($uye_tip != "bireysel"){
                                        mysql_query("INSERT INTO `teklifler`(`id`,`ilan_id`,`uye_id`,`teklif`,`hizmet_bedeli`,`teklif_zamani`,`user_token`,`dogrudan_satisli_ilan_id`,`kurumsal_token`,ip,tarayici,isletim_sistemi,admin_teklif,admin_id,durum) 
                                            VALUES (NULL,'".$ilanID."','".$uyeID."','".$verilen_teklif."','".$hizmet_bedel."','".$date."','','0','".$uye_tkn."','".$ip."','".$tarayici."','".$isletim_sistemi."','0','0','".$teklif_durum."')");
                                    }
                                    $response=["message"=>"Teklif başarıyla verildi","status"=>200];
                                    $islem_durum = 1;
                                }else{
                                    $teklif_durum=2;
                                    $onay_bekleyen_teklifler=mysql_query("select * from teklifler where ilan_id='".$ilanID."' and durum='2'");
                                    $ayni_teklif=false;
                                    while($onay_bekleyenler_oku=mysql_fetch_object($onay_bekleyen_teklifler)){
                                        if($verilen_teklif<=$onay_bekleyenler_oku->teklif){
                                            $ayni_teklif=true;
                                        }
                                    }
                                    if($ayni_teklif==true){
                                        $response=["message"=>"Bu teklif başka bir üye tarafından verildi ve onay bekliyor. Lütfen daha yüksek bir teklif vermeyi deneyiniz.","status"=>500];
                                        $islem_durum = 0;
                                    }
                                    else{
                                        if($uye_tip == "bireysel"){
                                            mysql_query("INSERT INTO `teklifler`(`id`,`ilan_id`,`uye_id`,`teklif`,`hizmet_bedeli`,`teklif_zamani`,`user_token`,`dogrudan_satisli_ilan_id`,`kurumsal_token`,ip,tarayici,isletim_sistemi,admin_teklif,admin_id,durum) 
                                                VALUES (NULL,'".$ilanID."','".$uyeID."','".$verilen_teklif."','".$hizmet_bedel."','".$date."','".$uye_tkn."','0','','".$ip."','".$tarayici."','".$isletim_sistemi."','0','0','".$teklif_durum."')");
                                        }elseif($uye_tip != "bireysel"){
                                            mysql_query("INSERT INTO `teklifler`(`id`,`ilan_id`,`uye_id`,`teklif`,`hizmet_bedeli`,`teklif_zamani`,`user_token`,`dogrudan_satisli_ilan_id`,`kurumsal_token`,ip,tarayici,isletim_sistemi,admin_teklif,admin_id,durum) 
                                                VALUES (NULL,'".$ilanID."','".$uyeID."','".$verilen_teklif."','".$hizmet_bedel."','".$date."','','0','".$uye_tkn."','".$ip."','".$tarayici."','".$isletim_sistemi."','0','0','".$teklif_durum."')");
                                        }
                                        $response=["message"=>$alacagi_mesaj,"status"=>200];
                                        $islem_durum = 1;
                                    }
                                }
                            }						
                        }else{
                            $ihale_son=$row->ihale_tarihi." ".$row->ihale_saati;
                            $ihale_son_str = strtotime($ihale_son);
                            $suan_str = strtotime(date("Y-m-d H:i:s"));
                            $sonuc=($ihale_son_str-$suan_str)/60;
                            if($sonuc>=$belirlenen ){
                                $teklif_durum=1;
                                $ilan_teklifi=mysql_query("select * from teklifler where ilan_id='".$ilanID."' and durum=1 order by teklif_zamani desc limit 1"); 
                                $ilan_teklifi_oku=mysql_fetch_object($ilan_teklifi);
                                $teklif_uye_id=$ilan_teklifi_oku->uye_id;
                                $ilan_cek = mysql_query("SELECT * FROM ilanlar WHERE id = '".$ilanID."' ");
                                $ilan_oku = mysql_fetch_array($ilan_cek);
                                $teklif = $ilan_oku['son_teklif'];
                                if($verilen_teklif > $teklif){
                                    if($sonuc>=3 && $teklif_uye_id!='283'){//283 Kaynak Firma Uye ID
                                        $ihale_bitis=$ilan_oku["ihale_tarihi"]." ".$ilan_oku["ihale_saati"];
                                        $sigorta_sure_uzatma_durumu=$row3->sure_uzatma;
                                        $sigorta_dakikanin_altinda=$row3->dakikanin_altinda;
                                        $sigorta_dakika_uzar=$row3->dakika_uzar;
                                        if($sigorta_sure_uzatma_durumu=="1"){
                                            $yeni_trh=strtotime("+".$sigorta_dakika_uzar." minutes",strtotime($ihale_bitis));
                                            $yeni_trh=date("Y-m-d H:i:s",$yeni_trh);
                                            $explode=explode(" ",$yeni_trh);
                                            $yeni_t=$explode[0];
                                            $yeni_s=$explode[1];
                                            // $date=date("Y-m-d H:i:s");
                                            $date=$teklif_tarihi;
                                            $tarih=strtotime("-".$sigorta_dakikanin_altinda." minutes",strtotime($ihale_bitis));
                                            $tarih=date("Y-m-d H:i:s",$tarih);
                                            if($date>$tarih){
                                                $gosterilme_tarih=strtotime($yeni_trh)+300; //Gösterilme süresi 5 dk fazla olması istendi
                                                $gosterilme_tarih=date("Y-m-d H:i:s",$gosterilme_tarih);
                                                // mysql_query("UPDATE ilanlar SET son_teklif = '".$verilen_teklif."',sistem_sure_uzatma_durumu='0',ihale_tarihi='".$yeni_t."',ihale_saati='".$yeni_s."',ihale_son_gosterilme='".$gosterilme_tarih."' WHERE id='".$ilanID."'");
                                                mysql_query("UPDATE ilanlar SET son_teklif = '".$verilen_teklif."',sistem_sure_uzatma_durumu='0' WHERE id='".$ilanID."'");
                                            }else{
                                                mysql_query("UPDATE ilanlar SET son_teklif = '".$verilen_teklif."',sistem_sure_uzatma_durumu='0' WHERE id='".$ilanID."'");
                                            }
                                        }else{
                                                mysql_query("UPDATE ilanlar SET son_teklif = '".$verilen_teklif."',sistem_sure_uzatma_durumu='0' WHERE id='".$ilanID."'");
                                        }
                                    }else{
                                        mysql_query("UPDATE ilanlar SET son_teklif = '".$verilen_teklif."' WHERE id='".$ilanID."'");
                                    }
                                }
                                if($uye_tip == "bireysel"){
                                    mysql_query("INSERT INTO `teklifler`(`id`,`ilan_id`,`uye_id`,`teklif`,`hizmet_bedeli`,`teklif_zamani`,`user_token`,`dogrudan_satisli_ilan_id`,`kurumsal_token`,ip,tarayici,isletim_sistemi,admin_teklif,admin_id,durum) 
                                        VALUES (NULL,'".$ilanID."','".$uyeID."','".$verilen_teklif."','".$hizmet_bedel."','".$date."','".$uye_tkn."','0','','".$ip."','".$tarayici."','".$isletim_sistemi."','0','0','".$teklif_durum."')");
                                }elseif($uye_tip != "bireysel"){
                                    mysql_query("INSERT INTO `teklifler`(`id`,`ilan_id`,`uye_id`,`teklif`,`hizmet_bedeli`,`teklif_zamani`,`user_token`,`dogrudan_satisli_ilan_id`,`kurumsal_token`,ip,tarayici,isletim_sistemi,admin_teklif,admin_id,durum) 
                                        VALUES (NULL,'".$ilanID."','".$uyeID."','".$verilen_teklif."','".$hizmet_bedel."','".$date."','','0','".$uye_tkn."','".$ip."','".$tarayici."','".$isletim_sistemi."','0','0','".$teklif_durum."')");
                                }
                                $response=["message"=>"Teklif başarıyla verildi","status"=>200];
                                $islem_durum = 1;
                            }else{
                                $teklif_durum=2;
                                $onay_bekleyen_teklifler=mysql_query("select * from teklifler where ilan_id='".$ilanID."' and durum='2'");
                                $ayni_teklif=false;
                                while($onay_bekleyenler_oku=mysql_fetch_object($onay_bekleyen_teklifler)){
                                    if($verilen_teklif<=$onay_bekleyenler_oku->teklif){
                                        $ayni_teklif=true;
                                    }
                                }
                                if($ayni_teklif==true){
                                    $response=["message"=>"Bu teklif başka bir üye tarafından verildi ve onay bekliyor. Lütfen daha yüksek bir teklif vermeyi deneyiniz.","status"=>500];
                                    $islem_durum = 0;
                                }
                                else{
                                    if($uye_tip == "bireysel"){
                                        mysql_query("INSERT INTO `teklifler`(`id`,`ilan_id`,`uye_id`,`teklif`,`hizmet_bedeli`,`teklif_zamani`,`user_token`,`dogrudan_satisli_ilan_id`,`kurumsal_token`,ip,tarayici,isletim_sistemi,admin_teklif,admin_id,durum) 
                                            VALUES (NULL,'".$ilanID."','".$uyeID."','".$verilen_teklif."','".$hizmet_bedel."','".$date."','".$uye_tkn."','0','','".$ip."','".$tarayici."','".$isletim_sistemi."','0','0','".$teklif_durum."')");
                                    }elseif($uye_tip != "bireysel"){
                                        mysql_query("INSERT INTO `teklifler`(`id`,`ilan_id`,`uye_id`,`teklif`,`hizmet_bedeli`,`teklif_zamani`,`user_token`,`dogrudan_satisli_ilan_id`,`kurumsal_token`,ip,tarayici,isletim_sistemi,admin_teklif,admin_id,durum) 
                                            VALUES (NULL,'".$ilanID."','".$uyeID."','".$verilen_teklif."','".$hizmet_bedel."','".$date."','','0','".$uye_tkn."','".$ip."','".$tarayici."','".$isletim_sistemi."','0','0','".$teklif_durum."')");
                                    }
                                    $response=["message"=>$alacagi_mesaj,"status"=>200];
                                    $islem_durum = 1;
                                }
                            }
                        }
                    }
                }
            }else{
                $response = ["message"=>"Hurda belgeli araçlara teklif verebilmek için lütfen bizimle iletişime geçin.","status"=>500];
                $islem_durum = 0;
            }
        }else{
            if($teklif_engelle=="on"){
                if($engelleme_nedeni ==""){
                    $response = ["message"=>"Teklif verme yetkileriniz geçici olarak durdurulmuştur.","status"=>500];
                    $islem_durum = 0;
                }else{
                    $response = ["message"=>"$engelleme_nedeni","status"=>500];
                    $islem_durum = 0;
                }
            }else if($otomatik_teklif_engelle=="on" ){
                $response = ["message"=>"Sistem tarafından teklif vermeniz kısıtlanmıştır.Müşteri temsilcileri ile iletişime geçebilirsiniz.","status"=>500];
                $islem_durum = 0;
            }else{
                if($uye_tkn == ""){
                    $response=["message"=>"Teklif verebilmek için giriş yapmalısınız","status"=>500];
                    $islem_durum = 0;
                }else if($uye_tkn == $row->ihale_sahibi){
                    $response=["message"=>"Kendi ihalenize teklif veremezsiniz.","status"=>500];
                    $islem_durum = 0;
                }else if($row->ihale_tarihi." ".$row->ihale_saati < $teklif_tarihi){
                    $response=["message"=>"İhalenin süresi dolmuştur.","status"=>500];
                    $islem_durum = 0;
                }elseif($verilen_teklif == ""){
                    $response=["message"=>"Teklfiniz boş olamaz","status"=>500];
                    $islem_durum = 0;
                }  
                else if($verilen_teklif <= $row->acilis_fiyati  ){
                    $response=["message"=>"Teklifiniz taban fiyat koşulunu sağlamamaktadır. İhalenin taban fiyatı $row->acilis_fiyati ₺'dir. ","status"=>500];
                    $islem_durum = 0;
                }	
                else if($verilen_teklif % $sigorta_min_artis != 0){
                    $response=["message"=>"Teklifiniz $sigorta_min_artis ₺ katları olmalı","status"=>500];
                    $islem_durum = 0;
                }
                else if($verilen_teklif > $teklif_limiti ){
                    $response=["message"=>"Teklif limitini aştınız. Mevcut paketinizin teklif limiti  '".money($teklif_limiti)."' ₺'dir. ","status"=>501];
                    $islem_durum = 0;
                } 					
                else if($engelli_sigorta=="true" ){
                    $response = ["message"=>"İlanın sigorta şirketine ait olan araçlara teklif vermeniz kısıtlanmıştır.","status"=>500];
                    $islem_durum = 0;
                }
                else if($verilen_teklif < $row->son_teklif+$sigorta_min_artis){
                    $response=["message"=>"Teklfiniz en yüksek teklifden en az $sigorta_min_artis ₺ fazla olmalı ","status"=>500];
                    $islem_durum = 0;
                }  
                else{
                    if($sozlesme_kontrol !=1){
                        $sigort_cek_onay = mysql_query("select * from sigorta_ozellikleri where id = '".$row->sigorta."'");
                        $sigorta_oku_onay = mysql_fetch_object($sigort_cek_onay);
                        if($sigorta_oku_onay->teklif_onay_mekanizmasi == 1){
                            $response=["message"=>"Teklif verebilmeniz için sözleşmeyi kabul etmelisiniz.","status"=>500];
                            $islem_durum = 0;
                        }else{
                            $ihale_son=$row->ihale_tarihi." ".$row->ihale_saati;
                            $ihale_son_str = strtotime($ihale_son);
                            $suan_str = strtotime(date("Y-m-d H:i:s"));
                            $sonuc=($ihale_son_str-$suan_str)/60;
                            if($sonuc>=$belirlenen ){
                                $teklif_durum=1;
                                $ilan_teklifi=mysql_query("select * from teklifler where ilan_id='".$ilanID."' and durum=1 order by teklif_zamani desc limit 1"); 
                                $ilan_teklifi_oku=mysql_fetch_object($ilan_teklifi);
                                $teklif_uye_id=$ilan_teklifi_oku->uye_id;
                                $ilan_cek = mysql_query("SELECT * FROM ilanlar WHERE id = '".$ilanID."' ");
                                $ilan_oku = mysql_fetch_array($ilan_cek);
                                $teklif = $ilan_oku['son_teklif'];
                                if($verilen_teklif > $teklif){
                                    if($sonuc>=3 && $teklif_uye_id!='283'){//283 Kaynak Firma Uye ID
                                        $ihale_bitis=$ilan_oku["ihale_tarihi"]." ".$ilan_oku["ihale_saati"];
                                        $sigorta_sure_uzatma_durumu=$row3->sure_uzatma;
                                        $sigorta_dakikanin_altinda=$row3->dakikanin_altinda;
                                        $sigorta_dakika_uzar=$row3->dakika_uzar;
                                        if($sigorta_sure_uzatma_durumu=="1"){
                                            $yeni_trh=strtotime("+".$sigorta_dakika_uzar." minutes",strtotime($ihale_bitis));
                                            $yeni_trh=date("Y-m-d H:i:s",$yeni_trh);
                                            $explode=explode(" ",$yeni_trh);
                                            $yeni_t=$explode[0];
                                            $yeni_s=$explode[1];
                                            // $date=date("Y-m-d H:i:s");
                                            $date=$teklif_tarihi;
                                            $tarih=strtotime("-".$sigorta_dakikanin_altinda." minutes",strtotime($ihale_bitis));
                                            $tarih=date("Y-m-d H:i:s",$tarih);
                                            if($date>$tarih){
                                                $gosterilme_tarih=strtotime($yeni_trh)+300; //Gösterilme süresi 5 dk fazla olması istendi
                                                $gosterilme_tarih=date("Y-m-d H:i:s",$gosterilme_tarih);
                                                // mysql_query("UPDATE ilanlar SET ihale_son_gosterilme='".$gosterilme_tarih."',son_teklif = '".$verilen_teklif."',sistem_sure_uzatma_durumu='0',ihale_tarihi='".$yeni_t."',ihale_saati='".$yeni_s."' WHERE id='".$ilanID."'");
                                                mysql_query("UPDATE ilanlar SET ihale_son_gosterilme='".$gosterilme_tarih."',son_teklif = '".$verilen_teklif."' WHERE id='".$ilanID."'");
                                            }else{
                                                mysql_query("UPDATE ilanlar SET son_teklif = '".$verilen_teklif."',sistem_sure_uzatma_durumu='0' WHERE id='".$ilanID."'");
                                            }
                                        }else{
                                                mysql_query("UPDATE ilanlar SET son_teklif = '".$verilen_teklif."',sistem_sure_uzatma_durumu='0' WHERE id='".$ilanID."'");
                                        }
                                    }else{
                                        mysql_query("UPDATE ilanlar SET son_teklif = '".$verilen_teklif."' WHERE id='".$ilanID."'");
                                    }
                                }
                                if($uye_tip == "bireysel"){
                                    mysql_query("INSERT INTO `teklifler`(`id`,`ilan_id`,`uye_id`,`teklif`,`hizmet_bedeli`,`teklif_zamani`,`user_token`,`dogrudan_satisli_ilan_id`,`kurumsal_token`,ip,tarayici,isletim_sistemi,admin_teklif,admin_id,durum) 
                                        VALUES (NULL,'".$ilanID."','".$uyeID."','".$verilen_teklif."','".$hizmet_bedel."','".$date."','".$uye_tkn."','0','','".$ip."','".$tarayici."','".$isletim_sistemi."','0','0','".$teklif_durum."')");
                                }elseif($uye_tip != "bireysel"){
                                    mysql_query("INSERT INTO `teklifler`(`id`,`ilan_id`,`uye_id`,`teklif`,`hizmet_bedeli`,`teklif_zamani`,`user_token`,`dogrudan_satisli_ilan_id`,`kurumsal_token`,ip,tarayici,isletim_sistemi,admin_teklif,admin_id,durum) 
                                        VALUES (NULL,'".$ilanID."','".$uyeID."','".$verilen_teklif."','".$hizmet_bedel."','".$date."','','0','".$uye_tkn."','".$ip."','".$tarayici."','".$isletim_sistemi."','0','0','".$teklif_durum."')");
                                }
                                $response=["message"=>"Teklif başarıyla verildi","status"=>200];
                                $islem_durum = 1;
                            }else{
                                $teklif_durum=2;
                                $onay_bekleyen_teklifler=mysql_query("select * from teklifler where ilan_id='".$ilanID."' and durum='2'");
                                $ayni_teklif=false;
                                while($onay_bekleyenler_oku=mysql_fetch_object($onay_bekleyen_teklifler)){
                                    if($verilen_teklif<=$onay_bekleyenler_oku->teklif){
                                        $ayni_teklif=true;
                                    }
                                }
                                if($ayni_teklif==true){
                                    $response=["message"=>"Bu teklif başka bir üye tarafından verildi ve onay bekliyor. Lütfen daha yüksek bir teklif vermeyi deneyiniz.","status"=>500];
                                    $islem_durum = 0;
                                }else{
                                    if($uye_tip == "bireysel"){
                                        mysql_query("INSERT INTO `teklifler`(`id`,`ilan_id`,`uye_id`,`teklif`,`hizmet_bedeli`,`teklif_zamani`,`user_token`,`dogrudan_satisli_ilan_id`,`kurumsal_token`,ip,tarayici,isletim_sistemi,admin_teklif,admin_id,durum) 
                                            VALUES (NULL,'".$ilanID."','".$uyeID."','".$verilen_teklif."','".$hizmet_bedel."','".$date."','".$uye_tkn."','0','','".$ip."','".$tarayici."','".$isletim_sistemi."','0','0','".$teklif_durum."')");
                                    }elseif($uye_tip != "bireysel"){
                                        mysql_query("INSERT INTO `teklifler`(`id`,`ilan_id`,`uye_id`,`teklif`,`hizmet_bedeli`,`teklif_zamani`,`user_token`,`dogrudan_satisli_ilan_id`,`kurumsal_token`,ip,tarayici,isletim_sistemi,admin_teklif,admin_id,durum) 
                                            VALUES (NULL,'".$ilanID."','".$uyeID."','".$verilen_teklif."','".$hizmet_bedel."','".$date."','','0','".$uye_tkn."','".$ip."','".$tarayici."','".$isletim_sistemi."','0','0','".$teklif_durum."')");
                                    }
                                    $response=["message"=>$alacagi_mesaj,"status"=>200];
                                    $islem_durum = 1;
                                }
                            }
                        }
                    }else{
                        $ihale_son=$row->ihale_tarihi." ".$row->ihale_saati;
                        $ihale_son_str = strtotime($ihale_son);
                        $suan_str = strtotime(date("Y-m-d H:i:s"));
                        $sonuc=($ihale_son_str-$suan_str)/60;
                        if($sonuc>=$belirlenen ){
                            $teklif_durum=1;
                            $ilan_teklifi=mysql_query("select * from teklifler where ilan_id='".$ilanID."' and durum=1 order by teklif_zamani desc limit 1"); 
                            $ilan_teklifi_oku=mysql_fetch_object($ilan_teklifi);
                            $teklif_uye_id=$ilan_teklifi_oku->uye_id;
                            $ilan_cek = mysql_query("SELECT * FROM ilanlar WHERE id = '".$ilanID."' ");
                            $ilan_oku = mysql_fetch_array($ilan_cek);
                            $teklif = $ilan_oku['son_teklif'];
                            if($verilen_teklif > $teklif){
                                if($sonuc>=3 && $teklif_uye_id!='283'){//283 Kaynak Firma Uye ID
                                    $ihale_bitis=$ilan_oku["ihale_tarihi"]." ".$ilan_oku["ihale_saati"];
                                    $sigorta_sure_uzatma_durumu=$row3->sure_uzatma;
                                    $sigorta_dakikanin_altinda=$row3->dakikanin_altinda;
                                    $sigorta_dakika_uzar=$row3->dakika_uzar;
                                    if($sigorta_sure_uzatma_durumu=="1"){
                                        $yeni_trh=strtotime("+".$sigorta_dakika_uzar." minutes",strtotime($ihale_bitis));
                                        $yeni_trh=date("Y-m-d H:i:s",$yeni_trh);
                                        $explode=explode(" ",$yeni_trh);
                                        $yeni_t=$explode[0];
                                        $yeni_s=$explode[1];
                                        // $date=date("Y-m-d H:i:s");
                                        $date=$teklif_tarihi;
                                        $tarih=strtotime("-".$sigorta_dakikanin_altinda." minutes",strtotime($ihale_bitis));
                                        $tarih=date("Y-m-d H:i:s",$tarih);
                                        if($date>$tarih){
                                            $gosterilme_tarih=strtotime($yeni_trh)+300; //Gösterilme süresi 5 dk fazla olması istendi
                                            $gosterilme_tarih=date("Y-m-d H:i:s",$gosterilme_tarih);
                                            // mysql_query("UPDATE ilanlar SET ihale_son_gosterilme='".$gosterilme_tarih."',son_teklif = '".$verilen_teklif."',sistem_sure_uzatma_durumu='0',ihale_tarihi='".$yeni_t."',ihale_saati='".$yeni_s."' WHERE id='".$ilanID."'");
                                            mysql_query("UPDATE ilanlar SET ihale_son_gosterilme='".$gosterilme_tarih."',son_teklif = '".$verilen_teklif."' WHERE id='".$ilanID."'");
                                        }else{
                                            mysql_query("UPDATE ilanlar SET son_teklif = '".$verilen_teklif."',sistem_sure_uzatma_durumu='0' WHERE id='".$ilanID."'");
                                        }
                                    }else{
                                            mysql_query("UPDATE ilanlar SET son_teklif = '".$verilen_teklif."',sistem_sure_uzatma_durumu='0' WHERE id='".$ilanID."'");
                                    }
                                }else{
                                    mysql_query("UPDATE ilanlar SET son_teklif = '".$verilen_teklif."' WHERE id='".$ilanID."'");
                                }
                            }
                            if($uye_tip == "bireysel"){
                                $test = 1;
                                mysql_query("INSERT INTO `teklifler`(`id`,`ilan_id`,`uye_id`,`teklif`,`hizmet_bedeli`,`teklif_zamani`,`user_token`,`dogrudan_satisli_ilan_id`,`kurumsal_token`,ip,tarayici,isletim_sistemi,admin_teklif,admin_id,durum) 
                                    VALUES (NULL,'".$ilanID."','".$uyeID."','".$verilen_teklif."','".$hizmet_bedel."','".$date."','".$uye_tkn."','0','','".$ip."','".$tarayici."','".$isletim_sistemi."','0','0','".$teklif_durum."')");
                            }elseif($uye_tip != "bireysel"){
                                $test = 2;
                                mysql_query("INSERT INTO `teklifler`(`id`,`ilan_id`,`uye_id`,`teklif`,`hizmet_bedeli`,`teklif_zamani`,`user_token`,`dogrudan_satisli_ilan_id`,`kurumsal_token`,ip,tarayici,isletim_sistemi,admin_teklif,admin_id,durum) 
                                    VALUES (NULL,'".$ilanID."','".$uyeID."','".$verilen_teklif."','".$hizmet_bedel."','".$date."','','0','".$uye_tkn."','".$ip."','".$tarayici."','".$isletim_sistemi."','0','0','".$teklif_durum."')");
                            }
                            $response=["message"=>"Teklif başarıyla verildi","status"=>200];
                            $islem_durum = 1;
                        }else{
                            $teklif_durum=2;
                            $onay_bekleyen_teklifler=mysql_query("select * from teklifler where ilan_id='".$ilanID."' and durum='2'");
                            $ayni_teklif=false;
                            while($onay_bekleyenler_oku=mysql_fetch_object($onay_bekleyen_teklifler)){
                                if($verilen_teklif<=$onay_bekleyenler_oku->teklif){
                                    $ayni_teklif=true;
                                }
                            }
                            if($ayni_teklif==true){
                                $response=["message"=>"Bu teklif başka bir üye tarafından verildi ve onay bekliyor. Lütfen daha yüksek bir teklif vermeyi deneyiniz.","status"=>500];
                                $islem_durum = 0;
                            }
                            else{
                                if($uye_tip == "bireysel"){
                                    mysql_query("INSERT INTO `teklifler`(`id`,`ilan_id`,`uye_id`,`teklif`,`hizmet_bedeli`,`teklif_zamani`,`user_token`,`dogrudan_satisli_ilan_id`,`kurumsal_token`,ip,tarayici,isletim_sistemi,admin_teklif,admin_id,durum) 
                                        VALUES (NULL,'".$ilanID."','".$uyeID."','".$verilen_teklif."','".$hizmet_bedel."','".$date."','".$uye_tkn."','0','','".$ip."','".$tarayici."','".$isletim_sistemi."','0','0','".$teklif_durum."')");
                                }elseif($uye_tip != "bireysel"){
                                    mysql_query("INSERT INTO `teklifler`(`id`,`ilan_id`,`uye_id`,`teklif`,`hizmet_bedeli`,`teklif_zamani`,`user_token`,`dogrudan_satisli_ilan_id`,`kurumsal_token`,ip,tarayici,isletim_sistemi,admin_teklif,admin_id,durum) 
                                        VALUES (NULL,'".$ilanID."','".$uyeID."','".$verilen_teklif."','".$hizmet_bedel."','".$date."','','0','".$uye_tkn."','".$ip."','".$tarayici."','".$isletim_sistemi."','0','0','".$teklif_durum."')");
                                }
                                $response=["message"=>$alacagi_mesaj,"status"=>200];
                                $islem_durum = 1;
                            }
                        }
                    }
                }
            }
        }
        // İhale türü 1 ise bitiş
    }else if($row->ihale_turu==2) {
         if($hurda_durumu=="Hurda Belgeli"){
            if($hurda_teklif == "on"){
                if($teklif_engelle=="on"){
                    if($engelleme_nedeni ==""){
                        $response = ["message"=>"Teklif verme yetkileriniz geçici olarak durdurulmuştur.","status"=>500];
                        $islem_durum = 0;
                    }else{
                        $response = ["message"=>"$engelleme_nedeni","status"=>500];
                        $islem_durum = 0;
                    }
                }else if($otomatik_teklif_engelle=="on" ){
                    $response = ["message"=>"Sistem tarafından teklif vermeniz kısıtlanmıştır.Müşteri temsilcileri ile iletişime geçebilirsiniz.","status"=>500];
                    $islem_durum = 0;
                }else if($engelli_sigorta=="true" ){
                    $response = ["message"=>"İlanın sigorta şirketine ait olan araçlara teklif vermeniz kısıtlanmıştır.","status"=>500];
                    $islem_durum = 0;
                }else{
                    if($uye_tkn == ""){
                        $response=["message"=>"Teklif verebilmek için giriş yapmalısınız","status"=>500];
                        $islem_durum = 0;
                    }else if($uye_tkn == $row->ihale_sahibi){
                        $response=["message"=>"Kendi ihalenize teklif veremezsiniz.","status"=>500];
                        $islem_durum = 0;
                    }else if($row->ihale_tarihi." ".$row->ihale_saati < $teklif_tarihi){
                        $response=["message"=>"İhalenin süresi dolmuştur.","status"=>500];
                        $islem_durum = 0;
                    }else if($verilen_teklif == ""){
                        $response=["message"=>"Teklfiniz boş olamaz","status"=>500];
                        $islem_durum = 0;
                    } 
                    else if($verilen_teklif <= $row->acilis_fiyati  ){
                        $response=["message"=>"Teklifiniz taban fiyat koşulunu sağlamamaktadır. İhalenin taban fiyatı $row->acilis_fiyati ₺'dir. ","status"=>500];
                        $islem_durum = 0;
                    }
                    else if($verilen_teklif % $sigorta_min_artis != 0){
                        $response=["message"=>"Teklifiniz $sigorta_min_artis ₺ katları olmalı","status"=>500];
                        $islem_durum = 0;
                    }					
                    else if($verilen_teklif > $teklif_limiti  ){
                        $response=["message"=>"Teklif limitini aştınız. Mevcut paketinizin teklif limiti '".money($teklif_limiti)."' ₺'dir. ","status"=>502];
                        $islem_durum = 0;
                    } 						
                    else if($verilen_teklif < $row->acilis_fiyati+$sigorta_min_artis){
                        $response=["message"=>"Teklfiniz taban fiyattan en az $sigorta_min_artis ₺ fazla olmalı ","status"=>500];
                        $islem_durum = 0;
                    }else{
                        if($sozlesme_kontrol !=1){
                            $sigort_cek_onay = mysql_query("select * from sigorta_ozellikleri where id = '".$row->sigorta."'");
                            $sigorta_oku_onay = mysql_fetch_object($sigort_cek_onay);
                            if($sigorta_oku_onay->teklif_onay_mekanizmasi == 1){
                                $response=["message"=>"Teklif verebilmeniz için sözleşmeyi kabul etmelisiniz.","status"=>500];
                                $islem_durum = 0;
                            }else{
                                $ihale_son=$row->ihale_tarihi." ".$row->ihale_saati;
                                $ihale_son_str = strtotime($ihale_son);
                                $suan_str = strtotime(date("Y-m-d H:i:s"));
                                $sonuc=($ihale_son_str-$suan_str)/60;
                                if($sonuc>=$belirlenen ){
                                    $teklif_durum=1;
                                    if($_SESSION['u_token'] != ""){
                                    mysql_query("INSERT INTO `teklifler`(`id`,`ilan_id`,`uye_id`,`teklif`,`hizmet_bedeli`,`teklif_zamani`,`user_token`,`dogrudan_satisli_ilan_id`,`kurumsal_token`,ip,tarayici,isletim_sistemi,admin_teklif,admin_id,durum) 
                                        VALUES (NULL,'".$ilanID."','".$uyeID."','".$verilen_teklif."','".$hizmet_bedel."','".$date."','".$_SESSION['u_token']."','0','','".$ip."','".$tarayici."','".$isletim_sistemi."','0','0','".$teklif_durum."')");
                                    }elseif($_SESSION['k_token'] != ""){
                                        mysql_query("INSERT INTO `teklifler`(`id`,`ilan_id`,`uye_id`,`teklif`,`hizmet_bedeli`,`teklif_zamani`,`user_token`,`dogrudan_satisli_ilan_id`,`kurumsal_token`,ip,tarayici,isletim_sistemi,admin_teklif,admin_id,durum) 
                                            VALUES (NULL,'".$ilanID."','".$uyeID."','".$verilen_teklif."','".$hizmet_bedel."','".$date."','','0','".$_SESSION['k_token']."','".$ip."','".$tarayici."','".$isletim_sistemi."','0','0','".$teklif_durum."')");
                                    }
                                    $teklif_cek=mysql_query("select * from teklifler where ilan_id='".$ilanID."' and durum=1 group by uye_id order by teklif_zamani ");
                                    $teklifler_array=array();
                                    $kaynak_firma_teklifi='';
                                    while($teklif_oku=mysql_fetch_object($teklif_cek)){
                                        $teklifleri_cek=mysql_query("select * from teklifler where ilan_id='".$ilanID."' and uye_id='".$teklif_oku->uye_id."' order by teklif_zamani desc limit 1 ");
                                        $teklifleri_oku=mysql_fetch_object($teklifleri_cek);
                                        $pushla=array_push($teklifler_array,$teklifleri_oku->teklif);
                                        if($teklif_oku->uye_id=='283'){
                                            $kaynak_firma_teklifi=$teklifleri_oku->teklif;
                                        }
                                    }
                                    $ilani_guncelle=mysql_query("update ilanlar set son_teklif='".max($teklifler_array)."' where id='".$ilanID."'");
                                    $i_cek=mysql_query("select * from ilanlar where id='".$ilanID."'");
                                    $i_oku=mysql_fetch_array($i_cek);
                                    $t_cek=mysql_query("select * from teklifler where ilan_id='".$ilanID."' and durum=1 group by uye_id order by teklif_zamani ");
                                    while($t_oku=mysql_fetch_object($t_cek)){
                                        $tt_cek=mysql_query("select * from teklifler where ilan_id='".$ilanID."' and uye_id='".$t_oku->uye_id."' order by teklif_zamani desc limit 1 ");
                                        $tt_oku=mysql_fetch_object($tt_cek);
                                        if($i_oku["son_teklif"]=$tt_oku->teklif){
                                            $son_teklif_uye_id=$tt_oku->uye_id;
                                        }
                                    }
                                    if($sonuc>=3){
                                        $ihale_bitis=$ilan_oku["ihale_tarihi"]." ".$ilan_oku["ihale_saati"];
                                        $sigorta_sure_uzatma_durumu=$row3->sure_uzatma;
                                        $sigorta_dakikanin_altinda=$row3->dakikanin_altinda;
                                        $sigorta_dakika_uzar=$row3->dakika_uzar;
                                        if($sigorta_sure_uzatma_durumu=="1"){
                                            $yeni_trh=strtotime("+".$sigorta_dakika_uzar." minutes",strtotime($ihale_bitis));
                                            $yeni_trh=date("Y-m-d H:i:s",$yeni_trh);
                                            $explode=explode(" ",$yeni_trh);
                                            $yeni_t=$explode[0];
                                            $yeni_s=$explode[1];
                                            // $date=date("Y-m-d H:i:s");
                                            $date=$teklif_tarihi;
                                            $tarih=strtotime("-".$sigorta_dakikanin_altinda." minutes",strtotime($ihale_bitis));
                                            $tarih=date("Y-m-d H:i:s",$tarih);
                                            if($date>$tarih){//Kaynak firma uye id 283
                                                $gosterilme_tarih=strtotime($yeni_trh)+300; //Gösterilme süresi 5 dk fazla olması istendi
                                                $gosterilme_tarih=date("Y-m-d H:i:s",$gosterilme_tarih);
                                                if($son_teklif_uye_id!="283"){
                                                    // $ilani_guncelle=mysql_query("update ilanlar set ihale_son_gosterilme='".$gosterilme_tarih."',sistem_sure_uzatma_durumu='0',ihale_tarihi='".$yeni_t."',ihale_saati='".$yeni_s."' where id='".$ilanID."'");
                                                    $ilani_guncelle=mysql_query("update ilanlar set sistem_sure_uzatma_durumu='0' where id='".$ilanID."'");
                                                }else{
                                                    // $ilani_guncelle=mysql_query("update ilanlar set ihale_son_gosterilme='".$gosterilme_tarih."',ihale_tarihi='".$yeni_t."',ihale_saati='".$yeni_s."' where id='".$ilanID."'");
                                                }
                                            }else{
                                                if($son_teklif_uye_id!="283"){
                                                    $ilani_guncelle=mysql_query("update ilanlar set sistem_sure_uzatma_durumu='0' where id='".$ilanID."'");
                                                }
                                            }
                                        }else{
                                            if($son_teklif_uye_id!="283"){
                                                $ilani_guncelle=mysql_query("update ilanlar set sistem_sure_uzatma_durumu='0' where id='".$ilanID."'");
                                            }
                                        }
                                    }
                                    if($ilani_guncelle){
                                        $response=["message"=>"Teklif başarıyla verildi","status"=>200 ];
                                        $islem_durum = 1;
                                    }else{
                                        $response=["message"=>"hata","status"=>500 ];
                                        $islem_durum = 0;
                                    }
                                }else{
                                    $teklif_durum=2;
                                    $onay_bekleyen_teklifler=mysql_query("select * from teklifler where ilan_id='".$ilanID."' and durum='2'");
                                    $ayni_teklif=false;
                                    while($onay_bekleyenler_oku=mysql_fetch_object($onay_bekleyen_teklifler)){
                                        if($verilen_teklif<=$onay_bekleyenler_oku->teklif){
                                            $ayni_teklif=true;
                                        }
                                    }
                                    if($ayni_teklif==true){
                                        $response=["message"=>"Bu teklif başka bir üye tarafından verildi ve onay bekliyor. Lütfen daha yüksek bir teklif vermeyi deneyiniz.","status"=>500];
                                        $islem_durum = 0;
                                    }
                                    else{
                                        if($_SESSION['u_token'] != ""){
                                            mysql_query("INSERT INTO `teklifler`(`id`,`ilan_id`,`uye_id`,`teklif`,`hizmet_bedeli`,`teklif_zamani`,`user_token`,`dogrudan_satisli_ilan_id`,`kurumsal_token`,ip,tarayici,isletim_sistemi,admin_teklif,admin_id,durum) 
                                                VALUES (NULL,'".$ilanID."','".$uyeID."','".$verilen_teklif."','".$hizmet_bedel."','".$date."','".$_SESSION['u_token']."','0','','".$ip."','".$tarayici."','".$isletim_sistemi."','0','0','".$teklif_durum."')");
                                        }elseif($_SESSION['k_token'] != ""){
                                            mysql_query("INSERT INTO `teklifler`(`id`,`ilan_id`,`uye_id`,`teklif`,`hizmet_bedeli`,`teklif_zamani`,`user_token`,`dogrudan_satisli_ilan_id`,`kurumsal_token`,ip,tarayici,isletim_sistemi,admin_teklif,admin_id,durum) 
                                                VALUES (NULL,'".$ilanID."','".$uyeID."','".$verilen_teklif."','".$hizmet_bedel."','".$date."','','0','".$_SESSION['k_token']."','".$ip."','".$tarayici."','".$isletim_sistemi."','0','0','".$teklif_durum."')");
                                        }
                                        $response=["message"=>$alacagi_mesaj,"status"=>200];
                                        $islem_durum = 1;
                                    }
                                }	
                            }
                        }else{
                            $ihale_son=$row->ihale_tarihi." ".$row->ihale_saati;
                            $ihale_son_str = strtotime($ihale_son);
                            $suan_str = strtotime(date("Y-m-d H:i:s"));
                            $sonuc=($ihale_son_str-$suan_str)/60;
                            if($sonuc>=$belirlenen ){
                                $teklif_durum=1;
                                if($_SESSION['u_token'] != ""){
                                mysql_query("INSERT INTO `teklifler`(`id`,`ilan_id`,`uye_id`,`teklif`,`hizmet_bedeli`,`teklif_zamani`,`user_token`,`dogrudan_satisli_ilan_id`,`kurumsal_token`,ip,tarayici,isletim_sistemi,admin_teklif,admin_id,durum) 
                                    VALUES (NULL,'".$ilanID."','".$uyeID."','".$verilen_teklif."','".$hizmet_bedel."','".$date."','".$_SESSION['u_token']."','0','','".$ip."','".$tarayici."','".$isletim_sistemi."','0','0','".$teklif_durum."')");
                                }elseif($_SESSION['k_token'] != ""){
                                    mysql_query("INSERT INTO `teklifler`(`id`,`ilan_id`,`uye_id`,`teklif`,`hizmet_bedeli`,`teklif_zamani`,`user_token`,`dogrudan_satisli_ilan_id`,`kurumsal_token`,ip,tarayici,isletim_sistemi,admin_teklif,admin_id,durum) 
                                        VALUES (NULL,'".$ilanID."','".$uyeID."','".$verilen_teklif."','".$hizmet_bedel."','".$date."','','0','".$_SESSION['k_token']."','".$ip."','".$tarayici."','".$isletim_sistemi."','0','0','".$teklif_durum."')");
                                }
                                $teklif_cek=mysql_query("select * from teklifler where ilan_id='".$ilanID."' and durum=1 group by uye_id order by teklif_zamani ");
                                $teklifler_array=array();
                                $kaynak_firma_teklifi='';
                                while($teklif_oku=mysql_fetch_object($teklif_cek)){
                                    $teklifleri_cek=mysql_query("select * from teklifler where ilan_id='".$ilanID."' and uye_id='".$teklif_oku->uye_id."' order by teklif_zamani desc limit 1 ");
                                    $teklifleri_oku=mysql_fetch_object($teklifleri_cek);
                                    $pushla=array_push($teklifler_array,$teklifleri_oku->teklif);
                                    if($teklif_oku->uye_id=='283'){
                                        $kaynak_firma_teklifi=$teklifleri_oku->teklif;
                                    }
                                }
                                $ilani_guncelle=mysql_query("update ilanlar set son_teklif='".max($teklifler_array)."' where id='".$ilanID."'");
                                $i_cek=mysql_query("select * from ilanlar where id='".$ilanID."'");
                                $i_oku=mysql_fetch_array($i_cek);
                                $t_cek=mysql_query("select * from teklifler where ilan_id='".$ilanID."' and durum=1 group by uye_id order by teklif_zamani ");
                                while($t_oku=mysql_fetch_object($t_cek)){
                                    $tt_cek=mysql_query("select * from teklifler where ilan_id='".$ilanID."' and uye_id='".$t_oku->uye_id."' order by teklif_zamani desc limit 1 ");
                                    $tt_oku=mysql_fetch_object($tt_cek);
                                    if($i_oku["son_teklif"]=$tt_oku->teklif){
                                        $son_teklif_uye_id=$tt_oku->uye_id;
                                    }
                                }
                                if($sonuc>=3){
                                    $ihale_bitis=$ilan_oku["ihale_tarihi"]." ".$ilan_oku["ihale_saati"];
                                    $sigorta_sure_uzatma_durumu=$row3->sure_uzatma;
                                    $sigorta_dakikanin_altinda=$row3->dakikanin_altinda;
                                    $sigorta_dakika_uzar=$row3->dakika_uzar;
                                    if($sigorta_sure_uzatma_durumu=="1"){
                                        $yeni_trh=strtotime("+".$sigorta_dakika_uzar." minutes",strtotime($ihale_bitis));
                                        $yeni_trh=date("Y-m-d H:i:s",$yeni_trh);
                                        $explode=explode(" ",$yeni_trh);
                                        $yeni_t=$explode[0];
                                        $yeni_s=$explode[1];
                                        // $date=date("Y-m-d H:i:s");
                                        $date=$teklif_tarihi;
                                        $tarih=strtotime("-".$sigorta_dakikanin_altinda." minutes",strtotime($ihale_bitis));
                                        $tarih=date("Y-m-d H:i:s",$tarih);
                                        if($date>$tarih){//Kaynak firma uye id 283
                                            $gosterilme_tarih=strtotime($yeni_trh)+300; //Gösterilme süresi 5 dk fazla olması istendi
                                            $gosterilme_tarih=date("Y-m-d H:i:s",$gosterilme_tarih);
                                            if($son_teklif_uye_id!="283"){
                                                // $ilani_guncelle=mysql_query("update ilanlar set ihale_son_gosterilme='".$gosterilme_tarih."',sistem_sure_uzatma_durumu='0',ihale_tarihi='".$yeni_t."',ihale_saati='".$yeni_s."' where id='".$ilanID."'");
                                                $ilani_guncelle=mysql_query("update ilanlar set sistem_sure_uzatma_durumu='0' where id='".$ilanID."'");
                                            }else{
                                                // $ilani_guncelle=mysql_query("update ilanlar set ihale_son_gosterilme='".$gosterilme_tarih."',ihale_tarihi='".$yeni_t."',ihale_saati='".$yeni_s."' where id='".$ilanID."'");
                                            }
                                        }else{
                                            if($son_teklif_uye_id!="283"){
                                                $ilani_guncelle=mysql_query("update ilanlar set sistem_sure_uzatma_durumu='0' where id='".$ilanID."'");
                                            }
                                        }
                                    }else{
                                        if($son_teklif_uye_id!="283"){
                                            $ilani_guncelle=mysql_query("update ilanlar set sistem_sure_uzatma_durumu='0' where id='".$ilanID."'");
                                        }
                                    }
                                }
                                if($ilani_guncelle){
                                    $response=["message"=>"Teklif başarıyla verildi","status"=>200];
                                    $islem_durum = 1;
                                }else{
                                    $response=["message"=>"hata","status"=>500];
                                    $islem_durum = 0;
                                }
                            }else{
                                $teklif_durum=2;
                                $onay_bekleyen_teklifler=mysql_query("select * from teklifler where ilan_id='".$ilanID."' and durum='2'");
                                $ayni_teklif=false;
                                while($onay_bekleyenler_oku=mysql_fetch_object($onay_bekleyen_teklifler)){
                                    if($verilen_teklif<=$onay_bekleyenler_oku->teklif){
                                        $ayni_teklif=true;
                                    }
                                }
                                if($ayni_teklif==true){
                                    $response=["message"=>"Bu teklif başka bir üye tarafından verildi ve onay bekliyor. Lütfen daha yüksek bir teklif vermeyi deneyiniz.","status"=>500];
                                    $islem_durum = 0;
                                }
                                else{
                                    if($_SESSION['u_token'] != ""){
                                        mysql_query("INSERT INTO `teklifler`(`id`,`ilan_id`,`uye_id`,`teklif`,`hizmet_bedeli`,`teklif_zamani`,`user_token`,`dogrudan_satisli_ilan_id`,`kurumsal_token`,ip,tarayici,isletim_sistemi,admin_teklif,admin_id,durum) 
                                            VALUES (NULL,'".$ilanID."','".$uyeID."','".$verilen_teklif."','".$hizmet_bedel."','".$date."','".$_SESSION['u_token']."','0','','".$ip."','".$tarayici."','".$isletim_sistemi."','0','0','".$teklif_durum."')");
                                    }elseif($_SESSION['k_token'] != ""){
                                        mysql_query("INSERT INTO `teklifler`(`id`,`ilan_id`,`uye_id`,`teklif`,`hizmet_bedeli`,`teklif_zamani`,`user_token`,`dogrudan_satisli_ilan_id`,`kurumsal_token`,ip,tarayici,isletim_sistemi,admin_teklif,admin_id,durum) 
                                            VALUES (NULL,'".$ilanID."','".$uyeID."','".$verilen_teklif."','".$hizmet_bedel."','".$date."','','0','".$_SESSION['k_token']."','".$ip."','".$tarayici."','".$isletim_sistemi."','0','0','".$teklif_durum."')");
                                    }
                                    $response=["message"=>$alacagi_mesaj,"status"=>200];
                                    $islem_durum = 1;
                                }
                            }	
                        }
                    }
                }
            }else{
                $response = ["message"=>"Hurda belgeli araçlara teklif verebilmek için lütfen bizimle iletişime geçin.","status"=>500];	
                $islem_durum = 0;
            }
        }else{
            if($teklif_engelle=="on"){
                if($engelleme_nedeni ==""){
                    $response = ["message"=>"Teklif verme yetkileriniz geçici olarak durdurulmuştur.","status"=>500];
                    $islem_durum = 0;
                }else{
                    $response = ["message"=>"$engelleme_nedeni","status"=>500];
                    $islem_durum = 0;
                }
            }else if($otomatik_teklif_engelle=="on" ){
                $response = ["message"=>"Sistem tarafından teklif vermeniz kısıtlanmıştır.Müşteri temsilcileri ile iletişime geçebilirsiniz.","status"=>500];
                $islem_durum = 0;
            }else{
                if($uye_tkn == ""){
                    $response=["message"=>"Teklif verebilmek için giriş yapmalısınız","status"=>500];
                    $islem_durum = 0;
                }else if($uye_tkn == $row->ihale_sahibi){
                    $response=["message"=>"Kendi ihalenize teklif veremezsiniz.","status"=>500];
                    $islem_durum = 0;
                }else if($row->ihale_tarihi." ".$row->ihale_saati < $teklif_tarihi){
                    $response=["message"=>"İhalenin süresi dolmuştur.","status"=>500];
                    $islem_durum = 0;
                }else if($verilen_teklif == ""){
                    $response=["message"=>"Teklfiniz boş olamaz","status"=>500];
                    $islem_durum = 0;
                } 
                else if($verilen_teklif <= $row->acilis_fiyati  ){
                    $response=["message"=>"Teklifiniz taban fiyat koşulunu sağlamamaktadır. İhalenin taban fiyatı $row->acilis_fiyati ₺'dir. ","status"=>500];
                    $islem_durum = 0;
                } 
                else if($verilen_teklif % $sigorta_min_artis != 0){
                    $response=["message"=>"Teklifiniz $sigorta_min_artis ₺ katları olmalı","status"=>500];
                    $islem_durum = 0;
                }
                else if($verilen_teklif > $teklif_limiti  ){
                    $response=["message"=>"Teklif limitini aştınız. Mevcut paketinizin teklif limiti '".money($teklif_limiti)."' ₺'dir. ","status"=>503];
                    $islem_durum = 0;
                } 					
                else if($verilen_teklif < $row->acilis_fiyati+$sigorta_min_artis){
                    $response=["message"=>"Teklfiniz taban fiyattan en az $sigorta_min_artis ₺ fazla olmalı ","status"=>500];
                    $islem_durum = 0;
                }  
                else if($engelli_sigorta=="true" ){
                    $response = ["message"=>"İlanın sigorta şirketine ait olan araçlara teklif vermeniz kısıtlanmıştır.","status"=>500];
                    $islem_durum = 0;
                }
                else{
                    if($sozlesme_kontrol !=1){
                        $sigort_cek_onay = mysql_query("select * from sigorta_ozellikleri where id = '".$row->sigorta."'");
                        $sigorta_oku_onay = mysql_fetch_object($sigort_cek_onay);
                        if($sigorta_oku_onay->teklif_onay_mekanizmasi == 1){
                            $response=["message"=>"Teklif verebilmeniz için sözleşmeyi kabul etmelisiniz.","status"=>500];
                            $islem_durum = 0;
                        }else{
                            $ihale_son=$row->ihale_tarihi." ".$row->ihale_saati;
                            $ihale_son_str = strtotime($ihale_son);
                            $suan_str = strtotime(date("Y-m-d H:i:s"));
                            $sonuc=($ihale_son_str-$suan_str)/60;
                            if($sonuc>=$belirlenen ){
                                $teklif_durum=1;
                                if($uye_tip == "bireysel"){
                                mysql_query("INSERT INTO `teklifler`(`id`,`ilan_id`,`uye_id`,`teklif`,`hizmet_bedeli`,`teklif_zamani`,`user_token`,`dogrudan_satisli_ilan_id`,`kurumsal_token`,ip,tarayici,isletim_sistemi,admin_teklif,admin_id,durum) 
                                    VALUES (NULL,'".$ilanID."','".$uyeID."','".$verilen_teklif."','".$hizmet_bedel."','".$date."','".$uye_tkn."','0','','".$ip."','".$tarayici."','".$isletim_sistemi."','0','0','".$teklif_durum."')");
                                }elseif($uye_tip != "bireysel"){
                                    mysql_query("INSERT INTO `teklifler`(`id`,`ilan_id`,`uye_id`,`teklif`,`hizmet_bedeli`,`teklif_zamani`,`user_token`,`dogrudan_satisli_ilan_id`,`kurumsal_token`,ip,tarayici,isletim_sistemi,admin_teklif,admin_id,durum) 
                                        VALUES (NULL,'".$ilanID."','".$uyeID."','".$verilen_teklif."','".$hizmet_bedel."','".$date."','','0','".$uye_tkn."','".$ip."','".$tarayici."','".$isletim_sistemi."','0','0','".$teklif_durum."')");
                                }
                                $kaynak_firma_teklifi='';
                                $teklif_cek=mysql_query("select * from teklifler where ilan_id='".$ilanID."' and durum=1 group by uye_id order by teklif_zamani ");
                                $teklifler_array=array();
                                while($teklif_oku=mysql_fetch_object($teklif_cek)){
                                    $teklifleri_cek=mysql_query("select * from teklifler where ilan_id='".$ilanID."' and uye_id='".$teklif_oku->uye_id."' order by teklif_zamani desc limit 1 ");
                                    $teklifleri_oku=mysql_fetch_object($teklifleri_cek);
                                    $pushla=array_push($teklifler_array,$teklifleri_oku->teklif);
                                }
                                $ilani_guncelle=mysql_query("update ilanlar set son_teklif='".max($teklifler_array)."' where id='".$ilanID."'");
                                $i_cek=mysql_query("select * from ilanlar where id='".$ilanID."'");
                                $i_oku=mysql_fetch_array($i_cek);
                                $t_cek=mysql_query("select * from teklifler where ilan_id='".$ilanID."' and durum=1 group by uye_id order by teklif_zamani ");
                                while($t_oku=mysql_fetch_object($t_cek)){
                                    $tt_cek=mysql_query("select * from teklifler where ilan_id='".$ilanID."' and uye_id='".$t_oku->uye_id."' order by teklif_zamani desc limit 1 ");
                                    $tt_oku=mysql_fetch_object($tt_cek);
                                    if($i_oku["son_teklif"]=$tt_oku->teklif){
                                        $son_teklif_uye_id=$tt_oku->uye_id;
                                    }
                                }
                                if($sonuc>=3){
                                    $ihale_bitis=$ilan_oku["ihale_tarihi"]." ".$ilan_oku["ihale_saati"];
                                    $sigorta_sure_uzatma_durumu=$row3->sure_uzatma;
                                    $sigorta_dakikanin_altinda=$row3->dakikanin_altinda;
                                    $sigorta_dakika_uzar=$row3->dakika_uzar;
                                    if($sigorta_sure_uzatma_durumu=="1"){
                                        $yeni_trh=strtotime("+".$sigorta_dakika_uzar." minutes",strtotime($ihale_bitis));
                                        $yeni_trh=date("Y-m-d H:i:s",$yeni_trh);
                                        $explode=explode(" ",$yeni_trh);
                                        $yeni_t=$explode[0];
                                        $yeni_s=$explode[1];
                                        // $date=date("Y-m-d H:i:s");
                                        $date=$teklif_tarihi;
                                        $tarih=strtotime("-".$sigorta_dakikanin_altinda." minutes",strtotime($ihale_bitis));
                                        $tarih=date("Y-m-d H:i:s",$tarih);
                                        
                                        if($date>$tarih){//Kaynak firma uye id 283
                                            $gosterilme_tarih=strtotime($yeni_trh)+300; //Gösterilme süresi 5 dk fazla olması istendi
                                            $gosterilme_tarih=date("Y-m-d H:i:s",$gosterilme_tarih);
                                            if($son_teklif_uye_id!="283"){
                                                // $ilani_guncelle=mysql_query("update ilanlar set ihale_son_gosterilme='".$gosterilme_tarih."',sistem_sure_uzatma_durumu='0',ihale_tarihi='".$yeni_t."',ihale_saati='".$yeni_s."' where id='".$ilanID."'");
                                                $ilani_guncelle=mysql_query("update ilanlar set sistem_sure_uzatma_durumu='0' where id='".$ilanID."'");
                                            }else{
                                                // $ilani_guncelle=mysql_query("update ilanlar set ihale_son_gosterilme='".$gosterilme_tarih."',ihale_tarihi='".$yeni_t."',ihale_saati='".$yeni_s."' where id='".$ilanID."'");
                                            }
                                        }else{
                                            if($son_teklif_uye_id!="283"){
                                                $ilani_guncelle=mysql_query("update ilanlar set sistem_sure_uzatma_durumu='0' where id='".$ilanID."'");
                                            }
                                        }
                                    }else{
                                        if($son_teklif_uye_id!="283"){
                                            $ilani_guncelle=mysql_query("update ilanlar set sistem_sure_uzatma_durumu='0' where id='".$ilanID."'");
                                        }
                                    }
                                }
                                if($ilani_guncelle){
                                    $response=["message"=>"Teklif başarıyla verildi","status"=>200];
                                    $islem_durum = 1;
                                }else{
                                    $response=["message"=>"hata","status"=>500];
                                    $islem_durum = 0;
                                }
                            }else{
                                $teklif_durum=2;
                                $onay_bekleyen_teklifler=mysql_query("select * from teklifler where ilan_id='".$ilanID."' and durum='2'");
                                $ayni_teklif=false;
                                while($onay_bekleyenler_oku=mysql_fetch_object($onay_bekleyen_teklifler)){
                                    if($verilen_teklif<=$onay_bekleyenler_oku->teklif){
                                        $ayni_teklif=true;
                                    }
                                }
                                if($ayni_teklif==true){
                                    $response=["message"=>"Bu teklif başka bir üye tarafından verildi ve onay bekliyor. Lütfen daha yüksek bir teklif vermeyi deneyiniz.","status"=>500];
                                    $islem_durum = 0;
                                }
                                else{
                                    if($uye_tip == "bireysel"){
                                        mysql_query("INSERT INTO `teklifler`(`id`,`ilan_id`,`uye_id`,`teklif`,`hizmet_bedeli`,`teklif_zamani`,`user_token`,`dogrudan_satisli_ilan_id`,`kurumsal_token`,ip,tarayici,isletim_sistemi,admin_teklif,admin_id,durum) 
                                            VALUES (NULL,'".$ilanID."','".$uyeID."','".$verilen_teklif."','".$hizmet_bedel."','".$date."','".$uye_tkn."','0','','".$ip."','".$tarayici."','".$isletim_sistemi."','0','0','".$teklif_durum."')");
                                    }elseif($uye_tip != "bireysel"){
                                        mysql_query("INSERT INTO `teklifler`(`id`,`ilan_id`,`uye_id`,`teklif`,`hizmet_bedeli`,`teklif_zamani`,`user_token`,`dogrudan_satisli_ilan_id`,`kurumsal_token`,ip,tarayici,isletim_sistemi,admin_teklif,admin_id,durum) 
                                            VALUES (NULL,'".$ilanID."','".$uyeID."','".$verilen_teklif."','".$hizmet_bedel."','".$date."','0','','".$uye_tip."','".$ip."','".$tarayici."','".$isletim_sistemi."','0','0','".$teklif_durum."')");
                                    }
                                    $response=["message"=>$alacagi_mesaj,"status"=>200];
                                    $islem_durum = 1;
                                }
                            }
                        }
                    }else{
                        $ihale_son=$row->ihale_tarihi." ".$row->ihale_saati;
                        $ihale_son_str = strtotime($ihale_son);
                        $suan_str = strtotime(date("Y-m-d H:i:s"));
                        $sonuc=($ihale_son_str-$suan_str)/60;
                        if($sonuc>=$belirlenen ){
                            $teklif_durum=1;
                            if($uye_tip == "bireysel"){
                            mysql_query("INSERT INTO `teklifler`(`id`,`ilan_id`,`uye_id`,`teklif`,`hizmet_bedeli`,`teklif_zamani`,`user_token`,`dogrudan_satisli_ilan_id`,`kurumsal_token`,ip,tarayici,isletim_sistemi,admin_teklif,admin_id,durum) 
                                VALUES (NULL,'".$ilanID."','".$uyeID."','".$verilen_teklif."','".$hizmet_bedel."','".$date."','".$uye_tkn."','0','','".$ip."','".$tarayici."','".$isletim_sistemi."','0','0','".$teklif_durum."')");
                            }elseif($uye_tip != "bireysel"){
                                mysql_query("INSERT INTO `teklifler`(`id`,`ilan_id`,`uye_id`,`teklif`,`hizmet_bedeli`,`teklif_zamani`,`user_token`,`dogrudan_satisli_ilan_id`,`kurumsal_token`,ip,tarayici,isletim_sistemi,admin_teklif,admin_id,durum) 
                                    VALUES (NULL,'".$ilanID."','".$uyeID."','".$verilen_teklif."','".$hizmet_bedel."','".$date."','','0','".$uye_tkn."','".$ip."','".$tarayici."','".$isletim_sistemi."','0','0','".$teklif_durum."')");
                            }
                            $kaynak_firma_teklifi='';
                            $teklif_cek=mysql_query("select * from teklifler where ilan_id='".$ilanID."' and durum=1 group by uye_id order by teklif_zamani ");
                            $teklifler_array=array();
                            while($teklif_oku=mysql_fetch_object($teklif_cek)){
                                $teklifleri_cek=mysql_query("select * from teklifler where ilan_id='".$ilanID."' and uye_id='".$teklif_oku->uye_id."' order by teklif_zamani desc limit 1 ");
                                $teklifleri_oku=mysql_fetch_object($teklifleri_cek);
                                $pushla=array_push($teklifler_array,$teklifleri_oku->teklif);
                            }
                            $ilani_guncelle=mysql_query("update ilanlar set son_teklif='".max($teklifler_array)."' where id='".$ilanID."'");
                            $i_cek=mysql_query("select * from ilanlar where id='".$ilanID."'");
                            $i_oku=mysql_fetch_array($i_cek);
                            $t_cek=mysql_query("select * from teklifler where ilan_id='".$ilanID."' and durum=1 group by uye_id order by teklif_zamani ");
                            while($t_oku=mysql_fetch_object($t_cek)){
                                $tt_cek=mysql_query("select * from teklifler where ilan_id='".$ilanID."' and uye_id='".$t_oku->uye_id."' order by teklif_zamani desc limit 1 ");
                                $tt_oku=mysql_fetch_object($tt_cek);
                                if($i_oku["son_teklif"]=$tt_oku->teklif){
                                    $son_teklif_uye_id=$tt_oku->uye_id;
                                }
                            }
                            if($sonuc>=3){
                                $ihale_bitis=$ilan_oku["ihale_tarihi"]." ".$ilan_oku["ihale_saati"];
                                $sigorta_sure_uzatma_durumu=$row3->sure_uzatma;
                                $sigorta_dakikanin_altinda=$row3->dakikanin_altinda;
                                $sigorta_dakika_uzar=$row3->dakika_uzar;
                                if($sigorta_sure_uzatma_durumu=="1"){
                                    $yeni_trh=strtotime("+".$sigorta_dakika_uzar." minutes",strtotime($ihale_bitis));
                                    $yeni_trh=date("Y-m-d H:i:s",$yeni_trh);
                                    $explode=explode(" ",$yeni_trh);
                                    $yeni_t=$explode[0];
                                    $yeni_s=$explode[1];
                                    // $date=date("Y-m-d H:i:s");
                                    $date=$teklif_tarihi;
                                    $tarih=strtotime("-".$sigorta_dakikanin_altinda." minutes",strtotime($ihale_bitis));
                                    $tarih=date("Y-m-d H:i:s",$tarih);
                                    if($date>$tarih){//Kaynak firma uye id 283
                                        $gosterilme_tarih=strtotime($yeni_trh)+300; //Gösterilme süresi 5 dk fazla olması istendi
                                        $gosterilme_tarih=date("Y-m-d H:i:s",$gosterilme_tarih);
                                        if($son_teklif_uye_id!="283"){
                                            // $ilani_guncelle=mysql_query("update ilanlar set ihale_son_gosterilme='".$gosterilme_tarih."',sistem_sure_uzatma_durumu='0',ihale_tarihi='".$yeni_t."',ihale_saati='".$yeni_s."' where id='".$ilanID."'");
                                            $ilani_guncelle=mysql_query("update ilanlar set sistem_sure_uzatma_durumu='0' where id='".$ilanID."'");
                                        }else{
                                            // $ilani_guncelle=mysql_query("update ilanlar set ihale_son_gosterilme='".$gosterilme_tarih."',ihale_tarihi='".$yeni_t."',ihale_saati='".$yeni_s."' where id='".$ilanID."'");
                                        }
                                    }else{
                                        if($son_teklif_uye_id!="283"){
                                            $ilani_guncelle=mysql_query("update ilanlar set sistem_sure_uzatma_durumu='0' where id='".$ilanID."'");
                                        }
                                    }
                                }else{
                                    if($son_teklif_uye_id!="283"){
                                        $ilani_guncelle=mysql_query("update ilanlar set sistem_sure_uzatma_durumu='0' where id='".$ilanID."'");
                                    }
                                }
                            }
                            if($ilani_guncelle){
                                $response=["message"=>"Teklif başarıyla verildi","status"=>200 ];
                                $islem_durum = 1;
                            }else{
                                $response=["message"=>"hata","status"=>500 ];
                                $islem_durum = 0;
                            }
                        }else{
                            $teklif_durum=2;
                            $onay_bekleyen_teklifler=mysql_query("select * from teklifler where ilan_id='".$ilanID."' and durum='2'");
                            $ayni_teklif=false;
                            while($onay_bekleyenler_oku=mysql_fetch_object($onay_bekleyen_teklifler)){
                                if($verilen_teklif<=$onay_bekleyenler_oku->teklif){
                                    $ayni_teklif=true;
                                }
                            }
                            if($ayni_teklif==true){
                                $response=["message"=>"Bu teklif başka bir üye tarafından verildi ve onay bekliyor. Lütfen daha yüksek bir teklif vermeyi deneyiniz.","status"=>500];
                                $islem_durum = 0;
                            }
                            else{
                                if($uye_tip == "bireysel"){
                                    mysql_query("INSERT INTO `teklifler`(`id`,`ilan_id`,`uye_id`,`teklif`,`hizmet_bedeli`,`teklif_zamani`,`user_token`,`dogrudan_satisli_ilan_id`,`kurumsal_token`,ip,tarayici,isletim_sistemi,admin_teklif,admin_id,durum) 
                                        VALUES (NULL,'".$ilanID."','".$uyeID."','".$verilen_teklif."','".$hizmet_bedel."','".$date."','".$uye_tkn."','0','','".$ip."','".$tarayici."','".$isletim_sistemi."','0','0','".$teklif_durum."')");
                                }elseif($uye_tip != "bireysel"){
                                    mysql_query("INSERT INTO `teklifler`(`id`,`ilan_id`,`uye_id`,`teklif`,`hizmet_bedeli`,`teklif_zamani`,`user_token`,`dogrudan_satisli_ilan_id`,`kurumsal_token`,ip,tarayici,isletim_sistemi,admin_teklif,admin_id,durum) 
                                        VALUES (NULL,'".$ilanID."','".$uyeID."','".$verilen_teklif."','".$hizmet_bedel."','".$date."','0','','".$uye_tkn."','".$ip."','".$tarayici."','".$isletim_sistemi."','0','0','".$teklif_durum."')");
                                }
                                $response=["message"=>$alacagi_mesaj,"status"=>200];
                                $islem_durum = 1;
                            }
                        }
                    }
                }
            }
        }
    }
    if($islem_durum == 1 && $teklif_durum == 1){
        $ilan_cek = mysql_query("select * from ilanlar where id = '".$ilanID."'");
        $ilan_oku = mysql_fetch_object($ilan_cek);
        $ilan_sigorta = $ilan_oku->sigorta;
        $sigorta_cek = mysql_query("select * from sigorta_ozellikleri where id = '".$ilan_sigorta."'");
        $sigorta_oku = mysql_fetch_object($sigorta_cek);
        if($sigorta_oku->sure_uzatma == 1){
            $kac_dakikanin_altinda = $sigorta_oku->dakikanin_altinda;
            $kac_saniyenin_altinda = $kac_dakikanin_altinda * 60;
            $uzayacak_dikaka = $sigorta_oku->dakika_uzar;
            $ilan_bitis = strtotime($ilan_oku->ihale_tarihi." ".$ilan_oku->ihale_saati);
            // $suan = strtotime(date('Y-m-d H:i:s'));
            $suan = strtotime($teklif_tarihi);
            $fark = $ilan_bitis - $suan;
            if($fark < $kac_saniyenin_altinda){				
                $yeni_trh=strtotime("+".$uzayacak_dikaka." minutes",strtotime($ilan_bitis));
                $yeni_trh=date("Y-m-d H:i:s",$yeni_trh);
                $yeni_trh = date('Y-m-d H:i:s', strtotime('+'.$uzayacak_dikaka.' minutes', strtotime($ilan_oku->ihale_tarihi." ".$ilan_oku->ihale_saati)));
                $explode=explode(" ",$yeni_trh);
                $yeni_t=$explode[0];
                $yeni_s=$explode[1];
                $gosterilme_tarih=strtotime($yeni_trh)+300; //Gösterilme süresi 5 dk fazla olması istendi.
                $gosterilme_tarih = date('Y-m-d H:i:s',$gosterilme_tarih);
                mysql_query("UPDATE ilanlar SET ihale_tarihi='".$yeni_t."', ihale_saati='".$yeni_s."', ihale_son_gosterilme='".$gosterilme_tarih."' WHERE id='".$ilanID."'");
            }
        }
    }
    echo json_encode($response);
}

//Araç Teklif Ver Page End

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

if(re("action")=="panel_ilan_guncelle"){
    $response=[];
    $ilan_id=re("ilan_id");
    $user_token=re("user_token");
    // $kapanis_zamani=re("kapanis_zamani");
    // $duzenli_kapanis_zamani=date("Y-m-d H:i:s",strtotime($kapanis_zamani));
    
    $ilan_getir=mysql_query("select * from ilanlar where id='".$ilan_id."'");
    $ilan_getirilen=mysql_fetch_object($ilan_getir);
    $kapanis_zamani = $ilan_getirilen->ihale_tarihi." ".$ilan_getirilen->ihale_saati;
    $duzenli_kapanis_zamani = date("Y-m-d H:i:s",strtotime($kapanis_zamani));
    
    $ilan_sigorta=mysql_query("select * from sigorta_ozellikleri where id='".$ilan_getirilen->sigorta."'");
    $ilan_sigorta_oku=mysql_fetch_object($ilan_sigorta);
    $belirlenen=$ilan_sigorta_oku->bu_sure_altinda_teklif;
    $sigorta_saniyenin_altinda=$ilan_sigorta_oku->saniyenin_altinda;
    $sigorta_saniye_uzar=$ilan_sigorta_oku->saniye_uzar;
    
    $bitis_tarihi=$ilan_getirilen->ihale_tarihi." ".$ilan_getirilen->ihale_saati;
    $yeni_tarih_str=strtotime($bitis_tarihi)+$sigorta_saniye_uzar;//Belirlenen saniye eklendi
    $yeni_tarih=date("Y-m-d H:i:s",$yeni_tarih_str);
    $duzenli_yeni_tarih=date("d-m-Y H:i:s",strtotime($yeni_tarih));
    $parcala=explode(" ",$yeni_tarih);
    $yeni_ihale_tarihi=$parcala[0];
    $yeni_ihale_saati=$parcala[1];
    
    if($ilan_getirilen->ihale_turu=="1"){
        $son_teklif=mysql_query("select * from teklifler where ilan_id='".$ilan_id."' and durum=1 order by teklif_zamani limit 1");
        $son_teklif_oku=mysql_fetch_object($son_teklif);
        $son_teklif_uye_id=$son_teklif_oku->uye_id;
    }else{
        $son_teklif=mysql_query("select * from teklifler where durum=1 and ilan_id='".$ilan_id."' group by uye_id order by teklif_zamani");
        while($son_teklifler_oku=mysql_fetch_array($son_teklif)){
            $uye_son_teklif=mysql_query("select * from teklifler where durum=1 and uye_id='".$son_teklifler_oku["uye_id"]."' and ilan_id='".$ilan_id."' order by teklif_zamani limit 1");
            $uye_son_teklif_oku=mysql_fetch_array($uye_son_teklif);
            if($ilan_getirilen->son_teklif==$uye_son_teklif_oku["teklif"]){
                $son_teklif_uye_id=$uye_son_teklif_oku["uye_id"];
            }
        }
    }
    
    $ihale_son_str = strtotime($bitis_tarihi);
    $suan_str = strtotime(date("Y-m-d H:i:s"));
    //$sonuc=($ihale_son_str-$suan_str)/60;
    $sonuc=$ihale_son_str-$suan_str;

    if($sonuc<$sigorta_saniyenin_altinda && $ilan_getirilen->sistem_sure_uzatma_durumu==0 && $son_teklif_uye_id !='283' && mysql_num_rows($son_teklif)!=0 ){//Kaynak firma uye_id 283
        $y_trh=$yeni_ihale_tarihi." ".$yeni_ihale_saati.":00";
        $gosterilme_tarih=strtotime($y_trh)+300; //Gösterilme süresi 5 dk fazla olması istendi
        $gosterilme_tarih=date("Y-m-d H:i:s",$gosterilme_tarih);
        $guncelle=mysql_query("update ilanlar set ihale_tarihi='$yeni_ihale_tarihi',ihale_saati='$yeni_ihale_saati',sistem_sure_uzatma_durumu='1',ihale_son_gosterilme='".$gosterilme_tarih."' where id='".$ilan_id."' ");
    }
    
    $ilan_cek=mysql_query("SELECT * FROM ilanlar where id='".$ilan_id."' ");
    $ilan_oku=mysql_fetch_object($ilan_cek);
    $ilan_bitis=$ilan_oku->ihale_tarihi." ".$ilan_oku->ihale_saati;

    $milisaniye=1000*(strtotime($ilan_bitis)-strtotime($duzenli_kapanis_zamani));
    
    
    $tablo_rengi="";
    $teklif_cek = mysql_query("SELECT * FROM teklifler WHERE ilan_id = '".$ilan_id."' and durum=1 order by teklif_zamani desc limit 1");
    $teklifini_oku = mysql_fetch_assoc($teklif_cek);
    $teklifler=mysql_query("select * from teklifler where ilan_id='".$ilan_id."' and durum=1 order by teklif_zamani desc ");
    $toplam_teklif = mysql_num_rows($teklifler);
    $admin_gormedigi_teklif = mysql_num_rows(mysql_query("select * from teklifler where ilan_id='".$ilan_id."' and durum=1 and is_admin_see = 0 and uye_id <> 283 order by teklif_zamani desc "));
    $statu_cek = mysql_query("SELECT * FROM kazanilan_ilanlar WHERE ilan_id = '".$ilan_id."'");
    $statu_oku = mysql_fetch_assoc($statu_cek);
    if($toplam_teklif>0){
        if($statu_oku['durum'] == "0" || $statu_oku['durum'] == "1" || $statu_oku['durum'] == "2" || $statu_oku['durum'] == "3" || $statu_oku['durum'] == "4"){
            $tablo_rengi = "#1b8d3d"; //Koyu yeşil
        }else if($ilan_oku->ihale_turu == "1" && $teklifini_oku['uye_id']!='283'){
            if($ilan_oku->durum == "-1"){
                $tablo_rengi = "#00a2ff"; //Açık mavi       
            }else{
                $tablo_rengi = "#b4e61d"; //Açık yeşil      
            }
        }else if($ilan_oku->ihale_turu== "1" && $teklifini_oku['uye_id']=='283'){
            $tablo_rengi = "#feadc8";  //Toz pembe
        }else {
            if($ilan_oku->ihale_turu== "2" && $teklifini_oku['uye_id']=='283'){
                $tablo_rengi = "#ffd0b0";//Krem rengi
            }else{
                $tablo_rengi = "#ffd0b0";//Krem rengi
            }
        }
    }else{
        $tablo_rengi = "#fff"; //Beyaz
    }
    $ilan_son_gosterilme=$ilan_oku->ihale_son_gosterilme;
    
    if($ilan_bitis>date("Y-m-d H:i:s")){
        /*if($toplam_teklif>0){
            $ilan_durum="true";
            
        }else{
            $ilan_durum="false";
        }*/
        $ilan_durum="true";
        
    }else{
        if($toplam_teklif>0){
            if($ilan_son_gosterilme > date("Y-m-d H-i-s")){
                $ilan_durum="true";
            }else{
                $ilan_durum="false";
            }
        }else{
            $ilan_durum="false";
        }
    }

    if($ilan_bitis > date('Y-m-d H:i:s')){
        $ilan_yeni_durum = 1;
    }else{
        if($ilan_bitis<date("Y-m-d H:i:s") && $toplam_teklif == 0){
            $ilan_yeni_durum = 0;
        }else{			
            $new_time = date("Y-m-d H:i:s", strtotime('+5 minutes', strtotime($ilan_bitis)));		
            if($toplam_teklif == 0){
                $ilan_yeni_durum = 0;
            }else{
                if($new_time > date('Y-m-d H:i:s')){
                    $ilan_yeni_durum = 1;					
                }else{
                    $ilan_yeni_durum = 0;
                }
            }
            
        }
    }
    
    //$ilan_durum="true";
    $suan=date("Y-m-d H:i:s");
    $gosterilme_sonuc=strtotime($ilan_son_gosterilme)-strtotime($suan);
    if($gosterilme_sonuc>0 && $son_teklif_uye_id !='283'){
        $gosterilme="true";
    }else{
        $gosterilme="false";
    }
    
    $mesaj_cek = mysql_query("select * from chat_room where ilan_id = '".$ilan_id."' and status = 1");
    $mesaj_sayi = mysql_num_rows($mesaj_cek);
    $okunmamis_sayi = 0;
    while($mesaj_oku = mysql_fetch_object($mesaj_cek)){
        $okunmamis_sayi += mysql_num_rows(mysql_query("select* from chat_messages where room_id = '".$mesaj_oku->id."' and gonderen_type = 1 and is_admin_see = 0"));
    }
    if($okunmamis_sayi > 0){
        $okunmamis_mesaj_var_mi = 1;
    }else{
        $okunmamis_mesaj_var_mi = 0;
    }
    $onay_bekleyen_teklif_cek = mysql_query("select * from teklifler where durum = 2 and ilan_id = '".$ilan_id."'");		
    if(mysql_num_rows($onay_bekleyen_teklif_cek) == 0){
        $onay_bekleyen_teklif_var_mi = 0;
    }else{
        $kaynak_teklif_cek = mysql_query("select * from teklifler where durum = 2 and ilan_id = '".$ilan_id."' and uye_id = '283'");
        if(mysql_num_rows($kaynak_teklif_cek) == 0){
            $onay_bekleyen_teklif_var_mi = 1;
        }else{
            $onay_bekleyen_teklif_var_mi = 0;
        }		
    }
    $onaydaki_cek = mysql_query("select * from teklifler WHERE ilan_id ='".$ilan_id."' and durum = 2");
    $onaydaki_oku = mysql_num_rows($onaydaki_cek);
    if(mysql_num_rows($onaydaki_cek) == 0){
        $onaydaki_sayi = 0;
    }else{
        $onaydaki_sayi = 1;
    }
    if(date('Y-m-d H:i:s') >= $duzenli_kapanis_zamani){
        $sure_bitmis = 1;
        $son_teklif_yeni = '<i style="color:#000" class="fas fa-lock"></i>';
    }else{
        $sure_bitmis = 0;
        if($ilan_oku->ihale_turu == 1){
            $son_teklif_yeni = money($ilan_oku->son_teklif)." ₺";
        }else{
            $son_teklif_yeni = money($ilan_oku->acilis_fiyati)." ₺";
        }

    }
    
    $bitis_tarihi=$ilan_bitis;
    $ihale_son_str = strtotime($bitis_tarihi);
    $suan_str = strtotime(date("Y-m-d H:i:s"));
    $sonuc=($ihale_son_str-$suan_str)/60;
    
    $uye_token = $user_token;
    $uye_cek = mysql_query("select * from user where user_token = '".$uye_token."' or kurumsal_user_token = '".$uye_token."'");
    $uye_oku = mysql_fetch_object($uye_cek);
    $uye_id = $uye_oku->id;
    if($uye_token!=""){	
        if($sonuc<30){ 
            $kullanici_grubu = kullanici_grubu_cek($uye_token);
            if($kullanici_grubu==1){
                $user_package_status=true;
            }else{
                $user_package_status=false;
            }
            $kazanilan_sorgu=mysql_query("select * from kazanilan_ilanlar where ilan_id='".$ilan_id."' ");
            if(mysql_num_rows($kazanilan_sorgu)==0){
                $ilan_status=1;
            }else{
                $ilan_status=0;
            }					
        }else{
            $ilan_status=1;
            $user_package_status=true;					
        }			
        if($ilan_oku->son_teklif>0){
            $teklif=$ilan_oku->son_teklif;
        }else{
            $teklif=$ilan_oku->acilis_fiyati;
        }
        if($ilan_oku->ihale_son_gosterilme >= date('Y-m-d H:i:s')){
            $ilan_status=1;
        }else{
            $ilan_status = 0;
        }
    }else{			
        if($sonuc<30){ 
            $ilan_status=0;
            $user_package_status=false;
        }else{
            $ilan_status=1;
            $user_package_status=true;
        }
        if($ilan_oku->son_teklif>0){
            $teklif=$ilan_oku->son_teklif;
        }else{
            $teklif=$ilan_oku->acilis_fiyati;
        }
        if($ilan_oku->ihale_son_gosterilme >= date('Y-m-d H:i:s')){
            $ilan_status=1;
        }else{
            $ilan_status = 0;
        }			
    }
    $benim_son_teklif_cek = mysql_query("select * from teklifler where ilan_id = '".$ilan_oku->id."' and uye_id = '".$uye_id."' and durum = 1 order by teklif desc");
    if(mysql_num_rows($benim_son_teklif_cek) == 0){
        $en_yuksek_benim = 0;
        $benim_son_teklif = "";
    }else{
        $benim_son_teklif_oku = mysql_fetch_object($benim_son_teklif_cek);
        $benim_son_teklif = money($benim_son_teklif_oku->teklif);
        if($benim_son_teklif == $ilan_oku->son_teklif){
            $en_yuksek_benim = 1;
        }else{
            $en_yuksek_benim = 0;
        }
    }
    $response=[
        "id"=>$ilan_oku->id,
        "son_teklif"=>$ilan_oku->son_teklif,
        "en_yuksek_benim"=>$en_yuksek_benim,
        "son_teklif_yeni" => $son_teklif_yeni,
        "ihale_tarihi"=>date("d-m-Y H:i:s",strtotime($ilan_bitis)),		
        "milisaniye"=>$milisaniye, 
        "belirlenen"=>$belirlenen, 
        "renk"=>$tablo_rengi,
        "ilan_durumu"=>$ilan_durum,
        "gosterilme"=>$gosterilme,
        "gosterilme_sonuc"=>$gosterilme_sonuc,
        "toplam_teklif" => $toplam_teklif,
        "mesaj_sayi" => $mesaj_sayi,
        "okunmamis_mesaj_var_mi" => $okunmamis_mesaj_var_mi,
        "onay_bekleyen_teklif_var_mi" => $onay_bekleyen_teklif_var_mi,
        "onaydaki_sayi" => $onaydaki_sayi,
        "yeni_teklif" => $admin_gormedigi_teklif,
        "ilan_yeni_durum" => $ilan_yeni_durum,
        "sure_bitmis_mi" => $sure_bitmis,
        "arac_detay_ihale_saati" => $ilan_bitis,
        "son_gosterilme" => $ilan_oku->ihale_son_gosterilme,
        "suan" => date('Y-m-d H:i:s'),
        "user_package_status" => $user_package_status,
        "ilan_status" => $ilan_status,
        "benim_son_teklif" => $benim_son_teklif,
    ];
    echo json_encode($response);
}











?>