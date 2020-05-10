<?PHP
	header('Content-type: text/xml');
	include("../PHP/session.php");
	if($_SESSION['connecte'] AND isset($_POST['User']) AND isset($_POST['mdp']) AND $_POST['mdp'] != NULL AND isset($_POST['remdp']) AND $_POST['remdp'] != NULL){
		if($_SESSION['autorisations'] == "ADMIN" OR $_SESSION['pseudo'] == $_POST['User']){
			if($_POST['mdp'] == $_POST['remdp'] AND strlen($_POST['mdp']) >= 5){
				try{
					$req = $bdd->prepare('UPDATE utilisateurs SET PASSWORD = :nvmdp WHERE LOGIN = :ilog');
					$req->execute(array('nvmdp' => sha1($_POST['mdp']), 'ilog' => $_POST['User']));
					$req->closeCursor();
				}
				catch (Exception $e){die('Erreur : ' . $e->getMessage());}
				echo 'Mot de passe modifie !';
			}
			else{
				echo 'Mots de passe non identique ou contenant moins de 5 caracteres !';
			}
		}
		else{
			echo'Erreur : PHP-M1';
		}
	}
	elseif($_SESSION['connecte'] AND $_SESSION['autorisations'] == "ADMIN" AND isset($_POST['User']) AND isset($_POST['autorisations']) AND $_POST['autorisations'] != NULL){
			if($_POST['autorisations'] == "ELEVE" OR $_POST['autorisations'] == "DELEGUE" OR $_POST['autorisations'] == "PROF" OR $_POST['autorisations'] == "ADMIN"){
				try{
					$req = $bdd->prepare('UPDATE utilisateurs SET AUTORISATIONS = :nvauto WHERE LOGIN = :ilog');
					$req->execute(array('nvauto' => $_POST['autorisations'], 'ilog' => $_POST['User']));
					$req->closeCursor();
				}
				catch (Exception $e){die('Erreur : ' . $e->getMessage());}
				echo 'Niveau d\autorisation modifie !';
			}
			else{
				echo 'Erreur PHP-M3';
			}
	}
	else{
		echo'Erreur PHP-M2 : vous semblez ne pas etre connecte !';
	}
?>