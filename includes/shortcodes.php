<?php
/**
 * Add shortcode
 * @see WPCoupon_Coupon_Submit_ShortCode
 * @since 1.0
 *
 */
add_shortcode( 'wpcoupon_submit', array( 'WPCoupon_Coupon_Submit_ShortCode', 'content_shortcode' ) );
