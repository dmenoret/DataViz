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
        <?php
            $db = new mysqli('localhost', 'root', '', 'dataviz');
            if ($db->connect_error) {
                echo 'bad co';
                die("échec de la connexion à la base de données:".$conn->connect_error);
            }
        ?>
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
    <form method="POST" action ="people.php">
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Email address</label>
            <input type="text" class="form-control" name="nom" id="exampleInputEmail1" aria-describedby="emailHelp">
            <div id="emailHelp" class="form-text">We'll never share your name with anyone else.</div>
        </div>
        <div class="mb-3">
            <label for="exampleInputPassword1" class="form-label">Password</label>
            <input type="password" class="form-control" name="idref" id="exampleInputPassword1">
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
    <?php
    $result = $db->query("SELECT * FROM people");

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
    ?>
  </tbody>
</table>
    </body>
</html>