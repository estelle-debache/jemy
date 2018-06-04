// =======================================================================
// Fonction permettant d'ajouter un événement click sur le bouton submit lorsque la page html est chargée (DOMContentLoaded).
document.addEventListener("DOMContentLoaded", function(event) {
	document.getElementById("submit").addEventListener('click', function(event) {
		event.preventDefault(); // annule le comportement par défaut du submit (qui recharge habituellement la page).
		ajax(); // exécute notre fonction ajax() pour le traitement du submit
	});
// =======================================================================
// Fonction permettant d'afficher les informations d'un employé (selectionné via le select/option) de la table "employes" en BDD.
	function ajax()
	{
		if(window.XMLHttpRequest) r = new XMLHttpRequest(); // Pour la plupart des navigateurs web
		else r = new ActiveXObject("Microsoft.XMLHTTP"); // For IE 7 et antérieur
		
		var p = document.getElementById("personne");
		var personne = p.options[p.selectedIndex].value;
		var parameters = "personne="+personne;
		r.open("POST", "ajax5.php", true); // Ouvre la connexion
		r.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		r.onreadystatechange = function()	// Quand l'état change
		{
			if(r.readyState == 4 && r.status == 200)
			{
				var obj = JSON.parse(r.responseText);
				document.getElementById("resultat").innerHTML = obj.resultat;
			}
		}
		r.send(parameters); // Envoie la requête avec les paramètres
	}
});
