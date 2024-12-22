<?php

use Elementor\Widget_Base;

class Widget_form_data extends Widget_Base
{
    public function get_name()
    {
        return 'data_form';
    }

    public function get_title()
    {
        return esc_html__('Data Form');
    }

    public function get_icon()
    {
        return 'eicon-code';
    }

    public function get_categories(): array
    {
        return ['basic'];
    }

    public function get_script_depends(): array
    {
        return ['widget-script-1'];
    }

    public function get_style_depends(): array
    {
        return ['widget-style-1'];
    }

    private function Search_($req)
    {
        global $wpdb;

        $table = $wpdb->prefix . "hd_manager_customer";

        $search = sanitize_text_field($req) ?? false;
        if ($search) {
            $result = $wpdb->get_results("SELECT 
                                                    a.id,
                                                    a.fullname,
                                                    a.year_birth,
                                                    a.address_info,
                                                    a.phone,
                                                    a.code,
                                                    a.warranty_time,
                                                    a.active,
                                                    a.service_,
                                                    a.note,
                                                    p.branch_name
                                                FROM
                                                    $table a
                                                LEFT JOIN {$wpdb->prefix}hd_branch p ON a.branch_id = p.id
                                                WHERE
                                                    code = '{$search}' ", ARRAY_A);
            return $result;
        }

    }

    protected function render()
    {   
        $data = $this->Search_($_REQUEST['search_code']);
        
        ob_start();
        $cont = require_once HDEL_PLUGIN_DIR . '/widget/component/form-data.php';
        $cont = ob_get_contents();
        ob_end_clean();
        echo $cont;
    }

    protected function content_template() {}
}
