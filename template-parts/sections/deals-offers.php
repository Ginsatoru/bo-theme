<?php
/**
 * Deals and offers section with Scroll Animations
 *
 * @package AAAPOS
 */

// Don't display if not on front page OR if section is disabled
if (!is_front_page() || !get_theme_mod("show_deals", true)) {
    return;
}

// Get customizer settings
$title = get_theme_mod("deals_title", "Special Deals");
$description = get_theme_mod("deals_description", "");
$deal_end_date = get_theme_mod("deal_end_date", "");
$selection_method = get_theme_mod("deal_selection_method", "manual");

// Initialize product variable
$deal_product = null;

// Get product based on selection method
switch ($selection_method) {
    case "manual":
        // Manual selection by Product ID
        $deal_product_id = get_theme_mod("deal_product_id", 0);
        if (
            $deal_product_id &&
            is_numeric($deal_product_id) &&
            $deal_product_id > 0
        ) {
            $deal_product = wc_get_product($deal_product_id);
        }
        break;

    case "latest_sale":
        // Automatically get the latest product on sale
        $args = [
            "post_type" => "product",
            "posts_per_page" => 1,
            "post_status" => "publish",
            "meta_query" => [
                "relation" => "AND",
                [
                    "key" => "_sale_price",
                    "value" => "",
                    "compare" => "!=",
                ],
                [
                    "key" => "_stock_status",
                    "value" => "instock",
                ],
            ],
            "orderby" => "date",
            "order" => "DESC",
        ];
        $sale_query = new WP_Query($args);
        if ($sale_query->have_posts()) {
            $deal_product = wc_get_product($sale_query->posts[0]->ID);
        }
        wp_reset_postdata();
        break;

    case "featured_sale":
        // Get a featured product that's on sale
        $args = [
            "post_type" => "product",
            "posts_per_page" => 1,
            "post_status" => "publish",
            "tax_query" => [
                [
                    "taxonomy" => "product_visibility",
                    "field" => "name",
                    "terms" => "featured",
                ],
            ],
            "meta_query" => [
                "relation" => "AND",
                [
                    "key" => "_sale_price",
                    "value" => "",
                    "compare" => "!=",
                ],
                [
                    "key" => "_stock_status",
                    "value" => "instock",
                ],
            ],
            "orderby" => "date",
            "order" => "DESC",
        ];
        $featured_query = new WP_Query($args);
        if ($featured_query->have_posts()) {
            $deal_product = wc_get_product($featured_query->posts[0]->ID);
        }
        wp_reset_postdata();
        break;
}

// Check if we have a valid, visible product
$has_valid_deal =
    $deal_product &&
    is_a($deal_product, "WC_Product") &&
    $deal_product->is_visible() &&
    $deal_product->is_in_stock();
?>

<section class="deals-offers section bg-light">
    <div class="container">
        <!-- Section Header with Animation -->
        <div class="section-header" 
             data-animate="fade-up" 
             data-animate-delay="100">
            <h2 class="section-title"><?php echo esc_html($title); ?></h2>
            <?php if (!empty($description)): ?>
                <p class="section-description"><?php echo esc_html(
                    $description,
                ); ?></p>
            <?php endif; ?>
        </div>

        <?php if ($has_valid_deal): ?>
            <div class="deal-content">
                <!-- Deal Image with Animation -->
                <div class="deal-image" 
                     data-animate="fade-right" 
                     data-animate-delay="200">
                    <?php if ($deal_product->get_image_id()) {
                        echo $deal_product->get_image("large");
                    } else {
                        echo wc_placeholder_img("large");
                    } ?>
                    
                    <?php if ($deal_product->is_on_sale()): ?>
                        <span class="deal-badge">
                            <?php
                            $percentage = "";
                            if (
                                $deal_product->get_regular_price() &&
                                $deal_product->get_sale_price()
                            ) {
                                $percentage = round(
                                    (($deal_product->get_regular_price() -
                                        $deal_product->get_sale_price()) /
                                        $deal_product->get_regular_price()) *
                                        100,
                                );
                                echo sprintf(
                                    esc_html__("Save %s%%", "AAAPOS"),
                                    $percentage,
                                );
                            } else {
                                esc_html_e("Sale!", "AAAPOS");
                            }
                            ?>
                        </span>
                    <?php endif; ?>
                </div>
                
                <!-- Deal Details with Staggered Animation -->
                <div class="deal-details">
                    <h3 class="deal-title" 
                        data-animate="fade-left" 
                        data-animate-delay="300">
                        <?php echo esc_html($deal_product->get_name()); ?>
                    </h3>
                    
                    <?php if ($deal_product->get_rating_count() > 0): ?>
                        <div class="deal-rating" 
                             data-animate="fade-left" 
                             data-animate-delay="350">
                            <?php echo wc_get_rating_html(
                                $deal_product->get_average_rating(),
                            ); ?>
                            <span class="rating-count">
                                <?php printf(
                                    esc_html(
                                        _n(
                                            "%s review",
                                            "%s reviews",
                                            $deal_product->get_rating_count(),
                                            "AAAPOS",
                                        ),
                                    ),
                                    number_format_i18n(
                                        $deal_product->get_rating_count(),
                                    ),
                                ); ?>
                            </span>
                        </div>
                    <?php endif; ?>
                    
                    <div class="deal-price" 
                         data-animate="fade-left" 
                         data-animate-delay="400">
                        <?php if ($deal_product->is_on_sale()): ?>
                            <span class="sale-price"><?php echo wc_price(
                                $deal_product->get_sale_price(),
                            ); ?></span>
                            <span class="regular-price"><?php echo wc_price(
                                $deal_product->get_regular_price(),
                            ); ?></span>
                            <?php
                            $saved =
                                $deal_product->get_regular_price() -
                                $deal_product->get_sale_price();
                            if ($saved > 0): ?>
                                <span class="you-save">
                                    <?php printf(
                                        esc_html__(
                                            "You save: %s",
                                            "AAAPOS",
                                        ),
                                        wc_price($saved),
                                    ); ?>
                                </span>
                            <?php endif;
                            ?>
                        <?php else: ?>
                            <span class="current-price"><?php echo $deal_product->get_price_html(); ?></span>
                        <?php endif; ?>
                    </div>
                    
                    <?php if ($deal_product->get_short_description()): ?>
                        <div class="deal-description" 
                             data-animate="fade-left" 
                             data-animate-delay="450">
                            <?php echo wp_kses_post(
                                wpautop($deal_product->get_short_description()),
                            ); ?>
                        </div>
                    <?php endif; ?>

                    <?php
                    // Display stock status
                    $stock_status = $deal_product->get_stock_status();
                    $stock_quantity = $deal_product->get_stock_quantity();
                    ?>
                    <div class="deal-stock" 
                         data-animate="fade-left" 
                         data-animate-delay="500">
                        <?php if ($stock_status === "instock"): ?>
                            <?php if (
                                $stock_quantity &&
                                $stock_quantity <= 10
                            ): ?>
                                <span class="stock-low">
                                    <?php printf(
                                        esc_html__(
                                            "Only %s left in stock!",
                                            "AAAPOS",
                                        ),
                                        $stock_quantity,
                                    ); ?>
                                </span>
                            <?php else: ?>
                                <span class="stock-available">
                                    <?php esc_html_e(
                                        "In Stock",
                                        "AAAPOS",
                                    ); ?>
                                </span>
                            <?php endif; ?>
                        <?php elseif ($stock_status === "onbackorder"): ?>
                            <span class="stock-backorder">
                                <?php esc_html_e(
                                    "Available on backorder",
                                    "AAAPOS",
                                ); ?>
                            </span>
                        <?php endif; ?>
                    </div>

                    <?php if (!empty($deal_end_date)): ?>
                        <div class="deal-countdown" 
                             data-animate="zoom-in" 
                             data-animate-delay="550">
                            <h4><?php esc_html_e(
                                "Offer ends in:",
                                "AAAPOS",
                            ); ?></h4>
                            <div class="countdown-timer" data-end-date="<?php echo esc_attr(
                                $deal_end_date,
                            ); ?>">
                                <div class="countdown-item">
                                    <span class="countdown-value days">00</span>
                                    <span class="countdown-label"><?php esc_html_e(
                                        "Days",
                                        "AAAPOS",
                                    ); ?></span>
                                </div>
                                <div class="countdown-item">
                                    <span class="countdown-value hours">00</span>
                                    <span class="countdown-label"><?php esc_html_e(
                                        "Hours",
                                        "AAAPOS",
                                    ); ?></span>
                                </div>
                                <div class="countdown-item">
                                    <span class="countdown-value minutes">00</span>
                                    <span class="countdown-label"><?php esc_html_e(
                                        "Minutes",
                                        "AAAPOS",
                                    ); ?></span>
                                </div>
                                <div class="countdown-item">
                                    <span class="countdown-value seconds">00</span>
                                    <span class="countdown-label"><?php esc_html_e(
                                        "Seconds",
                                        "AAAPOS",
                                    ); ?></span>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <div class="deal-actions" 
                         data-animate="fade-up" 
                         data-animate-delay="600">
                        <?php if (
                            $deal_product->is_purchasable() &&
                            $deal_product->is_in_stock()
                        ): ?>
                            <a href="<?php echo esc_url(
                                $deal_product->add_to_cart_url(),
                            ); ?>" 
                               class="btn btn--primary btn--lg add-to-cart-btn"
                               data-product-id="<?php echo esc_attr(
                                   $deal_product->get_id(),
                               ); ?>"
                               data-product-name="<?php echo esc_attr(
                                   $deal_product->get_name(),
                               ); ?>">
                                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                                </svg>
                                <?php esc_html_e(
                                    "Add to Cart",
                                    "AAAPOS",
                                ); ?>
                            </a>
                        <?php endif; ?>
                        
                        <a href="<?php echo esc_url(
                            $deal_product->get_permalink(),
                        ); ?>" class="btn btn--outline">
                            <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            <?php esc_html_e(
                                "View Details",
                                "AAAPOS",
                            ); ?>
                        </a>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="no-deals" 
                 data-animate="fade-up" 
                 data-animate-delay="200">
                <svg width="64" height="64" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="margin: 0 auto var(--space-4);">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <h3><?php esc_html_e(
                    "No Special Deals Available",
                    "AAAPOS",
                ); ?></h3>
                <p><?php esc_html_e(
                    "Check back soon for amazing deals and special offers!",
                    "AAAPOS",
                ); ?></p>
                <a href="<?php echo esc_url(
                    wc_get_page_permalink("shop"),
                ); ?>" class="btn btn--primary" style="margin-top: var(--space-4);">
                    <?php esc_html_e(
                        "Browse All Products",
                        "AAAPOS",
                    ); ?>
                </a>
            </div>
        <?php endif; ?>
    </div>
</section>