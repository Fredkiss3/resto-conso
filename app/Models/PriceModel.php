<?php


namespace App\Models;


use CodeIgniter\Model;

class PriceModel extends Model
{
    protected $table = "prix";
    protected $primaryKey = "idPrix";
    protected $allowedFields = [
        'facturation',
        'repas',
        'montant',
        'actif',
    ];
}