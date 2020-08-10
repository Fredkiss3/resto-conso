<?php


namespace App\Models\Entities;
use CodeIgniter\Entity;

/**
 * @property string $nom
 * @property string $prenoms
 * @property string $photo
 * @property string $login
 * @property string $profil
 */
class User extends Entity
{

    public function getFullName()
    {
        return $this->nom . ' ' . $this->prenoms;
    }
}