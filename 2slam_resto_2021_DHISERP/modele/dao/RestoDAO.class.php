<?php

namespace modele\dao;

use modele\metier\Resto;
use modele\dao\CritiqueDAO;
use modele\dao\TypeCuisineDAO;
use modele\dao\PhotoDAO;
use modele\dao\Bdd;
use PDO;
use PDOException;
use Exception;

/**
 * Description of RestoDAO
 * N.B. : chargement de type "lazy" pour casser le cycle suivant :
 * "un restaurant collectionne des critiques, une critique est émise par un utilisateur, un utilisateur aime des restaurants"
 * Donc, pour chaque critique,  on charge l'objet Utilisateur qui a émis la critique, mais sans ses restaurants aimés ni ses types de cuisine préférés
 * @author N. Bourgeois
 * @version 07/2021
 */
class RestoDAO {
    
    public static function insertResto(Resto $unResto): bool {
        $resultat = false;
        $requete = "INSERT INTO resto ( nomR, numAdrR, voieAdrR, cpR, villeR, latitudeDegR, longitudeDegR, descR, horairesR) VALUES(:nomR, :numAdrR, :voieAdrR, :cpR, :villeR, :latitudeDegR, :longitudeDegR, :descR, :horairesR)";
        $stmt = Bdd::getConnexion()->prepare($requete);
        $stmt->bindValue(':nomR', $unResto->getNomR());
        $stmt->bindValue(':numAdrR', $unResto->getNumAdr());
        $stmt->bindValue(':voieAdrR', $unResto->getVoieAdr());
        $stmt->bindValue(':cpR', $unResto->getCpR());
        $stmt->bindValue(':villeR', $unResto->getVilleR());
        $stmt->bindValue(':latitudeDegR', $unResto->getLatitudeDegR());
        $stmt->bindValue(':longitudeDegR', $unResto->getLongitudeDegR());
        $stmt->bindValue(':descR', $unResto->getDescR());
        $stmt->bindValue(':horairesR', $unResto->getHorairesR());
        $resultat = $stmt->execute();

        return $resultat;
    }

    public static function updateResto(Resto $unResto): bool {
        $ok = false;
        $requete = "UPDATE resto SET nomR = :nomR, numAdrR = :numAdrR, voieAdrR = :voieAdrR, cpR = :cpR, villeR = :villeR, descR = :descR, horairesR = :horairesR WHERE idR = :idR ";
        $stmt = Bdd::getConnexion()->prepare($requete);
        $stmt->bindValue(':nomR', $unResto->getNomR(), PDO::PARAM_STR);
        $stmt->bindValue(':numAdrR', $unResto->getNumAdr(), PDO::PARAM_INT);
        $stmt->bindValue(':voieAdrR', $unResto->getVoieAdr(), PDO::PARAM_STR);
        $stmt->bindValue(':cpR', $unResto->getCpR(), PDO::PARAM_INT);
        $stmt->bindValue(':villeR', $unResto->getVilleR(), PDO::PARAM_STR);
        $stmt->bindValue(':descR', $unResto->getDescR(), PDO::PARAM_STR);
        $stmt->bindValue(':horairesR', $unResto->getHorairesR(), PDO::PARAM_STR);
        $stmt->bindValue(':idR', $unResto->getIdR(), PDO::PARAM_INT);
        $ok = $stmt->execute();

        return $ok;
    }

    public static function deleteRestaurants(int $idR): bool {
        $resultat = false;
        $requete = "DELETE FROM aimer WHERE idR=:idR;
                    DELETE FROM critiquer WHERE idR=:idR;
                    DELETE FROM photo WHERE idR=:idR;
                    DELETE FROM proposer WHERE idR=:idR;
                    DELETE FROM resto WHERE idR=:idR;";
        $stmt = Bdd::getConnexion()->prepare($requete);
        $stmt->bindValue(':idR', $idR, PDO::PARAM_INT);
        $resultat = $stmt->execute();

        return $resultat;
    }

    /**
     * Retourne un objet Resto d'après son identifiant
     * @param int $id identifiant de l'objet Resto recherché
     * @return Resto l'objet Resto recherché ou null
     * @throws Exception transmission des erreurs PDO éventuelles
     */
    public static function getOneById(int $id): ?Resto {
        $leResto = null;
        try {
            $requete = "SELECT * FROM resto WHERE idR = :idR";
            $stmt = Bdd::getConnexion()->prepare($requete);
            $stmt->bindParam(':idR', $id, PDO::PARAM_INT);
            $ok = $stmt->execute();
            // attention, $ok = true pour un select ne retournant aucune ligne
            if ($ok && $stmt->rowCount() > 0) {
                // Extraire l'enregistrement obtenu
                $enreg = $stmt->fetch(PDO::FETCH_ASSOC);
                //Instancier un nouveau restaurant
                $leResto = self::enregistrementVersObjet($enreg);
            }
        } catch (PDOException $e) {
            throw new Exception("Erreur dans la méthode " . get_called_class() . "::getOneById : <br/>" . $e->getMessage());
        }
        return $leResto;
    }

    /**
     * Retourne tous les restaurants
     * @return array tableau d'objets Resto
     * @throws Exception transmission des erreurs PDO éventuelles
     */
    public static function getAll(): array {
        $lesObjets = array();
        try {
            $requete = "SELECT * FROM resto";
            $stmt = Bdd::getConnexion()->prepare($requete);
            $ok = $stmt->execute();
            // attention, $ok = true pour un select ne retournant aucune ligne
            if ($ok) {
                // Pour chaque enregistrement
                while ($enreg = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    //Instancier un nouveau restaurant et l'ajouter à la liste
                    $lesObjets[] = self::enregistrementVersObjet($enreg);
                }
            }
        } catch (PDOException $e) {
            throw new Exception("Erreur dans la méthode " . get_called_class() . "::getAll : <br/>" . $e->getMessage());
        }
        return $lesObjets;
    }

    /**
     * Liste  des 4 restaurants les mieux notés par les critiques
     * @return array tableau d'objets Resto
     * @throws Exception transmission des erreurs PDO éventuelles
     */
    public static function getTop4(): array {
        $lesObjets = array();
        try {
            $requete = "SELECT AVG(note) AS NotesCumulees, r.idR, nomR, numAdrR, voieAdrR, cpR, villeR, latitudeDegR, longitudeDegR, descR, horairesR  
                       FROM resto r
                       INNER JOIN critiquer c ON r.idR = c.idR 
                       GROUP BY r.idR, nomR, numAdrR, voieAdrR, cpR, villeR, latitudeDegR, longitudeDegR, descR, horairesR 
                       ORDER BY NotesCumulees DESC
                       LIMIT 4;
                    ";
            $stmt = Bdd::getConnexion()->prepare($requete);
            $ok = $stmt->execute();
            // attention, $ok = true pour un select ne retournant aucune ligne
            if ($ok) {
                // Pour chaque enregistrement
                while ($enreg = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    //Instancier un nouveau restaurant et l'ajouter à la liste
                    $lesObjets[] = self::enregistrementVersObjet($enreg);
                }
            }
        } catch (PDOException $e) {
            throw new Exception("Erreur dans la méthode " . get_called_class() . "::getTop4 : <br/>" . $e->getMessage());
        }
        return $lesObjets;
    }

    /**
     * Liste des restaurants proposant certains types de cuisine
     * Filtrage : les restaurants sélectionnés doivent proposer au moins un des types de cuisine recherchés
     * @param array $tabIdTC liste des identifiants des types de cuisine recherchés
     * @return array tableau d'objets Resto
     * @throws Exception transmission des erreurs PDO éventuelles
     */
    public static function getAllByTypesCuisine(array $tabIdTC): array {
        $lesObjets = array();
        try {
            if (count($tabIdTC) > 0) {
                $filtre = "idTC = $tabIdTC[0] ";
                for ($i = 1; $i < count($tabIdTC); $i++) {
                    $filtre .= " or  idTC = $tabIdTC[$i] ";
                }
                $requete = "SELECT DISTINCT r.* "
                        . "FROM resto r "
                        . "INNER JOIN proposer p ON r.idR = p.idR "
                        . "WHERE (" . $filtre . ") "
                        . "ORDER BY nomR";
                $stmt = Bdd::getConnexion()->prepare($requete);
                $ok = $stmt->execute();
                // attention, $ok = true pour un select ne retournant aucune ligne
                if ($ok) {
                    // Pour chaque enregistrement
                    while ($enreg = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        //Instancier un nouveau restaurant et l'ajouter à la liste
                        $lesObjets[] = self::enregistrementVersObjet($enreg);
                    }
                }
            }
        } catch (PDOException $e) {
            throw new Exception("Erreur dans la méthode " . get_called_class() . "::getAllByTypesCuisine : <br/>" . $e->getMessage());
        }
        return $lesObjets;
    }

    /**
     * Liste des restaurants filtrée sur le nom ou un extrait du nom.
     * Filtrage : les restaurants sélectionnés contiennent la sous-chaîne passée en paramètre dans leur nom
     * @param string $extraitNomR chai,ne à rechercher dasn les noms des restaurants
     * @return array tableau d'objets Resto
     * @throws Exception transmission des erreurs PDO éventuelles
     */
    public static function getAllByNomR(string $extraitNomR): array {
        $lesObjets = array();
        try {
            $requete = "SELECT * FROM resto WHERE nomR LIKE :nomR";
            $stmt = Bdd::getConnexion()->prepare($requete);
            $motif = "%" . $extraitNomR . "%";
            $stmt->bindParam(':nomR', $motif, PDO::PARAM_STR);
            $ok = $stmt->execute();
            // attention, $ok = true pour un select ne retournant aucune ligne
            if ($ok) {
                // Pour chaque enregistrement
                while ($enreg = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    //Instancier un nouveau restaurant et l'ajouter à la liste
                    $lesObjets[] = self::enregistrementVersObjet($enreg);
                }
            }
        } catch (PDOException $e) {
            throw new Exception("Erreur dans la méthode " . get_called_class() . "::getAllByNom : <br/>" . $e->getMessage());
        }
        return $lesObjets;
    }

    /**
     * Liste des restaurants filtrée sur les éléments de l'adresse.
     * @param string $voieAdrR voie ex : "rue de Crébillon"
     * @param string $cpR code postal ex : "44000"
     * @param string $villeR ex : "NANTES"
     * @return array tableau d'objets Resto
     * @throws Exception transmission des erreurs PDO éventuelles
     */
    public static function getAllByAdresse(string $voieAdrR, string $cpR, string $villeR): array {
        $lesObjets = array();
        try {
            $requete = "SELECT * FROM resto WHERE voieAdrR LIKE :voieAdrR AND cpR LIKE :cpR AND villeR LIKE :villeR";
            $stmt = Bdd::getConnexion()->prepare($requete);
            $motifVoieAdrR = "%" . $voieAdrR . "%";
            $motifCpR = "%" . $cpR . "%";
            $motifVilleR = "%" . $villeR . "%";
            $stmt->bindParam(':voieAdrR', $motifVoieAdrR, PDO::PARAM_STR);
            $stmt->bindParam(':cpR', $motifCpR, PDO::PARAM_STR);
            $stmt->bindParam(':villeR', $motifVilleR, PDO::PARAM_STR);
            $ok = $stmt->execute();
            // attention, $ok = true pour un select ne retournant aucune ligne
            if ($ok) {
                // Pour chaque enregistrement
                while ($enreg = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    //Instancier un nouveau restaurant et l'ajouter à la liste
                    $lesObjets[] = self::enregistrementVersObjet($enreg);
                }
            }
        } catch (PDOException $e) {
            throw new Exception("Erreur dans la méthode " . get_called_class() . "::getAllByAdresse : <br/>" . $e->getMessage());
        }
        return $lesObjets;
    }

    /**
     * Recherche de restaurants selon plusieurs critères (filtrage)
     * Tous les critères doivent être réunis (ET logique) sauf les types de cuisine, 1 au moins parmi tous (OU logique)
     * Les valeurs des critères de type string peuvent-être incomplètes (on cherche une sous-chaîne)
     * @param string $nomR nom du restaurant
     * @param string $voieAdrR nom de la rue
     * @param string $cpR code postal
     * @param string $villeR ville du restaurant
     * @param array $tabIdTC tableau des identifiants des types de cuisine concernés
     * @return array  tableau d'objets Resto
     * @throws Exception Exception transmission des erreurs PDO éventuelles
     */
    public static function getAllMultiCriteres(string $extraitNomR, string $voieAdrR, string $cpR, string $villeR, array $tabIdTC): array {
        $lesObjets = array();
        try {
            if (count($tabIdTC) > 0) {
                $filtre = "idTC = $tabIdTC[0] ";
                for ($i = 1; $i < count($tabIdTC); $i++) {
                    $filtre .= " OR  idTC = $tabIdTC[$i] ";
                }
                $requete = "SELECT DISTINCT r.* "
                        . " FROM resto r "
                        . " INNER JOIN proposer p ON r.idR = p.idR "
                        . " WHERE (" . $filtre . ") "
                        . " OR nomR LIKE :nomR"
                        . " OR  voieAdrR LIKE :voieAdrR AND cpR LIKE :cpR AND villeR LIKE :villeR"
                        . " ORDER BY nomR";
                $stmt = Bdd::getConnexion()->prepare($requete);
                $motifNom = "%" . $extraitNomR . "%";
                $motifVoieAdrR = "%" . $voieAdrR . "%";
                $motifCpR = "%" . $cpR . "%";
                $motifVilleR = "%" . $villeR . "%";
                $stmt->bindParam(':nomR', $motifNom, PDO::PARAM_STR);
                $stmt->bindParam(':voieAdrR', $motifVoieAdrR, PDO::PARAM_STR);
                $stmt->bindParam(':cpR', $motifCpR, PDO::PARAM_STR);
                $stmt->bindParam(':villeR', $motifVilleR, PDO::PARAM_STR);
                $ok = $stmt->execute();
                // attention, $ok = true pour un select ne retournant aucune ligne
                if ($ok) {
                    // Pour chaque enregistrement
                    while ($enreg = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        //Instancier un nouveau restaurant et l'ajouter à la liste
                        $lesObjets[] = self::enregistrementVersObjet($enreg);
                    }
                }
            }
        } catch (PDOException $e) {
            throw new Exception("Erreur dans la méthode " . get_called_class() . "::getAllMultiCriteres : <br/>" . $e->getMessage());
        }
        return $lesObjets;
    }

    /**
     * Liste des restaurants aimés par un utilisateurdonné
     * N.B. : chargement de type "lazy"  : pour chaque restaurant, on ne chargera pas les critiques, les photos ni les types de cuisine proposés
     * @param int $idU id d'un utilisateur
     * @return array tableau d'objets Resto
     * @throws Exception transmission des erreurs PDO éventuelles
     */
    public static function getAimesByIdU(int $idU): array {
        $lesObjets = array();
        try {
            $requete = "SELECT resto.* FROM resto "
                    . " INNER JOIN aimer ON resto.idR = aimer.idR"
                    . " WHERE idU = :idU";
            $stmt = Bdd::getConnexion()->prepare($requete);
            $stmt->bindParam(':idU', $idU, PDO::PARAM_INT);
            $ok = $stmt->execute();
            // attention, $ok = true pour un select ne retournant aucune ligne
            if ($ok) {
                // Pour chaque enregistrement
                while ($enreg = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    //Instancier un nouveau restaurant et l'ajouter à la liste
                    $lesObjets[] = new Resto
                            (
                            $enreg['idR'], $enreg['nomR'], $enreg['numAdrR'], $enreg['voieAdrR'], $enreg['cpR'], $enreg['villeR'],
                            $enreg['latitudeDegR'], $enreg['longitudeDegR'], $enreg['descR'], $enreg['horairesR']
                    );
                }
            }
        } catch (PDOException $e) {
            throw new Exception("Erreur dans la méthode " . get_called_class() . "::getAimesByIdU : <br/>" . $e->getMessage());
        }
        return $lesObjets;
    }

    /**
     * Fabrique un objet restaurant à partir d'un enregistrement de la table resto
     * N.B. : chargement de type "lazy" pour casser le cycle suivant :
     * "un restaurant collectionne des critiques, une critique est émise par un utilisateur, un utilisateur aime des restaurants"
     * Donc, pour chaque critique,  on charge l'objet Utilisateur qui a émis la critique, mais sans ses restaurants aimés ni ses types de cuisine préférés
     * @param array $enreg
     * @return Resto
     */
    private static function enregistrementVersObjet(array $enreg): Resto {
        $id = $enreg['idR'];
        // Instanciation sans les associations
        $leResto = new Resto(
                $enreg['idR'], $enreg['nomR'], $enreg['numAdrR'], $enreg['voieAdrR'], $enreg['cpR'], $enreg['villeR'],
                $enreg['latitudeDegR'], $enreg['longitudeDegR'], $enreg['descR'], $enreg['horairesR']
        );
        // Objets associés   
        $lesCritiques = CritiqueDAO::getAllByResto($id);
        $lesPhotos = PhotoDAO::getAllByResto($id);
        $lesTcProposes = TypeCuisineDAO::getAllProposesByIdR($id);
        $leResto->setLesTypesCuisineProposes($lesTcProposes);
        $leResto->setLesPhotos($lesPhotos);
        $leResto->setLesCritiques($lesCritiques);

        return $leResto;
    }

}
