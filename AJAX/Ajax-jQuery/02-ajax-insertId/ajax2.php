<?php
require_once('init.inc.php');
extract($_POST);
$result = $pdo->exec("INSERT INTO employes (prenom) VALUES ('$personne')");
$tab['validation'] = 'ok';
echo json_encode($tab);
