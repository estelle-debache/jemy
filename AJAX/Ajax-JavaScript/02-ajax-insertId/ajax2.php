<?php
require_once('init.inc.php');
// extract() sert à exporter un tableau vers la table des symboles. Elle prend un tableau associatif array, créée les variables dont les noms sont les index de ce tableau, et leur affecte la valeur associée.
extract($_POST);
$result = $pdo->exec("INSERT INTO employes (prenom) VALUES ('$personne')");
