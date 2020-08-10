<?php


namespace App\Controllers;


use App\Models\AccountModel;
use App\Models\Entities\Facturation;
use App\Models\FacturationModel;

class AccountController extends AuthController
{
    /**
     * @throws \Exception
     */
    public function index()
    {
        $this->menu['comptes']['active'] = true;
        $this->menu['comptes']['sub']['list']['active'] = true;

        $students = (new AccountModel())->getStudents();
        $accounts = (new AccountModel())->getAll();
        $facturations = (new FacturationModel())->getAll();

        return $this->render('accounts.index', compact('students', 'accounts', 'facturations'));
    }


    public function store()
    {
        if (!$this->validate(
            [
                'etudiant' => 'required|integer|greater_than[0]',
                'facturation' => 'required|integer|greater_than[0]'
            ]
        )) {
            $this->flash('error', 'Saisie incorrecte');
            return redirect()->back();
        } else {
            $mod = new AccountModel();
            $found = ($mod)
                ->where('etudiant', $this->request->getVar('etudiant'))
                ->get()
                ->getResultArray();

            if (count($found) > 0) {
                $this->flash('error', 'Cet étudiant possède déjà un compte actif');
                return redirect()->back();
            } else {
                $this->flash('success', 'Compte ajouté avec succès');
                $mod->create($this->request->getVar('etudiant'), $this->request->getVar('facturation'));
                return redirect()->back();
            }
        }

    }

    public function edit()
    {

    }
}