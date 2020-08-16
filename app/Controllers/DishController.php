<?php


namespace App\Controllers;


use App\Models\DishModel;
use App\Models\Entities\Dish;

class DishController extends AuthController
{
    public function index()
    {
        $dishes = (new DishModel)->getWhere(['supprime' => false])->getResult(Dish::class);

        $this->menu['resto']['active'] = true;
        $this->menu['resto']['sub']['dishes']['active'] = true;
        $this->render('dishes.index', compact('dishes'));
    }


    public function store()
    {
        if (!$this->validate(
            [
                'libelle' => 'required',
                'heureDebutSemaine' => 'required|validTime',
                'heureFinSemaine' => 'required|validTime',
                'heureDebutWeekend' => 'required|validTime',
                'heureFinWeekend' => 'required|validTime',
            ]
        )) {
            $this->flash('error', 'Saisie incorrecte');
            return redirect()->back();
        } else {

            $mod = new DishModel();
            $data = $this->request->getPost();
            $data['libelle'] = trim($data['libelle']);

            $mod->save($data);
            $this->flash('success', 'Repas ajouté avec succès');
            return redirect()->back();
        }
    }


    public function edit()
    {
        if (!$this->validate(
            [
                'edit_id' => 'required|integer|greater_than[0]',
                'libelle' => 'required',
                'heureDebutSemaine' => 'required|validTime',
                'heureFinSemaine' => 'required|validTime',
                'heureDebutWeekend' => 'required|validTime',
                'heureFinWeekend' => 'required|validTime',
            ]
        )) {
            $this->flash('error', 'Saisie incorrecte');
            return redirect()->back();
        } else {

            $mod = new DishModel();
            $data = $this->request->getPost();
            $data['libelle'] = trim($data['libelle']);
            $data['idRepas'] = $data['edit_id'];

            $mod->save($data);
            $this->flash('success', 'Repas modifié avec succès');
            return redirect()->back();
        }
    }

    public function delete()
    {
        if (!$this->validate(
            [
                'delete_id' => 'required|integer|greater_than[0]',
            ]
        )) {
            $this->flash('error', 'Saisie incorrecte');
            return redirect()->back();
        } else {

            $mod = new DishModel();
            $mod->save([
                'idRepas' => $this->getVar('delete_id'),
                'supprime' => true
            ]);
            $this->flash('success', 'Repas supprimé avec succès');
            return redirect()->back();
        }
    }
}