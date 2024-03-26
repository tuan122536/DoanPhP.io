<?php
// login.php

include 'database_operations1.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Truy vấn kiểm tra thông tin đăng nhập
    $conn = connectDB();
    $sql = "SELECT * FROM TaiKhoan WHERE Username='$username' AND Password='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        // Lấy loại tài khoản của người dùng
        $row = $result->fetch_assoc();
        $loaiTaiKhoan = $row['LoaiTaiKhoan'];

        // Đăng nhập thành công
        session_start();
        $_SESSION["username"] = $username;

        // Chuyển hướng dựa trên loại tài khoản
        if ($loaiTaiKhoan == 'admin') {
            header("Location: home.php"); // Chuyển hướng đến trang chính cho admin
        } else if ($loaiTaiKhoan == 'user') {
            header("Location: userindex.php"); // Chuyển hướng đến trang chính cho người dùng
        }
        exit();
    } else {
        // Đăng nhập không thành công
        echo "Tên người dùng hoặc mật khẩu không đúng.";
    }
    $conn->close();
}

?>
