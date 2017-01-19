<?php

session_start();
$bdd=NULL;
if(isset($_SESSION['co'])){
    if(!empty($_SESSION['login']) && !empty($_SESSION['mdp'])){
        $login=$_SESSION['login'];
        $mdp=$_SESSION['mdp'];
        $bdd= pg_connect("host=localhost port=5432 dbname=ludrescar user=".$login." password=".$mdp,PGSQL_CONNECT_FORCE_NEW);
    }else{
        header('Location:../index_employe.php');
    }
}else{
    header('Location:../index_employe.php');
}
include('../../classe/Vehicule.php');

$typeVehicule = listVehicule($bdd);
$station = listStation($bdd);

if(!empty($_POST)){
    $ajoutVehicule = ajoutVehicule($bdd, $_POST['noImmat'], $_POST['station'], $_POST['marque'], $_POST['modele'], $_POST['type'], $_POST['nbPlace'], $_POST['carburant'], $_POST['puissance'], $_POST['nbKm'], $_POST['dateMS'], $_POST['dureeMS'], $_POST['nivCarburant']);
    echo $ajoutVehicule;
}

?>
  <!DOCTYPE HTML>
  <html>

  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Ajouter un véhicule</title>
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
              <div id="gtco-logo"><a href="indexco.php">LudresCar <em>.</em></a></div>
            </div>
            <div class="col-xs-8 text-right menu-1">
              <ul>
                <li class="has-dropdown">
                  <a href="#">Services</a>
                  <ul class="dropdown">
                    <li><a href="SupprimerVehicule.php">Supprimer un véhicule</a></li>
                    <li><a href="transfert.php">Transférer un véhicule</a></li>
                    <li><a href="entretien.php">Mettre un véhicule en entretien</a></li>
                    <li><a href="ajoutType.php">Ajouter un type de véhicule</a></li>
                    <li><a href="statistiques.php">Statistiques</a></li>
                  </ul>
                </li>
                <li><a href="../decoEmploye.php">Se déconnecter</a></li>
              </ul>
            </div>
          </div>
        </div>
      </nav>

      <header id="gtco-header" class="gtco-cover gtco-cover-md" role="banner" style="height:1700px; background-image: url(images/img_bg_1.jpg)" data-stellar-background-ratio="0.5">
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
                          <h3 class="cursive-font">Informations :</h3>
                          <form action="AjoutVehicule.php" method="POST">
                            <div class="row form-group">
                              <div class="col-md-12">
                                <label for="noImmat">Numéro d'immatriculation :</label>
                                <input type="text" id="noImmat " name="noImmat" class="form-control">
                              </div>
                            </div>
                            <div class="row form-group">
                              <div class="col-md-12">
                                <label for="station">Station :</label>
                                <select name="station" id="station" name="station" class="form-control">
                                  <?php
while ($row = pg_fetch_row($station)) {
    echo "<option value=\"$row[0]\">$row[0]</option>";
}
?>
                                </select>
                              </div>
                            </div>
                            <div class="row form-group">
                              <div class="col-md-12">
                                <label for="marque">Marque :</label>
                                <input type="text" id="marque " name="marque" class="form-control">
                              </div>
                            </div>
                            <div class="row form-group">
                              <div class="col-md-12">
                                <label for="modele">Modèle :</label>
                                <input type="text" id="modele " name="modele" class="form-control">
                              </div>
                            </div>
                            <div class="row form-group">
                              <div class="col-md-12">
                                <label for="type">Type :</label>
                                <select name="type" id="type" name="type" class="form-control">
                                  <?php
while ($row = pg_fetch_row($typeVehicule)) {
    echo "<option value=\"$row[0]\">$row[0]</option>";
}
?>
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
                                <select name="carburant" id="carburant" name="carburant" class="form-control">
                                  <option value="Gasoil">Gasoil</option>
                                  <option value="Essence">Essence</option>
                                  <option value="Electrique">Electrique</option>
                                </select>
                              </div>
                            </div>
                            <div class="row form-group">
                              <div class="col-md-12">
                                <label for="puissance">Puissance :</label>
                                <input type="number" id="puissance" name="puissance" class="form-control">
                              </div>
                            </div>
                            <div class="row form-group">
                              <div class="col-md-12">
                                <label for="nbKm">Kilométrage :</label>
                                <input type="number" id="nbKm" name="nbKm" class="form-control">
                              </div>
                            </div>
                            <div class="row form-group">
                              <div class="col-md-12">
                                <label for="dateMS">Date de mise en service :</label>
                                <input type="text" id="date" name="dateMS" class="form-control">
                              </div>
                            </div>
                            <div class="row form-group">
                              <div class="col-md-12">
                                <label for="dureeMS">Durée de mise en service en année :</label>
                                <input type="number" id="dureeMS" name="dureeMS" class="form-control">
                              </div>
                            </div>
                            <div class="row form-group">
                              <div class="col-md-12">
                                <label for="nivCarburant">Niveau du carburant :</label>
                                <select name="nivCarburant" id="nivCarburant" name="nivCarburant" class="form-control">
                                  <option value="Plein">Plein</option>
                                  <option value="Elevé">Elevé</option>
                                  <option value="Moitié">Moitié</option>
                                  <option value="Faible">Faible</option>
                                </select>
                              </div>
                            </div>

                            <div class="row form-group">
                              <div class="col-md-12">
                                <input type="submit" class="btn btn-primary btn-block" value="Ajouter">
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

function listVehicule($bdd){
    return pg_query($bdd, "SELECT nom FROM types");
}

function listStation($bdd){
    return pg_query($bdd, "SELECT nom FROM stations");
}

function ajoutVehicule($bdd, $noImmat, $station, $marque, $modele, $type, $nbPlace, $carburant, $puissance, $nbKm, $dateMS, $dureeMS, $nivCarburant){
    $vehiculeExiste = verifVehiculeExiste($bdd, $noImmat);
    if($vehiculeExiste != false){
        $verifVehiculeSupprime = verifVehiculeSupprime($bdd, $noImmat);
        if($verifVehiculeSupprime == false){
            return 'Le véhicule existe déjà dans la base !';
        }else{
            $verifStation = verifStation($bdd, $station);
            if($verifStation == 0){
                return "Le véhicule ne peut pas être ajouté car la station est rempli !";
            }else{
                updateVehicule($bdd, $noImmat, $verifStation, $nbKm, $dateMS, $dureeMS, $nivCarburant);
                return 'Le véhicule a bien été ajouté dans la station';
            }
        }
    }
    $verifStation = verifStation($bdd, $station);
    if($verifStation == 0){
        return "Le véhicule ne peut pas être ajouté car la station est rempli !";
    }else{
        $noType = noType($bdd, $type);
        pg_query($bdd,"BEGIN") or die('Could not start transaction\n');
        $request = "INSERT INTO vehicules(
        no_immat, modele, nb_place, carburant, puissance, nb_km, etat,
        date_mise_serv, duree_serv, niv_carbu, type_id, station_id, marque)
        VALUES ($1, $2, $3, $4, $5, $6, 'Bon état',
        $7, $8, $9, $10, $11, $12);";
        $result = pg_prepare($bdd,'',$request);
        $result = pg_execute($bdd, "",array($noImmat, $modele, $nbPlace, $carburant, $puissance, $nbKm, $dateMS, $dureeMS, $nivCarburant, $noType[0], $verifStation, $marque));
        if($result){
            pg_query($bdd,'COMMIT') or die('Transaction commit failed\n');
            return "Le véhicule a bien été ajouté dans la station";
        }else{
            pg_query($bdd,"ROLLBACK") or die('Transaction rollback failed\n ');
            return "Le véhicule n'a pas pu ajouter dans la station ";
        }
    }
}



function verifStation($bdd, $station){
    $nbPlaceStation = nbPlaceStation($bdd, $station);
    $nbVehiculeStation = nbVehiculeStation($bdd, $nbPlaceStation[1]);
    if($nbPlaceStation[0] == $nbVehiculeStation[0]){
        return 0;
    }else{
        return $nbPlaceStation[1];
    }
    
}

function nbPlaceStation($bdd, $station){
    $request = "SELECT nb_max_v, id
    FROM stations
    WHERE nom = $1";
    $result = pg_prepare($bdd,'',$request);
    $result = pg_execute($bdd, "",array($station));
    $row = pg_fetch_row($result);
    return $row;
}

function nbVehiculeStation($bdd, $noStation){
    $request = "SELECT COUNT(*)
    FROM vehicules
    WHERE station_id = $1";
    $result = pg_prepare($bdd,'',$request);
    $result = pg_execute($bdd, "",array($noStation));
    $row = pg_fetch_row($result);
    return $row;
}

function noType($bdd, $type){
    $request = "SELECT id
    FROM types
    WHERE nom = $1";
    $result = pg_prepare($bdd,'',$request);
    $result = pg_execute($bdd, "",array($type));
    $row = pg_fetch_row($result);
    
    return $row;
}

function verifVehiculeExiste($bdd, $noImmat){
    $request = "SELECT no_immat
    FROM vehicules
    WHERE no_immat=$1";
    $result = pg_prepare($bdd,'',$request);
    $result = pg_execute($bdd, "",array($noImmat));
    $row = pg_fetch_row($result);
    return $row;
}

function updateVehicule($bdd, $noImmat, $station, $nbKm, $dateMS, $dureeMS, $nivCarburant){
    $request = "UPDATE vehicules SET etat='Bon état', station_id=$1, nb_km=$2, date_mise_serv=$3, duree_serv=$4, niv_carbu=$5 WHERE no_immat=$6";
    $result = pg_prepare($bdd,'',$request);
    $result = pg_execute($bdd, "",array($station, $nbKm, $dateMS, $dureeMS, $nivCarburant, $noImmat));
}

function verifVehiculeSupprime($bdd, $noImmat){
    $request = "SELECT no_immat
    FROM vehicules
    WHERE no_immat=$1
    AND etat='Supprimé'";
    $result = pg_prepare($bdd,'',$request);
    $result = pg_execute($bdd, "",array($noImmat));
    $row = pg_fetch_row($result);
    return $row;
}
?>