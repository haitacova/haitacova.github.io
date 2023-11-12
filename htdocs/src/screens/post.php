<?php 
if(isset($_GET['id']))
{
    $sql_content = __select("news_posts",["id" => $_GET["id"]]);
    if($sql_content != false && $sql_content->num_rows > 0){
        while($row = $sql_content->fetch_assoc()) {
            $content = $row;
        }
    }

    try{
        __update("news_posts", ["views" => $content["views"] + 1], ["id" => $_GET["id"]]);
    } catch(Exception $e) {
    }
}
?>



<div class="d-flex align-items-center">
   <div class="post-image d-none d-sm-block">
      <img src="/images/avatar.png" alt="<?php echo $content["title"] ?>">
      <div class="post-author">Admin</div>
   </div>
   <div class="post-detail flex-fill">
      <div class="fw-bold text-primary"><?php echo $content["title"] ?></div>
      <div class="post-date"><?php echo $content["created"] ?></div>
      <div class="post-content">
        <?php echo $content["content"] ?>
      </div>
      <div class="post-info mt-2"><?php echo $content["views"] ?> lượt xem, <span class="fb-comments-count" data-href="<?php echo "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; ?>">0</span> bình luận</div>
   </div>
</div>
<hr class="my-3">
<div class="comment-list text-center">
    <div class="fb-comments" data-href="<?php echo "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; ?>" data-width="" data-numposts="5" data-order-by="reverse_time"></div>
</div>