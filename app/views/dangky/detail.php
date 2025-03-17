<?php require_once 'app/views/shares/header.php'; ?>

<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 text-gray-800">Chi tiết đăng ký học phần</h1>
        <div>
            <a href="index.php?controller=dangky&action=history" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>Quay lại lịch sử
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-4">
            <!-- Thông tin đăng ký -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-file-alt me-2"></i>Thông tin đăng ký
                    </h6>
                </div>
                <div class="card-body">
                    <div class="alert alert-primary mb-4">
                        <div class="d-flex">
                            <div class="alert-icon me-3">
                                <i class="fas fa-info-circle fa-2x"></i>
                            </div>
                            <div>
                                <h6 class="alert-heading mb-1">Mã đăng ký: <?= $dangky['MaDK'] ?></h6>
                                <p class="mb-0">Ngày đăng ký: <?= date('d/m/Y', strtotime($dangky['NgayDK'])) ?></p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <h6 class="font-weight-bold">Thông tin sinh viên</h6>
                        <hr>
                        <div class="row mb-2">
                            <div class="col-5 text-muted">Mã sinh viên:</div>
                            <div class="col-7"><?= htmlspecialchars($dangky['MaSV']) ?></div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-5 text-muted">Họ tên:</div>
                            <div class="col-7"><?= htmlspecialchars($dangky['HoTen']) ?></div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-5 text-muted">Ngày sinh:</div>
                            <div class="col-7"><?= date('d/m/Y', strtotime($dangky['NgaySinh'])) ?></div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-5 text-muted">Ngành học:</div>
                            <div class="col-7"><?= htmlspecialchars($dangky['TenNganh']) ?></div>
                        </div>
                    </div>
                    
                    <a href="javascript:window.print();" class="btn btn-outline-primary w-100">
                        <i class="fas fa-print me-2"></i>In thông tin đăng ký
                    </a>
                </div>
            </div>
        </div>

        <div class="col-xl-8">
            <!-- Danh sách học phần -->
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
                        <li class="mb-2">Thông tin đăng ký này đã được xác nhận trong hệ thống.</li>
                        <li class="mb-2">Sinh viên vui lòng theo dõi lịch học trên trang thông tin của trường.</li>
                        <li class="mb-2">Thời gian học chính thức sẽ được thông báo qua email sinh viên.</li>
                        <li>Nếu có bất kỳ thắc mắc nào, vui lòng liên hệ phòng đào tạo để được hỗ trợ.</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once 'app/views/shares/footer.php'; ?>