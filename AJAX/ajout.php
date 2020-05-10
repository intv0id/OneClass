<?PHP
header('Content-type: text/xml');
include("../PHP/session.php");
if($_SESSION['connecte'] AND isset($_POST['Actualite']) AND $_POST['Actualite'] != NULL AND isset($_POST['important'])) //Post d'actualités
{
	try{$ajout = $bdd->prepare('INSERT INTO news(AUTEUR, IMPORTANT, TEXTE, DATE) VALUES(:auteur, :important, :texte, :date)');}
	catch (Exception $e){die('Erreur : ' . $e->getMessage());}

	if($_POST['important'] == 'true' AND ($_SESSION['autorisations'] == "ADMIN" OR $_SESSION['autorisations'] == "PROF" OR $_SESSION['autorisations'] == "DELEGUE")){
		try{$ajout->execute(array('auteur' => $_SESSION['pseudo'], 'important' => 1, 'texte' => $_POST['Actualite'], 'date' => date("Y-m-d")));}
		catch (Exception $e){die('Erreur : ' . $e->getMessage());}
		echo'Article publie !';
	}
	else{
		try{$ajout->execute(array('auteur' => $_SESSION['pseudo'], 'important' => 0, 'texte' => $_POST['Actualite'], 'date' => date("Y-m-d")));}
		catch (Exception $e){die('Erreur : ' . $e->getMessage());}
		echo'Article publie !';
	}
}
elseif($_SESSION['connecte'] AND isset($_POST['Playlist0']) AND $_POST['Playlist0'] != NULL AND isset($_POST['Titre_pl']) AND $_POST['Titre_pl'] != NULL AND isset($_POST['Genre_pl']) AND $_POST['Genre_pl'] != NULL){
	try{
		$prep = "";
		$prep .= "INSERT INTO playlists(AUTEUR, DATE, ";
		for ($i = 0; $i<15; $i ++){
			$prep .= 'URL';
			$prep .= ($i+1);
			$prep .= ', ';
		}
		$prep .= 'TITRE, GENRE) VALUES(:auteur, :date, ';
		for ($i = 0; $i<15; $i ++){
			$prep .= ':url'.$i.', ';
		}
		$prep .= ':titre, :genre)';
		
		$exearray = array();
		$exearray['auteur'] = $_SESSION['pseudo'];
		$exearray['date'] =  date("Y-m-d");
		for ($i = 0; $i<15; $i ++){
			$exearray['url'.$i] = $_POST['Playlist'.$i];
		}
		$exearray['titre'] = $_POST['Titre_pl'];
		$exearray['genre'] = $_POST['Genre_pl'];
		
		$ajout = $bdd->prepare($prep);
		$ajout->execute($exearray);
	}
	catch (Exception $e){die('Erreur : ' . $e->getMessage());}
	echo 'Playlist publiee !';
}
elseif($_SESSION['connecte'] AND isset($_POST['Compte']) AND $_POST['Compte'] != NULL AND isset($_POST['mdp']) AND $_POST['mdp'] != NULL AND isset($_POST['autorisations']) AND $_POST['autorisations'] != NULL){
	try{
		try{
			$ajout = $bdd->prepare('INSERT INTO utilisateurs(LOGIN, PASSWORD, AUTORISATIONS) VALUES(:login, :password, :autorisations)');
			$ajout->execute(array('login' => $_POST['Compte'], 'password' => sha1($_POST['mdp']), 'autorisations' => $_POST['autorisations']));
		}
		catch (Exception $e){die('Erreur : ' . $e->getMessage());}
	}
	catch (Exception $e){die('Erreur : ' . $e->getMessage());}
	echo 'Compte ajoute !';
}
else{echo'erreur PHP-A1';}
?>