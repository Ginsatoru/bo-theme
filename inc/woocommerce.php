<?php
/**
 * WooCommerce integration - Simplified Version
 */

if (!defined('ABSPATH')) {
    exit;
}

// Add theme support
function mr_woocommerce_setup() {
    add_theme_support('woocommerce');
    add_theme_support('wc-product-gallery-zoom');
    add_theme_support('wc-product-gallery-lightbox');
    add_theme_support('wc-product-gallery-slider');
}
add_action('after_setup_theme', 'mr_woocommerce_setup');

// Enqueue WooCommerce styles
function mr_woocommerce_scripts() {
    wp_enqueue_style('mr-woocommerce', MR_THEME_URI . '/assets/css/woocommerce.css', array('mr-style'), MR_THEME_VERSION);
    
    // Enqueue My Account styles only on My Account page
    if (is_account_page()) {
        wp_enqueue_style('mr-woocommerce-myaccount', MR_THEME_URI . '/assets/css/woocommerce-myaccount.css', array('mr-woocommerce'), MR_THEME_VERSION);
    }
}
add_action('wp_enqueue_scripts', 'mr_woocommerce_scripts');

// Modify WooCommerce markup
function mr_woocommerce_modifications() {
    // Remove default sidebar (we'll add custom one in template)
    remove_action('woocommerce_sidebar', 'woocommerce_get_sidebar', 10);
    
    // Change products per page to 50
    add_filter('loop_shop_per_page', 'mr_products_per_page', 20);
    
    // Change related products count
    add_filter('woocommerce_output_related_products_args', 'mr_related_products_args');
    
    // Modify product gallery
    add_filter('woocommerce_single_product_image_gallery_classes', 'mr_product_gallery_classes');
}
add_action('wp', 'mr_woocommerce_modifications');

/**
 * Set products per page to 50
 */
function mr_products_per_page() {
    return 50;
}

/**
 * Configure related products
 */
function mr_related_products_args($args) {
    $args['posts_per_page'] = get_theme_mod('related_products_count', 4);
    $args['columns'] = 4;
    return $args;
}

/**
 * Add custom class to product gallery
 */
function mr_product_gallery_classes($classes) {
    $classes[] = 'woocommerce-product-gallery--custom';
    return $classes;
}

/**
 * Modify products per row for grid layout
 */
function mr_woocommerce_products_per_row() {
    return get_theme_mod('products_per_row', 3);
}
add_filter('loop_shop_columns', 'mr_woocommerce_products_per_row');

/**
 * Add custom image sizes for WooCommerce
 */
function mr_woocommerce_image_sizes() {
    add_image_size('mr-product-card', 400, 400, true);
    add_image_size('mr-product-thumbnail', 150, 150, true);
}
add_action('after_setup_theme', 'mr_woocommerce_image_sizes');

/**
 * Remove WooCommerce wrappers
 */
remove_action('woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
remove_action('woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);

/**
 * Add custom body class for My Account page
 */
function mr_myaccount_body_class($classes) {
    if (is_account_page()) {
        $classes[] = 'woocommerce-account';
    }
    return $classes;
}
add_filter('body_class', 'mr_myaccount_body_class');

/**
 * Customize My Account menu items order
 */
function mr_custom_my_account_menu_order() {
    return array(
        'dashboard'          => __('Dashboard', 'woocommerce'),
        'orders'             => __('Orders', 'woocommerce'),
        'downloads'          => __('Downloads', 'woocommerce'),
        'edit-address'       => __('Addresses', 'woocommerce'),
        'payment-methods'    => __('Payment methods', 'woocommerce'),
        'edit-account'       => __('Account details', 'woocommerce'),
        'customer-logout'    => __('Logout', 'woocommerce'),
    );
}
add_filter('woocommerce_account_menu_items', 'mr_custom_my_account_menu_order');

/**
 * Modify Dashboard Content - Add Grid Cards
 */
function mr_custom_dashboard_content() {
    $current_user = wp_get_current_user();
    $display_name = !empty($current_user->first_name) 
        ? $current_user->first_name 
        : $current_user->display_name;
    
    ?>
    <div class="woocommerce-MyAccount-dashboard-intro">
        <h2 class="dashboard-greeting">
            <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/icons/profile-icon.png'); ?>" alt="Profile" class="greeting-icon">
            Hello <span class="greeting-name"><?php echo esc_html($display_name); ?></span>
        </h2>
    </div>

    <div class="woocommerce-MyAccount-dashboard-grid">
        
        <a href="<?php echo esc_url(wc_get_account_endpoint_url('orders')); ?>" class="dashboard-card">
            <div class="dashboard-card__icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                </svg>
            </div>
            <h3 class="dashboard-card__title"><?php esc_html_e('Orders', 'macedon-ranges'); ?></h3>
            <p class="dashboard-card__description"><?php esc_html_e('View your order history', 'macedon-ranges'); ?></p>
        </a>

        <a href="<?php echo esc_url(wc_get_account_endpoint_url('downloads')); ?>" class="dashboard-card">
            <div class="dashboard-card__icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10"/>
                </svg>
            </div>
            <h3 class="dashboard-card__title"><?php esc_html_e('Downloads', 'macedon-ranges'); ?></h3>
            <p class="dashboard-card__description"><?php esc_html_e('Access your downloads', 'macedon-ranges'); ?></p>
        </a>

        <a href="<?php echo esc_url(wc_get_account_endpoint_url('edit-address')); ?>" class="dashboard-card">
            <div class="dashboard-card__icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
            </div>
            <h3 class="dashboard-card__title"><?php esc_html_e('Addresses', 'macedon-ranges'); ?></h3>
            <p class="dashboard-card__description"><?php esc_html_e('Manage billing & shipping', 'macedon-ranges'); ?></p>
        </a>

        <a href="<?php echo esc_url(wc_get_account_endpoint_url('edit-account')); ?>" class="dashboard-card">
            <div class="dashboard-card__icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
            </div>
            <h3 class="dashboard-card__title"><?php esc_html_e('Account Details', 'macedon-ranges'); ?></h3>
            <p class="dashboard-card__description"><?php esc_html_e('Update your information', 'macedon-ranges'); ?></p>
        </a>

        <a href="<?php echo esc_url(wc_get_account_endpoint_url('payment-methods')); ?>" class="dashboard-card">
            <div class="dashboard-card__icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                </svg>
            </div>
            <h3 class="dashboard-card__title"><?php esc_html_e('Payment Methods', 'macedon-ranges'); ?></h3>
            <p class="dashboard-card__description"><?php esc_html_e('Manage saved payment cards', 'macedon-ranges'); ?></p>
        </a>

        <a href="<?php echo esc_url(home_url('/contact')); ?>" class="dashboard-card">
            <div class="dashboard-card__icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <h3 class="dashboard-card__title"><?php esc_html_e('Support', 'macedon-ranges'); ?></h3>
            <p class="dashboard-card__description"><?php esc_html_e('Get help & contact us', 'macedon-ranges'); ?></p>
        </a>

    </div>
    <?php
}
remove_action('woocommerce_account_dashboard', 'woocommerce_account_dashboard', 10);
add_action('woocommerce_account_dashboard', 'mr_custom_dashboard_content', 10);

/**
 * Add data-title attribute to order table cells for responsive design
 */
function mr_add_data_title_to_order_table() {
    ?>
    <script type="text/javascript">
        jQuery(document).ready(function($) {
            $('.woocommerce-orders-table thead th').each(function(index) {
                var title = $(this).text();
                $('.woocommerce-orders-table tbody tr').each(function() {
                    $(this).find('td').eq(index).attr('data-title', title);
                });
            });
        });
    </script>
    <?php
}
add_action('woocommerce_account_orders_endpoint', 'mr_add_data_title_to_order_table');