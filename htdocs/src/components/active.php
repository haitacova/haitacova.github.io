<div class="modal fade" id="modalActive" tabindex="-1" aria-labelledby="modalActiveLabel" aria-hidden="true">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-body">
            <div class="my-2">
               <div class="text-center"><a href="/"><img class="logo" alt="Logo" src="/images/logo1.png" style="max-width: 200px;"></a></div>
            </div>
            <div class="text-center fw-semibold">
               <div class="fs-6 mb-2">Xác nhận kích hoạt tài khoản</div>
               <div id="noti-active"></div>
               <span>Vui lòng thoát game trước khi xác nhận kích hoạt</span>
               <span>Sau khi kích hoạt, bạn sẽ mở khóa các tính năng giao dịch</span>
               <div class="text-success fw-bold">Phí kích hoạt: <?php echo $fees["active"]; ?> PCoin</div>
               <div class="mt-2"><button type="button" id="active" class="btn-rounded btn btn-primary btn-sm">Kích hoạt ngay</button></div>
            </div>
         </div>
      </div>
   </div>
</div>
<script>
   (function () {
  'use strict'
      var btnActive = $("button#active");
      btnActive.click(() => {
         var err = $("div#error").first()
         if(err) err.remove()
         event.preventDefault()
         event.stopPropagation()
         $("#NotiflixLoadingWrap").removeClass('hide');
         $.ajax({
               url: '/api/active',
               type: 'POST',
               dataType: 'json',
               data: JSON.stringify({}),
               success: function (data, textStatus, xhr) {
                  $("#NotiflixLoadingWrap").addClass('hide');
                  if(data.code == "01"){
                        let alertErr = '<div class="alert alert-danger" id="error">Thông tin không chính xác.</div>'
                        $("div#noti-active").prepend(alertErr)
                  } else if(data.code == "05"){
                        let alertErr = '<div class="alert alert-danger" id="error">Tài khoản không đủ số dư.</div>'
                        $("div#noti-active").prepend(alertErr)
                  } else if(data.code == "06"){
                        let alertErr = '<div class="alert alert-danger" id="error">Kích hoạt tài khoản thất bại. Vui lòng liên hệ quản trị viên để được hỗ trợ.</div>'
                        $("div#noti-active").prepend(alertErr)
                  } else if(data.code != "00"){
                        let alertErr = '<div class="alert alert-danger" id="error">Có lỗi xảy ra. Vui lòng liên hệ ADMIN để được hỗ trợ.</div>'
                        $("div#noti-active").prepend(alertErr)
                  } else {
                        let alertErr = '<div class="alert alert-success" id="error">Kích hoạt tài khoản thành công. Bạn sẽ được chuyển hướng sau 3s.</div>'
                        $("div#noti-active").prepend(alertErr)
                        $("button#active").addClass("hide")
                        setTimeout(() => {
                        window.location.reload();
                        }, 3000)
                  }
               },
               error: function (xhr, textStatus, errorThrown) {
                  $("#NotiflixLoadingWrap").addClass('hide');
                  console.log('Error in Operation');
               }
            });
      })
   })()
</script>