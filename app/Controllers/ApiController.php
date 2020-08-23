<?php

namespace App\Controllers;

use App\Auth\Auth;
use App\Models\KeyModel;

class ApiController extends BaseController
{
    /**
     * @throws \Exception
     */
    public function install()
    {
     	if(!$this->validate([
     		'cle' => "required"
     	])) {

     		$this->renderJson([
     			"error" => true,
     			"message" => "La clé est requise"
     		]);

     	}  else {
     		$res = (new KeyModel)->validInstall($this->getVar('cle'));
     // 		$this->renderJson([
		 		// 	"error" => false,
		 		// 	"message" => "Clé validée avec succès !",
		 		// 	'data' => $res
		 		// ]);

     		if($res == false) {
     			$this->renderJson([
		 			"error" => true,
		 			"message" => "La clé '{$this->getVar('cle')}' est invalide"
		 		]);
     		} else {
				$this->renderJson([
		 			"error" => false,
		 			"message" => "Clé validée avec succès !",
		 			'data' => $res
		 		]);
     		}
     	}
    }

    public function sync()
    {
       
    }

}