<style>
.breadcrumb{
    width:100%;
}
.right{
    float: right;
}
.mavi{
    background-color:rgb(74,170,214);
    color: white;
}
a{
    text-decoration: none;
    cursor: pointer;
}
.modal-header{
    background-color:rgb(74,170,214);
}

</style>


<?php 
$msg_kat_cek = mysql_query("select * from hazir_mesaj_kategori where durum='1'");
$msg_kat_bas = '';
while($msg_kat_oku = mysql_fetch_array($msg_kat_cek)){ 
  $msg_kat_bas .= ' <a href="#'.$msg_kat_oku["kisa_ad"].'" role="button" data-toggle="modal">
  <p class="span12 mavi">'.$msg_kat_oku["kategori_adi"].'</p>
  </a>';
  $option .='<option value="'.$msg_kat_oku["id"].'">'.$msg_kat_oku["kategori_adi"].' </option>';
  
$msg_kat_bas .= '<div id="'.$msg_kat_oku["kisa_ad"].'" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="'.$msg_kat_oku["kisa_ad"].'Label" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
    <h3 id="myModalLabel">Hazır Mesajlar</h3>
  </div>
  <div class="modal-body"> ';
  $msg_icerik_cek = mysql_query("select * from hazir_mesajlar where kategori_id = '".$msg_kat_oku['id']."'");
  while($msg_icerik_oku = mysql_fetch_array($msg_icerik_cek)){
	  $checked="";
	  if($msg_icerik_oku["durum"]==1){
		  $checked="checked";
	  }
    $msg_kat_bas .= '<div class="row-fluid">
    <input type="radio" '.$checked.' style="margin-left: 0px; opacity: 1; margin-top: 0;" onchange="goster(this)" name="secilen[]" id="kategori_icerik_'.$msg_icerik_oku["id"].'" value="'.$msg_icerik_oku["id"].'">'.$msg_icerik_oku["sms_icerigi"].'
    <input type="hidden" id="icerik_'.$msg_icerik_oku["id"].'">
</div>';
  }
  $msg_kat_bas .= '</div>
  <div class="modal-footer">
    <button class="btn-primary" id="duzenle" onclick="mesaj_duzenle()">DÜZENLE</button>
    <button class="btn-success" style="min-width:70px;" onclick="mesaj_aktif()">Aktif Et</button>
    
  </div>
</div>';
}

if(re("action")=="sms_kategori")
{
  $date_time=date("Y-m-d H:i:s");
  $yukle =mysql_query("INSERT INTO `hazir_mesajlar` (`kategori_id`, `sms_icerigi`, `e_tarihi`, `durum`) VALUES 
  ('".re('kategori')."', '".re('sms_icerigi')."', '".$date_time."', '1');");
if($yukle)
{
  $msg='<div class="alert alert-primary" role="alert">
       Başarıyla Eklendi.
      </div>';
      header('Location: ?modul=ayarlar&sayfa=hazir_mesajlar');
}
else {
  $msg='<div class="alert alert-primary" role="alert">
   Hata Oluştu.
 </div>';
}


}
?>


<ul class="breadcrumb">
  <li><a href="#">Anasayfa</a> <span class="divider">/</span><a href="#">Hazır Mesajlar</a></li>
  <li class="right">
    <!--<a href="#">Yeni Ekle</a> <span class="divider">/</span>-->
    <a href="#" onClick="window.location.reload();"><i class="fas fa-redo-alt"> Yenile</i></a>
    <span class="divider"></span>
  </li>
</ul>

<div class="row-fluid">
    <div class="span2">
        Sms İçeriği :
    </div>
    <div class="span7">
        <textarea name="sms_icerigi" id="sms_icerigi" class="span12"  rows="10"></textarea>
    </div>
    <div class="span3">
        <div class="row-fluid">
        <?= $msg_kat_bas ?>
        </div>
    </div>
</div>
<div class="row-fluid">
    <div class="span2"></div>
    <div class="span7">
        <button class="btn-primary" onclick="mesaj_guncelle()" type="button">Güncelle</button>
        <button class="btn-primary" type="button" onclick="mesaj_sil()">Sil</button>
    </div>
    <div class="span3">
      <?=$modal ?>
    </div>
</div>
<script>
  function goster(ivir){
    localStorage.removeItem("ivir");
    localStorage.setItem("ivir",ivir.value);    
  }
  function mesaj_duzenle(){       
 let deger= localStorage.getItem("ivir");
  jQuery.ajax({
          url: "sayfalar/ayarlar/hazir_mesaj_islemleri.php",
          type: "POST",
          dataType: "JSON",
          data: {
              action: "hazir_sec",
              deger: deger,               
          },
          success: function(response) {  
              if (response.status == 200) {
                $('#sms_icerigi').html(response.mesaj_icerik);    
                $("#"+response.kisa_ad).modal('hide');                                     
              }else{
                  swal("HATA", response.message, "error");  
              }
          }
      });
  }
  function mesaj_guncelle(){
    let mesaj_id= localStorage.getItem("ivir");
    var sms_icerigi = document.getElementById('sms_icerigi').value;
    if(mesaj_id){
      jQuery.ajax({
          url: "sayfalar/ayarlar/hazir_mesaj_islemleri.php",
          type: "POST",
          dataType: "JSON",
          data: {
              action: "mesaj_guncelle",
              mesaj_id: mesaj_id,               
              sms_icerigi: sms_icerigi,               
          },
          success: function(response) {  
              if (response.status == 200) {
                swal("Başarılı", response.message, "success")
                .then((value) => {
                  location.reload(); 
                });
              }else{
                  swal("HATA", response.message, "error");  
              }
          }
      });
    }else{
      swal("HATA", "Lütfen düzenlemek istedğiniz mesajı seçin", "error");  
    }
  }

  function mesaj_sil(){
    let mesaj_id= localStorage.getItem("ivir");
    var sms_icerigi = document.getElementById('sms_icerigi').value;
    if(mesaj_id){
      jQuery.ajax({
          url: "sayfalar/ayarlar/hazir_mesaj_islemleri.php",
          type: "POST",
          dataType: "JSON",
          data: {
              action: "mesaj_sil",
              mesaj_id: mesaj_id,               
              sms_icerigi: sms_icerigi,               
          },
          success: function(response) {  
              if (response.status == 200) {
                swal("Başarılı", response.message, "success")
                .then((value) => {
                  location.reload(); 
                });
              }else{
                  swal("HATA", response.message, "error");  
              }
          }
      });
    }else{
      swal("HATA", "Lütfen silmek istedğiniz mesajı seçin", "error");  
    }
  }

  function mesaj_aktif(){
    let mesaj_id= localStorage.getItem("ivir");    
    if(mesaj_id){
      jQuery.ajax({
          url: "sayfalar/ayarlar/hazir_mesaj_islemleri.php",
          type: "POST",
          dataType: "JSON",
          data: {
              action: "mesaji_aktif_et",
              mesaj_id: mesaj_id,               
          },
          success: function(response) {  
              if (response.status == 200) {
                swal("Başarılı", response.message, "success")
                .then((value) => {
                  location.reload(); 
                });
              }else if(response.status == 300){
                swal("HATA", response.message, "error");  
              }else{
                swal("HATA", response.message, "error");  
              }
          }
      });
    }else{
      swal("HATA", "Lütfen aktif etmek istedğiniz mesajı seçin", "error");  
    }
  }
</script>

<hr>
<br>
<form method="POST">
<div class="row-fluid">
<input type="hidden" name="action" value="sms_kategori">
    <div class="span2">
       SMS Kategorisi :
    </div>
    <div class="span8">
      <select name="kategori" id="kategoriler"> 
      <?= $option ?>       
    </select>
    </div>
     
</div>
<?= $msg ?>
<div class="row-fluid">
    <div class="span2">
        Yeni SMS İçeriği :
    </div>
    <div class="span7">
        <textarea name="sms_icerigi" class="span12"  rows="10"></textarea>
    </div>    
</div>
<div class="row-fluid">
    <div class="span2"></div>
    <div class="span10">
        <button type="submit" class="btn-primary" type="button">Kaydet</button>
    </div>
   
   </div>
</from> 

<script
  src="https://code.jquery.com/jquery-3.6.0.js">
</script>


<script>


function secilen_text()
{
  $("input[name='secilen[]']:checked").each(function (index, obj) {
    console.log( $(this).html() );
    });
}


</script>