<?php

namespace App\Controllers\Auth;

use App\Models\User;
use App\Models\Student;
use App\Models\Course;
use App\Models\Study;
use App\Models\Study_Plan;
use App\Controllers\Controller; 
use Respect\Validation\Validator as v;
use \Slim\Views\Twig as View;

class UtilsController extends Controller{

    public function uploadFile($directory, $request){

        $directory = $this->container->upload_directory; 

        $uploadedFiles = $request->getUploadedFiles();
        $uploadedFile = $uploadedFiles['inputFile'];

        $extension = pathinfo($uploadedFile->getClientFilename(), PATHINFO_EXTENSION);
        $basename = bin2hex(random_bytes(8));
        $filename = sprintf('%s.%0.8s', $basename, $extension);

        $uploadedFile->moveTo($directory . DIRECTORY_SEPARATOR . $filename);

        return $filename;

    }      
}