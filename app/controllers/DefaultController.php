<?php
require_once 'app/models/SinhVienModel.php';
require_once 'app/config/database.php';

class DefaultController {
    private $db;
    private $sinhvien;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->sinhvien = new SinhVienModel($this->db);
        
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function index() {
        header("Location: index.php?controller=sinhvien&action=list");
        exit();
    }
}
?>