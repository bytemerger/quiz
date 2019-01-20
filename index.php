<?php
//require autoloader
require_once __DIR__ . '/vendor/autoload.php';


// Set error display and the type to be displayed.
ini_set('display_errors', true);

//call app configurations
new App\config\config();

$klein= new \Klein\Klein();

$klein->respond('GET', '/?', function ($request, $response,$service){$service->render('app/views/home.phtml');});

$klein->dispatch();
?>
