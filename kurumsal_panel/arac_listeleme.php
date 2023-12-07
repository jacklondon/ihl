<?php 
   session_start();
   include('../ayar.php');
    $token = $_SESSION['k_token'];
    if(!empty($token)){
      $uye_token = $token;
    }
    if(!isset($_SESSION['k_token'])){
      echo '<script>alert("Devam Etmek İçin Lütfen Giriş Yapın !")</script>';
      echo '<script>window.location.href = "../index.php"</script>';
      }

?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <link rel="stylesheet" href="css/menu.css">
    <!-- <title>Pert Dünyası</title> -->
    <?php
			include '../seo_kelimeler.php';
		?>
  </head>
  <body>
      <div class="container">
          <div class="row">
              <div class="col-sm-3">
                <form>
                    <label for="sehir">Şehir</label>
                    <div class="form-group">                        
                        <select class="form-control" name="sehir" id="sehir">
                            <option value="0">şehir seçin..</option>
                            <option value="izmir">İzmir</option>
                            <option value="ankara">Ankara</option>
                            <option value="istanbul">İstanbul</option>
                        </select>
                    </div>
                    <h5>EVRAK DURUMU</h5>
                    <div class="form-group">                        
                        <input type="checkbox" name="cekme_pert"> Çekme Belgeli / Pert Kayıtlı 
                    </div>
                    <div class="form-group">                        
                        <input type="checkbox" name="cekme_belgeli"> Çekme Belgeli 
                    </div>
                    <div class="form-group">                        
                        <input type="checkbox" name="plakali"> Plakalı
                    </div>
                    <div class="form-group">                        
                        <input type="checkbox" name="hurda_belgeli"> Hurda Belgeli
                    </div>
                    <h5>MODEL YILI</h5>
                    <div class="form-group">                        
                        <input type="checkbox" name="2021"> 2021 
                    </div>
                    <div class="form-group">                        
                        <input type="checkbox" name="2020"> 2020
                    </div>
                    <div class="form-group">                        
                        <input type="checkbox" name="2019"> 2019
                    </div>
                    <div class="form-group">                        
                        <input type="checkbox" name="2018"> 2018
                    </div>
                    <h5>MARKA</h5>
                    <div class="form-group">                        
                        <input type="checkbox" name="opel"> OPEL 
                    </div>
                    <div class="form-group">                        
                        <input type="checkbox" name="bmw"> BMW
                    </div>
                    <div class="form-group">                        
                        <input type="checkbox" name="audi"> AUDI
                    </div>
                    <div class="form-group">                        
                        <input type="checkbox" name="mercedes"> MERCEDES
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
              </div>
          </div>
      </div>
<style>
    .scroll { border:2px solid #ccc; width:300px; height: 100px; overflow-y: scroll;}
</style>
      <div class="scroll">
    <input type="checkbox" /> This is checkbox <br />
    <input type="checkbox" /> This is checkbox <br />
    <input type="checkbox" /> This is checkbox <br />
    <input type="checkbox" /> This is checkbox <br />
    <input type="checkbox" /> This is checkbox <br />
    <input type="checkbox" /> This is checkbox <br />
    <input type="checkbox" /> This is checkbox <br />
    <input type="checkbox" /> This is checkbox <br />
    <input type="checkbox" /> This is checkbox <br />
    <input type="checkbox" /> This is checkbox <br />
</div>
<?php include 'template/footer.php'; ?>
    <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js" integrity="sha384-+YQ4JLhjyBLPDQt//I+STsc9iw4uQqACwlvpslubQzn4u2UU2UFM80nGisd026JF" crossorigin="anonymous"></script>
    -->
	     <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	  <script src="../js/cikis_yap.js?v=<?php echo time(); ?>"></script>
		<script >

		</script>

  </body>
</html>