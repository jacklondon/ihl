<br><b>gg_product</b><br>
<?php

		echo "<h2>ürün</h2>";
		$allProdData = $client->getProduct("286187548");  
		print_r($allProdData);
		echo "<br><br>";
		
		echo "<h2>Kategori bilgileri : 3og</h2>";
		$categoryData = $client->getCategory("3og",true);  
		print_r($categoryData);
		echo "<br><br>";		
		/*$products = $allData->products;
		
		$urunSay = $allData->productCount;*/
		
?>