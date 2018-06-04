// =======================================================================
// Fonction permettant d'ajouter un événement click sur le bouton submit lorsque la page html est chargée (DOMContentLoaded).
$(document).ready(function() {
	$("#submit").click(function(event) {
		event.preventDefault(); // annule le comportement par défaut du submit (qui recharge habituellement la page).
		ajax();
	});
// =======================================================================
// Fonction permettant d'afficher les informations d'un employé de la table "employes" en BDD.
	function ajax() {
		personne = $("#personne").val(); // nous récupérons la valeur saisie dans l'input.
		$.post("ajax2.php", "personne="+personne, function(data) {
			if(data.validation == 'ok') {
				$('#resultat').append("<div style=\"background: #22d3a7\">Employé " + personne + " ajouté !</div>"); // append veut dire accroche, on accroche donc le résultat dans la div qui à l'id #resultat
				$('#personne').val("");
			} else {
				alert("Problème d'affichage du message");
			}
		}, 'json');
	}
});
