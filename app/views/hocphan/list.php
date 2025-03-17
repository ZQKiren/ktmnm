<?php require_once 'app/views/shares/header.php'; ?>

<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 text-gray-800">Danh sách học phần</h1>
        <?php if(isset($_SESSION['MaSV'])): ?>
            <a href="index.php?controller=dangky&action=cart" class="btn btn-primary">
                <i class="fas fa-shopping-cart me-2"></i>Giỏ đăng ký
                <?php if(isset($_SESSION['cart']) && count($_SESSION['cart']) > 0): ?>
                    <span class="badge bg-light text-dark ms-1"><?= count($_SESSION['cart']) ?></span>
                <?php endif; ?>
            </a>
        <?php else: ?>
            <a href="index.php?controller=dangky&action=login" class="btn btn-primary">
                <i class="fas fa-sign-in-alt me-2"></i>Đăng nhập để đăng ký
            </a>
        <?php endif; ?>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Danh sách học phần có thể đăng ký</h6>
            <?php if(isset($_SESSION['MaSV'])): ?>
                <div class="text-muted">
                    <i class="fas fa-user me-1"></i> Đang đăng nhập với: 
                    <span class="fw-bold"><?= htmlspecialchars($_SESSION['HoTen']) ?></span>
                </div>
            <?php endif; ?>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                    <thead class="table-light">
                        <tr>
                            <th>Mã học phần</th>
                            <th>Tên học phần</th>
                            <th>Số tín chỉ</th>
                            <th width="15%">Số lượng còn lại</th>
                            <th width="15%">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($hocphan = $stmt->fetch(PDO::FETCH_ASSOC)): 
                            $soLuongConLai = isset($hocphan['SoLuongDuKien']) ? $hocphan['SoLuongDuKien'] - $hocphan['SoLuongDaDangKy'] : 'Không giới hạn';
                            $disabledBtn = (is_numeric($soLuongConLai) && $soLuongConLai <= 0) ? 'disabled' : '';
                            $progressValue = is_numeric($soLuongConLai) && $hocphan['SoLuongDuKien'] > 0 ? 
                                100 - (($soLuongConLai / $hocphan['SoLuongDuKien']) * 100) : 0;
                            
                            // Xác định màu sắc cho progress bar
                            $progressColor = 'bg-success';
                            if ($progressValue >= 70 && $progressValue < 90) {
                                $progressColor = 'bg-warning';
                            } else if ($progressValue >= 90) {
                                $progressColor = 'bg-danger';
                            }
                        ?>
                        <tr>
                            <td><?= htmlspecialchars($hocphan['MaHP']) ?></td>
                            <td>
                                <strong><?= htmlspecialchars($hocphan['TenHP']) ?></strong>
                            </td>
                            <td>
                                <span class="badge bg-info text-dark"><?= (int)$hocphan['SoTinChi'] ?> tín chỉ</span>
                            </td>
                            <td>
                                <?php if(is_numeric($soLuongConLai)): ?>
                                    <div class="d-flex align-items-center">
                                        <span class="me-2"><?= $soLuongConLai ?></span>
                                        <div class="progress flex-grow-1" style="height: 10px;">
                                            <div class="progress-bar <?= $progressColor ?>" role="progressbar" 
                                                style="width: <?= $progressValue ?>%;" 
                                                aria-valuenow="<?= $progressValue ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                    <small class="text-muted"><?= $hocphan['SoLuongDaDangKy'] ?>/<?= $hocphan['SoLuongDuKien'] ?> đã đăng ký</small>
                                <?php else: ?>
                                    <span class="text-success"><?= $soLuongConLai ?></span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if(isset($_SESSION['MaSV'])): ?>
                                    <a href="index.php?controller=dangky&action=add&id=<?= $hocphan['MaHP'] ?>" 
                                        class="btn btn-success btn-sm <?= $disabledBtn ?>" <?= $disabledBtn ?>>
                                        <i class="fas fa-plus-circle me-1"></i>Đăng ký
                                    </a>
                                <?php else: ?>
                                    <a href="index.php?controller=dangky&action=login" class="btn btn-outline-primary btn-sm">
                                        <i class="fas fa-sign-in-alt me-1"></i>Đăng nhập
                                    </a>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php require_once 'app/views/shares/footer.php'; ?>