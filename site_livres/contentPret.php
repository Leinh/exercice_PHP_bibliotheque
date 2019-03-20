<h1 class="titreContenu">Prêts:</h1>


<?php
// Tout d'abord, on va se connecter à la base de données:
$mysqli = new mysqli("localhost", "root", "root", "dblivre");

// Le menu déroulant du livre:

$requete = 'select id,titre
from
livre;'
;
// On créé un formulaire qui va envoyer la sélection pour en manipuler les données:
echo "<form method = 'POST'>";
$result = $mysqli->query($requete);
echo '<div class="row justify-content-around">';
echo '<div class="form-group col-8 col-lg-2 ">
<label for="livre">Livre:</label>
<select class="form-control" id="livre" name="livre">';
while ($requete = $result->fetch_array()) {
// On définit que la valeur de l'option est égale à l'ID. On veut que l'utilisateur voit le nom du livre
    // Mais le formulaire doit renvoyer son ID pour le manipuler à loisir.
    echo '<option value=' . $requete["id"] . '>' . utf8_encode($requete["titre"]) . '</option>';
}
echo '</select>
</div>';

// Le menu déroulant des adhérents:
$requete = 'select id,nom,prenom
from
adherents
order by nom;'
;

$result = $mysqli->query($requete);

echo '<div class="form-group col-8 col-lg-2">
<label for="adherent">Adherents:</label>
<select class="form-control" id="adherent" name="adherent">';
while ($requete = $result->fetch_array()) {

    echo '<option value=' . $requete["id"] . ' >' . utf8_encode($requete["nom"]) . " " . utf8_encode($requete["prenom"]) . '</option>';
}
echo '</select>
</div>';

// La date:

echo '<div class="form-group col-8 col-lg-2">
<label for="date">Date d\'emprunt:</label>
<input class="form-control" type="date" name="date" id="date">
</div>'
;

echo '</div>';

echo ' <div class="m-auto" width="100px"><input type="submit" value="Envoyer" class="btn btn-primary m-auto" buttonSubmit > </div>';
echo "</form>";

// Maintenant, il est temps de gérer l'ajout de données à la base emprunt:

if (isset($_POST["livre"]) && isset($_POST["adherent"]) && isset($_POST["date"])) {
    //  On met des @ pour que l'utilisateur ne voit pas afficher d'erreur quand il n'a pas encore utilisé le formulaire
    @$livre = $_POST["livre"];
    @$adherent = $_POST["adherent"];
    @$date = $_POST["date"];

// Il faut vérifier si le livre est déjà emprunté ou pas:
    $verification = '
select sur_place from livre
where id=' . $livre . ';'
    ;
    $verifLivre = $mysqli->query($verification);
    // Quand on utilise un select, le resultat retourné est un tableau. Par conséquent, pour utiliser ce tableau,
    // le fetch_array va lire ligne par ligne jusqu'à arriver à la ligne dont on a besoin. Même si le tableau ne fait
    // qu'une seule ligne.
    $ligne = $verifLivre->fetch_array();

    if ($ligne["sur_place"] == 0) {
        echo '<div class="red center"> Ce livre est déjà emprunté. </div>';
    }
    // S'il ne l'est pas alors on peut créer un emprunt:
    else {
        // La commande pour ajouter à la liste:
        // Les id n'ont pas besoin de guillemets car ce sont des ints. La date en revanche en a besoin.
        $ajout = '
insert into emprunt (id_livre,id_adherent,date_debut,date_fin)
VALUES
(' . $livre . ',' . $adherent . ',"' . $date . '",date_add("' . $date . '",interval 14 day))
;
';

        $nouvelEmprunt = $mysqli->query($ajout);

        $location = '
    update livre set
    sur_place = 0 where id=' . $livre . '
    ;';

        $nouvelleLocation = $mysqli->query($location);

        echo '<div class="green center">votre livre à bien été ajouté à la liste! </div>';

    }
}

?>

