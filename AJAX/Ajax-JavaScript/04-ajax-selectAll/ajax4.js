// =======================================================================
// Fonction permettant d'afficher les informations d'un employé de la table "employes" en BDD.
document.addEventListener("DOMContentLoaded", function(event) {
	if(window.XMLHttpRequest) r = new XMLHttpRequest(); // For Most Browser
	else r = new ActiveXObject("Microsoft.XMLHTTP"); // For Internet Explorer <= 7
	var personne = document.getElementById("personne");
	personne = personne.innerHTML;
	var parameters = "personne="+personne;
	r.open("POST", "ajax4.php", true); // Ouvre la connexion
	r.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	r.onreadystatechange = function()
	{
		if(r.readyState == 4 && r.status == 200)
		{
			var obj = JSON.parse(r.responseText);
			document.getElementById("resultat").innerHTML = obj.resultat;
		}
	}
	r.send(parameters); // Envoie la requête avec les paramètres
});
