<head>
  <meta charset="utf-8">
  <title>Fuksipassi Työkalut</title>

  <!-- Ulkoinen css - TODO oma CSS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
  <style type="text/css">
    .brand{
      background: grey !important;
    }
    .brand-text{
      color: black !important;
    }
    .btn-suoritettu{
      background: black !important;
      color: white !important;
    }

    .nav{
      background: white !important;
    }
    .kuittaus{
      max-width: 60%;
      margin: 20px auto;
      padding: 20px;
    }
    .error{
      max-width: 460px;
      margin: 10px auto;
      color: red;
    }
    .name{
      margin: 0;
      padding: 0 0 0 20px;
    }
    .underline{
      border-bottom: solid 1px black;
    }


    ::placeholder{
      color: rgba(0, 0, 0, 0.5);
    }

    button.accordion{
      cursor: pointer;
      border: none;
      outline: none;
      width: 100%;
      background-color: transparent;
      border: 1px solid white;
      color: grey;
      padding: 25px;
      margin: 0 0 4px 0px;
      transition: 0.3s;
    }

    button.accordion:hover{
      background-color: rgba(255, 255, 255, 0.3);
    }

    button.accordion.active{
      background-color: #fff;
      color: #000;
    }

    div.panel{
      background-color: rgba(255, 255, 255, 0.8);
      color: #000;
      border-radius: 0 0 4px 4px;
      overflow: default;
      opacity: 1;
      max-height: 0;
    }

    div.panel.show{
      opacity: 1;
      max-height: none;
      margin-bottom: 15px;
    }

  </style>
</head>
<body class="grey lighten-2">
  <nav class="nav">
    <div class="container">
        <!-- <a href="index.php" class="brand-logo brand-text center"><?php if (!isset($_SESSION['usermail'])) {echo 'WebFuksipassi';} ?></a> -->
        <a href="index.php" class="brand-logo brand-text center">Fuksipassi Työkalut</a>
        <a href="#">
        <?php
          if (isset($_SESSION['useradmin'])) {
            echo '<form class="right" action="includes/logout.inc.php" method="post">
              <button class="btn-small" type="submit" name="logout-submit">Kirjaudu ulos</button>
            </form>';
          }
          else {
            echo "ei toimi";
          }
        ?>

        </a>
    </div>
  </nav>
</body>
