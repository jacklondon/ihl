 <?php
	include "ayar.php";    
	$action=re("q");
	if($action == "vekaletname_word"){
		$doc_body ="
					<h1 style='text-align:center'>VEKALETNAME</h1>
					<p style='text-indent:30px;'>
					
				";
		$id=re("id");		
		$uye_id=re("uye_id");		
		$sorgu2=mysql_query("select * from user where id='".$uye_id."' ");
		$row2=mysql_fetch_object($sorgu2);
		$uye_adi=$row2->ad;
		//$uye_adi="Asdasd ŞİÖÇĞSD";
		$tc_kimlik=$row2->tc_kimlik;
		//$tc_kimlik=$row2->tc_kimlik;
		$sorgu = mysql_query("SELECT * FROM pdf_detay where id='".$id."'  ");
		$row=mysql_fetch_object($sorgu);
		$word=$row->vekaletname_detay;
		$parcala=explode(" ",$word);

		
		for($i=0;$i<count($parcala);$i++){
			if($parcala[$i]=="%1%"){
				$parcala[$i]=$uye_adi;
			} 
			if($parcala[$i]=="%2%"){
				$parcala[$i]=$tc_kimlik;
			} 
			if($parcala[$i]=="%p%"){
				$doc_body.='</p><p style="text-indent:30px;"> ' ;
			} else if($i==count($parcala)-1){
				$doc_body.=$parcala[$i]." "." </p>";
			}
			
			else{
				$doc_body.=$parcala[$i]." ";
				
			}
		}

		echo "<!DOCTYPE html>";
		echo "<html lang='tr' >";
		echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8'/>";
		echo "$doc_body";
		echo "</html>";      
		header("Content-Type: application/vnd.msword");
		header("Expires: 0");//no-cache
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");//no-cache
		header("content-disposition: attachment;filename=".$uye_adi."_vekaletname.doc");
	}   
	if($action == "vekaletname_word_olustur"){
		$doc_body ="
					<h1 style='text-align:center'>VEKALETNAME</h1>
					<p style='text-indent:30px;'>
					
				";
		$id=re("id");		
		$sorgu = mysql_query("SELECT * FROM pdf_detay where id='".$id."'  ");
		$row=mysql_fetch_object($sorgu);
		$word=$row->vekaletname_detay;
		$parcala=explode(" ",$word);

		
		for($i=0;$i<count($parcala);$i++){

			if($parcala[$i]=="%p%"){
				$doc_body.='</p><p style="text-indent:30px;"> ' ;
			} else if($i==count($parcala)-1){
				$doc_body.=$parcala[$i]." "." </p>";
			}
			
			else{
				$doc_body.=$parcala[$i]." ";
				
			}
		}

		echo "<!DOCTYPE html>";
		echo "<html lang='tr' >";
		echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8'/>";
		echo "$doc_body";
		echo "</html>";      
		header("Content-Type: application/vnd.msword");
		header("Expires: 0");//no-cache
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");//no-cache
		header("content-disposition: attachment;filename=ornek_vekaletname.doc");
	}      	
	 
?> 