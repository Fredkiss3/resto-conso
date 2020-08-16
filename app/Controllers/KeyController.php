<?php


namespace App\Controllers;


use App\Models\Entities\CleInstallation;
use App\Models\KeyModel;

class KeyController extends AuthController
{
    public function index()
    {
        $this->menu['keys']['active'] = true;
        $this->menu['keys']['sub']['list']['active'] = true;

        $operateurs = (new KeyModel)->getOperators();
        $keys = (new KeyModel)->getAll();
        $this->render('keys.index', compact('operateurs', 'keys'));
    }

    public function store()
    {
        if (!$this->validate([
            'operateur' => 'required|integer|greater_than[0]'
        ])) {
            $this->flash('error', 'Saisie incorrecte');
            return redirect()->back();
        } else {
            $mod = new KeyModel;
            if (count($mod->where('supprime', 0)->where('operateur', $this->getVar('operateur'))->get()->getResultArray()) > 0) {
                $this->flash('warning', 'Cet opérateur possède déjà une clé');
                return redirect()->back();
            } else {
                $mod->create($this->getVar('operateur'));
                $this->flash('success', 'Clé créée avec succès');
                return redirect()->back();
            }
        }
    }

    /**
     * Supprimer une clé
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
            $mod = new KeyModel();
            /**
             * @var CleInstallation
             */
            $found = ($mod)->find($this->getVar('delete_id'));

            if (!is_null($found)) {
                $found->supprime = true;
                $updated = ($mod)
                    ->save($found);
                if ($updated) {
                    $this->flash('success', "La clé a bien été supprimé");
                } else {
                    $this->flash('error', "Erreur lors de la suppression de la clé veuillez recommencer");
                }
                return redirect()->back();
            } else {
                $this->flash('error', "Erreur ! veuillez recommencer");
                return redirect()->back();
            }
        }
    }

    /**
     * Activer | Désactiver une clé
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
            $this->flash('error', 'Erreur lors de la saisie, veuillez recommencer');
            return redirect()->back();
        } else {
            $mod = new KeyModel();
            /**
             * @var CleInstallation $found
             */
            $found = ($mod)
                ->find( $this->getVar('toggle_id'));

            if (!is_null($found)) {
                $found->actif = !$found->actif;
                $updated = ($mod)
                    ->save($found);
                if ($updated) {
                    $this->flash('success', "La clé a bien été "
                        . (!$found->actif ? "désactivée" : "activée") . " Avec succès");
                } else {
                    $this->flash('error', "Erreur, veuillez recommencer");
                }
                return redirect()->back();
            } else {
                $this->flash('error', "Erreur, veuillez recommencer");
                return redirect()->back();
            }
        }
    }
}