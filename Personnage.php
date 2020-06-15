<?php
abstract class Personnage
{

    protected $_experience = 1;
    protected $_vie = 100;
    protected $_force = 20;
    protected $_degats = 0;
    protected $_niveau = 0;
    protected $_nom = 'inconnu';
    protected $_id;
    protected static $_compteur = 0;

    protected const EST_MORT = 1;
    protected const EST_FRAPPE = 2;
    protected const EST_LUI_MEME = 3;

    public function __construct($ligne)
    {
        $this->hydrate($ligne);
        self::$_compteur++;
        //print('<br/> Le perosnnage"'.$this->getNom().'" est créé ! <br/>');
        // self::parler();
    }
    public function hydrate(array $ligne)
    {
        foreach ($ligne as $key => $value) {
            $method = 'set' . ucfirst($key);
            //print('hydrate method= '.$method . '('.$value.')<br/>');

            if (method_exists($this, $method)) {
                $this->$method($value);
            }
        }
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
    public function setNiveau($niveau)
    {
        $this->_niveau = $niveau;
    }
    public function getNiveau()
    {
        return $this->_niveau;
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
    public function getExperience()
    {
        return $this->_experience;
    }
    public function gagnerExperience($valeur = 1)
    {
        //$this->_experience = $this->_experience + 1;
        $this->_experience += $valeur;
    }
    public function frapper(Personnage $adversaire)
    {
        if ($adversaire->getId() == $this->getId()) {
            return self::EST_LUI_MEME;
        }
        $adversaire->_vie -= $this->_force;
        print('<br/> ' . $adversaire->getNom() . ' a été frappé par ' . $this->getNom() . ' , vie restante de  ' . $adversaire->getNom() . ' = ' . $adversaire->_vie . '<br/>');

        if ($adversaire->getVie() <= 0) {
            return self::EST_MORT;
        } else {
            return self::EST_FRAPPE;
        }
    }
    public function setVie($vie)
    {
        $this->_vie = $vie;
    }
    public function getVie()
    {
        return $this->_vie;
    }
    public function getId()
    {
        return $this->_id;
    }
    public function setId($id)
    {
        $this->_id = $id;
    }
    public function afficherStats()
    {
        print('<br/> personnage : ' . $this->getNom() . ' , force : ' . $this->getForce() . ' , vie : ' . $this->getVie() . ' , expérience : ' . $this->_experience);
    }
}
