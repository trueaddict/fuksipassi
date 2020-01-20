<?php
  include('../config/db_connect.php');

  if(isset($_SESSION['useradmin'])) {
    if($_SESSION['useradmin'] == "syrre") {


      //Tehtävän kuvauksen muokkaaminen
      if (isset($_POST['edit-submit'])) {

        $kuvaus = mysqli_real_escape_string($conn, $_POST['kuvaus']);
        $teht_id = $_POST['tehtId'];

        $sql = "UPDATE tehtavat SET kuvaus = '$kuvaus' WHERE id_teht_nro = '$teht_id'";
        if(mysqli_query($conn, $sql)) {
          //header("location: ../index.php?");
        } else {
          echo 'query error: '. mysqli_error($conn);
        }

      }
      else {
        echo "";
      }




      //tehtavien haku databasesta
      $sql = 'SELECT kuvaus, id_teht_nro FROM tehtavat';

      $result = mysqli_query($conn, $sql);
      $tehtavat = mysqli_fetch_all($result, MYSQLI_ASSOC);



      ?>
      <!DOCTYPE html>
      <html lang="fi" dir="ltr">
        <?php include('header.php'); ?>


        <div class="container">
          <div class="row">
            <div class="col s12">
              <h4 class="center">Käyttäjät</h4>
            </div>
            <div class="col s2 m2">
              <div class="">
                <p>Nimi</p>
              </div>
            </div>
            <div class="col s2 m2 offset-m1">
              <div class="">
                <p>Perusopinnot</p>
              </div>
            </div>
            <div class="col s2 m2">
              <div class="">
                <p>Aineopinnot</p>
              </div>
            </div>
            <div class="col s2 m2">
              <div class="">
                <p>Syventävät opinnot</p>
              </div>
            </div>
            <div class="col s2 m2">
              <div class="">
                <p>Yleisopinnot</p>
              </div>
            </div>
            <div class="col s1 m1">
              <div class="">
                <p>Yhteensä</p>
              </div>
            </div>
          </div>

          <?php
          // kayttajien haku databasesta
          $sql2 = "SELECT * FROM kayttajat";
          $result = mysqli_query($conn, $sql2);
          $kayttajat = mysqli_fetch_all($result, MYSQLI_ASSOC);

          foreach ($kayttajat as $kayttaja) {

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

            $suoritettu_perus_pros = round(($suoritettu_perus / 25) * 100);
            $suoritettu_aine_pros = round(($suoritettu_aine / 60) * 100);
            $suoritettu_syv_pros = round(($suoritettu_syv / 50) * 100);
            $suoritettu_yleis_pros = round(($suoritettu_yleis / 45) * 100);

            $suoritettu_pros = round((($suoritettu_syv + $suoritettu_aine + $suoritettu_syv + $suoritettu_yleis) / 180) * 100);

            ?>

            <div class="row white">
              <div class="col s2 m2">
                <div class="">
                  <p><?php echo $kayttaja['nimi'] ?></p>
                  <a href="#"><?php echo $kayttaja['nimi'] ?></a>
                </div>
              </div>
              <div class="col s1 m1 offset-m1">
                <div class="">
                  <p><?php echo $suoritettu_perus?> / 25</p>
                </div>
              </div>
              <div class="col s1 m1">
                <div class="">
                  <p><?php echo $suoritettu_perus_pros?> %</p>
                </div>
              </div>
              <div class="col s1 m1">
                <div class="">
                  <p><?php echo $suoritettu_aine ?> / 60</p>
                </div>
              </div>
              <div class="col s1 m1">
                <div class="">
                  <p><?php echo $suoritettu_aine_pros ?> %</p>
                </div>
              </div>
              <div class="col s1 m1">
                <div class="">
                  <p><?php echo $suoritettu_syv ?> / 50</p>
                </div>
              </div>
              <div class="col s1 m1">
                <div class="">
                  <p><?php echo $suoritettu_syv_pros ?> %</p>
                </div>
              </div>
              <div class="col s1 m1">
                <div class="">
                  <p><?php echo $suoritettu_yleis ?> / 45</p>
                </div>
              </div>
              <div class="col s1 m1">
                <div class="">
                  <p><?php echo $suoritettu_yleis_pros ?> %</p>
                </div>
              </div>
              <div class="col s1 m1">
                <div class="">
                  <p><?php echo $suoritettu_pros ?> %</p>
                </div>
              </div>
              <div class="col s12 underline">

              </div>
            </div>

       <?php } ?>

        </div>

    <br>

      <h4 class="center">Tehtävät</h4>

      <div class="container">
        <div class="row">
          <div class="col s12">
            <div class="center">
              <button class="accordion">Perusopinnot 25</button>
              <div class="panel">
                <div class="">
                  <div class="row">
                      <?php
                        $teht_numero = 1;
                        for ($i = 0; $i <= 24; $i++):
                        $tehtava = $tehtavat[$i];
                        ?>
                        <div class="col s12 m6">
                          <div class="card z-depth-0">
                            <div class="card-content center" id="<?php echo $i ?>">
                              <h6>Tehtävä <?php echo $teht_numero; $teht_numero++; ?></h6>
                              <form class="" action="index.php#<?php echo $i ?>" method="post">
                                <input type="text" name="kuvaus" value="<?php echo $tehtava['kuvaus'] ?>">
                                <input class="hide" type="hidden" name="tehtId" value="<?php echo $tehtava['id_teht_nro']?>">


                            </div>
                              <div class="card-action center">
                                <button class="btn" type="submit" name="edit-submit">Muokkaa</button>
                              </div>
                            </form>
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
              <button class="accordion">Aineopinnot 60</button>
              <div class="panel">
                <div class="">
                  <div class="row">
                      <?php
                        $teht_numero = 1;
                        for ($i = 25; $i <= 84; $i++):
                        $tehtava = $tehtavat[$i];
                        ?>
                        <div class="col s12 m6">
                          <div class="card z-depth-0">
                            <div class="card-content center" id="<?php echo $i ?>">
                              <h6>Tehtävä <?php echo $teht_numero; $teht_numero++; ?></h6>
                              <form class="" action="index.php#<?php echo $i ?>" method="post">
                                <input type="text" name="kuvaus" value="<?php echo $tehtava['kuvaus'] ?>">
                                <input class="hide" type="hidden" name="tehtId" value="<?php echo $tehtava['id_teht_nro']?>">


                            </div>
                              <div class="card-action center">
                                <button class="btn" type="submit" name="edit-submit">Muokkaa</button>
                              </div>
                            </form>
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
              <button class="accordion">Syventävät opinnot 50</button>
              <div class="panel">
                <div class="">
                  <div class="row">
                      <?php
                        $teht_numero = 1;
                        for ($i = 85; $i <= 134; $i++):
                        $tehtava = $tehtavat[$i];
                        ?>
                        <div class="col s12 m6">
                          <div class="card z-depth-0">
                            <div class="card-content center" id="<?php echo $i ?>">
                              <h6>Tehtävä <?php echo $teht_numero; $teht_numero++; ?></h6>
                              <form class="" action="index.php#<?php echo $i ?>" method="post">
                                <input type="text" name="kuvaus" value="<?php echo $tehtava['kuvaus'] ?>">
                                <input class="hide" type="hidden" name="tehtId" value="<?php echo $tehtava['id_teht_nro']?>">


                            </div>
                              <div class="card-action center">
                                <button class="btn" type="submit" name="edit-submit">Muokkaa</button>
                              </div>
                            </form>
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
              <button class="accordion">Yleisopinnot 45</button>
              <div class="panel">
                <div class="">
                  <div class="row">
                      <?php
                        $teht_numero = 1;
                        for ($i = 135; $i <= 179; $i++):
                        $tehtava = $tehtavat[$i];
                        ?>
                        <div class="col s12 m6">
                          <div class="card z-depth-0">
                            <div class="card-content center" id="<?php echo $i ?>">
                              <h6>Tehtävä <?php echo $teht_numero; $teht_numero++; ?></h6>
                              <form class="" action="index.php#<?php echo $i ?>" method="post">
                                <input type="text" name="kuvaus" value="<?php echo $tehtava['kuvaus'] ?>">
                                <input class="hide" type="hidden" name="tehtId" value="<?php echo $tehtava['id_teht_nro']?>">


                            </div>
                              <div class="card-action center">
                                <button class="btn" type="submit" name="edit-submit">Muokkaa</button>
                              </div>
                            </form>
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


      <?php include('../templates/footer.php') ?>

      </html>





<?php
    }
    else {
      session_unset();
      session_destroy();
      header("Location: index.php");
      exit();
    }



  }
  else {
    ?>
    <!DOCTYPE html>
    <html lang="fi">
      <?php include('header.php') ?>
      <div class="center brand-text">
        <h4>Kirjaudu</h4>
      </div>
      <?php
            if (isset($_GET['error'])) {
              if ($_GET['error'] == "emptyfield") {
                echo '<p class="center error">Täytä kaikki kentät!</p>';
              }
              else if ($_GET['error'] == "invalidmail") {
                echo '<p class="center error">Käyttäjätunnus on väärin!</p>';
              }
              else if ($_GET['error'] == "wrongpwd") {
                echo '<p class="center error">Salasana on väärin!</p>';
              }
            }
           ?>

      <div class="">
        <form class="kuittaus" action="includes/login.inc.php" method="post">
          <input type="text" name="mail" placeholder="Käyttäjätunnus" value="">
          <input type="password" name="pwd" placeholder="Salasana" value="">
          <div class="center">
            <button class="btn" type="submit" name="login-submit">Kirjaudu</button>
          </div>
        </form>

      </div>
      <?php include('../templates/footer.php'); ?>
    </html>
<?php
  }
 ?>
