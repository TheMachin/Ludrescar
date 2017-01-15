<!DOCTYPE HTML>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>LudresCar &mdash; </title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="Free HTML5 Website Template by GetTemplates.co" />
  <meta name="keywords" content="free website templates, free html5, free template, free bootstrap, free website template, html5, css3, mobile first, responsive" />
  <meta name="author" content="GetTemplates.co" />

  <!-- Facebook and Twitter integration -->
  <meta property="og:title" content="" />
  <meta property="og:image" content="" />
  <meta property="og:url" content="" />
  <meta property="og:site_name" content="" />
  <meta property="og:description" content="" />
  <meta name="twitter:title" content="" />
  <meta name="twitter:image" content="" />
  <meta name="twitter:url" content="" />
  <meta name="twitter:card" content="" />

  <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Kaushan+Script" rel="stylesheet">

  <!-- Animate.css -->
  <link rel="stylesheet" href="css/animate.css">
  <!-- Icomoon Icon Fonts-->
  <link rel="stylesheet" href="css/icomoon.css">
  <!-- Themify Icons-->
  <link rel="stylesheet" href="css/themify-icons.css">
  <!-- Bootstrap  -->
  <link rel="stylesheet" href="css/bootstrap.css">

  <!-- Magnific Popup -->
  <link rel="stylesheet" href="css/magnific-popup.css">

  <!-- Bootstrap DateTimePicker -->
  <link rel="stylesheet" href="css/bootstrap-datetimepicker.min.css">

  <!-- Owl Carousel  -->
  <link rel="stylesheet" href="css/owl.carousel.min.css">
  <link rel="stylesheet" href="css/owl.theme.default.min.css">

  <!-- Theme style  -->
  <link rel="stylesheet" href="css/style.css">

  <!-- Modernizr JS -->
  <script src="js/modernizr-2.6.2.min.js"></script>
  <!-- FOR IE9 below -->
  <!--[if lt IE 9]>
    <script src="js/respond.min.js"></script>
<![endif]-->

</head>

<body>

  <div class="gtco-loader"></div>

  <div id="page">

    <!-- <div class="page-inner"> -->
    <nav class="gtco-nav" role="navigation">
      <div class="gtco-container">

        <div class="row">
          <div class="col-sm-4 col-xs-12">
            <div id="gtco-logo"><a href="index.html">LudresCar <em>.</em></a></div>
          </div>
          <div class="col-xs-8 text-right menu-1">
            <ul>
              <li><a href="">Véhicules</a></li>
              <li><a href="">Mes locations</a></li>
              <li><a href="">Contact</a></li>
              <li class="btn-cta"><a href="#"><span>Reservation</span></a></li>
              <li><a href="">Se déconnecter</a></li>
            </ul>
          </div>
        </div>
      </div>
    </nav>

    <header id="gtco-header" class="gtco-cover gtco-cover-md" role="banner" style="background-image: url(images/img_bg_1.jpg)" data-stellar-background-ratio="0.5">
      <div class="overlay"></div>
      <div class="gtco-container">
        <div class="row">
          <div class="col-md-12 col-md-offset-0 text-left">


            <div class="row row-mt-15em">
              <div class="col-md-7 mt-text animate-box" data-animate-effect="fadeInUp">
                <span class="intro-text-small">ludresCar</span>
                <h1 class="cursive-font">Quand la voiture rencontre la location.</h1>
              </div>
              <div class="col-md-4 col-md-push-1 animate-box" data-animate-effect="fadeInRight">
                <div class="form-wrap">
                  <div class="tab">

                    <div class="tab-content">
                      <div class="tab-content-inner active" data-content="signup">
                        <h3 class="cursive-font">Réservation de voiture</h3>
                        <form action="resVehiculeDispo.php" method="post">
                          <div class="row form-group">
                            <div class="col-md-12">
                              <label for="activities">Station</label>
                              <select name="#" id="activities" name="station" class="form-control">
                                <option value="">Ludres-Centre</option>
                                <option value="">Ludres-Gare</option>
                                <option value="">Ludres-Sud</option>
                              </select>
                            </div>
                          </div>
                          <div class="row form-group">
                            <div class="col-md-12">
                              <label for="date-start">Date de début</label>
                              <input type="text" id="date" name="dateDeb" class="form-control">
                            </div>
                          </div>
                          <div class="row form-group">
                            <div class="col-md-12">
                              <label for="date-end">Heure de début</label>
                              <input type="text" id="time" name="hDeb" class="form-control">
                            </div>
                          </div>
                          <div class="row form-group">
                            <div class="col-md-12">
                              <label for="date-start">Date de retour</label>
                              <input type="text" id="date" name="dateRet" class="form-control">
                            </div>
                          </div>
                          <div class="row form-group">
                            <div class="col-md-12">
                              <label for="date-end">Heure de retour</label>
                              <input type="text" id="time" name="hRet" class="form-control">
                            </div>
                          </div>
                          <div class="row form-group">
                            <div class="col-md-12">
                              <input type="submit" class="btn btn-primary btn-block" value="Véhicule(s) disponible(s)">
                            </div>
                          </div>
                        </form>
                      </div>


                    </div>
                  </div>
                </div>
              </div>
            </div>


          </div>
        </div>
      </div>
    </header>
    <!-- </div> -->

  </div>

  <div class="gototop js-top">
    <a href="#" class="js-gotop"><i class="icon-arrow-up"></i></a>
  </div>

  <!-- jQuery -->
  <script src="js/jquery.min.js"></script>
  <!-- jQuery Easing -->
  <script src="js/jquery.easing.1.3.js"></script>
  <!-- Bootstrap -->
  <script src="js/bootstrap.min.js"></script>
  <!-- Waypoints -->
  <script src="js/jquery.waypoints.min.js"></script>
  <!-- Carousel -->
  <script src="js/owl.carousel.min.js"></script>
  <!-- countTo -->
  <script src="js/jquery.countTo.js"></script>

  <!-- Stellar Parallax -->
  <script src="js/jquery.stellar.min.js"></script>

  <!-- Magnific Popup -->
  <script src="js/jquery.magnific-popup.min.js"></script>
  <script src="js/magnific-popup-options.js"></script>

  <script src="js/moment.min.js"></script>
  <script src="js/bootstrap-datetimepicker.min.js"></script>


  <!-- Main -->
  <script src="js/main.js"></script>

</body>

</html>