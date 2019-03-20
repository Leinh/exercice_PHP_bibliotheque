<h1 class="titreContenu">Retards:</h1>

<?php

$mysqli = new mysqli("localhost", "root", "root", "dblivre");

// Le date_diff est pris en compte uniquement parce qu'on utilise les apostrophes inversés (alt-gr+è). Il ne reconnaît pas les
// autres types de guillemets.
$retard = 'select id_livre,id_adherent,titre,nom,prenom,date_debut,date_fin,sur_place
from emprunt join livre
on id_livre = livre.id
join adherents
on id_adherent = adherents.id

where datediff(`date_fin`,now()) <0
order by titre;';

$verifRetard = $mysqli->query($retard);

while ($retardList = $verifRetard->fetch_array()) {
    // Comme chaque emprunt est conservé pour avoir une traçabilité, il faut tester uniquement les
    // livres qui ne sont pas sur place:
    if ($retardList["sur_place"] == 0) {

        echo 'Le livre <b>' . utf8_encode($retardList["titre"]) . '</b> "emprunté par <b>' . utf8_encode($retardList["nom"]) . " " .
        utf8_encode($retardList["prenom"]) . "</b> n'a pas été rendu <br>";
    }
}

?>