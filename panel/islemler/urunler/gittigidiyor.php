<?php 

	
	
	$ggInfo = mysql_fetch_object(mysql_query("select * from gitti_gidiyor_hesaplari where kid=".$_SESSION["kid"]));
	//echo "gg count : ".mysql_num_rows($ggQuery);

//print_r($ggInfo);	
	
	//include('araclar/gittigidiyor/client.php'); 
	
include 'araclar/gittigidiyor/client.php'; 



include "araclar/gittigidiyor/ggFunctions.php";



$client = new ggClient();

	
	
	if(re('k') != "")
		$k=re('k');
	else
		$k='A';	
	
	if(re('ggdwn') != ""){
		// çoklu ürün çekme
		include("gg_download.php");
	}
	
	

	/*
	elseif(re('d') == "1"){
		// çekimiş olan ürünlerin ayrıntılarını alma
		include("gg_product.php");
	}
	*/
		
		
	 
	

	//$k=re('ggdwn');

	
	

	


	//echo "Bu Kategoride Tolam ".$allData->productCount." adet ürün bulunmakta";
	/*
	echo "<br><br>";
	echo "count 2 : ".count($products->product)."<br><br><br>";
	*/
	
	$urunler = "";
	
	/*
	$i=1;
	foreach($products->product as $prd){
		
		$resimSayisi = count($prd->product->photos->photo);
		
		//echo $i++.")<br>";
		//echo "productId : ".$prd->productId."<br>";
		//echo "Başlık : ".$prd->product->title."<br>";
		//
		//echo "name : ".$prd->product->specs->spec[1]->name."<br>";
		//echo "value : ".$prd->product->specs->spec[1]->value."<br>";
		//
		////if(isset())
		////echo "photo : ".$prd->product->photos->photo[0]->url."<br>";
		//
		//echo "resim saısı : ".count($prd->product->photos->photo)."<br>";
		//
		//echo "kalan süre : ".$prd->summary->endDate."<br>";
		//
		//echo "Şimdi al Fiyatı : ".$prd->product->buyNowPrice."<br>";
		//
		//echo "açıklama : ".$prd->product->description."<br>";
		//
		//
		//
		//echo "spec sayısı : ".count($prd->product->specs->spec)."<br>";
		//
		//
		//echo "<br>cargo dtails : <br>";
		//echo "<br>City :".$prd->product->cargoDetail->city." ||<br>";
		//echo "<br>City :".$prd->product->cargoDetail->city." ||<br>";
		//echo "<br>City :".$prd->product->cargoDetail->cargoCompanyDetails->cargoCompanyDetail->name." ||<br>";
		//echo "<br>City :".$prd->product->cargoDetail->cargoCompanyDetails->cargoCompanyDetail->value." ||<br>";
		
		
		
		
		
		
		
		
	//	print_r($prd);
	//	echo "<hr>";

			$urunler .= '<tr>
							<td>'.$i++.'</td>
							<td>'.$prd->productId.'</td>
							<td>'.$prd->product->title.'</td>
							<td>'.$prd->summary->endDate.'</td>
							<td>'.$prd->product->buyNowPrice.'</td>
							<td><small>'.$resimSayisi.'</small></td>

							<td>
								<a href="" class="btn mini green"><i class="icon-search"></i> Düzenle</a>
								<a href="" class="btn mini red"><i class="icon-trash"></i> Sil</a>
							</td>
						</tr>';

		
	}
	
	*/
	
	
	//$urunSor = mysql_query("select ggu.*,(select count(urun_id) from gitti_gidiyor_photos where urun_id=ggu.productId) resimsay from gitti_gidiyor_urunler ggu where ggu.kid='".$_SESSION["kid"]."' and ggu.listingStatus='".$k."'");
	$urunSor = mysql_query("select ggu.*, (select s_urunler_id from gitti_gidiyor_sistemal_id where gitti_gidiyor_urunler_id=ggu.productId limit 1) s_urunler_id ,(select count(productId) from gitti_gidiyor_photos where productId=ggu.productId) resimsay from gitti_gidiyor_urunler ggu where ggu.kid='".$_SESSION["kid"]."' and ggu.listingStatus='".$k."'");
	
	$say = mysql_num_rows($urunSor);
	
	if($say>0)
		for($sy=0;$sy<$say;$sy++)
		{
			$urunler .= '<tr>
							<td>'.($sy+1).'</td>
							<td>'.mysql_result($urunSor,$sy,"productId").'</td>
							<td>'.mysql_result($urunSor,$sy,"title").'</td>
							<td>'.mysql_result($urunSor,$sy,"endDate").'</td>
							<td>'.mysql_result($urunSor,$sy,"buyNowPrice").'</td>
							<td><small>'.mysql_result($urunSor,$sy,"resimsay").'</small></td>

							<td>
								<a href="?modul=urunler&sayfa=urun_ekle&urun='.mysql_result($urunSor,$sy,"s_urunler_id").'" class="btn mini green"><i class="icon-search"></i> Düzenle</a>
								<a href="" class="btn mini red"><i class="icon-trash"></i> Sil</a>
							</td>
						</tr>';			
		}
	

	
	
	

	
	//print_r($products); 
	
	
	//print_r($allData); 
	
	
	?>