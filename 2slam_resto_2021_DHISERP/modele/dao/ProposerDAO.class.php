<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace modele\dao;

use modele\dao\Bdd;
use PDO;
use PDOException;
use Exception;
/**
 * Description of ProposerDAO
 *
 * @author Mluca
 */
class ProposerDAO {
    
    public static function insert(int $idR, int $idTC): bool {
        $resultat = false;
        try {
            $stmt = Bdd::getConnexion()->prepare("INSERT INTO proposer (idR, idTC) VALUES(:idR,:idTC)");
            $stmt->bindParam(':idR', $idR, PDO::PARAM_INT);
            $stmt->bindParam(':idTC', $idTC, PDO::PARAM_INT);
            $resultat = $stmt->execute();
        } catch (PDOException $e) {
            throw new Exception("Erreur dans la méthode " . get_called_class() . "::insert : <br/>" . $e->getMessage());
        }
        return $resultat;
    }
    
    public static function delete(int $idR, int $idTC): bool {
        $resultat = false;
        try {
            $stmt = Bdd::getConnexion()->prepare("DELETE FROM proposer WHERE idR=:idR and idTC=:idTC");
            $stmt->bindParam(':idTC', $idTC, PDO::PARAM_INT);
            $stmt->bindParam(':idR', $idR, PDO::PARAM_INT);
            $resultat = $stmt->execute();
        } catch (PDOException $e) {
            throw new Exception("Erreur dans la méthode " . get_called_class() . "::delete : <br/>" . $e->getMessage());
        }
        return $resultat;
    }
}
