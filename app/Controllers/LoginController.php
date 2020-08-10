<?php


namespace App\Controllers;


use App\Auth\Auth;

class LoginController extends BaseController
{
    /**
     * @throws \Exception
     */
    public function index()
    {
        return $this->render('auth.login');
    }

    /**
     * @throws \Exception
     */
    public function login()
    {
//        dd($this->request);
        if (! $this->validate([
            'username' => 'required',
            'password'  => 'required'
        ])) {
            $this->message(['error' => 'Veuillez saisir toutes les informations']);
            return redirect()->route('index');
        } else {
            if(Auth::Login($this->request->getVar('username'), $this->request->getVar('password'))) {
                return redirect()->route('index');
            } else {
                $this->message(['error' => 'Informations de connexion Incorrectes']);
                return redirect()->route('login');
            }
        }
    }

    public function logout()
    {
        Auth::Logout();
        return redirect('login');
    }
}