<?php

include('../../classe/Station.php');
include('../../classe/Vehicule.php');
include('../../classe/Type.php');
include('../../classe/Statistique.php');
include('../../classe/HistStationVehicule.php');
//session_start();

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
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        // put your code here
            if(isset($_POST['validS'])){
                
                if(!empty($_POST['description'])){
                    $description=$_POST['description'];
                }else{
                    $description='';
                }
                
                //on récupère son numero
                $immat=$_SESSION['immat'];
                //la liste des véhicules
                $tabVehicule= unserialize($_SESSION['tabVehicule']);
                //on récupère le véhicule concerné
                $vehicule=$tabVehicule[$immat];
                //on récupère la station dans laquelle le véhicule se trouve
                $stationInitiale= getStations($vehicule->getStation()->getId(), $bdd);
                //id station de destination
                $id=$_POST['station'];
                $stationDestination=getStations($id,$bdd);
                //on vérifie si la station de destination peut accueillir le véhicule
                $bool= verifStation($stationDestination, $bdd);
                if($bool){
                    //on vérifie si le véhicule peut etre transféré
                    $checkEtatV= verifEtatVehicule($immat, $bdd);
                    if($checkEtatV==NULL){
                        
                        //transfert du véhicule
                        
                        $date=new DateTime('now');
                        $hist=new HistStationVehicule(0, $date->format('Y-m-d') , $description, $stationInitiale, $vehicule);
                        pg_query($bdd,"BEGIN") or die('Could not start transaction\n');
                        $req1=$hist->insertTrans($bdd);
                        $vehicule->setStation($stationDestination);
                        $vehicule->setEtat("Transfert");
                        $req2=$vehicule->updateEtatTrans($bdd);
                        $req3=$vehicule->updateStationTrans($bdd);
                        if($req1 and $req2 and $req3){
                            echo "<h3>Succès : Le véhicule est maintenant en cours de transfert</h3>";
                            pg_query($bdd,'COMMIT') or die('Transaction commit failed\n');
                        }else{
                            echo "<h3>Echec : Le véhicule n'a pas été mis en transfert</h3>";
                            pg_query($bdd,"ROLLBACK") or die('Transaction rollback failed\n ');
                        }
                        
                        /*supprVehiculeStation($immat, $bdd);
                        updateEtatVehicule($immat, $bdd, 'Transfert');*/
                    }else{
                        //pas de transfert et affichage notification 
                        echo '<h3>'.$checkEtatV.'</h3>';
                    }
                }else{
                    echo '<h3>La station est rempli (complet)</h3>';
                }
                
            }
        ?>
        <div class="row">
            <div class="col-md-12 col-md-offset-0 text-left">
                <div class="row row-mt-15em">
                    <div class="col-md-7 mt-text animate-box" data-animate-effect="fadeInUp">
                        <span class="intro-text-small">ludresCar</span>
                        <h1 class="cursive-font">Transfert du véhicule.</h1>	
                    </div>
                    <div class="col-md-4 col-md-push-1 animate-box" data-animate-effect="fadeInRight">
                        <div class="form-wrap">
                            <div class="tab">
                                <div class="tab-content">
                                    <div class="tab-content-inner active" data-content="signup">
                                        <form method="POST">
                                            <?php
                                                if(!isset($_POST['valid'])){
                                            ?>
                                            <div class="row form-group">                                                                                
                                                <div class="col-md-12">
                                                    <label for="activities">Immatriculation : </label>
                                                    <select name="immat" id="activities" class="form-control">
                                                        <?php 
                                                        $requete="SELECT v.no_immat,v.marque,v.modele,v.etat,s.nom,s.id FROM vehicules v, stations s WHERE s.id=v.station_id";
                                                        $result = pg_query($bdd,$requete);
                                                        if (!$result) {
                                                          echo "Une erreur est survenue.\n";
                                                          exit;
                                                        }
                                                        $tabVehicule=array();
                                                        while ($row = pg_fetch_row($result)) {
                                                            $vehicule=new Vehicule($row[0], $row[1], $row[2], 0, "", 0, 0, $row[3], "", "", "", new Station($row[5], $row[4], "", 0, new Statistique(0, 0, 0, 0, 0, 0, 0)), new Type(0, "", 0, 0));
                                                            $tabVehicule[$row[0]]=$vehicule;
                                                            echo "<option value='".$row[0]."'> Immatriculation : ".$row[0]." Véhicule : ".$row[1]." ".$row[2]." état : ".$row[3]." Station : ".$row[4]."</option>";
                                                        }
                                                        $_SESSION['tabVehicule']= serialize($tabVehicule);
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                    <div class="col-md-12">
                                                            <input type="submit" name="valid" class="btn btn-primary btn-block" value="Choisir véhicule">
                                                    </div>
                                            </div>
                                            <?php
                                                }
                                                if(isset($_POST['valid'])){
                                                    $immat=$_POST['immat'];
                                                    $tabVehicule= unserialize($_SESSION['tabVehicule']);
                                                    $_SESSION['immat']=$immat;
                                                    $vehicule=$tabVehicule[$immat];
                                                    echo "<h3>Véhicule sélectionné</h3>";
                                                    echo "<h3>".$vehicule->getNo_immat()."'> Immatriculation : ".$vehicule->getNo_immat()." Véhicule : ".$vehicule->getMarque()." ".$vehicule->getModele()." état : ".$vehicule->getEtat()." Station : ".$vehicule->getStation()->getNom()."</h3>";
                                            ?>
                                            <div class="row form-group">
                                                <div class="col-md-12">
                                                    <label for="activities">Station</label>
                                                    <select name="station" id="activities" class="form-control">
                                                        <?php 

                                                        $result = pg_prepare($bdd,"" ,"SELECT s.id,s.nom, s.adresse FROM stations s, vehicules v where v.no_immat=$1 and v.station_id!=s.id");
                                                        $result= pg_execute($bdd,"",array($immat));
                                                        if (!$result) {
                                                          echo "Une erreur est survenue.\n";
                                                          exit;
                                                        }

                                                        while ($row = pg_fetch_row($result)) {
                                                            echo "<option value='".$row[0]."'> Station : ".$row[1]." Adresse : ".$row[2]."</option>";
                                                        }

                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="col-md-12">
                                                    <label for="date-start">Description du transfert (pas obligatoire)</label>
                                                    <input type="text" id="description" name="description" class="form-control">
                                                </div>
                                            </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col-md-12">
                                                        <input type="submit" name="validS" class="btn btn-primary btn-block" value="Choisir station">
                                                </div>
                                            </div>
                                            <?php
                                                }
                                            ?>
                                        </form>	
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
        </div>
    </body>
</html>

<?php
    function verifStation(Station $station,$bdd){
        
        $result = pg_prepare($bdd,"" ,"SELECT count(no_immat) FROM vehicules WHERE station_id=$1");
        $result= pg_execute($bdd,"",array($station->getId()));
        if (!$result) {
          echo "Une erreur est survenue.\n";
          exit;
        }
        $count=pg_num_rows($result);
        
        if($count==$station->getNb_max_v()){
            return FALSE;
        }else{
            return TRUE;
        }
        
    }
    
    function getStations($id,$bdd){
            $requete="SELECT * FROM stations where id=$1";
            $result= pg_prepare($bdd,'',$requete);
            $result = pg_execute($bdd, "", array($id));
            while ($row = pg_fetch_row($result)) {
                $station=new Station($row[0], $row[1], $row[2], $row[3], new Statistique($row[4], 0, 0, 0, 0, 0, 0));
            }
            return $station;
    }
    
    function verifEtatVehicule($immat,$bdd){
        
        $requete="SELECT * FROM locations WHERE vehicule_immat=$1 AND etatlocation!='Annulé' AND etatlocation!='Terminé'";
        $result= pg_prepare($bdd,'',$requete);
        $result = pg_execute($bdd, "", array($immat));
        $count= pg_num_rows($result);
        if($count==0){
            $requete="SELECT etat FROM vehicules where no_immat=$1";
            $result= pg_prepare($bdd,'',$requete);
            $result = pg_execute($bdd, "", array($immat));
            $row = pg_fetch_row($result);

            if($row[0]==="Hors service"){
                return "Le véhicule ne peut pas être transféré car il est hors service";
            }else if($row[0]==="En réparation"){
                return "Le véhicule ne peut pas être transféré car il est en entretien";
            }else if($row[0]==="Transfert"){
                return "Le véhicule ne peut pas être transféré car il est en cours de transfert";
            }else{
                return NULL;
            }
        }else{
            return "Le véhicule ne peut pas être transféré car une location est en cours ou une location a été réservée";
        }
    }
    
    function supprVehiculeStation($immat,$bdd){
        $requete="UPDATE vehicules SET station_id=$1 WHERE no_immat=$2";
        $result= pg_prepare($bdd,'',$requete);
        $result = pg_execute($bdd, "", array(NULL,$immat));
    }
    
    function updateEtatVehicule($immat,$bdd,$etat){
        $requete="UPDATE vehicules SET etat=$1 WHERE no_immat=$2";
        $result= pg_prepare($bdd,'',$requete);
        $result = pg_execute($bdd, "", array($etat,$immat));
    }
    
?>


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
                  <li><a href="#">Statistiques</a></li>
                  <li class="has-dropdown">
                     <a href="#">Services</a>
                     <ul class="dropdown">
                <li><a href="#">Ajouter un véhicule</a></li>
                <li><a href="#">Supprimer un véhicule</a></li>
                <li><a href="#">amener un véhicule à une autre station</a></li>
                <li><a href="#">mettre un véhicule en entretien</a></li>
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
                <h2 class="cursive-font primary-color">Les chiffres</h2>
                <p>Ludrescar en quelques chiffres.</p>
              </div>
            </div>

            <div class="row">

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
