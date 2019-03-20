

<?php
echo '<h1 class="titreContenu">Liste des livres:</h1>';


// Tout d'abord, on va se connecter à la base de données:
$mysqli = new mysqli("localhost", "root", "root", "dblivre");

// On vient définir ce qu'il se passe si on utilise la barre de recherche et qu'elle n'est pas vide:
if (isset($_GET["recherche"]) && !empty($_GET['recherche'])) {
    // On décode en utf8 pour afficher les accents et en HTMLspecialchars pour éviter les injections SQL.
    $recherche = utf8_decode(htmlspecialchars($_GET["recherche"]));
 // On définit que la recherche doit correspondre à tout ou partie d'une colonne (contenue dans le concat)
 // Pour fonctionner.
    $requete='select titre,nom,genre,motcle
    from

    ecritpar join livre
    on id_livre = livre.id
    join auteur
    on id_auteur = auteur.id

    join categorie
    on livre.rayon=categorie.id

    join motcleflivre
    on motcleflivre.id_livre=livre.id
    join motclef
    on ID_MOTCLEF=motclef.id
    where concat(titre,nom,genre,motcle) like "%' . $recherche . '%"
    group by titre';
   
//    On utilise la requête dans les tables:
    $result = $mysqli->query($requete);
  

    // Si la recherche s'avère infructueuse, alors on prévient l'utilisateur:
if ($result->num_rows==0){

    echo "<div> Malheureusement, votre recherche <b>".utf8_encode($recherche)."</b> n'a pas abouti... </div>";
    
}


}

// Le else correspond à ce qui se passe avant que l'on ait entré quelque chose dans la barre de recherche:
else
{
    // Initialement, la recherche a juste pour but d'afficher les livres sous forme de liste.
    $requete = "select titre,nom,genre,motcle
    from

    ecritpar join livre
    on id_livre = livre.id
    join auteur
    on id_auteur = auteur.id

    join categorie
    on livre.rayon=categorie.id

    join motcleflivre
    on motcleflivre.id_livre=livre.id
    join motclef
    on ID_MOTCLEF=motclef.id

    group by titre
    ;";
// Encore une fois, on utilise la requête dans les tables.
    $result = $mysqli->query($requete);

}

// Au lancement, la page affichera donc:


    while ($requete = $result->fetch_array()) {
        echo '<ul>';
        echo '<li > <b>' . utf8_encode($requete['titre']) . "</b> écrit par: <b>" . $requete['nom'] . "</b>" . ", classé dans la catégorie
        <b>" . $requete["genre"] . " </b> </li>";
        echo "</ul>";
    
}



?>



