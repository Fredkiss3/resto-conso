<?php


namespace App\Models;


use App\Models\Entities\Dish;
use App\Models\Entities\Facturation;
use App\Models\Entities\Price;
use CodeIgniter\Model;

class FacturationModel extends Model
{
    protected $table = "facturation";
    protected $returnType = Facturation::class;
    protected $primaryKey = "idFacturation";
    protected $allowedFields = [
        "libelle",
        "supprime"
    ];

    /**
     * @return array|Facturation[]
     */
    public function getAll(): array
    {
        $facturations = $this->getWhere(['supprime' => false])->getResult(Facturation::class);

        foreach ($facturations as $factu) {
            $factu->repas = $this->select('re.libelle, re.idRepas, pr.montant')
                ->from('repas re', true)
                ->join('prix pr', 'pr.repas=re.idRepas and pr.actif=1')
                ->join('facturation fa', "pr.facturation=fa.idFacturation
                                    and fa.idFacturation={$factu->idFacturation}")
                ->get()
                ->getResult(Dish::class);
        }

        return $facturations;
    }

    public function create(string $libelle, array $dishes)
    {
        $this->save([
            'libelle' => $libelle
        ]);

        $data = $this->findAll();

        /**
         * @var Facturation $last
         */
        $last = $data[count($data) - 1];

        $mod = new PriceModel;
//        $prices = ($mod)->getWhere(['facturation' => $last->idFacturation])->getResult(Price::class);
//
//        foreach ($prices as $pr) {
//            $pr->actif = false;
//            (new $mod)->save($pr);
//        }

        foreach ($dishes as $id => $amount) {
            ($mod)->save([
                'facturation' => $last->idFacturation,
                'repas' => $id,
                'montant' => $amount
            ]);
        }
    }

    public function edit(int $idFactu, string $label, array $dishes) : bool
    {
        /**
         * @var Facturation $factu
         */
        $factu = $this->find($idFactu);


        if ($factu) {
            if($factu->libelle != $label) {
                $factu->libelle = $label;
                $this->save($factu);
            }

            $mod = new PriceModel;
            $prices = ($mod)->getWhere(['facturation' => $factu->idFacturation, 'supprime' => false])->getResult(Price::class);

            foreach ($prices as $pr) {
                $pr->actif = false;
                (new $mod)->save($pr);
            }

            foreach ($dishes as $id => $amount) {
                ($mod)->save([
                    'facturation' => $factu->idFacturation,
                    'repas' => $id,
                    'montant' => $amount
                ]);
            }
        } else {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        return !is_null($factu);
    }

    public function remove(int $id)
    {
        /**
         * @var Facturation $factu
         */
        $factu = $this->find($id);
        $mod = new PriceModel;
        $prices = ($mod)->getWhere(['facturation' => $factu->idFacturation, 'supprime' => false])->getResult(Price::class);

        foreach ($prices as $pr) {
            $pr->actif = false;
            $pr->supprime = true;
            (new $mod)->save($pr);
        }
    }

    public function findOne(int $id): ?Facturation
    {
        /**
         * @var Facturation $factu
         */
        $factu = $this->find($id);

        if (!is_null($factu)) {
            $factu->repas = $this->select('re.libelle, re.idRepas, pr.montant')
                ->from('repas re', true)
                ->join('prix pr', 'pr.repas=re.idRepas')
                ->join('facturation fa', "pr.facturation=fa.idFacturation
                                    and fa.idFacturation={$factu->idFacturation}")
                ->get()
                ->getResult(Dish::class);
        }

        return $factu;
    }
}