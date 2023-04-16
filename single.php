<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 */
get_header();
?>
    <main id="site-content" role="main" class="main-content">
        <div class="container">
            <?php if (have_posts()) { ?>
                <?php while (have_posts()) { the_post(); ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                        <header><?php the_title('<h1>', '</h1>'); ?></header>
                        <div><?php the_content(); ?></div>
                    </article>
                <?php } ?>
            <?php } ?>
        </div>
    </main>
<?php
get_footer();
