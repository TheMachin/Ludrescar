<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Formulaire
 *
 * @author machin
 */
class Formulaire {
    //put your code here
    private $id;
    private $etatVehicule;
    private $km;
    private $commentaire;
    private $niv_carbu;
    private $type;
    private $heure;
    private $date;
    
    function __construct($id, $etatVehicule, $km, $commentaire, $niv_carbu, $type, $heure, $date) {
        $this->id = $id;
        $this->etatVehicule = $etatVehicule;
        $this->km = $km;
        $this->commentaire = $commentaire;
        $this->niv_carbu = $niv_carbu;
        $this->type = $type;
        $this->heure = $heure;
        $this->date = $date;
    }

    function getId() {
        return $this->id;
    }

    function getEtatVehicule() {
        return $this->etatVehicule;
    }

    function getKm() {
        return $this->km;
    }

    function getCommentaire() {
        return $this->commentaire;
    }

    function getNiv_carbu() {
        return $this->niv_carbu;
    }

    function getType() {
        return $this->type;
    }

    function getHeure() {
        return $this->heure;
    }

    function getDate() {
        return $this->date;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setEtatVehicule($etatVehicule) {
        $this->etatVehicule = $etatVehicule;
    }

    function setKm($km) {
        $this->km = $km;
    }

    function setCommentaire($commentaire) {
        $this->commentaire = $commentaire;
    }

    function setNiv_carbu($niv_carbu) {
        $this->niv_carbu = $niv_carbu;
    }

    function setType($type) {
        $this->type = $type;
    }

    function setHeure($heure) {
        $this->heure = $heure;
    }

    function setDate($date) {
        $this->date = $date;
    }


}
