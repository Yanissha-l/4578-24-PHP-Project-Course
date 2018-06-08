<?php

namespace App\Middleware;

class ValidationErrorsMiddleware extends Middleware{

     public function __invoke($request, $response, $next){
        
        if(empty($_SESSION['errors'])){
            $_SESSION['errors'] = true;
        }

        $this->container->view->getEnvironment()->addGlobal('errors', $_SESSION['errors']);
        $_SESSION['errors'] = $request->getParams();

        $response = $next($request, $response);
        return $response;        
     }
}