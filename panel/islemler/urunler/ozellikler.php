<?php 

	if(re('islemleri') == "Tümünü Kaydet")
	{
		$sorulari_cek = mysql_query("select * from s_sorular where durum='1' and soru_tur!='1' ORDER BY e_tarihi ASC ");
		while($sorulari_oku = mysql_fetch_array($sorulari_cek))
		{
			$eklesen = '';
			$sayi = 0;
			$ozellik_bol = explode('|',$sorulari_oku['ozellik']);
			foreach($ozellik_bol as $bolunen_ozellik)
			{
				$ic_bolum = explode(':',$bolunen_ozellik);
				$sayi++;
				
				$eklenebilir = re($sorulari_oku['input'].'_deger_'.$sayi).':'.re($sorulari_oku['input'].'_aciklama_'.$sayi).'|';
				if(re($sorulari_oku['input'].'_sil_'.$sayi) == 1)
				{
					$eklenebilir = '';
				}
				$eklesen .= $eklenebilir;
				
				if($_FILES[$sorulari_oku['input'].'_kat_resim_'.$sayi]['name'] != "")
				{
					$dosya_adi=$_FILES[$sorulari_oku['input'].'_kat_resim_'.$sayi]["name"];
					$dizim=array("iz","et","se","du","yr","nk");
					$uzanti=substr($dosya_adi,-4,4);
				
					$rasgele=rand(1,1000000);
					$ad=$dizim[rand(0,5)].$rasgele.$uzanti;
					$yeni_ad="../images/ozellik/".$ad;
					move_uploaded_file($_FILES[$sorulari_oku['input'].'_kat_resim_'.$sayi]['tmp_name'],$yeni_ad);
					
					$sec_bak = mysql_query("select * from s_ozellik_detay where input='".$sorulari_oku['input']."' and deger='".re($sorulari_oku['input'].'_deger_'.$sayi)."' and durum='1' ");
					if(mysql_num_rows($sec_bak) == 0)
					{
						mysql_query("insert into s_ozellik_detay (input,deger,resim,durum) values ('".$sorulari_oku['input']."','".re($sorulari_oku['input'].'_deger_'.$sayi)."','".$ad."','1') ");
					}
					else
					{
						mysql_query("update s_ozellik_detay set resim='".$ad."' where input='".$sorulari_oku['input']."' and deger='".re($sorulari_oku['input'].'_deger_'.$sayi)."' and durum='1' ");
					}
				}
			}
			
			if(re($sorulari_oku['input'].'_yeni_deger') != "" and re($sorulari_oku['input'].'_yeni_aciklama') != "")
			{
				$eklesen .= re($sorulari_oku['input'].'_yeni_deger').':'.re($sorulari_oku['input'].'_yeni_aciklama').'|';
				
				if($_FILES[$sorulari_oku['input'].'_yeni_kat_resim']['name'] != "")
				{
					$dosya_adi=$_FILES[$sorulari_oku['input'].'_yeni_kat_resim']["name"];
					$dizim=array("iz","et","se","du","yr","nk");
					$uzanti=substr($dosya_adi,-4,4);
				
					$rasgele=rand(1,1000000);
					$ad=$dizim[rand(0,5)].$rasgele.$uzanti;
					$yeni_ad="../images/ozellik/".$ad;
					move_uploaded_file($_FILES[$sorulari_oku['input'].'_yeni_kat_resim']['tmp_name'],$yeni_ad);
					
					$sec_bak = mysql_query("select * from s_ozellik_detay where input='".$sorulari_oku['input']."' and deger='".re($sorulari_oku['input'].'_yeni_deger')."' and durum='1' ");
					if(mysql_num_rows($sec_bak) == 0)
					{
						mysql_query("insert into s_ozellik_detay (input,deger,resim,durum) values ('".$sorulari_oku['input']."','".re($sorulari_oku['input'].'_yeni_deger')."','".$ad."','1') ");
					}
					else
					{
						mysql_query("update s_ozellik_detay set resim='".$ad."' where input='".$sorulari_oku['input']."' and deger='".re($sorulari_oku['input'].'_yeni_deger')."' and durum='1' ");
					}
				}
			}
			
			$eklesen = rtrim($eklesen, '|');
			mysql_query("update s_sorular set ozellik='".$eklesen."' where input='".$sorulari_oku['input']."' and durum='1' ");
		}
	}
	
	$tablar = '';
	$icerikler = '';
	
	$soru_say = 0;
	$sorulari_cek = mysql_query("select * from s_sorular where durum='1' and soru_tur!='1' ORDER BY e_tarihi ASC ");
	while($sorulari_oku = mysql_fetch_array($sorulari_cek))
	{
		$soru_say++;
		$aktif = '';
		if($soru_say == 1)
		{
			$aktif = 'active';
		}
		$tablar .= '<li class="'.$aktif.'"><a href="#tab_3_'.$soru_say.'" data-toggle="tab">'.$sorulari_oku['soru'].'</a></li>';
		
		$ozellik_ici = '';
		$sayi = 0;
		$ozellik_bol = explode('|',$sorulari_oku['ozellik']);
		foreach($ozellik_bol as $bolunen_ozellik)
		{
			$ic_bolum = explode(':',$bolunen_ozellik);
			
			$ozelligi_cek = mysql_query("select * from s_ozellik_detay where input='".$sorulari_oku['input']."' and deger='".$ic_bolum[0]."' and durum='1' ");
			$ozelligi_oku = mysql_fetch_assoc($ozelligi_cek);
			
			$sayi++;						
			$ozellik_ici .= '<tr>
					<td>
						'.$sayi.'
					</td>
					<td>
						<input type="text" style="width:160px;" class="yeni_inputlar" name="'.$sorulari_oku['input'].'_deger_'.$sayi.'" id="'.$sorulari_oku['input'].'_deger_'.$sayi.'" value="'.$ic_bolum[0].'" />
						<div style="float:left; width:160px;"></div>
					</td>
					<td>
						<input type="text" style="width:160px;" class="yeni_inputlar" name="'.$sorulari_oku['input'].'_aciklama_'.$sayi.'" id="'.$sorulari_oku['input'].'_aciklama_'.$sayi.'" value="'.$ic_bolum[1].'" />
						<div style="float:left; width:160px;"></div>
					</td>
					<td>
						<a href="../images/ozellik/'.$ozelligi_oku['resim'].'" target="_blank" style="float:left; position:relative; margin-top:3px; margin-right:4px;"><img src="images/resim.png" /></a>
						<input type="file" name="'.$sorulari_oku['input'].'_kat_resim_'.$sayi.'" id="'.$sorulari_oku['input'].'_kat_resim_'.$sayi.'" />
					</td>
					<td>
						<label class="checkbox">
							<input type="checkbox" value="1" name="'.$sorulari_oku['input'].'_sil_'.$sayi.'" id="'.$sorulari_oku['input'].'_sil_'.$sayi.'" />
						</label>
					</td>
				</tr>';
			
			
		}
		
		$icerikler .= '<div class="tab-pane '.$aktif.'" id="tab_3_'.$soru_say.'">
						<div class="portlet box blue">
							<div class="portlet-title">
								<h4><i class="icon-cogs"></i>Özellikler</h4>
							</div>
							<div class="portlet-body">
								<table class="table table-hover">
									<thead>
										<tr>
											<th>#</th>
											<th>Değer</th>
											<th>Açıklama</th>
											<th>Resim</th>
											<th>Sil</th>
										</tr>
									</thead>
									<tbody>
										
										'.$ozellik_ici.'
										
										<tr>
											<td>
												Yeni
											</td>
											<td>
												<input type="text" placeholder="Soru Adı" style="width:160px;" class="yeni_inputlar" name="'.$sorulari_oku['input'].'_yeni_deger" id="'.$sorulari_oku['input'].'_yeni_deger" />
												<div style="float:left; width:160px;"></div>
											</td>
											<td>
												<input type="text" placeholder="Açıklama" style="width:160px;" class="yeni_inputlar" name="'.$sorulari_oku['input'].'_yeni_aciklama" id="'.$sorulari_oku['input'].'_yeni_aciklama" />
												<div style="float:left; width:160px;"></div>
											</td>
											<td>
												<input type="file" name="'.$sorulari_oku['input'].'_yeni_kat_resim" id="'.$sorulari_oku['input'].'_yeni_kat_resim" />
											</td>
											<td>
												 
											</td>
										</tr>
									</tbody>
								</table>
							</div>
							</div>
						</div>';
	}
	
?>