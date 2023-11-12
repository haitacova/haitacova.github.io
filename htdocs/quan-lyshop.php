<?php
$mysqli = new mysqli("localhost", "root", "", "nsoz");
if(isset($_POST['delWebshop']))
{
    $idshop = mysqli_real_escape_string($mysqli ,$_POST['delWebshop']);
    $result = mysqli_query($mysqli,"SELECT * FROM webshop WHERE id = '$idshop'");
    $check = mysqli_fetch_array($result);

    $query = "DELETE FROM webshop WHERE id='$idshop' ";
    $query_run = mysqli_query($mysqli ,$query);
    if($query_run)
    {
        $_SESSION['success'] = "Đã xóa item shop. ".$check['ten_item']."";
        header("Location: /?page=user&tab=quan-lyshop");
        exit(0);
    }
    else
    {
        $_SESSION['error'] = "Không thể xóa item shop!";
        header("Location: /?page=user&tab=quan-lyshop");
        exit(0);
    }
}

if(isset($_POST['upwebshop'])) {
    $tenitem =mysqli_real_escape_string($mysqli, $_POST['tenitem']);
    $chisoweb = mysqli_real_escape_string($mysqli, $_POST['chisoweb']);
    $giaitem =mysqli_real_escape_string($mysqli, $_POST['giaitem']);
    $chisogame = mysqli_real_escape_string($mysqli, $_POST['chisogame']);
    $img_loc = $_FILES['link']['tmp_name'];
    $img_name = $_FILES['link']['name'];
    $img_des = "/uploadshop/".$img_name;
    move_uploaded_file($img_loc,'uploadshop/'.$img_name);

    if($img_des == '') {
        $_SESSION['error'] = "Link file không được bỏ trống!";
        header("Location: /?page=user&tab=quan-lyshop");
        exit(0);
    } else if($tenitem == ''){
        $_SESSION['error'] = "Tên item không được bỏ trống!";
        header("Location: /?page=user&tab=quan-lyshop");
        exit(0);
    } else if($chisoweb == ''){
        $_SESSION['error'] = "Chi so item không được bỏ trống!";
        header("Location: /?page=user&tab=quan-lyshop");
        exit(0);
    } else if($giaitem == ''){
        $_SESSION['error'] = "Gia coin không được bỏ trống!";
        header("Location: /?page=user&tab=quan-lyshop");
        exit(0);
    } else if($chisogame == ''){
        $_SESSION['error'] = "Chi so game không được bỏ trống!";
        header("Location: /?page=user&tab=quan-lyshop");
        exit(0);
    } else { 
        $query = "INSERT INTO `webshop`(`ten_item`, `chi_so_web`, `chi_so_game`,`gia_coin`, `image`) VALUES ('$tenitem','$chisoweb','$chisogame','$giaitem','$img_des')";
        $query_run = mysqli_query($mysqli ,$query);
        if($query_run)
        {
            $_SESSION['success'] = "Thêm item $tenitem vào shop!";
            header("Location: /?page=user&tab=quan-lyshop");
            exit(0);
        }
        else
        {
            $_SESSION['success'] = "Có lỗi xảy ra vui lòng liên hệ admin để khắc phục!";
            header("Location: /?page=user&tab=quan-lyshop");
            exit(0);
        }
    }
}
?>
<?php include('success.php'); ?>
<?php include('error.php'); ?>
<!-- upload shop -->
<div class="main" style="background: #ffffff00;">
    <div class="py-3 text-center">
        <h2>Upload Item Shop</h2>
    </div>
    <form action="" method="POST" enctype="multipart/form-data">
        <label for="">Tên Item:</label>
        <input class="form-control" type="text" name="tenitem" required><br>
        <label for="">Chỉ số web:</label>
        <input class="form-control" type="text" name="chisoweb" required><br>
        <label for="">Giá Item:</label>
        <input class="form-control" type="text" name="giaitem" required><br>
        <label for="">Chỉ số game:</label>
        <input class="form-control" type="text" name="chisogame" required><br>
        <label for="">Đường dẫn:</label>
        <input class="form-control" type="file" name="link" required><br>
        <button class="btn btn-primary" type="submit" name="upwebshop">Upload</button>
    </form>
</div>
<!-- end -->

<!-- item webshop -->
<div class="main">
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
                
                <div class="form-floating">
                    <textarea class="form-control" id="floatingTextarea2" style="height: 100px"><?= $row['chi_so_game']; ?></textarea>
                    <label for="floatingTextarea2">Chỉ số game</label>
                </div>
                <div class="item-btn-coll">
                    <form action="" method="POST" >
                        <button type="submit" name="delWebshop" value="<?= $row['id']; ?>"  class="btn btn-danger">Xóa</button>
                    </form>
                </div>
            </div>
        </div>
    <?php } ?>
    <div class="box-content-end" style="font-weight: 400;font-family: math;text-shadow: 0 0 #c0ae77;height: 22px;color: cornsilk;text-align: center;">Web shop by nsochen</div>
</div>
<!-- end -->