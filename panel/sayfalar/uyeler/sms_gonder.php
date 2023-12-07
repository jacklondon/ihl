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
$uye_cek = mysql_query("SELECT * FROM user");
$selected="";
$id=re("id");

if(re("action")=="sms_gonder")
{
    $gonderilecek_kisi=re("gonderilecek_kisi");
    $icerik=re("icerik");
    coklu_sms_gonder($gonderilecek_kisi,re("icerik"),3);
}

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
    $msg_kat_bas .= '<div class="row-fluid">
    <input type="radio" style="margin-left: 0px; opacity: 1; margin-top: 0;" onchange="goster(this)" name="secilen[]" id="kategori_icerik_'.$msg_icerik_oku["id"].'" value="'.$msg_icerik_oku["id"].'">'.$msg_icerik_oku["sms_icerigi"].'
    <input type="hidden" id="icerik_'.$msg_icerik_oku["id"].'">
</div>';
  }
  $msg_kat_bas .= '</div>
  <div class="modal-footer">
    <button class="btn-primary" id="duzenle" onclick="mesaj_duzenle()">SEÇ</button>
  </div>
</div>';
}
?>
<div class="row-fluid" style="margin-top:3%;">
<div class="span9">
<form name="form" id="form" method="POST" enctype="multipart/form-data">
<input type="hidden" name="action" value="sms_gonder">
    <label for="IDofInput">SMS İçeriği</label>
    <textarea name="icerik" id="icerik" class="span12" rows="6" required></textarea>
    <label for="IDofInput">Gönderilecek Kişi</label>
    <select name="gonderilecek_kisi" class="span12" required>
    <option value="">Seçiniz</option>
    <?php while($uye_oku = mysql_fetch_array($uye_cek))
    {    
        if($id==$uye_oku["id"])
        {        
            $selected="selected";
        }
        else {
            $selected="";
    }
    ?>
    <option value="<?= $uye_oku['id'] ?>" <?=  $selected ?>><?= $uye_oku['ad'] ?></option>
    <?php } ?>
    </select>
    <div class="form-actions">
        <div class="span4"></div>
        <div class="span4"><input type="submit" name="smsi" class="btn-primary btn-block" value="Kaydet"></div>
        <div class="span4"></div>
    </div>
</form>
</div>
<div class="span3">
<?= $msg_kat_bas ?>
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
                $('#icerik').html(response.mesaj_icerik);    
                $("#"+response.kisa_ad).modal('hide');                                     
              }else{
                  swal("HATA", response.message, "error");  
              }
          }
      });
  }
</script>
