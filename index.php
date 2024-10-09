<?php
// Appliquer la déclaration stricte des types.
declare(strict_types=1);
define("DS", DIRECTORY_SEPARATOR);

/*
    Importez le(s) fichier(s) nécessaire(s).
    Lancez la partie en appelant la fonction principale que vous aurez développé dans le fichier 'pendu/app.php'.
*/
$path_app = __DIR__ . DS . "pendu" . DS . "app.php";
require_once $path_app;
start(10);
?>