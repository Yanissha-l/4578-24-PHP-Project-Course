<?php

namespace App\Controllers\Auth;

use App\Models\User;
use App\Models\Student;
use App\Models\Course;
use App\Models\Study;
use App\Models\Study_Plan;
use App\Controllers\Controller; 
use App\Auth\UtilsController as util;
use Respect\Validation\Validator as v;
use \Slim\Views\Twig as View;

class AdminController extends Controller{

    public function getAdminDetails($request, $response){

        $admin = $this->db::select('select id, name, email, phone, role, image from administrators where 1');
        $owner_sum = $this->db::table('administrators')->where('role', '=', 'owner')->count();
        $manager_sum = $this->db::table('administrators')->where('role', '=', 'manager')->count();
        $sale_sum = $this->db::table('administrators')->where('role', '=', 'sale')->count();

        return $this->view->render($response,'/auth/contextadmin.html', [
            'admin' => $admin,
            'owner_sum'  => $owner_sum,
            'manager_sum' => $manager_sum,
            'sale_sum' => $sale_sum
        ]);
    }

    public function postAdminCreate($request, $response){
      
        $validation = $this->validator->validate($request,[
            'email'    => v::noWhitespace()->notEmpty()->email()->EmailAvailable(),
            'name'     => v::notEmpty()->alpha(),
            'password' => v::noWhitespace()->notEmpty(),
            'phone'    => v::noWhitespace()->notEmpty()->PhoneValid()
        ]);

        if ($validation->failed()){
            return $response->withRedirect($this->router->pathFor('get.admin.create'));
        }

        $filename = $this->UtilsController->uploadFile($directory, $request);

        $user = User::create([
        'email'    => $request->getParam('email'),
        'name'     => $request->getParam('name'),
        'password' => password_hash($request->getParam('password'), PASSWORD_DEFAULT),
        'phone'    => $request->getParam('phone'),
        'role'     => $request->getParam('role'),
        'image'    => $filename
        ]);

        return $response->withRedirect($this->router->pathFor('get.admin.detail'));
    }       

    public function getAdminUpdate($request, $response, $args){

        $admin = $this->db::select('select id, name, email, phone, role, image from administrators where 1');
        $admin_data = $this->db::table('administrators')->select('id', 'name', 'email', 'phone', 'role', 'image')->where('id', '=', $args["id"])->get();
 
        return $this->view->render($response,'/auth/updateadmin.html', [
            'admin'         => $admin,
            'admin_data'    => $admin_data
        ]); 
    } 

    public function postAdminUpdate($request, $response, $args){

        $validation = $this->validator->validate($request,[
            'email'    => v::noWhitespace()->notEmpty()->email(),
            'name'     => v::notEmpty()->alpha(),
            'phone'    => v::noWhitespace()->notEmpty()->PhoneValid()
        ]);

        if ($validation->failed()){
            return $response->withRedirect($this->router->pathFor('get.admin.update',['id' => $args["id"]]));
        }

        $this->db::table('administrators')
        ->where('id', $args["id"])
        ->update([
                'name' => $request->getParam('name'),
                'email' => $request->getParam('email'),
                'phone' => $request->getParam('phone'),
                'role' => $request->getParam('role')
            ]);

        return $response->withRedirect($this->router->pathFor('get.admin.detail'));
    }     

    public function getAdminDelete($request, $response, $args){

        $admin = $this->db::select('select id, name, email, phone, role, image from administrators where 1');
        $admin_name = $this->db::table('administrators')->select('id', 'name')->where('id', '=', $args["id"])->get();
 
        return $this->view->render($response,'/auth/deleteadmin.html', [
            'admin'         => $admin,
            'admin_name'    => $admin_name
        ]);
    }    

    public function postAdminDelete($request, $response, $args){
        
        if($request->getParam('delete_admin') === 'yes'){
            $this->db::table('administrators')->where('id', '=', $args["id"])->delete();

            return $response->withRedirect($this->router->pathFor('get.admin.detail'));

        } else if($request->getParam('delete_admin') === 'no'){
            return $response->withRedirect($this->router->pathFor('get.admin.detail'));
        }
    }     
    
    public function getAdminCreate($request, $response){

        $admin = $this->db::select('select id, name, email, phone, role, image from administrators where 1');
        $directory = $this->container->upload_directory;
    
        return $this->view->render($response, 'auth/createadmin.html', [
            'admin' => $admin
        ]);
    }     
}