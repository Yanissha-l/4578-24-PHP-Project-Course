<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model{

    protected $table = 'administrators';

    protected $fillable = [
        'email',
        'name',
        'password',
        'phone',
        'role',
        'image'
    ];

    public function setPassword($password){
        $this->update([
            'password' => password_hash($password, PASSWORD_DEFAULT)
        ]);
    } 


}