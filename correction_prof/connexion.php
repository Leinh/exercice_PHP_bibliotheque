<?php
// Pour simplifier la compréhension : aucun filtre n'a été appliqué. VOIR les mesures de sécurité
$err = '';
$pseudo = '';
if (isset($_POST['valider'])) {    
    if (!empty($_POST['pseudo']) && !empty($_POST['password'])) {
        // ICI IL FAUT CONTROLER LES DONNEES DE L 'UTILISATEUR
        // NE JAMAIS FAIRE CONFIANCE AVEUGLEMENT..A TOUTE DONNEE SAISIE
        $pseudo = $_POST['pseudo'];
        $password = $_POST['password'];
        $reponse = identifier($db, $pseudo, $password);
        if ($reponse){
            setcookie("employe_valide", $reponse, time() + (60*60), "/"); // 60 minutes
            header("location: index.php?p=home");
        } else {
            $err = 'ERREUR : Problème sur Le pseudo et/ou le mot de passe...';
        }
    }else{
        $err = 'ERREUR : Merci de renseigner tous les champs...';
    }
}
echo '<span style="color: red;">'.$err.'</span>';
?>

<h2>Veuillez vous identifier :</h2>
<form role="form" method='post' action='#'>
  <div class="form-group">
    <label for="pseudo">Pseudo</label>
    <input type="pseudo" class="form-control" id="pseudo" name="pseudo" placeholder="" value="<?php echo $pseudo; ?>">
  </div>
  <div class="form-group">
    <label for="password">Mot de passe</label>
    <input type="password" class="form-control" id="password" name="password" placeholder="" value="">
  </div>

  <button type="submit" class="btn btn-primary" name='valider' id='valider'>Valider</button>
</form>
