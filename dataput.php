<?php
    // Server name => localhost
    // Username => root
    // Password => empty
    
    
    include 'fonction.php';
   // echo 'connexion ok';
    
    // json file name
    $filename = "extract_theses.json";
          
    // Read the JSON file in PHP
    $theses = file_get_contents($filename);
          
    // Convert the JSON String into PHP Array
    $data = json_decode($theses, true); 
          
    // id
    $inc = 3;
    // Extracting row by row
    foreach ($data as $entry) {

        
        if (isset($entry['these_sur_travaux'])) {
            if ($entry['these_sur_travaux'] == "non") {
                $these_sur_travaux = "false";
            } else {
                $these_sur_travaux = "true";
            }
        } else {
            $these_sur_travaux = "null";
        }


        if (isset($entry['date_soutenance'])) {
            $date_soutenance = $entry['date_soutenance'];
        } else {
            $date_soutenance = null;
        }

        if (isset($entry['etablissements_soutenance'][0]) && isset($entry['code_etab'])) {
            $etablissements = "";
            foreach ($entry['etablissements_soutenance'] as $etab) {
                // il faut le Idref
                $etablissements .= $etab['nom'].' '.$etab['idref'].'<br>';
                $codeEtab = $entry['code_etab'];
                $nom = $etab['nom'];
                $idref = $etab['idref'];/*

                $result = $db->query("SELECT COUNT(*) as count FROM etablissement where codeEtab = '$codeEtab';");

                if ($result && $result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    if ($row["count"] > 0) {
                        //echo "L'établissement existe déjà.<br>";
                    } else {
                        // Insérer l'utilisateur ici
                        $insert = $db->query("INSERT into etablissement (codeEtab, nom, idref) VALUES ('$codeEtab', '$nom', '$idref');");
                       
                    }
                } else {
                    echo "Erreur lors de la vérification de l'utilisateur : " . $db->error;
                }*/
            }
        } else {
            $etablissements = null;
        }

        if (isset($entry['discipline']['fr'])) {
            $discipline_fr = $entry['discipline']['fr'];
            $langue = 'fr';
            $domaine = mysqli_real_escape_string($db, $entry['discipline']['fr']);/*
            $result = $db->query("SELECT COUNT(*) as count FROM discipline where domaine = '$domaine';");

            if ($result && $result->num_rows > 0) {
                $row = $result->fetch_assoc();
                if ($row["count"] > 0) {
                    //echo "La discipline existe déjà.<br>";
                } else {
                    // Insérer l'utilisateur ici
                    $insert = $db->query("INSERT into discipline (langue, domaine) VALUES ('$langue', '$domaine');");
                   
                }
            } else {
                echo "Erreur lors de la vérification de la discipline : " . $db->error;
            }*/
            $select = $db->query("SELECT iddiscipline from discipline where domaine = '$domaine';");
            if ($select && $select->num_rows > 0) {
                $disci = $select->fetch_assoc();
                $idDiscipline = $disci["iddiscipline"];
                
            } else {
                $idDiscipline = null;
            }
        } else {
            $discipline_fr = null;
            $idDiscipline = null;
        }

        if (isset($entry['president_jury']['nom'])) {
            $president = $entry['president_jury']['nom'].''.$entry['president_jury']['prenom'].''.$entry['president_jury']['idref'];
            
            $nom = $entry['president_jury']['nom'];
            $prenom = $entry['president_jury']['prenom'];
            $idref = $entry['president_jury']['idref'];
            /*
            $result = $db->query("SELECT COUNT(*) as count FROM people where nom = '$nom' and prenom = '$prenom';");

            if ($result && $result->num_rows > 0) {
                $row = $result->fetch_assoc();
                if ($row["count"] > 0) {
                    //echo "Le president_jury existe déjà.<br>";
                } else {
                    // Insérer l'utilisateur ici
                    $insert = $db->query("INSERT into people (nom, prenom, idref) VALUES ('$nom', '$prenom', '$idref');");
                    
                }
            } else {
                echo "Erreur lors de la vérification de l'utilisateur : " . $db->error;
            }*/
            $select = $db->query("SELECT idPeople from people where nom = '$nom' and prenom = '$prenom';");
            if ($select && $select->num_rows > 0) {
                $pres = $select->fetch_assoc();
                $idpres = $pres["idPeople"];
            } else {
                $idpres = 0;
            }
        } else {
            $president = null;
            $idpres = 0;
        }

        if (isset($entry['nnt'])) {
            $nnt = $entry['nnt'];
        } else {
            $nnt = null;
        }

        if (isset($entry['embargo'])) {
            $embargo = $entry['embargo'];
        } else {
            $embargo = null;
        }

        if (isset($entry['langue'])) {
            $langue = $entry['langue'];
        } else {
            $langue = null;
        }


        if (isset($entry['accessible'])) {
            if ($entry['accessible'] == "non") {
                $accessible = "false";
            } else {
                $accessible = "true";
            }
        } else {
            $accessible = null;
        }


        if (isset($entry['code_etab'])) {
            $code_etab = $entry['code_etab'];
        } else {
            $code_etab = null;
        }
        $titre = '';

        if (isset($entry['titres']['fr'])) {
            $titrefr = mysqli_real_escape_string($db, $entry['titres']['fr']);
            $titre .= $entry['titres']['fr'].'<br>';
        } else {
            $titrefr = null;
        }
        if (isset($entry['titres']['en'])) {
            $titreen = mysqli_real_escape_string($db, $entry['titres']['en']);
            $titre .= $entry['titres']['en'].'<br>';
        } else {
            $titreen = null;
        }


        $resume = '';
        if (isset($entry['resumes']['fr'])) {
            $resume .= $entry['resumes']['fr'].'<br>';
            $resumefr = mysqli_real_escape_string($db, $entry['resumes']['fr']);
        } else {
            $resumefr = null;
        }
        if (isset($entry['resumes']['en'])) {
            $resume .= $entry['resumes']['en'].'<br>';
            $resumeen = mysqli_real_escape_string($db, $entry['resumes']['en']);
        } else {
            $resumeen = null;
        }

        /*
        if ($inc != 0) {
            $insert = $db->query("INSERT INTO these (theseSurTravaux, dateSoutenance, idpres, nnt, embargo, langue, codeEtab,en_ligne,idDiscipline,titrefr, titreen, resumefr, resumeen) VALUES('$these_sur_travaux', '$date_soutenance', '$idpres', '$nnt', '$embargo', '$langue', '$code_etab', '$accessible', '$idDiscipline', '$titrefr', '$titreen', '$resumefr', '$resumeen');");
        }*/
        $qthese = 'SELECT idThese FROM these where titrefr = "'.$titrefr.'" and titreen = "'.$titreen.'" and resumefr = "'.$resumefr.'" and resumeen = "'.$resumeen.'"';
        $zthese = 'SELECT idThese FROM these where theseSurTravaux = '.$these_sur_travaux.' and dateSoutenance = '.$date_soutenance.' and idpres = '.$idpres.' and nnt = "'.$nnt.'" and langue = "'.$langue.'" and codeEtab = "'.$code_etab.'" and idDiscipline = '.$idDiscipline.' and titrefr = "'.$titrefr.'" and titreen = "'.$titreen.'" and resumefr = "'.$resumefr.'" and resumeen = "'.$resumeen.'"';
        $these = $db->query($qthese);
        echo $qthese;
        echo "<br>";
        echo $zthese;
        if ($these && $these->num_rows > 0) {
            $id = $these->fetch_assoc();
            $idThese = $id["idThese"];
        } else {
            $idThese = 0;
        }

        if (isset($entry['directeurs_these'][0])) {
            $directeur_these = "";
            foreach ($entry['directeurs_these'] as $dir) {
                $directeur_these .= $dir['nom'] . ' ' . $dir['prenom'].' '.$dir['idref'].'<br>';
                $nom = $dir['nom'];
                $prenom = $dir['prenom'];
                $idref = $dir['idref'];
                /*
                $result = $db->query("SELECT COUNT(*) as count FROM people where nom = '$nom' and prenom = '$prenom';");

                if ($result && $result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    if ($row["count"] > 0) {
                        //echo "Le directeur de these existe déjà.<br>";
                    } else {
                        // Insérer l'utilisateur ici
                        $insert = $db->query("INSERT into people (nom, prenom, idref) VALUES ('$nom', '$prenom', '$idref');");
                       
                    }
                } else {
                    //echo "Erreur lors de la vérification de l'utilisateur : " . $db->error;
                }*/
                $select = $db->query("SELECT idPeople from people where nom = '$nom' and prenom = '$prenom';");
                if ($select && $select->num_rows > 0) {
                    $dirs = $select->fetch_assoc();
                    $iddir = $dirs["idPeople"];
                    //$insert = $db->query("INSERT into directeurs_theses (idThese, idPeople) VALUES ('$inc', '$iddir'); ");
                }
            }
        } else {
            $directeur_these = null;
        }
        $sujets = '';
        if (isset($entry['sujets']['fr'])) {
            foreach($entry['sujets']['fr'] as $suj) {
                $sujets .= $suj.'<br>';
                $langue = 'fr';
                /*
                $result = $db->query("SELECT COUNT(*) as count FROM sujets where sujet = '$suj' and langue = '$langue';");

                if ($result && $result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    if ($row["count"] > 0) {
                        //echo "Le sujet existe déjà.<br>";
                    } else {
                        // Insérer l'utilisateur ici
                        $insert = $db->query("INSERT into sujets (langue, sujet) VALUES ('$langue', '$suj');");
                       
                    }
                } else {
                    //echo "Erreur lors de la vérification de l'utilisateur : " . $db->error;
                }*/
            }
        }
        if (isset($entry['sujets']['en'])) {
            foreach($entry['sujets']['en'] as $suj) {
                $sujets .= $suj.'<br>';
                $langue = 'en';
                /*
                $result = $db->query("SELECT COUNT(*) as count FROM sujets where sujet = '$suj' and langue = '$langue';");

                if ($result && $result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    if ($row["count"] > 0) {
                        echo "Le sujet existe déjà.<br>";
                    } else {
                        // Insérer l'utilisateur ici
                        $insert = $db->query("INSERT into sujets (langue, sujet) VALUES ('$langue', '$suj');");
                       
                    }
                } else {
                    //echo "Erreur lors de la vérification de l'utilisateur : " . $db->error;
                }*/
            }
        }

        if (isset($entry['ecoles_doctorales'][0])) {
            $ecoles_doctorales = "";
            foreach ($entry['ecoles_doctorales'] as $ecole) {
                $ecoles_doctorales .= $etab['nom'].' '.$etab['idref'].'<br>';
                $nom = $etab['nom'];
                $idref = $etab['idref'];/*

                $result = $db->query("SELECT COUNT(*) as count FROM ecole where nom = '$nom';");

                if ($result && $result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    if ($row["count"] > 0) {
                        //echo "L'établissement existe déjà.<br>";
                    } else {
                        // Insérer l'utilisateur ici
                        $insert = $db->query("INSERT into ecole (nom, idref) VALUES ('$nom', '$idref');");
                       
                    }
                } else {
                    //echo "Erreur lors de la vérification de l'utilisateur : " . $db->error;
                }*/
            }
        } else {
            $ecoles_doctorales = null;
        }

        if (isset($entry['oai_set_specs'][0])) {
            $oai = '';
            foreach($entry['oai_set_specs'] as $specs) {
                $ddc = explode('ddc:', $specs)['1'];
                $oai .= $ddc.'<br>';/*
                $result = $db->query("SELECT COUNT(*) as count FROM oai where ddc = '$ddc';");
                if ($result && $result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    if ($row["count"] > 0) {
                        //echo "La discipline existe déjà.<br>";
                    } else {
                        // Insérer l'utilisateur ici
                        $insert = $db->query("INSERT into oai (ddc) VALUES ('$ddc');");
                       
                    }
                } else {
                    echo "Erreur lors de la vérification de la discipline : " . $db->error;
                }*/
            }
        } else {
            $oai = null;
        }

        if (isset($entry['membres_jury'][0])) {
            $membres_jury = "";
            foreach ($entry['membres_jury'] as $jury) {
                //id ref
                $membres_jury .= $jury['nom'] . ' ' . $jury['prenom'].''.$jury['idref'].'<br>';
                $nom = $jury['nom'];
                $prenom = $jury['prenom'];
                $idref = $jury['idref'];/*

                $result = $db->query("SELECT COUNT(*) as count FROM people where nom = '$nom' and prenom = '$prenom';");

                if ($result && $result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    if ($row["count"] > 0) {
                        //echo "Le membres du jury existe déjà.<br>";
                    } else {
                        // Insérer l'utilisateur ici
                        $insert = $db->query("INSERT into people (nom, prenom, idref) VALUES ('$nom', '$prenom', '$idref');");
                       
                    }
                } else {
                    //echo "Erreur lors de la vérification de l'utilisateur : " . $db->error;
                }
                $select = $db->query("SELECT idPeople from people where nom = '$nom' and prenom = '$prenom';");
                if ($select && $select->num_rows > 0) {
                    $mem = $select->fetch_assoc();
                    $iddir = $mem["idPeople"];
                    $insert = $db->query("INSERT into membres_jury (idThese, idPeople) VALUES ('$inc', '$iddir'); ");
                }*/
            }
        } else {
            $membres_jury = null;
        }

        if (isset($entry['partenaires_recherche'][0])) {
            $partenaires = "";
            foreach ($entry['partenaires_recherche'] as $part) {
                $partenaires .= $part['nom'] . ' ' . $part['type'].''.$part['idref'].'<br>';
                if(strlen($part['nom']) > 130) {
                    echo 'partenaire nom plus grand que 50'; 
                }
                $nom = $part['nom'];
                $tipe = $part['type'];
                $idref = $part['idref'];/*

                $result = $db->query("SELECT COUNT(*) as count FROM partenaire where nom = '$nom' and tipe = '$tipe';");

                if ($result && $result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    if ($row["count"] > 0) {
                        //echo "Le partenaire de recherche existe déjà.<br>";
                    } else {
                        // Insérer l'utilisateur ici
                        $insert = $db->query("INSERT into partenaire (tipe, nom, idref) VALUES ('$tipe', '$nom', '$idref');");
                       
                    }
                } else {
                    //echo "Erreur lors de la vérification de l'utilisateur : " . $db->error;
                }*/
            }
        } else {
            $partenaires = null;
        }


        
        if (isset($entry['rapporteurs'][0])) {
            $rapporteurs = "";
            foreach ($entry['rapporteurs'] as $rapport) {
                $rapporteurs .= $rapport['nom'] . ' ' . $rapport['prenom'].''.$rapport['idref'].'<br>';
                $nom = $rapport['nom'];
                $prenom = $rapport['prenom'];
                $idref = $rapport['idref'];/*

                $result = $db->query("SELECT COUNT(*) as count FROM people where nom = '$nom' and prenom = '$prenom';");

                if ($result && $result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    if ($row["count"] > 0) {
                        //echo "Le rapporteur existe déjà.<br>";
                    } else {
                        // Insérer l'utilisateur ici
                        $insert = $db->query("INSERT into people (nom, prenom, idref) VALUES ('$nom', '$prenom', '$idref');");
                       
                    }
                } else {
                    echo "Erreur lors de la vérification de l'utilisateur : " . $db->error;
                }*/
                $select = $db->query("SELECT idPeople from people where nom = '$nom' and prenom = '$prenom';");
                if ($select && $select->num_rows > 0) {
                    $rap = $select->fetch_assoc();
                    $iddir = $rap["idPeople"];/*
                    if (iddir > 0) {
                        $insert = $db->query("INSERT into rapporteurs (idThese, idPeople) VALUES ('$inc', '$iddir'); ");
                    }*/
                }
            }
        } else {
            $rapporteurs = null;
        }

        if (isset($entry['auteurs'][0])) {
            $auteurs = "";
            foreach ($entry['auteurs'] as $auteur) {
                //id ref
                $auteurs .= $auteur['nom'] . ' '.$auteur['prenom'];
                if(isset($auteur['idref'])) {
                    $auteurs .= ''.$auteur['idref'].'<br>';
                    $idref = $auteur['idref'];
                } else {
                    $auteurs .= '<br>';
                    $idref = null;
                }
                $nom = $auteur['nom'];
                $prenom = $auteur['prenom'];
                /*
                $result = $db->query("SELECT COUNT(*) as count FROM people where nom = '$nom' and prenom = '$prenom';");

                if ($result && $result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    if ($row["count"] > 0) {
                    } else {
                        // Insérer l'utilisateur ici
                        $insert = $db->query("INSERT into people (nom, prenom, idref) VALUES ('$nom', '$prenom', '$idref');");
                       
                    }
                } else {
                    echo "Erreur lors de la vérification de l'utilisateur : " . $db->error;
                }
                $select = $db->query("SELECT idPeople from people where nom = '$nom' and prenom = '$prenom';");
                if ($select && $select->num_rows > 0) {
                    $aut = $select->fetch_assoc();
                    $iddir = $aut["idPeople"];
                    $insert = $db->query("INSERT into auteurs (idThese, idPeople) VALUES ('$inc', '$iddir'); ");
                }*/
            }
        } else {
            $auteurs = null;
        }
        // Utilisez les données extraites comme vous le souhaitez
        echo "Thèse : $idThese<br>";/*
        echo "En travaux : $these_sur_travaux<br>";
        echo "Date de Soutenance : $date_soutenance<br>";
        echo "président jury : $idpres<br>";
        echo "nnt : $nnt<br>";
        echo "embargo : $embargo<br>";
        echo "langue : $langue<br>";
        echo "code_etab : $code_etab<br>";
        echo "accessible : $accessible<br>";
        echo "Discipline : $idDiscipline<br>";
        echo "Titrefr : $titrefr<br>";
        echo "Titreen : $titreen<br>";
        echo "Résumefr : $resumefr<br>";
        echo "Résuméen : $resumeen<br>";*//*
        echo "Directeurs de theses : $directeur_these<br>";
        echo "Etablissement soutenance : $etablissements<br>";
        echo "Discipline (FR) : $discipline_fr<br>";
        echo "oai_set_specs : $oai<br>";
        echo "version : $vers<br>";
        echo "iddoc : $iddoc<br>";
        echo "ecoles_doctorales : $ecoles_doctorales<br>";
        echo "status : $status<br>";
        echo "source : $source<br>";
        echo "timestamp : $timestamp<br>";
        echo "cas : $cas<br>";
        echo "Titre : $titre<br>";
        echo "Résumé : $resume<br>";
        echo "sujets : $sujets<br>";
        echo "membres_jury : $membres_jury<br>";
        echo "partenaires : $partenaires<br>";
        echo "sujets_rameau : $sujets_rameau<br>";
        echo "rapporteurs : $rapporteurs<br>";
        echo "auteurs : $auteurs<br>";*/
        echo "<hr>";
        $inc += 1;
    }
?>
<?php
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


à faire:
 un mcd détaillé
 avec les cardinalités
*/
?>
