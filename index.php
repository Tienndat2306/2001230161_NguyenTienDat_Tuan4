<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=device-width, initial-scale=1.0">
    <title>Báo cáo bài tập Buổi 4 (1 - 11) - Nguyễn Anh Quân</title>
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
    <style>
        .exercise-card {
            border-radius: 12px;
            border: 1px solid var(--border-color);
            transition: all 0.3s ease;
            height: 100%;
        }
        .exercise-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px -5px rgba(79, 70, 229, 0.15), 0 8px 10px -6px rgba(79, 70, 229, 0.1);
            border-color: #818cf8;
        }
        .badge-status {
            background-color: #ecfdf5;
            color: #059669;
            font-weight: 600;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 0.75rem;
        }
        .badge-number {
            background-color: var(--primary-color);
            color: white;
            font-weight: 700;
            border-radius: 50%;
            width: 32px;
            height: 32px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
        .file-tag {
            background-color: #f1f5f9;
            color: #475569;
            font-size: 0.75rem;
            padding: 3px 8px;
            border-radius: 6px;
            font-family: SFMono-Regular, Menlo, Monaco, Consolas, monospace;
            text-decoration: none;
            display: inline-block;
        }
        .file-tag:hover {
            background-color: #e2e8f0;
            color: var(--primary-color);
        }
    </style>
</head>
<body>

    <header class="app-header">
        <div class="container text-center">
            <h1 class="app-title">Báo Cáo Phân Chia Thư Mục (Bài 1 - 11)</h1>
            <p class="lead mb-0 text-white-50">Họ và tên: Nguyễn Anh Quân - MSSV: 2001230717</p>
            <div class="mt-3">
                <span class="badge bg-success px-3 py-2 rounded-pill fs-6">Đã phân tách và hoàn thành 11/11 Bài tập riêng biệt</span>
            </div>
        </div>
    </header>

    <main class="container mb-5">
        <div class="row g-4">
            
            <!-- Bài tập 01 -->
            <div class="col-md-6 col-lg-4">
                <div class="card exercise-card p-3 d-flex flex-column">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="badge-number">01</span>
                        <span class="badge-status">Hoàn thành</span>
                    </div>
                    <h5 class="card-title fw-bold text-dark">Kết nối CSDL bằng PDO</h5>
                    <p class="card-text text-muted flex-grow-1">Viết chương trình PHP kết nối tới CSDL MySQL bằng thư viện PDO.</p>
                    <div class="mb-3">
                        <span class="file-tag">baitap01/connect.php</span>
                    </div>
                    <a href="baitap01/connect.php" target="_blank" class="btn btn-primary w-100">Chạy thử Kết nối</a>
                </div>
            </div>

            <!-- Bài tập 02 -->
            <div class="col-md-6 col-lg-4">
                <div class="card exercise-card p-3 d-flex flex-column">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="badge-number">02</span>
                        <span class="badge-status">Hoàn thành</span>
                    </div>
                    <h5 class="card-title fw-bold text-dark">Tạo bảng & Dữ liệu mẫu</h5>
                    <p class="card-text text-muted flex-grow-1">Tạo bảng sinh viên <code>students</code> và khởi tạo dữ liệu ban đầu.</p>
                    <div class="mb-3">
                        <span class="file-tag">baitap02/db_setup.sql</span>
                    </div>
                    <a href="baitap02/index.php" target="_blank" class="btn btn-primary w-100">Xem mã lệnh SQL</a>
                </div>
            </div>

            <!-- Bài tập 03 -->
            <div class="col-md-6 col-lg-4">
                <div class="card exercise-card p-3 d-flex flex-column">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="badge-number">03</span>
                        <span class="badge-status">Hoàn thành</span>
                    </div>
                    <h5 class="card-title fw-bold text-dark">Hiển thị danh sách SV</h5>
                    <p class="card-text text-muted flex-grow-1">Truy vấn dữ liệu thô và hiển thị dạng bảng HTML (chưa tìm kiếm/phân trang).</p>
                    <div class="mb-3">
                        <span class="file-tag">baitap03/list_students.php</span>
                    </div>
                    <a href="baitap03/list_students.php" target="_blank" class="btn btn-primary w-100">Xem danh sách sinh viên</a>
                </div>
            </div>

            <!-- Bài tập 04 -->
            <div class="col-md-6 col-lg-4">
                <div class="card exercise-card p-3 d-flex flex-column">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="badge-number">04</span>
                        <span class="badge-status">Hoàn thành</span>
                    </div>
                    <h5 class="card-title fw-bold text-dark">Thêm sinh viên mới</h5>
                    <p class="card-text text-muted flex-grow-1">Tạo Form điền thông tin và thực hiện chèn bản ghi vào cơ sở dữ liệu.</p>
                    <div class="mb-3">
                        <span class="file-tag">baitap04/list_students.php</span>
                    </div>
                    <a href="baitap04/list_students.php" target="_blank" class="btn btn-primary w-100">Mở danh mục Bài 4</a>
                </div>
            </div>

            <!-- Bài tập 05 -->
            <div class="col-md-6 col-lg-4">
                <div class="card exercise-card p-3 d-flex flex-column">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="badge-number">05</span>
                        <span class="badge-status">Hoàn thành</span>
                    </div>
                    <h5 class="card-title fw-bold text-dark">Xóa sinh viên</h5>
                    <p class="card-text text-muted flex-grow-1">Xóa sinh viên dựa vào ID, tích hợp hộp thoại hỏi ý kiến xác nhận (Confirm).</p>
                    <div class="mb-3">
                        <span class="file-tag">baitap05/list_students.php</span>
                    </div>
                    <a href="baitap05/list_students.php" target="_blank" class="btn btn-primary w-100">Mở danh mục Bài 5</a>
                </div>
            </div>

            <!-- Bài tập 06 -->
            <div class="col-md-6 col-lg-4">
                <div class="card exercise-card p-3 d-flex flex-column">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="badge-number">06</span>
                        <span class="badge-status">Hoàn thành</span>
                    </div>
                    <h5 class="card-title fw-bold text-dark">Sửa & Cập nhật thông tin</h5>
                    <p class="card-text text-muted flex-grow-1">Tải dữ liệu cũ lên Form và cập nhật chỉnh sửa của sinh viên.</p>
                    <div class="mb-3">
                        <span class="file-tag">baitap06/list_students.php</span>
                    </div>
                    <a href="baitap06/list_students.php" target="_blank" class="btn btn-primary w-100">Mở danh mục Bài 6</a>
                </div>
            </div>

            <!-- Bài tập 07 -->
            <div class="col-md-6 col-lg-4">
                <div class="card exercise-card p-3 d-flex flex-column">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="badge-number">07</span>
                        <span class="badge-status">Hoàn thành</span>
                    </div>
                    <h5 class="card-title fw-bold text-dark">Phân trang dữ liệu</h5>
                    <p class="card-text text-muted flex-grow-1">Phân chia dữ liệu sinh viên hiển thị theo trang (tối đa 5 bản ghi/trang).</p>
                    <div class="mb-3">
                        <span class="file-tag">baitap07/list_students.php</span>
                    </div>
                    <a href="baitap07/list_students.php" target="_blank" class="btn btn-primary w-100">Mở danh mục Bài 7</a>
                </div>
            </div>

            <!-- Bài tập 08 -->
            <div class="col-md-6 col-lg-4">
                <div class="card exercise-card p-3 d-flex flex-column">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="badge-number">08</span>
                        <span class="badge-status">Hoàn thành</span>
                    </div>
                    <h5 class="card-title fw-bold text-dark">Thêm cột Ngày sinh</h5>
                    <p class="card-text text-muted flex-grow-1">Mở rộng CSDL thêm cột <code>birthday</code>, cập nhật form và giao diện hiển thị.</p>
                    <div class="mb-3">
                        <span class="file-tag">baitap08/list_students.php</span>
                    </div>
                    <a href="baitap08/list_students.php" target="_blank" class="btn btn-primary w-100">Mở danh mục Bài 8</a>
                </div>
            </div>

            <!-- Bài tập 09 -->
            <div class="col-md-6 col-lg-4">
                <div class="card exercise-card p-3 d-flex flex-column">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="badge-number">09</span>
                        <span class="badge-status">Hoàn thành</span>
                    </div>
                    <h5 class="card-title fw-bold text-dark">Tìm kiếm sinh viên</h5>
                    <p class="card-text text-muted flex-grow-1">Viết bộ lọc tìm kiếm sinh viên gần đúng theo Họ tên (LIKE SQL).</p>
                    <div class="mb-3">
                        <span class="file-tag">baitap09/list_students.php</span>
                    </div>
                    <a href="baitap09/list_students.php" target="_blank" class="btn btn-primary w-100">Mở danh mục Bài 9</a>
                </div>
            </div>

            <!-- Bài tập 10 -->
            <div class="col-md-6 col-lg-4">
                <div class="card exercise-card p-3 d-flex flex-column">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="badge-number">10</span>
                        <span class="badge-status">Hoàn thành</span>
                    </div>
                    <h5 class="card-title fw-bold text-dark">Prepared Statement</h5>
                    <p class="card-text text-muted flex-grow-1">Chuyển toàn bộ câu truy vấn sang Prepared Statement phòng chống SQL Injection.</p>
                    <div class="mb-3">
                        <span class="file-tag">baitap10/list_students.php</span>
                    </div>
                    <a href="baitap10/list_students.php" target="_blank" class="btn btn-primary w-100">Mở danh mục Bài 10</a>
                </div>
            </div>

            <!-- Bài tập 11 -->
            <div class="col-md-6 col-lg-4">
                <div class="card exercise-card p-3 d-flex flex-column">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="badge-number">11</span>
                        <span class="badge-status">Hoàn thành</span>
                    </div>
                    <h5 class="card-title fw-bold text-dark">Sắp xếp theo cột</h5>
                    <p class="card-text text-muted flex-grow-1">Thêm tính năng nhấn vào tiêu đề cột để sắp xếp tăng/giảm dần theo Họ tên, Email.</p>
                    <div class="mb-3">
                        <span class="file-tag">baitap11/list_students.php</span>
                    </div>
                    <a href="baitap11/list_students.php" target="_blank" class="btn btn-primary w-100">Mở danh mục Bài 11 (Full)</a>
                </div>
            </div>

        </div>
    </main>

    <footer class="text-center py-4 bg-white border-top text-muted mt-auto">
        <div class="container">
            <small>&copy; 2026 - Nguyễn Anh Quân (2001230717) - Lập trình mã nguồn mở - Khoa CNTT - HUIT</small>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
