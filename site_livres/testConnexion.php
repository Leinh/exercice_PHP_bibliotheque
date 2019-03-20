<?php 
// Cette page est à ajouter en require avant le header dans toutes les pages qui nécessitent la connexion pour être 
// utilisables.
// Elle sert à dire que s'il n'y a pas de cookie de créé, dans ce cas on renvoie vers la page de connexion qui va générer
// des cookies dès lors que l'on s'est identifié.

if(!isset($_COOKIE["nomEmploye"])){
header("location:connexion.php");
}


?>