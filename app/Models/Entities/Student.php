<?php


namespace App\Models\Entities;


use CodeIgniter\Entity;

/**
 * Class Student
 * @package App\Models\Entities
 * @property int $idEtudiant
 * @property string $matriculeInphb
 * @property string $nom
 * @property string $prenoms
 */
class Student extends Entity
{
    public function getFullName()
    {
        return $this->nom . ' ' . $this->prenoms;
    }
}