<?php

namespace App\Controllers;

use eftec\bladeone\BladeOne;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 *
 * @package CodeIgniter
 */

use CodeIgniter\Controller;

class BaseController extends Controller
{

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var array
     */
    protected $helpers = [];

    /**
     * @var BladeOne
     */
    protected $blade;

    public function message(array $data)
    {
        session()->set('message', $data);
        session()->markAsFlashdata('message');
    }

    public function flash(string $type, string $message)
    {
        session()->set('flash', [
            'type' => $type,
            'message' => $message
        ]);
        session()->markAsFlashdata('flash');
    }

    /**
     * Constructor.
     */
    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        helper(['html', 'form']);


        //--------------------------------------------------------------------
        // Preload any models, libraries, etc, here.
        //--------------------------------------------------------------------
        // E.g.:
        $views = dirname(__DIR__) . '/Views';
        $cache = dirname(__DIR__) . '/cache';
        $this->blade = new BladeOne($views, $cache, BladeOne::MODE_DEBUG); // MODE_DEBUG allows to pinpoint troubles.
    }

    /**
     * @param string|null $viewPath
     * @param array $data
     * @throws \Exception
     */
    public function render(?string $viewPath = null, array $data = [])
    {
        $data = $this->preRender($data);
        echo $this->blade->run($viewPath, $data);
        return;
    }

    public function renderJson($data)
    {
        echo json_encode($data);
        return;
    }

    protected function preRender(array $data = []): array
    {
        $data['message'] = session('message');
        $data['flash'] = session('flash');
        return $data;
    }

    /**
     * @param string $key
     * @return mixed
     */
    protected function getVar(string $key)
    {
        return $this->request->getVar($key);
    }

    /**
     * @param string $key
     * @return mixed
     */
    protected function getJSON()
    {
        return $this->request->getJSON();
    }

    /**
     * Vérifier si c'est bien une requête Post
     * @return bool
     */
    public function isPost()
    {
        return $this->request->getMethod(true) == "POST";
    }

}
