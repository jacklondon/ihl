<?php 
 $today = date("Y-m-d");
 $hour = date("H:i:s");

  
 $getUserInfo = mysql_query("SELECT 
  * 
  FROM 
  user 
  WHERE 
  kurumsal_user_token = '$uye_token' AND 
  kurumsal_user_token <> '0'
  ");
  $userInfo = mysql_fetch_object($getUserInfo);

    // $favori = mysql_query("SELECT DISTINCT ilan_id FROM favoriler WHERE user_token = '".$uye_token."'");
    // $favori = mysql_query("SELECT 
    //   f.*  
    // FROM 
    //   favoriler AS f INNER JOIN 
    //   ilanlar AS i ON 
    //     f.ilan_id = i.id
    // WHERE 
    //   f.uye_id = '$userInfo->id' 
    //   ");
    $favori = mysql_query("
    (SELECT 
      ilanlar.*,unix_timestamp(concat(ilanlar.ihale_tarihi,' ',ilanlar.ihale_saati)) as ihale_son
    from 
      ilanlar
    inner join 
      favoriler
      on
        favoriler.ilan_id=ilanlar.id and 
        favoriler.uye_id='".$userInfo->id."'
    WHERE
      ilanlar.durum='1'

    )
      UNION
    (
    SELECT 
      ilanlar.*,concat(ilanlar.ihale_tarihi,' ',ilanlar.ihale_saati) as ihale_son2
    from 
      ilanlar
    inner join 
      favoriler
      on
        favoriler.ilan_id=ilanlar.id and 
        favoriler.uye_id='".$userInfo->id."'
                      where
      ilanlar.durum!='1'

    )
    ORDER BY
      ihale_son asc
");
	$dogrudan_favori=mysql_query("SELECT 
		  f.*  
		FROM 
		  favoriler AS f INNER JOIN 
		   dogrudan_satisli_ilanlar AS d ON 
			f.dogrudan_satisli_id = d.id
		WHERE 
		  f.uye_id = '$userInfo->id' 
		  ");
      
    // $teklif = mysql_query("SELECT 
		// 				f.*  
		// 				FROM 
		// 				teklifler AS f INNER JOIN 
		// 				ilanlar AS i ON 
		// 				f.ilan_id = i.id 
		// 				WHERE 
		// 				f.durum = 1 and
		// 				f.uye_id = '$userInfo->id' 
		// 				order by ihale_tarihi asc
		// 			");
    $teklif = mysql_query("
    (SELECT 
      ilanlar.*,unix_timestamp(concat(ilanlar.ihale_tarihi,' ',ilanlar.ihale_saati)) as ihale_son
    from 
      ilanlar
    inner join 
      teklifler
      on
        teklifler.ilan_id=ilanlar.id and 
        teklifler.uye_id='".$userInfo->id."'
    WHERE
      ilanlar.durum='1'

    )
      UNION
    (
    SELECT 
      ilanlar.*,concat(ilanlar.ihale_tarihi,' ',ilanlar.ihale_saati) as ihale_son2
    from 
      ilanlar
    inner join 
      teklifler
      on
        teklifler.ilan_id=ilanlar.id and 
        teklifler.uye_id='".$userInfo->id."'
    WHERE
      ilanlar.durum!='1'

    )
    ORDER BY
      ihale_son asc
");


  $beni_cek = mysql_query("select * from user where kurumsal_user_token = '".$uye_token."'");
	$beni_oku = mysql_fetch_object($beni_cek);
	$benim_id = $beni_oku->id;

  $mesaj_oda = user_chat_rooms($benim_id);
  $mesaj_sayisi = 0;
  for($i=0;$i<count($mesaj_oda);$i++){
    $mesaj_sayisi += $mesaj_oda[$i]["unread_count"];
  }


    $mesaj = mysql_query("SELECT * FROM mesajlar WHERE durum=0 and alan_token='".$uye_token."' group by ilan_id");
    $ihalesi = mysql_query("SELECT * FROM ilanlar WHERE ihale_sahibi = '".$uye_token."'");
    $dogrudan_satislari = mysql_query("SELECT * FROM dogrudan_satisli_ilanlar WHERE ilan_sahibi = '".$uye_token."'");
    $onay_bekleyen = mysql_query("SELECT * FROM kazanilan_ilanlar WHERE durum = 0 AND uye_id = '".$userInfo->id."'");
    $odeme_bekleyen = mysql_query("SELECT * FROM kazanilan_ilanlar WHERE durum = 1 AND uye_id = '".$userInfo->id."'");
    $son_islemde = mysql_query("SELECT * FROM kazanilan_ilanlar WHERE durum = 2 AND uye_id = '".$userInfo->id."'");
    $satin_alinan = mysql_query("SELECT * FROM kazanilan_ilanlar WHERE durum = 3 AND uye_id = '".$userInfo->id."'");
    $iptal_olan = mysql_query("SELECT * FROM kazanilan_ilanlar WHERE durum = 4 AND uye_id = '".$userInfo->id."'");
    $kullanici_getir = mysql_query("SELECT * FROM `user` WHERE kurumsal_user_token = '$uye_token'");
    $ihale_cek2 = mysql_query("SELECT * FROM ilanlar WHERE ihale_acilis <= '".$today."' AND ihale_tarihi >= '".$today."' AND durum = 1");
    $dogrudan_cek2 = mysql_query("SELECT * FROM dogrudan_satisli_ilanlar WHERE durum = 1");
    $dogrudan_satis_sayisi2 = mysql_num_rows($dogrudan_cek2);
    $ihale_sayisi2 = mysql_num_rows($ihale_cek2);

    $kullanici_yaz = mysql_fetch_assoc($kullanici_getir);
    $kullaniciID = $kullanici_yaz['id'];
    //$caymalari = mysql_query("SELECT * FROM cayma_bedelleri WHERE uye_id = '".$kullaniciID."' and durum!=5");
    $caymalari = mysql_query("SELECT * FROM cayma_bedelleri WHERE uye_id = '".$kullaniciID."'");
    $uyeyi_getir = mysql_query("select * from user where kurumsal_user_token = '".$uye_token."'");
    $uyeyi_yaz = mysql_fetch_assoc($uyeyi_getir);
    $uyenin_id_biligisi = $uyeyi_yaz['id'];
    $yorumlarim = mysql_query("select * from yorumlar where uye_id = '".$uyenin_id_biligisi."' and ilan_id <> 0");
    $yorumlarim_sayisi = mysql_num_rows($yorumlarim);
    $fav_sayisi = mysql_num_rows($favori) + mysql_num_rows($dogrudan_favori) ;
	
    $dogrudan_fav_sayisi=mysql_num_rows($dogrudan_favori);
    $ihale_fav_sayisi = mysql_num_rows($favori) ;
    // $tum_yorumlar = mysql_query("select * from yorumlar");
    $tum_yorumlar = mysql_query("select yorumlar.* from yorumlar inner join ilanlar as i on i.id=yorumlar.ilan_id where yorumlar.durum = 1 or yorumlar.durum=3 order by yorumlar.yorum_zamani desc");

    $tum_yorum_sayisi = mysql_num_rows($tum_yorumlar);

    $teklif_sayisi = 0;
    while($teklif_sayi_oku = mysql_fetch_object($teklif)){
      $kazanilan_cek=mysql_query("select * from kazanilan_ilanlar where ilan_id='".$teklif_sayi_oku->id."' and uye_id='".$uyenin_id_biligisi."'");
      $kazanilan_say=mysql_num_rows($kazanilan_cek);
      if($kazanilan_say == 0){
        $teklif_sayisi += 1;
      }
    }
    // $teklif_sayisi = mysql_num_rows($teklif);


    // $mesaj_sayisi = mysql_num_rows($mesaj);
    $uye_ihale = mysql_num_rows($ihalesi);
    $dogrudaki = mysql_num_rows($dogrudan_satislari);
    $onay_bekleyen_sayisi = mysql_num_rows($onay_bekleyen);
    $odeme_bekleyen_sayisi = mysql_num_rows($odeme_bekleyen);
    $son_islemde_sayisi = mysql_num_rows($son_islemde);
    $satin_alinan_sayisi = mysql_num_rows($satin_alinan);
    $iptal_olan_sayisi = mysql_num_rows($iptal_olan);
    $cayma_sayisi = mysql_num_rows($caymalari)

?>