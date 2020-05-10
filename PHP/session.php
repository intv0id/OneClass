<?PHP
session_start();
try{//ouverture de la base de donn�es
	$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
	$host=getenv('DATABASE_HOST');
	$dbname=getenv('DATABASE_NAME');
	$username=getenv('DATABASE_USERNAME');
	$password=getenv('DATABASE_PASSWORD');
	$bdd = new PDO(
		'mysql:host='.$host.';dbname='.$dbname, 
		$username, 
		$password, 
		$pdo_options);
}
catch (Exception $e){die('Erreur : ' . $e->getMessage());}

if(!isset($_SESSION['pseudo']) OR !isset($_SESSION['connecte']) OR !isset($_SESSION['autorisations'])){//Si utilisateur non connect�
	$_SESSION['pseudo']=NULL;//remise � z�ro du pseudo
	$_SESSION['connecte']=FALSE;//utilisateur d�fini comme non-connect�
	$_SESSION['autorisations']='INVITE';//Sans autorisations
}
?>