<?php


namespace App\Models;


use App\Models\Entities\Facturation;
use CodeIgniter\Model;

class FacturationModel extends Model
{
    protected $table = "facturation";
    protected $returnType = Facturation::class;

    /**
     * @return array|Facturation[]
     */
    public function getAll(): array
    {
        return $this->where('supprime', 0)->get()->getResult(Facturation::class);
    }
}