<?php
    include 'ayar.php';
    $sure_cek = mysql_query("select * from eski_ilan_sil");
    $sure_oku = mysql_fetch_object($sure_cek);
    $sure = $sure_oku->ay_sayi;
    $now = date('Y-m-d');
    $yeni_trh = strtotime("-".$sure." months",strtotime($now));
    $bitis_tarihi = date("Y-m-d",$yeni_trh);
    $cek = mysql_query("select * from ilanlar where ihale_tarihi < '".$bitis_tarihi."' and durum <> 2");
    // var_dump("select * from ilanlar where ihale_tarihi < '".$bitis_tarihi."' and durum <> 2");
    while($oku = mysql_fetch_object($cek)){
        $kontrol = mysql_query("select * from kazanilan_ilanlar where ilan_id = '".$oku->id."'");
        if(mysql_num_rows($kontrol) == 0){
            $kontrol2 = mysql_query("select * from satilan_araclar where ilan_id = '".$oku->id."'");
            if(mysql_num_rows($kontrol2) == 0){
                mysql_query("update ilanlar set durum = 2, eski_ilan_sil = 1 where id = '".$oku->id."'");
            }				
        }
    }
?>