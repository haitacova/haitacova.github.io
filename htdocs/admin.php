<div class="table-responsive">
    <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
        <symbol id="exclamation-triangle-fill" fill="currentColor" viewBox="0 0 16 16">
            <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
        </symbol>
    </svg>
      <style></style>
      
    <?php include('message.php'); ?>
    <input style="box-shadow: none;" type="text" id="live-search" class="form-control" placeholder="Search" aria-label="Username" aria-describedby="addon-wrapping">
  <table class="table align-middle table-row-dashed gy-5 dataTable no-footer" role="table" >
    <thead>
      <tr class="text-start fw-bold text-uppercase gs-0">
        <th colspan="1" role="columnheader" class="" style="cursor: pointer">User</th>
        <th colspan="1" role="columnheader" class="" style="cursor: pointer">Pass</th>
        <th colspan="1" role="columnheader" class="" style="cursor: default">Active</th>
        <th colspan="1" role="columnheader" class="" style="cursor: default">Setting</th>
      </tr>
    </thead>
    <tbody class="fw-semibold" role="rowgroup" id="searchresult">
      <style>
        .but {border: 1px solid black;border-radius: 5px;background: #20c997;font-weight: bold;}
        .but1 {border: 1px solid black;border-radius: 5px;background: #dc3545;font-weight: bold;}
        .but:hover, .but1:hover {box-shadow: 1px 1px 5px darkmagenta, -1px -1px 5px darkmagenta;}
      </style>
        <?php 
            $sql = "SELECT * FROM users";
            $rows = SQL()->query($sql);
            if ($rows->num_rows > 0) {
              foreach($rows as $user)
              {
                echo '<tr>';
                  echo'<td>'.$user['username'].'</td>
                  <td>'.$user['password'].'</td>';
                  if($user['kh'] == '1') {
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
                          </td>';
                  }
                  ?>
                    
                  </tr>
                  <?php
              }
            }
            else
            {
                echo'<h5> Không có có bản ghi nào !</h5>';
            }
        ?>
    </tbody>
  </table>
</div>

<script>
    $('#baotri').click(function() {
        $('.cli').removeClass("hide")
    })
    //search user
    $(document).ready(function() {
      $("#live-search").keyup(function() {
        var input = $(this).val();
        //alert(input);

        if(input != "") {
            $.ajax({
              url: "../livesearch.php",
              method: "POST",
              data: {input: input},

              success:function(data){
                  $("#searchresult").html(data);
              }
            });
        }
      })
    })
</script>