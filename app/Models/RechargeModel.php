<?php


namespace App\Models;


use App\Models\Entities\Account;
use App\Models\Entities\Recharge;
use CodeIgniter\Model;

class RechargeModel extends Model
{
    protected $table = "recharge";
    protected $primaryKey = "idRecharge";
    protected $returnType = Recharge::class;

    protected $allowedFields = [
        "compteresto",
        "cleinstallation",
        "montant",
        "statut",
        "commentaireAnnulation",
        "dateValidation",
    ];

    /**
     * @return Recharge[]
     */
    public function getAll(): array
    {

        $data = $this->select("
                re.idRecharge,
                 re.montant,
                  re.dateRequete, 
                  et.matriculeinphb, 
                    et.idEtudiant,
                     et.nom,
                      et.prenoms,
                      p.nom nomPersonnel,
                      p.prenoms prenomPersonnel
                      ")
            ->from('recharge as re', true)
            ->join('cleinstallation cle', "cle.idCleinstallation=re.cleinstallation")
            ->join('operateur o', "cle.operateur = o.idOperateur")
            ->join('personel p', "p.idPersonel=o.personel")
            ->join('compteresto co', "co.idCompte=re.compteresto")
            ->join('etudiants et', 'et.idEtudiant=co.etudiant')
            ->where(["statut" => false])
            ->get()
//            ->getResultArray();
            ->getResult(Recharge::class);

        return $data;
    }

    public function create(string $key, int $idCompte, int $somme)
    {
        $data = [
            'compteresto' => $idCompte,
            'montant' => $somme,
            'cleinstallation' => $key,
        ];

        $this->where(['compteresto' => $idCompte, 'statut' => 0])->delete();

        return $this->save($data);
    }

    public function accept(int $idRecharge)
    {
        $recharge = $this->find($idRecharge);

        if ($recharge) {
            /**
             * @var Account $account
             */
            $account = (new AccountModel)->find($recharge->compteresto);

            if ($account) {
                $account->solde += $recharge->montant;

                (new AccountModel)->save($account);

//                d($account, $recharge, $idRecharge);

                $recharge->statut = true;
                $recharge->dateValidation = date('Y-m-d H:i:s');
                $this->save($recharge);
            }
        }

    }

    public function cancel(int $idRecharge, string $reason)
    {
        $recharge = $this->find($idRecharge);
        if ($recharge) {
            $recharge->commentaireAnnulation = $reason;
            $recharge->statut = true;
            $recharge->dateValidation = date('Y-m-d H:i:s');
            $this->save($recharge);
        }
    }
}