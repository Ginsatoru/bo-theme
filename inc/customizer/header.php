<?php
/**
 * Header and Topbar customizer settings
 */
function mr_header_customizer($wp_customize)
{
    // Header Section
    $wp_customize->add_section("mr_header", [
        "title" => __("Header & Topbar Settings", "macedon-ranges"),
        "priority" => 30,
    ]);

    // ===================================
    // TOP BAR SETTINGS
    // ===================================

    $wp_customize->add_setting("show_top_bar", [
        "default" => true,
        "sanitize_callback" => "wp_validate_boolean",
        "transport" => "postMessage",
    ]);

    $wp_customize->add_control("show_top_bar", [
        "label" => __("Show Top Bar", "macedon-ranges"),
        "section" => "mr_header",
        "type" => "checkbox",
        "priority" => 10,
    ]);

    $wp_customize->add_setting("topbar_phone", [
        "default" => "+61 3 5420 0000",
        "sanitize_callback" => "sanitize_text_field",
        "transport" => "postMessage",
    ]);

    $wp_customize->add_control("topbar_phone", [
        "label" => __("Top Bar Phone", "macedon-ranges"),
        "section" => "mr_header",
        "type" => "text",
        "priority" => 20,
    ]);

    $wp_customize->add_setting("topbar_email", [
        "default" => "info@macedonrangesproduce.com",
        "sanitize_callback" => "sanitize_email",
        "transport" => "postMessage",
    ]);

    $wp_customize->add_control("topbar_email", [
        "label" => __("Top Bar Email", "macedon-ranges"),
        "section" => "mr_header",
        "type" => "email",
        "priority" => 30,
    ]);

    $wp_customize->add_setting("topbar_promo_text", [
        "default" => "Fresh local produce delivered daily!",
        "sanitize_callback" => "sanitize_text_field",
        "transport" => "postMessage",
    ]);

    $wp_customize->add_control("topbar_promo_text", [
        "label" => __("Top Bar Promo Text", "macedon-ranges"),
        "section" => "mr_header",
        "type" => "text",
        "priority" => 40,
    ]);

    // ===================================
    // HEADER SETTINGS
    // ===================================

    $wp_customize->add_setting("sticky_header", [
        "default" => true,
        "sanitize_callback" => "wp_validate_boolean",
        "transport" => "postMessage",
    ]);

    $wp_customize->add_control("sticky_header", [
        "label" => __("Sticky Header", "macedon-ranges"),
        "section" => "mr_header",
        "type" => "checkbox",
        "priority" => 50,
    ]);

    $wp_customize->add_setting("show_search_bar", [
        "default" => true,
        "sanitize_callback" => "wp_validate_boolean",
        "transport" => "postMessage",
    ]);

    $wp_customize->add_control("show_search_bar", [
        "label" => __("Show Search Bar", "macedon-ranges"),
        "description" => __("Display search bar in header", "macedon-ranges"),
        "section" => "mr_header",
        "type" => "checkbox",
        "priority" => 55,
    ]);

    $wp_customize->add_setting("header_cta_text", [
        "default" => "Get Started",
        "sanitize_callback" => "sanitize_text_field",
        "transport" => "postMessage",
    ]);

    $wp_customize->add_control("header_cta_text", [
        "label" => __("Header CTA Text", "macedon-ranges"),
        "section" => "mr_header",
        "type" => "text",
        "priority" => 60,
    ]);

    $wp_customize->add_setting("header_cta_link", [
        "default" => "#",
        "sanitize_callback" => "esc_url_raw",
        "transport" => "postMessage",
    ]);

    $wp_customize->add_control("header_cta_link", [
        "label" => __("Header CTA Link", "macedon-ranges"),
        "section" => "mr_header",
        "type" => "url",
        "priority" => 70,
    ]);

    // ===================================
    // SOCIAL MEDIA URLS
    // ===================================

    $wp_customize->add_setting("facebook_url", [
        "default" => "",
        "sanitize_callback" => "esc_url_raw",
        "transport" => "postMessage",
    ]);

    $wp_customize->add_control("facebook_url", [
        "label" => __("Facebook URL", "macedon-ranges"),
        "section" => "mr_header",
        "type" => "url",
        "priority" => 80,
    ]);

    $wp_customize->add_setting("instagram_url", [
        "default" => "",
        "sanitize_callback" => "esc_url_raw",
        "transport" => "postMessage",
    ]);

    $wp_customize->add_control("instagram_url", [
        "label" => __("Instagram URL", "macedon-ranges"),
        "section" => "mr_header",
        "type" => "url",
        "priority" => 90,
    ]);

    $wp_customize->add_setting("twitter_url", [
        "default" => "",
        "sanitize_callback" => "esc_url_raw",
        "transport" => "postMessage",
    ]);

    $wp_customize->add_control("twitter_url", [
        "label" => __("Twitter URL", "macedon-ranges"),
        "section" => "mr_header",
        "type" => "url",
        "priority" => 100,
    ]);

    $wp_customize->add_setting("linkedin_url", [
        "default" => "",
        "sanitize_callback" => "esc_url_raw",
        "transport" => "postMessage",
    ]);

    $wp_customize->add_control("linkedin_url", [
        "label" => __("LinkedIn URL", "macedon-ranges"),
        "section" => "mr_header",
        "type" => "url",
        "priority" => 110,
    ]);

    $wp_customize->add_setting("youtube_url", [
        "default" => "",
        "sanitize_callback" => "esc_url_raw",
        "transport" => "postMessage",
    ]);

    $wp_customize->add_control("youtube_url", [
        "label" => __("YouTube URL", "macedon-ranges"),
        "section" => "mr_header",
        "type" => "url",
        "priority" => 120,
    ]);
}
add_action("customize_register", "mr_header_customizer");
