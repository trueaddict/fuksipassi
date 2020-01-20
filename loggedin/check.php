<?php
  include('../config/db_connect.php');

  //session_start();

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

  $errors = array('password' => '');
  $password = '';

  $sql = 'SELECT password, id_salasana FROM salasanat';

  $result = mysqli_query($conn, $sql);
  $salasanat = mysqli_fetch_all($result, MYSQLI_ASSOC);

  if(isset($_POST['submit'])) {

    if(empty($_POST['password'])) {
      $errors['password'] = 'Salasana vaaditaan <br/>';
    } else {
      $password = $_POST['password'];
      //print_r('Foreach');
      foreach ($salasanat as $salasana) {
        //echo $salasana['password'];
        if($salasana['password'] != $_POST['password']) {
          $errors['password'] = 'Salasana on väärin';
        } else {
          $errors['password'] = '';
          break;
        }
      }
    }

    if(array_filter($errors)) {

    } else {
      // TODO Kuittaa käyttäjälle tehtävän suoritetuksi

      $suoritettu = explode(',', $kayttaja['suoritettu']);
      $id_teht = mysqli_real_escape_string($conn, $_GET['id_teht_nro']);
      $suoritettu[$id_teht - 1] = 1;
      $suor = mysqli_real_escape_string($conn, implode("," , $suoritettu));
      $mail = mysqli_real_escape_string($conn, $_SESSION['usermail']);
      $sql2 = "UPDATE kayttajat SET suoritettu = '$suor' WHERE mail = '$mail'";
      //header('location: index.php');
      //$password = mysqli_real_escape_string($conn, $_POST['password']);

      //$sql = "INSERT INTO kayttajat(suoritettu) VALUES('$password')";

      if(mysqli_query($conn, $sql2)) {
        header('location: index.php');
      } else {
        echo 'query error: '. mysqli_error($conn);
      }
    }


  }



  // Haetaan tehtävän tiedot GET metodista
  if(isset($_GET['id_teht_nro'])) {
    $id_teht_nro = mysqli_real_escape_string($conn, $_GET['id_teht_nro']);
    $sql = "SELECT * FROM tehtavat WHERE id_teht_nro = $id_teht_nro";
    $result = mysqli_query($conn, $sql);
    $tehtava = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    mysqli_close($conn);
  }
?>


<!DOCTYPE html>
<html lang="en" dir="ltr">
  <?php include('../templates/header.php') ?>
    <section class="container gray-text">
      <?php if($tehtava): ?>
      <h4 class="center">Kuittaa tehtävä <?php echo htmlspecialchars($tehtava['id_teht_nro']); ?></h4>
      <form class="white kuittaus" action="check.php?id_teht_nro=<?php echo $tehtava['id_teht_nro']?>" method="POST">
        <label for="">Salasana:</label>
        <input type="password" name="password" value="<?php echo htmlspecialchars($password) ?>">
        <div class="red-text"><?php echo $errors['password']; ?></div>
        <div class="center">
          <input type="submit" name="submit" value="Lähetä" class="btn brand z-depth-0">
        </div>
      </form>
    <?php else: ?>
      <h5>Tehtävää ei löydy</h5>
    <?php endif; ?>
    </section>
  <?php include('../templates/footer.php') ?>
</html>
