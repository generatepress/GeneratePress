<?php
/**
 * The template used for displaying content in the Link post format.
 */

defined( 'WPINC' ) or die;
?>

<article <?php generate_do_attr( 'post' ); ?>>
	<div class="inside-article">
		<?php do_action( 'generate_before_content' ); ?>
		<header class="entry-header">
			<?php do_action( 'generate_before_entry_title' ); ?>
			<?php the_title( sprintf( '<h2 class="entry-title" itemprop="headline"><a href="%s" rel="bookmark">', esc_url( generate_get_url_in_content() ) ), '</a></h2>' ); ?>
			<?php do_action( 'generate_after_entry_title' ); ?>
		</header><!-- .entry-header -->
		<?php do_action( 'generate_after_entry_header' ); ?>

		<?php if ( generate_show_post_excerpt() ) : ?>
			<div class="entry-summary" itemprop="text">
				<?php the_excerpt(); ?>
			</div><!-- .entry-summary -->
		<?php else : ?>
			<div class="entry-content" itemprop="text">
				<?php the_content(); ?>
				<?php
				wp_link_pages( array(
					'before' => '<div class="page-links">' . __( 'Pages:', 'generatepress' ),
					'after'  => '</div>',
				) );
				?>
			</div><!-- .entry-content -->
		<?php endif; ?>

		<?php do_action( 'generate_after_entry_content' ); ?>
		<?php do_action( 'generate_after_content' ); ?>
	</div><!-- .inside-article -->
</article><!-- #post-## -->