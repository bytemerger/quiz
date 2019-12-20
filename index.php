<?php
ini_set('display_errors', true);
//require autoloader
require_once __DIR__ . '/vendor/autoload.php';


// Set error display and the type to be displayed.
ini_set('display_errors', true);

use App\controllers\entry;
use App\db\seeder;
use App\controllers\write;
//call app configurations
new App\config\config();

$klein= new \Klein\Klein();

$klein->respond('GET', '/?', function ($request, $response,$service){$service->render('app/views/home.phtml');});
$klein->respond('POST', '/entry',function ($request, $response,$service){
   new entry($service);
    //$service->render('app/views/login.phtml',array('error'=>$error));
});
$klein->respond('GET','/write',function($request, $response, $service){
   $write= new write;
   $result=$write->proceed($_SESSION['student_id']);
   $service->render('app/views/write.phtml',array('result'=> $result));
});
$klein->respond('POST', '/write', function ($request, $response,$service){
   $write= new write();
   });

$klein->dispatch();
?>
