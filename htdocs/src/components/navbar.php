
<div class="mb-2">
   <div class="row text-center justify-content-center row-cols-2 row-cols-lg-6 g-2 g-lg-2 mt-1">
      <div class="col">
         <div class="px-2"><a class="btn btn-menu btn-danger w-100 fw-semibold <?php echo($page == "home") ? "active" : "false"; ?>" href="/" >Trang chủ</a></div>
      </div>
      <div class="col">
         <div class="px-2"><a class="btn btn-menu btn-danger w-100 fw-semibold <?php echo($page == "recharge") ? "active" : "false"; ?>" href="javascript:void(0)" onclick="onClickNav('/?page=recharge&tab=momo'); return;">Nạp tiền</a></div>
      </div>
      <div class="col">
         <div class="px-2"><a class="btn btn-menu btn-danger w-100 fw-semibold <?php echo($page == "exchange") ? "active" : "false"; ?>" href="javascript:void(0)" onclick="onClickNav('/?page=exchange'); return;">Đổi lượng</a></div>
      </div>
      <div class="col">
         <div class="px-2"><a class="btn btn-menu btn-danger w-100 fw-semibold false" href="https://zalo.me/g/taahcl325">Box Zalo</a></div>
      </div>
   </div>
</div>
    <script>
        function onClickNav(goto){
            let isLogged = <?php echo isset($isLogged) && $isLogged == true ? "true" : "false"; ?> 
            if(!isLogged){
                $("#modalLogin").modal("show");
            } else {
                window.location.href = goto;
            }
        }
    </script>