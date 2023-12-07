

function mesajlasma_veri_cek(ele=localStorage.getItem("val")){

   var $baseUrl = "https://ihale.pertdunyasi.com/uye_panel/";
   var $konum=$("#mesaj");
    var $html='';

    var val=ele.value;
    if(val==undefined)
    {
       val=localStorage.getItem("val");
    }
    var token=$('#msj_gndrn_tkn').val();

    localStorage.setItem("val",val);

    jQuery.ajax({
      url: $baseUrl+"get_veri.php",
      type: "POST",
      dataType: "JSON",
      data: {
          action: "mesajlasma",
          value:val,
          tkn_:token
      },    
      success: function(response) {
       jQuery.each(response.data, function(index, value) {     
         if(value.konum=="sag")
         {
            $html += '  <div class="direct-chat-msg"><div class="direct-chat-info clearfix">';                          
            $html += '  <span class="direct-chat-name pull-left">Siz</span>';  
            $html += '  <span class="direct-chat-timestamp pull-right">'+value.gonderme_zamani+'</span>';   
            $html += '   </div><div class="direct-chat-text"> '+value.mesajlar+'</div>   </div>';                          
         }
         else
         {
            $html += '  <div class="direct-chat-msg right"><div class="direct-chat-info clearfix">';                          
            $html += ' <span class="direct-chat-name pull-right">'+value.gonderen+'</span>';  
            $html += '  <span class="direct-chat-timestamp pull-left">'+value.gonderme_zamani+'</span></div>';   
            $html += ' <div class="direct-chat-text">'+value.mesajlar+'</div>  </div>';               
         }
   });
         $konum.html($html);
         // $konum.find("div").html($html);
      },
      complete: function(response) {       
      }
  });
}
$(document).on("click", "#mesaj_gndr_btn", function() { 
   var $baseUrl = "https://ihale.pertdunyasi.com/uye_panel/";
   var val=localStorage.getItem("val");
   var msj_icerik=$('#msj_icerik').val(); 
     
       jQuery.ajax({
           url: $baseUrl + "get_veri.php",
           type: "POST",
           dataType: "JSON",
           data: {
               action: "mesaj_gonder",              
               icerik:msj_icerik,  
               value:val        
           },
           success: function(response) {  
				mesajlasma_veri_cek();
               if (response.status == 200) {
                  $("#msj_icerik").val("");
               }
           }        
       });     
});



  

   

