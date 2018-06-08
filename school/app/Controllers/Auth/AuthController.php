<?php

namespace App\Controllers\Auth;

use App\Models\User;
use App\Models\Student;
use App\Controllers\Controller;
use Respect\Validation\Validator as v;

class AuthController extends Controller{

    public function getSignOut($request, $response){
        $this->auth->logout();
         
        return $response->withRedirect($this->router->pathFor('home'));
    } 

    public function getSignIn($request, $response){
        return $this->view->render($response,'auth/signin.html');
    }

    public function postSignIn($request, $response){
     
        $validation = $this->validator->validate($request,[
            'email'    => v::noWhitespace()->notEmpty()->email(),            
            'password' => v::noWhitespace()->notEmpty() 
        ]);     

        if ($validation->failed()){
            return $response->withRedirect($this->router->pathFor('auth.signin'));
        }        
     
        $auth = $this->auth->attempt(
            $request->getParam('email'),
            $request->getParam('password')
        );

        if(!$auth){
            return $response->withRedirect($this->router->pathFor('auth.signin'));
        }

        $student = $this->db::select('select name, email, phone from students where 1');
        $course = $this->db::select('select name, description from course where 1');
        
        return $response->withRedirect($this->router->pathFor('tmpl.home.admin'));
    }

    public function getSignUp($request, $response){

        return $this->view->render($response, 'auth/signup.html');

    }

    public function postSignUp($request, $response){
      
        $validation = $this->validator->validate($request,[
            'email'    => v::noWhitespace()->notEmpty()->email()->EmailAvailable(),
            'name'     => v::notEmpty()->alpha(),
            'password' => v::noWhitespace()->notEmpty(),
            'phone'    => v::noWhitespace()->notEmpty(), 
            'role'     => v::noWhitespace()->notEmpty()
        ]);

        if ($validation->failed()){
            return $response->withRedirect($this->router->pathFor('auth.signup'));
        }

        $user = User::create([
        'email'    => $request->getParam('email'),
        'name'     => $request->getParam('name'),
        'password' => password_hash($request->getParam('password'), PASSWORD_DEFAULT),
        'phone'    => $request->getParam('phone'),
        'role'     => $request->getParam('role')
        ]);

        return $response->withRedirect($this->router->pathFor('tmpl.home.admin'));
    }

}
