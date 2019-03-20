<?php

$db = @new mysqli('localhost','root','root','bib');
if($db->connect_error){
    die ('erreur de connexion : '.$db->connect_error.'<br>');
} 