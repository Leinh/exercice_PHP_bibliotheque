<?php


if (isset($_POST['validerM'])) {
    $idL = $_POST['livre'];
    $sql = "select * from livres where idlivre = $idL";
    $result = $db->query($sql); // A faire :  Verifier si pas d'erreur
    $rec = $result->fetch_array();
    $nomL = $rec['titrelivre'];
    $idR = $rec['idrayon'];
    $idE = $rec['idediteur'];
    $idA = $rec['livre_en_archive'];
    $idP = $rec['livre_en_pret']; // en theorie en modifie pas les livres en prêt, il faut attendre leur retour...
    $result->free();

    // creation donnees pour le select rayons
    $rayon_select = 'select * from rayons'; //
    $result = $db->query($rayon_select);
    $rayon_select = '';
    while ($rec = $result->fetch_array()) {
        $lebonrayon = '';
        if ($rec['idrayon']  == $idR) {
            $lebonrayon = ' selected';
        }
        $rayon_select .= '<option value=' . $rec['idrayon'] . $lebonrayon .'>' . utf8_encode($rec['nomrayon']) . '</option>';
    }
    $result->free();

    // creation donnees pour le select editeurs
    $editeur_select = 'select * from editeurs'; //
    $result = $db->query($editeur_select);
    $editeur_select = '';
    while ($rec = $result->fetch_array()) {
        $lebonediteur='';
        if ($rec['idediteur']  == $idE) {
            $lebonediteur = ' selected';
        }
        $editeur_select .= '<option value=' . $rec['idediteur'] . $lebonediteur .'>' . utf8_encode($rec['nomediteur']) . '</option>';
    }
    $result->free();

    // creation donnees pour le select Auteurs

    // d'abord quels sont les auteurs de ce livre
    $sssql = 'select idauteur from auteurs_livres where idlivre =  '.$idL;
    $result = $db->query($sssql);
    $aut=[];
    while($rec = $result->fetch_array()){
        $aut[] = $rec['idauteur'];
    }
    $result->free();
    // puis on crée la liste
    $auteur_select = 'select * from auteurs'; //
    $result = $db->query($auteur_select);
    $auteur_select = '';
    while ($rec = $result->fetch_array()) {
        $lebonauteur = '';
        if (in_array($rec['idauteur'],$aut)){
            $lebonauteur = ' selected';
        }
        $auteur_select .= '<option value=' . $rec['idauteur'] . $lebonauteur. '>' . utf8_encode($rec['nomauteur']) . '</option>';
    }
    $result->free();

    // creation donnees pour le select mots cles

    // d'abord quels sont les mots cles de ce livre
    $sssql = 'select idmotcle from livres_motscles where idlivre = '.$idL;
    $result = $db->query($sssql);
    $mcles=[];
    while($rec = $result->fetch_array()){
        $mcles[] = $rec['idmotcle'];
    }
    $result->free();
    // puis on crée la liste
    $motcle_select = 'select * from motscles'; //
    $result = $db->query($motcle_select);
    $motcle_select = '';
    while ($rec = $result->fetch_array()) {
        $lebonmot = '';
        if (in_array($rec['idmotcle'],$mcles)){
            $lebonmot = ' selected';
        }
        $motcle_select .= '<option value=' . $rec['idmotcle'] . $lebonmot. '>' . utf8_encode($rec['nommotcle']) . '</option>';
    }
    $result->free();

}elseif (isset($_POST['validerMV'])){
    // ici la validation de la modification :
    // reproduire le même code que pour ajouter un livre sauf que il faut
    // metre des updates au lieu de insert....
    
    header("location: index.php"); // temporraire

} else {
    header("location: index.php"); // si qq un tape l'url de lapage sans passer par le chemin habituel
}
?>

<form role="form" method='post' action='#'>
  <div class="form-group">
    <label for="livre">Titre du Livre</label>
    <input type="text" class="form-control" id="livre" name="livre" value="<?php echo $nomL; ?>">

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
    <input type="hidden" class="form-control" id="livre" name="livre" value="<?php echo $idL; ?>">
  </div>

  <button type="submit" class="btn btn-primary" name='validerMV' id='validerMV'>Valider</button>
</form>

<hr>