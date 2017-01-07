<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Employe
 *
 * @author machin
 */
class Employe {
    //put your code here
    private $id;
    private $nom;
    private $prenom;
    private $station;
    private $compteE;
    
    function __construct($id, $nom, $prenom, Station $station, CompteEmploye $compteE) {
        $this->id = $id;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->station = $station;
        $this->compteE = $compteE;
    }

    function getId() {
        return $this->id;
    }

    function getNom() {
        return $this->nom;
    }

    function getPrenom() {
        return $this->prenom;
    }

    function getStation() {
        return $this->station;
    }

    function getCompteE() {
        return $this->compteE;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setNom($nom) {
        $this->nom = $nom;
    }

    function setPrenom($prenom) {
        $this->prenom = $prenom;
    }

    function setStation(Station $station) {
        $this->station = $station;
    }

    function setCompteE(CompteEmploye $compteE) {
        $this->compteE = $compteE;
    }


}
