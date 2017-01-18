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
			$current_column_index = 0;
			
			// an array of integers representing how many columns there are, grouped
			// i.e. a panel-page indicates the start of a new group
			// example:
			// panel-page
			//     - column-page
			//     - column-page
			//     - panel-page
			//     - column-page
			//     - column-page
			//     - column-page
			// The above structure should result in [2,3]
			$column_group_counts = []; 

			if ( $child_pages->have_posts() ) :
				$column_count = 0;
				while ( $child_pages->have_posts() ) : $child_pages->the_post();
					$page_template_slug = get_page_template_slug();
					if ($page_template_slug == 'column-page.php') {
						$column_count += 1;
					} elseif ($column_count > 0) {
						array_push($column_group_counts, $column_count);
						$column_count = 0;
					}
				endwhile; // End of the loop.

				if ($column_count != 0) {
					array_push($column_group_counts, $column_count);
				}

			endif;

			// stores which column group we are currently using
			$current_column_group = -1;
			// store if previous page was panel-page; only then should we move on to the next column group
			// start with true, because column page should be child of panel page
			$previous_page_was_panel_page = TRUE;

			if ( $child_pages->have_posts() ) :

				$column_spread = 2; // default to having 2 columns

				while ( $child_pages->have_posts() ) : $child_pages->the_post();

					// panel pages can have column pages as children
					$page_template_slug = get_page_template_slug();
					$page_type = 'panel-page';

					if ($page_template_slug == 'column-page.php') {
						if ($previous_page_was_panel_page) {
							$current_column_group += 1;
							$previous_page_was_panel_page = FALSE;
						}

						if ($current_column_index == 0) {
							if ($column_group_counts[$current_column_group] % 3 == 0) {
								$column_spread = 3;
							}

							// Start the outer div
							echo "<div class='column-main hentry-wrapper column-main-" . $column_spread . "'>";
						}

						$current_column_index += 1;
						$page_type = 'column-page';
					} else {
						$previous_page_was_panel_page = TRUE;
					}

					get_template_part( 'template-parts/content', $page_type );


echo "<!-- DEBUG: " . $current_column_index . " " . $page_type . " " . $current_column_group . "-->";

					if ($current_column_index == $column_spread) {
						// close the outer div
						echo "<div style='clear:both;'></div>";
						echo "</div>";

						// reset the column index
						$current_column_index = 0;					
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
