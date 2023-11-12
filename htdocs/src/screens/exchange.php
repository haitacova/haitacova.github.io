<?php

    class Exchange {
        public $pcoin;
        public $luong;
        function __construct($pcoin, $luong) {
            $this->pcoin = $pcoin;
            $this->luong = $luong;
        }
    }
$exchanges = [];
    for ($i=0; $i < count($configDoiLuong) ; $i++) {
   array_push($exchanges, new Exchange($configDoiLuong[$i]['pCoin'], $configDoiLuong[$i]['luong']));

}
?>
<div class="overlay"></div>
<div class="text-center fw-semibold fs-5">Đổi PCoin ra Lượng 
<span class="text-danger"><?php  echo $bonusDoiLuong['bonus'] > 0 ? "(KM ".$bonusDoiLuong['bonus']."%)" : "" ?></span>
</div>
<div class="d-flex justify-content-center">
   <div class="col-md-8">
      <div class="row text-center justify-content-center row-cols-2 row-cols-lg-3 g-2 g-lg-2 my-1 mb-2">
         <?php
            foreach ($exchanges as $exc) {
                echo '<div >
                      <div class="col">
                         <div  class="w-100 fw-semibold cursor-pointer" onclick="handleClick('. $exc->pcoin.')">
                            <div id="button-'.$exc->pcoin.'" class="recharge-method-item false" style="height: 90px;">
                               <div class="text-primary" >'.number_format($exc->pcoin).'P</div>
                               <div class="center-text text-dark"><span>Nhận</span></div>
                               <div class="text-danger">'.number_format($exc->luong + ($exc->luong) * ($bonusDoiLuong['bonus']/100)).' lượng</div>
                            </div>
                         </div>
                      </div>
                </div>';
            }
            ?>
      </div>
      <!-- <div class="text-center">
         <div class="fw-semibold fs-6">Chọn nhân vật</div>
      </div>
      <div class="text-danger text-center fw-semibold mt-3 mb-2">Tài khoản chưa có nhân vật nào</div> -->
      <div class="text-center mt-4">
         <button id="confirm"  type="button" onclick="onClickExchange()" class="w-50 rounded-3 btn btn-primary btn-sm">Xác nhận</button>
         <div class="mt-2"><small class="fw-semibold"><a href="/?page=user&tab=transactions">Lịch sử giao dịch</a></small></div>
      </div>
   </div>
</div>
<div class="modal fade" id="modalConfirmExchange" tabindex="-1" aria-labelledby="modalConfirmExchangeLabel" aria-hidden="true">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-body">
            <div class="my-2">
               <div class="text-center"><a href="/"><img class="logo" alt="Logo" src="/images/logo.png" style="max-width: 200px;"></a></div>
            </div>
            <div class="text-center fw-semibold">
               <div id="noti" style="text-align: center;"></div>
               <div class="text-white text-center mb-2" id="waiting-times"></div>
               <div class="fs-6 mb-2">Bạn thoát game trước khi thực hiện giao dịch chưa?</div>
               <div id="noti-active"></div>
               <span>Bạn phải thoát game trước khi giao dịch rồi vào lại game để tránh phát sinh lỗi trong quá trình cộng tiền</span>
               <div class="mt-2 aci"><button type="button" id="confirmExchange" onclick="handleConfirm()" class="btn-rounded btn btn-primary btn-sm">Xác nhận đã thoát</button></div>
            </div>
         </div>
      </div>
   </div>
</div>
<script>

    function onClickExchange(){
        $("#modalConfirmExchange").modal("show");
    }
   let selected;
   let beforeSelected;
   function handleClick(index){
      selected = index;
      $(`#button-`+selected+``).css('background-color', '#ffae52') ;
      if(beforeSelected){
         $(`#button-`+beforeSelected+``).css('background-color', '') ;
      }
      beforeSelected = index;
   }
   
   function handleConfirm(){
      let alertNoti = null;
      if(!selected){
         alertNoti = `<div class="alert alert-danger" id="error">Chưa chọn số lượng </div>`;           
         $("#noti").prepend(alertNoti);
         return;
      }
      
      $.ajax({
         url: "/api/exchange",
         type: "POST",
         dataType: "json",
         data: JSON.stringify({"pcoin": selected}),
         success: function (data) {
            selected = undefined;
               if (data.code == "00") {
                  $(".aci").addClass("hide");
                  //Chuyển đến trang chủ sau 5s
                  let myTimeOut = setTimeout(function() {
                     window.location.reload();
                  }, 4000);

                  let waitingTimes = 3;
                  setInterval(function () {
                     $("#waiting-times").html(`<div class="alert alert-success" id="error">`+data.text+` Đang chuyển đến trang chủ sau ${waitingTimes} s</div>`);
                     waitingTimes--;
                  }, 1000);
                  return;
               } else {
                  alertNoti = `<div class="alert alert-danger" id="error">` + data.text + `</div>`;
                  //$("#modalConfirmExchange").modal("hide");
               }
               $("#noti").prepend(alertNoti);
         },
         error: function (xhr, textStatus, errorThrown) {
            $("#overlay").hide();
            console.log("Error in Operation", errorThrown);
         },
      });
   }
</script>