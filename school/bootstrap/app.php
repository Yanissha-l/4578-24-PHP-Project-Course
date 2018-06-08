<?php 

use Respect\Validation\Validator as v;

session_start();

require __DIR__ . '/../vendor/autoload.php';

$app = new Slim\App([
    'settings' => [
        'displayErrorDetails' => true,
        'db' => [
            'driver'     => 'mysql',
            'host'       => 'localhost',
            'database'   => 'school',
            'username'   => 'root',
            'password'   => '',
            'charsset'   => 'utf8',
            'collation'  => 'utf8_unicode_ci',
            'prefix'     => ''
        ]        
    ]
]);

$container = $app->getContainer();

$capsule = new \Illuminate\Database\Capsule\Manager;

$capsule->addConnection($container['settings']['db']);

$capsule->setAsGlobal();

$capsule->bootEloquent();

$container['db'] = function ($container) use ($capsule){
    return $capsule;
}; 

$container['view'] = function($container){
    $view = new \Slim\Views\Twig(__DIR__ . '/../resources/views',[
        'cashe' => false,
    ]);

    $view->addExtension(new \Slim\Views\TwigExtension(
        $container->router,
        $container->request->getUri()
    ));

    $view->getEnvironment()->addGlobal('auth', [
        'check'   => $container->auth->check(),
        'user'    => $container->auth->user()
    ]);

    return $view;
};

$container['auth'] = function($container){
    return new \App\Auth\Auth;
};

$container['validator'] = function($container){
    return new \App\Validation\Validator;
};

$container['HomeController'] = function($container){
    return new \App\Controllers\HomeController($container);
};

$container['AuthController'] = function($container){
    return new \App\Controllers\Auth\AuthController($container);
};

$container['PasswordController'] = function($container){
    return new \App\Controllers\Auth\PasswordController($container);
};

$container['HomeAdminController'] = function($container){
    return new \App\Controllers\Auth\HomeAdminController($container);
};

$container['UtilsController'] = function($container){
    return new \App\Controllers\Auth\UtilsController($container);
};

$container['StudentController'] = function($container){
    return new \App\Controllers\Auth\StudentController($container);
};

$container['CourseController'] = function($container){
    return new \App\Controllers\Auth\CourseController($container);
};

$container['AdminController'] = function($container){
    return new \App\Controllers\Auth\AdminController($container);
};

$container['upload_directory'] = __DIR__.'/../uploads';

$container['csrf'] = function($container){
    $guard = new \Slim\Csrf\Guard();
    $guard->setPersistentTokenMode(true);
    return $guard;
};

$app->add(new \App\Middleware\ValidationErrorsMiddleware($container));
$app->add(new \App\Middleware\OldInputMiddleware($container));
$app->add(new \App\Middleware\CsrfViewMiddleware($container));
$app->add($container->csrf);



v::with('App\\Validation\\Rules\\');

require __DIR__ . '/../app/routes.php'; 
