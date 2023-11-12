<div z-index="1" class="modal fade" id="modalForgotPass" tabindex="-1" aria-labelledby="modalForgotPassLabel" aria-hidden="true">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-body">
            <div class="my-2">
               <div class="text-center"><a href="/home"><img class="logo" alt="Logo" src="/images/logo1.jpg" style="max-width: 150px;"></a></div>
            </div>
            <form action="#" class="py-3 mx-3 needs-validation" id="forgotpass">
               <div class="mb-2 tuan1">
                  <label class="fw-semibold">Tên đăng nhập</label>
                  <div class="input-group"><input name="fusername" id="fusername" type="text" autocomplete="off" placeholder="Nhập tên đăng nhập" class="form-control form-control-solid" value=""></div>
               </div>
               <div class="mb-2 tuan1">
                  <label class="fw-semibold">Địa chỉ mail đăng ký</label>
                  <div class="input-group"><input name="fmail" id="fmail" type="email" autocomplete="off" placeholder="Nhập địa chỉ mail đăng ký" class="form-control form-control-solid" value=""></div>
               </div>
                <div class="mb-2">
                  <label class="fw-semibold">Mã OTP</label>
                  <div class="input-group"><input name="fcode" id="fcode" type="text" autocomplete="off" placeholder="Nhập mã OTP đã nhận" class="form-control form-control-solid" maxlength="6" value="">
                  <a class="btn btn-danger" href="javascript:void(0)" onclick="sendOTP();" type="button">Gửi mã OTP</a></div>
               </div>
               <!-- <div class="mb-2 tuan2">
                  <label class="fw-semibold">Số điện thoại đăng ký</label>
                  <div class="input-group"><input name="fphone" id="fphone" type="text" autocomplete="off" placeholder="Nhập số điện thoại đăng ký" class="form-control form-control-solid" value=""></div>
               </div> -->
               <!-- <div class="d-flex justify-content-center tuan3"><div id="recaptcha-container"></div></div> -->
               <!-- <div class="mb-2">
                  <label class="fw-semibold">Mã OTP</label>
                  <div class="input-group"><input name="fcode" id="fcode" type="text" autocomplete="off" placeholder="Nhập mã OTP đã nhận" class="form-control form-control-solid" pattern="\d*" maxlength="6" value="">
                  <a class="btn btn-danger" href="javascript:void(0)" onclick="sendOTP();" type="button">Gửi mã OTP</a></div>
               </div> -->
               <!-- <div style="margin-top: -10px;"></div> -->
               <div class="text-center mt-3">
                  <button type="submit" class="me-3 btn btn-primary">Xác nhận</button><button type="button" class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close">Hủy bỏ</button>
                  <div class="pt-3">Bạn đã có tài khoản? <a data-bs-toggle="modal" data-bs-target="#modalLogin" class="link-primary cursor-pointer">Đăng nhập ngay</a></div>
               </div>
            </form>
             <form action="#" class="py-3 mx-3 needs-validation" id="changePass">
            </form>
         </div>
      </div>
   </div>
</div>
<script type="text/javascript">
   window.onload = function() {
      $('form#changePass').css('display','none');
   };

   $('#modalForgotPass').on('hide.bs.modal', function () {
      $('#repassContent').children('div').remove();
   })
   
   $('#modalForgotPass').on('show.bs.modal', function () {
      $('#repassContent').children('div').remove();
      $('form#forgotpass').css('display','block');
      $("#fusername").val('')
      $("#fmail").val('')
      $('#fcode').val('')
   })

//   function render() {
//      window.recaptchaVerifier = new firebase.auth.RecaptchaVerifier('recaptcha-container');
//      recaptchaVerifier.render();
//   }

   function sendOTP(){
      var err = $("form#forgotpass div#error").first()
       if (err) err.remove()
      var user_name = $("#fusername").val();
      var mail = $("#fmail").val().trim();
      if(!user_name || !mail){
         let alertErr = '<div class="alert alert-error" id="error">Bạn chưa nhập Tên đăng nhập hoặc Mail.</div>'
         $("form#forgotpass").prepend(alertErr);
         return;
      }
        $.ajax({
         url: '/api/sendmail',
         type: 'POST',
         dataType: 'json',
         data: JSON.stringify({ "username": user_name, "mail": mail, "code": "", "type": "send", "key": "F" }),
         success: function (data, textStatus, xhr) {
             if(data.code == "00"){
                  let alertErr = '<div class="alert alert-success" id="error">'+data.text+'.</div>'
                  $("form#forgotpass").prepend(alertErr)
             } else {
                  let alertErr = '<div class="alert alert-danger" id="error">'+data.text+'</div>'
                  $("form#forgotpass").prepend(alertErr)
             }
         },
         error: function (xhr, textStatus, errorThrown) {
             console.log('Error in Operation', errorThrown);
         }
     });
   }

//    function sendOTP() {
//       var err = $("form#forgotpass div#error").first()
//       if (err) err.remove()
//       var user_name = $("#fusername").val();
//       let x = $('#fphone').val().replace(/\D/g, '').match(/(\d{0,1})(\d{0,9})/)
//       let number = !x[2] ? x[1] : `+84${x[2]}${x[3] ? `-${x[3]}` : ''}`
//       var code = $("#fcode").val();
//       $.ajax({
//          url: '/api/forgotpassword',
//          type: 'POST',
//          dataType: 'json',
//          data: JSON.stringify({ "username": user_name, "phone": number, "code": code, "type": "check" }),
//          success: function (data, textStatus, xhr) {
//              if(data.code != "00"){
//                  let alertErr = '<div class="alert alert-danger" id="error">Tài khoản hoặc số điện thoại không chính xác</div>'
//                  $("form#forgotpass").prepend(alertErr)
//              } else {
//                   firebase.auth().signInWithPhoneNumber(number, window.recaptchaVerifier).then(function(confirmationResult) {
//                      window.confirmationResult = confirmationResult;
//                      coderesult = confirmationResult;
//                      let alertErr = '<div class="alert alert-success" id="error">Gửi OTP thành công. Vui lòng nhập OTP bạn nhận được để tiếp tục.</div>'
//                      $("form#forgotpass").prepend(alertErr)
//                   }).catch(function(error) {
//                      let alertErr = '<div class="alert alert-danger" id="error">Lỗi không gửi được OTP. Liên hệ ADMIN để được hỗ trợ.</div>'
//                      $("form#forgotpass").prepend(alertErr)
//                   });
//              }
//          },
//          error: function (xhr, textStatus, errorThrown) {
//              console.log('Error in Operation');
//         }
//     });
//   } 

   function verify() {
      let code = $('#fcode').val();
      let user_name = $("#fusername").val();
      let mail = $("#fmail").val().trim();
      if(!code){
         let alertErr = '<div class="alert alert-danger" id="error">Chưa nhập OTP</div>'
         $("form#forgotpass").prepend(alertErr)
         return;
      }
      $.ajax({
         url: '/api/sendmail',
         type: 'POST',
         dataType: 'json',
         data: JSON.stringify({ "username": user_name, "mail": mail, "code": code, "type": "check", key: 'F' }),
         success: function (data, textStatus, xhr) {
             if(data.code == "00"){
               $('form#forgotpass').css('display','none');
               $('form#changePass').append(
                  `<div id="repassContent">
                     <div class="mb-2 tuan1">
                     <label class="fw-semibold">Mật khẩu mới</label>
                     <div class="input-group"><input name="newPass" id="newPass" type="password" autocomplete="off" placeholder="Mật khẩu mới" class="form-control form-control-solid" value=""></div>
                     </div>
                     <div class="mb-2 tuan2">
                        <label class="fw-semibold">Nhập lại mật khẩu</label>
                        <div class="input-group"><input name="reNewPass" id="reNewPass" type="password" autocomplete="off" placeholder="Nhập lại mật khẩu" class="form-control form-control-solid" value=""></div>
                     </div>
                     <div class="d-flex justify-content-center tuan3"><div id="recaptcha-container"></div></div>
                     <div class="text-center mt-3">
                        <button type="submit" class="me-3 btn btn-primary">Xác nhận</button><button type="button" class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close">Hủy bỏ</button>
                     </div>
                  </div>`);
                  $('form#changePass').css('display','block')
             } else {
                  let alertErr = '<div class="alert alert-danger" id="error">'+data.text+'</div>'
                  $("form#forgotpass").prepend(alertErr)
             }
         },
         error: function (xhr, textStatus, errorThrown) {
             console.log('Error in Operation', errorThrown);
         }
     });
         
   }

   // Check new pass and re new pass
   function verifyChangePass(){
      let user_name = $("#fusername").val();
      let newPass = $('#newPass').val();
      let rePass = $('#reNewPass').val();
      if(newPass != rePass){
         let alertErr = '<div class="alert alert-danger" id="error">Mật khẩu không trùng khớp</div>';
         $("form#changePass").prepend(alertErr);
         return;
      }else if(newPass.length < 6){
         let alertErr = '<div class="alert alert-danger" id="error">Mật khẩu quá ngắn. Tối thiểu 6 ký tự.</div>';
         $("form#changePass").prepend(alertErr);
         return;
      }else{
          $.ajax({
         url: '/api/forgotpassword',
         type: 'POST',
         dataType: 'json',
         data: JSON.stringify({ "username": user_name, "newPass": newPass, "code": "","type": "otp" }),
         success: function (data, textStatus, xhr) {
             if(data.code != "00"){
                 let alertErr = '<div class="alert alert-danger" id="error">Có lỗi trong quá trình reset mật khẩu</div>'
                 $("form#changePass").prepend(alertErr)
             } else {
                 let alertErr = '<div class="alert alert-success" id="error">Thay đổi mật khẩu thành công. Bạn sẽ được chuyển hướng sau 3s.</div>'
                 $("form#changePass").prepend(alertErr)
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
     
   }
</script>

<script>
   (
      function() {
         'use strict'
         var forms = document.querySelectorAll('.needs-validation#forgotpass')

         // Loop over them and prevent submission
         Array.prototype.slice.call(forms)
            .forEach(function(form) {
               form.addEventListener('submit', function(event) {
                  var err = $("form#forgotpass div#error").first()
                  if (err) err.remove()
                  event.preventDefault()
                  event.stopPropagation()
                  verify()
               }, false)
            })
      })();
         (
      function() {
         'use strict'
         var forms = document.querySelectorAll('.needs-validation#changePass')

         // Loop over them and prevent submission
         Array.prototype.slice.call(forms)
            .forEach(function(form) {
               form.addEventListener('submit', function(event) {
                  var err = $("form#changePass div#error").first()
                  if (err) err.remove()
                  event.preventDefault()
                  event.stopPropagation()
                  verifyChangePass()
               }, false)
            })
      })()
</script>