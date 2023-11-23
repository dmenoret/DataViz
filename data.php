<?php
    // Server name => localhost
    // Username => root
    // Password => empty
    // Database name => test
    // Passing these 4 parameters
            
    $query = '';
    $table_data = '';
          
    // json file name
    $filename = "extract_theses.json";
          
    // Read the JSON file in PHP
    $theses = file_get_contents($filename);
          
    // Convert the JSON String into PHP Array
    $array = json_decode($theses, true); 
    $directeur = null;
          
    // id
    $inc = 0;
    // Extracting row by row
    foreach($array as $inc => $row) {

        // Database query to insert data 
        // into database Make Multiple 
        // Insert Query 
 /*       $query .= 
        "INSERT INTO these (theseSurTravaux, 
        dateSoutenance, versio, iddoc, 
        idpres, nnt, embargo, statut, 
        origin, accessibility, langue, 
        timetable, codeEtab, cas) VALUES 
        ('".$row["accessible"]."', 
        '".$row["date_soutenance"]."', 
        '".$row["discipline"]."', 
        '".$row["embargo"]."', 
        '".$row["langue"]."', 
        '".$row["nnt"]."', 
        '".$row["date_soutenance"]."', 
        '".$row["date_soutenance"]."', 
        '".$row["date_soutenance"]."', 
        '".$row["date_soutenance"]."', 
        '".$row["accessible"]."'); "; */
        echo '<table><tr><td>aaaaa</td></tr>';
        foreach($row["directeurs_these"] as $dirnum => $dir) {
            $querydir = "INSERT INTO people";
        }/*
        $s = 0;
        if (isset($entry['sujets_rameau'][0])) {
            $sujets_rameau = "";
            foreach ($entry['sujets_rameau'] as $sujet) {
                $s += 1;
                $sujets_rameau .= $s.' type '.$sujet['type_vedette'].'<br> contenu ' . $sujet['element_entree']['contenu'].''.$sujet['element_entree']['idref'].'<br>';
                //id ref
                $typevedette = $sujet['type_vedette'];
                $contenu = $sujet['element_entree']['contenu'];
                $idref = $sujet['element_entree']['idref'];

                $result = $db->query("SELECT COUNT(*) as count FROM sujets_rameau where contenu = '$contenu' and typevedette = '$typevedette';");

                if ($result && $result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    if ($row["count"] > 0) {
                        echo "Le sujet-rameau existe déjà.<br>";
                    } else {
                        // Insérer l'utilisateur ici
                        $insert = $db->query("INSERT into sujets_rameau (typevedette, contenu, idref) VALUES ('$typevedette', '$contenu', '$idref');");
                       
                    }
                } else {
                    //echo "Erreur lors de la vérification de l'utilisateur : " . $db->error;
                }
                // subdivisions
                foreach($sujet['subdivisions'] as $sub) {
                    $sujets_rameau .= $sub['type'].' '.$sub['contenu'].' '.$sub['idref'].'<br>';
                    $contenu = $sub['contenu'];
                    $subtype = $sub['type'];
                    $idref = $sub['idref'];
    
                    $result = $db->query("SELECT COUNT(*) as count FROM subdivision where contenu = '$contenu' and subtype = '$subtype';");
    
                    if ($result && $result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        if ($row["count"] > 0) {
                            echo "Le partenaire de recherche existe déjà.<br>";
                        } else {
                            // Insérer l'utilisateur ici
                            $insert = $db->query("INSERT into subdivision (subtype, contenu, idref) VALUES ('$subtype', '$contenu', '$idref');");
                           
                        }
                    } else {
                        //echo "Erreur lors de la vérification de l'utilisateur : " . $db->error;
                    }
                }
            }
        } else {
            $sujets_rameau = null;
        }*/
    }
?>
<?php
$theses = file_get_contents("extract_theses.json");
echo var_dump($theses); 
/*
id = increment
en_ligne = accessible
auteurs = Table People
date_soutenance = date_soutenance
directeurs_these = Table people
discipline = discipline[fr]
embargo = embargo
etablissements_soutenance = Table etablissement
langue = langue
membres_jury = Table People
nnt = nnt
oai_set_specs = oai_set_specs
president_jury = Table people un seul
rapporteurs = Table people
resume = resume.fr
sujets = sujets.fr
these_sur_travaux = these_sur_travaux
titre = titre.fr

*/
?>
