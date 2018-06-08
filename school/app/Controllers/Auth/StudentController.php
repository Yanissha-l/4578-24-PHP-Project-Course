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

class StudentController extends Controller{

    public function getCreateStudent($request, $response){

        $student = $this->db::select('select id, name, email, phone, image from students where 1');
        $course = $this->db::select('select id, name, description, image from course where 1');

        return $this->view->render($response,'/auth/createstudent.html', [
            'student' => $student,
            'course'  => $course
        ]);        
    }

    public function postCreateStudent($request, $response){

        $uploadedFile = $request->getUploadedFiles()['inputFile'];
        $fileSize = $request->getUploadedFiles()['inputFile']->getSize();
        $fileName = $request->getUploadedFiles()['inputFile']->getClientFilename();
        $fileType = $request->getUploadedFiles()['inputFile']->getClientMediaType();
        

        //echo $fileName;
        //var_dump(v::image()->validate($_FILES['image']['tmp_name‌​']‌​));
        /* var_dump($uploadedFile);
        var_dump($fileSize);
        var_dump($fileName);
        var_dump($fileType); */
        //die();

        $validation = $this->validator->validate($request,[
            'email'     => v::noWhitespace()->notEmpty()->email()->EmailAvailable(),
            'name'      => v::notEmpty()->alpha(),
            'phone'     => v::noWhitespace()->notEmpty()->PhoneValid()
        ]);

        if ($validation->failed()){
            return $response->withRedirect($this->router->pathFor('get.student'));
        }  

        $filename = $this->UtilsController->uploadFile($directory, $request);

        $student = student::create([
        'email'    => $request->getParam('email'),
        'name'     => $request->getParam('name'),
        'phone'    => $request->getParam('phone'),
        'image'    => $filename
        ]);

        return $response->withRedirect($this->router->pathFor('tmpl.home.admin'));
    }

    public function getStudentDetails($request, $response, $args){

        $student = $this->db::select('select id, name, email, phone, image from students where 1');
        $course = $this->db::select('select id, name, description, image from course where 1');
        $student_data = $this->db::table('students')->select('id', 'name', 'email', 'phone', 'image')->where('id', '=', $args["id"])->get();
        $study_plan = $this->db::table('study_plan')->select('id', 'student_id', 'student_name', 'course_id', 'course_name')->where('student_id', '=', $args["id"])->get();

        $delete_course = $this->db::table('study_plan')->select('id', 'student_id', 'student_name', 'course_id', 'course_name')->where('student_id', '=', $args["id"])->get();
        
        $new_courses_temp = $this->db::table('study_plan')->select('course_id')->where('student_id', '=', $args["id"])->get(); 
        $temp_array = json_decode(json_encode($new_courses_temp), true);
        $new_courses = $this->db::table('course')->select('id', 'name')->whereNotIn('id', $temp_array)->get();

        return $this->view->render($response,'/auth/detailsstudent.html', [
            'student'        => $student,
            'course'         => $course,
            'student_data'   => $student_data,
            'study_plan'     => $study_plan,
            'new_courses'    => $new_courses,
            'delete_courses'  => $delete_course
        ]);
    }

    public function postStudentDetails($request, $response, $args){
        
        if(($request->getParam('insert') !== 'Choose...') or ($request->getParam('delete') !== 'Choose...') ){
    
            if($request->getParam('mode_insert_cr') === 'insert'){

                $student = study::create([
                'course_id'     => $request->getParam('insert'),
                'student_id'    => $args["id"]
                ]);

                return $response->withRedirect($this->router->pathFor('get.student.details',['id' => $args["id"]]));        
            }

            if($request->getParam('mode_delete_cr') === 'delete'){

                $this->db::table('study')->where([
                    ['course_id', '=', $request->getParam('delete')],
                    ['student_id','=',$args["id"]],
                ])->delete();            

                return $response->withRedirect($this->router->pathFor('get.student.details',['id' => $args["id"]]));        
            }            
        }       
    }    

    public function getStudentUpdate($request, $response, $args){

        $student = $this->db::select('select id, name, email, phone, image from students where 1');
        $course = $this->db::select('select id, name, description, image from course where 1');
        $student_data = $this->db::table('students')->select('id', 'name', 'email', 'phone', 'image')->where('id', '=', $args["id"])->get();
 
        return $this->view->render($response,'/auth/updatestudent.html', [
            'student'         => $student,
            'course'          => $course,
            'student_data'    => $student_data
        ]);
    }    

    public function postStudentUpdate($request, $response, $args){      
        
        $validation = $this->validator->validate($request,[
            'email'    => v::noWhitespace()->notEmpty()->email()->EmailAvailable(),
            'name'     => v::notEmpty()->alpha(),
            'phone'    => v::noWhitespace()->notEmpty()->PhoneValid()
        ]);

        if ($validation->failed()){
            return $response->withRedirect($this->router->pathFor('get.student.update',['id' => $args["id"]]));
        }  

        $this->db::table('students')
                    ->where('id', $args["id"])
                    ->update([
                            'name' => $request->getParam('name'),
                            'email' => $request->getParam('email'),
                            'phone' => $request->getParam('phone')
                        ]);

        return $response->withRedirect($this->router->pathFor('get.student.details',['id' => $args["id"]]));
    }

    public function getStudentDelete($request, $response, $args){

        $student = $this->db::select('select id, name, email, phone, image from students where 1');
        $course = $this->db::select('select id, name, description, image from course where 1');
        $student_name = $this->db::table('students')->select('id', 'name')->where('id', '=', $args["id"])->get();
 
        return $this->view->render($response,'/auth/deletestudent.html', [
            'student'         => $student,
            'course'          => $course,
            'student_name'    => $student_name
        ]);
    }    

    public function postStudentDelete($request, $response, $args){
        
        if($request->getParam('delete_student') === 'yes'){
            $this->db::table('students')->where('id', '=', $args["id"])->delete();

            $this->db::table('study')->where('student_id', '=', $args["id"])->delete();

            return $response->withRedirect($this->router->pathFor('tmpl.home.admin'));

        } else if($request->getParam('delete_student') === 'no'){
            return $response->withRedirect($this->router->pathFor('get.student.details',['id' => $args["id"]]));
        }
    }    
}