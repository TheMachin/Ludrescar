<?php
include('../../bdd/bdd.php');
include('../../classe/Station.php');
include('../../classe/Vehicule.php');
include('../../classe/Type.php');
include('../../classe/Statistique.php');
include('../../classe/HistStationVehicule.php');
session_start();
?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
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

    </head>
    <body>
        <header id="gtco-header" class="gtco-cover gtco-cover-md" role="banner" style="background-image: url(images/img_bg_1.jpg)" data-stellar-background-ratio="0.5">
        <div class="overlay"></div>
        <div class="gtco-container">
          <div class="row">
            <div class="col-md-12 col-md-offset-0 text-left">


              <div class="row row-mt-15em">
                <div class="col-md-7 mt-text animate-box" data-animate-effect="fadeInUp">
                  <span class="intro-text-small">ludresCar</span>
                  <h1 class="cursive-font">Supprimer un véhicule</h1>
                </div>
              </div>
            </div>
          </div>
        </div>
      </header>
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
                        $hist->insert($bdd);
                        $vehicule->setStation($stationDestination);
                        $vehicule->setEtat("Transfert");
                        $vehicule->updateEtat($bdd);
                        $vehicule->updateStation($bdd);
                        
                        /*supprVehiculeStation($immat, $bdd);
                        updateEtatVehicule($immat, $bdd, 'Transfert');*/
                        echo "<h3>Succès : Le véhicule est maintenant en cours de transfert</h3>";
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
                                                        $result = pg_query($bdd, "SELECT v.no_immat,v.marque,v.modele,v.etat,s.nom,s.id FROM vehicules v, stations s WHERE s.id=v.station_id");
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
        
        $requete="SELECT * FROM locations WHERE vehicule_immat=$1 AND (etatlocation='Annulé' OR etatlocation='Terminé')";
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