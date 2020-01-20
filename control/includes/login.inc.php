<?php
if (isset($_POST['login-submit'])) {

  include('../../config/db_connect.php');

  $userEmail = $_POST['mail'];
  $userPassword = $_POST['pwd'];

  $ktunnus = "syrre";
  $password = "syrinxadmin";

  if (empty($userEmail) || empty($userPassword)) {
    header("Location: ../index.php?error=emptyfield&mail=".$userEmail);
    exit();
  }
  else if ($userEmail !== $ktunnus) {
    header("Location: ../index.php?error=invalidmail");
    exit();
  }
  else {
    if ($userPassword !== $password) {
      header("Location: ../index.php?error=wrongpwd&mail=".$userEmail);
      exit();
    }

    session_start();
    $_SESSION['useradmin'] = $userEmail;
    header("Location: ../index.php?login=success");
    exit();

  }


  mysqli_stmt_close($stmt);
  mysqli_close($conn);


}
else {
  header("Location: ../index.php");
  exit();
}
