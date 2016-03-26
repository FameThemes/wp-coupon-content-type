<?php

add_action( 'init', 'wpcoupon_post_types_init' );

/**
 * Register post types for theme.
 *
 * @TODO  Register coupon, store post type, store taxonomies
 * @link http://codex.wordpress.org/Function_Reference/register_post_type
 * @since 1.0.0
 */
function wpcoupon_post_types_init() {
    // Coupon post type
    $labels = array(
        'name'               => _x( 'Coupons', 'post type general name', 'wp-coupon' ),
        'singular_name'      => _x( 'Coupon', 'post type singular name', 'wp-coupon' ),
        'menu_name'          => _x( 'Coupons', 'admin menu', 'wp-coupon' ),
        'name_admin_bar'     => _x( 'Coupon', 'add new on admin bar', 'wp-coupon' ),
        'add_new'            => _x( 'Add New', 'coupon', 'wp-coupon' ),
        'add_new_item'       => __( 'Add New Coupon', 'wp-coupon' ),
        'new_item'           => __( 'New Coupon', 'wp-coupon' ),
        'edit_item'          => __( 'Edit Coupon', 'wp-coupon' ),
        'view_item'          => __( 'View Coupon', 'wp-coupon' ),
        'all_items'          => __( 'All Coupons', 'wp-coupon' ),
        'search_items'       => __( 'Search Coupons', 'wp-coupon' ),
        'parent_item_colon'  => __( 'Parent Coupons:', 'wp-coupon' ),
        'not_found'          => __( 'No coupons found.', 'wp-coupon' ),
        'not_found_in_trash' => __( 'No coupons found in Trash.', 'wp-coupon' )
    );

    $args = array(
        'labels'             => $labels,
        'public'             => false,
        'publicly_queryable' => false,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => false,
        'rewrite'            => array( 'slug' => 'coupon' ),
        'capability_type'    => 'post',
        'has_archive'        => false,
        'hierarchical'       => false,
        'menu_position'      => null,
        'menu_icon'          => 'dashicons-tickets-alt',
        'supports'           => array( 'title', 'editor', 'thumbnail', 'author', 'excerpt', 'comments' )
    );

    register_post_type( 'coupon', $args );


    /**
     * Store category
     * Add new taxonomy, make it hierarchical (like categories)
     */
    $labels = array(
        'name'              => _x( 'Coupon Categories', 'taxonomy general name', 'wp-coupon' ),
        'singular_name'     => _x( 'Coupon Category', 'taxonomy singular name', 'wp-coupon' ),
        'search_items'      => __( 'Search Coupon Categories', 'wp-coupon' ),
        'all_items'         => __( 'All Coupon Categories', 'wp-coupon' ),
        'parent_item'       => __( 'Parent Coupon Category', 'wp-coupon' ),
        'parent_item_colon' => __( 'Parent Coupon Category:', 'wp-coupon' ),
        'edit_item'         => __( 'Edit Coupon Category', 'wp-coupon' ),
        'update_item'       => __( 'Update Category', 'wp-coupon' ),
        'add_new_item'      => __( 'Add New Coupon Category', 'wp-coupon' ),
        'new_item_name'     => __( 'New Coupon Category Name', 'wp-coupon' ),
        'menu_name'         => __( 'Categories', 'wp-coupon' ),
    );

    $args = array(
        'hierarchical'      => true,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => false,
        'show_in_menu'      => true,
        'show_in_nav_menus' => true,
        'show_in_quick_edit' => true,
        'rewrite'           => array( 'slug' => 'coupon-category' ),
    );

    register_taxonomy( 'coupon_category', array( 'coupon' ), $args );


    /**
     * Coupon Store
     *
     * Add new taxonomy, make it hierarchical (like categories)
     */
    $labels = array(
        'name'              => _x( 'Coupon Stores', 'taxonomy general name', 'wp-coupon' ),
        'singular_name'     => _x( 'Coupon Store', 'taxonomy singular name', 'wp-coupon' ),
        'search_items'      => __( 'Search Stores', 'wp-coupon' ),
        'all_items'         => __( 'All Stores', 'wp-coupon' ),
        'parent_item'       => __( 'Parent Store', 'wp-coupon' ),
        'parent_item_colon' => __( 'Parent Store:', 'wp-coupon' ),
        'update_item'       => __( 'Update Store', 'wp-coupon' ),
        'add_new_item'      => __( 'Add New Store', 'wp-coupon' ),
        'new_item_name'     => __( 'New Store', 'wp-coupon' ),
        'menu_name'         => __( 'Stores', 'wp-coupon' ),
        'view_item'         => __( 'View Store', 'wp-coupon' ),
        'edit_item'         => __( 'Edit Store', 'wp-coupon' ),
    );

    $args = array(
        'hierarchical'      => true,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'show_in_menu'      => true,
        'show_in_nav_menus' => true,
        'show_in_quick_edit'=> true,
        'rewrite'           => array( 'slug' => 'store' ),
    );

    register_taxonomy( 'coupon_store', array( 'coupon' ), $args );


}


if ( is_admin()  ) {

    class  WPCoupon_Edit_Taxs_Columns{

        function __construct() {

            add_filter('manage_edit-coupon_category_columns', array( $this, 'category_columns' ) );
            add_filter('manage_coupon_category_custom_column',  array( $this, 'category_fields' ), 10, 3);

            add_filter('manage_edit-coupon_store_columns', array( $this, 'store_columns' ) );
            add_filter('manage_coupon_store_custom_column',  array( $this, 'store_fields' ), 5, 3);

        }

        function category_columns( $columns ) {
            // add 'My Column'
            $columns['icon'] = __( 'Icon', 'wp-coupon' );
            return $columns;
        }

        function category_fields( $term , $column_name, $term_id ){
            switch ( $column_name ) {
                case 'icon':
                    $icon = get_term_meta( $term_id , '_wpc_icon', true );
                    if ( trim( $icon ) !== '' ){
                        echo '<span class="c-cat-icon"><i class="'.esc_attr( $icon ).'"></i></span>';
                    }
                    break;
            }
        }

        function store_columns( $columns ) {
            //$name = $columns['name'];
            //unset( $columns['name'] );
            //unset( $columns['description'] );
            //unset( $columns['slug'] );
            //$count = $columns['count'];
            // st_debug( $columns ); die();

            $new_columns = array();
            $new_columns['thumb'] = __( 'Thumbnail', 'wp-coupon' );
            $new_columns['name']  =  $columns['name'];
            $new_columns['posts'] =  $columns['posts'];
            $new_columns['url']   = __( 'URL', 'wp-coupon' );
            $new_columns['out']   = __( 'Out', 'wp-coupon' );
            $new_columns['feature']  = '<span class="dashicons dashicons-star-filled"></span>';
            return $new_columns;
        }

        function store_fields( $unknown , $column_name, $term_id ){
            $s = new WPCoupon_Store( $term_id );
            switch ( $column_name ) {
                case 'thumb':
                    echo $s->get_thumbnail();
                    break;
                case 'feature':
                    if ( $s->is_featured() ){
                        echo '<span class="dashicons dashicons-star-filled"></span>';
                    } else {
                        echo '<span class="dashicons dashicons-star-empty"></span>';
                    }
                    break;
                case 'icon':
                    $icon = get_term_meta( $term_id , '_wpc_icon', true );
                    if ( trim( $icon ) !== '' ){
                        echo '<span class="c-cat-icon"><i class="'.esc_attr( $icon ).'"></i></span>';
                    }
                    break;
                case 'out':
                    $out = get_term_meta( $term_id , '_wpc_go_out', true );
                    echo intval( $out );
                    break;
                case 'url':
                    ?>
                    <div>
                        <span><?php _e( 'URL:' ); ?></span>
                        <?php  echo ( $s->_wpc_store_url != '' ) ? '<a href="'.esc_url($s->_wpc_store_url).'" title="'.esc_attr( $s->_wpc_store_url ).'">'.esc_html($s->_wpc_store_url).'</a>' : __( '[empty]', 'wp-coupon' ); ?>
                    </div>
                    <div>
                        <span><?php _e( 'Aff:' ); ?></span>
                        <?php  echo ( $s->_wpc_store_aff_url != '' ) ? '<a href="'.esc_url($s->_wpc_store_aff_url).'" title="'.esc_attr( $s->_wpc_store_aff_url ).'">'.esc_html($s->_wpc_store_aff_url).'</a>' : __( '[empty]', 'wp-coupon' ); ?>
                    </div>
                    <?php
                    break;
            }
        }

    }

    new WPCoupon_Edit_Taxs_Columns();


}



