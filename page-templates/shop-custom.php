<?php
/**
 * Template Name: Shop Custom Layout
 * 
 * Custom shop template with 71% width product section
 * Keeps footer and other elements full width
 *
 * @package Macedon_Ranges
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header('shop');
?>

<div class="shop-page-wrapper shop-custom-layout">
    <div class="shop-custom-container">
        
        <?php
        /**
         * Hook: woocommerce_before_main_content
         */
        do_action('woocommerce_before_main_content');
        ?>
        
        <div class="shop-layout">
            
            <!-- Shop Sidebar -->
            <?php if (is_active_sidebar('shop-sidebar')) : ?>
                <aside class="shop-sidebar" id="shop-sidebar" role="complementary" aria-label="<?php esc_attr_e('Product Filters', 'macedon-ranges'); ?>">
                    
                    <!-- Mobile Filter Toggle -->
                    <button class="shop-sidebar__toggle" 
                            aria-expanded="false" 
                            aria-controls="shop-sidebar-content"
                            aria-label="<?php esc_attr_e('Toggle Filters', 'macedon-ranges'); ?>">
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V3z" clip-rule="evenodd"/>
                        </svg>
                        <span><?php esc_html_e('Filters', 'macedon-ranges'); ?></span>
                    </button>
                    
                    <!-- Sidebar Content -->
                    <div class="shop-sidebar__content" id="shop-sidebar-content">
                        <div class="shop-sidebar__header">
                            <h3><?php esc_html_e('Filter Products', 'macedon-ranges'); ?></h3>
                            <button class="shop-sidebar__close" aria-label="<?php esc_attr_e('Close Filters', 'macedon-ranges'); ?>">
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                </svg>
                            </button>
                        </div>
                        
                        <?php dynamic_sidebar('shop-sidebar'); ?>
                    </div>
                    
                    <!-- Sidebar Overlay for Mobile -->
                    <div class="shop-sidebar__overlay"></div>
                    
                </aside>
            <?php endif; ?>
            
            <!-- Main Product Area -->
            <div class="shop-main">
                
                <!-- Page Header -->
                <header class="woocommerce-products-header">
                    <?php if (apply_filters('woocommerce_show_page_title', true)) : ?>
                        <h1 class="woocommerce-products-header__title page-title">
                            <?php woocommerce_page_title(); ?>
                        </h1>
                    <?php endif; ?>

                    <?php
                    /**
                     * Hook: woocommerce_archive_description
                     */
                    do_action('woocommerce_archive_description');
                    ?>
                </header>

                <?php
                if (woocommerce_product_loop()) {
                    
                    /**
                     * Hook: woocommerce_before_shop_loop
                     */
                    do_action('woocommerce_before_shop_loop');

                    woocommerce_product_loop_start();

                    if (wc_get_loop_prop('total')) {
                        while (have_posts()) {
                            the_post();

                            /**
                             * Hook: woocommerce_shop_loop
                             */
                            do_action('woocommerce_shop_loop');

                            wc_get_template_part('content', 'product');
                        }
                    }

                    woocommerce_product_loop_end();

                    /**
                     * Hook: woocommerce_after_shop_loop
                     */
                    do_action('woocommerce_after_shop_loop');
                    
                } else {
                    
                    /**
                     * Hook: woocommerce_no_products_found
                     */
                    do_action('woocommerce_no_products_found');
                }

                /**
                 * Hook: woocommerce_after_main_content
                 */
                do_action('woocommerce_after_main_content');
                ?>
                
            </div><!-- .shop-main -->
            
        </div><!-- .shop-layout -->
        
    </div><!-- .shop-custom-container -->
</div><!-- .shop-page-wrapper -->

<?php
get_footer();