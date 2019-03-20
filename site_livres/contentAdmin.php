<h1 class="titreContenu">Fonctions administrateur:</h1>
<?php

$mysqli = new mysqli("localhost", "root", "root", "dblivre");

// Tout d'abord, nous allons gérer l'ajout d'un livre à une base de données:
// La première chose à faire est de créer quatre champs de sélection qui vont permettre de saisir un titre, un auteur
// un éditeur et un rayon approprié:


// On créé un formulaire qui contiendra tout:
echo '<form method="POST">';
echo '<div class="row justify-content-around">';
// Pour le titre:
echo '<div class="form-group col-3">
<label for="imputTitre">Titre du livre:</label>
<input class="form-control" id="titreLivre"  placeholder="Entrez le titre...">
</div>';

// Pour l'auteur:



echo "</div>
</form>";

$ajoutLivre='insert into livre (titre,editeur,rayon)
values
("'.$titre.'","'.$editeur.'","'.$rayon.'");';

$ajout = $mysqli->query($ajoutLivre);


?>