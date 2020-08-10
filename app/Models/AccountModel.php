<?php


namespace App\Models;


use App\Models\Entities\Account;
use App\Models\Entities\Student;
use CodeIgniter\Model;

class AccountModel extends Model
{
    protected $table = 'compteresto';
    protected $returnType = Account::class;

    protected $allowedFields = ['facturation', 'etudiant', 'numeroCompte', 'codeDeFacturation'];


    /**
     * @return array|Account[]
     */
    public function getAll()
    {
        return $this->select('et.matriculeinphb, 
        et.idEtudiant,
         et.nom,
          et.prenoms,
           solde,
            fa.libelle,
             idCompte,
             codeDeFacturation,
              numeroCompte,
               actif')
            ->join('etudiants et', 'et.idEtudiant=etudiant')
            ->join('facturation fa', 'fa.idFacturation=facturation')
            ->get()
            ->getResult(Account::class);
    }

    /**
     * @return array|Student[]
     */
    public function getStudents(): array
    {
        $res = $this->db->query(
            "select  idEtudiant,
                an.anneeAcademique,
                et.matriculeinphb,
                et.photo,
                et.nom,
                et.prenoms
                from etudiants et,
                    cursus c,
                    -- formation fo,
                    anneeacademique an 
                where et.idEtudiant=c.etudiant 
                     -- and c.formation=fo.idFormation 
                      and  c.anneeAcademique = an.idAnneeAcademique
                       and an.statut = 1"
        )->getResultArray();

        $students = [];

        foreach ($res as $student) {
            $students[] = new Student(($student));
        }
        return $students;
    }

    private function generateNumeroCompte(): string
    {
        $prefix = date('y') . "CRES";

        $count = (string)(count($this->findAll()) + 1);

        $suffix = str_pad($count, 4, '0', STR_PAD_LEFT);

        return $prefix . $suffix;
    }

    private function generateCode(): string
    {
        return password_hash(date('Y-m-d H:m:s'), PASSWORD_BCRYPT);
    }

    /**
     * @param int $idEtudiant
     * @param int $facturation
     * @return bool
     * @throws \ReflectionException
     */
    public function create(int $idEtudiant, int $facturation): bool
    {

        if (count($this->where('supprime', 0)->where('etudiant', $idEtudiant)->get()->getResultArray()) > 0) return false;

        $data = [
            'facturation' => $facturation,
            'etudiant' => $idEtudiant,
            'numeroCompte' => $this->generateNumeroCompte(),
            'codeDeFacturation' => $this->generateCode(),
        ];

        return $this->save($data);
    }
}