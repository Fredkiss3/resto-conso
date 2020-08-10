<?php

namespace App\Auth;

use App\Models\Entities\User;
use App\Models\UserModel;

class Auth
{
    public static function Logout(): void
    {
        session()->remove('userID');
    }

    public static function Login(string $username, string $password): bool
    {
        $res = (new UserModel())->findByLoginAndPassword($username, $password);

        if(count($res) == 1) {
            session()->set([ 'userID' => $res[0]->idOperateur]);
            session()->markAsTempdata('userID', 3600);
        }

        return count($res) == 1;
    }

    public static function getUser(): ?User
    {
        if(!self::Check()) return null;
        return (new UserModel())->findByOperateurID(session('userID'));
    }

    public static function Check() : bool
    {
        return session()->has('userID');
    }

}