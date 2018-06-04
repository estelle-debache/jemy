<?php
require_once('init.inc.php');
$tab = array();
extract($_POST);
$tab['resultat'] = '';
$result = $pdo->query("SELECT * FROM employes WHERE prenom='$personne'");
$tab['resultat'] .= "<table border=\"5\"><tr>";
for($i = 0; $i < $result->columnCount(); $i++) {
	$colonne = $result->getColumnMeta($i); // getColumnMeta récupère les informations sur les colonnes
	$tab['resultat'] .= "<th>$colonne[name]</th>";
}
$tab['resultat'] .= "</tr>";
while($ligne = $result->fetch(PDO::FETCH_ASSOC))
{
	$tab['resultat'] .= "<tr>";
	foreach($ligne AS $indice => $valeur)
	{
		$tab['resultat'] .= '<td>' . $valeur . '</td>';
	}
	$tab['resultat'] .= "</tr>";
}
$tab['resultat'] .= "</table>";

echo json_encode($tab);
