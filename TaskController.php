<?php
class TaskController {
    public function __construct(private TaskGateway $gateway) {

    }
    public function processRequest(string $method, ?string $id): void {
        if ($id) {
            $this -> processResourseRequest($method, $id);
        } else {
            $this -> processCollectionRequest($method);
        }
        
    }
    private function processResourseRequest (string $method, string $id):void {
     $task = $this -> gateway ->get($id);

     if (! $task) {
        http_response_code(404);
        echo json_encode(["message" =>"Task not found"]);
        return;
     }
    //  $status = $this -> gateway ->getByStatus($conn->getString());
    
     switch ($method) {
        case "DELETE":
            $rows = $this->gateway->delete($id);
            
            echo json_encode([
                "message" => "Task $id deleted",
                "rows" => $rows
            ]);
            break;

        case "GET":
            echo json_encode($task);
            break;    
    }      
    }
    
    private function processCollectionRequest (string $method):void {
        switch ($method) {
            case "GET":
                echo json_encode($this->gateway->getAll());
                break;
            case "POST":
                $data = (array) json_decode(file_get_contents("php://input"),true);
            default:
                http_response_code(405);
                header("Allow: GET");               
        }       
    }
}
?>