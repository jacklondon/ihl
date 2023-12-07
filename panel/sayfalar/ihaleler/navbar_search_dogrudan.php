<?php 

	$hepsini_cek = mysql_query("SELECT * FROM dogrudan_satisli_ilanlar where  concat(plaka,arac_kodu) LIKE '%".re("navbar_aranan")."%' ORDER BY bitis_tarihi DESC");
?>
<style>
table {
  border-collapse: collapse;
  border-spacing: 0;
  width: 100%;
  border: 1px solid #ddd;
}


th, td {
  text-align: left;
  padding: 8px;
}
i{
    padding: 8px;
}
tr:nth-child(even) {
  background-color: #f2f2f2;
}
</style>
<style>
.multiselect {
  width: 200px;
}

.selectBox {
  position: relative;
}
.selectBox select {
  width: 100%;
  font-weight: bold;
}
.overSelect {
  position: absolute;
  left: 0;
  right: 0;
  top: 0;
  bottom: 0;
}
#sehirler {
  display: none;
  border: 1px #dadada solid;
}

#sehirler label {
  display: block;
}

#sehirler label:hover {
  background-color: #1e90ff;
}
#markalar {
  display: none;
  border: 1px #dadada solid;
}

#markalar label {
  display: block;
}

#markalar label:hover {
  background-color: #1e90ff;
}
#tarih {
  display: none;
  border: 1px #dadada solid;
}

#tarih label {
  display: block;
}

#tarih label:hover {
  background-color: #1e90ff;
}
#profil {
  display: none;
  border: 1px #dadada solid;
}

#profil label {
  display: block;
}

#profil label:hover {
  background-color: #1e90ff;
}
	.checker span input {
		opacity:1!important;
		margin-top: -3px !important;
	}
			.chec
		{
			opacity:1!important;
			z-index:999!important;
		}
</style>
<script>
var expanded = false;
function showSehirler() {
  var checkboxes = document.getElementById("sehirler");
  if (!expanded) {
    checkboxes.style.display = "block";
    expanded = true;
  } else {
    checkboxes.style.display = "none";
    expanded = false;
  }
}
function showMarkalar() {
  var checkboxes = document.getElementById("markalar");
  if (!expanded) {
    checkboxes.style.display = "block";
    expanded = true;
  } else {
    checkboxes.style.display = "none";
    expanded = false;
  }
}
function showBitis() {
  var checkboxes = document.getElementById("tarih");
  if (!expanded) {
    checkboxes.style.display = "block";
    expanded = true;
  } else {
    checkboxes.style.display = "none";
    expanded = false;
  }
}  

function showProfil() {
  var checkboxes = document.getElementById("profil");
  if (!expanded) {
    checkboxes.style.display = "block";
    expanded = true;
  } else {
    checkboxes.style.display = "none";
    expanded = false;
  }
}
</script> 
<?php 
 $sehir_cek = mysql_query("SELECT * FROM sehir"); 
 $marka_cek = mysql_query("SELECT * FROM marka"); 
?>

<form method="POST" name="filter" id="filter">
  <div class="row-fluid">
    <div class="span6">
    <div class="form-group">
        <h5>Kelime ile ara</h5>
        <input type="search" name="aranan" class="form-control" placeholder="Plaka, araç kodu vb..">
    </div>
    <div class="multiselect">
        <div class="selectBox" onclick="showSehirler()">
          <select style="height:1.8em;">
          <option>Şehire Göre</option>
          </select>
          <div class="overSelect"></div>
        </div>
        <div id="sehirler">
        <?php while($sehir_oku = mysql_fetch_array($sehir_cek)){?>                        
          <label for="<?= $sehir_oku['sehirID'] ?>">
          <input type="checkbox" name="sehir[]" value="<?= $sehir_oku['sehiradi'] ?>" /><?= $sehir_oku['sehiradi'] ?></label>
          <?php } ?> 
        </div>
    </div>
    <div class="multiselect">
        <div class="selectBox" onclick="showMarkalar()">
          <select style="height:1.8em;">
          <option>Markaya Göre</option>
          </select>
          <div class="overSelect"></div>
        </div>
        <div id="markalar">
        <?php while($marka_oku = mysql_fetch_array($marka_cek)){?>                        
          <label for="<?= $marka_oku['markaID'] ?>">
          <input type="checkbox" name="marka[]" value="<?= $marka_oku['marka_adi'] ?>" /><?= $marka_oku['marka_adi'] ?></label>
          <?php } ?> 
        </div>
    </div>
    <div class="multiselect">
        <div class="selectBox" onclick="showBitis()">
          <select style="height:1.8em;">
          <option>Tarihe Göre</option>
          </select>
          <div class="overSelect"></div>
        </div>
        <div id="tarih">                           
          <input type="checkbox" name="tarih[]" value=" <?= date('Y-m-d') ?>" />Bugün Bitenler</label><br>
          <input type="checkbox" name="tarih[]" value="<?= date("Y-m-d", strtotime("+1 day")) ?>" />Yarın Bitenler</label>
        </div>
    </div>
    <div class="multiselect">
        <div class="selectBox" onclick="showProfil()">
          <select style="height:1.8em;">
          <option>Profile Göre</option>
          </select>
          <div class="overSelect"></div>
        </div>
        <div id="profil"> 
        <label for="Çekme Belgeli/Pert Kayıtlı">                          
          <input type="checkbox" name="profil[]" value="Çekme Belgeli/Pert Kayıtlı" />Çekme Belgeli/Pert Kayıtlı</label><br>
          <label for="Çekme Belgeli"> 
          <input type="checkbox" name="profil[]" value="Çekme Belgeli" />Çekme Belgeli</label><br>
          <label for="Hurda Belgeli"> 
          <input type="checkbox" name="profil[]" value="Hurda Belgeli" />Hurda Belgeli</label><br>
          <label for="Plakalı"> 
          <input type="checkbox" name="profil[]" value="Plakalı" />Plakalı</label>
        </div>
    </div>
    </div>
    <div class="span6">
    <div class="form-check">
        <h5>Yıla Göre</h5>
    </div>
    <div class="form-group">
        <label for="exampleInputEmail1">En düşük</label>
        <input type="text" name="kucuk_yil" class="form-control">
    </div>
    <div class="form-group">
        <label for="exampleInputPassword1">En yüksek</label>
        <input type="text" name="buyuk_yil" class="form-control" >
    </div>
    </div>
  </div>
    <button type="submit" name="filtrele" class="btn blue">Ara</button>
</form>
<?php 
                  if(isset($_POST['filtrele'])){                    
                    $f_kelime = $_POST['aranan'];     
                    $f_marka = $_POST['marka'];
                    $f_sehir = $_POST['sehir'];
                    $f_tarih = $_POST['tarih'];
                    $f_profil = $_POST['profil'];
                    $f_kucuk_yil = $_POST['kucuk_yil'];
                    $f_buyuk_yil = $_POST['buyuk_yil'];
                    
                    if($f_tarih=="1"){
                       $f_tarih =date("Y-m-d");
                    }elseif($f_tarih=="2"){
                       $f_tarih = date("Y-m-d", strtotime("+1 day"));
                    }


                     $where = "WHERE durum = '1'";
                     if($f_kelime !=""){
                        $where .= "AND concat(plaka,model,arac_kodu,model_yili,sehir,ilce) LIKE '%".$f_kelime."%'";
                     }
                     if($f_marka !=""){                    
                     $k = 0;
                     $seciliMarkaSayisi = count($_POST['marka']);
                     $seciliMarka = "";
                     while ($k < $seciliMarkaSayisi) {
                         $seciliMarka = $seciliMarka . "'" . $_POST['marka'][$k] . "'";
                         if ($k < $seciliMarkaSayisi - 1) {
                             $seciliMarka = $seciliMarka . ", ";
                         }
                         $k ++;
                     }
                     $where = $where . " AND marka in (" . $seciliMarka . ")";
                     }
                     if($f_sehir !=""){
                        $i = 0;
                        $seciliSehirSayisi = count($_POST['sehir']);
                        $seciliSehir = "";
                        while ($i < $seciliSehirSayisi) {
                            $seciliSehir = $seciliSehir . "'" . $_POST['sehir'][$i] . "'";
                            if ($i < $seciliSehirSayisi - 1) {
                                $seciliSehir = $seciliSehir . ", ";
                            }
                            $i ++;
                        }
                        $where = $where . " AND sehir in (" . $seciliSehir . ")";
                     }
                     if($f_profil !=""){
                        $p = 0;
                        $seciliProfilSayisi = count($_POST['profil']);
                        $seciliProfil = "";
                        while ($p < $seciliProfilSayisi) {
                            $seciliProfil = $seciliProfil . "'" . $_POST['profil'][$p] . "'";
                            if ($p < $seciliProfilSayisi - 1) {
                                $seciliProfil = $seciliProfil . ", ";
                            }
                            $p ++;
                        }
                        $where = $where . " AND evrak_tipi in (" . $seciliProfil . ")";
                     }
                     if($f_tarih !=""){
                        
                        $t = 0;
                        $seciliTarihSayisi = count($_POST['tarih']);
                        $seciliTarih = "";
                        while ($t < $seciliTarihSayisi) {
                            $seciliTarih = $seciliTarih . "'" . $_POST['tarih'][$t] . "'";
                            if ($t < $seciliTarihSayisi - 1) {
                                $seciliTarih = $seciliTarih . ", ";
                            }
                            $t ++;
                        }
                        $where = $where . " AND bitis_tarihi in (" . $seciliTarih . ")";
                     }
                     
                     if($f_kucuk_yil !="" && $f_buyuk_yil !=""){
                     $where .= "AND  model_yili BETWEEN $f_kucuk_yil AND $f_buyuk_yil";
                     }
                     $filtre_cek = "SELECT * FROM dogrudan_satisli_ilanlar $where order by bitis_tarihi desc";
                     $result = mysql_query($filtre_cek) or die(mysql_error());
                     $sayi = mysql_numrows($result);
                     if($sayi==0){
                        echo '<script type="text/javascript">'; 
                        echo 'alert("İstediğiniz kriterlere uygun araç bulunamadı.");'; 
                        echo 'window.location.href = "?modul=ihaleler&sayfa=dogrudan_satis";';
                        echo '</script>';                       
                     }else{  ?>
<form method="POST" action="?modul=ihaleler&sayfa=dogrudan_toplu_sil" >
<?php
    $admin_yetki_cek=mysql_query("Select * from kullanicilar where id='".$admin_id."' ");
    $admin_yetki_oku=mysql_fetch_assoc($admin_yetki_cek);
    $yetkiler=$admin_yetki_oku["yetki"];
    $yetki_parcala=explode("|",$yetkiler);
    $btn='';
    if (in_array(2, $yetki_parcala) && in_array(1, $yetki_parcala) ) { 
      $btn='<input type="submit" name="secili_sil" onclick="ConfirmDelete()" class="btn-danger" value="Seçili Olanları Sil">';
    }      
  ?>    
    <a><? echo $btn ?></a>

<div style="overflow-x:auto; margin-top:2%;">
<table class="table table-bordered" cellspacing="1" cellpadding="1">
    <tr>
        <td><input type="checkbox" id="checkle" class="checkall btn btn-blue chec2" style="padding:20px;opacity:1!important; z-index:999;">Tümünü Seç</td>
        <td>Düzenle</td>
        <td>Görseller</td>
        <td>Kod</td>
        <td>Plaka</td>
        <td>İl Adı</td>
        <td>Detaylar</td>
        <td>Yayın Bitiş Zamanı</td>
        <td>Fiyat</td>
        <td>Mesaj</td>
        <td>Favori</td>
        <td>Notlar</td>
        <td>Ekleyen</td>
    </tr>
    <?php while($filtre_oku = mysql_fetch_array($result)){

              $resim_cek = mysql_query("select * from dogrudan_satisli_resimler where ilan_id = '".$filtre_oku['id']."'");
              $resim_oku = mysql_fetch_assoc($resim_cek);
			  
			  	  // $mesaj_cek=mysql_query("SELECT * FROM mesajlar WHERE dogrudan_satis_id ='".$filtre_oku['id']."' ");
            // $mesaj_say=mysql_num_rows($mesaj_cek);

            $mesaj_cek = mysql_query("select * from chat_room where dogrudan_satis_id = '".$filtre_oku['id']."'");						
            $mesaj_say=mysql_num_rows($mesaj_cek);
			  
              $resim = $resim_oku['resim'];
              $ilan_sahibi = $filtre_oku['ilan_sahibi'];
              $uye_cek = mysql_query("SELECT * FROM user WHERE user_token = '".$ilan_sahibi."' OR kurumsal_user_token = '".$ilan_sahibi."'");
              $uye_oku =  mysql_fetch_assoc($uye_cek);
              $sahip = $uye_oku['ad'];
              $marka_cek2 = mysql_query("select * from marka where markaID = '".$filtre_oku['marka']."'");
              $marka_oku2 = mysql_fetch_assoc($marka_cek2);
              $marka_adi2 = $marka_oku2['marka_adi'];
              $gelen_id = $filtre_oku['id'];
			  
			$not_cek = mysql_query("SELECT * FROM dogrudan_satis_notlari WHERE dogrudan_id = '".$filtre_oku['id']."' group by tarih order by id desc");
			$not_sayi = mysql_num_rows($not_cek);
              

          ?>
          <tr>
          <td><input type="checkbox" name="secim[]" class="chec" id="asd<?= $filtre_oku['id'] ?>" value="<?= $filtre_oku['id'] ?>" style="opacity:1!important; z-index:999;"></td>
          <td><a href="?modul=ihaleler&sayfa=dogrudan_satis_duzenle&id=<?=$filtre_oku['id']?>" style="text-decoration:none; color:black;" name="duzenle"><i class="fas fa-edit"></i></a></td>
          <td><a onclick="tabTrigger();" href="?modul=ihaleler&sayfa=dogrudan_satis_duzenle&id=<?= $filtre_oku['id'] ?>"><img style="width: 50px; height:50px;" src="../images/<?= $resim ?>" alt=""></a></td>

          <td><?=$filtre_oku["arac_kodu"]?></td>
          <td><?=$filtre_oku["plaka"]?></td>    
          <td><?= $filtre_oku["sehir"] ?></td>      
			<td>
				<a href="../arac_detay.php?id=<?= $filtre_oku['id'] ?>&q=dogrudan" target="_blank" style="text-decoration: none; color:#000000; cursor:pointer;"> 
					<?=$filtre_oku["model_yili"]." ".$filtre_oku["marka"]." ".$filtre_oku["model"]." ".$filtre_oku["uzanti"]?>
				</a>
			</td>    
          <td> <a class="view_dogrudan_guncelle" id="<?= $filtre_oku['id'] ?>"><?= date("d-m-Y H:i:s",strtotime($filtre_oku['bitis_tarihi'])) ?></a></td>  
          <td><?=money($filtre_oku["fiyat"]) ?> ₺</td>
          <td><a class="view_dogru_mesajlari" id="<?= $filtre_oku['id'] ?>"><i class="fas fa-envelope"></i><?= $mesaj_say ?></a></td>    
          <td><a class="view_dogru_favorileri" id="<?= $filtre_oku['id'] ?>"><i class="fas fa-heart"></i><?= $favori_say ?></a></td>    
          <td><a class="view_dogru_notlari" id="<?= $filtre_oku['id'] ?>"><i class="fas fa-align-justify"><?= $not_sayi ?></i></a></td>    
          <td><?=$sahip?></td>    
          </tr>
      

<?php  } }?>                     
</table>
</div>
</form>
<?php }else{ ?>
  <form method="POST" action="?modul=ihaleler&sayfa=dogrudan_toplu_sil" >
<?php
    $admin_yetki_cek=mysql_query("Select * from kullanicilar where id='".$admin_id."' ");
    $admin_yetki_oku=mysql_fetch_assoc($admin_yetki_cek);
    $yetkiler=$admin_yetki_oku["yetki"];
    $yetki_parcala=explode("|",$yetkiler);
    $btn='';
    if (in_array(2, $yetki_parcala) && in_array(1, $yetki_parcala) ) { 
      $btn='<input type="submit" name="secili_sil"  onclick="ConfirmDelete()" class="btn-danger" value="Seçili Olanları Sil">';
    }      
  ?>    
    <a><? echo $btn ?></a>
<div style="overflow-x:auto; margin-top:2%;">
<table class="table table-bordered" cellspacing="1" cellpadding="1">
    <tr>
        <td><input type="checkbox" id="checkle" class="checkall btn btn-blue chec2" style="padding:20px;opacity:1!important; z-index:999;">Tümünü Seç</td>
        <td>Düzenle</td>
        <td>Görseller</td>
        <td>Kod</td>
        <td>Plaka</td>
        <td>İl Adı</td>
        <td>Detaylar</td>
        <td>Yayın Bitiş Zamanı</td>
        <td>Fiyat</td>
        <td>Mesaj</td>
        <td>Favori</td>
        <td>Notlar</td>
        <td>Ekleyen</td>
    </tr>
    <?php 
        while($hepsini_oku = mysql_fetch_array($hepsini_cek)){
          $resim_cek = mysql_query("select * from dogrudan_satisli_resimler where ilan_id = '".$hepsini_oku['id']."'");
          $resim_oku = mysql_fetch_assoc($resim_cek);
          $resim = $resim_oku['resim'];
          $ilan_sahibi = $hepsini_oku['ilan_sahibi'];
          $uye_cek = mysql_query("SELECT * FROM user WHERE user_token = '".$ilan_sahibi."' OR kurumsal_user_token = '".$ilan_sahibi."'");
          $uye_oku =  mysql_fetch_assoc($uye_cek);
          $sahip = $uye_oku['ad'];
          $dogrudan_satis_id = $hepsini_oku["id"];
		  
		  // $mesaj_cek=mysql_query("SELECT * FROM mesajlar WHERE dogrudan_satis_id ='".$dogrudan_satis_id."' ");
		  $mesaj_say=mysql_num_rows($mesaj_cek);

      $mesaj_cek = mysql_query("select * from chat_room where dogrudan_satis_id = '".$dogrudan_satis_id."'");						
      $mesaj_say=mysql_num_rows($mesaj_cek);
		  
		  $favori_cek = mysql_query("SELECT * FROM favoriler WHERE dogrudan_satisli_id ='".$dogrudan_satis_id."'");
		  $favori_say=mysql_num_rows($favori_cek);
			
			$not_cek = mysql_query("SELECT * FROM dogrudan_satis_notlari WHERE dogrudan_id = '".$dogrudan_satis_id."' group by tarih order by id desc");
			$not_sayi = mysql_num_rows($not_cek);
			
          $ili_cek = mysql_query("SELECT * FROM sehir WHERE plaka ='".$hepsini_oku['sehir']."'");
          $gelen_id = $hepsini_oku["id"]; ?>
		<tr>
		<td><input type="checkbox" name="secim[]" class="chec" id="asd<?= $hepsini_oku['id'] ?>" value="<?= $hepsini_oku['id'] ?>" style="opacity:1!important; z-index:999;"></td>
		<td><a href="?modul=ihaleler&sayfa=dogrudan_satis_duzenle&id=<?=$dogrudan_satis_id?>" target="_blank" style="text-decoration:none; color:black;" name="duzenle"><i class="fas fa-edit"></i></a></td>
		<td><a onclick="tabTrigger();" href="?modul=ihaleler&sayfa=dogrudan_satis_duzenle&id=<?= $hepsini_oku['id'] ?>"><img style="width: 50px; height:50px;" src="../images/<?= $resim ?>" alt=""></a></td>
		<td><?=$hepsini_oku["arac_kodu"]?></td>
		<td><?=$hepsini_oku["plaka"]?></td>    
		<td><?= $hepsini_oku["sehir"] ?></td>      
		<td><a href="../arac_detay.php?id=<?= $hepsini_oku['id'] ?>&q=dogrudan" target="_blank" style="text-decoration: none; color:#000000; cursor:pointer;"> 
		<?=$hepsini_oku["model_yili"]." ".$hepsini_oku["marka"]." ".$hepsini_oku["model"]." ".$hepsini_oku["uzanti"]?>
		</a></td>    
		<td><a class="view_dogrudan_guncelle" id="<?= $dogrudan_satis_id ?>"><?= date("d-m-Y H:i:s",strtotime($hepsini_oku['bitis_tarihi'])) ?></a></td>  
		<td><?=$hepsini_oku["fiyat"]?></td>
		<td><a class="view_dogru_mesajlari" id="<?= $hepsini_oku['id'] ?>"><i class="fas fa-envelope"><?=$mesaj_say ?></i></a></td>    
		<td><a class="view_dogru_favorileri" id="<?= $hepsini_oku['id'] ?>"><i class="fas fa-heart"><?=$favori_say ?></i></a></td>    
		<td><a class="view_dogru_notlari" id="<?= $hepsini_oku['id'] ?>"><i class="fas fa-align-justify"><?= $not_sayi ?></i></a></td>    
		<td><?= $sahip ?></td>    
		</tr>
		<?php } ?>
</table>
</div>
  </form>
<?php } ?>

<!-- Guncelleme-->
<div class="modal fade" id="tarih_guncelle">
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
    <h3 id="myModalLabel">Tarihi Değiştir</h3>
  </div>
   <div class="modal-dialog">
      <div class="modal-body" id="ihale_guncelle">
      </div>
   </div>
</div>
<!-- Guncelleme Modal Bitiş-->

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
//Tarih Guncelle
$(document).ready(function(){
    $(document).on('click', '.view_dogrudan_guncelle', function(){
      var employee_id = $(this).attr("id");
      if(employee_id != '')
      {  
        $.post('sayfalar/ihaleler/tarih_guncelle.php', {'id':employee_id}, function(response){
          $('#ihale_guncelle').html(response);
          $('#tarih_guncelle').modal('show')
        })
      }
    });
});


</script>
<script type="text/javascript">
      function ConfirmDelete()
      {
		if (confirm("Silmek İsteğinize Emin Misiniz?"))
			 location.href='linktoaccountdeletion';
      }
  </script>

  


<?php 
if((re('ihale_tarih_degisir')=="Kaydet")){
  $guncel_tarih = re('tarih_guncelle');
  $ilanin_id = re('ilanin_id');
  mysql_query("UPDATE dogrudan_satisli_ilanlar SET bitis_tarihi = '".$guncel_tarih."', durum = 1 WHERE id='".$ilanin_id."'");
  header("Refresh:0");
}
?>


<!-- İlan Notları-->

<div class="modal fade" id="dogrudan_notlari">
	<button type="button" class="close" style="margin-right: 2%; margin-top:2%;" data-dismiss="modal" aria-hidden="true"></button>
	<div class="modal-dialog">
		<div class="modal-body" id="dogrudanin_notlarini">
		</div>
	</div>
</div>

<!-- İlan Fav-->
<div class="modal fade" id="ilan_fav">
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
  </div>
   <div class="modal-dialog">
      <div class="modal-body" id="fav_ilan">
      </div>
   </div>
</div>

<!-- İlan Mesaj-->
<div style="width:60%;" class="modal fade" id="ilan_mesaj">
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
  </div>
   <div class="modal-dialog">
      <div class="modal-body" id="mesaj_ilan">
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
				$yenisim=md5(microtime()).$dosya_adi; 				//karmasik yeni isim.pdf 
				                     
				$klasor="../assets"; // yuklenecek dosyalar icin yeni klasor 
				$test=move_uploaded_file($dosya_gecici,"$klasor/".$yenisim);//yoksa yeni ismiyle kaydet 
				if($test==true){
					$yol='assets/'.$yenisim;
					$a=mysql_query("INSERT INTO `dogrudan_satis_notlari` (`id`, `dogrudan_id`, `ekleyen`, `ilan_notu`, `gizlilik`, `tarih`, `dosya`) 
					VALUES (NULL, '".$gelen_id."', '".$admin_id."', '".$eklenecek_not."', '".$gizlilik."', '".$tarih."', '".$yenisim."')")or die(mysql_error()); 
				
					mysql_query("INSERT INTO `yapilan_is` (`id`, `admin_id`, `yaptigi`,`aciklama`, `ekleme_zamani`, `ilan_id`, `dogrudan_id`, `uye_id`) VALUES 
					(NULL, '".$admin_id."', '2','".$eklenecek_not."', '".$tarih."','0','".$gelen_id."','0');"); 
					if($a){
					echo '<script>alert("Başarıyla Eklendi..");</script>';
					header("Location:?modul=ihaleler&sayfa=dogrudan_satis");
				   }
				}
				else {
					$a=mysql_query("INSERT INTO `dogrudan_satis_notlari` (`id`, `dogrudan_id`, `ekleyen`, `ilan_notu`, `gizlilik`, `tarih`, `dosya`) 
					VALUES (NULL, '".$gelen_id."', '".$admin_id."', '".$eklenecek_not."', '".$gizlilik."', '".$tarih."', '1')")or die(mysql_error()); 
				
					mysql_query("INSERT INTO `yapilan_is` (`id`, `admin_id`, `yaptigi`,`aciklama`, `ekleme_zamani`, `ilan_id`, `dogrudan_id`, `uye_id`) VALUES 
						(NULL, '".$admin_id."', '2','".$eklenecek_not."', '".$tarih."','0','".$gelen_id."','0');"); 
					header("Location:?modul=ihaleler&sayfa=dogrudan_satis");
				}
			} 
		

		}
	}

?>

<script>
	function tabTrigger(){
		localStorage.setItem("gorsel_trigger","1");
	}
//İlan Mesajları
$(document).ready(function(){
  $(document).on('click', '.view_dogru_mesajlari', function(){
      var employee_id = $(this).attr("id");
      if(employee_id != '')
      {  
        $.post('sayfalar/ihaleler/dogrudan_mesajlari.php', {'id':employee_id}, function(response){
          $('#mesaj_ilan').html(response);
          $('#ilan_mesaj').modal('show')
        })
      }
  });
});
//İlan Favorileri
$(document).ready(function(){
  $(document).on('click', '.view_dogru_favorileri', function(){
    var employee_id = $(this).attr("id");
    if(employee_id != '')
    {  
      $.post('sayfalar/ihaleler/dogrudan_favorileri.php', {'id':employee_id}, function(response){
        $('#fav_ilan').html(response);
        $('#ilan_fav').modal('show')
      })
    }
  });
});

//İlan Notları
$(document).ready(function(){
  $(document).on('click', '.view_dogru_notlari', function(){
    var employee_id = $(this).attr("id");
    if(employee_id != '')
    {  
      $.post('sayfalar/ihaleler/dogrudan_notlari.php', {'id':employee_id}, function(response){
        $('#dogrudanin_notlarini').html(response);
        $('#dogrudan_notlari').modal('show')
      })
    }
  });
});
	var clicked = false;
	$(".checkall").on("click", function() {
	  $(".chec").prop("checked", !clicked);
	  clicked = !clicked;
	  this.innerHTML = clicked ? 'Seçimleri Kaldır' : 'Tümünü Seç';
	});

</script>