<?php
session_start();
//include('../../bdd/bdd.php');
include('../../classe/Formulaire.php');
include('../../classe/Retour.php');
include('../../classe/Location.php');
include('../../classe/Vehicule.php');
include('../../classe/Type.php');
include('../../classe/Station.php');
include('../../classe/Statistique.php');
include('../../classe/Utilisateur.php');
include('../../classe/CompteUtilisateur.php');
include('../../classe/Societe.php');
include('../../classe/Penalite.php');
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
    <link rel="stylesheet" href="../css/animate.css">
    <!-- Icomoon Icon Fonts-->
    <link rel="stylesheet" href="../css/icomoon.css">
    <!-- Themify Icons-->
    <link rel="stylesheet" href="../css/themify-icons.css">
    <!-- Bootstrap  -->
    <link rel="stylesheet" href="../css/bootstrap.css">

    <!-- Magnific Popup -->
    <link rel="stylesheet" href="../css/magnific-popup.css">

    <!-- Bootstrap DateTimePicker -->
    <link rel="stylesheet" href="../css/bootstrap-datetimepicker.min.css">

    <!-- Owl Carousel  -->
    <link rel="stylesheet" href="../css/owl.carousel.min.css">
    <link rel="stylesheet" href="../css/owl.theme.default.min.css">

    <!-- Theme style  -->
    <link rel="stylesheet" href="../css/style.css">

    <!-- Modernizr JS -->
    <script src="../js/modernizr-2.6.2.min.js"></script>
    <!-- FOR IE9 below -->
    <!--[if lt IE 9]>
    <script src="../js/respond.min.js"></script>
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
                <p style="color: white;">
                  <?php if(isset($_SESSION['co']))
{
    echo($_SESSION['login']);
}
?>
                </p>
                <div id="gtco-logo"><a href="index.php">LudresCar <em>.</em></a></div>
              </div>
              <div class="col-xs-8 text-right menu-1">
                <ul>
                  <li class="has-dropdown">
                     <a href="#">Services</a>
                     <ul class="dropdown">
                <li><a href="AjoutVehicule.php">Ajouter un véhicule</a></li>
                <li><a href="SupprimerVehicule.php">Supprimer un véhicule</a></li>
                <li><a href="entretien.php">mettre un véhicule en entretien</a></li>
              </ul>
            </li>
                  <li><a href="../deco.php">Se déconnecter</a></li>
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
                  <div class="col-md-12 mt-text animate-box" data-animate-effect="fadeInUp">
                    <span class="intro-text-small">ludresCar</span>
                    <h1 class="cursive-font">Quand la voiture rencontre la location.</h1>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </header>

        <div id="gtco-counter" class="gtco-section">
          <div class="gtco-container">

            <div class="row">
              <div class="col-md-8 col-md-offset-2 text-center gtco-heading animate-box">
                <h2 class="cursive-font primary-color">Les véhicules en transfert</h2>
              </div>
            </div>

            <div class="row">
<?php
        // put your code here
            $result = pg_query($bdd, "SELECT * FROM vehicules where etat='Transfert'");
            if (!$result) {
              echo "Une erreur est survenue.\n";
              exit;
            }

            $tab = pg_fetch_all($result);
            if(!empty($tab)){
                $tab=getAllVehicule($tab,$bdd);
                ?>
                <div class='container-fluid'>
                        <label>Nombre de lignes : <?php echo count($tab); ?></label>
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
                                    <th>Transfert vers la station</th>
                                    <th>Adresse de la station</th>
                                    <th>Fin du transfert</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                            foreach($tab as $row){
                                //$vehicule=new Vehicule($no_immat, $marque, $modele, $bn_place, $carburant, $puissance, $nb_km, $etat, $date_mise_serv, $duree_serv, $niv_carbu, $station, $type)
                                $vehicule =$row;
                                ?>
                                <tr>
                                    <th><?php echo $vehicule->getNo_immat() ?></th>
                                    <th><?php echo $vehicule->getMarque() ?></th>
                                    <th><?php echo $vehicule->getModele() ?></th>
                                    <th><?php echo $vehicule->getBn_place() ?></th>
                                    <th><?php echo $vehicule->getPuissance() ?></th>
                                    <th><?php echo $vehicule->getNb_km() ?></th>
                                    <th><?php echo $vehicule->getEtat() ?></th>
                                    <th><?php echo $vehicule->getDate_mise_serv() ?></th>
                                    <th><?php echo $vehicule->getDuree_serv() ?></th>
                                    <th><?php echo $vehicule->getNiv_carbu() ?></th>
                                    <th><?php echo $vehicule->getType()->getNom() ?></th>
                                    <th><?php echo $vehicule->getType()->getPrix_km() ?></th>
                                    <th><?php echo $vehicule->getType()->getPrix_jour() ?></th>
                                    <th><?php echo $vehicule->getStation()->getNom() ?></th>
                                    <th><?php echo $vehicule->getStation()->getAdresse() ?></th>
                                    <th><a href="<?php echo dirname($_SERVER["PHP_SELF"]).'/finTransfertVehicule.php?immat='.$vehicule->getNo_immat(); ?>">Finir le transfert</a></th>
                                </tr>
                                <?php
                            }
                            ?>
                            </tbody>
                        </table>
                </div>
            <?php
            }else{
                echo "<h3>Aucun véhicule n'est en cours de transfert</h3>";
            }
            ?>
              <div class="col-md-3 col-sm-6 animate-box" data-animate-effect="fadeInUp">
                <div class="feature-center">
                  <span class="counter js-counter" data-from="0" data-to="50" data-speed="5000" data-refresh-interval="50">1</span>
                  <span class="counter-label">milles utilisateurs</span>

                </div>
              </div>
              <div class="col-md-3 col-sm-6 animate-box" data-animate-effect="fadeInUp">
                <div class="feature-center">
                  <span class="counter js-counter" data-from="0" data-to="325" data-speed="5000" data-refresh-interval="50">1</span>
                  <span class="counter-label">Voitures</span>
                </div>
              </div>
              <div class="col-md-3 col-sm-6 animate-box" data-animate-effect="fadeInUp">
                <div class="feature-center">
                  <span class="counter js-counter" data-from="0" data-to="32000" data-speed="5000" data-refresh-interval="50">1</span>
                  <span class="counter-label">nombres locations</span>
                </div>
              </div>
              <div class="col-md-3 col-sm-6 animate-box" data-animate-effect="fadeInUp">
                <div class="feature-center">
                  <span class="counter js-counter" data-from="0" data-to="2016" data-speed="5000" data-refresh-interval="50">1</span>
                  <span class="counter-label">années de départ</span>

                </div>
              </div>

            </div>
          </div>
        </div>



        <div id="gtco-subscribe">
          <div class="gtco-container">
            <div class="row animate-box">
              <div class="col-md-8 col-md-offset-2 text-center gtco-heading">
                <h2 class="cursive-font">Vos commentaires</h2>
                <p>N'hésitez pas à nous exprimer vos commentaires.</p>
              </div>
            </div>
            <div class="row animate-box">
              <div class="col-md-8 col-md-offset-2">
                <form class="form-inline">
                  <div class="col-md-6 col-sm-6">
                    <div class="form-group">
                      <label for="email" class="sr-only">Email</label>
                      <input type="email" class="form-control" id="email" placeholder="Votre Email">
                    </div>
                  </div>
                  <div class="col-md-6 col-sm-6">
                    <button type="submit" class="btn btn-default btn-block">Envoyer</button>
                  </div>
                </form>
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
                    <li><a href="#"> +1 234 567 890</a></li>
                    <li><a href="#"> info@ludrescar.fr</a></li>
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
      <script src="../js/jquery.min.js"></script>
      <!-- jQuery Easing -->
      <script src="../js/jquery.easing.1.3.js"></script>
      <!-- Bootstrap -->
      <script src="../js/bootstrap.min.js"></script>
      <!-- Waypoints -->
      <script src="../js/jquery.waypoints.min.js"></script>
      <!-- Carousel -->
      <script src="../js/owl.carousel.min.js"></script>
      <!-- countTo -->
      <script src="../js/jquery.countTo.js"></script>

      <!-- Stellar Parallax -->
      <script src="../js/jquery.stellar.min.js"></script>

      <!-- Magnific Popup -->
      <script src="../js/jquery.magnific-popup.min.js"></script>
      <script src="../js/magnific-popup-options.js"></script>

      <script src="../js/moment.min.js"></script>
      <script src="../js/bootstrap-datetimepicker.min.js"></script>


      <!-- Main -->
      <script src="../js/main.js"></script>

  </body>

  </html>



  <?php
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
        
        
        
?>