<?php
require_once 'app/models/SinhVienModel.php';
require_once 'app/models/HocPhanModel.php';
require_once 'app/config/database.php';

class DangKyController {
    private $db;
    private $sinhvien;
    private $hocphan;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->sinhvien = new SinhVienModel($this->db);
        $this->hocphan = new HocPhanModel($this->db);
        
        // Bắt đầu phiên làm việc nếu chưa bắt đầu
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function login() {
        if (isset($_SESSION['MaSV'])) {
            header("Location: index.php?controller=hocphan&action=list");
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $maSV = isset($_POST['MaSV']) ? $_POST['MaSV'] : '';

            // Kiểm tra xem mã SV có tồn tại không
            $this->sinhvien->MaSV = $maSV;
            if ($this->sinhvien->getById()) {
                $_SESSION['MaSV'] = $maSV;
                $_SESSION['HoTen'] = $this->sinhvien->HoTen;
                $_SESSION['NgaySinh'] = $this->sinhvien->NgaySinh;
                $_SESSION['MaNganh'] = $this->sinhvien->MaNganh;
                $_SESSION['TenNganh'] = $this->sinhvien->TenNganh;
                
                // Khởi tạo giỏ hàng nếu chưa tồn tại
                if (!isset($_SESSION['cart'])) {
                    $_SESSION['cart'] = [];
                }
                
                header("Location: index.php?controller=hocphan&action=list");
                exit();
            } else {
                $_SESSION['error'] = "Mã sinh viên không tồn tại. Vui lòng kiểm tra lại.";
            }
        }

        require_once 'app/views/dangky/login.php';
    }

    public function logout() {
        // Xóa phiên đăng nhập
        unset($_SESSION['MaSV']);
        unset($_SESSION['HoTen']);
        unset($_SESSION['NgaySinh']);
        unset($_SESSION['MaNganh']);
        unset($_SESSION['TenNganh']);
        unset($_SESSION['cart']);
        
        header("Location: index.php?controller=dangky&action=login");
        exit();
    }

    public function add() {
        // Kiểm tra đăng nhập
        if (!isset($_SESSION['MaSV'])) {
            header("Location: index.php?controller=dangky&action=login");
            exit();
        }

        if (!isset($_GET['id'])) {
            header("Location: index.php?controller=hocphan&action=list");
            exit();
        }

        $maHP = $_GET['id'];
        
        // Kiểm tra học phần có tồn tại không
        $this->hocphan->MaHP = $maHP;
        if ($this->hocphan->getById()) {
            // Kiểm tra số lượng sinh viên đăng ký
            $query = "SELECT COUNT(*) as count FROM ChiTietDangKy ctdk 
                      JOIN DangKy dk ON ctdk.MaDK = dk.MaDK 
                      WHERE ctdk.MaHP = ?";
            $stmt = $this->db->prepare($query);
            $stmt->execute([$maHP]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($row['count'] >= $this->hocphan->SoLuongDuKien) {
                $_SESSION['error'] = "Học phần {$this->hocphan->TenHP} đã đạt số lượng sinh viên tối đa.";
                header("Location: index.php?controller=hocphan&action=list");
                exit();
            }
            
            $exists = false;
            foreach ($_SESSION['cart'] as $item) {
                if ($item['MaHP'] === $maHP) {
                    $exists = true;
                    break;
                }
            }

            if (!$exists) {
                
                $_SESSION['cart'][] = [
                    'MaHP' => $this->hocphan->MaHP,
                    'TenHP' => $this->hocphan->TenHP,
                    'SoTinChi' => $this->hocphan->SoTinChi
                ];
                $_SESSION['success'] = "Đã thêm học phần {$this->hocphan->TenHP} vào danh sách đăng ký.";
            } else {
                $_SESSION['error'] = "Học phần {$this->hocphan->TenHP} đã có trong danh sách đăng ký.";
            }
        } else {
            $_SESSION['error'] = "Không tìm thấy học phần.";
        }
        
        header("Location: index.php?controller=dangky&action=cart");
        exit();
    }

    public function cart() {
        
        if (!isset($_SESSION['MaSV'])) {
            header("Location: index.php?controller=dangky&action=login");
            exit();
        }

        require_once 'app/views/dangky/cart.php';
    }

    public function remove() {
        
        if (!isset($_SESSION['MaSV'])) {
            header("Location: index.php?controller=dangky&action=login");
            exit();
        }

        if (!isset($_GET['id'])) {
            header("Location: index.php?controller=dangky&action=cart");
            exit();
        }

        $maHP = $_GET['id'];
        

        foreach ($_SESSION['cart'] as $key => $item) {
            if ($item['MaHP'] === $maHP) {
                unset($_SESSION['cart'][$key]);
                $_SESSION['success'] = "Đã xóa học phần khỏi danh sách đăng ký.";
                break;
            }
        }
        
        
        $_SESSION['cart'] = array_values($_SESSION['cart']);
        
        header("Location: index.php?controller=dangky&action=cart");
        exit();
    }

    public function clear() {
        
        if (!isset($_SESSION['MaSV'])) {
            header("Location: index.php?controller=dangky&action=login");
            exit();
        }

        
        $_SESSION['cart'] = [];
        $_SESSION['success'] = "Đã hủy tất cả đăng ký học phần.";
        
        header("Location: index.php?controller=dangky&action=cart");
        exit();
    }

    public function checkout() {
        
        if (!isset($_SESSION['MaSV'])) {
            header("Location: index.php?controller=dangky&action=login");
            exit();
        }

        
        if (empty($_SESSION['cart'])) {
            $_SESSION['error'] = "Không có học phần nào để đăng ký.";
            header("Location: index.php?controller=dangky&action=cart");
            exit();
        }

        try {
            
            $this->db->beginTransaction();
            
            
            $query = "INSERT INTO DangKy(NgayDK, MaSV) VALUES (NOW(), ?)";
            $stmt = $this->db->prepare($query);
            $stmt->execute([$_SESSION['MaSV']]);
            
            
            $maDK = $this->db->lastInsertId();
            
            $query = "INSERT INTO ChiTietDangKy(MaDK, MaHP) VALUES (?, ?)";
            $stmt = $this->db->prepare($query);
            
            foreach ($_SESSION['cart'] as $item) {
                $stmt->execute([$maDK, $item['MaHP']]);
                
                $this->hocphan->updateEnrollmentCount($item['MaHP'], 1);
            }
            
            $this->db->commit();
            
            $_SESSION['registration_success'] = true;
            $_SESSION['registration_id'] = $maDK;
            $_SESSION['registration_date'] = date('Y-m-d');
            $_SESSION['registered_courses'] = $_SESSION['cart'];
            
            
            $_SESSION['cart'] = [];
            $_SESSION['success'] = "Đăng ký học phần thành công!";
            
            
            header("Location: index.php?controller=dangky&action=success");
            exit();
            
        } catch (PDOException $e) {
            
            $this->db->rollBack();
            $_SESSION['error'] = "Đăng ký học phần thất bại: " . $e->getMessage();
            header("Location: index.php?controller=dangky&action=cart");
            exit();
        }
    }
    
    public function success() {
        
        if (!isset($_SESSION['MaSV']) || !isset($_SESSION['registration_success'])) {
            header("Location: index.php?controller=hocphan&action=list");
            exit();
        }
        
        
        $query = "SELECT dk.MaDK, dk.NgayDK, dk.MaSV, sv.HoTen, sv.NgaySinh, sv.MaNganh, ng.TenNganh
                  FROM DangKy dk
                  JOIN SinhVien sv ON dk.MaSV = sv.MaSV
                  JOIN NganhHoc ng ON sv.MaNganh = ng.MaNganh
                  WHERE dk.MaDK = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$_SESSION['registration_id']]);
        $dangky = $stmt->fetch(PDO::FETCH_ASSOC);
        
        
        $query = "SELECT ctdk.MaHP, hp.TenHP, hp.SoTinChi
                  FROM ChiTietDangKy ctdk
                  JOIN HocPhan hp ON ctdk.MaHP = hp.MaHP
                  WHERE ctdk.MaDK = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$_SESSION['registration_id']]);
        $chiTietDangKy = $stmt;
        
        require_once 'app/views/dangky/success.php';
        
        
        unset($_SESSION['registration_success']);
        unset($_SESSION['registration_id']);
        unset($_SESSION['registration_date']);
        unset($_SESSION['registered_courses']);
    }
    
    
    public function history() {
        
        if (!isset($_SESSION['MaSV'])) {
            header("Location: index.php?controller=dangky&action=login");
            exit();
        }
        
        $query = "SELECT dk.MaDK, dk.NgayDK, 
                 (SELECT COUNT(*) FROM ChiTietDangKy WHERE MaDK = dk.MaDK) as SoLuongHocPhan,
                 (SELECT SUM(hp.SoTinChi) FROM ChiTietDangKy ctdk JOIN HocPhan hp ON ctdk.MaHP = hp.MaHP WHERE ctdk.MaDK = dk.MaDK) as TongSoTinChi
                 FROM DangKy dk 
                 WHERE dk.MaSV = ? 
                 ORDER BY dk.NgayDK DESC";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$_SESSION['MaSV']]);
        $danhSachDangKy = $stmt;
        
        require_once 'app/views/dangky/history.php';
    }
    
    public function detail() {
        
        if (!isset($_SESSION['MaSV'])) {
            header("Location: index.php?controller=dangky&action=login");
            exit();
        }
        
        if (!isset($_GET['id'])) {
            header("Location: index.php?controller=dangky&action=history");
            exit();
        }
        
        $maDK = $_GET['id'];
        
        $query = "SELECT COUNT(*) as count FROM DangKy WHERE MaDK = ? AND MaSV = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$maDK, $_SESSION['MaSV']]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($row['count'] == 0) {
            $_SESSION['error'] = "Bạn không có quyền xem thông tin đăng ký này.";
            header("Location: index.php?controller=dangky&action=history");
            exit();
        }
        
        $query = "SELECT dk.MaDK, dk.NgayDK, sv.MaSV, sv.HoTen, sv.NgaySinh, ng.MaNganh, ng.TenNganh
                  FROM DangKy dk
                  JOIN SinhVien sv ON dk.MaSV = sv.MaSV
                  JOIN NganhHoc ng ON sv.MaNganh = ng.MaNganh
                  WHERE dk.MaDK = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$maDK]);
        $dangky = $stmt->fetch(PDO::FETCH_ASSOC);
        
        $query = "SELECT ctdk.MaHP, hp.TenHP, hp.SoTinChi
                  FROM ChiTietDangKy ctdk
                  JOIN HocPhan hp ON ctdk.MaHP = hp.MaHP
                  WHERE ctdk.MaDK = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$maDK]);
        $chiTietDangKy = $stmt;
        
        require_once 'app/views/dangky/detail.php';
    }
}
?>