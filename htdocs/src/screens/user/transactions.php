<div class="table-responsive">
  <table class="table align-middle table-row-dashed gy-5 dataTable no-footer" role="table" >
    <thead>
      <tr class="text-start fw-bold text-uppercase gs-0">
        <th colspan="1" role="columnheader" class="table-sort-desc text-primary" style="cursor: pointer" > 
          #ID
        </th>
        <th colspan="1" role="columnheader" class="" style="cursor: pointer">
          Số tiền
        </th>
         <th colspan="1" role="columnheader" class="" style="cursor: default">
          Trước G.D
        </th>
        <th colspan="1" role="columnheader" class="" style="cursor: default">
          Sau G.D
        </th>
        <th colspan="1" role="columnheader" class="" style="cursor: default">
          Mô tả
        </th>
        <th colspan="1" role="columnheader" class="" style="cursor: pointer">
          Ngày tạo
        </th>
      </tr>
    </thead>
    <tbody class="fw-semibold" role="rowgroup" id="list-transaction">
        <?php 
            $sql = "SELECT vnd_change, vnd_before,vnd_after, notes, created_at FROM transactions WHERE user_id = " . $user['id'] . " ORDER BY created_at desc";
            $rows = SQL()->query($sql);
            $i = 1;
            if ($rows->num_rows > 0) {
              foreach($rows as $ls)
              {
                echo '<tr>';
                  echo'<td>'.$i.'</td>';
                  $i++;
                  echo'<td>-'.number_format($ls['vnd_change']).'</td>
                  <td>'.number_format($ls['vnd_before']).'đ</td>
                  <td>'.number_format($ls['vnd_after']).'đ</td>
                  <td>'.$ls['notes'].'</td>
                  <td>'.$ls['created_at'].'</td>
                </tr>';
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
<div class="row">
  <div class="col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start" ></div>
  <div class="col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end" >
    <div>
      <ul class="pagination">
        <li class="page-item">
          <a class="page-link" style="cursor: pointer">&lt;</a>
        </li>
        <li class="page-item active">
          <a class="page-link" style="cursor: pointer">1</a>
        </li>
        <li class="page-item">
          <a class="page-link" style="cursor: pointer">&gt;</a>
        </li>
      </ul>
    </div>
  </div>
</div>


<script>

  // Get list card
  $(".pagination").twbsPagination({
    totalPages: totalPages,
    visiblePages: 5,
    prev: "&lt;",
    next: "&gt;",
    first: "",
    onPageClick: function (event, page) {
      var startIndex = pageSize * (page - 1);
      var endIndex = startIndex + pageSize;

      $(".content-row").hide().filter(function () {
          var idx = $(this).index();
          return idx >= startIndex && idx < endIndex;
        }).show();
    },
  });
  

</script>

