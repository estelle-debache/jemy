$(document).ready(function() { // function est appelée automatiquement en jQuery lorsque le DOM est chargé.
// =======================================================================
// INITIALISATION DU TCHAT
	convertir_smiley();
	$('#message_tchat').scrollTop($('#message_tchat')[0].scrollHeight); // permet de mettre l'ascenseur en bas.
	var url = 'inc/ajax.php'; // url avec laquelle on va échanger dynamiquement
	var lastid = 0; // dernier id de dialogue
	var timer = setInterval(affichage_message, 13000); // interval de vérification pour lancer la fonction affichant les messages.
	var timer_membre_connecte = setInterval(affichage_membre_connecte, 53000); // interval de vérification pour lancer la fonction affichant les membres connectés.
// =======================================================================
// FONCTION PERMETTANT D'AFFICHER LES MEMBRES CONNECTÉS AU TCHAT DANS LA PAGE WEB
	function affichage_membre_connecte() { // cette fonction permet d'afficher les membres connectés au tchat
		$.post(url, {action: 'affichage_membre_connecte'}, function(data)
		{ // $.post() : permet d'accéder au contenu du post, on passe l'action affichage_membre_connecte au fichier ajax.php (contenu dans la variable url)
			if(data.validation == 'ok') {
				$('#liste_membre_connecte').empty().append(data.resultat); // append veut dire accroche, on accroche donc le résultat dans la div qui à l'id "liste_membre_connecte".
				// empty().append() : on vide puis on ajoute.
			} else {
				alert('Problème d\'affichage des membres connectés');
			}
		}, 'json');
		return false; // empèche que le formulaire soit soumis
	}
// =======================================================================
// EVENEMENT PERMETTANT D'INSERER UN SMILEY DANS LA TEXTAREA
	$(".smiley").click(function(event) { // si on clique sur un élément ayant la classe smiley
		var prevMsg = $("#message").val(); // on récupère la valeur de la zone ayant l'id "message".
		var emotiText = $(event.target).attr("alt");
		$("#message").val(prevMsg + emotiText);
	});
// =======================================================================
// EVENEMENT PERMETTANT DE POSTER UN MESSAGE DANS LE TCHAT
	$("#formulaire_tchat form").submit(function() { // lorsque que je clique sur submit
		clearInterval(timer); // on arrete le timer car nous faisons un traitement
		showLoader("#formulaire_tchat"); // on affiche un loader sur la div ayant l'id "formulaire_tchat".
		var message = $('#formulaire_tchat form textarea[name=message]').val(); // .val() nous permet de récupérer la valeur du textarea
		$.post(url, {action: 'envoi_message', message: message}, function(data) {
			if(data.validation == 'ok') {
				affichage_message(); // quand on ajoute un message, on en profite pour allez voir les derniers messages à afficher
				$('#formulaire_tchat form textarea[name=message]').val(''); // on vide le textarea pour éviter qu'un membre envoi deux fois le même message
			} else {
				alert('Problème lors de l\'envoi du message');
			}
			timer = setInterval(affichage_message, 5000); // on remet le timer à 5000 millisecondes
			hideLoader(); // on retire le loader une fois que l'envoi a été fait
		}, 'json');
		return false; // empèche que le formulaire soit soumis de manière traditionnelle en PHP et que cela recharge toute la page.
	});
// =======================================================================
// FONCTION PERMETTANT DE CONVERTIR UN CODE SMILEY EN IMAGE
	function convertir_smiley() {
		$('#message_tchat p').each(function() { // chaque p va être analyser (grâce au each()).
			$('#message_tchat').html($('#message_tchat').html().replace(':)', '<img src="smil/smiley1.gif" />'));
			$('#message_tchat').html($('#message_tchat').html().replace(':|', '<img src="smil/smiley2.gif" />'));
			$('#message_tchat').html($('#message_tchat').html().replace(':d', '<img src="smil/smiley3.gif" />'));
			$('#message_tchat').html($('#message_tchat').html().replace(':p', '<img src="smil/smiley4.gif" />'));
			$('#message_tchat').html($('#message_tchat').html().replace('{3', '<img src="smil/smiley5.gif" />'));
			$('#message_tchat').html($('#message_tchat').html().replace(':o', '<img src="smil/smiley6.gif" />'));
		});
	}
// =======================================================================
// FONCTION PERMETTANT D'AFFICHER LES MESSAGES DU TCHAT DANS LA PAGE WEB
	function affichage_message() { // cette fonction permet d'afficher les messages
		$.post(url, {action: 'affichage_message', lastid: lastid}, function(data) { // $.post() permet d'accéder au contenu du post, on passe l'action affichage_message au fichier ajax.php (contenu dans variable url) ainsi que le dernier id.
			if(data.validation == 'ok') {
				location.reload();
				$("#message_tchat").append(data.resultat); // on append le résultat dans la div qui à l'id "message_tchat"
				lastid = data.lastid; // on récupère également le dernier id. data vient du fichier ajax.php car c'est le nom que l'on a donné à la variable dans la boucle permettant de sortir les messages.
				$("#message_tchat").scrollTop($("#message_tchat")[0].scrollHeight); // permet de mettre l'ascenseur en bas.
				convertir_smiley();
			} else {
				alert('Problème d\'affichage des messages');
			}
			hideLoader(); // on retire le loader une fois que l'affichage a été fait
		}, 'json');
		return false; // empèche que le formulaire soit soumis
	}
// =======================================================================
// FONCTION PERMETTANT D'AFFICHER LE LOADER
	function showLoader(div) { // affiche le loader
		$(div).append('<div class="loader"></div>');
		$('.loader').fadeTo(500, 0.6); // 500 millisecondes, 60% d'opacité.
	}
// =======================================================================
// FONCTION PERMETTANT DE CACHER LE LOADER
	function hideLoader(div) { // cacher le loader
		$('.loader').fadeOut(500, function() { 
			$('.loader').remove(); // permet de retirer le loader du code html
		});
	}
}); // fin de document ready
