<script src="https://cdn.ckeditor.com/ckeditor5/27.0.0/classic/ckeditor.js"></script>

<?if(re("action")=="tanitim_sms")
{
    $msg="";
    $date_time=date("Y-m-d H:i:s");


    $insert=mysql_query("INSERT INTO `tanitim_sms_ayarlari` (`gonderilen_sms`, `e_tarihi`,`durum`) VALUES ('".$_POST["tanitim_sms_ayarlari"]."','".$date_time."','0');");

    
        if($insert)
        {
            $msg.='
            <div class="alert alert-success" role="alert">
            İşleminiz Gerçekleşti.
        </div>';
        }
        else {

            $msg.='
            <div class="alert alert-danger" role="alert">
            Hata Oluştu.Lütfen Tekrar Deneyiniz.
        </div>';
            
        }
}

$select=mysql_query("Select *from tanitim_sms_ayarlari order by id desc");
while($veri_cek=mysql_fetch_array($select))
{
    $syaacim++;
    $durum_son="Pasif";
    if($veri_cek["durum"]==1)
    {
        $durum_son="Aktif";
    }
         
    $tr.='
    <tr>
            <td>'.$syaacim.' </td>
            <td> '.$veri_cek["gonderilen_sms"].'</td>
            <td> '.$durum_son.'</td>
            <td><a href="?modul=uyeler&sayfa=tanitim_aktif&id='.$veri_cek["id"].'" class="btn"> Aktif/Pasif </a> </td>
            <td  ><a  onclick="return confirm(\'Silmek istediğinize emin misiniz?\');" href="?modul=ayarlar&sayfa=data_sil&id='.$veri_cek["id"].'&q=tanitim_sms_sil" class="btn"> Sil </a> </td>
    <tr>
       ';
}


?>


<h3>Tanıtım Sms Ayarları</h3>
<?= $msg ?>
<form name="tanitim_sms" method="post" enctype="multipart/form-data">
<input type="hidden" name="action" value="tanitim_sms">
    <textarea style="width:50%;height:150px;" name="tanitim_sms_ayarlari" id="tanitim_sms_ayarlari" ></textarea>
    <div class="form-actions">
        <input type="submit"  class="btn blue" value="Kaydet" />
    </div>

</form>

<h3 style="text-align:center">Tanıtım Mesajları</h3>
<div class="table-responsive">
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Mesaj </th>
                <th>Durum </th>
                <th>Seç </th>
                <th>Sil </th>
            </tr>
        </thead>
        <tbody>
            <tr>
				<?= $tr ?>
			</tr>
        </tbody>
    </table>
</div>

<style>
.ck-editor__editable_inline {
    min-height: 200px !important;
}
</style>
<script>
    /*ClassicEditor
        .create( document.querySelector( '#tanitim_sms_ayarlari' ) )
        .then( editor => {
            console.log( editor );
        } )
        .catch( error => {
            console.error( error );
        } );
        */
</script>
