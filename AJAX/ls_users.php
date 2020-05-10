<?PHP
header('Content-type: text/xml');
include("../PHP/session.php");
echo '<?xml version="1.0" encoding="utf-8"?>';
if($_SESSION['autorisations'] == 'ADMIN'){
	try{$Users = $bdd->query('SELECT LOGIN, ID FROM utilisateurs');	}
	catch (Exception $e){die('Erreur : ' . $e->getMessage());}
	while ($Utilisateurs = $Users->fetch()){
		echo '<utilisateurs>';
		echo '<id>'.$Utilisateurs['ID'].'</id>';
		echo '<login>'.$Utilisateurs['LOGIN'].'</login>';
		echo '</utilisateurs>';
	}
}
?>