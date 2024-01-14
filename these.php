<?php
    include 'fonction.php';
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
			Thèse <?php echo $recherche; ?>
		</title>
	</head>
	<body>
    <div class="backgr">
        <div class ="a">
            <div class ="ab">
                <a href="recherche.php"><img src="home.png" alt="homepage icon"></a>
            </div>
        </div>
        <div class ="b"></div>
    </div>
        <div class="coeur">
            <div class="milieu">
                <?php
                $result = $db->query("SELECT p.nom AS pnom, p.prenom AS pprenom, e.nom AS nom, t.idThese as idThese, d.idPeople, resumefr, resumeen, titrefr, titreen, dateSoutenance, t.codeEtab AS codeEtab FROM these t join etablissement e on t.codeEtab = e.codeEtab JOIN directeurs_theses d on d.idThese = t.idThese JOIN people p on p.idPeople = d.idPeople where t.idThese = $recherche;");
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
                                <p class="directeur"><a style="text-decoration:none; color:white;" href="auteur.php?idAuteur='.$row['idPeople'].'">Sous la direction de '.$row['pprenom'].' '.$row['pnom'].'</a></p>
                                <p class="universite"><a style="text-decoration: none; color:white;" href="uni.php?uni='.$row['codeEtab'].'">'.$row['nom'].'</a></p>
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
                        break;
                    }
                } else {
                    echo "<h1>Il n'y a aucune thèse répondant à votre demande. </h1>";
                }
                ?>
            </div>
        </div>
    </body>
</html>