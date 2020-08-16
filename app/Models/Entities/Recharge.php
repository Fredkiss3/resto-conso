<?php


namespace App\Models\Entities;


use CodeIgniter\Entity;

class Recharge extends Entity
{
    public function getDate(): string
    {
        $date = date_create_from_format('Y-m-d H:i:s', $this->dateRequete);
        return $date->format('d/m/Y');
    }
}