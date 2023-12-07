<?php 
include('../../../ayar.php');
$gelen_id = re('id');

if($gelen_id)
{
    $output .= '';
    // $teklif = mysql_query("SELECT * FROM teklifler WHERE ilan_id ='".$gelen_id."' and durum=1 ORDER BY teklif DESC LIMIT 0,10 ");
    // $teklif = mysql_query("SELECT * FROM teklifler WHERE ilan_id ='".$gelen_id."' and durum <> 0 ORDER BY teklif DESC LIMIT 0,10 ");
    $teklif = mysql_query("SELECT * FROM teklifler WHERE ilan_id ='".$gelen_id."' and durum <> 0 ORDER BY teklif_zamani DESC LIMIT 0,10 ");
	mysql_query("update teklifler set is_admin_see = 1 where ilan_id = '".$gelen_id."'");
	$toplam_teklif=mysql_num_rows($teklif);
	if($toplam_teklif < 10){ $toplam_teklif=10; } 
	$sorgu2 = mysql_query("SELECT * FROM ilanlar WHERE id ='".$gelen_id."'");
	$cek2=mysql_fetch_object($sorgu2);
	$ilan_son_teklif=$cek2->son_teklif;
    $sorgu = mysql_query("SELECT * FROM ilan_komisyon WHERE ilan_id ='".$gelen_id."'");
	$cek=mysql_fetch_object($sorgu);
	if($cek2->ihale_turu==1){
		$output .='<style>
		.pagination {
			display: -webkit-box;
			display: -ms-flexbox;
			display: flex;
			padding-left: 0;
			list-style: none;
			border-radius: 0.25rem;
		}
		.page-link {
			position: relative;
			display: block;
			padding: 0.5rem 0.75rem;
			margin-left: -1px;
			line-height: 1.25;
			color: #007bff;
			background-color: #fff;
			border: 1px solid #dee2e6;
		}
		.disabled {
		  color: currentColor;
		  cursor: not-allowed;
		  opacity: 0.5;
		  text-decoration: none;
		}
      </style>';
		 $output .= '<div id="table">
        <table class="table table-bordered">
        <thead>
            <tr>
				<th>Teklif Zamanı</th>
				<th>Üye Grubu / Cayma Bedeli</th>
				<th>Üye İsmi</th>
				<th>Onaylı GSM No</th>
				<th>Teklif</th>
				<th>Hizmet Bedeli</th>
				<th>Detaylar</th>
				<th>Sil</th>
			</tr>
        </thead>'; 
		$output .= '<tbody> ';
		while($offer = mysql_fetch_array($teklif)){
			$query = mysql_query("SELECT * FROM `cayma_bedelleri` WHERE uye_id='".$offer["uye_id"]."' ORDER BY NET DESC LIMIT 1 ");
			$row=mysql_fetch_object($query);
			/*$cayma_bedeli=$row->net;*/
			/*$toplam_aktif = mysql_query('SELECT SUM(net) AS net FROM cayma_bedelleri WHERE uye_id = "'.$offer["uye_id"].'" and durum=1'); 
			$toplam_getir = mysql_fetch_assoc($toplam_aktif); 
			$toplam_cayma = $toplam_getir['net'];
			$toplam_borc = mysql_query('SELECT SUM(net) AS net FROM cayma_bedelleri WHERE uye_id = "'.$offer["uye_id"].'" and durum=2'); 
			$toplam_borc_getir = mysql_fetch_assoc($toplam_borc); 
			$toplam_borc_cayma = $toplam_getir['net'];
			$cayma_bedeli=$toplam_cayma+toplam_borc_cayma;*/
			
			$aktif_cayma_toplam=mysql_query("SELECT SUM(tutar) as toplam_aktif_cayma FROM cayma_bedelleri WHERE uye_id='".$offer['uye_id']."' AND durum=1");
			$toplam_aktif_cayma=mysql_fetch_assoc($aktif_cayma_toplam);
			$iade_talepleri_toplam=mysql_query("SELECT SUM(tutar) as toplam_iade_talepleri FROM cayma_bedelleri WHERE uye_id='".$offer['uye_id']."' AND durum=2");
			$toplam_iade_talepleri=mysql_fetch_assoc($iade_talepleri_toplam);
			$borclar_toplam=mysql_query("SELECT SUM(tutar) as toplam_borclar FROM cayma_bedelleri WHERE uye_id='".$offer['uye_id']."' AND durum=6");
			$toplam_borclar=mysql_fetch_assoc($borclar_toplam);
			$cayma_bedeli=$toplam_aktif_cayma["toplam_aktif_cayma"]-$toplam_iade_talepleri["toplam_iade_talepleri"]-$toplam_borclar["toplam_borclar"];
			$query2 = mysql_query("SELECT * FROM `user` WHERE id='".$offer["uye_id"]."' ");
			$row2=mysql_fetch_object($query2);
			$uye_grubu_id=$row2->paket;
			$sorgu3=mysql_query("select * from uye_grubu where id='".$uye_grubu_id."'");
			$row3=mysql_fetch_object($sorgu3);
			$uye_grubu=$row3->grup_adi;
			$telefon=$row2->telefon;
			if($cek2->pd_hizmet=="" || $cek2->pd_hizmet==0){
				$hizmet_bedeli=$offer["hizmet_bedeli"];
			}else{
				$hizmet_bedeli=$cek2->pd_hizmet;
			}
			if($row2->kurumsal_user_token == ""){
				$uye_ismi=$row2->ad;
			}else{
				//$uye_ismi=$row2->unvan."/".$row2->ad;
				$uye_ismi=$row2->unvan;
			}
			$admin_adi='';
			if($offer["admin_teklif"]=="1"){
				$teklif_admin=mysql_query("select * from kullanicilar where id='".$offer["admin_id"]."'");
				$teklif_admin_oku=mysql_fetch_object($teklif_admin);
				$admin_adi=' ('.$teklif_admin_oku->adi.' '.$teklif_admin_oku->soyadi.')';
				$uye_isim=$admin_adi.' --> '.$uye_ismi;
			}else{
				$admin_adi='';
				$uye_isim=$uye_ismi;
			}
			$teklif_date=$offer['teklif_zamani'];
			$teklif_zamani=date('d-m-Y H:i:s', strtotime($teklif_date));
			if($offer["durum"] == "2"){
				$onayla_btn = '<p id="onay_bekleyen_teklif_'.$offer["id"].'"><a style="color:red" onclick="teklifi_onayla('.$offer["id"].')">Onayla</a></p>';
			}else{
				$onayla_btn = "";
			}
			// <td><a href="https://ihale.pertdunyasi.com/pdf.php?teklif_id='.$offer["id"].'&ihale_id='.$gelen_id.'&q=pdf" target="_blank" >PDF</a></td>
			$output .= '<tr id="teklif_id'.$offer["id"].'" >
				<td>'.date("d-m-Y H:i:s", strtotime($teklif_zamani)) .'</td>
				<td>'.$uye_grubu."/".$cayma_bedeli.'</td>
				<td>'.$uye_isim.'</td>
				<td><a href="?modul=uyeler&sayfa=sms_gonder&id='.$offer["uye_id"].'" target="_blank" >'.$telefon.'</a></td>
				<td style="font-size:18px;font-weight:bold;" >'.money($offer["teklif"]).'₺ '.$onayla_btn.'</td>
				<td>'.money($hizmet_bedeli).'₺</td>
				<td><a href="https://ihale.pertdunyasi.com/custom_pdf.php?teklif_id='.$offer["id"].'&ihale_id='.$gelen_id.'&q=pdf" target="_blank" >PDF</a></td>
				<td><a href="#" onclick="teklif_sil('.$offer["id"].')" >Sil</a></td>
			</tr>';
		} 
		$output .='</tbody>
		</table>'; 
		$sayi1=0;
		$sayi3=$sayi1-10;
	//	if($sayi3 <= 0){ $yaz1="disabled"; } else{ $yaz1="" ; }
		$sayi5=$sayi1+10;
	//	if($sayi5 >= $toplam_teklif){ $yaz="disabled"; } else{ $yaz="" ; }
		if($toplam_teklif % 10 == 0)
		{ 
			$sayi7=$toplam_teklif-10; 
		}
		else{
			$sonuc=$toplam_teklif % 10;
			$sayi7=$toplam_teklif-$sonuc;
		}
		$output .='<nav aria-label="Page navigation example">
				<ul class="pagination justify-content-end">
				   <li class="page-item">
					  <a class="page-link" onclick="sayfalandir('.$sayi1.','.$gelen_id.')" aria-disabled="true">İlk</a>
				   </li>
				   <li class="page-item '.$yaz1.' " >
					  <a class="page-link" onclick="sayfalandir('.$sayi3.','.$gelen_id.')"  >Önceki</a>
				   </li>
				   <li class="page-item '.$yaz.' " >
					  <a class="page-link" onclick="sayfalandir('.$sayi5.','.$gelen_id.')" >Sonraki</a>
				   </li>
				   <li class="page-item" >
					  <a class="page-link" onclick="sayfalandir('.$sayi7.','.$gelen_id.')" >Son</a>
				   </li>
				</ul>
			 </nav>
			 </div>';
		$output .='<script>
					function sayfalandir(sayi1,ilan_id){
						jQuery.ajax({
							url: "https://ihale.pertdunyasi.com/check.php",
							type: "POST",
							dataType: "JSON",
							data: {
								action: "modal_sayfalandır",
								limit1: sayi1,
								ilan_id: ilan_id,
							},
							success: function(response) {
								console.log(response);
								if(response.teklif_sayisi!=0){
									$("#table").html("");
									$("#table").html(response.data);
								}
							}
						});
					}
				</script>
				<script>
					function teklif_sil(id){
						var a=confirm("Teklifi silmek istediğinize emin misiniz?");
						if(a){
							jQuery.ajax({
								url: "https://ihale.pertdunyasi.com/check.php",
								type: "POST",
								dataType: "JSON",
								data: {
									action: "panel_teklif_sil",
									teklif_id: id,
								},
								success: function(response) {
									console.log(response);
									if(response.status==200){
										$("#teklif_id"+id).remove();
										alert(response.message);
										//location.reload();
										
									}
								}
							});
						}
					}
				</script>
				<script>
				function teklifi_onayla(id){
					jQuery.ajax({
						url: "https://ihale.pertdunyasi.com/check.php",
						type: "POST",
						dataType: "JSON",
						data: {
							action: "panel_teklif_onayla",
							teklif_id: id,
						},
						success: function(response) {		
							alert(response.message);				
							if(response.status==200){
								$("#onay_bekleyen_teklif_"+id).remove();
							}
						}
					});
				}
				</script>';
		echo $output;
		
	}else if($cek2->ihale_turu==2){
		
		$output .='<style>
			.pagination {
			display: -webkit-box;
			display: -ms-flexbox;
			display: flex;
			padding-left: 0;
			list-style: none;
			border-radius: 0.25rem;
		}.page-link {
			position: relative;
			display: block;
			padding: 0.5rem 0.75rem;
			margin-left: -1px;
			line-height: 1.25;
			color: #007bff;
			background-color: #fff;
			border: 1px solid #dee2e6;
		}
		.disabled {
		  color: currentColor;
		  cursor: not-allowed;
		  opacity: 0.5;
		  text-decoration: none;
		}
      </style>
		';
		 $output .= '<div id="table">
        <table class="table table-bordered">
        <thead>
            <tr>
				<th> </th>
				<th>Teklif Zamanı</th>
				<th>Üye Grubu / Cayma Bedeli</th>
				<th>Üye İsmi</th>
				<th>Onaylı GSM No</th>
				<th>Teklif</th>
				<th>Hizmet Bedeli</th>
				<th>Detaylar</th>
				<th>Sil</th>
			</tr>
        </thead>'; 
		$output .= '<tbody> ';
		//$teklif2= mysql_query("SELECT id,ilan_id,uye_id,teklif_zamani, MAX(teklif) as teklif FROM teklifler where ilan_id='".$gelen_id."' and durum=1 GROUP BY uye_id order by teklif desc ");
		
		$teklif_array=array();
		$t_cek=mysql_query("SELECT * FROM teklifler where ilan_id='".$gelen_id."' and durum=1 GROUP BY uye_id order by teklif desc ");
		while($t_oku=mysql_fetch_array($t_cek)){
			$teklif_max=mysql_query("select * from teklifler where ilan_id='".$gelen_id."' and uye_id='".$t_oku["uye_id"]."' and durum=1 order by teklif_zamani desc limit 1 ");
			while($teklif_max_cek=mysql_fetch_array($teklif_max)){
				array_push($teklif_array,$teklif_max_cek["teklif"]);
			}
		}

		$en_yuksek=max($teklif_array);
		
		//$teklif2= mysql_query("SELECT * FROM teklifler where ilan_id='".$gelen_id."' and durum=1 GROUP BY uye_id order by teklif desc ");
		$teklif2= mysql_query("SELECT * FROM teklifler WHERE ilan_id ='".$gelen_id."' and durum = 1 group by uye_id ORDER BY teklif_zamani DESC ");
		// var_dump("SELECT * FROM teklifler WHERE ilan_id ='".$gelen_id."' and durum = 1 group by uye_id ORDER BY teklif_zamani DESC ");
		while($offer = mysql_fetch_array($teklif2)){
			// $teklifler=mysql_query("select * from teklifler where ilan_id='".$gelen_id."' and uye_id='".$offer["uye_id"]."' and durum=1 order by teklif_zamani desc limit 1 ");
			$teklifler=mysql_query("select * from teklifler where ilan_id='".$gelen_id."' and uye_id='".$offer["uye_id"]."' and durum=1 order by teklif_zamani desc limit 1 ");
			while($teklifler_cek=mysql_fetch_array($teklifler)){

				$query = mysql_query("SELECT * FROM `cayma_bedelleri` WHERE uye_id='".$teklifler_cek["uye_id"]."' ORDER BY NET DESC LIMIT 1 ");
					
				$row=mysql_fetch_object($query);
				//$cayma_bedeli=$row->net;
							
				$toplam_aktif = mysql_query('SELECT SUM(tutar) AS net FROM cayma_bedelleri WHERE uye_id = "'.$offer["uye_id"].'" and durum=1'); 
				$toplam_getir = mysql_fetch_assoc($toplam_aktif); 
				$toplam_cayma = $toplam_getir['net'];
					  
				$toplam_borc = mysql_query('SELECT SUM(tutar) AS net FROM cayma_bedelleri WHERE uye_id = "'.$offer["uye_id"].'" and durum=2'); 
				$toplam_borc_getir = mysql_fetch_assoc($toplam_borc); 
				$toplam_borc_cayma = $toplam_getir['net'];
				$cayma_bedeli=$toplam_cayma+$toplam_borc_cayma;
			
				$query2 = mysql_query("SELECT * FROM `user` WHERE id='".$teklifler_cek["uye_id"]."' ");
				$row2=mysql_fetch_object($query2);
				
				$uye_grubu_id=$row2->paket;
					
				$sorgu3=mysql_query("select * from uye_grubu where id='".$uye_grubu_id."'");
				
				$row3=mysql_fetch_object($sorgu3);
				$uye_grubu=$row3->grup_adi;
				$telefon=$row2->telefon;

				if($cek2->pd_hizmet=="" || $cek2->pd_hizmet==0){
					$hizmet_bedeli=$teklifler_cek["hizmet_bedeli"];
				}else{
					$hizmet_bedeli=$cek2->pd_hizmet;
				}
				if($row2->kurumsal_user_token == ""){
					$uye_ismi=$row2->ad;
				}else{
					$uye_ismi=$row2->unvan;
				}
				$teklif_date=$teklifler_cek['teklif_zamani'];
				$teklif_zamani=date('d-m-Y H:i:s', strtotime($teklif_date));
				if($teklifler_cek["teklif"] != $en_yuksek){
					// <td><a href="https://ihale.pertdunyasi.com/pdf.php?teklif_id='.$teklifler_cek["id"].'&ihale_id='.$gelen_id.'&q=pdf" target="_blank" >PDF</a></td>
					$output .= '
						<tr id="teklif_id'.$teklifler_cek["id"].'" >
							<td>
								<button style="background-color:#ff00a5;" type="button" onclick="detay('.$teklifler_cek["uye_id"].','.$teklifler_cek["ilan_id"].')" class="btn btn-danger" ">
								+
								</button>
							</td>
							<td>'.$teklif_zamani.'</td>
							<td>'.$uye_grubu."/".money($cayma_bedeli).' ₺</td>
							<td>'.$uye_ismi.'</td>
							<td><a href="?modul=uyeler&sayfa=sms_gonder&id='.$teklifler_cek["uye_id"].'" target="_blank" >'.$telefon.'</a></td>
							<td style="font-size:18px;font-weight:bold;" >'.money($teklifler_cek["teklif"]).'₺</td>
							<td>'.money($hizmet_bedeli).'₺</td>
							<td><a href="https://ihale.pertdunyasi.com/custom_pdf.php?teklif_id='.$teklifler_cek["id"].'&ihale_id='.$gelen_id.'&q=pdf" target="_blank" >PDF</a></td>
							<td><a href="#" onclick="teklif_sil('.$teklifler_cek["id"].')" >Sil</a></td>
						</tr>';
				}else{
					// <td><a href="https://ihale.pertdunyasi.com/pdf.php?teklif_id='.$teklifler_cek["id"].'&ihale_id='.$gelen_id.'&q=pdf" target="_blank" >PDF</a></td>
					$output .= '
						<tr id="teklif_id'.$teklifler_cek["id"].'" style=" background-color: rgb(255,255,0);">
							<td>
								<button style="background-color:#ff00a5;" type="button" onclick="detay('.$teklifler_cek["uye_id"].','.$teklifler_cek["ilan_id"].')" class="btn btn-danger" ">
								+
								</button>
							</td>
							<td>'.$teklif_zamani.'</td>
							<td>'.$uye_grubu."/".money($cayma_bedeli).' ₺</td>
							<td>'.$uye_ismi.'</td>
							<td><a href="?modul=uyeler&sayfa=sms_gonder&id='.$teklifler_cek["uye_id"].'" target="_blank" >'.$telefon.'</a></td>
							<td style="font-size:18px;font-weight:bold;" >'.money($teklifler_cek["teklif"]).'₺</td>
							<td>'.money($hizmet_bedeli).'₺</td>
							<td><a href="https://ihale.pertdunyasi.com/custom_pdf.php?teklif_id='.$teklifler_cek["id"].'&ihale_id='.$gelen_id.'&q=pdf" target="_blank" >PDF</a></td>
							<td><a href="#" onclick="teklif_sil('.$teklifler_cek["id"].')" >Sil</a></td>
						</tr>';
				}
			}
			$output.='<tr id="b'.$offer["uye_id"].'" ></tr>' ;
		} 
		$output .='
		</tbody>
		</table>'; 
		$output .='
				<script>
					function detay(uye_id,ilan_id){
						jQuery.ajax({
							url: "https://ihale.pertdunyasi.com/check.php",
							type: "POST",
							dataType: "JSON",
							data: {
								action: "detay",
								uye_id: uye_id,
								ilan_id: ilan_id,
							},
							success: function(response) {
								console.log(response);
								if($("#b"+uye_id).html()==""){
									$("#b"+uye_id).html(response.data);
								}else{
									$("#b"+uye_id).html("");
								}
							}
						});
					}
				</script>
				<script>
					function teklif_sil(id){
						var a=confirm("Teklifi silmek istediğinize emin misiniz?");
						if(a){
							jQuery.ajax({
								url: "https://ihale.pertdunyasi.com/check.php",
								type: "POST",
								dataType: "JSON",
								data: {
									action: "panel_teklif_sil",
									teklif_id: id,
								},
								success: function(response) {
									console.log(response);
									if(response.status==200){
										$("#teklif_id"+id).remove();
										alert("İşlem başarılı");
										//location.reload();
									}
								}
							});
						}
					}
				</script>';
	/*	$sayi1=0;
		$sayi3=$sayi1-10;
	//	if($sayi3 <= 0){ $yaz1="disabled"; } else{ $yaz1="" ; }
		$sayi5=$sayi1+10;
	//	if($sayi5 >= $toplam_teklif){ $yaz="disabled"; } else{ $yaz="" ; }
			
		if($toplam_teklif % 10 == 0)
		{ 
			$sayi7=$toplam_teklif-10; 
					
		}
		else{
			$sonuc=$toplam_teklif % 10;
			$sayi7=$toplam_teklif-$sonuc;
		}
		$output .='<nav aria-label="Page navigation example">
					<ul class="pagination justify-content-end">
						<li class="page-item">
							<a class="page-link" onclick="sayfalandir2('.$sayi1.','.$gelen_id.')" aria-disabled="true">İlk</a>
						</li>
						<li class="page-item '.$yaz1.' " >
							<a class="page-link" onclick="sayfalandir2('.$sayi3.','.$gelen_id.')"  >Önceki</a>
						</li>
						<li class="page-item '.$yaz.' " >
							<a class="page-link" onclick="sayfalandir2('.$sayi5.','.$gelen_id.')" >Sonraki</a>
						</li>
						<li class="page-item" >
							<a class="page-link" onclick="sayfalandir2('.$sayi7.','.$gelen_id.')" >Son</a>
						</li>
					</ul>
				</nav>
			</div>
		';
		$output .='<script>
					function sayfalandir2(sayi1,ilan_id){
						jQuery.ajax({
							url: "https://ihale.pertdunyasi.com/check.php",
							type: "POST",
							dataType: "JSON",
							data: {
								action: "modal_sayfalandır2",
								limit1: sayi1,
								ilan_id: ilan_id,
							},
							success: function(response) {
								console.log(response);
								if(response.teklif_sayisi!=0){
									$("#table").html("");
									$("#table").html(response.data);
								}
							}
						});
					}
				</script>
		';*/
		echo $output;
	}
  
}

?>



