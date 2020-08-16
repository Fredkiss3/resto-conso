<?php


namespace App\Controllers;


use App\Models\AccountModel;

class SummaryController extends AuthController
{
    public function index()
    {
        $filters = (new AccountModel)->getFilters();
        $this->menu['resto']['active'] = true;
        $this->menu['resto']['sub']['summary']['active'] = true;
        $this->render('summary.index', $filters);
    }

    public function show()
    {
        $consommations = (new AccountModel)->filter($this->request->getGet());

        if(!$consommations) {
            $this->flash('warning', "Veuillez choisir une année, ainsi qu'un trimestre pour effectuer le bilan");
            return redirect()->back();
        }

        $filterData = (new AccountModel)->getFilterData($this->request->getGet());



        $this->menu['resto']['active'] = true;
        $this->menu['resto']['sub']['summary']['active'] = true;

        $this->render('summary.show', compact("consommations", 'filterData'));
    }
}