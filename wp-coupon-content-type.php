<?php
/**
* Plugin Name:       WP Coupon Content Type
* Plugin URI:        http://smooththemes.com/
* Description:       Register coupon post type and taxonomies
* Version:           1.0.0
* Author:            SmoothThemes
* Author URI:        http://smoothemes.com/
* License:           GPL-2.0+
* License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
* Text Domain:       wp-coupons
* Domain Path:       /languages
*/

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
    die;
}
/**
* Make sure this plugin load one time
*
*/
if ( ! defined( 'WPCOUPON_PATH' ) ) {
    define( 'WPCOUPON_URL', trailingslashit(plugins_url('', __FILE__) ) );
    define( 'WPCOUPON_PATH', trailingslashit(plugin_dir_path(__FILE__) ));

    class WP_Coupons_Plugin {

        function __construct(){
            $this->inc();
        }
        function inc(){
            include_once WPCOUPON_PATH.'includes/post-type.php';
            include_once WPCOUPON_PATH.'includes/shortcodes.php';
        }
    }

    function WP_Coupons_Plugin(){
        return new WP_Coupons_Plugin();
    }
    add_action( 'plugins_loaded', 'WP_Coupons_Plugin' );

}
