<?php
if (!class_exists('WP_List_Table')) {
    include_once ABSPATH . 'wp-admin/includes/class-wp-list-table.php';
}
class List_table extends WP_List_Table
{
    public function get_columns()
    {
        $columns = array(
            'cb'        => '<input type="checkbox" />', //Render a checkbox instead of text
            'id'    => 'ID',
            'code'      => 'Mã Code',
            'fullname'    => 'ID',
            'address_info'  => 'Tên Chi Nhánh',
            'phone'  => 'Địa chỉ',
            'active'  => 'Tình trạng',
            'warranty_time'  => 'Bảo hành tới',
            'branch_id'  => 'Chi Nhánh',
            'service_'  => 'Dịch vụ',
            'note'  => 'Ghi Chú',

        );
        return $columns;
    }

    public function get_sortable_columns()
    {
        $sortable_columns = array(
            'id'  => array('id', true),  //true means it's already sorted
            // 'name_address' => array('name_address', true),
            // 'address_line' => array('address_line', false),
            // 'img_url' => array('img_url', false),
            // 'phone' => array('phone', false),
            'fullname' => array('fullname', true),
        );
        return $sortable_columns;
    }

    public function prepare_items()
    {
        global $wpdb;
        $this->_column_headers = [$this->get_columns(), [], $this->get_sortable_columns()];

        echo $this->current_action();

        $table = $wpdb->prefix . 'hd_manager_customer';

        //Sort
        $orderBy = $_POST['orderby'] ?? 'id';
        $order = $_POST['order'] ?? 'ASC';

        //Paginate
        $per_page     = 20; // Số bản ghi trên mỗi trang
        $current_page = $this->get_pagenum();

        // Search KeyWork
        $search = $_POST['s'] ?? false;

        if ($search) {

            $total_items  = $wpdb->get_var("SELECT COUNT(*)
                                                    FROM $table a
                                                    LEFT JOIN {$wpdb->prefix}hd_branch p ON a.branch_id = p.id
                                                    WHERE a.fullname LIKE '%{$search}%' 
                                                    OR p.branch_name LIKE '%{$search}%'"); // Đếm tổng số bản ghi
            // Lấy dữ liệu từ database
            $this->items = $wpdb->get_results("SELECT 
                                                a.*,
                                                p.branch_name 
                                            FROM
                                                $table a
                                            LEFT JOIN 
                                                {$wpdb->prefix}hd_branch p ON a.branch_id = p.id
                                            WHERE
                                                 a.fullname LIKE '%{$search}%' 
                                                OR p.branch_name LIKE '%{$search}%'
                                            ORDER BY a.id
                                            LIMIT {$per_page}", ARRAY_A);
        } else {
            $total_items  = $wpdb->get_var("SELECT COUNT(*) FROM $table"); // Đếm tổng số bản ghi
            // Lấy dữ liệu từ database
            $this->items = $wpdb->get_results("SELECT 
                                                a.*, 
                                                p.branch_name 
                                            FROM 
                                                $table a
                                            LEFT JOIN 
                                                {$wpdb->prefix}hd_branch p ON a.branch_id = p.id
                                            ORDER BY 
                                               {$orderBy} {$order}
                                            LIMIT {$per_page} OFFSET " . ($current_page - 1) * $per_page, ARRAY_A);
            //Setup output save in array
        }

        $this->set_pagination_args(array(
            'total_items' => $total_items,
            'per_page'    => $per_page,
            'total_pages' => ceil($total_items / $per_page)
        ));
    }

    public function column_default($item, $column_name)
    {
        // var_dump($item);
        switch ($column_name) {
            case 'id':
            case 'code':
            case 'fullname':
            case 'address_info':
            case 'active':
            case 'warranty_time':
            case 'branch_id':
            case 'service_':
            case 'note':
                return $item[$column_name];
            default:
                return print_r($item, true); //Hiển thị toàn bộ object nếu không tìm thấy cột
        }
    }
    // Add Column Table.
    public function single_row_columns( $item ) {
        list( $columns, $hidden ) = $this->get_column_info();
    
        foreach ( $columns as $column_name => $column_display_name ) {
            // ... (giữ nguyên phần xử lý các cột khác) ...
            $class = "class='$column_name column-$column_name'";

            $style = '';
            if ( in_array( $column_name, $hidden ) )
                $style = ' style="display:none;"';
    
            $attributes = "$class$style";
    
            switch ( $column_name ) {

                case 'cb':
                    echo "<td $attributes>". sprintf('<input type="checkbox" name="my_list_table[]" value="%s" />', $item['id']) . "</td>";
                    break;

                case 'id':
                    echo "<td $attributes>" . $item['id'] . "</td>";
                    break;

                case 'code':
                    echo "<td $attributes>" . $item['code'] . "</td>";
                    break;

                case 'fullname':
                    echo "<td class='$column_name column-$column_name'>";

                    echo $item['fullname'] . '<br>' ;
                    
                    // Nút "Xem"
                    echo '<a href="?page=my_page&action=view&id=' . $item['id'] . '">Xem</a> |';
    
                    // Nút "Sửa"
                    echo '<a href="?page=my_page&action=edit&id=' . $item['id'] . '">Sửa</a> |';
    
                    // Nút "Xóa"
                    echo '<a href="?page=hd_manager_customer&action=delete&id=' . $item['id'] . '" onclick="return confirm(\'Bạn có chắc chắn muốn xóa?\')">Xóa</a>';
    
                    echo "</td>";
                    break;

                case 'address_info':
                    echo "<td $attributes>" . $item['address_info'] . "</td>";  
                    break;

                case 'active':
                    echo "<td $attributes> Col Actice here </td>";
                    break;

                case 'warranty_time':
                    echo "<td $attributes>" . $item['warranty_time'] . "</td>";
                    break;

                case 'branch_id':
                    echo "<td $attributes>" . $item['branch_id'] . "</td>";
                    break;
                case 'service_':
                    echo "<td $attributes>" . $item['service_'] . "</td>";
                    break;
                case 'note':
                    echo "<td $attributes>" . $item['note'] . "</td>";
                    break;
            }
        }
    }

    public function ModifyActionBtn( $actions, $id){

        if ( isset( $actions ) ?? null || isset($id) ?? null ) {
            switch ( $actions ) {
                case 'view':
                    // Xử lý hành động "Xem"
                    break;
                case 'edit':
                    // Xử lý hành động "Sửa"
                    break;
                case 'delete':
                    // Xử lý hành động "Xóa"
            break;
            }
        }


    }
}