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

    protected function render()
    {
        ob_start();
        $cont = require_once HDEL_PLUGIN_DIR . '/widget/component/form-data.html';
        $cont = ob_get_contents();
        ob_end_clean();
        echo $cont;
    }

    protected function content_template() {}
}
