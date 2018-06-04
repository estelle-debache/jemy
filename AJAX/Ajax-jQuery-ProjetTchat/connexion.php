<?php require_once("inc/init.inc.php");
//--------------------------- TRAITEMENTS PHP---------------------------//
if(isset($_POST['connexion'])) {
	$resultat = $pdo->query("SELECT * FROM membre WHERE pseudo='$_POST[pseudo]'");
	if($resultat->rowCount() >= 1) {
		$membre = $resultat->fetch(PDO::FETCH_ASSOC);
		$_SESSION['membre']['id_membre'] = $membre['id_membre'];
		$_SESSION['membre']['pseudo'] = $membre['pseudo'];
		$_SESSION['membre']['civilite'] = $membre['civilite'];
		$_SESSION['membre']['ville'] = $membre['ville'];	
		$pdo->exec("UPDATE membre SET date_connexion=" . time() . " WHERE id_membre = $membre[id_membre]");
		header("location:index.php");
	} else {
		$content .= '<div class="alert alert-danger" role="alert">Erreur de pseudo !</div>';
	}
}
?>
<!----------------------------------------------------------------------->
<?= $content; ?>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
<link rel="stylesheet" href="inc/style.css" />
<form method="post" action="">
	<label for="pseudo">Pseudo : </label>
	<input type="text" name="pseudo" placeholder="Votre pseudo" id="pseudo" class="form-control"><br>

	<input type="submit" name="connexion" class="btn btn-default" value="Se connecter au tchat !">
</form>
