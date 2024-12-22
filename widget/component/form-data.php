<div class="form_send_data">
    <div class="send_data">
        <form action="" method="post">
            <label for="search_code" class="label_code">Enter customer code</label>
            <input type="text" name="search_code" id="search_code" class="search_code">
            <button name="btn_send_code" id="btn_send_code" class="btn_send_code">Check Code</button>
        </form>
    </div>
    <?php if(!empty($data)){ ?>
    <div class="show_info">
        <?php foreach($data as $val){ ?>
        <div class="info_customer">
            <div class="code"><p><span>Code:</span> <?=  $val['code'] ?></p></div>
            <div class="fullname"><p><span>Full Name:</span> <?=  $val['fullname'] ?></p></div>
            <div class="phone"><p><span>Phone:</span> <?=  $val['phone'] ?></p></div>
            <div class="address"><p><span>Address:</span> <?=  $val['address_info'] ?></p></div>
            <div class="yeah_birth"><p><span>Yeah Of Birth:</span> <?=  $val['year_birth'] ?></p></div>
        </div>
        <div class="time">
            <div class="warranty_time"><p><span>Warranty time:</span> <?=  $val['warranty_time'] ?></p></div>
            <div class="status_warranty"><p><span>Status Warranty:</span> <?php if($val['active'] == 0){ echo '<span style="color: #FF0000">Expired</span>'; } else{ echo '<span style="color: #00b715">Available</span>'; }  ?></p></div>
            <div class="branch"><p><span>Branch:</span> <?=  $val['branch_name'] ?></p></div>
        </div>
        <div class="bracnh">
            <div class="service"><p><span>Service:</span> <?=  $val['service_'] ?? 'No Comment!' ?></p></div>
            <div class="note"><p><span>Note:</span> <?=  $val['note'] ?? 'No Comment!' ?></p></div>
        </div>
        <?php } ?>
    </div>
    <?php } ?>
</div>