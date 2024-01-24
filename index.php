<?php
    include 'fonction.php';
    $discip = $db->query("SELECT domaine, COUNT(*) as times FROM discipline d JOIN these t ON d.iddiscipline = t.idDiscipline GROUP by domaine ORDER BY times DESC limit 5;");
    $ndiscip = $db->query("SELECT domaine, COUNT(*) as times FROM discipline d JOIN these t ON d.iddiscipline = t.idDiscipline GROUP by domaine ORDER BY times DESC limit 5;");
    $topdiscip = $db->query("SELECT domaine, COUNT(*) as times FROM discipline d JOIN these t ON d.iddiscipline = t.idDiscipline GROUP by domaine ORDER BY times DESC limit 5;");
    $ecoles = $db->query("SELECT COUNT(*) as times FROM etablissement");
    $numecoles = $ecoles->fetch_assoc()['times'];
    $univ = $db->query("SELECT nom, COUNT(*) as times FROM etablissement e JOIN these t ON e.codeEtab = t.codeEtab GROUP by t.codeEtab ORDER BY times DESC limit 5;");
    $nuniv = $db->query("SELECT nom, COUNT(*) as times FROM etablissement e JOIN these t ON e.codeEtab = t.codeEtab GROUP by t.codeEtab ORDER BY times DESC limit 5;");
    $topuniv = $db->query("SELECT e.codeEtab as codeEtab, nom, COUNT(*) as times FROM etablissement e JOIN these t ON e.codeEtab = t.codeEtab GROUP by t.codeEtab ORDER BY times DESC limit 5;");
    
    $dir = $db->query("SELECT nom, COUNT(*) as times FROM people p JOIN directeurs_theses d on p.idPeople = d.idPeople JOIN these t ON d.idThese = t.idThese GROUP by nom ORDER BY times DESC limit 5;");
    $ndir = $db->query("SELECT nom, COUNT(*) as times FROM people p JOIN directeurs_theses d on p.idPeople = d.idPeople JOIN these t ON d.idThese = t.idThese GROUP by nom ORDER BY times DESC limit 5;");
    $topdir = $db->query("SELECT nom, p.idPeople AS id, COUNT(*) as times FROM people p JOIN directeurs_theses d on p.idPeople = d.idPeople JOIN these t ON d.idThese = t.idThese GROUP by nom ORDER BY times DESC limit 5;");
    
    $lim = $db->query("SELECT count(*) as numResult from these");
    $numResult = $lim->fetch_assoc()['numResult'];
    
    $nbdis =$db->query("SELECT COUNT(*) AS nb FROM discipline;");
    ?>
<html>
    <head>
        <title>Accueil</title>
      <link href="chart.css" rel="stylesheet">
      <link rel="icon" type="image/x-icon" href="Icon.png">
      <meta charset="UTF-8" />
		  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    </head>
    <body>
        <div class="head">
          <h1>NosThèses.edu</h1>
            <div>
              <form method="GET" action ="recherche.php">
                <input type="text" placeholder="Recherchez une thèse" name="these">
              </form>
            </div>
        </div>
        <div class ="bottom">
            <div>
                <div>
                    <h3>Sujets les plus abordés (top 5):</h3>
                    <ul>
                        <?php
                         if ($topdiscip && $topdiscip->num_rows > 0) {
                            $disc = $topdiscip->fetch_assoc();
                            while ($disc != NULL) {
                                echo '<li><a href="recherche.php?disci='.$disc['domaine'].'">'.$disc['domaine']."</a> (".$disc['times'].")</li>";
                                $disc = $topdiscip->fetch_assoc();
                            }
                        }
                        
                        ?>
                    </ul>
                </div>
                <div><canvas id="topdixsujets"></canvas></div>
                <div>
                    <h3>Nombre de thèses : </h3>
                    <p style="text-align:center;"><?php echo $numResult;?></p>
                </div>
            </div>
            <div>
                <div><canvas id="topdixuniv"></canvas></div>
                <div>
                    <h3>Universités / Ecole avec le plus de thèses (top 5):</h3>
                    <ul>
                        <?php
                         if ($topuniv && $topuniv->num_rows > 0) {
                            $disc = $topuniv->fetch_assoc();
                            while ($disc != NULL) {
                                echo '<li><a href="uni.php?uni='.$disc['codeEtab'].'">'.$disc['nom']."</a> (".$disc['times'].")</li>";
                                $disc = $topuniv->fetch_assoc();
                            }
                        }
                        
                        ?>
                    </ul>
                </div>
                <div>
                    <h3>Nombre d'université :</h3>
                    <p style="text-align:center;"><?php echo $numecoles;?></p>
                </div>
            </div>
            <div>
                <div>
                    <h3>Nombre de sujets abordés</h3>
                    <p style="text-align:center;">
                    <?php if ($nbdis && $nbdis->num_rows > 0) {
                        $disc = $nbdis->fetch_assoc();
                        while ($disc != NULL) {
                            echo $disc['nb'];
                            $disc = $nbdis->fetch_assoc();
                        }
                    }?></p>
                </div>
                <div><canvas id="topdixdir"></canvas></div>
                <div>
                    <h3>Professeurs ayant encadré le plus de thèses (top 5):</h3>
                    <ul>
                        <?php
                         if ($topdir && $topdir->num_rows > 0) {
                            $disc = $topdir->fetch_assoc();
                            while ($disc != NULL) {
                                echo '<li><a href="auteur.php?idAuteur='.$disc['id'].'">'.$disc['nom']."</a> (".$disc['times'].")</li>";
                                $disc = $topdir->fetch_assoc();
                            }
                        }
                        
                        ?>
                    </ul>
                </div>               
            </div>
        </div><script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            const topdixsujet = document.getElementById('topdixsujets');
            const topdixuniv = document.getElementById('topdixuniv');
            const topdixdir = document.getElementById('topdixdir');
            Chart.defaults.backgroundColor = '#0d18ea';
            Chart.defaults.borderColor = '#5bffb8';
            Chart.defaults.color = '#5bffb8';
            new Chart(topdixsujet, {
              type: 'bar',
              data: {
                labels: [<?php
                if ($discip && $discip->num_rows > 0) {
                    $disc = $discip->fetch_assoc();
                    while ($disc != NULL) {
                        echo "'".$disc['domaine']."',";
                        $disc = $discip->fetch_assoc();
                    }
                }
                ?>],
                datasets: [{
                  label: 'Top 5 des thématiques abordées',
                  data: [<?php
                if ($ndiscip && $ndiscip->num_rows > 0) {
                    $disc = $ndiscip->fetch_assoc();
                    while ($disc != NULL) {
                        echo $disc['times'].",";
                        $disc = $ndiscip->fetch_assoc();
                    }
                }
                ?>],
                  borderWidth: 1,
                }]
              },
              options: {
                scales: {
                  y: {
                    beginAtZero: true
                  }
                }
              }
            });
            new Chart(topdixuniv, {
              type: 'bar',
              data: {
                labels: [<?php
                if ($univ && $univ->num_rows > 0) {
                    $disc = $univ->fetch_assoc();
                    while ($disc != NULL) {
                        echo "'".$disc['nom']."',";
                        $disc = $univ->fetch_assoc();
                    }
                }
                ?>],
                datasets: [{
                  label: 'Top 5 des universités représentées',
                  data: [<?php
                if ($nuniv && $nuniv->num_rows > 0) {
                    $disc = $nuniv->fetch_assoc();
                    while ($disc != NULL) {
                        echo $disc['times'].",";
                        $disc = $nuniv->fetch_assoc();
                    }
                }
                ?>],
                  borderWidth: 1,
                }]
              },
              options: {
                scales: {
                  y: {
                    beginAtZero: true
                  }
                }
              }
            });
            new Chart(topdixdir, {
              type: 'bar',
              data: {
                labels: [<?php
                if ($dir && $dir->num_rows > 0) {
                    $disc = $dir->fetch_assoc();
                    while ($disc != NULL) {
                        echo "'".$disc['nom']."',";
                        $disc = $dir->fetch_assoc();
                    }
                }
                ?>],
                datasets: [{
                  label: 'Top 5 des professeurs encandrants',
                  data: [<?php
                if ($ndir && $ndir->num_rows > 0) {
                    $disc = $ndir->fetch_assoc();
                    while ($disc != NULL) {
                        echo $disc['times'].",";
                        $disc = $ndir->fetch_assoc();
                    }
                }
                ?>],
                  borderWidth: 1,
                }]
              },
              options: {
                scales: {
                  y: {
                    beginAtZero: true
                  }
                }
              }
            });
        </script>          
    </body>
</html>