<?php
    error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
    define('NP', true);
    require(__DIR__.'../../../core/configs.php');
    
    if($isMaintained){
        include("maintenance.php");
        return;
    }
    
    $pageWasRefreshed = isset($_SERVER['HTTP_CACHE_CONTROL']) && $_SERVER['HTTP_CACHE_CONTROL'] === 'max-age=0';

    session_start();
    $isLogged = false;
    $user = null;
    if(isset($_SESSION['isLogged'])){
        $isLogged = $_SESSION['isLogged'];
        if($pageWasRefreshed && isset($_SESSION['user'])) {
            $sql = SQL()->query("select * from user where user = '".$_SESSION['user']['user']."' limit 1");
            if($sql != false && $sql->num_rows > 0){
                while($row = $sql->fetch_assoc()) {
                    $_SESSION['user'] = $row;
                }
            }
        }
    }
    

    if(isset($_SESSION['user'])){
        $user = $_SESSION['user'];
    }
    
    $page = isset($_GET['page']) ? $_GET['page'] : "home";

    if($page == 'logout'){
        session_destroy();
        header("Location: /");
    }
    $tab = isset($_GET['tab']) ? $_GET['tab'] : '';
    $action = isset($_GET['action']) ? $_GET['action'] : '';
?>
<!doctype html>
<html lang="en">
  <head>
  <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="/images/logo1.png" type="image/x-icon" />
    <link rel="shortcut icon" href="/static/images/favicon.jpg" type="image/x-icon" />
    <title>NSOCHEN.PRO - Ninja School Online</title>
    <meta name="description" content="NSOCHÉN - Tham gia trường học ninja để trở thành một nhẫn giả">
    <meta name="keywords" content="Nso, ninja, ninja school, ninja school online, ninja lậu, NSOCHÉN, NSOCHÉN">
    <link href="/static/css/bootstrap.min.css" rel="stylesheet">
    <script src="/static/js/jquery.min.js"></script>
    <link href="/static/css/main.css" rel="stylesheet">
    <script src="/static/js/toastr.min.js"></script>
    <link href="/static/css/toastr.min.css" rel="stylesheet"/>
    <script src="https://www.gstatic.com/firebasejs/6.0.2/firebase.js"></script>
    <script async defer crossorigin="anonymous" src="//connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v17.0" nonce="tQcugFbH"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twbs-pagination/1.4.2/jquery.twbsPagination.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twbs-pagination/1.4.2/jquery.twbsPagination.js"></script>
    <script>
        // Show loading
        $(document).on({
            ajaxStart: function () {
            // $("body").addClass("loading");
            $("#NotiflixLoadingWrap").removeClass('hide')
            },
            ajaxStop: function () {
            // $("body").removeClass("loading");
            $("#NotiflixLoadingWrap").addClass('hide')
            },
        });
    </script>
	<!-- Meta Pixel Code -->
	<script>
		!function(f,b,e,v,n,t,s)
		{if(f.fbq)return;n=f.fbq=function(){n.callMethod?
		n.callMethod.apply(n,arguments):n.queue.push(arguments)};
		if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
		n.queue=[];t=b.createElement(e);t.async=!0;
		t.src=v;s=b.getElementsByTagName(e)[0];
		s.parentNode.insertBefore(t,s)}(window, document,'script',
		'https://connect.facebook.net/en_US/fbevents.js');
		fbq('init', '599819225390979');
		fbq('track', 'PageView');
	</script>
		<noscript><img height="1" width="1" style="display:none"
		src="https://www.facebook.com/tr?id=599819225390979&ev=PageView&noscript=1"
	/></noscript>
	<!-- End Meta Pixel Code -->
  </head>
  <body>
    <div class="overlay"></div>
    <div id="root">
        <?php include_once('../components/loading.php'); ?>
        <div class="container">
            <div class="main">
                <?php include_once('../components/header.php'); ?>
                <?php include_once('../components/navbar.php'); ?>
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="post-image d-none d-sm-block">
                                <img src="/images/avatar.png" alt="Cẩm Nang Tân Thủ Cho Người Mới">
                                <div class="post-author">Admin</div>
                            </div>
                            <div class="post-detail flex-fill">
                                <div class="fw-bold text-primary">Cẩm Nang Tân Thủ Cho Người Mới</div>
                                <div class="post-date">21:36:02 29/06/2023</div>
                                <div class="post-content">
                                    <p><strong>Không kích hoạt có chơi được game không?</strong></p>
                                    <p>Có nhé, nhưng sẽ bị giới hạn tính năng giao dịch, chỉ khi anh em kích hoạt thì mới có thể giao dịch với người khác</p>
                                    <p><br></p>
                                    <p><strong>Tại sao tôi không Xác Thực Tài Khoản được?</strong></p>
                                    <p>Các bạn vào mục tải về, tải lại bản V1.4.8 mới nhất, sau đó vào lại game rồi xác thực là được nhé</p>
                                    <p><br></p>
                                    <p><strong>Làm sao để nhận quà tân thủ?</strong></p>
                                    <p>Khi vào game, anh em lại NPC Admin ở Làng Tone để nhận quà tân thủ, tiếp đó lại NPC Okanechan để nhập code: quatanthu để nhận thêm một lần nữa, ngoài ra anh em có thể nhận Thưởng Thăng Cấp tại NPC Okanechan mỗi khi đạt một mốc cấp độ nào đó</p>
                                    <p><br></p>
                                    <p><strong>Hiện tại có những CODE gì cho người mới?</strong></p>
                                    <p>Hiện tại đang có code là <strong>quatanthu</strong> cho những anh em mới chơi nhé, để nhận thêm CODE anh em có thể tham gia các hoạt động trên Fanpage, chúng mình thường xuyên tổ chức để phát code cho người chơi nè</p>
                                    <p><br></p>
                                    <p><strong>Android nên chơi bản nào để ổn định nhất?</strong></p>
                                    <p>Hiện tại để chơi trên Android ổn định nhất các bạn nên chơi bản Java bằng cách tải J2ME Loader trên CH PLAY, sau đó tải bản Java Auto về và mở J2ME Loader lên để chạy nhé</p>
                                    <p><br></p>
                                    <p><strong>PC nên chơi bản nào để ổn định nhất?</strong></p>
                                    <p>Hiện tại PC các bạn nên chơi giả lập Java là ổn định nhất nhé</p>
                                    <ul>
                                        <li>B1: Tải Microemulator: <a href="https://angelchip.net/files/share/AngelChipEmulatorEXE.zip" rel="noopener noreferrer" target="_blank" style="color: rgb(0, 102, 204);">AngelChipEmulator.zip</a></li>
                                        <li>B2: Tải Game:<span style="color: rgb(0, 102, 204);"> </span><a href="https://files.nsoplus.com/filebrowser/api/public/dl/2OleQ0qA" rel="noopener noreferrer" target="_blank" style="color: rgb(0, 102, 204);">NsoPlus.jar</a> hoặc bạn có thể tải bản khác ở mục TẢI GAME</li>
                                        <li>B3: Giải nén và mở microemulator đã tải về</li>
                                        <li>B4: Kéo bản java vào microemulator và chạy thôi</li>
                                    </ul>
                                    <p><strong>Trên bản IOS tại sao di chuyển lại bị dật lại?</strong></p>
                                    <p>Các bạn chat s6 để giảm tốc độ chạy là được nhé</p>
                                    <p><br></p>
                                    <p><strong>Tại sao nick tôi bị kẹt, đăng nhập không được, hoặc vào Vùng đất ma quỷ bị lag game?</strong></p>
                                    <p>Đối với bản Android và IOS hiện tại đang bị lỗi lag game ở Vùng Đất Ma Quỷ, với Android các bạn có thể chơi bằng J2ME Loader như hướng dẫn bên trên, còn IOS thì sắp tới chúng mình sẽ fix lại nhé ạ</p>
                                    <p><br></p>
                                    <p><strong>Chơi Android không thể gán chiêu, phải làm thế nào?</strong></p>
                                    <p>Tương tự như trên, bản Android cũng đang bị lỗi này, các bạn chơi bằng J2ME Loader như hướng dẫn bên trên để ổn định nhé</p>
                                    <p><br></p>
                                    <p><strong>Tại sao đánh quái không nhận được kinh nghiệm?</strong></p>
                                    <p>Có 2 trường hợp xảy ra:</p>
                                    <ul>
                                        <li>Do bạn đánh quái nằm ngoài khoảng +/-10 level</li>
                                        <li>Do bạn tắt nhận EXP ở NPC Admin</li>
                                    </ul>
                                    <p><strong>Mới chơi GAME, mua bán nick nhưng không biết nên giao dịch thế nào?</strong></p>
                                    <p>Ở mỗi BOX ZALO bên dưới đều sẽ có GIAO DỊCH VIÊN (KEY BẠC), anh em liên hệ những GDV này để làm trung gian tránh lừa đảo khi giao dịch trực tiếp nhé</p>
                                    <p><br></p>
                                    <p><strong>Tại sao sử dụng vật phẩm sự kiện không nhận được EXP?</strong></p>
                                    <p>Hiện tại đang có Tái Lập Đua TOP, anh em tạo tài khoản vào thời gian này sẽ mặc định đưa vào danh sách đua top, các bạn có thể lại NPC ADMIN hủy đua TOP để nhận được EXP khi dùng vật phẩm sự kiện nhé</p>
                                    <p><br></p>
                                    <p><strong style="color: rgb(94, 98, 120);">Tại sao đánh quái không rơi vật phẩm?</strong></p>
                                    <p>Các bạn chỉ đánh quái nằm trong khoảng +/-7 level thôi nhé</p>
                                    <p><br></p>
                                    <p><strong>NsoPlus có nhóm cộng đồng nào không?</strong></p>
                                    <p>Không những có mà là có rất nhiều nha:</p>
                                    <ul>
                                        <li><span style="color: rgb(33, 37, 41);">Group Zalo 1:&nbsp;</span><a href="#" rel="noopener noreferrer" target="_blank" style="color: rgb(0, 102, 204); background-color: transparent;">https://zalo.me/g/rraxcy742</a></li>
                                    </ul>
                                </div>
                                <?php $sql_content = __select("news_posts", [
                                        "slug" => $_GET["id"]
                                    ]);
                                    $content = [];

                                    if($sql_content != false && $sql_content->num_rows > 0){
                                        while($row = $sql_content->fetch_assoc()) {
                                            $content = $row;
                                        }
                                    }?>
                                <div class="post-info mt-2">101,221 lượt xem, 834 bình luận</div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php include_once('../components/footer.php'); ?>
            </div>
        </div>
    </div>
    
    <?php include_once('../components/active.php'); ?>
    <?php include_once('../components/forgotpassword.php'); ?>
    <?php include_once('../components/login.php'); ?>
    <?php include_once('../components/register.php'); ?>
    <script>
        $('[data-bs-dismiss=modal]').on('click', function (e) {
            var $t = $(this),
                target = $t[0].href || $t.data("target") || $t.parents('.modal') || [];
        
          $(target)
            .find("input,textarea,select")
               .val('')
               .end()
            .find("input[type=checkbox], input[type=radio]")
               .prop("checked", "")
               .end();
        })
    </script>
    <script src="/static/js/popper.min.js"></script>
    <script src="/static/js/bootstrap.min.js"></script>
  </body>
</html> 