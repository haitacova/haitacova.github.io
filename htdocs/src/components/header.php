<?php

?>

<div class="text-center card">
   <div class="card-body">
      <div class=""><a href="/"><img class="logo" alt="Logo" src="/images/logo1.jpg" style="max-width: 200px;"></a></div>
      <div class="mt-3">
          <?php
            if($isLogged){
                echo '
                  <div>
                     <a class="mb-3 px-2 py-1 fw-semibold text-secondary bg-warning bg-opacity-25 border border-warning border-opacity-75 rounded-2 link-success cursor-pointer" href="/?page=user&tab=profile">'.$user['username'].' - '.number_format($user['vnd']).' P</a>
                     <a class="ms-1 mb-3 px-2 py-1 fw-semibold text-secondary bg-warning bg-opacity-25 border border-warning border-opacity-75 rounded-2 link-success cursor-pointer" href="/?page=logout" >Đăng xuất</a></div>';
                 if($user['kh'] != 1){
                  echo '<div class="mt-2">
                     <small class="text-danger fw-semibold mt-3">Tài khoản của bạn chưa được kích hoạt, click vào phía dưới để kích hoạt.</small>
                     <div class="mt-2"><a data-bs-toggle="modal" data-bs-target="#modalActive" class="mb-3 px-2 py-1 fw-semibold text-secondary bg-danger bg-opacity-25 border border-danger border-opacity-75 rounded-2 link-success cursor-pointer">Kích hoạt tài khoản</a></div>
                  </div>';
                 }
            }
            else echo '
                <a class="mt-3" data-bs-toggle="modal" data-bs-target="#modalLogin"><span class="mb-3 px-2 py-1 fw-semibold text-secondary bg-warning bg-opacity-25 border border-warning border-opacity-75 rounded-2 link-success cursor-pointer">Đăng nhập ngay ?</span></a>
                ';
          ?>
         <div class="mt-3">
            <a class="mb-3 px-2 py-1 fw-semibold text-danger bg-danger bg-opacity-25 border border-danger border-opacity-50 rounded-2 cursor-pointer" href="/?page=download">
               TẢI GAME
               <svg fill="#000000" height="800px" width="800px" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 29.978 29.978" xml:space="preserve" class="download-icon">
                  <g>
                     <path d="M25.462,19.105v6.848H4.515v-6.848H0.489v8.861c0,1.111,0.9,2.012,2.016,2.012h24.967c1.115,0,2.016-0.9,2.016-2.012
                        v-8.861H25.462z"></path>

                     <path d="M14.62,18.426l-5.764-6.965c0,0-0.877-0.828,0.074-0.828s3.248,0,3.248,0s0-0.557,0-1.416c0-2.449,0-6.906,0-8.723
                        c0,0-0.129-0.494,0.615-0.494c0.75,0,4.035,0,4.572,0c0.536,0,0.524,0.416,0.524,0.416c0,1.762,0,6.373,0,8.742
                        c0,0.768,0,1.266,0,1.266s1.842,0,2.998,0c1.154,0,0.285,0.867,0.285,0.867s-4.904,6.51-5.588,7.193
                        C15.092,18.979,14.62,18.426,14.62,18.426z"></path>
                  </g>

               </svg>

            </a>

         </div>

      </div>

   </div>

</div>