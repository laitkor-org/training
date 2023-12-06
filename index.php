<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme and one
 * of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query,
 * e.g., it puts together the home page when no home.php file exists.
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage goblog
 * @since GoBlog 1.0
 */

global $bpxl_goblog_options;

if ( class_exists( 'ReduxFramework' ) ) {
	$bpxl_layout = $bpxl_goblog_options['bpxl_layout'];
	$bpxl_home_slider = $bpxl_goblog_options['bpxl_home_slider'];
	$bpxl_above_post_ad = $bpxl_goblog_options['bpxl_above_post_ad'];
	$bpxl_home_latest_posts = $bpxl_goblog_options['bpxl_home_latest_posts'];
} else {
	$bpxl_layout = 'cblayout';
	$bpxl_home_slider = '0';
	$bpxl_above_post_ad = '';
	$bpxl_home_latest_posts = '0';
}

get_header(); ?>

<div class="main-content <?php bpxl_layout_class(); ?>">
<?php if ( $bpxl_layout == 'scblayout' ) { ?>
	<div class="sidebar-small">
		<div class="small-sidebar">
			<?php
				if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar('sidebar-2') );
			?>
		</div><!--End .small-sidebar-->
	</div><!--End .sidebar-small-->
<?php } ?>
<div class="content-area home-content-area">
	<div class="content-home">
		<?php if ( $bpxl_home_slider == '1' ) { ?>
            <?php if (!is_paged() ) { ?>
			<div class="featuredslider flexslider loading">
				<ul class="slides">
					<?php
						$slider_cat = '';
						$slider_posts_count = '4';
						if ( ! empty( $bpxl_goblog_options['bpxl_home_slider_cat'] ) ) {
							$slider_cats = $bpxl_goblog_options['bpxl_home_slider_cat'];
							$slider_cat = implode( ',', $slider_cats );
							$slider_posts_count = $bpxl_goblog_options['bpxl_slider_posts_count'];
						}
						$slider_query = new WP_Query("cat=".$slider_cat."&orderby=date&order=DESC&showposts=".$slider_posts_count);
					
						if ( $slider_query->have_posts() ) : while ( $slider_query->have_posts() ) : $slider_query->the_post(); ?>
						<li>
							<a href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>" class="featured-thumbnail featured-widgetslider">
								<?php
									if ( has_post_thumbnail() ) {
										the_post_thumbnail('featured');
									}
								?>
								<div class="post-inner textcenter">
									<header>
										<h2 class="title title22">
											<?php the_title(); ?>
										</h2>
										<div class="slider-meta"><span><?php _e('Written by ','goblog'); ?></span> <?php the_author(); ?></div>
									</header><!--.header-->
								</div>
							</a>
						</li>
						<?php endwhile; ?>
					<?php endif; ?>
				</ul>
			</div>
            <?php } ?>
		<?php } ?>
		<div id="content" class="content <?php bpxl_masonry_class(); ?>">
			<?php if ( $bpxl_above_post_ad != '' ) { ?>
				<div class="single-post-ad">
					<?php echo $bpxl_goblog_options['bpxl_above_post_ad']; ?>
				</div>
			<?php } ?>
            <div class="grid-sizer"></div>
            <div class="gutter-sizer"></div>
			<?php
				if ( get_query_var('paged') ) { $paged = get_query_var('paged'); }
				elseif ( get_query_var('page') ) { $paged = get_query_var('page'); }
				else { $paged = 1; }
				
				if ( $bpxl_home_latest_posts == '1' ) {
                    $recent_cats = ( isset( $bpxl_goblog_options['bpxl_home_latest_cat'] ) ? $bpxl_goblog_options['bpxl_home_latest_cat'] : '' );
                    $recent_cat = ( $recent_cats ? implode(",", $recent_cats) : '' );
                    
					$args = array(
						'cat' => $recent_cat,
						'paged' => $paged
					);
				} else {
					$args = array(
						'post_type' => 'post',
						'paged' => $paged
					);
				}

				// The Query
				query_posts( $args );
			
				if ( have_posts() ) : while ( have_posts() ) : the_post();
				
				get_template_part( 'template-parts/post-formats/content', get_post_format() );
						
				endwhile;
						
				else:
					// If no content, include the "No posts found" template.
					get_template_part( 'template-parts/post-formats/content', 'none' );

				endif;
			?>
		</div><!--content-->
		<?php 
			// Previous/next page navigation.
			bpxl_paging_nav();
		?>
	</div><!--content-page-->
</div><!--content-area-->
<?php
	$bpxl_layout_array = array(
		'clayout',
		'glayout'
	);

	if ( ! in_array( $bpxl_layout, $bpxl_layout_array ) ) {
		get_sidebar();
	}
?>
</div><!--.main-->
<?php get_footer(); ?>