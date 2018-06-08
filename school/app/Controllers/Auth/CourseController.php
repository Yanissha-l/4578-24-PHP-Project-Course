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

class CourseController extends Controller{

    public function getCourseDetails($request, $response, $args){

        $student = $this->db::select('select id, name, email, phone, image from students where 1');
        $course = $this->db::select('select id, name, description, image from course where 1');
        $course_data = $this->db::table('course')->select('id', 'name', 'description', 'image')->where('id', '=', $args["id"])->get();
        $study_plan = $this->db::table('study_plan')->select('id', 'student_id', 'student_name', 'course_id', 'course_name')->where('course_id', '=', $args["id"])->get();

        $delete_students = $this->db::table('study_plan')->select('id', 'student_id', 'student_name', 'course_id', 'course_name')->where('course_id', '=', $args["id"])->get();
        
        $new_students_temp = $this->db::table('study_plan')->select('student_id')->where('course_id', '=', $args["id"])->get(); 
        $temp_array = json_decode(json_encode($new_students_temp), true);
        $new_students = $this->db::table('students')->select('id', 'name')->whereNotIn('id', $temp_array)->get();
        
        return $this->view->render($response,'/auth/detailscourse.html', [
            'student'         => $student,
            'course'          => $course,
            'course_data'     => $course_data,
            'study_plan'      => $study_plan,
            'new_students'    => $new_students,
            'delete_students' => $delete_students
        ]);
    } 

    public function postCreateCourse($request, $response){

        $validation = $this->validator->validate($request,[            
            'name'        => v::notEmpty()->alpha(),
            'description' => v::notEmpty()
        ]);

        if ($validation->failed()){
            return $response->withRedirect($this->router->pathFor('get.course'));
        }  

        $filename = $this->UtilsController->uploadFile($directory, $request);

        $student = course::create([
        'name'        => $request->getParam('name'),
        'description' => $request->getParam('description'),
        'image'       => $filename
        ]);

        return $response->withRedirect($this->router->pathFor('tmpl.home.admin'));
    }

    public function getCreateCourse($request, $response){

        $student = $this->db::select('select id, name, email, phone, image from students where 1');
        $course = $this->db::select('select id, name, description, image from course where 1');

        return $this->view->render($response,'/auth/createcourse.html', [
            'student' => $student,
            'course'  => $course
        ]);        
    } 

    public function postCourseDetails($request, $response, $args){
        
        if(($request->getParam('insert') !== 'Choose...') or ($request->getParam('delete') !== 'Choose...') ){
    
            if($request->getParam('mode_insert_st') === 'insert'){

                $student = study::create([
                'student_id'     => $request->getParam('insert'),
                'course_id'      => $args["id"]
                ]);

                return $response->withRedirect($this->router->pathFor('get.course.details',['id' => $args["id"]]));        
            }

            if($request->getParam('mode_delete_st') === 'delete'){

                $this->db::table('study')->where([
                    ['student_id', '=', $request->getParam('delete')],
                    ['course_id','=',$args["id"]],
                ])->delete();            

                return $response->withRedirect($this->router->pathFor('get.course.details',['id' => $args["id"]]));        
            }            
        }       
    }

    public function getCourseUpdate($request, $response, $args){

        $student = $this->db::select('select id, name, email, phone, image from students where 1');
        $course = $this->db::select('select id, name, description, image from course where 1');
        $course_data = $this->db::table('course')->select('id', 'name', 'description', 'image')->where('id', '=', $args["id"])->get();
        
        return $this->view->render($response,'/auth/updatecourse.html', [
            'student'         => $student,
            'course'          => $course,
            'course_data'     => $course_data
        ]);
    }    

    public function postCourseUpdate($request, $response, $args){
        
        $validation = $this->validator->validate($request,[            
            'name'        => v::notEmpty()->alpha(),
            'description' => v::notEmpty()
        ]);

        if ($validation->failed()){
            return $response->withRedirect($this->router->pathFor('get.course.update',['id' => $args["id"]]));
        }  

        $this->db::table('course')
                    ->where('id', $args["id"])
                    ->update([
                            'name' => $request->getParam('name'),
                            'description' => $request->getParam('description')
                        ]);

        return $response->withRedirect($this->router->pathFor('get.course.details',['id' => $args["id"]]));
    }

    public function getCourseDelete($request, $response, $args){

        $student = $this->db::select('select id, name, email, phone, image from students where 1');
        $course = $this->db::select('select id, name, description, image from course where 1');
        $course_name = $this->db::table('course')->select('id', 'name')->where('id', '=', $args["id"])->get();
 
        return $this->view->render($response,'/auth/deletecourse.html', [
            'student'         => $student,
            'course'          => $course,
            'course_data'     => $course_name
        ]);
    }    

    public function postCourseDelete($request, $response, $args){
        
        if($request->getParam('delete_course') === 'yes'){
            $this->db::table('course')->where('id', '=', $args["id"])->delete();

            $this->db::table('study')->where('course_id', '=', $args["id"])->delete();

            return $response->withRedirect($this->router->pathFor('tmpl.home.admin'));

        } else if($request->getParam('delete_course') === 'no'){
            return $response->withRedirect($this->router->pathFor('get.course.details',['id' => $args["id"]]));
        }
    }  

}