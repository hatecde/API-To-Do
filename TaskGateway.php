<?php 
class TaskGateway {
    private PDO $conn;
    
    public function __construct(Database $database) {
        $this->conn = $database->getConnection();
    }

    public function getString() {
        return $this->isUrgent;
    }
    public function getFlag() {
        return $this->$checkValue;
    }
    
    public function getAll(): array {
        $sql = "SELECT *
                FROM task";
                
        $stmt = $this->conn->query($sql);
        
        $data = [];
        
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }
        
        return $data;
    }

    public function create($task_id, $user_id,$category_id,$status_id,$task_name,$task_date,$task_description,$resourses) {
        try {
           $sql = "INSERT INTO task VALUES(:task_id,:user_id,:category_id,:status_id,:task_name,:task_date,:task_description,:resourses)";
           $stmt = $this -> db->prepare($sql); 
           $stmt->bindparam(':task_id',$task_id);
           $stmt->bindparam(':user_id',$user_id);
           $stmt->bindparam(':category_id',$category_id);
           $stmt->bindparam(':status_id',$status_id);
           $stmt->bindparam(':task_name',$task_name);
           $stmt->bindparam(':task_date',$task_date);
           $stmt->bindparam(':task_description',$task_description);
           $stmt->bindparam(':resourses',$resourses);

           $stmt->execute();
           return true;

        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }       
    }
    public function getByStatus(string $isUrgent): array|false {
        $sql = "SELECT task.task_id, task.user_id, status.status_name 
        FROM task INNER JOIN status ON task.status_id = status.status_id 
        WHERE status_name = 'urgent'";

        if ($isUrgent == $status_name) {
            $checkValue = true;
        }
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(":status_name",$status_name, PDO::PARAM_STR);
        $stmt -> execute();
        $data = $stmt ->fetch(PDO::FETCH_ASSOC);
        return $data;
    }

    public function get(string $task_id): array | false {
        $sql ="SELECT * from task WHERE task_id = :task_id";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(":task_id",$task_id, PDO::PARAM_INT);
        $stmt -> execute();
        $data = $stmt ->fetch(PDO::FETCH_ASSOC);
        return $data;
    }
    public function delete(string $task_id): int {
        $sql ="DELETE from task WHERE task_id = :task_id";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(":task_id",$task_id, PDO::PARAM_INT);
        $stmt -> execute();
        return $stmt->rowCount();
    }
    
}