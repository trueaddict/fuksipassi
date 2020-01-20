<?php
  include('../config/db_connect.php');

  echo $kissa = "kissa";
  $kissa[2] = "t";
  echo $kissa;


  session_start();
  if (isset($_SESSION['usermail'])) {
    echo 'toimii session';
    echo $_SESSION['usermail'];
  }
  else {
    header("Location: ../index.php");
    exit();
  }


  // TODO muuttaa niin että tieto kayttajasta tulee login sivulta post -metodilla
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
      echo "kayttaja ok";
    }

  }


  $sql = 'SELECT kuvaus, id_teht_nro FROM tehtavat';

  $result = mysqli_query($conn, $sql);
  $tehtavat = mysqli_fetch_all($result, MYSQLI_ASSOC);

  mysqli_free_result($result);
  mysqli_free_result($result2);
  mysqli_close($conn);

  //print_r($tehtavat);

?>

<!DOCTYPE html>
<html lang="fi">
  <?php
  include('../templates/header.php');?>
  <h4 class="center gray-text">Tehtävät</h4>
  <div class="container">
    <div class="row">
      <?php $suoritettu = explode(',', $kayttaja['suoritettu']);?>
        <?php foreach ($tehtavat as $tehtava): ?>
          <div class="col s12 m6 l6">
            <div class="card z-depth-0">
              <div class="card-content center">
                <h6>Tehtävä <?php echo $tehtava['id_teht_nro'] ?></h6>
                <div class=""><?php echo $tehtava['kuvaus'] ?></div>
              </div>
              <?php if($suoritettu[$tehtava['id_teht_nro'] - 1] == 0):?>
                <div class="card-action center">
                  <a href="check.php?id_teht_nro=<?php echo $tehtava['id_teht_nro']?>" class="btn brand-text">Kuittaa</a>
                </div>
              <?php else: ?>
                <div class="card-action center">
                  <a href="#" class="btn btn-suoritettu brand-text">Suoritettu</a>
                </div>
              <?php endif; ?>
            </div>
          </div>
      <?php endforeach; ?>
    </div>

  </div>

  <?php include('../templates/footer.php') ?>
</html>
