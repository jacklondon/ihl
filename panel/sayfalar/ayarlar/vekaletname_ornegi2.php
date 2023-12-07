<script src="https://cdn.ckeditor.com/ckeditor5/27.0.0/classic/ckeditor.js"></script>
<h3>Vekaletname</h3>
<p>-Yeni paragraf için enter kullanıp alt satıra geçmeyip, %p% yazıp yeni paragrafa başlamalısınız. </p>
<p>- Kullanıcının adının geleceği kısım için %1% , TC kimlik numarası içinse %2% yazmalısınız. </p>
<p>- Bahsettiğimiz özel tanımlamalar ve noktalama işaretlerinden sonra boşluk bırakmalısınız. </p>

<form action="" method="post" enctype="multipart/form-data">
<?php $row=mysql_fetch_object(mysql_query("select * from pdf_detay where id='1' ")); ?>
    <textarea style="height:200px;width:100%;" name="vekaletname" ><?=$row->vekaletname_detay ?></textarea>
<?php ?>
    <div class="form-actions">
		<input type="submit" name="vekaletnameyi" class="btn blue" value="Kaydet" />
		<a class="btn blue" href="https://ihale.pertdunyasi.com/pdf.php?id=1&q=vekaletname_pdf_olustur" target="_blank"> PDF Görüntüle</a>
		<a class="btn blue" href="https://ihale.pertdunyasi.com/word.php?id=1&q=vekaletname_word_olustur" > WORD Görüntüle</a>
	</div>
</form>


<style>
.ck-editor__editable_inline {
    min-height: 200px !important;
}
</style>
<script>
    /*ClassicEditor
        .create( document.querySelector( '#uyelik_sozlesmesi' ) )
        .then( editor => {
            console.log( editor );
        } )
        .catch( error => {
            console.error( error );
        } );
        */
</script>
<?php
if(re("vekaletnameyi")=="Kaydet"){
	
	$kaydet=mysql_query("update pdf_detay set vekaletname_detay='".re("vekaletname")."' where id='1' ");
	if($kaydet){
	 header("Location: ?modul=ayarlar&sayfa=vekaletname_ornegi");
	 
	}
	
}

 ?>

