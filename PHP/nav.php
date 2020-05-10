<Nav>
<noscript><a href="http://www.activatejavascript.org">Veuillez activer javascript !</a></noscript>
<?php
if ($_SESSION['connecte']){
	echo'<ul>';

	echo'<li ';
		if(!isset($_GET['page'])){
			echo'id="current"';
		}
		echo'><a href="./">Accueil</a></li>';

	echo'<li ';
		if(isset($_GET['page']) AND $_GET['page'] == "Actualites"){
			echo'id="current"';
		}
		echo'><a href="?page=Actualites">Actualités</a></li>';
		
	echo'<li ';
		if(isset($_GET['page']) AND $_GET['page'] == "Playlists"){
			echo'id="current"';
		}
		echo'><a href="?page=Playlists">Playlists</a></li>';
		
	/*echo'<li ';
		if(isset($_GET['page']) AND $_GET['page'] == "Liens"){
			echo'id="current"';
		}
		echo'><a href="?page=Liens">Liens</a></li>';*/
	
	if($_SESSION['autorisations'] == 'DELEGUE' OR $_SESSION['autorisations'] == 'PROF' OR $_SESSION['autorisations'] == 'ADMIN'){//Onglet_Signalements
		echo '<li ';
		if(isset($_GET['page']) AND $_GET['page'] == "Signalements"){
			echo'id="current"';
		}
		echo'><a href="?page=Signalements">Signalements'; 
		if(nb_signalements($bdd) > 0){
			echo' ('.nb_signalements($bdd).')';
		}
		echo'</a></li>';
	}

	echo'<li ';
		if(isset($_GET['page']) AND $_GET['page'] == "Compte"){
			echo'id="current"';
		}
		echo'><a ';
		if($_SESSION['autorisations'] == 'ADMIN'){
			echo'href="#" onclick="gestion_compte_admin();"';
		}
		else{
			echo'href="?page=Compte"';
		}
		echo'>Gestion du compte</a></li>';
		
	echo'</ul>';
}
?>
</Nav>