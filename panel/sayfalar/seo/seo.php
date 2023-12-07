<?php 
$seo_cek = mysql_query("select * from seo_kelimeler");
$seo_oku = mysql_fetch_assoc($seo_cek);
?>
<form method="POST" id="form" name="form" enctype="multipart/form-data" >
   <div class="row-fluid">
      <div class="span12">
         <div class="portlet box blue">
            <div class="portlet-title">
               <h4><i class="icon-reorder"></i>Site Ayarları</h4>
               <!-- <div class="tools" style="margin-top: -2px;">
                  <a href="?modul=ayarlar&sayfa=markalar" class="btn mini green" style="background-color: #006710;">
                  Markaları Gör
                  </a>
               </div> -->
            </div>
            <div class="portlet-body form">
               <!-- BEGIN FORM-->
               <div class="form-horizontal">
               <div class="control-group">     
               <div class="control-group">                    
                     <label class="control-label">Title</label>
                     <div class="controls">
                     <label for="exampleFormControlFile1"></label>
                     <input type="text" class="span6 m-wrap" name="title" value="<?= $seo_oku['title'] ?>"  />   
                     <span class="help-block">Site Başlığı</span>                    
                     </div>
                  </div> 
               <div class="control-group">                    
                     <label class="control-label">Yazar</label>
                     <div class="controls">
                     <label for="exampleFormControlFile1"></label>
                     <input type="text" class="span6 m-wrap" name="author" value="<?= $seo_oku['author'] ?>"  />   
                     <span class="help-block">Site Yazarı</span>                        
                     </div>
                  </div> 
               <div class="control-group">                    
                     <label class="control-label">Abstract</label>
                     <div class="controls">
                     <label for="exampleFormControlFile1"></label>
                     <input type="text" class="span6 m-wrap" name="abstract" value="<?= $seo_oku['abstract'] ?>"  />  
                     <span class="help-block">Site hakkında bilgi içeren bir cümle</span>     
                                         
                     </div>
                  </div> 
               <div class="control-group">                    
                     <label class="control-label">Description </label>
                     <div class="controls">
                     <label for="exampleFormControlFile1"></label>
                     <textarea name="description" id="description" class="span6 m-wrap" rows="4"><?= $seo_oku['description'] ?></textarea>
                     <span class="help-block">Site hakkında bilgi içeren kısa bir cümle</span>                        
                     </div>
                  </div> 
                  <div class="control-group">                    
                     <label class="control-label">Anahtar Sözcükler</label>
                     <div class="controls">
                     <label for="exampleFormControlFile1"></label>
                     <input type="text" class="span6 m-wrap" name="keywords" value="<?= $seo_oku['keywords'] ?>"  />   
                     <span class="help-block">Sitenizi tanımlayan anahtar kelimeler (Virgül ile ayırınız)</span>                       
                     </div>
                  </div> 

                  <div class="form-actions">
                     <input type="submit" class="btn-primary btn-block" name="iletisimi" value="Kaydet">
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   </div>
</form>
<script src="https://code.jquery.com/jquery-3.6.0.js"></script>

<?php if(re('iletisimi')=="Kaydet"){
    mysql_query("UPDATE `seo_kelimeler` SET `title` = '".re('title')."', `author` = '".re('author')."', `abstract` = '".re('abstract')."', 
    `description` = '".re('description')."', `keywords` = '".re('keywords')."' WHERE `seo_kelimeler`.`id` = 1;");
    echo'<script>alert("Başarıyla Güncellendi")</script>';
    echo "<script>window.location.href = '?modul=seo&sayfa=seo';</script>";
} ?>
