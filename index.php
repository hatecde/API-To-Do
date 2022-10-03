<?php        
    declare(strict_types=1); 

    spl_autoload_register(function ($class) { 
        require __DIR__ . "/src/$class.php";
    });
    // set_error_handler("ErrorHandler::handleError");
    set_exception_handler("ErrorHandler::handleException");

    header("Content-type: application/json; charset=UTF-8");
    $parts = explode("/", $_SERVER["REQUEST_URI"]);
    if ($parts[1] != "tasks") {
        http_response_code(404);
        exit;
    }
    // private $isUrgent;
    // private $checkValue а;
    
    $id = $parts[2] ?? null;
    $database = new Database("coffee20.mysql.tools","coffee20_maslov","coffee20_maslov","tjXkX9uG569R");
    $gateway = new TaskGateway($database);

    $controller = new TaskController($gateway);

    $controller->processRequest($_SERVER["REQUEST_METHOD"], $id);
?>