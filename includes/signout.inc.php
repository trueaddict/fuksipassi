<?php

  if (isset($_POST['signout-submit'])) {
    include('../config/db_connect.php');

    $usermail = mysqli_real_escape_string($conn, $_POST['signout-email']);
    $sql = "DELETE FROM kayttajat WHERE mail = '$usermail'";
    if(mysqli_query($conn, $sql)) {
      header("Location: ../includes/logout.inc.php");
      exit();
    }
    else {
      echo "query error: ". mysqli_error($conn);
    }


  }
  else {
    header("Location: ../index.php");
    exit();
  }


 ?>
