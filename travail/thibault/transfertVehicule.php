<?php
include('../../bdd/bdd.php');
include('../../classe/Station.php');
include('../../classe/Statistique.php');
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
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        // put your code here
            if(isset($_POST['validS'])){
                $immat=$_SESSION['immat'];
                $tabArray= unserialize($_SESSION['tabImmat']);
                $id=$_POST['station'];
                
                $bool= verifStation($id, $bdd);
                if($bool){
                    $checkEtatV= verifEtatVehicule($immat, $bdd);
                    if($checkEtatV==NULL){
                        supprVehiculeStation($immat, $bdd);
                        updateEtatVehicule($immat, $bdd, 'Transfert');
                        echo "<h3>Le véhicule n'est plus dans la station et il est en cours de transfert</h3>";
                    }else{
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
                                                                                            $result = pg_query($bdd, "SELECT v.no_immat,v.marque,v.modele,v.etat,s.nom FROM vehicules v, stations s WHERE s.id=v.station_id");
                                                                                            if (!$result) {
                                                                                              echo "Une erreur est survenue.\n";
                                                                                              exit;
                                                                                            }
                                                                                            $tabTransfert=array();
                                                                                            while ($row = pg_fetch_row($result)) {
                                                                                                $tabTransfert[$row[0]]="Immatriculation : ".$row[0]." Véhicule : ".$row[1]." ".$row[2]." état : ".$row[3]." Station : ".$row[4];
                                                                                                echo "<option value='".$row[0]."'> Immatriculation : ".$row[0]." Véhicule : ".$row[1]." ".$row[2]." état : ".$row[3]." Station : ".$row[4]."</option>";
                                                                                            }
                                                                                            $_SESSION['tabImmat']= serialize($tabTransfert);
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
                                                                                $tabArray= unserialize($_SESSION['tabImmat']);
                                                                                $_SESSION['immat']=$immat;
                                                                                echo "<h3>Véhicule sélectionné</h3>";
                                                                                echo "<h3>".$tabArray[$immat]."</h3>";
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
    function verifStation($id,$bdd){
        $station= getStations($id, $bdd);
        
        $result = pg_prepare($bdd,"" ,"SELECT count(no_immat) FROM vehicules WHERE station_id=$1");
        $result= pg_execute($bdd,"",array($id));
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