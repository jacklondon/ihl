<?php 
    if(re('sigorta_sirketini')=="Kaydet"){        
        mysql_query("INSERT INTO `sigorta_sirketleri` 
        (`id`,
         `sirket_adi`, 
         `altin_uye_zil_sesi`, 
         `altin_uye_zil_sesi_dakikasi`, 
         `hizli_teklif_1`, 
         `hizli_teklif_2`, 
         `hizli_teklif_3`, 
         `hizli_teklif_4`, 
         `misafir_arac_listeleme`, 
         `misafir_detay_gorme`, 
         `demo_arac_listeleme`, 
         `demo_detay_gorme`, 
         `sure_uzatma`, 
         `dakikanin_altinda`, 
         `dakika_uzar`, 
         `uyari_notu`, 
         `sigorta_aciklamasi`, 
         `park_ucreti`, 
         `sigorta_dosya_masrafi`, 
         `minumum_artis`, 
         `teklif_uyari_sesi`, 
         `sigorta_bitis_saati`, 
         `bu_sure_altinda_teklif`, 
         `alacagi_mesaj`, 
         `vip_arac_listeleme`, 
         `vip_detay_gorme`, 
         `gold_arac_listeleme`, 
         `gold_detay_gorme`, 
         `teklif_onay_mekanizmasi`, 
         `teklif_iletme_mesaji`, 
         `gold_teklif_son_teklif_ayni_ise`,
         `altina_inince_dakika_eklensin`, 
         `ihale_tipi`, 
         `vitrin`) 
          VALUES 
          (NULL, 
          '".re('sirket_adi')."', 
          '".re('zil_sesi')."', 
          '".re('dakika')."', 
          '".re('hizli_teklif1')."', 
          '".re('hizli_teklif2')."', 
          '".re('hizli_teklif3')."', 
          '".re('hizli_teklif4')."', 
          '".re('misafir_uye_arac')."', 
          '".re('misafir_detay_gorebilir')."', 
          '".re('demo_uye_arac')."', 
          '".re('demo_detay_gorebilir')."', 
          '".re('sure_uzatma')."', 
          '".re('dakikanin_altinda')."', 
          '".re('dakika_uzar')."', 
          '".re('uyari_notu')."', 
          '".re('sigorta_aciklamasi')."', 
          '".re('park_ucreti')."', 
          '".re('sigorta_dosya_masrafi')."', 
          '".re('minumum_artis')."', 
          '".re('teklif_uyari_sesi')."', 
          '".re('sigorta_dakika')."', 
          '".re('sure_altinda_teklif_verilirse')."', 
          '".re('bu_mesaji_alsin')."', 
          '".re('vip_uye_arac')."', 
          '".re('vip_detay_gorebilir')."', 
          '".re('gold_uye_arac')."', 
          '".re('gold_detay_gorebilir')."', 
          '".re('teklif_onay')."', 
          '".re('onaylama_mesaji')."', 
          '".re('teklif_ayni_ise_sure')."', 
          '".re('sure_eklensin')."', 
          '".re('ihale_tipi')."', 
          '".re('vitrin')."')
          ");
    }
        
?>




