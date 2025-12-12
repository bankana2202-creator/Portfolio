# 🚀 Hướng dẫn chạy Portfolio trên XAMPP

## Cách setup và chạy

### 1. Copy folder Portfolio vào XAMPP
```
C:\xampp\htdocs\Portfolio\
```

Hoặc nơi bạn cài XAMPP (thường là `C:\xampp\htdocs\`)

### 2. Khởi động XAMPP
1. Mở **XAMPP Control Panel**
2. Click **Start** cho **Apache** 
3. Nếu project cần database, click **Start** cho **MySQL** (project TamThuGuiNguoiLaiDo cần MySQL)

### 3. Truy cập Portfolio
Mở trình duyệt và truy cập:
```
http://localhost/Portfolio/
```

Hoặc nếu bạn đổi tên folder:
```
http://localhost/[tên-folder-của-bạn]/
```

### 4. Setup Database cho project TamThuGuiNguoiLaiDo (nếu cần)

Project "Tâm Thư Gửi Người Lái Đò" sử dụng PHP và MySQL. Để chạy đầy đủ:

1. **Tạo Database:**
   - Truy cập: `http://localhost/phpmyadmin`
   - Tạo database mới tên: `tam_thu_db` (hoặc tên khác tùy file `connect.php`)
   
2. **Import Database Structure:**
   - Kiểm tra trong folder `Project/TamThuGuiNguoiLaiDo/` có file `.sql` không
   - Nếu có, import vào database vừa tạo

3. **Kiểm tra file `connect.php`:**
   ```php
   // Đảm bảo thông tin kết nối đúng:
   $servername = "localhost";
   $username = "root";
   $password = "";  // Mặc định XAMPP không có password
   $dbname = "tam_thu_db";
   ```

### 5. Test Project

Click vào project "Tâm Thư Gửi Người Lái Đò" từ Portfolio:
- Nó sẽ redirect sang `index.php`
- PHP sẽ được xử lý bởi XAMPP Apache
- Website sẽ hiển thị đầy đủ chức năng

## ❗ Lỗi thường gặp

### Lỗi: "Index of /" hiển thị
**Nguyên nhân:** Chưa có file index.php hoặc index.html  
**Giải pháp:** Kiểm tra lại folder có đúng cấu trúc không

### Lỗi: CSS không load
**Nguyên nhân:** Đường dẫn CSS sai  
**Giải pháp:** 
- Kiểm tra file `style.css` có trong folder không
- Đảm bảo đường dẫn trong HTML là `./style.css` hoặc `style.css`

### Lỗi: Project PHP hiển thị code thay vì chạy
**Nguyên nhân:** Apache chưa chạy  
**Giải pháp:** 
- Đảm bảo Apache đang running trong XAMPP
- Truy cập qua `http://localhost/` chứ không mở file trực tiếp

### Lỗi: Database connection failed
**Nguyên nhân:** MySQL chưa chạy hoặc config sai  
**Giải pháp:**
- Start MySQL trong XAMPP
- Kiểm tra lại thông tin trong `connect.php`
- Đảm bảo database đã được tạo

## 📝 Cấu trúc folder đúng

```
C:\xampp\htdocs\Portfolio\
├── index.html          ← Trang chính Portfolio
├── style.css           ← CSS chính
├── script.js           ← JavaScript
├── README.md
├── assets/
├── image/
│   ├── fvc 1.png
│   └── lg 1.png
└── Project/
    └── TamThuGuiNguoiLaiDo/
        ├── index.html  ← Redirect file
        ├── index.php   ← Main PHP file
        ├── connect.php ← Database config
        ├── style.css
        └── image/
            ├── banner_goc.jpg
            └── AVT.jpg
```

## ✅ Checklist

- [ ] Folder Portfolio đã copy vào `C:\xampp\htdocs\`
- [ ] XAMPP Control Panel đã mở
- [ ] Apache đã Start (màu xanh)
- [ ] MySQL đã Start (nếu project cần)
- [ ] Truy cập thành công `http://localhost/Portfolio/`
- [ ] Click vào project và PHP chạy được

## 🆘 Cần thêm trợ giúp?

Nếu vẫn gặp lỗi, kiểm tra:
1. **XAMPP logs:** Check Apache error logs trong XAMPP Control Panel
2. **Browser Console:** Press F12 và xem tab Console có lỗi gì không
3. **File permissions:** Đảm bảo XAMPP có quyền đọc folder

---

**Lưu ý:** Portfolio chính (index.html) không cần XAMPP, chỉ project PHP bên trong mới cần!
