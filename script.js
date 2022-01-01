// Affiche la partie 3v3 ou la partie 2v2 en cliquant sur les boutons correspondant
function v2(){
	$("#v2").toggle();
	$("#v3").css("display","none");
}

function v3(){
	$("#v3").toggle();
	$("#v2").css("display","none");
}

// Affiche les stats de chaque spécialisation ainsi que les conseils en cliquant sur les images
$(document).ready(function() {	
	$(".imgs").click(function(){
			$(this).next().toggle();
	});
	
	$(".limg").click(function(){
			$(this).next().toggle();
	});

});
