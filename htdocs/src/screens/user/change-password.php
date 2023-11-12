<?php 
   if(isset($_POST['changepass'])) {
      $current_password = $_POST['current_password'];
      $password = $_POST['password'];
      $confirm_password = $_POST['confirm_password'];
      $username = $user['username'];
      if($current_password == '' || $password == '' || $confirm_password == '') {
         $_SESSION['message'] = "Không được bỏ trống!";
         header("Location: /?page=user&tab=change-password");
         exit(0);
      } else {
         $checkUser = SQL()->query("SELECT username from users where username = '".$username."' and password = '".$current_password."' limit 1");
         if($checkUser == false || $checkUser->num_rows < 1){
            $_SESSION['message'] = "Mật khẩu cũ không chính xác!";
            header("Location: /?page=user&tab=change-password");
            exit(0);
         } else {
            if($password != $confirm_password) {
               $_SESSION['message'] = "Mật khẩu mới không trùng nhau!";
               header("Location: /?page=user&tab=change-password");
               exit(0);
            } else {
               $sql = SQL()->query("UPDATE `users` set `password` = '".$password."' where `username` = '".$username."' and `password` = '".$current_password."'");
               if($sql){
                  $_SESSION['message'] = "Đổi mật khẩu thành công!";
                  header("Location: /?page=user&tab=change-password");
                  session_start();
                  session_destroy();
                  exit(0);
               } else {
                  $_SESSION['message'] = "Có lỗi gì đó xảy ra. Vui lòng liên hệ Admin!";
                  header("Location: /?page=user&tab=change-password");
                  exit(0);
               }
            }
         }
      }
   }
?>

<div class="w-100 d-flex justify-content-center">
   <form action="" class="pb-3" style="width: 26rem;" method="POST">
      <div class="fs-5 fw-bold text-center mb-3">Đổi mật khẩu</div>
      <?php include('message.php'); ?>
      <div class="mb-2">
         <div class="input-group">
            <input name="current_password" id="current_password" type="text" autocomplete="off" placeholder="Nhập mật khẩu hiện tại" class="form-control form-control-solid" value="">
            <div class="invalid-feedback">Không được bỏ trống</div>
         </div>
      </div>
      <div class="mb-2">
         <div class="input-group">
            <input name="password" id="password" type="password" autocomplete="off" placeholder="Mật khẩu" class="form-control form-control-solid" value="">
            <div class="invalid-feedback">Không được bỏ trống</div>
         </div>
      </div>
      <div class="mb-2">
         <div class="input-group">
            <input name="confirm_password" id="confirm_password" type="password" autocomplete="off" placeholder="Nhập lại mật khẩu" class="form-control form-control-solid" value="">
            <div class="invalid-feedback">Không được bỏ trống</div>
         </div>
      </div>
      <div class="text-center mt-3"><button type="submit" name="changepass" class="me-3 btn btn-primary">Đổi mật khẩu</button></div>
   </form>
</div>