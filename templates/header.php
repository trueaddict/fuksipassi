<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>WebFuksipassi</title>
  <link rel="icon" type="image/png" href="./favicon/favicon_fp_2.png"/>
  <link rel="shortcut icon" type="image/png" href="./favicon/favicon_fp_2.png"/>

  <!-- Ulkoinen css - TODO oma CSS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
  <style type="text/css">
    .brand{
      background: grey !important;
    }
    .brand-text{
      color: black !important;
    }
    .brand-logo{
      margin: 0.8rem 0 0 0;
    }
    .brand-site{
      margin-top: 1rem;
    }
    .btn-suoritettu{
      background: black !important;
      color: white !important;
    }
    .logout{
      margin-top: 1rem;
    }
    .logout-btn{
      padding: 0 0 0.01rem 0.01rem;
    }
    .card-content{
      height: 14rem;
    }

    .nav{
      background: white;
      padding-bottom: 0.5rem;
    }
    .kuittaus{
      max-width: 90%;
      margin: 0.4rem auto;
      padding: 0.4rem;
    }
    .error{
      max-width: 460px;
      margin: 10px auto;
      color: red;
    }
    .pass {
      font-family: 'text-security-disc';
    }
    .hidden{
      display: none;
    }

    .login{
      max-width: 90%;
      margin: 0.4rem auto;
      padding: 0.4rem;
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
      color: white;
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
      overflow: hidden;
      opacity: 0;
      max-height: 0;
    }

    div.panel.show{
      opacity: 1;
      max-height: 100%;
      margin-bottom: 15px;
    }
    body{
      background-color: grey !important;
    }
    input:focus{
      color: #123;
      border-bottom: 1px solid #fbc02d !important;
      box-shadow: 0 1px 0 0 #fbc02d !important;
    }

    .policy{
      position: fixed;
      z-index: 2;
      width: 100%;
      margin-top: 10rem;
      background-color: white;
      box-shadow: 0px 5px 10px grey;
    }

    .policy-background{
      position: fixed;
      z-index: 1;
      width: 100%;
      height: 100%;
      background-color: grey;
      opacity: 0.8;
    }

    @media screen all{
      html{
        font-size: 15px;
      }

    }


  </style>
</head>
<body class="">
  <div class="nav">
    <div class="row">
      <div class="center">


        <div class="col s12 m2 brand-site">
          <p>Ainejärjestö</p>
        </div>
        <div class="col s12 m4 offset-m2">
          <a href="index.php" class=""><h3 class="brand-text brand-logo">Fuksipassi</h3></a>
        </div>
        <div class="col s12 m2">
          <p class="brand-text"><?php if (isset($_SESSION['usermail'])) {echo $kayttaja['nimi'];} ?></p>
        </div>
        <div class="col s12 m2 logout">
          <a href="#">
          <?php
            if (isset($_SESSION['usermail'])) {
              echo '<form class="" action="includes/logout.inc.php" method="post">
                <button class="btn-small logout-btn yellow darken-2" type="submit" name="logout-submit">Kirjaudu ulos</button>
              </form>';
            }
            else {
              echo "";
            }
          ?>

        </a>
        </div>
      </div>
    </div>

        <!-- <a href="index.php" class="brand-logo brand-text center"><?php if (!isset($_SESSION['usermail'])) {echo 'WebFuksipassi';} ?></a> -->



  </div>
</body>
