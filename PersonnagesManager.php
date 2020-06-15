<?php

class PersonnagesManager extends Personnage 
{

    private $_db;

    public function __construct($db)
    {
        $this->setDb($db);

    }
    public function add(Personnage $perso)
    {
        $request = $this->_db->prepare('INSERT INTO personnages SET nom = :nom,
      `force` = :force, vie = :vie, niveau = :niveau, experience = :experience;');
        print_r('"' . $perso->getExperience() . '"');
        $request->bindValue(':nom', $perso->getNom(), PDO::PARAM_STR);
        $request->bindValue(':force', $perso->getForce(), PDO::PARAM_INT);
        $request->bindValue(':vie', $perso->getVie(), PDO::PARAM_INT);
        $request->bindValue(':niveau', $perso->getNiveau(), PDO::PARAM_INT);
        $request->bindValue(':experience', $perso->getExperience(), PDO::PARAM_INT);

        $request->execute();
        if ($request->errorCode() > 0) {
            echo "<br/> Une erreur SQL est intervenue : ";
            print_r($request->errorInfo()[2]);
        }

    }
    public function getList()
    {
        $persos = array();
        $request = $this->_db->query('SELECT id, nom, `force`, vie, niveau, experience FROM personnages ORDER BY nom; ');
        if ($request) {
            while ($ligne = $request->fetch(PDO::FETCH_ASSOC)) {
                $persos[] = new guerrier($ligne); 
            }
        } else {
            print('Erreur de requête SQL');
        }
        return $persos;
    }
    public function delete(Personnage $perso)
    {
        
        print("<br/>Le personnage " . $perso->getNom() . " est mort !<br/>");
        $request=$this->_db->prepare('DELETE FROM personnages Where id =' . $perso->getId() . ';');
        $request->bindValue(':id', $perso->getId(), PDO::FETCH_ASSOC);
        $request->execute();
    }
    public function getOne($id)
    {
        $id = (int) $id;
        $request = $this->_db->prepare('SELECT id, nom, `force`, vie, niveau, experience FROM personnages WHERE id = ' . $id . ';');
        $request->bindValue(':id', $id, PDO::FETCH_ASSOC);
        //print($id);
        $request->execute();
        if ($request->errorCode() != '00000') {
            echo "<br/>Une erreur SQL est intervenue : ";
            print_r($request->errorInfo()[2]);
        }
        $ligne = $request->fetch(PDO::FETCH_ASSOC);
        //print("Guerrier= ");var_dump($ligne);
        
        return new Guerrier($ligne);
    }
    public function update(Personnage $perso)
    {
        $request = $this->_db->prepare('UPDATE personnages SET
      `force` = :force, vie = :vie, niveau = :niveau, experience = :experience WHERE id = :id;');

        $request->bindValue(':force', $perso->getForce(), PDO::PARAM_INT);
        $request->bindValue(':vie', $perso->getVie(), PDO::PARAM_INT);
        $request->bindValue(':niveau', $perso->getNiveau(), PDO::PARAM_INT);
        $request->bindValue(':experience', $perso->getExperience(), PDO::PARAM_INT);
        $request->bindValue(':id', $perso->getId(), PDO::PARAM_STR);

        $request->execute();
        if($perso->getVie()<=0)
        {
            $this->delete($perso);
        }
    }
    public function setDb($_db)
    {
        $this->_db = $_db;
        return $this;
    }
 
}
