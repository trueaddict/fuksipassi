<?php
  include('config/db_connect.php');

  //session_start();
  if (isset($_SESSION['usermail'])) {
    $sql2 = "SELECT * FROM kayttajat WHERE mail = ?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql2)) {
      header("Location: ../index.php?error=sqlerror");
      exit();
    }
    else {
      mysqli_stmt_bind_param($stmt, "s", $_SESSION['usermail']);
      mysqli_stmt_execute($stmt);
      $result2 = mysqli_stmt_get_result($stmt);
      if ($kayttaja = mysqli_fetch_assoc($result2)) {
        //echo "kayttaja ok";
      }

    }


    $sql = 'SELECT kuvaus, id_teht_nro FROM tehtavat';

    $result = mysqli_query($conn, $sql);
    $tehtavat = mysqli_fetch_all($result, MYSQLI_ASSOC);

    mysqli_free_result($result);
    mysqli_free_result($result2);
    mysqli_close($conn);


    // Lasketaan monta käyttäjä on suorittanut

      $suoritettu = $kayttaja['suoritettu'];
      $suoritettu_perus = 0;
      $suoritettu_aine = 0;
      $suoritettu_syv = 0;
      $suoritettu_yleis = 0;

      for ($i = 0; $i <= 24; $i++) {
        if ($suoritettu[$i] == 1) $suoritettu_perus += 1;
      }

      for ($i = 25; $i <= 84; $i++) {
        if ($suoritettu[$i] == 1) $suoritettu_aine += 1;
      }

      for ($i = 85; $i <= 134; $i++) {
        if ($suoritettu[$i] == 1) $suoritettu_syv += 1;
      }

      for ($i = 135; $i <= 179; $i++) {
        if ($suoritettu[$i] == 1) $suoritettu_yleis += 1;
      }

    ?>

    <!DOCTYPE html>
    <html lang="fi">

    <?php
      if (isset($_GET['signup'])) {
        if ($_GET['signup'] == "success") { ?>

          <div class="policy">
            <h5 class="center gray-text">Luodaanko uusi käyttäjä?</h5>
            <p class="center gray-text">Luomalla käyttäjän hyväksyt palvelun käyttöehdot sekä <a href="./frontpage/tietosuoja">rekisteri- ja tietosuojaselosteen</a></p>
            <p class="center brand-text"><?php echo $_SESSION['usermail'] ?></p>
              <div class="center">
                <a href="index.php"><button class="btn">Kyllä</button></a>
                <form class="kuittaus" action="includes/signout.inc.php" method="post">
                <input type="hidden" name="signout-email" value="<?php echo $_SESSION['usermail'] ?>">
                <input type="submit" name="signout-submit" value="Ei" class="btn">

                  </form>
              </div>
           </div>
           <div class="policy-background">

           </div>
        <?php }
      }

     ?>

      <?php
      include('templates/header.php');?>
      <div class="center container">
        <p class="brand-text">Tervetuloa Syrinxin fuksipassin pariin! Tämä ”opintokokonaisuus” on luotu tekemään
          fuksisyksystäsi niin opettavainen ja ikimuistoinen kuin mahdollista. Tehtävien
          suorittamisen voivat kuitata vain tutorit sekä Syrinxin hallituslaiset ja kuittausta varten on
          aina oltava jonkinlainen todiste tehtävän suorittamisesta.</p>
        <p class="brand-text">Tartu siis tilaisuuteen ja ala täyttää fuksipassiasi heti syksyn alussa, niin saat kerättyä
          mahdollisimman paljon merkintöjä Syrinxin pikkujouluihin mennessä. Eniten suorituksia
          kerännyt fuksi palkitaan Syrinxin pikkujouluissa ainutlaatuisella Syrren SuperFuksi -
          arvonimellä ja haalarimerkillä sekä kaikki vähintään 75 % tehtävistä suorittaneet Syrren
          AktiiviFuksi -arvonimellä ja haalarimerkillä!</p>
        <p class="brand-text">Antoisaa fuksisyksyä!</p>
      </div>
      <h2 class="center gray-text">Tehtävät</h2>

      <div class="container">
        <div class="row">
          <div class="col s12">
            <div class="center">
              <button class="accordion"><h4>Perusopinnot</h4><br><h5><?php echo $suoritettu_perus ?> / 25</h5></button>
              <div class="panel">
                <div class="">
                  <div class="row">
                    <?php $suoritettu = $kayttaja['suoritettu']; $teht_numero = 1;?>
                      <?php for ($i = 0; $i <= 24; $i++):
                        $tehtava = $tehtavat[$i];
                        ?>
                        <div class="col s12 m12 l6">
                          <div class="card z-depth-0">
                            <div class="card-content center">
                              <h3>Tehtävä <?php echo $teht_numero; $teht_numero++; ?></h3>
                              <h5 class=""><?php echo $tehtava['kuvaus'] ?></h5>
                            </div>
                            <?php if($suoritettu[$tehtava['id_teht_nro'] - 1] == 0):?>
                              <div class="card-action center">
                                <a href="check.php?id_teht_nro=<?php echo $tehtava['id_teht_nro']?>" class="btn yellow darken-2"><h6 class="brand-text">Kuittaa</h6></a>
                              </div>
                            <?php else: ?>
                              <div class="card-action center">
                                <a href="#" class="btn btn-suoritettu brand-text">Suoritettu</a>
                              </div>
                            <?php endif; ?>
                          </div>
                        </div>
                    <?php endfor; ?>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col s12">
            <div class="center">
              <button class="accordion"><h4>Aineopinnot</h4><br><h5><?php echo $suoritettu_aine ?> / 60</h5></button>
              <div class="panel">
                <div class="">
                  <div class="row">
                    <?php $suoritettu = $kayttaja['suoritettu']; $teht_numero = 1;?>
                      <?php for ($i = 25; $i <= 84; $i++):
                        $tehtava = $tehtavat[$i];
                        ?>
                        <div class="col s12 m12 l6">
                          <div class="card z-depth-0">
                            <div class="card-content center">
                              <h3>Tehtävä <?php echo $teht_numero; $teht_numero++; ?></h3>
                              <h5 class=""><?php echo $tehtava['kuvaus'] ?></h5>
                            </div>
                            <?php if($suoritettu[$tehtava['id_teht_nro'] - 1] == 0):?>
                              <div class="card-action center">
                                <a href="check.php?id_teht_nro=<?php echo $tehtava['id_teht_nro']?>" class="btn brand-text yellow darken-2">Kuittaa</a>
                              </div>
                            <?php else: ?>
                              <div class="card-action center">
                                <a href="#" class="btn btn-suoritettu brand-text">Suoritettu</a>
                              </div>
                            <?php endif; ?>
                          </div>
                        </div>
                    <?php endfor; ?>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col s12">
            <div class="center">
              <button class="accordion"><h4>Syventävät opinnot</h4><br><h5><?php echo $suoritettu_syv ?> / 50</h5></button>
              <div class="panel" id="syv">
                <div class="">
                  <div class="row">
                    <?php $suoritettu = $kayttaja['suoritettu']; $teht_numero = 1;?>
                      <?php for ($i = 85; $i <= 134; $i++):
                        $tehtava = $tehtavat[$i];
                        ?>
                        <div class="col s12 m12 l6">
                          <div class="card z-depth-0">
                            <div class="card-content center">
                              <h3>Tehtävä <?php echo $teht_numero; $teht_numero++; ?></h3>
                              <h5 class=""><?php echo $tehtava['kuvaus'] ?></h5>
                            </div>
                            <?php if($suoritettu[$tehtava['id_teht_nro'] - 1] == 0):?>
                              <div class="card-action center">
                                <a href="check.php?id_teht_nro=<?php echo $tehtava['id_teht_nro']?>" class="btn brand-text yellow darken-2">Kuittaa</a>
                              </div>
                            <?php else: ?>
                              <div class="card-action center">
                                <a href="#" class="btn btn-suoritettu brand-text">Suoritettu</a>
                              </div>
                            <?php endif; ?>
                          </div>
                        </div>
                    <?php endfor; ?>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col s12">
            <div class="center">
              <button class="accordion"><h4>Yleisopinnot</h4><br><h5><?php echo $suoritettu_yleis ?> / 45</h5></button>
              <div class="panel">

                <div class="">
                  <div class="row">
                    <?php $suoritettu = $kayttaja['suoritettu']; $teht_numero = 1;?>
                      <?php for ($i = 135; $i <= 179; $i++):
                        $tehtava = $tehtavat[$i];
                        ?>
                        <div class="col s12 m12 l6">
                          <div class="card z-depth-0">
                            <div class="card-content center">
                              <h3>Tehtävä <?php echo $teht_numero; $teht_numero++; ?></h3>
                              <h5 class=""><?php echo $tehtava['kuvaus'] ?></h5>
                            </div>
                            <?php if($suoritettu[$tehtava['id_teht_nro'] - 1] == 0):?>
                              <div class="card-action center">
                                <a href="check.php?id_teht_nro=<?php echo $tehtava['id_teht_nro']?>" class="btn brand-text yellow darken-2">Kuittaa</a>
                              </div>
                            <?php else: ?>
                              <div class="card-action center">
                                <a href="#" class="btn btn-suoritettu brand-text">Suoritettu</a>
                              </div>
                            <?php endif; ?>
                          </div>
                        </div>
                    <?php endfor; ?>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>


      <script type="text/javascript">

        var accordions=document.querySelectorAll("button.accordion");

        for(var i=0; i < accordions.length; i++) {
          accordions[i].onclick=function(){
            this.classList.toggle("active");
            this.nextElementSibling.classList.toggle("show");
          }
        }
      </script>


      <?php include('templates/footer.php') ?>
    </html>





<?php
  }
  else {
    ?>
    <!DOCTYPE html>
    <html lang="fi">
    <?php include('templates/header.php') ?>
      <div class="center brand-text">
        <h4>Kirjaudu</h4>
        <p>Anna sähköposti muodossa: <i>etunimi</i>.<i>kirjain</i>.<i>sukunimi</i>@student.jyu.fi</p>
      </div>
      <p id="cookies" class="center error"></p>
          <?php
            if (isset($_GET['error'])) {
              if ($_GET['error'] == "emptyfield") {
                echo '<p class="center error">Täytä kaikki kentät!</p>';
              }
              else if ($_GET['error'] == "invalidmail") {
                echo '<p class="center error">Sähköposti on väärin!</p>';
              }
              else if ($_GET['error'] == "wrongpwd") {
                echo '<p class="center error">Salasana on väärin!</p>';
              }
            }
           ?>

        <form class="kuittaus" action="includes/login.inc.php" method="post">
          <input type="text" name="mail" placeholder="Sähköposti" value="<?php if (isset($_GET['mail'])) { echo $_GET['mail'];}?>">
          <input type="password" name="pwd" placeholder="Salasana">
          <div class="center">
              <button onclick="myFunction()" class="btn" type="submit" name="login-submit">Kirjaudu</button>
          </div>
        </form>

    <?php
      include('templates/footer.php');
     ?>
     </html>

     <script type="text/javascript">
       function myFunction() {
         if(navigator.cookieEnabled) {
           document.getElementById("cookies").innerHTML = "";
         }
         else {
           var x = "Fuksipassi ei toimi, jos et hyväksy evästeiden käyttöä selaimessasi!";
           document.getElementById("cookies").innerHTML = x;
         }
       }
     </script>
<?php
  }
 ?>
