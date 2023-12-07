<!-- <?php 
$ggInfo = mysql_fetch_object(mysql_query("select * from gitti_gidiyor_hesaplari where kid=".$_SESSION["kid"]));
	include 'araclar/gittigidiyor/client.php'; 
	include "araclar/gittigidiyor/ggFunctions.php";
	$client = new ggClient();

	if(re('islem') == "katal")
	{
		//echo "<br><h1>gelen : katal</h1>";
		
		//$categorySpecs = $client->getCategorySpecs();  
		$categorySpecs = $client->getCategories(1,1,true);   
		//$categorySpecs = $client->getCategory($categoryCode = null, $withSpecs = true); 

	//echo "<br><br><hr>categories :<br><br><br><hr>";
	print_r($categorySpecs);		
		
		
	}
	
	
	if(re('gg_kaydet') == "Kaydet")
	{
		echo "Bilgileriniz Güncellendi ";
		$query  = "replace into gitti_gidiyor_hesaplari (kid, gg_uname, gg_upass, gg_rname, gg_rpass, gg_akey, gg_skey, lang, is_active, record_date) ";
		$query .= "values('".$_SESSION['kid']."', '".re('gg_uname')."', '".re('gg_upass')."', '".re('gg_rname')."', '".re('gg_rpass')."', '".re('gg_akey')."', '".re('gg_skey')."', '".re('lang')."', '".re('is_active')."', '".date("Y-m-d H:i:s")."')";
		mysql_query($query);
	}
	
	$gg = mysql_query("select * from gitti_gidiyor_hesaplari where kid=".$_SESSION["kid"]);
	$gg_data = mysql_fetch_assoc($gg);
	
	
	
	
	
?> -->
