<?PHP
	header('Content-type: text/xml');
	include("../PHP/session.php");
	
	if($_SESSION['connecte'] AND isset($_POST['type']) AND $_POST['type'] != NULL AND isset($_POST['id']) AND $_POST['id'] != NULL){
		if($_POST['type'] == "ACTU"){
			try{
				$newi = $bdd->prepare('SELECT * FROM news WHERE ID= ?');
				$newi->execute(array($_POST['id']));
				$newii = $newi->fetch();
			}
			catch (Exception $e){die('Erreur : ' . $e->getMessage());}
			if(isset($newii['ID']) AND ($_SESSION['autorisations'] == "ELEVE" AND $_SESSION['pseudo'] != $newii['AUTEUR'])){
				try{
					$ajout = $bdd->prepare('INSERT INTO signalements(AUTEUR, TYPE, IDN) VALUES(:auteur, :type, :idn)');
					$ajout->execute(array('auteur' => $_SESSION['pseudo'], 'type' => 'News', 'idn' => $_POST['id']));
				}
				catch (Exception $e){die('Erreur : ' . $e->getMessage());}
				echo'Article signale !';
			}
			else{
				echo'Erreur 4';
			}
			$newi->closeCursor();
		}
		elseif($_POST['type'] == "PLAYLIST"){
			try{
				$pli = $bdd->prepare('SELECT * FROM playlists WHERE ID= ?');
				$pli->execute(array($_POST['id']));
				$plii = $pli->fetch();
			}
			catch (Exception $e){die('Erreur : ' . $e->getMessage());}
			if(isset($plii['ID']) AND ($_SESSION['autorisations'] == "ELEVE" AND $_SESSION['pseudo'] != $plii['AUTEUR'])){
				try{
					$ajout = $bdd->prepare('INSERT INTO signalements(AUTEUR, TYPE, IDN) VALUES(:auteur, :type, :idn)');
					$ajout->execute(array('auteur' => $_SESSION['pseudo'], 'type' => 'Playlist', 'idn' => $_POST['id']));
				}
				catch (Exception $e){die('Erreur : ' . $e->getMessage());}
				echo'Playlist signalee !';
			}
			else{
				echo'Erreur 4';
			}
			$pli->closeCursor();
		}
		else{
			echo'Erreur 3';
		}
	}
	else{
		echo'Erreur 2 : vous semblez ne pas etre connecte !';
	}
?>