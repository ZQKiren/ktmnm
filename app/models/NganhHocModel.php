<?php
class NganhHocModel {
    private $conn;
    private $table_name = "NganhHoc";

    public $MaNganh;
    public $TenNganh;

    public function __construct($db) {
        $this->conn = $db;
    }

    
    public function getAll() {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function getById() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE MaNganh = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->MaNganh);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if($row) {
            $this->TenNganh = $row['TenNganh'];
            return true;
        }
        return false;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table_name . " 
                  SET MaNganh = :MaNganh, TenNganh = :TenNganh";

        $stmt = $this->conn->prepare($query);

        $this->MaNganh = htmlspecialchars(strip_tags($this->MaNganh));
        $this->TenNganh = htmlspecialchars(strip_tags($this->TenNganh));

        $stmt->bindParam(":MaNganh", $this->MaNganh);
        $stmt->bindParam(":TenNganh", $this->TenNganh);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function update() {
        $query = "UPDATE " . $this->table_name . "
                  SET TenNganh = :TenNganh
                  WHERE MaNganh = :MaNganh";

        $stmt = $this->conn->prepare($query);

        $this->MaNganh = htmlspecialchars(strip_tags($this->MaNganh));
        $this->TenNganh = htmlspecialchars(strip_tags($this->TenNganh));

        $stmt->bindParam(":MaNganh", $this->MaNganh);
        $stmt->bindParam(":TenNganh", $this->TenNganh);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE MaNganh = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->MaNganh);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function countStudents() {
        $query = "SELECT COUNT(*) as total FROM SinhVien WHERE MaNganh = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->MaNganh);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $row['total'];
    }
}
?>