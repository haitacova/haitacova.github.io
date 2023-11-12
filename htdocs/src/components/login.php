<div class="modal fade" id="modalLogin" tabindex="-1" aria-labelledby="modalLoginLabel" aria-hidden="true">
  <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-body">
            <div class="my-2">
               <div class="text-center"><a href="/home"><img class="logo" alt="Logo" src="/images/logo1.jpg" style="max-width: 150px;"></a></div>
            </div>
            <form action="#" class="py-3 mx-3 needs-validation" id="login" novalidate>
               <div class="mb-2">
                  <div class="input-group">
                      <input name="username" id="username" type="text" autocomplete="off" placeholder="Tên đăng nhập" class="form-control form-control-solid" value="" minlength="5" required>
                      <div class="invalid-feedback">Không được bỏ trống</div>
                  </div>
                  
               </div>
               <div class="mb-2">
                  <div class="input-group">
                      <input name="password" id="password" type="password" autocomplete="off" placeholder="Mật khẩu" class="form-control form-control-solid" value="" minlength="5" required>
                      <div class="invalid-feedback">Không được bỏ trống</div></div>
               </div>
               <div class="text-center mt-3">
                  <button type="submit" class="me-3 btn btn-primary">Đăng nhập</button><button type="button" class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close">Hủy bỏ</button>
                  <div class="pt-3">Bạn chưa có tài khoản? <a data-bs-toggle="modal" data-bs-target="#modalRegister" class="link-primary cursor-pointer">Đăng ký ngay</a></div>
                  <div><a data-bs-toggle="modal" data-bs-target="#modalForgotPass" class="link-primary cursor-pointer">Quên mật khẩu</a></div>
               </div>
            </form>
         </div>
      </div>
   </div>
</div>
<script>(
function () {
  'use strict'

  // Fetch all the forms we want to apply custom Bootstrap validation styles to
  var forms = document.querySelectorAll('.needs-validation#login')

  // Loop over them and prevent submission
  Array.prototype.slice.call(forms)
    .forEach(function (form) {
      form.addEventListener('submit', function (event) {
        var err = $("form#login div#error").first()
        if(err) err.remove()
        var listInput = form.querySelectorAll('input');
        var listInValid = form.querySelectorAll('.invalid-feedback');
          event.preventDefault()
          event.stopPropagation()
          let check = true
            listInput.forEach((item, index) => {
                let val = item.value
                if(val.trim().length == 0){
                    listInValid[index].innerHTML = "Không được để trống"
                    check = false
                    listInValid[index].classList.add('d-block')
                } else if(val.trim().length < 1){
                    listInValid[index].innerHTML = "Tối thiểu 1 ký tự"
                    check = false
                    listInValid[index].classList.add('d-block')
                } else {
                    listInValid[index].classList.remove('d-block')
                }
            })
        if(check){
            let user_name = $('input#username').val()
            let pass_word = $('input#password').val()
             $("#NotiflixLoadingWrap").removeClass('hide');
            $.ajax({
                 url: '/api/login',
                 type: 'POST',
                 dataType: 'json',
                 data: JSON.stringify({ "username": user_name, "password": pass_word }),
                 success: function (data, textStatus, xhr) {
                    $("#NotiflixLoadingWrap").addClass('hide');
                     if(data.code != "00"){
                         let alertErr = '<div class="alert alert-danger" id="error">Tài khoản hoặc mật khẩu không chính xác</div>'
                         $("form#login").prepend(alertErr)
                     } else window.location.reload();
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