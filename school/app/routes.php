<?php

use App\Middleware\AuthMiddleware;

$app->get('/','HomeController:index')->setName('home');

$app->get('/auth/signup','AuthController:getSignUp')->setName('auth.signup');

$app->post('/auth/signup','AuthController:postSignUp');

$app->get('/auth/signin','AuthController:getSignIn')->setName('auth.signin');

$app->post('/auth/signin','AuthController:postSignIn');


$app->group('',function(){ 

    $this->get('/auth/signout','AuthController:getSignOut')->setName('auth.signout');

    $this->post('/auth/password/change','PasswordController:postChangePassword');
    
    $this->get('/auth/password/change','PasswordController:getChangePassword')->setName('auth.password.change');
    
    $this->get('/auth/context','HomeAdminController:getAdminData')->setName('tmpl.home.admin');

    /******************************************************************************************************************/
    
    $this->post('/auth/createcourse','CourseController:postCreateCourse')->setName('create.course');

    $this->get('/auth/createcourse','CourseController:getCreateCourse')->setName('get.course');

    $this->get('/auth/detailscourse/{id}','CourseController:getCourseDetails')->setName('get.course.details');

    $this->post('/auth/detailscourse/{id}','CourseController:postCourseDetails')->setName('post.course.details');    

    $this->get('/auth/updatecourse/{id}','CourseController:getCourseUpdate')->setName('get.course.update');

    $this->post('/auth/updatecourse/{id}','CourseController:postCourseUpdate')->setName('post.course.update');

    $this->get('/auth/deletecourse/{id}','CourseController:getCourseDelete')->setName('get.course.delete');

    $this->post('/auth/deletecourse/{id}','CourseController:postCourseDelete')->setName('post.course.delete');

    /******************************************************************************************************************/

    $this->post('/auth/createstudent','StudentController:postCreateStudent')->setName('create.student');

    $this->get('/auth/createstudent','StudentController:getCreateStudent')->setName('get.student');    
    
    $this->get('/auth/detailsstudent/{id}','StudentController:getStudentDetails')->setName('get.student.details');

    $this->post('/auth/detailsstudent/{id}','StudentController:postStudentDetails')->setName('post.student.details');
        
    $this->get('/auth/updatestudent/{id}','StudentController:getStudentUpdate')->setName('get.student.update');

    $this->post('/auth/updatestudent/{id}','StudentController:postStudentUpdate')->setName('post.student.update');

    $this->get('/auth/deletestudent/{id}','StudentController:getStudentDelete')->setName('get.student.delete');

    $this->post('/auth/deletestudent/{id}','StudentController:postStudentDelete')->setName('post.student.delete');

    /******************************************************************************************************************/

    $this->get('/auth/contextadmin','AdminController:getAdminDetails')->setName('get.admin.detail');

    $this->get('/auth/updateadmin/{id}','AdminController:getAdminUpdate')->setName('get.admin.update');

    $this->post('/auth/updateadmin/{id}','AdminController:postAdminUpdate')->setName('post.admin.update');

    $this->get('/auth/deleteadmin/{id}','AdminController:getAdminDelete')->setName('get.admin.delete');

    $this->post('/auth/deleteadmin/{id}','AdminController:postAdminDelete')->setName('post.admin.delete');

    $this->get('/auth/createadmin','AdminController:getAdminCreate')->setName('get.admin.create');

    $this->post('/auth/createadmin','AdminController:postAdminCreate')->setName('post.admin.create');    

})->add(new AuthMiddleware($container));



