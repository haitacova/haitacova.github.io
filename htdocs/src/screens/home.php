<div class="card-title h5">Bài viết mới</div>
<hr>
<div>
   <?php
      $posts = __select("news_posts");
      if($posts != false && $posts->num_rows > 0){
         while($item = $posts->fetch_assoc()) {
            $item_url = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]/post/".$item['slug'];
            echo '
            <div class="post-item d-flex align-items-center my-2">
               <div class="post-image"><img src="/images/avatar.png" alt="'.$item['title'].'"></div>
               <div>
                  <a class="fw-bold " href="/?page=post&id='.$item['id'].'">'.$item['title'].'</a>
                  <div class="text-muted font-weight-bold">Lượt xem: '.$item['views'].', Bình luận: <span class="fb-comments-count" data-href="'.$item_url.'"></span></div>
               </div>
            </div>
            ';
        }
      }
   ?>
   <div class="post-item d-flex align-items-center my-2">
               <div class="post-image"><img src="/images/avatar.png" alt="Giftcode: tanthu"></div>
               <div>
                  <a class="fw-bold " href="#">Giftcode: tanthu</a>
                  <div class="text-muted font-weight-bold">Lượt xem: 56, Bình luận: 2<span class="fb-comments-count" data-href="#"></span></div>
               </div>
            </div>
</div>
<div class="mt-4">
   <div class="card-title h5">Giới thiệu</div>
   <hr>
   <div class="mx-2 fs-6">Ninja School Quang Chén là một game thế giới mở với chủ đề trường học ninja, nơi người chơi sẽ được trải nghiệm cuộc sống của một ninja thực thụ. Trong game, người chơi có thể tham gia vào các hoạt động giải trí như săn bắn quái vật, khám phá khu rừng bí ẩn, hoặc tham gia đấu trường PvP để thử thách và cạnh tranh với những ninja khác. Ngoài ra, game còn có nhiều nhiệm vụ và thử thách khác nhau cho người chơi hoàn thành, từ đó thu thập được điểm kinh nghiệm và trang bị vũ khí, trang phục mới. Với đồ họa đẹp mắt, âm thanh sống động và nội dung đa dạng, Ninja School Server sẽ đem đến cho người chơi những trải nghiệm tuyệt vời và thỏa mãn niềm đam mê với văn hóa ninja.</div>
</div>