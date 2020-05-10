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
			if(isset($newii['ID']) AND ($_SESSION['autorisations'] == "ADMIN" OR $_SESSION['autorisations'] == "PROF" OR $_SESSION['autorisations'] == "DELEGUE" OR $_SESSION['pseudo'] == $newii['AUTEUR'])){
				try{
					$suppri = $bdd->prepare('DELETE FROM news WHERE ID= :idnewsi');
					$suppri->execute(array('idnewsi' => $newii['ID']));
					$supprim = $bdd->prepare('DELETE FROM signalements WHERE IDN= :idsupp AND TYPE= :typesupp');
					$supprim->execute(array('idsupp' => $newii['ID'], 'typesupp' => 'News'));
				}
				catch (Exception $e){die('Erreur : ' . $e->getMessage());}
				echo'Article supprime !';
			}
			else{
				echo'Erreur PHP-S1';
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
			if(isset($plii['ID']) AND ($_SESSION['autorisations'] == "ADMIN" OR $_SESSION['autorisations'] == "PROF" OR $_SESSION['autorisations'] == "DELEGUE" OR $_SESSION['pseudo'] == $plii['AUTEUR'])){
				try{
					$suppri = $bdd->prepare('DELETE FROM playlists WHERE ID= :idpli');
					$suppri->execute(array('idpli' => $plii['ID']));
					$supprim = $bdd->prepare('DELETE FROM signalements WHERE IDN= :idsupp AND TYPE= :typesupp');
					$supprim->execute(array('idsupp' => $plii['ID'], 'typesupp' => 'Playlist'));
				}
				catch (Exception $e){die('Erreur : ' . $e->getMessage());}
				echo'Playlist supprimee !';
			}
			else{
				echo'Erreur PHP-S2';
			}
			$pli->closeCursor();
		}
		elseif($_POST['type'] == "COMPTE" AND  $_SESSION['autorisations'] == 'ADMIN'){
			try{
				$cpti = $bdd->prepare('SELECT * FROM utilisateurs WHERE ID= ?');
				$cpti->execute(array($_POST['id']));
				$cptii = $cpti->fetch();
			}
			catch (Exception $e){die('Erreur : ' . $e->getMessage());}
			if(isset($cptii['ID'])){
				try{
					$suppri = $bdd->prepare('DELETE FROM playlists WHERE AUTEUR= :auteur');
					$suppri->execute(array('auteur' => $cptii['LOGIN']));
					$supprim = $bdd->prepare('DELETE FROM news WHERE AUTEUR= :auteur');
					$supprim->execute(array('auteur' => $cptii['LOGIN']));
					$supprime = $bdd->prepare('DELETE FROM utilisateurs WHERE ID= :id');
					$supprime->execute(array('id' => $cptii['ID']));
				}
				catch (Exception $e){die('Erreur : ' . $e->getMessage());}
				echo'Compte supprime !';
			}
			else{
				echo'Erreur PHP-S2';
			}
			$cpti->closeCursor();
		}
		else{
			echo'Erreur PHP-S3';
		}
	}
	else{
		echo'Erreur PHP-S4 : vous semblez ne pas etre connecte !';
	}
?>