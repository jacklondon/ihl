<?php 

if(re('veriyi')=="Kaydet"){
    $sor = mysql_query("select * from site_acilis_popup");
    $say = mysql_num_rows($sor);
    $oku = mysql_fetch_assoc($sor);
	if(re("icerik")==""){
		$icerik=$oku["icerik"];
	}else{
		$icerik=re("icerik");
	}
	
    if($say == 0){       
        $guncelle = mysql_query("INSERT INTO `site_acilis_popup` (`id`, `icerik`, `tarih`, `buton`, `durum`) VALUES (NULL, '".$icerik."', '".date('Y-m-d H:i:s')."', '".re('kapat_butonu')."', '".re('pop_durum')."')");
    }else{        
        $guncelle = mysql_query("update site_acilis_popup set icerik = '".$icerik."', buton = '".re('kapat_butonu')."', tarih = '".date('Y-m-d H:i:s')."',durum='".re('pop_durum')."'  ");
    }
}

?>
<?php 
	$sayac=1;
	
	$popup_cek = mysql_query("SELECT * FROM site_acilis_popup order by id asc");
	$popup_oku = mysql_fetch_array($popup_cek);
	
	if($popup_oku["durum"]=="1"){
		$checked="checked";
	}else{
		$checked="";
	}
	
	if($popup_oku["buton"]=="1"){
		$kapat_checked="checked";
	}else{
		$kapat_checked="";
	}
?>

<script src="assets/ckeditor4/ckeditor.js"></script>
	<h3>Site Açılış Popup Uyarısı</h3>
	<form name="uyelerin_gorecegi_popup" method="post" enctype="multipart/form-data">
		<textarea name="icerik" id="icerik"></textarea>
		<br/>	
		
		<span> Kapat Butonu: </span><input type="checkbox" <?=$kapat_checked ?> name="kapat_butonu" id="kapat_butonu" value="1" /><br/>
		<span>Onay Kutusu: </span><input type="checkbox" <?=$checked ?> name="pop_durum" id="pop_durum" value="1" /><br/>

		<div class="form-actions">
			<input type="submit" name="veriyi" class="btn blue" value="Kaydet" />
		</div>
	</form>
	<style>
		.ck-editor__editable_inline {
			min-height: 200px !important;
		}
	</style>
<script>
    CKEDITOR.replace( 'icerik', {
		height: 250,
		extraPlugins: 'colorbutton,colordialog',
		removeButtons: 'PasteFromWord'	
	} );
</script>



  <div class="row-fluid">
    <div class="span6" style="background-color: #eaeaea;">
        <p name=""><?= $popup_oku["icerik"] ?></p>
    </div>
    <div class="span6">
 
    </div>
</div>








<?php
/*

 
<h3>Site Açılış Popup Uyarısı</h3>
<form name="site_popup" method="POST" enctype="multipart/form-data">
    <textarea name="icerik" class="span8" rows="10" id="icerik"></textarea>
    <label class="checkbox">
      <input type="checkbox" id="kapat_buton" onclick="deger()" name="kapat_buton" value="0"> Kapat Butonu
    </label>
    <div class="form-actions">
        <input type="submit" name="veriyi" class="btn blue" value="Kaydet" />
    </div>
</form>
<script src="https://cdn.ckeditor.com/ckeditor5/27.0.0/classic/ckeditor.js"></script>
<!-- <style>
.ck-editor__editable_inline {
    min-height: 200px !important;
}
</style> -->
<script>
    function deger(){
        console.log("sa");
        var eleman = document.getElementById('kapat_buton').value;

        if(eleman == 0){
            document.getElementById("kapat_buton").value = "1";         
        }else{
            document.getElementById("kapat_buton").value = "0";
        }
    }
</script>
<!-- <script>
      ClassicEditor
        .create( document.querySelector( '#icerik' ) )
        .then( editor => {
            console.log( editor );
        } )
        .catch( error => {
            console.error( error );
        } );
</script> -->
*/ ?>