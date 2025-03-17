<?php require_once 'app/views/shares/header.php'; ?>

<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 text-gray-800">Đăng ký học phần</h1>
        <a href="index.php?controller=hocphan&action=list" class="btn btn-primary">
            <i class="fas fa-clipboard-list me-2"></i>Thêm học phần khác
        </a>
    </div>

    <?php if(isset($_SESSION['cart']) && !empty($_SESSION['cart'])): ?>
        <div class="row">
            <div class="col-xl-8">
                <!-- Danh sách học phần đã đăng ký -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Danh sách học phần đã chọn</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                                <thead class="table-light">
                                    <tr>
                                        <th width="10%">Mã HP</th>
                                        <th>Tên học phần</th>
                                        <th width="15%">Số tín chỉ</th>
                                        <th width="15%">Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $totalCredits = 0;
                                    foreach($_SESSION['cart'] as $item): 
                                        $totalCredits += $item['SoTinChi'];
                                    ?>
                                    <tr>
                                        <td><?= htmlspecialchars($item['MaHP']) ?></td>
                                        <td><strong><?= htmlspecialchars($item['TenHP']) ?></strong></td>
                                        <td>
                                            <span class="badge bg-info text-dark"><?= (int)$item['SoTinChi'] ?> tín chỉ</span>
                                        </td>
                                        <td>
                                            <a href="index.php?controller=dangky&action=remove&id=<?= $item['MaHP'] ?>" 
                                                class="btn btn-danger btn-sm" 
                                                onclick="return confirm('Bạn có chắc chắn muốn xóa học phần này khỏi danh sách đăng ký?')">
                                                <i class="fas fa-trash me-1"></i>Xóa
                                            </a>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="2" class="text-end fw-bold">Tổng cộng:</td>
                                        <td colspan="2">
                                            <div class="d-flex justify-content-between">
                                                <span><strong><?= count($_SESSION['cart']) ?></strong> học phần</span>
                                                <span><strong><?= $totalCredits ?></strong> tín chỉ</span>
                                            </div>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-4">
                <!-- Thông tin sinh viên -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Thông tin đăng ký</h6>
                    </div>
                    <div class="card-body">
                        <div class="text-center mb-4">
                            <i class="fas fa-user-circle fa-5x text-primary mb-3"></i>
                            <h5 class="font-weight-bold"><?= htmlspecialchars($_SESSION['HoTen']) ?></h5>
                            <p class="mb-1">Mã SV: <strong><?= htmlspecialchars($_SESSION['MaSV']) ?></strong></p>
                            <p class="mb-1">Ngày sinh: <strong><?= date('d/m/Y', strtotime($_SESSION['NgaySinh'])) ?></strong></p>
                            <p>Ngành học: <strong><?= htmlspecialchars($_SESSION['TenNganh']) ?></strong></p>
                        </div>
                        
                        <div class="mb-4">
                            <div class="d-flex justify-content-between mb-2">
                                <span>Tổng học phần:</span>
                                <span class="font-weight-bold"><?= count($_SESSION['cart']) ?></span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Tổng số tín chỉ:</span>
                                <span class="font-weight-bold"><?= $totalCredits ?></span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span>Ngày đăng ký:</span>
                                <span class="font-weight-bold"><?= date('d/m/Y') ?></span>
                            </div>
                        </div>
                        
                        <hr>
                        
                        <div class="d-grid gap-2">
                            <a href="index.php?controller=dangky&action=checkout" class="btn btn-success btn-lg">
                                <i class="fas fa-check-circle me-2"></i>Xác nhận đăng ký
                            </a>
                            <a href="index.php?controller=dangky&action=clear" class="btn btn-danger" 
                                onclick="return confirm('Bạn có chắc muốn hủy tất cả đăng ký?')">
                                <i class="fas fa-times-circle me-2"></i>Hủy tất cả đăng ký
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php else: ?>
        <div class="card shadow mb-4">
            <div class="card-body text-center py-5">
                <i class="fas fa-shopping-cart fa-5x text-muted mb-4"></i>
                <h4 class="text-muted mb-3">Giỏ đăng ký trống</h4>
                <p class="mb-4">Bạn chưa chọn học phần nào để đăng ký.</p>
                <a href="index.php?controller=hocphan&action=list" class="btn btn-primary">
                    <i class="fas fa-clipboard-list me-2"></i>Xem danh sách học phần
                </a>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php require_once 'app/views/shares/footer.php'; ?>