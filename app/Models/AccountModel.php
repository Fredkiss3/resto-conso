<?php


namespace App\Models;


use App\Models\Entities\Account;
use App\Models\Entities\Consommation;
use App\Models\Entities\Student;
use CodeIgniter\Model;
use Kint\Parser\DOMDocumentPlugin;

class AccountModel extends Model
{
    protected $table = 'compteresto';
    protected $returnType = Account::class;
    protected $primaryKey = "idCompte";
    protected $allowedFields = [
        'facturation',
        'etudiant',
        'numeroCompte',
        'codeDeFacturation',
        'actif',
        'solde',
        'version',
        'supprime',
        'facturation',
    ];

    public function getFilterData(array $filters): array
    {
        $filterSafe = [];
        $data = [];

        // Escape data to prevent SQL Injection
        foreach ($filters as $key => $val) {
            if ((int)$val > 1) {
                $filterSafe[$key] = $val;
            }
        }


        $filters = $filterSafe;

        if (!empty($filters['annee'])) {
            $annees = $this->select('anneeacademique')
                ->from('anneeacademique', true)
                ->where(['supprimer' => 0, 'idAnneeAcademique' => $filters['annee']])
                ->get()
                ->getResultArray();

//            d($annees->getCompiledSelect());

            if (count($annees) > 0) {
                $data['année académique'] = $annees[0]['anneeacademique'];
            }
        }

        if (!empty($filters['trimestre'])) {
            $trimestres = $this->select('tr.libelle,
                tr.idTrimestre,
                 tra.dateDebut,
                 tra.anneeacademique, 
                    tra.dateFin')
                ->distinct()
                ->from('trimestre tr', true)
                ->where([
                    'tr.supprime' => false,
                    'tra.supprime' => false,
                    'tr.idTrimestre' => $filters['trimestre']
                ])
                ->join('trimestreannee tra', 'tra.trimestre=tr.idTrimestre')
                ->get()
                ->getResultArray();

            if (count($trimestres) > 0) {
                $data['trimestre'] = $trimestres[0]['libelle'];
            }
        }

        if (!empty($filters['ecole'])) {
            $schools = $this->select('ec.codeEcole, ec.ecole, ec.idEcole')
                ->from('ecole ec', true)
                ->where(['supprimer' => 0,
                    'ec.idEcole' => $filters['ecole']])
                ->get()
                ->getResultArray();

            if (count($schools) > 0) {
                $data['école'] = $schools[0]['ecole'];
            }
        }


        if (!empty($filters['filiere'])) {
            $filieres = $this->select('f.codeFiliere, f.filiere, f.idFiliere, f.ecole')
                ->from('filiere f', true)
                ->where(['supprimer' => 0, 'f.idFiliere' => $filters['filiere']])
                ->get()
                ->getResultArray();

            if (count($filieres) > 0) {
                $data['filière'] = $filieres[0]['filiere'];
            }
        }


        if (!empty($filters['specialite'])) {
            $specialites = $this->select('spe.codeSpecialite, spe.specialite, spe.idSpecialite, spe.filiere')
                ->from('specialite spe', true)
                ->where(['supprimer' => 0, 'spe.idSpecialite' => $filters['specialite']])
                ->get()
                ->getResultArray();

            if (count($specialites) > 0) {
                $data['spécialité'] = $schools[0]['specialite'];
            }
        }


        if (!empty($filters['niveau'])) {
            $niveaux = $this->select('
              ni.codeNiveau,
              ni.niveau,
              ni.idNiveau
          ')
                ->distinct()
                ->from('niveau ni', true)
                ->where(['supprimer' => 0, 'ni.idNiveau' => $filters['niveau']])
                ->get()
                ->getResultArray();

            if (count($niveaux) > 0) {
                $data['niveau'] = $niveaux[0]['niveau'];
            }
        }


        if (!empty($filters['cycle'])) {
            $cycles = $this->select('cy.idCycle, 
                cy.codeCycle, cy.cycle')
                ->from('cycle cy', true)
                ->where(['cy.supprimer' => 0, 'cy.idCycle' => $filters['cycle']])
                ->get()
                ->getResultObject();

            if (count($cycles) > 0) {
                $data['cycle'] = $cycles[0]['cycle'];
            }
        }

        if (!empty($filters['nationalite'])) {
            $nationalites = $this->select('p.nationalite, p.idPays')
                ->from('pays p', true)
                ->where(['supprimer' => 0, 'p.idPays' => $filters['nationalite']])
                ->get()
                ->getResultArray();

            if (count($nationalites) > 0) {
                $data['nationalite'] = $nationalites[0]['nationalite'];
            }
        }

        return $data;
    }


    /**
     * @param array $filters
     * @return array|bool
     */
    public function filter(array $filters)
    {
        $results = [];
        $filterSafe = [];

        // Escape data to prevent SQL Injection
        foreach ($filters as $key => $val) {
            if ((int)$val > 1) {
                $filterSafe[$key] = $this->db->escape($val);
            }
        }

        $filters = $filterSafe;

        if (!empty($filters['annee']) and !empty($filters['trimestre'])) {

            $periodSql = "SELECT tra.dateDebut, tra.dateFin
                   FROM trimestre tr
                       JOIN anneeacademique an
                        JOIN trimestreannee tra
                            on tra.trimestre=tr.idTrimestre
                            and tra.anneeacademique=an.idAnneeAcademique
                            and an.idAnneeAcademique={$filters["annee"]}
                            and tr.idTrimestre={$filters["trimestre"]}";

            $res = $this->db->query($periodSql)->getResultObject();

            if (count($res) > 0) {
                $period = $res[0];

                $sql = "SELECT ANY_VALUE(cr.idCompte) as coID,
			ANY_VALUE(et.nom) as nom,
			ANY_VALUE(et.matriculeInphb) as matriculeInphb,
			ANY_VALUE(et.prenoms) as prenoms,
				MAX(total.total) as totalConso
								FROM 
								  compteresto cr 
	                       JOIN (
	
								  	 SELECT 
										 MAX(cp.idCompte) id,
										 SUM(pri.montant) as total
										 FROM prix pri
										 join compteresto cp
										 join consommation con
										 	on con.compteresto=cp.idCompte
										 	and pri.idPrix=con.prix
										 	group by cp.idCompte
								 ) as total
								  on total.id=cr.idCompte
								  JOIN consommation conso
								   on conso.compteresto=cr.idCompte
	                       JOIN etudiants et 
	                        ON et.idEtudiant=cr.etudiant
	                       	and conso.dateEtHeure >= \"{$period->dateDebut}\"
	                       	and conso.dateEtHeure <= \"{$period->dateFin}\"
	                        ";

                if (!empty($filters['nationalite'])) {
                    $sql .= " JOIN pays p 
								  	on p.idPays=et.nationalite
	                       	and p.idPays={$filters['nationalite']}";
                }

                $sql .= " JOIN cursus cu on cu.etudiant=et.idEtudiant
                                    and cu.anneeAcademique={$filters["annee"]}
                            JOIN cycle cy
                            JOIN formation fo on fo.idFormation=cu.formation
                                and fo.cycle=cy.idCycle 
                           ";

                if (!empty($filters['ecole'])) {
                    $sql .= " JOIN ecole ec
                             JOIN cycleecole ce
                                ON ce.ecole=ec.idEcole
                                and ce.cycle=cy.idCycle
                                and ec.idEcole={$filters['ecole']}";
                }


                if (!empty($filters['cycle'])) {
                    $sql .= " and cy.idCycle={$filters['cycle']}";
                }

                $sql .= " JOIN specialite spe on fo.specialite=spe.idSpecialite";

                if (!empty($filters['filiere'])) {
                    $sql .= " JOIN filiere fi on spe.filiere=fi.idFiliere
	  	                        and fi.idFiliere={$filters['filiere']}";
                }


                if (!empty($filters['specialite'])) {
                    $sql .= " and spe.idSpecialite={$filters['specialite']}";
                }

                if (!empty($filters['niveau'])) {
                    $sql .= "  JOIN niveau niv on fo.niveau=niv.idNiveau 
                                and niv.idNiveau={$filters['niveau']} ";
                }

                // add last statement
                $sql .= "  group by coID";
            }

            $results = $this->db->query($sql)->getResult(Consommation::class);
        } else {
            return false;
        }

        return $results;
    }

    public function getFilters()
    {
        $annees = $this->select('idAnneeAcademique, anneeacademique')
            ->from('anneeacademique', true)
            ->where(['supprimer' => 0])
            ->get()
            ->getResultObject();

        $trimestres = $this->select('
                tr.libelle,
                 tr.idTrimestre')
            ->distinct()
            ->from('trimestre tr', true)
            ->join('trimestreannee tra', 'tra.trimestre=tr.idTrimestre')
            ->where(['tra.supprime' => false])
            ->where(['tr.supprime' => false])
            ->get()
            ->getResultObject();

        $nationalites = $this->select('p.nationalite, p.idPays')
            ->from('pays p', true)
            ->where(['supprimer' => 0])
            ->get()
            ->getResultObject();

        $schools = $this->select('ec.codeEcole, ec.ecole, ec.idEcole')
            ->from('ecole ec', true)
            ->where(['supprimer' => 0])
            ->get()
            ->getResultObject();

        $filieres = $this->select('f.codeFiliere, f.filiere, f.idFiliere, f.ecole')
            ->from('filiere f', true)
            ->where(['supprimer' => 0])
            ->get()
            ->getResultObject();

        $specialites = $this->select('spe.codeSpecialite, spe.specialite, spe.idSpecialite, spe.filiere')
            ->from('specialite spe', true)
            ->where(['supprimer' => 0])
            ->get()
            ->getResultObject();

        $cycles = $this->select('cy.idCycle, 
                cy.codeCycle, cy.cycle')
            ->from('cycle cy', true)
            ->where(['cy.supprimer' => 0])
            ->get()
            ->getResultObject();

        $niveaux = $this->select('
              ni.codeNiveau,
              ni.niveau,
              ni.idNiveau
          ')
            ->distinct()
            ->from('niveau ni', true)
            ->where(['supprimer' => 0])
            ->get()
            ->getResultObject();


        return compact('annees',
            'trimestres',
            'nationalites',
            'schools',
            'filieres',
            'specialites',
            'niveaux',
            'cycles'
        );
    }


    /**
     * @param Account $data
     * @return bool
     * @throws \ReflectionException
     */
    public function save($data): bool
    {
        $data->version = (int)$data->version + 1;

        return parent::save($data);
    }

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
            fa.libelle as libelleFacturation,
            fa.idFacturation as facturation,
             idCompte,
             codeDeFacturation,
              numeroCompte,
               actif')
            ->from('compteresto as co', true)
            ->join('etudiants et', 'et.idEtudiant=etudiant')
            ->join('facturation fa', 'fa.idFacturation=facturation')
            ->where('co.supprime=0')
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

    public function generateCode(): string
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