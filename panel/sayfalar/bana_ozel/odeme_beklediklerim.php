<?php 
	session_start();
	$admin_id=$_SESSION['kid'];
	$uyeleri_cek = mysql_query("SELECT * FROM user WHERE temsilci_id = '".$admin_id."'"); 
?>
<style>
   .blink {
		animation: blinker 1.8s linear infinite;
		color: red;
		font-weight: bold;
	}
	@keyframes blinker {  
		50% { opacity: 0; }
   }
   .esit{
		color: red;
		font-weight: bold;
   }
	.yok{
		color: black;
   }
   	.yan {
		animation: blinker 0.9s linear infinite;
		color: red;
		font-size: 15px;
		font-weight: bold;
		font-family: sans-serif;
	}
	@keyframes blinker {  
		50% { opacity: 0; }
	}
	.kalin_kirmizi{
		color:red;
		font-weight:bold;
	}
</style>
<style>
	table {
		border-collapse: collapse;
		border-spacing: 0;
		width: 100%;
		border: 1px solid #ddd;
   }
	th, td {
		text-align: left;
		padding: 16px;
	}
	tr:nth-child(even) {
		background-color: #f2f2f2;
   }
	i{
		padding: 8px;
	}
	a{
		color: black;
	}
	a:hover{
		color: black;
	}
</style>
<div style="overflow-x:auto; overflow-y:auto; height:400px; margin-top:2%;">
	<table class="table table-bordered"  cellspacing="1" cellpadding="1">
		<tr>
			<td>Düzenle</td>
			<td>Görseller</td>
			<td>Araç Kodu </td>
			<td>Plaka</td>
			<td>Detaylar</td>
			<td>Kazanan</td>
			<td>Kazandığı Teklif</td>
			<td>PD Hizmet Bedeli</td>
			<td>Dosya Masrafı</td>
			<td>Noter Ücreti</td>
			<td>Son Ödeme Tarihi</td>
			<td>Teklifler</td>
			<td>Favori</td>
			<td>Mesaj</td>
			<td>Notlar</td>
			<td>Açıklama</td>
			<td>Sigorta</td>
			<td>Ödeme Tutarı</td>
		</tr>
		<?php 
			$iptalleri_cek = mysql_query("SELECT kazanilan_ilanlar.* FROM kazanilan_ilanlar inner join user on user.id=kazanilan_ilanlar.uye_id where user.temsilci_id='".$admin_id."' and kazanilan_ilanlar.durum=1");
			while($iptalleri_oku = mysql_fetch_array($iptalleri_cek)){
				$toplam_ucret=$iptalleri_oku["kazanilan_teklif"]+$iptalleri_oku["dosya_masrafi"]+$iptalleri_oku["pd_hizmet"]+$iptalleri_oku["noter_takipci_gideri"];
				//$otomatik_mesaj=$iptalleri_oku["otomatik_mesaj"];
				$otomatik_mesaj = '<table>
					<thead>
						<tr>
							<th>Parça 1</th>
							<th>Parça 2</th>
							<th>Parça 3</th>
							<th>MTV</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>'.$iptalleri_oku["parca_1"].' ₺</td>
							<td>'.$iptalleri_oku["parca_2"].' ₺</td>
							<td>'.$iptalleri_oku["parca_3"].' ₺</td>
							<td>'.$iptalleri_oku["mtv"].' ₺</td>
						</tr>
					</tbody>
				</table>';
				$kazanilan_teklif=$iptalleri_oku["kazanilan_teklif"];
				$pd_hizmet=$iptalleri_oku["pd_hizmet"];
				$dosya_masrafi=$iptalleri_oku["dosya_masrafi"];
				$mtv=$iptalleri_oku["mtv"];
				
				$iptal_id = $iptalleri_oku['ilan_id'];
				$hepsini_cek = mysql_query("SELECT * FROM ilanlar WHERE id = '".$iptal_id."'");
				$hepsini_oku = mysql_fetch_array($hepsini_cek);
				
				$sigorta_cek=mysql_query("select * from sigorta_ozellikleri where id='".$hepsini_oku['sigorta']."'");
				$sigorta_oku=mysql_fetch_array($sigorta_cek);
				
				$sigorta_adi=$sigorta_oku["sigorta_adi"];
				$sigorta_id=$sigorta_oku["sigorta_id"];
				
				$teklif_cek = mysql_query("SELECT * FROM teklifler WHERE ilan_id = '".$hepsini_oku['id']."' and durum=1");
				$teklif_sayi = mysql_num_rows($teklif_cek);
				$mesaj_cek = mysql_query("SELECT * FROM mesajlar WHERE ilan_id = '".$hepsini_oku['id']."' and alan_id !='0'");
				$mesaj_sayi = mysql_num_rows($mesaj_cek);
				$favori_cek = mysql_query("SELECT * FROM favoriler WHERE ilan_id = '".$hepsini_oku['id']."'");
				$favori_sayi = mysql_num_rows($favori_cek);
				$not_cek = mysql_query("SELECT * FROM ilan_notlari WHERE ilan_id = '".$hepsini_oku['id']."'");
				$not_sayi = mysql_num_rows($not_cek);
				
				$islem_id = $hepsini_oku["id"];

				if($hepsini_oku["profil"]=="Hurda Belgeli"){
					$noter_ucreti="Noter devri esnasında hesaplanıcak";
				}else{
					$noter_ucreti=$iptalleri_oku["noter_takipci_gideri"];
				}

				if($iptalleri_oku["son_odeme_tarihi"]==date("Y-m-d")){
					$son_odeme_class="kalin_kirmizi ";
				}
				else if($iptalleri_oku["son_odeme_tarihi"]<date("Y-m-d")){
					$son_odeme_class="yan ";
				}else{
					$son_odeme_class="";
				}
				
				if($hepsini_oku["ihale_tarihi"] < date("Y-m-d")){
					$class="blink";   
				}elseif($hepsini_oku["ihale_tarihi"] == date("Y-m-d")){ 
					$class="esit";
				}elseif($hepsini_oku["ihale_tarihi"] > date("Y-m-d")){
					$class="yok";
				}
				
				if(	date("d-m-Y",strtotime($iptalleri_oku["son_odeme_tarihi"]))=="30-11--0001" ){
					$son_odeme="";
				}else{
					$son_odeme=	date("d-m-Y",strtotime($iptalleri_oku["son_odeme_tarihi"]));
				}
			?>
		<tr>
			<?php 
				$marka_cek = mysql_query("SELECT * FROM marka WHERE markaID = '".$hepsini_oku['marka']."' LIMIT 1");
				$marka_oku = mysql_fetch_assoc($marka_cek);
				$marka_adi = $marka_oku['marka_adi'];
				$kazanan_kisi_cek = mysql_query("SELECT * FROM user WHERE id = '".$iptalleri_oku['uye_id']."' LIMIT 1"); ?>
				<td><a target="_blank" href="?modul=ilanlar&sayfa=ilan_ekle&id=<?= $islem_id ?>"><i class="fas fa-edit"></i></a></td>
				<td><a target="_blank" href="?modul=ilanlar&sayfa=ilan_resim_ekle&id=<?= $islem_id ?>"><i class="far fa-image"></i></a></td>
				<td><?= $hepsini_oku["arac_kodu"] ?> </td>
				<td><?=$hepsini_oku["plaka"]?></td>
				<td><a target="_blank" href="../arac_detay.php?id=<?=$islem_id?>&q=ihale" style="text-decoration: none; color:#000000; cursor:pointer;"> 
					<?=$hepsini_oku["model_yili"]. " " .$marka_adi ." ". $hepsini_oku['model']." ". $hepsini_oku['tip'] ?></a>
				</td>
				<?php 
				while($kazanan_kisi_oku = mysql_fetch_array($kazanan_kisi_cek)){ 
					$kazanan_adi = $kazanan_kisi_oku['ad'];?>
					<td><?=$kazanan_adi?></td>
					<td><?=money($kazanilan_teklif)."₺" ?></td>
					<td><?=money($pd_hizmet)."₺" ?></td>
					<td><?=money($dosya_masrafi)."₺" ?></td>
					<td><?=money($noter_ucreti)."₺" ?></td>
					<td class="<?=$son_odeme_class  ?>" ><?=$son_odeme ?></td>
					<td><a class="view_ilan_teklifleri" id="teklifler_<?= $islem_id ?>"><i class="fas fa-gavel"><?=$teklif_sayi ?></i></a></td> 
					<td><a class="view_ilan_favorileri" id="<?= $islem_id ?>"><i class="fas fa-heart"><?=$favori_sayi ?></i></a></td>  
					<td><a class="view_ilan_mesajlari" id="<?= $islem_id ?>"><i class="fas fa-envelope"><?=$mesaj_sayi ?></i></a></td>   
					<td><a class="view_ilan_notlari" id="<?= $islem_id ?>"><i class="fas fa-align-justify"><?=$not_sayi ?></i></a></td> 
					<td><?=$iptalleri_oku["aciklama"]?></td>
					<td>
						<!-- <a target="_blank" href="?modul=ayarlar&sayfa=sigorta_sirketi_ayarlari&id=<?=$sigorta_id ?>" style=""><?=$sigorta_adi ?></a> -->
						<a target="_blank" href="<?= $hepsini_oku['link'] ?>" style=""><?=$sigorta_adi ?></a>
					</td>
					<td>
						<a data-toggle="modal" data-target="#odeme_tutari" style="cursor: pointer; text-decoration:none; color:#000000;font-weight:bold;font-size:15px;">
							<?=money($toplam_ucret)."₺" ?>
						</a>
					</td>
				<?php } ?>
			</tr>
      <?php } ?>
   </table>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="js/uyeler_modal.js?v=<? echo time();?>"></script>
<!-- Ödeme Tutarı Modal Başlangıç -->
<!-- Modal -->
<div id="odeme_tutari" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
   <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
      <center>
         <h4 id="myModalLabel">ÖDEME MESAJI</h4>
      </center>
   </div>
   <div class="modal-body">
	<?=$otomatik_mesaj ?>
   </div>
   <div class="modal-footer">
      <div class="span3"></div>
      <div class="span6">
         <button class="btn btn-block" data-dismiss="modal" aria-hidden="true">KAPAT</button>
      </div>
      <div class="span3"></div>
   </div>
</div>
<!-- Ödeme Tutarı Modal Bitiş -->

<!-- İlan Teklif-->
<div  class="custom-large-modal modal fade" id="ilan_teklif">
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
  </div>
   <div class="modal-dialog">
      <div class="modal-body" id="teklif_ilan">
      </div>
   </div>
</div>
<!-- İlan Teklif-->
<!-- İlan Fav-->
<div class="custom-large-modal modal fade" id="ilan_fav">
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
  </div>
   <div class="modal-dialog">
      <div class="modal-body" id="fav_ilan">
      </div>
   </div>
</div>
<!-- İlan Fav Bitiş-->
<!-- İlan Mesaj-->
<div style="width:75%;" class="custom-large-modal modal fade" id="ilan_mesaj">
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
  </div>
   <div class="modal-dialog">
      <div class="modal-body" id="mesaj_ilan">
      </div>
   </div>
</div>
<!-- İlan Mesaj Bitiş-->
<!-- İlan Notları Başlangıç-->
<div class="custom-large-modal modal fade" id="ilan_notlari">
	<button type="button" class="close" style="margin-right: 2%; margin-top:2%;" data-dismiss="modal" aria-hidden="true"></button>
	<div class="modal-dialog">
      <div class="modal-body" id="ilanin_notlarini">
      </div>
   </div>
</div>

<?php 
	if(re('notu') =='Kaydet'){
		$admin_id = $_SESSION['kid'];
		$eklenecek_not = re('eklenecek_not');
		$gelen_id = re('gelen_id');
		$gizlilik = re('gizlilik');
		$tarih = date('Y-m-d H:i:s');
		if(isset($_FILES['files'])){     // dosya tanımlanmıs mı? 
			$errors= array(); 
			foreach($_FILES['files']['tmp_name'] as $key => $tmp_name ){ 
				$dosya_adi =$_FILES['files']['name'][$key]; 		// uzantiya beraber dosya adi 
				$dosya_boyutu =$_FILES['files']['size'][$key];    		// byte cinsinden dosya boyutu 
				$dosya_gecici =$_FILES['files']['tmp_name'][$key];		//gecici dosya adresi 
				$yenisim=md5(microtime()).$dosya_adi; 					//karmasik yeni isim.pdf 
				if($dosya_boyutu > 20971520){ 
					$errors[]='Maksimum 20 Mb lık dosya yuklenebilir.'; 
				}		                     
				$klasor="../assets"; // yuklenecek dosyalar icin yeni klasor 
				if(empty($errors)==true){  //eger hata yoksa 
					if(is_dir("$klasor/".$yenisim)==false){  //olusturdugumuz isimde dosya var mı?  
						$test=move_uploaded_file($dosya_gecici,"$klasor/".$yenisim);//yoksa yeni ismiyle kaydet 
						if($test==false){
							alert("asdjajsdasd");
						}
					}else{									//eger varsa 
						$new_dir="$klasor/".$yenisim.time(); //yeni ismin sonuna eklenme zamanını ekle 
						rename($dosya_gecici,$new_dir) ;				 
					}            			 
				}else{ 
					 print_r($errors); //varsa hataları yazdır 
				} 
			} 
			$yol='assets/'.$yenisim;
			
			if(empty($error)){ 
				
					$a=mysql_query("INSERT INTO `ilan_notlari` (`id`, `ilan_id`, `ekleyen`, `ilan_notu`, `gizlilik`, `tarih`, `dosya`) 
					VALUES (NULL, '".$gelen_id."', '".$admin_id."', '".$eklenecek_not."', '".$gizlilik."', '".$tarih."', '".$yol."')
					")or die(mysql_error()); 
                
          mysql_query("INSERT INTO `yapilan_is` (`id`, `admin_id`, `yaptigi`,`aciklama`, `ekleme_zamani`, `ilan_id`, `dogrudan_id`, `uye_id`) VALUES 
          (NULL, '".$admin_id."', '2','".$eklenecek_not."', '".$tarih."','','','".$gelen_id."');"); 
					if($a){
						alert("Başarıyla Eklendi..");
						header("Location:?modul=ihaleler&sayfa=tum_ihaleler");
            }
			} 
		}
	}

?>
