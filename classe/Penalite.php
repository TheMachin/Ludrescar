<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Penalite
 *
 * @author machin
 */
class Penalite {
    //put your code here
    private $id;
    private $nom;
    private $montant;
    
    function __construct($id, $nom, $montant) {
        $this->id = $id;
        $this->nom = $nom;
        $this->montant = $montant;
    }

    function getId() {
        return $this->id;
    }

    function getNom() {
        return $this->nom;
    }

    function getMontant() {
        return $this->montant;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setNom($nom) {
        $this->nom = $nom;
    }

    function setMontant($montant) {
        $this->montant = $montant;
    }

    function getBdDByNom($bdd){
        $requete="SELECT id,montant FROM penalites Where nom=$1";
        $result= pg_prepare($bdd,'',$requete);
        $result = pg_execute($bdd, "", array($this->nom));
        $row = pg_fetch_row($result);
        $this->id=$row[0];
        $this->montant=$row[1];
    }
    
    function insert($idLoc,$bdd){
        $requete="INSERT into a_pour_penalites (penalite_id,location_id) VALUES ($1,$2)";
        $result= pg_prepare($bdd,'',$requete);
        $result = pg_execute($bdd, "", array($this->id,$idLoc));
        $row = pg_fetch_row($result);
        $this->id=$row[0];
        $this->montant=$row[1];
    }
}
?>