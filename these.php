<?php
    $db = new mysqli('localhost', 'root', '', 'dataviz');
    if ($db->connect_error) {
        echo 'bad co';
        die("échec de la connexion à la base de données:".$conn->connect_error);
    }
    if (isset($_GET['idThese'])) {
        $recherche = $_GET['idThese'];
    } else {
        $recherche = 0;
    }
?>
<html lang="fr">
	<head>
        <link rel="icon" type="image/x-icon" href="Icon.png">
        <meta charset="UTF-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<link rel="stylesheet" href="these.css" />
		<title>
			Page principale
		</title>
	</head>
	<body>
        <div class="backgr">
            <div class ="a"></div>
            <div class ="b"></div>
        </div>
        <div class="coeur">
            <div class="milieu">
                <?php
                $result = $db->query("SELECT idThese, resumefr, resumeen, titrefr, titreen, dateSoutenance, nom FROM these t join etablissement e on t.codeEtab = e.codeEtab where idThese = $recherche;");
                if ($result && $result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    while ($row != NULL) {
                        if ($row['titrefr'] == "") {
                            echo '<div class="these-elem"><h2>'.$row['titreen'].'</h2>';
                        } else {
                            echo '<div class="these-elem"><h2>'.$row['titrefr'].'</h2>';
                        }
                        echo '
                            <div class="these-info">
                                <p class="auteur">Par mr Z</p>
                                <p class="directeur">Sous la direction de mme E</p>
                                <p class="universite">'.$row['nom'].'</p>
                            </div>
                            <div class="these-info">
                                <p class="date">Le '.$row['dateSoutenance'].'</p>';
                        if ($row['titrefr'] == "") {
                            echo '<p>'.$row['resumeen'].'</div>';
                        } else {
                            echo '<p>'.$row['resumefr'].'</div>';
                        }
                        echo '</div>';
                        $row = $result->fetch_assoc();
                    }
                } else {
                    echo "<h1>Il n'y a aucune thèse répondant à votre demande. </h1>";
                }
                ?>
            </div>
        </div>
    </body>
</html>