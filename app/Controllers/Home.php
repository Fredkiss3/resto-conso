<?php namespace App\Controllers;

class Home extends BaseController
{
    /**
     * @throws \Exception
     */
	public function index()
	{
//		return view('welcome_message');
        $this->render('welcome');
	}

	//--------------------------------------------------------------------

}
