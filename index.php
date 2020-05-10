<?PHP
	include("PHP/session.php");
	include("PHP/fonctions.php");
	include("PHP/head.php");
	echo'<body>';//Début de body
	include("PHP/header.php");
	include("PHP/nav.php");
	echo'<div id="corps">';//Début de div
	if ($_SESSION['connecte']){ //Si l'utilisateur est connecté
		if(!isset($_GET['page']) OR ($_GET['page'] != "Actualites" AND $_GET['page'] != "Playlists" AND $_GET['page'] != "Liens" AND $_GET['page'] != "Validation" AND $_GET['page'] != "Signalements" AND $_GET['page'] != "Compte")){
			echo'<div id="News">';//Début de div
			echo'<h2>Nouveaut&eacute;s :</h2>';
			echo'<div id="articles_acc">';
			echo'<h2>Articles :</h2>';
			echo'<article>';
			afficher_news_normal(1, $_SESSION['autorisations'], $_SESSION['pseudo'], $bdd);//News importantes
			echo'</article>';
			echo'<article>';
			afficher_news_normal(2, $_SESSION['autorisations'], $_SESSION['pseudo'], $bdd);//News secondaires
			echo'</article>';
			echo'</div>';
			echo'<div id="playlists_acc">';
			echo'<h2>Playlists :</h2>';
			echo'<article>';
			afficher_liste_playlist(2, $bdd, $_SESSION['autorisations'], $_SESSION['pseudo']);
			echo'</article>';
			echo'</div>';
			echo'</div>';//Fin de div
		}
		elseif (isset($_GET['page']) AND $_GET['page'] == "Actualites"){
			afficher_news_normal(3, $_SESSION['autorisations'], $_SESSION['pseudo'], $bdd);
		}
		elseif (isset($_GET['page']) AND $_GET['page'] == "Playlists"){
			if (isset($_GET['action']) AND $_GET['action'] == "Ecouter" AND isset($_GET['id']) AND preg_match("#^[0-9]{1,}$#", $_GET['id'])){
				afficher_playlist($_GET['id'], $bdd, $_SESSION['pseudo'], $_SESSION['autorisations']);
			}
			else{
				afficher_liste_playlist(1, $bdd, $_SESSION['autorisations'], $_SESSION['pseudo']);
			}
		}
		elseif (isset($_GET['page']) AND $_GET['page'] == "Liens"){
			
		}
		elseif (isset($_GET['page']) AND $_GET['page'] == "Signalements" AND ($_SESSION['autorisations'] == 'ADMIN' OR $_SESSION['autorisations'] == 'DELEGUE' OR $_SESSION['autorisations'] == 'PROF')){
			afficher_signalements($bdd);
		}
		elseif (isset($_GET['page']) AND $_GET['page'] == "Compte"){
			afficher_infos_compte($_SESSION['autorisations'], $_SESSION['pseudo'], $bdd);
		}
		else{
			echo'<p>Cette page n\'existe pas ou plus !</p>';
		}
	}
	else{//Si l'utilisateur n'est pas connecté
		echo'<div id="ConnectPanel">';
		echo '<p>Connectez vous :</p>';
		echo '<input type="text" id="log" name="log" placeholder="Identifiant" required/><input type="password" id="mdp" name="mdp" placeholder="Mot de passe" required/><input type="submit" value="Se connecter" onclick = "connexion();"/>';
		echo'</div>';
	}
	echo'</div>';//Fin de div
	include("PHP/footer.php");//Pied de page
	echo'</body>';//Fin de body
?>