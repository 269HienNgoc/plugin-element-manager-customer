<?php
if (!class_exists('List_table')) {
    include_once HDEL_PLUGIN_DIR . 'admin/component/list-table.php';
}
$my_list_table = new List_table();
$my_list_table->prepare_items();

?>
<div class="title"><h1>QUẢN LÝ KHÁCH HÀNG - THỜI GIAN BẢO HÀNH</h1></div>
<div class="wrap">
    <form id="my-list-table" action="<?php echo admin_url('admin.php?page=hd-manager-customer') ?>" method="post">
        <input type="hidden" name="page" value="list-books">

        <?php $my_list_table->search_box("Tìm Kiếm", "search_") ?>

        <?php $my_list_table->display(); ?>

    </form>
</div>