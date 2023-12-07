<?php 

// Ürün Kartı Arkplan Rengi rgb Formatına Çevriliyor (opaklık İçin)
$urun_arkaplan_r=hexdec(substr(re('urun_arkaplan'), 1, 2));
$urun_arkaplan_g=hexdec(substr(re('urun_arkaplan'), 3, 2));
$urun_arkaplan_b=hexdec(substr(re('urun_arkaplan'), 5, 2));
$urun_arkaplan_a='0.'.re('urun_arkaplan_opacity');

// Menü Üst Arkplan Rengi rgb Formatına Çevriliyor (opaklık İçin)
$menu_ust_renk_r=hexdec(substr(re('menu_ust_renk'), 1, 2));
$menu_ust_renk_g=hexdec(substr(re('menu_ust_renk'), 3, 2));
$menu_ust_renk_b=hexdec(substr(re('menu_ust_renk'), 5, 2));
$menu_ust_renk_a='0.'.re('menu_ust_renk_opacity');

// Menü Şeridi Arkplan Rengi rgb Formatına Çevriliyor (opaklık İçin)
$menu_renk_r=hexdec(substr(re('menu_renk'), 1, 2));
$menu_renk_g=hexdec(substr(re('menu_renk'), 3, 2));
$menu_renk_b=hexdec(substr(re('menu_renk'), 5, 2));
$menu_renk_a='0.'.re('menu_renk_opacity');

// Menü Şeridi Arkplan Rengi rgb Formatına Çevriliyor (opaklık İçin)
$slider_alt_1_r=hexdec(substr(re('slider_alt_1'), 1, 2));
$slider_alt_1_g=hexdec(substr(re('slider_alt_1'), 3, 2));
$slider_alt_1_b=hexdec(substr(re('slider_alt_1'), 5, 2));
$slider_alt_1_a='0.'.re('slider_alt_1_opacity');

// Menü Şeridi Arkplan Rengi rgb Formatına Çevriliyor (opaklık İçin)
$slider_alt_2_r=hexdec(substr(re('slider_alt_2'), 1, 2));
$slider_alt_2_g=hexdec(substr(re('slider_alt_2'), 3, 2));
$slider_alt_2_b=hexdec(substr(re('slider_alt_2'), 5, 2));
$slider_alt_2_a='0.'.re('slider_alt_2_opacity');

// Menü Şeridi Arkplan Rengi rgb Formatına Çevriliyor (opaklık İçin)
$footer_line_r=hexdec(substr(re('footer_line'), 1, 2));
$footer_line_g=hexdec(substr(re('footer_line'), 3, 2));
$footer_line_b=hexdec(substr(re('footer_line'), 5, 2));
$footer_line_a='0.'.re('footer_line_opacity');

// Menü Şeridi Arkplan Rengi rgb Formatına Çevriliyor (opaklık İçin)
$footer_arkaplan_renk_r=hexdec(substr(re('footer_arkaplan_renk'), 1, 2));
$footer_arkaplan_renk_g=hexdec(substr(re('footer_arkaplan_renk'), 3, 2));
$footer_arkaplan_renk_b=hexdec(substr(re('footer_arkaplan_renk'), 5, 2));
$footer_arkaplan_renk_a='0.'.re('footer_arkaplan_renk_opacity');



	if(re('tanimlari') == "Kaydet")
	{
	
	$resim_input="slider_alt_kutu1_resim:376,251:gif,png,jpg,jpeg,pjpeg|slider_alt_kutu2_resim:376,251:gif,png,jpg,jpeg,pjpeg|slider_alt_kutu3_resim:376,251:gif,png,jpg,jpeg,pjpeg|slider_alt_kutu4_resim:376,251:gif,png,jpg,jpeg,pjpeg|site_favicon:50,50:gif,png,jpg,jpeg,pjpeg|site_logo:179,43:gif,png,jpg,jpeg,pjpeg|site_logo_seffaf:179,43:gif,png,jpg,jpeg,pjpeg|site_arkaplan:1500,700:gif,png,jpg,jpeg,pjpeg|footer_arkaplan:1500,700:gif,png,jpg,jpeg,pjpeg|gorusleriniz_arkaplan:1200,1000:gif,png,jpg,jpeg,pjpeg|profil_resim_1:128,128:gif,png,jpg,jpeg,pjpeg|profil_resim_2:128,128:gif,png,jpg,jpeg,pjpeg|profil_resim_3:128,128:gif,png,jpg,jpeg,pjpeg|kutu_1_ust:1500,500:gif,png,jpg,jpeg,pjpeg|kutu_2_ust:1500,500:gif,png,jpg,jpeg,pjpeg|kutu_3_ust:1500,500:gif,png,jpg,jpeg,pjpeg|kutu_4_ust:1500,500:gif,png,jpg,jpeg,pjpeg";
	$resim_input_ayir=explode('|',$resim_input);
	$updateler_satir='';
	foreach ($resim_input_ayir as $inputlar)
	{
		$input_bol=explode(':',$inputlar);
		$gen_yuk=explode(',',$input_bol[1]);
		$uzanti_bol=explode(',',$input_bol[2]);
		if ( $_FILES[$input_bol[0].'_resim']['name'] != "" )
		{
			$yeni_ad='../images/'.$_FILES[$input_bol[0].'_resim']['name'];
			$imageFileType = $_FILES[$input_bol[0].'_resim']['type'];
			$uz_bol=explode('/',$imageFileType);
			
			
			if ( move_uploaded_file($_FILES[$input_bol[0].'_resim']['tmp_name'],$yeni_ad) )
			{
				$klasor='';
				$adi=$yeni_ad;
				$tipi=$imageFileType;
				$genislik=$gen_yuk[0];
				$yukseklik=$gen_yuk[1];
				$yeniisim=$yeni_ad;
				
				if($imageFileType=='image/jpg')
				{
					$kayitli_isim=resimYukle($klasor,$adi,$tipi,$genislik,$yukseklik,$yeniisim);
				}
				
				$updateler_satir.=$input_bol[0]."='".$_FILES[$input_bol[0].'_resim']['name']."',";
				
			}
			
		}
	}

		mysql_query("UPDATE site_tasarim SET 
site_title='".re('site_title')."',
tamamlama_eki='".re('tamamlama_eki')."',
site_on_isim='".re('site_on_isim')."',
site_konu='".re('site_konu')."',
site_anahtar_kelime='".re('site_anahtar_kelime')."',
site_kisa_isim='".re('site_kisa_isim')."',
site_telefon='".re('site_telefon')."',
logo_durum='".re('logo_durum')."',
slider_alt_kutular_durum='".re('slider_alt_kutular_durum')."',
site_face='".re('site_face')."',
site_twitter='".re('site_twitter')."',
site_instagram='".re('site_instagram')."',
site_hakkinda_bilgisi='".re('site_hakkinda_bilgisi')."',
site_color_border='".re('site_color_border')."',
ana_sayfa_basliklar='".re('ana_sayfa_basliklar')."',
ana_sayfa_baslik_sektor='".re('ana_sayfa_baslik_sektor')."',
buton_siparis='".re('buton_siparis')."',
e_ticaret='".re('e_ticaret')."',
site_arkaplan_boyut='".re('site_arkaplan_boyut')."',
site_arkaplan_2='".re('site_arkaplan_2')."',
site_arkaplan_2_boyut='".re('site_arkaplan_2_boyut')."',
site_ana_renk='".re('site_ana_renk')."',
footer_arkaplan_boyut='".re('footer_arkaplan_boyut')."',
vitrin_baslik='".re('vitrin_baslik')."',
secilen_sehir='".re('secilen_sehir')."',
slider_renk='".re('slider_renk')."',
slider_alt_kutu1='".re('slider_alt_kutu1')."',
slider_alt_kutu2='".re('slider_alt_kutu2')."',
slider_alt_kutu3='".re('slider_alt_kutu3')."',
slider_alt_kutu4='".re('slider_alt_kutu4')."',
slider_alt_kutu1_alt='".re('slider_alt_kutu1_alt')."',
slider_alt_kutu2_alt='".re('slider_alt_kutu2_alt')."',
slider_alt_kutu3_alt='".re('slider_alt_kutu3_alt')."',
slider_alt_kutu4_alt='".re('slider_alt_kutu4_alt')."',
slider_alt_kutu1_link='".re('slider_alt_kutu1_link')."',
slider_alt_kutu2_link='".re('slider_alt_kutu2_link')."',
slider_alt_kutu3_link='".re('slider_alt_kutu3_link')."',
slider_alt_kutu4_link='".re('slider_alt_kutu4_link')."',
buton_renk='".re('buton_renk')."',
buton_renk2='".re('buton_renk2')."',
menu_ust_renk='rgba(".$menu_ust_renk_r.",".$menu_ust_renk_g.",".$menu_ust_renk_b.",".$menu_ust_renk_a.")',
menu_renk='rgba(".$menu_renk_r.",".$menu_renk_g.",".$menu_renk_b.",".$menu_renk_a.")',
slider_alt_1='rgba(".$slider_alt_1_r.",".$slider_alt_1_g.",".$slider_alt_1_b.",".$slider_alt_1_a.")',
slider_alt_2='rgba(".$slider_alt_2_r.",".$slider_alt_2_g.",".$slider_alt_2_b.",".$slider_alt_2_a.")',
urun_arka='".re('urun_arka')."',
urun_text='".re('urun_text')."',
footer_line='rgba(".$footer_line_r.",".$footer_line_g.",".$footer_line_b.",".$footer_line_a.")',
footer_arkaplan_renk='rgba(".$footer_arkaplan_renk_r.",".$footer_arkaplan_renk_g.",".$footer_arkaplan_renk_b.",".$footer_arkaplan_renk_a.")',
footer_text='".re('footer_text')."',
urun_arkaplan='rgba(".$urun_arkaplan_r.",".$urun_arkaplan_g.",".$urun_arkaplan_b.",".$urun_arkaplan_a.")',
urun_kenarlık='".re('urun_kenarlık')."',
".$updateler_satir."
urun_text_rengi='".re('urun_text_rengi')."',
logo_boyut='".re('site_logo_boyut')."',
logo_margin='".re('site_logo_margin')."',
uyesiz='".re('uyesiz')."',
pos='".re('pos')."',
site_ssl='".re('site_ssl')."',
site_csr='".re('site_csr')."',
site_key='".re('site_key')."',
site_ip='".re('site_ipp')."',
site_crt='".re('site_crt')."',
site_rcrt='".re('site_rcrt')."'")or die(mysql_error());
	}
	
	$site_cek = mysql_query("select * from site_tasarim");
	$site_oku = mysql_fetch_assoc($site_cek);
	
	//Anasayfa Başlıklar Açık Kapalı Kontrolü
	$ana_sayfa_basliklar_true='';
	$ana_sayfa_basliklar_false='';
	if($site_oku['ana_sayfa_basliklar']=='true'){$ana_sayfa_basliklar_true='selected';}
	if($site_oku['ana_sayfa_basliklar']=='false'){$ana_sayfa_basliklar_false='selected';}
	
	//Buton Sipariş Açık Kapalı Kontrolü
	$buton_siparis_true='';
	$buton_siparis_false='';
	if($site_oku['buton_siparis']=='true'){$buton_siparis_true='selected';}
	if($site_oku['buton_siparis']=='false'){$buton_siparis_false='selected';}
	
	//E-Ticaret Açık Kapalı Kontrolü
	$e_ticaret_true='';
	$e_ticaret_false='';
	if($site_oku['e_ticaret']=='true'){$e_ticaret_true='selected';}
	if($site_oku['e_ticaret']=='false'){$e_ticaret_false='selected';}
	
	//Üyesiz Aktif Pasif Kontrolü
	$uyesiz_true='';
	$uyesiz_false='';
	if($site_oku['uyesiz']=='true'){$uyesiz_true='selected';}
	if($site_oku['uyesiz']=='false'){$uyesiz_false='selected';}
	
	//Pos Aktif Pasif Kontrolü
	$pos_true='';
	$pos_false='selected';
	if($site_oku['pos']=='1'){$pos_true='selected'; $pos_false='';}
	if($site_oku['pos']=='0'){$pos_true=''; $pos_false='selected';}
	
	//SSL Aktif Pasif Kontrolü
	$ssl_true='';
	$ssl_false='selected';
	if($site_oku['site_ssl']=='1'){$ssl_true='selected'; $ssl_false='';}
	if($site_oku['site_ssl']=='0'){$ssl_true=''; $ssl_false='selected';}
	
	
	//Şehirler Baılıp Seçili olan Şehir Kontrol Ediliyor
	$sehir_liste='';
	$sehir_sor=mysql_query("select * from sehir");
	while($sehir_oku=mysql_fetch_array($sehir_sor))
	{
		if($site_oku['secilen_sehir']==$sehir_oku['sehirID'])
		{
			$sehir_liste.='<option value="'.$sehir_oku['sehirID'].'" selected>'.$sehir_oku['sehiradiust'].'</option>';
		}
		else
		{
			$sehir_liste.='<option value="'.$sehir_oku['sehirID'].'">'.$sehir_oku['sehiradiust'].'</option>';
		}
	}
	
	//Logo Durum Kontrolü Yapılıyor
	$logo_durum_sagda='';
	$logo_durum_ortada='';
	$logo_durum_solda='';
	if($site_oku['logo_durum']=='sagda'){$logo_durum_sagda='selected';}
	if($site_oku['logo_durum']=='ortada'){$logo_durum_ortada='selected';}
	if($site_oku['logo_durum']=='solda'){$logo_durum_solda='selected';}
	
	//ürün kartı arkaplan rengi kontrolü yapılıyor
	$ayir=explode('(', $site_oku['urun_arkaplan']); 
	$ayir2=explode(')',$ayir[1]); 
	$ayir3=explode(',',$ayir2[0]);
	
	$urun_arkaplan_hex=sprintf("#%02x%02x%02x", $ayir3[0], $ayir3[1], $ayir3[2]);
	$urun_arkaplan_opacity=explode('.',$ayir3[3]);
	
	//Menü Üst arkaplan rengi kontrolü yapılıyor
	$menu_ust_ayir=explode('(', $site_oku['menu_ust_renk']); 
	$menu_ust_ayir2=explode(')',$menu_ust_ayir[1]); 
	$menu_ust_ayir3=explode(',',$menu_ust_ayir2[0]);
	
	$menu_ust_renk_hex=sprintf("#%02x%02x%02x", $menu_ust_ayir3[0], $menu_ust_ayir3[1], $menu_ust_ayir3[2]);
	$menu_ust_renk_opacity=explode('.',$menu_ust_ayir3[3]);
	
	//Menü arkaplan rengi kontrolü yapılıyor
	$menu_ayir=explode('(', $site_oku['menu_renk']); 
	$menu_ayir2=explode(')',$menu_ayir[1]); 
	$menu_ayir3=explode(',',$menu_ayir2[0]);
	
	$menu_renk_hex=sprintf("#%02x%02x%02x", $menu_ayir3[0], $menu_ayir3[1], $menu_ayir3[2]);
	$menu_renk_opacity=explode('.',$menu_ayir3[3]);
	
	//Menü arkaplan rengi kontrolü yapılıyor
	$slider_alt_1_ayir=explode('(', $site_oku['slider_alt_1']); 
	$slider_alt_1_ayir2=explode(')',$slider_alt_1_ayir[1]); 
	$slider_alt_1_ayir3=explode(',',$slider_alt_1_ayir2[0]);
	
	$slider_alt_1_hex=sprintf("#%02x%02x%02x", $slider_alt_1_ayir3[0], $slider_alt_1_ayir3[1], $slider_alt_1_ayir3[2]);
	$slider_alt_1_opacity=explode('.',$slider_alt_1_ayir3[3]);
	
	//Menü arkaplan rengi kontrolü yapılıyor
	$slider_alt_2_ayir=explode('(', $site_oku['slider_alt_2']); 
	$slider_alt_2_ayir2=explode(')',$slider_alt_2_ayir[1]); 
	$slider_alt_2_ayir3=explode(',',$slider_alt_2_ayir2[0]);
	
	$slider_alt_2_hex=sprintf("#%02x%02x%02x", $slider_alt_2_ayir3[0], $slider_alt_2_ayir3[1], $slider_alt_2_ayir3[2]);
	$slider_alt_2_opacity=explode('.',$slider_alt_2_ayir3[3]);
	
	//Menü arkaplan rengi kontrolü yapılıyor
	$footer_line_ayir=explode('(', $site_oku['footer_line']); 
	$footer_line_ayir2=explode(')',$footer_line_ayir[1]); 
	$footer_line_ayir3=explode(',',$footer_line_ayir2[0]);
	
	$footer_line_hex=sprintf("#%02x%02x%02x", $footer_line_ayir3[0], $footer_line_ayir3[1], $footer_line_ayir3[2]);
	$footer_line_opacity=explode('.',$footer_line_ayir3[3]);
	
	//Menü arkaplan rengi kontrolü yapılıyor
	$footer_arkaplan_renk_ayir=explode('(', $site_oku['footer_arkaplan_renk']); 
	$footer_arkaplan_renk_ayir2=explode(')',$footer_arkaplan_renk_ayir[1]); 
	$footer_arkaplan_renk_ayir3=explode(',',$footer_arkaplan_renk_ayir2[0]);
	
	$footer_arkaplan_renk_hex=sprintf("#%02x%02x%02x", $footer_arkaplan_renk_ayir3[0], $footer_arkaplan_renk_ayir3[1], $footer_arkaplan_renk_ayir3[2]);
	$footer_arkaplan_renk_opacity=explode('.',$footer_arkaplan_renk_ayir3[3]);
	
	/* Ek ücrete tabi özellikler html leri */
	$ucretlileri_sor=mysql_query("select * from site_tasarim_ucretliler");
	while ($ucretlileri_cek=mysql_fetch_assoc($ucretlileri_sor))
	{
		$tut=$ucretlileri_cek['ozellik'];
		if ( $ucretlileri_cek['durum'] == 1 )
		{
			${'ucretli_'.$tut}=1;
		}
		else
		{
			${'ucretli_'.$tut}=0;
		}
	
	}
	
	if ( $ucretli_uyeliksiz_satis == 1 )
	{
		$uyeliksiz_satis_html='<div class="control-group">
					  <label class="control-label">Üyeliksiz Satışlar</label>
					  <div class="controls">
							<select class="span6 m-wrap" name="uyesiz" id="uyesiz">
								<option value="true" '.$uyesiz_true.'>Pasif</option>
								<option value="false" '.$uyesiz_false.'>Aktif</option>
							</select>
						 <span class="help-inline"><small>Sitede Üye olmadan satış yapabilmek için Kullanılır.Not:Üyesiz satışlarda, ürün takibi yapılamaz.</small></span>
					  </div>
					</div>';
	}
	else
	{
		$uyeliksiz_satis_html='<div class="control-group">
					  <label class="control-label">Üyeliksiz Satışlar</label>
					  <div class="controls">
							<span class="help-inline"><small><b>Bu özellik ek ücrete tabidir. Müşteri Hizmetleri ile görüşünüz 0850 3030800</b></small></span>
					  </div>
					</div>';
	}
	
	
	
	if ( $ucretli_kredi_pos == 1 )
	{
		$uyeliksiz_pos_html='<div class="control-group">
					  <label class="control-label">POS Modülleri</label>
					  <div class="controls">
							<select class="span6 m-wrap" name="pos" id="pos">
								<option value="1" '.$pos_true.'>Aktif</option>
								<option value="0" '.$pos_false.'>Pasif</option>
							</select>
						 <span class="help-inline"><small>Anlaşmalı olduğunuz banka veya ödeme tahsilatı kuruluşları aracılığı ile tahsilat yapmanızı sağlar.Bu ayar, Tahsilat Tipleri bölümünden kurulmalıdır.</small></span>
					  </div>
					</div>';
	}
	else
	{
		$uyeliksiz_pos_html='<div class="control-group">
					  <label class="control-label">POS Modülleri</label>
					  <div class="controls">
							<span class="help-inline"><small><b>Bu özellik ek ücrete tabidir. Müşteri Hizmetleri ile görüşünüz 0850 3030800</b></small></span>
					  </div>
					</div>';
	}
	
	if ( $ucretli_kredi_pos == 1 )
	{
		$ssl_modul_html='<div class="control-group">
					  <label class="control-label">SSL Modülü</label>
					  <div class="controls">
							<select class="span6 m-wrap" name="site_ssl" id="site_ssl">
								<option value="1" '.$ssl_true.'>Aktif</option>
								<option value="0" '.$ssl_false.'>Pasif</option>
							</select>
						 <span class="help-inline"><small>SSL Sertifikası varsa AKTİF yapıp Sertifika kurulmalıdır.</small></span>
					  </div>
					</div>';
		$ssl_modul_html.='<div class="control-group">
					  <label class="control-label">SSL Kurulumu</label>
					  <div class="controls">
							CSR<textarea name="site_csr" id="site_csr">'.$site_oku['site_csr'].'</textarea>
						 <span class="help-inline">Key<textarea name="site_key" id="site_key">'.$site_oku['site_key'].'</textarea></span>
						 <span class="help-inline">Ip<input type="text" name="site_ipp" id="site_ipp" value="'.$site_oku['site_ip'].'"/></span>
						<br />
						CRT<textarea name="site_crt" id="site_crt">'.$site_oku['site_crt'].'</textarea>
						<br />
						CRT<textarea name="site_rcrt" id="site_rcrt">'.$site_oku['site_rcrt'].'</textarea>
						<span class="help-inline">Root CRT</span>
						<br />
						 <span class="help-inline">Sertifikanıza ait CSR ve KEY ile Müşteri hizmetlerinden satın aldığınız size tahsis edilen ip adresini ilgili alanlara yazınız.</span>
						<br />
						<span class="help-inline">Sertifikanız ve IP adresiniz yok ise, satın almak için müşteri hizmetlerini 0850 3030800 arayınız.</span>
					</div>
					</div>';
	}
	else
	{
		$ssl_modul_html='<div class="control-group">
					  <label class="control-label">SSL Modülü</label>
					  <div class="controls">
							<span class="help-inline"><small><b>Bu özellik ek ücrete tabidir. Müşteri Hizmetleri ile görüşünüz 0850 3030800</b></small></span>
					  </div>
					</div>';
	}
	
?>
