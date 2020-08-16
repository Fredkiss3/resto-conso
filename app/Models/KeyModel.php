<?php


namespace App\Models;


use App\Models\Entities\CleInstallation;
use App\Models\Entities\Opertator;
use CodeIgniter\Model;

class KeyModel extends Model
{
    protected $table = "cleinstallation";
    protected $returnType = CleInstallation::class;
    protected $primaryKey = "idCleinstallation";
    protected $allowedFields = [
        "operateur",
        "cle",
        "actif",
        'supprime',
    ];

    /**
     * @return array|Opertator[]
     */
    public function getOperators()
    {
        $res = $this->db->query(
            "SELECT o.photo,
            pr.menu,
            o.idOperateur,
            numeroTelephone,
            numeroTelephone contact,
            changePasse,
            login,
            pr.profil,
            p.nom,
            p.prenoms,
            motDePasse,
            o.personel 
        FROM personel p,
            operateur o,
            profil pr 
        WHERE p.idPersonel=o.personel 
             and pr.idProfil=o.profil
             and o.bloquer=0
             and o.supprimer=0
             and pr.profil='admin'
             OR pr.profil='restauration'
             OR pr.profil='comptabilite'
             "
        )->getResultArray();

        $data = [];

        foreach ($res as $operator) {
            $data[] = new Opertator(($operator));
        }

        return $data;
    }

    /**
     * @return array|CleInstallation[]
     */
    public function getAll()
    {
        $res = $this->db->query(
            "SELECT o.photo,
            cle.idCleinstallation,
            cle.cle,
            cle.actif,
            pr.menu,
            o.idOperateur,
            numeroTelephone,
            numeroTelephone contact,
            changePasse,
            login,
            pr.profil,
            p.nom,
            p.prenoms,
            motDePasse,
            o.personel 
        FROM personel p,
            operateur o,
            profil pr,
            cleinstallation cle
        WHERE p.idPersonel=o.personel 
             and pr.idProfil=o.profil
             and o.bloquer=0
             and o.supprimer=0
             and cle.supprime=0
             and cle.operateur=o.idOperateur
             "
        )->getResultArray();

        $keys = [];
        foreach ($res as $key) {
            $keys[] = new CleInstallation(($key));
        }

        return $keys;
    }

    private function genKey()
    {
        $prefix = date('y') . "RES"; // 20RESxxxx
        $suffix = password_hash(date('Y-m-d H:m:s'), PASSWORD_BCRYPT);
        $suffix = substr($suffix, 15, 4);

        return $prefix . $suffix;
    }

    /**
     * @param int $idOperateur
     * @return bool
     * @throws \ReflectionException
     */
    public function create(int $idOperateur): bool
    {
        if (count($this->where('supprime', 0)->where('operateur', $idOperateur)->get()->getResultArray()) > 0) return false;

        $user = (new UserModel)->findByOperateurID($idOperateur);

        if($user) {
            $data = [
                'operateur' => $idOperateur,
                'cle' => $this->genKey(),
            ];
            return $this->save($data);
        } else {
            return false;
        }
    }

}