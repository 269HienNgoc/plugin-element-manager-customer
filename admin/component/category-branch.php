</br>
</br>
<div class="form_class">
  <div class="noti"><p><?php echo $response ?? '' ?></p></div>
  <form class="form-container" action="<?php echo admin_url('admin.php?page=hd-add-branch') ?>" method="POST">
    <div class="form-header">NHẬP TÊN CHI NHÁNH</div>
    <div class="form-group">
      <label for="namebranch">Tên thành phố</label>
      <input type="text" id="namebranch" name="namebranch" placeholder="Nhập tên tỉnh thành..." required>
    </div>
    <button type="submit" name="submit-btn-branch" class="submit-btn-branch">Lưu</button>
  </form>
</div>

