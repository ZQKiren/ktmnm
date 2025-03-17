<?php
class SinhVienModel {
    private $conn;
    private $table_name = "SinhVien";

    public $MaSV;
    public $HoTen;
    public $GioiTinh;
    public $NgaySinh;
    public $Hinh;
    public $MaNganh;
    public $TenNganh;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAll() {
        $query = "SELECT sv.MaSV, sv.HoTen, sv.GioiTinh, sv.NgaySinh, sv.Hinh, sv.MaNganh, nh.TenNganh
                  FROM " . $this->table_name . " sv
                  LEFT JOIN NganhHoc nh ON sv.MaNganh = nh.MaNganh
                  ORDER BY sv.MaSV DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function getById() {
        $query = "SELECT sv.MaSV, sv.HoTen, sv.GioiTinh, sv.NgaySinh, sv.Hinh, sv.MaNganh, nh.TenNganh
                  FROM " . $this->table_name . " sv
                  LEFT JOIN NganhHoc nh ON sv.MaNganh = nh.MaNganh
                  WHERE sv.MaSV = ?";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->MaSV);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if($row) {
            $this->HoTen = $row['HoTen'];
            $this->GioiTinh = $row['GioiTinh'];
            $this->NgaySinh = $row['NgaySinh'];
            $this->Hinh = $row['Hinh'];
            $this->MaNganh = $row['MaNganh'];
            $this->TenNganh = $row['TenNganh'];
            return true;
        }
        return false;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table_name . " 
                  SET MaSV = :MaSV, HoTen = :HoTen, GioiTinh = :GioiTinh, 
                      NgaySinh = :NgaySinh, Hinh = :Hinh, MaNganh = :MaNganh";

        $stmt = $this->conn->prepare($query);

        $this->MaSV = htmlspecialchars(strip_tags($this->MaSV));
        $this->HoTen = htmlspecialchars(strip_tags($this->HoTen));
        $this->GioiTinh = htmlspecialchars(strip_tags($this->GioiTinh));
        $this->NgaySinh = htmlspecialchars(strip_tags($this->NgaySinh));
        $this->MaNganh = htmlspecialchars(strip_tags($this->MaNganh));
        
        $stmt->bindParam(":MaSV", $this->MaSV);
        $stmt->bindParam(":HoTen", $this->HoTen);
        $stmt->bindParam(":GioiTinh", $this->GioiTinh);
        $stmt->bindParam(":NgaySinh", $this->NgaySinh);
        $stmt->bindParam(":Hinh", $this->Hinh);
        $stmt->bindParam(":MaNganh", $this->MaNganh);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function update() {
        
        if(!empty($this->Hinh)) {
            $query = "UPDATE " . $this->table_name . "
                      SET HoTen = :HoTen, GioiTinh = :GioiTinh, 
                          NgaySinh = :NgaySinh, Hinh = :Hinh, MaNganh = :MaNganh
                      WHERE MaSV = :MaSV";
        } else {
            $query = "UPDATE " . $this->table_name . "
                      SET HoTen = :HoTen, GioiTinh = :GioiTinh, 
                          NgaySinh = :NgaySinh, MaNganh = :MaNganh
                      WHERE MaSV = :MaSV";
        }

        $stmt = $this->conn->prepare($query);

        $this->MaSV = htmlspecialchars(strip_tags($this->MaSV));
        $this->HoTen = htmlspecialchars(strip_tags($this->HoTen));
        $this->GioiTinh = htmlspecialchars(strip_tags($this->GioiTinh));
        $this->NgaySinh = htmlspecialchars(strip_tags($this->NgaySinh));
        $this->MaNganh = htmlspecialchars(strip_tags($this->MaNganh));

        $stmt->bindParam(":MaSV", $this->MaSV);
        $stmt->bindParam(":HoTen", $this->HoTen);
        $stmt->bindParam(":GioiTinh", $this->GioiTinh);
        $stmt->bindParam(":NgaySinh", $this->NgaySinh);
        $stmt->bindParam(":MaNganh", $this->MaNganh);
        
        if(!empty($this->Hinh)) {
            $stmt->bindParam(":Hinh", $this->Hinh);
        }

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE MaSV = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->MaSV);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }
}
?>