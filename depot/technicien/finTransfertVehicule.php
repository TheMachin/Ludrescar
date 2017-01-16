<?php
session_start();
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
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Fin transfert du véhicule</title>
    </head>
    <body>
<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
if(isset($_POST['valid'])){
    if(!empty($_POST['etat'])){
        $etat=$_POST['etat'];
        if($etat=="c"){
            $etat="Correct";
        }else if($etat="be"){
            $etat="Bon état";
        }else if($etat="hs"){
            $etat="Hors service";
        }else{
            sendError("Erreur traitement formulaire : L'état du véhicule n'existe pas");
        }
    }else{
        sendError("Erreur traitement formulaire : L'état du véhicule n'a pas été spécifié");
    }
    
    if(!empty($_POST['km'])){
        $km=$_POST['km'];
    }else{
        sendError("Erreur : Le kilométrage du véhicule n'a pas été spécifié");
    }
    
    if(!empty($_POST['immat'])){
        $immat=$_POST['immat'];
    }else{
        sendError("Erreur traitement du formulaire : Veuillez nous excuser.");
    }
    
    if(!empty($_POST['niv'])){
        $niv=$_POST['niv'];
    }else{
        sendError("Erreur traitement formulaire : Le niveau de carburant du véhicule n'a pas été spécifié");
    }
    
    $kmAvant= getKmVehicule($immat, $bdd);
    
    if($kmAvant>$km){
        //probleme
        sendError("Erreur : Le kilométrage spécifié ne doit pas être inférieure à celui du véhicule");
    }
    
    
    $requete="UPDATE vehicules SET etat=$1, nb_km=$2,niv_carbu=$3 WHERE no_immat=$4";
    $result= pg_prepare($bdd,'',$requete);
    $result = pg_execute($bdd, "", array($etat,$km,$niv,$immat));
    
    ?>
        <h3>Le véhicule est à nouveau disponible</h3>
        
    <?php
    
}else if(!empty($_GET['immat'])){
    $immat=$_GET['immat'];
    $requete="SELECT v.no_immat,v.marque,v.modele,v.etat,s.nom,s.adresse FROM vehicules v, stations s WHERE no_immat=$1 AND v.station_id=s.id";
    $result= pg_prepare($bdd,'',$requete);
    $result = pg_execute($bdd, "", array($immat));

    $row = pg_fetch_row($result);
    
    ?>
        <div class="row">
            <div class="col-md-12 col-md-offset-0 text-left">
                <div class="row row-mt-15em">
                        <div class="col-md-7 mt-text animate-box" data-animate-effect="fadeInUp">
                                <span class="intro-text-small">ludresCar</span>
                                <h1 class="cursive-font">Fin de transfert d'un véhicule.</h1>	
                        </div>
                        <div class="col-md-4 col-md-push-1 animate-box" data-animate-effect="fadeInRight">
                                <div class="form-wrap">
                                        <div class="tab">

                                                <div class="tab-content">
                                                        <div class="tab-content-inner active" data-content="signup">
                                                                
                                                                <h3 class="cursive-font">Véhicule : <?php echo $row[1]." ".$row[2]; ?></h3>
                                                                <h3 class="cursive-font">Transfert vers la station <?php echo $row[4]; ?></h3>
                                                                <form action="#" method="POST">
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
                                                                                        <input type="hidden" id="immat" name="immat" value='<?php echo $row[0]; ?>'>
                                                                                </div>
                                                                        </div>
                                                                        <div class="row form-group">
                                                                                <div class="col-md-12">
                                                                                        <label for="date-start">Niveau du carburant</label>
                                                                                        <select name="niv" id="activities" class="form-control">
                                                                                            <option value="p">Plein</option>
                                                                                            <option value="v">Vide</option>
                                                                                        </select>
                                                                                </div>
                                                                        </div>
                                                                        <div class="row form-group">
                                                                                <div class="col-md-12">
                                                                                        <input type="submit" name="valid" class="btn btn-primary btn-block" value="Valider fin de transfert">
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
    
}else{
    sendError("Pas de véhicule sélectionné");
}

    function sendError($msgError){
        $_SESSION['finTransfert']=$msgError;
        header("location:".  $_SERVER['HTTP_REFERER']); 
        exit(0);
    }
    
    function getKmVehicule($immat,$bdd){
        $requete="SELECT nb_km FROM vehicules where no_immat=$1";
            $result= pg_prepare($bdd,'',$requete);
            $result = pg_execute($bdd, "", array($immat));
            $row = pg_fetch_row($result);
            return $row[0];
    }