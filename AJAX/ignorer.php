<?PHP
	header('Content-type: text/xml');
	include("../PHP/session.php");
	if($_SESSION['connecte'] AND isset($_POST['type']) AND $_POST['type'] != NULL AND isset($_POST['id']) AND $_POST['id'] != NULL){
		if($_POST['type'] == "ACTU"){
			if($_SESSION['autorisations'] == "ADMIN" OR $_SESSION['autorisations'] == "PROF" OR $_SESSION['autorisations'] == "DELEGUE" OR $_SESSION['pseudo'] == $plii['AUTEUR']){
				try{
					$supprim = $bdd->prepare('DELETE FROM signalements WHERE IDN= :idsupp AND TYPE= :typesupp');
					$supprim->execute(array('idsupp' => $_POST['id'], 'typesupp' => 'News'));
				}
				catch (Exception $e){die('Erreur : ' . $e->getMessage());}
				echo'Signalement ignore !';
			}
			else{
				echo'Erreur 8';
			}
		}
		elseif($_POST['type'] == "PLAYLIST"){
			if($_SESSION['autorisations'] == "ADMIN" OR $_SESSION['autorisations'] == "PROF" OR $_SESSION['autorisations'] == "DELEGUE" OR $_SESSION['pseudo'] == $plii['AUTEUR']){
				try{
					$supprim = $bdd->prepare('DELETE FROM signalements WHERE IDN= :idsupp AND TYPE= :typesupp');
					$supprim->execute(array('idsupp' => $_POST['id'], 'typesupp' => 'Playlist'));
				}
				catch (Exception $e){die('Erreur : ' . $e->getMessage());}
				echo'Signalement ignore !';
			}
			else{
				echo'Erreur 8';
			}
		}
		else{
			echo'Erreur 3';
		}
	}
	else{
		echo'Erreur 7 : vous semblez ne pas etre connecte !';
	}
?>