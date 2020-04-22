<?php
class personnage
{

    private $_experience = 0;
    private $_vie = 100;
    private $_force = 20;
    private $_degats = 0;
    private $_nom = 'inconnu';

    public function __construct($nom, $force = 10, $vie = 100, $experience = 0)
    {
        $this->setNom($nom);
        $this->setForce($force);
        $this->setVie($vie);
        $this->setExperience($experience);
        print('<br/> Le personnage"' . $nom . '" est créé !');
    }
    public function __toString()
    {
        return $this->getNom() . ' a ' . $this->getVie() . ' point de vie' . ' , a une force de ' . $this->getForce() . ' et a ' . $this->_experience . ' point d\' expérience';
    }
    public function setNom($nom)
    {
        if (!is_string($nom)) {
            trigger_error('Le nom du personnage doit être un texte', E_USER_WARNING);
        } else {

            $this->_nom = $nom;
        }
    }

    public function getNom()
    {
        return $this->_nom;
    }

    public function setForce($force)
    {
        if (!is_int($force)) {
            trigger_error('La force du personnage doit être une valeur entière', E_USER_WARNING);
            return;
        } else {
            $this->_force = $force;
        }
    }
    public function getForce()
    {
        return $this->_force;
    }
    public function setExperience($experience)
    {
        if (!is_int($experience)) {
            trigger_error('L\'expérience d\'un personnage doit être un nombre entier', E_USER_WARNING);
            return;
        }
        if ($experience > 100) {
            trigger_error('L\'expérience d\'un personnage ne peut pas dépasser 100', E_USER_WARNING);
            return;
        }
        $this->_experience = $experience;
    }
    public function afficherExperience()
    {
        print('expérience de ' . $this->getNom() . ' = ' . $this->_experience);
    }
    public function gagnerExperience($valeur = 1)
    {
        //$this->_experience = $this->_experience + 1;
        $this->_experience += $valeur;
    }
    public function frapper(Personnage $adversaire)
    {
        $adversaire->_vie -= $this->_force;
        print('<br/> ' . $adversaire->getNom() . ' a été frappé par ' . $this->getNom() . ' , vie restante de  ' . $adversaire->getNom() . ' = ' . $adversaire->_vie . '<br/>');
    }
    public function setVie($vie)
    {
        $this->_vie = $vie;
    }
    public function getVie()
    {
        return $this->_vie;
    }
    public function afficherStats()
    {
        print('<br/> personnage : ' . $this->getNom() . ' , force : ' . $this->getForce() . ' , vie : ' . $this->getVie() . ' , expérience : ' . $this->_experience);
    }
}
