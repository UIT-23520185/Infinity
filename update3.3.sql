
CREATE TABLE HOPTHU (
    MAHT INT PRIMARY KEY AUTO_INCREMENT,
    MAUV INT,
    MANTD INT,
    TIEUDE TEXT NOT NULL,
    THONGDIEP TEXT NOT NULL,
	FOREIGN KEY (MAUV) REFERENCES UNGVIEN(MAUV),
    FOREIGN KEY (MANTD) REFERENCES NHATUYENDUNG(MANTD)
    );

INSERT INTO HOPTHU (MAUV, MANTD,TIEUDE, THONGDIEP) VALUES
(7, 1,'Kết quả ứng tuyển' ,'Xin chào Nguyen Van A, tôi xin chúc mừng bạn đã được ứng tuyển để thử việc tại công ty chúng tôi. Bạn có thể thử việc vào thứ 2 tuần sau. Mọi thắc mắc xin liên hệ qua email của công ty.');