<?php
// ICI IL FAUT CONTROLER LES DONNEES DE L 'UTILISATEUR
// NE JAMAIS FAIRE CONFIANCE AVEUGLEMENT..A TOUTE DONNEE SAISIE
if (isset($_POST['validerA'])) {
    $idlivre = $_POST['livre'];
    $idadherent = $_POST['adherent'];
    $dateP = $_POST['datepret'];
    $dateR = $_POST['dateretour'];

    // Verifier que l'adherent a emprunté moins de 6 livres
    $sql0 ="
    SELECT adherents.nomadherent, count(livre_en_pret) as cnt 
    FROM livres join adherents
    on livres.livre_en_pret = adherents.idadherent
    where livre_en_pret != 0  and adherents.idadherent = ".$idadherent." group BY livre_en_pret 
    ";
    $result = $db->query($sql0);
    $rec = $result->fetch_array();
    if($result->num_rows == 0 || $rec['cnt'] < 6){
        $diffday = ceil((strtotime($dateR) - strtotime($dateP)) / 60 / 60 / 24);
        if ($diffday > 0 ) { // faire plus de test : date d'emprunt dans le passé ou le futur ou si la  durée est sup à 14 jours ...etc
            // inserer le pret
            $sql1 = "insert into livres_adherents (idlivre, idadherent, datepret, dateretour) values($idlivre, $idadherent, '$dateP', '$dateR')";
            //echo 'sql 1 = '.$sql1.'<br>';
            $result = $db->query($sql1);
    
            // mettre le livre en emprunté
            $sql2 = "update livres set livre_en_pret = $idadherent where idlivre = $idlivre";
            $result = $db->query($sql2);
        } else {
            $err = 'La date de retour ne peut etre anterieure à la date de prêt !!!';
            echo '<span style="color: red;">' . $err . '</span>';
        }
    } else {
        echo 'Vous avez atteint la limite de 6 livres...!';
    }
}

if (isset($_POST['validerR'])) {
    $idlivre = $_POST['livre'];
    $sql2 = "update livres set livre_en_pret = '0' where idlivre = $idlivre";
    $result = $db->query($sql2);
}

// listing des emprunts -------------------------------------------------------
echo '<h2>LISTING DES PRETS</h2>';
// Requete sql à modifier,  version 0.02 Erreur des doublons à gerer.
$sql = "
select livres.titrelivre, adherents.nomadherent, livres_adherents.datepret, livres_adherents.dateretour FROM
livres join livres_adherents
on livres.idlivre = livres_adherents.idlivre
join adherents
on adherents.idadherent = livres_adherents.idadherent
where livres.livre_en_pret = adherents.idadherent
order by adherents.nomadherent
";

$result = $db->query($sql);
if ($result->num_rows == 0) {
    echo 'Aucun prêt ... ! <br>';
} else {
    echo '<hr>';
    echo '<table border="1">';
    echo '<tr><th>Adherent</th><th>Titre</th><th>Date prêt</th><th>Date retour</th></tr>';
    while ($rec = $result->fetch_array()) {
        $diffday = ceil((strtotime($rec['dateretour']) - strtotime('today')) / 60 / 60 / 24);
        $retard = ' (A rendre dans '.$diffday. ' jours). ';
        if ($diffday < 0) {
            $retard = ' RETARD : ' . (-1 * $diffday) . ' jours ';
            $retard = '<span style="color: red;">' . $retard . '</span>';
        }
        echo '<tr>';
        echo '<td>' . utf8_encode($rec['nomadherent']) . '</td>';
        echo '<td>' . utf8_encode($rec['titrelivre']) . '</td>';
        echo '<td>' . utf8_encode($rec['datepret']) . '</td>';
        echo '<td>' . utf8_encode($rec['dateretour']) . $retard . '</td>';
        echo '</tr>';
        $diffday = ceil((strtotime($rec['dateretour']) - strtotime('today')) / 60 / 60 / 24);
    }
    echo '</table>';
    echo '<hr>';
}
$result->free();

// Formulaire pour les emprunts -------------------------------------------------------
echo '<h2>ENREGISTER UN PRET</h2>';
// creation donnees pour le select adherents
$adhSql = 'select * from adherents';
$result = $db->query($adhSql);
$adh_select = '';
while ($rec = $result->fetch_array()) {
    $adh_select .= '<option value=' . $rec['idadherent'] . '>' . utf8_encode($rec['nomadherent']) . '</option>';
}
$result->free();

// creation donnees pour le select livres
$livresSql = 'select * from livres  where livre_en_pret = 0 order by titrelivre'; // on choisit uniquement les livres non en prêts
$result = $db->query($livresSql);
$livre_select = '';
while ($rec = $result->fetch_array()) {
    $livre_select .= '<option value=' . $rec['idlivre'] . '>' . utf8_encode($rec['titrelivre']) . '</option>';
}
$result->free();
?>

<form role="form" method='post' action='#'>
  <div class="form-group">
    <label for="adherent">Adherent</label>
    <select class="form-control" id="adherent" name="adherent">
    <?php
        echo $adh_select;
    ?>
    </select>

    <label for="livre">Livre</label>
    <select class="form-control" id="livre" name="livre">
    <?php
        echo $livre_select;
    ?>
    </select>
    <?php
        $today = strtotime('today');
        $datedebut = date('Y-m-d', $today);
        $dateretour = date('Y-m-d', strtotime("+2 weeks", $today));
    ?>
    <label for="datepret">Date du prêt</label>
    <input type="date" class="form-control" id="datepret" name="datepret" value="<?php echo $datedebut; ?>">

    <label for="dateretour">Date de retour</label>
    <input type="date" class="form-control" id="dateretour" name="dateretour" value="<?php echo $dateretour; ?>">
  </div>
  <button type="submit" class="btn btn-primary" name='validerA' id='validerA'>Valider</button>
</form>
<hr>

<?php
// Formulaire pour rendre un livre -------------------------------------------------------
echo '<h2>RENDRE UN LIVRE :</h2>';
// liste des livres empruntés
$livresSql = 'select * from livres  where livre_en_pret != 0 order by titrelivre'; // on choisit uniquement les livres en prêts
$livresSql = '
select livres.*, adherents.nomadherent
from livres
join adherents
on livres.livre_en_pret = adherents.idadherent
where livre_en_pret != 0 order by titrelivre'
;

$result = $db->query($livresSql);
$livre_select = '';
while ($rec = $result->fetch_array()) {
    $livre_select .= '<option value=' . $rec['idlivre'] . '>' . utf8_encode($rec['titrelivre']) .' ( emprunté par '.utf8_encode($rec['nomadherent']). ' )</option>';
}
$result->free();
?>

<form role="form" method='post' action='#'>
  <div class="form-group">
    <label for="livre">Livre</label>
    <select class="form-control" id="livre" name="livre">
    <?php
        echo $livre_select;
    ?>
    </select>
  </div>
  <button type="submit" class="btn btn-primary" name='validerR' id='validerR'>Valider</button>
</form>
<?php
