<?php
    $db = new mysqli('localhost', 'root', '', 'dataviz');
    if ($db->connect_error) {
        echo 'bad co';
        die("échec de la connexion à la base de données:".$conn->connect_error);
    }
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
    $result = $db->query("SELECT idThese from directeurs_theses where idPeople = $recherche");
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
                <a href="index.php"><img src="home.png" alt="homepage icon"></a>
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
                <div>Dernier article : ______________________</div>
                <div>12 articles</div>
                <div>3 thèses encadrés</div>
                <div>
                    <div class="univ">Orléans</div>
                    <div class="univ">Dauphine</div>
                    <div class="univ">Eiffel</div>
                </div>
                <div class ="author"><h1>A dirigé ces thèses :</h1></div>
                <d
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