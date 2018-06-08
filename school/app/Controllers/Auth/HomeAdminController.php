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

class HomeAdminController extends Controller{

    public function getAdminData($request, $response){

        $student = $this->db::select('select id, name, email, phone, image from students where 1');
        $course = $this->db::select('select id, name, description, image from course where 1');
        $student_sum = $this->db::table('students')->count();
        $course_sum = $this->db::table('course')->count();

        return $this->view->render($response,'/auth/context.html', [
            'student' => $student,
            'course'  => $course,
            'student_sum' => $student_sum,
            'course_sum' => $course_sum
        ]);
    }
}
