<?php
/**
 * WooCommerce Customizer Settings woocommerce.php
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Add WooCommerce customizer settings
 */
function mr_woocommerce_customizer($wp_customize) {
    
    // Add WooCommerce Section
    $wp_customize->add_section('mr_woocommerce_settings', array(
        'title'    => __('WooCommerce Settings', 'macedon-ranges'),
        'priority' => 120,
    ));
    
    // Products Per Page
    $wp_customize->add_setting('products_per_page', array(
        'default'           => 12,
        'sanitize_callback' => 'absint',
        'transport'         => 'refresh',
    ));
    
    $wp_customize->add_control('products_per_page', array(
        'label'       => __('Products Per Page', 'macedon-ranges'),
        'description' => __('Number of products to display per page in shop', 'macedon-ranges'),
        'section'     => 'mr_woocommerce_settings',
        'type'        => 'number',
        'input_attrs' => array(
            'min'  => 1,
            'max'  => 100,
            'step' => 1,
        ),
    ));
    
    // Shop Layout
    $wp_customize->add_setting('shop_layout', array(
        'default'           => 'grid',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ));
    
    $wp_customize->add_control('shop_layout', array(
        'label'   => __('Shop Layout', 'macedon-ranges'),
        'section' => 'mr_woocommerce_settings',
        'type'    => 'select',
        'choices' => array(
            'grid' => __('Grid', 'macedon-ranges'),
            'list' => __('List', 'macedon-ranges'),
        ),
    ));
    
    // Products Per Row
    $wp_customize->add_setting('products_per_row', array(
        'default'           => 3,
        'sanitize_callback' => 'absint',
        'transport'         => 'refresh',
    ));
    
    $wp_customize->add_control('products_per_row', array(
        'label'       => __('Products Per Row', 'macedon-ranges'),
        'description' => __('Number of product columns in grid layout', 'macedon-ranges'),
        'section'     => 'mr_woocommerce_settings',
        'type'        => 'select',
        'choices'     => array(
            '2' => __('2 Columns', 'macedon-ranges'),
            '3' => __('3 Columns', 'macedon-ranges'),
            '4' => __('4 Columns', 'macedon-ranges'),
            '5' => __('5 Columns', 'macedon-ranges'),
        ),
    ));
    
    // Show/Hide Product Rating
    $wp_customize->add_setting('show_product_rating', array(
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
        'transport'         => 'refresh',
    ));
    
    $wp_customize->add_control('show_product_rating', array(
        'label'   => __('Show Product Rating', 'macedon-ranges'),
        'section' => 'mr_woocommerce_settings',
        'type'    => 'checkbox',
    ));
    
    // Show/Hide Quick View
    $wp_customize->add_setting('show_quick_view', array(
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
        'transport'         => 'refresh',
    ));
    
    $wp_customize->add_control('show_quick_view', array(
        'label'   => __('Enable Quick View', 'macedon-ranges'),
        'section' => 'mr_woocommerce_settings',
        'type'    => 'checkbox',
    ));
    
    // Sale Badge Text
    $wp_customize->add_setting('sale_badge_text', array(
        'default'           => __('Sale', 'macedon-ranges'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ));
    
    $wp_customize->add_control('sale_badge_text', array(
        'label'   => __('Sale Badge Text', 'macedon-ranges'),
        'section' => 'mr_woocommerce_settings',
        'type'    => 'text',
    ));
    
    // Related Products Count
    $wp_customize->add_setting('related_products_count', array(
        'default'           => 4,
        'sanitize_callback' => 'absint',
        'transport'         => 'refresh',
    ));
    
    $wp_customize->add_control('related_products_count', array(
        'label'       => __('Related Products Count', 'macedon-ranges'),
        'description' => __('Number of related products to show on single product page', 'macedon-ranges'),
        'section'     => 'mr_woocommerce_settings',
        'type'        => 'number',
        'input_attrs' => array(
            'min'  => 0,
            'max'  => 12,
            'step' => 1,
        ),
    ));
    
    // Show/Hide Product Sidebar
    $wp_customize->add_setting('show_shop_sidebar', array(
        'default'           => false,
        'sanitize_callback' => 'wp_validate_boolean',
        'transport'         => 'refresh',
    ));
    
    $wp_customize->add_control('show_shop_sidebar', array(
        'label'   => __('Show Shop Sidebar', 'macedon-ranges'),
        'section' => 'mr_woocommerce_settings',
        'type'    => 'checkbox',
    ));
    
    // Cart Icon Style
    $wp_customize->add_setting('cart_icon_style', array(
        'default'           => 'icon-count',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ));
    
    $wp_customize->add_control('cart_icon_style', array(
        'label'   => __('Cart Icon Style', 'macedon-ranges'),
        'section' => 'mr_woocommerce_settings',
        'type'    => 'select',
        'choices' => array(
            'icon-only'  => __('Icon Only', 'macedon-ranges'),
            'icon-count' => __('Icon with Count', 'macedon-ranges'),
            'icon-total' => __('Icon with Total', 'macedon-ranges'),
        ),
    ));
}
add_action('customize_register', 'mr_woocommerce_customizer');