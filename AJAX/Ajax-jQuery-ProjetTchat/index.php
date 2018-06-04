<?php
require_once('inc/init.inc.php');
if(!isset($_SESSION['membre']['pseudo'])) // si on a pas de pseudo enregistré dans une session, c'est qu'on est pas passé par la page de connexion
{
	header('location:connexion.php'); // redirection vers la page connexion.php
}
?>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link rel="stylesheet" href="inc/style.css" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="inc/ajax.js"></script>
<!--<script src="https://code.jquery.com/jquery-3.3.1.min.js"
  integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
  crossorigin="anonymous"></script>-->
<script type="text/javascript">
<?php
	$resultat = $pdo->query("SELECT id_dialogue FROM dialogue ORDER BY id_dialogue DESC LIMIT 1");
	$donnees = $resultat->fetch(PDO::FETCH_ASSOC);
?>
	var lastid = <?php if(isset($donnees['id_dialogue'])) echo $donnees['id_dialogue']; else echo 0; ?>;
</script>
<!-- ================================================================= -->
<div id="container">
	<div id="message_tchat" style='overflow: scroll; overflow-x: hidden; max-height: 500px;'>
	<?php // Affiche tous les messages postés depuis la dernière connexion au tchat
		echo '<h2>Connecté en tant que : ' . $_SESSION['membre']['pseudo'] . '</h2>';
		$resultat = $pdo->query("SELECT d.id_dialogue, m.pseudo, m.civilite, d.message, date_format(d.date, '%d/%m/%Y') as datefr, date_format(d.date, '%H:%i:%s') as heurefr FROM dialogue d, membre m WHERE m.id_membre = d.id_membre ORDER BY d.date ASC"); // permet de prendre les 15 derniers commentaires dans le bon ordre
		while($dialogue = $resultat->fetch(PDO::FETCH_ASSOC)) {
			if($dialogue['civilite'] == 'm')
				echo '<p title="' . $dialogue['pseudo'] . ' à ' . $dialogue['datefr'] . ' - ' . $dialogue['heurefr'] . '" class="bleu"><strong>' . $dialogue['pseudo'] . '</strong> : ' . $dialogue['message'] . '</p>';
			else
				echo '<p title="' . $dialogue['pseudo'] . ' à ' . $dialogue['datefr'] . ' - ' . $dialogue['heurefr'] . '" class="rose"><strong>' . $dialogue['pseudo'] . '</strong> : ' . $dialogue['message'] . '</p>';
		}
	?>
	</div>
<!-- ================================================================= -->
	<div id="liste_membre_connecte">
	<?php
		echo '<h2>Membres connectés : </h2>';
		$resultat = $pdo->query("SELECT * FROM membre WHERE date_connexion > " . (time()-3600)); // Affiche les membres s'étant connecté ou ayant posté un message dans la dernière heure (3600 secondes)
		while($membre = $resultat->fetch(PDO::FETCH_ASSOC)) {
			if($membre['civilite'] == 'm')
				echo '<p class="bleu" title="Homme, ' . $membre['ville'] . ', ' . age($membre['date_de_naissance']) . ' ans">' . $membre['pseudo'] . '</p>';
			else
				echo '<p class="rose" title="Femme, ' . $membre['ville'] . ', ' . age($membre['date_de_naissance']) . ' ans">' . $membre['pseudo'] . '</p>';
		}
	?>
	</div>
	<div class="clear"></div>
<!-- ================================================================= -->
	<div id="smiley">
		<img class="smiley" src="smil/smiley1.gif" alt=":)" />
		<img class="smiley" src="smil/smiley2.gif" alt=":|" />
		<img class="smiley" src="smil/smiley3.gif" alt=":d" />
		<img class="smiley" src="smil/smiley4.gif" alt=":p" />
		<img class="smiley" src="smil/smiley5.gif" alt="{3" />
		<img class="smiley" src="smil/smiley6.gif" alt=":o" />
	</div>
	
<!-- ================================================================= -->
	<div id="formulaire_tchat">
		<form method="post" action="#">
			<textarea id="message" name="message" rows="5" value="<?php if(isset($_POST['message'])) print $_POST['message']; ?>" maxlength="300"></textarea><br>
			<input type="submit" name="envoi" value="envoi" class="submit" />
		</form>
	</div>
</div>
<!-- ================================================================= -->
