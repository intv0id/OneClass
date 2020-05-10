/*----------------------------------------------------------------------------------------------------------------------------
													VARIABLES GLOBALES
----------------------------------------------------------------------------------------------------------------------------*/

var url_videos = new Array();
var nb_video = 0;
reset_url_videos();

/*----------------------------------------------------------------------------------------------------------------------------
														FONCTIONS
----------------------------------------------------------------------------------------------------------------------------*/

/* ----------------------------------  FONTIONS DE GESTION DE CONTENU ------------------------------------------------------*/

function lumiere() {
	if (getInternetExplorerVersion() == -1){bkg = getComputedStyle(document.body, null).backgroundColor;}
	else{bkg = document.body.currentStyle.backgroundColor;}
	if(bkg == 'white' || bkg == 'transparent' || bkg == 'rgba(0, 0, 0, 0)'){
		document.body.style.backgroundColor = 'black';
		document.body.getElementsByTagName("header")[0].style.display = "none";
		document.body.getElementsByTagName("footer")[0].style.display = "none";
		document.body.getElementsByTagName("nav")[0].style.display = "none";
		document.getElementById('Videos').style.border = "none";
		var i = 0;
		while(document.getElementById('Videos').getElementsByTagName("br")[i]){
			document.getElementById('Videos').getElementsByTagName("br")[i].style.display = "none";
			i++;
		}
		
	}
	else{
		document.body.style.backgroundColor = 'transparent';
		document.body.getElementsByTagName("header")[0].style.display = "block";
		document.body.getElementsByTagName("footer")[0].style.display = "block";
		document.body.getElementsByTagName("nav")[0].style.display = "block";
		document.getElementById('Videos').style.border = "5px solid gray";
		var i = 0;
		while(document.getElementById('Videos').getElementsByTagName("br")[i]){
			document.getElementById('Videos').getElementsByTagName("br")[i].style.display = "inline";
			i++;
		}
	}

}

function creer_background(){
	var newLink = document.createElement('a');
	newLink.id = 'abg';
	newLink.onclick = supprimer_panneau;
	newLink.href = '#';
	document.getElementById('corps').appendChild(newLink);
	var newbackground = document.createElement('div');
	newbackground.id = 'bcg';
	document.getElementById('abg').appendChild(newbackground);
}

function supprimer_background(){
	var abg = document.getElementById('abg');
	abg.parentNode.removeChild(abg);
}

function supprimer_panneau(){
	supprimer_background();
	var divpanneau = document.getElementById('divpanneau');
	divpanneau.parentNode.removeChild(divpanneau);
	reset_url_videos();
}

function creer_panneau(width, height){
	creer_background();
	var newdiv = document.createElement('div');
	newdiv.id = "divpanneau";
	newdiv.width = width;
	newdiv.height = height;
	document.getElementById('corps').appendChild(newdiv);
}

function creer_playlist() {
	creer_panneau(800, 600);
	
	var new_avancement_indic = document.createElement('p');
	new_avancement_indic.id = "avancement_indic";
	document.getElementById('divpanneau').appendChild(new_avancement_indic);
	
	var new_button_back = document.createElement('input');
	new_button_back.id = "button_back";
	new_button_back.type = "submit";
	new_button_back.value = "Pr\351c\351dent";
	new_button_back.onclick = click_precedent_pl;
	document.getElementById('divpanneau').appendChild(new_button_back);
	
	var new_button_next = document.createElement('input');
	new_button_next.id = "button_next";
	new_button_next.type = "submit";
	new_button_next.value = "Suivant";
	new_button_next.onclick = click_suivant_pl;
	document.getElementById('divpanneau').appendChild(new_button_next);
	
	var new_button_end = document.createElement('input');
	new_button_end.id = "button_end";
	new_button_end.type = "submit";
	new_button_end.value = "Termin\351";
	new_button_end.onclick = click_terminer_pl;
	document.getElementById('divpanneau').appendChild(new_button_end);
	
	var new_url_input = document.createElement('input');
	new_url_input.type = "text";
	new_url_input.id = "input_url_video";
	new_url_input.placeholder = "Adresse video YOUTUBE";
	new_url_input.onchange = changement_url_video;
	document.getElementById('divpanneau').appendChild(new_url_input);
	
	reset_url_videos();
	
	gestion_form_creer_video();
}

function creer_actu(){
	creer_panneau(800, 600);
	
	if (window.XMLHttpRequest){var xhr = new XMLHttpRequest();}
	else{var xhr = new ActiveXObject("Microsoft.XMLHTTP");}
	xhr.open('GET', 'AJAX/get_niv_auto.php', false);
	xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xhr.send();
	
	if(xhr.responseText == "DELEGUE" || xhr.responseText == "PROF" || xhr.responseText == "ADMIN"){
		var new_warning_level_p = document.createElement('p');
		new_warning_level_p.id = "p_warning_level";
		new_warning_level_p.innerHTML = "Important ? ";
		document.getElementById('divpanneau').appendChild(new_warning_level_p);
			
		var new_warning_level_input = document.createElement('input');
		new_warning_level_input.type = "checkbox";
		new_warning_level_input.id = "input_warning_level";
		document.getElementById('divpanneau').appendChild(new_warning_level_input);
	}
	var new_actu_p = document.createElement('p');
	new_actu_p.id = "p_actu";
	new_actu_p.innerHTML = "Votre article :";
	document.getElementById('divpanneau').appendChild(new_actu_p);
		
	var new_actu_input = document.createElement('textarea');
	new_actu_input.id = "input_actu";
	new_actu_input.placeholder = "R\351digez votre article ici !";
	document.getElementById('divpanneau').appendChild(new_actu_input);
	
	var new_br = document.createElement('br');
	document.getElementById('divpanneau').appendChild(new_br);
	
	var new_a_input_news = document.createElement('a');
	new_a_input_news.id = "a_input_news";
	new_a_input_news.href = "#";
	new_a_input_news.innerHTML = "Publier cet article !";
	new_a_input_news.onclick = ajouter;
	document.getElementById('divpanneau').appendChild(new_a_input_news);
}

function gestion_compte_admin(){
	creer_panneau(800, 600);
	
	var new_a_create_account = document.createElement('a');
	new_a_create_account.id = "a_create_account";
	new_a_create_account.href = "#";
	new_a_create_account.innerHTML = "Ajouter un compte !";
	new_a_create_account.onclick = click_ajouter_compte;
	document.getElementById('divpanneau').appendChild(new_a_create_account);
	
	var new_br = document.createElement('br');
	document.getElementById('divpanneau').appendChild(new_br);
	
	var new_a_go_account = document.createElement('a');
	new_a_go_account.id = "a_go_account";
	new_a_go_account.href = "?page=Compte";
	new_a_go_account.innerHTML = "Mon compte";
	document.getElementById('divpanneau').appendChild(new_a_go_account);
	
	var new_br2 = document.createElement('br');
	document.getElementById('divpanneau').appendChild(new_br2);
	
	if (window.XMLHttpRequest){var xhr = new XMLHttpRequest();}
	else{var xhr = new ActiveXObject("Microsoft.XMLHTTP");}
	xhr.open('GET', 'AJAX/ls_users.php', false);
	xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xhr.send();
	var xhrdoc = xhr.responseText;
	var ii = 0;
}

function confirmation(texte){
	creer_panneau(800, 200);
	if(1){
		return true;
	}
	else{
		return false;
	}
}

function getInternetExplorerVersion(){
// Returns the version of Internet Explorer or a -1
// (indicating the use of another browser).
  var rv = -1; // Return value assumes failure.
  if (navigator.appName == 'Microsoft Internet Explorer')
  {
    var ua = navigator.userAgent;
    var re  = new RegExp("MSIE ([0-9]{1,}[\.0-9]{0,})");
    if (re.exec(ua) != null)
      rv = parseFloat( RegExp.$1 );
  }
  return rv;
}

/* ----------------------------------  FONTIONS DE GESTION D'ACTIONS  ----------------------------------------------------*/

function changement_url_video(){
	if(/\S*youtube.com\S*v=([a-zA-Z0-9-_]*)&?/i.test(document.getElementById('input_url_video').value)){

		if (document.getElementById("iframeyoutube" + nb_video)){
			document.getElementById("iframeyoutube" + nb_video).parentNode.removeChild(document.getElementById("iframeyoutube" + nb_video));
		}
		var newiframeyoutube = document.createElement('iframe');
		newiframeyoutube.id = 'iframeyoutube' + nb_video;
		newiframeyoutube.width = "200" ;
		newiframeyoutube.height = "150";
		newiframeyoutube.src = "http://www.youtube.com/embed/" + RegExp.$1 + "?wmode=transparent";
		newiframeyoutube.frameborder = 0;
		document.getElementById('divpanneau').appendChild(newiframeyoutube);
	}
	else{
		alert('Adresse youtube incorrecte !');
		document.getElementById('input_url_video').value = "";
	}
}

function click_suivant_pl(){
	if(/\S*youtube.com\S*v=([a-zA-Z0-9-_]*)&?/i.test(document.getElementById('input_url_video').value)){
		document.getElementById('input_url_video').value = "";
		url_videos[nb_video] = RegExp.$1;
		nb_video++;
		gestion_form_creer_video();
	}
	else{
		alert('Adresse youtube incorrecte !');
		document.getElementById('input_url_video').value = "";
	}
}

function click_precedent_pl(){
	if (document.getElementById("iframeyoutube" + nb_video)){
		document.getElementById("iframeyoutube" + nb_video).parentNode.removeChild(document.getElementById("iframeyoutube" + nb_video));
	}
	nb_video--;
	document.getElementById('input_url_video').value = 'www.youtube.com/watch?v=' + url_videos[nb_video];
	url_videos[nb_video] = "";
	gestion_form_creer_video();
}

function click_terminer_pl(){
	gestion_form_creer_video();
	if(nb_video == 0 && (!/\S*youtube.com\S*v=([a-zA-Z0-9-_]*)&?/i.test(document.getElementById('input_url_video').value) || document.getElementById('input_url_video').value == "")){
		alert('Adresse youtube incorrecte !');
	}
	else{
		if(/\S*youtube.com\S*v=([a-zA-Z0-9-_]*)&?/i.test(document.getElementById('input_url_video').value)){
			document.getElementById('input_url_video').value = "";
			url_videos[nb_video] = RegExp.$1;
			nb_video++;
			gestion_form_creer_video();
		}
		document.getElementById('avancement_indic').parentNode.removeChild(document.getElementById('avancement_indic'));
		document.getElementById('button_back').parentNode.removeChild(document.getElementById('button_back'));
		document.getElementById('button_next').parentNode.removeChild(document.getElementById('button_next'));
		document.getElementById('button_end').parentNode.removeChild(document.getElementById('button_end'));
		document.getElementById('input_url_video').parentNode.removeChild(document.getElementById('input_url_video'));
		//eventuellement pour supprimer la pr�visualisation des videos en phase finale
		/*for(var i=0; i < nb_video; i++){
			document.getElementById("iframeyoutube" + i).parentNode.removeChild(document.getElementById("iframeyoutube" + i));
		}*/
		
		var new_genre_p = document.createElement('p');
		new_genre_p.id = "p_genre";
		new_genre_p.innerHTML = "Genre de musique de la playlist :";
		document.getElementById('divpanneau').appendChild(new_genre_p);
		
		var new_genre_input = document.createElement('input');
		new_genre_input.type = "text";
		new_genre_input.id = "input_genre";
		new_genre_input.placeholder = "Genre de musique de la playlist";
		document.getElementById('divpanneau').appendChild(new_genre_input);
		
		var new_comment_p = document.createElement('p');
		new_comment_p.id = "p_comment";
		new_comment_p.innerHTML = "Commentaires sur la playlist :";
		document.getElementById('divpanneau').appendChild(new_comment_p);
		
		var new_comment_input = document.createElement('textarea');
		new_comment_input.id = "input_comment";
		new_comment_input.placeholder = "Commentaires sur la playlist";
		document.getElementById('divpanneau').appendChild(new_comment_input);
		
		var new_br = document.createElement('br');
		document.getElementById('divpanneau').appendChild(new_br);
		
		var new_a_input_pl = document.createElement('a');
		new_a_input_pl.id = "a_input_pl";
		new_a_input_pl.href = "#";
		new_a_input_pl.innerHTML = "Publier la playlist !";
		new_a_input_pl.onclick = ajouter;
		document.getElementById('divpanneau').appendChild(new_a_input_pl);
	}
}

function gestion_form_creer_video(){
	if(nb_video == 0){
		document.getElementById('button_back').style.visibility = "hidden";
		document.getElementById('button_next').style.visibility = "visible";
		document.getElementById('button_end').style.visibility = "visible";
	}
	else if(nb_video == 14){
		document.getElementById('button_back').style.visibility = "visible";
		document.getElementById('button_next').style.visibility = "hidden";
		document.getElementById('button_end').style.visibility = "visible";
	}
	else{
		document.getElementById('button_back').style.visibility = "visible";
		document.getElementById('button_next').style.visibility = "visible";
		document.getElementById('button_end').style.visibility = "visible";
	}
    
	document.getElementById('avancement_indic').innerHTML = 'Vid\351o ' + (nb_video+1);
}

function click_ajouter_compte(){
	supprimer_panneau();
	creer_panneau(800, 600);
	
	var new_p_name_account = document.createElement('p');
	new_p_name_account.id = "p_name_account";
	new_p_name_account.innerHTML = "Nom du compte :";
	document.getElementById('divpanneau').appendChild(new_p_name_account);
		
	var new_input_account_name = document.createElement('input');
	new_input_account_name.type = "text";
	new_input_account_name.id = "input_account_name";
	new_input_account_name.placeholder = "Nom du compte";
	document.getElementById('divpanneau').appendChild(new_input_account_name);
	
	var new_p_pass_account = document.createElement('p');
	new_p_pass_account.id = "p_pass_account";
	new_p_pass_account.innerHTML = "Mot de passe :";
	document.getElementById('divpanneau').appendChild(new_p_pass_account);
		
	var new_input_account_pass = document.createElement('input');
	new_input_account_pass.type = "password";
	new_input_account_pass.id = "input_account_pass";
	new_input_account_pass.placeholder = "Mot de passe";
	document.getElementById('divpanneau').appendChild(new_input_account_pass);
	
	var new_input_account_repass = document.createElement('input');
	new_input_account_repass.type = "password";
	new_input_account_repass.id = "input_account_repass";
	new_input_account_repass.placeholder = "Mot de passe";
	document.getElementById('divpanneau').appendChild(new_input_account_repass);
	
	var new_p_auto_account = document.createElement('p');
	new_p_auto_account.id = "p_auto_account";
	new_p_auto_account.innerHTML = "Niveau d'autorisations :";
	document.getElementById('divpanneau').appendChild(new_p_auto_account);
	
	var new_input_select_autorisations = document.createElement('select');
	new_input_select_autorisations.id = "input_select_autorisations";
	document.getElementById('divpanneau').appendChild(new_input_select_autorisations);
	
	var new_input_option_eleve_select_autorisations = document.createElement('option');
	new_input_option_eleve_select_autorisations.id = "input_option_eleve_autorisations";
	new_input_option_eleve_select_autorisations.innerHTML = "ELEVE";
	new_input_option_eleve_select_autorisations.value = "ELEVE";
	document.getElementById('input_select_autorisations').appendChild(new_input_option_eleve_select_autorisations);
	
	var new_input_option_delegue_select_autorisations = document.createElement('option');
	new_input_option_delegue_select_autorisations.id = "input_option_delegue_autorisations";
	new_input_option_delegue_select_autorisations.innerHTML = "DELEGUE";
	new_input_option_delegue_select_autorisations.value = "DELEGUE";
	document.getElementById('input_select_autorisations').appendChild(new_input_option_delegue_select_autorisations);
	
	var new_input_option_prof_select_autorisations = document.createElement('option');
	new_input_option_prof_select_autorisations.id = "input_option_prof_autorisations";
	new_input_option_prof_select_autorisations.innerHTML = "PROF";
	new_input_option_prof_select_autorisations.value = "PROF";
	document.getElementById('input_select_autorisations').appendChild(new_input_option_prof_select_autorisations);
	
	var new_input_option_admin_select_autorisations = document.createElement('option');
	new_input_option_admin_select_autorisations.id = "input_option_admin_autorisations";
	new_input_option_admin_select_autorisations.innerHTML = "ADMIN";
	new_input_option_admin_select_autorisations.value = "ADMIN";
	document.getElementById('input_select_autorisations').appendChild(new_input_option_admin_select_autorisations);
	
	var new_br = document.createElement('br');
	document.getElementById('divpanneau').appendChild(new_br);
	
	var new_bri = document.createElement('br');
	document.getElementById('divpanneau').appendChild(new_bri);
	
	var new_a_input_create_account = document.createElement('a');
	new_a_input_create_account.id = "a_input_create_account";
	new_a_input_create_account.href = "#";
	new_a_input_create_account.innerHTML = "Ajouter le compte !";
	new_a_input_create_account.onclick = ajouter;
	document.getElementById('divpanneau').appendChild(new_a_input_create_account);
}

function signaler(id, type){
	if (window.XMLHttpRequest){var xhr = new XMLHttpRequest();}
	else{var xhr = new ActiveXObject("Microsoft.XMLHTTP");}
	xhr.open('POST', 'AJAX/signalement.php', false);
	xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xhr.send('type=' + type + '&id=' + id);
	alert(xhr.responseText);
}

function supprimer(id, type){
	if (window.XMLHttpRequest){var xhr = new XMLHttpRequest();}
	else{var xhr = new ActiveXObject("Microsoft.XMLHTTP");}
	xhr.open('POST', 'AJAX/suppression.php', false);
	xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xhr.send('type=' + type + '&id=' + id);
	alert(xhr.responseText);
	window.location.reload();
}

function ignorer(id, type){
	if (window.XMLHttpRequest){var xhr = new XMLHttpRequest();}
	else{var xhr = new ActiveXObject("Microsoft.XMLHTTP");}
	xhr.open('POST', 'AJAX/ignorer.php', false);
	xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xhr.send('type=' + type + '&id=' + id);
	alert(xhr.responseText);
	window.location.reload();
}

function ajouter(){
	if (window.XMLHttpRequest){var xhr = new XMLHttpRequest();}
	else{var xhr = new ActiveXObject("Microsoft.XMLHTTP");}
	xhr.open('POST', 'AJAX/ajout.php', false);
	xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	
	if(document.getElementById('a_input_news')){
		if(document.getElementById('input_actu').value){
			var important_checked = false;
			if(document.getElementById('input_warning_level')){
				important_checked=document.getElementById('input_warning_level').checked;
			}
			xhr.send('Actualite=' + document.getElementById('input_actu').value + '&important=' + important_checked);
			alert(xhr.responseText);
			supprimer_panneau();
			window.location.reload();
		}
		else{
			alert('Veuillez remplir tous les champs');
		}
	}
	else if(document.getElementById('input_comment')){
		if(document.getElementById('input_comment').value && document.getElementById('input_genre').value){
			var requete = 'Playlist0=' + url_videos[0];
			for (var i=1; i < 15; i++){
				requete += '&Playlist'+ i +'=' + url_videos[i];
			}
			requete += '&Titre_pl=' + document.getElementById('input_comment').value + '&Genre_pl=' + document.getElementById('input_genre').value;
			xhr.send(requete);
			alert(xhr.responseText);
			reset_url_videos();
			supprimer_panneau();
			window.location.reload();
		}
		else{
			alert('Veuillez remplir tous les champs');
		}
	}
	else if(document.getElementById('input_account_name')){
		if(document.getElementById('input_account_name').value && document.getElementById('input_account_pass').value && document.getElementById('input_account_repass').value && document.getElementById('input_select_autorisations').value){
			if(document.getElementById('input_account_pass').value == document.getElementById('input_account_repass').value){
				xhr.send('Compte=' + document.getElementById('input_account_name').value + '&mdp=' + document.getElementById('input_account_pass').value + '&autorisations=' + document.getElementById('input_select_autorisations').value);
				alert(xhr.responseText);
				supprimer_panneau();
			}
			else{
				alert('Mots de passe non identiques !');
			}
		}
		else{
			alert('Veuillez remplir tous les champs');
		}
	}
	else{
		alert('Erreur JS-A1 !');
	}
	
}

function modifier(cas){
	var cas = cas || 0;
	if (window.XMLHttpRequest){var xhr = new XMLHttpRequest();}
	else{var xhr = new ActiveXObject("Microsoft.XMLHTTP");}
	xhr.open('POST', 'AJAX/modification.php', false);
	xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	
	if(document.getElementById('pass') && cas == 1){
		if (document.getElementById('repass').value == document.getElementById('pass').value && document.getElementById('pass').value.length >= 5){
			xhr.send('User=' + document.getElementById('cmp_nm_util').innerHTML + '&mdp=' + document.getElementById('pass').value + '&remdp=' + document.getElementById('repass').value);
			alert(xhr.responseText);
			document.getElementById('repass').value = "";
			document.getElementById('pass').value = "";
		}
		else{
			alert("Les deux mots de passe ne contiennent pas 5 caracteres ou sont differents");
			document.getElementById('repass').value = "";
			document.getElementById('pass').value = "";
		}
	}
	else if(document.getElementById('autorisations_select') && cas == 2){
		xhr.send('User=' + document.getElementById('cmp_nm_util').innerHTML + '&autorisations=' + document.getElementById('autorisations_select').value);
		alert(xhr.responseText);
		window.location.reload();
	}
	else{
		alert('Erreur JS-M1 !');
	}
}

function connexion(){
	if (window.XMLHttpRequest){var xhrco = new XMLHttpRequest();}
	else{var xhrco = new ActiveXObject("Microsoft.XMLHTTP");}
	xhrco.open('POST', 'AJAX/connexion.php', false);
	xhrco.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xhrco.send('log=' + document.getElementById('log').value + '&mdp=' + document.getElementById('mdp').value);
	if(xhrco.responseText){alert(xhrco.responseText);}
	window.location.reload();
}

function deconnexion(){
	if (window.XMLHttpRequest){var xhrdeco = new XMLHttpRequest();}
	else{var xhrdeco = new ActiveXObject("Microsoft.XMLHTTP");}
	xhrdeco.open('POST', 'AJAX/deconnexion.php', false);
	xhrdeco.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xhrdeco.send();
	window.location.reload();
}

function reset_url_videos(){
	nb_video = 0;
	for (var i=0; i < 15; i++){
		url_videos[i] = "";
	}
}