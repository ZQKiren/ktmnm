<?php require_once 'app/views/shares/header.php'; ?>

<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 text-gray-800">Đăng ký học phần thành công</h1>
        <div>
            <a href="index.php?controller=hocphan&action=list" class="btn btn-primary me-2">
                <i class="fas fa-clipboard-list me-2"></i>Tiếp tục đăng ký
            </a>
            <a href="index.php?controller=dangky&action=history" class="btn btn-info">
                <i class="fas fa-history me-2"></i>Xem lịch sử đăng ký
            </a>
        </div>
    </div>
    
    <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
        <div class="d-flex align-items-center">
            <div class="alert-icon me-3">
                <i class="fas fa-check-circle fa-2x"></i>
            </div>
            <div>
                <h5 class="alert-heading mb-1">Đăng ký học phần thành công!</h5>
                <p class="mb-0">Bạn đã đăng ký học phần thành công. Chi tiết đăng ký như dưới đây.</p>
            </div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
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
                        <h5 class="font-weight-bold"><?= htmlspecialchars($dangky['HoTen']) ?></h5>
                        <p class="mb-1">Mã SV: <strong><?= htmlspecialchars($dangky['MaSV']) ?></strong></p>
                        <p class="mb-1">Ngày sinh: <strong><?= date('d/m/Y', strtotime($dangky['NgaySinh'])) ?></strong></p>
                        <p>Ngành học: <strong><?= htmlspecialchars($dangky['TenNganh']) ?></strong></p>
                    </div>
                    
                    <div class="mb-3">
                        <h6 class="font-weight-bold">Thông tin đăng ký</h6>
                        <hr>
                        <div class="row mb-2">
                            <div class="col-5 text-muted">Mã đăng ký:</div>
                            <div class="col-7">
                                <span class="badge bg-primary"><?= $dangky['MaDK'] ?></span>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-5 text-muted">Ngày đăng ký:</div>
                            <div class="col-7"><?= date('d/m/Y', strtotime($dangky['NgayDK'])) ?></div>
                        </div>
                    </div>
                    
                    <a href="javascript:window.print();" class="btn btn-outline-primary w-100">
                        <i class="fas fa-print me-2"></i>In thông tin đăng ký
                    </a>
                </div>
            </div>
        </div>

        <div class="col-xl-8">
            <!-- Học phần đã đăng ký -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-list-alt me-2"></i>Danh sách học phần đã đăng ký
                    </h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                            <thead class="table-light">
                                <tr>
                                    <th width="8%">#</th>
                                    <th width="15%">Mã học phần</th>
                                    <th>Tên học phần</th>
                                    <th width="15%">Số tín chỉ</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $i = 1;
                                $totalCredits = 0;
                                while($chitiet = $chiTietDangKy->fetch(PDO::FETCH_ASSOC)): 
                                    $totalCredits += $chitiet['SoTinChi'];
                                ?>
                                <tr>
                                    <td class="text-center"><?= $i++ ?></td>
                                    <td><?= htmlspecialchars($chitiet['MaHP']) ?></td>
                                    <td><strong><?= htmlspecialchars($chitiet['TenHP']) ?></strong></td>
                                    <td class="text-center">
                                        <span class="badge bg-info text-dark"><?= (int)$chitiet['SoTinChi'] ?> tín chỉ</span>
                                    </td>
                                </tr>
                                <?php endwhile; ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3" class="text-end fw-bold">Tổng số tín chỉ:</td>
                                    <td class="text-center fw-bold text-primary"><?= $totalCredits ?></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
            
            <!-- Ghi chú -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-info-circle me-2"></i>Lưu ý
                    </h6>
                </div>
                <div class="card-body">
                    <ul class="mb-0">
                        <li class="mb-2">Việc đăng ký học phần đã được lưu vào cơ sở dữ liệu.</li>
                        <li class="mb-2">Bạn có thể xem lại thông tin đăng ký trong mục <a href="index.php?controller=dangky&action=history" class="fw-bold">Lịch sử đăng ký</a>.</li>
                        <li class="mb-2">Các thay đổi về lịch học sẽ được thông báo qua email sinh viên.</li>
                        <li>Nếu có bất kỳ thắc mắc nào, vui lòng liên hệ phòng đào tạo để được hỗ trợ.</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once 'app/views/shares/footer.php'; ?>