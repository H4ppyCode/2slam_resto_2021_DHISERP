<?php
namespace modele\metier;

/**
 * Description of TypeCuisine
 *
 * @author N. Bourgeois
 */

class TypeCuisine {
    private int $idTC;
    private string $libelleTC;
    
    function __construct(int $idTC, string $libelleTC) {
        $this->idTC = $idTC;
        $this->libelleTC = $libelleTC;
    }

    function getIdTC(): int {
        return $this->idTC;
    }

    function getLibelleTC(): string {
        return $this->libelleTC;
    }

    function setIdTC(int $idTC): void {
        $this->idTC = $idTC;
    }

    function setLibelleTC(string $libelleTC): void {
        $this->libelleTC = $libelleTC;
    }


}
