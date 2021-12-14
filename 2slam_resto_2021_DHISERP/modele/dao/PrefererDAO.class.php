<?php

namespace modele\dao;

use modele\dao\Bdd;
use PDO;
use PDOException;
use Exception;

/**
 * Description of PrefererDAO
 *
 * @author N. Bourgeois
 * @version 07/2021
 */
class PrefererDAO {


    /**
     * Ajouter un couple (idU, idTC) à la table preferer
     * @param int $idU identifiant de l'utilisateur qui préfère ce type de cuisine
     * @param int $idTC identifiant du type de cuisine préféré
     * @return bool true si l'opération réussit, false sinon
     * @throws Exception transmission des erreurs PDO éventuelles
     */
    public static function insert(int $idU, int $idTC): bool {
        $resultat = false;
        try {
            $stmt = Bdd::getConnexion()->prepare("INSERT INTO preferer (idTC, idU) VALUES(:idTC,:idU)");
            $stmt->bindParam(':idU', $idU, PDO::PARAM_INT);
            $stmt->bindParam(':idTC', $idTC, PDO::PARAM_INT);
            $resultat = $stmt->execute();
        } catch (PDOException $e) {
            throw new Exception("Erreur dans la méthode " . get_called_class() . "::insert : <br/>" . $e->getMessage());
        }
        return $resultat;
    }

    /**
     * Suppimer un couple (idU, idTC) de la table preferer
     * @param int $idU identifiant de l'utilisateur qui ne préfère plus ce type de cuisine
     * @param int $idTC identifiant du type de cuisine
     * @return bool true si l'opération réussit, false sinon
     * @throws Exception transmission des erreurs PDO éventuelles
     */
    public static function delete(int $idU, int $idTC): bool {
        $resultat = false;
        try {
            $stmt = Bdd::getConnexion()->prepare("DELETE FROM preferer WHERE idTC=:idTC and idU=:idU");
            $stmt->bindParam(':idTC', $idTC, PDO::PARAM_INT);
            $stmt->bindParam(':idU', $idU, PDO::PARAM_INT);
            $resultat = $stmt->execute();
        } catch (PDOException $e) {
            throw new Exception("Erreur dans la méthode " . get_called_class() . "::delete : <br/>" . $e->getMessage());
        }
        return $resultat;
    }

}
