/**
 * WooCommerce Enhanced Functionality
 * woocommerce.js
 * 
 * @package Macedon_Ranges
 */

(function($) {
    'use strict';

    /**
     * WooCommerce Enhancements
     */
    class MRWooCommerce {
        constructor() {
            this.init();
        }

        init() {
            this.initQuickView();
            this.initProductFilters();
            this.initQuantityButtons();
            this.initProductGallery();
            this.initWishlist();
            this.initCompare();
            this.initAjaxAddToCart();
            this.initCartDrawer();
            this.initProductTabs();
            this.initColorSwatches();
        }

        /**
         * Quick View Modal
         */
        initQuickView() {
            $(document).on('click', '.quick-view-btn', function(e) {
                e.preventDefault();
                const productId = $(this).data('product-id');
                
                if (!productId) return;

                // Show loading state
                const $btn = $(this);
                const originalText = $btn.text();
                $btn.text('Loading...').prop('disabled', true);

                // AJAX request for product quick view
                $.ajax({
                    url: mr_ajax.ajax_url,
                    type: 'POST',
                    data: {
                        action: 'mr_quick_view',
                        product_id: productId,
                        nonce: mr_ajax.nonce
                    },
                    success: function(response) {
                        if (response.success) {
                            // Create and show modal
                            const modal = $('<div class="quick-view-modal">' + response.data.html + '</div>');
                            $('body').append(modal);
                            
                            // Trigger WooCommerce product gallery
                            modal.find('.woocommerce-product-gallery').wc_product_gallery();
                            
                            // Show modal with animation
                            setTimeout(() => modal.addClass('visible'), 10);
                            
                            // Close handlers
                            modal.on('click', '.quick-view-close, .quick-view-overlay', function() {
                                modal.removeClass('visible');
                                setTimeout(() => modal.remove(), 300);
                            });
                        }
                    },
                    error: function() {
                        if (window.MRAnimations) {
                            window.MRAnimations.showNotification('Failed to load product', 'error');
                        }
                    },
                    complete: function() {
                        $btn.text(originalText).prop('disabled', false);
                    }
                });
            });
        }

        /**
         * Product Filters
         */
        initProductFilters() {
            const $filters = $('.product-filters');
            if (!$filters.length) return;

            // Price range filter
            const $priceSlider = $filters.find('.price-slider');
            if ($priceSlider.length && $.fn.slider) {
                const min = parseInt($priceSlider.data('min')) || 0;
                const max = parseInt($priceSlider.data('max')) || 1000;

                $priceSlider.slider({
                    range: true,
                    min: min,
                    max: max,
                    values: [min, max],
                    slide: function(event, ui) {
                        $('.price-range-display').text(`$${ui.values[0]} - $${ui.values[1]}`);
                    }
                });
            }

            // Filter submission
            $filters.on('submit', 'form', function(e) {
                e.preventDefault();
                const formData = $(this).serialize();
                
                // Show loading state
                $('.products').addClass('loading');
                
                // AJAX filter request
                $.ajax({
                    url: mr_ajax.ajax_url,
                    type: 'POST',
                    data: formData + '&action=mr_filter_products',
                    success: function(response) {
                        if (response.success) {
                            $('.products').html(response.data.html);
                            
                            // Update URL without reload
                            if (history.pushState) {
                                history.pushState(null, null, '?' + formData);
                            }
                        }
                    },
                    complete: function() {
                        $('.products').removeClass('loading');
                    }
                });
            });

            // Clear filters
            $filters.on('click', '.clear-filters', function(e) {
                e.preventDefault();
                $filters.find('form')[0].reset();
                $filters.find('form').submit();
            });
        }

        /**
         * Quantity Increment/Decrement Buttons
         */
        initQuantityButtons() {
            $(document).on('click', '.quantity-btn', function(e) {
                e.preventDefault();
                
                const $btn = $(this);
                const $input = $btn.siblings('.qty');
                const currentVal = parseInt($input.val()) || 0;
                const min = parseInt($input.attr('min')) || 1;
                const max = parseInt($input.attr('max')) || 999;
                
                let newVal = currentVal;
                
                if ($btn.hasClass('quantity-plus')) {
                    newVal = currentVal < max ? currentVal + 1 : max;
                } else if ($btn.hasClass('quantity-minus')) {
                    newVal = currentVal > min ? currentVal - 1 : min;
                }
                
                $input.val(newVal).trigger('change');
            });
        }

        /**
         * Enhanced Product Gallery
         */
        initProductGallery() {
            const $gallery = $('.woocommerce-product-gallery');
            if (!$gallery.length) return;

            // Add zoom effect on hover (if not on mobile)
            if (window.innerWidth > 768) {
                $gallery.on('mouseenter', '.woocommerce-product-gallery__image', function() {
                    $(this).addClass('zoom-active');
                }).on('mouseleave', '.woocommerce-product-gallery__image', function() {
                    $(this).removeClass('zoom-active');
                });
            }

            // Thumbnail navigation
            $gallery.on('click', '.flex-control-thumbs img', function() {
                const index = $(this).parent().index();
                $gallery.find('.flex-viewport img').eq(index).trigger('click');
            });
        }

        /**
         * Wishlist Functionality
         */
        initWishlist() {
            $(document).on('click', '.add-to-wishlist', function(e) {
                e.preventDefault();
                
                const $btn = $(this);
                const productId = $btn.data('product-id');
                
                $btn.addClass('loading');

                $.ajax({
                    url: mr_ajax.ajax_url,
                    type: 'POST',
                    data: {
                        action: 'mr_toggle_wishlist',
                        product_id: productId,
                        nonce: mr_ajax.nonce
                    },
                    success: function(response) {
                        if (response.success) {
                            $btn.toggleClass('in-wishlist');
                            
                            if (window.MRAnimations) {
                                window.MRAnimations.showNotification(response.data.message, 'success');
                            }
                            
                            // Update wishlist count
                            $('.wishlist-count').text(response.data.count);
                        }
                    },
                    complete: function() {
                        $btn.removeClass('loading');
                    }
                });
            });
        }

        /**
         * Product Compare
         */
        initCompare() {
            $(document).on('click', '.add-to-compare', function(e) {
                e.preventDefault();
                
                const $btn = $(this);
                const productId = $btn.data('product-id');
                
                $.ajax({
                    url: mr_ajax.ajax_url,
                    type: 'POST',
                    data: {
                        action: 'mr_toggle_compare',
                        product_id: productId,
                        nonce: mr_ajax.nonce
                    },
                    success: function(response) {
                        if (response.success) {
                            $btn.toggleClass('in-compare');
                            
                            if (window.MRAnimations) {
                                window.MRAnimations.showNotification(response.data.message, 'success');
                            }
                            
                            // Update compare count
                            $('.compare-count').text(response.data.count);
                        }
                    }
                });
            });
        }

        /**
         * AJAX Add to Cart
         */
        initAjaxAddToCart() {
            $(document).on('click', '.ajax-add-to-cart', function(e) {
                e.preventDefault();
                
                const $btn = $(this);
                const productId = $btn.data('product-id');
                const quantity = $btn.data('quantity') || 1;
                
                $btn.addClass('loading');

                $.ajax({
                    url: mr_ajax.wc_ajax_url.replace('%%endpoint%%', 'add_to_cart'),
                    type: 'POST',
                    data: {
                        product_id: productId,
                        quantity: quantity
                    },
                    success: function(response) {
                        if (response.error) {
                            if (window.MRAnimations) {
                                window.MRAnimations.showNotification(response.error_message, 'error');
                            }
                        } else {
                            // Update cart fragments
                            $(document.body).trigger('added_to_cart', [response.fragments, response.cart_hash, $btn]);
                            
                            if (window.MRAnimations) {
                                window.MRAnimations.showNotification('Product added to cart!', 'success');
                            }
                        }
                    },
                    complete: function() {
                        $btn.removeClass('loading');
                    }
                });
            });
        }

        /**
         * Cart Drawer/Sidebar
         */
        initCartDrawer() {
            // Open cart drawer
            $(document).on('click', '.cart-trigger', function(e) {
                e.preventDefault();
                $('.cart-drawer').addClass('open');
                $('body').addClass('cart-drawer-open');
            });

            // Close cart drawer
            $(document).on('click', '.cart-drawer__close, .cart-drawer__overlay', function() {
                $('.cart-drawer').removeClass('open');
                $('body').removeClass('cart-drawer-open');
            });

            // Update cart on fragment refresh
            $(document.body).on('wc_fragments_refreshed', function() {
                // Cart has been updated
                console.log('Cart fragments refreshed');
            });
        }

        /**
         * Product Tabs Enhancement
         */
        initProductTabs() {
            const $tabs = $('.woocommerce-tabs');
            if (!$tabs.length) return;

            $tabs.find('.tabs li a').on('click', function(e) {
                e.preventDefault();
                
                const $this = $(this);
                const target = $this.attr('href');
                
                // Update active states
                $this.closest('li').addClass('active').siblings().removeClass('active');
                
                // Show target panel
                $(target).show().addClass('active').siblings('.woocommerce-Tabs-panel').hide().removeClass('active');
                
                // Smooth scroll to tabs on mobile
                if (window.innerWidth < 768) {
                    $('html, body').animate({
                        scrollTop: $tabs.offset().top - 100
                    }, 300);
                }
            });
        }

        /**
         * Color/Attribute Swatches
         */
        initColorSwatches() {
            $(document).on('click', '.variation-swatch', function(e) {
                e.preventDefault();
                
                const $swatch = $(this);
                const value = $swatch.data('value');
                const $select = $swatch.closest('.variations').find('select');
                
                // Update select value
                $select.val(value).trigger('change');
                
                // Update active state
                $swatch.addClass('selected').siblings().removeClass('selected');
            });
        }
    }

    // Initialize WooCommerce enhancements
    $(function() {
        new MRWooCommerce();
    });

})(jQuery);