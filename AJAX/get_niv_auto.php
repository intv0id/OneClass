<?PHP
header('Content-type: text/xml');
include("../PHP/session.php");
if($_SESSION['connecte']){
	echo $_SESSION['autorisations'];
}
else{
	echo'Erreur PHP-GNA1 : vous semblez ne pas etre connecte !';
}
?>