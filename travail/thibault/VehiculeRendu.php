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
                                                                
                                                                <h3 class="cursive-font">Véhicule : Lada Niva</h3>
                                                                <h3 class="cursive-font">Date du rendu prévu 06/01/2017</h3>
                                                                <h3 class="cursive-font">Date du jour : 05/01/2017</h3>
                                                                <form action="traitVehiculeRendu.php" method="POST">
                                                                        <div class="row form-group">
                                                                                <div class="col-md-12">
                                                                                    <label for="activities">Etat du véhicule</label>
                                                                                    <select name="etat" id="activities" class="form-control">
                                                                                            <option value="c">Correcte</option>
                                                                                            <option value="be">En bon état</option>
                                                                                            <option value="v">Volé</option>
                                                                                            <option value="hs">Hors service</option>
                                                                                    </select>
                                                                                    <br><br>
                                                                                    <label>
                                                                                        Liste des états du véhicule : <br>
                                                                                        <strong>Correcte :</strong> Le véhicule comporte des rayures ou des dégats léger au niveau de la carrosserie. <br>
                                                                                        <strong>En bon état :</strong> Le véhicule ne comporte pas de dégats. <br>
                                                                                        <strong>Volé : </strong> Le véhicule a été volé durant la location. <br>
                                                                                        <strong>Hors service : </strong> Le véhicule comporte des dégats important et ne peut pas être roulé.
                                                                                    </label>
                                                                                    <br><br>
                                                                                </div>
                                                                        </div>
                                                                        <div class="row form-group">
                                                                                <div class="col-md-12">
                                                                                        <label for="date-start">Kilométrage du véhicule</label>
                                                                                        <input type="text" id="km" name="km" class="form-control">
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
                                                                                            <option value="c">Plein</option>
                                                                                            <option value="be">Vide</option>
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
