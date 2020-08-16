<?php


namespace App\Controllers;


use App\Auth\Auth;
use App\Models\AccountModel;
use App\Models\RechargeModel;
use phpDocumentor\Reflection\Types\This;

class RechargeController extends AuthController
{
    public function index()
    {
        $accounts = (new AccountModel())->getAll();
        $this->menu['comptes']['active'] = true;
        $this->menu['comptes']['sub']['charge']['active'] = true;

        $this->render('recharge.index', compact('accounts'));
    }

    public function show()
    {
        $recharges = (new RechargeModel)->getAll();

//        dd($recharges);

        $this->menu['comptes']['active'] = true;
        $this->menu['comptes']['sub']['show']['active'] = true;
        $this->render('recharge.show', compact('recharges'));
    }

    public function submit()
    {
        $msg = "";

        if ($this->validate([
            'selected' => 'required',
            'somme' => 'required|integer|greater_than[499]'
        ])) {
            // Récupérer les éléments sélectionnés
            $selected = json_decode($this->getVar('selected'));
            $valid = true;
            foreach ($selected as $item) {
                if (!((int)$item >= 0)) {
                    $valid = false;
                    $msg = "Saisie invalide";
                    break;
                }
            }

            // If invalid
            if (!$valid) {
                $this->flash('error', $msg);
                return redirect()->back();
            } else {
                // Recharger tous les comptes sélectionnés
                $mod = new RechargeModel;
                $user = Auth::getUserAndKey();
                if (!is_null($user)) {

                    foreach ($selected as $item) {
                        $mod->create($user->idCleinstallation, $item, $this->getVar('somme'));
                    }

                    $this->flash('success', "Demande de rechargement envoyée avec succès");
                    return redirect()->back();
                } else {
                    $this->flash('error', "Vous n'avez pas de clé active, veuillez contacter l'administrateur pour vous en créer une");
                    return redirect()->back();
                }
            }
        } else {
            $this->flash('error', "Erreur lors de la saisie, veuillez recommencer");
            return redirect()->back();
        }
    }

    public function cancel()
    {
        $msg = "";

        if ($this->validate([
            'canceled' => 'required',
            'reason' => 'required',
        ])) {
            // Récupérer les éléments sélectionnés
            $selected = json_decode($this->getVar('canceled'));
            $valid = true;
            foreach ($selected as $item) {
                if (!((int)$item >= 0)) {
                    $valid = false;
                    $msg = "Saisie invalide";
                    break;
                }
            }

            // If invalid
            if (!$valid) {
                $this->flash('error', $msg);
                return redirect()->back();
            } else {
                // Recharger tous les comptes sélectionnés
                $mod = new RechargeModel;
                $user = Auth::getUserAndKey();
                if (!is_null($user)) {

                    foreach ($selected as $item) {
                        $mod->cancel($item, $this->getVar('reason'));
                    }

                    $this->flash('success', "les rechargements ont bien été annulés");
                    return redirect()->back();
                } else {
                    $this->flash('error', "Vous n'avez pas de clé active, veuillez contacter l'administrateur pour vous en créer une");
                    return redirect()->back();
                }
            }
        } else {
            $this->flash('error', "Erreur lors de la saisie, veuillez recommencer");
            return redirect()->back();
        }
    }

    public function accept()
    {
        $msg = "";

        if ($this->validate([
            'accepted' => 'required',
        ])) {
            // Récupérer les éléments sélectionnés
            $selected = json_decode($this->getVar('accepted'));
            $valid = true;
            foreach ($selected as $item) {
                if (!((int)$item >= 0)) {
                    $valid = false;
                    $msg = "Saisie invalide";
                    break;
                }
            }

            // If invalid
            if (!$valid) {
                $this->flash('error', $msg);
                return redirect()->back();
            } else {
                // Recharger tous les comptes sélectionnés
                $mod = new RechargeModel;
                $user = Auth::getUserAndKey();
                if (!is_null($user)) {

                    foreach ($selected as $item) {
                        $mod->accept($item);
                    }

                    $this->flash('success', "les comptes ont bien été rechargés");
                    return redirect()->back();
                } else {
                    $this->flash('error', "Vous n'avez pas de clé active, veuillez contacter l'administrateur pour vous en créer une");
                    return redirect()->back();
                }
            }
        } else {
            $this->flash('error', "Erreur lors de la saisie, veuillez recommencer");
            return redirect()->back();
        }
    }
}