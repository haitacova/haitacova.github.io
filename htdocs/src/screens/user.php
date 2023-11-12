

<div class="mb-3">

   <div class="row text-center justify-content-center row-cols-3 row-cols-lg-6 g-1 g-lg-1">

      <div class="col"><a class="btn btn-sm btn-warning w-100 fw-semibold <?php echo $tab == "profile" ? "active" : "false"?>" href="/?page=user&tab=profile" style="background-color: rgb(255, 180, 115);"> Tài khoản</a></div>

      <div class="col"><a class="btn btn-sm btn-warning w-100 fw-semibold <?php echo $tab == "webshop" ? "active" : "false"?>" href="/?page=user&tab=webshop" style="background-color: rgb(255, 180, 115);"> Cửa hàng</a></div>

      <div class="col"><a class="btn btn-sm btn-warning w-100 fw-semibold <?php echo $tab == "transactions" ? "active" : "false"?>" href="/?page=user&tab=transactions" style="background-color: rgb(255, 180, 115);"> Lịch sử GD</a></div>
      <?php
      if($user['username'] == 'admin') {
         echo'<div class="col"><a class="btn btn-sm btn-warning w-100 fw-semibold '; echo $tab == "quanly-user" ? "active" : "false"; echo'" href="/?page=user&tab=quanly-user" style="background-color: rgb(255, 180, 115);"> Quản Lý user</a></div>';
         echo'<div class="col"><a class="btn btn-sm btn-warning w-100 fw-semibold '; echo $tab == "quan-lyshop" ? "active" : "false"; echo'" href="/?page=user&tab=quan-lyshop" style="background-color: rgb(255, 180, 115);"> Quản Lý shop</a></div>';
         echo'<div class="col"><a class="btn btn-sm btn-warning w-100 fw-semibold '; echo $tab == "cong-vnd" ? "active" : "false"; echo'" href="/?page=user&tab=cong-vnd" style="background-color: rgb(255, 180, 115);"> Cộng Vnd</a></div>';
      }
      ?>
   </div>

</div>

<hr>

<?php

   if($tab == "profile") include_once('user/profile.php');

   if($tab == "webshop") include_once('user/shopwebitem.php');
   
   if($tab == "transactions") include_once('user/transactions.php');

   if($tab == "quanly-user") include_once('admin.php');

   if($tab == "quan-lyshop") include_once('quan-lyshop.php');

   if($tab == "change-password") include_once('user/change-password.php');

   if($tab == "change-phone") include_once('user/change-phone.php');

   if($tab == "change-mail") include_once('user/change-mail.php');

   if($tab == "cong-vnd") include_once('buffvnd.php');

?>