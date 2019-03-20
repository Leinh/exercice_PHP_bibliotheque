
<h1 class="titreContenu">Connexion:</h1>

<?php
// Tout d'abord, on va se connecter à la base de données:
$mysqli = new mysqli("localhost", "root", "root", "dblivre");

// On définit une variable qui équivaut à un formulaire d'identification des employés:
$form = '

<form method="POST">
<table>
<tr>
    <td><label >Nom:</label>  </td>
    <td><input type="text" name="nomEmploye"></td>
</tr><br>

<tr>
    <td><label >Mot de passe:</label></td>
    <td><input type="text" name="mdpEmploye"></td>
</tr><br>
<tr><td colspan="2"><input type="submit" value="Se connecter" class="btn btn-primary m-auto" buttonSubmit></td> </tr>
  </table>

</form>

';
// Il faut vérifier s'il a entré ses identifiants dans la barre de recherche ou pas:
if (isset($_POST['mdpEmploye']) && isset($_POST['nomEmploye'])) {
    // On définit des variables qui feront gagner du temps:
    $nomEmploye = utf8_decode(htmlspecialchars($_POST["nomEmploye"]));
    $mdpEmploye = utf8_decode(htmlspecialchars($_POST["mdpEmploye"]));

    $testIdEmploye = "select nom,mdp
    from
    employe
    where nom ='$nomEmploye' and mdp = '$mdpEmploye'
    ;";

    $result = $mysqli->query($testIdEmploye);

    if ($result->num_rows == 0) {
        echo '<div class="red"> <b> Au moins l\'un des deux champs est incorrect. </b></div>';
        echo $form;
    } else {
        echo '<div> Bienvenue' . " " . $nomEmploye . '</div>';
        // Si la connection est correcte, alors on peut générer des cookies pour faciliter sa reconnection:
        setcookie('nomEmploye', $nomEmploye, time() + 365 * 24 * 3600, null, null, false, true);

    }

} else {
    echo '<div class="center"> <b> Veuillez vous identifier: </b> </div>';
    echo $form;

}

?>
