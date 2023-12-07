<?php 
    $cek = mysql_query("SELECT * FROM sistem_nasil_isler");
    $oku = mysql_fetch_object($cek);
    if(re('a') == "b"){
        $sql = mysql_query("update sistem_nasil_isler set content = '".re('content')."'");
        if($sql){
            header('refresh:0');
        }
    }
?>
<script src="assets/ckeditor4/ckeditor.js"></script>
<h3>Sistem Nasıl İşler Sayfası</h3>
<form method="POST" name="form" id="form" enctype="multipart/form-data">
    <textarea name="content" id="content" class="span10" rows="7"><?= $oku->content ?></textarea>
    <div class="form-actions">
        <button type="submit" class="btn blue" name="a" value="b">Güncelle</button>
    </div>
</form>




<style>
.ck-editor__editable_inline {
    min-height: 200px !important;
}
</style>
<script>
    CKEDITOR.replace( 'content', {
			height: 250,
			extraPlugins: 'colorbutton,colordialog',
			removeButtons: 'PasteFromWord'	
		} );
        
</script>

 