<?php

function chargerClasses($classe) //Permet de charger les "librairies" plus facilement

{
    require $classe . '.php';
}
print("\n" . '<br/> PHP Battle Game <br/>');

spl_autoload_register('chargerClasses'); // utilise la fonction "chargerClasse" dès que new sera vu dans le programme
session_start();
$phase = 0;
if (isset($_SESSION['perso'])) {
    $perso = $_SESSION['perso'];
    print("\n" . 'Le joueur ' . $perso->getNom() . ' a été créer, Qui voulez vous jouer ?');
}
if (isset($_SESSION['nom'])) {
    $perso = $_SESSION['nom'];
    print("\n" . 'Vous jouez ' . $perso->getNom() . ' qui voulez vous affronter ? ');
}
if (isset($_SESSION['adversaire'])) {
    $perso = $_SESSION['adversaire'];
    print("\n" . 'Vous avez choisis ' . $perso->getNom() . ' ! ');
    print("\n" . '<br> combat en cours <br>');
   // $personnageManager->frapper($perso);
    print("\n" . '<br>Qui voulez vous frapper maintenant ?');
}

// Création des persos
// $perso1 = new personnage('Mario', 30, 100 , 2 , 50); // Personnage = Nom,Force,Vie,Niveau,Experience
// $perso2 = new personnage('Luigi', 80, 700 , 1 , 10);
// print("\n".'<br/>');

// //Affichage des persos
// $perso1->afficherStats();
// $perso2->afficherStats();
// print("\n".'<br/>');

// // Combat
// $perso1->frapper($perso2);
// $perso1->gagnerExperience();
// $perso2->frapper($perso1);
// $perso2->gagnerExperience(50);

// //Affichage post combat
// print("\n".'<br/> Resultat du combat :');
// print("\n".'<br/>' . $perso1);
// print("\n".'<br/>' . $perso2);

$dsn = 'mysql:dbname=battlegame;host=127.0.0.1';
$user = 'root';
$password = '';

try {
    $db = new PDO($dsn, $user, $password);
    $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    if ($db) {
        print("\n" . '<br/>Lecture dans la base de données :');

        $personnageManager = new PersonnagesManager($db);
        // print($_POST['adversaire']);
        if (isset($_POST['adversaire'])) {
            $adversaire = $personnageManager->getOne($_POST['adversaire']);
            $perso->frapper($adversaire);
            $personnageManager->update($adversaire);
            //print("\n".'<br/>adversaire a frapper = '. $adversaire->getNom(). '<br/>');
        }
        if (isset($_POST['perso'])) {
            $perso = new Personnage(array(
                'nom' => $_POST['perso'],
                'force' => 50,
                'degats' => 0,
                'niveau' => 1,
                'experience' => 1,
            ));
            $personnageManager->add($perso);

        }
        print("\n" . '<br/> <table> <tr> <td>Nom<td/> <td>Force<td/> <td>Vie<td/> <td>Experience<td/> <td>Niveau<td/> <td> Choix <td/> </tr>');
        //print($_POST['perso']);
        $personnages = $personnageManager->getList();
        foreach ($personnages as $perso) {
            print("\n" . '<tr> <td>' . $perso->getNom() . ' <td/><td> ' . $perso->getForce() . ' <td/><td>  '
                . $perso->getVie() . ' <td/><td>  ' . $perso->getExperience() . ' <td/><td>  '
                . $perso->getNiveau() . '<td/> ');
            print("\n" . '<form method="POST">');
            print("\n" . '<input type="submit" name="choix" value="Choisir"/>');
                print("\n" . '<input type="hidden" name="nom"   value="' . $perso->getId() . '">');
                $phase = 1;
                print("\n" . '<input type="hidden" name="adversaire"   value="' . $perso->getId() . '">');
                $phase = 2;

            print("\n" . '</form> </tr>');
        }
        print("\n" . '</table>');
        print("\n" . 'nouveau personnage : ');
        print("\n" . '<form method="POST">');
        print("\n" . '<input type="text" name="perso"/>');
        print("\n" . '<input type="submit" name="creer" value="créer un personnage"/>');
        print("\n" . '</form> <br/>');

        // $request = $db->query('SELECT id, nom, `force`, vie, niveau, experience FROM personnages;');
        // while ($ligne = $request->fetch(PDO::FETCH_ASSOC)) // Chaque entrée sera récupérée et placée dans un array.
        // {
        //     $perso = new Personnage($ligne);
        //     print("\n".'<br/>' . $perso->getNom() . ' a ' . $perso->getForce() . ' de force, '
        //         . $perso->getVie() . ' point de vie, ' . $perso->getExperience() . ' d\'expérience et est au niveau '
        //         . $perso->getNiveau());
        // }
    }

} catch (PDOException $e) {
    print("\n" . '<br/>Erreur de connexion : ' . $e->getMessage());
}
if (isset($perso)) {
    $_SESSION['perso'] = $perso;
}
if (isset($perso) && ($phase == 1)) {
    $_SESSION['nom'] = $perso;
}
if (isset($perso) && ($phase == 2)) {
    $_SESSION['adversaire'] = $perso;
}
