<?php
/**
 * Product card component - FIXED VERSION
 * 
 * Changes:
 * - Added proper WooCommerce AJAX classes and data attributes
 * - Fixed button markup for cart functionality
 * - Improved accessibility and structure
 */
if (!defined('ABSPATH')) {
    exit;
}

global $product;

// Ensure visibility
if (empty($product) || !$product->is_visible()) {
    return;
}
?>
<div <?php wc_product_class('product-card', $product); ?>>
    <div class="product-card__image">
        <?php
        $link = apply_filters('woocommerce_loop_product_link', get_the_permalink(), $product);
        ?>
        <a href="<?php echo esc_url($link); ?>">
            <?php echo $product->get_image('mr-product-card'); ?>
        </a>

        <?php if ($product->is_on_sale() && get_theme_mod('show_sale_badges', true)) : ?>
            <span class="product-card__badge"><?php esc_html_e('Sale', 'macedon-ranges'); ?></span>
        <?php endif; ?>

        <?php if (get_theme_mod('show_quick_view', true)) : ?>
            <div class="product-card__actions">
                <button type="button" class="product-card__action quick-view-btn" data-product-id="<?php echo esc_attr($product->get_id()); ?>" aria-label="<?php esc_attr_e('Quick View', 'macedon-ranges'); ?>">
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor">
                        <path d="M10.5 8a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                        <path fill-rule="evenodd" d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 100-7 3.5 3.5 0 000 7z" clip-rule="evenodd"/>
                    </svg>
                </button>
            </div>
        <?php endif; ?>
    </div>

    <div class="product-card__content">
        <h3 class="product-card__title">
            <a href="<?php echo esc_url($link); ?>"><?php echo esc_html($product->get_name()); ?></a>
        </h3>

        <div class="product-card__rating">
            <?php if ($product->get_rating_count() > 0) : ?>
                <div class="product-card__stars">
                    <?php echo wc_get_rating_html($product->get_average_rating()); ?>
                </div>
                <span class="product-card__review-count">(<?php echo esc_html($product->get_review_count()); ?>)</span>
            <?php else : ?>
                <span class="no-reviews"><?php esc_html_e('No reviews yet', 'macedon-ranges'); ?></span>
            <?php endif; ?>
        </div>

        <div class="product-card__price">
            <?php echo $product->get_price_html(); ?>
        </div>

        <div class="product-card__add-to-cart">
            <?php
            // ✅ FIXED: Properly formatted Add to Cart button with ALL required attributes
            $button_classes = array(
                'button',
                'product_type_' . $product->get_type(),
                'add_to_cart_button'
            );

            // Add AJAX class for simple products
            if ($product->is_purchasable() && $product->is_in_stock() && $product->get_type() === 'simple') {
                $button_classes[] = 'ajax_add_to_cart';
            }

            echo apply_filters(
                'woocommerce_loop_add_to_cart_link',
                sprintf(
                    '<a href="%s" data-quantity="%s" class="%s" %s %s %s>%s</a>',
                    esc_url($product->add_to_cart_url()),
                    esc_attr(isset($args['quantity']) ? $args['quantity'] : 1),
                    esc_attr(implode(' ', $button_classes)),
                    // ✅ CRITICAL FIX: Add required data attributes
                    'data-product_id="' . esc_attr($product->get_id()) . '"',
                    'data-product_sku="' . esc_attr($product->get_sku()) . '"',
                    'aria-label="' . esc_attr($product->add_to_cart_description()) . '"',
                    esc_html($product->add_to_cart_text())
                ),
                $product,
                $args ?? array()
            );
            ?>
        </div>
    </div>
</div>