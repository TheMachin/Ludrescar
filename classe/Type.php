<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Type
 *
 * @author machin
 */
class Type {
    //put your code here
    private $id;
    private $nom;
    private $prix_km;
    private $prix_jour;
    
    function __construct($id, $nom, $prix_km, $prix_jour) {
        $this->id = $id;
        $this->nom = $nom;
        $this->prix_km = $prix_km;
        $this->prix_jour = $prix_jour;
    }
    
    function getId() {
        return $this->id;
    }

    function getNom() {
        return $this->nom;
    }

    function getPrix_km() {
        return $this->prix_km;
    }

    function getPrix_jour() {
        return $this->prix_jour;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setNom($nom) {
        $this->nom = $nom;
    }

    function setPrix_km($prix_km) {
        $this->prix_km = $prix_km;
    }

    function setPrix_jour($prix_jour) {
        $this->prix_jour = $prix_jour;
    }



}
