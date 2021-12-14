<?php

namespace modele\dao;

use modele\metier\TypeCuisine;
use modele\dao\Bdd;
use PDO;
use PDOException;
use Exception;

/**
 * Classe DAO
 * @author N. Bourgeois
 * @version 2021
 */
class TypeCuisineDAO {

    public static function getAllNonProposerByIdR(int $idR): array {
        $lesObjets = array();
        try {
            $requete = "select * from typeCuisine where idTC not in 
(select typeCuisine.idTC from typeCuisine inner join proposer on typeCuisine.idTC = proposer.idTC where proposer.idR = :idR)"
            ;
            $stmt = Bdd::getConnexion()->prepare($requete);
            $stmt->bindParam(':idR', $idR, PDO::PARAM_INT);
            $ok = $stmt->execute();
            if ($ok) {
                while ($enreg = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $lesObjets[] = new TypeCuisine($enreg['idTC'], $enreg['libelleTC']);
                }
            }
        } catch (PDOException $e) {
            throw new Exception("Erreur dans la méthode " . get_called_class() . "::getAllNonPreferesByIdU : <br/>" . $e->getMessage());
        }
        return $lesObjets;
    }
    /**
     * Retourne un objet TypeCuisine d'après son identifiant 
     * @param int $id identifiant de l'objet recherché
     * @return TypeCuisine
     */
    public static function getOneById(int $id): TypeCuisine {
        $leTC = null;
        try {
            $requete = "SELECT * FROM typeCuisine WHERE idTC = :id";
            $stmt = Bdd::getConnexion()->prepare($requete);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $ok = $stmt->execute();
            // attention, $ok = true pour un select ne retournant aucune ligne
            if ($ok && $stmt->rowCount() > 0) {
                $enreg = $stmt->fetch(PDO::FETCH_ASSOC);
                $leTC = new TypeCuisine($enreg['idTC'], $enreg['libelleTC']);
            }
        } catch (PDOException $e) {
            throw new Exception("Erreur dans la méthode " . get_called_class() . "::getOneById : <br/>" . $e->getMessage());
        }
        return $leTC;
    }

    /**
     * Retourne la liste de tous les types de cuisines de la BDD
     * @return array tableau d'objets de type TypeCuisine
     * @throws Exception transmet les exceptions PDO éventuelles
     */
    public static function getAll(): array {
        $lesObjets = array();
        try {
            $requete = "SELECT * FROM typeCuisine";
            $stmt = Bdd::getConnexion()->prepare($requete);
            $ok = $stmt->execute();
            if ($ok) {
                while ($enreg = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $lesObjets[] = new TypeCuisine($enreg['idTC'], $enreg['libelleTC']);
                }
            }
        } catch (PDOException $e) {
            throw new Exception("Erreur dans la méthode " . get_called_class() . "::getAll : <br/>" . $e->getMessage());
        }
        return $lesObjets;
    }

    /**
     * Liste des types de cuisine préférés par un utilisateur
     * @param int $idU identifiant de l'utilisateur
     * @return array tableau d'objets de type TypeCuisine
     */
    public static function getAllPreferesByIdU(int $idU): array {
        $lesObjets = array();
        try {
            $requete = "select tc.* from typeCuisine tc inner join preferer p on tc.idTC = p.idTC where p.idU = :idU";
            $stmt = Bdd::getConnexion()->prepare($requete);
            $stmt->bindParam(':idU', $idU, PDO::PARAM_INT);
            $ok = $stmt->execute();
            if ($ok) {
                while ($enreg = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $lesObjets[] = new TypeCuisine($enreg['idTC'], $enreg['libelleTC']);
                }
            }
        } catch (PDOException $e) {
            throw new Exception("Erreur dans la méthode " . get_called_class() . "::getAllPreferesByIdU : <br/>" . $e->getMessage());
        }
        return $lesObjets;
    }

    /**
     * Liste des types de cuisine que NE PREFERE PAS un utilisateur
     * @param int $idU identifiant de l'utilisateur
     * @return array tableau d'objets de type TypeCuisine
     */
    public static function getAllNonPreferesByIdU(int $idU): array {
        $lesObjets = array();
        try {
            $requete = "select * from typeCuisine where idTC 
                                not in 
                                    (select typeCuisine.idTC from typeCuisine
                                        inner join preferer on typeCuisine.idTC = preferer.idTC 
                                        where preferer.idU = :idU
                                    )"
            ;
            $stmt = Bdd::getConnexion()->prepare($requete);
            $stmt->bindParam(':idU', $idU, PDO::PARAM_INT);
            $ok = $stmt->execute();
            if ($ok) {
                while ($enreg = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $lesObjets[] = new TypeCuisine($enreg['idTC'], $enreg['libelleTC']);
                }
            }
        } catch (PDOException $e) {
            throw new Exception("Erreur dans la méthode " . get_called_class() . "::getAllNonPreferesByIdU : <br/>" . $e->getMessage());
        }
        return $lesObjets;
    }

    /**
     * Liste des types de cuisine proposés par un retaurant donné
     * @param int $idR identifiant du restaurant
     * @return array tableau d'objets de type TypeCuisine
     */
    public static function getAllProposesByIdR(int $idR): array {
        $lesObjets = array();
        try {
            $requete = "select typeCuisine.* from typeCuisine inner join proposer on typeCuisine.idTC = proposer.idTC where proposer.idR = :idR";
            $stmt = Bdd::getConnexion()->prepare($requete);
            $stmt->bindParam(':idR', $idR, PDO::PARAM_INT);
            $ok = $stmt->execute();
            if ($ok) {
                while ($enreg = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $lesObjets[] = new TypeCuisine($enreg['idTC'], $enreg['libelleTC']);
                }
            }
        } catch (PDOException $e) {
            throw new Exception("Erreur dans la méthode " . get_called_class() . "::getAllProposesByIdR : <br/>" . $e->getMessage());
        }
        return $lesObjets;
    }

    public static function delete(int $idTC): bool {
        $resultat = false;
        try {
            $stmt = Bdd::getConnexion()->prepare("DELETE FROM preferer WHERE idTC=:idTC; "
                    . "DELETE FROM proposer WHERE idTC=:idTC;"
                    . "DELETE FROM typeCuisine WHERE idTC=:idTC;");

            $stmt->bindParam(':idTC', $idTC, PDO::PARAM_INT);
            $resultat = $stmt->execute();
        } catch (PDOException $e) {
            throw new Exception("Erreur dans la méthode " . get_called_class() . "::delete : <br/>" . $e->getMessage());
        }
        return $resultat;
    }

    public static function insert(string $nomTag): bool {
        $resultat = false;
        try {
            $stmt = Bdd::getConnexion()->prepare("INSERT INTO typeCuisine(libelleTC) VALUES(?);");
            $stmt->bindParam(1, $nomTag);
            $resultat = $stmt->execute();
        } catch (PDOException $e) {
            throw new Exception("Erreur dans la méthode " . get_called_class() . "::insert : <br/>" . $e->getMessage());
        }
        return $resultat;
    }

}
