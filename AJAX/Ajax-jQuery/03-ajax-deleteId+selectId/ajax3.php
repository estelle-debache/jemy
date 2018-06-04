<?php
require_once('init.inc.php');
extract($_POST);
$result = $pdo->exec("DELETE FROM employes WHERE id_employes = '$id'");

$tab['resultat'] = '';
$result = $pdo->query("SELECT * FROM employes");
$tab['resultat'] .= '<select name="personne" id="personne">';
while($employe = $result->fetch(PDO::FETCH_ASSOC)) {
	$tab['resultat'] .= "<option value=\"$employe[id_employes]\">$employe[prenom]</option>";
}
$tab['resultat'] .= '</select>';

$tab['validation'] = 'ok';
echo json_encode($tab);
