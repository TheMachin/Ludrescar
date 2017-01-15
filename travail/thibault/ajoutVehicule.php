<?php
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
        <title></title>
    </head>
    <body>
        <?php
            if(isset($_POST['valid'])){
                if(!empty($_POST['immat'])&&!empty($_POST['marque'])&&!empty($_POST['modele'])&&!empty($_POST['place'])&&!empty($_POST['carbu'])&&!empty($_POST['puiss'])&&!empty($_POST['km'])&&!empty($_POST['mise'])&&!empty($_POST['serv'])&&!empty($_POST['tp'])&&!empty($_POST['station'])){
                    $immat=$_POST['immat'];
                    $marque=$_POST['marque'];
                    $modele=$_POST['modele'];
                    $place=$_POST['place'];
                    $carbu=$_POST['carbu'];
                    $puiss=$_POST['puiss'];
                    $km=$_POST['km'];
                    $mise=$_POST['mise'];
                    $serv=$_POST['serv'];
                    $tp=$_POST['tp'];
                    $station=$_POST['station'];
                    

                    $requete="select count(no_immat) from stations s, vehicules v where s.id=$1 and s.id=v.station_id;";
                    $result= pg_prepare($bdd,'countVehicule',$requete);
                    $result = pg_execute($bdd, "countVehicule", array($station));
                    $row = pg_fetch_row($result);
                    
                    $requete="select nb_max_v from stations where id=$1;";
                    $result= pg_prepare($bdd,'max_station',$requete);
                    $result = pg_execute($bdd, "max_station", array($station));
                    $row2 = pg_fetch_row($result);
                    
                    if($row[0]+1<=$row2[0]){
                    
                        $requete="select * from vehicules where no_immat=$1;";
                        $result= pg_prepare($bdd,'checkMail',$requete);
                        $result = pg_execute($bdd, "checkMail", array($immat));
                        $count= pg_num_rows($result);
                        if($count==0){
                            $requete="insert into vehicules(no_immat,marque,modele,nb_place,carburant,puissance,nb_km,etat,date_mise_serv,duree_serv,niv_carbu,type_id,station_id) values($1,$2,$3,$4,$5,$6,$7,$8,$9,$10,$11,$12,$13)";
                            $result= pg_prepare($bdd,'insert type',$requete);
                            $result= pg_execute($bdd,'insert type',array($immat,$marque,$modele,$place,$carbu,$puiss,$km,"Bon état",$mise,$serv,'Plein',$tp,$station));
                            echo "Le véhicule a été ajouté";
                        }else{
                            echo "<h3>Le véhicule existe déjà</h3>";
                        }
                    }else{
                        echo "<h3>La station est complet et ne peut pas accueillir plus de véhicule</h3>";
                    }
                }else{
                    echo "<h3>Veuillez remplir le champs</h3>";
                }
            }
        ?>
        <div class="row">
            <div class="col-md-12 col-md-offset-0 text-left">
                <div class="row row-mt-15em">
                        <div class="col-md-7 mt-text animate-box" data-animate-effect="fadeInUp">
                                <span class="intro-text-small">ludresCar</span>
                                <h1 class="cursive-font">Ajout du véhicule.</h1>	
                        </div>
                        <div class="col-md-4 col-md-push-1 animate-box" data-animate-effect="fadeInRight">
                                <div class="form-wrap">
                                        <div class="tab">

                                                <div class="tab-content">
                                                        <div class="tab-content-inner active" data-content="signup">
                                                                
                                                                
                                                                <form method="POST">
                                                                        <div class="row form-group">
                                                                                <div class="col-md-12">
                                                                                        <label for="date-start">Immatriculation</label>
                                                                                        <input type="text" id="type" name="immat" class="form-control">
                                                                                </div>
                                                                                <div class="col-md-12">
                                                                                        <label for="date-start">Marque</label>
                                                                                        <input type="text" id="type" name="marque" class="form-control">
                                                                                </div>
                                                                                <div class="col-md-12">
                                                                                        <label for="date-start">Modèle</label>
                                                                                        <input type="text" id="type" name="modele" class="form-control">
                                                                                </div>
                                                                                <div class="col-md-12">
                                                                                        <label for="date-start">Nombre de place</label>
                                                                                        <input type="number" id="type" name="place" class="form-control">
                                                                                </div>
                                                                                <div class="col-md-12">
                                                                                        <label for="date-start">Carburant</label>
                                                                                        <input type="text" id="type" name="carbu" class="form-control">
                                                                                </div>
                                                                                <div class="col-md-12">
                                                                                        <label for="date-start">Puissance</label>
                                                                                        <input type="number" id="type" name="puiss" class="form-control">
                                                                                </div>
                                                                                <div class="col-md-12">
                                                                                        <label for="date-start">Kilométrage</label>
                                                                                        <input type="number" id="type" name="km" class="form-control">
                                                                                </div>
                                                                                <div class="col-md-12">
                                                                                        <label for="date-start">Date de mise en service</label>
                                                                                        <input type="text" id="type" name="mise" class="form-control" placeholder="YYYY-MM-DD">
                                                                                </div>
                                                                                <div class="col-md-12">
                                                                                        <label for="date-start">Durée service en année</label>
                                                                                        <input type="number" id="type" name="serv" class="form-control">
                                                                                </div>
                                                                                <div class="row form-group">
                                                                                <div class="col-md-12">
                                                                                    <label for="activities">Type du véhicule</label>
                                                                                    <select name="tp" id="activities" class="form-control">
                                                                                            <?php 
                                                                                            $result = pg_query($bdd, "SELECT * FROM types");
                                                                                            if (!$result) {
                                                                                              echo "Une erreur est survenue.\n";
                                                                                              exit;
                                                                                            }
                                                                                            
                                                                                            while ($row = pg_fetch_row($result)) {
                                                                                                echo "<option value='".$row[0]."'>".$row[1]."</option>";
                                                                                            }
                                                                                            
                                                                                            ?>
                                                                                    </select>
                                                                                </div>
                                                                        </div><div class="row form-group">
                                                                                <div class="col-md-12">
                                                                                    <label for="activities">Station</label>
                                                                                    <select name="station" id="activities" class="form-control">
                                                                                            <?php 
                                                                                            $result = pg_query($bdd, "SELECT * FROM stations");
                                                                                            if (!$result) {
                                                                                              echo "Une erreur est survenue.\n";
                                                                                              exit;
                                                                                            }
                                                                                            
                                                                                            while ($row = pg_fetch_row($result)) {
                                                                                                echo "<option value='".$row[0]."'>".$row[1]."</option>";
                                                                                            }
                                                                                            
                                                                                            ?>
                                                                                    </select>
                                                                                </div>
                                                                        </div>
                                                                        </div>
                                                                        <div class="row form-group">
                                                                                <div class="col-md-12">
                                                                                        <input type="submit" name="valid" class="btn btn-primary btn-block" value="Ajouter un type">
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
