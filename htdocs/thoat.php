<?php   
	session_start(); // Kiểm tra username đăng nhập trước
	session_destroy(); // Xóa username ra khỏi phiên đăng nhập
	header("location:/"); // Trang chuyển hướng sau khi đăng xuất
	exit();
?>