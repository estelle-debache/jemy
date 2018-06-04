<!DOCTYPE html>
<html>
	<head>
		<script src="ajax5.js"></script>
	</head>
	<body>
		<form method="post" action='#'>
	<?php
		require_once('init.inc.php');
		$result = $pdo->query("SELECT * FROM employes");
		echo '<select name="personne" id="personne">';
		while($employe = $result->fetch(PDO::FETCH_ASSOC))
		{
			echo "<option>$employe[prenom]</option>";
		}
		echo '</select>';
	?>
		<input type="submit" value="ok" id="submit">
		</form>
	<div id="resultat"></div>
	</body>
</html>
