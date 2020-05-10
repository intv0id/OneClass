<Header>
<?php
	if ($_SESSION['connecte']){
		echo'<p><a href="index.php?page=Compte">'.$_SESSION['pseudo'].'</a><br/><a href="#" onclick="deconnexion();">Déconnexion</a></p>';
	}
?>
</Header>
