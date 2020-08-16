<?php


namespace App\Models\Entities;


use CodeIgniter\Entity;

/**
 * Class Account
 * @package App\Models\Entities
 * @property string $nom
 * @property int $idCompte
 * @property string $prenoms
 * @property string $matriculeInphb
 * @property int $facturation
 * @property string $libelleFacturation
 * @property string $codeDeFacturation
 * @property string $numeroCompte
 * @property int $solde
 * @property int $version
 * @property bool $actif
 * @property bool $supprime
 */
class Account extends Entity
{

    public function getFullName()
    {
        return $this->nom . ' ' . $this->prenoms;
    }
}