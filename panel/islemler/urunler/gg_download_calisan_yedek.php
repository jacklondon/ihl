<?php
include 'araclar/gittigidiyor/client.php'; 
include "araclar/gittigidiyor/ggFunctions.php";

$client = new ggClient();

	mysql_query("delete from gitti_gidiyor_specs where urun_id in (select productId from gitti_gidiyor_urunler where kid=".$_SESSION["kid"].")");
	mysql_query("delete from gitti_gidiyor_cargo_details where urun_id in (select productId from gitti_gidiyor_urunler where kid=".$_SESSION["kid"].")");
	mysql_query("delete from gitti_gidiyor_photos where urun_id in (select productId from gitti_gidiyor_urunler where kid=".$_SESSION["kid"].")");
	mysql_query("delete from gitti_gidiyor_urunler where kid=".$_SESSION["kid"]."");

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
			

			
			$productIds = "";
			$i=1;
			foreach($products->product as $prd)
			{
				$productIds .= "$i) ".$prd->productId."<br>";

				
				
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
				if($insertProduct==1){
					
					

					// fotoğrafların eklendiği bölüm 
					
					
					$resimSayisi = count($prd->product->photos->photo);
					
						$insertPhotoQuery = "INSERT INTO `gitti_gidiyor_photos` (`id`, `urun_id`, `url`, `photoId`) VALUES";
						
						if($resimSayisi>1){
							for($photoSay=0;$photoSay<$resimSayisi;$photoSay++){
								
								$insertPhotoQuery .= "(
															NULL, 
															'".$prd->productId."', 
															'".$prd->product->photos->photo[$photoSay]->url."', 
															'".$prd->product->photos->photo[$photoSay]->photoId."'
														),";				
							}
							$insertPhotoQuery = rtrim($insertPhotoQuery,",");
						}
						else{
							$insertPhotoQuery .= "(
									NULL, 
									'".$prd->productId."', 
									'".$prd->product->photos->photo->url."', 
									'".$prd->product->photos->photo->photoId."'
								)";
						}	
							
						
						
					
					
					$pht = mysql_query($insertPhotoQuery);
					
					// spec lerin eklendiği bölüm 
					
					$specSayisi = count($prd->product->specs->spec);
					
					$insertSpecQuery = "INSERT INTO `gitti_gidiyor_specs` (`id`, `urun_id`, `name`, `value`, `required`) VALUES";
					
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
					
					$insertCargoDetailsQuery = "INSERT INTO `gitti_gidiyor_cargo_details` (`id`, `urun_id`, `city`, `cargoCompany`, `cargoCompanyDetail`) VALUES";
					
						
						$insertCargoDetailsQuery .= "(
													NULL, 
													'".$prd->productId."', 
													'".$prd->product->cargoDetail->city."', 
													'".$prd->product->cargoDetail->cargoCompanyDetails->cargoCompanyDetail->name."',
													'".$prd->product->cargoDetail->cargoCompanyDetails->cargoCompanyDetail->value."'
												)";				
				
					
					$cargo = mysql_query($insertCargoDetailsQuery);	 	

				
					
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
				
				
							
				}

			}
			
			$urunSay -= 100;
			$islemsay++;
	
		}while($urunSay>0);
	
	}
	
?>