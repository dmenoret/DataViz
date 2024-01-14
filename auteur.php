<?php
    include 'fonction.php';
    if (isset($_GET['idAuteur'])) {
        $recherche = $_GET['idAuteur'];
    } else {
        $recherche = 0;
    }
    $people = $db->query("SELECT nom, prenom from people where idPeople = $recherche");
    if ($people && $people->num_rows > 0) {
        $peop = $people->fetch_assoc();
        while ($peop != NULL) {
            $nom = $peop["nom"];
            $prenom = $peop["prenom"];
            $peop = $people->fetch_assoc();
        }
    } else {
        echo "Nous n'avons pas de personne enregistrée sous ce numéro.";
    }
    $resultdir = $db->query("SELECT t.idThese as id, t.dateSoutenance as dateS, t.titrefr as titre FROM these t join directeurs_theses dt on t.idThese = dt.idThese WHERE dt.idPeople = $recherche");
    $resultaut = $db->query("SELECT t.idThese as id, t.dateSoutenance as dateS, t.titrefr as titre FROM these t join auteurs a on t.idThese = a.idThese WHERE a.idPeople = $recherche");
    $etabs = $db->query("SELECT e.codeEtab as code, e.nom as nom FROM etablissement e join these t on e.codeEtab = t.codeEtab join directeurs_theses dt on t.idThese = dt.idThese WHERE dt.idPeople = $recherche;");
    $count = $db->query("SELECT count(*) as count FROM these t join directeurs_theses dt on t.idThese = dt.idThese WHERE dt.idPeople = $recherche");
?>
<html lang="fr">
<head>
    <link rel="icon" type="image/x-icon" href="Icon.png">
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="these.css" />
    <title>
        Page de <?php echo $nom.' '.$prenom;?>
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
            <div class="infos">
                <div>
                    <div class ="author"><img src="author.png"></div>
                    <div class ="author"><h1><?php
                    echo $nom.' '.$prenom;?></h1></div>
                </div>
                <div>
                    <?php 
                        if ($count && $count->num_rows > 0) {
                            $row = $count->fetch_assoc();
                            echo $row["count"];
                        }
                    ?> thèse(s) encadré(s)
                </div>
                <div class ="etablis">
                    <?php
                        if ($etabs && $etabs->num_rows > 0) {
                            $etab = $etabs->fetch_assoc();
                            while ($etab != null) {
                                echo '<a style ="text-decoration:none; color:white;" href="uni.php?uni='.$etab['code'].'"><div class="univ">'.$etab["nom"]."</div></a>";
                                $etab = $etabs->fetch_assoc();
                            }
                        }
                    ?>
                </div>
                <div class ="dir">
                    <h1>A écrit :</h1>
                </div>
                <div class = "author" style = "display:block;">
                    <?php
                        if ($resultaut && $resultaut->num_rows > 0) {
                            $these = $resultaut->fetch_assoc();
                            while ($these != null) {
                                echo '<a style="text-decoration:none;" href="these.php?idThese='.$these["id"].'"><div class ="these-elem"><h2>'.$these["titre"].'</h2><div class="these-info">'.$these["dateS"]."</div></div></a>";
                                $these = $resultaut->fetch_assoc();
                            }
                        }
                    ?>
                </div>
                <div class ="dir">
                    <h1>A dirigé :</h1>
                </div>
                <div class = "directeur" style = "display:block;">
                    <?php
                        if ($resultdir && $resultdir->num_rows > 0) {
                            $these = $resultdir->fetch_assoc();
                            while ($these != null) {
                                echo '<a style="text-decoration:none;" href="these.php?idThese='.$these["id"].'"><div class ="these-elem"><h2>'.$these["titre"].'</h2><div class="these-info">'.$these["dateS"]."</div></div></a>";
                                $these = $resultdir->fetch_assoc();
                            }
                        }
                    ?>
                </div>
            </div>
            
        </div>
    </div>
</body>
</html>