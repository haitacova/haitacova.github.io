<?php

$mysqli = new mysqli("localhost", "root", "", "nsoz");

if (isset($_POST['input'])) {
    $input = $_POST['input'];
    $query = "SELECT * FROM users WHERE username LIKE '{$input}%' OR kh LIKE '{$input}%'";
    $result = mysqli_query($mysqli, $query);

    if(mysqli_num_rows($result) > 0){
        foreach($result as $user){
            $username = $user['username'];
            $kichhoat = $user['kh'];  
            echo '<tr>';
            echo'<td>'.$username.'</td>
            <td>'.$user['password'].'</td>';
            echo'<style>
                    .but {border: 1px solid black;border-radius: 5px;background: #20c997;font-weight: bold;}
                    .but1 {border: 1px solid black;border-radius: 5px;background: #dc3545;font-weight: bold;}
                    .but:hover, .but1:hover {box-shadow: 1px 1px 5px darkmagenta, -1px -1px 5px darkmagenta;}
                </style>';
            if($kichhoat == '1') {
            echo '<td><font color="#38ea10">YES</font></td>';
            echo '<td style="display: flex; flex-wrap: wrap;">
                    <form action="/src-code.php" method="POST" class="d-inline">
                        <button type="submit" name="kh-user" value="'. $user['id'].'" class="but">Đã active</button>
                    </form>
                    </td>';
            } else {
            echo '<td><font color="#d20707">NO</font></td>';
            echo '<td style="display: flex; flex-wrap: wrap;">
                    <form action="/src-code.php" method="POST" class="d-inline">
                        <button type="submit" name="kh-user" value="'. $user['id'].'" class="but1">Kích hoạt</button>
                        <script>$(".but1").css("background","#dc3545");</script>
                    </form>
                    </td>
                </tr>';
            }
        }
    }   
} else {
    echo '<h6 class="text-danger text-center mt-3">No Data Found</h6>';
}

?>