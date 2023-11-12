<?php
$mysqli = new mysqli("localhost", "root", "", "nsoz");
if(isset($_POST['buyWebshop']))
{
    $itemid = mysqli_real_escape_string($mysqli, $_POST['buyWebshop']);
    $result = mysqli_query($mysqli,"SELECT * FROM webshop WHERE id = '$itemid'");
    $item = mysqli_fetch_array($result);
    $id = $user['id'];
    $result1 = mysqli_query($mysqli,"SELECT * FROM players WHERE user_id = '$id'");
    $ninja = mysqli_fetch_array($result1);
    if($ninja['user_id'] == 0) {
        $_SESSION['error'] = "Tài khoản chưa tạo nhân vật không thể tham gia chức năng này!";
        header("Location: /?page=user&tab=webshop");
        exit(0);
    } else {
        $giacoin = $item['gia_coin'];
        $vnd = $user['vnd'];
        if($vnd < $giacoin) {
            $_SESSION['error'] = "Tài khoản không đủ vnd.";
            header("Location: /?page=user&tab=webshop");
            exit(0);
        } else {
            $ItemBag = $ninja['bag'];
            //sẽ giải mã chuỗi JSON trong thuộc tính "bag" của đối tượng $ninja thành một mảng liên kết và gán cho biến $bag.
            $bag = json_decode($ItemBag, true);
            //kiểm tra xem số lượng phần tử trong mảng $bag có vượt quá giới hạn được đặt trong thuộc tính "maxluggage" của đối tượng $ninja hay không
            if($ninja['numberCellBag'] < count($bag)) {
                $_SESSION['error'] = "Hành trang không đủ chỗ trống.";
                header("Location: /?page=user&tab=webshop");
                exit(0);
            } else {
                for($i = 0; $i<count($bag); $i++) {
                    $bag[$i]["index"] = $i;
                }
                $webitem = $item['chi_so_game'];
                $temp = json_decode($webitem, true);
                //gán giá trị bằng số lượng phần tử trong mảng $bag cho thuộc tính "index" của mảng $temp.
                $temp["index"] = count($bag);
                //thêm mảng $temp vào cuối mảng $bag.
                $bag[] = $temp;
                //mã hóa mảng $bag thành chuỗi JSON và gán lại cho thuộc tính "bag" của đối tượng $ninja.
                $ninja['bag'] = json_encode($bag);

                $itembuy = $ninja['bag']; //item đã được thêm vào 
                $up = __update("users", ["vnd" => $vnd - $giacoin],["id" => $id]);
                $up1 = __update("players", ["bag" => $itembuy],["user_id" => $id]);

                $_SESSION['success'] = "Đã mua item: ".$item['ten_item']."";
                header("Location: /?page=user&tab=webshop");
                exit(0);
            }
        }
    }
}

?>
<?php include('success.php'); ?>
<?php include('error.php'); ?>
<div class="box">
    <div class="box-content">
        <p>Web shop</p>
    </div>
</div>
<?php
    $query = SQL()->query("SELECT * FROM webshop");
    while($row = mysqli_fetch_array($query)) { ?>
    <div class="item">
        <div class="item-img"><img src="<?= $row['image']; ?>" alt="" srcset=""></div>
        <div class="item-title">
            <p style="color: aliceblue;"># <?= $row['ten_item']; ?></p>
            <p style="color: yellow; font-size: 14px; font-weight: 400;">Giá : <?= number_format($row['gia_coin']); ?> Coin</p>
        </div>
        <div class="item-btn">
            <button id="btn-view" data-bs-toggle="collapse" data-bs-target="#collapseExample<?= $row['id']; ?>" aria-expanded="false" aria-controls="collapseExample" >Xem</button>
        </div>
    </div>
    <div class="collapse" id="collapseExample<?= $row['id']; ?>">
        <div class="box-collap">
            <p><span style="color: #fff;"><?= $row['ten_item']; ?></span></p>
            <p><span style="color: #fff; font-size: 13px; font-weight: 400;">Không khóa</span></p>
            <p><span style="color: yellow; font-size: 13px; font-weight: 400;">Giá bán: <?= number_format($row['gia_coin']); ?> Coin</span> </p>
            <p><span style="color: #06e6ff; font-size: 13px; font-weight: 400;"><?= $row['chi_so_web']; ?></span></p>
            <div class="item-btn-coll">
                <form action="" method="POST" >
                    <button type="submit" name="buyWebshop" value="<?= $row['id']; ?>"  class="btn btn-success">MUA</button>
                </form>
            </div>
        </div>
    </div>
<?php } ?>
<div class="box-content-end" style="font-weight: 400;font-family: math;text-shadow: 0 0 #c0ae77;height: 22px;color: cornsilk;text-align: center;">Web shop by NSO CHEN</div>