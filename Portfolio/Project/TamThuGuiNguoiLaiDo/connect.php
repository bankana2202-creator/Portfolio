<?php
$servername = "localhost";   // Thường là localhost
$username   = "root";        // Tài khoản MySQL (mặc định phpMyAdmin dùng root)
$password   = "";            // Mật khẩu (nếu có)
$database   = "university"; // Đặt tên DB bạn muốn kết nối

// Tạo kết nối
$conn = new mysqli($servername, $username, $password, $database);
