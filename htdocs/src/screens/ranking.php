<?php
    error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
    define('NP', true);
    require(__DIR__.'/../../core/configs.php');
    
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
            $sql = SQL()->query("select * from users where username = '".$_SESSION['user']['username']."' limit 1");
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
    
    $page = isset($_GET['page']) ? $_GET['page'] : "";

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
    <link rel="icon" href="/images/favicon.jpg" type="image/x-icon" />
    <link rel="shortcut icon" href="/static/images/favicon.jpg" type="image/x-icon" />
    <title>NSO - Ninja School Online</title>
    <meta name="description" content="NsoPro - Tham gia trường học ninja để trở thành một nhẫn giả">
    <meta name="keywords" content="Nso, ninja, ninja school, ninja school online, nsocan, ninja lậu, nsoz, nsopro">
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
                        <ul class="mb-3 nav nav-tabs nav-justified" id="tabRanking" role="tablist">
                           <li class="nav-item" role="presentation"><button type="button" id="fill-tab-example-tab-1" role="tab" data-rr-ui-event-key="1" aria-controls="fill-tab-example-tabpane-1" aria-selected="false" class="nav-link active" data-bs-toggle="tab" data-bs-target="#fill-tab-example-tabpane-1">Thành viên</button></li>
                           <li class="nav-item" role="presentation"><button type="button" id="fill-tab-example-tab-2" role="tab" data-rr-ui-event-key="2" aria-controls="fill-tab-example-tabpane-2" aria-selected="false" class="nav-link" data-bs-toggle="tab" data-bs-target="#fill-tab-example-tabpane-2">Thành viên Bạc</button></li>
                           <li class="nav-item" role="presentation"><button type="button" id="fill-tab-example-tab-3" role="tab" data-rr-ui-event-key="3" aria-controls="fill-tab-example-tabpane-3" aria-selected="false" class="nav-link" data-bs-toggle="tab" data-bs-target="#fill-tab-example-tabpane-3">Thành viên Vàng</button></li>
                           <li class="nav-item" role="presentation"><button type="button" id="fill-tab-example-tab-4" role="tab" data-rr-ui-event-key="4" aria-controls="fill-tab-example-tabpane-4" aria-selected="true" class="nav-link" data-bs-toggle="tab" data-bs-target="#fill-tab-example-tabpane-4">Thành viên Kim Cương</button></li>
                        </ul>
                        <div class="tab-content" id="tabRankingContent">
                           <div role="tabpanel" id="fill-tab-example-tabpane-1" aria-labelledby="fill-tab-example-tab-1" class="fade tab-pane active show">
                              <div class="d-inline d-sm-flex justify-content-center">
                                 <div class="col-md-8">
                                    <div class="list-group bg-warning">
                                       <span class="list-group-item list-group-item-action">
                                          <div class="d-flex w-100 justify-content-between"><span class="fw-semibold">Khuyến mãi nạp tiền</span><small class="fw-semibold text-danger">new</small></div>
                                          <small>Ưu đãi 100% khi nạp tiền trên 0đ.</small>
                                       </span>
                                       <span class="list-group-item list-group-item-action">
                                          <div class="d-flex w-100 justify-content-between"><span class="fw-semibold">Khuyến mãi nạp tiền</span><small class="fw-semibold text-danger">new</small></div>
                                          <small>Ưu đãi 102% khi nạp tiền trên 1,000,000đ.</small>
                                       </span>
                                       <span class="list-group-item list-group-item-action">
                                          <div class="d-flex w-100 justify-content-between"><span class="fw-semibold">Khuyến mãi nạp tiền</span><small class="fw-semibold text-danger">new</small></div>
                                          <small>Ưu đãi 103% khi nạp tiền trên 5,000,000đ.</small>
                                       </span>
                                       <span class="list-group-item list-group-item-action">
                                          <div class="d-flex w-100 justify-content-between"><span class="fw-semibold">Khuyến mãi nạp tiền</span><small class="fw-semibold text-danger">new</small></div>
                                          <small>Ưu đãi 105% khi nạp tiền trên 10,000,000đ.</small>
                                       </span>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <div role="tabpanel" id="fill-tab-example-tabpane-2" aria-labelledby="fill-tab-example-tab-2" class="fade tab-pane">
                              <div class="d-inline d-sm-flex justify-content-center">
                                 <div class="col-md-8">
                                    <div class="list-group bg-warning">
                                       <span class="list-group-item list-group-item-action">
                                          <div class="d-flex w-100 justify-content-between"><span class="fw-semibold">Phần thưởng đạt hạng</span><small class="fw-semibold text-danger">HOT</small></div>
                                          <small>200tr yên, 5 bát bảo, 50 linh chi ngàn năm, 1 vé hoàn thành NV</small>
                                       </span>
                                       <span class="list-group-item list-group-item-action">
                                          <div class="d-flex w-100 justify-content-between"><span class="fw-semibold">Khuyến mãi nạp tiền</span><small class="fw-semibold text-danger">new</small></div>
                                          <small>Ưu đãi 100% khi nạp tiền trên 0đ.</small>
                                       </span>
                                       <span class="list-group-item list-group-item-action">
                                          <div class="d-flex w-100 justify-content-between"><span class="fw-semibold">Khuyến mãi nạp tiền</span><small class="fw-semibold text-danger">new</small></div>
                                          <small>Ưu đãi 102% khi nạp tiền trên 200,000đ.</small>
                                       </span>
                                       <span class="list-group-item list-group-item-action">
                                          <div class="d-flex w-100 justify-content-between"><span class="fw-semibold">Khuyến mãi nạp tiền</span><small class="fw-semibold text-danger">new</small></div>
                                          <small>Ưu đãi 104% khi nạp tiền trên 1,000,000đ.</small>
                                       </span>
                                       <span class="list-group-item list-group-item-action">
                                          <div class="d-flex w-100 justify-content-between"><span class="fw-semibold">Khuyến mãi nạp tiền</span><small class="fw-semibold text-danger">new</small></div>
                                          <small>Ưu đãi 105% khi nạp tiền trên 2,000,000đ.</small>
                                       </span>
                                       <span class="list-group-item list-group-item-action">
                                          <div class="d-flex w-100 justify-content-between"><span class="fw-semibold">Khuyến mãi nạp tiền</span><small class="fw-semibold text-danger">new</small></div>
                                          <small>Ưu đãi 107% khi nạp tiền trên 5,000,000đ.</small>
                                       </span>
                                       <span class="list-group-item list-group-item-action">
                                          <div class="d-flex w-100 justify-content-between"><span class="fw-semibold">Khuyến mãi nạp tiền</span><small class="fw-semibold text-danger">new</small></div>
                                          <small>Ưu đãi 110% khi nạp tiền trên 10,000,000đ.</small>
                                       </span>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <div role="tabpanel" id="fill-tab-example-tabpane-3" aria-labelledby="fill-tab-example-tab-3" class="fade tab-pane">
                              <div class="d-inline d-sm-flex justify-content-center">
                                 <div class="col-md-8">
                                    <div class="list-group bg-warning">
                                       <span class="list-group-item list-group-item-action">
                                          <div class="d-flex w-100 justify-content-between"><span class="fw-semibold">Phần thưởng đạt hạng</span><small class="fw-semibold text-danger">HOT</small></div>
                                          <small>500tr yên, 1 Hakairo Yoroi, 5 rương bạch ngân, 50 linh chi ngàn năm, 2 vé hoàn thành NV</small>
                                       </span>
                                       <span class="list-group-item list-group-item-action">
                                          <div class="d-flex w-100 justify-content-between"><span class="fw-semibold">Khuyến mãi nạp tiền</span><small class="fw-semibold text-danger">new</small></div>
                                          <small>Ưu đãi 102% khi nạp tiền trên 0đ.</small>
                                       </span>
                                       <span class="list-group-item list-group-item-action">
                                          <div class="d-flex w-100 justify-content-between"><span class="fw-semibold">Khuyến mãi nạp tiền</span><small class="fw-semibold text-danger">new</small></div>
                                          <small>Ưu đãi 103% khi nạp tiền trên 200,000đ.</small>
                                       </span>
                                       <span class="list-group-item list-group-item-action">
                                          <div class="d-flex w-100 justify-content-between"><span class="fw-semibold">Khuyến mãi nạp tiền</span><small class="fw-semibold text-danger">new</small></div>
                                          <small>Ưu đãi 105% khi nạp tiền trên 1,000,000đ.</small>
                                       </span>
                                       <span class="list-group-item list-group-item-action">
                                          <div class="d-flex w-100 justify-content-between"><span class="fw-semibold">Khuyến mãi nạp tiền</span><small class="fw-semibold text-danger">new</small></div>
                                          <small>Ưu đãi 107% khi nạp tiền trên 2,000,000đ.</small>
                                       </span>
                                       <span class="list-group-item list-group-item-action">
                                          <div class="d-flex w-100 justify-content-between"><span class="fw-semibold">Khuyến mãi nạp tiền</span><small class="fw-semibold text-danger">new</small></div>
                                          <small>Ưu đãi 110% khi nạp tiền trên 5,000,000đ.</small>
                                       </span>
                                       <span class="list-group-item list-group-item-action">
                                          <div class="d-flex w-100 justify-content-between"><span class="fw-semibold">Khuyến mãi nạp tiền</span><small class="fw-semibold text-danger">new</small></div>
                                          <small>Ưu đãi 113% khi nạp tiền trên 10,000,000đ.</small>
                                       </span>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <div role="tabpanel" id="fill-tab-example-tabpane-4" aria-labelledby="fill-tab-example-tab-4" class="fade tab-pane">
                              <div class="d-inline d-sm-flex justify-content-center">
                                 <div class="col-md-8">
                                    <div class="list-group bg-warning">
                                       <span class="list-group-item list-group-item-action">
                                          <div class="d-flex w-100 justify-content-between"><span class="fw-semibold">Phần thưởng đạt hạng</span><small class="fw-semibold text-danger">HOT</small></div>
                                          <small>1 tỷ yên, 1 Tôn Ngộ Không, 5 rương huyền bí, 5 vé hoàn thành NV</small>
                                       </span>
                                       <span class="list-group-item list-group-item-action">
                                          <div class="d-flex w-100 justify-content-between"><span class="fw-semibold">Khuyến mãi nạp tiền</span><small class="fw-semibold text-danger">new</small></div>
                                          <small>Ưu đãi 103% khi nạp tiền trên 0đ.</small>
                                       </span>
                                       <span class="list-group-item list-group-item-action">
                                          <div class="d-flex w-100 justify-content-between"><span class="fw-semibold">Khuyến mãi nạp tiền</span><small class="fw-semibold text-danger">new</small></div>
                                          <small>Ưu đãi 105% khi nạp tiền trên 200,000đ.</small>
                                       </span>
                                       <span class="list-group-item list-group-item-action">
                                          <div class="d-flex w-100 justify-content-between"><span class="fw-semibold">Khuyến mãi nạp tiền</span><small class="fw-semibold text-danger">new</small></div>
                                          <small>Ưu đãi 107% khi nạp tiền trên 1,000,000đ.</small>
                                       </span>
                                       <span class="list-group-item list-group-item-action">
                                          <div class="d-flex w-100 justify-content-between"><span class="fw-semibold">Khuyến mãi nạp tiền</span><small class="fw-semibold text-danger">new</small></div>
                                          <small>Ưu đãi 110% khi nạp tiền trên 2,000,000đ.</small>
                                       </span>
                                       <span class="list-group-item list-group-item-action">
                                          <div class="d-flex w-100 justify-content-between"><span class="fw-semibold">Khuyến mãi nạp tiền</span><small class="fw-semibold text-danger">new</small></div>
                                          <small>Ưu đãi 113% khi nạp tiền trên 5,000,000đ.</small>
                                       </span>
                                       <span class="list-group-item list-group-item-action">
                                          <div class="d-flex w-100 justify-content-between"><span class="fw-semibold">Khuyến mãi nạp tiền</span><small class="fw-semibold text-danger">new</small></div>
                                          <small>Ưu đãi 115% khi nạp tiền trên 10,000,000đ.</small>
                                       </span>
                                    </div>
                                 </div>
                              </div>
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


