<?php
/**
 * Template Name: Panel Page Template
 *
 * @package Shoreditch
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<?php
			while ( have_posts() ) : the_post();

			    get_template_part( 'template-parts/content', 'panel-page' );

			endwhile; // End of the loop.
			?>

			<?php
			$child_pages = new WP_Query( array(
				'post_type'      => 'page',
				'orderby'        => 'menu_order',
				'order'          => 'ASC',
				'post_parent'    => $post->ID,
				'posts_per_page' => 999,
				'no_found_rows'  => true,
			) );
			?>

			<?php
			$column_count = 0;

			if ( $child_pages->have_posts() ) :

				while ( $child_pages->have_posts() ) : $child_pages->the_post();

					// panel pages can have column pages as children
					$page_template_slug = get_page_template_slug();
					$page_type = 'panel-page';

					if ($page_template_slug == 'column-page.php') {
						if ($column_count == 0) {
							// Start the outer div
							echo "<div class='column-main'>";
						}

						$column_count += 1;
						$page_type = 'column-page';
					} 

					get_template_part( 'template-parts/content', $page_type );

					if (($column_count > 0 && $page_type != 'column-page') || $column_count == 3) {
						// close the outer div
						echo "</div>";
						echo "<div style='clear:both;'></div>";
					}

				endwhile; // End of the loop.

			endif;
			wp_reset_postdata();
			?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_sidebar( 'footer' );
get_footer();
