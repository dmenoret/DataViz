<?php
    include 'fonction.php';
    if (isset($_GET['uni'])) {
        $recherche = $_GET['uni'];
    } else {
        $recherche = 0;
    }
    $uni = $db->query('SELECT nom FROM etablissement WHERE codeEtab ="'.$recherche.'"');
    if ($uni && $uni->num_rows > 0) {
        $u = $uni->fetch_assoc();
        while ($u != NULL) {
            $nom = $u["nom"];
            $u = $uni->fetch_assoc();
        }
    } else {
        echo "Nous n'avons pas d'université enregistrée sous ce nom.";
    }
    $result = $db->query('SELECT * FROM these WHERE codeEtab = "'.$recherche.'" ORDER BY dateSoutenance DESC');
    
    $count = $db->query('SELECT COUNT(*) AS count FROM these WHERE codeEtab = "'.$recherche.'"');
    
    $disc = $db->query('SELECT d.domaine as nom, COUNT(*) as count FROM these t, discipline d WHERE t.idDiscipline = d.iddiscipline AND t.codeEtab = "'.$recherche.'" GROUP BY t.idDiscipline ORDER BY count DESC;')
?>
<html lang="fr">
<head>
    <link rel="icon" type="image/x-icon" href="Icon.png">
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="these.css" />
    <title>
        <?php echo $nom ?>
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
                    echo $nom ?></h1></div>
                </div>
                <div>
                    <?php 
                        if ($count && $count->num_rows > 0) {
                            $row = $count->fetch_assoc();
                            echo $row["count"];
                        }
                    ?> thèses encadrés par cet établissement
                </div>
                <div class ="etablis">
                    <?php
                        $ii=0;
                        if ($disc && $disc->num_rows > 0) {
                            $di = $disc->fetch_assoc();
                            while ($di != null) {
                                $ii++;
                                if ($ii%6==0){echo '</div><div class="etablis>';}
                                echo '<a href="recherche.php?these=&disci='.str_replace(" ","+",$di["nom"]).'" style="text-decoration:none; color : white;"><div class="univ">'.$di["nom"]." (".$di["count"].")</div><a/>";
                                $di = $disc->fetch_assoc();
                            }
                        }
                    ?>
                </div>
                <div class ="author">
                    <h1>Ces thèses ont été soutenu:</h1>
                </div>
                <div class = "directeur" style = "display:block;">
                    <?php
                        if ($result && $result->num_rows > 0) {
                            $these = $result->fetch_assoc();
                            while ($these != null) {
                                if($these["titrefr"] != ""){
                                    echo '<a style="text-decoration:none;" href="these.php?idThese='.$these["idThese"].'"><div class ="these-elem"><h2>'.$these["titrefr"].'</h2><div class="these-info">'.$these["dateSoutenance"]."</div></div></a>";
                                    $these = $result->fetch_assoc();
                                }
                                else{
                                    echo '<a style="text-decoration:none;" href="these.php?idThese='.$these["idThese"].'"><div class ="these-elem"><h2>'.$these["titreen"].'</h2><div class="these-info">'.$these["dateSoutenance"]."</div></div></a>";
                                    $these = $result->fetch_assoc();
                                }
                            }
                        }
                    ?>
                </div>
            </div>
            <div class="articles"></div>
            <div class="articles"></div>
            <div class="articles"></div>
            <div class="articles"></div>
            <div class="articles"></div>
            <div class="articles"></div>
            <div class="articles"></div>
            <div class="articles"></div>
            <div class="articles"></div>
            <div class="articles"></div>
            
        </div>
    </div>
</body>
</html>