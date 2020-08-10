<?php

namespace App\Controllers;

use App\Auth\Auth;

class HomeController extends AuthController
{
    /**
     * @throws \Exception
     */
    public function index()
    {
        $this->menu['dashboard']['active'] = true;

        $this->render('index');
    }

}
