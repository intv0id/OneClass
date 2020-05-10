<?php
/*--------------------------------------------------------------------------------------------------------------------------------------


																FONCTIONS


--------------------------------------------------------------------------------------------------------------------------------------*/

function datefr($date) { //Transformation de la date sous le format français
	date_default_timezone_set('EUROPE/Paris');
	return date("d/m/Y", strtotime($date));
}

function nb_signalements($bdd){//Nombre de signalements en attente
	$nb_signal = 0;
	try{$Signalements = $bdd->query('SELECT * FROM signalements');}
	catch (Exception $e){die('Erreur : ' . $e->getMessage());}
	while ($NSignalees = $Signalements->fetch()){$nb_signal++;}
	$Signalements->closeCursor();
	return $nb_signal;
}

function afficher_news_normal($cas, $autorisations_compte, $pseudo, $bdd){ //Affichage de news
	if($cas == 1)
	{
		try{$news = $bdd->query('SELECT * FROM news WHERE IMPORTANT = true ORDER BY ID DESC LIMIT 0, 5');}
		catch (Exception $e){die('Erreur : ' . $e->getMessage());}
	}
	elseif($cas == 2)
	{
		try{$news = $bdd->query('SELECT * FROM news WHERE IMPORTANT = false ORDER BY ID DESC LIMIT 0, 5');}
		catch (Exception $e){die('Erreur : ' . $e->getMessage());}
	}
	elseif($cas == 3)
	{
		echo '<p><a href="#" onclick="creer_actu();" class="Ajout"><strong>Ajouter une actualité !</strong></a></p><br/><br/>';
		try{$news = $bdd->query('SELECT * FROM news ORDER BY ID DESC');}
		catch (Exception $e){die('Erreur : ' . $e->getMessage());}
	}
	elseif($cas == 4)
	{
		try{
			$news = $bdd->prepare('SELECT * FROM news WHERE AUTEUR= ? ORDER BY ID DESC');
			$news->execute(array($pseudo));
		}
		catch (Exception $e){die('Erreur : ' . $e->getMessage());}
	}

	while ($infos = $news->fetch())
	{
		echo '<p ';
		if($infos['IMPORTANT'] == true){echo' class="Important"';}
		echo' >';
		echo'Publié le <strong>'. datefr(htmlspecialchars($infos['DATE'])) . '</strong> : <br/>'; //Date		
		echo '<em>'.htmlspecialchars($infos['TEXTE']) . '</em><br/>';
		echo 'Par <strong>' . htmlspecialchars($infos['AUTEUR']) .'</strong>';//Auteur
		if($autorisations_compte == "ADMIN" OR $autorisations_compte == "PROF" OR $autorisations_compte == "DELEGUE" OR $infos['AUTEUR'] == $pseudo){
			echo'<a href="#" onclick="supprimer('.$infos['ID'].', \'ACTU\');" class="Suppression" title="Supprimer cette actualité">Supprimer</a><br/><br/>';
		}
		elseif($autorisations_compte == 'ELEVE'){
			echo'<a href="#" onclick="signaler('.$infos['ID'].', \'ACTU\');" class="Signalement" title="Signaler cette actualité">Signaler</a><br/><br/>';
		}
		echo '</p>';//Fin de p
	}
	$news->closeCursor();
}

function afficher_liste_playlist($cas, $bdd, $autorisations_compte, $pseudo){
	if($cas == 1){
		try{$lsplaylists = $bdd->query('SELECT * FROM playlists ORDER BY ID DESC');}
		catch (Exception $e){die('Erreur : ' . $e->getMessage());}
		echo '<a href="#" onclick="creer_playlist();" class="Ajout"><strong>Créer une playlist !</strong></a><br/><br/>';
	}
	elseif($cas == 2){
		try{$lsplaylists = $bdd->query('SELECT * FROM playlists ORDER BY ID DESC LIMIT 0, 5');}
		catch (Exception $e){die('Erreur : ' . $e->getMessage());}
	}
	elseif($cas == 3){
		try{
			$lsplaylists = $bdd->prepare('SELECT * FROM playlists WHERE AUTEUR= ? ORDER BY ID DESC');
			$lsplaylists->execute(array($pseudo));
		}
		catch (Exception $e){die('Erreur : ' . $e->getMessage());}
	}
	
	while ($ls = $lsplaylists->fetch()){
		echo '<p>';
		echo '<a href="?page=Playlists&action=Ecouter&id='.$ls['ID'].'">' . htmlspecialchars($ls['GENRE']).' par '.htmlspecialchars($ls['AUTEUR']).' le '.datefr(htmlspecialchars($ls['DATE'])).' </a>';
		if($cas == 2 OR $cas == 3){echo'<br/>';}
		if($autorisations_compte == "ADMIN" OR $autorisations_compte == "PROF" OR $autorisations_compte == "DELEGUE" OR $ls['AUTEUR'] == $pseudo){
			echo'<a href="#" onclick="supprimer('.$ls['ID'].', \'PLAYLIST\');" class="Suppression" title="Supprimer cette playlist">Supprimer</a><br/><br/>';
		}
		elseif($autorisations_compte == 'ELEVE'){
			echo'<a href="#" onclick="signaler('.$ls['ID'].', \'PLAYLIST\');" class="Signalement" title="Signaler cette playlist">Signaler</a><br/><br/>';
		}
		echo '</p>';//Fin de p
	}
	
}

function afficher_playlist($id, $bdd, $pseudo, $autorisations_compte){
	try{
	$playlists = $bdd->PREPARE('SELECT * FROM playlists WHERE ID= ?');
	$playlists->execute(array($id));
	}
	catch (Exception $e){die('Erreur : ' . $e->getMessage());}
	$pl = $playlists->fetch();
	if ($pl['ID'] == NULL) {echo'<p> Cette playlist n\'existe pas ou plus !';}
	else{
		echo '<p id="Presentation">';
		echo'Publiée le <strong>'. datefr(htmlspecialchars($pl['DATE'])) . '</strong> par <strong>' . htmlspecialchars($pl['AUTEUR']) .' </strong><br/>'; //Date		
		echo 'Commentaire de l\'auteur : '.'<br/>';
		echo '<em>'.htmlspecialchars($pl['TITRE']) . '</em><br/>';
		echo 'Genre : <strong>'. htmlspecialchars($pl['GENRE']) . '</strong><br/>';
		echo '<a href="#" onclick="lumiere();" class="Light">Lumière !</a>';
		if($autorisations_compte == "ADMIN" OR $autorisations_compte == "PROF" OR $autorisations_compte == "DELEGUE" OR $pl['AUTEUR'] == $pseudo){
			echo'<a href="#" onclick="supprimer('.$pl['ID'].', \'PLAYLIST\');" class="Suppression" title="Supprimer cette playlist">Supprimer</a><br/>';
		}
		elseif($autorisations_compte == 'ELEVE'){
			echo'<a href="#" onclick="signaler('.$pl['ID'].', \'PLAYLIST\');" class="Signalement" title="Signaler cette playlist">Signaler</a><br/>';
		}
		echo '</p>';//Fin de p
		
		echo'<div id="Videos">';
		for($i = 0; $i<15; $i++){
			if(isset($pl['URL'.($i+1)]) AND $pl['URL'.($i+1)] != ""){
				echo '<iframe width="420" height="315" src="http://www.youtube.com/embed/'.htmlspecialchars($pl['URL'.($i+1)]).'?wmode=transparent" frameborder="0" allowfullscreen></iframe><br/>';
			}
		}
		echo'</div>';
	}
	$playlists->closeCursor();
}

function afficher_signalements($bdd){ //Affichage de news
	try
	{
		$Signalements = $bdd->query('SELECT * FROM signalements ORDER BY ID DESC');
	}
	catch (Exception $e){die('Erreur : ' . $e->getMessage());}
	while ($Signalees = $Signalements->fetch())
	{
		try
		{
			if ($Signalees['TYPE'] == 'News'){//signalement de news
				$new = $bdd->prepare('SELECT * FROM news WHERE ID= ?');
				$new->execute(array($Signalees['IDN']));
				$newsutilisateur = $new->fetch();
				if (!isset($newsutilisateur['ID']) OR $newsutilisateur['ID'] == NULL){//suppression des signalements d'actualités supprimées
					$suppr = $bdd->prepare('DELETE FROM signalements WHERE ID= :idnews');
					$suppr->execute(array('idnews' => $Signalees['IDN']));
				}
				else{//Affichage du signalement
					echo '<div class="signal">';
					echo'<p>Article signalé par <strong>'.$Signalees['AUTEUR'].'</strong> :</p><br/>';
					echo'Publié le <strong>'. datefr(htmlspecialchars($newsutilisateur['DATE'])) . '</strong> : <br/>'; //Date
					echo htmlspecialchars($newsutilisateur['TEXTE']) . '<br/>';
					echo 'Par <strong>' . htmlspecialchars($newsutilisateur['AUTEUR']) .'</strong>';//Auteur
					echo '</p>';//Fin de p
					echo'<a href="#" onclick="supprimer('.$newsutilisateur['ID'].', \'ACTU\');" class="Suppression" title="Supprimer cet article">Supprimer</a>';
					echo'<a href="#" onclick="ignorer('.$newsutilisateur['ID'].', \'ACTU\');" class="Ajout" title="Ignorer ce signalement">Ignorer</a><br/><br/>';
					echo '<div>';
				}
				$new->closeCursor();
			}
			
			elseif ($Signalees['TYPE'] == 'Playlist'){//signalement de playlist
				$playlist = $bdd->prepare('SELECT * FROM playlists WHERE ID= ?');
				$playlist->execute(array($Signalees['IDN']));
				$playlistutilisateur = $playlist->fetch();
				if (!isset($playlistutilisateur['ID']) OR $playlistutilisateur['ID'] == NULL){//suppression des signalements d'actualités supprimées
					$suppr = $bdd->prepare('DELETE FROM signalements WHERE ID= :idnews');
					$suppr->execute(array('idnews' => $Signalees['IDN']));
				}
				else{//Affichage du signalement
					echo '<div class="signal">';
					echo '<p>Playlist signalée par <strong>'.$Signalees['AUTEUR'].'</strong> :</p><br/>';
					echo 'Publiée le <strong>'. datefr(htmlspecialchars($playlistutilisateur['DATE'])) . '</strong> : <br/>'; //Date
					echo '<a href="?page=Playlists&action=Ecouter&id='.$playlistutilisateur['ID'].'">'.htmlspecialchars($playlistutilisateur['TITRE']) . '</a><br/>';
					echo 'Par <strong>' . htmlspecialchars($playlistutilisateur['AUTEUR']) .'</strong>';//Auteur
					echo '</p>';//Fin de p
					echo'<a href="#" onclick="supprimer('.$playlistutilisateur['ID'].', \'PLAYLIST\');" class="Suppression" title="Supprimer cet article">Supprimer</a>';
					echo'<a href="#" onclick="ignorer('.$playlistutilisateur['ID'].', \'PLAYLIST\');" class="Ajout" title="Ignorer ce signalement">Ignorer</a><br/><br/>';
					echo '</div>';
				}
				$playlist->closeCursor();
			}
		}
		catch (Exception $e){die('Erreur : ' . $e->getMessage());}
		
		
	}
	$Signalements->closeCursor();
			
}

function afficher_infos_compte($autorisations_compte, $pseudo, $bdd) {//Affichage du compte
	if($autorisations_compte == 'ADMIN' && isset($_GET['id']))
	{
		try{
			$InfosUser = $bdd->prepare('SELECT ID, LOGIN, AUTORISATIONS FROM utilisateurs WHERE ID = ?');
			$InfosUser->execute(array($_GET['id']));
			$Parametres = $InfosUser->fetch();
		}
		catch (Exception $e){die('Erreur : ' . $e->getMessage());}
		$UEC = $Parametres['LOGIN'];		
	}
	else{
		$UEC = $pseudo;
	}
	if($UEC){
		echo'<p id="cmp_nm_util">'.$UEC.'</p>';
		echo'<div id="gestion_compte">';
		echo'<h2> Modification des données</h2>';
		echo'<label for="pass">Nouveau mot de passe : </label>';
		echo'<input type="password" name="pass" id="pass" />';
		echo'<br/>';
		echo'<label for="repass">Nouveau mot de passe (2) : </label>';
		echo'<input type="password" name="repass" id="repass" />'; 
		echo'<br/>';
		echo'<input type="submit" value="Valider" onclick="modifier(1);"/>';
		if($autorisations_compte == 'ADMIN' AND $UEC != $pseudo){
			echo'<br/>';
			echo'<br/>';
			echo '<label for="autorisations_select">Niveau d\'autorisation (actuellement : "'.htmlspecialchars($Parametres['AUTORISATIONS']).'" ) : </label>';
			echo '<select name="autorisations_select" id="autorisations_select" onchange="modifier(2);" ><optgroup label="'.htmlspecialchars($Parametres['AUTORISATIONS']).'">';
			echo '<option></option><option value="ELEVE">ELEVE</option><option value="PROF">PROF</option><option value="DELEGUE">DELEGUE</option><option value="ADMIN">ADMIN</option></optgroup></select>';
			echo'<br/>';
			echo'<a href="#" onclick="supprimer('.$Parametres['ID'].', \'COMPTE\');" class="Suppression">Supprimer</a>';
		}
		echo'</div>';
		echo'<div id="publications_compte">';
		echo'<h2> Publications</h2>';
		echo'<table>';
		echo'<tr>';
		echo'<th> Articles</th><th> Playlists</th>';
		echo'</tr>';
		echo'<tr>';
		echo'<td>';
		afficher_news_normal(4, $autorisations_compte, $UEC, $bdd);
		echo'</td>';
		echo'<td>';
		afficher_liste_playlist(3, $bdd, $autorisations_compte, $UEC);
		echo'</td>';
		echo'</tr>';
		echo'</table>';
		echo'</div>';
	}
	else{
		echo'<p>Ce compte n\'existe pas ou plus !</p>';
	}
}

?>
