<?php

function chargerClasses($classe) //Permet de charger les "librairies" plus facilement

{
    require $classe . '.php';
}

spl_autoload_register('chargerClasses'); // utilise la fonction "chargerClasse" dès que new sera vu dans le programme

print('<br/> PHP Battle Game <br/>');

//Création des persos
$perso1 = new personnage('Mario', 30, 100); // Personnage = Nom,Force,Vie
$perso2 = new personnage('Luigi', 80, 700);
print('<br/>');

//Affichage des persos
$perso1->afficherStats();
$perso2->afficherStats();
print('<br/>');

// Combat
$perso1->frapper($perso2);
$perso1->gagnerExperience();
$perso2->frapper($perso1);
$perso2->gagnerExperience(50);

//Affichage post combat
print('<br/> Resultat du combat :');
print('<br/>' . $perso1);
print('<br/>' . $perso2);
