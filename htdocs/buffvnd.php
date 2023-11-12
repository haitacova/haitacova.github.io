<?php include('success.php'); ?>
<?php include('error.php'); ?>
<div class="mb-2" style="background: beige; padding: 10px;">
    <form action="/src-code.php" method="POST" class="d-inline">
        <div class="mb-2">
            <label><span style="font-size: 1.1rem; color:blueviolet"><b>Tài khoản nhận:</b></span></label>
            <input type="text" name="taikhoan" class="form-control" required="" placeholder="Nhập tài khoản người nhận...">
        </div>
        <div>
            <label><span style="font-size: 1.1rem; color:blueviolet"><b>Nhập vnd:</b></span></label>
            <input type="number" name="coincong" class="form-control" required="" placeholder="Nhập vnd...">
        </div>
        <button type="submit" name="addcoin" value="" style="margin-top: 10px; background: #9eff9a; border-radius: 5px;">Cộng Coin</button>
    </form>
</div>