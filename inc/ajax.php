<?php
/**
 * AJAX handlers
 */

// Quick view AJAX handler
function mr_quick_view_ajax() {
    // Verify nonce
    if (!isset($_GET['nonce']) || !wp_verify_nonce($_GET['nonce'], 'mr_nonce')) {
        wp_die('Invalid nonce');
    }
    
    $product_id = intval($_GET['product_id']);
    $product = wc_get_product($product_id);
    
    if (!$product) {
        wp_send_json_error('Product not found');
    }
    
    // Set up product data
    $product_data = array(
        'id' => $product->get_id(),
        'name' => $product->get_name(),
        'price' => $product->get_price_html(),
        'short_description' => apply_filters('the_content', $product->get_short_description()),
        'image' => $product->get_image('large'),
        'add_to_cart_url' => $product->add_to_cart_url(),
        'product_url' => $product->get_permalink(),
        'is_purchasable' => $product->is_purchasable(),
        'is_in_stock' => $product->is_in_stock(),
        'type' => $product->get_type(),
    );
    
    ob_start();
    ?>
    <div class="quick-view-content">
        <button class="quick-view-close" aria-label="Close quick view">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/>
            </svg>
        </button>
        
        <div class="quick-view-product">
            <div class="product-images">
                <?php echo $product_data['image']; ?>
            </div>
            
            <div class="product-summary">
                <h2><?php echo esc_html($product_data['name']); ?></h2>
                
                <div class="price">
                    <?php echo $product_data['price']; ?>
                </div>
                
                <div class="description">
                    <?php echo $product_data['short_description']; ?>
                </div>
                
                <div class="add-to-cart">
                    <?php if ($product_data['is_purchasable'] && $product_data['is_in_stock']) : ?>
                        <?php if ($product_data['type'] === 'simple') : ?>
                            <form class="cart" method="post" enctype="multipart/form-data">
                                <?php
                                woocommerce_quantity_input(array(
                                    'min_value' => 1,
                                    'max_value' => $product->get_max_purchase_quantity(),
                                    'input_value' => 1,
                                ), $product);
                                ?>
                                <button type="submit" name="add-to-cart" value="<?php echo esc_attr($product_data['id']); ?>" class="single_add_to_cart_button button alt">
                                    <?php echo esc_html($product->single_add_to_cart_text()); ?>
                                </button>
                            </form>
                        <?php else : ?>
                            <a href="<?php echo esc_url($product_data['product_url']); ?>" class="button view-product">
                                <?php esc_html_e('View Product', 'macedon-ranges'); ?>
                            </a>
                        <?php endif; ?>
                    <?php else : ?>
                        <p class="stock out-of-stock"><?php esc_html_e('This product is currently unavailable.', 'macedon-ranges'); ?></p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <?php
    $content = ob_get_clean();
    
    wp_send_json_success($content);
}
add_action('wp_ajax_mr_quick_view', 'mr_quick_view_ajax');
add_action('wp_ajax_nopriv_mr_quick_view', 'mr_quick_view_ajax');

// Newsletter subscription
function mr_newsletter_subscribe() {
    // Verify nonce
    if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'mr_nonce')) {
        wp_send_json_error('Invalid nonce');
    }
    
    $email = sanitize_email($_POST['email']);
    $gdpr = isset($_POST['gdpr']) ? true : false;
    
    if (!is_email($email)) {
        wp_send_json_error('Please enter a valid email address.');
    }
    
    if (!$gdpr && get_theme_mod('newsletter_gdpr', true)) {
        wp_send_json_error('Please accept the terms and conditions.');
    }
    
    // Here you would typically integrate with a newsletter service
    // For now, we'll just return success
    wp_send_json_success('Thank you for subscribing!');
}
add_action('wp_ajax_mr_newsletter_subscribe', 'mr_newsletter_subscribe');
add_action('wp_ajax_nopriv_mr_newsletter_subscribe', 'mr_newsletter_subscribe');

// Product search AJAX
function mr_product_search() {
    $search_term = isset($_GET['s']) ? sanitize_text_field($_GET['s']) : '';
    
    $args = array(
        'post_type' => 'product',
        'posts_per_page' => 8,
        's' => $search_term,
        'post_status' => 'publish',
    );
    
    $search_query = new WP_Query($args);
    
    ob_start();
    
    if ($search_query->have_posts()) {
        echo '<div class="search-results">';
        while ($search_query->have_posts()) {
            $search_query->the_post();
            global $product;
            ?>
            <div class="search-result-item">
                <a href="<?php the_permalink(); ?>" class="search-result-link">
                    <div class="search-result-image">
                        <?php echo $product->get_image('thumbnail'); ?>
                    </div>
                    <div class="search-result-content">
                        <h4><?php the_title(); ?></h4>
                        <div class="price"><?php echo $product->get_price_html(); ?></div>
                    </div>
                </a>
            </div>
            <?php
        }
        echo '</div>';
    } else {
        echo '<p class="no-results">' . esc_html__('No products found.', 'macedon-ranges') . '</p>';
    }
    
    wp_reset_postdata();
    
    $results = ob_get_clean();
    wp_send_json_success($results);
}
add_action('wp_ajax_mr_product_search', 'mr_product_search');
add_action('wp_ajax_nopriv_mr_product_search', 'mr_product_search');

// ============================================================================
// CART DROPDOWN AJAX HANDLERS
// ============================================================================

/**
 * AJAX Handler: Remove item from cart
 */
function mr_ajax_remove_cart_item() {
    // Verify nonce - accept both nonce names for compatibility
    $nonce = isset($_POST['nonce']) ? $_POST['nonce'] : '';
    $nonce_valid = wp_verify_nonce($nonce, 'mr_cart_nonce') || wp_verify_nonce($nonce, 'mr_nonce');
    
    if (!$nonce_valid) {
        wp_send_json_error(array(
            'message' => __('Security check failed', 'macedon-ranges')
        ));
    }
    
    // Check if WooCommerce is active
    if (!class_exists('WooCommerce')) {
        wp_send_json_error(array(
            'message' => __('WooCommerce is not active', 'macedon-ranges')
        ));
    }
    
    // Get cart item key
    $cart_item_key = isset($_POST['cart_item_key']) ? sanitize_text_field($_POST['cart_item_key']) : '';
    
    if (empty($cart_item_key)) {
        wp_send_json_error(array(
            'message' => __('Invalid cart item', 'macedon-ranges')
        ));
    }
    
    // Remove item from cart
    $removed = WC()->cart->remove_cart_item($cart_item_key);
    
    if ($removed) {
        // Calculate new totals
        WC()->cart->calculate_totals();
        
        // Get updated fragments
        $fragments = apply_filters('woocommerce_add_to_cart_fragments', array());
        
        wp_send_json_success(array(
            'message'       => __('Item removed from cart', 'macedon-ranges'),
            'cart_count'    => WC()->cart->get_cart_contents_count(),
            'cart_subtotal' => WC()->cart->get_cart_subtotal(),
            'cart_total'    => WC()->cart->get_total(),
            'fragments'     => $fragments
        ));
    } else {
        wp_send_json_error(array(
            'message' => __('Failed to remove item from cart', 'macedon-ranges')
        ));
    }
}

// Register AJAX actions for both logged in and logged out users
add_action('wp_ajax_remove_cart_item', 'mr_ajax_remove_cart_item');
add_action('wp_ajax_nopriv_remove_cart_item', 'mr_ajax_remove_cart_item');

/**
 * AJAX Handler: Update cart item quantity
 */
function mr_ajax_update_cart_quantity() {
    // Verify nonce - accept both nonce names for compatibility
    $nonce = isset($_POST['nonce']) ? $_POST['nonce'] : '';
    $nonce_valid = wp_verify_nonce($nonce, 'mr_cart_nonce') || wp_verify_nonce($nonce, 'mr_nonce');
    
    if (!$nonce_valid) {
        wp_send_json_error(array(
            'message' => __('Security check failed', 'macedon-ranges')
        ));
    }
    
    // Check if WooCommerce is active
    if (!class_exists('WooCommerce')) {
        wp_send_json_error(array(
            'message' => __('WooCommerce is not active', 'macedon-ranges')
        ));
    }
    
    $cart_item_key = isset($_POST['cart_item_key']) ? sanitize_text_field($_POST['cart_item_key']) : '';
    $quantity = isset($_POST['quantity']) ? absint($_POST['quantity']) : 1;
    
    if (empty($cart_item_key)) {
        wp_send_json_error(array(
            'message' => __('Invalid cart item', 'macedon-ranges')
        ));
    }
    
    // Update quantity
    $updated = WC()->cart->set_quantity($cart_item_key, $quantity);
    
    if ($updated) {
        WC()->cart->calculate_totals();
        
        // Get updated fragments
        $fragments = apply_filters('woocommerce_add_to_cart_fragments', array());
        
        wp_send_json_success(array(
            'message'       => __('Cart updated', 'macedon-ranges'),
            'cart_count'    => WC()->cart->get_cart_contents_count(),
            'cart_subtotal' => WC()->cart->get_cart_subtotal(),
            'cart_total'    => WC()->cart->get_total(),
            'fragments'     => $fragments
        ));
    } else {
        wp_send_json_error(array(
            'message' => __('Failed to update cart', 'macedon-ranges')
        ));
    }
}

add_action('wp_ajax_update_cart_quantity', 'mr_ajax_update_cart_quantity');
add_action('wp_ajax_nopriv_update_cart_quantity', 'mr_ajax_update_cart_quantity');

/**
 * Refresh cart fragments on add to cart (WooCommerce hook)
 */
function mr_refresh_cart_fragments($fragments) {
    $cart_count = WC()->cart->get_cart_contents_count();
    
    // Cart count fragment - always return the element (shown/hidden via CSS or JS)
    ob_start();
    ?>
    <span class="cart-count"<?php echo $cart_count === 0 ? ' style="display:none;"' : ''; ?>><?php echo esc_html($cart_count); ?></span>
    <?php
    $fragments['.cart-count'] = ob_get_clean();
    
    // Cart dropdown header count
    ob_start();
    ?>
    <span class="cart-item-count"><?php echo esc_html($cart_count); ?> <?php echo $cart_count === 1 ? esc_html__('item', 'macedon-ranges') : esc_html__('items', 'macedon-ranges'); ?></span>
    <?php
    $fragments['.cart-item-count'] = ob_get_clean();
    
    // Cart subtotal fragment
    ob_start();
    ?>
    <strong class="cart-subtotal-amount"><?php echo WC()->cart->get_cart_subtotal(); ?></strong>
    <?php
    $fragments['.cart-subtotal-amount'] = ob_get_clean();
    
    // Full cart dropdown fragment for complete refresh
    // Return only the inner HTML, not wrapped in UL
    ob_start();
    mr_render_cart_dropdown_items();
    $fragments['.cart-dropdown-items'] = ob_get_clean();
    
    return $fragments;
}
add_filter('woocommerce_add_to_cart_fragments', 'mr_refresh_cart_fragments');

/**
 * Render cart dropdown items (reusable function)
 * NOTE: This returns only the <li> items, NOT wrapped in <ul>
 */
function mr_render_cart_dropdown_items($max_items = 99) {
    $cart_count = WC()->cart->get_cart_contents_count();
    
    if ($cart_count > 0) :
        $cart_items = WC()->cart->get_cart();
        $item_count = 0;
        foreach ($cart_items as $cart_item_key => $cart_item) :
            if ($item_count >= $max_items) break;
            $_product = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
            if ($_product && $_product->exists() && $cart_item['quantity'] > 0) :
    ?>
<li class="cart-dropdown-item" data-cart-key="<?php echo esc_attr($cart_item_key); ?>">
    <a href="<?php echo esc_url($_product->get_permalink($cart_item)); ?>" class="cart-item-image">
        <?php echo wp_kses_post($_product->get_image('thumbnail')); ?>
    </a>
    <div class="cart-item-details">
        <a href="<?php echo esc_url($_product->get_permalink($cart_item)); ?>" class="cart-item-name">
            <?php echo wp_kses_post($_product->get_name()); ?>
        </a>
        <div class="cart-item-meta">
            <span class="cart-item-quantity"><?php echo esc_html($cart_item['quantity']); ?> × </span>
            <span class="cart-item-price"><?php echo WC()->cart->get_product_price($_product); ?></span>
        </div>
    </div>
    <button type="button" class="cart-item-remove" data-cart-item-key="<?php echo esc_attr($cart_item_key); ?>" aria-label="<?php esc_attr_e('Remove item', 'macedon-ranges'); ?>">
        <svg width="14" height="14" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
        </svg>
    </button>
</li>
    <?php 
            $item_count++;
            endif;
        endforeach;
    else :
    ?>
<li class="cart-dropdown-empty">
    <p><?php esc_html_e('Your cart is empty.', 'macedon-ranges'); ?></p>
</li>
    <?php
    endif;
}