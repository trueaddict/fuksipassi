<?php
if (isset($_POST['login-submit'])) {

  include('../config/db_connect.php');

  $userEmail = $_POST['mail'];
  $userPassword = $_POST['pwd'];
  $userSuoritettu = str_repeat("0", 180);



  $password = "syrinx";

  if (empty($userEmail) || empty($userPassword)) {
    header("Location: ../index.php?error=emptyfield&mail=".$userEmail);
    exit();
  }
  else if (!preg_match("/@student.jyu.fi/", $userEmail)) { // TODO PARANNA maili tarkistin @student.jyu.fi
    header("Location: ../index.php?error=invalidmail");
    exit();
  }
  else {
    if ($userPassword !== $password) {
      header("Location: ../index.php?error=wrongpwd&mail=".$userEmail);
      exit();
    }

    // Haetaan sähköpostista nimi
    $userName1 = preg_replace("/@student.jyu.fi/", "", $_POST['mail']);
    $nameArray = explode('.', $userName1);
    $nameArray[1] = $nameArray[2];
    $nameArray[2] = "";
    $userName = strtoupper(implode(" ", $nameArray));

    $sql = "SELECT mail FROM kayttajat WHERE mail=?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
      header("Location: ../index.php?error=sqlerror");
      exit();
    }
    else {
      mysqli_stmt_bind_param($stmt, "s", $userEmail);
      mysqli_stmt_execute($stmt);
      mysqli_stmt_store_result($stmt);
      $resultCheck = mysqli_stmt_num_rows($stmt);
      if ($resultCheck > 0) {
        session_start();
        $_SESSION['usermail'] = $userEmail;
        header("Location: ../index.php?login=success");
        exit();
      }
      else {
        $sql = "INSERT INTO kayttajat (mail, nimi, suoritettu) VALUES (?, ?, ?)";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
          header("Location: ../index.php?error=sqlerror");
          exit();
        }
        else {
          mysqli_stmt_bind_param($stmt, "sss", $userEmail, $userName, $userSuoritettu);
          mysqli_stmt_execute($stmt);
          mysqli_stmt_store_result($stmt);
          session_start();
          $_SESSION['usermail'] = $userEmail;
          header("Location: ../index.php?signup=success");
          exit();
        }
      }
    }
  }


  mysqli_stmt_close($stmt);
  mysqli_close($conn);


}
else {
  header("Location: ../index.php");
  exit();
}
