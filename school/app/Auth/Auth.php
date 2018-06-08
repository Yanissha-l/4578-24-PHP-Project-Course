<?php

namespace App\Auth;

use App\Models\User;
use App\Models\Student;

class Auth
{

    public function user(){

        if(empty($_SESSION['user'])){
            $_SESSION['user'] = Null;
        }   

        return User::find($_SESSION['user']);
    }

    public function check(){
        return isset($_SESSION['user']);
    }

    public function attempt($email, $password){

        $user = User::where('email',$email)->first();

        if(!$user){
            return false;
        }

        if(password_verify($password, $user->password)){
            $_SESSION['user'] = $user->id;
            return true;
        }

        return false;
    }

    public function logout(){
        unset($_SESSION['user']);
    }
}
