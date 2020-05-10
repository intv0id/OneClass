<?PHP
include("../PHP/session.php");
if (!$_SESSION['connecte'] AND isset ($_POST['log']) AND isset ($_POST['mdp']) AND $_POST['log'] != NULL AND $_POST['mdp'] != NULL){//Connection
	try{
			$auth = $bdd->prepare('SELECT PASSWORD, AUTORISATIONS FROM utilisateurs WHERE BINARY LOGIN = ?');
			$auth->execute(array($_POST['log']));
			$mdp_s = $auth->fetch();
			$auth->closeCursor();
	}
	catch (Exception $e){die('Erreur : ' . $e->getMessage());}
	if (sha1($_POST['mdp']) == $mdp_s['PASSWORD']){	
		$_SESSION['connecte'] = true;
		$_SESSION['pseudo'] = $_POST['log'];
		$_SESSION['autorisations'] = $mdp_s['AUTORISATIONS'];
	}
	else{
		echo'Identifiant ou mot de passe incorrect !';
	}
}
else{
	echo'Identifiant ou mot de passe incorrect !';
}
?>