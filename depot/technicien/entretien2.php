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
                <li><a href="transfert.php">amener un véhicule à une autre station</a></li>
                <li><a href="entretien.php">mettre un véhicule en entretien</a></li>
              </ul>
            </li>
                  <li><a href="../deco.php">Se déconnecter</a></li>
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
            <?php
if(!empty($_SESSION['entretienMise'])){
    echo "<h3>".$_SESSION['entretienMise']."</h3>";
    unset($_SESSION['entretienMise']);
}
?>
              <span class="intro-text-small">ludresCar</span>
              <h1 class="cursive-font">Mise en entretien d'un véhicule.</h1>

          </div>
          <div class="col-md-4 col-md-push-1 animate-box" data-animate-effect="fadeInRight">
            <div class="form-wrap">
              <div class="tab">

                <div class="tab-content">
                  <div class="tab-content-inner active" data-content="signup">
                    <form action="traitMiseEntretien.php" method="POST">
                      <div class="row form-group">
                        <div class="col-md-12">
                          <label for="activities">Immatriculation : </label>
                          <select name="immat" id="activities" class="form-control">
                            <?php
$result = pg_prepare($bdd,"", "SELECT v.no_immat,v.marque,v.modele,v.etat,s.nom,s.id FROM vehicules v, stations s WHERE s.id=v.station_id AND v.etat!='Transfert' AND v.etat!='En réparation' AND s.id=$1");
$result= pg_execute($bdd,'',array($station->getId()));
if (!$result) {
    echo "Une erreur est survenue.\n";
    exit;
}
while ($row = pg_fetch_row($result)) {
    echo "<option value='".$row[0]."'> Immatriculation : ".$row[0]." Véhicule : ".$row[1]." ".$row[2]." état : ".$row[3]." Station : ".$row[4]."</option>";
}
?>
                          </select>
                        </div>
                      </div>
                      <div class="row form-group">
                        <div class="col-md-12">
                          <label for="date-start">Date début entretien</label>
                          <input type="text" id="deb" name="deb" class="form-control">
                        </div>
                      </div>
                      <div class="row form-group">
                        <div class="col-md-12">
                          <label for="date-end">Date fin entretien</label>
                          <input type="text" id="end" name="end" class="form-control">
                        </div>
                      </div>
                      <div class="row form-group">
                        <div class="col-md-12">
                          <label for="date-start">Type d'entretien</label>
                          <input type="text" id="type" name="type" class="form-control">
                        </div>
                      </div>
                      <div class="row form-group">
                        <div class="col-md-12">
                          <input type="submit" name="valid" class="btn btn-primary btn-block" value="Valider entretien">
                        </div>
                      </div>
                    </form>
                  </div>


                </div>
              </div>
            </div>
          </div>
          <div class="col-md-7 mt-text animate-box" data-animate-effect="fadeInUp">
            <span class="intro-text-small">ludresCar</span>
            <h1 class="cursive-font">Fin d'entretien d'un véhicule.</h1>
          </div>
          <div class="col-md-4 col-md-push-1 animate-box" data-animate-effect="fadeInRight">
            <div class="form-wrap">
              <div class="tab">

                <div class="tab-content">
                  <div class="tab-content-inner active" data-content="signup">
                    <form action="traitMiseEntretien.php" method="POST">
                      <div class="row form-group">
                        <div class="col-md-12">
                          <label for="activities">Immatriculation : </label>
                          <select name="immat" id="activities" class="form-control">
                            <?php
$result = pg_prepare($bdd,"", "SELECT v.no_immat,v.marque,v.modele,v.etat,s.nom,s.id FROM vehicules v, stations s WHERE s.id=v.station_id AND v.etat='En réparation' AND s.id=$1");
$result= pg_execute($bdd,'',array($station->getId()));
if (!$result) {
    echo "Une erreur est survenue.\n";
    exit;
}
while ($row = pg_fetch_row($result)) {
    echo "<option value='".$row[0]."'> Immatriculation : ".$row[0]." Véhicule : ".$row[1]." ".$row[2]." état : ".$row[3]." Station : ".$row[4]."</option>";
}
?>
                          </select>
                        </div>
                        <div class="row form-group">
                          <div class="col-md-12">
                            <input type="submit" name="validFin" class="btn btn-primary btn-block" value="Valider fin entretien">
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
    return 'Le véhicule existe déjà dans la base !';
  }
  $verifStation = verifStation($bdd, $station);
  if($verifStation == 0){
    return "Le véhicule ne peut pas être ajouté car la station est rempli !";
  }else{
    $noType = noType($bdd, $type);
    $request = "INSERT INTO vehicules(
            no_immat, modele, nb_place, carburant, puissance, nb_km, etat, 
            date_mise_serv, duree_serv, niv_carbu, type_id, station_id, marque)
    VALUES ($1, $2, $3, $4, $5, $6, 'Bon état',
            $7, $8, $9, $10, $11, $12);";
    $result = pg_prepare($bdd,'',$request);
    $result = pg_execute($bdd, "",array($noImmat, $modele, $nbPlace, $carburant, $puissance, $nbKm, $dateMS, $dureeMS, $nivCarburant, $noType[0], $verifStation, $marque));
    return "Le véhicule a bien été ajouté dans la station !";
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
?>