<div class="modal fade" id="modalRegister" tabindex="-1" aria-labelledby="modalRegisterLabel" aria-hidden="true">
<div class="modal-dialog">
   <div class="modal-content">
      <div class="modal-body">
         <div class="my-2">
            <div class="text-center"><a href="/home"><img class="logo" alt="Logo" src="/images/logo1.jpg" style="max-width: 150px;"></a></div>
         </div>
         <form action="#" class="py-3 mx-3 needs-validation" id="register">
            <div class="mb-2">
               <label class="fw-semibold">Tên đăng nhập</label>
               <div class="input-group"><input name="rusername" id="rusername" type="text" autocomplete="off" placeholder="Nhập tên đăng nhập" class="form-control form-control-solid" value=""></div>
                      <div class="invalid-feedback">Không được bỏ trống</div>
            </div>
            <div class="mb-2">
               <label class="fw-semibold">Số điện thoại</label>
               <div class="input-group"><input name="phone" id="phone" type="text" autocomplete="off" placeholder="Nhập số điện thoại" class="form-control form-control-solid" value=""></div>
                      <div class="invalid-feedback">Không được bỏ trống</div>
            </div>
            <div class="mb-2">
               <label class="fw-semibold">Địa chỉ mail</label>
               <div class="input-group"><input name="email" id="email" type="email" autocomplete="off" placeholder="Nhập mail" class="form-control form-control-solid" value="@gmail.com"></div>
                      <div class="invalid-feedback">Không được bỏ trống</div>
            </div>
            <div class="mb-2">
               <label class="fw-semibold">Mật khẩu</label>
               <div class="input-group"><input name="rpassword" id="rpassword" type="password" autocomplete="off" placeholder="Nhập mật khẩu" class="form-control form-control-solid" value=""></div>
                      <div class="invalid-feedback">Không được bỏ trống</div>
            </div>
            <div class="mb-2">
               <label class="fw-semibold">Nhập lại mật khẩu</label>
               <div class="input-group"><input name="confirm_password" id="confirm_password" type="password" autocomplete="off" placeholder="Nhập nhập lại mật khẩu" class="form-control form-control-solid" value=""></div>
                      <div class="invalid-feedback">Không được bỏ trống</div>
            </div>
            <div class="text-center mt-3">
               <button type="submit" class="me-3 btn btn-primary">Đăng ký</button><button type="button" class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close">Hủy bỏ</button>
               <div class="pt-3">Bạn đã có tài khoản? <a data-bs-toggle="modal" data-bs-target="#modalLogin" class="link-primary cursor-pointer">Đăng nhập ngay</a></div>
               <div><a data-bs-toggle="modal" data-bs-target="#modalForgotPass" class="link-primary cursor-pointer">Quên mật khẩu</a></div>
            </div>
         </form>
      </div>
   </div>
</div>

<script>(
function () {
  'use strict'
  var forms = document.querySelectorAll('.needs-validation#register')

  // Loop over them and prevent submission
  Array.prototype.slice.call(forms)
    .forEach(function (form) {
      form.addEventListener('submit', function (event) {
        var err = $("form#register div#error").first()
        if(err) err.remove()
        var listInput = form.querySelectorAll('input');
        var listInValid = form.querySelectorAll('.invalid-feedback');
          event.preventDefault()
          event.stopPropagation()
          let check = true
            listInput.forEach((item, index) => {
                let val = item.value
                if(val.trim().length == 0){
                    listInValid[index].innerHTML = "Không được để trống."
                    check = false
                    listInValid[index].classList.add('d-block')
                } else if(val.trim().length < 5){
                    listInValid[index].innerHTML = "Tối thiểu 5 ký tự."
                    check = false
                    listInValid[index].classList.add('d-block')
                } else if(index == 1 && /((09|03|07|08|05)+([0-9]{8})\b)/g.test(val.trim()) == false){
                    listInValid[index].innerHTML = "Số điện thoại không hợp lệ."
                    check = false
                    listInValid[index].classList.add('d-block')
                } else if(index == 2 && /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(val.trim() == false)) {
                    listInValid[index].innerHTML = "Định dạng email không đúng."
                    check = false
                    listInValid[index].classList.add('d-block')
                } else if(index == 4 && (val.trim() != listInput[index-1].value.trim())) {
                    listInValid[index].innerHTML = "Mật khẩu nhập lại không chính xác."
                    check = false
                    listInValid[index].classList.add('d-block')
                } else {
                    listInValid[index].classList.remove('d-block')
                }
            })
        if(check){
            let user_name = $('input#rusername').val()
            let pass_word = $('input#rpassword').val()
            let x = $('input#phone').val().replace(/\D/g, '').match(/(\d{0,1})(\d{0,9})/)
            let phone = !x[2] ? x[1] : `+84${x[2]}${x[3] ? `-${x[3]}` : ''}`
            let email = $('input#email').val()
            $("#NotiflixLoadingWrap").removeClass('hide');
            $.ajax({
                 url: '/api/register',
                 type: 'POST',
                 dataType: 'json',
                 data: JSON.stringify({ "username": user_name, "password": pass_word, "phone": phone, "email": email}),
                 success: function (data, textStatus, xhr) {
                    $("#NotiflixLoadingWrap").addClass('hide');
                     if(data.code == "02"){
                         let alertErr = '<div class="alert alert-danger" id="error">Tên đăng nhập đã tồn tại trên hệ thống.</div>'
                         $("form#register").prepend(alertErr)
                     } else if(data.code == "03"){
                         let alertErr = '<div class="alert alert-danger" id="error">Số điện thoại đã tồn tại trên hệ thống.</div>'
                         $("form#register").prepend(alertErr)
                     } else if(data.code == "04"){
                         let alertErr = '<div class="alert alert-danger" id="error">Email đã tồn tại trên hệ thống.</div>'
                         $("form#register").prepend(alertErr)
                     } else if(data.code != "00"){
                         let alertErr = '<div class="alert alert-danger" id="error">Có lỗi xảy ra. Vui lòng liên hệ ADMIN để được hỗ trợ.</div>'
                         $("form#register").prepend(alertErr)
                     } else {
                         let alertErr = '<div class="alert alert-success" id="error">Tạo tài khoản thành công. Bạn sẽ được chuyển hướng sau 3s.</div>'
                         $("form#register").prepend(alertErr)
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
        }
      }, false)
    })
})()
</script>