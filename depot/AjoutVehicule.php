<?php

session_start();
include('../../bdd/bdd.php');
include('../classe/Vehicule.php');
/*
if(!empty($_POST))
{
    $req = $pdo->prepare('INSERT INTO document(NOM_DOC, TYPE_DOC) VALUES(:NOM_DOC, :TYPE_DOC)');
    $req->execute(array(
        'NOM_DOC' => $_POST['ldm'],
        'TYPE_DOC' => "Lettre de motivation"
    ));
    
    $dos = $pdo->query('SELECT NO_DOSSIER
    FROM dossier
    WHERE NOM_CANDIDAT =\''. $candidat->getNom_candidat().'\'');
    
    $doc = $pdo->query('SELECT NO_DOC
    FROM document
    WHERE type_doc = "Lettre de motivation"
    ORDER BY NO_DOC DESC LIMIT 0, 1');
    
    $doss = $dos->fetch();
    $docc = $doc->fetch();
    
    $req2 = $pdo->prepare('INSERT INTO contient_document(NO_DOC, NO_DOSSIER) VALUES(:NO_DOC, :NO_DOSSIER)');
    $req2->execute(array(
        'NO_DOC' => $docc['NO_DOC'],
        'NO_DOSSIER' => $doss['NO_DOSSIER']
    ));
    echo 'La nouvelle lettre de motivation a bien ete ajoutee';
    
    
}
*/
?>
<!DOCTYPE HTML>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Ajouter un véhicule</title>
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

    <header id="gtco-header" class="gtco-cover gtco-cover-md" role="banner" style="height:1500px; background-image: url(images/img_bg_1.jpg)" data-stellar-background-ratio="0.5">
      <div class="overlay"></div>
      <div class="gtco-container">
        <div class="row">
          <div class="col-md-12 col-md-offset-0 text-left">


            <div class="row row-mt-15em">
              <div class="col-md-7 mt-text animate-box" data-animate-effect="fadeInUp">
                <span class="intro-text-small">ludresCar</span>
                <h1 class="cursive-font">Ajouter un véhicule</h1>
              </div>
              <div class="col-md-4 col-md-push-1 animate-box" data-animate-effect="fadeInRight">
                <div class="form-wrap">
                  <div class="tab">

                    <div class="tab-content">
                      <div class="tab-content-inner active" data-content="signup">
                        <h3 class="cursive-font">Information :</h3>
                        <form action="#" method="POST">
                          <div class="row form-group">
                            <div class="col-md-12">
                              <label for="noImmat">Numéro d'immatriculation :</label>
                              <input type="text" id="noImmat " name="noImmat" class="form-control">
                            </div>
                          </div>
                          <div class="row form-group">
                            <div class="col-md-12">
                              <label for="marque">Marque :</label>
                              <input type="text" id="noImmat " name="noImmat" class="form-control">
                            </div>
                          </div>
                          <div class="row form-group">
                            <div class="col-md-12">
                              <label for="modele">Modèle :</label>
                              <select name="#" id="modele" name="modele" class="form-control">
                                <option value="monoplace">Monoplace</option>
                                <option value="suv">SUV</option>
                                <option value="fourfour">4x4</option>
                                <option value="coupe">Coupe</option>
                                <option value="cabriolet">Cabriolet</option>
                                <option value="break">Break</option>
                              </select>
                            </div>
                          </div>
                          <div class="row form-group">
                            <div class="col-md-12">
                              <label for="nbPlace">Nombre de place :</label>
                              <input type="number" id="nbPlace" name="nbPlace" class="form-control">
                            </div>
                          </div>
                          <div class="row form-group">
                            <div class="col-md-12">
                              <label for="carburant">Carburant :</label>
                              <select name="#" id="carburant" name="carburant" class="form-control">
                                <option value="diesel">Diesel</option>
                                <option value="spNeufCinq">SP95</option>
                                <option value="spNeufHuit">SP98</option>
                                <option value="electrique">Electrique</option>
                              </select>
                            </div>
                          </div>
                          <div class="row form-group">
                            <div class="col-md-12">
                              <label for="puissance">Puissance :</label>
                              <input type="text" id="puissance" name="puissance" class="form-control">
                            </div>
                          </div>
                          <div class="row form-group">
                            <div class="col-md-12">
                              <label for="nbKm">Kilométrage :</label>
                              <input type="text" id="nbKm" name="nbKm" class="form-control">
                            </div>
                          </div>
                          <div class="row form-group">
                            <div class="col-md-12">
                              <label for="dateMS">Date de mise en service :</label>
                              <input type="text" id="dateMS" name="dateMS" class="form-control">
                            </div>
                          </div>
                          <div class="row form-group">
                            <div class="col-md-12">
                              <label for="dureeMS">Durée de mise en service en année :</label>
                              <input type="text" id="dureeMS" name="dureeMS" class="form-control">
                            </div>
                          </div>
                          <div class="row form-group">
                            <div class="col-md-12">
                              <label for="nivCarburant">Niveau du carburant :</label>
                                <select name="#" id="nivCarburant" name="nivCarburant" class="form-control">
                                  <option value="plein">Plein</option>
                                  <option value="TroisQuatre">3/4</option>
                                  <option value="UnDeux">1/2</option>
                                  <option value="UnQuatre">1/4</option>
                                  <option value="vide">Vide</option>
                                </select>
                            </div>
                          </div>

                          <div class="row form-group">
                            <div class="col-md-12">
                              <input type="submit" class="btn btn-primary btn-block" value="Valider">
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