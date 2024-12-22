<?php
if (!class_exists('CreateDB')) {
    class CreateDB
    {
        private static $instance = null;
        public function __construct()
        {
            $this->CreateTableInfoCustomer();
            $this->CreateTableBranch();
        }

        public static function GetInstance()
        {
            if (self::$instance === null) {
                self::$instance = new CreateDB();
            }
            return self::$instance;
        }

        public function CreateTableInfoCustomer()
        {
            global $wpdb;
            
            $tableName  =  $wpdb->prefix . 'hd_manager_customer'; 
            $tableBranch = $wpdb->prefix . 'hd_branch';
            $charset_collect = $wpdb->get_charset_collate();

            $table_exists = $wpdb->get_var("SHOW TABLES LIKE '$tableName'");

            if (!$table_exists) {

                $escaped_tablename = $wpdb->_escape($tableName);
                $escaped_tablebranch = $wpdb->_escape($tableBranch);


                try {
                    $wpdb->query(query: 'SET FOREIGN_KEY_CHECKS = 0;');

                    $sql = "CREATE TABLE IF NOT EXISTS $escaped_tablename ( 
                            id INT AUTO_INCREMENT PRIMARY KEY,
                            fullname VARCHAR(255) NOT NULL,
                            address_info VARCHAR(255) NOT NULL,
                            year_birth VARCHAR(255) NOT NULL,
                            phone VARCHAR(255) NOT NULL,
                            code VARCHAR(255) NOT NULL,
                            warranty_time DATE NOT NULL,
                            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                            active INT(11),
                            branch_id INT(11) NOT NULL,
                            FOREIGN KEY (branch_id) REFERENCES $escaped_tablebranch(id) ON DELETE CASCADE,
                            INDEX (branch_id),
                            service_ VARCHAR(255) NOT NULL,
                            note VARCHAR(255) NOT NULL
                        )$charset_collect;";

                    // $prepare_ = $wpdb->prepare($sql, $tableName, $table_provice, $charset_collect);
                    require_once ABSPATH . '/wp-admin/includes/upgrade.php';

                    dbDelta($sql);
                } finally {
                    $wpdb->query('SET FOREIGN_KEY_CHECKS = 1;');
                }
            }
        }

        public function CreateTableBranch(){

            global $wpdb;

            $tableName  =  $wpdb->prefix . 'hd_branch';
            $charset_collect = $wpdb->get_charset_collate();
            $table_exists = $wpdb->get_var("SHOW TABLES LIKE '$tableName'");

            if (!$table_exists) {

                $escaped_table = $wpdb->_escape($tableName);

                $sql = "CREATE TABLE IF NOT EXISTS  $escaped_table (
                            id INT(11) AUTO_INCREMENT PRIMARY KEY,
                            branch_name VARCHAR(255) NOT NULL UNIQUE
                    ) $charset_collect;";

                // $prepare_ = $wpdb->prepare($sql, $tableName, $charset_collect);
                require_once ABSPATH . '/wp-admin/includes/upgrade.php';

                dbDelta($sql);
            }
        }

    }
    CreateDB::GetInstance();
}
