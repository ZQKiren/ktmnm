<?php require_once 'app/views/shares/header.php'; ?>

<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 text-gray-800">Lịch sử đăng ký học phần</h1>
        <div>
            <a href="index.php?controller=hocphan&action=list" class="btn btn-primary">
                <i class="fas fa-clipboard-list me-2"></i>Đăng ký học phần mới
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-4">
            <!-- Thông tin sinh viên -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-user-graduate me-2"></i>Thông tin sinh viên
                    </h6>
                </div>
                <div class="card-body">
                    <div class="text-center mb-4">
                        <i class="fas fa-user-circle fa-5x text-primary mb-3"></i>
                        <h5 class="font-weight-bold"><?= htmlspecialchars($_SESSION['HoTen']) ?></h5>
                        <p class="mb-1">Mã SV: <strong><?= htmlspecialchars($_SESSION['MaSV']) ?></strong></p>
                        <p class="mb-1">Ngày sinh: <strong><?= date('d/m/Y', strtotime($_SESSION['NgaySinh'])) ?></strong></p>
                        <p>Ngành học: <strong><?= htmlspecialchars($_SESSION['TenNganh']) ?></strong></p>
                    </div>
                    
                    <div class="d-grid">
                        <a href="index.php?controller=sinhvien&action=show&id=<?= $_SESSION['MaSV'] ?>" class="btn btn-outline-primary">
                            <i class="fas fa-eye me-2"></i>Xem thông tin chi tiết
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-8">
            <!-- Danh sách đăng ký -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-history me-2"></i>Lịch sử đăng ký của bạn
                    </h6>
                </div>
                <div class="card-body">
                    <?php if($danhSachDangKy->rowCount() > 0): ?>
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                                <thead class="table-light">
                                    <tr>
                                        <th width="10%">Mã ĐK</th>
                                        <th width="20%">Ngày đăng ký</th>
                                        <th width="15%">Số học phần</th>
                                        <th width="15%">Tổng tín chỉ</th>
                                        <th width="15%">Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while($dangky = $danhSachDangKy->fetch(PDO::FETCH_ASSOC)): ?>
                                    <tr>
                                        <td class="text-center"><strong><?= $dangky['MaDK'] ?></strong></td>
                                        <td><?= date('d/m/Y', strtotime($dangky['NgayDK'])) ?></td>
                                        <td class="text-center">
                                            <span class="badge bg-primary"><?= $dangky['SoLuongHocPhan'] ?></span>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-info text-dark"><?= $dangky['TongSoTinChi'] ?> tín chỉ</span>
                                        </td>
                                        <td>
                                            <a href="index.php?controller=dangky&action=detail&id=<?= $dangky['MaDK'] ?>" 
                                                class="btn btn-info btn-sm" title="Xem chi tiết">
                                                <i class="fas fa-eye me-1"></i>Chi tiết
                                            </a>
                                        </td>
                                    </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-5">
                            <i class="fas fa-calendar-times fa-4x text-muted mb-3"></i>
                            <h5 class="text-muted mb-3">Bạn chưa có lịch sử đăng ký nào</h5>
                            <p class="mb-4">Bạn chưa thực hiện đăng ký học phần nào trong hệ thống.</p>
                            <a href="index.php?controller=hocphan&action=list" class="btn btn-primary">
                                <i class="fas fa-clipboard-list me-2"></i>Đăng ký học phần ngay
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once 'app/views/shares/footer.php'; ?>