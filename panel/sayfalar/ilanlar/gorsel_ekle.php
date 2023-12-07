<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<style>
   .files input {
   outline: 2px dashed red;
   outline-offset: -10px;
   -webkit-transition: outline-offset .15s ease-in-out, background-color .15s linear;
   transition: outline-offset .15s ease-in-out, background-color .15s linear;
   padding: 120px 0px 85px 35%;
   text-align: center !important;
   margin: 0;
   width: 100% !important;
   }
   .files input:focus{     outline: 2px dashed #92b0b3;  outline-offset: -10px;
   -webkit-transition: outline-offset .15s ease-in-out, background-color .15s linear;
   transition: outline-offset .15s ease-in-out, background-color .15s linear; border:1px solid #92b0b3;
   }
   .files{ position:relative}
   .files:after {  pointer-events: none;
   position: absolute;
   top: 60px;
   left: 0;
   width: 50px;
   right: 0;
   height: 56px;
   content: "";
   background-image: url(images/dosya_yukleme.png);
   display: block;
   margin: 0 auto;
   background-size: 100%;
   background-repeat: no-repeat;
   }
   .color input{ background-color:#f1f1f1;}
   .files:before {
   position: absolute;
   bottom: 10px;
   left: 0;  pointer-events: none;
   width: 100%;
   right: 0;
   height: 57px;
   content: "veya Dosyaları buraya sürükle bırak yapabilirsiniz ";
   display: block;
   margin: 0 auto;
   color: red;
   font-weight: 600;
   text-align: center;
   }
</style>
<div class="row" style="margin-right: 2% !important; margin-left: 2% !important; width:96% !important;">
            <input type="submit" class="btn" value="Bütün Resimleri Sil" style="background-color: rgb(251,57,122); color:white;">
            <form method="post" action="#" id="#" style="margin-top:20px;">
               <div class="form-group files color">
                  <input type="file" class="form-control" multiple="">
               </div>
            </form>
            <div class="row" style="margin-left:1px;">
               <ul class="thumbnails">
                  <li class="span4">
                     <a href="#" class="thumbnail">
                     <img src="https://cdn.ototeknikveri.com/Files/News/Big/345opel-astra-da-2014-yenilikleri-16-dizel-cdti-ve-intellilink.jpg"alt="">
                     </a>
                  </li>
               </ul>
            </div>
            <div class="row" style="margin-left:1px;">
               <div class="span3"><input type="submit" value="Ana Resim Yap" class="btn blue"></div>
               <div class="span1"><input type="submit" value="Sil" class="btn" style="background-color: rgb(251,57,122); color:white;"></div>
            </div>
         </div>
