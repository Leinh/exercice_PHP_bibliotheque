<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<link rel="shortcut icon" href="images/ico.ico" type="image/x-icon">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" 
integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
<link rel="stylesheet" href="style.css">
<link rel="stylesheet" href="style2.css">
<link rel="stylesheet" href="style3.css">
<title><?php echo $titreOnglet ?></title>
</head>
<body>
<div class="container-fluid p-0 m-0">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark row ">
  <a class="navbar-brand text-success col-10 col-sm-1" href="index.php">Accueil</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
  <ul class="nav nav-pills col-12 col-sm-8">
  <li class="nav-item">
    <a class="nav-link text-success" href="bibliotheque.php">Bibliothèque</a>
  </li>
  <li class="nav-item">
    <a class="nav-link text-success" href="pret.php">Prêts</a>
  </li>
  <li class="nav-item">
    <a class="nav-link text-success" href="retard.php">Retards</a>
  </li>
  <li class="nav-item">
    <a class="nav-link disabled" href="admin.php" tabindex="-1" aria-disabled="true">Admin</a>
  </li>
  <li class="nav-item">
    <a class="nav-link text-success" href="connexion.php">Connexion</a>
  </li>
</ul>
    <form class="form-inline my-2 my-lg-2 ">
      <input class="form-control mr-sm-2" name="recherche" type="search" placeholder="Recherchez..." aria-label="Search">
      <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Recherche</button>
    </form>
  </div>
</nav>