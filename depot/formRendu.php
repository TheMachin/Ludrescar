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
include('../classe/HistStationVehicule.php');
include('../classe/Societe.php');
include('../classe/Penalite.php');
include('../../bdd/bdd.php');
    session_start();
    if(!empty($_SESSION['vehiculeRenduError'])){
        echo $_SESSION['vehiculeRenduError'];
        unset($_SESSION['vehiculeRenduError']);
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
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <div class="row">
            <div class="col-md-12 col-md-offset-0 text-left">
                <div class="row row-mt-15em">
                        <div class="col-md-7 mt-text animate-box" data-animate-effect="fadeInUp">
                                <span class="intro-text-small">ludresCar</span>
                                <h1 class="cursive-font">Formulaire de rendu du véhicule.</h1>	
                        </div>
                        <div class="col-md-4 col-md-push-1 animate-box" data-animate-effect="fadeInRight">
                                <div class="form-wrap">
                                        <div class="tab">

                                                <div class="tab-content">
                                                        <div class="tab-content-inner active" data-content="signup">
                                                                <?php
                                                                
                                                                    if(!empty($_GET['id'])){
                                                                        $location= getLocations($_GET['id'], $bdd);
                                                                        $vehicule=$location->getVehicule();
                                                                        $date=new DateTime();
                                                                        $date=$date->format('d/m/Y');
                                                                    }else{
                                                                        goPagePred("");
                                                                    }
                                                                
                                                                    function goPagePred($msgError){
                                                                        header("location:".  $_SERVER['HTTP_REFERER']); 
                                                                        exit(0);
                                                                    }
                                                                ?>
                                                                <h3 class="cursive-font">Véhicule : <?php echo $vehicule->getMarque()." ".$vehicule->getModele(); ?></h3>
                                                                <h3 class="cursive-font">Date et heure du rendu prévu <?php echo $location->getDate_fin_prev()." ".$location->getHeure_fin(); ?></h3>
                                                                <h3 class="cursive-font">Date du jour : <?php echo $date; ?></h3>
                                                                <form action="traitFormRendu.php" method="POST">
                                                                        <div class="row form-group">
                                                                                <div class="col-md-12">
                                                                                    <label for="activities">Etat du véhicule</label>
                                                                                    <select name="etat" id="activities" class="form-control">
                                                                                            <option value="c">Correct</option>
                                                                                            <option value="be">Bon état</option>
                                                                                            <option value="hs">Hors service</option>
                                                                                    </select>
                                                                                    <br><br>
                                                                                    <label>
                                                                                        Liste des états du véhicule : <br>
                                                                                        <strong>Correct :</strong> Le véhicule comporte des rayures ou des dégats léger au niveau de la carrosserie. <br>
                                                                                        <strong>En bon état :</strong> Le véhicule ne comporte pas de dégats. <br>
                                                                                        <strong>Hors service : </strong> Le véhicule comporte des dégats important et ne peut pas être roulé.
                                                                                    </label>
                                                                                    <br><br>
                                                                                </div>
                                                                        </div>
                                                                        <div class="row form-group">
                                                                                <div class="col-md-12">
                                                                                        <label for="date-start">Kilométrage du véhicule</label>
                                                                                        <input type="text" id="km" name="km" class="form-control">
                                                                                        <input type="hidden" id="km" name="idLoc" class="form-control" value="<?php echo $_GET['id']; ?>">
                                                                                </div>
                                                                        </div>
                                                                        <div class="row form-group">
                                                                                <div class="col-md-12">
                                                                                        <label for="date-end">Commentaire</label>
                                                                                        <input type="text" id="comm" name="comm" class="form-control">
                                                                                </div>
                                                                        </div>
                                                                        <div class="row form-group">
                                                                                <div class="col-md-12">
                                                                                        <label for="date-start">Niveau du carburant</label>
                                                                                        <select name="niv" id="activities" class="form-control">
                                                                                            <option value="p">Plein</option>
                                                                                            <option value="e">Elevé</option>
                                                                                            <option value="m">Moitié</option>
                                                                                            <option value="f">Faible</option>
                                                                                        </select>
                                                                                </div>
                                                                        </div>
                                                                        <div class="row form-group">
                                                                                <div class="col-md-12">
                                                                                        <input type="submit" name="valid" class="btn btn-primary btn-block" value="Valider formulaire de fin de location">
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
        <?php
        // put your code here
        ?>
    </body>
</html>

<?php
    function getVehicules($id,$bdd){
        $requete="SELECT * FROM vehicules where no_immat=$1";
            $result= pg_prepare($bdd,'',$requete);
            $result = pg_execute($bdd, "", array($id));
            $row = pg_fetch_row($result);
            $vehicule=new Vehicule($row[0], $row[12], $row[1], $row[2], $row[3], $row[4], $row[5], $row[6], $row[7], $row[8], $row[9], getStations($row[11], $bdd), getTypes($row[10], $bdd));
            return $vehicule;
    }
    
    function getLocations($id,$bdd){
        $compteU=new CompteUtilisateur(0, "");
        $user=new Utilisateur(0, "", "", "", "", "", "", "", 0, $compteU);
        $form=new Formulaire(0, "", "", "", "", "Début", "", "");
        $retour=new Retour(0, "", $form);
        $societe=new Societe(0, "");
        $penalite=New Penalite(0, "retard", 0);
        $arrPenalite=new ArrayObject($penalite);
        $requete="SELECT * FROM locations where id=$1";
        $result= pg_prepare($bdd,'',$requete);
        $result = pg_execute($bdd, "", array($id));
        $row = pg_fetch_row($result);
        $location=new Location($row[0], $row[0], $row[2], $row[3], $row[4], $row[5], $row[6], $row[7], $row[8], $row[9], getVehicules($row[10], $bdd), $user, getStations($row[14], $bdd), getStations($row[15], $bdd), $form, new Retour(0, NULL, $form), $societe, $arrPenalite);
        return $location;
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
?>