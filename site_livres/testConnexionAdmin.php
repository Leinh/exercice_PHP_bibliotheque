<?php 
// Cette page détermine que si la personne qui s'est identifiée n'est pas l'admin alors ça renvoie à 
// la connexion.

if(!isset($_COOKIE["nomEmploye"]) || $_COOKIE["nomEmploye"]!="admin" ){
header("location:connexion.php");
}


?>