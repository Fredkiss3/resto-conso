<?php


namespace App\Controllers;


use App\Models\DishModel;
use App\Models\Entities\Dish;
use App\Models\Entities\Facturation;
use App\Models\FacturationModel;

class FacturationController extends AuthController
{
    public function index()
    {
        $dishes = (new DishModel)->getWhere(['supprime' => false])->getResult(Dish::class);
        $facturations = (new FacturationModel)->getAll();


        $this->menu['resto']['active'] = true;
        $this->menu['resto']['sub']['facturations']['active'] = true;
        $this->render('facturations.index', compact('dishes', 'facturations'));
    }


    public function store()
    {
        if (!$this->validate(
            [
                'libelle' => 'required',
                'repas' => 'required|arrayInt',
            ]
        )) {
            $this->flash('error', 'Saisie incorrecte');
            return redirect()->back();
        } else {

            $mod = new FacturationModel;
            $data = $this->request->getPost();
            $data['libelle'] = trim($data['libelle']);

            $mod->create($data['libelle'], $data['repas']);
            $this->flash('success', 'Facturation ajoutée avec succès');
            return redirect()->back();
        }
    }

    public function edit()
    {
        if (!$this->validate(
            [
                'libelle' => 'required',
                'edit_id' => 'required|integer|greater_than[0]',
                'repas' => 'required|arrayInt',
            ]
        )) {
            $this->flash('error', 'Saisie incorrecte');
            return redirect()->back();
        } else {

            $mod = new FacturationModel;
            $data = $this->request->getPost();
            $data['libelle'] = trim($data['libelle']);

            $mod->edit($data['edit_id'], $data['libelle'], $data['repas']);
            $this->flash('success', 'Facturation modifiée avec succès');
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

            (new FacturationModel)->remove($this->getVar('delete_id'));
            $this->flash('success', 'Facturation supprimée avec succès');
            return redirect()->back();
        }
    }
}