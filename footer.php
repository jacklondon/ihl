<!-- <footer class="site-footer" style="margin-top:1%;">
    <div class="container">
      <div class="row">
        <div class="col-lg-3">
          <h2 class="footer-heading mb-4">İletişim</h2>
          <p>Adres - Çınar Mahallesi 5003/1 Sokak No:9 Ege Plaza Daire:30 Bornova / İzmir</p>
          <p>Sabit Hat - 0 (232) 503 80 13</p>
          <p>Fax ve Sms - 0 (850) 303 98 69</p>
          <p>E-mail - info@pertdunyasi.com</p>
        </div>
        <div class="col-lg-9 ml-auto">
          <div class="row">
            <div class="col-lg-3">
              <h2 class="footer-heading mb-4">Şirketimiz</h2>
              <ul class="list-unstyled">
                <li><a href="#">Hakkımızda</a></li>
                <li><a href="#">Iletisim</a></li>
                <li><a href="#">S.S.S</a></li>
              </ul>
            </div>
            <div class="col-lg-3">
              <h2 class="footer-heading mb-4">Hizmetlerimiz</h2>
              <ul class="list-unstyled">
                <li><a href="#">Doğrudan Satış</a></li>
                <li><a href="#">Aracını Sat</a></li>
                <li><a href="#">Araç Değer Tespiti</a></li>
              </ul>
            </div>
            <div class="col-lg-3">
              <h2 class="footer-heading mb-4">Bayiliklerimiz</h2>
              <ul class="list-unstyled">
                <li><a href="#">İzmir</a></li>
                <li><a href="#">İstanbul</a></li>
                <li><a href="#">Ankara</a></li>
              </ul>
            </div>
            <div class="col-lg-3">
              <h2 class="footer-heading mb-4">Yararli Linkler</h2>
              <ul class="list-unstyled">
                <li><a href="#">Kullanim Kosul ve Sartlari</a></li>
                <li><a href="#">Gizlilik</a></li>
                <li><a href="#">Site Haritası</a></li>
              </ul>
            </div>
          </div>
        </div>
      </div>
      <div class="row mt-5 text-center">
        <div class="col-md-12">
          <div class="border-top pt-5">
            <p>
              Telif hakkı &copy;
              <script>
                document.write(new Date().getFullYear());
              </script> Tüm Hakları Saklıdır <br>
              Yazılım & Tasarim <a href="https://eabilisim.net.tr/" target="_blank">EA Bilişim Teknolojileri</a>
            </p>
            <img src="images/logo2.png">
          </div>
        </div>
      </div>
    </div>
  </footer>-->
<?php
      session_start();
    include('../ayar.php');
     $token = $_SESSION['u_token'];
     $k_token = $_SESSION['k_token'];
     if($token != "" && $k_token == ""){
       $uye_token = $token;
     }elseif($token == "" && $k_token != ""){
        $uye_token = $k_token;
     }
	 $iletisim_sorgu=mysql_query("select * from iletisim");
	 $iletisim_row=mysql_fetch_object($iletisim_sorgu);
	 $iframe=$row->iframe;
	 $footer_bayiler=mysql_query("select * from bayiler");
?>
  <style>
      @media only screen and (max-width: 600px) {
  .yorumlar {
    margin-top:45% !important;
  }
  
}
  </style>
<style>
#chat-circle {
  position: fixed;
  bottom: 50px;
  right: 50px;
  background: #5A5EB9;
  width: 80px;
  height: 80px;  
  border-radius: 50%;
  color: white;
  padding: 28px;
  cursor: pointer;
  box-shadow: 0px 3px 16px 0px rgba(0, 0, 0, 0.6), 0 3px 1px -2px rgba(0, 0, 0, 0.2), 0 1px 5px 0 rgba(0, 0, 0, 0.12);
}

.btn#my-btn {
     background: white;
    padding-top: 13px;
    padding-bottom: 12px;
    border-radius: 45px;
    padding-right: 40px;
    padding-left: 40px;
    color: #5865C3;
}
#chat-overlay {
    background: rgba(255,255,255,0.1);
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    border-radius: 50%;
    display: none;
}


.chat-box {
  display:none;
  background: #efefef;
  position:fixed;
  right:30px;
  bottom:50px;  
  width:350px;
  max-width: 85vw;
  max-height:100vh;
  border-radius:5px;  
/*   box-shadow: 0px 5px 35px 9px #464a92; */
  box-shadow: 0px 5px 35px 9px #ccc;
}
.chat-box-toggle {
  float:right;
  margin-right:15px;
  cursor:pointer;
}
.chat-box-header {
  background: #5A5EB9;
  height:70px;
  border-top-left-radius:5px;
  border-top-right-radius:5px; 
  color:white;
  text-align:center;
  font-size:20px;
  padding-top:17px;
}
.chat-box-body {
  position: relative;  
  height:370px;  
  height:auto;
  border:1px solid #ccc;  
  overflow: hidden;
}
.chat-box-body:after {
  content: "";
  background-image: url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAwIiBoZWlnaHQ9IjIwMCIgdmlld0JveD0iMCAwIDIwMCAyMDAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGcgdHJhbnNmb3JtPSJ0cmFuc2xhdGUoMTAgOCkiIGZpbGw9Im5vbmUiIGZpbGwtcnVsZT0iZXZlbm9kZCI+PGNpcmNsZSBzdHJva2U9IiMwMDAiIHN0cm9rZS13aWR0aD0iMS4yNSIgY3g9IjE3NiIgY3k9IjEyIiByPSI0Ii8+PHBhdGggZD0iTTIwLjUuNWwyMyAxMW0tMjkgODRsLTMuNzkgMTAuMzc3TTI3LjAzNyAxMzEuNGw1Ljg5OCAyLjIwMy0zLjQ2IDUuOTQ3IDYuMDcyIDIuMzkyLTMuOTMzIDUuNzU4bTEyOC43MzMgMzUuMzdsLjY5My05LjMxNiAxMC4yOTIuMDUyLjQxNi05LjIyMiA5LjI3NC4zMzJNLjUgNDguNXM2LjEzMSA2LjQxMyA2Ljg0NyAxNC44MDVjLjcxNSA4LjM5My0yLjUyIDE0LjgwNi0yLjUyIDE0LjgwNk0xMjQuNTU1IDkwcy03LjQ0NCAwLTEzLjY3IDYuMTkyYy02LjIyNyA2LjE5Mi00LjgzOCAxMi4wMTItNC44MzggMTIuMDEybTIuMjQgNjguNjI2cy00LjAyNi05LjAyNS0xOC4xNDUtOS4wMjUtMTguMTQ1IDUuNy0xOC4xNDUgNS43IiBzdHJva2U9IiMwMDAiIHN0cm9rZS13aWR0aD0iMS4yNSIgc3Ryb2tlLWxpbmVjYXA9InJvdW5kIi8+PHBhdGggZD0iTTg1LjcxNiAzNi4xNDZsNS4yNDMtOS41MjFoMTEuMDkzbDUuNDE2IDkuNTIxLTUuNDEgOS4xODVIOTAuOTUzbC01LjIzNy05LjE4NXptNjMuOTA5IDE1LjQ3OWgxMC43NXYxMC43NWgtMTAuNzV6IiBzdHJva2U9IiMwMDAiIHN0cm9rZS13aWR0aD0iMS4yNSIvPjxjaXJjbGUgZmlsbD0iIzAwMCIgY3g9IjcxLjUiIGN5PSI3LjUiIHI9IjEuNSIvPjxjaXJjbGUgZmlsbD0iIzAwMCIgY3g9IjE3MC41IiBjeT0iOTUuNSIgcj0iMS41Ii8+PGNpcmNsZSBmaWxsPSIjMDAwIiBjeD0iODEuNSIgY3k9IjEzNC41IiByPSIxLjUiLz48Y2lyY2xlIGZpbGw9IiMwMDAiIGN4PSIxMy41IiBjeT0iMjMuNSIgcj0iMS41Ii8+PHBhdGggZmlsbD0iIzAwMCIgZD0iTTkzIDcxaDN2M2gtM3ptMzMgODRoM3YzaC0zem0tODUgMThoM3YzaC0zeiIvPjxwYXRoIGQ9Ik0zOS4zODQgNTEuMTIybDUuNzU4LTQuNDU0IDYuNDUzIDQuMjA1LTIuMjk0IDcuMzYzaC03Ljc5bC0yLjEyNy03LjExNHpNMTMwLjE5NSA0LjAzbDEzLjgzIDUuMDYyLTEwLjA5IDcuMDQ4LTMuNzQtMTIuMTF6bS04MyA5NWwxNC44MyA1LjQyOS0xMC44MiA3LjU1Ny00LjAxLTEyLjk4N3pNNS4yMTMgMTYxLjQ5NWwxMS4zMjggMjAuODk3TDIuMjY1IDE4MGwyLjk0OC0xOC41MDV6IiBzdHJva2U9IiMwMDAiIHN0cm9rZS13aWR0aD0iMS4yNSIvPjxwYXRoIGQ9Ik0xNDkuMDUgMTI3LjQ2OHMtLjUxIDIuMTgzLjk5NSAzLjM2NmMxLjU2IDEuMjI2IDguNjQyLTEuODk1IDMuOTY3LTcuNzg1LTIuMzY3LTIuNDc3LTYuNS0zLjIyNi05LjMzIDAtNS4yMDggNS45MzYgMCAxNy41MSAxMS42MSAxMy43MyAxMi40NTgtNi4yNTcgNS42MzMtMjEuNjU2LTUuMDczLTIyLjY1NC02LjYwMi0uNjA2LTE0LjA0MyAxLjc1Ni0xNi4xNTcgMTAuMjY4LTEuNzE4IDYuOTIgMS41ODQgMTcuMzg3IDEyLjQ1IDIwLjQ3NiAxMC44NjYgMy4wOSAxOS4zMzEtNC4zMSAxOS4zMzEtNC4zMSIgc3Ryb2tlPSIjMDAwIiBzdHJva2Utd2lkdGg9IjEuMjUiIHN0cm9rZS1saW5lY2FwPSJyb3VuZCIvPjwvZz48L3N2Zz4=');
  opacity: 0.1;
  top: 0;
  left: 0;
  bottom: 0;
  right: 0;
  height:100%;
  position: absolute;
  z-index: -1;   
}
#chat-input {
  background: #f4f7f9;
  width:100%; 
  position:relative;
  height:47px;  
  padding-top:10px;
  padding-right:50px;
  padding-bottom:10px;
  padding-left:15px;
  border:none;
  resize:none;
  outline:none;
  border:1px solid #ccc;
  color:#888;
  border-top:none;
  border-bottom-right-radius:5px;
  border-bottom-left-radius:5px;
  overflow:hidden;  
}
.chat-input > form {
  margin-bottom: 0;
}
#chat-input::-webkit-input-placeholder { /* Chrome/Opera/Safari */
  color: #ccc;
}
#chat-input::-moz-placeholder { /* Firefox 19+ */
  color: #ccc;
}
#chat-input:-ms-input-placeholder { /* IE 10+ */
  color: #ccc;
}
#chat-input:-moz-placeholder { /* Firefox 18- */
  color: #ccc;
}
.chat-submit {  
  position:absolute;
  bottom:3px;
  right:10px;
  background: transparent;
  box-shadow:none;
  border:none;
  border-radius:50%;
  color:#5A5EB9;
  width:35px;
  height:35px;  
}
.chat-logs {
  padding:15px; 
  height:370px;
  overflow-y:scroll;
}
.chat-logs::-webkit-scrollbar-track
{
	-webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
	background-color: #F5F5F5;
}
.chat-logs::-webkit-scrollbar
{
	width: 5px;  
	background-color: #F5F5F5;
}
.chat-logs::-webkit-scrollbar-thumb
{
	background-color: #5A5EB9;
}
@media only screen and (max-width: 500px) {
  .chat-logs {
      height:40vh;
  }
}
.chat-msg.user > .msg-avatar img {
  width:45px;
  height:45px;
  border-radius:50%;
  float:left;
  width:15%;
}
.chat-msg.self > .msg-avatar img {
  width:45px;
  height:45px;
  border-radius:50%;
  float:right;
  width:15%;
}
.cm-msg-text {
  background:white;
  padding:10px 15px 10px 15px;  
  color:#666;
  max-width:75%;
  float:left;
  margin-left:10px; 
  position:relative;
  margin-bottom:20px;
  border-radius:30px;
}
.chat-msg {
  clear:both;    
}
.chat-msg.self > .cm-msg-text {  
  float:right;
  margin-right:10px;
  background: #5A5EB9;
  color:white;
}
.cm-msg-button>ul>li {
  list-style:none;
  float:left;
  width:50%;
}
.cm-msg-button {
  clear: both;
  margin-bottom: 70px;
}
  </style>
 <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<!-- <footer class="site-footer"  style="margin-top:1%;"> -->
<footer class="site-footer">
    <div class="container">
      <div class="row">
        <div class="col-lg-3">
          <h2 class="footer-heading mb-4">İletişim</h2>
          <p>Adres : <?=$iletisim_row->adres ?></p>
          <p>Sabit Hat : <?=$iletisim_row->sabit_hat ?></p>
          <p>Telefon : <?=$iletisim_row->telefon ?></p>
          <p>Fax ve Sms : <?=$iletisim_row->fax_sms ?></p>
          <p>E-mail : <?=$iletisim_row->email ?></p>
          <style>
            .footer_social_outer
            {
              min-height:10px;
              float:left;
              padding:0px;
              margin-bottom:30px;
            }

            .social_box
            {
              width:40px;
              height:40px;
              float:left;
              background-color:#ffffff38;
              margin-right:10px;
              border-radius:50%;
              display:flex;
              align-items:center;
              justify-content:center;
              border:1px solid #ffffff7a;
              color:#ffffff;
              cursor:pointer;
            }
          </style>
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 footer_social_outer">
            <a class="social_box" href="<?= $iletisim_row->facebook ?>" target="_blank">
              <i class="fab fa-facebook-f"></i>
            </a>
            <a class="social_box" href="<?= $iletisim_row->twitter ?>" target="_blank">
              <i class="fab fa-twitter"></i>
            </a>
            <a class="social_box" href="<?= $iletisim_row->instagram ?>" target="_blank">
              <i class="fab fa-instagram"></i>
            </a>
            <a class="social_box" href="<?= $iletisim_row->youtube ?>" target="_blank">
              <i class="fab fa-youtube"></i>
            </a>
          </div>
        </div>
        <div class="col-lg-9 ml-auto">
          <div class="row">
            <div class="col-lg-3">
              <h2 class="footer-heading mb-4">Şirketimiz</h2>
              <ul class="list-unstyled">
                <li><a href="about.php">Hakkımızda</a></li>
                <li><a href="contact.php">Iletisim</a></li>
				 <li><a href="hesaplarimiz.php">Banka Hesaplarımız</a></li>
                <li><a href="sss.php">S.S.S</a></li>
              </ul>
            </div>
            <div class="col-lg-3">
              <h2 class="footer-heading mb-4">Hizmetlerimiz</h2>
              <ul class="list-unstyled">
                <li><a href="dogrudan_satisli_araclar.php">Doğrudan Satış</a></li>
                <?php if($k_token == "") {?>
                  <li><a href="uye_panel/yeni_ilan_ekle.php">Aracını Sat</a></li>
                <?php } else {?>
                  <li><a href="kurumsal_panel/yeni_ilan_ekle.php">Aracını Sat</a></li>
                <?php } ?>
                <li><a href="ihaledeki_araclar.php">İhale ile Satış</a></li>
              </ul>
            </div>
            <div class="col-lg-3">
              <h2 class="footer-heading mb-4">Bayiliklerimiz</h2>
              <ul class="list-unstyled">
				<?php while($bayiler_row=mysql_fetch_object($footer_bayiler)){?>
                <li><a href=""><?=$bayiler_row->bayi_adi ?></a></li>
				<?php } ?>

        <?php 
        $yararli_link_cek = mysql_query("select * from yararli_linkler where status = 1");
        while($yararli_link_oku = mysql_fetch_object($yararli_link_cek)){
          $yararli_linkler .= '<li><a href="'.$yararli_link_oku->link.'">'.$yararli_link_oku->name.'</a></li>';
        }
        ?>

              </ul>
            </div>
            <div class="col-lg-3">
              <h2 class="footer-heading mb-4">Yararli Linkler</h2>
              <ul class="list-unstyled">
            	<?php $pdf_kks_cek=mysql_fetch_object(mysql_query("select * from pdf")) ?>
                <li><a href="<?=$pdf_kks_cek->kullanim_sartlari ?>">Kullanim Kosul ve Sartlari</a></li>
                <?= $yararli_linkler ?>
              </ul>
            </div>
          </div>
        </div>
      </div>
      <div class="row mt-5 text-center">
        <div class="col-md-12">
          <div class="border-top pt-5">
            <p>
              <!-- Telif hakkı --> &copy;
              <script>
                document.write(new Date().getFullYear());
              </script> Tüm Hakları Saklıdır <br>
              <!-- Yazılım & Tasarim <a href="https://eabilisim.net.tr/" target="_blank">EA Bilişim Teknolojileri</a> -->
            </p>
            <!-- <img src="images/logo2.png"> -->
          </div>
        </div>
      </div>
    </div>
    <!--<div id="chat-circle" class="btn btn-raised" style="z-index: 999999999999999;">
      <div id="chat-overlay"></div>
      <i class="material-icons">speaker_phone</i>
	</div>
  <div class="chat-box" style="z-index: 999999999999999;">
    <div class="chat-box-header">
      Canlı Destek
      <span class="chat-box-toggle"><i class="material-icons">close</i></span>
    </div>
    <div class="chat-box-body">
      <div class="chat-box-overlay">   
      </div>
      <div class="chat-logs">
       
      </div>
    </div>
    <div class="chat-input">      
      <form>
        <input type="text" id="chat-input" placeholder="Mesajınızı Yazın..."/>
      <button type="submit" class="chat-submit" id="chat-submit" onclick="canli_chat_sor()"><i class="material-icons">send</i></button>
      </form>      
    </div>
  </div>-->

  </footer>
  <script>
    $(function() {
  var INDEX = 0; 
  $("#chat-submit").click(function(e) {
    e.preventDefault();
    var msg = $("#chat-input").val(); 
    if(msg.trim() == ''){
      return false;
    }
    generate_message(msg, 'self');
    var buttons = [
        {
          name: 'Existing User',
          value: 'existing'
        },
        {
          name: 'New User',
          value: 'new'
        }
      ];
    setTimeout(function() {      
      generate_message(msg, 'user');  
    }, 1000)
    
  })
 
   
  
  function generate_button_message(msg, buttons){    
    /* Buttons should be object array 
      [
        {
          name: 'Existing User',
          value: 'existing'
        },
        {
          name: 'New User',
          value: 'new'
        }
      ]
    */
    INDEX++;
    var btn_obj = buttons.map(function(button) {
       return  "              <li class=\"button\"><a href=\"javascript:;\" class=\"btn btn-primary chat-btn\" chat-value=\""+button.value+"\">"+button.name+"<\/a><\/li>";
    }).join('');
    var str="";
    str += "<div id='cm-msg-"+INDEX+"' class=chat-msg user>";
   
    str += "          <div class=\"cm-msg-text\">";
    str += msg;
    str += "          <\/div>";
    str += "          <div class=\"cm-msg-button\">";
    str += "            <ul>";   
    str += btn_obj;
    str += "            <\/ul>";
    str += "          <\/div>";
    str += "        <\/div>";
    $(".chat-logs").append(str);
    $("#cm-msg-"+INDEX).hide().fadeIn(300);   
    $(".chat-logs").stop().animate({ scrollTop: $(".chat-logs")[0].scrollHeight}, 1000);
    $("#chat-input").attr("disabled", true);
  }
  
  $(document).delegate(".chat-btn", "click", function() {
    var value = $(this).attr("chat-value");
    var name = $(this).html();
    $("#chat-input").attr("disabled", false);
    generate_message(name, 'self');
  })
  
  $("#chat-circle").click(function() {    
    $("#chat-circle").toggle('scale');
    $(".chat-box").toggle('scale');
  })
  
  $(".chat-box-toggle").click(function() {
    $("#chat-circle").toggle('scale');
    $(".chat-box").toggle('scale');
  })
  
})
  </script>
<!--Start of Tawk.to Script-->
<script type="text/javascript">
var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
(function(){
var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
s1.async=true;
s1.src='https://embed.tawk.to/616575c7157d100a41ac02fd/1fhq58579';
s1.charset='UTF-8';
s1.setAttribute('crossorigin','*');
s0.parentNode.insertBefore(s1,s0);
})();
</script>
<!--End of Tawk.to Script-->


<script>
  $(document).ready(function() {
    $('input[type="date"]').attr({
      "max" : "9999-12-31"
    });
  });
</script>