<?php


namespace App\Models\Entities;


use CodeIgniter\Entity;

class Dish extends Entity
{
    public function getTime(string $field)
    {
        $date = date_create_from_format('H:i:s', $this->$field);
        return $date->format('H:i');
    }
}