<?php 
$gelen_id = re('id');
$islem = re('q');
?>
<?php 

// TEKLİF ONAYLAMA
if($islem == "onayla"){
    $teklif_bul = mysql_query("select * from teklifler where id = '".$gelen_id."'");
    $teklif_oku = mysql_fetch_assoc($teklif_bul);
    $ilan_bul = mysql_query("select * from ilanlar where id = '".$teklif_oku['ilan_id']."'");
    $ilan_oku = mysql_fetch_assoc($ilan_bul);
    $sigorta_bul = mysql_query("select * from sigorta_ozellikleri where id = '".$ilan_oku['sigorta']."'");
    $sigorta_oku = mysql_fetch_assoc($sigorta_bul);    
    if($sigorta_oku['sure_uzatma'] == 1){
        $dakikanin_altinda = $sigorta_oku['dakikanin_altinda'];
        $dakika_uzar = $sigorta_oku['dakika_uzar'];
        $genel_kapanis = $ilan_oku['ihale_tarihi']." ".$ilan_oku['ihale_saati'];
        $suanki_zaman = date('Y-m-d H:i:s');
        $a = date('Y-m-d H:i:s', strtotime('+'.$dakikanin_altinda.'minutes', strtotime($suanki_zaman)));	        
        if($a > $genel_kapanis){            
            $suan_saat = date('H:i:s');
            $guncellenen_saat = date('H:i:s', strtotime('+'.$dakika_uzar.'minutes', strtotime($suan_saat)));            
            $guncelle = mysql_query("update ilanlar set durum = 1,sistem_sure_uzatma_durumu=0, ihale_tarihi = '".date('Y-m-d')."', ihale_saati = '".$guncellenen_saat."' where id = '".$ilan_oku['id']."'");
            $teklifi_onayla = mysql_query("update teklifler set durum = 1 where id = '".$gelen_id."'");        
            if($ilan_oku['son_teklif'] < $teklif_oku['teklif']){
                $son_teklif_guncelle = mysql_query("update ilanlar set son_teklif = '".$teklif_oku['teklif']."'");
            }
            header('Location: ?modul=ihaleler&sayfa=onay_bekleyen_teklifler');    
        }
    }else{
        $teklifi_onayla = mysql_query("update teklifler set durum = 1 where id = '".$gelen_id."'");   
        header('Location: ?modul=ihaleler&sayfa=tum_ihaleler'); 
    }
}

// TEKLİF REDDETME
if($islem == "reddet"){
    $teklif_sil = mysql_query("update teklifler set durum = 0 where id = '".$gelen_id."'");
    header('Location: ?modul=ihaleler&sayfa=onay_bekleyen_teklifler');
}

?>