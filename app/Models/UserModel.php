<?php

namespace App\Models;

use App\Models\Entities\User;
use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = "operateur";

    public function findByOperatorIDAndKey($id): ?User
    {
        $res = $this->db->query("
        SELECT o.photo,
            cle.cle,
            cle.idCleinstallation,
            pr.menu,
            idOperateur,
            numeroTelephone,
            numeroTelephone contact,
            changePasse,
            login,
            pr.profil,
            p.nom,
            p.prenoms,
            motDePasse,
            o.personel 
        FROM operateur o
        JOIN personel P ON p.idPersonel=o.personel 
        JOIN profil pr ON pr.idProfil=o.profil
        JOIN cleinstallation cle ON cle.operateur = o.idOperateur
            and cle.supprime=0
            and cle.actif=1
        WHERE o.bloquer=0
             and o.supprimer=0
             and o.idOperateur={$id}
             ")->getResultArray();

        if(count($res) == 0) return null;
        return new User($res[0]);
    }

    public function findByOperateurID($id): ?User
    {
        $res = $this->db->query("
        SELECT o.photo,
            pr.menu,
            idOperateur,
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
             and o.idOperateur={$id}
             ")->getResultArray();

        if(count($res) == 0) return null;

        return new User($res[0]);
    }

    public function findByLoginAndPassword(string $login, string $password): array
    {
        $res = $this->db->query("
        SELECT o.photo,
            idOperateur,
            numeroTelephone,
            numeroTelephone contact,
            changePasse,
            login,
            motDePasse,
            o.personel 
        FROM personel p,
            operateur o,
            profil pr 
        WHERE p.idPersonel=o.personel 
             and pr.idProfil=o.profil
             and o.bloquer=0
             and o.supprimer=0
             and login='" . $login . "' 
             and motDePasse=sha1('" . $password . "')");

        return $res->getResultObject();
    }

}