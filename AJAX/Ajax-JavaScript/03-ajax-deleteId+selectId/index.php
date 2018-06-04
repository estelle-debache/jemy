<!DOCTYPE html>
<html>
	<head>
		<script src="ajax3.js"></script>
	</head>
	<body>
		<form method="post" action="#">
		<div id="employes" style="display: inline;">
	<?php
		require_once('init.inc.php');
		$result = $pdo->query("SELECT * FROM employes");
		echo '<select name="personne" id="personne">';
		while($employe = $result->fetch(PDO::FETCH_ASSOC))
		{
			echo "<option value=\"$employe[id_employes]\">$employe[prenom]</option>";
		}
		echo '</select>';
	?>
		</div>
		<input type="submit" value="supprimer" id="submit">
		</form>
	<div id="resultat"></div>
	</body>
</html>
