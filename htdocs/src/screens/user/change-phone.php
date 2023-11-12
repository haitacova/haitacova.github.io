<div class="w-100 d-flex justify-content-center">
  <form action="#" class="pb-3 needs-validation" id="changephone" style="width: 26rem" autocomplete="off" >
    <div class="fs-5 fw-bold text-center mb-3">Đổi sim đăng ký</div>
    <div class="mb-2" style="display: none">
      <label class="fw-semibold">Email hiện tại</label>
      <div class="input-group">
        <input name="curMail" id="curMail" type="email" autocomplete="off" placeholder="Nhập email hiện tại" class="form-control form-control-solid" disabled="" value="<?php echo $user['email']; ?>"/>
      </div>
      <div class="invalid-feedback">Không được bỏ trống</div>
    </div>
    <div class="mb-2">
      <label class="fw-semibold">Số điện thoại hiện tại</label>
      <div class="input-group">
        <input name="curr_phone" id="curr_phone" type="text" autocomplete="off" placeholder="Nhập số điện thoại hiện tại" class="form-control form-control-solid" disabled=""value="<?php echo $user['phone']; ?>"/>
      </div>
      <div class="invalid-feedback">Không được bỏ trống</div>
    </div>
    <div class="mb-2">
      <label class="fw-semibold">Số điện thoại mới</label>
      <div class="input-group">
        <input name="new_phone" id="new_phone" type="text" autocomplete="off" placeholder="Nhập số điện thoại hiện tại" class="form-control form-control-solid" value=""/>
      </div>
      <div class="invalid-feedback">Không được bỏ trống</div>
    </div>
    <div class="d-flex justify-content-center tuan3">
      <div id="recaptcha-container"></div>
    </div>
    <div class="mb-2">
      <label class="fw-semibold">Mã OTP</label>
      <div class="input-group">
        <input name="otp" type="text" autocomplete="off" id="otp" placeholder="Nhập mã OTP đã nhận" class="form-control form-control-solid" maxlength="6" value="" />
        <button class="btn btn-danger" href="javascript:void(0);" onclick="sendOtpChangePhone()" type="button" > Gửi mã OTP </button>
      </div>
    </div>
    <div class="text-center mt-2">
      <button type="submit" class="me-3 btn btn-primary">Xác nhận</button>
    </div>
    <div class="mt-2">
      <small class="text-danger fw-semibold"
        >Lưu ý: Sau khi thay đổi, bạn sẽ không thể sử dụng số điện thoại này để
        lấy lại mật khẩu</small
      >
    </div>
  </form>
</div>
<script>
  window.onload = function () {
    window.recaptchaVerifier = new firebase.auth.RecaptchaVerifier(
      "recaptcha-container"
    );
    recaptchaVerifier.render();
  };
  /*    function sendOtpChangePhone(){
        console.log("ss")
        var err = $("form#changephone div#error").first()
        if(err) err.remove()
        let new_phone = $("input#new_phone").val();
          let x = $('input#curr_phone').val()
        if(/((09|03|07|08|05)+([0-9]{8})\b)/g.test(new_phone) == false) {
             let alertErr = '<div class="alert alert-danger" id="error">Số điện thoại mới không đúng định dạng</div>'
             $("form#changephone").prepend(alertErr)
            return
        } else {
          firebase.auth().signInWithPhoneNumber(x, window.recaptchaVerifier).then(function(confirmationResult) {
             window.confirmationResult = confirmationResult;
             coderesult = confirmationResult;
             let alertErr = '<div class="alert alert-success" id="error">Gửi OTP thành công. Vui lòng nhập OTP bạn nhận được để tiếp tục.</div>'
             $("form#changephone").prepend(alertErr)
          }).catch(function(error) {
             let alertErr = '<div class="alert alert-danger" id="error">Lỗi không gửi được OTP. Liên hệ ADMIN để được hỗ trợ.</div>'
             $("form#changephone").prepend(alertErr)
          });
        }
    }
    */
  function sendOtpChangePhone() {
    var curMail = $("#curMail").val().trim();
    var newPhone = $("#new_phone").val().trim();
    if (!newPhone) {
      let alertErr = '<div class="alert alert-danger" id="error">Vui lòng nhập số điện thoại mới</div>';
      $("form#changephone").prepend(alertErr);
      return;
    }
    let x = newPhone.replace(/\D/g, "").match(/(\d{0,1})(\d{0,9})/);
    if (!/((09|03|07|08|05)+([0-9]{8})\b)/g.test(`'${newPhone}'`)) {
      let alertErr =
        '<div class="alert alert-danger" id="error">Số điện thoại mới không đúng định dạng</div>';
      $("form#changephone").prepend(alertErr);
      return;
    }
    $.ajax({
      url: "/api/sendmail",
      type: "POST",
      dataType: "json",
      data: JSON.stringify({
        username: "<?php echo $user['username'] ?>",
        mail: curMail,
        code: "",
        key: "P",
        type: "send"
      }),
      success: function (data, textStatus, xhr) {
        if (data.code == "00") {
          let alertErr =
            '<div class="alert alert-success" id="error">' +
            data.text +
            "</div>";
          $("form#changephone").prepend(alertErr);
        } else {
          let alertErr =
            '<div class="alert alert-danger" id="error">' +
            data.text +
            "</div>";
          $("form#changephone").prepend(alertErr);
        }
      },
      error: function (xhr, textStatus, errorThrown) {
        console.log("Error in Operation", errorThrown);
      },
    });
  }

  (function () {
    "use strict";

    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    var forms = document.querySelectorAll("form#changephone");

    // Loop over them and prevent submission
    Array.prototype.slice.call(forms).forEach(function (form) {
      form.addEventListener(
        "submit",
        function (event) {
          var err = $("form#changephone div#error").first();
          if (err) err.remove();
          event.preventDefault();
          event.stopPropagation();
          var newPhone = $("#new_phone").val().trim();
          if (!newPhone) {
            let alertErr =
              '<div class="alert alert-danger" id="error">Vui lòng nhập số điện thoại mới</div>';
            $("form#changephone").prepend(alertErr);
            return;
          }
          let x = newPhone.replace(/\D/g, "").match(/(\d{0,1})(\d{0,9})/);
          let otp = $("input#otp").val();
          if (!/((09|03|07|08|05)+([0-9]{8})\b)/g.test(`'${newPhone}'`)) {
            let alertErr =
              '<div class="alert alert-danger" id="error">Số điện thoại mới không đúng định dạng</div>';
            $("form#changephone").prepend(alertErr);
          } else if (otp.trim().length < 1) {
            let alertErr =
              '<div class="alert alert-danger" id="error">Hãy nhập otp</div>';
            $("form#changephone").prepend(alertErr);
          } else {
               let new_phone_fm = !x[2] ? x[1] : `+84${x[2]}${x[3] ? `-${x[3]}` : ""}`;
            try {
               $.ajax({
                      url: "/api/change-phone",
                      type: "POST",
                      dataType: "json",
                      data: JSON.stringify({
                        username: "<?php echo $user['username'] ?>",
                        current_phone: "<?php echo $user['phone'] ?>",
                        new_phone: new_phone_fm,
                        code: otp,
                        key: 'P'
                      }),
                      success: function (data, textStatus, xhr) {
                        if (data.code != "00") {
                          let alertErr =
                            '<div class="alert alert-danger" id="error">' +
                            data.text +
                            "</div>";
                          $("form#changephone").prepend(alertErr);
                        } else {
                          let alertErr =
                            '<div class="alert alert-success" id="error">' +
                            data.text +
                            "</div>";
                          $("form#changephone").prepend(alertErr);
                          setTimeout(() => {
                            window.location.reload();
                          }, 3000);
                        }
                      },
                      error: function (xhr, textStatus, errorThrown) {
                        let alertErr =
                          '<div class="alert alert-danger" id="error">Lỗi hệ thống</div>';
                        $("form#changephone").prepend(alertErr);
                      },
                    });
            } catch (err) {
              let alertErr =
                '<div class="alert alert-danger" id="error">Lỗi không gửi được OTP. Liên hệ ADMIN để được hỗ trợ.</div>';
              $("form#changephone").prepend(alertErr);
            }
          }
        },
        false
      );
    });
  })();
</script>
