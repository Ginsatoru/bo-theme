<?php
/**
 * The Template for displaying product archives, including the main shop page
 * 
 * Modern 3-column grid layout with optional sidebar
 * Clean, Apple-style design with full-width product grid
 *
 * @package Macedon_Ranges
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header('shop');
?>

<div class="shop-page-wrapper">
    <div class="container-wide">
        
        <?php
        /**
         * Hook: woocommerce_before_main_content
         */
        do_action('woocommerce_before_main_content');
        ?>
        
        <div class="shop-layout <?php echo is_active_sidebar('shop-sidebar') ? 'has-sidebar' : 'full-width'; ?>">
            
            <!-- Shop Sidebar (Optional) -->
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
                     * 
                     * @hooked woocommerce_taxonomy_archive_description - 10
                     * @hooked woocommerce_product_archive_description - 10
                     */
                    do_action('woocommerce_archive_description');
                    ?>
                </header>

                <?php
                if (woocommerce_product_loop()) {
                    
                    /**
                     * Hook: woocommerce_before_shop_loop
                     * 
                     * @hooked woocommerce_output_all_notices - 10
                     * @hooked woocommerce_result_count - 20
                     * @hooked woocommerce_catalog_ordering - 30
                     */
                    ?>
                    <div class="shop-toolbar">
                        <?php do_action('woocommerce_before_shop_loop'); ?>
                    </div>
                    <?php

                    // Start products grid - Using custom wrapper for 3-column grid
                    echo '<div class="products-grid products-grid--three-col">';

                    if (wc_get_loop_prop('total')) {
                        while (have_posts()) {
                            the_post();

                            /**
                             * Hook: woocommerce_shop_loop
                             */
                            do_action('woocommerce_shop_loop');

                            // Load custom product card component
                            wc_get_template_part('components/product', 'card');
                        }
                    }

                    echo '</div>'; // Close products-grid

                    /**
                     * Hook: woocommerce_after_shop_loop
                     * 
                     * @hooked woocommerce_pagination - 10
                     */
                    do_action('woocommerce_after_shop_loop');
                    
                } else {
                    
                    /**
                     * Hook: woocommerce_no_products_found
                     * 
                     * @hooked wc_no_products_found - 10
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
        
    </div><!-- .container-wide -->
</div><!-- .shop-page-wrapper -->

<?php
get_footer();