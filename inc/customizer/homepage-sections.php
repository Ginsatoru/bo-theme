<?php
/**
 * Homepage sections customizer settings
 */
function mr_homepage_sections_customizer($wp_customize)
{
    // Homepage Sections
    $wp_customize->add_section("mr_homepage_sections", [
        "title" => __("Homepage Sections", "macedon-ranges"),
        "priority" => 45,
    ]);

    // ===================================
    // FEATURED PRODUCTS SECTION
    // ===================================

    $wp_customize->add_setting("show_featured_products", [
        "default" => true,
        "sanitize_callback" => "wp_validate_boolean",
        "transport" => "postMessage",
    ]);

    $wp_customize->add_control("show_featured_products", [
        "label" => __("Show Featured Products Section", "macedon-ranges"),
        "section" => "mr_homepage_sections",
        "type" => "checkbox",
        "priority" => 10,
    ]);

    $wp_customize->add_setting("featured_products_title", [
        "default" => "Featured Products",
        "sanitize_callback" => "sanitize_text_field",
        "transport" => "postMessage",
    ]);

    $wp_customize->add_control("featured_products_title", [
        "label" => __("Featured Products Title", "macedon-ranges"),
        "section" => "mr_homepage_sections",
        "type" => "text",
        "priority" => 20,
    ]);

    $wp_customize->add_setting("featured_products_description", [
        "default" => "",
        "sanitize_callback" => "sanitize_textarea_field",
        "transport" => "postMessage",
    ]);

    $wp_customize->add_control("featured_products_description", [
        "label" => __("Featured Products Description", "macedon-ranges"),
        "section" => "mr_homepage_sections",
        "type" => "textarea",
        "priority" => 25,
    ]);

    $wp_customize->add_setting("featured_products_count", [
        "default" => 8,
        "sanitize_callback" => "absint",
        "transport" => "postMessage",
    ]);

    $wp_customize->add_control("featured_products_count", [
        "label" => __("Number of Featured Products", "macedon-ranges"),
        "section" => "mr_homepage_sections",
        "type" => "number",
        "input_attrs" => [
            "min" => 1,
            "max" => 12,
            "step" => 1,
        ],
        "priority" => 30,
    ]);

    // Featured Products Colors
    $wp_customize->add_setting("featured_section_bg_color", [
        "default" => "#ffffff",
        "sanitize_callback" => "sanitize_hex_color",
        "transport" => "postMessage",
    ]);

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            "featured_section_bg_color",
            [
                "label" => __("Section Background Color", "macedon-ranges"),
                "section" => "mr_homepage_sections",
                "priority" => 31,
            ],
        ),
    );

    $wp_customize->add_setting("featured_title_color", [
        "default" => "#1f2937",
        "sanitize_callback" => "sanitize_hex_color",
        "transport" => "postMessage",
    ]);

    $wp_customize->add_control(
        new WP_Customize_Color_Control($wp_customize, "featured_title_color", [
            "label" => __("Title Color", "macedon-ranges"),
            "section" => "mr_homepage_sections",
            "priority" => 32,
        ]),
    );

    $wp_customize->add_setting("featured_card_bg_color", [
        "default" => "#ffffff",
        "sanitize_callback" => "sanitize_hex_color",
        "transport" => "postMessage",
    ]);

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            "featured_card_bg_color",
            [
                "label" => __("Product Card Background", "macedon-ranges"),
                "section" => "mr_homepage_sections",
                "priority" => 33,
            ],
        ),
    );

    $wp_customize->add_setting("featured_card_hover_color", [
        "default" => "#0ea5e9",
        "sanitize_callback" => "sanitize_hex_color",
        "transport" => "postMessage",
    ]);

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            "featured_card_hover_color",
            [
                "label" => __("Card Hover Accent Color", "macedon-ranges"),
                "section" => "mr_homepage_sections",
                "priority" => 34,
            ],
        ),
    );

    $wp_customize->add_setting("featured_price_color", [
        "default" => "#0ea5e9",
        "sanitize_callback" => "sanitize_hex_color",
        "transport" => "postMessage",
    ]);

    $wp_customize->add_control(
        new WP_Customize_Color_Control($wp_customize, "featured_price_color", [
            "label" => __("Price Color", "macedon-ranges"),
            "section" => "mr_homepage_sections",
            "priority" => 35,
        ]),
    );

    $wp_customize->add_setting("featured_button_bg_color", [
        "default" => "#0ea5e9",
        "sanitize_callback" => "sanitize_hex_color",
        "transport" => "postMessage",
    ]);

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            "featured_button_bg_color",
            [
                "label" => __(
                    "Add to Cart Button Background",
                    "macedon-ranges",
                ),
                "section" => "mr_homepage_sections",
                "priority" => 36,
            ],
        ),
    );

    $wp_customize->add_setting("featured_button_text_color", [
        "default" => "#ffffff",
        "sanitize_callback" => "sanitize_hex_color",
        "transport" => "postMessage",
    ]);

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            "featured_button_text_color",
            [
                "label" => __("Button Text Color", "macedon-ranges"),
                "section" => "mr_homepage_sections",
                "priority" => 37,
            ],
        ),
    );

    $wp_customize->add_setting("featured_sale_badge_color", [
        "default" => "#ef4444",
        "sanitize_callback" => "sanitize_hex_color",
        "transport" => "postMessage",
    ]);

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            "featured_sale_badge_color",
            [
                "label" => __("Sale Badge Color", "macedon-ranges"),
                "section" => "mr_homepage_sections",
                "priority" => 38,
            ],
        ),
    );

    // ===================================
    // PRODUCT CATEGORIES BY SLUG
    // ===================================

    $wp_customize->add_setting("show_categories", [
        "default" => true,
        "sanitize_callback" => "wp_validate_boolean",
        "transport" => "postMessage",
    ]);

    $wp_customize->add_control("show_categories", [
        "label" => __("Show Categories Section", "macedon-ranges"),
        "section" => "mr_homepage_sections",
        "type" => "checkbox",
        "priority" => 40,
    ]);

    $wp_customize->add_setting("categories_title", [
        "default" => "Shop by Category",
        "sanitize_callback" => "sanitize_text_field",
        "transport" => "postMessage",
    ]);

    $wp_customize->add_control("categories_title", [
        "label" => __("Categories Title", "macedon-ranges"),
        "section" => "mr_homepage_sections",
        "type" => "text",
        "priority" => 50,
    ]);

    $wp_customize->add_setting("categories_subtitle", [
        "default" =>
            "Quality feed and supplies for all your pets and livestock needs",
        "sanitize_callback" => "sanitize_text_field",
        "transport" => "postMessage",
    ]);

    $wp_customize->add_control("categories_subtitle", [
        "label" => __("Categories Subtitle", "macedon-ranges"),
        "section" => "mr_homepage_sections",
        "type" => "textarea",
        "priority" => 55,
    ]);

    // NEW: Category Slugs Input
    $wp_customize->add_setting("categories_slugs", [
        "default" => "",
        "sanitize_callback" => "sanitize_text_field",
        "transport" => "refresh",
    ]);

    $wp_customize->add_control("categories_slugs", [
        "label" => __("Category Slugs", "macedon-ranges"),
        "description" => __(
            "Enter category slugs separated by commas. Example: dog-food, cat-food, bird-supplies, horse-feed. Leave empty to show all categories.",
            "macedon-ranges",
        ),
        "section" => "mr_homepage_sections",
        "type" => "textarea",
        "priority" => 56,
    ]);

    // Fallback: Number of categories (used when slugs is empty)
    $wp_customize->add_setting("categories_count", [
        "default" => 6,
        "sanitize_callback" => "absint",
        "transport" => "refresh",
    ]);

    $wp_customize->add_control("categories_count", [
        "label" => __(
            "Number of Categories (if no slugs specified)",
            "macedon-ranges",
        ),
        "section" => "mr_homepage_sections",
        "type" => "number",
        "input_attrs" => [
            "min" => 3,
            "max" => 12,
            "step" => 1,
        ],
        "priority" => 57,
    ]);

    // ===================================
    // DEALS SECTION
    // ===================================

    $wp_customize->add_setting("show_deals", [
        "default" => true,
        "sanitize_callback" => "wp_validate_boolean",
        "transport" => "postMessage",
    ]);

    $wp_customize->add_control("show_deals", [
        "label" => __("Show Deals Section", "macedon-ranges"),
        "section" => "mr_homepage_sections",
        "type" => "checkbox",
        "priority" => 60,
    ]);

    $wp_customize->add_setting("deals_title", [
        "default" => "Special Deals",
        "sanitize_callback" => "sanitize_text_field",
        "transport" => "postMessage",
    ]);

    $wp_customize->add_control("deals_title", [
        "label" => __("Deals Title", "macedon-ranges"),
        "section" => "mr_homepage_sections",
        "type" => "text",
        "priority" => 70,
    ]);

    // NEW: Deals Description
    $wp_customize->add_setting("deals_description", [
        "default" => "",
        "sanitize_callback" => "sanitize_textarea_field",
        "transport" => "postMessage",
    ]);

    $wp_customize->add_control("deals_description", [
        "label" => __("Deals Description", "macedon-ranges"),
        "description" => __(
            "Optional description text below the section title",
            "macedon-ranges",
        ),
        "section" => "mr_homepage_sections",
        "type" => "textarea",
        "priority" => 75,
    ]);

    $wp_customize->add_setting("deal_product_id", [
        "default" => "",
        "sanitize_callback" => "absint",
        "transport" => "postMessage",
    ]);

    $wp_customize->add_control("deal_product_id", [
        "label" => __("Deal Product ID", "macedon-ranges"),
        "description" => __(
            "Enter the product ID for the featured deal.",
            "macedon-ranges",
        ),
        "section" => "mr_homepage_sections",
        "type" => "number",
        "priority" => 80,
    ]);

    $wp_customize->add_setting("deal_end_date", [
        "default" => "",
        "sanitize_callback" => "sanitize_text_field",
        "transport" => "postMessage",
    ]);

    $wp_customize->add_control("deal_end_date", [
        "label" => __("Deal End Date", "macedon-ranges"),
        "description" => __("Format: YYYY-MM-DD HH:MM:SS", "macedon-ranges"),
        "section" => "mr_homepage_sections",
        "type" => "text",
        "priority" => 90,
    ]);

    // ===================================
    // TESTIMONIALS
    // ===================================

    $wp_customize->add_setting("show_testimonials", [
        "default" => true,
        "sanitize_callback" => "wp_validate_boolean",
        "transport" => "postMessage",
    ]);

    $wp_customize->add_control("show_testimonials", [
        "label" => __("Show Testimonials Section", "macedon-ranges"),
        "section" => "mr_homepage_sections",
        "type" => "checkbox",
        "priority" => 100,
    ]);

    $wp_customize->add_setting("testimonials_title", [
        "default" => "What Our Customers Say",
        "sanitize_callback" => "sanitize_text_field",
        "transport" => "postMessage",
    ]);

    $wp_customize->add_control("testimonials_title", [
        "label" => __("Testimonials Title", "macedon-ranges"),
        "section" => "mr_homepage_sections",
        "type" => "text",
        "priority" => 110,
    ]);

    // ===================================
    // BLOG PREVIEW
    // ===================================

    $wp_customize->add_setting("show_blog", [
        "default" => true,
        "sanitize_callback" => "wp_validate_boolean",
        "transport" => "postMessage",
    ]);

    $wp_customize->add_control("show_blog", [
        "label" => __("Show Blog Section", "macedon-ranges"),
        "section" => "mr_homepage_sections",
        "type" => "checkbox",
        "priority" => 120,
    ]);

    $wp_customize->add_setting("blog_title", [
        "default" => "Latest from Our Blog",
        "sanitize_callback" => "sanitize_text_field",
        "transport" => "postMessage",
    ]);

    $wp_customize->add_control("blog_title", [
        "label" => __("Blog Title", "macedon-ranges"),
        "section" => "mr_homepage_sections",
        "type" => "text",
        "priority" => 130,
    ]);

    $wp_customize->add_setting("blog_posts_count", [
        "default" => 3,
        "sanitize_callback" => "absint",
        "transport" => "postMessage",
    ]);

    $wp_customize->add_control("blog_posts_count", [
        "label" => __("Number of Blog Posts", "macedon-ranges"),
        "section" => "mr_homepage_sections",
        "type" => "number",
        "input_attrs" => [
            "min" => 1,
            "max" => 6,
            "step" => 1,
        ],
        "priority" => 140,
    ]);

    // ===================================
    // NEWSLETTER
    // ===================================

    $wp_customize->add_setting("show_newsletter", [
        "default" => true,
        "sanitize_callback" => "wp_validate_boolean",
        "transport" => "postMessage",
    ]);

    $wp_customize->add_control("show_newsletter", [
        "label" => __("Show Newsletter Section", "macedon-ranges"),
        "section" => "mr_homepage_sections",
        "type" => "checkbox",
        "priority" => 150,
    ]);

    $wp_customize->add_setting("newsletter_title", [
        "default" => "Stay Updated",
        "sanitize_callback" => "sanitize_text_field",
        "transport" => "postMessage",
    ]);

    $wp_customize->add_control("newsletter_title", [
        "label" => __("Newsletter Title", "macedon-ranges"),
        "section" => "mr_homepage_sections",
        "type" => "text",
        "priority" => 160,
    ]);

    $wp_customize->add_setting("newsletter_description", [
        "default" =>
            "Get exclusive deals and product updates delivered to your inbox.",
        "sanitize_callback" => "sanitize_textarea_field",
        "transport" => "postMessage",
    ]);

    $wp_customize->add_control("newsletter_description", [
        "label" => __("Newsletter Description", "macedon-ranges"),
        "section" => "mr_homepage_sections",
        "type" => "textarea",
        "priority" => 170,
    ]);

    $wp_customize->add_setting("newsletter_gdpr", [
        "default" => true,
        "sanitize_callback" => "wp_validate_boolean",
        "transport" => "postMessage",
    ]);

    $wp_customize->add_control("newsletter_gdpr", [
        "label" => __("Show GDPR Checkbox", "macedon-ranges"),
        "section" => "mr_homepage_sections",
        "type" => "checkbox",
        "priority" => 180,
    ]);

    // Testimonials Section
    $wp_customize->add_setting("testimonials_section_title", [
        "default" => "What Our Customers Say",
        "sanitize_callback" => "sanitize_text_field",
    ]);

    $wp_customize->add_control("testimonials_section_title", [
        "label" => __("Testimonials Section Title", "your-theme"),
        "section" => "homepage_sections",
        "type" => "text",
    ]);

    $wp_customize->add_setting("testimonials_section_subtitle", [
        "default" => 'Don\'t just take our word for it',
        "sanitize_callback" => "sanitize_text_field",
    ]);

    $wp_customize->add_control("testimonials_section_subtitle", [
        "label" => __("Testimonials Section Subtitle", "your-theme"),
        "section" => "homepage_sections",
        "type" => "text",
    ]);
}
add_action("customize_register", "mr_homepage_sections_customizer");
