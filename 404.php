<?php
/**
 * The template for displaying 404 pages (not found)
 */
get_header();
?>

<div class="container">
    <div class="error-404 not-found">
        <div class="error-content">
            <h1 class="error-title"><?php esc_html_e('404', 'macedon-ranges'); ?></h1>
            <h2 class="error-subtitle"><?php esc_html_e('Page Not Found', 'macedon-ranges'); ?></h2>
            <p class="error-description">
                <?php esc_html_e('Sorry, the page you are looking for does not exist.', 'macedon-ranges'); ?>
            </p>
            <div class="error-actions">
                <a href="<?php echo esc_url(home_url('/')); ?>" class="btn btn--primary">
                    <?php esc_html_e('Go Back Home', 'macedon-ranges'); ?>
                </a>
                <a href="<?php echo esc_url(get_permalink(wc_get_page_id('shop'))); ?>" class="btn btn--outline">
                    <?php esc_html_e('Continue Shopping', 'macedon-ranges'); ?>
                </a>
            </div>
        </div>
    </div>
</div>

<?php
get_footer();