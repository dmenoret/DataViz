<html lang="fr">
	<head>
        <link rel="icon" type="image/x-icon" href="Icon.png">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
		<meta charset="UTF-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<link rel="stylesheet" href="accueil.css" />
		<title>
			Page principale
		</title>
	</head>
	<body>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#idPeople</th>
                    <th scope="col">nom</th>
                    <th scope="col">prénom</th>
                    <th scope="col">idref</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    if (isset($_POST['nom']) && isset($_POST['idref'])) {
                        $nom = htmlspecialchars($_POST['nom']);
                        $idref = htmlspecialchars($_POST['idref']);
                                
                        $db = new mysqli('localhost', 'root', '', 'dataviz');
                        if ($db->connect_error) {
                            echo 'bad co';
                            die("échec de la connexion à la base de données:".$conn->connect_error);
                        }
                        
                        $result = $db->query("SELECT * FROM people where nom = '$nom' and idref = '$idref';");
                        if ($result && $result->num_rows > 0) {
                            $row = $result->fetch_assoc();
                            while ($row != NULL) {            
                                echo '<tr><th>'.$row['idPeople'].'</th>';
                                echo '<td>'.$row['nom'].'</td>';
                                echo '<td>'.$row['prenom'].'</td>';
                                echo '<td>'.$row['idref'].'</td></tr>';
                                $row = $result->fetch_assoc();
                            }
                        }
                    } else {
                        header('login.php');
                    }
                ?>
            </tbody>
        </table>
	</body>
</html>