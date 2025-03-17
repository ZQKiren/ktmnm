<?php require_once 'app/views/shares/header.php'; ?>

<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 text-gray-800">Thêm học phần mới</h1>
        <a href="index.php?controller=hocphan&action=list" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Quay lại danh sách
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-plus-circle me-2"></i>Thông tin học phần mới
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

            <form method="post" action="index.php?controller=hocphan&action=add" class="needs-validation" novalidate>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="MaHP" class="form-label">Mã học phần <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-tag"></i></span>
                            <input type="text" class="form-control" id="MaHP" name="MaHP" maxlength="6" required>
                            <div class="invalid-feedback">Vui lòng nhập mã học phần.</div>
                        </div>
                        <div class="form-text">Mã học phần phải có tối đa 6 ký tự.</div>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label for="TenHP" class="form-label">Tên học phần <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-book"></i></span>
                            <input type="text" class="form-control" id="TenHP" name="TenHP" maxlength="30" required>
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
                            <input type="number" class="form-control" id="SoTinChi" name="SoTinChi" min="1" max="10" value="3" required>
                            <div class="invalid-feedback">Vui lòng nhập số tín chỉ (1-10).</div>
                        </div>
                        <div class="form-text">Số tín chỉ tối thiểu là 1, tối đa là 10.</div>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label for="SoLuongDuKien" class="form-label">Số lượng sinh viên dự kiến <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-users"></i></span>
                            <input type="number" class="form-control" id="SoLuongDuKien" name="SoLuongDuKien" min="1" value="50" required>
                            <div class="invalid-feedback">Vui lòng nhập số lượng sinh viên dự kiến.</div>
                        </div>
                        <div class="form-text">Số lượng tối đa sinh viên có thể đăng ký học phần này.</div>
                    </div>
                </div>
                
                <div class="mt-4 d-flex">
                    <button type="submit" class="btn btn-primary me-2">
                        <i class="fas fa-save me-2"></i>Lưu học phần
                    </button>
                    <button type="reset" class="btn btn-secondary">
                        <i class="fas fa-undo me-2"></i>Làm mới
                    </button>
                </div>
            </form>
        </div>
    </div>
    
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-info-circle me-2"></i>Hướng dẫn
            </h6>
        </div>
        <div class="card-body">
            <ul class="mb-0">
                <li class="mb-2"><strong>Mã học phần:</strong> Mã học phần nên được đặt theo quy ước của nhà trường, thường bao gồm mã ngành và số thứ tự.</li>
                <li class="mb-2"><strong>Tên học phần:</strong> Tên đầy đủ của học phần, nên đặt ngắn gọn và dễ hiểu.</li>
                <li class="mb-2"><strong>Số tín chỉ:</strong> Số lượng tín chỉ của học phần, thường từ 1-5 tín chỉ.</li>
                <li><strong>Số lượng sinh viên dự kiến:</strong> Số lượng tối đa sinh viên có thể đăng ký học phần này. Khi đạt số lượng này, hệ thống sẽ không cho phép đăng ký thêm.</li>
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