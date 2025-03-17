<?php require_once 'app/views/shares/header.php'; ?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-xl-10 col-lg-12 col-md-9">
            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <div class="row">
                        <div class="col-lg-6 d-none d-lg-block bg-login-image">
                            <!-- Background Image with CSS -->
                            <div style="height: 100%; background: linear-gradient(135deg, #4e73df 0%, #224abe 100%); display: flex; align-items: center; justify-content: center;">
                                <div class="text-center p-5">
                                    <i class="fas fa-user-graduate fa-5x text-white mb-3"></i>
                                    <h4 class="text-white mb-4">HỆ THỐNG ĐĂNG KÝ HỌC PHẦN</h4>
                                    <p class="text-white">Vui lòng đăng nhập bằng mã số sinh viên để tiếp tục.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="p-5">
                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-4">ĐĂNG NHẬP</h1>
                                </div>
                                
                                <?php if(isset($_SESSION['error'])): ?>
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        <i class="fas fa-exclamation-circle me-2"></i>
                                        <?= $_SESSION['error']; ?>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                        <?php unset($_SESSION['error']); ?>
                                    </div>
                                <?php endif; ?>
                                
                                <form class="user" method="post" action="index.php?controller=dangky&action=login">
                                    <div class="form-group mb-4">
                                        <label for="MaSV" class="form-label">Mã số sinh viên</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                                            <input type="text" class="form-control" id="MaSV" name="MaSV" 
                                                placeholder="Nhập mã số sinh viên..." required>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-user btn-block w-100 py-2 mt-4">
                                        <i class="fas fa-sign-in-alt me-2"></i>Đăng nhập
                                    </button>
                                </form>
                                <hr>
                                <div class="text-center">
                                    <a class="small" href="index.php?controller=hocphan&action=list">
                                        <i class="fas fa-arrow-left me-1"></i>Quay lại danh sách học phần
                                    </a>
                                </div>
                                <div class="text-center mt-3">
                                    <p class="small text-muted">
                                        Nếu bạn chưa có tài khoản, vui lòng liên hệ với phòng đào tạo để được hỗ trợ.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once 'app/views/shares/footer.php'; ?>