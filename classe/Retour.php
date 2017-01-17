<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Retour
 *
 * @author machin
 */
class Retour {
    //put your code here
    private $id;
    private $date_rendu;
    private $formulaire;
    
    function __construct($id, $date_rendu, Formulaire $formulaire) {
        $this->id = $id;
        $this->date_rendu = $date_rendu;
        $this->formulaire = $formulaire;
    }

    
    function getId() {
        return $this->id;
    }

    function getDate_rendu() {
        return $this->date_rendu;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setDate_rendu($date_rendu) {
        $this->date_rendu = $date_rendu;
    }

    function getFormulaire() {
        return $this->formulaire;
    }

    function setFormulaire(Formulaire $formulaire) {
        $this->formulaire = $formulaire;
    }


    function insert($bdd){
        $requete="INSERT INTO retours(date_rendu,formulaire_id) VALUES($1,$2)";
        $result= pg_prepare($bdd,'',$requete);
        $result = pg_execute($bdd, "", array($this->date_rendu->format('d/m/Y'), $this->formulaire->getId()));
        
        $result = pg_query($bdd, "SELECT MAX(id) FROM retours");
        $row = pg_fetch_row($result);
        $this->id=$row[0];
    }

}
?>