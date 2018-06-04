// =======================================================================
// Fonction permettant d'ajouter un événement click sur le bouton submit lorsque la page html est chargée (DOMContentLoaded).
document.addEventListener("DOMContentLoaded", function(event) {
	document.getElementById("submit").addEventListener('click', function(event) {
		event.preventDefault(); // annule le comportement par défaut du submit (qui recharge habituellement la page).
		ajax(); // exécute notre fonction ajax() pour le traitement du submit
	});
// =======================================================================
// Fonction permettant d'afficher les informations d'un employé de la table "employes" en BDD.
	function ajax()
	{
		if(window.XMLHttpRequest) r = new XMLHttpRequest(); // Pour la plupart des navigateurs web
		else r = new ActiveXObject("Microsoft.XMLHTTP"); // Pour Internet Explorer version 7 et antérieures
		
		var p = document.getElementById("personne");
		var personne = p.value;
		console.log(personne);
		var parameters = "personne="+personne;
		r.open("POST", "ajax2.php", true); // Ouvre une connexion avec le fichier ajax2.php
		r.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		r.send(parameters); // Envoie la requête avec les paramètres
		document.getElementById("resultat").innerHTML = "<div style=\"background: #22d3a7;\">employé " + p.value + " ajouté ! </div>";
		document.getElementById("personne").value = "";
	}
});
	
	
	
	
	
	
	
	
	