<?php
/**
 * The template part for displaying results in search pages.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package _s
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
        <?php
        $permalink = get_the_permalink();
        if( 'team' == get_post_type() ) {
            $permalink = sprintf( '%s#section-team', trailingslashit( get_permalink( 168 ) ) );
        }
        ?>
		<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( $permalink ) ), '</a></h2>' ); ?>

		<?php if ( 'post' === get_post_type() ) : ?>
		<div class="entry-meta">
			<?php _s_posted_on(); ?>
		</div><!-- .entry-meta -->
		<?php endif; ?>
	</header><!-- .entry-header -->

	<div class="entry-summary">
	</div><!-- .entry-summary -->
    <footer class="entry-footer">
    <?php
    printf( '<p class="read-more"><a href="%s" class="more">%s</a></p>', get_permalink(), __( 'Read More', '_s' ) ) ;
    ?>
    </footer>
	
</article><!-- #post-## -->
