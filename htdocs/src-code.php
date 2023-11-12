<?php 
session_start();
$mysqli = new mysqli("localhost", "root", "", "nsoz");
if(isset($_POST['kh-user']))
{
    $user_id = mysqli_real_escape_string($mysqli, $_POST['kh-user']);
    $query = "UPDATE `users` SET `kh` = '1', `status` = '1' WHERE `users`.`id` = '$user_id';";
    $query_run = mysqli_query($mysqli , $query);
    $sqlUs = 'SELECT username FROM users WHERE id=' . $user_id . ' LIMIT 1';
    $resultUs = $mysqli->query($sqlUs);
    $userDB = $resultUs->fetch_assoc();
    if($query_run)
    {
        $_SESSION['message'] = "Kích hoạt thành công tài khoản <font color='black'><b>".$userDB['username'] ."</b></font>!";
        header("Location: /?page=user&tab=adminz");
        exit(0);
    }
    else
    {
        $_SESSION['message'] = "Kích hoạt thất bại tài khoản <font color='black'><b>".$userDB['username'] ."</b></font>!";
        header("Location: /?page=user&tab=adminz");
        exit(0);
    }
}

if(isset($_POST['addcoin']))
{
    $taikhoan = mysqli_real_escape_string($mysqli, $_POST['taikhoan']);
$coincong = mysqli_real_escape_string($mysqli, $_POST['coincong']);

// Check if the user exists
$result1 = mysqli_query($mysqli, "SELECT * FROM users WHERE username = '$taikhoan'");
$usern = mysqli_fetch_array($result1);

if (!$usern) {
    $_SESSION['error'] = "Tài khoản không chính xác hoặc không tồn tại trên máy chủ!";
    header("Location: /?page=user&tab=cong-vnd");
    exit(0);
}

$vndbefore = $usern['vnd'];
$vndbeforetongnap = $usern['tongnap'];
$vndafter = $vndbefore + $coincong;
$vndaftertongnap = $vndbeforetongnap + $coincong;

// Create separate query strings for each update
$query1 = "UPDATE `users` SET `tongnap` = '$vndaftertongnap' WHERE `users`.`username` = '$taikhoan'";
$query2 = "UPDATE `users` SET `vnd` = '$vndafter' WHERE `users`.`username` = '$taikhoan'";

// Execute the first update query
$query_run1 = mysqli_query($mysqli, $query1);

if (!$query_run1) {
    $_SESSION['error'] = "Có lỗi sảy ra khi cập nhật tài khoản!";
    header("Location: /?page=user&tab=cong-vnd");
    exit(0);
}

// Execute the second update query
$query_run2 = mysqli_query($mysqli, $query2);

if ($query_run2) {
    $_SESSION['success'] = "Tài khoản $taikhoan đã được cộng $coincong vào tài khoản.";
    header("Location: /?page=user&tab=cong-vnd");
    exit(0);
} else {
    $_SESSION['error'] = "Có lỗi sảy ra khi cập nhật tài khoản!";
    header("Location: /?page=user&tab=cong-vnd");
    exit(0);
    }
}

?>