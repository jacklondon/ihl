<?

$id=re("id");

$select=mysql_query("Select * from canli_destek where id='".$id."'");
$sorulari_cek=mysql_fetch_assoc($select);


if(re("action")=="canli_destek_soru")
{
    $update=mysql_query("Update canli_destek set soru='".re('soru')."',cevap='".re('cevap')."' where id='".$id."' ");
    
    if($update)
    {
       
        $msg='<div class="alert alert-success" role="alert">
       Başarıyla Kaydedildi.
      </div>';
    }
    else {
       
        $msg='<div class="alert alert-danger" role="alert">
       Hata Oluştu.
      </div>';
    }
}

?>

<?= $msg ?>

<form method="POST" id="form" name="form">
    <input type="hidden" name="action" value="canli_destek_soru">
   <div class="row-fluid" style="margin-top: 2%;">
   <div class="span6">
      <label for="IDofInput">Soru</label>
      <input type="text" class="span12" name="soru" class="span12" value="<?= $sorulari_cek["soru"] ?>">
   </div>
   <div class="span6">
      <label for="IDofInput">Cevap</label>
      <input type="text" class="span12" name="cevap" class="span12" value="<?= $sorulari_cek["cevap"] ?>">
   </div>
   <div class="row-fluid">
       <div class="span12">
      <div class="form-actions">
         <input type="submit" name="cevap_kaydet" class="btn blue btn-block" value="Kaydet" />
      </div>
    </div>
   </div>
</form>
   

<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
