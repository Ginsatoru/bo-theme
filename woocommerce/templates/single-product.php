<?php
/**
 * The Template for displaying all single products
 */
if (!defined('ABSPATH')) {
    exit;
}

get_header('shop');
?>

<div class="container">
    <?php
    do_action('woocommerce_before_main_content');
    ?>

    <div class="single-product-content">
        <?php while (have_posts()) : ?>
            <?php the_post(); ?>

            <?php wc_get_template_part('content', 'single-product'); ?>

        <?php endwhile; ?>
    </div>

    <?php
    do_action('woocommerce_after_main_content');
    ?>
</div>

<?php
get_footer('shop');