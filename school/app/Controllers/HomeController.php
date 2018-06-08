<?php


namespace App\Controllers;

use App\Models\User; 
use App\Models\Students;
use \Slim\Views\Twig as View;

class HomeController extends Controller{

    public function index($request, $response){

        return $this->view->render($response, 'home.html');
    }
}
