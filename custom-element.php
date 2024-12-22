<?php 
/**
 * Plugin Name: Element Custom
 */

 define('HDEL_VERSION_CSS_JS', time());
define('HDEL_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('HDEL_PLUGIN_URL', plugin_dir_url(__FILE__));

require_once HDEL_PLUGIN_DIR . 'database/create-db.php';
require_once HDEL_PLUGIN_DIR . 'admin/menu-admin.php';




 if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

final class Custom_element {
    public function __construct(){

        // Call Hook
        $this->ActionHook();
    }

    public function ActionHook(){

        //Register Widget.
        add_action( 'elementor/widgets/register', [$this, 'RegisterElement'] );
        
        //Register Widget CSS, JS interface
        add_action( 'wp_enqueue_scripts', [$this, 'RegisterCssJs'] );

    }

    public function RegisterElement($widgets_manager){
        require_once HDEL_PLUGIN_DIR . '/widget/widget-form-data.php';

        $widgets_manager->register( new Widget_form_data() );

    }

    public function RegisterCssJs(){
        //JS
        wp_register_script( 'widget-script-1', HDEL_PLUGIN_URL . '/asset/script_interface.js', ['jquery'],HDEL_VERSION_CSS_JS, true );

        //CSS
        wp_register_style( 'widget-style-1', HDEL_PLUGIN_URL . '/asset/style.css',[], HDEL_VERSION_CSS_JS, 'all'  );

    }
}
new Custom_element();