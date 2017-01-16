<?php
include('../../bdd/bdd.php');
include('../../classe/Technicien.php');
include('../../classe/CompteEmploye.php');
include('../../classe/Statistique.php');
include('../../classe/Station.php');


$technicien=new Technicien(33, "Siesta", "Pedro", new Station(15, "La station", "ché pas", 15, new Statistique(0, 0, 0, 0, 0, 0, 0)), new CompteEmploye(33, ""));
$station=$technicien->getStation();
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
                                                                                    $result = pg_prepare($bdd,"", "SELECT v.no_immat,v.marque,v.modele,v.etat,s.nom,s.id FROM vehicules v, stations s WHERE s.id=v.station_id AND v.etat!='Transfert' AND s.id=$1");
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
                    </div>
                </div>
        </div>
        <?php
        // put your code here
        ?>
    </body>
</html>
