jQuery(document).ready(function () {
  var exitHTML = "";

  //HTML data form
  jQuery(document).on("click", ".hd-quick-edit", function () {
    if (jQuery(".hd-btn-cancel").length > 0) {
      jQuery(".hd-btn-cancel").trigger("click");
    }
    var id = jQuery(this).parents("tr").find(".column-id").text();

    var customerName = jQuery(this)
      .parents("tr")
      .find(".hd-customer-name")
      .text();
    var code = jQuery(this).parents("tr").find(".column-code").text();
    var address = jQuery(this)
      .parents("tr")
      .find(".column-address_info")
      .text();
    var phone = jQuery(this).parents("tr").find(".column-phone").text();
    var warranty = jQuery(this)
      .parents("tr")
      .find(".column-warranty_time")
      .text();
    var service = jQuery(this).parents("tr").find(".column-service_").text();
    var note = jQuery(this).parents("tr").find(".column-note").text();
    var branch = jQuery(this).parents("tr").find(".column-branch_id").text();
    var year = jQuery(this).parents("tr").find(".column-year_birth").text();

    console.log(branch);
    // function GetDataSelect() {
    //   var select_html = "";
    //   // Kiểm tra nếu data_branch tồn tại và là một mảng
    //   if (Array.isArray(data_branch)) {
    //     for (let i = 0; i < data_branch.length; i++) {
    //       const item = data_branch[i];
    //       // Kiểm tra nếu phần tử không bị undefined hoặc null
    //       if (item && item.id !== undefined && item.branch_name !== undefined) {
    //         select_html += `<option value="${item.id}">${item.branch_name}</option>`;
    //       } else {
    //         console.warn(`Phần tử tại chỉ số ${i} không hợp lệ:`, item);
    //       }
    //     }
    //   } else {
    //     console.error(
    //       "data_branch không được định nghĩa hoặc không phải là mảng."
    //     );
    //   }
    //   return select_html;
    // }

    let editHTML =
      `
            <td colspan="7" >
                <table>
                <tr>
                    <td colspan="2" style="color: #ff0000; font-weight: 600; font-size: 20px !important;">SỬA NHANH</td>
                </tr>
                 <tr>
                        <td>Mã Code</td>
                        <td> <input type="text" class="hd-customer-code" value="` +
      code +
      `" name="code"> </td>
                    </tr>
                    <tr>
                        <td>Họ và tên</td>
                        <td> <input type="text" class="hd-customer-customerName" value="` +
      customerName +
      `" name="fullname"> </td>
                    </tr>
                    <tr>
                        <td>Năm sinh</td>
                        <td> <input type="text" class="hd-customer-year_birth" value="` +
                        year +
      `" name="fullname"> </td>
                    </tr>
                     <tr>
                        <td>Địa chỉ</td>
                        <td> <input type="text" class="hd-customer-address" value="` +
      address +
      `" name="address"> </td>
                    </tr>
                     <tr>
                        <td>SĐT</td>
                        <td> <input type="text" class="hd-customer-phone" value="` +
      phone +
      `" name="phone"> </td>
                    </tr>
                     <tr>
                        <td>Bảo hành tới</td>
                        <td> <input type="date" class="hd-customer-warranty" value="` +
      warranty +
      `" name="warranty"> </td>
                    </tr>
                     <tr>
                        <td>Chi nhánh</td>
                        <td> <input type="text" class="hd-customer-branch" value="`+ branch +`" name="branch" readonly ></td>
                    </tr>
                     <tr>
                        <td>Dịch vụ</td>
                        <td> <input type="text" class="hd-customer-service" value="`+service +`" name="service"> </td>
                    </tr>
                     <tr>
                        <td>Ghi chú</td>
                        <td> <textarea id="note" class="hd-customer-note" value="` +
      note +
      `" name="note" rows="4" cols="60"></textarea> </td>
                    </tr>
                    <tr>
                        <td><button data-id="` +
      id +
      `" type="button" class="button button-primary save hd-btn-save">Update</button></td>
                        <td><button type="button" class="button cancel hd-btn-cancel">Cancel</button></td>
                    </tr>
                </table>
            </td>
        `;
    exitHTML = jQuery(this).parents("tr").html();

    jQuery(this).parents("tr").html(editHTML);
  });

  //Close Quick edit form
  jQuery(document).on("click", ".hd-btn-cancel", function () {
    jQuery(this).parents("tr").html(exitHTML);
    exitHTML = "";
  });

  //
  jQuery(document).on("click", ".hd-btn-save", function () {
    let id = jQuery(this).attr("data-id");

    let code = jQuery(this).parents("tr").find(".hd-customer-code").val();
    let fullName = jQuery(this).parents("tr").find(".hd-customer-customerName")
      .val();
    let address = jQuery(this).parents("tr").find(".hd-customer-address").val();
    let phone = jQuery(this).parents("tr").find(".hd-customer-phone").val();
    let warranty_ = jQuery(this)
      .parents("tr")
      .find(".hd-customer-warranty")
      .val();
    // let branch = jQuery(this).parents("tr").find("#branch_js").val();
    let service = jQuery(this).parents("tr").find(".hd-customer-service").val();
    let note = jQuery(this).parents("tr").find(".hd-customer-note").val();
    let year = jQuery(this).parents("tr").find(".hd-customer-year_birth").val();



    jQuery.ajax({
      type: "POST",
      url: url_ajax_plugin_manager_customer,
      data: {
        id: id,
        code: code,
        fullName: fullName,
        address: address,
        year_birth: year,
        phone: phone,
        warranty: warranty_,
        // branch: branch,
        service: service,
        note: note,
        action: "hd_js_action",
        param: "save_quick_form",
      },
      success: function (response) {
        window.location.reload();
      },
    });
  });
});
