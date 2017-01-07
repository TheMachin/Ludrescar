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


}
