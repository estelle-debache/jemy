<?php require_once("inc/init.inc.php");
//--------------------------- TRAITEMENTS PHP---------------------------//
	if($_POST) {
		$erreur = '';
		if(!preg_match('#^[a-zA-Z0-9.-_]+$#', $_POST['pseudo'])) {
			$erreur .= '<div class="alert alert-danger" role="alert">Erreur format pseudo</div>';
		}
		$r = $pdo->query("SELECT * FROM membre WHERE pseudo = '$_POST[pseudo]'");
		if($r->rowCount() >= 1) {
			$erreur .= '<div class="alert alert-danger" role="alert">Pseudo indisponible !</div>';
		}
		foreach($_POST as $indice => $valeur) {
			$_POST[$indice] = addslashes($valeur);
		}
		if(empty($erreur)) {
			$pdo->exec("INSERT INTO membre (pseudo, civilite, ville, date_de_naissance, date_connexion) VALUES ('$_POST[pseudo]', '$_POST[civilite]', '$_POST[ville]', '$_POST[date_de_naissance]', NOW())");
			$content .= '<div class="alert alert-success" role="alert">Inscription validée !</div>';
		}
		$content .= $erreur;
	}
?>
<?= $content; ?>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
<link rel="stylesheet" href="inc/style.css" />
<form method="post" action="">
	<label for="pseudo">Pseudo : </label>
	<input type="text" class="form-control" placeholder="Votre pseudo" name="pseudo" id="pseudo" required><br>

	<label for="civilite">Civilité : </label>
	<input type="radio" name="civilite" id="civilite" value="m" checked>
	Homme -- Femme
	<input type="radio" name="civilite" id="civilite" value="f"><br>
	
	<label for="ville">Ville : </label>
	<input type="text" class="form-control" placeholder="Votre ville" name="ville" id="ville"><br>
	
	<label for="date_de_naissance">Date de naissance : </label>
	<input type="date" class="form-control" placeholder="votre date de naissance" name="date_de_naissance" id="date_de_naissance"><br>

	<input type="submit" name="inscription" value="S'inscrire" class="btn btn-default"><br>
</form>