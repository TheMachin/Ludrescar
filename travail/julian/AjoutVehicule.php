<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <title>Ajouter un véhicule</title>
    </head>
	<body>
        <h1>Ajouter un véhicule</h1>
        <h2>Liste des informations :</h2>
        <div>
            <form action="#" method="POST">
                <label for="noImmat">Numéro d'immatriculation :</label><br/>
                <input type="text" id="noImmat "name="noImmat">
                <br/>
                <label for="marque">Marque :</label><br/>
                <input type="text" id="marque "name="marque">
                <br/>
                <label for="modele">Modèle :</label><br/>
                <select id="modele" name="modele">
                    <option value="monoplace">Monoplace</option>
                    <option value="suv">SUV</option>
                    <option value="fourfour">4x4</option>
                    <option value="coupe">Coupe</option>
                    <option value="cabriolet">Cabriolet</option>
                    <option value="break">Break</option>
                </select>
                <br/>
                <label for="nbPlace">Nombre de place :</label><br/>
                <input type="number" id="nbPlace "name="nbPlace">
                <br/>
                <label for="carburant">Carburant :</label><br/>
                <select id="carburant" name="carburant">
                    <option value="diesel">Diesel</option>
                    <option value="spNeufCinq">SP95</option>
                    <option value="spNeufHuit">SP98</option>
                    <option value="electrique">Electrique</option>
                </select>
                <br/>
                <label for="puissance">Puissance :</label><br/>
                <input type="text" id="puissance "name="puissance">
                <br/>
                <label for="nbKm">Nombre de kilomètres :</label><br/>
                <input type="text" id="nbKm "name="nbKm">
                <br/>
                <label for="etat">Etat du véhicule :</label><br/>
                <select id="etat" name="etat">
                    <option value="c">Correcte</option>
                    <option value="be">En bon état</option>
                    <option value="v">Volé</option>
                    <option value="hs">Hors service</option>
                </select>
                <br/>
                <label for="nivCarburant">Niveau du carburant :</label><br/>
                <input type="text" id="nivCarburant "name="nivCarburant">
                <br/>
                <input type="submit" name="valider" value="Valider">
            </form>
        </div>
    </body>
</html>