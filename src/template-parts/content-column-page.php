<?php
/**
 * Template part for displaying page content in column-page.php.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Shoreditch
 */

?>

<article class="column-page-column" id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<div class="hentry-wrapper">
		<?php if (has_post_thumbnail()) { ?>
		<div class="column-page-column-img" <?php shoreditch_background_image('thumbnail'); ?>></div>
		<?php } ?>
		<header class="entry-header">
			<?php
				the_title( '<h3 class="entry-title">', '</h3>' );
			?>
		</header><!-- .entry-header -->

		<div class="entry-content">
			<?php
			the_content();			
			?>
		</div><!-- .entry-content -->

		<?php
		edit_post_link(
			sprintf(
				/* translators: %s: Name of current post */
				esc_html__( 'Edit %s', 'shoreditch' ),
				the_title( '<span class="screen-reader-text">"', '"</span>', false )
			),
			'<footer class="entry-footer"><span class="edit-link">',
			'</span></footer><!-- .entry-footer -->'
		);
		?>
	</div><!-- .hentry-wrapper -->
</article><!-- #post-## -->
