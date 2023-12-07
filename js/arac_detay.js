//TEKLİF VERME
function modalGonder(){
    var modalTeklif = $('#sonTeklif').val();
    document.getElementById("modalTeklif").innerHTML = modalTeklif;
    }
     function denem(){
        
          var girilen_teklif = $("#girilen_teklif").val();
          var kullaniciToken = $('#kullaniciToken').val();
          
          var ilanID = $('#ilanID').val();
          var uyeID = $('#uyeID').val();
          document.getElementById("verilen_teklif").innerHTML = girilen_teklif;         
                   
          var verilen_teklif = $('#verilen_teklif').val();
             if (verilen_teklif == '') {
                 alert('Lütfen teklifinizi giriniz.');
             }else {
                 $.ajax({
                     url: 'teklif_ver.php',
                     method: 'post',
                     data: {
                      verilen_teklif: verilen_teklif,
                      kullaniciToken: kullaniciToken,
                      ilanID: ilanID,
                      uyeID: uyeID
                     },
                     success: function(data) {
                         $('.success').removeClass('d-none').html(data);
                         alert('Teklifiniz başarılı bir şekilde iletildi.');
                         location.reload();
                     },
                     error: function(data) {
                         $('.error').removeClass('d-none').html(data);
                         alert('HATA! Lütfen tekrar deneyiniz.')
                     }
                 });
             }
       }

       function kontrol(){
        var kullaniciToken = $('#kullaniciToken').val();
        if(kullaniciToken){ 
           return;
        }else{ 
           alert("Devam Etmek İçin Lütfen Giriş Yapın !");
           window.location.href = "index.php"
        }
     }

     //Mesaj Gönderme
   function mesajGonder(){
    var gonderilecek_mesaj = $("#gonderilecek_mesaj").val();
    var kullaniciToken = $('#kullaniciToken').val();
    var ilanID = $('#ilanID').val();
    var uyeID = $('#uyeID').val();
    var ihaleSahibi = $('#ihaleSahibi').val();

    if (gonderilecek_mesaj == '') {
          alert('Lütfen Mesajınızı Giriniz.');
    }else {
          $.ajax({
             url: 'mesaj_gonder.php',
             method: 'POST',
             data: {
             gonderilecek_mesaj: gonderilecek_mesaj,
             kullaniciToken: kullaniciToken,
             ilanID: ilanID,
             uyeID: uyeID,
             ihaleSahibi: ihaleSahibi
             },
             success: function(data) {
                $('.success').removeClass('d-none').html(data);
                alert("Mesajınız başarılı bir şekilde gönderildi");
             },
             error: function(data) {
                $('.error').removeClass('d-none').html(data);
                alert('HATA! Lütfen tekrar deneyiniz.')
             }
          });
    }

}

var i = document.getElementById('sonTeklif').value;
var plus = parseInt(i);
   function buttonClick() {
     plus += 250;
       document.getElementById('girilen_teklif').value = plus;
   }
   function ButtonClick() {
     plus += 500;
       document.getElementById('girilen_teklif').value = plus;
   }
   function clickButton() {
     plus += 750;
       document.getElementById('girilen_teklif').value = plus;
   }
   function ClickButton() {
     plus += 1000;
       document.getElementById('girilen_teklif').value = plus;
   }

   function degerOku(){
    var deger = document.getElementById('girilen_teklif').value;
    var input = document.getElementById('verilen_teklif').value=deger;
    document.getElementById("GelenTeklif").innerHTML = deger;
 }

 function isNumberKey(evt) {
    var charCode = (evt.which) ? evt.which : event.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
    return true;
    }

    var slideIndex = 1;
    showSlides(slideIndex);
    
    function plusSlides(n) {
      showSlides(slideIndex += n);
    }
    
    function currentSlide(n) {
      showSlides(slideIndex = n);
    }
    
    function showSlides(n) {
      var i;
      var slides = document.getElementsByClassName("mySlides");
      var dots = document.getElementsByClassName("demo");
      var captionText = document.getElementById("caption");
      if (n > slides.length) {slideIndex = 1}
      if (n < 1) {slideIndex = slides.length}
      for (i = 0; i < slides.length; i++) {
          slides[i].style.display = "none";
      }
      for (i = 0; i < dots.length; i++) {
          dots[i].className = dots[i].className.replace(" active", "");
      }
      slides[slideIndex-1].style.display = "block";
      dots[slideIndex-1].className += " active";
      captionText.innerHTML = dots[slideIndex-1].alt;
    }

