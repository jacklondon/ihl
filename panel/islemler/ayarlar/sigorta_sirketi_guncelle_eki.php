<?php 
    $gelen_id=re("id");    
    if(re('guncellenen_sigorta_sirketini')=="Kaydet"){ 


        mysql_query("UPDATE sigorta_sirketleri SET 
        sirket_adi                      =    '".re('sirket_adi')."',
        altin_uye_zil_sesi              =    '".re('zil_sesi')."',
        altin_uye_zil_sesi_dakikasi     =    '".re('dakika')."',
        hizli_teklif_1                  =    '".re('hizli_teklif1')."',
        hizli_teklif_2                  =    '".re('hizli_teklif2')."',
        hizli_teklif_3                  =    '".re('hizli_teklif3')."',
        hizli_teklif_4                  =    '".re('hizli_teklif4')."',
        misafir_arac_listeleme          =    '".re('misafir_uye_arac')."',
        misafir_detay_gorme             =    '".re('misafir_detay_gorebilir')."',
        demo_arac_listeleme             =    '".re('demo_uye_arac')."',
        demo_detay_gorme                =    '".re('demo_detay_gorebilir')."',
        sure_uzatma                     =    '".re('sure_uzatma')."',
        dakikanin_altinda               =    '".re('dakikanin_altinda')."',
        dakika_uzar                     =    '".re('dakika_uzar')."',
        uyari_notu                      =    '".re('uyari_notu')."',
        sigorta_aciklamasi              =    '".re('sigorta_aciklamasi')."',
        park_ucreti                     =    '".re('park_ucreti')."',
        sigorta_dosya_masrafi           =    '".re('sigorta_dosya_masrafi')."',
        minumum_artis                   =    '".re('minumum_artis')."',
        teklif_uyari_sesi               =    '".re('teklif_uyari_sesi')."',
        sigorta_bitis_saati             =    '".re('sigorta_dakika')."',
        bu_sure_altinda_teklif          =    '".re('sure_altinda_teklif_verilirse')."',
        alacagi_mesaj                   =    '".re('bu_mesaji_alsin')."',
        vip_arac_listeleme              =    '".re('vip_uye_arac')."',
        vip_detay_gorme                 =    '".re('vip_detay_gorebilir')."',
        gold_arac_listeleme             =    '".re('gold_uye_arac')."',
        gold_detay_gorme                =    '".re('gold_detay_gorebilir')."',
        teklif_onay_mekanizmasi         =    '".re('teklif_onay')."',
        teklif_iletme_mesaji            =    '".re('onaylama_mesaji')."',
        gold_teklif_son_teklif_ayni_ise =    '".re('teklif_ayni_ise_sure')."',
        altina_inince_dakika_eklensin   =    '".re('sure_eklensin')."',
        ihale_tipi                      =    '".re('ihale_tipi')."',        
        vitrin                          =    '".re('vitrin')."'

        WHERE id = $gelen_id
          ");
            header("Location:?modul=ayarlar&sayfa=sigorta_sirketi_ayarlari&id=$gelen_id");
    }   
           

?>




