<?php
// ICI IL FAUT CONTROLER LES DONNEES DE L 'UTILISATEUR
// NE JAMAIS FAIRE CONFIANCE AVEUGLEMENT..A TOUTE DONNEE SAISIE
if (isset($_POST['validerA'])) {
    $titrelivre = $_POST['livre'];
    $idrayon = $_POST['rayon'];
    $idediteur = $_POST['editeur'];
    $auteurs = $_POST['auteur'];
    $motscles = $_POST['motcle'];

    // A faire : Verifier que les champs ne sont pa vides...etc.
    // A faire : verifier que les insertions se sont bien passées

    // inserer le livre dans la table
    $sql = "insert into livres (titrelivre, idrayon, idediteur, Livre_en_archive, livre_en_pret)
    values ('$titrelivre', $idrayon, $idediteur, 0, 0) ";
    echo 'sql = ' . $sql;
    $result = $db->query($sql);
    $idL = $db->insert_id;

    // inserer les auteurs en relation avec ce livre
    foreach ($auteurs as $value) {
        $sql = "insert into auteurs_livres values ($value,$idL)";
        $result = $db->query($sql);
    }
    // inserer les auteurs en relation avec ce livre
    foreach ($motscles as $value) {
        $sql = "insert into livres_motscles values ($idL,$value)";
        $result = $db->query($sql);
    }
}



echo '<h2>AJOUTER UN LIVRE:</h2>';

// creation donnees pour le select rayons
$rayon_select = 'select * from rayons'; //
$result = $db->query($rayon_select);
$rayon_select = '';
while ($rec = $result->fetch_array()) {
    $rayon_select .= '<option value=' . $rec['idrayon'] . '>' . utf8_encode($rec['nomrayon']) . '</option>';
}
$result->free();

// creation donnees pour le select editeurs
$editeur_select = 'select * from editeurs'; //
$result = $db->query($editeur_select);
$editeur_select = '';
while ($rec = $result->fetch_array()) {
    $editeur_select .= '<option value=' . $rec['idediteur'] . '>' . utf8_encode($rec['nomediteur']) . '</option>';
}
$result->free();

// creation donnees pour le select Auteurs
$auteur_select = 'select * from auteurs'; //
$result = $db->query($auteur_select);
$auteur_select = '';
while ($rec = $result->fetch_array()) {
    $auteur_select .= '<option value=' . $rec['idauteur'] . '>' . utf8_encode($rec['nomauteur']) . '</option>';
}
$result->free();

// creation donnees pour le select Mots cles
$motcle_select = 'select * from motscles'; //
$result = $db->query($motcle_select);
$motcle_select = '';
while ($rec = $result->fetch_array()) {
    $motcle_select .= '<option value=' . $rec['idmotcle'] . '>' . utf8_encode($rec['nommotcle']) . '</option>';
}
$result->free();
?>

<form role="form" method='post' action='#'>
  <div class="form-group">
    <label for="livre">Titre du Livre</label>
    <input type="text" class="form-control" id="livre" name="livre" value="">

    <label for="rayon">Rayon</label>
    <select class="form-control" id="rayon" name="rayon">
    <?php
    echo $rayon_select;
    ?>
    </select>

    <label for="editeur">Editeur</label>
    <select class="form-control" id="editeur" name="editeur">
    <?php
    echo $editeur_select;
    ?>
    </select>

    <label for="Auteur">Auteur(s)</label>
    <select class="form-control" id="Auteur" name="auteur[]" size="4" multiple>
    <?php
    echo $auteur_select;
    ?>
    </select>

    <label for="motcle">Mots clés</label>
    <select class="form-control" id="motcle" name="motcle[]" size="7" multiple>
    <?php
    echo $motcle_select;
    ?>
    </select>

  </div>
  <button type="submit" class="btn btn-primary" name='validerA' id='validerA'>Valider</button>
</form>

<hr>

<h2>MODIFICATION D'UN LIVRE</h2>

<?php
// creation donnees pour le select livres
$livresSql = 'select * from livres  where livre_en_archive = 0 order by titrelivre';
$result = $db->query($livresSql);
$livre_select = '';
while ($rec = $result->fetch_array()) {
    $livre_select .= '<option value=' . $rec['idlivre'] . '>' . utf8_encode($rec['titrelivre']) . '</option>';
}
$result->free();
?>
<form role="form" method='post' action='index.php?p=admin_modlivre'>
  <div class="form-group">
    <label for="livre">Livre</label>
    <select class="form-control" id="livre" name="livre">
    <?php
        echo $livre_select;
    ?>
    </select>
  </div>
  <button type="submit" class="btn btn-primary" name='validerM' id='validerM'>Modifier</button>
</form>