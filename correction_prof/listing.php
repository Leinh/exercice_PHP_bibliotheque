<?php
$sql = "
SELECT livres.titrelivre, rayons.nomrayon , auteurs.nomauteur FROM 
livres JOIN auteurs_livres  
on livres.idlivre = auteurs_livres.idlivre 
join auteurs
on auteurs.idauteur = auteurs_livres.idauteur
join rayons
on livres.idrayon = rayons.idrayon
order by titrelivre
";

$result = $db->query($sql);

echo '<hr>';
echo '<table border=1>';
echo '<tr><th>Titre </th><th>Rayon</th><th>Auteur</th></tr>';
$liv='';
while ($rec = $result->fetch_array()) {
    echo '<tr>';
    if ($rec['titrelivre'] == $liv) {
        echo '<td>'. '&nbsp;'. '</td>';
        echo '<td>'. '&nbsp;'. '</td>';
    } else {
        echo '<td>'. utf8_encode($rec['titrelivre']). '</td>';
        echo '<td>'. utf8_encode($rec['nomrayon']). '</td>';
    }
    echo '<td>'. utf8_encode($rec['nomauteur']). '</td>';
    
    echo '</tr>';
    $liv = $rec['titrelivre'];
}
echo '</table>';
echo '<hr>';  

$result->free();