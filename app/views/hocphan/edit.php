<?php require_once 'app/views/shares/header.php'; ?>

<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 text-gray-800">Chỉnh sửa học phần</h1>
        <a href="index.php?controller=hocphan&action=list" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Quay lại danh sách
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-edit me-2"></i>Thông tin học phần: <?= htmlspecialchars($this->hocphan->TenHP) ?>
            </h6>
        </div>
        <div class="card-body">
            <?php if(isset($_SESSION['error'])): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    <?= $_SESSION['error']; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    <?php unset($_SESSION['error']); ?>
                </div>
            <?php endif; ?>

            <form method="post" action="index.php?controller=hocphan&action=edit&id=<?= $this->hocphan->MaHP ?>" class="needs-validation" novalidate>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="MaHP" class="form-label">Mã học phần</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-tag"></i></span>
                            <input type="text" class="form-control" id="MaHP" value="<?= htmlspecialchars($this->hocphan->MaHP) ?>" disabled>
                        </div>
                        <div class="form-text">Mã học phần không thể thay đổi.</div>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label for="TenHP" class="form-label">Tên học phần <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-book"></i></span>
                            <input type="text" class="form-control" id="TenHP" name="TenHP" value="<?= htmlspecialchars($this->hocphan->TenHP) ?>" maxlength="30" required>
                            <div class="invalid-feedback">Vui lòng nhập tên học phần.</div>
                        </div>
                        <div class="form-text">Tên học phần phải có tối đa 30 ký tự.</div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="SoTinChi" class="form-label">Số tín chỉ <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-award"></i></span>
                            <input type="number" class="form-control" id="SoTinChi" name="SoTinChi" value="<?= (int)$this->hocphan->SoTinChi ?>" min="1" max="10" required>
                            <div class="invalid-feedback">Vui lòng nhập số tín chỉ (1-10).</div>
                        </div>
                        <div class="form-text">Số tín chỉ tối thiểu là 1, tối đa là 10.</div>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label for="SoLuongDuKien" class="form-label">Số lượng sinh viên dự kiến <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-users"></i></span>
                            <input type="number" class="form-control" id="SoLuongDuKien" name="SoLuongDuKien" value="<?= (int)$this->hocphan->SoLuongDuKien ?>" min="1" required>
                            <div class="invalid-feedback">Vui lòng nhập số lượng sinh viên dự kiến.</div>
                        </div>
                        <div class="form-text">Số lượng tối đa sinh viên có thể đăng ký học phần này.</div>
                    </div>
                </div>
                
                <div class="alert alert-info mt-4" role="alert">
                    <div class="d-flex">
                        <div class="alert-icon me-3">
                            <i class="fas fa-info-circle fa-2x"></i>
                        </div>
                        <div>
                            <h6 class="alert-heading mb-1">Thông tin đăng ký hiện tại</h6>
                            <?php
                            // Tính số lượng đã đăng ký
                            $query = "SELECT COUNT(*) as count FROM ChiTietDangKy WHERE MaHP = ?";
                            $stmt = $this->db->prepare($query);
                            $stmt->execute([$this->hocphan->MaHP]);
                            $row = $stmt->fetch(PDO::FETCH_ASSOC);
                            $soLuongDaDangKy = $row['count'];
                            
                            // Tính số lượng còn lại
                            $soLuongConLai = $this->hocphan->SoLuongDuKien - $soLuongDaDangKy;
                            ?>
                            <p class="mb-0">Đã có <strong><?= $soLuongDaDangKy ?></strong> sinh viên đăng ký học phần này. Còn lại <strong><?= $soLuongConLai ?></strong> chỗ.</p>
                        </div>
                    </div>
                </div>
                
                <div class="mt-4 d-flex">
                    <button type="submit" class="btn btn-primary me-2">
                        <i class="fas fa-save me-2"></i>Lưu thay đổi
                    </button>
                    <button type="reset" class="btn btn-secondary">
                        <i class="fas fa-undo me-2"></i>Khôi phục
                    </button>
                </div>
            </form>
        </div>
    </div>
    
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-exclamation-triangle me-2"></i>Lưu ý khi chỉnh sửa
            </h6>
        </div>
        <div class="card-body">
            <ul class="mb-0">
                <li class="mb-2"><strong>Tên học phần:</strong> Có thể thay đổi tên học phần nhưng nên giữ ý nghĩa tương tự để không gây nhầm lẫn.</li>
                <li class="mb-2"><strong>Số tín chỉ:</strong> Thay đổi số tín chỉ sẽ ảnh hưởng đến tổng số tín chỉ của sinh viên đã đăng ký học phần này.</li>
                <li><strong>Số lượng sinh viên dự kiến:</strong> Nếu giảm số lượng dự kiến thấp hơn số sinh viên đã đăng ký, có thể gây ra vấn đề trong hệ thống. Nên tăng hoặc giữ nguyên giá trị này.</li>
            </ul>
        </div>
    </div>
</div>

<script>
// Form validation
(function() {
    'use strict';
    var forms = document.querySelectorAll('.needs-validation');
    Array.prototype.slice.call(forms).forEach(function(form) {
        form.addEventListener('submit', function(event) {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add('was-validated');
        }, false);
    });
})();
</script>

<?php require_once 'app/views/shares/footer.php'; ?>