<script src="assets/ckeditor4/ckeditor.js"></script>
<h3>Üyelik Sözleşmesi</h3>
<p>-Yeni paragraf için enter kullanıp alt satıra geçmeyip, %p% yazıp yeni paragrafa başlamalısınız. </p>
<p>- Kullanıcının adının geleceği kısım için %1% , TC kimlik numarası içinse %2% yazmalısınız. </p>
<p>- Bahsettiğimiz özel tanımlamalar önce ve sonra boşluk bırakmalısınız. </p>

<form method="post" enctype="multipart/form-data">
<?php $row=mysql_fetch_object(mysql_query("select * from pdf_detay where id='1' ")); ?>
    <textarea style="height:200px;width:100%;" readonly name="uyelik_sozlesmesi" id="uyelik_sozlesmesi" ><?=$row->uyelik_detay ?></textarea>
<?php ?> 
    <div class="form-actions">
		<a class="btn blue" href="https://sistemal.net.tr/tasarim/pert_dunyasi_yeni2/pdf.php?id=1&q=uyelik_pdf_olustur" target="_blank"> PDF Görüntüle</a>
		<!--<a class="btn blue" href="https://sistemal.net.tr/tasarim/pert_dunyasi_yeni2/html2pdf/pdf.php?id=1&q=uyelik_pdf_olustur" target="_blank"> PDF Görüntüle</a>-->
	</div>
</form>


<style>
.ck-editor__editable_inline {
    min-height: 200px !important;
}
</style>
<script>
    CKEDITOR.replace( 'uyelik_sozlesmesi', {
			height: 250,
			extraPlugins: 'colorbutton,colordialog',
			removeButtons: 'PasteFromWord'	
		} );
        
</script>
<?php

if(re("uyelik_sozlesmesini")=="Kaydet"){
	
	$kaydet=mysql_query("update pdf_detay set uyelik_detay='".re("uyelik_sozlesmesi")."' where id='1' ");
	if($kaydet){
		header("Location: ?modul=ayarlar&sayfa=uyelik_sozlesmesi");
	}
	
	
}

 ?>


<h3>Kurumsal Üyelik Sözleşmesi</h3>
<p>-Yeni paragraf için enter kullanıp alt satıra geçmeyip, %p% yazıp yeni paragrafa başlamalısınız. </p>
<p>- Firma adının geleceği kısım için %1% , vergi dairesi için %2% , vergi numarası için ise %3% yazmalısınız. </p>
<p>- Bahsettiğimiz özel tanımlamalar önce ve sonra boşluk bırakmalısınız. </p>

<form method="post" enctype="multipart/form-data">
<?php $row=mysql_fetch_object(mysql_query("select * from pdf_detay where id='1' ")); ?>
    <textarea style="height:200px;width:100%;" readonly name="k_uyelik_sozlesmesi" id="k_uyelik_sozlesmesi" ><?=$row->kurumsal_uyelik_detay ?></textarea>
<?php ?>
    <div class="form-actions">
		<a class="btn blue" href="https://sistemal.net.tr/tasarim/pert_dunyasi_yeni2/pdf.php?id=1&q=k_uyelik_pdf_olustur" target="_blank"> PDF Görüntüle</a>
	</div>
	

</form>
<script>
	
    CKEDITOR.replace( 'k_uyelik_sozlesmesi', {
		height: 250,
		extraPlugins: 'colorbutton,colordialog',
		removeButtons: 'PasteFromWord'	
	} );
</script>


<?php
if(re("k_uyelik_sozlesmesini")=="Kaydet"){
	/*
	$kaydet=mysql_query("update pdf_detay set kurumsal_uyelik_detay='".re("k_uyelik_sozlesmesi")."' where id='1' ");
	if($kaydet){
		header("Location: ?modul=ayarlar&sayfa=uyelik_sozlesmesi");
	}
	*/
	
}

 ?>

