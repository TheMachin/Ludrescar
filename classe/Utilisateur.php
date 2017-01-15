<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Utilisateur
 *
 * @author machin
 */
class Utilisateur {
    //put your code here
    private $id;
    private $nom;
    private $prenom;
    private $date_nais;
    private $date_ins;
    private $tel_port;
    private $email;
    private $adresse;
    private $banni;
    private $compteU;

    function __construct($id, $nom, $prenom, $date_nais, $date_ins, $tel_port, $email, $adresse, $banni, CompteUtilisateur $compteU) {
        $this->id = $id;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->date_nais = $date_nais;
        $this->date_ins = $date_ins;
        $this->tel_port = $tel_port;
        $this->email = $email;
        $this->adresse = $adresse;
        $this->banni = $banni;
        $this->compteU = $compteU;
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

    function getDate_nais() {
        return $this->date_nais;
    }

    function getDate_ins() {
        return $this->date_ins;
    }

    function getTel_port() {
        return $this->tel_port;
    }

    function getEmail() {
        return $this->email;
    }

    function getAdresse() {
        return $this->adresse;
    }

    function getBanni() {
        return $this->banni;
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

    function setDate_nais($date_nais) {
        $this->date_nais = $date_nais;
    }

    function setDate_ins($date_ins) {
        $this->date_ins = $date_ins;
    }

    function setTel_port($tel_port) {
        $this->tel_port = $tel_port;
    }

    function setEmail($email) {
        $this->email = $email;
    }

    function setAdresse($adresse) {
        $this->adresse = $adresse;
    }

    function setBanni($banni) {
        $this->banni = $banni;
    }

    function getCompteU() {
        return $this->compteU;
    }

    function setCompteU(CompteUtilisateur $compteU) {
        $this->compteU = $compteU;
    }


    
}
?>