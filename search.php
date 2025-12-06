<?php
/**
 * The template for displaying search results
 */
get_header();
?>

<div class="container">
    <div class="search-results-page">
        <header class="page-header">
            <h1 class="page-title">
                <?php
                printf(
                    /* translators: %s: search query. */
                    esc_html__('Search Results for: %s', 'macedon-ranges'),
                    '<span>' . get_search_query() . '</span>'
                );
                ?>
            </h1>
        </header>

        <div class="search-content">
            <?php if (have_posts()) : ?>
                <div class="search-results-grid">
                    <?php while (have_posts()) : the_post(); ?>
                        <article <?php post_class('search-result'); ?>>
                            <h2 class="entry-title">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h2>
                            
                            <div class="entry-meta">
                                <?php mr_posted_on(); ?>
                            </div>
                            
                            <div class="entry-summary">
                                <?php the_excerpt(); ?>
                            </div>
                            
                            <a href="<?php the_permalink(); ?>" class="read-more">
                                <?php esc_html_e('Read More', 'macedon-ranges'); ?>
                            </a>
                        </article>
                    <?php endwhile; ?>
                </div>

                <?php mr_the_posts_navigation(); ?>

            <?php else : ?>
                <div class="no-results">
                    <p><?php esc_html_e('Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'macedon-ranges'); ?></p>
                    
                    <div class="search-form-container">
                        <?php get_search_form(); ?>
                    </div>
                    
                    <div class="suggestions">
                        <h3><?php esc_html_e('You might be interested in:', 'macedon-ranges'); ?></h3>
                        <ul>
                            <li><a href="<?php echo esc_url(get_permalink(wc_get_page_id('shop'))); ?>"><?php esc_html_e('Browse Our Products', 'macedon-ranges'); ?></a></li>
                            <li><a href="<?php echo esc_url(home_url('/blog')); ?>"><?php esc_html_e('Read Our Blog', 'macedon-ranges'); ?></a></li>
                            <li><a href="<?php echo esc_url(home_url('/contact')); ?>"><?php esc_html_e('Contact Us', 'macedon-ranges'); ?></a></li>
                        </ul>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php
get_footer();