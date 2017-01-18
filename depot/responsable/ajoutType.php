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
                if(!empty($_POST['type'])&&!empty($_POST['km'])&&!empty($_POST['jour'])){
                    $type=$_POST['type'];
                    $km=$_POST['km'];
                    $jour=$_POST['jour'];
                    

                        
                        $requete="select * from types where nom=$1;";
                        $result= pg_prepare($bdd,'checkMail',$requete);
                        $result = pg_execute($bdd, "checkMail", array($type));
                        $count= pg_num_rows($result);
                        if($count==0){
                            $requete="insert into types(nom,prix_km,prix_jour) values($1,$2,$3)";
                            $result= pg_prepare($bdd,'insert type',$requete);
                            $result= pg_execute($bdd,'insert type',array($type,$km,$jour));
                            echo "Le type a été ajouté";
                        }else{
                            echo "<h3>Le type existe déjà</h3>";
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
                                <h1 class="cursive-font">Ajout du type de véhicule.</h1>	
                        </div>
                        <div class="col-md-4 col-md-push-1 animate-box" data-animate-effect="fadeInRight">
                                <div class="form-wrap">
                                        <div class="tab">

                                                <div class="tab-content">
                                                        <div class="tab-content-inner active" data-content="signup">
                                                                
                                                                
                                                                <form method="POST">
                                                                        <div class="row form-group">
                                                                                <div class="col-md-12">
                                                                                        <label for="date-start">Nom du type</label>
                                                                                        <input type="text" id="type" name="type" class="form-control">
                                                                                </div>
                                                                                <div class="col-md-12">
                                                                                        <label for="date-start">Prix km</label>
                                                                                        <input type="number" id="type" name="km" class="form-control">
                                                                                </div>
                                                                                <div class="col-md-12">
                                                                                        <label for="date-start">Prix jour</label>
                                                                                        <input type="number" id="type" name="jour" class="form-control">
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
