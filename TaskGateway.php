<?php 
class TaskGateway {
    private PDO $conn;
    
    public function __construct(Database $database) {
        $this->conn = $database->getConnection();
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
    public function create(array $data): string {
        $sql = "INSERT INTO task(task_id, user_id,category_id,status_id,task_name,task_date,task_description,resourses)
                VALUES (:task_id,:user_id,:category_id,:status_id,:task_name,:task_date,:task_description,:resourses)";
                
        $stmt = $this->conn->prepare($sql);
        
        $stmt->bindValue(":task_id", $data["task_id"] ?? 0, PDO::PARAM_INT);
        $stmt->bindValue(":user_id", $data["user_id"] ?? 0, PDO::PARAM_INT);
        $stmt->bindValue(":category_id", $data["category_id"] ?? 0, PDO::PARAM_INT);
        $stmt->bindValue(":status_id", $data["status_id"] ?? 0, PDO::PARAM_INT);
        $stmt->bindValue(":task_name", $data["task_name"] ?? 0, PDO::PARAM_STR);
        $stmt->bindValue(":task_date", $data["task_date"] ?? 0, PDO::PARAM_STR);
        $stmt->bindValue(":task_description", $data["task_description"] ?? 0, PDO::PARAM_STR);
        $stmt->bindValue(":resourses", $data["resourses"] ?? 0, PDO::PARAM_STR);
        $stmt->execute();
        
        return $this->conn->lastInsertId();
    }

    public function update(array $current, array $new): int {
        $sql = "UPDATE task
                SET task_name = :task_name,task_date = :task_date,task_description = :task_description,resourses = :resourses
                WHERE task_id = :task_id and user_id = :user_id and category_id = :category_id and status_id = :status_id";
                
        $stmt = $this->conn->prepare($sql);
        
        $stmt->bindValue(":task_name", $new["task_name"] ?? $current["task_name"], PDO::PARAM_STR);
        $stmt->bindValue(":task_date", $new["task_date"] ?? $current["task_date"], PDO::PARAM_STR);
        $stmt->bindValue(":task_description", $new["task_description"] ?? $current["task_description"], PDO::PARAM_STR);
        $stmt->bindValue(":resourses", $new["resourses"] ?? $current["resourses"], PDO::PARAM_STR);
        
        $stmt->bindValue(":task_id", $current["task_id"], PDO::PARAM_INT);
        $stmt->bindValue(":user_id",$current["user_id"] , PDO::PARAM_INT);
        $stmt->bindValue(":category_id", $current["category_id"], PDO::PARAM_INT);
        $stmt->bindValue(":status_id",$current["status_id"] , PDO::PARAM_INT);
        
        $stmt->execute();
        
        return $stmt->rowCount();
    }
    public function getValue(bool $task_stage): array | false {
        $sql ="SELECT * from task WHERE task_stage = :task_stage";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(":task_stage",$data["task_stage"], PDO::PARAM_BOOL);
        $stmt -> execute();
        $data = $stmt ->fetch(PDO::FETCH_ASSOC);
        return $data;
    }

    public function get(int $task_id): array | false {
        $sql ="SELECT * from task WHERE task_id = :task_id";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(":task_id",$task_id, PDO::PARAM_INT);
        $stmt -> execute();
        $data = $stmt ->fetch(PDO::FETCH_ASSOC);
        return $data;
    }
    public function delete(int $task_id): int {
        $sql ="DELETE from task WHERE task_id = :task_id";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(":task_id",$task_id, PDO::PARAM_INT);
        $stmt -> execute();
        return $stmt->rowCount();
    }
    
}