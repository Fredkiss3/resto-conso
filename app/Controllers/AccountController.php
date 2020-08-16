<?php


namespace App\Controllers;


use App\Models\AccountModel;
use App\Models\Entities\Account;
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

        $this->render('accounts.index', compact('students', 'accounts', 'facturations'));
    }

    /**
     * Enregistrer
     * @return \CodeIgniter\HTTP\RedirectResponse
     * @throws \ReflectionException
     */
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
                ->getResult(Account::class);

            if (count($found) > 0) {
                /**
                 * @var Account $account
                 */
                $account = $found[0];
                if($account->supprime) {
                    $account->supprime = false;
                    $account->actif = true;
                    $account->facturation = $this->getVar('facturation');
                    $updated = ($mod)
                        ->save($account);

                    if($updated) {
                        $this->flash('success', 'Compte ajouté avec succès');
                        return redirect()->back();
                    } else {
                        $this->flash('error', 'Erreur ! Veuillez Recommencer');
                        return redirect()->back();
                    }
                } else {
                    $this->flash('warning', 'Cet étudiant possède déjà un compte');
                    return redirect()->back();
                }
            } else {
                $mod->create($this->request->getVar('etudiant'), $this->request->getVar('facturation'));
                $this->flash('success', 'Compte ajouté avec succès');
                return redirect()->back();
            }
        }

    }

    /**
     * Regénérer le code de facturation
     */
    public function reset()
    {
        if (!$this->validate(
            [
                'reset_id' => 'required|integer|greater_than[0]',
            ]
        )) {
            $this->flash('error', 'Erreur ! ce compte n\'existe pas, veuillez recommencer');
            return redirect()->back();
        } else {
            $mod = new AccountModel();
            $found = ($mod)
                ->where('idCompte', $this->getVar('reset_id'))
                ->get()
                ->getResult(Account::class);

            if (count($found) > 0) {
                /**
                 * @var Account $account
                 */
                $account = $found[0];
                $account->codeDeFacturation = $mod->generateCode();
                $updated = ($mod)
                    ->save($account);
                if ($updated) {
                    $this->flash('success', "Le code de facturation du compte a bien été réintialisé avec succès");
                } else {
                    $this->flash('error', "Erreur lors de la mise à jour du compte, veuillez recommencer");
                }
                return redirect()->back();
            } else {
                $this->flash('error', "Erreur, aucun compte correspondant n'a été trouvé veuillez recommencer");
                return redirect()->back();
            }
        }
    }

    /**
     * Modifier un compte
     */
    public function edit()
    {
        if (!$this->validate(
            [
                'edit_id' => 'required|integer|greater_than[0]',
                'facturation' => 'required|integer|greater_than[0]',
            ]
        )) {
            $this->flash('error', 'Erreur ! ce compte n\'existe pas, veuillez recommencer');
            return redirect()->back();
        } else {
            $mod = new AccountModel();
            $found = ($mod)
                ->where('idCompte', $this->getVar('edit_id'))
                ->get()
                ->getResult(Account::class);

            if (count($found) > 0) {
                /**
                 * @var Account $account
                 */
                $account = $found[0];
                $account->facturation = $this->getVar('facturation');
                $updated = ($mod)
                    ->save($account);
                if ($updated) {
                    $this->flash('success', "Compte Modifié avec succès");
                } else {
                    $this->flash('error', "Erreur lors de la mise à jour du compte, veuillez recommencer");
                }
                return redirect()->back();
            } else {
                $this->flash('error', "Erreur, aucun compte correspondant n'a été trouvé veuillez recommencer");
                return redirect()->back();
            }
        }
    }

    /**
     * Supprimer un compte
     */
    public function delete()
    {
        if (!$this->validate(
            [
                'delete_id' => 'required|integer|greater_than[0]',
            ]
        )) {
            $this->flash('error', 'Erreur, de saisie veuillez recommencer');
            return redirect()->back();
        } else {
            $mod = new AccountModel();
            $found = ($mod)
                ->where('idCompte', $this->getVar('delete_id'))
                ->get()
                ->getResult(Account::class);

            if (count($found) > 0) {
                /**
                 * @var Account $account
                 */
                $account = $found[0];
                $account->supprime = true;
                $updated = ($mod)
                    ->save($account);
                if ($updated) {
                    $this->flash('success', "Le compte a bien été supprimé");
                } else {
                    $this->flash('error', "Erreur lors de la suppression du compte veuillez recommencer");
                }
                return redirect()->back();
            } else {
                $this->flash('error', "Erreur ! le compte choisi n'a pas été trouvé, veuillez recommencer");
                return redirect()->back();
            }
        }
    }

    /**
     * Activer | Désactiver un compte
     * @return \CodeIgniter\HTTP\RedirectResponse
     * @throws \ReflectionException
     */
    public function toggle()
    {
        if (!$this->validate(
            [
                'toggle_id' => 'required|integer|greater_than[0]',
            ]
        )) {
            $this->flash('error', 'Erreur, veuillez recommencer');
            return redirect()->back();
        } else {
            $mod = new AccountModel();
            $found = ($mod)
                ->where('idCompte', $this->getVar('toggle_id'))
                ->get()
                ->getResult(Account::class);

            if (count($found) > 0) {
                /**
                 * @var Account $account
                 */
                $account = $found[0];
                $account->actif = !$account->actif;
                $updated = ($mod)
                    ->save($account);
                if ($updated) {
                    $this->flash('success', "Le compte a bien été "
                        . (!$account->actif ? "bloqué" : "débloqué") . " Avec succès");
                } else {
                    $this->flash('error', "Erreur, veuillez recommencer");
                }
                return redirect()->back();
            } else {
                $this->flash('error', "Erreur, veuillez recommencer");
                return redirect()->back();

//                $this->flash('success', 'Compte ajouté avec succès');
//                $mod->create($this->request->getVar('etudiant'), $this->request->getVar('facturation'));
//                return redirect()->back();
            }
        }
    }
}