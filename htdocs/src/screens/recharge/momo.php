<div class="d-flex justify-content-center">
   <div class="col-md-8 mt-3">
         
      <div id="list" class="fs-5 fw-semibold text-center">Chọn mốc nạp</div>
      <div>
      <div id="noti" class="hide" style="text-align: center;">
         <div class="alert alert-danger" id="error">Chưa chọn số lượng </div>
      </div>
         <div id="list_amt" class="row text-center justify-content-center row-cols-2 row-cols-lg-3 g-2 g-lg-2 my-1 mb-2">
            <?php
               foreach($list_recharge_price_momo as $item) {
                  if($item['bonus'] > 0) {
                     echo '<div>
                     <div class="col">
                        <div class="w-100 fw-semibold cursor-pointer">
                           <div class="recharge-method-item position-relative false" style="height: 90px;">
                              <div>'.number_format($item['amount']).' đ</div>
                              <div class="center-text text-danger"><span>Nhận</span></div>
                              <div class="text-primary">'.number_format($item['amount'] + ($item['amount'] * $item['bonus'] / 100)).' P </div>
                              <span class="text-white position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="z-index: 1;">+'.$item['bonus'].'%</span>
                           </div>
                        </div>
                     </div>
                  </div>';
                  } else {
                     echo '<div>
                     <div class="col">
                        <div class="w-100 fw-semibold cursor-pointer">
                           <div class="recharge-method-item position-relative false" style="height: 90px;">
                              <div>'.number_format($item['amount']).' đ</div>
                              <div class="center-text text-danger"><span>Nhận</span></div>
                              <div class="text-primary">'.number_format($item['amount']).' P </div>
                           </div>
                        </div>
                     </div>
                  </div>';
                  }
               }
            ?>
         </div>
         <div id="momo_info">
         </div>
         <div class="text-center mt-3 momo-btn">
            <button type="button" id="payment_momo" class="w-50 rounded-3 btn btn-primary btn-sm">Xin vui lòng liên hệ AD để biết!</button>
            <button type="button" id="confirm_payment_momo" class="w-50 rounded-3 btn btn-primary btn-sm hide">Xác nhận (<span id="count"></span>)</button>
            <div class="mt-2"><small class="fw-semibold"><a href="/?page=user&tab=transactions">Lịch sử giao dịch</a></small></div>
            <div class="mt-4"><small class="fw-semibold">Lưu ý khi thanh toán: Giao dịch trên hoàn toàn được kiểm duyệt tự động, yêu cầu kiểm tra kỹ nội dung chuyển tiền trước khi thực hiện chuyển. Nếu ghi thiếu, sai hoặc quá 10 phút không thấy cộng tiền, các bạn hãy liên hệ với <a target="_blank" href="https://www.facebook.com/ninjaschoolpro" rel="noreferrer">Fanpage</a> để được hỗ trợ</small></div>
         </div>
      </div>
   </div>
</div>


      

<script>
   (function () {
   'use strict'
      var selected = -1;
      $("#list_amt div.recharge-method-item").each(function() {
         var item = this;
         item.addEventListener("click", function() {
            event.preventDefault();
            console.log($("#list_amt div.recharge-method-item").index(this))
            selected = $("#list_amt div.recharge-method-item").index(this)
            $("#list_amt div.recharge-method-item").removeClass("active")
            $("#list_amt div.recharge-method-item").addClass("false")
            $(this).removeClass("false")
            $(this).addClass("active")
         })
      })
      var btnPaymentMomo = $("button#payment_momo");
      var btnConfirmPaymentMomo = $("button#confirm_payment_momo");
      var spanCountdown = $("button#confirm_payment_momo span#count");
      var infoPaymentMomo = $("div#momo_info");
      var err = $("#noti");
      var counter = 60;
      btnPaymentMomo.click(() => {
         if(selected >= 0){
            err.addClass("hide");
            $("#list_amt").addClass('hide');
            $("#list").addClass('hide');
            var data = {
               coin: selected,
            };
            if (selected == 0) {
               infoPaymentMomo.append('<div>'+
                                       '<div class="table-responsive-sm">'+
                                          '<table class="fw-semibold mt-3 table">'+
                                             '<tbody>'+
                                                '<tr>'+
                                                   '<td>Chủ tài khoản</td>'+
                                                   '<td><?php echo $configNapTien['momo']['chutaikhoan']; ?></td>'+
                                                '</tr>'+
                                                '<tr>'+
                                                   '<td>Số điện thoại</td>'+
                                                   '<td><?php echo $configNapTien['momo']['sotaikhoan']; ?></td>'+
                                                '</tr>'+
                                                '<tr>'+
                                                   '<td>Số tiền</td>'+
                                                   '<td>10.000đ</td>'+
                                                '</tr>'+
                                                '<tr>'+
                                                   '<td>Nội dung</td>'+
                                                   '<td><?php echo $user['username']; ?></td>'+
                                                '</tr>'+
                                             '</tbody>'+
                                          '</table>'+
                                       '</div>'+
                                       '<div class="text-center fw-semibold fs-5">Quét mã để thanh toán</div>'+
                                       '<div class="text-center mt-2">'+
                                          '<img src="#" alt="">'+
                                       '</div>'+
                                    '</div>')
            } else if (selected == 1) {   
               infoPaymentMomo.append('<div>'+
                                       '<div class="table-responsive-sm">'+
                                          '<table class="fw-semibold mt-3 table">'+
                                             '<tbody>'+
                                                '<tr>'+
                                                   '<td>Chủ tài khoản</td>'+
                                                   '<td><?php echo $configNapTien['momo']['chutaikhoan']; ?></td>'+
                                                '</tr>'+
                                                '<tr>'+
                                                   '<td>Số điện thoại</td>'+
                                                   '<td><?php echo $configNapTien['momo']['sotaikhoan']; ?></td>'+
                                                '</tr>'+
                                                '<tr>'+
                                                   '<td>Số tiền</td>'+
                                                   '<td>50.000đ</td>'+
                                                '</tr>'+
                                                '<tr>'+
                                                   '<td>Nội dung</td>'+
                                                   '<td><?php echo $user['user']; ?></td>'+
                                                '</tr>'+
                                             '</tbody>'+
                                          '</table>'+
                                       '</div>'+
                                       '<div class="text-center fw-semibold fs-5">Quét mã để thanh toán</div>'+
                                       '<div class="text-center mt-2">'+
                                          '<img src="#" alt="">'+
                                       '</div>'+
                                    '</div>')
            } else if (selected == 2) {   
               infoPaymentMomo.append('<div>'+
                                       '<div class="table-responsive-sm">'+
                                          '<table class="fw-semibold mt-3 table">'+
                                             '<tbody>'+
                                                '<tr>'+
                                                   '<td>Chủ tài khoản</td>'+
                                                   '<td><?php echo $configNapTien['momo']['chutaikhoan']; ?></td>'+
                                                '</tr>'+
                                                '<tr>'+
                                                   '<td>Số điện thoại</td>'+
                                                   '<td><?php echo $configNapTien['momo']['sotaikhoan']; ?></td>'+
                                                '</tr>'+
                                                '<tr>'+
                                                   '<td>Số tiền</td>'+
                                                   '<td>100.000đ</td>'+
                                                '</tr>'+
                                                '<tr>'+
                                                   '<td>Nội dung</td>'+
                                                   '<td><?php echo $user['user']; ?></td>'+
                                                '</tr>'+
                                             '</tbody>'+
                                          '</table>'+
                                       '</div>'+
                                       '<div class="text-center fw-semibold fs-5">Quét mã để thanh toán</div>'+
                                       '<div class="text-center mt-2">'+
                                          '<img src="#" alt="">'+
                                       '</div>'+
                                    '</div>')
            } else if (selected == 3) {   
               infoPaymentMomo.append('<div>'+
                                       '<div class="table-responsive-sm">'+
                                          '<table class="fw-semibold mt-3 table">'+
                                             '<tbody>'+
                                                '<tr>'+
                                                   '<td>Chủ tài khoản</td>'+
                                                   '<td><?php echo $configNapTien['momo']['chutaikhoan']; ?></td>'+
                                                '</tr>'+
                                                '<tr>'+
                                                   '<td>Số điện thoại</td>'+
                                                   '<td><?php echo $configNapTien['momo']['sotaikhoan']; ?></td>'+
                                                '</tr>'+
                                                '<tr>'+
                                                   '<td>Số tiền</td>'+
                                                   '<td>200.000đ</td>'+
                                                '</tr>'+
                                                '<tr>'+
                                                   '<td>Nội dung</td>'+
                                                   '<td><?php echo $user['user']; ?></td>'+
                                                '</tr>'+
                                             '</tbody>'+
                                          '</table>'+
                                       '</div>'+
                                       '<div class="text-center fw-semibold fs-5">Quét mã để thanh toán</div>'+
                                       '<div class="text-center mt-2">'+
                                          '<img src="#" alt="">'+
                                       '</div>'+
                                    '</div>')
            } else if (selected == 4) {   
               infoPaymentMomo.append('<div>'+
                                       '<div class="table-responsive-sm">'+
                                          '<table class="fw-semibold mt-3 table">'+
                                             '<tbody>'+
                                                '<tr>'+
                                                   '<td>Chủ tài khoản</td>'+
                                                   '<td><?php echo $configNapTien['momo']['chutaikhoan']; ?></td>'+
                                                '</tr>'+
                                                '<tr>'+
                                                   '<td>Số điện thoại</td>'+
                                                   '<td><?php echo $configNapTien['momo']['sotaikhoan']; ?></td>'+
                                                '</tr>'+
                                                '<tr>'+
                                                   '<td>Số tiền</td>'+
                                                   '<td>500.000đ</td>'+
                                                '</tr>'+
                                                '<tr>'+
                                                   '<td>Nội dung</td>'+
                                                   '<td><?php echo $user['user']; ?></td>'+
                                                '</tr>'+
                                             '</tbody>'+
                                          '</table>'+
                                       '</div>'+
                                       '<div class="text-center fw-semibold fs-5">Quét mã để thanh toán</div>'+
                                       '<div class="text-center mt-2">'+
                                          '<img src="#" alt="">'+
                                       '</div>'+
                                    '</div>')
            } else if (selected == 5) {   
               infoPaymentMomo.append('<div>'+
                                       '<div class="table-responsive-sm">'+
                                          '<table class="fw-semibold mt-3 table">'+
                                             '<tbody>'+
                                                '<tr>'+
                                                   '<td>Chủ tài khoản</td>'+
                                                   '<td><?php echo $configNapTien['momo']['chutaikhoan']; ?></td>'+
                                                '</tr>'+
                                                '<tr>'+
                                                   '<td>Số điện thoại</td>'+
                                                   '<td><?php echo $configNapTien['momo']['sotaikhoan']; ?></td>'+
                                                '</tr>'+
                                                '<tr>'+
                                                   '<td>Số tiền</td>'+
                                                   '<td>1.000.000đ</td>'+
                                                '</tr>'+
                                                '<tr>'+
                                                   '<td>Nội dung</td>'+
                                                   '<td><?php echo $user['user']; ?></td>'+
                                                '</tr>'+
                                             '</tbody>'+
                                          '</table>'+
                                       '</div>'+
                                       '<div class="text-center fw-semibold fs-5">Quét mã để thanh toán</div>'+
                                       '<div class="text-center mt-2">'+
                                          '<img src="#" alt="">'+
                                       '</div>'+
                                    '</div>')
            } else if (selected == 6) {   
               infoPaymentMomo.append('<div>'+
                                       '<div class="table-responsive-sm">'+
                                          '<table class="fw-semibold mt-3 table">'+
                                             '<tbody>'+
                                                '<tr>'+
                                                   '<td>Chủ tài khoản</td>'+
                                                   '<td><?php echo $configNapTien['momo']['chutaikhoan']; ?></td>'+
                                                '</tr>'+
                                                '<tr>'+
                                                   '<td>Số điện thoại</td>'+
                                                   '<td><?php echo $configNapTien['momo']['sotaikhoan']; ?></td>'+
                                                '</tr>'+
                                                '<tr>'+
                                                   '<td>Số tiền</td>'+
                                                   '<td>2.000.000đ</td>'+
                                                '</tr>'+
                                                '<tr>'+
                                                   '<td>Nội dung</td>'+
                                                   '<td><?php echo $user['user']; ?></td>'+
                                                '</tr>'+
                                             '</tbody>'+
                                          '</table>'+
                                       '</div>'+
                                       '<div class="text-center fw-semibold fs-5">Quét mã để thanh toán</div>'+
                                       '<div class="text-center mt-2">'+
                                          '<img src="#" alt="">'+
                                       '</div>'+
                                    '</div>')
            } else if (selected == 7) {   
               infoPaymentMomo.append('<div>'+
                                       '<div class="table-responsive-sm">'+
                                          '<table class="fw-semibold mt-3 table">'+
                                             '<tbody>'+
                                                '<tr>'+
                                                   '<td>Chủ tài khoản</td>'+
                                                   '<td><?php echo $configNapTien['momo']['chutaikhoan']; ?></td>'+
                                                '</tr>'+
                                                '<tr>'+
                                                   '<td>Số điện thoại</td>'+
                                                   '<td><?php echo $configNapTien['momo']['sotaikhoan']; ?></td>'+
                                                '</tr>'+
                                                '<tr>'+
                                                   '<td>Số tiền</td>'+
                                                   '<td>5.000.000đ</td>'+
                                                '</tr>'+
                                                '<tr>'+
                                                   '<td>Nội dung</td>'+
                                                   '<td><?php echo $user['user']; ?></td>'+
                                                '</tr>'+
                                             '</tbody>'+
                                          '</table>'+
                                       '</div>'+
                                       '<div class="text-center fw-semibold fs-5">Quét mã để thanh toán</div>'+
                                       '<div class="text-center mt-2">'+
                                          '<img src="#" alt="">'+
                                       '</div>'+
                                    '</div>')
            } else {   
               infoPaymentMomo.append('<div>'+
                                       '<div class="table-responsive-sm">'+
                                          '<table class="fw-semibold mt-3 table">'+
                                             '<tbody>'+
                                                '<tr>'+
                                                   '<td>Chủ tài khoản</td>'+
                                                   '<td><?php echo $configNapTien['momo']['chutaikhoan']; ?></td>'+
                                                '</tr>'+
                                                '<tr>'+
                                                   '<td>Số điện thoại</td>'+
                                                   '<td><?php echo $configNapTien['momo']['sotaikhoan']; ?></td>'+
                                                '</tr>'+
                                                '<tr>'+
                                                   '<td>Số tiền</td>'+
                                                   '<td>10.000.000đ</td>'+
                                                '</tr>'+
                                                '<tr>'+
                                                   '<td>Nội dung</td>'+
                                                   '<td><?php echo $user['user']; ?></td>'+
                                                '</tr>'+
                                             '</tbody>'+
                                          '</table>'+
                                       '</div>'+
                                       '<div class="text-center fw-semibold fs-5">Quét mã để thanh toán</div>'+
                                       '<div class="text-center mt-2">'+
                                          '<img src="#" alt="">'+
                                       '</div>'+
                                    '</div>')
            }

            btnPaymentMomo.addClass("hide");
            btnConfirmPaymentMomo.removeClass("hide");
            counter = 60;
            setInterval(function() {
               counter--;
               if (counter >= 0) {
                  spanCountdown.html(counter);
               }
               if (counter === 0) {
                  // $("div#momo_info").empty();
                  btnPaymentMomo.removeClass("hide");
                  btnConfirmPaymentMomo.addClass("hide");
                  clearInterval(counter);
               }
            }, 1000);
         } else {
            err.removeClass("hide");
         }
         
      });

      btnConfirmPaymentMomo.click(() => {
         $("#list_amt").removeClass('hide');
         $("#list").removeClass('hide');
         infoPaymentMomo.addClass('hide');
         btnPaymentMomo.removeClass("hide");
         btnConfirmPaymentMomo.addClass("hide");
         window.location.reload();
      })
   })()
</script>
