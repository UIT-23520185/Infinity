INSERT INTO TAIKHOAN (USERNAME, PASSWORD, HOTEN, MAVTTK, NGDKTK) VALUES 
('ntd_congtyabc', '123456', 'Công ty ABC', 2, '2025-06-01');
INSERT INTO NHATUYENDUNG (TENNTD, EMAIL, DIACHI)
VALUES 
('Công ty ABC', 'tuyendung@abc.com', 'Quận 1, TP.HCM');
INSERT INTO BAIDANG (
    TENCV, TENNGANH, HTLV, LUONG, KINHNGHIEM, CAPBAC, DIACHI,
    PHUCLOI, MOTACV, YEUCAUCV, THOIGIANLV, TTKHAC, HINHANH, MANTD
)
VALUES (
    'Lập trình viên PHP', 'Công nghệ thông tin', 'Toàn thời gian', '10-15 triệu', 
    '2 năm', 'Nhân viên', 'TP.HCM',
    'Bảo hiểm, Du lịch, Phụ cấp ăn trưa', 
    'Phát triển và bảo trì hệ thống web', 
    'Biết Laravel, MySQL, Git', 
    'Thứ 2 - Thứ 6, 9h-17h', 
    'Ưu tiên người có kinh nghiệm thực tế', 
    'php-job.png',
    1
);
CREATE TABLE LUUTIN (
    MALUU INT PRIMARY KEY AUTO_INCREMENT,
    MAUV INT NOT NULL,         -- Ứng viên lưu tin
    MABD INT NOT NULL,         -- Tin được lưu
    NGAYLUU DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (MAUV) REFERENCES UNGVIEN(MAUV),
    FOREIGN KEY (MABD) REFERENCES BAIDANG(MABD),
    UNIQUE (MAUV, MABD)        -- Không cho lưu trùng cùng một tin
);
INSERT INTO TAIKHOAN (USERNAME, PASSWORD, HOTEN, MAVTTK, NGDKTK) VALUES 
('ntd_congtyxyz', 'abcdef', 'Công ty XYZ', 2, '2025-06-05');

INSERT INTO NHATUYENDUNG (TENNTD, EMAIL, DIACHI)
VALUES 
('Công ty XYZ', 'tuyendung@xyz.com', 'Quận 3, TP.HCM');

INSERT INTO BAIDANG (
    TENCV, TENNGANH, HTLV, LUONG, KINHNGHIEM, CAPBAC, DIACHI,
    PHUCLOI, MOTACV, YEUCAUCV, THOIGIANLV, TTKHAC, HINHANH, MANTD
)
VALUES (
    'Chuyên viên Marketing', 'Marketing', 'Bán thời gian', '7-10 triệu',
    '1 năm', 'Nhân viên', 'Hồ Chí Minh',
    'Môi trường thân thiện, Thưởng KPI', 
    'Lên kế hoạch và triển khai chiến dịch Marketing', 
    'Biết Digital Marketing, SEO, Facebook Ads', 
    'Thứ 2 - Thứ 7, 8h-12h', 
    'Ưu tiên người năng động và sáng tạo', 
    'marketing-job.png',
    2
);