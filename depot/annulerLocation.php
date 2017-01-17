<?php
include('../../bdd/bdd.php');
session_start();
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
if(empty($_SESSION['utilisateur'])){
    sendError("Vous n'êtes pas connecté");
}
if(isset($_GET['idLoc'])){
    if(!empty($_GET['idLoc'])){
        $idLoc=$_GET['idLoc'];
        $requete="UPDATE locations SET etatlocation=$1 WHERE id=$2";
        $result= pg_prepare($bdd,'',$requete);
        $result = pg_execute($bdd, "", array('Annulé',$idLoc));
        
        sendError("Location annulé.");
        
    }
}else{
    sendError("Problème de fonctionnement");
}

    function sendError($msgError){
        $_SESSION['location']=$msgError;
        header("location:".  $_SERVER['HTTP_REFERER']); 
        exit(0);
    }