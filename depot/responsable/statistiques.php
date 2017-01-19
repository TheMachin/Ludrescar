<?php
include('../../classe/Statistique.php');
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


$requete="SELECT nom From stations";
$result=pg_query($bdd,$requete);
$listStation=array();
while ($row = pg_fetch_row($result)) {
    $listStation[]=$row[0];
}

$requete="SELECT st.nb_location,st.nb_incident,st.nb_penalite,st.nb_entretien,st.montant_penalite,st.montant_total,st.nb_annulation,s.nom FROM stations s, statistiques st WHERE s.statistique_id=st.id";
$result=pg_query($bdd,$requete);
$tabStats=array();
while ($row = pg_fetch_row($result)) {
    $statistique=new Statistique(0, $row[0],$row[2],$row[3],$row[4],$row[5],$row[6]);
    $statistique->setNb_incident($row[1]);
    $tabStats[$row[7]]=$statistique;
}

$requete="SELECT COUNT(v.no_immat),s.nom FROM vehicules v, stations s WHERE s.id=v.station_id GROUP BY s.id";
$result=pg_query($bdd,$requete);
$tabVehiculeByStation=array();
$nbVehiculeTot=0;
while ($row = pg_fetch_row($result)) {
    $tabVehiculeByStation[$row[1]]=$row[0];
    $nbVehiculeTot=$nbVehiculeTot+$row[0];
}

$requete="SELECT COUNT(v.no_immat),s.nom FROM vehicules v, stations s WHERE s.id=v.station_id GROUP BY s.id";
$result=pg_query($bdd,$requete);
$tabVehiculeByStation=array();
$nbVehiculeTot=0;
while ($row = pg_fetch_row($result)) {
    $tabVehiculeByStation[$row[1]]=$row[0];
    $nbVehiculeTot=$nbVehiculeTot+$row[0];
}

$requete="SELECT COUNT(l.id),t.nom FROM vehicules v, types t, locations l WHERE l.vehicule_immat=v.no_immat AND v.type_id=t.id GROUP BY t.id";
$result=pg_query($bdd,$requete);
$nbType=array();
while ($row = pg_fetch_row($result)) {
    $nbType[]=[$row[1],$row[0]];
}

$requete="SELECT COUNT(e.id), t.nom,t.prenom FROM entretiens e, techniciens t WHERE e.technicien_id=t.id GROUP BY t.id";
$result=pg_query($bdd,$requete);
$nbEntretien=array();
while ($row = pg_fetch_row($result)) {
    $nbEntretien[]=[$row[1],$row[2],$row[0]];
}

$requete="SELECT COUNT(h.id), s.nom FROM stations s, histstationvehicules h WHERE h.station_id=s.id GROUP BY s.id";
$result=pg_query($bdd,$requete);
$deplacementByStation=array();
while ($row = pg_fetch_row($result)) {
    $deplacementByStation[$row[1]]=$row[0];
}


?>




  <!DOCTYPE html>
  <!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
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
              <div id="gtco-logo"><a href="indexco.php">LudresCar <em>.</em></a></div>
            </div>
            <div class="col-xs-8 text-right menu-1">
              <ul>
                <li class="has-dropdown">
                  <a href="#">Services</a>
                  <ul class="dropdown">
                    <li><a href="AjoutVehicule.php">Ajouter un véhicule</a></li>
                    <li><a href="SupprimerVehicule.php">Supprimer un véhicule</a></li>
                    <li><a href="transfert.php">Transférer un véhicule</a></li>
                    <li><a href="entretien.php">Mettre un véhicule en entretien</a></li>
                    <li><a href="ajoutType.php">Ajouter un type de véhicule</a></li>
                  </ul>
                </li>
                <li><a href="../decoEmploye.php">Se déconnecter</a></li>
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
                  <h1 class="cursive-font">Statistiques</h1>
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
              <h2 class="cursive-font primary-color">Nombre de véhicule totale <?php echo $nbVehiculeTot;?></h2>
            </div>
          </div>

          <div class="row">

            <div class='container-fluid'>















              <h2 class="cursive-font primary-color">Information par station</h2>
              <table id='tableID' class="table table-bordered table-striped" border='1'>
                <thead>
                  <th>Nom Station</th>
                  <th>Nombre de véhicule</th>
                  <th>Chiffre d'affaire de la station</th>
                  <th>Nombre de location</th>
                  <th>Nombre de pénalités infligées</th>
                  <th>Pourcentage d'incident</th>
                  <th>Nombre d'entretiens cumulé des véhicules</th>
                  <th>Nombre d'annulation de location</th>
                  <th>Nombre de transfert</th>
                </thead>
                <tbody>
                  <?php
for($i=0;$i<count($listStation);$i++){
    $statistique=$tabStats[$listStation[$i]];
    ?>
                    <tr>
                      <td>
                        <?php echo $listStation[$i]; ?>
                      </td>
                      <td>
                        <?php echo $tabVehiculeByStation[$listStation[$i]];?>
                      </td>
                      <td>
                        <?php echo $statistique->getMontant_total(); ?>€</td>
                      <td>
                        <?php echo $statistique->getNb_location(); ?>
                      </td>
                      <td>
                        <?php echo $statistique->getNb_penalite(); ?>
                      </td>
                      <td>
                        <?php echo round(($statistique->getNb_incident()/$nbVehiculeTot)*100,2); ?>%</td>
                      <td>
                        <?php echo $statistique->getNb_entretien(); ?>
                      </td>
                      <td>
                        <?php echo $statistique->getNb_annulation(); ?>
                      </td>
                      <td>
                        <?php echo $deplacementByStation[$listStation[$i]]; ?>
                      </td>
                    </tr>
                    <?php
}
?>
                </tbody>
              </table>

              
              <h2 class="cursive-font primary-color">Nombre de locations en fonction du type de véhicule</h2>
              <table id='tableID' class="table table-bordered table-striped" border='1'>
                <thead>
                  <th>Type de véhicule</th>
                  <th>Nombre de fois loué</th>
                </thead>
                <tbody>
                  <?php
for($i=0;$i<count($nbType);$i++){
    ?>
                    <tr>
                      <td>
                        <?php echo $nbType[$i][0]; ?>
                      </td>
                      <td>
                        <?php echo $nbType[$i][1]; ?>
                      </td>
                    </tr>
                    <?php
}
?>
                </tbody>
              </table>
              <br>
              <h2 class="cursive-font primary-color">Nombre d'entretien par technicien</h2>
              <table id='tableID' class="table table-bordered table-striped" border='1'>
                <thead>
                  <tr>
                    <th>Nom technicien</th>
                    <th>Prénom technicien</th>
                    <th>Nombre d'entretien</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
for($i=0;$i<count($nbEntretien);$i++){
    ?>
                    <tr>
                      <td>
                        <?php echo $nbEntretien[$i][0]; ?>
                      </td>
                      <td>
                        <?php echo $nbEntretien[$i][1]; ?>
                      </td>
                      <td>
                        <?php echo $nbEntretien[$i][2]; ?>
                      </td>
                    </tr>
                    <?php
}
?>
                </tbody>
              </table>

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