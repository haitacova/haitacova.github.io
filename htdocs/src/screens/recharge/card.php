<div>
  <div class="overlay"></div>
  <div class="w-100 d-flex justify-content-center">
    <form action="#" id="card" class="pb-3 needs-validation" style="width: 26rem" >
      <div class="fw-semibold fs-5 my-3 text-center">Nạp thẻ điện thoại</div>
      <div class="mb-2">
        <label class="fw-semibold">Nhà mạng</label>
        <select name="provider_id" id="provider_id" type="text" class="form-control form-control-solid" >
          <option value="">Chọn nhà mạng</option> 
          <option value="10000">Viettel</option> 
          <option value="20000">Vinaphone</option> 
          <option value="50000">Mobiphone</option>
        </select>
      </div>
      <div class="invalid-feedback">Không được bỏ trống</div>

      <div class="mb-2">
        <label class="fw-semibold">Mệnh giá</label>
        <select name="amount" id="amount" type="text" class="form-control form-control-solid" >
          <option value="">Chọn mệnh giá</option>
          <option value="10000">10,000 - Nhận 8,000</option>
          <option value="20000">20,000 - Nhận 16,000</option>
          <option value="50000">50,000 - Nhận 40,000</option>
          <option value="100000">100,000 - Nhận 80,000</option>
          <option value="200000">200,000 - Nhận 160,000</option>
          <option value="500000">500,000 - Nhận 400,000</option>
          <option value="1000000">1,000,000 - Nhận 800,000</option>
        </select>
        <div class="invalid-feedback">Không được bỏ trống</div>
      </div>

      <div class="mb-2">
        <label class="fw-semibold">Mã thẻ</label>
        <div class="input-group">
          <input id="code"  name="code" type="text" autocomplete="off" placeholder="Nhập mã thẻ" class="form-control form-control-solid" value="" />
        </div>
        <div class="invalid-feedback">Không được bỏ trống</div>
      </div>

      <div class="mb-2">
        <label class="fw-semibold">Mã serial</label>
        <div class="input-group">
          <input id="serial" name="serial" type="text" autocomplete="off" placeholder="Nhập mã serial" class="form-control form-control-solid" value="" />
        </div>
        <div class="invalid-feedback">Không được bỏ trống</div>
      </div>

      <div class="text-center mt-3">
        <button type="submit" class="me-3 px-3 btn btn-primary">
          Xin vui lòng liên hệ AD để biết!
        </button>
      </div>
    </form>
  </div>

  <div class="table-responsive">
    <table  class="table align-middle table-row-dashed gy-5 dataTable no-footer" role="table" >

      <thead>
        <tr class="text-start fw-bold text-uppercase gs-0">
          <th colspan="1" role="columnheader" class="table-sort-desc text-primary" style="cursor: pointer" >#ID </th>
          <th colspan="1" role="columnheader" class="" style="cursor: default">Nhà mạng</th>
          <th colspan="1" role="columnheader" class="" style="cursor: pointer">Mệnh giá</th>
          <th colspan="1" role="columnheader" class="" style="cursor: pointer">Nhận được</th>Trạng thái</th>
          <th colspan="1" role="columnheader" class="" style="cursor: pointer">Ngày tạo</th>
        </tr>
      </thead>

      <tbody id="list-card" class="fw-semibold" role="rowgroup">
        <tr id="noContent">
          <td colspan="6">
            <div class="d-flex text-center w-100 align-content-center justify-content-center" >Không có bản ghi nào</div>
          </td>
        </tr>
        <tr></tr>
      </tbody>
    </table>
  </div>

  <div class="row">
    <div class="col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start"></div>
    <div class="col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end">
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
</div>

<script>
  $.ajax({

    url: "/api/getListTelco",
    type: "GET",
    dataType: "json",

    success: function (data) {
      let itemHTML = ' <option value="">Chọn mệnh giá</option>';

      if (data.code != "01") {
        this.data = data;
        data.forEach((item, index) => {
          itemHTML += `<option value="`+item[1]+`">`+item[0]+`</option>`;
        });
        $('#provider_id').append(itemHTML);
      } else {
        $("#noContent").css('display',"block" );
      }
    },
    error: function (xhr, textStatus, errorThrown) {
      $("#overlay").hide();
      console.log("Error in Operation", errorThrown);
    },
  });

  // Get list card

  let data;

  $.ajax({
    url: "/api/getlistcard",
    type: "GET",
    dataType: "json",
    data: { rowCount: 10 },

    success: function (data) {
      $("#noContent").hide();
      let itemHTML = "";

      if (data.code != "01" && data.length >0) {
        this.data = data;
        data.forEach((item, index) => {
          itemHTML += `<tr class="anhbt"><td>` + (index + 1) + `</td>`;
          itemHTML += `<td>` + item[0] + `</td>`;
          itemHTML += `<td>` + item[1] + `</td>`;
          itemHTML += `<td>` + item[2] + `</td>`;
          itemHTML +=
            `<td>` +
            (item[3] == "PENDING"
              ? `Đang xử lý`
              : item[3] == "SUCCESS"
              ? "Thành công"
              : "Lỗi") +
            `</td>`;

          itemHTML += `<td>` + item[4] + `</td></tr>`;
        });

        $("#list-card").append(itemHTML);
        $("#list-card").show();
        pageSize = 12;
        pagesCount = $(".anhbt").length;
        var totalPages = Math.ceil(pagesCount / pageSize);

        $(".pagination").twbsPagination({
          totalPages: totalPages,
          visiblePages: 5,
          prev: "&lt;",
          next: "&gt;",
          first: "",
          onPageClick: function (event, page) {
            var startIndex = pageSize * (page - 1);
            var endIndex = startIndex + pageSize;

            $(".anhbt")
              .hide()
              .filter(function () {
                var idx = $(this).index();
                return idx >= startIndex && idx < endIndex;
              })
              .show();
          },
        });
      } else {

        $("#noContent").css("display", "contents");
        $("#noContent").css("vertical-align", "middle");
        $("#noContent").css("text-align", "center");

      }
    },

    error: function (xhr, textStatus, errorThrown) {
      $("#overlay").hide();
      console.log("Error in Operation", errorThrown);
    },
  });

  // Submit form

  (function () {
    "use strict";
    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    var forms = document.querySelectorAll(".needs-validation#card");
    // Loop over them and prevent submission
    Array.prototype.slice.call(forms).forEach(function (form) {
      //    $("#overlay").show();
      form.addEventListener(
        "submit",
        function (event) {
          var err = $("form#card div#error").first();

          if (err) err.remove();
          var listInput = form.querySelectorAll("input");
          var listInValid = form.querySelectorAll(".invalid-feedback");

          event.preventDefault();
          event.stopPropagation();

          let check = true;
          let provider = $("#provider_id").val();
          let amount = $("#amount").val();
          let code = $("#code").val();
          let serial = $("#serial").val();

          if (provider.trim().length == 0) {
            listInValid[0].innerHTML = "Chưa chọn nhà mạng";
            listInValid[0].classList.add("d-block");
            check = false;
          } else {
            listInValid[0].classList.remove("d-block");
          }

          if (amount.trim().length == 0) {
            listInValid[1].innerHTML = "Chưa chọn mệnh giá";
            listInValid[1].classList.add("d-block");
            check = false;
          } else {
            listInValid[1].classList.remove("d-block");
          }

          listInput.forEach((item, index) => {
            let val = item.value;

            if (val.trim().length == 0) {
              listInValid[index + 2].innerHTML = "Không được để trống";
              check = false;
              listInValid[index + 2].classList.add("d-block");
            } else {
              listInValid[index + 2].classList.remove("d-block");
            }
          });

          if (check) {
            $.ajax({
              url: "/api/rechargePhone",
              type: "POST",
              dataType: "json",
              data: JSON.stringify({
                provider: provider,
                amount: amount,
                code: code,
                serial: serial,
              }),

              success: function (data, textStatus, xhr) {
                let alertNoti = null;

                if (data.code == "00") {
                  alertNoti =
                    '<div class="alert alert-success" id="error">Nạp thẻ thành công. </br>Vui lòng đợi hệ thống xử lý.</div>';
                } else {
                  alertNoti =
                    `<div class="alert alert-danger" id="error">` + data.text + `</div>`;
                }
                $("form#card").prepend(alertNoti);
              },
              error: function (xhr, textStatus, errorThrown) {
                console.log("Error in Operation", errorThrown);

              },
            });
          }
        },
        false
      );
    });
  })();
</script>

