<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CompteUtilisateur
 *
 * @author machin
 */
class CompteUtilisateur {
    //put your code here
    private $id;
    private $mdp;
    
    function __construct($id, $mdp) {
        $this->id = $id;
        $this->mdp = $mdp;
    }

    function getId() {
        return $this->id;
    }

    function getMdp() {
        return $this->mdp;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setMdp($mdp) {
        $this->mdp = $mdp;
    }


}
