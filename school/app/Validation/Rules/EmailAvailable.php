<?php

namespace App\Validation\Rules;

use App\Models\User;
use Respect\Validation\Rules\AbstractRule;    

class EmailAvailable extends AbstractRule{

    public function validate($input){
    
        $dbValue = User::select('email as user_email')->where('email','=',$input)->first();

        if($dbValue['user_email'] === $input){
            return false;
        }else{       
            return true;
        }
    } 
}