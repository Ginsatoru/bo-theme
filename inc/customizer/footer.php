<?php
/**
 * Footer Customizer Settings - Simplified
 * Single primary color for entire site
 *
 * @package aaapos-prime
 * @since 1.0.0
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Register Footer Customizer Settings
 */
function aaapos_footer_customizer($wp_customize) {
    
    // ===================================================================
    // FOOTER SECTION
    // ===================================================================
    
    $wp_customize->add_section('aaapos_footer_settings', array(
        'title' => __('Footer Settings', 'aaapos-prime'),
        'priority' => 120,
        'description' => __('Customize your footer appearance and content. Social media links set here will also appear on the Contact page.', 'aaapos-prime'),
    ));
    
    // -------------------------------------------------------------------
    // LAYOUT SETTINGS
    // -------------------------------------------------------------------
    
    // Footer Layout
    $wp_customize->add_setting('footer_layout', array(
        'default' => '4-columns',
        'sanitize_callback' => 'aaapos_sanitize_select',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('footer_layout', array(
        'label' => __('Footer Layout', 'aaapos-prime'),
        'section' => 'aaapos_footer_settings',
        'type' => 'select',
        'priority' => 10,
        'choices' => array(
            '1-column' => __('1 Column', 'aaapos-prime'),
            '2-columns' => __('2 Columns', 'aaapos-prime'),
            '3-columns' => __('3 Columns', 'aaapos-prime'),
            '4-columns' => __('4 Columns (Default)', 'aaapos-prime'),
            '5-columns' => __('5 Columns', 'aaapos-prime'),
        ),
    ));
    
    // Footer Width
    $wp_customize->add_setting('footer_width', array(
        'default' => 'boxed',
        'sanitize_callback' => 'aaapos_sanitize_select',
        'transport' => 'postMessage',
    ));
    
    $wp_customize->add_control('footer_width', array(
        'label' => __('Footer Width', 'aaapos-prime'),
        'section' => 'aaapos_footer_settings',
        'type' => 'select',
        'priority' => 15,
        'choices' => array(
            'boxed' => __('Boxed', 'aaapos-prime'),
            'full-width' => __('Full Width', 'aaapos-prime'),
        ),
    ));
    
    // -------------------------------------------------------------------
    // BRAND COLUMN SETTINGS
    // -------------------------------------------------------------------
    
    // Show Logo in Footer
    $wp_customize->add_setting('footer_show_logo', array(
        'default' => true,
        'sanitize_callback' => 'wp_validate_boolean',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('footer_show_logo', array(
        'label' => __('Show Logo in Footer', 'aaapos-prime'),
        'section' => 'aaapos_footer_settings',
        'type' => 'checkbox',
        'priority' => 20,
    ));
    
    // Footer Logo (Alternative)
    $wp_customize->add_setting('footer_logo', array(
        'default' => '',
        'sanitize_callback' => 'absint',
    ));
    
    $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'footer_logo', array(
        'label' => __('Footer Logo (Optional)', 'aaapos-prime'),
        'description' => __('Upload a different logo for the footer. Leave empty to use the main site logo.', 'aaapos-prime'),
        'section' => 'aaapos_footer_settings',
        'mime_type' => 'image',
        'priority' => 25,
    )));
    
    // Footer Description
    $wp_customize->add_setting('footer_description', array(
        'default' => __('Your trusted source for fresh, locally sourced produce. Supporting local farmers and delivering quality to your doorstep.', 'aaapos-prime'),
        'sanitize_callback' => 'wp_kses_post',
        'transport' => 'postMessage',
    ));
    
    $wp_customize->add_control('footer_description', array(
        'label' => __('Footer Description', 'aaapos-prime'),
        'description' => __('Text that appears below the logo.', 'aaapos-prime'),
        'section' => 'aaapos_footer_settings',
        'type' => 'textarea',
        'priority' => 30,
    ));
    
    // -------------------------------------------------------------------
    // CONTACT INFORMATION
    // -------------------------------------------------------------------
    
    // Section Heading
    $wp_customize->add_setting('footer_contact_heading', array(
        'sanitize_callback' => '__return_false',
    ));
    
    $wp_customize->add_control(new Aaapos_Heading_Control($wp_customize, 'footer_contact_heading', array(
        'label' => __('Contact Information', 'aaapos-prime'),
        'section' => 'aaapos_footer_settings',
        'priority' => 35,
    )));
    
    // Footer Address
    $wp_customize->add_setting('footer_address', array(
        'default' => __('123 Farm Road, Macedon Ranges VIC 3440', 'aaapos-prime'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'postMessage',
    ));
    
    $wp_customize->add_control('footer_address', array(
        'label' => __('Address', 'aaapos-prime'),
        'section' => 'aaapos_footer_settings',
        'type' => 'text',
        'priority' => 40,
    ));
    
    // Footer Phone
    $wp_customize->add_setting('footer_phone', array(
        'default' => '03 5427 3552',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'postMessage',
    ));
    
    $wp_customize->add_control('footer_phone', array(
        'label' => __('Phone Number', 'aaapos-prime'),
        'section' => 'aaapos_footer_settings',
        'type' => 'text',
        'priority' => 45,
    ));
    
    // Footer Email
    $wp_customize->add_setting('footer_email', array(
        'default' => 'sales@macedonrangesproducestore.com.au',
        'sanitize_callback' => 'sanitize_email',
        'transport' => 'postMessage',
    ));
    
    $wp_customize->add_control('footer_email', array(
        'label' => __('Email Address', 'aaapos-prime'),
        'section' => 'aaapos_footer_settings',
        'type' => 'email',
        'priority' => 50,
    ));
    
    // -------------------------------------------------------------------
    // SOCIAL MEDIA LINKS
    // -------------------------------------------------------------------
    
    // Section Heading
    $wp_customize->add_setting('footer_social_heading', array(
        'sanitize_callback' => '__return_false',
    ));
    
    $wp_customize->add_control(new Aaapos_Heading_Control($wp_customize, 'footer_social_heading', array(
        'label' => __('Social Media Links', 'aaapos-prime'),
        'description' => __('These links will appear in both the footer and on the Contact page.', 'aaapos-prime'),
        'section' => 'aaapos_footer_settings',
        'priority' => 55,
    )));
    
    // Show Social Links
    $wp_customize->add_setting('footer_show_social', array(
        'default' => true,
        'sanitize_callback' => 'wp_validate_boolean',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('footer_show_social', array(
        'label' => __('Show Social Media Icons', 'aaapos-prime'),
        'section' => 'aaapos_footer_settings',
        'type' => 'checkbox',
        'priority' => 60,
    ));
    
    // Social Media Platforms with default URLs
    $social_platforms = array(
        'facebook' => array(
            'label' => __('Facebook', 'aaapos-prime'),
            'default' => 'https://www.facebook.com/aaapos.retailmanager'
        ),
        'twitter' => array(
            'label' => __('Twitter/X', 'aaapos-prime'),
            'default' => 'https://x.com/'
        ),
        'instagram' => array(
            'label' => __('Instagram', 'aaapos-prime'),
            'default' => ''
        ),
        'youtube' => array(
            'label' => __('YouTube', 'aaapos-prime'),
            'default' => 'https://www.youtube.com/@aaapos'
        ),
        'linkedin' => array(
            'label' => __('LinkedIn', 'aaapos-prime'),
            'default' => ''
        ),
        'pinterest' => array(
            'label' => __('Pinterest', 'aaapos-prime'),
            'default' => ''
        ),
        'tiktok' => array(
            'label' => __('TikTok', 'aaapos-prime'),
            'default' => ''
        ),
        'whatsapp' => array(
            'label' => __('WhatsApp', 'aaapos-prime'),
            'default' => ''
        ),
    );
    
    $priority = 65;
    foreach ($social_platforms as $platform => $data) {
        $wp_customize->add_setting('footer_social_' . $platform, array(
            'default' => $data['default'],
            'sanitize_callback' => 'esc_url_raw',
            'transport' => 'postMessage',
        ));
        
        $wp_customize->add_control('footer_social_' . $platform, array(
            'label' => $data['label'] . ' ' . __('URL', 'aaapos-prime'),
            'section' => 'aaapos_footer_settings',
            'type' => 'url',
            'priority' => $priority,
        ));
        
        $priority += 5;
    }
    
    // Social Icon Style
    $wp_customize->add_setting('social_icon_style', array(
        'default' => 'rounded',
        'sanitize_callback' => 'aaapos_sanitize_select',
        'transport' => 'postMessage',
    ));
    
    $wp_customize->add_control('social_icon_style', array(
        'label' => __('Social Icon Style', 'aaapos-prime'),
        'section' => 'aaapos_footer_settings',
        'type' => 'select',
        'priority' => 130,
        'choices' => array(
            'circle' => __('Circle', 'aaapos-prime'),
            'rounded' => __('Rounded Square', 'aaapos-prime'),
            'square' => __('Square', 'aaapos-prime'),
            'minimal' => __('Minimal (No Background)', 'aaapos-prime'),
        ),
    ));
    
    // -------------------------------------------------------------------
    // COPYRIGHT SETTINGS
    // -------------------------------------------------------------------
    
    // Section Heading
    $wp_customize->add_setting('footer_copyright_heading', array(
        'sanitize_callback' => '__return_false',
    ));
    
    $wp_customize->add_control(new Aaapos_Heading_Control($wp_customize, 'footer_copyright_heading', array(
        'label' => __('Copyright & Bottom Bar', 'aaapos-prime'),
        'section' => 'aaapos_footer_settings',
        'priority' => 135,
    )));
    
    // Copyright Text
    $wp_customize->add_setting('footer_copyright_text', array(
        'default' => sprintf(__('© %s {sitename}. All rights reserved.', 'aaapos-prime'), '{year}'),
        'sanitize_callback' => 'wp_kses_post',
        'transport' => 'postMessage',
    ));
    
    $wp_customize->add_control('footer_copyright_text', array(
        'label' => __('Copyright Text', 'aaapos-prime'),
        'description' => __('Use {year} for current year and {sitename} for site name.', 'aaapos-prime'),
        'section' => 'aaapos_footer_settings',
        'type' => 'textarea',
        'priority' => 140,
    ));
    
    // Show Footer Menu
    $wp_customize->add_setting('footer_show_menu', array(
        'default' => true,
        'sanitize_callback' => 'wp_validate_boolean',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('footer_show_menu', array(
        'label' => __('Show Footer Bottom Menu', 'aaapos-prime'),
        'description' => __('Privacy Policy, Terms, etc.', 'aaapos-prime'),
        'section' => 'aaapos_footer_settings',
        'type' => 'checkbox',
        'priority' => 145,
    ));
    
    // -------------------------------------------------------------------
    // BACK TO TOP BUTTON
    // -------------------------------------------------------------------
    
    // Section Heading
    $wp_customize->add_setting('footer_back_to_top_heading', array(
        'sanitize_callback' => '__return_false',
    ));
    
    $wp_customize->add_control(new Aaapos_Heading_Control($wp_customize, 'footer_back_to_top_heading', array(
        'label' => __('Back to Top Button', 'aaapos-prime'),
        'section' => 'aaapos_footer_settings',
        'priority' => 150,
    )));
    
    // Show Back to Top
    $wp_customize->add_setting('footer_show_back_to_top', array(
        'default' => true,
        'sanitize_callback' => 'wp_validate_boolean',
        'transport' => 'refresh',
    ));
    
    $wp_customize->add_control('footer_show_back_to_top', array(
        'label' => __('Show Back to Top Button', 'aaapos-prime'),
        'section' => 'aaapos_footer_settings',
        'type' => 'checkbox',
        'priority' => 155,
    ));
    
    // Back to Top Position
    $wp_customize->add_setting('footer_back_to_top_position', array(
        'default' => 'right',
        'sanitize_callback' => 'aaapos_sanitize_select',
        'transport' => 'postMessage',
    ));
    
    $wp_customize->add_control('footer_back_to_top_position', array(
        'label' => __('Button Position', 'aaapos-prime'),
        'section' => 'aaapos_footer_settings',
        'type' => 'select',
        'priority' => 160,
        'choices' => array(
            'left' => __('Bottom Left', 'aaapos-prime'),
            'right' => __('Bottom Right', 'aaapos-prime'),
        ),
    ));
}
add_action('customize_register', 'aaapos_footer_customizer');

/**
 * Sanitize Select Fields
 */
function aaapos_sanitize_select($input, $setting) {
    $input = sanitize_key($input);
    $choices = $setting->manager->get_control($setting->id)->choices;
    return (array_key_exists($input, $choices) ? $input : $setting->default);
}

/**
 * Custom Heading Control
 */
if (class_exists('WP_Customize_Control')) {
    class Aaapos_Heading_Control extends WP_Customize_Control {
        public $type = 'heading';
        public $description = '';
        
        public function render_content() {
            ?>
            <label>
                <span class="customize-control-title" style="font-size: 14px; font-weight: 600; color: #0073aa; border-bottom: 2px solid #0073aa; padding-bottom: 5px; display: block; margin-top: 20px;">
                    <?php echo esc_html($this->label); ?>
                </span>
                <?php if (!empty($this->description)) : ?>
                    <span class="description customize-control-description" style="display: block; margin-top: 8px; font-style: italic; color: #666;">
                        <?php echo esc_html($this->description); ?>
                    </span>
                <?php endif; ?>
            </label>
            <?php
        }
    }
}