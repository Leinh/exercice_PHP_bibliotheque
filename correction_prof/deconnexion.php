<?php

setcookie("employe_valide", '', time() - (60*15), "/"); // COOKIE dans le passé.
header("location: index.php?p=home");