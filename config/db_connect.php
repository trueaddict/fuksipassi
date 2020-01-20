<?php
  // luodaan yhteys databaseen (mysql, localhost)
  $servername="127.0.0.1";
  $dbusername="otto";
  $dbpassword="test1234";
  $dbname="web_fuksipassi";

  $conn = mysqli_connect($servername, $dbusername, $dbpassword, $dbname);
  $conn->set_charset('utf8');
  if(!$conn) {
    echo 'Connection error: ' . mysqli_connect_error();
  }

  session_start();

?>
