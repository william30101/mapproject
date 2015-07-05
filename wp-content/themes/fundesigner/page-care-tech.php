<?php
/*
Template Name: page-Tech
*/
get_header();
?>

<?php $args_caretech = array(
	  'tag'		=> 'caretech',

  );
// query
$wp_query_args_caretech = new WP_Query( $args_caretech );
?>

<div class="content">
	<div class="article">
		<?php breadcrumb_init(); ?>
        
                		<?php while ( $wp_query_args_caretech->have_posts() ) : $wp_query_args_caretech->the_post(); ?>
        
			<article class="article-content">
				<h1 class="article-title"><?php the_title(); ?></h1>
				<?php the_content(); ?>
				<div class="clearfix"></div>
			</article>
		<?php endwhile; ?>
	</div>
</div>
<?php get_footer(); ?>