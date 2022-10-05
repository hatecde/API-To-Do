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
     switch ($method) {
        case "DELETE":
            $rows = $this->gateway->delete($id);
            
            echo json_encode([
                "message" => "Task $id deleted",
                "rows" => $rows 
            ]);
            break;

            default:
            http_response_code(405);
            header("Allow:GET,PATCH,DELETE");

        case "GET":
                echo json_encode($task);
                break;
        case "PATCH":
            $data = (array) json_decode(file_get_contents("php://input"),true);
            $rows =  $this->gateway->update($task, $data);
            echo json_encode([
                "message" => "task updated",
                "rows" => $rows
            ]);
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
                $errors = $this ->getValidationErrors($data,false);
                $id =  $this->gateway->create($data);

                if ( ! empty($errors)) {
                    http_response_code(422);
                    echo json_encode(["errors" => $errors]);
                    break;
                }

                http_response_code(201);
                echo json_encode([
                    "message" => "task created"
                ]);
                break;
            default:
                http_response_code(405);
                header("Allow: GET,POST,PATCH");               
        }       
    }

    private function getValidationErrors(array $data, bool $is_new = true): array {
        $errors = [];
        
        if ($is_new && empty($data["task_name"])) {
            $errors[] = "task name is required";
        }
        
        if (array_key_exists("task_id", $data)) {
            if (filter_var($data["task_id"], FILTER_VALIDATE_INT) === false) {
                $errors[] = "id must be an integer";
            }
        }
        
        return $errors;
    }

    
}
?>
