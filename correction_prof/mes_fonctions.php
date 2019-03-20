<?php
require_once('db.php');

function identification() // tester si on a déjà validé l'identification
{    
    if (isset($_COOKIE["employe_valide"])) {
        $emp = $_COOKIE["employe_valide"];
        if ($emp == '1') {  // employé 
            return 1;
        } else {            // admin
            return 2;
        }        
    }
    return 0;
}

function identifier($db, $pseudo, $password)
{
    // Pour simplifier la compréhension : aucun filtre n'a été appliqué. VOIR l'appel de la fonction
    $sql = "SELECT * FROM employes WHERE pseudo = '$pseudo' and password='$password'";    
    $result = $db->query($sql);

    if ($result->num_rows == 0) {
        $rep = 0;
    } else {
        if($pseudo == 'admin'){
            $rep = 2;
        } else{
            $rep = 1;
        }
    }
   
    return $rep;
}