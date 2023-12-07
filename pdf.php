<?php
	

	require('fpdf17/fpdf.php');
	require_once 'fpdi/fpdi.php';
	include 'ayar.php';
	function turkce($k)
    {
        // return iconv('utf-8','iso-8859-9',$k);
        // return iconv('utf-8', 'ISO-8859-9', html_entity_decode($k));
        return iconv('utf-8', 'ISO-8859-9', html_entity_decode(strip_tags($k),ENT_QUOTES));
    }

	// $pdf->AddFont('arial','','arial.php'); 
	// $pdf->SetFont('Arial','',14);
	// $turkce_icerik = iconv('utf-8', 'ISO-8859-9', 'ŞüİĞ gibi harfleri artık kullanabiliriz');


	$action=re("q");
	if($action == "pdf"){
		$teklif_id=re("teklif_id");
		$ihale_id=re("ihale_id");
		
		$teklif = mysql_query("SELECT * FROM teklifler WHERE ilan_id ='".$ihale_id."' and id='".$teklif_id."' ");
		$sorgu = mysql_query("SELECT * FROM ilan_komisyon WHERE ilan_id ='".$ihale_id."'");
		$cek=mysql_fetch_object($sorgu);
		$hizmet_bedeli=$cek->toplam;
		$sorgu2 = mysql_query("SELECT * FROM ilanlar WHERE id ='".$ihale_id."'");
		$cek2=mysql_fetch_object($sorgu2);
		
		$arac_kodu=$cek2->arac_kodu;
		$plaka=$cek2->plaka;
		
		while($offer = mysql_fetch_array($teklif)){
			/*$query = mysql_query("SELECT * FROM `cayma_bedelleri` WHERE uye_id='".$offer["uye_id"]."' ORDER BY NET DESC LIMIT 1 ");*/
			/*$row=mysql_fetch_object($query);*/
			$query2 = mysql_query("SELECT * FROM `user` WHERE id='".$offer["uye_id"]."' ");
			$row2=mysql_fetch_object($query2);
			/*$cayma_bedeli=$row->net;*/
			$tc=$row2->tc_kimlik;
			$telefon=$row2->telefon;
			if(empty($row2->kurumsal_user_token)){
				$uye_ismi=$row2->ad;
			}else{
				$uye_ismi=$row2->unvan;
			}
			$teklif_date=$offer['teklif_zamani'];
			$teklif_zamani=date('d-m-Y H:i:s', strtotime($teklif_date));
			$ip=$offer["ip"];
			$tarayici=$offer["tarayici"];
			$isletim_sistemi=$offer["isletim_sistemi"];
			$verilen_teklif=money($offer["teklif"]);
			if($cek2->pd_hizmet=="" || $cek2->pd_hizmet==0){
				$hizmet_bedeli=$offer["hizmet_bedeli"];
			}else{
				$hizmet_bedeli=$cek2->pd_hizmet;
			}
		}


		$pdf=new FPDF ();
		$pdf->AddFont('arial_tr','','arial_tr.php');
		$pdf->AddFont('arial_tr','B','arial_tr_bold.php');
		$pdf->AddPage();
		$pdf->SetFont('Arial_tr','',18);
		$pdf->Image('images/sistem/pdf_logo.png',85,10,-100);
		$pdf->Ln(25);
		$pdf->cell(10);
		$pdf->write(10,turkce($uye_ismi));
		$pdf->cell(2);
		$pdf->write(10,turkce("TEKLİF DETAYLARIDIR"));
		$pdf->SetFont('Arial_tr','',11);
		$pdf->Ln(10);
		$pdf->cell(10);
		$pdf->write(10,turkce('ARAÇ KODU    :'));
		$pdf->cell(5);
		$pdf->write(10,turkce($arac_kodu));
		$pdf->Ln(10);
		$pdf->cell(10);
		$pdf->write(10,turkce('PLAKA   :'));
		$pdf->cell(5);
		$pdf->write(10,turkce($plaka));
		$pdf->Ln(10);
		$pdf->cell(10);
		$pdf->write(10,turkce('VERİLEN TEKLİF    :'));
		$pdf->cell(5);
		$pdf->write(10,turkce($verilen_teklif)." TL");
		$pdf->Ln(10);
		$pdf->cell(10);
		$pdf->write(10,turkce('TEKLİF ZAMANI    :'));
		$pdf->cell(5);
		$pdf->write(10,turkce($teklif_zamani));
		$pdf->Ln(10);
		$pdf->cell(10);
		$pdf->write(10,turkce('İP ADRESİ    :'));
		$pdf->cell(5);
		$pdf->write(10,turkce($ip));
		$pdf->Ln(10);
		$pdf->cell(10);
		$pdf->write(10,turkce('KULLANILAN İŞLETİM SİSTEMİ    :'));
		$pdf->cell(5);
		$pdf->write(10,turkce($isletim_sistemi));
		$pdf->Ln(10);	
		$pdf->cell(10);
		$pdf->write(10,turkce('KULLANILAN TARAYICI    :'));
		$pdf->cell(5);
		$pdf->write(10,turkce($tarayici));
		$pdf->Ln(10);
		$pdf->cell(10);
		$pdf->write(10,turkce('TC KİMLİK   :'));
		$pdf->cell(5);
		$pdf->write(10,turkce($tc));
		$pdf->Ln(10);
		$pdf->cell(10);
		$pdf->write(10,turkce('TELEFON   :'));
		$pdf->cell(5);
		$pdf->write(10,turkce($telefon));
		$pdf->Output();
	}
	if($action=="kullanim_sartlari_pdf"){
		$uye_id=re("uye_id");
		$sorgu=mysql_query("select * from user where id='".$uye_id."' ");
		$row=mysql_fetch_object($sorgu);
		$uye_adi=$row->ad;
		$tc_kimlik=$row->tc_kimlik;
		$sorgu2=mysql_query("select * from pdf");
		$row2=mysql_fetch_object($sorgu2);
		$kullanim_sartlari=$row2->kullanim_sartlari;
		$pdf = new Fpdi();
		$pages_count = $pdf->setSourceFile($kullanim_sartlari); 
		for($i = 1; $i <= $pages_count; $i++)
		{
			$pdf->AddPage(); 
			if($i==1){
					$pdf->AddFont('arial_tr','','arial_tr.php');
					$pdf->AddFont('arial_tr','B','arial_tr_bold.php');
					$pdf->SetFont('arial_tr','',10);
					$pdf->Ln(0);
					$pdf->cell(15);
					$pdf->write(10,turkce('TC Kimlik   :'));
					$pdf->cell(5);
					$pdf->write(10,turkce($tc_kimlik));
					$pdf->Ln(5);
					$pdf->cell(15);
					$pdf->write(10,turkce('Ad Soyad   :'));
					$pdf->cell(5);
					$pdf->write(10,turkce($uye_adi));
			}
			$tplIdx = $pdf->importPage($i);
			$pdf->useTemplate($tplIdx, 0, 0); 
		}
		//$pdf->Output("deneme.pdf", 'I');
		$pdf->Output();
	}
	if($action == "uyelik_pdf_olustur"){
		$id=re("id");		
		$sorgu = mysql_query("SELECT * FROM pdf_detay WHERE id ='".$id."' ");
		$row=mysql_fetch_object($sorgu);
		$pdf=$row->uyelik_detay;
		$parcala=explode(" ",$pdf);

		$pdf=new FPDF();
		$pdf->AddFont('arial_tr','','arial_tr.php');
		$pdf->AddFont('arial_tr','B','arial_tr_bold.php');
		$pdf->AddPage();
		$pdf->SetFont('Arial_tr','',18);
		$pdf->Ln(5);
		$pdf->cell(65);
		$pdf->write(10,turkce("ÜYELİK SÖZLEŞMESİ"));
		$pdf->Ln(5);
		$pdf->SetFont('Arial_tr','',11);
		for($i=0;$i<count($parcala);$i++){
			
				if($parcala[$i]=="%1%"){
					$parcala[$i]="Ad Soyad";
				} 
				if($parcala[$i]=="%2%"){
					$parcala[$i]="1111111111111";
				} 
				
			
			if($parcala[$i]=="%p%"){
				$pdf->Ln(10);
				$pdf->cell(10);
			} else{
				$yazi=$parcala[$i];
				$pdf->write(10,turkce(" ".$yazi." "));
			}
		}
		
		//$pdf->Output("deneme.pdf", 'd');
		$pdf->Output();
	}	
	if($action == "k_uyelik_pdf_olustur"){
		$id=re("id");		
		$sorgu = mysql_query("SELECT * FROM pdf_detay WHERE id ='".$id."' ");
		$row=mysql_fetch_object($sorgu);
		$pdf=$row->kurumsal_uyelik_detay;
		$parcala=explode(" ",$pdf);

		$pdf=new FPDF();
		$pdf->AddFont('arial_tr','','arial_tr.php');
		$pdf->AddFont('arial_tr','B','arial_tr_bold.php');
		$pdf->AddPage();
		$pdf->SetFont('Arial_tr','',18);
		$pdf->Ln(5);
		$pdf->cell(65);
		$pdf->write(10,turkce("ÜYELİK SÖZLEŞMESİ"));
		$pdf->Ln(5);
		$pdf->SetFont('Arial_tr','',11);
		for($i=0;$i<count($parcala);$i++){
			
				if($parcala[$i]=="%1%"){
					$parcala[$i]="Firma Adı";
				} 
				if($parcala[$i]=="%2%"){
					$parcala[$i]="Vergi Dairesi";
				} 
				if($parcala[$i]=="%3%"){
					$parcala[$i]="1111123123";
				}
				/*
				if($parcala[$i]=="%8%"){
					$parcala[$i] = "";
					$pdf->Ln(10);
				}
				*/ 
				
				
				//Yeni sayfaya geçirir
				if($parcala[$i]=="%6%"){
					$parcala[$i]="";
					$pdf->addPage();
				}
				
							
			if($parcala[$i]=="%p%"){
				$pdf->Ln(10);
				$pdf->cell(10);
			} else{
				$yazi=$parcala[$i];
				 $pdf->write(10,turkce(" ".$yazi." "));
			
			}
		}
		
		//$pdf->Output("deneme.pdf", 'd');
		$pdf->Output();
	}	
	if($action == "vekaletname_pdf_olustur"){
		$id=re("id");		
		$sorgu = mysql_query("SELECT * FROM pdf_detay WHERE id ='".$id."' ");
		$row=mysql_fetch_object($sorgu);
		$pdf=$row->vekaletname_detay;
		$parcala=explode(" ",$pdf);

		$pdf=new FPDF();
		$pdf->AddFont('arial_tr','','arial_tr.php');
		$pdf->AddFont('arial_tr','B','arial_tr_bold.php');
		$pdf->AddPage();
		$pdf->SetFont('Arial_tr','',18);
		$pdf->Ln(5);
		$pdf->cell(65);
		$pdf->write(10,turkce("VEKALETNAME"));
		$pdf->Ln(5);
		$pdf->SetFont('Arial_tr','',11);
		for($i=0;$i<count($parcala);$i++){
			
				if($parcala[$i]=="%1%"){
					$parcala[$i]="Ad Soyad";
				} 
				if($parcala[$i]=="%2%"){
					$parcala[$i]="1111111111111";
				} 
			
			if($parcala[$i]=="%p%"){
				$pdf->Ln(10);
				$pdf->cell(10);
			} else{
				$yazi=$parcala[$i];
				$pdf->write(10,turkce(" ".$yazi." "));
			}
		}
		
		//$pdf->Output("deneme.pdf", 'd');
		$pdf->Output();
	}
	if($action == "uyelik_pdf"){
		$id=re("id");		
		$uye_id=re("uye_id");		
		$sorgu2=mysql_query("select * from user where id='".$uye_id."' ");
		$row2=mysql_fetch_object($sorgu2);
		$uye_adi=$row2->ad;
		$tc_kimlik=$row2->tc_kimlik;
		$sorgu = mysql_query("SELECT * FROM pdf_detay WHERE id ='".$id."' ");
		$row=mysql_fetch_object($sorgu);
		$pdf=$row->uyelik_detay;
		$parcala=explode(" ",$pdf);
		if($uye_oku['tc_kimlik']=="" || $uye_oku['mail']==""  || $uye_oku['telefon']=="" || $uye_oku['sehir']==""|| $uye_oku['ad']=="" || $uye_oku['cinsiyet']==""  || $uye_oku['kargo_adresi']=="" ){
			//echo "<script>window.location.href = 'uye_panel/profili_duzenle.php';</script>";                
		}
		
		$pdf=new FPDF();
		$pdf->AddFont('arial_tr','','arial_tr.php');
		$pdf->AddFont('arial_tr','B','arial_tr_bold.php');
		$pdf->AddPage();
		$pdf->SetFont('Arial_tr','',18);
		$pdf->Ln(5);
		$pdf->cell(65);
		$pdf->write(10,turkce("ÜYELİK SÖZLEŞMESİ"));
		$pdf->Ln(5);
		$pdf->SetFont('Arial_tr','',9);
		for($i=0;$i<count($parcala);$i++){
			if($parcala[$i]=="%1%"){
				$parcala[$i]=$uye_adi;
			} 
			if($parcala[$i]=="%2%"){
				$parcala[$i]=$tc_kimlik;
			} 
			if($parcala[$i]=="%p%"){
				$pdf->Ln(10);
				$pdf->cell(10);
			} else{
				$yazi=$parcala[$i];
				$pdf->write(10,turkce(" ".$yazi." "));
			}
		}
		
		//$pdf->Output("deneme.pdf", 'd');
		$pdf->Output();
	}	
	if($action == "k_uyelik_pdf"){
		$id=re("id");		
		$uye_id=re("uye_id");		
		$sorgu2=mysql_query("select * from user where id='".$uye_id."' ");
		$row2=mysql_fetch_object($sorgu2);
		$uye_adi=$row2->ad;
		$vergi_dairesi=$row2->vergi_dairesi;
		$vergi_no=$row2->vergi_dairesi_no;
		
		$sorgu = mysql_query("SELECT * FROM pdf_detay WHERE id ='".$id."' ");
		$row=mysql_fetch_object($sorgu);
		$pdf=$row->kurumsal_uyelik_detay;
		$parcala=explode(" ",$pdf);
		/*
		if($uye_oku['tc_kimlik']=="" || $uye_oku['mail']==""  || $uye_oku['telefon']=="" || $uye_oku['sehir']==""|| $uye_oku['unvan']=="" || $uye_oku['ad']=="" || $uye_oku['vergi_dairesi']=="" || $uye_oku['vergi_dairesi_no']=="" || $uye_oku['cinsiyet']==""  || $uye_oku['kargo_adresi']=="" ){
			echo "<script>window.location.href = 'kurumsal_panel/profili_duzenle.php';</script>";                
		}
		*/
		$pdf=new FPDF();
		$pdf->AddFont('arial_tr','','arial_tr.php');
		$pdf->AddFont('arial_tr','B','arial_tr_bold.php');
		$pdf->AddPage();
		$pdf->SetFont('Arial_tr','',18);
		$pdf->Ln(5);
		$pdf->cell(65);
		$pdf->write(10,turkce("ÜYELİK SÖZLEŞMESİ"));
		$pdf->Ln(5);
		$pdf->SetFont('Arial_tr','',9);
		for($i=0;$i<count($parcala);$i++){
			if($parcala[$i]=="%1%"){
				$parcala[$i]=$uye_adi." ";
			} 
			if($parcala[$i]=="%2%"){
				$parcala[$i]=$vergi_dairesi;
			} 
			if($parcala[$i]=="%3%"){
				$parcala[$i]=$vergi_no;
			} 
			if($parcala[$i]=="%p%"){
				$pdf->Ln(10);
				$pdf->cell(10);
			} else{
				$yazi=$parcala[$i];
				$pdf->write(10,turkce(" ".$yazi." "));
			}
		}
		
		//$pdf->Output("deneme.pdf", 'd');
		$pdf->Output();
	}	
	if($action == "vekaletname_pdf"){
		$id=re("id");		
		$uye_id=re("uye_id");		
		$sorgu2=mysql_query("select * from user where id='".$uye_id."' ");
		$row2=mysql_fetch_object($sorgu2);
		$uye_adi=$row2->ad;
		$tc_kimlik=$row2->tc_kimlik;
		$sorgu = mysql_query("SELECT * FROM pdf_detay WHERE id ='".$id."' ");
		$row=mysql_fetch_object($sorgu);
		$pdf=$row->vekaletname_detay;
		$parcala=explode(" ",$pdf);

		$pdf=new FPDF();
		$pdf->AddFont('arial_tr','','arial_tr.php');
		$pdf->AddFont('arial_tr','B','arial_tr_bold.php');
		$pdf->AddPage();
		$pdf->SetFont('Arial_tr','',18);
		$pdf->Ln(5);
		$pdf->cell(65);
		$pdf->write(10,turkce("VEKALETNAME"));
		$pdf->Ln(5);
		$pdf->SetFont('Arial_tr','',11);
		for($i=0;$i<count($parcala);$i++){
			if($parcala[$i]=="%1%"){
				$parcala[$i]=$uye_adi;
			} 
			if($parcala[$i]=="%2%"){
				$parcala[$i]=$tc_kimlik;
			} 
			if($parcala[$i]=="%p%"){
				$pdf->Ln(10);
				$pdf->cell(10);
			} else{
				$yazi=$parcala[$i];
				$pdf->write(10,turkce(" ".$yazi." "));
			}
		}
		
		//$pdf->Output("deneme.pdf", 'd');
		$pdf->Output();
	}
		if($action == "uyelik_pdf_mobil"){
		$id=re("id");		
		$uye_id=re("uye_id");		
		$sorgu2=mysql_query("select * from user where id='".$uye_id."' ");
		$row2=mysql_fetch_object($sorgu2);
		$uye_adi=$row2->ad;
		$tc_kimlik=$row2->tc_kimlik;
		$sorgu = mysql_query("SELECT * FROM pdf_detay WHERE id ='".$id."' ");
		$row=mysql_fetch_object($sorgu);
		$pdf=$row->uyelik_detay;
		$parcala=explode(" ",$pdf);

		$pdf=new FPDF();
		$pdf->AddFont('arial_tr','','arial_tr.php');
		$pdf->AddFont('arial_tr','B','arial_tr_bold.php');
		$pdf->AddPage();
		$pdf->SetFont('Arial_tr','',18);
		$pdf->Ln(5);
		$pdf->cell(65);
		$pdf->write(10,turkce("ÜYELİK SÖZLEŞMESİ"));
		$pdf->Ln(5);
		$pdf->SetFont('Arial_tr','',11);
		for($i=0;$i<count($parcala);$i++){
			if($parcala[$i]=="%1%"){
				$parcala[$i]=$uye_adi;
			} 
			if($parcala[$i]=="%2%"){
				$parcala[$i]=$tc_kimlik;
			} 
			if($parcala[$i]=="%p%"){
				$pdf->Ln(10);
				$pdf->cell(10);
			} else{
				$yazi=$parcala[$i];
				$pdf->write(10,turkce(" ".$yazi." "));
			}
		}
		
		$pdf->Output("deneme.pdf", 'd');
		//$pdf->Output();
	}	
	if($action == "k_uyelik_pdf_mobil"){
		$id=re("id");		
		$uye_id=re("uye_id");		
		$sorgu2=mysql_query("select * from user where id='".$uye_id."' ");
		$row2=mysql_fetch_object($sorgu2);
		$uye_adi=$row2->ad;
		$vergi_dairesi=$row2->vergi_dairesi;
		$vergi_no=$row2->vergi_dairesi_no;
		
		$sorgu = mysql_query("SELECT * FROM pdf_detay WHERE id ='".$id."' ");
		$row=mysql_fetch_object($sorgu);
		$pdf=$row->kurumsal_uyelik_detay;
		$parcala=explode(" ",$pdf);

		$pdf=new FPDF();
		$pdf->AddFont('arial_tr','','arial_tr.php');
		$pdf->AddFont('arial_tr','B','arial_tr_bold.php');
		$pdf->AddPage();
		$pdf->SetFont('Arial_tr','',18);
		$pdf->Ln(5);
		$pdf->cell(65);
		$pdf->write(10,turkce("ÜYELİK SÖZLEŞMESİ"));
		$pdf->Ln(5);
		$pdf->SetFont('Arial_tr','',11);
		for($i=0;$i<count($parcala);$i++){
			if($parcala[$i]=="%1%"){
				$parcala[$i]=$uye_adi." ";
			} 
			if($parcala[$i]=="%2%"){
				$parcala[$i]=$vergi_dairesi;
			} 
			if($parcala[$i]=="%3%"){
				$parcala[$i]=$vergi_dairesi_no;
			} 
			if($parcala[$i]=="%p%"){
				$pdf->Ln(10);
				$pdf->cell(10);
			} else{
				$yazi=$parcala[$i];
				$pdf->write(10,turkce(" ".$yazi));
			}
		}
		
		$pdf->Output("deneme.pdf", 'd');
		//$pdf->Output();
	}	
	if($action == "vekaletname_pdf_mobil"){
		$id=re("id");		
		$uye_id=re("uye_id");		
		$sorgu2=mysql_query("select * from user where id='".$uye_id."' ");
		$row2=mysql_fetch_object($sorgu2);
		$uye_adi=$row2->ad;
		$tc_kimlik=$row2->tc_kimlik;
		$sorgu = mysql_query("SELECT * FROM pdf_detay WHERE id ='".$id."' ");
		$row=mysql_fetch_object($sorgu);
		$pdf=$row->vekaletname_detay;
		$parcala=explode(" ",$pdf);

		$pdf=new FPDF();
		$pdf->AddFont('arial_tr','','arial_tr.php');
		$pdf->AddFont('arial_tr','B','arial_tr_bold.php');
		$pdf->AddPage();
		$pdf->SetFont('Arial_tr','',18);
		$pdf->Ln(5);
		$pdf->cell(65);
		$pdf->write(10,turkce("VEKALETNAME"));
		$pdf->Ln(5);
		$pdf->SetFont('Arial_tr','',11);
		for($i=0;$i<count($parcala);$i++){
			if($parcala[$i]=="%1%"){
				$parcala[$i]=$uye_adi;
			} 
			if($parcala[$i]=="%2%"){
				$parcala[$i]=$tc_kimlik;
			} 
			if($parcala[$i]=="%p%"){
				$pdf->Ln(10);
				$pdf->cell(10);
			} else{
				$yazi=$parcala[$i];
				$pdf->write(10,turkce(" ".$yazi." "));
			}
		}
		
		$pdf->Output("deneme.pdf", 'd');
		//$pdf->Output();
	}
	if($action == "odeme_bildirimi_pdf"){
		/* $id=re("id");		
		$uye_id=re("uye_id");		
		$sorgu2=mysql_query("select * from user where id='".$uye_id."' ");
		$row2=mysql_fetch_object($sorgu2);
		$uye_adi=$row2->ad;
		$tc_kimlik=$row2->tc_kimlik;
		$sorgu = mysql_query("SELECT * FROM pdf_detay WHERE id ='".$id."' ");
		$row=mysql_fetch_object($sorgu);
		$pdf=$row->vekaletname_detay;
		$parcala=explode(" ",$pdf); */

		$pdf=new FPDF();
		$pdf->AddPage();
		$pdf->setSourceFile($filename); 
		$tplIdx = $pdf->importPage(1); 
		
		
		//$pdf->Output("deneme.pdf", 'd');
		$pdf->Output();
	}
	
 ?>