</br>
</br>
<div class="noti"><p><?php echo $response ?? '' ?></p></div>
<form class="form-container" action="<?php echo admin_url('admin.php?page=hd-add-customer') ?>" method="post">
  <div class="form-header">NHẬP THÔNG TIN KHÁCH HÀNG</div>
  <div class="form-group">
    <label for="fullname">Họ và tên</label>
    <input type="text" id="fullname" name="fullname" placeholder="Nhập địa chỉ..." >
  </div>
  <div class="form-group">
    <label for="year-brith">Năm sinh</label>
    <input type="text" id="year-brith" name="year-brith" placeholder="Nhập năm sinh..." >
  </div>
  <div class="form-group">
    <label for="nameAddress">Địa chỉ</label>
    <input type="text" id="nameAddress" name="nameAddress" placeholder="Nhập địa chỉ..." required>
  </div>
  <div class="form-group">
    <label for="phone">Nhập SĐT</label>
    <input type="text" id="phone" name="phone" placeholder="Nhập SĐT...">
  </div>
  <div class="form-group">
    <label for="code">Nhập mã Code</label>
    <input type="text" id="code" name="code" placeholder="Nhập mã code..." required>
  </div>
  <div class="form-group">
    <label for="warranty_time">Thời gian bảo hành đến</label>
    <input type="date" id="warranty_time" name="warranty_time" placeholder="Nhập thời gian bảo hành...." required>
  </div>
  <div class="form-group">
    <label for="branch_">Chi nhánh thực hiện</label>
    <select id="branch_" name="branch_" required>
      <option>Chọn chi nhánh</option>
      <?php foreach($branch as $val){ ?>
      <option value="<?= $val->id ?>"><?= $val->branch_name ?></option>
      <?php } ?>
    </select>
  </div>
  <div class="form-group">
    <label for="service_">Tên dịch vụ</label>
    <input type="text" id="service_" name="service_" placeholder="Nhập tên dịch vụ" required>
  </div>
  <div class="form-group">
    <label for="note">Ghi Chú</label>
    <textarea id="note" name="note" rows="4" cols="80"> </textarea>
  </div>
  <button type="submit" name="submit-btn" class="submit-btn">Lưu</button>
</form>