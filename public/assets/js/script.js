/** DEMANDE CONGE *****************************************/
$("button").click(function(){
	$("div.demandeConge").show(1000);
	$("button.btndemandeConge").slideUp(500);
})


$(function () {
    $('#datetimepicker4').datetimepicker({
         format: 'L'
    });
});

$(function () {
    $('#datetimepicker3').datetimepicker({
        format: 'L'
    });
});
