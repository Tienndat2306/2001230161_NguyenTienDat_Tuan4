-- BÀI TẬP 01: Tạo CSDL labdb
CREATE DATABASE IF NOT EXISTS labdb CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE labdb;

-- BÀI TẬP 02: Tạo bảng students với các trường cơ bản
-- BÀI TẬP 08: Thêm trường birthday (kiểu DATE) vào cấu trúc bảng students
CREATE TABLE IF NOT EXISTS students (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE,
    phone VARCHAR(20),
    birthday DATE -- BÀI TẬP 08: Cột ngày sinh của sinh viên
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- BÀI TẬP 02: Thêm dữ liệu mẫu vào bảng students
-- BÀI TẬP 08: Cập nhật thông tin ngày sinh cho các sinh viên mẫu
INSERT INTO students (name, email, phone, birthday) VALUES
('Nguyen Van A', 'a@example.com', '0123456789', '2003-01-15'),
('Tran Thi B', 'b@example.com', '0987654321', '2004-05-22'),
('Le Van C', 'c@example.com', '0912345678', '2003-11-30'),
('Pham Thi D', 'd@example.com', '0923456789', '2002-08-14'),
('Hoang Van E', 'e@example.com', '0934567890', '2003-03-05'),
('Vu Thi F', 'f@example.com', '0945678901', '2004-07-19'),
('Ngo Van G', 'g@example.com', '0956789012', '2002-12-01'),
('Do Thi H', 'h@example.com', '0967890123', '2003-06-10')
ON DUPLICATE KEY UPDATE 
    name=VALUES(name), 
    phone=VALUES(phone), 
    birthday=VALUES(birthday);

