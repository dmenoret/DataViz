<?php
    $db = new mysqli('localhost', 'root', '', 'dataviz');
    if ($db->connect_error) {
        echo 'bad co';
        die("échec de la connexion à la base de données:".$conn->connect_error);
    }
    if (isset($_GET['these'])) {
        $recherche = '%'.str_replace(" ","",$_GET['these']).'%';
    } else {
        $recherche = '%%';
    } if (isset($_GET['limiteelem'])) {
        $limit = $_GET['limiteelem'];
    } else {
        $limit = 500;
    } if (isset($_GET['page'])) {
        $page = $_GET['page'];
    } else {
        $page = 1;
    }
    $ld = (($page-1)*$limit);
    $lf = (($page)*$limit);
    $limits = [25, 100, 200, 500];
    $lim = $db->query("SELECT count(*) as numResult from these where titrefr like '$recherche' or titreen like'$recherche'");
    $numResult = $lim->fetch_assoc()['numResult'];
    $discip = $db->query("SELECT domaine, COUNT(*) as times FROM discipline d JOIN these t ON d.iddiscipline = t.idDiscipline GROUP by domaine ORDER BY times DESC limit 10;");
?>
<html lang="fr">
	<head>
        <link rel="icon" type="image/x-icon" href="Icon.png">
        <meta charset="UTF-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<link rel="stylesheet" href="Theses.css" />
		<title>
			Page principale
		</title>
	</head>
	<body>
        <form method="GET" action ="index.php">
            <div class="tete">
                <input type="text" class="navbar" placeholder="Entrez des mots clés" value="
                <?php if (isset($_GET['these'])) { echo str_replace(" ","",$_GET['these']);}?>" name="these">
                <br>
                <div>
                <?php
                    echo "affichage de ".$ld." à ".$lf." sur ".$numResult." éléments.";
                ?>
                </div>
            </div>
            <br>
            <div class="coeur">
                <div class="gauche">
                    <button class ="sub" type="submit">Rechercher</button>
                    <div>
                        <?php
                            if ($discip && $discip->num_rows > 0) {
                                $disc = $discip->fetch_assoc();
                                while ($disc != NULL) {
                                    echo "<div><input class='radio' type='radio' id='huey' name='drone' value='huey' />
                                    <label for='huey'>".$disc['domaine']."</label></div>";
                                    $disc = $discip->fetch_assoc();
                                }
                            }
                        ?>
                    </div>
                </div>
                <div class="milieu">
                    <?php
                    $result = $db->query("SELECT idThese, titrefr, titreen, dateSoutenance, nom FROM these t join etablissement e on t.codeEtab = e.codeEtab where titrefr like '$recherche' or titreen like '$recherche' limit $ld, $lf;");
                    if ($result && $result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        $inc = 0;
                        while ($row != NULL && $inc < $limit) {  
                            $inc += 1;
                            echo $inc;
                            if ($row['titrefr'] == "") {
                                echo '<a href="these.php?idThese='.$row['idThese'].'"><div class="these-elem"><h2>'.$row['titreen'].'</h2>';
                            } else {
                                echo '<a href="these.php?idThese='.$row['idThese'].'"><div class="these-elem"><h2>'.$row['titrefr'].'</h2>';
                            }
                            echo '
                                <div class="these-info">
                                    <p class="auteur">Par mr Z</p>
                                    <p class="directeur">Sous la direction de mme E</p>
                                    <p class="universite">'.$row['nom'].'</p>
                                </div>
                                <div class="these-info">
                                    <p class="date">Le '.$row['dateSoutenance'].'</p>
                                </div>';
                            echo '</div></a>';
                            $row = $result->fetch_assoc();
                        }
                    }
                    ?>
                </div>
                <div class="droite">
                    <div>
                        <p>Nombre par page</p>
                        <select name="limiteelem">
                            <?php
                                $i = 0;
                                do {
                                    if ($limit == $limits[$i]) {
                                        echo '<option value='.$limits[$i].' selected>'.$limits[$i].'</option>';
                                    } else {
                                        echo '<option value='.$limits[$i].'>'.$limits[$i].'</option>';
                                    }
                                    
                                    $i += 1;
                                } while ($limits[$i] < $numResult && $i < 4); 
                            ?>
                        </select>
                    </div><br>
                    <div>
                        <p>Numéro de la page</p>
                        <select name="page">
                            <?php
                                for ($n = 1; $n < (intdiv($numResult,$limit)) + 2; $n++) {
                                    if ($n == $page) {
                                        echo '<option value='.$n.' selected>'.$n.'</option>';
                                    } else {
                                        echo '<option value='.$n.'>'.$n.'</option>';
                                    }
                                    
                                    $i += 1;
                                } 
                            ?>
                        </select>
                    </div>
                </div>
            </div>
        </form>    
    </body>
</html>