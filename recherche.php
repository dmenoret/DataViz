<?php
    
    include 'fonction.php';
    if (isset($_GET['these'])) {
        $recherche = '%'.str_replace(" ","",$_GET['these']).'%';
    } else {
        $recherche = '%';
    } if (isset($_GET['limiteelem'])) {
        $limit = $_GET['limiteelem'];
    } else {
        $limit = 500;
    } if (isset($_GET['page'])) {
        $page = $_GET['page'];
    } else {
        $page = 1;
    }
    if (isset($_GET['disci'])) {
        $disci = $_GET['disci'];
    } else {
        $disci = "%";
    }
    if (isset($_GET['etab'])) {
        $etab = $_GET['etab'];
    } else {
        $etab = "%";
    }
    $ld = (($page-1)*$limit);
    $lf = (($page)*$limit);
    $limits = [25, 100, 200, 500];
    $lim = $db->query("SELECT count(*) as numResult from these where titrefr like '$recherche' or titreen like'$recherche'");
    $numResult = $lim->fetch_assoc()['numResult'];
    $discip = $db->query("SELECT domaine, COUNT(*) as times FROM discipline d JOIN these t ON d.iddiscipline = t.idDiscipline where titrefr like '$recherche' or titreen like'$recherche' GROUP by domaine ORDER BY times DESC limit 10;");
    $univ = $db->query("SELECT nom, COUNT(*) as times FROM etablissement e JOIN these t ON e.codeEtab = t.codeEtab where titrefr like '$recherche' or titreen like'$recherche' GROUP by t.codeEtab ORDER BY times DESC limit 10;");
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
        <div class="backgr">
            <div class ="a">
                <div class ="ab">
                    <a href="index.php"><img src="home.png" alt="homepage icon"></a>
                </div>
            </div>
            <div class ="b"></div>
        </div>
        <form method="GET" action ="recherche.php">
            <div class="tete">
                <input type="text" class="navbar" placeholder="Entrez des mots clés" value="<?php if (isset($_GET['these'])) { echo str_replace(" ","",$_GET['these']);}?>" name="these">
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
                                    if ($disc['domaine'] == $disci) {
                                        echo "<div><input class='radio' type='radio' id='".$disc['domaine']."' name='disci' value='".$disc['domaine']."' checked/>
                                        <label for='".$disc['domaine']."'>".$disc['domaine']." (".$disc['times'].")"."</label></div>";
                                    } else {
                                        echo "<div><input class='radio' type='radio' id='".$disc['domaine']."' name='disci' value='".$disc['domaine']."' />
                                        <label for='".$disc['domaine']."'>".$disc['domaine']." (".$disc['times'].")"."</label></div>";
                                    }
                                    $disc = $discip->fetch_assoc();
                                }
                            }
                        ?>
                    </div>
                </div>
                <div class="milieu">
                    <?php
                    $result = $db->query("SELECT t.idThese, titrefr, titreen, d.domaine, dateSoutenance, e.codeEtab as codeetab, e.nom as etnom, p.idPeople as idDir, p.nom as dinom, p.prenom as diprenom, p2.idPeople as idAut, p2.nom as aunom, p2.prenom as auprenom FROM people p join directeurs_theses dt on p.idPeople = dt.idPeople join these t on dt.idThese = t.idThese join etablissement e on t.codeEtab = e.codeEtab join discipline d on d.iddiscipline = t.idDiscipline LEFT JOIN auteurs a on a.idThese = t.idThese join people p2 on a.idPeople = p2.idPeople where titrefr like '$recherche' and d.domaine like '$disci' and e.nom like '$etab' or titreen like '$recherche' and d.domaine like '$disci' and e.nom like '$etab' order by t.idThese limit $ld, $lf;");
                    if ($result && $result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        $inc = 0;
                        while ($row != NULL && $inc < $limit) {  
                            $inc += 1;
                            if ($row['titrefr'] == "") {
                                echo '<a href="these.php?idThese='.$row['idThese'].'"><div class="these-elem"><h2>'.$row['titreen'].'</h2>';
                            } else {
                                echo '<a href="these.php?idThese='.$row['idThese'].'"><div class="these-elem"><h2>'.$row['titrefr'].'</h2>';
                            }
                            echo '
                                <div class="these-info">
                                    <p class="auteur">Par <div class="lien"><a href="auteur.php?idAuteur='.$row['idAut'].'">'.$row['aunom'].' '.$row['auprenom'].'</a></div></p>
                                    <p class="directeur">Sous la direction de <div class="lien"><a href="auteur.php?idAuteur='.$row['idDir'].'">'.$row['dinom'].' '.$row['diprenom'].'</a></div></p>
                                    <p class="discipline"><a href="uni.php?uni='.$row['codeetab'].'">'.$row['etnom'].'</a></p>
                                </div>
                                <div class="these-info">
                                    <p class="date">Le '.$row['dateSoutenance'].'</p>
                                    <p class="discipline">'.$row['domaine'].'</p>
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
                    <div>
                        <?php
                            if ($univ && $univ->num_rows > 0) {
                                $disc = $univ->fetch_assoc();
                                while ($disc != NULL) {
                                    if ($disc['nom'] == $etab) {
                                        echo "<div><input class='radio' type='radio' id='".$disc['nom']."' name='etab' value='".$disc['nom']."' checked/>
                                        <label for='".$disc['nom']."'>".$disc['nom']." (".$disc['times'].")"."</label></div>";
                                    } else {
                                        echo "<div><input class='radio' type='radio' id='".$disc['nom']."' name='etab' value='".$disc['nom']."' />
                                        <label for='".$disc['nom']."'>".$disc['nom']." (".$disc['times'].")"."</label></div>";
                                    }
                                    $disc = $univ->fetch_assoc();
                                }
                            }
                        ?>
                    </div>
                </div>
            </div>
        </form>    
    </body>
</html>