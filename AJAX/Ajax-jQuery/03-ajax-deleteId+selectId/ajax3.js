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
		var id = $("#personne").find(":selected").val();
		$.post("ajax3.php", "id="+id, function(data) {
			if(data.validation == 'ok') {
				$('#employes').html(data.resultat);
			} else {
				alert("Problème d'affichage du message");
			}
		}, 'json');
	}
});
