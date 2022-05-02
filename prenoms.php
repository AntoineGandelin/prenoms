<!DOCTYPE html>
<html>
	<head>
		<title>Prenoms</title>
		<meta http-equiv="content-type" content="text/html; charset=UTF-8">
		<meta http-equiv="content-type" content="application/xhtml+xml; charset=UTF-8">
		<meta http-equiv="content-style-type" content="text/css">
		<meta http-equiv="expires" content="0">
		<link href="prenoms.css" rel="stylesheet" type="text/css">
	</head>
	<body>
		<h1>Fichier des prénoms de 1900 à 2019</h1>
		<br>
		<button onclick="window.location.href='https://www.data.gouv.fr/fr/datasets/fichier-des-prenoms-de-1900-a-2019/'">Source des donnees</button>
		<br>
		<button onclick="window.location.href='mailto:antoine.gdln@laposte.net'">Me contacter</button>
		<br>
		<br>
        <form action="prenoms.php" method="get">
			<input type="text" name="mot">
			<input type="submit" value="Envoyer">
		</form>
		<?php
            if(isset($_GET['mot']))
                {
                // Mot à chercher
				$cherche = strtoupper($_GET['mot']);
				// Affichage de l'entête du tableau résultat			
				echo '<table border="1">';
				echo '<tr>';
					echo '<th>Sexe</th>';
					echo '<th>Prenom Usuel</th>';
					echo '<th>Annee de Naissance</th>';
					echo '<th>Departement</th>';
                    echo '<th>Nombre</th>';
				echo '</tr>';
				
				// connexion à la base
				$conn = pg_connect('host=127.0.0.1 dbname=prenoms user=prenoms_admin password=admin');
				if(!isset($_GET['offset']))
					{
				// construction de la requête (on ne gère pas la sécurité)
				$string_req = "select count(*) from prenom where prenom.preusuel like '%".$cherche."%'";
				// Envoi de la requête au système de gestion de bases de données
				$req = pg_query($string_req);
                // Récupération de la  première colonne de la première ligne
				$taille = pg_fetch_row($req)[0];
                // Première utilisation de l'offset, celui-ci vaudra 0
				$off=0;
					}
				else 
					{
					// Il y a déjà un offset, on le récupère 
					$off = $_GET['offset'];
					// La taille est passée en paramètre pour éviter de lancer la requête
					// de calcul à chaque apple de la page. 
					$taille = $_GET['taille']; 
					}
                    $string_req = "select sexe, preusuel, annais, dpt, nombre from prenom where prenom.preusuel like '%".$cherche."%'";
                    // On modifie la requête pour tenir compte de l'offset
                    $string_req .= ' offset '.$off.' limit 20'; 
                    $req = pg_query($string_req);
                    $tab = pg_fetch_assoc($req);
                    // Pour permettre la numérotation des lignes
                    $inc = 1;
                    while($tab)
                        {
                        echo '<tr>';
                            echo '<td>'.($off+$inc++).'</td>';
                            echo '<td>'.$tab['sexe'].'</td>';
                            echo '<td>'.$tab['preusuel'].'</td>';
                            echo '<td>'.$tab['annais'].'</td>';
                            echo '<td>'.$tab['dpt'].'</td>';
                            echo '<td>'.$tab['nombre'].'</td>';
                        echo '</tr>';
                        $tab = pg_fetch_assoc($req);
                        }
                    pg_close($conn);
                    echo "</table>\n";
                    // Zone de déplacement dans les enregistrements
    
                    // affichage des pages
                    for($i=0; $i<=$taille; $i=$i+20)
                        {
                        $string_page = 'prenoms.php?mot='.$cherche.'&offset='.$i.'&taille='.$taille;
                        echo '&nbsp;<a href="'.$string_page.'">'.(int)($i/20).'</a>&nbsp;';
                        }
                }
		?>
	</body>
</html>