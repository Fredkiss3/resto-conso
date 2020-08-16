<?php


namespace App\Models;


use App\Models\Entities\Dish;
use CodeIgniter\Model;

class DishModel extends Model
{
    protected $table = "repas";
    protected $primaryKey = "idRepas";
    protected $allowedFields = [
        "libelle",
        "heureDebutSemaine",
        "heureFinSemaine",
        "heureDebutWeekend",
        "heureFinWeekend",
        "supprime",
    ];

    protected $returnType = Dish::class;
}