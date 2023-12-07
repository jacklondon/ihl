<?php
/*
include 'araclar/gittigidiyor/client.php'; 
include "araclar/gittigidiyor/ggFunctions.php";

$client = new ggClient();
*/

	mysql_query("delete from gitti_gidiyor_specs where productId in (select productId from gitti_gidiyor_urunler where kid=".$_SESSION["kid"].")");
	mysql_query("delete from gitti_gidiyor_cargo_details where productId in (select productId from gitti_gidiyor_urunler where kid=".$_SESSION["kid"].")");
	mysql_query("delete from gitti_gidiyor_photos where productId in (select productId from gitti_gidiyor_urunler where kid=".$_SESSION["kid"].")");
	mysql_query("delete from gitti_gidiyor_urunler where kid=".$_SESSION["kid"]."");
	mysql_query("delete FROM `s_urunler` WHERE `anahtar_kelime` LIKE '%gittigidiyor ürünü%'");
	mysql_query("delete FROM `s_stoklar` WHERE `urun_id` in (select id FROM `s_urunler` WHERE `anahtar_kelime` LIKE '%gittigidiyor urunu%')");
	mysql_query("delete FROM `urunler_kategoriler` WHERE `bilgi` LIKE 'GittiGidiyor Kategori'"); 

	/*
	DELETE FROM `e_ticaret_sistem`.`gitti_gidiyor_photos` WHERE  urun_id in (select productId from gitti_gidiyor_urunler where kid=4)
	*/
	
	//$products = $client->getProducts(0,100,'A',true);  
	//$allData = $client->getProducts(0,100,$k,true);


	$tumKategoriler = array("A","L","S","U");
	
	foreach($tumKategoriler as $kategori)
	{

	
		$allData = $client->getProducts(0,100,$kategori,true);  
		
		$products = $allData->products;
		
		$urunSay = $allData->productCount;
			
		$islemsay=0;
		$baslangic = 0;
		
		//echo "<h1>urunSay : ".$urunSay."</h1>";
		
		//$j=0;
	

	
		do{
			//echo "<br>üst".++$j; 
			
			
			if($islemsay>0){
				$baslangic = $islemsay * 100;
				$allData = $client->getProducts($baslangic,100,$kategori,true);  
				$products = $allData->products;			
				
			}
			
			$i=0;
			
			echo "<h2>Kategori bilgileri : 3og</h2>";
			foreach($products->product as $prd)
			{
				
				$categoryData = $client->getCategory($prd->product->categoryCode,false);  
				/*
				echo "<br>".$i.". kateogri bilgisi : <br>";
				print_r($categoryData);
				
				echo "<br>cat code : ".$prd->product->categoryCode."<br>";
				echo "<br>cat name : ".$categoryData->categories->category->categoryName."<br>";
				*/
				
				$kategori = array(
									"kodu"=>$prd->product->categoryCode,
									"tanim"=>$categoryData->categories->category->categoryName,
									"bilgi"=>"GittiGidiyor Kategori",
									"aciklama"=>$categoryData->categories->category->categoryName
								 );
								 
				urunKategoriEkle($kategori);
				
				/*
				if(isset($categoryData->categories->category->specs->spec)){
					$catSpecSayisi = count($categoryData->categories->category->specs->spec);
					
					echo "<br>cat catSpecSayisi : ".$catSpecSayisi."<br>";
				}
				else
					echo "<br><h1>SPEC YOK</h1<<br>";
				*/
				
				/*
				// getCategory ayrıntı true iken
				$catSpecSayisi = count($categoryData->categories->category->specs->spec);
				if($catSpecSayisi>1){
					echo "<br>spec name (çoklu): ".$categoryData->categories->category->specs->spec[$i]->name."<br>";
					
					if($categoryData->categories->category->specs->spec[$i]->name=="Marka")
					{
						$j=0;
						foreach($categoryData->categories->category->specs->spec[$i]->values->value as $val){
							
							echo "<br>".$j.". val : ".$val." <br>";
							$j++;
							
						}
						
					}
					
					
				}
				else{
					echo "<br>spec name (TEKLİ): ".$categoryData->categories->category->specs->spec->name."<br>";
				}
				*/
				
				
				$i++;
								
								
			
			}			

			
			$productIds = "";
			$i=1;
			foreach($products->product as $prd)
			{
				//$productIds .= "$i) ".$prd->productId."<br>";
				
				
				$resimSayisi = count($prd->product->photos->photo);
				
				
				$insertProductQuery  = "REPLACE INTO `gitti_gidiyor_urunler` ";
				$insertProductQuery .= "(`productId`,`kid`, `categoryCode`, `storeCategoryId`, `title`, `pageTemplate`, `description`, 
										`format`, `buyNowPrice`, `listingDays`, `productCount`, `catalogOption`, `soldCount`, `endDate`, `listingStatus`, `recordDate`) ";
				
				$insertProductQuery .= "VALUES (
										
										'".$prd->productId."', 
										'".$_SESSION["kid"]."', 
										'".$prd->product->categoryCode."', 
										'".$prd->product->storeCategoryId."', 
										'".tirnaklar($prd->product->title)."',
										'".$prd->product->pageTemplate."',
										'".tirnaklar($prd->product->description)."',
										'".$prd->product->format."',
										'".$prd->product->buyNowPrice."',
										'".$prd->product->listingDays."',
										'".$prd->product->productCount."',
										'".$prd->product->catalogOption."',
										'".$prd->summary->soldCount."',
										'".ggDateFormat( $prd->summary->endDate )."',
										'".$kategori."',
										'".date("Y-m-d H-i-s")."'
										);";
										

										
												
				//echo "<br>TRH : ".ggDateFormat( $prd->summary->endDate )."<br>";								
				//echo "<br>".$i.") <br>".$insertProductQuery ."<hr>";
				//echo "<br>".$i.")<hr>";
				
				$i++;
				
				$insertProduct=mysql_query($insertProductQuery);
				
				//echo "<br>insertProduct : ".$insertProduct."<br>";
				//echo "<br>count photo : ".count($prd->product->photos->photo)."<br>";   
				//print_r($prd->product->photos->photo);
				
				
				//if(mysql_query($insertProductQuery)){

				$stokResim = "";

				if($insertProduct==1){

					// fotoğrafların eklendiği bölüm 
					
					$resimSayisi = count($prd->product->photos->photo);
				
					//$insertPhotoQuery = "INSERT INTO `gitti_gidiyor_photos` (`id`, `urun_id`, `url`, `photoId`) VALUES";
					$insertPhotoQuery = "INSERT INTO `gitti_gidiyor_photos` (`id`, `productId`, `url`, `photoId`) VALUES";
					
					$insert_s_urunler_resimler= "INSERT INTO `s_urunler_resimler` (`id`, `urun_id`, `kullanici_id`, `resim`, `resim2`, `aciklama`, `e_tarihi`, `durum`) VALUES";
					
					if($resimSayisi>1){
						for($photoSay=0;$photoSay<$resimSayisi;$photoSay++){
							
							$insertPhotoQuery .= "(
														NULL, 
														'".$prd->productId."', 
														'".$prd->product->photos->photo[$photoSay]->url."', 
														'".$prd->product->photos->photo[$photoSay]->photoId."'
													),";	

							$insert_s_urunler_resimler .= "(
															  NULL,
															  '".ggSaUrunIdBul($prd->productId)."',
															  '".$_SESSION["kid"]."',
															  '".$prd->product->photos->photo[$photoSay]->url."',
															  '',
															  'gittigidiyor ürünü',
															  '".mktime()."',
															  '1'
															),";																
															
							
						}
						$stokResim = $prd->product->photos->photo[0]->url;
						
						$insertPhotoQuery = rtrim($insertPhotoQuery,",");
						$insert_s_urunler_resimler = rtrim($insert_s_urunler_resimler,",");
					}
					else{
						$insertPhotoQuery .= "(
								NULL, 
								'".$prd->productId."', 
								'".$prd->product->photos->photo->url."', 
								'".$prd->product->photos->photo->photoId."'
							)";
														
						$insert_s_urunler_resimler .= "(
														  NULL,
														  '".ggSaUrunIdBul($prd->productId)."',
														  '".$_SESSION["kid"]."',
														  '".$prd->product->photos->photo->url."',
														  '',
														  'gittigidiyor ürünü',
														  '".mktime()."',
														  '1'
														)";	
															
						$stokResim = $prd->product->photos->photo->url;
					}	
						
					
					
					$pht = mysql_query($insertPhotoQuery);
					$pht2 = mysql_query($insert_s_urunler_resimler);
					
					// spec lerin eklendiği bölüm 
					
					$specSayisi = count($prd->product->specs->spec);
					
					//$insertSpecQuery = "INSERT INTO `gitti_gidiyor_specs` (`id`, `urun_id`, `name`, `value`, `required`) VALUES";
					$insertSpecQuery = "INSERT INTO `gitti_gidiyor_specs` (`id`, `productId`, `name`, `value`, `required`) VALUES";
					
					if($specSayisi>1){
						for($specSay=0;$specSay<$specSayisi;$specSay++){
							
							$insertSpecQuery .= "(
														NULL, 
														'".$prd->productId."', 
														'".$prd->product->specs->spec[$specSay]->name."', 
														'".$prd->product->specs->spec[$specSay]->value."',
														'".$prd->product->specs->spec[$specSay]->required."'
													),";		
													
						}
						$insertSpecQuery = rtrim($insertSpecQuery,",");
					}
					else{
							$insertSpecQuery .= "(
														NULL, 
														'".$prd->productId."', 
														'".$prd->product->specs->spec->name."', 
														'".$prd->product->specs->spec->value."',
														'".$prd->product->specs->spec->required."'
													)";					
					}
					
					
					
					$spc = mysql_query($insertSpecQuery);		
					
					// cargo_details lerin eklendiği bölüm 
					
					//$insertCargoDetailsQuery = "INSERT INTO `gitti_gidiyor_cargo_details` (`id`, `urun_id`, `city`, `cargoCompany`, `cargoCompanyDetail`) VALUES";
					$insertCargoDetailsQuery = "INSERT INTO `gitti_gidiyor_cargo_details` (`id`, `productId`, `city`, `cargoCompany`, `cargoCompanyDetail`) VALUES";
					
						
						$insertCargoDetailsQuery .= "(
													NULL, 
													'".$prd->productId."', 
													'".$prd->product->cargoDetail->city."', 
													'".$prd->product->cargoDetail->cargoCompanyDetails->cargoCompanyDetail->name."',
													'".$prd->product->cargoDetail->cargoCompanyDetails->cargoCompanyDetail->value."'
												)";				
				
					
					$cargo = mysql_query($insertCargoDetailsQuery);	 	

				
					//echo "<br>insertCargoDetailsQuery : ".$insertCargoDetailsQuery;
					
					/*
					
					echo "<br>Cargo details : <br>";
					print_r($prd->product->cargoDetail);
					echo "<hr>";
					
					
					echo "<br><b>Sonuçar : </b> <br>";
					
					echo "<br>".$prd->productId." ok!<br>";
					
					if($pht)
					echo $prd->productId."<br>foto tamam <br>";
					else
						echo $prd->productId."<br><b>foto olmadı</b> <br>";


					if($spc)
					echo $prd->productId."<br>spec tamam <br>";
					else
						echo $prd->productId."<br><b>spec olmadı</b> <br>";		


					if($cargo)
					echo $prd->productId."<br>cargo tamam <br>";
					else
						echo $prd->productId."<br><b>cargo olmadı</b> <br>";
					
					*/
				
/*****************************************************************************************************/					
// Aiatemal DB Ürün Ekleme

/*
	mysql_query("insert into urunler_markalar (
	id,
	kategori,
	sira,
	tanim,
	tel_ozel,
	durum
	)values(
	null,
	'0',
	'+1',
	'm',
	'1',
	'1')")or die(mysql_error());
*/

//echo "<br>MARKA : " . ggMarkaAyikla($prd->product->specs->spec);
//ggMarkaAyikla($prd->product->specs->spec);

//echo "<br>MARKA : ".$prd->product->specs->spec[1]->value."<br>";
//echo "<br>MARKA : ".$prd->product->specs->spec->name."<br>";


	$sa_insert_query = "insert into 
		s_urunler (
			kullanici_id,
			adi,
			tarih,
			aciklama,
			e_tarihi,
			durum,
			garanti,
			kategoriler,
			k_kategoriler,
			kategori,
			marka,
			gg_kategori,
			stok,
			anahtar_kelime,
			i1,
			i2,
			i3,
			i4,
			ek_gor,
			fiyat
			) 
			values (
			'".$_SESSION['kid']."',
			'".tirnaklar($prd->product->title)."',
			'".mkcevir(date("d.m.Y"))."',
			'".tirnaklar($prd->product->description)."',
			'".mktime()."',
			'1',
			'',
			'',
			'',
			'',
			'".tirnaklar(ggMarkaAyikla($prd->product->specs->spec))."',
			'".$prd->product->categoryCode."',
			'".$prd->product->productCount."',
			'gittigidiyor ürünü',
			'',
			'',
			'',
			'',
			'',
			'".$prd->product->buyNowPrice."'
			) ";
			
			
			//echo "<p>s_urunler query : <br>".$sa_insert_query."</p>";

	
	mysql_query($sa_insert_query);
	
	$urun_id = mysql_insert_id();
	$eklebunu_1 = '';
	$eklebunu_2 = '';

	/*
	$fiyat_cek = mysql_query("select * from s_fiyat_tanim where durum='1' ORDER BY id ASC ");
	while($fiyat_oku = mysql_fetch_array($fiyat_cek))
	{
		mysql_query("update s_urunler set ".$fiyat_oku['tanim']."='".re('fiyat_'.$fiyat_oku['id'])."', ".$fiyat_oku['tanim2']."='".re('doviz_'.$fiyat_oku['id'])."' where id='".$urun_id."' ");
	}
	*/
	
	// GG ürün ID si ile sistemal ürün ID sinin bağlandığı tablo
	mysql_query("replace into gitti_gidiyor_sistemal_id (s_urunler_id,gitti_gidiyor_urunler_id) values('".$urun_id."','".$prd->productId."')");
	
	mysql_query("replace into s_stoklar (id,urun_id,ek_oz_id,stok,resim,e_tarihi,g_tarihi,durum) 
	values(NULL,'".$urun_id."','1','".$prd->product->productCount."','".$stokResim."','".mktime()."','','1')");
	


/*****************************************************************************************************/					
							
				}

			}
			
			$urunSay -= 100;
			$islemsay++;
	
		}while($urunSay>0);
	
	}
	
?>