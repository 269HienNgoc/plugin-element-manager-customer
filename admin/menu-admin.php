<?php

/**
 * Summary of AdminMenu
 */
if (!class_exists('AdminMenu')) {
    class AdminMenu
    {
        private static $instance = null;
        private $mess = '';
        /**
         * Summary of __construct
         */
        public function __construct()
        {
            $this->Register();
        }
        /**
         * Summary of GetInstance
         * @return AdminMenu
         */
        public static function GetInstance()
        {
            if (self::$instance === null) {
                self::$instance = new AdminMenu;
            }
            return self::$instance;
        }

        /**
         * Summary of Register
         * @return void
         */
        public function Register()
        {
            //Add menu
            add_action('admin_menu', [$this, 'AddMenuAdmin']);
            //Register CSS, JS
            add_action('admin_enqueue_scripts', [$this, 'RegisterScript']);
        }
        /**
         * Summary of AddMenuAdmin
         * Add Admin Menu QL Địa chỉ
         * @return void
         */
        public function AddMenuAdmin()
        {
            add_menu_page(
                'Manager Customer',
                'Manager Customer',
                'manage_options',
                'hd-manager-customer',
                [$this, 'CreateInterfaceAdmin'],
                'dashicons-list-view',
                10
            );
            add_submenu_page(
                'hd-manager-customer',
                'Add New',
                'Add New',
                'manage_options',
                'hd-add-customer',
                [$this, 'CreateNewCustomer']
            );
            add_submenu_page(
                'hd-manager-customer',
                'Branch',
                'Branch',
                'manage_options',
                'hd-add-branch',
                [$this, 'CreateNewBranch']
            );
        }

        public function CreateInterfaceAdmin()
        {
            ob_start();
            require_once HDEL_PLUGIN_DIR . 'admin/component/view-table.php';
            $the_contents = ob_get_contents();
            ob_end_clean();
            echo $the_contents;
        }

        public function CreateNewCustomer()
        {
            $this->SaveInfoCustomer();

            $branch = $this->GetValueBranch();

            $response = $this->mess;

            ob_start();
            require_once HDEL_PLUGIN_DIR . 'admin/component/add-new.php';
            $the_contents = ob_get_contents();
            ob_end_clean();
            echo $the_contents;
        }

        public function CreateNewBranch(){

            $this->SaveBranch();
            $response = $this->mess;

            ob_start();
            require_once HDEL_PLUGIN_DIR . 'admin/component/category-branch.php';
            $the_content = ob_get_contents();
            ob_end_clean();
            echo $the_content;
        }

        private function SaveInfoCustomer()
        {
            global $wpdb;

            $perfix  =  $wpdb->prefix;

            

            if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_REQUEST['submit-btn'])) {
                //Sanitize
                $fullName =   sanitize_text_field($_REQUEST['fullname']) ?? '';
                $nameAddress =   sanitize_text_field($_REQUEST['nameAddress']) ?? '';
                $phone =   sanitize_text_field($_REQUEST['phone']) ?? '';
                $branch_id = isset($_REQUEST['branch_']) ? intval($_REQUEST['branch_']) : 0; 
                $service_ =   sanitize_text_field($_REQUEST['service_']) ?? '';
                $warranty_time = $_REQUEST['warranty_time'];
                $code   = sanitize_text_field($_REQUEST['code']) ?? '';
                $note   = sanitize_textarea_field($_REQUEST['note']) ?? '';

                $fomat_warranty_time = date('Y-m-d', strtotime(str_replace('/', '-', $warranty_time)));

                $wpdb->insert("{$perfix}hd_manager_customer", [
                    'fullname' => $fullName,
                    'address_info' =>  $nameAddress,
                    'phone' =>  $phone,
                    'code' => $code,
                    'active' => 0,
                    'warranty_time' => $fomat_warranty_time,
                    'branch_id' =>  $branch_id,
                    'service_' => $service_,
                    'note' => $note,
                ]);

                $address_id = $wpdb->insert_id;

                if ($address_id > 0) {
                    $this->mess = "Thêm thành công...";
                } else {
                    $this->mess = "Tạo thất bại...";
                }
            }
        }

        /**
         * Summary of SaveBranch
         * @return void
         */
        private function SaveBranch()  {

            global $wpdb;
            $perfix  =  $wpdb->prefix;

            if ( $_SERVER["REQUEST_METHOD"] == "POST" && isset($_REQUEST["submit-btn-branch"])) {

                $namebranch = sanitize_text_field($_REQUEST['namebranch']);
                
                try {
                    $wpdb->insert("{$perfix}hd_branch", [
                        'branch_name' => $namebranch,
                    ]);
    
                    $branch_id = $wpdb->insert_id;
    
                    if ($branch_id > 0) {
                        $this->mess = "Thêm thành công...";
                    } else {
                        $this->mess = "Thêm không thành công...";
                    }

                } catch (\Throwable $th) {
                    //throw $th;
                    $this->mess = "Error when insert data: " . $th->getMessage();
                }
            }
            
        }
        private function GetValueBranch(){
            global $wpdb;
            $results = $wpdb->get_results("SELECT id, branch_name FROM {$wpdb->prefix}hd_branch");
            return $results;
        }
        public function RegisterScript($hook)
        {
            wp_register_style('add-news-style', HDEL_PLUGIN_URL . '/asset/add-new.css', array(), 'all');

            $arr = [
                'manager-customer_page_hd-add-customer',
                'manager-customer_page_hd-add-branch'
            ];

            if ( in_array($hook, $arr) ) {
                wp_enqueue_style('add-news-style');
            }
        }
    }
    AdminMenu::GetInstance();
}
