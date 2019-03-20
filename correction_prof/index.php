<?php
require_once 'mes_fonctions.php';

$p = 'home';
$pfile = 'home.php';
$connecte = identification();

if (isset($_GET['p'])) {
    $p = $_GET['p'];
    if ($p === 'home') {
        $pfile = $p.'.php';
    } elseif ($p === 'listing') {
		$pfile = $p.'.php';
    } elseif ($p === 'connexion') {
		$pfile = $p.'.php';	
    } elseif ($p === 'deconnexion') {
        $pfile = $p.'.php';			
    } elseif ($p === 'prets' || $p === 'admin' || $p === 'admin_modlivre') {				
        if ($connecte) {
			$pfile = $p.'.php';
        } else {
            $pfile = 'erreur_connexion.php';
        }
    }
}

?>
<!DOCTYPE html>
<html lang="fr">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Ma petite bibliothèque très sommaire</title>
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/style.css" rel="stylesheet">

</head>

<body>

	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<ul class="nav">
					<li class="nav-item">
						<a class="nav-link active" href="index.php?p=home">Home</a>
					</li>
					<li class="nav-item dropdown">
					 <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown">Liste des livres</a>
					<div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
						 <a class="dropdown-item" href="index.php?p=listing">Lister tous les livres</a> 
						 <div class="dropdown-divider"></div>
						 <!-- 
							 A FAIRE:
							 Pour la recherche c'est la même requete que pour le listing,
							 il faut rajouter un : where livres.titre like "%...%",
							 ou : where auteurs.nomauteur like "%..%",
							 ou : where motscles.nommotcle like "%...%"	
							 ces parametres sont à saisir dans un champs de recherche	
							 ICI, pour le test on le passera en parametre d'url				
						-->
						 <a class="dropdown-item" href="index.php?p=listing&auteur=">Rechercher par auteur</a>						 
						 <a class="dropdown-item" href="index.php?p=listing&titre=">Rechercher par titre</a>
						 <a class="dropdown-item" href="index.php?p=listing&motcle=">Rechercher par mot clé</a>
					</div>
				</li>
					<?php
						if ($connecte) {
								echo '<li class="nav-item">';
								echo '<a class="nav-link" href="index.php?p=prets">Gestion des prêts</a>';
								echo '</li>';
								if ($connecte == 2){
									echo '<li class="nav-item">';
									echo '<a class="nav-link" href="index.php?p=admin">Administration</a>';
									echo '</li>';
								}
								echo '<li class="nav-item dropdown ml-md-auto">';
								echo '<a class="nav-link" href="index.php?p=deconnexion">Déconnexion</a>';
								echo '</li>';
						}else {
							echo '<li class="nav-item dropdown ml-md-auto">';
							echo '<a class="nav-link" href="index.php?p=connexion">Connexion</a>';
							echo '</li>';
						}
					?>
		
				</ul>
				<div class="page-header">
					<h1>
					<small>bibliothèque municipale</small> : Les auteurs qui chantent<br>
					</h1>
				</div>
				<div class="jumbotron">
					<?php
						include $pfile; // inclusion de fichier...(l'inculsion de page par un parametre url peut etre dangereux : double check)
					?>
				</div>
				<div class="page-footer">
					<h1>
						Copyright<small> Personne 2019 </small>
					</h1>
				</div>
			</div>
		</div>
	</div>

	<script src="js/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/scripts.js"></script>
</body>

</html>
