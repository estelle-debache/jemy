<?php
require_once('init.inc.php');
$tab = array();
extract($_POST);
/* Action : envoi_message : permet l'ajout d'un message */
// =======================================================================
// ENVOYER UN MESSAGE
if($_POST['action'] == 'envoi_message') {
	$_POST['message'] = addslashes($_POST['message']); // évite les problèmes d'apostrophes.
	if(!empty($_POST['message'])) { // s'il y a bien un message, on l'enregistre
		$pdo->exec("INSERT INTO dialogue (id_membre, message, date) VALUES ('" . $_SESSION['membre']['id_membre'] . "', '$_POST[message]', NOW())"); // on insére le message dans la table dialogue
		$pdo->exec("UPDATE membre SET date_connexion = " . time() . " WHERE id_membre = " . $_SESSION['membre']['id_membre']);
	}
	$tab['validation'] = 'ok';
}

/* Action : affichage_message : permet l'affichage des messages */
// =======================================================================
// AFFICHAGE DES MESSAGES
if($_POST['action'] == 'affichage_message') {
	$lastid = floor($lastid);
	$resultat = $pdo->query("SELECT d.id_dialogue, m.pseudo, m.civilite, d.message, date_format(d.date, '%d/%m/%Y') as datefr, date_format(d.date, '%H:%i:%s') as heurefr FROM dialogue d, membre m WHERE d.id_dialogue<$lastid AND d.id_membre = m.id_membre ORDER BY d.date ASC"); // on affiche les messages depuis le dernier ($lastid correspond au dernier message posté lorsque l'on tombe sur la page).
	$tab['resultat'] = '';
	$tab['lastid'] = $lastid;
	while($dialogue = $resultat->fetch(PDO::FETCH_ASSOC)) {
		if($dialogue['civilite'] == 'm')
			$tab['resultat'] .= '<p title="' . $dialogue['pseudo'] . ' à ' . $dialogue['datefr'] . ' - ' . $dialogue['heurefr'] . '" class="bleu"><strong>' . $dialogue['pseudo'] . '</strong>' . $dialogue['message'] . '</p>';
		else
			$tab['resultat'] .= '<p title="' . $dialogue['pseudo'] . ' à ' . $dialogue['datefr'] . ' - ' . $dialogue['heurefr'] . '" class="rose"><strong>' . $dialogue['pseudo'] . '</strong>' . $dialogue['message'] . '</p>';
		$tab['lastid'] = $dialogue['id_dialogue']; // au dernier tour de boucle, le dernier id_dialogue sera conservé en mémoire afin de ne pas réafficher des messages déjà sortis puisque cette portion de code est exécutée toutes les 5 secondes.
	}
	$tab['validation'] = 'ok';
}

/* Action : affichage_membre_connecte : permet l'affichage des membres connectés */
//========================================================================
// AFFICHAGE DES MEMBRES CONNECTÉS
if($_POST['action'] == 'affichage_membre_connecte') {
	$resultat = $pdo->query("SELECT * FROM membre WHERE date_connexion > " . (time()-3600)); // affiche les membres s'étant connectés ou ayant déposés un message dans la dernière heure (3600 secondes)
	$tab['resultat'] = '<h2>Membres connectés : </h2>'; // attention le "é" de connectés peut provoquer un dysfonctionnement en fonction de l'encodage choisi.
	while($donnees = $resultat->fetch(PDO::FETCH_ASSOC)) {
		if($donnees['civilite'] == 'm')
			$tab['resultat'] .= '<p class="bleu" title="Homme, ' . $donnees['ville'] . ', ' . age($donnees['date_de_naissance']) . ' ans">' . $donnees['pseudo'] . '</p>';
		else
			$tab['resultat'] .= '<p class="rose" title="Femme, ' . $donnees['ville'] . ', ' . age($donnees['date_de_naissance']) . ' ans">' . $donnees['pseudo'] . '</p>';
	}
	$tab['resultat'] = 'ok';
}
//------------------------------------------------------------------------
echo json_encode($tab);
