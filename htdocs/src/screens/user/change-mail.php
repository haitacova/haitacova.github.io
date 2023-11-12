<div class="w-100 d-flex justify-content-center">
   <form action="#" class="pb-3 needs-validation" id="changeMail" style="width: 26rem;" autocomplete="off">
      <div class="fs-5 fw-bold text-center mb-3">Đổi Email đăng ký</div>
      <div class="mb-2">
         <label class="fw-semibold">Email hiện tại</label>
         <div class="input-group"><input name="curMail" id="curMail" type="email" autocomplete="off" placeholder="Nhập email hiện tại" class="form-control form-control-solid" disabled="" value="<?php echo $user['email']; ?>"></div>
         <div class="invalid-feedback">Không được bỏ trống</div>
      </div>
      <div class="mb-2">
         <label class="fw-semibold">Email mới</label>
         <div class="input-group"><input name="newMail" id="newMail" type="email" autocomplete="off" placeholder="Nhập email mới" class="form-control form-control-solid" value=""></div>
         <div class="invalid-feedback">Không được bỏ trống</div>
      </div>
       <!-- <div class="d-flex justify-content-center tuan3"><div id="recaptcha-container"></div></div> -->
      <div class="mb-2">
         <label class="fw-semibold">Mã OTP</label>
         <div class="input-group"><input name="otpMail" type="text" autocomplete="off" id="otpMail" placeholder="Nhập mã OTP đã nhận" class="form-control form-control-solid" pattern="\d*" maxlength="6" value=""><button class="btn btn-danger" href="javascript:void(0);" onclick="sendOtpChangeMail();" type="button">Gửi mã OTP</button></div>
      </div>
      <div class="text-center mt-2"><button type="submit" class="me-3 btn btn-primary">Xác nhận</button></div>
      <div class="mt-2"><small class="text-danger fw-semibold">Lưu ý: Sau khi thay đổi, bạn sẽ không thể sử dụng mail này để lấy lại mật khẩu</small></div>
   </form>
</div>
<script>
    function sendOtpChangeMail(){
       var curMail = $("#curMail").val().trim();
       var newMail = $("#newMail").val().trim();
       if(!curMail || !newMail){
          let alertErr = '<div class="alert alert-error" id="error">Bạn chưa nhập Mail.</div>'
          $("form#changeMail").prepend(alertErr);
          return;
       }
         $.ajax({
          url: '/api/sendmail',
          type: 'POST',
          dataType: 'json',
          data: JSON.stringify({  "username": "<?php echo $user['username'] ?>", "mail": curMail, "code": "", "type": "send", "key": "C" }),
          success: function (data, textStatus, xhr) {
              if(data.code == "00"){
                   let alertErr = '<div class="alert alert-success" id="error">'+data.text+'</div>'
                   $("form#changeMail").prepend(alertErr)
              } else {
                   let alertErr = '<div class="alert alert-danger" id="error">'+data.text+'</div>'
                   $("form#changeMail").prepend(alertErr)
              }
          },
          error: function (xhr, textStatus, errorThrown) {
              console.log('Error in Operation', errorThrown);
          }
      });
    }

   (function () {
  'use strict'

  // Fetch all the forms we want to apply custom Bootstrap validation styles to
  var forms = document.querySelectorAll('form#changeMail')

  // Loop over them and prevent submission
  Array.prototype.slice.call(forms)
    .forEach(function (form) {
      form.addEventListener('submit', function (event) {
        var err = $("form#changeMail div#error").first()
        if(err) err.remove()
         event.preventDefault()
         event.stopPropagation()
        let curMail = $("input#curMail").val();
        let newMail = $('input#newMail').val();
        let otp = $("input#otpMail").val(); 
        if(otp.trim().length <1) {
            let alertErr = '<div class="alert alert-danger" id="error">Hãy nhập otp</div>'
            $("form#changeMail").prepend(alertErr)
        } else {
            $.ajax({
                url: '/api/change-mail',
                type: 'POST',
                dataType: 'json',
                data: JSON.stringify({ "username": "<?php echo $user['username'] ?>", "mail": curMail, "newMail": newMail, "code": "","type": "otp" }),
                success: function (data, textStatus, xhr) {
                    if(data.code != "00"){
                        let alertErr = '<div class="alert alert-danger" id="error">Có lỗi trong quá trình reset mật khẩu</div>'
                        $("form#changeMail").prepend(alertErr)
                    } else {
                        let alertErr = '<div class="alert alert-success" id="error">Thay đổi mật khẩu thành công. Bạn sẽ được chuyển hướng sau 3s.</div>'
                        $("form#changeMail").prepend(alertErr)
                        setTimeout(() => {
                            window.location.reload();
                        }, 3000)
                    }
                },
                error: function (xhr, textStatus, errorThrown) {
                    console.log('Error in Operation', errorThrown);
                }
             });
        }
      }, false)
    })
})()
</script>