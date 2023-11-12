<?php
    error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
    define('NP', true);
    require(__DIR__.'/core/configs.php');
    
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
    <title>NSOCHÉN  - Ninja School Online</title>
    <meta name="description" content="NSOCHÉN - Tham gia trường học ninja để trở thành một nhẫn giả">
    <meta name="keywords" content="Nso, ninja, ninja school, ninja school online, ninja lậu, NSOCHÉN, NSOCHÉN">
    <link href="/static/css/bootstrap.min.css" rel="stylesheet">
    <script src="/static/js/jquery.min.js"></script>
    <link href="/static/css/main.css" rel="stylesheet">
    <script src="/static/js/toastr.min.js"></script>
    <link href="/static/css/toastr.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="/static/css/fontawesome.pro.6.0.0.css">
    <script src="https://www.gstatic.com/firebasejs/6.0.2/firebase.js"></script>
    <script async defer crossorigin="anonymous" src="//connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v17.0" nonce="tQcugFbH"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twbs-pagination/1.4.2/jquery.twbsPagination.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twbs-pagination/1.4.2/jquery.twbsPagination.js"></script>
    <link rel="stylesheet" href="/static/css/alert.css">
    <link rel="stylesheet" href="/static/css/webshop.css">
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
	<noscript><img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id=599819225390979&ev=PageView&noscript=1"/></noscript>
	<!-- End Meta Pixel Code -->
</head>
<body>
    <audio autoplay >
		<source src="/music/0.mp3" type="audio/mpeg">
	</audio>
    <div class="overlay"></div>
    <div id="root">
        <?php include_once('./src/components/loading.php'); ?>
        <div class="container">
			<style>
			.main{background-color: #1bb1db;}
			.card{background-color: #c2f1ff;}
			</style>
            <div class="main">
                <?php include_once('./src/components/header.php'); ?>
                <?php include_once('./src/components/navbar.php'); ?>
                <div class="card">
                    <div class="card-body">
                        <?php include_once('./src/routers.php'); ?>
                    </div>
                </div>
                <?php include_once('./src/components/footer.php'); ?>
            </div>
        </div>
    </div>
    
    <?php include_once('./src/components/active.php'); ?>
    <?php include_once('./src/components/forgotpassword.php'); ?>
    <?php include_once('./src/components/login.php'); ?>
    <?php include_once('./src/components/register.php'); ?>
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