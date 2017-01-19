<?php
include('../classe/Formulaire.php');
include('../classe/Retour.php');
include('../classe/Location.php');
include('../classe/Vehicule.php');
include('../classe/Type.php');
include('../classe/Station.php');
include('../classe/Statistique.php');
include('../classe/Utilisateur.php');
include('../classe/CompteUtilisateur.php');
include('../classe/Societe.php');
include('../classe/Penalite.php');
include('../../bdd/bdd.php');
?>
  <!DOCTYPE HTML>
  <html>

  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>LudresCar &mdash; </title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

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
              <div id="gtco-logo"><a href="index.php">LudresCar <em>.</em></a></div>
            </div>
            <div class="col-xs-8 text-right menu-1">
              <ul>
                <li class="active"><a href="vehicules.php">Véhicules</a></li>
                <li><a href="contact.php">Contact</a></li>
                <li class="btn-cta"><a href="Inscription.php"><span>Inscription</span></a></li>
              </ul>
            </div>
          </div>

        </div>
      </nav>

      <header id="gtco-header" class="gtco-cover gtco-cover-sm" role="banner" style="background-image: url(images/img_bg_1.jpg)" data-stellar-background-ratio="0.5">
        <div class="overlay"></div>
        <div class="gtco-container">
          <div class="row">
            <div class="col-md-12 col-md-offset-0 text-center">


              <div class="row row-mt-15em">
                <div class="col-md-12 mt-text animate-box" data-animate-effect="fadeInUp">
                  <h1 class="cursive-font">Nos véhicules!</h1>
                </div>

              </div>


            </div>
          </div>
        </div>
      </header>



      <div class="gtco-section">
        <div class="gtco-container">
          <div class="row">
            <div class="col-md-8 col-md-offset-2 text-center gtco-heading">
              <h2 class="cursive-font primary-color">La liste des véhicules</h2>
              <p>Voici la liste des véhicules que l'on peut vous proposer.</p>
            </div>
          </div>
          <div class="row">
            <?php

include('../../bdd/bdd.php');
function getAllVehicule($tab,$bdd){
    $array=array();
    foreach($tab as $row){
        $vehicule=new Vehicule($row['no_immat'], $row['marque'], $row['modele'], $row['nb_place'], $row['carburant'], $row['puissance'], $row['nb_km'], $row['etat'], $row['date_mise_serv'], $row['duree_serv'], $row['niv_carbu'], getStation($row['station_id'],$bdd), getTypes($row['type_id'],$bdd));
        $array[]=$vehicule;
    }
    return $array;
}

function getTypes($id,$bdd){
    $requete="SELECT * FROM types where id=$1";
    $result= pg_prepare($bdd,'',$requete);
    $result = pg_execute($bdd, "", array($id));
    $type=NULL;
    while ($row = pg_fetch_row($result)) {
        $type=new Type($row[0], $row[1], $row[2], $row[3]);
    }
    return $type;
}

function getStation($id,$bdd){
    $requete="SELECT * FROM stations where id=$1";
    $result= pg_prepare($bdd,'',$requete);
    $result = pg_execute($bdd, "", array($id));
    while ($row = pg_fetch_row($result)) {
        $station=new Station($row[0], $row[1], $row[2], $row[3], new Statistique($row[4], 0, 0, 0, 0, 0, 0));
    }
    return $station;
}
// put your code here
$result = pg_query($bdd, "SELECT * FROM vehicules");
if (!$result) {
    echo "Une erreur est survenue.\n";
    exit;
}

$tab = pg_fetch_all($result);

$tab=getAllVehicule($tab,$bdd);
?>
              <div class='container-fluid'>
                <label>Nombre de véhicules :
                  <?php echo count($tab); ?>
                </label>
                <table id='tableID' class="table table-bordered table-striped" border='1'>
                  <thead>
                    <tr>
                      <th>Immatriculation</th>
                      <th>Marque</th>
                      <th>Modèle</th>
                      <th>nombre de place</th>
                      <th>puissance</th>
                      <th>kilométrage</th>
                      <th>Etat</th>
                      <th>Date mise en service</th>
                      <th>Durée du service</th>
                      <th>niveau de carburant</th>
                      <th>Nom du type</th>
                      <th>Prix kilométrique</th>
                      <th>Prix jour</th>
                      <th>Station</th>
                      <th>Adresse de la station</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
foreach($tab as $row){
    //$vehicule=new Vehicule($no_immat, $marque, $modele, $bn_place, $carburant, $puissance, $nb_km, $etat, $date_mise_serv, $duree_serv, $niv_carbu, $station, $type)
    $vehicule =$row;
    ?>
                      <tr>
                        <th>
                          <?php echo $vehicule->getNo_immat() ?>
                        </th>
                        <th>
                          <?php echo $vehicule->getMarque() ?>
                        </th>
                        <th>
                          <?php echo $vehicule->getModele() ?>
                        </th>
                        <th>
                          <?php echo $vehicule->getBn_place() ?>
                        </th>
                        <th>
                          <?php echo $vehicule->getPuissance() ?>
                        </th>
                        <th>
                          <?php echo $vehicule->getNb_km() ?>
                        </th>
                        <th>
                          <?php echo $vehicule->getEtat() ?>
                        </th>
                        <th>
                          <?php echo $vehicule->getDate_mise_serv() ?>
                        </th>
                        <th>
                          <?php echo $vehicule->getDuree_serv() ?>
                        </th>
                        <th>
                          <?php echo $vehicule->getNiv_carbu() ?>
                        </th>
                        <th>
                          <?php echo $vehicule->getType()->getNom() ?>
                        </th>
                        <th>
                          <?php echo $vehicule->getType()->getPrix_km() ?>
                        </th>
                        <th>
                          <?php echo $vehicule->getType()->getPrix_jour() ?>
                        </th>
                        <th>
                          <?php echo $vehicule->getStation()->getNom() ?>
                        </th>
                        <th>
                          <?php echo $vehicule->getStation()->getAdresse() ?>
                        </th>
                      </tr>
                      <?php
}
?>
                  </tbody>
                </table>
              </div>

          </div>
        </div>
      </div>


      <footer id="gtco-footer" role="contentinfo" style="background-image: url(images/img_bg_1.jpg)" data-stellar-background-ratio="0.5">
        <div class="overlay"></div>
        <div class="gtco-container">
          <div class="row row-pb-md">




            <div class="col-md-12 text-center">
              <div class="gtco-widget">
                <h3>Nous contacter</h3>
                <ul class="gtco-quick-contact">
                  <li><a href="#"><i class="icon-phone"></i> +1 234 567 890</a></li>
                  <li><a href="#"><i class="icon-mail2"></i> info@ludrescar.fr</a></li>
                </ul>
              </div>
              <div class="gtco-widget">
                <h3>Réseaux sociaux</h3>
                <ul class="gtco-social-icons">
                  <li><a href="#"><i class="icon-twitter"></i></a></li>
                  <li><a href="#"><i class="icon-facebook"></i></a></li>
                  <li><a href="#"><i class="icon-linkedin"></i></a></li>
                  <li><a href="#"><i class="icon-dribbble"></i></a></li>
                </ul>
              </div>
            </div>
          </div>



        </div>
      </footer>
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